<?php

trait Df_MetaBox_Data_Process {
	public $df_metabox_cpt_list = ['select'    => 'Select post type'];
	public $metabox_extension;
	public $metabox_dependent_class = "RWMB_Loader";
	public $df_metabox_fields = [];

	public function df_metabox_init($post_include = false) {
		$this->metabox_extension = get_option('df_general_metabox_field_support') === '1' ? 'on' : 'off';
		if( 'on' !== $this->metabox_extension ) return;
		if( !class_exists($this->metabox_dependent_class) ) return;
		if(!$post_include){
			$this->df_metabox_cpt_list = array_merge(
				$this->df_metabox_cpt_list,
				df_get_registered_post_type_options(false, false)
			);
		}else{
			$this->df_metabox_cpt_list = array_merge(
				$this->df_metabox_cpt_list,
				df_get_registered_post_type_options(false, false , true)
			);
		}
		$this->df_get_all_metabox_fields();
	}

	public function df_get_all_metabox_fields() {
		$fields_storage = Df_MetaBox_Fields::getInstance();
		foreach($fields_storage->metabox_fields as $post_type=>$options) {
			if('select' !== $post_type){
				$this->df_metabox_fields["metabox-".$post_type] = $this->add_settings_with_metabox_fields($post_type,$options);
			}
		}
	}



	public function add_settings_with_metabox_fields( $post_type, $options){
		$options = array_merge(array('df_select_option' => ' '), $options);

		$df_metabox_settings = [
			'label'             => esc_html__('Select Meta Box Field', 'divi_flash'),
			'type'              => 'select',
			'options'           => $options,
			'default'           => 'select_option',
			'tab_slug'          => 'general',
			'toggle_slug'       => 'settings',
			'show_if'           => [
				'post_type_for_metabox'  => $post_type,
				'type'               => 'metabox_fields'
			]
		];

		return $df_metabox_settings;
	}

}