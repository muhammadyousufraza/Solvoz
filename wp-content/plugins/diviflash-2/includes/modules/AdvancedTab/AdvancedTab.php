<?php

class DIFL_AdvancedTab extends ET_Builder_Module {
    public $slug       = 'difl_advancedtab';
    public $vb_support = 'on';
    public $child_slug = 'difl_advancedtabitem';
	public $icon_path, $default_active;
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name             = esc_html__( 'Advanced Tabs', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/advanced-tabs.svg';
        $this->default_active = "";
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'tabs_settings'         => esc_html__('Tab Settings', 'divi_flash'),
                    'nav_background'        => esc_html__('Nav Container Background', 'divi_flash'),
                    'content_background'    => esc_html__('Content Container Background', 'divi_flash'),
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'nav_items'     => esc_html__('Nav Container Settings', 'divi_flash'),
                    'content_wrapper'  => esc_html__('Content Area Settings', 'divi_flash'),
                    'at_item'       => esc_html__('Nav Item', 'divi_flash'),
                    'at_item_active'=> esc_html__('Nav Item Active', 'divi_flash'),
                    'nav_text'      => array(
                        'title'             => esc_html__('Nav Item Text', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
							'title'     => array(
								'name' => 'Title'
							),
							'subtitle'     => array(
								'name' => 'Description'
							)
						)
                    ),
                    'nav_text_active'      => array(
                        'title'             => esc_html__('Nav Item Text Active', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
							'title'     => array(
								'name' => 'Title'
							),
							'subtitle'     => array(
								'name' => 'Description'
							)
						)
                    ),
                    'nav_active_arrow'      => esc_html__('Nav Active Arrow', 'divi_flash'),
                    'text'   => array(
						'title'             => esc_html__('Body', 'divi_flash'),
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
					'header' => array(
						'title'             => esc_html__( 'Heading Text', 'et_builder' ),
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
                    'at_button'     => esc_html__('Button', 'divi_flash'),
                    'custom_spacing'        => array(
                        'title'             => esc_html__('Custom Spacing', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'wrapper'   => array(
                                'name' => 'Wrapper',
                            ),
                            'content'     => array(
                                'name' => 'Content',
                            )
                        )
                    )
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();
        // $advanced_fields['text'] = false;
        $advanced_fields['link_options'] = false;

        $advanced_fields['fonts']  = array(
            'title'     => array(
                'label'           => et_builder_i18n( 'Title' ),
                'css'             => array(
                    'main'        => "{$this->main_css_element} .df_at_title",
                    'hover'        => "{$this->main_css_element} .df_at_nav:hover .df_at_title"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '16px',
                ),
                'header_level' => array(
	                'default' => 'h4',
                ),
                'toggle_slug'     => 'nav_text',
                'sub_toggle'      => 'title'
            ),
            'title_active'     => array(
                'label'           => et_builder_i18n( 'Title' ),
                'css'             => array(
                    'main'        => "{$this->main_css_element} .df_at_nav_active.df_at_nav .df_at_title",
                    'hover'        => "{$this->main_css_element} .df_at_nav_active.df_at_nav:hover .df_at_title"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '16px',
                ),
                'toggle_slug'     => 'nav_text_active',
                'sub_toggle'      => 'title'
            ),
            'subtitle'     => array(
                'label'           => et_builder_i18n( 'Description' ),
                'css'             => array(
                    'main'        => "{$this->main_css_element} .df_at_subtitle",
                    'hover'        => "{$this->main_css_element} .df_at_nav:hover .df_at_subtitle"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'toggle_slug'     => 'nav_text',
                'sub_toggle'      => 'subtitle'
            ),
            'subtitle_active'     => array(
                'label'           => et_builder_i18n( 'Description' ),
                'css'             => array(
                    'main'        => "{$this->main_css_element} .df_at_nav_active .df_at_subtitle",
                    'hover'        => "{$this->main_css_element} .df_at_nav_active.df_at_nav:hover .df_at_subtitle"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'toggle_slug'     => 'nav_text_active',
                'sub_toggle'      => 'subtitle'
            ),
            'text'     => array(
                'label'           => et_builder_i18n( 'Text' ),
                'css'             => array(
                    'main'        => "{$this->main_css_element} .df_at_content",
                    'line_height' => "{$this->main_css_element} .df_at_content",
                    'color'       => "{$this->main_css_element} .df_at_content"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'toggle_slug'     => 'text',
                'sub_toggle'      => 'p',
                // 'hide_text_align' => true,
            ),
            'link'     => array(
                'label'       => et_builder_i18n( 'Link' ),
                'css'         => array(
                    'main'  => "{$this->main_css_element} .df_at_content a",
                    'color' => "{$this->main_css_element} .df_at_content a",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'hide_text_align' => true,
                'toggle_slug' => 'text',
                'sub_toggle'  => 'a',
            ),
            'ul'       => array(
                'label'       => esc_html__( 'Unordered List', 'et_builder' ),
                'css'         => array(
                    'main'        => "{$this->main_css_element} .df_at_content ul li",
                    'color'       => "{$this->main_css_element} .df_at_content ul li",
                    'line_height' => "{$this->main_css_element} .df_at_content ul li",
                    'item_indent' => "{$this->main_css_element} .df_at_content ul",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'text',
                'sub_toggle'  => 'ul',
            ),
            'ol'       => array(
                'label'       => esc_html__( 'Ordered List', 'et_builder' ),
                'css'         => array(
                    'main'        => "{$this->main_css_element} .df_at_content ol li",
                    'color'       => "{$this->main_css_element} .df_at_content ol li",
                    'line_height' => "{$this->main_css_element} .df_at_content ol li",
                    'item_indent' => "{$this->main_css_element} .df_at_content ol",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'text',
                'sub_toggle'  => 'ol',
            ),
            'quote'    => array(
                'label'       => esc_html__( 'Blockquote', 'et_builder' ),
                'css'         => array(
                    'main'  => "{$this->main_css_element} .df_at_content blockquote",
                    'color' => "{$this->main_css_element} .df_at_content blockquote",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'text',
                'sub_toggle'  => 'quote',
            ),
            'header'   => array(
                'label'       => esc_html__( 'Heading', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df_at_content h1",
                ),
                'font_size'   => array(
                    'default' => absint( et_get_option( 'body_header_size', '30' ) ) . 'px',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h1',
            ),
            'header_2' => array(
                'label'       => esc_html__( 'Heading 2', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df_at_content h2",
                ),
                'font_size'   => array(
                    'default' => '26px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h2',
            ),
            'header_3' => array(
                'label'       => esc_html__( 'Heading 3', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df_at_content h3",
                ),
                'font_size'   => array(
                    'default' => '22px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h3',
            ),
            'header_4' => array(
                'label'       => esc_html__( 'Heading 4', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df_at_content h4",
                ),
                'font_size'   => array(
                    'default' => '18px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h4',
            ),
            'header_5' => array(
                'label'       => esc_html__( 'Heading 5', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df_at_content h5",
                ),
                'font_size'   => array(
                    'default' => '16px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h5',
            ),
            'header_6' => array(
                'label'       => esc_html__( 'Heading 6', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df_at_content h6",
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h6',
            ),
            'button'     => array(
                'label'           => et_builder_i18n( 'Button' ),
                'css'             => array(
                    'main'        => "{$this->main_css_element} .df_at_button"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'toggle_slug'     => 'at_button'
            ),
        );
        $advanced_fields['borders'] = array(
            'default'   => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element}",
                        'border_radii_hover'  => "{$this->main_css_element}:hover",
                        'border_styles' => "{$this->main_css_element}",
                        'border_styles_hover' => "{$this->main_css_element}:hover",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => array(
                        'width' => '1px',
                        'color' => '#333333',
                        'style' => 'solid'
                    )
                )
            ),
            'content_wrapper'              => array(
                'css' => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .df_at_all_tabs_wrap",
                        'border_radii_hover' => "{$this->main_css_element} .df_at_all_tabs_wrap:hover",
                        'border_styles' => "{$this->main_css_element} .df_at_all_tabs_wrap",
                        'border_styles_hover' => "{$this->main_css_element} .df_at_all_tabs_wrap:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'content_wrapper',
                'label_prefix'      => esc_html__("Content Area", 'divi_flash')
            ),
            'button'         => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .df_at_button",
                        'border_radii_hover'  => "{$this->main_css_element} .df_at_button:hover",
                        'border_styles' => "{$this->main_css_element} .df_at_button",
                        'border_styles_hover' => "{$this->main_css_element} .df_at_button:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'at_button'
            ),
            'nav_wrapper'         => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .df_at_nav_wrap",
                        'border_radii_hover'  => "{$this->main_css_element} .df_at_nav_wrap:hover",
                        'border_styles' => "{$this->main_css_element} .df_at_nav_wrap",
                        'border_styles_hover' => "{$this->main_css_element} .df_at_nav_wrap:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'nav_items'
            ),
            'nav_item'         => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .df_at_nav",
                        'border_radii_hover'  => "{$this->main_css_element} .df_at_nav:hover",
                        'border_styles' => "{$this->main_css_element} .df_at_nav",
                        'border_styles_hover' => "{$this->main_css_element} .df_at_nav:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'at_item',
                'label_prefix'      => esc_html__("Nav Item", 'divi_flash')
            ),
            'nav_item_active'         => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .df_at_nav_active",
                        'border_radii_hover'  => "{$this->main_css_element} .df_at_nav_active:hover",
                        'border_styles' => "{$this->main_css_element} .df_at_nav_active",
                        'border_styles_hover' => "{$this->main_css_element} .df_at_nav_active:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'at_item_active',
                'label_prefix'      => esc_html__("Active Nav Item", 'divi_flash')
            ),

        );
        $advanced_fields['box_shadow'] = array(
            'default'   => array(),
            'button'              => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_at_button",
                    'hover' => "{$this->main_css_element} .df_at_button:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'at_button'
            ),
            'nav_item'              => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_at_nav",
                    'hover' => "{$this->main_css_element} .df_at_nav:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'at_item'
            ),
            'nav_item_active'              => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_at_nav_active.df_at_nav",
                    'hover' => "{$this->main_css_element} .df_at_nav_active.df_at_nav:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'at_item_active'
            ),
            'nav_wrapper'              => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_at_nav_wrap",
                    'hover' => "{$this->main_css_element} .df_at_nav_wrap:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'nav_items'
            ),
            'content_wrapper'              => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_at_all_tabs_wrap",
                    'hover' => "{$this->main_css_element} .df_at_all_tabs_wrap:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'content_wrapper'
            )
        );

        return $advanced_fields;
    }

    public function get_fields() {
        $tab_animation = array (
            'tab_event_type' => array(
                'label'                 => esc_html__('Tab Event Type', 'dgat-advanced-tabs'),
                'type'                  => 'select',
                'default'               => 'click',
                'options'               => array(
                    'click'             => esc_html__('Click', 'dgat-advanced-tabs'),
                    'mouseover'         => esc_html__('Hover', 'dgat-advanced-tabs')
                ),
                'toggle_slug'           => 'tabs_settings',
                'tab_slug'              => 'general'
            ),
            'tab_animation' => array(
                'label'                 => esc_html__('Tab Reveal Animation', 'divi_flash'),
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
                'toggle_slug'            => 'tabs_settings',
                'tab_slug'               => 'general'
            ),
            'df_animation_duration'  => array (
                'label'             => esc_html__( 'Animation Duration', 'divi_flash' ),
				'type'              => 'range',
				'tab_slug'          => 'general',
				'toggle_slug'       => 'tabs_settings',
				'default'           => '200',
                'unitless'          => true,
				'range_settings' => array(
					'min'  => '100',
					'max'  => '1000',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
                'responsive'        => true
            ),
        );

        $navs = array(
            'use_sticky_nav' => array(
				'label'                 => esc_html__( 'Sticky Nav', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => 'nav_items',
                'tab_slug'              => 'advanced'
            ),
            'turn_off_sticky' => array(
                'label'                 => esc_html__('Turn Off Sticky On', 'divi_flash'),
                'type'                  => 'select',
                'default'               => 'none',
                'options'               => array(
                    'none'              => esc_html__('None', 'divi_flash'),
                    'tablet_phone'      => esc_html__('Tablet & Mobile', 'divi_flash'),
                    'phone'             => esc_html__('Mobile', 'divi_flash')
                ),
                'toggle_slug'            => 'nav_items',
                'tab_slug'               => 'advanced',
                'show_if'               => array(
                    'use_sticky_nav' => 'on'
                )
            ),
            'sticky_nav_distance'  => array (
                'label'             => esc_html__( 'Sticky Top Offset', 'divi_flash' ),
				'type'              => 'range',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'nav_items',
				'default'           => '55px',
                'default_unit'      => 'px',
                // 'unitless'          => true,
                'validate_unit'    => true,
                'allowed_units'    => array( 'px' ),
				'range_settings' => array(
					'min'  => '1',
					'max'  => '300',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
                'responsive'        => true,
                'show_if'           => array(
                    'use_sticky_nav'    => 'on'
                )
            ),
            'use_nav_width' => array(
				'label'                 => esc_html__( 'Use Nav Width Control', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => 'nav_items',
                'tab_slug'              => 'advanced',
                'affects'               => array (
                    'nav_min_width',
                    'nav_max_width',
                    'nav_height'
				)
            ),
            'nav_min_width'  => array (
                'label'             => esc_html__( 'Nav Item Min Width', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'nav_items',
				'default'           => '100px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '300',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
				'responsive'        => true
            ),
            'nav_max_width'  => array (
                'label'             => esc_html__( 'Nav Item Max Width', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'nav_items',
				'default'           => '200px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '500',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
				'responsive'        => true
            ),
            'nav_height'  => array (
                'label'             => esc_html__( 'Nav Item Height', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'nav_items',
				'default'           => 'auto',
				'default_on_front'  => 'auto',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '500',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
				'responsive'        => true
            ),
            'nav_place'   => array(
                'label'             => esc_html__( 'Nav Placement', 'divi_flash' ),
				'type'              => 'composite',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'nav_items',
                'composite_type'    => 'default',
                // 'show_if_not'       => array('use_library_item' => 'on'),
                'composite_structure' => array(
					'desktop' => array(
                        'icon'     => 'desktop',
						'controls' => array(
							'nav_placement' => array(
                                'label'                 => esc_html__('Nav Placement Desktop', 'divi_flash'),
                                'type'                  => 'select',
                                'default'               => 'flex_top',
                                'options'               => array(
                                    'flex_top'        => esc_html__('Default', 'divi_flash'),
                                    'flex_top'       => esc_html__('Top', 'divi_flash'),
                                    'flex_bottom'    => esc_html__('Bottom', 'divi_flash'),
                                    'flex_left'      => esc_html__('Left', 'divi_flash'),
                                    'flex_right'     => esc_html__('Right', 'divi_flash')
                                ),
                                'toggle_slug'            => 'nav_items',
                                'tab_slug'               => 'advanced'
                            ),
                            'nav_container_width'   => array(
                                'label'             => esc_html__( 'Nav Container Width Desktop', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'nav_items',
                                'tab_slug'          => 'advanced',
                                'default'           => '20%',
                                'default_unit'      => '%',
                                'default_on_front'  => '20%',
                                'range_settings'    => array(
                                    'min'  => '1',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                                'show_if'           => array(
                                    'nav_placement' => array('flex_left', 'flex_right')
                                )
                            )
						),
					),
					'tablet' => array(
                        'icon'  => 'tablet',
						'controls' => array(
							'nav_placement_tablet' => array(
                                'label'                 => esc_html__('Nav Placement Tablet', 'divi_flash'),
                                'type'                  => 'select',
                                'default'               => 'flex_top',
                                'options'               => array(
                                    'flex_top'        => esc_html__('Default', 'divi_flash'),
                                    'flex_top'       => esc_html__('Top', 'divi_flash'),
                                    'flex_bottom'    => esc_html__('Bottom', 'divi_flash'),
                                    'flex_left'      => esc_html__('Left', 'divi_flash'),
                                    'flex_right'     => esc_html__('Right', 'divi_flash')
                                ),
                                'toggle_slug'            => 'nav_items',
                                'tab_slug'               => 'advanced',
                            ),
                            'nav_container_width_tablet'   => array(
                                'label'             => esc_html__( 'Nav Container Width Tablet', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'nav_items',
                                'tab_slug'          => 'advanced',
                                'default'           => '50%',
                                'default_unit'      => '%',
                                'default_on_front'  => '50%',
                                'range_settings'    => array(
                                    'min'  => '1',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                                'show_if'           => array(
                                    'nav_placement_tablet' => array('flex_left', 'flex_right')
                                )
                            )
						),
					),
					'phone' => array(
                        'icon'  => 'phone',
						'controls' => array(
							'nav_placement_phone' => array(
                                'label'                 => esc_html__('Nav Placement Mobile', 'divi_flash'),
                                'type'                  => 'select',
                                'default'               => 'flex_top',
                                'options'               => array(
                                    'flex_top'        => esc_html__('Default', 'divi_flash'),
                                    'flex_top'       => esc_html__('Top', 'divi_flash'),
                                    'flex_bottom'    => esc_html__('Bottom', 'divi_flash'),
                                    'flex_left'      => esc_html__('Left', 'divi_flash'),
                                    'flex_right'     => esc_html__('Right', 'divi_flash')
                                ),
                                'toggle_slug'            => 'nav_items',
                                'tab_slug'               => 'advanced',
                            ),
                            'nav_container_width_phone'   => array(
                                'label'             => esc_html__( 'Nav Container Width Mobile', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'nav_items',
                                'tab_slug'          => 'advanced',
                                'default'           => '50%',
                                'default_unit'      => '%',
                                'default_on_front'  => '50%',
                                'range_settings'    => array(
                                    'min'  => '1',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                                'show_if'           => array(
                                    'nav_placement_phone' => array('flex_left', 'flex_right')
                                )
                            )
						),
					),
				),
            ),
            'nav_align'    => array(
                'label'             => esc_html__('Nav Item Alignment', 'divi_flash'),
                'type'              => 'select',
                'default'           => 'flex_start',
                'options'           => array(
                    'flex_start'        => esc_html__('Start', 'divi_flash'),
                    'flex_center'       => esc_html__('Center', 'divi_flash'),
                    'flex_end'          => esc_html__('End', 'divi_flash'),
                    'auto'          => esc_html__('Full Area', 'divi_flash')
                ),
                'toggle_slug'       => 'nav_items',
                'tab_slug'          => 'advanced',
                'mobile_options'    => true,
                'responsive'        => true
            )
        );

        $content_settings = array(
            'use_scroll_to_content' => array(
				'label'                 => esc_html__( 'Scroll to Content ( Tablet & Phone )', 'divi_flash' ),
				'type'                  => 'yes_no_button',
                'description'           => esc_html__('If enabled the window will scroll to content area in tablet and mobile device.', 'divi_flash'),
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => 'content_wrapper',
                'tab_slug'              => 'advanced',
                'show_if_not'           => array(
                    'use_sticky_nav'    => 'on'
                )
            ),
            'content_vertical_align'    => array(
                'label'             => esc_html__('Content Vertical Align', 'divi_flash'),
                'description'       => esc_html__('It will only work when the nav placement is left or right.', 'divi_flash'),
                'type'              => 'select',
                'default'           => 'flex_start',
                'options'           => array(
                    'flex_start'        => esc_html__('Start', 'divi_flash'),
                    'flex_center'       => esc_html__('Center', 'divi_flash'),
                    'flex_end'          => esc_html__('End', 'divi_flash')
                ),
                'toggle_slug'       => 'content_wrapper',
                'tab_slug'          => 'advanced',
                'mobile_options'    => true,
                'responsive'        => true
            )
        );

        $icon = array(
            'icon_color'            => array (
				'default'           => "#2ea3f2",
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'at_item',
                'hover'             => 'tabs'
            ),
            'icon_color_active'     => array (
				// 'default'           => "#2ea3f2",
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'at_item_active',
                'hover'             => 'tabs'
            ),
            'icon_size'             => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'at_item',
				'default'           => '40px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
				'responsive'        => true
            ),
            'image_size'             => array (
                'label'             => esc_html__( 'Image Max-Width', 'divi_flash' ),
				'type'              => 'range',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'at_item',
				'default'           => '40px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
				'responsive'        => true
            ),
            'icon_size_active'             => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'at_item_active',
				// 'default'           => '40px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
				'responsive'        => true
            ),
            'image_size_active'             => array (
                'label'             => esc_html__( 'Image Max-Width Active', 'divi_flash' ),
				'type'              => 'range',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'at_item_active',
				'default'           => '40px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
				'responsive'        => true
            ),
            'icon_placement' => array(
                'label'                 => esc_html__('Icon Placement', 'divi_flash'),
                'type'                  => 'select',
                'default'               => 'flex_top',
                'options'               => array(
                    'flex_top'       => esc_html__('Default', 'divi_flash'),
                    'flex_bottom'    => esc_html__('Bottom', 'divi_flash'),
                    'flex_left'      => esc_html__('Left', 'divi_flash'),
                    'flex_right'     => esc_html__('Right', 'divi_flash')
                ),
                'toggle_slug'            => 'at_item',
                'tab_slug'               => 'advanced',
                'responsive'             => true,
                'mobile_options'         => true
            ),
            'icon_align'    => array(
                'label'             => esc_html__('Icon Alignment', 'divi_flash'),
                'type'              => 'text_align',
                'options'           => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'       => 'at_item',
                'tab_slug'          => 'advanced'
            ),
        );

        $active_arrow = array(
            'use_active_arrow' => array(
				'label'                 => esc_html__( 'Use Active Arrow', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => 'nav_active_arrow',
                'tab_slug'              => 'advanced',
                'affects'               => array(
                    'active_arrow_color',
                    'active_arrow_size',
                    'arrow_align'
                )
            ),
            'active_arrow_color'    => array (
				'default'           => "#eaeaea",
				'label'             => esc_html__( 'Active Arrow Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'nav_active_arrow',
                'hover'             => 'tabs'
            ),
            'active_arrow_size'  => array (
                'label'             => esc_html__( 'Arrow Size', 'divi_flash' ),
				'type'              => 'range',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'nav_active_arrow',
                'default'           => '30px',
                'default_unit'      => 'px',
                'validate_unit'     => true,
                'allowed_units'     => array( 'px' ),
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
                ),
				'depends_show_if'   => 'on',
            ),
            'arrow_align'    => array(
                'label'             => esc_html__('Arrow Alignment', 'divi_flash'),
                'type'              => 'select',
                'default'           => 'start',
                'options'           => array(
                    'start'        => esc_html__('Start', 'divi_flash'),
                    'center'       => esc_html__('Center', 'divi_flash'),
                    'end'          => esc_html__('End', 'divi_flash')
                ),
                'toggle_slug'       => 'nav_active_arrow',
                'tab_slug'          => 'advanced',
                'depends_show_if'   => 'on',
            )
        );

        $button = array(
            'button_align'    => array(
                'label'             => esc_html__('Alignment', 'divi_flash'),
                'type'              => 'text_align',
                'options'           => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'       => 'at_button',
                'tab_slug'          => 'advanced'
            )
        );
        $content_background = $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'content_container',
            'toggle_slug'           => 'content_background',
            'tab_slug'              => 'general'
        ));
        $nav_container_background = $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'nav_container',
            'toggle_slug'           => 'nav_background',
            'tab_slug'              => 'general'
        ));
        $nav_item_background = $this->df_add_bg_field(array(
            'label'                 => 'Nav Item Background',
            'key'                   => 'nav_item',
            'toggle_slug'           => 'at_item',
            'tab_slug'              => 'advanced'
        ));
        $nav_item_background_active = $this->df_add_bg_field(array(
            'label'                 => 'Nav Active Item Background',
            'key'                   => 'nav_item_active',
            'toggle_slug'           => 'at_item_active',
            'tab_slug'              => 'advanced'
        ));
        $button_background = $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'button',
            'toggle_slug'           => 'at_button',
            'tab_slug'              => 'advanced',
            'dynamic_option'        => 'text'
        ));
        $button_spacing = $this->add_margin_padding(array(
            'title'         => 'Button',
            'key'           => 'button',
            'toggle_slug'   => 'at_button',
            'tab_slug'      => 'advanced'
        ));

        // spacing
        $nav_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Nav Wrapper',
            'key'           => 'nav_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $content_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Tab Wrapper',
            'key'           => 'at_content_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $image_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Image Wrapper',
            'key'           => 'image_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $item_content_spacing = $this->add_margin_padding(array(
            'title'         => 'Content Wrapper',
            'key'           => 'content',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $nav_item_spacing = $this->add_margin_padding(array(
            'title'         => 'Nav Item',
            'key'           => 'nav_item',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        $nav_item_spacing_first = $this->add_margin_padding(array(
            'title'         => 'Nav First Item',
            'key'           => 'nav_item_first',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content',
            'option'        => 'margin'
        ));
        $nav_item_spacing_last = $this->add_margin_padding(array(
            'title'         => 'Nav Last Item',
            'key'           => 'nav_item_last',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content',
            'option'        => 'margin'
        ));
        $nav_active_item_spacing = $this->add_margin_padding(array(
            'title'         => 'Nav Item Active',
            'key'           => 'nav_item_active',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        $nav_icon_spacing = $this->add_margin_padding(array(
            'title'         => 'Nav Icon',
            'key'           => 'nav_icon',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content',
            'option'        => 'margin'
        ));
        $nav_title_spacing = $this->add_margin_padding(array(
            'title'         => 'Nav Title',
            'key'           => 'nav_title',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content',
            'option'        => 'margin'
        ));
        $nav_description_spacing = $this->add_margin_padding(array(
            'title'         => 'Nav Description',
            'key'           => 'nav_description',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content',
            'option'        => 'margin'
        ));

        return array_merge(
            $tab_animation,
            $content_background,
            $nav_container_background,
            $navs,
            $content_settings,
            $nav_item_background,
            $nav_item_background_active,
            $icon,
            $active_arrow,
            $button,
            $button_background,
            $button_spacing,
            $nav_wrapper_spacing,
            $content_wrapper_spacing,
            $image_wrapper_spacing,
            $nav_item_spacing,
            $nav_item_spacing_first,
            $nav_item_spacing_last,
            $nav_active_item_spacing,
            $item_content_spacing,
            $nav_icon_spacing,
            $nav_title_spacing,
            $nav_description_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $button = '%%order_class%% .df_at_button';
        $nav_item = '%%order_class%% .df_at_nav';
        $nav_item_active = '%%order_class%% .df_at_nav_active';

        $fields['icon_color'] = array('color' => '%%order_class%% .df_at_nav .et-pb-icon');
        $fields['icon_color_active'] = array('color' => '%%order_class%% .df_at_nav .et-pb-icon');
        // background
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'button',
            'selector'      => '%%order_class%% .df_at_button'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'nav_container',
            'selector'      => '%%order_class%% .df_at_nav_wrap'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'nav_item',
            'selector'      => '%%order_class%% .df_at_nav'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'nav_item_active',
            'selector'      => '%%order_class%% .df_at_nav'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'content_container',
            'selector'      => '%%order_class%% .df_at_all_tabs_wrap'
        ));

        // spacing
        $fields['nav_wrapper_margin'] = array('margin' => '%%order_class%% .df_at_nav_container');
        $fields['nav_wrapper_padding'] = array('padding' => '%%order_class%% .df_at_nav_container');

        $fields['at_content_wrapper_margin'] = array('margin' => '%%order_class%% .df_at_all_tabs');
        $fields['at_content_wrapper_padding'] = array('padding' => '%%order_class%% .df_at_all_tabs');

        $fields['image_wrapper_margin'] = array('margin' => '%%order_class%% .df_at_image_wrapper');
        $fields['image_wrapper_padding'] = array('padding' => '%%order_class%% .df_at_image_wrapper');

        $fields['nav_item_margin'] = array('margin' => $nav_item);
        $fields['nav_item_padding'] = array('padding' => $nav_item);

        $fields['nav_item_first_margin'] = array('margin' => $nav_item);
        $fields['nav_item_last_margin'] = array('margin' => $nav_item);

        $fields['nav_item_active_margin'] = array('margin' => $nav_item_active);
        $fields['nav_item_active_padding'] = array('padding' => $nav_item_active);

        $fields['content_margin'] = array('margin' => '%%order_class%% .df_at_content_wrapper');
        $fields['content_padding'] = array('padding' => '%%order_class%% .df_at_content_wrapper');

        $fields['button_margin'] = array('margin' => $button);
        $fields['button_padding'] = array('padding' => $button);

        $fields['nav_icon_margin'] = array('margin' => '%%order_class%% .at_icon_wrap , %%order_class%% .at_image_wrap');
        $fields['nav_title_margin'] = array('margin' => '%%order_class%% .df_at_title');
        $fields['nav_description_margin'] = array('margin' => '%%order_class%% .df_at_subtitle');

        // border
        $fields = $this->df_fix_border_transition(
            $fields,
            'button',
            $button
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'nav_item',
            $nav_item
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'nav_item_active',
            $nav_item_active
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'nav_wrapper',
            '%%order_class%% .df_at_nav_container'
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'content_wrapper',
            '%%order_class%% .df_at_all_tabs_wrap'
        );

        // box-shadow transition
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'button',
            $button
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'nav_item',
            $nav_item
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'nav_item_active',
            $nav_item_active
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'nav_wrapper',
            '%%order_class%% .df_at_nav_container'
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'content_wrapper',
            '%%order_class%% .df_at_all_tabs_wrap'
        );

        return $fields;
    }

    public function active_button_transition($render_slug) {
        $duration = $this->props['hover_transition_duration'];
        $curve = $this->props['hover_transition_speed_curve'];
        $delay = $this->props['hover_transition_delay'];

        $transition_properties = array(
            'border', 'border-radius', 'box-shadow', 'font-size',
            'line-height', 'color', 'background', 'padding',
            'margin'
        );

        ET_Builder_Element::set_style($render_slug, array(
			'selector' => "%%order_class%% .df_at_nav",
            'declaration' => sprintf('transition-property:%1$s !important;
                transition-duration: %2$s;
                transition-delay: %3$s;
                transition-timing-function: %4$s;',
                implode(', ', $transition_properties),
                $duration,
                $delay,
                $curve
			),
		));
        ET_Builder_Element::set_style($render_slug, array(
			'selector' => "%%order_class%% .df_at_title",
            'declaration' => sprintf('transition-property:%1$s !important;
                transition-duration: %2$s;
                transition-delay: %3$s;
                transition-timing-function: %4$s;',
                implode(', ', $transition_properties),
                $duration,
                $delay,
                $curve
			),
		));
        ET_Builder_Element::set_style($render_slug, array(
			'selector' => "%%order_class%% .df_at_subtitle",
            'declaration' => sprintf('transition-property:%1$s !important;
                transition-duration: %2$s;
                transition-delay: %3$s;
                transition-timing-function: %4$s;',
                implode(', ', $transition_properties),
                $duration,
                $delay,
                $curve
			),
		));
        ET_Builder_Element::set_style($render_slug, array(
			'selector' => "%%order_class%% .at_icon_wrap, %%order_class%% .et-pb-icon ,
                        %%order_class%% .at_image_wrap, %%order_class%% .at_image_wrap img",
            'declaration' => sprintf('transition-property:%1$s !important;
                transition-duration: %2$s;
                transition-delay: %3$s;
                transition-timing-function: %4$s;',
                implode(', ', $transition_properties),
                $duration,
                $delay,
                $curve
			),
		));
        ET_Builder_Element::set_style($render_slug, array(
			'selector' => "%%order_class%% svg",
            'declaration' => sprintf('transition-property:%1$s;
                transition-duration: %2$s;
                transition-delay: %3$s;
                transition-timing-function: %4$s;',
                'fill',
                $duration,
                $delay,
                $curve
			),
		));

    }

    public function additional_css_styles($render_slug) {
        $alignment = [
            'left' => 'flex-start',
            'right' => 'flex-end',
            'center' => 'center'
        ];
        $vertical_align = [
            'flex_start'        => '',
            'flex_center'       => 'margin-top: auto; margin-bottom: auto;',
            'flex_end'          => 'margin-top:auto; margin-bottom:0;'
        ];

        $this->active_button_transition($render_slug);
        // active styles
        if($this->props['use_active_arrow'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_nav ',
                'declaration' => 'overflow: visible !important;'
            ));
        }
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'active_arrow_color',
            'type'              => 'fill',
            'selector'          => '%%order_class%% .df_at_nav svg',
            'hover'             => '%%order_class%% .df_at_nav:hover svg',
            'important'         => false
        ));
        $tanslate_values = array(
            'flex_left' => 'top: 50%; transform: translateX(0px) translateY(-50%);',
            'flex_right' => 'top: 50%; transform: translateX(-100%) translateY(-50%);',
            'flex_bottom' => 'left: 50%; transform: translateY(-100%) translateX(-50%);',
            'flex_top' => 'left: 50%; transform: translateX(-50%);'
        );
        $nav_placement = $this->props['nav_placement'] !== '' ?
            $this->props['nav_placement'] : 'flex_top';

        if ($this->props['nav_placement'] === 'flex_left' || $this->props['nav_placement'] === 'flex_right') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_nav svg',
                'declaration' => sprintf('height: %1$s; width: auto;', $this->props['active_arrow_size'])
            ));
            if($this->props['arrow_align'] === 'center') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_at_nav svg',
                    'declaration' => $tanslate_values[$nav_placement]
                ));
            } else if($this->props['arrow_align'] === 'end') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_at_nav svg',
                    'declaration' => 'top: auto; bottom:0px;'
                ));
            }
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_nav svg',
                'declaration' => sprintf('width: %1$s; height: auto;', $this->props['active_arrow_size'])
            ));
            if($this->props['arrow_align'] === 'center') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_at_nav svg',
                    'declaration' => $tanslate_values[$nav_placement]
                ));
            } else if($this->props['arrow_align'] === 'end') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_at_nav svg',
                    'declaration' => 'left: auto; right: 0;'
                ));
            }
        }


        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df_at_nav .et-pb-icon',
            'hover'             => '%%order_class%% .df_at_nav:hover .et-pb-icon',
            'important'         => false
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_color_active',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df_at_nav.df_at_nav_active .et-pb-icon',
            'hover'             => '%%order_class%% .df_at_nav.df_at_nav_active:hover .et-pb-icon'
        ));
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_size',
            'type'              => 'font-size',
            'selector'          => '%%order_class%% .df_at_nav .et-pb-icon',
            'important'         => false
        ) );
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_size',
            'type'              => 'max-width',
            'selector'          => '%%order_class%% .df_at_nav .at_image_wrap img',
            'important'         => false
        ) );
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_size_active',
            'type'              => 'font-size',
            'selector'          => '%%order_class%% .df_at_nav.df_at_nav_active .et-pb-icon'
        ) );

        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_size_active',
            'type'              => 'max-width',
            'selector'          => '%%order_class%% .df_at_nav.df_at_nav_active .at_image_wrap img'
        ) );

        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_placement',
            'type'              => 'flex-direction',
            'selector'          => '%%order_class%% .df_at_nav'
        ));
        if($this->props['use_nav_width'] === 'on') {
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'nav_min_width',
                'type'              => 'min-width',
                'selector'          => '%%order_class%% .df_at_nav',
                'important'         => false
            ) );
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'nav_max_width',
                'type'              => 'max-width',
                'selector'          => '%%order_class%% .df_at_nav',
                'important'         => false
            ) );
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'nav_height',
                'type'              => 'height',
                'selector'          => '%%order_class%% .df_at_nav_container .df_at_nav',
                'important'         => false
            ) );
        }

        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_align',
            'type'              => 'align-self',
            'selector'          => '%%order_class%% .df_at_nav_wrap'
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_align',
            'type'              => 'justify-content',
            'selector'          => '%%order_class%% .df_at_nav_container'
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_align',
            'type'              => 'align-items',
            'selector'          => '%%order_class%% .df_at_nav_container'
        ));

        // nav placement
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df_at_container',
            'declaration' => sprintf('flex-direction:%1$s;',$this->df_process_values($this->props['nav_placement'])),
            'media_query' => ET_Builder_Element::get_media_query('min_width_981')
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df_at_container',
            'declaration' => sprintf('flex-direction:%1$s;',$this->df_process_values($this->props['nav_placement_tablet'])),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df_at_container',
            'declaration' => sprintf('flex-direction:%1$s;',$this->df_process_values($this->props['nav_placement_phone'])),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));

        if ($this->props['nav_placement'] === 'flex_left' || $this->props['nav_placement'] === 'flex_right') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_nav_container',
                'declaration' => 'flex-direction: column;',
                'media_query' => ET_Builder_Element::get_media_query('min_width_981')
            ));
        }

        if($this->props['nav_placement'] === 'flex_left' || $this->props['nav_placement'] === 'flex_right') {
            $nav_container_width = '' !== $this->props['nav_container_width'] ?
                $this->props['nav_container_width'] : '20%';

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_nav_wrap:not(.sticky)',
                'declaration' => "width:{$nav_container_width} !important;",
                'media_query' => ET_Builder_Element::get_media_query('min_width_981')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_all_tabs_wrap',
                'declaration' => "width:calc(100% - {$nav_container_width}) !important;",
                'media_query' => ET_Builder_Element::get_media_query('min_width_981')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .et_pb_module',
                'declaration' => "height: 100%;",
                'media_query' => ET_Builder_Element::get_media_query('min_width_981')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ati_container',
                'declaration' => sprintf('%1$s', $vertical_align[$this->props['content_vertical_align']]),
                'media_query' => ET_Builder_Element::get_media_query('min_width_981')
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ati_container',
                'declaration' => sprintf('align-items: %1$s;', $this->df_process_values($this->props['content_vertical_align'])),
                'media_query' => ET_Builder_Element::get_media_query('min_width_981')
            ));
        }
        if($this->props['nav_placement_tablet'] === 'flex_left' || $this->props['nav_placement_tablet'] === 'flex_right') {
            $nav_container_width_tablet = '' !== $this->props['nav_container_width_tablet'] ?
                $this->props['nav_container_width_tablet'] : '20%';

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_nav_wrap',
                'declaration' => "width:{$nav_container_width_tablet};",
                'media_query' => ET_Builder_Element::get_media_query('min_width_768')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_all_tabs_wrap',
                'declaration' => "width:calc(100% - {$nav_container_width_tablet});",
                'media_query' => ET_Builder_Element::get_media_query('min_width_768')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .et_pb_module',
                'declaration' => "height: 100%;",
                'media_query' => ET_Builder_Element::get_media_query('min_width_768')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ati_container',
                'declaration' => sprintf('%1$s', $vertical_align[$this->props['content_vertical_align']]),
                'media_query' => ET_Builder_Element::get_media_query('min_width_768')
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ati_container',
                'declaration' => sprintf('align-items: %1$s;', $this->df_process_values($this->props['content_vertical_align'])),
                'media_query' => ET_Builder_Element::get_media_query('min_width_768')
            ));
        }
        if($this->props['nav_placement_phone'] === 'flex_left' || $this->props['nav_placement_phone'] === 'flex_right') {
            $nav_container_width_phone = '' !== $this->props['nav_container_width_phone'] ?
                $this->props['nav_container_width_phone'] : '20%';

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_nav_wrap',
                'declaration' => "width:{$nav_container_width_phone};",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_all_tabs_wrap',
                'declaration' => "width:calc(100% - {$nav_container_width_phone});",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .et_pb_module',
                'declaration' => "height: 100%;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ati_container',
                'declaration' => sprintf('%1$s', $vertical_align[$this->props['content_vertical_align']]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ati_container',
                'declaration' => sprintf('align-items: %1$s;', $this->df_process_values($this->props['content_vertical_align'])),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

        if($this->props['use_nav_width'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_nav_container',
                'declaration' => 'flex-wrap: wrap;'
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_nav',
                'declaration' => 'height: auto;'
            ));
        }

        $this->icon_wrapper_width($render_slug);
        $this->icon_alignment_styles($render_slug);

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df_at_button_wrapper',
            'declaration' => sprintf('text-align: %1$s;', $this->props['button_align'])
        ));

        // process background
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button',
            'selector'          => "{$this->main_css_element} .df_at_button",
            'hover'             => "{$this->main_css_element} .df_at_button:hover"
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_container',
            'selector'          => "%%order_class%% .df_at_nav_wrap",
            'hover'             => "%%order_class%%:hover .df_at_nav_wrap"
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_container',
            'selector'          => "%%order_class%% .df_at_all_tabs_wrap",
            'hover'             => "%%order_class%%:hover .df_at_all_tabs_wrap"
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_item',
            'selector'          => "%%order_class%% .df_at_nav",
            'hover'             => "%%order_class%% .df_at_nav:hover"
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_item_active',
            'selector'          => "%%order_class%% .df_at_nav.df_at_nav_active",
            'hover'             => "%%order_class%% .df_at_nav.df_at_nav_active:hover"
        ));

        // spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_at_nav_container',
            'hover'             => '%%order_class%%:hover .df_at_nav_container',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_at_nav_container',
            'hover'             => '%%order_class%%:hover .df_at_nav_container',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'at_content_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_at_all_tabs',
            'hover'             => '%%order_class%%:hover .df_at_all_tabs',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'at_content_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_at_all_tabs',
            'hover'             => '%%order_class%%:hover .df_at_all_tabs',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_at_image_wrapper',
            'hover'             => '%%order_class%%:hover .df_at_image_wrapper',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_at_image_wrapper',
            'hover'             => '%%order_class%%:hover .df_at_image_wrapper',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_item_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_at_nav',
            'hover'             => '%%order_class%%:hover .df_at_nav',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_item_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_at_nav',
            'hover'             => '%%order_class%%:hover .df_at_nav',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_item_first_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_at_nav:first-child',
            'hover'             => '%%order_class%%:hover .df_at_nav:first-child',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_item_last_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_at_nav:last-child',
            'hover'             => '%%order_class%%:hover .df_at_nav:last-child',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_item_active_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_at_nav_active.df_at_nav',
            'hover'             => '%%order_class%%:hover .df_at_nav_active.df_at_nav',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_item_active_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_at_nav_active.df_at_nav',
            'hover'             => '%%order_class%%:hover .df_at_nav_active.df_at_nav',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_at_content_wrapper',
            'hover'             => '%%order_class%%:hover .df_at_content_wrapper',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_at_content_wrapper',
            'hover'             => '%%order_class%%:hover .df_at_content_wrapper',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_at_button',
            'hover'             => '%%order_class%%:hover .df_at_button',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_at_button',
            'hover'             => '%%order_class%%:hover .df_at_button',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_icon_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .at_icon_wrap , %%order_class%% .at_image_wrap',
            'hover'             => '%%order_class%% .df_at_nav:hover .at_icon_wrap , %%order_class%% .df_at_nav:hover .at_image_wrap',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_title_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_at_title',
            'hover'             => '%%order_class%% .df_at_nav:hover .df_at_title',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'nav_description_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_at_subtitle',
            'hover'             => '%%order_class%% .df_at_nav:hover .df_at_subtitle',
            'important'         => false
        ));

    }

    /**
     * Render tab navigation
     *
     */
    public function df_at_render_nav() {
        global $df_at_data;
        $nav_placement = $this->props['nav_placement'] !== '' ? $this->props['nav_placement'] : 'flex_top';
        $placement = array(
            'flex_top' => 'top',
            'flex_bottom' => 'bottom',
            'flex_left' => 'left',
            'flex_right' => 'right'
        );
        $arrows = array(
            'flex_top'       => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 255 127.5" width="30px" height="auto"><g><polygon points="0 0 127.5 127.5 255 0 0 0"/></g></svg>',
            'flex_bottom'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 255 127.5" width="30px" height="auto"><g><polygon points="255 127.5 127.5 0 0 127.5 255 127.5"/></g></svg>',
            'flex_left'      => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 127.5 255" height="30px" width="auto"><g><polygon points="0 255 127.5 127.5 0 0 0 255"/></g></svg>',
            'flex_right'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 127.5 255" height="30px" width="auto"><g><polygon points="127.5 0 0 127.5 127.5 255 127.5 0"/></g></svg>'
        );
        $arrow = $this->props['use_active_arrow'] === 'on' ? $arrows[$nav_placement] : '';
        $arrow_class = 'arrow_' . $placement[$nav_placement];


        $desktop = $this->props['icon_placement'] !== '' ? $placement[$this->props['icon_placement']] : 'top';
        $tablet = $this->props['icon_placement_tablet'] !== '' ? $placement[$this->props['icon_placement_tablet']] : $desktop;
        $phone = $this->props['icon_placement_phone'] !== '' ? $placement[$this->props['icon_placement_phone']] : $tablet;

        $lr = 'lr_' . $desktop;
        $md = 'md_' . $tablet;
        $sm = 'sm_' . $phone;

        $icon_placement_class = sprintf('%1$s %2$s %3$s', $lr, $md, $sm);
        $tabs = '';
		$title_level = !empty($this->props['title_level']) ? $this->props['title_level'] : 'h4';
        foreach($df_at_data as $class => $data) {
            if( "on" === $data['default_active'] ){
                $this->default_active = $class;
            }
            $title = $data['title'] !== '' ?
                sprintf('<%2$s class="df_at_title">%1$s</%2$s>', esc_html($data['title']), $title_level ) : '';
            $subtitle = $data['subtitle'] !== '' ?
                sprintf('<div class="df_at_subtitle">%1$s</div>',$data['subtitle']) : '';

            $tab_image_alt_text = '';

            if( 'on' !== $data['use_icon'] && '' !== $data['tab_image'] ){
                $tab_image_id = attachment_url_to_postid($data['tab_image']);
                $tab_image_alt_text = get_post_meta($tab_image_id, '_wp_attachment_image_alt', true);
            }

            $image = $data['use_icon'] !== 'on' && $data['tab_image'] !== '' ?
	            sprintf('<span class="at_image_wrap"><img src="%1$s" alt="%2$s"/></span>', $data['tab_image'], esc_attr( $tab_image_alt_text ) ) : '';

            $icon = isset($data['use_icon']) && $data['use_icon'] === 'on' ?
                sprintf('<span class="at_icon_wrap "><span class="et-pb-icon df-tab-nav-icon">%1$s</span></span>',
                    isset($data['font_icon']) && $data['font_icon'] !== '' ?
                        $data['font_icon'] : '5'
                ) : $image;

            $tabs .= sprintf('<div data-hash="%1$s" class="%1$s df_at_nav %5$s %7$s">
                %4$s <span class="at_nav_content">%2$s %3$s</span> %6$s
            </div>', esc_attr($class), $title, $subtitle, $icon, $icon_placement_class, $arrow, $arrow_class);
        }
        $df_at_data = array();
        return $tabs;
    }


    public function render( $attrs, $content, $render_slug ) {
        if ( $this->content === '' ) {
            return sprintf(
                '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Tab Item.</strong></h2>'
            );
        }
        $df_at_contents = et_core_sanitized_previously($this->content);
        wp_enqueue_script('animejs');
        wp_enqueue_script('sticky-script');
        wp_enqueue_script('df-tabs');

        $df_tab_nav         = $this->df_at_render_nav();
        $sticky_nav_class   = $this->props['use_sticky_nav'] === 'on' ? ' df_has_sticky_nav' : '';
        $order_class        = self::get_module_order_class($render_slug);

        $sticky_distance = isset($this->props['sticky_nav_distance']) ?
            $this->props['sticky_nav_distance'] : '55px';
        $sticky_distance_tablet = isset($this->props['sticky_nav_distance_tablet']) && $this->props['sticky_nav_distance_tablet'] !== '' ?
            $this->props['sticky_nav_distance_tablet'] : $sticky_distance;
        $sticky_distance_phone = isset($this->props['sticky_nav_distance_phone']) ?
            $this->props['sticky_nav_distance_phone'] : $sticky_distance_tablet;

        $data = [
            'tab_event_type'            => $this->props['tab_event_type'],
            'use_sticky_nav'            => $this->props['use_sticky_nav'],
            'use_scroll_to_content'     => $this->props['use_scroll_to_content'],
            'sticky_distance'           => $sticky_distance,
            'sticky_distance_tablet'    => $sticky_distance_tablet,
            'sticky_distance_phone'     => $sticky_distance_phone,
            'tab_animation'             => $this->props['tab_animation'],
            'extra_space'               => is_admin_bar_showing() ? true : false,
            'turn_off_sticky'           => $this->props['turn_off_sticky'],
            'module_class'              => $order_class,
            'animation_duration'        => $this->props['df_animation_duration'],
            'default_active'            => $this->default_active
        ];
        $this->default_active = "";

        $this->additional_css_styles($render_slug);

        return sprintf('<div class="df_at_container%4$s" data-settings=\'%3$s\'>
                <div class="df_at_nav_wrap"><div class="df_at_nav_container">%2$s</div></div>
                <div class="df_at_all_tabs_wrap"><div class="df_at_all_tabs">%1$s</div></div>
            </div>',
            $df_at_contents,
            $df_tab_nav,
            wp_json_encode($data),
            $sticky_nav_class
        );
    }

    /**
     * Icon wrapper width
     *
     * @param $render_slug
     */
    public function icon_wrapper_width($render_slug) {
        $icon_wrapper_width = [
            'flex_top' => '100%',
            'flex_bottom' => '100%',
            'flex_left' => 'auto',
            'flex_right' => 'auto'
        ];
        $desktop = $this->props['icon_placement'] !== '' ?
            $this->props['icon_placement'] : 'flex_top';
        $tablet = $this->props['icon_placement_tablet'] !== '' ?
            $this->props['icon_placement_tablet'] : $desktop;
        $phone = $this->props['icon_placement_phone'] !== '' ?
            $this->props['icon_placement_phone'] : $tablet;

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .at_icon_wrap , %%order_class%% .at_image_wrap',
            'declaration' => sprintf('width:%1$s;', $icon_wrapper_width[$desktop])
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .at_icon_wrap , %%order_class%% .at_image_wrap',
            'declaration' => sprintf('width:%1$s;', $icon_wrapper_width[$tablet]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .at_icon_wrap , %%order_class%% .at_image_wrap',
            'declaration' => sprintf('width:%1$s;', $icon_wrapper_width[$phone]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
    }

    public function icon_alignment_styles($render_slug) {
        $align = isset($this->props['icon_align']) && $this->props['icon_align'] !== '' ?
            $this->props['icon_align'] : 'left';

        $flex_style = [
            'left' => 'flext-start',
            'center' => 'center',
            'right' => 'flex-end'
        ];
        $flex_style_reverse = [
            'left' => 'flex-end',
            'center' => 'center',
            'right' => 'flext-start'
        ];
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .at_icon_wrap ,%%order_class%% .at_image_wrap ',
            'declaration' => sprintf('text-align: %1$s;', $align)
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .lr_left .at_nav_content, %%order_class%% .lr_right .at_nav_content',
            'declaration' => 'width: auto;',
            'media_query' => ET_Builder_Element::get_media_query('min_width_981')
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df_at_nav.lr_left',
            'declaration' => sprintf('justify-content: %1$s;', $flex_style[$align]),
            'media_query' => ET_Builder_Element::get_media_query('min_width_981')
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => ' %%order_class%% .df_at_nav.lr_right',
            'declaration' => sprintf('justify-content: %1$s;', $flex_style_reverse[$align]),
            'media_query' => ET_Builder_Element::get_media_query('min_width_981')
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .md_left .at_nav_content, %%order_class%% .md_right .at_nav_content',
            'declaration' => 'width: auto;',
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df_at_nav.md_left',
            'declaration' => sprintf('justify-content: %1$s;', $flex_style[$align]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => ' %%order_class%% .df_at_nav.md_right',
            'declaration' => sprintf('justify-content: %1$s;', $flex_style_reverse[$align]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .sm_left .at_nav_content, %%order_class%% .sm_right .at_nav_content',
            'declaration' => 'width: auto;',
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df_at_nav.sm_left',
            'declaration' => sprintf('justify-content: %1$s;', $flex_style[$align]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df_at_nav.sm_right',
            'declaration' => sprintf('justify-content: %1$s;', $flex_style_reverse[$align]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
    }

}
new DIFL_AdvancedTab;
