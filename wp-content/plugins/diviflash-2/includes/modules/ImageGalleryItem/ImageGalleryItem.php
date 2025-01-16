<?php

class DIFL_ImageGalleryItem extends ET_Builder_Module {
    public $slug       = 'difl_imagegalleryitem';
    public $vb_support = 'on';
    public $type       = 'child';

    public $child_title_var          = 'gallery_title';
    public $child_title_fallback_var = 'admin_label';
    
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        // $this->no_render = true;
        $this->name = esc_html__( 'Advanced Gallery Item', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'gallery'   => esc_html__('Gallery', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array()
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = false;
        $advanced_fields['borders'] = false;
        $advanced_fields['box_shadow'] = false;
        $advanced_fields['filters'] = false;
        $advanced_fields['transform'] = false;
        $advanced_fields['scroll_effects'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['margin_padding'] = false;
        $advanced_fields['max_width'] = false;
        $advanced_fields['background'] = false;
    
        return $advanced_fields;
    }

    public function get_fields() {
        $general = array (
            'gallery_title' => array(
				'label'            => esc_html__( 'Title', 'divi_flash' ),
				'type'             => 'text',
				'toggle_slug'      => 'gallery',
			),
            'gallery_ids' => array(
				'label'            => esc_html__( 'Gallery Images', 'divi_flash' ),
				'description'      => esc_html__( 'Choose images that you would like to appear in the image gallery.', 'divi_flash' ),
				'type'             => 'upload-gallery',
				'toggle_slug'      => 'gallery',
            ),
            'admin_label' => array (
                'label'           => esc_html__( 'Admin Label', 'divi_flash' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'admin_label',
                'default_on_front'=> 'Gallery'
            )
        );

        return array_merge(
            $general
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        return $fields;
    }
    
    public function additional_css_styles($render_slug) {}

    public function render( $attrs, $content, $render_slug ) {
        $this->additional_css_styles($render_slug);

        $_jsonstring = [
            "gallery_title" => sanitize_text_field($this->props['gallery_title']),
            "gallery_ids" => $this->props['gallery_ids']
        ];
        
        return wp_json_encode($_jsonstring).',';
    }
   
}
new DIFL_ImageGalleryItem;

