<?php

class DIFL_HoverBox extends ET_Builder_Module {
    public $slug       = 'difl_hoverbox';
    public $vb_support = 'on';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array (
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__('Hover Box', 'divi_flash');
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/hover-box.svg';
    }

    public function get_settings_modal_toggles() {
        return array(
            'general'   => array(
                'toggles'      => array(
                    'view'              => esc_html__('Change builder view', 'divi_flash'),
                    'content'           => esc_html__('Content', 'divi_flash'),
                    'button'            => esc_html__('Button', 'divi_flash'),
                    'hover'             => esc_html__('Hover Settings', 'divi_flash'),
                    'hb_background'     => esc_html__('Background', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'text'              => esc_html__('Text', 'divi_flash'),
                    'vertical_align'    => esc_html__('Vertical Align', 'divi_flash'),
                    'title'             => esc_html__('Title', 'divi_flash'),
                    'sub_title'         => esc_html__('Sub Title', 'divi_flash'),
                    'content'           => esc_html__('Content', 'divi_flash'),
                    'button'            => esc_html__('Button', 'divi_flash'),
                    'custom_border'     => esc_html__('Custom Border', 'divi_flash'),
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

        $advanced_fields['text'] = array(
			'use_text_orientation'  => true, // default
			'css' => array(
				'text_orientation' => '%%order_class%% .df_hb_container',
			)
		);
        $advanced_fields['fonts'] = array (
            'title'         => array(
                'label'         => esc_html__( 'Title', 'divi_flash' ),
                'toggle_slug'   => 'title',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '22px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .title",
                    'important'	=> 'all'
                ),
            ),
            'sub_title'         => array(
                'label'         => esc_html__( 'Sub Title', 'divi_flash' ),
                'toggle_slug'   => 'sub_title',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .subtitle",
                    'important'	=> 'all'
                ),
            ),
            'content'         => array(
                'label'         => esc_html__( 'Content', 'divi_flash' ),
                'toggle_slug'   => 'content',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1.7em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .content",
                    'important'	=> 'all'
                ),
            ),
            'button'     => array(
                'label'         => esc_html__( 'Button', 'divi_flash' ),
                'toggle_slug'   => 'button',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_hb_button",
                    'hover' => "%%order_class%% .df_hb_button:hover",
                    'important'	=> 'all'
                ),
            ),
        );
        $advanced_fields['borders'] = array (
            'default'               => true,
            'button'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_hb_button',
                        'border_radii_hover' => '%%order_class%% .df_hb_button:hover',
                        'border_styles' => '%%order_class%% .df_hb_button',
                        'border_styles_hover' => '%%order_class%% .df_hb_button:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'button'
            ),
            'title'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .title',
                        'border_styles' => '%%order_class%% .title',
                        'border_styles_hover' => '%%order_class%% .title:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'title',
                'label_prefix'      => esc_html__('Title', 'divi_flash')
            ),
            'subtitle'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .subtitle',
                        'border_styles' => '%%order_class%% .subtitle',
                        'border_styles_hover' => '%%order_class%% .subtitle:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'sub_title',
                'label_prefix'      => esc_html__('Subtitle', 'divi_flash')
            ),
            'content'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .content',
                        'border_styles' => '%%order_class%% .content',
                        'border_styles_hover' => '%%order_class%% .content:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'content',
                'label_prefix'      => esc_html__('Content', 'divi_flash')
            )
        );

        $advanced_fields['box_shadow'] = array (
            'default'               => true,
            'button'              => array(
                'css' => array(
                    'main' => "%%order_class%% .df_hb_button",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button'
            )
        );
        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'important' => 'all'
            )
        );
        $advanced_fields['background'] = false;
    
        return $advanced_fields;
    }

    public function get_fields() {
        $general = array (
            'change_view'    => array (
                'label'             => esc_html__('Change Builder View Mode', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Default', 'divi_flash' ),
					'on'  => esc_html__( 'Hover', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'view'
            ),
            'title'         => array (
                'label'             => esc_html__('Title', 'divi_flash'),
                'type'              => 'text',
                'toggle_slug'       => 'content',
                'dynamic_content'   => 'text'
            ),
            'sub_title'      => array (
                'label'             => esc_html__('Sub Title', 'divi_flash'),
                'type'              => 'text',
                'toggle_slug'       => 'content',
                'dynamic_content'   => 'text'
            ),
            'content'        => array (
                'label'             => esc_html__('Content', 'divi_flash'),
                'type'              => 'tiny_mce',
                'toggle_slug'       => 'content',
                'dynamic_content'   => 'text'
            ),
        );
        $button = $this->df_add_btn_content(array (
            'key'                   => 'hb_btn',
            'toggle_slug'           => 'button',
            'dynamic_option'        => true
        ));
        $button_style = $this->df_add_btn_styles(array (
            'key'                   => 'hb_btn',
            'toggle_slug'           => 'button',
            'tab_slug'              => 'advanced'
        ));
        $buttons_bg = $this->df_add_bg_field(array (
			'label'				    => 'Button Background',
            'key'                   => 'hb_btn_background',
            'toggle_slug'           => 'button',
            'tab_slug'              => 'advanced'
        ));
        $background = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'hb_background',
            'toggle_slug'           => 'hb_background',
            'tab_slug'              => 'general'
        ));
        $hover_settings = array (
            'title_on_hover'      => array (
                'label'                 => esc_html__( 'Title On Hover', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'hover'
            ),
            'subtitle_on_hover'      => array (
                'label'                 => esc_html__( 'Sub Title On Hover', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'hover'
            ),
            'content_on_hover'      => array (
                'label'                 => esc_html__( 'Content On Hover', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'hover'
            ),
            'button_on_hover'      => array (
                'label'                 => esc_html__( 'Button On Hover', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'hover'
            ),
            'background_scale'      => array (
                'label'                 => esc_html__( 'Background Scale On hover', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'default'               => 'off',
                'toggle_slug'           => 'hover'
            ),
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
                'toggle_slug'     => 'hover'
            )
        );
        $vertical_align = array (
            'vertical_align' => array (
                'default'         => 'flex-start',
                'label'           => esc_html__( 'Vertical Align', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'flex-start'    => esc_html__( 'Top', 'divi_flash' ),
                    'center'        => esc_html__( 'Center', 'divi_flash' ),
                    'flex-end'      => esc_html__( 'Bottom', 'divi_flash' )
                ),
                'toggle_slug'     => 'vertical_align',
                'tab_slug'        => 'advanced',
                'description'     => esc_html__('Vertical align only work if you have a fixed module height that is larger then the content.', 'divi_flash')
            )
        );
        $tag = array (
            'title_tag' => array (
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
                'toggle_slug'     => 'title',
                'tab_slug'        => 'advanced'
            ),
            'subtitle_tag' => array (
                'default'         => 'h6',
                'label'           => esc_html__( 'Subtitle Tag', 'divi_flash' ),
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
                'toggle_slug'     => 'sub_title',
                'tab_slug'        => 'advanced'
            )
        );

        $wrapper = $this->add_margin_padding(array(
            'title'         => 'Wrapper',
            'key'           => 'wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $button_wrapper = $this->add_margin_padding(array(
            'title'         => 'Button Wrapper',
            'key'           => 'button_wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $title_spacing = $this->add_margin_padding(array(
            'title'         => 'Title',
            'key'           => 'title',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        $subtitle_spacing = $this->add_margin_padding(array(
            'title'         => 'Sub Title',
            'key'           => 'subtitle',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        $content_spacing = $this->add_margin_padding(array(
            'title'         => 'Content',
            'key'           => 'content',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        $button_spacing = $this->add_margin_padding(array(
            'title'         => 'Button',
            'key'           => 'button',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        $title_background = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'title_bg',
            'toggle_slug'           => 'title',
            'tab_slug'              => 'advanced'
        ));
        $subtitle_background = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'subtitle_bg',
            'toggle_slug'           => 'sub_title',
            'tab_slug'              => 'advanced'
        ));
        $content_background = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'content_bg',
            'toggle_slug'           => 'content',
            'tab_slug'              => 'advanced'
        ));

        return array_merge(
            $general,
            $button,
            $button_style,
            $hover_settings,
            $buttons_bg,
            $background,
            $vertical_align,
            $tag,
            $wrapper,
            $button_wrapper,
            $title_spacing,
            $subtitle_spacing,
            $content_spacing,
            $button_spacing,
            $title_background,
            $subtitle_background,
            $content_background
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        // selectors
        $wrapper = '%%order_class%% .df_hb_container';
        $title = '%%order_class%% .title';
        $subtitle = '%%order_class%% .subtitle';
        $content = '%%order_class%% .content';
        $button = '%%order_class%% .df_hb_button';
        $button_wrapper = '%%order_class%% .df_hb_button_wrapper';

        // background
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'hb_btn_background',
            'selector'      => '%%order_class%% .df_hb_button'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'hb_background',
            'selector'      => '%%order_class%%'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'title_bg',
            'selector'      => '%%order_class%% .title'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'sub_title',
            'selector'      => '%%order_class%% .subtitle'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'content_bg',
            'selector'      => '%%order_class%% .content'
        ));
        // spacing
        $fields['wrapper_margin'] = array ('margin' => $wrapper);
        $fields['wrapper_padding'] = array ('padding' => $wrapper);

        $fields['title_margin'] = array ('margin' => $title);
        $fields['title_padding'] = array ('padding' => $title);

        $fields['subtitle_margin'] = array ('margin' => $subtitle);
        $fields['subtitle_padding'] = array ('padding' => $subtitle);

        $fields['content_margin'] = array ('margin' => $content);
        $fields['content_padding'] = array ('padding' => $content);

        $fields['button_margin'] = array ('margin' => $button);
        $fields['button_padding'] = array ('padding' => $button);

        $fields['button_wrapper_margin'] = array ('margin' => $button_wrapper);
        $fields['button_wrapper_padding'] = array ('padding' => $button_wrapper);

        // fix border transition
        $fields = $this->df_fix_border_transition(
            $fields, 
            'button', 
            $button
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'title', 
            $title
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'subtitle', 
            $subtitle
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'content', 
            $content
        );

        return $fields;
    }

    public function additional_css_styles($render_slug) {
        // background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'hb_background',
            'selector'          => '%%order_class%% .df_hb_background',
            'hover'             => '%%order_class%%:hover .df_hb_background'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'title_bg',
            'selector'          => '%%order_class%% .title',
            'hover'             => '%%order_class%% .title:hover'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'subtitle_bg',
            'selector'          => '%%order_class%% .subtitle',
            'hover'             => '%%order_class%% .subtitle:hover'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'content_bg',
            'selector'          => '%%order_class%% .content',
            'hover'             => '%%order_class%% .content:hover'
        ));
        // button style
        $this->df_process_btn_styles(array (
            'render_slug'       => $render_slug,
            'slug'              => 'hb_btn',
            'selector'          => '%%order_class%% .df_hb_button',
            'hover'             => '%%order_class%% .df_hb_button:hover',
            'align_container'   => '%%order_class%% .df_hb_button_wrapper'
        ));
        // button background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'hb_btn_background',
            'selector'          => '%%order_class%% .df_hb_button',
            'hover'             => '%%order_class%% .df_hb_button:hover'
        ));
        // wrapper spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_hb_container',
            'hover'             => '%%order_class%% .df_hb_container:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_hb_container',
            'hover'             => '%%order_class%% .df_hb_container:hover',
        ));
        // button wrapper spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_hb_button_wrapper',
            'hover'             => '%%order_class%% .df_hb_button_wrapper:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_hb_button_wrapper',
            'hover'             => '%%order_class%% .df_hb_button_wrapper:hover',
        ));
        // Title spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .title',
            'hover'             => '%%order_class%% .title:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .title',
            'hover'             => '%%order_class%% .title:hover',
        ));
        // Sub Title spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'subtitle_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .subtitle',
            'hover'             => '%%order_class%% .subtitle:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'subtitle_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .subtitle',
            'hover'             => '%%order_class%% .subtitle:hover',
        ));
        // Content spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .content',
            'hover'             => '%%order_class%% .content:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .content',
            'hover'             => '%%order_class%% .content:hover',
        ));
        // Button spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_hb_button',
            'hover'             => '%%order_class%% .df_hb_button:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_hb_button',
            'hover'             => '%%order_class%% .df_hb_button:hover',
        ));

        if ($this->props['background_scale'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%:hover .df_hb_background',
                'declaration' => 'transform: scale(1.06);'
            ));
        }
        if (isset($this->props['vertical_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_hb_inner',
                'declaration' => sprintf('justify-content: %1$s;', $this->props['vertical_align'])
            ));
        }
        // transform styles
        if (isset($this->props['anim_direction'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_hb_def_content',
                'declaration' => sprintf('transform: %1$s;', 
                    $this->df_transform_values($this->props['anim_direction'], 'default'))
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_hb_def_content_hover',
                'declaration' => sprintf('transform: %1$s;', 
                    $this->df_transform_values($this->props['anim_direction'], 'hover'))
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%:hover .df_hb_def_content',
                'declaration' => sprintf('transform: %1$s;', 
                    $this->df_transform_values($this->props['anim_direction'], 'hover'))
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%:hover .df_hb_def_content_hover',
                'declaration' => sprintf('transform: %1$s;', 
                    $this->df_transform_values($this->props['anim_direction'], 'default'))
            ));
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
                'hover'     => 'translateY(-60px)'
            ],
            'bottom'        => [
                'default'   => 'translateY(0px)',
                'hover'     => 'translateY(60px)'
            ],
            'left'          => [
                'default'   => 'translateX(0px)',
                'hover'     => 'translateX(-60px)'
            ],
            'right'         => [
                'default'   => 'translateX(0px)',
                'hover'     => 'translateX(60px)'
            ],
            'center'        => [
                'default'   => 'scale(1)',
                'hover'     => 'scale(0)'
            ],
            'top_right'     => [
                'default'   => 'translateX(0px) translateY(0px)',
                'hover'     => 'translateX(50px) translateY(-50px)'
            ],
            'top_left'      => [
                'default'   => 'translateX(0px) translateY(0px)',
                'hover'     => 'translateX(-50px) translateY(-50px)'
            ],
            'bottom_right'  => [
                'default'   => 'translateX(0px) translateY(0px)',
                'hover'     => 'translateX(50px) translateY(50px)'
            ],
            'bottom_left'   => [
                'default'   => 'translateX(0px) translateY(0px)',
                'hover'     => 'translateX(-50px) translateY(50px)'
            ]
        );
        return $transform_values[$key][$state];
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
            return sprintf('<div class="df_hb_button_wrapper">
                <a class="df_hb_button" href="%1$s" %3$s>%2$s</a>
            </div>', esc_attr($url), esc_html($text), $target);
        } else { return ''; }
    }

    /**
     * Render HTML markup
     * 
     * @param Null
     * @param String | HTML markup
     */
    public function df_hb_content() {
        $content_default = '';
        $content_hover = '';
        $title = $this->props['title'] !== '' ?
            sprintf('<%2$s class="title">%1$s</%2$s>', $this->props['title'], $this->props['title_tag']) : '';
        $sub_title = $this->props['sub_title'] !== '' ?
            sprintf('<%2$s class="subtitle">%1$s</%2$s>', $this->props['sub_title'], $this->props['subtitle_tag']) : '';
        $content = $this->props['content'] !== '' ?
            sprintf('<div class="content">%1$s</div>', $this->props['content']) : '';

        if ($this->props['title_on_hover'] === 'on') {
            $content_hover .= $title;
        } else {
            $content_default .= $title;
        }

        if ($this->props['subtitle_on_hover'] === 'on') {
            $content_hover .= $sub_title;
        } else {
            $content_default .= $sub_title;
        }

        if ($this->props['content_on_hover'] === 'on') {
            $content_hover .= $content;
        } else {
            $content_default .= $content;
        }

        if ($this->props['button_on_hover'] === 'on') {
            $content_hover .= $this->df_render_button('hb_btn');
        } else {
            $content_default .= $this->df_render_button('hb_btn');
        }

        $content_default_container = $content_default !== '' ?
            sprintf('<div class="df_hb_def_content">%1$s</div>', $content_default) : '';
        $content_hover_container = $content_hover !== '' ?
            sprintf('<div class="df_hb_def_content_hover">%1$s</div>', $content_hover) : '';

        return $content_default_container . $content_hover_container;
    }

    public function render( $attrs, $content, $render_slug ) {
        $this->additional_css_styles($render_slug);

        return sprintf('
            <div class="df_hb_container">
                <div class="df_hb_background"></div>
                <div class="df_hb_inner">
                    %1$s
                </div>
            </div>',
            $this->df_hb_content()
        );
    }
}
new DIFL_HoverBox;