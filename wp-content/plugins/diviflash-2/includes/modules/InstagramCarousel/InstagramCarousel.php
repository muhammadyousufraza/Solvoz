<?php
require_once ( DIFL_MAIN_DIR . '/includes/functions/df_instagram_process.php');

require_once( DIFL_MAIN_DIR . '/includes/functions/df_instagram.php');
class DIFL_InstagramCarousel extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_instagramcarousel';
    public $vb_support = 'on';
	public $icon_path;
   // public $child_slug = 'media_item';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Instagram Feed Carousel', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/instagram-carousel.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'instagram_settings'         => esc_html__('Instagram Settings', 'divi_flash'),
                    'carousel_settings'         => esc_html__('Carousel Settings', 'divi_flash'),
                    'advanced_settings'         => esc_html__('Advanced Carousel Settings', 'divi_flash'),
                    'content_bg'                => esc_html__('Content Area', 'divi_flash'),
                    'caption_bg'                => esc_html__('Caption Background', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'inc_overlay'                => esc_html__('Overlay', 'divi_flash'),
                    'inc_image'                  => esc_html__('Image Settings', 'divi_flash'),
                    'inc_hover'                  => esc_html__('Hover', 'divi_flash'),
                    'inc_caption'                  => esc_html__('Caption', 'divi_flash'),
                    'inc_icon'                  => esc_html__('Icon', 'divi_flash'),
                    'inc_arrow'                  => esc_html__('Arrow', 'divi_flash'),
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
                'toggle_slug'   => 'inc_caption',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "{$this->main_css_element} .content",
                    'hover' => "{$this->main_css_element} .content:hover",
                    'important'	=> 'all'
                ),
            ),
        );
        
        $advanced_fields['borders'] = array (
            'default'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .media_item > div',
                        'border_radii_hover' => '%%order_class%% .media_item > div:hover',
                        'border_styles' => '%%order_class%% .media_item > div',
                        'border_styles_hover' => '%%order_class%% .media_item > div:hover',
                    )
                )
            ),
        );
        $advanced_fields['box_shadow'] = array (
            'default' => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .media_item > div",
                ),
            ),
            'arrow' => array(
                'css' => array(
                    'main' => "%%order_class%% .df_inc_arrows > div",
                    'hover' => "%%order_class%% .df_inc_arrows > div:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows'
            ),
        );

        $advanced_fields['filters'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['transform'] = array(
			'css' => array(
				'main'	=> "{$this->main_css_element} .media_item > div",
			)
		);
    
        return $advanced_fields;
    }

    public function get_fields() {
        $general = array ();
        $instagram_settings = array (
//            'instagram_client_id'    => array (
//                'label'             => esc_html__( 'Client ID (Optional)', 'divi_flash' ),
//				'type'              => 'text',
//				'toggle_slug'       => 'instagram_settings',
//            ),
//            'instagram_client_secret'    => array (
//                'label'             => esc_html__( 'Client Secret (Optional)', 'divi_flash' ),
//				'type'              => 'text',
//				'toggle_slug'       => 'instagram_settings',
//            ),
            'instagram_user_token'    => array (
                'label'             => esc_html__( 'Access Token', 'divi_flash' ),
                'description'       => esc_html__('To create Instagram User Token <a href="https://developers.facebook.com/docs/instagram-basic-display-api">Click here </a>'),
				'type'              => 'text',
				'toggle_slug'       => 'instagram_settings',
            ),
            'item_limit'    => array (
                'label'             => esc_html__( 'Number of item', 'divi_flash' ),
                'description'       => esc_html__( 'File formate included image\'s and video\'s.','divi_flash'),
				'type'              => 'range',
				'toggle_slug'       => 'instagram_settings',
				'default'           => '6',
                'default_unit'      => '',
                'allowed_units'     => array (''),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '10',
					'step' => '1',
                ),
                'validate_unit'     => false,
            ),

            'instagram_post_only_image'    => array(
                'label'         => esc_html__('Post only images ', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'toggle_slug'   => 'instagram_settings',
                'default'         =>'off'
            ),
            'autoplay_video'    => array (
                'label'             => esc_html__('Video Autoplay', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'instagram_settings',
                'show_if'           => array(
                    'instagram_post_only_image' => 'off'
                )
            ),
           
            'cache_time' => array(
                'label'             => esc_html__( 'Data Cache Time', 'divi_flash' ),
                'description'       => esc_html__('Default value is 1. Set -1 to remove cache immediately.','divi_flash'),
				'type'              => 'range',
				'toggle_slug'       => 'instagram_settings',
				'default'           => '-1',
                'default_unit'      => '',
                'allowed_units'     => array (''),
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '365',
					'step' => '1',
                ),
                'validate_unit'     => false,
            ),
            'cache_time_type'  => array(
                'label'           => esc_html__('Data Cache Time Type', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'minute'      => esc_html__('Minute', 'divi_flash'),
                    'hour'     => esc_html__('Hour', 'divi_flash'),
                    'day'    => esc_html__('Day', 'divi_flash'),
                    'week'    => esc_html__('Week', 'divi_flash'),
                    'month'      => esc_html__('Month', 'divi_flash'),
                    'year'     => esc_html__('Year', 'divi_flash'),
                 ),
                'default'           => 'minute',
                'toggle_slug'       => 'instagram_settings',
            ),
        );

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
                'toggle_slug'       => 'carousel_settings',
                'show_if_not'       => array (
                    'carousel_type'  => array ('cube', 'flip')
                )
            ),

            'use_url'    => array(
                'label'         => esc_html__('Use Instagram Post Link', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'carousel_settings',
            ),
            'url_target'    => array(
                'label'         => esc_html__('Link Target', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'same_window'               => esc_html__('In The Same Window', 'divi_flash'),
                    'new_window'              => esc_html__('In The New Tab', 'divi_flash')
                ),
                'default'       => 'same_window',
                'toggle_slug'   => 'carousel_settings',
                'show_if'       => array(
                    'use_url'   => 'on'
                )
            ),
                
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
            'toggle_slug'           => 'inc_overlay',
            'tab_slug'              => 'advanced',
            'image'                 => false
        ));
       
    
        $image_settings = array(
            'ic_max_width'   => array (
                'label'             => esc_html__( 'Image Max Width', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'inc_image',
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
                'toggle_slug'     => 'inc_image',
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
                'toggle_slug'     => 'inc_image',
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
                'toggle_slug'       => 'inc_image',
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
                'toggle_slug'       => 'inc_image',
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
                'toggle_slug'       => 'inc_hover',
                'tab_slug'          => 'advanced'
            ),
            'image_scale_value'  => array(
                'label'             => esc_html__( 'Image scale Value on Hover', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'inc_hover',
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
            'use_icon'                  => array(
				'label'                 => esc_html__( 'Enable Hover Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'           => 'content_bg',
                'tab_slug'              => 'general',
                'affects'               => array (
                    'hover_icon_alignment',
                    'hover_icon_color',
                    'hover_icon_size',
                    'vertical_align'
				)
            ),
            
            'always_show_content'  => array (
                'label'             => esc_html__('Always show caption', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'divi_flash' ),
                    'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'content_bg',
                'tab_slug'          => 'general',
                'show_if'         => array (
                    'use_icon'     => 'off'
                ),
                'affects'         => array (
                    'vertical_align',
                    'inc_content_background'
				)
            ),
            'content_hover'  => array (
                'label'             => esc_html__('Enable caption on hover', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'divi_flash' ),
                    'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'content_bg',
                'tab_slug'          => 'general',
                'show_if'         => array (
                    'always_show_content'     => 'off',
                    'use_icon'     => 'off'
                ),
                'affects'          => array (
                    'vertical_align',
                    'inc_content_background'
				)
                
            ),
            
            'hover_icon' => array(
                'label'                 => esc_html__('Icon', 'divi_flash'),
                'type'                  => 'select_icon',
                'class' => array('et-pb-font-icon'),
                'default'           => 'P',
                'toggle_slug'           => 'content_bg',
                'tab_slug'              => 'general',
                'show_if'         => array(
                    'use_icon'     => 'on',
                ),
            ),
            'always_show_icon'  => array (
                'label'             => esc_html__('Always show Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'divi_flash' ),
                    'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'content_bg',
                'tab_slug'          => 'general',
                'show_if'         => array (
                    'use_icon'     => 'on'
                ),
            ),

            'vertical_align' => array (
                'default'         => 'default',
                'label'           => esc_html__( 'Vertical Align', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'flex-start'    => esc_html__( 'Top', 'divi_flash' ),
                    'center'        => esc_html__( 'Center', 'divi_flash' ),
                    'flex-end'      => esc_html__( 'Bottom', 'divi_flash' ),
                    'default'       => esc_html__( 'Default', 'divi_flash' )
                ),
              
                'toggle_slug'     => 'content_bg',
                'tab_slug'        => 'general',
                'depends_show_if' => 'on'
            ),

            'icon_anim_direction' => array (
                'default'         => 'top',
                'label'           => esc_html__( 'Icon Animation Direction', 'divi_flash' ),
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
                'toggle_slug'     => 'content_bg',
                'tab_slug'        => 'general',
                'show_if'         => array(
                    'use_icon'     => 'on',
                    'always_show_icon' => 'off'
                ),
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
                'toggle_slug'     => 'content_bg',
                'tab_slug'        => 'general',
                'show_if'         => array (
                    'content_hover'     => 'on',
                    'always_show_content'     => 'off'
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
                'toggle_slug'       => 'inc_hover',
                'tab_slug'          => 'advanced'
            ),
        );
        $icon_design = array(
            'hover_icon_alignment' => array(
                'label'           => esc_html__('Icon Alignment', 'divi_flash'),
                'type'            => 'text_align',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'       => 'inc_icon',
                'tab_slug'       => 'advanced',
                'mobile_options'    => true,
                'depends_show_if'     => 'on',
            ),

            'hover_icon_size' => array(
                'label'             => esc_html__('Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'inc_icon',
                'tab_slug'       => 'advanced',
                'default'           => '36px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '500',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'depends_show_if'     => 'on',
            ),
            'hover_icon_color' => array(
                'label'                 => esc_html__('Icon Color', 'divi_flash'),
                'default'           => "rgba(0,0,0,1)",
                'type'            => 'color-alpha',
                'toggle_slug'       => 'inc_icon',
                'tab_slug'       => 'advanced',
                'depends_show_if'     => 'on',
            ),
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
            'dots_align'    => array (
                'label'             => esc_html__('Alignment', 'divi_flash'),
                'type'              => 'text_align',
                'options'           => et_builder_get_text_orientation_options(array('justified')),
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
        $content_bg = $this->df_add_bg_field(array (
			'label'				    => 'Caption Background',
            'key'                   => 'inc_content_background',
            'toggle_slug'           => 'caption_bg',
            'tab_slug'              => 'general',
            'show_if_not'           => array(
                'use_icon' => 'on'
            ),
            'depends_show_if'       => 'on'
        ));
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

        $caption_spacing = $this->add_margin_padding(array(
            'title'         => 'Caption',
            'key'           => 'caption',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        
        return array_merge(
            $general,
            $instagram_settings,
            $carousel_settings,
            $coverflow_effect,
            $image_settings,
            $overlay_wrapper,
            $arrow_prev_icon,
            $arrow_next_icon,
            $arrows,
            $arrow_prev_spacing,
            $arrow_next_spacing,
            $dots,
            $hover_settings,
            $icon_design,
            // $vertical_align,
            $content_bg,
            $wrapper_spacing,
            $item_wrapper_spacing,
            $caption_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $overlay_wrapper = "{$this->main_css_element} .media_item .overlay_wrapper";
        $content = '%%order_class%% .overlay_wrapper .content';
        $icon = '%%order_class%% .overlay_wrapper .media_item .et-pb-icon.hover_icon';
        $wrapper = '%%order_class%% .swiper-container';
        $item_wrapper = '%%order_class%% .media_item > div';
        $arrow_icon = '%%order_class%% .df_inc_arrows div:after';
        $arrow = '%%order_class%% .df_inc_arrows div';
        $dots = '%%order_class%% .swiper-pagination span';
        $active_dot = '%%order_class%% .swiper-pagination span.swiper-pagination-bullet-active';
        $prev = '%%order_class%% .df_inc_arrows .swiper-button-prev';
        $next = '%%order_class%% .df_inc_arrows .swiper-button-next';

        $fields['arrow_color'] = array ('color' => $arrow_icon);
        $fields['arrow_background'] = array ('background-color' => $arrow);
        $fields['dots_color'] = array ('background' => $dots);
        $fields['active_dots_color'] = array ('background' => $active_dot);

        $fields['wrapper_margin'] = array ('margin' => $wrapper);
        $fields['wrapper_padding'] = array ('padding' => $wrapper);

        $fields['item_wrapper_margin'] = array ('margin' => $item_wrapper);
        $fields['item_wrapper_padding'] = array ('padding' => $item_wrapper);

        $fields['caption_margin'] = array ('margin' => $content);
        $fields['caption_padding'] = array ('padding' => $content);

        $fields['arrow_prev_margin'] = array ('margin' => $prev);
        $fields['arrow_prev_padding'] = array ('padding' => $prev);
        $fields['arrow_next_margin'] = array ('margin' => $next);
        $fields['arrow_next_padding'] = array ('padding' => $next);
        $fields['arrow_opacity'] = array ('opacity' => $arrow);
        $fields['arrow_opacity_disable'] = array ('opacity' => '%%order_class%% .df_inc_arrows div.swiper-button-disabled');
        $fields['hover_icon'] = array ('display' => $icon);

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'ic_overlay_background',
            'selector'      => $overlay_wrapper
        ));
      
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'inc_content_background',
            'selector'      => $content
        ));
        // border transition fix
     

        return $fields;
    }

    public function get_custom_css_fields_config() {
        return array(
			'carousel_item' => array(
				'label'    => esc_html__( 'Carousel Item', 'divi_flash' ),
				'selector' => '%%order_class%% .media_item > div',
            ),
			
			'image' => array(
				'label'    => esc_html__( 'Image', 'divi_flash' ),
				'selector' => '%%order_class%% .media_item .inc_image_wrapper img',
            ),
			
			'arrow' => array(
				'label'    => esc_html__( 'Arrows', 'divi_flash' ),
				'selector' => '%%order_class%% .df_inc_arrows div',
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
                'selector'          => '%%order_class%% .media_item img',
                'default'           => '100%'
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .media_item .inc_image_wrapper',
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
                'selector'          => '%%order_class%% .media_item img, %%order_class%% .media_item iframe',
                'default'           => '250px'
            ));
        }

        if ($this->props['ic_equal_height'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .media_item',
                'declaration' => 'height:auto;'
            ));
        }
        if ($this->props['ic_equal_height'] !== 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .media_item',
                'declaration' => sprintf('align-self:%1$s;', $this->props['ic_vertical'])
            ));
        }
        if ($this->props['ic_full_width'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .inc_image_wrapper, %%order_class%% .inc_image_wrapper img',
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
        
        if($this->props['use_icon'] === 'on'){
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'hover_icon_alignment',
                'type'              => 'text-align',
                'selector'          => "%%order_class%% .et-pb-icon.hover_icon",
                'default'           => 'center'
            ));
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'hover_icon_color',
                'type'              => 'color',
                'selector'            => "%%order_class%% .et-pb-icon.hover_icon",
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'hover_icon_size',
                'type'              => 'font-size',
                'selector'            => "%%order_class%% .et-pb-icon.hover_icon",
            ));
        }


        // overlay
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "ic_overlay_background",
            'selector'          => "{$this->main_css_element} .media_item .overlay_wrapper",
            'hover'             => "{$this->main_css_element} .media_item:hover .overlay_wrapper"
        ));
        
          // content background
          $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'inc_content_background',
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
            'selector'          => '%%order_class%% .media_item > div',
            'hover'             => '%%order_class%% .media_item > div:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .media_item > div',
            'hover'             => '%%order_class%% .media_item > div:hover',
        ));

        // caption spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'caption_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .content',
            'hover'             => '%%order_class%% .media_item:hover .content',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'caption_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .content',
            'hover'             => '%%order_class%% .media_item:hover .content',
        ));
        
        // dots colors
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

        if (isset($this->props['vertical_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .overlay_wrapper',
                'declaration' => sprintf('justify-content: %1$s;', $this->props['vertical_align'])
            ));
        }
        // transform styles
        
        if ($this->props['always_show_content'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "{$this->main_css_element} .content",
                'declaration' => sprintf('opacity: 1;')
            ));
 
        }else{
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "{$this->main_css_element} .content",
                'declaration' => sprintf('opacity: 0;')
            ));
        }
       if ($this->props['use_icon'] === 'on' && isset($this->props['icon_anim_direction'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "{$this->main_css_element} .content",
                'declaration' => sprintf('display: none;')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "{$this->main_css_element} .media_item .et-pb-icon.hover_icon",
                'declaration' => sprintf('opacity: 0; transform: %1$s;', 
                    $this->df_transform_values($this->props['icon_anim_direction'], 'default'))
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "{$this->main_css_element} .media_item:hover .et-pb-icon.hover_icon",
                'declaration' => sprintf('opacity: 1; transform: %1$s;', 
                    $this->df_transform_values($this->props['icon_anim_direction'], 'hover'))
            ));


        }
        if ($this->props['always_show_content'] === 'off' && $this->props['content_hover'] === 'on' && isset($this->props['anim_direction'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "{$this->main_css_element} .content",
                'declaration' => sprintf('opacity: 0; transform: %1$s;', 
                    $this->df_transform_values($this->props['anim_direction'], 'default'))
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "{$this->main_css_element} .media_item:hover .content",
                'declaration' => sprintf('opacity: 1; transform: %1$s;', 
                    $this->df_transform_values($this->props['anim_direction'], 'hover'))
            ));
        }

        if ($this->props['use_icon'] === 'on' && $this->props['always_show_icon'] ==='on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "{$this->main_css_element} .media_item .et-pb-icon.hover_icon.always_show_icon",
                'declaration' => sprintf('opacity: 1; transform: %1$s;', 'none')
            ));
        }
        if ($this->props['image_scale'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .media_item:hover img',
                'declaration' => sprintf('transform: scale(%1$s);', $this->props['image_scale_value'])
            ));
        }
      
        if ($this->props['item_overflow'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .media_item > div',
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
                'selector' => '%%order_class%% .df_inc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_inc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_inc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
            // alignment
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_inc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_inc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_inc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_opacity',
                'type'              => 'opacity',
                'selector'          => '%%order_class%% .df_inc_arrows div',
                'hover'             => '%%order_class%%:hover .df_inc_arrows div'
            ) );
            if( 'on' !== $this->props['loop'] ){
                $this->df_process_range( array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'arrow_opacity_disable',
                    'type'              => 'opacity',
                    'selector'          => '%%order_class%% .df_inc_arrows div.swiper-button-disabled',
                    'hover'             => '%%order_class%%:hover .df_inc_arrows div.swiper-button-disabled'
                ) );
            }
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df_inc_arrows .swiper-button-prev',
                'hover'             => '%%order_class%%:hover .df_inc_arrows .swiper-button-prev',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df_inc_arrows .swiper-button-prev',
                'hover'             => '%%order_class%%:hover .df_inc_arrows .swiper-button-prev',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df_inc_arrows .swiper-button-next',
                'hover'             => '%%order_class%%:hover .df_inc_arrows .swiper-button-next',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df_inc_arrows .swiper-button-next',
                'hover'             => '%%order_class%%:hover .df_inc_arrows .swiper-button-next',
            ));
            // arrow colors
            $this->df_process_color( array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_color',
                'type'              => 'color',
                'selector'          => '%%order_class%% .df_inc_arrows div:after',
                'hover'             => '%%order_class%%:hover .df_inc_arrows div:after'
            ) );
            $this->df_process_color( array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_background',
                'type'              => 'background-color',
                'selector'          => '%%order_class%% .df_inc_arrows div',
                'hover'             => '%%order_class%%:hover .df_inc_arrows div'
            ) );
            // arrow icon styles
            $this->process_icon_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_icon',
                'selector'          => '%%order_class%% .df_inc_arrows div.swiper-button-prev:after'
            ));
            $this->process_icon_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_icon',
                'selector'          => '%%order_class%% .df_inc_arrows div.swiper-button-next:after'
            ));

            if($this->props['arrow_opacity'] !== '0') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%%  .arrow-middle .df_inc_arrows *',
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
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'hover_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.hover_icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }
    }
    public function df_render_hover_icon(){

        if (isset($this->props['use_icon']) && $this->props['use_icon'] === 'on') {

            return sprintf(
                isset($this->props['hover_icon']) && $this->props['hover_icon'] !== '' ?
                    esc_attr(et_pb_process_font_icon($this->props['hover_icon'])) : esc_attr(et_pb_process_font_icon('5'))
            );
        } 

    }
    public function render( $attrs, $content, $render_slug ) {
		$this->handle_fa_icon();
        wp_enqueue_style('swiper-style');
        wp_enqueue_script('swiper-script');
        wp_enqueue_script('df-instagramcarousel');
        $this->additional_css_styles($render_slug);
        $order_class 	= self::get_module_order_class( $render_slug );
        $order_number	= str_replace('_','',str_replace($this->slug,'', $order_class));

        $instagram_client_id = (!empty($this->props['instagram_client_id'])) ? $this->props['instagram_client_id'] : '';
        $instagram_client_secret = (!empty($this->props['instagram_client_secret'])) ? $this->props['instagram_client_secret'] : '';
        $instagram_user_token = (!empty($this->props['instagram_user_token'])) ? $this->props['instagram_user_token'] : '';
        $item_limit = (!empty($this->props['item_limit'])) ? $this->props['item_limit'] : '';
        
        $instagram_obj = new DF_Instagram_Process($instagram_client_id, $instagram_client_secret, $instagram_user_token);
        
        
        $cache_time = !empty($this->props['cache_time']) ? $this->props['cache_time'] : '1';
	
        $cache_time_type = $this->props['cache_time_type'];
        $settings_data= array(
            'item_limit' => $item_limit,
            'cache_time' => $cache_time,
            'cache_time_type' => $cache_time_type,
            'unique_module'=> self::get_module_order_class( $render_slug )
        );
        $data = $instagram_obj->get_instagram_data($settings_data , $order_class);

        if(count($data) > 0){
            if($this->props['instagram_post_only_image'] =='on'){
                
                $media_type= "IMAGE";
                $data = array_filter(
                            $data,
                            function ($value) use ($media_type) {
                                return $value->media_type == $media_type;
                            },
                            ARRAY_FILTER_USE_BOTH
                        );
            }
        }

        $error_msg = "";
        $instagram_data = true;
        //if (isset(($instagram_obj->get_instagram_account_id($instagram_user_token) )->status) === 400 ) {
        if ( is_object ($instagram_obj->get_instagram_account_id($instagram_user_token)) && 
            isset($instagram_obj->get_instagram_account_id($instagram_user_token)->status) && 
            $instagram_obj->get_instagram_account_id($instagram_user_token)->status === 400 ){

            $error_msg = "Your Instagram User access token is not valid";
            $instagram_data = false;
        }else if(intval(count($data)) < 1){
            if($item_limit < 0 ){
                $error_msg = "Item limit should more then 0";
            }else{
                $error_msg = "No data found from instagram";
            } 
            $instagram_data = false;
            
        }else{
            $instagram_data = true;
        }
                                                        
        $module_error_msg = $this->props['instagram_user_token'] == '' ? 
            '<div class="instagram-carousel-error"> Please Enter Access token </div>':
            sprintf('<div class="instagram-carousel-error"> %1$s </div>', $error_msg);

        $item_html ='';
        $always_show_icon = ( $this->props['use_icon'] === 'on' && $this->props['always_show_icon'] ==='on') ? 'always_show_icon' : '';
        $icon = $this->props['use_icon'] === 'on' ?
        sprintf('<span class="et-pb-icon hover_icon %2$s">%1$s</span>', $this->df_render_hover_icon() , $always_show_icon ) : '';
        if($this->props['instagram_user_token'] !== '' && $instagram_data){

            foreach ( $data as $item ) { 
                $custom_url = $this->props['use_url'] === 'on' ? 
                    sprintf('data-url="%1$s"', $item->permalink) 
                    : '';  
                $autoplay_video = ( $this->props['autoplay_video'] === 'on' && $this->props['instagram_post_only_image']=== 'off' ) ? 'autoplay' : '';
                $content = sprintf('%1$s', !empty($item->caption) ? '<div class="content">'. $item->caption. '</div>' : '' );
                $media_type = ('VIDEO' == $item->media_type)? 'video': 'img';
                $overlay_wrapper = ('VIDEO' == $item->media_type)? '': sprintf('<div class="overlay_wrapper">%1$s %2$s</div>', $icon, $content);
                $media_html ='';
                if($item->media_type !== 'VIDEO'){
                    $media_html .=  sprintf('<div class="inc_image_wrapper">
                                            <%1$s src="%2$s" title="Image by: %3$s"/>
                                    </div>', $media_type , $item->media_url , $item->username );
                }else{
                    $media_html .=  sprintf('<div class="inc_image_wrapper">
                                        <video id="instagram-video" src=%1$s controls %2$s></video>
                                        
                                    </div>',
                                    $item->media_url,
                                    $autoplay_video);
                }
                
                $item_html .=sprintf('<div class="media_item swiper-slide" %1$s >
                                <div>
                                    <div class="df_inci_container">
                                        %2$s
                                        %3$s
                                    </div>
                                        
                                </div>
                            </div>', $custom_url, $media_html, $overlay_wrapper );
            }
        }else{
             $item_html .= $module_error_msg;
        }
        
        $class = '';

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
            'url_target' => $this->props['url_target']
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
     
        return sprintf('<div class="df_inc_container%5$s" data-settings=\'%4$s\' data-item="%6$s" data-itemtablet="%7$s" data-itemphone="%8$s">
                <div class="df_inc_inner_wrapper">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            %1$s
                        </div>
                    </div>
                    %2$s
                </div>
                %3$s
            </div>',
            $item_html,
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
            <div class="df_inc_arrows">
                <div class="swiper-button-next inc-next-%1$s" data-icon="%3$s"></div>
                <div class="swiper-button-prev inc-prev-%1$s" data-icon="%2$s"></div>
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
            sprintf('<div class="swiper-pagination inc-dots-%1$s"></div>',$order_number) : '';
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
new DIFL_InstagramCarousel;
