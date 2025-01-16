<?php

class DIFL_Heading_Anim extends ET_Builder_Module {

	public $slug       = 'dfadh_heading_anim';
    public $vb_support = 'on';
	public $icon_path;
    use DF_UTLS;

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
	);

	public function init() {
        $this->name = esc_html__( 'Animated Heading', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/animated-heading.svg';
	}
    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'content'           => esc_html__( 'Content', 'divi_flash' ),
                    'anim_settings'     => esc_html__('Settings', 'divi_flash'),
                    'prefix_background' => esc_html__( 'Prefix Background', 'divi_flash' ),
                    'infix_background' => esc_html__( 'Fancy-text Background', 'divi_flash' ),
                    'suffix_background' => esc_html__( 'Suffix Background', 'divi_flash' )
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'title'             => esc_html__('Title', 'divi_flash'),
                    'prefix'            => esc_html__('Prefix', 'divi_flash'),
                    'infix'             => esc_html__('Fancy-text', 'divi_flash'),
                    'suffix'            => esc_html__('Suffix', 'divi_flash'),
                    // 'second_button_style'   => esc_html__('Second Button Style', 'divi_flash'),
                    'border'                => esc_html__('Border', 'divi_flash'),
                    'custom_borders'        => esc_html__('Custom border', 'divi_flash'),
                    'custom_spacing'        => esc_html__('Custom Spacing', 'divi_flash')
                )
            ),
        );
    }
    public function get_advanced_fields_config() {
        $advanced_fields = array();
        $advanced_fields['fonts'] = array(
            'title'   => array(
				'label'         => esc_html__( 'Title', 'divi_flash' ),
				'toggle_slug'   => 'title',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array(
						'default' => '1em',
					),
					'font_size' => array(
						'default' => '24',
					),
				'css'      => array(
                    'main' => "{$this->main_css_element} h1 span,
                                {$this->main_css_element} h2 span,
                                {$this->main_css_element} h3 span,
                                {$this->main_css_element} h4 span,
                                {$this->main_css_element} h5 span,
                                {$this->main_css_element} h6 span",
                    'text_align'=> "{$this->main_css_element} h1,
                                {$this->main_css_element} h2,
                                {$this->main_css_element} h3,
                                {$this->main_css_element} h4,
                                {$this->main_css_element} h5,
                                {$this->main_css_element} h6",
                    'hover' => "{$this->main_css_element}:hover h1 span,
                                {$this->main_css_element}:hover h2 span,
                                {$this->main_css_element}:hover h3 span,
                                {$this->main_css_element}:hover h4 span,
                                {$this->main_css_element}:hover h5 span,
                                {$this->main_css_element}:hover h6 span",
					'important' => 'all',
                ),
                'header_level' => array(
                    'default' => 'h4',
                ),
			),
            't_prefix'   => array(
				'label'         => esc_html__( 'Prefix', 'divi_flash' ),
				'toggle_slug'   => 'prefix',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
				'css'      => array(
                    'main' => "{$this->main_css_element} span.prefix",
                    'hover' => "{$this->main_css_element}:hover span.prefix",
					'important' => 'all',
                )
            ),
            't_infix'   => array(
				'label'         => esc_html__( 'Fancy-text', 'divi_flash' ),
				'toggle_slug'   => 'infix',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_letter_spacing' => true,
				'css'      => array(
                    'main' => "{$this->main_css_element} span.infix",
                    'hover' => "{$this->main_css_element}:hover span.infix",
					'important' => 'all',
                )
			),
            't_suffix'   => array(
				'label'         => esc_html__( 'Suffix', 'divi_flash' ),
				'toggle_slug'   => 'suffix',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
				'css'      => array(
                    'main' => "{$this->main_css_element} span.suffix",
                    'hover' => "{$this->main_css_element}:hover span.suffix",
					'important' => 'all',
                )
			),
        );
        $advanced_fields['borders'] = array(
            'default'               => array(),
            'prefix_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} span.prefix",
                        'border_styles' => "{$this->main_css_element} span.prefix",
                        'border_styles_hover' => "{$this->main_css_element}:hover span.prefix",
                    )
                ),
                'label_prefix'    => esc_html__( 'Prefix', 'divi_flash' ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'custom_borders',	
            ),
            'infix_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} span.infix",
                        'border_styles' => "{$this->main_css_element} span.infix",
                        'border_styles_hover' => "{$this->main_css_element}:hover span.infix",
                    )
                ),
                'label_prefix'    => esc_html__( 'Fancy-text', 'divi_flash' ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'custom_borders',	
            ),
            'suffix_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} span.suffix",
                        'border_styles' => "{$this->main_css_element} span.suffix",
                        'border_styles_hover' => "{$this->main_css_element}:hover span.suffix",
                    )
                ),
                'label_prefix'    => esc_html__( 'Suffix', 'divi_flash' ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'custom_borders',	
            )

        );
        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'important' => 'all'
            )
        ); 
        $advanced_fields['text'] = false;     
        $advanced_fields['filters'] = false;
        $advanced_fields['transform'] = false;
        $advanced_fields['animation'] = false;
        // $advanced_fields['link_options'] = false;
        return $advanced_fields;
    }
	public function get_fields() {
        $heading = array(
            'fancy_text_anim'   => array(
                'label'         => esc_html__( 'Fancy Text Animation', 'divi_flash' ),
                'type'          => 'select',
                'options'       => array(
                    'type-word-rotate'         => 'Word Rotate',
                    'type-word-slide-top'      => 'Word Slide Top',
                    'type-word-slide-left'     => 'Word Slide Left',
                    'type-word-scale'          => 'Word Scale',
                    // 'type-word-clip'           => 'Word Clip',
                    'type-letter-flip'         => 'Letter Flip',
                    'type-letter-scale'        => 'Letter Scale',
                    'type-letter-wave'         => 'Letter Wave',
                    'type-letter-stand'        => 'Letter Stand',
                    'type-letter-slide'        => 'Letter Slide'
                ),
                'toggle_slug'     => 'content',
                'default'         => 'type-word-rotate'
            ),
            'title_prefix' => array(
				'label'           => esc_html__( 'Title Prefix', 'divi_flash' ),
				'type'            => 'text',
                'toggle_slug'     => 'content',
                'dynamic_content' =>'text'
            ),
            'fency_text_list' => array(
				'label'           => esc_html__( 'Fancy Text List', 'divi_flash' ),
				'type'            => 'options_list',
                'toggle_slug'     => 'content'
			),
            'title_suffix' => array(
				'label'           => esc_html__( 'Title Suffix', 'divi_flash' ),
				'type'            => 'text',
				'toggle_slug'     => 'content',
                'dynamic_content' =>'text'
            ),
            'fancy_text_overflow'   => array(
                'label'         => esc_html__( 'Overflow', 'divi_flash' ),
                'type'          => 'select',
                'options'       => array(
                    'visible'       => 'Visible',
                    'hidden'        => 'Hidden'
                ),
                'toggle_slug'       => 'infix',
                'tab_slug'          => 'advanced',
                'default'           => 'visible'
            )
        );
        $settings = array (
            'easing' => array(
                'label'         => esc_html__('Easing', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array(
                    'off'   => __('Off', 'divi_flash'),
                    'on'   => __('On', 'divi_flash')
                ),
                'default'       => 'off',
                'toggle_slug'   => 'anim_settings'
            ),
            'anim_duration' => array(
                'label'         => esc_html__('Animation Duration', 'divi_flash'),
                'type'          => 'range',
                'range_settings'    => array(
					'min'  => '1',
					'max'  => '3000',
					'step' => '1',
				),
                'default'       => '1000',
                'default_unit'  => 'ms',
                'description'   => esc_html__('Duration for each animation', 'divi_flash'),
                'toggle_slug'   => 'anim_settings',
                'show_if'       => array(
                    'easing'    => 'on'
                )
            ),
            'anim_delay' => array(
                'label'         => esc_html__('Animation Delay', 'divi_flash'),
                'type'          => 'range',
                'range_settings'    => array(
					'min'  => '1',
					'max'  => '3000',
					'step' => '1',
                ),
                'default_unit'  => 'ms',
                'default'       => '500',
                'description'   => esc_html__('Delay between each animation', 'divi_flash'),
                'toggle_slug'   => 'anim_settings',
                'show_if'       => array(
                    'easing'    => 'on'
                )
            ),
            'anim_easing'   => array(
                'label'     => esc_html__('Easing', 'divi_flash'),
                'type'      => 'select',
                'options'   => array(
                    'easeInBack' => esc_html__('Default', 'divi_flash'),
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
                'default'       => 'easeInBack',
                'toggle_slug'   => 'anim_settings',
                'show_if'       => array(
                    'easing'    => 'on'
                )
            ),
            'spring_anim_mass' => array(
                'label'         => esc_html__('Spring Animation Mass', 'divi_flash'),
                'type'          => 'range',
                'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
                ),
                'default_unit'  => '',
                'default'       => '1',
                'toggle_slug'   => 'anim_settings',
                'show_if_not'   => array(
                    'easing'    => 'on'
                )
            ),
            'spring_anim_stiffness' => array(
                'label'         => esc_html__('Spring Animation Stiffness', 'divi_flash'),
                'type'          => 'range',
                'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
                ),
                'default_unit'  => '',
                'default'       => '80',
                'toggle_slug'   => 'anim_settings',
                'show_if_not'   => array(
                    'easing'    => 'on'
                )
            ),
            'spring_anim_damping' => array(
                'label'         => esc_html__('Spring Animation Damping', 'divi_flash'),
                'type'          => 'range',
                'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
                ),
                'default_unit'  => '',
                'default'       => '10',
                'toggle_slug'   => 'anim_settings',
                'show_if_not'   => array(
                    'easing'    => 'on'
                )
            ),
            'spring_anim_velocity' => array(
                'label'         => esc_html__('Spring Animation Velocity', 'divi_flash'),
                'type'          => 'range',
                'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
                ),
                'default_unit'  => '',
                'default'       => '0',
                'toggle_slug'   => 'anim_settings',
                'show_if_not'   => array(
                    'easing'    => 'on'
                )
            )
                
        );
        $block_element = array(
            'title_prefix_block'       => array(
                'label'             => esc_html__( 'Display Element', 'divi_flash' ),
				'type'              => 'select',
                'options'           => array(
					'inline-block' => esc_html__( 'Default', 'divi_flash' ),
					'block'  => esc_html__( 'Block', 'divi_flash' ),
					'inline'  => esc_html__( 'Inline', 'divi_flash' ),
                ),
                'default'           => 'inline-block',
                'default_on_front'  => 'inline-block',
                'toggle_slug'       => 'prefix',
                'tab_slug'          => 'advanced',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'title_infix_block'       => array(
                'label'             => esc_html__( 'Display Block', 'divi_flash' ),
				'type'              => 'select',
                'options'           => array(
					'inline-block' => esc_html__( 'Default', 'divi_flash' ),
					'block'  => esc_html__( 'Block', 'divi_flash' ),
					'inline'  => esc_html__( 'Inline', 'divi_flash' ),
                ),
                'default'           => 'inline-block',
                'default_on_front'  => 'inline-block',
                'toggle_slug'       => 'infix',
                'tab_slug'          => 'advanced',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'title_suffix_block'       => array(
                'label'             => esc_html__( 'Display Block', 'divi_flash' ),
				'type'              => 'select',
                'options'           => array(
					'inline-block' => esc_html__( 'Default', 'divi_flash' ),
					'block'  => esc_html__( 'Block', 'divi_flash' ),
					'inline'  => esc_html__( 'Inline', 'divi_flash' ),
                ),
                'default'           => 'inline-block',
                'default_on_front'  => 'inline-block',
                'toggle_slug'       => 'suffix',
                'tab_slug'          => 'advanced',
                'responsive'        => true,
                'mobile_options'    => true
            )
        );
        $prefix_max_width  = $this->df_add_max_width(
            array(
                'title_pefix'   => 'Prefix',
                'key'           => 'prefix',
                'toggle_slug'   => 'prefix',
                'sub_toggle'    => null,
                'alignment'     => true,
                'priority'      => 30,
                'tab_slug'      => 'advanced',
                'show_if'    => array(
                    'title_prefix_block' => 'block'
                )
            )
        );
        $infix_max_width  = $this->df_add_max_width(
            array(
                'title_pefix'   => 'Infix',
                'key'           => 'infix',
                'toggle_slug'   => 'infix',
                'sub_toggle'    => null,
                'alignment'     => true,
                'priority'      => 30,
                'tab_slug'      => 'advanced',
                'show_if'    => array(
                    'title_infix_block' => 'block'
                )
            )
        );
        $suffix_max_width  = $this->df_add_max_width(
            array(
                'title_pefix'   => 'Suffix',
                'key'           => 'suffix',
                'toggle_slug'   => 'suffix',
                'sub_toggle'    => null,
                'alignment'     => true,
                'priority'      => 30,
                'tab_slug'      => 'advanced',
                'show_if'    => array(
                    'title_suffix_block' => 'block'
                )
            )
        );
        $heading_spacing = $this->add_margin_padding(array(
            'title'             => 'Heading',
            'key'               => 'heading',
            'toggle_slug'       => 'margin_padding'
        ));
        $prefix_spacing = $this->add_margin_padding(array(
            'title'             => 'Prefix',
            'key'               => 'prefix',
            'toggle_slug'       => 'margin_padding'
        ));
        $infix_spacing = $this->add_margin_padding(array(
            'title'             => 'Fancy-text',
            'key'               => 'infix',
            'toggle_slug'       => 'margin_padding'
        ));
        $suffix_spacing = $this->add_margin_padding(array(
            'title'             => 'Suffix',
            'key'               => 'suffix',
            'toggle_slug'       => 'margin_padding'
        ));
        $prefix_background = $this->df_add_bg_field(array(
            'label'             => 'Prefix Background',
            'key'               => 'prefix_background',
            'toggle_slug'       => 'prefix_background',
            'tab_slug'          => 'general'
        ));
        $infix_background = $this->df_add_bg_field(array(
            'label'             => 'Fancy-text Background',
            'key'               => 'infix_background',
            'toggle_slug'       => 'infix_background',
            'tab_slug'          => 'general'
        ));
        $suffix_background = $this->df_add_bg_field(array(
            'label'             => 'Suffix Background',
            'key'               => 'suffix_background',
            'toggle_slug'       => 'suffix_background',
            'tab_slug'          => 'general'
        ));
        return array_merge(
            $heading, 
            $settings, 
            $block_element,
            $prefix_max_width,
            $infix_max_width,
            $suffix_max_width,
            $heading_spacing,
            $prefix_spacing,
            $infix_spacing,
            $suffix_spacing,
            $prefix_background,
            $infix_background,
            $suffix_background
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $heading = '%%order_class%% .headline-animation';
        $prefix = '%%order_class%% .headline-animation .prefix';
        $infix = '%%order_class%% .headline-animation .infix';
        $suffix = '%%order_class%% .headline-animation .suffix';

		$fields['heading_margin']                       = array( 'margin' => $heading );
		$fields['heading_padding']                      = array( 'padding' => $heading );
		$fields['prefix_margin']                        = array( 'margin' => $prefix );
		$fields['prefix_padding']                       = array( 'padding' => $prefix );
		$fields['infix_margin']                         = array( 'margin' => $infix );
		$fields['infix_padding']                        = array( 'padding' => $infix );
		$fields['suffix_margin']                        = array( 'margin' => $suffix );
		$fields['suffix_padding']                       = array( 'padding' => $suffix );
		$fields['prefix_background_bgcolor']            = array( 'background' => $prefix );
		$fields['prefix_background_use_gradient']       = array( 'background' => $prefix );
		$fields['infix_background_bgcolor']             = array( 'background' => $infix );
		$fields['infix_background_use_gradient']        = array( 'background' => $infix );
		$fields['suffix_background_bgcolor']            = array( 'background' => $suffix );
        $fields['suffix_background_use_gradient']       = array( 'background' => $suffix );
        
        //max-width
        $fields['prefix_maxwidth']          = array( 'max-width' => $prefix );
        $fields['infix_maxwidth']           = array( 'max-width' => $infix );
        $fields['suffix_maxwidth']          = array( 'max-width' => $suffix );
        //border prefix
        $fields['border_width_all_prefix_border']        = array( 'border-width' => $prefix, 'border-color' => $prefix );
        $fields['border_width_top_prefix_border']        = array( 'border-width' => $prefix, 'border-color' => $prefix );
        $fields['border_width_bottom_prefix_border']        = array( 'border-width' => $prefix, 'border-color' => $prefix );
        $fields['border_width_left_prefix_border']        = array( 'border-width' => $prefix, 'border-color' => $prefix );
        $fields['border_width_right_prefix_border']        = array( 'border-width' => $prefix, 'border-color' => $prefix );
        $fields['border_radii_prefix_border']        = array( 'border-radius' => $prefix );
        //border infix
        $fields['border_width_all_infix_border']        = array( 'border-width' => $infix, 'border-color' => $infix );
        $fields['border_width_top_infix_border']        = array( 'border-width' => $infix, 'border-color' => $infix );
        $fields['border_width_bottom_infix_border']        = array( 'border-width' => $infix, 'border-color' => $infix );
        $fields['border_width_left_infix_border']        = array( 'border-width' => $infix, 'border-color' => $infix );
        $fields['border_width_right_infix_border']        = array( 'border-width' => $infix, 'border-color' => $infix );
        $fields['border_radii_infix_border']        = array( 'border-radius' => $infix );
        //border suffix
        $fields['border_width_all_suffix_border']        = array( 'border-width' => $suffix, 'border-color' => $suffix );
        $fields['border_width_top_suffix_border']        = array( 'border-width' => $suffix, 'border-color' => $suffix );
        $fields['border_width_bottom_suffix_border']        = array( 'border-width' => $suffix, 'border-color' => $suffix );
        $fields['border_width_left_suffix_border']        = array( 'border-width' => $suffix, 'border-color' => $suffix );
        $fields['border_width_right_suffix_border']        = array( 'border-width' => $suffix, 'border-color' => $suffix );
        $fields['border_radii_suffix_border']        = array( 'border-radius' => $suffix );
        
		return $fields;
	}
    
    public function additional_css_styles($render_slug) {

        $alignment = array(
            'left' => 'flex-start',
            'center'   => 'center',
            'right'=> 'flex-end',
            'justified'=> 'space-between'
        );

        // Display Element
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_prefix_block',
            'type'              => 'display',
            'selector'          => '%%order_class%% .headline-animation .prefix',
            'hover'             => '%%order_class%%:hover .headline-animation .prefix',
            'default'           => 'inline-block'
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_infix_block',
            'type'              => 'display',
            'selector'          => '%%order_class%% .headline-animation .infix',
            'hover'             => '%%order_class%%:hover .headline-animation .infix',
            'default'           => 'inline-block'
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_suffix_block',
            'type'              => 'display',
            'selector'          => '%%order_class%% .headline-animation .suffix',
            'hover'             => '%%order_class%%:hover .headline-animation .suffix',
            'default'           => 'inline-block'
        ));
        
        // process max-width and alignment
        $this->df_process_maxwidth(array(
            'render_slug'       => $render_slug,
            'slug'              => 'prefix',
            'selector'          => '%%order_class%% .headline-animation .prefix',
            'hover'             => '%%order_class%%:hover .headline-animation .prefix',
            'alignment'         => true,
            'important'         => true
        ));
        $this->df_process_maxwidth(array(
            'render_slug'       => $render_slug,
            'slug'              => 'infix',
            'selector'          => '%%order_class%% .headline-animation .infix',
            'hover'             => '%%order_class%%:hover .headline-animation .infix',
            'alignment'         => true,
            'important'         => true
        ));
        $this->df_process_maxwidth(array(
            'render_slug'       => $render_slug,
            'slug'              => 'suffix',
            'selector'          => '%%order_class%% .headline-animation .suffix',
            'hover'             => '%%order_class%%:hover .headline-animation .suffix',
            'alignment'         => true,
            'important'         => true
        ));
        // heading spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'heading_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .headline-animation',
            'hover'             => '%%order_class%%:hover .headline-animation',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'heading_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .headline-animation',
            'hover'             => '%%order_class%%:hover .headline-animation',
            'important'         => true
        ));
        // prefix spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'prefix_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .headline-animation .prefix',
            'hover'             => '%%order_class%%:hover .headline-animation .prefix',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'prefix_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .headline-animation .prefix',
            'hover'             => '%%order_class%%:hover .headline-animation .prefix',
            'important'         => true
        ));
        // infix spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'infix_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .headline-animation .infix',
            'hover'             => '%%order_class%%:hover .headline-animation .infix',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'infix_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .headline-animation .infix',
            'hover'             => '%%order_class%%:hover .headline-animation .infix',
            'important'         => true
        ));
        // suffix spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'suffix_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .headline-animation .suffix',
            'hover'             => '%%order_class%%:hover .headline-animation .suffix',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'suffix_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .headline-animation .suffix',
            'hover'             => '%%order_class%%:hover .headline-animation .suffix',
            'important'         => true
        ));
        // background
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'prefix_background',
            'selector'          => '%%order_class%% .headline-animation .prefix',
            'hover'             => '%%order_class%%:hover .headline-animation .prefix'
        ));
        
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'suffix_background',
            'selector'          => '%%order_class%% .headline-animation .suffix',
            'hover'             => '%%order_class%%:hover .headline-animation .suffix'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'infix_background',
            'selector'          => '%%order_class%% .headline-animation .infix',
            'hover'             => '%%order_class%%:hover .headline-animation:hover .infix'
        ));
        // fancy text overflow
        if ( $this->props['fancy_text_overflow'] !== '') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .headline-animation .infix',
                'declaration' => sprintf('overflow: %1$s;', $this->props['fancy_text_overflow'])
            ));
        }
    }
    public function get_custom_css_fields_config() {
        $custom_css = array();


        return $custom_css;
    }

    public function wrapChar ($word, $key) {
        $anim_type = strpos($this->props['fancy_text_anim'], 'letter');
        $newWord = '';
        if ( $anim_type == true ) {
            $len = mb_strlen($word, 'UTF-8');
            if ( $len > 0 ) {
                for ($i = 0; $i < $len; $i++) {
                    $ch = mb_substr($word, $i, 1, 'UTF-8');
                    if ( $ch !== ' ') {
                        if ( $key === 0 ) {
                            $newWord .= sprintf('<span class="in">%1$s</span>', $ch);
                        } else {
                            $newWord .= sprintf('<span class="out">%1$s</span>', $ch);
                        }
                    } else {
                        $newWord .= ' ';
                    }
                }
            } 
        } else {
            $newWord = $word;
        }
        return $newWord;
    }

    public function fancy_text() {
        $option_search  = array( '&#91;', '&#93;' );
		$option_replace = array( '[', ']' );
        $lists = str_replace( $option_search, $option_replace, $this->props['fency_text_list'] );
        $lists = json_decode( $lists );
        $fancy_text = '<span class="infix words-wrapper">';
        foreach ($lists as $key => $list) {
            $word = $this->wrapChar($list->value, $key);
            if ( $key === 0 ) {
                $fancy_text .= '<span class="is-visible">' . $word . '</span>';
            } else {
                $fancy_text .= '<span class="is-hidden">' . $word . '</span>';
            }
        }
        $fancy_text .= '</span>';
        return $fancy_text;
    }

    public function fancy_text_class() {
        $animation_type = array(
            'type-word-rotate'          => 'word type-word-rotate',
            'type-word-slide-top'       => 'word type-word-slide-top',
            'type-word-slide-left'      => 'word type-word-slide-left',
            'type-word-scale'           => 'word type-word-scale',
            'type-letter-flip'          => 'letter type-letter-flip',
            'type-letter-scale'         => 'letter type-letter-scale',
            'type-letter-wave'          => 'letter type-letter-wave',
            'type-letter-stand'         => 'letter type-letter-stand',
            'type-letter-slide'         => 'letter type-letter-slide'
        );
        return sprintf('headline-animation %1$s', $animation_type[$this->props['fancy_text_anim']]);
    }

	public function render( $attrs, $content, $render_slug ) {

        wp_enqueue_script('animejs');
        wp_enqueue_script('headline-scripts');
        
        $animation_type = array(
            'type-word-rotate'          => 'word',
            'type-word-slide-top'       => 'word',
            'type-word-slide-left'      => 'word',
            'type-word-scale'           => 'word',
            'type-letter-flip'          => 'letter',
            'type-letter-scale'         => 'letter',
            'type-letter-wave'          => 'letter',
            'type-letter-stand'         => 'letter',
            'type-letter-slide'         => 'letter'
        );
        $title_level  = $this->props['title_level'];
        $title_prefix = !empty($this->props['title_prefix']) ? 
            sprintf('<span class="prefix">%1$s</span>',$this->props['title_prefix']) : '';
        $title_suffix = !empty($this->props['title_suffix']) ? 
            sprintf('<span class="suffix">%1$s</span>',$this->props['title_suffix']) : '';
        $title_infix = $this->fancy_text();

        

        $title = sprintf('%1$s %2$s %3$s', $title_prefix, $title_infix, $title_suffix);

        $this->additional_css_styles($render_slug);

        $data_attr = array(
            'transition_type'           => $animation_type[$this->props['fancy_text_anim']],
            'animation_type'            => $this->props['fancy_text_anim'],
            'delay'                     => intval($this->props['anim_delay']),
            'duration'                  => intval($this->props['anim_duration']),
            'easing'                    => $this->props['easing'] === 'on' ? $this->props['anim_easing'] : 'none',
            'mass'                      => intval($this->props['spring_anim_mass']),
            'stiffness'                 => intval($this->props['spring_anim_stiffness']),
            'damping'                   => intval($this->props['spring_anim_damping']),
            'velocity'                  => intval($this->props['spring_anim_velocity'])
        );

        return sprintf( '<div class="df-anim-heading-container">
                <%2$s class="%3$s" data-anmi=\'%4$s\' >%1$s</%2$s>
            </div>', 
            $title,
            et_pb_process_header_level( $title_level, 'h4' ),
            $this->fancy_text_class(),
            wp_json_encode($data_attr)
        );
	}
}


new DIFL_Heading_Anim;