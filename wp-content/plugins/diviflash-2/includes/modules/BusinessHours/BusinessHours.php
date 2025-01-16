<?php

class DIFL_BusinessHours extends ET_Builder_Module
{
    public $slug       = 'difl_businesshours';
    public $vb_support = 'on';
    public $child_slug = 'difl_businesshoursitem';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'DiviFlash',
        'author_uri' => '',
    );

    public function init()
    {
        $this->name = esc_html__('Business Hours', 'divi_flash');
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/business-hours.svg';
    }

    public function get_settings_modal_toggles()
    {
        return array(
            'general'   => array(
                'toggles'      => array(
                    'general_settings' => esc_html__('General Settings', 'divi_flash'),
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'title_design' => esc_html__('Title', 'divi_flash'),
                    'item_design' => esc_html__('Items', 'divi_flash'),
                    'day_design' => esc_html__('Day', 'divi_flash'),
                    'time_design' => esc_html__('Time', 'divi_flash'),
                    'start_time_design' => esc_html__('Start Time', 'divi_flash'),
                    'end_time_design' => esc_html__('End Time', 'divi_flash'),
                    'time_separetor_design' => esc_html__('Time Separator', 'divi_flash'),
                    'custom_spacing'        => array(
                        'title'             => esc_html__('Custom Spacing', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'wrapper'   => array(
                                'name' => 'Wrapper',
                            ),
                            'content'     => array(
                                'name' => 'Content',
                            )
                        )
                    )
                )
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = array();
        $advanced_fields['text'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['fonts'] = array(
            'day_name'     => array(
                'label'         => esc_html__('Day', 'divi_flash'),
                'toggle_slug'   => 'day_design',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_bh_day",
                    'hover' => "%%order_class%% .difl_businesshoursitem:hover .df_bh_day",
                    'important'    => 'all'
                ),
            ),
            
            'time_div'     => array(
                'label'         => esc_html__('Time', 'divi_flash'),
                'toggle_slug'   => 'time_design',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_bh_time",
                    'hover' => "%%order_class%% .difl_businesshoursitem:hover .df_bh_time",
                    'important'    => 'all'
                ),
            ), 
            'start_time'     => array(
                'label'         => esc_html__('Start Time', 'divi_flash'),
                'toggle_slug'   => 'start_time_design',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_bh_start_time",
                    'hover' => "%%order_class%% .difl_businesshoursitem:hover .df_bh_start_time",
                    'important'    => 'all'
                ),
            ), 

            'end_time'     => array(
                'label'         => esc_html__('End Time', 'divi_flash'),
                'toggle_slug'   => 'end_time_design',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_bh_end_time",
                    'hover' => "%%order_class%% .difl_businesshoursitem:hover .df_bh_end_time",
                    'important'    => 'all'
                ),
            ),
            'time_separetor'     => array(
                'label'         => esc_html__('Time Separator', 'divi_flash'),
                'toggle_slug'   => 'time_separetor_design',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_bh_time_separetor",
                    'hover' => "%%order_class%% .difl_businesshoursitem:hover .df_bh_time_separetor",
                    'important'    => 'all'
                ),
            ),
            'title_text'     => array(
                'label'         => esc_html__('Title', 'divi_flash'),
                'toggle_slug'   => 'title_design',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'font_size' => array(
                    'default' => '24',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .df_bh_title",
                    'hover' => "%%order_class%% .df_bh_container:hover .df_bh_title",
                    'important'    => 'all'
                ),
                'header_level' => array(
                    'default' => 'h3',
                ),
            ),
    
        );
        $advanced_fields['borders'] = array(
            'default'   => array(),
            'item_border'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .difl_businesshoursitem",
                        'border_radii_hover'  => "%%order_class%%  .difl_businesshoursitem:hover",
                        'border_styles' => "%%order_class%% .difl_businesshoursitem",
                        'border_styles_hover' => "%%order_class%% .difl_businesshoursitem:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_design'
            ),
            'title_border'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .df_bh_title",
                        'border_radii_hover'  => "%%order_class%%  .df_bh_container:hover .df_bh_title",
                        'border_styles' => "%%order_class%% .df_bh_title",
                        'border_styles_hover' => "%%order_class%% .df_bh_container:hover .df_bh_title",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'title_design'
            ),
            'day_border'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .df_bh_day",
                        'border_radii_hover'  => "%%order_class%%  .difl_businesshoursitem:hover .df_bh_day",
                        'border_styles' => "%%order_class%% .df_bh_day",
                        'border_styles_hover' => "%%order_class%% .difl_businesshoursitem:hover .df_bh_day",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'day_design'
            ),
            'time_border'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .df_bh_time",
                        'border_radii_hover'  => "%%order_class%%  .difl_businesshoursitem:hover .df_bh_time",
                        'border_styles' => "%%order_class%% .df_bh_time",
                        'border_styles_hover' => "%%order_class%% .difl_businesshoursitem:hover .df_bh_time",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'time_design'
            ),

            'start_time_border'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .df_bh_start_time",
                        'border_radii_hover'  => "%%order_class%%  .difl_businesshoursitem:hover .df_bh_start_time",
                        'border_styles' => "%%order_class%% .df_bh_start_time",
                        'border_styles_hover' => "%%order_class%% .difl_businesshoursitem:hover .df_bh_start_time",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'start_time_design'
            ),

            'end_time_border'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .df_bh_end_time",
                        'border_radii_hover'  => "%%order_class%%  .difl_businesshoursitem:hover .df_bh_end_time",
                        'border_styles' => "%%order_class%% .df_bh_end_time",
                        'border_styles_hover' => "%%order_class%% .difl_businesshoursitem:hover .df_bh_end_time",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'end_time_design'
            ),

            'time_separetor_border'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .df_bh_time_separetor",
                        'border_radii_hover'  => "%%order_class%%  .difl_businesshoursitem:hover .df_bh_time_separetor",
                        'border_styles' => "%%order_class%% .df_bh_time_separetor",
                        'border_styles_hover' => "%%order_class%% .difl_businesshoursitem:hover .df_bh_time_separetor",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'time_separetor_design'
            ),

           
            
        );
        $advanced_fields['box_shadow'] = array(
            'default'   => array(),
            'day'              => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_bh_day",
                    'hover' => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_day",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'day_design'
            ),
            'time'              => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_bh_time",
                    'hover' => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_time",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'time_design'
            ),
            'start_time'              => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_bh_start_time",
                    'hover' => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_start_time",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'start_time_design'
            ),
            'end_time'              => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_bh_end_time",
                    'hover' => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_end_time",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'end_time_design'
            ),
            'time_separetor'              => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_bh_time_separetor",
                    'hover' => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_time_separetor",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'time_separetor_design'
            ),
            'title'              => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .df_bh_title",
                    'hover' => "{$this->main_css_element} .df_bh_container:hover .df_bh_title",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'title_design'
            ),
            'item'              => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .difl_businesshoursitem",
                    'hover' => "{$this->main_css_element} .df_bh_container .difl_businesshoursitem:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'item_design'
            ),
        );


        return $advanced_fields;
    }

    public function get_fields()
    {
        $business_hours_settings = array(
            
            'title_on_off'    => array(
                'label'             => esc_html__('Title On/Off ', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'general_settings',
                'affects'           => [
                    'autospeed',
                    'pause_hover'
                ]
            ), 
            'heading_title_text' => array (
                'label'                 => esc_html__( 'Heading Title Text', 'divi_flash' ),
                'type'                  => 'text',
                'toggle_slug'           => 'general_settings',
                'dynamic_content'       =>'text',
                'show_if'               =>array(
                    'title_on_off' => 'on'
                ),
                
            ),
            
        );

        $title_bg = $this->df_add_bg_field(array(
            'label'                    => 'Background',
            'key'                   => 'df_title_bg',
            'toggle_slug'           => 'title_design',
            'tab_slug'              => 'advanced'
        ));
        $item_bg = $this->df_add_bg_field(array(
            'label'                    => 'Background',
            'key'                   => 'df_items_bg',
            'toggle_slug'           => 'item_design',
            'tab_slug'              => 'advanced'
        ));

        $day_background_color = $this->df_add_bg_field(array(
            'label'                    => 'Background',
            'key'                   => 'day_background_color',
            'toggle_slug'           => 'day_design',
            'tab_slug'              => 'advanced'
        ));
        $time_background_color = $this->df_add_bg_field(array(
            'label'                    => 'Background',
            'key'                   => 'time_background_color',
            'toggle_slug'           => 'time_design',
            'tab_slug'              => 'advanced'
        ));

        $day_width = array(
            'day_width' => array(
                'label'             => esc_html__('Day Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'day_design',
                'tab_slug'       => 'advanced',
                'default'           => '50%',
                'allowed_units'     => array('%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'description'     => esc_html__('Set Day Width', 'divi_flash')
            ),
        );
        $background_color = array(
           
            'start_time_background_color' => array(
                'label'             => esc_html__('Start Time background', 'divi_flash'),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'start_time_design',
                'hover'             => 'tabs'
            ),
            'end_time_background_color' => array(
                'label'             => esc_html__('End Time background', 'divi_flash'),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'end_time_design',
                'hover'             => 'tabs'
            ),
            'time_separetor_background_color' => array(
                'label'             => esc_html__('Time Separator background', 'divi_flash'),
                'type'              => 'color-alpha',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'time_separetor_design',
                'hover'             => 'tabs'
            ),
        );

        $content_spacing = array(
            'title_margin' => array(
                'label'               => sprintf(esc_html__('Title Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'               =>array(
                    'title_on_off' => 'on'
                ),

            ),
            'title_padding' => array(
                'label'               => sprintf(esc_html__('Title Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'               =>array(
                    'title_on_off' => 'on'
                ),
            ),
            'day_margin' => array(
                'label'               => sprintf(esc_html__('Day Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,

            ),
            'day_padding' => array(
                'label'               => sprintf(esc_html__('Day Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
            ),
            'time_margin' => array(
                'label'               => sprintf(esc_html__('Time Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
            ),
            'time_padding' => array(
                'label'               => sprintf(esc_html__('Time Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
            ),
            'start_time_margin' => array(
                'label'               => sprintf(esc_html__('Start Time Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
            ),
            'start_time_padding' => array(
                'label'               => sprintf(esc_html__('Start Time Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
            ),

            'end_time_margin' => array(
                'label'               => sprintf(esc_html__('End Time Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
            ),
            'end_time_padding' => array(
                'label'               => sprintf(esc_html__('End Time Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
            ),

            'time_separetor_margin' => array(
                'label'               => sprintf(esc_html__('Time Separator Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
            ),
            'time_separetor_padding' => array(
                'label'               => sprintf(esc_html__('Time Separator Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'content',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
            ),

           

        );
        $wrapper_spacing = array(
            'main_wrapper_margin' => array(
                'label'               => sprintf(esc_html__('Main Wrapper Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'wrapper',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
            ),
            'main_wrapper_padding' => array(
                'label'               => sprintf(esc_html__('Main Wrapper Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'wrapper',
                'tab_slug'    => 'advanced',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
            ),
            'item_wrapper_margin' => array(
                'label'               => sprintf(esc_html__('Item Wrapper Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'wrapper',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
            ),
            'item_wrapper_padding' => array(
                'label'               => sprintf(esc_html__('Item Wrapper Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'wrapper',
                'tab_slug'    => 'advanced',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
            ),
            'title_wrapper_margin' => array(
                'label'               => sprintf(esc_html__('Title Wrapper Margin', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'tab_slug'    => 'advanced',
                'sub_toggle'  => 'wrapper',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'               =>array(
                    'title_on_off' => 'on'
                ),
            ),
            'title_wrapper_padding' => array(
                'label'               => sprintf(esc_html__('Title Wrapper Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'wrapper',
                'tab_slug'    => 'advanced',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'               =>array(
                    'title_on_off' => 'on'
                ),
            ),

           
        );
        return array_merge(
            $business_hours_settings,
            $title_bg,
            $item_bg,
            $day_background_color,
            $time_background_color,
            $day_width,
            $background_color,
            $content_spacing,
            $wrapper_spacing
        );
    }

    public function get_transition_fields_css_props()
    {
        $fields = parent::get_transition_fields_css_props();

        $items = '%%order_class%% .difl_businesshoursitem';
        $title = '%%order_class%% .df_bh_title';
        $day ='%%order_class%% .df_bh_day';
        $time ='%%order_class%% .df_bh_time';
        $start_time ='%%order_class%% .df_bh_start_time';
        $end_time ='%%order_class%% .df_bh_end_time';
        $time_separetor ='%%order_class%% .df_bh_time_separetor';
        // spacing
 
        $fields['main_wrapper_margin'] = array('margin' => '%%order_class%% .df_bh_wrapper');
        $fields['main_wrapper_padding'] = array('padding' => '%%order_class%% .df_bh_wrapper');

        $fields['title_wrapper_margin'] = array('padding' => '%%order_class%% .df_bh_header');
        $fields['title_wrapper_padding'] = array('padding' => '%%order_class%% .df_bh_header');

        $fields['item_wrapper_margin'] = array('margin' => '%%order_class%% .difl_businesshoursitem');
        $fields['item_wrapper_padding'] = array('padding' => '%%order_class%% .difl_businesshoursitem');

      
        $fields['title_margin'] = array('margin' => $title);
        $fields['title_padding'] = array('padding' => $title);

        $fields['day_margin'] = array('margin' => $day);
        $fields['day_padding'] = array('padding' => $day);

        $fields['time_margin'] = array('margin' => $time);
        $fields['time_padding'] = array('padding' => $time);
       
        $fields['start_time_margin'] = array('margin' => $start_time);
        $fields['start_time_padding'] = array('padding' => $start_time);

        $fields['end_time_margin'] = array('margin' => $end_time);
        $fields['end_time_padding'] = array('padding' => $end_time);
        $fields['time_separetor_margin'] = array('margin' => $time_separetor);
        $fields['time_separetor_padding'] = array('padding' => $time_separetor);
       
        // Background Color
  
        $fields['start_time_background_color'] = array('background' => $start_time);
        $fields['end_time_background_color'] = array('background' => $end_time);
        $fields['time_separetor_background_color'] = array('background' => $time_separetor);
        // background
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'df_title_bg',
            'selector'      => $title
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'df_items_bg',
            'selector'      => $items
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'day_background_color',
            'selector'      => $day
        ));
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'time_background_color',
            'selector'      => $time
        ));
        // border fix
        $fields = $this->df_fix_border_transition(
            $fields,
            'title_border',
            $title
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'day_border',
            $day
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'time_border',
            $time
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'item_border',
            $items
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'start_time_border',
            $start_time
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'end_time_border',
            $end_time
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'time_separetor_border',
            $time_separetor
        );

        // box-shadow Fix
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'title',
            $title
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'item',
            $items
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'day',
            $day
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'time',
            $time
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'start_time',
            $start_time
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'end_time',
            $end_time
        );

        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'time_separetor',
            $time_separetor
        );

        return $fields;
    }

    public function get_custom_css_fields_config()
    {
      
    }

    public function additional_css_styles($render_slug)
    {
   

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'df_title_bg',
            'selector'          => "{$this->main_css_element} .df_bh_title",
            'hover'             => "{$this->main_css_element} .df_bh_container:hover .df_bh_title"
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'df_items_bg',
            'selector'          => "{$this->main_css_element} .difl_businesshoursitem",
            'hover'             => "{$this->main_css_element} .df_bh_container .difl_businesshoursitem:hover"
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'day_background_color',
            'selector'          => '%%order_class%% .df_bh_day',
            'hover'             => '%%order_class%% .difl_businesshoursitem:hover .df_bh_day'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_background_color',
            'selector'          => '%%order_class%% .df_bh_time',
            'hover'             => '%%order_class%% .difl_businesshoursitem:hover .df_bh_time'
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'start_time_background_color',
            'type'              => 'background',
            'selector'          => '%%order_class%% .df_bh_start_time',
            'hover'             => '%%order_class%% .difl_businesshoursitem:hover .df_bh_start_time'
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'end_time_background_color',
            'type'              => 'background',
            'selector'          => '%%order_class%% .df_bh_end_time',
            'hover'             => '%%order_class%% .difl_businesshoursitem:hover .df_bh_end_time'
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_separetor_background_color',
            'type'              => 'background',
            'selector'          => '%%order_class%% .df_bh_time_separetor',
            'hover'             => '%%order_class%% .difl_businesshoursitem:hover .df_bh_time_separetor'
        ));

     

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_bh_title",
            'hover'             => "{$this->main_css_element} .df_bh_container:hover .df_bh_title",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_bh_title",
            'hover'             => "{$this->main_css_element} .df_bh_container:hover .df_bh_title",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'day_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_bh_day",
            'hover'             => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_day",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'day_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_bh_day",
            'hover'             => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_day",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_bh_time",
            'hover'             => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_time",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_bh_time",
            'hover'             => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_time",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'start_time_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_bh_start_time",
            'hover'             => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_start_time",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'start_time_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_bh_start_time",
            'hover'             => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_start_time",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'end_time_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_bh_end_time",
            'hover'             => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_end_time",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'end_time_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_bh_end_time",
            'hover'             => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_end_time",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_separetor_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_bh_time_separetor",
            'hover'             => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_time_separetor",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_separetor_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_bh_time_separetor",
            'hover'             => "{$this->main_css_element} .difl_businesshoursitem:hover .df_bh_time_separetor",
            'important'         => false
        ));

        
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'main_wrapper_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_bh_wrapper",
            'hover'             => "{$this->main_css_element} .df_bh_container:hover .df_bh_wrapper",
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'main_wrapper_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_bh_wrapper",
            'hover'             => "{$this->main_css_element} .df_bh_container:hover .df_bh_wrapper",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .difl_businesshoursitem",
            'hover'             => "{$this->main_css_element} .difl_businesshoursitem:hover",
            'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .difl_businesshoursitem",
            'hover'             => "{$this->main_css_element} .difl_businesshoursitem:hover",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_wrapper_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df_bh_header",
            'hover'             => "{$this->main_css_element} .df_bh_container:hover .df_bh_header",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'title_wrapper_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .df_bh_header",
            'hover'             => "{$this->main_css_element} .df_bh_container:hover .df_bh_header",
            'important'         => false
        ));

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'day_width',
            'type'              => 'max-width',
            'selector'    => '%%order_class%% .df_bh_day',
        ));

        $slug = 'day_width';
        $day_width_desktop  =  !empty($this->props[$slug]) ? 
            $this->df_process_values($this->props[$slug]) : '20%';
        $day_width_tablet   =  !empty($this->props[$slug.'_tablet']) ? 
            $this->df_process_values($this->props[$slug.'_tablet']) : $day_width_desktop;
    
         
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .df_bh_time",
            'declaration' =>'max-width:  calc(100% - '.$day_width_desktop.')',
        ));
        
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .df_bh_time",
            'declaration' =>'max-width:  calc(100% - '.$day_width_tablet.')',
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .df_bh_time",
            'declaration' => 'max-width:  100%;',
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));

        
       
    }

    public function render($attrs, $content, $render_slug)
    {
        
        $title_text_level  = $this->props['title_text_level'];
        $heading_title_text = ( $this->props['heading_title_text'] !== '' ) ?
        sprintf(' <div class ="df_bh_header"> <%1$s class="df_bh_title"> %2$s </%1$s></div>',$title_text_level, $this->props['heading_title_text'] ) : '';
     
        $this->additional_css_styles($render_slug);
        
      

        $html_code = sprintf(
                '<div class="df_bh_container">
                    <div class="df_bh_wrapper">
                        %2$s
                        %1$s 
                    </div>
                </div>',
                et_core_sanitized_previously($this->content),
                $heading_title_text
        );
         
        


        return sprintf($html_code);
    

        
    }

    
}
new DIFL_BusinessHours;
