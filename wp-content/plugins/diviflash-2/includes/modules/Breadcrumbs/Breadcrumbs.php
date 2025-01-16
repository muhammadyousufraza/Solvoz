<?php

class DIFL_Breadcrumbs extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_breadcrumbs';
    public $vb_support = 'on';
	public $icon_path;
    use DF_UTLS;

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Breadcrumbs', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/breadcrumbs.svg';
    }
    
    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'home'          => esc_html__( 'Home Link', 'divi_flash' ),
                    'separator'     => esc_html__( 'Separator', 'divi_flash' ),
                    'breadcrumb_settings'          => esc_html__( 'Breadcrumb Settings', 'divi_flash' )
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'alignment'     => esc_html__('Alignment', 'divi_flash'),
                    'breadcrumbs'   => esc_html__('Breadcrumbs Wrapper', 'divi_flash'),
                    'pages'         => esc_html__('Pages Link', 'divi_flash'),
                    'home'          => esc_html__('Home Link'),
                    'link_icon'    => esc_html__( 'Link Icon', 'divi_flash' ),
                    'separator'     => esc_html__('Separator Style'),
                    'separator_text'=> esc_html__('Separator Text'),
                    'active_page'   => esc_html__('Active Page Link'),
                    'custom_spacing'=> esc_html__('Custom Spacing', 'divi_flash')
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['text'] = false; 
        $advanced_fields['link_options'] = false;
        $advanced_fields['fonts'] = array(

            'pages_font'     => array(
                'toggle_slug'   => 'pages',
                'tab_slug'		=> 'advanced',
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1.7em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% .df-breadcrumbs-item .df-breadcrumbs-text',
                    'hover' => '%%order_class%% .df-breadcrumbs-item:hover .df-breadcrumbs-text',
                    'important'	=> 'all'
                )
            ),

            'home_font'     => array(
                'toggle_slug'   => 'home',
                'tab_slug'		=> 'advanced',
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1.7em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start a .df-breadcrumbs-text',
                    'hover' => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start:hover a .df-breadcrumbs-text',
                    'important'	=> 'all'
                 )
            ),
            'separator_text_font'     => array(
                'toggle_slug'   => 'separator_text',
                'tab_slug'		=> 'advanced',
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1.7em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% .df-breadcrumbs-separator .df-breadcrumbs-separator-text ,.df-breadcrumbs-separator .df-breadcrumbs-separator-icon',
                    'hover' => '%%order_class%% .df-breadcrumbs-separator:hover .df-breadcrumbs-separator-text,.df-breadcrumbs-separator:hover .df-breadcrumbs-separator-icon',
                    'important'	=> 'all'
                 )
            ),
            'active_page_font'     => array(
                'toggle_slug'   => 'active_page',
                'tab_slug'		=> 'advanced',
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1.7em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end .df-breadcrumbs-text',
                    'hover' => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end:hover .df-breadcrumbs-text',
                    'important'	=> 'all'
                 )
            ),
        );
        $advanced_fields['borders'] = array(
            'default'               => true,
            'breadcrumbs_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "%%order_class%% ul.df-breadcrumbs",
                        'border_radii_hover' => "%%order_class%% ul.df-breadcrumbs:hover",
                        'border_styles' => "%%order_class%% ul.df-breadcrumbs",
                        'border_styles_hover' => "%%order_class%% ul.df-breadcrumbs:hover",
                    )
                ),
                'label'    => esc_html__('Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'breadcrumbs',
            ),
            'pages_border'  => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "%%order_class%% .df-breadcrumbs-item",
                        'border_radii_hover' => "%%order_class%% .df-breadcrumbs-item:hover",
                        'border_styles' => "%%order_class%% .df-breadcrumbs-item",
                        'border_styles_hover' => "%%order_class%% .df-breadcrumbs-item:hover",
                    )
                ),
                'label'    => esc_html__('Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'pages',
            ),
            'home_border'  => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start",
                        'border_radii_hover' => "%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start:hover",
                        'border_styles' => "%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start",
                        'border_styles_hover' => "%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start:hover",
                    )
                ),
                'label'    => esc_html__('Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'home',
            ),
            'separator_border'  => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "%%order_class%% .df-breadcrumbs-separator",
                        'border_radii_hover' => "%%order_class%% .df-breadcrumbs-separator:hover",
                        'border_styles' => "%%order_class%% .df-breadcrumbs-separator",
                        'border_styles_hover' => "%%order_class%% .df-breadcrumbs-separator:hover",
                    )
                ),
                'label'    => esc_html__('Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'separator',
            ),
            'active_page_border'  => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end",
                        'border_radii_hover' => "%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end:hover",
                        'border_styles' => "%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end",
                        'border_styles_hover' => "%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end:hover",
                    )
                ),
                'label'    => esc_html__('Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'active_page',
            )
        );
        $advanced_fields['box_shadow'] = array(
            'default'               => true,
            'breadcrumbs_shadow'             => array(
                'label'    => esc_html__('Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% ul.df-breadcrumbs",
                    'hover' => "%%order_class%% ul.df-breadcrumbs:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'breadcrumbs',
            ),
            'home_shadow'             => array(
                'label'    => esc_html__('Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start",
                    'hover' => "%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'home',
            ),
            'pages_shadow'             => array(
                'label'    => esc_html__('Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .df-breadcrumbs-item",
                    'hover' => "%%order_class%% .df-breadcrumbs-item:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'pages',
            ),
            'separator_shadow'             => array(
                'label'    => esc_html__('Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .df-breadcrumbs-separator",
                    'hover' => "%%order_class%% .df-breadcrumbs-separator:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'separator',
            ),
            'active_page_shadow'             => array(
                'label'    => esc_html__('Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end",
                    'hover' => "%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'active_page',
            ),
        );
        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'important' => 'all'
            )
        ); 
        return $advanced_fields;
    }

	public function get_fields() {

        $title_text_settings = array(
            'enable_custom_page' => array(
				'label'                 => esc_html__( 'Custom Page Link', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'toggle_slug'           => 'breadcrumb_settings',
				'description'           => esc_html__( 'Here you can choose Custopm page item show Breadcrumbs.', 'divi_flash' )
			),
            'page_title' => array (
                'label'                 => esc_html__( 'Page Link Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'breadcrumb_settings',
                'dynamic_content'        => 'text',
                'show_if'               => array(
                    'enable_custom_page' =>  'on'
                )
            ),
            'use_page_custom_url' => array(
				'label'                 => esc_html__( 'Use Page Url', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default' => 'off',
                'affects'               => array(
                    'page_custom_url',
                    'page_custom_url_target'
				),
				'description'           => esc_html__( 'Input the destination URL for your page.', 'divi_flash' ),
                'default_on_front'      => 'off',
                'toggle_slug'           => 'breadcrumb_settings',
                'show_if_not' => array(
                    'page_title' => array('')
                ),
                'show_if'               => array(
                    'enable_custom_page' =>  'on'
                )
            ),
            'page_custom_url' => array (
                'label'                 => esc_html__( 'Page Url', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'breadcrumb_settings',
                'dynamic_content'       => 'url',
                'depends_show_if'     => 'on',
            ),
            'page_custom_url_target' => array(
                'label'           => esc_html__('Page Url Target ', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'same_window' => esc_html__('In The Same Window', 'divi_flash'),
                    'new_tab'  => esc_html__('In The New Tab', 'divi_flash'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'breadcrumb_settings',
                'depends_show_if'     => 'on',
                'description'     => esc_html__('Choose whether your link opens in a new window or not', 'divi_flash')
            ),
            'search_title' => array (
                'label'                 => esc_html__( 'Search Title', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'breadcrumb_settings',
            ),

            'error_404_title' => array (
                'label'                 => esc_html__( 'Error 404 Title', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'breadcrumb_settings',
            )
        );
        $home_settings = array(
            'home_text' => array (
                'label'                 => esc_html__( 'Home Link Text', 'divi_flash' ),
				'type'                  => 'text',
                'dynamic_content'       => 'text',
                'toggle_slug'           => 'home',
            ),
            'use_home_icon' => array(
				'label'                 => esc_html__( 'Use Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
                'toggle_slug'           => 'home',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'affects'               => array(
					'home_font_icon',
					'home_icon_color',
					'home_icon_font_size',
                    'home_icon_placement',
				),
				'description'           => esc_html__( 'Here you can choose whether icon set below should be used.', 'divi_flash' ),
                'default_on_front'      => 'off',
			),
	
            'home_font_icon' => array(
				'label'               => esc_html__( 'Icon', 'divi_flash' ),
				'type'                => 'select_icon',
				'option_category'     => 'basic_option',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'         => 'home',
				'description'         => esc_html__( 'Choose an icon to display with your Home Text.', 'divi_flash' ),
				'depends_show_if'     => 'on',
			),
           
			'home_icon_color' => array(
				'default'           => "#2ea3f2",
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
				'toggle_slug'       => 'home',
                'tab_slug'           => 'advanced',
                'hover'             => 'tabs'
			),

			'home_icon_font_size' => array(
				'label'           => esc_html__( 'Icon Font Size', 'divi_flash' ),
				'type'            => 'range',
				'option_category' => 'font_option',
				// 'tab_slug'        => 'advanced',
				'toggle_slug'     => 'home',
                'tab_slug'      => 'advanced',
				'default'         => '16px',
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
            ),
            'home_icon_placement'   => array(
                'label'             => esc_html__('Icon Placement', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'left'          => esc_html__('Left', 'divi_flash'),
                    'right'         => esc_html__('Right', 'divi_flash')
                ),
                'default'           => 'left',
                'toggle_slug'         => 'home',
                'depends_show_if'   => 'on'
            )
            
        );

        $separator = array(
            'separator_text' => array(
				'label'                 => esc_html__( 'Separator text', 'divi_flash' ),
				'type'                  => 'text',
                // 'default'               => '/',
                'toggle_slug'           => 'separator',
                'show_if_not'       => array(
                    'use_separator_icon'  => 'on',
                    'use_icon_inner_item' => 'on'
                ),
            ),
            'use_separator_icon' => array(
				'label'                 => esc_html__( 'Use Separator Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
                'default'               => 'off',
				'toggle_slug'           => 'separator',
				'affects'               => array(
					'separator_font_icon',
					'separator_icon_color',
					'separator_icon_font_size'
				),
				'description'           => esc_html__( 'Here you can choose whether Separator icon set below should be used.', 'divi_flash' ),
                'show_if_not'           => array(
                    'use_icon_inner_item' => 'on'
                )
			),
			'separator_font_icon' => array(
				'label'               => esc_html__( 'Separator Icon', 'divi_flash' ),
				'type'                => 'select_icon',
				'option_category'     => 'basic_option',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'         => 'separator',
				'description'         => esc_html__( 'Choose an icon to display for separator.', 'divi_flash' ),
				'depends_show_if'     => 'on',
			),
			'separator_icon_color' => array(
				'default'           => "#2ea3f2",
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
				'toggle_slug'       => 'separator',
                'tab_slug'          => 'advanced',
                'hover'             => 'tabs',
                'show_if_not'           => array(
                    'use_icon_inner_item' => 'on'
                )
			),
			'separator_icon_font_size' => array(
				'label'           => esc_html__( 'Icon Font Size', 'divi_flash' ),
				'type'            => 'range',
				'option_category' => 'font_option',
				// 'tab_slug'        => 'advanced',
				'toggle_slug'     => 'separator',
                'tab_slug'      => 'advanced',
				// 'default'         => '16px',
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
                'show_if_not'           => array(
                    'use_icon_inner_item' => 'on'
                )
            ),
            'use_icon_inner_item' => array(
				'label'                 => esc_html__( 'Use Link Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
                'toggle_slug'           => 'separator',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'affects'               => array(
					'inner_icon',
					'inner_icon_color',
					'inner_icon_font_size',
                    'inner_icon_spacing',
                    
				),
				'description'           => esc_html__( 'Here you can choose whether icon set below should be used.', 'divi_flash' ),
                'default_on_front'      => 'off',
			),
	
            'inner_icon' => array(
				'label'               => esc_html__( 'Link Icon', 'divi_flash' ),
				'type'                => 'select_icon',
				'option_category'     => 'basic_option',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'         => 'separator',
				'description'         => esc_html__( 'Choose an icon to display with your Home Text.', 'divi_flash' ),
				'depends_show_if'     => 'on',
			),
            'inner_icon_color' => array(
                'default'           => "#2ea3f2",
                'label'             => esc_html__( 'Inner Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
				'toggle_slug'       => 'link_icon',
                'tab_slug'          => 'advanced',
                'hover'             => 'tabs'
			),

			'inner_icon_font_size' => array(
				'label'             => esc_html__( 'Inner Icon Font Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'toggle_slug'       => 'link_icon',
                'tab_slug'          => 'advanced',
				'default'           => '16px',
				'default_unit'      => 'px',
				'default_on_front'  => '',
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
				),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
				'responsive'        => true,
            ),
            'inner_icon_spacing' => array(
				'label'           => esc_html__( 'Space Between Text and Icon', 'divi_flash' ),
				'type'            => 'range',
				'toggle_slug'     => 'link_icon',
                'tab_slug'      => 'advanced',
				'default'         => '5px',
				'default_unit'    => 'px',
				'default_on_front'=> '',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'mobile_options'  => true,
				'depends_show_if' => 'on',
				'responsive'      => true
            )
        );
        $separator_background = $this->df_add_bg_field(array(
			'label'				=> 'Background color',
            'key'               => 'separator_background',
            'toggle_slug'       => 'separator',
            'tab_slug'			=> 'advanced',
            'show_if_not' => array(
                'use_icon_inner_item' => 'on'
            )
        ));

        $breadcrumbs_background = $this->df_add_bg_field(array(
			'label'				=> 'Background color',
            'key'               => 'breadcrumbs_background',
            'toggle_slug'       => 'breadcrumbs',
            'tab_slug'			=> 'advanced'
        ));

        $pages_background = $this->df_add_bg_field(array(
			'label'				=> 'Background color',
            'key'               => 'pages_background',
            'toggle_slug'       => 'pages',
            'tab_slug'			=> 'advanced'
        ));

        $home_background = $this->df_add_bg_field(array(
			'label'				=> 'Background color',
            'key'               => 'home_background',
            'toggle_slug'       => 'home',
            'tab_slug'			=> 'advanced'
        ));

        $current_page_background = $this->df_add_bg_field(array(
			'label'				=> 'Background color',
            'key'               => 'active_page_background',
            'toggle_slug'       => 'active_page',
            'tab_slug'			=> 'advanced'
        ));
        
        // spacing
        $breadcrumbs_spacing = $this->add_margin_padding(array(
            'title'         => 'Wrapper',
            'key'           => 'breadcrumbs',
            'tab_slug'      => 'advanced',
            'default_padding' => '10px|10px|10px|10px',
            'toggle_slug'   => 'custom_spacing'
        ));

        $home_spacing = $this->add_margin_padding(array(
            'title'         => 'Home Link',
            'key'           => 'home',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'custom_spacing'
        ));

        $home_icon_spacing = $this->add_margin_padding(array(
            'title'         => 'Home Link Icon',
            'key'           => 'home_icon', 
            'tab_slug'      => 'advanced',
            'option'        => 'margin',
            'toggle_slug'   => 'custom_spacing',
            'show_if'       => array(
                'use_home_icon' => 'on'
            )
        ));
        
        $pages_spacing = $this->add_margin_padding(array(
            'title'         => 'Pages Link',
            'key'           => 'pages',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'custom_spacing'
        ));
        $separator_spacing = $this->add_margin_padding(array(
            'title'         => 'Separator',
            'key'           => 'separator',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'custom_spacing'
        ));
       
        $current_page_spacing = $this->add_margin_padding(array(
            'title'         => 'Active Page',
            'key'           => 'active_page',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'custom_spacing'
        ));
       

        $genarel_settings = array(
            'alignment'     => array(
                'label'             => esc_html__('Alignment', 'divi_flash'),
                'type'              => 'text_align',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'alignment',
                'options'           =>  et_builder_get_text_orientation_options( array( 'justified' ) ),
                'responsive'        => true,
                'mobile_options'    => true
            )
        ); 

        $breadcrumb_settings = array(
            'show_on_front_page' => array(
				'label'                 => esc_html__( 'Show On Home Page', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'toggle_slug'           => 'breadcrumb_settings',
				'description'           => esc_html__( 'Here you can choose whether Breadcrumbs show on Home page.', 'divi_flash' )
			),

            'show_title' => array(
				'label'                 => esc_html__( 'Show Title', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
                'default'               => 'on',
				'toggle_slug'           => 'breadcrumb_settings',
				'description'           => esc_html__( 'Here you can choose Title show at Breadcrumbs.', 'divi_flash' )
			),
            'enable_schema' => array(
				'label'                 => esc_html__( 'Enable Schema', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
                'default'               => 'off',
				'toggle_slug'           => 'breadcrumb_settings',
				'description'           => esc_html__( 'Here you can choose Schema show at Breadcrumbs.', 'divi_flash' )
			)
        );

 
		return array_merge(
            $separator_background,
            $separator,
            $breadcrumbs_background,
            $pages_background,
            $home_background,
            $current_page_background,
            $home_settings,
            $title_text_settings,
            $genarel_settings,
            $breadcrumb_settings,
            $breadcrumbs_spacing,
            $home_spacing,
            $home_icon_spacing,
            $separator_spacing,
            $pages_spacing,
            $current_page_spacing
        );
    }
    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $separator = '%%order_class%% .df-breadcrumbs-separator';
        $breadcrumbs = '%%order_class%% ul.df-breadcrumbs';
        $home = '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start';
        $home_icon = '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start .et-pb-icon.df-home-icon';
        $inner_icon = '%%order_class%% .df-breadcrumbs-item .df-breadcrumbs-text .et-pb-icon.df-inner-icon';
        $separator_icon = '%%order_class%% .df-breadcrumbs-item .df-breadcrumbs-text .et-pb-icon.df-separator-icon';
        $pages = '%%order_class%% .df-breadcrumbs-item';
        $active_page = '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end';
        // spacing
        $fields['breadcrumbs_margin'] = array('margin' => $breadcrumbs);
        $fields['breadcrumbs_padding'] = array('padding' => $breadcrumbs);
        $fields['pages_margin'] = array('margin' => $pages);
        $fields['pages_padding'] = array('padding' => $pages);
        $fields['current_page_margin'] = array('margin' => $active_page);
        $fields['current_page_padding'] = array('padding' => $active_page);
        $fields['home_margin'] = array('margin' => $home);
        $fields['home_padding'] = array('padding' => $home);
        $fields['home_icon_margin'] = array('margin' => $home_icon);
        $fields['inner_icon_margin'] = array('margin' => $inner_icon);
        $fields['home_icon_padding'] = array('padding' => $home_icon);
        $fields['separator_margin'] = array('margin' => $separator);
        $fields['separator_padding'] = array('padding' => $separator);

        $fields['home_icon_color'] = array('color' => $home_icon);
        $fields['inner_icon_color'] = array('color' => $inner_icon);
        $fields['separator_icon_color'] = array('color' => $separator_icon);
        // background
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'separator_background',
            'selector'      => $separator
        ));

        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'breadcrumbs_background',
            'selector'      => $breadcrumbs
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'home_background',
            'selector'      => $home
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'pages_background',
            'selector'      => $pages
        ));

        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'active_page_background',
            'selector'      => $active_page
        ));
       
        // border fix
        $fields = $this->df_fix_border_transition(
            $fields,
            'breadcrumbs_border',
            $breadcrumbs
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'home_border',
            $home
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'separator_border',
            $separator
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'pages_border',
            $pages
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'active_page_border',
            $active_page
        );
   

        // // box-shadow Fix   
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'breadcrumbs_shadow',
            $breadcrumbs
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'home_shadow',
            $home
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'pages_shadow',
            $pages
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'separator_shadow',
            $separator
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'active_page_shadow',
            $active_page
        );

        return $fields;
    }
     
    public function additional_css_styles($render_slug){
        $home = '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start';
        $pages = '%%order_class%% .df-breadcrumbs-item';
        $active_page = '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end';
     
        if ( '' !== $this->props['alignment']) {
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'alignment',
                'type'              => 'justify-content',
                'selector'          => "%%order_class%% ul.df-breadcrumbs",
                'default'           => 'left'
            ));
          
        }

        // Background

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'breadcrumbs_background',
            'selector'          => '%%order_class%% ul.df-breadcrumbs',
            'hover'             => '%%order_class%% ul.df-breadcrumbs:hover'
        ));

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'separator_background',
            'selector'          => '%%order_class%% .df-breadcrumbs-separator',
            'hover'             => '%%order_class%% .df-breadcrumbs-separator:hover'
        ));

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'home_background',
            'selector'          =>  '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start',
            'hover'             => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start:hover'
        ));

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'pages_background',
            'selector'          =>  '%%order_class%% .df-breadcrumbs-item',
            'hover'             => '%%order_class%% .df-breadcrumbs-item:hover'
        ));

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'active_page_background',
            'selector'          =>  '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end',
            'hover'             => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end:hover'
        ));

        // Home icon
        if ('on' === $this->props['use_home_icon']) {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'home_icon_color',
                'type'              => 'color',
                'selector'          => "%%order_class%% .et-pb-icon.df-home-icon",
                'hover'             => '%%order_class%% .df-breadcrumbs-text:hover .et-pb-icon.df-home-icon'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'home_icon_font_size',
                'type'              => 'font-size',
                'default'           => '16px',
                'selector'          => "%%order_class%% .et-pb-icon.df-home-icon"
            ));

        }

        // Home icon
        if ('on' === $this->props['use_icon_inner_item']) {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'inner_icon_color',
                'type'              => 'color',
                'selector'          => "%%order_class%% .et-pb-icon.df-inner-icon",
                'hover'             => '%%order_class%% .df-breadcrumbs-text:hover .et-pb-icon.df-inner-icon'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'inner_icon_font_size',
                'type'              => 'font-size',
                'default'           => '16px',
                'selector'          => "%%order_class%% .et-pb-icon.df-inner-icon"
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'inner_icon_spacing',
                'type'              => 'margin-left',
                'default'           => '5px',
                'selector'          => "%%order_class%% .et-pb-icon.df-inner-icon"
            ));

        }
        // Separator icon
        if ('on' === $this->props['use_separator_icon']) {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'separator_icon_color',
                'type'              => 'color',
                'selector'          => "%%order_class%% .et-pb-icon.df-separator-icon",
                'hover'             => '%%order_class%% .df-breadcrumbs-separator:hover .et-pb-icon.df-separator-icon'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'separator_icon_font_size',
                'type'              => 'font-size',
                // 'default'           => '16px',
                'selector'          => "%%order_class%% .df-breadcrumbs-separator .df-breadcrumbs-separator-icon"
            ));

        }
        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'home_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-home-icon',
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
                    'base_attr_name' => 'separator_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-separator-icon',
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
                    'base_attr_name' => 'inner_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-inner-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
            
            
        }

        //Custom Spacing

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'breadcrumbs_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% ul.df-breadcrumbs',
            'hover'             => '%%order_class%% ul.df-breadcrumbs:hover',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'breadcrumbs_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% ul.df-breadcrumbs',
            'hover'             => '%%order_class%% ul.df-breadcrumbs:hover',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pages_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-breadcrumbs-item',
            'hover'             => '%%order_class%% .df-breadcrumbs-item:hover',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pages_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-breadcrumbs-item',
            'hover'             => '%%order_class%% .df-breadcrumbs-item:hover',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'home_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start',
            'hover'             => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start:hover',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'home_icon_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start .df-breadcrumbs-home-icon .df-home-icon',
            'hover'             => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start:hover .df-breadcrumbs-home-icon .df-home-icon',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'home_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start',
            'hover'             => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-start:hover',
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'active_page_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end',
            'hover'             => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end:hover',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'active_page_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end',
            'hover'             => '%%order_class%% .df-breadcrumbs-item.df-breadcrumbs-end:hover',
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'separator_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-breadcrumbs-separator',
            'hover'             => '%%order_class%% .df-breadcrumbs-separator:hover',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'separator_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-breadcrumbs-separator',
            'hover'             => '%%order_class%% .df-breadcrumbs-separator:hover',
            'important'         => false
        ));

    }

  

	public function render( $attrs, $content, $render_slug ) {
       $this->handle_fa_icon();
        $settings = $this->props;
        $home_font_icon = $settings['home_font_icon'] !== '' ? esc_attr( et_pb_process_font_icon( $settings['home_font_icon'] ) ) : '&#xe074';
		$home_icon = '';
        $home_icon = $settings['use_home_icon'] !== 'off' ?
                            sprintf('<span class="et-pb-icon df-home-icon">%1$s</span>',
                                $settings['home_font_icon'] !== '' ? esc_attr( et_pb_process_font_icon( $settings['home_font_icon'] ) ) : '&#xe074'
                            ) : '';
        $home_icon_placement = $settings['home_icon_placement'] !== '' ? $settings['home_icon_placement']: 'left';
		$separator = '';
		if( 'on' === $settings['use_separator_icon'] ){
			$icon =  sprintf('<span class="et-pb-icon df-separator-icon">%1$s</span>',
                        $settings['separator_font_icon'] !== '' ? esc_attr( et_pb_process_font_icon( $settings['separator_font_icon'] ) ) : '&#x39;'
                    );
			$class = "df-breadcrumbs-separator-icon";
			$separator = sprintf( '<span class="%2$s"> %1$s </span>', $icon , $class );
		}elseif( 'off' === $settings['use_separator_icon'] && $settings['separator_text'] !== ''){
			$class = "df-breadcrumbs-separator-text";
			$separator = sprintf( '<span class="%2$s"> %1$s </span>', $settings['separator_text'] !== '' ? esc_html($settings['separator_text']) : ''  , $class );
		}
  
        $inner_icon_data = $settings['inner_icon'] !== '' ? esc_attr( et_pb_process_font_icon( $settings['inner_icon'] ) ) : '&#xe074';
        $inner_icon = '';
        $inner_icon = $settings['use_icon_inner_item'] !== 'off' ?
                            sprintf('<span class="et-pb-icon df-inner-icon">%1$s</span>',
                                $settings['inner_icon'] !== '' ? esc_attr( et_pb_process_font_icon( $settings['inner_icon'] ) ) : '&#x39;'
                            ) : '';
		$labels = array(
			'home' => isset($settings['home_text']) && $settings['home_text'] !== '' ? esc_html( $settings['home_text'] ) : '',
            'enable_custom_page' => isset($settings['enable_custom_page']) ? esc_attr( $settings['enable_custom_page'] ) : 'off',
			'page_title' => isset( $settings['page_title'] ) && $settings['page_title'] !== '' && $settings['enable_custom_page'] === 'on' ? esc_html( $settings['page_title'] ) : '',
            
            'use_page_custom_url' => isset($settings['use_page_custom_url']) ? esc_attr( $settings['use_page_custom_url'] ) : 'off',
            'page_custom_url' => isset($settings['page_custom_url']) ? esc_url( $settings['page_custom_url'] ) : '',
            'page_custom_url_target' => isset($settings['page_custom_url_target']) ? esc_attr( $settings['page_custom_url_target'] ) : 'same_window',
			'search' => isset($settings['search_title']) ? esc_html( $settings['search_title'] ).' %s' : '%s',
			'error_404' => isset($settings['error_404_title']) ? esc_html( $settings['error_404_title'] ) : '',
		);

		$args = array(
			'list_class'        => 'df-breadcrumbs',
			'item_class'        => 'df-breadcrumbs-item',
			'separator'         =>  $separator,
			'separator_class'   => 'df-breadcrumbs-separator',
			'home_icon'         => $home_icon,
            'home_icon_placement'=> $home_icon_placement,
			'home_icon_class'   => 'df-breadcrumbs-home-icon',
			'labels'            => $labels,
            'use_icon_inner_item' =>$settings['use_icon_inner_item'],
            'inner_icon'        => $inner_icon,
			'show_on_front'     => 'on' === $settings['show_on_front_page'] ? true : false,
			'show_title'        => 'on' === $settings['show_title'] ? true : false,
		);
		$breadcrumb = new Df_Breadcrumb( $args );
     
        $this->additional_css_styles($render_slug);
        $schema_script = '';
        if($this->props['enable_schema'] === 'on'){
            $schema_script = sprintf('<script type="application/ld+json">%1$s</script>', wp_json_encode($breadcrumb->trail()['schema']));
        }
        return sprintf( '<div class="df_breadcrumbs_container">
                             %2$s
                            <div class="df_breadcrumbs_wrapper">
                                %1$s
                            </div>

                        </div>' ,
                        $breadcrumb->trail()['breadcrumb'] ,
                        $schema_script
                    );
	}
}

new DIFL_Breadcrumbs;