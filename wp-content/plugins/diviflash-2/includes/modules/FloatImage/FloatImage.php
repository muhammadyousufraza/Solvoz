<?php

class DIFL_FloatImage extends ET_Builder_Module {
    public $slug       = 'difl_floatimage';
    public $vb_support = 'on';
    public $child_slug = 'difl_floatimageitem';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Floating Images', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/float-image.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'image'         => esc_html__('Image', 'divi_flash'),
                    'fi_settings'   => esc_html__('Image Settings', 'divi_flash'),
                    'fi_animation'  => esc_html__('Animation Settings', 'divi_flash'),
                )
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'image_shadow'      => esc_html__('Image Shadow', 'divi_flash'),
                    'image_border'      => esc_html__('Image border', 'divi_flash')
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = false;
        $advanced_fields['filters'] = false;
        $advanced_fields['z_index'] = false;
        $advanced_fields['transform'] = false;
        $advanced_fields['animation'] = false;
        $advanced_fields['position_fields'] = false;
        $advanced_fields['borders'] = array (
            'default'   => false,
            'iamge'                => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .df_fii_container img",
                        'border_styles' => "{$this->main_css_element} .df_fii_container img",
                        'border_styles_hover' => "{$this->main_css_element} .df_fii_container img:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'image_border'
            ),
        );
        $advanced_fields['box_shadow'] = array(
            'default'   => false,
            'iamge'     => array (
                'css'       => array (
                    'main'  => "{$this->main_css_element} .df_fii_container"
                ),
                'toggle_slug'   => 'image_shadow',
                'tab_slug'      => 'advanced'
            )
        );

        return $advanced_fields;
    }

    public function get_fields() {
        $settings = array(
            'fi_min_height'   => array (
                'label'             => esc_html__( 'Container Min Height', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'fi_settings',
				'default'           => '500px',
                'default_unit'      => 'px',
                'responsive'        => true,
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '2000',
					'step' => '1',
                )
            ),
        );

        return $settings;
    }

    /**
     * Aditional Css for the module
     * 
     * @param $render_slug
     * @return Null
     */
    public function additional_css_styles($render_slug) {
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'fi_min_height',
            'type'              => 'min-height',
            'selector'          => '%%order_class%% .df_fi_container',
            'unit'              => 'px',
        ));
    }

    public function render($attr, $content, $render_slug ) {
        wp_enqueue_script('animejs');
        wp_enqueue_script('df-floatimage-script');
        
        $this->additional_css_styles($render_slug);
        return sprintf('<div class="df_fi_container">%1$s</div>',et_core_sanitized_previously( $this->content ));
    }
}
new DIFL_FloatImage;