<?php

class DIFL_PostList extends ET_Builder_Module_Type_PostBased {
    use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_postlist';
    public $vb_support = 'on';
    public $child_slug = 'difl_postlistitem';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Post List', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/postlist.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'settings'              => esc_html__('Post Settings', 'divi_flash'),
                    'item_background'       => esc_html__('Item Background', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'content_align' => esc_html__('Alignment', 'divi_flash'),
                    'layout' => esc_html__('Layout', 'divi_flash'),
                    'post_item' => esc_html__('Post Item', 'divi_flash'),
                    'featured_image' => esc_html__('Featured Image', 'divi_flash'),
                    'item_outer_wrapper' => esc_html__('Content Wrapper', 'divi_flash'),
                    'item_inner_wrapper' => esc_html__('Content Inner Wrapper', 'divi_flash'),
                    'pagination' => esc_html__('Pagination Button Styles', 'divi_flash'),
                    'active_pagination' => esc_html__('Active Pagination Number', 'divi_flash'),
                    'df_overflow' => esc_html__( 'Overflow & Z-index', 'divi_flash' )
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
            'pagination'     => array(
                'label'           => et_builder_i18n( 'Pagination' ),
                'css'             => array(
                    'main'        => "%%order_class%% .pagination .page-numbers:not(.current)",
                    'hover'        => "%%order_class%% .pagination .page-numbers:not(.current):hover"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '16px',
                ),
                'toggle_slug'     => 'pagination'
            ),
            'active_pagination'     => array(
                'label'           => et_builder_i18n( 'Pagination' ),
                'css'             => array(
                    'main'        => "%%order_class%% .pagination .page-numbers.current",
                    'hover'        => "%%order_class%% .pagination .page-numbers.current:hover"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '16px',
                ),
                'toggle_slug'     => 'active_pagination'
            )
        );

        $advanced_fields['borders'] = array (
            'featured_image'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-postlist-featured-image .df-item-wrap,
                        %%order_class%% .df-pl-icon',
                        'border_radii_hover' => '%%order_class%% .df-postlist-featured-image .df-item-wrap:hover,%%order_class%% .df-pl-icon:hover',
                        'border_styles' => '%%order_class%% .df-postlist-featured-image .df-item-wrap, %%order_class%% .df-pl-icon',
                        'border_styles_hover' => '%%order_class%% .df-postlist-featured-image .df-item-wrap:hover, %%order_class%% .df-pl-icon:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'featured_image',
                'label_prefix'      => ''
            ),
            'post_item'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-post-item',
                        'border_radii_hover' => '%%order_class%% .df-post-item:hover',
                        'border_styles' => '%%order_class%% .df-post-item',
                        'border_styles_hover' => '%%order_class%% .df-post-item:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'post_item',
                'label_prefix'      => ''
            ),
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
                'label_prefix'      => ''
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
                'label_prefix'      => ''
            ),
            'pagination'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .pagination .page-numbers:not(.current)',
                        'border_radii_hover' => '%%order_class%% .pagination .page-numbers:not(.current):hover',
                        'border_styles' => '%%order_class%% .pagination .page-numbers:not(.current)',
                        'border_styles_hover' => '%%order_class%% .pagination .page-numbers:not(.current):hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'pagination'
                // 'label_prefix'      => 'Pagination'
            ),
            'active_pagination'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .pagination .page-numbers.current',
                        'border_radii_hover' => '%%order_class%% .pagination .page-numbers.current:hover',
                        'border_styles' => '%%order_class%% .pagination .page-numbers.current',
                        'border_styles_hover' => '%%order_class%% .pagination .page-numbers.current:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'active_pagination'
                // 'label_prefix'      => 'Pagination'
            ),
        );

        $advanced_fields['box_shadow'] = array(
            'featured_image'      => array(
                'css' => array(
                    'main' => "%%order_class%% .df-postlist-featured-image .df-item-wrap, %%order_class%% .df-pl-cion",
                    'hover' => "%%order_class%% .df-postlist-featured-image .df-item-wrap:hover, %%order_class%% .df-pl-icon:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'featured_image'
            ),
            'post_item'      => array(
                'css' => array(
                    'main' => "%%order_class%% .df-post-item",
                    'hover' => "%%order_class%% .df-post-item:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'post_item'
            ),
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
            ),
            'pagination'      => array(
                'css' => array(
                    'main' => "%%order_class%% .pagination .page-numbers:not(.current)",
                    'hover' => "%%order_class%% .pagination .page-numbers:not(.current):hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'pagination'
            ),
            'active_pagination'      => array(
                'css' => array(
                    'main' => "%%order_class%% .pagination .page-numbers.current",
                    'hover' => "%%order_class%% .pagination .page-numbers.current:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'active_pagination'
            )
        );

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
                'meta_categories'  => array(
					'current' => esc_html__( 'Current Category', 'et_builder' ),
				),
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
            'show_pagination'    => array(
                'label'             => esc_html__('Show Pagination', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings'
            ),
            'use_number_pagination'    => array(
                'label'             => esc_html__('Use Number Pagination', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings',
                'tab_slug'		    => 'general',
                'show_if'           => array(
                    'show_pagination'       => 'on'
                )
            ),
            'older_text'                  => array(
				'label'            => esc_html__( 'Older Entries Button Text', 'divi_flash' ),
				'type'             => 'text',
				'toggle_slug'      => 'settings',
                'default'          => 'Older Entries',
                'show_if'          => array(
                    'show_pagination'   => 'on'
                )       
            ),
            'newer_text'                  => array(
				'label'            => esc_html__( 'Next Entries Button Text', 'divi_flash' ),
				'type'             => 'text',
				'toggle_slug'      => 'settings',
                'default'          => 'Next Entries',
                'show_if'          => array(
                    'show_pagination'   => 'on'
                )
            )
        );
        $layout = array(
            'use_breakpoint'   => array (
                'label'             => esc_html__( 'Use Breakpoint', 'divi_flash' ),
                'type'              => 'yes_no_button',
                'toggle_slug'       => 'layout',
                'tab_slug'          => 'advanced',
                'options'           => array(
                    'off'     => esc_html__('Off', 'divi_flash'),
                    'on'      => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
            ),
            'breakpoint'   => array (
                'label'             => esc_html__( 'Breakpoint', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'layout',
                'tab_slug'          => 'advanced',
                'default'           => '980',
                'validate_unit'     => true,
                'fixed_unit'        => 'px',
                'fixed_range'       => true,
                'allowed_units'     => array( 'px' ),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '1200',
                    'step' => '1',
                    'min_limit' => 0,
                ),
                'show_if' => array(
                    'use_breakpoint' => 'on'
                )
            ),
            'layout_device_settings'   => array(
                'label'             => esc_html__( 'Device settings', 'divi_flash' ),
				'type'              => 'composite',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'layout',
                'composite_type'    => 'default',
                'composite_structure' => array(
					'd_settings' => array(
                        'icon'     => 'desktop',
						'controls' => array(
							'layout'   => array(
                                'label'             => esc_html__('Layout', 'divi_flash'),
                                'type'              => 'select',
                                'options'           => array(
                                    'layout-1'       => esc_html__('Layout 1', 'divi_flash'),
                                    'layout-2'       => esc_html__('Layout 2', 'divi_flash'),
                                    'layout-3'       => esc_html__('Layout 3', 'divi_flash')
                                ),
                                'default'           => 'layout-1',
                                'toggle_slug'       => 'layout',
                                'tab_slug'          => 'advanced',
                                'show_if_not'       => array(
                                    'use_iamge'     => 'off'
                                )
                            ),
                            'item_gap'   => array (
                                'label'             => esc_html__( 'Gap', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'layout',
                                'tab_slug'          => 'advanced',
                                'default'           => '30px',
                                'validate_unit'     => true,
                                'fixed_unit'        => 'px',
                                'fixed_range'       => true,
                                'allowed_units'     => array( 'px' ),
                                'range_settings'    => array(
                                    'min'  => '0',
                                    'max'  => '100',
                                    'step' => '1',
                                    'min_limit' => 0,
                                )
                            ),
                            'image_col_size'   => array (
                                'label'             => esc_html__( 'Image Column Size', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'layout',
                                'tab_slug'          => 'advanced',
                                'default'           => '50%',
                                'default_unit'      => 'px',
                                // 'responsive'        => true,
                                // 'mobile_options'    => true,
                                'validate_unit'     => true,
                                'fixed_unit'        => '%',
                                'fixed_range'       => true,
                                'allowed_units'     => array( '%' ),
                                'range_settings'    => array(
                                    'min'  => '10',
                                    'max'  => '80',
                                    'step' => '1',
                                    'min_limit' => 10,
                                    'max_limit' => 80,
                                ),
                                'show_if_not'       => array(
                                    'use_iamge'     => 'off'
                                )
                            ),
                            'vertical_align'   => array(
                                'label'             => esc_html__('Vertical Align', 'divi_flash'),
                                'type'              => 'select',
                                'options'           => array(
                                    'stretch'       => esc_html__('Stretch', 'divi_flash'),
                                    'flex-start'    => esc_html__('Top', 'divi_flash'),
                                    'center'        => esc_html__('Center', 'divi_flash'),
                                    'flex-end'      => esc_html__('Bottom', 'divi_flash')
                                ),
                                'default'           => 'off',
                                'toggle_slug'       => 'layout',
                                'tab_slug'          => 'advanced',
                                'show_if_not'       => array(
                                    'equal_height' => 'on',
                                    'use_iamge'     => 'off'
                                )
                            ),
                            'collapse'   => array(
                                'label'             => esc_html__('Collapse', 'divi_flash'),
                                'type'              => 'yes_no_button',
                                'options'           => array(
                                    'off'     => esc_html__('Off', 'divi_flash'),
                                    'on'      => esc_html__('On', 'divi_flash'),
                                ),
                                'default'           => 'off',
                                'toggle_slug'       => 'layout',
                                'tab_slug'          => 'advanced',
                                'show_if'           => array(
                                    'vertical_align' => array('flex-start', 'center', 'flex-end')
                                ),
                                'show_if_not'       => array(
                                    'equal_height' => 'on',
                                    'use_iamge'     => 'off'
                                )
                            ),
                            'collapse_value'   => array (
                                'label'             => esc_html__( 'Collapse Value', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'layout',
                                'tab_slug'          => 'advanced',
                                'default'           => '50px',
                                'default_unit'      => 'px',
                                'validate_unit'     => true,
                                'fixed_unit'        => 'px',
                                'fixed_range'       => true,
                                'allowed_units'     => array( 'px' ),
                                'range_settings'    => array(
                                    'min'  => '0',
                                    'max'  => '100',
                                    'step' => '1',
                                    'min_limit' => 0,
                                ),
                                'show_if' => array(
                                    'collapse' => 'on',
                                    'vertical_align' => array('flex-start', 'center', 'flex-end')
                                ),
                                'show_if_not'       => array(
                                    'equal_height' => 'on',
                                    'use_iamge'     => 'off'
                                )
                            ),
                            'equal_height'   => array(
                                'label'             => esc_html__('Equal Height', 'divi_flash'),
                                'type'              => 'yes_no_button',
                                'options'           => array(
                                    'off'     => esc_html__('Off', 'divi_flash'),
                                    'on'      => esc_html__('On', 'divi_flash'),
                                ),
                                'default'           => 'off',
                                'toggle_slug'       => 'layout',
                                'tab_slug'          => 'advanced',
                                'show_if_not'       => array(
                                    'use_iamge'     => 'off'
                                )
                            ),
                            'image_min_height'   => array (
                                'label'             => esc_html__( 'Image Min Height', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'layout',
                                'tab_slug'          => 'advanced',
                                'default'           => '250px',
                                'default_unit'      => 'px',
                                'default_on_front'  => '',
                                'validate_unit'     => true,
                                'fixed_unit'        => 'px',
                                'fixed_range'       => true,
                                'allowed_units'     => array( 'px' ),
                                'range_settings'    => array(
                                    'min'  => '0',
                                    'max'  => '800',
                                    'step' => '1',
                                    'min_limit' => 0,
                                ),
                                'show_if' => array(
                                    'equal_height' => 'on',
                                )
                            ),
						),
					),
					't_settings' => array(
                        'icon'  => 'tablet',
						'controls' => array(
                            'item_gap_mobile'   => array (
                                'label'             => esc_html__( 'Gap', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'layout',
                                'tab_slug'          => 'advanced',
                                'default'           => '30px',
                                'validate_unit'     => true,
                                'fixed_unit'        => 'px',
                                'fixed_range'       => true,
                                'allowed_units'     => array( 'px' ),
                                'range_settings'    => array(
                                    'min'  => '0',
                                    'max'  => '100',
                                    'step' => '1',
                                    'min_limit' => 0,
                                )
                            ),
							'mobile_image_size'   => array (
                                'label'             => esc_html__( 'Image Column Size', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'layout',
                                'tab_slug'          => 'advanced',
                                'default'           => '100%',
                                'default_unit'      => '%',
                                'validate_unit'     => true,
                                'fixed_range'       => true,
                                'allowed_units'     => array( '%', 'px' ),
                                'range_settings'    => array(
                                    'min'  => '0',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                                'show_if_not'       => array(
                                    'use_iamge'     => 'off'
                                )
                            ),
							'mobile_content_size'   => array (
                                'label'             => esc_html__( 'Content Column Size', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'layout',
                                'tab_slug'          => 'advanced',
                                'default'           => '100%',
                                'default_unit'      => '%',
                                'validate_unit'     => true,
                                'fixed_range'       => true,
                                'allowed_units'     => array( '%', 'px' ),
                                'range_settings'    => array(
                                    'min'  => '0',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                                'show_if_not'       => array(
                                    'use_iamge'     => 'off'
                                )
                            ),
                            'mobile_image_min_height'   => array (
                                'label'             => esc_html__( 'Image Min Height', 'divi_flash' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'layout',
                                'tab_slug'          => 'advanced',
                                'default'           => '250px',
                                'default_unit'      => 'px',
                                'default_on_front'  => '',
                                'validate_unit'     => true,
                                'fixed_unit'        => 'px',
                                'fixed_range'       => true,
                                'allowed_units'     => array( 'px' ),
                                'range_settings'    => array(
                                    'min'  => '0',
                                    'max'  => '800',
                                    'step' => '1',
                                    'min_limit' => 0,
                                ),
                                'show_if' => array(
                                    'equal_height' => 'on',
                                )
                            ),
						),
					),
				),
            ),
        );
        $post_item = array_merge(
            $this->df_add_bg_field(array (
                'label'				    => 'Background',
                'key'                   => 'item_background',
                'toggle_slug'           => 'post_item',
                'tab_slug'              => 'advanced',
            )),
            $this->add_margin_padding(array(
                'key'           => 'post_item',
                'toggle_slug'   => 'post_item',
            ))
        );
        $featured_image = array_merge(
            array(
                'use_iamge'   => array (
                    'label'             => esc_html__( 'Show Image', 'divi_flash' ),
                    'type'              => 'yes_no_button',
                    'toggle_slug'       => 'featured_image',
                    'tab_slug'          => 'advanced',
                    'options'           => array(
                        'off'     => esc_html__('Off', 'divi_flash'),
                        'on'      => esc_html__('On', 'divi_flash'),
                    ),
                    'default'           => 'on',
                ),
                'image_size' => array (
                    'default'         => 'large',
                    'label'           => esc_html__( 'Image Size', 'divi_flash' ),
                    'type'            => 'select',
                    'options'         => array(
                        'original'      => esc_html__( 'Original', 'divi_flash' ),
                        '1080x675'      => esc_html__( '1080 x 675', 'divi_flash' ),
                        '768x360'       => esc_html__( '768 x 360', 'divi_flash' ),
                        '510x382'       => esc_html__( '510 x 382', 'divi_flash' ),
                        '400x250'       => esc_html__( '400 x 250', 'divi_flash' ),
                        '300x300'       => esc_html__( '300 x 300', 'divi_flash' ),
                        '300x187'       => esc_html__( '300 x 187', 'divi_flash' ),
                        '150x150'       => esc_html__( '150 x 150', 'divi_flash' ),
                        '100x100'       => esc_html__( '100 x 100', 'divi_flash' ),
                    ),
                    'toggle_slug'       => 'featured_image',
                    'tab_slug'		    => 'advanced',
                    'show_if_not'       => array(
                        'use_iamge'     => 'off'
                    )
                ),
                'image_scale'    => array(
                    'label'    => esc_html__('Image Scale Type', 'divi_flash'),
                    'type'          => 'select',
                    'options'       => array (
                        'no-image-scale'            => esc_html__('Select Scale Type', 'divi_flash'),
                        'df-image-zoom-in'          => esc_html__('Zoom In', 'divi_flash'),
                        'df-image-zoom-out'         => esc_html__('Zoom Out', 'divi_flash'),
                        'df-image-pan-up'           => esc_html__('Pan Up', 'divi_flash'),
                        'df-image-pan-down'         => esc_html__('Pan Down', 'divi_flash'),
                        'df-image-pan-left'         => esc_html__('Pan Left', 'divi_flash'),
                        'df-image-pan-right'        => esc_html__('Pan Right', 'divi_flash'),
                        'df-image-rotate-left'      => esc_html__('Rotate Left', 'divi_flash'),
                        'df-image-rotate-right'     => esc_html__('Rotate Right', 'divi_flash'),
                        'df-image-blur'             => esc_html__('Blur', 'divi_flash')
                    ),
                    'default'       => 'no-image-scale',
                    'toggle_slug'   => 'featured_image',
                    'tab_slug'		=> 'advanced',
                    'show_if_not'       => array(
                        'use_iamge'     => 'off'
                    )
                ),
                'use_icon'   => array (
                    'label'             => esc_html__( 'Use Icon', 'divi_flash' ),
                    'type'              => 'yes_no_button',
                    'toggle_slug'       => 'featured_image',
                    'tab_slug'          => 'advanced',
                    'options'           => array(
                        'off'     => esc_html__('Off', 'divi_flash'),
                        'on'      => esc_html__('On', 'divi_flash'),
                    ),
                    'default'           => 'off',
                    'show_if'           => array(
                        'use_iamge'     => 'off'
                    )
                ),
                'icon_image' => array(
                    'label'                 => esc_html__( 'Icon', 'divi_flash' ),
                    'type'                  => 'select_icon',
                    'option_category'       => 'basic_option',
                    'class'                 => array( 'et-pb-font-icon' ),
                    'toggle_slug'           => 'featured_image',
                    'tab_slug'              => 'advanced',
                    'show_if'               => array(
                        'use_icon'          => 'on'
                    )
                ),
                'icon_size'   => array (
                    'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
                    'type'              => 'range',
                    'toggle_slug'       => 'featured_image',
                    'tab_slug'          => 'advanced',
                    'default'           => '30px',
                    'validate_unit'     => true,
                    'fixed_unit'        => 'px',
                    'allowed_units'     => array( 'px' ),
                    'hover'             => 'tabs',
                    'range_settings'    => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1',
                    ),
                    'show_if' => array(
                        'use_icon' => 'on'
                    )
                ),
                'icon_color' => array(
                    'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
                    'type'              => 'color-alpha',
                    'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
                    'toggle_slug'       => 'featured_image',
                    'tab_slug'          => 'advanced' ,
                    'hover'             => 'tabs',
                    'show_if' => array(
                        'use_icon' => 'on'
                    )
                ),
            ),
            $this->add_margin_padding(array(
                'title'         => 'Icon',
                'key'           => 'icon',
                'toggle_slug'   => 'featured_image',
                'show_if'       => array(
                    'use_icon'  => 'on'
                )
            )),
            $this->df_add_bg_field(array (
                'label'				    => 'Icon Background',
                'key'                   => 'icon_background',
                'toggle_slug'           => 'featured_image',
                'tab_slug'              => 'advanced',
                'show_if'               => array(
                    'use_icon'          => 'on'
                )
            ))
        );
        $content_wrapper = array_merge(
            $this->df_add_bg_field(array (
                'label'				    => 'Background',
                'key'                   => 'outer_wrapper_background',
                'tab_slug'              => 'advanced',
                'toggle_slug'           => 'item_outer_wrapper',
            )),
            $this->add_margin_padding(array(
                'key'           => 'item_outer',
                'toggle_slug'   => 'item_outer_wrapper',
            ))
        );
        $content_inner_wrapper = array_merge(
            $this->df_add_bg_field(array (
                'label'				    => 'Background',
                'key'                   => 'inner_wrapper_background',
                'tab_slug'              => 'advanced',
                'toggle_slug'           => 'item_inner_wrapper',
            )),
            $this->add_margin_padding(array(
                'key'           => 'item_inner',
                'toggle_slug'   => 'item_inner_wrapper',
            ))
        );
        $pagination = array_merge(
            array(
                'pagination_align'   => array(
                    'label'             => esc_html__('Pagination Alignment', 'divi_flash'),
                    'type'              => 'select',
                    'options'           => array(
                        'center'          => esc_html__('Center', 'divi_flash'),
                        'flex-start'      => esc_html__('Left', 'divi_flash'),
                        'flex-end'        => esc_html__('Right', 'divi_flash'),
                        'space-between'   => esc_html__('Justified', 'divi_flash')
                    ),
                    'default'           => 'center',
                    'toggle_slug'       => 'pagination',
                    'tab_slug'          => 'advanced',
                    'responsive'        => true,
                    'mobile_options'    => true
                ),
                'next_prev_icon'   => array(
                    'label'             => esc_html__('Next & Prev Icon', 'divi_flash'),
                    'type'              => 'select',
                    'options'           => array(
                        'set_1'          => esc_html__('Set 1', 'divi_flash'),
                        'set_2'          => esc_html__('Set 2', 'divi_flash'),
                        'set_3'          => esc_html__('Set 3', 'divi_flash'),
                        'set_4'          => esc_html__('Set 4', 'divi_flash')
                    ),
                    'default'           => 'set_1',
                    'toggle_slug'       => 'pagination',
                    'tab_slug'          => 'advanced',
                    'responsive'        => true,
                    'mobile_options'    => true
                )
            ),
            $this->df_add_bg_field(array (
                'label'				    => 'Background',
                'key'                   => 'pagination_background',
                'toggle_slug'           => 'pagination',
                'tab_slug'              => 'advanced'
            )),
            $this->add_margin_padding(array(
                'title'         => 'Pagination',
                'key'           => 'pagination',
                'toggle_slug'   => 'pagination'
            ))
        );
        $active_pagination_background = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'active_pagination_background',
            'toggle_slug'           => 'active_pagination',
            'tab_slug'              => 'advanced'
        ));
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
            ),
            'featured_image_index'   => array (
                'label'             => esc_html__( 'Featured Image', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'df_overflow',
                'tab_slug'          => 'advanced',
                'default'           => '0',
                'unitless'        => true,
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1'
                )
            ),
            'content_wrapper_index'   => array (
                'label'             => esc_html__( 'Content Wrapper', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'df_overflow',
                'tab_slug'          => 'advanced',
                'default'           => '0',
                'unitless'        => true,
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1'
                )
            ),
        );
        return array_merge(
            $settings,
            $alignment,
            $layout,
            $post_item,
            $featured_image,
            $content_wrapper,
            $content_inner_wrapper,
            $pagination,
            $visibility,
            $active_pagination_background
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $blog_item = '%%order_class%% .df-post-inner-wrap';
        $pagination = '%%order_class%% .pagination .page-numbers';
        $icon = '%%order_class%% .df-pl-icon';

        $fields['item_outer_margin'] = array ('margin' => '%%order_class%% .df-post-outer-wrap');
        $fields['item_outer_padding'] = array ('padding' => '%%order_class%% .df-post-outer-wrap');
        $fields['post_item_margin'] = array ('margin' => '%%order_class%% .df-post-item');
        $fields['post_item_padding'] = array ('padding' => '%%order_class%% .df-post-item');
        $fields['item_inner_margin'] = array ('margin' => $blog_item);
        $fields['item_inner_padding'] = array ('padding' => $blog_item);

        $fields['pagination_margin'] = array ('margin' => $pagination);
        $fields['pagination_padding'] = array ('padding' => $pagination);

        $fields['icon_margin'] = array ('margin' => $icon);
        $fields['icon_padding'] = array ('padding' => $icon);
        $fields['icon_size'] = array ('padding' => $icon);
        $fields['icon_color'] = array ('padding' => $icon);
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'icon_background',
            'selector'      => $icon
        ));
        
        // background
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'item_background',
            'selector'      => '%%order_class%% .df-post-item'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'outer_wrapper_background',
            'selector'      => '%%order_class%% .df-post-outer-wrap'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'inner_wrapper_background',
            'selector'      => $blog_item
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'pagination_background',
            'selector'      => $pagination
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'active_pagination_background',
            'selector'      => '%%order_class%% .pagination .page-numbers.current'
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
        $fields = $this->df_fix_border_transition(
            $fields, 
            'pagination', 
            $pagination
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
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'pagination',
            $pagination
        );

        return $fields;
    }
    
    public function additional_css_styles($render_slug) {

        $breakpoint = $this->props['use_breakpoint'] === 'on' ? sprintf('@media only screen and ( max-width: %1$s )', $this->props['breakpoint'] !== '' ? $this->props['breakpoint'] : '980px') : ET_Builder_Element::get_media_query('max_width_980');

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%',
            'declaration' => sprintf('
                --collapse-value: %1$s;
                --align-items: %2$s;
                --image-col-size: %3$s;
                --gap: %4$s;', 
                $this->props['collapse_value'] !== '' ? $this->props['collapse_value'] : '50px',
                $this->props['vertical_align'] ? $this->props['vertical_align'] : 'stretch',
                $this->props['image_col_size'] ? $this->props['image_col_size'] : '50%',
                $this->props['item_gap'] !== '' ? $this->props['item_gap'] : '30px'
            ),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%',
            'declaration' => sprintf('
                --flex-direction: column;
                --align-items: center;
                --order-2: unset;
                --collapse-value: 0;
                --gap: %1$s;', 
                $this->props['item_gap_mobile'] ? $this->props['item_gap_mobile'] : '30px'
            ),
            'media_query' => $breakpoint
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df-postlist-featured-image',
            'declaration' => sprintf('
                    width: %1$s;
                ', 
                $this->props['mobile_image_size'] ? $this->props['mobile_image_size'] : '100%'
            ),
            'media_query' => $breakpoint
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df-post-outer-wrap',
            'declaration' => sprintf('
                    width: %1$s;
                ', 
                $this->props['mobile_content_size'] ? $this->props['mobile_content_size'] : '100%'
            ),
            'media_query' => $breakpoint
        ));
        // featured image with equal height
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df-post-item.equal-height .df-postlist-featured-image a',
            'declaration' => sprintf('min-height: %1$s;', $this->props['image_min_height'])
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df-post-item.equal-height .df-postlist-featured-image a',
            'declaration' => sprintf('min-height: %1$s;', $this->props['mobile_image_min_height']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        // z-index
        if(isset($this->props['featured_image_index']) && $this->props['featured_image_index'] !== '0') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-postlist-featured-image',
                'declaration' => sprintf('z-index: %1$s !important;', $this->props['featured_image_index'])
            ));
        }
        if(isset($this->props['content_wrapper_index']) && $this->props['content_wrapper_index'] !== '0') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-post-outer-wrap',
                'declaration' => sprintf('z-index: %1$s !important;', $this->props['content_wrapper_index'])
            ));
        }

        // icon
        $this->generate_styles(
            array(
                'utility_arg'    => 'icon_font_family',
                'render_slug'    => $render_slug,
                'base_attr_name' => 'icon_image',
                'important'      => true,
                'selector'       => '%%order_class%% .df-pl-icon',
                'processor'      => array(
                    'ET_Builder_Module_Helper_Style_Processor',
                    'process_extended_icon'
                )
            )
        );
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_size',
            'type'              => 'font-size',
            'selector'          => '%%order_class%% .df-pl-icon',
            'hover'             => '%%order_class%% .df-pl-icon:hover'
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df-pl-icon',
            'hover'             => '%%order_class%% .df-pl-icon:hover'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "icon_background",
            'selector'          => '%%order_class%% .df-pl-icon',
            'hover'             => '%%order_class%% .df-pl-icon:hover'
        ));
        
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'alignment',
            'type'              => 'text-align',
            'selector'          => '%%order_class%% .df-post-inner-wrap'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_outer_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-post-outer-wrap',
            'hover'             => '%%order_class%% .df-post-outer-wrap:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_outer_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-post-outer-wrap',
            'hover'             => '%%order_class%% .df-post-outer-wrap:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'post_item_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-post-item',
            'hover'             => '%%order_class%% .df-post-item:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'post_item_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-post-item',
            'hover'             => '%%order_class%% .df-post-item:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_inner_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-post-inner-wrap',
            'hover'             => '%%order_class%% .df-hover-trigger:hover .df-post-inner-wrap',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_inner_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-post-inner-wrap',
            'hover'             => '%%order_class%% .df-hover-trigger:hover .df-post-inner-wrap',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pagination_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .pagination .page-numbers',
            'hover'             => '%%order_class%% .pagination .page-numbers:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pagination_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .pagination .page-numbers',
            'hover'             => '%%order_class%% .pagination .page-numbers:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-pl-icon',
            'hover'             => '%%order_class%% .df-pl-icon:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-pl-icon',
            'hover'             => '%%order_class%% .df-pl-icon:hover',
        ));
        // background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "item_background",
            'selector'          => "%%order_class%% .df-post-item",
            'hover'             => "%%order_class%% .df-post-item:hover"
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "outer_wrapper_background",
            'selector'          => "%%order_class%% .df-post-outer-wrap",
            'hover'             => "%%order_class%% .df-post-outer-wrap:hover .df-post-inner-wrap"
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "inner_wrapper_background",
            'selector'          => "%%order_class%% .df-post-inner-wrap",
            'hover'             => "%%order_class%% .df-hover-trigger:hover .df-post-inner-wrap"
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "pagination_background",
            'selector'          => '%%order_class%% .pagination .page-numbers:not(.current)',
            'hover'             => '%%order_class%% .pagination .page-numbers:not(.current):hover'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "active_pagination_background",
            'selector'          => '%%order_class%% .pagination .page-numbers.current',
            'hover'             => '%%order_class%% .pagination .page-numbers.current:hover',
            'important'         => true
        ));
        // pagination
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pagination_align',
            'type'              => 'justify-content',
            'selector'          => '%%order_class%% .pagination',
            'important'         => false,
            'default'           => 'center'
        ));
        // arrow icon
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .pagination .newer:after, %%order_class%% .pagination .next:after',
            'declaration' => sprintf('content: "%1$s" !important;', $this->arrow_icon($this->props['next_prev_icon'], 'next')),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .pagination .older:before, %%order_class%% .pagination .prev:before',
            'declaration' => sprintf('content: "%1$s" !important;', $this->arrow_icon($this->props['next_prev_icon'], 'prev')),
        ));

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
	 * Get blog posts for postlist module
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
        $layout                     = $this->props['layout'];
        $layout                     = $this->props['layout'] ? $this->props['layout'] : 'layout-1';
        $collapse                   = $this->props['collapse'] === 'on' && $this->props['vertical_align'] !== 'stretch' ? 'layout-collapse' : '';
        $current_post_id = $post->ID ;
        $image_size = $this->props['image_size'] !== '' ? $this->props['image_size'] : 'large';
        $image_scale = $this->props['image_scale'] ? $this->props['image_scale'] : 'no-image-scale';
        $equal_height = $this->props['equal_height'] ? $this->props['equal_height'] : 'off';
        $use_iamge = $this->props['use_iamge'] ? $this->props['use_iamge'] : 'on';
        $use_icon = $this->props['use_icon'] ? $this->props['use_icon'] : 'off';
        $icon_image = $this->props['icon_image'] ? esc_attr(et_pb_process_font_icon($this->props['icon_image'])) : '$';
        $query_args = array(
			'posts_per_page' => intval($this->props['posts_number']),
			'post_status'    => array( 'publish' ),
			'perm'           => 'readable',
			'post_type'      => 'post',
        );

        // post by categories
        if ( 'by_category' === $post_display) {
            //$query_args['cat'] = $this->props['include_categories'];
            $query_args['cat'] =  implode( ',', self::filter_include_categories( $this->props['include_categories'], $current_post_id ) );

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
		if ( is_single() ) { // Exclude Current post. This feature added from version 1.2.10
			$main_query_post = ET_Post_Stack::get_main_post();

			if ( null !== $main_query_post ) {
				$query_args['post__not_in'][] = $main_query_post->ID;
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
		} elseif ( is_singular() ) {
			// Force an empty result set in order to avoid loops over the current post.
			query_posts( array( 'post__in' => array( 0 ) ) ); // phpcs:ignore WordPress.WP.DiscouragedFunctions
			// $show_no_results_template = false;
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

        echo '<div class="df-posts-wrap list-'. esc_attr( $layout ).'">';

        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();

                $width = 'on' === 1080;
                // $width = 'on' === $fullwidth ? 1080 : 400;
				$width = (int) apply_filters( 'et_pb_blog_image_width', $width );

				$height    = 'on' === 675;
				$height    = (int) apply_filters( 'et_pb_blog_image_height', $height );

                $outer_content = '';
                $inner_content = '';
                $featured_image = $use_iamge === 'on' ? df_post_image_render(array(
                    'image_size'    => $image_size,
                    'image_scale'   => $image_scale,
                    'equal_height'  => $equal_height
                )) : '';
                $collapse_class = !empty($featured_image) && $equal_height !== 'on' ? $collapse : '';

                $classes = array(
                    'df-post-item',
                    $collapse_class,
                    empty($featured_image) ? 'no-thumbnail' : '',
                    $equal_height === 'on' ? 'equal-height' : '',
                    $use_icon === 'on' ? 'has-icon' : ''
                );
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( $classes ) ?>>
                    <?php if (!empty($featured_image)): ?>
                        <div class="df-postlist-featured-image">
                            <?php echo et_core_esc_previously( $featured_image ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($use_iamge != 'on' && $use_icon === 'on'): ?>
                        <div class="df-pl-icon"><?php echo esc_html( $icon_image ); ?></div>
                    <?php endif; ?>
                    <div class="df-post-outer-wrap df-hover-trigger">
                        <?php 
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

        // ajax navigation
        if ( 'on' === $this->props['show_pagination'] ) {
            if ( function_exists( 'wp_pagenavi' ) ) {
                wp_pagenavi();
            } else {
                add_filter( 'get_pagenum_link', array( 'DIFL_PostList', 'filter_pagination_url' ) );
                if ($this->props['use_number_pagination'] !== 'on') {
                    render_pagination(
                        $this->props['older_text'],
                        $this->props['newer_text']
                    );
                } else {
                    render_number_pagination(
                        $this->props['older_text'],
                        $this->props['newer_text']
                    );
                }
                remove_filter( 'get_pagenum_link', array( 'DIFL_PostList', 'filter_pagination_url' ) );
            }
        }

		$wp_the_query = $wp_query = $main_query; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
        wp_reset_query(); // phpcs:ignore WordPress.WP.DiscouragedFunctions
        
        $posts = ob_get_contents();
        ob_end_clean();
        if(empty($df_post_items)) {
            $posts = '';
        }
        $df_post_items = array();
        $df_post_items_outside = array();

        return $posts;
    }

    public static function filter_pagination_url( $result ) {
		return add_query_arg( 'df_blog', '', $result );
	}

    public function render( $attrs, $content, $render_slug ) {
        $this->handle_fa_icon();
        if ( $this->content === '' ) {
            return sprintf(
                '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Post Element.</strong></h2>'
            );
        }
        $this->additional_css_styles($render_slug);
        // wp_enqueue_script('imageload');
        if ($this->props['show_pagination'] !== 'off') {
			wp_enqueue_script( 'fitvids' );
		}
        wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );

        $data = array(
            'layout' => $this->props['layout']
        );

        return sprintf('<div class="df_postlist_container et_pb_ajax_pagination_container" data-settings=\'%2$s\'>%1$s</div>', 
            $this->get_posts(),
            wp_json_encode($data)
        );
    }

    /**
     * Render simple pagination
     * 
     * need to remove
     * 
     */
    function render_pagination( ) {
        echo '<div class="pagination clearfix">';
            echo '<div class="alignleft">';
                next_posts_link(esc_html__("&laquo; {$this->props['older_text']}",'divi_flash'));
            echo '</div>';
            echo '<div class="alignright">';
                previous_posts_link(esc_html__("{$this->props['newer_text']} &raquo;", 'divi_flash'));
            echo '</div>';
        echo '</div>';
    }

    /**
     * Render numbered pagination
     * 
     * need to remove
     * 
     */
    function render_number_pagination() {
        global $wp_query;
        $big = 9999999; // need an unlikely integer
        echo '<div class="pagination clearfix">';
        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
            'prev_text' => esc_html__("&laquo; {$this->props['older_text']}",'divi_flash'),
            'next_text' => esc_html__("{$this->props['newer_text']} &raquo;", 'divi_flash')
        ));
        echo '</div>';
    }
    /**
     * next and prev icons
     */
    public function arrow_icon( $set = 'set_1', $type = 'next' ) {
        $icons = array(
            'set_1'  => array(
                'next' => '5',
                'prev' => '4'
            ),
            'set_2' => array(
                'next' => '$',
                'prev' => '#'
            ),
            'set_3' => array(
                'next' => '9',
                'prev' => '8'
            ),
            'set_4' => array(
                'next' => 'E',
                'prev' => 'D'
            )
        );
        return $icons[$set][$type];
    }
    
    public function add_new_child_text() {
		return esc_html__( 'Add New Post Element', 'divi_flash' );
	}

}
new DIFL_PostList;


