<?php

class DIFL_AdvancedTabItem extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_advancedtabitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $child_title_var  = 'title';
    public $child_title_fallback_var = 'admin_label';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Advanced Tab Item', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'content' => esc_html__('Content', 'divi_flash'),
                    'at_icon' => esc_html__('Nav Icon Settings', 'divi_flash'),
                    'image' => esc_html__('Image', 'divi_flash'),
                    'navigation_settings' => esc_html__('Navigation Settings', 'divi_flash'),
                    'at_button' => esc_html__('Button', 'divi_flash'),
                    'text_area' => esc_html__('Text Area Background', 'divi_flash'),
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
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
                    'image'   => esc_html__('Image Styles', 'divi_flash'),
                    'text'   => array(
						'title'             => esc_html__('Text', 'divi_flash'),
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
                    'text_area'     => esc_html__('Content Area Styles', 'divi_flash')
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();

        // $advanced_fields['text'] = false;
        $advanced_fields['fonts']  = array(
            'title'     => array(
                'label'           => et_builder_i18n( 'Title' ),
                'css'             => array(
                    'main'        => ".difl_advancedtab {$this->main_css_element} .df_at_title"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '16px',
                ),
                'toggle_slug'     => 'nav_text',
                'sub_toggle'      => 'title'
            ),
            'subtitle'     => array(
                'label'           => et_builder_i18n( 'Sub Title' ),
                'css'             => array(
                    'main'        => ".difl_advancedtab {$this->main_css_element} .df_at_subtitle"
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
            'text'     => array(
                'label'           => et_builder_i18n( 'Text' ),
                'css'             => array(
                    'main'        => ".difl_advancedtab {$this->main_css_element} .df_at_content",
                    'line_height' => ".difl_advancedtab {$this->main_css_element} .df_at_content",
                    'color'       => ".difl_advancedtab {$this->main_css_element} .df_at_content",
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
                    'main'  => ".difl_advancedtab {$this->main_css_element} .df_at_content a",
                    'color' => ".difl_advancedtab {$this->main_css_element} .df_at_content a",
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
                    'main'        => ".difl_advancedtab {$this->main_css_element} .df_at_content ul li",
                    'color'       => ".difl_advancedtab {$this->main_css_element} .df_at_content ul li",
                    'line_height' => ".difl_advancedtab {$this->main_css_element} .df_at_content ul li",
                    'item_indent' => ".difl_advancedtab {$this->main_css_element} .df_at_content ul",
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
                    'main'        => ".difl_advancedtab {$this->main_css_element} .df_at_content ol li",
                    'color'       => ".difl_advancedtab {$this->main_css_element} .df_at_content ol li",
                    'line_height' => ".difl_advancedtab {$this->main_css_element} .df_at_content ol li",
                    'item_indent' => ".difl_advancedtab {$this->main_css_element} .df_at_content ol",
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
                    'main'  => ".difl_advancedtab {$this->main_css_element} .df_at_content blockquote",
                    'color' => ".difl_advancedtab {$this->main_css_element} .df_at_content blockquote",
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
                    'main' => ".difl_advancedtab {$this->main_css_element} .df_at_content h1",
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
                    'main' => ".difl_advancedtab {$this->main_css_element} .df_at_content h2",
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
                    'main' => ".difl_advancedtab {$this->main_css_element} .df_at_content h3",
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
                    'main' => ".difl_advancedtab {$this->main_css_element} .df_at_content h4",
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
                    'main' => ".difl_advancedtab {$this->main_css_element} .df_at_content h5",
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
                    'main' => ".difl_advancedtab {$this->main_css_element} .df_at_content h6",
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
                    'main'        => ".difl_advancedtab {$this->main_css_element} .df_at_button"
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
                'css'       => array(
                    'main'  => array(
                        'border_radii' => ".df_at_all_tabs {$this->main_css_element}",
                        'border_radii_hover'  => ".df_at_all_tabs {$this->main_css_element}:hover",
                        'border_styles' => ".df_at_all_tabs {$this->main_css_element}",
                        'border_styles_hover' => ".df_at_all_tabs {$this->main_css_element}:hover",
                    )
                )
            ),
            'button'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_advancedtab {$this->main_css_element} .df_at_button",
                        'border_radii_hover'  => ".difl_advancedtab {$this->main_css_element} .df_at_button:hover",
                        'border_styles' => ".difl_advancedtab {$this->main_css_element} .df_at_button",
                        'border_styles_hover' => ".difl_advancedtab {$this->main_css_element} .df_at_button:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'at_button'
            ),
            'image'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_advancedtab {$this->main_css_element} .df_at_image",
                        'border_radii_hover'  => ".difl_advancedtab {$this->main_css_element} .df_at_image:hover",
                        'border_styles' => ".difl_advancedtab {$this->main_css_element} .df_at_image",
                        'border_styles_hover' => ".difl_advancedtab {$this->main_css_element} .df_at_image:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'image'
            ),
            'textarea_border'       => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_advancedtab {$this->main_css_element} .df_at_content_wrapper",
                        'border_radii_hover'  => ".difl_advancedtab {$this->main_css_element} .df_at_content_wrapper:hover",
                        'border_styles' => ".difl_advancedtab {$this->main_css_element} .df_at_content_wrapper",
                        'border_styles_hover' => ".difl_advancedtab {$this->main_css_element} .df_at_content_wrapper:hover",
                    ),
                    'important' => 'all'
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'text_area'
            )
        );
        $advanced_fields['box_shadow'] = array(
            'default'             => array(
                'css'       => array (
                    'main' => ".difl_advancedtab {$this->main_css_element}.et_pb_module",
                    'hover' => ".difl_advancedtab {$this->main_css_element}.et_pb_module:hover",
                    'important' => 'all'
                )
            ),
            'button'              => array(
                'css' => array(
                    'main' => ".difl_advancedtab {$this->main_css_element} .df_at_button",
                    'hover' => ".difl_advancedtab {$this->main_css_element} .df_at_button:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'at_button'
            ),
            'image'              => array(
                'css' => array(
                    'main' => ".difl_advancedtab {$this->main_css_element} .df_at_image",
                    'hover' => ".difl_advancedtab {$this->main_css_element} .df_at_image:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'image'
            ),
            'textarea_shadow'    => array(
                'css' => array(
                    'main' => ".difl_advancedtab {$this->main_css_element} .df_at_content_wrapper",
                    'hover' => ".difl_advancedtab {$this->main_css_element} .df_at_content_wrapper:hover",
                    'important' => 'all'
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'text_area'
            )
        );
        $advanced_fields["filters"] = array(
			'child_filters_target' => array(
				'tab_slug' => 'advanced',
				'toggle_slug' => 'image',
				'css' => array(
					'main' => '%%order_class%% img'
				),
			),
        );

        $advanced_fields['image'] = array(
			'css' => array(
				'main' => array(
					'%%order_class%% img',
				)
			),
        );
        $advanced_fields['transform'] = false;
        $advanced_fields['background'] = array(
            'css' => array(
                'main' => "{$this->main_css_element}.et_pb_module"
            )
        );
        $advanced_fields['max_width'] = array(
            'css'   => array(
                'main'      => "{$this->main_css_element}.et_pb_module"
            )
        );
        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'main'      => "{$this->main_css_element}.et_pb_module",
                'important' => 'all'
            )
        );
        $advanced_fields['link_options'] = false;

        return $advanced_fields;
    }

    public function get_fields() {
        $general = array (
            'admin_label' => array (
				'label'           => esc_html__( 'Admin Label', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'admin_label',
				'default_on_front'=> 'Tab Item',
            ),
            'title' => array (
                'label'                 => esc_html__( 'Tab Label', 'divi_flash' ),
                'description'           => esc_html__( 'Dynamic Content Shown Only Frontend', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'content',
                'dynamic_content'       => 'text'
            ),
            'subtitle' => array (
                'label'                 => esc_html__( 'Tab Description', 'divi_flash' ),
                'description'           => esc_html__( 'Dynamic Content Shown Only Frontend', 'divi_flash' ),
				'type'                  => 'textarea',
                'toggle_slug'           => 'content',
                'dynamic_content'       => 'text'
            ),
            'content_type' => array(
                'default'         => 'content',
                'label'           => esc_html__( 'Content Type', 'divi_flash' ),
                'type'            => 'select',
                'option_category' => 'configuration',
                'options'         => array(
                    'content' => esc_html__( 'Content', 'divi_flash' ),
                    'library'  => esc_html__( 'Library Item', 'divi_flash' ),
                ),
                'toggle_slug'     => 'content'

            ),
            'content'        => array (
                'label'                 => esc_html__('Body', 'divi_flash'),
                'type'                  => 'tiny_mce',
                'toggle_slug'           => 'content',
                'dynamic_content'       => 'text',
                'show_if_not'     => array('content_type' => 'library')
            ),
            'library_item' => array(
                'default'         => 'none',
                'label'           => esc_html__( 'Library Layout', 'divi_flash' ),
                'type'            => 'select',
                'option_category' => 'configuration',
                'options'         => df_load_library(),
                'toggle_slug'     => 'content',
                'show_if'         => array('content_type' => 'library'),
                'computed_affects' => [
                    '__libraryShortcode',
                ]
            ),
            "__libraryShortcode" => array(
                'type'                => 'computed',
                'computed_callback'   => array('DIFL_AdvancedTabItem', 'df_divi_library_shortcode'),
                'computed_depends_on' => array(
                    'library_item'
                )
            )
        );
        $icon = array(
            'use_icon'                  => array(
				'label'                 => esc_html__( 'Use Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => 'at_icon',
                'tab_slug'              => 'general',
                'affects'               => array (
                    'font_icon',
                    'icon_color',
                    'icon_size'
				)
            ),
            'font_icon'                 => array(
				'label'                 => esc_html__( 'Icon', 'divi_flash' ),
				'type'                  => 'select_icon',
				'option_category'       => 'basic_option',
				'class'                 => array( 'et-pb-font-icon' ),
                'toggle_slug'           => 'at_icon',
                'tab_slug'              => 'general',
                'depends_show_if'       => 'on'
            ),
            'icon_color'            => array (
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
				'tab_slug'          => 'general',
                'toggle_slug'       => 'at_icon',
                'hover'             => 'tabs'
            ),
            'icon_size'             => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'tab_slug'          => 'general',
				'toggle_slug'       => 'at_icon',
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
            'tab_image' => array (
                'label'                 => esc_html__( 'Tab Image', 'dgat-advanced-tabs' ),
                'description'           => esc_html__( 'Dynamic Content Shown Only Frontend', 'divi_flash' ),
				'type'                  => 'upload',
                'option_category'       => 'basic_option',
				'upload_button_text'    => esc_attr__( 'Upload an image', 'dgat-advanced-tabs' ),
				'choose_text'           => esc_attr__( 'Choose an Image', 'dgat-advanced-tabs' ),
				'update_text'           => esc_attr__( 'Set As Image', 'dgat-advanced-tabs' ),
                'toggle_slug'           => 'at_icon',
                'dynamic_content'       => 'image',
                'show_if_not'           => array('use_icon' => 'on')
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
                'dynamic_content'       => 'image',
                // 'show_if_not'           => array('use_library_item' => 'on')
            ),
            'alt' => array (
                'label'                 => esc_html__( 'Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'image',
                // 'show_if_not'           => array('use_library_item' => 'on')
            ),
            'iamge_place'   => array(
                'label'             => esc_html__( 'Image Placement', 'divi_flash' ),
				'type'              => 'composite',
				'tab_slug'          => 'general',
                'toggle_slug'       => 'image',
                'composite_type'    => 'default',
                // 'show_if_not'       => array('use_library_item' => 'on'),
                'composite_structure' => array(
					'desktop' => array(
                        'icon'     => 'desktop',
						'controls' => array(
							'img_placement' => array(
                                'label'                 => esc_html__('Image Placement Desktop', 'divi_flash'),
                                'type'                  => 'select',
                                'default'               => 'top',
                                'options'               => array(
                                    'flex_top'       => esc_html__('Default', 'divi_flash'),
                                    'flex_bottom'    => esc_html__('Bottom', 'divi_flash'),
                                    'flex_left'      => esc_html__('Left', 'divi_flash'),
                                    'flex_right'     => esc_html__('Right', 'divi_flash')
                                ),
                                'toggle_slug'            => 'image',
                                'tab_slug'               => 'general'
                            ),
                            'img_container_width'   => array(
                                'label'             => esc_html__( 'Container Width Desktop', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'image',
                                'tab_slug'          => 'general',
                                'default'           => '50%',
                                'default_unit'      => '%',
                                'default_on_front'  => '50%',
                                'range_settings'    => array(
                                    'min'  => '1',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                                'show_if'           => array(
                                    'img_placement' => array('flex_left', 'flex_right')
                                )
                            ),
						),
					),
					'tablet' => array(
                        'icon'  => 'tablet',
						'controls' => array(
							'img_placement_tablet' => array(
                                'label'                 => esc_html__('Image Placement Tablet', 'divi_flash'),
                                'type'                  => 'select',
                                'default'               => 'top',
                                'options'               => array(
                                    'flex_top'       => esc_html__('Default', 'divi_flash'),
                                    'flex_bottom'    => esc_html__('Bottom', 'divi_flash'),
                                    'flex_left'      => esc_html__('Left', 'divi_flash'),
                                    'flex_right'     => esc_html__('Right', 'divi_flash')
                                ),
                                'toggle_slug'            => 'image',
                                'tab_slug'               => 'general',
                            ),
                            'img_container_width_tablet'   => array(
                                'label'             => esc_html__( 'Container Width Tablet', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'image',
                                'tab_slug'          => 'general',
                                'default'           => '50%',
                                'default_unit'      => '%',
                                'default_on_front'  => '50%',
                                'range_settings'    => array(
                                    'min'  => '1',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                                'show_if'           => array(
                                    'img_placement_tablet' => array('flex_left', 'flex_right')
                                )
                            ),
						),
					),
					'phone' => array(
                        'icon'  => 'phone',
						'controls' => array(
							'img_placement_phone' => array(
                                'label'                 => esc_html__('Image Placement Mobile', 'divi_flash'),
                                'type'                  => 'select',
                                'default'               => 'top',
                                'options'               => array(
                                    'flex_top'       => esc_html__('Default', 'divi_flash'),
                                    'flex_bottom'    => esc_html__('Bottom', 'divi_flash'),
                                    'flex_left'      => esc_html__('Left', 'divi_flash'),
                                    'flex_right'     => esc_html__('Right', 'divi_flash')
                                ),
                                'toggle_slug'            => 'image',
                                'tab_slug'               => 'general',
                            ),
                            'img_container_width_phone'   => array(
                                'label'             => esc_html__( 'Container Width Mobile', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'image',
                                'tab_slug'          => 'general',
                                'default'           => '50%',
                                'default_unit'      => '%',
                                'default_on_front'  => '50%',
                                'range_settings'    => array(
                                    'min'  => '1',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                                'show_if'           => array(
                                    'img_placement_phone' => array('flex_left', 'flex_right')
                                )
                            ),
						),
					),
				),
            ),
            'image_z_index'    => array (
                'label'             => esc_html__( 'Image Z-index', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'image',
                'tab_slug'          => 'advanced',
                'default'           => '0',
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '15',
                    'step' => '1',
                ),
                'validate_unit'     => false
            )
        );
        $navigation_settings = array(
            'default_active'  => array(
                'label'           => esc_html__( 'Set as Active', 'divi_flash' ),
                'description'     => esc_html__( 'Set the default active tab for User.', 'divi_flash' ),
                'type'            => 'yes_no_button',
                'option_category' => 'basic_option',
                'options'         => array(
                    'off' => esc_html__( 'No', 'divi_flash' ),
                    'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'         => 'off',
                'tab_slug'        => 'general',
                'toggle_slug'     => 'navigation_settings'
            ),
            'navigation_link' => array(
                'label'           => esc_html__( 'Navigation Link', 'divi_flash' ),
                'description'     => esc_html__( 'Use this link to landing this web page and open specific tab.', 'divi_flash' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'tab_slug'        => 'general',
                'toggle_slug'     => 'navigation_settings'
            ),
        );
        $at_button = array(
            'at_button_button_text' => array(
                'label'           => esc_html__( 'Button Text', 'divi_flash' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Input your desired button text, or leave blank for no button.', 'divi_flash' ),
                'toggle_slug'     => 'at_button',
                'tab_slug'        => 'general',
                'dynamic_content'   => 'text'
                // 'show_if_not'     => array('use_library_item' => 'on')
            ),
            'at_button_button_url' => array(
                'label'           => esc_html__( 'Button URL', 'divi_flash' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Input URL for your button.', 'divi_flash' ),
                'toggle_slug'     => 'at_button',
                'tab_slug'        => 'general',
                'dynamic_content'  => 'url'
                // 'show_if_not'     => array('use_library_item' => 'on')
            ),
            'at_button_button_url_new_window' => array(
                'default'         => 'off',
                'default_on_front'=> true,
                'label'           => esc_html__( 'Url Opens', 'divi_flash' ),
                'type'            => 'select',
                'option_category' => 'configuration',
                'options'         => array(
                    'off' => esc_html__( 'In The Same Window', 'divi_flash' ),
                    'on'  => esc_html__( 'In The New Tab', 'divi_flash' ),
                ),
                'toggle_slug'     => 'at_button',
                'tab_slug'        => 'general',
                // 'show_if_not'     => array('use_library_item' => 'on')
            ),
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
        $image_sizing =  $this->df_add_max_width(array(
            'key'                   => 'image_size',
            'toggle_slug'           => 'image',
            'alignment'             => true,
            'tab_slug'              => 'advanced',
        ));
        $button_background = $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'button',
            'toggle_slug'           => 'at_button',
            'tab_slug'              => 'advanced'
        ));
        $button_spacing = $this->add_margin_padding(array(
            'title'         => 'Button',
            'key'           => 'button',
            'toggle_slug'   => 'at_button',
            'tab_slug'      => 'advanced'
        ));
        $image_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Image Wrapper',
            'key'           => 'image_wrapper',
            'toggle_slug'   => 'margin_padding'
        ));
        $item_content_spacing = $this->add_margin_padding(array(
            'title'         => 'Content Wrapper',
            'key'           => 'content',
            'toggle_slug'   => 'margin_padding'
        ));
        $text_area_background = $this->df_add_bg_field(array(
            'label'                 => 'Nav Item Background',
            'key'                   => 'text_area',
            'toggle_slug'           => 'text_area',
            'tab_slug'              => 'general'
        ));

        return array_merge(
            $general,
            $icon,
            $image,
            $image_sizing,
            $navigation_settings,
            $at_button,
            $button,
            $text_area_background,
            $button_background,
            $button_spacing,
            $image_wrapper_spacing,
            $item_content_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $button = '%%order_class%% .df_at_button';
        $image = '%%order_class%% .df_at_image';

        $fields['icon_color'] = array('color' => '%%order_class%%.df_at_nav .et-pb-icon');
        $fields['image_size_maxwidth'] = array('max-width' => $image);

        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'button',
            'selector'      => '%%order_class%% .df_at_button'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'text_area',
            'selector'      => '%%order_class%% .df_at_content_wrapper'
        ));

        // spacing
        $fields['image_wrapper_margin'] = array('margin' => '%%order_class%% .df_at_image_wrapper');
        $fields['image_wrapper_padding'] = array('padding' => '%%order_class%% .df_at_image_wrapper');

        $fields['content_margin'] = array('margin' => '%%order_class%% .df_at_content_wrapper');
        $fields['content_padding'] = array('padding' => '%%order_class%% .df_at_content_wrapper');

        $fields['button_margin'] = array('margin' => $button);
        $fields['button_padding'] = array('padding' => $button);

        // border
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

	public static function df_divi_library_shortcode( $args = [] ) {
		if ( empty( $args['library_item'] ) || 'none' === $args['library_item'] ) {
			return '';
		}

		return df_render_library_layout( $args['library_item'] );
	}

    public function additional_css_styles($render_slug) {
        // image placements
        if ('' !== $this->props['image']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ati_container',
                'declaration' => sprintf('flex-direction:%1$s;',$this->df_process_values($this->props['img_placement'])),
                'media_query' => ET_Builder_Element::get_media_query('min_width_981')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ati_container',
                'declaration' => sprintf('flex-direction:%1$s;',$this->df_process_values($this->props['img_placement_tablet'])),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ati_container',
                'declaration' => sprintf('flex-direction:%1$s;',$this->df_process_values($this->props['img_placement_phone'])),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

        if('' !== $this->props['image'] && ($this->props['img_placement'] === 'flex_left' || $this->props['img_placement'] === 'flex_right')) {
            $img_container_width = '' !== $this->props['img_container_width'] ?
                $this->props['img_container_width'] : '50%';

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_image_wrapper',
                'declaration' => "width:{$img_container_width};",
                'media_query' => ET_Builder_Element::get_media_query('min_width_981')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_content_wrapper',
                'declaration' => "width:calc(100% - {$img_container_width});",
                'media_query' => ET_Builder_Element::get_media_query('min_width_981')
            ));
        }
        if(($this->props['img_placement_tablet'] === 'flex_left' || $this->props['img_placement_tablet'] === 'flex_right') && '' !== $this->props['image']) {
            $img_container_width_tablet = '' !== $this->props['img_container_width_tablet'] ?
                $this->props['img_container_width_tablet'] : '50%';

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_image_wrapper',
                'declaration' => "width:{$img_container_width_tablet};",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_content_wrapper',
                'declaration' => "width:calc(100% - {$img_container_width_tablet});",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }
        if(($this->props['img_placement_phone'] === 'flex_left' || $this->props['img_placement_phone'] === 'flex_right') && '' !== $this->props['image']) {
            $img_container_width_phone = '' !== $this->props['img_container_width_phone'] ?
                $this->props['img_container_width_phone'] : '50%';

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_image_wrapper',
                'declaration' => "width:{$img_container_width_phone};",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_at_content_wrapper',
                'declaration' => "width:calc(100% - {$img_container_width_phone});",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }



        if(isset($this->props['icon_color']) && $this->props['icon_size'] !== '') {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_color',
                'type'              => 'color',
                'selector'          => '%%order_class%%.df_at_nav .et-pb-icon',
                'hover'             => '%%order_class%%.df_at_nav:hover .et-pb-icon',
                'important'         => true
            ));
        }
        if(isset($this->props['icon_size']) && $this->props['icon_size'] !== '') {
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_size',
                'type'              => 'font-size',
                'selector'          => '%%order_class%%.df_at_nav .et-pb-icon',
                'important'         => true
            ) );
        }
        // process background
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button',
            'selector'          => ".difl_advancedtab {$this->main_css_element} .df_at_button",
            'hover'             => ".difl_advancedtab {$this->main_css_element} .df_at_button:hover"
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'text_area',
            'selector'          => ".difl_advancedtab {$this->main_css_element} .df_at_content_wrapper",
            'hover'             => ".difl_advancedtab {$this->main_css_element} .df_at_content_wrapper:hover"
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => ".difl_advancedtab {$this->main_css_element} .df_at_button_wrapper",
            'declaration' => sprintf('text-align: %1$s;', $this->props['button_align'])
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "{$this->main_css_element} .df_at_image_wrapper",
            'declaration' => sprintf('z-index: %1$s;', $this->props['image_z_index'])
        ));

        // spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_wrapper_margin',
            'type'              => 'margin',
            'selector'          => ".difl_advancedtab {$this->main_css_element} .df_at_image_wrapper",
            'hover'             => ".difl_advancedtab {$this->main_css_element}:hover .df_at_image_wrapper",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_wrapper_padding',
            'type'              => 'padding',
            'selector'          => ".difl_advancedtab {$this->main_css_element} .df_at_image_wrapper",
            'hover'             => ".difl_advancedtab {$this->main_css_element}:hover .df_at_image_wrapper",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_margin',
            'type'              => 'margin',
            'selector'          => ".difl_advancedtab {$this->main_css_element} .df_at_content_wrapper",
            'hover'             => ".difl_advancedtab {$this->main_css_element}:hover .df_at_content_wrapper",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_padding',
            'type'              => 'padding',
            'selector'          => ".difl_advancedtab {$this->main_css_element} .df_at_content_wrapper",
            'hover'             => ".difl_advancedtab {$this->main_css_element}:hover .df_at_content_wrapper",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => ".difl_advancedtab {$this->main_css_element} .df_at_button",
            'hover'             => ".difl_advancedtab {$this->main_css_element}:hover .df_at_button",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => ".difl_advancedtab {$this->main_css_element} .df_at_button",
            'hover'             => ".difl_advancedtab {$this->main_css_element}:hover .df_at_button",
            'important'         => false
        ));

        // max width
        $this->df_process_maxwidth(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_size',
            'selector'          => '%%order_class%% .df_at_image',
            'hover'             => '%%order_class%%:hover .df_at_image',
            'alignment'         => true,
            'important'         => false
        ));
        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-tab-nav-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }
    }

    public function maybe_inherit_values() {
        $order_class = ET_Builder_Element::get_module_order_class( "difl_advancedtabitem" );
        $page_link = esc_html__(get_page_link(), 'divi_flash');
        $this->props['navigation_link'] = sprintf('%1$s#%2$s',
            $page_link,
            esc_html__($order_class, 'divi_flash')
        );
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
            return sprintf('<div class="df_at_button_wrapper">
                <a class="df_at_button" href="%1$s" %3$s>%2$s</a>
            </div>',
            esc_attr($url), esc_html($text), $target);
        } else { return ''; }
    }

    public function df_render_content($content_container) {
        if($this->props['content_type'] == 'library') {
            $library = self::df_divi_library_shortcode(array(
                'library_item' => $this->props['library_item']
            ));
            return sprintf('<div class="df_at_content_wrapper">%1$s</div>', $library);
        } else {
            return $content_container;
        }
    }

    public function render( $attrs, $content, $render_slug ) {
		$this->handle_fa_icon();
        global $df_at_data;
        $df_ati_class = ET_Builder_Element::get_module_order_class( $render_slug );

        $df_at_data[$df_ati_class]['default_active'] = "on" === $this->props['default_active'] ? $this->props['default_active'] : "off";
        $df_at_data[$df_ati_class]['title'] = esc_html($this->props['title']);
        $df_at_data[$df_ati_class]['subtitle'] = wp_kses_post($this->props['subtitle']);
        $df_at_data[$df_ati_class]['use_icon'] = esc_html($this->props['use_icon']);
        $df_at_data[$df_ati_class]['font_icon'] = esc_attr(et_pb_process_font_icon( $this->props['font_icon'] ));
        $df_at_data[$df_ati_class]['tab_image'] = esc_url( $this->props['tab_image'] );
        $this->additional_css_styles($render_slug);

        // filter for images
		if (array_key_exists('image', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['image'])) {
			$this->add_classname($this->generate_css_filters(
				$render_slug,
				'child_',
				self::$data_utils->array_get($this->advanced_fields['image']['css'], 'main', '%%order_class%%')
			));
		}
        $image_alt_text = $this->props['alt'] !== '' ? $this->props['alt']  : df_image_alt_by_url($this->props['image']);
        $image = '' !== $this->props['image'] && $this->props['content_type'] !== 'library' ?
            sprintf('<div class="df_at_image_wrapper"><img class="df_at_image" src="%1$s" alt="%2$s" /></div>',
                esc_attr($this->props['image']),
                esc_attr($image_alt_text)
            ) : '';

        $content = isset($this->props['content']) && $this->props['content'] !== '' ?
            sprintf('<div class="df_at_content">%1$s</div>', $this->props['content']) : '';

        $content_container = $content !== '' || $this->df_render_button('at_button') !== '' ?
            sprintf('<div class="df_at_content_wrapper">%1$s %2$s</div>',
                $content, $this->df_render_button('at_button')
            ) : '';

        return sprintf('<div class="df_ati_container">%2$s%1$s</div>', $this->df_render_content($content_container), $image);
    }
}
new DIFL_AdvancedTabItem;
