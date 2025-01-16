<?php
class DIFL_CptFilter extends ET_Builder_Module_Type_PostBased {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_cptfilter';
    public $vb_support = 'on';
    public $child_slug = 'difl_cptitem';
    use DF_UTLS;
    use Df_Cpt_Taxonomy_Support;
	use Df_Acf_Data_Process;

	public $filter_modile_view_header, $filter_modile_view_footer;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Filterable CPT', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/cpt-filter.svg';
        $this->init_cpt_tax(
            'general', 
            'settings',
            array(),
            array(),
            array(
                'terms' => 'Filter by terms:'
            )
        );
	    $this->df_acf_init();

		$this->filter_modile_view_header = "{$this->main_css_element} .df_phn_resp_cls .difl_filter_short_desc_card_header";
		$this->filter_modile_view_footer = "{$this->main_css_element} .df_phn_resp_cls .difl_filter_short_desc_card";
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'settings'              => esc_html__('CPT Settings', 'divi_flash'),
                    'multi_filter_acf'          => esc_html__('Multi Filter ( ACF )', 'divi_flash'),
                    'multi_filter_field_type'          => esc_html__('Multi Filter Field Type', 'divi_flash'),
                    'item_outer_background'       => esc_html__('Item Outer Wrapper Background', 'divi_flash'),
                    'item_inner_background'       => esc_html__('Item Inner wrapper Background', 'divi_flash'),
                    'search_bar_wrapper_background'       => esc_html__('Search wrapper Background', 'divi_flash'),
                    // 'loader_settings'              => esc_html__('Loader Settings', 'divi_flash'),  
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'content_align'         => esc_html__('Alignment', 'divi_flash'),
                    'layout'                => esc_html__('Layout', 'divi_flash'),
                    'item_outer_wrapper'    => esc_html__('Item Outer Wrapper', 'divi_flash'),
                    'item_inner_wrapper'    => esc_html__('Item Inner Wrapper', 'divi_flash'),
                    'filter_buttons'        => esc_html__('Filter Buttons', 'divi_flash'),
                    'filter_button_active'  => esc_html__('Active Filter Button', 'divi_flash'),
                    'filter_button_active_container' => array(
	                    'title'             => esc_html__( 'Active Filter Button Container', 'divi_flash' ),
	                    'tabbed_subtoggles' => true,
	                    'sub_toggles'       => array(
		                    'container'       => array(
			                    'name' => esc_html__( 'Container', 'divi_flash' )
		                    ),
		                    'show' => array(
			                    'name' => esc_html__( 'Show Btn', 'divi_flash' )
		                    ),
		                    'cancel' => array(
			                    'name' => esc_html__( 'Cancel Btn', 'divi_flash' )
		                    ),
	                    ),
                    ),
                    'multi_filter_container'=> esc_html__('Multi Filter Container', 'divi_flash'),
                    'multi_filter_input'    => esc_html__('Multi Filter Dropdown', 'divi_flash'),
                    'multi_filter_label'    => esc_html__('Multi Filter Dropdown Label', 'divi_flash'),
                    'multi_filter_checkbox_field'    => esc_html__('Multi Filter Checkbox', 'divi_flash'),
                    'multi_filter_checkbox_label'    => array(
	                    'title' => esc_html__('Multi Filter Checkbox Font', 'divi_flash'),
	                    'tabbed_subtoggles' => true,
	                    'sub_toggles' => array(
		                    'checkbox_label'     => array(
			                    'name' => 'Label',
		                    ),
		                    'checkbox_text'     => array(
			                    'name' => 'Field Text',
		                    )
	                    ),
                    ),
                    'multi_filter_range_field'=> esc_html__('Multi Filter Range', 'divi_flash'),
                    'multi_filter_range_label'=> array(
	                    'title' => esc_html__('Multi Filter Range Font', 'divi_flash'),
	                    'tabbed_subtoggles' => true,
	                    'sub_toggles' => array(
		                    'range_label'     => array(
			                    'name' => 'Label',
		                    ),
		                    'range_text'     => array(
			                    'name' => 'Tooltip',
		                    ),
		                    'min_max_text'     => array(
			                    'name' => 'Min-Max',
		                    )
	                    ),
                    ),
                    'search_bar'             => esc_html__('Search Input', 'divi_flash'),
                    'search_bar_button'       => esc_html__('Search Button', 'divi_flash'),
                    'empty_post_message'    => esc_html__('Empty Post Message', 'divi_flash'),
                    'load_more'             => esc_html__('Load More', 'divi_flash'),
                    'loader_settings'           => esc_html__('Loader Spinner', 'divi_flash'),
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
            'filter_buttons'     => array(
                'label'          => et_builder_i18n( 'Filter Buttons' ),
                'css'            => array(
                    'main'        => "%%order_class%% .df-cpt-filter-nav-item",
                    'hover'       => "%%order_class%% .df-cpt-filter-nav-item:hover"
                ),
                'line_height'    => array(
                    'default'       => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'hide_text_align' => true,
                'font_size'      => array(
                    'default'       => '14px',
                ),
                'toggle_slug'    => 'filter_buttons'
            ),
            'filter_button_active'     => array(
                'label'           => et_builder_i18n( 'Active Filter Button' ),
                'css'             => array(
                    'main'        => "%%order_class%% .df-cpt-filter-nav-item.df-active, %%order_class%% .filter_section .filter_elements .filter_element_card",
                    'hover'        => "%%order_class%% .df-cpt-filter-nav-item.df-active:hover, %%order_class%% .filter_section .filter_elements .filter_element_card:hover"
                ),
                'hide_text_align' => true,
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '14px',
                ),
                'toggle_slug'     => 'filter_button_active'
            ),
            'filter_button_active_container_header_title' => array(
	            'label'           => et_builder_i18n( 'Header Title' ),
	            'css'             => array(
		            'main'  => "{$this->filter_modile_view_header} h4",
		            'hover' => "{$this->filter_modile_view_header} h4"
	            ),
	            'hide_text_align' => true,
	            'line_height'     => array(
		            'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
	            ),
	            'font_size'       => array(
		            'default' => '14px',
	            ),
	            'toggle_slug'     => 'filter_button_active_container',
	            'sub_toggle'      => 'container'
            ),
            'filter_button_active_container_show'         => array(
	            'label'           => et_builder_i18n( '' ),
	            'css'             => array(
		            'main'  => "{$this->filter_modile_view_footer} a.difl_filter_show_btn",
		            'hover' => "{$this->filter_modile_view_footer} a.difl_filter_show_btn:hover"
	            ),
	            'hide_text_align' => true,
	            'line_height'     => array(
		            'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
	            ),
	            'font_size'       => array(
		            'default' => '14px',
	            ),
	            'toggle_slug'     => 'filter_button_active_container',
	            'sub_toggle'      => 'show'
            ),
            'filter_button_active_container_cancel'       => array(
	            'label'           => et_builder_i18n( '' ),
	            'css'             => array(
		            'main'  => "{$this->filter_modile_view_footer} a.difl_filter_cls_btn",
		            'hover' => "{$this->filter_modile_view_footer} a.difl_filter_cls_btn:hover"
	            ),
	            'hide_text_align' => true,
	            'line_height'     => array(
		            'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
	            ),
	            'font_size'       => array(
		            'default' => '14px',
	            ),
	            'toggle_slug'     => 'filter_button_active_container',
	            'sub_toggle'      => 'cancel'
            ),
            'multi_filter_input'     => array(
                'label'          => et_builder_i18n( 'Dropdown' ),
                'css'            => array(
                    'main'        => "%%order_class%% .filter_section li .multi-select-component , %%order_class%% .filter_section .search-container .selected-input, %%order_class%% .filter_section .search-container .selected-input::placeholder",
                    'hover'       => "%%order_class%% .filter_section li:hover .multi-select-component"
                ),
                'line_height'    => array(
                    'default'       => floatval( et_get_option( 'body_font_height', '1.3' ) ) . 'em',
                ),
                'font_size'      => array(
                    'default'       => '14px',
                ),
                'toggle_slug'    => 'multi_filter_input'
            ),

            'multi_filter_text'     => array(
                'label'          => et_builder_i18n( 'Label' ),
                'css'            => array(
                    'main'        => "%%order_class%% .filter_section ul li span.multi_filter_label",
                    'hover'       => "%%order_class%% .filter_section ul li span.multi_filter_label:hover"
                ),
                'line_height'    => array(
                    'default'       => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'      => array(
                    'default'       => '14px',
                ),
                'toggle_slug'    => 'multi_filter_label'
            ),

            'load_more'     => array(
                'label'           => et_builder_i18n( 'Load More' ),
                'css'             => array(
                    'main'        => "%%order_class%% .df-cptfilter-load-more",
                    'hover'        => "%%order_class%% .df-cptfilter-load-more:hover"
                ),
                'hide_text_align' => true,
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '14px',
                ),
                'toggle_slug'     => 'load_more'
            ),
            'search_bar'     => array(
                'label'           => et_builder_i18n( 'Input' ),
                'css'             => array(
                    'main'        => "%%order_class%% .search_bar input.df_search_filter_input, %%order_class%% .search_bar input.df_search_filter_input::placeholder",
                    'hover'        => "%%order_class%% .search_bar input.df_search_filter_input:hover"
                ),
                'hide_text_align' => true,
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '14px',
                ),
                'toggle_slug'     => 'search_bar'
            ),
            'search_bar_button'     => array(
                'label'           => et_builder_i18n( 'Button' ),
                'css'             => array(
                    'main'        => "%%order_class%% .search_bar .search_bar_button",
                    'hover'        => "%%order_class%% .search_bar .search_bar_button:hover"
                ),
                'hide_text_align' => true,
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '14px',
                ),
                'toggle_slug'     => 'search_bar_button'
            ),
            'empty_post_message'     => array(
                'label'          => et_builder_i18n( '' ),
                'css'            => array(
                    'main'        => "%%order_class%% .no-post",
                    'hover'       => "%%order_class%% .no-post:hover"
                ),
                'font' => array(
                    'show_if' => array(
                        'use_empty_post_message' => 'on' 
                     )
                ),
                'text_color'=> array(
                    'show_if' => array(
                        'use_empty_post_message' => 'on' 
                     )
                ),
                'letter_spacing'=> array(
                    'show_if' => array(
                        'use_empty_post_message' => 'on' 
                     )
                ),
                'line_height'    => array(
                    'default'       => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                    'show_if' => array(
                        'use_empty_post_message' => 'on' 
                     )
                ),
                'text_shadow'=> array(
                    'show_if' => array(
                        'use_empty_post_message' => 'on' 
                     )
                ),
                'hide_text_align' => true,
                'font_size'      => array(
                    'default'       => '14px',
                    'show_if' => array(
                       'use_empty_post_message' => 'on' 
                    )
                ),
                'toggle_slug'    => 'empty_post_message'
            ),

            'multi_filter_checkbox_label'         => array(
	            'label'       => et_builder_i18n( 'Label' ),
	            'css'         => array(
		            'main'  => "%%order_class%% .filter_section li .checkbox_container .multi_filter_label",
		            'hover' => "%%order_class%% .filter_section li .checkbox_container .multi_filter_label:hover"
	            ),
	            'line_height' => array(
		            'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
	            ),
	            'font_size'   => array(
		            'default' => '18px',
	            ),
	            'toggle_slug' => 'multi_filter_checkbox_label',
	            'sub_toggle'  => 'checkbox_label',
            ),
            'multi_filter_acf_checkbox_text' => array(
	            'label'       => et_builder_i18n( 'Label' ),
	            'css'         => array(
		            'main'  => "%%order_class%% .filter_section li .checkbox_container .checkbox_content",
		            'hover' => "%%order_class%% .filter_section li .checkbox_container .checkbox_content:hover"
	            ),
	            'line_height' => array(
		            'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
	            ),
	            'font_size'   => array(
		            'default' => '14px',
	            ),
	            'toggle_slug' => 'multi_filter_checkbox_label',
	            'sub_toggle'  => 'checkbox_text'
            ),
            'multi_filter_range_label' => array(
	            'label'       => et_builder_i18n( 'Label' ),
	            'css'         => array(
		            'main'  => "%%order_class%% .filter_section li span.multi_filter_range_label",
		            'hover' => "%%order_class%% .filter_section li span.multi_filter_range_label:hover"
	            ),
	            'line_height' => array(
		            'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
	            ),
	            'font_size'   => array(
		            'default' => '14px',
	            ),
	            'toggle_slug' => 'multi_filter_range_label',
	            'sub_toggle'  => 'range_label'
            ),
            'multi_filter_range_tooltip_text' => array(
	            'label'       => et_builder_i18n( 'Text' ),
	            'css'         => array(
		            'main'  => "%%order_class%% .filter_section li .irs .irs-from, %%order_class%% .filter_section li .irs .irs-to",
		            'hover' => "%%order_class%% .filter_section li .irs .irs-from:hover, %%order_class%% .filter_section li .irs .irs-to:hover"
	            ),
	            'line_height' => array(
		            'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
	            ),
	            'font_size'   => array(
		            'default' => '10px',
	            ),
	            'toggle_slug' => 'multi_filter_range_label',
	            'sub_toggle'  => 'range_text'
            ),
            'multi_filter_range_min_max_text' => array(
	            'label'       => et_builder_i18n( 'Min-Max' ),
	            'css'         => array(
		            'main'  => "%%order_class%% .filter_section li .irs .irs-min, %%order_class%% .filter_section li .irs .irs-max",
		            'hover' => "%%order_class%% .filter_section li .irs .irs-min:hover, %%order_class%% .filter_section li .irs .irs-max:hover"
	            ),
	            'line_height' => array(
		            'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
	            ),
	            'font_size'   => array(
		            'default' => '10px',
	            ),
	            'toggle_slug' => 'multi_filter_range_label',
	            'sub_toggle'  => 'min_max_text'
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
            'filter_buttons'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-cpt-filter-nav-item',
                        'border_radii_hover' => '%%order_class%% .df-cpt-filter-nav-item:hover',
                        'border_styles' => '%%order_class%% .df-cpt-filter-nav-item',
                        'border_styles_hover' => '%%order_class%% .df-cpt-filter-nav-item:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'filter_buttons',
                'label_prefix'      => 'Buttons'
            ),
            'filter_button_active'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-cpt-filter-nav-item.df-active, %%order_class%% .filter_section .filter_elements .filter_element_card',
                        'border_radii_hover' => '%%order_class%% .df-cpt-filter-nav-item.df-active:hover, %%order_class%% .filter_section .filter_elements .filter_element_card:hover',
                        'border_styles' => '%%order_class%% .df-cpt-filter-nav-item.df-active, %%order_class%% .filter_section .filter_elements .filter_element_card',
                        'border_styles_hover' => '%%order_class%% .df-cpt-filter-nav-item.df-active:hover, %%order_class%% .filter_section .filter_elements .filter_element_card:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'filter_button_active',
                'label_prefix'      => 'Active Button'
            ),
            'filter_button_active_container_header' => array(
	            'css'          => array(
		            'main' => array(
			            'border_radii'        => $this->filter_modile_view_header,
			            'border_radii_hover'  => "{$this->filter_modile_view_header}:hover",
			            'border_styles'       => $this->filter_modile_view_header,
			            'border_styles_hover' => "{$this->filter_modile_view_header}:hover",
		            )
	            ),
	            'tab_slug'     => 'advanced',
	            'toggle_slug'  => 'filter_button_active_container',
	            'sub_toggle'   => 'container',
	            'label_prefix' => 'Header'
            ),
            'filter_button_active_container_footer' => array(
	            'css'          => array(
		            'main' => array(
			            'border_radii'        => $this->filter_modile_view_footer,
			            'border_radii_hover'  => "{$this->filter_modile_view_footer}:hover",
			            'border_styles'       => $this->filter_modile_view_footer,
			            'border_styles_hover' => "{$this->filter_modile_view_footer}:hover",
		            )
	            ),
	            'tab_slug'     => 'advanced',
	            'toggle_slug'  => 'filter_button_active_container',
	            'sub_toggle'   => 'container',
	            'label_prefix' => 'Footer'
            ),
            'filter_button_active_container_show'   => array(
	            'css'          => array(
		            'main' => array(
			            'border_radii'        => "{$this->filter_modile_view_footer} a.difl_filter_show_btn",
			            'border_radii_hover'  => "{$this->filter_modile_view_footer} a.difl_filter_show_btn:hover",
			            'border_styles'       => "{$this->filter_modile_view_footer} a.difl_filter_show_btn",
			            'border_styles_hover' => "{$this->filter_modile_view_footer} a.difl_filter_show_btn:hover",
		            )
	            ),
	            'tab_slug'     => 'advanced',
	            'toggle_slug'  => 'filter_button_active_container',
	            'sub_toggle'   => 'show',
	            'label_prefix' => ''
            ),
            'filter_button_active_container_cancel' => array(
	            'css'          => array(
		            'main' => array(
			            'border_radii'        => "{$this->filter_modile_view_footer} a.difl_filter_cls_btn",
			            'border_radii_hover'  => "{$this->filter_modile_view_footer} a.difl_filter_cls_btn:hover",
			            'border_styles'       => "{$this->filter_modile_view_footer} a.difl_filter_cls_btn",
			            'border_styles_hover' => "{$this->filter_modile_view_footer} a.difl_filter_cls_btn:hover",
		            )
	            ),
	            'tab_slug'     => 'advanced',
	            'toggle_slug'  => 'filter_button_active_container',
	            'sub_toggle'   => 'cancel',
	            'label_prefix' => ''
            ),
            'multi_filter_container'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .filter_section',
                        'border_radii_hover' => '%%order_class%% .filter_section:hover',
                        'border_styles' => '%%order_class%% .filter_section',
                        'border_styles_hover' => '%%order_class%% .filter_section:hover'
                    )
                ),
                'defaults' => array(
                    'border_styles' => array(
                        'width' => '0px',
                        'color' => '#D0D9E2',
                        'style' => 'solid'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'multi_filter_container',
                'label_prefix'      => 'Container'
            ),
            'multi_filter_input'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .filter_section li select , %%order_class%% .filter_section li .multi-select-component',
                        'border_radii_hover' => '%%order_class%% .filter_section li select:hover , %%order_class%% .filter_section li .multi-select-component:hover',
                        'border_styles' => '%%order_class%% .filter_section li select , %%order_class%% .filter_section li .multi-select-component',
                        'border_styles_hover' => '%%order_class%% .filter_section li select:hover, %%order_class%% .filter_section li .multi-select-component:hover',
                    )
                ),
                'defaults' => array(
                    'border_styles' => array(
                        'width' => '1px',
                        'color' => '#D0D9E2',
                        'style' => 'solid'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'multi_filter_input',
                'label_prefix'      => 'Dropdown'
            ),
            'multi_filter_dropdown_container'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .filter_section li select , %%order_class%% .filter_section li .dropdown-container',
                        'border_radii_hover' => '%%order_class%% .filter_section li select:hover , %%order_class%% .filter_section li .dropdown-container:hover',
                        'border_styles' => '%%order_class%% .filter_section li select , %%order_class%% .filter_section li .dropdown-container',
                        'border_styles_hover' => '%%order_class%% .filter_section li select:hover, %%order_class%% .filter_section li .dropdown-container:hover',
                    )
                ),
                'defaults' => array(
                    'border_styles' => array(
                        'width' => '0px',
                        'color' => '#000000',
                        'style' => 'solid'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'multi_filter_input',
                'label_prefix'      => 'Dropdown Container'
            ),

            'multi_filter_label'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .filter_section li span.multi_filter_label',
                        'border_radii_hover' => '%%order_class%% .filter_section li span.multi_filter_label:hover',
                        'border_styles' => '%%order_class%% .filter_section li span.multi_filter_label',
                        'border_styles_hover' => '%%order_class%% .filter_section li span.multi_filter_label:hover',
                    )
                ),
                'defaults' => array(
                    'border_styles' => array(
                        'width' => '1px',
                        'color' => '#D0D9E2',
                        'style' => 'solid'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'multi_filter_label',
                'label_prefix'      => 'Label'
            ),
            'multi_filter_range_label'            => array (
	            'css'               => array(
		            'main' => array(
			            'border_radii' => '%%order_class%% .filter_section li span.multi_filter_range_label',
			            'border_radii_hover' => '%%order_class%% .filter_section li span.multi_filter_range_label:hover',
			            'border_styles' => '%%order_class%% .filter_section li span.multi_filter_range_label',
			            'border_styles_hover' => '%%order_class%% .filter_section li span.multi_filter_range_label:hover',
		            )
	            ),
	            'defaults' => array(
		            'border_styles' => array(
			            'width' => '1px',
			            'color' => '#D0D9E2',
			            'style' => 'solid'
		            )
	            ),
	            'toggle_slug'    => 'multi_filter_range_label',
	            'sub_toggle'     => 'range_label',
	            'tab_slug'       => 'advanced',
	            'label_prefix'   => 'Label'
            ),

            'multi_filter_checkbox_field'        => array (
	            'css'               => array(
		            'main' => array(
			            'border_radii' => '%%order_class%% .filter_section li .checkbox_container',
			            'border_radii_hover' => '%%order_class%% .filter_section li .checkbox_container:hover',
			            'border_styles' => '%%order_class%% .filter_section li .checkbox_container',
			            'border_styles_hover' => '%%order_class%% .filter_section li .checkbox_container:hover',
		            )
	            ),
	            'defaults' => array(
		            'border_styles' => array(
			            'width' => '0px',
			            'color' => '#333',
			            'style' => 'solid'
		            )
	            ),
	            'tab_slug'          => 'advanced',
	            'toggle_slug'       => 'multi_filter_checkbox_field',
	            'label_prefix'      => 'Field'
            ),

            'load_more'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .df-cptfilter-load-more',
                        'border_radii_hover' => '%%order_class%% .df-cptfilter-load-more:hover',
                        'border_styles' => '%%order_class%% .df-cptfilter-load-more',
                        'border_styles_hover' => '%%order_class%% .df-cptfilter-load-more:hover',
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'load_more',
                'label_prefix'      => 'Load More'
            ),
            'search_bar_input'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .search_bar input.df_search_filter_input',
                        'border_radii_hover' => '%%order_class%% .search_bar input.df_search_filter_input:hover',
                        'border_styles' => '%%order_class%% .search_bar input.df_search_filter_input',
                        'border_styles_hover' => '%%order_class%% .search_bar input.df_search_filter_input:hover',
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => array(
                        'width' => '1px',
                        'color' => '#f9f9f9',
                        'style' => 'solid'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'search_bar',
                'label_prefix'      => 'Input'
                ),
            'search_bar_button'            => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .search_bar .search_bar_button',
                        'border_radii_hover' => '%%order_class%% .search_bar .search_bar_button:hover',
                        'border_styles' => '%%order_class%% .search_bar .search_bar_button',
                        'border_styles_hover' => '%%order_class%% .search_bar .search_bar_button:hover',
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => array(
                        'width' => '1px',
                        'color' => '#E6E6E6',
                        'style' => 'solid'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'search_bar_button',
                'label_prefix'      => 'Button'
            )
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
            'filter_buttons'      => array(
                'css' => array(
                    'main' => "%%order_class%% .df-cpt-filter-nav-item",
                    'hover' => "%%order_class%% .df-cpt-filter-nav-item:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'filter_buttons'
            ),
            'filter_button_active'    => array(
                'css' => array(
                    'main' => "%%order_class%% .df-cpt-filter-nav-item.df-active, %%order_class%% .filter_section .filter_elements .filter_element_card",
                    'hover' => "%%order_class%% .df-cpt-filter-nav-item.df-active:hover,
                    %%order_class%% .filter_section .filter_elements .filter_element_card:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'filter_button_active'
            ),
            'filter_button_active_container_show'   => array(
	            'css'         => array(
		            'main'  => "{$this->filter_modile_view_footer} a.difl_filter_show_btn",
		            'hover' => "{$this->filter_modile_view_footer} a.difl_filter_show_btn:hover",
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'filter_button_active_container',
	            'sub_toggle'  => 'show',
	            'label'       => ''
            ),
            'filter_button_active_container_cancel' => array(
	            'css'         => array(
		            'main'  => "{$this->filter_modile_view_footer} a.difl_filter_cls_btn",
		            'hover' => "{$this->filter_modile_view_footer} a.difl_filter_cls_btn:hover",
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'filter_button_active_container',
	            'sub_toggle'  => 'cancel',
	            'label'       => ''
            ),

            'multi_filter_container'  => array(
                'css' => array(
                    'main' => "%%order_class%% .filter_section",
                    'hover' => "%%order_class%% .filter_section:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'multi_filter_container',
                'label'      => 'Container Box Shadow'
            ), 
            'multi_filter_input'      => array(
                'css' => array(
                    'main' => "%%order_class%% .filter_section li select , %%order_class%% .filter_section li .multi-select-component",
                    'hover' => "%%order_class%% .filter_section li select:hover , %%order_class%% .filter_section li .multi-select-component:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'multi_filter_input',
                'label'      => 'Dropdown Box Shadow'
            ),
            'multi_filter_dropdown_container'      => array(
	            'css' => array(
		            'main' => "%%order_class%% .filter_section li select , %%order_class%% .filter_section li .dropdown-container",
		            'hover' => "%%order_class%% .filter_section li select:hover , %%order_class%% .filter_section li .dropdown-container:hover",
	            ),
	            'tab_slug'          => 'advanced',
	            'toggle_slug'       => 'multi_filter_input',
	            'label'      => 'Dropdown Container Box Shadow'
            ),

            'multi_filter_label'      => array(
                'css' => array(
                    'main' => "%%order_class%% .filter_section li span.multi_filter_label",
                    'hover' => "%%order_class%% .filter_section li span.multi_filter_label:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'multi_filter_label',
                'label'      => 'Label Box Shadow'
            ),

            'multi_filter_checkbox_field'      => array(
	            'css' => array(
		            'main' => "%%order_class%% .filter_section li .checkbox_container",
		            'hover' => "%%order_class%% .filter_section li .checkbox_container",
	            ),
	            'tab_slug'          => 'advanced',
	            'toggle_slug'       => 'multi_filter_checkbox_field',
	            'label'      => 'Field Box Shadow'
            ),

            'load_more'      => array(
                'css' => array(
                    'main' => "%%order_class%% .df-cptfilter-load-more",
                    'hover' => "%%order_class%% .df-cptfilter-load-more:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'load_more',
                'label'             =>'Load More Box Shadow'
            ),

            'search_bar_input'      => array(
                'css' => array(
                    'main' => "%%order_class%% .search_bar input.df_search_filter_input",
                    'hover' => "%%order_class%% .search_bar input.df_search_filter_input:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'search_bar',
                'label'             =>'Input Box Shadow'
            ),
            'search_bar_button'      => array(
                'css' => array(
                    'main' => "%%order_class%% .search_bar .search_bar_button",
                    'hover' => "%%order_class%% .search_bar .search_bar_button:hover",
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'search_bar_button',
                'label'             =>'Button Box Shadow'
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
                    'by_tax'        => esc_html__('By Taxonomy', 'divi_flash'),
                    'multiple_filter'        => esc_html__('Multiple Filter', 'divi_flash')
                ),
                'default'           => 'recent',
                'toggle_slug'       => 'settings',
                'show_if_not'       => array(
					'use_current_loop' => 'on'
				)
            )
        );
    
        $post_type = array_merge($post_type, $this->tax_settings,  $this->tax_list , $this->df_multi_filter_tax_field_type, $this->term_settings);

        $settings = array (
            'multi_filter_type' => array(
				'label'             => esc_html__( 'Multi Filter Type', 'divi_flash' ),
				'type'              => 'select',
				'options'           => array(
					'AND' => esc_html__( 'AND', 'divi_flash' ),
					'OR' => esc_html__( 'OR', 'divi_flash' ),
				),
				'default'			=> 'AND',
				'toggle_slug'       => 'settings',
                'show_if'         => array(
					'post_display' => array('multiple_filter'),
				),
				'show_if_not'         => array(
					'post_display' => array('by_tax'),
                    'use_current_loop' => 'on'
				)
			),
            

            'orderby' => array(
				'label'             => esc_html__( 'Order by', 'divi_flash' ),
                'description' => esc_html__('Choose which order you would like to set for your feed. These options provide the facility to order post lists by date, title, random and admin post order by ascending or descending.', 'divi_flash'),
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
            'multi_filter_dropdown_placeholder_prefix' => array(
				'label'            => esc_html__( 'Multi Filter Dropdown Placeholder Prefix Text', 'divi_flash' ),
				'type'             => 'text',
				'description'      => esc_html__( 'Choose how much posts you would like to display per page.', 'divi_flash' ),
				'toggle_slug'      => 'settings',
                'show_if'         => array(
					'post_display' => array('multiple_filter'),
				),
                'default' => 'All'
            ),
            'use_search_bar'    => array(
                'label'             => esc_html__('Search Filter', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings',
                'tab_slug'		    => 'general'
            ),

            'search_bar_button_text'    => array(
                'label'             => esc_html__('Search Button Text', 'divi_flash'),
                'type'              => 'text',
                'default'           => esc_html__('Search', 'divi_flash'),
                'toggle_slug'       => 'settings',
                'tab_slug'		    => 'general',
                'show_if'           => array(
                    'use_search_bar' => 'on'
                )
            ),
            'search_bar_placeholder_text'    => array(
                'label'             => esc_html__('Search Placeholder Text', 'divi_flash'),
                'type'              => 'text',
                'toggle_slug'       => 'settings',
                'tab_slug'          => 'general',
                'show_if'           => array(
                    'use_search_bar'      => 'on'
                )
            ),

            'use_empty_post_message'    => array(
                'label'             => esc_html__('Empty Post Message', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings',
                'tab_slug'		    => 'general'
            ),

            'empty_post_message'    => array(
                'label'             => esc_html__('Custom Empty Post Message', 'divi_flash'),
                'type'              => 'text',
                'toggle_slug'       => 'settings',
                'tab_slug'		    => 'general',
                'show_if'           => array(
                    'use_empty_post_message' => 'on'
                )
            ),

            'use_load_more'    => array(
                'label'             => esc_html__('Load More Button', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings',
                'tab_slug'		    => 'general'
            ),
            'use_load_more_text'    => array(
                'label'             => esc_html__('Load More Text', 'divi_flash'),
                'type'              => 'text',
                'default'           => 'Load More',
                'toggle_slug'       => 'settings',
                'tab_slug'		    => 'general',
                'show_if'           => array(
                    'use_load_more' => 'on'
                )
            ),
            'all_items'    => array(
                'label'             => esc_html__('All Items', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings',
                'tab_slug'		    => 'general',
                'show_if_not'         => array(
					'post_display' => array('multiple_filter')
				)
            ),
            'all_items_text'    => array(
                'label'             => esc_html__('All Item Button Text', 'divi_flash'),
                'type'              => 'text',
                'default'           => 'All',
                'toggle_slug'       => 'settings',
                'tab_slug'		    => 'general',
                'show_if'           => array(
                    'all_items'     => 'on'
                ),
                'show_if_not'         => array(
					'post_display' => array('multiple_filter')
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
	    $settings = array_merge( $this->df_acf_filter_fields, $this->df_acf_filter_field_options, $this->df_multi_filter_acf_field_type, $settings );
	    $loader_settings = array(
		    'loader_spining'              => array(
			    'label'       => esc_html__( 'Loader Spinner', 'divi_flash' ),
			    'type'        => 'yes_no_button',
			    'options'     => array(
				    'on'  => esc_html__( 'On', 'divi_flash' ),
				    'off' => esc_html__( 'Off', 'divi_flash' )
			    ),
			    'default'     => 'off',
			    'toggle_slug' => 'loader_settings',
			    'tab_slug'    => 'advanced',
		    ),
		    'loader_spinning_type'        => array(
			    'label'       => esc_html__( 'Type', 'divi_flash' ),
			    'type'        => 'select',
			    'options'     => array(
//				    'classic'    => esc_html__( 'Classic', 'divi_flash' ),
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
			    'default'     => 'spinner_1',
			    'toggle_slug' => 'loader_settings',
			    'tab_slug'    => 'advanced',
			    'show_if'     => array(
				    'loader_spining' => 'on'
			    )
		    ),
		    'loader_spinning_color'        => array(
			    'label'       => esc_html__( 'Spinner Color', 'divi_flash' ),
			    'type'        => 'color-alpha',
			    'toggle_slug' => 'loader_settings',
			    'tab_slug'    => 'advanced',
			    'hover'       => 'tabs',
			    'show_if'     => array(
				    'loader_spining' => 'on'
			    )
		    ),
		    'loader_spinning_bg_color'    => array(
			    'label'       => esc_html__( 'Secondary Color', 'divi_flash' ),
			    'type'        => 'color-alpha',
			    'default'     => '#ADD8E6',
			    'tab_slug'    => 'advanced',
			    'toggle_slug' => 'loader_settings',
			    'show_if'     => array(
				    'loader_spining'  => 'on',
				    'loader_spinning_type'    => array( 'spinner_1', 'blob_1' )
			    ),
		    ),
		    'loader_spining_size'         => array(
			    'label'          => esc_html__( 'Spinner Size', 'divi_flash' ),
			    'type'           => 'range',
			    'toggle_slug'    => 'loader_settings',
			    'tab_slug'       => 'advanced',
			    'default'           => '30px',
			    'responsive'     => true,
			    'mobile_options' => true,
			    'validate_unit'  => true,
			    'allowed_units'  => array( 'px' ),
			    'range_settings' => array(
				    'min'  => '0',
				    'max'  => '100',
				    'step' => '1',
			    ),
			    'show_if'        => array(
				    'loader_spining' => 'on'
			    )
		    ),
		    'loader_spinning_alignment'   => array(
			    'label'           => esc_html__( 'Alignment', 'divi_flash' ),
			    'type'            => 'multiple_buttons',
			    'options'         => array(
				    'left'   => array(
					    'title' => esc_html__( 'Left', 'divi_flash' ),
					    'icon'  => 'align-left', // Any svg icon that is defined on ETBuilderIcon component
				    ),
				    'center' => array(
					    'title' => esc_html__( 'Center', 'divi_flash' ),
					    'icon'  => 'align-center', // Any svg icon that is defined on ETBuilderIcon component
				    ),
				    'right'  => array(
					    'title' => esc_html__( 'Right', 'divi_flash' ),
					    'icon'  => 'align-right', // Any svg icon that is defined on ETBuilderIcon component
				    ),
			    ),
			    'default'         => 'center',
			    'toggleable'      => true,
			    'multi_selection' => false,
			    'tab_slug'        => 'advanced',
			    'toggle_slug'     => 'loader_settings',
			    'description'     => esc_html__( 'You can control the loader alignment', 'divi_flash' ),
			    'show_if'         => array(
				    'loader_spining' => 'on'
			    ),
		    ),
		    'loader_spinning_margin'               => array(
			    'label'       => esc_html__( 'Margin', 'divi_flash' ),
			    'type'        => 'custom_margin',
			    'tab_slug'    => 'advanced',
			    'toggle_slug' => 'loader_settings',
			    'show_if'     => array(
				    'loader_spining'  => 'on'
			    ),
		    ),
		    'loader_spining_top_position' => array(
			    'label'          => esc_html__( 'Spinner Distance From Top', 'divi_flash' ),
			    'type'           => 'range',
			    'toggle_slug'    => 'loader_settings',
			    'tab_slug'       => 'advanced',
			     'default'           => '30%',
			    'default_unit'      => '%',
			    'responsive'     => true,
			    'mobile_options' => true,
			    'validate_unit'  => true,
			    'allowed_units'  => array( '%', 'px' ),
			    'range_settings' => array(
				    'min'  => '0',
				    'max'  => '100',
				    'step' => '1',
			    ),
			    'show_if'        => array(
				    'loader_spining' => 'on'
			    )
		    ),


		    'loader_overlay' => array(
			    'label'       => esc_html__( 'Loader Overlay', 'divi_flash' ),
			    'type'        => 'yes_no_button',
			    'options'     => array(
				    'on'  => esc_html__( 'On', 'divi_flash' ),
				    'off' => esc_html__( 'Off', 'divi_flash' )
			    ),
			    'default'     => 'off',
			    'toggle_slug' => 'loader_settings',
			    'tab_slug'    => 'advanced',
			    // 'show_if'  => array(
			    //     'loader_spining' => 'on'
			    // )
		    ),
	    );
        $layout = array(
            'layout'   => array(
                'label'             => esc_html__('Layout', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'fitRows'       => esc_html__('Grid', 'divi_flash'),
                    'masonry'       => esc_html__('Masonry', 'divi_flash')
                ),
                'default'           => 'fitRows',
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
        $filter_buttons = array(
            'filter_button_align' => array (
                'label'             => esc_html__( 'Alignment', 'divi_flash' ),
				'type'              => 'select',
				'options'           => array(
                    'center' => 'Center',
                    'flex-start' => 'Left',
                    'flex-end' => 'Right',
                    'space-between' => 'Justified'
                ),
                'default'           => 'center',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'filter_buttons',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'filter_nav_gap'   => array (
                'label'             => esc_html__( 'Gap', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'filter_buttons',
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
                ),
                'show_if_not' => array(
                    'filter_button_align' => 'space-between'
                )
            ),
        );
        $filter_buttons_bg = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'filter_buttons',
            'toggle_slug'           => 'filter_buttons',
            'tab_slug'              => 'advanced'
        ));
        $filter_button_spacing = $this->add_margin_padding(array(
            'title'         => 'Buttons',
            'key'           => 'filter_buttons',
            'toggle_slug'   => 'filter_buttons',
            'priority'      => 90
        ));
        $active_filter_button_bg = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'filter_button_active',
            'toggle_slug'           => 'filter_button_active',
            'tab_slug'              => 'advanced'
        ));
	    $active_filter_container = array(
		    "filter_button_active_container_header"                    => array(
			    'label'       => 'Header Background Color',
			    'type'        => 'color-alpha',
			    'default'     => '#ffffff',
			    'sub_toggle'  => 'container',
			    'toggle_slug' => 'filter_button_active_container',
			    'tab_slug'    => 'advanced',
			    'show_if'     => array(
				    'enable_mobile_responsive'                 => 'on',
				    'enable_mobile_responsive_view_on_builder' => 'on'
			    )
		    ),
		    "filter_button_active_container_header_cls_btn_icon_color" => array(
			    'label'       => 'Header Close Button Icon Color',
			    'type'        => 'color-alpha',
			    'default'     => '#ffffff',
			    'sub_toggle'  => 'container',
			    'toggle_slug' => 'filter_button_active_container',
			    'tab_slug'    => 'advanced',
			    'show_if'     => array(
				    'enable_mobile_responsive'                 => 'on',
				    'enable_mobile_responsive_view_on_builder' => 'on'
			    )
		    ),
		    "filter_button_active_container_header_cls_btn_bg"         => array(
			    'label'       => 'Header Close Button Background Color',
			    'type'        => 'color-alpha',
			    'default'     => '#727272',
			    'sub_toggle'  => 'container',
			    'toggle_slug' => 'filter_button_active_container',
			    'tab_slug'    => 'advanced',
			    'show_if'     => array(
				    'enable_mobile_responsive'                 => 'on',
				    'enable_mobile_responsive_view_on_builder' => 'on'
			    )
		    ),
		    "filter_button_active_container_footer"                    => array(
			    'label'       => 'Footer Background Color',
			    'type'        => 'color-alpha',
			    'default'     => '#ffffff',
			    'sub_toggle'  => 'container',
			    'toggle_slug' => 'filter_button_active_container',
			    'tab_slug'    => 'advanced',
			    'show_if'     => array(
				    'enable_mobile_responsive'                 => 'on',
				    'enable_mobile_responsive_view_on_builder' => 'on'
			    )
		    ),
		    "filter_button_active_container_show"                      => array(
			    'label'       => 'Footer Show Button Background Color',
			    'type'        => 'color-alpha',
			    'default'     => '#445dc8',
			    'sub_toggle'  => 'container',
			    'toggle_slug' => 'filter_button_active_container',
			    'tab_slug'    => 'advanced',
			    'show_if'     => array(
				    'enable_mobile_responsive'                 => 'on',
				    'enable_mobile_responsive_view_on_builder' => 'on'
			    )
		    ),
		    "filter_button_active_container_cancel"                    => array(
			    'label'       => 'Footer Cancel Button Background Color',
			    'type'        => 'color-alpha',
			    'default'     => '#ffffff',
			    'sub_toggle'  => 'container',
			    'toggle_slug' => 'filter_button_active_container',
			    'tab_slug'    => 'advanced',
			    'show_if'     => array(
				    'enable_mobile_responsive'                 => 'on',
				    'enable_mobile_responsive_view_on_builder' => 'on'
			    )
		    )
	    );
        $active_filter_button_spacing = $this->add_margin_padding(array(
            'title'         => 'Active Button',
            'key'           => 'filter_button_active',
            'toggle_slug'   => 'filter_button_active',
            'priority'      => 90
        ));
        $multi_filter_input = array(
            'multi_filter_placement' => array(
				'label'             => esc_html__( 'Multi Filter Placement', 'divi_flash' ),
				'type'              => 'select',
				'options'           => array(
					'default' => esc_html__( 'Default', 'divi_flash' ),
					'left' => esc_html__( 'Left', 'divi_flash' ),
                    'right' => esc_html__( 'Right', 'divi_flash' )
				),
				'default'			=> 'default',
                'toggle_slug'       => 'multi_filter_container',
                'tab_slug'		    => 'advanced',
                'show_if'         => array(
					'post_display' => array('multiple_filter'),
				),
				'show_if_not'         => array(
					'post_display' => array('by_tax'),
                    'use_current_loop' => 'on'
				)
			),
            'multi_filter_item_in_row' => array(
	            'label'             => esc_html__( 'Multi Filter Item in Row', 'divi_flash' ),
	            'type'              => 'select',
	            'options'           => array(
		            '1' => esc_html__( '1', 'divi_flash' ),
		            '2' => esc_html__( '2', 'divi_flash' ),
		            '3' => esc_html__( '3', 'divi_flash' ),
		            '4' => esc_html__( '4', 'divi_flash' ),
		            '5' => esc_html__( '5', 'divi_flash' ),
		            '6' => esc_html__( '6', 'divi_flash' ),
	            ),
	            'default'			=> '3',
	            'toggle_slug'       => 'multi_filter_container',
	            'tab_slug'		    => 'advanced',
	            'show_if'         => array(
		            'post_display' => array('multiple_filter'),
		            'multi_filter_placement' => array('default'),
	            ),
	            'show_if_not'         => array(
		            'post_display' => array('by_tax'),
		            'use_current_loop' => 'on'
	            )
            ),
            'multi_filter_input_align' => array (
                'label'             => esc_html__( 'Alignment', 'divi_flash' ),
				'type'              => 'select',
				'options'           => array(
                    'center' => 'Center',
                    'flex-start' => 'Left',
                    'flex-end' => 'Right',
                    'space-between' => 'Justified'
                ),
                'default'           => 'center',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'multi_filter_container',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'multi_filter_placement' => array('default'),
                    'multi_filter_item_full_width' => array('off')
                )
            ),
            'multi_filter_container_width'   => array (
                'label'             => esc_html__( 'Multi Filter Container Width', 'divi_flash' ),
				'type'              => 'range',
                'toggle_slug'       => 'multi_filter_container',
                'tab_slug'		    => 'advanced',
				'default'           => '30',
                'default_unit'      => '%',
                'responsive'        => true,
                'mobile_options'    => true,
                'validate_unit'     => true,
                'allowed_units'     => array( '%' ),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
                ),
                'show_if'         => array(
					'post_display' => array('multiple_filter'),
                    'multi_filter_placement' => array('left', 'right')
				),
				'show_if_not'         => array(
					'post_display' => array('by_tax'),
                    'use_current_loop' => 'on'
				)
            ),
            'multi_filter_item_align' => array(
                'label'           => esc_html__('Vertical Alignment ', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'normal'     => esc_html__('Default' , 'divi_flash'),
                    'flex-start' => esc_html__('Start', 'divi_flash'),
                    'center'     => esc_html__('Center', 'divi_flash'),
                    'flex-end'   => esc_html__('End', 'divi_flash')
                ),
                'default'           => 'normal',
                'toggle_slug'       => 'multi_filter_container',
                'tab_slug'		    => 'advanced',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'multi_filter_placement'  => array('left', 'right')
                ),
                'description' => esc_html__('Choose Multi Filter Item Align', 'divi_flash')
            ),
            'multi_filter_item_full_width'    => array(
                'label'             => esc_html__('Dropdown Item Justify', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'multi_filter_container',
                'tab_slug'		    => 'advanced',
                'show_if'         => array(
					'post_display' => array('multiple_filter'),
                    'multi_filter_placement' => array('default')

				),
				'show_if_not'         => array(
					'post_display' => array('by_tax'),
                    'use_current_loop' => 'on'
				)
            ),
            'use_multi_filter_label'    => array(
                'label'             => esc_html__('Show Dropdown Label', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'multi_filter_container',
                'show_if'         => array(
					'post_display' => array('multiple_filter')
				),
				'show_if_not'         => array(
					'post_display' => array('by_tax'),
                    'use_current_loop' => 'on'
				)
            ),
            'prefix_multi_filter_label'    => array(
                'label'             => esc_html__('Label Prefix', 'divi_flash'),
                'type'              => 'text',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'multi_filter_container',
                'show_if'         => array(
					'post_display' => array('multiple_filter'),
                    'use_multi_filter_label' => 'on',
				),
				'show_if_not'         => array(
					'post_display' => array('by_tax'),
                    'use_current_loop' => 'on',
                    'enable_single_filter_label' => 'on'
				)
            ),

            'multi_filter_label_position' => array(
				'label'             => esc_html__( 'Label Position', 'divi_flash' ),
				'type'              => 'select',
				'options'           => array(
					'default'   => esc_html__( 'Default', 'divi_flash' ),
					'on_top' => esc_html__( 'On Top', 'divi_flash' ),
				),
				'default'			=> 'default',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'multi_filter_container',
                'show_if'         => array(
					'post_display' => array('multiple_filter'),
                    'multi_filter_placement' => array('default')
				),
				'show_if_not'         => array(
					'post_display' => array('by_tax'),
                    'use_current_loop' => 'on',
                    'enable_single_filter_label' => 'on'
				)
			),
   
            'enable_single_filter_label'    => array(
                'label'             => esc_html__('Use Single Label', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'multi_filter_container',
                'show_if'         => array(
					'post_display' => array('multiple_filter'),
                    'use_multi_filter_label' => array('on')
				),
				'show_if_not'         => array(
					'post_display' => array('by_tax'),
                    'use_current_loop' => 'on'
				)
            ),

            'single_label_text'    => array(
                'label'             => esc_html__('Single Label Text', 'divi_flash'),
                'type'              => 'text',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'multi_filter_container',
                'show_if'         => array(
					'post_display' => array('multiple_filter'),
                    'use_multi_filter_label' => 'on',
                    'enable_single_filter_label' =>'on'
				),
				'show_if_not'         => array(
					'post_display' => array('by_tax'),
                    'use_current_loop' => 'on'
				)
            ),
            
            'multi_filter_input_gap'   => array (
                'label'             => esc_html__( 'Filter Items Gap', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'multi_filter_container',
				'tab_slug'          => 'advanced',
				'default'           => '20px',
                'default_unit'      => 'px',
                'responsive'        => true,
                'mobile_options'    => true,
                'validate_unit'     => true,
                'allowed_units'     => array( 'px' ),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
                ),
                'show_if'         => array(
					'post_display' => array('multiple_filter')

				),
                'show_if_not' => array(
                    'multi_filter_input_align' => 'space-between'
                )
            ),

            'multi_filter_autocomplete_max_height'   => array (
                'label'             => esc_html__( 'Autocomplete min Height', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'multi_filter_input',
				'tab_slug'          => 'advanced',
				'default'           => '180px',
                'default_unit'      => 'px',
                'responsive'        => true,
                'mobile_options'    => true,
                'validate_unit'     => true,
                'allowed_units'     => array( 'px' ),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '300',
					'step' => '1',
                ),
                'show_if'         => array(
					'post_display' => array('multiple_filter')

				)
            ),

            'multi_filter_label_min_width'   => array (
                'label'             => esc_html__( 'Label Min Width', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'multi_filter_label',
				'tab_slug'          => 'advanced',
				'default'           => '150px',
                'default_unit'      => 'px',
                'responsive'        => true,
                'mobile_options'    => true,
                'validate_unit'     => true,
                'allowed_units'     => array( 'px' ),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '300',
					'step' => '1',
                ),
                'show_if'         => array(
					'post_display' => array('multiple_filter'),
                    'multi_filter_placement' => array('default'),
                    'multi_filter_item_full_width' => 'off'
				)
            ),

            'enable_mobile_responsive'    => array(
                'label'             => esc_html__('Mobile Responsive', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'on',
                'toggle_slug'       => 'multi_filter_container',
                'tab_slug'		    => 'advanced',
                'show_if'         => array(
                    'post_display' => array('multiple_filter')
                ),
                'show_if_not'         => array(
                    'post_display' => array('by_tax'),
                    'use_current_loop' => 'on'
                )
            ),
            'enable_mobile_responsive_view_on_builder'    => array(
	            'label'             => esc_html__('Enable Mobile Responsive View on Builder', 'divi_flash'),
	            'type'              => 'yes_no_button',
	            'options'           => array(
		            'off' => esc_html__('Off', 'divi_flash'),
		            'on'  => esc_html__('On', 'divi_flash'),
	            ),
	            'default'           => 'on',
	            'toggle_slug'       => 'multi_filter_container',
	            'tab_slug'		    => 'advanced',
	            'show_if'         => array(
		            'post_display' => array('multiple_filter'),
		            'enable_mobile_responsive' => 'on'
	            ),
	            'show_if_not'         => array(
		            'post_display' => array('by_tax'),
		            'use_current_loop' => 'on'
	            )
            ),

            'multi_filter_input_gap_for_mobile'   => array (
                'label'             => esc_html__( 'Filter Items Gap for Mobile', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'multi_filter_container',
				'tab_slug'          => 'advanced',
				'default'           => '20px',
                'default_unit'      => 'px',
                'validate_unit'     => true,
                'allowed_units'     => array( 'px' ),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
                ),
                'show_if'         => array(
					'post_display' => array('multiple_filter'),
                    'enable_mobile_responsive' => 'on'

				)
            ),

        );
        $multi_filter_container_bg = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'multi_filter_container_bg',
            'toggle_slug'           => 'multi_filter_container',
            'tab_slug'              => 'advanced',
            'show_if'       => array(
                'post_display' => array('multiple_filter')
            )
        ));
        $multi_filter_container_spacing = $this->add_margin_padding(array(
            'title'         => 'Multi Filter Container',
            'key'           => 'multi_filter_container',
            'toggle_slug'   => 'margin_padding',
            'default_margin' => '0px|0px|10px|0px',
            'show_if'       => array(
                'post_display' => array('multiple_filter')
            )
        ));
        $multi_filter_input_bg = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'multi_filter_input_bg',
            'toggle_slug'           => 'multi_filter_input',
            'tab_slug'              => 'advanced',
            'show_if'       => array(
                'post_display' => array('multiple_filter')
            )
        ));
        $multi_filter_input_spacing = $this->add_margin_padding(array(
            'title'         => 'Multi Filter Dropdown Field',
            'key'           => 'multi_filter_input',
            'toggle_slug'   => 'margin_padding',
            'priority'      => 90,
            'default_padding' => '5px|5px|5px|5px',
            'show_if'       => array(
                'post_display' => array('multiple_filter')
            )
        ));
	    $multi_filter_dropdown_container_spacing = $this->add_margin_padding(array(
		    'title'         => 'Multi Filter Dropdown',
		    'key'           => 'multi_filter_dropdown_container',
		    'toggle_slug'   => 'margin_padding',
		    'priority'      => 90,
		    'default_padding' => '5px|5px|5px|5px',
		    'show_if'       => array(
			    'post_display' => array('multiple_filter')
		    )
	    ));
        $multi_filter_label_spacing = $this->add_margin_padding(array(
            'title'         => 'Multi Filter Label',
            'key'           => 'multi_filter_label',
            'toggle_slug'   => 'margin_padding',
            'priority'      => 90,
            'default_padding' => '5px|5px|5px|5px',
            'show_if'               => array(
                'post_display' => array('multiple_filter')
            )
        ));

        $multi_filter_label_bg = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'multi_filter_label_bg',
            'toggle_slug'           => 'multi_filter_label',
            'tab_slug'              => 'advanced',
            'show_if'               => array(
                'post_display' => array('multiple_filter'),
                'use_multi_filter_label' => 'on'
            )
        ));

	    $multi_filter_checkbox_field_bg = $this->df_add_bg_field(array (
		    'label'				    => 'Background',
		    'key'                   => 'multi_filter_checkbox_field_bg',
		    'toggle_slug'           => 'multi_filter_checkbox_field',
		    'tab_slug'              => 'advanced',
		    'show_if'       => array(
			    'post_display' => array('multiple_filter')
		    )
	    ));
	    $multi_filter_checkbox_field_spacing = $this->add_margin_padding(array(
		    'title'         => 'Multi Filter Checkbox',
		    'key'           => 'multi_filter_checkbox_field',
		    'toggle_slug'   => 'margin_padding',
		    'priority'      => 90,
		    'default_padding' => '5px|5px|5px|5px',
		    'show_if'       => array(
			    'post_display' => array('multiple_filter')
		    )
	    ));
		$multi_filter_checkbox_field_checkbox_item = array(
			'multi_filter_checkbox_field_checkbox_item_gap'        => array(
				'label'          => esc_html__( 'Checkbox Item Gap', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'multi_filter_checkbox_field',
				'tab_slug'       => 'advanced',
				'default'        => '8px',
				'default_unit'   => 'px',
				'responsive'     => true,
				'mobile_options' => true,
				'validate_unit'  => true,
				'allowed_units'  => array( 'px' ),
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'        => array(
					'post_display' => array( 'multiple_filter' )

				)
			),
			'multi_filter_checkbox_field_checkbox_item_space_left' => array(
				'label'          => esc_html__( 'Checkbox Item Space Left', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'multi_filter_checkbox_field',
				'tab_slug'       => 'advanced',
				'default'        => '10px',
				'default_unit'   => 'px',
				'responsive'     => true,
				'mobile_options' => true,
				'validate_unit'  => true,
				'allowed_units'  => array( 'px' ),
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'        => array(
					'post_display' => array( 'multiple_filter' )

				)
			),
			'multi_filter_checkbox_field_checkbox_size'            => array(
				'label'          => esc_html__( 'Checkbox Size', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'multi_filter_checkbox_field',
				'tab_slug'       => 'advanced',
				'default'        => '25px',
				'default_unit'   => 'px',
				'responsive'     => true,
				'mobile_options' => true,
				'validate_unit'  => true,
				'allowed_units'  => array( 'px' ),
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'        => array(
					'post_display' => array( 'multiple_filter' )

				)
			),
			'multi_filter_checkbox_field_checkbox_text_space_left' => array(
				'label'          => esc_html__( 'Checkbox Item Text Left Spacing', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'multi_filter_checkbox_field',
				'tab_slug'       => 'advanced',
				'default'        => '35px',
				'default_unit'   => 'px',
				'responsive'     => true,
				'mobile_options' => true,
				'validate_unit'  => true,
				'allowed_units'  => array( 'px' ),
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'        => array(
					'post_display' => array( 'multiple_filter' )

				)
			),
			'multi_filter_checkbox_field_checkbox_checked_color'   => array(
				'label'       => esc_html__( 'Checkbox Checked Color', 'divi_flash' ),
				'type'        => 'color-alpha',
				'default'     => '#2196F3',
				'toggle_slug' => 'multi_filter_checkbox_field',
				'tab_slug'    => 'advanced',
				'show_if'     => array(
					'post_display' => array( 'multiple_filter' )

				)
			),
		);

	    $multi_filter_range = array(
		    'multi_filter_range_bg'                  => array(
			    'label'       => esc_html__( 'Background', 'divi_flash' ),
			    'type'        => 'color-alpha',
			    'default'     => '#e1e4e9',
			    'toggle_slug' => 'multi_filter_range_field',
			    'tab_slug'    => 'advanced',
			    'show_if'     => array(
				    'post_display' => array( 'multiple_filter' )

			    )
		    ),
		    'multi_filter_range_active_color'        => array(
			    'label'       => esc_html__( 'Active Color', 'divi_flash' ),
			    'type'        => 'color-alpha',
			    'default'     => '#ed5565',
			    'toggle_slug' => 'multi_filter_range_field',
			    'tab_slug'    => 'advanced',
			    'show_if'     => array(
				    'post_display' => array( 'multiple_filter' )

			    )
		    ),
		    'multi_filter_range_active_border_color' => array(
			    'label'       => esc_html__( 'Active Border Color', 'divi_flash' ),
			    'type'        => 'color-alpha',
			    'default'     => '#da4453',
			    'toggle_slug' => 'multi_filter_range_field',
			    'tab_slug'    => 'advanced',
			    'show_if'     => array(
				    'post_display' => array( 'multiple_filter' )

			    )
		    ),
		    'multi_filter_range_tooltip_bg'          => array(
			    'label'       => esc_html__( 'Tooltip Background', 'divi_flash' ),
			    'type'        => 'color-alpha',
			    'default'     => '#ed5565',
			    'toggle_slug' => 'multi_filter_range_field',
			    'tab_slug'    => 'advanced',
			    'show_if'     => array(
				    'post_display' => array( 'multiple_filter' )

			    )
		    ),
		    'multi_filter_range_min_max_bg'          => array(
			    'label'       => esc_html__( 'Min Max Background', 'divi_flash' ),
			    'type'        => 'color-alpha',
			    'default'     => '#e1e4e9',
			    'toggle_slug' => 'multi_filter_range_field',
			    'tab_slug'    => 'advanced',
			    'show_if'     => array(
				    'post_display' => array( 'multiple_filter' )

			    )
		    ),
		    'multi_filter_range_label_min_width'     => array(
			    'label'          => esc_html__( 'Label Min Width', 'divi_flash' ),
			    'type'           => 'range',
			    'toggle_slug'    => 'multi_filter_range_label',
			    'sub_toggle'     => 'range_label',
			    'tab_slug'       => 'advanced',
			    'default'        => '50px',
			    'default_unit'   => 'px',
			    'responsive'     => true,
			    'mobile_options' => true,
			    'validate_unit'  => true,
			    'allowed_units'  => array( 'px' ),
			    'range_settings' => array(
				    'min'  => '0',
				    'max'  => '300',
				    'step' => '1',
			    ),
			    'show_if'        => array(
				    'post_display'                 => array( 'multiple_filter' ),
				    'multi_filter_placement'       => array( 'default' ),
				    'multi_filter_item_full_width' => 'off'
			    )
		    ),
	    );
	    $multi_filter_range_label_bg = $this->df_add_bg_field( array(
		    'label'       => 'Background',
		    'key'         => 'multi_filter_range_label_bg',
		    'toggle_slug' => 'multi_filter_range_label',
		    'sub_toggle'  => 'range_label',
		    'tab_slug'    => 'advanced',
		    'show_if'     => array(
			    'post_display'           => array( 'multiple_filter' )
		    )
	    ) );

        $load_more = array(
            'load_more_align' => array (
                'label'             => esc_html__( 'Alignment', 'divi_flash' ),
				'type'              => 'select',
				'options'           => array(
                    'center' => 'Center',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
                'default'           => 'left',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'load_more',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'full_width_load_more'   => array(
                'label'             => esc_html__('Full Width Button', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'on'            => esc_html__('On', 'divi_flash'),
                    'off'           => esc_html__('Off', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'load_more',
                'tab_slug'          => 'advanced'
            ),
            'use_load_more_icon'    => array(
                'label'             => esc_html__('Use Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'load_more',
                'tab_slug'          => 'advanced'
            ),
            'load_more_font_icon'             => array(
				'label'             => esc_html__( 'Icon', 'divi_flash' ),
				'type'              => 'select_icon',
				'option_category'   => 'basic_option',
				'class'             => array( 'et-pb-font-icon' ),
                'toggle_slug'       => 'load_more',
                'tab_slug'          => 'advanced',
                'show_if'           => array(
                    'use_load_more_icon'      => 'on'
                )
            ),
            'load_more_icon_pos'    => array(
                'label'             => esc_html__('Icon Position', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'right' => esc_html__('Right', 'divi_flash'),
                    'left'  => esc_html__('Left', 'divi_flash'),
                ),
                'default'           => 'right',
                'toggle_slug'       => 'load_more',
                'tab_slug'          => 'advanced',
                'show_if'           => array(
                    'use_load_more_icon'      => 'on'
                )
            )
        );
        $search_bar_settings = array(
            'search_input_width' => array(
                'label'             => esc_html__('Search Input Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'     => 'search_bar',
                'tab_slug'        => 'advanced',
                'default'           => '200px',
                'allowed_units'     => array('px', '%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '1000',
                    'step' => '1'
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'use_search_bar'      => 'on'
                )
            ),
            'search_bar_align'  => array(
                'label'           => esc_html__('Search Alignment', 'divi_flash'),
                'type'            => 'text_align',
                'option_category' => 'configuration',
                'options'         => et_builder_get_text_orientation_options(
                    array('justified')
                ),
                'toggle_slug'     => 'search_bar',
                'tab_slug'        => 'advanced',
                'default'         => 'center',
                'options_icon'    => 'module_align',
                'mobile_options'  => true,
                'show_if'           => array(
                    'use_search_bar'      => 'on'
                )
            ),
            'use_search_bar_icon'    => array(
                'label'             => esc_html__('Use Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'search_bar_button',
                'tab_slug'          => 'advanced',
                'show_if'           => array(
                    'use_search_bar'      => 'on'
                )
            ),
            'search_bar_font_icon'             => array(
				'label'             => esc_html__( 'Icon', 'divi_flash' ),
				'type'              => 'select_icon',
				'option_category'   => 'basic_option',
				'class'             => array( 'et-pb-font-icon' ),
                'toggle_slug'       => 'search_bar_button',
                'tab_slug'          => 'advanced',
                'show_if'           => array(
                    'use_search_bar_icon'      => 'on',
                    'use_search_bar'      => 'on'
                )
            ),
            'search_button_icon_size' => array(
                'label'             => esc_html__('Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'search_bar_button',
                'tab_slug'          => 'advanced',
                'default'           => '14px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'use_search_bar_icon'      => 'on',
                    'use_search_bar'      => 'on'
                )
            ),
            'search_button_icon_color' => array(
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
                'toggle_slug'       => 'search_bar_button',
                'tab_slug'          => 'advanced',
                'hover'             => 'tabs',
                'show_if'           => array(
                    'use_search_bar_icon'      => 'on',
                    'use_search_bar'      => 'on'
                )
            ),
            'search_button_icon_placement'   => array(
                'label'             => esc_html__('Icon Placement', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'left'          => esc_html__('Left', 'divi_flash'),
                    'right'         => esc_html__('Right', 'divi_flash')
                ),
                'default'           => 'right',
                'toggle_slug'       => 'search_bar_button',
                'tab_slug'          => 'advanced',
                'show_if'           => array(
                    'use_search_bar_icon'      => 'on',
                    'use_search_bar'      => 'on',
                    'use_only_search_bar_icon' => 'off'
                ),
              
            ),
            'use_only_search_bar_icon'    => array(
                'label'             => esc_html__('Show Only Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'search_bar_button',
                'tab_slug'          => 'advanced'
            )
            
        );
        $search_bar_input_background = $this->df_add_bg_field(array (
			'label'				    => 'Input Background',
            'key'                   => 'search_bar_input_background',
            'toggle_slug'           => 'search_bar',
            'tab_slug'              => 'advanced',
            'show_if'               => array(
                'use_search_bar' => 'on'
            )
        ));

        $search_bar_button_background = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'search_bar_button_background',
            'toggle_slug'           => 'search_bar_button',
            'tab_slug'              => 'advanced',
            'show_if'               => array(
                'use_search_bar' => 'on'
            )
        ));

        $search_bar_input_spacing = $this->add_margin_padding(array(
            'title'         => 'Search Input',
            'key'           => 'search_bar_input',
            'toggle_slug'   => 'margin_padding',
            'default_padding'=> '5px|5px|5px|5px',
            'option'        => 'padding'
        ));
        $search_bar_button_spacing = $this->add_margin_padding(array(
            'title'         => 'Search Button',
            'key'           => 'search_bar_button',
            'toggle_slug'   => 'margin_padding',
            'default_padding'=> '10px|10px|10px|10px'
        ));
        $load_more_background = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'load_more_background',
            'toggle_slug'           => 'load_more',
            'tab_slug'              => 'advanced'
        ));

        $loader_background = $this->df_add_bg_field(array (
			'label'				    => 'Loader Overlay Background',
            'key'                   => 'loader_background',
            'toggle_slug'           => 'loader_settings',
            'tab_slug'              => 'advanced',
            'image'                 => false,
            'show_if'  => array(
                'loader_overlay' => 'on'
            )
        ));

        $load_more_spacing = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'load_more',
            'toggle_slug'   => 'load_more'
        ));
        $item_outer_background = $this->df_add_bg_field(array (
			'label'				    => 'Item Background',
            'key'                   => 'item_outer_background',
            'toggle_slug'           => 'item_outer_background',
            'tab_slug'              => 'general'
        ));
        $item_inner_background = $this->df_add_bg_field(array (
			'label'				    => 'Item Background',
            'key'                   => 'item_inner_background',
            'toggle_slug'           => 'item_inner_background',
            'tab_slug'              => 'general'
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
            'toggle_slug'   => 'margin_padding'
        ));
        $search_bar_wrapper_background = $this->df_add_bg_field(array (
			'label'				    => 'Background',
            'key'                   => 'search_bar_wrapper_background',
            'toggle_slug'           => 'search_bar_wrapper_background',
            'tab_slug'              => 'general',
            'show_if'               => array(
                'use_search_bar'    => 'on'
            )
        ));
        $search_bar_wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Search Wrapper',
            'key'           => 'search_bar_wrapper',
            'toggle_slug'   => 'margin_padding',
            'show_if'               => array(
                'use_search_bar'    => 'on'
            ),
            'default_padding'=> '5px|0px|5px|0px'
        ));
        $search_bar_button_icon_spacing = $this->add_margin_padding(array(
            'title'         => 'Search Button Icon',
            'key'           => 'search_bar_button_icon',
            'toggle_slug'   => 'margin_padding',
            'show_if'               => array(
                'use_search_bar'     => 'on',
                'use_search_bar_icon'=> 'on',
            ),
            'option'       => 'margin',
            'default_margin'=> '0px|4px|0px|4px'
        ));

        return array_merge(
            $post_type,
            $settings,
            $alignment,
            $layout,
            $filter_buttons_bg,
            $filter_buttons,
            $filter_button_spacing,
            $active_filter_button_bg,
            $active_filter_button_spacing,
	        $active_filter_container,
            $visibility,
            $multi_filter_container_bg,
            $multi_filter_input_bg,
            $multi_filter_label_bg,
            $multi_filter_input,
	        $multi_filter_dropdown_container_spacing,
	        $multi_filter_checkbox_field_bg,
	        $multi_filter_checkbox_field_spacing,
	        $multi_filter_checkbox_field_checkbox_item,
	        $multi_filter_range,
	        $multi_filter_range_label_bg,
            $search_bar_wrapper_background,
            $search_bar_input_background,
            $search_bar_button_background,
            $search_bar_settings,
            $load_more,
            $load_more_background,
            $load_more_spacing,
            $item_outer_background,
            $item_inner_background,
            $wrapper_spacing,
            $item_wrapper_spacing,
            $item_spacing,
            $search_bar_wrapper_spacing,
            $search_bar_input_spacing,
            $search_bar_button_spacing,
            $search_bar_button_icon_spacing,
            $multi_filter_container_spacing,
            $multi_filter_input_spacing,
            $multi_filter_label_spacing,
            $loader_settings,
            $loader_background
        );
    }

    public function before_render() {
        $this->props['equal_height__hover'] = '1px||||false|false';
        $this->props['equal_height__hover_enabled'] = 'on|hover';
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $filter_buttons_item = '%%order_class%% .df-cpt-filter-nav-item';
        $blog_item = '%%order_class%% .df-cpt-inner-wrap';
        $load_more = '%%order_class%% .df-cptfilter-load-more';
        $multi_filter_container = '%%order_class%% .filter_section';
        $multi_filter_input= '%%order_class%% .filter_section li select';
	    $multi_filter_dropdown_container= '%%order_class%% .filter_section li .dropdown-container';
        $multi_filter_label= '%%order_class%% .filter_section ul li span.multi_filter_label';
        $multi_filter_range_label= '%%order_class%% .filter_section ul li span.multi_filter_range_label';
        $multi_filter_checkbox_field= '%%order_class%% .filter_section li .checkbox_container';
        $search_bar_wrapper = '%%order_class%% .search_bar';
        $search_bar_input= '%%order_class%% .search_bar .df_search_filter_input';
        $search_bar_button= '%%order_class%% .search_bar .search_bar_button';
        $search_bar_button_icon= '%%order_class%% .search_bar .search_icon';

        $fields['item_wrapper_padding'] = array ('padding' => '%%order_class%% .df-cpt-outer-wrap');
        $fields['item_margin'] = array ('margin' => $blog_item);
        $fields['item_padding'] = array ('padding' => $blog_item);

        $fields['wrapper_margin'] = array ('margin' => '%%order_class%% .df-cpts-wrap');
        $fields['wrapper_padding'] = array ('padding' => '%%order_class%% .df-cpts-wrap');

        $fields['filter_buttons_margin'] = array ('margin' => $filter_buttons_item);
        $fields['filter_buttons_padding'] = array ('padding' => $filter_buttons_item);
        
        $fields['multi_filter_container_margin'] = array ('margin' => $multi_filter_container);
        $fields['multi_filter_container_padding'] = array ('padding' => $multi_filter_container);

        $fields['multi_filter_input_margin'] = array ('margin' => $multi_filter_input);
        $fields['multi_filter_input_padding'] = array ('padding' => $multi_filter_input);

	    $fields['multi_filter_dropdown_container_margin'] = array ('margin' => $multi_filter_dropdown_container);
	    $fields['multi_filter_dropdown_container_padding'] = array ('padding' => $multi_filter_dropdown_container);

        $fields['multi_filter_label_margin'] = array ('margin' => $multi_filter_label);
        $fields['multi_filter_label_padding'] = array ('padding' => $multi_filter_label);

	    $fields['multi_filter_checkbox_field_margin'] = array ('margin' => $multi_filter_checkbox_field);
	    $fields['multi_filter_checkbox_field_padding'] = array ('padding' => $multi_filter_checkbox_field);
         
        $fields['load_more_margin'] = array ('margin' => $load_more);
        $fields['load_more_padding'] = array ('padding' => $load_more);

        $fields['search_bar_wrapper_margin'] = array ('margin' => $search_bar_wrapper);
        $fields['search_bar_wrapper_padding'] = array ('padding' => $search_bar_wrapper);
        $fields['search_bar_button_icon_margin'] = array ('margin' => $search_bar_button_icon);
        $fields['search_bar_button_padding'] = array ('padding' => $search_bar_button);
        $fields['search_bar_button_margin'] = array ('margin' => $search_bar_button);
        $fields['search_bar_input_padding'] = array ('padding' => $search_bar_input);

        $fields['search_button_icon_color'] = array ('color' => $search_bar_button_icon);
        // background
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'filter_buttons',
            'selector'      => $filter_buttons_item
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'item_outer_background',
            'selector'      => '%%order_class%% .df-cpt-outer-wrap'
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'item_inner_background',
            'selector'      => $blog_item
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'load_more_background',
            'selector'      => $load_more
        ));

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'multi_filter_container_bg',
            'selector'      => $multi_filter_container
        ));
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'multi_filter_input_bg',
            'selector'      => $multi_filter_input
        ));

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'multi_filter_label_bg',
            'selector'      => $multi_filter_label
        ));

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'multi_filter_range_label_bg',
            'selector'      => $multi_filter_range_label
        ));

	    $fields = $this->df_background_transition(array (
		    'fields'        => $fields,
		    'key'           => 'multi_filter_checkbox_field_bg',
		    'selector'      => $multi_filter_checkbox_field
	    ));

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'search_bar_wrapper_background',
            'selector'      => $search_bar_wrapper
        ));

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'search_bar_input_background',
            'selector'      => $search_bar_input
        ));

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'search_bar_button_background',
            'selector'      => $search_bar_button
        ));

        // border
        $fields = $this->df_fix_border_transition(
            $fields, 
            'filter_buttons', 
            $filter_buttons_item
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'multi_filter_container', 
            $multi_filter_container
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'multi_filter_input', 
            $multi_filter_input
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'multi_filter_label', 
            $multi_filter_label
        );
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
            'load_more', 
            $load_more
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'search_bar_input', 
            $search_bar_input
        );
        $fields = $this->df_fix_border_transition(
            $fields, 
            'search_bar_button', 
            $search_bar_button
        );

        // box-shadow
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'filter_buttons',
            $filter_buttons_item
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'multi_filter_container',
            $multi_filter_container
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'multi_filter_input',
            $multi_filter_input
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'multi_filter_label',
            $multi_filter_label
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'search_bar_input',
            $search_bar_input
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'search_bar_button',
            $search_bar_button
        );
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
            'load_more',
            $load_more
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

        // spacing
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
            'slug'              => "item_outer_background",
            'selector'          => "%%order_class%% .df-cpt-outer-wrap",
            'hover'             => "%%order_class%% .df-hover-trigger.df-cpt-outer-wrap:hover "
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "item_inner_background",
            'selector'          => "%%order_class%% .df-cpt-inner-wrap",
            'hover'             => "%%order_class%% .df-hover-trigger:hover .df-cpt-inner-wrap"
        ));
        // column
        if(isset($this->props['column']) && $this->props['column'] !== '') {
            $column_desktop = round(100 / intval($this->props['column']), 2) . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-cpt-item',
                'declaration' => sprintf('width: %1$s;', $column_desktop)
            ));
        }
        if(isset($this->props['column_tablet']) && $this->props['column_tablet'] !== '') {
            $column_tablet = round(100 / intval($this->props['column_tablet']), 2) . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-cpt-item',
                'declaration' => sprintf('width: %1$s;', $column_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }
        if(isset($this->props['column_phone']) && $this->props['column_phone'] !== '') {
            $column_phone = round(100 / intval($this->props['column_phone']), 2) . '%';
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
                'selector' => '%%order_class%% .df_cptfilter_container .df-cpts-inner-wrap',
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
                'selector' => '%%order_class%% .df_cptfilter_container .df-cpts-inner-wrap',
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
                'selector' => '%%order_class%% .df_cptfilter_container .df-cpts-inner-wrap',
                'declaration' => sprintf('margin-left: -%1$spx; margin-right: -%1$spx;', $gutter_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

        // Filter Buttons
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "filter_buttons",
            'selector'          => "%%order_class%% .df-cpt-filter-nav-item",
            'hover'             => "%%order_class%% .df-cpt-filter-nav-item:hover"
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'filter_button_align',
            'type'              => 'justify-content',
            'selector'          => '%%order_class%% .df-cpt-filter-nav',
            'important'         => false,
            'default'           => 'center'
        ));
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'filter_nav_gap',
            'type'              => 'gap',
            'selector'          => '%%order_class%% .df-cpt-filter-nav',
            'unit'              => 'px',
            'important'         => false,
            'default'           => '20',
            'negative'          => false,
            'fixed_unit'        => 'px'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'filter_buttons_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-cpt-filter-nav-item',
            'hover'             => '%%order_class%% .df-cpt-filter-nav-item:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'filter_buttons_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-cpt-filter-nav-item',
            'hover'             => '%%order_class%% .df-cpt-filter-nav-item:hover',
        ));
        // active filter button
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "filter_button_active",
            'selector'          => "%%order_class%% .df-cpt-filter-nav-item.df-active, %%order_class%% .filter_section .filter_elements .filter_element_card",
            'hover'             => "%%order_class%% .df-cpt-filter-nav-item.df-active:hover, %%order_class%% .filter_section .filter_elements .filter_element_card:hover"
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'filter_button_active_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-cpt-filter-nav-item.df-active, %%order_class%% .filter_section .filter_elements .filter_element_card',
            'hover'             => '%%order_class%% .df-cpt-filter-nav-item.df-active:hover, %%order_class%% .filter_section .filter_elements .filter_element_card:hover'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'filter_button_active_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-cpt-filter-nav-item.df-active, %%order_class%% .filter_section .filter_elements .filter_element_card',
            'hover'             => '%%order_class%% .df-cpt-filter-nav-item.df-active:hover, %%order_class%% .filter_section .filter_elements .filter_element_card:hover'
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

         // Multi Filter Input

         $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "multi_filter_input_bg",
            'selector'          => "%%order_class%% .filter_section li select ,%%order_class%% .filter_section li .multi-select-component",
            'hover'             => "%%order_class%% .filter_section li select:hover, %%order_class%% .filter_section li .multi-select-component:hover"
        ));

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "multi_filter_label_bg",
            'selector'          => "%%order_class%% .filter_section ul li span.multi_filter_label",
            'hover'             => "%%order_class%% .filter_section ul li span.multi_filter_label:hover"
        ));
		$this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "multi_filter_range_label_bg",
            'selector'          => "%%order_class%% .filter_section li span.multi_filter_range_label",
            'hover'             => "%%order_class%% .filter_section li span.multi_filter_range_label:hover"
        ));
        if(isset($this->props['multi_filter_label_position']) && $this->props['multi_filter_label_position'] === 'on_top'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .filter_section ul li',
                'declaration' => 'display: flex; flex-direction:column;'
            ));
        }
        if($this->props['post_display'] === 'multiple_filter'){
            $this->df_process_string_attr(array(
                'render_slug'       => $render_slug,
                'slug'              => 'multi_filter_item_align',
                'type'              => 'align-items',
                'selector'          => '%%order_class%% .df_cptfilter_container.df_filter_sidebar ',
                'important'         => true
            ));
	        $this->df_process_bg(array (
		        'render_slug'       => $render_slug,
		        'slug'              => "multi_filter_checkbox_field_bg",
		        'selector'          => "%%order_class%% .filter_section li .checkbox_container",
		        'hover'             => "%%order_class%% .filter_section li .checkbox_container:hover"
	        ));
        }
        if($this->props['multi_filter_item_full_width'] === 'on'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .filter_section ul li, %%order_class%% .filter_section ul li select , %%order_class%% .filter_section ul li .multi_filter_label',
                'declaration' => 'width: 100%;'
            ));
        }

        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'multi_filter_input_align',
            'type'              => 'justify-content',
            'selector'          => '%%order_class%% .filter_section ul.multi_filter_container',
            'important'         => false,
            'default'           => 'center'
        ));
        if ( 'multiple_filter' === $this->props['post_display'] && 'default' === $this->props['multi_filter_placement']){
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'multi_filter_input_gap',
                'type'              => 'padding-right',
                'selector'          => '%%order_class%% .df_cptfilter_container:not(.df_filter_sidebar) ul.multi_filter_container > li:not(:last-child)',
                'unit'              => 'px',
                'important'         => false,
                'default'           => '20',
                'negative'          => false,
                'fixed_unit'        => 'px'
            ));
	        $this->df_process_range(array(
		        'render_slug'       => $render_slug,
		        'slug'              => 'multi_filter_input_gap',
		        'type'              => 'row-gap',
		        'selector'          => '%%order_class%% .df_cptfilter_container:not(.df_filter_sidebar) ul',
		        'unit'              => 'px',
		        'important'         => false,
		        'default'           => '20',
		        'negative'          => false,
		        'fixed_unit'        => 'px'
	        ));
            if($this->props['multi_filter_item_full_width'] === 'off'){
                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'multi_filter_label_min_width',
                    'type'              => 'min-width',
                    'selector'          => '%%order_class%% .df_cptfilter_container:not(.df_filter_sidebar) .filter_section ul li .multi_filter_label',
                    'unit'              => 'px',
                    'important'         => false,
                    'default'           => '120',
                    'negative'          => false,
                    'fixed_unit'        => 'px'
                ));
	            $this->df_process_range(array(
		            'render_slug'       => $render_slug,
		            'slug'              => 'multi_filter_range_label_min_width',
		            'type'              => 'min-width',
		            'selector'          => '%%order_class%% .df_cptfilter_container:not(.df_filter_sidebar) .filter_section ul li .multi_filter_range_label',
		            'unit'              => 'px',
		            'important'         => false,
		            'default'           => '50',
		            'negative'          => false,
		            'fixed_unit'        => 'px'
	            ));
            }
	        $multi_filter_item_in_row = isset($this->props['multi_filter_item_in_row']) ? $this->props['multi_filter_item_in_row'] : '3';
	        $flex = '25%';
	        $width = '24%';
			switch ($multi_filter_item_in_row){
				case '1':
					$flex = '100%';
					$width = '100%';
					break;
				case '2':
					$flex = '49%';
					$width = '50%';
					break;
				case '3':
					$flex = '32%';
					$width = '33.33%';
					break;
				case '5':
					$flex = '19%';
					$width = '20%';
					break;
				case '6':
					$flex = '16%';
					$width = '16.66%';
					break;
				default:
					$flex = '24%';
					$width = '25%';
					break;
			}
	        ET_Builder_Element::set_style($render_slug, array(
		        'selector' => '%%order_class%% .filter_section  ul.multi_filter_container > li',
		        'declaration' => sprintf('flex: %1$s;max-width: %2$s;', $flex, $width )
	        ));
            
        }
        if ( 'multiple_filter' === $this->props['post_display'] && 'default' !== $this->props['multi_filter_placement'] ){
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'multi_filter_input_gap',
                'type'              => 'margin-bottom',
                'selector'          => '%%order_class%% .df_cptfilter_container.df_filter_sidebar ul.multi_filter_container > li:not(:last-child)',
                'unit'              => 'px',
                'important'         => false,
                'default'           => '20',
                'negative'          => false,
                'fixed_unit'        => 'px'
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .filter_section ul li, %%order_class%% .filter_section ul li .checkbox_container,%%order_class%% .filter_section ul li .dropdown-container, %%order_class%% .filter_section ul li span.multi_filter_label',
                'declaration' => 'width: auto;'
            ));
        }
        if ( 'multiple_filter' === $this->props['post_display'] && 'on' === $this->props['enable_mobile_responsive'] ){

            $mobile_filter_gap = isset($this->props['multi_filter_input_gap_for_mobile']) ? intval($this->props['multi_filter_input_gap_for_mobile']) : '20';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_cptfilter_container ul.multi_filter_container > li:not(:last-child)',
                'declaration' => sprintf('margin-bottom: %1$spx !important;padding-right: 0px !important;', $mobile_filter_gap),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));

	        $this->df_process_color(array (
		        'render_slug'       => $render_slug,
		        'slug'              => "filter_button_active_container_header",
		        'type'              => 'background',
		        'selector'          => "{$this->filter_modile_view_header}",
		        'hover'             => "{$this->filter_modile_view_header}:hover"
	        ));
	        $this->df_process_color(array (
		        'render_slug'       => $render_slug,
		        'slug'              => "filter_button_active_container_header_cls_btn_icon_color",
		        'type'              => 'color',
		        'selector'          => "%%order_class%% .df_phn_resp_cls:after"
	        ));
	        $this->df_process_color(array (
		        'render_slug'       => $render_slug,
		        'slug'              => "filter_button_active_container_header_cls_btn_bg",
		        'type'              => 'background',
		        'selector'          => "%%order_class%% .df_phn_resp_cls:after"
	        ));
	        $this->df_process_color(array (
		        'render_slug'       => $render_slug,
		        'slug'              => "filter_button_active_container_footer",
		        'type'              => 'background',
		        'selector'          => "{$this->filter_modile_view_footer}",
		        'hover'             => "{$this->filter_modile_view_footer}:hover"
	        ));
	        $this->df_process_color(array (
		        'render_slug'       => $render_slug,
		        'slug'              => "filter_button_active_container_show",
		        'type'              => 'background',
		        'selector'          => "{$this->filter_modile_view_footer} a.difl_filter_show_btn",
		        'hover'             => "{$this->filter_modile_view_footer} a.difl_filter_show_btn:hover"
	        ));
	        $this->df_process_color(array (
		        'render_slug'       => $render_slug,
		        'slug'              => "filter_button_active_container_cancel",
		        'type'              => 'background',
		        'selector'          => "{$this->filter_modile_view_footer} a.difl_filter_cls_btn",
		        'hover'             => "{$this->filter_modile_view_footer} a.difl_filter_cls_btn:hover"
	        ));
        }
        if ( 'multiple_filter' === $this->props['post_display']){
	        $this->df_process_bg(array (
		        'render_slug'       => $render_slug,
		        'slug'              => "multi_filter_container_bg",
		        'selector'          => "%%order_class%% .filter_section",
		        'hover'             => "%%order_class%% .filter_section:hover"
	        ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'multi_filter_autocomplete_max_height',
                'type'              => 'max-height',
                'selector'          => '%%order_class%% .autocomplete-list',
                'unit'              => 'px',
                'important'         => false,
                'default'           => '180',
                'negative'          => false,
                'fixed_unit'        => 'px'
            ));
	        $this->set_margin_padding_styles(array(
		        'render_slug'       => $render_slug,
		        'slug'              => 'multi_filter_container_margin',
		        'type'              => 'margin',
		        'selector'          => '%%order_class%% .filter_section .filter_field_wrapper',
		        'hover'             => '%%order_class%% .filter_section .filter_field_wrapper:hover',
		        'important'         => false,
	        ));
	        $this->set_margin_padding_styles(array(
		        'render_slug'       => $render_slug,
		        'slug'              => 'multi_filter_container_padding',
		        'type'              => 'padding',
		        'selector'          => '%%order_class%% .filter_section .filter_field_wrapper',
		        'hover'             => '%%order_class%% .filter_section .filter_field_wrapper:hover',
	        ));

			$range_background = isset($this->props['multi_filter_range_bg']) ? $this->props['multi_filter_range_bg'] : '#e1e4e9';
	        ET_Builder_Element::set_style($render_slug, array(
		        'selector' => '%%order_class%% .filter_section li .irs .irs-line',
		        'declaration' => sprintf('background-color: %1$s;', $range_background)
	        ));
			$range_active_color = isset($this->props['multi_filter_range_active_color']) ? $this->props['multi_filter_range_active_color'] : '#ed5565';
	        ET_Builder_Element::set_style($render_slug, array(
		        'selector' => '%%order_class%% .filter_section li .irs .irs-bar',
		        'declaration' => sprintf('background-color: %1$s;', $range_active_color)
	        ));
			$range_active_border_color = isset($this->props['multi_filter_range_active_border_color']) ? $this->props['multi_filter_range_active_border_color'] : '#da4453';
	        ET_Builder_Element::set_style($render_slug, array(
		        'selector' => '%%order_class%% .filter_section li .irs .irs-handle>i:first-child',
		        'declaration' => sprintf('background-color: %1$s;', $range_active_border_color)
	        ));
			$range_tooltip_color = isset($this->props['multi_filter_range_tooltip_bg']) ? $this->props['multi_filter_range_tooltip_bg'] : '#ed5565';
	        ET_Builder_Element::set_style($render_slug, array(
		        'selector' => '%%order_class%% .filter_section li .irs .irs-from, %%order_class%% .filter_section li .irs .irs-to',
		        'declaration' => sprintf('background-color: %1$s;', $range_tooltip_color)
	        ));
	        ET_Builder_Element::set_style($render_slug, array(
		        'selector' => '%%order_class%% .filter_section li .irs .irs-from:before, %%order_class%% .filter_section li .irs .irs-to:before',
		        'declaration' => sprintf('border-top-color: %1$s;', $range_tooltip_color)
	        ));
			$range_min_max_backgrond = isset($this->props['multi_filter_range_min_max_bg']) ? $this->props['multi_filter_range_min_max_bg'] : '#e1e4e9';
	        ET_Builder_Element::set_style($render_slug, array(
		        'selector' => '%%order_class%% .filter_section li .irs .irs-min, %%order_class%% .filter_section li .irs .irs-max',
		        'declaration' => sprintf('background-color: %1$s;', $range_min_max_backgrond)
	        ));
        }
        

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'multi_filter_input_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .filter_section li select, %%order_class%% .filter_section li .multi-select-component',
            'hover'             => '%%order_class%% .filter_section li select:hover, %%order_class%% .filter_section li .multi-select-component:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'multi_filter_input_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .filter_section li select, %%order_class%% .filter_section li .multi-select-component',
            'hover'             => '%%order_class%% .filter_section li select:hover , %%order_class%% .filter_section li .multi-select-component:hover',
        ));

	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'multi_filter_dropdown_container_margin',
		    'type'              => 'margin',
		    'selector'          => '%%order_class%% .filter_section ul li .dropdown-container',
		    'hover'             => '%%order_class%% .filter_section ul li .dropdown-container:hover',
	    ));
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'multi_filter_dropdown_container_padding',
		    'type'              => 'padding',
		    'selector'          => '%%order_class%% .filter_section ul li .dropdown-container',
		    'hover'             => '%%order_class%% .filter_section ul li .dropdown-container:hover',
	    ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'multi_filter_label_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .filter_section ul li span.multi_filter_label',
            'hover'             => '%%order_class%% .filter_section ul li span.multi_filter_label:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'multi_filter_label_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .filter_section ul li span.multi_filter_label',
            'hover'             => '%%order_class%% .filter_section ul li span.multi_filter_label:hover',
        ));

	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'multi_filter_checkbox_field_margin',
		    'type'              => 'margin',
		    'selector'          => '%%order_class%% .filter_section li .checkbox_container',
		    'hover'             => '%%order_class%% .filter_section li .checkbox_container:hover',
	    ));
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'multi_filter_checkbox_field_padding',
		    'type'              => 'padding',
		    'selector'          => '%%order_class%% .filter_section li .checkbox_container',
		    'hover'             => '%%order_class%% .filter_section li .checkbox_container:hover',
	    ));

	    $multi_filter_checkbox_field_checkbox_item_gap = isset($this->props['multi_filter_checkbox_field_checkbox_item_gap']) ? intval($this->props['multi_filter_checkbox_field_checkbox_item_gap']) : '8';
	    ET_Builder_Element::set_style($render_slug, array(
		    'selector' => '%%order_class%% .filter_section li .checkbox_container .checkbox_content',
		    'declaration' => sprintf('margin-bottom: %1$spx !important;', $multi_filter_checkbox_field_checkbox_item_gap)
	    ));

		$multi_filter_checkbox_field_checkbox_item_space_left = isset($this->props['multi_filter_checkbox_field_checkbox_item_space_left']) ? intval($this->props['multi_filter_checkbox_field_checkbox_item_space_left']) : '10';
	    ET_Builder_Element::set_style($render_slug, array(
		    'selector' => '%%order_class%% .filter_section li .checkbox_container .checkbox_content',
		    'declaration' => sprintf('margin-left: %1$spx !important;', $multi_filter_checkbox_field_checkbox_item_space_left)
	    ));

		$multi_filter_checkbox_field_checkbox_size = isset($this->props['multi_filter_checkbox_field_checkbox_size']) ? intval($this->props['multi_filter_checkbox_field_checkbox_size']) : '25';
	    ET_Builder_Element::set_style($render_slug, array(
		    'selector' => '%%order_class%% .filter_section li .checkbox_container .checkmark',
		    'declaration' => sprintf('height: %1$spx !important; width: %1$spx !important;', $multi_filter_checkbox_field_checkbox_size)
	    ));

		$multi_filter_checkbox_field_checkbox_text_space_left = isset($this->props['multi_filter_checkbox_field_checkbox_text_space_left']) ? intval($this->props['multi_filter_checkbox_field_checkbox_text_space_left']) : '35';
	    ET_Builder_Element::set_style($render_slug, array(
		    'selector' => '%%order_class%% .filter_section li .checkbox_container .checkbox_content',
		    'declaration' => sprintf('padding-left: %1$spx !important;', $multi_filter_checkbox_field_checkbox_text_space_left)
	    ));

		$multi_filter_checkbox_field_checkbox_checked_color = isset($this->props['multi_filter_checkbox_field_checkbox_checked_color']) ? $this->props['multi_filter_checkbox_field_checkbox_checked_color'] : '#2196F3';
	    ET_Builder_Element::set_style($render_slug, array(
		    'selector' => '%%order_class%% .filter_section li .checkbox_container input:checked ~ .checkmark',
		    'declaration' => sprintf('background-color: %1$s !important;', $multi_filter_checkbox_field_checkbox_checked_color)
	    ));

        if($this->props['post_display'] === 'multiple_filter' && $this->props['multi_filter_placement'] !== 'default'){
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'multi_filter_container_width',
                'type'              => 'width',
                //'selector'          => '%%order_class%% .df_filter_sidebar ul.multiple_taxonomy_filter',
                'selector'          => '%%order_class%% .df_filter_sidebar .filter_section',
                'unit'              => '%',
                'important'         => false,
                'default'           => '30',
                'negative'          => false,
                'fixed_unit'        => '%'
            ));
        
            if($this->props['multi_filter_placement'] == 'right'){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .df_cptfilter_container.df_filter_sidebar',
                    'declaration' => 'flex-direction: row-reverse'
                ));
            }

            $multi_filter_container_width = isset( $this->props['multi_filter_container_width'] ) ?  $this->props['multi_filter_container_width'] : '0%';
	        $multi_filter_container_width = str_contains($multi_filter_container_width, '%') ? $multi_filter_container_width : $multi_filter_container_width . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_filter_sidebar .df-cpts-wrap',
                'declaration' => "width:calc(100% - {$multi_filter_container_width});",
            ));
            $multi_filter_container_width_tablet= isset( $this->props['multi_filter_container_width_tablet'] ) ?  $this->props['multi_filter_container_width_tablet'] : $multi_filter_container_width;
	        $multi_filter_container_width_tablet = '' !== $multi_filter_container_width_tablet ? $multi_filter_container_width_tablet : '0%';
	        $multi_filter_container_width_tablet = str_contains($multi_filter_container_width_tablet, '%') ? $multi_filter_container_width_tablet : $multi_filter_container_width_tablet . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_filter_sidebar .df-cpts-wrap',
                'declaration' => "width:calc(100% - {$multi_filter_container_width_tablet});",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            $multi_filter_container_width_phone= isset( $this->props['multi_filter_container_width_phone'] ) ?  $this->props['multi_filter_container_width_phone'] : $multi_filter_container_width_tablet;
	        $multi_filter_container_width_phone = '' !== $multi_filter_container_width_phone ? $multi_filter_container_width_phone : '0%';
	        $multi_filter_container_width_phone = str_contains($multi_filter_container_width_phone, '%') ? $multi_filter_container_width_phone : $multi_filter_container_width_phone . '%';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_filter_sidebar .df-cpts-wrap',
                'declaration' => "width:calc(100% - {$multi_filter_container_width_phone});",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));     
        }

        if($this->props['post_display'] === 'multiple_filter' && $this->props['enable_mobile_responsive'] === 'on'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_cptfilter_container , %%order_class%% .df_cptfilter_container.df_filter_sidebar',
                'declaration' => "flex-direction:column;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
	        ET_Builder_Element::set_style($render_slug, array(
		        'selector' => '%%order_class%% .df_cptfilter_container .filter_section, %%order_class%% .df_cptfilter_container .filter_section ul',
		        'declaration' => "display:block;width:100%;",
		        'media_query' => ET_Builder_Element::get_media_query('max_width_767')
	        ));
	        ET_Builder_Element::set_style($render_slug, array(
		        'selector' => '%%order_class%% .df_cptfilter_container .filter_section li, %%order_class%% .df_cptfilter_container .filter_section li select, %%order_class%% .df_cptfilter_container .filter_section li> span',
		        'declaration' => "width:100% !important;max-width:100% !important",
		        'media_query' => ET_Builder_Element::get_media_query('max_width_767')
	        ));
        }
        // load more
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'load_more_align',
            'type'              => 'text-align',
            'selector'          => '%%order_class%% .load-more-pagintaion-container',
            'important'         => false,
            'default'           => 'left'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "load_more_background",
            'selector'          => "%%order_class%% .df-cptfilter-load-more",
            'hover'             => "%%order_class%% .df-cptfilter-load-more:hover"
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'load_more_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df-cptfilter-load-more',
            'hover'             => '%%order_class%% .df-cptfilter-load-more:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'load_more_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df-cptfilter-load-more',
            'hover'             => '%%order_class%% .df-cptfilter-load-more:hover',
        ));
        if(isset($this->props['full_width_load_more']) && $this->props['full_width_load_more'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-cptfilter-load-more',
                'declaration' => 'width: 100%;'
            ));
        }
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
       
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'load_more_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-load-more-icon',
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
                    'base_attr_name' => 'search_bar_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .search_bar .et-pb-icon.search_icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }

        // Search bar
         if ('on' === $this->props['use_search_bar'] && 'on' === $this->props['use_search_bar_icon']) {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'search_button_icon_color',
                'type'              => 'color',
                'selector'          => "%%order_class%% .search_bar .search_bar_button .et-pb-icon.search_icon",
                'hover'             => '%%order_class%% .search_bar .search_bar_button:hover .et-pb-icon.search_icon'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'search_button_icon_size',
                'type'              => 'font-size',
                'default'           => '14px',
                'selector'          => "%%order_class%% .search_bar .et-pb-icon.search_icon"
            ));
        }
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_input_width',
            'type'              => 'width',
            'selector'          => '%%order_class%% .df_search_filter_input',
            'unit'              => 'px',
            'important'         => false,
            'default'           => '200',
            'negative'          => false,
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_bar_align',
            'type'              => 'justify-content',
            'selector'          => '%%order_class%% .search_bar',
            'important'         => false,
            'default'           => 'center'
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "search_bar_wrapper_background",
            'selector'          => "%%order_class%% .search_bar",
            'hover'             => "%%order_class%% .search_bar:hover"
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "search_bar_input_background",
            'selector'          => "%%order_class%% .search_bar .df_search_filter_input",
            'hover'             => "%%order_class%% .search_bar .df_search_filter_input:hover"
        ));
        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "search_bar_button_background",
            'selector'          => "%%order_class%% .search_bar .search_bar_button",
            'hover'             => "%%order_class%% .search_bar .search_bar_button:hover"
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_bar_wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .search_bar',
            'hover'             => '%%order_class%% .search_bar:hover'
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_bar_wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .search_bar',
            'hover'             => '%%order_class%% .search_bar:hover'
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_bar_input_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .search_bar .df_search_filter_input',
            'hover'             => '%%order_class%% .search_bar .df_search_filter_input:hover'
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_bar_button_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .search_bar .search_bar_button',
            'hover'             => '%%order_class%% .search_bar .search_bar_button:hover'
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_bar_button_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .search_bar .search_bar_button',
            'hover'             => '%%order_class%% .search_bar .search_bar_button:hover'
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_bar_button_icon_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .search_bar .search_icon',
            'hover'             => '%%order_class%% .search_bar .search_icon:hover'
        ));

        // Loader Style

        $this->df_process_bg(array (
            'render_slug'       => $render_slug,
            'slug'              => "loader_background",
            'selector'          => "%%order_class%% .df-cpts-wrap #overlay",
            'hover'             => "%%order_class%% .df-cpts-wrap #overlay:hover"
        ));
        
        if($this->props['use_image_as_background'] === 'on' && $this->props['use_background_scale'] === 'on'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '.difl_cptfilter%%order_class%%',
                'declaration' => sprintf('z-index:1;'),
            ));
        }
      
    }

    /**
	 * Get blog posts for cptfilter module
	 *
	 * @return string blog post markup
	 */
    public function get_posts($df_cpt_items, $df_cpt_items_outside) {

        global $post, $paged, $wp_query, $wp_the_query, $wp_filter, $__et_blog_module_paged;

        $main_query = $wp_the_query;

        $use_current_loop           = isset( $this->props['use_current_loop'] ) ? $this->props['use_current_loop'] : 'off';
        $post_type                  = $this->props['post_type'];
        $post_display               = isset($this->props['post_display']) ? sanitize_text_field($this->props['post_display']) : '';
        $offset_number              = $this->props['offset_number'];
        $posts_number               = $this->props['posts_number'];
        $orderby                    = $this->props['orderby'];
        $layout                     = $this->props['layout'];
        $use_image_as_background    = $this->props['use_image_as_background'];
        $initial_term_id            = '';
        $order_by                   = $this->props['orderby'];

        if ( !isset($this->props['post_type']) || 'select' === $this->props['post_type'] ) return;

        $query_args = array(
			'posts_per_page' => intval($this->props['posts_number']),
			'post_status'    => array( 'publish' ),
			'perm'           => 'readable',
			'post_type'      => $this->props['post_type'],
        );

        // order by
        if ( isset($order_by) && $order_by === '2' ) {
            $query_args['orderby'] = 'date';
            $query_args[ 'order' ] = 'ASC';
        }
        else if(isset($order_by) &&  '3' === $order_by) {
            $query_args['orderby'] = 'title';
            $query_args['order'] = 'ASC';
        }
        else if( isset($order_by) &&  '4' === $order_by) {
            $query_args['orderby'] = 'title';
            $query_args['order'] = 'DESC';
        }
        else if( isset($order_by) && $order_by === '5' ) {
            $query_args[ 'orderby' ] = 'rand';
        }
        else if( isset($order_by) &&  '6' === $order_by) {
            $query_args['orderby'] = 'menu_order';
            $query_args['order'] = 'ASC';
        }
        else if( isset($order_by) &&  '7' === $order_by) {
            $query_args['orderby'] = 'menu_order';
            $query_args['order'] = 'DESC';
        }
        else{
            $query_args['orderby'] = 'date';
            $query_args['order'] = 'DESC';
        }

        // display post_types by taxonomies
        $this->get_taxonomy_values();
        if('multiple_filter' === $post_display && !empty($this->multi_filter_terms)){
            
            $terms_query   = [];
            $multi_texonomies = $this->multi_filter_terms;
            foreach($multi_texonomies as $multi_texonomy){
               
                $terms = get_terms( array(
                    'taxonomy' => $multi_texonomy,
                    'hide_empty' => true,
                ) );
           
                $permittedValues = array_values($terms);
              
                $all_terms = $str = array_column($permittedValues, 'term_id');
       
                $terms_query[] = [
                    'taxonomy' => $multi_texonomy,
                    'field'     => 'term_id',
                    'terms'     =>   $all_terms
                ];
    
            }       
            //$multi_filter_type = isset($this->props['multi_filter_type']) ? sanitize_text_field($this->props['multi_filter_type']) : '';
            if (!empty($terms_query)) {
                $query_args['tax_query'] = $terms_query;
                $query_args['tax_query']['relation'] = 'OR';//$multi_filter_type;
            }  
    
           
        }
        else if('' !== $this->selected_terms) {
            $selected_terms = explode(',', $this->selected_terms);
            $initial_term_id = $selected_terms[0];
			if(str_contains($this->selected_terms, 'current') && is_single()){
				$current_terms = implode(",", array_column(wp_get_post_terms($post->ID , $this->selected_taxonomy), "term_taxonomy_id"));
				//$current_terms = array_column(wp_get_post_terms($current_post_id , $this->selected_taxonomy), "term_taxonomy_id")
				$terms = explode(',', $current_terms);
			}else{
				$terms = 'current' !== $initial_term_id && 'on' !== $this->props['all_items'] ? $initial_term_id: $selected_terms;
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

        // set post orderby
        $post_orderby = isset($query_args[ 'orderby' ]) ? $query_args[ 'orderby' ] : 'date';

        $cpt_grid_options = array(
            'layout' => $this->props['layout'],
            'cpt_item_inner' => $df_cpt_items,
            'cpt_item_outer' => $df_cpt_items_outside,
            'equal_height' => $this->props['equal_height'],
            'use_image_as_background' => $this->props['use_image_as_background'],
            'use_background_scale' => $this->props['use_background_scale'],
            'load_more' => $this->props['use_load_more'],
            'use_load_more_icon' => $this->props['use_load_more_icon'],
            'load_more_font_icon' => $this->props['load_more_font_icon'],
            'load_more_icon_pos' => $this->props['load_more_icon_pos'],
            'use_load_more_text' => $this->props['use_load_more_text'],
            'use_search_bar' => isset($this->props['use_search_bar']) ? $this->props['use_search_bar'] : 'off',
            'use_search_bar_icon' => isset($this->props['use_search_bar_icon']) ? $this->props['use_search_bar_icon'] : '',
            'search_bar_font_icon' => isset($this->props['search_bar_font_icon']) ? $this->props['search_bar_font_icon'] : '',
            'use_only_search_bar_icon' => isset($this->props['use_only_search_bar_icon']) ? $this->props['use_only_search_bar_icon'] : 'off',
            'search_bar_button_text' => isset($this->props['search_bar_button_text']) ? $this->props['search_bar_button_text'] : '',
            'search_bar_placeholder_text' => isset($this->props['search_bar_placeholder_text']) ? $this->props['search_bar_placeholder_text'] : '',
            'use_empty_post_message' => isset($this->props['use_empty_post_message']) ? $this->props['use_empty_post_message'] : 'off',
            'empty_post_message' => isset($this->props['empty_post_message']) ? $this->props['empty_post_message'] : '',
            'orderby' => $post_orderby,
	        'entire_item_clickable' => !empty($this->props['entire_item_clickable']) ? $this->props['entire_item_clickable'] : 'off'
        );
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

        // render Cpt Filter navigation
        echo et_core_esc_previously(render_cpt_filter_nav (
            $post_type, 
            $this->selected_taxonomy, 
            $this->selected_terms,
            $this->props['all_items'],
            $this->props['all_items_text'],
            $post_orderby
        ));
    
        
        echo '<div class="df-cpts-wrap layout-'.esc_attr($cpt_grid_options['layout']).'">';
    
        if($this->props['loader_overlay'] === 'on'){
            echo '<div id="overlay"></div>';
        }
	    $initial_term_id_for_load_more = 'current' !== $initial_term_id && 'on' !== $this->props['all_items'] ? $initial_term_id: $this->selected_terms;
        echo et_core_esc_previously(df_process_filter_grid_data($cpt_grid_options, $initial_term_id_for_load_more));
        echo '</div>';

		$wp_the_query = $wp_query = $main_query; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
        wp_reset_query(); // phpcs:ignore WordPress.WP.DiscouragedFunctions
        
        $posts = ob_get_clean();

	    if(empty($df_cpt_items)) {
            $posts = '';
        }

        return $posts;
    }

	public function generate_multi_filter_select($class_name, $selector, $title, $label ,$options){
		return sprintf('
                    <li class="%5$s">
	                    <div class="dropdown-container">
		                        %3$s
		                        <select id="%1$s" name="%1$s" title="%4$s" multiple data-multi-select-plugin>
		                            %2$s
		                        </select>
	                    <div/>
                    </li>
                    ',
			$selector,
			$options,
			$title,
			esc_html__( $label),
			$class_name
		);
	}
	public function generate_multi_filter_checkbox($class_name, $selector, $label, $options){
		return sprintf('
                    <li class="%4$s">
                    	<div class="checkbox_container" id="%1$s">
	                        <span class="multi_filter_label">%3$s</span>
	                        %2$s
                    	</div> 
                    </li>
                    ',
			$selector,
			$options,
			esc_html__( $label),
			$class_name
		);
	}
	public function generate_multi_filter_range($args = []){
		return sprintf('
                    <li class="%5$s">
                        %2$s
                        <input type="text" class="df-rangle-slider" id="%1$s" data-range_value = "%4$s" data-range=\'%3$s\' data-value="%1$s"/>
                    </li>
                    ',
			$args['selector'],
			$args['title'],
			wp_json_encode($args['data']),
			wp_json_encode([$args['data']['min'],$args['data']['max']]),
			$args['class_name']
		);
	}
    public function termlist_options($tex_name , $tex_label){
        $terms = get_terms($tex_name);
        //$term_name_html = "<option value='all'> All $tex_label</option>";
        $term_name_html = "";
        foreach($terms as $term ){
            $term_id = $term->term_id;
            $name = $term->name;
            $term_name_html .= "<option value=$term->slug> $name </option>";
        }
        return $term_name_html;
    }

	public function get_taxonomy_field_options($tex_name) {
		$terms = get_terms($tex_name);
		$option_html = "";
		foreach($terms as $term ){
			$option_html .= sprintf('
							<label class="checkbox_content">%1$s
							  <input type="checkbox"  data-value="%2$s">
							  <span class="checkmark"></span>
							</label>',
				$term->name,
				$term->slug
			);
		}
		return $option_html;
	}

	public function generate_taxonomy_dropdown($post_type, $taxonomy_lists, $props){
        if(empty($taxonomy_lists)){
            return ;
        }
        $html = "";
        $heading_text = $this->props['use_multi_filter_label'] === 'on' && $this->props['enable_single_filter_label'] === 'on' && $this->props['single_label_text'] !== '' ?
                        sprintf('<li><span class="multi_filter_label"> %1$s </span></li>' , esc_html__($this->props['single_label_text'], 'divi_flash') )
                        : '';
        $html .=$heading_text;
        $index = 0;
        foreach($taxonomy_lists as $key =>$value){
	        $index++;
	        $taxonomy_details = get_taxonomy( $value );
	        $term_options = $this->termlist_options($value , $taxonomy_details->label);
	        $prefix_label = $this->props['use_multi_filter_label'] === 'on' && $this->props['prefix_multi_filter_label'] !== '' ? $this->props['prefix_multi_filter_label'] : '';
	        $label_text = $this->props['enable_single_filter_label'] === 'on' && $this->props['single_label_text'] !== '' ?  $this->props['single_label_text'] : $prefix_label ." ". $taxonomy_details->label;
	        $multi_filter_label = $this->props['use_multi_filter_label'] === 'on' ? sprintf('<span class="multi_filter_label"> %1$s </span>' , esc_html__($label_text, 'divi_flash') ): '';
	        if($this->props['enable_single_filter_label'] === 'on' ){
		        $multi_filter_label = '';
	        }
			$field_type = $props['tax_filter_field_type_'.$post_type.'_'.$value];
			if('select' === $field_type){
				$html .= $this->generate_multi_filter_select('multiple_taxonomy_filter',$value, $multi_filter_label, $taxonomy_details->label, $term_options);
			}
			else if('checkbox' === $field_type){
				$html .= $this->generate_multi_filter_checkbox('multiple_taxonomy_filter',$value, $taxonomy_details->label, $this->get_taxonomy_field_options($value));
			}
			else {
				$html .= $this->generate_multi_filter_select('multiple_taxonomy_filter',$value, $multi_filter_label, $taxonomy_details->label, $term_options);
			}

        }

        return $html;
    }
	public function get_acf_field_options($post_type, $field, $type) {
		$posts = new WP_Query([
			'post_type' => $post_type,
			'posts_per_page' => -1,
		]);

		$options = [];

		if ($posts->have_posts()) {
			while ($posts->have_posts()) {
				$posts->the_post();
				$acf_meta_value = trim(get_post_meta(get_the_ID(), $field['name'], true));
				if(!in_array($acf_meta_value, $options) && "" !== $acf_meta_value && "0" !== $acf_meta_value){
					$options[] = $acf_meta_value;
				}
			}
			wp_reset_postdata();
		}
		$options = array_unique($options);
		$acf_option_html = "";
		foreach($options as $option ){
			if('checkbox' === $type){
				$acf_option_html .= sprintf('
							<label class="checkbox_content">%2$s %1$s %3$s
							  <input type="checkbox"  data-value="%1$s">
							  <span class="checkmark"></span>
							</label>',
					$option,
					$field['prepend'],
					$field['append']
				);
			}
			if('select' === $type){
				$acf_option_html .= sprintf('<option value="%1$s">%2$s %1$s %3$s</option>', $option, $field['prepend'], $field['append']);
			}

		}
		return $acf_option_html;
	}
	public function get_acf_field_range_min_max($post_type, $field) {
		$posts = new WP_Query([
			'post_type' => $post_type,
			'posts_per_page' => -1,
		]);

		$options = [];

		if ($posts->have_posts()) {
			while ($posts->have_posts()) {
				$posts->the_post();
				$acf_meta_value = trim(get_post_meta(get_the_ID(), $field['name'], true));
				if(!in_array($acf_meta_value, $options) && "" !== $acf_meta_value && "0" !== $acf_meta_value){
					$options[] = $acf_meta_value;
				}
			}
			wp_reset_postdata();
		}
		$options = array_unique($options);
		$values = [];
		foreach($options as $option ){
			$values[] = (int) $option;

		}
		return ['min' => min($values), 'max' => max($values)];
	}
	public function get_acf_field_choices($post_type,$field, $type) {
		$get_field_choice = $field['choices'];
		$html = "";
		foreach ($get_field_choice as $key => $value) {
			if('checkbox' === $type){
				$html .= sprintf('
							<label class="checkbox_content">%1$s
							  <input type="checkbox"  data-key="%2$s" data-value="%1$s">
							  <span class="checkmark"></span>
							</label>',
					$value,
					$key
				);
			}
			if('select' === $type){
				$html .= "<option value=$key> $value </option>";
			}

		}
		return $html;
	}
	public function generate_acf_filter_fields($post_type, $selected_acf_filter_fields, $df_acf_field_details_for_filter, $props) {
		if(empty($selected_acf_filter_fields)){
			return ;
		}
		$html = "";
		$acf_field_details = $df_acf_field_details_for_filter[$post_type];
		foreach ($acf_field_details as $field){
			$multi_filter_label=$props['use_multi_filter_label'] === 'on' ?
				sprintf('<span class="multi_filter_label"> %1$s </span>' , esc_html__($field['label'], 'divi_flash') )
				: '';
			if($props['enable_single_filter_label'] === 'on'){
				$multi_filter_label = '';
			}
			$field_type = $props['acf_filter_field_type_'.$post_type.'_'.$field['name']];
			if(in_array($field['name'], $selected_acf_filter_fields)){
				if(in_array($field['type'],['textarea', 'text', 'number'])){
					if('select' === $field_type){
						$html .= $this->generate_multi_filter_select('multiple_acf_filter', $field['name'], $multi_filter_label, $field['label'], $this->get_acf_field_options($post_type,$field, 'select'));
					}
					else if('checkbox' === $field_type){
						$html .= $this->generate_multi_filter_checkbox('multiple_acf_filter', $field['name'], $field['label'], $this->get_acf_field_options($post_type,$field, 'checkbox'));
					}
					else if('range' === $field_type){
						$range_label = sprintf('<span class="multi_filter_range_label"> %1$s </span>' , esc_html__($field['label'], 'divi_flash') );
						$min_max = $this->get_acf_field_range_min_max($post_type,$field);
						$html .= $this->generate_multi_filter_range( [
							'class_name' => 'multiple_acf_filter',
							'selector'   => $field['name'],
							'title'      => $range_label,
							'data'       => [
								'skin'    => 'flat',
								'type'    => "double",
								'grid'    => false,
								'min'     => $min_max['min'],
								'max'     => $min_max['max'],
								'from'    => $min_max['min'],
								'to'      => $min_max['max'],
								'prefix'  => $field['prepend'],
								'postfix' => $field['append']
							]
						] );
					}
					else{
						$html .= $this->generate_multi_filter_checkbox('multiple_acf_filter',$field['name'], $field['label'], $this->get_acf_field_options($post_type,$field, 'checkbox'));
					}
				}
				if('select' === $field['type']){
					if('select' === $field_type){
						$html .= $this->generate_multi_filter_select('multiple_acf_filter', $field['name'], $multi_filter_label, $field['label'], $this->get_acf_field_choices($post_type, $field, 'select'));
					}
					else if('checkbox' === $field_type){
						$html .= $this->generate_multi_filter_checkbox('multiple_acf_filter', $field['name'], $field['label'], $this->get_acf_field_choices($post_type, $field, 'checkbox'));
					}
					else{
						$html .= $this->generate_multi_filter_checkbox('multiple_acf_filter', $field['name'], $field['label'], $this->get_acf_field_choices($post_type, $field, 'checkbox'));
					}
				}
				if('range' === $field['type'] && 'range' === $field_type){
					$range_label = sprintf('<span class="multi_filter_range_label"> %1$s </span>' , esc_html__($field['label'], 'divi_flash') );
					$html .= $this->generate_multi_filter_range( [
						'class_name' => 'multiple_acf_filter',
						'selector'   => $field['name'],
						'title'      => $range_label,
						'data'       => [
							'skin'    => 'flat',
							'type'    => "double",
							'grid'    => false,
							'min'     => $field['min'],
							'max'     => $field['max'],
							'from'    => $field['min'],
							'to'      => $field['max'],
							'prefix'  => $field['prepend'],
							'postfix' => $field['append']
						]
					] );
				}
			}
		}

		return $html;
	}
    public function df_search_filter_html($use_icon = 'on', $font_icon = '&#x55;', $placeholder_text = 'Search', $button_text = 'Search', $only_icon = 'off' , $button_icon_placement='right'){
        $icon = 'on' === $use_icon ?
                sprintf('<span class="et-pb-icon search_icon">%1$s</span>', 
                    esc_attr(et_pb_process_font_icon($font_icon))
                ) : '';
        $button_icon_html = sprintf('<span class="search_bar_button">
                                    %2$s
                                    %1$s
                                    %3$s
                                </span>',
                                esc_html($button_text),
                                $button_icon_placement === 'left' ? $icon : '',
                                $button_icon_placement === 'right' ? $icon : ''
                        );
        $only_icon_html  = sprintf('<span class="search_bar_button">
                            %1$s
                        </span>',
                        $icon 
                    );
        return sprintf('<div class="search_bar">
                        <input type="text" name="df_search_filter" placeholder="%2$s" class="df_search_filter_input"/>
                        %1$s
                    </div>',
                    $only_icon === 'off' ? $button_icon_html : $only_icon_html,
                    esc_html($placeholder_text)
                );        
    }

    /**
     * Module render method.
     * 
     * @return String
     */
    public function render( $attrs, $content, $render_slug ) {
		$this->handle_fa_icon();
        global $df_cpt_items, $df_cpt_items_outside;
   
        $this->additional_css_styles($render_slug);
        wp_enqueue_script('imageload');
        wp_enqueue_script('df-imagegallery-lib');
        wp_enqueue_script('df_cpt_filter');
	    wp_enqueue_style('df-rangeSlider-styles');
	    wp_enqueue_script('df-rangeSlider');
        $order_class = self::get_module_order_class($render_slug);

        $this->get_taxonomy_values();
        $multiple_cat = array();
        $selected_multi = explode("|",$this->selected_taxonomy_list);

        $list_multi_key = array_keys($this->df_taxonomies[$this->selected_post_type]);
        array_shift($list_multi_key);
	    $iMax = count( $selected_multi );
        for($i =0; $i < $iMax; $i++){
            if($selected_multi[$i] === 'on'){
                $multiple_cat[] = $list_multi_key[ $i ];
            }
        }
		/* ACF Filter */
	    $multiACFKey = "";
	    if('on' === $this->acf_extension && class_exists('ACF')) {
		    $this->get_acf_filter_values();
		    $multiACFKey = 'acf_filter_' . $this->props['post_type'];
	    }
		/* ACF Filter */

	    $loader_data = array(
		    'status'          => isset( $this->props['loader_spining'] ) ? $this->props['loader_spining'] : 'off',
		    'color'           => isset( $this->props['loader_spinning_color'] ) ? $this->props['loader_spinning_color'] : '#284cc1',
		    'size'            => isset( $this->props['loader_spining_size'] ) ? $this->props['loader_spining_size'] : '10px',
		    'type'            => isset( $this->props['loader_spinning_type'] ) ? $this->props['loader_spinning_type'] : 'classic',
		    'background'      => isset( $this->props['loader_spinning_bg_color'] ) ? $this->props['loader_spinning_bg_color'] : '#ffffff',
		    'alignment'       => isset( $this->props['loader_spinning_alignment'] ) ? $this->props['loader_spinning_alignment'] : 'center',
		    'margin_from_top' => isset( $this->props['loader_spining_top_position'] ) && ! empty( $this->props['loader_spining_top_position'] ) ? $this->props['loader_spining_top_position'] : '30%',
		    'margin'          => isset( $this->props['loader_spinning_margin'] ) ? array_slice( explode( "|", $this->props['loader_spinning_margin'] ), 0, 4 ) : [
			    '0px',
			    '0px',
			    '0px',
			    '0px'
		    ],
	    );
        DF_Localize_Vars::enqueue( 'df_cpt_filter', array( 
            'class' => $order_class,
            'layout' => $this->props['layout'],
            'post_type' => $this->props['post_type'],
            'post_display' => $this->props['post_display'],
            'posts_number' => $this->props['posts_number'],
	        'offset_number'=> $this->props['offset_number'],
            'equal_height' => $this->props['equal_height'],
            'use_image_as_background' => $this->props['use_image_as_background'],
            'use_background_scale' => $this->props['use_background_scale'],
            'cpt_item_inner' => wp_json_encode($df_cpt_items),
            'cpt_item_outer' => wp_json_encode($df_cpt_items_outside),
            'load_more' => $this->props['use_load_more'],
            'use_load_more_icon' => $this->props['use_load_more_icon'],
            'load_more_font_icon' => $this->props['load_more_font_icon'],
            'load_more_icon_pos' => $this->props['load_more_icon_pos'],
            'use_load_more_text' => $this->props['use_load_more_text'],
            'use_search_bar' => isset($this->props['use_search_bar']) ? $this->props['use_search_bar'] : 'off',
            'use_search_bar_icon' => $this->props['use_search_bar_icon'],
            'search_bar_font_icon' => $this->props['search_bar_font_icon'],
            'search_bar_button_text' => $this->props['search_bar_button_text'],
            'search_bar_placeholder_text' => $this->props['search_bar_placeholder_text'],
            'selected_tax' => $this->selected_taxonomy,
            'selected_taxonomy_list' => $this->selected_taxonomy_list,
            'multi_filter_type' =>isset($this->props['multi_filter_type']) ? $this->props['multi_filter_type'] : 'AND',
            'multi_filter_dropdown_placeholder_prefix'=> isset($this->props['multi_filter_dropdown_placeholder_prefix']) ? $this->props['multi_filter_dropdown_placeholder_prefix']: '',
            'orderby'   => $this->props['orderby'],
            'gutter'    => $this->props['gutter'],
            'all_items' => $this->props['all_items'],
            'column' => $this->props['column'],
            'column_tablet' => $this->props['column_tablet'],
            'column_phone' => $this->props['column_phone'],
            'loader_spining' => isset($this->props['loader_spining']) ? $this->props['loader_spining'] : 'off',
            'loader_overlay' => isset($this->props['loader_overlay']) ? $this->props['loader_overlay'] : 'off',
            'use_empty_post_message' => isset($this->props['use_empty_post_message']) ? $this->props['use_empty_post_message'] : 'off',
            'empty_post_message' => isset($this->props['empty_post_message']) ? $this->props['empty_post_message'] : '',
            'loader' => $loader_data,
	        'enable_acf_filter' => isset($this->props[$multiACFKey]) ? $this->props[$multiACFKey] : 'off',
	        'entire_item_clickable' => isset($this->props['entire_item_clickable']) ? $this->props['entire_item_clickable'] : 'off',
        ) );

        $data = array('layout' => $this->props['layout']);

        $posts = $this->get_posts($df_cpt_items, $df_cpt_items_outside);

        $multi_filter_placement_class = 'multiple_filter' === $this->props['post_display'] && $this->props['multi_filter_placement'] !== 'default' ? 'df_filter_sidebar' : '';
        $df_cpt_items = array();
        $df_cpt_items_outside = array();

        return sprintf('<div class="df_cptfilter_container %4$s" data-settings=\'%2$s\'>
                            <div class="filter_section %6$s"><div class="filter_wrapper"><div class="filter_elements"></div>
                            <div class="filter_field_wrapper">%5$s %3$s</div>
                            </div></div>
                            %1$s
                        </div>', 
            $posts,
            wp_json_encode($data),
            sprintf('<ul class="multi_filter_container">%1$s %2$s</ul>',$this->generate_taxonomy_dropdown($this->props['post_type'], $multiple_cat, $this->props),'multiple_filter' === $this->props['post_display'] && (isset($this->props[$multiACFKey]) && 'on' === $this->props[$multiACFKey])? $this->generate_acf_filter_fields($this->props['post_type'], $this->selected_acf_filter_fields, $this->df_acf_field_details_for_filter, $this->props) : ''),
            $multi_filter_placement_class,
            $this->props['use_search_bar'] === 'on' ? 
                $this->df_search_filter_html (
                    $this->props['use_search_bar_icon'],
                    isset($this->props['search_bar_font_icon']) &&  $this->props['search_bar_font_icon'] !=='' ? $this->props['search_bar_font_icon'] : '&#x55;',
                    $this->props['search_bar_placeholder_text'],
                    $this->props['search_bar_button_text'],
                    $this->props['use_only_search_bar_icon'],
                    $this->props['search_button_icon_placement']
                )
                : '',
        "on" === $this->props['enable_mobile_responsive'] ? "df_phn_resp" : ""
        );

    }

}

new DIFL_CptFilter;
