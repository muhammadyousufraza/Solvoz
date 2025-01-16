
(function ($, bxSlider) {
    $(document).ready(function(){
        df_init_logo_carousel();
        [ ...document.querySelectorAll( '.difl_logocarouselitem' ) ].filter( li => ! li.querySelector( '.df_lci_container' ) ).forEach( li => li.remove() )
    })
    function df_init_logo_carousel() {
        var container = document.querySelectorAll('.df_lc_container');

        $('.df_lc_container').each(function(index, ele) {
            var _this = $(this);
            var data = JSON.parse(ele.dataset.settings);
            var config = {
                minSlides: parseInt(data.desktop),
                maxSlides: parseInt(data.desktop),
                speed: parseInt(data.speed),
                slideMargin: parseInt(data.spacingbetween),
                slideWidth: parseInt(data.width),
                moveSlides: 1,
                shrinkItems: true,
                responsive: true,
                adaptiveHeight: false,
            }
            if (data.ticker !== 'on') {
                config['infiniteLoop'] = data.loop;
                config['pager'] = data.dots;
                config['controls'] = data.arrows;
                config['pause'] = parseInt(data.auto_delay);
                config['autoHover'] = data.pause_hover;
                config['prevText'] = '4';
                config['nextText'] = '5';
                config['hideControlOnEnd'] = !data.loop;
                config['auto'] = data.autoplay;
            } else {
                config['ticker'] = true;
                config['tickerHover'] = data.ticker_hover;
                config['speed'] = parseInt(data.ticker_speed);
            }

            if ( $(window).width() < 981 ) {
                config['minSlides'] = parseInt(data.tablet);
                config['maxSlides'] = parseInt(data.tablet);
                // console.log( 'tablet' )
            }
            if ( $(window).width() < 768 ) {
                config['minSlides'] = parseInt(data.mobile);
                config['maxSlides'] = parseInt(data.mobile);
            }

            var df_lc_slider = _this.bxSlider(config);

            // on load
            if( inViewport(ele) ){
                df_lc_slider.redrawSlider();
            }else{
                df_lc_slider.stopAuto();
            }

            $(window).scroll(function(){
                df_lc_slider.redrawSlider();

                // on scroll
                if( inViewport(ele) ){
                    df_lc_slider.startAuto();
                }else{
                    df_lc_slider.stopAuto();
                }

            })
            if (data.ticker !== 'on' && data.autoplay) {
                $( ele ).mouseleave( function(){
                    df_lc_slider.startAuto();
                } )
            }
        });

    }

})(jQuery)

function inViewport(selector) {

    const offset = 10;
    const element = selector.getBoundingClientRect();
    const elementTop = Math.round(element.top) + offset;
    const elementBottom = Math.round(element.bottom);

    return elementTop <= window.innerHeight && elementBottom >= 0
}
