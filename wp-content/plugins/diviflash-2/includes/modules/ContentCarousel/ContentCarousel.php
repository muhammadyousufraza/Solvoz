<?php

class DIFL_ContentCarousel extends ET_Builder_Module
{
    public $slug       = 'difl_contentcarousel';
    public $vb_support = 'on';
    public $child_slug = 'difl_contentcarouselitem';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'DiviFlash',
        'author_uri' => '',
    );

    public function init()
    {
        $this->name = esc_html__('Advanced Carousel', 'divi_flash');
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/content-carousel.svg';
    }

    public function get_settings_modal_toggles()
    {
        $heading_sub_toggles = [
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
        ];

        $content_sub_toggles = [
            'p' => array(
                'name' => 'P',
                'icon' => 'text-left',
            ),
            'a' => array(
                'name' => 'A',
                'icon' => 'text-link',
            ),
            'ul' => array(
                'name' => 'UL',
                'icon' => 'list',
            ),
            'ol' => array(
                'name' => 'OL',
                'icon' => 'numbered-list',
            ),
            'quote' => array(
                'name' => 'QUOTE',
                'icon' => 'text-quote',
            ),
        ];

        return array(
            'general'   => array(
                'toggles'      => array(
                    'carousel_settings' => esc_html__('Carousel Settings', 'divi_flash'),
                    'advanced_settings' => esc_html__('Advanced Settings', 'divi_flash'),
                    'item_order'    => esc_html__('Item Order', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'title' => esc_html__('Title', 'divi_flash'),
                    'sub_title' => esc_html__('Sub Title', 'divi_flash'),
                    'df_content_style' => esc_html__('Content Style', 'divi_flash'),
                    'df_content_heading'   => array(
                        'title'             => esc_html__('Content Heading Text', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => $heading_sub_toggles,
                    ),
                    'df_content_inherit'   => array(
                        'title'             => esc_html__('Content', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => $content_sub_toggles,
                    ),
                    'df_button' => esc_html__('Button', 'divi_flash'),
                    'arrows' => esc_html__('Arrows', 'divi_flash'),
                    'dots' => esc_html__('Dots', 'divi_flash'),
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

    public function get_advanced_fields_config()
    {
        $advanced_fields = array();
        $advanced_fields['text'] = false;
        $advanced_fields['filters'] = false;
        $advanced_fields['transform'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['fonts'] = array(
            'cc_title'     => array(
                'label'         => esc_html__('Title', 'divi_flash'),
                'toggle_slug'   => 'title',
                'tab_slug'        => 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '24px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_cc_title",
                    'hover' => "%%order_class%% .df_cci_container:hover .df_cc_title",
                    // 'important'    => 'all'
                ),
            ),
            'cc_subtitle'     => array(
                'label'         => esc_html__('Sub Title', 'divi_flash'),
                'toggle_slug'   => 'sub_title',
                'tab_slug'        => 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '20px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_cc_subtitle",
                    'hover' => "%%order_class%% .df_cci_container:hover .df_cc_subtitle",
                    // 'important'    => 'all'
                ),
            ),
            'cc_content'     => array(
                'label'         => esc_html__('Content', 'divi_flash'),
                'toggle_slug'   => 'df_content', // this toggle not exit now. but data is still available.
                'tab_slug'        => 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_cc_content",
                    'hover' => "%%order_class%% .df_cci_container:hover .df_cc_content",
                ),
            ),

            // This field inherited from 'cc_content' by this 'maybe_inherit_values' method
            'df_content_inherit' => array(
                'toggle_slug'       => 'df_content_inherit',
                'tab_slug'          => 'advanced',
                'hide_text_shadow'  => true,
                'css'=> array(
                    'main'  => "%%order_class%% .df_cc_content",
                    'hover' => "%%order_class%% .df_cci_container:hover .df_cc_content",
                ),
                'block_elements' => array(
                    'tabbed_subtoggles' => true,
                    'bb_icons_support'  => true,
                    'css'               => array(
						'main'  => '%%order_class%% .df_cc_content',
						'hover' => '%%order_class%% .df_cci_container:hover .df_cc_content',
					),
                ),
            ),
            'button'     => array(
                'label'         => esc_html__('Button', 'divi_flash'),
                'toggle_slug'   => 'df_button',
                'tab_slug'        => 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "{$this->main_css_element} .df_cci_button",
                    'hover' => "{$this->main_css_element} .df_cci_button:hover",
                    // 'important'    => 'all'
                ),
            )
        );

        // Content Heading text
        $advanced_fields['fonts']['content_heading_1']  = array(
            'label'       => esc_html__('Heading 1', 'divi_flash'),
            'font_size'   => array(
                'default' => absint(et_get_option('body_header_size', '30')) . 'px',
            ),
            'font_weight' => array(
                'default' => '500',
            ),
            'line_height' => array(
                'default' => '1.7',
            ),
            'css'         => array(
                'main'    => "%%order_class%% .df_cc_content h1",
                'hover'   => "%%order_class%% .df_cci_container:hover .df_cc_content h1",
            ),
            'toggle_slug' => 'df_content_heading',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'h1'
        );
        $advanced_fields['fonts']['content_heading_2']  = array(
            'label'       => esc_html__('Heading 2', 'divi_flash'),
            'font_size'   => array(
                'default' => '26px',
            ),
            'font_weight' => array(
                'default' => '500',
            ),
            'line_height' => array(
                'default' => '1.7',
            ),
            'css'         => array(
                'main'    => "%%order_class%% .df_cc_content h2",
                'hover'   => "%%order_class%% .df_cci_container:hover .df_cc_content h2",
            ),
            'tab_slug'    => 'advanced',
            'toggle_slug' => 'df_content_heading',
            'sub_toggle'  => 'h2'
        );
        $advanced_fields['fonts']['content_heading_3']  = array(
            'label'       => esc_html__('Heading 3', 'divi_flash'),
            'font_size'   => array(
                'default' => '22px',
            ),
            'font_weight' => array(
                'default' => '500',
            ),
            'line_height' => array(
                'default' => '1.7',
            ),
            'css'         => array(
                'main'    => "%%order_class%% .df_cc_content h3",
                'hover'   => "%%order_class%% .df_cci_container:hover .df_cc_content h3",
            ),
            'toggle_slug' => 'df_content_heading',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'h3'
        );
        $advanced_fields['fonts']['content_heading_4']  = array(
            'label'       => esc_html__('Heading 4', 'divi_flash'),
            'font_size'   => array(
                'default' => '18px',
            ),
            'font_weight' => array(
                'default' => '500',
            ),
            'line_height' => array(
                'default' => '1.7',
            ),
            'css'         => array(
                'main'    => "%%order_class%% .df_cc_content h4",
                'hover'   => "%%order_class%% .df_cci_container:hover .df_cc_content h4",
            ),
            'toggle_slug' => 'df_content_heading',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'h4'
        );
        $advanced_fields['fonts']['content_heading_5']  = array(
            'label'       => esc_html__('Heading 5', 'divi_flash'),
            'font_size'   => array(
                'default' => '16px',
            ),
            'font_weight' => array(
                'default' => '500',
            ),
            'line_height' => array(
                'default' => '1.7',
            ),
            'css'         => array(
                'main'    => "%%order_class%% .df_cc_content h5",
                'hover'   => "%%order_class%% .df_cci_container:hover .df_cc_content h5",
            ),
            'toggle_slug' => 'df_content_heading',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'h5'
        );
        $advanced_fields['fonts']['content_heading_6']  = array(
            'label'       => esc_html__('Heading 6', 'divi_flash'),
            'font_size'   => array(
                'default' => '14px',
            ),
            'font_weight' => array(
                'default' => '500',
            ),
            'line_height' => array(
                'default' => '1.7',
            ),
            'css'         => array(
                'main'    => "%%order_class%% .df_cc_content h6",
                'hover'   => "%%order_class%% .df_cci_container:hover .df_cc_content h6",
            ),
            'toggle_slug' => 'df_content_heading',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'h6'
        );

        $advanced_fields['borders'] = array(
            'default'   => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .difl_contentcarouselitem > div:first-child",
                        'border_radii_hover'  => "{$this->main_css_element} .difl_contentcarouselitem > div:first-child:hover",
                        'border_styles' => "{$this->main_css_element} .difl_contentcarouselitem > div:first-child",
                        'border_styles_hover' => "{$this->main_css_element} .difl_contentcarouselitem > div:first-child:hover",
                    )
                )
            ),
            'arrow_icon_wrapper_border' => array(
                'css'      => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .df_cc_arrows div",
                        'border_radii_hover'  => "{$this->main_css_element} .df_cc_arrows div:hover",
                        'border_styles' => "{$this->main_css_element} .df_cc_arrows div",
                        'border_styles_hover' => "{$this->main_css_element} .df_cc_arrows div:hover",
                    )
                ),
                'toggle_slug'    => 'arrows',
                'tab_slug'       => 'advanced',
                'depends_on'      => array('arrow_circle'),
                'depends_show_if' => 'off',
            ),
            'button'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .df_cci_button",
                        'border_radii_hover'  => "{$this->main_css_element} .df_cci_button:hover",
                        'border_styles' => "{$this->main_css_element} .df_cci_button",
                        'border_styles_hover' => "{$this->main_css_element} .df_cci_button:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'df_button'
            ),
        );
        $advanced_fields['box_shadow'] = array(
            'default'   => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .difl_contentcarouselitem > div:first-child",
                    'hover' => "{$this->main_css_element} .difl_contentcarouselitem > div:first-child:hover"
                )
            ),
            'arrow_icon_wrapper_box_shadow' => array(
                'css' => array(
                    'main'  => "{$this->main_css_element} .df_cc_arrows div",
                    'hover' => "{$this->main_css_element} .df_cc_arrows div:hover",
                ),
                'toggle_slug' => 'arrows',
                'tab_slug'    => 'advanced',
                'depends_on'      => array('arrow_circle'),
                'depends_show_if' => 'off'
            ),
            'button'              => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_cci_button",
                    'hover' => "{$this->main_css_element} .df_cci_button:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'df_button'
            )
        );
        $advanced_fields['background'] = array(
            'css' => array(
                'main' => "{$this->main_css_element} .difl_contentcarouselitem > div:first-child",
                'hover' => "{$this->main_css_element} .difl_contentcarouselitem:hover > div:first-child"
            )
        );

        return $advanced_fields;
    }

    public function maybe_inherit_values() {
        foreach ( $this->props as $key => $value ) {
            if ( strpos( $key, 'cc_content' ) !== false ) {
                $inherit_key = str_replace( 'cc_content', 'df_content_inherit', $key );

                if ( isset( $this->props[ $inherit_key ] ) && ! empty( $this->props[ $inherit_key ] ) ) {
                    return;
                }

                $this->props[ $inherit_key ] = $value;

            }
          }
     }

    public function get_fields()
    {
        $carousel_settings = array(
            'carousel_type'   => array(
                'label'             => esc_html__('Carousel Type', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'slide'         => esc_html__('Slide', 'divi_flash'),
                    'coverflow'     => esc_html__('Coverflow', 'divi_flash')
                ),
                'default'           => 'slide',
                'toggle_slug'       => 'carousel_settings'
            ),
            'item_desktop'    => array(
                'label'             => esc_html__('Max Slide Desktop', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'default'           => '3',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '7',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if_not'       => array(
                    'variable_width' => 'on',
                    'carousel_type'  => array('cube', 'flip')
                )
            ),
            'item_tablet'    => array(
                'label'             => esc_html__('Max Slide Tablet', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'default'           => '2',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '7',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if_not'       => array(
                    'variable_width' => 'on',
                    'carousel_type'  => array('cube', 'flip')
                )
            ),
            'item_mobile'    => array(
                'label'             => esc_html__('Max Slide Mobile', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'default'           => '1',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '7',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if_not'       => array(
                    'variable_width' => 'on',
                    'carousel_type'  => array('cube', 'flip')
                )
            ),
            'item_spacing'    => array(
                'label'             => esc_html__('Spacing (px)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'default'           => '30px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '200',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if_not'       => array(
                    'carousel_type'  => array('cube', 'flip')
                )
            ),
            'speed'    => array(
                'label'             => esc_html__('Speed (ms)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'default'           => '500',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '100',
                    'max'  => '30000',
                    'step' => '50',
                ),
                'validate_unit'     => false
            ),
            'centered_slides'    => array(
                'label'             => esc_html__('Centered Slides', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if_not'       => array(
                    'carousel_type'  => array('cube', 'flip')
                )
            ),
            'loop'    => array(
                'label'             => esc_html__('Loop', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings'
            ),
            'autoplay'    => array(
                'label'             => esc_html__('Autoplay', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'mobile_options'    => true,
                'affects'           => [
                    'autospeed',
                    'pause_hover'
                ]
            ),
            'autospeed'    => array(
                'label'             => esc_html__('Autoplay Speed (ms)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'default'           => '2000',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '100',
                    'max'  => '10000',
                    'step' => '50',
                ),
                'mobile_options'    => true,
                'validate_unit'     => false,
                'depends_show_if'   => 'on'
            ),
            'pause_hover'    => array(
                'label'             => esc_html__('Pause On Hover', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'mobile_options'    => true,
                'toggle_slug'       => 'carousel_settings',
                'depends_show_if'   => 'on'
            ),
            'arrow'    => array(
                'label'             => esc_html__('Arrow Navigation', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings'
            ),
            'dots'    => array(
                'label'             => esc_html__('Dot Navigation', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if_not'       => array(
                    'carousel_type'  => array('cube', 'flip')
                )
            ),
            'equal_height'    => array(
                'label'             => esc_html__('Equal Height Item', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings'
            ),
            'use_lightbox'    => array (
                'label'             => esc_html__('Use Lightbox', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings'
            ),
            'use_lightbox_title'    => array (
                'label'             => esc_html__('Show Title on Lightbox', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if'           => array(
                    'use_lightbox' => 'on'
                )
            )
        );

        $coverflow_effect = array(
            'coverflow_shadow'    => array(
                'label'             => esc_html__('Enables slides shadows', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'advanced_settings',
                'show_if'           => array(
                    'carousel_type'  => 'coverflow'
                )
            ),
            'coveflow_color_dark' => array(
                'label'             => esc_html__('Shadow color dark', 'divi_flash'),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'advanced_settings',
                'tab_slug'          => 'general',
                'show_if'           => array(
                    'carousel_type'  => 'coverflow',
                    'coverflow_shadow' => 'on'
                ),
                'default'           => 'rgba(0,0,0,1)'
            ),
            'coveflow_color_light' => array(
                'label'             => esc_html__('Shadow color light', 'divi_flash'),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'advanced_settings',
                'tab_slug'          => 'general',
                'show_if'           => array(
                    'carousel_type'  => 'coverflow',
                    'coverflow_shadow' => 'on'
                ),
                'default'           => 'rgba(0,0,0,0)'
            ),
            'coverflow_rotate'    => array(
                'label'             => esc_html__('Slide rotate in degrees', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'advanced_settings',
                'default'           => '30',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'carousel_type'  => 'coverflow'
                )
            ),
            'coverflow_stretch'    => array(
                'label'             => esc_html__('Stretch space between slides (in px)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'advanced_settings',
                'default'           => '0',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'carousel_type'  => 'coverflow'
                )
            ),
            'coverflow_depth'    => array(
                'label'             => esc_html__('StreDepth offset in px (slides translate in Z axis)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'advanced_settings',
                'default'           => '100',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'carousel_type'  => 'coverflow'
                )
            ),
            'coverflow_modifier'    => array(
                'label'             => esc_html__('Effect multipler', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'advanced_settings',
                'default'           => '1',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '8',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'carousel_type'  => 'coverflow'
                )
            )
        );

        $item_order = array(
            'image_order' => array(
                'label'             => esc_html__('Image Order', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'item_order',
                'default'           => '9',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'description'       => esc_html__('Increase the order number to position the item lower.', 'divi_flash')
            ),
            'title_order' => array(
                'label'             => esc_html__('Title Order', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'item_order',
                'default'           => '9',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'description'       => esc_html__('Increase the order number to position the item lower.', 'divi_flash')
            ),
            'subtitle_order' => array(
                'label'             => esc_html__('Sub Title Order', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'item_order',
                'default'           => '9',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'description'       => esc_html__('Increase the order number to position the item lower.', 'divi_flash')
            ),
            'content_order' => array(
                'label'             => esc_html__('Content Order', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'item_order',
                'default'           => '9',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'description'       => esc_html__('Increase the order number to position the item lower.', 'divi_flash')
            ),
            'button_order' => array(
                'label'             => esc_html__('Button Order', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'item_order',
                'default'           => '9',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'description'       => esc_html__('Increase the order number to position the item lower.', 'divi_flash')
            )
        );
        $title_bg = $this->df_add_bg_field(array(
            'label'                    => 'Background',
            'key'                   => 'df_title_bg',
            'toggle_slug'           => 'title',
            'tab_slug'              => 'advanced'
        ));
        $subtitle_bg = $this->df_add_bg_field(array(
            'label'                    => 'Background',
            'key'                   => 'df_subtitle_bg',
            'toggle_slug'           => 'sub_title',
            'tab_slug'              => 'advanced'
        ));
        $content_bg = $this->df_add_bg_field(array(
            'label'                    => 'Background',
            'key'                   => 'df_content_bg',
            'toggle_slug'           => 'df_content_style',
            'tab_slug'              => 'advanced'
        ));

        $arrows = array(
            'arrow_color' => array(
                'default'           => "#007aff",
                'label'             => esc_html__('Arrow icon color', 'divi_flash'),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
                'hover'             => 'tabs'
            ),
            'arrow_background' => array(
                'default'           => "#ffffff",
                'label'             => esc_html__('Arrow background', 'divi_flash'),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
                'hover'             => 'tabs'
            ),
            'arrow_position'    => array(
                'default'         => 'middle',
                'label'           => esc_html__('Arrow Position', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'top'           => esc_html__('Top', 'divi_flash'),
                    'middle'        => esc_html__('Middle', 'divi_flash'),
                    'bottom'        => esc_html__('Bottom', 'divi_flash')
                ),
                'mobile_options'    => true,
                'toggle_slug'     => 'arrows',
                'tab_slug'        => 'advanced'
            ),
            'arrow_align'    => array(
                'default'         => 'space-between',
                'label'           => esc_html__('Arrow Alignment', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'flex-start'            => esc_html__('Left', 'divi_flash'),
                    'center'                => esc_html__('Center', 'divi_flash'),
                    'flex-end'              => esc_html__('Right', 'divi_flash'),
                    'space-between'         => esc_html__('Justified', 'divi_flash')
                ),
                'mobile_options'    => true,
                'toggle_slug'     => 'arrows',
                'tab_slug'        => 'advanced'
            ),
            'arrow_opacity'    => array(
                'label'             => esc_html__('Opacity', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'arrows',
                'tab_slug'          => 'advanced',
                'default'           => '1',
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '1',
                    'step' => '.01',
                ),
                'validate_unit'     => false,
                'hover'             => 'tabs'
            ),
            'arrow_opacity_disable'    => array (
                'label'             => esc_html__( 'Disabled Arrow Opacity', 'divi_flash' ),
                'description'       => esc_html__('Here you can define the opacity of the disabled arrow when the total slide ends.', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'arrows',
                'tab_slug'          => 'advanced',
                'default'           => '0.5',
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '1',
                    'step' => '.01',
                ),
                'validate_unit'     => false,
                'hover'             => 'tabs',
                'show_if_not'       => array (
                    'loop'  => 'on'
                )
            ),
            'arrow_circle'    => array(
                'label'             => esc_html__('Circle Arrow', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'arrows',
                'tab_slug'          => 'advanced'
            )
        );
        $arrow_prev_icon = $this->df_add_icon_settings(array(
            'title'                 => 'Arrow prev icon',
            'key'                   => 'arrow_prev_icon',
            'toggle_slug'           => 'arrows',
            'tab_slug'              => 'advanced',
            'default_size'          => '39px',
            'icon_alignment'        => false,
            'image_styles'          => false,
            'circle_icon'           => false,
            'icon_color'            => false,
            'icon_size'             => true,
            'image'                 => false
        ));
        $arrow_next_icon = $this->df_add_icon_settings(array(
            'title'                 => 'Arrow next icon',
            'key'                   => 'arrow_next_icon',
            'toggle_slug'           => 'arrows',
            'tab_slug'              => 'advanced',
            'default_size'          => '39px',
            'icon_alignment'        => false,
            'image_styles'          => false,
            'circle_icon'           => false,
            'icon_color'            => false,
            'icon_size'             => true,
            'image'                 => false
        ));
        $arrow_prev_spacing = $this->add_margin_padding(array(
            'title'         => 'Arrow Previous',
            'key'           => 'arrow_prev',
            'toggle_slug'   => 'arrows'
            // 'option'        => 'margin'
        ));
        $arrow_next_spacing = $this->add_margin_padding(array(
            'title'         => 'Arrow Next',
            'key'           => 'arrow_next',
            'toggle_slug'   => 'arrows'
            // 'option'        => 'margin'
        ));
        $dots = array(
            'dots_color' => array(
                'default'           => "#c7c7c7",
                'label'             => esc_html__('Dots color', 'divi_flash'),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dots',
                'hover'             => 'tabs'
            ),
            'active_dots_color' => array(
                'default'           => "#007aff",
                'label'             => esc_html__('Active dots color', 'divi_flash'),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dots',
                'hover'             => 'tabs'
            ),
            'large_active_dot'    => array(
                'label'             => esc_html__('Large Active Dot', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'dots',
                'tab_slug'          => 'advanced'
            ),
            'dots_align'    => array(
                'label'             => esc_html__('Alignment', 'divi_flash'),
                'type'              => 'text_align',
                'options'           => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'       => 'dots',
                'tab_slug'          => 'advanced'
            ),
            'dot_vertical_position'   => array(
				'label'          => esc_html__( 'Vertical Position', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can define vertical position of dots wrapper.', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'dots',
                'tab_slug'       => 'advanced',
				'default'        => '0px',
				'default_unit'   => 'px',
				'hover'          => 'tabs',
				'mobile_options' => true,
				'range_settings' => array(
					'min'  => '-100',
					'max'  => '100',
					'step' => '1',
				),
			),
        );
        $cc_button_style = $this->df_add_btn_styles(array(
            'key'                   => 'cc_button',
            'toggle_slug'           => 'df_button',
            'full_width'            => true,
            'tab_slug'              => 'advanced'
        ));
        $buttons_bg = $this->df_add_bg_field(array(
            'label'                    => 'Button Background',
            'key'                   => 'df_button_bg',
            'toggle_slug'           => 'df_button',
            'tab_slug'              => 'advanced'
        ));
        $button_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Button Wrapper',
            'key'           => 'button_wrapper',
            'toggle_slug'   => 'df_button'
        ));
        $button_spacing = $this->add_margin_padding(array(
            'title'         => 'Button',
            'key'           => 'button',
            'toggle_slug'   => 'df_button'
        ));

        // spacing
        $wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Carousel Wrapper',
            'key'           => 'wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper',
            'option'        => 'padding'
        ));
        $item_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Item Wrapper',
            'key'           => 'item_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $image_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Image Wrapper',
            'key'           => 'image_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $image_spacing = $this->add_margin_padding(array(
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
            'sub_toggle'    => 'content',
            'default_padding'=> '10px|0px|10px|0px'
        ));
        $subtitle_spacing = $this->add_margin_padding(array(
            'title'         => 'Subtitle',
            'key'           => 'subtitle',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        $content_spacing = $this->add_margin_padding(array(
            'title'         => 'Content',
            'key'           => 'content',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));

        return array_merge(
            $carousel_settings,
            $coverflow_effect,
            $item_order,
            $title_bg,
            $subtitle_bg,
            $content_bg,
            $arrows,
            $arrow_prev_icon,
            $arrow_next_icon,
            $arrow_prev_spacing,
            $arrow_next_spacing,
            $dots,
            $cc_button_style,
            $buttons_bg,
            $button_wrapper_spacing,
            $button_spacing,
            $wrapper_spacing,
            $item_wrapper_spacing,
            $image_wrapper_spacing,
            $image_spacing,
            $title_spacing,
            $subtitle_spacing,
            $content_spacing
        );
    }

    public function get_transition_fields_css_props()
    {
        $fields = parent::get_transition_fields_css_props();

        $button_wrapper = '%%order_class%% .df_cci_button_wrapper';
        $title = '%%order_class%% .df_cc_title';
        $subtitle = '%%order_class%% .df_cc_subtitle';
        $content = '%%order_class%% .df_cc_content';
        $button = '%%order_class%% .df_cci_button';
        $dots = '%%order_class%% .swiper-pagination .swiper-pagination-bullet';
        $arrows = '%%order_class%% .df_cc_arrows > div';
        $arrow_icon = '%%order_class%% .df_cc_arrows > div:after';

        // spacing
        $fields['button_wrapper_margin'] = array('margin' => $button_wrapper);
        $fields['button_wrapper_padding'] = array('padding' => $button_wrapper);
        $fields['button_margin'] = array('margin' => $button);
        $fields['button_padding'] = array('padding' => $button);

        $fields['dots_color'] = array('background' => $dots);
        $fields['active_dots_color'] = array('background' => $dots);

        $fields['arrow_opacity'] = array('opacity' => $arrows);
        $fields['arrow_opacity_disable'] = array('opacity' => '%%order_class%% .df_cptc_arrows div.swiper-button-disabled');
        $fields['arrow_color'] = array('color' => $arrow_icon);
        $fields['arrow_background'] = array('background-color' => $arrows);
        $fields['arrow_prev_margin'] = array('margin' => $arrows);
        $fields['arrow_prev_padding'] = array('padding' => $arrows);
        $fields['arrow_next_margin'] = array('margin' => $arrows);
        $fields['arrow_next_padding'] = array('padding' => $arrows);

        $fields['wrapper_padding'] = array('padding' => '%%order_class%% .swiper-container');

        $fields['item_wrapper_margin'] = array('margin' => '%%order_class%% .difl_contentcarouselitem > div');
        $fields['item_wrapper_padding'] = array('padding' => '%%order_class%% .difl_contentcarouselitem > div');

        $fields['image_wrapper_margin'] = array('margin' => '%%order_class%% .df_cci_image_container');
        $fields['image_wrapper_padding'] = array('padding' => '%%order_class%% .df_cci_image_container');

        $fields['image_margin'] = array('margin' => '%%order_class%% .df_cci_image_container img');

        $fields['title_margin'] = array('margin' => $title);
        $fields['title_padding'] = array('padding' => $title);

        $fields['subtitle_margin'] = array('margin' => $subtitle);
        $fields['subtitle_padding'] = array('padding' => $subtitle);

        $fields['content_margin'] = array('margin' => $content);
        $fields['content_padding'] = array('padding' => $content);

        // background
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'df_button_bg',
            'selector'      => $button
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'df_title_bg',
            'selector'      => $title
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'df_subtitle_bg',
            'selector'      => $subtitle
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'df_content_bg',
            'selector'      => $content
        ));

        // border fix
        $fields = $this->df_fix_border_transition(
            $fields,
            'button',
            $button
        );

        $fields = $this->df_fix_border_transition( $fields, 'arrow_icon_wrapper_border', $arrows);

        //box shadow
        $fields = $this->df_fix_box_shadow_transition($fields, 'arrow_icon_wrapper_box_shadow', $arrows);

        return $fields;
    }

    public function get_custom_css_fields_config()
    {
        return array(
            'carousel_item' => array(
                'label'    => esc_html__('Carousel Item', 'divi_flash'),
                'selector' => '%%order_class%% .difl_contentcarouselitem > div:first-child',
            ),
            'image' => array(
                'label'    => esc_html__('Image', 'divi_flash'),
                'selector' => '%%order_class%% .df_cci_image_container img',
            ),
            'title' => array(
                'label'    => esc_html__('Title', 'divi_flash'),
                'selector' => '%%order_class%% .df_cc_title',
            ),
            'subtitle' => array(
                'label'    => esc_html__('Subtile', 'divi_flash'),
                'selector' => '%%order_class%% .df_cc_subtitle',
            ),
            'content' => array(
                'label'    => esc_html__('Content', 'divi_flash'),
                'selector' => '%%order_class%% .df_cc_content',
            ),
            'button' => array(
                'label'    => esc_html__('Button', 'divi_flash'),
                'selector' => '%%order_class%% .df_cci_button',
            )
        );
    }

    public function additional_css_styles($render_slug)
    {

        // item order
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_order',
            'type'              => 'order',
            'selector'          => '%%order_class%% .df_cci_image_container'
        ));
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_order',
            'type'              => 'order',
            'selector'          => '%%order_class%% .df_cc_title'
        ));
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'subtitle_order',
            'type'              => 'order',
            'selector'          => '%%order_class%% .df_cc_subtitle'
        ));
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_order',
            'type'              => 'order',
            'selector'          => '%%order_class%% .df_cc_content'
        ));
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_order',
            'type'              => 'order',
            'selector'          => '%%order_class%% .df_cci_button_wrapper'
        ));
        // coverflow shadows
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .swiper-container-3d .swiper-slide-shadow-left',
            'declaration' => sprintf(
                'background-image: linear-gradient(to left,%1$s,%2$s);',
                $this->props['coveflow_color_dark'],
                $this->props['coveflow_color_light']
            )
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .swiper-container-3d .swiper-slide-shadow-right',
            'declaration' => sprintf(
                'background-image: linear-gradient(to right,%1$s,%2$s);',
                $this->props['coveflow_color_dark'],
                $this->props['coveflow_color_light']
            )
        ));

        // dots
        if ($this->props['large_active_dot'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination .swiper-pagination-bullet-active',
                'declaration' => 'width: 40px; border-radius: 20px;'
            ));
        }
        if (isset($this->props['dots_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination',
                'declaration' => sprintf('text-align: %1$s;', $this->props['dots_align'])
            ));
        }
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'dot_vertical_position',
            'type'              => 'top',
            'selector'          => '%%order_class%% .swiper-pagination'
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'dots_color',
            'type'              => 'background',
            'selector'          => '%%order_class%% .swiper-pagination span',
            'hover'             => '%%order_class%% .swiper-pagination span:hover'
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'active_dots_color',
            'type'              => 'background',
            'selector'          => '%%order_class%% .swiper-pagination span.swiper-pagination-bullet-active',
            'hover'             => '%%order_class%% .swiper-pagination span.swiper-pagination-bullet-active:hover'
        ));
        // equal height
        if ($this->props['equal_height'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .difl_contentcarouselitem',
                'declaration' => 'align-self: auto;',
            ));
        }
        // arrow
        if ($this->props['arrow'] === 'on') {
            $pos = isset($this->props['arrow_position']) ? $this->props['arrow_position'] : 'middle';
            $pos_tab = isset($this->props['arrow_position_tablet']) && $this->props['arrow_position_tablet'] !== '' ?
                $this->props['arrow_position_tablet'] : $pos;
            $pos_ph = isset($this->props['arrow_position_phone']) && $this->props['arrow_position_phone'] !== '' ?
                $this->props['arrow_position_phone'] : $pos_tab;
            $a_align = isset($this->props['arrow_align']) ? $this->props['arrow_align'] : 'space-between';
            $a_align_tab = isset($this->props['arrow_align_tablet']) ? $this->props['arrow_align_tablet'] : $a_align;
            $a_align_ph = isset($this->props['arrow_align_phone']) ? $this->props['arrow_align_phone'] : $a_align_tab;

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_cc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_cc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_cc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
            // alignment
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_cc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_cc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_cc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
            if ($this->props['arrow_circle'] === 'on') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_cc_arrows > div',
                    'declaration' => 'border-radius: 50%;'
                ));
            }
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_opacity',
                'type'              => 'opacity',
                'selector'          => '%%order_class%% .df_cc_arrows div',
                'hover'             => '%%order_class%%:hover .df_cc_arrows div'
            ));
            if( 'on' !== $this->props['loop'] ){
                $this->df_process_range( array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'arrow_opacity_disable',
                    'type'              => 'opacity',
                    'selector'          => '%%order_class%% .df_cc_arrows div.swiper-button-disabled',
                    'hover'             => '%%order_class%%:hover .df_cc_arrows div.swiper-button-disabled'
                ) );
            }
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df_cc_arrows .swiper-button-prev',
                'hover'             => '%%order_class%%:hover .df_cc_arrows .swiper-button-prev',
                'important'         => false
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df_cc_arrows .swiper-button-prev',
                'hover'             => '%%order_class%%:hover .df_cc_arrows .swiper-button-prev',
                'important'         => false
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df_cc_arrows .swiper-button-next',
                'hover'             => '%%order_class%%:hover .df_cc_arrows .swiper-button-next',
                'important'         => false
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df_cc_arrows .swiper-button-next',
                'hover'             => '%%order_class%%:hover .df_cc_arrows .swiper-button-next',
                'important'         => false
            ));
            // arrow colors
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_color',
                'type'              => 'color',
                'selector'          => '%%order_class%% .df_cc_arrows div:after',
                'hover'             => '%%order_class%%:hover .df_cc_arrows div:after'
            ));
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_background',
                'type'              => 'background-color',
                'selector'          => '%%order_class%% .df_cc_arrows div',
                'hover'             => '%%order_class%%:hover .df_cc_arrows div'
            ));
            // arrow icon styles
            $this->process_icon_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_icon',
                'selector'          => '%%order_class%% .df_cc_arrows div.swiper-button-prev:after'
            ));
            $this->process_icon_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_icon',
                'selector'          => '%%order_class%% .df_cc_arrows div.swiper-button-next:after'
            ));
        }

        // button
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'df_button_bg',
            'selector'          => "{$this->main_css_element} .df_cci_button",
            'hover'             => "{$this->main_css_element} .df_cci_button:hover"
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_wrapper_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_cci_button_wrapper",
            'hover'             => "{$this->main_css_element} .df_cci_button_wrapper:hover",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_wrapper_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_cci_button_wrapper",
            'hover'             => "{$this->main_css_element} .df_cci_button_wrapper:hover",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_cci_button",
            'hover'             => "{$this->main_css_element} .df_cci_button:hover",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_cci_button",
            'hover'             => "{$this->main_css_element} .df_cci_button:hover",
            'important'         => false
        ));
        $this->df_process_btn_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'cc_button',
            'selector'          => "{$this->main_css_element} .df_cci_button",
            'hover'             => "{$this->main_css_element} .df_cci_button:hover",
            'align_container'   => "{$this->main_css_element} .df_cci_button_wrapper"
        ));

        // content area background
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'df_title_bg',
            'selector'          => "{$this->main_css_element} .df_cc_title",
            'hover'             => "{$this->main_css_element} .df_cci_container .df_cc_title:hover"
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'df_subtitle_bg',
            'selector'          => "{$this->main_css_element} .df_cc_subtitle",
            'hover'             => "{$this->main_css_element} .df_cci_container .df_cc_subtitle:hover"
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'df_content_bg',
            'selector'          => "{$this->main_css_element} .df_cc_content",
            'hover'             => "{$this->main_css_element} .df_cci_container .df_cc_content:hover"
        ));
        // spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .swiper-container",
            'hover'             => "{$this->main_css_element}:hover .swiper-container",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .difl_contentcarouselitem .df_cci_container",
            'hover'             => "{$this->main_css_element} .difl_contentcarouselitem:hover .df_cci_container",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .difl_contentcarouselitem .df_cci_container",
            'hover'             => "{$this->main_css_element} .difl_contentcarouselitem:hover .df_cci_container",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_wrapper_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_cci_image_container",
            'hover'             => "{$this->main_css_element} .difl_contentcarouselitem:hover .df_cci_image_container",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_wrapper_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_cci_image_container",
            'hover'             => "{$this->main_css_element} .difl_contentcarouselitem:hover .df_cci_image_container",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_cci_image_container img",
            'hover'             => "{$this->main_css_element} .difl_contentcarouselitem:hover .df_cci_image_container img",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_cc_title",
            'hover'             => "{$this->main_css_element} .difl_contentcarouselitem:hover .df_cc_title",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_cc_title",
            'hover'             => "{$this->main_css_element} .difl_contentcarouselitem:hover .df_cc_title",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'subtitle_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_cc_subtitle",
            'hover'             => "{$this->main_css_element} .difl_contentcarouselitem:hover .df_cc_subtitle",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'subtitle_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_cc_subtitle",
            'hover'             => "{$this->main_css_element} .difl_contentcarouselitem:hover .df_cc_subtitle",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_cc_content",
            'hover'             => "{$this->main_css_element} .difl_contentcarouselitem:hover .df_cc_content",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_cc_content",
            'hover'             => "{$this->main_css_element} .difl_contentcarouselitem:hover .df_cc_content",
            'important'         => false
        ));

        if($this->props['arrow_opacity'] !== '0') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%  .arrow-middle .df_cc_arrows *',
                'declaration' => 'pointer-events: all !important;'
            ));
        }

        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'arrow_prev_icon_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .swiper-button-prev:after',
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
                    'base_attr_name' => 'arrow_next_icon_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .swiper-button-next:after',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }
    }

    public function render($attrs, $content, $render_slug)
    {
        if ( $this->content === '' ) {
            return sprintf(
                '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Item</strong> to continue</h2>'
            );
        }

        if($this->props['use_lightbox'] === 'on') {
            wp_enqueue_script('lightgallery-script');
            $this->add_classname('has_lightbox');
        }
        wp_enqueue_script('swiper-script');
        wp_enqueue_script('df-contentcarousel');
        $this->additional_css_styles($render_slug);

        $order_class     = self::get_module_order_class($render_slug);
        $order_number    = str_replace('_', '', str_replace($this->slug, '', $order_class));
        $class = ''; 
        $data = [
            'effect' => $this->props['carousel_type'],
            'desktop' => $this->props['item_desktop'],
            'tablet' => $this->props['item_tablet'],
            'mobile' => $this->props['item_mobile'],
            'loop' => $this->props['loop'] === 'on' ? true : false,
            'item_spacing' => $this->props['item_spacing'],
            'item_spacing_tablet' => $this->props['item_spacing_tablet'],
            'item_spacing_phone' => $this->props['item_spacing_phone'],
            'arrow' => $this->props['arrow'],
            'dots' => $this->props['dots'],
            'autoplay' => $this->props['autoplay'],
            'autoplay_tablet' => isset($this->props['autoplay_tablet']) && "" !== $this->props['autoplay_tablet'] ? $this->props['autoplay_tablet'] : 'off',
            'autoplay_phone' => isset($this->props['autoplay_phone']) && "" !== $this->props['autoplay_phone'] ? $this->props['autoplay_phone'] : 'off',
            'auto_delay' => $this->props['autospeed'],
            'auto_delay_tablet' => !empty($this->props['autospeed_tablet']) ? $this->props['autospeed_tablet'] : $this->props['autospeed'],
            'auto_delay_phone' => !empty($this->props['autospeed_phone']) ? $this->props['autospeed_phone'] : ($this->props['autospeed_tablet'] ? $this->props['autospeed_tablet'] : $this->props['autospeed']),
            'speed' => $this->props['speed'],
            'pause_hover' => $this->props['pause_hover'],
            'pause_hover_tablet' => isset($this->props['pause_hover_tablet']) && "" !== $this->props['pause_hover_tablet'] ? $this->props['pause_hover_tablet'] : 'off',
            'pause_hover_phone' => isset($this->props['pause_hover_phone']) && "" !== $this->props['pause_hover_phone'] ? $this->props['pause_hover_phone'] : 'off',
            'centeredSlides' => $this->props['centered_slides'],
            'order' => $order_number,
            'use_lightbox' => $this->props['use_lightbox'],
            'use_lightbox_title' => $this->props['use_lightbox_title']
        ];
        if ($this->props['carousel_type'] === 'coverflow') {
            $data['slideShadows'] = $this->props['coverflow_shadow'];
            $data['rotate'] = $this->props['coverflow_rotate'];
            $data['stretch'] = $this->props['coverflow_stretch'];
            $data['depth'] = $this->props['coverflow_depth'];
            $data['modifier'] = $this->props['coverflow_modifier'];
        }

        // arrow position classes
        if($this->props['arrow'] === 'on') {
            $arrow_position = '' !== $this->props['arrow_position'] ? $this->props['arrow_position'] : 'middle';
            $class .= ' arrow-' . $arrow_position;
        }

        return sprintf(
            '<div class="df_cc_container%8$s" data-settings=\'%2$s\' data-item="%5$s" data-itemtablet="%6$s" data-itemphone="%7$s">
                <div class="df_cc_inner_wrapper">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            %1$s
                        </div>
                    </div>
                    %3$s
                </div>
                %4$s
            </div>',
            et_core_sanitized_previously($this->content),
            wp_json_encode($data),
            $this->df_cc_arrow($order_number),
            $this->df_cc_dots($order_number),
            $this->props['item_desktop'],
            $this->props['item_tablet'],
            $this->props['item_mobile'],
            $class
        );
    }

    /**
     * Arrow navigation
     *
     * @param Integer | $order_number
     * @return String | HTML
     */
    public function df_cc_arrow($order_number)
    {
        $prev_icon = $this->props['arrow_prev_icon_use_icon'] === 'on' && isset($this->props['arrow_prev_icon_font_icon']) && !empty($this->props['arrow_prev_icon_font_icon']) ?
            esc_attr(et_pb_process_font_icon($this->props['arrow_prev_icon_font_icon'])) : '4';
        $next_icon = $this->props['arrow_next_icon_use_icon'] === 'on' && isset($this->props['arrow_next_icon_font_icon']) && !empty($this->props['arrow_next_icon_font_icon']) ?
            esc_attr(et_pb_process_font_icon($this->props['arrow_next_icon_font_icon'])) : '5';

        return $this->props['arrow'] === 'on' ? sprintf('
            <div class="df_cc_arrows">
                <div class="swiper-button-next cc-next-%1$s" data-icon="%3$s"></div>
                <div class="swiper-button-prev cc-prev-%1$s" data-icon="%2$s"></div>
            </div>
        ', $order_number, $prev_icon, $next_icon) : '';
    }

    /**
     * Dot pagination
     *
     * @param Integer | $order_number
     * @return String | HTML
     */
    public function df_cc_dots($order_number)
    {
        return $this->props['dots'] === 'on' ?
            sprintf('<div class="swiper-pagination cc-dots-%1$s"></div>', $order_number) : '';
    }

    /**
     * Arrow Position styles
     *
     * @param String | position
     * @return String
     */
    public function df_arrow_pos_styles($value = 'middle')
    {
        $options = array(
            'top' => 'position: relative;
                    top: auto;
                    left: auto;
                    right: auto;
                    transform: translateY(0);
                    order: 0;',
            'middle' => 'position: absolute;
                        top: 50%;
                        left: 0;
                        right: 0;
                        transform: translateY(-50%);',
            'bottom' => 'position: relative;
                    top: auto;
                    left: auto;
                    right: auto;
                    transform: translateY(0);
                    order: 2;',
        );
        return $options[$value];
    }
}
new DIFL_ContentCarousel;
