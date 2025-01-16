<?php

class DIFL_AdvancedBlurb extends ET_Builder_Module
{
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_advanced_blurb';
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
        $this->name = esc_html__('Advanced Blurb', 'divi_flash');
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/advanced-blurb.svg';
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

        return array(
            'general'  => array(
                'toggles' => array(
                    'main_content'           => esc_html__('Content', 'divi_flash'),
                    'button'                 => esc_html__('Button', 'divi_flash'),
                    'image'                  => esc_html__('Image and Icon', 'divi_flash'),
                    'badge'                  => esc_html__('Badge', 'divi_flash'),
                    'item_order'             => esc_html__('Item Order', 'divi_flash'),
                    'title_link'             => esc_html__('Title Link', 'divi_flash')
                ),
            ),
            'advanced'  =>  array(
                'toggles'   =>  array(
                    'design_zindex'          => esc_html__('Z-index ', 'divi_flash'),
                    'design_image'           => esc_html__('Image', 'divi_flash'),
                    'design_icon'            => esc_html__('Icon', 'divi_flash'),
                    'design_content_area'    => esc_html__('Content Area', 'divi_flash'),
                    'design_text'            => esc_html__('Text', 'divi_flash'),
                    'design_title'           => esc_html__('Title', 'divi_flash'),
                    'design_sub_title'       => esc_html__('Sub title', 'divi_flash'),
                    'design_content'         => array(
                        'title' => esc_html__('Content', 'divi_flash'),
                        // Groups can be organized into tab
                        'tabbed_subtoggles' => true,
                        // Subtoggle tab configuration. Add `sub_toggle` attribute on field to put them here
                        'sub_toggles' => array(
                            'body'     => array(
                                'name' => 'P',
                                'icon' => 'text-left',
                            ),
                            'link'     => array(
                                'name' => 'A',
                                'icon' => 'text-link',
                            ),
                            'unorder_list'     => array(
                                'name' => 'A',
                                'icon' => 'list',
                            ),
                            'order_list'     => array(
                                'name' => 'A',
                                'icon' => 'numbered-list',
                            ),
                            'quote' => array(
                                'name' => 'QUOTE',
                                'icon' => 'text-quote',
                            ),
                        ),
                    ),
                    'design_content_bg_and_others' => esc_html__(' Content Style', 'divi_flash'),
                    'design_content_heading' => array(
                        'title' => esc_html__('Content Heading Text', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'  => $heading_sub_toggles,
                    ),
                    'design_badge'           => esc_html__('Badge', 'divi_flash'),
                    'design_badge_text'      => array(
                        'title'              => esc_html__('Badge Font', 'divi_flash'),
                        'tabbed_subtoggles'  => true,
                        'sub_toggles' => array(
                            'badge_text_both' => array(
                                'name' => 'Both'
                            ),
                            'badge_text_1'   => array(
                                'name' => 'Line 1'
                            ),
                            'badge_text_2'     => array(
                                'name' => 'Line 2'
                            )
                        )
                    ),
                    'button'            => esc_html__('Button', 'divi_flash'),
                    'custom_spacing'    => array(
                        'title'             => esc_html__('Custom Spacing', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'wrapper'   => array(
                                'name' => 'Wrapper',
                            ),
                            'content'     => array(
                                'name' => 'Content'
                            )
                        ),
                    )
                )
            ),

            // Advance tab's slug is "custom_css"
            'custom_css' => array(
                'toggles' => array(
                    'limitation' => esc_html__('Limitation', 'divi_flash'), // totally made up
                )
            ),
        );
    }
    public function get_advanced_fields_config()
    {
        $advanced_fields = array();
        $advanced_fields['fonts'] = array(
            'title'   => array(
                'label'         => esc_html__('Title', 'divi_flash'),
                'toggle_slug'   => 'design_title',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '24',
                ),
                'font-weight' => array(
                    'default' => 'bold'
                ),
                'css'      => array(
                    'main' => " %%order_class%% .df_ab_blurb_title ",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_title",
                    'important' => 'all',
                ),
                'header_level' => array(
                    'default' => 'h3',
                ),
            ),
            'sub_title'   => array(
                'label'         => esc_html__('Sub Title', 'divi_flash'),
                'toggle_slug'   => 'design_sub_title',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18',
                ),
                'font-weight' => array(
                    'default' => 'semi-bold'
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ab_blurb_sub_title ",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_sub_title",
                    'important' => 'all',
                ),

                'header_level' => array(
                    'default' => 'h4',
                ),
            ),

            'content_body'   => array(
                'label'         => esc_html__('Body', 'divi_flash'),
                'toggle_slug'   => 'design_content',
                'sub_toggle'  => 'body',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ab_blurb_description",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_description",
                    'important' => 'all',
                ),
            ),

            'content_link'   => array(
                'label'         => esc_html__('Body Link', 'divi_flash'),
                'toggle_slug'   => 'design_content',
                'sub_toggle'  => 'link',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ab_blurb_description a",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_description a",
                    'important' => 'all',
                ),
            ),

            'content_unorder_list'   => array(
                'label'         => esc_html__('Body Unorder List', 'divi_flash'),
                'toggle_slug'   => 'design_content',
                'sub_toggle'  => 'unorder_list',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ab_blurb_description ul li",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_description ul li",
                    'important' => 'all',
                ),
            ),

            'content_order_list'   => array(
                'label'         => esc_html__('Body Order List', 'divi_flash'),
                'toggle_slug'   => 'design_content',
                'sub_toggle'  => 'order_list',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ab_blurb_description ol li",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_description ol li",
                    'important' => 'all',
                ),
            ),

            'content_quote'   => array(
                'label'         => esc_html__('Body Blockquote', 'divi_flash'),
                'toggle_slug'   => 'design_content',
                'sub_toggle'  => 'quote',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ab_blurb_description blockquote",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_description blockquote",
                    'important' => 'all',
                ),
            ),


            'button_text'   => array(
                'label'         => esc_html__('Button', 'divi_flash'),
                'toggle_slug'   => 'button',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ab_blurb_button",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_button",
                    'important' => 'all',
                ),
            ),

            'badge_text'   => array(
                'label'         => esc_html__('Badge Both', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'   => 'design_badge_text',
                'sub_toggle'  => 'badge_text_both',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ab_blurb_badge .badge_text_wrapper",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_badge .badge_text_wrapper",
                    'important' => 'all',
                ),
            ),
            'badge_text_1'   => array(
                'label'         => esc_html__('Badge Line 1', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'   => 'design_badge_text',
                'sub_toggle'  => 'badge_text_1',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ab_blurb_badge .badge_text_1",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_badge .badge_text_1",
                    'important' => 'all',
                ),
            ),

            'badge_text_2'   => array(
                'label'         => esc_html__('Badge Line 2', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'   => 'design_badge_text',
                'sub_toggle'  => 'badge_text_2',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ab_blurb_badge .badge_text_2",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_badge .badge_text_2",
                    'important' => 'all',
                ),
            ),

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
                'main'    => "$this->main_css_element .df_ab_blurb_description h1",
                'hover'   => "$this->main_css_element .df_ab_blurb_description h1:hover",
            ),
            'toggle_slug' => 'design_content_heading',
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
                'main'    => "$this->main_css_element .df_ab_blurb_description h2",
                'hover'   => "$this->main_css_element .df_ab_blurb_description h2:hover",
            ),
            'tab_slug'    => 'advanced',
            'toggle_slug' => 'design_content_heading',
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
                'main'    => "$this->main_css_element .df_ab_blurb_description h3",
                'hover'   => "$this->main_css_element .df_ab_blurb_description h3:hover",
            ),
            'toggle_slug' => 'design_content_heading',
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
                'main'    => "$this->main_css_element .df_ab_blurb_description h4",
                'hover'   => "$this->main_css_element .df_ab_blurb_description h4:hover",
            ),
            'toggle_slug' => 'design_content_heading',
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
                'main'    => "$this->main_css_element .df_ab_blurb_description h5",
                'hover'   => "$this->main_css_element .df_ab_blurb_description h5:hover",
            ),
            'toggle_slug' => 'design_content_heading',
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
                'main'    => "$this->main_css_element .df_ab_blurb_description h6",
                'hover'   => "$this->main_css_element .df_ab_blurb_description h6:hover",
            ),
            'toggle_slug' => 'design_content_heading',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'h6'
        );

        $advanced_fields['borders'] = array(
            'default'               => array(),
            'title_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_ab_blurb_title",
                        'border_radii_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_title",
                        'border_styles' => "{$this->main_css_element} .df_ab_blurb_title",
                        'border_styles_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_title",
                    )
                ),
                'label'    => esc_html__('Title Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_title',
            ),
            'sub_title_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_ab_blurb_sub_title",
                        'border_radii_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_sub_title",
                        'border_styles' => "{$this->main_css_element} .df_ab_blurb_sub_title",
                        'border_styles_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_sub_title",
                    )
                ),
                'label'    => esc_html__('Sub Title Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_sub_title',
            ),
            'content_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_ab_blurb_description",
                        'border_radii_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_description",
                        'border_styles' => "{$this->main_css_element} .df_ab_blurb_description",
                        'border_styles_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_description",
                    )
                ),
                'label'    => esc_html__('Content Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'   => 'design_content_bg_and_others',
                'sub_toggle'  => 'body',
            ),
            'button_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_ab_blurb_button",
                        'border_radii_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_button:hover",
                        'border_styles' => "{$this->main_css_element} .df_ab_blurb_button",
                        'border_styles_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_button",
                    )
                ),
                'label'    => esc_html__('Button Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button',
            ),

            'badge_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_ab_blurb_badge",
                        'border_radii_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_badge",
                        'border_styles' => "{$this->main_css_element} .df_ab_blurb_badge",
                        'border_styles_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_badge",
                    )
                ),
                'label'    => esc_html__('Badge Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_badge',
            ),

            'badge_text_1_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_ab_blurb_badge .badge_text_1 ",
                        'border_radii_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_badge .badge_text_1",
                        'border_styles' => "{$this->main_css_element} .df_ab_blurb_badge .badge_text_1",
                        'border_styles_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_badge .badge_text_1",
                    )
                ),
                'label'    => esc_html__('Badge Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'   => 'design_badge_text',
                'sub_toggle'  => 'badge_text_1',
            ),

            'badge_text_2_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_ab_blurb_badge .badge_text_2 ",
                        'border_radii_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_badge .badge_text_2",
                        'border_styles' => "{$this->main_css_element} .df_ab_blurb_badge .badge_text_2",
                        'border_styles_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_badge .badge_text_2",
                    )
                ),
                'label'    => esc_html__('Badge Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'   => 'design_badge_text',
                'sub_toggle'  => 'badge_text_2',
            ),

            'icon_border'         => array(
                'label'    => esc_html__('Icon Border', 'divi_flash'),
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .et-pb-icon.df-blurb-icon",
                        'border_radii_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .et-pb-icon.df-blurb-icon",
                        'border_styles' => "{$this->main_css_element} .et-pb-icon.df-blurb-icon",
                        'border_styles_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .et-pb-icon.df-blurb-icon",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_icon',
            ),

            'image_border'         => array(
                'label'    => esc_html__('Image Border', 'divi_flash'),
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_ab_blurb_image_img",
                        'border_radii_hover' => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_image_img',
                        'border_styles' => "{$this->main_css_element} .df_ab_blurb_image_img",
                        'border_styles_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_image_img",

                    ),
                    'important' => true,

                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_image',
            ),

            'content_area_border'         => array(
                'label'    => esc_html__('Content Area Border', 'divi_flash'),
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_ab_blurb_content_container",
                        'border_radii_hover' => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_content_container',
                        'border_styles' => "{$this->main_css_element} .df_ab_blurb_content_container",
                        'border_styles_hover' => "{$this->main_css_element} .df_ab_blurb_container:hover .df_ab_blurb_content_container",

                    ),
                    'important' => true,

                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_content_area',
            ),


        );
        $advanced_fields['box_shadow'] = array(
            'default'               => true,

            'button_shadow'             => array(
                'label'    => esc_html__('Button Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .df_ab_blurb_button",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_button",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button',
            ),
            'badge_shadow'             => array(
                'label'    => esc_html__('Badge Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .df_ab_blurb_badge",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_badge",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_badge',
            ),
            'icon_shadow'             => array(
                'label'    => esc_html__('Icon Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .et-pb-icon.df-blurb-icon",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .et-pb-icon.df-blurb-icon",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_icon',
            ),

            'image_shadow'             => array(
                'label'    => esc_html__('Image Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .df_ab_blurb_image_img",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_image_img",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_image',
            ),

            'content_area_shadow'             => array(
                'label'    => esc_html__('Content Area Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .df_ab_blurb_content_container",
                    'hover' => "%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_content_container",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_content_area',
            )

        );
        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'important' => 'all'
            )
        );

        $advanced_fields['filters'] = array(
            'child_filters_target' => array(
                'label'    => esc_html__('Image filter', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_image',
                'css' => array(
                    'main' => '%%order_class%% .df_ab_blurb_image_img',
                    'hover' => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_image_img'
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
        $advanced_fields['text'] = false;
        return $advanced_fields;
    }

    public function get_fields()
    {
        $general = array();

        $list_additional_fields = array(
					'ul_type'             => array(
						'label'            => esc_html__( 'Unordered List Style Type', 'et_builder' ),
						'description'      => esc_html__( 'This setting adjusts the shape of the bullet point that begins each list item.', 'et_builder' ),
						'type'             => 'select',
						'option_category'  => 'configuration',
						'options'          => array(
							'disc'   => et_builder_i18n( 'Disc' ),
							'circle' => et_builder_i18n( 'Circle' ),
							'square' => et_builder_i18n( 'Square' ),
							'none'   => et_builder_i18n( 'None' ),
						),
						'priority'         => 80,
						'default'          => 'disc',
						'default_on_front' => '',
						'toggle_slug'      => 'design_content',
						'sub_toggle'       => 'unorder_list',
						'tab_slug'         => 'advanced',
						'mobile_options'   => true,
					),
					'ul_position'         => array(
						'label'            => esc_html__( 'Unordered List Style Position', 'et_builder' ),
						'description'      => esc_html__( 'The bullet point that begins each list item can be placed either inside or outside the parent list wrapper. Placing list items inside will indent them further within the list.', 'et_builder' ),
						'type'             => 'select',
						'option_category'  => 'configuration',
						'options'          => array(
							'outside' => et_builder_i18n( 'Outside' ),
							'inside'  => et_builder_i18n( 'Inside' ),
						),
						'priority'         => 85,
						'default'          => 'inside',
						'default_on_front' => '',
						'toggle_slug'      => 'design_content',
						'sub_toggle'       => 'unorder_list',
						'tab_slug'         => 'advanced',
						'mobile_options'   => true,
					),
					'ol_type'             => array(
						'label'            => esc_html__( 'Ordered List Style Type', 'et_builder' ),
						'description'      => esc_html__( 'Here you can choose which types of characters are used to distinguish between each item in the ordered list.', 'et_builder' ),
						'type'             => 'select',
						'option_category'  => 'configuration',
						'options'          => array(
							'decimal'              => 'decimal',
							'armenian'             => 'armenian',
							'cjk-ideographic'      => 'cjk-ideographic',
							'decimal-leading-zero' => 'decimal-leading-zero',
							'georgian'             => 'georgian',
							'hebrew'               => 'hebrew',
							'hiragana'             => 'hiragana',
							'hiragana-iroha'       => 'hiragana-iroha',
							'katakana'             => 'katakana',
							'katakana-iroha'       => 'katakana-iroha',
							'lower-alpha'          => 'lower-alpha',
							'lower-greek'          => 'lower-greek',
							'lower-latin'          => 'lower-latin',
							'lower-roman'          => 'lower-roman',
							'upper-alpha'          => 'upper-alpha',
							'upper-greek'          => 'upper-greek',
							'upper-latin'          => 'upper-latin',
							'upper-roman'          => 'upper-roman',
							'none'                 => 'none',
						),
						'priority'         => 80,
						'default'          => 'decimal',
						'default_on_front' => '',
						'toggle_slug'      => 'design_content',
						'sub_toggle'       => 'order_list',
						'tab_slug'         => 'advanced',
						'mobile_options'   => true,
					),
					'ol_position'        => array(
						'label'            => esc_html__( 'Ordered List Style Position', 'et_builder' ),
						'description'      => esc_html__( 'The characters that begins each list item can be placed either inside or outside the parent list wrapper. Placing list items inside will indent them further within the list.', 'et_builder' ),
						'type'             => 'select',
						'option_category'  => 'configuration',
						'options'          => array(
							'inside'  => et_builder_i18n( 'Inside' ),
							'outside' => et_builder_i18n( 'Outside' ),
						),
						'priority'         => 85,
						'default'          => 'inside',
						'default_on_front' => '',
						'toggle_slug'      => 'design_content',
						'sub_toggle'       => 'order_list',
						'tab_slug'         => 'advanced',
						'mobile_options'   => true,
					)
				);
        $content = array(
            'title' => array(
                'label'           => esc_html__('Title', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Title entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'main_content',
                'affects'            => array(
					'title_url',
					'title_url_new_tab'
				),
                'dynamic_content' => 'text'
            ),
            'sub_title' => array(
                'label'           => esc_html__('Sub Title', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Sub Title entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text'
            ),
            'content' => array(
                'label'           => esc_html__('Content', 'divi_flash'),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Content entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text'
            ),
            'badge_enable'  => array(
                'label'           => esc_html__('Use Badge', 'divi_flash'),
                'type'            => 'yes_no_button',
                'options'         => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'badge'
            ),


        );
        $button  = array(
            'button_text' => array(
                'label'           => esc_html__('Button Text', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Title entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'button',
                'dynamic_content'    => 'text',
            ),
            'button_url' => array(
                'label'           => esc_html__('Button URL', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Title entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'button',
                'dynamic_content'    => 'url',
            ),
            'button_url_new_window' => array(
                'label'           => esc_html__('Button New tab ', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'off' => esc_html__('In The Same Window', 'divi_flash'),
                    'on'  => esc_html__('In The New Tab', 'divi_flash'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'button',
                'description'     => esc_html__('Choose whether your link opens in a new window or not', 'divi_flash')
            ),
            'button_full_width'  => array(
                'label'             => esc_html__('Enable Button Fullwidth', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'button',
                'tab_slug'        => 'advanced'
            ),
            'button_alignment' => array(
                'label'           => esc_html__('Button Alignment', 'divi_flash'),
                'type'            => 'text_align',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'     => 'button',
                'tab_slug'        => 'advanced',
                'mobile_options'  => true,
                'show_if'         => array(
                    'button_full_width'     => 'off'
                )
            ),
        );
        $button_icon = array(
            'use_button_icon' => array(
				'label'                 => esc_html__( 'Use Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'affects'               => array(
                    'button_font_icon',
                    'button_icon_size',
                    'button_icon_color',
                    'button_icon_placement'
				),
				'description'           => esc_html__( 'Here you can choose whether icon set below should be used.', 'divi_flash' ),
                'default_on_front'      => 'off',
                'toggle_slug'           => 'button',
                'tab_slug'              => 'advanced'
            ),
            'button_font_icon' => array(
				'label'               => esc_html__( 'Icon', 'divi_flash' ),
				'type'                => 'select_icon',
                'class'                 => array('et-pb-font-icon'),
                'default'               => '5',
				'toggle_slug'         => 'button',
                'tab_slug'            => 'advanced' ,
				'description'         => esc_html__( 'Choose an icon to display with your blurb.', 'divi_flash' ),
				'depends_show_if'     => 'on',
            ),
            'button_icon_size' => array(
                'label'             => esc_html__('Button Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'button',
                'tab_slug'          => 'advanced',
                'default'           => '24px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'depends_show_if'     => 'on'
            ),
            'button_icon_color' => array(
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'toggle_slug'       => 'button',
                'tab_slug'          => 'advanced' ,
                'hover'             => 'tabs',
                'depends_show_if'   => 'on',
            ),
            'button_icon_placement'   => array(
                'label'             => esc_html__('Icon Placement', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'left'          => esc_html__('Left', 'divi_flash'),
                    'right'         => esc_html__('Right', 'divi_flash')
                ),
                'default'           => 'right',
                'toggle_slug'       => 'button',
                'tab_slug'          => 'advanced',
                'depends_show_if'   => 'on'
            )
        );
        $badge = array(
            'badge' => array(
                'label'           => esc_html__('Badge Line 1', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Badge entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'badge',
                'dynamic_content'    => 'text',
                'show_if'         => array(
                    'badge_enable'     => 'on'
                ),
                'show_if_not'     => array(
                    'badge_icon_enable'       => 'on'
                )
            ),

            'badge_text_2' => array(
                'label'           => esc_html__('Badge Line 2', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Badge entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'badge',
                'dynamic_content'    => 'text',
                'show_if'         => array(
                    'badge_enable'     => 'on'
                ),
                'show_if_not'     => array(
                    'badge_icon_enable'       => 'on'
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
                    'badge_enable'     => 'on'
                )
            ),
            'badge_icon' => array(
                'label'                 => esc_html__('Badge Icon', 'divi_flash'),
                'type'                  => 'select_icon',
                'class' => array('et-pb-font-icon'),
                'default' => '4',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'badge',
                'show_if'         => array(
                    'badge_icon_enable'     => 'on',
                    'badge_enable'     => 'on'
                )
            ),
            'badge_alignment' => array(
                'label'           => esc_html__('Badge Alignment', 'divi_flash'),
                'type'            => 'text_align',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'     => 'design_badge',
                'tab_slug'        => 'advanced',
                'mobile_options'  => true,
                'show_if'         => array(
                    'badge_enable'     => 'on',
                )
            ),

            'badge_icon_color' => array(
                'label'                 => esc_html__('Badge Icon Color', 'divi_flash'),

                'type'            => 'color-alpha',
                'toggle_slug'   => 'design_badge',
                'tab_slug'        => 'advanced',
                'show_if'         => array(
                    'badge_icon_enable'     => 'on',
                    'badge_enable'     => 'on'
                ),
                'hover'            => 'tabs'
            ),

            'badge_icon_size' => array(
                'label'             => esc_html__('Badge Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_badge',
                'tab_slug'       => 'advanced',
                'default'           => '90px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '500',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'         => array(
                    'badge_icon_enable'     => 'on',
                    'badge_enable'     => 'on'
                ),
            ),

        );
        $title_link  = array(
            'title_url' => array(
                'label'           => esc_html__('Link URL', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Title url entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'title_link',
                'depends_show_if' => 'on',
				'depends_on'      => array(
					'title',
				),
                'dynamic_content' => 'url'
            ),
            'title_url_new_tab' => array(
                'label'           => esc_html__('Link Open New tab ', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'off' => esc_html__('In The Same Window', 'divi_flash'),
                    'on'  => esc_html__('In The New Tab', 'divi_flash')
                ),
                'option_category' => 'basic_option',
                'description'     => esc_html__('Choose whether your link opens in a new window or not', 'divi_flash'),
                'default'         => 'off',
                'toggle_slug'     => 'title_link',
                'depends_show_if' => 'on',
				'depends_on'      => array(
					'title'
				)
            )

        );

        $title_background = $this->df_add_bg_field(array(
            'label'                 => 'Title Background',
            'key'                   => 'title_background',
            'toggle_slug'           => 'design_title',
            'tab_slug'              => 'advanced'
        ));
        $sub_title_background = $this->df_add_bg_field(array(
            'label'                 => 'Sub Title Background',
            'key'                   => 'sub_title_background',
            'toggle_slug'           => 'design_sub_title',
            'tab_slug'              => 'advanced'
        ));
        $content_background = $this->df_add_bg_field(array(
            'label'                 => 'Content Background',
            'key'                   => 'content_background',
            'toggle_slug'           => 'design_content_bg_and_others',
            'tab_slug'              => 'advanced'
        ));
        $button_background = $this->df_add_bg_field(array(
            'label'                 => 'Button Background',
            'key'                   => 'button_background',
            'toggle_slug'           => 'button',
            'tab_slug'              => 'advanced'
        ));

        $badge_background = $this->df_add_bg_field(array(
            'label'                 => 'Badge Background',
            'key'                   => 'badge_background',
            'toggle_slug'           => 'design_badge',
            'tab_slug'              => 'advanced',
            'show_if'               => array(
                'badge_enable'     => 'on'
            )
        ));

        $image = array(

            'blurb_icon_enable'  => array(
                'label'             => esc_html__('Use Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'image'
            ),

            'blurb_icon' => array(
                'label'                 => esc_html__('Icon', 'divi_flash'),
                'type'                  => 'select_icon',
                'class'                 => array('et-pb-font-icon'),
                'default'               => '4',
                'option_category'       => 'basic_option',
                'toggle_slug'           => 'image',
                //'depends_show_if'     => 'on',
                'show_if'         => array(
                    'blurb_icon_enable'     => 'on'
                )
            ),

            'blurb_icon_color' => array(
                'label'                 => esc_html__('Icon Color', 'divi_flash'),

                'type'            => 'color-alpha',
                'toggle_slug'     => 'design_icon',
                'tab_slug'        => 'advanced',
                //'depends_show_if'     => 'on',
                'show_if'         => array(
                    'blurb_icon_enable'     => 'on'
                ),
                'hover'            => 'tabs'
            ),

            'icon_size' => array(
                'label'             => esc_html__('Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_icon',
                'tab_slug'          => 'advanced',
                'default'           => '90px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '500',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'blurb_icon_enable'     => 'on'
                ),
            ),

            'blurb_icon_background_color' => array(
                'label'           => esc_html__('Icon Background Color', 'divi_flash'),

                'type'            => 'color-alpha',
                'toggle_slug'     => 'design_icon',
                'tab_slug'        => 'advanced',
                'show_if'         => array(
                    'blurb_icon_enable'     => 'on'
                ),
                'hover'            => 'tabs'
            ),

            'blurb_img_background_color' => array(
                'label'                 => esc_html__('Image Background Color', 'divi_flash'),

                'type'            => 'color-alpha',
                'toggle_slug'     => 'design_image',
                'tab_slug'        => 'advanced',
                'show_if'         => array(
                    'blurb_icon_enable'     => 'off'
                ),
                'hover'            => 'tabs'
            ),

            'image' => array(
                'label'                 => esc_html__('Image', 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'upload_button_text'    => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'image',
                'show_if'         => array(
                    'blurb_icon_enable'     => 'off'
                ),
                'dynamic_content'    => 'image'

            ),
            'image_icon_container_position'  => array(
                'label'           => esc_html__('Image or Icon Container Placement', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'inside'      => esc_html__('Inside Content Area', 'divi_flash'),
                    'outside'     => esc_html__('Outside Content Area', 'divi_flash')
                 ),
                'default'         => 'inside',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'image',
                'description'     => esc_html__('Choose Image or Icon container placement', 'divi_flash')
            ),

            'image_placement'  => array(
                'label'           => esc_html__('Image or Icon Position ', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'flex_top'    => esc_html__('Top', 'divi_flash'),
                    'flex_left'   => esc_html__('Left', 'divi_flash'),
                    'flex_right'  => esc_html__('Right', 'divi_flash'),
                    'flex_bottom' => esc_html__('Bottom', 'divi_flash')
                 ),
                'default'         => 'flex_top',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'image',
                 'show_if'        => array(
                    'image_icon_container_position'     => 'outside'
                 ),
                'description'     => esc_html__('Choose image position', 'divi_flash'),
                'responsive'      => true,
                'mobile_options'    => true
            ),
            'image_icon_alignment' => array(
                'label'           => esc_html__('Image or Icon Alignment', 'divi_flash'),
                'type'            => 'text_align',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'     => 'image',
                'mobile_options'    => true
            ),
            'image_icon_item_align' => array(
                'label'           => esc_html__('Image or Icon Item Align ', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'flex-start' => esc_html__('Start', 'divi_flash'),
                    'center'     => esc_html__('Center', 'divi_flash'),
                    'flex-end'   => esc_html__('End', 'divi_flash')
                ),
                'default'           => 'normal',
                'option_category'   => 'basic_option',
                'toggle_slug'       => 'image',
                'show_if'           => array(
                    'image_placement'     => array('flex_left', 'flex_right')
                ),
                'description'       => esc_html__('Choose Image or Icon Item Align', 'divi_flash'),
                'responsive'      => true,
                'mobile_options'    => true
            ),
            'image_container_width' => array(
                'label'             => esc_html__('Image Container Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_image',
                'tab_slug'          => 'advanced',
                'default'           => '20%',
                'allowed_units'     => array('%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'image_placement'     => array('flex_left', 'flex_right'),
                    'blurb_icon_enable'     => 'off',
                    'image_icon_container_position' => 'outside'
                ),
                'description'     => esc_html__('Set Image container Width', 'divi_flash')
            ),
            'alt_text' => array(
                'label'                 => esc_html__('Image Alt Text', 'divi_flash'),
                'description'           => esc_html__( 'This defines the HTML ALT text. A short description of your image can be placed here.', 'divi_flash' ),
                'type'                  => 'text',
                'toggle_slug'           => 'image',
                'show_if'               => array(
                    'blurb_icon_enable' => 'off'
                ),
                'show_if_not'           => array(
                    'image' => array('')
                )
            )

        );
        $content_area = array(
            'content_area_alignment'     => array(
                'label'             => esc_html__('Content Area Alignment', 'divi_flash'),
                'type'              => 'text_align',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'design_content_area',
                'options'           =>  et_builder_get_text_orientation_options( array( 'justified' ) ),
                'mobile_options'    => true,
            )
        );
        $content_area_background = $this->df_add_bg_field(array(
            'label'                 => 'Content Area Background',
            'key'                   => 'content_area_background',
            'toggle_slug'           => 'design_content_area',
            'tab_slug'              => 'advanced',
            'show_if'               => array(
                'image_icon_container_position'     => 'outside'
            ),
        ));
        $z_index = array(
            'blurb_img_zindex' => array(
                'label'             => esc_html__('Image or Icon z-index', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_zindex',
                'tab_slug'          => 'advanced',
                'default'           => '0',
                'range_settings'    => array(
                    'min'  => '-100',
                    'max'  => '1000',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'mobile_options'    => true,
                'show_if_not'       => array(
                    'image' => array('')
                ),
            ),

            'title_zindex' => array(
                'label'             => esc_html__('Title z-index', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_zindex',
                'tab_slug'          => 'advanced',
                'default'           => '0',
                'range_settings'    => array(
                    'min'  => '-100',
                    'max'  => '1000',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'mobile_options'    => true,
            ),

            'sub_title_zindex' => array(
                'label'             => esc_html__('Sub Title z-index', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_zindex',
                'tab_slug'          => 'advanced',
                'default'           => '0',
                'range_settings'    => array(
                    'min'  => '-100',
                    'max'  => '1000',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'mobile_options'    => true,
            ),

            'content_zindex' => array(
                'label'             => esc_html__('Content z-index', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_zindex',
                'tab_slug'          => 'advanced',
                'default'           => '0',
                'range_settings'    => array(
                    'min'  => '-100',
                    'max'  => '1000',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'mobile_options'    => true,
            ),

            'badge_zindex' => array(
                'label'             => esc_html__('Badge z-index', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_zindex',
                'tab_slug'          => 'advanced',
                'default'           => '0',
                'range_settings'    => array(
                    'min'  => '-100',
                    'max'  => '1000',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'mobile_options'    => true,
                'show_if'           => array(
                    'badge_enable'     => 'on'
                ),
            ),

           'button_zindex' => array(
                'label'             => esc_html__('Button z-index', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_zindex',
                'tab_slug'          => 'advanced',
                'default'           => '0',
                'range_settings'    => array(
                    'min'  => '-100',
                    'max'  => '1000',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'mobile_options'    => true,
            ),

        );
        $sizeing = array(
            'content_width' => array(
                'label'             => esc_html__('Content Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'width',
                'tab_slug'          => 'advanced',
                'default'           => '540px',
                'allowed_units'     => array('px', '%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '1920',
                    'step' => '1'
                ),
                'responsive'        => true,
                'mobile_options'    => true,
            ),

            'image_width' => array(
                'label'             => esc_html__('Image Width(%)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'width',
                'tab_slug'          => 'advanced',
                'default'           => '100%',
                'default_unit'      => '%',
                'allowed_units'     => array('%', 'px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if_not'       => array(
                    'image' => array('')
                ),
            ),
        );
        $wrapper_spacing = array(
            'wrapper_margin' => array(
                'label'             => sprintf(esc_html__('Wrapper Margin', 'divi_flash')),
                'toggle_slug'       => 'custom_spacing',
                'tab_slug'          => 'advanced',
                'sub_toggle'        => 'wrapper',
                'type'              => 'custom_margin',
                'hover'             => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'wrapper_padding' => array(
                'label'             => sprintf(esc_html__('Wrapper Padding', 'divi_flash')),
                'toggle_slug'       => 'custom_spacing',
                'tab_slug'          => 'advanced',
                'sub_toggle'        => 'wrapper',
                'type'              => 'custom_margin',
                'hover'             => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),

            'blurb_img_margin' => array(
                'label'             => sprintf(esc_html__('Image or Icon Wrapper Margin', 'divi_flash')),
                'toggle_slug'       => 'custom_spacing',
                'tab_slug'          => 'advanced',
                'sub_toggle'        => 'wrapper',
                'type'              => 'custom_margin',
                'hover'             => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),

            'blurb_icon_spacing' => array(
                'label'             => esc_html__('Icon Wrapper Padding', 'divi_flash'),
                'type'              => 'custom_margin',
                'toggle_slug'       => 'custom_spacing',
                'tab_slug'          => 'advanced',
                'sub_toggle'        => 'wrapper',
                'show_if'           => array(
                    'blurb_icon_enable'     => 'on'
                ),
                'hover'             => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),

            'blurb_img_spacing' => array(
                'label'             => esc_html__('Image Wrapper Padding', 'divi_flash'),
                'type'              => 'custom_margin',
                'toggle_slug'       => 'custom_spacing',
                'tab_slug'          => 'advanced',
                'sub_toggle'        => 'wrapper',
                'show_if'           => array(
                    'blurb_icon_enable'     => 'off'
                ),
                'show_if_not'       => array(
                    'image' => array('')
                ),
                'hover'             => 'tabs',
                'mobile_options'    => true
            ),


            'button_wrapper_margin' => array(
                'label'             => sprintf(esc_html__('Button Wrapper Margin', 'divi_flash')),
                'toggle_slug'       => 'custom_spacing',
                'tab_slug'          => 'advanced',
                'sub_toggle'        => 'wrapper',
                'type'              => 'custom_margin',
                'hover'             => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'button_wrapper_padding' => array(
                'label'             => sprintf(esc_html__('Button Wrapper Padding', 'divi_flash')),
                'toggle_slug'       => 'custom_spacing',
                'tab_slug'          => 'advanced',
                'sub_toggle'        => 'wrapper',
                'type'              => 'custom_margin',
                'hover'             => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),

            'badge_wrapper_margin' => array(
                'label'             => sprintf(esc_html__('Badge Wrapper Margin', 'divi_flash')),
                'toggle_slug'       => 'design_badge',
                'tab_slug'          => 'advanced',
                'sub_toggle'        => 'content',
                'type'              => 'custom_margin',
                'hover'             => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'badge_enable'     => 'on'
                )
            ),

        );

        $content_spacing = array(
            'content_area_margin' => array(
                'label'               => sprintf(esc_html__('Content Area Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'        => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'         => array(
                    'image_icon_container_position' => 'outside'
                )
            ),
            'content_area_padding' => array(
                'label'               => sprintf(esc_html__('Content Area Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'        => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'         => array(
                    'image_icon_container_position' => 'outside'
                )
            ),
            'title_margin' => array(
                'label'               => sprintf(esc_html__('Title Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'title_padding' => array(
                'label'               => sprintf(esc_html__('Title Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'sub_title_margin' => array(
                'label'               => sprintf(esc_html__('Sub Title Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'sub_title_padding' => array(
                'label'               => sprintf(esc_html__('Sub Title Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'content_margin' => array(
                'label'               => sprintf(esc_html__('Content Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'content_padding' => array(
                'label'               => sprintf(esc_html__('Content Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),

            'button_margin' => array(
                'label'               => sprintf(esc_html__('Button Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'button_padding' => array(
                'label'               => sprintf(esc_html__('Button Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'button_icon_margin' => array(
                'label'               => sprintf(esc_html__('Button Icon Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'badge_margin' => array(
                'label'               => sprintf(esc_html__('Badge Margin', 'divi_flash')),
                'toggle_slug' => 'design_badge',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'         => array(
                    'badge_enable'     => 'on'
                )
            ),
            'badge_padding' => array(
                'label'               => sprintf(esc_html__('Badge Padding', 'divi_flash')),
                'toggle_slug' => 'design_badge',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'=> array(
                    'badge_enable' => 'on'
                )
            ),
            'badge_icon_margin' => array(
                'label'               => sprintf(esc_html__('Badge Icon Margin', 'divi_flash')),
                'toggle_slug' => 'design_badge',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'         => array(
                    'badge_enable'          => 'on',
                    'badge_icon_enable'     => 'on'
                )
            ),
            'badge_text_1_margin' => array(
                'label'               => sprintf(esc_html__('Badge Line 1 Margin', 'divi_flash')),
                'toggle_slug' => 'design_badge',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'         => array(
                    'badge_enable'     => 'on'
                )
            ),
            'badge_text_1_padding' => array(
                'label'               => sprintf(esc_html__('Badge Line 1 Padding', 'divi_flash')),
                'toggle_slug' => 'design_badge',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'         => array(
                    'badge_enable'     => 'on'
                )
            ),
        );

        $item_order = array(
            'order_enable'  => array(
                'label'             => esc_html__('Enable Order', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'item_order'
            ),
            'image_order' => array(
                'label'             => esc_html__('Image/Icon Order', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'item_order',
                'default'           => '9',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'order_enable'     => 'on',
                    'image_icon_container_position'     => 'inside'
                ),

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
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'order_enable'     => 'on'
                ),
                'description'       => esc_html__('Increase the order number to position the item lower.', 'divi_flash')
            ),
            'sub_title_order' => array(
                'label'             => esc_html__('Sub Title Order', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'item_order',
                'default'           => '9',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'show_if'         => array(
                    'order_enable'     => 'on'
                ),
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
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'order_enable'     => 'on'
                ),
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
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'order_enable'     => 'on'
                ),
                'description'       => esc_html__('Increase the order number to position the item lower.', 'divi_flash')
            ),
            'badge_order' => array(
                'label'             => esc_html__('Badge Order', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'item_order',
                'default'           => '9',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'order_enable'     => 'on',
                    'badge_enable'     => 'on',
                ),
                'description'       => esc_html__('Increase the order number to position the item lower.', 'divi_flash')
            )

        );

        return array_merge(
            $content,
			$list_additional_fields,
            $button_background,
            $button,
            $button_icon,
            $badge_background,
            $badge,
            $image,
            $title_link,
            $title_background,
            $sub_title_background,
            $content_background,
            $content_area,
            $content_area_background,
            $item_order,
            $z_index,
            $sizeing,
            $wrapper_spacing,
            $content_spacing
        );
    }

    public function df_ab_flex_direction($placement_slug)
    {
        $flex_direction = '';
        if ($placement_slug == 'right') {
            $flex_direction = 'row-reverse';
            $add_css = 'margin-left: 20px';
        } else if ($placement_slug == 'top') {
            $flex_direction = 'column';
            $add_css = 'margin-left: 0';
        } else if ($placement_slug == 'left') {
            $flex_direction = 'row';
            $add_css = 'margin-right: 20px';
        }
        return $flex_direction;
    }

    public function get_transition_fields_css_props()
    {
        $fields = parent::get_transition_fields_css_props();

        $button_wrapper  = '%%order_class%% .df_ab_blurb_button_wrapper';
        $title           = '%%order_class%% .df_ab_blurb_title';
        $subtitle        = '%%order_class%% .df_ab_blurb_sub_title';
        $content         = '%%order_class%% .df_ab_blurb_description';
        $button          = '%%order_class%% .df_ab_blurb_button';
        $button_icon     = '%%order_class%% .df_ab_blurb_button .et-pb-icon.df-blurb-button-icon';
        $badge_wrapper   = '%%order_class%% .df_ab_blurb_badge_wrapper';
        $badge           = '%%order_class%% .df_ab_blurb_badge';
        $badge_text_1    = '%%order_class%% .df_ab_blurb_badge .badge_text_1';
        $badge_text_2    = '%%order_class%% .df_ab_blurb_badge .badge_text_2';
        $badge_icon      = '%%order_class%% .df_ab_blurb_badge .et-pb-icon';
        $icon            = '%%order_class%% .et-pb-icon.df-blurb-icon';
        $image           =  '%%order_class%% .df_ab_blurb_image_img';
        $image_and_icon_wrapper = '%%order_class%% .df_ab_blurb_image';
        $content_area = '%%order_class%%  .df_ab_blurb_content_container';
        // spacing
        $fields['button_wrapper_margin']    = array('margin' => $button_wrapper);
        $fields['button_wrapper_padding']   = array('padding' => $button_wrapper);

        $fields['button_margin']            = array('margin' => $button);
        $fields['button_padding']           = array('padding' => $button);
        $fields['button_icon_margin']            = array('margin' =>  $button_icon );
        $fields['badge_wrapper_margin']   = array('margin' => $badge_wrapper);
        $fields['badge_margin']            = array('margin' => $badge);
        $fields['badge_padding']           = array('padding' => $badge);
        $fields['badge_icon_margin']            = array('margin' => $badge_icon);
        $fields['badge_text_1_margin']            = array('margin' => $badge_text_1);
        $fields['badge_text_1_padding']           = array('padding' => $badge_text_1);
        $fields['blurb_icon_spacing']           = array('padding' => $icon);
        $fields['blurb_img_spacing']           = array('padding' => $image);

        $fields['wrapper_padding']  = array('padding' => '%%order_class%% .df_ab_blurb_container');
        $fields['wrapper_margin']   = array('margin' => '%%order_class%% .df_ab_blurb_container');
        $fields['blurb_img_margin'] = array('margin' => '%%order_class%% .df_ab_blurb_image');
        $fields['image_margin'] = array('margin' => '%%order_class%% .df_ab_blurb_image img');

        $fields['content_area_margin'] = array('margin' => $content_area);
        $fields['content_area_padding'] = array('padding' => $content_area);
        $fields['title_margin'] = array('margin' => $title);
        $fields['title_padding'] = array('padding' => $title);

        $fields['sub_title_margin'] = array('margin' => $subtitle);
        $fields['sub_title_padding'] = array('padding' => $subtitle);

        $fields['content_margin'] = array('margin' => $content);
        $fields['content_padding'] = array('padding' => $content);

       // Color
       $fields['blurb_icon_color'] = array('color' => $icon);
       $fields['badge_icon_color'] = array('color' => $badge_icon);
       $fields['blurb_icon_background_color'] = array('background' => $icon);
       $fields['blurb_img_background_color'] = array('background' => $image);

        // background
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'button_background',
            'selector'      => $button
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'badge_background',
            'selector'      => $badge
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'content_area_background',
            'selector'      => $content_area
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'title_background',
            'selector'      => $title
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'sub_title_background',
            'selector'      => $subtitle
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'content_background',
            'selector'      => $content
        ));

        // border fix
        $fields = $this->df_fix_border_transition(
            $fields,
            'content_area_border',
            $content_area
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'sub_title_border',
            $subtitle
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'title_border',
            $title
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'content_border',
            $content
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'button_border',
            $button
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'badge_border',
            $badge
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'image_border',
            $image
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'icon_border',
            $icon
        );
        // box-shadwo fix
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'button_shadow',
            $button
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'badge_shadow',
            $badge
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'icon_shadow',
            $icon
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'image_shadow',
            $image
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'content_area_shadow',
            $content_area
        );

        return $fields;
    }
    public function additional_css_styles($render_slug)
    {

        if ('off' !== $this->props['order_enable']) {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'image_order',
                'type'              => 'order',
                'selector'          => '%%order_class%% .df_ab_blurb_image'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'title_order',
                'type'              => 'order',
                'selector'          => '%%order_class%% .df_ab_blurb_title'
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'sub_title_order',
                'type'              => 'order',
                'selector'          => '%%order_class%% .df_ab_blurb_sub_title'
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'content_order',
                'type'              => 'order',
                'selector'          => '%%order_class%% .df_ab_blurb_description'
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'button_order',
                'type'              => 'order',
                'selector'          => '%%order_class%% .df_ab_blurb_button_wrapper'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'badge_order',
                'type'              => 'order',
                'selector'          => '%%order_class%% .df_ab_blurb_badge_wrapper'
            ));
        }
        // Z index
        $this->df_process_range(array(
            'render_slug'           => $render_slug,
            'slug'                  => 'blurb_img_zindex',
            'type'                  => 'z-index',
            'selector'              => '%%order_class%% .df_ab_blurb_image'
        ));

        $this->df_process_range(array(
            'render_slug'           => $render_slug,
            'slug'                  => 'badge_zindex',
            'type'                  => 'z-index',
            'selector'              => '%%order_class%% .df_ab_blurb_badge_wrapper'
        ));

        $this->df_process_range(array(
            'render_slug'           => $render_slug,
            'slug'                  => 'button_zindex',
            'type'                  => 'z-index',
            'selector'              => '%%order_class%% .df_ab_blurb_button_wrapper'
        ));

        $this->df_process_range(array(
            'render_slug'           => $render_slug,
            'slug'                  => 'title_zindex',
            'type'                  => 'z-index',
            'selector'              => '%%order_class%% .df_ab_blurb_title'
        ));

        $this->df_process_range(array(
            'render_slug'           => $render_slug,
            'slug'                  => 'sub_title_zindex',
            'type'                  => 'z-index',
            'selector'              => '%%order_class%% .df_ab_blurb_sub_title'
        ));

        $this->df_process_range(array(
            'render_slug'           => $render_slug,
            'slug'                  => 'content_zindex',
            'type'                  => 'z-index',
            'selector'              => '%%order_class%% .df_ab_blurb_description'
        ));

        // Image placement
        $image_placement =  $this->props['image_placement'];

        $this->df_process_string_attr(array(
            'render_slug'           => $render_slug,
            'slug'                  => 'image_placement',
            'type'                  => 'flex-direction',
            'selector'              => "%%order_class%% .df_ab_blurb_container",
            'default'               => 'column'
        ));

        // if('flex_top' !== $image_placement){
        //     ET_Builder_Element::set_style($render_slug, array(
        //         'selector'      => "%%order_class%% .df_ab_blurb_container",
        //         'declaration'   => "flex-direction: $image_placement;",
        //         'media_query'   => ET_Builder_Element::get_media_query('max_width_767')
        //     ));
        // }
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_width',
            'type'              => 'max-width',
            'selector'          => '%%order_class%% .df_ab_blurb_container'
        ));

        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_icon_alignment',
            'type'              => 'text-align',
            'selector'          => "%%order_class%% .df_ab_blurb_image",
            'default'           => 'left'
        ));

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_width',
            'type'              => 'max-width',
            'selector'          => "%%order_class%% .df_ab_blurb_image_img"
        ));

        if ($this->props['image_icon_container_position'] !== 'inside' && ($image_placement === 'flex_left' || $image_placement === 'flex_right')) {
            // Image container and content container design
           if ('off' === $this->props['blurb_icon_enable']) {
                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'image_container_width',
                    'type'              => 'width',
                    'selector'          => '%%order_class%% .df_ab_blurb_image'
                ));
            }

            $slug = 'image_container_width';
            $selector_property = 'width';
            $image_container_width_desktop  =  !empty($this->props[$slug]) ?
                $this->df_process_values($this->props[$slug]) : '20%';
            $image_container_width_tablet   =  !empty($this->props[$slug.'_tablet']) ?
                $this->df_process_values($this->props[$slug.'_tablet']) : $image_container_width_desktop;

            $image_container_width_phone   =  !empty($this->props[$slug.'_phone']) ?
                $this->df_process_values($this->props[$slug.'_phone']) : $image_container_width_tablet;

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .df_ab_blurb_content_container",
                'declaration' => $selector_property.':  calc(100% - '.$image_container_width_desktop.');'
            ));

            if($this->props['image_placement_tablet'] === 'flex_left' || $this->props['image_placement_tablet'] === 'flex_right'){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% .df_ab_blurb_content_container",
                    'declaration' =>$selector_property.':  calc(100% - '.$image_container_width_tablet.');',
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
            }


            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .df_ab_blurb_content_container",
                'declaration' =>$selector_property.':  100%;',
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));

            // ET_Builder_Element::set_style($render_slug, array(
            //     'selector' => "%%order_class%% .df_ab_blurb_container",
            //     'declaration' => sprintf('align-items: %1$s;',  $this->props['image_icon_item_align'])
            // ));


            // if ('' !== $this->props['image_icon_item_align']) {
            //     ET_Builder_Element::set_style($render_slug, array(
            //         'selector' => "%%order_class%% .df_ab_blurb_container",
            //         'declaration' => sprintf(' align-items: %1$s;',  $this->props['image_icon_item_align'])
            //     ));
            // }

            $this->df_process_string_attr(array(
                'render_slug'           => $render_slug,
                'slug'                  => 'image_icon_item_align',
                'type'                  => 'align-items',
                'selector'              => "%%order_class%% .df_ab_blurb_container",
                'default'               => 'center'
            ));
        }

        //  background
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_area_background',
            'selector'          => "%%order_class%% .df_ab_blurb_content_container",
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_content_container'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_background',
            'selector'          => "%%order_class%% .df_ab_blurb_title",
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_title'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'sub_title_background',
            'selector'          => "%%order_class%% .df_ab_blurb_sub_title",
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_sub_title'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_background',
            'selector'          => "%%order_class%% .df_ab_blurb_description",
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_description'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_background',
            'selector'          => "%%order_class%% .df_ab_blurb_button",
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_button'
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_background',
            'selector'          => "%%order_class%% .df_ab_blurb_badge",
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_badge'
        ));
        // Badge icon
        if ('on' === $this->props['badge_icon_enable']) {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'badge_icon_color',
                'type'              => 'color',
                'selector'          => "%%order_class%% .df_ab_blurb_badge .et-pb-icon",
                'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_badge .et-pb-icon'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'badge_icon_size',
                'type'              => 'font-size',
                'selector'          => "%%order_class%% .df_ab_blurb_badge .et-pb-icon"
            ));
        }
        // Blurb Icon
        if ('on' === $this->props['blurb_icon_enable']) {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'blurb_icon_color',
                'type'              => 'color',
                'selector'          => "%%order_class%% .et-pb-icon.df-blurb-icon",
                'hover'             => '%%order_class%% .df_ab_blurb_container:hover .et-pb-icon.df-blurb-icon'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_size',
                'type'              => 'font-size',
                'selector'          => "%%order_class%% .et-pb-icon.df-blurb-icon",
                'hover'             => '%%order_class%% .df_ab_blurb_container:hover .et-pb-icon.df-blurb-icon'
            ));

            if ('' !== $this->props['blurb_icon_background_color']) {
                $this->df_process_color(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'blurb_icon_background_color',
                    'type'              => 'background-color',
                    'selector'          => "%%order_class%% .et-pb-icon.df-blurb-icon",
                    'hover'             => '%%order_class%% .df_ab_blurb_container:hover .et-pb-icon.df-blurb-icon'
                ));
            }
        }
        if ('on' === $this->props['blurb_icon_enable'] && '' !== $this->props['blurb_icon_spacing']) {
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'blurb_icon_spacing',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .et-pb-icon.df-blurb-icon',
                'hover'             => '%%order_class%% .df_ab_blurb_container:hover .et-pb-icon.df-blurb-icon',
                'important'         => false
            ));
        }
        // Button icon
        if ('on' === $this->props['use_button_icon']) {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'button_icon_color',
                'type'              => 'color',
                'selector'          => "%%order_class%% .df_ab_blurb_button .et-pb-icon",
                'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_button .et-pb-icon.df-blurb-button-icon'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'button_icon_size',
                'type'              => 'font-size',
                'default'           => '24px',
                'selector'          => "%%order_class%% .df_ab_blurb_button .et-pb-icon.df-blurb-button-icon"
            ));
        }


        // Blurb Image
        if ('' !== $this->props['image']) {
            if ('' !== $this->props['blurb_img_background_color']) {

                $this->df_process_color(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'blurb_img_background_color',
                    'type'              => 'background-color',
                    'selector'          => "%%order_class%% .df_ab_blurb_image_img",
                    'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_image_img'
                ));
            }
           $this->set_margin_padding_styles(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'blurb_img_spacing',
                    'type'              => 'padding',
                    'selector'          => '%%order_class%% .df_ab_blurb_image_img',
                    'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_image_img',
                    'important'         => true
            ));

        }

        if ('' !== $this->props['blurb_img_margin']) {
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'blurb_img_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df_ab_blurb_image',
                'hover'             => '%%order_class%% .df_ab_blurb_image:hover',
                'important'         => false
            ));
        }

        // Blurb Container spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ab_blurb_container',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ab_blurb_container',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover',
            'important'         => false
        ));

        // Button Design
        if ('on' === $this->props['button_full_width']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .df_ab_blurb_button",
                'declaration' => 'display: block !important;'
            ));
        }
        if ('off' === $this->props['button_full_width'] &&  '' !== $this->props['button_alignment']) {
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'button_alignment',
                'type'              => 'text-align',
                'selector'          => "%%order_class%% .df_ab_blurb_button_wrapper",
                'default'           => 'left'
            ));

        }

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ab_blurb_button_wrapper',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_button_wrapper',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ab_blurb_button_wrapper',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_button_wrapper',
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ab_blurb_badge_wrapper',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_badge_wrapper',
            'important'         => false
        ));


        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ab_blurb_button',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_button',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ab_blurb_button',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_button',
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_icon_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ab_blurb_button .et-pb-icon.df-blurb-button-icon',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_button .et-pb-icon.df-blurb-button-icon',
            'important'         => false,
            'show_if' => array(
                'use_button_icon' => 'on'
            )
        ));
        // Content area design
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_area_alignment',
            'type'              => 'text-align',
            'selector'          => "%%order_class%% .df_ab_blurb_content_container",
            'default'           => 'left'
        ));

        // list additional fields
        $this->df_process_string_attr(array(
            'render_slug'           => $render_slug,
            'slug'                  => 'ul_type',
            'type'                  => 'list-style-type',
            'selector'              => "%%order_class%% .df_ab_blurb_description ul",
            'default'               => 'disc'
        ));
        $this->df_process_string_attr(array(
            'render_slug'           => $render_slug,
            'slug'                  => 'ul_position',
            'type'                  => 'list-style-position',
            'selector'              => "%%order_class%% .df_ab_blurb_description ul",
            'default'               => 'inside'
        ));
        $this->df_process_string_attr(array(
            'render_slug'           => $render_slug,
            'slug'                  => 'ol_type',
            'type'                  => 'list-style-type',
            'selector'              => "%%order_class%% .df_ab_blurb_description ol",
            'default'               => 'decimal'
        ));
        $this->df_process_string_attr(array(
            'render_slug'           => $render_slug,
            'slug'                  => 'ol_position',
            'type'                  => 'list-style-position',
            'selector'              => "%%order_class%% .df_ab_blurb_description ol",
            'default'               => 'inside'
        ));
        
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_area_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ab_blurb_content_container',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_content_container',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_area_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ab_blurb_content_container',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_content_container',
            'important'         => false
        ));

        // Title design
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ab_blurb_title',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_title',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ab_blurb_title',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_title',
            'important'         => false
        ));

        // Sub Title
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'sub_title_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ab_blurb_sub_title',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_sub_title',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'sub_title_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ab_blurb_sub_title',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_sub_title',
            'important'         => false
        ));

        // Content design
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ab_blurb_description',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_description',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ab_blurb_description',
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .df_ab_blurb_description',
            'important'         => false
        ));

        // Badge design
        if ('on' === $this->props['badge_enable'] &&  '' !== $this->props['badge_alignment']) {
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'badge_alignment',
                'type'              => 'text-align',
                'selector'          => "%%order_class%% .df_ab_blurb_badge_wrapper",
            ));

        }

        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "%%order_class%% .badge_text_1",
            'declaration' => 'display: block !important;',
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "%%order_class%% .badge_text_2",
            'declaration' => 'display: block !important;',
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ab_blurb_badge',
            'hover'             => '%%order_class%%  .df_ab_blurb_container:hover .df_ab_blurb_badge',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ab_blurb_badge',
            'hover'             => '%%order_class%%  .df_ab_blurb_container:hover .df_ab_blurb_badge',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_icon_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ab_blurb_badge .et-pb-icon',
            'hover'             => '%%order_class%%  .df_ab_blurb_container:hover .df_ab_blurb_badge .et-pb-icon',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_text_1_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .badge_text_1',
            'hover'             => '%%order_class%%  .df_ab_blurb_container:hover .badge_text_1',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_text_1_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .badge_text_1',
            'hover'             => '%%order_class%%  .df_ab_blurb_container:hover .badge_text_1',
            'important'         => false
        ));
        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'blurb_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-blurb-icon',
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

            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'button_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-blurb-button-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }
    }
    public function df_render_image_icon()
    {
        if (isset($this->props['blurb_icon_enable']) && $this->props['blurb_icon_enable'] === 'on') {

            return sprintf(
                '<span class="et-pb-icon df-blurb-icon">%1$s</span>',
                isset($this->props['blurb_icon']) && $this->props['blurb_icon'] !== '' ?
                    esc_attr(et_pb_process_font_icon($this->props['blurb_icon'])) : '5'
            );
        } else if (isset($this->props['image']) && $this->props['image'] !== '') {

            $src = 'src';
            $image_alt = $this->props['alt_text'] !== '' ? $this->props['alt_text']  : df_image_alt_by_url($this->props['image']);
            $image_url = $this->props['image'];

            return sprintf(
                '<img class="df_ab_blurb_image_img" %3$s="%1$s" alt="%2$s" />',
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

    public function df_render_button()
    {
        $text = isset($this->props['button_text']) ? $this->props['button_text'] : '';
        $url = isset($this->props['button_url']) ? $this->props['button_url'] : '';
        $target = $this->props['button_url_new_window'] === 'on'  ?
            'target="_blank"' : '';

        $button_font_icon             = $this->props['button_font_icon'];
        $button_icon_pos             = $this->props['button_icon_placement'];

        // Button icon
        $button_icon = $this->props['use_button_icon'] !== 'off' ? sprintf('<span class="et-pb-icon df-blurb-button-icon">%1$s</span>',
            $button_font_icon !== '' ? esc_attr( et_pb_process_font_icon( $button_font_icon ) ) : '5'
        ) : '';
        if ($text !== '' || $url !== '') {
            return sprintf('<div class="df_ab_blurb_button_wrapper">
                                <a href="%1$s" %3$s class="df_ab_blurb_button" data-icon="5">%5$s <span>%2$s</span> %4$s</a>
                            </div>',
                            esc_attr($url),
                            esc_html(trim($text)),
                            $target,
                            $button_icon_pos === 'right' ? $button_icon : '',
                            $button_icon_pos === 'left' ? $button_icon : ''
                        );
        } else {
            return '';
        }
    }

    public function render($attrs, $content, $render_slug)
    {
		$this->handle_fa_icon();
		$title_level  = $this->props['title_level'];
		$sub_title_level  = $this->props['sub_title_level'];
		$title_url = isset($this->props['title_url']) ? $this->props['title_url'] : '';
		$title_url_target = $this->props['title_url_new_tab'] === 'on'  ?
				'target="_blank"' : '';
		$title_element_with_link =  $this->props['title'] !== '' ?
					sprintf('<a href="%1$s" class="df_ab_title_link" %3$s >%2$s</a>',
						$title_url,
						$this->props['title'],
						$title_url_target
				) : '';

		$title_html = $this->props['title'] !== '' ?
				sprintf('<%1$s  class="df_ab_blurb_title">%2$s</%1$s >',
				et_pb_process_header_level($title_level, 'h4'),
				!empty ( $this->props['title_url'] ) ? $title_element_with_link  : $this->props['title'] ) :  '';

		$sub_title_html = $this->props['sub_title'] !== '' ?
				sprintf('<%1$s  class="df_ab_blurb_sub_title">%2$s</%1$s >', et_pb_process_header_level($sub_title_level, 'h6'), $this->props['sub_title']) : '';
		$content = $this->props['content'] !== '' ?
				sprintf('<div class="df_ab_blurb_description">%1$s</div>', $this->props['content']) : '';

		$badge_text_1_html = ( $this->props['badge_enable']==='on' && $this->props['badge'] !== '' ) ?
				sprintf('<span class="badge_text_1">%1$s</span>', $this->props['badge']) : '';

		$badge_text_2_html = ( $this->props['badge_enable']==='on' && $this->props['badge_text_2'] !== '' ) ?
				sprintf('<span class="badge_text_2">%1$s</span>', $this->props['badge_text_2']) : '';

		$badge_text_html = ( $this->props['badge'] !== '' && $this->props['badge_icon_enable'] !== 'on') ?
				sprintf('<span class="badge_text_wrapper">
										%1$s
										%2$s
								</span>
								',  $badge_text_1_html, $badge_text_2_html) : '';

		$badge_html = ( $this->props['badge_enable']==='on' ) ?
		sprintf('<div class="df_ab_blurb_badge_wrapper">
								<div class="df_ab_blurb_badge">
										%2$s
										%1$s
								</div>
						</div>',  $badge_text_html , $this->df_render_badge_icon()) : '';

		$this->additional_css_styles($render_slug);

		// filter for images


		if (array_key_exists('image', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['image'])) {
			$this->add_classname($this->generate_css_filters(
				$render_slug,
				'child_',
				self::$data_utils->array_get($this->advanced_fields['image']['css'], 'main', '%%order_class%%')
			));
		 }

        $placement_class = ($this->props['image_placement'] !== '' && $this->props['blurb_icon_enable'] === 'off') ? 'placement_image_' . $this->props['image_placement'] : 'placement_icon_' . $this->props['image_placement'];
        $icon_available_class = ($this->props['blurb_icon_enable'] === 'on' && $this->props['image_placement'] ==='flex_top') ? 'icon' : 'image';

        $image_html  = sprintf('<div class="df_ab_blurb_image %3$s %2$s">%1$s</div>', $this->df_render_image_icon(), $placement_class, $icon_available_class);

        if ( 'outside'!== $this->props['image_icon_container_position']  ) {
            $html_code = '<div class="df_ab_blurb_container"> <div class="df_ab_blurb_content_container">%2$s %3$s %4$s %1$s %5$s %6$s</div></div>';
        } else {
            $html_code = '<div class="df_ab_blurb_container"> %2$s<div class="df_ab_blurb_content_container"> %3$s %4$s %1$s %5$s %6$s</div></div>';
        }

        return sprintf($html_code, $content, $image_html, $title_html, $sub_title_html, $this->df_render_button() , $badge_html);
    }
}

new DIFL_AdvancedBlurb;
