<?php

class DIFL_ContentSwitcher extends ET_Builder_Module
{
    public $slug       = 'difl_contentswitcher';
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
        $this->name = esc_html__('Content Toggle', 'divi_flash');
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/content-toggle.svg';
    }

    public function get_settings_modal_toggles()
    {
        return array(
            'general'  => array(
                'toggles' => array(
                    'switcher_content'                 => esc_html__('Toggle Content', 'divi_flash'),
                    'switcher_control'                 => esc_html__('Toggle Control', 'divi_flash'),
                    'badge_settings'                   => esc_html__('Badges', 'divi_flash'),
                    'animation_settings'               => esc_html__('Content Animation', 'divi_flash'),
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'switcher'          => esc_html__('Toggle Bar', 'divi_flash'),
                    'primary_label'     => esc_html__('Primary Label', 'divi_flash'),
                    'secondary_label'   => esc_html__('Secondary Label', 'divi_flash'),
                    'active_label'      => esc_html__('Active Label', 'divi_flash'),
                    'primary_control'   => esc_html__('Primary Toggle Switch', 'divi_flash'),
                    'secondary_control' => esc_html__('Secondary Toggle Switch', 'divi_flash'),
                    'primary_button'    => esc_html__('Primary Button', 'divi_flash'),
                    'secondary_button'  => esc_html__('Secondary Button', 'divi_flash'),
                    'active_button'     => esc_html__('Active Button', 'divi_flash'),
                    'button_design'     => esc_html__('Button', 'divi_flash'),
                    'switcher_bar'      => esc_html__('Toggle Bar', 'divi_flash'),
                    'switcher_content'  => esc_html__('Toggle Content', 'divi_flash'),
                    'switcher_content_text'   => array(
						'title'             => esc_html__('Toggle Content Text', 'divi_flash'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'     => array(
								'name' => 'P',
								'icon' => 'text-left',
							),
							'a'     => array(
								'name' => 'A',
								'icon' => 'text-link',
							),
							'ul'    => array(
								'name' => 'UL',
								'icon' => 'list',
							),
							'ol'    => array(
								'name' => 'OL',
								'icon' => 'numbered-list',
							),
							'quote' => array(
								'name' => 'QUOTE',
								'icon' => 'text-quote',
							),
						),
					),
					'switcher_content_header' => array(
						'title'             => esc_html__( 'Toggle Content Heading', 'et_builder' ),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'h1' => array(
								'name' => 'H1',
								'icon' => 'text-h1',
							),
							'h2' => array(
								'name' => 'H2',
								'icon' => 'text-h2',
							),
							'h3' => array(
								'name' => 'H3',
								'icon' => 'text-h3',
							),
							'h4' => array(
								'name' => 'H4',
								'icon' => 'text-h4',
							),
							'h5' => array(
								'name' => 'H5',
								'icon' => 'text-h5',
							),
							'h6' => array(
								'name' => 'H6',
								'icon' => 'text-h6',
							),
						),
                    ),
                    'badge_settings'                   => esc_html__('Primary Badge', 'divi_flash'),
                    'secondary_badge_settings'                   => esc_html__('Secondary Badge', 'divi_flash'),
                    'custom_spacing'    => esc_html__('Custom Spacing', 'divi_flash'),
                )
            ),
        );
    }
    public function get_advanced_fields_config()
    {
        $advanced_fields = array();
        $advanced_fields['text'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['fonts'] = array(
            'primary_label_font'     => array(
                'toggle_slug'   => 'primary_label',
                'tab_slug'		=> 'advanced',
                'hide_text_align'  => true,
                'hide_font_color'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% .df-cs-switch.primary span.title',
                    'hover' => '%%order_class%% .df-cs-switch.primary:hover span.title',
                    'important'	=> 'all'
                )
            ),

            'secondary_label_font'     => array(
                'toggle_slug'   => 'secondary_label',
                'tab_slug'		=> 'advanced',
                'hide_text_align'  => true,
                'hide_font_color'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% .df-cs-switch.secondary span.title',
                    'hover' => '%%order_class%% .df-cs-switch.secondary:hover span.title',
                    'important'	=> 'all'
                )
            ),

            'active_label_font'     => array(
                'toggle_slug'   => 'active_label',
                'tab_slug'		=> 'advanced',
                'hide_text_align'  => true,
                'hide_font_color'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% .df-cs-switch.active span.title',
                    'hover' => '%%order_class%% .df-cs-switch.active:hover span.title',
                    'important'	=> 'all'
                )
            ),

            'primary_button_font'     => array(
                'toggle_slug'   => 'primary_button',
                'tab_slug'		=> 'advanced',
                'hide_text_align'  => true,
                'hide_font_color'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% button.df-cs-button.primary span.title',
                    'hover' => '%%order_class%% button.df-cs-button.primary:hover span.title',
                    'important'	=> 'all'
                ),
                'show_if' => array(
                    'switcher_type' => array('button')
                )
            ),

            'secondary_button_font'     => array(
                'toggle_slug'   => 'secondary_button',
                'tab_slug'		=> 'advanced',
                'hide_text_align'  => true,
                'hide_font_color'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% button.df-cs-button.secondary span.title',
                    'hover' => '%%order_class%% button.df-cs-button.secondary:hover span.title',
                    'important'	=> 'all'
                )
            ),

            'active_button_font'     => array(
                'toggle_slug'   => 'active_button',
                'tab_slug'		=> 'advanced',
                'hide_text_align'  => true,
                'hide_font_color'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% button.df-cs-button.active span.title',
                    'hover' => '%%order_class%% button.df-cs-button.active:hover span.title',
                    'important'	=> 'all'
                )
            ),
            
            'primary_badge_font'     => array(
                'toggle_slug'   => 'badge_settings',
                'tab_slug'		=> 'advanced',
                'hide_color'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% .df-cs-primary-badge',
                    'hover' => '%%order_class%% .df-cs-primary-badge:hover',
                    'important'	=> 'all'
                )
            ),
            'secondary_badge_font'     => array(
                'toggle_slug'   => 'secondary_badge_settings',
                'tab_slug'		=> 'advanced',
                'hide_color'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => '%%order_class%% .df-cs-secondary-badge',
                    'hover' => '%%order_class%% .df-cs-secondary-badge:hover',
                    'important'	=> 'all'
                )
            ),
            'text'     => array(
                'label'           => et_builder_i18n( 'Text' ),
                'css'             => array(
                    'main'        => "{$this->main_css_element} .df-cs-content-section",
                    'line_height' => "{$this->main_css_element} .df-cs-content-section",
                    'color'       => "{$this->main_css_element} .df-cs-content-section"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'toggle_slug'     => 'switcher_content_text',
                'sub_toggle'      => 'p',
                // 'hide_text_align' => true,
            ),
            'link'     => array(
                'label'       => et_builder_i18n( 'Link' ),
                'css'         => array(
                    'main'  => "{$this->main_css_element} .df-cs-content-section a",
                    'color' => "{$this->main_css_element} .df-cs-content-section a",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'hide_text_align' => true,
                'toggle_slug' => 'switcher_content_text',
                'sub_toggle'  => 'a',
            ),
            'ul'       => array(
                'label'       => esc_html__( 'Unordered List', 'et_builder' ),
                'css'         => array(
                    'main'        => "{$this->main_css_element} .df-cs-content-section ul li",
                    'color'       => "{$this->main_css_element} .df-cs-content-section ul li",
                    'line_height' => "{$this->main_css_element} .df-cs-content-section ul li",
                    'item_indent' => "{$this->main_css_element} .df-cs-content-section ul",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'switcher_content_text',
                'sub_toggle'  => 'ul',
            ),
            'ol'       => array(
                'label'       => esc_html__( 'Ordered List', 'et_builder' ),
                'css'         => array(
                    'main'        => "{$this->main_css_element} .df-cs-content-section ol li",
                    'color'       => "{$this->main_css_element} .df-cs-content-section ol li",
                    'line_height' => "{$this->main_css_element} .df-cs-content-section ol li",
                    'item_indent' => "{$this->main_css_element} .df-cs-content-section ol",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'switcher_content_text',
                'sub_toggle'  => 'ol',
            ),
            'quote'    => array(
                'label'       => esc_html__( 'Blockquote', 'et_builder' ),
                'css'         => array(
                    'main'  => "{$this->main_css_element} .df-cs-content-section blockquote",
                    'color' => "{$this->main_css_element} .df-cs-content-section blockquote",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'switcher_content_text',
                'sub_toggle'  => 'quote',
            ),
            'header'   => array(
                'label'       => esc_html__( 'Heading', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df-cs-content-section h1",
                ),
                'font_size'   => array(
                    'default' => absint( et_get_option( 'body_header_size', '30' ) ) . 'px',
                ),
                'toggle_slug' => 'switcher_content_header',
                'sub_toggle'  => 'h1',
            ),
            'header_2' => array(
                'label'       => esc_html__( 'Heading 2', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df-cs-content-section h2",
                ),
                'font_size'   => array(
                    'default' => '26px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'switcher_content_header',
                'sub_toggle'  => 'h2',
            ),
            'header_3' => array(
                'label'       => esc_html__( 'Heading 3', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df-cs-content-section h3",
                ),
                'font_size'   => array(
                    'default' => '22px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'switcher_content_header',
                'sub_toggle'  => 'h3',
            ),
            'header_4' => array(
                'label'       => esc_html__( 'Heading 4', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df-cs-content-section h4",
                ),
                'font_size'   => array(
                    'default' => '18px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'switcher_content_header',
                'sub_toggle'  => 'h4',
            ),
            'header_5' => array(
                'label'       => esc_html__( 'Heading 5', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df-cs-content-section h5",
                ),
                'font_size'   => array(
                    'default' => '16px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'switcher_content_header',
                'sub_toggle'  => 'h5',
            ),
            'header_6' => array(
                'label'       => esc_html__( 'Heading 6', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df-cs-content-section h6",
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'switcher_content_header',
                'sub_toggle'  => 'h6',
            )
            
        );
        $advanced_fields['borders'] = array(     
            'switcher_bar_border'                 => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-cs-switch-wrapper',
                        'border_radii_hover' => '%%order_class%% .df-cs-switch-wrapper:hover',
                        'border_styles' => '%%order_class%% .df-cs-switch-wrapper',
                        'border_styles_hover' => '%%order_class%% .df-cs-switch-wrapper:hover',
                    )
                ),
                'toggle_slug'           => 'switcher',
                'tab_slug'              => 'advanced'
            ),
            'switcher_content_border'                 => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-cs-content-section',
                        'border_radii_hover' => '%%order_class%% .df-cs-content-section:hover',
                        'border_styles' => '%%order_class%% .df-cs-content-section',
                        'border_styles_hover' => '%%order_class%% .df-cs-content-section:hover',
                    )
                ),
                'toggle_slug'           => 'switcher_content',
                'tab_slug'              => 'advanced'
            ),
            'primary_button_border'                 => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.primary',
                        'border_radii_hover' => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.primary:hover',
                        'border_styles' => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.primary',
                        'border_styles_hover' => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.primary:hover',
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|30px|30px|30px|30px',
                    'border_styles' => array(
                        'width' => '0px|0px|0px|0px',
                        'color' => '#eee',
                        'style' => 'solid'
                    )
                ),
                'toggle_slug'           => 'primary_button',
                'tab_slug'              => 'advanced'
            ),
            'secondary_button_border'                 => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.secondary',
                        'border_radii_hover' => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.secondary:hover',
                        'border_styles' => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.secondary',
                        'border_styles_hover' => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.secondary:hover',
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|30px|30px|30px|30px',
                    'border_styles' => array(
                        'width' => '0px|0px|0px|0px',
                        'color' => '#eee',
                        'style' => 'solid'
                    )
                ),
                'toggle_slug'           => 'secondary_button',
                'tab_slug'              => 'advanced'
            ),
            'active_button_border'                 => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.active',
                        'border_radii_hover' => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.active:hover',
                        'border_styles' => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.active',
                        'border_styles_hover' => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.active:hover',
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|30px|30px|30px|30px',
                    'border_styles' => array(
                        'width' => '0px|0px|0px|0px',
                        'color' => '#eee',
                        'style' => 'solid'
                    )
                ),
                'toggle_slug'           => 'active_button',
                'tab_slug'              => 'advanced'
            ),
            'badge_border'                 => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-cs-primary-badge',
                        'border_radii_hover' => '%%order_class%% .df-cs-primary-badge:hover',
                        'border_styles' => '%%order_class%% .df-cs-primary-badge',
                        'border_styles_hover' => '%%order_class%% .df-cs-primary-badge:hover',
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|5px|5px|5px|5px',
                    'border_styles' => array(
                        'width' => '0px|0px|0px|0px',
                        'color' => '#eee',
                        'style' => 'solid'
                    )
                ),
                'toggle_slug'           => 'badge_settings',
                'tab_slug'              => 'advanced'
            ),
            
            'secondary_badge_border'                 => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-cs-secondary-badge',
                        'border_radii_hover' => '%%order_class%% .df-cs-secondary-badge:hover',
                        'border_styles' => '%%order_class%% .df-cs-secondary-badge',
                        'border_styles_hover' => '%%order_class%% .df-cs-secondary-badge:hover',
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|5px|5px|5px|5px',
                    'border_styles' => array(
                        'width' => '0px|0px|0px|0px',
                        'color' => '#eee',
                        'style' => 'solid'
                    )
                ),
                'toggle_slug'           => 'secondary_badge_settings',
                'tab_slug'              => 'advanced'
            ),
        );
        $advanced_fields['box_shadow'] = array(
            'switcher_content_box_shadow'=> array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df-cs-content-section",
                    'hover' => "{$this->main_css_element} .df-cs-content-section:hover",
                ),
                'toggle_slug'           => 'switcher_content',
                'tab_slug'              => 'advanced'
            ),
            'switcher_bar_box_shadow'=> array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df-cs-switch-wrapper",
                    'hover' => "{$this->main_css_element} .df-cs-switch-wrapper:hover",
                ),
                'toggle_slug'           => 'switcher',
                'tab_slug'              => 'advanced'
            ),
            'primary_button_box_shadow'=> array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df-cs-switch-wrapper .df-cs-button.primary",
                    'hover' => "{$this->main_css_element} .df-cs-switch-wrapper .df-cs-button.primary:hover",
                ),
                'toggle_slug'           => 'primary_button',
                'tab_slug'              => 'advanced'
            ),
            'secondary_button_box_shadow'=> array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df-cs-switch-wrapper .df-cs-button.secondary",
                    'hover' => "{$this->main_css_element} .df-cs-switch-wrapper .df-cs-button.secondary:hover",
                ),
                'toggle_slug'           => 'secondary_button',
                'tab_slug'              => 'advanced'
            ),
            'active_button_box_shadow'=> array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df-cs-switch-wrapper .df-cs-button.active",
                    'hover' => "{$this->main_css_element} .df-cs-switch-wrapper .df-cs-button.active:hover",
                ),
                'toggle_slug'           => 'active_button',
                'tab_slug'              => 'advanced'
            ),
            'badge_box_shadow'=> array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df-cs-primary-badge",
                    'hover' => "{$this->main_css_element} .df-cs-primary-badge:hover",
                ),
                'toggle_slug'           => 'badge_settings',
                'tab_slug'              => 'advanced'
            ),
            'secondary_badge_box_shadow'=> array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df-cs-secondary-badge",
                    'hover' => "{$this->main_css_element} .df-cs-secondary-badge:hover",
                ),
                'toggle_slug'           => 'secondary_badge_settings',
                'tab_slug'              => 'advanced'
            )
        );
        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'important' => 'all'
            )
        );
        return $advanced_fields;
    }

    public function get_fields()
    {
        $switcher = array(
    
            'primary_label_title' => array(
                'label'                 => esc_html__('Primary Label', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'switcher_content',
                'dynamic_content'       => 'text'              
            ),
            'secondary_label_title' => array(
                'label'                 => esc_html__('Secondary Label', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'switcher_content',
                'dynamic_content'       => 'text'                
            ),
            'content_switcher_type'   => array(
                'label'             => esc_html__('Content Type', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'content_base'         => esc_html__('Content', 'divi_flash'),
                    'shortcode_base'         => esc_html__('Shortcode', 'divi_flash'),
                    'library_base'      => esc_html__('Library', 'divi_flash'),
                    'class_base'         => esc_html__('Html Class', 'divi_flash')
                ),
                'default'           => 'content_base',
                'toggle_slug'       => 'switcher_content'
            ),
            'content' => array(
                'label'           => esc_html__('Primary Content', 'divi_flash'),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Content entered here will appear inside Primary Content.', 'divi_flash'),
                'toggle_slug'     => 'switcher_content',
                'dynamic_content'       => 'text',
                'show_if' => array(
                    'content_switcher_type' => array('content_base')
                )
            ),  

            'secondary_content' => array(
                'label'           => esc_html__('Secondary Content', 'divi_flash'),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Content entered here will appear inside Secondary Content.', 'divi_flash'),
                'toggle_slug'     => 'switcher_content',
                'dynamic_content'       => 'text',
                'show_if' => array(
                    'content_switcher_type' => array('content_base')
                )
            ),
            'shortcode_primary_content' => array(
                'label'                 => esc_html__('Primary Shortcode', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'switcher_content' ,
                'show_if' => array(
                    'content_switcher_type' => array('shortcode_base')
                ),
                'computed_affects' => [
	                '__shortcode_primary_content',
                ]
            ),
            '__shortcode_primary_content'        => array(
	            'type'                => 'computed',
	            'computed_callback'   => array( 'DIFL_ContentSwitcher', 'handle_shortcode_content' ),
	            'computed_depends_on' => array(
		            'shortcode_primary_content'
	            )
            ),

            'shortcode_secondary_content' => array(
                'label'                 => esc_html__('Secondary Shortcode', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'switcher_content',
                'show_if' => array(
                    'content_switcher_type' => array('shortcode_base')
                ),
                'computed_affects' => [
	                '__shortcode_secondary_content',
                ]
            ),
            '__shortcode_secondary_content'        => array(
	            'type'                => 'computed',
	            'computed_callback'   => array( 'DIFL_ContentSwitcher', 'handle_shortcode_content' ),
	            'computed_depends_on' => array(
		            'shortcode_secondary_content'
	            )
            ),
            'library_id_primary'        => array(
				'label'            => __( 'Primary Content Library', 'divi_flash' ),
				'type'             => 'select',
                'default'          => 'none',
				'options'          => df_load_library(),
				'toggle_slug'      => 'switcher_content',
                'show_if' => array(
                    'content_switcher_type' => array('library_base')
                ),
				'computed_affects' => [
					'__library_content_primary',
				]
            ),
            '__library_content_primary'        => array(
	            'type'                => 'computed',
	            'computed_callback'   => array( 'DIFL_ContentSwitcher', 'handle_library_content' ),
	            'computed_depends_on' => array(
		            'library_id_primary'
	            )
            ),

            'library_id_secondary'        => array(
				'label'            => __( 'Secondary Content Library', 'divi_flash' ),
				'type'             => 'select',
                'default'           => 'none',
				'options'          => df_load_library(),
				'toggle_slug'      => 'switcher_content',
                'show_if'          => array(
                    'content_switcher_type' => array('library_base')
                ),
				'computed_affects' => [
					'__library_content_secondary',
				]
            ),
            '__library_content_secondary'        => array(
	            'type'                => 'computed',
	            'computed_callback'   => array( 'DIFL_ContentSwitcher', 'handle_library_content' ),
	            'computed_depends_on' => array(
		            'library_id_secondary'
	            )
            ),

            'primary_content_selector' => array(
				'label'           => esc_html__( '', 'divi_flash' ),
				'type'            => 'generate_button',
                'button_text'     => 'Copy',
                'prefix_class'    => 'df_cs_primary',
                'toggle_slug'     => 'switcher_content',
                'show_if' => array(
                    'content_switcher_type' => array('class_base')
                ) 
			),

            'secondary_content_selector' => array(
				'label'           => esc_html__( '', 'divi_flash' ),
				'type'            => 'generate_button',
                'button_text'     => 'Copy',
                'prefix_class'    => 'df_cs_secondary',
                'toggle_slug'     => 'switcher_content',
                'show_if' => array(
                    'content_switcher_type' => array('class_base')
                ) 
			)
        );
       
        $switcher_controll_settings = array(
            'switcher_type'   => array(
                'label'             => esc_html__('Toggle Type', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'round'       => esc_html__('Round', 'divi_flash'),
                    'round-2'     => esc_html__('Round 2', 'divi_flash'),
                    'square'      => esc_html__('Square', 'divi_flash'),
                    'square-2'    => esc_html__('Square 2', 'divi_flash'),
                    'button'      => esc_html__('Button', 'divi_flash'),
                ),
                'default'           => 'round',
                'toggle_slug'       => 'switcher_control'
            )
        );
        $primary_icon_settings = $this->df_add_icon_settings(array(
            'title'                 => 'Primary Label Icon',
            'key'                   => 'primary_title',
            'toggle_slug'           => 'switcher_control',
            'default_size'          => '16px',
            'icon_alignment'        => false,
            'image_styles'          => true,
            'circle_icon'           => false,
            'icon_color'            => true,
            'icon_size'             => true,
            'image'                 => false,
            'image_title'           => 'Primary Label Image'
        ));
        $primary_icon_align = array(
            'primary_icon_align' => array(
                'label'             => esc_html__('Primary Icon Alignment', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'left'       => esc_html__('left', 'divi_flash'),
                    'right'     => esc_html__('right', 'divi_flash')
                ),
                'default'           => 'left',
                'toggle_slug'       => 'switcher_control',
                'show_if'           => array(
                    'primary_title_use_icon' => 'on'
                )
            )
        );
        $secondary_icon_settings = $this->df_add_icon_settings(array(
            'title'                 => 'Secondary Label Icon',
            'key'                   => 'secondary_title',
            'toggle_slug'           => 'switcher_control',
            'default_size'          => '16px',
            'image_styles'          => true,
            'circle_icon'           => false,
            'icon_color'            => true,
            'icon_size'             => true,
            'image'                 => false,
            'image_title'           => 'Secondary Label Image'
        ));
        $secondary_icon_align = array(
            'secondary_icon_align' => array(
                'label'             => esc_html__('Secondary Icon Alignment', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'left'       => esc_html__('left', 'divi_flash'),
                    'right'     => esc_html__('right', 'divi_flash')
                ),
                'default'           => 'left',
                'toggle_slug'       => 'switcher_control',
                'show_if'           => array(
                    'secondary_title_use_icon' => 'on'
                )
            )
        );
        $primary_icon_hide_on_mobile = array(
            'primary_icon_hide_on_mobile'    => array(
                'label'             => esc_html__('Hide On Mobile', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'switcher_control',
                'show_if'           => array(
                    'primary_title_use_icon' => 'on'
                )
            )
        );
        $secondary_icon_hide_on_mobile = array(  
            'secondary_icon_hide_on_mobile'    => array(
                'label'             => esc_html__('Hide On Mobile', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'switcher_control',
                'show_if'           => array(
                    'secondary_title_use_icon' => 'on'
                )
            ),
        );
        $active_icon_style = array(
            'enable_active_icon_color'    => array(
                'label'             => esc_html__('Active Icon Color', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'switcher_control',
               
            ),
            'active_icon_color'            => array (
                'label'             => esc_html__( 'Color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'description'       => esc_html__( 'Here you can define a custom color for Active Icon.', 'divi_flash' ),
                'toggle_slug'       => 'switcher_control',
                'hover'             => 'tabs',
                'show_if'           => array(
                    'enable_active_icon_color' => 'on'
                )
            ),
        );
        $switcher_style = array(
         
            'switcher_alignment' => array(
                'label'           => esc_html__('Toggle Alignment', 'divi_flash'),
                'type'            => 'text_align',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'     => 'switcher',
                'tab_slug'        => 'advanced',
                'mobile_options'  => true
            ),
 
            'switcher_control_size'    => array(
                'label'             => esc_html__('Toggle Size (px)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'switcher_control',
                'default'           => '18px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if_not' => array(
                    'switcher_type' => array('button')
                )
            ),
            'swicher_bar_width'    => array(
                'label'             => esc_html__('Toggle Bar Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'switcher',
                'tab_slug'          => 'advanced',
                'default'           => '100%',
                'default_unit'      => '%',
                'allowed_units'     => array('px','%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'use_custom_spacing'    => array(
                'label'             => esc_html__('Label Or Button Distance', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'switcher',
                'tab_slug'          => 'advanced'
            ),
            'title_spacing'    => array(
                'label'             => esc_html__('Distance Between Label Or Button (px)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'switcher',
                'tab_slug'          => 'advanced',
                'default'           => '20px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if' => array(
                    'use_custom_spacing' => 'on'
                )
            )

        );
        $switcher_control = array(
            'active_control_color'            => array (
                'label'             => esc_html__( 'Toggle Color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'description'       => esc_html__( 'Here you can define a custom color for Active Control.', 'divi_flash' ),
                'toggle_slug'       => 'secondary_control',
                'tab_slug'          => 'advanced',
                'hover'             => 'tabs',
                'show_if_not' => array(
                    'switcher_type' => array('button')
                )
            ),
            'normal_control_color'            => array (
                'label'             => esc_html__( 'Toggle Color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'description'       => esc_html__( 'Here you can define a custom color for Normal Control.', 'divi_flash' ),
                'toggle_slug'       => 'primary_control',
                'tab_slug'          => 'advanced',
                'hover'             => 'tabs',
                'show_if_not' => array(
                    'switcher_type' => array('button')
                )
            )
        );
        $badge_settings = array(
            'enable_primary_badge'    => array(
                'label'             => esc_html__('Primary Badge', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'badge_settings',
               
            ),
            'primary_badge_text' => array(
                'label'                 => esc_html__('Primary Badge Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'badge_settings',
                'dynamic_content'       => 'text',
                'show_if'           => array(
                    'enable_primary_badge' => 'on'
                )             
            ),
            'primary_badge_position'  => array (
                'label'             => esc_html__( 'Left/Right Position', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'badge_settings',
				'default'           => '-40%',
                'default_unit'      => '%',
				'range_settings' => array(
					'min'  => '-100',
					'max'  => '100',
					'step' => '1',
                ),
				'mobile_options'    => true,
                'responsive'        => true,
                'show_if'           => array(
                    'enable_primary_badge' => 'on'
                )
            ),
            'primary_badge_top_position'  => array (
                'label'             => esc_html__( 'Top/Bottom Position', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'badge_settings',
				'default'           => '-100%',
                'default_unit'      => '%',
				'range_settings' => array(
					'min'  => '-100',
					'max'  => '100',
					'step' => '1',
                ),
				'mobile_options'    => true,
                'responsive'        => true,
                'show_if'           => array(
                    'enable_primary_badge' => 'on'
                )
            ),
            'primary_badge_arrow_placement'   => array(
                'label'             => esc_html__('Arrow Placement', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'arrow-bottom'       => esc_html__('Down', 'divi_flash'),
                    'arrow-left'     => esc_html__('Left', 'divi_flash'),
                    'arrow-right'      => esc_html__('Right', 'divi_flash'),
                    'arrow-top'    => esc_html__('Top', 'divi_flash')
                ),
                'default'           => 'arrow-bottom',
                'toggle_slug'       => 'badge_settings',
                'show_if'           => array(
                    'enable_primary_badge' => 'on'
                )
            ),
            'primary_badge_arrow_size'  => array (
                'label'             => esc_html__( 'Arrow Size', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'badge_settings',
				'default'           => '5px',
                'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '16',
					'step' => '.5',
                ),
				'mobile_options'    => true,
                'responsive'        => true,
                'show_if'           => array(
                    'enable_primary_badge' => 'on'
                )
            ),
            'primary_badge_arrow_position'=> array (
                'label'             => esc_html__( 'Arrow Position', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'badge_settings',
				'default'           => '50%',
                'default_unit'      => '%',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
                ),
				'mobile_options'    => true,
                'responsive'        => true,
                'show_if'           => array(
                    'enable_primary_badge' => 'on'
                )
            ),

            'primary_badge_arrow_color'=> array (
				'default'           => "#333",
				'label'             => esc_html__( 'Arrow Color', 'divi_flash' ),
				'type'              => 'color-alpha',
                'hover'             => 'tabs',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'badge_settings',
                'show_if'           => array(
                    'enable_primary_badge' => 'on'
                )
            ),

            'enable_secondary_badge'=> array(
                'label'             => esc_html__('Secondary Badge', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'badge_settings',
            ),
            'secondary_badge_text' => array(
                'label'                 => esc_html__('Secondary Badge Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'badge_settings' ,
                'dynamic_content'       => 'text',
                'show_if'           => array(
                    'enable_secondary_badge' => 'on'
                )             
            ),
            'secondary_badge_position'  => array (
                'label'             => esc_html__( 'Left To Right Position', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'badge_settings',
				'default'           => '-40%',
                'default_unit'      => '%',
				'range_settings' => array(
					'min'  => '-100',
					'max'  => '100',
					'step' => '1',
                ),
				'mobile_options'    => true,
                'responsive'        => true,
                'show_if'           => array(
                    'enable_secondary_badge' => 'on'
                )
            ),
            'secondary_badge_top_position'  => array (
                'label'             => esc_html__( 'Top To Bottom Position', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'badge_settings',
				'default'           => '-100%',
                'default_unit'      => '%',
				'range_settings' => array(
					'min'  => '-100',
					'max'  => '100',
					'step' => '1',
                ),
				'mobile_options'    => true,
                'responsive'        => true,
                'show_if'           => array(
                    'enable_secondary_badge' => 'on'
                )
            ),
            'secondary_badge_arrow_placement'   => array(
                'label'             => esc_html__('Arrow Placement', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'arrow-bottom'       => esc_html__('Down', 'divi_flash'),
                    'arrow-left'     => esc_html__('Left', 'divi_flash'),
                    'arrow-right'      => esc_html__('Right', 'divi_flash'),
                    'arrow-top'    => esc_html__('Top', 'divi_flash')
                ),
                'default'           => 'arrow-bottom',
                'toggle_slug'       => 'badge_settings',
                'show_if'           => array(
                    'enable_secondary_badge' => 'on'
                )
            ),
            'secondary_badge_arrow_size'  => array (
                'label'             => esc_html__( 'Arrow Size', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'badge_settings',
				'default'           => '5px',
                'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '16',
					'step' => '.5',
                ),
				'mobile_options'    => true,
                'responsive'        => true,
                'show_if'           => array(
                    'enable_secondary_badge' => 'on'
                )
            ),
            'secondary_badge_arrow_position'  => array (
                'label'             => esc_html__( 'Arrow Position', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'badge_settings',
				'default'           => '50%',
                'default_unit'      => '%',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
                ),
				'mobile_options'    => true,
                'responsive'        => true,
                'show_if'           => array(
                    'enable_secondary_badge' => 'on'
                )
            ),
            'secondary_badge_arrow_color'    => array (
				'default'           => "#333",
				'label'             => esc_html__( 'Arrow Color', 'divi_flash' ),
				'type'              => 'color-alpha',
                'hover'             => 'tabs',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'secondary_badge_settings',
                'show_if'           => array(
                    'enable_secondary_badge' => 'on'
                )  
            ),

            'primary_badge_padding' => array(
                'label'             => sprintf(esc_html__('Primary Badge Padding', 'divi_flash')),
                'toggle_slug'       => 'custom_spacing',
                'tab_slug'          => 'advanced',
                'type'              => 'custom_margin',
                'hover'             => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'enable_primary_badge' => 'on'
                )
            ),

            'secondary_badge_padding' => array(
                'label'             => sprintf(esc_html__('Secondary Badge Padding', 'divi_flash')),
                'toggle_slug'       => 'custom_spacing',
                'tab_slug'          => 'advanced',
                'type'              => 'custom_margin',
                'hover'             => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'enable_secondary_badge' => 'on'
                )
            )
            
        );
        $active_switcher_control_bg = $this->df_add_bg_field(array(
            'label'                 => 'Toggle Background',
            'key'                   => 'active_switcher_control_bg',
            'toggle_slug'           => 'secondary_control',
            'tab_slug'              => 'advanced',
            'show_if_not' => array(
                'switcher_type' => array('button')
            )
        ));

        $normal_switcher_control_bg = $this->df_add_bg_field(array(
            'label'                 => 'Toggle Background',
            'key'                   => 'normal_switcher_control_bg',
            'toggle_slug'           => 'primary_control',
            'tab_slug'              => 'advanced',
            'show_if_not' => array(
                'switcher_type' => array('button')
            )
        ));

        $primary_button_bg = $this->df_add_bg_field(array(
            'label'                 => 'Primary Button',
            'key'                   => 'primary_button_bg',
            'toggle_slug'           => 'primary_button',
            'tab_slug'              => 'advanced',
            'show_if' => array(
                'switcher_type' => array('button')
            )
        ));

        $secondary_button_bg = $this->df_add_bg_field(array(
            'label'                 => 'Secondary Button',
            'key'                   => 'secondary_button_bg',
            'toggle_slug'           => 'secondary_button',
            'tab_slug'              => 'advanced',
            'show_if'               => array(
                'switcher_type' => array('button')
            )
        ));

        $active_button_bg = $this->df_add_bg_field(array(
            'label'             => 'Active Button',
            'key'               => 'active_button_bg',
            'toggle_slug'       => 'active_button',
            'tab_slug'          => 'advanced',
            'show_if'           => array(
                'switcher_type' => array('button')
            )
        ));
        
        $switcher_content_bg = $this->df_add_bg_field(array(
            'label'         => 'Background',
            'key'           => 'switcher_content_bg',
            'toggle_slug'   => 'switcher_content',
            'tab_slug'      => 'advanced'
        ));

        $switcher_bar_bg = $this->df_add_bg_field(array(
            'label'         => 'Toggle Bar',
            'key'           => 'switcher_bar_bg',
            'toggle_slug'   => 'switcher',
            'tab_slug'      => 'advanced'
        ));
        $primary_badge_bg = $this->df_add_bg_field(array(
            'label'         => 'Background',
            'key'           => 'primary_badge_bg',
            'toggle_slug'   => 'badge_settings',
            'tab_slug'      => 'advanced',
            'show_if'       => array(
                'enable_primary_badge' => 'on'
            )
        ));
        $secondary_badge_bg = $this->df_add_bg_field(array(
            'label'         => 'Background',
            'key'           => 'secondary_badge_bg',
            'toggle_slug'   => 'secondary_badge_settings',
            'tab_slug'      => 'advanced',
            'show_if'       => array(
                'enable_secondary_badge' => 'on'
            )
        ));
        $primary_icon_spacing = $this->add_margin_padding(array(
            'title'         => 'Primary Label Icon',
            'key'           => 'primary_icon',
            'toggle_slug'   => 'custom_spacing',
            'tab_slug'      => 'advanced',
            'option'        => 'padding'
        ));

        $secondary_icon_spacing = $this->add_margin_padding(array(
            'title'         => 'Secondary Label Icon',
            'key'           => 'secondary_icon',
            'toggle_slug'   => 'custom_spacing',
            'tab_slug'      => 'advanced',
            'option'        => 'padding'
        ));

        $switcher_bar_spacing = $this->add_margin_padding(array(
            'title'         => 'Toggle Bar',
            'key'           => 'switcher_bar',
            'toggle_slug'   => 'custom_spacing',
            'tab_slug'      => 'advanced'
        ));

        $switcher_content_spacing = $this->add_margin_padding(array(
            'title'         => 'Toggle Content',
            'key'           => 'switcher_content',
            'option'        => 'padding',
            'toggle_slug'   => 'custom_spacing',
            'tab_slug'      => 'advanced'
        ));

        $switcher_toggle_spacing = $this->add_margin_padding(array(
            'title'         => 'Toggle',
            'key'           => 'switcher_toggle',
            'option'        => 'margin',
            'toggle_slug'   => 'custom_spacing',
            'tab_slug'      => 'advanced'
        ));

        $switcher_button_spacing = $this->add_margin_padding(array(
            'title'         => 'Toggle Button',
            'key'           => 'switcher_button',
            'option'        => 'padding',
            'toggle_slug'   => 'custom_spacing',
            'tab_slug'      => 'advanced'
        ));

        $content_animation = array (
            'enable_animation'  => array (
                'label'             => esc_html__('Animation', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'divi_flash' ),
                    'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'on',
                'toggle_slug'       => 'animation_settings'
            ),
            'content_animation' => array(
                'label'                 => esc_html__('Content Animation', 'divi_flash'),
                'type'                  => 'select',
                'default'               => 'fade_in',
                'options'               => array(
                    'slide_left'            => esc_html__('Slide Left', 'divi_flash'),
                    'slide_right'           => esc_html__('Slide Right', 'divi_flash'),
                    'slide_up'              => esc_html__('Slide Up', 'divi_flash'),
                    'slide_down'            => esc_html__('Slide Down', 'divi_flash'),
                    'fade_in'               => esc_html__('Fade', 'divi_flash'),
                    'zoom_left'             => esc_html__('Zoom Left', 'divi_flash'),
                    'zoom_center'           => esc_html__('Zoom Center', 'divi_flash'),
                    'zoom_right'             => esc_html__('Zoom Right', 'divi_flash'),
                ),
                'toggle_slug'            => 'animation_settings',
                'tab_slug'               => 'general',
                'show_if'                => array(
                   'enable_animation' => 'on' 
                )
            ),
            'content_animation_duration'  => array (
                'label'             => esc_html__( 'Animation Duration', 'divi_flash' ),
				'type'              => 'range',
				'tab_slug'          => 'general',
				'toggle_slug'       => 'animation_settings',
				'default'           => '200',
                'unitless'          => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '1000',
					'step' => '1',
                ),
				'mobile_options'    => true,
                'responsive'        => true,
                'show_if'                => array(
                    'enable_animation' => 'on' 
                )
            ),
        );
        return array_merge(
            $switcher,
            $switcher_controll_settings,
            $switcher_style,
            $primary_icon_settings,
            $primary_icon_align,
            $primary_icon_hide_on_mobile,
            $secondary_icon_settings,
            $secondary_icon_align,
            $secondary_icon_hide_on_mobile,
            $active_icon_style,
            $switcher_bar_bg,  
            $switcher_control,
            $content_animation,
            $active_switcher_control_bg,
            $normal_switcher_control_bg,
            $primary_button_bg,
            $secondary_button_bg,
            $active_button_bg,
            $switcher_content_bg,
            $switcher_bar_spacing,
            $primary_icon_spacing,
            $secondary_icon_spacing,
            $switcher_toggle_spacing,
            $switcher_content_spacing,
            $switcher_button_spacing,
            $primary_badge_bg,
            $secondary_badge_bg,
            $badge_settings
        );
    } 

    public function get_transition_fields_css_props()
    {
        $fields = parent::get_transition_fields_css_props();
        $before_text = '%%order_class%% .df_cm_content span.icv__label-before';
        $after_text = '%%order_class%% .df_cm_content span.icv__label-after';
        $overlay  ='%%order_class%% .df_cm_content.cm_overlay:after';
        $primary_button = '%%order_class%% .df-cs-switch-wrapper .df-cs-button.primary';
        $secondary_button = '%%order_class%% .df-cs-switch-wrapper .df-cs-button.secondary';
        $active_button = '%%order_class%% .df-cs-switch-wrapper .df-cs-button.active';
        $switcher_bar = '%%order_class%% .df-cs-switch-wrapper';
        $switcher_content = '%%order_class%% .df-cs-content-section';
        $primary_badge = '%%order_class%% .df-cs-primary-badge';
        $secondary_badge = '%%order_class%% .df-cs-secondary-badge';
        // spacing
        $fields['switcher_bar_margin'] = array('margin' => $switcher_bar);
        $fields['switcher_bar_padding'] = array('padding' => $switcher_bar);
        $fields['switcher_content_padding'] = array('padding' => $switcher_content);
        $fields['primary_icon_padding'] = array('padding' => '%%order_class%% .df-cs-icon-wrapper .et-pb-icon.df-primary-label-icon');
        $fields['secondary_icon_padding'] = array('padding' => '%%order_class%% .df-cs-icon-wrapper .et-pb-icon.df-secondary-label-icon');
        $fields['switcher_toggle_margin'] = array('margin' => '%%order_class%% label.df-cs-switch.df-input-label');
        $fields['switcher_button_padding'] = array('padding' => '%%order_class%% .df-cs-switch-wrapper .df-cs-button');
        $fields['primary_badge_padding'] = array('padding' => $primary_badge);
        $fields['primary_badge_margin'] = array('padding' => $primary_badge);
        $fields['secondary_badge_padding'] = array('padding' => $secondary_badge);
        $fields['secondary_badge_margin'] = array('padding' => $secondary_badge);
        // Arrow Color
        $fields['primary_badge_arrow_color'] = array('border-color' => "%%order_class%% .df-cs-primary-badge::after");
        $fields['secondary_badge_arrow_color'] = array('border-color' => "%%order_class%% .df-cs-secondary-badge::after");
        
        // Background Color

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'switcher_content_bg',
            'selector'      => '%%order_class%% .df-cs-content-section'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'switcher_bar_bg',
            'selector'      => '%%order_class%% .df-cs-switch-wrapper'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'primary_button_bg',
            'selector'      => $primary_button
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'secondary_button_bg',
            'selector'      => $secondary_button
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'active_button_bg',
            'selector'      => $active_button
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'primary_badge_bg',
            'selector'      =>  $primary_badge
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'secondary_badge_bg',
            'selector'      => $secondary_badge
        ));
        // border fix
        $fields = $this->df_fix_border_transition(
            $fields,
            'switcher_content_border',
            $switcher_content
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'switcher_bar_border',
            $switcher_bar
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'primary_button_border',
            $primary_button
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'secondary_button_border',
            $secondary_button
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'active_button_border',
            $active_button
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'badge_border',
            $primary_badge
        );

        $fields = $this->df_fix_border_transition(
            $fields,
            'secondary_badge_border',
            $secondary_badge
        );
        // box-shadow Fix
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'switcher_bar_box_shadow',
            $switcher_bar
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'switcher_content_box_shadow',
            $switcher_content
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'primary_button_box_shadow',
            $primary_button
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'secondary_button_box_shadow',
            $secondary_button
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'active_button_box_shadow',
            $active_button
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'badge_box_shadow',
            $primary_badge
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'secondary_badge_box_shadow',
            $secondary_badge
        );

        return $fields;
    }

    public function additional_css_styles($render_slug)
    {  
         
        if($this->props['content_switcher_type'] === 'class_base'){
          
            $primary_class_name = "." . $this->props['primary_content_selector'];
            $secondary_class_name = "." . $this->props['secondary_content_selector'];
      
            ET_Builder_Element::set_style($render_slug, array(
                'selector'      => "$primary_class_name .et_pb_pricing_table .et_pb_dollar_sign",
                'declaration'   => 'margin-left: 0px!important; transform: translateX(-100%);'
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector'      => "$secondary_class_name .et_pb_pricing_table .et_pb_dollar_sign",
                'declaration'   => 'margin-left: 0px!important; transform: translateX(-100%);'
            ));
        }
    
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'switcher_content_bg',
            'selector'          => '%%order_class%% .df-cs-content-section , %%order_class%% .df-cs-content-section .et_pb_section',
            'hover'             => '%%order_class%% .df-cs-content-section:hover , %%order_class%% .df-cs-content-section:hover .et_pb_section'
        ));

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'switcher_bar_bg',
            'selector'          => '%%order_class%% .df-cs-switch-wrapper',
            'hover'             => '%%order_class%% .df-cs-switch-wrapper:hover'
        ));

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'normal_switcher_control_bg',
            'selector'          => '%%order_class%% .df-input-label .df-cs-slider',
            'hover'             => '%%order_class%% .df-input-label .df-cs-slider:hover'
        ));

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'active_switcher_control_bg',
            'selector'          => '%%order_class%% .df-input-label input:checked+.df-cs-slider',
            'hover'             => '%%order_class%% .df-input-label input:checked+.df-cs-slider:hover',
            'important'         => true
        ));  
        
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'primary_button_bg',
            'selector'          => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.primary',
            'hover'             => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.primary:hover'
        ));

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'secondary_button_bg',
            'selector'          => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.secondary',
            'hover'             => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.secondary:hover'
        ));

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'active_button_bg',
            'selector'          => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.active',
            'hover'             => '%%order_class%% .df-cs-switch-wrapper .df-cs-button.active:hover'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'primary_badge_bg',
            'selector'          => '%%order_class%% .df-cs-primary-badge',
            'hover'             => '%%order_class%% .df-cs-primary-badge:hover'
        ));

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'secondary_badge_bg',
            'selector'          => '%%order_class%% .df-cs-secondary-badge',
            'hover'             => '%%order_class%% .df-cs-secondary-badge:hover'
        ));

        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'switcher_alignment',
            'type'              => 'justify-content',
            'selector'          => "%%order_class%% .df-cs-switch-wrapper",
            'default'           => 'center'
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'primary_icon_align',
            'type'              => 'justify-content',
            'selector'          => "%%order_class%% .df-cs-icon-wrapper .et-pb-icon.df-primary-label-icon, %%order_class%% .df-cs-icon-wrapper img",
            'default'           => 'left'
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'secondary_icon_align',
            'type'              => 'justify-content',
            'selector'          => "%%order_class%% .df-cs-icon-wrapper .et-pb-icon.df-primary-label-icon, %%order_class%% .df-cs-icon-wrapper img",
            'default'           => 'left'
        ));

        $this->process_icon_styles(array (
            'render_slug'       => $render_slug,
            'slug'              => 'primary_title',
            'selector'          => '%%order_class%% .df-cs-icon-wrapper .et-pb-icon.df-primary-label-icon',
            'hover'             => '%%order_class%% .df-cs-icon-wrapper .et-pb-icon.df-primary-label-icon:hover',
            'image_selector'    => '%%order_class%% .df-cs-icon-wrapper img'
        ));

        $this->process_icon_styles(array (
            'render_slug'       => $render_slug,
            'slug'              => 'secondary_title',
            'selector'          => '%%order_class%% .df-cs-icon-wrapper .et-pb-icon.df-secondary-label-icon',
            'hover'             => '%%order_class%% .df-cs-icon-wrapper .et-pb-icon.df-secondary-label-icon:hover',
            'image_selector'    => '%%order_class%% .df-cs-icon-wrapper img'
        ));

        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'primary_title_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-primary-label-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }

        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'secondary_title_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-secondary-label-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }
        if(isset($this->props['primary_icon_hide_on_mobile']) && $this->props['primary_icon_hide_on_mobile'] === 'on'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector'      => "%%order_class%% .df-cs-switch-wrapper .primary .df-cs-icon-wrapper",
                'declaration'   => 'display: none;',
                'media_query'   => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

        if(isset($this->props['secondary_icon_hide_on_mobile']) && $this->props['secondary_icon_hide_on_mobile'] === 'on'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector'      => "%%order_class%% .df-cs-switch-wrapper .secondary .df-cs-icon-wrapper",
                'declaration'   => 'display: none;',
                'media_query'   => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
        if(isset($this->props['enable_primary_badge']) && $this->props['enable_primary_badge'] === 'on'){

            $primary_badge_arrow_placement = isset($this->props['primary_badge_arrow_placement']) ? $this->props['primary_badge_arrow_placement'] : '';
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'primary_badge_position',
                'type'              => 'left',
                'selector'          => "%%order_class%% .df-cs-primary-badge",
                'important'         => 'true'
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'primary_badge_top_position',
                'type'              => 'top',
                'selector'          => "%%order_class%% .df-cs-primary-badge",
                'important'         => 'true'
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'primary_badge_arrow_size',
                'type'              => 'border-width',
                'selector'          => "%%order_class%% .df-cs-primary-badge.$primary_badge_arrow_placement::after",
                'important'         => 'true'
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'primary_badge_arrow_position',
                'type'              => $primary_badge_arrow_placement === 'arrow-bottom' || $primary_badge_arrow_placement === 'arrow-top'  ? 'left' : 'bottom',
                'selector'          => "%%order_class%% .df-cs-primary-badge.$primary_badge_arrow_placement::after",
                'important'         => 'true'
            ));
            $this->df_process_transform(array(
                'render_slug'       => $render_slug,
                'selector'          => "%%order_class%% .df-cs-primary-badge.$primary_badge_arrow_placement::after",
                'oposite'           => $primary_badge_arrow_placement === 'arrow-bottom' || $primary_badge_arrow_placement === 'arrow-top'  ? true : false,
                'transforms'        => [
                    [
                        'type' => $primary_badge_arrow_placement === 'arrow-bottom' || $primary_badge_arrow_placement === 'arrow-top'  ? 'translateX' : 'translateY',
                        'unit' => '%',
                        'slug'  => 'primary_badge_arrow_position'
                    ]
                ]
            ));
            $arrow_border_props = $this->get_arrow_border_poperty ($primary_badge_arrow_placement);
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'primary_badge_arrow_color',
                'type'              => $arrow_border_props,
                'selector'          => "%%order_class%% .df-cs-primary-badge.$primary_badge_arrow_placement::after",
                'hover'             => "%%order_class%% .df-cs-primary-badge.$primary_badge_arrow_placement:hover::after"
            ));
        }
    
        if(isset($this->props['enable_secondary_badge']) && $this->props['enable_secondary_badge'] === 'on'){
            $secondary_badge_arrow_placement = isset($this->props['secondary_badge_arrow_placement']) ? $this->props['secondary_badge_arrow_placement'] : '';

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'secondary_badge_position',
                'type'              => 'left',
                'selector'          => "%%order_class%% .df-cs-secondary-badge",
                'important'         => 'true'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'secondary_badge_top_position',
                'type'              => 'top',
                'selector'          => "%%order_class%% .df-cs-secondary-badge",
                'important'         => 'true'
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'secondary_badge_arrow_size',
                'type'              => 'border-width',
                'selector'          => "%%order_class%% .df-cs-secondary-badge.$secondary_badge_arrow_placement::after",
                'important'         => 'true'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'secondary_badge_arrow_position',
                'type'              => $secondary_badge_arrow_placement === 'arrow-bottom' || $secondary_badge_arrow_placement === 'arrow-top'  ? 'left' : 'bottom',
                'selector'          => "%%order_class%% .df-cs-secondary-badge.$secondary_badge_arrow_placement::after",
                'important'         => 'true'
            ));
          
            $this->df_process_transform(array(
                'render_slug'       => $render_slug,
                'selector'          => "%%order_class%% .df-cs-secondary-badge.$secondary_badge_arrow_placement::after",
                'oposite'           => $secondary_badge_arrow_placement === 'arrow-bottom' || $secondary_badge_arrow_placement === 'arrow-top' ? true : false,
                'transforms'        => [
                    [
                        'type' => $secondary_badge_arrow_placement === 'arrow-bottom' || $secondary_badge_arrow_placement === 'arrow-top'  ? 'translateX' : 'translateY',
                        'unit' => '%',
                        'slug'  => 'secondary_badge_arrow_position'
                    ]
                ]
            ));
            $arrow_border_props = $this->get_arrow_border_poperty ($secondary_badge_arrow_placement);

            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'secondary_badge_arrow_color',
                'type'              => $arrow_border_props,
                'selector'          => "%%order_class%% .df-cs-secondary-badge.$secondary_badge_arrow_placement::after",
                'hover'             => "%%order_class%% .df-cs-secondary-badge.$secondary_badge_arrow_placement:hover::after"
            ));
        }        
        
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'normal_control_color',
            'type'              => 'background-color',
            'selector'          => "%%order_class%% .df-input-label .df-cs-slider:before",
            'hover'             => '%%order_class%% .df-input-label .df-cs-slider:hover:before',
            'important'         => false
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'active_control_color',
            'type'              => 'background-color',
            'selector'          => "%%order_class%% .df-input-label input:checked+.df-cs-slider:before",
            'hover'             => '%%order_class%% .df-input-label input:checked+.df-cs-slider:hover:before'
        ));
        if($this->props['enable_active_icon_color']){
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'active_icon_color',
                'type'              => 'color',
                'selector'          => "%%order_class%% .df-cs-switch.active .df-cs-icon-wrapper .et-pb-icon , %%order_class%% .df-cs-button.active .df-cs-icon-wrapper .et-pb-icon",
                'hover'             => '%%order_class%% .df-cs-switch.active .df-cs-icon-wrapper .et-pb-icon:hover , %%order_class%% .df-cs-button.active .df-cs-icon-wrapper .et-pb-icon:hover",'
            ));
        }
        
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'switcher_control_size',
            'type'              => 'font-size',
            'selector'          => "%%order_class%% label.df-cs-switch.df-input-label",
        ));

        if(isset($this->props['use_custom_spacing']) && $this->props['use_custom_spacing'] ==='on'){
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'title_spacing',
                'type'              => 'margin-right',
                'selector'          => "%%order_class%% .df-cs-switch-wrapper .df-cs-switch.primary, %%order_class%% .df-cs-switch-wrapper .df-cs-button:not(:last-of-type)",
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'title_spacing',
                'type'              => 'margin-left',
                'selector'          => "%%order_class%% .df-cs-switch-wrapper .df-cs-switch.secondary",
            ));
        }

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'swicher_bar_width',
            'type'              => 'width',
            'selector'          => "%%order_class%% .df-cs-switch-wrapper",
            'default'           => "100%"
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'primary_icon_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-cs-icon-wrapper .et-pb-icon.df-primary-label-icon',
            'hover'             => '%%order_class%% .df-cs-icon-wrapper .et-pb-icon.df-primary-label-icon:hover',
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'secondary_icon_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-cs-icon-wrapper .et-pb-icon.df-secondary-label-icon',
            'hover'             => '%%order_class%% .df-cs-icon-wrapper .et-pb-icon.df-secondary-label-icon:hover',
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'switcher_bar_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-cs-switch-wrapper',
            'hover'             => '%%order_class%% .df-cs-switch-wrapper:hover',
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'switcher_bar_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-cs-switch-wrapper',
            'hover'             => '%%order_class%% .df-cs-switch-wrapper:hover',
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'switcher_toggle_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% label.df-cs-switch.df-input-label',
            'hover'             => '%%order_class%% label.df-cs-switch.df-input-label:hover',
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'switcher_button_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-cs-switch-wrapper .df-cs-button',
            'hover'             => '%%order_class%% .df-cs-switch-wrapper .df-cs-button:hover',
        ));  
        
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'switcher_content_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-cs-content-section',
            'hover'             => '%%order_class%% .df-cs-content-section:hover',
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'primary_badge_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-cs-primary-badge',
            'hover'             => '%%order_class%% .df-cs-primary-badge:hover',
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'secondary_badge_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-cs-secondary-badge',
            'hover'             => '%%order_class%% .df-cs-secondary-badge:hover',
        ));
        $content_animation = array('slide_left', 'slide_right', 'slide_up', 'slide_down');
        if($this->props['enable_animation'] === 'on' && in_array($this->props['content_animation'], $content_animation) ){
            ET_Builder_Element::set_style($render_slug, array(
                'selector'      => "%%order_class%% .df-cs-content-container",
                'declaration'   => 'overflow: hidden;'
            ));
        }
    }
      /**
     * Render image for the front image
     * 
     * @param String $key
     * @return HTML | markup for the image
     */
    public function df_render_icon($key = '', $ad_class='') {
        if ( isset($this->props[$key . '_use_icon']) && $this->props[$key . '_use_icon'] === 'on' ) {
            return sprintf('<div class="df-cs-icon-wrapper">
                    <span class="et-pb-icon %2$s">%1$s</span>
                </div>', 
                isset($this->props[$key . '_font_icon']) && $this->props[$key . '_font_icon'] !== '' ? 
                    esc_attr(et_pb_process_font_icon( $this->props[$key . '_font_icon'] )) : '5',
                $ad_class
            );
        } else if ( isset($this->props[$key . '_image']) && $this->props[$key . '_image'] !== ''){
          
            $image_alt = $this->props[$key . '_alt_text'] !== '' ? $this->props[$key . '_alt_text']  : df_image_alt_by_url($this->props[$key . '_image']);
            return sprintf('<div class="df-cs-icon-wrapper">
                    <img alt="%2$s" src="%1$s" />
                </div>',
                esc_attr($this->props[$key . '_image']),
                $image_alt
            );
        }
    }

	public static function handle_library_content( $id ) {
		if ( is_array( $id ) ) {
			$id = array_values( $id )[0];
		}
		if ( empty( $id ) || 'none' === $id ) {
			return '';
		}

		return df_render_library_layout( $id );
	}

	public static function handle_shortcode_content( $tag = '' ) {
		if ( is_array( $tag ) ) {
			$tag = array_values( $tag )[0];
		}

		$tag       = str_replace( '\"', '', $tag );
		$shortcode = html_entity_decode( $tag );

		return sprintf( '<div>%1$s</div>', do_shortcode( $shortcode ) );
	}

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('animejs');
        wp_enqueue_script('df-content-switcher');
        $this->additional_css_styles($render_slug);
        $order_class        = self::get_module_order_class($render_slug);

        $switch_control_type = isset($this->props['switcher_type']) && $this->props['switcher_type'] !=='' ? $this->props['switcher_type'] : 'round';
      
        $primary_label = isset($this->props['primary_label_title']) && $this->props['primary_label_title'] !=='' ? $this->props['primary_label_title'] :  ($switch_control_type !=='button' ? '' : 'Primary');
        $secondary_label = isset($this->props['secondary_label_title']) && $this->props['secondary_label_title'] !=='' ? $this->props['secondary_label_title'] : ($switch_control_type !=='button' ? '' : 'Secondary');
        $primary_label_icon = $this->df_render_icon('primary_title' , 'df-primary-label-icon');
        $secondary_label_icon = $this->df_render_icon('secondary_title' , 'df-secondary-label-icon');

        $primary_icon_position = isset($this->props['primary_icon_align']) && $this->props['primary_icon_align'] !=='' ? $this->props['primary_icon_align'] : 'left'; // left or center or right
        $secondary_icon_position = isset($this->props['secondary_icon_align']) && $this->props['secondary_icon_align'] !=='' ? $this->props['secondary_icon_align'] : 'left'; // left or center or right
        $primary_button_icon_position = $switch_control_type ==='button' && isset($this->props['primary_icon_align']) && $this->props['primary_icon_align'] !=='' ? $this->props['primary_icon_align'] : 'left'; // left or center or right
        $secondary_button_icon_position = $switch_control_type ==='button' && isset($this->props['secondary_icon_align']) && $this->props['secondary_icon_align'] !=='' ? $this->props['secondary_icon_align'] : 'left'; // left or center or right
        $primary_content = '';
        $secondary_content= '';

        if($this->props['content_switcher_type'] === 'content_base'){
            $primary_content = isset($this->props['content']) && $this->props['content'] !== '' ?
            sprintf('<div class="primary-content">%1$s</div>', do_shortcode(html_entity_decode( $this->sanitize_content( $this->props['content'] ) ) ) ) : '';
            $secondary_content = isset($this->props['secondary_content']) && $this->props['secondary_content'] !== '' ?
            sprintf('<div class="secondary-content">%1$s</div>', do_shortcode(html_entity_decode( $this->sanitize_content($this->props['secondary_content']))) ) : '';

        }else if($this->props['content_switcher_type'] === 'shortcode_base'){
	        $primary_content   = !empty( $this->props['shortcode_primary_content'] )  ? self::handle_shortcode_content( $this->props['shortcode_primary_content'] ) : '';
	        $secondary_content = !empty( $this->props['shortcode_secondary_content'] )  ? self::handle_shortcode_content( $this->props['shortcode_secondary_content'] ) : '';

        } else if ( $this->props['content_switcher_type'] === 'library_base' ) {
	        $library_id_primary   = ! empty( $this->props['library_id_primary'] ) ? $this->props['library_id_primary'] : '';
	        $library_id_secondary = ! empty( $this->props['library_id_secondary'] ) ? $this->props['library_id_secondary'] : '';
	        $primary_content      = self::handle_library_content( $library_id_primary );
	        $secondary_content    = self::handle_library_content( $library_id_secondary );
        }
        $primary_badge_text = isset($this->props['primary_badge_text']) && $this->props['primary_badge_text'] !=='' ? wp_kses_post($this->props['primary_badge_text']) : 'popular';
        $primary_badge_arrow_placement =isset($this->props['primary_badge_arrow_placement']) ? $this->props['primary_badge_arrow_placement'] : 'arrow-bottom';
        $primary_badge = $this->props['enable_primary_badge'] === 'on' ?  
                        sprintf( '<div class="df-cs-primary-badge %2$s">%1$s</div>' , $primary_badge_text , $primary_badge_arrow_placement ) 
                        : '';
        $secondary_badge_text = isset($this->props['secondary_badge_text']) && $this->props['secondary_badge_text'] !=='' ? wp_kses_post($this->props['secondary_badge_text']) : 'popular';
        $secondary_badge_arrow_placement =isset($this->props['secondary_badge_arrow_placement']) ? $this->props['secondary_badge_arrow_placement'] : 'arrow-bottom';
        $secondary_badge = $this->props['enable_secondary_badge'] === 'on' ?  
                        sprintf( '<div class="df-cs-secondary-badge %2$s">%1$s</div>' , $secondary_badge_text , $secondary_badge_arrow_placement ) 
                        : '';
        $switch_html = sprintf('
                        <div class="df-cs-switch primary df-cs-icon-%6$s active">
                            %8$s             
                            %4$s
                            <span class="title">%2$s</span>
                        </div>

                        <label class="df-cs-switch df-input-label">
                            <input class="df-cs-toggle-switch" type="checkbox">
                            <span class="df-cs-slider df-cs-%1$s"></span>
                        </label>

                        <div class="df-cs-switch secondary df-cs-icon-%7$s">
                            %9$s 
                            %5$s
                            <span class="title">%3$s</span>
                        </div>
                    ',
                    $switch_control_type,
                    $primary_label,
                    $secondary_label,
                    $primary_label_icon,
                    $secondary_label_icon,
                    $primary_icon_position,
                    $secondary_icon_position,
                    $primary_badge,
                    $secondary_badge
                );
        $switch_button = sprintf('
                        <button class="df-cs-button primary df-cs-icon-%5$s active"> 
                            %7$s              
                            %3$s        
                            <span class="title">%1$s</span>
                        </button>
                        <button class="df-cs-button secondary df-cs-icon-%6$s">  
                            %8$s
                            %4$s
                            <span class="title">%2$s</span>
                        </button>',
                        $primary_label,
                        $secondary_label,
                        $primary_label_icon,
                        $secondary_label_icon,
                        $primary_button_icon_position,
                        $secondary_button_icon_position,
                        $primary_badge,
                        $secondary_badge
                    );

         $switch_content = sprintf('
                        <div class="df-cs-content-section primary active">
                            %1$s
                        </div>
                        
                        <div class="df-cs-content-section secondary">
                            %2$s
                        </div>',
                    $primary_content,
                    $secondary_content
                );

        $class_base_selector = [
            'content_switcher_type'         => isset($this->props['content_switcher_type']) ? $this->props['content_switcher_type'] : '',
            'primary_content_selector'      => isset($this->props['primary_content_selector']) ? $this->props['primary_content_selector'] : '' ,
            'secondary_content_selector'    => isset($this->props['secondary_content_selector']) ? $this->props['secondary_content_selector'] : '',
            'module_class'                  => $order_class,
            'enable_animation'              => isset($this->props['enable_animation']) ? $this->props['enable_animation'] : 'on',
            'content_animation'             => isset($this->props['content_animation']) ? $this->props['content_animation'] : '' ,
            'content_animation_duration'    => isset($this->props['content_animation_duration']) ? $this->props['content_animation_duration'] : '' 
        ];
      
        return  sprintf('<div class="df-content-switcher-wrapper df-cs-design-%2$s" data-settings=\'%4$s\'>
                            <div class="df-cs-switch-container">
                                <div class="df-cs-switch-wrapper">
                                    %3$s
                                </div>
                            </div>
                                
                            <div class="df-cs-content-container">
                                <div class="df-cs-content-wrapper">
                                    %1$s
                                </div>
                            </div>
                        </div>',
                        $this->props['content_switcher_type'] !== 'class_base' ? $switch_content : '',
                        $switch_control_type,
                        $switch_control_type ==='button' ?  $switch_button :  $switch_html,
                        wp_json_encode($class_base_selector)
			        );
    }

    protected function sanitize_content( $content ) {
		return preg_replace( '/^<\/p>(.*)<p>/s', '$1', $content );
	}

    public function get_arrow_border_poperty($placement){
        switch ($placement) {
            case 'arrow-left':
                $test = "border-right-color";
                break;
            case 'arrow-top':
                 $test = "border-bottom-color";
                break;
            case 'arrow-right':
                 $test = "border-left-color";
                break;
            default:
                $test = "border-top-color";
           
        }
        return $test;
    }

}

new DIFL_ContentSwitcher;