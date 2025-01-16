<?php

class DIFL_GravityForm extends ET_Builder_Module {
    public $slug       = 'df_gravity_form';
    public $vb_support = 'on';
    use DF_UTLS;

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
	);

	public function init() {
        $this->name = esc_html__( 'Gravity Form Styler', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/gravityform.svg';
		$this->input_selector = "%%order_class%% .gfield:not(.gfield--type-time) input[type='text']:not(.chosen-search-input), %%order_class%% input[type='password'], %%order_class%% input[type='url'], %%order_class%% input[type='phone'], %%order_class%% input[type='number'], %%order_class%% input[type='tel'], %%order_class%% input[type='email']";
        $this->input_selector_hover = "%%order_class%% .gfield:not(.gfield--type-time) input[type='text']:not(.chosen-search-input):hover, %%order_class%% input[type='password']:hover, %%order_class%% input[type='url']:hover, %%order_class%% input[type='phone']:hover, %%order_class%% input[type='number']:hover";
        $this->input_selector_focus = "%%order_class%% .gfield:not(.gfield--type-time) input[type='text']:not(.chosen-search-input):focus, %%order_class%% input[type='password']:focus, %%order_class%% input[type='url']:focus, %%order_class%% input[type='phone']:focus, %%order_class%% input[type='number']:focus";
        $this->select_selector = "%%order_class%% .gfield:not(.gfield--type-time) select, %%order_class%% .chosen-container-single .chosen-single, %%order_class%% .chosen-container-multi .chosen-choices";
        $this->select_selector_hover = "%%order_class%% .gfield:not(.gfield--type-time) select:hover";
        $this->select_selector_focus = "%%order_class%% .gfield:not(.gfield--type-time) select:focus";
        $this->textarea_selector = "%%order_class%% textarea";
        $this->textarea_selector_hover = "%%order_class%% textarea:hover";
        $this->textarea_selector_focus = "%%order_class%% textarea:focus";
        $this->checkbox_selector = "%%order_class%% .ginput_container:not(.ginput_container_consent) input[type='checkbox']";
        $this->checkbox_selector_hover = "%%order_class%% .ginput_container:not(.ginput_container_consent) input[type='checkbox']:hover";
        $this->radio_selector = "%%order_class%% input[type='radio']";
        $this->radio_selector_hover = "%%order_class%% input[type='radio']:hover";
        $this->button_selector = "%%order_class%% .button";
        $this->button_selector_hover = "%%order_class%% .button:hover";
        $this->confirm_selector = "%%order_class%% .gform_confirmation_message";
        $this->confirm_selector_hover = "%%order_class%% .gform_confirmation_message";
        $this->section_selector = "%%order_class%% .gsection";
        $this->section_selector_hover = "%%order_class%% .gsection:hover";
        $this->progress_selector = '%%order_class%% .gf_progressbar_percentage';
        $this->progress_selector_hover = '%%order_class%% .gf_progressbar_percentage:hover';
        $this->progress_wrapper = '%%order_class%% .gf_progressbar_wrapper';
        $this->progress_wrapper_hover = '%%order_class%% .gf_progressbar_wrapper:hover';
        $this->progess_steps = "%%order_class%% .gf_page_steps";
        $this->gform_heading = '%%order_class%% .gform_heading';
        $this->gform_heading_hover = '%%order_class%% .gform_heading:hover';
        $this->form_title = '%%order_class%% .gform_title';
        $this->form_title_hover = '%%order_class%% .gform_title:hover';
        $this->form_description = '%%order_class%% .gform_description';
        $this->form_description_hover = '%%order_class%% .gform_description:hover';
        $this->form_heading_notice = '%%order_class%% .gform_heading .gform_required_legend';
        $this->form_heading_notice_hover = '%%order_class%% .gform_heading .gform_required_legend:hover';
        $this->consent = '%%order_class%% .gfield--type-consent';
        $this->error_box_global = "%%order_class%% .gform_wrapper .gform_validation_errors";
        $this->error_box = "%%order_class%% .gform_wrapper .validation_message";
        $this->time_selector = "%%order_class%% .gfield.gfield--type-time input[type='text'], %%order_class%% .gfield.gfield--type-time select";
        $this->time_selector_hover = "%%order_class%% .gfield.gfield--type-time input[type='text']:hover, %%order_class%% .gfield.gfield--type-time select:hover";
        $this->time_input = "%%order_class%% .gfield.gfield--type-time input[type='text']";
        $this->time_select = "%%order_class%% .gfield.gfield--type-time select";
        $this->enhanced_select = "%%order_class%% .chosen-container-single";
        $this->enhanced_select_hover = "%%order_class%% .chosen-container-single:hover";
        $this->progress_steps = "%%order_class%% .gf_page_steps";
     }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'content'      => esc_html__( 'Content', 'divi_flash' ),
                    
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'heading' => array(
                        'title'             => esc_html__('Heading', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'design'   => array(
                                'name' => 'Heading',
                            ),
                            'title'     => array(
                                'name' => 'Title',
                            ),
                            'description'     => array(
                                'name' => 'Descr',
                            ),
                            'notice'     => array(
                                'name' => 'Notice',
                            )
                        ),
                    ),
                    'label' => esc_html__( 'Label', 'divi_falsh' ),
                    'sub-label' => esc_html__( 'Sub Label', 'divi_falsh' ),
                    'description' => esc_html__( 'Description', 'divi_falsh' ),
                    'placeholder' => esc_html__( 'Placeholder', 'divi_falsh' ),
                    'warning_text' => esc_html__( 'Warning Text', 'divi_falsh' ),
                    'input' => esc_html__('Input', 'divi_flash'),
                    'select' => esc_html__('Select', 'divi_flash'),
                    'textarea' => esc_html__('Textarea', 'divi_flash'),
                    'checkbox' => esc_html__('Checkbox', 'divi_flash'),
                    'radio' => esc_html__('Radio', 'divi_flash'),
                    'time'  => esc_html__('Time', 'divi_flash'),
                    'consent' => array(
                        'title'             => esc_html__('Consent', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'label'   => array(
                                'name' => 'Label',
                            ),
                            'checkbox'     => array(
                                'name' => 'Checkbox',
                            ),
                            'description'     => array(
                                'name' => 'Description',
                            )
                        ),
                    ),
                    'required_text' => esc_html__('Required Text', 'divi_flash'),
                    'error_box' => array(
                        'title'             => esc_html__('Error Box', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'global'   => array(
                                'name' => 'Global',
                            ),
                            'field'     => array(
                                'name' => 'Field Error',
                            )
                        )
                    ),
                    'gf_section' => array(
                        'title'             => esc_html__('Section', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'design'   => array(
                                'name' => 'Section',
                            ),
                            'title'     => array(
                                'name' => 'Title',
                            ),
                            'description'     => array(
                                'name' => 'Description',
                            )
                        ),
                    ),
                    'progress' => array(
                        'title' => esc_html__('Progress', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'bar'   => array(
                                'name' => 'Bar',
                            ),
                            'step'     => array(
                                'name' => 'Setp',
                            )
                        )
                    ),
                    'button' => esc_html__('Button', 'divi_flash'),
                    'confirm' => esc_html__('Confirmation', 'divi_flash'),
                    'focus' => esc_html__('Focus Settings', 'divi_flash'),
                )
            ),
        );
    }
    public function get_advanced_fields_config() {
        $advanced_fields = array();
        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = array(
            'form_title'   => array(
				'toggle_slug'   => 'heading',
                'sub_toggle'    => 'title',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '26px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => $this->form_title,
                    'hover' => $this->form_title_hover,
                    'important' => 'all'
                )
			),
            'form_description'   => array(
				'toggle_slug'   => 'heading',
                'sub_toggle'    => 'description',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => $this->form_description,
                    'hover' => $this->form_description_hover,
                    'important' => 'all'
                )
			),
            'form_heading_notice'   => array(
				'toggle_slug'   => 'heading',
                'sub_toggle'    => 'notice',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => $this->form_heading_notice,
                    'hover' => $this->form_heading_notice_hover,
                    'important' => 'all'
                )
			),
            'label'   => array(
				// 'label'         => esc_html__( 'La', 'divi_flash' ),
				'toggle_slug'   => 'label',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => "{$this->main_css_element} .gfield:not(.gfield--type-consent) .gfield_label.gform-field-label",
                    'hover' => "{$this->main_css_element} .gfield:not(.gfield--type-consent) .gfield_label.gform-field-label:hover",
                    'important' => 'all'
                )
			),
            'sub-label'   => array(
				'toggle_slug'   => 'sub-label',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => "{$this->main_css_element} .gform-field-label.gform-field-label--type-sub, {$this->main_css_element} .gfield_header_item.gform-grid-col",
                    'hover' => "{$this->main_css_element} .gform-field-label.gform-field-label--type-sub:hover, {$this->main_css_element} .gfield_header_item.gform-grid-col:hover",
                    'important' => 'all'
                )
			),
            'description'   => array(
				'toggle_slug'   => 'description',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => "{$this->main_css_element} .gfield_description:not(.warningTextareaInfo):not(.gfield_consent_description):not(.gfield_validation_message)",
                    'hover' => "{$this->main_css_element} .gfield_description:not(.warningTextareaInfo):not(.gfield_consent_description):not(.gfield_validation_message):hover",
                    'important' => 'all'
                )
			),
            'warning_text'   => array(
				'toggle_slug'   => 'warning_text',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => "{$this->main_css_element} .gfield_description.warningTextareaInfo",
                    'hover' => "{$this->main_css_element} .gfield_description.warningTextareaInfo:hover",
                    'important' => 'all'
                )
			),
            'input'   => array(
				'toggle_slug'   => 'input',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_letter_spacing' => true,
                'hide_text_shadow' => true,
                'hide_line_height' => true,
                'hide_text_align' => true,
				'css'      => array(
                    'main' => $this->input_selector,
                    'hover' => $this->input_selector_hover,
                    'important' => 'all'
                )
			),
            'select'   => array(
				'toggle_slug'   => 'select',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_letter_spacing' => true,
                'hide_text_shadow' => true,
                'hide_line_height' => true,
                'hide_text_align' => true,
				'css'      => array(
                    'main' => $this->select_selector,
                    'hover' => $this->select_selector_hover,
                    'important' => 'all'
                )
			),
            'textarea'   => array(
				'toggle_slug'   => 'textarea',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_letter_spacing' => true,
                'hide_text_shadow' => true,
                'hide_line_height' => true,
                'hide_text_align' => true,
				'css'      => array(
                    'main' => $this->textarea_selector,
                    'hover' => $this->textarea_selector_hover,
                    'important' => 'all'
                )
			),
            'checkbox'   => array(
				'toggle_slug'   => 'checkbox',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '15px',
                ),
                'hide_letter_spacing' => true,
                'hide_text_shadow' => true,
                'hide_text_align' => true,
				'css'      => array(
                    'main' => "%%order_class%% .gfield_checkbox .gform-field-label",
                    'hover' => "%%order_class%% .gfield_checkbox .gform-field-label:hover",
                    'important' => 'all'
                )
			),
            'radio'   => array(
				'toggle_slug'   => 'radio',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '15px',
                ),
                'hide_letter_spacing' => true,
                'hide_text_shadow' => true,
                'hide_text_align' => true,
				'css'      => array(
                    'main' => "%%order_class%% .gfield_radio .gform-field-label",
                    'hover' => "%%order_class%% .gfield_radio .gform-field-label:hover",
                    'important' => 'all'
                )
			),
            'button'   => array(
				'toggle_slug'   => 'button',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
                'hide_text_align' => true,
				'css'      => array(
                    'main' => $this->button_selector,
                    'hover' => $this->button_selector_hover,
                    'important' => 'all'
                )
			),
            'section_title'   => array(
				'toggle_slug'   => 'gf_section',
				'sub_toggle'   => 'title',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '22px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => "{$this->section_selector} .gsection_title",
                    'hover' => "{$this->section_selector} .gsection_title:hover",
                    'important' => 'all'
                )
			),
            'section_description'   => array(
				'toggle_slug'   => 'gf_section',
				'sub_toggle'   => 'description',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => "{$this->section_selector} .gsection_description",
                    'hover' => "{$this->section_selector} .gsection_description:hover",
                    'important' => 'all'
                )
			),
            'progress_title'   => array(
                'label'         => esc_html__('Progress Title', 'divi_flash'),
				'toggle_slug'   => 'progress',
                'sub_toggle'    => 'bar',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '13px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => "%%order_class%% .gf_progressbar_title",
                    'hover' => "%%order_class%% .gf_progressbar_title:hover",
                    'important' => 'all'
                )
			),
            'progress_step_name'   => array(
                'label'         => esc_html__('Page Name', 'divi_flash'),
				'toggle_slug'   => 'progress',
                'sub_toggle'    => 'step',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_align' => true,
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => "{$this->progress_steps} .gf_step_label",
                    'hover' => "{$this->progress_steps} .gf_step_label:hover",
                    'important' => 'all'
                )
			),
            'confirm'   => array(
				'toggle_slug'   => 'confirm',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => $this->confirm_selector,
                    'hover' => $this->confirm_selector_hover,
                    'important' => 'all'
                )
			),
            'consent_label'   => array(
				'toggle_slug'   => 'consent',
                'sub_toggle'    => 'label',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' =>  "{$this->consent} .gfield_label",
                    'hover' => "{$this->consent} .gfield_label:hover",
                    'important' => 'all'
                )
			),
            'consent_sublabel'   => array(
				'toggle_slug'   => 'consent',
                'sub_toggle'    => 'checkbox',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' =>  "{$this->consent} .gfield_consent_label",
                    'hover' => "{$this->consent} .gfield_consent_label:hover",
                    'important' => 'all'
                )
			),
            'consent_description'   => array(
				'toggle_slug'   => 'consent',
                'sub_toggle'    => 'description',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' =>  "{$this->consent} .gfield_description",
                    'hover' => "{$this->consent} .gfield_description:hover",
                    'important' => 'all'
                )
			),
            'required_text'   => array(
				'toggle_slug'   => 'required_text',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
                'hide_text_align' => true,
				'css'      => array(
                    'main' => "%%order_class%% .gfield_required",
                    'hover' => "%%order_class%% .gfield_required:hover",
                    'important' => 'all'
                )
			),
            'error_box_global'   => array(
				'toggle_slug'   => 'error_box',
                'sub_toggle'    => 'global',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => "{$this->error_box_global} h2, {$this->error_box_global} li a",
                    'hover' => "{$this->error_box_global} h2:hover, {$this->error_box_global} li a:hover",
                    'important' => 'all'
                )
			),
            'error_box'   => array(
				'toggle_slug'   => 'error_box',
                'sub_toggle'    => 'field',
				'tab_slug'		=> 'advanced',
				'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'hide_text_shadow' => true,
				'css'      => array(
                    'main' => $this->error_box,
                    'hover' => "{$this->error_box}:hover",
                    'important' => 'all'
                )
			),
            'time'   => array(
				'toggle_slug'   => 'time',
                // 'sub_toggle'    => 'field',
				'tab_slug'		=> 'advanced',
                'font_size' => array(
                    'default' => '15px',
                ),
                'hide_text_shadow' => true,
                'hide_text_align' => true,
                'hide_line_height' => true,
                'hide_letter_spacing' => true,
				'css' => array(
                    'main' => $this->time_selector,
                    'hover' => $this->time_selector_hover,
                    'important' => 'all'
                )
			)
        );
        $advanced_fields['borders'] = array(
            'heading'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => $this->gform_heading,
                        'border_radii_hover' => $this->gform_heading_hover,
                        'border_styles' => $this->gform_heading,
                        'border_styles_hover' => $this->gform_heading_hover,
                    ),
                    'important'         => 'all'
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'heading',
                'sub_toggle'        => 'design',
                'priority'          => 100
            ),
            'input'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => $this->input_selector,
                        'border_radii_hover' => $this->input_selector_hover,
                        'border_styles' => $this->input_selector,
                        'border_styles_hover' => $this->input_selector_hover,
                    ),
                    'important'         => 'all'
                ),
                'defaults'          => array(
                    'border_styles' => array(
                        'width'     => '1px'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'input'
            ),
            'select'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => $this->select_selector,
                        'border_radii_hover' => $this->select_selector_hover,
                        'border_styles' => $this->select_selector,
                        'border_styles_hover' => $this->select_selector_hover,
                    ),
                    'important'         => 'all'
                ),
                'defaults'          => array(
                    'border_styles' => array(
                        'width'     => '1px'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'select'
            ),
            'textarea'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => $this->textarea_selector,
                        'border_radii_hover' => $this->textarea_selector_hover,
                        'border_styles' => $this->textarea_selector,
                        'border_styles_hover' => $this->textarea_selector_hover,
                    ),
                    'important'         => 'all'
                ),
                'defaults'          => array(
                    'border_styles' => array(
                        'width'     => '1px'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'textarea'
            ),
            'button'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => $this->button_selector,
                        'border_radii_hover' => $this->button_selector_hover,
                        'border_styles' => $this->button_selector,
                        'border_styles_hover' => $this->button_selector_hover,
                    ),
                    'important'         => 'all'
                ),
                'defaults'          => array(
                    'border_styles' => array(
                        'width'     => '2px'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'button',
            ),
            'section'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => $this->section_selector,
                        'border_radii_hover' => $this->section_selector_hover,
                        'border_styles' => $this->section_selector,
                        'border_styles_hover' => $this->section_selector_hover,
                    ),
                    'important'         => 'all'
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'gf_section',
                'sub_toggle'        => 'design',
                'priority'          => 100
            ),
            'confirm'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => $this->confirm_selector,
                        'border_radii_hover' => $this->confirm_selector_hover,
                        'border_styles' => $this->confirm_selector,
                        'border_styles_hover' => $this->confirm_selector_hover,
                    ),
                    'important'         => 'all'
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'confirm',
            ),
            'error_box_global'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => $this->error_box_global,
                        'border_radii_hover' => "{$this->error_box_global}:hover",
                        'border_styles' => $this->error_box_global,
                        'border_styles_hover' => "{$this->error_box_global}:hover",
                    ),
                    'important'         => 'all'
                ),
                'defaults'          => array(
                    'border_styles' => array(
                        'width'     => '1px'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'error_box',
                'sub_toggle'        => 'global',
                'priority'          => 100
            ),
            'error_box'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => $this->error_box,
                        'border_radii_hover' => "{$this->error_box}:hover",
                        'border_styles' => $this->error_box,
                        'border_styles_hover' => "{$this->error_box}:hover",
                    ),
                    'important'         => 'all'
                ),
                'defaults'          => array(
                    'border_styles' => array(
                        'width'     => '1px'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'error_box',
                'sub_toggle'        => 'field',
                'priority'          => 100
            ),
            'time'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => $this->time_selector,
                        'border_radii_hover' => $this->time_selector_hover,
                        'border_styles' => $this->time_selector,
                        'border_styles_hover' => $this->time_selector_hover,
                    ),
                    'important'         => 'all'
                ),
                'defaults'          => array(
                    'border_styles' => array(
                        'width'     => '1px'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'time',
                // 'sub_toggle'        => 'field',
                'priority'          => 100
            ),
        );
        $advanced_fields['box_shadow'] = array(
            'heading'              => array(
                'css' => array(
                    'main' => $this->gform_heading,
                    'hover' => $this->gform_heading_hover,
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'heading',
                'sub_toggle'      => 'design',
                'priority'        => 100
            ),
            'input'              => array(
                'css' => array(
                    'main' => $this->input_selector,
                    'hover' => $this->input_selector_hover,
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'input'
            ),
            'select'              => array(
                'css' => array(
                    'main' => $this->select_selector,
                    'hover' => $this->select_selector_hover,
                    'important' => true
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'select'
            ),
            'textarea'              => array(
                'css' => array(
                    'main' => $this->textarea_selector,
                    'hover' => $this->textarea_selector_hover,
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'textarea'
            ),
            'button'              => array(
                'css' => array(
                    'main' => $this->button_selector,
                    'hover' => $this->button_selector_hover,
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button'
            ),
            'section'              => array(
                'css' => array(
                    'main' => $this->section_selector,
                    'hover' => $this->section_selector_hover,
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'gf_section',
                'sub_toggle'      => 'design',
                'priority'        => 100
            ),
            'confirm'              => array(
                'css' => array(
                    'main' => $this->confirm_selector,
                    'hover' => $this->confirm_selector_hover,
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'confirm'
            ),
            'time'              => array(
                'css' => array(
                    'main' => $this->time_selector,
                    'hover' => $this->time_selector_hover,
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'time'
            ),
        );
        
        return $advanced_fields;
    }

    public function get_fields() {
        $content = array(
            'gravity_forms' => array(
                'default'         => 'none',
                'label'           => esc_html__( 'Gravity Forms', 'divi_flash' ),
                'type'            => 'select',
                'option_category' => 'configuration',
                'options'         => df_load_g_forms(),
                'toggle_slug'     => 'content',
                'computed_affects' => [
                    '__gravityFormShortcode',
                ]
            ),
            'show_title'        => array(
                'label'             => esc_html__( 'Show Title', 'divi_flash' ),
                'type'              => 'yes_no_button',
                'toggle_slug'       => 'content',
                'description'       => esc_html__('Whether or not to display the form title.', 'divi_flash'),
                'default'           => 'off',
                'options'           => array(
                    'on'    => esc_html__('On', 'divi_flash'),
                    'off'   => esc_html__('Off', 'divi_flash'),
                ),
                'computed_affects' => [
                    '__gravityFormShortcode',
                ]
            ),
            'show_description'        => array(
                'label'             => esc_html__( 'Show Description', 'divi_flash' ),
                'type'              => 'yes_no_button',
                'toggle_slug'       => 'content',
                'default'           => 'off',
                'description'       => esc_html__('Whether or not to display the form description.', 'divi_flash'),
                'options'           => array(
                    'on'    => esc_html__('On', 'divi_flash'),
                    'off'   => esc_html__('Off', 'divi_flash'),
                ),
                'computed_affects' => [
                    '__gravityFormShortcode',
                ]
            ),
            'use_ajax'        => array(
                'label'             => esc_html__( 'Use Ajax', 'divi_flash' ),
                'type'              => 'yes_no_button',
                'toggle_slug'       => 'content',
                'default'           => 'off',
                'description'       => esc_html__('Specify whether or not to use AJAX to submit the form.', 'divi_flash'),
                'options'           => array(
                    'on'    => esc_html__('On', 'divi_flash'),
                    'off'   => esc_html__('Off', 'divi_flash'),
                ),
                'computed_affects' => [
                    '__gravityFormShortcode',
                ]
            ),
            'tabindex'        => array(
                'label'             => esc_html__( 'Tabindex', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'content',
                'description'       => esc_html__('Specify the starting tab index for the fields of this form.', 'divi_flash'),
                'default'           => '0',
                'default_on_front'  => '0',
                'fixed_range'       => true,
                'unitless'          => true,
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                    'min_limit' => 0,
                )
            ),
            "__gravityFormShortcode" => array(
                'type'                => 'computed',
                'computed_callback'   => array('DIFL_GravityForm', 'df_gravity_form_render_vb'),
                'computed_depends_on' => array(
                    'gravity_forms',
                    'show_title',
                    'show_description',
                    'use_ajax'
                )   
            )
        );
        $heading = array_merge(
            $this->df_add_bg_field(array(
                'label'             => 'Background',
                'key'               => 'heading_background',
                'toggle_slug'       => 'heading',
                'sub_toggle'        => 'design',
                'tab_slug'          => 'advanced',
                'priority'          => 10
            )),
            $this->add_margin_padding(array(
                'key'           => 'heading',
                'toggle_slug'   => 'heading',
                'sub_toggle'    => 'design',
                'priority'      => 10
            ))
        );
        $input = array_merge(
            array(
                'input_background' => array(
                    'label'           => esc_html__( 'Background Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'input',
                    'tab_slug'        => 'advanced',
                    'hover'           => 'tabs'
                )
            ),
            $this->add_margin_padding(array(
                'key'           => 'input',
                'toggle_slug'   => 'input'
            )),
            array(
                'input_placeholder_color' => array(
                    'label'           => esc_html__( 'Placeholder Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'input',
                    'tab_slug'        => 'advanced'
                )
            )
        );
        $select = array_merge(
            array(
                'select_background' => array(
                    'label'           => esc_html__( 'Background Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'select',
                    'tab_slug'        => 'advanced',
                    'hover'           => 'tabs'
                ),
            ),
            $this->add_margin_padding(array(
                'key'           => 'select',
                'toggle_slug'   => 'select'
            ))
        );
        $textarea = array_merge(
            array(
                'textarea_background' => array(
                    'label'           => esc_html__( 'Background Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'textarea',
                    'tab_slug'        => 'advanced',
                    'hover'           => 'tabs'
                ),
            ),
            $this->add_margin_padding(array(
                'key'           => 'textarea',
                'toggle_slug'   => 'textarea'
            )),
            array(
                'textarea_placeholder_color' => array(
                    'label'           => esc_html__( 'Placeholder Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'textarea',
                    'tab_slug'        => 'advanced'
                )
            )
        );
        $checkbox = array_merge(
            array(
                'checkbox_gap'        => array(
                    'label'             => esc_html__( 'Gap', 'divi_flash' ),
                    'type'              => 'range',
                    'toggle_slug'       => 'checkbox',
                    'tab_slug'          => 'advanced',
                    'default'           => '0px',
                    'default_unit'      => 'px',
                    'default_on_front'  => '0px',
                    'fixed_range'       => true,
                    'validate_unit'     => true,
                    'allowed_units'     => array( 'px' ),
                    'range_settings'    => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1',
                        'min_limit' => '0px',
                    )
                ),
                'checkbox_background' => array(
                    'label'           => esc_html__( 'Checkbox Background Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'checkbox',
                    'tab_slug'        => 'advanced'
                ),
                'checkbox_tickcolor' => array(
                    'label'           => esc_html__( 'Checkbox Tick Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'checkbox',
                    'tab_slug'        => 'advanced',
                    'default_on_front'=> '#333'
                ),
                'checkbox_bordercolor' => array(
                    'label'           => esc_html__( 'Checkbox Border Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'checkbox',
                    'tab_slug'        => 'advanced',
                    'default_on_front'=> '#333'
                ),
                'checkbox_size'        => array(
                    'label'             => esc_html__( 'Size', 'divi_flash' ),
                    'type'              => 'range',
                    'toggle_slug'       => 'checkbox',
                    'tab_slug'          => 'advanced',
                    'default'           => '20px',
                    'default_unit'      => 'px',
                    'default_on_front'  => '20px',
                    'fixed_range'       => true,
                    'validate_unit'     => true,
                    'allowed_units'     => array( 'px' ),
                    'range_settings'    => array(
                        'min'  => '10',
                        'max'  => '100',
                        'step' => '1',
                        'min_limit' => '10px',
                    )
                ),
                'checkbox_bordersize'        => array(
                    'label'             => esc_html__( 'Border Thickness', 'divi_flash' ),
                    'type'              => 'range',
                    'toggle_slug'       => 'checkbox',
                    'tab_slug'          => 'advanced',
                    'default'           => '1px',
                    'default_unit'      => 'px',
                    'default_on_front'  => '1px',
                    'fixed_range'       => true,
                    'validate_unit'     => true,
                    'allowed_units'     => array( 'px' ),
                    'range_settings'    => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1',
                        'min_limit' => '0px',
                    )
                ),
            )
        );
        $consent_checkbox = array_merge(
            array(
                'consent_checkbox_background' => array(
                    'label'           => esc_html__( 'Checkbox Background Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'consent',
                    'sub_toggle'      => 'checkbox',
                    'tab_slug'        => 'advanced'
                ),
                'consent_checkbox_tickcolor' => array(
                    'label'           => esc_html__( 'Checkbox Tick Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'consent',
                    'sub_toggle'      => 'checkbox',
                    'tab_slug'        => 'advanced',
                    'default_on_front'=> '#333'
                ),
                'consent_checkbox_bordercolor' => array(
                    'label'           => esc_html__( 'Checkbox Border Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'consent',
                    'sub_toggle'      => 'checkbox',
                    'tab_slug'        => 'advanced',
                    'default_on_front'=> '#333'
                ),
                'consent_checkbox_size'        => array(
                    'label'             => esc_html__( 'Size', 'divi_flash' ),
                    'type'              => 'range',
                    'toggle_slug'       => 'consent',
                    'sub_toggle'        => 'checkbox',
                    'tab_slug'          => 'advanced',
                    'default'           => '20px',
                    'default_unit'      => 'px',
                    'default_on_front'  => '20px',
                    'fixed_range'       => true,
                    'validate_unit'     => true,
                    'allowed_units'     => array( 'px' ),
                    'range_settings'    => array(
                        'min'  => '10',
                        'max'  => '100',
                        'step' => '1',
                        'min_limit' => '10px',
                    )
                ),
                'consent_checkbox_bordersize'        => array(
                    'label'             => esc_html__( 'Border Thickness', 'divi_flash' ),
                    'type'              => 'range',
                    'toggle_slug'       => 'consent',
                    'sub_toggle'        => 'checkbox',
                    'tab_slug'          => 'advanced',
                    'default'           => '1px',
                    'default_unit'      => 'px',
                    'default_on_front'  => '1px',
                    'fixed_range'       => true,
                    'validate_unit'     => true,
                    'allowed_units'     => array( 'px' ),
                    'range_settings'    => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1',
                        'min_limit' => '0px',
                    )
                ),
            ),
            array(
                'consent_description_background' => array(
                    'label'           => esc_html__( 'Background Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'consent',
                    'sub_toggle'      => 'description',
                    'tab_slug'        => 'advanced'
                ),
                'consent_description_bordercolor' => array(
                    'label'           => esc_html__( 'Border Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'consent',
                    'sub_toggle'      => 'description',
                    'tab_slug'        => 'advanced',
                    'default_on_front'=> '#ddd'
                )
            )
        );
        $radio = array_merge(
            array(
                'radio_gap'        => array(
                    'label'             => esc_html__( 'Gap', 'divi_flash' ),
                    'type'              => 'range',
                    'toggle_slug'       => 'radio',
                    'tab_slug'          => 'advanced',
                    'default'           => '0px',
                    'default_unit'      => 'px',
                    'default_on_front'  => '0px',
                    'fixed_range'       => true,
                    'validate_unit'     => true,
                    'allowed_units'     => array( 'px' ),
                    'range_settings'    => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1',
                        'min_limit' => '0px',
                    )
                ),
                'radio_box'        => array(
                    'label'             => esc_html__( 'Radio Box Style', 'divi_flash' ),
                    'type'              => 'yes_no_button',
                    'toggle_slug'       => 'radio',
                    'tab_slug'          => 'advanced',
                    'default'           => 'off',
                    'options'           => array(
                        'on'    => esc_html__('On', 'divi_flash'),
                        'off'   => esc_html__('Off', 'divi_flash'),
                    )
                ),
                'radio_background' => array(
                    'label'           => esc_html__( 'Radio Background Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'radio',
                    'tab_slug'        => 'advanced',
                ),
                'radio_dotcolor' => array(
                    'label'           => esc_html__( 'Radio Dot Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'radio',
                    'tab_slug'        => 'advanced',
                    'default_on_front'=> '#333'
                ),
                'radio_bordercolor' => array(
                    'label'           => esc_html__( 'Radio Border Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'radio',
                    'tab_slug'        => 'advanced',
                    'default_on_front'=> '#333'
                ),
                'radio_size'        => array(
                    'label'             => esc_html__( 'Size', 'divi_flash' ),
                    'type'              => 'range',
                    'toggle_slug'       => 'radio',
                    'tab_slug'          => 'advanced',
                    'default'           => '15px',
                    'default_unit'      => 'px',
                    'default_on_front'  => '15px',
                    'fixed_range'       => true,
                    'validate_unit'     => true,
                    'allowed_units'     => array( 'px' ),
                    'range_settings'    => array(
                        'min'  => '10',
                        'max'  => '100',
                        'step' => '1',
                        'min_limit' => '10px',
                    )
                ),
                'radio_bordersize'        => array(
                    'label'             => esc_html__( 'Border Thickness', 'divi_flash' ),
                    'type'              => 'range',
                    'toggle_slug'       => 'radio',
                    'tab_slug'          => 'advanced',
                    'default'           => '1px',
                    'default_unit'      => 'px',
                    'default_on_front'  => '1px',
                    'fixed_range'       => true,
                    'validate_unit'     => true,
                    'allowed_units'     => array( 'px' ),
                    'range_settings'    => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1',
                        'min_limit' => '0px',
                    )
                ),
            )
        );
        $button = array_merge(
            array(
                'button_align' => array(
                    'label'           => esc_html__( 'Button Align', 'divi_flash' ),
                    'type'            => 'text_align',
                    'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
                    'toggle_slug'     => 'button',
                    'tab_slug'        => 'advanced',
                    'show_if_not'     => array(
                        'button_full_width' => 'on'
                    )
                ),
                'button_full_width'        => array(
                    'label'             => esc_html__( 'Full width button', 'divi_flash' ),
                    'type'              => 'yes_no_button',
                    'toggle_slug'       => 'button',
                    'tab_slug'          => 'advanced',
                    'default'           => 'off',
                    'options'           => array(
                        'on'    => esc_html__('On', 'divi_flash'),
                        'off'   => esc_html__('Off', 'divi_flash'),
                    )
                ),
            ),
            $this->df_add_bg_field(array(
                'label'             => 'Background',
                'key'               => 'button_background',
                'toggle_slug'       => 'button',
                'tab_slug'          => 'advanced'
            )),
            array(
                'btn_icon_color' => array(
                    'label'           => esc_html__( 'Icon Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'button',
                    'tab_slug'        => 'advanced'
                )
            ),
            $this->add_margin_padding(array(
                'key'           => 'button',
                'toggle_slug'   => 'button'
            ))
        );
        $section = array_merge(
            $this->df_add_bg_field(array(
                'label'             => 'Background',
                'key'               => 'section_background',
                'toggle_slug'       => 'gf_section',
                'sub_toggle'        => 'design',
                'tab_slug'          => 'advanced',
                'priority'          => 10
            )),
            $this->add_margin_padding(array(
                'key'           => 'section',
                'toggle_slug'   => 'gf_section',
                'sub_toggle'    => 'design',
                'priority'      => 10
            )),
            $this->add_margin_padding(array(
                'key'           => 'section_title',
                'toggle_slug'   => 'gf_section',
                'sub_toggle'    => 'title',
                'priority'      => 10,
                'option'        => 'padding'
            )),
            $this->add_margin_padding(array(
                'key'           => 'section_description',
                'toggle_slug'   => 'gf_section',
                'sub_toggle'    => 'description',
                'priority'      => 10,
                'option'        => 'padding'
            ))
        );
        $progress = array_merge(
            $this->add_margin_padding(array(
                'title'         => 'Wrapper',
                'key'           => 'progress',
                'toggle_slug'   => 'progress',
                'sub_toggle'    => 'bar',
            )),
            $this->df_add_bg_field(array(
                'label'             => 'Bar Background',
                'key'               => 'progress_background',
                'toggle_slug'       => 'progress',
                'tab_slug'          => 'advanced',
                'sub_toggle'        => 'bar',
            )),
            array(
                'progress_color' => array(
                    'label'           => esc_html__( 'Text Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'progress',
                    'tab_slug'        => 'advanced',
                    'sub_toggle'      => 'bar',
                ),
                'steps_align' => array(
                    'label'           => esc_html__( 'Alignment', 'divi_flash' ),
                    'type'            => 'text_align',
                    'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
                    'toggle_slug'     => 'progress',
                    'sub_toggle'      => 'step',
                    'tab_slug'        => 'advanced'
                ),
                'step_background' => array(
                    'label'           => esc_html__( 'Step Number Background', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'progress',
                    'tab_slug'        => 'advanced',
                    'sub_toggle'      => 'step',
                ),
                'step_color' => array(
                    'label'           => esc_html__( 'Step Number Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'progress',
                    'tab_slug'        => 'advanced',
                    'sub_toggle'      => 'step',
                ),
                'step_bordercolor' => array(
                    'label'           => esc_html__( 'Step Number Border Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'progress',
                    'tab_slug'        => 'advanced',
                    'sub_toggle'      => 'step',
                ),
                'active_step_background' => array(
                    'label'           => esc_html__( 'Active Step Number Background', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'progress',
                    'tab_slug'        => 'advanced',
                    'sub_toggle'      => 'step',
                ),
                'active_step_color' => array(
                    'label'           => esc_html__( 'Active Step Number Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'progress',
                    'tab_slug'        => 'advanced',
                    'sub_toggle'      => 'step',
                ),
                'active_step_bordercolor' => array(
                    'label'           => esc_html__( 'Active Step Number Border Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'progress',
                    'tab_slug'        => 'advanced',
                    'sub_toggle'      => 'step',
                ),
                'complete_step_background' => array(
                    'label'           => esc_html__( 'Complete Step Number Background', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'progress',
                    'tab_slug'        => 'advanced',
                    'sub_toggle'      => 'step',
                ),
                'complete_step_color' => array(
                    'label'           => esc_html__( 'Complete Step Number Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'progress',
                    'tab_slug'        => 'advanced',
                    'sub_toggle'      => 'step',
                ),
                'step_bottom_bordercolor' => array(
                    'label'           => esc_html__( 'Bottom Border Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'progress',
                    'tab_slug'        => 'advanced',
                    'sub_toggle'      => 'step',
                ),
            )
        );
        $confirm = array_merge(
            $this->df_add_bg_field(array(
                'label'             => 'Background',
                'key'               => 'confirm_background',
                'toggle_slug'       => 'confirm',
                'tab_slug'          => 'advanced'
            )),
            $this->add_margin_padding(array(
                'key'           => 'confirm',
                'toggle_slug'   => 'confirm'
            ))
        );
        $focus = array_merge(
            array(
                'input_focus_background' => array(
                    'label'           => esc_html__( 'Input Background Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'focus',
                    'tab_slug'        => 'advanced'
                ),
                'input_focus_border_color' => array(
                    'label'           => esc_html__( 'Input Border Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'focus',
                    'tab_slug'        => 'advanced'
                ),
                'input_focus_text_color' => array(
                    'label'           => esc_html__( 'Input Text Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'focus',
                    'tab_slug'        => 'advanced'
                ),
            ),
            array(
                'select_focus_background' => array(
                    'label'           => esc_html__( 'Select Background Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'focus',
                    'tab_slug'        => 'advanced'
                ),
                'select_focus_border_color' => array(
                    'label'           => esc_html__( 'Select Border Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'focus',
                    'tab_slug'        => 'advanced'
                ),
                'select_focus_text_color' => array(
                    'label'           => esc_html__( 'Select Text Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'focus',
                    'tab_slug'        => 'advanced'
                ),
            ),
            array(
                'textarea_focus_background' => array(
                    'label'           => esc_html__( 'Textarea Background Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'focus',
                    'tab_slug'        => 'advanced'
                ),
                'textarea_focus_border_color' => array(
                    'label'           => esc_html__( 'Textarea Border Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'focus',
                    'tab_slug'        => 'advanced'
                ),
                'textarea_focus_text_color' => array(
                    'label'           => esc_html__( 'Textarea Text Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'focus',
                    'tab_slug'        => 'advanced'
                ),
            )
        );
        $error_box = array_merge(
            array(
                'error_box_global_background' => array(
                    'label'           => esc_html__( 'Background Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'error_box',
                    'tab_slug'        => 'advanced',
                    'sub_toggle'      => 'global'
                ),
                'error_box_background' => array(
                    'label'           => esc_html__( 'Background Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'error_box',
                    'tab_slug'        => 'advanced',
                    'sub_toggle'      => 'field'
                )
            ),
            $this->add_margin_padding(array(
                'key'           => 'error_box_global',
                'toggle_slug'   => 'error_box',
                'sub_toggle'    => 'global',
                'priority'      => 10
            )),
            $this->add_margin_padding(array(
                'key'           => 'error_box',
                'toggle_slug'   => 'error_box',
                'sub_toggle'    => 'field',
                'priority'      => 10
            ))
        );
        $time = array_merge(
            array(
                'time_background' => array(
                    'label'           => esc_html__( 'Background Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'time',
                    'tab_slug'        => 'advanced',
                    'hover'           => 'tabs'
                )
            ),
            $this->add_margin_padding(array(
                'title'         => 'Input',
                'key'           => 'time_input',
                'toggle_slug'   => 'time',
            )),
            $this->add_margin_padding(array(
                'title'         => 'Select',
                'key'           => 'time_select',
                'toggle_slug'   => 'time',
            )),
            array(
                'time_input_placeholder' => array(
                    'label'           => esc_html__( 'Input Placeholder Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'time',
                    'tab_slug'        => 'advanced'
                ),
                'time_colon' => array(
                    'label'           => esc_html__( 'Colon Color', 'divi_flash' ),
                    'type'            => 'color-alpha',
                    'toggle_slug'     => 'time',
                    'tab_slug'        => 'advanced'
                )
            )
        );
		return array_merge(
            $content,
            $heading,
            $input,
            $select,
            $textarea,
            $checkbox,
            $radio,
            $consent_checkbox,
            $button,
            $section,
            $progress,
            $confirm,
            $focus,
            $error_box,
            $time
        );
    }
    /**
     * Render the gravity form on VB
     */
    public static function df_gravity_form_render_vb( $args = [] ) {
        global $paged, $post, $wp_scripts, $wp_styles;
        $styles  = [];
        
        if($args['gravity_forms'] !== 'none' ){
            $id = intval($args['gravity_forms']); 
            $title = $args['show_title'] === 'on' ? 'true' : 'false';
            $description = $args['show_description'] === 'on' ? 'true' : 'false';
            $ajax = $args['use_ajax'] === 'on' ? 'true' : 'false';
            
            $shortcode = "[gravityform id='{$id}' title={$title} description={$description} ajax={$ajax} ]";

            ob_start();
            echo do_shortcode($shortcode);
            $gform = ob_get_clean();

            foreach ($wp_styles->queue as $handle) {
                $styles[] = $wp_styles->registered[$handle]->src;
            }
        
            $form = [
                'content'   => $gform,
                'styles'    => $styles,
            ];
            return $form;
        } 
        return 'Please select a form';        
    }  
    /**
     * Render the gravity form
     */
    public function df_gravity_form_render() {
        if(!isset($this->props['gravity_forms']) || $this->props['gravity_forms'] == 'none') return '<h2>Please select a form</h2>';

        $id = $this->props['gravity_forms'];
        $title = $this->props['show_title'] === 'on' ? 'true' : 'false';
        $description = $this->props['show_description'] === 'on' ? 'true' : 'false';
        $ajax = $this->props['use_ajax'] === 'on' ? 'true' : 'false';
        $tabindex = $this->props['tabindex'];

        $shortcode = "[gravityform id='{$id}' title={$title} description={$description} ajax={$ajax} tabindex={$tabindex} ]";
        ob_start();
        echo do_shortcode($shortcode);
        $gform = ob_get_clean();
        return $gform;
    }

    public function additional_css_styles($render_slug) {
        $aliment_values = array(
            'left' => 'flex-start',
            'right' => 'flex-end',
            'center' => 'center'
        );
        // heading
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'heading_background',
            'selector'          => $this->gform_heading,
            'hover'             => $this->gform_heading_hover,
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'heading_margin',
            'type'              => 'margin',
            'selector'          => $this->gform_heading,
            'hover'             => $this->gform_heading_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'heading_padding',
            'type'              => 'padding',
            'selector'          => $this->gform_heading,
            'hover'             => $this->gform_heading_hover,
        ));
        // input
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_background',
            'type'              => 'background-color',
            'selector'          => $this->input_selector,
            'hover'             => $this->input_selector_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_margin',
            'type'              => 'margin',
            'selector'          => $this->input_selector,
            'hover'             => $this->input_selector_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_padding',
            'type'              => 'padding',
            'selector'          => $this->input_selector,
            'hover'             => $this->input_selector_hover,
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% input::placeholder",
            'declaration' => sprintf('
                color: %1$s;', 
                $this->props['input_placeholder_color'])
        ));
        // select
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'select_background',
            'type'              => 'background',
            'selector'          => $this->select_selector,
            'hover'             => $this->select_selector_hover,
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'select_margin',
            'type'              => 'margin',
            'selector'          => $this->select_selector,
            'hover'             => $this->select_selector_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'select_padding',
            'type'              => 'padding',
            'selector'          => $this->select_selector,
            'hover'             => $this->select_selector_hover,
        ));
        // textarea
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'textarea_background',
            'type'              => 'background-color',
            'selector'          => $this->textarea_selector,
            'hover'             => $this->textarea_selector_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'textarea_margin',
            'type'              => 'margin',
            'selector'          => $this->textarea_selector,
            'hover'             => $this->textarea_selector_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'textarea_padding',
            'type'              => 'padding',
            'selector'          => $this->textarea_selector,
            'hover'             => $this->textarea_selector_hover,
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% textarea::placeholder",
            'declaration' => sprintf('
                color: %1$s;', 
                $this->props['textarea_placeholder_color'])
        ));
        // checkbox & radio
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%',
            'declaration' => sprintf('
                --checkbox-size: %1$s;
                --checkbox-border-color: %2$s;
                --checkbox-tick-color: %3$s;
                --checkbox-border-width: %4$s;
                --checkbox-background: %5$s;
                --checkbox-gap: %11$s;
                --radio-size: %6$s;
                --radio-dot-color: %7$s;
                --radio-border-color: %8$s;
                --radio-border-width: %9$s;
                --radio-background: %10$s;
                --radio-gap: %12$s;
                --radio-border-radius: %13$s;', 
                $this->props['checkbox_size'],
                $this->props['checkbox_bordercolor'],
                $this->props['checkbox_tickcolor'],
                $this->props['checkbox_bordersize'],
                $this->props['checkbox_background'],
                $this->props['radio_size'],
                $this->props['radio_dotcolor'],
                $this->props['radio_bordercolor'],
                $this->props['radio_bordersize'],
                $this->props['radio_background'],
                $this->props['checkbox_gap'],
                $this->props['radio_gap'],
                $this->props['radio_box'] === 'on' ? '0' : '50%')
        ));
        // consent checkbox
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%',
            'declaration' => sprintf('
                --consent-checkbox-size: %1$s;
                --consent-checkbox-border-color: %2$s;
                --consent-checkbox-tick-color: %3$s;
                --consent-checkbox-border-width: %4$s;
                --consent-checkbox-background: %5$s;
                --consent-description-background: %6$s;
                --consent-description-bordercolor: %7$s;', 
                $this->props['consent_checkbox_size'],
                $this->props['consent_checkbox_bordercolor'],
                $this->props['consent_checkbox_tickcolor'],
                $this->props['consent_checkbox_bordersize'],
                $this->props['consent_checkbox_background'],
                $this->props['consent_description_background'],
                $this->props['consent_description_bordercolor'])
        ));
        // error box
        // global error
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'error_box_global_background',
            'type'              => 'background-color',
            'selector'          => $this->error_box_global
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'error_box_global_margin',
            'type'              => 'margin',
            'selector'          => $this->error_box_global,
            'hover'             => "{$this->error_box_global}:hover",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'error_box_global_padding',
            'type'              => 'padding',
            'selector'          => $this->error_box_global,
            'hover'             => "{$this->error_box_global}:hover",
        ));
        // field error box
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'error_box_background',
            'type'              => 'background-color',
            'selector'          => $this->error_box
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'error_box_margin',
            'type'              => 'margin',
            'selector'          => $this->error_box,
            'hover'             => "{$this->error_box}:hover",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'error_box_padding',
            'type'              => 'padding',
            'selector'          => $this->error_box,
            'hover'             => "{$this->error_box}:hover",
        ));
        // button
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_background',
            'selector'          => $this->button_selector,
            'hover'             => $this->button_selector_hover,
            'important'         => true
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'btn_icon_color',
            'type'              => 'fill',
            'selector'          => "{$this->button_selector} svg path",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => $this->button_selector,
            'hover'             => $this->button_selector_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => $this->button_selector,
            'hover'             => $this->button_selector_hover,
        ));
        if(isset($this->props['button_align']) && $this->props['button_align'] !== '') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .gform_footer, %%order_class%% .gform_page_footer',
                'declaration' => sprintf('justify-content:%1$s !important;',
                    $aliment_values[$this->props['button_align']]
                ),
            ));
        }
        if(isset($this->props['button_full_width']) && $this->props['button_full_width'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .button',
                'declaration' => 'width: 100%;',
            ));
        }
        // section
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'section_background',
            'selector'          => $this->section_selector,
            'hover'             => $this->section_selector_hover
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'section_margin',
            'type'              => 'margin',
            'selector'          => $this->section_selector,
            'hover'             => $this->section_selector_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'section_padding',
            'type'              => 'padding',
            'selector'          => $this->section_selector,
            'hover'             => $this->section_selector_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'section_title_padding',
            'type'              => 'padding',
            'selector'          => "{$this->section_selector} .gsection_title",
            'hover'             => "{$this->section_selector} .gsection_title:hover",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'section_description_padding',
            'type'              => 'padding',
            'selector'          => "{$this->section_selector} .gsection_description",
            'hover'             => "{$this->section_selector} .gsection_description:hover",
        ));
        // progress 
        // bar
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'progress_background',
            'selector'          => $this->progress_selector,
            'hover'             => $this->progress_selector_hover,
            'important'         => true
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'progress_color',
            'type'              => 'color',
            'selector'          => $this->progress_selector,
            'hover'             => $this->progress_selector_hover,
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'progress_margin',
            'type'              => 'margin',
            'selector'          => $this->progress_wrapper,
            'hover'             => $this->progress_wrapper_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'progress_padding',
            'type'              => 'padding',
            'selector'          => $this->progress_wrapper,
            'hover'             => $this->progress_wrapper_hover,
        ));
        // steps
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $this->progess_steps,
            'declaration' => sprintf('
                text-align: %1$s !important;', 
                $this->props['steps_align'])
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'step_background',
            'type'              => 'background-color',
            'selector'          => "{$this->progress_steps} .gf_step .gf_step_number",
            'important'         => true
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'step_color',
            'type'              => 'color',
            'selector'          => "{$this->progress_steps} .gf_step .gf_step_number",
            'important'         => true
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'step_bordercolor',
            'type'              => 'border-color',
            'selector'          => "{$this->progress_steps} .gf_step .gf_step_number",
            'important'         => true
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'active_step_background',
            'type'              => 'background-color',
            'selector'          => "{$this->progress_steps} .gf_step_active .gf_step_number",
            'important'         => true
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'active_step_color',
            'type'              => 'color',
            'selector'          => "{$this->progress_steps} .gf_step_active .gf_step_number",
            'important'         => true
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'active_step_bordercolor',
            'type'              => 'border-color',
            'selector'          => "{$this->progress_steps} .gf_step_active .gf_step_number",
            'important'         => true
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'complete_step_background',
            'type'              => 'background-color',
            'selector'          => "{$this->progress_steps} .gf_step.gf_step_completed .gf_step_number:before",
            'important'         => true
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'complete_step_background',
            'type'              => 'border-color',
            'selector'          => "{$this->progress_steps} .gf_step.gf_step_completed .gf_step_number:before",
            'important'         => true
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'complete_step_color',
            'type'              => 'color',
            'selector'          => "{$this->progress_steps} .gf_step.gf_step_completed .gf_step_number:after",
            'important'         => true
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'step_bottom_bordercolor',
            'type'              => 'border-bottom-color',
            'selector'          => $this->progress_steps,
            'important'         => true
        ));
        // confirm
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'confirm_background',
            'selector'          => $this->confirm_selector,
            'hover'             => $this->confirm_selector_hover
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'confirm_margin',
            'type'              => 'margin',
            'selector'          => $this->confirm_selector,
            'hover'             => $this->confirm_selector_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'confirm_padding',
            'type'              => 'padding',
            'selector'          => $this->confirm_selector,
            'hover'             => $this->confirm_selector_hover,
        ));

        // focus settings
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_focus_background',
            'type'              => 'background-color',
            'selector'          => $this->input_selector_focus
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_focus_border_color',
            'type'              => 'border-color',
            'selector'          => $this->input_selector_focus
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'input_focus_text_color',
            'type'              => 'color',
            'selector'          => $this->input_selector_focus
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'select_focus_background',
            'type'              => 'background-color',
            'selector'          => $this->select_selector_focus
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'select_focus_border_color',
            'type'              => 'border-color',
            'selector'          => $this->select_selector_focus
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'select_focus_text_color',
            'type'              => 'color',
            'selector'          => $this->select_selector_focus
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'textarea_focus_background',
            'type'              => 'background-color',
            'selector'          => $this->textarea_selector_focus
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'textarea_focus_border_color',
            'type'              => 'border-color',
            'selector'          => $this->textarea_selector_focus
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'textarea_focus_text_color',
            'type'              => 'color',
            'selector'          => $this->textarea_selector_focus
        )); 
        // time
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_background',
            'type'              => 'background-color',
            'selector'          => $this->time_selector,
            'hover'             => $this->time_selector_hover
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_input_margin',
            'type'              => 'margin',
            'selector'          => $this->time_input,
            'hover'             => "{$this->time_input}:hover",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_input_padding',
            'type'              => 'padding',
            'selector'          => $this->time_input,
            'hover'             => "{$this->time_input}:hover",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_select_margin',
            'type'              => 'margin',
            'selector'          => $this->time_select,
            'hover'             => "{$this->time_select}:hover",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_select_padding',
            'type'              => 'padding',
            'selector'          => $this->time_select,
            'hover'             => "{$this->time_select}:hover",
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "{$this->time_input}::placeholder",
            'declaration' => sprintf('
                color: %1$s !important;', 
                $this->props['time_input_placeholder'])
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .hour_minute_colon",
            'declaration' => sprintf('
                color: %1$s !important;', 
                $this->props['time_colon'])
        ));
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        // heading
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'heading_background',
            'selector'      => $this->gform_heading
        ));  
        $fields['heading_margin'] = array ('margin' => $this->gform_heading);
        $fields['heading_padding'] = array ('padding' => $this->gform_heading);    
        // input
        $fields['input_margin'] = array ('margin' => $this->input_selector);
        $fields['input_padding'] = array ('padding' => $this->input_selector);
        $fields['input_background'] = array ('background-color' => $this->input_selector);
        // select
        $fields['select_margin'] = array ('margin' => $this->select_selector);
        $fields['select_padding'] = array ('padding' => $this->select_selector);
        $fields['select_background'] = array ('background-color' => $this->select_selector);
        // textarea
        $fields['textarea_margin'] = array ('margin' => $this->textarea_selector);
        $fields['textarea_padding'] = array ('padding' => $this->textarea_selector);
        $fields['textarea_background'] = array ('background-color' => $this->textarea_selector); 
        // error box
        $fields['error_box_margin'] = array ('margin' => $this->error_box);
        $fields['error_box_padding'] = array ('padding' => $this->error_box);
        // button
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'button_background',
            'selector'      => $this->button_selector
        ));  
        $fields['button_margin'] = array ('margin' => $this->button_selector);
        $fields['button_padding'] = array ('padding' => $this->button_selector);    
        // section
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'section_background',
            'selector'      => $this->section_selector
        ));  
        $fields['section_title_padding'] = array ('padding' => "{$this->section_selector} .gsection_title");
        $fields['section_description_padding'] = array ('padding' => "{$this->section_selector} .gsection_description");
        // progress
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'progress_background',
            'selector'      => $this->progress_selector
        ));  
        $fields['progress_color'] = array ('color' => $this->progress_selector);   
        $fields['progress_padding'] = array ('padding' => $this->progress_wrapper);
        $fields['progress_margin'] = array ('margin' => $this->progress_wrapper);
        // confirm
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'confirm_background',
            'selector'      => $this->confirm_selector
        ));  
        $fields['confirm_margin'] = array ('margin' => $this->confirm_selector);
        $fields['confirm_padding'] = array ('padding' => $this->confirm_selector);    

        return $fields;
    }

    public function get_custom_css_fields_config() {}

    public function render( $attrs, $content, $render_slug ) {
        $this->additional_css_styles($render_slug);

        return sprintf( '<div class="df-gravity-form-container">
                %1$s
            </div>', 
            $this->df_gravity_form_render()
        );
    }
}
new DIFL_GravityForm;