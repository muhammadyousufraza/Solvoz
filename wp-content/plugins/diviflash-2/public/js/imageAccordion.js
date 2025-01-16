(function ($) {

    var df_image_accordion = document.querySelectorAll('.difl_imageaccordion');

    [].forEach.call(df_image_accordion, function (ele, index) {
        var container = ele.querySelector('.df_ia_container');

        var settings = JSON.parse(container.dataset.settings);

        var animation_settings = JSON.parse(container.dataset.animation); //_this.find('.df_ia_container').data().animation;

        var ele_class = ele.classList.value.split(" ").filter(function(class_name){
            return class_name.indexOf('difl_imageaccordion_') !== -1;
        });
        var itemSelector = '.'+ ele_class[0]+ ' .difl_imageaccordionitem';
        callEventFunction(itemSelector, settings, animation_settings);
        if (settings.active_item !== '') {
            var active_item_order = ':eq(' + (settings.active_item - 1) + ')';
            $(itemSelector + active_item_order).addClass("df_ia_active");
            $(itemSelector + active_item_order).find('.content').css('opacity', 1);
        }
        if (settings.outer_click_close_item === 'on') {
            $(document).on('click', function (e) {
                var container = $(itemSelector).parent();
                if (!$(e.target).closest(container).length) {
                    $(itemSelector).removeClass("df_ia_active");
                    df_content_visibility(itemSelector, 0, 'hidden');
                }
            });
        }
    });

    function df_accordion_anime(selector, animation_settings) {
        var object = {
            targets: selector,
            easing: animation_settings.animation_function,
            duration: parseInt(animation_settings.duration),
            endDelay: 1,
            delay: parseInt(animation_settings.delay),
            begin: function (anim) {
                if (document.querySelector(selector))
                    document.querySelector(selector).style.visibility = 'visible';
            },
        };

        if (animation_settings.enable_stagger === 'on') {
            object.delay = anime.stagger(parseInt(animation_settings.stagger));
        }

        var anime_config = Object.assign(object, animations[animation_settings.content_animation]);

        if (window.anime) {
            window.anime(anime_config);
        }
    }

    function callEventFunction(itemSelector, settings, animation_settings) {
        jQuery(itemSelector + ':not(".df_ia_active")').on(settings.event_type, function (event) {
            if (!$(event.target).closest('.df_ia_button').length) {
                event.stopPropagation();
                event.preventDefault();
                if (!$(this).hasClass("df_ia_active")) {
                    jQuery(itemSelector).removeClass('df_ia_active');
                    df_content_visibility(itemSelector, 0, 'hidden');
                    jQuery(this).addClass('df_ia_active');
    
                    if (animation_settings.enable_animation === 'on') {
                        if (animation_settings.enable_stagger === 'on') {
                            jQuery(this).addClass('df_ia_active');
                            df_content_visibility(this, 1, 'visible');
                        }
    
                        var anime_selector = animation_settings.enable_stagger === 'on' ?
                            //`${itemSelector}.df_ia_active .content .anime_wrap` : `${itemSelector}.df_ia_active .content`;
                            itemSelector + '.df_ia_active .content .anime_wrap' : itemSelector + '.df_ia_active .content';
                        df_accordion_anime(
                            anime_selector,
                            animation_settings
                        );
                    } else {
                        df_content_visibility(this, 1, 'visible');
                    }
    
                }
            }
        })

    }

    function df_content_visibility(selector, opacity, visibility) {
        jQuery(selector).find('.content').css('opacity', opacity);
        jQuery(selector).find('.content').css('visibility', visibility);
    }

    var animations = {
        slide_right: {
            opacity: ['0', '1'],
            translateX: ['-100px', '0']
        },
        slide_left: {
            opacity: ['0', '1'],
            translateX: ['100px', '0']
        },
        slide_down: {
            opacity: ['0', '1'],
            translateY: ['-100px', '0']
        },
        slide_up: {
            opacity: ['0', '1'],
            translateY: ['100px', '0']
        },
        fade_in: {
            opacity: ['0', '1'],
        },
        zoom_right: {
            opacity: ['0', '1'],
            scale: ['.5', '1'],
            transformOrigin: ['0% 50%', '0% 50%'],
        },
        zoom_center: {
            opacity: ['0', '1'],
            scale: ['.5', '1'],
            transformOrigin: ['50% 50%', '50% 50%'],
        },
        zoom_left: {
            opacity: ['0', '1'],
            scale: ['.5', '1'],
            transformOrigin: ['100% 50%', '100% 50%'],
        }
    }

})(jQuery)