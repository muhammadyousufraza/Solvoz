<?php

class Df_MetaBox_Fields {
	private static $instance = null;
	public $metabox_extension;
	public $metabox_dependent_class = "RWMB_Loader";

	protected $registry;

	protected $filters;
	private $supported_field_type = [
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
	];

	public $metabox_fields = [];
	public $metabox_field_type = [];

	private function __construct(){
		$this->metabox_extension = get_option('df_general_metabox_field_support') === '1' ? 'on' : 'off';
		$this->filters = ['not_type' => [ 'group' ]];
		$this->process_all_posttype();
	}

	public static function getInstance(){
		if(self::$instance == null) {
			self::$instance = new Df_MetaBox_Fields();
		}
		return self:: $instance;
	}

	function process_all_metabox_groups($post_type) {
		$meta_box_registry = rwmb_get_registry( 'meta_box' );
		$meta_boxes        = $meta_box_registry->all();
		$fields = [];

		foreach ( $meta_boxes as $meta_box ) {
			$meta_box = $meta_box->meta_box;
			if(in_array($post_type, $meta_box['post_types'])){
				$fields   = array_merge( $fields, $this->process_all_metabox_fields_from_groups( $meta_box['fields'] ) );
			}
		}
		$this->metabox_fields[$post_type] = array_merge(isset($this->metabox_fields[$post_type])?$this->metabox_fields[$post_type]:[],$this->process_all_metabox_fields($fields, 'name', 'id'));
	}

	public function process_all_metabox_fields( $fields = [], $value = "", $key = null ) {
		$output = [];
		foreach ( $fields as $field ) {
			if ( ! isset( $field[ $value ] ) || empty( $field[ $value ] ) ) {
				continue;
			}

			if ( isset( $key ) ) {
				$output[ $field[ $key ] ] = $field[ $value ];
			} else {
				$output[] = $field[ $value ];
			}
		}

		return $output;
	}

	public function process_all_metabox_fields_from_groups( $fields = [], $parent = null ) {
		$output = [];

		foreach ( $fields as $field ) {
			if ( 'group' === $field['type'] ) {
				$children = $this->process_all_metabox_fields_from_groups( $field['fields'], $field );
				$output   = array_merge( $output, $children );
			}

			if ( !in_array( $field['type'], $this->supported_field_type, true ) ) {
				continue;
			}

			if ( $parent ) {
				$field['name'] = $parent['name'] . ': ' . $field['name'];
				$field['id']   = $parent['id'] . '.' . $field['id'];
			}

			$accepted_filters = [ 'clone', 'type' ];

			foreach ( $accepted_filters as $filter ) {
				if ( isset( $this->filters[ $filter ] ) && $field[ $filter ] != $this->filters[ $filter ] ) {
					continue 2;
				}
			}

			if ( isset( $this->filters['not_type'] ) && in_array( $field['type'], $this->filters['not_type'], true ) ) {
				continue;
			}
			$this->metabox_field_type[$field['id']] = $field['type'];

			$output[] = $field;
		}

		return $output;
	}

	private function process_all_posttype(){
		if( 'on' !== $this->metabox_extension ) return;
		if( !class_exists($this->metabox_dependent_class) ) return;

		$post_types = df_get_registered_post_type_options(false, false , true);
		// iterate over each custom post type
		if(!empty($post_types)) {
			foreach($post_types as $post_type => $value) {
				$this->process_all_metabox_groups($post_type);
			}
		}
	}

}