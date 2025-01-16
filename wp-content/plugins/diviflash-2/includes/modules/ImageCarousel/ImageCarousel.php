<?php

class DIFL_ImageCarousel extends ET_Builder_Module {
    public $slug       = 'difl_imagecarousel';
    public $vb_support = 'on';
    public $child_slug = 'difl_imagecarouselitem';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Image Carousel', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/image-carousel.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'carousel_settings'         => esc_html__('Carousel Settings', 'divi_flash'),
                    'advanced_settings'         => esc_html__('Advanced Carousel Settings', 'divi_flash'),
                    'content_bg'                => esc_html__('Content Area Background', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'ic_overlay'                => esc_html__('Overlay', 'divi_flash'),
                    'ic_image'                  => esc_html__('Image Settings', 'divi_flash'),
                    'ic_hover'                  => esc_html__('Hover', 'divi_flash'),
                    'caption'                   => esc_html__('Caption', 'divi_flash'),
                    'ic_arrow'                  => esc_html__('Arrow', 'divi_flash'),
                    'button'                    => esc_html__('Button', 'divi_flash'),
                    'arrows'                    => esc_html__('Arrows', 'divi_flash'),
                    'dots'                      => esc_html__('Dots', 'divi_flash'),
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
            'caption'     => array(
                'label'         => esc_html__( 'Caption', 'divi_flash' ),
                'toggle_slug'   => 'caption',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .ic_caption",
                    'hover' => "%%order_class%% .ic_caption:hover",
                    'important'	=> 'all'
                ),
            ),
            'button'     => array(
                'label'         => esc_html__( 'Button', 'divi_flash' ),
                'toggle_slug'   => 'button',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ic_button",
                    'hover' => "%%order_class%% .df_ic_button:hover",
                    'important'	=> 'all'
                ),
            )
        );
        $advanced_fields['borders'] = array (
            'default'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .difl_imagecarouselitem > div',
                        'border_radii_hover' => '%%order_class%% .difl_imagecarouselitem > div:hover',
                        'border_styles' => '%%order_class%% .difl_imagecarouselitem > div',
                        'border_styles_hover' => '%%order_class%% .difl_imagecarouselitem > div:hover',
                    )
                )
            ),
            'button'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_ic_button',
                        'border_radii_hover' => '%%order_class%% .df_ic_button:hover',
                        'border_styles' => '%%order_class%% .df_ic_button',
                        'border_styles_hover' => '%%order_class%% .df_ic_button:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'button'
            ),
        );
        $advanced_fields['box_shadow'] = array (
            'default' => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .difl_imagecarouselitem > div",
                ),
            ),
            'arrow' => array(
                'css' => array(
                    'main' => "%%order_class%% .df_ic_arrows > div",
                    'hover' => "%%order_class%% .df_ic_arrows > div:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows'
            ),
            'button' => array(
                'css' => array(
                    'main' => "%%order_class%% .df_ic_button",
                    'hover' => "%%order_class%% .df_ic_button:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'button'
            )
        );

        $advanced_fields['background'] = array(
            'css'   => array(
                'main'  => "{$this->main_css_element} .difl_imagecarouselitem > div",
                'hover'  => "{$this->main_css_element} .difl_imagecarouselitem:hover > div"
            )
        );
        $advanced_fields['filters'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['transform'] = array(
			'css' => array(
				'main'	=> "{$this->main_css_element} .difl_imagecarouselitem > div",
			)
		);

        return $advanced_fields;
    }

    public function get_fields() {
        $general = array ();
        $carousel_settings = array (
            'carousel_type'   => array (
                'label'             => esc_html__('Carousel Type', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
					'slide'         => esc_html__( 'Slide', 'divi_flash' ),
					'cube'          => esc_html__( 'Cube', 'divi_flash' ),
					'coverflow'     => esc_html__( 'Coverflow', 'divi_flash' ),
					'flip'          => esc_html__( 'Flip', 'divi_flash' )
                ),
                'default'           => 'slide',
                'toggle_slug'       => 'carousel_settings'
            ),
            'variable_width'  => array (
                'label'             => esc_html__('Variable Width', 'divi_flash'),
                'description'       => esc_html__('Item must be greater then display item.', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if'           => array (
                    'carousel_type' => 'slide'
                )
            ),
            'item_height'      => array (
                'label'             => esc_html__( 'Max Image Height', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '250px',
                'default_unit'      => 'px',
                'allowed_units'     => array ('px', '%'),
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '1000',
					'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array (
                    'variable_width' => 'on'
                )
            ),
            'item_desktop'    => array (
                'label'             => esc_html__( 'Max Slide Desktop', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '4',
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
            'use_lightbox_caption'    => array (
                'label'             => esc_html__('Use Lightbox Caption', 'divi_flash'),
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
        $overlay_wrapper = $this->df_add_bg_field(array (
			'label'				    => 'Overlay',
            'key'                   => 'ic_overlay_background',
            'toggle_slug'           => 'ic_overlay',
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'prefix'                => 'Overlay',
            'suffix'                => 'overlay',
        ));
        $vertical_align = array (
            'vertical_align' => array (
                'default'         => 'flex-start',
                'label'           => esc_html__( 'Content Vertical Align', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'flex-start'    => esc_html__( 'Top', 'divi_flash' ),
                    'center'        => esc_html__( 'Center', 'divi_flash' ),
                    'flex-end'      => esc_html__( 'Bottom', 'divi_flash' )
                ),
                'toggle_slug'     => 'ic_overlay',
                'tab_slug'        => 'advanced'
            )
        );
        $image_settings = array(
            'ic_max_width'   => array (
                'label'             => esc_html__( 'Image Max Width', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'ic_image',
				'tab_slug'          => 'advanced',
				'default'           => '100%',
                'default_unit'      => '%',
                'responsive'        => true,
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
                ),
                'show_if_not'       => array(
                    'ic_full_width'  => 'on'
                )
            ),
            'ic_img_align' => array(
				'label'           => esc_html__( 'Alignment', 'et_builder' ),
				'type'            => 'text_align',
				'options'         => et_builder_get_text_orientation_options(array('justified')),
				'tab_slug'        => 'advanced',
                'toggle_slug'     => 'ic_image',
                'show_if_not'     => array(
                    'ic_max_width' => '100%'
                )
			),
            'ic_vertical'       => array (
                'default'         => 'flex-start',
                'label'           => esc_html__( 'Vertical Alignment', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'flex-start'            => esc_html__( 'Top', 'divi_flash' ),
                    'center'                => esc_html__( 'Center', 'divi_flash' ),
                    'flex-end'              => esc_html__( 'Bottom', 'divi_flash' )
                ),
                'toggle_slug'     => 'ic_image',
                'tab_slug'        => 'advanced',
                'show_if_not'     => array(
                    'ic_equal_height' => 'on'
                )
            ),
            'ic_equal_height'    => array (
                'label'             => esc_html__('Equal Height Image Container', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'ic_image',
                'tab_slug'        => 'advanced'
            ),
            'ic_full_width'    => array (
                'label'             => esc_html__('Force Full Width', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'ic_image',
                'tab_slug'          => 'advanced',
                'show_if'           => array(
                    'ic_max_width' => '100%'
                )
            )
        );
        $hover_settings = array (
            'image_scale'  => array (
                'label'             => esc_html__('Image scale on hover', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'divi_flash' ),
                    'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'ic_hover',
                'tab_slug'          => 'advanced'
            ),
            'image_scale_value'  => array(
                'label'             => esc_html__( 'Image scale Value on Hover', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'ic_hover',
				'default'           => '1.03',
				'validate_unit'     => false,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '2',
					'step' => '.01',
                ),
                'show_if'           => array (
                    'image_scale'   => 'on'
                )
            ),
            'content_hover'  => array (
                'label'             => esc_html__('Enable content on hover', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'divi_flash' ),
                    'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'ic_hover',
                'tab_slug'          => 'advanced'
            ),
            'anim_direction' => array (
                'default'         => 'top',
                'label'           => esc_html__( 'Animation Direction', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'top'           => esc_html__( 'Top', 'divi_flash' ),
                    'bottom'        => esc_html__( 'Bottom', 'divi_flash' ),
                    'left'          => esc_html__( 'Left', 'divi_flash' ),
                    'right'         => esc_html__( 'Right', 'divi_flash' ),
                    'center'        => esc_html__( 'Center', 'divi_flash' ),
                    'top_right'     => esc_html__( 'Top Right', 'divi_flash' ),
                    'top_left'      => esc_html__( 'Top Left', 'divi_flash' ),
                    'bottom_right'  => esc_html__( 'Bottom Right', 'divi_flash' ),
                    'bottom_left'   => esc_html__( 'Bottom Left', 'divi_flash' ),
                ),
                'toggle_slug'     => 'ic_hover',
                'tab_slug'        => 'advanced',
                'show_if'         => array (
                    'content_hover'     => 'on'
                )
            ),
            'item_overflow'  => array (
                'label'             => esc_html__('Overflow Hidden', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'divi_flash' ),
                    'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'ic_hover',
                'tab_slug'          => 'advanced'
            ),
        );

        $button_style = $this->df_add_btn_styles(array (
            'key'                   => 'ic_btn',
            'toggle_slug'           => 'button',
            'tab_slug'              => 'advanced'
        ));
        $buttons_bg = $this->df_add_bg_field(array (
			'label'				    => 'Button Background',
            'key'                   => 'ic_btn_background',
            'toggle_slug'           => 'button',
            'tab_slug'              => 'advanced'
        ));
        $content_bg = $this->df_add_bg_field(array (
			'label'				    => 'Content Area Background',
            'key'                   => 'ic_content_background',
            'toggle_slug'           => 'content_bg',
            'tab_slug'              => 'general'
        ));
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
        ));
        $arrow_next_spacing = $this->add_margin_padding(array(
            'title'         => 'Arrow Next',
            'key'           => 'arrow_next',
            'toggle_slug'   => 'arrows'
        ));
        $dots = array (
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
            'dots_align'    => array (
                'label'             => esc_html__('Alignment', 'divi_flash'),
                'type'              => 'text_align',
                'options'           => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'       => 'dots',
                'tab_slug'          => 'advanced'
            ),
            'dots_gap' => array(
                'label'       => esc_html__('Gap', 'divi_flash'),
                'description' => esc_html__('You can control the gap between dots.', 'divi_flash'),
                'type'        => 'range',
                'default'     => '8px',
                'allowed_units'  => array('px'),
                'default_unit'   => 'px',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'step' => '1'
                ),
                'mobile_options' => true,
                'responsive'    => true,
                'toggle_slug'   => 'dots',
                'tab_slug'      => 'advanced',
            ),
        );
        $wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Wrapper',
            'key'           => 'wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $item_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Item Wrapper',
            'key'           => 'item_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $content_spacing = $this->add_margin_padding(array(
            'title'         => 'Content Area',
            'key'           => 'content',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $caption_spacing = $this->add_margin_padding(array(
            'title'         => 'Caption',
            'key'           => 'caption',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));

        $button_spacing = $this->add_margin_padding(array(
            'title'         => 'Button',
            'key'           => 'button',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        return array_merge(
            $general,
            $carousel_settings,
            $coverflow_effect,
            $image_settings,
            $content_bg,
            $overlay_wrapper,
            $arrow_prev_icon,
            $arrow_next_icon,
            $arrows,
            $arrow_prev_spacing,
            $arrow_next_spacing,
            $dots,
            $vertical_align,
            $hover_settings,
            $button_style,
            $buttons_bg,
            $wrapper_spacing,
            $item_wrapper_spacing,
            $content_spacing,
            $caption_spacing,
            $button_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $overlay_wrapper = "{$this->main_css_element} .difl_imagecarouselitem .overlay_wrapper";
        $button = "%%order_class%% .df_ic_button";
        $wrapper = '%%order_class%% .swiper-container';
        $item_wrapper = '%%order_class%% .difl_imagecarouselitem > div';
        $content = '%%order_class%% .content';
        $caption = '%%order_class%% .ic_caption';
        $arrow_icon = '%%order_class%% .df_ic_arrows div:after';
        $arrow = '%%order_class%% .df_ic_arrows div';
        $dots = '%%order_class%% .swiper-pagination span';
        $active_dot = '%%order_class%% .swiper-pagination span.swiper-pagination-bullet-active';
        $prev = '%%order_class%% .df_ic_arrows .swiper-button-prev';
        $next = '%%order_class%% .df_ic_arrows .swiper-button-next';

        $fields['arrow_color'] = array ('color' => $arrow_icon);
        $fields['arrow_background'] = array ('background-color' => $arrow);
        $fields['dots_color'] = array ('background' => $dots);
        $fields['active_dots_color'] = array ('background' => $active_dot);

        $fields['wrapper_margin'] = array ('margin' => $wrapper);
        $fields['wrapper_padding'] = array ('padding' => $wrapper);

        $fields['item_wrapper_margin'] = array ('margin' => $item_wrapper);
        $fields['item_wrapper_padding'] = array ('padding' => $item_wrapper);

        $fields['content_margin'] = array ('margin' => $content);
        $fields['content_padding'] = array ('padding' => $content);

        $fields['caption_margin'] = array ('margin' => $caption);
        $fields['caption_padding'] = array ('padding' => $caption);

        $fields['button_margin'] = array ('margin' => $button);
        $fields['button_padding'] = array ('padding' => $button);

        $fields['arrow_prev_margin'] = array ('margin' => $prev);
        $fields['arrow_prev_padding'] = array ('padding' => $prev);
        $fields['arrow_next_margin'] = array ('margin' => $next);
        $fields['arrow_next_padding'] = array ('padding' => $next);
        $fields['arrow_opacity'] = array ('opacity' => $arrow);
        $fields['arrow_opacity_disable'] = array ('opacity' => '%%order_class%% .df_ic_arrows div.swiper-button-disabled');

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'ic_overlay_background',
            'selector'      => $overlay_wrapper
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'ic_btn_background',
            'selector'      => $button
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'ic_content_background',
            'selector'      => $content
        ));

        // border transition fix
        $fields = $this->df_fix_border_transition(
            $fields,
            'button',
            '%%order_class%% .df_ic_button'
        );

        return $fields;
    }

    public function get_custom_css_fields_config() {
        return array(
			'carousel_item' => array(
				'label'    => esc_html__( 'Carousel Item', 'divi_flash' ),
				'selector' => '%%order_class%% .difl_imagecarouselitem > div',
            ),
			'caption' => array(
				'label'    => esc_html__( 'Caption', 'divi_flash' ),
				'selector' => '%%order_class%% .difl_imagecarouselitem .ic_caption',
            ),
			'image' => array(
				'label'    => esc_html__( 'Image', 'divi_flash' ),
				'selector' => '%%order_class%% .difl_imagecarouselitem .ic_image_wrapper img',
            ),
			'button' => array(
				'label'    => esc_html__( 'Button', 'divi_flash' ),
				'selector' => '%%order_class%% .difl_imagecarouselitem .df_ic_button',
            ),
			'arrow' => array(
				'label'    => esc_html__( 'Arrows', 'divi_flash' ),
				'selector' => '%%order_class%% .df_ic_arrows div',
            ),
			'dots' => array(
				'label'    => esc_html__( 'Dots', 'divi_flash' ),
				'selector' => '%%order_class%% .swiper-pagination span',
			)
		);
    }

    public function additional_css_styles($render_slug) {

        // image settings
        if($this->props['ic_full_width'] !== 'on') {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'ic_max_width',
                'type'              => 'max-width',
                'selector'          => '%%order_class%% .difl_imagecarouselitem img',
                'default'           => '100%'
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .difl_imagecarouselitem .ic_image_wrapper',
                'declaration' => sprintf('text-align: %1$s;',
                    $this->props['ic_img_align']
                )
            ));
        }

        if (isset($this->props['variable_width']) && $this->props['variable_width'] === 'on') {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'item_height',
                'type'              => 'height',
                'selector'          => '%%order_class%% .difl_imagecarouselitem img',
                'default'           => '250px'
            ));
        }

        if ($this->props['ic_equal_height'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .difl_imagecarouselitem',
                'declaration' => 'height:auto;'
            ));
        }
        if ($this->props['ic_equal_height'] !== 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .difl_imagecarouselitem',
                'declaration' => sprintf('align-self:%1$s;', $this->props['ic_vertical'])
            ));
        }
        if ($this->props['ic_full_width'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .ic_image_wrapper, %%order_class%% .ic_image_wrapper img',
                'declaration' => 'min-width:100%;'
            ));
        }
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

        // overlay
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "ic_overlay_background",
            'selector'          => "{$this->main_css_element} .difl_imagecarouselitem .overlay_wrapper",
            'hover'             => "{$this->main_css_element} .difl_imagecarouselitem:hover .overlay_wrapper"
        ));
        // button
        // button style
        $this->df_process_btn_styles(array (
            'render_slug'       => $render_slug,
            'slug'              => 'ic_btn',
            'selector'          => '%%order_class%% .df_ic_button',
            'hover'             => '%%order_class%% .df_ic_button:hover',
            'align_container'   => '%%order_class%% .df_ic_button_wrapper'
        ));
        // button background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'ic_btn_background',
            'selector'          => '%%order_class%% .df_ic_button',
            'hover'             => '%%order_class%% .df_ic_button:hover'
        ));
        // content background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'ic_content_background',
            'selector'          => '%%order_class%% .content',
            'hover'             => '%%order_class%% .content:hover'
        ));
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
            'hover'             => '%%order_class%% .swiper-container:hover',
        ));
        // item wrapper spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .difl_imagecarouselitem > div',
            'hover'             => '%%order_class%% .difl_imagecarouselitem > div:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .difl_imagecarouselitem > div',
            'hover'             => '%%order_class%% .difl_imagecarouselitem > div:hover',
        ));
        // content spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .content',
            'hover'             => '%%order_class%% .content:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .content',
            'hover'             => '%%order_class%% .content:hover',
        ));
        // caption spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'caption_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .ic_caption',
            'hover'             => '%%order_class%% .ic_caption:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'caption_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .ic_caption',
            'hover'             => '%%order_class%% .ic_caption:hover',
        ));
        // Button spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ic_button',
            'hover'             => '%%order_class%% .df_ic_button:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ic_button',
            'hover'             => '%%order_class%% .df_ic_button:hover',
        ));

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
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'dots_gap',
            'type'              => 'margin-right',
            'selector'          => '%%order_class%% .swiper-pagination span'
        ));
        if (isset($this->props['vertical_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .overlay_wrapper',
                'declaration' => sprintf('justify-content: %1$s;', $this->props['vertical_align'])
            ));
        }
        if ($this->props['image_scale'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .difl_imagecarouselitem:hover img',
                'declaration' => sprintf('transform: scale(%1$s);', $this->props['image_scale_value'])
            ));
        }
        // transform styles
        if ($this->props['content_hover'] === 'on' && isset($this->props['anim_direction'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .difl_imagecarouselitem .content',
                'declaration' => sprintf('opacity: 0; transform: %1$s;',
                    $this->df_transform_values($this->props['anim_direction'], 'default'))
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .difl_imagecarouselitem:hover .content',
                'declaration' => sprintf('opacity: 1; transform: %1$s;',
                    $this->df_transform_values($this->props['anim_direction'], 'hover'))
            ));
        }
        if ($this->props['item_overflow'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .difl_imagecarouselitem > div',
                'declaration' => 'overflow: hidden;'
            ));
        }

        // arrow positions
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
                'selector' => '%%order_class%% .df_ic_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ic_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ic_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
            // alignment
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ic_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ic_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ic_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_opacity',
                'type'              => 'opacity',
                'selector'          => '%%order_class%% .df_ic_arrows div',
                'hover'             => '%%order_class%%:hover .df_ic_arrows div'
            ) );
            if( 'on' !== $this->props['loop'] ){
                $this->df_process_range( array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'arrow_opacity_disable',
                    'type'              => 'opacity',
                    'selector'          => '%%order_class%% .df_ic_arrows div.swiper-button-disabled',
                    'hover'             => '%%order_class%%:hover .df_ic_arrows div.swiper-button-disabled'
                ) );
            }
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df_ic_arrows .swiper-button-prev',
                'hover'             => '%%order_class%%:hover .df_ic_arrows .swiper-button-prev',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df_ic_arrows .swiper-button-prev',
                'hover'             => '%%order_class%%:hover .df_ic_arrows .swiper-button-prev',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df_ic_arrows .swiper-button-next',
                'hover'             => '%%order_class%%:hover .df_ic_arrows .swiper-button-next',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df_ic_arrows .swiper-button-next',
                'hover'             => '%%order_class%%:hover .df_ic_arrows .swiper-button-next',
            ));
            // arrow colors
            $this->df_process_color( array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_color',
                'type'              => 'color',
                'selector'          => '%%order_class%% .df_ic_arrows div:after',
                'hover'             => '%%order_class%%:hover .df_ic_arrows div:after'
            ) );
            $this->df_process_color( array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_background',
                'type'              => 'background-color',
                'selector'          => '%%order_class%% .df_ic_arrows div',
                'hover'             => '%%order_class%%:hover .df_ic_arrows div'
            ) );
            // arrow icon styles
            $this->process_icon_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_icon',
                'selector'          => '%%order_class%% .df_ic_arrows div.swiper-button-prev:after'
            ));
            $this->process_icon_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_icon',
                'selector'          => '%%order_class%% .df_ic_arrows div.swiper-button-next:after'
            ));

            if($this->props['arrow_opacity'] !== '0') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%%  .arrow-middle .df_ic_arrows *',
                    'declaration' => 'pointer-events: all !important;'
                ));
            }
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
                '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Image Item.</strong></h2>'
            );
        }

        if($this->props['use_lightbox'] === 'on') {
            wp_enqueue_script('lightgallery-script');
            $this->add_classname('has_lightbox');
        }
        wp_enqueue_script('swiper-script');
        wp_enqueue_script('df-imagecarousel');
        $this->additional_css_styles($render_slug);

        $class = '';
        $order_class 	= self::get_module_order_class( $render_slug );
        $order_number	= str_replace('_','',str_replace($this->slug,'', $order_class));
        $data = [
            'effect' => $this->props['carousel_type'],
            'desktop' => $this->props['item_desktop'],
            'tablet' => $this->props['item_tablet'],
            'mobile' => $this->props['item_mobile'],
            'variable_width' => $this->props['variable_width'],
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
            'use_lightbox' => $this->props['use_lightbox'],
            'use_lightbox_caption' => $this->props['use_lightbox_caption']
        ];
        if ($this->props['carousel_type'] === 'coverflow') {
            $data['slideShadows'] = $this->props['coverflow_shadow'];
            $data['rotate'] = $this->props['coverflow_rotate'];
            $data['stretch'] = $this->props['coverflow_stretch'];
            $data['depth'] = $this->props['coverflow_depth'];
            $data['modifier'] = $this->props['coverflow_modifier'];
        }

        if (isset($this->props['variable_width']) && $this->props['variable_width'] === 'on') {
            $class .= ' variable-width';
        }

        // arrow position classes
        if($this->props['arrow'] === 'on') {
            $arrow_position = '' !== $this->props['arrow_position'] ? $this->props['arrow_position'] : 'middle';
            $class .= ' arrow-' . $arrow_position;
        }

        return sprintf('<div class="df_ic_container%5$s" data-settings=\'%4$s\' data-item="%6$s" data-itemtablet="%7$s" data-itemphone="%8$s">
                <div class="df_ic_inner_wrapper">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            %1$s
                        </div>
                    </div>
                    %2$s
                </div>
                %3$s
            </div>',
            et_core_sanitized_previously( $this->content ),
            $this->df_ic_arrow($order_number),
            $this->df_ic_dots($order_number),
            wp_json_encode($data),
            $class,
            $this->props['item_desktop'],
            $this->props['item_tablet'],
            $this->props['item_mobile']
        );
    }

    /**
     * Arrow Position styles
     *
     * @param String | position
     * @return String
     */
    public function df_arrow_pos_styles($value) {
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

    /**
     * Arrow navigation
     *
     * @param Integer | $order_number
     * @return String | HTML
     */
    public function df_ic_arrow($order_number) {
        $prev_icon = $this->props['arrow_prev_icon_use_icon'] === 'on' && isset($this->props['arrow_prev_icon_font_icon']) && !empty($this->props['arrow_prev_icon_font_icon']) ?
            esc_attr(et_pb_process_font_icon( $this->props['arrow_prev_icon_font_icon'] )) : '4';
        $next_icon = $this->props['arrow_next_icon_use_icon'] === 'on' && isset($this->props['arrow_next_icon_font_icon']) && !empty($this->props['arrow_next_icon_font_icon'])?
            esc_attr(et_pb_process_font_icon( $this->props['arrow_next_icon_font_icon'] )) : '5';

        return $this->props['arrow'] === 'on' ? sprintf('
            <div class="df_ic_arrows">
                <div class="swiper-button-next ic-next-%1$s" data-icon="%3$s"></div>
                <div class="swiper-button-prev ic-prev-%1$s" data-icon="%2$s"></div>
            </div>
        ', $order_number, $prev_icon, $next_icon) : '';
    }

    /**
     * Dot pagination
     *
     * @param Integer | $order_number
     * @return String | HTML
     */
    public function df_ic_dots($order_number) {
        return $this->props['dots'] === 'on' ?
            sprintf('<div class="swiper-pagination ic-dots-%1$s"></div>',$order_number) : '';
    }

    /**
     * Get transform values
     *
     * @param String $key
     * @param String | State
     */
    public function df_transform_values($key = 'top', $state = 'default') {
        $transform_values = array (
            'top'           => [
                'default'   => 'translateY(-60px)',
                'hover'     => 'translateY(0px)'
            ],
            'bottom'        => [
                'default'   => 'translateY(60px)',
                'hover'     => 'translateY(0px)'
            ],
            'left'          => [
                'default'   => 'translateX(-60px)',
                'hover'     => 'translateX(0px)'
            ],
            'right'         => [
                'default'   => 'translateX(60px)',
                'hover'     => 'translateX(0px)'
            ],
            'center'        => [
                'default'   => 'scale(0)',
                'hover'     => 'scale(1)'
            ],
            'top_right'     => [
                'default'   => 'translateX(50px) translateY(-50px)',
                'hover'     => 'translateX(0px) translateY(0px)'
            ],
            'top_left'      => [
                'default'   => 'translateX(-50px) translateY(-50px)',
                'hover'     => 'translateX(0px) translateY(0px)'
            ],
            'bottom_right'  => [
                'default'   => 'translateX(50px) translateY(50px)',
                'hover'     => 'translateX(0px) translateY(0px)'
            ],
            'bottom_left'   => [
                'default'   => 'translateX(-50px) translateY(50px)',
                'hover'     => 'translateX(0px) translateY(0px)'
            ]
        );
        return $transform_values[$key][$state];
    }
}
new DIFL_ImageCarousel;
