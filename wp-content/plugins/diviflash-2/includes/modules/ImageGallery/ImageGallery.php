<?php

class DIFL_ImageGallery extends ET_Builder_Module {
    use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_imagegallery';
    public $vb_support = 'on';
    public $child_slug = 'difl_imagegalleryitem';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Advanced Gallery', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/image-gallery.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'settings'  => esc_html__('Gallery Settings', 'divi_flash'),
                    'hover'     => esc_html__('Hover Settings', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'font_styles'    => array (
                        'title'             => esc_html__('Font Styles', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'caption'   => array(
                                'name' => 'Caption',
                            ),
                            'description'     => array(
                                'name' => 'Description',
                            )
                        ),
                    ),
                    'image'                 => esc_html__('Image', 'divi_flash'),
                    'filter_btn'            => esc_html__('Filter Buttons', 'divi_flash'),
                    'filter_btn_active'     => esc_html__('Active Filter Button', 'divi_flash'),
                    'more_btn'              => esc_html__('Load More Button', 'divi_flash'),
                    'df_borders'            => esc_html__('Borders', 'divi_flash'),
                    'pagination'            => esc_html__( 'Pagination Button Styles', 'divi_flash' ),
                    'active_pagination'     => esc_html__( 'Active Pagination Number', 'divi_flash' ),
                )
            )
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['fonts'] = array(
            'caption'     => array(
                'label'         => esc_html__( 'Caption', 'divi_flash' ),
                'toggle_slug'   => 'font_styles',
                'sub_toggle'    => 'caption',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ig_caption",
                    'hover' => "%%order_class%% .df_ig_image:hover .df_ig_caption",
                    'important'	=> 'all'
                ),
            ),
            'description'     => array(
                'label'         => esc_html__( 'Description', 'divi_flash' ),
                'toggle_slug'   => 'font_styles',
                'sub_toggle'    => 'description',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_ig_description",
                    'hover' => "%%order_class%% .df_ig_image:hover .df_ig_description",
                    'important'	=> 'all'
                ),
            ),
            'filter_btns'     => array(
                'label'         => esc_html__( 'Filter Buttons', 'divi_flash' ),
                'toggle_slug'   => 'filter_btn',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_filter_buttons button",
                    'hover' => "%%order_class%% .df_filter_buttons button:hover",
                    'important'	=> 'all'
                ),
            ),
            'active_filter_btn'     => array(
                'label'         => esc_html__( 'Active Button', 'divi_flash' ),
                'toggle_slug'   => 'filter_btn_active',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_filter_buttons button.is-checked",
                    'hover' => "%%order_class%% .df_filter_buttons button.is-checked:hover",
                    'important'	=> 'all'
                ),
            ),
            'more_btn'     => array(
                'label'         => esc_html__( 'Button', 'divi_flash' ),
                'toggle_slug'   => 'more_btn',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .ig-load-more-btn",
                    'hover' => "%%order_class%% .ig-load-more-btn:hover",
                    'important'	=> 'all'
                ),
            ),
            'pagination'        => array(
	            'label'       => et_builder_i18n( 'Pagination' ),
	            'css'         => array(
		            'main'  => "%%order_class%% .pagination .page-numbers",
		            'hover' => "%%order_class%% .pagination .page-numbers:hover"
	            ),
	            'line_height' => array(
		            'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
	            ),
	            'font_size'   => array(
		            'default' => '16px',
	            ),
	            'toggle_slug' => 'pagination'
            ),
            'active_pagination' => array(
	            'label'       => et_builder_i18n( 'Pagination' ),
	            'css'         => array(
		            'main'  => "%%order_class%% .pagination .page-numbers.current",
		            'hover' => "%%order_class%% .pagination .page-numbers.current:hover"
	            ),
	            'line_height' => array(
		            'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
	            ),
	            'font_size'   => array(
		            'default' => '16px',
	            ),
	            'toggle_slug' => 'active_pagination'
            )
        );

        $advanced_fields['borders'] = array(
            'default'               => false,
            'filter_container'      => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_filter_buttons',
                        'border_styles' => '%%order_class%% .df_filter_buttons',
                        'border_styles_hover' => '%%order_class%% .df_filter_buttons:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'df_borders',
                'label_prefix'      => 'Filter Container'
            ),
            'image'                 => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_ig_image .item-content',
                        'border_styles' => '%%order_class%% .df_ig_image .item-content',
                        'border_styles_hover' => '%%order_class%% .df_ig_image:hover .item-content',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'df_borders',
                'label_prefix'      => 'Image'
            ),
            'filter_btn'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_filter_buttons button',
                        'border_styles' => '%%order_class%% .df_filter_buttons button',
                        'border_styles_hover' => '%%order_class%% .df_filter_buttons button:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'filter_btn',
                'label_prefix'      => 'Button'
            ),
            'active_filter_btn'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df_filter_buttons button.is-checked',
                        'border_styles' => '%%order_class%% .df_filter_buttons button.is-checked',
                        'border_styles_hover' => '%%order_class%% .df_filter_buttons button.is-checked:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'filter_btn_active',
                'label_prefix'      => 'Button'
            ),
            'morebtn_border'              => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .ig-load-more-btn",
                        'border_radii_hover' => "{$this->main_css_element} .ig-load-more-btn:hover",
                        'border_styles' => "{$this->main_css_element} .ig-load-more-btn",
                        'border_styles_hover' => "{$this->main_css_element} .ig-load-more-btn:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'more_btn',
                'label_prefix'      => 'Button'
            ),
            'pagination'        => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => '%%order_class%% .pagination .page-numbers:not(.dots)',
			            'border_radii_hover'  => '%%order_class%% .pagination .page-numbers:not(.dots):hover',
			            'border_styles'       => '%%order_class%% .pagination .page-numbers:not(.dots)',
			            'border_styles_hover' => '%%order_class%% .pagination .page-numbers:not(.dots):hover',
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'pagination'
            ),
            'active_pagination' => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => '%%order_class%% .pagination .page-numbers.current',
			            'border_radii_hover'  => '%%order_class%% .pagination .page-numbers.current:hover',
			            'border_styles'       => '%%order_class%% .pagination .page-numbers.current',
			            'border_styles_hover' => '%%order_class%% .pagination .page-numbers.current:hover',
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'active_pagination'
            )
        );
        
        $advanced_fields['box_shadow'] = array(
            'default'   => false,
            'image'     => array(
                'css' => array(
                    'main' => "%%order_class%% .item-content",
                    'hover' => "%%order_class%% .item-content:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'image'
            ),
            'filter_btn'     => array(
                'css' => array(
                    'main' => "%%order_class%% .df_filter_buttons button",
                    'hover' => "%%order_class%% .df_filter_buttons button:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'filter_btn'
            ),
            'active_filter_btn'     => array(
                'css' => array(
                    'main' => "%%order_class%% .df_filter_buttons button.is-checked",
                    'hover' => "%%order_class%% .df_filter_buttons button.is-checked:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'filter_btn_active'
            ),
            'more_button'     => array(
                'css' => array(
                    'main' => "%%order_class%% .ig-load-more-btn",
                    'hover' => "%%order_class%% .ig-load-more-btn:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'more_btn'
            ),
            'pagination'        => array(
	            'css'         => array(
		            'main'  => "%%order_class%% .pagination .page-numbers:not(.dots)",
		            'hover' => "%%order_class%% .pagination .page-numbers:not(.dots):hover",
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'pagination'
            ),
            'active_pagination' => array(
	            'css'         => array(
		            'main'  => "%%order_class%% .pagination .page-numbers.current",
		            'hover' => "%%order_class%% .pagination .page-numbers.current:hover",
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'active_pagination'
            )
        );
        $advanced_fields["filters"] = array(
			'child_filters_target' => array(
				'tab_slug' => 'advanced',
				'toggle_slug' => 'image',
				'css' => array(
					'main' => '%%order_class%% img'
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

        $advanced_fields['text'] = false;
        
        $advanced_fields['transform'] = false;

	    $advanced_fields['margin_padding'] = array(
		    'css' => array(
			    'main' => array(
				    '%%order_class%% .df_ig_container',
			    )
		    ),
	    );
    
        return $advanced_fields;
    }
	function modify_et_builder_backend_helpers($data) {
		$data['urls']['restUrl'] = get_rest_url(null,"/wp/v2/");
		return $data;
	}


	public function get_fields() {
		add_filter('et_fb_backend_helpers', [$this,'modify_et_builder_backend_helpers']);
        $general = array (
	        'df_gallery_enable_category' => array(
		        'label'       => esc_html__( 'Use Category', 'divi_flash' ),
		        'type'        => 'yes_no_button',
		        'options'     => array(
			        'off' => esc_html__( 'Off', 'divi_flash' ),
			        'on'  => esc_html__( 'On', 'divi_flash' ),
		        ),
		        'default'     => 'off',
		        'tab_slug'    => 'general',
		        'toggle_slug' => 'settings',
	        ),
	        'category_ids' => array(
		        'label'            => esc_html__( 'Category', 'divi_flash' ),
		        'type'             => 'df_gallery_multi_select',
		        'default'          => '[]',
		        'default_in_front' => '[]',
		        'tab_slug'         => 'general',
		        'toggle_slug'      => 'settings',
		        'show_if'          => array(
			        'df_gallery_enable_category' => 'on',
		        ),
	        ),
            'image_size'    => array(
                'label'    => esc_html__('Image Size', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'thumbnail' => esc_html__('Thumbnail', 'divi_flash'),
                    'medium'    => esc_html__('Medium', 'divi_flash'),
                    'large'     => esc_html__('Large', 'divi_flash'),
                    'original'  => esc_html__('Original', 'divi_flash')
                ),
                'default'       => 'medium',
                'toggle_slug'   => 'settings',
                'show_if'       => array(
	                'use_orientation' => 'off'
                )
            ),
            'image_to_display'    => array(
                'label'    => esc_html__('Image in row', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    '1'     => esc_html__('1 Item', 'divi_flash'),
                    '2'     => esc_html__('2 Items', 'divi_flash'),
                    '3'     => esc_html__('3 Items', 'divi_flash'),
                    '4'     => esc_html__('4 Items', 'divi_flash'),
                    '5'     => esc_html__('5 Items', 'divi_flash'),
                    '6'     => esc_html__('6 Items', 'divi_flash'),
                    '7'     => esc_html__('7 Items', 'divi_flash'),
                    '8'     => esc_html__('8 Items', 'divi_flash')
                ),
                'default'       => '4',
                'toggle_slug'   => 'settings',
                'mobile_options'=> true
            ),
            'layout_mode'    => array(
                'label'    => esc_html__('Layout Mode', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'masonry'     => esc_html__('Masonry', 'divi_flash'),
                    'fitRows'     => esc_html__('Grid', 'divi_flash')
                ),
                'default'       => 'masonry',
                'toggle_slug'   => 'settings'
            ),
	        'use_orientation'    => array(
		        'label'         => esc_html__('Use Image Orientation', 'divi_flash'),
		        'type'          => 'yes_no_button',
		        'options'       => array (
			        'off' => esc_html__( 'Off', 'divi_flash' ),
			        'on'  => esc_html__( 'On', 'divi_flash' ),
		        ),
		        'default'       => 'off',
		        'toggle_slug'   => 'settings'
	        ),
	        'image_orientation'                    => array(
		        'label'            => esc_html__( 'Image Orientation', 'divi_flash' ),
		        'type'             => 'select',
		        'options_category' => 'configuration',
		        'options'          => array(
			        'landscape' => esc_html__( 'Landscape', 'divi_flash' ),
			        'portrait'  => esc_html__( 'Portrait', 'divi_flash' ),
		        ),
		        'default_on_front' => 'landscape',
		        'tab_slug'         => 'general',
		        'toggle_slug'      => 'settings',
		        'show_if'       => array(
			        'use_orientation' => 'on'
		        )
	        ),
            'item_gutter'    => array (
                'label'             => esc_html__( 'Space Between', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'settings',
                'default'           => '10px',
                'default_unit'      => '',
                'allowed_units'     => array ('px'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '50',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'use_image_order'    => array(
                'label'         => esc_html__('Use Image Order', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'settings'
            ),
            'image_order'    => array(
                'label'    => esc_html__('Image Order', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'random'        => esc_html__('Random', 'divi_flash'),
                    'asc'           => esc_html__('ASC', 'divi_flash'),
                    'desc'          => esc_html__('DESC', 'divi_flash')
                ),
                'default'       => 'random',
                'toggle_slug'   => 'settings',
                'show_if'       => array(
                    'use_image_order' => 'on'
                )
            ),
            'filter_nav'    => array(
                'label'         => esc_html__('Filter Nav', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'settings',
                'show_if_not'   => array(
	                'load_more'       => 'on',
	                'show_pagination' => 'on'
                )
            ),
	        'disable_filter_nav_all_button'    => array(
		        'label'         => esc_html__('Disable First Nav', 'divi_flash'),
		        'type'          => 'yes_no_button',
		        'options'       => array (
			        'off' => esc_html__( 'Off', 'divi_flash' ),
			        'on'  => esc_html__( 'On', 'divi_flash' ),
		        ),
		        'default'       => 'off',
		        'toggle_slug'   => 'settings',
		        'show_if'       => array(
			        'filter_nav'    => 'on'
		        )
	        ),
            'filter_nav_all_button'    => array(
                'label'         => esc_html__('First Nav Text', 'divi_flash'),
                'type'          => 'text',
                'default'       => 'All',
                'toggle_slug'   => 'settings',
                'show_if'       => array(
	                'filter_nav'    => 'on',
                    'disable_filter_nav_all_button'    => 'off'
                )
            ),
            'load_more'    => array(
                'label'         => esc_html__('Load More button', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'settings',
                'show_if_not'   => array(
	                'filter_nav'      => 'on',
	                'show_pagination' => 'on'
                )
            ),
            'init_count'    => array(
                'label'         => esc_html__('Initial Image Load', 'divi_flash'),
                'type'          => 'text',
                'default'       => '6',
                'toggle_slug'   => 'settings',
                'show_if'       => array(
                    'load_more' => 'on'
                ),
                'show_if_not'   => array(
                    'filter_nav' => 'on'
                )
            ),
            'image_count'    => array(
                'label'         => esc_html__('Load More Image Count', 'divi_flash'),
                'type'          => 'text',
                'default'       => '4',
                'toggle_slug'   => 'settings',
                'show_if'       => array(
                    'load_more' => 'on'
                ),
                'show_if_not'   => array(
                    'filter_nav' => 'on'
                )
            ),
            'load_more_text'    => array(
                'label'         => esc_html__('Load More Button Text', 'divi_flash'),
                'type'          => 'text',
                'default'       => 'Load More',
                'toggle_slug'   => 'settings',
                'show_if'       => array(
                    'load_more' => 'on'
                ),
                'show_if_not'   => array(
                    'filter_nav' => 'on'
                )
            ),
	        /** Pagination **/
	        'show_pagination'                      => array(
		        'label'       => esc_html__( 'Show Pagination', 'divi_flash' ),
		        'type'        => 'yes_no_button',
		        'options'     => array(
			        'off' => esc_html__( 'Off', 'divi_flash' ),
			        'on'  => esc_html__( 'On', 'divi_flash' ),
		        ),
		        'default'     => 'off',
		        'toggle_slug' => 'settings',
		        'show_if_not' => array(
			        'filter_nav'      => 'on',
			        'load_more' => 'on'
		        )
	        ),
	        'pagination_img_count' => array(
		        'label'       => esc_html__( 'Pagination Image Count', 'divi_flash' ),
		        'type'        => 'text',
		        'default'     => '6',
		        'toggle_slug' => 'settings',
		        'show_if'     => array(
			        'show_pagination' => 'on'
		        ),
		        'show_if_not' => array(
			        'load_more' => 'on'
		        )
	        ),
	        'use_number_pagination'                => array(
		        'label'       => esc_html__( 'Use Number Pagination', 'divi_flash' ),
		        'type'        => 'yes_no_button',
		        'options'     => array(
			        'off' => esc_html__( 'Off', 'divi_flash' ),
			        'on'  => esc_html__( 'On', 'divi_flash' ),
		        ),
		        'default'     => 'off',
		        'toggle_slug' => 'settings',
		        'tab_slug'    => 'general',
		        'show_if'     => array(
			        'show_pagination' => 'on'
		        )
	        ),
	        'use_icon_only_at_pagination'          => array(
		        'label'       => esc_html__( 'Use Icon Only in Next and Previous Button', 'divi_flash' ),
		        'type'        => 'yes_no_button',
		        'options'     => array(
			        'off' => esc_html__( 'Off', 'divi_flash' ),
			        'on'  => esc_html__( 'On', 'divi_flash' ),
		        ),
		        'default'     => 'off',
		        'toggle_slug' => 'settings',
		        'tab_slug'    => 'general',
		        'show_if'     => array(
			        'show_pagination' => 'on'
		        )
	        ),
	        'older_text'                           => array(
		        'label'       => esc_html__( 'Older Entries Button Text', 'divi_flash' ),
		        'type'        => 'text',
		        'toggle_slug' => 'settings',
		        'default'     => 'Older Entries',
		        'show_if'     => array(
			        'show_pagination'             => 'on',
			        'use_icon_only_at_pagination' => 'off'
		        )
	        ),
	        'newer_text'                           => array(
		        'label'       => esc_html__( 'Next Entries Button Text', 'divi_flash' ),
		        'type'        => 'text',
		        'toggle_slug' => 'settings',
		        'default'     => 'Next Entries',
		        'show_if'     => array(
			        'show_pagination'             => 'on',
			        'use_icon_only_at_pagination' => 'off'
		        )
	        ),
	        /** Pagination **/
            'use_url'    => array(
                'label'         => esc_html__('Use Custom Link', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'settings',
            ),
            'url_target'    => array(
                'label'         => esc_html__('Link Target', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'same_window'               => esc_html__('In The Same Window', 'divi_flash'),
                    'new_window'              => esc_html__('In The New Tab', 'divi_flash')
                ),
                'default'       => 'same_window',
                'toggle_slug'   => 'settings',
                'show_if'       => array(
                    'use_url'   => 'on'
                )
            ),
            'use_lightbox'    => array(
                'label'         => esc_html__('Lightbox', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'settings',
                'show_if_not'   => array(
                    'use_url' => 'on'
                )
            ),
            'use_lightbox_download'    => array(
                'label'         => esc_html__('Lightbox Download Button', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'settings',
                'show_if'       => array(
                    'use_lightbox' => 'on'
                ),
                'show_if_not'   => array(
	                'use_url' => 'on'
                )
            ),
            'use_lightbox_content'    => array(
                'label'         => esc_html__('Lightbox Content', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'settings',
                'show_if'       => array(
                    'use_lightbox' => 'on'
                ),
                'show_if_not'   => array(
                    'use_url' => 'on'
                )
            )
        );
        $hover = array(
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
	        /** --Overlay Icon--  **/
            'field_use_icon'  => array(
	            'label'       => esc_html__( 'Use Icon', 'divi_flash' ),
	            'type'        => 'yes_no_button',
	            'options'     => array(
		            'off' => esc_html__( 'Off', 'divi_flash' ),
		            'on'  => esc_html__( 'On', 'divi_flash' ),
	            ),
	            'default'     => 'off',
	            'toggle_slug' => 'hover',
	            'show_if'     => array(
		            'overlay' => 'on'
	            )
            ),
            'field_font_icon' => array(
	            'label'           => esc_html__( 'Icon', 'divi_flash' ),
	            'type'            => 'select_icon',
	            'option_category' => 'basic_option',
	            'class'           => array( 'et-pb-font-icon' ),
	            'default'         => '5',
	            'toggle_slug'     => 'hover',
	            'show_if'         => array(
		            'overlay'        => 'on',
		            'field_use_icon' => 'on'
	            )
            ),
            'field_icon_color'      => array(
	            'label'           => esc_html__( 'Icon Color', 'divi_flash' ),
	            'type'            => 'color-alpha',
	            'description'     => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
	            'depends_show_if' => 'on',
	            'toggle_slug'     => 'hover',
	            'hover'           => 'tabs',
	            'show_if'         => array(
		            'overlay'  => 'on',
		            'field_use_icon' => 'on'
	            )
            ),
            'field_icon_size'       => array(
	            'label'           => esc_html__( 'Icon Size', 'divi_flash' ),
	            'type'            => 'range',
	            'option_category' => 'font_option',
	            'toggle_slug'     => 'hover',
	            'default'         => '24px',
	            'default_unit'    => 'px',
	            'range_settings'  => array(
		            'min'  => '1',
		            'max'  => '120',
		            'step' => '1',
	            ),
	            'mobile_options'  => true,
	            'depends_show_if' => 'on',
	            'responsive'      => true,
	            'show_if'         => array(
		            'overlay'  => 'on',
		            'field_use_icon' => 'on'
	            )
            ),
            'field_icon_placement' => array(
	            'label'       => esc_html__( 'Icon Placement', 'divi_flash' ),
	            'type'        => 'select',
	            'options'     => array(
		            'start'  => esc_html__( 'Top', 'divi_flash' ),
		            'center' => esc_html__( 'Center', 'divi_flash' ),
		            'end'    => esc_html__( 'Bottom', 'divi_flash' ),
	            ),
	            'default'     => 'center',
	            'tab_slug'    => 'general',
	            'toggle_slug' => 'hover',
	            'description' => esc_html__( 'You can control the placement of the hover overlay icon', 'divi_flash' ),
	            'show_if'     => array(
		            'overlay'  => 'on',
		            'field_use_icon' => 'on'
	            ),
            ),
            'field_icon_alignment' => array(
	            'label'           => esc_html__( 'Icon Alignment', 'divi_flash' ),
	            'type'            => 'multiple_buttons',
	            'options'         => array(
		            'start'  => array(
			            'title' => esc_html__( 'Left', 'divi_flash' ),
			            'icon'  => 'align-left', // Any svg icon that is defined on ETBuilderIcon component
		            ),
		            'center' => array(
			            'title' => esc_html__( 'Center', 'divi_flash' ),
			            'icon'  => 'align-center', // Any svg icon that is defined on ETBuilderIcon component
		            ),
		            'end'    => array(
			            'title' => esc_html__( 'Right', 'divi_flash' ),
			            'icon'  => 'align-right', // Any svg icon that is defined on ETBuilderIcon component
		            ),
	            ),
	            'default'         => 'center',
	            'toggleable'      => true,
	            'multi_selection' => false,
	            'tab_slug'        => 'general',
	            'toggle_slug'     => 'hover',
	            'description'     => esc_html__( 'You can control the hover overlay icon alignment', 'divi_flash' ),
	            'show_if'         => array(
		            'overlay'  => 'on',
		            'field_use_icon' => 'on'
	            ),
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
	            'show_if' => array(
		            'overlay'  => 'on',
		            'field_use_icon' => 'on'
	            )
            ),
	        /** --Overlay Icon--  **/
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

            'show_caption'    => array(
	            'label'         => esc_html__('Show Caption', 'divi_flash'),
	            'type'          => 'yes_no_button',
	            'options'       => array (
		            'off' => esc_html__( 'Off', 'divi_flash' ),
		            'on'  => esc_html__( 'On', 'divi_flash' ),
	            ),
	            'default'       => 'off',
	            'toggle_slug'   => 'hover',
            ),
            'always_show_title'  => array(
	            'label'         => esc_html__('Always Show Caption', 'divi_flash'),
	            'type'          => 'yes_no_button',
	            'options'       => array (
		            'off' => esc_html__( 'Off', 'divi_flash' ),
		            'on'  => esc_html__( 'On', 'divi_flash' ),
	            ),
	            'default'       => 'off',
	            'toggle_slug'   => 'hover',
	            'show_if' => array(
		            'show_caption'            => 'on',
		            'enable_content_position' => 'off'
	            )
            ),
            'content_reveal_caption'    => array(
	            'label'    => esc_html__('Caption Reveal', 'divi_flash'),
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
	            ),
	            'show_if' => array(
		            'show_caption'            => 'on',
		            'enable_content_position' => 'off'
	            )
            ),
            'show_description'    => array(
	            'label'         => esc_html__('Show Description', 'divi_flash'),
	            'type'          => 'yes_no_button',
	            'options'       => array (
		            'off' => esc_html__( 'Off', 'divi_flash' ),
		            'on'  => esc_html__( 'On', 'divi_flash' ),
	            ),
	            'default'       => 'off',
	            'toggle_slug'   => 'hover',
            ),
            'always_show_description'  => array(
	            'label'         => esc_html__('Always Show Description', 'divi_flash'),
	            'type'          => 'yes_no_button',
	            'options'       => array (
		            'off' => esc_html__( 'Off', 'divi_flash' ),
		            'on'  => esc_html__( 'On', 'divi_flash' ),
	            ),
	            'default'       => 'off',
	            'toggle_slug'   => 'hover',
	            'show_if' => array(
		            'show_description' => 'on',
		            'enable_content_position'=>'off'
	            )
            ),
            'content_reveal_description'    => array(
	            'label'    => esc_html__('Description Reveal', 'divi_flash'),
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
		            'c4-rotate-down-left'     => esc_html__('Rotate Down Left', 'divi_flash'),
	            ),
	            'default'       => 'c4-fade-up',
	            'toggle_slug'   => 'hover',
	            'show_if_not'   => array(
		            'always_show_description'  => 'on'
	            ),
	            'show_if' => array(
		            'show_description'        => 'on',
		            'enable_content_position' => 'off'
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
            'enable_content_position'    => array(
	            'label'         => esc_html__('Content Outside', 'divi_flash'),
	            'type'          => 'yes_no_button',
	            'options'       => array (
		            'off' => esc_html__( 'Off', 'divi_flash' ),
		            'on'  => esc_html__( 'On', 'divi_flash' ),
	            ),
	            'default'       => 'off',
	            'toggle_slug'   => 'hover',
            ),
            'content_position_outside' => array(
	            'label'       => esc_html__( 'Content Position', 'divi_flash' ),
	            'type'        => 'select',
	            'options'     => array(
		            'options'     => array(
			            'c4-layout-top-left'      => esc_html__( 'Top Left', 'divi_flash' ),
			            'c4-layout-top-center'    => esc_html__( 'Top Center', 'divi_flash' ),
			            'c4-layout-top-right'     => esc_html__( 'Top Right', 'divi_flash' ),
			            'c4-layout-bottom-left'   => esc_html__( 'Bottom Left', 'divi_flash' ),
			            'c4-layout-bottom-center' => esc_html__( 'Bottom Center', 'divi_flash' ),
			            'c4-layout-bottom-right'  => esc_html__( 'Bottom Right', 'divi_flash' )
		            ),
	            ),
	            'default'     => 'c4-layout-bottom-left',
	            'toggle_slug' => 'hover',
	            'show_if'     => array(
		            'enable_content_position' => 'on'
	            )
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
                'toggle_slug'   => 'hover',
                'show_if'     => array(
	                'enable_content_position' => 'off'
                )
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
            )
        );
        $alignment = array(
            'fliter_align' => array(
                'label'             => esc_html__( 'Alignment', 'divi_flash' ),
				'type'              => 'text_align',
				'options'           => et_builder_get_text_orientation_options(array('justified')),
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'filter_btn'
            ),
            'more_btn_align' => array(
                'label'             => esc_html__( 'Alignment', 'divi_flash' ),
				'type'              => 'text_align',
				'options'           => et_builder_get_text_orientation_options(array('justified')),
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'more_btn'
            )
        );
        $button = array(
            'spinner_color' => array(
                'label'             => esc_html__( 'Loading Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'more_btn',
                'default'           => '#2665e0'
            )
        );
        $tag = array(
            'caption_tag' => array (
                'default'         => 'h4',
                'label'           => esc_html__( 'Caption Tag', 'divi_flash' ),
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
                'toggle_slug'     => 'font_styles',
                'tab_slug'        => 'advanced',
                'sub_toggle'      => 'caption'
            ),
            'description_tag' => array (
                'default'         => 'p',
                'label'           => esc_html__( 'Description Tag', 'divi_flash' ),
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
                'toggle_slug'     => 'font_styles',
                'tab_slug'        => 'advanced',
                'sub_toggle'      => 'description'
            )
        );
        $filter_nav_bg = $this->df_add_bg_field(array(
            'label'				=> 'Background',
            'key'               => 'filter_nav_bg',
            'toggle_slug'       => 'filter_btn',
            'tab_slug'			=> 'advanced',
            'hover'				=> 'tabs',
            'image'             => false
        ));
        $active_filter_bg = $this->df_add_bg_field(array(
            'label'				=> 'Background',
            'key'               => 'active_filter_bg',
            'toggle_slug'       => 'filter_btn_active',
            'tab_slug'			=> 'advanced',
            'hover'				=> 'tabs',
            'image'             => false
        ));
        $more_btn_bg = $this->df_add_bg_field(array(
            'label'				=> 'Background',
            'key'               => 'more_btn_bg',
            'toggle_slug'       => 'more_btn',
            'tab_slug'			=> 'advanced',
            'hover'				=> 'tabs',
            'image'             => false
        ));
        $title = $this->add_margin_padding(array(
            'title'         => 'Caption',
            'key'           => 'title',
            'toggle_slug'   => 'margin_padding',
            'option'        => 'padding'
        ));
        $description = $this->add_margin_padding(array(
            'title'         => 'Description',
            'key'           => 'description',
            'toggle_slug'   => 'margin_padding',
            'option'        => 'padding'
        ));
        $filter_button_container = $this->add_margin_padding(array(
            'title'         => 'Filter Button Container',
            'key'           => 'filter_button_container',
            'toggle_slug'   => 'margin_padding'
        ));
        $filter_button = $this->add_margin_padding(array(
            'title'         => 'Filter Button',
            'key'           => 'filter_button',
            'default_margin'  => '0px|10px|10px|0px',
            'toggle_slug'   => 'margin_padding'
        ));
        $load_more_button = $this->add_margin_padding(array(
            'title'         => 'Load More',
            'key'           => 'load_more',
            'toggle_slug'   => 'margin_padding'
        ));
        $use_load_more_icon = array(
            'more_btn_use_icon' => array(
				'label'                 => esc_html__( 'Use Icon', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => 'more_btn',
                'tab_slug'              => 'advanced',
				'affects'               => array (
                    'more_btn_font_icon',
                    'more_btn_icon_size'
				)
            ),
            'more_btn_font_icon' => array(
                'label'                 => esc_html__( 'Icon', 'divi_flash' ),
                'type'                  => 'select_icon',
                'option_category'       => 'basic_option',
                'class'                 => array( 'et-pb-font-icon' ),
                'toggle_slug'           => 'more_btn',
                'tab_slug'              => 'advanced',
                'depends_show_if'       => 'on'
            ),
            'more_btn_icon_size' => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'toggle_slug'       => 'more_btn',
                'tab_slug'          => 'advanced',
				'default'           => '22px',
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
			)
		);
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
		$pagination_spacing = $this->add_margin_padding(array(
			'title'         => 'Pagination Next & Previous Button',
			'key'           => 'pagination',
			'toggle_slug'   => 'margin_padding'
		));
		$pagination_number_spacing = $this->add_margin_padding(array(
			'title'         => 'Pagination Number',
			'key'           => 'pagination_number',
			'toggle_slug'   => 'margin_padding'
		));

        return array_merge(
            $general,
            $hover,
            $tag,
            $alignment,
            $button,
            $filter_nav_bg,
            $active_filter_bg,
            $more_btn_bg,
            $title,
            $description,
            $filter_button_container,
            $filter_button,
            $load_more_button,
            $use_load_more_icon,
	        $pagination,
	        $pagination_background,
	        $active_pagination_background,
	        $pagination_spacing,
	        $pagination_number_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'filter_nav_bg',
            'selector'      => '%%order_class%% .df_filter_buttons button'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'more_btn_bg',
            'selector'      => '%%order_class%% .ig-load-more-btn'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'active_filter_bg',
            'selector'      => '%%order_class%% .df_filter_buttons button.is-checked'
        ));

        $fields['title_padding'] = array ('padding' => '%%order_class%% .df_ig_caption');
        $fields['description_padding'] = array ('padding' => '%%order_class%% .df_ig_description');
        $fields['filter_button_container_margin'] = array ('margin' => '%%order_class%% .df_filter_buttons');
        $fields['filter_button_container_padding'] = array ('padding' => '%%order_class%% .df_filter_buttons');
        $fields['filter_button_margin'] = array ('margin' => '%%order_class%% .df_filter_buttons button');
        $fields['filter_button_padding'] = array ('padding' => '%%order_class%% .df_filter_buttons button');
        $fields['load_more_margin'] = array ('margin' => '%%order_class%% .ig-load-more-btn');
        $fields['load_more_padding'] = array ('padding' => '%%order_class%% .ig-load-more-btn');

        // border fix
        $fields = $this->df_fix_border_transition(
            $fields, 
            'filter_container', 
            '%%order_class%% .df_filter_buttons'
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'image', 
            '%%order_class%% .df_ig_image figure'
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'filter_btn', 
            '%%order_class%% .df_filter_buttons button'
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'active_filter_btn', 
            '%%order_class%% .df_filter_buttons button.is-checked'
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'morebtn_border', 
            '%%order_class%% .ig-load-more-btn'
        );
	    /** --Overlay Icon-- **/
	    $fields['field_icon_color'] = array('color' => '%%order_class%% .df-overlay .et-pb-icon');
	    /** --Overlay Icon-- **/

	    /** Pagination **/
	    $pagination = '%%order_class%% .pagination .page-numbers';
	    $fields['pagination_margin'] = array ('margin' => $pagination);
	    $fields['pagination_padding'] = array ('padding' => $pagination);

	    $fields['pagination_number_margin'] = array ('margin' => $pagination);
	    $fields['pagination_number_margin'] = array ('padding' => $pagination);
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
	    $fields = $this->df_fix_border_transition(
		    $fields,
		    'pagination',
		    $pagination
	    );
	    $fields = $this->df_fix_box_shadow_transition(
		    $fields,
		    'pagination',
		    $pagination
	    );
	    /** Pagination **/

        return $fields;
    }
    
    public function additional_css_styles($render_slug) {

        if (isset($this->props['image_to_display'])) {
	        $image_width = 0 !== (int)$this->props['image_to_display'] ? 100/(int)$this->props['image_to_display'] . '%' : '100%';
	        $image_width_tablet = isset($this->props['image_to_display_tablet']) && $this->props['image_to_display_tablet'] !== '' && 0 !== (int)$this->props['image_to_display_tablet'] ?
		        100/$this->props['image_to_display_tablet'] . '%' : $image_width;
	        $image_width_phone = isset($this->props['image_to_display_phone']) && $this->props['image_to_display_phone'] !== '' && 0 !== (int)$this->props['image_to_display_phone'] ?
		        100/$this->props['image_to_display_phone'] . '%' : $image_width_tablet;

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .grid-sizer, %%order_class%% .grid-item',
                'declaration' => sprintf('width: %1$s;', $image_width)
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .grid-sizer, %%order_class%% .grid-item',
                'declaration' => sprintf('width: %1$s;', $image_width_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .grid-sizer, %%order_class%% .grid-item',
                'declaration' => sprintf('width: %1$s;', $image_width_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
        if (isset($this->props['item_gutter'])) {
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'item_gutter',
                'type'              => 'padding-left',
                'selector'          => '%%order_class%% .grid .grid-item'
            ) );
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'item_gutter',
                'type'              => 'padding-bottom',
                'selector'          => '%%order_class%% .grid .grid-item'
            ) );
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'item_gutter',
                'type'              => 'margin-left',
                'selector'          => '%%order_class%% .grid',
                'negative'          => true
            ) );
        }
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
        if (isset($this->props['fliter_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_filter_buttons',
                'declaration' => sprintf('text-align: %1$s;', $this->props['fliter_align'])
            ));
        }
        if (isset($this->props['more_btn_align'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_ig_button_container',
                'declaration' => sprintf('text-align: %1$s;', $this->props['more_btn_align'])
            ));
        }
        if('on' !== $this->props['overlay']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .c4-izmir',
                'declaration' => '--image-opacity: 1;'
            ));
        }
        if('on' === $this->props['overlay']) {
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
        if('on' === $this->props['border_anim']) {
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

        // loading icon color
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'spinner_color',
            'type'              => 'fill',
            'selector'          => '%%order_class%% .ig-load-more-btn .spinner svg'
        ));
        // loading font-size
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'more_btn_icon_size',
            'type'              => 'font-size',
            'selector'          => '%%order_class%% .df-ig-load-more-icon'
        ) );

        // background: filter button
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'filter_nav_bg',
            'selector'          => '%%order_class%% .df_filter_buttons button',
            'hover'             => '%%order_class%% .df_filter_buttons button:hover'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'more_btn_bg',
            'selector'          => '%%order_class%% .ig-load-more-btn',
            'hover'             => '%%order_class%% .ig-load-more-btn:hover'
        ));
        // active background: filter button
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'active_filter_bg',
            'selector'          => '%%order_class%% .df_filter_buttons button.is-checked',
            'hover'             => '%%order_class%% .df_filter_buttons button.is-checked:hover'
        ));
        // spacing: title
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ig_caption',
            'hover'             => '%%order_class%% .item-content:hover .df_ig_caption',
        ));
        // spacing: description
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'description_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_ig_description',
            'hover'             => '%%order_class%% .item-content:hover .df_ig_description',
        ));
        // spacing: filter button container
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'filter_button_container_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_filter_buttons',
            'hover'             => '%%order_class%% .df_filter_buttons:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'filter_button_container_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_filter_buttons',
            'hover'             => '%%order_class%% .df_filter_buttons:hover',
        ));
        // spacing: filter button
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'filter_button_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_filter_buttons button',
            'hover'             => '%%order_class%% .df_filter_buttons button:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'filter_button_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_filter_buttons button',
            'hover'             => '%%order_class%% .df_filter_buttons button:hover',
        ));
        // spacing: load more
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'load_more_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .ig-load-more-btn',
            'hover'             => '%%order_class%% .ig-load-more-btn:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'load_more_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .ig-load-more-btn',
            'hover'             => '%%order_class%% .ig-load-more-btn:hover',
        ));
        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'more_btn_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .df-ig-load-more-icon',
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
			        'base_attr_name' => 'field_font_icon',
			        'important'      => true,
			        'selector'       => '%%order_class%% .df-overlay .et-pb-icon',
			        'processor'      => array(
				        'ET_Builder_Module_Helper_Style_Processor',
				        'process_extended_icon',
			        ),
		        )
	        );
        }
	    if('on' === $this->props['field_use_icon']){
		    $this->df_process_color(array(
			    'render_slug'       => $render_slug,
			    'slug'              => 'field_icon_color',
			    'type'              => 'color',
			    'selector'          => '%%order_class%% .df-overlay .et-pb-icon',
			    'hover'             => ''
		    ));
		    $this->df_process_range( array(
			    'render_slug'       => $render_slug,
			    'slug'              => 'field_icon_size',
			    'type'              => 'font-size',
			    'selector'          => '%%order_class%% .df-overlay .et-pb-icon'
		    ) );
		    $icon_placement = isset($this->props['field_icon_placement']) ? $this->props['field_icon_placement'] : 'center';
		    $icon_alignment = isset($this->props['field_icon_alignment']) ? $this->props['field_icon_alignment'] : 'center';
		    ET_Builder_Element::set_style($render_slug, array(
			    'selector' => '%%order_class%% .df-overlay',
			    'declaration' => sprintf('display: flex;align-items:%1$s;justify-content:%2$s;', $icon_placement,$icon_alignment )
		    ));
	    }

	    /** Pagination **/
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'pagination_margin',
		    'type'              => 'margin',
		    'selector'          => '%%order_class%% .pagination .page-numbers.prev, %%order_class%% .pagination .page-numbers.next',
		    'hover'             => '%%order_class%% .pagination .page-numbers.prev:hover, %%order_class%% .pagination .page-numbers.next:hover',
	    ));
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'pagination_padding',
		    'type'              => 'padding',
		    'selector'          => '%%order_class%% .pagination .page-numbers.prev, %%order_class%% .pagination .page-numbers.next',
		    'hover'             => '%%order_class%% .pagination .page-numbers.prev:hover, %%order_class%% .pagination .page-numbers.next:hover',
	    ));
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'pagination_number_margin',
		    'type'              => 'margin',
		    'selector'          => '%%order_class%% .pagination .page-numbers:not(.prev):not(.next)',
		    'hover'             => '%%order_class%% .pagination .page-numbers:not(.prev):not(.next):hover',
	    ));
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'pagination_number_padding',
		    'type'              => 'padding',
		    'selector'          => '%%order_class%% .pagination .page-numbers:not(.prev):not(.next)',
		    'hover'             => '%%order_class%% .pagination .page-numbers:not(.prev):not(.next):hover',
	    ));
	    $this->df_process_bg(array (
		    'render_slug'       => $render_slug,
		    'slug'              => "pagination_background",
		    'selector'          => '%%order_class%% .pagination .page-numbers:not(.dots)',
		    'hover'             => '%%order_class%% .pagination .page-numbers:not(.dots):hover'
	    ));
	    $this->df_process_bg(array (
		    'render_slug'       => $render_slug,
		    'slug'              => "active_pagination_background",
		    'selector'          => '%%order_class%% .pagination .page-numbers.current',
		    'hover'             => '%%order_class%% .pagination .page-numbers.current:hover',
		    'important'         => true
	    ));
	    $this->df_process_string_attr(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'pagination_align',
		    'type'              => 'justify-content',
		    'selector'          => '%%order_class%% .pagination',
		    'important'         => false,
		    'default'           => 'center'
	    ));
	    // arrow icon
	    $next_prev_icon = $this->props['next_prev_icon'];
	    ET_Builder_Element::set_style($render_slug, array(
		    'selector' => '%%order_class%% .pagination .older::before, %%order_class%% .pagination .prev::before',
		    'declaration' => sprintf('content: "%1$s";', $this->ig_arrow_icon($next_prev_icon, 'prev')),
	    ));
	    ET_Builder_Element::set_style($render_slug, array(
		    'selector' => '%%order_class%% .pagination .newer::after, %%order_class%% .pagination .next::after',
		    'declaration' => sprintf('content: "%1$s";', $this->ig_arrow_icon($next_prev_icon, 'next')),
	    ));
	    /** Pagination **/
    }

    public function render( $attrs, $content, $render_slug ) {
        $this->handle_fa_icon();
        $this->additional_css_styles($render_slug);
        wp_enqueue_script('imageload');
        wp_enqueue_script('lightgallery-script');
        wp_enqueue_script('df-imagegallery-lib');
        wp_enqueue_script('df-imagegallery');
        
        $content = $this->content;
        $load_more = $this->props['load_more'];
        $filter_nav = $this->props['filter_nav'];
        $more_btn_use_icon = $this->props['more_btn_use_icon'];
	    $show_pagination = $this->props['show_pagination'];

        $_string = '[' .substr(trim(wp_strip_all_tags($content)), 0, -1) .']';
        $_objects = json_decode($_string);
        $filter_nav_markup = '';
        $filter_nav_buttons = '';
        $filter_nav_status = true;
        $image_ids = '';
        $images_array = [];
		if('on' === $this->props['df_gallery_enable_category']){
			if(!isset($this->props['category_ids'])) return ;
			$tex_ids = $this->props['category_ids'];
			$tex_ids = explode(',', substr($tex_ids, 5, -2));
			foreach ($tex_ids as $index => $value){
				$term_id = (int)str_replace('"', '',$value);
				$term_name = get_term_by('id', $term_id, DiviFlash_Media_Category::TAXONOMY);
				$title = $term_name ? $term_name->name : "";
				$category = strtolower(preg_replace('/[^A-Za-z0-9-]/', "-", $title));
				$args = [
					'post_type' => 'attachment',
					'post_status' => 'inherit',
					'posts_per_page' => -1,
					'tax_query' => [
						[
							'taxonomy' => DiviFlash_Media_Category::TAXONOMY,
							'field'    => 'term_id',
							'terms'    => $term_id,
						],
					],
				];
				$attachments = get_posts($args);
				if (!empty($attachments)) {

					$filter_nav_buttons .= sprintf('<button class="button %3$s" data-filter=".%1$s" onclick="igHandleClick(event)"> %2$s</button>', esc_attr($category), $title, ("on" === $this->props['disable_filter_nav_all_button'] && $filter_nav_status) ? "is-checked" : "");
					if("on" === $this->props['disable_filter_nav_all_button'] && $filter_nav_status){
						$filter_nav_status = false;
					}
					foreach ($attachments as $attachment) {
						$images_array[$attachment->ID][] = $category;
					}
				}
			}


		}else{
			foreach($_objects as $_object) {
				$title = isset($_object->gallery_title) && $_object->gallery_title !== '' ?
					$_object->gallery_title : '';
				$category = isset($_object->gallery_title) && $_object->gallery_title !== '' ?
					strtolower(preg_replace('/[^A-Za-z0-9-]/', "-", $_object->gallery_title)) : '';

				$ids = explode( ',', $_object->gallery_ids);

				$filter_nav_buttons .= sprintf('<button class="button %3$s" data-filter=".%1$s" onclick="igHandleClick(event)">
                %2$s</button>', esc_attr($category), $title,("on" === $this->props['disable_filter_nav_all_button'] && $filter_nav_status) ? "is-checked" : "");
				if("on" === $this->props['disable_filter_nav_all_button'] && $filter_nav_status){
					$filter_nav_status = false;
				}
				foreach($ids as $id) {
					$images_array[$id][] = $category;
				}
			}
		}

        // image order
        if('on' === $this->props['use_image_order']) {
            if('' === $this->props['image_order'] || 'random' === $this->props['image_order']) {
                $images_array = df_shuffle_assoc($images_array);
            } else if('asc' === $this->props['image_order']) {
                ksort($images_array);
            } else if('desc' === $this->props['image_order']) {
                krsort($images_array);
            }
        }

        if(!empty($images_array)) {
            $image_ids = implode(", " , array_keys($images_array));
        }
        
        $options = df_ig_options(
            array('images_array' => $images_array),
            $this->props
        );

        $images = df_ig_render_images($options);

        // filter nav HLML
        if('on' === $filter_nav && !empty($filter_nav_buttons)) {
			$first_btn = ('on' !== $this->props['disable_filter_nav_all_button']) ? sprintf('<button class="button is-checked" data-filter="*" onclick="igHandleClick(event)">%1$s</button>',"" !== $this->props['filter_nav_all_button']?esc_html( $this->props['filter_nav_all_button'] ):"All"):"";
            $filter_nav_markup = sprintf('<div class="df_filter_buttons">%2$s%1$s</div>', $filter_nav_buttons, $first_btn);
        }
        $load_more_icon = $more_btn_use_icon === 'on' ? sprintf('<span class="df-ig-load-more-icon">%1$s</span>',
            $this->props['more_btn_font_icon'] !== '' ? esc_attr(et_pb_process_font_icon( $this->props['more_btn_font_icon'] )) : '4'
        ) : '';

        $load_more_icon_class = 'on' === $more_btn_use_icon ? ' has_icon' : '';
 
        $load_more_button = $load_more === 'on' ?
            sprintf('<div class="df_ig_button_container">
                    <button class="ig-load-more-btn%4$s" data-loaded="%2$s">%1$s %3$s
                    <span class="spinner">
                        <svg width="135" height="140" viewBox="0 0 135 140" xmlns="http://www.w3.org/2000/svg" fill="#fff">
                            <rect y="10" width="15" height="120" rx="6">
                                <animate attributeName="height"
                                    begin="0.5s" dur="1s"
                                    values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                    repeatCount="indefinite" />
                                <animate attributeName="y"
                                    begin="0.5s" dur="1s"
                                    values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                    repeatCount="indefinite" />
                            </rect>
                            <rect x="30" y="10" width="15" height="120" rx="6">
                                <animate attributeName="height"
                                    begin="0.25s" dur="1s"
                                    values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                    repeatCount="indefinite" />
                                <animate attributeName="y"
                                    begin="0.25s" dur="1s"
                                    values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                    repeatCount="indefinite" />
                            </rect>
                            <rect x="60" width="15" height="140" rx="6">
                                <animate attributeName="height"
                                    begin="0s" dur="1s"
                                    values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                    repeatCount="indefinite" />
                                <animate attributeName="y"
                                    begin="0s" dur="1s"
                                    values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                    repeatCount="indefinite" />
                            </rect>
                            <rect x="90" y="10" width="15" height="120" rx="6">
                                <animate attributeName="height"
                                    begin="0.25s" dur="1s"
                                    values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                    repeatCount="indefinite" />
                                <animate attributeName="y"
                                    begin="0.25s" dur="1s"
                                    values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                    repeatCount="indefinite" />
                            </rect>
                            <rect x="120" y="10" width="15" height="120" rx="6">
                                <animate attributeName="height"
                                    begin="0.5s" dur="1s"
                                    values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                    repeatCount="indefinite" />
                                <animate attributeName="y"
                                    begin="0.5s" dur="1s"
                                    values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                    repeatCount="indefinite" />
                            </rect>
                        </svg>
                    </span></button>
                </div>', 
                sanitize_text_field($this->props['load_more_text']),
                sanitize_text_field($this->props['init_count']),
                $load_more_icon,
                esc_attr($load_more_icon_class)
            ) : '';

	    $older = $this->props['older_text'] ? $this->props['older_text'] : 'Older Entries';
	    $next = $this->props['newer_text'] ? $this->props['newer_text'] : 'Next Entries';
	    if('on' === $this->props['use_icon_only_at_pagination']){
		    $older = '';
		    $next = '';
	    }
	    $pagination_data = '';
	    if('on' === $show_pagination && count(explode(',',$image_ids)) > (int)$this->props['pagination_img_count']){
		    ob_start();
		    ?>
		    <div class="df-ig-pagination pagination clearfix <?php echo 'on' === $this->props['use_icon_only_at_pagination'] ? 'only_icon':''; ?>">
			    <a class="prev page-numbers" data-current="1" data-count="<?php echo esc_html($this->props['pagination_img_count']); ?>" href="#" style="display: none;"><?php echo esc_html($older); ?></a>
			    <?php
			    if('on' === $this->props['use_number_pagination']){
				    for ($i = 0; $i < ceil(count($images_array)/(int)$this->props['pagination_img_count']); $i++){
					    ?>
					    <a class="page-numbers <?php echo 0 === $i ? 'current' : ''; ?>" data-page="<?php echo esc_html(($i+1)); ?>" data-count="<?php echo esc_html($this->props['pagination_img_count']); ?>" href="#"><?php echo esc_html(($i+1)); ?></a>
					    <?php
				    }
			    }
			    ?>
			    <a class="next page-numbers" data-current="1" data-count="<?php echo esc_html($this->props['pagination_img_count']); ?>" href="#"><?php echo esc_html($next); ?></a>
		    </div>
		    <?php
		    $pagination_data = ob_get_clean();
	    }

        $data = df_ig_options(
            array('image_ids' => $image_ids),
            $this->props
        );

        // filter for images
		if (array_key_exists('image', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['image'])) {
			$this->add_classname($this->generate_css_filters(
				$render_slug,
				'child_',
				self::$data_utils->array_get($this->advanced_fields['image']['css'], 'main', '%%order_class%%')
			));
		}
        
        return sprintf('<div class="df_ig_container%5$s" data-settings=\'%4$s\'>
                %2$s
                <div class="df_ig_gallery grid" style="opacity:0;">
                    %1$s
                </div>
                %3$s
                %6$s
            </div>', 
            $images, 
            $filter_nav_markup,
	        strlen($images) > 0 ?$load_more_button:"",
            wp_json_encode($data),
	        'on' === $this->props['use_lightbox'] ? ' ig_has_lightbox' : '',
	        $pagination_data
        );
    }
	public function ig_arrow_icon( $set = 'set_1', $type = 'next') {
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
}
new DIFL_ImageGallery;

