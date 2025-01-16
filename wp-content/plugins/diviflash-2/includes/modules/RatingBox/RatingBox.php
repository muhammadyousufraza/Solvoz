<?php
if (!class_exists('ET_Builder_Element')) {
    return;
}

class DIFL_RatingBox extends ET_Builder_Module
{
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_ratingbox';
    public $vb_support = 'on';
    use DF_UTLS;

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'DiviFlash',
        'author_uri' => '',
    );

    public function init()
    {
        $this->name = esc_html__('Star Rating', 'divi_flash');
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/star-rating.svg';
    }

    public function get_settings_modal_toggles()
    {
        // All sub toggles
        $content_sub_toggles = array(
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
        );
        $heading_sub_toggles = array(
            'h1' => array(
                'name' => 'H1',
                'icon' => 'text-h1',
            ),
            'h2' => array(
                'name' => 'H2',
                'icon' => 'text-h2',
            ),
            'h3' => array(
                'name' => 'H3',
                'icon' => 'text-h3',
            ),
            'h4' => array(
                'name' => 'H4',
                'icon' => 'text-h4',
            ),
            'h5' => array(
                'name' => 'H5',
                'icon' => 'text-h5',
            ),
            'h6' => array(
                'name' => 'H6',
                'icon' => 'text-h6',
            ),
        );

        return array(
            'general'   => array(
                'toggles'      => array(
                    'rating'      => esc_html__('Rating', 'divi_flash'),
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'design_rating'                => esc_html__('Rating', 'divi_flash'),
                    'design_rating_number'         => esc_html__('Rating Number', 'divi_flash'),
                    'design_title'                 => esc_html__('Title Style', 'divi_flash'),
                    'design_content'               => esc_html__('Content Style', 'divi_flash'),
                    'design_content_text'          => array(
                        'title' => esc_html__('Content Text', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => $content_sub_toggles,
                    ),
                    'design_content_heading'       => array(
                        'title' => esc_html__('Content Heading Text', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => $heading_sub_toggles,
                    ),
                    'custom_spacing'        => esc_html__('Custom Spacing', 'divi_flash'),
                )
            )
        );
    }

    public function get_fields()
    {
        $rating = [
            'rating_scale_type'   => array(
                'label'           => esc_html__('Rating Scale Type', 'divi_flash'),
                'description'     => esc_html__('Choose Rating Scale Type', 'divi_flash'),
                'type'            => 'select',
                'default'         => '5',
                'options'         => array(
                    '5'   => esc_html__('0-5', 'divi_flash'),
                    '10'  => esc_html__('0-10', 'divi_flash'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'rating'
            ),

            'rating_value_5' => array(
                'label'             => esc_html__('Rating Value', 'divi_flash'),
                'description'       => esc_html__('Set Rating Value', 'divi_flash'),
                'type'              => 'range',
                'default'           => '5',
                'range_settings'    => array(
                    'min'       => '0.1',
                    'max'       => '5',
                    'step'      => '0.1',
                    'min_limit' => '0',
                    'max_limit' => '5'
                ),
                'toggle_slug'   => 'rating',
                'show_if'       => array(
                    'rating_scale_type'     => '5'
                )
            ),

            'rating_value_10' => array(
                'label'             => esc_html__('Rating Value', 'divi_flash'),
                'description'       => esc_html__('Set Rating Value', 'divi_flash'),
                'type'              => 'range',
                'default'           => '10',
                'range_settings'    => array(
                    'min'       => '0.1',
                    'max'       => '10',
                    'step'      => '0.1',
                    'min_limit' => '0',
                    'max_limit' => '10'
                ),
                'toggle_slug'     => 'rating',
                'show_if'         => array(
                    'rating_scale_type'     => '10'
                )
            ),

            // Custom icon
            'enable_custom_icon'  => array(
                'label'             => esc_html__('Use Custom Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'rating',
            ),

            'rating_icon'          => array(
                'label'            => esc_html__('Rating Icon', 'divi_flash'),
                'type'             => 'select_icon',
                'option_category'  => 'basic_option',
                'default'          => '☆',
                'class'            => array('et-pb-font-icon'),
                'toggle_slug'      => 'rating',
                'show_if'          => array(
                    'enable_custom_icon'     => 'on',
                )
            ),

            'rating_color_single' => array(
                'label'           => esc_html__('Rating Icon Color', 'divi_flash'),
                'type'            => 'color-alpha',
                'hover'           => 'tabs',
                'option_category' => 'basic_option',
                'default'         => '#E02B20',
                'toggle_slug'     => 'design_rating',
                'tab_slug'        => 'advanced',
                'show_if'         => array(
                    'enable_single_rating'     => 'on',
                ),
            ),

            'rating_color_active' => array(
                'label'           => esc_html__('Active Rating Icon color', 'divi_flash'),
                'type'            => 'color-alpha',
                'hover'           => 'tabs',
                'option_category' => 'basic_option',
                'default'         => '#E02B20',
                'toggle_slug'     => 'design_rating',
                'tab_slug'        => 'advanced',
                'show_if_not'     => array(
                    'enable_single_rating'     => 'on',
                ),
            ),

            'rating_color_inactive' => array(
                'label'           => esc_html__('Inactive Rating Icon color', 'divi_flash'),
                'type'            => 'color-alpha',
                'hover'           => 'tabs',
                'option_category' => 'basic_option',
                'default'         => '#000',
                'toggle_slug'     => 'design_rating',
                'tab_slug'        => 'advanced',
                'show_if_not'     => array(
                    'enable_single_rating'     => 'on',
                ),
            ),

            // Rating Number
            'enable_rating_number' => array(
                'label'            => esc_html__('Show Rating number', 'divi_flash'),
                'type'             => 'yes_no_button',
                'options'          => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'          => 'off',
                'toggle_slug'      => 'rating',
            ),

            'rating_number_type'  => array(
                'label'           => esc_html__('Rating Number Type', 'divi_flash'),
                'type'            => 'select',
                'default'         => 'number_with_bracket',
                'options'         => array(
                    'number_with_bracket'  => esc_html__('Number With Bracket', 'divi_flash'),
                    'number_without_bracket'   => esc_html__('Number Without Bracket', 'divi_flash'),
                    'number_single_value'   => esc_html__('Number Single Value', 'divi_flash'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'rating',
                'show_if'         => array(
                    'enable_rating_number' => 'on'
                ),
                'show_if_not'         => array(
                    'enable_single_rating' => 'on'
                ),
            ),

            'rating_number_placement_left_right' => array(
                'label'           => esc_html__('Rating Number Placement', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'right'  => esc_html__('Right', 'divi_flash'),
                    'left'   => esc_html__('Left', 'divi_flash'),
                ),
                'default'         => 'right',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'rating',
                'show_if'         => array(
                    'enable_rating_number'     => 'on'
                ),
            ),

            // Single
            'enable_single_rating'  => array(
                'label'             => esc_html__('Enable Single Rating', 'divi_flash'),
                'type'              => 'yes_no_button',
                'default'           => 'off',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'toggle_slug'       => 'rating',
            ),

            // Title
            'enable_title'  => array(
                'label'             => esc_html__('Enable Title', 'divi_flash'),
                'description'       => esc_html__('Enable Rating box title.', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'rating',
            ),

            'title' => array(
                'label'           => esc_html__('Title', 'divi_flash'),
                'type'            => 'text',
                'dynamic_content' => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'rating',
                'show_if'         => array(
                    'enable_title'     => 'on'
                )
            ),

            'rating_title_tag'    => array(
                'label'           => esc_html__('Title Tag', 'divi_flash'),
                'description'     => esc_html__('Choose a tag to display your title.', 'divi_flash'),
                'type'            => 'select',
                'option_category' => 'layout',
                'options'         => array(
                    'h1'   => esc_html__('H1 tag', 'divi_flash'),
                    'h2'   => esc_html__('H2 tag', 'divi_flash'),
                    'h3'   => esc_html__('H3 tag', 'divi_flash'),
                    'h4'   => esc_html__('H4 tag', 'divi_flash'),
                    'h5'   => esc_html__('H5 tag', 'divi_flash'),
                    'h6'   => esc_html__('H6 tag', 'divi_flash'),
                    'p'    => esc_html__('P tag', 'divi_flash'),
                    'span' => esc_html__('Span tag', 'divi_flash'),
                    'div'  => esc_html__('Div tag', 'divi_flash'),
                ),
                'toggle_slug'      => 'rating',
                'default'          => 'h4',
                'show_if'          => array(
                    'enable_title' => 'on'
                )
            ),

            'title_display_type'  => array(
                'label'           => esc_html__('Title Display Type', 'divi_flash'),
                'type'            => 'select',
                'default'         => 'block',
                'options'         => array(
                    'block'  => esc_html__('Block', 'divi_flash'),
                    'inline' => esc_html__('Inline', 'divi_flash'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'rating',
                'show_if'         => array(
                    'enable_title' => 'on'
                )
            ),

            'title_placement_top_bottom' => array(
                'label'           => esc_html__('Title Placement', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(
                    'top'    => esc_html__('Top', 'divi_flash'),
                    'bottom' => esc_html__('Bottom', 'divi_flash'),
                ),
                'default'         => 'top',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'rating',
                'show_if'         => array(
                    'title_display_type'     => 'block',
                    'enable_title' => 'on'
                )
            ),

            'title_placement_left_right' => array(
                'label'           => esc_html__('Title Placement', 'divi_flash'),
                'type'            => 'select',
                'options'         => array(

                    'right'  => esc_html__('Right', 'divi_flash'),
                    'left'   => esc_html__('Left', 'divi_flash'),
                ),
                'default'         => 'left',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'rating',
                'show_if'         => array(
                    'enable_title'       => 'on',
                    'title_display_type' => 'inline'
                )
            ),

            'rating_icon_align'   => array(
                'label'           => esc_html__('Rating Alignment', 'divi_flash'),
                'type'            => 'text_align',
                'option_category' => 'configuration',
                'options'         => et_builder_get_text_orientation_options(
                    array('justified')
                ),
                'toggle_slug'     => 'design_rating',
                'tab_slug'        => 'advanced',
                'default'         => 'center',
                'options_icon'    => 'module_align',
                'mobile_options'  => true,
            ),

            'rating_icon_size' => array(
                'label'             => esc_html__('Rating Icon Size', 'divi_flash'),
                'type'              => 'range',
                'default'           => '30px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '100',
                    'step' => '1',
                    'min_limit' => '1',
                ),
                'toggle_slug'   => 'design_rating',
                'tab_slug'      => 'advanced',
                'mobile_options'  => true
            ),

            'rating_icon_space' => array(
                'label'             => esc_html__('Space between rating icons', 'divi_flash'),
                'type'              => 'range',
                'hover'             => 'tabs',
                'responsive'        => true,
                'default'           => '0px',
                'default_unit'           => '0px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'       => '0',
                    'max'       => '100',
                    'step'      => '1',
                    'min_limit' => '0'
                ),
                'toggle_slug'       => 'design_rating',
                'tab_slug'          => 'advanced',
                'show_if_not'       => array(
                    'enable_single_rating' => 'on'
                ),
                'mobile_options'  => true
            )
        ];

        $content = [
            'enable_content'  => array(
                'label'           => esc_html__('Enable Content', 'divi_flash'),
                'description'     => esc_html__('Enable rating box content.', 'divi_flash'),
                'type'            => 'yes_no_button',
                'options'         => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'         => 'off',
                'toggle_slug'     => 'rating',
            ),
            'content' => array(
                'label'           => esc_html__('Content', 'divi_flash'),
                'type'            => 'tiny_mce',
                'dynamic_content' => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Rating box description.', 'divi_flash'),
                'toggle_slug'     => 'rating',
                'show_if'         => array(
                    'enable_content'     => 'on'
                )
            )
        ];

        $schema = [
            'enable_schema'  => array(
                'label'             => esc_html__('Enable Schema', 'divi_flash'),
                'description'       => esc_html__('Enable Schema for SEO', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'rating',
            )
        ];

        $rating_bg = $this->df_add_bg_field(array(
            'label'                 => 'Rating Background',
            'key'                   => 'rating_bg',
            'toggle_slug'           => 'design_rating',
            'tab_slug'              => 'advanced'
        ));

        $rating_title_bg = $this->df_add_bg_field(array(
            'label'                 => 'Rating Title Background',
            'key'                   => 'rating_title_bg',
            'toggle_slug'           => 'design_title',
            'tab_slug'              => 'advanced',
            'show_if'         => array(
                'enable_title'     => 'on'
            )
        ));

        $rating_content_bg = $this->df_add_bg_field(array(
            'label'                 => 'Rating Content Background',
            'key'                   => 'rating_content_bg',
            'toggle_slug'           => 'design_content',
            'tab_slug'              => 'advanced',
            'show_if' => array(
                'enable_content'    => 'on'
            )
        ));

        $rating_margin = $this->add_margin_padding(array(
            'title'             => 'Rating',
            'key'               => 'rating_wrapper',
            'toggle_slug'       => 'margin_padding'
        ));

        $rating_number_margin = $this->add_margin_padding(array(
            'title'             => 'Rating Number',
            'key'               => 'rating_box_number',
            'toggle_slug'       => 'margin_padding',
            'option'            => 'margin',
            'show_if' => array(
                'enable_rating_number'     => 'on'
            )
        ));

        $rating_title_margin = $this->add_margin_padding(array(
            'title'             => 'Rating Title',
            'key'               => 'rating_box_title',
            'toggle_slug'       => 'margin_padding',
            'show_if'           => array(
                'enable_title'     => 'on'
            )
        ));

        $rating_content_margin = $this->add_margin_padding(array(
            'title'             => 'Rating Content',
            'key'               => 'rating_box_content',
            'toggle_slug'       => 'margin_padding',
            'show_if'           => array(
                'enable_content'     => 'on'
            )
        ));

        return array_merge(
            $rating_bg,
            $rating,
            $rating_title_bg,
            $rating_content_bg,
            $content,
            $schema,
            $rating_margin,
            $rating_number_margin,
            $rating_title_margin,
            $rating_content_margin
        );
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = array();

        // Disable fields
        $advanced_fields['text'] = false;

        $advanced_fields['fonts'] = [

            'rating'   => array(
                'label'              => esc_html__('Rating', 'divi_flash'),
                'toggle_slug'        => 'design_rating',
                'tab_slug'           => 'advanced',
                'hide_font'          => true,
                'hide_font_size'     => true,
                'hide_line_height'   => true,
                'hide_text_color'    => true,
                'hide_text_align'    => true,
                'hide_letter_spacing' => true,
                'css'      => array(
                    'main' => "$this->main_css_element .df_rating_icon .et-pb-icon, $this->main_css_element span.df_rating_icon_fill::before, $this->main_css_element span.df_rating_icon_empty::after",
                    'hover' => "$this->main_css_element .df_rating_icon .et-pb-icon:hover, $this->main_css_element span.df_rating_icon_fill:hover::before, $this->main_css_element span.df_rating_icon_empty:hover::after"
                )
            ),

            'rating_number'         => array(
                'label'             => esc_html__('Rating Number', 'divi_flash'),
                'toggle_slug'       => 'design_rating_number',
                'tab_slug'          => 'advanced',
                'hide_line_height'  => true,
                'hide_text_align'   => true,
                'font_size'   => array(
                    'default' => '20px',
                ),
                'font-weight' => array(
                    'default' => 'normal'
                ),
                'css'       => array(
                    'main'  => "$this->main_css_element span.df_rating_number, $this->main_css_element .df_rating_bracket",
                    'hover' => "$this->main_css_element span.df_rating_number:hover, $this->main_css_element .df_rating_bracket:hover",
                    'important' => 'all',
                )
            ),

            'title'   => array(
                'label'         => esc_html__('Title', 'divi_flash'),
                'toggle_slug'   => 'design_title',
                'tab_slug'      => 'advanced',
                'line_height' => array(
                    'default' => '1.7em',
                ),
                'font_size'   => array(
                    'default' => '20px',
                ),
                'font-weight' => array(
                    'default' => 'normal'
                ),
                'css' => array(
                    'main'  => "$this->main_css_element .df_rating_title",
                    'hover' => "$this->main_css_element .df_rating_title:hover",
                    'important' => 'all'
                )
            ),

            'design_content_text'   => array(
                'label'       => esc_html__('Content', 'divi_flash'),
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
                    'main'  => "$this->main_css_element .df_rating_content",
                    'hover' => "$this->main_css_element .df_rating_content",
                    'important' => 'all',
                ),
                // Content design
                'block_elements' => array(
                    'tabbed_subtoggles' => true,
                    'bb_icons_support'  => true,
                    'css'               => array(
                        'main'  => "$this->main_css_element .df_rating_content",
                        'hover' => "$this->main_css_element .df_rating_content:hover",
                    ),
                ),
            )

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
                'main'    => "$this->main_css_element .df_rating_content h1",
                'hover'   => "$this->main_css_element .df_rating_content h1:hover",
            ),
            'toggle_slug' => 'design_content_heading',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'h1',
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
                'main'    => "$this->main_css_element .df_rating_content h2",
                'hover'   => "$this->main_css_element .df_rating_content h2:hover",
            ),
            'tab_slug'    => 'advanced',
            'toggle_slug' => 'design_content_heading',
            'sub_toggle'  => 'h2',
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
                'main'    => "$this->main_css_element .df_rating_content h3",
                'hover'   => "$this->main_css_element .df_rating_content h3:hover",
            ),
            'toggle_slug' => 'design_content_heading',
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
                'main'    => "$this->main_css_element .df_rating_content h4",
                'hover'   => "$this->main_css_element .df_rating_content h4:hover",
            ),
            'toggle_slug' => 'design_content_heading',
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
                'main'    => "$this->main_css_element .df_rating_content h5",
                'hover'   => "$this->main_css_element .df_rating_content h5:hover",
            ),
            'toggle_slug' => 'design_content_heading',
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
                'main'    => "$this->main_css_element .df_rating_content h6",
                'hover'   => "$this->main_css_element .df_rating_content h6:hover",
            ),
            'toggle_slug' => 'design_content_heading',
            'tab_slug'    => 'advanced',
            'sub_toggle'  => 'h6'
        );



        $advanced_fields['borders'] = array(
            'default'               => array(),
            'rating_icon_border'    => array(
                'css'               => array(
                    'main'  => array(
                        'border_radii'       => "$this->main_css_element .df_rating_icon",
                        'border_radii_hover' => "$this->main_css_element .df_rating_icon:hover",
                        'border_styles'      => "$this->main_css_element .df_rating_icon",
                        'border_styles_hover' => "$this->main_css_element .df_rating_icon:hover",
                    )
                ),
                'label_prefix'    => esc_html__('Rating', 'divi_flash'),
                'toggle_slug'     => 'design_rating',
                'tab_slug'        => 'advanced'
            ),
            'title_border'        => array(
                'css' => array(
                    'main'  => array(
                        'border_radii'       => "$this->main_css_element .df_rating_title",
                        'border_radii_hover' => "$this->main_css_element .df_rating_title:hover",
                        'border_styles'      => "$this->main_css_element .df_rating_title",
                        'border_styles_hover' => "$this->main_css_element .df_rating_title:hover",
                    )
                ),
                'label_prefix'    => esc_html__('Title', 'divi_flash'),
                'toggle_slug'     => 'design_title',
                'tab_slug'        => 'advanced'
            ),
            'content_border'      => array(
                'css'             => array(
                    'main'  => array(
                        'border_radii'       => "$this->main_css_element .df_rating_content",
                        'border_radii_hover' => "$this->main_css_element .df_rating_content:hover",
                        'border_styles'      => "$this->main_css_element .df_rating_content",
                        'border_styles_hover' => "$this->main_css_element .df_rating_content:hover",
                    )
                ),
                'label_prefix'    => esc_html__('Content', 'divi_flash'),
                'toggle_slug'     => 'design_content',
                'tab_slug'        => 'advanced'
            )
        );

        $advanced_fields['box_shadow'] = array(
            'default'           => true,

            'rating_box_shadow' => array(
                'label'         => esc_html__('Rating Box Shadow', 'divi_flash'),
                'css'           => array(
                    'main'  => "$this->main_css_element .df_rating_icon",
                    'hover' => "$this->main_css_element .df_rating_icon:hover",
                ),
                'toggle_slug'   => 'design_rating',
                'tab_slug'      => 'advanced'
            ),

            'title_box_shadow'   => array(
                'label'          => esc_html__('Title Box Shadow', 'divi_flash'),
                'css' => array(
                    'main'  => "$this->main_css_element .df_rating_title",
                    'hover' => "$this->main_css_element .df_rating_title:hover",
                ),
                'toggle_slug'    => 'design_title',
                'tab_slug'       => 'advanced'
            ),

            'content_box_shadow' => array(
                'label'          => esc_html__('Content Box Shadow', 'divi_flash'),
                'css' => array(
                    'main'  => "$this->main_css_element .df_rating_content",
                    'hover' => "$this->main_css_element .df_rating_content:hover",
                ),
                'toggle_slug'    => 'design_content',
                'tab_slug'       => 'advanced'
            ),

        );

        $advanced_fields['filters'] = array(
            'child_filters_target' => array(
                'label'    => esc_html__('Filter', 'divi_flash'),
                'toggle_slug'     => 'filter',
                'tab_slug'        => 'advanced',
                'css' => array(
                    'main'  => "$this->main_css_element .df_rating_box_container",
                    'hover' => "$this->main_css_element .df_rating_box_container:hover"
                ),
            )
        );

        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'important' => 'all'
            )
        );

        $advanced_fields['max_width'] = array(
            'css' => array(
                'main'             => $this->main_css_element,
                'module_alignment' => "$this->main_css_element.et_pb_module",
                'important' => 'all'
            )
        );

        return $advanced_fields;
    }

    public function get_custom_css_fields_config()
    {
        return array(
            'rating_css'   => array(
                'label'    => esc_html__('Rating Icon', 'divi_flash'),
                'selector' => "$this->main_css_element .df_rating_wrapper .df_rating_icon span.et-pb-icon",
            ),
            'rating_before_css' => array(
                'label'    => esc_html__('Rating Icon Before', 'divi_flash'),
                'selector' => "$this->main_css_element .df_rating_wrapper .df_rating_icon span.df_rating_icon_fill::before",
            ),
            'rating_after_css' => array(
                'label'    => esc_html__('Rating Icon After', 'divi_flash'),
                'selector' => "$this->main_css_element .df_rating_wrapper .df_rating_icon span.df_rating_icon_empty::after",
            ),
            'rating_number_css' => array(
                'label'    => esc_html__('Rating Number', 'divi_flash'),
                'selector' => "$this->main_css_element .df_rating_wrapper span.df_rating_number",
            ),
            'rating_title_css' => array(
                'label'    => esc_html__('Rating Title', 'divi_flash'),
                'selector' => "$this->main_css_element .df_rating_wrapper .df_rating_title",
            ),
            'rating_content_css' => array(
                'label'    => esc_html__('Rating Content', 'divi_flash'),
                'selector' => "$this->main_css_element .df_rating_box_container .df_rating_content",
            )
        );
    }

    public function get_transition_fields_css_props()
    {
        $fields = parent::get_transition_fields_css_props();

        $rating_rating_wrapper = "$this->main_css_element .df_rating_wrapper";
        $rating_icon = "$this->main_css_element .df_rating_icon";
        $rating_title = "$this->main_css_element .df_rating_title";
        $rating_content = "$this->main_css_element .df_rating_content";

        // Color
        $fields['rating_color_active'] = array(
            'color' => "$this->main_css_element .df_rating_icon .df_rating_icon_fill::before",
        );

        $fields['rating_color_inactive'] = array(
            'color' => "$this->main_css_element .df_rating_icon .df_rating_icon_empty, $this->main_css_element .df_rating_icon .df_rating_icon_empty::after",
        );

        // Background
        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'rating_bg',
            'selector'      => $rating_icon
        ));

        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'rating_title_bg',
            'selector'      => $rating_title
        ));

        $fields = $this->df_background_transition(array(
            'fields'        => $fields,
            'key'           => 'rating_content_bg',
            'selector'      => $rating_content
        ));

        // Border
        $fields = $this->df_fix_border_transition(
            $fields,
            'rating_wrapper_border',
            $rating_rating_wrapper
        );

        $fields = $this->df_fix_border_transition(
            $fields,
            'rating_icon_border',
            $rating_icon
        );

        $fields = $this->df_fix_border_transition(
            $fields,
            'title_border',
            $rating_title
        );

        $fields = $this->df_fix_border_transition(
            $fields,
            'content_border',
            $rating_content
        );

        // Box Shadow
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'rating_box_wrapper_shadow',
            $rating_rating_wrapper
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'rating_box_shadow',
            $rating_icon
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'title_box_shadow',
            $rating_title
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'content_box_shadow',
            $rating_content
        );

        return $fields;
    }

    public function render($attrs, $content, $render_slug)
    {
		$this->handle_fa_icon();
        // Get all style
        $this->additional_css_styles($render_slug);

        // Schema
        $schema = "";
        if ($this->props['enable_schema'] && $this->props['enable_schema'] === 'on') {
            $rating_val = $this->props['rating_scale_type'] === "5"
                ? $this->props['rating_value_5']
                : $this->props['rating_value_10'];

            $json = [
                '@context' => 'https://schema.org',
                '@type' => 'Rating',
                "ratingValue" => intval($rating_val)
            ];

            $schema =  '<script type="application/ld+json">' . wp_json_encode($json) . '</script>';
        }
        // Display frontend
        $output = sprintf(
                '%3$s
                <div class="df_rating_box_container">
                %1$s
                %2$s
            </div>',
            $this->df_render_rating_wrapper(),
            $this->df_render_content(),
            $schema
        );

        return $output;
    }

    public function additional_css_styles($render_slug)
    {
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_bg',
            'selector'          => "$this->main_css_element .df_rating_icon",
            'hover'             => "$this->main_css_element .df_rating_icon:hover"
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_title_bg',
            'selector'          => "$this->main_css_element .df_rating_title",
            'hover'             => "$this->main_css_element .df_rating_title:hover"
        ));

        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_content_bg',
            'selector'          => "$this->main_css_element .df_rating_content",
            'hover'             => "$this->main_css_element .df_rating_content:hover"
        ));

        // Rating Icon (+ before) Size
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_icon_size',
            'type'              => 'font-size',
            'selector'          => "$this->main_css_element .df_rating_icon span.et-pb-icon, $this->main_css_element .df_rating_icon span.df_rating_icon_fill::before, $this->main_css_element .df_rating_icon span.df_rating_icon_empty::after",
            'hover'             => "$this->main_css_element .df_rating_icon:hover span.et-pb-icon, $this->main_css_element .df_rating_icon:hover span.df_rating_icon_fill::before, $this->main_css_element .df_rating_icon:hover span.df_rating_icon_empty::after",
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_wrapper_margin',
            'type'              => 'margin',
            'selector'          => "$this->main_css_element .df_rating_icon",
            'hover'             => "$this->main_css_element .df_rating_icon:hover",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_wrapper_padding',
            'type'              => 'padding',
            'selector'          => "$this->main_css_element .df_rating_icon",
            'hover'             => "$this->main_css_element .df_rating_icon:hover",
            'important'         => false
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_box_number_margin',
            'type'              => 'margin',
            'selector'          => "$this->main_css_element .df_rating_number",
            'hover'             => "$this->main_css_element .df_rating_number:hover",
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_box_title_margin',
            'type'              => 'margin',
            'selector'          => "$this->main_css_element .df_rating_title",
            'hover'             => "$this->main_css_element .df_rating_title:hover",
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_box_title_padding',
            'type'              => 'padding',
            'selector'          => "$this->main_css_element .df_rating_title",
            'hover'             => "$this->main_css_element .df_rating_title:hover",
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_box_content_margin',
            'type'              => 'margin',
            'selector'          => "$this->main_css_element .df_rating_content",
            'hover'             => "$this->main_css_element .df_rating_content:hover",
            'important'         => true
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_box_content_padding',
            'type'              => 'padding',
            'selector'          => "$this->main_css_element .df_rating_content",
            'hover'             => "$this->main_css_element .df_rating_content:hover",
            'important'         => true
        ));

        // Get only icon
        $enable_rating_icon = $this->props['enable_custom_icon'] === 'on' ? true : false;
        $get_rating_icon = $this->props['enable_custom_icon'] === 'on' ? et_pb_process_font_icon($this->props['rating_icon']) : et_pb_process_font_icon("&#xe033;||divi||400"); // et_pb_process_font_icon('');

        if ($get_rating_icon && !empty($this->props['rating_icon'])) {
            if (method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {

                difl_inject_fa_icons($this->props['rating_icon']);

                $this->generate_styles(
                    array(
                        'utility_arg'    => 'icon_font_family',
                        'render_slug'    => $render_slug,
                        'base_attr_name' => 'rating_icon',
                        'important'      => true,
                        'selector'       => "$this->main_css_element .df_rating_icon span.et-pb-icon",
                        'processor'      => array(
                            'ET_Builder_Module_Helper_Style_Processor',
                            'process_extended_icon'
                        )
                    )
                );
            }
        }

        // Rating Icon Spaces
        $title_display_type = !empty($this->props['title_display_type']) ? $this->props['title_display_type'] : "block";
        $title_placement_left_right = !empty($this->props['title_placement_left_right']) ? $this->props['title_placement_left_right'] : "right";
        $title_placement_top_bottom = !empty($this->props['title_placement_top_bottom']) ? $this->props['title_placement_top_bottom'] : "top";

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'rating_icon_space',
            'type'              => 'margin-left',
            'selector'          => "$this->main_css_element .df_rating_icon .et-pb-icon:not(:first-child)",
            'hover'             => "$this->main_css_element .df_rating_icon .et-pb-icon:hover"
        ));

        // Title Placement default
        if ($title_display_type === "inline") {
            if ($this->props['title_placement_left_right'] === "right") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_rating_title",
                    'declaration' => 'margin-left: 5px;'
                ));
            } else {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_rating_title",
                    'declaration' => 'margin-right: 5px;'
                ));
            }

            // Mobile
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_rating_title",
                'declaration' => "width: 100%; margin: 0px auto;",
                'media_query' => self::get_media_query('max_width_767')
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_rating_title",
                'declaration' => 'display: block; width: 100%;'
            ));
        }

        // Rating Number Default
        if ($this->props['enable_rating_number'] === "on") {
            if ($this->props['rating_number_placement_left_right'] === "right") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_rating_number",
                    'declaration' => 'margin-left: 5px;'
                ));
            } else {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_rating_number",
                    'declaration' => 'margin-right: 5px'
                ));
            }
        }

        // Custom icon
        if ($enable_rating_icon) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_rating_icon span.et-pb-icon",
                'declaration' => 'margin-top: -3px;'
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_rating_icon span.df_rating_icon_fill::before",
                'declaration' => 'content: attr(data-icon) !important;'
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_rating_icon span.df_rating_icon_empty::after",
                'declaration' => 'display: none !important;'
            ));

            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'rating_color_inactive',
                'type'              => 'color',
                'selector'          => "$this->main_css_element .df_rating_icon .df_rating_icon_empty",
                'hover'             => "$this->main_css_element .df_rating_icon:hover .df_rating_icon_empty",
                'important' => true
            ));

            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'rating_color_active',
                'type'              => 'color',
                'selector'          => "$this->main_css_element .df_rating_icon span.et-pb-icon:not(.df_rating_icon_empty), $this->main_css_element .df_rating_icon .df_rating_icon_fill::before",
                'hover'             => "$this->main_css_element .df_rating_icon:hover span.et-pb-icon:not(.df_rating_icon_empty), $this->main_css_element .df_rating_icon:hover .df_rating_icon_fill::before",
                'important' => false
            ));
        } else {
            // Rating color
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'rating_color_active',
                'type'              => 'color',
                'selector'          => "$this->main_css_element .df_rating_icon span.et-pb-icon:not(.df_rating_icon_empty), $this->main_css_element .df_rating_icon .df_rating_icon_fill::before",
                'hover'             => "$this->main_css_element .df_rating_icon:hover .df_rating_icon_fill, $this->main_css_element .df_rating_icon:hover .df_rating_icon_fill::before",
                'important' => false
            ));
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'rating_color_inactive',
                'type'              => 'color',
                'selector'          => "$this->main_css_element .df_rating_icon .df_rating_icon_empty, $this->main_css_element .df_rating_icon .df_rating_icon_empty::after",
                'hover'             => "$this->main_css_element .df_rating_icon:hover .df_rating_icon_empty, $this->main_css_element .df_rating_icon:hover .df_rating_icon_empty::after",
                'important' => false
            ));
        }

        // Single rating
        if ($this->props['enable_single_rating'] === "on") {
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'rating_color_single',
                'type'              => 'color',
                'selector'          => "$this->main_css_element .df_rating_icon span.df_rating_icon_fill::before, $this->main_css_element .df_rating_icon span.et-pb-icon",
                'hover'             => "$this->main_css_element .df_rating_icon:hover span.df_rating_icon_fill::before, $this->main_css_element .df_rating_icon:hover span.et-pb-icon",
                'important' => true
            ));
        }

        // Rating Alignment
        if ($title_display_type === "block") {
            $this->df_set_flex_position([
                'render_slug' => $render_slug,
                'slug'        => 'rating_icon_align',
                'selector'    => "$this->main_css_element .df_rating_wrapper",
                'type'        => "align-items"
            ]);

            if ($title_placement_top_bottom === "top") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_rating_wrapper",
                    'declaration' => "flex-direction: column-reverse;"
                ));
            } else {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_rating_wrapper",
                    'declaration' => "flex-direction: column;"
                ));
            }
            // Inline
        } else {
            $this->df_set_flex_position([
                'render_slug' => $render_slug,
                'slug'        => 'rating_icon_align',
                'selector'    => "$this->main_css_element .df_rating_wrapper",
                'type'        => "justify-content",
                'css'         => "align-items: center;"
            ]);

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_rating_icon",
                'declaration' => 'display: flex; align-items: center;'
            ));

            if ($title_placement_left_right === "left") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_rating_wrapper",
                    'declaration' => "flex-direction: row-reverse;"
                ));
            } elseif ($title_placement_left_right === "right") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element .df_rating_wrapper",
                    'declaration' => "flex-direction: row;"
                ));
            }

            // Mobile
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_rating_wrapper",
                'declaration' => "align-items: unset !important; flex-direction: column-reverse !important;",
                'media_query' => self::get_media_query('max_width_767')
            ));
        }

        if ("" !== $this->props['title_text_align_phone']) {
            $title_text_align_mob = $this->props['title_text_align_phone'] ? $this->props['title_text_align_phone'] : "center";
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "$this->main_css_element .df_rating_title",
                'declaration' => "width: 100%; margin-right:0px; margin-left:0px; text-align: " . $title_text_align_mob . ";",
                'media_query' => self::get_media_query('max_width_767')
            ));
        }

        $rating_align_mob = "";
        if (!empty($this->props['rating_icon_align_phone'])) {
            $rating_align_mob = $this->props['rating_icon_align_phone'];
        } else {
            if (!empty($this->props['rating_icon_align_tablet'])) {
                $rating_align_mob = $this->props['rating_icon_align_tablet'];
            } else {
                $rating_align_mob = $this->props['rating_icon_align'];
            }
        }
        
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "$this->main_css_element .df_rating_icon",
            'declaration' => "width: fit-content; justify-content: " . $rating_align_mob . ";",
            'media_query' => self::get_media_query('max_width_767')
        ));
    } // Css

    // Render Rating & Rating Number & Title
    public function df_render_rating_wrapper()
    {
        // Rating Title
        $title_tag = isset($this->props['rating_title_tag']) ? $this->props['rating_title_tag'] : "h4";

        $title = $this->props['enable_title'] === 'on' && !empty($this->props['title']) ? sprintf(
            '<%1$s class="df_rating_title">%2$s</%1$s>',
            $title_tag,
            $this->props['title']) : "";

        // Rating Icon only
        $get_rating_icon =  $this->props['enable_custom_icon'] === 'on' ? et_pb_process_font_icon($this->props['rating_icon']) : "☆";

        // Rating scale type
        $rating_scale_type = $this->props['enable_single_rating'] == 'off' ?
            (!empty($this->props['rating_scale_type']) ? $this->props['rating_scale_type'] : 5) : 1;

        $rating_value = $rating_scale_type == 5
            ? ($this->props['rating_value_5'] <= 5 && $this->props['rating_value_5'] >= 0
                ? $this->props['rating_value_5'] : 5) : ($this->props['rating_value_10'] <= 10 && $this->props['rating_value_10'] >= 0
                ? $this->props['rating_value_10'] : 10);

        // Get float value
        $get_float = explode('.', $rating_value);

        $rating_icon = '';
        $rating_active_class = '';

        // Display Rating Icon
        for ($i = 1; $i <= $rating_scale_type; $i++) {
            if (!isset($rating_value)) {
                $rating_active_class = '';
            } else if ($i <= $rating_value) {
                $rating_active_class = 'df_rating_icon_fill';
            } else if ($i == $get_float[0] + 1 && isset($get_float[1]) && $get_float[1] != '' && $get_float[1] != 0) {
                $rating_active_class = 'df_rating_icon_fill df_rating_icon_empty df_fill_' . $get_float[1];
            } else {
                $rating_active_class = 'df_rating_icon_empty';
            }
            $rating_icon .= '<span class="et-pb-icon ' . $rating_active_class . '" data-icon="' . $get_rating_icon . '">' . $get_rating_icon . '</span>';
        }

        // Get single rating value
        $rating_value_single = $this->props['rating_scale_type'] === "5" ? $this->props['rating_value_5'] : $this->props['rating_value_10'];

        // Show rating number
        $rating_number = '';
        if($this->props['enable_rating_number'] === 'on'){
            if($this->props['enable_single_rating'] !== 'on'){
                if($this->props['rating_number_type'] === 'number_with_bracket'){
                    $rating_number = sprintf(
                        '<span class="df_rating_number">(%1$s/%2$s)</span>',
                        $rating_value,
                        $rating_scale_type
                    );
                }elseif($this->props['rating_number_type'] === 'number_without_bracket'){
                    $rating_number = sprintf(
                        '<span class="df_rating_number">%1$s/%2$s</span>',
                        $rating_value,
                        $rating_scale_type
                    );
                }else{
                    $rating_number = sprintf('<span class="df_rating_number">%1$s</span>', $rating_value_single);
                }
            }else{
                $rating_number = sprintf('<span class="df_rating_number">%1$s</span>', $rating_value_single);
            }
        }else{
            $rating_number = '';
        }

        // Rating Number placement
        $rating_icon_and_number_placement = '';
        $this->props['rating_number_placement_left_right'] === 'left' ?
            $rating_icon_and_number_placement = $rating_number . $rating_icon : $rating_icon_and_number_placement = $rating_icon . $rating_number;

        return sprintf(
            '<div class="df_rating_wrapper">
                <div class="df_rating_icon">
                    %1$s
                </div>
                %2$s
            </div>',
            $rating_icon_and_number_placement,
            $title
        );
    }

    // Render rating content
    public function df_render_content()
    {
        $content = $this->props['enable_content'] === 'on' && !empty($this->props['content'])
            ? sprintf(
                '<div class="df_rating_content">%1$s</div>',
                $this->props['content']
            ) : "";

        return $content;
    }

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
}

new DIFL_RatingBox;
