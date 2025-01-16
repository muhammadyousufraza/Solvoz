(function () {
    df_image_hotspot_init();   
    function df_image_hotspot_init() {
        var selectors = document.querySelectorAll('.difl_imagehotspot');
        [].forEach.call(selectors, function ( selector , index) {
            var optionSettings = JSON.parse(selector.querySelector('.difl_imagehotspot_container').dataset.options);
            var itemSelectors = selector.querySelectorAll('.difl_imagehotspotitem');
            const tooltipStatus = optionSettings.tooltip_enable;  // Check Tooltip is on / off .
            
            var ele_class = selector.classList.value.split(" ").filter(function(class_name){
                return class_name.indexOf('difl_imagehotspot_') !== -1;
            });

            if(itemSelectors && tooltipStatus){
                var options = {
                    arrow: optionSettings.arrow,
                    animation: optionSettings.animation,
                    placement: optionSettings.placement,
                    trigger: optionSettings.trigger,
                    allowHTML: true,
                    followCursor: optionSettings.trigger === 'mouseenter focus' ? optionSettings.followCursor: false,
                    interactive: optionSettings.interactive,
                    interactiveBorder: parseInt(optionSettings.interactiveBorder),
                    interactiveDebounce: parseInt(optionSettings.interactiveDebounce),
                    maxWidth: parseInt(optionSettings.maxWidth),
                    offset:[parseInt(optionSettings.offsetSkidding) , parseInt(optionSettings.offsetDistance)],
                    theme :'.difl_imagehotspot_'+index  // for each module initiat , make different theme         
                    //duration: 1000,
                    // delay: 500,
                    // moveTransition: 'transform 2s ease-out',
                    //showOnCreate: true                
                };
    
                [].forEach.call(itemSelectors, function (itemSelector) {     
                    var child_ele_class = itemSelector.classList.value.split(" ").filter(function(class_name){
                        return class_name.indexOf('difl_imagehotspotitem_') !== -1;
                    });
                    
                    var tooltipContent = df_image_hotspot[ele_class]['toogle_content_data'][child_ele_class[0]];
                    if(tooltipContent === ''){
                        tippy(itemSelector, options).disable();
                    }else{
                        options['content'] =  tooltipContent;
                        //tippy.disableAnimations();
                        tippy(itemSelector, options);
                    }                  
                })
            } 
        });
    }
}())


