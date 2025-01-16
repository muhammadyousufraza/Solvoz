<?php
class DIFL_TIMELINE extends ET_Builder_Module
{
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_timeline';
    public $child_slug = 'difl_timelineitem';
    public $vb_support = 'on';
    use DF_UTLS;

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'DiviFlash',
        'author_uri' => '',
    );

    public function init()
    {
        $this->name = esc_html__('Timeline', 'divi_flash');
        $this->main_css_element = "%%order_class%%";
        $this->icon_path = DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/timeline.svg';
    }

    public function add_new_child_text()
    {
        return esc_html__('Add New Item', 'divi_flash');
    }

    public function get_settings_modal_toggles()
    {
        $content_sub_toggles = [
            'p'     => array(
                'name' => 'P',
                'icon' => 'text-left',
            ),
            'a'     => array(
                'name' => 'A',
                'icon' => 'text-link',
            ),
            'ul'    => array(
                'name' => 'UL',
                'icon' => 'list',
            ),
            'ol'    => array(
                'name' => 'OL',
                'icon' => 'numbered-list',
            ),
            'quote' => array(
                'name' => 'QUOTE',
                'icon' => 'text-quote',
            ),
        ];

        return [
            'general'   => array(
                'toggles'       => array(
                    'general_setting'  => [
                        'title'        => esc_html__('General Settings', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'  => [
                            'all'  => [
                                'name' => esc_html__('General', 'divi_flash')
                            ],
                            'small'   => [
                                'name' => esc_html__('Small Device', 'divi_flash')
                            ]
                        ]
                    ],
                    'line_setting'  => esc_html__('Line Settings', 'divi_flash'),
                    'arrow_setting' => [
                        'title'     => esc_html__('Arrow Settings', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'  => [
                            'content'  => [
                                'name' => esc_html__('Blurb', 'divi_flash')
                            ],
                            'date'     => [
                                'name' => esc_html__('Date', 'divi_flash')
                            ]
                        ]
                    ],
                    'animation'  => esc_html__('Animation', 'divi_flash'),
                    'item_order' => esc_html__('Blurb Items Order', 'divi_flash'),
                ),
            ),
            'advanced'      => array(
                'toggles'   => array(
                    'design_item_style' => esc_html__('Blurb Style', 'divi_flash'),
                    'design_title'      => esc_html__('Title', 'divi_flash'),
                    'design_subtitle'   => esc_html__('Subtitle', 'divi_flash'),
                    'design_media'      => esc_html__('Media', 'divi_flash'),
                    'design_content'    => esc_html__('Content Style', 'divi_flash'),
                    'design_content_text'   => array(
                        'title'             => esc_html__('Content Text', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => $content_sub_toggles,
                    ),
                    'design_button' => esc_html__('Button', 'divi_flash'),
                    'design_date_wrapper' => esc_html__('Date Style', 'divi_flash'),
                    'design_date_text' => [
                        'title'     => esc_html__('Date Text', 'divi_flash'),
                        'tabbed_subtoggles'  => true,
                        'sub_toggles'  => [
                            'title'    => [
                                'name' => esc_html__('Title', 'divi_flash')
                            ],
                            'subtitle' => [
                                'name' => esc_html__('Subtitle', 'divi_flash')
                            ]
                        ]
                    ],
                    'design_line_top_marker' => esc_html__('Line Top Marker', 'divi_flash'),
                    'design_line_bottom_marker' => esc_html__('Line Bottom Marker', 'divi_flash'),
                    'design_marker' => esc_html__('Marker', 'divi_flash')
                )
            ),
        ];
    }

    public function get_fields()
    {
        $layout_type = [
            'layout_type' => array(
                'label'      => esc_html__('Layout', 'divi_flash'),
                'description' => esc_html__('Select a layout type for desktop.', 'divi_flash'),
                'type'       => 'select',
                'default'    => 'middle',
                'options'    => array(
                    'middle' => esc_html__('Layout 1', 'divi_flash'),
                    'left'   => esc_html__('Layout 2', 'divi_flash'),
                    'right'  => esc_html__('Layout 3', 'divi_flash'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'general_setting',
                'sub_toggle'     => 'all'
            ),
            'layout_type_mobile' => array(
                'label'       => esc_html__('Layout', 'divi_flash'),
                'description' => esc_html__('Select a layout type for mobile.', 'divi_flash'),
                'type'        => 'select',
                'default'     => 'left',
                'options'     => array(
                    'middle' => esc_html__('Line Middle', 'divi_flash'),
                    'left'   => esc_html__('Line Left', 'divi_flash'),
                    'right'  => esc_html__('Line Right', 'divi_flash'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'general_setting',
                'sub_toggle'      => 'small',
            ),

            'module_area_width'   => array(
                'label'         => esc_html__('Module Width', 'divi_flash'),
                'description' => esc_html__('Control the module area width.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '80%',
                'allowed_units' => array('%', 'px'),
                'default_unit'  => '%',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'toggle_slug'   => 'general_setting',
                'sub_toggle'    => 'all',
                'show_if'           => array(
                    'layout_type' => 'middle',
                )
            ),
            'blurb_area_width'   => array(
                'label'         => esc_html__('Blurb Width', 'divi_flash'),
                'description' => esc_html__('Control the blurb area width.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '50%',
                'default_phone' => '100%',
                'allowed_units' => array('%', 'px'),
                'default_unit'  => '%',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'max'  => '50',
                    'step' => '1'
                ),
                'toggle_slug'   => 'general_setting',
                'sub_toggle'    => 'all',
                'show_if_not'           => array(
                    'layout_type' => 'middle',
                )
            ),
            'date_area_width'   => array(
                'label'         => esc_html__('Date Width', 'divi_flash'),
                'description' => esc_html__('Control the date area width.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '40%',
                'default_tablet' => '40%',
                'default_phone' => '100%',
                'allowed_units' => array('%', 'px'),
                'default_unit'  => '%',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'max'  => '50',
                    'step' => '1'
                ),
                'toggle_slug'   => 'general_setting',
                'sub_toggle'    => 'all',
                'mobile_options' => true,
                'responsive'     => true,
                'show_if'           => array(
                    'disable_date' => 'off',
                )
            ),
            'disable_date'      => array(
                'label'          => esc_html__('Disable Date', 'divi_flash'),
                'description'    => esc_html__('Activate this option to disable date area.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'on'  => esc_html__('On', 'divi_flash'),
                    'off' => esc_html__('Off', 'divi_flash')
                ),
                'toggle_slug'    => 'general_setting',
                'sub_toggle'     => 'all'
            ),
            'item_horizontal_alignment' => array(
                'label'      => esc_html__('Horizontal Alignment', 'divi_flash'),
                'description' => esc_html__('Control horizontal alignment for desktop. If blurb and date take full space this align will not work.', 'divi_flash'),
                'default'    => 'center',
                'type'       => 'text_align',
                'options'    => et_builder_get_text_orientation_options(array('justified')),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'general_setting',
                'sub_toggle'     => 'all'
            ),
            'item_horizontal_gap'   => array(
                'label'         => esc_html__('Horizontal Gap', 'divi_flash'),
                'description' => esc_html__('You can control the horizontal gap for timeline items on desktop and tablet devices.', 'divi_flash'),
                'type'          => 'range',
                'default' => '50px',
                'allowed_units' => array('px', '%'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'step' => '1'
                ),
                'toggle_slug'   => 'general_setting',
                'sub_toggle'     => 'all',
                'mobile_options' => true,
                'responsive'     => true
            ),
            'item_vertical_alignment' => array(
                'label'      => esc_html__('Vertical Alignment', 'divi_flash'),
                'description' => esc_html__('Control vertical alignment for desktop.', 'divi_flash'),
                'type'       => 'select',
                'default'    => 'center',
                'options'    => array(
                    'start'    => esc_html__('Top', 'divi_flash'),
                    'center' => esc_html__('Middle', 'divi_flash'),
                    'end' => esc_html__('Bottom', 'divi_flash'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'general_setting',
                'sub_toggle'     => 'all'
            ),
            'item_vertical_gap'   => array(
                'label'         => esc_html__('Vertical Gap', 'divi_flash'),
                'description' => esc_html__('Control timeline item vertical gap.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '50px',
                'allowed_units' => array('px', '%'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'step' => '1'
                ),
                'toggle_slug'   => 'general_setting',
                'sub_toggle'     => 'all',
                'mobile_options' => true,
                'responsive'     => true
            ),
            'enable_date_in_blurb' => array(
                'label'          => esc_html__('Date In Blurb', 'divi_flash'),
                'description'    => esc_html__('Activate this option to set date area in blurb', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'on'  => esc_html__('On', 'divi_flash'),
                    'off' => esc_html__('Off', 'divi_flash')
                ),
                'toggle_slug'    => 'general_setting',
                'sub_toggle'     => 'small',
                'show_if_not'           => array(
                    'disable_date_mobile' => 'on',
                    'disable_date' => 'on',
                )
            ),
            'date_horizontal_alignment' => array(
                'label'      => esc_html__('Date Alignment', 'divi_flash'),
                'description' => esc_html__('Control date horizontal alignment for mobile. If date take full space this align will not work.', 'divi_flash'),
                'default'    => 'left',
                'type'       => 'text_align',
                'options'    => et_builder_get_text_orientation_options(array('justified')),
                'option_category' => 'basic_option',
                'toggle_slug'    => 'general_setting',
                'sub_toggle'     => 'small',
                'show_if'        => array(
                    'enable_date_in_blurb' => 'on'
                ),
                'show_if_not'           => array(
                    'disable_date_mobile' => 'on',
                    'disable_date' => 'on',
                )
            ),
            'disable_date_mobile'      => array(
                'label'          => esc_html__('Disable Date', 'divi_flash'),
                'description'    => esc_html__('Activate this option to disable date area on mobile.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'on'  => esc_html__('On', 'divi_flash'),
                    'off' => esc_html__('Off', 'divi_flash')
                ),
                'toggle_slug'    => 'general_setting',
                'sub_toggle'     => 'small',
                'show_if_not'    => array(
                    'disable_date' => 'on'
                )
                
            ),
            'arrow_marker_vertical_align' => array(
                'label'      => esc_html__('Marker & Arrow Position', 'divi_flash'),
                'description' => esc_html__('Control arrow & marker vertical alignment or position for mobile.', 'divi_flash'),
                'type'       => 'select',
                'default'    => 'middle',
                'options'    => array(
                    'top'    => esc_html__('Top', 'divi_flash'),
                    'middle' => esc_html__('Middle', 'divi_flash'),
                    'bottom' => esc_html__('Bottom', 'divi_flash'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'general_setting',
                'sub_toggle'     => 'small',
                'show_if_not'           => array(
                    'layout_type_mobile' => 'middle'
                )
            ),
            'marker_postion_mobile' => array(
                'label'          => esc_html__('Marker From Blurb', 'divi_flash'),
                'description'    => esc_html__('Here you can set the marker postion on mobile. If there no arrow or container available marker will start from top.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'on'  => esc_html__('On', 'divi_flash'),
                    'off' => esc_html__('Off', 'divi_flash')
                ),
                'toggle_slug'    => 'general_setting',
                'sub_toggle'     => 'small',
                'show_if_not'           => array(
                    'layout_type_mobile' => 'middle',
                    'disable_date_mobile' => 'on',
                    'enable_date_in_blurb' => 'on',
                    'disable_date' => 'on',
                )
            ),
        ];

        $line_settings = [
            'line_color' => array(
                'label'         => esc_html__('Color', 'divi_flash'),
                'description'   => esc_html__('Here you can define a custom color for line.', 'divi_flash'),
                'type'          => 'color-alpha',
                'default'       => '#ccc',
                'toggle_slug'   => 'line_setting',
                'hover'         => 'tabs',
            ),
            'line_width'   => array(
                'label'         => esc_html__('Width', 'divi_flash'),
                'description' => esc_html__('Here you can define a custom width for line.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '3px',
                'allowed_units' => array('px', '%'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'step' => '1'
                ),
                'toggle_slug'   => 'line_setting',
                'mobile_options' => true,
                'responsive'    => true
            ),
            'line_start_from' => array(
                'label'       => esc_html__('Height Start From', 'divi_flash'),
                'description' => esc_html__('Here you can set custom line position.', 'divi_flash'),
                'type'        => 'select',
                'default'     => 'first_marker',
                'options'     => array(
                    'first_marker' => esc_html__('Content Marker', 'divi_flash'),
                    'custom'  => esc_html__('Content Top To Bottom', 'divi_flash')
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'line_setting',
            ),
            'enable_line_top_marker'      => array(
                'label'          => esc_html__('Top Marker', 'divi_flash'),
                'description'    => esc_html__('Activate this option to enable line\'s top marker.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'toggle_slug'    => 'line_setting',
                'show_if'           => array(
                    'line_start_from' => 'custom'
                )
            ),
            'line_top_marker_type' => array(
                'label'       => esc_html__('Type', 'divi_flash'),
                'description'    => esc_html__('Here you can set marker type.', 'divi_flash'),
                'type'        => 'select',
                'default'     => 'icon',
                'options'     => array(
                    'image'   => esc_html__('Image', 'divi_flash'),
                    'icon'    => esc_html__('Icon', 'divi_flash'),
                    'text'    => esc_html__('Text', 'divi_flash')
                ),
                'option_category' => 'basic_option',
                'toggle_slug'    => 'line_setting',
                'show_if'        => array(
                    'enable_line_top_marker' => 'on',
                    'line_start_from' => 'custom'
                )
            ),
            'line_top_icon'         => array(
                'label'             => esc_html__('Icon', 'divi_flash'),
                'description'    => esc_html__('Choose an icon for the marker.', 'divi_flash'),
                'type'              => 'select_icon',
                'default'           => '&#xe00a;||divi||400',
                'option_category'   => 'basic_option',
                'class'             => array('et-pb-font-icon'),
                'toggle_slug'       => 'line_setting',
                'show_if'           => array(
                    'line_start_from' => 'custom',
                    'enable_line_top_marker' => 'on',
                    'line_top_marker_type' => 'icon'
                )
            ),
            'line_top_icon_color' => array(
                'label'         => esc_html__('Icon Color', 'divi_flash'),
                'description'   => esc_html__('Here you can define a custom color for your icon.', 'divi_flash'),
                'type'          => 'color-alpha',
                'default'       => '#333',
                'toggle_slug'   => 'design_line_top_marker',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs',
                'show_if'       => array(
                    'line_start_from' => 'custom',
                    'enable_line_top_marker' => 'on',
                    'line_top_marker_type'   => 'icon'
                )
            ),
            'line_top_icon_size' => array(
                'label'           => esc_html__('Icon Size', 'divi_flash'),
                'description'   => esc_html__('Here you can define a custom size for your icon.', 'divi_flash'),
                'type'            => 'range',
                'toggle_slug'     => 'design_line_top_marker',
                'tab_slug'        => 'advanced',
                'default'         => '24px',
                'allowed_units'   => array('px'),
                'range_settings'  => array(
                    'min'  => '1',
                    'min_limit'   => '1',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'      => true,
                'mobile_options'  => true,
                'show_if'         => array(
                    'line_start_from' => 'custom',
                    'enable_line_top_marker' => 'on',
                    'line_top_marker_type'   => 'icon'
                )
            ),

            'line_top_image' => array(
                'label'              => esc_html__('Image', 'divi_flash'),
                'description'   => esc_html__('Choose an image for marker.', 'divi_flash'),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'        => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'        => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'        => 'line_setting',
                'show_if' => array(
                    'line_start_from' => 'custom',
                    'enable_line_top_marker' => 'on',
                    'line_top_marker_type' => 'image'
                ),
                'depends_on'      => array(
                    'line_top_marker_type' => 'image'
                )
            ),
            'line_top_img_alt_txt' => array(
                'label'            => esc_html__('Image Alt Text', 'divi_flash'),
                'description'   => esc_html__('Set an alternative text for the image.', 'divi_flash'),
                'type'             => 'text',
                'toggle_slug'      => 'line_setting',
                'show_if'          => array(
                    'line_start_from' => 'custom',
                    'enable_line_top_marker' => 'on',
                    'line_top_marker_type' => 'image'
                )
            ),
            'line_top_img_width' => array(
                'label'             => esc_html__('Image Width', 'divi_flash'),
                'description'   => esc_html__('Control the image width.', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'line_setting',
                'default'           => '30px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'show_if'         => array(
                    'line_start_from' => 'custom',
                    'enable_line_top_marker' => 'on',
                    'line_top_marker_type' => 'image'
                )
            ),
            'line_top_txt' => array(
                'label'           => esc_html__('Text', 'divi_flash'),
                'description'   => esc_html__('Set the a text in marker.', 'divi_flash'),
                'type'            => 'text',
                'toggle_slug'     => 'line_setting',
                'show_if'         => array(
                    'line_start_from' => 'custom',
                    'enable_line_top_marker' => 'on',
                    'line_top_marker_type' => 'text'
                )
            ),
            'line_top_marker_vertical_position' => array(
                'label'         => esc_html__('Top Marker Height', 'divi_flash'),
                'description'   => esc_html__('Control the top marker height.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '0px',
                'allowed_units' => array('px'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'step' => '1'
                ),
                'toggle_slug'   => 'line_setting',
                'mobile_options' => true,
                'responsive'     => true,
                'show_if'       => array(
                    'line_start_from' => 'custom',
                    'enable_line_top_marker' => 'on'
                ),
            ),
            'enable_line_bottom_marker'      => array(
                'label'          => esc_html__('Bottom Marker', 'divi_flash'),
                'description'    => esc_html__('Activate this option to enable scroll line bottom media.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'toggle_slug'    => 'line_setting',
                'show_if'           => array(
                    'line_start_from' => 'custom'
                )
            ),
            'line_bottom_marker_type' => array(
                'label'       => esc_html__('Type', 'divi_flash'),
                'type'        => 'select',
                'default'     => 'icon',
                'options'     => array(
                    'image'   => esc_html__('Image', 'divi_flash'),
                    'icon'    => esc_html__('Icon', 'divi_flash'),
                    'text'    => esc_html__('Text', 'divi_flash')
                ),
                'option_category' => 'basic_option',
                'toggle_slug'    => 'line_setting',
                'show_if'        => array(
                    'line_start_from' => 'custom',
                    'enable_line_bottom_marker' => 'on'
                )
            ),
            'line_bottom_icon'      => array(
                'label'             => esc_html__('Icon', 'divi_flash'),
                'type'              => 'select_icon',
                'default'           => '&#xe00a;||divi||400',
                'option_category'   => 'basic_option',
                'class'             => array('et-pb-font-icon'),
                'toggle_slug'       => 'line_setting',
                'show_if'           => array(
                    'line_start_from' => 'custom',
                    'enable_line_bottom_marker' => 'on',
                    'line_bottom_marker_type' => 'icon'
                ),
                'depends_on'      => array(
                    'line_bottom_marker_type' => 'icon'
                )
            ),
            'line_bottom_icon_color' => array(
                'label'         => esc_html__('Icon Color', 'divi_flash'),
                'type'          => 'color-alpha',
                'default'       => '#333',
                'description'   => esc_html__('Here you can define a custom color for your icon.', 'divi_flash'),
                'toggle_slug'   => 'design_line_bottom_marker',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs',
                'show_if'       => array(
                    'line_start_from' => 'custom',
                    'enable_line_bottom_marker' => 'on',
                    'line_bottom_marker_type'   => 'icon'
                )
            ),
            'line_bottom_icon_size' => array(
                'label'           => esc_html__('Icon Size', 'divi_flash'),
                'type'            => 'range',
                'toggle_slug'     => 'design_line_bottom_marker',
                'tab_slug'        => 'advanced',
                'default'         => '24px',
                'allowed_units'   => array('px'),
                'range_settings'  => array(
                    'min'  => '1',
                    'min_limit'   => '1',
                    'max'  => '100',
                    'step' => '1'
                ),
                'show_if'         => array(
                    'line_start_from' => 'custom',
                    'enable_line_bottom_marker' => 'on',
                    'line_bottom_marker_type'   => 'icon'
                )
            ),
            'line_bottom_image' => array(
                'label'              => esc_html__('Image', 'divi_flash'),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'        => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'        => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'        => 'line_setting',
                'show_if' => array(
                    'line_start_from' => 'custom',
                    'enable_line_bottom_marker' => 'on',
                    'line_bottom_marker_type' => 'image'
                )
            ),
            'line_bottom_img_alt_txt' => array(
                'label'           => esc_html__('Image Alt Text', 'divi_flash'),
                'type'            => 'text',
                'toggle_slug'     => 'line_setting',
                'show_if'         => array(
                    'line_start_from' => 'custom',
                    'enable_line_bottom_marker' => 'on',
                    'line_bottom_marker_type' => 'image'
                )
            ),
            'line_bottom_img_width' => array(
                'label'          => esc_html__('Image Width', 'divi_flash'),
                'type'           => 'range',
                'toggle_slug'    => 'line_setting',
                'default'        => '30px',
                'default_unit'   => 'px',
                'allowed_units'  => array('px'),
                'range_settings' => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'show_if'         => array(
                    'line_start_from' => 'custom',
                    'enable_line_bottom_marker' => 'on',
                    'line_bottom_marker_type' => 'image'
                )
            ),
            'line_bottom_txt' => array(
                'label'       => esc_html__('Text', 'divi_flash'),
                'type'        => 'text',
                'toggle_slug' => 'line_setting',
                'show_if'     => array(
                    'line_start_from' => 'custom',
                    'enable_line_bottom_marker' => 'on',
                    'line_bottom_marker_type' => 'text'
                )
            ),
            'line_bottom_marker_vertical_position' => array(
                'label'         => esc_html__('Bottom Marker Height', 'divi_flash'),
                'description'   => esc_html__('Control the bottom marker height.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '0px',
                'allowed_units' => array('px'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'step' => '1'
                ),
                'toggle_slug'   => 'line_setting',
                'mobile_options' => true,
                'responsive'     => true,
                'show_if'       => array(
                    'line_start_from' => 'custom',
                    'enable_line_bottom_marker' => 'on'
                )
            ),
        ];

        $arrow_settings = [
            'enable_arrow'      => array(
                'label'          => esc_html__('Arrow', 'divi_flash'),
                'description'    => esc_html__('Activate this option to enable blurb arrow.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'on',
                'options'        => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'toggle_slug'    => 'arrow_setting',
                'sub_toggle'   => 'content',
            ),
            'arrow_type' => array(
                'label'     => esc_html__('Type', 'divi_flash'),
                'description'    => esc_html__('Chose blurb arrow type.', 'divi_flash'),
                'type'      => 'select',
                'default'   => 'arrow_caret',
                'options'   => array(
                    'arrow_caret' => esc_html__('Caret', 'divi_flash'),
                    'arrow_icon' => esc_html__('Icon', 'divi_flash'),
                    'arrow_line' => esc_html__('Line', 'divi_flash')
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'arrow_setting',
                'sub_toggle'   => 'content',
                'show_if'         => array(
                    'enable_arrow' => 'on'
                )
            ),
            'arrow_icon' => array(
                'label'     => esc_html__('Icon', 'divi_flash'),
                'description'    => esc_html__('Select blurb arrow icon.', 'divi_flash'),
                'type'      => 'select',
                'default'   => '&#x24;||divi||400',
                'options'   => array(
                    '&#x24;'  => esc_html__('Arrow', 'divi_flash'),
                    '&#xe03c;'  => esc_html__('Arrow 2', 'divi_flash'),
                    '&#x3d;'  => esc_html__('Caret', 'divi_flash'),
                    '&#x49;'  => esc_html__('Caret 2', 'divi_flash'),
                    '&#xe046;'  => esc_html__('Caret 3', 'divi_flash'),
                    '&#x35;'  => esc_html__('Caret 4', 'divi_flash'),
                    '&#x39;'  => esc_html__('Double Caret', 'divi_flash'),
                    '&#x41;'  => esc_html__('Double Caret 2', 'divi_flash'),
                    '&#xe04a;' => esc_html__('Double Caret 3', 'divi_flash')
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'arrow_setting',
                'sub_toggle'   => 'content',
                'show_if'         => array(
                    'enable_arrow' => 'on',
                    'arrow_type'   => 'arrow_icon'
                )
            ),
            'arrow_line_type' => array(
                'label'       => esc_html__('Line Type', 'divi_flash'),
                'description'    => esc_html__('Set blurb arrow line type.', 'divi_flash'),
                'type'        => 'select',
                'default'     => 'solid',
                'options'     => array(
                    'solid' => esc_html__('Solid', 'divi_flash'),
                    'dashed' => esc_html__('Dashed', 'divi_flash'),
                    'dotted' => esc_html__('Dotted', 'divi_flash'),
                    'double' => esc_html__('Double', 'divi_flash'),
                    'groove' => esc_html__('Groove', 'divi_flash'),
                    'ridge' => esc_html__('Ridge', 'divi_flash'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'arrow_setting',
                'sub_toggle'   => 'content',
                'mobile_options'  => true,
                'responsive'      => true,
                'show_if'        => array(
                    'enable_arrow' => 'on',
                    'arrow_type' => 'arrow_line'
                )
            ),
            'arrow_thick' => array(
                'label'         => esc_html__('Thickness', 'divi_flash'),
                'description'    => esc_html__('Control blurb arrow line thickness.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '2px',
                'allowed_units' => array('px', '%'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'step' => '1'
                ),
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'   => 'content',
                'mobile_options' => true,
                'responsive'    => true,
                'show_if'        => array(
                    'enable_arrow' => 'on',
                    'arrow_type' => 'arrow_line'
                )
            ),
            'arrow_size' => array(
                'label'         => esc_html__('Size', 'divi_flash'),
                'description'    => esc_html__('Control blurb arrow size.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '20px',
                'allowed_units' => array('px', '%'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'step' => '1'
                ),
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'   => 'content',
                'mobile_options' => true,
                'responsive'    => true,
                'show_if'        => array(
                    'enable_arrow' => 'on'
                )
            ),
            'arrow_color' => array(
                'label'         => esc_html__('Color', 'divi_flash'),
                'description'   => esc_html__('Here you can define a custom color for arrow.', 'divi_flash'),
                'type'          => 'color-alpha',
                'default'       => '#ddd',
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'    => 'content',
                'hover'         => 'tabs',
                'show_if'        => array(
                    'enable_arrow' => 'on'
                )
            ),
            'arrow_vertical_alignment' => array(
                'label'       => esc_html__('Vertical Alignment', 'divi_flash'),
                'description'    => esc_html__('Select blurb arrow vertical alignment.', 'divi_flash'),
                'type'        => 'select',
                'default'     => 'middle',
                'options'     => array(
                    'top'     => esc_html__('Top', 'divi_flash'),
                    'middle'  => esc_html__('Middle', 'divi_flash'),
                    'bottom'  => esc_html__('Bottom', 'divi_flash'),
                    'custom'  => esc_html__('Custom', 'divi_flash')
                ),
                'option_category' => 'basic_option',
                'toggle_slug'    => 'arrow_setting',
                'sub_toggle'     => 'content',
                'show_if'        => array(
                    'enable_arrow' => 'on'
                )
            ),
            'arrow_vertical_position' => array(
                'label'         => esc_html__('Vertical Position', 'divi_flash'),
                'description'    => esc_html__('Control blurb arrow vertical position for desktop & tablet.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '50%',
                'allowed_units' => array('%', 'px'),
                'default_unit'  => '%',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'step' => '1'
                ),
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'    => 'content',
                'show_if'       => array(
                    'enable_arrow' => 'on',
                    'arrow_vertical_alignment' => 'custom'
                )
            ),
            'arrow_horizontal_position' => array(
                'label'         => esc_html__('Horizontal Position', 'divi_flash'),
                'description'    => esc_html__('Control blurb arrow horizontal position.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '0px',
                'allowed_units' => array('px', '%'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'step' => '1'
                ),
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'    => 'content',
                'mobile_options' => true,
                'responsive'    => true,
                'show_if'        => array(
                    'enable_arrow' => 'on'
                )
            ),
            'reverse_arrow' => array(
                'label'          => esc_html__('Reverse', 'divi_flash'),
                'description'    => esc_html__('Activate this option to reverse blurb arrow.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'on'  => esc_html__('On', 'divi_flash'),
                    'off' => esc_html__('Off', 'divi_flash')
                ),
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'    => 'content',
                'show_if'       => array(
                    'enable_arrow' => 'on'
                ),
                'show_if_not'   => array(
                    'arrow_type' => 'arrow_line'
                )
            ),
            'disable_arrow_mobile' => array(
                'label'          => esc_html__('Disable On Mobile', 'divi_flash'),
                'description'    => esc_html__('Activate this option to daisable blurb arrow on mobile.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'on'  => esc_html__('On', 'divi_flash'),
                    'off' => esc_html__('Off', 'divi_flash')
                ),
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'    => 'content',
                'show_if'       => array(
                    'enable_arrow' => 'on'
                )
            ),
        ];

        $date_arrow_settings = [
            'enable_date_arrow'      => array(
                'label'          => esc_html__('Arrow', 'divi_flash'),
                'description'    => esc_html__('Activate this option to enable date arrow.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'on',
                'options'        => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'toggle_slug'    => 'arrow_setting',
                'sub_toggle'     => 'date',
                'show_if'        => array(
                    'disable_date' => 'off'
                )
            ),
            'date_arrow_type' => array(
                'label'       => esc_html__('Type', 'divi_flash'),
                'description'    => esc_html__('Chose date arrow type.', 'divi_flash'),
                'type'        => 'select',
                'default'     => 'arrow_caret',
                'options'     => array(
                    'arrow_caret' => esc_html__('Caret', 'divi_flash'),
                    'arrow_icon' => esc_html__('Icon', 'divi_flash'),
                    'arrow_line' => esc_html__('Line', 'divi_flash')
                ),
                'option_category' => 'basic_option',
                'toggle_slug'    => 'arrow_setting',
                'sub_toggle'     => 'date',
                'show_if'        => array(
                    'disable_date' => 'off',
                    'enable_date_arrow' => 'on'
                )
            ),
            'date_arrow_icon' => array(
                'label'       => esc_html__('Icon', 'divi_flash'),
                'description' => esc_html__('Select date arrow icon.', 'divi_flash'),
                'type'        => 'select',
                'default'     => '&#x24;||divi||400',
                'options'     => array(
                    '&#x24;'  => esc_html__('Arrow', 'divi_flash'),
                    '&#xe03c;'  => esc_html__('Arrow 2', 'divi_flash'),
                    '&#x3d;'  => esc_html__('Caret', 'divi_flash'),
                    '&#x49;'  => esc_html__('Caret 2', 'divi_flash'),
                    '&#xe046;'  => esc_html__('Caret 3', 'divi_flash'),
                    '&#x35;'  => esc_html__('Caret 4', 'divi_flash'),
                    '&#x39;'  => esc_html__('Double Caret', 'divi_flash'),
                    '&#x41;'  => esc_html__('Double Caret 2', 'divi_flash'),
                    '&#xe04a;' => esc_html__('Double Caret 3', 'divi_flash')
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'arrow_setting',
                'sub_toggle'   => 'date',
                'show_if'         => array(
                    'enable_date_arrow' => 'on',
                    'date_arrow_type'   => 'arrow_icon'
                )
            ),
            'date_arrow_line_type' => array(
                'label'       => esc_html__('Line Type', 'divi_flash'),
                'description'    => esc_html__('Set date arrow line type.', 'divi_flash'),
                'type'        => 'select',
                'default'     => 'solid',
                'options'     => array(
                    'solid' => esc_html__('Solid', 'divi_flash'),
                    'dashed' => esc_html__('Dashed', 'divi_flash'),
                    'dotted' => esc_html__('Dotted', 'divi_flash'),
                    'double' => esc_html__('Double', 'divi_flash'),
                    'groove' => esc_html__('Groove', 'divi_flash'),
                    'ridge' => esc_html__('Ridge', 'divi_flash'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'    => 'arrow_setting',
                'sub_toggle'     => 'date',
                'mobile_options' => true,
                'responsive'     => true,
                'show_if'        => array(
                    'disable_date' => 'off',
                    'enable_date_arrow' => 'on',
                    'date_arrow_type' => 'arrow_line'
                )
            ),
            'date_arrow_thick' => array(
                'label'         => esc_html__('Thickness', 'divi_flash'),
                'description'    => esc_html__('Control date arrow line thickness.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '2px',
                'allowed_units' => array('px', '%'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'step' => '1'
                ),
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'    => 'date',
                'mobile_options' => true,
                'responsive'    => true,
                'show_if'        => array(
                    'disable_date' => 'off',
                    'enable_date_arrow' => 'on',
                    'date_arrow_type' => 'arrow_line'
                )
            ),
            'date_arrow_size' => array(
                'label'         => esc_html__('Size', 'divi_flash'),
                'description'    => esc_html__('Control date arrow size.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '10px',
                'allowed_units' => array('px', '%'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'step' => '1'
                ),
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'    => 'date',
                'mobile_options' => true,
                'responsive'    => true,
                'show_if'        => array(
                    'disable_date' => 'off',
                    'enable_date_arrow' => 'on'
                )
            ),
            'date_arrow_color' => array(
                'label'         => esc_html__('Color', 'divi_flash'),
                'description'   => esc_html__('Here you can define a color for date arrow.', 'divi_flash'),
                'type'          => 'color-alpha',
                'default'       => '#ddd',
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'    => 'date',
                'hover'         => 'tabs',
                'show_if'        => array(
                    'disable_date' => 'off',
                    'enable_date_arrow' => 'on'
                )
            ),
            'date_arrow_vertical_align' => array(
                'label'       => esc_html__('Vertical Alignment', 'divi_flash'),
                'description'    => esc_html__('Select date arrow vertical alignment.', 'divi_flash'),
                'type'        => 'select',
                'default'     => 'middle',
                'options'     => array(
                    'top'     => esc_html__('Top', 'divi_flash'),
                    'middle'  => esc_html__('Middle', 'divi_flash'),
                    'bottom'  => esc_html__('Bottom', 'divi_flash'),
                    'custom'  => esc_html__('Custom', 'divi_flash')
                ),
                'option_category' => 'basic_option',
                'toggle_slug'    => 'arrow_setting',
                'sub_toggle'     => 'date',
                'show_if'        => array(
                    'disable_date' => 'off',
                    'enable_date_arrow' => 'on'
                )
            ),
            'date_arrow_vertical_position' => array(
                'label'         => esc_html__('Vertical Position', 'divi_flash'),
                'description'    => esc_html__('Control date arrow vertical position for desktop & tablet.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '50%',
                'allowed_units' => array('%', 'px'),
                'default_unit'  => '%',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'step' => '1'
                ),
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'    => 'date',
                'mobile_options' => true,
                'responsive'    => true,
                'show_if'       => array(
                    'disable_date' => 'off',
                    'enable_arrow' => 'on',
                    'date_arrow_vertical_align' => 'custom'
                )
            ),
            'date_arrow_horizontal_position' => array(
                'label'         => esc_html__('Horizontal Position', 'divi_flash'),
                'description'    => esc_html__('Control date arrow horizontal position.', 'divi_flash'),
                'type'          => 'range',
                'default'       => '0px',
                'allowed_units' => array('px', '%'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'step' => '1'
                ),
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'    => 'date',
                'mobile_options' => true,
                'responsive'    => true,
                'show_if'       => array(
                    'disable_date' => 'off',
                    'enable_date_arrow' => 'on'
                )
            ),
            'reverse_date_arrow' => array(
                'label'          => esc_html__('Reverse', 'divi_flash'),
                'description'    => esc_html__('Activate this option to reverse date arrow.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'on'  => esc_html__('On', 'divi_flash'),
                    'off' => esc_html__('Off', 'divi_flash')
                ),
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'    => 'date',
                'show_if'       => array(
                    'enable_date_arrow' => 'on'
                ),
                'show_if_not'   => array(
                    'disable_date' => 'on',
                    'date_arrow_type' => 'arrow_line'
                )
            ),
            'disable_date_arrow_mobile' => array(
                'label'          => esc_html__('Disable On Mobile', 'divi_flash'),
                'description'    => esc_html__('Activate this option to daisable date arrow on mobile.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'on'  => esc_html__('On', 'divi_flash'),
                    'off' => esc_html__('Off', 'divi_flash')
                ),
                'toggle_slug'   => 'arrow_setting',
                'sub_toggle'    => 'date',
                'show_if'       => array(
                    'disable_date' => 'off',
                    'enable_date_arrow' => 'on'
                )
            ),
        ];

        $button = [
            'button_icon_color' => array(
                'label'         => esc_html__('Icon Color', 'divi_flash'),
                'description'   => esc_html__('Here you can define a color for button icon.', 'divi_flash'),
                'type'          => 'color-alpha',
                'default'       => '#333',
                'toggle_slug'   => 'design_button',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs',
            ),
            'button_icon_size'  => array(
                'label'         => esc_html__('Icon Size', 'divi_flash'),
                'description'   => esc_html__('Here you can set size for button icon.', 'divi_flash'),
                'type'          => 'range',
                'toggle_slug'   => 'design_button',
                'tab_slug'      => 'advanced',
                'default'       => '18px',
                'allowed_units' => array('px'),
                'range_settings' => array(
                    'min'  => '1',
                    'min_limit'  => '1',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'    => true,
                'mobile_options' => true
            ),
        ];

        $marker = [
            'marker_width' => array(
                'label'           => esc_html__('Marker Width', 'divi_flash'),
                'description'    => esc_html__('Set the width of marker.', 'divi_flash'),
                'type'            => 'range',
                'toggle_slug'     => 'design_marker',
                'tab_slug'        => 'advanced',
                'default'         => '50px',
                'allowed_units'   => array('px'),
                'range_settings'  => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'      => true,
                'mobile_options'  => true
            ),
            'marker_height' => array(
                'label'           => esc_html__('Marker Height', 'divi_flash'),
                'description'    => esc_html__('Set the height of marker.', 'divi_flash'),
                'type'            => 'range',
                'toggle_slug'     => 'design_marker',
                'tab_slug'        => 'advanced',
                'default'         => '50px',
                'allowed_units'   => array('px'),
                'range_settings'  => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'      => true,
                'mobile_options'  => true
            ),
            'marker_icon_color' => array(
                'label'         => esc_html__('Icon Color', 'divi_flash'),
                'type'          => 'color-alpha',
                'description'   => esc_html__('Here you can define a color for marker icon.', 'divi_flash'),
                'toggle_slug'   => 'design_marker',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs'
            ),
            'marker_icon_size' => array(
                'label'           => esc_html__('Icon Size', 'divi_flash'),
                'description'   => esc_html__('Here you can set size for marker icon.', 'divi_flash'),
                'type'            => 'range',
                'toggle_slug'     => 'design_marker',
                'tab_slug'        => 'advanced',
                'default'         => '24px',
                'allowed_units'   => array('px'),
                'range_settings'  => array(
                    'min'  => '0',
                    'min_limit'   => '0',
                    'step' => '1'
                ),
                'responsive'      => true,
                'mobile_options'  => true
            ),
        ];

        $animation = [
            'enable_item_animation'      => array(
                'label'          => esc_html__('Item Animation On Scroll', 'divi_flash'),
                'description'    => esc_html__('Activate this option to enable item animation.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'toggle_slug'    => 'animation'
            ),
            'tmln_animation' => array(
                'label'                 => esc_html__('Timeline Animation', 'divi_flash'),
                'description'    => esc_html__('Enable timeline animation.', 'divi_flash'),
                'type'                  => 'select',
                'default'               => 'fade_in',
                'options'               => array(
                    'slide_left'            => esc_html__('Slide Left', 'divi_flash'),
                    'slide_right'           => esc_html__('Slide Right', 'divi_flash'),
                    'slide_up'              => esc_html__('Slide Up', 'divi_flash'),
                    'slide_down'            => esc_html__('Slide Down', 'divi_flash'),
                    'fade_in'               => esc_html__('Fade', 'divi_flash'),
                    'zoom_left'             => esc_html__('Zoom Left', 'divi_flash'),
                    'zoom_center'           => esc_html__('Zoom Center', 'divi_flash'),
                    'zoom_right'             => esc_html__('Zoom Right', 'divi_flash'),
                ),
                'toggle_slug'            => 'animation',
                'show_if'        => array(
                    'enable_item_animation' => 'on'
                )
            ),

            'enable_scroll_line'      => array(
                'label'          => esc_html__('Scroll Line Animation', 'divi_flash'),
                'description'    => esc_html__('Activate this option to enable scroll line effect.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'toggle_slug'    => 'animation'
            ),
            'scroll_line_color'  => array(
                'label'          => esc_html__('Scroll Line Color', 'divi_flash'),
                'type'           => 'color-alpha',
                'description'    => esc_html__('Here you can define a custom color for scroll line.', 'divi_flash'),
                'toggle_slug'    => 'animation',
                'default'        => "#333",
                'show_if'        => array(
                    'enable_scroll_line' => 'on'
                )
            ),

            'enable_marker_animation' => array(
                'label'          => esc_html__('Marker Effect On Scroll', 'divi_flash'),
                'description'    => esc_html__('Activate this option to enable marker scroll effect.', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'toggle_slug'    => 'animation',
            )
        ];

        $active_marker_color = [
            'active_marker_color' => array(
                'label'         => esc_html__('Marker Color', 'divi_flash'),
                'description'   => esc_html__('Here you can define a color for marker scroll effect.', 'divi_flash'),
                'type'          => 'color-alpha',
                'default'       => '#ddd',
                'toggle_slug'   => 'animation',
                'hover'         => 'tabs',
                'show_if'        => array(
                    'enable_marker_animation' => 'on'
                )
            )
        ];

        $item_order = [
            'order_enable'  => array(
                'label'             => esc_html__('Enable Order', 'divi_flash'),
                'description'   => esc_html__('Enabling this option will give you the control to set the each item\'s order.', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'item_order'
            ),
            'date_order' => array(
                'label'             => esc_html__('Date', 'divi_flash'),
                'description'   => esc_html__('Increase or decrease the order number to position the date tile and subtitle.', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'    => 'item_order',
                'default'           => '-1',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'enable_date_in_blurb' => 'on',
                    'order_enable' => 'on'
                ),
                'show_if_not'           => array(
                    'disable_date_mobile' => 'on'
                )
            ),
            'title_order' => array(
                'label'             => esc_html__('Title', 'divi_flash'),
                'description'   => esc_html__('Increase or decrease the order number to position the item.', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'item_order',
                'default'           => '9',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'order_enable'     => 'on'
                ),
            ),
            'sub_title_order' => array(
                'label'             => esc_html__('Subtitle', 'divi_flash'),
                'description'       => esc_html__('Increase or decrease the order number to position the item.', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'item_order',
                'default'           => '9',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'show_if'         => array(
                    'order_enable'     => 'on'
                ),
            ),
            'media_order' => array(
                'label'             => esc_html__('Image/Icon', 'divi_flash'),
                'description'       => esc_html__('Increase or decrease the order number to position the item.', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'item_order',
                'default'           => '9',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'order_enable'     => 'on'
                ),
            ),
            'content_order' => array(
                'label'             => esc_html__('Content', 'divi_flash'),
                'description'       => esc_html__('Increase or decrease the order number to position the item.', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'item_order',
                'default'           => '9',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'order_enable'     => 'on'
                ),
            ),
            'button_order' => array(
                'label'             => esc_html__('Button', 'divi_flash'),
                'description'       => esc_html__('Increase or decrease the order number to position the item.', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'item_order',
                'default'           => '9',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '15',
                    'step' => '1'
                ),
                'validate_unit'     => false,
                'show_if'           => array(
                    'order_enable'     => 'on'
                ),
            )
        ];

        $item_wrapper_bg = $this->df_add_bg_field(
            array(
                'label'        => 'Background',
                'key'          => 'item_wrapper_bg',
                'toggle_slug'  => 'design_item_style',
                'tab_slug'     => 'advanced'
            )
        );

        $line_top_bg = $this->df_add_bg_field(
            array(
                'label'        => 'Background',
                'key'          => 'line_top_bg',
                'toggle_slug'  => 'design_line_top_marker',
                'tab_slug'     => 'advanced',
                'show_if'     => array(
                    'enable_line_top_marker' => 'on'
                )
            )
        );

        $line_bottom_bg = $this->df_add_bg_field(
            array(
                'label'        => 'Background',
                'key'          => 'line_bottom_bg',
                'toggle_slug'  => 'design_line_bottom_marker',
                'tab_slug'     => 'advanced',
                'show_if'     => array(
                    'enable_line_bottom_marker' => 'on'
                )
            )
        );

        $title_bg = $this->df_add_bg_field(
            array(
                'label'        => 'Background',
                'key'          => 'title_bg',
                'toggle_slug'  => 'design_title',
                'tab_slug'     => 'advanced'
            )
        );

        $subtitle_bg = $this->df_add_bg_field(
            array(
                'label'        => 'Background',
                'key'          => 'subtitle_bg',
                'toggle_slug'  => 'design_subtitle',
                'tab_slug'     => 'advanced'
            )
        );

        $content_media_bg = $this->df_add_bg_field(
            array(
                'label'        => 'Background',
                'key'          => 'content_media_bg',
                'toggle_slug'  => 'design_media',
                'tab_slug'     => 'advanced'
            )
        );

        $content_text_bg = $this->df_add_bg_field(
            array(
                'label'        => 'Background',
                'key'          => 'content_text_bg',
                'toggle_slug'  => 'design_content',
                'tab_slug'     => 'advanced'
            )
        );

        $button_bg = $this->df_add_bg_field(
            array(
                'label'       => 'Background',
                'key'         => 'content_button_bg',
                'toggle_slug' => 'design_button',
                'tab_slug'    => 'advanced'
            )
        );

        $marker_bg = $this->df_add_bg_field(
            array(
                'label'       => 'Background',
                'key'         => 'marker_bg',
                'toggle_slug' => 'design_marker',
                'tab_slug'    => 'advanced'
            )
        );

        $active_marker_bg = $this->df_add_bg_field(
            array(
                'label'       => 'Background',
                'key'         => 'active_marker_bg',
                'toggle_slug' => 'animation',
                'tab_slug'    => 'general',
                'image'       => false,
                'show_if'     => array(
                    'enable_marker_animation' => 'on',

                )
            )
        );

        $date_wrapper_bg = $this->df_add_bg_field(
            array(
                'label'        => 'Background',
                'key'          => 'date_wrapper_bg',
                'toggle_slug'  => 'design_date_wrapper',
                'tab_slug'     => 'advanced',
                'show_if'       => array(
                    'disable_date' => 'off'
                )
            )
        );

        $item_wrapper_margin = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'item_wrapper',
            'toggle_slug'   => 'design_item_style',
            'default_padding' => '10px|10px|10px|10px'
        ));

        $title_margin = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'timeline_title',
            'toggle_slug'   => 'design_title',
        ));

        $subtitle_margin = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'timeline_subtitle',
            'toggle_slug'   => 'design_subtitle',
        ));

        $content_margin = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'timeline_content',
            'toggle_slug'   => 'design_content',
        ));

        $media_item_margin = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'timeline_media_item',
            'toggle_slug'   => 'design_media',
        ));

        $button_margin = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'timeline_button',
            'toggle_slug'   => 'design_button',
            'default_padding' => '5px|5px|5px|5px',
        ));

        $date_wrapper_margin = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'date_wrapper',
            'toggle_slug'   => 'design_date_wrapper',
            'default_padding' => '10px|10px|10px|10px'
        ));

        $date_title_margin = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'date_title',
            'toggle_slug'   => 'design_date_text',
            'sub_toggle'    => 'title',
            'option'        => 'margin'
        ));

        $date_subtitle_margin = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'date_subtitle',
            'toggle_slug'   => 'design_date_text',
            'sub_toggle'    => 'subtitle',
            'option'        => 'margin'
        ));

        $line_top_wrapper_margin = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'line_top_wrapper',
            'toggle_slug'   => 'design_line_top_marker',
            'default_padding' => '5px|5px|5px|5px',
            'show_if'         => array(
                'enable_line_top_marker' => 'on'
            )
        ));

        $line_bottom_wrapper_margin = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'line_bottom_wrapper',
            'toggle_slug'   => 'design_line_bottom_marker',
            'default_padding' => '5px|5px|5px|5px',
            'show_if'         => array(
                'enable_line_bottom_marker' => 'on'
            )
        ));

        return array_merge(
            $layout_type,
            $line_top_bg,
            $line_bottom_bg,
            $line_settings,
            $arrow_settings,
            $date_arrow_settings,
            $button_bg,
            $button,
            $button_margin,
            $animation,
            $active_marker_bg,
            $active_marker_color,
            $item_order,
            $item_wrapper_bg,
            $title_bg,
            $subtitle_bg,
            $content_text_bg,
            $content_media_bg,
            $marker_bg,
            $marker,
            $date_wrapper_bg,
            $title_margin,
            $subtitle_margin,
            $item_wrapper_margin,
            $content_margin,
            $media_item_margin,
            $date_wrapper_margin,
            $date_title_margin,
            $date_subtitle_margin,
            $line_top_wrapper_margin,
            $line_bottom_wrapper_margin
        );
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields['text'] = false;

        $advanced_fields['fonts'] = [
            'line_top_txt'   => array(
                'toggle_slug'  => 'design_line_top_marker',
                'tab_slug'     => 'advanced',
                'hide_text_align' => true,
                'font'  => array(
                    'show_if' => array(
                        'enable_line_top_marker' => 'on',
                        'line_top_marker_type'   => 'text'
                    )
                ),
                'font_weight'  => array(
                    'default'  => 'normal',
                    'show_if' => array(
                        'enable_line_top_marker' => 'on',
                        'line_top_marker_type'   => 'text'
                    )
                ),
                'text_align'  => array(
                    'default'  => 'left',
                    'show_if' => array(
                        'enable_line_top_marker' => 'on',
                        'line_top_marker_type'   => 'text'
                    )
                ),
                'text_color' => array(
                    'show_if' => array(
                        'enable_line_top_marker' => 'on',
                        'line_top_marker_type'   => 'text'
                    )
                ),
                'font_size'    => array(
                    'default'  => '18px',
                    'show_if' => array(
                        'enable_line_top_marker' => 'on',
                        'line_top_marker_type'   => 'text'
                    )
                ),
                'letter_spacing' => array(
                    'show_if' => array(
                        'enable_line_top_marker' => 'on',
                        'line_top_marker_type'   => 'text'
                    )
                ),
                'line_height'  => array(
                    'default'  => '1.7em',
                    'show_if' => array(
                        'enable_line_top_marker' => 'on',
                        'line_top_marker_type'   => 'text'
                    )
                ),
                'text_shadow' => array(
                    'show_if' => array(
                        'enable_line_top_marker' => 'on',
                        'line_top_marker_type'   => 'text'
                    )
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_top",
                    'hover' => "$this->main_css_element .df_timeline_top:hover",
                )
            ),
            'line_bottom_txt'   => array(
                'toggle_slug'  => 'design_line_bottom_marker',
                'tab_slug'     => 'advanced',
                'hide_text_align' => true,
                'font'  => array(
                    'show_if' => array(
                        'enable_line_bottom_marker' => 'on',
                        'line_bottom_marker_type'   => 'text'
                    )
                ),
                'font_weight'  => array(
                    'default'  => 'normal',
                    'show_if' => array(
                        'enable_line_bottom_marker' => 'on',
                        'line_bottom_marker_type'   => 'text'
                    )
                ),
                'text_align'  => array(
                    'default'  => 'left',
                    'show_if' => array(
                        'enable_line_bottom_marker' => 'on',
                        'line_bottom_marker_type'   => 'text'
                    )
                ),
                'text_color' => array(
                    'show_if' => array(
                        'enable_line_bottom_marker' => 'on',
                        'line_bottom_marker_type'   => 'text'
                    )
                ),
                'font_size'    => array(
                    'default'  => '18px',
                    'show_if' => array(
                        'enable_line_bottom_marker' => 'on',
                        'line_bottom_marker_type'   => 'text'
                    )
                ),
                'letter_spacing' => array(
                    'show_if' => array(
                        'enable_line_bottom_marker' => 'on',
                        'line_bottom_marker_type'   => 'text'
                    )
                ),
                'line_height'  => array(
                    'default'  => '1.7em',
                    'show_if' => array(
                        'enable_line_bottom_marker' => 'on',
                        'line_bottom_marker_type'   => 'text'
                    )
                ),
                'text_shadow' => array(
                    'show_if' => array(
                        'enable_line_bottom_marker' => 'on',
                        'line_bottom_marker_type'   => 'text'
                    )
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_bottom",
                    'hover' => "$this->main_css_element .df_timeline_bottom:hover",
                )
            ),
            'title' => array(
                'toggle_slug' => 'design_title',
                'tab_slug'    => 'advanced',
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'font_size'   => array(
                    'default' => '24px',
                ),
                'text_color'   => array(
                    'default' => '#333',
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_content_area .df_timeline_title",
                    'hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_title",
                )
            ),
            'subtitle' => array(
                'toggle_slug' => 'design_subtitle',
                'sub_toggle'  => 'subtitle',
                'tab_slug'    => 'advanced',
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'font_size'   => array(
                    'default' => '18px',
                ),
                'text_color'   => array(
                    'default' => '#333',
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_content_area .df_timeline_subtitle",
                    'hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_subtitle",
                )
            ),
            'design_content_text' => array(
                'toggle_slug' => 'design_content_text',
                'tab_slug'    => 'advanced',
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'text_color'  => array(
                    'default' => '#333',
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_content_area .df_timeline_desc, $this->main_css_element .df_timeline_content_area .df_timeline_desc p",
                    'hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_desc, $this->main_css_element .df_timeline_content_area:hover .df_timeline_desc p",
                ),
                'block_elements' => array(
                    'tabbed_subtoggles' => true,
                    'bb_icons_support'  => true,
                    'css'  => array(
                        'main'  => "$this->main_css_element .df_timeline_content_area .df_timeline_desc:not(blockquote p) p",
                        'hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_desc p",
                        'a'     => "$this->main_css_element .df_timeline_content_area .df_timeline_desc a",
                        'ul'    => "$this->main_css_element .df_timeline_content_area .df_timeline_desc ul",
                        'ol'    => "$this->main_css_element .df_timeline_content_area .df_timeline_desc ol",
                        'quote' => "$this->main_css_element .df_timeline_content_area .df_timeline_desc blockquote, $this->main_css_element .df_timeline_content_area .df_timeline_desc blockquote p"
                    )
                )
            ),
            'content_button'   => array(
                'toggle_slug'  => 'design_button',
                'tab_slug'     => 'advanced',
                'line_height'  => array(
                    'default'  => '1.7em',
                ),
                'text_color' => array(
                    'default'  => '#2ea3f2',
                ),
                'font_size'    => array(
                    'default'  => '18px',
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_button a",
                    'hover' => "$this->main_css_element .df_timeline_button a:hover",
                )
            ),
            'date_title' => array(
                'toggle_slug' => 'design_date_text',
                'sub_toggle'  => 'title',
                'tab_slug'    => 'advanced',
                'font'  => array(
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'font_weight'  => array(
                    'default'  => 'normal',
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'text_align'  => array(
                    'default' => 'left',
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'text_color' => array(
                    'default' => '#333',
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'font_size'    => array(
                    'default'  => '24px',
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'letter_spacing' => array(
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'line_height'  => array(
                    'default'  => '1.7em',
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'text_shadow' => array(
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content .df_timeline_date_title",
                    'hover' => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content:hover .df_timeline_date_title",
                )
            ),
            'date_subtitle' => array(
                'toggle_slug' => 'design_date_text',
                'sub_toggle'  => 'subtitle',
                'tab_slug'    => 'advanced',
                'font'  => array(
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'font_weight'  => array(
                    'default'  => 'normal',
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'text_align'  => array(
                    'default' => 'left',
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'text_color' => array(
                    'default' => '#333',
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'font_size'    => array(
                    'default'  => '18px',
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'letter_spacing' => array(
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'line_height'  => array(
                    'default'  => '1.7em',
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'text_shadow' => array(
                    'show_if' => array(
                        'disable_date' => 'off'
                    )
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content .df_timeline_date_subtitle",
                    'hover' => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content:hover .df_timeline_date_subtitle",
                )
            )
        ];

        // Arrow
        $advanced_fields['borders'] = array(
            'default'     => [],

            'item_wrapper_border' => array(
                'css'      => array(
                    'main' => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_content_area .df_timeline_content",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_content",
                        'border_styles'      => "$this->main_css_element .df_timeline_content_area .df_timeline_content",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_content",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => [
                        'width'     => "0px",
                        'color'     => "#504b4b",
                    ],
                ),
                'toggle_slug'    => 'design_item_style',
                'tab_slug'       => 'advanced'
            ),

            'title_border' => array(
                'css'      => array(
                    'main' => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_content_area .df_timeline_title",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_title",
                        'border_styles'      => "$this->main_css_element .df_timeline_content_area .df_timeline_title",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_title",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => [
                        'width'     => "0px",
                        'color'     => "#504b4b",
                    ],
                ),
                'toggle_slug'    => 'design_title',
                'tab_slug'       => 'advanced'
            ),

            'subtitle_border' => array(
                'css'      => array(
                    'main' => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_content_area .df_timeline_subtitle",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_subtitle",
                        'border_styles'      => "$this->main_css_element .df_timeline_content_area .df_timeline_subtitle",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_subtitle",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => [
                        'width'     => "0px",
                        'color'     => "#504b4b",
                    ],
                ),
                'toggle_slug'    => 'design_subtitle',
                'tab_slug'       => 'advanced'
            ),

            'content_text_wrapper_border' => array(
                'css' => array(
                    'main'  => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_content_area .df_timeline_desc",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_desc",
                        'border_styles'      => "$this->main_css_element .df_timeline_content_area .df_timeline_desc",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_desc",
                    ),
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => [
                        'width'     => "0px",
                        'color'     => "#504b4b",
                    ],
                ),
                'toggle_slug'     => 'design_content',
                'tab_slug'        => 'advanced',
            ),
            'content_media_border' => array(
                'css' => array(
                    'main'  => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_content_area .df_timeline_media>*",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_media>*",
                        'border_styles'      => "$this->main_css_element .df_timeline_content_area .df_timeline_media>*",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_media>*",
                    ),
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => [
                        'width'     => "0px",
                        'color'     => "#504b4b",
                    ],
                ),
                'toggle_slug'     => 'design_media',
                'tab_slug'        => 'advanced',
            ),

            'content_button_border' => array(
                'css' => array(
                    'main'  => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_button a",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_button a:hover",
                        'border_styles'      => "$this->main_css_element .df_timeline_button a",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_button a:hover",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => [
                        'width'     => "0px",
                        'color'     => "#504b4b",
                    ],
                ),
                'toggle_slug'     => 'design_button',
                'tab_slug'        => 'advanced'
            ),

            'line_top_border' => array(
                'css' => array(
                    'main'  => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_top .df_line_marker",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_top .df_line_marker:hover",
                        'border_styles'      => "$this->main_css_element .df_timeline_top .df_line_marker",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_top .df_line_marker:hover",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => [
                        'width'     => "0px",
                        'color'     => "#504b4b",
                    ],
                ),
                'toggle_slug'     => 'design_line_top_marker',
                'tab_slug'        => 'advanced',
                'depends_on'      => array('enable_line_top_marker'),
                'depends_show_if' => 'on'
            ),

            'line_bottom_border' => array(
                'css' => array(
                    'main'  => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_bottom .df_line_marker",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_bottom .df_line_marker:hover",
                        'border_styles'      => "$this->main_css_element .df_timeline_bottom .df_line_marker",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_bottom .df_line_marker:hover",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => [
                        'width'     => "0px",
                        'color'     => "#504b4b",
                    ],
                ),
                'toggle_slug'     => 'design_line_bottom_marker',
                'tab_slug'        => 'advanced',
                'depends_on'      => array('enable_line_bottom_marker'),
                'depends_show_if' => 'on'
            ),

            'marker_wrapper_border' => array(
                'css' => array(
                    'main' => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_marker",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_marker:hover",
                        'border_styles'      => "$this->main_css_element .df_timeline_marker",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_marker:hover",
                    )
                ),
                'defaults' => array(
                    'border_radii' => "on|0px|0px|0px|0px",
                    'border_styles' => [
                        'width'     => "0px",
                        'color'     => "#504b4b",
                    ],
                ),
                'toggle_slug'    => 'design_marker',
                'tab_slug'       => 'advanced'
            ),

            'date_wrapper_border' => array(
                'css'      => array(
                    'main' => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content:hover",
                        'border_styles'      => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content:hover",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => [
                        'width'     => "0px",
                        'color'     => "#504b4b",
                    ],
                ),
                'toggle_slug'    => 'design_date_wrapper',
                'tab_slug'       => 'advanced',
                'depends_on'     => array('disable_date'),
                'depends_show_if' => 'off'

            )
        );

        $advanced_fields['box_shadow'] = array(
            'default'       => [],
            'item_wrapper_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_content_area .df_timeline_content",
                    'hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_content",
                ),
                'toggle_slug' => 'design_item_style',
                'tab_slug'    => 'advanced',
            ),
            'title_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_content_area .df_timeline_title",
                    'hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_title",
                ),
                'toggle_slug' => 'design_title',
                'tab_slug'    => 'advanced',
            ),
            'subtitle_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_content_area .df_timeline_subtitle",
                    'hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_subtitle",
                ),
                'toggle_slug' => 'design_subtitle',
                'tab_slug'    => 'advanced',
            ),
            'content_text_wrapper_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_content_area .df_timeline_desc",
                    'hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_desc",
                ),
                'toggle_slug' => 'design_content',
                'tab_slug'    => 'advanced',
            ),
            'content_media_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_content_area .df_timeline_media>*",
                    'hover' => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_media>*",
                ),
                'toggle_slug' => 'design_media',
                'tab_slug'    => 'advanced',
            ),
            'content_button_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_button a",
                    'hover' => "$this->main_css_element .df_timeline_button a:hover",
                ),
                'toggle_slug' => 'design_button',
                'tab_slug'    => 'advanced',
            ),
            'line_top_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_top .df_line_marker",
                    'hover' => "$this->main_css_element .df_timeline_top .df_line_marker:hover",
                ),
                'toggle_slug' => 'design_line_top_marker',
                'tab_slug'    => 'advanced',
                'depends_on'      => array('enable_line_top_marker'),
                'depends_show_if' => 'on'
            ),
            'line_bottom_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_bottom .df_line_marker",
                    'hover' => "$this->main_css_element .df_timeline_bottom .df_line_marker:hover",
                ),
                'toggle_slug' => 'design_line_bottom_marker',
                'tab_slug'    => 'advanced',
                'depends_on'      => array('enable_line_bottom_marker'),
                'depends_show_if' => 'on'
            ),
            'marker_wrapper_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_marker",
                    'hover' => "$this->main_css_element .df_timeline_marker:hover",
                ),
                'toggle_slug' => 'design_marker',
                'tab_slug'    => 'advanced',
            ),
            'date_wrapper_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content",
                    'hover' => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content:hover",
                ),
                'toggle_slug' => 'design_date_wrapper',
                'tab_slug'    => 'advanced',
                'depends_on'  => array('disable_date'),
                'depends_show_if' => 'off'
            )
        );

        $advanced_fields['margin_padding'] = array(
            'css' => array(
                'important' => 'all'
            )
        );

        $advanced_fields['max_width'] = array(
            'css' => array(
                'main'             => $this->main_css_element,
                'module_alignment' => "$this->main_css_element.et_pb_module",
                'important' => 'all'
            ),
        );

        return $advanced_fields;
    }

    public function get_transition_fields_css_props()
    {
        $fields = parent::get_transition_fields_css_props();
        $item_wrapper = "$this->main_css_element .df_timeline_content_area";
        $content_area = "$item_wrapper .df_timeline_content";
        $title_wrapper = "$item_wrapper .df_timeline_title";
        $subtitle_wrapper = "$item_wrapper .df_timeline_subtitle";
        $content_text_wrapper = "$item_wrapper .df_timeline_desc";
        $content_media = "$item_wrapper .df_timeline_media";
        $arrow_caret = "$item_wrapper .timeline_arrow_caret";
        $arrow_icon = "$item_wrapper .timeline_arrow_icon";
        $arrow_line = "$item_wrapper .timeline_arrow_line";
        $date_wrapper = "$this->main_css_element .df_timeline_date_area .df_timeline_date_content";
        $date_arrow_caret = "$date_wrapper .timeline_arrow_caret";
        $date_arrow_icon = "$date_wrapper .timeline_arrow_icon";
        $date_arrow_line = "$date_wrapper .timeline_arrow_line";
        $button = "$this->main_css_element .df_timeline_button a";
        $button_icon = "$button .df_timeline_btn_icon";
        $line = "$this->main_css_element .df_timeline_line";
        $scroll_line = $line . ":after";
        $line_top = "$this->main_css_element .df_timeline_top .df_line_marker";
        $line_bottom = "$this->main_css_element .df_timeline_bottom .df_line_marker";
        $active_marker_color = "$this->main_css_element .df_timeline_marker.active,
                                $this->main_css_element .difl_timelineitem .df_timeline_marker.active .df_timeline_marker_icon,
                                $this->main_css_element .df_timeline_top .active.df_line_marker,
                                $this->main_css_element .df_timeline_top .active.df_line_marker .df_timeline_top_icon,
                                $this->main_css_element .df_timeline_bottom .active.df_line_marker,
                                $this->main_css_element .df_timeline_bottom .active.df_line_marker .df_timeline_bottom_icon";

        // Color
        if (isset($this->props['arrow_type'])) {
            switch ($this->props['arrow_type']) {
                case 'arrow_caret':
                    $fields['arrow_color'] = array('border-right-color' => $arrow_caret);
                    break;
                case 'arrow_icon':
                    $fields['arrow_color'] = array('border-right-color' => $arrow_icon);
                    break;
                case 'arrow_line':
                    $fields['arrow_color'] = array('border-right-color' => $arrow_line);
                    break;
            }
        }

        if (isset($this->props['date_arrow_type'])) {
            switch ($this->props['date_arrow_type']) {
                case 'arrow_caret':
                    $fields['arrow_color'] = array('border-right-color' => $date_arrow_caret);
                    break;
                case 'arrow_icon':
                    $fields['arrow_color'] = array('color' => $date_arrow_icon);
                    break;
                case 'arrow_line':
                    $fields['arrow_color'] = array('border-color' => $date_arrow_line);
                    break;
            }
        }

        $fields['button_icon_color'] = array('color' => $button_icon);
        $fields['line_color'] = array('background-color' => $line);
        $fields['scroll_line_color'] = array('background-color' => $scroll_line);
        $fields['active_marker_color'] = array('color' => $active_marker_color);
        $fields['marker_icon_color'] = array('color' => "$this->main_css_element .df_timeline_marker .df_timeline_marker_icon");
        $fields['line_top_icon_color'] = array('color' => "$this->main_css_element .df_timeline_top .df_timeline_top_icon");
        $fields['line_bottom_icon_color'] = array('color' => "$this->main_css_element .df_timeline_bottom .df_timeline_bottom_icon");

        // Background
        $fields = $this->df_background_transition(
            array(
                'fields'   => $fields,
                'key'      => 'item_wrapper_bg',
                'selector' => $content_area
            )
        );

        $fields = $this->df_background_transition(
            array(
                'fields'   => $fields,
                'key'      => 'title_bg',
                'selector' => $title_wrapper
            )
        );

        $fields = $this->df_background_transition(
            array(
                'fields'   => $fields,
                'key'      => 'subtitle_bg',
                'selector' => $subtitle_wrapper
            )
        );

        $fields = $this->df_background_transition(
            array(
                'fields'   => $fields,
                'key'      => 'content_text_bg',
                'selector' => $content_text_wrapper
            )
        );

        $fields = $this->df_background_transition(
            array(
                'fields'   => $fields,
                'key'      => 'content_media_bg',
                'selector' => "$content_media>*"
            )
        );

        $fields = $this->df_background_transition(
            array(
                'fields'   => $fields,
                'key'      => 'content_button_bg',
                'selector' => $button
            )
        );

        $fields = $this->df_background_transition(
            array(
                'fields'   => $fields,
                'key'      => 'date_wrapper_bg',
                'selector' => $date_wrapper
            )
        );

        $fields = $this->df_background_transition(
            array(
                'fields'   => $fields,
                'key'      => 'marker_bg',
                'selector' => "$this->main_css_element .df_timeline_marker"
            )
        );

        $fields = $this->df_background_transition(
            array(
                'fields'   => $fields,
                'key'      => 'active_marker_bg',
                'selector' => "$this->main_css_element .df_timeline_marker.active"
            )
        );

        $fields = $this->df_background_transition(
            array(
                'fields'   => $fields,
                'key'      => 'line_top_bg',
                'selector' => $line_top
            )
        );

        $fields = $this->df_background_transition(
            array(
                'fields'   => $fields,
                'key'      => 'line_bottom_bg',
                'selector' => $line_bottom
            )
        );

        $fields = $this->df_background_transition(
            array(
                'fields'   => $fields,
                'key'      => 'active_marker_bg',
                'selector' => "$this->main_css_element .df_timeline_top .active.df_line_marker, $this->main_css_element .df_timeline_bottom .active.df_line_marker"
            )
        );

        // Border
        $fields = $this->df_fix_border_transition($fields, 'item_wrapper_border', $content_area);
        $fields = $this->df_fix_border_transition($fields, 'title_border', $title_wrapper);
        $fields = $this->df_fix_border_transition($fields, 'subtitle_border', $subtitle_wrapper);
        $fields = $this->df_fix_border_transition($fields, 'content_text_wrapper_border', $content_text_wrapper);
        $fields = $this->df_fix_border_transition($fields, 'content_media_border', "$content_media>*");
        $fields = $this->df_fix_border_transition($fields, 'content_button_border', $button);
        $fields = $this->df_fix_border_transition($fields, 'marker_wrapper_border', "$this->main_css_element .df_timeline_marker");
        $fields = $this->df_fix_border_transition($fields, 'marker_wrapper_border', "$this->main_css_element .active.df_timeline_marker");
        $fields = $this->df_fix_border_transition($fields, 'marker_wrapper_border', "$this->main_css_element .df_timeline_top .active.df_line_marker");
        $fields = $this->df_fix_border_transition($fields, 'marker_wrapper_border', "$this->main_css_element .df_timeline_bottom .active.df_line_marker");
        $fields = $this->df_fix_border_transition($fields, 'date_wrapper_border', $date_wrapper);
        $fields = $this->df_fix_border_transition($fields, 'line_top_border', $line_top);
        $fields = $this->df_fix_border_transition($fields, 'line_bottom_border', $line_bottom);

        // Box Shadow
        $fields = $this->df_fix_box_shadow_transition($fields, 'item_wrapper_box_shadow', $item_wrapper);
        $fields = $this->df_fix_box_shadow_transition($fields, 'title_box_shadow', $title_wrapper);
        $fields = $this->df_fix_box_shadow_transition($fields, 'subtitle_box_shadow', $subtitle_wrapper);
        $fields = $this->df_fix_box_shadow_transition($fields, 'content_text_wrapper_box_shadow', $content_text_wrapper);
        $fields = $this->df_fix_box_shadow_transition($fields, 'content_media_box_shadow', "$content_media>*");
        $fields = $this->df_fix_box_shadow_transition($fields, 'content_button_box_shadow', $button);
        $fields = $this->df_fix_box_shadow_transition($fields, 'date_wrapper_box_shadow', $date_wrapper);
        $fields = $this->df_fix_box_shadow_transition($fields, 'line_top_box_shadow', $line_top);
        $fields = $this->df_fix_box_shadow_transition($fields, 'line_bottom_box_shadow', $line_bottom);

        //Spacing
        $fields['timeline_title_margin'] = array('margin' => $title_wrapper);
        $fields['timeline_title_padding'] = array('margin' => $title_wrapper);
        $fields['timeline_subtitle_margin'] = array('margin' => $subtitle_wrapper);
        $fields['timeline_subtitle_padding'] = array('margin' => $subtitle_wrapper);
        $fields['item_wrapper_margin'] = array('margin' => $content_area);
        $fields['item_wrapper_padding'] = array('padding' => $content_area);
        $fields['timeline_media_item_margin'] = array('padding' => "$content_media");
        $fields['timeline_media_item_padding'] = array('padding' => "$content_media>*");
        $fields['timeline_content_margin'] = array('margin' => $content_text_wrapper);
        $fields['timeline_content_padding'] = array('padding' => $content_text_wrapper);
        $fields['timeline_button_margin'] = array('margin' => $button);
        $fields['timeline_button_padding'] = array('padding' => $button);
        $fields['date_wrapper_margin'] = array('margin' => $date_wrapper);
        $fields['date_wrapper_padding'] = array('padding' => $date_wrapper);
        $fields['date_title_margin'] = array('margin' => "$date_wrapper .df_timeline_date_title");
        $fields['date_subtitle_margin'] = array('margin' => "$date_wrapper .df_timeline_date_subtitle");
        $fields['line_top_wrapper_margin'] = array('padding' => $line_top);
        $fields['line_top_wrapper_padding'] = array('padding' => $line_top);
        $fields['line_bottom_wrapper_margin'] = array('padding' => $line_bottom);
        $fields['line_bottom_wrapper_padding'] = array('padding' => $line_bottom);

        return $fields;
    }

    public function get_custom_css_fields_config()
    {
        $item_wrapper = "$this->main_css_element .df_timeline_content_area";
        $title = "$item_wrapper .df_timeline_title";
        $subtitle = "$item_wrapper .df_timeline_subtitle";
        $content_text = "$item_wrapper .df_timeline_desc, $item_wrapper .df_timeline_desc p";
        $content_media = "$this->main_css_element .df_timeline_content_area .df_timeline_media";
        $marker_wrapper = "$this->main_css_element .df_timeline_item .df_timeline_marker";
        $date_wrapper = "$this->main_css_element .df_timeline_date_area .df_timeline_date_content";
        $date_title = "$date_wrapper .df_timeline_date_title";
        $date_subtitle = "$date_wrapper .df_timeline_date_subtitle";
        $button = "$this->main_css_element .df_timeline_button a";
        $button_icon = "$button .df_timeline_btn_icon";
        $line = "$this->main_css_element .df_timeline_line";
        $scroll_line = "$this->main_css_element .df_line_inner";

        return array(
            'item_wrapper_css' => array(
                'label'    => esc_html__('Item Wrapper', 'divi_flash'),
                'selector' => $item_wrapper,
            ),
            'title_text_css' => array(
                'label'    => esc_html__('Title', 'divi_flash'),
                'selector' => $title,
            ),
            'subtitle_text_css' => array(
                'label'    => esc_html__('Subtitle', 'divi_flash'),
                'selector' => $subtitle,
            ),
            'content_text_css' => array(
                'label'    => esc_html__('Content', 'divi_flash'),
                'selector' => $content_text,
            ),
            'content_media_wrapper_css' => array(
                'label'    => esc_html__('Media Wrapper', 'divi_flash'),
                'selector' => $content_media,
            ),
            'content_arrow_css' => array(
                'label'    => esc_html__('Content Arrow', 'divi_flash'),
                'selector' => "$item_wrapper .timeline_arrow>*",
            ),
            'marker_wrapper_css' => array(
                'label'    => esc_html__('Marker Wrapper', 'divi_flash'),
                'selector' => $marker_wrapper,
            ),
            'marker_css' => array(
                'label'    => esc_html__('Marker', 'divi_flash'),
                'selector' => "$marker_wrapper>*",
            ),
            'date_wrapper_css' => array(
                'label'    => esc_html__('Date Wrapper', 'divi_flash'),
                'selector' => $date_wrapper,
            ),
            'date_title_css' => array(
                'label'    => esc_html__('Date Title', 'divi_flash'),
                'selector' => $date_title,
            ),
            'date_subtitle_css' => array(
                'label'    => esc_html__('Date Subtitle', 'divi_flash'),
                'selector' => $date_subtitle,
            ),
            'date_arrow_css' => array(
                'label'    => esc_html__('Date Arrow', 'divi_flash'),
                'selector' => "$date_wrapper .timeline_arrow>*",
            ),
            'content_button_css' => array(
                'label'    => esc_html__('Button', 'divi_flash'),
                'selector' => $button,
            ),
            'content_button_icon_css' => array(
                'label'    => esc_html__('Button Icon', 'divi_flash'),
                'selector' => $button_icon,
            ),
            'line_css' => array(
                'label'    => esc_html__('Line', 'divi_flash'),
                'selector' => $line,
            ),
            'scroll_line_css' => array(
                'label'    => esc_html__('Scroll Line', 'divi_flash'),
                'selector' => $scroll_line,
            ),
            'line_top_marker_css' => array(
                'label'    => esc_html__('Line Top Marker', 'divi_flash'),
                'selector' => "$this->main_css_element .df_timeline_top .df_line_marker, $this->main_css_element .df_timeline_top .df_line_marker>*",
            ),
            'line_bottom_marker_css' => array(
                'label'    => esc_html__('Line Bottom Marker', 'divi_flash'),
                'selector' => "$this->main_css_element .df_timeline_bottom .df_line_marker, $this->main_css_element .df_timeline_bottom .df_line_marker>*",
            ),
        );
    }

    public function additional_css_styles($render_slug)
    {
        if (method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {

            if ("" !== $this->props['line_top_icon']) {
                $this->generate_styles(
                    array(
                        'utility_arg'    => 'icon_font_family',
                        'render_slug'    => $render_slug,
                        'base_attr_name' => 'line_top_icon',
                        'important'      => true,
                        'selector'       => "$this->main_css_element .df_timeline_top .df_timeline_top_icon",
                        'processor'      => array(
                            'ET_Builder_Module_Helper_Style_Processor',
                            'process_extended_icon'
                        ),
                    )
                );
            }

            if ("" !== $this->props['line_top_icon']) {
                $this->generate_styles(
                    array(
                        'utility_arg'    => 'icon_font_family',
                        'render_slug'    => $render_slug,
                        'base_attr_name' => 'line_top_icon',
                        'important'      => true,
                        'selector'       => "$this->main_css_element .df_timeline_top .df_timeline_top_icon",
                        'processor'      => array(
                            'ET_Builder_Module_Helper_Style_Processor',
                            'process_extended_icon'
                        ),
                    )
                );
            }

            if ("" !== $this->props['line_bottom_icon']) {
                $this->generate_styles(
                    array(
                        'utility_arg'    => 'icon_font_family',
                        'render_slug'    => $render_slug,
                        'base_attr_name' => 'line_bottom_icon',
                        'important'      => true,
                        'selector'       => "$this->main_css_element .df_timeline_bottom .df_timeline_bottom_icon",
                        'processor'      => array(
                            'ET_Builder_Module_Helper_Style_Processor',
                            'process_extended_icon'
                        ),
                    )
                );
            }
        }

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'item_wrapper_bg',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_content",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_content",
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'line_top_bg',
                'selector'    => "$this->main_css_element .df_timeline_top .df_line_marker",
                'hover'       => "$this->main_css_element .df_timeline_top .df_line_marker:hover",
                'important'   => true
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'active_marker_bg',
                'selector'    => "$this->main_css_element .df_timeline_top .active.df_line_marker",
                'hover'       => "$this->main_css_element .df_timeline_top.hover .active.df_line_marker",
                'important'   => true
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'line_bottom_bg',
                'selector'    => "$this->main_css_element .df_timeline_bottom .df_line_marker",
                'hover'       => "$this->main_css_element .df_timeline_bottom .df_line_marker:hover",
                'important'   => true
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'active_marker_bg_bgcolor',
                'type'        => 'border-color',
                'selector'    => "$this->main_css_element .df_timeline_top .active.df_line_marker",
                'hover'       => "$this->main_css_element .df_timeline_top:hover .active.df_line_marker"
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'active_marker_bg',
                'selector'    => "$this->main_css_element .df_timeline_bottom .active.df_line_marker",
                'hover'       => "$this->main_css_element .df_timeline_bottom.hover .active.df_line_marker",
                'important'   => true
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'active_marker_bg_bgcolor',
                'type'        => 'border-color',
                'selector'    => "$this->main_css_element .df_timeline_bottom .active.df_line_marker",
                'hover'       => "$this->main_css_element .df_timeline_bottom:hover .active.df_line_marker"
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'title_bg',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_title",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_title",
                'important'   => true
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'subtitle_bg',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_subtitle",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_subtitle",
                'important'   => true
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'content_text_bg',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_desc",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_desc",
                'important'   => true
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'content_media_bg',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_media>*",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_media>*",
                'important'   => true
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'content_button_bg',
                'selector'    => "$this->main_css_element .df_timeline_button a",
                'hover'       => "$this->main_css_element .df_timeline_button a:hover",
                'important'   => true
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'button_icon_color',
                'type'        => 'color',
                'selector'    => "$this->main_css_element .df_timeline_button .df_timeline_btn_icon",
                'hover'       => "$this->main_css_element .df_timeline_button a:hover .df_timeline_btn_icon"
            )
        );

        $this->df_process_range(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'button_icon_size',
                'type'        => 'font-size',
                'default'     => '18px',
                'selector'    => "$this->main_css_element .df_timeline_button a .df_timeline_btn_icon",
                'hover'       => "$this->main_css_element .df_timeline_button a:hover .df_timeline_btn_icon",
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'marker_bg',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker",
                'hover'       => "$this->main_css_element .df_timeline_item:hover .df_timeline_marker",
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'active_marker_bg',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker.active",
                'hover'       => "$this->main_css_element .df_timeline_item:hover .df_timeline_marker.active",
                'important'   => true
            )
        );

        $this->df_process_range(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'marker_width',
                'type'        => 'width',
                'default'     => '50px',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_marker:hover",
            )
        );

        $this->df_process_range(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'marker_height',
                'type'        => 'height',
                'default'     => '50px',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_marker:hover",
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'active_marker_color',
                'type'        => 'color',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker.active,
                                  $this->main_css_element .difl_timelineitem .df_timeline_marker.active .df_timeline_marker_icon,
                                  $this->main_css_element .df_timeline_top .active.df_line_marker,
                                  $this->main_css_element .df_timeline_top .active.df_line_marker .df_timeline_top_icon,
                                  $this->main_css_element .df_timeline_bottom .active.df_line_marker,
                                  $this->main_css_element .df_timeline_bottom .active.df_line_marker .df_timeline_bottom_icon",
                'hover'       => "$this->main_css_element .df_timeline_item.hover .df_timeline_marker.active,
                                  $this->main_css_element .difl_timelineitem:hover .df_timeline_marker.active .df_timeline_marker_icon
                                  $this->main_css_element .df_timeline_top.hover .active.df_line_marker,
                                  $this->main_css_element .df_timeline_top.hover .active.df_line_marker .df_timeline_top_icon,
                                  $this->main_css_element .df_timeline_bottom.hover .active.df_line_marker,
                                  $this->main_css_element .df_timeline_bottom.hover .active.df_line_marker .df_timeline_bottom_icon"
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'active_marker_bg_bgcolor',
                'type'        => 'border-color',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker.active",
                'hover'       => "$this->main_css_element .df_timeline_item:hover .df_timeline_marker.active"
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'marker_icon_color',
                'type'        => 'color',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker_icon",
                'hover'       => "$this->main_css_element .df_timeline_item:hover .df_timeline_marker_icon"
            )
        );

        $this->df_process_range(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'marker_icon_size',
                'type'        => 'font-size',
                'default'     => '24px',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker .df_timeline_marker_icon",
                'hover'       => "$this->main_css_element .df_timeline_item:hover .df_timeline_marker .df_timeline_marker_icon",
                'important'   => false
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'date_wrapper_bg',
                'selector'    => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content",
                'hover'       => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content:hover",
                'important'   => true
            )
        );

        // margin-padding
        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'item_wrapper_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_content",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_content",
                'important'   => true
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'item_wrapper_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_content",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_content",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_title_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_title",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_title",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_title_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_title",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_title",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_subtitle_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_subtitle",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_subtitle",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_subtitle_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_subtitle",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_subtitle",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_content_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_desc",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_desc",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_content_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_desc",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_desc",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_media_item_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_media",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_media",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_media_item_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_media>*",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_media>*",
                'important'   => false
            )
        );


        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_button_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_button a",
                'hover'       => "$this->main_css_element .df_timeline_content_area .df_timeline_button a:hover",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_button_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_button a",
                'hover'       => "$this->main_css_element .df_timeline_content_area .df_timeline_button a:hover",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'date_wrapper_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content",
                'hover'       => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content:hover",
                'important'   => true
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'date_wrapper_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content",
                'hover'       => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content:hover",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'date_title_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_date_content .df_timeline_date_title",
                'hover'       => "$this->main_css_element .df_timeline_date_content:hover .df_timeline_date_title",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'date_subtitle_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_date_content .df_timeline_date_subtitle",
                'hover'       => "$this->main_css_element .df_timeline_date_content:hover .df_timeline_date_subtitle",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'line_top_wrapper_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_top .df_line_marker",
                'hover'       => "$this->main_css_element .df_timeline_top .df_line_marker:hover",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'line_top_wrapper_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_top .df_line_marker",
                'hover'       => "$this->main_css_element .df_timeline_top .df_line_marker:hover",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'line_bottom_wrapper_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_bottom .df_line_marker",
                'hover'       => "$this->main_css_element .df_timeline_bottom .df_line_marker:hover",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'line_bottom_wrapper_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_bottom .df_line_marker",
                'hover'       => "$this->main_css_element .df_timeline_bottom .df_line_marker:hover",
                'important'   => false
            )
        );

        // Vertical alignment
        $this->df_process_string_attr(array(
            'render_slug' => $render_slug,
            'slug'        => 'item_vertical_alignment',
            'type'        => 'align-items',
            'selector'    => "$this->main_css_element .df_timeline_item",
            'important'   => true,
        ));

        $this->df_process_string_attr(array(
            'render_slug' => $render_slug,
            'slug'        => 'item_horizontal_alignment',
            'type'        => 'justify-content',
            'selector'    => "$this->main_css_element .df_timeline_item",
        ));

        // Item Gap
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_horizontal_gap',
            'type'              => 'column-gap',
            'selector'          => "$this->main_css_element .df_timeline_item",
            'default'           => '50px',
        ));

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_vertical_gap',
            'type'              => 'margin-top',
            'selector'          => "$this->main_css_element .difl_timelineitem:not(:first-child)", // margin top not working on this selector
            'default'           => '50px',
        ));

        // blurb & date width
        if ("middle" === $this->props['layout_type']) {
            $module_width = str_replace(["%", "px"], "", $this->props['module_area_width']) / 2;
            $unit = $this->df_get_unit($this->props['module_area_width']);

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_content_area, $this->main_css_element .df_timeline_date_area",
                'declaration' => "flex-basis: " . $module_width . $unit . " !important;"
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'date_area_width',
                'type'              => 'width',
                'selector'          => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content",
                // 'default'           => '40%',
                'important'         => false,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content",
                'declaration' => "width: 100%;",
                'media_query' => self::get_media_query('max_width_767')
            ));
        } else {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'blurb_area_width',
                'type'              => 'flex-basis',
                'selector'          => "$this->main_css_element .df_timeline_content_area",
                'default'           => '50%',
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'date_area_width',
                'type'              => 'flex-basis',
                'selector'          => "$this->main_css_element .df_timeline_date_area",
                'default'           => '40%',
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content",
                'declaration' => "width: 100%;"
            ));
        }

        if (isset($this->props['date_area_width_phone'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content",
                'declaration' => "width: " . $this->props['date_area_width_phone'] . " !important;",
                'media_query' => self::get_media_query('max_width_767')
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content",
                'declaration' => "width: 100% !important;",
                'media_query' => self::get_media_query('max_width_767')
            ));
        }

        if ("on" === $this->props['enable_date_in_blurb']) {
            if (isset($this->props['date_area_width_phone'])) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content",
                    'declaration' => "width: " . $this->props['date_area_width_phone'] . " !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            } else {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content",
                    'declaration' => "width: 90% !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_container .df_timeline_date_area",
                'declaration' => "justify-content:" . $this->props['date_horizontal_alignment'] . " !important;",
                'media_query' => self::get_media_query('max_width_767')
            ));
        }

        if ('on' === $this->props['disable_date'] || 'on' === $this->props['disable_date_mobile']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_date_area",
                'declaration' => "display: none !important;",
                'media_query' => self::get_media_query('max_width_767')
            ));
        }

        // Line
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'line_width',
            'type'              => 'width',
            'selector'          => "$this->main_css_element .df_timeline_line",
            'default'           => '3px',
        ));

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'line_width',
            'type'              => 'width',
            'selector'          => "$this->main_css_element .df_timeline_item .df_line_inner",
            'default'           => '3px',
        ));

        $this->df_process_color(
            array(
                'render_slug'  => $render_slug,
                'slug'         => 'line_color',
                'type'         => 'background-color',
                'selector'     => "$this->main_css_element .df_timeline_line",
                'hover'        => "$this->main_css_element .df_timeline_line:hover",
                'important'    => false
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'line_top_icon_color',
                'type'        => 'color',
                'selector'    => "$this->main_css_element .df_timeline_top .df_timeline_top_icon",
                'hover'       => "$this->main_css_element .df_timeline_top .df_timeline_top_icon:hover"
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'line_bottom_icon_color',
                'type'        => 'color',
                'selector'    => "$this->main_css_element .df_timeline_bottom .df_timeline_bottom_icon",
                'hover'       => "$this->main_css_element .df_timeline_bottom .df_timeline_bottom_icon:hover"
            )
        );

        $this->df_process_color(
            array(
                'render_slug'  => $render_slug,
                'slug'         => 'scroll_line_color',
                'type'         => 'background-color',
                'selector'     => "$this->main_css_element .df_timeline_item .df_line_inner",
                'hover'        => "$this->main_css_element .df_timeline_item:hover .df_line_inner",
                'important'    => false
            )
        );

        // top marker
        if ('on' === $this->props['enable_line_top_marker']) {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'line_top_marker_vertical_position',
                'type'              => 'bottom',
                'selector'          => "$this->main_css_element .df_timeline_top>*",
                'default'           => '0px',
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'line_top_icon_size',
                'type'              => 'font-size',
                'selector'          => "$this->main_css_element .df_timeline_top .df_timeline_top_icon",
                'default'           => '24px',
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'line_top_img_width',
                'type'              => 'width',
                'selector'          => "$this->main_css_element .df_timeline_top img",
                'default'           => '30px',
            ));
        }

        // bottom marker
        if ('on' === $this->props['enable_line_bottom_marker']) {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'line_bottom_marker_vertical_position',
                'type'              => 'top',
                'selector'          => "$this->main_css_element .df_timeline_bottom>*",
                'default'           => '0px',
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'line_bottom_icon_size',
                'type'              => 'font-size',
                'selector'          => "$this->main_css_element .df_timeline_bottom .df_timeline_bottom_icon",
                'default'           => '24px',
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'line_bottom_img_width',
                'type'              => 'width',
                'selector'          => "$this->main_css_element .df_timeline_bottom img",
                'default'           => '30px',
            ));
        }

        // content arrow
        if ("on" == $this->props['enable_arrow']) {
            $arrow_type = $this->props['arrow_type'] ? $this->props['arrow_type'] : "arrow_caret";
            $arrow_selector = "";
            $arrow_selector_rev = "";
            switch ($arrow_type) {
                case 'arrow_caret':
                    $arrow_selector = "$this->main_css_element .df_timeline_item .df_timeline_content_area .timeline_arrow_caret";
                    $arrow_selector_rev = "$this->main_css_element .df_timeline_item.reverse .df_timeline_content_area .timeline_arrow_caret";
                    break;
                case 'arrow_icon':
                    $arrow_selector = "$this->main_css_element .df_timeline_item .df_timeline_content_area .timeline_arrow_icon";
                    $arrow_selector_rev = "$this->main_css_element .df_timeline_item.reverse .df_timeline_content_area .timeline_arrow_icon";
                    break;
                case 'arrow_line':
                    $arrow_selector = "$this->main_css_element .df_timeline_item .df_timeline_content_area .timeline_arrow_line";
                    $arrow_selector_rev = "$this->main_css_element .df_timeline_item.reverse .df_timeline_content_area .timeline_arrow_line";
                    break;
            }

            if ("arrow_caret" == $arrow_type) {
                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'arrow_size',
                    'type'              => 'border-width',
                    'selector'          => $arrow_selector,
                    'default'           => '30px',
                ));

                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => $arrow_selector,
                    'declaration' => "border-left-width: 0px !important;"
                ));

                $this->df_process_color(
                    array(
                        'render_slug'  => $render_slug,
                        'slug'         => 'arrow_color',
                        'type'         => 'border-right-color',
                        'selector'     => $arrow_selector,
                        'hover'        => "$this->main_css_element .df_timeline_content_area:hover .timeline_arrow_caret"
                    )
                );
            }

            if ("arrow_icon" == $arrow_type) {
                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'arrow_size',
                    'type'              => 'font-size',
                    'selector'          => $arrow_selector,
                    'default'           => '20px',
                ));

                $this->df_process_color(
                    array(
                        'render_slug'  => $render_slug,
                        'slug'         => 'arrow_color',
                        'type'         => 'color',
                        'selector'     => $arrow_selector,
                        'hover'        => "$this->main_css_element .df_timeline_content_area:hover .timeline_arrow_icon"
                    )
                );
            }

            if ("arrow_line" == $arrow_type) {
                $this->df_process_string_attr(array(
                    'render_slug' => $render_slug,
                    'slug'        => 'arrow_line_type',
                    'type'        => 'border-style',
                    'selector'    => $arrow_selector,
                    'important'   => true
                ));

                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'arrow_size',
                    'type'              => 'width',
                    'selector'          => $arrow_selector,
                    'default'           => '20px',
                ));

                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'arrow_thick',
                    'type'              => 'border-top-width',
                    'selector'          => $arrow_selector,
                    'default'           => '2px',
                ));

                $this->df_process_color(
                    array(
                        'render_slug'  => $render_slug,
                        'slug'         => 'arrow_color',
                        'type'         => 'border-color',
                        'selector'     => $arrow_selector,
                        'hover'        => "$this->main_css_element .df_timeline_content_area:hover .timeline_arrow_line"
                    )
                );
            }

            // Arrow horizontal position
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_horizontal_position',
                'type'              => 'margin-right',
                'selector'          => $arrow_selector,
                'default'           => '0px',
                'important'         => false,
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_horizontal_position',
                'type'              => 'margin-left',
                'selector'          => $arrow_selector_rev,
                'default'           => '0px',
                'important'         => false
            ));

            if ('arrow_icon' === $arrow_type && "on" === $this->props['reverse_arrow']) {
                if (str_replace('px', '', $this->props['arrow_horizontal_position']) > 0) {
                    $this->df_process_range(array(
                        'render_slug'       => $render_slug,
                        'slug'              => 'arrow_horizontal_position',
                        'type'              => 'margin-left',
                        'selector'          => $arrow_selector_rev,
                        'default'           => $this->df_get_mobile_value('arrow_size'),
                        'important'         => false
                    ));
                } else {
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => $arrow_selector_rev,
                        'declaration' => "margin-left:" . $this->df_get_mobile_value('arrow_size') . ";"
                    ));
                }
            }

            // arrow reverse
            if ("on" === $this->props['reverse_arrow'] && "arrow_caret" === $arrow_type) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => $arrow_selector,
                    'declaration' => "transform: rotate(180deg) !important;"
                ));

                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => $arrow_selector_rev,
                    'declaration' => "transform: rotate(0deg) !important;"
                ));
            }

            if ("on" === $this->props['reverse_arrow'] && "arrow_icon" === $this->props['arrow_type']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => $arrow_selector,
                    'declaration' => "transform: rotate(0deg) !important;"
                ));

                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => $arrow_selector_rev,
                    'declaration' => "transform: rotate(180deg) !important;"
                ));
            }

            if ('left' === $this->props['layout_type_mobile'] && "off" === $this->props['reverse_arrow']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_container.layout_left .df_timeline_content_area .timeline_arrow_icon",
                    'declaration' => "transform: rotate(180deg) !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }

            if ('left' === $this->props['layout_type_mobile'] && "on" === $this->props['reverse_arrow']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_container.layout_left .df_timeline_content_area .timeline_arrow_icon",
                    'declaration' => "transform: rotate(0deg) !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }

            if ('right' === $this->props['layout_type_mobile'] && "off" === $this->props['reverse_arrow']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_container.layout_right .df_timeline_content_area .timeline_arrow_icon",
                    'declaration' => "transform: rotate(0deg) !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }

            if ('right' === $this->props['layout_type_mobile'] && "on" === $this->props['reverse_arrow']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_container.layout_right .df_timeline_content_area .timeline_arrow_icon",
                    'declaration' => "transform: rotate(180deg) !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }

            if ("on" === $this->props['reverse_arrow'] && 'left' === $this->props['layout_type_mobile']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_container.layout_left .df_timeline_content_area .timeline_arrow_caret",
                    'declaration' => "transform: rotate(180deg) !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            } else if ("on" === $this->props['reverse_arrow'] && 'right' === $this->props['layout_type_mobile']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_container.layout_right .df_timeline_content_area .timeline_arrow_caret",
                    'declaration' => "transform: rotate(0deg) !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }

            // disable content arrow mobile
            if ("on" === $this->props['disable_arrow_mobile']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_content_area .timeline_arrow",
                    'declaration' => "display: none !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }
        }

        // date arrow
        if ("on" === $this->props['enable_date_arrow']) {
            $date_arrow_type = $this->props['date_arrow_type'] ? $this->props['date_arrow_type'] : "arrow_caret";
            $date_arrow_selector = "";
            $date_arrow_selector_rev = "";
            switch ($date_arrow_type) {
                case 'arrow_caret':
                    $date_arrow_selector = "$this->main_css_element .df_timeline_item .df_timeline_date_content .timeline_arrow_caret";
                    $date_arrow_selector_rev = "$this->main_css_element .df_timeline_item.reverse .df_timeline_date_content .timeline_arrow_caret";
                    break;
                case 'arrow_icon':
                    $date_arrow_selector = "$this->main_css_element .df_timeline_item .df_timeline_date_content .timeline_arrow_icon";
                    $date_arrow_selector_rev = "$this->main_css_element .df_timeline_item.reverse .df_timeline_date_content .timeline_arrow_icon";
                    break;
                case 'arrow_line':
                    $date_arrow_selector = "$this->main_css_element .df_timeline_item .df_timeline_date_content .timeline_arrow_line";
                    $date_arrow_selector_rev = "$this->main_css_element .df_timeline_item.reverse .df_timeline_date_content .timeline_arrow_line";
                    break;
            }

            if ("arrow_caret" == $date_arrow_type) {
                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'date_arrow_size',
                    'type'              => 'border-width',
                    'selector'          => $date_arrow_selector,
                    'default'           => '10px',
                ));

                // set border left width 0
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => $date_arrow_selector,
                    'declaration' => "border-left-width: 0px !important;"
                ));

                $this->df_process_color(
                    array(
                        'render_slug'  => $render_slug,
                        'slug'         => 'date_arrow_color',
                        'type'         => 'border-right-color',
                        'selector'     => $date_arrow_selector,
                        'hover'        => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content:hover .timeline_arrow_caret"
                    )
                );
            }

            if ("arrow_icon" == $date_arrow_type) {
                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'date_arrow_size',
                    'type'              => 'font-size',
                    'selector'          => $date_arrow_selector,
                    'default'           => '20px',
                ));

                $this->df_process_color(
                    array(
                        'render_slug'  => $render_slug,
                        'slug'         => 'date_arrow_color',
                        'type'         => 'color',
                        'selector'     => $date_arrow_selector,
                        'hover'        => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content:hover .timeline_arrow_icon"
                    )
                );
            }

            if ("arrow_line" == $date_arrow_type) {
                $this->df_process_string_attr(array(
                    'render_slug' => $render_slug,
                    'slug'        => 'date_arrow_line_type',
                    'type'        => 'border-style',
                    'selector'    => $date_arrow_selector,
                    'important'   => true
                ));

                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'date_arrow_size',
                    'type'              => 'width',
                    'selector'          => $date_arrow_selector,
                    'default'           => '20px',
                ));

                $this->df_process_range(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'date_arrow_thick',
                    'type'              => 'border-top-width',
                    'selector'          => $date_arrow_selector,
                    'default'           => '2px',
                ));

                $this->df_process_color(
                    array(
                        'render_slug'  => $render_slug,
                        'slug'         => 'date_arrow_color',
                        'type'         => 'border-color',
                        'selector'     => $date_arrow_selector,
                        'hover'        => "$this->main_css_element .df_timeline_date_area .df_timeline_date_content:hover .timeline_arrow_line"
                    )
                );
            }

            // Arrow horizontal position
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'date_arrow_horizontal_position',
                'type'              => 'margin-left',
                'selector'          => $date_arrow_selector,
                'default'           => '0px',
                'important'         => false
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'date_arrow_horizontal_position',
                'type'              => 'margin-right',
                'selector'          => $date_arrow_selector_rev,
                'default'           => '0px'
            ));

            // arrow reverse
            if ("on" === $this->props['reverse_date_arrow']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => $date_arrow_selector,
                    'declaration' => "transform: rotate(0deg) !important;"
                ));

                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => $date_arrow_selector_rev,
                    'declaration' => "transform: rotate(180deg) !important;"
                ));
            }

            if ('left' === $this->props['layout_type_mobile'] && "off" === $this->props['reverse_date_arrow']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_container.layout_left .df_timeline_date_area .timeline_arrow_icon",
                    'declaration' => "transform: rotate(180deg) !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }

            if ('left' === $this->props['layout_type_mobile'] && "on" === $this->props['reverse_date_arrow']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_container.layout_left .df_timeline_date_area .timeline_arrow_icon",
                    'declaration' => "transform: rotate(0deg) !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }

            if ('right' === $this->props['layout_type_mobile'] && "off" === $this->props['reverse_date_arrow']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_container.layout_right .df_timeline_date_area .timeline_arrow_icon",
                    'declaration' => "transform: rotate(0deg) !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }

            if ('right' === $this->props['layout_type_mobile'] && "on" === $this->props['reverse_date_arrow']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_container.layout_right .df_timeline_date_area .timeline_arrow_icon",
                    'declaration' => "transform: rotate(180deg) !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }

            if ("on" === $this->props['reverse_date_arrow'] && 'left' === $this->props['layout_type_mobile']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_container.layout_left .df_timeline_date_area .timeline_arrow_caret",
                    'declaration' => "transform: rotate(180deg) !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            } else if ("on" === $this->props['reverse_date_arrow'] && 'right' === $this->props['layout_type_mobile']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_container.layout_right .df_timeline_date_area .timeline_arrow_caret",
                    'declaration' => "transform: rotate(0deg) !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }

            // disable date arrow mobile
            if ("on" === $this->props['disable_date_arrow_mobile']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_date_area .timeline_arrow",
                    'declaration' => "display: none;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }

            if ("on" === $this->props['enable_date_in_blurb']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_date_content .timeline_arrow",
                    'declaration' => "opacity: 0 !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }
        }

        $date_wrapper_margin = $this->df_get_mobile_value('date_wrapper_margin');
        $dateMargin = !empty($date_wrapper_margin) ? explode("|", $date_wrapper_margin) : explode("|", "0px|80px|0px|80px|false|false");

        $defaultMargin = 'on' === $this->props['enable_date_in_blurb'] ? "0px" : "80px";
        $arrow_horizontal_mobile = $this->df_get_mobile_value('arrow_horizontal_position');
        $date_arrow_horizontal_mobile = $this->df_get_mobile_value('date_arrow_horizontal_position');

        $date_horizontal_gap = $defaultMargin;
        if ('left' === $this->props['layout_type_mobile']) {
            $date_horizontal_gap = is_array($dateMargin) ? $dateMargin[3] : $defaultMargin;
        } else {
            $date_horizontal_gap = is_array($dateMargin) ? $dateMargin[1] : $defaultMargin;
        }

        if (empty($date_horizontal_gap)) {
            $date_horizontal_gap = $defaultMargin;
        }

        // date arrow
        $date_arrow_size = $this->df_get_mobile_value('date_arrow_size');
        $date_arrow_size_rev = "on" === $this->props['reverse_date_arrow'] ? str_replace('px', '', $date_arrow_size) : str_replace('px', '', $date_arrow_size) * 2;
        if ('on' !== $this->props['disable_date']) {
            if ('on' !== $this->props['disable_date_mobile']) {
                if ('left' === $this->props['layout_type_mobile']) {
                    $marginLeft = str_replace('px', '', $date_horizontal_gap) - $date_arrow_size_rev . "px";
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "$this->main_css_element .df_timeline_container.layout_left .df_timeline_date_area .timeline_arrow>*",
                        'declaration' => "margin-left: $marginLeft !important; left: calc(0% - $date_arrow_horizontal_mobile) !important;",
                        'media_query' => self::get_media_query('max_width_767')
                    ));

                    $marginLeftArrowDateIcon = $date_horizontal_gap;
                    if ("on" === $this->props['reverse_date_arrow']) {
                        $marginLeftArrowDateIcon = str_replace('px', '', $date_horizontal_gap) - $date_arrow_size_rev . "px";
                    }
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "$this->main_css_element .df_timeline_container.layout_left .df_timeline_date_area .timeline_arrow .timeline_arrow_icon",
                        'declaration' => "margin-left: $marginLeftArrowDateIcon !important; left: calc(0% - $date_arrow_horizontal_mobile) !important;",
                        'media_query' => self::get_media_query('max_width_767')
                    ));

                    $marginLeftLine = str_replace('px', '', $date_horizontal_gap) - str_replace('px', '', $date_arrow_size) . "px";
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "$this->main_css_element .df_timeline_container.layout_left .df_timeline_date_area .timeline_arrow .timeline_arrow_line",
                        'declaration' => "margin-left: $marginLeftLine !important; left: calc(0% - $date_arrow_horizontal_mobile) !important;",
                        'media_query' => self::get_media_query('max_width_767')
                    ));
                } else {
                    $marginLeft = str_replace('px', '', $date_horizontal_gap) . "px";
                    if ("on" === $this->props['reverse_date_arrow']) {
                        $marginLeft = str_replace('px', '', $date_horizontal_gap) + $date_arrow_size_rev . "px";
                    }
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "$this->main_css_element .df_timeline_container.layout_right .df_timeline_date_area .timeline_arrow>*",
                        'declaration' => "margin-left: -$marginLeft !important; left: calc(100% + $date_arrow_horizontal_mobile) !important;",
                        'media_query' => self::get_media_query('max_width_767')
                    ));

                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "$this->main_css_element .df_timeline_container.layout_right .df_timeline_date_area .timeline_arrow .timeline_arrow_icon",
                        'declaration' => "margin-left: -$date_horizontal_gap !important; left: calc(100% + $date_arrow_horizontal_mobile) !important;",
                        'media_query' => self::get_media_query('max_width_767')
                    ));
                }
            }
        }

        // blurb arrow
        $item_wrapper_margin = $this->df_get_mobile_value('item_wrapper_margin');
        $itemMargin = !empty($item_wrapper_margin) ? explode("|", $item_wrapper_margin) : explode("|", "0px|80px|0px|80px|false|false");
        $item_horizontal_gap = $defaultMargin;

        if ('left' === $this->props['layout_type_mobile']) {
            $item_horizontal_gap = is_array($itemMargin) ? $itemMargin[3] : $defaultMargin;
        } else {
            $item_horizontal_gap = is_array($itemMargin) ? $itemMargin[1] : $defaultMargin;
        }

        if (empty($item_horizontal_gap)) {
            $item_horizontal_gap = $defaultMargin;
        }

        $arrow_size = $this->df_get_mobile_value('arrow_size');
        $arrow_size_rev = "on" === $this->props['reverse_arrow'] ? str_replace('px', '', $arrow_size) : str_replace('px', '', $arrow_size) * 2;
        if ('left' === $this->props['layout_type_mobile']) {
            $marginLeftArrow = str_replace('px', '', $item_horizontal_gap) - $arrow_size_rev . "px";
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_container.layout_left .df_timeline_content_area .timeline_arrow>*",
                'declaration' => "margin-left: $marginLeftArrow !important; left: calc(0% - $arrow_horizontal_mobile) !important;",
                'media_query' => self::get_media_query('max_width_767')
            ));

            $marginLeftArrowIcon = $item_horizontal_gap;
            if ("on" === $this->props['reverse_arrow']) {
                $marginLeftArrowIcon = str_replace('px', '', $item_horizontal_gap) - $arrow_size_rev . "px";
            }
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_container.layout_left .df_timeline_content_area .timeline_arrow .timeline_arrow_icon",
                'declaration' => "margin-left: $marginLeftArrowIcon !important; left: calc(0% - $arrow_horizontal_mobile) !important;",
                'media_query' => self::get_media_query('max_width_767')
            ));

            $marginLeftLine = str_replace('px', '', $item_horizontal_gap) - str_replace('px', '', $arrow_size) . "px";
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_container.layout_left .df_timeline_content_area .timeline_arrow .timeline_arrow_line",
                'declaration' => "margin-left: $marginLeftLine !important; left: calc(0% - $arrow_horizontal_mobile) !important;",
                'media_query' => self::get_media_query('max_width_767')
            ));
        } else {
            $marginLeftArrow = str_replace('px', '', $item_horizontal_gap) . "px";
            if ("on" === $this->props['reverse_arrow']) {
                $marginLeftArrow = str_replace('px', '', $item_horizontal_gap) + $arrow_size_rev . "px";
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_container.layout_right .df_timeline_content_area .timeline_arrow>*",
                'declaration' => "margin-left: -$marginLeftArrow !important; left: calc(100% + $arrow_horizontal_mobile) !important;",
                'media_query' => self::get_media_query('max_width_767')
            ));

            if ("on" === $this->props['reverse_arrow'] && "arrow_icon" === $arrow_type) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_timeline_container.layout_right .df_timeline_content_area .timeline_arrow .timeline_arrow_icon",
                    'declaration' => "margin-left: -$item_horizontal_gap !important; left: calc(100% + $arrow_horizontal_mobile) !important;",
                    'media_query' => self::get_media_query('max_width_767')
                ));
            }
        }
        
        // marker side offset
        $layout_type_mobile = $this->props['layout_type_mobile'] ? $this->props['layout_type_mobile'] : 'left';
        $marker_width = $this->df_get_mobile_value('marker_width');

        if ('left' === $layout_type_mobile) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => " $this->main_css_element .df_timeline_container.layout_left .df_timeline_marker",
                'declaration' => "left: 0% !important;",
                'media_query' => self::get_media_query('max_width_767')
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_container.layout_right .df_timeline_marker",
                'declaration' => "left: calc(100% - " . $marker_width . ") !important;",
                'media_query' => self::get_media_query('max_width_767')
            ));
        }

        // line top/bottom marker
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "$this->main_css_element .df_timeline_top",
            'declaration' => "text-align: left"
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "$this->main_css_element .df_timeline_bottom",
            'declaration' => "text-align: left"
        ));

        // Content list position
        if (!empty($this->props['design_content_text_ul_position'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_content .df_timeline_desc ul",
                'declaration' => "list-style-position: " . $this->props['design_content_text_ul_position'] . ";",
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_content .df_timeline_desc ul",
                'declaration' => "list-style-position: outside !important; margin-left: 4px;",
            ));
        }

        if (!empty($this->props['design_content_text_ol_position'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_content .df_timeline_desc ol",
                'declaration' => "list-style-position: " . $this->props['design_content_text_ol_position'] . "; margin-left: 15px;",
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_content .df_timeline_desc ol",
                'declaration' => "list-style-position: outside !important; margin-left: 20px;",
            ));
        }

        // orders
        if ('off' !== $this->props['order_enable']) {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'title_order',
                'type'              => 'order',
                'selector'          => "$this->main_css_element .df_timeline_content_area .df_timeline_title"
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'sub_title_order',
                'type'              => 'order',
                'selector'          => "$this->main_css_element .df_timeline_content_area .df_timeline_subtitle"
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'media_order',
                'type'              => 'order',
                'selector'          => "$this->main_css_element .df_timeline_content_area .df_timeline_media"
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'content_order',
                'type'              => 'order',
                'selector'          => "$this->main_css_element .df_timeline_content_area .df_timeline_desc"
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'button_order',
                'type'              => 'order',
                'selector'          => "$this->main_css_element .df_timeline_content_area .df_timeline_button"
            ));
        }
    }

    public function df_get_unit($string = "80%")
    {
        if (str_contains($string, '%')) {
            return preg_replace('/\d+/', '', $string);
        }

        return "px";
    }

    public function df_tmln_top_bottom_marker( $str = "top")
    {
        $enable_marker = "on" === $this->props["enable_line_" . $str . "_marker"];
        $marker_type = $this->props["line_" . $str . "_marker_type"] ? $this->props["line_" . $str . "_marker_type"] : "icon";
        $marker_icon_html = $enable_marker && "icon" === $marker_type ? sprintf(
            '<span class="et-pb-icon %2$s">%1$s</span>',
            !empty($this->props["line_" . $str . "_icon"]) ? esc_attr(et_pb_process_font_icon($this->props["line_" . $str . "_icon"])) : "&#xe00a;",
            "top" === $str ? "df_timeline_top_icon" : "df_timeline_bottom_icon"
        ) : "";
        $marker_img_html = $enable_marker && "image" === $marker_type && !empty($this->props["line_" . $str . "_image"]) ? $this->df_render_tmln_image($this->props["line_" . $str . "_image"], $this->props["line_" . $str . "_img_alt_txt"]) : "";
        $marker_txt = $enable_marker && "text" === $marker_type && !empty($this->props["line_" . $str . "_txt"]) ? $this->props["line_" . $str . "_txt"] : "Marker Text";

        $marker = "";
        switch ($marker_type) {
            case 'icon':
                $marker = $marker_icon_html;
                break;
            case 'image':
                $marker = $marker_img_html;
                break;
            case 'text':
                $marker = $marker_txt;
                break;
        }

        return $enable_marker && 'custom' === $this->props['line_start_from'] ? sprintf(
            '<div class="%2$s"><div class="df_line_marker">%1$s</div></div>',
            $marker,
            "top" === $str ? "df_timeline_top" : "df_timeline_bottom"
        ) : '';
    }

    public function df_render_tmln_image($img_prop, $img_alt)
    {
        if (isset($img_prop) && '' !== $img_prop) {
            $image_alt = '' !== $img_alt ? $img_alt  : df_image_alt_by_url($img_prop);
            return sprintf(
                '<img src="%1$s" alt="%2$s" />',
                $img_prop,
                $image_alt
            );
        }
    }

    public function df_get_mobile_value($key)
    {
        if (!empty($this->props[$key . "_phone"])) {
            return $this->props[$key . "_phone"];
        }

        if (!empty($this->props[$key . "_tablet"])) {
            return $this->props[$key . "_tablet"];
        }

        if (!empty($this->props[$key])) {
            return $this->props[$key];
        }

        return;
    }

    public function render($attrs, $content, $render_slug)
    {
		$this->handle_fa_icon();
        // Scripts
        wp_enqueue_script('animejs');
        wp_enqueue_script('df_timeline');

        // Css
        $this->additional_css_styles($render_slug);

        $data_settings = [
            'layout_type'               => $this->props['layout_type'] ? $this->props['layout_type'] : "middle",
            'layout_type_mobile'        => $this->props['layout_type_mobile'] ? $this->props['layout_type_mobile'] : "left",
            'enable_item_animation'     => "on" === $this->props['enable_item_animation'] ? $this->props['enable_item_animation'] : "off",
            'tmln_animation'            => $this->props['tmln_animation'] ? $this->props['tmln_animation'] : "fade_in",
            'line_width'                => $this->props['line_width'] ? $this->props['line_width'] : "3px",
            'line_start_from'           => $this->props['line_start_from'] ? $this->props['line_start_from'] : "first_marker",
            'enable_line_top_marker'    => "on" === $this->props['enable_line_top_marker'],
            'line_top_marker_type'      => $this->props['line_top_marker_type'] ? $this->props['line_top_marker_type'] : 'icon',
            'enable_line_bottom_marker' => "on" === $this->props['enable_line_bottom_marker'],
            'line_bottom_marker_type'   => $this->props['line_bottom_marker_type'] ? $this->props['line_bottom_marker_type'] : 'icon',
            'line_top_marker_space'     => $this->props['line_top_marker_vertical_position'] ? $this->props['line_top_marker_vertical_position'] : "0px",
            'line_bottom_marker_space'  => $this->props['line_bottom_marker_vertical_position'] ? $this->props['line_bottom_marker_vertical_position'] : "0px",
            'item_vertical_gap'         => $this->props['item_vertical_gap'] ? $this->props['item_vertical_gap'] : "50",
            'enable_scroll_line'        => "on" === $this->props['enable_scroll_line'] ? $this->props['enable_scroll_line'] : "off",
            'enable_arrow'              => "on" === $this->props['enable_arrow'] ? $this->props['enable_arrow'] : "on",
            'disable_arrow_mobile'      => "on" === $this->props['disable_arrow_mobile'] ? $this->props['disable_arrow_mobile'] : "off",
            'item_vertical_alignment'   => $this->props['item_vertical_alignment'] ? $this->props['item_vertical_alignment'] : "center",
            // 'item_horizontal_alignment' => $this->props['item_horizontal_alignment'] ? $this->props['item_horizontal_alignment'] : "center",
            'arrow_marker_vertical_align' => $this->props['arrow_marker_vertical_align'] ? $this->props['arrow_marker_vertical_align'] : "center",
            'arrow_vertical_align'      => !empty($this->props['arrow_vertical_alignment']) ? $this->props['arrow_vertical_alignment'] : "middle",
            'arrow_vertical_position'   => !empty($this->props['arrow_vertical_position']) ? $this->props['arrow_vertical_position'] : "50%",
            'disable_date'              => "on" === $this->props['disable_date'] ? $this->props['disable_date'] : "off",
            'disable_date_mobile'       => "on" === $this->props['disable_date_mobile'] ? $this->props['disable_date_mobile'] : "off",
            'enable_date_in_blurb'      => "on" === $this->props['enable_date_in_blurb'] ? $this->props['enable_date_in_blurb'] : "off",
            'date_order'                => "on" === $this->props['order_enable'] ? $this->props['date_order'] : "-1",
            'enable_date_arrow'         => "on" === $this->props['enable_date_arrow'] ? $this->props['enable_arrow'] : "off",
            'disable_date_arrow_mobile' => "on" === $this->props['disable_date_arrow_mobile'] ? $this->props['disable_date_arrow_mobile'] : "off",
            'date_arrow_vertical_align' => !empty($this->props['date_arrow_vertical_align']) ? $this->props['date_arrow_vertical_align'] : "middle",
            'date_arrow_vertical_position' => !empty($this->props['date_arrow_vertical_position']) ? $this->props['date_arrow_vertical_position'] : "50%",
            'enable_marker_animation'   => "on" === $this->props['enable_marker_animation'] ? $this->props['enable_marker_animation'] : "off",
            'marker_postion_mobile'     => "on" === $this->props['marker_postion_mobile'] ? $this->props['marker_postion_mobile'] : "off",
            'marker_border_color'       => isset($this->props['border_color_all_marker_wrapper_border']) ? $this->props['border_color_all_marker_wrapper_border'] : "",
            'line_top_border'           => isset($this->props['border_color_all_line_top_border']) ? $this->props['border_color_all_line_top_border'] : "",
            'line_bottom_border'        => isset($this->props['border_color_all_line_bottom_border']) ? $this->props['border_color_all_line_bottom_border'] : "",
        ];

        $output = sprintf(
            '<div class="df_timeline_container" data-settings=\'%1$s\'>
                %3$s
                <div class="df_timeline_items">
                    %2$s
                    <div class="df_timeline_line"></div>
                </div>
                %4$s
            </div>',
            wp_json_encode($data_settings),
            $this->content ? $this->content : "",
            $this->df_tmln_top_bottom_marker("top"),
            $this->df_tmln_top_bottom_marker("bottom")
        );

        return !empty($this->content) ? $output : "<h2 class='df_timeline_notice'>Please <strong>Add New Timeline Item.</strong></h2>";
    }
}

new DIFL_TIMELINE;
