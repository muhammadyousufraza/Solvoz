<?php

class DIFL_BlogCarousel extends ET_Builder_Module_Type_PostBased {
    public $slug       = 'difl_blogcarousel';
    public $vb_support = 'on';
    public $child_slug = 'difl_postitem';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Post Carousel', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/blogcarousel.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'settings'              => esc_html__('Post Settings', 'divi_flash'),
                    'carousel_settings'     => esc_html__('Carousel Settings', 'divi_flash'),
                    'advanced_settings'     => esc_html__('Advanced Settings', 'divi_flash'),
                    'item_background'       => esc_html__('Item Background', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'content_align'         => esc_html__('Alignment', 'divi_flash'),
                    // 'layout'                => esc_html__('Layout', 'divi_flash'),
                    'item_outer_wrapper'    => esc_html__('Item Outer Wrapper', 'divi_flash'),
                    'item_inner_wrapper'    => esc_html__('Item Inner Wrapper', 'divi_flash'),
                    'arrows'                => esc_html__('Arrows', 'divi_flash'),
                    'dots'                  => esc_html__('Dots', 'divi_flash'),
                    'df_overflow'           => esc_html__( 'Overflow', 'divi_flash' )
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();
        $advanced_fields['text'] = false;
        $advanced_fields['link_options'] = false;

        $advanced_fields['fonts'] = array(
            // 'default'   => false,
        );

        $advanced_fields['borders'] = array (
            'item_outer'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-post-outer-wrap',
                        'border_radii_hover' => '%%order_class%% .df-post-outer-wrap:hover',
                        'border_styles' => '%%order_class%% .df-post-outer-wrap',
                        'border_styles_hover' => '%%order_class%% .df-post-outer-wrap:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_outer_wrapper',
                'label_prefix'      => 'Item'
            ),
            'item'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-post-inner-wrap',
                        'border_radii_hover' => '%%order_class%% .df-post-inner-wrap:hover',
                        'border_styles' => '%%order_class%% .df-post-inner-wrap',
                        'border_styles_hover' => '%%order_class%% .df-post-inner-wrap:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_inner_wrapper',
                'label_prefix'      => 'Item'
            )
        );

        $advanced_fields['box_shadow'] = array(
            'item_outer'      => array(
                'css' => array(
                    'main' => "%%order_class%% .df-post-outer-wrap",
                    'hover' => "%%order_class%% .df-post-outer-wrap:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_outer_wrapper'
            ),
            'item'      => array(
                'css' => array(
                    'main' => "%%order_class%% .df-post-inner-wrap",
                    'hover' => "%%order_class%% .df-post-inner-wrap:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_inner_wrapper'
            )
        );

        $advanced_fields['transform'] = false;
        $advanced_fields['filters'] = false;
    
        return $advanced_fields;
    }

    public function get_fields() {
        $alignment = array(
            'alignment' => array (
                'label'             => esc_html__( 'Alignment', 'divi_flash' ),
				'type'              => 'text_align',
				'options'           => et_builder_get_text_orientation_options(array('justified')),
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'content_align',
                'responsive'        => true,
                'mobile_options'    => true
            )
        );
        $settings = array (
            'use_current_loop'              => array(
				'label'            => esc_html__( 'Posts For Current Page', 'et_builder' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => et_builder_i18n( 'Yes' ),
					'off' => et_builder_i18n( 'No' ),
				),
				'description'      => esc_html__( 'Display posts for the current page. Useful on archive and index pages.', 'et_builder' ),
				'toggle_slug'      => 'settings',
				'default'          => 'off',
				'show_if'          => array(
					'function.isTBLayout' => 'on',
				),
			),
            'posts_number'                  => array(
				'label'            => esc_html__( 'Post Count', 'divi_flash' ),
				'type'             => 'text',
				'description'      => esc_html__( 'Choose how much posts you would like to display per page.', 'divi_flash' ),
				'toggle_slug'      => 'settings',
				'default'          => 10,
            ),
            'post_display'   => array(
                'label'             => esc_html__('Display Post By', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'recent'        => esc_html__('Recent', 'divi_flash'),
                    'by_category'   => esc_html__('By Category', 'divi_flash'),
                    'by_tag'        => esc_html__('By Tag', 'divi_flash')
                ),
                'default'           => 'recent',
                'toggle_slug'       => 'settings',
                'show_if_not'       => array(
					'use_current_loop' => 'on'
				)
            ),
            'include_categories'   => array(
				'label'            => esc_html__( 'Include Categories', 'divi_flash' ),
				'type'             => 'categories',
				'renderer_options' => array(
					'use_terms'    => true,
					'term_name'    => 'category',
				),
				'taxonomy_name'    => 'category',
				'toggle_slug'      => 'settings',
				'show_if'         => array(
					'post_display' => 'by_category',
					// 'post_type' => 'post'
				),
				'show_if_not'       => array(
					'use_current_loop' => 'on'
				)
            ),
            'include_tags'   => array(
				'label'            => esc_html__( 'Include Tags', 'divi_flash' ),
				'type'             => 'categories',
				'renderer_options' => array(
					'use_terms'    => true,
					'term_name'    => 'post_tag',
				),
				'taxonomy_name'    => 'post_tag',
				'toggle_slug'      => 'settings',
				'show_if'         => array(
					'post_display' => 'by_tag',
					// 'post_type' => 'post'
				),
				'show_if_not'       => array(
					'use_current_loop' => 'on'
				)
            ),
            'orderby' => array(
				'label'             => esc_html__( 'Orderby', 'dg-blog-module' ),
				'type'              => 'select',
				'options'           => array(
					'1' => esc_html__( 'Newest to oldest', 'dg-blog-module' ),
					'2' => esc_html__( 'Oldest to newest', 'dg-blog-module' ),
					'3' => esc_html__( 'Random', 'dg-blog-module' ),
				),
				'default'			=> '1',
				'toggle_slug'       => 'settings',
				'show_if_not'         => array(
					'post_display' => array('by_category', 'by_tag'),
                    'use_current_loop' => 'on'
				)
			),	
            'offset_number'                 => array(
				'label'            => esc_html__( 'Post Offset Number', 'divi_flash' ),
				'type'             => 'text',
				'description'      => esc_html__( 'Choose how many posts you would like to skip. These posts will not be shown in the feed.', 'divi_flash' ),
				'toggle_slug'      => 'settings',
				'default'          => 0,
            ),
            'use_image_as_background'    => array(
                'label'             => esc_html__('Use Image as Background', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings',
                'tab_slug'		    => 'general'
            ),
            'use_background_scale'    => array(
                'label'             => esc_html__('Background Image Scale On Hover', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings',
                'tab_slug'		    => 'general',
                'show_if'           => array(
                    'use_image_as_background'   => 'on'
                )
            )
        );

        $carousel_settings = array(
            'carousel_type'   => array(
                'label'             => esc_html__('Carousel Type', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'slide'         => esc_html__('Slide', 'divi_flash'),
                    'coverflow'     => esc_html__('Coverflow', 'divi_flash')
                ),
                'default'           => 'slide',
                'toggle_slug'       => 'carousel_settings'
            ),
            'item_desktop'    => array(
                'label'             => esc_html__('Max Slide Desktop', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'default'           => '3',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '7',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if_not'       => array(
                    'variable_width' => 'on',
                    'carousel_type'  => array('cube', 'flip')
                )
            ),
            'item_tablet'    => array(
                'label'             => esc_html__('Max Slide Tablet', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'default'           => '2',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '7',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if_not'       => array(
                    'variable_width' => 'on',
                    'carousel_type'  => array('cube', 'flip')
                )
            ),
            'item_mobile'    => array(
                'label'             => esc_html__('Max Slide Mobile', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'default'           => '1',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '7',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if_not'       => array(
                    'variable_width' => 'on',
                    'carousel_type'  => array('cube', 'flip')
                )
            ),
            'item_spacing'    => array(
                'label'             => esc_html__('Spacing (px)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'default'           => '30px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '200',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if_not'       => array(
                    'carousel_type'  => array('cube', 'flip')
                )
            ),
            'speed'    => array(
                'label'             => esc_html__('Speed (ms)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'default'           => '500',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '100',
                    'max'  => '30000',
                    'step' => '50',
                ),
                'validate_unit'     => false
            ),
            'centered_slides'    => array(
                'label'             => esc_html__('Centered Slides', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if_not'       => array(
                    'carousel_type'  => array('cube', 'flip')
                )
            ),
            'loop'    => array(
                'label'             => esc_html__('Loop', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings'
            ),
            'autoplay'    => array(
                'label'             => esc_html__('Autoplay', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'affects'           => [
                    'autospeed',
                    'pause_hover'
                ]
            ),
            'autospeed'    => array(
                'label'             => esc_html__('Autoplay Speed (ms)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'default'           => '2000',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '100',
                    'max'  => '10000',
                    'step' => '50',
                ),
                'validate_unit'     => false,
                'depends_show_if'   => 'on'
            ),
            'pause_hover'    => array(
                'label'             => esc_html__('Pause On Hover', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'depends_show_if'   => 'on'
            ),
            'arrow'    => array(
                'label'             => esc_html__('Arrow Navigation', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings'
            ),
            'dots'    => array(
                'label'             => esc_html__('Dot Navigation', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if_not'       => array(
                    'carousel_type'  => array('cube', 'flip')
                )
            ),
            'equal_height'    => array(
                'label'             => esc_html__('Equal Height Item', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings'
            )
        );
        $coverflow_effect = array(
            'coverflow_shadow'    => array(
                'label'             => esc_html__('Enables slides shadows', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'advanced_settings',
                'show_if'           => array(
                    'carousel_type'  => 'coverflow'
                )
            ),
            'coveflow_color_dark' => array(
                'label'             => esc_html__('Shadow color dark', 'divi_flash'),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'advanced_settings',
                'tab_slug'          => 'general',
                'show_if'           => array(
                    'carousel_type'  => 'coverflow',
                    'coverflow_shadow' => 'on'
                ),
                'default'           => 'rgba(0,0,0,1)'
            ),
            'coveflow_color_light' => array(
                'label'             => esc_html__('Shadow color light', 'divi_flash'),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'advanced_settings',
                'tab_slug'          => 'general',
                'show_if'           => array(
                    'carousel_type'  => 'coverflow',
                    'coverflow_shadow' => 'on'
                ),
                'default'           => 'rgba(0,0,0,0)'
            ),
            'coverflow_rotate'    => array(
                'label'             => esc_html__('Slide rotate in degrees', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'advanced_settings',
                'default'           => '30',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'carousel_type'  => 'coverflow'
                )
            ),
            'coverflow_stretch'    => array(
                'label'             => esc_html__('Stretch space between slides (in px)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'advanced_settings',
                'default'           => '0',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'carousel_type'  => 'coverflow'
                )
            ),
            'coverflow_depth'    => array(
                'label'             => esc_html__('StreDepth offset in px (slides translate in Z axis)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'advanced_settings',
                'default'           => '100',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'carousel_type'  => 'coverflow'
                )
            ),
            'coverflow_modifier'    => array(
                'label'             => esc_html__('Effect multipler', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'advanced_settings',
                'default'           => '1',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '8',
                    'step' => '1',
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'carousel_type'  => 'coverflow'
                )
            )
        );

        $arrows = array(
            'arrow_color' => array(
                'default'           => "#007aff",
                'label'             => esc_html__('Arrow icon color', 'divi_flash'),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
                'hover'             => 'tabs'
            ),
            'arrow_background' => array(
                'default'           => "#ffffff",
                'label'             => esc_html__('Arrow background', 'divi_flash'),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
                'hover'             => 'tabs'
            ),
            'arrow_position'    => array(
                'default'         => 'middle',
                'label'           => esc_html__('Arrow Position', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'top'           => esc_html__('Top', 'divi_flash'),
                    'middle'        => esc_html__('Middle', 'divi_flash'),
                    'bottom'        => esc_html__('Bottom', 'divi_flash')
                ),
                'mobile_options'    => true,
                'toggle_slug'     => 'arrows',
                'tab_slug'        => 'advanced'
            ),
            'arrow_align'    => array(
                'default'         => 'space-between',
                'label'           => esc_html__('Arrow Alignment', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'flex-start'            => esc_html__('Left', 'divi_flash'),
                    'center'                => esc_html__('Center', 'divi_flash'),
                    'flex-end'              => esc_html__('Right', 'divi_flash'),
                    'space-between'         => esc_html__('Justified', 'divi_flash')
                ),
                'mobile_options'    => true,
                'toggle_slug'     => 'arrows',
                'tab_slug'        => 'advanced'
            ),
            'arrow_opacity'    => array(
                'label'             => esc_html__('Opacity', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'arrows',
                'tab_slug'          => 'advanced',
                'default'           => '1',
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '1',
                    'step' => '.01',
                ),
                'validate_unit'     => false,
                'hover'             => 'tabs'
            ),
            'arrow_opacity_disable'    => array (
                'label'             => esc_html__( 'Disabled Arrow Opacity', 'divi_flash' ),
                'description'       => esc_html__('Here you can define the opacity of the disabled arrow when the total slide ends.', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'arrows',
                'tab_slug'          => 'advanced',
                'default'           => '0.5',
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '1',
                    'step' => '.01',
                ),
                'validate_unit'     => false,
                'hover'             => 'tabs',
                'show_if_not'       => array (
                    'loop'  => 'on'
                )
            ),
            'arrow_circle'    => array(
                'label'             => esc_html__('Circle Arrow', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'arrows',
                'tab_slug'          => 'advanced'
            )
        );
        $arrow_prev_icon = $this->df_add_icon_settings(array(
            'title'                 => 'Arrow prev icon',
            'key'                   => 'arrow_prev_icon',
            'toggle_slug'           => 'arrows',
            'tab_slug'              => 'advanced',
            'default_size'          => '39px',
            'icon_alignment'        => false,
            'image_styles'          => false,
            'circle_icon'           => false,
            'icon_color'            => false,
            'icon_size'             => true,
            'image'                 => false
        ));
        $arrow_next_icon = $this->df_add_icon_settings(array(
            'title'                 => 'Arrow next icon',
            'key'                   => 'arrow_next_icon',
            'toggle_slug'           => 'arrows',
            'tab_slug'              => 'advanced',
            'default_size'          => '39px',
            'icon_alignment'        => false,
            'image_styles'          => false,
            'circle_icon'           => false,
            'icon_color'            => false,
            'icon_size'             => true,
            'image'                 => false
        ));
        $arrow_prev_spacing = $this->add_margin_padding(array(
            'title'         => 'Arrow Previous',
            'key'           => 'arrow_prev',
            'toggle_slug'   => 'arrows'
            // 'option'        => 'margin'
        ));
        $arrow_next_spacing = $this->add_margin_padding(array(
            'title'         => 'Arrow Next',
            'key'           => 'arrow_next',
            'toggle_slug'   => 'arrows'
            // 'option'        => 'margin'
        ));
        $dots = array(
            'dots_align'    => array(
                'label'             => esc_html__('Alignment', 'divi_flash'),
                'type'              => 'text_align',
                'options'           => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'       => 'dots',
                'tab_slug'          => 'advanced'
            ),
            'dots_position'    => array(
                'default'         => 'bottom',
                'label'           => esc_html__('Dots Position', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'top'           => esc_html__('Before Content', 'divi_flash'),
                    'bottom'        => esc_html__('After Content', 'divi_flash')
                ),
                'mobile_options'    => true,
                'toggle_slug'     => 'dots',
                'tab_slug'        => 'advanced'
            ),
            'large_active_dot'    => array(
                'label'             => esc_html__('Large Active Dot', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'dots',
                'tab_slug'          => 'advanced'
            ),
            'dots_color' => array(
                'default'           => "#c7c7c7",
                'label'             => esc_html__('Dots color', 'divi_flash'),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dots',
                'hover'             => 'tabs'
            ),
            'active_dots_color' => array(
                'default'           => "#007aff",
                'label'             => esc_html__('Active dots color', 'divi_flash'),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dots',
                'hover'             => 'tabs'
            )
        );
        // df_visibility
        $visibility = array(
            'outer_wrpper_visibility' => array (
                'label'             => esc_html__( 'Outer Wrapper Overflow', 'divi_flash' ),
                'type'              => 'select',
                'options'           => array(
                    'default'   => 'Default',
                    'visible'   => 'Visible',
                    'scroll'    => 'Scroll',
                    'hidden'    => 'Hidden',
                    'auto'      => 'Auto'
                ),
                'default'           => 'default',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'df_overflow',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'inner_wrpper_visibility' => array (
                'label'             => esc_html__( 'Inner Wrapper Overflow', 'divi_flash' ),
                'type'              => 'select',
                'options'           => array(
                    'default'   => 'Default',
                    'visible'   => 'Visible',
                    'scroll'    => 'Scroll',
                    'hidden'    => 'Hidden',
                    'auto'      => 'Auto'
                ),
                'default'           => 'default',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'df_overflow',
                'responsive'        => true,
                'mobile_options'    => true
            )
        );
        $dots_wrapper = $this->add_margin_padding(array(
            'title'         => 'Dots Wrapper',
            'key'           => 'dots_wrapper',
            'toggle_slug'   => 'dots'
        ));
        
        $item_background = $this->df_add_bg_field(array (
			'label'				    => 'Blog Item Background',
            'key'                   => 'item_background',
            'toggle_slug'           => 'item_background',
            'tab_slug'              => 'general'
        ));
        $wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Container',
            'key'           => 'wrapper',
            'toggle_slug'   => 'margin_padding'
        ));
        $item_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Blog Item Outer Wrapper',
            'key'           => 'item_wrapper',
            'toggle_slug'   => 'margin_padding',
            'option'        => 'padding'
        ));
        $item_spacing = $this->add_margin_padding(array(
            'title'         => 'Blog Item Inner Wrapper',
            'key'           => 'item',
            'toggle_slug'   => 'margin_padding',
        ));


        return array_merge(
            $settings,
            $carousel_settings,
            $coverflow_effect,
            $alignment,
            $item_background,
            $arrows,
            $arrow_prev_icon,
            $arrow_next_icon,
            $arrow_prev_spacing,
            $arrow_next_spacing,
            $dots,
            $visibility,
            $dots_wrapper,
            $wrapper_spacing,
            $item_wrapper_spacing,
            $item_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $blog_item = '%%order_class%% .df-post-inner-wrap';
        $arrows = '%%order_class%% .df_bc_arrows > div';
        $arrow_icon = '%%order_class%% .df_bc_arrows > div:after';
        $dots = '%%order_class%% .swiper-pagination .swiper-pagination-bullet';
        $dots_wrapper = '%%order_class%% .swiper-pagination';

        $fields['item_wrapper_padding'] = array ('padding' => '%%order_class%% .df-post-outer-wrap');
        $fields['item_margin'] = array ('margin' => $blog_item);
        $fields['item_padding'] = array ('padding' => $blog_item);

        $fields['wrapper_margin'] = array ('margin' => '%%order_class%% .df-posts-wrap');
        $fields['wrapper_padding'] = array ('padding' => '%%order_class%% .df-posts-wrap');

        $fields['arrow_opacity'] = array('opacity' => $arrows);
        $fields['arrow_opacity_disable'] = array ('opacity' => '%%order_class%% .df_bc_arrows div.swiper-button-disabled');
        $fields['arrow_color'] = array('color' => $arrow_icon);
        $fields['arrow_background'] = array('background-color' => $arrows);
        $fields['arrow_prev_margin'] = array('margin' => $arrows);
        $fields['arrow_prev_padding'] = array('padding' => $arrows);
        $fields['arrow_next_margin'] = array('margin' => $arrows);
        $fields['arrow_next_padding'] = array('padding' => $arrows);

        $fields['dots_color'] = array('background' => $dots);
        $fields['active_dots_color'] = array('background' => $dots);
        $fields['dots_wrapper_margin'] = array('margin' => $dots_wrapper);
        $fields['dots_wrapper_padding'] = array('padding' => $dots_wrapper);
        
        // background
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'item_background',
            'selector'      => $blog_item
        ));

        // border
        $fields = $this->df_fix_border_transition(
            $fields, 
            'item_outer', 
            '%%order_class%% .df-post-outer-wrap'
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'item', 
            $blog_item
        );
        // box-shadow
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'item_outer',
            '%%order_class%% .df-post-outer-wrap'
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'item',
            $blog_item
        );

        return $fields;
    }
    
    public function additional_css_styles($render_slug) {

        // equal height
        if ($this->props['equal_height'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-post-item',
                'declaration' => 'align-self: auto;',
            ));
        }
        // coverflow shadows
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .swiper-container-3d .swiper-slide-shadow-left',
            'declaration' => sprintf('background-image: linear-gradient(to left,%1$s,%2$s);',
                $this->props['coveflow_color_dark'],
                $this->props['coveflow_color_light']
            )
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .swiper-container-3d .swiper-slide-shadow-right',
            'declaration' => sprintf('background-image: linear-gradient(to right,%1$s,%2$s);',
                $this->props['coveflow_color_dark'],
                $this->props['coveflow_color_light']
            )
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'alignment',
            'type'              => 'text-align',
            'selector'          => '%%order_class%% .df-post-inner-wrap'
        ));
        // spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-post-outer-wrap',
            'hover'             => '%%order_class%% .df-post-outer-wrap:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-post-inner-wrap',
            'hover'             => '%%order_class%% .df-hover-trigger:hover .df-post-inner-wrap',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-post-inner-wrap',
            'hover'             => '%%order_class%% .df-hover-trigger:hover .df-post-inner-wrap',
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-posts-wrap',
            'hover'             => '%%order_class%% .df-posts-wrap:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-posts-wrap',
            'hover'             => '%%order_class%% .df-posts-wrap:hover',
        ));
        // background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "item_background",
            'selector'          => "%%order_class%% .df-post-inner-wrap",
            'hover'             => "%%order_class%% .df-hover-trigger:hover .df-post-inner-wrap"
        ));

        // arrow
        if ($this->props['arrow'] === 'on') {
            $pos = isset($this->props['arrow_position']) ? $this->props['arrow_position'] : 'middle';
            $pos_tab = isset($this->props['arrow_position_tablet']) && $this->props['arrow_position_tablet'] !== '' ?
                $this->props['arrow_position_tablet'] : $pos;
            $pos_ph = isset($this->props['arrow_position_phone']) && $this->props['arrow_position_phone'] !== '' ?
                $this->props['arrow_position_phone'] : $pos_tab;
            $a_align = isset($this->props['arrow_align']) ? $this->props['arrow_align'] : 'space-between';
            $a_align_tab = isset($this->props['arrow_align_tablet']) ? $this->props['arrow_align_tablet'] : $a_align;
            $a_align_ph = isset($this->props['arrow_align_phone']) ? $this->props['arrow_align_phone'] : $a_align_tab;

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_bc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_bc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_bc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
            // alignment
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_bc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_bc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_bc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
            if ($this->props['arrow_circle'] === 'on') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_bc_arrows > div',
                    'declaration' => 'border-radius: 50%;'
                ));
            }
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_opacity',
                'type'              => 'opacity',
                'selector'          => '%%order_class%% .df_bc_arrows div',
                'hover'             => '%%order_class%%:hover .df_bc_arrows div'
            ));
            if( 'on' !== $this->props['loop'] ){
                $this->df_process_range( array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'arrow_opacity_disable',
                    'type'              => 'opacity',
                    'selector'          => '%%order_class%% .df_bc_arrows div.swiper-button-disabled',
                    'hover'             => '%%order_class%%:hover .df_bc_arrows div.swiper-button-disabled'
                ) );
            }
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df_bc_arrows .swiper-button-prev',
                'hover'             => '%%order_class%%:hover .df_bc_arrows .swiper-button-prev',
                'important'         => false
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df_bc_arrows .swiper-button-prev',
                'hover'             => '%%order_class%%:hover .df_bc_arrows .swiper-button-prev',
                'important'         => false
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df_bc_arrows .swiper-button-next',
                'hover'             => '%%order_class%%:hover .df_bc_arrows .swiper-button-next',
                'important'         => false
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df_bc_arrows .swiper-button-next',
                'hover'             => '%%order_class%%:hover .df_bc_arrows .swiper-button-next',
                'important'         => false
            ));
            // arrow colors
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_color',
                'type'              => 'color',
                'selector'          => '%%order_class%% .df_bc_arrows div:after',
                'hover'             => '%%order_class%%:hover .df_bc_arrows div:after'
            ));
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_background',
                'type'              => 'background-color',
                'selector'          => '%%order_class%% .df_bc_arrows div',
                'hover'             => '%%order_class%%:hover .df_bc_arrows div'
            ));
            // arrow icon styles
            $this->process_icon_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_icon',
                'selector'          => '%%order_class%% .df_bc_arrows div.swiper-button-prev:after'
            ));
            $this->process_icon_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_icon',
                'selector'          => '%%order_class%% .df_bc_arrows div.swiper-button-next:after'
            ));
        }

        // dots
        if($this->props['dots'] === 'on'){
            $dots_pos = isset($this->props['dots_position']) ? $this->props['dots_position'] : 'top';
            $dots_pos_tab = isset($this->props['dots_position_tablet']) && $this->props['dots_position_tablet'] !== '' ?
                $this->props['dots_position_tablet'] : $dots_pos;
            $dots_pos_ph = isset($this->props['dots_position_phone']) && $this->props['dots_position_phone'] !== '' ?
                $this->props['dots_position_phone'] : $dots_pos_tab;

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination',
                'declaration' => $this->df_arrow_pos_styles($dots_pos),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination',
                'declaration' => $this->df_arrow_pos_styles($dots_pos_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination',
                'declaration' => $this->df_arrow_pos_styles($dots_pos_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ($this->props['large_active_dot'] === 'on') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .swiper-pagination .swiper-pagination-bullet-active',
                    'declaration' => 'width: 40px; border-radius: 20px;'
                ));
            }
            if (isset($this->props['dots_align'])) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .swiper-pagination',
                    'declaration' => sprintf('text-align: %1$s;', $this->props['dots_align'])
                ));
            }
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'dots_color',
                'type'              => 'background',
                'selector'          => '%%order_class%% .swiper-pagination span',
                'hover'             => '%%order_class%% .swiper-pagination span:hover'
            ));
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'active_dots_color',
                'type'              => 'background',
                'selector'          => '%%order_class%% .swiper-pagination span.swiper-pagination-bullet-active',
                'hover'             => '%%order_class%% .swiper-pagination span.swiper-pagination-bullet-active:hover'
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'dots_wrapper_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .swiper-pagination',
                'hover'             => '%%order_class%% .swiper-pagination:hover',
                'important'         => false
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'dots_wrapper_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .swiper-pagination',
                'hover'             => '%%order_class%% .swiper-pagination:hover',
                'important'         => false
            ));
        }

        if($this->props['arrow_opacity'] !== '0') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%  .arrow-middle .df_bc_arrows *',
                'declaration' => 'pointer-events: all !important;'
            ));
        }
        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'arrow_prev_icon_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .swiper-button-prev:after',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'arrow_next_icon_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .swiper-button-next:after',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }

        // overflow
        if( isset($this->props['outer_wrpper_visibility']) && $this->props['outer_wrpper_visibility'] !== 'default' ) {
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'outer_wrpper_visibility',
                'type'              => 'overflow',
                'selector'          => '%%order_class%% .df-post-outer-wrap',
                'important'         => true
            ));
        }
        if( isset($this->props['inner_wrpper_visibility']) && $this->props['inner_wrpper_visibility'] !== 'default' ) {
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'inner_wrpper_visibility',
                'type'              => 'overflow',
                'selector'          => '%%order_class%% .df-post-inner-wrap',
                'important'         => true
            ));
        }
    }

    /**
	 * Get blog posts for postgrid module
	 *
	 * @return string blog post markup
	 */
    public function get_posts() {
        global $post, $paged, $wp_query, $wp_the_query, $wp_filter, $__et_blog_module_paged, $df_post_items, $df_post_items_outside;

        $main_query = $wp_the_query;

        $use_current_loop           = isset( $this->props['use_current_loop'] ) ? $this->props['use_current_loop'] : 'off';
        $offset_number              = $this->props['offset_number'];
        $posts_number               = $this->props['posts_number'];
        $post_display               = $this->props['post_display'];
        $orderby                    = $this->props['orderby'];
        $use_image_as_background    = $this->props['use_image_as_background'];
        $use_background_scale       = $this->props['use_background_scale'];
        $query_args = array(
			'posts_per_page' => intval($this->props['posts_number']),
			'post_status'    => array( 'publish' ),
			'perm'           => 'readable',
			'post_type'      => 'post',
        );

        // post by categories
        if ( 'by_category' === $post_display) {
            $query_args['cat'] = $this->props['include_categories'];
        }
        // post by tag
        if ( 'by_tag' == $post_display) {
            $query_args['tag__in'] = explode(',', $this->props['include_tags'] );
        }
        // orderby
        if ( 'recent' == $post_display) {
            if ( '3' === $orderby ) {
                $query_args['orderby'] = 'rand';
            } else if('2' === $orderby) {
                $query_args['orderby'] = 'date';
                $query_args['order'] = 'ASC';
            } else {
                $query_args['orderby'] = 'date';
                $query_args['order'] = 'DESC';
            }
        }

        $df_pg_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );
        if ( is_front_page() ) {
            $paged = $df_pg_paged; //phpcs:ignore WordPress.WP.GlobalVariablesOverride
		}

		if ( $__et_blog_module_paged > 1 ) {
			$df_pg_paged            = $__et_blog_module_paged;
			$paged                  = $__et_blog_module_paged; //phpcs:ignore WordPress.WP.GlobalVariablesOverride
			$query_args['paged']    = $__et_blog_module_paged;
		}

        $query_args['paged'] = $df_pg_paged;

        if ( '' !== $offset_number && ! empty( $offset_number ) ) {
			/**
			 * Offset + pagination don't play well. Manual offset calculation required
			 *
			 * @see: https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
			 */
			if ( $paged > 1 ) {
				$query_args['offset'] = ( ( $df_pg_paged - 1 ) * intval( $posts_number ) ) + intval( $offset_number );
			} else {
				$query_args['offset'] = intval( $offset_number );
			}
		}
        
        ob_start();

        if ( 'off' === $use_current_loop ) {
			query_posts( $query_args ); // phpcs:ignore WordPress.WP.DiscouragedFunctions
		} elseif ( is_singular() && 'on' === $use_current_loop) {
            $custom   = array_intersect_key( $query_args, array_flip( array( 'posts_per_page', 'offset', 'paged' ) ) );

            query_posts($custom);
		} else {
			// Only allow certain args when `Posts For Current Page` is set.
			$original = $wp_query->query_vars;
			$custom   = array_intersect_key( $query_args, array_flip( array( 'posts_per_page', 'offset', 'paged' ) ) );

			// Trick WP into reporting this query as the main query so third party filters
			// that check for is_main_query() are applied.
			$wp_the_query = $wp_query = new WP_Query( array_merge( $original, $custom ) ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
        }

        // Manually set the max_num_pages to make the `next_posts_link` work
		if ( '' !== $offset_number && ! empty( $offset_number ) ) {
			global $wp_query;
			$wp_query->found_posts   = max( 0, $wp_query->found_posts - intval( $offset_number ) );
			$posts_number            = intval( $posts_number );
			$wp_query->max_num_pages = $posts_number > 1 ? ceil( $wp_query->found_posts / $posts_number ) : 1;
		}

        echo '<div class="df-posts-wrap swiper-wrapper">';

        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();

                $width = 'on' === 1080;
                // $width = 'on' === $fullwidth ? 1080 : 400;
				$width = (int) apply_filters( 'et_pb_blog_image_width', $width );

				$height    = 'on' === 675;
				$height    = (int) apply_filters( 'et_pb_blog_image_height', $height );
                $equal_height_class = $this->props['equal_height'] === 'on' ? ' df-equal-height' : '';

                $outer_content = '';
                $inner_content = '';

                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( "df-post-item swiper-slide v2{$equal_height_class}" ) ?>>
                    <div class="df-post-outer-wrap df-hover-trigger" <?php echo $use_background_scale !== 'on' ? et_core_esc_previously(df_post_image_as_background($use_image_as_background)): '';?>>
                        <?php 
                            // render markup to achive the scale effect.
                            if($use_image_as_background === 'on' && $use_background_scale === 'on') {
                                echo '<div class="df-blogcarousel-bg-on-hover"><div ' .et_core_esc_previously(df_post_image_as_background($use_image_as_background)) .'></div></div>';
                            }
                            if( !empty($df_post_items_outside) ) {
                                foreach( $df_post_items_outside as $post_item ) {

                                    if( !isset($post_item['type'])) {
                                        continue;
                                    }

                                    $callback = 'df_post_' . $post_item['type'];

                                    call_user_func($callback, $post_item);

                                } // end of foreach
                            }
                        ?>
                        <div class="df-post-inner-wrap">
                            <?php
                                foreach( $df_post_items as $post_item ) {
                                    
                                    if( !isset($post_item['type'])) {
                                        continue;
                                    }

                                    $callback = 'df_post_' . $post_item['type'];

                                    call_user_func($callback, $post_item);

                                } // end of foreach
                            ?>
                        </div>
                    </div>
                </article>
                <?php
            } // endwhile
        }

        echo '</div>'; // end of df-pg-posts

		$wp_the_query = $wp_query = $main_query; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
        wp_reset_query(); // phpcs:ignore WordPress.WP.DiscouragedFunctions
        
        $posts = ob_get_contents();
        ob_end_clean();
        if(empty($df_post_items)) {
            $posts = '<h2>Please create post element.</h3>';
        }
        $df_post_items = array();
        $df_post_items_outside = array();

        return $posts;
    }

    public function render( $attrs, $content, $render_slug ) {
        if ( $this->content === '' ) {
            return sprintf(
                '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Post Element.</strong></h2>'
            );
        }
        $this->additional_css_styles($render_slug);
        wp_enqueue_script('swiper-script');
        wp_enqueue_script('df-blog-carousel');

        wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );

        $order_class     = self::get_module_order_class($render_slug);
        $order_number    = str_replace('_', '', str_replace($this->slug, '', $order_class));
        $class = '';
        
        $data = array(
            'effect' => $this->props['carousel_type'],
            'desktop' => $this->props['item_desktop'],
            'tablet' => $this->props['item_tablet'],
            'mobile' => $this->props['item_mobile'],
            'loop' => $this->props['loop'] === 'on' ? true : false,
            'item_spacing' => $this->props['item_spacing'],
            'item_spacing_tablet' => $this->props['item_spacing_tablet'],
            'item_spacing_phone' => $this->props['item_spacing_phone'],
            'arrow' => $this->props['arrow'],
            'dots' => $this->props['dots'],
            'autoplay' => $this->props['autoplay'],
            'auto_delay' => $this->props['autospeed'],
            'speed' => $this->props['speed'],
            'pause_hover' => $this->props['pause_hover'],
            'centeredSlides' => $this->props['centered_slides'],
            'order' => $order_number
        );
        if ($this->props['carousel_type'] === 'coverflow') {
            $data['slideShadows'] = $this->props['coverflow_shadow'];
            $data['rotate'] = $this->props['coverflow_rotate'];
            $data['stretch'] = $this->props['coverflow_stretch'];
            $data['depth'] = $this->props['coverflow_depth'];
            $data['modifier'] = $this->props['coverflow_modifier'];
        }

        // arrow position classes
        if($this->props['arrow'] === 'on') {
            $arrow_position = '' !== $this->props['arrow_position'] ? $this->props['arrow_position'] : 'middle';
            $class .= ' arrow-' . $arrow_position;
        }
        
        return sprintf('<div class="df_blogcarousel_container%8$s" data-settings=\'%2$s\' data-item="%5$s" data-itemtablet="%6$s" data-itemphone="%7$s">
                <div class="swiper-container">%1$s</div>%3$s
            </div>%4$s', 
            $this->get_posts(),
            wp_json_encode($data),
            $this->df_bc_arrow($order_number),
            $this->df_bc_dots($order_number),
            $this->props['item_desktop'],
            $this->props['item_tablet'],
            $this->props['item_mobile'],
            $class
        );
    }

    /**
     * Arrow navigation
     * 
     * @param Integer | $order_number
     * @return String | HTML
     */
    public function df_bc_arrow($order_number)
    {
        $prev_icon = $this->props['arrow_prev_icon_use_icon'] === 'on' && isset($this->props['arrow_prev_icon_font_icon']) && !empty($this->props['arrow_prev_icon_font_icon']) ?
            esc_attr(et_pb_process_font_icon($this->props['arrow_prev_icon_font_icon'])) : '4';
        $next_icon = $this->props['arrow_next_icon_use_icon'] === 'on' && isset($this->props['arrow_next_icon_font_icon']) && !empty($this->props['arrow_next_icon_font_icon']) ?
            esc_attr(et_pb_process_font_icon($this->props['arrow_next_icon_font_icon'])) : '5';

        return $this->props['arrow'] === 'on' ? sprintf('
            <div class="df_bc_arrows">
                <div class="swiper-button-next bc-next-%1$s" data-icon="%3$s"></div>
                <div class="swiper-button-prev bc-prev-%1$s" data-icon="%2$s"></div>
            </div>
        ', $order_number, $prev_icon, $next_icon) : '';
    }

    /**
     * Dot pagination
     * 
     * @param Integer | $order_number
     * @return String | HTML
     */
    public function df_bc_dots($order_number)
    {
        return $this->props['dots'] === 'on' ?
            sprintf('<div class="swiper-pagination bc-dots-%1$s"></div>', $order_number) : '';
    }
    /**
     * Arrow Position styles
     * 
     * @param String | position
     * @return String
     */
    public function df_arrow_pos_styles($value = 'middle')
    {
        $options = array(
            'top' => 'position: relative; 
                    top: auto;
                    left: auto;
                    right: auto;
                    transform: translateY(0);
                    order: 0;',
            'middle' => 'position: absolute; 
                        top: 50%;
                        left: 0;
                        right: 0;
                        transform: translateY(-50%);',
            'bottom' => 'position: relative; 
                    top: auto;
                    left: auto;
                    right: auto;
                    transform: translateY(0);
                    order: 2;',
        );
        return $options[$value];
    }
    
    public function add_new_child_text() {
		return esc_html__( 'Add New Post Element', 'divi_flash' );
	}
}
new DIFL_BlogCarousel;
