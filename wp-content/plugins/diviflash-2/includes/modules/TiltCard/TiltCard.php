<?php

class DIFL_TiltCard extends ET_Builder_Module {
    public $slug       = 'difl_tiltcard';
    public $vb_support = 'on';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Tilt Card', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/titlt-box.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'content'           => esc_html__('Content', 'divi_flash'),
                    'image'             => esc_html__('Image & Icon', 'divi_flash'),
                    'button'            => esc_html__('Button', 'divi_flash'),
                    'tilt'              => esc_html__('Tilt Settings', 'divi_flash'),
                    'content_float'     => esc_html__('Content Float', 'divi_flash')
                )
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'image'             => esc_html__('Image Styles', 'divi_flash'),
                    'image_border'      => esc_html__('Image Border', 'divi_flash'),
                    'title'             => esc_html__('Title Font', 'divi_flash'),
                    'content'           => esc_html__('Content Font', 'divi_flash'),
                    'button'            => esc_html__('Button', 'divi_flash'),
                    'custom_spacing'    => array (
                        'title'             => esc_html__('Custom Spacing', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'wrapper'   => array(
                                'name' => 'Wrapper',
                            ),
                            'content'     => array(
                                'name' => 'Content',
                            )
                        ),
                    )
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['fonts'] = array (
            'title'         => array(
                'label'         => esc_html__( 'Title', 'divi_flash' ),
                'toggle_slug'   => 'title',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .title",
                    // 'hover' => "%%order_class%% .title",
                    'important'	=> 'all'
                ),
            ),
            'content'         => array(
                'label'         => esc_html__( 'Content', 'divi_flash' ),
                'toggle_slug'   => 'content',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .content",
                    // 'hover' => "%%order_class%% .content",
                    'important'	=> 'all'
                ),
            ),
            'button'     => array(
                'label'         => esc_html__( 'Button', 'divi_flash' ),
                'toggle_slug'   => 'button',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_tc_button",
                    'hover' => "%%order_class%% .df_tc_button:hover",
                    'important'	=> 'all'
                ),
            ),
        );

        $advanced_fields['borders'] = array (
            'default'               => true,
            'button'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_tc_button',
                        'border_styles' => '%%order_class%% .df_tc_button',
                        'border_styles_hover' => '%%order_class%% .df_tc_button:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'button'
            ),
            'image'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_tc_image_container img',
                        'border_styles' => '%%order_class%% .df_tc_image_container img',
                        'border_styles_hover' => '%%order_class%%:hover .df_tc_image_container img',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'image',
                'label_prefix'      => esc_html__('Image', 'divi_flash')
            ),
        );
        $advanced_fields['box_shadow'] = array (
            'default'               => true,
            'image'                 => array(
                'css' => array(
                    'main' => "%%order_class%% .df_tc_image_container img",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'image'
            ),
            'button'                 => array(
                'css' => array(
                    'main' => "%%order_class%% .df_tc_button",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button'
            )
        );

        $advanced_fields['text'] = false;     
        $advanced_fields['filters'] = false;
        $advanced_fields['transform'] = false;
        return $advanced_fields;
    }

    public function get_fields() {
        $content = array(
            'title'         => array (
                'label'             => esc_html__('Title', 'divi_flash'),
                'type'              => 'text',
                'toggle_slug'       => 'content',
                'dynamic_content'   => 'text'
            ),
            'content'        => array (
                'label'             => esc_html__('Content', 'divi_flash'),
                'type'              => 'tiny_mce',
                'toggle_slug'       => 'content',
                'dynamic_content'   => 'text'
            ),
        );
        $tc_icon_image = $this->df_add_icon_settings(array (
            'title_prefix'          => 'image',
            'key'                   => 'image',
            'toggle_slug'           => 'image',
            'default_size'          => '48px',
            'icon_alignment'        => true,
            'image_styles'          => true,
            'icon_bg'               => true,
            'circle_icon'           => true,
            'img_toggle'            => 'image',
            'img_tab'               => 'advanced',
            'max_width'             => true,
            'image_alt'             => true,
            'dynamic_option'        => true
        ));
        $button = $this->df_add_btn_content(array (
            'key'                   => 'tc_btn',
            'toggle_slug'           => 'button',
            'dynamic_option'        => true
        ));
        $button_style = $this->df_add_btn_styles(array (
            'key'                   => 'tc_btn',
            'toggle_slug'           => 'button',
            'tab_slug'              => 'advanced'
        ));
        $tc_buttons_bg = $this->df_add_bg_field(array (
			'label'				    => 'Button Background',
            'key'                   => 'tc_button_background',
            'toggle_slug'           => 'button',
            'tab_slug'              => 'advanced'
        ));
        $tilt = array (
            'tc_reverse'      => array (
                'label'                 => esc_html__( 'Reverse the tilt direction', 'divi_flash' ),
                'description'           => esc_html__('Setting this option will reverse the tilt.', 'divi_flash'),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'tilt'
            ),
            'tc_max'       => array (
                'label'             => esc_html__( 'Max tilt rotation (degrees)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'tilt',
				'default'           => '35',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
                )
            ),
            'tc_perspective'       => array (
                'label'             => esc_html__( 'Transform perspective', 'divi_flash' ),
                'description'       => esc_html__('Transform perspective, the lower the more extreme the tilt gets.', 'divi_flash'),
				'type'              => 'range',
				'toggle_slug'       => 'tilt',
				'default'           => '1000',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '100',
					'max'  => '2000',
					'step' => '50',
                )
            ),
            'tc_glare'      => array (
                'label'                 => esc_html__( 'Glare', 'divi_flash' ),
                'description'           => esc_html__('Setting this option will enable a glare effect.', 'divi_flash'),
                'type'                  => 'yes_no_button',
                'options'               => array(
                    'off' => esc_html__( 'No', 'divi_flash' ),
                    'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'tilt'
            ),
            'tc_glare_opacity'       => array (
                'label'             => esc_html__( 'Glare Opacity', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'tilt',
				'default'           => '1',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '.1',
					'max'  => '1',
					'step' => '.1',
                ),
                'show_if'           => array(
                    'tc_glare'      => 'on'
                )
            ),
            'tc_card_scale'       => array (
                'label'             => esc_html__( 'Card Scale on hover', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'tilt',
				'default'           => '1',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '.1',
					'max'  => '3',
					'step' => '.1',
                )
            ),
            'tc_speed'       => array (
                'label'             => esc_html__('Speed', 'divi_flash' ),
                'description'       => esc_html__('Speed of the enter/exit transition', 'divi_flash'),
				'type'              => 'range',
				'toggle_slug'       => 'tilt',
				'default'           => '300',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '100',
					'max'  => '5000',
					'step' => '50',
                )
            ),
            'tc_full_page'      => array (
                'label'                 => esc_html__( 'Full page listening', 'divi_flash' ),
                'description'           => esc_html__('Setting this option will make the element respond to any mouse movements on page.', 'divi_flash'),
                'type'                  => 'yes_no_button',
                'options'               => array(
                    'off' => esc_html__( 'No', 'divi_flash' ),
                    'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'tilt'
            )
        );
        $content_float = array(
            'tc_content_float'      => array (
                'label'                 => esc_html__( 'Content Floating Effect', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => 'content_float'
                
            ),
            'tc_translate'       => array (
                'label'             => esc_html__( 'Translate Z', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'content_float',
				'default'           => '50px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
                ),
                'show_if'         => array (
                    'tc_content_float'  => 'on'
                ) 
            ),
            'tc_scale'       => array (
                'label'             => esc_html__( 'Scale', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'content_float',
				'default'           => '.9',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '.5',
					'max'  => '2',
					'step' => '.1',
                ),
                'show_if'           => array (
                    'tc_content_float'  => 'on'
                ) 
            )
        );

        $wrapper = $this->add_margin_padding(array(
            'title'         => 'Wrapper',
            'key'           => 'wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $content_wrapper = $this->add_margin_padding(array(
            'title'         => 'Content Wrapper',
            'key'           => 'content_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $image_wrapper = $this->add_margin_padding(array(
            'title'         => 'Image Wrapper',
            'key'           => 'img_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $button_wrapper = $this->add_margin_padding(array(
            'title'         => 'Button Wrapper',
            'key'           => 'btn_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $icon = $this->add_margin_padding(array(
            'title'         => 'Icon',
            'key'           => 'icon',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content',
            'option'        => 'padding'
        ));
        $image = $this->add_margin_padding(array(
            'title'         => 'Image',
            'key'           => 'image',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content',
            'option'        => 'margin'
        ));
        $title_spacing = $this->add_margin_padding(array(
            'title'         => 'Title',
            'key'           => 'title',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        $content_spacing = $this->add_margin_padding(array(
            'title'         => 'Content',
            'key'           => 'content',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        $button_spacing = $this->add_margin_padding(array(
            'title'         => 'Button',
            'key'           => 'button',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));


        return array_merge(
            $content,
            $tc_icon_image,
            $button,
            $button_style,
            $tc_buttons_bg,
            $content_float,
            $tilt,
            $wrapper,
            $content_wrapper,
            $image_wrapper,
            $button_wrapper,
            $icon,
            $image,
            $title_spacing,
            $content_spacing,
            $button_spacing
        );
    }

    public function additional_css_styles($render_slug) {
        
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%',
            'declaration' => sprintf('transform: perspective(%1$spx);',
                $this->props['tc_perspective']
            )
        ));
        // content float
        if ($this->props['tc_content_float'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% > div:first-child',
                'declaration' => sprintf('transform: translateZ(%1$s) scale(%2$s);', 
                    $this->props['tc_translate'],
                    $this->props['tc_scale']
                )
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%, %%order_class%%:hover',
                'declaration' => 'overflow: visible;'
            ));
        }
        // icon styles
        $this->process_icon_styles(array (
            'render_slug'       => $render_slug,
            'slug'              => 'image',
            'selector'          => '%%order_class%% .df_tc_image_container .et-pb-icon',
            'hover'             => '%%order_class%% .df_tc_image_container .et-pb-icon:hover',
            'align_container'   => '%%order_class%% .df_tc_image_container',
            'image_selector'    => '%%order_class%% .df_tc_image_container img'
        ));
        // button style
        $this->df_process_btn_styles(array (
            'render_slug'       => $render_slug,
            'slug'              => 'tc_btn',
            'selector'          => '%%order_class%% .df_tc_button',
            'hover'             => '%%order_class%% .df_tc_button:hover',
            'align_container'   => '%%order_class%% .df_tc_button_wrapper'
        ));
        // button background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'tc_button_background',
            'selector'          => '%%order_class%% .df_tc_button',
            'hover'             => '%%order_class%% .df_tc_button:hover'
        ));
        // wrapper spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_container',
            'hover'             => '%%order_class%% .df_tc_container:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_tc_container',
            'hover'             => '%%order_class%% .df_tc_container:hover',
        ));
        // content wrapper spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_content_container',
            'hover'             => '%%order_class%% .df_tc_content_container:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_tc_content_container',
            'hover'             => '%%order_class%% .df_tc_content_container:hover',
        ));
        // Image spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'img_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_image_container',
            'hover'             => '%%order_class%% .df_tc_image_container:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'img_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_tc_image_container',
            'hover'             => '%%order_class%% .df_tc_image_container:hover',
        ));
        // Button spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'btn_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_button_wrapper',
            'hover'             => '%%order_class%% .df_tc_button_wrapper:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'btn_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_tc_button_wrapper',
            'hover'             => '%%order_class%% .df_tc_button_wrapper:hover',
        ));
        // icon spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .et-pb-icon',
            'hover'             => '%%order_class%% .et-pb-icon:hover',
        ));
        // icon spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_image_container img',
            'hover'             => '%%order_class%% .df_tc_image_container img:hover',
        ));
        // Title spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .title',
            'hover'             => '%%order_class%% .title:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .title',
            'hover'             => '%%order_class%% .title:hover',
        ));
        // Content spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .content',
            'hover'             => '%%order_class%% .content:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .content',
            'hover'             => '%%order_class%% .content:hover',
        ));
        // Button spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_button',
            'hover'             => '%%order_class%% .df_tc_button:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_tc_button',
            'hover'             => '%%order_class%% .df_tc_button:hover',
        ));
        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'image_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }  
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $wrapper = '%%order_class%% .df_tc_container';
        $content_wrapper = '%%order_class%% .df_tc_content_container';
        $image_wrapper = '%%order_class%% .df_tc_image_container';
        $button_wrapper = '%%order_class%% .df_tc_button_wrapper';
        $icon = '%%order_class%% .et-pb-icon';
        $image = '%%order_class%% .df_tc_image_container img';
        $title = '%%order_class%% .title';
        $content = '%%order_class%% .content';
        $button = '%%order_class%% .df_tc_button';


        $fields['image_icon_color'] = array ('color' => $icon);
        $fields['image_icon_size'] = array ('font-size' => $icon);
        $fields['image_icon_bg'] = array ('background-color' => $icon);

        $fields['wrapper_margin'] = array ('margin' => $wrapper);
        $fields['wrapper_padding'] = array ('padding' => $wrapper);

        $fields['content_wrapper_margin'] = array ('margin' => $content_wrapper);
        $fields['content_wrapper_padding'] = array ('padding' => $content_wrapper);

        $fields['img_wrapper_margin'] = array ('margin' => $image_wrapper);
        $fields['img_wrapper_padding'] = array ('padding' => $image_wrapper);

        $fields['btn_wrapper_margin'] = array ('margin' => $button_wrapper);
        $fields['btn_wrapper_padding'] = array ('padding' => $button_wrapper);

        $fields['icon_padding'] = array ('padding' => $icon);
        $fields['image_padding'] = array ('margin' => $image);

        $fields['title_margin'] = array ('margin' => $title);
        $fields['title_padding'] = array ('padding' => $title);

        $fields['content_margin'] = array ('margin' => $content);
        $fields['content_padding'] = array ('padding' => $content);

        $fields['button_margin'] = array ('margin' => $button);
        $fields['button_padding'] = array ('padding' => $button);


        // background 
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'tc_button_background',
            'selector'      => '%%order_class%% .df_tc_button'
        ));
        // border transition
        $fields = $this->df_fix_border_transition(
            $fields, 
            'button', 
            $button
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'image', 
            $image
        );

        return $fields;
    }

    /**
     * Render image for the front image
     * 
     * @param String $key
     * @return HTML | markup for the image
     */
    public function df_render_image($key = '') {
        if ( isset($this->props[$key . '_use_icon']) && $this->props[$key . '_use_icon'] === 'on' ) {
            return sprintf('<div class="df_tc_image_container">
                    <span class="et-pb-icon">%1$s</span>
                </div>', 
                isset($this->props[$key . '_font_icon']) && $this->props[$key . '_font_icon'] !== '' ? 
                    esc_attr(et_pb_process_font_icon( $this->props[$key . '_font_icon'] )) : '5'
            );
        } else if ( isset($this->props[$key . '_image']) && $this->props[$key . '_image'] !== ''){
            $image_alt = $this->props[$key . '_alt_text'] !== '' ? $this->props[$key . '_alt_text']  : df_image_alt_by_url($this->props[$key . '_image']);
            $image_url = $this->props[$key . '_image'];  
            return sprintf('<div class="df_tc_image_container">
                    <img src="%1$s" alt="%2$s" />
                </div>',
                esc_url($image_url),
                esc_attr($image_alt)
            );
        }
    }

    /**
     * Render button HTML markup
     * 
     * @param String $key
     * @return String HTML markup of the button
     */
    public function df_render_button($key) {
        $text = isset($this->props[$key . '_button_text']) ? $this->props[$key . '_button_text'] : '';
        $url = isset($this->props[$key . '_button_url']) ? $this->props[$key . '_button_url'] : '';
        $target = $this->props[$key . '_button_url_new_window'] === 'on'  ? 
            'target="_blank"' : '';
        if($text !== '' || $url !== '') {
            return sprintf('<div class="df_tc_button_wrapper">
                <a class="df_tc_button" href="%1$s" %3$s>%2$s</a>
            </div>', esc_attr($url), esc_html($text), $target);
        } else { return ''; }
    }

    public function render($attr, $content, $render_slug ) {
        wp_enqueue_script('df-tilt-lib');
        wp_enqueue_script('df-tilt-script');
        $this->additional_css_styles($render_slug);

        $data_options = array(
            'reverse' => $this->props['tc_reverse'] === 'on' ? true : false,
            'max' => isset($this->props['tc_max']) ? $this->props['tc_max'] : 35,
            'perspective' => isset($this->props['tc_perspective']) ? $this->props['tc_perspective'] : 1000,
            'glare' => $this->props['tc_glare'] === 'on' ? true : false,
            'glare_opacity' => $this->props['tc_glare_opacity'],
            'scale' => isset($this->props['tc_card_scale']) ? $this->props['tc_card_scale'] : 1,
            'speed' => isset($this->props['tc_speed']) ? $this->props['tc_speed'] : 300,
            'tc_full_page' => $this->props['tc_full_page'] === 'on' ? true : false
        );

        $title = $this->props['title'] !== '' ? sprintf('<h4 class="title">%1$s</h4>', $this->props['title']) : '';
        $content = $this->props['content'] !== '' ? sprintf('<div class="content">%1$s</div>', $this->props['content']) : '';
        $content_wrapper = $title !== '' || $content !== '' ?
            sprintf('<div class="df_tc_content_container">%1$s%2$s</div>', $title, $content) : '';

        return sprintf('<div class="df_tc_container" data-options=\'%2$s\'>
                %3$s
                %1$s
                %4$s
            </div>',
            $content_wrapper,
            wp_json_encode($data_options),
            $this->df_render_image('image'),
            $this->df_render_button('tc_btn')
        );
    }
}
new DIFL_TiltCard;