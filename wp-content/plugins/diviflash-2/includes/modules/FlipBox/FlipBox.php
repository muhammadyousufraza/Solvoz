<?php

class DIFL_FlipBox extends ET_Builder_Module {
    public $slug       = 'difl_flipbox';
    public $vb_support = 'on';
	public $icon_path;
    use DF_UTLS;

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Flip Box', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/flip.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'front_end_view'        => esc_html__('Builder View (Front/Back side)', 'divi_flash'),
                    'fb_content'            => array (
                        'title'             => esc_html__('Content', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'front'   => array(
                                'name' => 'Front',
                            ),
                            'back'     => array(
                                'name' => 'Back',
                            )
                        ),
                    ),
                    'fb_buttons'            => esc_html__('Button For Back Side', 'divi_flash'),
                    'fb_image'              => array (
                        'title'             => esc_html__('Image and icon settings', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'front'   => array(
                                'name' => 'Front',
                            ),
                            'back'     => array(
                                'name' => 'Back',
                            )
                        ),
                    ),
                    'fb_animation'          => esc_html__('Animation', 'divi_flash'),
                    'settings'              => esc_html__('Settings', 'divi_flash'),
                    'fb_background'         => esc_html__('Background Front Side', 'divi_flash'),
                    'fb_back_background'    => esc_html__('Background Back Side', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'content_align'         => esc_html__('Content Vertical Align', 'divi_flash'),
                    'image'                 => array (
                        'title'             => esc_html__('Image Styles', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'front'   => array(
                                'name' => 'Front',
                            ),
                            'back'     => array(
                                'name' => 'Back',
                            )
                        ),
                    ),
                    'image_border'          => esc_html__('Image Border', 'divi_flash'),
                    'title'                 => array (
                        'title'             => esc_html__('Title', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'front'   => array(
                                'name' => 'Front',
                            ),
                            'back'     => array(
                                'name' => 'Back',
                            )
                        )
                    ),
                    'content'               => array (
                        'title'             => esc_html__('Content', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'front'   => array(
                                'name' => 'Front',
                            ),
                            'back'     => array(
                                'name' => 'Back',
                            )
                        )
                    ),
                    'fb_button'             => esc_html__('Button', 'divi_flash'),
                    'border'                => esc_html__('Border', 'divi_flash'),
                    'custom_spacing'        => array (
                        'title'             => esc_html__('Custom Spacing', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'wrapper'   => array(
                                'name' => 'Wrapper',
                            ),
                            'front'     => array(
                                'name' => 'Front',
                            ),
                            'back'     => array(
                                'name' => 'Back',
                            )
                        )
                    ),
                    'front_box_shadow'         => esc_html__('Front Side Box Shadow', 'divi_flash'),
                    'back_box_shadow'         => esc_html__('Back Side Box Shadow', 'divi_flash')
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();
        $advanced_fields['fonts'] = array(
            'title'         => array(
                'label'         => esc_html__( 'Title', 'divi_flash' ),
                'toggle_slug'   => 'title',
                'tab_slug'		=> 'advanced',
                'sub_toggle'    => 'front',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_fb_front .title",
                    // 'hover' => "%%order_class%% .df_fb_front .title",
                    'important'	=> 'all'
                ),
            ),
            'content'         => array(
                'label'         => esc_html__( 'Content', 'divi_flash' ),
                'toggle_slug'   => 'content',
                'tab_slug'		=> 'advanced',
                'sub_toggle'    => 'front',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_fb_front .fb-text",
                    // 'hover' => "%%order_class%% .df_fb_back .title",
                    'important'	=> 'all'
                ),
            ),
            'title_back'       => array(
                'label'         => esc_html__( 'Title', 'divi_flash' ),
                'toggle_slug'   => 'title',
                'tab_slug'		=> 'advanced',
                'sub_toggle'    => 'back',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_fb_back .title",
                    // 'hover' => "%%order_class%% .df_fb_front .title",
                    'important'	=> 'all'
                ),
            ),
            'content_back'     => array(
                'label'         => esc_html__( 'Content', 'divi_flash' ),
                'toggle_slug'   => 'content',
                'tab_slug'		=> 'advanced',
                'sub_toggle'    => 'back',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_fb_back .fb-text",
                    // 'hover' => "%%order_class%% .df_fb_back .title",
                    'important'	=> 'all'
                ),
            ),
            'button'     => array(
                'label'         => esc_html__( 'Button', 'divi_flash' ),
                'toggle_slug'   => 'fb_button',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_fb_back .df_fb_button",
                    'hover' => "%%order_class%% .df_fb_back .df_fb_button:hover",
                    'important'	=> 'all'
                ),
            ),
        );
        $advanced_fields['borders'] = array (
            'default'               => true,
            'button_b'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_fb_button',
                        'border_radii_hover'  => '%%order_class%% .df_fb_button:hover',
                        'border_styles' => '%%order_class%% .df_fb_button',
                        'border_styles_hover' => '%%order_class%% .df_fb_button:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'fb_button'
            ),
            'front'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_fb_front .fb_inner',
                        'border_styles' => '%%order_class%% .df_fb_front .fb_inner',
                        'border_styles_hover' => '%%order_class%%:hover .df_fb_front .fb_inner',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'border',
                'label_prefix'      => esc_html__('Front Side', 'divi_flash')
            ),
            'back'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_fb_back .fb_inner',
                        'border_styles' => '%%order_class%% .df_fb_back .fb_inner',
                        'border_styles_hover' => '%%order_class%%:hover .df_fb_back .fb_inner',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'border',
                'label_prefix'      => esc_html__('Back Side', 'divi_flash')
            ),
            'image_f'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_fb_front .df_fb_image_container img',
                        'border_styles' => '%%order_class%% .df_fb_front .df_fb_image_container img',
                        'border_styles_hover' => '%%order_class%% .df_fb_front:hover .df_fb_image_container img',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'image_border',
                'label_prefix'      => esc_html__('Front Image', 'divi_flash')
            ),
            'image_b'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_fb_back .df_fb_image_container img',
                        'border_styles' => '%%order_class%% .df_fb_back .df_fb_image_container img',
                        'border_styles_hover' => '%%order_class%% .df_fb_back:hover .df_fb_image_container img',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'image_border',
                'label_prefix'      => esc_html__('Back Image', 'divi_flash')
            )
        );
        $advanced_fields['text'] = false;     
        $advanced_fields['filters'] = false;
        $advanced_fields['transform'] = false;
        $advanced_fields['box_shadow'] = array (
            'default'               => true,
            'front'                 => array(
                'css' => array(
                    'main' => "%%order_class%% .df_fb_front .fb_inner",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'front_box_shadow'
            ),
            'back'                 => array(
                'css' => array(
                    'main' => "%%order_class%% .df_fb_back .fb_inner",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'back_box_shadow'
            ),
            'fb_button'              => array(
                'css' => array(
                    'main' => "%%order_class%% .df_fb_back .df_fb_button",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'fb_button'
            )
        );
        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'important' => 'all'
            )
        );
        return $advanced_fields;
    }

    public function get_fields() {
        $content = array (
            'title_front'         => array (
                'label'             => esc_html__('Title', 'divi_flash'),
                'type'              => 'text',
                'toggle_slug'       => 'fb_content',
                'sub_toggle'        => 'front',
                'dynamic_content'   => 'text'
            ),
            'content_front'        => array (
                'label'             => esc_html__('Content', 'divi_flash'),
                'type'              => 'tiny_mce',
                'toggle_slug'       => 'fb_content',
                'sub_toggle'        => 'front',
                'dynamic_content'   => 'text'
            ),
            'title_back'      => array (
                'label'             => esc_html__('Title', 'divi_flash'),
                'type'              => 'text',
                'toggle_slug'       => 'fb_content',
                'sub_toggle'        => 'back',
                'dynamic_content'   => 'text'
            ),
            'content_back'    => array (
                'label'             => esc_html__('Content', 'divi_flash'),
                'type'              => 'tiny_mce',
                'toggle_slug'       => 'fb_content',
                'sub_toggle'        => 'back',
                'dynamic_content'   => 'text'
            ),
            'change_view'    => array (
                'label'             => esc_html__('Change Builder View Mode', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Front', 'divi_flash' ),
					'on'  => esc_html__( 'Back', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'front_end_view'
            ),
            'fb_front_align'      => array (
                'default'         => 'flex-start',
                'label'           => esc_html__( 'Front Side Alignment', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'flex-start'            => esc_html__( 'Top', 'divi_flash' ),
                    'center'                => esc_html__( 'Center', 'divi_flash' ),
                    'flex-end'              => esc_html__( 'Bottom', 'divi_flash' )
                ),
                'toggle_slug'     => 'content_align',
                'tab_slug'        => 'advanced'
            ),
            'fb_back_align'       => array (
                'default'         => 'flex-start',
                'label'           => esc_html__( 'Back Side Alignment', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'flex-start'            => esc_html__( 'Top', 'divi_flash' ),
                    'center'                => esc_html__( 'Center', 'divi_flash' ),
                    'flex-end'              => esc_html__( 'Bottom', 'divi_flash' )
                ),
                'toggle_slug'     => 'content_align',
                'tab_slug'        => 'advanced'
            ),
            'front_title_tag' => array (
                'default'         => 'h4',
                'label'           => esc_html__( 'Title Tag', 'divi_flash' ),
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
                'toggle_slug'   => 'title',
                'tab_slug'		=> 'advanced',
                'sub_toggle'    => 'front'
            ),
            'back_title_tag' => array (
                'default'         => 'h4',
                'label'           => esc_html__( 'Title Tag', 'divi_flash' ),
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
                'toggle_slug'   => 'title',
                'tab_slug'		=> 'advanced',
                'sub_toggle'    => 'back'
            )
        ); 
        $settings = array(
            'use_height'    => array (
                'label'             => esc_html__('Use Custom Height', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings'
            ),
            'fb_height'       => array (
                'label'             => esc_html__( 'Height', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'settings',
				'default'           => '500px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '1000',
					'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if'           => array(
                    'use_height'    => 'on'
                )
            ),
        );
        $fb_animation = array (
            'fb_animation'      => array (
                'default'         => 'rotate',
                'label'           => esc_html__( 'Aniamation Type', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'rotate'    => esc_html__( 'Rotate', 'divi_flash' ),
                    'zoom'      => esc_html__( 'Zoom', 'divi_flash' ),
                    'slide'     => esc_html__( 'Slide', 'divi_flash' ),
                    'fade'      => esc_html__( 'Fade', 'divi_flash' )
                    // 'box_cube'  => esc_html__('3D Cube', 'divi_flash')
                ),
                'toggle_slug'     => 'fb_animation'
            ),
            'fb_flip_direction'    => array (
                'default'         => 'rotate_left',
                'label'           => esc_html__( 'Rotate Direction', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'rotate_left'       => esc_html__( 'Rotate Left', 'divi_flash' ),
                    'rotate_right'      => esc_html__( 'Rotate Right', 'divi_flash' ),
                    'rotate_up'         => esc_html__( 'Rotate Up', 'divi_flash' ),
                    'rotate_down'       => esc_html__( 'Rotate Down', 'divi_flash' )
                ),
                'toggle_slug'     => 'fb_animation',
                'show_if'         => array (
                    'fb_animation'  => 'rotate'
                )  
            ),
            'fb_slide_direction'    => array (
                'default'         => 'slide_left',
                'label'           => esc_html__( 'Slide Direction', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'slide_left'       => esc_html__( 'Slide Left', 'divi_flash' ),
                    'slide_right'      => esc_html__( 'Slide Right', 'divi_flash' ),
                    'slide_up'         => esc_html__( 'Slide Up', 'divi_flash' ),
                    'slide_down'       => esc_html__( 'Slide Down', 'divi_flash' )
                ),
                'toggle_slug'     => 'fb_animation',
                'show_if'         => array (
                    'fb_animation'  => 'slide'
                )  
            ),
            'fb_zoom_direction'    => array (
                'default'         => 'zoom_center',
                'label'           => esc_html__( 'Zoom Direction', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'zoom_center'       => esc_html__( 'Center', 'divi_flash' ),
                    'zoom_left'         => esc_html__( 'Left', 'divi_flash' ),
                    'zoom_right'        => esc_html__( 'Right', 'divi_flash' ),
                    'zoom_up'           => esc_html__( 'Up', 'divi_flash' ),
                    'zoom_down'         => esc_html__( 'Down', 'divi_flash' )
                ),
                'toggle_slug'     => 'fb_animation',
                'show_if'         => array (
                    'fb_animation'  => 'zoom'
                )  
            ),
            'fb_content_float'      => array (
                'label'                 => esc_html__( 'Content Floating Effect', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => 'fb_animation',
                'show_if'         => array (
                    'fb_animation'  => 'rotate'
                ) 
            ),
            'fb_cf_translate'       => array (
                'label'             => esc_html__( 'Translate Z', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'fb_animation',
				'default'           => '50px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
                ),
                'show_if'         => array (
                    'fb_animation'  => 'rotate',
                    'fb_content_float'  => 'on'
                ) 
            ),
            'fb_cf_scale'       => array (
                'label'             => esc_html__( 'Scale', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'fb_animation',
				'default'           => '.9',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '.5',
					'max'  => '2',
					'step' => '.1',
                ),
                'show_if'           => array (
                    'fb_animation'  => 'rotate',
                    'fb_content_float'  => 'on'
                ) 
            )
        );
        $transition = $this->df_transition_options(array (
            'key'               => 'fb',
            'toggle_slug'       => 'fb_animation',
            'duration_default'  => '600ms'
        ));
        $fb_icon = $this->df_add_icon_settings(array (
            'title_prefix'          => 'image_front',
            'key'                   => 'image_front',
            'toggle_slug'           => 'fb_image',
            'sub_toggle'            => 'front',
            'default_size'          => '48px',
            'icon_alignment'        => true,
            'image_styles'          => true,
            'icon_bg'               => true,
            'circle_icon'           => true,
            'img_toggle'            => 'image',
            'img_tab'               => 'advanced',
            'max_width'             => true,
            'image_alt'             => true,
            'dynamic_option'        => true
        ));
        $fb_back_icon = $this->df_add_icon_settings(array (
            'title_prefix'          => 'image_back',
            'key'                   => 'image_back',
            'toggle_slug'           => 'fb_image',
            'sub_toggle'            => 'back',
            'default_size'          => '48px',
            'icon_alignment'        => true,
            'image_styles'          => true,
            'icon_bg'               => true,
            'circle_icon'           => true,
            'img_toggle'            => 'image',
            'img_tab'               => 'advanced',
            'max_width'             => true,
            'image_alt'             => true,
            'dynamic_option'        => true
        ));
        $fb_background = $this->df_add_bg_field(array (
			'label'				    => 'Background Front Side',
            'key'                   => 'fb_background',
            'toggle_slug'           => 'fb_background',
            'tab_slug'              => 'general'
		));
        $fb_back_background = $this->df_add_bg_field(array (
			'label'				    => 'Background Back Side',
            'key'                   => 'fb_back_background',
            'toggle_slug'           => 'fb_back_background',
            'tab_slug'              => 'general'
        ));
        $fb_buttons_bg = $this->df_add_bg_field(array (
			'label'				    => 'Button Background',
            'key'                   => 'fb_button_background',
            'toggle_slug'           => 'fb_button',
            'tab_slug'              => 'advanced'
        ));
        $fb_button_back = $this->df_add_btn_content(array (
            'key'                   => 'fb_btn',
            'toggle_slug'           => 'fb_buttons',
            'dynamic_option'        => true
        ));
        $fb_button_style = $this->df_add_btn_styles(array (
            'key'                   => 'fb_btn',
            'toggle_slug'           => 'fb_button',
            'tab_slug'              => 'advanced'
        ));
        $image_container_front_spacing = $this->add_margin_padding(array(
            'title'         => 'Image & Icon Container Front',
            'key'           => 'img_container_front',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'front'
        ));
        $image_container_back_spacing = $this->add_margin_padding(array(
            'title'         => 'Image & Icon Container Back',
            'key'           => 'img_container_back',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'back'
        ));
        $icon_padding_fornt = $this->add_margin_padding(array(
            'title'         => 'Icon',
            'key'           => 'icon_front',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'front'
        ));
        $icon_padding_back = $this->add_margin_padding(array(
            'title'         => 'Icon',
            'key'           => 'icon_back',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'back'
        ));
        $button_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Button Wrapper',
            'key'           => 'button_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'back'
        ));
        $button_spacing = $this->add_margin_padding(array(
            'title'         => 'Button',
            'key'           => 'button',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'back'
        ));
        $title_front_spacing = $this->add_margin_padding(array(
            'title'         => 'Front Title',
            'key'           => 'title_front',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'front'
        ));
        $title_back_spacing = $this->add_margin_padding(array(
            'title'         => 'Back Title',
            'key'           => 'title_back',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'back'
        ));
        $text_front_spacing = $this->add_margin_padding(array(
            'title'         => 'Front Text',
            'key'           => 'text_front',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'front'
        ));
        $text_back_spacing = $this->add_margin_padding(array(
            'title'         => 'Back Text',
            'key'           => 'text_back',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'back'
        ));
        $front_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Front Wrapper',
            'key'           => 'front_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper',
            'option'        => 'padding'
        ));
        $back_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Back Wrapper',
            'key'           => 'back_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper',
            'option'        => 'padding'
        ));
        $container_spacing = $this->add_margin_padding(array(
            'title'         => 'Container',
            'key'           => 'container',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));

        return array_merge (
            $content,
            $settings,
            $fb_button_back,
            $fb_button_style,
            $fb_icon,
            $fb_animation,
            $transition,
            $fb_back_icon,
            $fb_background,
            $fb_back_background,
            $fb_buttons_bg,
            $container_spacing,
            $front_wrapper_spacing,
            $back_wrapper_spacing,
            $image_container_front_spacing,
            $icon_padding_fornt,
            $image_container_back_spacing,
            $icon_padding_back,
            // $content_front_spacing,
            // $content_back_spacing,
            $title_front_spacing,
            $title_back_spacing,
            $text_front_spacing,
            $text_back_spacing,
            $button_wrapper_spacing,
            $button_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $container = '%%order_class%% .df_flipbox_container';
        $front_container = '%%order_class%% .df_fb_front .fb_inner';
        $front_image_container = '%%order_class%% .df_fb_front .df_fb_image_container';
        $front_icon = '%%order_class%% .df_fb_front .et-pb-icon';
        $front_image = '%%order_class%% .df_fb_front img';
        $front_title = '%%order_class%% .df_fb_front .title';
        $front_text = '%%order_class%% .df_fb_front .fb-text';
        $back_container = '%%order_class%% .df_fb_back .fb_inner';
        $back_image_container = '%%order_class%% .df_fb_back .df_fb_image_container';
        $back_icon = '%%order_class%% .df_fb_back .et-pb-icon';
        $back_image = '%%order_class%% .df_fb_back img';
        $back_title = '%%order_class%% .df_fb_back .title';
        $back_text = '%%order_class%% .df_fb_back .fb-text';
        $back_button_wrapper = '%%order_class%% .df_fb_back .df_fb_button_wrapper';
        $back_button = '%%order_class%% .df_fb_back .df_fb_button';


        // front icon and image
        $fields['image_front_icon_color'] = array( 'color' => $front_icon );
        $fields['image_front_icon_size'] = array( 'font-size' => $front_icon );
        $fields['image_front_icon_bg'] = array( 'background-color' => $front_icon );

        // back icon and image
        $fields['image_back_icon_color'] = array( 'color' => $back_icon );
        $fields['image_back_icon_size'] = array( 'font-size' => $back_icon );
        $fields['image_back_icon_bg'] = array( 'background-color' => $back_icon );

        // Wrapper Spacing
        $fields['container_margin'] = array('margin' => '%%order_class%% .et_pb_module_inner');
        $fields['container_padding'] = array('padding' => '%%order_class%% .et_pb_module_inner');
        $fields['front_wrapper_margin'] = array('margin' => $front_container);
        $fields['front_wrapper_padding'] = array('padding' => $front_container);
        $fields['back_wrapper_margin'] = array('margin' => $back_container);
        $fields['back_wrapper_padding'] = array('padding' => $back_container);
        // Front Spacing
        $fields['img_container_front_margin'] = array('margin' => $front_image_container);
        $fields['img_container_front_padding'] = array('padding' => $front_image_container);
        $fields['title_front_margin'] = array('margin' => $front_title);
        $fields['title_front_padding'] = array('padding' => $front_title);
        $fields['text_front_margin'] = array('margin' => $front_text);
        $fields['text_front_padding'] = array('padding' => $front_text);
        $fields['icon_front_margin'] = array('margin' => $front_icon);
        $fields['icon_front_padding'] = array('padding' => $front_icon);
        // Back Spacing
        $fields['img_container_back_margin'] = array('margin' => $back_image_container);
        $fields['img_container_back_padding'] = array('padding' => $back_image_container);
        $fields['title_back_margin'] = array('margin' => $back_title);
        $fields['title_back_padding'] = array('padding' => $back_title);
        $fields['text_back_margin'] = array('margin' => $back_text);
        $fields['text_back_padding'] = array('padding' => $back_text);
        $fields['button_wrapper_margin'] = array('margin' => $back_button_wrapper);
        $fields['button_wrapper_padding'] = array('padding' => $back_button_wrapper);
        $fields['button_margin'] = array('margin' => $back_button);
        $fields['button_padding'] = array('padding' => $back_button);
        $fields['icon_back_margin'] = array('margin' => $back_icon);
        $fields['icon_back_padding'] = array('padding' => $back_icon);

        // fix border transition
        $fields = $this->df_fix_border_transition(
            $fields, 
            'button_b', 
            $back_button
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'front', 
            $front_container
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'back', 
            $back_container
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'image_f', 
            $front_image
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'image_b', 
            $back_image
        );

        // background 
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'fb_background',
            'selector'      => $front_container
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'fb_back_background',
            'selector'      => $back_container
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'fb_button_background',
            'selector'      => $back_button
        ));

        return $fields;
    }

    /**
     * Aditional Css for the module
     * 
     * @param $render_slug
     * @return Null
     */
    public function additional_css_styles($render_slug) {
        // flipbox height
        if($this->props['use_height'] === 'on') {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'fb_height',
                'type'              => 'height',
                'selector'          => '%%order_class%% .df_flipbox_container',
                'unit'              => 'px',
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'fb_height',
                'type'              => 'max-height',
                'selector'          => '%%order_class%% .df_flipbox_container .df_fb_image_container',
                'unit'              => 'px',
            ));
        }
        // process animation transition
        $this->df_process_transition(array(
            'render_slug'       => $render_slug,
            'slug'              => 'fb',
            'selector'          => '%%order_class%% .df_flipbox_body, %%order_class%% .df_fb_front, %%order_class%% .df_fb_back',
            'properties'        => ['opacity', 'transform']
        ));

        // icon styles
        $this->process_icon_styles(array (
            'render_slug'       => $render_slug,
            'slug'              => 'image_front',
            'selector'          => '%%order_class%% .df_fb_front .et-pb-icon',
            'hover'             => '%%order_class%% .df_fb_front .et-pb-icon:hover',
            'align_container'   => '%%order_class%% .df_fb_front .df_fb_image_container',
            'image_selector'    => '%%order_class%% .df_fb_front .df_fb_image_container img'
        ));
        $this->process_icon_styles(array (
            'render_slug'       => $render_slug,
            'slug'              => 'image_back',
            'selector'          => '%%order_class%% .df_fb_back .et-pb-icon',
            'hover'             => '%%order_class%% .df_fb_back .et-pb-icon:hover',
            'align_container'   => '%%order_class%% .df_fb_back .df_fb_image_container',
            'image_selector'    => '%%order_class%% .df_fb_back .df_fb_image_container img'
        ));
        // background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'fb_background',
            'selector'          => '%%order_class%% .df_fb_front .fb_inner',
            'hover'             => '%%order_class%% .df_fb_front .fb_inner:hover'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'fb_back_background',
            'selector'          => '%%order_class%% .df_fb_back .fb_inner',
            'hover'             => '%%order_class%% .df_fb_back .fb_inner:hover'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'fb_button_background',
            'selector'          => '%%order_class%% .df_fb_back .df_fb_button',
            'hover'             => '%%order_class%% .df_fb_back .df_fb_button:hover'
        ));
        // container spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'container_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .et_pb_module_inner',
            'hover'             => '%%order_class%% .et_pb_module_inner:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'container_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .et_pb_module_inner',
            'hover'             => '%%order_class%% .et_pb_module_inner:hover',
        ));
        // wrapper spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'front_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_fb_front .fb_inner',
            'hover'             => '%%order_class%% .df_fb_front .fb_inner:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'back_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_fb_back .fb_inner',
            'hover'             => '%%order_class%% .df_fb_back .fb_inner:hover',
        ));
        // image container spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_front_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_fb_front .df_fb_image_container .et-pb-icon',
            'hover'             => '%%order_class%% .df_fb_front .df_fb_image_container .et-pb-icon:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_front_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_fb_front .df_fb_image_container .et-pb-icon',
            'hover'             => '%%order_class%% .df_fb_front .df_fb_image_container .et-pb-icon:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_back_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_fb_back .df_fb_image_container .et-pb-icon',
            'hover'             => '%%order_class%% .df_fb_back .df_fb_image_container .et-pb-icon:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_back_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_fb_back .df_fb_image_container .et-pb-icon',
            'hover'             => '%%order_class%% .df_fb_back .df_fb_image_container .et-pb-icon:hover',
        ));
        // image container spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'img_container_front_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_fb_front .df_fb_image_container',
            'hover'             => '%%order_class%% .df_fb_front .df_fb_image_container:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'img_container_front_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_fb_front .df_fb_image_container',
            'hover'             => '%%order_class%% .df_fb_front .df_fb_image_container:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'img_container_back_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_fb_back .df_fb_image_container',
            'hover'             => '%%order_class%% .df_fb_back .df_fb_image_container:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'img_container_back_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_fb_back .df_fb_image_container',
            'hover'             => '%%order_class%% .df_fb_back .df_fb_image_container:hover',
        ));
        // title spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_front_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_fb_front .title',
            'hover'             => '%%order_class%% .df_fb_front .title:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_front_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_fb_front .title',
            'hover'             => '%%order_class%% .df_fb_front .title:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_back_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_fb_back .title',
            'hover'             => '%%order_class%% .df_fb_back .title:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_back_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_fb_back .title',
            'hover'             => '%%order_class%% .df_fb_back .title:hover',
        ));
        // text spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'text_front_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_fb_front .fb-text',
            'hover'             => '%%order_class%% .df_fb_front .fb-text:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'text_front_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_fb_front .fb-text',
            'hover'             => '%%order_class%% .df_fb_front .fb-text:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'text_back_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_fb_back .fb-text',
            'hover'             => '%%order_class%% .df_fb_back .fb-text:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'text_back_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_fb_back .fb-text',
            'hover'             => '%%order_class%% .df_fb_back .fb-text:hover',
        ));
        // button spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_fb_back .df_fb_button_wrapper',
            'hover'             => '%%order_class%% .df_fb_back .df_fb_button_wrapper:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_fb_back .df_fb_button_wrapper',
            'hover'             => '%%order_class%% .df_fb_back .df_fb_button_wrapper:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_fb_back .df_fb_button',
            'hover'             => '%%order_class%% .df_fb_back .df_fb_button:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_fb_back .df_fb_button',
            'hover'             => '%%order_class%% .df_fb_back .df_fb_button:hover',
        ));
        // button styles
        $this->df_process_btn_styles(array (
            'render_slug'       => $render_slug,
            'slug'              => 'fb_btn',
            'selector'          => '%%order_class%% .df_fb_back .df_fb_button',
            'hover'             => '%%order_class%% .df_fb_back .df_fb_button:hover',
            'align_container'   => '%%order_class%% .df_fb_back .df_fb_button_wrapper'
        ));

        // slide animation
        if($this->props['fb_animation'] === 'slide') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .et_pb_module_inner',
                'declaration' => 'overflow:hidden;'
            ));
        }
        // for rotate effect
        if($this->props['fb_animation'] === 'rotate' && $this->props['fb_content_float'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_flipbox_container.rotate.fb_floating_content .df_fb_front .fb_inner_content',
                'declaration' => sprintf('transform: translateZ(%1$s) scale(%2$s);', 
                    $this->props['fb_cf_translate'],
                    $this->props['fb_cf_scale']
                )
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_flipbox_container.rotate.fb_floating_content .df_fb_front .fb_inner',
                'declaration' => 'overflow: visible;'
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_flipbox_container.rotate.fb_floating_content .df_fb_back .fb_inner_content',
                'declaration' => sprintf('transform: translateZ(%1$s) scale(%2$s);', 
                    $this->props['fb_cf_translate'],
                    $this->props['fb_cf_scale']
                )
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_flipbox_container.rotate.fb_floating_content .df_fb_back .fb_inner',
                'declaration' => 'overflow: visible;'
            ));
        }
        // content alignment
        if ( isset($this->props['fb_front_align']) ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_fb_front .fb_inner',
                'declaration' => sprintf('align-items: %1$s;', 
                    $this->props['fb_front_align']
                )
            ));
        }
        if ( isset($this->props['fb_back_align']) ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_fb_back .fb_inner',
                'declaration' => sprintf('align-items: %1$s;', 
                    $this->props['fb_back_align']
                )
            ));
        }
        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'image_front_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.img_front',
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
                    'base_attr_name' => 'image_back_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.img_back',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }
    }

    /**
     * Render image for the front image
     * 
     * @param String $key
     * @return HTML | markup for the image
     */
    public function df_render_image($key = '', $ad_class='') {
        if ( isset($this->props[$key . '_use_icon']) && $this->props[$key . '_use_icon'] === 'on' ) {
            return sprintf('<div class="df_fb_image_container">
                    <span class="et-pb-icon %2$s">%1$s</span>
                </div>', 
                isset($this->props[$key . '_font_icon']) && $this->props[$key . '_font_icon'] !== '' ? 
                    esc_attr(et_pb_process_font_icon( $this->props[$key . '_font_icon'] )) : '5',
                $ad_class
            );
        } else if ( isset($this->props[$key . '_image']) && $this->props[$key . '_image'] !== ''){
          
            $image_alt = $this->props[$key . '_alt_text'] !== '' ? $this->props[$key . '_alt_text']  : df_image_alt_by_url($this->props[$key . '_image']);
            return sprintf('<div class="df_fb_image_container">
                    <img alt="%2$s" src="%1$s" />
                </div>',
                esc_attr($this->props[$key . '_image']),
                $image_alt
            );
        }
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
            return sprintf('<div class="df_fb_button_wrapper">
                <a class="df_fb_button" href="%1$s" %3$s>%2$s</a>
            </div>', 
            esc_attr($url), esc_html($text), $target);
        } else { return ''; }
    }

    /**
     * Animation Clases
     * 
     * @return String $animation_class
     */
    public function fb_animation_class () {
        $animation_class = '';
        // rotate animation
        if (isset($this->props['fb_animation']) && $this->props['fb_animation'] === 'rotate' && isset($this->props['fb_flip_direction'])) {
            $animation_class = ' ' . $this->props['fb_animation'] . ' ' . $this->props['fb_flip_direction'];
            if ($this->props['fb_content_float'] === 'on') {
                $animation_class .= ' fb_floating_content';
            }
        }
        // slide animation
        if (isset($this->props['fb_animation']) && $this->props['fb_animation'] === 'slide' && isset($this->props['fb_slide_direction'])) {
            $animation_class = ' ' . $this->props['fb_animation'] . ' ' . $this->props['fb_slide_direction'];
        }
        // zoom animation
        if (isset($this->props['fb_animation']) && $this->props['fb_animation'] === 'zoom' && isset($this->props['fb_zoom_direction'])) {
            $animation_class = ' ' . $this->props['fb_animation'] . ' ' . $this->props['fb_zoom_direction'];
        }
        // fade animation
        if (isset($this->props['fb_animation']) && $this->props['fb_animation'] === 'fade') {
            $animation_class = ' ' . $this->props['fb_animation'];
        }
        // 3d mode
        if ( isset($this->props['fb_animation']) && $this->props['fb_animation'] === 'box_cube' ) {
            $animation_class = ' ' . $this->props['fb_animation'];
        }

        return $animation_class;
    }

    public function process_shotcode($content) {
		ob_start();
		echo do_shortcode(html_entity_decode($content));
		$post = ob_get_clean();
		return $post;
	}

    /**
     * Rener the FB module
     * 
     * @return HTML | the module markup
     */
    public function render( $attrs, $content, $render_slug ) {
        $this->additional_css_styles($render_slug);

        $front_title = isset($this->props['title_front']) && $this->props['title_front'] !== '' ? 
            sprintf('<%2$s class="title">%1$s</%2$s>', 
                esc_html($this->props['title_front']),
                esc_attr($this->props['front_title_tag'])
            ) : '';
        $front_content = isset($this->props['content_front']) && $this->props['content_front'] !== '' ? 
            sprintf('<div class="fb-text">%1$s</div>', $this->process_shotcode($this->props['content_front'])) : '';
        $back_title = isset($this->props['title_back']) && $this->props['title_back'] !== '' ? 
            sprintf('<%2$s class="title">%1$s</%2$s>', 
                esc_html($this->props['title_back']),
                esc_attr($this->props['back_title_tag'])
            ) : '';
        $back_content = isset($this->props['content_back']) && $this->props['content_back'] !== '' ? 
            sprintf('<div class="fb-text">%1$s</div>', $this->process_shotcode($this->props['content_back'])) : '';


        $front_content_markup = $front_title !== '' || !empty($front_content) ?
            sprintf('%1$s%2$s', $front_title,
            $front_content) : '';

        $back_content_markup = $back_title !== '' || !empty($back_content) ?
            sprintf('%1$s%2$s', $back_title,
            $back_content) : '';
        

        return sprintf('<div class="df_flipbox_container%6$s">
                <div class="df_flipbox_body">
                    <div class="df_fb_front">
                        <div class="fb_inner">
                            <div class="fb_inner_content">%2$s%1$s</div>
                        </div>
                    </div>
                    <div class="df_fb_back">
                        <div class="fb_inner">
                            <div class="fb_inner_content">%4$s%3$s%5$s</div>
                        </div>
                    </div>
                </div>
            </div>',
            $front_content_markup,
            $this->df_render_image('image_front', 'img_front'),
            $back_content_markup,
            $this->df_render_image('image_back', 'img_back'),
            $this->df_render_button('fb_btn'),
            $this->fb_animation_class()
        );
    }
}
new DIFL_FlipBox;