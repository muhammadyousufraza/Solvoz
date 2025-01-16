<?php

class DIFL_TypewriterText extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_typewriter_text';
    public $vb_support = 'on';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Typing Text', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/typewriter.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'content'           => esc_html__( 'Content', 'divi_flash' ),
                    'settings'          => esc_html__( 'Settings', 'divi_flash' ),
                    'prefix_background' => esc_html__( 'Prefix Background', 'divi_flash' ),
                    'typed_background'  => esc_html__( 'Typed Text Background', 'divi_flash' ),
                    'suffix_background' => esc_html__( 'Suffix Background', 'divi_flash' )
                )
            ),
            'advanced'   => array(
                'toggles'      => array(
                    'alignment'         => esc_html__( 'Alignment', 'divi_flash' ),
                    'ctext'             => esc_html__( 'Text', 'divi_flash' ),
                    'blockquote'        => esc_html__( 'Blockquote', 'divi_flash' ),
                    'prefix'            => esc_html__( 'Prefix', 'divi_flash' ),
                    'typed_text'        => esc_html__( 'Typed Text', 'divi_flash' ),
                    'suffix'            => esc_html__( 'Suffix', 'divi_flash' ),
                    'border'            => esc_html__( 'Border', 'divi_flash' ),
                    'custom_spacing'    => esc_html__( 'Custom Spacing', 'divi_flash' )
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();
        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = array(
            'text'   => array(
				'label'         => esc_html__( '', 'divi_flash' ),
				'toggle_slug'   => 'ctext',
				'tab_slug'		=> 'advanced',
				'line_height'   => array(
                    'default' => '1.7em',
                ),
                'font_size'     => array(
                    'default' => '14px',
                ),
				'css'           => array(
                    'main' => "{$this->main_css_element} .df-twt",
                    'hover' => "{$this->main_css_element} .df-twt:hover",
					'important' => 'all',
                )
            ),
            'prefix'   => array(
				'label'         => esc_html__( 'Prefix', 'divi_flash' ),
				'toggle_slug'   => 'prefix',
				'tab_slug'		=> 'advanced',
				'line_height'   => array(
                    'default' => '1.7em',
                ),
                'font_size'     => array(
                    'default' => '14px',
                ),
				'css'           => array(
                    'main' => "{$this->main_css_element} .prefix",
                    'hover' => "{$this->main_css_element} .df-twt .prefix:hover",
					'important' => 'all',
                )
            ),
            'typed_text'   => array(
				'label'         => esc_html__( 'Typed', 'divi_flash' ),
				'toggle_slug'   => 'typed_text',
				'tab_slug'		=> 'advanced',
				'line_height'   => array(
                    'default' => '1.7em',
                ),
                'font_size'     => array(
                    'default' => '14px',
                ),
				'css'           => array(
                    'main' => "{$this->main_css_element} .df-twt-element",
                    'hover' => "{$this->main_css_element} .df-twt .df-twt-element:hover",
					'important' => 'all',
                )
            ),
            'suffix'   => array(
				'label'         => esc_html__( 'Suffix', 'divi_flash' ),
				'toggle_slug'   => 'suffix',
				'tab_slug'		=> 'advanced',
				'line_height'   => array(
                    'default' => '1.7em',
                ),
                'font_size'     => array(
                    'default' => '14px',
                ),
				'css'           => array(
                    'main' => "{$this->main_css_element} .suffix",
                    'hover' => "{$this->main_css_element} .df-twt .suffix:hover",
					'important' => 'all',
                )
            ),
        );
        $advanced_fields['borders'] = array(
            'default'            => true,
            'prefix_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} span.prefix",
                        'border_styles' => "{$this->main_css_element} span.prefix",
                        'border_styles_hover' => "{$this->main_css_element} .df-twt span.prefix:hover",
                    )
                ),
                'label_prefix'    => esc_html__( 'Prefix', 'divi_flash' ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'prefix',	
            ),
            'typed_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} span.df-twt-element",
                        'border_styles' => "{$this->main_css_element} span.df-twt-element",
                        'border_styles_hover' => "{$this->main_css_element} .df-twt span.df-twt-element:hover",
                    )
                ),
                'label_prefix'    => esc_html__( 'Typed Text', 'divi_flash' ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'typed_text',	
            ),
            'suffix_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} span.suffix",
                        'border_styles' => "{$this->main_css_element} span.suffix",
                        'border_styles_hover' => "{$this->main_css_element} .df-twt span.suffix:hover",
                    )
                ),
                'label_prefix'    => esc_html__( 'Suffix', 'divi_flash' ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'suffix',	
            ),
        );

        $advanced_fields['box_shadow'] = array(
            'default'               => true,
            'prefix'             => array(
                'css' => array(
                    'main' => "%%order_class%% span.prefix",
                    'hover' => "%%order_class%% .df-twt span.prefix:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'prefix',
            ),
            'infix'             => array(
                'css' => array(
                    'main' => "%%order_class%% span.df-twt-element",
                    'hover' => "%%order_class%% .df-twt span.infix:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'typed_text',
            ),
            'suffix'             => array(
                'css' => array(
                    'main' => "%%order_class%% span.suffix",
                    'hover' => "%%order_class%% .df-twt span.suffix:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'suffix',
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
        $content = array(
            'prefix' => array(
				'label'           => esc_html__( 'Prefix', 'divi_flash' ),
				'type'            => 'text',
                'toggle_slug'     => 'content',
                'dynamic_content' => 'text'
			),
            'typed_text_list' => array(
				'label'           => esc_html__( 'Typewriter Text', 'divi_flash' ),
				'type'            => 'options_list',
                'toggle_slug'     => 'content'
			),
        
            'suffix' => array(
				'label'           => esc_html__( 'Suffix', 'divi_flash' ),
				'type'            => 'text',
                'toggle_slug'     => 'content',
                'dynamic_content' => 'text'
			),
            'main_wrap_tag'     => array(
                'label'             => esc_html__('Main Wrapper tag', 'divi_flash'),
                'type'              => 'select',
                'toggle_slug'       => 'content',
                'options'           => array(
                    'h1'            => 'h1',
                    'h2'            => 'h2',
                    'h3'            => 'h3',
                    'h4'            => 'h4',
                    'h5'            => 'h5',
                    'h6'            => 'h6',
                    'span'          => 'span',
                    'p'             => 'p',
                    'blockquote'    => 'blockquote',
                    'div'           => 'div',
                    'a'             => 'a'
                ),
                'default'           => 'div'
            ),
            'df_link' => array(
				'label'             => esc_html__( 'Link Url', 'divi_flash' ),
				'type'              => 'text',
                'toggle_slug'       => 'content',
                'show_if'           => array(
                    'main_wrap_tag'        => 'a'
                )
			),
            'df_link_target'     => array(
                'label'             => esc_html__('Link Target', 'divi_flash'),
                'type'              => 'select',
                'toggle_slug'       => 'content',
                'options'           => array(
                    'same'              => esc_html__( 'In The Same Window', 'divi_flash' ),
                    '_blank'            => esc_html__( 'In The New Window', 'divi_flash' ),
                ),
                'show_if'           => array(
                    'main_wrap_tag'        => 'a'
                )
            )
        );
        $settings = array (
           
            'speed'      => array (
                'label'                 => esc_html__( 'Typing Speed (ms)', 'divi_flash' ),
				'type'                  => 'range',
				'toggle_slug'           => 'settings',
				'default'               => '100',
                'unitless'              =>  true,
                'range_settings'        => array(
					'min'       => '1',
					'max'       => '2000',
					'step'      => '1',
                )
            ),
            'deletespeed'      => array (
                'label'                 => esc_html__( 'Delete Speed (ms)', 'divi_flash' ),
				'type'                  => 'range',
				'toggle_slug'           => 'settings',
				'default'               => '100',
                'unitless'              =>  true,
                'range_settings'        => array(
					'min'       => '1',
					'max'       => '2000',
					'step'      => '1',
                )
            ),
            'next_delay'      => array (
                'label'                 => esc_html__( 'Next Sting Delay (ms)', 'divi_flash' ),
				'type'                  => 'range',
				'toggle_slug'           => 'settings',
				'default'               => '1500',
                'unitless'              =>  true,
                'range_settings'        => array(
					'min'       => '50',
					'max'       => '10000',
					'step'      => '50',
                )
            ),
            'cursor'      => array (
                'label'                 => esc_html__( 'Cursor', 'divi_flash' ),
                'type'                  => 'yes_no_button',
                'options'               => array(
                    'off' => esc_html__( 'OFF', 'divi_flash' ),
                    'on'  => esc_html__( 'ON', 'divi_flash' ),
                ),
                'default'               => 'on',
                'toggle_slug'           => 'settings'
            ),
            'cursorchar' => array(
				'label'             => esc_html__( 'Cursor Character', 'divi_flash' ),
				'type'              => 'text',
                'toggle_slug'       => 'settings',
                'default'           => '|',
                'show_if_not'       => array(
                    'cursor'            => 'off',
                    'cursor_use_icon'   => 'on'
                )
			),
            'cursor_use_icon' => array(
                'label'                 => esc_html__( 'Use Cursor Icon', 'divi_flash' ),
                'type'                  => 'yes_no_button',
                'option_category'       => 'basic_option',
                'options'               => array(
                    'off' => esc_html__( 'No', 'divi_flash' ),
                    'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => 'settings',
                'show_if_not'       => array(
                    'cursor'        => 'off'
                )
            ),
            'cursor_font_icon' => array(
                'label'                 => esc_html__( 'Icon', 'divi_flash' ),
                'type'                  => 'select_icon',
                'option_category'       => 'basic_option',
                'class'                 => array( 'et-pb-font-icon' ),
                'toggle_slug'           => 'settings',
                'depends_show_if'       => 'on',
                'show_if_not'           => array(
                    'cursor'        => 'off'
                ),
                'show_if'               => array(
                    'cursor_use_icon'   => 'on'
                )
            ),
            'cursor_icon_color'  => array(
                'label'             => esc_html__( 'Cursor Icon Color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'settings',
                'show_if_not'           => array(
                    'cursor'        => 'off'
                ),
                'show_if'               => array(
                    'cursor_use_icon'   => 'on'
                )
            ),
            'cursor_font_size'      => array (
                'label'                 => esc_html__( 'Cursor Font Size (px)', 'divi_flash' ),
				'type'                  => 'range',
				'toggle_slug'           => 'settings',
				'default'               => '0',
                'default_unit'          => 'px',
                'range_settings'        => array(
					'min'       => '1',
					'max'       => '200',
					'step'      => '1',
                ),
                'show_if_not'           => array(
                    'cursor'        => 'off'
                ),
                'mobile_options'    => true
            ),
            'cursor_distance_left'      => array (
                'label'                 => esc_html__( 'Cursor Distance Left (px)', 'divi_flash' ),
				'type'                  => 'range',
				'toggle_slug'           => 'settings',
				'default'               => '0',
                'unitless'              =>  true,
                'range_settings'        => array(
					'min'       => '1',
					'max'       => '200',
					'step'      => '1',
                ),
                'show_if_not'               => array (
                    'cursor'              => 'off'
                )
            ),
            'loop'      => array (
                'label'                 => esc_html__( 'Loop', 'divi_flash' ),
                'type'                  => 'yes_no_button',
                'options'               => array(
                    'off' => esc_html__( 'No', 'divi_flash' ),
                    'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'settings'
            )
        );
        $display_prop = array(
            'display_props_prefix'     => array(
                'label'             => esc_html__('Display Property', 'divi_flash'),
                'description'       => esc_html__('Display property for prefix, typewriter text and suffix.', 'divi_flash'),
                'type'              => 'select',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'prefix',
                'options'           => array(
                    'inline'        => 'Inline',
                    'inline-block'  => 'Inline Block',
                    'block'         => 'Block',
                ),
                'default'           => 'inline-block',
                'mobile_options'    => true,
            ),
            'display_props_typed'     => array(
                'label'             => esc_html__('Display Property', 'divi_flash'),
                'description'       => esc_html__('Display property for prefix, typewriter text and suffix.', 'divi_flash'),
                'type'              => 'select',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'typed_text',
                'options'           => array(
                    'inline'        => 'Inline',
                    'inline-block'  => 'Inline Block',
                    'block'         => 'Block',
                ),
                'default'           => 'inline-block',
                'mobile_options'    => true,
            ),
            'display_props_suffix'     => array(
                'label'             => esc_html__('Display Property', 'divi_flash'),
                'description'       => esc_html__('Display property for prefix, typewriter text and suffix.', 'divi_flash'),
                'type'              => 'select',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'suffix',
                'options'           => array(
                    'inline'        => 'Inline',
                    'inline-block'  => 'Inline Block',
                    'block'         => 'Block',
                ),
                'default'           => 'inline-block',
                'mobile_options'    => true,
            ),
        );
        $alignemnt = array(
            'alignment'     => array(
                'label'           => esc_html__('Alignment', 'divi_flash'),
                'type'            => 'text_align',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'     => 'alignment',
                'tab_slug'        => 'advanced',
                'mobile_options'  => true
            )
        );
        $prefix_background = $this->df_add_bg_field(array(
            'label'             => 'Background',
            'key'               => 'prefix_background',
            'toggle_slug'       => 'prefix_background',
            'tab_slug'          => 'general'
        ));
        $typed_background = $this->df_add_bg_field(array(
            'label'             => 'Background',
            'key'               => 'typed_background',
            'toggle_slug'       => 'typed_background',
            'tab_slug'          => 'general'
        ));
        $suffix_background = $this->df_add_bg_field(array(
            'label'             => 'Background',
            'key'               => 'suffix_background',
            'toggle_slug'       => 'suffix_background',
            'tab_slug'          => 'general'
        ));

        $prefix_clip = $this->df_text_clip(array(
            'key'                   => 'prefix_clip',
            'toggle_slug'           => 'prefix',
            'tab_slug'              => 'advanced'
        ));
        $typed_clip = $this->df_text_clip(array(
            'key'                   => 'typed_clip',
            'toggle_slug'           => 'typed_text',
            'tab_slug'              => 'advanced'
        ));
        $suffix_clip = $this->df_text_clip(array(
            'key'                   => 'suffix_clip',
            'toggle_slug'           => 'suffix',
            'tab_slug'              => 'advanced'
        ));

        $prefix_spacing = $this->add_margin_padding(array(
            'title'             => 'Prefix',
            'key'               => 'prefix',
            'toggle_slug'       => 'custom_spacing'
        ));
        $typed_spacing = $this->add_margin_padding(array(
            'title'             => 'Typed Text',
            'key'               => 'typed',
            'toggle_slug'       => 'custom_spacing'
        ));
        $suffix_spacing = $this->add_margin_padding(array(
            'title'             => 'Suffix',
            'key'               => 'suffix',
            'toggle_slug'       => 'custom_spacing'
        ));
        return array_merge(
            $content,
            $settings,
            $alignemnt,
            $display_prop,
            $prefix_background,
            $typed_background,
            $suffix_background,
            $prefix_clip,
            $typed_clip,
            $suffix_clip,
            $prefix_spacing,
            $typed_spacing,
            $suffix_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $prefix = '%%order_class%% .prefix';
        $typed_text = '%%order_class%% .df-twt-element';
        $suffix = '%%order_class%% .suffix';


        $fields['prefix_margin'] = array( 'margin' => $prefix );
        $fields['prefix_padding'] = array( 'padding' => $prefix );

        $fields['typed_margin'] = array( 'margin' => $typed_text );
        $fields['typed_padding'] = array( 'padding' => $typed_text );

        $fields['suffix_margin'] = array( 'margin' => $suffix );
        $fields['suffix_padding'] = array( 'padding' => $suffix );
        
        // background 
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'prefix_background',
            'selector'      => $prefix
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'typed_background',
            'selector'      => $typed_text
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'suffix_background',
            'selector'      => $suffix
        ));
        // border transition
        $fields = $this->df_fix_border_transition(
            $fields, 
            'prefix_border', 
            $prefix
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'typed_border', 
            $typed_text
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'suffix_border', 
            $suffix
        );

        return $fields;
    }

    public function additional_css_styles($render_slug) {

        $prefix = '%%order_class%% .prefix';
        $prefix_hover = '%%order_class%% .df-twt .prefix:hover';
        $suffix = '%%order_class%% .suffix';
        $suffix_hover = '%%order_class%% .df-twt .suffix:hover';
        $typed = '%%order_class%% .df-twt-element';
        $typed_hover = '%%order_class%% .df-twt .df-twt-element:hover';

        if ( '' !== $this->props['alignment'] ) {
            $this->df_process_string_attr( array(
                'render_slug'       => $render_slug,
                'slug'              => 'alignment',
                'type'              => 'text-align',
                'selector'          => "%%order_class%% .df-twt-container",
                'default'           => 'left'
            ) );
        }
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'prefix_background',
            'selector'          => $prefix,
            'hover'             => $prefix_hover
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'typed_background',
            'selector'          => $typed,
            'hover'             => $typed_hover
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'suffix_background',
            'selector'          => $suffix,
            'hover'             => $suffix_hover
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'prefix_margin',
            'type'              => 'margin',
            'selector'          => $prefix,
            'hover'             => $prefix_hover,
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'prefix_padding',
            'type'              => 'padding',
            'selector'          => $prefix,
            'hover'             => $prefix_hover,
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'typed_margin',
            'type'              => 'margin',
            'selector'          => $typed,
            'hover'             => $typed_hover,
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'typed_padding',
            'type'              => 'padding',
            'selector'          => $typed,
            'hover'             => $typed_hover,
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'suffix_margin',
            'type'              => 'margin',
            'selector'          => $suffix,
            'hover'             => $suffix_hover,
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'suffix_padding',
            'type'              => 'padding',
            'selector'          => $suffix,
            'hover'             => $suffix_hover,
            'important'         => true
        ));

        $this->df_process_text_clip(array(
            'render_slug'       => $render_slug,
            'slug'              => 'prefix_clip',
            'selector'          => $prefix,
            'hover'             => $prefix_hover,
        ));
        $this->df_process_text_clip(array(
            'render_slug'       => $render_slug,
            'slug'              => 'typed_clip',
            'selector'          => $typed,
            'hover'             => $typed_hover,
        ));
        $this->df_process_text_clip(array(
            'render_slug'       => $render_slug,
            'slug'              => 'suffix_clip',
            'selector'          => $suffix,
            'hover'             => $suffix_hover,
        ));
        // icon font family
        if( $this->props['cursor_use_icon'] == 'on' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .twt-cursor-icon .Typewriter__cursor',
                'declaration' => 'font-family: ETmodules;
                        speak: none;
                        font-weight: 400;
                        -webkit-font-feature-settings: normal;
                        font-feature-settings: normal;
                        font-variant: normal;
                        text-transform: none;
                        line-height: 1;
                        -webkit-font-smoothing: antialiased;
                        font-style: normal;
                        display: inline-block;
                        -webkit-box-sizing: border-box;
                        box-sizing: border-box;
                        direction: ltr;'
            ));

            if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
                $this->generate_styles(
                    array(
                        'utility_arg'    => 'icon_font_family',
                        'render_slug'    => $render_slug,
                        'base_attr_name' => 'cursor_font_icon',
                        'important'      => true,
                        'selector'       => '%%order_class%% .twt-cursor-icon .Typewriter__cursor',
                        'processor'      => array(
                            'ET_Builder_Module_Helper_Style_Processor',
                            'process_extended_icon',
                        ),
                    )
                );
            }
        }
        
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .twt-cursor-icon .Typewriter__cursor',
            'declaration' => sprintf('color: %1$s !important;',
                $this->props['cursor_icon_color']
            ),
        ));
       
        if( isset($this->props['cursor_font_size']) && $this->props['cursor_font_size'] === '0' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-twt-element .Typewriter__cursor',
                'declaration' => 'font-size: inherit !important;'
            ));
        } else if( isset($this->props['cursor_font_size']) ) {
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'cursor_font_size',
                'type'              => 'font-size',
                'selector'          => '%%order_class%% .df-twt-element .Typewriter__cursor',
                'important'         => true
            ) );
        }
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'cursor_distance_left',
            'type'              => 'margin-left',
            'selector'          => '%%order_class%% .df-twt-element .Typewriter__cursor',
            'important'         => true,
            'fixed_unit'        => 'px'
        ) );

        $this->df_process_string_attr( array(
            'render_slug'       => $render_slug,
            'slug'              => 'display_props_prefix',
            'type'              => 'display',
            'selector'          => "%%order_class%% .prefix"
        ) );
        $this->df_process_string_attr( array(
            'render_slug'       => $render_slug,
            'slug'              => 'display_props_typed',
            'type'              => 'display',
            'selector'          => "%%order_class%% .df-twt-element"
        ) );
        $this->df_process_string_attr( array(
            'render_slug'       => $render_slug,
            'slug'              => 'display_props_suffix',
            'type'              => 'display',
            'selector'          => "%%order_class%% .suffix"
        ) );
        
    }

    /**
     * @return Array
     */
    public function typed_text() {
        $option_search  = array( '&#91;', '&#93;' );
		$option_replace = array( '[', ']' );
        $lists = str_replace( $option_search, $option_replace, $this->props['typed_text_list'] );
        $lists = json_decode( $lists, true );
        $string_list = array();

        foreach( $lists as $key => $item ) {
            if ( isset($item['value']) ) {
                array_push( $string_list, $item['value'] );
            }
        }
        
        return $string_list;
    }

    public function render($attr, $content, $render_slug ) {
		$this->handle_fa_icon();
        wp_enqueue_script('type-writer-lib');
        wp_enqueue_script('df-type-text-script');

        $this->additional_css_styles($render_slug);

        $classes = '';
        $link_attrs = '';
        if ( $this->props['main_wrap_tag'] === 'a' ) {
            $link_attrs .= sprintf( 'href=%1$s', 
                !empty($this->props['df_link']) ? esc_attr( $this->props['df_link'] ) : ''
            );
            if( $this->props['df_link_target'] === '_blank' ) {
                $link_attrs .= ' target=%1$s';
            }
        } 

        $cursor_text = $this->props['cursor_use_icon'] === 'on' && $this->props['cursor_font_icon'] !== '' ? esc_attr( et_pb_process_font_icon( $this->props['cursor_font_icon'] ) ) : wp_kses_post( $this->props['cursorchar'] );
        $classes .= $this->props[ 'cursor_use_icon' ] === 'on' && $this->props['cursor_font_icon'] !== '' ? ' twt-cursor-icon' : '';
        
        $data_options = array(
            'loop'              => $this->props['loop'],
            'speed'             => $this->props['speed'],
            'deleteSpeed'       => $this->props['deletespeed'],
            'cursorchar'        => $cursor_text,
            'cursor'            => $this->props['cursor'],
            'pauseFor'          => $this->props['next_delay']
        );

        $prefix = !empty( $this->props['prefix'] ) && $this->props['prefix'] !== '' ? sprintf( '<span class="prefix">%1$s</span> ', wp_kses_post( $this->props['prefix'] ) ) : '';
        $suffix = !empty( $this->props['suffix'] ) && $this->props['suffix'] !== ''? sprintf( ' <span class="suffix">%1$s</span>', wp_kses_post( $this->props['suffix'] ) ) : '';

        return sprintf('<div class="df-twt-container%7$s" data-options=\'%4$s\'>
                <%5$s class="df-twt" %6$s>%1$s<span class="df-twt-element" data-content=\'%2$s\'></span>%3$s</%5$s>
            </div>', 
            et_core_esc_previously( $prefix ),
            wp_json_encode( $this->typed_text() , JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE),
            et_core_esc_previously( $suffix ),
            wp_json_encode( $data_options ),
            esc_html( $this->props['main_wrap_tag'] ),
            esc_attr( $link_attrs ),
            esc_attr( $classes )
        );
    }
}
new DIFL_TypewriterText;