<?php
require_once ( __DIR__ . '/masks.php');

class DIFL_ImageMask extends ET_Builder_Module {
    public $slug       = 'difl_imagemask';
    public $vb_support = 'on';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Image Mask', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/image-masking.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'image'                 => esc_html__('Image', 'divi_flash'),
                    'mask_settings'         => esc_html__('Mask Settings', 'divi_flash')
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
        // $advanced_fields['borders'] = false;
        // $advanced_fields['box_shadow'] = false;
    
        return $advanced_fields;
    }

    public function get_fields() {
        $general = array (
            'image' => array (
                'label'                 => esc_html__( 'Image', 'divi_flash' ),
				'type'                  => 'upload',
                'option_category'       => 'basic_option',
				'upload_button_text'    => esc_attr__( 'Upload an image', 'divi_flash' ),
				'choose_text'           => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'           => esc_attr__( 'Set As Image', 'divi_flash' ),
                'toggle_slug'           => 'image',
                'dynamic_content'       =>'image'
            ),
            'alt_text' => array (
                'label'                 => esc_html__( 'Image Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'image'
            )
        );
        $settings = array (
            'mask_size'             => array (
                'label'             => esc_html__( 'Mask Size', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'mask_settings',
				'default'           => '80',
                'default_unit'      => '%',
                'allowed_units'     => array ('%'),
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
            ),
            'mask_position'   => array(
                'label'     => esc_html__('Mask Position', 'divi_flash'),
                'type'      => 'select',
                'options'   => array(
                    'top_left'    => esc_html__( 'Top Left', 'divi_flash' ),
                    'top_center'    => esc_html__( 'Top Center', 'divi_flash' ),
                    'top_right'    => esc_html__( 'Top Right', 'divi_flash' ),
                    'center_left'    => esc_html__( 'Center Left', 'divi_flash' ),
                    'center'    => esc_html__( 'Center', 'divi_flash' ),
                    'center_right'    => esc_html__( 'Center Right', 'divi_flash' ),
                    'bottom_left'    => esc_html__( 'Bottom Left', 'divi_flash' ),
                    'bottom_center'    => esc_html__( 'Bottom Center', 'divi_flash' ),
                    'bottom_right'    => esc_html__( 'Bottom Right', 'divi_flash' ),
                ),
                'default'       => 'center',
                'toggle_slug'   => 'mask_settings',
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'mask_select'   => array(
                'label'     => esc_html__('Select Mask', 'divi_flash'),
                'type'      => 'select',
                'options'   => array(
                    'mask_image_01'    => esc_html__( 'Mask 1', 'divi_flash' ),
                    'mask_image_02'    => esc_html__( 'Mask 2', 'divi_flash' ),
                    'mask_image_03'    => esc_html__( 'Mask 3', 'divi_flash' ),
                    'mask_image_04'    => esc_html__( 'Mask 4', 'divi_flash' ),
                    'mask_image_05'    => esc_html__( 'Mask 5', 'divi_flash' ),
                    'mask_image_06'    => esc_html__( 'Mask 6', 'divi_flash' ),
                    'mask_image_07'    => esc_html__( 'Mask 7', 'divi_flash' ),
                    'mask_image_08'    => esc_html__( 'Mask 8', 'divi_flash' ),
                    'mask_image_09'    => esc_html__( 'Mask 9', 'divi_flash' ),
                    'mask_image_10'    => esc_html__( 'Mask 10', 'divi_flash' ),
                    'mask_image_11'    => esc_html__( 'Mask 11', 'divi_flash' ),
                    'mask_image_12'    => esc_html__( 'Mask 12', 'divi_flash' ),
                    'mask_image_13'    => esc_html__( 'Mask 13', 'divi_flash' ),
                    'mask_image_14'    => esc_html__( 'Mask 14', 'divi_flash' ),
                    'mask_image_15'    => esc_html__( 'Mask 15', 'divi_flash' ),
                    'mask_image_16'    => esc_html__( 'Mask 16', 'divi_flash' ),
                    'mask_image_17'    => esc_html__( 'Mask 17', 'divi_flash' ),
                    'mask_image_18'    => esc_html__( 'Mask 18', 'divi_flash' ),
                    'mask_image_19'    => esc_html__( 'Mask 19', 'divi_flash' ),
                    'mask_image_20'    => esc_html__( 'Mask 20', 'divi_flash' ),
                    'mask_image_21'    => esc_html__( 'Mask 21', 'divi_flash' ),
                    'mask_image_22'    => esc_html__( 'Mask 22', 'divi_flash' ),
                    'mask_image_23'    => esc_html__( 'Mask 23', 'divi_flash' ),
                    'mask_image_24'    => esc_html__( 'Mask 24', 'divi_flash' ),
                    'mask_image_25'    => esc_html__( 'Mask 25', 'divi_flash' ),
                    'mask_image_26'    => esc_html__( 'Mask 26', 'divi_flash' ),
                    'mask_image_27'    => esc_html__( 'Mask 27', 'divi_flash' ),
                    'mask_image_28'    => esc_html__( 'Mask 28', 'divi_flash' ),
                    'mask_image_29'    => esc_html__( 'Mask 29', 'divi_flash' ),
                    'mask_image_30'    => esc_html__( 'Mask 30', 'divi_flash' )
                ),
                'default'       => 'mask_image_01',
                'toggle_slug'   => 'mask_settings'
            ),
            'image_full_width'      => array (
                'label'             => esc_html__('Image Force Full Width', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'mask_settings'
            ),
            'mask_rotate'           => array (
                'label'             => esc_html__( 'Rotate', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'mask_settings',
				'default'           => '0',
                'default_unit'      => 'deg',
                'allowed_units'     => array ('deg'),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '360',
					'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
            ),
        );

        return array_merge(
            $general,
            $settings
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        return $fields;
    }
    
    public function additional_css_styles($render_slug) {

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .df_im_container',
            'declaration' => sprintf('-webkit-mask-image: url("%1$s");
                    mask-image: url("%1$s");',
                get_mask_image($this->props['mask_select'])
            )
        ));
        $this->df_process_range( array (
            'render_slug'       => $render_slug,
            'slug'              => 'mask_size',
            'type'              => '-webkit-mask-size',
            'selector'          => '%%order_class%% .df_im_container',
            'default'           => '80%'
        ));
        $this->df_process_range( array (
            'render_slug'       => $render_slug,
            'slug'              => 'mask_size',
            'type'              => 'mask-size',
            'selector'          => '%%order_class%% .df_im_container',
            'default'           => '80%'
        ));
        
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'mask_position',
            'type'              => '-webkit-mask-position',
            'selector'          => '%%order_class%% .df_im_container',
            'default'           => 'inline-block'
        ));
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'mask_position',
            'type'              => 'mask-position',
            'selector'          => '%%order_class%% .df_im_container',
            'default'           => 'inline-block'
        ));
        if($this->props['image_full_width'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_im_container img',
                'declaration' => 'width: 100%;'
            ));
        }

        $this->df_process_transform(array(
            'render_slug'       => $render_slug,
            'selector'          => '%%order_class%% .df_im_container',
            'transforms'        => [
                [
                    'type' => 'rotate',
                    'unit' => 'px',
                    'slug'  => 'mask_rotate'
                ]
            ]
        ));
        $this->df_process_transform(array(
            'render_slug'       => $render_slug,
            'selector'          => '%%order_class%% .df_im_container img',
            'oposite'           => true,
            'transforms'        => [
                [
                    'type' => 'rotate',
                    'unit' => 'px',
                    'slug'  => 'mask_rotate'
                ]
            ]
        ));

    }

    public function render( $attrs, $content, $render_slug ) {
        $this->additional_css_styles($render_slug);
        $image_alt = $this->props['alt_text'] !== '' ? $this->props['alt_text']  : df_image_alt_by_url($this->props['image']);
        $image = $this->props['image'] !== '' ?
            sprintf('<img src="%1$s" alt="%2$s" />',
            esc_attr($this->props['image']), 
            esc_attr($image_alt)) : '';
        
        return sprintf('<div class="df_im_container">%1$s</div>', $image);
    }
}
new DIFL_ImageMask;