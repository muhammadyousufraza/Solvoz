<?php

class DIFL_ImageAccordion extends ET_Builder_Module {
    public $slug       = 'difl_imageaccordion';
    public $vb_support = 'on';
    public $child_slug = 'difl_imageaccordionitem';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Image Accordion', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/image-accordion.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'accordion_setting'         => esc_html__('Accordion Settings', 'divi_flash'),
                    'advanced_settings'         => esc_html__('Advanced Accordion Settings', 'divi_flash'),
                    'fii_animation' => esc_html__('Text Animation Settings', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'design_overlay'                => esc_html__('Overlay', 'divi_flash'),
                    'design_item'                  => esc_html__('Items', 'divi_flash'),
                    'ic_image'                  => esc_html__('Image Settings', 'divi_flash'),
                    'design_content'                  => esc_html__('Content', 'divi_flash'),
                    'ia_hover'                  => esc_html__('Hover', 'divi_flash'),
                    'design_icon'                  => esc_html__('Icon', 'divi_flash'),
                    'design_title'                  => esc_html__('Title', 'divi_flash'),
                    'design_sub_title'                  => esc_html__('Sub Title', 'divi_flash'),
                    'design_description'                  => esc_html__('Description', 'divi_flash'),
                    'design_button'                  => esc_html__('Button', 'divi_flash'),
                    'custom_spacing'    => array (
                        'title'             => esc_html__('Custom Spacing', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'item'   => array(
                                'name' => 'Item',
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

    
    public function get_fields() {
        $general = array ();
        $accordion_setting = array (
            'accordion_type'      => array(
                'label'           => esc_html__('Select Accordion Type ', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'horizontal'  => esc_html__('Horizontal', 'divi_flash'),
                    'vertical'    => esc_html__('Vertical ', 'divi_flash'),
                ),
                'default'           => 'horizontal',
                'option_category'   => 'basic_option',
                'toggle_slug'       => 'accordion_setting',
                'description'       => esc_html__('Choose Image accordion Type', 'divi_flash')
            ), 
            'vertical_at_mobile'  => array (
                'label'             => esc_html__('Vertical Accordion At Mobile ', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'divi_flash' ),
                    'on'  => esc_html__( 'On', 'divi_flash' )
                ),
                'default'           => 'on',
                'toggle_slug'       => 'accordion_setting',
                'show_if'       => array(
                    'accordion_type' => 'horizontal'
                )
            ),
            'event_type'      => array(
                'label'           => esc_html__('Select Event Type ', 'divi_flash'),
                'type'            => 'select',
                'default'           => 'click',
                'options'         => array(
                    'mouseover' => esc_html__('Hover', 'divi_flash'),
                    'click'  => esc_html__('Click', 'divi_flash')
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'accordion_setting',
                'description'     => esc_html__('Choose Image accordion event', 'divi_flash')
            ),  

            'active_on_first_time'  => array (
                'label'             => esc_html__('Active Item on First Time', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'divi_flash' ),
                    'on'  => esc_html__( 'On', 'divi_flash' )
                ),
                'default'           => 'on',
                'toggle_slug'     => 'accordion_setting',
            ),

            'active_item_order_number' => array (
                'label'             => esc_html__( 'Active Item Order Number', 'divi_flash' ),
				'type'              => 'range',
				'default'           => '1',
                'default_unit'      => '',
                'allowed_units'     => array (),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '10',
					'step' => '1'
                ),
                'show_if' => array(
                    'active_on_first_time' => 'on',
                ),
                'toggle_slug'     => 'accordion_setting'
            ),
            'outer_click_close_item'  => array (
                'label'             => esc_html__('Close Item On Click Outside Accordion', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'divi_flash' ),
                    'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'accordion_setting',
            ),
            'accordion_container_height' => array (
                'label'             => esc_html__( 'Accordion Container Height', 'divi_flash' ),
				'type'              => 'range',
				'default'           => '450px',
                'default_unit'      => 'px',
                'allowed_units'     => array ('px','%','vh'),
                // 'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '1000',
					'step' => '1'
                ),
                'toggle_slug'     => 'accordion_setting',
                'mobile_options' => true
            ),
            'content_alignment' => array(
                'label'           => esc_html__('Content Alignment', 'divi_flash'),
                'type'            => 'text_align',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'     => 'design_content',
                'tab_slug'    => 'advanced',
                'mobile_options'  => true     
            ),
            'item_spacing' => array(
                'label'               => sprintf(esc_html__('Item Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'item',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'item_padding' => array(
                'label'               => sprintf(esc_html__('Item Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'item',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'first_item_spacing' => array(
                'label'               => sprintf(esc_html__('First Item Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'item',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'last_item_spacing' => array(
                'label'               => sprintf(esc_html__('Last Item Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'item',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
   
        );
        $animation = array (
            'enable_animation'  => array (
                'label'             => esc_html__('Enable Animation', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'divi_flash' ),
                    'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'on',
                'toggle_slug'       => 'fii_animation'
            ),
            'content_animation' => array(
                'label'                 => esc_html__('Animation', 'divi_flash'),
                'type'                  => 'select',
                'default'               => 'fade_in',
                'options'               => array(
                    'slide_left'            => esc_html__('Slide Left', 'divi_flash'),
                    'slide_right'           => esc_html__('Slide Right', 'divi_flash'),
                    'slide_up'              => esc_html__('Slide Up', 'divi_flash'),
                    'slide_down'            => esc_html__('Slide Down', 'divi_flash'),
                    'fade_in'               => esc_html__('Fade', 'divi_flash'),
                    'zoom_left'             => esc_html__('Zoom Left', 'divi_flash'),
                    'zoom_center'           => esc_html__('Zoom Center', 'divi_flash'),
                    'zoom_right'             => esc_html__('Zoom Right', 'divi_flash'),
                ),
                'toggle_slug'            => 'fii_animation',
                'tab_slug'               => 'general',
                'show_if' => array(
                    'enable_animation' => 'on',
                )
            ),
            'duration'                => array (
                'label'             => esc_html__( 'Duration (ms)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'fii_animation',
				'default'           => '1000',
                'default_unit'      => '',
                'allowed_units'     => array (),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '100',
					'max'  => '20000',
					'step' => '50',
                ),
                'show_if' => array(
                    'enable_animation' => 'on',
                )
            ),
            'delay'                => array (
                'label'             => esc_html__( 'Delay (ms)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'fii_animation',
				'default'           => '200',
                'default_unit'      => '',
                'allowed_units'     => array (),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '2000',
					'step' => '50',
                ),
                'show_if' => array(
                    'enable_animation' => 'on',
                )
            ),
            'animation_function'   => array(
                'label'     => esc_html__('Animation Timing Function', 'divi_flash'),
                'type'      => 'select',
                'options'   => array(
                    'easeInQuad' => esc_html__('easeInQuad', 'divi_flash'),
                    'easeInCubic' => esc_html__('easeInCubic', 'divi_flash'),
                    'easeInQuart' => esc_html__('easeInQuart', 'divi_flash'),
                    'easeInQuint' => esc_html__('easeInQuint', 'divi_flash'),
                    'easeInSine' => esc_html__('easeInSine', 'divi_flash'),
                    'easeInExpo' => esc_html__('easeInExpo', 'divi_flash'),
                    'easeInCirc' => esc_html__('easeInCirc', 'divi_flash'),
                    'easeInBack' => esc_html__('easeInBack', 'divi_flash'),
                    'easeInBounce' => esc_html__('easeInBounce', 'divi_flash'),
                    'easeInOutQuad' => esc_html__('easeInOutQuad', 'divi_flash'),
                    'easeInOutCubic' => esc_html__('easeInOutCubic', 'divi_flash'),
                    'easeInOutQuart' => esc_html__('easeInOutQuart', 'divi_flash'),
                    'easeInOutQuint' => esc_html__('easeInOutQuint', 'divi_flash'),
                    'easeInOutSine' => esc_html__('easeInOutSine', 'divi_flash'),
                    'easeInOutExpo' => esc_html__('easeInOutExpo', 'divi_flash'),
                    'easeInOutCirc' => esc_html__('easeInOutCirc', 'divi_flash'),
                    'easeInOutBack' => esc_html__('easeInOutBack', 'divi_flash'),
                    'easeInOutBounce' => esc_html__('easeInOutBounce', 'divi_flash'),
                    'easeOutQuad' => esc_html__('easeOutQuad', 'divi_flash'),
                    'easeOutCubic' => esc_html__('easeOutCubic', 'divi_flash'),
                    'easeOutQuart' => esc_html__('easeOutQuart', 'divi_flash'),
                    'easeOutQuint' => esc_html__('easeOutQuint', 'divi_flash'),
                    'easeOutSine' => esc_html__('easeOutSine', 'divi_flash'),
                    'easeOutExpo' => esc_html__('easeOutExpo', 'divi_flash'),
                    'easeOutCirc' => esc_html__('easeOutCirc', 'divi_flash'),
                    'easeOutBack' => esc_html__('easeOutBack', 'divi_flash'),
                    'easeOutBounce' => esc_html__('easeOutBounce', 'divi_flash'),
                    'linear' => esc_html__('linear', 'divi_flash')
                ),
                'default'       => 'linear',
                'toggle_slug'   => 'fii_animation',
                'show_if' => array(
                    'enable_animation' => 'on',
                )
            ),
            'enable_stagger'  => array (
                'label'             => esc_html__('Enable Stagger', 'divi_flash'),
                'description'       => esc_html__('Stagger allows to animate Title, Sub title, Description and Button Indivisually', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'divi_flash' ),
                    'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'fii_animation',
                'show_if'           => array (
                    'enable_animation' => 'on'
                )
            ),
            'stagger'                => array (
                'label'             => esc_html__( 'Stagger', 'divi_flash' ),
                'description'       => esc_html__('Staggering allows to animate Title, Sub title, Description and Button. So delay by 100ms for each elements', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'fii_animation',
                'default'           => '100',
                'default_unit'      => '',
                'allowed_units'     => array (),
                'validate_unit'     => false,
                'range_settings'    => array(
                    'min'  => '100',
                    'max'  => '1000',
                    'step' => '10',
                ),
                'show_if' => array(
                    'enable_stagger' => 'on',
                    'enable_animation' => 'on',
                )
            ),
  
        );
        $overlay = $this->df_add_bg_field(array (
			'label'				    => 'Overlay',
            'key'                   => 'ia_overlay_background',
            'toggle_slug'           => 'design_overlay',
            'tab_slug'              => 'advanced',
            'image'                 => false
        ));

        $active_overlay = $this->df_add_bg_field(array (
			'label'				    => 'Active Overlay',
            'key'                   => 'ia_active_overlay_background',
            'toggle_slug'           => 'design_overlay',
            'tab_slug'              => 'advanced',
            'image'                 => false
        ));

        $vertical_align = array (
            'vertical_align' => array (
                'default'         => 'flex-start',
                'label'           => esc_html__( 'Content Vertical Align', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'flex-start'    => esc_html__( 'Top', 'divi_flash' ),
                    'center'        => esc_html__( 'Center', 'divi_flash' ),
                    'flex-end'      => esc_html__( 'Bottom', 'divi_flash' ),
                ),
                'toggle_slug'     => 'design_content',
                'tab_slug'        => 'advanced'
            )
        );
        
        $content_bg = $this->df_add_bg_field(array (
			'label'				    => 'Content Background',
            'key'                   => 'ia_content_background',
            'toggle_slug'           => 'design_content',
            'tab_slug'              => 'advanced'
        ));
        $icon_background = $this->df_add_bg_field(array(
            'label'                 => 'Icon Background',
            'key'                   => 'icon_background',
            'toggle_slug'           => 'design_icon',
            'tab_slug'              => 'advanced'
        ));
        $icon_settings = array(    
            'icon_color'            => array (
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
                'toggle_slug'       => 'design_icon',
                'tab_slug'          => 'advanced',
                'hover'             => 'tabs'
            ),
            'icon_size'             => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'toggle_slug'       => 'design_icon',
                'tab_slug'          => 'advanced',
                'default'           => '50px',
                'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
                ),
				'mobile_options'    => true,
                'responsive'        => true
            ),
            'image_as_icon_width' => array(
                'label'             => esc_html__('Image as Icon Width(%)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_icon',
                'tab_slug'          => 'advanced',
                'default'           => '50px',
                'default_unit'      => 'px',
                'allowed_units'     => array('%', 'px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'important'           => false
            ),
           
        );
        $icon_spacing = $this->add_margin_padding(array(
            'title'       => 'Icon',
            'key'         => 'icon',
            'toggle_slug' => 'custom_spacing',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'content'
        ));
        $content_spacing = $this->add_margin_padding(array(
            'title'         => 'Content Area',
            'key'           => 'content',
            'toggle_slug'   => 'custom_spacing',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'content'
        ));
        $content_inner_margin = array(
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
            'sub_title_margin' => array(
                'label'               => sprintf(esc_html__('Sub Title Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'description_margin' => array(
                'label'               => sprintf(esc_html__('Description Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true
            ),
        );
        $button_style = $this->df_add_btn_styles(array (
            'key'                   => 'ia_btn',
            'toggle_slug'           => 'design_button',
            'tab_slug'              => 'advanced'
        ));
        $buttons_bg = $this->df_add_bg_field(array (
			'label'				    => 'Button Background',
            'key'                   => 'ia_btn_background',
            'toggle_slug'           => 'design_button',
            'tab_slug'              => 'advanced'
        ));

        $button_spacing = $this->add_margin_padding(array(
            'title'         => 'Button',
            'key'           => 'button',
            'toggle_slug'   => 'custom_spacing',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'content'
        ));
        return array_merge(
            $general,
            $accordion_setting,
            $animation,
            $overlay,
            $active_overlay,
            $vertical_align,
            $content_bg,       
            $icon_spacing,
            $content_inner_margin,
            $content_spacing,
            $icon_background,
            $icon_settings,
            $button_style,
            $buttons_bg,
            $button_spacing     
        );
    }
    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = array (
            'title'   => array(
                'label'         => esc_html__('Title', 'divi_flash'),
                'toggle_slug'   => 'design_title',
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
                    'main' => " %%order_class%% .df_ia_title ",
                    'hover' => "%%order_class%% .difl_imageaccordionitem:hover .df_ia_title",
                    'important' => 'all'
                ),
            ),
            'sub_title'   => array(
                'label'         => esc_html__('Sub Title', 'divi_flash'),
                'toggle_slug'   => 'design_sub_title',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em'
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'font-weight' => array(
                    'default' => 'semi-bold'
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ia_sub_title ",
                    'hover' => "%%order_class%% .difl_imageaccordionitem:hover .df_ia_sub_title",
                    'important' => 'all'
                ),
            ),
            'description'   => array(
                'label'         => esc_html__('Description', 'divi_flash'),
                'toggle_slug'   => 'design_description',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em'
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'font-weight' => array(
                    'default' => 'semi-bold'
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ia_description ",
                    'hover' => "%%order_class%% .difl_imageaccordionitem:hover .df_ia_description",
                    'important' => 'all'
                ),
            ),
            'button'   => array(
                'label'         => esc_html__('Button', 'divi_flash'),
                'toggle_slug'   => 'design_button',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em'
                ),
                'font_size' => array(
                    'default' => '16px'
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ia_button ",
                    'hover' => "%%order_class%% .difl_imageaccordionitem .df_ia_button:hover",
                    'important' => 'all'
                ),
            ),
        );
        $advanced_fields['borders'] = array (
            'default'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%%',
                        'border_radii_hover' => '%%order_class%%:hover',
                        'border_styles' => '%%order_class%%',
                        'border_styles_hover' => '%%order_class%%:hover'
                    )
                )
            ),
            'item_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .difl_imageaccordionitem",
                        'border_radii_hover' => "{$this->main_css_element} .difl_imageaccordionitem:hover",
                        'border_styles' => "{$this->main_css_element} .difl_imageaccordionitem",
                        'border_styles_hover' => "{$this->main_css_element} .difl_imageaccordionitem:hover"
                    )
                ),
                'label'    => esc_html__('Items Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_item'
            ),
            'content_border'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .content",
                        'border_styles' => "{$this->main_css_element} .content",
                        'border_styles_hover' => "{$this->main_css_element} .content:hover"
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'design_content'
            ),
            'button_border'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .df_ia_button",
                        'border_styles' => "{$this->main_css_element} .df_ia_button",
                        'border_styles_hover' => "{$this->main_css_element} .df_ia_button:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'design_button'
            ),
            'icon_border'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .df-image-accordion-icon",
                        'border_styles' => "{$this->main_css_element} .df-image-accordion-icon",
                        'border_styles_hover' => "{$this->main_css_element} .df-image-accordion-icon:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'design_icon'
            ),
        );
        $advanced_fields['box_shadow'] = array (
            'default' => array(
                'css' => array(
                    'main' => "{$this->main_css_element}"
                ),
            ),
            'item_box_shadow'             => array(
                'label'    => esc_html__('Items Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "{$this->main_css_element} .difl_imageaccordionitem",
                    'hover' => "{$this->main_css_element} .difl_imageaccordionitem:hover"
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_item',
            ),
            'content_box_shadow' => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .content",
                    'hover' => "{$this->main_css_element} .content:hover"
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'design_content'
            ),
            'icon_box_shadow' => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df-image-accordion-icon",
                    'hover' => "{$this->main_css_element} .df-image-accordion-icon:hover"
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'design_icon'
            ),
            'button_box_shadow' => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_ia_button",
                    'hover' => "{$this->main_css_element} .df_ia_button:hover"
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'design_button'
            )
            
        );


        $advanced_fields['filters'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['transform'] = array(
			'css' => array(
				'main'	=> "{$this->main_css_element} .difl_imageaccordionitem"
			)
        );
    
        return $advanced_fields;
    }

    public function before_render() {
        $this->props['event_type__hover'] = '1px||||false|false';
        $this->props['event_type__hover_enabled'] = 'on|hover';
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
       
        $item =  '%%order_class%% .difl_imageaccordionitem';
        $item_overlay =  '%%order_class%% .difl_imageaccordionitem:before';
        $item_active_overlay = '%%order_class%% .difl_imageaccordionitem.df_ia_active:before';
        $content = '%%order_class%% .content';
        $title = "%%order_class%% .df_ia_title";
        $sub_title = "%%order_class%% .df_ia_sub_title";
        $description = "%%order_class%% .df_ia_description";
        $button = "%%order_class%% .df_ia_button";
        $icon = "%%order_class%% .df-image-accordion-icon";
        
        // custom tansition
        $fields['event_type'] = array ('flex' => $item);

        $fields['item_spacing'] = array('margin' => $item);
        $fields['item_padding'] = array ('padding' => $item);

        $fields['content_margin'] = array ('margin' => $content);
        $fields['content_padding'] = array ('padding' => $content);
        $fields['icon_margin'] = array ('margin' => $icon);
        $fields['icon_padding'] = array ('padding' => $icon);

        $fields['title_margin'] = array ('margin' => $title);
        $fields['sub_title_margin'] = array ('margin' => $sub_title);
        $fields['description_margin'] = array ('margin' => $description);
        $fields['button_margin'] = array ('margin' => '%%order_class%% .df_ia_button_wrapper');
        $fields['button_padding'] = array ('padding' => $button);
        $fields['testing'] = array('flex'=> $item);
        
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'ia_overlay_background',
            'selector'      => $item_overlay
        ));

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'ia_active_overlay_background',
            'selector'      => $item_active_overlay
        ));

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'ia_btn_background',
            'selector'      => $button
        ));

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'ia_content_background',
            'selector'      => $content
        ));

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'icon_background',
            'selector'      => $icon
        ));

        // Color 
        $fields['icon_color'] = array('color' => $icon);
        // border fix
        $fields = $this->df_fix_border_transition(
            $fields,
            'item_border',
            $item
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
            'icon_border',
            $icon
        );
        //box-shadow Fix
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'item_box_shadow',
            $item
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'content_box_shadow',
            $content
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'button_box_shadow',
            $button
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'icon_box_shadow',
            $icon
        );
        

        
        return $fields;
    }

    public function get_custom_css_fields_config() {
        return array(
			'accordion_item' => array(
				'label'    => esc_html__( 'Accordion Item', 'divi_flash' ),
				'selector' => '%%order_class%% .difl_imageaccordionitem'
            ),
			'title' => array(
				'label'    => esc_html__( 'Title', 'divi_flash' ),
				'selector' => '%%order_class%% .difl_imageaccordionitem .df_ia_title'
            ),
            'sub_title' => array(
				'label'    => esc_html__( 'Sub Title', 'divi_flash' ),
				'selector' => '%%order_class%% .difl_imageaccordionitem .df_ia_sub_title'
            ),
            'description' => array(
				'label'    => esc_html__( 'Description', 'divi_flash' ),
				'selector' => '%%order_class%% .difl_imageaccordionitem .df_ia_description'
            ),
			'button' => array(
				'label'    => esc_html__( 'Button', 'divi_flash' ),
				'selector' => '%%order_class%% .difl_imageaccordionitem .df_ia_button'
            ),
			
		);
    }
    
    public function additional_css_styles($render_slug) {

        if($this->props['vertical_at_mobile'] === 'on' && $this->props['accordion_type'] === 'horizontal'){
            
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "{$this->main_css_element} .item-wrapper.vertical_at_mobile",
                'declaration' => 'flex-direction: column;',
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "{$this->main_css_element} .item-wrapper",
            'declaration' => 'display:flex;'
        ));

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'accordion_container_height',
            'type'              => 'height',
            'selector'          => "{$this->main_css_element} .item-wrapper"
        ));

        // overlay
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "ia_overlay_background",
            'selector'          => "{$this->main_css_element} .difl_imageaccordionitem:before",
            'hover'             => "{$this->main_css_element} .difl_imageaccordionitem:not(.df_ia_active):hover:before"
        ));

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "ia_active_overlay_background",
            'selector'          => "{$this->main_css_element} .difl_imageaccordionitem.df_ia_active:before",
            'hover'             => "{$this->main_css_element} .difl_imageaccordionitem.df_ia_active:hover:before"
        ));
        
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_spacing',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .difl_imageaccordionitem",
            'hover'             => "{$this->main_css_element} .difl_imageaccordionitem:hover",
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .difl_imageaccordionitem",
            'hover'             => "{$this->main_css_element} .difl_imageaccordionitem:hover",
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'first_item_spacing',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .difl_imageaccordionitem:first-child",
            'hover'             => "{$this->main_css_element} .difl_imageaccordionitem:hover:first-child",
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'last_item_spacing',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .difl_imageaccordionitem:last-child",
            'hover'             => "{$this->main_css_element} .difl_imageaccordionitem:hover:last-child",
            'important'         => true
        ));
        
        //content Alignment
        $this->df_process_string_attr( array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_alignment',
            'type'              => 'text-align',
            'selector'          => "%%order_class%% .content",
            'default'           => 'center'
        ));

        // content background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'ia_content_background',
            'selector'          => "{$this->main_css_element} .content",
            'hover'             => "{$this->main_css_element} .content:hover"
        ));

        // Item Icon
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_color',
            'type'              => 'color',
            'selector'          => "%%order_class%% .et-pb-icon.df-image-accordion-icon",
            'hover'             => '%%order_class%% .et-pb-icon.df-image-accordion-icon:hover'
        ));

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_size',
            'type'              => 'font-size',
            'selector'          => "%%order_class%% .et-pb-icon.df-image-accordion-icon",
            'hover'             => '%%order_class%% .et-pb-icon.df-image-accordion-icon:hover',
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_background',
            'selector'          => "%%order_class%% .df-image-accordion-icon",
            'hover'             => '%%order_class%% .df-image-accordion-icon:hover'
        ));
    
        // Icon spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .difl_imageaccordionitem .df-image-accordion-icon",
            'hover'             => "{$this->main_css_element} .difl_imageaccordionitem .df-image-accordion-icon:hover"
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .difl_imageaccordionitem .df-image-accordion-icon",
            'hover'             => "{$this->main_css_element} .difl_imageaccordionitem .df-image-accordion-icon:hover"
        ));
    
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_as_icon_width',
            'type'              => 'width',
            'selector'          => '%%order_class%% img.df-image-accordion-icon',
            'important'         => false
            ) 
        );
        

        // button style
        $this->df_process_btn_styles(array (
            'render_slug'       => $render_slug,
            'slug'              => 'ia_btn',
            'selector'          => "{$this->main_css_element} .df_ia_button",
            'hover'             => "{$this->main_css_element} .df_ia_button:hover",
            'align_container'   => "{$this->main_css_element} .df_ia_button_wrapper"
        ));
        // button background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'ia_btn_background',
            'selector'          => "{$this->main_css_element} .df_ia_button",
            'hover'             => "{$this->main_css_element} .df_ia_button:hover"
        ));

        // content spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ia_title',
            'hover'             => '%%order_class%% .difl_imageaccordionitem:hover .df_ia_title',
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'sub_title_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ia_sub_title',
            'hover'             => '%%order_class%% .difl_imageaccordionitem:hover .df_ia_sub_title',
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'description_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ia_description',
            'hover'             => '%%order_class%% .difl_imageaccordionitem:hover .df_ia_description',
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .content',
            'hover'             => '%%order_class%% .content:hover'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .content',
            'hover'             => '%%order_class%% .content:hover'
        ));

        // Button spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_ia_button_wrapper",
            'hover'             => "{$this->main_css_element} .df_ia_button_wrapper:hover"
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_ia_button",
            'hover'             => "{$this->main_css_element} .df_ia_button:hover",
        ));
        
        if (isset($this->props['vertical_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .overlay_wrapper',
                'declaration' => sprintf('justify-content: %1$s;', $this->props['vertical_align'])
            ));
        }
    
    }

    public function render( $attrs, $content, $render_slug ) {
        wp_enqueue_script('animejs');
        wp_enqueue_script('df-imageaccordion');
        $this->additional_css_styles($render_slug);

        $order_class 	= self::get_module_order_class( $render_slug );
        $order_number	= str_replace('_','',str_replace($this->slug,'', $order_class));
        $active_item = $this->props['active_on_first_time'] ==='on'? $this->props['active_item_order_number'] : '';
        $mobile_accodion_class = $this->props['vertical_at_mobile'] ==='on'? ' vertical_at_mobile': '';
        $data = [
            'accordion_type' => $this->props['accordion_type'],
            'event_type' => $this->props['event_type'],
            'active_on_first_time' => $this->props['active_on_first_time'],
            'active_item' => $active_item,
            'outer_click_close_item' => $this->props['outer_click_close_item'], 
            'order' => $order_number
        ];
        $class = '';
        if (isset($this->props['accordion_type'])) {
            $class .= ' '.$this->props['accordion_type'];
        }
        if($mobile_accodion_class !== ''){
            $class .= $mobile_accodion_class;
        }
        if (isset($this->props['event_type'])) {
            $class .= ' '.$this->props['event_type'];
        }
       
        $animation_data = array (
            'enable_animation'          => $this->props['enable_animation'],
            'content_animation'         => $this->props['content_animation'],
            'duration'                  => $this->props['duration'],
            'delay'                     => $this->props['delay'],
            'animation_function'        => $this->props['animation_function'],
            'module_class'              => $order_class,
            'enable_stagger'            => $this->props['enable_stagger'],
            'stagger'                   => $this->props['stagger']
        );
        
        return sprintf('<div class="df_ia_container" data-settings=\'%2$s\' data-animation=\'%4$s\'>
            <div class="df_ia_inner_wrapper">
                <div class="item-container">
                    <div class="item-wrapper %3$s">
                        %1$s
                    </div>
                </div>
            </div>
        </div>',
        et_core_sanitized_previously( $this->content ),
        wp_json_encode($data),
        $class,
        wp_json_encode($animation_data)
        );
    }
}
new DIFL_ImageAccordion;