<?php
if ( ! class_exists( 'ET_Builder_Element' ) ) {
	return;
}
trait DF_Background {
    /**
     * add background field
     */
    function df_add_bg_field( $args = array() )
    {
        $default    = array(
            'label'				=> '',
            'key'               => '',
            'toggle_slug'       => '',
            'sub_toggle'		=> null,
            'tab_slug'			=> '',
            'mobile_options'    => true,
            'hover'				=> 'tabs',
            'color'             => true,
            'gradient'          => true,
            'image'             => true,
            'order_reverse'     => false,
            'show_if'           => null,
            'show_if_not'       => null,
            'prefix'            => 'Background',
            'suffix'            => 'background',
            'depends_show_if'   => '',
            'sticky'            => false
        );
        $args   = wp_parse_args( $args, $default );
        $fields = array();
        $key = $args['key'];

        $_fields = array(
            'label'               => sprintf(esc_html__('%1$s', 'divi_flash'), $args['label']),
            'tab_slug'            => $args['tab_slug'],
            'toggle_slug'         => $args['toggle_slug'],
            'attr_suffix'         => 'df',
            'type'                => 'composite',
            'hover'               => $args['hover'],
            'composite_type'      => 'default',
            'composite_structure' => array(),
            'show_if'             => $args['show_if'],
            'show_if_not'         => $args['show_if_not']
        );

        if(isset($args['priority']) && $args['priority'] !== '') {
            $_fields['priority'] = $args['priority'];
        }
        if($args['sub_toggle'] !== '') {
            $_fields['sub_toggle'] = $args['sub_toggle'];
        }
        if($args['depends_show_if'] !== '') {
            $_fields['depends_show_if'] = $args['depends_show_if'];
        }


        $background_fields = array();

        if ($args['color'] === true) {
            $background_fields['color'] = array (
                'icon'     => 'background-color',
                'controls' => array(
                    "{$key}_bgcolor" => array(
                        'label' => esc_html__( $args['prefix'] .' Color', 'divi_flash' ),
                        'type'  => 'color-alpha',
                        'hover' => $args['hover'],
                        'sticky' => $args['sticky']
                    ),
                ),
            );
        }

        if ($args['gradient'] === true) {
            $background_fields['color_gradient'] = array (
                'icon'     => 'background-gradient',
                'controls' => array(
                    "{$key}_use_gradient" => array(
                        'label'           => esc_html__( 'Use gradient ' . $args['suffix'], 'divi_flash' ),
                        'type'            => 'yes_no_button',
                        'options'           => array(
                            'on'  => esc_html__( 'On', 'divi_flash' ),
                            'off' => esc_html__( 'Off', 'divi_flash' ),
                        ),
                        'default'   => 'off'
                    ),
                    "{$key}_color_gradient_1" => array(
                        'label' => esc_html__( 'Select color', 'divi_flash' ),
                        'type'  => 'color-alpha',
                        'default'   => "#2b87da",
                        'show_if' => array(
                            "{$key}_use_gradient" => 'on'
                        ),
                        'hover' => $args['hover']
                    ),
                    "{$key}_color_gradient_2" => array(
                        'label' => esc_html__( 'Select color', 'divi_flash' ),
                        'type'  => 'color-alpha',
                        'default'   => "#29c4a9",
                        'show_if' => array(
                            "{$key}_use_gradient" => 'on'
                        ),
                        'hover' => $args['hover']
                    ),
                    "{$key}_gradient_type" => array(
                        'label' => esc_html__( 'Gradient Type', 'divi_flash' ),
                        'type'  => 'select',
                        'options'         => array(
                            'leniar'    => esc_html__( 'Linear', 'divi_flash' ),
                            'radial'    => esc_html__( 'Radial', 'divi_flash' )
                        ),
                        'default'   => 'leniar',
                        'show_if' => array(
                            "{$key}_use_gradient" => 'on'
                        ),
                        'hover'  => $args['hover'],
                    ),
                    "{$key}_radial_direction" => array(
                        'label' => esc_html__( 'Radial Direction', 'divi_flash' ),
                        'type'  => 'select',
                        'options'         => array(
                            'center'    => esc_html__( 'Center', 'divi_flash' ),
                            'top_left'    => esc_html__( 'Top Left', 'divi_flash' ),
                            'top'    => esc_html__( 'Top', 'divi_flash' ),
                            'top_right'    => esc_html__( 'Top Right', 'divi_flash' ),
                            'right'    => esc_html__( 'Right', 'divi_flash' ),
                            'bottom_right'    => esc_html__( 'Bottom Right', 'divi_flash' ),
                            'bottom'    => esc_html__( 'Bottom', 'divi_flash' ),
                            'bottom_left'    => esc_html__( 'Bottom Left', 'divi_flash' ),
                            'left'    => esc_html__( 'Left', 'divi_flash' ),
                        ),
                        'default'   => 'center',
                        'show_if' => array(
                            "{$key}_use_gradient" => 'on',
                            "{$key}_gradient_type" => 'radial'
                        ),
                        'hover'  => $args['hover'],
                    ),
                    "{$key}_gradient_direction" => array(
                        'label'             => esc_html__( 'Gradient Direction', 'divi_flash' ),
                        'type'              => 'range',
                        'default'           => '180deg',
                        'default_on_front'  => '',
                        'default_unit'      => 'deg',
                        'range_settings'         => array(
                            'min'    => '0',
                            'max'    => '360',
                            'step'    => '1'
                        ),
                        'show_if'           => array(
                            "{$key}_use_gradient" => 'on'
                        ),
                        'show_if_not'       => array(
                            "{$key}_gradient_type" => 'radial'
                        ),
                        'hover'  => $args['hover'],
                    ),
                    "{$key}_start_position" => array(
                        'label'           => esc_html__( 'Start Position', 'divi_flash' ),
                        'type'            => 'range',
                        'default'   => '0%',
                        'show_if' => array(
                            "{$key}_use_gradient" => 'on'
                        ),
                        'hover'  => $args['hover'],
                    ),
                    "{$key}_end_position" => array(
                        'label'           => esc_html__( 'End Position', 'divi_flash' ),
                        'type'            => 'range',
                        'default'   => '100%',
                        'show_if' => array(
                            "{$key}_use_gradient" => 'on'
                        ),
                        'hover'  => $args['hover'],
                    )
                )
            );

            if ($args['image'] === true){
                $background_fields['color_gradient']['controls']["{$key}_above_image"] =  array(
                    'label'           => esc_html__( 'Place Gradient Above Background Image', 'divi_flash' ),
                    'type'            => 'yes_no_button',
                    'options'           => array(
                        'on'  => esc_html__( 'On', 'divi_flash' ),
                        'off' => esc_html__( 'Off', 'divi_flash' ),
                    ),
                    'show_if' => array(
                        "{$key}_use_gradient" => 'on'
                    )
                );
            }

        }

        if ($args['image'] === true) {
            $background_fields['image'] = array (
                'icon'     => 'background-image',
                'controls' => array(
                    "{$key}_background_image" => array(
                        'label' => esc_html__( 'Background Image', 'divi_flash' ),
                        'type'  => 'upload',
                        'upload_button_text' => esc_attr__( 'Set Image', 'divi_flash' ),
                        'hover'  => $args['hover'],
                    ),
                    "{$key}_background_image_size" => array(
                        'label' => esc_html__( 'Background Image Size', 'divi_flash' ),
                        'type'  => 'select',
                        'options'         => array(
                            'cover'    => esc_html__( 'Cover', 'divi_flash' ),
                            'fit'    => esc_html__( 'Fit', 'divi_flash' ),
                            'actual_size'    => esc_html__( 'Actual Size', 'divi_flash' ),
                            'custom'    => esc_html__('Custom Size', 'divi_flash')
                        ),
                        'default'   => 'cover',
                        'hover' => $args['hover'],
                    ),
                    "{$key}_size_width" => array(
                        'label'             => esc_html__( 'Background Width', 'divi_flash' ),
                        'type'              => 'range',
                        'default'           => '50%',
                        'default_on_front'  => '',
                        'default_unit'      => '%',
                        'range_settings'         => array(
                            'min'    => '0',
                            'max'    => '100',
                            'step'    => '1'
                        ),
                        'show_if'           => array(
                            "{$key}_background_image_size" => 'custom'
                        ),
                        'hover'  => $args['hover'],
                    ),
                    "{$key}_size_height" => array(
                        'label'             => esc_html__( 'Background Height', 'divi_flash' ),
                        'type'              => 'range',
                        'default'           => '50%',
                        'default_on_front'  => '',
                        'default_unit'      => '%',
                        'range_settings'         => array(
                            'min'    => '0',
                            'max'    => '100',
                            'step'    => '1'
                        ),
                        'show_if'           => array(
                            "{$key}_background_image_size" => 'custom'
                        ),
                        'hover'  => $args['hover'],
                    ),
                    "{$key}_size_width" => array(
                        'label'             => esc_html__( 'Background Width', 'divi_flash' ),
                        'type'              => 'range',
                        'default'           => '50%',
                        'default_on_front'  => '',
                        'default_unit'      => '%',
                        'range_settings'         => array(
                            'min'    => '0',
                            'max'    => '100',
                            'step'    => '1'
                        ),
                        'show_if'           => array(
                            "{$key}_background_image_size" => 'custom'
                        ),
                        'hover'  => $args['hover'],
                    ),
                    "{$key}_size_height" => array(
                        'label'             => esc_html__( 'Background Height', 'divi_flash' ),
                        'type'              => 'range',
                        'default'           => '50%',
                        'default_on_front'  => '',
                        'default_unit'      => '%',
                        'range_settings'         => array(
                            'min'    => '0',
                            'max'    => '100',
                            'step'    => '1'
                        ),
                        'show_if'           => array(
                            "{$key}_background_image_size" => 'custom'
                        ),
                        'hover'  => $args['hover'],
                    ),
                    "{$key}_background_image_position" => array(
                        'label' => esc_html__( 'Background Image Position', 'divi_flash' ),
                        'type'  => 'select',
                        'options'         => array(
                            'top_left'    => esc_html__( 'Top Left', 'divi_flash' ),
                            'top_center'    => esc_html__( 'Top Center', 'divi_flash' ),
                            'top_right'    => esc_html__( 'Top Right', 'divi_flash' ),
                            'center_left'    => esc_html__( 'Center Left', 'divi_flash' ),
                            'center'    => esc_html__( 'Center', 'divi_flash' ),
                            'center_right'    => esc_html__( 'Center Right', 'divi_flash' ),
                            'bottom_left'    => esc_html__( 'Bottom Left', 'divi_flash' ),
                            'bottom_center'    => esc_html__( 'Bottom Center', 'divi_flash' ),
                            'bottom_right'    => esc_html__( 'Bottom Right', 'divi_flash' ),
                            'custom'          => esc_html__('Custom Position', 'divi_flash')
                        ),
                        'default'   => 'center',
                        'hover' => $args['hover'],
                    ),
                    "{$key}_position_horizontal" => array(
                        'label'             => esc_html__( 'Horizontal Position', 'divi_flash' ),
                        'type'              => 'range',
                        'default'           => '0px',
                        'default_on_front'  => '',
                        'default_unit'      => 'px',
                        'range_settings'         => array(
                            'min'    => '0',
                            'max'    => '1000',
                            'step'    => '1'
                        ),
                        'show_if'           => array(
                            "{$key}_background_image_position" => 'custom'
                        ),
                        'hover'  => $args['hover'],
                    ),
                    "{$key}_position_vertical" => array(
                        'label'             => esc_html__( 'Vertical Position', 'divi_flash' ),
                        'type'              => 'range',
                        'default'           => '0px',
                        'default_on_front'  => '',
                        'default_unit'      => 'px',
                        'range_settings'         => array(
                            'min'    => '0',
                            'max'    => '1000',
                            'step'    => '1'
                        ),
                        'show_if'           => array(
                            "{$key}_background_image_position" => 'custom'
                        ),
                        'hover'  => $args['hover'],
                    ),
                    "{$key}_position_horizontal" => array(
                        'label'             => esc_html__( 'Horizontal Position', 'divi_flash' ),
                        'type'              => 'range',
                        'default'           => '0px',
                        'default_on_front'  => '',
                        'default_unit'      => 'px',
                        'range_settings'         => array(
                            'min'    => '0',
                            'max'    => '1000',
                            'step'    => '1'
                        ),
                        'show_if'           => array(
                            "{$key}_background_image_position" => 'custom'
                        ),
                        'hover'  => $args['hover'],
                    ),
                    "{$key}_position_vertical" => array(
                        'label'             => esc_html__( 'Vertical Position', 'divi_flash' ),
                        'type'              => 'range',
                        'default'           => '0px',
                        'default_on_front'  => '',
                        'default_unit'      => 'px',
                        'range_settings'         => array(
                            'min'    => '0',
                            'max'    => '1000',
                            'step'    => '1'
                        ),
                        'show_if'           => array(
                            "{$key}_background_image_position" => 'custom'
                        ),
                        'hover'  => $args['hover'],
                    ),
                    "{$key}_background_image_repeat" => array(
                        'label' => esc_html__( 'Background Image Repeat', 'divi_flash' ),
                        'type'  => 'select',
                        'options'         => array(
                            'no_repeat'    => esc_html__( 'No Repeat', 'divi_flash' ),
                            'repeat'    => esc_html__( 'Repeat', 'divi_flash' ),
                            'repeat_x'    => esc_html__( 'Repeat X (horizontal)', 'divi_flash' ),
                            'repeat_y'    => esc_html__( 'Repeat Y (vertical)', 'divi_flash' ),
                            'space'    => esc_html__( 'Space', 'divi_flash' ),
                            'round'    => esc_html__( 'Round', 'divi_flash' ),
                        ),
                        'default'   => 'no_repeat',
                        'hover' => $args['hover'],
                    )
                ),
            );
        }
        if ($args['order_reverse'] === true) {
            $background_fields = array_reverse($background_fields);
        }

        $_fields['composite_structure'] = $background_fields;

        $fields[$args['key']] = $_fields;

        return $fields;
    }
}