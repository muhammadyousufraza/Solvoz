<?php

class DIFL_ImageCarouselItem extends ET_Builder_Module {
    public $slug       = 'difl_imagecarouselitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $child_title_var = 'admin_label';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Image Carousel Item', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'image'                     => esc_html__('Image', 'divi_flash'),
                    'button'                    => esc_html__('Button', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'ic_overlay'                => esc_html__('Overlay', 'divi_flash'),
                    'ic_hover'                  => esc_html__('Hover', 'divi_flash'),
                    'caption'                   => esc_html__('Caption', 'divi_flash'),
                    'button'                    => esc_html__('Button', 'divi_flash'),
                    'custom_spacing'            => array (
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

        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = array (
            'caption'     => array(
                'label'         => esc_html__( 'Caption', 'divi_flash' ),
                'toggle_slug'   => 'caption',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => ".difl_imagecarousel {$this->main_css_element} .ic_caption",
                    'hover' => ".difl_imagecarousel {$this->main_css_element} .ic_caption:hover",
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
                    'main' => ".difl_imagecarousel {$this->main_css_element} .df_ic_button",
                    'hover' => ".difl_imagecarousel {$this->main_css_element} .df_ic_button:hover",
                    'important'	=> 'all'
                ),
            )
        );
        $advanced_fields['borders'] = array (
            'default' => array(
                'css' => array(
                    'main' => ".difl_imagecarousel {$this->main_css_element} > div",
                )
            ),
            'button'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_imagecarousel {$this->main_css_element} .df_ic_button",
                        'border_styles' => ".difl_imagecarousel {$this->main_css_element} .df_ic_button",
                        'border_styles_hover' => ".difl_imagecarousel {$this->main_css_element} .df_ic_button:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'button'
            ),
        );
        $advanced_fields['background'] = array(
            'css'   => array(
                'main'  => ".difl_imagecarousel {$this->main_css_element}.difl_imagecarouselitem > div"
            )
        );
        $advanced_fields['box_shadow'] = array(
            'default'   => false,
            'button' => array(
                'css' => array(
                    'main' => ".difl_imagecarousel {$this->main_css_element} .df_ic_button",
                    'hover' => ".difl_imagecarousel {$this->main_css_element} .df_ic_button:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'button'
            )
        );
        $advanced_fields['max_width'] = false;
    
        return $advanced_fields;
    }

    public function get_fields() {
        $general = array (
            'admin_label' => array (
                'label'           => esc_html__( 'Admin Label', 'divi_flash' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'admin_label',
                'default_on_front'=> 'Carousel Item'
            )
        );
        $image = array (
            'image' => array (
                'label'                 => esc_html__( 'Image', 'divi_flash' ),
				'type'                  => 'upload',
                'option_category'       => 'basic_option',
				'upload_button_text'    => esc_attr__( 'Upload an image', 'divi_flash' ),
				'choose_text'           => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'           => esc_attr__( 'Set As Image', 'divi_flash' ),
                'toggle_slug'           => 'image',
                'dynamic_content'       => 'image'
            ),
            'alt_text' => array (
                'label'                 => esc_html__( 'Image Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'image'
            ),
            'caption' => array (
                'label'                 => esc_html__( 'Image Caption', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'image',
                'dynamic_content'       => 'text'
            ),
            'caption_tag' => array (
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
                'toggle_slug'     => 'caption',
                'tab_slug'        => 'advanced'
            )
        );
        $overlay_wrapper = $this->df_add_bg_field(array (
			'label'				    => 'Overlay',
            'key'                   => 'ic_overlay_background',
            'toggle_slug'           => 'ic_overlay',
            'tab_slug'              => 'advanced',
            'image'                 => false
        ));
        $vertical_align = array (
            'vertical_align' => array (
                'default'         => 'default',
                'label'           => esc_html__( 'Content Vertical Align', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'flex-start'    => esc_html__( 'Top', 'divi_flash' ),
                    'center'        => esc_html__( 'Center', 'divi_flash' ),
                    'flex-end'      => esc_html__( 'Bottom', 'divi_flash' ),
                    'default'       => esc_html__( 'Default', 'divi_flash' )
                ),
                'toggle_slug'     => 'ic_overlay',
                'tab_slug'        => 'advanced'
            )
        );
        $hover_settings = array (
            'content_hover'  => array (
                'label'             => esc_html__('Enable content on hover', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'divi_flash' ),
                    'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'ic_hover',
                'tab_slug'          => 'advanced'
            ),
            'anim_direction' => array (
                'default'         => 'top',
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
                'toggle_slug'     => 'ic_hover',
                'tab_slug'        => 'advanced',
                'show_if'         => array (
                    'content_hover'     => 'on'
                )
            )
        );
        $button = $this->df_add_btn_content(array (
            'key'                   => 'ic_button',
            'toggle_slug'           => 'button',
            'dynamic_option'        => true
        ));
        $button_style = $this->df_add_btn_styles(array (
            'key'                   => 'ic_btn',
            'toggle_slug'           => 'button',
            'tab_slug'              => 'advanced'
        ));
        $buttons_bg = $this->df_add_bg_field(array (
			'label'				    => 'Button Background',
            'key'                   => 'ic_btn_background',
            'toggle_slug'           => 'button',
            'tab_slug'              => 'advanced'
        ));
        $wrapper = $this->add_margin_padding(array(
            'title'         => 'Wrapper',
            'key'           => 'wrapper',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $content_spacing = $this->add_margin_padding(array(
            'title'         => 'Content Area',
            'key'           => 'content',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'wrapper'
        ));
        $caption_spacing = $this->add_margin_padding(array(
            'title'         => 'Caption',
            'key'           => 'caption',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        $button_spacing = $this->add_margin_padding(array(
            'title'         => 'Button',
            'key'           => 'button',
            'toggle_slug'   => 'custom_spacing',
            'sub_toggle'    => 'content'
        ));
        
        return array_merge(
            $general,
            $image,
            $overlay_wrapper,
            $vertical_align,
            $hover_settings,
            $button,
            $button_style,
            $buttons_bg,
            $wrapper,
            $content_spacing,
            $caption_spacing,
            $button_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $overlay_wrapper = '%%order_class%% .difl_imagecarouselitem .overlay_wrapper';
        $wrapper = '%%order_class%% > div';
        $button = "%%order_class%% .df_ic_button";
        $content = '%%order_class%% .content';
        $caption = '%%order_class%% .ic_caption';

        $fields['wrapper_margin'] = array ('margin' => $wrapper);
        $fields['wrapper_padding'] = array ('padding' => $wrapper);

        $fields['content_margin'] = array ('margin' => $content);
        $fields['content_padding'] = array ('padding' => $content);

        $fields['caption_margin'] = array ('margin' => $caption);
        $fields['caption_padding'] = array ('padding' => $caption);
        
        $fields['button_margin'] = array ('margin' => $button);
        $fields['button_padding'] = array ('padding' => $button);

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'ic_overlay_background',
            'selector'      => $overlay_wrapper
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'ic_btn_background',
            'selector'      => $button
        ));

        // border transition fix
        $fields = $this->df_fix_border_transition(
            $fields, 
            'button', 
            '%%order_class%% .df_ic_button'
        );

        return $fields;
    }
    
    public function additional_css_styles($render_slug) {

        // overlay
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "ic_overlay_background",
            'selector'          => ".difl_imagecarousel {$this->main_css_element} .overlay_wrapper",
            'hover'             => ".difl_imagecarousel {$this->main_css_element}:hover .overlay_wrapper"
        ));
        // button
        // button style
        $this->df_process_btn_styles(array (
            'render_slug'       => $render_slug,
            'slug'              => 'ic_btn',
            'selector'          => ".difl_imagecarousel {$this->main_css_element} .df_ic_button",
            'hover'             => ".difl_imagecarousel {$this->main_css_element} .df_ic_button:hover",
            'align_container'   => ".difl_imagecarousel {$this->main_css_element} .df_ic_button_wrapper"
        ));
        // button background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => 'ic_btn_background',
            'selector'          => ".difl_imagecarousel {$this->main_css_element} .df_ic_button",
            'hover'             => ".difl_imagecarousel {$this->main_css_element} .df_ic_button:hover"
        ));
        // wrapper spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_margin',
            'type'              => 'margin',
            'selector'          => ".difl_imagecarousel {$this->main_css_element}.difl_imagecarouselitem > div",
            'hover'             => ".difl_imagecarousel {$this->main_css_element}.difl_imagecarouselitem > div:hover",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_padding',
            'type'              => 'padding',
            'selector'          => ".difl_imagecarousel {$this->main_css_element}.difl_imagecarouselitem > div",
            'hover'             => ".difl_imagecarousel {$this->main_css_element}.difl_imagecarouselitem > div:hover",
        ));
        // content spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_margin',
            'type'              => 'margin',
            'selector'          => ".difl_imagecarousel {$this->main_css_element} .content",
            'hover'             => ".difl_imagecarousel {$this->main_css_element} .content:hover",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_padding',
            'type'              => 'padding',
            'selector'          => ".difl_imagecarousel {$this->main_css_element} .content",
            'hover'             => ".difl_imagecarousel {$this->main_css_element} .content:hover",
        ));
        // caption spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'caption_margin',
            'type'              => 'margin',
            'selector'          => ".difl_imagecarousel {$this->main_css_element} .ic_caption",
            'hover'             => ".difl_imagecarousel {$this->main_css_element} .ic_caption:hover",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'caption_padding',
            'type'              => 'padding',
            'selector'          => ".difl_imagecarousel {$this->main_css_element} .ic_caption",
            'hover'             => ".difl_imagecarousel {$this->main_css_element} .ic_caption:hover",
        ));
        // Button spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => ".difl_imagecarousel {$this->main_css_element} .df_ic_button",
            'hover'             => ".difl_imagecarousel {$this->main_css_element} .df_ic_button:hover"
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => ".difl_imagecarousel {$this->main_css_element} .df_ic_button",
            'hover'             => ".difl_imagecarousel {$this->main_css_element} .df_ic_button:hover",
        ));
        // vertical algin
        if (isset($this->props['vertical_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => ".difl_imagecarousel {$this->main_css_element} .overlay_wrapper",
                'declaration' => sprintf('justify-content: %1$s;', $this->props['vertical_align'])
            ));
        }
        // transform styles
        if ($this->props['content_hover'] === 'on' && isset($this->props['anim_direction'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => ".difl_imagecarousel {$this->main_css_element} .content",
                'declaration' => sprintf('opacity: 0; transform: %1$s;', 
                    $this->df_transform_values($this->props['anim_direction'], 'default'))
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => ".difl_imagecarousel {$this->main_css_element}:hover .content",
                'declaration' => sprintf('opacity: 1; transform: %1$s;', 
                    $this->df_transform_values($this->props['anim_direction'], 'hover'))
            ));
        }

    }

    public function render( $attrs, $content, $render_slug ) {
	    if ( empty( $attrs['image'] ) ) {
		    return;
	    }

        $this->additional_css_styles($render_slug);
        
        array_push($this->classname, 'swiper-slide');

        $parent_module = isset(self::get_parent_modules('page')['difl_imagecarousel']) ? self::get_parent_modules('page') ['difl_imagecarousel']: new stdClass;

        $src = 'src';
        $image_alt_text = $this->props['alt_text'] !== '' ? $this->props['alt_text']  : df_image_alt_by_url($this->props['image']);
        $image = $this->props['image'] !== '' ?
            sprintf('<div class="ic_image_wrapper"><img class="df-ic-image" %3$s="%1$s" alt="%2$s" /></div>',esc_attr($this->props['image']), esc_attr($image_alt_text), $src) : '';
        

        $caption = $this->props['caption'] !== '' ? sprintf('<%2$s class="ic_caption">%1$s</%2$s>', esc_attr($this->props['caption']), esc_attr($this->props['caption_tag'])) : '';
        $content = $caption !== '' || $this->df_render_button('ic_button') !== '' ?
            sprintf('<div class="content">%1$s %2$s</div>',$caption, $this->df_render_button('ic_button')) : '';
        $overlay_wrapper = sprintf('<div class="overlay_wrapper">%1$s</div>', $content);

        $lightbox_caption = $this->props['caption'] !== '' && $parent_module->props['use_lightbox_caption'] === 'on'? 
            'data-sub-html=".ic_caption"' : '';

        return sprintf('%5$s%6$s %7$s%8$s<div class="df_ici_container" data-src="%3$s" %4$s>
                %1$s%2$s
            </div>', 
            $image, 
            $overlay_wrapper,
            esc_attr($this->props['image']),
            $lightbox_caption,
            isset($parent_module->props['background_enable_pattern_style']) ? $this->df_render_pattern_or_mask_html($parent_module->props['background_enable_pattern_style'], 'pattern') : '',
            isset($parent_module->props['background_enable_mask_style']) ? $this->df_render_pattern_or_mask_html($parent_module->props['background_enable_mask_style'], 'mask') : '',
            isset($this->props['background_enable_pattern_style']) ? $this->df_render_pattern_or_mask_html($this->props['background_enable_pattern_style'], 'pattern') : '',
            isset($this->props['background_enable_mask_style']) ? $this->df_render_pattern_or_mask_html($this->props['background_enable_mask_style'], 'mask') : ''
        );
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
            return sprintf('<div class="df_ic_button_wrapper">
                <a class="df_ic_button" href="%1$s" %3$s>%2$s</a>
            </div>', esc_attr($url), esc_html($text), $target);
        } else { return ''; }
    }

    /**
     * Get transform values
     * 
     * @param String $key
     * @param String | State
     */
    public function df_transform_values($key = 'top', $state = 'default') {
        $transform_values = array (
            'top'           => [
                'default'   => 'translateY(-60px)',
                'hover'     => 'translateY(0px)'
            ],
            'bottom'        => [
                'default'   => 'translateY(60px)',
                'hover'     => 'translateY(0px)'
            ],
            'left'          => [
                'default'   => 'translateX(-60px)',
                'hover'     => 'translateX(0px)'
            ],
            'right'         => [
                'default'   => 'translateX(60px)',
                'hover'     => 'translateX(0px)'
            ],
            'center'        => [
                'default'   => 'scale(0)',
                'hover'     => 'scale(1)'
            ],
            'top_right'     => [
                'default'   => 'translateX(50px) translateY(-50px)',
                'hover'     => 'translateX(0px) translateY(0px)'
            ],
            'top_left'      => [
                'default'   => 'translateX(-50px) translateY(-50px)',
                'hover'     => 'translateX(0px) translateY(0px)'
            ],
            'bottom_right'  => [
                'default'   => 'translateX(50px) translateY(50px)',
                'hover'     => 'translateX(0px) translateY(0px)'
            ],
            'bottom_left'   => [
                'default'   => 'translateX(-50px) translateY(50px)',
                'hover'     => 'translateX(0px) translateY(0px)'
            ]
        );
        return $transform_values[$key][$state];
    }
}
new DIFL_ImageCarouselItem;