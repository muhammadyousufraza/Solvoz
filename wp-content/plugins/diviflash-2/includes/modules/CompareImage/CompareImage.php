<?php

class DIFL_CompareImage extends ET_Builder_Module
{
    public $slug       = 'difl_compareimage';
    public $vb_support = 'on';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'DiviFlash',
        'author_uri' => '',
    );

    public function init()
    {
        $this->name = esc_html__('Before After Slider', 'divi_flash');
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/image-compare.svg';        
    }

    public function get_settings_modal_toggles()
    {
        return array(
            'general'  => array(
                'toggles' => array(
                    'main_content'                     => esc_html__('Content', 'divi_flash'),
                    'image'                     => esc_html__('Before After Images', 'divi_flash'),
                    'settings'                     => esc_html__('Settings', 'divi_flash'),
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'before_design'  => esc_html__('Before Label Style', 'divi_flash'),
                    'after_design'   => esc_html__('After Label Style', 'divi_flash'),
                    'bar_design'     => esc_html__('Control Bar', 'divi_flash'),
                    'filter_design'     => array(
                        'title'             => esc_html__('Before Image Filter', 'divi_flash'),
                    ),
                    'custom_spacing' => esc_html__('Custom Spacing', 'divi_flash'),
                )
            ),
        );
    }
    public function get_advanced_fields_config()
    {
        $advanced_fields = array();
        $advanced_fields['text'] = false;
        $advanced_fields['transform'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['fonts'] = array(
            'before_text'     => array(
                // 'label'         => esc_html__( 'Before Text', 'divi_flash' ),
                'toggle_slug'   => 'before_design',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% .df_cm_content span.icv__label-before',
                    'hover' => '%%order_class%% .df_cm_content span.icv__label-before:hover',
                    'important'	=> 'all'
                )
            ),

            'after_text'     => array(
                // 'label'         => esc_html__( 'After Text', 'divi_flash' ),
                'toggle_slug'   => 'after_design',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% .df_cm_content span.icv__label-after',
                    'hover' => '%%order_class%% .df_cm_content span.icv__label-after:hover',
                    'important'	=> 'all'
                )
            )
            
        );
        $advanced_fields['borders'] = array(
            'default'   => array(),
            'before_text_border'                 => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_cm_content span.icv__label-before',
                        'border_styles' => '%%order_class%% .df_cm_content span.icv__label-before',
                        'border_styles_hover' => '%%order_class%% .df_cm_content span.icv__label-before:hover',
                    )
                ),
                'toggle_slug'           => 'before_design',
                'tab_slug'              => 'advanced'
                // 'label_prefix'      => 'Before text'
            ),
            'after_text_border'                 => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_cm_content span.icv__label-after',
                        'border_styles' => '%%order_class%% .df_cm_content span.icv__label-after',
                        'border_styles_hover' => '%%order_class%% .df_cm_content span.icv__label-after:hover',
                    )
                ),
                'toggle_slug'           => 'after_design',
                'tab_slug'              => 'advanced'
                // 'label_prefix'      => 'After text'
            )
        );
        $advanced_fields['box_shadow'] = array(
            'default'   => array(
            ),
            'before_text_shadow'=> array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_cm_content span.icv__label-before",
                    'hover' => "{$this->main_css_element} .df_cm_content span.icv__label-before:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'before_design'
            ),
            'after_text_shadow'=> array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_cm_content span.icv__label-after",
                    'hover' => "{$this->main_css_element} .df_cm_content span.icv__label-after:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'after_design'
            )
        );
        
        $advanced_fields['filters'] = array(
            'toggle_name'          => esc_html__( 'After Image filter', 'divi_flash' ),
            'css'                  => array(
                'main' => array(
                '%%order_class%% img.after_image',
                )
            ),
            'child_filters_target' => array(
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'filter_design',
                'label'           => et_builder_i18n( 'Before Image' ),
                'css'             => array(
                    'main'  => '%%order_class%% img.before_image',
                    'hover' => '%%order_class%%:hover img.before_image',
                ),
            )
            
        );
        $advanced_fields['image'] = array(
			'css' => array(
				'main' => array(
					'%%order_class%% img.before_image',
				)
			),
		);
  
        return $advanced_fields;
    }

    public function get_fields()
    {
        $general = array();

        $image = array(
            'before_image' => array(
                'label'                 => esc_html__('Before Image' , 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'default'               => '',
                'upload_button_text'    => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'image',
                'dynamic_content'       => 'image'
            ),
            'before_image_alt_text' => array(
                'label'                 => esc_html__('Before Image Alt Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'image'               
            ),
            'after_image' => array(
                'label'                 => esc_html__('After Image', 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'default'               => '',
                'upload_button_text'    => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'image',
                'dynamic_content'       => 'image'
            ),
            'after_image_alt_text' => array(
                'label'                 => esc_html__('After Image Alt Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'image'     
            )
        );
        $options_settings = array(
            'cm_sarting_point'       => array (
                'label'             => esc_html__( 'Control Starting Point', 'divi_flash' ),
                'description'       => esc_html__('Control Starting Point', 'divi_flash'),
				'type'              => 'range',
				'toggle_slug'       => 'settings',
				'default'           => '50',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
                )
            ),
            'cm_vertical_mode'      => array (
                'label'                 => esc_html__( 'Vertical Mode', 'divi_flash' ),
                'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'settings'
            ),
            'cm_control_hover'      => array (
                'label'                 => esc_html__( 'Slider on Hover', 'divi_flash' ),
                'description'           => esc_html__('Compare slider on hover.', 'divi_flash'),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'settings'
            ),
            'cm_control_color' => array(
                'label'                 => esc_html__('Slider Color', 'divi_flash'),
                'type'                  => 'color-alpha',
                'default'               =>  "#333333",
                'toggle_slug'           => 'settings',
                'hover'                 => 'tabs'
            ),
            'cm_control_shadow'      => array (
                'label'                 => esc_html__( 'Slider Shadow', 'divi_flash' ),
                'description'           => esc_html__('Setting this option will Shadow Slider.', 'divi_flash'),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' ),
                ),
                'default'               => 'on',
                'toggle_slug'           => 'settings'
            ),
            'cm_add_circle'      => array (
                'label'                 => esc_html__( 'Enable Circle', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'settings'
            ),
            'cm_add_circle_blur'      => array (
                'label'                 => esc_html__( 'Enable Circle Blur', 'divi_fla sh' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'settings',
                'show_if'               => array(
                    'cm_add_circle'     => 'on'
                )
            ),
            'cm_smoothing'      => array (
                'label'                 => esc_html__( 'Smoothing', 'divi_flash' ),
                'description'           => esc_html__('Smoothing on Drag and click.', 'divi_flash'),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' ),
                ),
                'default'               => 'on',
                'toggle_slug'           => 'settings'
            ),
            'cm_smoothing_amount'       => array (
                'label'             => esc_html__( 'Smoothing Amount', 'divi_flash' ),
				'type'              => 'range',
                'default'           => '100',
                'toggle_slug'       => 'settings',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '1000',
					'step' => '1',
                ),
                'show_if'           => array(
                    'cm_smoothing'      => 'on'
                )
            ),
            'cm_enable_show_lebel'      => array (
                'label'                 => esc_html__( 'Show Label', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'settings'
            ),
            'cm_before_lebel_text' => array(
                'label'                 => esc_html__('Before Label Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'settings',
                'dynamic_content'       => 'text',
                'show_if'           => array(
                    'cm_enable_show_lebel'      => 'on'
                )
            ),
            'cm_after_lebel_text' => array(
                'label'                 => esc_html__('After Label Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'settings',
                'dynamic_content'       => 'text',
                'show_if'           => array(
                    'cm_enable_show_lebel'      => 'on'
                )
            ),
            'cm_level_show_on_hover'      => array (
                'label'                 => esc_html__( 'Label Show on Hover', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'settings',
                'show_if'           => array(
                    'cm_enable_show_lebel'      => 'on'
                )
            ),
            'use_lebel_top_position'      => array (
                'label'                 => esc_html__( 'Use Horizontal Position', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'settings',
                'show_if'           => array(
                    'cm_vertical_mode'      => 'off',
                    'cm_enable_show_lebel'      => 'on',
                )
            ),
            'lebel_top_position' => array(
                'label'             => esc_html__('Label Horizontal Position', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'settings',
                'default'           => '90%',
                'allowed_units'     => array('px','%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'            =>array(
                    'cm_vertical_mode'          => 'off',
                    'cm_enable_show_lebel'      => 'on',
                    'use_lebel_top_position'    => 'on'
                )
            ),
            'use_lebel_left_position'      => array (
                'label'                 => esc_html__( 'Use Vertical Position', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'settings',
                'show_if'           => array(
                    'cm_vertical_mode'      => 'on',
                    'cm_enable_show_lebel'      => 'on',
                )
            ),
            'lebel_left_position' => array(
                'label'             => esc_html__('Label Left Position', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'settings',
                'default'           => '0%',
                'allowed_units'     => array('px','%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'            =>array(
                    'cm_vertical_mode'          => 'on',
                    'cm_enable_show_lebel'      => 'on',
                    'use_lebel_left_position'   => 'on'
                )
            ),
        );

        $before_background =  $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'df_before_background',
            'toggle_slug'           => 'before_design',
            'tab_slug'              => 'advanced',           
            'image'                 => false,
            'hover'				    => 'tabs'
        ));
        $after_background = $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'df_after_background',
            'toggle_slug'           => 'after_design',           
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'hover'				    => 'tabs'
        ));

        $before_text_spacing = $this->add_margin_padding(array(
            'title'         => 'Before Text',
            'key'           => 'before_text',
            'toggle_slug'   => 'margin_padding'
        ));

        $after_text_spacing = $this->add_margin_padding(array(
            'title'         => 'After Text',
            'key'           => 'after_text',
            'toggle_slug'   => 'margin_padding'
        ));

        return array_merge(
            $image,
            $options_settings,
            $before_background,
            $after_background,
            $before_text_spacing,
            $after_text_spacing
        );
    } 

    public function get_transition_fields_css_props()
    {
        $fields = parent::get_transition_fields_css_props();
        $before_text = '%%order_class%% .df_cm_content span.icv__label-before';
        $after_text = '%%order_class%% .df_cm_content span.icv__label-after';
        $overlay  ='%%order_class%% .df_cm_content.cm_overlay:after';
        // background
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'df_before_background',
            'selector'      => $before_text
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'df_after_background',
            'selector'      => $after_text
        ));

        // spacing
        $fields['before_text_margin'] = array('margin' => $before_text);
        $fields['after_text_margin'] = array('padding' => $after_text);

        // border fix
        $fields = $this->df_fix_border_transition(
            $fields,
            'before_text_border',
            $before_text
        );

        $fields = $this->df_fix_border_transition(
            $fields,
            'before_text_border',
            $after_text
        );

          // box-shadow Fix
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'before_text_shadow',
            $before_text
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'after_text_shadow',
            $after_text
        );

        return $fields;
    }
    public function additional_css_styles($render_slug)
    {  
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%',
            'declaration' => 'filter: none !important;'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'df_before_background',
            'selector'          => "{$this->main_css_element} .df_cm_content span.icv__label-before",
            'hover'             => "{$this->main_css_element} .df_cm_content span.icv__label-before:hover"
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'df_after_background',
            'selector'          => "{$this->main_css_element} .df_cm_content span.icv__label-after",
            'hover'             => "{$this->main_css_element} .df_cm_content span.icv__label-after:hover"
        ));

        if($this->props['cm_vertical_mode'] !== 'on' && $this->props['use_lebel_top_position'] === 'on') {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'lebel_top_position',
                'type'              => 'top',
                'selector'            => "%%order_class%% .df_cm_content.icv__icv--horizontal span.icv__label"
            ));
        } elseif($this->props['cm_vertical_mode'] !== 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_cm_content.icv__icv--horizontal span.icv__label',
                'declaration' => 'transform: translateY(-50%);'
            ));
        }
        if($this->props['cm_vertical_mode'] === 'on' && $this->props['use_lebel_left_position'] === 'on') {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'lebel_left_position',
                'type'              => 'left',
                'selector'            => "%%order_class%% .df_cm_content.icv__icv--vertical span.icv__label.vertical"
            ));
        } elseif($this->props['cm_vertical_mode'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_cm_content.icv__icv--vertical span.icv__label.vertical',
                'declaration' => 'transform: translateX(-50%);'
            ));
        }
  
        // Spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'before_text_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_cm_content span.icv__label-before",
            'hover'             => "{$this->main_css_element} .df_cm_content span.icv__label-before:hover",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'before_text_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_cm_content span.icv__label-before",
            'hover'             => "{$this->main_css_element} .df_cm_content span.icv__label-before:hover",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'after_text_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_cm_content span.icv__label-after",
            'hover'             => "{$this->main_css_element} .df_cm_content span.icv__label-after:hover",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'after_text_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_cm_content span.icv__label-after",
            'hover'             => "{$this->main_css_element} .df_cm_content span.icv__label-after:hover",
            'important'         => false
        ));
    }
    
    public function df_render_image($props_key)
    {  
        if (isset($this->props[$props_key]) && $this->props[$props_key] !== '') {
            $image_alt = $this->props[$props_key . '_alt_text'] !== '' ? $this->props[$props_key . '_alt_text']  : df_image_alt_by_url($this->props[$props_key]);
            $src = 'src';
            return sprintf(
                '<img class="%4$s" %3$s="%1$s" alt="%2$s" />',
                $this->props[$props_key],
                $image_alt,
                $src,
                $props_key
            );
        }else{
            return '';
        }
    }
     
    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('compare-image-script');
        wp_enqueue_script('df-compareimage');
        $before_image_html = $this->df_render_image('before_image');
        $after_image_html =  $this->df_render_image('after_image');
        $this->additional_css_styles($render_slug);
        // filter for images
         if ( array_key_exists( 'image', $this->advanced_fields ) && array_key_exists( 'css', $this->advanced_fields['image'] ) ) {
			 $this->generate_css_filters(
				$render_slug,
				'child_',
				self::$data_utils->array_get( $this->advanced_fields['image']['css'], 'main', '%%order_class%%' )
			);
		}

        $this->generate_css_filters( $render_slug, '', $this->advanced_fields['filters']['css']['main'] );
      
        $html_code = sprintf('<div class="df_cm_content">
                 %1$s
                 %2$s
            </div>',$before_image_html, $after_image_html );
        $data_options = array(
            'cm_sarting_point'       => isset($this->props['cm_sarting_point']) ? $this->props['cm_sarting_point'] : 50,
            'cm_vertical_mode'       => $this->props['cm_vertical_mode'] === 'on' ? true : false,
            'cm_control_hover'       => $this->props['cm_control_hover'] === 'on' ? true : false,
            'cm_control_color'       => isset($this->props['cm_control_color']) ? $this->props['cm_control_color'] : "#333333",
            'cm_control_shadow'      => $this->props['cm_control_shadow'] === 'on' ? true : false,
            'cm_add_circle'          => $this->props['cm_add_circle'] === 'on' ? true : false,
            'cm_add_circle_blur'     => $this->props['cm_add_circle_blur'] === 'on' ? true : false,
            'cm_smoothing'           => $this->props['cm_smoothing'] === 'on' ? true : false,
            'cm_smoothing_amount'    => isset($this->props['cm_smoothing_amount']) ? $this->props['cm_smoothing_amount'] : 100,
            'cm_enable_show_lebel'   => $this->props['cm_enable_show_lebel'] === 'on' ? true : false,
            'cm_before_lebel_text'   => $this->props['cm_before_lebel_text'] !== '' ? $this->props['cm_before_lebel_text'] : 'Before',
            'cm_after_lebel_text'    => $this->props['cm_after_lebel_text'] !== '' ? $this->props['cm_after_lebel_text'] : 'After',
            'cm_level_show_on_hover' => $this->props['cm_level_show_on_hover'] === 'on' ? true : false
        );
        return sprintf('<div class="df_cm_container" data-options=\'%2$s\'>
            %1$s
        </div>' , $html_code , wp_json_encode($data_options));
    }
}

new DIFL_CompareImage;