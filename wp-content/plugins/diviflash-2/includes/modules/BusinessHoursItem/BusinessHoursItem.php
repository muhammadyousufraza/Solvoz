<?php

class DIFL_BusinessHourslItem extends ET_Builder_Module {
    public $slug       = 'difl_businesshoursitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $child_title_var          = 'title';
	public $child_title_fallback_var = 'admin_label';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Business Hour', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'content' => esc_html__('Content', 'divi_flash'),
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
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

    public function get_advanced_fields_config() {
        $advanced_fields = array();
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
                    'main' => ".difl_businesshours %%order_class%% .df_bh_day",
                    'hover' => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_day",
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
                    'main' => ".difl_businesshours %%order_class%% .df_bh_time",
                    'hover' => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_time",
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
                    'main' => ".difl_businesshours %%order_class%% .df_bh_start_time",
                    'hover' => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_start_time",
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
                    'main' => ".difl_businesshours %%order_class%% .df_bh_end_time",
                    'hover' => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_end_time",
                    'important'    => 'all'
                ),
            ),

            'time_separetor'     => array(
                'label'         => esc_html__('End Time', 'divi_flash'),
                'toggle_slug'   => 'time_separetor_design',
                'tab_slug'        => 'advanced',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => ".difl_businesshours %%order_class%% .df_bh_time_separetor",
                    'hover' => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_time_separetor",
                    'important'    => 'all'
                ),
            ),
    
        );
        $advanced_fields['borders'] = array(
            'item_border'   => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_businesshours %%order_class%%.difl_businesshoursitem",
                        'border_radii_hover'  => ".difl_businesshours %%order_class%%.difl_businesshoursitem:hover",
                        'border_styles' => ".difl_businesshours %%order_class%%.difl_businesshoursitem",
                        'border_styles_hover' => ".difl_businesshours %%order_class%%.difl_businesshoursitem:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'item_design'
            ),
           
            'day_border'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_businesshours %%order_class%% .df_bh_day",
                        'border_radii_hover'  => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_day",
                        'border_styles' => ".difl_businesshours %%order_class%% .df_bh_day",
                        'border_styles_hover' => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_day",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'day_design'
            ),
            'time_border'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_businesshours %%order_class%% .df_bh_time",
                        'border_radii_hover'  => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_time",
                        'border_styles' => ".difl_businesshours %%order_class%% .df_bh_time",
                        'border_styles_hover' => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_time",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'time_design'
            ),

            'start_time_border'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_businesshours %%order_class%% .df_bh_start_time",
                        'border_radii_hover'  => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_start_time",
                        'border_styles' => ".difl_businesshours %%order_class%% .df_bh_start_time",
                        'border_styles_hover' => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_start_time",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'start_time_design'
            ),

            'end_time_border'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_businesshours %%order_class%% .df_bh_end_time",
                        'border_radii_hover'  => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_end_time",
                        'border_styles' => ".difl_businesshours %%order_class%% .df_bh_end_time",
                        'border_styles_hover' => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_end_time",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'end_time_design'
            ),

            'time_separetor_border'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_businesshours %%order_class%% .df_bh_time_separetor",
                        'border_radii_hover'  => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_time_separetor",
                        'border_styles' => ".difl_businesshours %%order_class%% .df_bh_time_separetor",
                        'border_styles_hover' => ".difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_time_separetor",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'time_separetor_design'
            ),
            
        );
        $advanced_fields['box_shadow'] = array(
            
            'item'   => array(
                'css' => array(
                    'main' => ".difl_businesshours %%order_class%%.difl_businesshoursitem",
                    'hover' => ".difl_businesshours .df_bh_container %%order_class%%.difl_businesshoursitem:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'item_design'
            ),
            'day'              => array(
                'css' => array(
                    'main' => ".difl_businesshours {$this->main_css_element} .df_bh_day",
                    'hover' => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_day",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'day_design'
            ),
            'time'              => array(
                'css' => array(
                    'main' => ".difl_businesshours {$this->main_css_element} .df_bh_time",
                    'hover' => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_time",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'time_design'
            ),
            'start_time'              => array(
                'css' => array(
                    'main' => ".difl_businesshours {$this->main_css_element} .df_bh_start_time",
                    'hover' => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_start_time",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'start_time_design'
            ),
            'end_time'              => array(
                'css' => array(
                    'main' => ".difl_businesshours {$this->main_css_element} .df_bh_end_time",
                    'hover' => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_end_time",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'end_time_design'
            ),
            'time_separetor'              => array(
                'css' => array(
                    'main' => ".difl_businesshours {$this->main_css_element} .df_bh_time_separetor",
                    'hover' => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_time_separetor",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'time_separetor_design'
            ),
           
        );
     
        $advanced_fields['background'] = array(
            'css'   => array(
                'main'  => ".difl_businesshours %%order_class%%.difl_businesshoursitem > div:first-child",
                'hover'  => ".difl_businesshours .df_bh_container %%order_class%%.difl_businesshoursitem:hover > div:first-child",
               
            )
        );
        $advanced_fields['text'] = false;
        $advanced_fields['filters'] = true;
        $advanced_fields['transform'] = false;
        //$advanced_fields['link_options'] = true;
        $advanced_fields['margin_padding'] = false;
        return $advanced_fields;
    }

    public function get_fields() {
        $general = array (
            'admin_label' => array (
				'label'           => esc_html__( 'Admin Label', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'admin_label',
				'default_on_front'=> 'Business Hours Item',
			)
        );
        $content = array (
            'day_name' => array (
                'label'                 => esc_html__( 'Day Name', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'content',
                'dynamic_content'       =>'text'
            ),
          
            'off_day_enable'  => array(
                'label'             => esc_html__('Enable Off Day', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'     => 'content',
            ),
            'off_day_text'        => array (
                'label'                 => esc_html__('Off Day Text', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'content',
                'dynamic_content'       =>'text',
                'show_if'               =>array(
                    'off_day_enable' => 'on'
                ),
            ),
            'time_structure_type' => array(
                'label'           => esc_html__('Time Structure ', 'diviblurb-diviblurb'),
                'type'            => 'select',
                'options'         => array(
                    'default' => esc_html__('Default'),
                    'advanced'  => esc_html__('Start and End Time', 'dicm-divi-custom-modules'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'content',
                'default'           => 'default',
                'show_if'               =>array(
                    'off_day_enable' => 'off'
                ),
                'description'     => esc_html__('Choose whether your link opens in a new window or not', 'dicm-divi-custom-modules')
            ),
            'time'        => array (
                'label'                 => esc_html__('Time', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'content',
                'dynamic_content'       =>'text',
                'show_if_not'               =>array(
                    'off_day_enable' => 'on'
                ),
                'show_if'               =>array(
                    'time_structure_type' => 'default'
                ),
                
            ),
            'start_time' => array (
                'label'                 => esc_html__( 'Start Time', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'content',
                'dynamic_content'       =>'text',
                'show_if'               =>array(
                    'time_structure_type' => 'advanced',
                    'off_day_enable' => 'off'
                ),
       
            ),
            'end_time'        => array (
                'label'                 => esc_html__('End Time', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'content',
                'dynamic_content'       =>'text',
                'show_if'               =>array(
                    'time_structure_type' => 'advanced',
                    'off_day_enable' => 'off'
                ),
      
            ),
            'time_separetor'        => array (
                'label'                 => esc_html__('Time Separator', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'content',
                'dynamic_content'       =>'text',
                'show_if'               =>array(
                    'time_structure_type' => 'advanced',
                    'off_day_enable' => 'off'
                ),
 
            ),

        );
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
         
            'item_padding' => array(
                'label'               => sprintf(esc_html__('Item Padding', 'divi_flash')),
                'toggle_slug' => 'custom_spacing',
                'sub_toggle'  => 'content',
                'tab_slug'    => 'advanced',
                'type'            => 'custom_margin',
                'hover'            => 'tabs',
                'responsive'        => true,
                'mobile_options'    => true,
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
                'show_if'               =>array(
                    'time_structure_type' => 'advanced'
                ),
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
                'show_if'               =>array(
                    'time_structure_type' => 'advanced'
                ),
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
                'show_if'               =>array(
                    'time_structure_type' => 'advanced'
                ),
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
                'show_if'               =>array(
                    'time_structure_type' => 'advanced'
                ),
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
                'show_if'               =>array(
                    'time_structure_type' => 'advanced'
                ),
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
                'show_if'               =>array(
                    'time_structure_type' => 'advanced'
                ),
            ),

           

        );
        $wrapper_spacing = array(
            

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
        );
        return array_merge(
            $general,
            $content,
            $day_background_color,
            $time_background_color,
            $background_color,
            $content_spacing,
            $wrapper_spacing
        );
        
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $items = '.difl_businesshours %%order_class%%.difl_businesshoursitem';
        $day ='.difl_businesshours %%order_class%% .df_bh_day';
        $time ='.difl_businesshours %%order_class%% .df_bh_time';
        $start_time ='.difl_businesshours %%order_class%% .df_bh_start_time';
        $end_time ='.difl_businesshours %%order_class%% .df_bh_end_time';
        $time_separetor ='.difl_businesshours %%order_class%% .df_bh_time_separetor';
        // spacing
 
        
        $fields['item_wrapper_margin'] = array('margin' => $items);
        $fields['item_wrapper_padding'] = array('padding' => $items);
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

        $fields['start_time_background_color'] = array('background' => $start_time);
        $fields['end_time_background_color'] = array('background' => $end_time);
        $fields['time_separetor_background_color'] = array('background' => $time_separetor);
        // background
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
    
    public function additional_css_styles($render_slug) {

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '.difl_businesshours %%order_class%%.difl_businesshoursitem',
            'declaration' => 'margin-bottom: 0;'
        ));
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'day_background_color',
            'selector'          => '.difl_businesshours %%order_class%% .df_bh_day',
            'hover'             => '.difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_day'
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_background_color',
            'selector'          => '.difl_businesshours %%order_class%% .df_bh_time',
            'hover'             => '.difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_time'
        ));

    
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'start_time_background_color',
            'type'              => 'background',
            'selector'          => '.difl_businesshours %%order_class%% .df_bh_start_time',
            'hover'             => '.difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_start_time'
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'end_time_background_color',
            'type'              => 'background',
            'selector'          => '.difl_businesshours %%order_class%% .df_bh_end_time',
            'hover'             => '.difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_end_time'
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_separetor_background_color',
            'type'              => 'background',
            'selector'          => '.difl_businesshours %%order_class%% .df_bh_time_separetor',
            'hover'             => '.difl_businesshours .df_bh_container %%order_class%%:hover .df_bh_time_separetor'
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_padding',
            'type'              => 'padding',
            'selector'          => ".difl_businesshours {$this->main_css_element}.difl_businesshoursitem > div:first-child",
            'hover'             => ".difl_businesshours {$this->main_css_element}.difl_businesshoursitem:hover > div:first-child",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'day_margin',
            'type'              => 'margin',
            'selector'          => ".difl_businesshours {$this->main_css_element} .df_bh_day",
            'hover'             => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_day",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'day_padding',
            'type'              => 'padding',
            'selector'          => ".difl_businesshours {$this->main_css_element} .df_bh_day",
            'hover'             => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_day",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_margin',
            'type'              => 'margin',
            'selector'          => ".difl_businesshours {$this->main_css_element} .df_bh_time",
            'hover'             => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_time",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_padding',
            'type'              => 'padding',
            'selector'          => ".difl_businesshours {$this->main_css_element} .df_bh_time",
            'hover'             => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_time",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'start_time_margin',
            'type'              => 'margin',
            'selector'          => ".difl_businesshours {$this->main_css_element} .df_bh_start_time",
            'hover'             => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_start_time",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'start_time_padding',
            'type'              => 'padding',
            'selector'          => ".difl_businesshours {$this->main_css_element} .df_bh_start_time",
            'hover'             => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_start_time",
            'important'         => false
        ));


        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'end_time_margin',
            'type'              => 'margin',
            'selector'          => ".difl_businesshours {$this->main_css_element} .df_bh_end_time",
            'hover'             => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_end_time",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'end_time_padding',
            'type'              => 'padding',
            'selector'          => ".difl_businesshours {$this->main_css_element} .df_bh_end_time",
            'hover'             => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_end_time",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_separetor_margin',
            'type'              => 'margin',
            'selector'          => ".difl_businesshours {$this->main_css_element} .df_bh_time_separetor",
            'hover'             => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_time_separetor",
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'time_separetor_padding',
            'type'              => 'padding',
            'selector'          => ".difl_businesshours {$this->main_css_element} .df_bh_time_separetor",
            'hover'             => ".difl_businesshours .df_bh_container {$this->main_css_element}:hover .df_bh_time_separetor",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_margin',
            'type'              => 'margin',
            'selector'          => ".difl_businesshours {$this->main_css_element}.difl_businesshoursitem",
            'hover'             => ".difl_businesshours {$this->main_css_element}.difl_businesshoursitem:hover",
             'important'         => true
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_wrapper_padding',
            'type'              => 'padding',
            'selector'          => ".difl_businesshours {$this->main_css_element}.difl_businesshoursitem",
            'hover'             => ".difl_businesshours {$this->main_css_element}.difl_businesshoursitem:hover",
            'important'         => false
        ));

       
    }





    public function render( $attrs, $content, $render_slug ) {
        
        $day_name = ( $this->props['day_name'] !== '' ) ?
        sprintf('<div class="df_bh_day">%1$s</div>', $this->props['day_name']) : '';

        $time_text = ( $this->props['time'] !== '' ) ?
        sprintf(' <span class="df_bh_time_only">%1$s</span> ', $this->props['time'] ): '';

        $start_time =  ( $this->props['start_time'] !== '' ) ?
        sprintf(' <span class="df_bh_start_time">%1$s</span> ', $this->props['start_time'] ): '';

        $end_time =  ( $this->props['end_time'] !== '' ) ?
        sprintf(' <span class="df_bh_end_time">%1$s</span> ', $this->props['end_time'] ): '';

        $time_separetor =  ( $this->props['time_separetor'] !== '' ) ?
        sprintf(' <span class="df_bh_time_separetor">%1$s</span> ', $this->props['time_separetor'] ): '';
       
        $off_day_text =  ( $this->props['off_day_enable'] === 'on' && $this->props['off_day_text'] !== ''  ) ?
        sprintf(' <span class="df_bh_off_day">%1$s</span> ', $this->props['off_day_text'] ): '';

        $normal_time = ( $this->props['time_structure_type'] === 'advanced')?
        sprintf('<div class="df_bh_time"> %1$s %3$s %2$s  </div>', $start_time , $end_time ,$time_separetor )
        :
        sprintf('<div class="df_bh_time"> %1$s </div>', $time_text );

        $time_html = ( $this->props['off_day_enable'] === 'off')?
        sprintf('%1$s', $normal_time )
            :
        sprintf('<div class="df_bh_time"> %1$s </div>', $off_day_text );

        $off_day_class = ( $this->props['off_day_enable'] === 'on' && $this->props['off_day_text'] !== ''  ) ? ' off_day_true' : '';

        $this->additional_css_styles($render_slug);
        
        $item_html =sprintf(
                    '<div class="df_bh_item%3$s">
                        %1$s
                        %2$s
                    </div>',
                    $day_name, $time_html , $off_day_class);
            
        return sprintf($item_html);
        
    }
    
}
new DIFL_BusinessHourslItem;