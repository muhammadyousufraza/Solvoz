<?php

class DIFL_TestimonialCarousel extends ET_Builder_Module {
    public $slug       = 'difl_testimonialcarousel';
    public $vb_support = 'on';
    public $child_slug = 'difl_testimonialcarouselitem';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Testimonial Carousel', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/test-carousel.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'carousel_settings'     => esc_html__('Carousel settings', 'divi_flash'),
                    'advanced_settings'     => esc_html__('Coverflow Settings', 'divi_flash'),
                    'item_order'            => esc_html__('Items Order', 'divi_flash'),
                    'text_bg'               => esc_html__('Text Area Background', 'divi_flash'),
                    'author_bg'             => esc_html__('Author Box Background', 'divi_flash'),
                    'rating_bg'             => esc_html__('Rating Container Background', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'brand_logo'                => esc_html__('Brand Logo', 'divi_flash'),
                    'author_image'              => esc_html__('Author Image', 'divi_flash'),
                    'author_box'                => esc_html__('Author Box Settings', 'divi_flash'),
                    'font'                      => array (
                        'title'         => esc_html__('Font Style', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'name'   => array(
                                'name' => 'Name'
                            ),
                            'title'     => array(
                                'name' => 'Title',
                            ),
                            'company'     => array(
                                'name' => 'Company',
                            ),
                            'body'     => array(
                                'name' => 'Body',
                            )
                        )
                    ),
                    'arrows'                    => esc_html__('Arrows', 'divi_flash'),
                    'dots'                      => esc_html__('Dots', 'divi_flash'),
                    'rating'                    => esc_html__('Rating', 'divi_flash'),
                    'quote_icon'                => esc_html__('Quote Icon & Image', 'divi_flash'),
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

        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = array (
            'name'     => array(
                'label'         => esc_html__( 'Name', 'divi_flash' ),
                'toggle_slug'   => 'font',
                'sub_toggle'    => 'name',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'header_level' => array(
	                'default' => 'h4',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_tc_author_info .author_name",
                    'hover' => "%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_author_info .author_name",
                    'important'	=> 'all'
                ),
            ),
            'title'     => array(
                'label'         => esc_html__( 'Job Title', 'divi_flash' ),
                'toggle_slug'   => 'font',
                'sub_toggle'    => 'title',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .tc_job_title",
                    'hover' => "%%order_class%% .difl_testimonialcarouselitem:hover .tc_job_title",
                    'important'	=> 'all'
                ),
            ),
            'company'     => array(
                'label'         => esc_html__( 'Company', 'divi_flash' ),
                'toggle_slug'   => 'font',
                'sub_toggle'    => 'company',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .tc_company",
                    'hover' => "%%order_class%% .difl_testimonialcarouselitem:hover .tc_company",
                    'important'	=> 'all'
                ),
            ),
            'body'     => array(
                'label'         => esc_html__( 'Body', 'divi_flash' ),
                'toggle_slug'   => 'font',
                'sub_toggle'    => 'body',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_tc_content",
                    'hover' => "%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_content",
                    'important'	=> 'all'
                ),
            ),
        );
        $advanced_fields['borders'] = array (
            'default'             => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .difl_testimonialcarouselitem > div:first-child',
                        'border_radii_hover' => '%%order_class%% .difl_testimonialcarouselitem > div:first-child:hover',
                        'border_styles' => '%%order_class%% .difl_testimonialcarouselitem > div:first-child',
                        'border_styles_hover' => '%%order_class%% .difl_testimonialcarouselitem > div:first-child:hover',
                    )
                )
            ),
            'logo'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_tc_company_logo img',
                        'border_radii_hover' => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_company_logo img',
                        'border_styles' => '%%order_class%% .df_tc_company_logo img',
                        'border_styles_hover' => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_company_logo img',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'brand_logo'
            ),
            'author_image'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_tc_author_image img',
                        'border_radii_hover' => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_author_image img',
                        'border_styles' => '%%order_class%% .df_tc_author_image img',
                        'border_styles_hover' => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_author_image img',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'author_image'
            ),
            'author_box'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_tc_author_box',
                        'border_radii_hover' => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_author_box',
                        'border_styles' => '%%order_class%% .df_tc_author_box',
                        'border_styles_hover' => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_author_box',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'author_box'
            ),
        );
        $advanced_fields['box_shadow'] = array (
            'default' => array (
                'css' => array(
                    'main' => "%%order_class%% .difl_testimonialcarouselitem > div:first-child",
                    'hover' => "%%order_class%% .difl_testimonialcarouselitem > div:first-child:hover",
                )
            ),
            'logo' => array(
                'css' => array(
                    'main' => "%%order_class%% .df_tc_company_logo img",
                    'hover' => "%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_company_logo img",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'brand_logo'
            ),
            'author_image' => array(
                'css' => array(
                    'main' => "%%order_class%% .df_tc_author_image img",
                    'hover' => "%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_author_image img",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'author_image'
            ),
            'author_box' => array(
                'css' => array(
                    'main' => "%%order_class%% .df_tc_author_box",
                    'hover' => "%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_author_box",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'author_box'
            ),
            'quote_icon' => array(
                'css' => array(
                    'main' => "%%order_class%% .df_tc_quote_image span, %%order_class%% .df_tc_quote_image img",
                    'hover' => "%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_quote_image img,
                        %%order_class%% .difl_testimonialcarouselitem:hover .df_tc_quote_image span",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'quote_icon'
            ),
            'arrow' => array(
                'css' => array(
                    'main' => "%%order_class%% .df_tc_arrows > div",
                    'hover' => "%%order_class%% .df_tc_arrows > div:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows'
            )
        );

        $advanced_fields['background'] = array (
            'css' => array (
                'main'  => "{$this->main_css_element} .difl_testimonialcarouselitem > div:first-child"
            )
        );
        $advanced_fields['filters'] = false;
        $advanced_fields['transform'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['animation'] = false;

        return $advanced_fields;
    }

    public function get_fields() {
        $general = array ();
        $item_order = array (
            'quote_order' => array (
                'label'             => esc_html__( 'Quote Order', 'divi_flash' ),
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
            'logo_order' => array (
                'label'             => esc_html__( 'Company Logo Order', 'divi_flash' ),
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
            'text_order' => array (
                'label'             => esc_html__( 'Testimonial Content Order', 'divi_flash' ),
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
            'author_order' => array (
                'label'             => esc_html__( 'Author Box Order', 'divi_flash' ),
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
            'rating_order' => array (
                'label'             => esc_html__( 'Rating Order', 'divi_flash' ),
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
        $author_box = array (
            'author_image_position'    => array (
                'default'         => 'left',
                'label'           => esc_html__( 'Author Image Position', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'top'                   => esc_html__( 'Top', 'divi_flash' ),
                    'left'                  => esc_html__( 'Left', 'divi_flash' ),
                    'bottom'                => esc_html__( 'Bottom', 'divi_flash' ),
                    'right'                 => esc_html__( 'Right', 'divi_flash' )
                ),
                'toggle_slug'     => 'author_box',
                'tab_slug'		  => 'advanced'
            ),
            'auther_alignhr'    => array (
                'default'         => 'center',
                'label'           => esc_html__( 'Horizontal Alignment', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'center'                => esc_html__( 'Center', 'divi_flash' ),
                    'flex-start'            => esc_html__( 'Left', 'divi_flash' ),
                    'flex-end'              => esc_html__( 'Right', 'divi_flash' )
                ),
                'toggle_slug'     => 'author_box',
                'tab_slug'		  => 'advanced'
            ),
            'info_align' => array (
                'label'             => esc_html__( 'Text Alignment', 'divi_flash' ),
				'type'              => 'text_align',
				'options'           => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'       => 'author_box',
                'tab_slug'		    => 'advanced'
            )
        );

        $carousel_settings = array (
            'carousel_type'   => array (
                'label'             => esc_html__('Carousel Type', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
					'slide'         => esc_html__( 'Slide', 'divi_flash' ),
					'coverflow'     => esc_html__( 'Coverflow', 'divi_flash' )
                ),
                'default'           => 'slide',
                'toggle_slug'       => 'carousel_settings'
            ),
            'item_desktop'    => array (
                'label'             => esc_html__( 'Max Slide Desktop', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '3',
                'default_unit'      => '',
                'allowed_units'     => array (''),
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '7',
					'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if_not'       => array (
                    'variable_width' => 'on',
                    'carousel_type'  => array ('cube', 'flip')
                )
            ),
            'item_tablet'    => array (
                'label'             => esc_html__( 'Max Slide Tablet', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '2',
                'default_unit'      => '',
                'allowed_units'     => array (''),
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '7',
					'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if_not'       => array (
                    'variable_width' => 'on',
                    'carousel_type'  => array ('cube', 'flip')
                )
            ),
            'item_mobile'    => array (
                'label'             => esc_html__( 'Max Slide Mobile', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '1',
                'default_unit'      => '',
                'allowed_units'     => array (''),
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '7',
					'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if_not'       => array (
                    'variable_width' => 'on',
                    'carousel_type'  => array ('cube', 'flip')
                )
            ),
            'item_spacing'    => array (
                'label'             => esc_html__( 'Spacing (px)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '30px',
                'default_unit'      => 'px',
                'allowed_units'     => array ('px'),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '200',
					'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if_not'       => array (
                    'carousel_type'  => array ('cube', 'flip')
                )
            ),
            'speed'    => array (
                'label'             => esc_html__( 'Speed (ms)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '500',
                'default_unit'      => '',
                'allowed_units'     => array (''),
				'range_settings'    => array(
					'min'  => '100',
					'max'  => '30000',
					'step' => '50',
                ),
                'validate_unit'     => false
            ),
            'centered_slides'    => array (
                'label'             => esc_html__('Centered Slides', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if_not'       => array (
                    'carousel_type'  => array ('cube', 'flip')
                )
            ),
            'loop'    => array (
                'label'             => esc_html__('Loop', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings'
            ),
            'autoplay'    => array (
                'label'             => esc_html__('Autoplay', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'affects'           => [
                    'autospeed',
                    'pause_hover'
                ]
            ),
            'autospeed'    => array (
                'label'             => esc_html__( 'Autoplay Speed (ms)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '2000',
                'default_unit'      => '',
                'allowed_units'     => array (''),
				'range_settings'    => array(
					'min'  => '100',
					'max'  => '10000',
					'step' => '50',
                ),
                'validate_unit'     => false,
                'depends_show_if'   => 'on'
            ),
            'pause_hover'    => array (
                'label'             => esc_html__('Pause On Hover', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'depends_show_if'   => 'on'
            ),
            'arrow'    => array (
                'label'             => esc_html__('Arrow Navigation', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings'
            ),
            'dots'    => array (
                'label'             => esc_html__('Dot Navigation', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if_not'       => array (
                    'carousel_type'  => array ('cube', 'flip')
                )
            ),
            'equal_height'    => array (
                'label'             => esc_html__('Equal Height Item', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings'
            )
        );

        $coverflow_effect = array (
            'coverflow_shadow'    => array (
                'label'             => esc_html__('Enables slides shadows', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'advanced_settings',
                'show_if'           => array (
                    'carousel_type'  => 'coverflow'
                )
            ),
            'coverflow_rotate'    => array (
                'label'             => esc_html__( 'Slide rotate in degrees', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'advanced_settings',
                'default'           => '30',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if'           => array (
                    'carousel_type'  => 'coverflow'
                )
            ),
            'coverflow_stretch'    => array (
                'label'             => esc_html__( 'Stretch space between slides (in px)', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'advanced_settings',
                'default'           => '0',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if'           => array (
                    'carousel_type'  => 'coverflow'
                )
            ),
            'coverflow_depth'    => array (
                'label'             => esc_html__( 'StreDepth offset in px (slides translate in Z axis)', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'advanced_settings',
                'default'           => '100',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if'           => array (
                    'carousel_type'  => 'coverflow'
                )
            ),
            'coverflow_modifier'    => array (
                'label'             => esc_html__( 'Effect multipler', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'advanced_settings',
                'default'           => '1',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '8',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if'           => array (
                    'carousel_type'  => 'coverflow'
                )
            ),
            'coveflow_color_dark' => array (
                'label'             => esc_html__( 'Shadow color dark', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'advanced_settings',
                'tab_slug'          => 'general',
                'show_if'           => array(
                    'carousel_type'  => 'coverflow',
                    'coverflow_shadow' => 'on'
                ),
                'default'           => 'rgba(0,0,0,1)'
            ),
            'coveflow_color_light' => array (
                'label'             => esc_html__( 'Shadow color light', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'advanced_settings',
                'tab_slug'          => 'general',
                'show_if'           => array(
                    'carousel_type'  => 'coverflow',
                    'coverflow_shadow' => 'on'
                ),
                'default'           => 'rgba(0,0,0,0)'
            )
        );

        $image_settings = array (
            'author_image_width' => array (
                'label'             => esc_html__( 'Author Image Max Width', 'divi_flash' ),
				'type'              => 'range',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'author_image',
				'default'           => '100px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '500',
					'step' => '1',
                ),
                'mobile_options'    => true,
                'responsive'        => true
            ),
            'brand_align' => array (
                'label'             => esc_html__( 'Alignment', 'divi_flash' ),
				'type'              => 'text_align',
				'options'           => et_builder_get_text_orientation_options(array('justified')),
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'brand_logo'
            ),
            'brand_width' => array (
                'label'             => esc_html__( 'Max Width', 'divi_flash' ),
				'type'              => 'range',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'brand_logo',
				'default'           => '150px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '300',
					'step' => '1',
                )
            )
        );

        $arrows = array (
            'arrow_color' => array (
                'default'           => "#007aff",
				'label'             => esc_html__( 'Arrow icon color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
                'hover'             => 'tabs'
            ),
            'arrow_background' => array (
                'default'           => "#ffffff",
				'label'             => esc_html__( 'Arrow background', 'divi_flash' ),
				'type'              => 'color-alpha',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
                'hover'             => 'tabs'
            ),
            'arrow_position'    => array (
                'default'         => 'middle',
                'label'           => esc_html__( 'Arrow Position', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'top'           => esc_html__( 'Top', 'divi_flash' ),
                    'middle'        => esc_html__( 'Middle', 'divi_flash' ),
                    'bottom'        => esc_html__( 'Bottom', 'divi_flash' )
                ),
                'mobile_options'    => true,
                'toggle_slug'     => 'arrows',
                'tab_slug'        => 'advanced'
            ),
            'arrow_align'    => array (
                'default'         => 'space-between',
                'label'           => esc_html__( 'Arrow Alignment', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'flex-start'            => esc_html__( 'Left', 'divi_flash' ),
                    'center'                => esc_html__( 'Center', 'divi_flash' ),
                    'flex-end'              => esc_html__( 'Right', 'divi_flash' ),
                    'space-between'         => esc_html__( 'Justified', 'divi_flash' )
                ),
                'mobile_options'    => true,
                'toggle_slug'     => 'arrows',
                'tab_slug'        => 'advanced'
            ),
            'arrow_opacity'    => array (
                'label'             => esc_html__( 'Opacity', 'divi_flash' ),
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
            'arrow_circle'    => array (
                'label'             => esc_html__('Circle Arrow', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'arrows',
                'tab_slug'          => 'advanced'
            )
        );
        $arrow_prev_icon = $this->df_add_icon_settings(array (
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
        $arrow_next_icon = $this->df_add_icon_settings(array (
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
        $dots = array (
            'dots_align'    => array (
                'label'             => esc_html__('Alignment', 'divi_flash'),
                'type'              => 'text_align',
                'options'           => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'       => 'dots',
                'tab_slug'          => 'advanced',
                'mobile_options'    => true,
                'responsive'        => true
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
            'dots_color' => array (
                'default'           => "#c7c7c7",
				'label'             => esc_html__( 'Dots color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dots',
                'hover'             => 'tabs'
            ),
            'active_dots_color' => array (
                'default'           => "#007aff",
				'label'             => esc_html__( 'Active dots color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dots',
                'hover'             => 'tabs'
            )
        );
        $rating = array (
            'rating_color' => array (
                'default'           => "#ffd700",
				'label'             => esc_html__( 'Rating Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'rating'
            ),
            'rating_align' => array (
                'label'             => esc_html__( 'Alignment', 'divi_flash' ),
				'type'              => 'text_align',
				'options'           => et_builder_get_text_orientation_options(array('justified')),
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'rating'
            ),
            'rating_size' => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'rating',
				'default'           => '18px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '50',
					'step' => '1',
                )
            ),
            'rating_space' => array (
                'label'             => esc_html__( 'Rating Space Between', 'divi_flash' ),
				'type'              => 'range',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'rating',
				'default'           => '0px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '20',
					'step' => '1',
                )
            )
        );
        $quote_icon = array (
            'qoute_align' => array (
                'label'             => esc_html__( 'Alignment', 'divi_flash' ),
				'type'              => 'text_align',
				'options'           => et_builder_get_text_orientation_options(array('justified')),
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'quote_icon'
            ),
            'quote_icon_size'    => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'quote_icon',
                'tab_slug'          => 'advanced',
                'default'           => '20px',
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options'    => true,
				'responsive'        => true
            ),
            'quote_icon_color' => array (
                'default'           => "#007aff",
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'quote_icon',
                'hover'             => 'tabs'
            ),
            'quote_icon_bgcolor' => array (
                'default'           => "rgba(0,0,0,0)",
				'label'             => esc_html__( 'Icon Background Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'quote_icon',
                'hover'             => 'tabs'
            ),
            'quote_image_max'    => array (
                'label'             => esc_html__( 'Image Max Width', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'quote_icon',
                'tab_slug'          => 'advanced',
                'default'           => '50px',
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '200',
                    'step' => '1',
                ),
                'mobile_options'    => true,
				'responsive'        => true
            ),
            'quote_opacity'    => array (
                'label'             => esc_html__( 'Opacity', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'quote_icon',
                'tab_slug'          => 'advanced',
                'default'           => '1',
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '1',
                    'step' => '.01',
                ),
                'validate_unit'     => false
            ),
            'quote_z_index'    => array (
                'label'             => esc_html__( 'Quote Z-index', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'quote_icon',
                'tab_slug'          => 'advanced',
                'default'           => '2',
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '15',
                    'step' => '1',
                ),
                'validate_unit'     => false
            )
        );

        $wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Wrapper',
            'key'           => 'wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $itemwrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Item Wrapper',
            'key'           => 'item_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $author_box_spacing = $this->add_margin_padding(array(
            'title'         => 'Author Box',
            'key'           => 'author_box',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $rating_spacing = $this->add_margin_padding(array(
            'title'         => 'Rating',
            'key'           => 'rating',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        $text_spacing = $this->add_margin_padding(array(
            'title'         => 'Text',
            'key'           => 'text',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        $logo_spacing = $this->add_margin_padding(array(
            'title'         => 'Brand Logo',
            'key'           => 'logo',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content',
            'option'        => 'margin'
        ));
        $author_image_spacing = $this->add_margin_padding(array(
            'title'         => 'Author Image',
            'key'           => 'author_image',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content',
            'option'        => 'margin'
        ));
        $quote_icon_spacing = $this->add_margin_padding(array(
            'title'         => 'Quote Icon',
            'key'           => 'quote_icon',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        $quote_icon_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Quote Wrapper',
            'key'           => 'quote_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $text_bg = $this->df_add_bg_field(array (
			'label'				    => 'Text Area Background',
            'key'                   => 'text_bg',
            'toggle_slug'           => 'text_bg',
            'tab_slug'              => 'general'
        ));
        $author_bg = $this->df_add_bg_field(array (
			'label'				    => 'Text Area Background',
            'key'                   => 'author_bg',
            'toggle_slug'           => 'author_bg',
            'tab_slug'              => 'general'
        ));
        $rating_bg = $this->df_add_bg_field(array (
			'label'				    => 'Text Area Background',
            'key'                   => 'rating_bg',
            'toggle_slug'           => 'rating_bg',
            'tab_slug'              => 'general'
        ));


        return array_merge(
            $general,
            $item_order,
            $author_box,
            $carousel_settings,
            $coverflow_effect,
            $image_settings,
            $arrow_prev_icon,
            $arrow_next_icon,
            $arrows,
            $arrow_prev_spacing,
            $arrow_next_spacing,
            $dots,
            $rating,
            $quote_icon,
            $wrapper_spacing,
            $itemwrapper_spacing,
            $author_box_spacing,
            $rating_spacing,
            $text_spacing,
            $logo_spacing,
            $author_image_spacing,
            $quote_icon_spacing,
            $text_bg,
            $author_bg,
            $rating_bg,
            $quote_icon_wrapper_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        // border fix
        // fix border transition
        $fields = $this->df_fix_border_transition(
            $fields,
            'logo',
            '%%order_class%% .df_tc_company_logo img'
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'author_image',
            '%%order_class%% .df_tc_author_image img'
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'author_box',
            '%%order_class%% .df_tc_author_box'
        );

        // background
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'text_bg',
            'selector'      => '%%order_class%% .df_tc_content'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'author_bg',
            'selector'      => '%%order_class%% .df_tc_author_box'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'rating_bg',
            'selector'      => '%%order_class%% .df_tc_ratings'
        ));
        // color, opacity & background-color
        $fields['arrow_color'] = array ('color' => '%%order_class%% .df_tc_arrows div:after');
        $fields['arrow_background'] = array ('background-color' => '%%order_class%% .df_tc_arrows div');
        $fields['arrow_opacity'] = array ('opacity' => '%%order_class%% .df_tc_arrows div');
        $fields['arrow_opacity_disable'] = array ('opacity' => '%%order_class%% .df_tc_arrows div.swiper-button-disabled');

        $fields['dots_color'] = array ('background' => '%%order_class%% .swiper-pagination span');
        $fields['active_dots_color'] = array ('background' => '%%order_class%% .swiper-pagination span.swiper-pagination-bullet-active');

        $fields['quote_icon_color'] = array ('color' => '%%order_class%% .df_tci_container .df_tc_quote_icon:before');
        $fields['quote_icon_bgcolor'] = array ('background-color' => '%%order_class%% .df_tci_container .df_tc_quote_icon');
        // spacing
        $fields['wrapper_margin'] = array ('margin' => '%%order_class%% .swiper-container');
        $fields['wrapper_padding'] = array ('padding' => '%%order_class%% .swiper-container');

        $fields['item_wrapper_margin'] = array ('margin' => '%%order_class%% .df_tci_container');
        $fields['item_wrapper_padding'] = array ('padding' => '%%order_class%% .df_tci_container');

        $fields['author_box_margin'] = array ('margin' => '%%order_class%% .df_tc_author_box');
        $fields['author_box_padding'] = array ('padding' => '%%order_class%% .df_tc_author_box');

        $fields['rating_margin'] = array ('margin' => '%%order_class%% .df_tc_ratings');
        $fields['rating_padding'] = array ('padding' => '%%order_class%% .df_tc_ratings');

        $fields['text_margin'] = array ('margin' => '%%order_class%% .df_tc_content');
        $fields['text_padding'] = array ('padding' => '%%order_class%% .df_tc_content');

        $fields['logo_margin'] = array ('margin' => '%%order_class%% .df_tc_company_logo img');
        $fields['author_image_margin'] = array ('margin' => '%%order_class%% .df_tc_author_image img');

        $fields['quote_icon_margin'] = array ('margin' => '%%order_class%% .df_tc_quote_image img');
        $fields['quote_icon_padding'] = array ('padding' => '%%order_class%% .df_tc_quote_image img');
        $fields['quote_icon_margin'] = array ('margin' => '%%order_class%% .df_tc_quote_image span');
        $fields['quote_icon_padding'] = array ('padding' => '%%order_class%% .df_tc_quote_image span');
        $fields['quote_wrapper_margin'] = array ('margin' => '%%order_class%% .df_tc_quote_image');
        $fields['quote_wrapper_padding'] = array ('padding' => '%%order_class%% .df_tc_quote_image');

        $fields['arrow_prev_margin'] = array ('margin' => '%%order_class%% .df_tc_arrows .swiper-button-prev');
        $fields['arrow_prev_padding'] = array ('padding' => '%%order_class%% .df_tc_arrows .swiper-button-prev');
        $fields['arrow_next_margin'] = array ('margin' => '%%order_class%% .df_tc_arrows .swiper-button-next');
        $fields['arrow_next_padding'] = array ('padding' => '%%order_class%% .df_tc_arrows .swiper-button-next');

        return $fields;
    }

    public function additional_css_styles($render_slug) {

        // coverflow shadows
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .swiper-container-3d .swiper-slide-shadow-left',
            'declaration' => sprintf('background-image: linear-gradient(to left,%1$s,%2$s);',
                $this->props['coveflow_color_dark'],
                $this->props['coveflow_color_light']
            )
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .swiper-container-3d .swiper-slide-shadow-right',
            'declaration' => sprintf('background-image: linear-gradient(to right,%1$s,%2$s);',
                $this->props['coveflow_color_dark'],
                $this->props['coveflow_color_light']
            )
        ));
        // item order
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'quote_order',
            'type'              => 'order',
            'selector'          => '%%order_class%% .df_tc_quote_image'
        ) );
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'logo_order',
            'type'              => 'order',
            'selector'          => '%%order_class%% .df_tc_company_logo'
        ) );
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'text_order',
            'type'              => 'order',
            'selector'          => '%%order_class%% .df_tc_content'
        ) );
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'author_order',
            'type'              => 'order',
            'selector'          => '%%order_class%% .df_tc_author_box'
        ) );
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_order',
            'type'              => 'order',
            'selector'          => '%%order_class%% .df_tc_ratings'
        ) );
        // author box
        // author image position
        if ( $this->props['author_image_position'] === 'top' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_author_box',
                'declaration' => 'flex-direction: column;',
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_author_image',
                'declaration' => 'margin-left:0;margin-right:0;',
            ));
        }
        if ( $this->props['author_image_position'] === 'bottom' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_author_box',
                'declaration' => 'flex-direction: column;',
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_author_image',
                'declaration' => 'order: 2; margin-left:0; margin-right:0;',
            ));
        }
        if ( $this->props['author_image_position'] === 'right' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_author_image',
                'declaration' => 'order: 2;margin-left:0; margin-right:10px;',
            ));
        }
        if (isset($this->props['auther_alignhr'])) {
            if ($this->props['author_image_position'] === 'top' || $this->props['author_image_position'] === 'bottom') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_tc_author_box',
                    'declaration' => sprintf('align-items: %1$s;', $this->props['auther_alignhr']),
                ));
            } else {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_tc_author_box',
                    'declaration' => sprintf('justify-content: %1$s;', $this->props['auther_alignhr']),
                ));
            }
        }
        if (isset($this->props['info_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_author_info',
                'declaration' => sprintf('text-align: %1$s;', $this->props['info_align']),
            ));
        }
        // dots colors
        if ($this->props['large_active_dot'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination .swiper-pagination-bullet-active',
                'declaration' => 'width: 40px; border-radius: 20px;'
            ));
        }
        $this->df_process_color( array(
            'render_slug'       => $render_slug,
            'slug'              => 'dots_color',
            'type'              => 'background',
            'selector'          => '%%order_class%% .swiper-pagination span',
            'hover'             => '%%order_class%% .swiper-pagination span:hover'
        ) );
        $this->df_process_color( array(
            'render_slug'       => $render_slug,
            'slug'              => 'active_dots_color',
            'type'              => 'background',
            'selector'          => '%%order_class%% .swiper-pagination span.swiper-pagination-bullet-active',
            'hover'             => '%%order_class%% .swiper-pagination span.swiper-pagination-bullet-active:hover'
        ) );
        if (isset($this->props['dots_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination',
                'declaration' => sprintf('text-align: %1$s;', $this->props['dots_align'])
            ));
        }
        if (isset($this->props['dots_align_tablet'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination',
                'declaration' => sprintf('text-align: %1$s;', $this->props['dots_align_tablet']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }
        if (isset($this->props['dots_align_phone'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination',
                'declaration' => sprintf('text-align: %1$s;', $this->props['dots_align_phone']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
        // arrow
        if ($this->props['arrow'] === 'on') {
            $pos = isset($this->props['arrow_position']) ? $this->props['arrow_position'] : 'middle';
            $pos_tab = isset($this->props['arrow_position_tablet']) && $this->props['arrow_position_tablet'] !== ''?
                $this->props['arrow_position_tablet'] : $pos;
            $pos_ph = isset($this->props['arrow_position_phone']) && $this->props['arrow_position_phone'] !== '' ?
                $this->props['arrow_position_phone'] : $pos_tab;
            $a_align = isset($this->props['arrow_align']) ? $this->props['arrow_align'] : 'space-between';
            $a_align_tab = isset($this->props['arrow_align_tablet']) ? $this->props['arrow_align_tablet'] : $a_align;
            $a_align_ph = isset($this->props['arrow_align_phone']) ? $this->props['arrow_align_phone'] : $a_align_tab;

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
            // alignment
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
            if ($this->props['arrow_circle'] === 'on') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_tc_arrows > div',
                    'declaration' => 'border-radius: 50%;'
                ));
            }
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_opacity',
                'type'              => 'opacity',
                'selector'          => '%%order_class%% .df_tc_arrows div',
                'hover'             => '%%order_class%%:hover .df_tc_arrows div'
            ) );
            if( 'on' !== $this->props['loop'] ){
                $this->df_process_range( array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'arrow_opacity_disable',
                    'type'              => 'opacity',
                    'selector'          => '%%order_class%% .df_tc_arrows div.swiper-button-disabled',
                    'hover'             => '%%order_class%%:hover .df_tc_arrows div.swiper-button-disabled'
                ) );
            }
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df_tc_arrows .swiper-button-prev',
                'hover'             => '%%order_class%%:hover .df_tc_arrows .swiper-button-prev',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df_tc_arrows .swiper-button-prev',
                'hover'             => '%%order_class%%:hover .df_tc_arrows .swiper-button-prev',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df_tc_arrows .swiper-button-next',
                'hover'             => '%%order_class%%:hover .df_tc_arrows .swiper-button-next',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df_tc_arrows .swiper-button-next',
                'hover'             => '%%order_class%%:hover .df_tc_arrows .swiper-button-next',
            ));
            // arrow colors
            $this->df_process_color( array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_color',
                'type'              => 'color',
                'selector'          => '%%order_class%% .df_tc_arrows div:after',
                'hover'             => '%%order_class%%:hover .df_tc_arrows div:after'
            ) );
            $this->df_process_color( array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_background',
                'type'              => 'background-color',
                'selector'          => '%%order_class%% .df_tc_arrows div',
                'hover'             => '%%order_class%%:hover .df_tc_arrows div'
            ) );
            // arrow icon styles
            $this->process_icon_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_icon',
                'selector'          => '%%order_class%% .df_tc_arrows div.swiper-button-prev:after'
            ));
            $this->process_icon_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_icon',
                'selector'          => '%%order_class%% .df_tc_arrows div.swiper-button-next:after'
            ));
        }

        // rating
        $this->df_process_color( array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df_tc_ratings span.et-pb-icon.df_rating_icon_fill'
        ) );
        if (isset($this->props['rating_align'])) {

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_ratings',
                'declaration' => sprintf('justify-content: %1$s;', $this->props['rating_align']),
            ));
        }
        if (isset($this->props['rating_size'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_ratings span.et-pb-icon',
                'declaration' => sprintf('font-size: %1$s;', $this->props['rating_size']),
            ));
        }
        if (isset($this->props['rating_space'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_ratings span',
                'declaration' => sprintf('margin-right: %1$s;', $this->props['rating_space']),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_ratings span:last-child',
                'declaration' => 'margin-right: 0;',
            ));
        }

        // image settings
        if (isset($this->props['brand_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_company_logo',
                'declaration' => sprintf('text-align: %1$s;', $this->props['brand_align']),
            ));
        }
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'brand_width',
            'type'              => 'max-width',
            'selector'          => '%%order_class%% .df_tc_company_logo img'
        ) );
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'author_image_width',
            'type'              => 'max-width',
            'selector'          => '%%order_class%% .df_tc_author_image'
        ) );

        //spacing
        // wrapper spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .swiper-container',
            'hover'             => '%%order_class%% .swiper-container:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .swiper-container',
            'hover'             => '%%order_class%% .swiper-container:hover'
        ));
        // item wrapper spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tci_container',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tci_container'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_tci_container',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tci_container'
        ));
        // author box spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'author_box_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_author_box',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_author_box'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'author_box_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_tc_author_box',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_author_box'
        ));
        // rating spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_ratings',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_ratings'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_tc_ratings',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_ratings'
        ));
        // text spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'text_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_content',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_content'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'text_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_tc_content',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_content'
        ));
        // image spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'logo_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_company_logo img',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_company_logo img'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'author_image_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_author_image img',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_author_image img'
        ));
        // quote icon
        if (isset($this->props['qoute_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_tc_quote_image',
                'declaration' => sprintf('text-align: %1$s;', $this->props['qoute_align']),
            ));
        }
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'quote_icon_size',
            'type'              => 'font-size',
            'selector'          => '%%order_class%% .df_tc_quote_icon'
        ) );
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'quote_image_max',
            'type'              => 'max-width',
            'selector'          => '%%order_class%% .df_tc_quote_image img'
        ) );
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'quote_z_index',
            'type'              => 'z-index',
            'selector'          => '%%order_class%% .df_tc_quote_image, %%order_class%% .df_tc_quote_icon'
        ) );
        $this->df_process_color( array(
            'render_slug'       => $render_slug,
            'slug'              => 'quote_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df_tci_container .df_tc_quote_icon',
            'hover'             => '%%order_class%% .df_tci_container:hover .df_tc_quote_icon'
        ) );
        $this->df_process_color( array(
            'render_slug'       => $render_slug,
            'slug'              => 'quote_icon_bgcolor',
            'type'              => 'background-color',
            'selector'          => '%%order_class%% .df_tci_container .df_tc_quote_icon',
            'hover'             => '%%order_class%% .df_tci_container:hover .df_tc_quote_icon'
        ) );

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'quote_icon_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_quote_image img',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_quote_image img'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'quote_icon_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_tc_quote_image img',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_quote_image img'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'quote_icon_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_quote_image span',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_quote_image span'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'quote_icon_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_tc_quote_image span',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_quote_image span'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'quote_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_tc_quote_image',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_quote_image'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'quote_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_tc_quote_image',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_quote_image'
        ));
        // background
        if(isset($this->props['background_repeat']) && 'no-repeat' === $this->props['background_repeat']){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .difl_testimonialcarouselitem > div:first-child',
                'declaration' => 'background-repeat: inherit;',
            ));
        }

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'text_bg',
            'selector'          => '%%order_class%% .df_tc_content',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_content'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'author_bg',
            'selector'          => '%%order_class%% .df_tc_author_box',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_author_box'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'rating_bg',
            'selector'          => '%%order_class%% .df_tc_ratings',
            'hover'             => '%%order_class%% .difl_testimonialcarouselitem:hover .df_tc_ratings'
        ));
        // equal height
        if ($this->props['equal_height'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .difl_testimonialcarouselitem.et_pb_module',
                'declaration' => 'align-self: auto;',
            ));
        }
        // quote opacity
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df_tc_quote_icon',
            'declaration' => sprintf('opacity: %1$s;', $this->props['quote_opacity']),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df_tc_quote_image',
            'declaration' => sprintf('opacity: %1$s;', $this->props['quote_opacity']),
        ));

        if($this->props['arrow_opacity'] !== '0') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%  .arrow-middle .df_tc_arrows *',
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

    public function render( $attrs, $content, $render_slug ) {
        if ( $this->content === '' ) {
            return sprintf(
                '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Testimonial Item.</strong></h2>'
            );
        }

        wp_enqueue_script('swiper-script');
        wp_enqueue_script('df-testcarousel');
        $this->additional_css_styles($render_slug);

        $order_class 	= self::get_module_order_class( $render_slug );
        $order_number	= str_replace('_','',str_replace($this->slug,'', $order_class));
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
            'auto_delay' => $this->props['autospeed'],
            'speed' => $this->props['speed'],
            'pause_hover' => $this->props['pause_hover'],
            'centeredSlides' => $this->props['centered_slides'],
            'order' => $order_number,
	        'author_tag' => !empty($this->props['name_level']) ? $this->props['name_level'] : 'h4'
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

        return sprintf('<div class="df_tc_container%8$s" data-settings=\'%2$s\' data-item="%5$s" data-itemtablet="%6$s" data-itemphone="%7$s">
                <div class="df_tc_inner_wrapper">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            %1$s
                        </div>
                    </div>
                    %3$s
                </div>
                %4$s
            </div>',
            et_core_sanitized_previously( $this->content ),
            wp_json_encode($data),
            $this->df_tc_arrow($order_number),
            $this->df_tc_dots($order_number),
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
    public function df_tc_arrow($order_number) {
        $prev_icon = $this->props['arrow_prev_icon_use_icon'] === 'on' && isset($this->props['arrow_prev_icon_font_icon']) && !empty($this->props['arrow_prev_icon_font_icon']) ?
            esc_attr(et_pb_process_font_icon( $this->props['arrow_prev_icon_font_icon'] )) : '4';
        $next_icon = $this->props['arrow_next_icon_use_icon'] === 'on' && isset($this->props['arrow_next_icon_font_icon']) && !empty($this->props['arrow_next_icon_font_icon'])?
            esc_attr(et_pb_process_font_icon( $this->props['arrow_next_icon_font_icon'] )) : '5';

        return $this->props['arrow'] === 'on' ? sprintf('
            <div class="df_tc_arrows">
                <div class="swiper-button-next tc-next-%1$s" data-icon="%3$s"></div>
                <div class="swiper-button-prev tc-prev-%1$s" data-icon="%2$s"></div>
            </div>
        ', $order_number, $prev_icon, $next_icon) : '';
    }

    /**
     * Dot pagination
     *
     * @param Integer | $order_number
     * @return String | HTML
     */
    public function df_tc_dots($order_number) {
        return $this->props['dots'] === 'on' ?
            sprintf('<div class="swiper-pagination tc-dots-%1$s"></div>',$order_number) : '';
    }

    /**
     * Arrow Position styles
     *
     * @param String | position
     * @return String
     */
    public function df_arrow_pos_styles($value = 'middle') {
        $options = array (
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
new DIFL_TestimonialCarousel;
