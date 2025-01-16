<?php

class DIFL_DataTable extends ET_Builder_Module
{
    public $slug       = 'difl_datatable';
    public $vb_support = 'on';
    public $child_slug = 'difl_datatableitem';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'DiviFlash',
        'author_uri' => '',
    );

    public function init()
    {
        $this->name = esc_html__('Table', 'divi_flash');
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/datatable.svg';
    }

    public function get_settings_modal_toggles()
    {
        return array(
            'general'  => array(
                'toggles' => array(
                    'general_settings'      => esc_html__('Settings', 'divi_flash'),
                    'table_options'         => esc_html__('Table Options', 'divi_flash'),
                ),
            ),
            'advanced'  =>  array(
                'toggles'   =>  array(
                    'design_table'         => esc_html__('Table', 'divi_flash'),
                    'design_head'          => esc_html__('Head', 'divi_flash'),
                    'design_body'          => esc_html__('Body', 'divi_flash'),
                    'design_foot'          => esc_html__('Foot', 'divi_flash'),
                    'design_first_column'  => esc_html__('First Column', 'divi_flash'),
                    'design_last_column'  => esc_html__('Last Column', 'divi_flash'),
                    'design_image'          => esc_html__('Image', 'divi_flash'),
                    'design_icon'           => esc_html__('Icon', 'divi_flash'),
                    'design_link'           => esc_html__('Link', 'divi_flash'),
                    'design_custom_border' => esc_html__('Border Style', 'divi_flash'),
                    'custom_spacing'       => array(
                        'title'            => esc_html__('Custom Spacing', 'divi_flash'),
                    ),        
                )
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = array();
        
        $advanced_fields['fonts'] = array(
            'head_text'   => array(
                'label'       => esc_html__('Head', 'divi_flash'),
                'toggle_slug' => 'design_head',
                'tab_slug'    => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'font-weight' => array(
                    'default' => 'normal'
                ),
                'css'         => array(
                    'main'      => "%%order_class%% table.df_dt_content thead tr th.df_dt_table_body_column_cell",
                    'hover'     => "%%order_class%% table.df_dt_content thead tr th.df_dt_table_body_column_cell:hover",
                    'important' => 'all',
                ),
            ),
            'row_text'   => array(
                'label'         => esc_html__('Body', 'divi_flash'),
                'toggle_slug'   => 'design_body',
                'tab_slug'      => 'advanced',
                'line_height'   => array(
                      'default' => '1em',
                    ),
                'font_size'     => array(
                    'default'   => '14px',
                ),
                'font-weight'   => array(
                    'default'   => 'semi-bold'
                ),
                'css'           => array(
                    'main'      => "%%order_class%% td.df_dt_table_body_column_cell",
                    'hover'     => "%%order_class%% td.df_dt_table_body_column_cell:hover",
                    'important' => 'all',
                ),
            ),

            'row_first_column_text'   => array(
                'label'         => esc_html__('First Column', 'divi_flash'),
                'toggle_slug'   => 'design_first_column',
                'tab_slug'      => 'advanced',
                'line_height'   => array(
                      'default' => '1em',
                    ),
                'font_size'     => array(
                    'default'   => '14px',
                ),
                'font-weight'   => array(
                    'default'   => 'semi-bold'
                ),
                'css'           => array(
                    'main'      => "%%order_class%% table.df_dt_content tr:nth-child(n) > .df_dt_table_body_column_cell:not(.exclude_head_foot):first-child",
                    'hover'     => "%%order_class%% table.df_dt_content tr:nth-child(n) > .df_dt_table_body_column_cell:not(.exclude_head_foot):first-child:hover",
                    'important' => 'all',
                ),
            ),

            'row_last_column_text'   => array(
                'label'         => esc_html__('Last Column', 'divi_flash'),
                'toggle_slug'   => 'design_last_column',
                'tab_slug'      => 'advanced',
                'line_height'   => array(
                      'default' => '1em',
                    ),
                'font_size'     => array(
                    'default'   => '14px',
                ),
                'font-weight'   => array(
                    'default'   => 'semi-bold'
                ),
                'css'           => array(
                    'main'      => "%%order_class%% table.df_dt_content tr:nth-child(n) > .df_dt_table_body_column_cell:not(.exclude_head_foot_last_col):last-child",
                    'hover'     => "%%order_class%% table.df_dt_content tr:nth-child(n) > .df_dt_table_body_column_cell:not(.exclude_head_foot_last_col):last-child:hover",
                    'important' => 'all',
                ),
            ),

            'footer_text'   => array(
                'label'         => esc_html__('Foot', 'divi_flash'),
                'toggle_slug'   => 'design_foot',
                'tab_slug'      => 'advanced',
                'line_height'   => array(
                    'default' => '1em',
                ),
                'font_size'     => array(
                    'default' => '14px',
                ),
                'font-weight'   => array(
                    'default' => 'semi-bold'
                ),
                'css'           => array(
                    'main'      => "%%order_class%% table.df_dt_content tfoot tr td.df_dt_table_body_column_cell",
                    'hover'     => "%%%order_class%% table.df_dt_content tfoot tr td.df_dt_table_body_column_cell",
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
                    'main' => "%%order_class%% tr .df_dt_table_body_column_cell a",
                    'hover' => "%%order_class%% tr .df_dt_table_body_column_cell a:hover",
                    'important' => 'all',
                ),
            ),

        );

        $advanced_fields['borders'] = array(
            'default'               => array(),
            'table_border'          => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} table.df_dt_content",
                        'border_radii_hover' => "{$this->main_css_element} .df_dt_container:hover table.df_dt_content",
                        'border_styles' => "{$this->main_css_element} table.df_dt_content",
                        'border_styles_hover' => "{$this->main_css_element} .df_dt_container:hover table.df_dt_content",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => array(
                        'width' => '1px',
                        'color' => '#eee',
                        'style' => 'solid'
                    )
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_table',
            ),
            'head_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} table.df_dt_content thead tr th.df_dt_table_body_column_cell",
                        'border_radii_hover' => "{$this->main_css_element} table.df_dt_content thead tr:hover th.df_dt_table_body_column_cell",
                        'border_styles' => "{$this->main_css_element} table.df_dt_content thead tr th.df_dt_table_body_column_cell",
                        'border_styles_hover' => "{$this->main_css_element} table.df_dt_content thead tr:hover th.df_dt_table_body_column_cell",
                    )
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_head',
            ),
            
            'row_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} table.df_dt_content tbody tr td.df_dt_table_body_column_cell",
                        'border_radii_hover' => "{$this->main_css_element} table.df_dt_content tbody tr:hover td.df_dt_table_body_column_cell",
                        'border_styles' => "{$this->main_css_element} table.df_dt_content tbody tr td.df_dt_table_body_column_cell",
                        'border_styles_hover' => "{$this->main_css_element} table.df_dt_content tbody tr:hover td.df_dt_table_body_column_cell",
                    )
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_body',
            ),

            'row_first_column_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "%%order_class%% table.df_dt_content tr:nth-child(n) > .df_dt_table_body_column_cell:not(.exclude_head_foot):first-child",
                        'border_radii_hover' => "%%order_class%% table.df_dt_content tr:nth-child(n):hover > .df_dt_table_body_column_cell:not(.exclude_head_foot):first-child",
                        'border_styles' => "%%order_class%% table.df_dt_content tr:nth-child(n) > .df_dt_table_body_column_cell:not(.exclude_head_foot):first-child",
                        'border_styles_hover' => "%%order_class%% table.df_dt_content tr:nth-child(n):hover > .df_dt_table_body_column_cell:not(.exclude_head_foot):first-child",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => array(
                        'width' => '0px',
                        'color' => 'transparent',
                        'style' => 'solid'
                    )
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_first_column',
            ),


            'row_last_column_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "%%order_class%% table.df_dt_content tr:nth-child(n) > .df_dt_table_body_column_cell:not(.exclude_head_foot_last_col):last-child",
                        'border_radii_hover' => "%%order_class%% table.df_dt_content tr:nth-child(n):hover > .df_dt_table_body_column_cell:not(.exclude_head_foot_last_col):last-child",
                        'border_styles' => "%%order_class%% table.df_dt_content tr:nth-child(n) > .df_dt_table_body_column_cell:not(.exclude_head_foot_last_col):last-child",
                        'border_styles_hover' => "%%order_class%% table.df_dt_content tr:nth-child(n):hover > .df_dt_table_body_column_cell:not(.exclude_head_foot_last_col):last-child",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => array(
                        'width' => '0px',
                        'color' => 'transparent',
                        'style' => 'solid'
                    )
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_last_column',
            ),
            'footer_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "%%order_class%% table.df_dt_content tfoot tr td.df_dt_table_body_column_cell",
                        'border_radii_hover' => "%%order_class%% table.df_dt_content tfoot tr:hover td.df_dt_table_body_column_cell",
                        'border_styles' => "%%order_class%% table.df_dt_content tfoot tr td.df_dt_table_body_column_cell",
                        'border_styles_hover' => "%%order_class%% table.df_dt_content tfoot tr:hover td.df_dt_table_body_column_cell",
                    )
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_foot',
            ),
            'link_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} tr .df_dt_table_body_column_cell a",
                        'border_radii_hover' => "{$this->main_css_element} tr .df_dt_table_body_column_cell a:hover",
                        'border_styles' => "{$this->main_css_element} tr .df_dt_table_body_column_cell a",
                        'border_styles_hover' => "{$this->main_css_element} tr .df_dt_table_body_column_cell a:hover",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|3px|3px|3px|3px',
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_link',
            ),

            'image_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} tr td.df_dt_table_body_column_cell img",
                        'border_radii_hover' => "{$this->main_css_element} tr td.df_dt_table_body_column_cell:hover img",
                        'border_styles' => "{$this->main_css_element} tr td.df_dt_table_body_column_cell img",
                        'border_styles_hover' => "{$this->main_css_element} tr td.df_dt_table_body_column_cell:hover img",
                    )
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_image',
            ),

            'icon_border'         => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii' => "{$this->main_css_element} tr .df_dt_table_body_column_cell span.et-pb-icon",
                        'border_radii_hover' => "{$this->main_css_element} tr .df_dt_table_body_column_cell span.et-pb-icon:hover",
                        'border_styles' => "{$this->main_css_element} tr .df_dt_table_body_column_cell span.et-pb-icon",
                        'border_styles_hover' => "{$this->main_css_element} tr .df_dt_table_body_column_cell span.et-pb-icon:hover",
                    )
                ),
                'label'    => esc_html__('', 'divi_flash'),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_icon',
            ),

        );
        $advanced_fields['box_shadow'] = array(
            'default'         => true,
            'table_shadow'    => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css'      => array(
                    'main' => "%%order_class%% table.df_dt_content",
                    'hover'=> "%%order_class%% .df_dt_container:hover table.df_dt_content",
                ),
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'design_table',
            ),
            'head_shadow'         => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css' => array(
                    'main' => "{$this->main_css_element} table.df_dt_content thead tr th.df_dt_table_body_column_cell",
                    'hover' => "{$this->main_css_element} table.df_dt_content thead tr:hover th.df_dt_table_body_column_cell",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_head',
            ),

            'row_shadow'          => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css' => array(
                    'main' => "{$this->main_css_element} table.df_dt_content tbody tr td.df_dt_table_body_column_cell",
                    'hover' => "{$this->main_css_element} table.df_dt_content tbody tr:hover td.df_dt_table_body_column_cell",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_body',
            ),
            'footer_shadow'          => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css' => array(
                    'main' => "{$this->main_css_element} table.df_dt_content tfoot tr td.df_dt_table_body_column_cell",
                    'hover' => "{$this->main_css_element} table.df_dt_content tfoot tr:hover td.df_dt_table_body_column_cell",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_foot',
            ),
            'link_shadow'          => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% table.df_dt_content tr .df_dt_table_body_column_cell a",
                    'hover' => "%%order_class%% table.df_dt_content tr .df_dt_table_body_column_cell a:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_link',
            ),
            'image_shadow'          => array(
                'label'    => esc_html__('', 'divi_flash'),
                'css' => array(
                    'main' => "%%order_class%% table.df_dt_content tr .df_dt_table_body_column_cell img",
                    'hover' => "%%order_class%% table.df_dt_content tr .df_dt_table_body_column_cell:hover img",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_image',
            ),

        );
        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'important' => 'all'
            )
        );
        $advanced_fields['filters'] =false;
        $advanced_fields['text'] = false;
        $advanced_fields['link_options'] = false;
        return $advanced_fields;
    }

    public function get_fields()
    {
        $genarel_settings = array(
            'responsive_mode' => array(
                'label'             => esc_html__('Responsive Mode', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'on',
                'toggle_slug'     => 'general_settings',     
            ),
          
        );
        $custom_settings = array(

            'make_head_cell_equal_border' => array(
                
                'label'             => esc_html__('Head Row Equal Border', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'design_custom_border',
                'tab_slug'            => 'advanced',
                
            ),

            'make_row_cell_equal_border' => array(
                 'label'             => esc_html__('Body Row Equal Border', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'design_custom_border',
                'tab_slug'            => 'advanced',
                
            ),

            'make_foot_cell_equal_border' => array(
                
                'label'             => esc_html__('Foot Row Equal Border', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'design_custom_border',
                'tab_slug'            => 'advanced',
                
            ),

            'make_row_last_cell_border_right_0' => array(
                'label'             => esc_html__('Last Column Border right 0', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'design_custom_border',
                'tab_slug'          => 'advanced',
            ),

           'make_row_first_cell_border_left_0' => array(
                'label'             => esc_html__('First Column Border Left 0', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'design_custom_border',
                'tab_slug'          => 'advanced',   
            ),

        );
  
     
        $head_background = $this->df_add_bg_field(array(
            'label'               => 'Head',
            'key'                 => 'head_background',
            'toggle_slug'         => 'design_head',
            'tab_slug'            => 'advanced',
            'image'               => false
        ));
        $row_background = $this->df_add_bg_field(array(
            'label'               => 'Row',
            'key'                 => 'row_background',
            'toggle_slug'         => 'design_body',
            'tab_slug'            => 'advanced',
            'image'               => false
        ));
        $row_odd_background = $this->df_add_bg_field(array(
            'label'               => 'Row Odd',
            'key'                 => 'row_odd_background',
            'toggle_slug'         => 'design_body',
            'tab_slug'            => 'advanced',
            'image'               => false
        ));
        $row_even_background = $this->df_add_bg_field(array(
            'label'               => 'Row Even',
            'key'                 => 'row_even_background',
            'toggle_slug'         => 'design_body',
            'tab_slug'            => 'advanced',
            'image'               => false
        ));

        $row_first_column_background = $this->df_add_bg_field(array(
            'label'               => 'First Column',
            'key'                 => 'row_first_column_background',
            'toggle_slug'         => 'design_first_column',
            'tab_slug'            => 'advanced',
            'image'               => false
        ));

        $row_last_column_background = $this->df_add_bg_field(array(
            'label'               => 'Last Column',
            'key'                 => 'row_last_column_background',
            'toggle_slug'         => 'design_last_column',
            'tab_slug'            => 'advanced',
            'image'               => false
        ));

        $footer_background = $this->df_add_bg_field(array(
            'label'               => 'Footer',
            'key'                 => 'footer_background',
            'toggle_slug'         => 'design_foot',
            'tab_slug'            => 'advanced',
            'image'               => false
        ));

        $content_spacing = array(
            'table_padding' => array(
                'label'         => sprintf(esc_html__('Table Padding', 'divi_flash')),
                'toggle_slug'   => 'custom_spacing',
                'tab_slug'      => 'advanced',
                'type'          => 'custom_margin',
                'hover'         => 'tabs',
                'responsive'    => true,
                'mobile_options'=> true,
            ),
            'head_cell_padding' => array(
                'label'         => sprintf(esc_html__('Head Cell Padding', 'divi_flash')),
                'toggle_slug'   => 'custom_spacing',
                'tab_slug'      => 'advanced',
                'type'          => 'custom_margin',
                'hover'         => 'tabs',
                'mobile_options'=> true,
            ),
            'body_cell_padding' => array(
                'label'         => sprintf(esc_html__('Body Cell Padding', 'divi_flash')),
                'toggle_slug'   => 'custom_spacing',
                'tab_slug'      => 'advanced',
                'type'          => 'custom_margin',
                'hover'         => 'tabs',
                'mobile_options'=> true,
            ),    
            'foot_cell_padding' => array(
                'label'         => sprintf(esc_html__('Foot Cell Padding', 'divi_flash')),
                'toggle_slug'   => 'custom_spacing',
                'tab_slug'      => 'advanced',
                'type'          => 'custom_margin',
                'hover'         => 'tabs',
                'mobile_options'=> true,
            ),     
            'image_margin' => array(
                'label'         => sprintf(esc_html__('Image Cell Margin', 'divi_flash')),
                'toggle_slug'   => 'design_image',
                'tab_slug'      => 'advanced',
                'type'          => 'custom_margin',
                'hover'         => 'tabs',
                'mobile_options'=> true,
            ),  
            'icon_margin' => array(
                'label'         => sprintf(esc_html__('Icon Cell Margin', 'divi_flash')),
                'toggle_slug'   => 'design_icon',
                'tab_slug'      => 'advanced',
                'type'          => 'custom_margin',
                'hover'         => 'tabs',
                'mobile_options'=> true,
            ),  
        );

        $image_settings = array(
            'image_size' => array(
                'label'             => esc_html__('Image Size', 'divi_flash'),
                'type'              => 'range',
                'sub_toggle'        => 'content',
                'toggle_slug'       => 'design_image',
                'tab_slug'          => 'advanced',
                'default'           => '50px',
                'allowed_units'     => array('px','%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options'    => true,
            ),  
        );
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
                'default'           => '40px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'important' => false
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
        $others_setting = array(
            'exclude_head_foot' => array(
                'label'             => esc_html__('Exclude Head and Foot', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'design_first_column',
                'tab_slug'            => 'advanced',
            ),
            'exclude_head_foot_last_col' => array(
                'label'             => esc_html__('Exclude Head and Foot', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'design_last_column',
                'tab_slug'            => 'advanced',
            ),
        );
        return array_merge(
            $genarel_settings,
            $custom_settings,
            $head_background,
            $row_background,
            $row_odd_background,
            $row_even_background,
            $row_first_column_background,
            $row_last_column_background,
            $footer_background,
            $icon_settings,
            $image_settings,
            $link_background,
            $link_styling,
            $others_setting,
            $content_spacing
        );
    }

    public function get_transition_fields_css_props()
    {
        $fields      = parent::get_transition_fields_css_props();
        $table       = "{$this->main_css_element} table.df_dt_content";
        $head        = "{$this->main_css_element} table.df_dt_content thead tr th.df_dt_table_body_column_cell";
        $row         = "{$this->main_css_element} table.df_dt_content tbody tr td.df_dt_table_body_column_cell";
        $row_odd     = "{$this->main_css_element} table.df_dt_content tbody tr:nth-child(2n+2) td.df_dt_table_body_column_cell";
        $row_even    = "{$this->main_css_element} table.df_dt_content tbody tr:nth-child(2n+1) td.df_dt_table_body_column_cell";
        $row_first_column = "{$this->main_css_element} table.df_dt_content tr:nth-child(n) .df_dt_table_body_column_cell:first-child";
        $row_last_column = "{$this->main_css_element} table.df_dt_content tr:nth-child(n) .df_dt_table_body_column_cell:last-child";
        $footer       = "{$this->main_css_element} table.df_dt_content tfoot tr td.df_dt_table_body_column_cell";
        $image_cell  = "{$this->main_css_element} table.df_dt_content .df_dt_table_body_column_cell img";
        $icon_cell   = "{$this->main_css_element} table.df_dt_content .df_dt_table_body_column_cell span.et-pb-icon";
        $link_cell   = "{$this->main_css_element} table.df_dt_content .df_dt_table_body_column_cell a";
       
        $fields['table_padding']     = array('padding' => $table);
        $fields['head_cell_padding'] = array('padding' => $head);
        $fields['body_cell_padding'] = array('padding' => $row);
        $fields['foot_cell_padding'] = array('padding' => $footer);
        $fields['link_padding']      = array('padding' => $link_cell);
        $fields['image_margin']      = array('margin' => $image_cell);
        $fields['icon_margin']       = array('margin' => $icon_cell);

        $fields['icon_color']        = array('color' => $icon_cell);
        $fields['first_cell_font_color'] = array('color' => "%%order_class%% table.df_dt_content tr:first-child > .df_dt_table_body_column_cell:first-child");
       
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'head_background',
            'selector'      =>   $head
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'row_background',
            'selector'      => $row
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'row_odd_background',
            'selector'      => $row_odd
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'row_even_background',
            'selector'      => $row_even
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'footer_background',
            'selector'      => $footer
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'link_background',
            'selector'      => $link_cell
        ));
        // border
        $fields = $this->df_fix_border_transition(
            $fields,
            'table_border',
            $table
        );     
        $fields = $this->df_fix_border_transition(
            $fields,
            'head_border',
            $head
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'row_border',
            $row
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'row_first_column_border',
            $row_first_column
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'row_last_column_border',
            $row_last_column
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'footer_border',
            $footer
        );    
        $fields = $this->df_fix_border_transition(
            $fields,
            'image_border',
            $image_cell
        );
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

        // box-shadow transition
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'table_shadow',
            $table
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'head_shadow',
            $head
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'row_shadow',
            $row
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'footer_shadow',
            $footer
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'image_shadow',
            $image_cell
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'link_shadow',
            $link_cell
        );

        return $fields;
    }

    public function get_custom_css_fields_config()
    {
      
    }

    public function additional_css_styles($render_slug)
    {   
        $responsive_mode = $this->props['responsive_mode'];
        // $media_query_min_768 = $responsive_mode === 'on' ?  ET_Builder_Element::get_media_query('min_width_768') : ET_Builder_Element::get_media_query('');
        if('on' === $this->props['make_head_cell_equal_border']){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% table.df_dt_content thead tr th.df_dt_table_body_column_cell:not(:last-child)",
                'declaration' => 'border-right:0px;'
            ));
        }

        if('on' === $this->props['make_foot_cell_equal_border']){
           
           if($responsive_mode === 'on'){
              
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% table.df_dt_content tfoot tr .df_dt_table_body_column_cell:not(:last-child)",
                    'declaration' => 'border-right:0px;',
                    'media_query' => ET_Builder_Element::get_media_query('min_width_768'),
                ));
                
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% table.df_dt_content tfoot tr .df_dt_table_body_column_cell:first-child",
                    'declaration' => 'border-bottom:0px;',
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }else{
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% table.df_dt_content tfoot tr .df_dt_table_body_column_cell:not(:last-child)",
                    'declaration' => 'border-right:0px;',
                ));
              
           }

           ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% table.df_dt_content tfoot tr:last-child .df_dt_table_body_column_cell",
                'declaration' => 'border-top:0px;',
            ));
         
        }

        if('on' === $this->props['make_row_cell_equal_border']){
            if($responsive_mode === 'on'){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% table.df_dt_content tbody tr:first-child .df_dt_table_body_column_cell",
                    'declaration' => 'border-top:0px;',
                    'media_query' => ET_Builder_Element::get_media_query('min_width_768'),
                ));
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%%  table.df_dt_content tbody tr > td.df_dt_table_body_column_cell:not(:last-child)",
                    'declaration' => 'border-right:0px;',
                    'media_query' => ET_Builder_Element::get_media_query('min_width_768'),
                )); 
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% table.df_dt_content tbody tr:not(:last-child) .df_dt_table_body_column_cell",
                    'declaration' => 'border-bottom:0px;',
                ));
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% table.df_dt_content tbody tr:last-child .df_dt_table_body_column_cell:not(:last-child)",
                    'declaration' => 'border-bottom:0px;',
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }else{
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% table.df_dt_content tbody tr:first-child .df_dt_table_body_column_cell",
                    'declaration' => 'border-top:0px;',
                ));
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%%  table.df_dt_content tbody tr > td.df_dt_table_body_column_cell:not(:last-child)",
                    'declaration' => 'border-right:0px;',
                )); 
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% table.df_dt_content tbody tr:not(:last-child) .df_dt_table_body_column_cell",
                    'declaration' => 'border-bottom:0px;'
                ));
            }
       
        }

        if('on' === $this->props['make_row_last_cell_border_right_0']){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% table.df_dt_content tr > td.df_dt_table_body_column_cell:last-child",
                'declaration' => 'border-right:0px;'
            ));
        }
        if('on' === $this->props['make_row_first_cell_border_left_0']){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% table.df_dt_content tr > td.df_dt_table_body_column_cell:first-child",
                'declaration' => 'border-left:0px;'
            ));
        }

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_color',
            'type'              => 'color',
            'selector'            => "%%order_class%% tr .df_dt_table_body_column_cell span.et-pb-icon",
            'hover'             => '%%order_class%% tr .df_dt_table_body_column_cell span.et-pb-icon:hover'
        ));
       
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_size',
            'type'              => 'font-size',
            'selector'            => "%%order_class%% table.df_dt_content tr .df_dt_table_body_column_cell span.et-pb-icon",
            'important'           => false
        ));

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_size',
            'type'              => 'width',
            'selector'            => "%%order_class%% tr th.df_dt_table_body_column_cell img,
                                      %%order_class%% tr td.df_dt_table_body_column_cell img",
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'head_background',
            'selector'          => "{$this->main_css_element} table.df_dt_content thead tr th.df_dt_table_body_column_cell",
            'hover'             => "{$this->main_css_element} table.df_dt_content thead tr:hover th.df_dt_table_body_column_cell"
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'row_background',
            'selector'          => "{$this->main_css_element} table.df_dt_content tbody tr td.df_dt_table_body_column_cell",
            'hover'             => "{$this->main_css_element} table.df_dt_content tbody tr td.df_dt_table_body_column_cell:hover"
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'row_even_background',
            'selector'          => "{$this->main_css_element} table.df_dt_content tbody tr:nth-child(2n+2) td.df_dt_table_body_column_cell",
            'hover'             => "{$this->main_css_element} table.df_dt_content tbody tr:nth-child(2n+2):hover td.df_dt_table_body_column_cell"
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'row_odd_background',
            'selector'          => "{$this->main_css_element} table.df_dt_content tbody tr:nth-child(2n+1) td.df_dt_table_body_column_cell",
            'hover'             => "{$this->main_css_element} table.df_dt_content tbody tr:nth-child(2n+1):hover td.df_dt_table_body_column_cell"
        ));
        
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'row_first_column_background',
            'selector'          => "{$this->main_css_element} table.df_dt_content tr:nth-child(n) > .df_dt_table_body_column_cell:not(.exclude_head_foot):first-child",
            'hover'             => "{$this->main_css_element} table.df_dt_content tr:nth-child(n):hover > .df_dt_table_body_column_cell:not(.exclude_head_foot):first-child"
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'row_last_column_background',
            'selector'          => "{$this->main_css_element} table.df_dt_content tr:nth-child(n) > .df_dt_table_body_column_cell:not(.exclude_head_foot_last_col):last-child",
            'hover'             => "{$this->main_css_element} table.df_dt_content tr:nth-child(n):hover > .df_dt_table_body_column_cell:not(.exclude_head_foot_last_col):last-child"
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'footer_background',
            'selector'          => "{$this->main_css_element} table.df_dt_content tfoot tr td.df_dt_table_body_column_cell",
            'hover'             => "{$this->main_css_element} table.df_dt_content tfoot tr:hover td.df_dt_table_body_column_cell"
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'link_background',
            'selector'          => "%%order_class%% .df_dt_table_body_column_cell a",
            'hover'             => '%%order_class%% .df_dt_table_body_column_cell a:hover'
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'table_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_dt_content',
            'hover'             => '%%order_class%% .df_dt_container:hover .df_dt_content',
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'body_cell_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} table.df_dt_content tbody tr td.df_dt_table_body_column_cell",
            'hover'             => "{$this->main_css_element} table.df_dt_content tbody tr:hover td.df_dt_table_body_column_cell",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'foot_cell_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} table.df_dt_content tfoot tr td.df_dt_table_body_column_cell",
            'hover'             => "{$this->main_css_element} table.df_dt_content tfoot tr:hover td.df_dt_table_body_column_cell",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'head_cell_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} table.df_dt_content thead tr th.df_dt_table_body_column_cell",
            'hover'             => "{$this->main_css_element} table.df_dt_content thead tr:hover th.df_dt_table_body_column_cell",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'link_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .df_dt_table_body_column_cell a',
            'hover'             => '%%order_class%% .df_dt_table_body_column_cell a:hover',
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_dt_table_body_column_cell img',
            'hover'             => '%%order_class%% .df_dt_table_body_column_cell img:hover',
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .df_dt_table_body_column_cell span.et-pb-icon',
            'hover'             => '%%order_class%% .df_dt_table_body_column_cell span.et-pb-icon:hover',
            'important'         => true
        ));
    }

    public function render($attrs, $content, $render_slug)
    {
        global $table_data;
        global $marge_settings;
       
        $this->additional_css_styles($render_slug);
        
        $raw_table_data = $table_data;
        $responsive_mode = $this->props['responsive_mode'] === 'on'? 'responsive_mode_active': 'scroll_mode_active';
        $html_code = sprintf(
                '<div class="df_dt_container %4$s">
                    <div class="df_dt_wrapper">
                        <table class="df_dt_content">
                            <thead>%1$s</thead>
                            <tbody>%2$s</tbody>
                            <tfoot>%3$s</tfoot>
                        </table>
                    </div>
                </div>',
                (!empty($raw_table_data['head'])) ? $raw_table_data['head']: '' ,
                (!empty($raw_table_data['body'])) ? $raw_table_data['body']: '',
                (!empty($raw_table_data['foot'])) ? $raw_table_data['foot']: '',
                $responsive_mode
        );
         
        $table_data = array();
        return $html_code;  
    }
   
}
new DIFL_DataTable;
