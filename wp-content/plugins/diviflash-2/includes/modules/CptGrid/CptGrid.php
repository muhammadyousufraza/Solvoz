<?php
class DIFL_CptGrid extends ET_Builder_Module_Type_PostBased {
    public $slug       = 'difl_cptgrid';
    public $vb_support = 'on';
    public $child_slug = 'difl_cptitem';
	public $icon_path;
    use DF_UTLS;
    use Df_Cpt_Taxonomy_Support;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'CPT Grid', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/cpt-grid.svg';
        $this->init_cpt_tax(
            'general', 
            'settings', 
            array(
                'post_display'  => 'by_tax'
            )
        );
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'settings'              => esc_html__('CPT Settings', 'divi_flash'),
                    'item_background'       => esc_html__('Item Background', 'divi_flash'),
                    'loader'                => esc_html__('Loader', 'divi_flash')
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
                    'main'        => "%%order_class%% .pagination .page-numbers",
                    'hover'        => "%%order_class%% .pagination .page-numbers:hover"
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
                        'border_radii' => '%%order_class%% .df-cpt-outer-wrap',
                        'border_radii_hover' => '%%order_class%% .df-cpt-outer-wrap:hover',
                        'border_styles' => '%%order_class%% .df-cpt-outer-wrap',
                        'border_styles_hover' => '%%order_class%% .df-cpt-outer-wrap:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_outer_wrapper',
                'label_prefix'      => 'Item'
            ),
            'item'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-cpt-inner-wrap',
                        'border_radii_hover' => '%%order_class%% .df-cpt-inner-wrap:hover',
                        'border_styles' => '%%order_class%% .df-cpt-inner-wrap',
                        'border_styles_hover' => '%%order_class%% .df-cpt-inner-wrap:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_inner_wrapper',
                'label_prefix'      => 'Item'
            ),
            'pagination'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .pagination .page-numbers:not(.dots)',
                        'border_radii_hover' => '%%order_class%% .pagination .page-numbers:not(.dots):hover',
                        'border_styles' => '%%order_class%% .pagination .page-numbers:not(.dots)',
                        'border_styles_hover' => '%%order_class%% .pagination .page-numbers:not(.dots):hover',
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
                    'main' => "%%order_class%% .df-cpt-outer-wrap",
                    'hover' => "%%order_class%% .df-cpt-outer-wrap:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_outer_wrapper'
            ),
            'item'      => array(
                'css' => array(
                    'main' => "%%order_class%% .df-cpt-inner-wrap",
                    'hover' => "%%order_class%% .df-cpt-inner-wrap:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_inner_wrapper'
            ),
            'pagination'      => array(
                'css' => array(
                    'main' => "%%order_class%% .pagination .page-numbers:not(.dots)",
                    'hover' => "%%order_class%% .pagination .page-numbers:not(.dots):hover",
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
        $post_type = array(
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
            'post_type_arch'    => array(
                'label'            => esc_html__( 'Select the Post Type to View on Builder', 'et_builder' ),
                'type'             => 'select',
                'option_category'  => 'configuration',
                'options'          => $this->df_post_types,
                'toggle_slug'      => 'settings',
                'default'          => 'select',
                'show_if'          => array(
                    'use_current_loop' => 'on',
                    'function.isTBLayout' => 'on',
                ),
            ),
            'post_type'                     => array(
                'label'            => esc_html__( 'Post Type', 'et_builder' ),
                'type'             => 'select',
                'option_category'  => 'configuration',
                'options'          => $this->df_post_types,
                'description'      => esc_html__( 'Choose posts of which post type you would like to display.', 'et_builder' ),
                'toggle_slug'      => 'settings',
                'default'          => 'select',
                'show_if'          => array(
                    'use_current_loop' => 'off',
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
                    'recent'        => esc_html__('Default', 'divi_flash'),
                    'by_tax'        => esc_html__('By Taxonomy', 'divi_flash')
                ),
                'default'           => 'recent',
                'toggle_slug'       => 'settings',
                'show_if_not'       => array(
					'use_current_loop' => 'on'
				)
            )
        );
        
        $post_type = array_merge($post_type, $this->tax_settings, $this->term_settings);

        $settings = array (
            'orderby' => array(
				'label'             => esc_html__( 'Order By', 'divi_flash' ),
				'type'              => 'select',
				'options'           => array(
					'1' => esc_html__( 'Newest to oldest', 'divi_flash' ),
					'2' => esc_html__( 'Oldest to newest', 'divi_flash' ),
                    '3' => esc_html__( 'A to Z', 'divi_flash' ),
					'4' => esc_html__( 'Z to A', 'divi_flash' ),
					'5' => esc_html__( 'Random', 'divi_flash' ),
                    '6' => esc_html__( 'Menu Order: ASC', 'divi_flash' ),
					'7' => esc_html__( 'Menu Order: DESC', 'divi_flash' ),
				),
				'default'			=> '1',
				'toggle_slug'       => 'settings',
				'show_if_not'         => array(
					//'post_display' => array('by_tax'),
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
            'on_scroll_load'             => array(
	            'label'       => esc_html__( 'On Scroll Load', 'divi_flash' ),
	            'type'        => 'yes_no_button',
	            'options'     => array(
		            'off' => esc_html__( 'Off', 'divi_flash' ),
		            'on'  => esc_html__( 'On', 'divi_flash' ),
	            ),
	            'default'     => 'off',
	            'toggle_slug' => 'settings',
	            'show_if' => array(
		            'show_pagination' => 'off'
	            )
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
            'use_icon_only_at_pagination'    => array(
                'label'             => esc_html__('Use Icon Only in Next and Previous Button', 'divi_flash'),
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
                    'show_pagination'   => 'on',
                    'use_icon_only_at_pagination' => 'off'
                )       
            ),
            'newer_text'                  => array(
				'label'            => esc_html__( 'Next Entries Button Text', 'divi_flash' ),
				'type'             => 'text',
				'toggle_slug'      => 'settings',
                'default'          => 'Next Entries',
                'show_if'          => array(
                    'show_pagination'   => 'on',
                    'use_icon_only_at_pagination' => 'off'
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
            ),
            'entire_item_clickable'       => array(
	            'label'       => esc_html__( 'Clickable Entire Item', 'divi_flash' ),
	            'type'        => 'yes_no_button',
	            'options'     => array(
		            'off' => esc_html__( 'No', 'divi_flash' ),
		            'on'  => esc_html__( 'Yes', 'divi_flash' ),
	            ),
	            'default'     => 'off',
	            'toggle_slug' => 'settings',
	            'tab_slug'    => 'general'
            ),
        );
	    $loader = array(
		    'enable_loader'    => array(
			    'label'       => esc_html__( 'Enable', 'divi_flash' ),
			    'type'        => 'yes_no_button',
			    'options'     => array(
				    'off' => esc_html__( 'Off', 'divi_flash' ),
				    'on'  => esc_html__( 'On', 'divi_flash' ),
			    ),
			    'default'     => 'off',
			    'toggle_slug' => 'loader',
			    'show_if'     => array(
				    'on_scroll_load'  => 'on',
				    'show_pagination' => 'off'
			    )
		    ),
		    'loader_type'      => array(
			    'label'       => esc_html__( 'Type', 'divi_flash' ),
			    'type'        => 'select',
			    'options' => array(
				    'classic'    => esc_html__( 'Classic', 'divi_flash' ),
				    'dot_1'      => esc_html__( 'Dot 1', 'divi_flash' ),
				    'dot_2'      => esc_html__( 'Dot 2', 'divi_flash' ),
				    'bar_1'      => esc_html__( 'Bar 1', 'divi_flash' ),
				    'bar_2'      => esc_html__( 'Bar 2', 'divi_flash' ),
				    'spinner_1'  => esc_html__( 'Spinner 1', 'divi_flash' ),
				    'spinner_2'  => esc_html__( 'Spinner 2', 'divi_flash' ),
				    'spinner_3'  => esc_html__( 'Spinner 3', 'divi_flash' ),
				    'spinner_4'  => esc_html__( 'Spinner 4', 'divi_flash' ),
				    'spinner_5'  => esc_html__( 'Spinner 5', 'divi_flash' ),
				    'spinner_6'  => esc_html__( 'Spinner 6', 'divi_flash' ),
				    'spinner_7'  => esc_html__( 'Spinner 7', 'divi_flash' ),
				    'spinner_8'  => esc_html__( 'Spinner 8', 'divi_flash' ),
				    'continuous' => esc_html__( 'Continuous', 'divi_flash' ),
				    'flipping_1' => esc_html__( 'Flipping 1', 'divi_flash' ),
				    'flipping_2' => esc_html__( 'Flipping 2', 'divi_flash' ),
				    'blob_1'     => esc_html__( 'Blob', 'divi_flash' ),
			    ),
			    'default'     => 'classic',
			    'toggle_slug' => 'loader',
			    'tab_slug'    => 'general',
			    'show_if'     => array(
				    'on_scroll_load' => 'on',
				    'enable_loader'  => 'on'
			    )
		    ),
		    'loader_color'     => array(
			    'label'       => esc_html__( 'Color', 'divi_flash' ),
			    'type'        => 'color-alpha',
			    'default'     => '#284cc1',
			    'tab_slug'    => 'general',
			    'toggle_slug' => 'loader',
			    'show_if'     => array(
				    'on_scroll_load' => 'on',
				    'enable_loader'  => 'on'
			    ),
		    ),
		    'loader_bg_color'  => array(
			    'label'       => esc_html__( 'Secondary Color', 'divi_flash' ),
			    'type'        => 'color-alpha',
			    'default'     => '#ADD8E6',
			    'tab_slug'    => 'general',
			    'toggle_slug' => 'loader',
			    'show_if'     => array(
				    'on_scroll_load' => 'on',
				    'enable_loader'  => 'on',
				    'loader_type'    => array( 'spinner_1', 'blob_1' )
			    ),
		    ),
		    'loader_size'      => array(
			    'label'          => esc_html__( 'Size', 'divi_flash' ),
			    'type'           => 'range',
			    'toggle_slug'    => 'loader',
			    'tab_slug'       => 'general',
			    'default'        => '10px',
			    'default_unit'   => 'px',
			    'range_settings' => array(
				    'min'  => '0',
				    'max'  => '100',
				    'step' => '1',
			    ),
			    'show_if'        => array(
				    'on_scroll_load' => 'on',
				    'enable_loader'  => 'on'
			    )
		    ),
		    'loader_alignment' => array(
			    'label'           => esc_html__( 'Alignment', 'divi_flash' ),
			    'type'            => 'multiple_buttons',
			    'options'         => array(
				    'left'  => array(
					    'title' => esc_html__( 'Left', 'divi_flash' ),
					    'icon'  => 'align-left', // Any svg icon that is defined on ETBuilderIcon component
				    ),
				    'center' => array(
					    'title' => esc_html__( 'Center', 'divi_flash' ),
					    'icon'  => 'align-center', // Any svg icon that is defined on ETBuilderIcon component
				    ),
				    'right'    => array(
					    'title' => esc_html__( 'Right', 'divi_flash' ),
					    'icon'  => 'align-right', // Any svg icon that is defined on ETBuilderIcon component
				    ),
			    ),
			    'default'         => 'center',
			    'toggleable'      => true,
			    'multi_selection' => false,
			    'tab_slug'        => 'general',
			    'toggle_slug'     => 'loader',
			    'description'     => esc_html__( 'You can control the loader alignment', 'divi_flash' ),
			    'show_if'         => array(
				    'on_scroll_load' => 'on',
				    'enable_loader'  => 'on'
			    ),
		    ),
		    'loader_margin'    => array(
			    'label'       => esc_html__( 'Margin', 'divi_flash' ),
			    'type'        => 'custom_margin',
			    'tab_slug'    => 'general',
			    'toggle_slug' => 'loader',
			    'show_if'     => array(
				    'on_scroll_load' => 'on',
				    'enable_loader'  => 'on'
			    ),
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
                    '1'  => esc_html__('1 column', 'divi_flash'),
                    '2'  => esc_html__('2 columns', 'divi_flash'),
                    '3'  => esc_html__('3 columns', 'divi_flash'),
                    '4'  => esc_html__('4 columns', 'divi_flash'),
                    '5'  => esc_html__('5 columns', 'divi_flash')
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
        $item_background = $this->df_add_bg_field(array (
			'label'				    => 'Item Background',
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
            'title'         => 'Item Outer Wrapper',
            'key'           => 'item_wrapper',
            'toggle_slug'   => 'margin_padding',
            'option'        => 'padding'
        ));
        $item_spacing = $this->add_margin_padding(array(
            'title'         => 'Item Inner Wrapper',
            'key'           => 'item',
            'toggle_slug'   => 'margin_padding',
            // 'option'        => 'padding'
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
            $post_type,
            $settings,
	        $loader,
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
            $pagination_spacing,
            $pagination_number_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $blog_item = '%%order_class%% .df-cpt-inner-wrap';
        $pagination = '%%order_class%% .pagination .page-numbers';

        $fields['item_wrapper_padding'] = array ('padding' => '%%order_class%% .df-cpt-outer-wrap');
        $fields['item_margin'] = array ('margin' => $blog_item);
        $fields['item_padding'] = array ('padding' => $blog_item);

        $fields['wrapper_margin'] = array ('margin' => '%%order_class%% .df-cpts-wrap');
        $fields['wrapper_padding'] = array ('padding' => '%%order_class%% .df-cpts-wrap');

        $fields['pagination_margin'] = array ('margin' => $pagination);
        $fields['pagination_padding'] = array ('padding' => $pagination);

        $fields['pagination_number_margin'] = array ('margin' => $pagination);
        
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
            '%%order_class%% .df-cpt-outer-wrap'
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
            '%%order_class%% .df-cpt-outer-wrap'
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
            'selector'          => '%%order_class%% .df-cpt-inner-wrap'
        ));
     
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-cpt-outer-wrap',
            'hover'             => '%%order_class%% .df-cpt-outer-wrap:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-cpt-inner-wrap',
            'hover'             => '%%order_class%% .df-hover-trigger:hover .df-cpt-inner-wrap',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-cpt-inner-wrap',
            'hover'             => '%%order_class%% .df-hover-trigger:hover .df-cpt-inner-wrap',
        ));
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
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-cpts-wrap',
            'hover'             => '%%order_class%% .df-cpts-wrap:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-cpts-wrap',
            'hover'             => '%%order_class%% .df-cpts-wrap:hover',
        ));
        // background
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "item_background",
            'selector'          => "%%order_class%% .df-cpt-inner-wrap",
            'hover'             => "%%order_class%% .df-hover-trigger:hover .df-cpt-inner-wrap"
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
        // column
        if(isset($this->props['column']) && $this->props['column'] !== '') {
            $column_desktop = 100 / intval($this->props['column']) . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-cpt-item',
                'declaration' => sprintf('width: %1$s;', $column_desktop)
            ));
        }
        if(isset($this->props['column_tablet']) && $this->props['column_tablet'] !== '') {
            $column_tablet = 100 / intval($this->props['column_tablet']) . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-cpt-item',
                'declaration' => sprintf('width: %1$s;', $column_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }
        if(isset($this->props['column_phone']) && $this->props['column_phone'] !== '') {
            $column_phone = 100 / intval($this->props['column_phone']) . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-cpt-item',
                'declaration' => sprintf('width: %1$s;', $column_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
        // gutter
        if(isset($this->props['gutter']) && $this->props['gutter'] !== '') {
            $gutter_desktop = intval($this->props['gutter']) / 2;
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-cpt-item',
                'declaration' => sprintf('padding-left: %1$spx; padding-right: %1$spx; padding-bottom: %2$spx;', 
                    $gutter_desktop, intval($this->props['gutter'])
                )
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_cptgrid_container .df-cpts-wrap',
                'declaration' => sprintf('margin-left: -%1$spx; margin-right: -%1$spx;', $gutter_desktop)
            ));
        }
        // gutter tablet
        if(isset($this->props['gutter_tablet']) && $this->props['gutter_tablet'] !== '') {
            $gutter_tablet = intval($this->props['gutter_tablet']) / 2;
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-cpt-item',
                'declaration' => sprintf('padding-left: %1$spx; padding-right: %1$spx; padding-bottom: %2$spx;', $gutter_tablet, intval($this->props['gutter_tablet'])),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_cptgrid_container .df-cpts-wrap',
                'declaration' => sprintf('margin-left: -%1$spx; margin-right: -%1$spx;', $gutter_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }
        // gutter phone
        if(isset($this->props['gutter_phone']) && $this->props['gutter_phone'] !== '') {
            $gutter_phone = intval($this->props['gutter_phone']) / 2;
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-cpt-item',
                'declaration' => sprintf('padding-left: %1$spx; padding-right: %1$spx; padding-bottom: %2$spx;', $gutter_phone, intval($this->props['gutter_phone'])),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_cptgrid_container .df-cpts-wrap',
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
            'selector' => '%%order_class%% .pagination .older:before, %%order_class%% .pagination .prev:before',
            'declaration' => sprintf('content: "%1$s";', $this->arrow_icon($this->props['next_prev_icon'], 'prev')),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .pagination .newer:after, %order_class%% .pagination .next:after',
            'declaration' => sprintf('content: "%1$s";', $this->arrow_icon($this->props['next_prev_icon'], 'next')),
        ));

        // overflow
        if( isset($this->props['outer_wrpper_visibility']) && $this->props['outer_wrpper_visibility'] !== 'default' ) {
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'outer_wrpper_visibility',
                'type'              => 'overflow',
                'selector'          => '%%order_class%% .df-cpt-outer-wrap',
                'important'         => true
            ));
        }
        if( isset($this->props['inner_wrpper_visibility']) && $this->props['inner_wrpper_visibility'] !== 'default' ) {
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'inner_wrpper_visibility',
                'type'              => 'overflow',
                'selector'          => '%%order_class%% .df-cpt-inner-wrap',
                'important'         => true
            ));
        }
        if($this->props['use_image_as_background'] === 'on' && $this->props['use_background_scale'] === 'on'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '.difl_cptgrid%%order_class%%',
                'declaration' => sprintf('z-index:1;'),
            ));
        }
    }

    /**
	 * Get blog posts for cptgrid module
	 *
	 * @return string blog post markup
	 */
    public function get_posts() {

        global $post, $paged, $wp_query, $wp_the_query, $wp_filter, $__et_blog_module_paged, $df_cpt_items, $df_cpt_items_outside;

        $main_query = $wp_the_query;

        $use_current_loop           = isset( $this->props['use_current_loop'] ) ? $this->props['use_current_loop'] : 'off';
        $offset_number              = $this->props['offset_number'];
        $posts_number               = $this->props['posts_number'];
        $post_display               = $this->props['post_display'];
        $orderby                    = ! empty( $this->props['orderby'] ) ? $this->props['orderby'] : '';
        $layout                     = $this->props['layout'];
        $use_image_as_background    = $this->props['use_image_as_background'];
        $use_background_scale       = $this->props['use_background_scale'];
        $current_post_id = isset( $post->ID ) && ! empty( $post->ID ) ? $post->ID : 0 ;
        if ( 'off' === $use_current_loop && ( !isset($this->props['post_type']) || 'select' === $this->props['post_type'] ) ) return;

        $query_args = array(
			'posts_per_page' => intval($this->props['posts_number']),
			'post_status'    => array( 'publish' ),
			'perm'           => 'readable',
			'post_type'      => $this->props['post_type'],
        );

        // display post_types by taxonomies
        if('by_tax' === $post_display) {
            $this->get_taxonomy_values();
            if('' != $this->selected_terms) {
                
                if(str_contains($this->selected_terms, 'current')){
                    if(is_single()){
                        $current_terms = implode(",", array_column(wp_get_post_terms($current_post_id , $this->selected_taxonomy), "term_taxonomy_id"));
                       //$current_terms = array_column(wp_get_post_terms($current_post_id , $this->selected_taxonomy), "term_taxonomy_id")
	                    $terms = explode(',', $current_terms);
                    }
                }else{
	                $terms = explode(',', $this->selected_terms);
                }
	            $query_args['tax_query'] = array( //phpcs:ignore WordPress.DB.SlowDBQuery
		            'relation' => 'AND',
		            array(
			            'taxonomy'  => $this->selected_taxonomy,
			            'field'     => 'term_id',
			            'terms'     => $terms
		            )
	            );

            }
        }

        // orderby
        if ('2' === $orderby) {
            $query_args['orderby'] = 'date';
            $query_args['order'] = 'ASC';
        } else if ('3' === $orderby) {
            $query_args['orderby'] = 'title';
            $query_args['order'] = 'ASC';
        } else if ('4' === $orderby) {
            $query_args['orderby'] = 'title';
            $query_args['order'] = 'DESC';
        } else if ('5' === $orderby) {
            $query_args['orderby'] = 'rand';
        }  else if ('6' === $orderby) {
            $query_args['orderby'] = 'menu_order';
            $query_args['order'] = 'ASC';
        }  else if ('7' === $orderby) {
            $query_args['orderby'] = 'menu_order';
            $query_args['order'] = 'DESC';
        } else {
            $query_args['orderby'] = 'date';
            $query_args['order'] = 'DESC';
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
		}else{
			$query_args['paged'] = $df_pg_paged;
        }

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

        echo '<div class="df-cpts-wrap layout-'.esc_attr($layout).'">';

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
                <article id="post-<?php the_ID(); ?>" <?php post_class( "df-cpt-item v2{$equal_height_class}" ) ?>
		            <?php if ('on' === $this->props['entire_item_clickable']) { echo 'onclick="location.href=\'', esc_url(get_the_permalink()), '\'" style="cursor:pointer;"';} ?>
                >
                    <div class="df-cpt-outer-wrap df-hover-trigger" <?php echo 'on' !== $use_background_scale ? et_core_esc_previously(df_cpt_image_as_background($use_image_as_background)) : '';?>>
                        <?php 
                            // render markup to achive the scale effect.
                            if( 'on' === $use_image_as_background && 'on' === $use_background_scale ) {
                                echo '<div class="df-cpt-bg-on-hover"><div ' . et_core_esc_previously(df_cpt_image_as_background($use_image_as_background)) .'></div></div>';
                            }
                            if( !empty($df_cpt_items_outside) ) {
                                foreach( $df_cpt_items_outside as $post_item ) {

                                    if( !isset($post_item['type'])) {
                                        continue;
                                    }

                                    $callback = 'df_cpt_' . $post_item['type'];

                                    call_user_func($callback, $post_item);

                                } // end of foreach
                            }
                        ?>
                        <div class="df-cpt-inner-wrap">
                            <?php
                                foreach( $df_cpt_items as $post_item ) {
                                    
                                    if( !isset($post_item['type'])) {
                                        continue;
                                    }

                                    $callback = 'df_cpt_' . $post_item['type'];

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
                add_filter( 'get_pagenum_link', array( 'DIFL_CptGrid', 'filter_pagination_url' ) );
                if ( 'on' !== $this->props['use_number_pagination'] ) {
                    cpt_render_pagination(
                        $this->props['older_text'],
                        $this->props['newer_text'],
                        $this->props['use_icon_only_at_pagination']
                    );
                } else {
                    cpt_render_number_pagination(
                        $this->props['older_text'],
                        $this->props['newer_text'],
                        $this->props['use_icon_only_at_pagination']
                    );
                }
                remove_filter( 'get_pagenum_link', array( 'DIFL_CptGrid', 'filter_pagination_url' ) );
            }
        }

		$wp_the_query = $wp_query = $main_query; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
        wp_reset_query(); // phpcs:ignore WordPress.WP.DiscouragedFunctions
        
        $posts = ob_get_contents();
	    ob_end_clean();
        
        if(empty($df_cpt_items)) { $posts = ''; }
        $df_cpt_items = array();
        $df_cpt_items_outside = array();

        return $posts;
    }

    /**
     * Module render method.
     * 
     * @return String
     */
    public function render( $attrs, $content, $render_slug ) {
	    global $df_cpt_items, $df_cpt_items_outside;
        $this->additional_css_styles($render_slug);
        wp_enqueue_script('imageload');
        wp_enqueue_script('df-imagegallery-lib');
        if ( 'off' !== $this->props['show_pagination'] ) {
			wp_enqueue_script( 'fitvids' );
		}
        wp_enqueue_script('df-cpt-grid');

	    $loader_data = array(
		    'status'     => isset( $this->props['enable_loader'] ) ? $this->props['enable_loader'] : 'off',
		    'color'      => isset( $this->props['loader_color'] ) ? $this->props['loader_color'] : '#284cc1',
		    'size'       => isset( $this->props['loader_size'] ) ? $this->props['loader_size'] : '10px',
		    'type'       => isset( $this->props['loader_type'] ) ? $this->props['loader_type'] : 'bar',
		    'background' => isset( $this->props['loader_bg_color'] ) ? $this->props['loader_bg_color'] : '#ffffff',
		    'alignment'  => isset( $this->props['loader_alignment'] ) ? $this->props['loader_alignment'] : 'center',
		    'margin'     => isset( $this->props['loader_margin'] ) ? array_slice( explode( "|", $this->props['loader_margin'] ), 0, 4 ) : [
			    '0px',
			    '0px',
			    '0px',
			    '0px'
		    ],
	    );
        
        $data = array(
            'layout'                  => $this->props['layout'],
            'on_scroll_load'          => $this->props['on_scroll_load'],
            'use_current_loop'        => $this->props['use_current_loop'],
            'post_type'               => $this->props['post_type'],
            'posts_number'            => $this->props['posts_number'],
            'post_display'            => $this->props['post_display'],
            'orderby'                 => $this->props['orderby'],
            'offset_number'           => $this->props['offset_number'],
            'use_image_as_background' => $this->props['use_image_as_background'],
            'use_background_scale'    => $this->props['use_background_scale'],
            'equal_height'            => $this->props['equal_height'],
            'entire_item_clickable'   => $this->props['entire_item_clickable'],
            'taxonomy_values'         => $this->get_taxonomy_values(),
            'selected_terms'          => $this->selected_terms,
            'selected_taxonomy'       => $this->selected_taxonomy,
            'df_cpt_items'            => $df_cpt_items,
            'df_cpt_items_outside'    => $df_cpt_items_outside,
            'loader'                  => $loader_data
        );

        return sprintf('<div class="df_cptgrid_container et_pb_ajax_pagination_container" data-settings=\'%2$s\'>%1$s</div>', 
            $this->get_posts(),
            wp_json_encode($data)
        );
    }

    /**
     * next and prev icons
     * 
     * @param String set of the icon to use
     * @param String next/prev
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

    public static function filter_pagination_url( $result ) {
		return add_query_arg( 'df_cpt', '', $result );
	}

}

new DIFL_CptGrid;
