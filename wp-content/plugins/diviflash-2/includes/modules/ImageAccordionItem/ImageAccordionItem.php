<?php

class DIFL_ImageAccordionItem extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_imageaccordionitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $child_title_var = 'title';
    public $child_title_fallback_var = 'admin_label';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Image Accordion Item', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'image'                    => esc_html__('Image', 'divi_flash'),
                    'main_content'              => esc_html__('Content', 'divi_flash'),
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'design_content'                  => esc_html__('Content', 'divi_flash'),
                    'design_icon'                  => esc_html__('Icon', 'divi_flash'),
                    'design_title'                  => esc_html__('Title', 'divi_flash'),
                    'design_sub_title'                  => esc_html__('Sub Title', 'divi_flash'),
                    'design_description'                  => esc_html__('Description', 'divi_flash'),
                    'button'                  => esc_html__('Button', 'divi_flash'),
                    'ia_hover'                  => esc_html__('Hover', 'divi_flash'),
                    'custom_spacing'            => array (
                        'title'             => esc_html__('Custom Spacing', 'divi_flash'),
                    )
                )
            ),
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
                    'main' => ".difl_imageaccordion %%order_class%% .df_ia_title ",
                    'hover' => ".difl_imageaccordion %%order_class%%:hover .df_ia_title",
                    'important' => 'all',
                ),
            ),
            'sub_title'   => array(
                'label'         => esc_html__('Sub Title', 'divi_flash'),
                'toggle_slug'   => 'design_sub_title',
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
                    'main' => ".difl_imageaccordion %%order_class%% .df_ia_sub_title ",
                    'hover' => ".difl_imageaccordion %%order_class%%:hover .df_ia_sub_title",
                    'important' => 'all',
                ),
            ),

            'description'   => array(
                'label'         => esc_html__('Description', 'divi_flash'),
                'toggle_slug'   => 'design_description',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'font-weight' => array(
                    'default' => 'semi-bold'
                ),
                'css'      => array(
                    'main' => ".difl_imageaccordion %%order_class%% .df_ia_description ",
                    'hover' => ".difl_imageaccordion %%order_class%%:hover .df_ia_description",
                    'important' => 'all',
                ),
            ),
            'button'   => array(
                'label'         => esc_html__('Button', 'divi_flash'),
                'toggle_slug'   => 'design_button',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => ".difl_imageaccordion %%order_class%% .df_ia_button ",
                    'hover' => ".difl_imageaccordion %%order_class%% .difl_imageaccordionitem .df_ia_button:hover",
                    'important' => 'all',
                ),
            ),
        );
        $advanced_fields['borders'] = array (
            'default' => array(
                'css' => array(
                    'main' => ".difl_imageaccordion {$this->main_css_element} > div",
                )
            ),
            'icon'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_imageaccordion {$this->main_css_element} .df-image-accordion-icon",
                        'border_styles' => ".difl_imageaccordion {$this->main_css_element} .df-image-accordion-icon",
                        'border_styles_hover' => ".difl_imageaccordion {$this->main_css_element} .df-image-accordion-icon:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'design_icon'
            ),
            'button'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_imageaccordion {$this->main_css_element} .df_ia_button",
                        'border_styles' => ".difl_imageaccordion {$this->main_css_element} .df_ia_button",
                        'border_styles_hover' => ".difl_imageaccordion {$this->main_css_element} .df_ia_button:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'button'
            ),
        );
        $advanced_fields['background'] = false;
        $advanced_fields['box_shadow'] = array(
            'default'   => false,
            'icon' => array(
                'css' => array(
                    'main' => ".difl_imageaccordion {$this->main_css_element} .df-image-accordion-icon",
                    'hover' => ".difl_imageaccordion {$this->main_css_element} .df-image-accordion-icon:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'design_icon'
            ),
            'button' => array(
                'css' => array(
                    'main' => ".difl_imageaccordion {$this->main_css_element} .df_ia_button",
                    'hover' => ".difl_imageaccordion {$this->main_css_element} .df_ia_button:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'button'
            )
        );
        $advanced_fields['max_width'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['transform'] = false;
    
        return $advanced_fields;
    }

    public function get_fields() {
        $general = array (
            'admin_label' => array (
                'label'           => esc_html__( 'Admin Label', 'divi_flash' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'admin_label',
                'default_on_front'=> 'Accordion Item'
            )
        );
        $icon_background = $this->df_add_bg_field(array(
            'label'                 => 'Icon Background',
            'key'                   => 'icon_background',
            'toggle_slug'           => 'design_icon',
            'tab_slug'              => 'advanced',
            'show_if' => array(
                'use_icon' => 'on'
            )
        ));
        $icon_settings = array(
            'use_icon'    => array(
                'label'             => esc_html__('Use Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'main_content'
            ),
            'use_image_as_icon'    => array(
                'label'             => esc_html__('Use Image as Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'main_content',
                'show_if'           => array(
                    'use_icon'     => 'on',
                )
            ),
            'image_as_icon' => array(
                'label'                 => esc_html__('Image', 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'upload_button_text'    => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'main_content',
                'dynamic_content'       => 'image',
                'show_if'         => array(
                    'use_icon'     => 'on',
                    'use_image_as_icon' => 'on'
                )

            ),
            'image_alt_text' => array (
                'label'                 => esc_html__( 'Image Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'main_content',
                'show_if'         => array(
                    'use_icon'     => 'on',
                    'use_image_as_icon' => 'on'
                )
            ),
            'image_as_icon_width' => array(
                'label'             => esc_html__('Image as Icon Width(%)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'design_icon',
                'tab_slug'          => 'advanced',
                'default_unit'      => 'px',
                'allowed_units'     => array('%', 'px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'show_if'           => array(
                    'use_icon'     => 'on',
                    'use_image_as_icon' => 'on'
                )
            ),
            
            'font_icon'                 => array(
				'label'                 => esc_html__( 'Icon', 'divi_flash' ),
				'type'                  => 'select_icon',
				'option_category'       => 'basic_option',
				'class'                 => array( 'et-pb-font-icon' ),
                'toggle_slug'           => 'main_content',
                'show_if'           => array(
                    'use_icon'      => 'on',
                    'use_image_as_icon' => 'off'
                )
            ),
            'icon_color'            => array (
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
                'toggle_slug'       => 'design_icon',
                'tab_slug'          => 'advanced',
                'hover'             => 'tabs',
                'show_if'           => array(
                    'use_icon'      => 'on',
                    'use_image_as_icon' => 'off'
                )
            ),
            'icon_size'             => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'toggle_slug'       => 'design_icon',
                'tab_slug'          => 'advanced',
                'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
                'responsive'        => true,
                'show_if'           => array(
                    'use_icon'      => 'on',
                    'use_image_as_icon' => 'off'
                )
            )
           
        );
        $icon_spacing = $this->add_margin_padding(array(
            'title'         => 'Icon',
            'key'           => 'icon',
            'toggle_slug'   => 'custom_spacing',
            'tab_slug'      => 'advanced'
        ));
        $content = array (
            'title' => array (
                'label'                 => esc_html__( 'Title', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'main_content',
                'dynamic_content'       => 'text'
            ),
            'sub_title' => array (
                'label'                 => esc_html__( 'Sub Title', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'main_content',
                'dynamic_content'       => 'text'
            ),
            'description' => array (
                'label'                 => esc_html__( 'Description', 'divi_flash' ),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Content entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'           => 'main_content',
                'dynamic_content'       => 'text'
            ),
            
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
                    'span'  => esc_html__( 'span tag', 'divi_flash'),
                    'div'  => esc_html__( 'div tag', 'divi_flash')
                ),
                'toggle_slug'   => 'main_content'
            ),
            'sub_title_tag' => array (
                'default'         => 'h5',
                'label'           => esc_html__( 'Sub Title Tag', 'divi_flash' ),
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
                'toggle_slug'   => 'main_content'
            )
        );
        $button = $this->df_add_btn_content(array (
            'key'                   => 'ia_button',
            'toggle_slug'           => 'main_content',
            'dynamic_option'        => true
        ));
        $image = $this->df_add_bg_field(array(
            'label'                 => 'Image',
            'key'                   => 'ia_image',
            'toggle_slug'           => 'image',
            'tab_slug'              => 'general',
            'order_reverse'         => true
        ));
        $button_style = $this->df_add_btn_styles(array (
            'key'                   => 'ia_btn',
            'toggle_slug'           => 'button',
            'tab_slug'              => 'advanced'
        ));
        $buttons_bg = $this->df_add_bg_field(array (
			'label'				    => 'Button Background',
            'key'                   => 'ia_btn_background',
            'toggle_slug'           => 'button',
            'tab_slug'              => 'advanced'
        ));

        $vertical_align = array (
            'vertical_align' => array (
                'default'         => 'none',
                'label'           => esc_html__( 'Content Vertical Align', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'none'    => esc_html__( 'Default', 'divi_flash' ),
                    'flex-start'    => esc_html__( 'Top', 'divi_flash' ),
                    'center'        => esc_html__( 'Center', 'divi_flash' ),
                    'flex-end'      => esc_html__( 'Bottom', 'divi_flash' ),
                ),
                'toggle_slug'     => 'design_content',
                'tab_slug'        => 'advanced'
            ),
            'content_alignment' => array(
                'label'           => esc_html__('Content Alignment', 'divi_flash'),
                'type'            => 'text_align',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'     => 'design_content',
                'tab_slug'    => 'advanced',
                'mobile_options'  => true       
            ),
        );
        
       
      
        $content_spacing = $this->add_margin_padding(array(
            'title'         => 'Content',
            'key'           => 'content',
            'toggle_slug'   => 'custom_spacing'
        ));
        
        $button_spacing = $this->add_margin_padding(array(
            'title'         => 'Button',
            'key'           => 'button',
            'toggle_slug'   => 'custom_spacing'
        ));
        
        return array_merge(
            $icon_background,
            $icon_settings,     
            $general,
            $image,   
            $content,
            $button,
            $button_style,
            $buttons_bg,
            $vertical_align,
            $content_spacing,
            $button_spacing,
            $icon_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $wrapper = '%%order_class%% > div';
        $button = "%%order_class%% .df_ia_button";
        $content = '%%order_class%% .content';
        $caption = '%%order_class%% .ic_caption';
        $icon = "%%order_class%% .df-image-accordion-icon";

        // spacing transition
        $fields['wrapper_margin'] = array ('margin' => $wrapper);
        $fields['wrapper_padding'] = array ('padding' => $wrapper);

        $fields['content_margin'] = array ('margin' => $content);
        $fields['content_padding'] = array ('padding' => $content);
        $fields['icon_margin'] = array ('margin' => $icon);
        $fields['icon_padding'] = array ('padding' => $icon);

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'icon_background',
            'selector'      => $icon
        ));
        
         // Color 
         $fields['icon_color'] = array('color' => $icon);

        // border transition fix
        $fields = $this->df_fix_border_transition(
            $fields, 
            'button', 
            '%%order_class%% .df_ia_button'
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'icon', 
            $icon
        );

        // Box shadow transition fix
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'icon',
            $icon
        );

        return $fields;
    }
    
    public function additional_css_styles($render_slug) {
        // Item Background
       
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'ia_image',
            'selector'          => ".difl_imageaccordion {$this->main_css_element}"
        ));
        
         // Item Icon
         if ('on' === $this->props['use_icon']) {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_color',
                'type'              => 'color',
                'selector'          => ".difl_imageaccordion %%order_class%% .et-pb-icon.df-image-accordion-icon",
                'hover'             => '.difl_imageaccordion %%order_class%% .et-pb-icon.df-image-accordion-icon:hover'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_size',
                'type'              => 'font-size',
                'default_unit'      => 'px',
                'selector'          => ".difl_imageaccordion %%order_class%% .et-pb-icon.df-image-accordion-icon",
                'hover'             => '.difl_imageaccordion %%order_class%% .et-pb-icon.df-image-accordion-icon:hover',
                'important'         => 'true'
            ));

            $this->df_process_bg(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_background',
                'selector'          => ".difl_imageaccordion %%order_class%% .df-image-accordion-icon",
                'hover'             => '.difl_imageaccordion %%order_class%% .df-image-accordion-icon:hover'
            ));
     
            // Icon spacing
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_margin',
                'type'              => 'margin',
                'selector'          => ".difl_imageaccordion {$this->main_css_element}.difl_imageaccordionitem .df-image-accordion-icon",
                'hover'             => ".difl_imageaccordion {$this->main_css_element}.difl_imageaccordionitem .df-image-accordion-icon:hover"
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_padding',
                'type'              => 'padding',
                'selector'          => ".difl_imageaccordion {$this->main_css_element}.difl_imageaccordionitem .df-image-accordion-icon",
                'hover'             => ".difl_imageaccordion {$this->main_css_element}.difl_imageaccordionitem .df-image-accordion-icon:hover"
            ));
        }

        if ('on' === $this->props['use_image_as_icon']) {
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'image_as_icon_width',
                'type'              => 'width',
                'selector'          => '.difl_imageaccordion %%order_class%% img.df-image-accordion-icon'
                ) 
            );
        }
        // button style
        $this->df_process_btn_styles(array (
            'render_slug'       => $render_slug,
            'slug'              => 'ia_btn',
            'selector'          => ".difl_imageaccordion {$this->main_css_element} .df_ia_button",
            'hover'             => ".difl_imageaccordion {$this->main_css_element} .df_ia_button:hover",
            'align_container'   => ".difl_imageaccordion {$this->main_css_element} .df_ia_button_wrapper"
        ));
        // button background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'ia_btn_background',
            'selector'          => ".difl_imageaccordion {$this->main_css_element} .df_ia_button",
            'hover'             => ".difl_imageaccordion {$this->main_css_element} .df_ia_button:hover"
        ));


        // Button spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => ".difl_imageaccordion {$this->main_css_element}.difl_imageaccordionitem .df_ia_button_wrapper",
            'hover'             => ".difl_imageaccordion {$this->main_css_element}.difl_imageaccordionitem .df_ia_button_wrapper:hover"
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => ".difl_imageaccordion {$this->main_css_element}.difl_imageaccordionitem .df_ia_button",
            'hover'             => ".difl_imageaccordion {$this->main_css_element}.difl_imageaccordionitem .df_ia_button:hover"
        ));

         // Content spacing
         $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_margin',
            'type'              => 'margin',
            'selector'          => ".difl_imageaccordion {$this->main_css_element}.difl_imageaccordionitem .content",
            'hover'             => ".difl_imageaccordion {$this->main_css_element}.difl_imageaccordionitem .content:hover"
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_padding',
            'type'              => 'padding',
            'selector'          => ".difl_imageaccordion {$this->main_css_element}.difl_imageaccordionitem .content",
            'hover'             => ".difl_imageaccordion {$this->main_css_element}.difl_imageaccordionitem .content:hover"
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => ".difl_imageaccordion {$this->main_css_element}",
            'declaration' => 'flex:1 1 0%;'
        ));
      
        // vertical algin
        if (isset($this->props['vertical_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => ".difl_imageaccordion {$this->main_css_element} .overlay_wrapper",
                'declaration' => sprintf('justify-content: %1$s;', $this->props['vertical_align'])
            ));
        }

        //content Alignment
        $this->df_process_string_attr( array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_alignment',
            'type'              => 'text-align',
            'selector'          => ".difl_imageaccordion %%order_class%% .content"
        ));

        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-image-accordion-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon'
                    ),
                )
            );
        
        }

    }
    
    public function df_render_image_icon()
    {
        if (isset($this->props['use_icon']) && $this->props['use_icon'] === 'on' && $this->props['use_image_as_icon'] ==='off') {

            return sprintf(
                '<span class="et-pb-icon df-image-accordion-icon">%1$s</span>',
                isset($this->props['font_icon']) && $this->props['font_icon'] !== '' ?
                    esc_attr(et_pb_process_font_icon($this->props['font_icon'])) : '1'
            );
        } else if (isset($this->props['use_image_as_icon']) && $this->props['use_image_as_icon'] === 'on') {
            
            $src = 'src';
            $image_alt = $this->props['image_alt_text'] !== '' ? $this->props['image_alt_text']  : df_image_alt_by_url($this->props['image_as_icon']);
            $image_url = $this->props['image_as_icon'];    
           
            return sprintf(
                '<img class="df-image-accordion-icon" %3$s="%1$s" alt="%2$s" />',
                $this->props['image_as_icon'],
                $image_alt,
                $src
            );
        }
    }
    public function render( $attrs, $content, $render_slug ) {
		$this->handle_fa_icon();
        $this->additional_css_styles($render_slug);
        $icon_html = $this->df_render_image_icon();
        $title_level  =  esc_attr($this->props['title_tag']);
        $sub_title_level  =  esc_attr($this->props['sub_title_tag']);
      
        $title_html = $this->props['title'] !== '' ?
            sprintf('<%1$s  class="df_ia_title anime_wrap">%2$s</%1$s >', $title_level, $this->props['title']) : '';
        $sub_title_html = $this->props['sub_title'] !== '' ?
            sprintf('<%1$s  class="df_ia_sub_title anime_wrap">%2$s</%1$s >', $sub_title_level, $this->props['sub_title']) : '';

        $pattern = "/<p[^>]*><\\/p[^>]*>/";
        $description = preg_replace($pattern, '', $this->props['description']);
        $description = $this->props['description'] !== '' ?
            sprintf('<div class="df_ia_description anime_wrap">%1$s</div>', $description ) : '';
        $content = sprintf('<div class="content">%5$s %1$s %2$s %3$s %4$s </div>', $title_html, $sub_title_html , $description , $this->df_render_button('ia_button') , $icon_html);
       
        
        $overlay_wrapper = sprintf('<div class="overlay_wrapper">%1$s</div>', $content);
      
        $image = sprintf('<div class="accordion-item">
                        <div class="overlay">
                            %1$s
                        </div>
                    </div>', $overlay_wrapper);
        
        return sprintf('<div class="df_iai_container">
                %1$s
            </div>', $image);
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
            return sprintf('<div class="df_ia_button_wrapper anime_wrap">
                <a class="df_ia_button" href="%1$s" %3$s>%2$s</a>
            </div>', esc_attr($url), esc_html($text), $target);
        } else { return ''; }
    }

}
new DIFL_ImageAccordionItem;