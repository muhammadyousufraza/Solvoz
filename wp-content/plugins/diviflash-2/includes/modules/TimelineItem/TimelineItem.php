<?php

if (file_exists(DIFL_PUBLIC_DIR . 'popup/MobileDetect.php')) {
    require_once(DIFL_PUBLIC_DIR . 'popup/MobileDetect.php');
}

class DIFL_TimelineItem extends ET_Builder_Module
{
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_timelineitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $parent_tmln;

    use DF_UTLS;

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'DiviFlash',
        'author_uri' => '',
    );

    public function init()
    {
        $this->name = esc_html__('Timeline Item', 'divi_flash');
        $this->plural = esc_html__('Timeline Items', 'divi_flash');

        $this->parent_tmln = isset(self::get_parent_modules('page')['difl_timeline']) ? self::get_parent_modules('page')['difl_timeline'] : new stdClass;
        $this->child_title_var = 'title';
        $this->child_title_fallback_var = 'admin_label';

        $this->main_css_element = "%%order_class%%";
        $this->icon_path = DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/rating-box.svg';
    }

    public function get_settings_modal_toggles()
    {
        // All sub toggles
        $content_sub_toggles = [
            'p' => array(
                'name' => 'P',
                'icon' => 'text-left',
            ),
            'a' => array(
                'name' => 'A',
                'icon' => 'text-link',
            ),
            'ul' => array(
                'name' => 'UL',
                'icon' => 'list',
            ),
            'ol' => array(
                'name' => 'OL',
                'icon' => 'numbered-list',
            ),
            'quote' => array(
                'name' => 'QUOTE',
                'icon' => 'text-quote',
            ),
        ];

        return array(
            'general'   => array(
                'toggles'    => array(
                    'content' => esc_html__('Content', 'divi_flash'),
                    'media'  => esc_html__('Media', 'divi_flash'),
                    'button' => esc_html__('Button', 'divi_flash'),
                    'date' => [
                        'title'    => esc_html__('Date', 'divi_flash'),
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
                    'marker' => esc_html__('Marker', 'divi_flash'),
                    'position' => esc_html__('Custom Position', 'divi_flash')
                ),
            ),
            'advanced'      => array(
                'toggles'   => array(
                    'design_item_style' => esc_html__('Blurb Style', 'divi_flash'),
                    'design_title' => esc_html__('Title', 'divi_flash'),
                    'design_subtitle' => esc_html__('Subtitle', 'divi_flash'),
                    'design_media' => esc_html__('Media', 'divi_flash'),
                    'design_content' => esc_html__('Content Style', 'divi_flash'),
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
                    'design_arrow' => esc_html__('Blurb & Date Arrow', 'divi_flash'),
                    'design_marker' => esc_html__('Marker', 'divi_flash'),
                )
            ),
        );
    }

    public function get_fields()
    {
        $admin_label = array(
            'admin_label' => array(
                'label'           => esc_html__('Admin Label', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'admin_label',
                'default_on_front' => 'Timeline Item',
            )
        );

        $content = [
            'title' => array(
                'label'           => esc_html__('Title', 'divi_flash'),
                'description' => esc_html__('Set a title for the blurb', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'content',
                'dynamic_content' => 'text'
            ),
            'title_tag'  => array(
                'label'           => esc_html__('Title Tag', 'divi_flash'),
                'description'     => esc_html__('Define a heading tag for the title.', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'h1'   => esc_html__('H1 tag', 'divi_flash'),
                    'h2'   => esc_html__('H2 tag', 'divi_flash'),
                    'h3'   => esc_html__('H3 tag', 'divi_flash'),
                    'h4'   => esc_html__('H4 tag', 'divi_flash'),
                    'h5'   => esc_html__('H5 tag', 'divi_flash'),
                    'h6'   => esc_html__('H6 tag', 'divi_flash'),
                    'p'    => esc_html__('P tag', 'divi_flash'),
                    'span' => esc_html__('Span tag', 'divi_flash'),
                    'div'  => esc_html__('Div tag', 'divi_flash')
                ),
                'toggle_slug'    => 'design_title',
                'tab_slug'       => 'advanced',
                'default'        => 'h3'
            ),
            'sub_title' => array(
                'label'           => esc_html__('Subtitle', 'divi_flash'),
                'description' => esc_html__('Set a subtitle for the blurb', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'content',
                'dynamic_content' => 'text'
            ),
            'sub_title_tag'  => array(
                'label'           => esc_html__('Subtitle Tag', 'divi_flash'),
                'description'     => esc_html__('Define a heading tag for the subtitle.', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'h1'   => esc_html__('H1 tag', 'divi_flash'),
                    'h2'   => esc_html__('H2 tag', 'divi_flash'),
                    'h3'   => esc_html__('H3 tag', 'divi_flash'),
                    'h4'   => esc_html__('H4 tag', 'divi_flash'),
                    'h5'   => esc_html__('H5 tag', 'divi_flash'),
                    'h6'   => esc_html__('H6 tag', 'divi_flash'),
                    'p'    => esc_html__('P tag', 'divi_flash'),
                    'span' => esc_html__('Span tag', 'divi_flash'),
                    'div'  => esc_html__('Div tag', 'divi_flash')
                ),
                'toggle_slug'    => 'design_subtitle',
                'tab_slug'       => 'advanced',
                'default'        => 'h4'
            ),
            'content' => array(
                'label'           => esc_html__('Content', 'divi_flash'),
                'description' => esc_html__('Input the main text content for blurb here.', 'divi_flash'),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'content',
                'dynamic_content' => 'text'
            )
        ];

        $media = [
            'enable_content_media' => array(
                'label'           => esc_html__('Enable Media', 'divi_flash'),
                'description' => esc_html__('Here you can enable media for blurb.', 'divi_flash'),
                'type'            => 'yes_no_button',
                'default'         => 'on',
                'options'         => array(
                    'on'  => esc_html__('On', 'divi_flash'),
                    'off' => esc_html__('Off', 'divi_flash')
                ),
                'toggle_slug' => 'media',
            ),
            'content_media_type' => array(
                'label'       => esc_html__('Media Type', 'divi_flash'),
                'description' => esc_html__('Here you can choose media for blurb.', 'divi_flash'),
                'type'        => 'select',
                'default'     => 'image',
                'options'     => array(
                    'image'   => esc_html__('Image', 'divi_flash'),
                    'icon'    => esc_html__('Icon', 'divi_flash')
                ),
                'option_category' => 'basic_option',
                'toggle_slug'    => 'media',
                'show_if'        => array(
                    'enable_content_media' => 'on'
                ),
            ),
            'content_icon'                 => array(
                'label'                 => esc_html__('Icon', 'divi_flash'),
                'description' => esc_html__('Choose an icon to display with your blurb.', 'divi_flash'),
                'type'                  => 'select_icon',
                'default'               => '&#xe00a;||divi||400',
                'option_category'       => 'basic_option',
                'class'                 => array('et-pb-font-icon'),
                'toggle_slug'           => 'media',
                'show_if'           => array(
                    'enable_content_media' => 'on',
                    'content_media_type' => 'icon'
                ),
            ),
            'content_icon_color' => array(
                'label'         => esc_html__('Icon Color', 'divi_flash'),
                'description'   => esc_html__('Here you can define a color for blurb icon.', 'divi_flash'),
                'type'          => 'color-alpha',
                'default'       => '#666',
                'toggle_slug'   => 'design_media',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs',
                'show_if'       => array(
                    'enable_content_media' => 'on',
                    'content_media_type' => 'icon'
                ),
            ),
            'content_icon_size' => array(
                'label'         => esc_html__('Icon Size', 'divi_flash'),
                'description'   => esc_html__('Here you can control icon size.', 'divi_flash'),
                'type'          => 'range',
                'toggle_slug'   => 'design_media',
                'tab_slug'      => 'advanced',
                'default'       => '30px',
                'allowed_units' => array('px'),
                'range_settings' => array(
                    'min'  => '1',
                    'min_limit' => '1',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'      => true,
                'mobile_options'  => true,
                'show_if'           => array(
                    'enable_content_media' => 'on',
                    'content_media_type' => 'icon'
                ),
            ),
            'content_icon_alignment'    => array(
                'label'           => esc_html__('Icon Alignment', 'divi_flash'),
                'description'   => esc_html__('Align icon to the left, right, or center.', 'divi_flash'),
                'type'            => 'text_align',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'default'         => 'left',
                'toggle_slug'   => 'design_media',
                'tab_slug'      => 'advanced',
                'mobile_options'  => true,
                'show_if'         => array(
                    'enable_content_media' => 'on',
                    'content_media_type' => 'icon'
                ),
            ),
            'content_image' => array(
                'label'              => esc_html__('Image', 'divi_flash'),
                'description'   => esc_html__('Upload an image.', 'divi_flash'),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'        => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'        => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'        => 'media',
                'show_if' => array(
                    'enable_content_media' => 'on',
                    'content_media_type' => 'image'
                ),
                'dynamic_content'    => 'image'
            ),
            'content_image_alt_text' => array(
                'label'             => esc_html__('Alt Text', 'divi_flash'),
                'description'       => esc_html__('Here you can set alternative text for image.', 'divi_flash'),
                'type'              => 'text',
                'default'           => '',
                'toggle_slug'       => 'media',
                'show_if' => array(
                    'enable_content_media' => 'on',
                    'content_media_type' => 'image'
                )
            ),
            'content_image_width' => array(
                'label'         => esc_html__('Image Width', 'divi_flash'),
                'description'   => esc_html__('Here you can control the image width.', 'divi_flash'),
                'type'          => 'range',
                'range_settings' => array(
                    'step'      => '1',
                    'min'       => '1',
                    'min_limit' => '1',
                    'max'       => '100',
                    'max_limit' => '100'
                ),
                'validate_unit' => true,
                'allowed_units' => array('%', 'em', 'px'),
                'default_unit'  => '%',
                'default'       => '100%',
                'toggle_slug'   => 'design_media',
                'tab_slug'      => 'advanced',
                'show_if'       => array(
                    'enable_content_media' => 'on',
                    'content_media_type' => 'image'
                ),
                'mobile_options'    => true
            ),
            'content_image_alignment'   => array(
                'label'         => esc_html__('Image Alignment', 'divi_flash'),
                'description'   => esc_html__('Align image to the left, right, or center.', 'divi_flash'),
                'type'          => 'text_align',
                'option_category' => 'configuration',
                'options'       => et_builder_get_text_orientation_options(
                    array('justified')
                ),
                'default'       => 'left',
                'options_icon'  => 'module_align',
                'mobile_options' => true,
                'toggle_slug'   => 'design_media',
                'tab_slug'      => 'advanced',
                'show_if'       => array(
                    'enable_content_media' => 'on',
                    'content_media_type' => 'image'
                ),
            ),
            'content_image_full_width_mobile' => array( // delete this props
                'label'         => esc_html__('Content Full Width On Mobile', 'divi_flash'),
                'description'   => esc_html__('Set ', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'       => 'off',
                'toggle_slug'   => 'design_media',
                'tab_slug'      => 'advanced',
                'show_if'       => array(
                    'content_media_type' => 'image',
                )
            ),
        ];

        $button = [
            'enable_content_button' => array(
                'label'            => esc_html__('Enable Button', 'divi_flash'),
                'description'   => esc_html__('Enable button for the blurb.', 'divi_flash'),
                'type'             => 'yes_no_button',
                'default'          => 'off',
                'options'          => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'toggle_slug'      => 'button'
            ),
            'button_text' => array(
                'label'           => esc_html__('Button Text', 'divi_flash'),
                'description'   => esc_html__('Set button text.', 'divi_flash'),
                'type'            => 'text',
                'default'         => esc_html__('Button', 'divi_flash'),
                'dynamic_content' => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'button',
                'show_if'         => array(
                    'enable_content_button' => 'on'
                )
            ),
            'button_url' => array(
                'label'           => esc_html__('Button URL', 'divi_flash'),
                'description'   => esc_html__('Set button url.', 'divi_flash'),
                'type'            => 'text',
                'default'         => '#',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'button',
                'show_if'         => array(
                    'enable_content_button' => 'on'
                )
            ),
            'button_url_new_window' => array(
                'label'             => esc_html__('Button Link Target', 'divi_flash'),
                'description'       => esc_html__('Choose whether your link opens in a new window or not', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'off' => esc_html__('In The Same Window', 'divi_flash'),
                    'on'  => esc_html__('In The New Tab', 'divi_flash')
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'button',
                'show_if'         => array(
                    'enable_content_button' => 'on'
                )
            ),
            'button_full_width'   => array(
                'label'           => esc_html__('Button Full Width', 'divi_flash'),
                'description'   => esc_html__('Here you can set full width for the button.', 'divi_flash'),
                'type'            => 'yes_no_button',
                'options'         => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'         => 'off',
                'toggle_slug'     => 'design_button',
                'tab_slug'        => 'advanced',
                'show_if'         => array(
                    'enable_content_button' => 'on',
                )
            ),
            'button_alignment'    => array(
                'label'           => esc_html__('Button Alignment', 'divi_flash'),
                'description'   => esc_html__('Align button to the left, right, or center.', 'divi_flash'),
                'type'            => 'text_align',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'     => 'design_button',
                'tab_slug'        => 'advanced',
                'mobile_options'  => true,
                'show_if'         => array(
                    'enable_content_button' => 'on'
                ),
                'show_if_not'         => array(
                    'button_full_width'    => 'on'
                ),
            ),
            'use_button_icon' => array(
                'label'       => esc_html__('Use Button Icon', 'divi_flash'),
                'description' => esc_html__('Here you can choose whether icon set below should be used.', 'divi_flash'),
                'type'        => 'yes_no_button',
                'options'     => array(
                    'off' => esc_html__('No', 'divi_flash'),
                    'on'  => esc_html__('Yes', 'divi_flash')
                ),
                'affects'               => array(
                    'button_font_icon',
                    'button_icon_size',
                    'button_icon_color',
                    'button_icon_placement'
                ),
                'default'     => 'off',
                'toggle_slug' => 'button',
                'show_if' => array(
                    'enable_content_button' => 'on'
                )
            ),
            'button_font_icon' => array(
                'label'           => esc_html__('Icon', 'divi_flash'),
                'description'   => esc_html__('Here you can choose an icon alongside with the button text.', 'divi_flash'),
                'type'            => 'select_icon',
                'class'           => array('et-pb-font-icon'),
                'default'         => '5',
                'toggle_slug'     => 'button',
                'depends_show_if' => 'on'
            ),
            'button_icon_placement' => array(
                'label'           => esc_html__('Icon Placement', 'divi_flash'),
                'description'   => esc_html__('Place the button icon to the left or right.', 'divi_flash'),
                'type'            => 'select',
                'default'         => 'right',
                'options'         => array(
                    'left'        => esc_html__('Left', 'divi_flash'),
                    'right'       => esc_html__('Right', 'divi_flash')
                ),
                'toggle_slug'     => 'button',
                'show_if'         => array(
                    'enable_content_button' => 'on',
                    'use_button_icon' => 'on'
                )
            ),
            'button_icon_color' => array(
                'label'         => esc_html__('Icon Color', 'divi_flash'),
                'type'          => 'color-alpha',
                'description'   => esc_html__('Here you can define a color for button icon.', 'divi_flash'),
                'toggle_slug'   => 'design_button',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs',
                'show_if'         => array(
                    'enable_content_button' => 'on',
                    'use_button_icon' => 'on'
                )
            ),
            'button_icon_size' => array(
                'label'           => esc_html__('Icon Size', 'divi_flash'),
                'description'   => esc_html__('Here you can define a size for button icon.', 'divi_flash'),
                'type'            => 'range',
                'toggle_slug'     => 'design_button',
                'tab_slug'        => 'advanced',
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
                    'enable_content_button' => 'on',
                    'use_button_icon' => 'on'
                )
            ),
            'button_icon_space'  => array(
                'label'         => esc_html__('Icon Space', 'divi_flash'),
                'description'   => esc_html__('Here you can control the space between button text and icon.', 'divi_flash'),
                'type'          => 'range',
                'toggle_slug'   => 'design_button',
                'tab_slug'      => 'advanced',
                'allowed_units' => array('px'),
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit'  => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'show_if'  => array(
                    'enable_content_button' => 'on',
                    'use_button_icon' => 'on'
                ),
                'responsive'    => true,
                'mobile_options' => true
            )
        ];

        $date = [
            'date_title' => array(
                'label'           => esc_html__('Title', 'divi_flash'),
                'description' => esc_html__('Set a title for the date', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'date',
                'sub_toggle'      => 'title',
                'dynamic_content' => 'text'
            ),
            'date_title_tag'  => array(
                'label'           => esc_html__('Title Tag', 'divi_flash'),
                'description'     => esc_html__('Define a heading tag for the title.', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'h1'   => esc_html__('H1 tag', 'divi_flash'),
                    'h2'   => esc_html__('H2 tag', 'divi_flash'),
                    'h3'   => esc_html__('H3 tag', 'divi_flash'),
                    'h4'   => esc_html__('H4 tag', 'divi_flash'),
                    'h5'   => esc_html__('H5 tag', 'divi_flash'),
                    'h6'   => esc_html__('H6 tag', 'divi_flash'),
                    'p'    => esc_html__('P tag', 'divi_flash'),
                    'span' => esc_html__('Span tag', 'divi_flash'),
                    'div'  => esc_html__('Div tag', 'divi_flash')
                ),
                'toggle_slug'     => 'date',
                'sub_toggle'      => 'title',
                'default'         => 'h3'
            ),
            'date_sub_title' => array(
                'label'           => esc_html__('Subtitle', 'divi_flash'),
                'description' => esc_html__('Set a subtitle for the date', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'date',
                'sub_toggle'      => 'subtitle',
                'dynamic_content' => 'text'
            ),
            'date_sub_title_tag'  => array(
                'label'           => esc_html__('Subtitle Tag', 'divi_flash'),
                'description'     => esc_html__('Define a heading tag for the subtitle.', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'h1'   => esc_html__('H1 tag', 'divi_flash'),
                    'h2'   => esc_html__('H2 tag', 'divi_flash'),
                    'h3'   => esc_html__('H3 tag', 'divi_flash'),
                    'h4'   => esc_html__('H4 tag', 'divi_flash'),
                    'h5'   => esc_html__('H5 tag', 'divi_flash'),
                    'h6'   => esc_html__('H6 tag', 'divi_flash'),
                    'p'    => esc_html__('P tag', 'divi_flash'),
                    'span' => esc_html__('Span tag', 'divi_flash'),
                    'div'  => esc_html__('Div tag', 'divi_flash')
                ),
                'toggle_slug'     => 'date',
                'sub_toggle'      => 'subtitle',
                'default'         => 'h4'
            )
        ];

        $arrow = [
            'arrow_color' => array(
                'label'         => esc_html__('Blurb Arrow Color', 'divi_flash'),
                'description'   => esc_html__('Here you can define a custom color for blurb arrow.', 'divi_flash'),
                'type'          => 'color-alpha',
                'toggle_slug'   => 'design_arrow',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs'
            ),
            'date_arrow_color' => array(
                'label'        => esc_html__('Date Arrow Color', 'divi_flash'),
                'description'  => esc_html__('Here you can define a custom color for date arrow.', 'divi_flash'),
                'type'         => 'color-alpha',
                'toggle_slug'  => 'design_arrow',
                'tab_slug'     => 'advanced',
                'hover'        => 'tabs'
            ),
        ];

        $marker = [
            'marker_type'   => array(
                'label'             => esc_html__('Marker Type', 'divi_flash'),
                'description'    => esc_html__('Chose marker type.', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'icon'         => esc_html__('Icon', 'divi_flash'),
                    'text'         => esc_html__('Text', 'divi_flash'),
                    'image'         => esc_html__('Image', 'divi_flash'),
                    'blank'         => esc_html__('Blank', 'divi_flash'),
                ),
                'default'           => 'icon',
                'toggle_slug'       => 'marker',
            ),
            'marker_img' => array(
                'label'                 => esc_html__('Image', 'divi_flash'),
                'description'    => esc_html__('Upload an image.', 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'upload_button_text'    => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'marker',
                'show_if'         => array(
                    'marker_type' => 'image'
                )
            ),
            'marker_img_alt_txt' => array(
                'label'                 => esc_html__('Image Alt Text', 'divi_flash'),
                'description'    => esc_html__('Alternative text for marker image.', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'marker',
                'show_if'         => array(
                    'marker_type' => 'image'
                )
            ),
            'marker_img_width' => array(
                'label'             => esc_html__('Image Width', 'divi_flash'),
                'description'    => esc_html__('Set the marker image width.', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'marker',
                'default'           => '100%',
                'default_unit'      => '%',
                'allowed_units'     => array('%', 'px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'marker_type' => 'image'
                )
            ),
            'marker_icon'               => array(
                'label'                 => esc_html__('Icon', 'divi_flash'),
                'description'           => esc_html__('Select marker icon.', 'divi_flash'),
                'type'                  => 'select_icon',
                'option_category'       => 'basic_option',
                'class'                 => array('et-pb-font-icon'),
                'toggle_slug'           => 'marker',
                'show_if' => array(
                    'marker_type' => 'icon'
                )
            ),
            'marker_icon_color' => array(
                'label'         => esc_html__('Icon Color', 'divi_flash'),
                'type'          => 'color-alpha',
                'description'   => esc_html__('Here you can define a color for marker icon.', 'divi_flash'),
                'toggle_slug'   => 'design_marker',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs',
                'show_if'       => array(
                    'marker_type' => 'icon'
                )
            ),
            'marker_icon_size' => array(
                'label'           => esc_html__('Icon Size', 'divi_flash'),
                'description'    => esc_html__('Control marker icon size.', 'divi_flash'),
                'type'            => 'range',
                'toggle_slug'     => 'design_marker',
                'tab_slug'        => 'advanced',
                'allowed_units'   => array('px'),
                'range_settings'  => array(
                    'min'  => '0',
                    'min_limit'   => '0',
                    'step' => '1'
                ),
                'responsive'      => true,
                'mobile_options'  => true,
                'show_if'         => array(
                    'marker_type' => 'icon'
                )
            ),
            'enable_marker_icon_mobile' => array(
                'label'           => esc_html__('Mobile Marker Icon', 'divi_flash'),
                'description'    => esc_html__('Activate this option to enable marker on mobile.', 'divi_flash'),
                'type'            => 'yes_no_button',
                'default'         => 'off',
                'options'         => array(
                    'on'  => esc_html__('On', 'divi_flash'),
                    'off' => esc_html__('Off', 'divi_flash')
                ),
                'toggle_slug' => 'marker',
                'show_if'         => array(
                    'marker_type' => 'icon'
                )
            ),
            'mobile_marker_icon'                 => array(
                'label'                 => esc_html__('Icon', 'divi_flash'),
                'description'    => esc_html__('Select marker icon.', 'divi_flash'),
                'type'                  => 'select_icon',
                'option_category'       => 'basic_option',
                'class'                 => array('et-pb-font-icon'),
                'toggle_slug'           => 'marker',
                'show_if'           => array(
                    'enable_marker_icon_mobile' => 'on',
                    'marker_type' => 'icon'
                )
            ),
            'mobile_marker_icon_color' => array(
                'label'         => esc_html__('Mobile Icon Color', 'divi_flash'),
                'description'   => esc_html__('Here you can define a color for marker icon.', 'divi_flash'),
                'type'          => 'color-alpha',
                'toggle_slug'   => 'design_marker',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs',
                'show_if'           => array(
                    'enable_marker_icon_mobile' => 'on',
                    'marker_type' => 'icon'
                )
            ),
            'mobile_marker_icon_size' => array(
                'label'           => esc_html__('Mobile Icon Size', 'divi_flash'),
                'description'   => esc_html__('Set the marker icon size.', 'divi_flash'),
                'type'            => 'range',
                'toggle_slug'     => 'design_marker',
                'tab_slug'        => 'advanced',
                'allowed_units'   => array('px'),
                'range_settings'  => array(
                    'min'  => '0',
                    'min_limit'   => '0',
                    'step' => '1'
                ),
                'responsive'      => true,
                'mobile_options'  => true,
                'show_if'           => array(
                    'enable_marker_icon_mobile' => 'on',
                    'marker_type' => 'icon'
                )
            ),
            'marker_txt' => array(
                'label'                 => esc_html__('Marker Text', 'divi_flash'),
                'description'   => esc_html__('Set the marker text.', 'divi_flash'),
                'type'                  => 'text',
                'toggle_slug'           => 'marker',
                'show_if'         => array(
                    'marker_type' => 'text'
                )
            )
        ];

        $custom_position = [
            'item_vartical_position'   => array(
                'label'         => esc_html__('Blurb Vertical position', 'divi_flash'),
                'description'   => esc_html__('Here you can define a custom vertical position of blurb. This postion will work from top of the container.', 'divi_flash'),
                'type'          => 'range',
                'allowed_units' => array('px', '%'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'step' => '1'
                ),
                'toggle_slug'   => 'position',
                'mobile_options' => true,
                'responsive'     => true,
            ),
            'date_vartical_position'   => array(
                'label'         => esc_html__('Date Vertical position', 'divi_flash'),
                'description'   => esc_html__('Here you can define a custom vertical position of date. This postion will work from top of the container.', 'divi_flash'),
                'type'          => 'range',
                'allowed_units' => array('px', '%'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'step' => '1'
                ),
                'toggle_slug'   => 'position',
                'mobile_options' => true,
                'responsive'     => true,
            ),
            'child_arrow_vertical_position' => array(
                'label'         => esc_html__('Blurb Arrow Vertical Position', 'divi_flash'),
                'description'   => esc_html__('Here you can define a custom vertical position of blurb arrow. This postion will work from top of the container.', 'divi_flash'),
                'type'          => 'range',
                'allowed_units' => array('%', 'px'),
                'default_unit'  => '%',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'step' => '1'
                ),
                'toggle_slug'   => 'position',
            ),
            'child_date_arrow_vertical_position' => array(
                'label'         => esc_html__('Date Arrow Vertical Position', 'divi_flash'),
                'description'   => esc_html__('Here you can define a custom vertical position of date arrow. This postion will work from top of the container.', 'divi_flash'),
                'type'          => 'range',
                'allowed_units' => array('%', 'px'),
                'default_unit'  => '%',
                'range_settings' => array(
                    'min'  => '0',
                    'min_limit' => '0',
                    'step' => '1'
                ),
                'toggle_slug'   => 'position',
            ),
            'marker_vertical_position' => array(
                'label'         => esc_html__('Marker Vertical Position', 'divi_flash'),
                'description'   => esc_html__('Here you can define a custom vertical position of marker. This postion will work from top of the container.', 'divi_flash'),
                'type'          => 'range',
                'allowed_units' => array('px', '%'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'step' => '1'
                ),
                'toggle_slug'   => 'position',
                'responsive'    => true,
                'desktop_options' => true,
                'tablet_options' => true,
                'mobile_options' => false,
            ),
        ];

        // Background
        $item_wrapper_bg = $this->df_add_bg_field(
            array(
                'label'        => 'Background',
                'key'          => 'item_wrapper_bg',
                'toggle_slug'  => 'design_item_style',
                'tab_slug'     => 'advanced'
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
                'tab_slug'    => 'advanced',
                'show_if'     => array(
                    'enable_content_button' => 'on'
                )
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

        $date_wrapper_bg = $this->df_add_bg_field(
            array(
                'label'        => 'Background',
                'key'          => 'date_wrapper_bg',
                'toggle_slug'  => 'design_date_wrapper',
                'tab_slug'     => 'advanced'
            )
        );

        $item_wrapper_margin = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'item_wrapper',
            'toggle_slug'   => 'design_item_style',
            'option'        => 'padding',
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
            'show_if'       => array(
                'enable_content_button' => 'on'
            )
        ));

        $date_wrapper_margin = $this->add_margin_padding(array(
            'title'         => '',
            'key'           => 'date_wrapper',
            'toggle_slug'   => 'design_date_wrapper',
            'option'        => 'padding',
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

        return array_merge(
            $admin_label,
            $title_bg,
            $subtitle_bg,
            $content_media_bg,
            $content,
            $media,
            $button_bg,
            $button,
            $button_margin,
            $marker,
            $marker_bg,
            $arrow,
            $date,
            $item_wrapper_bg,
            $custom_position,
            $content_text_bg,
            $date_wrapper_bg,
            $title_margin,
            $subtitle_margin,
            $item_wrapper_margin,
            $media_item_margin,
            $content_margin,
            $date_wrapper_margin,
            $date_title_margin,
            $date_subtitle_margin
        );
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields['text'] = false;
        $advanced_fields['margin_padding'] = false;
        $advanced_fields['max_width'] = false;
        $advanced_fields['transform'] = false;
        $advanced_fields['filters'] = false;

        $advanced_fields['fonts'] = [
            'title' => array(
                'toggle_slug' => 'design_title',
                'tab_slug'    => 'advanced',
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'font_size'   => array(
                    'default' => '24px',
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_title",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_title",
                    'important' => 'all'
                )
            ),
            'subtitle' => array(
                'toggle_slug' => 'design_subtitle',
                'tab_slug'    => 'advanced',
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'font_size'   => array(
                    'default' => '18px',
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_subtitle",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_subtitle",
                    'important' => 'all'
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
                'font-weight' => array(
                    'default' => 'normal'
                ),
                'css'       => array(
                    'main'  => ".difl_timeline $this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc, $this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc p",
                    'hover' => ".difl_timeline $this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_desc, $this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_desc p",
                    'important' => 'all'
                ),
                'block_elements' => array(
                    'tabbed_subtoggles' => true,
                    'bb_icons_support'  => true,
                    'css'  => array(
                        'main'  => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc:not(blockquote p) p",
                        'hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_desc p",
                        'a'     => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc a",
                        'ul'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc ul",
                        'ol'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc ol",
                        'quote' => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc blockquote, $this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc blockquote p"
                    )
                )
            ),
            'content_button'   => array(
                'toggle_slug'  => 'design_button',
                'tab_slug'     => 'advanced',
                'font'  => array(
                    'show_if' => array(
                        'enable_content_button' => 'on'
                    )
                ),
                'font_weight'  => array(
                    'default'  => 'normal',
                    'show_if' => array(
                        'enable_content_button' => 'on'
                    )
                ),
                'text_align'  => array(
                    'show_if' => array(
                        'enable_content_button' => 'on'
                    )
                ),
                'text_color' => array(
                    'show_if' => array(
                        'enable_content_button' => 'on'
                    )
                ),
                'font_size'    => array(
                    'default'  => '18px',
                    'show_if' => array(
                        'enable_content_button' => 'on'
                    )
                ),
                'letter_spacing' => array(
                    'show_if' => array(
                        'enable_content_button' => 'on'
                    )
                ),
                'line_height'  => array(
                    'default'  => '1.7em',
                    'show_if' => array(
                        'enable_content_button' => 'on'
                    )
                ),
                'text_shadow' => array(
                    'show_if' => array(
                        'enable_content_button' => 'on'
                    )
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_button a",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_button a:hover",
                    'important' => 'all'
                )
            ),
            'marker_txt'   => array(
                'toggle_slug'  => 'design_marker',
                'tab_slug'     => 'advanced',
                'font'  => array(
                    'show_if' => array(
                        'marker_type' => 'text'
                    )
                ),
                'font_weight'  => array(
                    'default'  => 'normal',
                    'show_if' => array(
                        'marker_type' => 'text'
                    )
                ),
                'text_align'  => array(
                    'show_if' => array(
                        'marker_type' => 'text'
                    )
                ),
                'text_color' => array(
                    'show_if' => array(
                        'marker_type' => 'text'
                    )
                ),
                'font_size'    => array(
                    'default'  => '18px',
                    'show_if' => array(
                        'marker_type' => 'text'
                    )
                ),
                'letter_spacing' => array(
                    'show_if' => array(
                        'marker_type' => 'text'
                    )
                ),
                'line_height'  => array(
                    'default'  => '1.7em',
                    'show_if' => array(
                        'marker_type' => 'text'
                    )
                ),
                'text_shadow' => array(
                    'show_if' => array(
                        'marker_type' => 'text'
                    )
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_marker",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_marker:hover",
                    'important' => 'all'
                )
            ),
            'date_title' => array(
                'toggle_slug' => 'design_date_text',
                'sub_toggle'  => 'title',
                'tab_slug'    => 'advanced',
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'font_size'   => array(
                    'default' => '22px',
                ),
                'text_color'   => array(
                    'default' => '#333',
                ),
                'text_align'   => array(
                    'default' => 'left',
                ),
                'font-weight' => array(
                    'default' => '500'
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content .df_timeline_date_title",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content:hover .df_timeline_date_title",
                    'important' => 'all'
                )
            ),
            'date_subtitle' => array(
                'toggle_slug' => 'design_date_text',
                'sub_toggle'  => 'subtitle',
                'tab_slug'    => 'advanced',
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'text_color'   => array(
                    'default' => '#333',
                ),
                'text_align'   => array(
                    'default' => 'left',
                ),
                'font-weight' => array(
                    'default' => '500'
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content .df_timeline_date_subtitle",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content:hover .df_timeline_date_subtitle",
                    'important' => 'all'
                )
            )
        ];

        // Arrow
        $advanced_fields['borders'] = array(
            'default'     => false,

            'item_wrapper_border' => array(
                'css'      => array(
                    'main' => array(
                        'border_radii'       => ".difl_timeline $this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_content",
                        'border_radii_hover' => ".difl_timeline $this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_content",
                        'border_styles'      => ".difl_timeline $this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_content",
                        'border_styles_hover' => ".difl_timeline $this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_content",
                    ),
                    'important' => 'all'
                ),
                'toggle_slug'    => 'design_item_style',
                'tab_slug'       => 'advanced'
            ),

            'title_border' => array(
                'css'      => array(
                    'main' => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_title",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_title",
                        'border_styles'      => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_title",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_title",
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
                        'border_radii'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_subtitle",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_subtitle",
                        'border_styles'      => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_subtitle",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_subtitle",
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
                        'border_radii'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_desc",
                        'border_styles'      => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_desc",
                    ),
                    // 'important' => 'all'
                ),
                'toggle_slug'     => 'design_content',
                'tab_slug'        => 'advanced',
            ),
            'content_media_border' => array(
                'css' => array(
                    'main'  => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_media>*",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_media>*",
                        'border_styles'      => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_media>*",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_media>*",
                    ),
                ),
                'toggle_slug'     => 'design_media',
                'tab_slug'        => 'advanced',
            ),
            'content_button_border' => array(
                'css' => array(
                    'main'  => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_item .df_timeline_button a",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_item .df_timeline_button a:hover",
                        'border_styles'      => "$this->main_css_element .df_timeline_item .df_timeline_button a",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_item .df_timeline_button a:hover",
                    )
                ),
                'toggle_slug'     => 'design_button',
                'tab_slug'        => 'advanced',
                'depends_on'      => array('enable_content_button'),
                'depends_show_if' => 'on'
            ),

            'marker_wrapper_border' => array(
                'css'      => array(
                    'main' => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_item .df_timeline_marker",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_item .df_timeline_marker:hover",
                        'border_styles'      => "$this->main_css_element .df_timeline_item .df_timeline_marker",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_item .df_timeline_marker:hover",
                    ),
                ),
                'toggle_slug'    => 'design_marker',
                'tab_slug'       => 'advanced'
            ),
            'date_wrapper_border' => array(
                'css'      => array(
                    'main' => array(
                        'border_radii'       => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content",
                        'border_radii_hover' => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content:hover",
                        'border_styles'      => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content",
                        'border_styles_hover' => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content:hover",
                    )
                ),
                'toggle_slug'    => 'design_date_wrapper',
                'tab_slug'       => 'advanced'

            )
        );

        $advanced_fields['box_shadow'] = array(
            'default'       => false,

            'item_wrapper_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_content",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_content",
                ),
                'toggle_slug' => 'design_item_style',
                'tab_slug'    => 'advanced',
            ),
            'title_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_title",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_title",
                ),
                'toggle_slug' => 'design_title',
                'tab_slug'    => 'advanced',
            ),
            'subtitle_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_subtitle",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_subtitle",
                ),
                'toggle_slug' => 'design_subtitle',
                'tab_slug'    => 'advanced',
            ),
            'content_text_wrapper_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_desc",
                ),
                'toggle_slug' => 'design_content',
                'tab_slug'    => 'advanced',
            ),
            'content_media_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_media>*",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_media>*",
                ),
                'toggle_slug' => 'design_media',
                'tab_slug'    => 'advanced',
            ),
            'content_button_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_button a",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_button a:hover",
                ),
                'toggle_slug' => 'design_button',
                'tab_slug'    => 'advanced',
                'depends_on'      => array('enable_content_button'),
                'depends_show_if' => 'on'
            ),
            'marker_wrapper_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_marker",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_marker:hover",
                ),
                'toggle_slug' => 'design_marker',
                'tab_slug'    => 'advanced',
            ),
            'date_wrapper_box_shadow' => array(
                'css' => array(
                    'main'  => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content",
                    'hover' => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content:hover",
                ),
                'toggle_slug' => 'design_date_wrapper',
                'tab_slug'    => 'advanced',
            )
        );

        return $advanced_fields;
    }

    public function get_transition_fields_css_props()
    {
        $fields = parent::get_transition_fields_css_props();
        $item_wrapper = "$this->main_css_element .df_timeline_item .df_timeline_content_area";
        $arrow_caret = "$item_wrapper .timeline_arrow_caret";
        $arrow_icon = "$item_wrapper .timeline_arrow_icon";
        $arrow_line = "$item_wrapper .timeline_arrow_line";
        $date_wrapper = "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content";
        $date_arrow_caret = "$date_wrapper .timeline_arrow_caret";
        $date_arrow_icon = "$date_wrapper .timeline_arrow_icon";
        $date_arrow_line = "$date_wrapper .timeline_arrow_line";
        $content_area = "$item_wrapper .df_timeline_content";
        $title_wrapper = "$item_wrapper .df_timeline_title";
        $subtitle_wrapper = "$item_wrapper .df_timeline_subtitle";
        $content_text_wrapper = "$item_wrapper .df_timeline_desc";
        $content_media = "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_media";
        $date_wrapper = "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content";
        $button = "$this->main_css_element  .df_timeline_button a";
        $button_icon = "$button .df_timeline_btn_icon";
        $marker = "$this->main_css_element .df_timeline_item .df_timeline_marker";

        // Color
        $fields['button_icon_color'] = array('color' => $button_icon);
        $fields['marker_icon_color'] = array('color' => "$marker .df_timeline_marker_icon");
        $fields['mobile_marker_icon_color'] = array('color' => "$marker .df_timeline_marker_icon.marker_mobile");

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
                'key'      => 'marker_bg',
                'selector' => $marker
            )
        );

        $fields = $this->df_background_transition(
            array(
                'fields'   => $fields,
                'key'      => 'date_wrapper_bg',
                'selector' => $date_wrapper
            )
        );

        // Color
        if (isset($this->parent_tmln->props['arrow_type'])) {
            switch ($this->parent_tmln->props['arrow_type']) {
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

        if (isset($this->parent_tmln->props['date_arrow_type'])) {
            switch ($this->parent_tmln->props['date_arrow_type']) {
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

        // Border
        $fields = $this->df_fix_border_transition($fields, 'item_wrapper_border', $content_area);
        $fields = $this->df_fix_border_transition($fields, 'content_text_wrapper_border', $content_text_wrapper);
        $fields = $this->df_fix_border_transition($fields, 'content_media_wrapper_border', "$content_media");
        $fields = $this->df_fix_border_transition($fields, 'content_media_border', "$content_media>*");
        $fields = $this->df_fix_border_transition($fields, 'content_button_border', $button);
        $fields = $this->df_fix_border_transition($fields, 'marker_wrapper_border', $marker);
        $fields = $this->df_fix_border_transition($fields, 'date_wrapper_border', $date_wrapper);

        // Box Shadow
        $fields = $this->df_fix_box_shadow_transition($fields, 'item_wrapper_box_shadow', $item_wrapper);
        $fields = $this->df_fix_box_shadow_transition($fields, 'content_text_wrapper_box_shadow', $content_text_wrapper);
        $fields = $this->df_fix_box_shadow_transition($fields, 'content_media_box_shadow', "$content_media>*");
        $fields = $this->df_fix_box_shadow_transition($fields, 'content_button_box_shadow', $button);
        $fields = $this->df_fix_box_shadow_transition($fields, 'marker_wrapper_box_shadow', $marker);

        //Spacing
        $fields['item_wrapper_padding'] = array('padding' => $content_area);
        $fields['timeline_title_margin'] = array('margin' => $title_wrapper);
        $fields['timeline_title_padding'] = array('margin' => $title_wrapper);
        $fields['timeline_subtitle_margin'] = array('margin' => $subtitle_wrapper);
        $fields['timeline_subtitle_padding'] = array('margin' => $subtitle_wrapper);
        $fields['timeline_media_item_margin'] = array('padding' => "$content_media");
        $fields['timeline_media_item_padding'] = array('padding' => "$content_media>*");
        $fields['timeline_content_margin'] = array('margin' => $content_text_wrapper);
        $fields['timeline_content_padding'] = array('padding' => $content_text_wrapper);
        $fields['timeline_button_margin'] = array('margin' => $button);
        $fields['timeline_button_padding'] = array('padding' => $button);
        $fields['date_wrapper_padding'] = array('padding' => $date_wrapper);
        $fields['date_title_margin'] = array('margin' => "$date_wrapper .df_timeline_date_title");
        $fields['date_subtitle_margin'] = array('margin' => "$date_wrapper .df_timeline_date_subtitle");

        return $fields;
    }

    public function additional_css_styles($render_slug)
    {
        if (method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            if ('' !== $this->props['content_icon'] && 'icon' === $this->props['content_media_type']) {
                $this->generate_styles(
                    array(
                        'utility_arg'    => 'icon_font_family',
                        'render_slug'    => $render_slug,
                        'base_attr_name' => 'content_icon',
                        'important'      => true,
                        'selector'       => "$this->main_css_element .df_timeline_content_area .df_timeline_media .df_timeline_content_icon",
                        'processor'      => array(
                            'ET_Builder_Module_Helper_Style_Processor',
                            'process_extended_icon'
                        )
                    )
                );
            }

            if ('on' === $this->props['use_button_icon']) {
                $this->generate_styles(
                    array(
                        'utility_arg'    => 'icon_font_family',
                        'render_slug'    => $render_slug,
                        'base_attr_name' => 'button_font_icon',
                        'important'      => true,
                        'selector'       => "$this->main_css_element  .df_timeline_button a .df_timeline_btn_icon",
                        'processor'      => array(
                            'ET_Builder_Module_Helper_Style_Processor',
                            'process_extended_icon'
                        )
                    )
                );
            }

            if ('' !== $this->props['marker_icon'] && 'icon' === $this->props['marker_type']) {
                $this->generate_styles(
                    array(
                        'utility_arg'    => 'icon_font_family',
                        'render_slug'    => $render_slug,
                        'base_attr_name' => 'marker_icon',
                        'important'      => true,
                        'selector'       => "$this->main_css_element .df_timeline_item .df_timeline_marker .df_timeline_marker_icon",
                        'processor'      => array(
                            'ET_Builder_Module_Helper_Style_Processor',
                            'process_extended_icon'
                        )
                    )
                );
            }

            if ('' !== $this->props['mobile_marker_icon'] && 'icon' === $this->props['marker_type']) {
                $this->generate_styles(
                    array(
                        'utility_arg'    => 'icon_font_family',
                        'render_slug'    => $render_slug,
                        'base_attr_name' => 'mobile_marker_icon',
                        'important'      => true,
                        'selector'       => "$this->main_css_element .df_timeline_item .df_timeline_marker .df_timeline_marker_icon",
                        'processor'      => array(
                            'ET_Builder_Module_Helper_Style_Processor',
                            'process_extended_icon'
                        )
                    )
                );
            }
        }

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'item_wrapper_bg',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_content",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_content",
                'important'   => true
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'title_bg',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_title",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_title",
                'important'   => true
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'subtitle_bg',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_subtitle",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_subtitle",
                'important'   => true
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'content_text_bg',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_desc",
                'important'   => true
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'content_media_bg',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_media>*",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_media>*",
                'important'   => true
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'content_button_bg',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_button a",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_button a:hover",
                'important'   => true
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'marker_bg',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker",
                'hover'       => "$this->main_css_element .df_timeline_item:hover .df_timeline_marker",
                'important'   => true
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'marker_icon_color',
                'type'        => 'color',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker .df_timeline_marker_icon",
                'hover'       => "$this->main_css_element .df_timeline_item:hover .df_timeline_marker .df_timeline_marker_icon"
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'mobile_marker_icon_color',
                'type'        => 'color',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker .df_timeline_marker_icon.marker_mobile",
                'hover'       => "$this->main_css_element .df_timeline_item:hover .df_timeline_marker .df_timeline_marker_icon.marker_mobile"
            )
        );

        $this->df_process_color(
            array(
                'render_slug'  => $render_slug,
                'slug'         => 'arrow_color',
                'type'         => 'border-right-color',
                'selector'     => "$this->main_css_element div.df_timeline_item div.df_timeline_content_area div.timeline_arrow div.timeline_arrow_caret",
                'hover'        => "$this->main_css_element div.df_timeline_item div.df_timeline_content_area:hover div.timeline_arrow div.timeline_arrow_caret"
            )
        );

        $this->df_process_color(
            array(
                'render_slug'  => $render_slug,
                'slug'         => 'arrow_color',
                'type'         => 'color',
                'selector'     => "$this->main_css_element div.df_timeline_item div.df_timeline_content_area div.timeline_arrow span.timeline_arrow_icon",
                'hover'        => "$this->main_css_element div.df_timeline_item div.df_timeline_content_area:hover div.timeline_arrow span.timeline_arrow_icon"
            )
        );

        $this->df_process_color(
            array(
                'render_slug'  => $render_slug,
                'slug'         => 'arrow_color',
                'type'         => 'border-color',
                'selector'     => "$this->main_css_element div.df_timeline_item div.df_timeline_content_area div.timeline_arrow div.timeline_arrow_line",
                'hover'        => "$this->main_css_element div.df_timeline_item .df_timeline_content_area:hover div.timeline_arrow div.timeline_arrow_line"
            )
        );

        // date arrow color
        $this->df_process_color(
            array(
                'render_slug'  => $render_slug,
                'slug'         => 'date_arrow_color',
                'type'         => 'border-right-color',
                'selector'     => "$this->main_css_element div.df_timeline_item div.df_timeline_date_area div.df_timeline_date_content div.timeline_arrow div.timeline_arrow_caret",
                'hover'        => "$this->main_css_element div.df_timeline_item div.df_timeline_date_area:hover div.df_timeline_date_content div.timeline_arrow div.timeline_arrow_caret"
            )
        );

        $this->df_process_color(
            array(
                'render_slug'  => $render_slug,
                'slug'         => 'date_arrow_color',
                'type'         => 'color',
                'selector'     => "$this->main_css_element div.df_timeline_item div.df_timeline_date_area div.df_timeline_date_content div.timeline_arrow span.timeline_arrow_icon",
                'hover'        => "$this->main_css_element div.df_timeline_item div.df_timeline_date_area:hover div.df_timeline_date_content div.timeline_arrow span.timeline_arrow_icon"
            )
        );

        $this->df_process_color(
            array(
                'render_slug'  => $render_slug,
                'slug'         => 'date_arrow_color',
                'type'         => 'border-color',
                'selector'     => "$this->main_css_element div.df_timeline_item div.df_timeline_date_area div.df_timeline_date_content div.timeline_arrow div.timeline_arrow_line",
                'hover'        => "$this->main_css_element div.df_timeline_item div.df_timeline_date_area:hover div.df_timeline_date_content div.timeline_arrow div.timeline_arrow_line"
            )
        );

        $this->df_process_range(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'marker_icon_size',
                'type'        => 'font-size',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker .df_timeline_marker_icon",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_marker:hover .df_timeline_marker_icon",
            )
        );

        $this->df_process_range(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'mobile_marker_icon_size',
                'type'        => 'font-size',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker .df_timeline_marker_icon.marker_mobile",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_marker:hover .df_timeline_marker_icon.marker_mobile",
            )
        );

        $this->df_process_range(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'marker_img_width',
                'type'        => 'width',
                'default'     => '100%',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_marker img",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_marker:hover img",
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'content_icon_color',
                'type'        => 'color',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_media .df_timeline_content_icon",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_media .df_timeline_content_icon"
            )
        );

        $this->df_process_range(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'content_icon_size',
                'type'        => 'font-size',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_media .df_timeline_content_icon",
                'hover'       => "$this->main_css_element .df_timeline_content_area:hover .df_timeline_media .df_timeline_content_icon",
                'default'     => '30px'
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'button_icon_color',
                'type'        => 'color',
                'selector'    => "$this->main_css_element .df_timeline_content .df_timeline_button .df_timeline_btn_icon",
                'hover'       => "$this->main_css_element .df_timeline_content .df_timeline_button a:hover .df_timeline_btn_icon"
            )
        );

        $this->df_process_range(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'button_icon_size',
                'type'        => 'font-size',
                'default'     => '18px',
                'selector'    => "$this->main_css_element .df_timeline_content .df_timeline_button a .df_timeline_btn_icon",
                'hover'       => "$this->main_css_element .df_timeline_content .df_timeline_button a:hover .df_timeline_btn_icon",
            )
        );

        $this->df_process_string_attr(array(
            'render_slug' => $render_slug,
            'slug'        => 'button_alignment',
            'type'        => 'text-align',
            'selector'    => "$this->main_css_element .df_timeline_button",
            'default'     => 'left'
        ));

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'date_wrapper_bg',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content:hover",
                'important'   => true
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'item_wrapper_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_content",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_content",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_title_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_title",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_title",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_title_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_title",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_title",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_subtitle_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_subtitle",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_subtitle",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_subtitle_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_subtitle",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_subtitle",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_media_item_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_media",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_media",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_media_item_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_media>*",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_media>*",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_content_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_desc",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_content_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_desc",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area:hover .df_timeline_desc",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_button_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_button a",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_button a:hover",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'timeline_button_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_button a",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_content_area .df_timeline_button a:hover",
                'important'   => false
            )
        );

        // custom position
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'item_vartical_position',
            'type'              => 'top',
            'selector'          => "$this->main_css_element .df_timeline_item .df_timeline_content_area",
            'default'           => '',
        ));

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'date_vartical_position',
            'type'              => 'top',
            'selector'          => "$this->main_css_element .df_timeline_item .df_timeline_date_area",
            'default'           => '0px',
        ));

        if ("left" === $this->props['button_icon_placement']) {
            $this->df_process_range(
                array(
                    'render_slug' => $render_slug,
                    'slug'        => 'button_icon_space',
                    'type'        => 'margin-right',
                    'selector'    => "$this->main_css_element .df_timeline_item  .df_timeline_button a .df_timeline_btn_icon",
                    'hover'       => "$this->main_css_element .df_timeline_item  .df_timeline_button a:hover .df_timeline_btn_icon",
                )
            );
        } else {
            $this->df_process_range(
                array(
                    'render_slug' => $render_slug,
                    'slug'        => 'button_icon_space',
                    'type'        => 'margin-left',
                    'selector'    => "$this->main_css_element .df_timeline_item  .df_timeline_button a .df_timeline_btn_icon",
                    'hover'       => "$this->main_css_element .df_timeline_item  .df_timeline_button a:hover .df_timeline_btn_icon",
                )
            );
        }

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'date_wrapper_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_date_area .df_timeline_date_content:hover",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'date_title_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_date_content .df_timeline_date_title",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_date_content:hover .df_timeline_date_title",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'date_subtitle_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element .df_timeline_item .df_timeline_date_content .df_timeline_date_subtitle",
                'hover'       => "$this->main_css_element .df_timeline_item .df_timeline_date_content:hover .df_timeline_date_subtitle",
                'important'   => false
            )
        );

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_image_width',
            'type'              => 'width',
            'selector'          => "$this->main_css_element .df_timeline_content_area .df_timeline_media img",
            'default'           => '100%',
        ));

        // media alignment
        if ('icon' === $this->props['content_media_type']) {
            $this->df_process_string_attr(array(
                'render_slug' => $render_slug,
                'slug'        => 'content_icon_alignment',
                'type'        => 'text-align',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_media",
                'default'     => 'left'
            ));
        } else {
            $this->df_process_string_attr(array(
                'render_slug' => $render_slug,
                'slug'        => 'content_image_alignment',
                'type'        => 'text-align',
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_media",
                'default'     => 'left'
            ));
        }

        // full width on image placement left/right
        if ("on" === $this->props['content_image_full_width_mobile']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_media",
                'declaration' => 'width: 100% !important;',
                'media_query' => self::get_media_query('max_width_767')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_media img",
                'declaration' => 'width: 100% !important;',
                'media_query' => self::get_media_query('max_width_767')
            ));
        }

        // button
        $display_btn = "on" === $this->props['button_full_width'] ? "block" : "inline-flex";
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_button a",
            'declaration' => "display: $display_btn;"
        ));

        if ("on" === $this->props['button_full_width']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_timeline_content_area .df_timeline_button a span",
                'declaration' => "vertical-align: middle;"
            ));
        }

        // Marker
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "$this->main_css_element .df_timeline_marker",
            'declaration' => "top: ".$this->props['marker_vertical_position'].";"
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "$this->main_css_element .df_timeline_marker",
            'declaration' => "top: ".$this->props['marker_vertical_position'].";",
            'media_query' => ET_Builder_Element::get_media_query('max_width_768'),
        ));

        // Content list position
        if (isset($this->props['design_content_text_ul_position'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element div.df_timeline_item div.df_timeline_content_area div.df_timeline_content div.df_timeline_desc ul",
                'declaration' => "list-style-position: " . $this->props['design_content_text_ul_position'] . " !important;",
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element div.df_timeline_item div.df_timeline_content_area div.df_timeline_content div.df_timeline_desc ul",
                'declaration' => "list-style-position: outside !important;",
            ));
        }
    }

    public function df_tmln_render_date()
    {
        $disable_date = "off" !== $this->parent_tmln->props['disable_date'];
        $layout_type = $this->parent_tmln->props['layout_type'] ? $this->parent_tmln->props['layout_type'] : "middle";
        $title_tag = esc_attr($this->props['date_title_tag'] ? $this->props['date_title_tag'] : "h3");
        $subtitle_tag = esc_attr($this->props['date_sub_title_tag'] ? $this->props['date_sub_title_tag'] : "h4");

        $title_html = "" !== $this->props['date_title'] ?
            sprintf(
                '<%1$s class="df_timeline_date_title">%2$s</%1$s>',
                $title_tag,
                $this->props['date_title'] ? $this->props['date_title'] : ""
            ) : '';

        $subtitle_html = "" !== $this->props['date_sub_title'] ?
            sprintf(
                '<%1$s class="df_timeline_date_subtitle">%2$s</%1$s>',
                $subtitle_tag,
                $this->props['date_sub_title'] ? $this->props['date_sub_title'] : ""
            ) : '';
        $arrow_html = "on" === $this->parent_tmln->props['enable_date_arrow'] ?
            $this->df_tmln_render_arrow(
                $this->parent_tmln->props['date_arrow_type'],
                $this->parent_tmln->props['date_arrow_icon']
            ) : "";

        return sprintf(
            '<div class="df_timeline_date_area %5$s %6$s">
                <div class="df_timeline_date_content %4$s">
                    %1$s
                    %2$s
                    %3$s
                </div>
             </div>',
            $arrow_html,
            $title_html,
            $subtitle_html,
            empty($this->props['date_title']) && empty($this->props['date_sub_title']) ? 'df_hide_section' : '',
            $disable_date && 'middle' === $layout_type ? "df_hide_section" : "",
            $disable_date && 'middle' !== $layout_type ? "df_disable_section" : ""
        );
    }
    public function df_tmln_render_marker()
    {
        $marker_type = $this->props['marker_type'] ? $this->props['marker_type'] : "icon";
        $marker_icon = sprintf(
            '<span class="et-pb-icon df_timeline_marker_icon">%1$s</span>',
            !empty($this->props['marker_icon']) ? esc_attr(et_pb_process_font_icon($this->props['marker_icon'])) : "&#xe00a;"
        );
        $isMarkerMobile = 'mobile' === $this->df_user_device() && "on" === $this->props['enable_marker_icon_mobile'];
        $marker_icon_mobile = sprintf(
            '<span class="et-pb-icon df_timeline_marker_icon %2$s">%1$s</span>',
            !empty($this->props['mobile_marker_icon']) ? esc_attr(et_pb_process_font_icon($this->props['mobile_marker_icon'])) : "&#xe00a;",
            $isMarkerMobile ? "marker_mobile" : ""
        );
        $marker_img = $this->props['marker_img'] ? $this->df_render_tmln_image($this->props['marker_img'], $this->props['marker_img_alt_txt']) : "";
        $marker_txt = $this->props['marker_txt'] ? $this->props['marker_txt'] : "Mar 1, 2023";
        $marker_html = "";

        switch ($marker_type) {
            case 'icon':
                $marker_html = $isMarkerMobile ? $marker_icon_mobile : $marker_icon;
                break;
            case 'image':
                $marker_html = $marker_img;
                break;
            case 'text':
                $marker_html = $marker_txt;
                break;
            case 'blank':
                $marker_html = "";
                break;
        }

        return sprintf(
            '<div class="df_timeline_marker">%1$s</div>',
            $marker_html
        );
    }

    public function df_tmln_render_content()
    {
        $title_tag = esc_attr($this->props['title_tag'] ? $this->props['title_tag'] : "h3");
        $subtitle_tag = esc_attr($this->props['sub_title_tag'] ? $this->props['sub_title_tag'] : "h4");
        $title_html = !empty($this->props['title']) ?
            sprintf(
                '<%1$s class="df_timeline_title">%2$s</%1$s>',
                $title_tag,
                $this->props['title']
            ) : '';
        $subtitle_html = !empty($this->props['sub_title']) ?
            sprintf(
                '<%1$s class="df_timeline_subtitle">%2$s</%1$s>',
                $subtitle_tag,
                $this->props['sub_title']
            ) : '';
        $content_btn = $this->props['enable_content_button'] ? $this->df_tmln_render_button() : "";
        $content = !empty($this->props['content']) ? $this->props['content'] : '';
        $content_html = !empty($content) ? sprintf('<div class="df_timeline_desc">%1$s</div>', $content) : "";
        $content_icon_html = !empty($this->props['content_icon']) ?
            "<span class='et-pb-icon df_timeline_content_icon'>" . esc_attr(et_pb_process_font_icon($this->props['content_icon'])) . "</span>" :
            "<span class='et-pb-icon df_timeline_content_icon'>&#xe00a;</span>";
        $content_img_html = !empty($this->props['content_image']) ? $this->df_render_tmln_image($this->props['content_image'], $this->props['content_image_alt_text']) : "";

        $media_html = 'on' === $this->props['enable_content_media'] ?
            sprintf(
                '<div class="df_timeline_media">%1$s</div>',
                'image' === $this->props['content_media_type'] ? $content_img_html : $content_icon_html
            )
            : "";

        return !empty($title_html) || !empty($subtitle_html) || !empty($content) || !empty($content_btn) || !empty($media_html) || $content_btn ?
            sprintf(
                '%1$s %2$s %3$s %4$s %5$s',
                $title_html,
                $subtitle_html,
                $media_html,
                $content_html,
                $content_btn
            ) : "";
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

    public function df_tmln_render_button()
    {
        $text = isset($this->props['button_text']) ? $this->props['button_text'] : '';
        $url = isset($this->props['button_url']) ? $this->props['button_url'] : '';
        $target = $this->props['button_url_new_window'] === 'on' ? 'target="_blank"' : '';

        $button_font_icon = $this->props['button_font_icon'];
        $button_icon_pos = $this->props['button_icon_placement'];

        // Button icon
        $button_icon = $this->props['use_button_icon'] !== 'off' ? sprintf(
            '<span class="et-pb-icon df_timeline_btn_icon">%1$s</span>',
            $button_font_icon !== '' ? esc_attr(et_pb_process_font_icon($button_font_icon)) : '5'
        ) : '';
        if ('on' === $this->props['enable_content_button']) {
            return sprintf(
                '<div class="df_timeline_button %6$s">
                    <a href="%1$s" %3$s data-icon="5">%5$s <span>%2$s</span> %4$s</a>
                </div>',
                esc_attr($url),
                esc_html(trim($text)),
                $target,
                $button_icon_pos === 'right' ? $button_icon : '',
                $button_icon_pos === 'left' ? $button_icon : '',
                "left" !== $button_icon_pos ? "right" : "left"
            );
        } else {
            return '';
        }
    }

    public function df_tmln_render_arrow($type, $icon)
    {
        $arrow_type = !empty($type) ? $type : "arrow_caret";
        $arrow_icon_html = !empty($icon) ?
            "<span class='et-pb-icon timeline_arrow_icon'>" . esc_attr(et_pb_process_font_icon($icon)) . "</span>" :
            "<span class='et-pb-icon timeline_arrow_icon'>&#x45;</span>";
        $arrow_icon = "";

        switch ($arrow_type) {
            case 'arrow_caret':
                $arrow_icon = '<div class="timeline_arrow_caret"></div>';
                break;
            case 'arrow_icon':
                $arrow_icon = $arrow_icon_html;
                break;
            case 'arrow_line':
                $arrow_icon = '<div class="timeline_arrow_line"></div>';
                break;
        }

        return sprintf('<div class="timeline_arrow">%1$s</div>', $arrow_icon);
    }

    private function df_user_device()
    {
        // library: Mobile Detect
	    $user_agent = ! empty( $_SERVER['HTTP_USER_AGENT'] ) ? strtolower( sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
        if (class_exists('\Detection\DIFL_MobileDetect')) {
            $detect = new \Detection\DIFL_MobileDetect;
        }

        $get_devices = [];
        $detect->setUserAgent($user_agent);

        if ($detect->isTablet()) {
            array_push($get_devices, "tablet");
        }

        if ($detect->isMobile() && !in_array("tablet", $get_devices)) {
            array_push($get_devices, "mobile");
        }

        if (!empty($get_devices)) {
            return $get_devices[0];
        }

        return false;
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
        $this->additional_css_styles($render_slug);

        // Content arrow
        $hasContentElement = !empty($this->df_tmln_render_content());
        $arrow_html = "on" === $this->parent_tmln->props['enable_arrow'] && $hasContentElement ?
            $this->df_tmln_render_arrow(
                $this->parent_tmln->props['arrow_type'],
                $this->parent_tmln->props['arrow_icon']
            ) : "";

        $data_settings = [
            'child_arrow_vertical_position' => !empty($this->props['child_arrow_vertical_position']) ? $this->props['child_arrow_vertical_position'] : "",
            'child_date_arrow_vertical_position' => isset($this->props['child_date_arrow_vertical_position']) ? $this->props['child_date_arrow_vertical_position'] : "",

        ];

        $output = sprintf(
            '<div class="df_timeline_item" data-settings=\'%6$s\'>
                %1$s
                %2$s
                <div class="df_timeline_content_area %5$s">
                    <div class="df_timeline_content">
                        %3$s
                    </div>
                    %4$s
                </div>
                <div class="df_line_inner"></div>
            </div>',
            $this->df_tmln_render_date(), // 1
            $this->df_tmln_render_marker(), // 2
            $this->df_tmln_render_content(), // 3
            $arrow_html, // 4
            !$hasContentElement ? 'df_hide_section' : '', // 5
            wp_json_encode($data_settings) // 6
        );

        return $output;
    }
} //Class

new DIFL_TimelineItem;
