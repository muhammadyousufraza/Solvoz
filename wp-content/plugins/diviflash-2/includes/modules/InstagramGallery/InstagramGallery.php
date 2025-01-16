<?php

class DIFL_InstagramGallery extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_instagramgallery';
    public $vb_support = 'on';
    public $df_image_props = array();
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Instagram Feed', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/instagram-gallery.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'instagram_settings'         => esc_html__('Instagram Settings', 'divi_flash'),
                    'settings'  => esc_html__('Gallery Settings', 'divi_flash'),
                    'hover'     => esc_html__('Hover Settings', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'font_styles'    => array (
                        'title'             => esc_html__('Font Styles', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'caption'   => array(
                                'name' => 'Caption',
                            ),
                            'username'     => array(
                                'name' => 'Username',
                            ),
                            'post_date'     => array(
                                'name' => 'Post date',
                            )
                        ),
                    ),
                    'user_info'                 => esc_html__('User Info', 'divi_flash'),
                    'profile_picture'                 => esc_html__('Profile Picture', 'divi_flash'),
                    'image'                 => esc_html__('Image', 'divi_flash'),
                    'hover_design'                 => esc_html__('Hover', 'divi_flash'),
                    'more_btn'              => esc_html__('Load More Button', 'divi_flash'),
                    'df_borders'            => esc_html__('Borders', 'divi_flash')
                )
            )
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['fonts'] = array(
            'caption'     => array(
                'label'         => esc_html__( 'Caption', 'divi_flash' ),
                'toggle_slug'   => 'font_styles',
                'sub_toggle'    => 'caption',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ing_caption",
                    'hover' => "%%order_class%% .df_ing_image:hover .df_ing_caption",
                    'important'	=> 'all'
                ),
            ),
            'instagram_username'     => array(
                'label'         => esc_html__( 'Username', 'divi_flash' ),
                'toggle_slug'   => 'font_styles',
                'sub_toggle'    => 'username',
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
                    'main' => "%%order_class%% .df-instagram-user-name",
                    'hover' => "%%order_class%% .df_ing_image:hover .df-instagram-user-name",
                    'important'	=> 'all'
                ),
            ),
            'instagram_post_date'     => array(
                'label'         => esc_html__( 'Post Date', 'divi_flash' ),
                'toggle_slug'   => 'font_styles',
                'sub_toggle'    => 'post_date',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df-instagram-postdate",
                    'hover' => "%%order_class%% .df_ing_image:hover .df-instagram-postdate",
                    'important'	=> 'all'
                ),
            ),
            'more_btn'     => array(
                'label'         => esc_html__( '', 'divi_flash' ),
                'toggle_slug'   => 'more_btn',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .ing-load-more-btn",
                    'hover' => "%%order_class%% .ing-load-more-btn:hover",
                    'important'	=> 'all'
                ),
            )
        );

        $advanced_fields['borders'] = array(
            'default'               => false,
            'image'                 => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_ing_image .item-content',
                        'border_styles' => '%%order_class%% .df_ing_image .item-content',
                        'border_styles_hover' => '%%order_class%% .df_ing_image:hover .item-content',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'image',
                'label_prefix'      => ''
            ),
            'instagram_user_profile_picture_border' => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_ing_image .df-instagram-user-profile-picture img',
                        'border_styles' => '%%order_class%% .df_ing_image .df-instagram-user-profile-picture img',
                        'border_styles_hover' => '%%order_class%% .df_ing_image:hover .df-instagram-user-profile-picture img',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'profile_picture',
                'label_prefix'      => ''
            ),
            'user_info_border'              => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .df-instagram-user-info",
                        'border_radii_hover' => "{$this->main_css_element} .df-instagram-user-info:hover ",
                        'border_styles' => "{$this->main_css_element} .df-instagram-user-info",
                        'border_styles_hover' => "{$this->main_css_element} .df-instagram-user-info:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'user_info',
                'label_prefix'      => ''
            ),
            'morebtn_border'              => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .ing-load-more-btn",
                        'border_radii_hover' => "{$this->main_css_element} .ing-load-more-btn:hover",
                        'border_styles' => "{$this->main_css_element} .ing-load-more-btn",
                        'border_styles_hover' => "{$this->main_css_element} .ing-load-more-btn:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'more_btn',
                'label_prefix'      => ''
            )
        );
        
        $advanced_fields['box_shadow'] = array(
            'default'   => false,
            'image'     => array(
                'css' => array(
                    'main' => "%%order_class%% .item-content",
                    'hover' => "%%order_class%% .item-content:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'image'
            ),
            'instagram_user_profile_picture'     => array(
                'css' => array(
                    'main' => "%%order_class%% .df-instagram-user-profile-picture img",
                    'hover' => "%%order_class%% .df-instagram-user-profile-picture img:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'profile_picture',
                'level'              => 'Profile Picture'
            ),
            'user_info'     => array(
                'css' => array(
                    'main' => "%%order_class%% .df-instagram-user-info",
                    'hover' => "%%order_class%% .df-instagram-user-info:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'user_info'
            ),
            'more_button'     => array(
                'css' => array(
                    'main' => "%%order_class%% .ing-load-more-btn",
                    'hover' => "%%order_class%% .ing-load-more-btn:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'more_btn'
            )
        );
        $advanced_fields["filters"] = array(
			'child_filters_target' => array(
				'tab_slug' => 'advanced',
				'toggle_slug' => 'image',
				'css' => array(
					'main' => '%%order_class%% .image-container img'
				),
			),
        );
        
        $advanced_fields['image'] = array(
			'css' => array(
				'main' => array(
					'%%order_class%% .image-container img',
				)
			),
		);

        $advanced_fields['text'] = false;
        
        $advanced_fields['transform'] = false;
    
        return $advanced_fields;
    }

    public function get_fields() {
        $general = array (
            'image_to_display'    => array(
                'label'    => esc_html__('Image in row', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    '1'     => esc_html__('1 Item', 'divi_flash'),
                    '2'     => esc_html__('2 Items', 'divi_flash'),
                    '3'     => esc_html__('3 Items', 'divi_flash'),
                    '4'     => esc_html__('4 Items', 'divi_flash'),
                    '5'     => esc_html__('5 Items', 'divi_flash'),
                    '6'     => esc_html__('6 Items', 'divi_flash'),
                    '7'     => esc_html__('7 Items', 'divi_flash'),
                    '8'     => esc_html__('8 Items', 'divi_flash')
                ),
                'default'       => '4',
                'toggle_slug'   => 'settings',
                'mobile_options'=> true
            ),
            'layout_mode'    => array(
                'label'    => esc_html__('Layout Mode', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'masonry'     => esc_html__('Masonry', 'divi_flash'),
                    'fitRows'     => esc_html__('Grid', 'divi_flash')
                ),
                'default'       => 'masonry',
                'toggle_slug'   => 'settings'
            ),
            'item_gutter'    => array (
                'label'             => esc_html__( 'Space Between', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'settings',
                'default'           => '10px',
                'default_unit'      => '',
                'allowed_units'     => array ('px'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '50',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true
            ),
         
            'load_more'    => array(
                'label'         => esc_html__('Load More button', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'settings',
                'show_if_not'   => array(
                    'filter_nav' => 'on'
                )
            ),
            'init_count'    => array(
                'label'         => esc_html__('Initial Image Load', 'divi_flash'),
                'type'          => 'text',
                'default'       => '6',
                'toggle_slug'   => 'settings',
                'show_if'       => array(
                    'load_more' => 'on'
                ),
                'show_if_not'   => array(
                    'filter_nav' => 'on'
                )
            ),
            'image_count'    => array(
                'label'         => esc_html__('Load More Image Count', 'divi_flash'),
                'type'          => 'text',
                'default'       => '4',
                'toggle_slug'   => 'settings',
                'show_if'       => array(
                    'load_more' => 'on'
                ),
                'show_if_not'   => array(
                    'filter_nav' => 'on'
                )
            ),
            'load_more_text'    => array(
                'label'         => esc_html__('Load More Button Text', 'divi_flash'),
                'type'          => 'text',
                'default'       => 'Load More',
                'toggle_slug'   => 'settings',
                'show_if'       => array(
                    'load_more' => 'on'
                ),
                'show_if_not'   => array(
                    'filter_nav' => 'on'
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
                'toggle_slug'   => 'settings',
            ),
            'url_target'    => array(
                'label'         => esc_html__('Link Target', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'same_window'               => esc_html__('In The Same Window', 'divi_flash'),
                    'new_window'              => esc_html__('In The New Tab', 'divi_flash')
                ),
                'default'       => 'same_window',
                'toggle_slug'   => 'settings',
                'show_if'       => array(
                    'use_url'   => 'on'
                )
            )
        );
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
				'default'           => '100',
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
            'show_instagram_user_info'    => array(
                'label'         => esc_html__('Show Instagram User Info ', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'toggle_slug'   => 'instagram_settings',
                'default'         =>'off'
            ),
            
            'instagram_user_profile_picture' => array(
                'label'                 => esc_html__('User profile Picture', 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'upload_button_text'    => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'instagram_settings',
                'show_if'         => array(
                    'show_instagram_user_info'     => 'on'
                ),
                'default'              => ''

            ),
            'instagram_username_text' => array(
                'label'           => esc_html__('Username Text', 'divi_flash'),
                'type'            => 'text',
                'description'     => esc_html__('Instagram Username Text entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'instagram_settings',
                'show_if'         => array(
                    'show_instagram_user_info'     => 'on'
                ),
                'default'           => '',
            ),
            'date_formate'    => array (
                'label'             => esc_html__( 'Post Date Formate', 'divi_flash' ),
				'type'              => 'text',
                'toggle_slug'       => 'instagram_settings',
                'option_category'   => 'configuration',
				'description'       => esc_html__( 'If you would like to adjust the date format, input the appropriate PHP date format here. To see example <a href="https://www.php.net/manual/en/function.date.php#example-2574"> Click Here </a>', 'et_builder' ),
				'show_if'			=> array (
					'show_instagram_user_info'		=> 'on'
				),
				'default'           => 'M j, Y',
            ),
            'instagram_icon_enable'  => array(
                'label'             => esc_html__('Use Instagram Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'instagram_settings',
                'show_if'         => array(
                    'show_instagram_user_info'     => 'on'
                )
            ),
            'instagram_icon' => array(
                'label'                 => esc_html__('Instagram Icon', 'divi_flash'),
                'type'                  => 'select_icon',
                'class' => array('et-pb-font-icon'),
                'default'           => '',
                'toggle_slug'     => 'instagram_settings',
                'show_if'         => array(
                    'show_instagram_user_info'     => 'on',
                    'instagram_icon_enable'     => 'on'

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
        $user_info_settings = array(
            'user_info_show_at_bottom'  => array(
                'label'             => esc_html__('User Info Show at Bottom', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'user_info',
                'tab_slug'       => 'advanced',
                'show_if'         => array(
                    'show_instagram_user_info'     => 'on'
                )
            ),

            'instagram_user_section_width' => array(
                'label'             => esc_html__('User Info Width', 'divi_flash'),
                'description'       => esc_html__('container without instagram icon (profile picture and user info)' , 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'user_info',
                'tab_slug'       => 'advanced',
                'default'           => '70%',
                'default_unit'      => '%',
                'allowed_units'     => array('%','px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if'         => array(
                    'show_instagram_user_info'     => 'on'
                ),
            ),
            'user_profile_picture_width' => array(
                'label'             => esc_html__('Profile Picture Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'user_info',
                'tab_slug'          => 'advanced',
                'default'           => '50',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '300',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if_not'       => array(
                    'instagram_user_profile_picture' => array('')
                ),
                'show_if'         => array(
                    'show_instagram_user_info'     => 'on'
                ),
            ),
            'instagram_icon_alignment' => array(
                'label'           => esc_html__('Icon Alignment', 'divi_flash'),
                'type'            => 'text_align',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'       => 'user_info',
                'tab_slug'       => 'advanced',
                'mobile_options'    => true,
                'show_if'         => array(
                    'instagram_icon_enable'     => 'on',
                    'show_instagram_user_info'     => 'on'
                ),
            ),
            'instagram_icon_position' => array(
                'label'           => esc_html__('Icon Position', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'flex-start' => esc_html__('Start', 'divi_flash'),
                    'center'     => esc_html__('Center', 'divi_flash'),
                    'flex-end'   => esc_html__('End', 'divi_flash'),
                ),
                'default'           => 'center',
                'option_category' => 'basic_option',
                'toggle_slug'       => 'user_info',
                'tab_slug'       => 'advanced',
                'description'     => esc_html__('Choose Instagram Icon Position', 'divi_flash'),
                'show_if'         => array(
                    'instagram_icon_enable'     => 'on',
                    'show_instagram_user_info'     => 'on'
                ),
            ),
            'instagram_icon_size' => array(
                'label'             => esc_html__('Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'user_info',
                'tab_slug'       => 'advanced',
                'default'           => '48px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '500',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if'         => array(
                    'instagram_icon_enable'     => 'on',
                    'show_instagram_user_info'     => 'on'
                ),
            ),
            'instagram_icon_color' => array(
                'label'                 => esc_html__('Icon Color', 'divi_flash'),
                'default'           => "rgba(255,255,255,1)",
                'type'            => 'color-alpha',
                'toggle_slug'   => 'user_info',
                'tab_slug'        => 'advanced',
                //'depends_show_if'     => 'on',
                'show_if'         => array(
                    'instagram_icon_enable'     => 'on',
                    'show_instagram_user_info'     => 'on'
                ),
                'hover'            => 'tabs'
            ),
            
        );
        $hover = array(
            'overlay'    => array(
                'label'         => esc_html__('Overlay', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'hover',
            ),
            'overlay_primary'  => array(
                'label'             => esc_html__( 'Overlay Primary color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'hover',
                'default'           => '#00B4DB',
                'show_if'           => array(
                    'overlay'  => 'on'
                )
            ),
            'overlay_secondary'  => array(
                'label'             => esc_html__( 'Overlay Secondary color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'hover',
                'default'           => '#0083B0',
                'show_if'           => array(
                    'overlay'  => 'on'
                )
            ),
            'overlay_direction'    => array (
                'label'             => esc_html__( 'Overlay Gradient Direction', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'hover',
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
            'border_anim'    => array(
                'label'         => esc_html__('Border Animation', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'hover'
            ),
            'anm_border_color'  => array(
                'label'             => esc_html__( 'Border Color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'hover',
                'default'           => '#ffffff',
                'show_if'           => array(
                    'border_anim'  => 'on'
                )
            ),
            'anm_border_width'    => array (
                'label'             => esc_html__( 'Border Width', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'hover',
                'default'           => '3px',
                'default_unit'      => '',
                'allowed_units'     => array ('px'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '20',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if'           => array(
                    'border_anim'  => 'on'
                )
            ),
            'anm_border_margin'    => array (
                'label'             => esc_html__( 'Border Space', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'hover',
                'default'           => '15px',
                'default_unit'      => '',
                'allowed_units'     => array ('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '50',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if'           => array(
                    'border_anim'  => 'on'
                )
            ),
            'border_anm_style'    => array(
                'label'         => esc_html__('Border Animation Style', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'c4-border-center'          => esc_html__('Border Center', 'divi_flash'),
                    'c4-border-top'             => esc_html__('Border Top', 'divi_flash'),
                    'c4-border-bottom'          => esc_html__('Border Bottom', 'divi_flash'),
                    'c4-border-right'           => esc_html__('Border Right', 'divi_flash'),
                    'c4-border-vert'            => esc_html__('Border Vertical', 'divi_flash'),
                    'c4-border-horiz'           => esc_html__('Border Horizontal', 'divi_flash'),
                    'c4-border-top-left'        => esc_html__('Border Top Left', 'divi_flash'),
                    'c4-border-top-right'       => esc_html__('Border Top Right', 'divi_flash'),
                    'c4-border-bottom-left'     => esc_html__('Border Bottom Left', 'divi_flash'),
                    'c4-border-bottom-right'    => esc_html__('Border Bottom Right', 'divi_flash'),
                    'c4-border-corners-1'       => esc_html__('Border Corner 1', 'divi_flash'),   
                    'c4-border-corners-2'       => esc_html__('Border Corner 2', 'divi_flash'),   
                    'c4-border-cc-1'            => esc_html__('Border CC 1', 'divi_flash'),   
                    'c4-border-cc-2'            => esc_html__('Border CC 2', 'divi_flash'),   
                    'c4-border-cc-3'            => esc_html__('Border CC 3', 'divi_flash'),   
                    'c4-border-ccc-1'           => esc_html__('Border CCC 1', 'divi_flash'),   
                    'c4-border-ccc-2'           => esc_html__('Border CCC 2', 'divi_flash'),   
                    'c4-border-ccc-3'           => esc_html__('Border CCC 3', 'divi_flash'),   
                    'c4-border-fade'            => esc_html__('Border Fade', 'divi_flash'),   
                ),
                'default'       => 'c4-border-fade',
                'toggle_slug'   => 'hover',
                'show_if'       => array(
                    'border_anim'   => 'on'
                )
            ),
            'anm_content_padding'    => array (
                'label'             => esc_html__( 'Content Space', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'hover',
                'default'           => '1em',
                'default_unit'      => '',
                'allowed_units'     => array ('em'),
                'range_settings'    => array(
                    'min'  => '.5',
                    'max'  => '3',
                    'step' => '.1',
                ),
                'mobile_options'    => true
            ),
            'content_position'    => array(
                'label'         => esc_html__('Content Position', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'c4-layout-top-left'        => esc_html__('Top Left', 'divi_flash'),
                    'c4-layout-top-center'      => esc_html__('Top Center', 'divi_flash'),
                    'c4-layout-top-right'       => esc_html__('Top Right', 'divi_flash'),
                    'c4-layout-center-left'     => esc_html__('Center Left', 'divi_flash'),
                    'c4-layout-center'          => esc_html__('Center', 'divi_flash'),
                    'c4-layout-center-right'    => esc_html__('Center Right', 'divi_flash'),
                    'c4-layout-bottom-left'     => esc_html__('Bottom Left', 'divi_flash'),
                    'c4-layout-bottom-center'   => esc_html__('Bottom Center', 'divi_flash'),
                    'c4-layout-bottom-right'    => esc_html__('Bottom Right', 'divi_flash')
                ),
                'default'       => 'c4-layout-top-left',
                'toggle_slug'   => 'hover'
            ),
            'image_scale'    => array(
                'label'    => esc_html__('Image Scale Type', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'no-image-scale'            => esc_html__('None', 'divi_flash'),
                    'c4-image-zoom-in'          => esc_html__('Zoom In', 'divi_flash'),
                    'c4-image-zoom-out'         => esc_html__('Zoom Out', 'divi_flash'),
                    'c4-image-pan-up'           => esc_html__('Pan Up', 'divi_flash'),
                    'c4-image-pan-down'         => esc_html__('Pan Down', 'divi_flash'),
                    'c4-image-pan-left'         => esc_html__('Pan Left', 'divi_flash'),
                    'c4-image-pan-right'        => esc_html__('Pan Right', 'divi_flash'),
                    'c4-image-rotate-left'      => esc_html__('Rotate Left', 'divi_flash'),
                    'c4-image-rotate-right'     => esc_html__('Rotate Right', 'divi_flash'),
                    'c4-image-blur'             => esc_html__('Blur', 'divi_flash')
                ),
                'default'       => 'no-image-scale',
                'toggle_slug'   => 'hover'
            ),
            'image_scale_hover'    => array (
                'label'             => esc_html__( 'Scale', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'hover',
                'default'           => '1.3',
                'allowed_units'     => array (),
                'range_settings'    => array(
                    'min'  => '1.3',
                    'max'  => '3',
                    'step' => '.1',
                ),
                'validate_unit'    => false,
                'show_if'          => array (
                    'image_scale' => array( 'c4-image-rotate-left', 'c4-image-rotate-right')
                )
            ),
            'use_icon'                  => array(
				'label'                 => esc_html__( 'Use Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
                'default'               => 'off',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => 'hover',
                'affects'               => array (
                    'font_icon',
                    'icon_color',
                    'icon_size'
				)
            ),
            'hover_icon' => array(
                'label'                 => esc_html__('Hover Icon', 'divi_flash'),
                'type'                  => 'select_icon',
                'class' => array('et-pb-font-icon'),
                'default'           => 'P',
                'toggle_slug'     => 'hover',
                'show_if'         => array(
                    'use_icon'     => 'on',
                ),
            ),
            'show_caption'    => array(
                'label'         => esc_html__('Show Caption', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'hover',
            ),
            
            'always_show_title'  => array(
                'label'         => esc_html__('Always Show Caption', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'hover',
                'show_if' => array(
                    'show_caption' => 'on'
                )
            ),
            'content_reveal_caption'    => array(
                'label'    => esc_html__('Caption Reveal', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'c4-reveal-up'            => esc_html__('Reveal Top', 'divi_flash'),
                    'c4-reveal-down'          => esc_html__('Reveal Down', 'divi_flash'),
                    'c4-reveal-left'          => esc_html__('Reveal Left', 'divi_flash'),
                    'c4-reveal-right'         => esc_html__('Reveal Right', 'divi_flash'),
                    'c4-fade-up'              => esc_html__('Fade Up', 'divi_flash'),
                    'c4-fade-down'            => esc_html__('Fade Down', 'divi_flash'),
                    'c4-fade-left'            => esc_html__('Fade Left', 'divi_flash'),
                    'c4-fade-right'           => esc_html__('Fade Right', 'divi_flash'),
                    'c4-rotate-up-right'      => esc_html__('Rotate Up Right', 'divi_flash'),
                    'c4-rotate-up-left'       => esc_html__('Rotate Up Left', 'divi_flash'),
                    'c4-rotate-down-right'    => esc_html__('Rotate Down Right', 'divi_flash'),
                    'c4-rotate-down-left'     => esc_html__('Rotate Down Left', 'divi_flash')
                ),
                'default'       => 'c4-fade-up',
                'toggle_slug'   => 'hover',
                'show_if_not'   => array(
                    'always_show_title' => 'on'
                ),
                'show_if' => array(
                    'show_caption' => 'on'
                )
            ),
         
            
        );

        $hover_design = array(
            'hover_icon_size' => array(
                'label'             => esc_html__('Hover Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'hover_design',
                'tab_slug'       => 'advanced',
                'default'           => '36px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '500',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if'         => array(
                    'use_icon'     => 'on',
                ),
            ),
            'hover_icon_color' => array(
                'label'                 => esc_html__('Hover Icon Color', 'divi_flash'),
                'default'           => "rgba(0,0,0,1)",
                'type'            => 'color-alpha',
                'toggle_slug'   => 'hover_design',
                'tab_slug'        => 'advanced',
                //'depends_show_if'     => 'on',
                'show_if'         => array(
                    'use_icon'     => 'on',
                ),
                'hover'            => 'tabs'
            ),
        );

        $alignment = array(
            'instagram_username_align' => array(
                'label'             => esc_html__( 'Username Alignment', 'divi_flash' ),
				'type'              => 'text_align',
				'options'           => et_builder_get_text_orientation_options(array('justified')),
				'toggle_slug'   => 'font_styles',
                'sub_toggle'    => 'username',
                'tab_slug'		=> 'advanced',
                'show_if'         => array(
                    'show_instagram_user_info'     => 'on'
                ),
            ),
            'instagram_post_date_align' => array(
                'label'             => esc_html__( 'Post Date Alignment', 'divi_flash' ),
				'type'              => 'text_align',
				'options'           => et_builder_get_text_orientation_options(array('justified')),
				'toggle_slug'   => 'font_styles',
                'sub_toggle'    => 'post_date',
                'tab_slug'		=> 'advanced',
                'show_if'         => array(
                    'show_instagram_user_info'     => 'on'
                ),

            ),
            'more_btn_align' => array(
                'label'             => esc_html__( 'Alignment', 'divi_flash' ),
				'type'              => 'text_align',
				'options'           => et_builder_get_text_orientation_options(array('justified')),
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'more_btn'
            )
        );
        $button = array(
            'spinner_color' => array(
                'label'             => esc_html__( 'Loading Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'more_btn',
                'default'           => '#2665e0'
            )
        );
        $tag = array(
            'caption_tag' => array (
                'default'         => 'h4',
                'label'           => esc_html__( 'Caption Tag', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'h1'    => esc_html__( 'h1 tag', 'divi_flash' ),
                    'h2'    => esc_html__( 'h2 tag', 'divi_flash' ),
                    'h3'    => esc_html__( 'h3 tag', 'divi_flash' ),
                    'h4'    => esc_html__( 'h4 tag', 'divi_flash' ),
                    'h5'    => esc_html__( 'h5 tag', 'divi_flash' ),
                    'h6'    => esc_html__( 'h6 tag', 'divi_flash'),
                    'p'     => esc_html__( 'p tag', 'divi_flash'),
                    'span'  => esc_html__( 'span tag', 'divi_flash')
                ),
                'toggle_slug'     => 'font_styles',
                'tab_slug'        => 'advanced',
                'sub_toggle'      => 'caption'
            ),
        );
        $user_info_bg = $this->df_add_bg_field(array(
            'label'				=> 'Background',
            'key'               => 'user_info_bg',
            'toggle_slug'       => 'user_info',
            'tab_slug'			=> 'advanced',
            'hover'				=> 'tabs',
        ));
        $more_btn_bg = $this->df_add_bg_field(array(
            'label'				=> 'Background',
            'key'               => 'more_btn_bg',
            'toggle_slug'       => 'more_btn',
            'tab_slug'			=> 'advanced',
            'hover'				=> 'tabs',
            'image'             => false
        ));
        $title = $this->add_margin_padding(array(
            'title'         => 'Caption',
            'key'           => 'title',
            'toggle_slug'   => 'margin_padding',
            'option'        => 'padding'
        ));
      
        $load_more_button = $this->add_margin_padding(array(
            'title'         => 'Load More',
            'key'           => 'load_more',
            'toggle_slug'   => 'margin_padding'
        ));
        $content_spacing = array(
            'instagram_user_info_padding' => array(
                'label'               => sprintf(esc_html__('User Info Padding', 'divi_flash')),
                'toggle_slug' => 'margin_padding',
                'tab_slug'    => 'advanced',
                'type'        => 'custom_margin',
                'hover'            => 'tabs',
                'mobile_options'    => true,
                'show_if'       => array(
                    'show_instagram_user_info'     => 'on'
                )
            ),
            'instagram_user_profile_picture_margin' => array(
                'label'               => sprintf(esc_html__('Profile Picture Margin', 'divi_flash')),
                'toggle_slug' => 'margin_padding',
                'tab_slug'    => 'advanced',
                'type'        => 'custom_margin',
                'hover'            => 'tabs',
                'mobile_options'    => true,
                'show_if_not'       => array(
                    'instagram_user_profile_picture' => array('')
                ),
                'show_if'       => array(
                    'show_instagram_user_info'     => 'on'
                )
            ),
            'instagram_user_profile_picture_padding' => array(
                'label'               => sprintf(esc_html__('Profile Picture Padding', 'divi_flash')),
                'toggle_slug' => 'margin_padding',
                'tab_slug'    => 'advanced',
                'type'        => 'custom_margin',
                'hover'            => 'tabs',
                'mobile_options'    => true,
                'show_if_not'       => array(
                    'instagram_user_profile_picture' => array('')
                ),
                'show_if'       => array(
                    'show_instagram_user_info'     => 'on'
                )
            ),
            'instagram_user_name_margin' => array(
                'label'               => sprintf(esc_html__('Username Margin', 'divi_flash')),
                'toggle_slug' => 'margin_padding',
                'tab_slug'    => 'advanced',
                'type'        => 'custom_margin',
                'hover'            => 'tabs',
                'mobile_options'    => true,
                'show_if'       => array(
                    'show_instagram_user_info'     => 'on'
                )
            ),
            'instagram_post_date_margin' => array(
                'label'               => sprintf(esc_html__('Post Date Margin', 'divi_flash')),
                'toggle_slug' => 'margin_padding',
                'tab_slug'    => 'advanced',
                'type'        => 'custom_margin',
                'hover'            => 'tabs',
                'mobile_options'    => true,
                'show_if'       => array(
                    'show_instagram_user_info'     => 'on'
                )
            ),
            'instagram_icon_margin' => array(
                'label'               => sprintf(esc_html__('Icon Margin', 'divi_flash')),
                'toggle_slug' => 'margin_padding',
                'tab_slug'    => 'advanced',
                'type'        => 'custom_margin',
                'hover'            => 'tabs',
                'mobile_options'    => true,
                'show_if'       => array(
                    'show_instagram_user_info'     => 'on',
                    'instagram_icon_enable'        => 'on'
                )
            ),
            
        );
        return array_merge(
            $general,
            $instagram_settings,
            $user_info_bg,
            $user_info_settings,
            $hover,
            $hover_design,
            $tag,
            $alignment,
            $content_spacing,
            $button,
            $more_btn_bg,
            $title,
            $load_more_button
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $instagram_icon = '%%order_class%% .df-instagram-feed-icon .et-pb-icon'; 
        $instagram_user_profile_picture = '%%order_class%% .df-instagram-user-profile-picture'; 
        $fields['instagram_icon_color'] = array('color' => $instagram_icon);

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'more_btn_bg',
            'selector'      => '%%order_class%% .ing-load-more-btn'
        ));

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'user_info_bg',
            'selector'      => '%%order_class%% .df-instagram-user-info'
        ));
      

        $fields['title_padding'] = array ('padding' => '%%order_class%% .df_ing_caption');
        $fields['load_more_margin'] = array ('margin' => '%%order_class%% .ing-load-more-btn');
        $fields['load_more_padding'] = array ('padding' => '%%order_class%% .ing-load-more-btn');
        
        $fields['instagram_user_info_padding'] = array ('padding' => '%%order_class%% .df-instagram-user-info');
        $fields['instagram_user_profile_picture_margin'] = array ('margin' => $instagram_user_profile_picture);
        $fields['instagram_user_profile_picture_padding'] = array ('padding' => $instagram_user_profile_picture);
        $fields['instagram_user_name_margin'] = array ('margin' => '%%order_class%% .df-instagram-user-name');
        $fields['instagram_post_date_margin'] = array ('margin' => '%%order_class%% .df-instagram-postdate');
        $fields['instagram_icon_margin'] = array ('margin' => $instagram_icon);
         
        // border fix
 
        $fields = $this->df_fix_border_transition(
            $fields, 
            'image', 
            '%%order_class%% .df_ing_image .item-content'
        );

        $fields = $this->df_fix_border_transition(
            $fields, 
            'morebtn_border', 
            '%%order_class%% .ing-load-more-btn'
        );

        $fields = $this->df_fix_border_transition(
            $fields, 
            'user_info_border', 
            '%%order_class%% .df-instagram-user-info'
        );

        return $fields;
    }
    
    public function additional_css_styles($render_slug) {

        if (isset($this->props['image_to_display'])) {
            $image_width = 100/$this->props['image_to_display'] . '%';
            $image_width_tablet = isset($this->props['image_to_display_tablet']) && $this->props['image_to_display_tablet'] !== '' ?
                100/$this->props['image_to_display_tablet'] . '%' : $image_width;
            $image_width_phone = isset($this->props['image_to_display_phone']) && $this->props['image_to_display_phone'] !== '' ?
                100/$this->props['image_to_display_phone'] . '%' : $image_width_tablet;

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .grid-sizer, %%order_class%% .grid-item',
                'declaration' => sprintf('width: %1$s;', $image_width)
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .grid-sizer, %%order_class%% .grid-item',
                'declaration' => sprintf('width: %1$s;', $image_width_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .grid-sizer, %%order_class%% .grid-item',
                'declaration' => sprintf('width: %1$s;', $image_width_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
        if (isset($this->props['item_gutter'])) {
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'item_gutter',
                'type'              => 'padding-left',
                'selector'          => '%%order_class%% .grid .grid-item'
            ) );
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'item_gutter',
                'type'              => 'padding-bottom',
                'selector'          => '%%order_class%% .grid .grid-item'
            ) );
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'item_gutter',
                'type'              => 'margin-left',
                'selector'          => '%%order_class%% .grid',
                'negative'          => true
            ) );
        }
        if( 'on' === $this->props['show_instagram_user_info']){
            if ('on' === $this->props['user_info_show_at_bottom']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_ing_container .item-content',
                    'declaration' => 'flex-direction: column-reverse;'
                ));
            }
            if ('on' === $this->props['instagram_icon_enable']) {
                $this->df_process_color(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'instagram_icon_color',
                    'type'              => 'color',
                    'selector'            => "%%order_class%% .df-instagram-feed-icon .et-pb-icon",
                    'hover'             => '%%order_class%% .item-content:hover .df-instagram-feed-icon .et-pb-icon'
                ));
    
                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'instagram_icon_size',
                    'type'              => 'font-size',
                    'selector'            => "%%order_class%% .df-instagram-feed-icon .et-pb-icon",
                ));
                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'instagram_user_section_width',
                    'type'              => 'flex-basis',
                    'selector'    => '%%order_class%% a.df-instagram-user',
                ));
            }else{
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% a.df-instagram-user",
                    'declaration' => 'flex-basis: 100%;',
                ));
            }
        

            $slug = 'instagram_user_section_width';
            $selector_property = 'flex-basis';
            $image_container_width_desktop  =  !empty($this->props[$slug]) ? 
                $this->df_process_values($this->props[$slug]) : '20%';
            $image_container_width_tablet   =  !empty($this->props[$slug.'_tablet']) ? 
                $this->df_process_values($this->props[$slug.'_tablet']) : $image_container_width_desktop;
            
            $image_container_width_phone   =  !empty($this->props[$slug.'_phone']) ? 
                $this->df_process_values($this->props[$slug.'_phone']) : $image_container_width_tablet;
            
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% a.df-instagram-feed-icon",
                'declaration' => $selector_property.':  calc(100% - '.$image_container_width_desktop.');',
            ));
            
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% a.df-instagram-feed-icon",
                'declaration' =>$selector_property.':  calc(100% - '.$image_container_width_tablet.');',
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% a.df-instagram-feed-icon",
                'declaration' =>$selector_property.':  calc(100% - '.$image_container_width_phone.');',
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
           
            if ('' !== $this->props['instagram_icon_position']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% .df-instagram-user-info",
                    'declaration' => sprintf('
                    align-items: %1$s;',  $this->props['instagram_icon_position']),
                ));
            }
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'user_profile_picture_width',
                'type'              => 'width',
                'selector'    => "%%order_class%% .df-instagram-user-profile-picture",
            ));

            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'instagram_icon_alignment',
                'type'              => 'text-align',
                'selector'          => "%%order_class%% a.df-instagram-feed-icon",
                'default'           => 'right'
            ));
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'instagram_username_align',
                'type'              => 'text-align',
                'selector'          => "%%order_class%% span.df-instagram-user-name",
                'default'           => 'left'
            ));
        
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'instagram_post_date_align',
                'type'              => 'text-align',
                'selector'          => "%%order_class%% span.df-instagram-postdate",
                'default'           => 'left'
            ));

            $this->df_process_bg(array(
                'render_slug'       => $render_slug,
                'slug'              => 'user_info_bg',
                'selector'          => '%%order_class%% .df-instagram-user-info',
                'hover'             => '%%order_class%% .df-instagram-user-info:hover'
            ));

            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'instagram_user_info_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df-instagram-user-info',
                'hover'             => '%%order_class%% .df-instagram-user-info:hover',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'instagram_user_profile_picture_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df-instagram-user-profile-picture',
                'hover'             => '%%order_class%% .df-instagram-user-info:hover .df-instagram-user-profile-picture',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'instagram_user_profile_picture_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df-instagram-user-profile-picture',
                'hover'             => '%%order_class%% .df-instagram-user-info:hover .df-instagram-user-profile-picture',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'instagram_post_date_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df-instagram-postdate',
                'hover'             => '%%order_class%% .df-instagram-user-info:hover .df-instagram-postdate',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'instagram_user_name_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df-instagram-user-name',
                'hover'             => '%%order_class%% .df-instagram-user-info:hover .df-instagram-user-name',
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'instagram_icon_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .et-pb-icon.instagram_icon',
                'hover'             => '%%order_class%% .df-instagram-user-info:hover .et-pb-icon.instagram_icon',
            ));   
        }
        if($this->props['use_icon'] === 'on'){
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'hover_icon_color',
                'type'              => 'color',
                'selector'            => "%%order_class%% .et-pb-icon.hover_icon",
                'hover'             => '%%order_class%% .et-pb-icon.hover_icon:hover'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'hover_icon_size',
                'type'              => 'font-size',
                'selector'            => "%%order_class%% .et-pb-icon.hover_icon",
            ));
        }
        if ($this->props['image_scale'] === 'c4-image-rotate-left') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .c4-image-rotate-left:hover img, %%order_class%% :focus.c4-image-rotate-left img',
                'declaration' => sprintf('transform: scale(%1$s) rotate(-15deg);', $this->props['image_scale_hover'])
            ));
        }
        if ($this->props['image_scale'] === 'c4-image-rotate-right') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .c4-image-rotate-right:hover img, %%order_class%% :focus.c4-image-rotate-right img',
                'declaration' => sprintf('transform: scale(%1$s) rotate(15deg);', $this->props['image_scale_hover'])
            ));
        }
      
        if (isset($this->props['more_btn_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ing_button_container',
                'declaration' => sprintf('text-align: %1$s;', $this->props['more_btn_align'])
            ));
        }
        if($this->props['overlay'] !== 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .c4-izmir',
                'declaration' => '--image-opacity: 1;'
            ));
        }
        if($this->props['overlay'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .c4-izmir .df-overlay',
                'declaration' => sprintf('background-image: linear-gradient(%4$s, %1$s 0, %2$s %3$s);',
                    $this->props['overlay_primary'],
                    $this->props['overlay_secondary'],
                    '100%',
                    $this->props['overlay_direction']
                )
            ));
        }
        if($this->props['border_anim'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .c4-izmir',
                'declaration' => sprintf('
                    --border-color: %1$s;',
                    $this->props['anm_border_color']
                ),
            ));
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'anm_border_width',
                'type'              => '--border-width',
                'selector'          => '%%order_class%% .c4-izmir'
            ) );
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'anm_border_margin',
                'type'              => '--border-margin',
                'selector'          => '%%order_class%% .c4-izmir'
            ) );
        }
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'anm_content_padding',
            'type'              => '--padding',
            'selector'          => '%%order_class%% .c4-izmir'
        ) );

        // loadign icon color
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'spinner_color',
            'type'              => 'fill',
            'selector'          => '%%order_class%% .ing-load-more-btn .spinner svg'
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'more_btn_bg',
            'selector'          => '%%order_class%% .ing-load-more-btn',
            'hover'             => '%%order_class%% .ing-load-more-btn:hover'
        ));
      
        // spacing: title
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ing_caption',
            'hover'             => '%%order_class%% .item-content:hover .df_ing_caption',
        ));
        // spacing: description
     
        // spacing: load more
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'load_more_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .ing-load-more-btn',
            'hover'             => '%%order_class%% .ing-load-more-btn:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'load_more_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .ing-load-more-btn',
            'hover'             => '%%order_class%% .ing-load-more-btn:hover',
        ));
        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
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
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'instagram_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.instagram_icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }
    }

    public function df_render_instagram_icon()
    {
        if (isset($this->props['instagram_icon_enable']) && $this->props['instagram_icon_enable'] === 'on') {

            return sprintf(
                isset($this->props['instagram_icon']) && $this->props['instagram_icon'] !== '' ?
                    esc_attr(et_pb_process_font_icon($this->props['instagram_icon'])) : esc_attr(et_pb_process_font_icon('5'))
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
        $this->additional_css_styles($render_slug);
        wp_enqueue_script('imageload');
        wp_enqueue_script('df-imagegallery-lib');
        wp_enqueue_script('df-instagramgallery');
        
        $load_more = $this->props['load_more'];

        $image_ids = '';
        $images_array = [];

        $instagram_client_id = (!empty($this->props['instagram_client_id'])) ? $this->props['instagram_client_id'] : '';
        $instagram_client_secret = (!empty($this->props['instagram_client_secret'])) ? $this->props['instagram_client_secret'] : '';
        $instagram_user_token = (!empty($this->props['instagram_user_token'])) ? $this->props['instagram_user_token'] : '';
        $item_limit = (!empty($this->props['item_limit'])) ? $this->props['item_limit'] : '';
        $cache_time = !empty($this->props['cache_time']) ? $this->props['cache_time'] : '-1';
	    $cache_time_type = $this->props['cache_time_type'];
        
        $settings_data= array(
            'item_limit' => $item_limit,
            'cache_time' => $cache_time,
            'cache_time_type' => $cache_time_type,
            'unique_module'=> self::get_module_order_class( $render_slug )
        );

        $instagram_obj = new DF_Instagram_Process($instagram_client_id, $instagram_client_secret, $instagram_user_token);
        $images_array = $instagram_obj->get_instagram_data($settings_data, self::get_module_order_class( $render_slug ));


        if($this->props['instagram_post_only_image'] =='on'){
                
            $media_type= "IMAGE";
            $images_array = array_filter(
                        $images_array,
                        function ($value) use ($media_type) {
                            return $value->media_type == $media_type;
                        },
                        ARRAY_FILTER_USE_BOTH
                    );
        }
        // post icon element generate
        $this->df_image_props = $this->props;
        $this->df_image_props['unique_module_name']	= self::get_module_order_class( $render_slug );
        $this->df_image_props['instagram_icon'] = $this->df_render_instagram_icon();
        $this->df_image_props['hover_icon'] = $this->df_render_hover_icon();
        $this->df_image_props['total_item'] = intval(count($images_array));

        
        $options = df_intagram_gallery_options(
            array('images_array' => $images_array),
            $this->df_image_props
        );
    
        $images = df_ing_render_images($options);
        $error_msg = "";
        $instagram_data = true;
        if (isset(($instagram_obj->get_instagram_account_id($instagram_user_token) )->status) === 400 ) {
            $error_msg = "Your Instagram User access token is not valid";
            $instagram_data = false;
        }else if(intval(count($images_array)) < 1){
            if($item_limit < 0 ){
                $error_msg = "Item limit should more then 0";
               
            }else{
                $error_msg = "No data found from instagram";
            } 
            $instagram_data = false;
            
        }else{
            $instagram_data = true;
        }
                                                        
        $user_token_exits_msg = $this->props['instagram_user_token'] == '' ? 'Please Enter Access token':  $error_msg;
       
        $load_more_button = $load_more === 'on' && count($images_array) > $this->props['init_count']  ?
            sprintf('<div class="df_ing_button_container">
                    <button class="ing-load-more-btn" data-loaded="%2$s">%1$s <span class="spinner">
                        <svg width="135" height="140" viewBox="0 0 135 140" xmlns="http://www.w3.org/2000/svg" fill="#fff">
                            <rect y="10" width="15" height="120" rx="6">
                                <animate attributeName="height"
                                    begin="0.5s" dur="1s"
                                    values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                    repeatCount="indefinite" />
                                <animate attributeName="y"
                                    begin="0.5s" dur="1s"
                                    values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                    repeatCount="indefinite" />
                            </rect>
                            <rect x="30" y="10" width="15" height="120" rx="6">
                                <animate attributeName="height"
                                    begin="0.25s" dur="1s"
                                    values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                    repeatCount="indefinite" />
                                <animate attributeName="y"
                                    begin="0.25s" dur="1s"
                                    values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                    repeatCount="indefinite" />
                            </rect>
                            <rect x="60" width="15" height="140" rx="6">
                                <animate attributeName="height"
                                    begin="0s" dur="1s"
                                    values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                    repeatCount="indefinite" />
                                <animate attributeName="y"
                                    begin="0s" dur="1s"
                                    values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                    repeatCount="indefinite" />
                            </rect>
                            <rect x="90" y="10" width="15" height="120" rx="6">
                                <animate attributeName="height"
                                    begin="0.25s" dur="1s"
                                    values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                    repeatCount="indefinite" />
                                <animate attributeName="y"
                                    begin="0.25s" dur="1s"
                                    values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                    repeatCount="indefinite" />
                            </rect>
                            <rect x="120" y="10" width="15" height="120" rx="6">
                                <animate attributeName="height"
                                    begin="0.5s" dur="1s"
                                    values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                    repeatCount="indefinite" />
                                <animate attributeName="y"
                                    begin="0.5s" dur="1s"
                                    values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                    repeatCount="indefinite" />
                            </rect>
                        </svg>
                    </span></button>
                </div>', 
                sanitize_text_field($this->props['load_more_text']),
                sanitize_text_field($this->props['init_count'])
        ) : '';

        $data = df_intagram_gallery_options(
            array('image_ids' => ''),
            $this->df_image_props
        );
        unset($data['instagram_user_token']);
        unset($data['instagram_client_secret']);
        unset($data['instagram_client_id']);

        // filter for images
		if (array_key_exists('image', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['image'])) {
			$this->add_classname($this->generate_css_filters(
				$render_slug,
				'child_',
				self::$data_utils->array_get($this->advanced_fields['image']['css'], 'main', '%%order_class%%')
			));
		}
        if( $this->props['instagram_user_token'] !== '' && $instagram_data){
                return sprintf('<div class="df_ing_container" data-settings=\'%4$s\'>
                                %2$s
                                <div class="df_ing_gallery grid" style="opacity:1;">
                                    %1$s
                                
                                </div>
                                %3$s
                            </div>', 
                            $images, 
                            '', 
                            $load_more_button,
                            wp_json_encode($data)
                        );
        }else{
            return sprintf('<div class="df_ing_container error-section">
                             %1$s
                            </div>', 
                            $user_token_exits_msg
                        );
        }
        
    }
}
new DIFL_InstagramGallery;
