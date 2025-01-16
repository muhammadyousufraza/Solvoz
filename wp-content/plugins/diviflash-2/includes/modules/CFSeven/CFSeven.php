<?php

class DIFL_CFSeven extends ET_Builder_Module {
    public $slug       = 'difl_cfseven';
	public $vb_support = 'on';
	public $icon_path;
	use DF_UTLS;

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
	);

	public function init() {
		$this->name = esc_html__( 'Contact Form 7 Styler', 'divi_flash' );
		$this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/contact-form-7.svg';
	}

	public function get_settings_modal_toggles(){
		return array(
			'general'  => array(
					'toggles' => array(
							'main_content' 					=> esc_html__( 'Content', 'divi_flash' ),
							'elements' 						=> esc_html__( 'Elements', 'divi_flash' ),
							'input_background'				=> esc_html__( 'Input & Textarea Background', 'divi_flash' ),
							'select_background'				=> esc_html__( 'Dropdown Box Background', 'divi_flash' ),
							'submit_background'				=> esc_html__( 'Button Background', 'divi_flash' )
					),
			),
			'advanced'  =>  array(
					'toggles'   =>  array(
							'label'				=> esc_html__('Label', 'divi_flash'),
							'input'				=> esc_html__('Input & Textarea', 'divi_flash'),
							'dropdown'			=> esc_html__('Dropdown', 'divi_flash'),
							'submit'			=> esc_html__('Submit Button', 'divi_flash'),
							'design_size'			=> esc_html__('Input Field Width', 'divi_flash'),
							'input_border'		=> esc_html__('Input Border', 'divi_flash')
					)
			)
		);
	}

	public function get_advanced_fields_config() {
		$advanced_fields = array();
		$advanced_fields['text'] = false;

		$advanced_fields['fonts']['label'] = array(
			'label'         => esc_html__( 'Label', 'divi_flash' ),
			'toggle_slug'   => 'label',
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
				'main' => "%%order_class%% label, %%order_class%% .wpcf7-list-item-label",
				'hover' => "%%order_class%% label:hover, %%order_class%% .wpcf7-list-item-label:hover",
				'important'	=> 'all'
			),
		);
		$advanced_fields['fonts']['input'] = array(
			'label'         => esc_html__( 'Input', 'divi_flash' ),
			'toggle_slug'   => 'input',
			'tab_slug'		=> 'advanced',
			'hide_text_shadow'  => true,
			'line_height' => array (
				'default' => '1em',
			),
			'font_size' => array(
				'default' => '16px',
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
							%%order_class%% input[type="url"],
							%%order_class%% input[type="url"]::placeholder,
							%%order_class%% textarea,
							%%order_class%% textarea::placeholder,
							%%order_class%% input[type="date"]',
				'hover' => '%%order_class%% input[type="text"]:hover,
							%%order_class%% input[type="email"]:hover,
							%%order_class%% input[type="number"]:hover,
							%%order_class%% input[type="tel"]:hover,
							%%order_class%% input[type="password"]:hover,
							%%order_class%% input[type="url"]:hover,
							%%order_class%% textarea:hover',
				'important'	=> 'all'
			),
		);

		$advanced_fields['fonts']['dropdown'] = array(
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
				'main' => '%%order_class%% .wpcf7-select',
				'hover' => '%%order_class%% .wpcf7-select:hover',
				'important'	=> 'all'
			),
		);
		$advanced_fields['fonts']['submit'] = array(
			'label'         => esc_html__( 'Submit Button', 'divi_flash' ),
			'toggle_slug'   => 'submit',
			'tab_slug'		=> 'advanced',
			'hide_text_shadow'  => true,
			'line_height' => array (
				'default' => '1em',
			),
			'font_size' => array(
				'default' => '16px',
			),
			'css'      => array(
				'main' => '%%order_class%% [type="submit"]',
				'hover' => '%%order_class%% [type="submit"]:hover',
				'important'	=> 'all'
			),
		);
		$advanced_fields['borders']['input'] = array(
			'css'             => array(
				'main' => array(
					'border_radii' => '%%order_class%% input[type="text"],
										%%order_class%% input[type="email"],
										%%order_class%% input[type="number"],
										%%order_class%% input[type="tel"],
										%%order_class%% input[type="password"],
										%%order_class%% input[type="url"],
										%%order_class%% textarea',
					'border_styles' => '%%order_class%% input[type="text"],
										%%order_class%% input[type="email"],
										%%order_class%% input[type="number"],
										%%order_class%% input[type="tel"],
										%%order_class%% input[type="password"],
										%%order_class%% input[type="url"],
										%%order_class%% textarea',
					'border_styles_hover' => '%%order_class%% input[type="text"]:hover,
												%%order_class%% input[type="email"]:hover,
												%%order_class%% input[type="number"]:hover,
												%%order_class%% input[type="tel"]:hover,
												%%order_class%% input[type="password"]:hover,
												%%order_class%% input[type="url"]:hover,
												%%order_class%% textarea:hover',
				)
			),
			'tab_slug'        => 'advanced',
			'toggle_slug'     => 'input',
		);
		$advanced_fields['borders']['dropdown'] = array(
			'css'             => array(
				'main' => array(
					'border_radii' => '%%order_class%% .wpcf7-select',
					'border_styles' => '%%order_class%% .wpcf7-select',
					'border_styles_hover' => '%%order_class%% .wpcf7-select:hover',
				)
			),
			'tab_slug'        => 'advanced',
			'toggle_slug'     => 'dropdown',
		);
		$advanced_fields['borders']['submit'] = array(
			'css'             => array(
				'main' => array(
					'border_radii' => '%%order_class%% input[type="submit"]',
					'border_styles' => '%%order_class%% input[type="submit"]',
					'border_styles_hover' => '%%order_class%% input[type="submit"]:hover',
				)
			),
			'default' => array(
				'border_radii' => 'on|0px|0px|0px|0px',
				'border_styles' => array(
					'width' => '2px',
					'color' => '#333333',
					'style' => 'solid'
				)
			),
			'tab_slug'        => 'advanced',
			'toggle_slug'     => 'submit',
		);
		$advanced_fields['box_shadow']['submit'] = array(
			'css'             => array(
				'main' => '%%order_class%% input[type="submit"]'
			),
			'tab_slug'        => 'advanced',
			'toggle_slug'     => 'submit',
		);
		$advanced_fields['borders']['default'] = array(
			'css'             => array(
				'main' => array(
					'border_radii' => '%%order_class%%',
					'border_styles' => '%%order_class%%',
					'border_styles_hover' => '%%order_class%%:hover',
				)
			)
		);

		$advanced_fields['box_shadow']['default'] = array(
			'css'             => array(
				'main' => '%%order_class%%',
				'hover' => '%%order_class%%:hover'
			),
		);

		$advanced_fields['max_width'] = false;
		//$advanced_fields['box_shadow']['default'] = false;
		//$advanced_fields['transform'] = false;
		$advanced_fields['filters'] = false;
		$advanced_fields['link_options'] = false;
		//$advanced_fields['animation'] = false;
		return $advanced_fields;
	}

	public function get_fields() {
		$settigns = array(
			'cf7_forms' => array(
				'label'           	=> esc_html__( 'Contact Forms', 'divi_flash' ),
				'type'            	=> 'select',
				'options'			=> $this->df_get_all_wpcf7(),
				'option_category' 	=> 'basic_option',
				'default'			=> 'default',
				'description'     	=> esc_html__( 'Select the contact form you want to use.', 'divi_flash' ),
				'toggle_slug'     	=> 'main_content',
			)
		);
		$width_settings = array(
			'input_text_width' => array(
                'label'             => esc_html__('Input Text Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_size',
                'tab_slug'       => 'advanced',
                'allowed_units'     => array('%','px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'description'     => esc_html__('Set Day Width', 'divi_flash')
            ),

			'input_email_width' => array(
                'label'             => esc_html__('Input Email Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_size',
                'tab_slug'       => 'advanced',
                'allowed_units'     => array('%','px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true
            ),

			'input_textarea_width' => array(
                'label'             => esc_html__('Input Textarea Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_size',
                'tab_slug'       => 'advanced',
                'allowed_units'     => array('%','px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true
            ),
			'input_select_width' => array(
                'label'             => esc_html__('Input Dropdown Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_size',
                'tab_slug'       => 'advanced',
                'allowed_units'     => array('%','px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true
            ),
		);
		$input_background = $this->df_add_bg_field(array(
			'label'				=> 'Input & textarea Background',
            'key'               => 'input_background',
            'toggle_slug'       => 'input_background',
            'tab_slug'			=> 'general'
		));
		$select_background = $this->df_add_bg_field(array(
			'label'				=> 'Dropdown Background',
            'key'               => 'select_background',
            'toggle_slug'       => 'select_background',
            'tab_slug'			=> 'general'
		));
		$submit_background = $this->df_add_bg_field(array(
			'label'				=> 'Submit Button Background',
            'key'               => 'submit_background',
            'toggle_slug'       => 'submit_background',
            'tab_slug'			=> 'general'
		));
		$input_spacing = $this->add_margin_padding(array(
            'title'             => 'Input',
            'key'               => 'input',
            'toggle_slug'       => 'margin_padding',
        ));
		$select_spacing = $this->add_margin_padding(array(
            'title'             => 'Dropdown',
            'key'               => 'dropdown',
            'toggle_slug'       => 'margin_padding',
        ));
		$submit_spacing = $this->add_margin_padding(array(
            'title'             => 'Submit',
            'key'               => 'submit',
            'toggle_slug'       => 'margin_padding',
        ));
		$sumit_settings = array(
			'submit_button_align'    => array(
                'label'             => esc_html__('Alignment', 'divi_flash'),
                'type'              => 'text_align',
                'options'           => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'       => 'submit',
                'tab_slug'          => 'advanced'
            ),
			'input_submit_width' => array(
                'label'             => esc_html__('Submit Button Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'submit',
                'tab_slug'       => 'advanced',
                'allowed_units'     => array('%','px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true
            ),
		);
		return array_merge(
			$settigns,
			$width_settings,
			$input_background,
			$select_spacing,
			$select_background,
			$submit_background,
			$input_spacing,
			$submit_spacing,
			$sumit_settings
		);
	}

	public function additional_css_styles($render_slug) {
		// input background
		$this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_background',
            'selector'          => '%%order_class%% input[type="text"],
									%%order_class%% input[type="email"],
									%%order_class%% input[type="number"],
									%%order_class%% input[type="tel"],
									%%order_class%% input[type="password"],
									%%order_class%% input[type="url"],
									%%order_class%% input[type="date"],
									%%order_class%% textarea',
            'hover'             => '%%order_class%% input[type="text"]:hover,
									%%order_class%% input[type="email"]:hover,
									%%order_class%% input[type="number"]:hover,
									%%order_class%% input[type="tel"]:hover,
									%%order_class%% input[type="password"]:hover,
									%%order_class%% input[type="url"]:hover,
									%%order_class%% input[type="date"]:hover,
									%%order_class%% textarea:hover'
        ));
		//  dropdown background
		$this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'select_background',
            'selector'          => '%%order_class%% .wpcf7-select',
            'hover'             => '%%order_class%% .wpcf7-select:hover'
		));
		//  button background
		$this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'submit_background',
            'selector'          => '%%order_class%% [type="submit"]',
            'hover'             => '%%order_class%% [type="submit"]:hover'
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
									%%order_class%% input[type="url"],
									%%order_class%% input[type="date"],
									%%order_class%% textarea',
            'hover'             => '%%order_class%% input[type="text"]:hover,
									%%order_class%% input[type="email"]:hover,
									%%order_class%% input[type="number"]:hover,
									%%order_class%% input[type="tel"]:hover,
									%%order_class%% input[type="password"]:hover,
									%%order_class%% input[type="date"]:hover,
									%%order_class%% input[type="url"]:hover,
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
									%%order_class%% input[type="url"],
									%%order_class%% input[type="date"],
									%%order_class%% textarea',
            'hover'             => '%%order_class%% input[type="text"]:hover,
									%%order_class%% input[type="email"]:hover,
									%%order_class%% input[type="number"]:hover,
									%%order_class%% input[type="tel"]:hover,
									%%order_class%% input[type="password"]:hover,
									%%order_class%% input[type="url"]:hover,
									%%order_class%% input[type="date"]:hover,
									%%order_class%% textarea:hover',
            'important'         => true
		));
		// dropdown spacing
		$this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'dropdown_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .wpcf7-select',
            'hover'             => '%%order_class%% .wpcf7-select:hover',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'dropdown_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .wpcf7-select',
            'hover'             => '%%order_class%% .wpcf7-select:hover',
            'important'         => true
		));
		// submit spacing
		$this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'submit_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% [type="submit"]',
            'hover'             => '%%order_class%% [type="submit"]:hover',
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'submit_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% [type="submit"]',
            'hover'             => '%%order_class%% [type="submit"]:hover',
            'important'         => true
		));
		//width
		$this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_text_width',
            'type'              => 'width',
            'selector'    => '%%order_class%% .wpcf7-form-control.wpcf7-text',
        ));

		$this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_email_width',
            'type'              => 'width',
            'selector'    		=> '%%order_class%% .wpcf7-form-control.wpcf7-email',
        ));
		$this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_submit_width',
            'type'              => 'width',
            'selector'    => '%%order_class%% .wpcf7-form-control.wpcf7-submit',
        ));
		$this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_textarea_width',
            'type'              => 'width',
            'selector'    => '%%order_class%% .wpcf7-form-control.wpcf7-textarea',
        ));
		$this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_select_width',
            'type'              => 'width',
            'selector'    => '%%order_class%% .wpcf7-form-control.wpcf7-select',
        ));
		
		// alignment
		$this->df_process_string_attr(array(
            'render_slug'           => $render_slug,
            'slug'                  => 'submit_button_align',
            'type'                  => 'text-align',
            'selector'              => "%%order_class%% p:has(.wpcf7-form-control.wpcf7-submit)",
        ));

		// transition
		$this->apply_custom_transition(
			$render_slug,
			'%%order_class%% *'
		);
	}

	/**
	 * Get all contact form 7 posts
	 * 
	 * @return Array of posts
	 */
	public function df_get_all_wpcf7() {
		$cf7 = array();
		$args = array(
			'post_type' => 'wpcf7_contact_form',
			'numberposts'   => -1
		);
		$contact_forms = get_posts($args);
		$cf7['default'] = 'Select an item';
		foreach ( $contact_forms as $contact_form) {
			$cf7[$contact_form->ID] = $contact_form->post_title;
		}
		return $cf7;
	}
	
	/**
	 * Render forms with the given id
	 * 
	 * @return HTML rendered by do_shortcode()
	 */
	public function get_cf7() {
		if ($this->props['cf7_forms'] === 'default') {
			$contact_forms = "Please select an contact form!";
		} else {
			$contact_forms = do_shortcode('[contact-form-7 id="'.$this->props['cf7_forms'].'" ]');
		}
		return $contact_forms;
	}

	public function render( $attrs, $content, $render_slug ) {
		$this->additional_css_styles($render_slug);
		return sprintf( '<div class="df-cf7-container">%1$s</div>', $this->get_cf7() );
	}
}
new DIFL_CFSeven;