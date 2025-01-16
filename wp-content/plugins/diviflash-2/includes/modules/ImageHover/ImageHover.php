<?php

class DIFL_ImageHover extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_imagehover';
    public $vb_support = 'on';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Image Hover', 'et_builder' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/image-hover-box.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'image'     => esc_html__('Image', 'divi_flash'),
                    'icon'     => esc_html__('Icon', 'divi_flash'),
                    'hover'     => esc_html__('Hover Settings', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'image'     => esc_html__('Image', 'divi_flash'),
                    'icon'     => esc_html__('Icon', 'divi_flash'),
                    'title'     => esc_html__('Title', 'divi_flash')
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();
        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = array(
            'title'     => array(
                'label'         => esc_html__( 'Title', 'divi_flash' ),
                'toggle_slug'   => 'title',
                // 'sub_toggle'    => 'caption',
                'tab_slug'		=> 'advanced',
                // 'hide_text_shadow'  => true,
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '30px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ihb_title",
                    'hover' => "%%order_class%% .df_ihb_image_wrap:hover .df_ihb_title",
                    'important'	=> 'all'
                ),
            )
        );
        $advanced_fields['borders'] = array(
            'icon_wrapper_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} .ihb_icon_wrap",
                        'border_radii_hover' => "{$this->main_css_element} .df_ihb_container:hover .ihb_icon_wrap",
                        'border_styles' => "{$this->main_css_element} .ihb_icon_wrap",
                        'border_styles_hover' => "{$this->main_css_element} .df_ihb_container:hover .ihb_icon_wrap"
                    )
                ),
                'label'    => esc_html__('Icon Wrapper Border', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'icon',
            )
         );

         $advanced_fields['box_shadow'] = array(
            'icon_wrapper_shadow'             => array(
                'label'    => esc_html__('Icon Wrapper Box Shadow', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% .ihb_icon_wrap",
                    'hover' => "%%order_class%% .df_ihb_container:hover .ihb_icon_wrap",
                    'important' => 'all'
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'icon'
            )

        );
        $advanced_fields["filters"] = array(
			'child_filters_target' => array(
				'tab_slug' => 'advanced',
				'toggle_slug' => 'image',
				'css' => array(
					'main' => '%%order_class%% img',
					'hover' => '%%order_class%%:hover img'
				),
			),
        );
        $advanced_fields['image'] = array(
			'css' => array(
				'main' => array(
					'%%order_class%% img',
				)
			),
		);
    
        return $advanced_fields;
    }

    public function get_fields() {
        $general = array (
            'image' => array (
                'label'                 => esc_html__( 'Image', 'divi_flash' ),
				'type'                  => 'upload',
                'option_category'       => 'basic_option',
				'upload_button_text'    => esc_attr__( 'Upload an image', 'divi_flash' ),
				'choose_text'           => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'           => esc_attr__( 'Set As Image', 'divi_flash' ),
                'toggle_slug'           => 'image',
                'dynamic_content'       => 'image',
            ),
            'alt' => array (
                'label'                 => esc_html__( 'Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'image'
            ),
            'title_text'          => array(
				'label'           => esc_html__( 'Image Title Text', 'divi_flash' ),
				'type'            => 'text',
				'description'     => esc_html__( 'This defines the HTML Title text.', 'divi_flash' ),
				'toggle_slug'     => 'image',
				'dynamic_content' => 'text',
            ),
            'use_icon'                  => array(
				'label'                 => esc_html__( 'Use Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => 'icon',
                'affects'               => array (
                    'font_icon',
                    'icon_color',
                    'icon_size'
				)
            ),
        
            'font_icon'                 => array(
				'label'                 => esc_html__( 'Icon', 'divi_flash' ),
				'type'                  => 'select_icon',
				'option_category'       => 'basic_option',
				'class'                 => array( 'et-pb-font-icon' ),
                'toggle_slug'           => 'icon',
                'depends_show_if'       => 'on'
            ),
            'title_tag' => array (
                'default'         => 'h3',
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
            )
        );
        $hover_settings = array (
            'overlay'    => array(
                'label'         => esc_html__('Overlay', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'hover',
            ),
            'overlay_primary'  => array(
                'label'             => esc_html__( 'Overlay Primary color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'hover',
                'default'           => '#00B4DB',
                'show_if'           => array(
                    'overlay'  => 'on'
                )
            ),
            'overlay_secondary'  => array(
                'label'             => esc_html__( 'Overlay Secondary color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'hover',
                'default'           => '#0083B0',
                'show_if'           => array(
                    'overlay'  => 'on'
                )
            ),
            'overlay_direction'    => array (
                'label'             => esc_html__( 'Overlay Gradient Direction', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'hover',
                'default'           => '180deg',
                'default_unit'      => 'deg',
                'allowed_units'     => array ('deg'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '360',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if'           => array(
                    'overlay'  => 'on'
                )
            ),
            'border_anim'    => array(
                'label'         => esc_html__('Border Animation', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'hover'
            ),
            'anm_border_color'  => array(
                'label'             => esc_html__( 'Border Color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'hover',
                'default'           => '#ffffff',
                'show_if'           => array(
                    'border_anim'  => 'on'
                )
            ),
            'anm_border_width'    => array (
                'label'             => esc_html__( 'Border Width', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'hover',
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
                    'border_anim'  => 'on'
                )
            ),
            'anm_border_margin'    => array (
                'label'             => esc_html__( 'Border Space', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'hover',
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
                    'border_anim'  => 'on'
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
                    'c4-border-left'            => esc_html__('Border Left', 'divi_flash'),
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
                'toggle_slug'   => 'hover',
                'show_if'       => array(
                    'border_anim'   => 'on'
                )
            ),
            'anm_content_padding'    => array (
                'label'             => esc_html__( 'Content Space', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'hover',
                'default'           => '1em',
                'default_unit'      => '',
                'allowed_units'     => array ('em'),
                'range_settings'    => array(
                    'min'  => '.5',
                    'max'  => '3',
                    'step' => '.1',
                ),
                'mobile_options'    => true
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
                'toggle_slug'   => 'hover'
            ),
            'image_scale'    => array(
                'label'    => esc_html__('Image Scale Type', 'divi_flash'),
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
                'toggle_slug'   => 'hover'
            ),
            'image_scale_hover'    => array (
                'label'             => esc_html__( 'Scale', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'hover',
                'default'           => '1.3',
                'allowed_units'     => array (),
                'range_settings'    => array(
                    'min'  => '1.3',
                    'max'  => '3',
                    'step' => '.1',
                ),
                'validate_unit'    => false,
                'show_if'          => array (
                    'image_scale' => array( 'c4-image-rotate-left', 'c4-image-rotate-right')
                )
            ),
            'always_show_title'  => array(
                'label'         => esc_html__('Always Show Title', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'hover'
            ),
            'content_reveal_title'    => array(
                'label'    => esc_html__('Title Reveal', 'divi_flash'),
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
                'toggle_slug'   => 'hover',
                'show_if_not'   => array(
                    'always_show_title' => 'on'
                )
            ),
            'title_anim_delay'      => array (
                'label'             => esc_html__( 'Title animation delay (ms)', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'hover',
                'default'           => '0',
                'allowed_units'     => array (),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '2000',
                    'step' => '50',
                ),
                'validate_unit'    => false,
                'show_if_not'   => array(
                    'always_show_title' => 'on'
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
                'toggle_slug'   => 'hover'
            ),
            'icon_anim_delay'      => array (
                'label'             => esc_html__( 'Icon animation delay (ms)', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'hover',
                'default'           => '0',
                'allowed_units'     => array (),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '2000',
                    'step' => '50',
                ),
                'validate_unit'    => false,
                'show_if_not'   => array(
                    'always_show_icon' => 'on'
                )
            ),
            'content_reveal_icon'    => array(
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
                'toggle_slug'   => 'hover',
                'show_if_not'   => array(
                    'always_show_icon' => 'on'
                )
            )
        );
        $image = array(
            'icon_color'            => array (
				'default'           => "#2ea3f2",
				// 'default_on_front'	=> true,
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'icon',
                'hover'             => 'tabs'
                // 'mobile_options'    => true,
                // 'responsive'        => true
            ),
            'icon_size'             => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'icon',
				'default'           => '96px',
				'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
				'responsive'        => true
            )
         
        );
        $icon_background = $this->df_add_bg_field(array(
            'label'                 => 'Icon Background',
            'key'                   => 'icon_background_color',
            'toggle_slug'           => 'icon',
            'tab_slug'              => 'advanced',
            'hover'                 => 'tabs',
            'show_if'               => array(
                'use_icon' => 'on'
            )
        ));

        $title_spacing = $this->add_margin_padding(array(
            'title'         => 'Title',
            'key'           => 'title',
            'toggle_slug'   => 'margin_padding',
            'option'        => 'margin'
        ));
        $icon_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Icon Wrapper',
            'key'           => 'icon_wrapper',
            'toggle_slug'   => 'margin_padding',
            'option'        => 'margin'
        ));
        $icon_spacing = $this->add_margin_padding(array(
            'title'         => 'Icon',
            'key'           => 'icon',
            'toggle_slug'   => 'margin_padding',
            'option'        => 'margin'
        ));
        return array_merge(
            $general,
            $hover_settings,
            $image,
            $icon_background,
            $title_spacing,
            $icon_wrapper_spacing,
            $icon_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $icon_wrapper   = '%%order_class%% .ihb_icon_wrap';
        $fields['icon_color'] = array('color' => '%%order_class%% .et-pb-icon');
        $fields['title_margin'] = array('magin' => '%%order_class%% .df_ihb_title');
        $fields['icon_margin'] = array('magin' => '%%order_class%% .et-pb-icon');
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'icon_background_color',
            'selector'      => $icon_wrapper
        ));
        // border fix
        $fields = $this->df_fix_border_transition(
            $fields, 
            'icon_wrapper_border', 
            $icon_wrapper
        );
  
        return $fields;
    }
    
    public function additional_css_styles($render_slug) {

        if($this->props['overlay'] !== 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .c4-izmir',
                'declaration' => '--image-opacity: 1;'
            ));
        }
        if($this->props['overlay'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .c4-izmir .df-overlay',
                'declaration' => sprintf('background-image: linear-gradient(%4$s, %1$s 0, %2$s %3$s);',
                    $this->props['overlay_primary'],
                    $this->props['overlay_secondary'],
                    '100%',
                    $this->props['overlay_direction']
                )
            ));
        }

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

        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'anm_content_padding',
            'type'              => '--padding',
            'selector'          => '%%order_class%% .c4-izmir'
        ) );

        if ($this->props['image_scale'] === 'c4-image-rotate-left') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .c4-image-rotate-left:hover img, %%order_class%% :focus.c4-image-rotate-left img',
                'declaration' => sprintf('transform: scale(%1$s) rotate(-15deg);', $this->props['image_scale_hover'])
            ));
        }
        if ($this->props['image_scale'] === 'c4-image-rotate-right') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .c4-image-rotate-right:hover img, %%order_class%% :focus.c4-image-rotate-right img',
                'declaration' => sprintf('transform: scale(%1$s) rotate(15deg);', $this->props['image_scale_hover'])
            ));
        }

        // icon
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .et-pb-icon',
            'hover'             => '%%order_class%%:hover .et-pb-icon'
        ));
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_size',
            'type'              => 'font-size',
            'selector'          => '%%order_class%% .et-pb-icon'
        ) );

        // Icon background
        if ( $this->props['use_icon'] !== 'off' ) {

            $this->df_process_bg(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_background_color',
                'type'              => 'background-color',
                'selector'          => "%%order_class%% .ihb_icon_wrap",
                'hover'             => '%%order_class%% .df_ihb_container:hover .ihb_icon_wrap'
            ));
        }

        if(isset($this->props['title_anim_delay']) && $this->props['title_anim_delay'] !== '0' && $this->props['always_show_title'] !== 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .ihb_title_wrap, %%order_class%% .ihb_title_wrap > *',
                'declaration' => sprintf('transition-delay: %1$sms;', $this->props['title_anim_delay'])
            ));
        }
        if(isset($this->props['icon_anim_delay']) && $this->props['icon_anim_delay'] !== '0' && $this->props['always_show_icon'] !== 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .ihb_icon_wrap, %%order_class%% .ihb_icon_wrap > *',
                'declaration' => sprintf('transition-delay: %1$sms;', $this->props['icon_anim_delay'])
            ));
        }

        // spacing: title
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_ihb_title',
            'hover'             => '%%order_class%%:hover .df_ihb_title',
        ));
         // spacing: icon wrapper
         $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .ihb_icon_wrap',
            'hover'             => '%%order_class%% .df_ihb_container:hover .ihb_icon_wrap'
        ));
        // spacing: icon
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .et-pb-icon',
            'hover'             => '%%order_class%%:hover .et-pb-icon',
        ));
        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }    
    }

    public function render( $attrs, $content, $render_slug ) {
		$this->handle_fa_icon();
        $this->additional_css_styles($render_slug);

        $title_reveal_class = $this->props['always_show_title'] === 'on' ? 
            'always-show-title c4-fade-up' : $this->props['content_reveal_title'];
        $icon_reveal_class = $this->props['always_show_icon'] === 'on' ? 
            'always-show-title c4-fade-up' : $this->props['content_reveal_icon'];
        $image_alt = $this->props['alt'] !== '' ? $this->props['alt']  : df_image_alt_by_url($this->props['image']);

        $image = '' !== $this->props['image'] ?
            sprintf('<img src="%1$s" alt="%2$s" />', 
                esc_attr($this->props['image']), 
                esc_attr($image_alt)
            ) : '';
        $title_text = '' !== $this->props['title_text'] ?
            sprintf('<div class="ihb_title_wrap %3$s"><%2$s class="df_ihb_title">%1$s</%2$s></div>', 
                esc_html($this->props['title_text']),
                esc_attr($this->props['title_tag']),
                esc_attr($title_reveal_class)
            ) : '';
        $icon = isset($this->props['use_icon']) && $this->props['use_icon'] === 'on' ?
                sprintf('<div class="ihb_icon_wrap %2$s"><span class="et-pb-icon">%1$s</span></div>', 
                    isset($this->props['font_icon']) && $this->props['font_icon'] !== '' ? 
                        esc_attr(et_pb_process_font_icon( $this->props['font_icon'] )) : '5',
                    esc_attr($icon_reveal_class)
                ) : '';

        // filter for images
		if (array_key_exists('image', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['image'])) {
			$this->add_classname($this->generate_css_filters(
				$render_slug,
				'child_',
				self::$data_utils->array_get($this->advanced_fields['image']['css'], 'main', '%%order_class%%')
			));
		}
        
        return sprintf('<div class="df_ihb_container %7$s">
                <figure class="c4-izmir df_ihb_image_wrap %5$s">
                    %4$s
                    %1$s
                    <figcaption class="df_ihb_content %6$s">
                        %3$s
                        %2$s
                    </figcaption>
                </figure>
            </div>', 
            $image, 
            $title_text,
            $icon,
            $this->props['overlay'] === 'on' ? '<span class="df-overlay"></span>' : '',
            $this->props['border_anim'] === 'on' ? esc_attr($this->props['border_anm_style']) : '',
            esc_attr($this->props['content_position']),
            esc_attr($this->props['image_scale'])
        );
    }
}
new DIFL_ImageHover;