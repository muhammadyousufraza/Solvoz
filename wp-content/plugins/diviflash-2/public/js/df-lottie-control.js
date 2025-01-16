( function(){
    [].forEach.call( document.querySelectorAll('.difl_lottieimage'), function( selector ) {
        var container = selector.querySelector('.df-lottie-image-container');
        var data = JSON.parse(container.dataset.options);
        var path = data.path;

        var _lottie = lottie.loadAnimation({
            container: container.querySelector('.df-lottie-image'), // the dom element that will contain the animation
            renderer: data.renderer,
            loop: data.loop,
            autoplay: false,
            path: path // the path to the animation json
        });

        _lottie.setSpeed( parseInt( data.speed ) )

        if( data.direction_reverse === 'on' ) {
            _lottie.setDirection( -1 );
        }

        // animation trigger on viewport
        if( data.animation_trigger === 'viewport' ) {
            observer = new IntersectionObserver(function ( [ item ] ) {
                if( item.isIntersecting ) {
                    item.target.classList.add( 'intersecting' );
                    _lottie.play();
                }
            }, {
                threshold: parseFloat( data.threshold ),
                delay: 100,
                trackVisibility: true,
            });
            observer.observe( container.querySelector('.df-lottie-image') );
        }
        // animation trigger on click
        if( data.animation_trigger === 'on_click' ) {
            container.querySelector('.df-lottie-image').addEventListener( 'click', function() {
                _lottie.play();
            } )
        }
        // animation trigger on hover
        if( data.animation_trigger === 'on_hover' ) {
            container.querySelector('.df-lottie-image').addEventListener( 'mouseover', function() {
                _lottie.play();
            } )
            if( data.stop_on_mouse_out === 'on' ) {
                container.querySelector('.df-lottie-image').addEventListener( 'mouseout', function() {
                    _lottie.pause();
                } )
            }
        }
        // animation trigger none
        if( data.animation_trigger === 'none' ) {
            _lottie.play();
        }

        // animation trigger on_scroll
        if( data.animation_trigger === 'on_scroll' ) {
            let isScrolling;
            let scrollPos = 0;
            let _transform = window.getComputedStyle( selector );
            let _transform_value = '';
            ( data.direction_reverse === 'on' )? _lottie.setDirection( 1 ) : _lottie.setDirection( -1 );
            window.addEventListener( 'scroll', function( event ) {
                const quater = window.innerHeight / 100 * 5;
                const min = quater;
                const max = window.innerHeight - min;
                if((container.getBoundingClientRect()).top > min && (container.getBoundingClientRect()).top < max){
                    if ((document.body.getBoundingClientRect()).top > scrollPos) {
                        ( data.direction_reverse === 'on' ) ? _lottie.setDirection( 1 ) : _lottie.setDirection( -1 );
                    } else {
                        ( data.direction_reverse === 'on' ) ? _lottie.setDirection( -1 ) : _lottie.setDirection( 1 );
                    }
                }

                scrollPos = (document.body.getBoundingClientRect()).top;

                window.clearTimeout( isScrolling );
                if ( data.scroll_effect === 'on' ) {
                    if( _transform.getPropertyValue( 'transform' ) !== _transform_value ) {
                        _lottie.play();
                    }
                } else {
                    _lottie.play();
                }
                
                isScrolling = setTimeout(function() {
                    _lottie.pause();
                    _transform_value = _transform.getPropertyValue( 'transform' );
                }, 30);
            }, false )
        }
    })
} ) ()