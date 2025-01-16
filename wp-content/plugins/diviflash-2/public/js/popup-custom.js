
function df_is_intiger(value) {
    var x;
    return isNaN(value) ? !1 : (x = parseFloat(value), (0 | x) === x);
}


;(function($){
	
    const dfpopup = {
        popupContainer: $('div.popup-container'),
		closeSelector: $('.popup-close, .popup-close span'),
		ovalaySelector: $('.overlay'),
        init: function() {
            // display the modal
			if ( dfpopup.popupContainer.length ) {
				if(typeof popups_with_automatic_trigger !== 'undefined'){
					dfpopup.automaticTriggerProcess(popups_with_automatic_trigger);
				}
				if(typeof popups_with_css_trigger !== 'undefined'){
					dfpopup.cssTriggerProcess(popups_with_css_trigger);
				}
				if(typeof df_popup_close_link_selector !== 'undefined'){
					dfpopup.closeLinkTriggerProcess(df_popup_close_link_selector);
				}
				if(typeof popups_with_automatic_trigger !== 'undefined' || typeof popups_with_css_trigger !== 'undefined'){
				
                    if (typeof popups_with_css_trigger !== 'undefined'){
						dfpopup.urlHashTargeting( popups_with_css_trigger );
					}
					if (typeof popups_with_automatic_trigger !== 'undefined'){
						dfpopup.urlHashTargeting( popups_with_automatic_trigger );
					}
			
				}
				
				dfpopup.closePopup();
				// Get the hash from the URL
				var hash = window.location.hash;

				// Check if the hash exists
                if (hash && hash.includes('#popup_')) {
                    const popup_id = parseInt(hash.replace('#popup_',''),10);
                    if(!isNaN(popup_id)) dfpopup.displayPopup(popup_id);
                }

			}
       
        },
        displayPopup: function(popup_id , hashTarget = false) {
				if ( !df_is_intiger(popup_id) )
				return;

			var popup_selector = '#popup_' + popup_id
			, popup = $( popup_selector )
			, enableajax = false//popup.data('enableajax')
			, divi_popup_container_selector = '#df-popup-container-' + popup_id;
			
			if ( $( divi_popup_container_selector ).length ) {
				dfpopup.processPopup(popup_id, hashTarget);
			}
        },
		processPopup: function(popup_id , hashTarget=false){
			var popup_element = '#popup_' + popup_id;
			var popup = $('body').find( popup_element );

			var settings = JSON.parse(document.querySelector(popup_element).dataset.settings);	
			
			var cookieName = 'diviflash_' + popup_id,
			 cookieType = settings.df_popup_activity_type,
			cookiePeriodType = settings.df_popup_activity_period_type,
			cookiePeriodValue = settings.df_popup_activity_period_value;
    
			let cookieDays = 0;

			if(cookiePeriodType == 'day'){
				cookieDays = parseInt(cookiePeriodValue);
			}else if(cookiePeriodType == 'hour'){
				cookieDays = parseFloat(parseInt(cookiePeriodValue)/24)
			}else if(cookiePeriodType == 'month'){
				cookieDays = parseInt(cookiePeriodValue)*30;
			}
			if ( dfpopup.read_cookie( cookieName )) {
				if(cookieType == 'never'){
					dfpopup.erase_cookie(cookieName)
				}else{
					return;
				}
			
			}
	
			if ( cookieType =='once_only') {
				dfpopup.erase_cookie(cookieName)
			}

		    if(settings.df_popup_prevent_scroll && !dfpopup.read_cookie( cookieName )){
				$('body').addClass('stop-scrolling')
				$('html').addClass('stop-scrolling');
				$('body').bind('touchmove', function(e){e.preventDefault()})
			}

			if(settings.df_popup_content_scroll){
				$('body').addClass('popup_scroll_added');
				setTimeout( function() { popupScrollByObserver() }, 1000);
				
			}

			
			if(settings.df_popup_trigger_type === 'on_load' || settings.df_popup_trigger_type === 'on_scroll' 
			|| settings.df_popup_trigger_type === 'scroll_to_element' || settings.df_popup_trigger_type === 'on_inactivity'
			|| settings.df_popup_trigger_type === 'on_exit'){
				$(popup).addClass('active');
				$(popup).css( {"z-index" : 999999} );
			}

			if(hashTarget == true){
				$(popup).addClass('active');
				$(popup).css( {"z-index" : 999999} );
			}
			if(settings.df_popup_trigger_type === 'click' ){
				if(settings.df_popup_custom_selector !== ''){
					$(popup).addClass('active');
	
					$(popup).css( {"z-index" : 999999} );
				}
				
			}
			
			setTimeout(function() {
				$(popup).addClass(settings.df_popup_animation_type);
			}, settings.df_popup_animation_delay);

			
			if ($(popup).hasClass('open')) {
				$( popup ).removeClass('open');
				$( popup ).addClass('close');
			}
			else if(!$( popup ).hasClass('close')) {

				setTimeout( function() {
					$(popup).addClass('open');
				}, 200);
			}
         
			if ($(popup).hasClass('close')) {

				$( popup ).addClass('open');
				$( popup ).removeClass('close');

			}

			// close button set to inner
			if(settings.df_popup_close_btn_move_inner_content){
				const close_selector = '.popup-close-button-' + popup_id;
				const close_destination= '#popup_' + popup_id + ' .et_pb_row.custom_row';
				if($(close_destination).length > 0){
					$(close_selector).appendTo(close_destination);
					$(close_selector).css("position", "absolute");
				}else{
					$(close_selector).prependTo('#popup_' + popup_id + ' .df_popup_inner_container .df_popup_wrapper .et_pb_section:first-child');
					$(close_selector).css("position", "absolute");
				}
			}

			$(`${popup_element}.overlay.active`).css({
				"animation": `${settings.df_popup_animation_duration}ms popup_load`,
				"opacity":"1",
				"visibility":"visible"
			})

		},
		 closePopup: function () {
			dfpopup.closeSelector.on('click touchstart', function (e) {
				var closeClick = true;
				 var popup_id = $(this).parents().children(".overlay").attr("id")
				 popup_id = popup_id.split("_")
				 if (e.target !== e.currentTarget) return;
				 dfpopup.closeActivePopup(parseInt(popup_id[1]));
				//  var $videoEl = jQuery(this).closest('.overlay').find('iframe');
				//  $videoEl.attr('src', $videoEl.attr('src'));
				//  var $iframe = jQuery('iframe'),
				// 	src = $iframe.prop('src');
				// $iframe.prop('src', '').prop('src', src.replace('&autoplay=1&mute=1', ''));
			 })

			 dfpopup.ovalaySelector.on('click', function(e){
				//e.preventDefault()
				var popup_id = $(this).attr("id")
				popup_id = popup_id.split("_");
				var popup_element = '#popup_' + parseInt(popup_id[1]);
				var popup_container_id = 'df_popup_inner_containner_'+ popup_id[1];
				var closestSelector = '.df_popup_wrapper .et_pb_section'; 
				var popupContainer = document.getElementById(popup_container_id);
				let ignorSelector = '';
				if (popupContainer.querySelector(closestSelector)) { // use builder
					ignorSelector = '.df_popup_wrapper .et_pb_section';
				} else {                                                // Child elements with class '.df_popup_wrapper .et_pb_section' do not exist
					ignorSelector = '.df_popup_wrapper .custom_section'; // Use WIthout Builder									
				}
			
				if ($(e.target).closest(ignorSelector).length === 0 ) {
				
					var settings = JSON.parse(document.querySelector(popup_element).dataset.settings);
				
					if(settings.df_popup_close_on_overlay_click === true){
						dfpopup.closeActivePopup(parseInt(popup_id[1]));
					}
					
				}
		
			})

			$("body").on('keydown', function(event){
				if(event.which == 27) {
					var popupDiv = document.querySelector('.overlay.active');
					if (popupDiv) {
						var popupId = popupDiv.id;
					
						const popup_id = popupId.split("_")
						dfpopup.closeActivePopup(parseInt(popup_id[1]));
					}
				}
			});

					
		 },

		 // Function to find the YouTube iframe within the popup
		 findYouTubeIframe: function() {
			let iframes = document.getElementsByTagName('iframe');
			for (let i = 0; i < iframes.length; i++) {
				let iframe = iframes[i];
				if (iframe.src.includes('youtube.com/embed')) {
				youtubeIframe = iframe;
				break;
				}
			}
		},
        reset: function() {
            $('body').css('padding-bottom', 0);
        },

		 closeActivePopup: function (popup_id) {
			 // find active overlay
			 var popup = $('#popup_'+ popup_id);
			 var popup_element = '#popup_' + popup_id;
	
			// $(popup).animate({ opacity: 0 }, 1000);

			/* Youtube pause Functionality*/
			let iframes = document.getElementsByTagName('iframe');
			for (let i = 0; i < iframes.length; i++) {
				let iframe = iframes[i];
				if (iframe.src.includes('youtube.com/embed')) {
					let videoUrl = iframe.src;
					videoUrl = videoUrl.replace('?autoplay=1', '?autoplay=0');
					iframe.src = videoUrl;
				}
			}

			// media uploaded video
			if($(popup_element).find('video').length){
				const media = $(popup_element).find('video').get(0)
				media.pause();
				media.currentTime = 0;
			}

			var settings = JSON.parse(document.querySelector(popup_element).dataset.settings);

			if(settings.df_popup_prevent_scroll){
				$('body').removeClass('stop-scrolling')
				$('html').removeClass('stop-scrolling');
			}

			if (popup.hasClass('active')) {

			  //  Animation
			  const close_anmimation_duration = settings.df_popup_close_animation_enable ? settings.df_popup_close_animation_duration: 200;
				setTimeout(function () {
					$(popup).removeClass('active');
					$(popup).css({ "z-index": -1 });
				}, close_anmimation_duration); // Close animation apply
			}

			if(settings.df_popup_content_scroll){
				if($('body.popup_scroll_added').length > 0 ){
					$('body').removeClass('popup_scroll_added');
				}
				
			}


			var cookieName = 'diviflash_' + popup_id,
				cookieType = settings.df_popup_activity_type,
			cookiePeriodType = settings.df_popup_activity_period_type,
			cookiePeriodValue = settings.df_popup_activity_period_value;
	
			let cookieDays = 0;

			if(cookiePeriodType == 'day'){
				cookieDays = parseInt(cookiePeriodValue);
			}else if(cookiePeriodType == 'hour'){
				cookieDays = parseFloat(parseInt(cookiePeriodValue)/24)
			}else if(cookiePeriodType == 'month'){
				cookieDays = parseInt(cookiePeriodValue)*30;
			}
		
			if ( cookieDays > 0 && cookieType =='per_period') {
				dfpopup.create_cookie( cookieName, 'true', cookieDays );
			}
			else if(cookieType =='once_only'){
				dfpopup.erase_cookie( cookieName );
				cookieDays = 365;
				dfpopup.create_cookie( cookieName, 'true', cookieDays );
			}
			else{
				dfpopup.erase_cookie( cookieName );
			}
          
			if (popup.length) {
				 if (popup_id == null) {
					 var popupArr = popup.attr('id').split('_');
					 popup_id = popupArr[popupArr.length - 1];
				 }
				 popup.removeClass('open');
				 popup.addClass('close');
			}
            const close_anmimation_duration = settings.df_popup_close_animation_enable ? settings.df_popup_close_animation_duration: 200;
			$(`#popup_${popup_id}.overlay.close`).css({
				"animation": `${close_anmimation_duration}ms popup_close`,
				"opacity":"0",
				"visibility":"hidden"
			})
		 },
        create_cookie: function( name,value,days ) {
			var expires = "";
			
			if ( days ) {
				
				var date = new Date();
				
				date.setTime(date.getTime() + ( days * 24 * 60 * 60 * 1000));
				
				expires = "; expires=" + date.toUTCString();
			}
			
			document.cookie = name + "=" + value + expires + "; path=/";
		},

		read_cookie: function( name ) {
			
			var cookieName = name + "=";
			var cookieArray = document.cookie.split(';');
			
			for(var i=0;i < cookieArray.length;i++) {
				
				var cookieItem = cookieArray[i];
				
				while (cookieItem.charAt(0)==' ') cookieItem = cookieItem.substring(1,cookieItem.length);
				
				if (cookieItem.indexOf(cookieName) == 0) return cookieItem.substring(cookieName.length,cookieItem.length);
			}
			
			return null;
		},

        create_cookie:function( name,value,days ) {
			var expires = "";
			
			if ( days ) {
				
				var date = new Date();
				
				date.setTime(date.getTime() + ( days * 24 * 60 * 60 * 1000));
				
				expires = "; expires=" + date.toUTCString();
			}
			
			document.cookie = name + "=" + value + expires + "; path=/";
		},

		erase_cookie: function( name ) {
			dfpopup.create_cookie( name, '', -1 );
		},
		getScrollTop:function() {
			
			if ( typeof pageYOffset!= 'undefined' ) {
				
				// most browsers except IE before #9
				return pageYOffset;
			}
			else {
				
				var B = document.body; // IE 'quirks'
				var D = document.documentElement; // IE with doctype
				D = ( D.clientHeight ) ? D: B;
				
				return D.scrollTop;
			}
		},
		automaticTriggerProcess:function(popups_with_automatic_trigger){

			if (typeof popups_with_automatic_trigger !== 'undefined') {
	
				if ( $( popups_with_automatic_trigger ).length > 0 ) {
					
					$.each( popups_with_automatic_trigger, function( popup_id, at_settings ) {
						
						var automatic_trigger_obj = jQuery.parseJSON( at_settings );
						var at_type_value = automatic_trigger_obj.at_type;
		
	                    
						if ( at_type_value == 'on_load' ) {
						
							var time_delayed = automatic_trigger_obj.at_value * 1000;
						  
							if ( time_delayed == 0 ) {
								time_delayed = 300;
							}
							
							setTimeout( function() {
								
								dfpopup.displayPopup( popup_id );
								
							}, time_delayed);
						}
						
						
						if ( at_type_value == 'on_scroll' ) {
					
							var poupupScroll = automatic_trigger_obj.at_value;
							let refScroll= 'px';
				          
							if ( poupupScroll.indexOf('%') || poupupScroll.indexOf('px') ) {
								
								if ( poupupScroll.indexOf('%') > 0 ) {
									
									poupupScroll = poupupScroll.replace(/%/g, '');
									refScroll = '%';
								}
								
								if ( poupupScroll.indexOf('px') > 0 ) {
									
									poupupScroll = poupupScroll.replace(/px/g, '');
									refScroll = 'px';
								}
							}else{
								refScroll = 'px';
							}
								
								
							poupupScroll = poupupScroll.split(':');
							var poupupScroll = poupupScroll[0]
		
					
							$(window).scroll(function(e) {
								
								var s = dfpopup.getScrollTop(),
									d = $(document).height(),
									c = $(window).height(),
									wScroll;
								
								if ( refScroll == '%' ) {
								
									wScroll = (s / (d-c)) * 100;
								
								} else if ( refScroll == 'px' ) {
									
									wScroll = s;
									
								} else {
									
									return;
								}
								
								if ( poupupScroll > 0 ) {
	
									if ( wScroll >= poupupScroll ) {
										
										if ( !dfpopup.isActivePopup( popup_id ) && !dfpopup.isClosedPopup(popup_id) ) {
											dfpopup.displayPopup( popup_id );
										}
									}
						
								}
								
							});
							
						}
			
						if(at_type_value == 'on_inactivity'){
					
							var inactivityValue = automatic_trigger_obj.at_value !== null ? parseInt(automatic_trigger_obj.at_value): 5;
					
							if(!df_is_intiger(inactivityValue)){
								return;
							}
							const delayInMilisec = inactivityValue*1000;
							window.onload = function(e) {
								 e.preventDefault();
								var time;
								window.addEventListener('load', resetTimer, true);
								var events = ['mousedown', 'mousemove', 'keypress', 'onkeydown', 'scroll', 'touchstart'];
								events.forEach(function(name) {
								document.addEventListener(name, resetTimer, true);
								});
								function showEvent() {
									dfpopup.displayPopup( popup_id );
								}
	
								function resetTimer() {
									clearTimeout(time);
									time = setTimeout(showEvent, delayInMilisec)
									// 1000 milliseconds = 1 second
								}
							  }
						}

						if (at_type_value == 'scroll_to_element') {

							var scroll_element = automatic_trigger_obj.at_value;

							if (scroll_element && $(scroll_element).length > 0) {
								var viewport_position = automatic_trigger_obj.at_view;
								$(window).on('scroll', function(e) {
									e.preventDefault();

									var elementOffsetTop = $(scroll_element).offset().top,
											elementHeigh = $(scroll_element).outerHeight(),
											windowHeight = $(window).height(),
											scrolledValue = $(this).scrollTop();

									if ('on_top' === viewport_position) {
										if (scrolledValue > (elementOffsetTop + elementHeigh - windowHeight) &&
												(elementOffsetTop < scrolledValue)
												//&& (scrolledValue+windowHeight > elementOffsetTop+elementHeigh)
										) {
											if (!dfpopup.isActivePopup(popup_id) && !dfpopup.isClosedPopup(popup_id)) {
												dfpopup.displayPopup(popup_id);
											}
										}
									} else if ('on_center' === viewport_position) {
										var terget = ((elementOffsetTop - ((windowHeight - 100) / 2)) + (elementHeigh / 2)) - 100;
										if (scrolledValue >= terget) {
											if (!dfpopup.isActivePopup(popup_id) && !dfpopup.isClosedPopup(popup_id)) {
												dfpopup.displayPopup(popup_id);
											}
										}
									} else {
										var terget = (elementOffsetTop - windowHeight);
										if (scrolledValue >= terget) {
											if (!dfpopup.isActivePopup(popup_id) && !dfpopup.isClosedPopup(popup_id)) {
												dfpopup.displayPopup(popup_id);
											}
										}
									}

								});
							}
						}
						
						
						if ( at_type_value == 'on_exit' ) {
							// document.addEventListener('visibilitychange', function () { // Will Added this feature next update
							// 	if (document.hidden) {
							// 	  // Do something here, for example, pause a video or stop a timer
							// 	  console.log('User has switched to another tab.');
							// 	} else {
							// 	  // Do something here, for example, resume a video or restart a timer
							// 	  console.log('User has switched back to this tab.');
							// 	  dfpopup.displayPopup( popup_id );
							// 	}
							//   });
						
							document.addEventListener('mouseout', e => {
								if (!e.toElement && !e.relatedTarget) {
									if ( !dfpopup.isActivePopup( popup_id ) && !dfpopup.isClosedPopup(popup_id) ) {
										dfpopup.displayPopup( popup_id );
									}
								}
							});

						 }
					});
				}
			}
		},
		cssTriggerProcess: function(popups_with_css_trigger){
			if (typeof popups_with_css_trigger !== 'undefined') {
				if ( $( popups_with_css_trigger ).length > 0 ) {
					$.each( popups_with_css_trigger, function( popup_id, selector ) {
						if(selector !== ''){
							$(selector).css( 'pointer-events', 'auto' );
							$(selector).css( 'cursor', 'pointer' );
							$( selector +':not(.popup-close)' ).on('click touch tap', function (e) {
								e.preventDefault();
								var cookieName = 'diviflash_' + popup_id;
								
								dfpopup.erase_cookie( cookieName );
								dfpopup.displayPopup(parseInt(popup_id));
							});
						}
					
					});
				}
			}
		},
		urlHashTargeting: function(popups_with_css_trigger = 'undefined' , popups_with_automatic_trigger = 'undefined'){

			if (typeof popups_with_css_trigger !== 'undefined') {
				if ( $( popups_with_css_trigger ).length > 0 ) {
					$.each( popups_with_css_trigger, function( popup_id, selector ) {
						
						var popup_selector = "#popup_"+ popup_id;
						var links = document.querySelectorAll('a[href="'+popup_selector+'"');
						links.forEach((link)=>{
							if(link){
								link.addEventListener('click', function(event) {
									event.preventDefault();
									var cookieName = 'diviflash_' + popup_id;
									dfpopup.erase_cookie( cookieName );
									dfpopup.displayPopup(parseInt(popup_id), true);
								});
							}
						});
					
					});
				}
			}

			if (typeof popups_with_automatic_trigger !== 'undefined') {
	
				if ( $( popups_with_automatic_trigger ).length > 0 ) {
					
					$.each( popups_with_automatic_trigger, function( popup_id, at_settings ) {
						
						var popup_selector = "#popup_"+ popup_id;
						var links = document.querySelector('a[href='+popup_selector+'');
						links.forEach(()=>{
							if(link){
								link.addEventListener('click', function(event) {
									event.preventDefault();
									cookieName = 'diviflash_' + popup_id;
									dfpopup.erase_cookie( cookieName );
									dfpopup.displayPopup(parseInt(popup_id));
								});
							}
						});
			 
					});
				}
			}

		},
		closeLinkTriggerProcess: function(df_popup_close_link_selector){
			if(typeof df_popup_close_link_selector !== 'undefined'){
				if ( $( df_popup_close_link_selector ).length > 0 ) {
					
					$.each( df_popup_close_link_selector, function( popup_id, selector ) {
					
						$( selector ).on('click touch tap', function (e) {
						
							e.preventDefault();
							var cookieName = 'diviflash_' + popup_id;
						
							dfpopup.erase_cookie( cookieName );
							
					

							var closeClick = true;

							dfpopup.closeActivePopup(parseInt(popup_id), closeClick);
	
						});
					});
				}
			}
		},

		preventScrollonPopup: function(){
			window.onscroll = function () { window.scrollTo(0, 0); };
		},
		isActivePopup: function ( popup_id ) {
			
			if ( !popup_id ) {
				
				var popup = $( '.overlay.open' );
			}
			else {
				
				var popup = $( '#popup_' + popup_id );
			}
			
			if ( $( popup ).hasClass('open') ) {
				
				return true;
			}
			
			return false;
		},
		isClosedPopup : function( popup_id ) {
			
			if ( !popup_id ) {
				
				return null;
			}
			
			var popup = $( '#popup_' + popup_id );
			
			if ( $( popup ).hasClass('close') ) {
				
				return true;
			}
			
			return false;
		}

    }

	function df_remove_animation_data(element) {
		var attr_name;
		var data_attrs_to_remove = [];
		var data_attrs = element.attributes;
		for (var i = 0; i < data_attrs.length; i++) {
		  if (data_attrs[i].name.substring(0, 15) === 'data-animation-') {
			data_attrs_to_remove.push(data_attrs[i].name);
		  }
		}
		data_attrs_to_remove.forEach(function(attr_name) {
		  element.removeAttribute(attr_name);
		});
	}
	function df_get_animation_classes() {
		return ['et_animated', 'et_is_animating', 'infinite', 'et-waypoint', 'fade', 'fadeTop', 'fadeRight', 'fadeBottom', 'fadeLeft', 'slide', 'slideTop', 'slideRight', 'slideBottom', 'slideLeft', 'bounce', 'bounceTop', 'bounceRight', 'bounceBottom', 'bounceLeft', 'zoom', 'zoomTop', 'zoomRight', 'zoomBottom', 'zoomLeft', 'flip', 'flipTop', 'flipRight', 'flipBottom', 'flipLeft', 'fold', 'foldTop', 'foldRight', 'foldBottom', 'foldLeft', 'roll', 'rollTop', 'rollRight', 'rollBottom', 'rollLeft', 'transformAnim'];
	}
  
	function df_remove_animation(element) {
		// Don't remove looping animations, return early.
		if (element.classList.contains('infinite')) {
			return;
		}

		var animation_classes = df_get_animation_classes(); // Assuming et_get_animation_classes() is defined elsewhere.

		// Remove attributes which avoid horizontal scroll to appear when section is rolled
		if (element.classList.contains('et_pb_section') && element.classList.contains('roll')) {
			var cssContainerPrefix = et_frontend_scripts.builderCssContainerPrefix;
			var cssLayoutPrefix = et_frontend_scripts.builderCssLayoutPrefix;

			document.querySelectorAll(cssContainerPrefix + ', ' + cssLayoutPrefix).forEach(function (el) {
				el.style.overflowX = '';
			});
		}

		element.classList.remove.apply(element.classList, animation_classes);

		element.style.animationDelay = '';
		element.style.animationDuration = '';
		element.style.animationTimingFunction = '';
		element.style.opacity = '';
		element.style.transform = '';
		element.style.left = '';

		// Prevent animation module with no explicit position property to be incorrectly positioned
		// after the animation is complete and the animation classname is removed because the animation classname has
		// animation-name property which gives pseudo correct z-index. This class also works as a marker to prevent animating already animated objects.
		element.classList.add('et_had_animation');
	}
	
	/**
	 * Animation Functionality of POPUP
	 *
	 * @param Element $elementOriginal
	 */
	function df_animate_element(elementOriginal) {
		var element = elementOriginal;
		if (element.classList.contains('et_had_animation')) {
			return;
		}

		var animation_style = element.getAttribute('data-animation-style');
		var animation_repeat = element.getAttribute('data-animation-repeat');
		var animation_duration = element.getAttribute('data-animation-duration');
		var animation_delay = element.getAttribute('data-animation-delay');
		var animation_intensity = element.getAttribute('data-animation-intensity');
		var animation_starting_opacity = element.getAttribute('data-animation-starting-opacity');
		var animation_speed_curve = element.getAttribute('data-animation-speed-curve');
		var buttonWrapper = element.closest('.et_pb_button_module_wrapper');
		var isEdge = document.body.classList.contains('edge'); // Check for the 'edge' class in the body's classList

		if (element.classList.contains('et_pb_section') && animation_style === 'roll') {
			document.querySelectorAll(et_frontend_scripts.builderCssContainerPrefix + ', ' + et_frontend_scripts.builderCssLayoutPrefix).forEach(function (el) {
				el.style.overflowX = 'hidden';
			});
		}

		// Remove all the animation data attributes once the variables have been set
		df_remove_animation_data(element);

		// Opacity can be 0 to 1 so the starting opacity is equal to the percentage number multiplied by 0.01
		var starting_opacity = isNaN(parseInt(animation_starting_opacity)) ? 0 : parseInt(animation_starting_opacity) * 0.01;

		// Check if the animation speed curve is one of the allowed ones and set it to the default one if it is not
		var allowed_speed_curves = ['linear', 'ease', 'ease-in', 'ease-out', 'ease-in-out'];
		animation_speed_curve = allowed_speed_curves.includes(animation_speed_curve) ? animation_speed_curve : 'ease-in-out';

		if (buttonWrapper) {
			element.classList.remove('et_animated');
			element = buttonWrapper;
			element.classList.add('et_animated');
		}

		element.style.animationDuration = animation_duration;
		element.style.animationDelay = animation_delay;
		element.style.opacity = starting_opacity;
		element.style.animationTimingFunction = animation_speed_curve;

		if (animation_style === 'slideTop' || animation_style === 'slideBottom') {
			element.style.left = '0px';
		}

		var intensity_css = {};
		var intensity_percentage = isNaN(parseInt(animation_intensity)) ? 50 : parseInt(animation_intensity);

		// All the animations that can have intensity
		var intensity_animations = ['slide', 'zoom', 'flip', 'fold', 'roll'];
		var original_animation = false;
		var original_direction = false;

		// Check if current animation can have intensity
		for (var i = 0; i < intensity_animations.length; i++) {
			var animation = intensity_animations[i];
			// As the animation style is a combination of type and direction check if
			// the current animation contains any of the allowed animation types
			if (!animation_style || !animation_style.startsWith(animation)) {
				continue;
			}
			// If it does set the original animation to the base animation type
			original_animation = animation;
			// Get the remainder of the animation style and set it as the direction
			original_direction = animation_style.substr(animation.length, animation_style.length);
			// If that is not empty convert it to lower case for better readability's sake
			if (original_direction !== '') {
				original_direction = original_direction.toLowerCase();
			}
			break;
		}

		if (original_animation !== false && original_direction !== false) {
			intensity_css = df_process_animation_intensity(original_animation, original_direction, intensity_percentage);
		}

		if (Object.keys(intensity_css).length > 0) { // temporarily disable transform transitions to avoid double animation.
			if (isEdge) {
				Object.assign(intensity_css, { transition: 'transform 0s ease-in' });
			}
			Object.assign(element.style, intensity_css);
		}

		element.classList.add('et_animated');
		element.classList.add('et_is_animating');
		element.classList.add(animation_style);
		animation_repeat ? element.classList.add(animation_repeat) : false;

		// Remove the animation after it completes if it is not an infinite one
		if (!animation_repeat) {
			var animation_duration_ms = parseInt(animation_duration);
			var animation_delay_ms = parseInt(animation_delay);

			setTimeout(function () {
				df_remove_animation(element);
				if (isEdge && Object.keys(intensity_css).length > 0) {
					// re-enable transform transitions after animation is done.
					element.style.transition = '';
				}
			}, animation_duration_ms + animation_delay_ms);
		}
	}
  
	/**
	 * Animation Processing of POPUP
	 *
	 * @param animation
	 *  @param direction
	 *  @param intensity
	 *  @reutn $intensity_css inline css apply when go view point
	 */

	function df_process_animation_intensity(animation, direction, intensity) {
		var intensity_css = {};
		switch (animation) {
			case 'slide':
				switch (direction) {
					case 'top':
						var percentage = intensity * -2;
						intensity_css = {
							transform: "translate3d(0, ".concat(percentage, "%, 0)")
						};
						break;
					case 'right':
						var percentage = intensity * 2;
						intensity_css = {
							transform: "translate3d(".concat(percentage, "%, 0, 0)")
						};
						break;
					case 'bottom':
						var percentage = intensity * 2;
						intensity_css = {
							transform: "translate3d(0, ".concat(percentage, "%, 0)")
						};
						break;
					case 'left':
						var percentage = intensity * -2;
						intensity_css = {
							transform: "translate3d(".concat(percentage, "%, 0, 0)")
						};
						break;
					default:
						var scale = (100 - intensity) * 0.01;
						intensity_css = {
							transform: "scale3d(".concat(scale, ", ").concat(scale, ", ").concat(scale, ")")
						};
						break;
				}
				break;
			case 'zoom':
				var scale = (100 - intensity) * 0.01;
				switch (direction) {
					case 'top':
						intensity_css = {
							transform: "scale3d(".concat(scale, ", ").concat(scale, ", ").concat(scale, ")")
						};
						break;
					case 'right':
						intensity_css = {
							transform: "scale3d(".concat(scale, ", ").concat(scale, ", ").concat(scale, ")")
						};
						break;
					case 'bottom':
						intensity_css = {
							transform: "scale3d(".concat(scale, ", ").concat(scale, ", ").concat(scale, ")")
						};
						break;
					case 'left':
						intensity_css = {
							transform: "scale3d(".concat(scale, ", ").concat(scale, ", ").concat(scale, ")")
						};
						break;
					default:
						intensity_css = {
							transform: "scale3d(".concat(scale, ", ").concat(scale, ", ").concat(scale, ")")
						};
						break;
				}
				break;
			case 'flip':
				switch (direction) {
					case 'right':
						var degree = Math.ceil(90 / 100 * intensity);
						intensity_css = {
							transform: "perspective(2000px) rotateY(".concat(degree, "deg)")
						};
						break;
					case 'left':
						var degree = Math.ceil(90 / 100 * intensity) * -1;
						intensity_css = {
							transform: "perspective(2000px) rotateY(".concat(degree, "deg)")
						};
						break;
					case 'top':
					default:
						var degree = Math.ceil(90 / 100 * intensity);
						intensity_css = {
							transform: "perspective(2000px) rotateX(".concat(degree, "deg)")
						};
						break;
					case 'bottom':
						var degree = Math.ceil(90 / 100 * intensity) * -1;
						intensity_css = {
							transform: "perspective(2000px) rotateX(".concat(degree, "deg)")
						};
						break;
				}
				break;
			case 'fold':
				switch (direction) {
					case 'top':
						var degree = Math.ceil(90 / 100 * intensity) * -1;
						intensity_css = {
							transform: "perspective(2000px) rotateX(".concat(degree, "deg)")
						};
						break;
					case 'bottom':
						var degree = Math.ceil(90 / 100 * intensity);
						intensity_css = {
							transform: "perspective(2000px) rotateX(".concat(degree, "deg)")
						};
						break;
					case 'left':
						var degree = Math.ceil(90 / 100 * intensity);
						intensity_css = {
							transform: "perspective(2000px) rotateY(".concat(degree, "deg)")
						};
						break;
					case 'right':
					default:
						var degree = Math.ceil(90 / 100 * intensity) * -1;
						intensity_css = {
							transform: "perspective(2000px) rotateY(".concat(degree, "deg)")
						};
						break;
				}
				break;
			case 'roll':
				switch (direction) {
					case 'right':
					case 'bottom':
						var degree = Math.ceil(360 / 100 * intensity) * -1;
						intensity_css = {
							transform: "rotateZ(".concat(degree, "deg)")
						};
						break;
					case 'top':
					case 'left':
						var degree = Math.ceil(360 / 100 * intensity);
						intensity_css = {
							transform: "rotateZ(".concat(degree, "deg)")
						};
						break;
					default:
						var degree = Math.ceil(360 / 100 * intensity);
						intensity_css = {
							transform: "rotateZ(".concat(degree, "deg)")
						};
						break;
				}
				break;
		}
		return intensity_css;
	}
	/**
	 * Scroll Event by Insertion Observer
	 *  Use Observer API
	 *  Main Function for Scroll Popup Content run only if option is enable
	 */
	function popupScrollByObserver(){
		const popup_scroll_added = document.body.classList.contains('popup_scroll_added')
		if (popup_scroll_added) {
			const Observer = new IntersectionObserver(
			(modules, observer) => {
				modules.forEach((module, i) => {
		
				const target = module.target;
				
				

				const isEtWaypoint = target.classList.contains("et-waypoint");
		
				const isBlurb = target.classList.contains("et_pb_blurb");
				const isEtAnimated = target.classList.contains("et_animated");
				if (module.isIntersecting) {

					if(isEtAnimated){   // When User give Custom Animation
						df_animate_element(target)
					}
				
					// Apply the "et-animated" class to the target element
					if(isEtWaypoint){
					target.classList.add("et-animated");
					}
					if(isBlurb){
					const etWaypointDivs = document.querySelectorAll('.popup-container .et-waypoint');
					etWaypointDivs.forEach(div => {
						div.classList.add('et-animated');
					});
					}

					if(target.classList.contains("et_pb_number_counter")){
					target.classList.add("active");
					var $et_pb_number_counter = $('.et_pb_number_counter');
					if ($et_pb_number_counter.length) {
						$et_pb_number_counter.each(function() {
							var $this_counter = $(this);
							$this_counter.data('easyPieChart').update($this_counter.data('number-value'));
				
						});
					}

					}

					if(target.classList.contains("et_pb_circle_counter")){
					var $et_pb_circle_counter = $('.et_pb_circle_counter');
					if($et_pb_circle_counter.length){
						var $this_counter = $(target).find('.et_pb_circle_counter_inner');
						if ($this_counter.data('PieChartHasLoaded') || 'undefined' === typeof $this_counter.data('easyPieChart')) {
							return;
						}
						$this_counter.data('easyPieChart').update($this_counter.data('number-value'));
						$this_counter.data('PieChartHasLoaded', true);
					}
					
					}
					// Stop observing the target element
					observer.unobserve(target);
				}

				});
			},
			{ threshold: .5 }
			);

			const et_pb_module = document.querySelectorAll(".popup_scroll_added .popup-container .et_pb_module");
			et_pb_module.forEach((module) => {
			Observer.observe(module);
			});
		}
	}
	window.addEventListener('DOMContentLoaded', function (){
		dfpopup.init();
	})
    
})(jQuery);
