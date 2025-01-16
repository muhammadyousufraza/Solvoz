<?php

class DIFL_ScrollImage extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_scrollimage';
    public $vb_support = 'on';
    use DF_UTLS;

    protected $module_credits = array (
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__('Scroll Image', 'divi_flash');
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/scroll-image.svg';
    }

    public function get_settings_modal_toggles() {
        return array(
            'general'   => array(
                'toggles'         => array(
                'image'           => esc_html__('Image', 'divi_flash'),
                'scroll_settings' => esc_html__('Scroll Settings', 'divi_flash'),
                'image_settings'  => esc_html__('Image Settings', 'divi_flash'),
                'icon'   => esc_html__('Icon', 'divi_flash'),
                'caption'         => esc_html__('Caption', 'divi_flash'),
                'frame'           => esc_html__('Frame', 'divi_flash'),
                'badge'           => esc_html__('Badge', 'divi_flash'),
                'external_link'   => esc_html__('Lightbox & Link', 'divi_flash'),
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'image'             => esc_html__('Image Design', 'divi_flash'),
                    'icon'   => esc_html__('Icon Design', 'divi_flash'),
                    'caption'           => esc_html__('Caption Design', 'divi_flash'),
                    'caption_text'   => array(
						'title'             => esc_html__('Caption Text', 'divi_flash'),
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
					'caption_header' => array(
						'title'             => esc_html__( 'Caption Heading', 'divi_flash' ),
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
                    'frame'           => esc_html__('Frame Design', 'divi_flash'),
                    'badge'             => esc_html__('Badge Design', 'divi_flash'),
                    'custom_spacing'    => array (
                        'title'             => esc_html__('Custom Spacing', 'divi_flash'),
                    )
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();
        $advanced_fields['link_options'] = false;
        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = array (
            'badge_text'   => array(
                // 'label'         => esc_html__('Badge', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'   => 'badge',
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_scroll_image_badge",
                    'hover' => "%%order_class%% .df_scroll_image_badge:hover",
                    'important' => 'all',
                ),
            ),

            'text'     => array(
                // 'label'           => et_builder_i18n( 'Text' ),
                'css'             => array(
                    'main'        => "{$this->main_css_element} .df_scroll_image_caption",
                    'line_height' => "{$this->main_css_element} .df_scroll_image_caption",
                    'color'       => "{$this->main_css_element} .df_scroll_image_caption"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'toggle_slug'     => 'caption_text',
                'sub_toggle'      => 'p',
                // 'hide_text_align' => true,
            ),
            'link'     => array(
                'label'       => et_builder_i18n( 'Link' ),
                'css'         => array(
                    'main'  => "{$this->main_css_element} .df_scroll_image_caption a",
                    'color' => "{$this->main_css_element} .df_scroll_image_caption a",
                ),
                'line_height' => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'   => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'hide_text_align' => true,
                'toggle_slug' => 'caption_text',
                'sub_toggle'  => 'a',
            ),
            'ul'       => array(
                'label'       => esc_html__( 'Unordered List', 'divi_flash' ),
                'css'         => array(
                    'main'        => "{$this->main_css_element} .df_scroll_image_caption ul li",
                    'color'       => "{$this->main_css_element} .df_scroll_image_caption ul li",
                    'line_height' => "{$this->main_css_element} .df_scroll_image_caption ul li",
                    'item_indent' => "{$this->main_css_element} .df_scroll_image_caption ul",
                ),
                'line_height' => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'caption_text',
                'sub_toggle'  => 'ul',
            ),
            'ol'       => array(
                'label'       => esc_html__( 'Ordered List', 'divi_flash' ),
                'css'         => array(
                    'main'        => "{$this->main_css_element} .df_scroll_image_caption ol li",
                    'color'       => "{$this->main_css_element} .df_scroll_image_caption ol li",
                    'line_height' => "{$this->main_css_element} .df_scroll_image_caption ol li",
                    'item_indent' => "{$this->main_css_element} .df_scroll_image_caption ol",
                ),
                'line_height' => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'caption_text',
                'sub_toggle'  => 'ol',
            ),
            'quote'    => array(
                'label'       => esc_html__( 'Blockquote', 'divi_flash' ),
                'css'         => array(
                    'main'  => "{$this->main_css_element} .df_scroll_image_caption blockquote",
                    'color' => "{$this->main_css_element} .df_scroll_image_caption blockquote",
                ),
                'line_height' => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'caption_text',
                'sub_toggle'  => 'quote',
            ),
            'header'   => array(
                'label'       => esc_html__( 'Heading', 'divi_flash' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df_scroll_image_caption h1",
                ),
                'font_size'   => array(
                    'default' => absint( et_get_option( 'body_header_size', '30' ) ) . 'px',
                ),
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'toggle_slug' => 'caption_header',
                'sub_toggle'  => 'h1',
            ),
            'header_2' => array(
                'label'       => esc_html__( 'Heading 2', 'divi_flash' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df_scroll_image_caption h2",
                ),
                'font_size'   => array(
                    'default' => '26px',
                ),
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'toggle_slug' => 'caption_header',
                'sub_toggle'  => 'h2',
            ),
            'header_3' => array(
                'label'       => esc_html__( 'Heading 3', 'divi_flash' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df_scroll_image_caption h3",
                ),
                'font_size'   => array(
                    'default' => '22px',
                ),
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'toggle_slug' => 'caption_header',
                'sub_toggle'  => 'h3',
            ),
            'header_4' => array(
                'label'       => esc_html__( 'Heading 4', 'divi_flash' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df_scroll_image_caption h4",
                ),
                'font_size'   => array(
                    'default' => '18px',
                ),
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'toggle_slug' => 'caption_header',
                'sub_toggle'  => 'h4',
            ),
            'header_5' => array(
                'label'       => esc_html__( 'Heading 5', 'divi_flash' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df_scroll_image_caption h5",
                ),
                'font_size'   => array(
                    'default' => '16px',
                ),
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'toggle_slug' => 'caption_header',
                'sub_toggle'  => 'h5',
            ),
            'header_6' => array(
                'label'       => esc_html__( 'Heading 6', 'divi_flash' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} .df_scroll_image_caption h6",
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'toggle_slug' => 'caption_header',
                'sub_toggle'  => 'h6',
            )
        );
        
        $advanced_fields['borders'] = array (
            'default'               => true,     
            'scroll_image_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_scroll_image_holder:not(.df_device_slider) ,{$this->main_css_element} .df_scroll_image_holder .scroll_image_section",
                        'border_radii_hover' => "{$this->main_css_element} .df_scroll_image_holder:not(.df_device_slider):hover , {$this->main_css_element} .df_scroll_image_holder:hover .scroll_image_section",
                        'border_styles' => "{$this->main_css_element} .df_scroll_image_holder:not(.df_device_slider) , {$this->main_css_element} .df_scroll_image_holder .scroll_image_section",
                        'border_styles_hover' => "{$this->main_css_element} .df_scroll_image_holder:not(.df_device_slider):hover , {$this->main_css_element} .df_scroll_image_holder:hover .scroll_image_section",
                    )
                ),
                'label'    => esc_html__('Scroll Image', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'image',
            ),
            'link_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_link_area",
                        'border_radii_hover' => "{$this->main_css_element} .df_link_area:hover",
                        'border_styles' => "{$this->main_css_element} .df_link_area",
                        'border_styles_hover' => "{$this->main_css_element} .df_link_area:hover",
                    )
                ),
                'label'    => esc_html__('Link', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'icon',
            ),
            'badge_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_scroll_image_badge",
                        'border_radii_hover' => "{$this->main_css_element} .df_scroll_image_badge:hover",
                        'border_styles' => "{$this->main_css_element} .df_scroll_image_badge",
                        'border_styles_hover' => "{$this->main_css_element} .df_scroll_image_badge:hover",
                    )
                ),
                'label'    => esc_html__('Badge Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'badge',
            ),

            'caption_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_scroll_image_container .df_scroll_image_caption",
                        'border_radii_hover' => "{$this->main_css_element} .df_scroll_image_container .df_scroll_image_caption:hover",
                        'border_styles' => "{$this->main_css_element} .df_scroll_image_container .df_scroll_image_caption",
                        'border_styles_hover' => "{$this->main_css_element} .df_scroll_image_container .df_scroll_image_caption:hover",
                    )
                ),
                'label'    => esc_html__('Caption Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'caption',
            ),
        );

        $advanced_fields['box_shadow'] = array (
            'default'               => true,
            'scroll_image_box_shadow'             => array(
                'label'    => esc_html__('Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .df_scroll_image_holder:not(.df_device_slider) , %%order_class%% .df_scroll_image_holder .scroll_image_section",
                    'hover' => "%%order_class%% .df_scroll_image_holder:not(.df_device_slider):hover , %%order_class%% .df_scroll_image_holder:hover .scroll_image_section",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'image',
            ),
            'link_box_shadow'             => array(
                'label'    => esc_html__('Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .df_link_area",
                    'hover' => "%%order_class%% .df_link_area:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'icon',
            ),
            'badge_box_shadow'             => array(
                'label'    => esc_html__('Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .df_scroll_image_badge",
                    'hover' => "%%order_class%% .df_scroll_image_badge:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'badge',
            ),
            'caption_box_shadow'             => array(
                'label'    => esc_html__('Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .df_scroll_image_container .df_scroll_image_caption",
                    'hover' => "%%order_class%% .df_scroll_image_container .df_scroll_image_caption:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'caption',
            ),
        );
        $advanced_fields['filters'] = array(
            'default' => array(
                'label'    => esc_html__('Image filter', 'divi_flash'),
                'css' => array(
                    'main' => array(
                        '%%order_class%% .df_scroll_image',
                    )
                ),
            )
            
        );
        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'important' => 'all'
            )
        ); 

        $advanced_fields['background'] = false;

    
        return $advanced_fields;
    }

    public function get_fields() {
        
        $image = array(
            'scroll_image' => array(
                'label'                 => esc_html__('Image' , 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                //'default'               => 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA4MCIgaGVpZ2h0PSI1NDAiIHZpZXdCb3g9IjAgMCAxMDgwIDU0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPHBhdGggZmlsbD0iI0VCRUJFQiIgZD0iTTAgMGgxMDgwdjU0MEgweiIvPgogICAgICAgIDxwYXRoIGQ9Ik00NDUuNjQ5IDU0MGgtOTguOTk1TDE0NC42NDkgMzM3Ljk5NSAwIDQ4Mi42NDR2LTk4Ljk5NWwxMTYuMzY1LTExNi4zNjVjMTUuNjItMTUuNjIgNDAuOTQ3LTE1LjYyIDU2LjU2OCAwTDQ0NS42NSA1NDB6IiBmaWxsLW9wYWNpdHk9Ii4xIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgICAgICA8Y2lyY2xlIGZpbGwtb3BhY2l0eT0iLjA1IiBmaWxsPSIjMDAwIiBjeD0iMzMxIiBjeT0iMTQ4IiByPSI3MCIvPgogICAgICAgIDxwYXRoIGQ9Ik0xMDgwIDM3OXYxMTMuMTM3TDcyOC4xNjIgMTQwLjMgMzI4LjQ2MiA1NDBIMjE1LjMyNEw2OTkuODc4IDU1LjQ0NmMxNS42Mi0xNS42MiA0MC45NDgtMTUuNjIgNTYuNTY4IDBMMTA4MCAzNzl6IiBmaWxsLW9wYWNpdHk9Ii4yIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgIDwvZz4KPC9zdmc+Cg==',
                'upload_button_text'    => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'image',
                'dynamic_content'       => 'image'
            ),
            'image_min_height'   => array (
                'label'             => esc_html__( 'Min Height', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'image',
				'default'           => '450px',
                'default_unit'      => 'px',
                'responsive'        => true,
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '2000',
					'step' => '1',
                ),
                'show_if' => array(
                    'enable_frame' => 'off'
                )
            )  
        );
        $scroll_settings = array (
            'image_scroll_type'    => array (
                'label'             => esc_html__('Scroll Type', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'top_bottom'           => esc_html__( 'Top To Bottom', 'divi_flash' ),
                    'bottom_top'        => esc_html__( 'Bottom To Top', 'divi_flash' ),
                    'left_right'          => esc_html__( 'Left To Right', 'divi_flash' ),
                    'right_left'         => esc_html__( 'Right To Left', 'divi_flash' ),
                    'off'         => esc_html__( 'Off', 'divi_flash' )
                ),
                'default'         => 'top_bottom',
                'toggle_slug'     => 'scroll_settings'
            )
     
        );
        $caption_settings = array(
            'enable_caption'      => array (
                'label'                 => esc_html__( 'Caption', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'caption'
            ),
            'caption_text'        => array (
                'label'             => esc_html__('Caption', 'divi_flash'),
                'type'              => 'tiny_mce',
                'dynamic_content'   => 'text',
                'toggle_slug'       => 'caption',
                'show_if'           => array(
                    'enable_caption' => 'on'
                )
            ),  
        );

        $lightbox_settings = array(
            'use_light_box'      => array (
                'label'                 => esc_html__( 'Use Lightbox', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'external_link',
                'show_if'   => array(
                    'enable_custom_link' => 'off'
                )
            ),
            'use_different_lightbox_image'      => array (
                'label'                 => esc_html__( 'Use Different Lightbox Image ', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'external_link',
                'show_if'   => array(
                    //'enable_link' => 'on',
                    'use_light_box'=> 'on',
                    'enable_custom_link' => 'off'
                )
            ),
            'different_lightbox_image' => array(
                'label'                 => esc_html__('Different Lightbox Image' , 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'default'               => '',
                'upload_button_text'    => esc_attr__('Upload an Lightbox Image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Lightbox Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Lightbox Image', 'divi_flash'),
                'toggle_slug'           => 'external_link',
                'show_if'   => array(
                    //'enable_link' => 'on',
                    'use_light_box'=> 'on',
                    'use_different_lightbox_image'=> 'on',
                    'enable_custom_link' => 'off'
                )
            ),
            'enable_custom_link'      => array (
                'label'                 => esc_html__( 'Custom Link', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'external_link',
                'show_if'   => array(
                    'use_light_box' => 'off'
                )
            ),
            'link_url' => array(
                'label'           => esc_html__('Link URL', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Title entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'external_link',
                'show_if'           => array(
                    'use_light_box' => 'off',
                    'enable_custom_link' => 'on'
                )
            ),

            'link_url_target' => array(
                'label'           => esc_html__('Link Target', 'divi_flash'),
                'type'            => 'select',
                'options'       => array (
                    'same_window'     => esc_html__('In The Same Window', 'divi_flash'),
                    'new_window'      => esc_html__('In The New Tab', 'divi_flash')
                ),
                'default'         => 'same_window',
                'toggle_slug'     => 'external_link',
                'description'     => esc_html__('Choose whether your link opens in a new window or not', 'divi_flash'),
                'show_if'           => array(
                    'use_light_box' => 'off',
                    'enable_custom_link' => 'on'
                )
            ),

            'enable_icon'      => array (
                'label'                 => esc_html__( 'Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'icon'        
            ),

            'use_image_as_icon'      => array (
                'label'                 => esc_html__( 'Use Image as Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'icon',
                'show_if'           => array(
                    'enable_icon' => 'on'
                ),         
            ),

            'link_icon' => array(
                'label'                 => esc_html__('Icon', 'divi_flash'),
                'type'                  => 'select_icon',
                'class'                 => array('et-pb-font-icon'),
                'default'               => '5',
                'option_category'       => 'basic_option',
                'toggle_slug'           => 'icon',
                //'depends_show_if'     => 'on',
                'show_if'         => array(
                    'enable_icon' => 'on',
                    'use_image_as_icon'    => 'off'
                )
            ),
            
            'link_icon_color' => array(
                'label'           => esc_html__('Icon Color', 'divi_flash'),
                'default'         => "#333",
                'hover'            => 'tabs',
                'type'            => 'color-alpha',
                'toggle_slug'     => 'icon',
                'tab_slug'        => 'advanced',
                //'depends_show_if'     => 'on',
                'show_if'         => array(
                    'enable_icon' => 'on',
                    'use_image_as_icon'    => 'off'
                ),
            ),

            'icon_size' => array(
                'label'             => esc_html__('Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'icon',
                'tab_slug'          => 'advanced',
                'default'           => '36px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '500',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'enable_icon' => 'on',
                    'use_image_as_icon'    => 'off'
                ),
            ),

            'image' => array(
                'label'                 => esc_html__('Image as Icon', 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'upload_button_text'    => esc_attr__('Upload an Image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'icon',
                'dynamic_content'       => 'image',
                'show_if'         => array(
                    'enable_icon' => 'on',
                    'use_image_as_icon'  => 'on'
                ),
            ),
            'image_container_width' => array(
                'label'             => esc_html__('Image Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'icon',
                'tab_slug'          => 'advanced',
                'default'           => '50px',
                'allowed_units'     => array('px', '%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'enable_icon' => 'on',
                    'use_image_as_icon'  => 'on'
                ),
                'show_if_not'           => array(
                    'image' => array('')
                ),
                'description'     => esc_html__('Set Icon Image Width', 'divi_flash')
            ),
            'alt_text' => array(
                'label'                 => esc_html__('Image Alt Text', 'divi_flash'),
                'description'           => esc_html__( 'This defines the HTML ALT text. A short description of your image can be placed here.', 'divi_flash' ),
                'type'                  => 'text',
                'toggle_slug'           => 'icon',
                'show_if'               => array(
                    'enable_icon' => 'on',
                    'use_image_as_icon'  => 'on'
                ),
                'show_if_not'           => array(
                    'image' => array('')
                )
            ),
            'link_position'    => array (
                'label'             => esc_html__(' Icon/Image Position', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'top_left'           => esc_html__( 'Top Left', 'divi_flash' ),
                    'top_right'        => esc_html__( 'Top Right', 'divi_flash' ),
                    'top_center'          => esc_html__( 'Top Center', 'divi_flash' ),
                    'center_center'        => esc_html__( 'Center', 'divi_flash' ),
                    'center_left'         => esc_html__( 'Center Left', 'divi_flash' ),
                    'center_right'        => esc_html__( 'Center Right', 'divi_flash' ),
                    'bottom_left'         => esc_html__( 'Bottom Left', 'divi_flash' ),
                    'bottom_right'        => esc_html__( 'Bottom Right', 'divi_flash' ),
                    'bottom_center'          => esc_html__( 'Bottom Center', 'divi_flash' )          
                ),
                'default'         => 'center_center',
                'toggle_slug'     => 'icon',
                'show_if'          => array(
                    'enable_icon' => 'on'
                )
    
            ),
            'show_on_hover'      => array (
                'label'                 => esc_html__( 'Show On Hover', 'divi_flash' ),
                'type'                  => 'yes_no_button',
                'options'               => array(
                    'off' => esc_html__( 'No', 'divi_flash' ),
                    'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'icon', 
                'show_if'          => array(
                    'enable_icon' => 'on',
                    'hide_on_hover' => 'off'
                )       
            ),

            'hide_on_hover'      => array (
                'label'                 => esc_html__( 'Hide On Hover', 'divi_flash' ),
                'type'                  => 'yes_no_button',
                'options'               => array(
                    'off' => esc_html__( 'No', 'divi_flash' ),
                    'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'icon', 
                'show_if'          => array(
                    'enable_icon' => 'on',
                    'show_on_hover' => 'off'
                )           
            ),
            
            'icon_motion'      => array (
                'label'                 => esc_html__( 'Icon Motion', 'divi_flash' ),
                'type'                  => 'yes_no_button',
                'options'               => array(
                    'off' => esc_html__( 'No', 'divi_flash' ),
                    'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'icon',  
                'show_if'    => array(
                    'enable_icon' => 'on'
                )      
            )  

        );

        $badge_settings = array (
            'enable_badge'      => array (
                'label'                 => esc_html__( 'Badge', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'badge',
            ),
            'badge_text'      => array (
                'label'             => esc_html__('Badge Text', 'divi_flash'),
                'type'              => 'text',
                'dynamic_content'   => 'text',
                'toggle_slug'       => 'badge',
                'show_if'           => array(
                    'enable_badge' => 'on'
                )
            ),
            'badge_icon_enable'  => array(
                'label'             => esc_html__('Use Badge Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'badge',
                'show_if'         => array(
                    'enable_badge'     => 'on'
                ),
                'show_if_not'   =>array(
                    'badge_text' => array('')
                ) 
            ),
            'badge_icon' => array(
                'label'                 => esc_html__('Badge Icon', 'divi_flash'),
                'type'                  => 'select_icon',
                'class' => array('et-pb-font-icon'),
                'default' => '5',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'badge',
                'show_if'         => array(
                    'badge_icon_enable'     => 'on',
                    'enable_badge'     => 'on'
                ),
                'show_if_not'   =>array(
                    'badge_text' => array('')
                ) 
            ),

            'badge_icon_placement'   => array(
                'label'             => esc_html__('Icon Placement', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'left'          => esc_html__('Left', 'divi_flash'),
                    'right'         => esc_html__('Right', 'divi_flash')
                ),
                'default'           => 'right',
                'toggle_slug'       => 'badge',
                'show_if'         => array(
                    'badge_icon_enable' => 'on',
                    'enable_badge'      => 'on'
                ),
                'show_if_not'   =>array(
                    'badge_text' => array('')
                ) 
            ),

            'badge_icon_color' => array(
                'label'                 => esc_html__('Icon Color', 'divi_flash'),

                'type'            => 'color-alpha',
                'toggle_slug'   => 'badge',
                'tab_slug'        => 'advanced',
                'hover'            => 'tabs',
                'show_if'         => array(
                    'badge_icon_enable'     => 'on',
                    'enable_badge'     => 'on'
                ),
                'show_if_not'   =>array(
                    'badge_text' => array('')
                )
               
            ),

            'badge_icon_size' => array(
                'label'             => esc_html__('Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'badge',
                'tab_slug'       => 'advanced',
                'allowed_units'     => array('px'),
                'default'           => '14px',
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '500',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'         => array(
                    'badge_icon_enable'     => 'on',
                    'enable_badge'     => 'on'
                ),
                'show_if_not'   =>array(
                    'badge_text' => array('')
                )
            ),
            'badge_position'    => array (
                'label'             => esc_html__('Badge Position', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'top_left'            => esc_html__( 'Top Left', 'divi_flash' ),
                    'top_right'           => esc_html__( 'Top Right', 'divi_flash' ),
                    'top_center'          => esc_html__( 'Top Center', 'divi_flash' ),
                    'center_center'              => esc_html__( 'Center', 'divi_flash' ),
                    'center_left'         => esc_html__( 'Center Left', 'divi_flash' ),
                    'center_right'        => esc_html__( 'Center Right', 'divi_flash' ),
                    'bottom_left'         => esc_html__( 'Bottom Left', 'divi_flash' ),
                    'bottom_right'        => esc_html__( 'Bottom Right', 'divi_flash' ),
                    'bottom_center'          => esc_html__( 'Bottom Center', 'divi_flash' )  
                ),
                'default'           => 'top_center',
                'toggle_slug'     => 'badge',
                'show_if'           => array(
                    'enable_badge' => 'on'
                ),
                'show_if_not'   =>array(
                    'badge_text' => array('')
                )
            ),
            'badge_container_width' => array(
                'label'             => esc_html__('Badge Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'badge',
                'default'           => '25%',
                'allowed_units'     => array('px', '%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'enable_icon' => 'on',
                    'badge_position'  => array('top_center', 'center_center', 'bottom_center' )
                ),
                'description'     => esc_html__('Set Badge Container Width', 'divi_flash')
            ),

            'show_badge_on_hover'      => array (
                'label'                 => esc_html__( 'Show On Hover', 'divi_flash' ),
                'type'                  => 'yes_no_button',
                'options'               => array(
                    'off' => esc_html__( 'No', 'divi_flash' ),
                    'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'badge', 
                'show_if'          => array(
                    'enable_badge' => 'on',
                    'hide_badge_on_hover' => 'off'
                ),
                'show_if_not'   =>array(
                    'badge_text' => array('')
                )      
            ),

            'hide_badge_on_hover'      => array (
                'label'                 => esc_html__( 'Hide On Hover', 'divi_flash' ),
                'type'                  => 'yes_no_button',
                'options'               => array(
                    'off' => esc_html__( 'No', 'divi_flash' ),
                    'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'badge', 
                'show_if'          => array(
                    'enable_badge' => 'on',
                    'show_badge_on_hover' => 'off'
                ),
                'show_if_not'   =>array(
                    'badge_text' => array('')
                )        
            )
        );
        $frame_settings = array(
            'enable_frame'      => array (
                'label'                 => esc_html__( 'Frame', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'image'
            ),
            'frame_type'    => array (
                'label'             => esc_html__('Frame Type', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'desktop'           => esc_html__( 'Desktop', 'divi_flash' ),
                    'laptop'            => esc_html__( 'Laptop', 'divi_flash' ),
                    'macbook'           => esc_html__( 'Macbook', 'divi_flash' ),
                    'macbookpro'        => esc_html__( 'Macbookpro', 'divi_flash' ),
                    'ipad'              => esc_html__( 'Ipad', 'divi_flash' ),
                    'phone'             => esc_html__( 'Phone', 'divi_flash' ),
                    'tablet'            => esc_html__( 'Tablet', 'divi_flash' ),
                    'chrome'            => esc_html__( 'Chrome', 'divi_flash' ),
                    'chrome_dark'       => esc_html__( 'Chrome Dark', 'divi_flash' ),
                    'edge'              => esc_html__( 'Edge', 'divi_flash' ),
                    'edge_dark'         => esc_html__( 'Edge Dark', 'divi_flash' ),
                    'firefox'           => esc_html__( 'Firefox', 'divi_flash' ),
                    'firefox_dark'      => esc_html__( 'Firefox Dark', 'divi_flash' ),
                    'opera'             => esc_html__( 'Opera', 'divi_flash' ),
                    'opera_dark'        => esc_html__( 'Opera Dark', 'divi_flash' ),
                    'safari'            => esc_html__( 'Safari', 'divi_flash' )
                ),
                'default'         => 'desktop',
                'toggle_slug'     => 'image',
                'show_if'    => array(
                   'enable_frame' => 'on'
                )
            ),
        );
        $overlay = array(
            'overlay'    => array(
                'label'         => esc_html__('Overlay', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'image',
            ),
            'overlay_primary'  => array(
                'label'             => esc_html__( 'Overlay Primary color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'image',
                'default'           => '#00B4DB',
                'show_if'           => array(
                    'overlay'  => 'on'
                )
            ),
            'overlay_secondary'  => array(
                'label'             => esc_html__( 'Overlay Secondary color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'image',
                'default'           => '#0083B0',
                'show_if'           => array(
                    'overlay'  => 'on'
                )
            ),
            'overlay_direction'    => array (
                'label'             => esc_html__( 'Overlay Gradient Direction', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'image',
                'default'           => '180deg',
                'default_unit'      => 'deg',
                'allowed_units'     => array ('deg'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '360',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if'           => array(
                    'overlay'  => 'on'
                )
            ),
        );
        
        $link_icon_background = $this->df_add_bg_field(array(
            'label'                 => 'Icon/Image Background',
            'key'                   => 'link_icon_background',
            'toggle_slug'           => 'icon',
            'image'                 => false,
            'tab_slug'              => 'advanced',
            'show_if' => array(
                'enable_icon' => 'on'
            )

        ));
        $badge_background = $this->df_add_bg_field(array(
            'label'                 => 'Badge Background',
            'key'                   => 'badge_background',
            'toggle_slug'           => 'badge',
            'tab_slug'              => 'advanced',
            'show_if'               => array(
                'enable_badge'     => 'on'
            )
        ));

        $caption_background = $this->df_add_bg_field(array(
            'label'                 => 'Caption Background',
            'key'                   => 'caption_background',
            'toggle_slug'           => 'caption',
            'tab_slug'              => 'advanced',
            'show_if'               => array(
                'enable_caption'     => 'on'
            )
        ));

        $transition = $this->df_transition_options(array (
            'key'               => 'scroll',
            'toggle_slug'       => 'scroll_settings',
            'duration_default'  => '3s',
            'default_unit'      => 's',
            'allowed_units'     => array ('ms', 's')
        ));  

        // spacing
        $badge_spacing = $this->add_margin_padding(array(
            'title'         => 'Badge',
            'key'           => 'badge',
            'default_padding' => '10px|15px|10px|15px',
            'toggle_slug'   => 'custom_spacing',
            'show_if'               => array(
                'enable_badge'     => 'on'
            )
        ));

        $badge_icon_spacing = $this->add_margin_padding(array(
            'title'         => 'Badge Icon',
            'key'           => 'badge_icon',
            'toggle_slug'   => 'custom_spacing',
            'option'        => 'margin',
            'show_if'               => array(
                'enable_badge'     => 'on'
            )
        ));

        $caption_spacing = $this->add_margin_padding(array(
            'title'         => 'Caption',
            'key'           => 'caption',
            'toggle_slug'   => 'custom_spacing',
            'show_if'               => array(
                'enable_caption'     => 'on'
            )
        ));

        $link_icon_spacing = $this->add_margin_padding(array(
            'title'         => 'Icon',
            'key'           => 'link_icon',
            'toggle_slug'   => 'custom_spacing',
        ));
        return array_merge(
            $image,
            $scroll_settings,
            $frame_settings,
            $overlay,
            $caption_background,
            $caption_settings,
            $lightbox_settings,
            $link_icon_background,
            $badge_background,
            $badge_settings,
            $transition,
            $link_icon_spacing,
            $caption_spacing,
            $badge_spacing,
            $badge_icon_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        // selectors
         $badge = '%%order_class%% .df_scroll_image_badge';
         $caption = '%%order_class%% .df_scroll_image_caption';
         $link = '%%order_class%% .df_link_area'; 
         $link_icon = '%%order_class%% .df_link_icon'; 
         $scroll_image_area = '%%order_class%% .df_scroll_image_holder , %%order_class%% .df_scroll_image_holder .scroll_image_section';
        // background
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'link_icon_background',
            'selector'      => $link_icon
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'badge_background',
            'selector'      => $badge
        ));

        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'caption_background',
            'selector'      => $caption
        ));

        // spacing
        $fields['badge_margin'] = array ('margin' => $badge);
        $fields['badge_padding'] = array ('padding' => $badge);
        $fields['caption_margin'] = array ('margin' => $caption);
        $fields['caption_padding'] = array ('padding' => $caption);
        $fields['link_icon_margin'] = array ('margin' => $link_icon);
        $fields['link_icon_padding'] = array ('padding' => $link_icon);

        //
        $fields['link_icon_color'] = array ('color' => '%%order_class%% .et-pb-icon.df-sl-link-icon');
        $fields['badge_icon_color'] = array ('color' => '%%order_class%% .df_scroll_image_badge .et-pb-icon');
        //  fix border transition
        
        $fields = $this->df_fix_border_transition(
            $fields, 
            'scroll_image_border', 
            $scroll_image_area
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'link_border', 
            $link
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'badge_border', 
            $badge
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'caption_border', 
            $caption
        );
        // fix border transition
        $fields = $this->df_fix_box_shadow_transition(
            $fields, 
            'scroll_image_box_shadow', 
            $scroll_image_area
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields, 
            'link_box_shadow', 
            $link
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields, 
            'badge_box_shadow', 
            $badge
        );
        
        $fields = $this->df_fix_box_shadow_transition(
            $fields, 
            'caption_box_shadow', 
            $caption
        );
        
        return $fields;
    }

    public function additional_css_styles($render_slug) {

        // process animation transition
        $this->df_process_transition(array(
            'render_slug'       => $render_slug,
            'slug'              => 'scroll',
            'selector'          => '%%order_class%% .df_scroll_image_container .df_scroll_image_holder .df_scroll_image',
            'properties'        => ['background-position']
        )); 
        if($this->props['enable_frame'] !== 'on'){
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'image_min_height',
                'type'              => 'min-height',
                'selector'          => '%%order_class%% .df_scroll_image_container .df_scroll_image_holder .df_scroll_image',
                'important'         => false
            ) );
        }
  
        if ('on' === $this->props['use_image_as_icon']) {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'image_container_width',
                'type'              => 'width',
                'selector'          => '%%order_class%% .df_link_area'
            ));
        }
        
        // Background
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_background',
            'selector'          => "%%order_class%% .df_scroll_image_badge",
            'hover'             => '%%order_class%% .df_scroll_image_badge:hover'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'caption_background',
            'selector'          => "%%order_class%% .df_scroll_image_container .df_scroll_image_caption",
            'hover'             => '%%order_class%% .df_scroll_image_container .df_scroll_image_caption:hover'
        ));
        // Badge icon
        if ('on' === $this->props['badge_icon_enable']) {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'badge_icon_color',
                'type'              => 'color',
                'selector'          => "%%order_class%% .df_scroll_image_badge .et-pb-icon",
                'hover'             => '%%order_class%% .df_scroll_image_badge:hover .et-pb-icon'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'badge_icon_size',
                'type'              => 'font-size',
                'selector'          => "%%order_class%% .df_scroll_image_badge .badge_icon.et-pb-icon"
            ));
        }
        // Link Icon
        if ('on' === $this->props['enable_icon'] && 'off' === $this->props['use_image_as_icon']) {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'link_icon_color',
                'type'              => 'color',
                'selector'          => "%%order_class%% .et-pb-icon.df-sl-link-icon",
                'hover'             => '%%order_class%% .df_link_area:hover .et-pb-icon.df-sl-link-icon'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_size',
                'type'              => 'font-size',
                'selector'          => "%%order_class%% .et-pb-icon.df-sl-link-icon",
                'hover'             => '%%order_class%% .df_link_area:hover .et-pb-icon.df-sl-link-icon'
            ));
       
        }

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'link_icon_background',
            'selector'          => "%%order_class%% .df_link_icon",
            'hover'             => '%%order_class%% .df_link_icon:hover'
        ));

        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'link_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-sl-link-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon'
                    )
                )
            );

            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'badge_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.badge_icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon'
                    )
                )
            );
            
        }

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_padding',
            'type'              => 'padding',
            'selector'          => "%%order_class%% .df_scroll_image_badge",
            'hover'             => "%%order_class%% .df_scroll_image_badge:hover",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_margin',
            'type'              => 'margin',
            'selector'          => "%%order_class%% .df_scroll_image_badge",
            'hover'             => "%%order_class%% .df_scroll_image_badge:hover",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_icon_margin',
            'type'              => 'margin',
            'selector'          => "%%order_class%% .df_scroll_image_badge .badge_icon",
            'hover'             => "%%order_class%% .df_scroll_image_badge .badge_icon:hover",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'caption_padding',
            'type'              => 'padding',
            'selector'          => "%%order_class%% .df_scroll_image_container .df_scroll_image_caption",
            'hover'             => "%%order_class%% .df_scroll_image_container .df_scroll_image_caption:hover",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'caption_margin',
            'type'              => 'margin',
            'selector'          => "%%order_class%% .df_scroll_image_container .df_scroll_image_caption",
            'hover'             => "%%order_class%% .df_scroll_image_container .df_scroll_image_caption:hover",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'link_icon_padding',
            'type'              => 'padding',
            'selector'          => "%%order_class%% .df_scroll_image_container .df_link_icon",
            'hover'             => "%%order_class%% .df_scroll_image_container .df_link_icon:hover",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'link_icon_margin',
            'type'              => 'margin',
            'selector'          => "%%order_class%% .df_scroll_image_container .df_link_area",
            'hover'             => "%%order_class%% .df_scroll_image_container .df_link_area:hover",
            'important'         => false
        ));
       
        // Element (Badge, Link) Position
        $tanslate_values = array(
            'top_left' => 'top: 0px !important; left: 0 !important; transform: none !important;',
            'top_center' => 'top: 0px !important; left: 50% !important; transform: translateX(-50%) !important;',
            'top_right' => 'top:0px !important; right: 0 !important; transform: translate(0%) !important;',   
            'center_left' => 'left: 0px !important; top: 50% !important; transform: translateY(-50%) !important;',
            'center_center' => 'left: 50% !important; top:50% !important; transform: translate(-50%, -50%) !important;',
            'center_right' => 'right: 0 !important; top: 50% !important; transform: translate(0%, -50%) !important;',
            'bottom_left' => 'left:0px !important; top: 100% !important; transform: translateY(-100%) !important;',
            'bottom_center' => 'left: 50% !important; top:100% !important; transform: translate(-50% ,-100%) !important',
            'bottom_right' => 'right: 0 !important; top: 100% !important; transform: translate(0% ,-100%) !important;'
        );
        $link_position = $this->props['link_position'] !== '' ? 
            $this->props['link_position'] : 'center_center';
        
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df_link_area',
            'declaration' => $tanslate_values[$link_position]
        ));

        $badge_position = $this->props['badge_position'] !== '' ? 
            $this->props['badge_position'] : 'top_center';
        $badge_center_list = array("top_center", "center_center", "bottom_center");
        if ('on' === $this->props['enable_badge'] && in_array($badge_position, $badge_center_list) ) {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'badge_container_width',
                'type'              => 'width',
                'selector'          => '%%order_class%% .df_scroll_image_badge'
            ));
        }
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df_scroll_image_badge',
            'declaration' => $tanslate_values[$badge_position]
        ));

        if($this->props['overlay'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-overlay',
                'declaration' => sprintf('background-image: linear-gradient(%4$s, %1$s 0, %2$s %3$s);',
                    $this->props['overlay_primary'],
                    $this->props['overlay_secondary'],
                    '100%',
                    $this->props['overlay_direction']
                )
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-overlay',
                'declaration' => sprintf('background-image: linear-gradient(%4$s, %1$s 0, %2$s %3$s);',
                                    $this->props['overlay_primary'],
                                    $this->props['overlay_secondary'],
                                    '100%',
                                    $this->props['overlay_direction_tablet']
                                ),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-overlay',
                'declaration' => sprintf('background-image: linear-gradient(%4$s, %1$s 0, %2$s %3$s);',
                                    $this->props['overlay_primary'],
                                    $this->props['overlay_secondary'],
                                    '100%',
                                    $this->props['overlay_direction_phone']
                                ),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
    }

    /**
     * Get transform values
     * 
     * @param String $key
     * @param String | State
     */
    public function df_transform_values($key = 'bottom', $state = 'default') {
        $transform_values = array (
            'top'           => [
                'default'   => 'translateY(0px)',
                'hover'     => 'translateY(-60px)'
            ],
            'bottom'        => [
                'default'   => 'translateY(0px)',
                'hover'     => 'translateY(60px)'
            ],
            'left'          => [
                'default'   => 'translateX(0px)',
                'hover'     => 'translateX(-60px)'
            ],
            'right'         => [
                'default'   => 'translateX(0px)',
                'hover'     => 'translateX(60px)'
            ],
            'center'        => [
                'default'   => 'scale(1)',
                'hover'     => 'scale(0)'
            ],
            'top_right'     => [
                'default'   => 'translateX(0px) translateY(0px)',
                'hover'     => 'translateX(50px) translateY(-50px)'
            ],
            'top_left'      => [
                'default'   => 'translateX(0px) translateY(0px)',
                'hover'     => 'translateX(-50px) translateY(-50px)'
            ],
            'bottom_right'  => [
                'default'   => 'translateX(0px) translateY(0px)',
                'hover'     => 'translateX(50px) translateY(50px)'
            ],
            'bottom_left'   => [
                'default'   => 'translateX(0px) translateY(0px)',
                'hover'     => 'translateX(-50px) translateY(50px)'
            ]
        );
        return $transform_values[$key][$state];
    }

    /**
     * Render Icon/Image HTML markup
     * 
     * @return String HTML markup of the Icon/Image
     */

    public function df_render_image_icon()
    {
        if (isset($this->props['enable_icon']) && $this->props['enable_icon'] === 'on' && $this->props['use_image_as_icon'] === 'off') {

            return sprintf(
                '<span class="et-pb-icon df-sl-link-icon">%1$s</span>',
                isset($this->props['link_icon']) && $this->props['link_icon'] !== '' ?
                    esc_attr(et_pb_process_font_icon($this->props['link_icon'])) : '5'
            );
        } else if (isset($this->props['image']) && $this->props['image'] !== '') {
            
            $src = 'src';
            $image_alt = $this->props['alt_text'] !== '' ? $this->props['alt_text']  : df_image_alt_by_url($this->props['image']);
            $image_url = $this->props['image'];    
           
            return sprintf(
                '<img class="df_sm_image_icon" %3$s="%1$s" alt="%2$s" />',
                $this->props['image'],
                $image_alt,
                $src
            );
        }
    }

    public function df_render_badge_icon()
    {
        if (isset($this->props['badge_icon_enable']) && $this->props['badge_icon_enable'] === 'on') {

            return sprintf(
                '<span class="et-pb-icon badge_icon">%1$s</span>',
                isset($this->props['badge_icon']) && $this->props['badge_icon'] !== '' ?
                    esc_attr(et_pb_process_font_icon($this->props['badge_icon'])) : '5'
            );
        } 
    }

    /**
     * Render HTML markup
     * 
     * @param Null
     * @param String | HTML markup
     */

    public function render( $attrs, $content, $render_slug ) {
		$this->handle_fa_icon();
        wp_enqueue_script('lightgallery-script');
        wp_enqueue_script('df-scroll-image');
        $this->additional_css_styles($render_slug);
        
        $scroll_image = isset($this->props['scroll_image']) && $this->props['scroll_image'] !== ''  ? $this->props['scroll_image'] : 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA4MCIgaGVpZ2h0PSI1NDAiIHZpZXdCb3g9IjAgMCAxMDgwIDU0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPHBhdGggZmlsbD0iI0VCRUJFQiIgZD0iTTAgMGgxMDgwdjU0MEgweiIvPgogICAgICAgIDxwYXRoIGQ9Ik00NDUuNjQ5IDU0MGgtOTguOTk1TDE0NC42NDkgMzM3Ljk5NSAwIDQ4Mi42NDR2LTk4Ljk5NWwxMTYuMzY1LTExNi4zNjVjMTUuNjItMTUuNjIgNDAuOTQ3LTE1LjYyIDU2LjU2OCAwTDQ0NS42NSA1NDB6IiBmaWxsLW9wYWNpdHk9Ii4xIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgICAgICA8Y2lyY2xlIGZpbGwtb3BhY2l0eT0iLjA1IiBmaWxsPSIjMDAwIiBjeD0iMzMxIiBjeT0iMTQ4IiByPSI3MCIvPgogICAgICAgIDxwYXRoIGQ9Ik0xMDgwIDM3OXYxMTMuMTM3TDcyOC4xNjIgMTQwLjMgMzI4LjQ2MiA1NDBIMjE1LjMyNEw2OTkuODc4IDU1LjQ0NmMxNS42Mi0xNS42MiA0MC45NDgtMTUuNjIgNTYuNTY4IDBMMTA4MCAzNzl6IiBmaWxsLW9wYWNpdHk9Ii4yIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgIDwvZz4KPC9zdmc+Cg=='; 
        $image_scroll_type = isset($this->props['image_scroll_type']) ? $this->props['image_scroll_type'] : "top_bottom";

        $caption_text = $this->props['enable_caption'] === 'on' && isset($this->props['caption_text']) && $this->props['caption_text'] !=='' ? 
       
       
            sprintf('<figcaption class="df_scroll_image_caption df_caption_text">
                        %1$s
                    </figcaption>',
                    preg_replace("/<p[^>]*>(?:\s|&nbsp;)*<\/p>/", '', $this->props['caption_text'])
                    ) : ''; 

        $badge_position = isset($this->props['badge_position']) ? $this->props['badge_position'] : "top_right"; 
        $badge_icon_placement = $this->props['badge_icon_placement'];
        $badge_text = $this->props['enable_badge'] === 'on' && isset($this->props['badge_text']) && $this->props['badge_text'] !=='' ? 
            sprintf('<div class="df_scroll_image_badge df_position_%2$s %5$s %6$s">
                        %4$s            
                        <span class="df_badge">%1$s</span>
                        %3$s
                    </div>',
                    wp_kses_post($this->props['badge_text']),
                    $badge_position,
                    $badge_icon_placement !== 'left' ? $this->df_render_badge_icon() : '',
                    $badge_icon_placement === 'left' ? $this->df_render_badge_icon() : '',
                    $this->props['show_badge_on_hover'] === 'on' ? 'show_badge_on_hover' : '',
                    $this->props['hide_badge_on_hover'] === 'on' ? 'hide_badge_on_hover' : ''
                    )
                    : ''; 

        $link_position = isset($this->props['link_position']) ? $this->props['link_position'] : "top_right"; 
       
        $link_url = $this->props['enable_custom_link'] === 'on' && isset($this->props['link_url']) && $this->props['link_url'] !== '' ? $this->props['link_url'] : ""; 
       
        $lightbox_image_link = $this->props['use_light_box'] === 'on' && $this->props['use_different_lightbox_image'] === 'on' && isset( $this->props['different_lightbox_image'] )  ?
                                $this->props['different_lightbox_image']
                                :
                                $scroll_image;
        
     
        $custom_url = $this->props['use_light_box'] === 'off'  && $link_url !=='' ? 
            sprintf('data-url="%1$s"',$link_url) 
            : '';  
        
        $link_main = 'on' === $this->props['use_image_as_icon'] && $this->props['image'] === '' ? 

                ''
                :
                sprintf('<div class="df_link_area df_position_small df_position_%2$s %3$s%4$s%5$s">
                    <span class="df_link_icon df_scroll_image_lightbox_item">
                        %1$s
                    </span>
                </div>',
                $this->df_render_image_icon(),
                $link_position,
                $this->props['show_on_hover'] === 'on' ? 'show_on_hover' : '',
                $this->props['hide_on_hover'] === 'on' ? 'hide_on_hover' : '',
                $this->props['icon_motion'] === 'on' ? ( $image_scroll_type === 'top_bottom' || $image_scroll_type === 'bottom_top' || $image_scroll_type === 'off') ? ' vertical_motion' : 'horizontal_motion' : ''
            );

        $link_html = isset($this->props['enable_icon']) && $this->props['enable_icon'] === 'on' ?
                    sprintf(' %1$s ',
                        $link_main
                    )
                    :
                    '';

        $main_image = sprintf('%3$s %4$s<div class="df_scroll_image df_scroll_image_%2$s" style="background-image: url(%1$s);"></div> 
                        ',
                        $scroll_image,
                        $image_scroll_type,
                        $this->props['overlay'] === 'on' ? '<span class="df-overlay"></span>' : '',
                        $link_html,
                        $lightbox_image_link
                );
 
        $frame_type = isset($this->props['frame_type']) ? $this->props['frame_type'] : 'desktop';

        $frame_url = DIFL_PUBLIC_DIR. 'img/devices/'. $frame_type. '.svg';
        $frame_html = sprintf('<img class="frame_image" src="%1$s" alt="%2$s">' , $frame_url, $frame_type );
         
        $image_html = $this->props['enable_frame'] === 'on' ? 
            sprintf('<div class="df_device_slider_device">
                        %1$s
                        <div class="df_responsive_width scroll_image_section">
                            %2$s
                        </div>
                    </div>
                    ',
                    $frame_html,
                    $main_image
                    ) 

                    : $main_image; 
     
        $data = [
            'use_light_box' => isset($this->props['use_light_box']) ? $this->props['use_light_box'] : 'off',
            'link_url' => $this->props['use_light_box'] === 'off' && isset($this->props['link_url']) && $this->props['link_url'] !== '' ?  $this->props['link_url'] : '',
            'link_url_target' => isset($this->props['link_url_target']) ? $this->props['link_url_target'] : 'same_window',
            'frame' => isset($this->props['enable_frame']) ? $this->props['enable_frame'] : 'off',
            'frame_type' => isset($this->props['frame_type']) ? $this->props['frame_type'] : 'desktop'
        ];
        $frame_class = $this->props['enable_frame'] === 'on' ? 
            sprintf('df_device_slider df_device_slider_%1$s', $frame_type) : '';
        $link_lightbox_class = $this->props['use_light_box'] === 'on' || $this->props['enable_custom_link'] === 'on' ? ' link_lightbox' : '';

        return sprintf('<div class="df_scroll_image_container" data-settings=\'%4$s\'>
                            <div class="df_scroll_image_wrapper%9$s" data-src="%8$s">
                                <div class="df_scroll_image_holder %5$s" %7$s>
                                        %1$s   
                                        %2$s                               
                                </div> 
                                %3$s
                                %6$s  
                            </div>     
                        </div>' ,
                        $image_html,
                        $this->props['enable_frame'] === 'on' ? $caption_text : '',
                        $badge_text,
                        wp_json_encode($data),
                        $frame_class,
                        $this->props['enable_frame'] !== 'on' ? $caption_text : '',
                        $custom_url,
                        $lightbox_image_link,
                        $link_lightbox_class
                    );
    }
}
new DIFL_ScrollImage;