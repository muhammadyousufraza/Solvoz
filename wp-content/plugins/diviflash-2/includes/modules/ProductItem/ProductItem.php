<?php

class DIFL_ProductItem extends ET_Builder_Module_Type_PostBased {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_productitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $child_title_var = 'type';
	public $child_title_fallback_var = 'admin_label';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Product Child Element', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
    }

    public function font_selector($type = 'main') {
        $selector = array(
            'main'  => array(
                "{$this->main_css_element} .df-product-title",
                "{$this->main_css_element} .df-product-title a",
                "{$this->main_css_element}.df-item-wrap > span:not(.et-pb-icon , .df-sale-badge)",
                "{$this->main_css_element}.df-item-wrap a",
                "{$this->main_css_element}.df-item-wrap",
                "{$this->main_css_element}.df-item-wrap p",
                "{$this->main_css_element} .df-product-read-more",
                "{$this->main_css_element} .df-product-custom-text",
                ".woocommerce ul.products li.product {$this->main_css_element} .price",
                "{$this->main_css_element} .df-product-price.price",
                "{$this->main_css_element}.df-item-wrap a.add_to_cart_button"
            ),
            'hover'  => array(
                ".df-product-outer-wrap:hover {$this->main_css_element} .df-product-title",
                ".df-product-outer-wrap:hover {$this->main_css_element} .df-product-title a",
                ".df-product-outer-wrap:hover {$this->main_css_element}.df-item-wrap > span:not(.et-pb-icon)",
                ".df-product-outer-wrap:hover {$this->main_css_element} .df-product-custom-text",
                ".woocommerce ul.products li.product .df-product-outer-wrap:hover {$this->main_css_element} .price",
                ".df-product-outer-wrap:hover {$this->main_css_element} .df-product-price.price",
                ".df-product-outer-wrap:hover {$this->main_css_element}.df-item-wrap",
                "{$this->main_css_element}.df-item-wrap:hover a",
                "{$this->main_css_element}.df-item-wrap:not(span.df-sale-badge):hover",
                "{$this->main_css_element}.df-item-wrap:hover .df-product-read-more",
                "{$this->main_css_element}.df-item-wrap:hover a.add_to_cart_button"
            )
        );

        if($type === 'main') {
            return implode(', ',  $selector['main']);
        } else if($type === 'hover') {
            //return '.df-product-outer-wrap:hover ' . implode(',.df-product-outer-wrap:hover ',  $selector['main']);
            return implode(', ',  $selector['hover']);
        }
        
    }

    public function advanced_field_selector($type = 'main') {
        $selector = array(
            'main'  => array(
                "{$this->main_css_element}:not(.df-product-button-wrap, .df-product-add-to-cart-wrap)",
                "{$this->main_css_element}.df-product-button-wrap",
                "{$this->main_css_element}.df-product-add-to-cart-wrap",
            ),
            'hover'  => array(
                ".df-product-outer-wrap:hover {$this->main_css_element}:not(.df-product-button-wrap, .df-product-add-to-cart-wrap)",
                "{$this->main_css_element}.df-product-button-wrap:hover",
                "{$this->main_css_element}.df-product-add-to-cart-wrap:hover"
            )
        );

        if($type === 'main') {
            return implode(', ',  $selector['main']);
        } else if($type === 'hover') {
            return implode(', ',  $selector['hover']);
        }
        
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'type'                  => esc_html__('Element', 'divi_flash'),
                    'icon_settings'         => esc_html__('Icon Settings', 'divi_flash'),
                    'animation_settings'    => esc_html__('Animation Settings', 'divi_flash'),
                    'overlay'               => esc_html__('Overlay & Scale', 'divi_flash'),
                    'divider_line'          => esc_html__('Divider Line', 'divi_flash')
                )
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'image'         => esc_html__('Image Settings', 'divi_flash'),
                    'text'          => esc_html__('Text', 'divi_flash'),
                    'text_style'    => esc_html__('Text Styles', 'divi_flash'),
                    'pricing_style' => array(
                        'title'                 => esc_html__('Pricing Styles', 'divi_flash'),
                        'tabbed_subtoggles'     => true,
                        'sub_toggles'           => array(
							'off_price_text'    => array(
								'name' => 'Off Price'
							),
                            'regular_price_text' => array(
								'name' => 'Regular Price'
							)
						)
                    ),
                    'add_to_cart_design'     => esc_html__('Add To Cart', 'divi_flash'),
                    'rating'     => esc_html__('Rating', 'divi_flash'),
                    'category_tag'     => esc_html__('Category & Tag', 'divi_flash'),
                    'read_more'     => esc_html__('Read More', 'divi_flash'),
                    'custom_spacing'=> esc_html__('Spacing', 'divi_flash')
                )
            )
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();
    
        $advanced_fields['text'] = array(
            'toggle_slug'           => 'text',
            'use_text_orientation'  => true, // default
			'css' => array(
				'text_orientation' => '%%order_class%%.df-item-wrap',
			),
        );

        $advanced_fields['fonts'] = array(
            'product_font_style'     => array(
                'toggle_slug'   => 'text_style',
                'tab_slug'        => 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => $this->advanced_field_selector('main'),
                    'hover' => $this->advanced_field_selector('hover'),
                    'important'    => 'all'
                )
            ),
            'product_regular_price_style'     => array(
                'label'         => esc_html__('', 'divi_flash'),
                'toggle_slug'   => 'pricing_style',
                'sub_toggle'    => 'regular_price_text',
                'tab_slug'        => 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => ".woocommerce ul.products li.product {$this->main_css_element}.df-item-wrap.df-product-price-wrap .price,
                                {$this->main_css_element} .price ins,
                                .woocommerce ul.products li.product {$this->main_css_element}.df-item-wrap.df-product-price-wrap .price ins",
                    'hover' => ".woocommerce ul.products li.product .df-product-outer-wrap:hover {$this->main_css_element} .price,
                                .df-product-outer-wrap:hover {$this->main_css_element} .price ins,
                                .woocommerce ul.products li.product .df-product-outer-wrap:hover {$this->main_css_element} .price ins",
                    'important'    => 'all'
                )
            ),
            'product_off_price_style'     => array(
                'label'         => esc_html__('', 'divi_flash'),
                'toggle_slug'   => 'pricing_style',
                'sub_toggle'    => 'off_price_text',
                'tab_slug'      => 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => " {$this->main_css_element} .price del, 
                                .woocommerce ul.products li.product {$this->main_css_element} .price del",
                    'hover' => ".df-product-outer-wrap:hover {$this->main_css_element} .price del , 
                                .woocommerce ul.products li.product .df-product-outer-wrap:hover {$this->main_css_element} .price del",
                    'important'    => 'all'
                )
          
            ),
        );
    

        $advanced_fields['borders'] = array(
            'default'   => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => $this->advanced_field_selector('main'),
                        'border_radii_hover'  => $this->advanced_field_selector('hover'),
                        'border_styles' => $this->advanced_field_selector('main'),
                        'border_styles_hover' => $this->advanced_field_selector('hover')
                    )
                )
            )
        );
        $advanced_fields['box_shadow'] = array(
            'default'      => array(
                'css' => array(
                    'main' => $this->advanced_field_selector('main'),
                    'hover' => $this->advanced_field_selector('hover'),
                )
            )
        );
        $advanced_fields['max_width'] = array(
            'css'   => array(
                'module_alignment' => "{$this->main_css_element}"
            )
        );

        $advanced_fields['background'] = array(
            'css'       => array(
                'main'     => $this->advanced_field_selector('main'),
                'hover'     => $this->advanced_field_selector('hover')
            )
        );
        $advanced_fields['margin_padding'] = false;

        $advanced_fields['link_options'] = false;
        return $advanced_fields;
    }

    public function get_fields() {
        $general = array (
            'type'   => array(
                'label'             => esc_html__('Type', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'select'        => esc_html__('Select Type', 'divi_flash'),
                    'image'         => esc_html__('Product Image', 'divi_flash'),
                    'title'         => esc_html__('Product Title', 'divi_flash'),
                    'rating'         => esc_html__('Product Rating', 'divi_flash'),
                    'price'         => esc_html__('Product Price', 'divi_flash'),
                    'short_description'       => esc_html__('Product Short Description', 'divi_flash'),
                    'add_to_cart'        => esc_html__('Add To Cart', 'divi_flash'),
                    'categories'        => esc_html__('Categories', 'divi_flash'),
                    'tags'        => esc_html__('Tags', 'divi_flash'),
                    'button'        => esc_html__('Button', 'divi_flash'),
                    'custom_text'   => esc_html__('Custom Text', 'divi_flash'),
                    'divider'       => esc_html__('Divider', 'divi_flash')
                ),
                'default'           => 'select',
                'toggle_slug'       => 'type',
                'affects'           => [
                    'title_tag',
                    'price_tag',
                    'show_categories',
                    'use_image_as_background',
                    'image_full_width'
                ]
            ),
           
            'admin_label' => array (
				'label'           => esc_html__( 'Admin Label', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'admin_label',
				'default_on_front'=> '',
			)
        );
        
        $title = array(
            'title_tag' => array (
                'default'         => 'h2',
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
                'toggle_slug'       => 'type',
                'tab_slug'		    => 'general',
                'depends_show_if'   => 'title'
            )
        );

        $price = array(
            'price_tag' => array (
                'default'         => 'span',
                'label'           => esc_html__( 'Price Tag', 'divi_flash' ),
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
                'toggle_slug'       => 'type',
                'tab_slug'		    => 'general',
                'depends_show_if'   => 'price'
            )
        );

        $meta_sttings = array(
            'meta_display'   => array(
                'label'             => esc_html__('Display', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'inline-block'          => esc_html__('Inline Block', 'divi_flash'),
                    'inline-flex'           => esc_html__('Inline', 'divi_flash'),
                    'block'                 => esc_html__('Block', 'divi_flash'),
                ),
                'default'           => 'block',
                'toggle_slug'       => 'type',
                'show_if'           => array(
                    'type'      => array('rating', 'price', 'categories', 'tags', 'button', 'custom_text','add_to_cart') 
                )
            ),   
        );
 
        $animation_sttings = array(
            'display_type'   => array(
                'label'             => esc_html__('Display Type', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'always_show'          => esc_html__('Always Show', 'divi_flash'),
                    'show_on_hover'                => esc_html__('Show On Hover', 'divi_flash'),
                    'hide_on_hover'                 => esc_html__('Hide On Hover', 'divi_flash'),
                ),
                'default'           => 'always_show',
                'toggle_slug'       => 'animation_settings',
                'show_if'           => array(
                    'type'      =>  array('title','rating', 'price', 'categories', 'tags' , 'button', 'custom_text','add_to_cart','short_description', 'divider')
                )
            ),
            'always_show_on_mobile'   => array(
                'label'             => esc_html__('Always Show on Mobile', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'animation_settings',
                'show_if'           => array(
                    'display_type'              => array('show_on_hover', 'hide_on_hover')
                )
            ),
    
        );
    
        $read_more = array(
            'read_more_text' => array(
				'label'             => esc_html__( 'Read More Text', 'divi_flash' ),
				'type'              => 'text',
				'toggle_slug'       => 'type',
                'default'           => 'Read More',
                'show_if'           => array(
                    'type'      => array('button')
                )
			),
        );

        $content = array(
          
            'use_product_excrpt'   => array(
                'label'             => esc_html__('Enable Limit to show content', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'type',
                'show_if'           => array(
                    'type'              => 'short_description'
                )
            ),
            'excerpt_length' => array(
				'label'             => esc_html__( 'Short Description Length', 'divi_flash' ),
				'description'       => esc_html__( 'Define the length of automatically generated excerpts. Leave blank for default ( 100 ) ', 'divi_flash' ),
				'type'              => 'text',
				'default'           => '100',
                'toggle_slug'       => 'type',
                'show_if'           => array(
                    'type'              => 'short_description',
                    'use_product_excrpt' => 'on'
                )
			),
        );
        $icon_settings_dependency = array( 'add_to_cart', 'button');
        $icon_settings = array(
            'use_icon'    => array(
                'label'             => esc_html__('Use Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'icon_settings',
                'show_if'           => array(
                    'use_image_as_icon'     => 'off',
                    'type'          => $icon_settings_dependency
                )
            ),       
            'use_image_as_icon'    => array(
                'label'             => esc_html__('Use Image as Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'icon_settings',
                'show_if'           => array(
                    'use_icon'     => 'off',
                    'type'          => $icon_settings_dependency
                )
            ),
            'image_as_icon' => array(
                'label'                 => esc_html__('Image', 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'upload_button_text'    => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'icon_settings',
                'show_if'         => array(
                    'use_icon'     => 'off',
                    'use_image_as_icon' => 'on',
                    'type'          => $icon_settings_dependency
                )

            ),
            'image_alt_text' => array (
                'label'                 => esc_html__( 'Image Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'icon_settings',
                'show_if'         => array(
                    'use_icon'     => 'off',
                    'use_image_as_icon' => 'on',
                    'type'          => $icon_settings_dependency
                )
            ),
            'image_as_icon_width' => array(
                'label'             => esc_html__('Icon Image Width(%)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'          => 'icon_settings',
                'default'           => '20px',
                'default_unit'      => 'px',
                'allowed_units'     => array('%', 'px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'use_icon'     => 'off',
                    'use_image_as_icon' => 'on',
                    'type'      => $icon_settings_dependency
                )
            ),
            
            'font_icon'                 => array(
				'label'                 => esc_html__( 'Icon', 'divi_flash' ),
				'type'                  => 'select_icon',
				'option_category'       => 'basic_option',
				'class'                 => array( 'et-pb-font-icon' ),
                'toggle_slug'           => 'icon_settings',
                'show_if'           => array(
                    'type'          => $icon_settings_dependency,
                    'use_icon'      => 'on'
                )
            ),
            'icon_color'            => array (
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
                'toggle_slug'       => 'icon_settings',
                'hover'             => 'tabs',
                'show_if'           => array(
                    'type'          => $icon_settings_dependency,
                    'use_icon'      => 'on'
                )
            ),
            'icon_size'             => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'toggle_slug'       => 'icon_settings',
                'default'           => '12px',
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
                    'type'          => $icon_settings_dependency,
                    'use_icon'      => 'on'
                )
            ),
            'use_only_icon'    => array(
                'label'         => esc_html__('Use Only Icon', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'icon_settings',
                'show_if'           => array(
                    'type'          => $icon_settings_dependency,
                    'text_show_on_hover' => 'off'
                )
            ),
            'only_icon_position' => array(
                'default'         => 'left',
                'label'           => esc_html__( 'Only Icon Position', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'left'         => esc_html__( 'left', 'divi_flash' ),
                    'center'       => esc_html__( 'Center', 'divi_flash' ),
                    'right'       => esc_html__( 'Right', 'divi_flash' ) 
                ),
                'toggle_slug'		    => 'icon_settings',
                'show_if'           => array(
                    'use_image_as_icon'  => 'on',
                    'use_only_icon' => 'on',
                    'meta_display'   => 'block',
                    'type'      => array('add_to_cart')
                ),
            ),
            'text_show_on_hover'    => array(
                'label'         => esc_html__('Text Show On Hover', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'icon_settings',
                'show_if'           => array(
                    'type'          => $icon_settings_dependency,
                    'use_only_icon'      => 'off'
                )
            ),
            'image_icon_placement' => array(
                'default'         => 'right',
                'label'           => esc_html__( 'Icon Image Placement', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'right'       => esc_html__( 'Right', 'divi_flash' ),
                    'left'         => esc_html__( 'left', 'divi_flash' )    
                ),
                'toggle_slug'		    => 'icon_settings',
                'show_if'           => array(
                    'use_only_icon' => 'off',
                    'type'      => $icon_settings_dependency
                ),
            ),
            'space_btw_text_icon'    => array (
                'label'             => esc_html__( 'Space Between Text and Icon ', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'icon_settings',
                'default'           => '10px',
                'default_unit'      => '',
                'allowed_units'     => array ('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '50',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if'           => array(
                    'use_only_icon' => 'off',
                    'type'      => $icon_settings_dependency
                ),
            ),
        );
 
        $image_settings = array(

            'overlay'    => array(
                'label'         => esc_html__('Overlay', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'overlay',
                'show_if'           => array(
                    'type'      => array('image')
                )
            ),
            'overlay_primary'  => array(
                'label'             => esc_html__( 'Overlay Primary color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'overlay',
                'default'           => '#00B4DB',
                'show_if'           => array(
                    'overlay'  => 'on',
                    'type'      => array('image')
                )
            ),
            'overlay_secondary'  => array(
                'label'             => esc_html__( 'Overlay Secondary color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'overlay',
                'default'           => '#0083B0',
                'show_if'           => array(
                    'overlay'  => 'on',
                    'type'      => array('image')
                )
            ),
            'overlay_direction'    => array (
                'label'             => esc_html__( 'Overlay Gradient Direction', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'overlay',
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
                    'overlay'  => 'on',
                    'type'      => array('image')
                )
            ),
            'overlay_icon'    => array(
                'label'         => esc_html__('Use Icon', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'overlay',
                'show_if'           => array(
                    'overlay'  => 'on',
                    'type'      => array('image')
                )
            ),
            'overlay_font_icon'                 => array(
				'label'                 => esc_html__( 'Icon', 'divi_flash' ),
                'description'           => esc_html__('Overlay Icon' , 'divi_flash' ),
				'type'                  => 'select_icon',
				'option_category'       => 'basic_option',
				'class'                 => array( 'et-pb-font-icon' ),
                'toggle_slug'           => 'overlay',
                'show_if'           => array(
                    'type'          => array('image'),
                    'overlay_icon'      => 'on',
                    'overlay'       => 'on'
                )
            ),
            'overlay_icon_color'            => array (
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
                'toggle_slug'       => 'overlay',
                'show_if'           => array(
                    'type'          => array('image'),
                    'overlay_icon'      => 'on',
                    'overlay'       => 'on'
                )
            ),
            'overlay_icon_size'             => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'toggle_slug'       => 'overlay',
                'default'           => '35px',
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
                    'type'          => array('image'),
                    'overlay_icon'      => 'on',
                    'overlay'       => 'on'
                )
            ),
            'overlay_icon_reveal'    => array(
                'label'    => esc_html__('Icon Reveal Type', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'df-fade-up'            => esc_html__('Fade Up', 'divi_flash'),
                    'df-fade-down'          => esc_html__('Fade Down', 'divi_flash'),
                    'df-fade-left'          => esc_html__('Fade Left', 'divi_flash'),
                    'df-fade-right'         => esc_html__('Fade Right', 'divi_flash'),
                    'df-fade-in'            => esc_html__('Fade In', 'divi_flash'),
                    'df-rotate-up-right'    => esc_html__('Rotate Up Right', 'divi_flash'),
                    'df-rotate-up-left'     => esc_html__('Rotate Up Left', 'divi_flash'),
                    'df-rotate-down-right'  => esc_html__('Rotate Down Right', 'divi_flash'),
                    'df-rotate-down-left'   => esc_html__('Rotate Down Left', 'divi_flash'),
                    'df-zoom-in'            => esc_html__('Zoom In', 'divi_flash'),
                ),
                'default'       => 'df-fade-up',
                'toggle_slug'   => 'overlay',
                'show_if'           => array(
                    'type'          => array('image'),
                    'overlay_icon'      => 'on',
                    'overlay'       => 'on'
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
                    // 'df-image-rotate-left'      => esc_html__('Rotate Left', 'divi_flash'),
                    // 'df-image-rotate-right'     => esc_html__('Rotate Right', 'divi_flash'),
                    // 'df-image-blur'             => esc_html__('Blur', 'divi_flash')
                ),
                'default'       => 'no-image-scale',
                'toggle_slug'   => 'overlay',
                'show_if'       => array(
                    'type'      => 'image'
                )
            ),
            'image_scale_hover'    => array (
                'label'             => esc_html__( 'Scale', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'overlay',
                'default'           => '1.3',
                'allowed_units'     => array (),
                'range_settings'    => array(
                    'min'  => '1.3',
                    'max'  => '3',
                    'step' => '.1',
                ),
                'validate_unit'    => false,
                'show_if'          => array (
                    'image_scale' => array( 'df-image-rotate-left', 'df-image-rotate-right')
                )
            ),
            'overlay_off_at_mobile'    => array(
                'label'         => esc_html__('Disable Overlay On Mobile', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'overlay',
                'show_if'           => array(
                    'overlay'  => 'on',
                    'type'      => array('image')
                )
            ),
        );

        $custom_text = array(
            'custom_text'    => array(
                'label'             => esc_html__('Custom Text', 'divi_flash'),
                'type'              => 'text',
                'toggle_slug'       => 'type',
                'show_if'           => array(
                    'type'      => array('custom_text')
                )
            ),
            'add_to_cart_text'    => array(
                'label'             => esc_html__('Add To Cart Text', 'divi_flash'),
                'type'              => 'text',
                'toggle_slug'       => 'type',
                'show_if'           => array(
                    'type'      => array('add_to_cart')
                )
            )

        );
        $rating = array(
            'rating_size' => array(
                'label'             => esc_html__( 'Rating Size', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'rating',
				'tab_slug'          => 'advanced',
				'default'           => '12px',
                'default_unit'      => 'px',
                'responsive'        => true,
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
                ),
                'show_if'           => array(
                    'type'              => 'rating'
                )
            ),
            'rating_color'=> array(
                'label'           => esc_html__('Rating Color', 'divi_flash'),
                'type'            => 'color-alpha',
                'toggle_slug'     => 'rating',
                'tab_slug'        => 'advanced',
                'hover'           => 'tabs',
                'show_if'           => array(
                    'type'              => 'rating'
                )
            ),

            'disable_rating_color'=> array(
                'label'           => esc_html__('Disable Rating Color', 'divi_flash'),
                'type'            => 'color-alpha',
                'toggle_slug'     => 'rating',
                'tab_slug'        => 'advanced',
                'hover'           => 'tabs',
                'show_if'           => array(
                    'type'              => 'rating'
                )
            ),

            'show_rating_all_item'    => array(
                'label'         => esc_html__('Show Disable Rating for no ratings Item', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'rating',
                'tab_slug'      => 'advanced',
                'show_if'       => array(
                    'type' => 'rating'
                )
            )
        );
        $spacing = $this->add_margin_padding(array(
            'key'           => 'element',
            'toggle_slug'   => 'custom_spacing'
        ));

        $button_spacing = $this->add_margin_padding(array(
            'title'         => 'Button',
            'key'           => 'button',
            'toggle_slug'   => 'custom_spacing',
            'show_if'       => array(
                'type'      => 'button'
            )
        ));

        $divider_spacing = $this->add_margin_padding(array(
            'title'         => 'Divider',
            'key'           => 'divider',
            'toggle_slug'   => 'custom_spacing',
            'show_if'       => array(
                'type'      => 'divider'
            )
        ));

        $image_spacing = $this->add_margin_padding(array(
            'title'         => 'Image',
            'key'           => 'image',
            'toggle_slug'   => 'custom_spacing',
            'option'        => 'margin',
            'show_if'       => array(
                'type'      => 'image'
            )
        ));

        $icon_spacing = $this->add_margin_padding(array(
            'title'         => 'Icon',
            'key'           => 'icon',
            'toggle_slug'   => 'custom_spacing',
            'option'        => 'margin',
            'show_if'       => array(
                'type'      => $icon_settings_dependency
            )
        ));

        $divider = array(
            'divider_line_height'    => array (
                'label'             => esc_html__( 'Divider Line Height', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'divider_line',
                'default'           => '3px',
                'default_unit'      => 'px',
                'allowed_units'     => array ('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if'           => array(
                    'type'  => 'divider'
                )
            ),
            'divider_color_primary'  => array(
                'label'             => esc_html__( 'Divider Color Primary', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'divider_line',
                'default'           => '#e02b20',
                'show_if'           => array(
                    'type'  => 'divider'
                )
            ),
            'divider_color_secondary'  => array(
                'label'             => esc_html__( 'Divider Color Secondary', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'divider_line',
                'default'           => '#fc7069',
                'show_if'           => array(
                    'type'  => 'divider'
                )
            ),
            'divider_color_direction'    => array (
                'label'             => esc_html__( 'Divider Color Direction', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'divider_line',
                'default'           => '90deg',
                'default_unit'      => 'deg',
                'allowed_units'     => array ('deg'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '360',
                    'step' => '1',
                ),
                // 'mobile_options'    => true,
                'show_if'           => array(
                    'type'  => 'divider'
                )
            ),
            'divider_color_start'    => array (
                'label'             => esc_html__( 'Starting Position', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'divider_line',
                'default'           => '0%',
                'default_unit'      => '%',
                'allowed_units'     => array ('%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                // 'mobile_options'    => true,
                'show_if'           => array(
                    'type'  => 'divider'
                )
            ),
            'divider_color_end'    => array (
                'label'             => esc_html__( 'Ending Position', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'divider_line',
                'default'           => '100%',
                'default_unit'      => '%',
                'allowed_units'     => array ('%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                // 'mobile_options'    => true,
                'show_if'           => array(
                    'type'  => 'divider'
                )
            ),
        );

        $category_settings = array(
            'use_separator'   => array(
                'label'             => esc_html__('Use Separator', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'type',
                'show_if'           => array(
                    'type'              => array('categories','tags')
                )
            ),

            'category_separator'    => array(
                'label'             => esc_html__('Separator', 'divi_flash'),
                'type'              => 'text',
                'toggle_slug'       => 'type',
                'show_if'           => array(
                    'type'              => array('categories','tags'),
                    'use_separator'     => 'on'
                )
            ),
            'use_category_link'   => array(
                'label'             => esc_html__('Use Link', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'type',
                'show_if'           => array(
                    'type'              => array('categories','tags')
                )
            ),
            'category_open_new_tab' => array(
                'label'           => esc_html__('Open on New Tab ', 'divi_flash'),
                'description'     => esc_html__('Choose whether your link opens in a new window or not', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'off' => esc_html__('In The Same Window', 'divi_flash'),
                    'on'  => esc_html__('In The New Tab', 'divi_flash'),
                ),
                'toggle_slug'     => 'type',
                'show_if'           => array(
                    'type'              => array('categories','tags'),
                    'use_category_link' => 'on'
                )
            )
        );
    
        $outside_inner_wrapper = array(
            'outside_wrapper'   => array(
                'label'             => esc_html__('Outside Inner Wrapper', 'divi_flash'),
                'type'              => 'yes_no_button',
                'description'       => esc_html__('This will put the content outside the inner wrapper.', 'divi_flash'),
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'type',
                'show_if'           => array(
                    'type'      => array('image', 'title', 'rating', 'price', 'short_description','add_to_cart', 'categories' , 'custom_text', 'tags', 'button' , 'divider' )
                )
            )
        );
        return array_merge(
            $general,
            $title,
            $price,
            $custom_text,
            $meta_sttings,
            $rating,
            $content,
            $read_more,
            $icon_settings,
            $animation_sttings,
            $image_settings,
            $divider,
            $spacing,
            $button_spacing,
            $divider_spacing,
            $image_spacing,
            $icon_spacing,
            $category_settings,
            $outside_inner_wrapper
            // $term_items_background,
            // $category_tag_design,
            // $category_tag_spacing
        );
    }
  //for custom transition
    public function before_render() {
        $this->props['type__hover'] = '1px||||false|false';
        $this->props['type__hover_enabled'] = "on|hover";

        $this->props['display_type__hover'] = '1px||||false|false';
        $this->props['display_type__hover_enabled'] = "on|hover";
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $add_to_cart = '.df-product-outer-wrap %%order_class%%.df-product-add-to-cart-wrap a.add_to_cart_button';
        $fields['icon_color'] = array('color' => '%%order_class%%.df-item-wrap .et-pb-icon');
        $fields['rating_color'] = array('color' => '%%order_class%%.df-product-rating-wrap .star-rating span::before');
        $fields['disable_rating_color'] = array('color' => '%%order_class%%.df-product-rating-wrap .star-rating::before');
        $fields['element_margin'] = array('margin' => '%%order_class%%');
        $fields['element_padding'] = array('padding' => '%%order_class%%');
        $fields['icon_margin'] = array('margin' => '%%order_class%%.df-item-wrap .et-pb-icon');
        $fields['button_margin'] = array('margin' => '%%order_class%% a');
        $fields['button_padding'] = array('padding' => '%%order_class%% a');
        $fields['image_margin'] = array('margin' => '%%order_class%% img');
        $fields['divider_margin'] = array('margin' => '%%order_class%% span');
        $fields['divider_padding'] = array('padding' => '%%order_class%% span');
        $fields['add_to_cart_margin'] = array('margin' => $add_to_cart);
        $fields['add_to_cart_padding'] = array('padding' => $add_to_cart);

        $fields['type'] = array('opacity' => '%%order_class%%');
        $fields['display_type'] = array('transform' => '%%order_class%%');
        //border
        $fields = $this->df_fix_border_transition(
            $fields, 
            'add_to_cart', 
            $add_to_cart
        );

        // box-shadow
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'add_to_cart',
            $add_to_cart
        );
        return $fields;
    }
    
    public function additional_css_styles($render_slug) {
        $meta = array('rating', 'add_to_cart', 'button', 'price','categories', 'tags', 'custom_text'); // Remove 'quick_view',

        if(in_array($this->props['type'], $meta)) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%',
                'declaration' => sprintf('display: %1$s;', $this->props['meta_display'])
            ));
            if($this->props['meta_display'] === 'inline-block'){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%%',
                    'declaration' => 'vertical-align: middle;'
                ));
            }
        } 
        if($this->props['type'] === 'button' && $this->props['meta_display'] === 'block' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%.df-product-button-wrap a.df-product-read-more',
                'declaration' => 'display: block;'
            ));
        }
        if($this->props['text_show_on_hover'] ==='on' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%.df-item-wrap.df-product-add-to-cart-wrap a.df_button',
                'declaration' => sprintf('font-size: 0px;')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%.df-item-wrap.df-product-add-to-cart-wrap a.df_button:hover',
                'declaration' => sprintf('font-size: inherit;')
            ));
        }    
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_size',
            'type'              => 'font-size',
            'selector'          => '%%order_class%%.df-item-wrap .et-pb-icon,
                                    %%order_class%%.df-product-add-to-cart-wrap a.added_to_cart.wc-forward::after,
                                    %%order_class%%.df-product-add-to-cart-wrap a.added_to_cart.wc-forward::before'
        ) );
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%%.df-item-wrap .et-pb-icon,
                                    %%order_class%%.df-product-add-to-cart-wrap a.added_to_cart.wc-forward::after,
                                    %%order_class%%.df-product-add-to-cart-wrap a.added_to_cart.wc-forward::before',
            'hover'             => '%%order_class%%.df-item-wrap:hover .et-pb-icon,
                                    %%order_class%%.df-product-add-to-cart-wrap:hover a.added_to_cart.wc-forward::after,
                                    %%order_class%%.df-product-add-to-cart-wrap:hover a.added_to_cart.wc-forward::before'
        ));
         // Icon Setting design
        if($this->props['use_icon'] ==='on' || $this->props['use_image_as_icon'] === 'on'){
            $type = $this->props['image_icon_placement'] === 'left' ? 'margin-right' : 'margin-left';
            $icon_selector = '%%order_class%%.df-item-wrap a.df_button span.et-pb-icon,
                        %%order_class%%.df-item-wrap a.df_button img.df_product_icon_image,
                        %%order_class%%.df-product-add-to-cart-wrap a.added_to_cart.wc-forward::after,
                        %%order_class%%.df-product-add-to-cart-wrap a.added_to_cart.wc-forward::before';
            if($this->props['use_only_icon'] === 'off'){
                $this->df_process_range( array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'space_btw_text_icon',
                    'type'              => $type,
                    'selector'          => $icon_selector
                 ));
            }         
        }

       if($this->props['use_image_as_icon'] === 'on') {
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'image_as_icon_width',
                'type'              => 'width',
                'selector'          => '%%order_class%%.df-item-wrap a.df_button img'
            ) );

            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'image_as_icon_width',
                'type'              => 'font-size',
                'selector'          => '%%order_class%%.df-product-add-to-cart-wrap a.added_to_cart.wc-forward::after,
                                         %%order_class%%.df-product-add-to-cart-wrap a.added_to_cart.wc-forward::before'
            ) );
        }
        
   
        
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_icon_placement',
            'type'              => 'float',
            'selector'          => '%%order_class%%.df-item-wrap:not(.only_icon_in_cart) a.df_button img',
            'important'         => true,
            'default'           => 'right'
        ));   
        if($this->props['use_only_icon'] === 'on'  &&  $this->props['use_image_as_icon'] === 'on' && $this->props['meta_display'] === 'block') {
         
            if($this->props['only_icon_position'] === 'center'){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%%.df-item-wrap.only_icon_in_cart a img.df_product_icon_image",
                    'declaration' => 'display:block; margin:0px auto !important;'
                ));
            }else{
                $this->df_process_string_attr(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'only_icon_position',
                    'type'              => 'float',
                    'selector'          => '%%order_class%%.df-item-wrap.only_icon_in_cart a img.df_product_icon_image',
                    'important'         => true,
                    'default'           => 'left'
                ));
            }

            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'only_icon_position',
                'type'              => 'text-align',
                'selector'          => '%%order_class%%.df-item-wrap.only_icon_in_cart a.added_to_cart.wc-forward',
                'important'         => true,
                'default'           => 'left'
            ));
        }

        // Animation
        if(isset($this->props['display_type']) && $this->props['display_type'] ==='show_on_hover'){
     
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => ".df-item-wrap%%order_class%%",
                'declaration' => sprintf('opacity: 0;')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => ".df-product-outer-wrap:hover .df-item-wrap%%order_class%%",
                'declaration' => sprintf('opacity: 1; ')
            ));
            if($this->props['always_show_on_mobile'] === 'on'){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => ".df-item-wrap%%order_class%%",
                    'declaration' => sprintf('opacity: 1;'),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
            }
        }

        if(isset($this->props['display_type']) && $this->props['display_type'] ==='hide_on_hover'){
     
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => ".df-item-wrap%%order_class%%",
                'declaration' => sprintf('opacity: 1;')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => ".df-product-outer-wrap:hover .df-item-wrap%%order_class%%",
                'declaration' => sprintf('opacity: 0; ')
            ));

            if($this->props['always_show_on_mobile'] === 'on'){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => ".df-product-outer-wrap:hover",
                    'declaration' => sprintf('opacity: 1;'),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
            }
        }

        // Rating
        if($this->props['type'] === 'rating'){
        
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'rating_color',
                'type'              => 'color',
                'selector'          => "%%order_class%%.df-product-rating-wrap .star-rating span::before",
                'hover'             => ".df-product-outer-wrap:hover %%order_class%%.df-product-rating-wrap .star-rating span::before"
            ));

            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'disable_rating_color',
                'type'              => 'color',
                'selector'          => "%%order_class%%.df-product-rating-wrap .star-rating::before",
                'hover'            => ".df-product-outer-wrap:hover %%order_class%%.df-product-rating-wrap .star-rating::before",
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'rating_size',
                'type'              => 'font-size',
                'selector'          => "%%order_class%%.df-product-rating-wrap .star-rating",
                'hover'             => ".df-product-outer-wrap:hover %%order_class%%.df-product-rating-wrap .star-rating"
            ));
        }

        if ($this->props['image_scale'] === 'df-image-rotate-left') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => ".df-hover-trigger:hover {$this->main_css_element} .df-image-rotate-left img, :focus.df-hover-trigger {$this->main_css_element} .df-image-rotate-left img",
                'declaration' => sprintf('transform: scale(%1$s) rotate(-15deg);', $this->props['image_scale_hover'])
            ));
        }
        if ($this->props['image_scale'] === 'df-image-rotate-right') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => ".df-hover-trigger:hover {$this->main_css_element} .df-image-rotate-right img, :focus.df-hover-trigger {$this->main_css_element} .df-image-rotate-right img",
                'declaration' => sprintf('transform: scale(%1$s) rotate(15deg);', $this->props['image_scale_hover'])
            ));
        }
        // overlay
        if($this->props['overlay'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-hover-effect .df-overlay',
                'declaration' => sprintf('background-image: linear-gradient(%4$s, %1$s 0, %2$s %3$s);',
                    $this->props['overlay_primary'],
                    $this->props['overlay_secondary'],
                    '100%',
                    $this->props['overlay_direction']
                )
            ));
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'overlay_icon_size',
                'type'              => 'font-size',
                'selector'          => '%%order_class%%.df-item-wrap .df-icon-overlay'
            ) );
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'overlay_icon_color',
                'type'              => 'color',
                'selector'          => '%%order_class%%.df-item-wrap .df-icon-overlay'
            ));
            if(isset($this->props['overlay_off_at_mobile']) && $this->props['overlay_off_at_mobile'] ==='on' ){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% .df-hover-effect .df-overlay",
                    'declaration' => sprintf('display: none;'),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767')
                ));
            }
        }


        if($this->props['type'] === 'divider') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-product-ele-divider',
                'declaration' => sprintf('background-image: linear-gradient(%1$s, %2$s %4$s, %3$s %5$s);',
                    $this->props['divider_color_direction'],
                    $this->props['divider_color_primary'],
                    $this->props['divider_color_secondary'],
                    $this->props['divider_color_start'],
                    $this->props['divider_color_end']
                )
            ));
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'divider_line_height',
                'type'              => 'height',
                'selector'          => '%%order_class%%.df-item-wrap .df-product-ele-divider'
            ) );
        }
        // spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'element_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element}",
            'hover'             => ".df-hover-trigger:hover {$this->main_css_element}",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'element_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element}",
            'hover'             => ".df-hover-trigger:hover {$this->main_css_element}",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} a",
            'hover'             => ".df-hover-trigger:hover {$this->main_css_element}",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} a",
            'hover'             => ".df-hover-trigger:hover {$this->main_css_element}", 
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element}.df-item-wrap a.df_button img.df_product_icon_image,
                                    {$this->main_css_element} .et-pb-icon",
            'hover'             => ".df-hover-trigger:hover {$this->main_css_element}.df-item-wrap a.df_button img.df_product_icon_image,
                                    .df-hover-trigger:hover {$this->main_css_element} .et-pb-icon"
        ));
        
        if ($this->props['type'] === 'image') {
       
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'image_margin',
                'type'              => 'margin',
                'selector'          => ".woocommerce ul li.product {$this->main_css_element} a.df-hover-effect img",
                'hover'             => ".woocommerce ul li.product .df-hover-trigger:hover {$this->main_css_element} img"
            ));
        }


        if ($this->props['type'] === 'divider') {
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'divider_padding',
                'type'              => 'padding',
                'selector'          => "{$this->main_css_element} span",
                'hover'             => ".df-hover-trigger:hover {$this->main_css_element} span"
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'divider_margin',
                'type'              => 'margin',
                'selector'          => "{$this->main_css_element} span",
                'hover'             => ".df-hover-trigger:hover {$this->main_css_element} span"
            ));
        }
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

            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'overlay_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .df-icon-overlay',
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
        global $df_product_items, $df_product_items_outside, $df_product_element;
        $type_settings = array();

        if(!empty($this->props['type']) && 'select' !== $this->props['type']) {
            $type_settings['type'] = $this->props['type'];
            $type_settings['class'] = ET_Builder_Element::get_module_order_class( $render_slug );
            // title
            $type_settings['title_tag'] = $this->props['title_tag'];
            $type_settings['price_tag'] = $this->props['price_tag'];
            // content
            $type_settings['use_product_excrpt'] = $this->props['use_product_excrpt'];
            $type_settings['excerpt_length'] = $this->props['excerpt_length'];
            // rating
            $type_settings['show_rating_all_item'] = $this->props['show_rating_all_item'];
            // Read More
            $type_settings['read_more_text'] = $this->props['read_more_text'];
            // icon
            $type_settings['use_icon'] = $this->props['use_icon'];
            $type_settings['font_icon'] = isset($this->props['font_icon']) && $this->props['font_icon'] !== '' ? 
                esc_attr(et_pb_process_font_icon( $this->props['font_icon'] )) : '5';
            
            $type_settings['use_image_as_icon'] = $this->props['use_image_as_icon'];
            $type_settings['image_as_icon'] = $this->props['image_as_icon'];
            $type_settings['image_alt_text'] =  $this->props['image_alt_text'] !== '' ? $this->props['image_alt_text']: '';
            $type_settings['image_as_icon_width'] = $this->props['image_as_icon_width'];
            $type_settings['image_icon_placement'] = $this->props['image_icon_placement'];
            // Categories
            $type_settings['use_category_link'] = $this->props['use_category_link'];
            $type_settings['use_separator'] = $this->props['use_separator'];
            $type_settings['category_separator'] = isset($this->props['category_separator'])? $this->props['category_separator'] : '|'; 
            $type_settings['category_open_new_tab'] = $this->props['category_open_new_tab'];
            
            // placement
            $type_settings['placement'] = $this->props['outside_wrapper'];
            // hover
            $type_settings['image_scale'] = $this->props['image_scale'];
            $type_settings['overlay'] = $this->props['overlay'];
            // overlay icon
            $type_settings['overlay_icon'] = $this->props['overlay_icon'];
            $type_settings['overlay_icon_reveal'] = $this->props['overlay_icon_reveal'];
            $type_settings['overlay_font_icon'] = isset($this->props['overlay_icon']) && $this->props['overlay_icon'] !== '' ? $this->props['overlay_font_icon'] : '%%16%%';

            // custom text
            $type_settings['custom_text'] = $this->props['custom_text'];
            $type_settings['add_to_cart_text'] = !empty($this->props['add_to_cart_text']) ? $this->props['add_to_cart_text'] : 'Add To Cart';
            $type_settings['use_only_icon'] = $this->props['use_only_icon'];

             // background
             $type_settings['background_enable_mask_style'] = isset($this->props['background_enable_mask_style']) ? $this->props['background_enable_mask_style'] : 'off';
             $type_settings['background_enable_pattern_style'] = isset($this->props['background_enable_pattern_style']) ? $this->props['background_enable_pattern_style'] : 'off';
            
        }   

        if ($this->props['outside_wrapper'] === 'on') {
            $df_product_items_outside[] = $type_settings;
        } else if(!empty($this->props['type']) && 'select' !== $this->props['type']) {
            $df_product_items[] = $type_settings;
        }

        $df_product_element = array(
            'df_product_items' => $df_product_items,
            'df_product_items_outside'=>$df_product_items_outside
        );

        return;
    }

    /**
	 * Process transform options.
	 *
	 * @param string $function_name Function name.
	 *
	 * @since 4.6.0 Add sticky style support.
	 */
	public function process_transform( $function_name ) {

		$transform = self::$_->array_get( $this->advanced_fields, 'transform', array() );

		if ( false === $transform || ! is_array( $transform ) ) {
			return;
		}

		// @codingStandardsIgnoreLine
		$selector = self::$_->array_get( $transform, 'css.main', '%%order_class%%' );

		/**
		 * The "a" element of the button module is the one that should be
		 * scaled and not its wrapper
		 */
		if ( 'et_pb_button' === $function_name ) {
			$selector .= ' a';
		}

		$important             = self::$_->array_get( $transform, 'css.important', false );
		$hover                 = et_pb_hover_options();
		$sticky                = et_pb_sticky_options();
		$is_hover_enabled      = $hover->is_enabled( 'transform_styles', $this->props );
		$is_sticky_enabled     = $sticky->is_enabled( 'transform_styles', $this->props );
		$is_responsive_enabled = isset( $this->props['transform_styles_last_edited'] ) && et_pb_get_responsive_status( $this->props['transform_styles_last_edited'] );
		$responsive_direction  = isset( $this->props['animation_direction_last_edited'] ) && et_pb_get_responsive_status( $this->props['animation_direction_last_edited'] );
		$animation_type        = self::$_->array_get( $this->props, 'animation_style', 'none' );

		/**
		 * Transform instance.
		 *
		 * @var ET_Builder_Module_Field_Transform $class Transform field class instance.
		 */
		$class = ET_Builder_Module_Fields_Factory::get( 'Transform' );
		$class->set_props( $this->props + array( 'transforms_important' => $important ) );
		$position_locations = $this->get_position_locations();

		$is_enabled = $this->_features_manager->get(
			// Transforms is enabled.
			'tra',
			function() use ( $class, $position_locations ) {
				return $class->is_used( $this->props, $position_locations );
			}
		);

		if ( ! $is_enabled ) {
			return;
		}

		$views = array( 'desktop' );
		if ( $is_hover_enabled || isset( $position_locations['hover'] ) ) {
			array_push( $views, 'hover' );
		}

		if ( $is_sticky_enabled || isset( $position_locations['sticky'] ) ) {
			array_push( $views, 'sticky' );
		}

		if ( $is_responsive_enabled || ( 'none' !== $animation_type && $responsive_direction )
			 || ( isset( $position_locations['hover'] ) || isset( $position_locations['phone'] ) ) ) {
			array_push( $views, 'tablet', 'phone' );
		}
		foreach ( $views as $view ) {
			$view_selector = $selector;
			$device        = $view;
			if ( ! $is_responsive_enabled && in_array( $view, array( 'phone', 'tablet' ), true ) || ( 'hover' === $view && ! $is_hover_enabled ) || ( 'sticky' === $view && ! $is_sticky_enabled ) ) {
				$device = 'desktop';
			}
			$elements    = $class->get_elements( $device );
			$media_query = array();

			if ( 'hover' === $view ) {
				$view_selector = '.df-hover-trigger:hover '. $selector;
			} elseif ( 'sticky' === $view ) {
				$view_selector = $sticky->add_sticky_to_selectors( $selector, $this->is_sticky_module );
			} elseif ( 'tablet' === $view ) {
				$media_query = array(
					'media_query' => self::get_media_query( 'max_width_980' ),
				);
			} elseif ( 'phone' === $view ) {
				$media_query = array(
					'media_query' => self::get_media_query( 'max_width_767' ),
				);
			}

			if ( isset( $position_locations[ $view ] ) ) {
				$default_strpos = strpos( $position_locations[ $view ], '_is_default' );
				$location       = $position_locations[ $view ];
				if ( false !== $default_strpos ) {
					$location = substr( $position_locations[ $view ], 0, $default_strpos );
				}
				if ( ! isset( $elements['transform']['translateX'] ) ) {
					if ( in_array( $location, array( 'top_center', 'bottom_center', 'center_center' ), true ) ) {
						$elements['transform']['translateX'] = '-50%';
					} elseif ( 'desktop' !== $view ) {
						$elements['transform']['translateX'] = '0px';
					}
				}
				if ( ! isset( $elements['transform']['translateY'] ) ) {
					if ( in_array( $location, array( 'center_left', 'center_right', 'center_center' ), true ) ) {
						$elements['transform']['translateY'] = '-50%';
					} elseif ( 'desktop' !== $view ) {
						$elements['transform']['translateY'] = '0px';
					}
				}
			}

			if ( ! empty( $elements['transform'] ) || ! empty( $elements['origin'] ) ) {

				if ( 'hover' !== $view && 'sticky' !== $view && ! empty( $animation_type ) && 'none' !== $animation_type && 'fade' !== $animation_type ) {

					$transformed_animation = $class->transformedAnimation( $animation_type, $elements, $function_name, $device );

					if ( ! empty( $transformed_animation ) ) {
						self::set_style( $function_name, $transformed_animation['keyframe'] + $media_query );
						self::set_style( $function_name, $transformed_animation['animationRules'] + $media_query );
						$el_style = array(
							'selector'    => $view_selector,
							'declaration' => $transformed_animation['declaration'],
							'priority'    => $this->_style_priority,
						) + $media_query;
						self::set_style( $function_name, $el_style );
					}
				} else {
					$declaration = '';
					if ( ! empty( $elements['transform'] ) ) {
						$declaration .= $class->getTransformDeclaration( $elements['transform'], $view );
					}

					if ( ! empty( $elements['origin'] ) ) {
						if ( $important ) {
							array_push( $elements['origin'], '!important' );
						}
						$declaration .= sprintf( 'transform-origin:%s;', implode( ' ', $elements['origin'] ) );
					}

					$el_style = array(
						'selector'    => $view_selector,
						'declaration' => $declaration,
						'priority'    => $this->_style_priority,
					) + $media_query;
					self::set_style( $function_name, $el_style );

					// Flag sticky module that uses transform uses classname on module wrapper
					// so its offset calculation can be adjusted (jQuery offsets() gets the edge
					// of transformed module so its offset will be outside its parent).
					if ( 'sticky' !== $view && $this->is_sticky_module ) {
						$this->add_classname( 'et_pb_sticky--has-transform' );
					}
				}
			}
		}
	}
}
new DIFL_ProductItem;
