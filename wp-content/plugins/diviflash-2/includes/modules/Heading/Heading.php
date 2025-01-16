<?php

class DIFL_Heading extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'df_adh_heading';
    public $vb_support = 'on';
	public $icon_path;
    use DF_UTLS;

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
	);

	public function init() {
        $this->name = esc_html__( 'Advanced Heading', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/advanced-heading.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'content'      => esc_html__( 'Content', 'divi_flash' ),
                    'divider'      => esc_html__( 'Divider', 'divi_flash' ),
                    'divider_background' => esc_html__( 'Divider Line Background', 'divi_flash' ),
                    'prefix_background' => esc_html__( 'Prefix Background', 'divi_flash' ),
                    'infix_background' => esc_html__( 'Infix Background', 'divi_flash' ),
                    'suffix_background' => esc_html__( 'Suffix Background', 'divi_flash' )
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'title'                 => esc_html__('Title', 'divi_flash'),
                    'dual_text'                => esc_html__('Dual Text', 'divi_flash'),
                    'prefix'                => esc_html__('Prefix', 'divi_flash'),
                    'infix'                 => esc_html__('Infix', 'divi_flash'),
                    'suffix'                => esc_html__('Suffix', 'divi_flash'),
                    // 'second_button_style'   => esc_html__('Second Button Style', 'divi_flash'),
                    'border'                => esc_html__('Border', 'divi_flash'),
                    'custom_borders'        => esc_html__('Custom border', 'divi_flash'),
                    'custom_spacing'        => esc_html__('Custom Spacing', 'divi_flash')
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();
        $advanced_fields['fonts'] = array(
            'title'   => array(
				'label'         => esc_html__( 'Title', 'divi_flash' ),
				'toggle_slug'   => 'title',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
						'default' => '1em',
					),
                'font_size' => array(
                    'default' => '24',
                ),
				'css'      => array(
                    'main' => "{$this->main_css_element} h1,
                                {$this->main_css_element} h2,
                                {$this->main_css_element} h3,
                                {$this->main_css_element} h4,
                                {$this->main_css_element} h5,
                                {$this->main_css_element} h6,
                                {$this->main_css_element} h1 span,
                                {$this->main_css_element} h2 span,
                                {$this->main_css_element} h3 span,
                                {$this->main_css_element} h4 span,
                                {$this->main_css_element} h5 span,
                                {$this->main_css_element} h6 span",
                    'hover' => "{$this->main_css_element}:hover h1,
                                {$this->main_css_element}:hover h2,
                                {$this->main_css_element}:hover h3,
                                {$this->main_css_element}:hover h4,
                                {$this->main_css_element}:hover h5,
                                {$this->main_css_element}:hover h6,
                                {$this->main_css_element}:hover h1 span,
                                {$this->main_css_element}:hover h2 span,
                                {$this->main_css_element}:hover h3 span,
                                {$this->main_css_element}:hover h4 span,
                                {$this->main_css_element}:hover h5 span,
                                {$this->main_css_element}:hover h6 span",
					'important' => 'all',
                ),
                'header_level' => array(
                    'default' => 'h3',
                ),
			),
            't_dual'   => array(
				'label'         => esc_html__( 'Dual Text', 'divi_flash' ),
				'toggle_slug'   => 'dual_text',
				'tab_slug'		=> 'advanced',
                'text_color'    => array(
                    'default'   => '#e0e0e0'
                ),
				'line_height' => array(
						'default' => '1em',
					),
					'font_size' => array(
						'default' => '30px',
					),
				'css'      => array(
                    'main' => "{$this->main_css_element} .df-heading-dual_text",
                    'hover' => "{$this->main_css_element}:hover .df-heading-dual_text",
					'important' => 'all',
                )
            ),
            't_prefix'   => array(
				'label'         => esc_html__( 'Prefix', 'divi_flash' ),
				'toggle_slug'   => 'prefix',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
						'default' => '1em',
					),
					'font_size' => array(
						'default' => '24px',
					),
				'css'      => array(
                    'main' => "{$this->main_css_element} span.prefix",
                    'hover' => "{$this->main_css_element}:hover span.prefix",
					'important' => 'all',
                )
            ),
            't_infix'   => array(
				'label'         => esc_html__( 'Infix', 'divi_flash' ),
				'toggle_slug'   => 'infix',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
						'default' => '1em',
					),
					'font_size' => array(
						'default' => '24px',
					),
				'css'      => array(
                    'main' => "{$this->main_css_element} span.infix",
                    'hover' => "{$this->main_css_element}:hover span.infix",
					'important' => 'all',
                )
			),
            't_suffix'   => array(
				'label'         => esc_html__( 'Suffix', 'divi_flash' ),
				'toggle_slug'   => 'suffix',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
						'default' => '1em',
					),
					'font_size' => array(
						'default' => '24px',
					),
				'css'      => array(
                    'main' => "{$this->main_css_element} span.suffix",
                    'hover' => "{$this->main_css_element}:hover span.suffix",
					'important' => 'all',
                )
			),
        );
        $advanced_fields['borders'] = array(
            'default'               => array(),
            'prefix_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} span.prefix",
                        'border_styles' => "{$this->main_css_element} span.prefix",
                        'border_styles_hover' => "{$this->main_css_element}:hover span.prefix",
                    )
                ),
                'label_prefix'    => esc_html__( 'Prefix', 'divi_flash' ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'custom_borders',	
            ),
            'infix_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} span.infix",
                        'border_styles' => "{$this->main_css_element} span.infix",
                        'border_styles_hover' => "{$this->main_css_element}:hover span.infix",
                    )
                ),
                'label_prefix'    => esc_html__( 'Infix', 'divi_flash' ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'custom_borders',	
            ),
            'suffix_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} span.suffix",
                        'border_styles' => "{$this->main_css_element} span.suffix",
                        'border_styles_hover' => "{$this->main_css_element}:hover span.suffix",
                    )
                ),
                'label_prefix'    => esc_html__( 'Suffix', 'divi_flash' ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'custom_borders',	
            )

        );
        $advanced_fields['box_shadow'] = array(
            'default'               => true,
            'prefix'             => array(
                'css' => array(
                    'main' => "%%order_class%% span.prefix",
                    'hover' => "%%order_class%%:hover span.prefix",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'prefix',
            ),
            'infix'             => array(
                'css' => array(
                    'main' => "%%order_class%% span.infix",
                    'hover' => "%%order_class%%:hover span.infix",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'infix',
            ),
            'suffix'             => array(
                'css' => array(
                    'main' => "%%order_class%% span.suffix",
                    'hover' => "%%order_class%%:hover span.suffix",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'suffix',
            )
        );
        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'important' => 'all'
            )
        );     
        $advanced_fields['text'] = false;     
        $advanced_fields['filters'] = false;
        // $advanced_fields['transform'] = false;
        // $advanced_fields['animation'] = false;
        // $advanced_fields['link_options'] = false;
        return $advanced_fields;
    }

    public function get_fields() {
        $heading = array(
            'title_prefix' => array(
				'label'             => esc_html__( 'Title Prefix', 'divi_flash' ),
				'type'              => 'text',
                'toggle_slug'       => 'content',
                'dynamic_content' => 'text'
            ),
            'title_prefix_block'       => array(
                'label'             => esc_html__( 'Display Element', 'divi_flash' ),
				'type'              => 'select',
                'options'           => array(
					'inline-block' => esc_html__( 'Default', 'divi_flash' ),
					'block'  => esc_html__( 'Block', 'divi_flash' ),
					'inline'  => esc_html__( 'Inline', 'divi_flash' ),
                ),
                'default'           => 'inline-block',
                'default_on_front'  => 'inline-block',
                'toggle_slug'       => 'prefix',
                'tab_slug'          => 'advanced',
                'responsive'        => true,
                'mobile_options'    => true,
                'dynamic_content' => 'text'
            ),
            'title_infix' => array(
				'label'             => esc_html__( 'Title Infix', 'divi_flash' ),
				'type'              => 'text',
                'toggle_slug'       => 'content',
                'dynamic_content' => 'text'
            ),
            'title_infix_block'       => array(
                'label'             => esc_html__( 'Display Block', 'divi_flash' ),
				'type'              => 'select',
                'options'           => array(
					'inline-block' => esc_html__( 'Default', 'divi_flash' ),
					'block'  => esc_html__( 'Block', 'divi_flash' ),
					'inline'  => esc_html__( 'Inline', 'divi_flash' ),
                ),
                'default'           => 'inline-block',
                'default_on_front'  => 'inline-block',
                'toggle_slug'       => 'infix',
                'tab_slug'          => 'advanced',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'title_suffix' => array(
				'label'             => esc_html__( 'Title Suffix', 'divi_flash' ),
				'type'              => 'text',
				'toggle_slug'       => 'content',
                'dynamic_content' => 'text'
            ),
            'title_suffix_block'       => array(
                'label'             => esc_html__( 'Display Block', 'divi_flash' ),
				'type'              => 'select',
                'options'           => array(
					'inline-block' => esc_html__( 'Default', 'divi_flash' ),
					'block'  => esc_html__( 'Block', 'divi_flash' ),
					'inline'  => esc_html__( 'Inline', 'divi_flash' ),
                ),
                'default'           => 'inline-block',
                'default_on_front'  => 'inline-block',
                'toggle_slug'       => 'suffix',
                'tab_slug'          => 'advanced',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'use_dual_text'       => array(
                'label'             => esc_html__( 'Use Dual Text', 'divi_flash' ),
				'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'dual_text',
                'tab_slug'          => 'advanced'
            ),
            'use_dual_text_custom'       => array(
                'label'             => esc_html__( 'Custom Text', 'divi_flash' ),
				'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'dual_text',
                'tab_slug'          => 'advanced',
                'show_if'           => array(
                    'use_dual_text'     => 'on'
                )
            ),
            'custom_text_input'       => array(
                'label'             => esc_html__( 'Custom Text Input', 'divi_flash' ),
				'type'              => 'text',
                'toggle_slug'       => 'dual_text',
                'tab_slug'          => 'advanced',
                'show_if'           => array(
                    'use_dual_text_custom'     => 'on'
                )
            ),
        );
        $divider = array(
            'use_divider'           => array(
                'label'             => esc_html__( 'Use Divider', 'divi_flash' ),
				'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'           => 'off',
				'toggle_slug'       => 'divider'
            ),
            'divider_position'         => array(
                'label'             => esc_html__( 'Divider Position', 'divi_flash' ),
                'type'              => 'select',
                'options'           => array(
					'bottom'        => esc_html__( 'Bottom', 'divi_flash' ),
					'top'           => esc_html__( 'Top', 'divi_flash' )
				),
                'toggle_slug'       => 'divider',
                'default'           => 'bottom',
                'show_if'           => array(
                    'use_divider'       => 'on'
                )
            ),
            'divider_style'         => array(
                'label'             => esc_html__( 'Divider Line Style', 'divi_flash' ),
                'type'              => 'select',
                'options'           => array(
					'solid'     => esc_html__( 'Default', 'divi_flash' ),
					'dotted'    => esc_html__( 'Dotted', 'divi_flash' ),
					'dashed'    => esc_html__( 'Dashed', 'divi_flash' ),
					'double'    => esc_html__( 'Double', 'divi_flash' ),
					'groove'    => esc_html__( 'Groove', 'divi_flash' ),
					'ridge'     => esc_html__( 'Ridge', 'divi_flash' )
				),
                'toggle_slug'       => 'divider',
                'default'           => 'solid',
                'show_if'           => array(
                    'use_divider'       => 'on'
                )
            ),
            'divider_color'         => array(
				'label'             => esc_html__( 'Divider Line Color', 'divi_flash' ),
				'type'              => 'color-alpha',
                'toggle_slug'       => 'divider',
                'show_if'           => array(
                    'use_divider'       => 'on'
                )
            ),
            'divider_height'        => array(
				'label'             => esc_html__( 'Divider Thickness', 'divi_flash' ),
				'type'              => 'range',
                'toggle_slug'       => 'divider',
                'default'           => '5px',
				'default_unit'      => 'px',
                'default_on_front'  => '',
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
                'show_if'           => array(
                    'use_divider'       => 'on'
                )
            ),
            'divider_border_radius'         => array(
				'label'             => esc_html__( 'Divider Border Radius', 'divi_flash' ),
				'type'              => 'range',
                'toggle_slug'       => 'divider',
                'default'           => '0px',
				'default_unit'      => 'px',
                'default_on_front'  => '',
                'hover'             => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
                'show_if'           => array(
                    'use_divider'         => 'on'
                )
            ),
            'divider_width'         => array(
				'label'             => esc_html__( 'Divider Max Width', 'divi_flash' ),
				'type'              => 'range',
                'toggle_slug'       => 'divider',
                'default'           => '100%',
				'default_unit'      => '%',
                'default_on_front'  => '',
                'hover'             => 'tabs',
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
                'show_if'           => array(
                    'use_divider'       => 'on'
                )
            ),
            'divider_alignment'         => array(
				'label'             => esc_html__( 'Divider Alignment', 'divi_flash' ),
				'type'              => 'text_align',
                'toggle_slug'       => 'divider',
				'options'           =>  et_builder_get_text_orientation_options( array( 'justified' ) ),
                'show_if'           => array(
                    'use_divider'       => 'on'
                ),
                'show_if_not'       => array(
                    'divider_width'       => '100%'
                )
            ),
            'use_divider_icon'      => array(
                'label'             => esc_html__( 'Use Divider Icon', 'divi_flash' ),
				'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'divider',
                'show_if'           => array(
                    'use_divider'   => 'on'
                ),
                'show_if_not'           => array(
                    'use_divider_image'   => 'on'
                )
            ),
            'divider_icon'          => array(
                'label'             => esc_html__( 'Icon', 'divi_flash' ),
				'type'              => 'select_icon',
				'class'             => array( 'et-pb-font-icon' ),
				'toggle_slug'       => 'divider',
				'show_if'                 => array(
                    'use_divider'         => 'on',
                    'use_divider_icon'    => 'on'
                )
            ),
            'divider_icon_alignment' => array(
                'label'             => esc_html__( 'Divider Icon Alignment', 'divi_flash' ),
				'type'              => 'text_align',
                'toggle_slug'       => 'divider',
				'options'           =>  et_builder_get_text_orientation_options( array( 'justified' ) ),
                'show_if'           => array(
                    'use_divider'         => 'on',
                    'use_divider_icon'    => 'on'
                )
            ),
            'divider_icon_color'         => array(
				'label'             => esc_html__( 'Divider Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
                'toggle_slug'       => 'divider',
                'hover'             => 'tabs',
                'show_if'           => array (
                    'use_divider'       => 'on',
                    'use_divider_icon'    => 'on'
                )
            ),
            'divider_icon_bgcolor'         => array(
				'label'             => esc_html__( 'Divider Icon Background Color', 'divi_flash' ),
				'type'              => 'color-alpha',
                'toggle_slug'       => 'divider',
                'hover'             => 'tabs',
                'default'           => 'rgba(0,0,0,0)',
                'show_if'           => array (
                    'use_divider'       => 'on',
                    'use_divider_icon'    => 'on'
                )
            ),
            'use_divider_icon_circle'      => array(
                'label'             => esc_html__( 'Icon Circle', 'divi_flash' ),
				'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'divider',
                'show_if'           => array (
                    'use_divider'       => 'on',
                    'use_divider_icon'    => 'on'
                )
            ),
            'dvr_icon_font_size'         => array(
				'label'             => esc_html__( 'Divider Icon Size', 'divi_flash' ),
				'type'              => 'range',
                'toggle_slug'       => 'divider',
                'default'           => '18px',
				'default_unit'      => 'px',
                'default_on_front'  => '',
                'hover'             => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
                'show_if'           => array(
                    'use_divider'         => 'on',
                    'use_divider_icon'    => 'on'
                )
            ),
            'use_divider_image'      => array(
                'label'             => esc_html__( 'Use Divider Image', 'divi_flash' ),
				'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'divider',
                'show_if'           => array(
                    'use_divider'   => 'on'
                ),
                'show_if_not'       => array(
                    'use_divider_icon'    => 'on'
                )
            ),
            'divider_image'         => array(
                'type'               => 'upload',
                'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Image', 'divi_flash' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'        => esc_attr__( 'Set As Image', 'divi_flash' ),
                'toggle_slug'       => 'divider',
                'show_if'           => array(
                    'use_divider'         => 'on',
                    'use_divider_image'   => 'on'
                ),
            ),
            'divider_image_alt_text' => array (
                'label'                 => esc_html__( 'Image Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'divider',
                'show_if'           => array(
                    'use_divider'         => 'on',
                    'use_divider_image'   => 'on'
                ),
            ),
            'divider_image_width'   => array(
                'label'             => esc_html__( 'Divider Image Max Width', 'divi_flash' ),
				'type'              => 'range',
                'toggle_slug'       => 'divider',
                'default'           => '100px',
				'default_unit'      => 'px',
                'default_on_front'  => '',
                'hover'             => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
                'show_if'           => array(
                    'use_divider'         => 'on',
                    'use_divider_image'    => 'on'
                )
            ),
            'divider_image_alignment' => array(
                'label'             => esc_html__( 'Divider Image Alignment', 'divi_flash' ),
                'type'              => 'text_align',
                'toggle_slug'       => 'divider',
                'options'           =>  et_builder_get_text_orientation_options( array( 'justified' ) ),
                'show_if'           => array(
                    'use_divider'         => 'on',
                    'use_divider_image'    => 'on'
                )
            ),
            'divider_image_bgcolor'         => array(
				'label'             => esc_html__( 'Divider Image Background Color', 'divi_flash' ),
				'type'              => 'color-alpha',
                'toggle_slug'       => 'divider',
                'hover'             => 'tabs',
                'default'           => 'rgba(0,0,0,0)',
                'show_if'           => array (
                    'use_divider'       => 'on',
                    'use_divider_image'    => 'on'
                )
            ),
            'use_divider_image_circle'      => array(
                'label'             => esc_html__( 'Image Circle', 'divi_flash' ),
				'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'divider',
                'show_if'           => array (
                    'use_divider'       => 'on',
                    'use_divider_image'    => 'on'
                )
            )
        ); 
        $prefix_max_width  = $this->df_add_max_width(
            array(
                'title_pefix'   => 'Prefix',
                'key'           => 'prefix',
                'toggle_slug'   => 'prefix',
                'sub_toggle'    => null,
                'alignment'     => true,
                'priority'      => 30,
                'tab_slug'      => 'advanced',
                'show_if'    => array(
                    'title_prefix_block' => 'block'
                )
            )
        );
        $infix_max_width  = $this->df_add_max_width(
            array(
                'title_pefix'   => 'Infix',
                'key'           => 'infix',
                'toggle_slug'   => 'infix',
                'sub_toggle'    => null,
                'alignment'     => true,
                'priority'      => 30,
                'tab_slug'      => 'advanced',
                'show_if'    => array(
                    'title_infix_block' => 'block'
                )
            )
        );
        $suffix_max_width  = $this->df_add_max_width(
            array(
                'title_pefix'   => 'Suffix',
                'key'           => 'suffix',
                'toggle_slug'   => 'suffix',
                'sub_toggle'    => null,
                'alignment'     => true,
                'priority'      => 30,
                'tab_slug'      => 'advanced',
                'show_if'    => array(
                    'title_suffix_block' => 'block'
                )
            )
        );
        $divider_background = $this->df_add_bg_field(array(
            'label'             => 'Divider Line Background',
            'key'               => 'divider_background',
            'toggle_slug'       => 'divider_background',
            'tab_slug'          => 'general'
        ));
        $prefix_background = $this->df_add_bg_field(array(
            'label'             => 'Prefix Background',
            'key'               => 'prefix_background',
            'toggle_slug'       => 'prefix_background',
            'tab_slug'          => 'general'
        ));
        $infix_background = $this->df_add_bg_field(array(
            'label'             => 'Infix Background',
            'key'               => 'infix_background',
            'toggle_slug'       => 'infix_background',
            'tab_slug'          => 'general'
        ));
        $suffix_background = $this->df_add_bg_field(array(
            'label'             => 'Suffix Background',
            'key'               => 'suffix_background',
            'toggle_slug'       => 'suffix_background',
            'tab_slug'          => 'general'
        ));
        $heading_spacing = $this->add_margin_padding(array(
            'title'             => 'Heading',
            'key'               => 'heading',
            'toggle_slug'       => 'margin_padding'
        ));
        $prefix_spacing = $this->add_margin_padding(array(
            'title'             => 'Prefix',
            'key'               => 'prefix',
            'toggle_slug'       => 'margin_padding'
        ));
        $infix_spacing = $this->add_margin_padding(array(
            'title'             => 'Infix',
            'key'               => 'infix',
            'toggle_slug'       => 'margin_padding'
        ));
        $suffix_spacing = $this->add_margin_padding(array(
            'title'             => 'Suffix',
            'key'               => 'suffix',
            'toggle_slug'       => 'margin_padding'
        ));
        $divider_container_spacing = $this->add_margin_padding(array(
            'title'             => 'Divider Container',
            'key'               => 'divider_container',
            'toggle_slug'       => 'margin_padding'
        ));
        $divider_spacing = $this->add_margin_padding(array(
            'title'             => 'Divider Line',
            'key'               => 'divider',
            'toggle_slug'       => 'margin_padding'
        ));
        $divider_icon_spacing = $this->add_margin_padding(array(
            'title'             => 'Divider Icon & Image',
            'key'               => 'divider_icon_image',
            'toggle_slug'       => 'margin_padding',
        ));

        $dual_text_spacing = $this->add_margin_padding(array(
            'title'             => 'Dual Text',
            'key'               => 'dual_text',
            'toggle_slug'       => 'dual_text',
        ));
        $prefix_text_clip = $this->df_text_clip(array(
            'key'                   => 'df_prefix',
            'toggle_slug'           => 'prefix',
            'tab_slug'              => 'advanced'
        ));
        $infix_text_clip = $this->df_text_clip(array(
            'key'                   => 'df_infix',
            'toggle_slug'           => 'infix',
            'tab_slug'              => 'advanced'
        ));
        $suffix_text_clip = $this->df_text_clip(array(
            'key'                   => 'df_suffix',
            'toggle_slug'           => 'suffix',
            'tab_slug'              => 'advanced'
        ));

		return array_merge(
            $heading,
            $divider,
            $divider_background,
            $prefix_max_width,
            $prefix_text_clip,
            $infix_max_width,
            $infix_text_clip,
            $suffix_max_width,
            $suffix_text_clip,
            $prefix_background,
            $infix_background,
            $suffix_background,
            $heading_spacing,
            $prefix_spacing,
            $infix_spacing,
            $suffix_spacing,
            $divider_container_spacing,
            $divider_spacing,
            $divider_icon_spacing,
            $dual_text_spacing
        );
    }

    public function additional_css_styles($render_slug) {
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_background',
            'selector'          => '%%order_class%% .df-heading-divider .df-divider-line',
            'hover'             => '%%order_class%%:hover .df-heading-divider .df-divider-line'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'prefix_background',
            'selector'          => '%%order_class%% .df-heading .prefix',
            'hover'             => '%%order_class%%:hover .df-heading .prefix'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'infix_background',
            'selector'          => '%%order_class%% .df-heading .infix',
            'hover'             => '%%order_class%%:hover .df-heading:hover .infix'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'suffix_background',
            'selector'          => '%%order_class%% .df-heading .suffix',
            'hover'             => '%%order_class%%:hover .df-heading .suffix'
        ));
    
        // heading spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'heading_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-heading',
            'hover'             => '%%order_class%%:hover .df-heading',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'heading_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-heading',
            'hover'             => '%%order_class%%:hover .df-heading',
            'important'         => true
        ));
        // prefix spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'prefix_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-heading .prefix',
            'hover'             => '%%order_class%%:hover .df-heading .prefix',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'prefix_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-heading .prefix',
            'hover'             => '%%order_class%%:hover .df-heading .prefix',
            'important'         => true
        ));
        // infix spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'infix_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-heading .infix',
            'hover'             => '%%order_class%%:hover .df-heading .infix',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'infix_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-heading .infix',
            'hover'             => '%%order_class%%:hover .df-heading .infix',
            'important'         => true
        ));
        // suffix spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'suffix_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-heading .suffix',
            'hover'             => '%%order_class%%:hover .df-heading .suffix',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'suffix_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-heading .suffix',
            'hover'             => '%%order_class%%:hover .df-heading .suffix',
            'important'         => true
        ));
        // divider spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-heading-divider .df-divider-line',
            'hover'             => '%%order_class%%:hover .df-heading-divider .df-divider-line',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-heading-divider .df-divider-line',
            'hover'             => '%%order_class%%:hover .df-heading-divider .df-divider-line',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_container_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-heading-divider',
            'hover'             => '%%order_class%%:hover .df-heading-divider',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_container_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-heading-divider',
            'hover'             => '%%order_class%%:hover .df-heading-divider',
            'important'         => true
        ));
        // Divider Icon and Image text spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_icon_image_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-heading-divider span',
            'hover'             => '%%order_class%%:hover .df-heading-divider span',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_icon_image_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-heading-divider img',
            'hover'             => '%%order_class%%:hover .df-heading-divider img',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_icon_image_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-heading-divider span',
            'hover'             => '%%order_class%%:hover .df-heading-divider span',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_icon_image_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-heading-divider img',
            'hover'             => '%%order_class%%:hover .df-heading-divider img',
            'important'         => true
        ));
        // dual_text text spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'dual_text_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-heading-dual_text',
            'hover'             => '%%order_class%%:hover .df-heading-dual_text',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'dual_text_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-heading-dual_text',
            'hover'             => '%%order_class%%:hover .df-heading-dual_text',
            'important'         => true
        ));

        // divider styles
        if (isset($this->props['divider_style']) && !empty($this->props['divider_style'])) {
            ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .df-heading-divider .df-divider-line::before',
				'declaration' => sprintf('border-top-style:%1$s !important;',
				$this->props['divider_style']),
			));
        }
        if (isset($this->props['divider_color']) && !empty($this->props['divider_color'])) {
            ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .df-heading-divider .df-divider-line::before',
				'declaration' => sprintf('border-top-color:%1$s !important;',
				$this->props['divider_color']),
			));
        }
        $divider_height = isset($this->props['divider_height']) && !empty($this->props['divider_height']) ? 
            $this->props['divider_height'] : '5px';
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df-heading-divider .df-divider-line',
            'declaration' => sprintf('top:calc(%1$s - %2$s);',
                '50%',
                $this->df_get_div_value($divider_height)
            ),
        ));
        if (isset($this->props['divider_height_tablet']) && !empty($this->props['divider_height_tablet'])) {
            ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .df-heading-divider .df-divider-line',
				'declaration' => sprintf('top:calc(%1$s - %2$s);',
                    '50%',
                    $this->df_get_div_value($this->props['divider_height_tablet'])
                ),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
			));
        }
        if (isset($this->props['divider_height_phone']) && !empty($this->props['divider_height_phone'])) {
            ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .df-heading-divider .df-divider-line',
				'declaration' => sprintf('top:calc(%1$s - %2$s);',
                    '50%',
                    $this->df_get_div_value($this->props['divider_height_phone'])
                ),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));
        }
        $this->apply_single_value(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_height',
            'type'              => 'border-top-width',
            'selector'          => '%%order_class%% .df-heading-divider .df-divider-line::before',
            'unit'              => 'px',
            'default'           => '5'
        ));
        $this->apply_single_value(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_height',
            'type'              => 'height',
            'selector'          => '%%order_class%% .df-heading-divider .df-divider-line',
            'unit'              => 'px',
            'default'           => '5'
        ));
        $this->apply_single_value(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_width',
            'type'              => 'max-width',
            'selector'          => '%%order_class%% .df-heading-divider',
            'unit'              => '%',
            'hover'             => '%%order_class%%:hover .df-heading-divider',
            'default'           => '100'
        ));
        if (isset($this->props['divider_alignment']) && !empty($this->props['divider_alignment'])) {
            if ( $this->props['divider_alignment'] === 'center' ) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df-heading-divider',
                    'declaration' => 'margin: 0 auto;'
                ));
            }
            if ( $this->props['divider_alignment'] === 'right' ) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df-heading-divider',
                    'declaration' => 'margin: 0 0 0 auto;'
                ));
            }
        }
        if ( $this->props['use_divider_icon'] !== 'on' && $this->props['use_divider_image'] !== 'on' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-heading-divider::before',
                'declaration' => 'position: relative;'
            ));
        }
        if ( $this->props['use_divider_icon_circle'] === 'on' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-heading-divider .et-pb-icon',
                'declaration' => 'border-radius: 50%;'
            ));
        }
        if ( $this->props['use_divider_image_circle'] === 'on' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-heading-divider img',
                'declaration' => 'border-radius: 50%;'
            ));
        }
        $this->apply_single_value(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_border_radius',
            'type'              => 'border-radius',
            'selector'          => '%%order_class%% .df-heading-divider .df-divider-line:before',
            'unit'              => 'px',
            'hover'             => '%%order_class%%:hover .df-heading-divider .df-divider-line:before',
            'default'           => '0'
        ));
        $this->apply_single_value(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_border_radius',
            'type'              => 'border-radius',
            'selector'          => '%%order_class%% .df-heading-divider .df-divider-line',
            'unit'              => 'px',
            'hover'             => '%%order_class%%:hover .df-heading-divider .df-divider-line',
            'default'           => '0'
        ));
        $this->apply_single_value(array(
            'render_slug'       => $render_slug,
            'slug'              => 'dvr_icon_font_size',
            'type'              => 'font-size',
            'selector'          => '%%order_class%% .df-heading-divider span',
            'unit'              => 'px',
            'hover'             => '%%order_class%%:hover .df-heading-divider .et-pb-icon',
            'default'           => '18'
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df-heading-divider .et-pb-icon',
            'hover'             => '%%order_class%%:hover .df-heading-divider .et-pb-icon'
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_icon_bgcolor',
            'type'              => 'background-color',
            'selector'          => '%%order_class%% .df-heading-divider .et-pb-icon',
            'hover'             => '%%order_class%%:hover .df-heading-divider .et-pb-icon'
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_image_bgcolor',
            'type'              => 'background-color',
            'selector'          => '%%order_class%% .df-heading-divider img',
            'hover'             => '%%order_class%%:hover .df-heading-divider img'
        ));
        if ( !empty($this->props['divider_icon_alignment']) && $this->props['use_divider_icon'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-heading-divider',
                'declaration' => sprintf('text-align: %1$s;', $this->props['divider_icon_alignment'])
            ));
        }
        $this->apply_single_value(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_image_width',
            'type'              => 'max-width',
            'selector'          => '%%order_class%% .df-heading-divider .divider-image',
            'unit'              => 'px',
            'hover'             => '%%order_class%%:hover .df-heading-divider .divider-image',
            'default'           => '100'
        ));
        if ( !empty($this->props['divider_image_alignment']) &&  $this->props['use_divider_image'] == 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-heading-divider',
                'declaration' => sprintf('text-align: %1$s;', $this->props['divider_image_alignment'])
            ));
        }
        // Display Element
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_prefix_block',
            'type'              => 'display',
            'selector'          => '%%order_class%% .df-heading .prefix',
            'hover'             => '%%order_class%%:hover .df-heading .prefix',
            'default'           => 'inline-block'
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_infix_block',
            'type'              => 'display',
            'selector'          => '%%order_class%% .df-heading .infix',
            'hover'             => '%%order_class%%:hover .df-heading .infix',
            'default'           => 'inline-block'
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_suffix_block',
            'type'              => 'display',
            'selector'          => '%%order_class%% .df-heading .suffix',
            'hover'             => '%%order_class%%:hover .df-heading .suffix',
            'default'           => 'inline-block'
        ));

        // process max-width and alignment
        $this->df_process_maxwidth(array(
            'render_slug'       => $render_slug,
            'slug'              => 'prefix',
            'selector'          => '%%order_class%% .df-heading .prefix',
            'hover'             => '%%order_class%%:hover .df-heading .prefix',
            'alignment'         => true,
            'important'         => true
        ));
        $this->df_process_maxwidth(array(
            'render_slug'       => $render_slug,
            'slug'              => 'infix',
            'selector'          => '%%order_class%% .df-heading .infix',
            'hover'             => '%%order_class%%:hover .df-heading .infix',
            'alignment'         => true,
            'important'         => true
        ));
        $this->df_process_maxwidth(array(
            'render_slug'       => $render_slug,
            'slug'              => 'suffix',
            'selector'          => '%%order_class%% .df-heading .suffix',
            'hover'             => '%%order_class%%:hover .df-heading .suffix',
            'alignment'         => true,
            'important'         => true
        ));

        // text clip 
        $this->df_process_text_clip(array(
            'render_slug'       => $render_slug,
            'slug'              => 'df_prefix',
            'selector'          => '%%order_class%% .df-heading .prefix',
            'hover'             => '%%order_class%%:hover .df-heading .prefix',
        ));
        $this->df_process_text_clip(array(
            'render_slug'       => $render_slug,
            'slug'              => 'df_infix',
            'selector'          => '%%order_class%% .df-heading .infix',
            'hover'             => '%%order_class%%:hover .df-heading .infix',
        ));
        $this->df_process_text_clip(array(
            'render_slug'       => $render_slug,
            'slug'              => 'df_suffix',
            'selector'          => '%%order_class%% .df-heading .suffix',
            'hover'             => '%%order_class%%:hover .df-heading .suffix',
        ));

        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'divider_icon',
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
        $prefix = '%%order_class%% .df-heading .prefix';
        $infix = '%%order_class%% .df-heading .infix';
        $suffix = '%%order_class%% .df-heading .suffix';
        $heading = '%%order_class%% .df-heading';
        $divider_line_container = '%%order_class%% .df-heading-divider';
        $divider_line = '%%order_class%% .df-heading-divider .df-divider-line';
        $divider_icon = '%%order_class%% .df-heading-divider span';
        $divider_img = '%%order_class%% .df-heading-divider img';
        $dual_text = '%%order_class%% .df-heading-dual_text';

        // spacing
        $fields['heading_margin'] = array('margin' => $heading);
        $fields['heading_padding'] = array('padding' => $heading);

        $fields['prefix_margin'] = array('margin' => $prefix);
        $fields['prefix_padding'] = array('padding' => $prefix);

        $fields['infix_margin'] = array('margin' => $infix);
        $fields['infix_padding'] = array('padding' => $infix);

        $fields['suffix_margin'] = array('margin' => $suffix);
        $fields['suffix_padding'] = array('padding' => $suffix);

        $fields['divider_margin'] = array('margin' => $divider_line);
        $fields['divider_padding'] = array('padding' => $divider_line);

        $fields['divider_container_margin'] = array('margin' => $divider_line_container);
        $fields['divider_container_padding'] = array('padding' => $divider_line_container);

        $fields['divider_icon_image_margin'] = array('margin' => $divider_icon);
        $fields['divider_icon_image_padding'] = array('padding' => $divider_icon);
        $fields['divider_icon_image_margin'] = array('margin' => $divider_img);
        $fields['divider_icon_image_padding'] = array('padding' => $divider_img);

        $fields['dual_text_margin'] = array('margin' => $dual_text);
        $fields['dual_text_padding'] = array('padding' => $dual_text);

        // others
        $fields['divider_width'] = array('max-width' => $divider_line_container);

        $fields['divider_border_radius'] = array('border-radius' => '%%order_class%% .df-heading-divider .df-divider-line:before');
        $fields['divider_border_radius'] = array('border-radius' => $divider_line);

        $fields['dvr_icon_font_size'] = array('font-size' => $divider_icon);

        $fields['divider_icon_color'] = array('color' => '%%order_class%% .df-heading-divider .et-pb-icon');

        $fields['divider_icon_bgcolor'] = array('background-color' => '%%order_class%% .df-heading-divider .et-pb-icon');
        $fields['divider_image_bgcolor'] = array('background-color' => $divider_img);

        $fields['divider_image_width'] = array('max-width' => '%%order_class%% .df-heading-divider .divider-image');

        $fields['prefix_maxwidth'] = array('max-width' => $prefix);
        $fields['infix_maxwidth'] = array('max-width' => $infix);
        $fields['suffix_maxwidth'] = array('max-width' => $suffix);

        $fields['df_prefix_fill_color'] = array('-webkit-text-fill-color' => $prefix);
        $fields['df_prefix_fill_color'] = array('-webkit-text-stroke-color' => $prefix);
        $fields['df_prefix_stroke_width'] = array('-webkit-text-stroke-width' => $prefix);

        $fields['df_infix_fill_color'] = array('-webkit-text-fill-color' => $infix);
        $fields['df_infix_fill_color'] = array('-webkit-text-stroke-color' => $infix);
        $fields['df_infix_stroke_width'] = array('-webkit-text-stroke-width' => $infix);

        $fields['df_suffix_fill_color'] = array('-webkit-text-fill-color' => $suffix);
        $fields['df_suffix_fill_color'] = array('-webkit-text-stroke-color' => $suffix);
        $fields['df_suffix_stroke_width'] = array('-webkit-text-stroke-width' => $suffix);

        // background
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'divider_background',
            'selector'      => $divider_line
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'prefix_background',
            'selector'      => $prefix
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'infix_background',
            'selector'      => $infix
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'suffix_background',
            'selector'      => $suffix
        ));

        return $fields;
    }

    public function get_custom_css_fields_config() {}

    public function render_divider($position, $value) {
        $divider_icon = '';
        if ($this->props['use_divider_icon'] === 'on') {
            $divider_icon = !empty($this->props['divider_icon']) && $this->props['divider_icon'] !== null ?
                sprintf('<span class="et-pb-icon">%1$s</span>', 
                    html_entity_decode( et_pb_process_font_icon( $this->props['divider_icon'] ) ) ) :
                    '<span class="et-pb-icon">1</span>';
        }
        if ($this->props['use_divider_image'] === 'on') {
            $image_alt = $this->props['divider_image_alt_text'] !== '' ? $this->props['divider_image_alt_text']  : df_image_alt_by_url($this->props['divider_image']);
            $divider_icon = !empty($this->props['divider_image']) && $this->props['divider_image'] !== null ?
                sprintf('<img alt="%2$s" src="%1$s" class="divider-image"/>', 
                    $this->props['divider_image'],
                    $image_alt
                ) : '';
        }
        if ($value === $position) {
            return $this->props['use_divider'] === 'on' ? 
                sprintf('<div class="df-heading-divider"><div class="df-divider-line"></div>%1$s</div>', $divider_icon) : '';
        }
    }

    public function render( $attrs, $content, $render_slug ) {
		$this->handle_fa_icon();
        $heading_classes = '';
        $dual_text_title = '';
        $divider_position = '' !== $this->props['divider_position'] ? 
            $this->props['divider_position'] : 'bottom';
        $title_level  = $this->props['title_level'];
        $title_prefix = !empty($this->props['title_prefix']) ? 
            sprintf('<span class="prefix">%1$s</span>',$this->props['title_prefix']) : '';
        $title_infix = !empty($this->props['title_infix']) ? 
            sprintf('<span class="infix">%1$s</span>',$this->props['title_infix']) : '';
        $title_suffix = !empty($this->props['title_suffix']) ? 
            sprintf('<span class="suffix">%1$s</span>',$this->props['title_suffix']) : '';

        $title = sprintf('%1$s %2$s %3$s', $title_prefix, $title_infix, $title_suffix);

        $this->additional_css_styles($render_slug);

        if ( $this->props['use_dual_text'] === 'on') {
            $dual_title = sprintf('%1$s %2$s %3$s',$this->props['title_prefix'],$this->props['title_infix'],$this->props['title_suffix']);

            if ( $this->props['use_dual_text_custom'] !== 'on') {
                $dual_text_title = sprintf('<div class="df-heading-dual_text" data-title="%1$s"></div>', 
                wp_strip_all_tags(trim($dual_title))) ;
            } else {
                $dual_text_title = sprintf('<div class="df-heading-dual_text" data-title="%1$s"></div>', 
                wp_strip_all_tags($this->props['custom_text_input'])) ;
            }
            
            $heading_classes .= ' has-dual-text';
        }

        return sprintf( '<div class="df-heading-container%6$s">
                %3$s
                %5$s
                <%2$s class="df-heading">%1$s</%2$s>
                %4$s
            </div>', 
            $title,
            et_pb_process_header_level( $title_level, 'h3' ),
            $this->render_divider('top', $divider_position),
            $this->render_divider('bottom', $divider_position),
            $dual_text_title,
            $heading_classes
        );
    }
}
new DIFL_Heading;