<?php

class DIFL_ProductGrid extends ET_Builder_Module_Type_PostBased {
    public $slug       = 'difl_productgrid';
    public $vb_support = 'on';
    public $child_slug = 'difl_productitem';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Product Grid', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/product-grid.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'settings'              => esc_html__('Settings', 'divi_flash'),
                    'pagination_sales_badge'              => esc_html__('Pagination & Sales Badge', 'divi_flash'),
                    'more_settings'              => esc_html__('More Settings', 'divi_flash'),
                    'item_background'       => esc_html__('Item Background', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'content_align'         => esc_html__('Alignment', 'divi_flash'),
                    'layout'                => esc_html__('Layout', 'divi_flash'),
                    'on_sale'      => array(
                        'title'             => esc_html__('Sales Badge Text', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
							'badge_text'     => array(
								'name' => 'Badge'
							),
                            'after_badge_text'     => array(
								'name' => 'After Text'
							),
                            'suffix_badge_text'     => array(
								'name' => 'Sufix Text'
							)
						)
                    ),
                    'on_sale_style'    => esc_html__('Sales Badge Style', 'divi_flash'),
                    'rating'                => esc_html__('Rating', 'divi_flash'),
                    'item_outer_wrapper'    => esc_html__('Item Outer Wrapper', 'divi_flash'),
                    'item_inner_wrapper'    => esc_html__('Item Inner Wrapper', 'divi_flash'),
                    'pagination'            => esc_html__('Pagination Styles', 'divi_flash'),
                    'active_pagination'     => esc_html__('Active Pagination Button', 'divi_flash'),
                    'pagination_result_count'=> esc_html__('Pagination Result Count', 'divi_flash'),
                    'pagination_sorting'     => esc_html__('Pagination Sorting', 'divi_flash'),
                    'df_overflow'         => esc_html__( 'Overflow', 'divi_flash' )
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();
        $advanced_fields['text'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['fonts'] = array(
            'on_sale_font'     => array(
                'label'           => et_builder_i18n( '' ),
                'css'             => array(
                    'main'          => "%%order_class%% .woocommerce-page ul.products li.product span.df-sale-badge.df-onsale,
                                        %%order_class%% .woocommerce ul.products li.product span.df-sale-badge.df-onsale",
                    'hover'         => "%%order_class%% .woocommerce-page ul.products li.product:hover span.df-sale-badge.df-onsale,
                                        %%order_class%% .woocommerce ul.products li.product:hover span.df-sale-badge.df-onsale",
                    'important'     => 'all'
                ),
                'hide_text_align'  => true,
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em'
                ),
                'font_size'       => array(
                    'default' => '16px',
                ),
                'toggle_slug'     => 'on_sale',
                'sub_toggle'      => 'badge_text'    
            ),
            'on_after_sale_font'     => array(
                'label'           => et_builder_i18n( '' ),
                'css'             => array(
                    'main'        => "%%order_class%% .woocommerce-page ul.products li.product .df-onsale span.after-text,
                                        %%order_class%% .woocommerce ul.products li.product .df-onsale span.after-text",
                    'hover'        => "%%order_class%% .woocommerce-page ul.products li.product:hover .df-onsale span.after-text,
                                        %%order_class%% .woocommerce ul.products li.product:hover .df-onsale span.after-text"
                ),
                'hide_text_align'  => true,
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '16px'
                ),
                'toggle_slug'     => 'on_sale',
                'sub_toggle'      => 'after_badge_text'
            ),
            'on_suffix_sale_font'     => array(
                'label'           => et_builder_i18n( '' ),
                'css'             => array(
                    'main'        => "%%order_class%% .woocommerce-page ul.products li.product .df-onsale span.after-sale-text,
                                        %%order_class%% .woocommerce ul.products li.product .df-onsale span.after-sale-text",
                    'hover'        => "%%order_class%% .woocommerce-page ul.products li.product:hover .df-onsale span.after-sale-text,
                                        %%order_class%% .woocommerce ul.products li.product:hover .df-onsale span.after-sale-text"
                ),
                'hide_text_align'  => true,
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '16px',
                ),
                'toggle_slug'     => 'on_sale',
                'sub_toggle'      => 'suffix_badge_text'
            ),
            'pagination'     => array(
                'label'           => et_builder_i18n( 'Pagination' ),
                'css'             => array(
                    'main'        => "%%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers,
                                    %%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers.dots,
                                    %%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers span.et-pb-icon",
                    'hover'        => "%%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers:hover",
                    'important' => 'all'
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em'
                ),
                'hide_font'       => true,
                'toggle_slug'     => 'pagination'

            ),
            'active_pagination'     => array(
                'label'           => et_builder_i18n( 'Pagination' ),
                'css'             => array(
                    'main'        => "%%order_class%% .woocommerce nav.woocommerce-pagination ul li span.current",
                    'hover'       => "%%order_class%% .woocommerce nav.woocommerce-pagination ul li span.current:hover",
                    'important'   => 'all'
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em'
                ),
                'hide_font'       => true,
                'font_size'       => array(
                    'default' => '14px',
                ),
                'toggle_slug'     => 'active_pagination'
            ),
            'pagination_result_count'     => array(
                'label'           => et_builder_i18n( '' ),
                'css'             => array(
                    'main'        => "%%order_class%% .woocommerce .woocommerce-result-count",
                    'hover'        => "%%order_class%% .woocommerce .woocommerce-result-count:hover"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '14px',
                ),
                'toggle_slug'     => 'pagination_result_count'
            ),
            'pagination_sorting'     => array(
                'label'           => et_builder_i18n( '' ),
                'css'             => array(
                    'main'        => "%%order_class%% .woocommerce .woocommerce-ordering select",
                    'hover'        => "%%order_class%% .woocommerce .woocommerce-ordering select:hover"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '14px',
                ),
                'toggle_slug'     => 'pagination_sorting'
            ),
            
        );

        $advanced_fields['borders'] = array (
            'item_outer'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-product-outer-wrap',
                        'border_radii_hover' => '%%order_class%% .df-product-outer-wrap:hover',
                        'border_styles' => '%%order_class%% .df-product-outer-wrap',
                        'border_styles_hover' => '%%order_class%% .df-product-outer-wrap:hover'
                    )
                ),
              
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_outer_wrapper',
                'label_prefix'      => 'Item'
            ),
            'item'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-product-inner-wrap',
                        'border_radii_hover' => '%%order_class%% .df-product-inner-wrap:hover',
                        'border_styles' => '%%order_class%% .df-product-inner-wrap',
                        'border_styles_hover' => '%%order_class%% .df-product-inner-wrap:hover'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_inner_wrapper',
                'label_prefix'      => 'Item'
            ),
            'on_sale_border'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_productgrid{$this->main_css_element} .woocommerce ul.products li.product span.df-sale-badge.df-onsale",
                        'border_radii_hover' => ".difl_productgrid{$this->main_css_element} .woocommerce ul.products li.product:hover span.df-sale-badge.df-onsale",
                        'border_styles' => ".difl_productgrid{$this->main_css_element} .woocommerce ul.products li.product span.df-sale-badge.df-onsale",
                        'border_styles_hover' => ".difl_productgrid{$this->main_css_element} .woocommerce ul.products li.product:hover span.df-sale-badge.df-onsale"
                    ),
                    'important' => 'all',
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'on_sale_style'
            ),
            'pagination'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii'      =>  '%%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers , 
                                                %%order_class%% .woocommerce nav.woocommerce-pagination ul li span.current ,
                                                %%order_class%% .woocommerce nav.woocommerce-pagination ul li span.page-numbers.dots',
                        'border_radii_hover'=> '%%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers:hover,
                                                %%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers.dots:hover',
                        'border_styles' =>      '%%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers , 
                                                %%order_class%% .woocommerce nav.woocommerce-pagination ul li span.current,
                                                %%order_class%% .woocommerce nav.woocommerce-pagination ul li span.page-numbers.dots',
                        'border_styles_hover'=> '%%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers:hover ,
                                                %%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers.dots:hover'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'pagination'
            ),
            'active_pagination'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .woocommerce nav.woocommerce-pagination ul li span.current',
                        'border_radii_hover' => '%%order_class%% .woocommerce nav.woocommerce-pagination ul li span.current:hover',
                        'border_styles' => '%%order_class%% .woocommerce nav.woocommerce-pagination ul li span.current',
                        'border_styles_hover' => '%%order_class%% .woocommerce nav.woocommerce-pagination ul li span.current:hover'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'active_pagination'
            ),

            'pagination_result_count'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .woocommerce .woocommerce-result-count',
                        'border_radii_hover' => '%%order_class%% .woocommerce .woocommerce-result-count:hover',
                        'border_styles' => '%%order_class%% .woocommerce .woocommerce-result-count',
                        'border_styles_hover' => '%%order_class%% .woocommerce .woocommerce-result-count:hover'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'pagination_result_count'
            ),

            'pagination_sorting_border'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .woocommerce .woocommerce-ordering select',
                        'border_radii_hover' => '%%order_class%% .woocommerce .woocommerce-ordering select:hover',
                        'border_styles' => '%%order_class%% .woocommerce .woocommerce-ordering select',
                        'border_styles_hover' => '%%order_class%% .woocommerce .woocommerce-ordering select:hover'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'pagination_sorting'
            ),
        );

        $advanced_fields['box_shadow'] = array(
            'item_outer'      => array(
                'css' => array(
                    'main' => "%%order_class%% .df-product-outer-wrap",
                    'hover' => "%%order_class%% .df-product-outer-wrap:hover"
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_outer_wrapper'
            ),
            'item'      => array(
                'css' => array(
                    'main' => "%%order_class%% .df-product-inner-wrap",
                    'hover' => "%%order_class%% .df-product-inner-wrap:hover"
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_inner_wrapper'
            ),
            'on_sale'      => array(
                'css' => array(
                    'main' => "%%order_class%% .woocommerce-page ul.products li.product span.df-sale-badge.df-onsale,
                                %%order_class%% .woocommerce ul.products li.product span.df-sale-badge.df-onsale",
                    'hover' => "%%order_class%% .woocommerce-page ul.products li.product:hover span.df-sale-badge.df-onsale,
                                %%order_class%% .woocommerce ul.products li.product:hover span.df-sale-badge.df-onsale",
                    'important'=> 'all'
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'on_sale_style',
            ),
            'pagination'      => array(
                'css' => array(
                    'main' => "%%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers",
                    'hover' => "%%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers:hover"
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'pagination'
            ),
            'active_pagination'      => array(
                'css' => array(
                    'main' => "%%order_class%% .woocommerce nav.woocommerce-pagination ul li span.current",
                    'hover' => "%%order_class%% .woocommerce nav.woocommerce-pagination ul li span.current:hover"
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'active_pagination'
            ),
            'pagination_result_count'      => array(
                'css' => array(
                    'main' => "%%order_class%% .woocommerce .woocommerce-result-count",
                    'hover' => "%%order_class%% .woocommerce .woocommerce-result-count:hover"
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'pagination_result_count'
            ),
            'pagination_sorting_boxshadow'      => array(
                'css' => array(
                    'main' => "%%order_class%% .woocommerce .woocommerce-ordering select",
                    'hover' => "%%order_class%% .woocommerce .woocommerce-ordering select:hover"
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'pagination_sorting'
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
            // Content
			'type' => array(
				'label'           => esc_html__( 'Type', 'divi_flash' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
                    'default'          => esc_html__( 'Default Products', 'divi_flash' ),
					'latest'  => esc_html__( 'Latest Products', 'divi_flash' ),
					'featured' => esc_html__( 'Featured Products', 'divi_flash' ),
					'sale' => esc_html__( 'Sale Products', 'divi_flash' ),
					'best_selling' => esc_html__( 'Best Selling Products', 'divi_flash' ),
					'top_rated' => esc_html__( 'Top Rated Products', 'divi_flash' ),
					'product_category' => esc_html__( 'Product Category', 'divi_flash' )
				),
				'default_on_front' => 'default',
				'affects'        => array(
					'include_categories'
				),
				'description'      => esc_html__( 'Choose which type of products you would like to display.', 'divi_flash' ),
				'toggle_slug'      => 'settings'
			),
            'use_current_loop'    => array(
				'label'            => esc_html__( 'Use Current Page', 'divi_flash' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'Yes' ),
					'off' => et_builder_i18n( 'No' )
				),
				'description'      => esc_html__( 'Only include products for the current page. Useful on archive and index pages. For example let\'s say you used this module on a Theme Builder layout that is enabled for product categories. Selecting the "Sale Products" view type above and enabling this option would show only products that are on sale when viewing product categories.', 'divi_flash' ),
				'toggle_slug'      => 'settings',
				'default'          => 'off',
                'show_if'          => array(
					'function.isTBLayout' => 'on'
				),
				'show_if_not'       => array(
					'type' => 'product_category'
				),
			),
			'include_categories'   => array(
				'label'            => esc_html__( 'Include Categories', 'divi_flash' ),
				'type'             => 'categories',
                'meta_categories'  => array(
					'all'     => esc_html__( 'All Categories', 'et_builder' ),
					'current' => esc_html__( 'Current Category', 'et_builder' )
				),
				'renderer_options' => array(
					'use_terms'    => true,
					'term_name'    => 'product_cat'
				),
				'depends_show_if'  => 'product_category',
				'description'      => esc_html__( 'Choose which categories you would like to include.', 'divi_flash' ),
				'taxonomy_name'    => 'product_cat',
				'toggle_slug'      => 'settings'
			),
			'posts_number' => array(
				'default'           => '12',
				'label'             => esc_html__( 'Product Count', 'divi_flash' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Define the number of products that should be displayed per page.', 'divi_flash' ),
				'toggle_slug'       => 'settings'
			),
			'orderby' => array(
				'label'             => esc_html__( 'Order By', 'divi_flash' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'default_order'  => esc_html__( 'Default Sorting', 'divi_flash' ),
					'menu_order'  => esc_html__( 'Sort By Menu order', 'divi_flash' ),
					'popularity' => esc_html__( 'Sort By Popularity', 'divi_flash' ),
					'rating' => esc_html__( 'Sort By Rating', 'divi_flash' ),
					'date' => esc_html__( 'Sort By Date: Oldest To Newest', 'divi_flash' ),
					'date-desc' => esc_html__( 'Sort By Date: Newest To Oldest', 'divi_flash' ),
					'price' => esc_html__( 'Sort By Price: Low To High', 'divi_flash' ),
					'price-desc' => esc_html__( 'Sort By Price: High To Low', 'divi_flash' ),
					'rand' => esc_html__( 'Sort By Random', 'divi_flash' )
				),
				'default_on_front' => 'date-desc',
				'default' => 'date-desc',
				'description'       => esc_html__( 'Choose how your products should be ordered.', 'divi_flash' ),
				'toggle_slug'       => 'settings',
                'show_if_not'      => array(
					'type' => 'latest'
				)
			)
            	
        );
        $content= array(
            'show_pagination'     => array(
				'label'            => esc_html__( 'Show Pagination', 'divi_flash' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'Yes' ),
					'off' => et_builder_i18n( 'No' )
				),
				'default'          => 'on',
				'description'      => esc_html__( 'Turn pagination on and off.', 'divi_flash' ),
				'toggle_slug'      => 'pagination_sales_badge',
				'mobile_options'   => true
			),
            'show_pagination_result_count'     => array(
				'label'            => esc_html__( 'Show result Count', 'divi_flash' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'Yes' ),
					'off' => et_builder_i18n( 'No' )
				),
				'default'          => 'off',
				'description'      => esc_html__( 'Turn Pagination result Count on and off.', 'divi_flash' ),
				'toggle_slug'      => 'pagination_sales_badge',
                'show_if' => array(
                    'show_pagination' => 'on'
                )
			),
            'show_pagination_sorting'     => array(
				'label'            => esc_html__( 'Show sorting', 'divi_flash' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'Yes' ),
					'off' => et_builder_i18n( 'No' )
				),
				'default'          => 'off',
				'description'      => esc_html__( 'Turn Pagination sorting on and off.', 'divi_flash' ),
				'toggle_slug'      => 'pagination_sales_badge',
                'show_if' => array(
                    'show_pagination' => 'on'
                )
			),
            'show_badge'       => array(
                'label'            => esc_html__( 'Show Badge', 'divi_flash' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'Yes' ),
					'off' => et_builder_i18n( 'No' )
				),
				'default'          => 'off',
				'description'      => esc_html__( 'Turn Badge on and off.', 'divi_flash' ),
				'toggle_slug'      => 'pagination_sales_badge'
            ),
            'show_badge_in_image'       => array(
                'label'            => esc_html__( 'Show Badge In Image Container', 'divi_flash' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'Yes' ),
					'off' => et_builder_i18n( 'No' )
				),
				'default'          => 'off',
				'description'      => esc_html__( 'Turn Badge In Image on and off.', 'divi_flash' ),
				'toggle_slug'      => 'pagination_sales_badge',
                'show_if' => array(
                    'show_badge' => 'on'
                )
            ),
            'badge_placement'=> array(
                'label'             => esc_html__( 'Badge Placement', 'divi_flash' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'top_left'  => esc_html__( 'Top Left', 'divi_flash' ),
					'top_center' => esc_html__( 'Top Center', 'divi_flash' ),
                    'top_right' => esc_html__( 'Top Right', 'divi_flash' ),
                    'center_left'  => esc_html__( 'Center Left', 'divi_flash' ),
					'center_center' => esc_html__( 'Center Center', 'divi_flash' ),
                    'center_right' => esc_html__( 'Center Right', 'divi_flash' ),
                    'bottom_left'  => esc_html__( 'Bottom Left', 'divi_flash' ),
					'bottom_center' => esc_html__( 'Bottom Center', 'divi_flash' ),
                    'bottom_right' => esc_html__( 'Bottom Right', 'divi_flash' )
				),
				'default' => 'top_left',
				'description'       => esc_html__( 'Choose Badge Placement.', 'divi_flash' ),
				'toggle_slug'       => 'pagination_sales_badge',
                'show_if' => array(
                    'show_badge' => 'on'
                )
            ),
            'on_sale_text'    => array(
                'label'                 => esc_html__('Badge Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'pagination_sales_badge',
                'show_if' => array(
                    'show_badge' => 'on'
                )
            ),
     
            'after_sale_text_enable'       => array(
                'label'            => esc_html__( 'After Badge Text Enable', 'divi_flash' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'Yes' ),
					'off' => et_builder_i18n( 'No' )
				),
				'default'          => 'off',
				'description'      => esc_html__( 'After Badge Turn on and off.', 'divi_flash' ),
				'toggle_slug'      => 'pagination_sales_badge',
                'show_if' => array(
                    'show_badge' => 'on'
                )
            ),        
            'after_sale_text_type'=> array(
                'label'             => esc_html__( 'After Badge Text Type', 'divi_flash' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'price-percentise'  => esc_html__( 'Price Percentise', 'divi_flash' ),
					'price-difference' => esc_html__( 'Price Difference', 'divi_flash' ),
                    'both-percentise-difference' => esc_html__( 'Both Percentise & Difference', 'divi_flash' )
				),
				'default_on_front' => 'price-percentise',
				'default' => 'price-percentise',
				'description'       => esc_html__( 'Choose how your after Badge Text Type.', 'divi_flash' ),
				'toggle_slug'       => 'pagination_sales_badge',
                'show_if' => array(
                    'show_badge' => 'on',
                    'after_sale_text_enable' => 'on'
                )
            ),
            'after_sale_text'    => array(
                'label'                 => esc_html__('Suffix Badge Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'pagination_sales_badge',
                'show_if' => array(
                    'show_badge' => 'on',
                    'after_sale_text_enable' => 'on'
                )
            ),

            'enable_custom_soldout_text'       => array(
                'label'            => esc_html__( 'Enable Custom SoldOut Text', 'divi_flash' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'Yes' ),
					'off' => et_builder_i18n( 'No' )
				),
				'default'          => 'off',
				'toggle_slug'      => 'pagination_sales_badge',
                'show_if' => array(
                    'show_badge' => 'on'
                )
            ),
            'custom_soldout_text'    => array(
                'label'                 => esc_html__('SoldOut Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'pagination_sales_badge',
                'show_if' => array(
                    'show_badge' => 'on',
                    'enable_custom_soldout_text' => 'on'
                )
            ),

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
                    '2'          => esc_html__('2 colums', 'divi_flash'),
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
					'step' => '1'
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
            ),
        );
    
    
        $pagination = array(
            'pagination_align'   => array(
                'label'             => esc_html__('Pagination Alignment', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'center'          => esc_html__('Center', 'divi_flash'),
                    'left'      => esc_html__('Left', 'divi_flash'),
                    'right'        => esc_html__('Right', 'divi_flash'),
                    'justified'   => esc_html__('Justified', 'divi_flash')
                ),
                'default'           => 'center',
                'toggle_slug'       => 'pagination',
                'tab_slug'          => 'advanced',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if' => array(
                    'show_pagination' => 'on'
                )
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
                'mobile_options'    => true,
                'show_if' => array(
                    'show_pagination' => 'on'
                )
            ),
            'next_prev_icon_color' => array(
                'label'                 => esc_html__('Next & Prev Icon Color', 'divi_flash'),
                'type'            => 'color-alpha',
                'toggle_slug'       => 'pagination',
                'tab_slug'          => 'advanced',
                'show_if'         => array(
                    'blurb_icon_enable'     => 'on'
                ),
                'hover'            => 'tabs',
                'show_if' => array(
                    'show_pagination' => 'on'
                )
            ),
            'next_prev_icon_size' => array(
                'label'             => esc_html__('Next & Prev Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'pagination',
                'tab_slug'          => 'advanced',
                'default'           => '14px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'show_pagination'     => 'on'
                ),
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
        $on_sale_background = $this->df_add_bg_field(array (
			'label'				    => 'On Sale Background',
            'key'                   => 'on_sale_background',
            'toggle_slug'           => 'on_sale_style',
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'show_if'               => array(
                'show_badge' => 'on'
            )
        ));
        $item_background = $this->df_add_bg_field(array (
			'label'				    => 'Product Item Background',
            'key'                   => 'item_background',
            'toggle_slug'           => 'item_background',
            'tab_slug'              => 'general'
        )); 

        $pagination_wrapper_background = $this->df_add_bg_field(array (
			'label'				    => 'Wrapper Background',
            'key'                   => 'pagination_wrapper_background',
            'toggle_slug'           => 'pagination',
            'tab_slug'              => 'advanced'
        ));

        $pagination_background = $this->df_add_bg_field(array (
			'label'				    => 'Button Background',
            'key'                   => 'pagination_background',
            'toggle_slug'           => 'pagination',
            'tab_slug'              => 'advanced'
        ));

        $active_pagination_background = $this->df_add_bg_field(array (
			'label'				    => 'Active Button Background',
            'key'                   => 'active_pagination_background',
            'toggle_slug'           => 'active_pagination',
            'tab_slug'              => 'advanced'
        ));
        $pagination_result_count_background = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'pagination_result_count_background',
            'toggle_slug'           => 'pagination_result_count',
            'tab_slug'              => 'advanced'
        ));
        $pagination_sorting_background = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'pagination_sorting_background',
            'toggle_slug'           => 'pagination_sorting',
            'tab_slug'              => 'advanced'
        ));
        $wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Container',
            'key'           => 'wrapper',
            'toggle_slug'   => 'margin_padding'
        ));
        $item_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Product Item Outer Wrapper',
            'key'           => 'item_wrapper',
            'toggle_slug'   => 'margin_padding',
            'option'        => 'padding'
        ));
        $item_spacing = $this->add_margin_padding(array(
            'title'         => 'Product Item Inner Wrapper',
            'key'           => 'item',
            'toggle_slug'   => 'margin_padding'
        ));
        $on_sale_spacing = $this->add_margin_padding(array(
            'title'         => 'sale',
            'key'           => 'on_sale',
            'toggle_slug'   => 'margin_padding'
        ));

        $pagination_result_count_spacing = $this->add_margin_padding(array(
            'title'         => 'Pagination Result Count',
            'key'           => 'pagination_result_count',
            'toggle_slug'   => 'margin_padding'
        ));

        $pagination_sorting_spacing = $this->add_margin_padding(array(
            'title'         => 'Pagination Sorting',
            'key'           => 'pagination_sorting',
            'toggle_slug'   => 'margin_padding'
        ));

        $pagination_spacing = $this->add_margin_padding(array(
            'title'         => 'Pagination Button',
            'key'           => 'pagination',
            'toggle_slug'   => 'margin_padding'
        ));

        $pagination_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Pagination Wrapper',
            'key'           => 'pagination_wrapper',
            'toggle_slug'   => 'margin_padding'
        ));

        return array_merge(
            $settings,
            $content,
            $alignment,
            $layout,
            $item_background,
            $on_sale_background,
            $pagination_wrapper_background,
            $pagination,
            $pagination_background,
            $active_pagination_background,
            $pagination_result_count_background,
            $pagination_sorting_background,
            $wrapper_spacing,
            $item_wrapper_spacing,
            $item_spacing,
            $on_sale_spacing,       
            $pagination_wrapper_spacing ,
            $pagination_spacing,
            $pagination_result_count_spacing,
            $pagination_sorting_spacing,
            $visibility
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $product_item = '%%order_class%% .df-product-inner-wrap';
        $on_sale = '%%order_class%% .woocommerce ul.products li.product .df-onsale';
        $pagination = '%%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers';
        $pagination_wrapper = '%%order_class%% .woocommerce nav.woocommerce-pagination';
        $pagination_result_count = '%%order_class%% .woocommerce .woocommerce-result-count';
        $pagination_sorting = '%%order_class%% .woocommerce .woocommerce-ordering select';

        $fields['item_wrapper_padding'] = array ('padding' => '%%order_class%% .df-product-outer-wrap');
        $fields['item_margin'] = array ('margin' => $product_item);
        $fields['item_padding'] = array ('padding' => $product_item);

        $fields['wrapper_margin'] = array ('margin' => '%%order_class%% .df-products-wrap');
        $fields['wrapper_padding'] = array ('padding' => '%%order_class%% .df-products-wrap');
        
        $fields['on_sale_margin'] = array ('margin' => $on_sale);
        $fields['on_sale_padding'] = array ('padding' => $on_sale);

        $fields['pagination_margin'] = array ('margin' => $pagination);
        $fields['pagination_padding'] = array ('padding' => $pagination);
        $fields['next_prev_icon_color'] = array('color' => "%%order_class%% .woocommerce nav.woocommerce-pagination ul li span.et-pb-icon");
        $fields['pagination_wrapper_margin'] = array ('margin' => $pagination_wrapper);
        $fields['pagination_wrapper_padding'] = array ('padding' => $pagination_wrapper);

        $fields['pagination_result_count_margin'] = array ('margin' => $pagination_result_count);
        $fields['pagination_result_count_padding'] = array ('padding' => $pagination_result_count);
        $fields['pagination_sorting_margin'] = array ('margin' => $pagination_sorting);
        $fields['pagination_sorting_padding'] = array ('padding' => $pagination_sorting);
        
        // background
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'item_background',
            'selector'      => $product_item
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'pagination_wrapper_background',
            'selector'      => $pagination_wrapper
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'pagination_background',
            'selector'      => $pagination
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'on_sale_background',
            'selector'      => $on_sale
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'active_pagination_background',
            'selector'      => '%%order_class%% .woocommerce nav.woocommerce-pagination ul li span.current'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'pagination_result_count',
            'selector'      => $pagination_result_count
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'pagination_sorting_background',
            'selector'      => $pagination_sorting
        ));
        // border
        $fields = $this->df_fix_border_transition(
            $fields, 
            'item_outer', 
            '%%order_class%% .df-product-outer-wrap'
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'item', 
            $product_item
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'on_sale_border', 
            $on_sale
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'pagination', 
            $pagination
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'pagination_result_count', 
            $pagination_result_count
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'pagination_sorting_border', 
            $pagination_sorting
        );
        // box-shadow
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'item_outer',
            '%%order_class%% .df-product-outer-wrap'
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'item',
            $product_item
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'on_sale',
            $on_sale
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'pagination',
            $pagination
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'pagination_result_count',
            $pagination_result_count
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'pagination_sorting_boxshadow',
            $pagination_sorting
        );
        return $fields;
    }
    
    public function additional_css_styles($render_slug) {
        if($this->props['show_badge'] ==='on'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% span.df-onsale:not(.df-sale-badge)',
                'declaration' => sprintf('display:none;')
            ));
        }

        if($this->props['show_pagination_result_count'] ==='off'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .woocommerce .woocommerce-result-count',
                'declaration' => sprintf('display:none;')
            ));
        }

        if($this->props['show_pagination_sorting'] ==='off'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .woocommerce .woocommerce-ordering',
                'declaration' => sprintf('display:none;')
            ));
        }

        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'alignment',
            'type'              => 'text-align',
            'selector'          => '%%order_class%% .df-product-inner-wrap'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-product-outer-wrap',
            'hover'             => '%%order_class%% .df-product-outer-wrap:hover'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-product-inner-wrap',
            'hover'             => '%%order_class%% .df-hover-trigger:hover .df-product-inner-wrap'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-product-inner-wrap',
            'hover'             => '%%order_class%% .df-hover-trigger:hover .df-product-inner-wrap'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'on_sale_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .woocommerce ul.products li.product .df-onsale',
            'hover'             => '%%order_class%% .woocommerce ul.products li.product:hover .df-onsale'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'on_sale_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .woocommerce ul.products li.product .df-onsale',
            'hover'             => '%%order_class%% .woocommerce ul.products li.product:hover .df-onsale'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pagination_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .woocommerce nav.woocommerce-pagination ul .page-numbers',
            'hover'             => '%%order_class%% .woocommerce nav.woocommerce-pagination ul .page-numbers:hover'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pagination_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .woocommerce nav.woocommerce-pagination ul .page-numbers',
            'hover'             => '%%order_class%% .woocommerce nav.woocommerce-pagination ul .page-numbers:hover'
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pagination_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .woocommerce nav.woocommerce-pagination',
            'hover'             => '%%order_class%% .woocommerce nav.woocommerce-pagination:hover'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pagination_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .woocommerce nav.woocommerce-pagination',
            'hover'             => '%%order_class%% .woocommerce nav.woocommerce-pagination:hover'
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pagination_result_count_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .woocommerce .woocommerce-result-count',
            'hover'             => '%%order_class%% .woocommerce .woocommerce-result-count:hover'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pagination_result_count_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .woocommerce .woocommerce-result-count',
            'hover'             => '%%order_class%% .woocommerce .woocommerce-result-count:hover'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pagination_sorting_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .woocommerce .woocommerce-ordering select',
            'hover'             => '%%order_class%% .woocommerce .woocommerce-ordering select:hover'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'pagination_sorting_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .woocommerce .woocommerce-ordering select',
            'hover'             => '%%order_class%% .woocommerce .woocommerce-ordering select:hover'
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-products-wrap',
            'hover'             => '%%order_class%% .df-products-wrap:hover'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-products-wrap',
            'hover'             => '%%order_class%% .df-products-wrap:hover'
        ));
        // background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "item_background",
            'selector'          => "%%order_class%% .df-product-inner-wrap",
            'hover'             => "%%order_class%% .df-hover-trigger:hover .df-product-inner-wrap"
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "on_sale_background",
            'selector'          => '%%order_class%% .woocommerce-page ul.products li.product .df-onsale, 
                                     %%order_class%% .woocommerce ul.products li.product .df-onsale',
            'hover'             => '%%order_class%% .woocommerce ul.products li.product:hover .df-onsale,
                                    %%order_class%% .woocommerce ul.products li.product:hover .df-onsale',
            'important'         => true
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "pagination_wrapper_background",
            'selector'          => '%%order_class%% .woocommerce nav.woocommerce-pagination ',
            'hover'             => '%%order_class%% .woocommerce nav.woocommerce-pagination:hover'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "pagination_background",
            'selector'          => '%%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers',
            'hover'             => '%%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers:hover'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "active_pagination_background",
            'selector'          => '%%order_class%% .woocommerce nav.woocommerce-pagination ul li span.current',
            'hover'             => '%%order_class%% .woocommerce nav.woocommerce-pagination ul li span.current:hover',
            'important'         => true
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "pagination_result_count_background",
            'selector'          => '%%order_class%% .woocommerce .woocommerce-result-count',
            'hover'             => '%%order_class%% .woocommerce .woocommerce-result-count:hover'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "pagination_sorting_background",
            'selector'          => '%%order_class%% .woocommerce .woocommerce-ordering select',
            'hover'             => '%%order_class%% .woocommerce .woocommerce-ordering select:hover'
        ));
        if(isset($this->props['column']) && $this->props['column'] !== '') {
            $column_desktop = 100 / intval($this->props['column']) . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .woocommerce ul.products li.product',
                'declaration' => sprintf('width: %1$s !important;', $column_desktop)
            ));
        }
        if(isset($this->props['column_tablet']) && $this->props['column_tablet'] !== '') {
            $column_tablet = 100 / intval($this->props['column_tablet']) . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .woocommerce ul.products li.product',
                'declaration' => sprintf('width: %1$s !important;', $column_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }
        if(isset($this->props['column_phone']) && $this->props['column_phone'] !== '') {
            $column_phone = 100 / intval($this->props['column_phone']) . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .woocommerce ul.products li.product',
                'declaration' => sprintf('width: %1$s !important;', $column_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .woocommerce ul.products li.product, %%order_class%% .woocommerce-page ul.products li.product',
            'declaration' => sprintf('margin: 0px !important;')
        ));
    
        // gutter
        if(isset($this->props['gutter']) && $this->props['gutter'] !== '') {
            $gutter_desktop = intval($this->props['gutter']) / 2;
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% ul.products li.product',
                'declaration' => sprintf('padding-left: %1$spx; padding-right: %1$spx; padding-bottom: %2$spx;', 
                    $gutter_desktop, intval($this->props['gutter'])
                )
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% ul.products',
                'declaration' => sprintf('margin-left: -%1$spx !important; margin-right: -%1$spx !important;', $gutter_desktop)
                
            ));
            
        }
        // gutter tablet
        if(isset($this->props['gutter_tablet']) && $this->props['gutter_tablet'] !== '') {
            $gutter_tablet = intval($this->props['gutter_tablet']) / 2;
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% ul.products li.product',
                'declaration' => sprintf('padding-left: %1$spx; padding-right: %1$spx; padding-bottom: %2$spx;', $gutter_tablet, intval($this->props['gutter_tablet'])),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% ul.products',
                'declaration' => sprintf('margin-left: -%1$spx !important; margin-right: -%1$spx !important;', $gutter_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));

        }
        // gutter phone
        if(isset($this->props['gutter_phone']) && $this->props['gutter_phone'] !== '') {
            $gutter_phone = intval($this->props['gutter_phone']) / 2;
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% ul.products li.product',
                'declaration' => sprintf('padding-left: %1$spx; padding-right: %1$spx; padding-bottom: %2$spx;', $gutter_phone, intval($this->props['gutter_phone'])),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% ul.products',
                'declaration' => sprintf('margin-left: -%1$spx !important; margin-right: -%1$spx !important;', $gutter_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
                
            ));

        }
        
        // pagination
        if($this->props['show_pagination'] === 'on'){
         
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'pagination_align',
                'type'              => 'text-align',
                'selector'          => '%%order_class%% .woocommerce nav.woocommerce-pagination',
                'important'         => false,
                'default'           => 'center'
            ));

            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'next_prev_icon_color',
                'type'              => 'color',
                'selector'          => "%%order_class%% .woocommerce nav.woocommerce-pagination ul li span.et-pb-icon",
                'hover'             => "%%order_class%% .woocommerce nav.woocommerce-pagination ul li:hover span.et-pb-icon",
                'important'         => true
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'next_prev_icon_size',
                'type'              => 'font-size',
                'selector'          => "%%order_class%% .woocommerce nav.woocommerce-pagination ul li .page-numbers span.et-pb-icon",
                'hover'             => "%%order_class%% .woocommerce nav.woocommerce-pagination ul li:hover .page-numbers span.et-pb-icon",
                'important'         => true
            ));

        }

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'blurb_icon_color',
            'type'              => 'color',
            'selector'          => "%%order_class%% .et-pb-icon.df-blurb-icon",
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .et-pb-icon.df-blurb-icon'
        ));

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_size',
            'type'              => 'font-size',
            'selector'          => "%%order_class%% .et-pb-icon.df-blurb-icon",
            'hover'             => '%%order_class%% .df_ab_blurb_container:hover .et-pb-icon.df-blurb-icon'
        ));


       // Sale badges position items
        $tanslate_values = array(
            'top_left' => 'top: 0px !important; left: 0 !important; transform: none !important;',
            'top_center' => 'top: 0px !important; left: 50% !important; transform: translateX(-50%) !important;',
            'top_right' => 'top:0px !important; left: 100% !important; transform: translate(-100%) !important;',   
            'center_left' => 'left: 0px !important; top: 50% !important; transform: translateY(-50%) !important;',
            'center_center' => 'left: 50% !important; top:50% !important; transform: translate(-50%, -50%) !important;',
            'center_right' => 'left: 100% !important; top: 50% !important; transform: translate(-100%, -50%) !important;',
            'bottom_left' => 'left:0px !important; top: 100% !important; transform: translateY(-100%) !important;',
            'bottom_center' => 'left: 50% !important; top:100% !important; transform: translate(-50% ,-100%) !important',
            'bottom_right' => 'left: 100% !important; top: 100% !important; transform: translate(-100% ,-100%) !important;'
        );
        $badge_placement = $this->props['badge_placement'] !== '' ? 
            $this->props['badge_placement'] : 'top_left';

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .woocommerce ul.products li.product .df-sale-badge.df-onsale',
            'declaration' => $tanslate_values[$badge_placement]
        ));
        
         // overflow
         if( isset($this->props['outer_wrpper_visibility']) && $this->props['outer_wrpper_visibility'] !== 'default' ) {
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'outer_wrpper_visibility',
                'type'              => 'overflow',
                'selector'          => '%%order_class%% .df-product-outer-wrap',
                'important'         => true
            ));
        }
        if( isset($this->props['inner_wrpper_visibility']) && $this->props['inner_wrpper_visibility'] !== 'default' ) {
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'inner_wrpper_visibility',
                'type'              => 'overflow',
                'selector'          => '%%order_class%% .df-product-inner-wrap',
                'important'         => true
            ));
        } 
        
    }
    
    /**
	 * Get products for productgrid module
	 *
	 * @return string  product markup
	 */
    public function df_get_products() {
        global $product, $paged, $wp_query, $wp_the_query, $wp_filter, $__et_blog_module_paged, $df_product_element, $df_product_items, $df_product_items_outside;   
        if ( ! is_plugin_active ( 'woocommerce/woocommerce.php' ) ) {
            $error_notice ="<div style='color:red'>" . esc_html__("Please Before Using the Diviflash $this->name Module, you need to Activate and configure the WooCommerce Plugin", 'divi_flash') . "</div>";
            return $error_notice;
        }    
        if(empty($df_product_items) && empty($df_product_items_outside)) {
            $shop = '';
            return $shop;
        }
        $post_id            = isset( $current_page['id'] ) ? (int) $current_page['id'] : 0;
      
		$type               = $this->props['type'];
		$posts_number       = $this->props['posts_number'];
		$orderby            = $this->props['orderby'];
		$order              = 'ASC';
		$columns            = $this->props['column'];
		
        $pagination = ($this->props['show_pagination'] === 'on') ? true: false;
		$product_categories = array();
		$product_tags       = array();
		$use_current_loop   = 'on' === $this->prop( 'use_current_loop', 'off' );
		$use_current_loop   = $use_current_loop && ( is_post_type_archive( 'product' ) || is_search() || et_is_product_taxonomy() );
		$product_attribute  = '';
		$product_terms      = array();

		if ( $use_current_loop ) {
			$this->props['include_categories'] = 'all';

			if ( is_product_category() ) {
				$this->props['include_categories'] = (string) get_queried_object_id();
			} elseif ( is_product_tag() ) {
				$product_tags = array( get_queried_object()->slug );
			} elseif ( is_product_taxonomy() ) {
				$term = get_queried_object();

				// Product attribute taxonomy slugs start with pa_ .
				if ( et_()->starts_with( $term->taxonomy, 'pa_' ) ) {
					$product_attribute = $term->taxonomy;
					$product_terms[]   = $term->slug;
				}
			}
		}

		if ( 'product_category' === $type || ( $use_current_loop && ! empty( $this->props['include_categories'] ) ) ) {
			$all_shop_categories     = et_builder_get_shop_categories();
          
			$all_shop_categories_map = array();
			$raw_product_categories  = self::filter_include_categories( $this->props['include_categories'], $post_id, 'product_cat' );
    
			foreach ( $all_shop_categories as $term ) {
				if ( is_object( $term ) && is_a( $term, 'WP_Term' ) ) {
					$all_shop_categories_map[ $term->term_id ] = $term->slug;
				}
			}

			$product_categories = array_values( $all_shop_categories_map );

			if ( ! empty( $raw_product_categories ) ) {
				$product_categories = array_intersect_key(
					$all_shop_categories_map,
					array_flip( $raw_product_categories )
				);
			}
		}

		if ( 'default_order' === $orderby && ( 'default' === $type || 'recent' === $type ) ) {
			// Leave the attribute empty to allow WooCommerce to take over and use the default sorting.
			$orderby = '';
		}

		if ( 'latest' === $type ) {
			$orderby = 'date-desc';
		}

		if ( in_array( $orderby, array( 'price-desc', 'date-desc' ), true ) ) {
			// Supported orderby arguments (as defined by WC_Query->get_catalog_ordering_args() ):
			// rand | date | price | popularity | rating | title .
			$orderby = str_replace( '-desc', '', $orderby );
			// Switch to descending order if orderby is 'price-desc' or 'date-desc'.
			$order = 'DESC';
		}

		$ids             = array();
		$wc_custom_view  = '';
		$wc_custom_views = array(
			'sale'         => array( 'on_sale', 'true' ),
			'best_selling' => array( 'best_selling', 'true' ),
			'top_rated'    => array( 'top_rated', 'true' ),
			'featured'     => array( 'visibility', 'featured' )
		);

		if ( et_()->includes( array_keys( $wc_custom_views ), $type ) ) {
			$custom_view_data = $wc_custom_views[ $type ];
			$wc_custom_view   = sprintf( '%1$s="%2$s"', esc_attr( $custom_view_data[0] ), esc_attr( $custom_view_data[1] ) );
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- reason wp_nonce is not required here as data from get requests go through something like "whitelisting" via `in_array` function.
		$request_orderby_value = et_()->array_get_sanitized( $_GET, 'orderby', '' );
		$shop_fields           = $this->get_fields();
		// Checking if there is an orderby parameter in the GET-request and is its value is defined in the options via $this->get_fields() and contains `price` value.
		$maybe_fields_has_orderby_options           = ! empty( $shop_fields ) && isset( $shop_fields['orderby']['options'] );
		$maybe_request_price_value_in_order_options = ! empty( $request_orderby_value ) && $maybe_fields_has_orderby_options && in_array( $request_orderby_value, array_keys( $shop_fields['orderby']['options'] ), true ) && false !== strpos( strtolower( $request_orderby_value ), 'price' );
		if ( $maybe_request_price_value_in_order_options ) {
			$orderby = 'price';
			$order   = false !== strpos( strtolower( $request_orderby_value ), 'desc' ) ? 'DESC' : 'ASC';
		}

		$options = array(
            'show_badge'             => $this->props['show_badge'],
            'show_badge_in_image'    => $this->props['show_badge_in_image'],
            'on_sale_text'           => $this->props['on_sale_text'],
            'after_sale_text_enable' => $this->props['after_sale_text_enable'],
            'after_sale_text_type'   => $this->props['after_sale_text_type'],
            'after_sale_text'        => $this->props['after_sale_text'],
            'enable_custom_soldout_text'=> $this->props['enable_custom_soldout_text'],
            'custom_soldout_text'=> $this->props['custom_soldout_text'],
            'next_prev_icon'         => $this->props['next_prev_icon'],
            'layout'                 => $this->props['layout'],
            'equal_height'           => $this->props['equal_height']
        );
        $df_product_element = array(
            'df_product_items' => $df_product_items,
            'df_product_items_outside'=>$df_product_items_outside
        );
       
        do_action('df_pg_before_print', $df_product_element , $options);
        add_filter( 'woocommerce_pagination_args', array($this, 'df_pg_pagination'),10, 2);
        
        if ( 'default_order' === $orderby ){
            add_filter( 'woocommerce_default_catalog_orderby', array( $this, 'set_default_orderby' ) );
        }

        if ( 'product_category' === $type || $use_current_loop ) {
			add_filter( 'woocommerce_shortcode_products_query', array( $this, 'filter_products_query' ) );
		}

		$shortcode = sprintf(
			'[products columns="%4$s" %1$s limit="%2$s" orderby="%3$s" %5$s order="%6$s" %7$s %8$s %9$s %10$s %11$s]',
			et_core_intentionally_unescaped( $wc_custom_view, 'fixed_string' ),
			esc_attr( $posts_number ),
			esc_attr( $orderby ),
			esc_attr( $columns ),
			$product_categories ? sprintf( 'category="%s"', esc_attr( implode( ',', $product_categories ) ) ) : '',
			esc_attr( $order ),
			$pagination ? 'paginate="true"' : '',
			$ids ? sprintf( 'ids="%s"', esc_attr( implode( ',', $ids ) ) ) : '',
			$product_tags ? sprintf( 'tag="%s"', esc_attr( implode( ',', $product_tags ) ) ) : '',
			$product_attribute ? sprintf( 'attribute="%s"', esc_attr( $product_attribute ) ) : '',
			$product_terms ? sprintf( 'terms="%s"', esc_attr( implode( ',', $product_terms ) ) ) : ''
		);
        $shop = do_shortcode( $shortcode );  
     
        do_action('df_pg_after_print', $df_product_element, $options);
        remove_filter( 'woocommerce_pagination_args', array($this, 'df_pg_pagination'),10);
	    
        if ( 'default_order' === $orderby ){
            remove_filter( 'woocommerce_default_catalog_orderby', array( $this, 'set_default_orderby' ) );
        }

        if ( 'product_category' === $type || $use_current_loop ) {
			remove_filter( 'woocommerce_shortcode_products_query', array( $this, 'filter_products_query' ) );
		}

        $df_product_items = array();
        $df_product_items_outside = array();
        $df_product_element = array();
        return $shop;
    }

    /**
	 * Set correct default value for the orderby menu depending on module settings.
	 *
	 * @param string $default_orderby default orderby value from woocommerce settings.
	 * @return string updated orderby value for current module
	 */
	public function set_default_orderby( $default_orderby ) {
		$orderby = $this->props['orderby'];

		if ( '' === $orderby || 'default_order' === $orderby ) {
			return $default_orderby;
		}

		// Should check this explicitly since it's the only option which supports '-desc' suffix.
		if ( 'price-desc' === $orderby ) {
			return 'price-desc';
		}

		// Remove '-desc' suffix from other options where Divi may add it.
		$orderby = str_replace( '-desc', '', $orderby );

		return $orderby;
	}

        /**
	 * Filter the products query arguments.
	 *
	 * @param array $query_args Query array.
	 *
	 * @return array
	 */
	public function filter_products_query( $query_args ) {
		if ( is_search() ) {
			$query_args['s'] = get_search_query();
		}

		if ( function_exists( 'WC' ) ) {
			$query_args['meta_query'] = WC()->query->get_meta_query( et_()->array_get( $query_args, 'meta_query', array() ), true );
			$query_args['tax_query']  = WC()->query->get_tax_query( et_()->array_get( $query_args, 'tax_query', array() ), true );
			$query_args['nocache'] = microtime( true );
		}

		return $query_args;
	}

    public function render( $attrs, $content, $render_slug ) {
        $this->additional_css_styles($render_slug);
        wp_enqueue_script('imageload');
        wp_enqueue_script('df-imagegallery-lib');
        wp_enqueue_script('df-products');

        wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );
        $layout = $this->props['layout'];
        $data = array(
            'layout' => $this->props['layout']
        );
       
        return sprintf('<div class="df_productgrid_container et_pb_ajax_pagination_container" data-settings=\'%2$s\'>
                                <div class="df-products-wrap layout-'.$layout.'">
                                    %1$s 
                                </div>
                            </div>', 
            $this->df_get_products(),
            wp_json_encode($data)
        );
    }

    public function add_new_child_text() {
		return esc_html__( 'Add New Product Element', 'divi_flash' );
	}
    /**
     * next and prev icons
     */
    public function arrow_icon( $set = 'set_1', $type = 'next') {
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
    /**
     * function for 'woocommerce_pagination_args' hook overwrite
     * @param $args default pagination 
     * @return  Array $args
     */
    public function df_pg_pagination( $args) {

        $args['prev_text'] = '<span class="et-pb-icon">' . esc_attr(et_pb_process_font_icon( $this->arrow_icon ($this->props['next_prev_icon'] , 'prev') )) . "</span>";
        $args['next_text'] = '<span class="et-pb-icon">' . esc_attr(et_pb_process_font_icon( $this->arrow_icon ($this->props['next_prev_icon'] , 'next') )) . "</span>";

        return $args;
    }

}
new DIFL_ProductGrid;

