<?php

class DIFL_WPForms extends ET_Builder_Module {
    public $slug       = 'difl_wpforms';
    public $vb_support = 'on';
	public $icon_path, $main_element;
    use DF_UTLS;
    
    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
	);

	public function init() {
		$this->name = esc_html__( 'WPForms Styler', 'divi_flash' );
		$this->main_element = '%%order_class%%';
		$this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/wp-form.svg';
	}

	public function get_settings_modal_toggles(){
		return array(
			'general'  => array(
					'toggles' => array(
							'main_content' 					=> esc_html__( 'Content', 'divi_flash' ),
							'elements' 						=> esc_html__( 'Elements', 'divi_flash' ),
							'input_background'				=> esc_html__( 'Input & Textarea Background', 'divi_flash' ),
							'submit_background'				=> esc_html__( 'Button Background', 'divi_flash' )
					),
			),
			'advanced'  =>  array(
					'toggles'   =>  array(
							'label'				=> esc_html__('Label Text', 'divi_flash'),
							'sub_label'			=> esc_html__('Sub Label Text', 'divi_flash'),
							'description'		=> esc_html__('Description Text', 'divi_flash'),
							'input'				=> esc_html__('Input & Textarea Text', 'divi_flash'),
							'radio'				=> esc_html__('Checkbox & Radio Text', 'divi_flash'),
							'dropdown'			=> esc_html__('Dropdown', 'divi_flash'),
							'submit'			=> esc_html__('Submit Button', 'divi_flash'),
							'input_border'		=> esc_html__('Input & Textarea Border', 'divi_flash')
					)
			)
			
		);
	}

	public function get_advanced_fields_config() {
		$advanced_fields = array();

		$advanced_fields['text'] = false;

		// font styles
		$advanced_fields['fonts'] = array(
			'label'		=> array(
				'label'         => esc_html__( 'Label Text', 'divi_flash' ),
				'toggle_slug'   => 'label',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array (
					'default' => '1em',
				),
				'font_size' => array(
					'default' => '16px',
				),
				'css'      => array(
					'main' => "%%order_class%% label.wpforms-field-label , %%order_class%% legend.wpforms-field-label",
					'hover' => "%%order_class%% label.wpforms-field-label:hover , %%order_class%% legend.wpforms-field-label:hover",
					'important'	=> 'all'
				),
			),
			'sub_label' 	=> array(
				'label'         => esc_html__( 'Sub Label Text', 'divi_flash' ),
				'toggle_slug'   => 'sub_label',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array (
					'default' => '1em',
				),
				'font_size' => array(
					'default' => '16px',
				),
				'css'      => array(
					'main' => "%%order_class%% label.wpforms-field-sublabel",
					'hover' => "%%order_class%% label.wpforms-field-sublabel:hover",
					'important'	=> 'all'
				),
			),
			'description' 	=> array(
				'label'         => esc_html__( 'Description Text', 'divi_flash' ),
				'toggle_slug'   => 'description',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array (
					'default' => '1em',
				),
				'font_size' => array(
					'default' => '14px',
				),
				'css'      => array(
					'main' => "%%order_class%% .wpforms-field-description",
					'hover' => "%%order_class%% .wpforms-field-description:hover",
					'important'	=> 'all'
				),
			),
			'input_text' 	=> array(
				'label'         => esc_html__( 'Input & Textarea', 'divi_flash' ),
				'toggle_slug'   => 'input',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array (
					'default' => '1em',
				),
				'font_size' => array(
					'default' => '14px',
				),
				'css'      => array(
					'main' => '%%order_class%% input[type="text"],
								%%order_class%% input[type="text"]::placeholder,
								%%order_class%% input[type="email"],
								%%order_class%% input[type="email"]::placeholder,
								%%order_class%% input[type="number"],
								%%order_class%% input[type="number"]::placeholder,
								%%order_class%% input[type="tel"],
								%%order_class%% input[type="tel"]::placeholder,
								%%order_class%% input[type="password"],
								%%order_class%% input[type="password"]::placeholder,
								%%order_class%% textarea,
								%%order_class%% textarea::placeholder',
					'hover' => '%%order_class%% input[type="text"]:hover,
								%%order_class%% input[type="email"]:hover,
								%%order_class%% input[type="number"]:hover,
								%%order_class%% input[type="tel"]:hover,
								%%order_class%% input[type="password"]:hover,
								%%order_class%% textarea:hover',
					'important'	=> 'all'
				),
			),
			'radio_text' 	=> array(
				'label'         => esc_html__( 'Checkbox & Radio', 'divi_flash' ),
				'toggle_slug'   => 'radio',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array (
					'default' => '1em',
				),
				'font_size' => array(
					'default' => '14px',
				),
				'css'      => array(
					'main' => '%%order_class%% label.wpforms-field-label-inline',
					'hover' => '%%order_class%% label.wpforms-field-label-inline:hover',
					'important'	=> 'all'
				),
			),
			'dropdown' 	=> array(
				'label'         => esc_html__( 'Dropdown', 'divi_flash' ),
				'toggle_slug'   => 'dropdown',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array (
					'default' => '1em',
				),
				'font_size' => array(
					'default' => '14px',
				),
				'css'      => array(
					'main' => '%%order_class%% .wpforms-form .wpforms-field-container select,
								%%order_class%% .wpforms-form .choices__inner',
					'hover' => '%%order_class%% .wpforms-form .wpforms-field-container select:hover',
					'important'	=> 'all'
				),
			),
			'submit'	=> array(
				'label'         => esc_html__( 'Submit Button', 'divi_flash' ),
				'toggle_slug'   => 'submit',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'hide_text_align' => true,
				'line_height' => array (
					'default' => '1em',
				),
				'font_size' => array(
					'default' => '16px',
				),
				'css'      => array(
					'main' => '%%order_class%% [type="submit"]',
					'hover' => '%%order_class%% [type="submit"]:hover',
					// 'main' => '%%order_class%% .wpforms-container .wpforms-submit-container [type="submit"]',
					// 'hover' => '%%order_class%% .wpforms-container .wpforms-submit-container [type="submit"]:hover',
					'important'	=> 'all'
				),
			)
		);

		// border styles
		$advanced_fields['borders'] = array(
			'default'	=> false,
			'input'		=> array(
				'css'             => array(
					'main' => array(
						'border_radii' => "{$this->main_element} .wpforms-container .wpforms-form input[type=\"text\"],
							{$this->main_element} .wpforms-container .wpforms-form input[type=\"email\"],
							{$this->main_element} .wpforms-container .wpforms-form input[type=\"number\"],
							{$this->main_element} .wpforms-container .wpforms-form input[type=\"tel\"],
							{$this->main_element} .wpforms-container .wpforms-form input[type=\"password\"],
							{$this->main_element} .wpforms-container .wpforms-form textarea,
							{$this->main_element} .wpforms-container .wpforms-form textarea:focus",
						'border_styles' => "{$this->main_element} .wpforms-container .wpforms-form input[type=\"text\"],
							{$this->main_element} .wpforms-container .wpforms-form input[type=\"email\"],
							{$this->main_element} .wpforms-container .wpforms-form input[type=\"number\"],
							{$this->main_element} .wpforms-container .wpforms-form input[type=\"tel\"],
							{$this->main_element} .wpforms-container .wpforms-form input[type=\"password\"],
							{$this->main_element} .wpforms-container .wpforms-form textarea,
							{$this->main_element} .wpforms-container .wpforms-form textarea:focus",
						'border_styles_hover' => "{$this->main_element} .wpforms-container .wpforms-form input[type=\"text\"]:hover,
							{$this->main_element} .wpforms-container .wpforms-form input[type=\"email\"]:hover,
							{$this->main_element} .wpforms-container .wpforms-form input[type=\"number\"]:hover,
							{$this->main_element} .wpforms-container .wpforms-form input[type=\"tel\"]:hover,
							{$this->main_element} .wpforms-container .wpforms-form input[type=\"password\"]:hover,
							{$this->main_element} .wpforms-container .wpforms-form textarea:hover",
					),
					'important' => 'all'
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'input_border',
			),
			'submit'	=> array(
				'css'             => array(
					'main' => array(
						'border_radii' => "{$this->main_element} .wpforms-container .wpforms-form [type=\"submit\"]",
						'border_styles' => "{$this->main_element} .wpforms-container .wpforms-form [type=\"submit\"]",
						'border_styles_hover' => "{$this->main_element} .wpforms-container .wpforms-form [type=\"submit\"]:hover",
					),
					'important' => 'all'
				),
				'defaults' => array(
					'border_styles' => [
						 'width'     => "0px"
					],
			  ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'submit',
			),
			'dropdown'	=> array(
				'css'             => array(
					'main' => array(
						'border_radii' => "%%order_class%% .wpforms-form .wpforms-field-container select, 
											%%order_class%% .wpforms-form .wpforms-field-container select:focus,
											%%order_class%% .wpforms-form .choices__inner",
						'border_styles' => "%%order_class%% .wpforms-form .wpforms-field-container select, %%order_class%% .wpforms-form .wpforms-field-container select:focus",
						'border_styles_hover' => "%%order_class%% .wpforms-form .wpforms-field-container select:hover, %%order_class%% .wpforms-form .wpforms-field-container select:hover:focus",
					),
					'important' => 'all'
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dropdown',
			)
		);
		
		// $advanced_fields['max_width'] = false;
		$advanced_fields['box_shadow'] = false;
		// $advanced_fields['margin_padding'] = false;
		$advanced_fields['transform'] = false;
		$advanced_fields['filters'] = false;
		$advanced_fields['link_options'] = false;
		$advanced_fields['animation'] = false;
		return $advanced_fields;
	}

	public function get_fields() {

		$checkbox_radio_color = [
			'checkbox_radio_color'     => array(
				'label'           => esc_html__('Checkbox & Radio active color', 'divi_flash'),
				'type'            => 'color-alpha',
				'description'     => esc_html__('Here you can define a custom active color for checkbox & radio.', 'divi_flash'),
				'toggle_slug'     => 'radio',
				'tab_slug'        => 'advanced',
		  ),
		];
		$settings = array(
			'wpforms' => array(
				'label'           	=> esc_html__( 'WPForms', 'divi_flash' ),
				'type'            	=> 'select',
				'options'			=> $this->get_all_wpforms(),
				'option_category' 	=> 'basic_option',
				'default'			=> 'default',
				'description'     	=> esc_html__( 'Select the wpforms form you want to use.', 'divi_flash' ),
				'toggle_slug'     	=> 'main_content',
			),
			'dorpdown_height'       => array (
                'label'             => esc_html__( 'Dropdown Height', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'dropdown',
				'tab_slug'       	=> 'advanced',
				'default'           => '38px',
                'default_unit'      => 'px',
                'allowed_units'     => array ('px'),
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
                )
			),
			'submit_align'    => array (
                'label'             => esc_html__('Alignment', 'divi_flash'),
                'type'              => 'text_align',
                'options'           => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'       => 'submit',
                'tab_slug'          => 'advanced',
					 'responsive'         => true,
                'mobile_options'    => true
            )
		);
		$input_background = $this->df_add_bg_field(array(
			'label'				=> 'Input & textarea Background',
            'key'               => 'input_bg',
            'toggle_slug'       => 'input_background',
            'tab_slug'			=> 'general'
		));
		$submit_background = $this->df_add_bg_field(array(
			'label'				=> 'Button Background',
            'key'               => 'submit_bg',
            'toggle_slug'       => 'submit_background',
            'tab_slug'			=> 'general'
		));
		$label_spacing = $this->add_margin_padding(array(
            'title'             => 'Label',
            'key'               => 'label',
            'toggle_slug'       => 'margin_padding',
				// 'default_margin'  => '15px|0px|15px|0px',
        ));
		$input_spacing = $this->add_margin_padding(array(
            'title'             => 'Input',
            'key'               => 'input',
            'toggle_slug'       => 'margin_padding',
				// 'default_margin'  => '0px|0px|15px|0px',
        ));

		$radio_spacing = $this->add_margin_padding(array(
			'title'             => 'Radio',
			'key'               => 'radio',
			'toggle_slug'       => 'margin_padding',
			// 'default_margin'  => '15px|0px|15px|0px',
		));

		$checkbox_spacing = $this->add_margin_padding(array(
			'title'             => 'Checkbox',
			'key'               => 'checkbox',
			'toggle_slug'       => 'margin_padding',
			// 'default_margin'  => '15px|0px|15px|0px',
		));

		$submit_spacing = $this->add_margin_padding(array(
            'title'             => 'Submit',
            'key'               => 'submit',
            'toggle_slug'       => 'margin_padding',
				'default_padding' => '10px|15px|10px|15px'
		));
		$select_background = $this->df_add_bg_field(array(
			'label'				=> 'Dropdown Background',
            'key'               => 'drop_bg',
            'toggle_slug'       => 'dropdown',
            'tab_slug'			=> 'advanced'
		));
		return array_merge(
			$checkbox_radio_color,
			$settings,
			$input_background,
			$submit_background,
			$label_spacing,
			$input_spacing,
			$radio_spacing,
			$checkbox_spacing,
			$submit_spacing,
			$select_background
		);
	}

	public function additional_css_styles($render_slug) {
		
		// checkbox & radio active color
		if(isset($this->props['checkbox_radio_color'])){
			$this->df_process_color(
				array(
					 'render_slug' => $render_slug,
					 'slug'        => 'checkbox_radio_color',
					 'type'        => 'background-color',
					 'selector'    => '%%order_class%% .wpforms-container .wpforms-form input[type=radio]:checked:after',
					 'important'   => true,
				)
		  );
			
			$this->df_process_color(
				array(
					 'render_slug' => $render_slug,
					 'slug'        => 'checkbox_radio_color',
					 'type'        => 'border-color',
					 'selector'    => '%%order_class%% .wpforms-container .wpforms-form input[type=radio]:checked:before, 
					 						%%order_class%% .wpforms-container .wpforms-form input[type=radio]:checked:after, 
					 						%%order_class%% .wpforms-container .wpforms-form input[type=radio]:focus:before, 
					 						%%order_class%% .wpforms-container .wpforms-form input[type=checkbox]:checked:before, 
					 						%%order_class%% .wpforms-container .wpforms-form input[type=checkbox]:checked:after, 
					 						%%order_class%% .wpforms-container .wpforms-form input[type=checkbox]:focus:before',
					 'important'   => true,
				)
		  );

		  ET_Builder_Element::set_style($render_slug, array(
			'selector'    => "%%order_class%% .wpforms-container .wpforms-form input[type=radio]:checked:before, 
									%%order_class%% .wpforms-container .wpforms-form input[type=radio]:checked:after, 
									%%order_class%% .wpforms-container .wpforms-form input[type=radio]:focus:before,
									%%order_class%% .wpforms-container .wpforms-form input[type=checkbox]:checked:before, 
									%%order_class%% .wpforms-container .wpforms-form input[type=checkbox]:focus:before",
			'declaration' => "box-shadow: 0 0 0 1px ".$this->props['checkbox_radio_color'].",0px 1px 2px rgba(0,0,0,0.15) !important;"
	  ));
		}

		// if (isset($this->props['submit_align'])) {
		//       ET_Builder_Element::set_style($render_slug, array(
		//           'selector' => '%%order_class%% .wpforms-submit-container',
		//           'declaration' => sprintf('text-align: %1$s;', $this->props['submit_align'])
		//       ));
		//   }

		if (isset($this->props['submit_align'])) {
			$this->df_process_string_attr(array(
				'render_slug' => $render_slug,
				'slug'        => 'submit_align',
				'type'        => 'text-align',
				'selector'    => "%%order_class%% .wpforms-submit-container",
				'default'     => 'left'
			));
		}
		// input background
		$this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_bg',
            'selector'          => '%%order_class%% .wpforms-container .wpforms-field-container input[type="text"],
									%%order_class%% .wpforms-container .wpforms-field-container input[type="email"],
									%%order_class%% .wpforms-container .wpforms-field-container input[type="number"],
									%%order_class%% .wpforms-container .wpforms-field-container input[type="tel"],
									%%order_class%% .wpforms-container .wpforms-field-container input[type="password"],
									%%order_class%% .wpforms-container .wpforms-field-container textarea',
            'hover'             => '%%order_class%% .wpforms-container .wpforms-field-container input[type="text"]:hover,
									%%order_class%% .wpforms-container .wpforms-field-container input[type="email"]:hover,
									%%order_class%% .wpforms-container .wpforms-field-container input[type="number"]:hover,
									%%order_class%% .wpforms-container .wpforms-field-container input[type="tel"]:hover,
									%%order_class%% .wpforms-container .wpforms-field-container input[type="password"]:hover,
									%%order_class%% .wpforms-container .wpforms-field-container textarea:hover',
			'important' => true,
        ));
		//  button background
		$this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'submit_bg',
            'selector'          => '%%order_class%% .wpforms-container .wpforms-submit-container [type="submit"]',
            'hover'             => '%%order_class%% .wpforms-container .wpforms-submit-container [type="submit"]:hover',
				'important'         => true
        ));
		//  dropdown
		$this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'drop_bg',
			'selector'          => '%%order_class%% .wpforms-form .wpforms-field-container select, 
									%%order_class%% .wpforms-form .wpforms-field-container select:focus,
									%%order_class%% .wpforms-form .wpforms-field-select-style-modern .choices__inner',
            'hover'             => '%%order_class%% .wpforms-form .wpforms-field-container select:hover'
		));
		$this->df_process_range(array(
			'render_slug'       => $render_slug,
			'slug'              => 'dorpdown_height',
			'type'              => 'min-height',
			'selector'          => '%%order_class%% .wpforms-form .choices__inner',
			'unit'              => 'px',
		));
		$this->df_process_range(array(
			'render_slug'       => $render_slug,
			'slug'              => 'dorpdown_height',
			'type'              => 'height',
			'selector'          => '%%order_class%% .wpforms-form .wpforms-field-select:not(.wpforms-field-select-style-classic) select',
			'unit'              => 'px',
		));
		// label spacing
		$this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'label_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% label.wpforms-field-label',
            'hover'             => '%%order_class%% label.wpforms-field-label:hover',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'label_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% label.wpforms-field-label',
            'hover'             => '%%order_class%% label.wpforms-field-label:hover',
            'important'         => true
		));
		// input spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% input[type="text"],
									%%order_class%% input[type="email"],
									%%order_class%% input[type="number"],
									%%order_class%% input[type="tel"],
									%%order_class%% input[type="password"],
									%%order_class%% textarea',
            'hover'             => '%%order_class%% input[type="text"]:hover,
									%%order_class%% input[type="email"]:hover,
									%%order_class%% input[type="number"]:hover,
									%%order_class%% input[type="tel"]:hover,
									%%order_class%% input[type="password"]:hover,
									%%order_class%% textarea:hover',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% input[type="text"],
									%%order_class%% input[type="email"],
									%%order_class%% input[type="number"],
									%%order_class%% input[type="tel"],
									%%order_class%% input[type="password"],
									%%order_class%% textarea',
            'hover'             => '%%order_class%% input[type="text"]:hover,
									%%order_class%% input[type="email"]:hover,
									%%order_class%% input[type="number"]:hover,
									%%order_class%% input[type="tel"]:hover,
									%%order_class%% input[type="password"]:hover,
									%%order_class%% textarea:hover',
            'important'         => true
		));
		$this->set_margin_padding_styles(array(
			'render_slug'       => $render_slug,
			'slug'              => 'radio_margin',
			'type'              => 'margin',
			'selector'          => '%%order_class%% .wpforms-container .wpforms-field-radio',
			'hover'             => '%%order_class%% .wpforms-container .wpforms-field-radio:hover',
			'important'         => true
		));
		
		$this->set_margin_padding_styles(array(
			'render_slug'       => $render_slug,
			'slug'              => 'radio_padding',
			'type'              => 'padding',
			'selector'          => '%%order_class%% .wpforms-container .wpforms-field-radio',
			'hover'             => '%%order_class%% .wpforms-container .wpforms-field-radio:hover',
			'important'         => true
		));
		$this->set_margin_padding_styles(array(
			'render_slug'       => $render_slug,
			'slug'              => 'checkbox_margin',
			'type'              => 'margin',
			'selector'          => '%%order_class%% .wpforms-container .wpforms-field-checkbox',
			'hover'             => '%%order_class%% .wpforms-container .wpforms-field-checkbox:hover',
			'important'         => true
		));

		$this->set_margin_padding_styles(array(
			'render_slug'       => $render_slug,
			'slug'              => 'checkbox_padding',
			'type'              => 'padding',
			'selector'          => '%%order_class%% .wpforms-container .wpforms-field-checkbox',
			'hover'             => '%%order_class%% .wpforms-container .wpforms-field-checkbox:hover',
			'important'         => true
		));
		// submit spacing
		$this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'submit_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .wpforms-container .wpforms-submit-container [type="submit"]',
            'hover'             => '%%order_class%% .wpforms-container .wpforms-submit-container [type="submit"]:hover',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'submit_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .wpforms-container .wpforms-submit-container [type="submit"]',
            'hover'             => '%%order_class%% .wpforms-container .wpforms-submit-container [type="submit"]:hover',
            'important'         => true
		));
	}
	public function get_transition_fields_css_props() {
		$fields = parent::get_transition_fields_css_props();

		$input = '%%order_class%% .wpforms-container .wpforms-field-container input[type="text"],
		%%order_class%% .wpforms-container .wpforms-field-container input[type="email"],
		%%order_class%% .wpforms-container .wpforms-field-container input[type="number"],
		%%order_class%% .wpforms-container .wpforms-field-container input[type="tel"],
		%%order_class%% .wpforms-container .wpforms-field-container input[type="password"],
		%%order_class%% .wpforms-container .wpforms-field-container textarea';
		$submit = '%%order_class%% .wpforms-container .wpforms-form [type="submit"]';
		$dropdown = '%%order_class%% .wpforms-form .wpforms-field-container select';


		// spacing
		$fields['submit_margin'] = array('margin' => $submit);
		$fields['submit_padding'] = array('padding' => $submit);

		$fields['input_margin'] = array('margin' => $input);
		$fields['input_padding'] = array('padding' => $input);

		$fields['label_margin'] = array('margin' => '%%order_class%% label.wpforms-field-label');
		$fields['label_padding'] = array('padding' => '%%order_class%% label.wpforms-field-label');

		// background
		$fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'input_bg',
            'selector'      => $input
		));
		$fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'submit_bg',
            'selector'      => $submit
		));
		$fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'drop_bg',
            'selector'      => $dropdown
		));
		// border transition fix
		$fields = $this->df_fix_border_transition(
            $fields, 
            'input', 
            $input
        );
		$fields = $this->df_fix_border_transition(
            $fields, 
            'submit', 
            $submit
        );
		$fields = $this->df_fix_border_transition(
            $fields, 
            'dropdown', 
            $dropdown
        );
		
		return $fields;
	}
	/**
	 * Get all wpforms posts
	 * 
	 * @return Array of posts
	 */
	public function get_all_wpforms() {
		$wpforms = array();
        $args = array(
            'post_type' => 'wpforms',
            'numberposts'   => -1
        );
        $forms = get_posts($args);
        $wpforms['default'] = 'Select an item';
        foreach ( $forms as $form ) {
            $wpforms[$form->ID] = $form->post_title;
        }
        return $wpforms;
    }
    /**
	 * Render forms with the given id
	 * 
	 * @return HTML rendered by do_shortcode()
	 */
    public function render_wpforms() {
        if ($this->props['wpforms'] === 'default') {
			$wpforms = "Please select an contact form!";
		} else {
			$wpforms = do_shortcode('[wpforms id="'.$this->props['wpforms'].'" ]');
			ob_start();
			echo do_shortcode('[wpforms id="'.$this->props['wpforms'].'" ]');
			$wpforms = ob_get_clean();
		}
		return $wpforms;
    }

	public function render( $attrs, $content, $render_slug ) {
		$this->additional_css_styles($render_slug);
		return sprintf( '<div class="df-wpf-container">%1$s</div>', $this->render_wpforms() );
    }
    
}
new DIFL_WPForms;
