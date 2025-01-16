<?php

class DIFL_ProductCarousel extends ET_Builder_Module_Type_PostBased {
    public $slug       = 'difl_product_carousel';
    public $vb_support = 'on';
    public $child_slug = 'difl_productitem';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Product Carousel', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/product-carousel.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'settings'              => esc_html__('Settings', 'divi_flash'),
                    'carousel_settings'     => esc_html__('Carousel Settings', 'divi_flash'),
                    'advanced_settings'     => esc_html__('Advanced Settings', 'divi_flash'),
                    'sales_badge'     => esc_html__('Sales Badge Settings', 'divi_flash'),
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
                    'arrows'                => esc_html__('Arrows', 'divi_flash'),
                    'dots'                  => esc_html__('Dots', 'divi_flash'),
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
            // 'default'   => true,
            'on_sale_font'     => array(
                'label'           => et_builder_i18n( '' ),
                'css'             => array(
                    'main'          => "%%order_class%% .woocommerce-page ul.df-products li.product span.df-sale-badge.df-onsale,
                                        %%order_class%% .woocommerce ul.df-products li.product span.df-sale-badge.df-onsale",
                    'hover'         => "%%order_class%% .woocommerce-page ul.df-products li.product span.df-sale-badge.df-onsale:hover,
                                        %%order_class%% .woocommerce ul.df-products li.product span.df-sale-badge.df-onsale:hover",
                    'important'     => 'all',
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '16px',
                ),
                'toggle_slug'     => 'on_sale',
                'sub_toggle'      => 'badge_text',
            ),

            'on_after_sale_font'     => array(
                'label'           => et_builder_i18n( '' ),
                'css'             => array(
                    'main'        => "%%order_class%% .woocommerce-page ul.df-products li.product .df-onsale span.after-text,
                                        %%order_class%% .woocommerce ul.df-products li.product .df-onsale span.after-text",
                    'hover'        => "%%order_class%% .woocommerce-page ul.df-products li.product .df-onsale:hover span.after-text,
                                        %%order_class%% .woocommerce ul.df-products li.product .df-onsale:hover span.after-text",
                ),
                'hide_text_align'  => true,
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '16px',
                ),
                'toggle_slug'     => 'on_sale',
                'sub_toggle'      => 'after_badge_text'
            ),

            'on_suffix_sale_font'     => array(
                'label'           => et_builder_i18n( '' ),
                'css'             => array(
                    'main'        => "%%order_class%% .woocommerce-page ul.df-products li.product .df-onsale span.after-sale-text,
                                        %%order_class%% .woocommerce ul.df-products li.product .df-onsale span.after-sale-text",
                    'hover'        => "%%order_class%% .woocommerce-page ul.df-products li.product .df-onsale:hover span.after-sale-text,
                                        %%order_class%% .woocommerce ul.df-products li.product .df-onsale:hover span.after-sale-text",
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
            )

        );

        $advanced_fields['borders'] = array (
            'item_outer'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-product-outer-wrap',
                        'border_radii_hover' => '%%order_class%% .df-product-outer-wrap:hover',
                        'border_styles' => '%%order_class%% .df-product-outer-wrap',
                        'border_styles_hover' => '%%order_class%% .df-product-outer-wrap:hover',
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
                        'border_styles_hover' => '%%order_class%% .df-product-inner-wrap:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_inner_wrapper',
                'label_prefix'      => 'Item'
            ),
            'on_sale_border'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_product_carousel{$this->main_css_element} .woocommerce ul.df-products li.product span.df-sale-badge.df-onsale",
                        'border_radii_hover' => ".difl_product_carousel{$this->main_css_element} .woocommerce ul.df-products li.product span.df-sale-badge.df-onsale:hover",
                        'border_styles' => ".difl_product_carousel{$this->main_css_element} .woocommerce ul.df-products li.product span.df-sale-badge.df-onsale",
                        'border_styles_hover' => ".difl_product_carousel{$this->main_css_element} .woocommerce ul.df-products li.product span.df-sale-badge.df-onsale:hover",
                    ),
                    'important' => 'all',
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'on_sale_style'
            ),

            'arrows'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_pc_arrows > div',
                        'border_radii_hover' => '%%order_class%% .df_pc_arrows > div:hover',
                        'border_styles' => '%%order_class%% .df_pc_arrows > div',
                        'border_styles_hover' => '%%order_class%% .df_pc_arrows> div:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
                'label_prefix'      => 'Arrows'
            ),
        );

        $advanced_fields['box_shadow'] = array(
            'item_outer'      => array(
                'css' => array(
                    'main' => "%%order_class%% .df-product-outer-wrap",
                    'hover' => "%%order_class%% .df-product-outer-wrap:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_outer_wrapper'
            ),
            'item'      => array(
                'css' => array(
                    'main' => "%%order_class%% .df-product-inner-wrap",
                    'hover' => "%%order_class%% .df-product-inner-wrap:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_inner_wrapper'
            ),
            'on_sale'      => array(
                'css' => array(
                    'main' => "%%order_class%% .woocommerce-page ul.df-products li.product span.df-sale-badge.df-onsale,
                                %%order_class%% .woocommerce ul.df-products li.product span.df-sale-badge.df-onsale",
                    'hover' => "%%order_class%% .woocommerce-page ul.df-products li.product span.df-sale-badge.df-onsale:hover,
                                %%order_class%% .woocommerce ul.df-products li.product span.df-sale-badge.df-onsale:hover",
                    'important'=> 'all'
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'on_sale_style',
            ),

            'arrows'      => array(
                'css' => array(
                    'main' => '%%order_class%% .df_pc_arrows > div',
                    'hover' => '%%order_class%% .df_pc_arrows> div:hover',
                    'important'=> 'all'
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
            ),

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
					'product_category' => esc_html__( 'Product Category', 'divi_flash' ),
				),
				'default_on_front' => 'default',
				'affects'        => array(
					'include_categories',
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
				)

			),
			'include_categories'   => array(
				'label'            => esc_html__( 'Include Categories', 'divi_flash' ),
				'type'             => 'categories',
				'renderer_options' => array(
					'use_terms'    => true,
					'term_name'    => 'product_cat',
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
				'toggle_slug'       => 'settings'
			),


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
                'label'             => esc_html__('Effect multiplier', 'divi_flash'),
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
        $content = array(
            'show_badge'       => array(
                'label'            => esc_html__( 'Show Badge', 'divi_flash' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'Yes' ),
					'off' => et_builder_i18n( 'No' ),
				),
				'default'          => 'off',
				'description'      => esc_html__( 'Turn Badge on and off.', 'divi_flash' ),
				'toggle_slug'      => 'sales_badge',
            ),
            'show_badge_in_image'       => array(
                'label'            => esc_html__( 'Show Badge In Image Container', 'divi_flash' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'Yes' ),
					'off' => et_builder_i18n( 'No' ),
				),
				'default'          => 'off',
				'description'      => esc_html__( 'Turn Badge In Image on and off.', 'divi_flash' ),
				'toggle_slug'      => 'sales_badge',
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
                    'bottom_right' => esc_html__( 'Bottom Right', 'divi_flash' ),
				),
				'default' => 'top_left',
				'description'       => esc_html__( 'Choose Badge Placement.', 'divi_flash' ),
				'toggle_slug'       => 'sales_badge',
                'show_if' => array(
                    'show_badge' => 'on'
                )
            ),
            'on_sale_text'    => array(
                'label'                 => esc_html__('Badge Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'sales_badge',
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
					'off' => et_builder_i18n( 'No' ),
				),
				'default'          => 'off',
				'description'      => esc_html__( 'After Badge Turn on and off.', 'divi_flash' ),
				'toggle_slug'      => 'sales_badge',
                'show_if' => array(
                    'show_badge' => 'on'
                )
            ),
            'after_sale_text'    => array(
                'label'                 => esc_html__('Suffix Badge Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'sales_badge',
                'show_if' => array(
                    'show_badge' => 'on',
                    'after_sale_text_enable' => 'on'
                )
            ),
            'after_sale_text_type'=> array(
                'label'             => esc_html__( 'After Badge Text Type', 'divi_flash' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'price-percentise'  => esc_html__( 'Price Percentise', 'divi_flash' ),
					'price-difference' => esc_html__( 'Price Difference', 'divi_flash' ),
                    'both-percentise-difference' => esc_html__( 'Both Percentise & Difference', 'divi_flash' ),
				),
				'default_on_front' => 'price-percentise',
				'default' => 'price-percentise',
				'description'       => esc_html__( 'Choose how your after Badge Text Type.', 'divi_flash' ),
				'toggle_slug'       => 'sales_badge',
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
					'off' => et_builder_i18n( 'No' ),
				),
				'default'          => 'off',
				'toggle_slug'      => 'sales_badge',
                'show_if' => array(
                    'show_badge' => 'on'
                )
            ),
            'custom_soldout_text'    => array(
                'label'                 => esc_html__('SoldOut Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'sales_badge',
                'show_if' => array(
                    'show_badge' => 'on',
                    'enable_custom_soldout_text' => 'on'
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
            ),
            'disable_arrow_design'    => array(
                'label'             => esc_html__('Disable Arrow Style', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'arrows',
                'tab_slug'          => 'advanced'
            ),
            'disable_arrow_color' => array(
                'label'             => esc_html__('Disable Arrow icon color', 'divi_flash'),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
                'hover'             => 'tabs',
                'show_if' => array(
                    'disable_arrow_design' => 'on'
                )
            ),
            'disable_arrow_background' => array(
                'label'             => esc_html__('Disable Arrow background', 'divi_flash'),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
                'hover'             => 'tabs',
                'show_if' => array(
                    'disable_arrow_design' => 'on'
                )
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
            'dots_style_type'    => array(
                'default'         => 'default',
                'label'           => esc_html__('Dots Style Type', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'default'           => esc_html__('Default', 'divi_flash'),
                    'square'            => esc_html__('Style 1', 'divi_flash'),
                    'square_rotate'      => esc_html__('Style 2', 'divi_flash'),
                    'rectangle'      => esc_html__('Style 3', 'divi_flash'),
                ),
                'toggle_slug'     => 'dots',
                'tab_slug'        => 'advanced'
            ),

            'active_dot_border_style_enable'    => array(
                'label'             => esc_html__('Active Dot Border Style Enable', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'dots',
                'tab_slug'          => 'advanced',
                'show_if'           => array(
                    'large_active_dot' => 'off',
                    'dots_style_type' => array('default', 'square','square_rotate')
                ),


            ),
            'custom_dot_style_enable'    => array(
                'label'             => esc_html__('Custom Dot Style Enable', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'dots',
                'tab_slug'          => 'advanced',
                'show_if'           => array(
                    'dots_style_type'=> array('default', 'square','rectangle')
                )
            ),
            'custom_dot_width'    => array(
                'label'             => esc_html__('All dot Width(px)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'dots',
                'tab_slug'          => 'advanced',
                'default'           => '12px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '10',
                    'max'  => '100',
                    'step' => '1',
                ),
                'show_if'           => array(
                    'dots_style_type'=> array('default', 'square' , 'rectangle'),
                    'custom_dot_style_enable' =>'on'
                )
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
                'tab_slug'          => 'advanced',
                'show_if'           => array(
                    'dots_style_type'=> array('default', 'square', 'rectangle'),
                    'active_dot_border_style_enable' => 'off'
                )
            ),
            'large_active_dot_width'    => array(
                'label'             => esc_html__('Large Active dot Width(px)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'dots',
                'tab_slug'          => 'advanced',
                'default'           => '40px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '20',
                    'max'  => '100',
                    'step' => '1',
                ),
                'show_if'           => array(
                    'dots_style_type'=> array('default', 'square' ,'rectangle'),
                    'large_active_dot' =>'on',
                    'active_dot_border_style_enable'=>'off'
                )
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
			'label'				    => 'Product Item Background',
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

        $on_sale_spacing = $this->add_margin_padding(array(
            'title'         => 'sale',
            'key'           => 'on_sale',
            'toggle_slug'   => 'margin_padding'
        ));


        return array_merge(
            $settings,
            $carousel_settings,
            $coverflow_effect,
            $alignment,
            $item_background,
            $content,
            $arrows,
            $arrow_prev_icon,
            $arrow_next_icon,
            $arrow_prev_spacing,
            $arrow_next_spacing,
            $dots,
            $dots_wrapper,
            $wrapper_spacing,
            $item_wrapper_spacing,
            $item_spacing,
            $on_sale_spacing,
            $item_background,
            $on_sale_background,
            $visibility
        );


    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $product_item = '%%order_class%% .df-product-inner-wrap';
        $on_sale = '%%order_class%% .woocommerce ul.df-products li.product .df-onsale';
        $arrows = '%%order_class%% .df_pc_arrows > div';
        $arrow_icon = '%%order_class%% .df_pc_arrows > div:after';
        $disable_arrows = '%%order_class%% .df_pc_arrows > div.swiper-button-disabled';
        $disable_arrow_icon = '%%order_class%% .df_pc_arrows > div.swiper-button-disabled:after';
        $dots = '%%order_class%% .swiper-pagination .swiper-pagination-bullet';
        $dots_wrapper = '%%order_class%% .swiper-pagination';

        $fields['item_wrapper_padding'] = array ('padding' => '%%order_class%% .df-product-outer-wrap');
        $fields['item_margin'] = array ('margin' => $product_item);
        $fields['item_padding'] = array ('padding' => $product_item);

        $fields['wrapper_margin'] = array ('margin' => '%%order_class%% .df-products');
        $fields['wrapper_padding'] = array ('padding' => '%%order_class%% .df-products');

        $fields['on_sale_margin'] = array ('margin' => $on_sale);
        $fields['on_sale_padding'] = array ('padding' => $on_sale);

        $fields['arrow_opacity'] = array('opacity' => $arrows);
        $fields['arrow_opacity_disable'] = array('opacity' => '%%order_class%% .df_pc_arrows div.swiper-button-disabled');
        $fields['arrow_color'] = array('color' => $arrow_icon);
        $fields['arrow_background'] = array('background-color' => $arrows);
        $fields['disable_arrow_color'] = array('color' => $disable_arrow_icon);
        $fields['disable_arrow_background'] = array('background-color' => $disable_arrows);
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
            'selector'      => $product_item
        ));

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'on_sale_background',
            'selector'      => $on_sale
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

        return $fields;
    }

    public function additional_css_styles($render_slug) {
         // equal height
         if ($this->props['equal_height'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% ul li.df-equal-height',
                'declaration' =>'align-self: auto;
                                 height: auto;'
            ));
        }
        if($this->props['show_badge'] ==='on'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% span.df-onsale:not(.df-sale-badge)',
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
            'selector'          => '%%order_class%% .woocommerce ul.df-products li.product .df-onsale',
            'hover'             => '%%order_class%% .woocommerce ul.df-products li.product .df-onsale:hover'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'on_sale_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .woocommerce ul.df-products li.product .df-onsale',
            'hover'             => '%%order_class%% .woocommerce ul.df-products li.product .df-onsale:hover'
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-products',
            'hover'             => '%%order_class%% .df-products:hover'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-products',
            'hover'             => '%%order_class%% .df-products:hover'
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
            'selector'          => '%%order_class%% .woocommerce-page ul.df-products li.product .df-onsale,
                                     %%order_class%% .woocommerce ul.df-products li.product .df-onsale',
            'hover'             => '%%order_class%% .woocommerce ul.df-products li.product .df-onsale:hover,
                                    %%order_class%% .woocommerce ul.df-products li.product .df-onsale:hover',
            'important'         => true
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
                'selector' => '%%order_class%% .df_pc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos)
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_pc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_pc_arrows',
                'declaration' => $this->df_arrow_pos_styles($pos_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
            // alignment
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_pc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align)
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_pc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_pc_arrows',
                'declaration' => sprintf('justify-content: %1$s;', $a_align_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
            if ($this->props['arrow_circle'] === 'on') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_pc_arrows > div',
                    'declaration' => 'border-radius: 50%;'
                ));
            }
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_opacity',
                'type'              => 'opacity',
                'selector'          => '%%order_class%% .df_pc_arrows div',
                'hover'             => '%%order_class%%:hover .df_pc_arrows div'
            ));
            if( 'on' !== $this->props['loop'] ){
                $this->df_process_range( array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'arrow_opacity_disable',
                    'type'              => 'opacity',
                    'selector'          => '%%order_class%% .df_pc_arrows div.swiper-button-disabled',
                    'hover'             => '%%order_class%%:hover .df_pc_arrows div.swiper-button-disabled'
                ) );
            }
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df_pc_arrows .swiper-button-prev',
                'hover'             => '%%order_class%%:hover .df_pc_arrows .swiper-button-prev',
                'important'         => false
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df_pc_arrows .swiper-button-prev',
                'hover'             => '%%order_class%%:hover .df_pc_arrows .swiper-button-prev',
                'important'         => false
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_margin',
                'type'              => 'margin',
                'selector'          => '%%order_class%% .df_pc_arrows .swiper-button-next',
                'hover'             => '%%order_class%%:hover .df_pc_arrows .swiper-button-next',
                'important'         => false
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_padding',
                'type'              => 'padding',
                'selector'          => '%%order_class%% .df_pc_arrows .swiper-button-next',
                'hover'             => '%%order_class%%:hover .df_pc_arrows .swiper-button-next',
                'important'         => false
            ));
            // arrow colors
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_color',
                'type'              => 'color',
                'selector'          => '%%order_class%% .df_pc_arrows > div:after',
                'hover'             => '%%order_class%% .df_pc_arrows > div:not(.swiper-button-disabled):hover:after'
            ));
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_background',
                'type'              => 'background-color',
                'selector'          => '%%order_class%% .df_pc_arrows > div',
                'hover'             => '%%order_class%% .df_pc_arrows > div:hover'
            ));
            // disable arrow colors
            if ($this->props['disable_arrow_design'] === 'on') {
                $this->df_process_color(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'disable_arrow_color',
                    'type'              => 'color',
                    'selector'          => '%%order_class%% .df_pc_arrows > div.swiper-button-disabled:after',
                    'hover'             => '%%order_class%% .df_pc_arrows > div.swiper-button-disabled:hover:after'
                ));
                $this->df_process_color(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'disable_arrow_background',
                    'type'              => 'background-color',
                    'selector'          => '%%order_class%% .df_pc_arrows > div.swiper-button-disabled',
                    'hover'             => '%%order_class%% .df_pc_arrows > div.swiper-button-disabled:hover'
                ));
            }
            // arrow icon styles
            $this->process_icon_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_prev_icon',
                'selector'          => '%%order_class%% .df_pc_arrows div.swiper-button-prev:after'
            ));
            $this->process_icon_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_next_icon',
                'selector'          => '%%order_class%% .df_pc_arrows div.swiper-button-next:after'
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
                'declaration' => $this->df_arrow_pos_styles($dots_pos)
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination',
                'declaration' => $this->df_arrow_pos_styles($dots_pos_tab),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination',
                'declaration' => $this->df_arrow_pos_styles($dots_pos_ph),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));

            if ($this->props['large_active_dot'] === 'on') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .swiper-pagination:not(.dots_style_square_rotate) .swiper-pagination-bullet-active',
                    'declaration' => 'width: 40px; border-radius: 20px;',
                    'important' => true
                ));

                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'large_active_dot_width',
                    'type'              => 'width',
                    'default'           =>'40px',
                    'selector'          => '%%order_class%% .swiper-pagination:not(.dots_style_square_rotate) .swiper-pagination-bullet-active'
                ));

            }

            if ($this->props['custom_dot_style_enable'] === 'on') {
                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'custom_dot_width',
                    'type'              => 'width',
                    'default'           =>'12px',
                    'selector'          => '%%order_class%% .swiper-pagination:not(.dots_style_square_rotate) .swiper-pagination-bullet',
                    'important'         => false
                ));
                if ($this->props['dots_style_type'] === 'default' || $this->props['dots_style_type'] === 'square') {
                    $this->df_process_range(array(
                        'render_slug'       => $render_slug,
                        'slug'              => 'custom_dot_width',
                        'type'              => 'height',
                        'default'           =>'12px',
                        'selector'          => '%%order_class%% .swiper-pagination:not(.dots_style_square_rotate) .swiper-pagination-bullet',
                        'important'         => false
                    ));
                }

                if ($this->props['active_dot_border_style_enable'] === 'on') {
                    $this->df_process_range(array(
                        'render_slug'       => $render_slug,
                        'slug'              => 'custom_dot_width',
                        'type'              => 'margin-right',
                        'default'           =>'12px',
                        'selector'          => '%%order_class%% .swiper-pagination:not(.dots_style_square_rotate) .swiper-pagination-bullet',
                        'important'         => true
                    ));
                }
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
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'active_dots_color',
                'type'              => 'border-color',
                'selector'          => '%%order_class%% .swiper-pagination span.swiper-pagination-bullet-active:before',
                'hover'             => '%%order_class%% .swiper-pagination span.swiper-pagination-bullet-active:hover:before'
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
                'selector' => '%%order_class%%  .arrow-middle .df_pc_arrows *',
                'declaration' => 'pointer-events: all !important;'
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

        // icon font family
        $this->generate_styles(
            array(
                'utility_arg'    => 'icon_font_family',
                'render_slug'    => $render_slug,
                'base_attr_name' => 'arrow_prev_icon_font_icon',
                'important'      => true,
                'selector'       => '%%order_class%% .swiper-button-prev:after',
                'processor'      => array(
                    'ET_Builder_Module_Helper_Style_Processor',
                    'process_extended_icon'
                )
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
                    'process_extended_icon'
                )
            )
        );


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
            'selector' => '%%order_class%% .woocommerce ul.df-products li.product .df-sale-badge.df-onsale',
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
     * Arrow navigation
     *
     * @param Integer | $order_number
     * @return String | HTML
     */
    public function df_pc_arrow($order_number)
    {
        $prev_icon = $this->props['arrow_prev_icon_use_icon'] === 'on' && isset($this->props['arrow_prev_icon_font_icon']) && !empty($this->props['arrow_prev_icon_font_icon']) ?
            esc_attr(et_pb_process_font_icon($this->props['arrow_prev_icon_font_icon'])) : '4';
        $next_icon = $this->props['arrow_next_icon_use_icon'] === 'on' && isset($this->props['arrow_next_icon_font_icon']) && !empty($this->props['arrow_next_icon_font_icon']) ?
            esc_attr(et_pb_process_font_icon($this->props['arrow_next_icon_font_icon'])) : '5';

        return $this->props['arrow'] === 'on' ? sprintf('
            <div class="df_pc_arrows">
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
    public function df_pc_dots($order_number)
    {
        $dosts_style_class = '';
        $active_dot_border_style ='';
        if(isset($this->props['dots_style_type']) && $this->props['dots_style_type'] !== ''){
            $dosts_style_class = 'dots_style_'.$this->props['dots_style_type'];
        }
        if(isset($this->props['active_dot_border_style_enable']) && $this->props['active_dot_border_style_enable'] === 'on'){
            $active_dot_border_style .= 'active_dot_border_style';
        }
        return $this->props['dots'] === 'on' ?
            sprintf('<div class="swiper-pagination bc-dots-%1$s %2$s %3$s"></div>', $order_number , $dosts_style_class, $active_dot_border_style) : '';
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

    /**
	 * Get products for productCarousel module
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

		// Recent was the default option in Divi once, so it is added here for the websites created before the change.
		if ( 'default' === $orderby && ( 'default' === $type || 'recent' === $type ) ) {
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
            'module_type'            => 'carousel',
            'show_badge'             => $this->props['show_badge'],
            'show_badge_in_image'    => $this->props['show_badge_in_image'],
            'on_sale_text'           => $this->props['on_sale_text'],
            'after_sale_text_enable' => $this->props['after_sale_text_enable'],
            'after_sale_text'        => $this->props['after_sale_text'],
            'after_sale_text_type'   => $this->props['after_sale_text_type'],
            'enable_custom_soldout_text' => $this->props['enable_custom_soldout_text'],
            'custom_soldout_text'   => $this->props['custom_soldout_text'],
            'equal_height'           => $this->props['equal_height']
        );
        $df_product_element = array(
            'df_product_items' => $df_product_items,
            'df_product_items_outside'=>$df_product_items_outside
        );

        do_action('df_pg_before_print', $df_product_element , $options);
        add_filter('post_class', 'df_product_carousel_class_add' ,10,3);
		$shortcode = sprintf(
			'[products class="swiper-container"  columns="4" %1$s limit="%2$s" orderby="%3$s" %5$s order="%6$s" %7$s %8$s %9$s %10$s %11$s]',
			et_core_intentionally_unescaped( $wc_custom_view, 'fixed_string' ),
			esc_attr( $posts_number ),
			esc_attr( $orderby ),
			'',
			$product_categories ? sprintf( 'category="%s"', esc_attr( implode( ',', $product_categories ) ) ) : '',
			esc_attr( $order ),
			'',
			$ids ? sprintf( 'ids="%s"', esc_attr( implode( ',', $ids ) ) ) : '',
			$product_tags ? sprintf( 'tag="%s"', esc_attr( implode( ',', $product_tags ) ) ) : '',
			$product_attribute ? sprintf( 'attribute="%s"', esc_attr( $product_attribute ) ) : '',
			$product_terms ? sprintf( 'terms="%s"', esc_attr( implode( ',', $product_terms ) ) ) : ''
		);
        $shop = do_shortcode( $shortcode );

        do_action('df_pg_after_print', $df_product_element, $options);
        $df_product_items = array();
        $df_product_items_outside = array();
        $df_product_element = array();
        return $shop;
    }

    public function render( $attrs, $content, $render_slug ) {

        if ( $this->content === '' ) {
            return sprintf(
                '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Product Element</strong> to continue.</h2>'
            );
        }

        $this->additional_css_styles($render_slug);
        wp_enqueue_script('swiper-script');
        wp_enqueue_script('df-product-carousel');

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


        return sprintf('<div class="df_product_carousel_container%8$s" data-settings=\'%2$s\' data-item="%5$s" data-itemtablet="%6$s" data-itemphone="%7$s">
            %1$s%3$s
        </div>%4$s',
        $this->df_get_products(),
        wp_json_encode($data),
        $this->df_pc_arrow($order_number),
        $this->df_pc_dots($order_number),
        $this->props['item_desktop'],
        $this->props['item_tablet'],
        $this->props['item_mobile'],
        $class
);
    }

    public function add_new_child_text() {
		return esc_html__( 'Add New Product Element', 'divi_flash' );
	}


}
new DIFL_ProductCarousel;

