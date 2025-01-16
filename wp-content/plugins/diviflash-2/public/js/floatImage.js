(function(){
    df_fi_animation(document.querySelectorAll('.difl_floatimage .df_fii_container'));

    function df_fi_animation(selectors) {
        [].forEach.call(selectors, function(selector) {
            var data = JSON.parse(selector.dataset.animation)
            if ( window.anime ) {
                var object = {
                    targets: selector,
                    loop: true,
                    direction: 'alternate',
                    // easing: 'linear'
                };
                
                if (data.animation_type === "fi-up-down") {
                    object.translateY = data.vertical_anime_distance;
                } else if (data.animation_type === "fi-left-right") {
                    object.translateX = data.horizontal_anime_distance;
                }

                object.easing = data.animation_function;
                object.duration = data.duration;
                object.delay = 0;
    
                setTimeout(function () {
                    window.anime(object)
                }, parseInt(data.delay));
            }
        })
    } 
})()