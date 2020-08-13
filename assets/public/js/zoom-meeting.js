"use strict";

jQuery(function ($) {
  var zoom_browser_integration = {
    init: function init() {
      var browseinfo = ZoomMtg.checkSystemRequirements();
      var page_html = '<ul><li><strong>Browser Info:</strong> ' + browseinfo.browserInfo + '</li>';
      page_html += '<li><strong>Browser Name:</strong> ' + browseinfo.browserName + '</li>';
      page_html += '<li><strong>Browser Version:</strong> ' + browseinfo.browserVersion + '</li></ul>'; // page_html += '<li><strong>Available:</strong> ' + browseinfo.features + '</li></ul>';

      $('.vczapi-zoom-browser-meeting--info__browser').html(page_html);
      ZoomMtg.preLoadWasm();
      ZoomMtg.prepareJssdk();
      this.eventHandlers();
    },
    eventHandlers: function eventHandlers() {
      $('#vczapi-zoom-browser-meeting-join-mtg').on('click', this.loadMeeting.bind(this));
    },
    loadMeeting: function loadMeeting(e) {
      e.preventDefault();
      var meeting_id = zvc_ajx.meeting_id;
      var API_KEY = false;
      var SIGNATURE = false;
      var REDIRECTION = zvc_ajx.redirect_page;
      var PASSWD = zvc_ajx.meeting_pwd;
      var EMAIL_USER = '';
      $('body').append('<span id="zvc-cover"></span>');

      if (meeting_id) {
        $.post(zvc_ajx.ajaxurl, {
          action: 'get_auth',
          noncce: zvc_ajx.zvc_security,
          meeting_id: meeting_id
        }).done(function (response) {
          if (response.success) {
            $("#zvc-cover").remove();
            $('#vczapi-zoom-browser-meeting').hide();
            API_KEY = response.data.key;
            SIGNATURE = response.data.sig;

            if (API_KEY && SIGNATURE) {
              var display_name = $('#vczapi-jvb-display-name');
              var email = $('#vczapi-jvb-email');
              var pwd = $('#meeting_password');

              if (!display_name.val()) {
                alert("Name is required to enter the meeting !");
                $("#zvc-cover").remove();
                return false;
              } //Email Validation


              if (email.length > 0 && email.val().length > 0) {
                EMAIL_USER = email.val();
              } //Password Validation


              if (!PASSWD && pwd.length > 0 && pwd.val().length > 0) {
                PASSWD = pwd.val();
              }

              var lang = $('#meeting_lang');
              var meetConfig = {
                apiKey: API_KEY,
                meetingNumber: parseInt(meeting_id, 10),
                userName: display_name.val(),
                passWord: PASSWD,
                lang: lang.length > 0 ? lang.val() : 'en-US',
                leaveUrl: REDIRECTION,
                signaure: SIGNATURE,
                email: EMAIL_USER
              };
              ZoomMtg.init({
                leaveUrl: REDIRECTION,
                isSupportAV: true,
                success: function success() {
                  $.i18n.reload(meetConfig.lang);
                  ZoomMtg.join({
                    meetingNumber: meetConfig.meetingNumber,
                    userName: meetConfig.userName,
                    signature: meetConfig.signaure,
                    apiKey: meetConfig.apiKey,
                    userEmail: meetConfig.email,
                    passWord: meetConfig.passWord,
                    success: function success(res) {
                      console.log('Join Meeting Success');
                    },
                    error: function error(res) {
                      console.log(res);
                    }
                  });
                },
                error: function error(res) {
                  console.log(res);
                }
              });
            } else {
              $("#zvc-cover").remove();
              alert("NOT AUTHORIZED");
            }
          }
        });
      } else {
        $("#zvc-cover").remove();
        alert("Incorrect Meeting ID");
      }
    }
  };
  zoom_browser_integration.init();
});