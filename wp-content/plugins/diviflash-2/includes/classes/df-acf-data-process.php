<?php

trait Df_Acf_Data_Process {

    /**
     * Store all the custom post type
     * in array
     */
    public $df_acf_cpt_list = ['select'    => 'Select post type'];
    /**
     * Store the dashboard extension value
     * this will depend on dashboard settings
     * 
     */
    public $acf_extension;
    /**
     * Store all acf fields for each cpt
     * 
     */
    public $df_acf_fields = [];

	/* ACF Filter Declaration */
    public $df_acf_fields_for_filter = [];
    public $df_acf_field_details_for_filter = [];
    public $df_acf_filter_fields = [];
    public $df_acf_filter_field_options = [];
    public $df_multi_filter_acf_field_type = [];
	public $selected_post_type_for_acf;
	public $selected_acf_filter;
	public $selected_acf_filter_fields;
	/* ACF Filter Declaration */

    /**
     * Initialize the acf support for
     * dynamic modules
     *  
     */
    public function df_acf_init($post_include = false) {
	    $this->acf_extension = get_option( 'df_general_acf_field_support' ) === '1' && class_exists( 'ACF' ) ? 'on' : 'off';
        if( 'on' !== $this->acf_extension ) return;
        if( !class_exists('ACF') ) return;
        if(!$post_include){
            $this->df_acf_cpt_list = array_merge(
                $this->df_acf_cpt_list, 
                df_get_registered_post_type_options(false, false)
            );
        }else{
            $this->df_acf_cpt_list = array_merge(
                $this->df_acf_cpt_list, 
                df_get_registered_post_type_options(false, false , true)
            );  
        }
      

        //$this->df_acf_cpt_list = array('post');
        $this->df_get_all_acf_fields();
    }

    /**
     * Get all fields for post types
     * 
     * @param String | $post_type
     */
    public function df_get_all_acf_fields() {
        $fields_storage = Df_Acf_Fields::getInstance();

        foreach($fields_storage->acf_fields_storage as $post_type=>$options) {
            $this->df_acf_fields[$post_type] = $this->add_settings_with_acf_fields($post_type,$options);
        }
		/* ACF Filter initialisation */
		$this->df_acf_fields_for_filter = $fields_storage->processed_acf_fields_for_filter_options();
		$this->df_acf_field_details_for_filter = $fields_storage->acf_fields_with_details;
		foreach ($this->df_acf_fields_for_filter as $post_type=>$options){
			$this->df_acf_filter_fields['acf_filter_'.$post_type] = $this->add_settings_for_acf_filter($post_type);
			$this->df_acf_filter_field_options['acf_filter_option_'.$post_type] = $this->add_settings_for_acf_filter_options($post_type,$options);
			foreach ($options as $name => $label){
				$this->df_multi_filter_acf_field_type['acf_filter_field_type_'.$post_type.'_'.$name] = $this->add_settings_for_acf_filter_field_type($post_type,$label);
			}
		}
	    /* ACF Filter initialisation */
    }

    /**
     * Acf Fields settings for module
     * 
     * @param String $post_type
     * @param Array $options
     * @return Array
     */
    public function add_settings_with_acf_fields($post_type, $options){
        $options = array_merge(array('df_select_option' => ' '), $options);

        $df_acf_settings = array(
            'label'             => esc_html__('Select Acf Field', 'divi_flash'),
            'type'              => 'select',
            'options'           => $options,
            'default'           => 'select_option',
            'tab_slug'          => 'general',
            'toggle_slug'       => 'settings',
            'show_if'           => array(
                'post_type_for_acf'  => $post_type,
                'type'               => 'acf_fields'
            )
        );
        
        return $df_acf_settings;
    }

	/* ACF Filter Methods */
	public function add_settings_for_acf_filter($post_type){

		$df_acf_filter_settings = array(
			'label'             => esc_html__('ACF Filter', 'divi_flash'),
			'type'              => 'yes_no_button',
			'options'           => array(
				'off' => esc_html__('Off', 'divi_flash'),
				'on'  => esc_html__('On', 'divi_flash'),
			),
			'default'           => '',
			'tab_slug'          => 'general',
			'toggle_slug'       => 'multi_filter_acf',
			'show_if' => array(
				'post_type'                  => $post_type,
				'post_display'               => 'multiple_filter'
			)
		);

		return $df_acf_filter_settings;
	}
	public function add_settings_for_acf_filter_options($post_type, $options){

		$df_acf_filter_settings = array(
			'label'             => esc_html__('Select ACF Field', 'divi_flash'),
			'type'              => 'multiple_checkboxes',
			'options'           => $options,
			'default'           => '',
			'tab_slug'          => 'general',
			'toggle_slug'       => 'multi_filter_acf',
			'show_if' => array(
				'acf_filter_' . $post_type => 'on',
				'post_type'                => $post_type,
				'post_display'             => 'multiple_filter'
			)
		);

		return $df_acf_filter_settings;
	}

	public function add_settings_for_acf_filter_field_type($post_type, $label){
		$df_acf_filter_field_type_settings = array(
			'label'             => esc_html__($label.' Field Type', 'divi_flash'),
			'type'             => 'select',
			'option_category'  => 'configuration',
			'options'           => array(
				'checkbox' => esc_html__('Checkbox', 'divi_flash'),
				'select' => esc_html__('Dropdown', 'divi_flash'),
			),
			'default'           => 'select',
			'tab_slug'          => 'general',
			'toggle_slug'       => 'multi_filter_field_type',
			'show_if' => array(
				'post_type'                  => $post_type,
				'post_display'               => 'multiple_filter',
				'acf_filter_'.$post_type => 'on',

			)
		);
		foreach ($this->df_acf_field_details_for_filter[$post_type] as $single_field){
			if($single_field['label'] === $label && in_array($single_field['type'],['number', 'range'])){
				$df_acf_filter_field_type_settings['options']['range'] = esc_html__('Range', 'divi_flash');
			}
			if($single_field['label'] === $label && 'range' === $single_field['type']){
				$df_acf_filter_field_type_settings['default'] = 'range';
			}
		}


		return $df_acf_filter_field_type_settings;
	}

	public function get_acf_filter_values(){
		$this->selected_post_type_for_acf = $this->props['post_type'];
		$this->selected_acf_filter = isset($this->props['acf_filter_'.$this->selected_post_type_for_acf]) ? $this->props['acf_filter_'.$this->selected_post_type_for_acf]: 'off';
		$this->selected_acf_filter_options = 'on' === $this->selected_acf_filter ? isset($this->props['acf_filter_option_'.$this->selected_post_type_for_acf]) ? $this->props['acf_filter_option_'.$this->selected_post_type_for_acf]: '':'';
		$this->selected_acf_filter_fields = $this->get_multi_filter_acf_fields($this->selected_acf_filter_options);
	}

	public function get_multi_filter_acf_fields($selected_acf_filter_options){
		if (!array_key_exists( $this->selected_post_type_for_acf,$this->df_acf_fields_for_filter )){
			return [];
		}
		if ( ! is_array( $this->df_acf_fields_for_filter[ $this->selected_post_type_for_acf ] ) ) {
			return [];
		}
		$main_value = array();
		$selected_multi = explode("|",$selected_acf_filter_options);

		$list_multi_key = array_keys($this->df_acf_fields_for_filter[$this->selected_post_type_for_acf]);
		$iMax = count( $selected_multi );
		for($i =0; $i < $iMax; $i++){
			if($selected_multi[$i] === 'on'){
				$main_value[] = $list_multi_key[ $i ];
			}
		}
		return $main_value;
	}
	/* ACF Filter Methods */

}