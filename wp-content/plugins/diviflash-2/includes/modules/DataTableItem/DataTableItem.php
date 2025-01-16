<?php

class DIFL_DataTableItem extends ET_Builder_Module {
    public $slug       = 'difl_datatableitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $child_title_var          = 'content';
	public $child_title_fallback_var = 'admin_label';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Table Row Item', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'  => array(
                'toggles'      => array(
                    'content' => esc_html__('Content', 'divi_flash'),
                    'table_options'=> esc_html__('Table Options', 'divi_flash'),
                    'admin_label' => esc_html__('Label', 'divi_flash'),
                )
            ),
            'advanced'  =>  array(
                'toggles'   =>  array(
                    'design_table'          => esc_html__('Table', 'divi_flash'),
                    'design_row'            => esc_html__('Row', 'divi_flash'),
                    'design_body'           => esc_html__('Body', 'divi_flash'),
                    'design_foot'           => esc_html__('Foot', 'divi_flash'),
                    'design_first_column'   => esc_html__('First Column', 'divi_flash'),
                    'design_last_column'    => esc_html__('Last Column', 'divi_flash'),
                    'design_image'          => esc_html__('Image', 'divi_flash'),
                    'design_icon'           => esc_html__('Icon', 'divi_flash'),
                    'design_link'           => esc_html__('Link', 'divi_flash'),
                    'design_badge'          => esc_html__('Badge', 'divi_flash'),
                    'design_custom_border'  => esc_html__('Border Style', 'divi_flash'),
                    'custom_spacing'        => array(
                        'title'             => esc_html__('Custom Spacing', 'divi_flash'),
                    ),
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();
        $advanced_fields['fonts'] = array(
            'row_text'   => array(
                'label'       => esc_html__('Row', 'divi_flash'),
                'toggle_slug' => 'design_row',
                'tab_slug'    => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'font-weight' => array(
                    'default' => 'bold'
                ),
                'css'         => array(
                    'main'      => ".entry-content thead %%order_class%% th, 
                                    table.df_dt_content tbody tr%%order_class%% td.df_dt_table_body_column_cell",
                    'hover'     => ".entry-content thead %%order_class%%:hover th,
                                    table.df_dt_content tbody tr%%order_class%%:hover td.df_dt_table_body_column_cell",
                    'important' => 'all',
                ),
            ),

            
            'link_text'   => array(
                'label'         => esc_html__('Link', 'divi_flash'),
                'toggle_slug'   => 'design_link',
                'tab_slug'        => 'advanced',
                'hide_text_align' => true,
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'font-weight' => array(
                    'default' => 'semi-bold'
                ),
                'css'      => array(
                    'main' => "table.df_dt_content tr%%order_class%% .df_dt_table_body_column_cell a",
                    'hover' => "table.df_dt_content tr%%order_class%% .df_dt_table_body_column_cell a:hover",
                    'important' => 'all',
                ),
            ),

            'badge_text'   => array(
                'label'         => esc_html__('Badge', 'divi_flash'),
                'toggle_slug'   => 'design_badge',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'font-weight' => array(
                    'default' => 'semi-bold'
                ),
                'css'      => array(
                    'main' => "table.df_dt_content tr%%order_class%% .df_dt_table_body_column_cell .table_badge",
                    'hover' => "table.df_dt_content tr%%order_class%% .df_dt_table_body_column_cell .table_badge:hover",
                    'important' => 'all',
                ),
            ),

            
        );
        
        $advanced_fields['borders'] = array(
            'link_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "table.df_dt_content {$this->main_css_element} .df_dt_table_body_column_cell a",
                        'border_radii_hover' => "table.df_dt_content {$this->main_css_element} .df_dt_table_body_column_cell a:hover",
                        'border_styles' => "table.df_dt_content {$this->main_css_element} .df_dt_table_body_column_cell a",
                        'border_styles_hover' => "table.df_dt_content {$this->main_css_element} .df_dt_table_body_column_cell a:hover",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|3px|3px|3px|3px',
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_link',
            ),

            'icon_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "table.df_dt_content {$this->main_css_element} .df_dt_table_body_column_cell span.et-pb-icon",
                        'border_radii_hover' => "table.df_dt_content {$this->main_css_element} .df_dt_table_body_column_cell:hover span.et-pb-icon",
                        'border_styles' => "table.df_dt_content {$this->main_css_element} .df_dt_table_body_column_cell span.et-pb-icon",
                        'border_styles_hover' => "table.df_dt_content {$this->main_css_element} .df_dt_table_body_column_cell:hover span.et-pb-icon",
                    )
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_icon',
            ),

            'badge_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "table.df_dt_content {$this->main_css_element} th.df_dt_table_body_column_cell .table_badge",
                        'border_radii_hover' => "table.df_dt_content {$this->main_css_element} th.df_dt_table_body_column_cell:hover .table_badge",
                        'border_styles' => "table.df_dt_content {$this->main_css_element} th.df_dt_table_body_column_cell .table_badge",
                        'border_styles_hover' => "table.df_dt_content {$this->main_css_element} th.df_dt_table_body_column_cell:hover .table_badge",
                    )
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_badge',
            ),
        );
        
        $advanced_fields['box_shadow'] = array(
            'badge_shadow'    => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css'      => array(
                    'main' => "table.df_dt_content {$this->main_css_element} .df_dt_table_body_column_cell .table_badge",
                    'hover'=> "table.df_dt_content {$this->main_css_element} .df_dt_table_body_column_cell:hover .table_badge",
                ),
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'design_badge',
            ),
        ); 
        $advanced_fields['max_width'] = false;
        $advanced_fields['filters'] =false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['margin_padding'] = false;
        $advanced_fields['transform'] = false;
        $advanced_fields['background'] = false;
        $advanced_fields['text'] = false;
         return $advanced_fields;
    }

    public function get_fields() {
   
        $general = array (
            'admin_label' => array (
				'label'           => esc_html__( 'Admin Label', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'content',
				'toggle_slug'     => 'admin_label',
				'default_on_front'=> 'Data Table Row',
			)
        );
        $content = array (
            'row' => array (
                'label'                 => esc_html__( 'Columns', 'divi_flash' ),
                'description'           => esc_html__('To make Empty column, you can use html special character for space (&ampnbsp;). To want use font you should Put Icon code in span tag and use class "et-pb-icon" (Example:   &ltspan class="et-pb-icon" &gt icon code &ltspan&gt). You can find icons code from here <a href="https://www.elegantthemes.com/blog/resources/elegant-icon-font"> font list </a> and go "Complete Set and Unicode Reference Guide" section', 'divi_flash'),
                'type'                  => 'codemirror',
                'mode'                  => 'html',
                'toggle_slug'           => 'content'
            ),
            'row_type'  => array(
                'label'           => esc_html__('Row Type', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'head'      => esc_html__('Head', 'divi_flash'),
                    'foot'     => esc_html__('Foot', 'divi_flash'),
                    'body'    => esc_html__('Body', 'divi_flash')
                 ),
                'default'           => 'body',
                'toggle_slug'     => 'content',
            ),
            'badge_enable'  => array(
                'label'             => esc_html__('Use Badge', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'content',
                'show_if' => array(
                    'row_type' => array('head')
                )
            ),
            'badge' => array(
                'label'           => esc_html__('Badge Text', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Badge entered here will appear inside the module.', 'divi_flash'),
                'toggle_slug'     => 'content',
               
                'show_if' => array(
                    'badge_enable' => 'on',
                    'row_type' => array('head')
                )
            ),
            'badge_position' => array(
                'label'           => esc_html__( 'Badge Position', 'divi_flash' ),
                'type'            => 'text',
                'toggle_slug'     => 'content',
                'show_if' => array(
                    'badge_enable' => 'on',
                    'row_type' => array('head')
                )
            
            ),
        );

        $span_settings = array(
            'enable_row_merge' => array(
                'label'             => esc_html__('Enable Row Merge', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'table_options',
                'tab_slug'            => 'general',
                'show_if' => array(
                    'row_type' => array('body')
                )
            ),

             
            'body_row_span_item' => array(
                'label'           => esc_html__( 'Merge Row Item', 'divi_flash' ),
                'type'            => 'text',
                'toggle_slug'     => 'table_options',
                'show_if' => array(
                    'enable_row_merge' => 'on',
                    'row_type' => array('body')
                )
            
            ),

            'body_row_span_item_value' => array(
               'label'           => esc_html__( 'Merge Row Item Value', 'divi_flash' ),
                'type'            => 'text',
                'toggle_slug'     => 'table_options',
                'show_if' => array(
                    'enable_row_merge' => 'on',
                    'row_type' => array('body')
                )
            ),

            'enable_column_merge' => array(
                'label'             => esc_html__('Enable Column Merge', 'divi_flash'),
               'type'              => 'yes_no_button',
               'options'           => array(
                   'off' => esc_html__('Off', 'divi_flash'),
                   'on'  => esc_html__('On', 'divi_flash'),
               ),
               'default'           => 'off',
               'toggle_slug'     => 'table_options',
               'tab_slug'            => 'general',
           ),   

            'body_col_span_item' => array(
                'label'           => esc_html__( 'Merge Column Item', 'divi_flash' ),
                'type'            => 'text',
                'toggle_slug'     => 'table_options',
                'show_if' => array(
                    'enable_column_merge' => 'on',
                )
            ),
            'body_col_span_item_value' => array(
                'label'           => esc_html__( 'Merge Column Item Value', 'divi_flash' ),
                'type'            => 'text',
                'toggle_slug'     => 'table_options',
                'show_if' => array(
                    'enable_column_merge' => 'on'
                )
            )
        );
  
       
        $row_background = $this->df_add_bg_field(array(
            'label'               => 'Row',
            'key'                 => 'row_background',
            'toggle_slug'         => 'design_row',
            'tab_slug'            => 'advanced',
            'image'               => false
        ));


        $icon_settings = array(
            'icon_color' => array(
                'label'             => esc_html__('Icon Color', 'divi_flash'),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'design_icon',
                'tab_slug'          => 'advanced',
                'hover'             => 'tabs'
            ),
            'icon_size' => array(
                'label'             => esc_html__('Icon Size', 'divi_flash'),
                'type'              => 'range',
                'sub_toggle'        => 'content',
                'toggle_slug'       => 'design_icon',
                'tab_slug'          => 'advanced',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'important' => false
            ), 

            'icon_margin' => array(
                'label'         => sprintf(esc_html__('Icon Cell Margin', 'divi_flash')),
                'toggle_slug'   => 'design_icon',
                'tab_slug'      => 'advanced',
                'type'          => 'custom_margin',
                'hover'         => 'tabs',
                'mobile_options'=> true,
            )
        );
        $badge_background = $this->df_add_bg_field(array(
            'label'               => 'Badge',
            'key'                 => 'badge_background',
            'toggle_slug'         => 'design_badge',
            'tab_slug'            => 'advanced',
            'image'               => false
        ));
        $badge_settings = array(
       
            'full_width_badge'  => array(
                'label'             => esc_html__('Full Width Badge', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'tab_slug'      => 'advanced',
                'toggle_slug'       => 'design_badge',
                'show_if' => array(
                    'badge_enable' => 'on',
                )
            ),

            'badge_alignment'     => array(
                'label'             => esc_html__('Badge Alignment', 'divi_flash'),
                'type'              => 'text_align',
                'default'           =>'left',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'design_badge',
                'options'           =>  et_builder_get_text_orientation_options( array( 'justified' ) ),
                'mobile_options'    => false,
                'show_if' => array(
                    'badge_enable' => 'on',
                    'full_width_badge'=> 'off'
                )
            ),
            'badge_margin' => array(
                'label'         => sprintf(esc_html__('Badge Margin', 'divi_flash')),
                'toggle_slug'   => 'design_badge',
                'tab_slug'      => 'advanced',
                'type'          => 'custom_margin',
                'hover'         => 'tabs',
                'mobile_options'=> true,
                'show_if' => array(
                    'badge_enable' => 'on',
                )
            ),
            'badge_padding' => array(
                'label'         => sprintf(esc_html__('Badge Padding', 'divi_flash')),
                'toggle_slug'   => 'design_badge',
                'tab_slug'      => 'advanced',
                'type'          => 'custom_margin',
                'hover'         => 'tabs',
                'mobile_options'=> true,
                'show_if' => array(
                    'badge_enable' => 'on',
                )
            ),
        );
        $link_background = $this->df_add_bg_field(array(
            'label'               => 'Link',
            'key'                 => 'link_background',
            'toggle_slug'         => 'design_link',
            'tab_slug'            => 'advanced',
            'image'               => false
        ));
        $link_styling = array(
            'link_padding' => array(
                'label'         => sprintf(esc_html__('Link Padding', 'divi_flash')),
                'toggle_slug'   => 'design_link',
                'sub_toggle'    => 'content',
                'tab_slug'      => 'advanced',
                'type'          => 'custom_margin',
                'hover'         => 'tabs',
                'mobile_options'=> true,
            ),
        );
    
        return array_merge(
            $general,
            $span_settings,
            $content,
            $row_background,
            $badge_background,
            $badge_settings,
            $icon_settings,
            $link_background,
            $link_styling
        ); 
        
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $row         = "table.df_dt_content %%order_class%% .df_dt_table_body_column_cell";
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'row_background',
            'selector'      => $row
        ));

        $icon_cell   = "table.df_dt_content {$this->main_css_element} .df_dt_table_body_column_cell span.et-pb-icon";
        $link_cell   = "table.df_dt_content {$this->main_css_element} .df_dt_table_body_column_cell a";
        $badge       = "table.df_dt_content {$this->main_css_element} .df_dt_table_body_column_cell .table_badge";
        $fields['link_padding']      = array('padding' => $link_cell);
        $fields['icon_margin']       = array('margin' => $icon_cell);
        $fields['badge_padding']     = array('padding' => $badge);
        $fields['badge_margin']      = array('margin' => $badge);
        $fields['icon_color']        = array('color' => $icon_cell);
        
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'link_background',
            'selector'      => $link_cell
        ));

        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'badge_background',
            'selector'      => $badge
        ));


        $fields = $this->df_fix_border_transition(
            $fields,
            'link_border',
            $link_cell
        );

        $fields = $this->df_fix_border_transition(
            $fields,
            'icon_border',
            $icon_cell
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'badge_border',
            $badge 
        );
        // box-shadow transition
     
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'link_shadow',
            $link_cell
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'badge_shadow',
            $badge
        );

        return $fields;
    }
    
    public function additional_css_styles($render_slug) {

        if('on' === $this->props['badge_enable']){

            if('on' === $this->props['full_width_badge']){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "table.df_dt_content tr%%order_class%% th.df_dt_table_body_column_cell.badge .table_badge",
                    'declaration' => 'width:100%;'
                ));
        
            }
            
            if('on' !== $this->props['full_width_badge']){
                if('center' == $this->props['badge_alignment']){
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => "table.df_dt_content tr%%order_class%% th.df_dt_table_body_column_cell.badge .table_badge",
                        'declaration' => 'left: 50%; transform: translate(-50%, -100%);'
                    ));
                }
                if('right' == $this->props['badge_alignment']){
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => "table.df_dt_content tr%%order_class%% th.df_dt_table_body_column_cell.badge .table_badge",
                        'declaration' => 'right: 0; left: unset;'
                    ));
                }
            }
    
        }
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'row_background',
            'selector'          => "table.df_dt_content tbody tr%%order_class%% td.df_dt_table_body_column_cell",
            'hover'             => "table.df_dt_content tbody tr%%order_class%% td.df_dt_table_body_column_cell:hover",
            'important'         => true
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'link_background',
            'selector'          => "table.df_dt_content %%order_class%% > .df_dt_table_body_column_cell a",
            'hover'             => 'table.df_dt_content %%order_class%% > .df_dt_table_body_column_cell a:hover'
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_background',
            'selector'          => 'table.df_dt_content %%order_class%% .df_dt_table_body_column_cell .table_badge',
            'hover'             => 'table.df_dt_content %%order_class%% .df_dt_table_body_column_cell .table_badge:hover'
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_color',
            'type'              => 'color',
            'selector'          => "table.df_dt_content %%order_class%% .df_dt_table_body_column_cell span.et-pb-icon",
            'hover'             => 'table.df_dt_content %%order_class%% .df_dt_table_body_column_cell span.et-pb-icon:hover'
        ));
    
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_size',
            'type'              => 'font-size',
            'selector'          => "table.df_dt_content tr%%order_class%% .df_dt_table_body_column_cell span.et-pb-icon",
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'link_padding',
            'type'              => 'padding',
            'selector'          => 'table.df_dt_content %%order_class%% .df_dt_table_body_column_cell a',
            'hover'             => 'table.df_dt_content %%order_class%% .df_dt_table_body_column_cell a:hover',
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_margin',
            'type'              => 'margin',
            'selector'          => 'table.df_dt_content %%order_class%% .df_dt_table_body_column_cell span.et-pb-icon',
            'hover'             => 'table.df_dt_content %%order_class%% .df_dt_table_body_column_cell span.et-pb-icon:hover',
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_margin',
            'type'              => 'margin',
            'selector'          => 'table.df_dt_content %%order_class%% .df_dt_table_body_column_cell .table_badge',
            'hover'             => 'table.df_dt_content %%order_class%% .df_dt_table_body_column_cell .table_badge:hover',
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'badge_padding',
            'type'              => 'padding',
            'selector'          => 'table.df_dt_content %%order_class%% .df_dt_table_body_column_cell .table_badge',
            'hover'             => 'table.df_dt_content  %%order_class%% .df_dt_table_body_column_cell .table_badge:hover',
            'important'         => true
        ));
    }

    public function render( $attrs, $content, $render_slug ) {
        
        global $table_data;
        global $data_lebel;
        global $marge_settings;
   
        $order_class = self::get_module_order_class($render_slug);
        $parent_module = self::get_parent_modules('page')['difl_datatable'];
        $marge_settings['row_merge'] = $this->props['enable_row_merge'];
        $marge_settings['col_merge'] = $this->props['enable_column_merge'];
     
        $tablerowsData = $this->props['row'];

        $rowCounts = array();
        $tableDataArray = array();
        $tags = array("<p>", "</p>");
        $tablerowsData = trim(str_replace($tags, "", $tablerowsData), "\n");
        $RowData = explode("\n", str_replace("\r", "", $tablerowsData));

        $rowCounts= count($RowData);
        $tableDataArray = $RowData;
        
        if($parent_module->props['responsive_mode'] === 'on' && $this->props['row_type'] === 'head'){
            $data_lebel = $RowData;
        }

        $tag = 'td';
        if( $this->props['row_type'] === 'head') {
            $tag = 'th';
        }
       
        $row_html = sprintf('<tr class="%1$s">', $order_class);
        for($index = 0; $index<$rowCounts; $index++ ){

            if($index % 2 === 0 && $index !== 0 ){
                $row_class = '';
            } else {
                $row_class = '';
            }
            if($index === 0 && $this->props['body_row_span_item_value'] !== '' && $marge_settings['row_merge'] ==='on'){
               
                $row_span_code = sprintf('rowspan="%1$s"', esc_attr($this->props['body_row_span_item_value']) );
            }else{
                $row_span_code = '';
            }

            if($index+1 == $this->props['body_col_span_item'] && $this->props['body_col_span_item_value'] !== '' && $marge_settings['col_merge'] ==='on' ){
                
                $body_col_span_code = sprintf('colspan="%1$s"', esc_attr($this->props['body_col_span_item_value']) );
            }else{
                $body_col_span_code = '';
            } 
            $class= 'df_dt_table_body_column_cell';
            if( ($this->props['row_type'] === 'head' || $this->props['row_type'] === 'foot') &&  $parent_module->props['exclude_head_foot'] === 'on' ){
                $class .= ' exclude_head_foot';
            }

            if( ($this->props['row_type'] === 'head' || $this->props['row_type'] === 'foot') &&  $parent_module->props['exclude_head_foot_last_col'] === 'on' ){
                $class .= ' exclude_head_foot_last_col';
            }
            // Badge 
            if($this->props['row_type']==='head' &&  $this->props['badge_enable']==='on' && $index+1 == $this->props['badge_position'] && $this->props['badge'] !== ''){
                $badge_text_html =sprintf('<div class="table_badge"><span class="table_badge_text">%1$s</span></div>', $this->props['badge']);
                $class .= ' badge';
            }else{
                $badge_text_html ='';
            }
            $row_html .= sprintf(
                '<%7$s data-label="%6$s" %4$s %5$s class="%2$s" >%8$s %1$s</%7$s>', 
                $RowData[$index], 
                $class, 
                $row_class, 
                $row_span_code, 
                $body_col_span_code, 
                (!empty($data_lebel[$index])) ? wp_strip_all_tags($data_lebel[$index]): '',
                $tag,
                $badge_text_html 
            );

        }
        $row_html .= '</tr>';
            
        if( isset($this->props['row_type']) && $this->props['row_type'] === 'head') {
            if(isset($table_data['head'])){
                $table_data['head'] .= $row_html;
            }else{
                $table_data['head'] = $row_html;
            }
         
        } else if(isset($this->props['row_type']) &&  $this->props['row_type'] === 'foot') {
            if(isset($table_data['foot'])){
                $table_data['foot'] .= $row_html;
            }else{
                $table_data['foot'] = $row_html;
            }
        } else {
            if(isset($table_data['body'])){
                $table_data['body'] .= $row_html;
            }else{
                $table_data['body'] = $row_html;
            }
        }
        $this->additional_css_styles($render_slug);
            
        return;
    }
    
}
new DIFL_DataTableItem;