<?php

class DIFL_FaqItem extends ET_Builder_Module
{
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_faqitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $parent_faq;
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'DiviFlash',
        'author_uri' => '',
    );

    public function init()
    {
        $this->name   = esc_html__('FAQ Item', 'divi_flash');
        $this->plural = esc_html__('FAQ Items', 'divi_flash');

        $this->parent_faq = isset(self::get_parent_modules('page')['difl_faq']) ? self::get_parent_modules('page')['difl_faq'] : new stdClass;
        $this->child_title_var          = 'question';
        $this->child_title_fallback_var = 'admin_label';

        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/rating-box.svg';
    }

    public function get_settings_modal_toggles()
    {
        // All sub toggles
        $content_sub_toggles = array(
            'p'     => array(
                'name' => 'P',
                'icon' => 'text-left'
            ),
            'a'     => array(
                'name' => 'A',
                'icon' => 'text-link'
            ),
            'ul'    => array(
                'name' => 'UL',
                'icon' => 'list'
            ),
            'ol'    => array(
                'name' => 'OL',
                'icon' => 'numbered-list'
            ),
            'quote' => array(
                'name' => 'QUOTE',
                'icon' => 'text-quote'
            ),
        );
        $heading_sub_toggles = array(
            'h1' => array(
                'name' => 'H1',
                'icon' => 'text-h1'
            ),
            'h2' => array(
                'name' => 'H2',
                'icon' => 'text-h2'
            ),
            'h3' => array(
                'name' => 'H3',
                'icon' => 'text-h3'
            ),
            'h4' => array(
                'name' => 'H4',
                'icon' => 'text-h4'
            ),
            'h5' => array(
                'name' => 'H5',
                'icon' => 'text-h5'
            ),
            'h6' => array(
                'name' => 'H6',
                'icon' => 'text-h6'
            ),
        );

        return array(
            'general'   => array(
                'toggles'      => array(
                    'child_faq_question'    => esc_html__('Question', 'divi_flash'),
                    'child_faq_answer'      => esc_html__('Answer', 'divi_flash'),
                    'child_hide_item'     => esc_html__('Hide FAQ Item', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'design_question'  => esc_html__('Question Style', 'divi_flash'),
                    'design_question_active'  => esc_html__('Question Opened Style', 'divi_flash'),
                    'design_question_text' => [
                        'title'        => esc_html__('Question Text', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'  => [
                            'close'   => [
                                'name' => esc_html__('Text', 'divi_flash')
                            ],
                            'open'   => [
                                'name' => esc_html__('Opened Text', 'divi_flash')
                            ]
                        ]
                    ],
                    'design_faq_icon'  => [
                        'title'        => esc_html__('Question Icon', 'divi_flash'),
                        'tabbed_subtoggles'  => true,
                        'sub_toggles'  => [
                            'close' => [
                                'name' => esc_html__('Icon', 'divi_flash')
                            ],
                            'open'  => [
                                'name' => esc_html__('Opened Icon', 'divi_flash')
                            ]
                        ],
                    ],
                    'design_que_img'   => [
                        'title'        => esc_html__('Question Image', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'  => [
                            'close'    => [
                                'name' => esc_html__('Image', 'divi_flash')
                            ],
                            'open'     => [
                                'name' => esc_html__('Opened Image', 'divi_flash')
                            ]
                        ]
                    ],
                    'design_answer'    => esc_html__('Answer Style', 'divi_flash'),
                    'design_answer_text'    => array(
                        'title'             => esc_html__('Answer Text', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => $content_sub_toggles
                    ),
                    'design_answer_heading' => array(
                        'title' => esc_html__('Answer Heading Text', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => $heading_sub_toggles
                    ),
                    'design_answer_img' => esc_html__('Answer Image', 'divi_flash'),
                    'design_button'    => esc_html__('Answer Button', 'divi_flash'),
                    'margin_padding'   => [
                        'title'        => esc_html__('Custom Spacing', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'  => [
                            'wrapper'  => [
                                'name' => esc_html__('Wrapper', 'divi_flash')
                            ],
                            'content'  => [
                                'name' => esc_html__('Content', 'divi_flash')
                            ]
                        ]
                    ]
                )
            ),
        );
    }

    public function get_fields()
    {
        $question = [
            'question' => array(
                'label'           => esc_html__('Question', 'divi_flash'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'child_faq_question',
                'dynamic_content' => 'text'
            ),
            'question_title_tag'  => array(
                'label'           => esc_html__('Question Tag', 'divi_flash'),
                'description'     => esc_html__('Choose a tag to display your question.', 'divi_flash'),
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
                'toggle_slug'      => 'child_faq_question',
                // 'default'          => 'h3'
            ),
            'enable_question_image' => array(
                'label'          => esc_html__('Enable Question Image', 'divi_flash'),
                'type'           => 'yes_no_button',
                'default'        => 'off',
                'options'        => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'toggle_slug'    => 'child_faq_question'
            ),
            'close_question_image' => array(
                'label'                 => esc_html__('Image', 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'upload_button_text'    => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'child_faq_question',
                'show_if' => array(
                    'enable_question_image' => 'on'
                )
            ),
            'close_que_img_alt_txt' => array(
                'label'                 => esc_html__('Image Alt Text', 'divi_flash'),
                'description'           => esc_html__('This defines the HTML ALT text. A short description of your image can be placed here.', 'divi_flash'),
                'default'               => 'Closed image alt text',
                'type'                  => 'text',
                'toggle_slug'           => 'child_faq_question',
                'show_if'        => array(
                    'enable_question_image' => 'on'
                )
            ),
            'open_question_image' => array(
                'label'                 => esc_html__('Use different image on opening.', 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'upload_button_text'    => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'child_faq_question',
                'show_if'        => array(
                    'enable_question_image' => 'on'
                )
            ),
            'open_que_img_alt_txt' => array(
                'label'        => esc_html__('Opened Image Alt Text', 'divi_flash'),
                'description'  => esc_html__('This defines the HTML ALT text. A short description of your image can be placed here.', 'divi_flash'),
                'default'      => 'Opened image alt text',
                'type'         => 'text',
                'toggle_slug'  => 'child_faq_question',
                'show_if'      => array(
                    'enable_question_image' => 'on'
                )
            ),
            'question_image_placement' => array(
                'label'           => esc_html__('Image Placement', 'divi_flash'),
                'type'            => 'select',
                'default'         => 'inherit',
                'options'         => array(
                    'inherit'     => esc_html__('Left', 'divi_flash'),
                    'row-reverse' => esc_html__('Right', 'divi_flash'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'child_faq_question',
                'mobile_options'  => true,
                'show_if' => array(
                    'enable_question_image' => 'on'
                )
            )
        ];

        $answer = [
            'content' => array(
                'label'           => esc_html__('Answer', 'divi_flash'),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'child_faq_answer',
                'dynamic_content' => 'text'
            ),
            'enable_answer_image' => array(
                'label'           => esc_html__('Enable Image', 'divi_flash'),
                'type'            => 'yes_no_button',
                'default'         => 'off',
                'options'         => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'toggle_slug' => 'child_faq_answer'
            ),
            'answer_image' => array(
                'label'              => esc_html__('Answer Image', 'divi_flash'),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'        => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'        => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'        => 'child_faq_answer',
                'show_if' => array(
                    'enable_answer_image' => 'on'
                )
            ),
            'answer_image_alt_text' => array(
                'label'             => esc_html__('Image Alt Text', 'divi_flash'),
                'description'       => esc_html__('This defines the HTML ALT text. A short description of your image can be placed here.', 'divi_flash'),
                'type'              => 'text',
                'default'           => 'Answer image alt text',
                'toggle_slug'       => 'child_faq_answer',
                'show_if'           => array(
                    'enable_answer_image' => 'on'
                )
            ),
            'answer_image_placement' => array(
                'label'              => esc_html__('Image Placement', 'divi_flash'),
                'type'               => 'select',
                'default'            => 'column-reverse',
                'options'            => array(
                    'column-reverse' => esc_html__('Top', 'divi_flash'),
                    'column'         => esc_html__('Bottom', 'divi_flash'),
                    'row-reverse'    => esc_html__('Left', 'divi_flash'),
                    'row'            => esc_html__('Right', 'divi_flash'),
                ),
                'option_category'    => 'basic_option',
                'toggle_slug'        => 'child_faq_answer',
                'show_if'            => array(
                    'enable_answer_image' => 'on'
                ),
                // 'mobile_options'     => true
            ),
            'answer_image_width' => array(
                'label'         => esc_html__('Image Container Width', 'divi_flash'),
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
                'default'       => '50%',
                'toggle_slug'   => 'child_faq_answer',
                'show_if'       => array(
                    'enable_answer_image' => 'on',
                    'answer_image_placement' => ['row-reverse', 'row']
                ),
                'mobile_options'    => true
            ),
            'answer_image_width_top_bottom' => array(
                'label'         => esc_html__('Image Width', 'divi_flash'),
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
                'toggle_slug'   => 'design_answer_img',
                'tab_slug'      => 'advanced',
                'show_if'       => array(
                    'enable_answer_image' => 'on',
                ),
                'show_if_not'       => array(
                    'answer_image_placement' => ['row-reverse', 'row']
                ),
                'mobile_options'    => true
            ),
            'answer_image_full_width_mobile' => array(
                'label'         => esc_html__('Content Full Width On Mobile', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'       => 'off',
                'toggle_slug'   => 'child_faq_answer',
                'show_if'       => array(
                    'answer_image_placement' => ['row-reverse', 'row']
                )
            ),
            'answer_image_alignment'   => array(
                'label'         => esc_html__('Image Alignment', 'divi_flash'),
                'type'          => 'text_align',
                'option_category' => 'configuration',
                'options'       => et_builder_get_text_orientation_options(
                    array('justified')
                ),
                'toggle_slug'   => 'child_faq_answer',
                'default'       => 'left',
                'options_icon'  => 'module_align',
                'mobile_options' => true,
                'toggle_slug'   => 'design_answer_img',
                'tab_slug'      => 'advanced',
                'show_if'       => array(
                    'enable_answer_image' => 'on'
                ),
                'show_if_not'       => array(
                    'answer_image_placement' => ['row-reverse', 'row']
                ),
            )
        ];

        $faq_que_icon = [
            'faq_icon_bg' => array(
                'label'          => esc_html__('Background Color', 'divi_flash'),
                'type'           => 'color-alpha',
                'toggle_slug'    => 'design_faq_icon',
                'sub_toggle'     => 'close',
                'tab_slug'       => 'advanced',
                'hover'          => 'tabs',
                'option_category' => 'basic_option'
            ),
            'active_faq_icon_bg' => array(
                'label'          => esc_html__('Background Color', 'divi_flash'),
                'type'           => 'color-alpha',
                'toggle_slug'    => 'design_faq_icon',
                'sub_toggle'     => 'open',
                'tab_slug'       => 'advanced',
                'hover'          => 'tabs',
                'option_category' => 'basic_option'
            ),

            'close_icon_color'   => array(
                'label'          => esc_html__('Icon Color', 'divi_flash'),
                'type'           => 'color-alpha',
                'description'    => esc_html__('Here you can define a custom color for your icon.', 'divi_flash'),
                'toggle_slug'    => 'design_faq_icon',
                'sub_toggle'     => 'close',
                'tab_slug'       => 'advanced',
                'hover'          => 'tabs'
            ),

            'open_icon_color'    => array(
                'label'          => esc_html__('Icon Color', 'divi_flash'),
                'type'           => 'color-alpha',
                'description'    => esc_html__('Here you can define a custom color for your icon.', 'divi_flash'),
                'depends_show_if' => 'on',
                'toggle_slug'    => 'design_faq_icon',
                'sub_toggle'     => 'open',
                'tab_slug'       => 'advanced',
                'hover'          => 'tabs'
            )
        ];

        $faq_que_img = [
            'que_img_bg' => array(
                'label'         => esc_html__('Background', 'divi_flash'),
                'type'          => 'color-alpha',
                'toggle_slug'   => 'design_que_img',
                'sub_toggle'    => 'close',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs',
                'option_category' => 'basic_option'
            ),
            'active_que_img_bg' => array(
                'label'         => esc_html__('Background', 'divi_flash'),
                'type'          => 'color-alpha',
                'toggle_slug'   => 'design_que_img',
                'sub_toggle'    => 'open',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs',
                'option_category' => 'basic_option'
            )
        ];

        $button = [
            'enable_answer_button' => array(
                'label'            => esc_html__('Enable Button', 'divi_flash'),
                'type'             => 'yes_no_button',
                'default'          => 'off',
                'options'          => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'toggle_slug'      => 'child_faq_answer'
            ),
            'button_text' => array(
                'label'           => esc_html__('Button Text', 'divi_flash'),
                'type'            => 'text',
                'default'         => esc_html__('Button', 'divi_flash'),
                'dynamic_content' => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'child_faq_answer',
                'show_if'         => array(
                    'enable_answer_button' => 'on'
                )
            ),
            'button_url' => array(
                'label'           => esc_html__('Button URL', 'divi_flash'),
                'type'            => 'text',
                'default'         => '#',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'child_faq_answer',
                'show_if'         => array(
                    'enable_answer_button' => 'on'
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
                'toggle_slug'     => 'child_faq_answer',
                'show_if'         => array(
                    'enable_answer_button' => 'on'
                )
            ),
            'button_text_color' => array(
                'label'         => esc_html__('Text Color', 'divi_flash'),
                'type'          => 'color-alpha',
                'description'   => esc_html__('Here you can define a custom color for button text.', 'divi_flash'),
                'toggle_slug'   => 'design_button',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs',
                'show_if'         => array(
                    'enable_answer_button' => 'on'
                )
            ),
            'button_full_width'   => array(
                'label'           => esc_html__('Enable Button Full Width', 'divi_flash'),
                'type'            => 'yes_no_button',
                'options'         => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'         => 'off',
                'toggle_slug'     => 'design_button',
                'tab_slug'        => 'advanced',
                'show_if'         => array(
                    'enable_answer_button' => 'on',
                    'show_icon_hover' => 'off',
                )
            ),
            'button_alignment'    => array(
                'label'           => esc_html__('Button Alignment', 'divi_flash'),
                'type'            => 'text_align',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'     => 'design_button',
                'tab_slug'        => 'advanced',
                'mobile_options'  => true,
                'show_if'         => array(
                    'enable_answer_button' => 'on'
                ),
                'show_if_not'         => array(
                    'button_full_width'    => 'on'
                ),
            ),
        ];

        $button_icon = [
            'use_button_icon' => array(
                'label'       => esc_html__('Use Button Icon', 'divi_flash'),
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
                'description' => esc_html__('Here you can choose whether icon set below should be used.', 'divi_flash'),
                'default'     => 'off',
                'toggle_slug' => 'child_faq_answer',
                'show_if' => array(
                    'enable_answer_button' => 'on'
                )
            ),
            'button_font_icon' => array(
                'label'           => esc_html__('Icon', 'divi_flash'),
                'type'            => 'select_icon',
                'class'           => array('et-pb-font-icon'),
                'default'         => '5',
                'toggle_slug'     => 'child_faq_answer',
                'description'     => esc_html__('Choose an icon to display with your blurb.', 'divi_flash'),
                'depends_show_if' => 'on'
            ),
            'button_icon_placement' => array(
                'label'           => esc_html__('Icon Placement', 'divi_flash'),
                'type'            => 'select',
                'default'         => 'right',
                'options'         => array(
                    'left'        => esc_html__('Left', 'divi_flash'),
                    'right'       => esc_html__('Right', 'divi_flash')
                ),
                'toggle_slug'     => 'child_faq_answer',
                'show_if'         => array(
                    'use_button_icon' => 'on'
                )
            ),
            'show_icon_hover' => array(
                'label'       => esc_html__('Show Icon On Hover', 'divi_flash'),
                'type'        => 'yes_no_button',
                'options'     => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'description' => esc_html__('Here you can choose whether icon set below should be used.', 'divi_flash'),
                'default'     => 'off',
                'toggle_slug' => 'child_faq_answer',
                'show_if' => array(
                    'use_button_icon' => 'on',
                    'button_full_width' => 'off',
                )
            ),
            'button_icon_color' => array(
                'label'         => esc_html__('Icon Color', 'divi_flash'),
                'type'          => 'color-alpha',
                'description'   => esc_html__('Here you can define a custom color for your icon.', 'divi_flash'),
                'toggle_slug'   => 'design_button',
                'tab_slug'      => 'advanced',
                'hover'         => 'tabs',
                'show_if'         => array(
                    'use_button_icon' => 'on'
                )
            ),
            'button_icon_size' => array(
                'label'           => esc_html__('Icon Size', 'divi_flash'),
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
                    'use_button_icon' => 'on'
                )
            ),
            'button_icon_space'  => array(
                'label'         => esc_html__('Icon Space', 'divi_flash'),
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
                    'use_button_icon' => 'on'
                ),
                'responsive'    => true,
                'mobile_options' => true
            )
        ];

        $setting = [
            'hide_faq_item' => array(
                'type'         => 'multiple_checkboxes',
                'options'      => [
                    "desktop"  => "Desktop",
                    "tablet"   => "Tablet",
                    "mobile"   => "Mobile"
                ],
                'toggle_slug'      => 'child_hide_item'
            )
        ];

        $que_wrapper_bg = $this->df_add_bg_field(array(
            'label'            => 'Background',
            'key'              => 'default_que_wrapper_bg',
            'toggle_slug'      => 'design_question',
            'tab_slug'         => 'advanced'
        ));

        $active_que_wrapper_bg = $this->df_add_bg_field(array(
            'label'            => 'Background',
            'key'              => 'active_que_wrapper_bg',
            'toggle_slug'      => 'design_question_active',
            'tab_slug'         => 'advanced'
        ));

        $ans_wrapper_bg = $this->df_add_bg_field(array(
            'label'            => 'Background',
            'key'              => 'ans_wrapper_bg',
            'toggle_slug'      => 'design_answer',
            'tab_slug'         => 'advanced'
        ));

        $ans_button_bg = $this->df_add_bg_field(array(
            'label'           => 'Background',
            'key'             => 'ans_button_bg',
            'toggle_slug'     => 'design_button',
            'tab_slug'        => 'advanced',
            'show_if'         => array(
                'enable_answer_button' => 'on'
            )
        ));

        $faq_item_wrapper_margin = $this->add_margin_padding(array(
            'title'         => 'FAQ Item Wrapper',
            'key'           => 'faq_item_wrapper',
            'toggle_slug'   => 'margin_padding',
            'sub_toggle'    => 'wrapper'
        ));

        $que_wrapper_margin = $this->add_margin_padding(array(
            'title'         => 'Question Wrapper',
            'key'           => 'que_wrapper',
            'toggle_slug'   => 'margin_padding',
            'sub_toggle'    => 'wrapper'
        ));


        $que_text_margin = $this->add_margin_padding(array(
            'title'         => 'Question Text',
            'key'           => 'que_text',
            'option'        => 'margin',
            'toggle_slug'   => 'margin_padding',
            'sub_toggle'    => 'content'
        ));

        $icon_wrapper_margin = $this->add_margin_padding(array(
            'title'         => 'Question Icon',
            'key'           => 'que_icon',
            'toggle_slug'   => 'margin_padding',
            'sub_toggle'    => 'content'
        ));

        $que_img_margin = $this->add_margin_padding(array(
            'title'         => 'Question Image',
            'key'           => 'que_img',
            'toggle_slug'   => 'margin_padding',
            'sub_toggle'    => 'content'
        ));

        $ans_wrapper_margin = $this->add_margin_padding(array(
            'title'         => 'Answer Wrapper',
            'key'           => 'ans_wrapper',
            'toggle_slug'   => 'margin_padding',
            'sub_toggle'    => 'wrapper'
        ));

        $ans_text_padding = $this->add_margin_padding(
            array(
                'title'         => 'Answer Text',
                'key'           => 'ans_text',
                'toggle_slug'   => 'margin_padding',
                'sub_toggle'    => 'content',
                'option'        => 'padding',
            )
        );

        $ans_img_padding = $this->add_margin_padding(
            array(
                'title'         => 'Answer Image',
                'key'           => 'ans_img',
                'toggle_slug'   => 'margin_padding',
                'sub_toggle'    => 'content',
                'option'        => 'padding',
            )
        );

        $ans_btn_margin = $this->add_margin_padding(
            array(
                'title'         => 'Answer Button',
                'key'           => 'ans_button',
                'toggle_slug'   => 'design_button',
                'tab_slug'      => 'advanced',
                'show_if'         => array(
                    'enable_answer_button' => 'on'
                )
            )
        );

        $general_common_fields = array(
            'admin_label' => array(
                'label'           => et_builder_i18n('Admin Label'),
                'description'     => esc_html__(
                    'This will change the label of the module in the builder for easy identification.',
                    'et_builder'
                ),
                'type'            => 'text',
                'option_category' => 'configuration',
                'toggle_slug'     => 'admin_label',
            ),
        );

        return array_merge(
            $question,
            $answer,
            $faq_que_icon,
            $faq_que_img,
            $que_wrapper_bg,
            $active_que_wrapper_bg,
            $ans_wrapper_bg,
            $ans_button_bg,
            $button,
            $button_icon,
            $setting,
            $faq_item_wrapper_margin,
            $que_wrapper_margin,
            $que_text_margin,
            $icon_wrapper_margin,
            $que_img_margin,
            $ans_wrapper_margin,
            $ans_text_padding,
            $ans_img_padding,
            $general_common_fields,
            $ans_btn_margin
        );
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = array();
        $advanced_fields['text'] = false;

        $advanced_fields['background'] = [
            'css'       => array(
                'main'  => ".difl_faq $this->main_css_element div.df_faq_item",
                'hover' => ".difl_faq $this->main_css_element div.df_faq_item:hover",
                'important' => 'all'
            )
        ];

        $advanced_fields['fonts'] = [
            'question_text'         => array(
                'toggle_slug'  => 'design_question_text',
                'sub_toggle'   => 'close',
                'tab_slug'     => 'advanced',
                'hide_text_align' => true,
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'font_size'    => array(
                    'default'  => '22px',
                ),
                'font-weight'  => array(
                    'default'  => 'normal'
                ),
                'css'       => array(
                    'main'  => ".difl_faq $this->main_css_element div.df_faq_item div.faq_question_wrapper .faq_question_title",
                    'hover' => ".difl_faq $this->main_css_element div.df_faq_item div.faq_question_wrapper:hover .faq_question_title",
                    'important' => 'all'
                )
            ),

            'active_design_question_text'  => array(
                'toggle_slug'  => 'design_question_text',
                'sub_toggle'   => 'open',
                'tab_slug'     => 'advanced',
                'hide_text_align' => true,
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'font_size'    => array(
                    'default'  => '22px',
                ),
                'font-weight'  => array(
                    'default'  => 'normal'
                ),
                'css'       => array(
                    'main'  => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_wrapper .faq_question_title",
                    'hover' => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_wrapper:hover .faq_question_title",
                    'important' => 'all'
                )
            ),

            'design_answer_text' => array(
                'toggle_slug' => 'design_answer_text',
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
                    'main'  => ".difl_faq $this->main_css_element .faq_answer_wrapper .faq_answer, .difl_faq $this->main_css_element .faq_answer_wrapper .faq_answer p",
                    'hover' => ".difl_faq $this->main_css_element .faq_answer_wrapper .faq_answer:hover, .difl_faq $this->main_css_element .faq_answer_wrapper .faq_answer:hover p",
                    'important' => 'all'
                ),
                // answer design
                'block_elements' => array(
                    'tabbed_subtoggles' => true,
                    'bb_icons_support'  => true,
                    'css'  => array(
                        'main'  => ".difl_faq $this->main_css_element .faq_answer_wrapper .faq_answer p",
                        'hover' => ".difl_faq $this->main_css_element .faq_answer_wrapper .faq_answer:hover p",
                        'a' => ".difl_faq $this->main_css_element .faq_answer_wrapper .faq_answer a",
                        'ul' => ".difl_faq $this->main_css_element .faq_answer_wrapper .faq_answer ul",
                        'ol' => ".difl_faq $this->main_css_element .faq_answer_wrapper .faq_answer ol",
                        'quote' => ".difl_faq $this->main_css_element .faq_answer_wrapper .faq_answer blockquote",
                    )
                ),
            ),
            'ans_button'       => array(
                'toggle_slug'  => 'design_button',
                'tab_slug'     => 'advanced',
                'hide_text_color' => true,
                'line_height'  => array(
                    'default'  => '1.5em',
                ),
                'font_size'    => array(
                    'default'  => '18px',
                ),
                'font-weight'  => array(
                    'default'  => 'normal'
                ),
                'css'       => array(
                    'main'  => ".difl_faq $this->main_css_element .faq_answer_wrapper .faq_answer_area .faq_answer .faq_button a",
                    'hover' => ".difl_faq $this->main_css_element .faq_answer_wrapper .faq_answer_area .faq_answer .faq_button:hover a",
                    'important' => 'all'
                ),
            ),

        ];

        // Heading Tag
        $advanced_fields['fonts']['content_heading_1']  = array(
            'label'       => esc_html__('Heading 1', 'divi_flash'),
            'font_size'   => array(
                'default' => absint(et_get_option('body_header_size', '30')) . 'px',
            ),
            'font_weight' => array(
                'default' => '500',
            ),
            'line_height' => array(
                'default' => '1.7',
            ),
            'css'         => array(
                'main'    => ".difl_faq $this->main_css_element div.faq_answer_wrapper .faq_answer h1",
                'hover'   => ".difl_faq $this->main_css_element div.faq_answer_wrapper .faq_answer h1:hover",
            ),
            'toggle_slug' => 'design_answer_heading',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'h1'
        );
        $advanced_fields['fonts']['content_heading_2']  = array(
            'label'       => esc_html__('Heading 2', 'divi_flash'),
            'font_size'   => array(
                'default' => '26px',
            ),
            'font_weight' => array(
                'default' => '500',
            ),
            'line_height' => array(
                'default' => '1.7',
            ),
            'css'         => array(
                'main'    => ".difl_faq $this->main_css_element div.faq_answer_wrapper .faq_answer h2",
                'hover'   => ".difl_faq $this->main_css_element div.faq_answer_wrapper .faq_answer h2:hover",
            ),
            'tab_slug'    => 'advanced',
            'toggle_slug' => 'design_answer_heading',
            'sub_toggle'  => 'h2'
        );
        $advanced_fields['fonts']['content_heading_3']  = array(
            'label'       => esc_html__('Heading 3', 'divi_flash'),
            'font_size'   => array(
                'default' => '22px',
            ),
            'font_weight' => array(
                'default' => '500',
            ),
            'line_height' => array(
                'default' => '1.7',
            ),
            'css'         => array(
                'main'    => ".difl_faq $this->main_css_element div.faq_answer_wrapper .faq_answer h3",
                'hover'   => ".difl_faq $this->main_css_element div.faq_answer_wrapper .faq_answer h3:hover",
            ),
            'toggle_slug' => 'design_answer_heading',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'h3'
        );
        $advanced_fields['fonts']['content_heading_4']  = array(
            'label'       => esc_html__('Heading 4', 'divi_flash'),
            'font_size'   => array(
                'default' => '18px',
            ),
            'font_weight' => array(
                'default' => '500',
            ),
            'line_height' => array(
                'default' => '1.7',
            ),
            'css'         => array(
                'main'    => ".difl_faq $this->main_css_element div.faq_answer_wrapper .faq_answer h4",
                'hover'   => ".difl_faq $this->main_css_element div.faq_answer_wrapper .faq_answer h4:hover",
            ),
            'toggle_slug' => 'design_answer_heading',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'h4'
        );
        $advanced_fields['fonts']['content_heading_5']  = array(
            'label'       => esc_html__('Heading 5', 'divi_flash'),
            'font_size'   => array(
                'default' => '16px',
            ),
            'font_weight' => array(
                'default' => '500',
            ),
            'line_height' => array(
                'default' => '1.7',
            ),
            'css'         => array(
                'main'    => ".difl_faq $this->main_css_element div.faq_answer_wrapper .faq_answer h5",
                'hover'   => ".difl_faq $this->main_css_element div.faq_answer_wrapper .faq_answer h5:hover",
            ),
            'toggle_slug' => 'design_answer_heading',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'h5'
        );
        $advanced_fields['fonts']['content_heading_6']  = array(
            'label'       => esc_html__('Heading 6', 'divi_flash'),
            'font_size'   => array(
                'default' => '14px',
            ),
            'font_weight' => array(
                'default' => '500',
            ),
            'line_height' => array(
                'default' => '1.7',
            ),
            'css'         => array(
                'main'    => ".difl_faq $this->main_css_element div.faq_answer_wrapper .faq_answer h6",
                'hover'   => ".difl_faq $this->main_css_element div.faq_answer_wrapper .faq_answer h6:hover",
            ),
            'toggle_slug' => 'design_answer_heading',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'h6'
        );

        $advanced_fields['borders'] = array(
            'default'     => [
                'css'            => array(
                    'main'  => array(
                        'border_radii'       => ".difl_faq $this->main_css_element div.df_faq_item",
                        'border_radii_hover' => ".difl_faq $this->main_css_element div.df_faq_item:hover",
                        'border_styles'      => ".difl_faq $this->main_css_element div.df_faq_item",
                        'border_styles_hover' => ".difl_faq $this->main_css_element div.df_faq_item:hover",
                    ),
                    'important' => 'all'
                )
            ],
            'que_wrapper_border' => array(
                'css'            => array(
                    'main'  => array(
                        'border_radii'       => ".difl_faq $this->main_css_element div.df_faq_item div.faq_question_wrapper",
                        'border_radii_hover' => ".difl_faq $this->main_css_element div.df_faq_item div.faq_question_wrapper:hover",
                        'border_styles'      => ".difl_faq $this->main_css_element div.df_faq_item div.faq_question_wrapper",
                        'border_styles_hover' => ".difl_faq $this->main_css_element div.df_faq_item div.faq_question_wrapper:hover",
                    )
                ),
                'toggle_slug'     => 'design_question',
                'tab_slug'        => 'advanced'
            ),
            'active_que_wrapper_border'      => array(
                'css'       => array(
                    'main'  => array(
                        'border_radii'       => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_wrapper",
                        'border_radii_hover' => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_wrapper:hover",
                        'border_styles'      => ".difl_faq $this->main_css_element .df_faq_item.active div.faq_question_wrapper",
                        'border_styles_hover' => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_wrapper:hover",
                    )
                ),
                'toggle_slug'     => 'design_question_active',
                'tab_slug'        => 'advanced'
            ),
            'que_img_border' => array(
                'css' => array(
                    'main' => array(
                        'border_radii'       => ".difl_faq $this->main_css_element div.faq_question_image",
                        'border_radii_hover' => ".difl_faq $this->main_css_element div.faq_question_wrapper:hover div.faq_question_image",
                        'border_styles'      => ".difl_faq $this->main_css_element div.faq_question_image",
                        'border_styles_hover' => ".difl_faq $this->main_css_element div.faq_question_wrapper:hover div.faq_question_image",
                    )
                ),
                'toggle_slug'     => 'design_que_img',
                'sub_toggle'      => 'close',
                'tab_slug'        => 'advanced'
            ),
            'active_que_img_border' => array(
                'css' => array(
                    'main' => array(
                        'border_radii'       => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_image",
                        'border_radii_hover' => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_wrapper:hover div.faq_question_image",
                        'border_styles'      => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_image",
                        'border_styles_hover' => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_wrapper:hover div.faq_question_image",
                    )
                ),
                'toggle_slug'     => 'design_que_img',
                'sub_toggle'      => 'open',
                'tab_slug'        => 'advanced'
            ),
            'que_icon_wrapper_border' => array(
                'css' => array(
                    'main' => array(
                        'border_radii'       => ".difl_faq $this->main_css_element div.df_faq_item div.faq_icon",
                        'border_radii_hover' => ".difl_faq $this->main_css_element div.df_faq_item div.faq_question_wrapper:hover div.faq_icon",
                        'border_styles'      => ".difl_faq $this->main_css_element div.df_faq_item div.faq_icon",
                        'border_styles_hover' => ".difl_faq $this->main_css_element div.df_faq_item div.faq_question_wrapper:hover div.faq_icon",
                    )
                ),
                'toggle_slug'     => 'design_faq_icon',
                'sub_toggle'      => 'close',
                'tab_slug'        => 'advanced',
            ),
            'active_que_icon_wrapper_border' => array(
                'css' => array(
                    'main' => array(
                        'border_radii'       => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_icon",
                        'border_radii_hover' => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_wrapper:hover div.faq_icon",
                        'border_styles'      => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_icon",
                        'border_styles_hover' => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_wrapper:hover div.faq_icon",
                    )
                ),
                'toggle_slug'     => 'design_faq_icon',
                'sub_toggle'      => 'open',
                'tab_slug'        => 'advanced',
            ),
            'ans_wrapper_border' => array(
                'css' => array(
                    'main'  => array(
                        'border_radii'       => ".difl_faq $this->main_css_element div.faq_answer_area",
                        'border_radii_hover' => ".difl_faq $this->main_css_element div.faq_answer_area:hover",
                        'border_styles'      => ".difl_faq $this->main_css_element div.faq_answer_area",
                        'border_styles_hover' => ".difl_faq $this->main_css_element div.faq_answer_area:hover",
                    )
                ),
                'toggle_slug'     => 'design_answer',
                'tab_slug'        => 'advanced'
            ),
            'ans_img_border' => array(
                'css' => array(
                    'main' => array(
                        'border_radii'       => ".difl_faq $this->main_css_element div.faq_answer_image",
                        'border_radii_hover' => ".difl_faq $this->main_css_element div.faq_answer_image:hover",
                        'border_styles'      => ".difl_faq $this->main_css_element div.faq_answer_image",
                        'border_styles_hover' => ".difl_faq $this->main_css_element div.faq_answer_image:hover",
                    )
                ),
                'toggle_slug'     => 'design_answer_img',
                'tab_slug'        => 'advanced'
            ),
            'ans_button_border' => array(
                'css' => array(
                    'main'  => array(
                        'border_radii'       => ".difl_faq $this->main_css_element div.faq_button a",
                        'border_radii_hover' => ".difl_faq $this->main_css_element div.faq_button a:hover",
                        'border_styles'      => ".difl_faq $this->main_css_element div.faq_button a",
                        'border_styles_hover' => ".difl_faq $this->main_css_element div.faq_button a:hover",
                    )
                ),
                'toggle_slug'     => 'design_button',
                'tab_slug'        => 'advanced'
            ),
        );

        $advanced_fields['box_shadow'] = array(
            'default' => [
                'css' => array(
                    'main'  => ".difl_faq $this->main_css_element div.df_faq_item",
                    'hover' => ".difl_faq $this->main_css_element div.df_faq_item:hover",
                    'important' => 'all'
                )
            ],
            'que_wrapper_box_shadow' => array(
                'css' => array(
                    'main'  => ".difl_faq $this->main_css_element div.df_faq_item div.faq_question_wrapper",
                    'hover' => ".difl_faq $this->main_css_element div.df_faq_item div.faq_question_wrapper:hover",
                ),
                'toggle_slug'   => 'design_question',
                'tab_slug'      => 'advanced',
            ),
            'active_que_wrapper_box_shadow' => array(
                'css' => array(
                    'main'  => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_wrapper",
                    'hover' => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_wrapper:hover",
                ),
                'toggle_slug' => 'design_question_active',
                'tab_slug'    => 'advanced',
            ),
            'que_img_box_shadow' => array(
                'css' => array(
                    'main'  => ".difl_faq $this->main_css_element div.df_faq_item div.faq_question_image",
                    'hover' => ".difl_faq $this->main_css_element div.df_faq_item div.faq_question_wrapper:hover div.faq_question_image",
                ),
                'toggle_slug'   => 'design_que_img',
                'sub_toggle'    => 'close',
                'tab_slug'      => 'advanced',
            ),
            'active_que_img_box_shadow' => array(
                'css' => array(
                    'main'  => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_image",
                    'hover' => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_wrapper:hover div.faq_question_image",
                ),
                'toggle_slug'   => 'design_que_img',
                'sub_toggle'    => 'open',
                'tab_slug'      => 'advanced',
            ),
            'que_icon_box_shadow' => array(
                'css' => array(
                    'main'  => ".difl_faq $this->main_css_element div.df_faq_item div.faq_icon",
                    'hover' => ".difl_faq $this->main_css_element div.df_faq_item div.faq_question_wrapper:hover div.faq_icon",
                ),
                'toggle_slug'   => 'design_faq_icon',
                'sub_toggle'    => 'close',
                'tab_slug'      => 'advanced',
            ),
            'active_que_icon_box_shadow' => array(
                'css' => array(
                    'main'  => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_icon",
                    'hover' => ".difl_faq $this->main_css_element div.df_faq_item.active div.faq_question_wrapper:hover div.faq_icon",
                ),
                'toggle_slug'   => 'design_faq_icon',
                'sub_toggle'    => 'open',
                'tab_slug'      => 'advanced',
            ),
            'ans_wrapper_box_shadow' => array(
                'css' => array(
                    'main'  => ".difl_faq $this->main_css_element div.faq_answer_area",
                    'hover' => ".difl_faq $this->main_css_element div.faq_answer_area:hover",
                ),
                'toggle_slug'  => 'design_answer',
                'tab_slug'     => 'advanced',
            ),
            // 'ans_wrapper_box_shadow' => array(
            //     'css' => array(
            //         'main'  => ".difl_faq $this->main_css_element div.faq_answer_wrapper",
            //         'hover' => ".difl_faq $this->main_css_element div.faq_answer_wrapper:hover",
            //     ),
            //     'toggle_slug'  => 'design_answer',
            //     'tab_slug'     => 'advanced',
            // ),
            'ans_btn_box_shadow' => array(
                'css'       => array(
                    'main'  => ".difl_faq $this->main_css_element div.faq_button a",
                    'hover' => ".difl_faq $this->main_css_element div.faq_button a:hover",
                    'important' => 'all'
                ),
                'toggle_slug'  => 'design_button',
                'tab_slug'     => 'advanced',
            ),
            'ans_img_box_shadow' => array(
                'css' => array(
                    'main'  => ".difl_faq $this->main_css_element div.faq_answer_image",
                    'hover' => ".difl_faq $this->main_css_element div.faq_answer_image:hover",
                ),
                'toggle_slug'  => 'design_answer_img',
                'tab_slug'     => 'advanced',
            )
        );

        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'important' => 'all'
            )
        );

        $advanced_fields['max_width'] = array(
            'css' => array(
                'main'             => ".difl_faq $this->main_css_element",
                'module_alignment' => ".difl_faq $this->main_css_element.et_pb_module",
                'important' => 'all'
            ),
        );

        return $advanced_fields;
    }

    public function before_render()
    {
        $this->props['que_wrapper_bg_bgcolor__hover'] = '1px||||false|false';
        $this->props['que_wrapper_bg_bgcolor__hover_enabled'] = "on|hover";
    }

    public function get_transition_fields_css_props()
    {
        $fields = parent::get_transition_fields_css_props();
        $que_wrapper    = "$this->main_css_element div.df_faq_item .faq_question_wrapper";
        $active_que_wrapper  = "$this->main_css_element .df_faq_item.active .faq_question_wrapper";

        $faq_que_text   = "$this->main_css_element .faq_question_title";
        // $active_faq_que_text = "$this->main_css_element .df_faq_item.active .faq_question_title";

        $icon_wrapper   = "$this->main_css_element div.df_faq_item .faq_icon";
        $active_icon_wrapper = "$this->main_css_element div.df_faq_item.active .faq_icon";
        $close_que_icon = "$this->main_css_element .faq_icon .close_icon span.et-pb-icon";
        $open_que_icon  = "$this->main_css_element .faq_icon .open_icon span.et-pb-icon";

        $que_img_wrapper_bg  = "$this->main_css_element div.df_faq_item .faq_question_image";
        $active_que_img_wrapper_bg = "$this->main_css_element .df_faq_item.active .faq_question_image";
        $que_img        = "$this->main_css_element div.df_faq_item .faq_question_image img";
        $active_que_img = "$this->main_css_element .df_faq_item.active .faq_question_image img";

        // $ans_wrapper    = "$this->main_css_element .faq_answer_wrapper";
        $ans_wrapper    = "$this->main_css_element .faq_answer_area";
        $ans_button     = "$this->main_css_element .faq_button a";

        // Color
        $fields['close_icon_color']  = array('color' => $close_que_icon);
        $fields['open_icon_color']   = array('color' => $open_que_icon);
        $fields['button_text_color'] = array('color' => $ans_button);
        $fields['button_icon_color'] = array('color' => "$this->main_css_element div.faq_button_icon");

        $fields = $this->df_background_transition(array(
            'fields'   => $fields,
            'key'      => 'default_que_wrapper_bg',
            'selector' => $que_wrapper
        ));

        $fields = $this->df_background_transition(array(
            'fields'   => $fields,
            'key'      => 'active_que_wrapper_bg',
            'selector' => $active_que_wrapper
        ));

        $fields['faq_icon_bg']        = array('background-color' => $icon_wrapper);
        $fields['active_faq_icon_bg'] = array('background-color' => $active_icon_wrapper);
        $fields['que_img_bg']         = array('background-color' => $que_img_wrapper_bg);
        $fields['active_que_img_bg']  = array('background-color' => $active_que_img_wrapper_bg);

        $fields = $this->df_background_transition(array(
            'fields'   => $fields,
            'key'      => 'ans_wrapper_bg',
            'selector' => $ans_wrapper
        ));

        $fields = $this->df_background_transition(array(
            'fields'   => $fields,
            'key'      => 'ans_button_bg',
            'selector' => $ans_button
        ));

        // Border
        $fields = $this->df_fix_border_transition($fields, 'que_wrapper_border', $que_wrapper);
        $fields = $this->df_fix_border_transition($fields, 'que_wrapper_border', $que_wrapper);
        $fields = $this->df_fix_border_transition($fields, 'active_que_wrapper_border', $active_que_wrapper);
        // $fields = $this->df_fix_border_transition($fields, 'que_text_border', $faq_que_text);
        // $fields = $this->df_fix_border_transition($fields, 'active_que_text_border', $active_faq_que_text);
        $fields = $this->df_fix_border_transition($fields, 'que_img_wrapper_border', $que_img_wrapper_bg);
        $fields = $this->df_fix_border_transition($fields, 'que_img_border', $que_img);
        $fields = $this->df_fix_border_transition($fields, 'active_que_img_border', $active_que_img);
        $fields = $this->df_fix_border_transition($fields, 'que_icon_wrapper_border', $icon_wrapper);
        $fields = $this->df_fix_border_transition($fields, 'active_que_icon_wrapper_border', $active_icon_wrapper);
        $fields = $this->df_fix_border_transition($fields, 'ans_wrapper_border', $ans_wrapper);
        $fields = $this->df_fix_border_transition($fields, 'ans_img_border', "$this->main_css_element div.faq_answer_image img");
        $fields = $this->df_fix_border_transition($fields, 'ans_button_border', $ans_button);

        // Box Shadow
        $fields = $this->df_fix_box_shadow_transition($fields, 'que_wrapper_box_shadow', $que_wrapper);
        $fields = $this->df_fix_box_shadow_transition($fields, 'que_icon_box_shadow', $icon_wrapper);
        $fields = $this->df_fix_box_shadow_transition($fields, 'active_que_icon_box_shadow', $active_icon_wrapper);
        $fields = $this->df_fix_box_shadow_transition($fields, 'que_img_box_shadow', "$this->main_css_element div.faq_question_image");
        $fields = $this->df_fix_box_shadow_transition($fields, 'active_que_img_box_shadow', "$this->main_css_element div.df_faq_item.active div.faq_question_image");
        $fields = $this->df_fix_box_shadow_transition($fields, 'ans_wrapper_box_shadow', $ans_wrapper);
        $fields = $this->df_fix_box_shadow_transition($fields, 'ans_btn_box_shadow', "$this->main_css_element div.faq_button a");
        $fields = $this->df_fix_box_shadow_transition($fields, 'ans_img_box_shadow', "$this->main_css_element div.faq_answer_image");

        //Spacing
        $fields['faq_item_wrapper_margin']  = array('margin'  => "$this->main_css_element .df_faq_item");
        $fields['faq_item_wrapper_padding'] = array('padding' => "$this->main_css_element .df_faq_item");
        $fields['que_wrapper_margin'] = array('margin'  => $que_wrapper);
        $fields['que_wrapper_padding'] = array('padding' => $que_wrapper);
        $fields['que_text_margin']    = array('margin'  => $faq_que_text);
        $fields['que_text_padding']   = array('padding' => $faq_que_text);
        $fields['que_icon_margin']    = array('margin'  => $icon_wrapper);
        $fields['que_icon_padding']   = array('padding' => $icon_wrapper);
        $fields['que_img_margin']     = array('margin'  => $que_img);
        $fields['que_img_padding']    = array('padding' => $que_img);
        $fields['ans_wrapper_margin'] = array('margin' => "$this->main_css_element $ans_wrapper");
        $fields['ans_wrapper_padding'] = array('padding' => "$this->main_css_element $ans_wrapper");
        $fields['ans_text_padding'] = array('padding'   => "$this->main_css_element div.faq_answer");
        $fields['ans_img_padding']  = array('padding'   => "$this->main_css_element div.faq_answer_image img");
        $fields['ans_button_margin']  = array('margin' => $ans_button);
        $fields['ans_button_padding'] = array('padding' => $ans_button);

        return $fields;
    }

    public function additional_css_styles($render_slug)
    {

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'default_que_wrapper_bg',
                'selector'    => "$this->main_css_element div.df_faq_item .faq_question_wrapper",
                'hover'       => "$this->main_css_element div.df_faq_item .faq_question_wrapper:hover",
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'active_que_wrapper_bg',
                'selector'    => "$this->main_css_element div.df_faq_item.active .faq_question_wrapper",
                'hover'       => "$this->main_css_element div.df_faq_item.active .faq_question_wrapper:hover",
            )
        );

        // $this->df_process_bg(
        //     array(
        //         'render_slug' => $render_slug,
        //         'slug'        => 'ans_wrapper_bg',
        //         'selector'    => "$this->main_css_element div.faq_answer_wrapper",
        //         'hover'       => "$this->main_css_element div.faq_answer_wrapper:hover",
        //     )
        // );
        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'ans_wrapper_bg',
                'selector'    => "$this->main_css_element div.faq_answer_area",
                'hover'       => "$this->main_css_element div.faq_answer_area:hover",
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'faq_icon_bg',
                'type'        => 'background-color',
                'selector'    => "$this->main_css_element div.df_faq_item div.faq_icon",
                'hover'       => "$this->main_css_element div.df_faq_item div.faq_question_wrapper:hover div.faq_icon"
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'active_faq_icon_bg',
                'type'        => 'background-color',
                'selector'    => "$this->main_css_element div.df_faq_item.active div.faq_icon",
                'hover'       => "$this->main_css_element div.df_faq_item.active div.faq_question_wrapper:hover div.faq_icon"
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'close_icon_color',
                'type'        => 'color',
                'selector'    => "$this->main_css_element div.faq_question_wrapper div.faq_icon div.close_icon span.et-pb-icon, $this->main_css_element div.faq_question_wrapper div.faq_icon div.open_icon span.et-pb-icon",
                'hover'       => "$this->main_css_element div.faq_question_wrapper:hover div.faq_icon div.close_icon span.et-pb-icon, $this->main_css_element div.faq_question_wrapper:hover div.faq_icon div.open_icon span.et-pb-icon",
                'important'   => false,
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'open_icon_color',
                'type'        => 'color',
                'selector'    => "$this->main_css_element div.faq_question_wrapper div.faq_icon div.open_icon span.et-pb-icon",
                'hover'       => "$this->main_css_element div.faq_question_wrapper:hover div.faq_icon div.open_icon span.et-pb-icon",
                'important'   => true,
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'que_img_bg',
                'type'        => 'background-color',
                'selector'    => "$this->main_css_element div.df_faq_item div.faq_question_image",
                'hover'       => "$this->main_css_element div.df_faq_item div.faq_question_wrapper:hover div.faq_question_image",
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'active_que_img_bg',
                'type'        => 'background-color',
                'selector'    => "$this->main_css_element div.df_faq_item.active .faq_question_image",
                'hover'       => "$this->main_css_element div.df_faq_item.active div.faq_question_wrapper:hover .faq_question_image"
            )
        );

        $this->df_process_bg(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'ans_button_bg',
                'selector'    => "$this->main_css_element div.faq_button a",
                'hover'       => "$this->main_css_element div.faq_button a:hover"
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'       => 'button_text_color',
                'type'       => 'color',
                'selector'   => "$this->main_css_element div.faq_button a",
                'hover'      => "$this->main_css_element div.faq_button a:hover"
            )
        );

        $this->df_process_color(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'button_icon_color',
                'type'        => 'color',
                'selector'    => "$this->main_css_element div.faq_button_icon",
                'hover'       => "$this->main_css_element div.faq_button a:hover div.faq_button_icon"
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'faq_item_wrapper_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element div.df_faq_item",
                'hover'       => "$this->main_css_element div.df_faq_item:hover",
                'important'   => true
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'faq_item_wrapper_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element div.df_faq_item",
                'hover'       => "$this->main_css_element div.df_faq_item:hover",
                'important'   => true
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'que_wrapper_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element div.faq_question_wrapper",
                'hover'       => "$this->main_css_element div.faq_question_wrapper:hover",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'que_wrapper_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element div.faq_question_wrapper",
                'hover'       => "$this->main_css_element div.faq_question_wrapper:hover",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'que_text_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element div.faq_question_wrapper .faq_question_title",
                'hover'       => "$this->main_css_element div.faq_question_wrapper:hover .faq_question_title",
                'important'   => true
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'que_icon_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element div.faq_icon",
                'hover'       => "$this->main_css_element div.faq_question_wrapper:hover div.faq_icon",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'       => 'que_icon_padding',
                'type'       => 'padding',
                'selector'   => "$this->main_css_element div.faq_icon",
                'hover'      => "$this->main_css_element div.faq_question_wrapper:hover div.faq_icon",
                'important'  => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'       => 'que_img_margin',
                'type'       => 'margin',
                'selector'   => "$this->main_css_element div.faq_question_image ",
                'hover'      => "$this->main_css_element div.faq_question_wrapper:hover div.faq_question_image",
                'important'  => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'       => 'que_img_padding',
                'type'       => 'padding',
                'selector'   => "$this->main_css_element div.faq_question_image",
                'hover'      => "$this->main_css_element div.faq_question_wrapper:hover div.faq_question_image",
                'important'  => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'       => 'ans_wrapper_margin',
                'type'       => 'margin',
                'selector'   => "$this->main_css_element div.faq_answer_wrapper div.faq_answer_area",
                'hover'      => "$this->main_css_element div.faq_answer_wrapper div.faq_answer_area:hover",
                'important'  => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'       => 'ans_wrapper_padding',
                'type'       => 'padding',
                'selector'   => "$this->main_css_element div.faq_answer_wrapper div.faq_answer_area",
                'hover'      => "$this->main_css_element div.faq_answer_wrapper div.faq_answer_area:hover",
                'important'  => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'ans_text_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element div.faq_answer",
                'hover'       => "$this->main_css_element div.faq_answer:hover",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'ans_img_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element div.faq_answer_image img",
                'hover'       => "$this->main_css_element div.faq_answer_image img:hover",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'ans_button_margin',
                'type'        => 'margin',
                'selector'    => "$this->main_css_element div.faq_button a",
                'hover'       => "$this->main_css_element div.faq_button a:hover",
                'important'   => false
            )
        );

        $this->set_margin_padding_styles(
            array(
                'render_slug' => $render_slug,
                'slug'        => 'ans_button_padding',
                'type'        => 'padding',
                'selector'    => "$this->main_css_element div.faq_button a",
                'hover'       => "$this->main_css_element div.faq_button a:hover",
                'important'   => false
            )
        );

        // Button icon
        if ('on' === $this->props['use_button_icon']) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'button_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.faq_button_icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon'
                    )
                )
            );

            $this->df_process_color(
                array(
                    'render_slug'  => $render_slug,
                    'slug'         => 'button_icon_color',
                    'type'         => 'color',
                    'selector'     => "%%order_class%% .faq_button a .et-pb-icon",
                    'hover'        => '%%order_class%% .faq_button a:hover .et-pb-icon'
                )
            );

            $this->df_process_range(
                array(
                    'render_slug'  => $render_slug,
                    'slug'         => 'button_icon_size',
                    'type'         => 'font-size',
                    'selector'     => "%%order_class%% .faq_button .et-pb-icon"
                )
            );

            // show icon on hover
            if ('off' !== $this->props['show_icon_hover']) {
                $icon_size = "" !== $this->props['button_icon_size'] ? $this->props['button_icon_size'] : "18px";
                $icon_space = "" !== $this->props['button_icon_space'] ? $this->props['button_icon_space'] : "0px";
                $icon_wrapper_width = intval(substr($icon_size, 0, -2)) + intval(substr($icon_space, 0, -2));

                if ('left' !== $this->props['button_icon_placement']) {
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "$this->main_css_element .faq_answer_wrapper .faq_button.icon_show_hover .faq_button_icon",
                        'declaration' => "margin: 0px; margin-right: -" . $icon_wrapper_width . " !important; opacity: 0 !important;"
                    ));

                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "$this->main_css_element .faq_answer_wrapper .faq_button.icon_show_hover:hover .faq_button_icon",
                        'declaration' => "margin-right:0px !important; opacity: 1 !important;"
                    ));
                } else {
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "$this->main_css_element .faq_answer_wrapper .faq_button.icon_show_hover .faq_button_icon",
                        'declaration' => "margin-left: -" . $icon_wrapper_width . "px !important; opacity: 0 !important;"
                    ));

                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "$this->main_css_element .faq_answer_wrapper .faq_button.icon_show_hover:hover .faq_button_icon",
                        'declaration' => "margin: 0px; margin-left:0px !important; opacity: 1 !important;"
                    ));
                }
            }

            if ("left" === $this->props['button_icon_placement']) {
                $this->df_process_range(
                    array(
                        'render_slug' => $render_slug,
                        'slug'        => 'button_icon_space',
                        'type'        => 'margin-right',
                        // 'default'     => '5px',
                        'selector'    => "$this->main_css_element .faq_answer_wrapper .faq_button .faq_button_icon",
                        'hover'       => "$this->main_css_element .faq_answer_wrapper .faq_button:hover .faq_button_icon",
                    )
                );
            } else {
                $this->df_process_range(
                    array(
                        'render_slug' => $render_slug,
                        'slug'        => 'button_icon_space',
                        'type'        => 'margin-left',
                        // 'default'     => '5px',
                        'selector'    => "$this->main_css_element .faq_answer_wrapper .faq_button .faq_button_icon",
                        'hover'       => "$this->main_css_element .faq_answer_wrapper .faq_button:hover .faq_button_icon",
                    )
                );
            }
        }

        // question image placement
        if ('inherit' !== $this->props['question_image_placement']) {
            $this->generate_styles(
                array(
                    'base_attr_name' => 'question_image_placement',
                    'selector'       => "$this->main_css_element .faq_question_area",
                    'css_property'   => 'flex-direction',
                    'render_slug'    => $render_slug,
                    'type'           => 'align',
                    'important'      => true
                )
            );
        }

        // answer image placement
        $this->generate_styles(
            array(
                'base_attr_name' => 'answer_image_placement',
                'selector'       => "$this->main_css_element .faq_content",
                'css_property'   => 'flex-flow',
                'render_slug'    => $render_slug,
                'type'           => 'align',
                'important'      => true
            )
        );

        // answer image container width
        // if (!empty($this->props['answer_image_width'])) {
        if ('row-reverse' === $this->props['answer_image_placement'] || 'row' === $this->props['answer_image_placement']) {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'answer_image_width',
                'type'              => 'width',
                'selector'          => "$this->main_css_element .faq_answer_image",
                'default'           => '50%',
                // 'unit'              => '%',
            ));

            $content_width = 100 - intval($this->props['answer_image_width']);
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .faq_answer",
                'declaration' => "width: $content_width%;"
            ));
        } else {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'answer_image_width',
                'type'              => 'width',
                'selector'          => "$this->main_css_element .faq_answer_image",
                'default'           => '100%',
            ));

            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'answer_image_width_top_bottom',
                'type'              => 'width',
                'selector'          => "$this->main_css_element .faq_answer_image",
                'default'           => '100%',
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .faq_answer,$this->main_css_element .faq_answer_image img",
                'declaration' => "width:100%;"
            ));
        }

        if ('row-reverse' === $this->props['answer_image_placement'] || 'row' === $this->props['answer_image_placement']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .faq_content",
                'declaration' => 'align-items: start;'
            ));
        } else {
            $this->df_set_flex_position([
                'render_slug' => $render_slug,
                'slug'        => 'answer_image_alignment',
                'selector'    => "$this->main_css_element .faq_content",
                'type'        => "align-items"
            ]);
        }

        // full width on image placement left/right
        if ("on" === $this->props['answer_image_full_width_mobile']) {
            // ET_Builder_Element::set_style($render_slug, array(
            //     'selector'    => "$this->main_css_element .faq_answer_wrapper",
            //     'declaration' => 'height: fit-content !important;',
            //     'media_query' => self::get_media_query('max_width_767')
            // ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .faq_content",
                'declaration' => 'flex-flow: column-reverse !important;',
                'media_query' => self::get_media_query('max_width_767')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .faq_answer",
                'declaration' => 'width: 100% !important;',
                'media_query' => self::get_media_query('max_width_767')
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .faq_answer_image",
                'declaration' => 'width: 100% !important;',
                'media_query' => self::get_media_query('max_width_767')
            ));
        }

        $display_btn = "on" === $this->props['button_full_width'] ? "block" : "inline-flex";
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "$this->main_css_element div.faq_button a",
            'declaration' => "display: $display_btn;"
        ));

        if("on" === $this->props['button_full_width']){
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .faq_button_icon",
                'declaration' => "vertical-align: middle;"
            ));
        }

        if ('on' !== $this->props['button_full_width'] &&  '' !== $this->props['button_alignment']) {
            $this->df_process_string_attr(array(
                'render_slug' => $render_slug,
                'slug'        => 'button_alignment',
                'type'        => 'text-align',
                'selector'    => "%%order_class%% div.faq_button"
            ));
        }
    }

    public function df_render_question()
    {
        $close_q_img = !empty($this->props['close_question_image']) ? $this->props['close_question_image'] : "";
        $close_q_img_alt = !empty($this->props['close_que_img_alt_txt']) ? $this->props['close_que_img_alt_txt'] : "";
        $open_q_img = !empty($this->props['open_question_image']) ? $this->props['open_question_image'] : $close_q_img;
        $open_q_img_alt = !empty($this->props['open_que_img_alt_txt']) ? $this->props['open_que_img_alt_txt'] : $close_q_img_alt;
        $que_img_html = 'on' === $this->props['enable_question_image'] && (!empty($this->props['close_question_image']) || !empty($this->props['open_question_image'])) ?
            sprintf(
                '<div class="faq_question_image">
                <div class="close_image">%1$s</div>
                <div class="open_image">%2$s</div>
                </div>',
                $this->df_render_faq_image($close_q_img, $close_q_img_alt),
                $this->df_render_faq_image($open_q_img, $open_q_img_alt)
            ) : '';

        $que_title_tag = esc_attr($this->props['question_title_tag']);

        $que_html = "" !== $this->props['question'] ?
            sprintf(
                '<div class="faq_question"><%1$s class="faq_question_title">%2$s</%1$s></div>',
                '' !== $que_title_tag ? $que_title_tag : "h3",
                $this->props['question'] ? $this->props['question'] : ""
            ) : '';

        $icon_html =  sprintf(
            '<div class="faq_icon">%1$s</div>',
            $this->df_render_faq_toggle_icon()
        );

        $output = sprintf(
            '<div class="faq_question_wrapper">
                <div class="faq_question_area">
                    %1$s
                    %2$s
                </div>
                %3$s
            </div>
          ',
            $que_img_html,
            $que_html,
            $icon_html
        );

        return $output;
    }

    public function df_render_answer()
    {
        $ans_btn = $this->props['enable_answer_button'] ? $this->df_render_button() : "";
        $ans_html = $this->props['content'] !== '' ? sprintf('<div class="faq_answer"><div>%1$s</div> %2$s</div>',  $this->props['content'], $ans_btn) : '';
        $ans_img = !empty($this->props['answer_image']) ? $this->props['answer_image'] : '';
        $ans_img_html  = 'on' === $this->props['enable_answer_image'] ?
            sprintf(
                '<div class="faq_answer_image">%1$s</div>',
                $this->df_render_faq_image($ans_img, $this->props['answer_image_alt_text'])
            ) : "";

        $output = sprintf(
            '<div class="faq_answer_wrapper">
                <div class="faq_answer_area">
                   <div class="faq_content">
                        %1$s
                        %2$s
                   </div>
                </div>
            </div>',
            $ans_html,
            $ans_img_html
        );

        return $output;
    }

    public function df_render_faq_image($img_prop, $img_alt)
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

    public function df_render_faq_toggle_icon()
    {
        $close_faq_icon = !empty($this->parent_faq->props['close_faq_icon']) ?  esc_attr(et_pb_process_font_icon($this->parent_faq->props['close_faq_icon'])) : '5';
        $open_faq_icon = !empty($this->parent_faq->props['open_faq_icon']) ?  esc_attr(et_pb_process_font_icon($this->parent_faq->props['open_faq_icon'])) : '5';

        if (!empty($close_faq_icon)) {
            return sprintf(
                '<div class="close_icon"><span class="et-pb-icon">%1$s</span></div>
                <div class="open_icon"><span class="et-pb-icon">%2$s</span></div>',
                $close_faq_icon,
                $open_faq_icon
            );
        }
    }

    public function df_render_button()
    {
        $text = isset($this->props['button_text']) ? $this->props['button_text'] : '';
        $url = isset($this->props['button_url']) ? $this->props['button_url'] : '';
        $target = $this->props['button_url_new_window'] === 'on' ? 'target="_blank"' : '';

        $button_font_icon = $this->props['button_font_icon'];
        $button_icon_pos = $this->props['button_icon_placement'];
        $icon_show_hover = "on" === $this->props['show_icon_hover'] ? "icon_show_hover" : "";

        // Button icon
        $button_icon = $this->props['use_button_icon'] !== 'off' ? sprintf(
            '<span class="et-pb-icon faq_button_icon">%1$s</span>',
            $button_font_icon !== '' ? esc_attr(et_pb_process_font_icon($button_font_icon)) : '5'
        ) : '';
        if ('on' === $this->props['enable_answer_button']) {
            return sprintf(
                '<div class="faq_button %6$s %7$s">
                    <a href="%1$s" %3$s data-icon="5">%5$s <span>%2$s</span> %4$s</a>
                </div>',
                esc_attr($url),
                esc_html(trim($text)),
                $target,
                $button_icon_pos === 'right' ? $button_icon : '',
                $button_icon_pos === 'left' ? $button_icon : '',
                $icon_show_hover,
                "left" !== $button_icon_pos ? "right" : "left"
            );
        } else {
            return '';
        }
    }

    // set checkbox value to devices
    public function df_multicheck_value($cehckbox_values)
    {
        if (!empty($cehckbox_values)) {
            $values = explode("|", $cehckbox_values);
            $devices = ['desktop', 'tablet', 'mobile'];
            $single_devices = [];

            for ($i = 0; $i < count($values); $i++) {
                if ("on" === $values[$i]) {
                    $single_devices[$devices[$i]] = $values[$i];
                }
            }
            return $single_devices;
        }
        return "";
    }


    // text to flex conversion
    public function df_set_flex_position($options)
    {
        $defaults = [
            'render_slug' => '',
            'slug'        => '',
            'selector'    => '',
            'type'        => '',
            'css'         => '',
        ];

        $options = wp_parse_args($options, $defaults);
        $get_values = ["center", "left", "right"];
        $set_values = ["center", "start", "end"];
        $values = [];

        foreach ($get_values as $key => $value) {
            $values[$value] = $set_values[$key];
        }

        if (array_key_exists($options['slug'], $this->props) && !empty($this->props[$options['slug']])) {
            $desktop = $this->props[$options['slug']];
            self::set_style($options['render_slug'], array(
                'selector'    => $options['selector'],
                'declaration' => sprintf('display: flex;%1$s:%2$s;%3$s;', $options['type'], $values[$desktop], $options['css'])
            ));
        }

        if (array_key_exists($options['slug'], $this->props) && !empty($this->props[$options['slug'] . "_tablet"])) {
            $tablet = $this->props[$options['slug'] . "_tablet"];
            self::set_style($options['render_slug'], array(
                'selector'    => $options['selector'],
                'declaration' => sprintf('display: flex;%1$s:%2$s;%3$s;', $options['type'], $values[$tablet], $options['css']),
                'media_query' => self::get_media_query('max_width_980')
            ));
        }

        if (array_key_exists($options['slug'], $this->props) && !empty($this->props[$options['slug'] . "_phone"])) {
            $phone = $this->props[$options['slug'] . "_phone"];
            self::set_style($options['render_slug'], array(
                'selector'    => $options['selector'],
                'declaration' => sprintf('display: flex;%1$s:%2$s;%3$s;', $options['type'], $values[$phone], $options['css']),
                'media_query' => self::get_media_query('max_width_767')
            ));
        }
    }

    public function render($attrs, $content, $render_slug)
    {
		$this->handle_fa_icon();
        // Scripts
        wp_enqueue_script('animejs');
        wp_enqueue_script('df_faq');

        // Get all styles
        $this->additional_css_styles($render_slug);

        // Schema Data
        global $df_faq_schema_data;
        $df_faq_class = ET_Builder_Element::get_module_order_class($render_slug);
        $df_faq_schema_data[$df_faq_class]['question'] = wp_strip_all_tags($this->props['question']);
        $df_faq_schema_data[$df_faq_class]['content'] = $this->props['content'];

        // JS data
        $data_settings = [
            'hide_faq_item' => $this->df_multicheck_value($this->props['hide_faq_item']),
        ];

        $output = sprintf(
            '<div class="df_faq_item" data-settings=\'%3$s\'>
                %1$s
                %2$s
            </div>',
            $this->df_render_question(),
            $this->df_render_answer($render_slug),
            wp_json_encode($data_settings)
        );

        return $output;
    }
} //Class

new DIFL_FaqItem;
