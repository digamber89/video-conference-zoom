=== Video Conferencing with Zoom API ===
Contributors: j__3rk, digamberpradhan
Tags: zoom video conference, video conference, zoom, zoom video conferencing, web conferencing, online meetings
Donate link: https://deepenbajracharya.com.np/donate
Requires at least: 4.9
Tested up to: 5.3
Stable tag: 2.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Gives you the power to manage Zoom Meetings, check reports and create users from your WordPress dashboard.

== Description ==

**NOTE: Upgrading to version 3.0.0 ? Huge changes from 3.0.0. Please refer to [changelog tab](https://wordpress.org/plugins/video-conferencing-with-zoom-api/#developers "changelog tab"). **

A simple plugin which gives you the extensive functionality to manage zoom meetings, users, reports from your WordPress Dashboard. Now, with capabitly to add your own post as a meeting. Create posts as meetings directly from your WordPress dashboard to show in the frontend as a meeting page. Allow users to directly join via that page with click of a button.

**REFER FAQ to override page templates !**

**FEATURES:**

* Manage WordPress posts and link them to Live Zoom meetings ( NEW from 3.0.0 )
* Override single and archive page templates via your theme. ( NEW from 3.0.0 )
* Join links directly from frontend. ( NEW from 3.0.0 )
* Start Links for post authors. ( NEW from 3.0.0 )
* Allow posts to be only shown to logged in users. ( NEW from 3.0.0 )
* Manage Live Zoom Meetings.
* Listing Users.
* Developer Friendly
* Daily and Account Reports
* Shortcode Available as well

**COMPATIBILITY**

* Enables direct integration of Zoom into WordPress.
* Compatible with LearnPress, LearnDash 3.
* Enables most of the settings from zoom via admin panel.
* Fully Compatible with Zoom API.
* Provides Shortcode to conduct the meeting via any WordPress page/post or custom post type pages
* Separate Admin area to manage all meetings.
* Can add meeting links via shortcode to your WooCommerce product pages as well.

**LIMITATIONS**

* Webinar module not integrated

**SHORTCODE**

From version 3.0.0 - Shortcode has been changed to fit different need:

* [zoom_api_link meeting_id="123456789"] - Just enter your meeting ID and you are good to show your meeting in any page.

**Find a Short Documentation or Guide on how to setup: [Here](https://deepenbajracharya.com.np/zoom-conference-wp-plugin-documentation/ "Documentation")**

Any additional features, suggestions related to translations, contact me via [email](https://deepenbajracharya.com.np/say-hello/ "Deepen Bajracharya").

== Installation ==
Search for the plugin -> add new dialog and click install, or download and extract the plugin, and copy the the Zoom plugin folder into your wp-content/plugins directory and activate.

== Frequently Asked Questions ==
= How to show Zoom Meetings on Front =

* By using shortcode like [zoom_api_link meeting_id="123456789"] you can show the link of your meeting in front.

= How to override plugin template to your theme =

* Copy from wp-content/plugins/video-conferencing-with-zoom-api/templates to your yourtheme/video-conferencing-zoom/name-of-the-tempalate-file.php

== Screenshots ==
1. Meetings Listings. Select a User in order to list meetings for that user.
2. Add a Meeting.
3. Frontend Display Page.
4. Users List Screen. Flush cache to clear the cache of users.
5. Reports Section.
6. Settings Page.
7. Backend Meeting Create via CPT

== Changelog ==

= 3.0.0 =
Added: Custom post type meetings for seperate post meetings.
Added: Page template overrides.
Added: Frontend meeting join links, start links for authors.
Removed: Seperate vanity URL removed.
Fixed: Bug Fixes on creating meetings, Warnings and Notice errors.

= 2.2.3 =
Fixed: API access token time increased by 1 hour

= 2.2.3 =
Added: Validation issue fixed
Fixed: Added vanity URL functionality in settings
Fixed: Minor users API bug fixes

= 2.2.2 =
Added: UI changes
Fixed: Validation Issues fixed
Fixed: Minor bug fixes

= 2.2.1 =
Fixed: CURL Request fail fixed

= 2.2.0 =
* Removed: API version 1 support. Added to deprecated library.
* Added: New options when adding meetings
* Added: Classic editor meeting link add icon
* Fix: Changed API call implementation to fit WordPress standards
* Fix: Major bug fixes

= 2.1.3 =
* Minor Changes

= 2.1.2 =
* Minor Changes
* Timezone Settings Changes

= 2.1.1 =
* Minor Changes

= 2.1.0 =
* API version 2 added.
* Major fixes
* Major breaking changes in this version.
* Added: Assign Host ID manually section for Developers

= 2.0.5 =
* Minor Changes

= 2.0.4 =
* Minor Change

= 2.0.3 =
* WordPress 4.8 Compatible

= 2.0.1 =
* Added: Translation Error Fixed
* Added: French Translation
* Added: 3 new hooks see under "Using Action Hook" in description page.

= 2.0.0 =
* Added: Datatables in order to view all listings
* Added: New shortcode button in tinymce section
* Added: Bulk delete
* Added: Redesigned Zoom Meetings section where meetings can be viewed based on users.
* Added: Redesigned add meetings section with alot of bug fixes and attractive UI.
* Changed: Easy datepicker
* Changed: Removed editing of users capability. Maybe in future again ?
* Removed: Single link shortcode ( [zoom_api_video_uri] )
* Bug Fix: Reports section causing to define error when viewing available reports
* Bug Fix: Error on reload after creating a meeting
* Bug Fix: Unknown error when trying to connect with api keys ( Rare Case )
* Changed: Total codebase of the plugin.
* Fixed: Few security issues such as no nonce validations.
* Alot of Major Bug Fixes but no breaking change except for a removed shortcode

= 1.3.1 =
* Minor Bug Fixes

= 1.3.0 =
* Added Pagination to meetings list
* Hidden API token fields
* Fixed various bugs and flaws

= 1.2.4 =
* WordPress 4.6 Compatible

= 1.2.3 =
* Validation Errors Added
* Minor Bug Fixes

= 1.2.2 =
* Minor Functions Change

= 1.2.1 =
* Bug Fixes
* Major Bug fix on problem when adding users
* Removed only system users on users adding section
* Added a shortcode which will print out zoom video link. [zoom_api_video_uri]

= 1.2.0 =
* Various Bug Fixes
* Validation Errors Fixed
* Translation Ready

= 1.1.1 =
* Increased Add Meeting Refresh time interval to 5 seconds.

= 1.1 =
* Added Reports
* Minor Bug fixes and Changes

= 1.0.2 =
* Minor Changes

= 1.0.1 =
* Minor UI Changes
* Removed the unecessary dropdown in Meeting Type since only Scheduled Meetings are allowed to be created.
* Added CSS Editor in Settings Page
* Alot of Minor Bug Fixes

= 1.0.0 =
* Initial Release

== Upgrade Notice ==

= 2.2.0 =
This is a major release. Please check you if you have any customization related to this plugin before upgrading.

= 2.1.0 =
This is a major release. Please check you if you have any customization related to this plugin before upgrading.

= 2.0.0 =
This is a major release. Kindly request to upgrade for better performance and lots of bug fixes.

= 1.2.3 =
Validation Errors Added

= 1.2.0 =
Crucial Security Patches