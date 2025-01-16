<?php

class DIFL_PostGrid extends ET_Builder_Module_Type_PostBased {
    public $slug       = 'difl_postgrid';
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
        $this->name = esc_html__( 'Post Grid', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/postgrid.svg';
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
                    'content_align'         => esc_html__('Alignment', 'divi_flash'),
                    'layout'                => esc_html__('Layout', 'divi_flash'),
                    'item_outer_wrapper'    => esc_html__('Item Outer Wrapper', 'divi_flash'),
                    'item_inner_wrapper'    => esc_html__('Item Inner Wrapper', 'divi_flash'),
                    'pagination'            => esc_html__('Pagination Button Styles', 'divi_flash'),
                    'active_pagination'     => esc_html__('Active Pagination Number', 'divi_flash'),
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

        $layout = array(
            'layout'   => array(
                'label'             => esc_html__('Layout', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'grid'          => esc_html__('Grid', 'divi_flash'),
                    'masonry'       => esc_html__('Masonry', 'divi_flash')
                ),
                'default'           => 'grid',
                'toggle_slug'       => 'layout',
                'tab_slug'          => 'advanced'
            ),
            'column'   => array(
                'label'             => esc_html__('Column', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    '1'          => esc_html__('1 column', 'divi_flash'),
                    '2'          => esc_html__('2 columns', 'divi_flash'),
                    '3'          => esc_html__('3 columns', 'divi_flash'),
                    '4'          => esc_html__('4 columns', 'divi_flash'),
                    '5'          => esc_html__('5 columns', 'divi_flash')
                ),
                'default'           => '3',
                'toggle_slug'       => 'layout',
                'tab_slug'          => 'advanced',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'gutter'   => array (
                'label'             => esc_html__( 'Space Between', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'layout',
				'tab_slug'          => 'advanced',
				'default'           => '20px',
                'default_unit'      => 'px',
                'responsive'        => true,
                'mobile_options'    => true,
                'validate_unit'     => true,
                'unitless'          => true,
                'allowed_units'     => array( 'px' ),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
                )
            ),
            'equal_height'   => array(
                'label'             => esc_html__('Equal Height', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'on'            => esc_html__('On', 'divi_flash'),
                    'off'           => esc_html__('Off', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'layout',
                'tab_slug'          => 'advanced',
                'show_if_not'       => array(
                    'layout'        => 'masonry'
                )
            )
        );

        $pagination = array(
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
            ),

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
        $item_background = $this->df_add_bg_field(array (
			'label'				    => 'Blog Item Background',
            'key'                   => 'item_background',
            'toggle_slug'           => 'item_background',
            'tab_slug'              => 'general'
        ));
        $pagination_background = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'pagination_background',
            'toggle_slug'           => 'pagination',
            'tab_slug'              => 'advanced'
        ));
        $active_pagination_background = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'active_pagination_background',
            'toggle_slug'           => 'active_pagination',
            'tab_slug'              => 'advanced'
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
            // 'option'        => 'padding'
        ));
        $pagination_spacing = $this->add_margin_padding(array(
            'title'         => 'Pagination',
            'key'           => 'pagination',
            'toggle_slug'   => 'margin_padding'
        ));

        return array_merge(
            $settings,
            $alignment,
            $layout,
            $item_background,
            $pagination,
            $visibility,
            $pagination_background,
            $active_pagination_background,
            $wrapper_spacing,
            $item_wrapper_spacing,
            $item_spacing,
            $pagination_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $blog_item = '%%order_class%% .df-post-inner-wrap';
        $pagination = '%%order_class%% .pagination .page-numbers';

        $fields['item_wrapper_padding'] = array ('padding' => '%%order_class%% .df-post-outer-wrap');
        $fields['item_margin'] = array ('margin' => $blog_item);
        $fields['item_padding'] = array ('padding' => $blog_item);

        $fields['wrapper_margin'] = array ('margin' => '%%order_class%% .df-posts-wrap');
        $fields['wrapper_padding'] = array ('padding' => '%%order_class%% .df-posts-wrap');

        $fields['pagination_margin'] = array ('margin' => $pagination);
        $fields['pagination_padding'] = array ('padding' => $pagination);

        // background
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'item_background',
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
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'alignment',
            'type'              => 'text-align',
            'selector'          => '%%order_class%% .df-post-inner-wrap'
        ));
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
        // column
        if(isset($this->props['column']) && $this->props['column'] !== '') {
            $column_desktop = 100 / intval($this->props['column']) . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%.difl_postgrid .df-post-item',
                'declaration' => sprintf('width: %1$s;', $column_desktop),
            ));
        }
        if(isset($this->props['column_tablet']) && $this->props['column_tablet'] !== '') {
            $column_tablet = 100 / intval($this->props['column_tablet']) . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%.difl_postgrid .df-post-item',
                'declaration' => sprintf('width: %1$s;', $column_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }
        if(isset($this->props['column_phone']) && $this->props['column_phone'] !== '') {
            $column_phone = 100 / intval($this->props['column_phone']) . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%.difl_postgrid .df-post-item',
                'declaration' => sprintf('width: %1$s;', $column_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
        // gutter
        if(isset($this->props['gutter']) && $this->props['gutter'] !== '') {
            $gutter_desktop = intval($this->props['gutter']) / 2;
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-post-item',
                'declaration' => sprintf('padding-left: %1$spx; padding-right: %1$spx; padding-bottom: %2$spx;',
                    $gutter_desktop, intval($this->props['gutter'])
                )
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_postgrid_container .df-posts-wrap',
                'declaration' => sprintf('margin-left: -%1$spx; margin-right: -%1$spx;', $gutter_desktop)
            ));
        }
        // gutter tablet
        if(isset($this->props['gutter_tablet']) && $this->props['gutter_tablet'] !== '') {
            $gutter_tablet = intval($this->props['gutter_tablet']) / 2;
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-post-item',
                'declaration' => sprintf('padding-left: %1$spx; padding-right: %1$spx; padding-bottom: %2$spx;', $gutter_tablet, intval($this->props['gutter_tablet'])),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_postgrid_container .df-posts-wrap',
                'declaration' => sprintf('margin-left: -%1$spx; margin-right: -%1$spx;', $gutter_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }
        // gutter phone
        if(isset($this->props['gutter_phone']) && $this->props['gutter_phone'] !== '') {
            $gutter_phone = intval($this->props['gutter_phone']) / 2;
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-post-item',
                'declaration' => sprintf('padding-left: %1$spx; padding-right: %1$spx; padding-bottom: %2$spx;', $gutter_phone, intval($this->props['gutter_phone'])),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_postgrid_container .df-posts-wrap',
                'declaration' => sprintf('margin-left: -%1$spx; margin-right: -%1$spx;', $gutter_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
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
            'declaration' => sprintf('content: "%1$s";', $this->arrow_icon($this->props['next_prev_icon'], 'next')),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .pagination .older:before, %%order_class%% .pagination .prev:before',
            'declaration' => sprintf('content: "%1$s";', $this->arrow_icon($this->props['next_prev_icon'], 'prev')),
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
        $layout                     = $this->props['layout'];
        $use_image_as_background    = $this->props['use_image_as_background'];
        $use_background_scale       = $this->props['use_background_scale'];
	    $current_post_id = empty( $post ) ? 0 : $post->ID;
        $query_args = [
	        'posts_per_page'      => intval( $this->props['posts_number'] ),
	        'post_status'         => [ 'publish' ],
	        'perm'                => 'readable',
	        'post_type'           => 'post',
        ];

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
        $wp_query->query_vars['ignore_sticky_posts'] = true;
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

        echo '<div class="df-posts-wrap layout-'.esc_attr($layout).'">';

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
                <article id="post-<?php the_ID(); ?>" <?php post_class( "df-post-item v2{$equal_height_class}" ) ?>>
                    <div class="df-post-outer-wrap df-hover-trigger" <?php echo $use_background_scale !== 'on' ? et_core_esc_previously(df_post_image_as_background($use_image_as_background)): '';?>>
                        <?php
                            // render markup to achive the scale effect.
                            if($use_image_as_background === 'on' && $use_background_scale === 'on') {
                                echo '<div class="df-postgrid-bg-on-hover"><div ' .et_core_esc_previously(df_post_image_as_background($use_image_as_background)) .'></div></div>';
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

        // ajax navigation
        if ( 'on' === $this->props['show_pagination'] ) {
            if ( function_exists( 'wp_pagenavi' ) ) {
                wp_pagenavi();
            } else {
                add_filter( 'get_pagenum_link', array( 'DIFL_PostGrid', 'filter_pagination_url' ) );
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
                remove_filter( 'get_pagenum_link', array( 'DIFL_PostGrid', 'filter_pagination_url' ) );
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

        if ( $this->content === '' ) {
            return sprintf(
                '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Post Element.</strong></h2>'
            );
        }
        $this->additional_css_styles($render_slug);
        wp_enqueue_script('imageload');
        wp_enqueue_script('df-imagegallery-lib');
        if ($this->props['show_pagination'] !== 'off') {
			wp_enqueue_script( 'fitvids' );
		}
        wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );

        wp_enqueue_script('df-posts');

        $data = array(
            'layout' => $this->props['layout']
        );

        return sprintf('<div class="df_postgrid_container et_pb_ajax_pagination_container" data-settings=\'%2$s\'>%1$s</div>',
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
new DIFL_PostGrid;
