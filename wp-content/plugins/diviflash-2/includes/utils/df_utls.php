<?php
if ( ! class_exists( 'ET_Builder_Element' ) ) {
	return;
}
require_once ( DIFL_MAIN_DIR . '/includes/utils/df_background.php');
require_once ( DIFL_MAIN_DIR . '/includes/utils/df_process_bg.php');
require_once ( DIFL_MAIN_DIR . '/includes/utils/df_button.php');

trait DF_UTLS {
    use DF_Background;
    public $button;

    /**
     * render pattern or mask markup
     * 
     */
    function df_render_pattern_or_mask_html( $props, $type ) {
        $html = array(
            'pattern' => '<span class="et_pb_background_pattern"></span>',
            'mask' => '<span class="et_pb_background_mask"></span>'
        );
        return $props == 'on' ? $html[$type] : '';
    }

    /**
     * Add button settings
     * 
     * @param Array $options
     * @return Array of settings
     */
    function df_add_btn_content($options = []) {

        if (empty($this->button)) {
            $this->button = new DF_BUTTON($this);
        }
        return $this->button->get_content_fields($options);
    }

    /**
     * Add Button Style settings
     * 
     * @param Array $options
     * @return Array of settings
     */
    function df_add_btn_styles($options = []) {

        if (empty($this->button)) {
            $this->button = new DF_BUTTON($this);
        }
        return $this->button->get_style_fields($options);
    }
    
    /**
     * Process Button Styles
     * 
     * @param Array $options
     * @return Void
     */
    function df_process_btn_styles($options = []) {
        $this->button->process_btn_styles($options);
    }
    /**
     * Add margin and padding fields
     * 
     */
    function df_margin_padding(&$fields, $options, $type ) {
        // $options = array(
        //     'title'         => 'Button',
        //     'key'           => 'button',
        //     'toggle_slug'   => 'custom_spacing',
        //     'show_if'       => array(
        //         'type'      => 'button'
        //     )
        // );
        $key = $options['key'] . '_' . $type;
 
        $fields[$key] = array(
            'label'				=> sprintf(esc_html__('%1$s %2$s', 'divi_flash'), $options['title'], ucwords($type)),
            'type'				=> 'custom_margin',
            'toggle_slug'       => $options['toggle_slug'],
            'sub_toggle'		=> $options['sub_toggle'],
            'default'           => $options['default_'.$type], // default value set using margin/padding type 
            'tab_slug'			=> $options['tab_slug'],
            'mobile_options'    => true,
            'hover'				=> 'tabs',
            'priority' 			=> $options['priority'],
        );
        $fields[$key . '_tablet'] = array(
            'type'            	=> 'skip',
            'tab_slug'        	=> $options['tab_slug'],
            'toggle_slug'		=> $options['toggle_slug'],
            'sub_toggle'		=> $options['sub_toggle']
        );
        $fields[$key.'_phone'] = array(
            'type'            	=> 'skip',
            'tab_slug'        	=> $options['tab_slug'],
            'toggle_slug'		=> $options['toggle_slug'],
            'sub_toggle'		=> $options['sub_toggle']
        );
        $fields[$key.'_last_edited'] = array(
            'type'            	=> 'skip',
            'tab_slug'        	=> $options['tab_slug'],
            'toggle_slug'		=> $options['toggle_slug'],
            'sub_toggle'		=> $options['sub_toggle']
        );
        // added in version 1.0.5
        if(isset($options['show_if'])) {
            $fields[$key]['show_if'] = $options['show_if'];
        }
    }
    function add_margin_padding( $options = array() ) {
        $margin_padding = array();
        $default = array(
            'title'         => '',
            'key'           => '',
            'toggle_slug'   => '',
            'sub_toggle'    => null,
            'tab_slug'      => 'advanced',
            'default_padding' => '',
            'default_margin'  => '',
            'option'        => 'both',
            'priority'      => 30
        );
        $args = wp_parse_args( $options, $default );

        if ( $args['option'] === 'both' || $args['option'] === 'margin' ) {
            $this->df_margin_padding($margin_padding, $args, 'margin');
        }
        if ( $args['option'] === 'both' || $args['option'] === 'padding' ) {
            $this->df_margin_padding($margin_padding, $args, 'padding');
        }
        return $margin_padding;
    }

    /**
     * Add Custom transition options
     * 
     * @param Array $options
     * @return Array $fields
     */
    function df_transition_options($options = []) {
        $fields = array ();
        $default = array (
            'key'               => '',
            'toggle_slug'       => '',
            'sub_toggle'        => '',
            'tab_slug'          => 'general',
            'default_unit'      => 'ms',
            'allowed_units'     => array ('ms'),
            'duration_default'  => '300ms',
            'mobile_options'    => false,
            'show_if'           => null,
            'show_if_not'       => null,
        );
        $args = wp_parse_args( $options, $default );
        extract($args); // phpcs:ignore WordPress.PHP.DontExtract

        $fields[$key . '_transition_duration'] = array (
            'label'             => esc_html__( 'Transition Duration', 'divi_flash' ),
				'type'              => 'range',
                'toggle_slug'       => $toggle_slug,
                'tab_slug'          => $tab_slug,
				'default'           => $duration_default,
                'default_unit'      => $default_unit,
                'allowed_units'     => $allowed_units,
                'mobile_options'    => $mobile_options,
				'range_settings'    => array(
					'min'  => '0',
					'max'  => $default_unit === 'ms' ? '2000' : '100',
					'step' => $default_unit === 'ms' ? '50' : '1',
                ),
                'show_if'             => $show_if,
                'show_if_not'         => $show_if_not,
        );
        $fields[$key . '_transition_delay'] = array (
            'label'             => esc_html__( 'Transition Delay', 'divi_flash' ),
				'type'              => 'range',
                'toggle_slug'       => $toggle_slug,
                'tab_slug'          => $tab_slug,
				'default'           => '0ms',
                'default_unit'      => 'ms',
                'allowed_units'     => array ('ms'),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '300',
					'step' => '50',
                ),
                'show_if'             => $show_if,
                'show_if_not'         => $show_if_not
        );
        $fields[$key . '_transition_curve'] = array (
            'default'         => 'ease_in_out',
            'label'           => esc_html__( 'Transition Speed Curve', 'divi_flash' ),
            'type'            => 'select',
            'options'         => array(
                'ease'          => esc_html__( 'Ease', 'divi_flash' ),
                'ease_in'       => esc_html__( 'Ease In', 'divi_flash' ),
                'ease_in_out'   => esc_html__( 'Ease In Out', 'divi_flash' ),
                'ease_out'      => esc_html__( 'Ease Out', 'divi_flash' ),
                'linear'        => esc_html__( 'Linear', 'divi_flash' ),
                'bounce'        => esc_html__( 'Bounce', 'divi_flash')
            ),
            'toggle_slug'     => $toggle_slug,
            'tab_slug'        => $tab_slug,
            'show_if'             => $show_if,
            'show_if_not'         => $show_if_not
        );

        return $fields;
    }

    /**
     * Process custom transition
     * 
     * @param Array of settings
     * @return Void
     */
    function df_process_transition($options = []) {
        $default = array(
            'render_slug'       => '',
            'slug'              => '',
            'selector'          => '',
            'properties'        => [],
            'important'         => false
        );
        $options = wp_parse_args( $options, $default );
        extract($options); // phpcs:ignore WordPress.PHP.DontExtract

        $transition = '';

    

        $transition_fn = $this->df_transition($this->props[$slug . '_transition_curve']);
        $transition_delay = $this->props[$slug . '_transition_delay'];
        $transition_duration = $this->props[$slug . '_transition_duration'];
       
        $t = sprintf('%1$s %2$s %3$s',$transition_duration, $transition_fn, $transition_delay);

        for ( $i = 0; $i < count($properties); $i++ ) {
            $s = ($i+1) !== count($properties) ? ',' : '';
            $transition .= $properties[$i] . ' ' . $t . $s;
        }

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('transition:%1$s;', $transition)
        ));
    }

    /**
     * Add icon settings options
     * 
     * @param Array of settings
     * @return Array of settings fields
     */
    function df_add_icon_settings($options = array()) {
        $fields = array ();
        $default = array (
            'title'             => '',
            'image_title'       => '',
            'title_prefix'      => '',
            'key'               => '',
            'toggle_slug'       => '',
            'sub_toggle'        => '',
            'tab_slug'          => 'general',
            'default_size'      => '18px',
            'image'             => true,
            'image_alt'         => false,
            'on_off'            => true,
            'icon'              => true,
            'icon_color'        => true,
            'icon_size'         => true,
            'icon_alignment'    => false,
            'icon_bg'           => false,
            'circle_icon'       => false,
            'hover'             => false,
            'image_styles'      => false,
            'img_toggle'        => '',
            'img_sub'           => '',
            'img_tab'           => '',
            'max_width'         => false,
            'dynamic_option'    => false
        );
        $args = wp_parse_args( $options, $default );
        extract($args); // phpcs:ignore WordPress.PHP.DontExtract

        $prefix = $key . '_';

        $button_text = $title !== '' ? $title : 'Use Icon';
        $image_title = $image_title !== '' ? $image_title : 'Image';

        // image
        if ($image === true) {
            $fields[$prefix.'image'] = array (
                'label'                 => esc_html__( $image_title, 'divi_flash' ),
				'type'                  => 'upload',
				'upload_button_text'    => esc_attr__( 'Upload an image', 'divi_flash' ),
				'choose_text'           => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'           => esc_attr__( 'Set As Image', 'divi_flash' ),
                'toggle_slug'           => $toggle_slug,
                'tab_slug'              => $tab_slug,
                'depends_show_if_not'   => 'on',
                'dynamic_content'   => $dynamic_option ? 'image': ''
            );
            if($image_alt === true) {
                $fields[$prefix . 'alt_text'] = array (
                    'label'                 => esc_html__( 'Image Alt Text', 'divi_flash' ),
                    'type'                  => 'text',
                    'toggle_slug'           => $toggle_slug,
                    'depends_show_if_not'   => 'on'
                );
            } 
        }
        // show on/off button
        if ($on_off === true) {
            $fields[$prefix.'use_icon'] = array(
				'label'                 => esc_html__( $button_text, 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => $toggle_slug,
                'tab_slug'              => $tab_slug,
				'affects'               => array (
                    $prefix.'font_icon',
                    $prefix.'icon_color',
                    $prefix.'icon_size',
                    $prefix.'image',
                    $prefix.'icon_align',
                    $prefix.'icon_bg',
                    $prefix.'circle_icon',
                    $prefix . 'alt_text'
				)
			);
        }
        // icon select box
        if ($icon === true) {
            $fields[$prefix.'font_icon'] = array(
				'label'                 => esc_html__( 'Icon', 'divi_flash' ),
				'type'                  => 'select_icon',
				'option_category'       => 'basic_option',
				'class'                 => array( 'et-pb-font-icon' ),
                'toggle_slug'           => $toggle_slug,
                'tab_slug'              => $tab_slug,
                'depends_show_if'       => 'on'
			);
        }
        // icon color
        if ($icon_color === true) {
            $fields[$prefix.'icon_color'] = array (
				'default'           => "#2ea3f2",
				// 'default_on_front'	=> true,
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
				'tab_slug'          => $tab_slug,
                'toggle_slug'       => $toggle_slug,
                'hover'             => 'tabs'
                // 'mobile_options'    => true,
                // 'responsive'        => true
			);
        }
        // icon size
        if ($icon_size === true) {
            $fields[$prefix.'icon_size'] = array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'tab_slug'          => $tab_slug,
				'toggle_slug'       => $toggle_slug,
				'default'           => $default_size,
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
				'responsive'        => true
            );
        }
        // icon alignment
        if ($icon_alignment === true) {
            $fields[$prefix.'icon_align'] = array (
                'label'             => esc_html__( 'Icon Align', 'divi_flash' ),
				'type'              => 'text_align',
				'options'           => et_builder_get_text_orientation_options(array('justified')),
				'tab_slug'          => $tab_slug,
                'toggle_slug'       => $toggle_slug,
                'depends_show_if'   => 'on',
            );
        }
        // image alignment
        if ($image_styles === true) {
            $fields[$prefix.'image_align'] = array (
                'label'             => esc_html__( 'Image Alignment', 'divi_flash' ),
				'type'              => 'text_align',
				'options'           => et_builder_get_text_orientation_options(array('justified')),
				'tab_slug'          => $img_tab,
                'toggle_slug'       => $img_toggle,
                'depends_show_if_not'=> 'on',
            );
            $fields[$prefix.'full_width']    = array (
                'label'             => esc_html__('Force Full Width', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'           => 'off',
                'tab_slug'          => $img_tab,
                'toggle_slug'       => $img_toggle,
                'affects'           => array (
                    $prefix.'image_align'
				)
            );
            if ($max_width === true) {
                $fields[$prefix.'max_width'] = array(
                    'label'             => esc_html__( 'Max Width', 'divi_flash' ),
                    'type'              => 'range',
                    'toggle_slug'       => $img_toggle,
                    'tab_slug'          => $img_tab,
                    'default'           => '100%',
                    'default_unit'      => '%',
                    'default_on_front'  => '100%',
                    'responsive'        => true,
                    'mobile_options'    => true,
                    'range_settings'    => array(
                        'min'  => '1',
                        'max'  => '100',
                        'step' => '1',
                    ),
                    'show_if_not'       => array(
                        $prefix.'full_width' => 'on'
                    )
                );
            }
        }
        // icon color
        if ($icon_bg === true) {
            $fields[$prefix.'icon_bg'] = array (
				'default'           => "rgba(0,0,0,0)",
				'label'             => esc_html__( 'Icon Background', 'divi_flash' ),
				'type'              => 'color-alpha',
				'depends_show_if'   => 'on',
				'tab_slug'          => $tab_slug,
                'toggle_slug'       => $toggle_slug,
                'hover'             => 'tabs',
                'depends_show_if'   => 'on'
			);
        }
        // circle icon
        if ($circle_icon === true) {
            $fields[$prefix.'circle_icon'] = array(
				'label'                 => esc_html__( 'Circle Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => $toggle_slug,
                'tab_slug'              => $tab_slug,
                'depends_show_if'       => 'on'
			);
        }
        // adding hover options
        if ( $hover === true ) {
            foreach( $fields as $field => $value) {
                if ( $field !== $prefix.'use_icon' )
                    $fields[$field]['hover'] = 'tabs';
            }
        }
        if ( $sub_toggle !== '' ) {
            foreach( $fields as $field => $value) {
                $fields[$field]['sub_toggle'] = $sub_toggle;
            }
        }
        
        return $fields;
    }

    /**
     * add max-width settings with alignment
     * 
     * @param Array $options
     * @return Array of settins
     */
    function df_add_max_width($options = array()){
        $default = array(
            'title_pefix'           => '',
            'key'                   => '',
            'toggle_slug'           => '',
            'sub_toggle'            => null,
            'alignment'             => false,
            'priority'              => 30,
            'tab_slug'              => 'general',
            'show_if'               => array(),
            'alignment_show_not'    => array()
        );
        $args = wp_parse_args( $options, $default );
        extract($args); // phpcs:ignore WordPress.PHP.DontExtract
        $fields = array();
        $max_width = $key . '_maxwidth';
        $fields[$max_width] = array(
            'label'             => esc_html__( 'Max Width', 'divi_flash' ),
            'type'              => 'range',
            'toggle_slug'       => $toggle_slug,
            'sub_toggle'        => $sub_toggle,
            'tab_slug'          => $tab_slug,
            'default'           => '100%',
            'default_unit'      => '%',
            'default_on_front'  => '100%',
            'hover'             => 'tabs',
            'responsive'        => true,
            'mobile_options'    => true,
            'range_settings'    => array(
                'min'  => '1',
                'max'  => '100',
                'step' => '1',
            ),
        );
        if (!empty($show_if)) {
            $fields[$max_width]['show_if'] = $show_if;
        }
        if ($alignment === true) {
            $alignment_key = $key . '_alignment';
            $fields[$alignment_key] = array(
                'label'             => esc_html__( 'Alignment', 'divi_flash' ),
                'type'              => 'text_align',
                'toggle_slug'       => $toggle_slug,
                'sub_toggle'        => $sub_toggle,
                'tab_slug'          => $tab_slug,
                'mobile_options'   => true,
                'options'           =>  et_builder_get_text_orientation_options( array( 'justified' ) ),
            );
            if (!empty($show_if)) {
                $fields[$alignment_key]['show_if'] = $show_if;
            }
        }

        return $fields;
    }
    
    /**
     * Add text clip settings
     * 
     * @param Array $options
     * @return Array $fields
     */
    function df_text_clip($options = array()) {
        $default = array(
            'title_pefix'           => '',
            'key'                   => '',
            'toggle_slug'           => '',
            'sub_toggle'            => null,
            'priority'              => 30,
            'tab_slug'              => 'general'
        );
        $args = wp_parse_args( $options, $default );
        extract($args); // phpcs:ignore WordPress.PHP.DontExtract
        $fields = array();
        $fields[$key . '_enable_clip'] = array(
            'label'             => esc_html__( 'Enable Clip', 'divi_flash' ),
            'type'              => 'yes_no_button',
            'options'           => array(
                'off' => esc_html__( 'No', 'divi_flash' ),
                'on'  => esc_html__( 'Yes', 'divi_flash' ),
            ),
            'default'           => 'off',
            'toggle_slug'       => $toggle_slug,
            'tab_slug'          => $tab_slug
        );
        $fields[$key . '_enable_bg_clip'] = array(
            'label'             => esc_html__( 'Enable Background Clip', 'divi_flash' ),
            'type'              => 'yes_no_button',
            'options'           => array(
                'off' => esc_html__( 'No', 'divi_flash' ),
                'on'  => esc_html__( 'Yes', 'divi_flash' ),
            ),
            'default'           => 'off',
            'toggle_slug'       => $toggle_slug,
            'tab_slug'          => $tab_slug,
            'show_if'           => array(
                $key . '_enable_clip'       => 'on'
            )
        );
        $fields[$key . '_fill_color'] = array(
            'label'             => esc_html__( 'Fill Color', 'divi_flash' ),
            'type'              => 'color-alpha',
            'toggle_slug'       => $toggle_slug,
            'tab_slug'          => $tab_slug,
            'hover'             => 'tabs',
            'default'           => 'rgba(255,255,255,0)',
            'show_if'           => array(
                $key . '_enable_clip'       => 'on'
            )
        );
        $fields[$key . '_stroke_color'] = array(
            'label'             => esc_html__( 'Stroke Color', 'divi_flash' ),
            'type'              => 'color-alpha',
            'toggle_slug'       => $toggle_slug,
            'tab_slug'          => $tab_slug,
            'hover'             => 'tabs',
            'show_if'           => array(
                $key . '_enable_clip'       => 'on'
            )
        );
        $fields[$key . '_stroke_width'] = array(
            'label'             => esc_html__( 'Stroke Width', 'divi_flash' ),
            'type'              => 'range',
            'toggle_slug'       => $toggle_slug,
            'tab_slug'          => $tab_slug,
            'default'           => '1px',
            'hover'             => 'tabs',
            'mobile_options'    => true,
            'default_unit'      => 'px',
            'default_on_front'  => '',
            'range_settings'    => array(
                'min'  => '1',
                'max'  => '100',
                'step' => '1',
            ),
            'show_if'           => array(
                $key . '_enable_clip'       => 'on'
            )
        );
        return $fields;
    }

    /**
     * Process Text Clip styles
     * 
     * @param Array $options
     * @return Void
     */
    function df_process_text_clip($options = array()) {
        $default = array(
            'render_slug'       => '',
            'slug'              => '',
            'selector'          => '',
            'hover'             => '',
            'alignment'         => false,
            'important'         => true
        );
        $options        = wp_parse_args( $options, $default );
        extract($options); // phpcs:ignore WordPress.PHP.DontExtract
        if ($this->props[$slug . '_enable_clip'] === 'on') {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => $slug.'_fill_color',
                'type'              => '-webkit-text-fill-color',
                'selector'          => $selector,
                'hover'             => $hover
            ));
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => $slug.'_stroke_color',
                'type'              => '-webkit-text-stroke-color',
                'selector'          => $selector,
                'hover'             => $hover
            ));
            $this->apply_single_value(array(
                'render_slug'       => $render_slug,
                'slug'              => $slug.'_stroke_width',
                'type'              => '-webkit-text-stroke-width',
                'selector'          => $selector,
                'unit'              => 'px',
                'hover'             => $hover,
                'default'           => '1'
            ));
            if ($this->props[$slug . '_enable_bg_clip'] === 'on') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $selector,
                    'declaration' => '-webkit-background-clip: text;'
                ));
            }
        }
    }

    /**
     * Process string attr
     */
    function df_process_string_attr($options = array()) {
        $default = array(
            'render_slug'       => '',
            'slug'              => '',
            'type'              => '',
            'selector'          => '',
            'hover'             => '',
            'important'         => false,
            'default'           => ''
        );
        $options        = wp_parse_args( $options, $default );
        extract($options); // phpcs:ignore WordPress.PHP.DontExtract
        $desktop  =  !empty($this->props[$slug]) ? 
            $this->df_process_values($this->props[$slug]) : $default;
        $tablet   =  !empty($this->props[$slug.'_tablet']) ? 
            $this->df_process_values($this->props[$slug.'_tablet']) : $desktop;
        $phone   =  !empty($this->props[$slug.'_phone']) ? 
            $this->df_process_values($this->props[$slug.'_phone']) : $tablet;
        $important_opt = $important === true ? '!important' : '';

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('%1$s:%2$s %3$s;', $type, $desktop, $important_opt),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('%1$s:%2$s %3$s;', $type, $tablet,$important_opt),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('%1$s:%2$s %3$s;', $type, $phone,$important_opt),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
    }

    /**
     * Process icon settings
     * 
     * @param Array $options
     * @return Void
     */
    function process_icon_styles($options=array()) {
        $default = array(
            'render_slug'       => '',
            'slug'              => '',
            'selector'          => '',
            'hover'             => '',
            'align_container'   => '',
            'image_selector'    => '',
            'important'         => false
        );
        $options = wp_parse_args( $options, $default );
        extract($options); // phpcs:ignore WordPress.PHP.DontExtract

        if ($this->props[$slug . '_use_icon'] === 'on') {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => $slug.'_icon_color',
                'type'              => 'color',
                'selector'          => $selector,
                'hover'             => $hover
            ));
            $this->apply_single_value(array(
                'render_slug'       => $render_slug,
                'slug'              => $slug . '_icon_size',
                'type'              => 'font-size',
                'selector'          => $selector,
                'unit'              => 'px',
                'hover'             => $hover,
                'default'           => '48'
            ));
        }
        
        // icon alignment
        if (isset($this->props[$slug . '_icon_align']) && $this->props[$slug . '_use_icon'] === 'on') {
            $align = $this->props[$slug . '_icon_align'] !== '' ? $this->props[$slug . '_icon_align'] : 'left';
            $align_container = $align_container !== '' ? $align_container : $selector;

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $align_container,
                'declaration' => sprintf('text-align:%1$s;', $align)
            ));
        }
        // image styles
        if (isset($this->props[$slug . '_image']) && $this->props[$slug . '_use_icon'] !== 'on' && $this->props[$slug . '_image'] !== '') {
            $image_align = $this->props[$slug . '_image_align'] !== '' ? $this->props[$slug . '_image_align'] : 'left';
            $align_container = $align_container !== '' ? $align_container : $image_selector;

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $align_container,
                'declaration' => sprintf('text-align:%1$s;', $image_align)
            ));
            if ( isset($this->props[$slug . '_full_width']) && $this->props[$slug . '_full_width'] === 'on') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $image_selector,
                    'declaration' => 'width:100%;'
                ));
            }
            if ( isset($this->props[$slug . '_max_width']) && $this->props[$slug . '_full_width'] !== 'on') {
                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => $slug . '_max_width',
                    'type'              => 'max-width',
                    'selector'          => $image_selector,
                    'unit'              => '%'
                ));
            }
        }
        // icon background
        if (isset($this->props[$slug . '_icon_bg']) && $this->props[$slug . '_icon_bg'] !== '') {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => $slug.'_icon_bg',
                'type'              => 'background-color',
                'selector'          => $selector,
                'hover'             => $hover
            ));
        }
        // circle icon
        if (isset($this->props[$slug . '_circle_icon']) && $this->props[$slug . '_circle_icon'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $selector,
                'declaration' => 'border-radius:50%;'
            ));
        }
    }

    /**
     * Process max-width and alignment values
     * 
     * @param Array $option
     * @return Void
     */
    function df_process_maxwidth($options = array()) {
        $default = array(
            'render_slug'       => '',
            'slug'              => '',
            'selector'          => '',
            'hover'             => '',
            'alignment'         => false,
            'important'         => true
        );
        $options        = wp_parse_args( $options, $default );
        extract($options); // phpcs:ignore WordPress.PHP.DontExtract
        $max_width = $slug . '_maxwidth';
        $desktop = $this->props[$max_width];
        $tablet = $this->df_check_values($desktop, $this->props[$max_width.'_tablet']);
        $phone = $this->df_check_values($desktop, $this->props[$max_width.'_phone']);

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('max-width:%1$s;', $desktop),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('max-width:%1$s;', $tablet),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('max-width:%1$s;', $phone),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
        if ($alignment === true) {
            $align = $slug . '_alignment';
            $desktop_align = $this->props[$align];
            $tablet_align = $this->df_check_values($desktop_align, $this->props[$align.'_tablet']);
            $phone_align = $this->df_check_values($tablet_align, $this->props[$align.'_phone']);
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $selector,
                'declaration' => sprintf('%1$s', $this->df_block_align($desktop_align)),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $selector,
                'declaration' => sprintf('%1$s', $this->df_block_align($tablet_align)),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $selector,
                'declaration' => sprintf('%1$s', $this->df_block_align($phone_align)),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
    }

    /**
     * align center with margin
     */
    function df_block_align($align) {
        if ($align === 'center') {
            return 'margin-left: auto; margin-right: auto;';
        } else if ($align === 'right') {
            return 'margin-left: auto; margin-right: 0;';
        } else if ($align === 'left') {
            return 'margin-right: auto; margin-left: 0;';
        }
    }

    /**
     * Checking values
     */
    function df_check_values($desktop, $other){
        return isset($other) && '' !== $other ? $other : $desktop;
    }

    /**
     * Check the integer values
     */
    function df_get_div_value($arg) {
        $value = intval($arg) / 2;
        $unit = str_replace(intval($arg), "", $arg);
        return $value . $unit; 
    }

    /**
     * Process Margin & Padding styles
     */
    function set_margin_padding_styles($options = array()) {
        $default = array(
            'module'            => '',
            'render_slug'       => '',
            'slug'              => '',
            'type'              => '',
            'selector'          => '',
            'hover'             => '',
            'important'         => true
        );
        $options        = wp_parse_args( $options, $default );
        extract($options); // phpcs:ignore WordPress.PHP.DontExtract
        $module = $this;
		$desktop 		= $module->props[$slug];
		$tablet 		= $module->props[$slug.'_tablet'];
        $phone 			= $module->props[$slug.'_phone'];
        
        if (class_exists('ET_Builder_Element')) {
            if(isset($desktop) && !empty($desktop)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $options['selector'],
                    'declaration' => et_builder_get_element_style_css($desktop, 
                        $type, $important),
                ));
            }
            if (isset($tablet) && !empty($tablet)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $options['selector'],
                    'declaration' => et_builder_get_element_style_css($tablet, 
                        $type, $important),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ));
            }
            if (isset($phone) && !empty($phone)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $options['selector'],
                    'declaration' => et_builder_get_element_style_css($phone, 
                        $type, $important),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }
			if (et_builder_is_hover_enabled( $slug, $module->props ) && isset($module->props[$slug.'__hover'])) {
				$hover = $module->props[$slug.'__hover'];
				ET_Builder_Element::set_style($render_slug, array(
					'selector' => $options['hover'],
                    'declaration' => et_builder_get_element_style_css($hover, 
                        $type, $important),
				));
			}
        }
    }

    /**
     * Process single value
     * old version
     */
    function apply_single_value($options = array()) {

        $default = array(
            'render_slug'       => '',
            'slug'              => '',
            'type'              => '',
            'selector'          => '',
            'unit'              => '%',
            'hover'             => '',
            'decrease'          => false,
            'addition'          => true,
            'important'         => true,
            'default'           => '14'
        );
        $options        = wp_parse_args( $options, $default );
        extract($options); // phpcs:ignore WordPress.PHP.DontExtract
        $module = $this;
        $unit_value = !empty(str_replace(intval($module->props[$slug]), "", $module->props[$slug])) ? str_replace(intval($module->props[$slug]), "", $module->props[$slug]) : $unit;
        $unit_value_tab = str_replace(intval($module->props[$slug.'_tablet']), "", $module->props[$slug.'_tablet']) !== '' ? 
            str_replace(intval($module->props[$slug.'_tablet']), "", $module->props[$slug.'_tablet']) : $unit_value;
        $unit_value_ph = str_replace(intval($module->props[$slug.'_phone']), "", $module->props[$slug.'_phone']) !== '' ? 
            str_replace(intval($module->props[$slug.'_phone']), "", $module->props[$slug.'_phone']) : $unit_value_tab;

        $desktop_value  =  !empty($module->props[$slug]) ? $module->props[$slug] : $default;
        $tablet_value   =  !empty($module->props[$slug.'_tablet']) ?$module->props[$slug.'_tablet'] : $desktop_value;
        $mobile_value   =  !empty($module->props[$slug.'_phone']) ? $module->props[$slug.'_phone'] : $tablet_value;

		$desktop 	= $decrease === false ? intval($desktop_value) : 100 - intval($desktop_value);
		$tablet 	= $decrease === false ? intval($tablet_value) : 100 - intval($tablet_value);
		$phone 		= $decrease === false ? intval($mobile_value) : 100 - intval($mobile_value);
		$negative   = $addition == false ? '-' : '';

		$desktop    .= $unit_value;
		$tablet     .= $unit_value_tab;
		$phone      .= $unit_value_ph;

		if(isset($desktop) && !empty($desktop)) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $selector,
				'declaration' => sprintf('%1$s:%2$s;', $type, $desktop, $negative),
			));
		}
		if (isset($tablet) && !empty($tablet)) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $selector,
				'declaration' => sprintf('%1$s:%3$s%2$s !important;', $type, $tablet,$negative),
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			));
		}
		if (isset($phone) && !empty($phone)) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $selector,
				'declaration' => sprintf('%1$s:%3$s%2$s !important;', $type, $phone,$negative),
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));
        }
        if (et_builder_is_hover_enabled( $slug, $module->props ) && isset($module->props[$slug.'__hover'])) {
            $hover_value = $module->props[$slug.'__hover'];
            if ( !empty($hover_value)) {
                $hover_value 	= $decrease === false ? intval($hover_value) : 100 - intval($hover_value) ;
                $hover_value .= $unit_value;
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $options['hover'],
                    'declaration' => sprintf('%1$s:%2$s %3$s;', $type, $hover_value, $negative),
                ));
            }
        }
    }

    /**
     * Process range value
     * 
     */
    function df_process_range ( $options = array() ) {
        $default = array(
            'render_slug'       => '',
            'slug'              => '',
            'type'              => '',
            'selector'          => '',
            'unit'              => '%',
            'hover'             => '',
            'important'         => true,
            'default'           => '14',
            'negative'          => false,
            'fixed_unit'        => ''
        );
        $options        = wp_parse_args( $options, $default );
        extract($options); // phpcs:ignore WordPress.PHP.DontExtract
        $important_text = $important !== false ? '!important' : '';
        $ng_value = $negative === true ? '-' : '';

	    $desktop = isset($this->props[$slug]) && $this->props[$slug] !== '' ?
		    $this->props[$slug] : $default;
	    $tablet = isset($this->props[$slug . '_tablet']) && $this->props[$slug . '_tablet'] !== '' ?
		    $this->props[$slug . '_tablet'] : $desktop;
	    $phone = isset($this->props[$slug . '_phone']) && $this->props[$slug . '_phone'] !== '' ?
		    $this->props[$slug . '_phone'] : $tablet;

        if(!empty($fixed_unit)) {
            $desktop        = (int)$desktop . $fixed_unit;
            $tablet         = (int)$tablet . $fixed_unit;
            $phone          = (int)$phone . $fixed_unit;
        }

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('%1$s:%4$s%2$s%3$s;', $type, $desktop, $important_text,$ng_value),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('%1$s:%4$s%2$s%3$s;', $type, $tablet,$important_text,$ng_value),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('%1$s:%4$s%2$s%3$s;', $type, $phone,$important_text,$ng_value),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
        if (et_builder_is_hover_enabled( $slug, $this->props ) && isset($this->props[$slug.'__hover']) && $hover !== '') {
            $hover_value = $this->props[$slug.'__hover'];
            if ( !empty($hover_value)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $hover,
                    'declaration' => sprintf('%1$s:%4$s%2$s %3$s;', $type, $hover_value, $important_text,$ng_value),
                ));
            } 
        }
    }

    /**
     * process oposite value
     * 
     */
    function df_process_oposite_value( $value, $ops = false) {
        if ($ops === true) {
            if (intval($value) >= 0) {
                $value = '-' . $value;
            } else {
                $value = substr($value, 1);
            }
        }        
        return $value;
    }

    /**
     * Process transform values
     */
    function df_process_transform( $options = array () ) {
        // transform: type, unit, default, slug
        $default = array(
            'render_slug'       => '',
            'selector'          => '',
            'hover'             => '',
            'oposite'           => false,
            'important'         => true,
            'transforms'        => []
        );
        $options        = wp_parse_args( $options, $default );
        extract($options); // phpcs:ignore WordPress.PHP.DontExtract
        $important_text = $important !== false ? '!important' : '';

        $transform_desktop = '';
        $transform_tablet = '';
        $transform_phone = '';
        $transform_hover = '';
        $hover_enable = false;

        foreach ( $transforms as $t ) {
            extract($t); // phpcs:ignore WordPress.PHP.DontExtract
            $desktop = isset($this->props[$slug]) && $this->props[$slug] !== '' ?
                $this->df_process_oposite_value($this->props[$slug], $oposite) : $default;
            $tablet = isset($this->props[$slug . '_tablet']) && $this->props[$slug . '_tablet'] !== '' ?
                $this->df_process_oposite_value($this->props[$slug . '_tablet'], $oposite) : $desktop;
            $phone = isset($this->props[$slug . '_phone']) && $this->props[$slug . '_phone'] !== '' ?
                $this->df_process_oposite_value($this->props[$slug . '_phone'], $oposite) : $tablet;
            $hover = isset($this->props[$slug . '__hover']) && $this->props[$slug . '__hover'] !== '' ?
                $this->df_process_oposite_value($this->props[$slug . '__hover'], $oposite) : $desktop;
            $transform_desktop .=  ' ' . $type . '(' . $desktop . ')';
            $transform_tablet .=  ' ' . $type . '(' . $tablet . ')';
            $transform_phone .=  ' ' . $type . '(' . $phone . ')';
            $transform_hover .=  ' ' . $type . '(' . $hover . ')';

            if (et_builder_is_hover_enabled( $slug, $this->props )) {
                $hover_enable = true;
            }
        }   

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('transform:%1$s %2$s;', $transform_desktop, $important_text),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('transform:%1$s %2$s;', $transform_tablet,$important_text),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('transform:%1$s %2$s;', $transform_phone,$important_text),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
        if ($hover_enable === true) {
            if ( !empty($transform_hover)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $hover,
                    'declaration' => sprintf('transform:%1$s %2$s;', $transform_hover, $important_text),
                ));
            }   
        }
    }

    /**
     * process css filter
     */
    function df_process_filter ( $options = array() ) {
        // filter: type, unit, default, slug
        $default = array(
            'render_slug'       => '',
            'selector'          => '',
            'hover'             => '',
            'important'         => true,
            'filters'           => []
        );
        $options        = wp_parse_args( $options, $default );
        extract($options); // phpcs:ignore WordPress.PHP.DontExtract
        $important_text = $important !== false ? '!important' : '';

        $filter_desktop = '';
        $filter_tablet = '';
        $filter_phone = '';
        $filter_hover = '';
        $hover_enable = false;

        foreach ( $filters as $filter ) {
            extract($filter); // phpcs:ignore WordPress.PHP.DontExtract
            $desktop = isset($this->props[$slug]) && $this->props[$slug] !== '' ?
                $this->props[$slug] : $default;
            $tablet = isset($this->props[$slug . '_tablet']) && $this->props[$slug . '_tablet'] !== '' ?
                $this->props[$slug . '_tablet'] : $desktop;
            $phone = isset($this->props[$slug . '_phone']) && $this->props[$slug . '_phone'] !== '' ?
                $this->props[$slug . '_phone'] : $tablet;
            $hover = isset($this->props[$slug . '__hover']) && $this->props[$slug . '__hover'] !== '' ?
                $this->props[$slug . '__hover'] : $desktop;
            
            $filter_desktop .=  ' ' . $type . '(' . $desktop . ')';
            $filter_tablet .=  ' ' . $type . '(' . $tablet . ')';
            $filter_phone .=  ' ' . $type . '(' . $phone . ')';
            $filter_hover .=  ' ' . $type . '(' . $hover . ')';

            if (et_builder_is_hover_enabled( $slug, $this->props )) {
                $hover_enable = true;
            }
        }

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('filter:%1$s %2$s;', $filter_desktop, $important_text),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('filter:%1$s %2$s;', $filter_tablet,$important_text),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('filter:%1$s %2$s;', $filter_phone,$important_text),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
        if ($hover_enable === true) {
            if ( !empty($filter_hover)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $hover,
                    'declaration' => sprintf('filter:%1$s %2$s;', $filter_hover, $important_text),
                ));
            }   
        }
    }

    /**
     * Process color
     */
    function df_process_color( $options = array() ) {
        $default = array(
            'module'            => '',
            'render_slug'       => '',
            'slug'              => '',
            'type'              => '',
            'selector'          => '',
            'hover'             => '',
            'important'         => true
        );
        $options        = wp_parse_args( $options, $default );
        extract($options); // phpcs:ignore WordPress.PHP.DontExtract
        $module = $this;
		$key = isset($module->props[$slug]) ? $module->props[$slug] : '';
        $important_text = true === $important ? '!important' : '';
        
		if ('' !== $key) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $selector,
				'declaration' => sprintf('%2$s: %1$s %3$s;', $key, $type, $important_text),
			));
		}
		if ( et_builder_is_hover_enabled( $slug, $module->props ) && isset($module->props[$slug . '__hover']) ) {
			$slug_hover = $module->props[$slug . '__hover'];
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => $hover,
				'declaration' => sprintf('%2$s: %1$s %3$s;', $slug_hover, $type, $important_text),
			));
		}
    }


    /**
     * check hover option
     */
    function df_check_hover_enable($key, $module) {
        if ( isset($module->props[$key . '__hover'])  && et_builder_is_hover_enabled( $key, $module->props ) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
	 * Custom transition to elements
	 */
	function apply_custom_transition($render_slug, $selector, $type = 'all') {
		ET_Builder_Element::set_style($render_slug, array(
			'selector' => $selector,
			'declaration' => sprintf('transition:%1$s %2$s %3$s %4$s !important;', 
				$type, 
				$this->props['hover_transition_duration'],
				$this->props['hover_transition_speed_curve'],
				$this->props['hover_transition_delay']
			),
		));
    }

    /**
     * Get a value from an array
     * 
     * @param String $value
     * @return String
     */
    function df_process_values($value) {
        $array = array(
            'center'        => 'center',
            'top_left'      => 'top left',
            'top_center'    => 'top center',
            'center_top'    => 'center top',
            'top'           => 'top',
            'top_right'     => 'top right',
            'right'         => 'right',
            'center_right'  => 'center right',
            'bottom_right'  => 'bottom right',
            'bottom'        => 'bottom',
            'bottom_center' => 'bottom center',
            'bottom_left'   => 'bottom left',
            'left'          => 'left',
            'center_left'   => 'center left',
            'no_repeat'     => 'no-repeat',
            'repeat'        => 'repeat',
            'repeat_x'      => 'repeat-x',
            'repeat_y'      => 'repeat-y',
            'space'         => 'space',
            'round'         => 'round',
            'cover'         => 'cover',
            'fit'           => 'contain',
            'actual_size'   => 'initial',
            'flex_left'     =>  'row',
            'flex_top'      =>  'column',
            'flex_right'    =>  'row-reverse',
            'flex_bottom'   =>  'column-reverse',
            'flex_start'    => 'flex-start',
            'flex_end'      => 'flex-end',
            'flex_center'   => 'center'
        );
        return array_key_exists($value, $array) ? $array[$value] : $value;
    }
    
     /**
     * Get a value from an array
     * 
     * @param Flex $value
     * @return Flex
     */
    function df_process_flex_values($value) {
        $array = array(
            'flex_left'     =>  'row',
            'flex_top'      =>  'column',
            'flex_right'    =>  'row-reverse',
            'flex_bottom'   =>  'column-reverse',
        );
        return array_key_exists($value, $array) ? $array[$value] : $value;
    }

    /**
     * Process background styles
     * 
     * @param array $options
     * @return void
     */
    function df_process_bg( $options = array() ) {
        $default = array(
            'render_slug'       => '',
            'slug'              => '',
            'selector'          => '',
            'hover'             => '',
            'important'         => false
        );
        $options        = wp_parse_args( $options, $default );
        $background = new DF_BG_PROCESS($this, $options);
        $background->set_style();
    }

    /**
     * Process custom background
     * 
     * @deprecated 
     * @param array $options
     * @return void
     */
    function df_process_background( $options = array() ) {
        $default = array(
            'render_slug'       => '',
            'slug'              => '',
            'selector'          => '',
            'hover'             => '',
            'important'         => true
        );

        $options        = wp_parse_args( $options, $default );
        extract($options); // phpcs:ignore WordPress.PHP.DontExtract
        $module = $this;
        $background_image = '';
        $gradient = '';
        $important_text = true === $important ? '!important' : '';

        if ( $module->props[$slug . '_bgcolor'] !== '' ) {
            ET_Builder_Element::set_style($render_slug, array(
				'selector' => $selector,
                'declaration' => sprintf( 'background-color: %1$s %2$s;',
                $module->props[$slug . '_bgcolor'], $important_text ),
			));
        }

        if ($module->props[$slug . '_use_gradient'] === 'on' ) {
            $color_1 = $module->props[$slug . '_color_gradient_1'] != '' ? 
                $module->props[$slug . '_color_gradient_1'] : "#2b87da";
            $color_2 = $module->props[$slug . '_color_gradient_2'] != '' ? 
                $module->props[$slug . '_color_gradient_2'] : "#29c4a9";
            $linear_direction = $module->props[$slug . '_gradient_direction'] != '' ? 
                $module->props[$slug . '_gradient_direction'] : "180deg";
            $start_position = $module->props[$slug . '_start_position'] != '' ? 
                $module->props[$slug . '_start_position'] : "0%";
            $end_position = $module->props[$slug . '_end_position'] != '' ? 
                $module->props[$slug . '_end_position'] : "100%";
            $radial_direction = $module->props[$slug . '_radial_direction'] ? 
                $module->props[$slug . '_radial_direction'] : 'center';

            if ( $module->props[ $slug . '_gradient_type'] !== 'radial') {
                $gradient = sprintf('linear-gradient( %3$s, %1$s %4$s, %2$s %5$s)', 
                    $color_1,
                    $color_2,
                    $linear_direction,
                    $start_position,
                    $end_position
                );
            } else {
                $gradient = sprintf('radial-gradient( circle at %3$s, %1$s %4$s, %2$s %5$s)', 
                    $color_1,
                    $color_2,
                    $this->df_process_values($radial_direction),
                    $start_position,
                    $end_position
                );
            }
        }

        // background image
        if ( $module->props[$slug . '_background_image'] !== '' || $gradient  !== '' ) {
            $separator = $module->props[$slug . '_background_image'] !== '' && $gradient  !== '' ? ',' : '';
            $background_image = !empty($module->props[$slug . '_background_image']) ? 
                sprintf('url(%1$s)', $module->props[$slug . '_background_image']) : '';
            ET_Builder_Element::set_style($render_slug, array(
				'selector' => $selector,
                'declaration' => $module->props[$slug . '_above_image'] === 'on' ?
                    sprintf( 'background-image:%1$s%4$s %2$s %3$s;',
                        $gradient, 
                        $background_image,
                        $important_text,
                        $separator 
                    ) : sprintf( 'background-image:%2$s%4$s %1$s %3$s;',
                        $gradient, 
                        $background_image,
                        $important_text,
                        $separator
                    ),
			));
        }
        if ( $background_image !== '' ) {
        
            $background_size = $module->props[$slug . '_background_image_size'] !== '' ? 
                $module->props[$slug . '_background_image_size'] : 'cover';
            $background_position = $module->props[$slug . '_background_image_position'] !== '' ?
                $module->props[$slug . '_background_image_position'] : 'center';
            $background_repeat = $module->props[$slug . '_background_image_repeat'] !== '' ?
                $module->props[$slug . '_background_image_repeat'] : 'no_repeat';

            ET_Builder_Element::set_style($render_slug, array(
				'selector' => $selector,
                'declaration' => sprintf( 'background-size:%1$s; background-position:%2$s; background-repeat:%3$s;',
                    $this->df_process_values($background_size), 
                    $this->df_process_values($background_position),
                    $this->df_process_values($background_repeat)
                ) ,
            ));
        } 

        // hover 
        $this->set_backgroud_hover($module, $slug, $render_slug, $hover);

        // hover styles
        if ( $this->df_check_hover_enable( $slug.'_bgcolor', $module) === true ) {
            ET_Builder_Element::set_style($render_slug, array(
				'selector' => $hover,
                'declaration' => sprintf( 'background-color: %1$s !important;',
                    $module->props[$slug.'_bgcolor__hover']
                )
            ));
        }
        if ( $this->df_check_hover_enable( $slug.'_background_image_size', $module) === true ) {
            ET_Builder_Element::set_style($render_slug, array(
				'selector' => $hover,
                'declaration' => sprintf( 'background-size: %1$s !important;',
                    $module->props[$slug.'_background_image_size__hover']
                )
            ));
        }
        if ( $this->df_check_hover_enable( $slug.'_background_image_position', $module) === true ) {
            ET_Builder_Element::set_style($render_slug, array(
				'selector' => $hover,
                'declaration' => sprintf( 'background-position: %1$s !important;',
                    $module->props[$slug.'_background_image_position__hover']
                )
            ));
        }
        if ( $this->df_check_hover_enable( $slug.'_background_image_repeat', $module) === true ) {
            ET_Builder_Element::set_style($render_slug, array(
				'selector' => $hover,
                'declaration' => sprintf( 'background-repeat: %1$s !important;',
                    $module->props[$slug.'_background_image_repeat__hover']
                )
            ));
        }
    }

    /**
     * Process Background Custom Transition
     * 
     * @param array $options | fields, key, selector
     *
     * @return array
     */
    function df_background_transition ($options) {
        $background = new DF_BG_PROCESS($this, $options);
        return $background->df_process_transiton($options);
    }

    /**
     * Add Button Style settings
     * 
     * @param Array $options
     * @return Array of settings
     */
    function df_transition($arg) {
        $transition = [
            'ease'          => 'ease',
            'ease_in'       => 'ease-in',
            'ease_in_out'   => 'ease-in-out',
            'ease_out'      => 'ease-out',
            'linear'        => 'linear',
            'bounce'        => 'cubic-bezier(.2,.85,.4,1.275)'
        ];
        return $transition[$arg];
    }

    /**
     * Fix border transition issues
     * 
     */
    function df_fix_border_transition($fields, $slug, $selector) {
        // all
        $fields['border_radii_'.$slug] = array('border-radius' => $selector);
        $fields['border_width_all_'.$slug] = array('border-width' => $selector);
        $fields['border_color_all_'.$slug] = array('border-color' => $selector);
        $fields['border_style_all_'.$slug] = array('border-style' => $selector);

        // right
        $fields['border_width_right_'.$slug] = array('border-right-width' => $selector);
        $fields['border_color_right_'.$slug] = array('border-right-color' => $selector);
        $fields['border_style_right_'.$slug] = array('border-right-style' => $selector);
        // left
        $fields['border_width_left_'.$slug] = array('border-left-width' => $selector);
        $fields['border_color_left_'.$slug] = array('border-left-color' => $selector);
        $fields['border_style_left_'.$slug] = array('border-left-style' => $selector);
        // top
        $fields['border_width_top_'.$slug] = array('border-left-width' => $selector);
        $fields['border_color_top_'.$slug] = array('border-top-color' => $selector);
        $fields['border_style_top_'.$slug] = array('border-top-style' => $selector);
        // bottom
        $fields['border_width_bottom_'.$slug] = array('border-left-width' => $selector);
        $fields['border_color_bottom_'.$slug] = array('border-bottom-color' => $selector);
        $fields['border_style_bottom_'.$slug] = array('border-bottom-style' => $selector);

        return $fields;
    }
    /**
     * Fix font style transition issues
     * Description: take all the attribute from divi advanced 'fonts' field
     * and set the transition with given selector.
     * 
     * @param Array $fields
     * @param String $slug
     * @param String Selector
     * @return Array $fields
     */
    function df_fix_fonts_transition($fields, $slug, $selector) {
        
        $fields[$slug . '_font_size'] = array('font-size' => $selector);
        $fields[$slug . '_text_color'] = array('color' => $selector);
        $fields[$slug . '_letter_spacing'] = array('letter-spacing' => $selector);
        $fields[$slug . '_line_height'] = array('line-height' => $selector);

        return $fields;
    }

    /**
     * Fix box-shadow transition issues
     * 
     */
    function df_fix_box_shadow_transition($fields, $slug, $selector) {
        // all
        $fields['box_shadow_color_'.$slug] = array('box-shadow' => $selector);
        $fields['box_shadow_blur_'.$slug] = array('box-shadow' => $selector);
        $fields['box_shadow_spread_'.$slug] = array('box-shadow' => $selector);
        $fields['box_shadow_horizontal_'.$slug] = array('box-shadow' => $selector);
        $fields['box_shadow_vertical_'.$slug] = array('box-shadow' => $selector);
         return $fields;
    }
    /**
     * Carousel Item initial width
     */
    function df_fix_carousel_item_initial_width($options = array()) {
        $item_desktop =  intval($this->props[$options['desktop']]);
        ET_Builder_Element::set_style($options['render_slug'], array(
            'selector' => $options['selector'],
            'declaration' =>  "width:calc(100%/{$item_desktop});"
        ));
        $item_tablet =  intval($this->props[$options['tablet']]);
        ET_Builder_Element::set_style($options['render_slug'], array(
            'selector' => $options['selector'],
            'declaration' =>  "width:calc(100%/{$item_tablet});",
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));
        $item_phone =  intval($this->props[$options['phone']]);
        ET_Builder_Element::set_style($options['render_slug'], array(
            'selector' => $options['selector'],
            'declaration' =>  "width:calc(100%/{$item_phone});",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
    }
    /**
     * new background settings
     */
    function df_background_settings($options = array()) {

        $default = array(
            'title'             => 'Background',
            'option_name'       => '',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => '',
            'sub_toggle'        => '',
            'show_if'           => array(),
            'show_if_not'       => array()
        );

        $args = wp_parse_args( $options, $default );
        extract($args); // phpcs:ignore WordPress.PHP.DontExtract

        $background["{$option_name}_color"] = array(
            'label'             => esc_html__( $title, 'divi_flash' ),
            'description'       => esc_html__( 'Adjust the background style of the Badge 1 by customizing the background color, gradient, and image.', 'divi_flash' ),
            'type'              => 'background-field',
            'base_name'         => "{$option_name}",
            'context'           => "{$option_name}_color",
            'custom_color'      => true,
            'background_fields' => array_merge(
                $this->generate_background_options("{$option_name}", "color", "advanced", "design_badge", "{$option_name}_color"),
                $this->generate_background_options("{$option_name}", 'gradient', "advanced", "design_badge", "{$option_name}_gradient"),
                $this->generate_background_options("{$option_name}", "image", "advanced", "design_badge", "{$option_name}_image")
            ),
            'default'           => ET_Global_Settings::get_value( 'all_buttons_bg_color' ),
            'default_on_front'  => '',
            'depends_show_if'   => 'on',
            'tab_slug'          => $tab_slug,
            'toggle_slug'       => $toggle_slug,
            'hover'             => 'tabs',
            'mobile_options'    => true,
            'sticky'            => true,
            'show_if'           => $show_if,
            'show_if_not'       => $show_if_not
        );
        if(!empty($sub_toggle)) {
            $background["{$option_name}_color"]['sub_toggle'] = $sub_toggle;
        }
		$background["{$option_name}_color"]['background_fields']["{$option_name}_color"]['default'] = ET_Global_Settings::get_value( 'all_buttons_bg_color' );
		$background = array_merge( 
            $background, 
            $this->generate_background_options(
                "{$option_name}",
                'skip',
                $tab_slug,
                $toggle_slug,
                "{$option_name}_color"
            )               
        );
        $background["{$option_name}_color"]['background_fields']["{$option_name}_parallax"]["type"] = "skip";
        return $background;
    }
    /**
     * process new background styles
     * 
     */
    function df_process_new_background_styles($options = array()) {
        $default = array(
            'props' => '',
            'key' => '',
            'selector' => '',
            'hover' => ''
        );
        $args = wp_parse_args( $options, $default );
        extract($args); // phpcs:ignore WordPress.PHP.DontExtract

        et_pb_background_options()->get_background_style(
            array(
                'base_prop_name'         => $key,
                'props'                  => $props,
                'selector'               => $selector,
                'selector_hover'         => $hover,
                'selector_sticky'        => $selector,
                'function_name'          => $this->slug,
                'important'              => ' !important',
                'use_background_video'   => false,
                'use_background_pattern' => false,
                'use_background_mask'    => false,
                'prop_name_aliases'      => array(
                    "use_{$key}_color_gradient" => "{$key}_use_color_gradient",
                    "{$key}"                    => "{$key}_color",
                ),
            )
        );
    }
    /**
     * Process new background transition
     * 
     */
    function df_process_new_background_transition($fields, $key, $selector) {
        $fields["{$key}_color"] = array(
            'background' => $selector
        );
        return $fields;
    }
}