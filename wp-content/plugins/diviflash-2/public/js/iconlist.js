jQuery(function ($) {
    // Select all lottie container for lottie image
    $('.difl_iconlistitem').each((index, selector) => {
        if ($(selector).find('.difl_lottie_player.lottie-player-container').length !== 0) {
            try {
                let observer;
                const lottieContainer = selector.querySelector('.difl_lottie_player.lottie-player-container');
                const lottieSrc = !!lottieContainer.dataset && !!lottieContainer.dataset.src ? lottieContainer.dataset.src : '';
                const lottieOptions = !!lottieContainer.dataset && !!lottieContainer.dataset.options ? JSON.parse(lottieContainer.dataset.options) : {};

                // lottieOptions.renderer => data.renderer, lottieOptions.loop => data.loop, lottieSrcAttr => path;
                const _lottie = lottie.loadAnimation({
                    'container': lottieContainer,
                    'renderer': lottieOptions.renderer || 'svg',
                    'loop': lottieOptions.loop || false,
                    'autoplay': false,
                    'path': lottieSrc // the path to the animation json
                });

                // lottieOptions.mouse_out_event => data.speed;
                _lottie.setSpeed(Number.parseFloat(lottieOptions.speed));

                // lottieOptions.direction_reverse => data.direction_reverse;
                if( lottieOptions.direction_reverse === 'on' ) {
                    _lottie.setDirection( -1 );
                }

                // animation trigger on viewport
                // lottieOptions.interaction => data.animation_trigger;
                if (lottieOptions.interaction === 'viewport') {
                    observer = new IntersectionObserver(function ([item]) {
                        if (item.isIntersecting) {
                            item.target.classList.add('intersecting');
                            _lottie.play();
                        }
                    }, {
                        // lottieOptions.delay => data.threshold;
                        threshold: parseFloat(lottieOptions.delay),
                        delay: 100,
                        trackVisibility: true,
                    });
                    observer.observe(lottieContainer);
                }

                // animation trigger on click
                // lottieOptions.interaction => data.animation_trigger;
                // click => on_click;
                if (lottieOptions.interaction === 'click') {
                    lottieContainer.addEventListener('click', function () {
                        _lottie.play();
                    })
                }

                // animation trigger on hover
                // lottieOptions.interaction => data.animation_trigger;
                if (lottieOptions.interaction === 'hover') {
                    lottieContainer.addEventListener('mouseover', function () {
                        _lottie.play();
                    });
                    // lottieOptions.mouse_out_event => data.stop_on_mouse_out;
                    if (lottieOptions.mouse_out_event === 'on') {
                        lottieContainer.addEventListener('mouseout', function () {
                            _lottie.pause();
                        });
                    }
                }


                // animation trigger on_scroll
                // lottieOptions.interaction => data.animation_trigger;
                // scroll => on_scroll;
                if (lottieOptions.interaction === 'scroll') {
                    let isScrolling;
                    let scrollPos = 0;
                    const _transform = window.getComputedStyle(selector);
                    let _transform_value = '';
                    window.addEventListener('scroll', function (event) {

                        if ((document.body.getBoundingClientRect()).top > scrollPos) {
                            // lottieOptions.direction_reverse => data.direction_reverse;
                            if (lottieOptions.direction_reverse === 'on') {
                                _lottie.setDirection(1);
                            } else {
                                _lottie.setDirection(-1);
                            }
                        } else {
                            // lottieOptions.direction => data.direction_reverse;
                            if (lottieOptions.direction_reverse === 'on') {
                                _lottie.setDirection(1);
                            } else {
                                _lottie.setDirection(-1);
                            }
                        }
                        scrollPos = (document.body.getBoundingClientRect()).top;

                        window.clearTimeout(isScrolling);
                        // lottieOptions.scroll_effect => data.scroll_effect;
                        if (lottieOptions.scroll_effect === 'on') {
                            if (_transform.getPropertyValue('transform') !== _transform_value) {
                                _lottie.play();
                            }
                        } else _lottie.play();

                        isScrolling = setTimeout(function () {
                            _lottie.pause();
                            _transform_value = _transform.getPropertyValue('transform');
                        }, 30);
                    }, false)
                }

                // animation trigger none
                // lottieOptions.interaction => data.animation_trigger;
                if (lottieOptions.interaction === 'none') {
                    _lottie.play();
                }
            } catch (e) {
                console.error('AdvancedList:: Lottie could not loaded!!');
            }
        }

        if ($(selector).find('.item-tooltip-data').length !== 0) {
            try {
                const tooltipContainer = $(selector).find('.difl_icon_item_tooltip_content');
                const tooltipOptionsAttr = $(tooltipContainer).attr('data-options');
                let tooltipContent = $(tooltipContainer).html();

                if (!!tooltipOptionsAttr && !!tooltipContent) {
                    const tooltipOptions = JSON.parse(tooltipOptionsAttr);

                    if (tooltipOptions !== {} && tooltipOptions.tooltip_enable) {
                        const itemSelector = $(selector).find('.item-elements')[0];

                        const options = {
                            arrow: tooltipOptions.arrow,
                            animation: tooltipOptions.animation,
                            placement: tooltipOptions.placement,
                            trigger: tooltipOptions.trigger,
                            allowHTML: true,
                            followCursor: tooltipOptions.trigger === 'mouseenter focus' ? tooltipOptions.followCursor : false,
                            interactive: tooltipOptions.interactive,
                            interactiveBorder: parseInt(tooltipOptions.interactiveBorder),
                            interactiveDebounce: parseInt(tooltipOptions.interactiveDebounce),
                            maxWidth: parseInt(tooltipOptions.maxWidth),
                            offset: [parseInt(tooltipOptions.offsetSkidding), parseInt(tooltipOptions.offsetDistance)],
                            theme: `.difl_iconlistitem_${index} difl_icon_item_tooltip`
                        };

                        // replace empty p tag
                        tooltipContent = tooltipContent.replaceAll(/(<p><\/p>|<p>\s*<\/p>)/gi, '')
                        options['content'] = tooltipContent;
                        tippy(itemSelector, options);
                    }
                }
            } catch (e) {
                console.error('AdvancedList:: Tooltip could not loaded!!')
            }
        }
    });
});