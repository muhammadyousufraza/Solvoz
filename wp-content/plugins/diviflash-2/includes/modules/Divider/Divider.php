<?php

class DIFL_Divider extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_divider';
    public $vb_support = 'on';
	public $icon_path;
    use DF_UTLS;

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Advanced Divider', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/divider.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'line_settings'          => esc_html__( 'Line Settings', 'divi_flash' ),
                    'separator_icon_settings'            => esc_html__( 'Separator Settings', 'divi_flash' ),
                    'lottie_settings'          => esc_html__( 'Lottie Settings', 'divi_flash' )
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'alignment'             => esc_html__('Alignment', 'divi_flash'),
                    'line_settings'         => esc_html__('Line'),
                    'custom_line'         => esc_html__('Custom Line'),
                    'separator_icon_settings'           => esc_html__('Separator Style' , 'divi_flash'),
                    'separator_text'           => esc_html__('Separator Text' , 'divi_flash'),
                    'custom_spacing'        => esc_html__('Custom Spacing', 'divi_flash')
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();
        $advanced_fields['fonts'] = array(
            'separator'   => array(
				'label'         => esc_html__( 'Separator', 'divi_flash' ),
				'toggle_slug'   => 'separator_text',
				'tab_slug'		=> 'advanced',
				'hide_text_shadow'  => true,
				'line_height' => array(
						'default' => '1.7em',
					),
					'font_size' => array(
						'default' => '16px',
					),
				'css'      => array(
					'main' => "%%order_class%% .difl-divider-icon .difl-divider-icon-text",
					'important' => 'all',
				),
			)
        );
        $advanced_fields['borders'] = array(
            'default'        => true,
            'custom_divider_border'             => array(
                'css'             => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .difl-divider-custom .difl-divider-left-side hr , %%order_class%% .difl-divider-custom .difl-divider-right-side hr",
                        'border_styles' => "%%order_class%% .difl-divider-custom .difl-divider-left-side hr , %%order_class%% .difl-divider-custom .difl-divider-right-side hr",
                        'border_styles_hover' => "%%order_class%% .difl-divider-custom .difl-divider-left-side hr:hover , %%order_class%% .difl-divider-custom .difl-divider-right-side hr:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'custom_line',
            ),

            'icon_border'             => array(
                'css'             => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .difl-divider-icon",
                        'border_styles' => "%%order_class%% .difl-divider-icon",
                        'border_styles_hover' => "%%order_class%% .difl-divider-icon:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'separator_icon_settings',
            ),

        );
        $advanced_fields['box_shadow'] = array(
            'default'        => true,
            'custom_divider_box_shadow'             => array(
                'css' => array(
                    'main' => " %%order_class%%  .difl-divider-shadow .difl-divider-left-side hr,
                                %%order_class%%  .difl-divider-shadow .difl-divider-right-side hr,
                                %%order_class%% .difl-divider-custom .difl-divider-left-side hr,
                                %%order_class%% .difl-divider-custom .difl-divider-right-side hr",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'custom_line',
            ),
            'icon_box_shadow'             => array(
                'css' => array(
                    'main' => "%%order_class%% .difl-divider-icon",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'separator_icon_settings',
            )
        );
        $advanced_fields['text'] = false;
        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'important' => 'all'
            )
        );
        return $advanced_fields;
    }

	public function get_fields() {

        $genarel_settings = array(

            'divider_type'   => array(
                'label'             => esc_html__('Divider Type', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'solid'         => esc_html__('Solid', 'divi_flash'),
                    'dashed'        => esc_html__('Dashed', 'divi_flash'),
                    'dotted'        => esc_html__('Dotted', 'divi_flash'),
                    'double'        => esc_html__('Double', 'divi_flash'),
                    'groove'        => esc_html__('Groove', 'divi_flash'),
                    'ridge'         => esc_html__('Ridge', 'divi_flash'),
                    'gradient'      => esc_html__('Gradient', 'divi_flash'),
                    'curvedtop'     => esc_html__('Curved Top', 'divi_flash'),
                    'curvedbot'     => esc_html__('Curved Bottom', 'divi_flash'),
                    'custom'        => esc_html__('Custom', 'divi_flash'),
                ),
                'default'           => 'solid',
                'toggle_slug'       => 'line_settings',
            ),
            'use_multiple_line'    => array(
                'label'             => esc_html__('Multiple Line', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'line_settings'
            ),

            'line_number' => array(
                'label'             => esc_html__('Line Number', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'line_settings',
                'default'           => '2',
                'unitless'          => true,
                'range_settings'    => array(
                    'min'  => '2',
                    'max'  => '10',
                    'step' => '1',
                    'min_limit' => 2,
				    'max_limit' => 100,
                ),
                'show_if'           => array(
                    'use_multiple_line' => 'on'
                )
            ),

            'multiple_line_gap' => array(
                'label'             => esc_html__('Line Gap ', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'line_settings',
                'default'           => '10px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'responsive'        => true,
                'mobile_options'    => true,
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                    'min_limit' => 0,
				    'max_limit' => 100,
                ),
                'show_if'           => array(
                    'use_multiple_line' => 'on'
                )
            ),

            'separetor_type'   => array(
                'label'             => esc_html__('Separetor Type', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'icon'         => esc_html__('Icon', 'divi_flash'),
                    'text'         => esc_html__('Text', 'divi_flash'),
                    'lottie'         => esc_html__('Lottie', 'divi_flash'),
                    'no'         => esc_html__('No Separator', 'divi_flash'),
                ),
                'default'           => 'icon',
                'toggle_slug'       => 'separator_icon_settings',
            )
        );
        $separator_icon_settings = array(

            'use_image_as_icon'    => array(
                'label'             => esc_html__('Image as Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'separator_icon_settings',
                'show_if'           => array(
                    'separetor_type' => 'icon'
                )
            ),
            'image_as_icon' => array(
                'label'                 => esc_html__('Image', 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'upload_button_text'    => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'separator_icon_settings',
                'show_if'         => array(
                    'use_image_as_icon' => 'on',
                    'separetor_type' => 'icon'
                )

            ),
            'image_alt_text' => array (
                'label'                 => esc_html__( 'Image Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'separator_icon_settings',
                'show_if'         => array(
                    'use_image_as_icon' => 'on',
                    'separetor_type' => 'icon'
                )
            ),
            'image_as_icon_width' => array(
                'label'             => esc_html__('Image as Icon Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'separator_icon_settings',
                'tab_slug'          => 'advanced',
                'default'           => '30px',
                'default_unit'      => 'px',
                'allowed_units'     => array('%', 'px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'show_if'           => array(
                    'use_image_as_icon' => 'on',
                    'separetor_type' => 'icon'
                )
            ),

            'lottie_image_width' => array(
                'label'             => esc_html__('Lottie Image Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'separator_icon_settings',
                'tab_slug'          => 'advanced',
                'default'           => '80px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '200',
                    'step' => '1',
                    'min_limit'=> 1
                ),
                'responsive'        => true,
                'show_if'           => array(
                    'separetor_type' => 'lottie'
                )
            ),

            'font_icon'                 => array(
				'label'                 => esc_html__( 'Icon', 'divi_flash' ),
				'type'                  => 'select_icon',
				'option_category'       => 'basic_option',
				'class'                 => array( 'et-pb-font-icon' ),
                'toggle_slug'           => 'separator_icon_settings',
                'show_if'           => array(
                    'use_image_as_icon' => 'off',
                    'separetor_type' => 'icon'
                )
            ),
            'icon_image_alignment' => array(
                'label'             => esc_html__( 'Icon/Image  Alignment', 'divi_flash' ),
				'type'              => 'text_align',
                'toggle_slug'       => 'separator_icon_settings',
				'options'           =>  et_builder_get_text_orientation_options( array( 'justified' ) ),
                'show_if_not'       => array(
                    'separetor_type' => 'no'
                )
            ),
            'icon_color'            => array (
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
                'toggle_slug'       => 'separator_icon_settings',
                'tab_slug'          => 'advanced',
                'hover'             => 'tabs',
                'show_if'           => array(
                    'use_image_as_icon' => 'off',
                    'separetor_type' => 'icon'
                )
            ),
            'icon_size'             => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'toggle_slug'       => 'separator_icon_settings',
                'tab_slug'          => 'advanced',
                'default'           => '30px',
                'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
                'responsive'        => true,
                'show_if'           => array(
                    'use_image_as_icon' => 'off',
                    'separetor_type' => 'icon'
                )
            )

        );
        $icon_spacing = $this->add_margin_padding(array(
            'title'         => 'Separetor',
            'key'           => 'separetor',
            'toggle_slug'   => 'custom_spacing',
            'tab_slug'      => 'advanced'
        ));

        $text_settings = array(
            'title' => array (
                'label'                 => esc_html__( 'Title', 'divi_flash' ),
				'type'                  => 'text',
                'dynamic_content'       => 'text',
                'toggle_slug'           => 'separator_icon_settings',
                'show_if'           => array(
                    'separetor_type' => 'text'
                )
            ),

            'title_tag' => array (
                'default'         => 'h3',
                'label'           => esc_html__( 'Title Tag', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'h1'    => esc_html__( 'h1 tag', 'divi_flash' ),
                    'h2'    => esc_html__( 'h2 tag', 'divi_flash' ),
                    'h3'    => esc_html__( 'h3 tag', 'divi_flash' ),
                    'h4'    => esc_html__( 'h4 tag', 'divi_flash' ),
                    'h5'    => esc_html__( 'h5 tag', 'divi_flash' ),
                    'h6'    => esc_html__( 'h6 tag', 'divi_flash'),
                    'p'     => esc_html__( 'p tag', 'divi_flash'),
                    'span'  => esc_html__( 'span tag', 'divi_flash'),
                    'div'  => esc_html__( 'div tag', 'divi_flash')
                ),
                'toggle_slug'   => 'separator_icon_settings',
                'show_if'           => array(
                    'separetor_type' => 'text'
                )
            ),
        );

        $lottie_source = array(
            'lottie_file_options'      => array (
                'label'                 => esc_html__( 'Lottie File Location', 'divi_flash' ),
				'type'                  => 'select',
				'options'               => array(
					'external'      => esc_html__( 'External File URL', 'divi_flash' ),
					'media'         => esc_html__( 'From Media', 'divi_flash' ),
                ),
                'toggle_slug'           => 'separator_icon_settings',
                'default'               => 'external',
                'show_if'           => array(
                    'separetor_type' => 'lottie'
                )
            ),
            'external_file'         => array (
                'label'             => esc_html__('URL', 'divi_flash'),
                'type'              => 'text',
                'toggle_slug'       => 'separator_icon_settings',
                'show_if_not'       => array(
                    'lottie_file_options' => 'media',
                ),
                'show_if'           => array(
                    'separetor_type' => 'lottie'
                )
            ),
            'upload' => array(
				'label'              => esc_html__( 'Upload', 'et_builder' ),
				'type'               => 'upload',
				'upload_button_text' => esc_attr__( 'Upload a JSON', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose a JSON', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As JSON', 'et_builder' ),
				'toggle_slug'        => 'separator_icon_settings',
                'data_type'          => 'josn',
                'show_if'            => array(
                    'lottie_file_options' => 'media',
                    'separetor_type' => 'lottie'
                )
			),

            'json_ex_notice'      => array(
                'type'                  => 'df_json_ex_notice',
                'tab_slug'              => 'general',
                'toggle_slug'           => 'separator_icon_settings',
                'options'               => array(
                    'lottie_file_options' => 'media'
                )
            ),
        );
        $lottie_settings = array(
            'animation_trigger'      => array (
                'label'                 => esc_html__( 'Animation trigger', 'divi_flash' ),
				'type'                  => 'select',
				'options'               => array(
					'viewport'           => esc_html__( 'Viewport', 'divi_flash' ),
					'on_click'            => esc_html__( 'On Click', 'divi_flash' ),
					'on_hover'            => esc_html__( 'On Hover', 'divi_flash' ),
					'none'                => esc_html__( 'None', 'divi_flash' )
                ),
                'toggle_slug'           => 'lottie_settings',
                'default'               => 'none',
                'show_if'               => array(
                    'separetor_type' => 'lottie'
                )

            ),

            'stop_on_mouse_out'      => array (
                'label'                 => esc_html__( 'Pause Animation Mouse Leave', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off'           => esc_html__( 'OFF', 'divi_flash' ),
					'on'            => esc_html__( 'ON', 'divi_flash' ),
                ),
                'toggle_slug'           => 'lottie_settings',
                'default'               => 'off',
                'show_if'               => array(
                    'animation_trigger' => 'on_hover',
                    'separetor_type' => 'lottie'
                )
            ),
            'threshold'       => array (
                'label'             => esc_html__( 'Threshold', 'divi_flash' ),
                'description'       => esc_html__( 'It has a default value of zero, which means that as soon as a user approaches the target element and it becomes visible', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'lottie_settings',
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
                    'animation_trigger'        => 'viewport',
                    'separetor_type' => 'lottie'
                )
            ),
            'loop'      => array (
                'label'                 => esc_html__( 'Loop', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off'           => esc_html__( 'OFF', 'divi_flash' ),
					'on'            => esc_html__( 'ON', 'divi_flash' ),
                ),
                'toggle_slug'           => 'lottie_settings',
                'default'               => 'on',
                'show_if'               => array(
                    'separetor_type' => 'lottie'
                )
            ),
            'speed'       => array (
                'label'             => esc_html__( 'Animation Speed', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'lottie_settings',
				'default'           => '1',
                'default_unit'      => '',
                'allowed_units'     => array (''),
                'validate_unit'     => false,
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '15',
					'step' => '.5',
                ),
                'show_if'               => array(
                    'separetor_type' => 'lottie'
                )
            ),
            'direction_reverse'      => array (
                'label'                 => esc_html__( 'Reverse Direction', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'options'               => array(
					'off'           => esc_html__( 'OFF', 'divi_flash' ),
					'on'            => esc_html__( 'ON', 'divi_flash' ),
                ),
                'toggle_slug'           => 'lottie_settings',
                'default'               => 'off',
                'show_if'               => array(
                    'separetor_type' => 'lottie'
                )
            ),
            'renderer'      => array (
                'label'                 => esc_html__( 'Renderer', 'divi_flash' ),
				'type'                  => 'select',
				'options'               => array(
					'svg'               => esc_html__( 'SVG', 'divi_flash' ),
					'canvas'            => esc_html__( 'Canvas', 'divi_flash' )
                ),
                'toggle_slug'           => 'lottie_settings',
                'default'               => 'svg',
                'show_if'               => array(
                    'separetor_type' => 'lottie'
                )
            ),
        );
        $divider_line_settings = array(
            'divider_line_color' => array(
				'default'           => "#2ea3f2",
				'label'             => esc_html__( 'Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for Line.', 'divi_flash' ),
				'depends_show_if'   => 'on',
				'toggle_slug'       => 'line_settings',
                'tab_slug'          => 'advanced' ,
                'hover'             => 'tabs',
                'show_if_not' => array(
                    'divider_type' => array('gradient', 'custom')
                )
            ),
            'divider_right_line_color' => array(
				'label'             => esc_html__( 'Right Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'if you want to use different color on right side, here you can define color', 'divi_flash' ),
				'depends_show_if'   => 'on',
				'toggle_slug'       => 'line_settings',
                'tab_slug'          => 'advanced' ,
                'hover'             => 'tabs',
                'show_if_not' => array(
                    'divider_type' => array('gradient', 'custom')
                )
            ),
            'divider_line_width' => array(
                'label'             => esc_html__('Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'line_settings',
                'tab_slug'          => 'advanced',
                'default'           => '3px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '30',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'divider_width' => array(
                'label'             => esc_html__('Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'line_settings',
                'tab_slug'          => 'advanced',
                'default'           => '100%',
                'allowed_units'     => array('%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'        => true,
                'mobile_options'    => true,
            ),
            'line_alignment' => array(
                'label'           => esc_html__('Line Alignment', 'divi_flash'),
                'type'            => 'text_align',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'     => 'line_settings',
                'tab_slug'        => 'advanced',
                'mobile_options'  => true
            ),
            'divider_left_line_width' => array(
                'label'             => esc_html__('Left Offset', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'line_settings',
                'tab_slug'          => 'advanced',
                'default'           => '50%',
                'default_unit'      => '%',
                'allowed_units'     => array('%','px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true
            ),

            'divider_right_line_width' => array(
                'label'             => esc_html__('Right Offset', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'line_settings',
                'tab_slug'          => 'advanced',
                'default'           => '50%',
                'default_unit'      => '%',
                'allowed_units'     => array('%','px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'divider_line_spacing' => array(
                'label'             => esc_html__('Space Between Line', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'line_settings',
                'tab_slug'          => 'advanced',
                'default'           => '0px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '30',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'hover'             => 'tabs'
            ),
            'line_placement'      => array (
                'label'                 => esc_html__( 'Line Placement', 'divi_flash' ),
                'type'                  => 'select',
                'options'               => array(
                    'flex-start'            => esc_html__( 'Top', 'divi_flash' ),
                    'center'               => esc_html__( 'Center', 'divi_flash' ),
                    'flex-end'            => esc_html__( 'Bottom', 'divi_flash' )
                ),
                'toggle_slug'       => 'line_settings',
                'tab_slug'          => 'advanced',
                'default'           => 'center',
                'show_if_not' => array(
                    'separetor_type' => array('no')
                )
            ),
        );

        $divider_line_bg = $this->df_add_bg_field(array(
            'label'                 => 'Line Background',
            'key'                   => 'divider_line_bg',
            'description'       => esc_html__( 'Here you can define a custom color for Line.', 'divi_flash' ),
            'toggle_slug'           => 'line_settings',
            'image'                 => false,
            'order_reverse'         => false,
            'tab_slug'              => 'advanced',
            'show_if' => array(
                'divider_type' => array('gradient', 'custom')
            )
        ));

        $divider_right_line_bg = $this->df_add_bg_field(array(
            'label'                 => 'Right Line Background',
            'description'       => esc_html__( 'Here you can define a custom color for Line.', 'divi_flash' ),
            'key'                   => 'divider_right_line_bg',
            'toggle_slug'           => 'line_settings',
            'image'                 => false,
            'order_reverse'         => false,
            'tab_slug'              => 'advanced',
            'show_if' => array(
                'divider_type' => array('gradient', 'custom')
            )
        ));
        $icon_bg = $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'icon_background',
            'toggle_slug'           => 'separator_icon_settings',
            'image'                 => false,
            'tab_slug'              => 'advanced',
            'show_if_not' => array(
                'separetor_type' => 'no'
            )
        ));

		return array_merge(
            $genarel_settings,
            $icon_bg,
            $text_settings,
            $lottie_source,
            $lottie_settings,
            $separator_icon_settings,
            $divider_line_bg,
            $divider_right_line_bg,
            $divider_line_settings,
            $icon_spacing
        );
    }
    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $icon = '%%order_class%% .difl-divider-icon';
        $left_line = "%%order_class%% .difl-divider-left-side";
        $right_line = "%%order_class%% .difl-divider-left-side";
        // spacing
        $fields['separetor_margin'] = array('margin' => $icon);
        $fields['separetor_padding'] = array('padding' => $icon);
        // $fields['line_margin'] = array('margin' => $left_line);
        // $fields['line_margin'] = array('margin' => $right_line);

        $fields['divider_line_spacing'] = array('padding' => $left_line);
        $fields['divider_line_spacing'] = array('padding' => $right_line);
        // Color
        $fields['divider_line_color'] = array('border-top-color' => '%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-left-side hr , %%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-right-side hr');

        // background
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'icon_background',
            'selector'      => $icon
        ));

        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'divider_line_bg',
            'selector'      => "%%order_class%% .difl-divider-left-side hr,
                                %%order_class%% .difl-divider-right-side hr"
        ));

        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'divider_right_line_bg',
            'selector'      => "%%order_class%% .difl-divider-right-side hr"
        ));

        // border fix
        $fields = $this->df_fix_border_transition(
            $fields,
            'icon_border',
            $icon
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'custom_divider_border',
            "%%order_class%% .difl-divider-custom .difl-divider-left-side hr , %%order_class%% .difl-divider-custom .difl-divider-right-side hr"
        );

        // box-shadow Fix
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'icon_box_shadow',
            $icon
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'custom_divider_box_shadow',
            "%%order_class%% .difl-divider-custom .difl-divider-left-side hr , %%order_class%% .difl-divider-custom .difl-divider-right-side hr"
        );

        return $fields;
    }

    public function additional_css_styles($render_slug){

        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'line_alignment',
            'type'              => 'text-align',
            'selector'          => "%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider",
            'default'           => 'center'
        ));

         // Item Icon
         if ('icon' === $this->props['separetor_type']) {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_color',
                'type'              => 'color',
                'selector'          => "%%order_class%% .et-pb-icon.difl-divider-icon",
                'hover'             => '%%order_class%% .et-pb-icon.df-image-accordion-icon:hover'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_size',
                'type'              => 'font-size',
                'default_unit'      => 'px',
                'selector'          => "%%order_class%% .et-pb-icon.difl-divider-icon",
                'hover'             => '%%order_class%% .et-pb-icon.difl-divider-icon:hover',
                'important'         => 'true'
            ));

        }

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_background',
            'selector'          => "%%order_class%% .difl-divider-icon",
            'hover'             => '%%order_class%% .difl-divider-icon:hover'
        ));

        // Icon spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'separetor_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .difl-divider-icon",
            'hover'             => "{$this->main_css_element} .difl-divider-icon:hover"
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'separetor_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .difl-divider-icon",
            'hover'             => "{$this->main_css_element} .difl-divider-icon:hover"
        ));

        if ('on' === $this->props['use_image_as_icon']) {
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'image_as_icon_width',
                'type'              => 'width',
                'selector'          => '%%order_class%% .difl-divider-icon img'
                )
            );
        }
        if ('lottie' === $this->props['separetor_type']) {
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'lottie_image_width',
                'type'              => 'width',
                'selector'          => '%%order_class%% .difl-divider-lottie-image.difl-divider-icon'
                )
            );
        }

        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.difl-divider-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon'
                    ),
                )
            );

        }
       // Line placement
        if($this->props['separetor_type'] !=='no'){
             $this->df_process_string_attr(array(
                'render_slug'           => $render_slug,
                'slug'                  => 'line_placement',
                'type'                  => 'align-items',
                'selector'              => "%%order_class%% .difl-divider-content-wrapper",
                'default'               => 'center'
            ));
        }

        $divider_type = isset($this->props['divider_type']) ?  $this->props['divider_type'] : 'solid';
        if(! ( $divider_type === 'custom' || $divider_type === 'gradient' ) ){
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'divider_line_color',
                'type'              => $divider_type === 'curvedtop' ? 'border-bottom-color' : 'border-top-color',
                'selector'          =>'%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-left-side hr,
                                        %%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-right-side hr',
                'hover'             => '%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-left-side:hover hr,
                                        %%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-right-side:hover hr'
            ));
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'divider_right_line_color',
                'type'              => $divider_type === 'curvedtop' ? 'border-bottom-color' : 'border-top-color',
                'selector'          =>'%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-right-side hr',
                'hover'             =>'%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-right-side:hover hr'
            ));

        }

        $border_type_value = $this->get_border_size_by_divider_type( $divider_type );
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_line_width',
            'type'              => $border_type_value,
            'default_unit'      => 'px',
            'selector'          =>'%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-left-side hr,
                                    %%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-right-side hr',
            'hover'             => '%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-left-side hr:hover,
                                    %%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-right-side hr:hover',
            'important'         => 'true'
        ));
        //if(( $this->props['separetor_type'] !=='no')){
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'divider_left_line_width',
                'type'              => 'width',
                'default_unit'      => '%',
                'selector'          =>'%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-left-side',
                'hover'             => '%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-left-side:hover',
                'important'         => 'true'
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'divider_right_line_width',
                'type'              => 'width',
                'default_unit'      => '%',
                'selector'          =>'%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-right-side',
                'hover'             => '%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-righ-side:hover',
                'important'         => 'true'
            ));
       //}

        //if($this->props['separetor_type'] !== 'no'){
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'divider_line_spacing',
                'type'              => 'padding-right',
                'default_unit'      => '%',
                'selector'          =>'%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-left-side',
                'hover'             => '%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-left-side:hover',
                'important'         => 'true'
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'divider_line_spacing',
                'type'              => 'padding-left',
                'default_unit'      => '%',
                'selector'          =>'%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-right-side',
                'hover'             => '%%order_class%% .difl-divider-wrapper-separator .difl-divider-wrapper-separator-divider .difl-divider-right-side:hover',
                'important'         => 'true'
            ));
        //}

        if($this->props['use_multiple_line'] !== 'no'){

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'multiple_line_gap',
                'type'              => 'margin-bottom',
                'default_unit'      => 'px',
                'selector'          =>'%%order_class%% .difl-divider-wrapper-separator .difl-divider-left hr:not(:last-child),
                                       %%order_class%% .difl-divider-wrapper-separator .difl-divider-right hr:not(:last-child)',
                'important'         => 'true'
            ));
        }


        if( $divider_type === 'gradient' || $divider_type === 'custom'){
            $this->df_process_bg(array (
                'render_slug'       => $render_slug,
                'slug'              => 'divider_line_bg',
                'selector'          => "%%order_class%% .difl-divider-$divider_type .difl-divider-left-side hr,
                                        %%order_class%% .difl-divider-$divider_type .difl-divider-right-side hr",
                'hover'             => "%%order_class%% .difl-divider-$divider_type .difl-divider-left-side hr:hover,
                                        %%order_class%% .difl-divider-$divider_type .difl-divider-right-side hr:hover",
                'important'         => true
            ));
            $this->df_process_bg(array (
                'render_slug'       => $render_slug,
                'slug'              => 'divider_right_line_bg',
                'selector'          => "%%order_class%% .difl-divider-$divider_type .difl-divider-right-side hr",
                'hover'             => "%%order_class%% .difl-divider-$divider_type .difl-divider-right-side hr:hover",
                'important'         => true
            ));
        }


        $this->df_process_bg(array (
                'render_slug'       => $render_slug,
                'slug'              => 'icon_background',
                'selector'          => "%%order_class%% .difl-divider-icon",
                'hover'             => "%%order_class%% .difl-divider-icon:hover",
                'important'         => true
        ));

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_width',
            'type'              => 'width',
            'selector'          => '%%order_class%% .difl-divider-inner'
        ));


    }
    public function get_border_size_by_divider_type( $divider_type ){
         $value = '';
        if($divider_type === 'gradient' || $divider_type === 'custom'){
            $value = 'height';
        }else if($divider_type === 'curvedtop'){
            $value = 'border-bottom-width';
        }else{
            $value = 'border-top-width';
        }
        return $value;
    }
    public function df_render_image_icon()
    {
        if (isset($this->props['separetor_type']) && $this->props['separetor_type'] === 'icon' && $this->props['use_image_as_icon'] ==='off') {

            return sprintf(
                '<span class="et-pb-icon difl-divider-icon">%1$s</span>',
                isset($this->props['font_icon']) && $this->props['font_icon'] !== '' ?
                    esc_attr(et_pb_process_font_icon($this->props['font_icon'])) : '1'
            );
        } else if (isset($this->props['use_image_as_icon']) && $this->props['use_image_as_icon'] === 'on') {

            $src = 'src';
            $image_alt = $this->props['image_alt_text'] !== '' ? $this->props['image_alt_text']  : df_image_alt_by_url($this->props['image_as_icon']);
            $image_url = $this->props['image_as_icon'];

            return sprintf(
                '<div class="difl-divider-icon"><img class="separator-image-icon" %3$s="%1$s" alt="%2$s" /></div>',
                $this->props['image_as_icon'],
                $image_alt,
                $src
            );
        }
    }

	public function render( $attrs, $content, $render_slug ) {
		$this->handle_fa_icon();
        $divider_type = isset($this->props['divider_type']) ?  $this->props['divider_type'] : 'solid';
        $icon_html = $this->df_render_image_icon();
        $title_level  =  esc_attr($this->props['title_tag']);

        $title_html = $this->props['separetor_type'] === 'text' && $this->props['title'] !== '' ?
            sprintf('<div class="difl-divider-icon"><%1$s  class="difl-divider-icon-text">%2$s</%1$s> </div>', $title_level, $this->props['title'])
            :
            sprintf('<div class="difl-divider-icon"><%1$s  class="difl-divider-icon-text">Title</%1$s> </div>', $title_level);

        $path = '';
        $props = $this->props;
        $separetor_type = isset($this->props['separetor_type']) ? $this->props['separetor_type'] : 'icon';
        if( $separetor_type === 'lottie'){

            wp_enqueue_script('df-lottie-lib');
            wp_enqueue_script('df_divider');

            if( $props['lottie_file_options'] !== 'media') {
                $path = $props['external_file'];
            } else if( !empty( $props['upload'] ) ) {
                $path = $props['upload'];
            }
        }

        $content_html = '';
        if( $separetor_type === 'text'){
            $content_html = $title_html;
        }else if( $separetor_type === 'icon'){
            $content_html = $icon_html;
        }else if( $separetor_type === 'lottie'){
            $content_html = sprintf('<div class="difl-divider-lottie-image difl-divider-icon"></div>');
        }else{
            $content_html = '';
        }
        $content_html = !empty($content_html)? sprintf('<div class="difl-divider-icon-container">
                                                <div class="difl-divider-icon-wrap">
                                                    %1$s
                                                </div>
                                            </div>' , $content_html ) : '' ;
        $icon_image_alignment =  isset($this->props['icon_image_alignment']) && $this->props['icon_image_alignment'] !== '' ? $this->props['icon_image_alignment'] : 'center';

        $hr_content ='';
        if($this->props['use_multiple_line'] === 'off'){
            $hr_content ='<hr>';
        }else{
            $line_number =  isset($this->props['line_number']) ? $this->props['line_number']: 1 ;

            for($i=1;$i<=$line_number;$i++){
                $hr_content .= '<hr>';
            }
        }
        $data = [];
        if($separetor_type === 'lottie'){
            $data = array (
                'divider_type'      => $divider_type,
                'separetor_type'    => $separetor_type,
                'path'              => $path,
                'loop'              => $props['loop'] === 'on' ? true : false,
                'speed'             => $props['speed'],
                'direction_reverse' => $props['direction_reverse'],
                'renderer'          => $props['renderer'],
                'animation_trigger' => $props['animation_trigger'],
                'threshold'         => $props['threshold'],
                'stop_on_mouse_out' => $props['stop_on_mouse_out']
            );
        }

        $this->additional_css_styles($render_slug);
        return sprintf( '<div class="difl-divider-container difl-divider-%1$s" data-settings=\'%3$s\'>
                            <div class="difl-divider-wrapper">
                                <div class="difl-divider-wrapper-separator">
                                    <div class="difl-divider-wrapper-separator-divider">
                                        <div class="difl-divider-inner">

                                            <div class="difl-divider-content-wrapper icon-type-%5$s">
                                                %6$s
                                                <div class="difl-divider-left difl-divider-left-side">
                                                    %4$s
                                                </div>

                                                %2$s

                                                <div class="difl-divider-right difl-divider-right-side">
                                                    %4$s
                                                </div>
                                                %7$s
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>' ,
                        $divider_type,
                        $icon_image_alignment === 'center' ? $content_html : '',
                        wp_json_encode($data),
                        $hr_content,
                        $separetor_type,
                        $icon_image_alignment === 'left' ? $content_html : '',
                        $icon_image_alignment === 'right' ? $content_html : ''
         );
	}
}

new DIFL_Divider;