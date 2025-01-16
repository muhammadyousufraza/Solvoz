(function () {

    if (ImageCompare) {
        df_cm_init(ImageCompare);

    }


    function df_cm_init(ImageCompareClass) {
       
        // For Add custom css at style.css
        var body = document.body;
        body.classList.add("difl_compareimage");

        var selectors = document.querySelectorAll('.difl_compareimage');
        [].forEach.call(selectors, function (selector) {
            var compareElement = selector.querySelector('.df_cm_content');
            var optionSetttings = JSON.parse(selector.querySelector('.df_cm_container').dataset.options);
            const options = {
                // UI Theme Defaults
                controlColor: optionSetttings.cm_control_color,
                controlShadow: optionSetttings.cm_control_shadow,
                addCircle: optionSetttings.cm_add_circle,
                addCircleBlur: optionSetttings.cm_add_circle_blur,

                // Label Defaults
                showLabels: optionSetttings.cm_enable_show_lebel,
                labelOptions: {
                    before: optionSetttings.cm_before_lebel_text,
                    after: optionSetttings.cm_after_lebel_text,
                    onHover: optionSetttings.cm_level_show_on_hover
                },

                // Smoothing
                smoothing: optionSetttings.cm_smoothing,
                smoothingAmount: optionSetttings.cm_smoothing_amount,

                // Other options
                hoverStart: optionSetttings.cm_control_hover,
                verticalMode: optionSetttings.cm_vertical_mode,
                startingPoint: optionSetttings.cm_sarting_point,
                fluidMode: false
            };
            const viewer = new ImageCompareClass(compareElement, options);
            viewer.mount();

        });
    }
}())



