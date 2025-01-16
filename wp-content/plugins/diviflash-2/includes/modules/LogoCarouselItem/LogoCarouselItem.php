<?php

class DIFL_LogoCarouselItem extends ET_Builder_Module {
    public $slug       = 'difl_logocarouselitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $child_title_var = 'admin_label';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Logo Carousel Item', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'image'         => esc_html__('Image', 'divi_flash')
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
        $advanced_fields['max_width'] = false;
        return $advanced_fields;
    }

    public function get_fields() {
        $general = array (
            'admin_label' => array (
                'label'           => esc_html__( 'Admin Label', 'divi_flash' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'admin_label',
                'default_on_front'=> 'Carousel Item'
            )
        );
        $image = array (
            'image' => array (
                'label'                 => esc_html__( 'Image', 'divi_flash' ),
				'type'                  => 'upload',
                'option_category'       => 'basic_option',
				'upload_button_text'    => esc_attr__( 'Upload an image', 'divi_flash' ),
				'choose_text'           => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'           => esc_attr__( 'Set As Image', 'divi_flash' ),
                'toggle_slug'           => 'image',
                'dynamic_content'       => 'image'
            ),
            'alt_text' => array (
                'label'                 => esc_html__( 'Image Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'image'
            )
        );

        return array_merge(
            $general,
            $image
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        return $fields;
    }
    
    public function additional_css_styles($render_slug) {}

    public function render( $attrs, $content, $render_slug ) {
	    if ( empty( $attrs['image'] ) ) {
		    return;
	    }

        $this->additional_css_styles($render_slug);
        $image_url = $this->props['image'] !== '' ? $this->props['image'] : '';
        $image_alt = $this->props['alt_text'] !== '' ? $this->props['alt_text']  : df_image_alt_by_url($this->props['image']);
        $image = $this->props['image'] !== '' ?
            sprintf('<img class="df-lc-image" src="%1$s" alt="%2$s" />',
                esc_attr($image_url), 
                esc_attr($image_alt)
            ) 
            : '';
        
        return sprintf('<div class="df_lci_container">%1$s</div>', $image);
    }
}
new DIFL_LogoCarouselItem;