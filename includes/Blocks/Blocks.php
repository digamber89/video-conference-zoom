<?php


namespace Codemanas\VczApi\Blocks;


class Blocks {
	public static $_instance = null;

	public static function get_instance() {
		return is_null( self::$_instance ) ? self::$_instance = new self() : self::$_instance;
	}

	public function __construct() {

		add_filter( 'block_categories', [ $this, 'register_block_categories' ], 10, 2 );
		add_action( 'init', [ $this, 'register_scripts' ] );
		add_action( 'init', [ $this, 'register_blocks' ] );

		add_action( 'wp_ajax_vczapi_get_zoom_hosts', [ $this, 'get_hosts' ] );
		add_action( 'wp_ajax_vczapi_get_live_meetings', [ $this, 'get_live_meetings' ] );
	}

	public function register_scripts() {
		$script_asset_path = require_once( ZVC_PLUGIN_DIR_PATH . '/build/index.asset.php' );
		$dependencies      = $script_asset_path['dependencies'];
		//Plugin Scripts
		wp_register_style( 'video-conferencing-with-zoom-api-blocks',
			ZVC_PLUGIN_PUBLIC_ASSETS_URL . '/css/style.css',
			false,
			ZVC_PLUGIN_VERSION );
		//print(ZVC_PLUGIN_PUBLIC_ASSETS_URL . '/css/style.css'); die;

		wp_register_style(
			'vczapi-blocks-style',
			plugins_url( '/build/index.css', ZVC_PLUGIN_FILE ),
			[ 'video-conferencing-with-zoom-api-blocks' ],
			$script_asset_path['version']
		);

		wp_register_script(
			'vczapi-blocks',
			plugins_url( '/build/index.js', ZVC_PLUGIN_FILE ),
			$dependencies,
			$script_asset_path['version']
		);

		wp_localize_script( 'vczapi-blocks',
			'vczapi_blocks',
			[
				'list_meetings_preview'            => ZVC_PLUGIN_IMAGES_PATH . '/block-previews/list-meetings-webinars.png',
				'direct_meeting_preview_image'     => ZVC_PLUGIN_IMAGES_PATH . '/block-previews/direct-meeting.jpg',
				'list_host_meetings_preview_image' => ZVC_PLUGIN_IMAGES_PATH . '/block-previews/list-host-meetings.png',
				'embed_post_preview'               => ZVC_PLUGIN_IMAGES_PATH . '/block-previews/embed_post_preview.png',
			]
		);
	}

	public function register_block_categories( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'vczapi-blocks',
					'title' => __( 'Zoom', 'video-conferencing-with-zoom-api' ),
					//'icon'  => 'wordpress',
				),
			)
		);
	}

	public function register_blocks() {

		register_block_type( 'vczapi/list-meetings', [
			"title"           => "List Zoom Meetings",
			"attributes"      => [
				'preview'          => [
					'type'    => 'boolean',
					'default' => false
				],
				"shortcodeType"    => [
					"type"    => "string",
					"default" => "meeting"
				],
				"showPastMeeting"  => [
					"type"    => "boolean",
					"default" => false
				],
				"showFilter"       => [
					"type"    => "string",
					"default" => "yes",
				],
				"postsToShow"      => [
					"type"    => "number",
					"default" => 5
				],
				"orderBy"          => [
					"type"    => "string",
					"default" => ""
				],
				"selectedCategory" => [
					"type"    => "array",
					"default" => []
				],
				"selectedAuthor"   => [
					"type"    => "number",
					"default" => 0
				],
				"displayType"      => [
					"type"    => "string",
					"default" => ""
				],
				"columns"          => [
					"type"    => "number",
					"default" => 3
				]
			],
			"category"        => "vczapi-blocks",
			"icon"            => "list-view ",
			"description"     => "List Upcoming or Past Meetings/Webinars",
			"textdomain"      => "video-conferencing-with-zoom-api",
			'editor_script'   => 'vczapi-blocks',
			'editor_style'    => 'vczapi-blocks-style',
			'render_callback' => [ $this, 'render_list_meetings' ]
		] );

		register_block_type( 'vczapi/list-host-meetings', [
			"title"           => "List Host Zoom Meetings",
			"attributes"      => [
				"host"    => [
					"type" => "object",
				],
				"preview" => [
					"type"    => "boolean",
					"default" => false
				],
			],
			"category"        => "vczapi-blocks",
			"icon"            => "list-view",
			"description"     => "Show a Meeting Post with Countdown",
			"textdomain"      => "video-conferencing-with-zoom-api",
			'editor_script'   => 'vczapi-blocks',
			'editor_style'    => 'vczapi-blocks-style',
			'render_callback' => [ $this, 'render_host_meeting_list' ]
		] );

		register_block_type( 'vczapi/show-meeting-post', [
			"title"           => "Embed Zoom Post",
			"attributes"      => [
				"preview" => [
					"type"    => "boolean",
					"default" => false
				],
				"postID"  => [
					"type"    => "number",
					"default" => 0
				]
			],
			"category"        => "vczapi-blocks",
			"icon"            => "sticky",
			"description"     => "Show a Meeting Post with Countdown",
			"textdomain"      => "video-conferencing-with-zoom-api",
			'editor_script'   => 'vczapi-blocks',
			'editor_style'    => 'vczapi-blocks-style',
			'render_callback' => [ $this, 'render_meeting_post' ]
		] );

		register_block_type( 'vczapi/show-live-meeting', [
			"title"           => "Direct Meeting or Webinar",
			"attributes"      => [
				"preview"         => [
					"type"    => "boolean",
					"default" => false
				],
				"shouldShow"      => [
					"type"    => "object",
					"default" => [
						"label" => "Meeting",
						"value" => "meeting"
					]
				],
				"host"            => [
					"type" => "object",
				],
				"selectedMeeting" => [
					"type" => "object",
				],
				"link_only"       => [
					"type"    => "string",
					"default" => "no"
				]
			],
			"category"        => "vczapi-blocks",
			"icon"            => "sticky",
			"description"     => "Show a Meeting/Webinar details - direct from Zoom",
			"textdomain"      => "video-conferencing-with-zoom-api",
			'editor_script'   => 'vczapi-blocks',
			'editor_style'    => 'vczapi-blocks-style',
			'render_callback' => [ $this, 'render_live_meeting' ]
		] );


	}

	public function get_hosts() {
		$host_name = filter_input( INPUT_GET, 'host' );
		$users     = video_conferencing_zoom_api_get_user_transients();

		$hosts = [];
		if ( ! empty( $users ) ) {
			foreach ( $users as $user ) {
				$first_name = ! empty( $user->first_name ) ? $user->first_name . ' ' : '';
				$last_name  = ! empty( $user->last_name ) ? $user->last_name . ' ' : '';
				$username   = $first_name . $last_name . '(' . $user->email . ')';


				if ( ! empty( $host_name ) ) {
					preg_match( "/($host_name)/", $username, $matches );
					if ( ! empty( $matches ) ) {
						$hosts[] = [ 'label' => $username, 'value' => $user->id ];
					}
				} else {
					$hosts[] = [ 'label' => $username, 'value' => $user->id ];
				}
			}
		}
		wp_send_json( $hosts );
	}

	public function get_live_meetings() {
		$host_id                 = filter_input( INPUT_GET, 'host_id' );
		$show_meeting_or_webinar = filter_input( INPUT_GET, 'show' );
		$args                    = [
			'page_size' => 300,
		];
		$page_number             = filter_input( INPUT_GET, 'page_number' );
		if ( ! empty( $page_number ) ) {
			$args['page_number'] = $page_number;
		}

		if ( empty( $host_id ) ) {
			wp_send_json( [] );
		}

		$encoded_meetings_webinar  = ( $show_meeting_or_webinar == 'webinar' ) ? zoom_conference()->listWebinar( $host_id, $args ) : zoom_conference()->listMeetings( $host_id, $args );
		$decoded_meetings_webinars = json_decode( $encoded_meetings_webinar );
		if ( $show_meeting_or_webinar == 'webinar' ) {
			$meetings_or_webinars = ! empty( $decoded_meetings_webinars->webinars ) ? $decoded_meetings_webinars->webinars : [];
		} else {
			$meetings_or_webinars = ! empty( $decoded_meetings_webinars->meetings ) ? $decoded_meetings_webinars->meetings : [];
		}

		$data               = [];
		$formatted_meetings = [];
		if ( ! empty( $meetings_or_webinars ) ) {
			$data = [
				'page_size'     => isset( $decoded_meetings_webinars->page_size ) ? $decoded_meetings_webinars->page_size : '',
				'total_records' => isset( $decoded_meetings_webinars->total_records ) ? $decoded_meetings_webinars->total_records : ''
			];
			foreach ( $meetings_or_webinars as $meeting_or_webinar ) {
				$formatted_meetings[] = [
					'label' => $meeting_or_webinar->topic,
					'value' => $meeting_or_webinar->id
				];
			}
			$data['formatted_meetings'] = $formatted_meetings;
		}
		wp_send_json( $data );
	}

	public function render_list_meetings( $attributes ) {


		$shortcode = isset( $attributes['shortcodeType'] ) && ( $attributes['shortcodeType'] == 'webinar' ) ? 'zoom_list_webinars' : 'zoom_list_meetings';


		if ( isset( $attributes['postsToShow'] ) && ! empty( $attributes['postsToShow'] ) ) {
			$shortcode .= ' per_page="' . $attributes['postsToShow'] . '"';
		}

		if ( isset( $attributes['orderBy'] ) && ! empty( $attributes['orderBy'] ) ) {
			$shortcode .= ' order="' . $attributes['orderBy'] . '"';
		}

		if ( isset( $attributes['showFilter'] ) && ! empty( $attributes['showFilter'] ) ) {
			$shortcode .= ' filter="' . $attributes['showFilter'] . '"';
		}

		if ( isset( $attributes['selectedCategory'] ) && is_array( $attributes['selectedCategory'] ) && ! empty( $attributes['selectedCategory'] ) ) {
			$categories_string = '';
			$category_count    = count( $attributes['selectedCategory'] );
			$separator         = ( $category_count > 1 ) ? ',' : '';
			foreach ( $attributes['selectedCategory'] as $index => $category ) {
				if ( $category['value'] == '' ) {
					continue;
				}
				$separator         = ( $index + 1 ) ? $separator : '';
				$categories_string .= $category['value'] . $separator;
			}
			unset( $separator );

			if ( ! empty( $categories_string ) ) {
				$shortcode .= ' category="' . $categories_string . '"';
			}
		}

		if ( isset( $attributes['selectedAuthor'] ) && ! empty( $attributes['selectedAuthor'] ) ) {
			$shortcode .= ' author="' . $attributes['selectedAuthor'] . '"';
		}

		if ( isset( $attributes['displayType'] ) && ! empty( $attributes['displayType'] ) ) {
			$shortcode .= ' type="' . $attributes['displayType'] . '"';
		}

		if ( isset( $attributes['columns'] ) && ! empty( $attributes['columns'] ) ) {
			$shortcode .= ' cols="' . $attributes['columns'] . '"';
		}

		return do_shortcode( '[' . $shortcode . ']' );
	}

	public function render_meeting_post( $attributes ) {
		$shortcode = 'zoom_meeting_post';
		if ( isset( $attributes['postID'] ) && ! empty( $attributes['postID'] ) ) {
			$shortcode .= ' post_id="' . $attributes['postID'] . '"';
		}

		ob_start();
		echo do_shortcode( '[' . $shortcode . ']' );

		return ob_get_clean();
	}

	public function render_live_meeting( $attributes ) {
		ob_start();
		$shortcode = ( $attributes['shouldShow']['value'] == 'webinar' ) ? 'zoom_api_webinar' : 'zoom_api_link';
		
		
		if ( isset( $attributes['selectedMeeting'] ) && ! empty( 'selectedMeeting' ) ) {
			$shortcode .= ( $attributes['shouldShow']['value'] == 'webinar' ) ?
				' webinar_id="' . $attributes['selectedMeeting']['value'] . '"':
				' meeting_id="' . $attributes['selectedMeeting']['value'] . '"';
		}
		if ( isset( $attributes['link_only'] ) && ! empty( 'link_only' ) ) {
			$shortcode .= ' link_only="' . $attributes['link_only'] . '"';
		}
		echo do_shortcode( '[' . $shortcode . ']' );

		return ob_get_clean();
	}

	public function render_host_meeting_list( $attributes ) {
		ob_start();
		echo do_shortcode( '[zoom_list_host_meetings host="' . $attributes['host']['value'] . '"]' );

		return ob_get_clean();
	}
}

Blocks::get_instance();