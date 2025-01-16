(function() {
    if ( window.VanillaTilt ) {
        var VanillaTilt = window.VanillaTilt;
        df_tc_init(VanillaTilt);
    }

    function df_tc_init(VanillaTilt) {
        var selectors = document.querySelectorAll('.difl_tiltcard');
        [].forEach.call(selectors, function(selector) {
            var options = JSON.parse(selector.querySelector('.df_tc_container').dataset.options);
            VanillaTilt.init(selector, {
                reverse:                options['reverse'],  // reverse the tilt direction
                max:                    options['max'],     // max tilt rotation (degrees)
                startX:                 0,      // the starting tilt on the X axis, in degrees.
                startY:                 0,      // the starting tilt on the Y axis, in degrees.
                perspective:            options['perspective'],   // Transform perspective, the lower the more extreme the tilt gets.
                scale:                  options['scale'],      // 2 = 200%, 1.5 = 150%, etc..
                speed:                  options['speed'],    // Speed of the enter/exit transition
                transition:             true,   // Set a transition on enter/exit.
                axis:                   null,   // What axis should be disabled. Can be X or Y.
                reset:                  true,    // If the tilt effect has to be reset on exit.
                easing:                 "cubic-bezier(.03,.98,.52,.99)",    // Easing on enter/exit.
                glare:                  options['glare'],   // if it should have a "glare" effect
                "max-glare":            options['glare_opacity'],      // the maximum "glare" opacity (1 = 100%, 0.5 = 50%)
                "glare-prerender":      false,  // false = VanillaTilt creates the glare elements for you, otherwise
                                                // you need to add .js-tilt-glare>.js-tilt-glare-inner by yourself
                "mouse-event-element":  null,    // css-selector or link to HTML-element what will be listen mouse events
                                                // you need to add .js-tilt-glare>.js-tilt-glare-inner by yourself
                gyroscope:              true,    // Boolean to enable/disable device orientation detection,
                gyroscopeMinAngleX:     -45,     // This is the bottom limit of the device angle on X axis, meaning that a device rotated at this angle would tilt the element as if the mouse was on the left border of the element;
                gyroscopeMaxAngleX:     45,      // This is the top limit of the device angle on X axis, meaning that a device rotated at this angle would tilt the element as if the mouse was on the right border of the element;
                gyroscopeMinAngleY:     -45,     // This is the bottom limit of the device angle on Y axis, meaning that a device rotated at this angle would tilt the element as if the mouse was on the top border of the element;
                gyroscopeMaxAngleY:     45,      // This is the top limit of the device angle on Y axis, meaning that a device rotated at this angle would tilt the element as if the mouse was on the bottom border of the element;
                "full-page-listening" : options['tc_full_page']
            })
        });
    }
}())



