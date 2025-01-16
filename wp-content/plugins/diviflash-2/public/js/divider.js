( function(){
    [].forEach.call( document.querySelectorAll('.difl_divider'), function( selector ) {
        var container = selector.querySelector('.difl-divider-container');
        var data = JSON.parse(container.dataset.settings);
        var path = data.path;

        var _lottie = lottie.loadAnimation({
            container: container.querySelector('.difl-divider-lottie-image'), // the dom element that will contain the animation
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
            observer.observe( container.querySelector('.difl-divider-lottie-image') );
        }
        // animation trigger on click
        if( data.animation_trigger === 'on_click' ) {
            container.querySelector('.difl-divider-lottie-image').addEventListener( 'click', function() {
                _lottie.play();
            } )
        }
        // animation trigger on hover
        if( data.animation_trigger === 'on_hover' ) {
            container.querySelector('.difl-divider-lottie-image').addEventListener( 'mouseover', function() {
                _lottie.play();
            } )
            if( data.stop_on_mouse_out === 'on' ) {
                container.querySelector('.difl-divider-lottie-image').addEventListener( 'mouseout', function() {
                    _lottie.pause();
                } )
            }
        }
        // animation trigger none
        if( data.animation_trigger === 'none' ) {
            _lottie.play();
        }

    })
} ) ()