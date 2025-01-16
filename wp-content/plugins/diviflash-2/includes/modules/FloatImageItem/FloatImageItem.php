<?php

class DIFL_FloatImageItem extends ET_Builder_Module {
    public $slug       = 'difl_floatimageitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $child_title_var          = 'admin_label';
	// public $child_title_fallback_var = 'admin_label';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Floating Image Item', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'image'         => esc_html__('Image', 'divi_flash'),
                    'fii_sizing'    => esc_html__('Image Sizing', 'divi_flash'),
                    'fii_position'  => esc_html__('Image Position', 'divi_flash'),
                    'fii_animation' => esc_html__('Animation Settings', 'divi_flash'),
                )
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'image_shadow'      => esc_html__('Image Shadow', 'divi_flash'),
                    'image_filter'      => esc_html__('Image Filter', 'divi_flash'),
                    'image_border'      => esc_html__('Image border', 'divi_flash')
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = false;
        $advanced_fields['borders'] = array (
            'default'   => true,
            'iamge'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_floatimage {$this->main_css_element} .df_fii_container img",
                        'border_styles' => ".difl_floatimage {$this->main_css_element} .df_fii_container img",
                        'border_styles_hover' => ".difl_floatimage {$this->main_css_element} .df_fii_container img:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'image_border'
            ),
        );
        $advanced_fields['z_index'] = false;
        $advanced_fields['transform'] = false;
        $advanced_fields['animation'] = false;
        $advanced_fields['position_fields'] = false;
        $advanced_fields['box_shadow'] = array(
            'default'   => false,
            'iamge'     => array (
                'css'       => array (
                    'main'  => ".difl_floatimage {$this->main_css_element} .df_fii_container img"
                ),
                'toggle_slug'   => 'image_shadow',
                'tab_slug'      => 'advanced'
            )
        );
        $advanced_fields['max_width'] = false;

        return $advanced_fields;
    }

    public function get_fields() {
        $general = array (
            'admin_label' => array (
				'label'           => esc_html__( 'Admin Label', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'admin_label',
				'default_on_front'=> 'Floating Image Item',
			),
        );
        $image = array (
            'image' => array (
                'label'                 => esc_html__( 'Image', 'divi_flash' ),
				'type'                  => 'upload',
                'option_category'       => 'basic_option',
				'upload_button_text'    => esc_attr__( 'Upload an image', 'divi_flash' ),
				'choose_text'           => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'           => esc_attr__( 'Set As Image', 'divi_flash' ),
                'toggle_slug'           => 'image',
                'dynamic_content'       => 'image'
            ),
            'alt_text' => array (
                'label'                 => esc_html__( 'Image Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'image'
            )
        );
        $sizing = array(
            'fii_max_width'   => array (
                'label'             => esc_html__( 'Image Max Width', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'fii_sizing',
				'default'           => 'auto',
                'default_unit'      => 'px',
                'responsive'        => true,
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '1',
                ),
                'hover'             => 'tabs'
            ),
            'fii_max_height'   => array (
                'label'             => esc_html__( 'Image Max Height', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'fii_sizing',
				'default'           => 'auto',
                'default_unit'      => 'px',
                'responsive'        => true,
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '1',
                ),
                'hover'             => 'tabs'
            )
        );
        $position = array (
            'horizontal_position'   => array (
                'label'             => esc_html__( 'Horizontal Position', 'divi_flash' ),
                'description'       => esc_html__('Horizontal position of the image.', 'divi_flash'),
				'type'              => 'range',
				'toggle_slug'       => 'fii_position',
				'default'           => '0%',
                'default_unit'      => '%',
                'allowed_units'     => array ('%', 'px', 'em'),
                'responsive'        => true,
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
                )
            ),
            'vertical_position'     => array (
                'label'             => esc_html__( 'Vertical Position', 'divi_flash' ),
                'description'       => esc_html__('Vertical position of the image.', 'divi_flash'),
				'type'              => 'range',
				'toggle_slug'       => 'fii_position',
				'default'           => '0%',
                'default_unit'      => '%',
                'allowed_units'     => array ('%', 'px', 'em'),
                'responsive'        => true,
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
                )
            )
        );
        $animation = array (
            'animation_type'        => array (
                'label'             => __('Animation type', 'divi_flash'),
                'type'              => 'select',
                'options'           => array (
                    'fi-up-down'       => esc_html__('Up and Down', 'divi_flash'),
                    'fi-left-right'    => esc_html__('Left and Right', 'divi_flash')
                ),
                'default'           => 'fi-up-down',
                'toggle_slug'       => 'fii_animation'
            ),
            'vertical_anime_distance'    => array (
                'label'             => esc_html__( 'Animation Distance Vertical (px/%)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'fii_animation',
				'default'           => '20px',
                'default_unit'      => 'px',
                'allowed_units'     => array ('px', '%'),
				'range_settings'    => array(
					'min'  => '-200',
					'max'  => '200',
					'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if_not'       => array (
                    'animation_type'    => 'fi-left-right'
                )
            ),
            'horizontal_anime_distance'    => array (
                'label'             => esc_html__( 'Animation Distance Horizontal (px/%)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'fii_animation',
				'default'           => '20px',
                'default_unit'      => 'px',
                'allowed_units'     => array ('px', '%'),
				'range_settings'    => array(
					'min'  => '-200',
					'max'  => '200',
					'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array (
                    'animation_type'    => 'fi-left-right'
                )
            ),
            'duration'                => array (
                'label'             => esc_html__( 'Duration (ms)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'fii_animation',
				'default'           => '4000',
                'default_unit'      => '',
                'allowed_units'     => array (),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '100',
					'max'  => '20000',
					'step' => '50',
                )
            ),
            'delay'                => array (
                'label'             => esc_html__( 'Delay (ms)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'fii_animation',
				'default'           => '0ms',
                'default_unit'      => '',
                'allowed_units'     => array (),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '2000',
					'step' => '50',
                )
            ),
            'animation_function'   => array(
                'label'     => esc_html__('Animation Timing Function', 'divi_flash'),
                'type'      => 'select',
                'options'   => array(
                    'easeInQuad' => esc_html__('easeInQuad', 'divi_flash'),
                    'easeInCubic' => esc_html__('easeInCubic', 'divi_flash'),
                    'easeInQuart' => esc_html__('easeInQuart', 'divi_flash'),
                    'easeInQuint' => esc_html__('easeInQuint', 'divi_flash'),
                    'easeInSine' => esc_html__('easeInSine', 'divi_flash'),
                    'easeInExpo' => esc_html__('easeInExpo', 'divi_flash'),
                    'easeInCirc' => esc_html__('easeInCirc', 'divi_flash'),
                    'easeInBack' => esc_html__('easeInBack', 'divi_flash'),
                    'easeInBounce' => esc_html__('easeInBounce', 'divi_flash'),
                    'easeInOutQuad' => esc_html__('easeInOutQuad', 'divi_flash'),
                    'easeInOutCubic' => esc_html__('easeInOutCubic', 'divi_flash'),
                    'easeInOutQuart' => esc_html__('easeInOutQuart', 'divi_flash'),
                    'easeInOutQuint' => esc_html__('easeInOutQuint', 'divi_flash'),
                    'easeInOutSine' => esc_html__('easeInOutSine', 'divi_flash'),
                    'easeInOutExpo' => esc_html__('easeInOutExpo', 'divi_flash'),
                    'easeInOutCirc' => esc_html__('easeInOutCirc', 'divi_flash'),
                    'easeInOutBack' => esc_html__('easeInOutBack', 'divi_flash'),
                    'easeInOutBounce' => esc_html__('easeInOutBounce', 'divi_flash'),
                    'easeOutQuad' => esc_html__('easeOutQuad', 'divi_flash'),
                    'easeOutCubic' => esc_html__('easeOutCubic', 'divi_flash'),
                    'easeOutQuart' => esc_html__('easeOutQuart', 'divi_flash'),
                    'easeOutQuint' => esc_html__('easeOutQuint', 'divi_flash'),
                    'easeOutSine' => esc_html__('easeOutSine', 'divi_flash'),
                    'easeOutExpo' => esc_html__('easeOutExpo', 'divi_flash'),
                    'easeOutCirc' => esc_html__('easeOutCirc', 'divi_flash'),
                    'easeOutBack' => esc_html__('easeOutBack', 'divi_flash'),
                    'easeOutBounce' => esc_html__('easeOutBounce', 'divi_flash'),
                    'linear' => esc_html__('linear', 'divi_flash')
                ),
                'default'       => 'linear',
                'toggle_slug'   => 'fii_animation',
            ),
        );
        return array_merge(
            $general,
            $sizing,
            $image,
            $position,
            $animation
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $image = '%%order_class%% .df_fii_container img';

        $fields['fii_max_width'] = array( 'max-width' => $image );
        $fields['fii_max_height'] = array( 'max-height' => $image );
        
        $fields = $this->df_fix_border_transition(
            $fields, 
            'iamge', 
            $image
        );

        return $fields;
    }

    public function additional_css_styles($render_slug) { 

        $this->df_process_range( array (
            'render_slug'       => $render_slug,
            'slug'              => 'horizontal_position',
            'type'              => 'left',
            'selector'          => '%%order_class%%',
            'default'           => '0%'
        ));
        $this->df_process_range( array (
            'render_slug'       => $render_slug,
            'slug'              => 'vertical_position',
            'type'              => 'top',
            'selector'          => '%%order_class%%',
            'default'           => '0%'
        ));
        // image sizing
        $this->df_process_range( array (
            'render_slug'       => $render_slug,
            'slug'              => 'fii_max_width',
            'type'              => 'max-width',
            'selector'          => '%%order_class%% .df_fii_container img',
            'hover'             => '%%order_class%% .df_fii_container img:hover'
        ));
        $this->df_process_range( array (
            'render_slug'       => $render_slug,
            'slug'              => 'fii_max_height',
            'type'              => 'max-height',
            'selector'          => '%%order_class%% .df_fii_container img',
            'hover'             => '%%order_class%% .df_fii_container img:hover'
        ));
    }

    public function render($attr, $content, $render_slug ) {
        
        $this->additional_css_styles($render_slug);
        $image_alt = $this->props['alt_text'] !== '' ? $this->props['alt_text']  : df_image_alt_by_url($this->props['image']);
        $image = $this->props['image'] !== '' ?
                sprintf('<img src="%1$s" alt="%2$s" />',
                esc_attr($this->props['image']), 
                esc_attr($image_alt)
            ): '';
        
        $data = array (
            'animation_type'            => $this->props['animation_type'],
            'duration'                  => $this->props['duration'],
            'delay'                     => $this->props['delay'],
            'animation_function'        => $this->props['animation_function'],
            'vertical_anime_distance'   => $this->props['vertical_anime_distance'],
            'horizontal_anime_distance' => $this->props['horizontal_anime_distance']
        );
        
        return sprintf('
            <div class="df_fii_container" data-animation=\'%2$s\'>
                %1$s
            </div>',
            $image,
            wp_json_encode($data)
        );
    }
}
new DIFL_FloatImageItem;