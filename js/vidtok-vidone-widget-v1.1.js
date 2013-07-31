	jQuery(document).ready(function (e) {
		var vid = jQuery.url().param('vid');
		if (vid == 'undefined' || vid == null) {
			vid = '' 
		}
		if(VIDONE_REGISTERED === 'yes'){
		jQuery('body').append('<div class="vidone-widget-w"> <div class="vidone-widget-invite-email"> <div id="vidone-invalid-email">Oops! Not a valid email</div> <p>Invite friend to join video chat</p> <input type="text" name="email" id="email" value="" /> <input type="button" name="vidone-invite-submit" id="vidone-invite-submit" value="Send Invite" class="invite btn btn-info" /> </div> <div class="vidone-widget-video-w"> <div class="vidone-widget-video-h" id="pub"> <div id="vidone-pub"><img src="' + VIDONE_PLUGIN_URL + 'img/large-loader-cyan.gif" alt="loading" /><p>Loading Video Connection...</p></div> </div> <div class="vidone-widget-video-h" id="sub"> <div id="vidone-sub"><p>Your guest will appear here...</p></div> </div> <div class="vidone-widget-access"> <div class="vidone-widget-start"> <p>Want to start a new video chat?</p> <input type="button" class="start btn btn-info" id="create-button" value="Create Video Chat" /> </div> <div class="vidone-widget-join"> <div id="vidone-invalid">Oops! Wrong code, try again</div> <p>Join an existing video chat</p> <input type="text" name="vid" id="vid" value="' + vid + '" /> <input type="button" name="vidone-join-submit" id="vidone-join-submit" value="Join Existing Video Chat" class="join btn btn-info" /> </div> </div> </div> <div class="vidone-widget-chat-bubble" id="bubble"><img src="' + VIDONE_PLUGIN_URL + 'img/video-chat-bubble.png" alt="vidtok vid {one} chat bubble"/></div> <div class="vidone-widget-action-bar"> <div id="vidone-widget-default-view"> <div class="vidone-start-msg vidone-widget-default-msg-size"> <div class="vidone-widget-action-bar-arrow" id="up-arrow"> <img src="' + VIDONE_PLUGIN_URL + 'img/up-arrow.png" alt="vidtok vid {one} start" /> </div> <p>Start a <strong>"LIVE"</strong> video chat!</p> </div> </div> <div class="vidone-widget-chat-view"> <div class="vidone-widget-invite"> <p>Send Invite via</p> <a rel="invite-email" style="border:none; text-decoration:none;" href="#"><img src="' + VIDONE_PLUGIN_URL + 'img/envolope.png" alt="" /></a> <a rel="nofollow" style="border:none; text-decoration:none;" href="#" onclick="return fbs_click()" target="_blank"><img src="' + VIDONE_PLUGIN_URL + 'img/facebook.png" alt="" /></a> <a rel="nofollow" style="border:none; text-decoration:none;" href="#" onclick="return tw_click()" target="_blank"><img src="' + VIDONE_PLUGIN_URL + 'img/twitter.png" alt="" /></a> </div> <div class="vidone-widget-get-vidone"> <p><a href="http://wordpress.org/plugins/vidtok-vidone-video-chat-using-tokboxs-opentok-api/" target="_blank">Download vid{one}</a> for Wordpress</p> </div> <div class="vidone-end-msg vidone-widget-default-msg-size" style="width:226px; border-left:1px #e4e4e4 solid; "> <div class="vidone-widget-action-bar-arrow" id="end-arrow"><img src="' + VIDONE_PLUGIN_URL + 'img/down-arrow.png" alt="vidtok vid {one} end"/></div> <p>End your video chat</p> </div> </div> </div> </div>'); }
		start = 0;
		clicked = 0;
		invite = 0;
		jQuery('.vidone-start-msg').show();
		jQuery('#vid').watermark('Enter Invitation Code');
		jQuery('#email').watermark('Enter Email Address');
		setTimeout(function () {
			jQuery('.vidone-widget-w').animate({
				right: '20px'
			})
		}, 750);
		if (jQuery.url().param('vid') && (VIDONE_REGISTERED === 'yes')) {
			setTimeout(function () {
				jQuery('#vidone-invalid').hide();
				jQuery('#vidone-widget-default-view').empty();
				jQuery('#vidone-widget-default-view').append('<div class="vidone-close-msg vidone-widget-default-msg-size"> <div class="vidone-widget-action-bar-arrow" id="down-arrow"> <img src="' + VIDONE_PLUGIN_URL + 'img/down-arrow.png" alt="vidtok vid {one} close" /> </div> <p>Close video start window</p> </div>');
				jQuery('.vidone-close-msg').fadeIn('slow');
				jQuery('.vidone-widget-chat-bubble').animate({
					bottom: '-200px'
				}, 375, function () {
					jQuery('.vidone-widget-access').animate({
						bottom: '390px'
					});
					clicked = 0
				});
				jQuery.ajax({
					url: vidoneAjax.ajaxurl,
					type: 'POST',
					data: {
						action: 'join_session',
						vid: vid
					},
					dataType: "json",
					success: function (data) {
						if (data.status === 'non-existing') {
							jQuery('#vidone-invalid').fadeIn()
						}
						if (data.status === 'exists') {
							jQuery.ajax({
								url: 'http://vidtok.co/vidone/usage',
								type:'POST',
								data: {
									vapi: VAPI,
									domain : DOMAIN,
									type: 'join'	
								}
							});
							jQuery('.vidone-widget-invite').hide();
							jQuery('.vidone-widget-get-vidone').show(); 
							jQuery('#vidone-invalid').hide();
							vidone();
							VID = data.vid;
							TOKBOX_SESSION_ID = data.session_id;
							TOKBOX_TOKEN = data.token;
							setTimeout(function () {
								TB.setLogLevel(TB.DEBUG);
								session = TB.initSession(TOKBOX_SESSION_ID);
								session.addEventListener("sessionConnected", sessionConnectedHandler);
								session.addEventListener("streamCreated", streamCreatedHandler);
								session.addEventListener("streamDestroyed", streamDestroyedHandler);
								session.connect('21436142', TOKBOX_TOKEN);
								jQuery('#controller_' + TOKBOX_SESSION_ID).css({
									width: '0px',
									height: '0px'
								})
							}, 2500)
						}
					}
				})
			}, 1250)
		}
		jQuery("div").on('click', '#up-arrow', function (e) {
			e.preventDefault();
			if (clicked == 0) {
				access();
				clicked++
			}
		});
		jQuery("div").on('click', '#bubble', function (e) {
			e.preventDefault();
			if (clicked == 0) {
				access();
				clicked++
			}
		});
		jQuery("div").on('click', '#down-arrow', function (e) {
			e.preventDefault();
			if (clicked == 0) {
				cAccess();
				clicked++
			}
		});
		jQuery("div").on('click', '#end-arrow', function (e) {
			e.preventDefault();
			if (clicked == 0) {
				cVidone();
				clicked++
			}
		});
		jQuery("a[rel='invite-email']").toggle(function (e) {
			e.preventDefault();
			jQuery('.vidone-widget-invite-email').animate({
				bottom: '80px'
			})
		}, function (e) {
			e.preventDefault();
			jQuery('#vidone-invalid-email').hide();
			jQuery('.vidone-widget-invite-email').animate({
				bottom: '-140px'
			})
		});
		jQuery('#vidone-invite-submit').on('click', function (e) {
			e.preventDefault();
			var email = jQuery('#email').val(); 
			jQuery.ajax({
				url: vidoneAjax.ajaxurl,
				type: 'POST',
				data: {
					action: 'invite_email',
					vid: VID,
					email: email,
					url:VIDONE_INVITE_URL 
				},
				dataType: "json",
				success: function (data) {
					if (data.status === 'invalid') {
						jQuery('#vidone-invalid-email').fadeIn()
					}
					if (data.status === 'valid') {
						jQuery('#vidone-invalid-email').hide();
						jQuery('.vidone-widget-invite-email').animate({
							bottom: '-140px'
						})
					}
				}
			})
		});
		jQuery('#vidone-join-submit').on('click', function (e) { 
			e.preventDefault();
			jQuery('#vidone-invalid').hide();
			var vid = jQuery('#vid').val();
			jQuery.ajax({
				url: vidoneAjax.ajaxurl,
				type: 'POST',
				data: {
					action: 'join_session',
					vid: vid
				},
				dataType: "json",
				success: function (data) {
					if (data.status === 'non-existing') {
						jQuery('#vidone-invalid').fadeIn()
					}
					if (data.status === 'exists') {
						jQuery.ajax({
							url: 'http://vidtok.co/vidone/usage',
							type:'POST',
							data: {
								vapi: VAPI,
								domain : DOMAIN,
								type: 'join'	
							}
						});
						jQuery('.vidone-widget-invite').hide();
						jQuery('.vidone-widget-get-vidone').show();
						jQuery('#vidone-invalid').hide();
						vidone();
						VID = data.vid;
						TOKBOX_SESSION_ID = data.session_id;
						TOKBOX_TOKEN = data.token;
						setTimeout(function () {
							TB.setLogLevel(TB.DEBUG);
							session = TB.initSession(TOKBOX_SESSION_ID);
							session.addEventListener("sessionConnected", sessionConnectedHandler);
							session.addEventListener("streamCreated", streamCreatedHandler);
							session.addEventListener("streamDestroyed", streamDestroyedHandler);
							session.connect('21436142', TOKBOX_TOKEN);
							jQuery('#controller_' + TOKBOX_SESSION_ID).css({
								width: '0px',
								height: '0px'
							})
						}, 2500)
					}
				}
			})
		});
		jQuery("div").on('click', '.start', function (e) {
			if (start == 0) {
				jQuery('.vidone-widget-get-vidone').hide();
				jQuery('.vidone-widget-invite').show();
				vidone();
				jQuery.ajax({
					url: vidoneAjax.ajaxurl,
					type: 'POST',
					data: {
						action: 'create_session'
					},
					dataType: "json",
					success: function (data) {
						jQuery.ajax({
						url: 'http://vidtok.co/vidone/usage',
							type:'POST',
							data: {
								vapi: VAPI,
								domain : DOMAIN,
								type: 'create'	
							}
						});
						VID = data.vid;
						TOKBOX_SESSION_ID = data.session_id;
						TOKBOX_TOKEN = data.token;
						setTimeout(function () {
							TB.setLogLevel(TB.DEBUG);
							session = TB.initSession(TOKBOX_SESSION_ID);
							session.addEventListener("sessionConnected", sessionConnectedHandler);
							session.addEventListener("streamCreated", streamCreatedHandler);
							session.addEventListener("streamDestroyed", streamDestroyedHandler);
							session.connect('21436142', TOKBOX_TOKEN);
							jQuery('#controller_' + TOKBOX_SESSION_ID).css({
								width: '0px',
								height: '0px'
							})
						}, 750)
					}
				});
				start++
			}
		})
	});
	
	function access() {
		jQuery('.vidone-widget-video-h').hide();
		jQuery('.vidone-widget-access').show();
		jQuery('#vidone-widget-default-view').empty();
		jQuery('#vidone-widget-default-view').append('<div class="vidone-close-msg vidone-widget-default-msg-size"> <div class="vidone-widget-action-bar-arrow" id="down-arrow"> <img src="' + VIDONE_PLUGIN_URL + 'img/down-arrow.png" alt="vidtok vid {one} close" /> </div> <p>Close video start window</p> </div>');
		jQuery('.vidone-close-msg').fadeIn('slow');
		jQuery('.vidone-widget-chat-bubble').animate({
			bottom: '-200px'
		}, 375, function () {
			jQuery('.vidone-widget-access').animate({
				bottom: '390px'
			});
			clicked = 0;
			start = 0
		})
	}
	
	function cAccess() {
		jQuery('#vidone-widget-default-view').empty();
		jQuery('#vidone-widget-default-view').append('<div class="vidone-start-msg vidone-widget-default-msg-size"> <div class="vidone-widget-action-bar-arrow" id="up-arrow"> <img src="' + VIDONE_PLUGIN_URL + 'img/up-arrow.png" alt="vidtok vid {one} start" /> </div> <p>Start a <strong>"LIVE"</strong> video chat!</p> </div>');
		jQuery('.vidone-start-msg').fadeIn('slow');
		jQuery('#vidone-invalid').hide();
		jQuery('.vidone-widget-access').animate({
			bottom: '-350px'
		}, 375, function () {
			jQuery('.vidone-widget-chat-bubble').animate({
				bottom: '40px'
			});
			clicked = 0;
			start = 0
		})
	}
	
	function cVidone() {
		session.disconnect();
		jQuery('#vidone-invalid-email').hide();
		jQuery('.vidone-widget-invite-email').animate({
			bottom: '-140px'
		});
		jQuery('.vidone-widget-video-w').animate({
			bottom: '-350px'
		}, 375, function () {
			jQuery('.vidone-widget-action-bar').animate({
				width: '276px'
			}, 375, function () {
				jQuery('.vidone-widget-video-h').empty();
				jQuery('#pub').append('<div id="vidone-pub"><img src="' + VIDONE_PLUGIN_URL + '/img/large-loader-cyan.gif" alt="loading" /><p>Loading Video Connection...</p></div>');
				jQuery('#sub').append('<div id="vidone-sub"><p>Your guest will appear here...</p></div>');
				jQuery('.vidone-widget-chat-view').hide();
				jQuery('#vidone-widget-default-view').fadeIn();
				jQuery('#vidone-widget-default-view').empty();
				jQuery('#vidone-widget-default-view').append('<div class="vidone-start-msg vidone-widget-default-msg-size"> <div class="vidone-widget-action-bar-arrow" id="up-arrow"> <img src="' + VIDONE_PLUGIN_URL + 'img/up-arrow.png" alt="vidtok vid {one} start" /> </div> <p>Start a <strong>"LIVE"</strong> video chat!</p> </div>');
				jQuery('.vidone-start-msg').fadeIn('slow');
				jQuery('.vidone-widget-chat-bubble').animate({
					bottom: '40px'
				});
				clicked = 0;
				start = 0
			})
		})
	}
	
	function vidone() {
		jQuery('#vidone-widget-default-view').hide();
		jQuery('.vidone-widget-access').hide();
		jQuery('.vidone-widget-video-h').show();
		jQuery('#vidone-invalid').hide();
		jQuery('.vidone-widget-access').animate({
			bottom: '-350px'
		});
		jQuery('.vidone-widget-w').animate({
			right: '0px'
		});
		jQuery('.vidone-widget-action-bar').animate({
			width: '598px'
		}, 375, function () {
			jQuery('.vidone-widget-video-w').animate({
				bottom: '40px'
			});
			jQuery('.vidone-widget-chat-view').fadeIn();
			clicked = 0;
			start = 0
		})
	}