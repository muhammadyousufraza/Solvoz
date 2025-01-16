<?php

class DIFL_LottieImage extends ET_Builder_Module {
    public $slug       = 'difl_lottieimage';
    public $vb_support = 'on';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Lottie', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/lottie-image.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'source'      => esc_html__('Lottie Source', 'divi_flash'),
                    'settings'    => esc_html__('Lottie Settings', 'divi_flash'),
                )
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'image'             => esc_html__('Image Styles', 'divi_flash')
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = false;
        return $advanced_fields;
    }

    public function get_fields() {
        $source = array(
            'lottie_file_options'      => array (
                'label'                 => esc_html__( 'Lottion File Location', 'divi_flash' ),
				'type'                  => 'select',
				'options'               => array(
					'external'      => esc_html__( 'External File URL', 'divi_flash' ),
					'media'         => esc_html__( 'From Media', 'divi_flash' ),
                ),
                'toggle_slug'           => 'source',
                'default'               => 'external'
            ),
            'external_file'         => array (
                'label'             => esc_html__('URL', 'divi_flash'),
                'type'              => 'text',
                'toggle_slug'       => 'source',
                'show_if_not'       => array(
                    'lottie_file_options' => 'media'
                )
            ),
            'upload' => array(
				'label'              => esc_html__( 'Upload', 'et_builder' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload a JSON', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose a JSON', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As JSON', 'et_builder' ),
				'toggle_slug'        => 'source',
                'data_type'          => 'josn',
                'show_if'            => array(
                    'lottie_file_options' => 'media'
                )
			),
            'json_ex_notice'      => array(
                'type'                  => 'df_json_ex_notice',
                'tab_slug'              => 'general',
                'toggle_slug'           => 'source',
                'options'               => array(
                    'lottie_file_options' => 'media'
                )
            ),
        );
        $settings = array(
            'animation_trigger'      => array (
                'label'                 => esc_html__( 'Animation trigger', 'divi_flash' ),
				'type'                  => 'select',
				'options'               => array(
					'viewport'           => esc_html__( 'Viewport', 'divi_flash' ),
					'on_click'            => esc_html__( 'On Click', 'divi_flash' ),
					'on_hover'            => esc_html__( 'On Hover', 'divi_flash' ),
					'on_scroll'           => esc_html__( 'On Scroll', 'divi_flash' ),
					'none'                => esc_html__( 'None', 'divi_flash' )
                ),
                'toggle_slug'           => 'settings',
                'default'               => 'viewport'
            ),
            'scroll_effect'      => array (
                'label'                 => esc_html__( 'Track Divi Scroll Effect', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off'           => esc_html__( 'OFF', 'divi_flash' ),
					'on'            => esc_html__( 'ON', 'divi_flash' ),
                ),
                'toggle_slug'           => 'settings',
                'default'               => 'off',
                'show_if'               => array(
                    'animation_trigger' => 'on_scroll'
                )
            ),
            'stop_on_mouse_out'      => array (
                'label'                 => esc_html__( 'Pause Animation Mouse Leave', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off'           => esc_html__( 'OFF', 'divi_flash' ),
					'on'            => esc_html__( 'ON', 'divi_flash' ),
                ),
                'toggle_slug'           => 'settings',
                'default'               => 'off',
                'show_if'               => array(
                    'animation_trigger' => 'on_hover'
                )
            ),
            'threshold'       => array (
                'label'             => esc_html__( 'Threshold', 'divi_flash' ),
                'description'       => esc_html__( 'It has a default value of zero, which means that as soon as a user approaches the target element and it becomes visible', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'settings',
				'default'           => '0',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '1',
					'step' => '.1',
                ),
                'show_if'               => array(
                    'animation_trigger'        => 'viewport'
                )
            ),
            'loop'      => array (
                'label'                 => esc_html__( 'Loop', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off'           => esc_html__( 'OFF', 'divi_flash' ),
					'on'            => esc_html__( 'ON', 'divi_flash' ),
                ),
                'toggle_slug'           => 'settings',
                'default'               => 'off'
            ),
            'speed'       => array (
                'label'             => esc_html__( 'Animation Speed', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'settings',
				'default'           => '1',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '15',
					'step' => '.5',
                )
            ),
            'direction_reverse'      => array (
                'label'                 => esc_html__( 'Reverse Direction', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off'           => esc_html__( 'OFF', 'divi_flash' ),
					'on'            => esc_html__( 'ON', 'divi_flash' ),
                ),
                'toggle_slug'           => 'settings',
                'default'               => 'off'
            ),
            'renderer'      => array (
                'label'                 => esc_html__( 'Renderer', 'divi_flash' ),
				'type'                  => 'select',
				'options'               => array(
					'svg'               => esc_html__( 'SVG', 'divi_flash' ),
					'canvas'            => esc_html__( 'Canvas', 'divi_flash' )
                ),
                'toggle_slug'           => 'settings',
                'default'               => 'svg'
            ),
        );
        return array_merge(
            $source,
            $settings
        );
    }

    public function additional_css_styles($render_slug) {
        
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        return $fields;
    }

    public function render($attr, $content, $render_slug ) {
        // https://github.com/airbnb/lottie-web
        // https://elementor.com/widgets/lottie-widget/

        wp_enqueue_script('df-lottie-lib');
        wp_enqueue_script('df-lottie-control');

        $path = '';
        $props = $this->props;

        if( $props['lottie_file_options'] !== 'media') {
            $path = $props['external_file'];
        } else if( !empty( $props['upload'] ) ) {
            $path = $props['upload'];
        }

        $data_options = array(
            'path'              => $path,
            'loop'              => $props['loop'] === 'on' ? true : false,
            'speed'             => $props['speed'],
            'direction_reverse' => $props['direction_reverse'],
            'renderer'          => $props['renderer'],
            'animation_trigger' => $props['animation_trigger'],
            'threshold'         => $props['threshold'],
            'stop_on_mouse_out' => $props['stop_on_mouse_out'],
            'scroll_effect'     => $props['scroll_effect']
        );
        
        return sprintf( '<div class="df-lottie-image-container" data-options=\'%1$s\'>
                <div class="df-lottie-image"></div>
            </div>', 
        wp_json_encode($data_options) );
    }
}
new DIFL_LottieImage;