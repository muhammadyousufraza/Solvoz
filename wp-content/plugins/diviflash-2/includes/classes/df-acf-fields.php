<?php

class Df_Acf_Fields{
    private static $instance = null;

    private $acf_extension;

    /**
     * Store the acf fields name with
     * by custom post type.
     * 
     */
    public $acf_fields_storage = array();

    /**
     * Store the field type with 
     * the acf field name
     * 
     */
    public $acf_fields_type = array();

    /**
     * Supported acf field type.
     * Other field will be skipped from $acf_fields_storage
     * 
     */
    private $acf_supported_field_type = array(
        'text',
        'number',
        'textarea',
        'range',
        'email',
        'url',
        'image',
        'select',
        'date_picker',
        'wysiwyg'
    );
	/* ACF Filter Declaration */
	private $acf_filter_supported_field_type = array(
		'text',
		'number',
		'textarea',
		'range',
		'select',
		'date_picker'
	);

	public $acf_fields_with_details = [];
	/* ACF Filter declaration */

    private function __construct(){
	    $this->acf_extension = get_option( 'df_general_acf_field_support' ) === '1' && class_exists( 'ACF' ) ? 'on' : 'off';

        $this->process_all_posttype();
    }

    public static function getInstance(){
        if(self::$instance == null) {
            self::$instance = new Df_Acf_Fields();
        }
        return self:: $instance;
    }

    /**
     * Get all acf fields for by custom post type
     * and iterate over each post type 
     * 
     */
    private function process_all_posttype(){
        if('on' !== $this->acf_extension) {
            return array();
        }
        if(!class_exists('ACF')) {
            return array();
        }

        $post_types = df_get_registered_post_type_options(false, false , true);
        // iterate over each custom post type
        if(!empty($post_types)) {
            foreach($post_types as $post_type => $value) {
                $this->process_all_acf_groups($post_type);
            }
        }
    }

    /**
     * Get all acf groups for a single post type
     * 
     * @param String $post_type
     */
    private function process_all_acf_groups($post_type) {
        $groups = acf_get_field_groups(array('post_type' => $post_type));

        foreach($groups as $group) {
            $this->process_all_acf_fields($post_type, $group['key']);
            $this->process_field_data_for_acf_filter($post_type, $group['key']);
        }
    }

    /**
     * Process all acf fields for a group
     * 
     * @param String $post_type
     * @param String $group_key
     */
    private function process_all_acf_fields($post_type, $group_key) {
        $acf_fields = acf_get_fields($group_key);

        foreach($acf_fields as $acf_field) {
            if(in_array($acf_field['type'],$this->acf_supported_field_type)) {
                $this->acf_fields_storage[$post_type][$acf_field['name']] = $acf_field['label'];
                $this->acf_fields_type[$acf_field['name']] = $acf_field['type'];
            }
            
        }
    }

	/* ACF Filter Methods */
	private function process_field_data_for_acf_filter($post_type, $group_key) {
		$acf_fields = acf_get_fields($group_key);
		foreach($acf_fields as $acf_field) {
			if ( in_array( $acf_field['type'], $this->acf_filter_supported_field_type ) ) {
				$data_for_acf_filter = [
					"id"          => $acf_field['ID'],
					"key"         => $acf_field['key'],
					"label"       => $acf_field['label'],
					"name"        => $acf_field['name'],
					"prefix"      => $acf_field['prefix'],
					"type"        => $acf_field['type'],
					"parent"      => $acf_field['parent'],
					"prepend"     => ! empty( $acf_field['prepend'] ) ? $acf_field['prepend'] : "",
					"append"      => ! empty( $acf_field['append'] ) ? $acf_field['append'] : "",
					"placeholder" => ! empty( $acf_field['placeholder'] ) ? $acf_field['placeholder'] : ""
				];
				if ( "select" === $acf_field['type'] ) {
					$data_for_acf_filter['choices'] = $acf_field['choices'];
				}
				if ( "range" === $acf_field['type'] ) {
					$data_for_acf_filter['min'] = ! empty( $acf_field['min'] ) ? $acf_field['min'] : 0;
					$data_for_acf_filter['max'] = ! empty( $acf_field['max'] ) ? $acf_field['max'] : 100;
				}
				$this->acf_fields_with_details[ $post_type ][] = $data_for_acf_filter;
			}

		}
	}

	public function processed_acf_fields_for_filter_options() {
		$processed_data = [];
		foreach ($this->acf_fields_with_details as $post_type=>$fields){
			foreach ($fields as $field){
				$processed_data[$post_type][$field['name']] = $field['label'];
			}
		}
		return $processed_data;
	}
	/* ACF Filter Methods */

}