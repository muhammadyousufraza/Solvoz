<?php

class DIFL_DualButton extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_dual_button';
    public $vb_support = 'on';
	public $icon_path;
    use DF_UTLS;

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Dual Button', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/dual-button.svg';
    }
    
    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'left_button'          => esc_html__( 'Left Button', 'divi_flash' ),
                    'right_button'         => esc_html__( 'Right Button', 'divi_flash' ),
                    'separator'             => esc_html__( 'Button Separator', 'divi_flash' ),
                    'btn_left_background'   => esc_html__( 'Left Button Background', 'divi_flash' ),
                    'btn_right_background'  => esc_html__( 'Right Button Background', 'divi_flash' )
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'alignment'             => esc_html__('Alignment', 'divi_flash'),
                    'button_styles'                => esc_html__('Button Styles', 'divi_flash'),
                    'left_button_text'      => esc_html__('Left Button Text', 'divi_flash'),
                    'left_button_style'     => esc_html__('Left Button Style', 'divi_flash'),
                    'right_button_text'     => esc_html__('Right Button Text', 'divi_flash'),
                    'right_button_style'    => esc_html__('Right Button Style', 'divi_flash'),
                    'separator_font'        => esc_html__('Separator Text', 'divi_flash'),
                    'separator_style'       => esc_html__('Separator Style', 'divi_flash'),
                    'border'                => esc_html__('Border', 'divi_flash'),
                    'custom_spacing'        => esc_html__('Custom Spacing', 'divi_flash')
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['fonts'] = array(
            'left_button'   => array(
				'label'         => esc_html__( 'Left Button', 'divi_flash' ),
				'toggle_slug'   => 'left_button_text',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '20px',
                ),
				'css'      => array(
					'main' => "%%order_class%% .df_button_left",
					'important' => 'all',
				),
			),
            'right_button'   => array(
				'label'         => esc_html__( 'Right Button', 'divi_flash' ),
				'toggle_slug'   => 'right_button_text',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '20px',
                ),
				'css'      => array(
					'main' => "%%order_class%% .df_button_right",
					'important' => 'all',
				),
			),
            'separator'   => array(
				'label'         => esc_html__( 'Separator', 'divi_flash' ),
				'toggle_slug'   => 'separator_font',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array(
						'default' => '1em',
					),
					'font_size' => array(
						'default' => '14px',
					),
				'css'      => array(
					'main' => "%%order_class%% .button-separator",
					'important' => 'all',
				),
			)
        );
        $advanced_fields['borders'] = array(
            'default'               => false,
            'left_button'             => array(
                'css'             => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .df_button_left",
                        'border_styles' => "%%order_class%% .df_button_left",
                        'border_styles_hover' => "%%order_class%% .df_button_left:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'left_button_style',
            ),
            'right_button'             => array(
                'css'             => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .df_button_right",
                        'border_styles' => "%%order_class%% .df_button_right",
                        'border_styles_hover' => "%%order_class%% .df_button_right:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'right_button_style',	
            ),
            'separator'             => array(
                'css'             => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .button-separator",
                        'border_styles' => "%%order_class%% .button-separator",
                        'border_styles_hover' => "%%order_class%% .button-separator:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'separator_style',	
            ),
            'left_button_wrapper'      => array(
                'css'             => array(
                    'main' => array(
                        'border_radii' => "body #page-container {$this->main_css_element} 
                            .df_button_left_wrapper",
                        'border_styles' => "body #page-container {$this->main_css_element} 
                            .df_button_left_wrapper",
                        'border_styles_hover' => "body #page-container {$this->main_css_element} 
                            .df_button_left_wrapper:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'border',
                'label_prefix'      => esc_html__( 'Left Button Wrapper', 'divi_flash' )
            ),
            'right_button_wrapper'      => array(
                'css'             => array(
                    'main' => array(
                        'border_radii' => "body #page-container {$this->main_css_element} .df_button_right_wrapper",
                        'border_styles' => "body #page-container {$this->main_css_element} .df_button_right_wrapper",
                        'border_styles_hover' => "body #page-container {$this->main_css_element} .df_button_right_wrapper:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'border',	
                'label_prefix'      => esc_html__( 'Right Button Wrapper', 'divi_flash' )
            )
        );
        $advanced_fields['box_shadow'] = array(
            'default'               => false,
            'separator'             => array(
                'css' => array(
                    'main' => "%%order_class%% .button-separator",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'separator_style',
            ),
            'left_button'             => array(
                'css' => array(
                    'main' => "%%order_class%% .df_button_left",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'left_button_style',
            ),
            'right_button'             => array(
                'css' => array(
                    'main' => "%%order_class%% .df_button_right",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'right_button_style',
            )
        );
        $advanced_fields['text'] = false;     
        $advanced_fields['filters'] = false;
        $advanced_fields['transform'] = false;
        $advanced_fields['animation'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['background'] = false;
        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'main'      => "{$this->main_css_element}.et_pb_module",
                'important' => 'all'
            )
        );
        return $advanced_fields;
    }

	public function get_fields() {
        $left_button = array(
            'left_button' => array(
				'label'           => esc_html__( 'Text', 'divi_flash' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Text for button one.', 'divi_flash' ),
				'toggle_slug'     => 'left_button',
                'dynamic_content' => 'text',
			),
            'left_button_url' => array(
				'label'           => esc_html__( 'URL', 'divi_flash' ),
				'type'            => 'text',
				'description'     => esc_html__( 'URL for button one.', 'divi_flash' ),
				'toggle_slug'     => 'left_button',
                'dynamic_content' => 'url'
            ),
            'left_button_target' => array(
                'label'           => esc_html__( 'Link Target', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
					'off' => esc_html__( 'In The Same Window', 'divi_flash' ),
					'on'  => esc_html__( 'In The New Tab', 'divi_flash' ),
				),
				'description'     => esc_html__( 'URL target button one.', 'divi_flash' ),
                'toggle_slug'     => 'left_button',
                'default_on_front'=> 'off',
                'default'=> 'off'
            )
        );
        $right_button = array(
            'right_button' => array(
				'label'           => esc_html__( 'Text', 'divi_flash' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Text for button two.', 'divi_flash' ),
				'toggle_slug'     => 'right_button',
                'dynamic_content' => 'text'
            ),
            'right_button_url' => array(
				'label'           => esc_html__( 'URL', 'divi_flash' ),
				'type'            => 'text',
				'description'     => esc_html__( 'URL for button two.', 'divi_flash' ),
				'toggle_slug'     => 'right_button',
                'dynamic_content' => 'url'
            ),
            'right_button_target' => array(
                'label'           => esc_html__( 'Link Target', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
					'off' => esc_html__( 'In The Same Window', 'divi_flash' ),
					'on'  => esc_html__( 'In The New Tab', 'divi_flash' ),
				),
				'description'     => esc_html__( 'URL target button two.', 'divi_flash' ),
                'toggle_slug'     => 'right_button',
                'default_on_front'=> 'off',
                'default'=> 'off'
            )
        );
        $separator = array(
            'button_separator'  => array(
                'label'           => esc_html__( 'Use button separator', 'divi_flash' ),
				'type'            => 'yes_no_button',
                'options'         => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'         => 'off',
				'toggle_slug'     => 'separator'
            ),
            'separator_text' => array(
				'label'                 => esc_html__( 'Separator text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'separator',
                'dynamic_content' => 'text',
                'show_if'       => array(
                    'button_separator'  => 'on'
                ),
                'show_if_not'       => array(
                    'use_icon'  => 'on'
                )
            ),
            'use_icon' => array(
				'label'                 => esc_html__( 'Use Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'toggle_slug'           => 'separator',
				'affects'               => array(
					'font_icon',
					'icon_color',
					'use_icon_font_size',
                    'icon_alignment',
                    'separator_text'
				),
				'description'           => esc_html__( 'Here you can choose whether icon set below should be used.', 'divi_flash' ),
                'default_on_front'      => 'off',
                'show_if'       => array(
                    'button_separator'  => 'on'
                ),
			),
			'font_icon' => array(
				'label'               => esc_html__( 'Icon', 'divi_flash' ),
				'type'                => 'select_icon',
				'option_category'     => 'basic_option',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'         => 'separator',
				'description'         => esc_html__( 'Choose an icon to display with your blurb.', 'divi_flash' ),
				'depends_show_if'     => 'on',
			),
			'icon_color' => array(
				'default'           => "#2ea3f2",
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
				'toggle_slug'       => 'separator',
			),
			'use_icon_font_size' => array(
				'label'           => esc_html__( 'Use Icon Font Size', 'divi_flash' ),
				'type'            => 'yes_no_button',
				'option_category' => 'font_option',
				'options'         => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'affects'     => array(
					'icon_font_size',
				),
				'depends_show_if' => 'on',
				// 'tab_slug'        => 'advanced',
				'toggle_slug'     => 'separator',
				'default_on_front'=> 'off',
			),
			'icon_font_size' => array(
				'label'           => esc_html__( 'Icon Font Size', 'divi_flash' ),
				'type'            => 'range',
				'option_category' => 'font_option',
				// 'tab_slug'        => 'advanced',
				'toggle_slug'     => 'separator',
				'default'         => '18px',
				'default_unit'    => 'px',
				'default_on_front'=> '',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
				),
				'mobile_options'  => true,
				'depends_show_if' => 'on',
				'responsive'      => true,
            )
            // 'separator_background' => array(
			// 	'default'         => "#ffffff",
			// 	'label'           => esc_html__( 'Background color', 'divi_flash' ),
			// 	'type'            => 'color-alpha',
			// 	'tab_slug'        => 'advanced',
			// 	'toggle_slug'     => 'separator_style',
			// ),
        );
        $separator_background = $this->df_add_bg_field(array(
			'label'				=> 'Background color',
            'key'               => 'separator_background',
            'toggle_slug'       => 'separator_style',
            'tab_slug'			=> 'advanced'
        ));
        $genarel_settings = array(
            'alignment'     => array(
                'label'             => esc_html__('Alignment', 'divi_flash'),
                'type'              => 'text_align',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'button_styles',
                'options'           =>  et_builder_get_text_orientation_options( array( 'justified' ) ),
                'responsive'        => true,
                'mobile_options'    => true
            )
        ); 
        $left_button_wrapper = $this->add_margin_padding(array(
            'title'         => 'Left Button Wrapper',
            'key'           => 'left_button_wrapper',
            'toggle_slug'   => 'margin_padding',
        ));
        $right_button_wrapper = $this->add_margin_padding(array(
            'title'         => 'Right Button Wrapper',
            'key'           => 'right_button_wrapper',
            'toggle_slug'   => 'margin_padding',
        ));
        $left_button_spacing = $this->add_margin_padding(array(
            'title'         => 'Left Button',
            'key'           => 'left_button',
            'toggle_slug'   => 'margin_padding',
        ));
        $right_button_spacing = $this->add_margin_padding(array(
            'title'         => 'Right Button',
            'key'           => 'right_button',
            'toggle_slug'   => 'margin_padding',
        ));
        $button_separator = $this->add_margin_padding(array(
            'title'         => 'Button separator',
            'key'           => 'button_separator',
            'toggle_slug'   => 'margin_padding',
        ));
        $btn_left_background = $this->df_add_bg_field(array(
			'label'				=> 'Left Button Background',
            'key'               => 'btn_left_background',
            'toggle_slug'       => 'left_button_style',
            'tab_slug'			=> 'advanced'
		));
        $btn_right_background = $this->df_add_bg_field(array(
			'label'				=> 'Right Button Background',
            'key'               => 'btn_right_background',
            'toggle_slug'       => 'right_button_style',
            'tab_slug'			=> 'advanced'
        ));
        $btn_left_icon = array(
            'use_left_button_icon' => array(
				'label'                 => esc_html__( 'Use Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'affects'               => array(
                    'btn_left_font_icon',
                    'btn_left_icon_color',
                    'btn_left_icon_placement',
                    'btn_left_icon_font_size',
                    'btn_left_icon_gap'
				),
				'description'           => esc_html__( 'Here you can choose whether icon set below should be used.', 'divi_flash' ),
                'default_on_front'      => 'on',
                'toggle_slug'           => 'left_button_style',
                'tab_slug'              => 'advanced'  
            ),
            'btn_left_font_icon' => array(
				'label'               => esc_html__( 'Icon', 'divi_flash' ),
				'type'                => 'select_icon',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'         => 'left_button_style',
                'tab_slug'            => 'advanced' ,
				'description'         => esc_html__( 'Choose an icon to display with your blurb.', 'divi_flash' ),
				'depends_show_if'     => 'on',
            ),
            'btn_left_icon_color' => array(
				'default'           => "#2ea3f2",
				'default_on_front'	=> true,
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
				'toggle_slug'       => 'left_button_style',
                'tab_slug'          => 'advanced' ,
                'hover'             => 'tabs'
            ),
            'btn_left_icon_font_size' => array(
				'label'           => esc_html__( 'Icon Font Size', 'divi_flash' ),
				'type'            => 'range',
				'option_category' => 'font_option',
                'toggle_slug'       => 'left_button_style',
                'tab_slug'          => 'advanced' ,
				'default_unit'    => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
				),
				'mobile_options'  => true,
				'responsive'      => true,
                'depends_show_if'   => 'on'
            ),
            'btn_left_icon_placement'   => array(
                'label'             => esc_html__('Icon Placement', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'left'          => esc_html__('Left', 'divi_flash'),
                    'right'         => esc_html__('Right', 'divi_flash')
                ),
                'default'           => 'right',
                'toggle_slug'       => 'left_button_style',
                'tab_slug'          => 'advanced',
                'depends_show_if'   => 'on'
            ),
            'btn_left_icon_gap' => array(
				'label'           => esc_html__( 'Gap Between Icon and Text', 'divi_flash' ),
				'type'            => 'range',
                'toggle_slug'       => 'left_button_style',
                'tab_slug'          => 'advanced' ,
                'default'         => '7px',
				'default_unit'    => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
				),
				'mobile_options'  => true,
				'responsive'      => true,
                'depends_show_if'   => 'on'
            ),
        );
        $btn_right_icon = array(
            'use_right_button_icon' => array(
				'label'                 => esc_html__( 'Use Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'affects'               => array(
                    'btn_right_font_icon',
                    'btn_right_icon_color',
                    'btn_right_icon_placement',
                    'btn_right_icon_font_size',
                    'btn_right_icon_gap'
				),
				'description'           => esc_html__( 'Here you can choose whether icon set below should be used.', 'divi_flash' ),
                'default_on_front'      => 'on',
                'toggle_slug'           => 'right_button_style',
                'tab_slug'              => 'advanced'  
            ),
            'btn_right_font_icon' => array(
				'label'               => esc_html__( 'Icon', 'divi_flash' ),
				'type'                => 'select_icon',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'         => 'right_button_style',
                'tab_slug'            => 'advanced' ,
				'description'         => esc_html__( 'Choose an icon to display with your blurb.', 'divi_flash' ),
				'depends_show_if'     => 'on',
            ),
            'btn_right_icon_color' => array(
				'default'           => "#2ea3f2",
				'default_on_front'	=> true,
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
				'toggle_slug'       => 'right_button_style',
                'tab_slug'          => 'advanced',
                'hover'             => 'tabs'
            ),

            'btn_right_icon_font_size' => array(
				'label'           => esc_html__( 'Icon Font Size', 'divi_flash' ),
				'type'            => 'range',
                'toggle_slug'       => 'right_button_style',
                'tab_slug'          => 'advanced' ,
				'default_unit'    => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
				),
				'mobile_options'  => true,
				'responsive'      => true,
                'depends_show_if'   => 'on'
            ),

            'btn_right_icon_placement'   => array(
                'label'             => esc_html__('Icon Placement', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'left'          => esc_html__('Left', 'divi_flash'),
                    'right'         => esc_html__('Right', 'divi_flash')
                ),
                'default'           => 'right',
                'toggle_slug'       => 'right_button_style',
                'tab_slug'          => 'advanced',
                'depends_show_if'   => 'on'
            ),

            'btn_right_icon_gap' => array(
				'label'           => esc_html__( 'Gap Between Icon and Text', 'divi_flash' ),
				'type'            => 'range',
				'option_category' => 'font_option',
                'toggle_slug'       => 'right_button_style',
                'tab_slug'          => 'advanced' ,
                'default'         => '7px',
				'default_unit'    => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
				),
				'mobile_options'  => true,
				'responsive'      => true,
                'depends_show_if'   => 'on'
            ),
        );
        $layout = array(
            'button_style'   => array(
                'label'             => esc_html__('Button Style', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'row'         => esc_html__('Horizontal', 'divi_flash'),
                    'column'         => esc_html__('Vertical', 'divi_flash'),
                ),
                'default'           => 'row',
                'toggle_slug'       => 'button_styles',
                'tab_slug'			=> 'advanced',
                'responsive'        => true,
                'mobile_options'    => true
            ),
        );

		return array_merge(
           $btn_left_background,
            $btn_left_icon,
            $btn_right_background,
            $btn_right_icon,
            $left_button,
            $right_button,
            $separator,
            $separator_background,
            $left_button_wrapper,
            $right_button_wrapper,
            $left_button_spacing,
            $right_button_spacing,
            $button_separator,
            $layout,
            $genarel_settings
        );
    }
    
    public function additional_css_styles($render_slug){
        
        $alignment = array(
            'left' => 'flex-start',
            'center'   => 'center',
            'right'=> 'flex-end',
            'justified'=> 'space-between'
        );
        // Flex Director for responsiveness updated at version 1.3.1
        $this->df_process_string_attr(array(
            'render_slug'           => $render_slug,
            'slug'                  => 'button_style',
            'type'                  => 'flex-direction',
            'selector'              => "%%order_class%% .df_button_container",
            'default'               => 'row'
        ));

        if (isset($this->props['alignment']) && !empty($this->props['alignment'])) {
            $css_property = isset($this->props['button_style']) && $this->props['button_style'] === 'column' ? 'align-items' : 'justify-content';
            $css_property_tablet = isset($this->props['button_style_tablet']) && $this->props['button_style_tablet'] === 'column' ? 'align-items' : $css_property;
            $css_property_phone = isset($this->props['button_style_phone']) && $this->props['button_style_phone'] === 'column' ? 'align-items' : $css_property_tablet;

            ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_button_container',
                    'declaration' => sprintf('%2$s:%1$s !important;',
                    $alignment[$this->props['alignment']],
                    $css_property
                ),
            ));
            if (isset($this->props['alignment_tablet']) && !empty($this->props['alignment_tablet'])) {
               
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_button_container',
                    'declaration' => sprintf('%2$s:%1$s !important;',
                        $alignment[$this->props['alignment_tablet']],
                        $css_property_tablet
                    ),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
            }
            if (isset($this->props['alignment_phone']) && !empty($this->props['alignment_phone'])) {
             
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_button_container',
                    'declaration' => sprintf('%2$s:%1$s !important;',
                        $alignment[$this->props['alignment_phone']],
                        $css_property_phone
                    ),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }
        }
        // process custom background
        $this->df_process_bg( array(
            'render_slug'       => $render_slug,
            'slug'              => 'btn_left_background',
            'selector'          => "{$this->main_css_element} .df_button_left",
            'hover'             => "{$this->main_css_element} .df_button_left:hover"
        ) );
        $this->df_process_bg( array(
            'render_slug'       => $render_slug,
            'slug'              => 'btn_right_background',
            'selector'          => "{$this->main_css_element} .df_button_right",
            'hover'             => "{$this->main_css_element} .df_button_right:hover"
        ) );
        $this->df_process_bg( array(
            'render_slug'       => $render_slug,
            'slug'              => 'separator_background',
            'selector'          => "{$this->main_css_element} .button-separator",
            'hover'             => "{$this->main_css_element} .button-separator:hover"
        ) );
        // left button wrapper
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'left_button_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_button_left_wrapper',
            'hover'             => '%%order_class%% .df_button_left_wrapper:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'left_button_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_button_left_wrapper',
            'hover'             => '%%order_class%% .df_button_left_wrapper:hover',
        ));
        // right button wrapper
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'right_button_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_button_right_wrapper',
            'hover'             => '%%order_class%% .df_button_right_wrapper:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'right_button_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_button_right_wrapper',
            'hover'             => '%%order_class%% .df_button_right_wrapper:hover',
        ));
        // left button
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'left_button_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_button_left",
            'hover'             => "{$this->main_css_element} .df_button_left:hover",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'left_button_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_button_left",
            'hover'             => "{$this->main_css_element} .df_button_left:hover",
        ));
        // right button
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'right_button_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_button_right",
            'hover'             => "{$this->main_css_element} .df_button_right:hover",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'right_button_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_button_right",
            'hover'             => "{$this->main_css_element} .df_button_right:hover",
        ));
        // button separator spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_separator_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .button-separator',
            'hover'             => '%%order_class%% .button-separator:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_separator_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .button-separator',
            'hover'             => '%%order_class%% .button-separator:hover',
        ));
        if ( $this->props['use_icon'] === 'on' && $this->props['use_icon_font_size'] === 'on') {
            $this->apply_single_value(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_font_size',
                'selector'          => '%%order_class%% .button-separator .et-pb-icon',
                'unit'              => 'px',
                'type'              => 'font-size'
            ));
        }

        if ( $this->props['use_left_button_icon'] === 'on') {
            $this->apply_single_value(array(
                'render_slug'       => $render_slug,
                'slug'              => 'btn_left_icon_font_size',
                'selector'          => '%%order_class%% .df_button_left .et-pb-icon',
                'unit'              => 'px',
                'type'              => 'font-size'
            ));

            $this->apply_single_value(array(
                'render_slug'       => $render_slug,
                'slug'              => 'btn_left_icon_gap',
                'selector'          => '%%order_class%% .df_button_left .et-pb-icon',
                'unit'              => 'px',
                'type'              =>  $this->props['btn_left_icon_placement'] === 'right' ? 'margin-left' : 'margin-right'
            ));       
        }

        if ( $this->props['use_right_button_icon'] === 'on') {
            $this->apply_single_value(array(
                'render_slug'       => $render_slug,
                'slug'              => 'btn_right_icon_font_size',
                'selector'          => '%%order_class%% .df_button_right .et-pb-icon',
                'unit'              => 'px',
                'type'              => 'font-size'
            ));

            $this->apply_single_value(array(
                'render_slug'       => $render_slug,
                'slug'              => 'btn_right_icon_gap',
                'selector'          => '%%order_class%% .df_button_right .et-pb-icon',
                'unit'              => 'px',
                'type'              =>  $this->props['btn_right_icon_placement'] === 'right' ? 'margin-left' : 'margin-right'
            ));  
        }

        $this->apply_custom_transition(
			$render_slug,
			'%%order_class%%, %%order_class%% *'
        );
        
        // left icon styles
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'btn_left_icon_color',
            'selector'          => '%%order_class%% .df_button_left .et-pb-icon',
            'hover'             => '%%order_class%% .df_button_left:hover .et-pb-icon',
            'type'              => 'color'
        ));
        // right icon styles
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'btn_right_icon_color',
            'selector'          => '%%order_class%% .df_button_right .et-pb-icon',
            'hover'             => '%%order_class%% .df_button_right:hover .et-pb-icon',
            'type'              => 'color'
        ));

        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-btn-saparator-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'btn_left_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-left-btn-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'btn_right_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-right-btn-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }
    }
    public function get_custom_css_fields_config() {
        $custom_css = array();

        $custom_css['left_button'] = array(
            'label'    => esc_html__( 'Left Button', 'divi_flash' ),
			'selector' => '%%order_class%% .df_button_left_wrapper .df_button_left',
        );
        $custom_css['right_button'] = array(
            'label'    => esc_html__( 'Right Button', 'divi_flash' ),
			'selector' => '%%order_class%% .df_button_right_wrapper .df_button_right',
        );
        $custom_css['button_separator'] = array(
            'label'    => esc_html__( 'Button Separator', 'divi_flash' ),
			'selector' => '%%order_class%% .button-separator',
        );

        return $custom_css;
    }

	public function render( $attrs, $content, $render_slug ) {
		$this->handle_fa_icon();
        $font_icon                      = $this->props['font_icon'];
		$use_icon                       = $this->props['use_icon'];
		$icon_color                     = $this->props['icon_color'];
		$use_icon_font_size             = $this->props['use_icon_font_size'];
		$icon_font_size                 = $this->props['icon_font_size'];
		$icon_font_size_tablet          = $this->props['icon_font_size_tablet'];
		$icon_font_size_phone           = $this->props['icon_font_size_phone'];
        $icon_font_size_last_edited     = $this->props['icon_font_size_last_edited'];
        $btn_left_font_icon             = $this->props['btn_left_font_icon'];
        $btn_right_font_icon            = $this->props['btn_right_font_icon'];
        $left_btn_icon_pos              = $this->props['btn_left_icon_placement'];
        $right_btn_icon_pos             = $this->props['btn_right_icon_placement'];
        
        // left icon
        $left_button_icon = $this->props['use_left_button_icon'] !== 'off' ? sprintf('<span class="et-pb-icon df-left-btn-icon">%1$s</span>',
            $btn_left_font_icon !== '' ? esc_attr( et_pb_process_font_icon( $btn_left_font_icon ) ) : '5'
        ) : '';
        $right_button_icon = $this->props['use_right_button_icon'] !== 'off' ? sprintf('<span class="et-pb-icon df-right-btn-icon">%1$s</span>',
            $btn_right_font_icon !== '' ? esc_attr( et_pb_process_font_icon( $btn_right_font_icon ) ) : '5'
        ) : '';

        $left_button = !empty($this->props['left_button']) ? 
            sprintf('<div class="df_button_left_wrapper">
                <a href="%2$s" class="df_button_left%5$s" %6$s>%4$s%1$s%3$s</a>
            </div>', $this->props['left_button'],
                $this->props['left_button_url'],
                $left_btn_icon_pos !== 'left' ? $left_button_icon : '',
                $left_btn_icon_pos === 'left' ? $left_button_icon : '',
                $left_btn_icon_pos === 'left' ? ' icon-left' : '',
                $this->props['left_button_target'] === 'on' ? 'target="_blank"' : ''
            ) : null;
        $right_button = !empty($this->props['right_button']) ? 
            sprintf('<div class="df_button_right_wrapper">
                <a href="%2$s" class="df_button_right%5$s" %6$s>%4$s%1$s%3$s</a>
            </div>', $this->props['right_button'],
                $this->props['right_button_url'],
                $right_btn_icon_pos !== 'left' ? $right_button_icon : '',
                $right_btn_icon_pos === 'left' ? $right_button_icon : '',
                $right_btn_icon_pos === 'left' ? ' icon-left' : '',
                $this->props['right_button_target'] === 'on' ? 'target="_blank"' : ''
            ) : null;

        $separator_content = '';
        if ( 'on' == $use_icon) {
            $icon_style = sprintf( 'color: %1$s;', esc_attr( $icon_color ) );

			$separator_content = ( '' !== $font_icon ) ? sprintf(
				'<span class="et-pb-icon df-btn-saparator-icon" style="%2$s">%1$s</span>',
				esc_attr( et_pb_process_font_icon( $font_icon ) ),
				$icon_style
			) : '';
        } else {
            $separator_content .= $this->props['separator_text'];
        }
        $separator = $this->props['button_separator'] === 'on' ? 
            sprintf('<div class="button-separator">%1$s</div>', 
            $separator_content) : null;

        $this->additional_css_styles($render_slug);

        return sprintf( '<div class="df_button_container">%1$s %3$s %2$s</div>', 
            $left_button, $right_button, $separator );
	}
}

new DIFL_DualButton;
