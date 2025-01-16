(function(){
    var difl_testimonialcarousel = document.querySelectorAll('.difl_contentcarousel');
    [].forEach.call(difl_testimonialcarousel, function(ele, index) {
        const container = ele.querySelector('.df_cc_container');
        const data = JSON.parse(container.dataset.settings);
        const selector = ele.querySelector('.swiper-container');

        const item_spacing_tablet = '' !== data.item_spacing_tablet ? data.item_spacing_tablet : data.item_spacing;
        const item_spacing_phone = '' !== data.item_spacing_phone ? data.item_spacing_phone : item_spacing_tablet;

        // custom breakpoints
        const desktopBreakpoint = window.matchMedia('(min-width: 992px)').matches;
        const tabletBreakpoint = window.matchMedia('screen and (min-width: 401px) and (max-width: 768px)').matches;
        const mobileBreakpoint = window.matchMedia('screen and (max-width: 400px)').matches;

        var config = {
            speed: parseInt(data.speed),
            autoplay: false,
            loop: data.loop,
            effect: data.effect,
            centeredSlides: data.centeredSlides === 'on' ? true : false,
            threshold: 15,
            slideClass: 'difl_contentcarouselitem',
            observer: true,
            observeParents: true,
            observeSlideChildren: true,
            watchSlidesVisibility: true,
            preventClicks : true,
            preventClicksPropagation: true,
            slideToClickedSlide: false,

            breakpoints: {
                // desktop
                981: {
                    slidesPerView: data.desktop,
                    spaceBetween : parseInt(data.item_spacing)
                },
                // tablet
                768: {
                    slidesPerView: data.tablet,
                    spaceBetween : parseInt(item_spacing_tablet)
                },
                // mobile
                1: {
                    slidesPerView: data.mobile,
                    spaceBetween : parseInt(item_spacing_phone)
                },
            }
        };

        if (data.effect === 'coverflow') {
            config['coverflowEffect'] = {
                slideShadows: data.slideShadows === 'on' ? true : false,
                rotate: parseInt(data.rotate),
                stretch: parseInt(data.stretch),
                depth: parseInt(data.depth),
                modifier: parseInt(data.modifier)
            };
        }

        if (('off' === data.autoplay && desktopBreakpoint)
            || ('off' === data.autoplay_tablet && tabletBreakpoint)
            || ('off' === data.autoplay_phone && mobileBreakpoint)) {
            config['autoplay'] = false
        }

        if ('on' === data.autoplay && desktopBreakpoint) {
            config['autoplay'] = {
                delay : data.auto_delay,
                disableOnInteraction: false
            }
        }

        if ('on' === data.autoplay_tablet && tabletBreakpoint) {
            config['autoplay'] = {
                delay: parseInt(data.auto_delay_tablet),
                disableOnInteraction: false
            }
        }

        if ('on' === data.autoplay_phone && mobileBreakpoint) {
            config['autoplay'] = {
                delay: parseInt(data.auto_delay_phone),
                disableOnInteraction: false
            }
        }

        // arrow navigation
        if (data.arrow === 'on') {
            config['navigation'] = {
                nextEl: '.cc-next-'+data.order,
                prevEl: '.cc-prev-'+data.order
            }
        }
        // dots pagination
        if (data.dots === 'on') {
            config['pagination'] = {
                el: '.cc-dots-'+data.order,
                type: 'bullets',
                clickable: true
            }
        }


        if (typeof Swiper === 'function') {
            var slider = new Swiper (selector, config);

            setTimeout(function () {
                slider.update(true);
            }, 500);

            // pause on hover
            const pauseOnHoverDesktop = 'on' === data.autoplay && 'on' === data.pause_hover && desktopBreakpoint;
            const pauseOnHoverTablet = 'on' === data.autoplay_tablet && 'on' === data.pause_hover_tablet && tabletBreakpoint;
            const pauseOnHoverphone = 'on' === data.autoplay_phone && 'on' === data.pause_hover_phone && mobileBreakpoint;

            if (pauseOnHoverDesktop || pauseOnHoverTablet || pauseOnHoverphone) {
                selector.addEventListener("mouseover", function(){
                    slider.autoplay.stop();
                })
                selector.addEventListener("mouseout", function(){
                    slider.autoplay.start();
                })
            }

            if (('on' === data.autoplay && desktopBreakpoint && slider)
                || ('on' === data.autoplay_tablet && tabletBreakpoint && slider)
                || ('on' === data.autoplay_phone && mobileBreakpoint && slider)) {
                document.addEventListener('scroll', () => {
                    handleAutoplay(selector, slider);
                });

                handleAutoplay(selector, slider);
            }
        }
        // pointer event
        df_cc_handle_mouseover_event(ele);
        // use lightbox
        df_cc_use_lightbox(
            container.querySelector('.swiper-wrapper'),
            {
                cc_lightbox : data.use_lightbox
            }
        );
    })
})()
function df_cc_use_lightbox(selector, options) {
    if (options.cc_lightbox === 'on') {
        var settings = {
            selector: '.df_cci_container',
            subHtmlSelectorRelative: true,
            addClass: 'df_cc_lightbox',
            counter: false,
            download: options.download
        };

        lightGallery(selector, settings);
    }
}
function df_cc_handle_mouseover_event(ele) {
    const hover_class = 'df-ele-hover';
    let class_list = ele.classList;

    ele.addEventListener('mouseleave', function(event) {
        if(class_list.contains(hover_class)) {
            setTimeout(function(){
                ele.classList.remove(hover_class);
            }, 3000);
        }
    })

    ele.addEventListener('mouseenter', function(event) {
        if( !ele.classList.contains(hover_class) ) {
            ele.classList.add(hover_class);
        }
    })
}

function inViewport(selector) {

    const offset = 10;
    const element = selector.getBoundingClientRect();
    const elementTop = Math.round(element.top) + offset;
    const elementBottom = Math.round(element.bottom);

    return elementTop <= window.innerHeight && elementBottom >= 0
}

function handleAutoplay(selector, swiper) {
    if ( inViewport(selector) ) {
        swiper.autoplay.start();

        return;
    }

    swiper.autoplay.stop();
}
