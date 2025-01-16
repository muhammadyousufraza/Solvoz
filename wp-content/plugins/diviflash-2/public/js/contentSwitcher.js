(function ($) {

        var selectors = document.querySelectorAll('.difl_contentswitcher');
        [].forEach.call(selectors, function (selector) {
			var container = selector.querySelector('.df-content-switcher-wrapper');

        	var settings = JSON.parse(container.dataset.settings);

			var _elm = $(selector);
			
            var toggleSwitch = _elm.find('.df-cs-switch.df-input-label'),
				input = _elm.find('input.df-cs-toggle-switch'),
				primarySwitcher = _elm.find('.df-cs-switch.primary'),
				secondarySwitcher = _elm.find('.df-cs-switch.secondary');

				if(settings.content_switcher_type ==='class_base'){
					$("." + settings.primary_content_selector).show();
					$("." + settings.secondary_content_selector).hide();
				}
				const animationStatus = settings.enable_animation ? settings.enable_animation : 'on';
				toggleSwitch.on('click', function(e){
				
					if(input.is(':checked')){
						primarySwitcher.removeClass('active');
						secondarySwitcher.addClass('active');
						const secondarySelector = settings.content_switcher_type !=='class_base' ? `.${settings.module_class} .df-cs-content-section`: `.${settings.secondary_content_selector}`
						df_content_switcher_anime(
							_elm, 
							secondarySelector, 
							settings.content_animation, 
							parseInt(settings.content_animation_duration),
							'secondary',
							animationStatus
						);
						if(settings.content_switcher_type ==='class_base'){
						
							$("." + settings.primary_content_selector).hide();
							$("." + settings.secondary_content_selector).show();
						}
					}else {
						secondarySwitcher.removeClass('active');
						primarySwitcher.addClass('active');
						const primarySelector = settings.content_switcher_type !=='class_base' ? `.${settings.module_class} .df-cs-content-section` : `.${settings.primary_content_selector}`;
						df_content_switcher_anime(
							_elm, 
							primarySelector,
							settings.content_animation, 
							parseInt(settings.content_animation_duration),
							'primary',
							animationStatus
						);
						if(settings.content_switcher_type ==='class_base'){
							$("." + settings.primary_content_selector).show();
							$("." + settings.secondary_content_selector).hide();
						}
					}
				});

				var buttons = _elm.find('.df-cs-button'),
				contents = _elm.find('.df-cs-content-section');
			
				buttons.each(function (index, btn){
					$(this).on('click', function(e) {
						e.preventDefault();
				
						if($(this).hasClass('active')) {
							return;
						}else {

							const classBaseSelector = index === 0 ? `.${settings.primary_content_selector}` : `.${settings.secondary_content_selector}`;
							const buttonContentSelector = settings.content_switcher_type !=='class_base' ? `.${settings.module_class} .df-cs-content-section` : classBaseSelector;	
							const contentClass = index !== 0 ? 'secondary' : 'primary';
							df_content_switcher_anime(
								_elm, 
								buttonContentSelector, 
								settings.content_animation, 
								parseInt(settings.content_animation_duration),
								settings.content_switcher_type !=='class_base' ? contentClass : 'class',
								animationStatus
							);
							
							buttons.removeClass('active');
							$(this).addClass('active');
							if(settings.content_switcher_type ==='class_base'){

								if(index === 0){
									$("." + settings.primary_content_selector).show();
									$("." + settings.secondary_content_selector).hide();
						
								}else{
									$("."+ settings.primary_content_selector).hide();
									$("."+ settings.secondary_content_selector).show();
								}							
							}else{
						
								contents.removeClass('active');
								_elm.find('.df-cs-content-section:eq('+ index +')').addClass('active');
								
							}
						}
					} );
				});

        });

		var animations = {
			slide_left : {
				opacity: ['1', '0'],
				translateX: ['0', '-100px']
			},
			slide_right : {
				opacity: ['1', '0'],
				translateX: ['0', '100px']
			},
			slide_up : {
				opacity: ['1', '0'],
				translateY: ['0', '-100px']
			},
			slide_down : {
				opacity: ['1', '0'],
				translateY: ['0', '100px']
			},
			fade_in : {
				opacity: ['1', '0'],
			},
			zoom_left : {
				opacity: ['1', '0'],
				scale: ['1', '.5'],
				transformOrigin: ['0% 50%', '0% 50%'],
				// duration: 200
			},
			zoom_center : {
				opacity: ['1', '0'],
				scale: ['1', '.5'],
				transformOrigin: ['50% 50%', '50% 50%'],
				// duration: 200
			},
			zoom_right : {
				opacity: ['1', '0'],
				scale: ['1', '.5'],
				transformOrigin: ['100% 50%', '100% 50%'],
				// duration: 200
			}
		}
	
		function df_content_switcher_anime(element, selector, config = 'slide_left', duration, active_class , animationStatus = 'on'  ) {
			var object = {
				targets: selector,
				direction: 'alternate',
				easing: 'linear',
				duration: duration,
				endDelay: 1,
				update: function(anim) {
					if(anim.progress === 100) {
						if(active_class === 'secondary'){
							element.find('.df-cs-content-section.secondary').addClass('active');
							element.find('.df-cs-content-section.primary').removeClass('active');
	
						}else{
							element.find('.df-cs-content-section.primary').addClass('active');
							element.find('.df-cs-content-section.secondary').removeClass('active');
						}
						
					}
				}
			};
			if(animationStatus === 'on'){
				var anime_config = Object.assign(object, animations[config]);
	
				if( window.anime ) {
					window.anime(anime_config);
				}
			}else{
				if(active_class === 'secondary'){
					element.find('.df-cs-content-section.secondary').addClass('active');
					element.find('.df-cs-content-section.primary').removeClass('active');

				}else{
					element.find('.df-cs-content-section.primary').addClass('active');
					element.find('.df-cs-content-section.secondary').removeClass('active');
				}
			}
		
		} 
    
})(jQuery);
	
				