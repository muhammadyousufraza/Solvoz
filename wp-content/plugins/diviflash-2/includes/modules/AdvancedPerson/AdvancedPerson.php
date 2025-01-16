<?php
class DIFL_AdvancedPerson extends ET_Builder_Module
{
    public $slug       = 'difl_advanced_person';
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
        $this->name = esc_html__('Advanced Person', 'divi_flash');
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/advanced-person.svg';
    }
    public function get_settings_modal_toggles()
    {
        return array(
            'general'  => array(
                'toggles' => array(
                    'main_content'      => esc_html__('Content', 'divi_flash'),
                    'image'             => esc_html__('Image', 'divi_flash'),
                    'social'            => esc_html__('Social Icon', 'divi_flash'),
                    'layout'            => esc_html__('Layout Style', 'divi_flash'),
                    'animation_setting' => esc_html__('Animation Settings', 'divi_flash'),
                ),
            ),
            'advanced'  =>  array(
                'toggles'   =>  array(
                    'design_image'          => esc_html__('Image', 'divi_flash'),
                    'design_image_wrapper'  => esc_html__('Image Wrapper', 'divi_flash'),
                    'design_overlay'        => esc_html__('Overlay', 'divi_flash'),
                    'design_ekip_overlay'   => esc_html__('Overlay', 'divi_flash'),
                    'design_content'           => esc_html__('Content', 'divi_flash'),
                    'design_name'           => esc_html__('Name', 'divi_flash'),
                    'design_role'           => esc_html__('Role', 'divi_flash'),
                    'design_description'    => esc_html__('Description', 'divi_flash'),
                    'design_desc_wrapper'   => esc_html__('Description Wrapper', 'divi_flash'),
                    'design_social_wrapper' => esc_html__('Social Wrapper', 'divi_flash'),
                    'design_social_setting' => esc_html__('Social Settings', 'divi_flash'),
                    'design_social'         => esc_html__('Social Color', 'divi_flash'),
                    'design_zindex'         => esc_html__('Z index', 'divi_flash'),
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
                        ),
                    )

                )
            ),

            // Advance tab's slug is "custom_css"
            'custom_css' => array(
                'toggles' => array(
                    'limitation' => esc_html__('Limitation', 'divi_flash'), // totally made up
                ),
            ),
        );
    }
    public function get_advanced_fields_config()
    {
        $advanced_fields = array();
    
        $advanced_fields['text'] = true;
        $advanced_fields['fonts'] = array(
            'name'   => array(
                'label'         => esc_html__('', 'divi_flash'),
                'toggle_slug'   => 'design_name',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '24px',
                ),
                'font-weight' => array(
                    'default' => 'bold'
                ),
                'css'      => array(
                    'main' => " %%order_class%% .df_person_name",
                    'hover' => "%%order_class%% .df_ap_person_container:hover .df_person_name",
                    'important' => 'all',
                ),
            ),
            'role'   => array(
                'label'         => esc_html__('', 'divi_flash'),
                'toggle_slug'   => 'design_role',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'font-weight' => array(
                    'default' => 'semi-bold'
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_person_role ",
                    'hover' => "%%order_class%% .df_ap_person_container:hover .df_person_role",
                    'important' => 'all',
                ),
            ),

            'description'   => array(
                'label'         => esc_html__('', 'divi_flash'),
                'toggle_slug'   => 'design_description',
                'hide_text_shadow'  => true,
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_person_description",
                    'hover' => "%%order_class%% .df_ap_person_container:hover .df_person_description",
                    'important' => 'all',
                ),
            ),

            'content'   => array(
                'label'         => esc_html__('', 'divi_flash'),
                'toggle_slug'   => 'design_content',
                'hide_text_shadow'  => true,
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ap_person_desc_wrapper",
                    'hover' => "%%order_class%% .df_ap_person_container:hover .df_ap_person_desc_wrapper",
                    'important' => 'all',
                ),
            )
        );
        $advanced_fields['borders'] = array(
            'default'               => array(),
            'name_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_person_name",
                        'border_radii_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_name",
                        'border_styles' => "{$this->main_css_element} .df_person_name",
                        'border_styles_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_name",
                    )
                ),
                'label'    => esc_html__('Name', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_name',
            ),
            'role_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_person_role",
                        'border_radii_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_role",
                        'border_styles' => "{$this->main_css_element} .df_person_role",
                        'border_styles_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_role",
                    )
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_role',
            ),
            'description_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_person_description",
                        'border_radii_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_description",
                        'border_styles' => "{$this->main_css_element} .df_person_description",
                        'border_styles_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_description",
                    )
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'   => 'design_description',
            ),

            'content_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_ap_person_desc_wrapper",
                        'border_radii_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_ap_person_desc_wrapper",
                        'border_styles' => "{$this->main_css_element} .df_ap_person_desc_wrapper",
                        'border_styles_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_ap_person_desc_wrapper",
                    )
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'   => 'design_content',
            ),
            'photo_wrapper_border'         => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_person_photo_wrapper",
                        'border_radii_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_photo_wrapper",
                        'border_styles' => "{$this->main_css_element} .df_person_photo_wrapper",
                        'border_styles_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_photo_wrapper",
                    ),
                    'important' => true,                   
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_image_wrapper',
            ),  

            'photo_border'         => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_person_photo img.person_photo",
                        'border_radii_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_photo img.person_photo",
                        'border_styles' => "{$this->main_css_element} .df_person_photo img.person_photo",
                        'border_styles_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_photo img.person_photo",
                    ),
                    'important' => true,    
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_image',
            ),

            'social_container_border'         => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_person_socail_wrapper",
                        'border_radii_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_socail_wrapper",
                        'border_styles' => "{$this->main_css_element} .df_person_socail_wrapper",
                        'border_styles_hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_socail_wrapper",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_social_wrapper',
            ),

            'social_icon_border'         => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .df_person_social_icon",
                        'border_radii_hover' => "{$this->main_css_element} .df_person_social_icon:hover",
                        'border_styles' => "{$this->main_css_element} .df_person_social_icon",
                        'border_styles_hover' => "{$this->main_css_element} .df_person_social_icon:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_social_setting',
            )
        );
        
        $advanced_fields['box_shadow'] = array(
            'default'               => true,
            'content_shadow'             => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css' => array(
                    'main' => "{$this->main_css_element} .df_ap_person_desc_wrapper",
                    'hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_ap_person_desc_wrapper",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_content',
            ),
            'image_shadow'             => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css' => array(
                    'main' => "{$this->main_css_element} .df_person_photo img.person_photo",
                    'hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_photo img.person_photo",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_image',
            ),

            'image_wrapper_shadow'             => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css' => array(
                    'main' => "{$this->main_css_element} .df_person_photo_wrapper",
                    'hover' => "{$this->main_css_element} .df_ap_person_container:hover .df_person_photo_wrapper",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_image_wrapper',
            ),

            'social_icon_shadow'             => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css' => array(
                    'main' => "{$this->main_css_element} .df_person_social_icon",
                    'hover' => "{$this->main_css_element} .df_person_social_icon:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_social_setting',
            ),

        );
     
        $advanced_fields['filters'] = array(
            'child_filters_target' => array(
                'label'    => esc_html__('Image filter', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_image',
                'css' => array(
                    'main' => '%%order_class%% .df_person_photo',
                    'hover' => '%%order_class%% .df_ap_person_container:hover .df_person_photo'
                ),
            ),
        );
        $advanced_fields['image'] = array(
			'css' => array(
				'main' => array(
					'%%order_class%% .df_person_photo',
				)
			),
		);
        
        return $advanced_fields;
    }

    public function get_fields()
    {
        $general = array(
            'style_type'=> array (
                'default'         => 'default_style',
                'label'           => esc_html__( 'Style Type', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'default_style'    => esc_html__( 'Style 1', 'divi_flash' ),
                    'ekip_style'    => esc_html__( 'Style 2', 'divi_flash' ),
                    'ekip_style_2'    => esc_html__( 'Style 3', 'divi_flash' ),
                ),
                'toggle_slug'   => 'layout',
            ),
            
        );

        $content_on_overlay = array(
            'enable_icon_on_overlay'  => array(
                'label'             => esc_html__('Enable Icon Over Image', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'layout',
                'show_if'         => array(
                    'style_type' => 'default_style',
                    'enable_alternative_photo' => 'off',
                )
            ),
            'anm_content_padding'    => array (
                'label'             => esc_html__( 'Content Space', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'   => 'layout',
                'default'           => '1em',
                'default_unit'      => '',
                'allowed_units'     => array ('em'),
                'range_settings'    => array(
                    'min'  => '.5',
                    'max'  => '3',
                    'step' => '.1',
                ),
                'mobile_options'    => true,
                'show_if'         => array(
                    'style_type' => 'default_style',
                    'enable_alternative_photo' => 'off',
                    'enable_icon_on_overlay'=> 'on'
                )
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
                'toggle_slug'   => 'layout',
                'show_if'         => array(
                    'style_type' => 'default_style',
                    'enable_alternative_photo' => 'off',
                    'enable_icon_on_overlay'=> 'on'
                )
            ), 
               
            'always_show_icon'  => array(
                'label'         => esc_html__('Always Show Icon', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'layout',
                'show_if' => array(
                    'style_type' => 'default_style',
                    'enable_alternative_photo' => 'off',
                    'enable_icon_on_overlay' => 'on',
                ),  
            ),
            'icon_reveal_caption'    => array(
                'label'    => esc_html__('Icon Reveal', 'divi_flash'),
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
                'toggle_slug'   => 'layout',
                'show_if_not'   => array(
                    'always_show_icon' => 'on'
                ),
                'show_if' => array(
                    'style_type' => 'default_style',
                    'enable_alternative_photo' => 'off',
                    'enable_icon_on_overlay' => 'on',
                ),
            ),
        );

        $content = array(
            'ap_name' => array(
                'label'           => esc_html__('Name', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Name entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text'
            ),
            'ap_role' => array(
                'label'           => esc_html__('Role', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Role entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text'
            ),
            'ap_description' => array(
                'label'           => esc_html__('Description', 'divi_flash'),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Description entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text'
            ),
            'ap_name_tag' => array (
                'default'         => 'h4',
                'label'           => esc_html__( 'Name Tag', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'h1'    => esc_html__( 'h1 tag', 'divi_flash' ),
                    'h2'    => esc_html__( 'h2 tag', 'divi_flash' ),
                    'h3'    => esc_html__( 'h3 tag', 'divi_flash' ),
                    'h4'    => esc_html__( 'h4 tag', 'divi_flash' ),
                    'h5'    => esc_html__( 'h5 tag', 'divi_flash' ),
                    'h6'    => esc_html__( 'h6 tag', 'divi_flash'),
                    'p'     => esc_html__( 'p tag', 'divi_flash'),
                    'span'  => esc_html__( 'span tag', 'divi_flash'),
                    'div'  => esc_html__( 'div tag', 'divi_flash')
                ),
                'toggle_slug'   => 'main_content',
            ),
            'ap_role_tag' => array (
                'default'         => 'h5',
                'label'           => esc_html__( 'Role Tag', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'h1'    => esc_html__( 'h1 tag', 'divi_flash' ),
                    'h2'    => esc_html__( 'h2 tag', 'divi_flash' ),
                    'h3'    => esc_html__( 'h3 tag', 'divi_flash' ),
                    'h4'    => esc_html__( 'h4 tag', 'divi_flash' ),
                    'h5'    => esc_html__( 'h5 tag', 'divi_flash' ),
                    'h6'    => esc_html__( 'h6 tag', 'divi_flash'),
                    'p'     => esc_html__( 'p tag', 'divi_flash'),
                    'span'  => esc_html__( 'span tag', 'divi_flash'),
                    'div'  => esc_html__( 'div tag', 'divi_flash')
                ),
                'toggle_slug'   => 'main_content',
            )   
        );
        $name_background = $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'name_background',
            'toggle_slug'           => 'design_name',
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'show_if_not'               => array(
                'ap_name' => array('')
            )
        ));
        $role_background = $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'role_background',
            'toggle_slug'           => 'design_role',
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'show_if_not'               => array(
                'ap_role' => array('')
            )
        ));
        $description_background = $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'description_background',
            'toggle_slug'           => 'design_description',
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'show_if_not'               => array(
                'ap_description' => array('')
            )
        ));

        $content_background = $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'content_background',
            'toggle_slug'           => 'design_content',
            'tab_slug'              => 'advanced',
            'default'               => 'rgba(0, 255, 255, 0.479)',
            'image'                 => true
        ));
        $content_settings= array(
            'content_zindex' => array(
                'label'             => esc_html__('Z-index', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_content',
                'tab_slug'          => 'advanced',
                'default'           => '0',
                'range_settings'    => array(
                    'min'  => '-100',
                    'max'  => '1000',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'mobile_options'    => true,
            ),
        );

        $image = array(
            'ap_photo' => array(
                'label'                 => esc_html__('Image', 'divi_flash'),
                'type'                  => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text'    => esc_attr__('Upload an Image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'image',
                'label'              => et_builder_i18n( 'Image' ),
				'hide_metadata'      => true,
				'affects'            => array(
					'alt',
					'title_text',
				),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'et_builder' ),
	            'dynamic_content'    => 'image',
            ),
            'photo_alt_text' => array(
                'label'                 => esc_html__('Image Alt Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'image',     
            ),
            'enable_alternative_photo'  => array(
                'label'             => esc_html__('Enable Alternative Image', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'layout',
                'show_if'         => array(
                    'style_type' => 'default_style',
                    'border_anim' => 'off',
                    'enable_icon_on_overlay' => 'off'
                )
            ),

            'ap_alternative_photo' => array(
                'label'                 => esc_html__('Alternative Image', 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'dynamic_content'       => 'image',
                'upload_button_text'    => esc_attr__('Upload an Alternative Image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Alternative Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Alternative Image', 'divi_flash'),
                'toggle_slug'           => 'layout',
                'show_if'               => array(
                    'enable_alternative_photo' => 'on',
                    'style_type' => 'default_style',
                    'border_anim' => 'off',
                    'enable_icon_on_overlay' => 'off'
                )
            ),
            'alternative_photo_alt_text' => array(
                'label'                 => esc_html__('Alternative Image Alt Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'layout',
                'show_if'               => array(
                    'enable_alternative_photo' => 'on',
                    'style_type' => 'default_style',
                    'border_anim' => 'off',
                    'enable_icon_on_overlay' => 'off'
                )
            ),

        );
        $image_design = array(
  
            'image_wrapper_max_width' => array(
                'label'             => esc_html__( 'Max Width', 'divi_flash' ),
                'type'              => 'range',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'design_image_wrapper',
                'default'           => '100%',
                'default_unit'      => '%',
                'default_on_front'  => '100%',
                'responsive'        => true,
                'mobile_options'    => true,
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '100',
                    'step' => '1',
                )
            ),
            'image_wrapper_zindex' => array(
                'label'             => esc_html__('Z-index', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_image_wrapper',
                'tab_slug'          => 'advanced',
                'default'           => '0',
                'range_settings'    => array(
                    'min'  => '-100',
                    'max'  => '1000',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'mobile_options'    => true,
            ),
            'image_alignment'     => array(
                'label'             => esc_html__('Image Alignment', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'auto 0'            => esc_html__('Left', 'divi_flash'),
                    '0 auto'          => esc_html__('Center', 'divi_flash'),
                    '0 0 0 auto'         => esc_html__('Right', 'divi_flash'),
                ),
                'default'       => '0 auto',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'design_image_wrapper',
                'mobile_options'    => true,
            ),
            'image_force_to_fullwidth'    => array(
                'label'    => esc_html__('Force Fullwidth', 'divi_flash'),
                'description' => esc_html__('When enabled, this will force your image to extend 100% of the width of the column it\'s in.', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'design_image',
                'tab_slug'      => 'advanced',
                'show_if'       => array(
                    'enable_alternative_photo' => 'off'
                )
            ),
            'image_scale_type'    => array(
                'label'    => esc_html__('Scale Type', 'divi_flash'),
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
                'toggle_slug'   => 'design_image',
                'tab_slug'      => 'advanced',
                'show_if_not'   => array(
                    'style_type' => 'ekip_style'
                )
            ),
            'image_scale_value' => array (
                'label'         => esc_html__( 'Scale Value', 'divi_flash' ),
                'type'          => 'range',
                'toggle_slug'   => 'design_image',
                'tab_slug'      => 'advanced',
                'default'       => '1.3',
                'allowed_units' => array (),
                'range_settings'=> array(
                    'min'  => '1.0',
                    'max'  => '3',
                    'step' => '.1',
                ),
                'validate_unit'=> false,
                'show_if_not'  => array(
                    'style_type' => 'ekip_style'
                ),
                'show_if'      => array (
                    'image_scale_type' => array( 'c4-image-rotate-left', 'c4-image-rotate-right')
                )
            ),

        );
        $image_overlay = array(
            'overlay'    => array(
                'label'         => esc_html__('Overlay', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'design_overlay',
                'tab_slug'      => 'advanced',
                'show_if'       => array(
                    'style_type'  => 'default_style',
                    'enable_alternative_photo' => 'off'
                )
            ),
        
        );
        $image_wrapper_background = $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'image_wrapper_background',
            'toggle_slug'           => 'design_image_wrapper',
            'tab_slug'              => 'advanced',
            'image'                 => false
        ));  
        $default_style_overlay = $this->df_add_bg_field(array(
            'label'       => 'Default Overlay',
            'key'         => 'default_overlay_background',
            'toggle_slug' => 'design_overlay',
            'tab_slug'    => 'advanced',
            'image'       => true,
            'hover'       => false,
            'show_if'     => array(
                'overlay'  => 'on',
                'style_type'  => 'default_style',
                'enable_alternative_photo' => 'off'
            )
        )); 
        $ekip_style_overlay = $this->df_add_bg_field(array(
            'label'           => 'Overlay',
            'key'             => 'ekip_overlay_background',
            'toggle_slug'     => 'design_ekip_overlay',
            'tab_slug'        => 'advanced',
            'show_if_not'     => array(
                'style_type'  => array('default_style','ekip_style_2' )
            )
        )); 
        $border_animation = array(
            'border_anim'    => array(
                'label'         => esc_html__('Border Animation', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'layout',
                'show_if'       => array(
                    'style_type' => array('default_style'),
                    'enable_alternative_photo' => 'off'
                )
            ),
            'anm_border_color'  => array(
                'label'             => esc_html__( 'Border Color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'layout',
                'default'           => '#ffffff',
                'show_if'           => array(
                    'style_type'  => array('default_style'),
                    'border_anim' => 'on',
                    'enable_alternative_photo' => 'off'
                )
            ),
            'anm_border_width'    => array (
                'label'             => esc_html__( 'Border Width', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'layout',
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
                    'style_type'               => array('default_style'),
                    'border_anim'              => 'on',
                    'enable_alternative_photo' => 'off'
                )
            ),
            'anm_border_margin'    => array (
                'label'             => esc_html__( 'Border Space', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'layout',
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
                    'style_type'  => array('default_style'),
                    'border_anim'  => 'on',
                    'enable_alternative_photo' => 'off'
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
                'toggle_slug'   => 'layout',
                'show_if'       => array(
                    'style_type'  => array('default_style'),
                    'border_anim'  => 'on',
                    'enable_alternative_photo' => 'off'
                )
            ),
        ); 
        $overlay_animation = array(
            'anim_direction' => array (
                'default'         => 'bottom',
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
                'toggle_slug'     => 'animation_setting',
                'show_if'         => array(
                    'style_type' => array('ekip_style','ekip_style_2')
                )
            )
        );  
        $transition = $this->df_transition_options(array (
            'key'               => 'overlay_transition',
            'toggle_slug'       => 'animation_setting',
            'duration_default'  => '300ms',
            'show_if_not'  => array(
                'style_type' => array('default_style')
            )
        ));              
        $socail = array(
            'ap_facebook' => array(
                'label'           => esc_html__('Facebook', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'social',
                'dynamic_content' => 'url'
            ),
            'ap_twitter' => array(
                'label'           => esc_html__('Twitter', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'social',
                'dynamic_content' => 'url'
            ),
            'ap_linkedin' => array(
                'label'           => esc_html__('Linkedin', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'social',
                'dynamic_content' => 'url'
            ),
            'ap_instagram' => array(
                'label'           => esc_html__('Instagram', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'social',
                'dynamic_content' => 'url'
            ),
            'ap_pinterest' => array(
                'label'           => esc_html__('Pinterest', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'social',
                'dynamic_content' => 'url'
            ),
            'ap_email' => array(
                'label'           => esc_html__('Email', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'social',
                'dynamic_content' => 'url'
            ),
            'ap_phone' => array(
                'label'           => esc_html__('Phone', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'social',
                'dynamic_content' => 'url'
            )
        );

        $wrapper_spacing = array(
            'module_wrapper_margin' => array(
                'label'               => esc_html__('Wrapper Margin', 'divi_flash'),
                'toggle_slug'    => 'custom_spacing',
                'tab_slug'       => 'advanced',
                'sub_toggle'     => 'wrapper',
                'type'           => 'custom_margin',
                'hover'          => 'tabs',
                'mobile_options' => true,
            ),
            'module_wrapper_padding' => array(
                'label'          => esc_html__('Wrapper Padding', 'divi_flash'),
                'toggle_slug'    => 'custom_spacing',
                'tab_slug'       => 'advanced',
                'sub_toggle'     => 'wrapper',
                'type'           => 'custom_margin',
                'hover'          => 'tabs',
            'mobile_options'     => true,
            ),
    
            'image_wrapper_margin' => array(
                'label'          => esc_html__('Image Wrapper Margin', 'divi_flash'),
                'toggle_slug'    => 'custom_spacing',
                'tab_slug'       => 'advanced',
                'sub_toggle'     => 'wrapper',
                'type'           => 'custom_margin',
                'hover'          => 'tabs',
                'mobile_options' => true,
            ),

            'image_wrapper_padding' => array(
                'label'           => esc_html__('Image Wrapper Padding', 'divi_flash'),
                'type'            => 'custom_margin',
                'toggle_slug'     => 'custom_spacing',
                'tab_slug'        => 'advanced',
                'sub_toggle'      => 'wrapper',
                'hover'            => 'tabs',
                'mobile_options'   => true,
            ),
            'content_margin' => array(
                'label'              => esc_html__('Content Wrapper Margin', 'divi_flash'),
                'toggle_slug'        => 'custom_spacing',
                'tab_slug'           => 'advanced',
                'sub_toggle'         => 'wrapper',
                'type'               => 'custom_margin',
                'hover'              => 'tabs',
                'mobile_options'     => true,
            ),

            'content_padding' => array(
                'label'       => esc_html__('Content Wrapper Padding', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'wrapper',
                'type'        => 'custom_margin',
                'hover'       => 'tabs',
                'mobile_options' => true,
            ),

            'details_wrapper_margin' => array(
                'label'              => esc_html__('Text Wrapper Margin', 'divi_flash'),
                'toggle_slug'        => 'custom_spacing',
                'tab_slug'           => 'advanced',
                'sub_toggle'         => 'wrapper',
                'type'               => 'custom_margin',
                'hover'              => 'tabs',
                'mobile_options'     => true,
            ),

            'details_wrapper_padding' => array(
                'label'       => esc_html__('Text Wrapper Padding', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'wrapper',
                'type'        => 'custom_margin',
                'hover'       => 'tabs',
                'mobile_options' => true,
            ),

            'social_wrapper_margin' => array(
                'label'       => esc_html__('Social Wrapper Margin', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'wrapper',
                'type'        => 'custom_margin',
                'hover'       => 'tabs',
                'mobile_options'=> true,
            ),
            'social_wrapper_padding' => array(
                'label'       => esc_html__('Social Wrapper Padding', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'wrapper',
                'type'        => 'custom_margin',
                'hover'       => 'tabs',
                'mobile_options'    => true,
            ),

        );
     
        $content_spacing = array(         
            'name_margin' => array(
                'label'       => esc_html__('Name Margin', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'        => 'custom_margin',
                'hover'       => 'tabs',
                'mobile_options'    => true,
            ),
            'name_padding' => array(
                'label'       => esc_html__('Name Padding', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'        => 'custom_margin',
                'hover'       => 'tabs',
                'mobile_options'=> true,
            ),
            'role_margin' => array(
                'label'       => esc_html__('Role Margin', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'        => 'custom_margin',
                'hover'       => 'tabs',
                'mobile_options'    => true,
            ),
            'role_padding' => array(
                'label'       => esc_html__('Role Padding', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'        => 'custom_margin',
                'hover'       => 'tabs',
                'mobile_options'=> true,
            ),
            'description_margin' => array(
                'label'       => esc_html__('Description Margin', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'        => 'custom_margin',
                'hover'       => 'tabs',
                'mobile_options'    => true,
            ),
            'description_padding' => array(
                'label'       => esc_html__('Description Padding', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'        => 'custom_margin',
                'hover'       => 'tabs',
                'mobile_options'    => true,
            ),
            'image_margin' => array(
                'label'       => esc_html__('Image Margin', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'        => 'custom_margin',
                'hover'        => 'tabs',
                'mobile_options'    => true,
            ),
            'image_padding' => array(
                'label'               => esc_html__('Image Padding', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'        => 'custom_margin',
                'hover'       => 'tabs',
                'mobile_options'=> true,
            ),
            'social_margin' => array(
                'label'               => esc_html__('Social Margin', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'        => 'custom_margin',
                'hover'       => 'tabs',
                'mobile_options'=> true,
            ),
            'social_padding' => array(
                'label'           => esc_html__('Social Padding', 'divi_flash'),
                'toggle_slug'     => 'custom_spacing',
                'tab_slug'        => 'advanced',
                'sub_toggle'      => 'content',
                'type'            => 'custom_margin',
                'hover'           => 'tabs',
                'mobile_options'  => true,
            ),
            'first_social_margin' => array(
                'label'         => esc_html__('First Social Margin', 'divi_flash'),
                'toggle_slug'   => 'custom_spacing',
                'tab_slug'      => 'advanced',
                'sub_toggle'    => 'content',
                'type'          => 'custom_margin',
                'hover'         => 'tabs',
                'mobile_options'=> true,
            ),
            'last_social_margin' => array(
                'label'       => esc_html__('Last Social Margin', 'divi_flash'),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'        => 'custom_margin',
                'hover'       => 'tabs',
                'mobile_options' => true,
            ),         
        );
       
        $icon_design = array(
            'social_section_align' => array(
                'label'             => esc_html__( 'Icon Alignment', 'divi_flash' ),
				'type'              => 'text_align',
				'options'           => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'       => 'design_social_setting',
                'tab_slug'          => 'advanced',
                'mobile_options'    => true,
            ),
            'make_vertical_icon'  => array(
                'label'             => esc_html__('Vertical Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'design_social_setting',
                'tab_slug'          => 'advanced',
                'show_if'           => array(
                    'style_type' => array('default_style')
                )
            ),
            'make_full_with_icon'  => array(
                'label'             => esc_html__('Full Width Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'design_social_setting',
                'tab_slug'       => 'advanced',
            ),
            'icon_size' => array(
                'label'             => esc_html__('Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_social_setting',
                'tab_slug'          => 'advanced',
                'default'           => '16px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options'    => true,
            ),
            'icon_color' => array(
                'label'           => esc_html__('Icon Color', 'divi_flash'),
                'type'            => 'color-alpha',
                'toggle_slug'     => 'design_social_setting',
                'tab_slug'        => 'advanced',
                'hover'           => 'tabs'
            ),
        );
        $social_wrapper_background = $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'social_wrapper_background',
            'toggle_slug'           => 'design_social_wrapper',
            'tab_slug'              => 'advanced',
            'image'                 => false
        ));  

        $icon_background = $this->df_add_bg_field(array(
            'label'                 => 'Icon Background',
            'key'                   => 'icon_background',
            'toggle_slug'           => 'design_social_setting',
            'tab_slug'              => 'advanced',
            'image'                 => false
        ));  

        $facebook_icon_color = array( 
            'facebook_icon_color' => array(
                'label'           => esc_html__('Facebook Icon Color', 'divi_flash'),
                'type'            => 'color-alpha',
                'toggle_slug'     => 'design_social',
                'tab_slug'        => 'advanced',
                'hover'           => 'tabs',
                'show_if_not'     => array(
                    'ap_facebook' => array('')
                )
            )
        );        
        $twitter_icon_color = array(
            'twitter_icon_color' => array(
                'label'           => esc_html__('Twitter Icon Color', 'divi_flash'),
                'type'            => 'color-alpha',
                'toggle_slug'     => 'design_social',
                'tab_slug'        => 'advanced',
                'hover'           => 'tabs',
                'show_if_not'           => array(
                    'ap_twitter' => array('')
                )
            )
        );    
        $linkedin_icon_color = array(
            'linkedin_icon_color' => array(
                'label'           => esc_html__('linkedin Icon Color', 'divi_flash'),
                'type'            => 'color-alpha',
                'toggle_slug'     => 'design_social',
                'tab_slug'        => 'advanced',
                'hover'           => 'tabs',
                'show_if_not'     => array(
                    'ap_linkedin' => array('')
                )
            )
        );
        $instagram_icon_color = array(
            'instagram_icon_color' => array(
                'label'           => esc_html__('Instagram Icon Color', 'divi_flash'),
                'type'            => 'color-alpha',
                'toggle_slug'     => 'design_social',
                'tab_slug'        => 'advanced',
                'hover'           => 'tabs',
                'show_if_not'     => array(
                    'ap_instagram' => array('')
                )
            )    
        );

        $pinterest_icon_color = array(
            'pinterest_icon_color' => array(
            'label'           => esc_html__('Pinterest Icon Color', 'divi_flash'),
            'type'            => 'color-alpha',
            'toggle_slug'     => 'design_social',
            'tab_slug'        => 'advanced',
            'hover'           => 'tabs',
            'show_if_not'     => array(
                    'ap_pinterest' => array('')
                )
            )
        );
        $email_icon_color = array(
            'email_icon_color' => array(
                'label'         => esc_html__('Email Icon Color', 'divi_flash'),
                'type'          => 'color-alpha',
                'toggle_slug'   => 'design_social',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs',
                'show_if_not'   => array(
                    'ap_email' => array('')
                )
            )
        );
        $phone_icon_color = array(
            'phone_icon_color' => array(
                'label'           => esc_html__('phone Icon Color', 'divi_flash'),
                'type'            => 'color-alpha',
                'toggle_slug'     => 'design_social',
                'tab_slug'        => 'advanced',
                'hover'           => 'tabs',
                'show_if_not'           => array(
                    'ap_phone' => array('')
                )
            )
        );
        

        $facebook_background = $this->df_add_bg_field(array(
            'label'                 => 'Facebook Background',
            'key'                   => 'facebook_background',
            'toggle_slug'           => 'design_social',
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'show_if_not'           => array(
                'ap_facebook' => array('')
            )
        ));                    
        $twitter_background = $this->df_add_bg_field(array(
            'label'                 => 'Twitter Background',
            'key'                   => 'twitter_background',
            'toggle_slug'           => 'design_social',
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'show_if_not'           => array(
                'ap_twitter' => array('')
            )
        ));
        $linkedin_background = $this->df_add_bg_field(array(
            'label'                 => 'Linkedin Background',
            'key'                   => 'linkedin_background',
            'toggle_slug'           => 'design_social',
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'show_if_not'           => array(
                'ap_linkedin' => array('')
            )
        ));

        $instagram_background = $this->df_add_bg_field(array(
            'label'                 => 'Instagram Background',
            'key'                   => 'instagram_background',
            'toggle_slug'           => 'design_social',
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'show_if_not'           => array(
                'ap_instagram' => array('')
            )
        ));
        $pinterest_background = $this->df_add_bg_field(array(
            'label'                 => 'Pinterest Background',
            'key'                   => 'pinterest_background',
            'toggle_slug'           => 'design_social',
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'show_if_not'           => array(
                'ap_pinterest' => array('')
            )
        ));
        $email_background = $this->df_add_bg_field(array(
            'label'                 => 'Email Background',
            'key'                   => 'email_background',
            'toggle_slug'           => 'design_social',
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'show_if_not'           => array(
                'ap_email' => array('')
            )
        ));

        $phone_background = $this->df_add_bg_field(array(
            'label'                 => 'Phone Background',
            'key'                   => 'phone_background',
            'toggle_slug'           => 'design_social',
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'show_if_not'           => array(
                'ap_phone' => array('')
            )
        ));

        return array_merge(
            $general,
            $image,
            $content_on_overlay,
            $image_wrapper_background,
            $image_design,
            $image_overlay,
            $ekip_style_overlay,
            $default_style_overlay,
            $overlay_animation,
            $transition,
            $border_animation,
            $content,
            $name_background,
            $role_background,
            $description_background,
            $content_background,
            $content_settings,
            //$person_desc_wrapper_background,
            $socail,
            $icon_design,
            $icon_background,
            $social_wrapper_background,
            $facebook_icon_color,
            $facebook_background,
            $twitter_icon_color,
            $twitter_background,
            $linkedin_icon_color,
            $linkedin_background,
            $instagram_icon_color,
            $instagram_background,
            $pinterest_icon_color,
            $pinterest_background,
            $email_icon_color,
            $email_background,
            $phone_icon_color,
            $phone_background,
            $wrapper_spacing,
            $content_spacing
        );
    } 

    public function get_transition_fields_css_props()
    {
        $fields = parent::get_transition_fields_css_props();
        $module_wrapper = '%%order_class%% .df_ap_person_wrapper';
        $name            = '%%order_class%% .df_person_name';
        $role            = '%%order_class%% .df_person_role';
        $description     = '%%order_class%% .df_person_description';
        $content     = '%%order_class%% .df_ap_person_desc_wrapper';
        $image           = '%%order_class%% img.person_photo'; 
        $image_wrapper   = '%%order_class%% .df_person_photo_wrapper';
        $icon            =  '%%order_class%% .df_person_social_icon .et-pb-icon';
        $facebook_social_icon=  '%%order_class%% .df_person_social_icon.facebook .et-pb-icon';
        $twitter_social_icon=  '%%order_class%% .df_person_social_icon.twitter .et-pb-icon';
        $linkedin_social_icon=  '%%order_class%% .df_person_social_icon.linkedin .et-pb-icon';
        $instagram_social_icon=  '%%order_class%% .df_person_social_icon.instagram .et-pb-icon';
        $pinterest_social_icon=  '%%order_class%% .df_person_social_icon.pinterest .et-pb-icon';
        $email_social_icon=  '%%order_class%% .df_person_social_icon.email .et-pb-icon';
        $phone_social_icon=  '%%order_class%% .df_person_social_icon.phone .et-pb-icon';
           
        $social_icon     = "%%order_class%% .df_person_social_icon";
        $social_icon_container     = "%%order_class%% .df_person_socail_wrapper";
        $fields['image_scale_value'] = array('transform' => $image);
        $fields['name_margin'] = array('margin' => $name);
        $fields['name_padding'] = array('padding' => $name);

        $fields['role_margin'] = array('margin' => $role);
        $fields['role_padding'] = array('padding' => $role);
        $fields['description_margin'] = array('margin' => $description);
        $fields['description_padding'] = array('padding' => $description);
        $fields['image_margin'] = array('margin' => '%%order_class%% .df_person_photo');
        $fields['image_padding'] = array('padding' => '%%order_class%% .df_person_photo');
        $fields['social_margin'] = array('margin' => $social_icon);
        $fields['social_padding'] = array('padding' => $social_icon);
        $fields['module_wrapper_margin'] = array('margin' => $module_wrapper);
        $fields['module_wrapper_padding'] = array('padding' => $module_wrapper);
        $fields['image_wrapper_margin'] = array('margin' => $image_wrapper);
        $fields['image_wrapper_padding'] = array('padding' => $image_wrapper);

        $fields['details_wrapper_margin'] = array('margin' => '%%order_class%% .df_person_details');
        $fields['details_wrapper_padding'] = array('padding' => '%%order_class%% .df_person_details');
        $fields['content_margin'] = array('margin' => '%%order_class%% .df_ap_person_desc_wrapper');
        $fields['content_padding'] = array('padding' => '%%order_class%% .df_ap_person_desc_wrapper');
       // $fields['description_wrapper_margin'] = array('margin' => '%%order_class%% .df_ap_person_desc_wrapper');
        
        $fields['socail_wrapper_margin'] = array('margin' => '%%order_class%% .df_person_socail_wrapper');
        $fields['socail_wrapper_padding'] = array('padding' => '%%order_class%% .df_person_socail_wrapper');
            
        //Color
        $fields['icon_color'] = array('color' => $social_icon);
        $fields['facebook_icon_color'] = array('color' => $facebook_social_icon);
        $fields['twitter_icon_color'] = array('color' => $twitter_social_icon);
        $fields['linkedin_icon_color'] = array('color' => $linkedin_social_icon);
        $fields['instagram_icon_color'] = array('color' => $instagram_social_icon);
        $fields['pinterest_icon_color'] = array('color' => $pinterest_social_icon);
        $fields['email_icon_color'] = array('color' => $email_social_icon);
        $fields['phone_icon_color'] = array('color' => $phone_social_icon);
        // Background Transition
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'name_background',
            'selector'      => $name
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'role_background',
            'selector'      => $role
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'description_background',
            'selector'      => $description
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'content_background',
            'selector'      => $content
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'social_wrapper_background',
            'selector'      => '%%order_class%% .df_person_socail_wrapper'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'image_wrapper_background',
            'selector'      => $image_wrapper
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'icon_background',
            'selector'      => '%%order_class%% .df_person_social_icon'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'facebook_background',
            'selector'      => '%%order_class%% .df_person_social_icon.facebook'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'ekip_overlay_background',
            'selector'      => '%%order_class%% .df_person_overlay'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'default_overlay_background',
            'selector'      => '%%order_class%% .c4-izmir .df-overlay'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'twitter_background',
            'selector'      => '%%order_class%% .df_person_social_icon.twitter'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'linkedin_background',
            'selector'      => '%%order_class%% .df_person_social_icon.linkedin'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'instagram_background',
            'selector'      => '%%order_class%% .df_person_social_icon.instagram'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'pinterest_background',
            'selector'      => '%%order_class%% .df_person_social_icon.pinterest'
        ));      
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'email_background',
            'selector'      => '%%order_class%% .df_person_social_icon.email'
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'phone_background',
            'selector'      => '%%order_class%% .df_person_social_icon.phone'
        ));
        // border fix
        $fields = $this->df_fix_border_transition(
            $fields,
            'name_border',
            $name
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'role_border',
            $role
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'description_border',
            $description
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'content_border',
            $content
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'photo_border',
            $image
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'photo_wrapper_border',
            $image_wrapper
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'social_icon_border',
            $social_icon
        ); 
        $fields = $this->df_fix_border_transition(
            $fields,
            'social_container_border',
            $social_icon_container
        );   
        // Box shadow transition 

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'content_shadow',
            $content
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'social_icon_shadow',
            $social_icon
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'image_shadow',
            $image
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'image_wrapper_shadow',
            $image_wrapper
        );

        return $fields;
    }
    public function additional_css_styles($render_slug)
    {  
        if($this->props['overlay'] === 'on' && $this->props['style_type'] ==='default_style') {
            $this->df_process_bg(array(
                'render_slug'       => $render_slug,
                'slug'              => 'default_overlay_background',
                'selector'          => '%%order_class%% .c4-izmir .df-overlay',
                'hover'             => '%%order_class%% .df_ap_person_container:hover .c4-izmir .df-overlay',
            ));
        }
        

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_wrapper_max_width',
            'type'              => 'max-width',
            'selector'          => "%%order_class%% .df_person_photo_wrapper",
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_photo_wrapper'
        ));
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_zindex',
            'type'              => 'z-index',
            'selector'          => '%%order_class%% .df_ap_person_desc_wrapper'
        ));
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_wrapper_zindex',
            'type'              => 'z-index',
            'selector'          => '%%order_class%% .df_person_photo_wrapper'
        ));
        
       
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
        if($this->props['image_force_to_fullwidth'] ==='on' && $this->props['enable_alternative_photo'] ==='off'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .c4-izmir',
                'declaration' => 'display: block;'
            ));
        }
        if($this->props['make_full_with_icon'] === 'on'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .df_person_socail_wrapper',
                'declaration' => 'display: flex;'
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .df_person_socail_wrapper .df_person_social_icon',
                'declaration' =>  'flex-grow: 1;
                                   margin: 0px;'
            ));

        }

        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'anm_content_padding',
            'type'              => '--padding',
            'selector'          => '%%order_class%% .c4-izmir'
        ) );
      
        // Image Design
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_alignment',
            'type'              => 'margin',
            'selector'          => "%%order_class%% .df_person_photo_wrapper"
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'social_section_align',
            'type'              => 'text-align',
            'selector'          => '%%order_class%% .df_person_socail_wrapper',
            'default'           => 'left'
        ));

        if ($this->props['image_scale_type'] === 'c4-image-rotate-left') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .df_ap_person_container:hover .c4-image-rotate-left img.person_photo, %%order_class%% :focus.c4-image-rotate-left img.person_photo',
                'declaration' => sprintf('transform: scale(%1$s) rotate(-15deg);', $this->props['image_scale_value'])
            ));
        }
        if ($this->props['image_scale_type'] === 'c4-image-rotate-right') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .df_ap_person_container:hover .c4-image-rotate-right img.person_photo, %%order_class%% :focus.c4-image-rotate-right img.person_photo',
                'declaration' => sprintf('transform: scale(%1$s) rotate(15deg);', $this->props['image_scale_value'])
            ));
        }
        
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => '%%order_class%% .df_ap_person_container .df_ap_person_desc',
            'declaration' => sprintf('transform: %1$s;', 
                $this->df_transform_values($this->props['anim_direction'], 'hover'))
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => '%%order_class%% .df_ap_person_container:hover .df_ap_person_desc',
            'declaration' => sprintf('transform: %1$s;', 
                $this->df_transform_values($this->props['anim_direction'], 'default'))
        ));
        // All background
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'ekip_overlay_background',
            'selector'          => '%%order_class%% .df_person_overlay',
            'default'           => '#00000088'
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'name_background',
            'selector'          => '%%order_class%% .df_person_name',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_name'
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'role_background',
            'selector'          => '%%order_class%% .df_person_role',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_role'
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'description_background',
            'selector'          => '%%order_class%% .df_person_description',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_description'
        ));

        $this->df_process_bg(array(
            'render_slug'   => $render_slug,
            'slug'          => 'content_background',
            'selector'      => '%%order_class%% .df_ap_person_desc_wrapper',
            'hover'         => '%%order_class%% .df_ap_person_container:hover .df_ap_person_desc_wrapper'
        ));
   
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_wrapper_background',
            'selector'          => '%%order_class%% .df_person_photo_wrapper',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_photo_wrapper'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'social_wrapper_background',
            'selector'          => '%%order_class%% .df_person_socail_wrapper',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_socail_wrapper'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_background',
            'selector'          => '%%order_class%% .df_person_social_icon',
            'hover'             => '%%order_class%% .df_person_social_icon:hover'
        ));
           
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'facebook_background',
            'selector'          => '%%order_class%% .df_person_social_icon.facebook',
            'hover'             => '%%order_class%% .df_person_social_icon.facebook:hover'
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'twitter_background',
            'selector'          => '%%order_class%% .df_person_social_icon.twitter',
            'hover'             => '%%order_class%% .df_person_social_icon.twitter:hover'
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'linkedin_background',
            'selector'          => '%%order_class%% .df_person_social_icon.linkedin',
            'hover'             => '%%order_class%% .df_person_social_icon.linkedin:hover'
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'instagram_background',
            'selector'          => '%%order_class%% .df_person_social_icon.instagram',
            'hover'             => '%%order_class%% .df_person_social_icon.instagram:hover'
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pinterest_background',
            'selector'          => '%%order_class%% .df_person_social_icon.pinterest',
            'hover'             => '%%order_class%% .df_person_social_icon.pinterest:hover'
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'phone_background',
            'selector'          => '%%order_class%% .df_person_social_icon.phone',
            'hover'             => '%%order_class%% .df_person_social_icon.phone:hover'
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'email_background',
            'selector'          => '%%order_class%% .df_person_social_icon.email',
            'hover'             => '%%order_class%% .df_person_social_icon.email:hover'
        ));
        
        //Socail Icon Color
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df_person_social_icon .et-pb-icon',
            'hover'             => '%%order_class%% .df_person_social_icon:hover .et-pb-icon'
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'facebook_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df_person_social_icon.facebook .et-pb-icon',
            'hover'             => '%%order_class%% .df_person_social_icon.facebook:hover .et-pb-icon'
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'twitter_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df_person_social_icon.twitter .et-pb-icon',
            'hover'             => '%%order_class%% .df_person_social_icon.twitter:hover .et-pb-icon'
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'linkedin_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df_person_social_icon.linkedin .et-pb-icon',
            'hover'             => '%%order_class%% .df_person_social_icon.linkedin:hover .et-pb-icon'
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'instagram_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df_person_social_icon.instagram .et-pb-icon',
            'hover'             => '%%order_class%% .df_person_social_icon.instagram:hover .et-pb-icon'
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pinterest_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df_person_social_icon.pinterest .et-pb-icon',
            'hover'             => '%%order_class%% .df_person_social_icon.pinterest:hover .et-pb-icon'
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'email_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df_person_social_icon.email .et-pb-icon',
            'hover'             => '%%order_class%% .df_person_social_icon.email:hover .et-pb-icon'
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'phone_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df_person_social_icon.phone .et-pb-icon',
            'hover'             => '%%order_class%% .df_person_social_icon.phone:hover .et-pb-icon'
        ));

        // Icon Size
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_size',
            'type'              => 'font-size',
            'selector'          => "%%order_class%% .df_person_social_icon .et-pb-icon",
            'hover'             => '%%order_class%% .df_person_social_icon:hover .et-pb-icon'
        ));
        
        // module wrapper spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'module_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ap_person_wrapper',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_ap_person_wrapper',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'module_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ap_person_wrapper',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_ap_person_wrapper',
            'important'         => false
        ));

        // Image wrapper spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_person_photo_wrapper',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_photo_wrapper',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_person_photo_wrapper',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_photo_wrapper',
            'important'         => false
        ));

        // person details wrapper spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'details_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_person_details',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_details',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'details_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_person_details',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_details',
            'important'         => false
        ));

        
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ap_person_desc_wrapper',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_ap_person_desc_wrapper',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ap_person_desc_wrapper',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_ap_person_desc_wrapper',
            'important'         => false
        ));

        // Social wrapper spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'social_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_person_socail_wrapper',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_socail_wrapper',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'social_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_person_socail_wrapper',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_socail_wrapper',
            'important'         => false
        ));

        // Name spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'name_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_person_name',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_name',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'name_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_person_name',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_name',
            'important'         => false
        ));

        // Role spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'role_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_person_role',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_role',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'role_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_person_role',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_role',
            'important'         => false
        ));

        // Description spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'description_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_person_description',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_description',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'description_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_person_description',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_description',
            'important'         => false
        ));

        // Image spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_person_photo',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_photo',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_person_photo',
            'hover'             => '%%order_class%% .df_ap_person_container:hover .df_person_photo',
            'important'         => false
        ));

        // Social spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'social_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_person_socail_wrapper .df_person_social_icon',
            'hover'             => '%%order_class%% .df_person_socail_wrapper .df_person_social_icon:hover',
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'social_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_person_social_icon',
            'hover'             => '%%order_class%% .df_person_social_icon:hover',
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'first_social_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_person_social_icon:first-child",
            'hover'             => "{$this->main_css_element} .df_person_social_icon:hover:first-child",
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'last_social_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_person_social_icon:last-child",
            'hover'             => "{$this->main_css_element} .df_person_social_icon:hover:last-child",
            'important'         => true
        ));
        
      // process animation transition
      $this->df_process_transition(array(
        'render_slug'       => $render_slug,
        'slug'              => 'overlay_transition',
        'selector'          => '%%order_class%% .df_ap_person_container .df_person_overlay , %%order_class%% .df_ap_person_container.df_ap_ekip_style_2 .df_ap_person_desc',
        'properties'        => ['opacity', 'transform']
    ));    
   
    }
    public function df_social_icon($icon){
        return sprintf(
            '<span class="et-pb-icon socail_icon">%1$s</span>',
                $icon !== '' ?
                esc_attr(et_pb_process_font_icon($icon)) : '5'
        );
    }
    
    public function df_render_image($props_key)
    {  
        if (isset($this->props[$props_key]) && $this->props[$props_key] !== '') {
            
            $photo_alt_text = $this->props['photo_alt_text'] !== '' ? $this->props['photo_alt_text']  : df_image_alt_by_url($this->props[$props_key]);
            $src = 'src';
            $image_html = sprintf(
                '<img class="person_photo" %3$s="%1$s" alt="%4$s" />',
                esc_url($this->props[$props_key]),
                $props_key,
                $src,
                $photo_alt_text
            );
            if(isset($this->props['ap_alternative_photo']) && $this->props['enable_alternative_photo'] === 'on' && !empty($this->props['ap_alternative_photo'])&&  $this->props['style_type'] ==='default_style'){
                $alternative_photo_alt_text = $this->props['alternative_photo_alt_text'] !== '' ? $this->props['alternative_photo_alt_text']  : df_image_alt_by_url($this->props['ap_alternative_photo']);
                $image_html .=  sprintf(
                    '<img class="person_photo img-top" %3$s="%1$s" alt="%4$s"/>',
                    esc_url($this->props['ap_alternative_photo']),
                    'ap_alternative_photo',
                    $src,
                    $alternative_photo_alt_text
                );
               
                return sprintf(
                    '<div class="alter_image"> %1$s</div>',
                    $image_html
                );
                
              
            }

            return $image_html;
                   
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
                'hover'     => 'translateY(-100%)'
            ],
            'bottom'        => [
                'default'   => 'translateY(0px)',
                'hover'     => 'translateY(100%)'
            ],
            'left'          => [
                'default'   => 'translateX(0px)',
                'hover'     => 'translateX(-100%)'
            ],
            'right'         => [
                'default'   => 'translateX(0px)',
                'hover'     => 'translateX(100%)'
            ],
            'center'        => [
                'default'   => 'scale(1)',
                'hover'     => 'scale(0)'
            ],
            'top_right'     => [
                'default'   => 'translateX(0px) translateY(0px)',
                'hover'     => 'translateX(100%) translateY(-100%)'
            ],
            'top_left'      => [
                'default'   => 'translateX(0px) translateY(0px)',
                'hover'     => 'translateX(-100%) translateY(-100%)'
            ],
            'bottom_right'  => [
                'default'   => 'translateX(0px) translateY(0px)',
                'hover'     => 'translateX(100%) translateY(100%)'
            ],
            'bottom_left'   => [
                'default'   => 'translateX(0px) translateY(0px)',
                'hover'     => 'translateX(-100%) translateY(100%)'
            ]
        );
        return $transform_values[$key][$state];
    }
    
    public function render($attrs, $content, $render_slug)
    {  	
        $name_level  =  esc_attr($this->props['ap_name_tag']);
        $role_level  =  esc_attr($this->props['ap_role_tag']);
        $name_html = $this->props['ap_name'] !== '' ?
            sprintf('<%1$s  class="df_person_name">%2$s</%1$s >', $name_level, esc_attr($this->props['ap_name']) ) : '';
        $role_html = $this->props['ap_role'] !== '' ?
            sprintf('<%1$s  class="df_person_role">%2$s</%1$s >', $role_level, esc_attr($this->props['ap_role']) ) : '';    
        $description = $this->props['ap_description'] !== '' ?
            sprintf('<div class="df_person_description"> %1$s</div>', $this->props['ap_description']  ) : '';
        $pattern = "/<p[^>]*><\\/p[^>]*>/"; 
        $description = preg_replace($pattern, '', $description);  //$description = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $description); // remove 1.2.4 version
        $member_details_html = ($name_html !== '') || ($role_html !== '') || ($description !== '') ?
                            sprintf('<div class="df_person_details">
                                %1$s%2$s%3$s
                            </div>',
                            $name_html,
                            $role_html,
                            $description
                            ) : '';  

        $facebook = $this->props['ap_facebook'] !== '' ?
            sprintf('<a href="%1$s" class="df_person_social_icon facebook" target="_blank" df-tooltip="Facebook" title="" aria-expanded="false">
                %2$s
            </a>', esc_url($this->props['ap_facebook']), $this->df_social_icon('%%291%%') ) : '';

        $twitter = $this->props['ap_twitter'] !== '' ?
            sprintf('<a href="%1$s" class="df_person_social_icon twitter" target="_blank" df-tooltip="Twitter" title="" aria-expanded="false">
                %2$s
            </a>', esc_url($this->props['ap_twitter']) ,  $this->df_social_icon('%%292%%') ) : '';

        $linkedin = $this->props['ap_linkedin'] !== '' ?
            sprintf('<a href="%1$s" class="df_person_social_icon linkedin" target="_blank" df-tooltip="Linkedin" title="" aria-expanded="false">
                %2$s
            </a>', esc_url($this->props['ap_linkedin']) ,  $this->df_social_icon('%%301%%') ) : '';

        $instagram = $this->props['ap_instagram'] !== '' ?
            sprintf('<a href="%1$s" class="df_person_social_icon instagram" target="_blank" df-tooltip="Instagram" title="" aria-expanded="false">
                %2$s
            </a>', esc_url($this->props['ap_instagram']) ,  $this->df_social_icon('%%298%%') ) : '';

        $pinterest = $this->props['ap_pinterest'] !== '' ?
        sprintf('<a href="%1$s" class="df_person_social_icon pinterest" target="_blank" df-tooltip="Pinterest" title="" aria-expanded="false">
            %2$s
        </a>', esc_url($this->props['ap_pinterest']) ,  $this->df_social_icon('%%293%%') ) : '';

        $email = $this->props['ap_email'] !== '' ?
        sprintf('<a href="mailto:%1$s" class="df_person_social_icon email" target="_blank" df-tooltip="Email" title="" aria-expanded="false">
            %2$s
        </a>', esc_attr($this->props['ap_email']) ,  $this->df_social_icon('%%238%%') ) : '';

        $phone = $this->props['ap_phone'] !== '' ?
        sprintf('<a href="tel:%1$s" class="df_person_social_icon phone" target="_blank" df-tooltip="Phone" title="" aria-expanded="false">
            %2$s
        </a>', esc_attr($this->props['ap_phone']) ,  $this->df_social_icon('%%264%%') ) : '';

        $socail_html = ($facebook !=='' || $twitter !=='' || $linkedin !=='' || $instagram !=='' || $pinterest !=='' || $email !=='' || $phone !=='') ? 
                        sprintf('<div class="df_person_socail_wrapper %8$s">
                                %1$s
                                %2$s
                                %3$s
                                %4$s
                                %5$s
                                %6$s
                                %7$s             
                            </div>', 
                            $facebook, 
                            $twitter, 
                            $linkedin, 
                            $instagram,
                            $pinterest,
                            $email,
                            $phone,
                            $this->props['make_vertical_icon'] ==='on' && $this->props['style_type'] === 'default_style' ? 'vertical' : ''
                        ): '';
        $border_anim_class = $this->props['border_anim'] === 'on' ? $this->props['border_anm_style'] : '';
       
        $icon_reveal_class = $this->props['always_show_icon'] === 'on' ? 
                        'always-show-title' : $this->props['icon_reveal_caption'];
        $overlay_social = $this->props['enable_icon_on_overlay'] === 'on' ? sprintf('<div class="%1$s">%2$s</div>',
                            $icon_reveal_class,                    
                            $socail_html
                        ): '';   

        $overlay_content =  ( $this->props['style_type'] === 'default_style' && $this->props['enable_icon_on_overlay'] === 'on' ) ? 
                    sprintf('<figcaption class="df_ap_person_content %1$s ">
                            %2$s
                            %3$s
                            %4$s
                        </figcaption>' , 
                        $this->props['content_position'] !==''? $this->props['content_position']:'',
                        isset($overlay_name)   ? $overlay_name : '',
                        isset($overlay_role)   ? $overlay_role : '',
                        isset($overlay_social) ? $overlay_social : ''
                        )
                        :
                        '<figcaption class="df_ap_person_content"></figcaption>' ;   
        
        $person_photo = $this->df_render_image('ap_photo') !== '' ? 
                        sprintf('<div class="df_person_photo_wrapper">
                                    <div class=" %6$s %5$s">
                                        %2$s
                                        <div class="df_person_photo">
                                            %1$s
                                        </div>
                                        %3$s
                                    </div>
                                </div>',
                                $this->df_render_image('ap_photo'),
                                ( $this->props['overlay'] === 'on' && $this->props['enable_alternative_photo'] !=='on' ) ? '<span class="df-overlay"></span>' : '',
                                $overlay_content,
                                $this->props['image_scale_type'] !=='' ? $this->props['image_scale_type'] : '',
                                $border_anim_class,
                                ($this->props['overlay'] === 'on' || $this->props['border_anim'] === 'on' ||  $this->props['enable_alternative_photo'] === 'on' || $this->props['enable_icon_on_overlay'] === 'on') ? 'c4-izmir' : 'c4-izmir'
                            ): '';
        
        $this->additional_css_styles($render_slug);
                 // filter for images
		if (array_key_exists('image', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['image'])) {
			$this->add_classname($this->generate_css_filters(
				$render_slug,
				'child_',
				self::$data_utils->array_get($this->advanced_fields['image']['css'], 'main', '%%order_class%%')
			));
		}
        if($this->props['style_type'] === 'default_style') {
            $person_html  = sprintf('<div class="df_ap_person_wrapper %6$s">
                                    %1$s
                                    <div class="df_ap_person_desc_wrapper">
                                        <div class="df_person_details">
                                            %2$s
                                            %3$s
                                            %4$s
                                        </div>
                                        %5$s
                                    </div>
                                </div>',
                              
                                $person_photo,
                                $name_html,
                                $role_html,
                                $description,
                                (isset($this->props['enable_icon_on_overlay']) && $this->props['enable_icon_on_overlay'] !== 'on' )  ?  $socail_html : '',
                                $this->props['image_scale_type'] !=='' ? $this->props['image_scale_type'] : ''
                        );
        }else if($this->props['style_type'] === 'ekip_style'){
            $overlay_class = 'df_person_overlay';
            $person_html =sprintf('<div class="df_ap_person_wrapper">
                                    %1$s
                                    <div class="df_ap_person_desc %4$s">
                                        <div class="df_ap_person_desc_wrapper">
                                            %2$s
                                            %3$s
                                        </div>
                                    </div>
                                </div>
                            ',$person_photo,
                            $member_details_html,
                            $socail_html,
                            $overlay_class
                            );      
        }
        else if($this->props['style_type'] === 'ekip_style_2'){
            
            $person_html =sprintf('<div class="df_ap_person_wrapper %4$s">
                                        %1$s
                                        <div class="df_ap_person_desc">
                                            <div class="df_ap_person_desc_wrapper">
                                                %2$s
                                                %3$s
                                            </div>
                                        </div>
                                    </div>
                                ',$person_photo,
                                $member_details_html,
                                $socail_html,
                                $this->props['image_scale_type'] !=='' ? $this->props['image_scale_type'] : ''
                                );      
        }

        $layout_class = 'df_ap_' . esc_attr($this->props['style_type']);
     
        $html_code = sprintf('<div class="df_ap_person_container %2$s"> %1$s</div>', $person_html,$layout_class );
        
        return sprintf('%1$s', $html_code);
    }
}

new DIFL_AdvancedPerson;