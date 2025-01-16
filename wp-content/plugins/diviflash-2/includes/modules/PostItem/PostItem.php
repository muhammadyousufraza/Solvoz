<?php

class DIFL_PostItem extends ET_Builder_Module_Type_PostBased {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_postitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $child_title_var = 'type';
	public $child_title_fallback_var = 'admin_label';
	public $display_element_dependancy;
    use DF_UTLS;
    use Df_Acf_Data_Process;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Post Element', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->df_acf_init(true);
        $this->display_element_dependancy = array('author', 'date', 'categories', 'comments', 'tags', 'custom_text', 'acf_fields');
    }

    public function font_selector($type = 'main') {
        $selector = array(
            'main'  => array(
                "{$this->main_css_element} .df-post-title",
                "{$this->main_css_element} .df-post-title a",
                "{$this->main_css_element}.df-item-wrap > span:not(.et-pb-icon)",
                "{$this->main_css_element}.df-item-wrap a",
                "{$this->main_css_element}.df-item-wrap",
                "{$this->main_css_element}.df-item-wrap p",
                "{$this->main_css_element} .df-post-read-more",
                "{$this->main_css_element} .df-post-custom-text"
            )
        );

        if($type === 'main') {
            return implode(', ',  $selector['main']);
        } else if($type === 'hover') {
            return '.df-post-outer-wrap:hover ' . implode(',.df-post-outer-wrap:hover ',  $selector['main']);
        }

    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'type'                  => esc_html__('Element', 'divi_flash'),
                    'settings'              => esc_html__('Element', 'divi_flash'),
                    'acf_settings'          => esc_html__('Settings For ACF', 'divi_flash'),
                    'icon_settings'         => esc_html__('Icon Settings', 'divi_flash'),
                    'overlay'               => esc_html__('Overlay & Scale', 'divi_flash'),
                    'divider_line'          => esc_html__('Divider Line', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'image'         => esc_html__('Image Settings', 'divi_flash'),
                    'text'          => esc_html__('Text', 'divi_flash'),
                    'text_style'    => esc_html__('Text Styles', 'divi_flash'),
                    'read_more'     => esc_html__('Read More', 'divi_flash'),
                    'before_after'  => array(
                        'title' => esc_html__('Before After Text', 'divi_flash'),
                        'priority' => 70,
                    ),
                    'custom_spacing'=> array(
                        'title' => esc_html__('Spacing', 'divi_flash'),
                        'priority' => 70,
                    ),
                    'custom_spacing'=> esc_html__('Spacing', 'divi_flash')
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['text'] = array(
            'toggle_slug'           => 'text',
            'use_text_orientation'  => true, // default
			'css' => array(
				'text_orientation' => '%%order_class%%.df-item-wrap',
			),
        );

        $advanced_fields['fonts'] = array(
            'post_font_style'     => array(
                'label'         => esc_html__('Text', 'divi_flash'),
                'toggle_slug'   => 'text_style',
                'tab_slug'        => 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => $this->font_selector('main'),
                    'hover' => $this->font_selector('hover'),
                    'important'    => 'all'
                ),
            ),
            'before_after'     => array(
                'label'         => esc_html__('Before After', 'divi_flash'),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'tab_slug'  => 'advanced',
                'toggle_slug' => 'before_after',
                'css'      => array(
                    'main' => "{$this->main_css_element}.df-item-wrap.df-item-acf .before-text, {$this->main_css_element}.df-item-wrap.df-item-acf .after-text",
                    'hover' => ".df-post-outer-wrap:hover {$this->main_css_element}.df-item-acf .before-text, .df-post-outer-wrap:hover {$this->main_css_element}.df-item-acf .after-text",
                    'important'    => 'all'
                ),
                'hide_text_align' => true
            )
        );

        $advanced_fields['borders'] = array(
            'default'   => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".df-post-outer-wrap {$this->main_css_element}",
                        'border_radii_hover'  => ".df-post-outer-wrap:hover {$this->main_css_element}",
                        'border_styles' => ".df-post-outer-wrap {$this->main_css_element}",
                        'border_styles_hover' => ".df-post-outer-wrap:hover {$this->main_css_element}",
                    )
                )
            )
        );
        $advanced_fields['box_shadow'] = array(
            'default'      => array(
                'css' => array(
                    'main' => ".df-post-outer-wrap {$this->main_css_element}",
                    'hover' => ".df-post-outer-wrap:hover {$this->main_css_element}",
                )
            ),
        );
        $advanced_fields['max_width'] = array(
            'css'   => array(
                'module_alignment' => "{$this->main_css_element}",
            )
        );

        $advanced_fields['background'] = array(
            'css'       => array(
                'main'     => "{$this->main_css_element}",
                'hover'     => ".df-post-outer-wrap:hover {$this->main_css_element}"
            )
        );
        $advanced_fields['margin_padding'] = false;

        $advanced_fields['link_options'] = false;
        return $advanced_fields;
    }

    public function get_fields() {
        $general = array (
            'type'   => array(
                'label'             => esc_html__('Type', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'select'        => esc_html__('Select Type', 'divi_flash'),
                    'image'         => esc_html__('Post Image', 'divi_flash'),
                    'title'         => esc_html__('Post Title', 'divi_flash'),
                    'content'       => esc_html__('Post Content', 'divi_flash'),
                    'button'        => esc_html__('Read More Button', 'divi_flash'),
                    'author'        => esc_html__('Post Author', 'divi_flash'),
                    'date'          => esc_html__('Publish Date', 'divi_flash'),
                    'categories'    => esc_html__('Post Categories', 'divi_flash'),
                    'tags'          => esc_html__('Post Tags', 'divi_flash'),
                    'comments'      => esc_html__('Post Comments', 'divi_flash'),
                    'custom_text'   => esc_html__('Custom Text', 'divi_flash'),
                    'divider'       => esc_html__('Divider', 'divi_flash')
                ),
                'default'           => 'select',
                'toggle_slug'       => 'settings',
                'affects'           => [
                    'title_tag',
                    'show_author',
                    'show_date',
                    'show_categories',
                    'show_comments',
                    'post_content',
                    'image_size',
                    'use_image_as_background',
                    'image_full_width'
                ]
            ),

            'post_type_for_acf'    => array(
                'label'            => esc_html__( 'Post Type', 'et_builder' ),
                'type'             => 'select',
                'option_category'  => 'configuration',
                'options'          => $this->df_acf_cpt_list,
                'description'      => esc_html__( 'Choose posts to display ACF Fields.', 'et_builder' ),
                'toggle_slug'      => 'settings',
                'default'          => 'select',
                'show_if'          => array(
                    'type'         => 'acf_fields'
                )
            ),
            'comment_text'   => array(
                'label'             => esc_html__('Turn off Comment Text', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings',
                'show_if'           => array(
                    'type'      => array('comments')
                )
            )
        );

        if( $this->acf_extension === 'on' && class_exists('ACF') ){
            $general['type']['options']['acf_fields'] = esc_html__('ACF Fields', 'divi_flash');
            $general = array_merge( $general, $this->df_acf_fields );
        }

        $general = array_merge($general, array(
            'acf_before_label' => array(
				'label'             => esc_html__( 'Before Text', 'divi_flash' ),
				'type'              => 'text',
				'toggle_slug'       => 'settings',
                'description'       => esc_html__( 'This text will appeare before the ACF Field content.', 'divi_flash'),
                'default'           => '',
                'show_if'           => array(
                    'type'      => array('acf_fields')
                )
			),
            'acf_after_label' => array(
				'label'             => esc_html__( 'After Text', 'divi_flash' ),
				'type'              => 'text',
				'toggle_slug'       => 'settings',
                'description'       => esc_html__( 'This text will appeare after the ACF Field content.', 'divi_flash'),
                'default'           => '',
                'show_if'           => array(
                    'type'      => array('acf_fields')
                )
			),
        ));

        $type_setting = array(
            'outside_wrapper'   => array(
                'label'             => esc_html__('Outside Inner Wrapper', 'divi_flash'),
                'type'              => 'yes_no_button',
                'description'       => esc_html__('This will put the content outside the inner wrapper.', 'divi_flash'),
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings',
                'show_if'           => array(
                    'type'      => array('image', 'author', 'date', 'categories', 'tags', 'comments', 'custom_text')
                )
            ),
            'admin_label' => array (
				'label'           => esc_html__( 'Admin Label', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'admin_label',
				'default_on_front'=> '',
			)
        );
        $title = array(
            'title_tag' => array (
                'default'         => 'h2',
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
                'toggle_slug'       => 'settings',
                'tab_slug'		    => 'general',
                'depends_show_if'   => 'title'
            )
        );

        $author = array(
            'show_author_image'    => array(
                'label'             => esc_html__('Show Author Image', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings',
                'show_if'           => array(
                    'type'      => 'author',
                )
            ),
            'author_image_size' => array(
                'label'         => esc_html__('Author Image Size', 'divi_flash'),
                'type'          => 'range',
                'default'       => '16px',
                'allowed_units' => array('px'),
                'default_unit'  => 'px',
                'range_settings' => array(
                    'min'       => '16',
                    'min_limit' => '0',
                    'max'       => '96',
                    'step'      => '1'
                ),
                'toggle_slug'   => 'settings',
                'mobile_options'=> true,
                'show_if'       => array(
                    'show_author_image' => 'on',
                    'type'          => 'author'
                )
            ),
            'hide_author_text'    => array(
                'label'             => esc_html__('Hide Author Text', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings',
                'show_if'           => array(
                    'type'              => 'author',
                    'show_author_image' => 'on'
                )
            ),
        );

        $date = array(
            'date_format' => array(
				'label'             => esc_html__( 'Date Format', 'divi_flash' ),
				'type'              => 'text',
				'description'       => esc_html__( 'If you would like to adjust the date format, input the appropriate PHP date format here.', 'divi_flash' ),
				'toggle_slug'       => 'settings',
                'default'           => 'M j, Y',
                'show_if'           => array(
                    'type'      => array('date')
                )
			),
        );

        $meta_sttings = array(
            'meta_display'   => array(
                'label'             => esc_html__('Display', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'inline-flex'          => esc_html__('Inline Block', 'divi_flash'),
                    'inline'                => esc_html__('Inline', 'divi_flash'),
                    'block'                 => esc_html__('Block', 'divi_flash'),
                ),
                'default'           => 'inline-flex',
                'toggle_slug'       => 'settings',
                'show_if'           => array(
                    'type'      => $this->display_element_dependancy
                )
            ),
            'meta_position'   => array(
                'label'             => esc_html__('Align', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'none'           => esc_html__('Default', 'divi_flash'),
                    'right'           => esc_html__('Right', 'divi_flash')
                ),
                'default'           => 'none',
                'toggle_slug'       => 'settings',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'           => array(
                    'type'      => $this->display_element_dependancy
                ),
                'show_if_not'    => array(
                    'meta_display'=> array('block')
                )
            )
        );

        $read_more = array(
            'read_more_text' => array(
				'label'             => esc_html__( 'Read More Text', 'divi_flash' ),
				'type'              => 'text',
				'toggle_slug'       => 'settings',
                'default'           => 'Read More',
                'show_if'           => array(
                    'type'      => array('button')
                )
			),
        );

        $content = array(
            'post_content'   => array(
                'label'             => esc_html__('Post Content', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'content'        => esc_html__('Show Content', 'divi_flash'),
                    'excerpt'        => esc_html__('Show Excerpt', 'divi_flash')
                ),
                'default'           => 'excerpt',
                'toggle_slug'       => 'settings',
                'depends_show_if'   => 'content'
            ),
            'use_post_excrpt'   => array(
                'label'             => esc_html__('Use Post Excerpt', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings',
                'show_if'           => array(
                    'post_content'      => 'excerpt',
                    'type'              => 'content'
                )
            ),
            'excerpt_length' => array(
				'label'             => esc_html__( 'Excerpt Length', 'divi_flash' ),
				'description'       => esc_html__( 'Define the length of automatically generated excerpts. Leave blank for default ( 270 ) ', 'divi_flash' ),
				'type'              => 'text',
				'default'           => '270',
                'toggle_slug'       => 'settings',
                'show_if'           => array(
                    'post_content'      => 'excerpt',
                    'type'              => 'content'
                )
			),
        );

        $settings_for_acf = array(
            'acf_url_text' => array(
				'label'             => esc_html__( 'Link Text', 'divi_flash' ),
				'type'              => 'text',
				'toggle_slug'       => 'acf_settings',
                'default'           => '',
                'show_if'           => array(
                    'type'      => array('acf_fields')
                )
			),
            'acf_url_new_window'   => array(
				'label'            => esc_html__( 'Link Target', 'divi_flash' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'In The Same Window', 'divi_flash' ),
					'on'  => esc_html__( 'In The New Tab', 'divi_flash' ),
				),
                'default'          => 'off',
				'toggle_slug'      => 'acf_settings',
				'description'      => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'divi_flash' ),
                'show_if'           => array(
                    'type'      => array('acf_fields')
                )
			),
            'acf_email_text' => array(
				'label'             => esc_html__( 'Email Text', 'divi_flash' ),
				'type'              => 'text',
				'toggle_slug'       => 'acf_settings',
                'default'           => '',
                'show_if'           => array(
                    'type'      => array('acf_fields')
                )
			),
            'acf_image_width'       => array (
                'label'             => esc_html__( 'Image Max-Width', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'acf_settings',
                'default'           => 'auto',
                'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '500',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
                'responsive'        => true,
                'show_if'           => array(
                    'type'      => array('acf_fields')
                )
            )
        );

        $icon_settings_dependency = array('author', 'date', 'categories', 'comments', 'tags', 'button');
        $icon_settings = array(
            'use_icon'    => array(
                'label'             => esc_html__('Use Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'icon_settings',
                'show_if'           => array(
                    'type'          => $icon_settings_dependency
                )
            ),
            'font_icon'                 => array(
				'label'                 => esc_html__( 'Icon', 'divi_flash' ),
				'type'                  => 'select_icon',
				'option_category'       => 'basic_option',
				'class'                 => array( 'et-pb-font-icon' ),
                'toggle_slug'           => 'icon_settings',
                'show_if'           => array(
                    'type'          => $icon_settings_dependency,
                    'use_icon'      => 'on'
                )
            ),
            'icon_color'            => array (
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
                'toggle_slug'       => 'icon_settings',
                'hover'             => 'tabs',
                'show_if'           => array(
                    'type'          => $icon_settings_dependency,
                    'use_icon'      => 'on'
                )
            ),
            'icon_size'             => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'toggle_slug'       => 'icon_settings',
                'default'           => '12px',
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
                    'type'          => $icon_settings_dependency,
                    'use_icon'      => 'on'
                )
            ),
            'icon_vertical_alignment'    => array(
                'label'             => esc_html__('Enable Vertical Align Center', 'divi_flash'),
                'type'              => 'yes_no_button',
                'default'           => 'off',
                'options'           => array(
                    'on'    => esc_html__('On', 'divi_flash'),
                    'off'   => esc_html__('Off', 'divi_flash'),
                ),
                'toggle_slug'       => 'icon_settings',
                'show_if'           => array(
                    'use_icon'      => 'on'
                )
            ),
            'image_icon' => array (
                'label'                 => esc_html__( 'Image', 'divi_flash' ),
				'type'                  => 'upload',
                'option_category'       => 'basic_option',
				'upload_button_text'    => esc_attr__( 'Upload an image', 'divi_flash' ),
				'choose_text'           => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'           => esc_attr__( 'Set As Image', 'divi_flash' ),
                'toggle_slug'           => 'icon_settings',
                'show_if'               => array(
                    'type'              => $icon_settings_dependency
                ),
                'show_if_not'           => array(
                    'use_icon'          => 'on'
                )
            ),
            'image_alt_text' => array (
                'label'                 => esc_html__( 'Image Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'icon_settings',
                'show_if'               => array(
                    'type'              => $icon_settings_dependency
                ),
                'show_if_not'           => array(
                    'use_icon'          => 'on'
                )
            ),
            'icon_image_width'       => array (
                'label'             => esc_html__( 'Image Width', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'icon_settings',
                'default'           => 'auto',
                'default_unit'      => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
                'responsive'        => true,
                'show_if'               => array(
                    'type'              => $icon_settings_dependency
                ),
                'show_if_not'           => array(
                    'use_icon'          => 'on'
                )
            ),
            'icon_image_verticle_align'   => array(
                'label'             => esc_html__('Vertical align', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'text-top'           => esc_html__('Top', 'divi_flash'),
                    'middle'        => esc_html__('Middle', 'divi_flash'),
                    'text-bottom'        => esc_html__('Bottom', 'divi_flash')
                ),
                'default'           => 'text-top',
                'toggle_slug'       => 'icon_settings',
                'show_if'               => array(
                    'type'              => $icon_settings_dependency
                ),
                'show_if_not'           => array(
                    'use_icon'          => 'on'
                )
            )

        );

        $image_settings = array(
            'image_size' => array (
                'default'         => 'mid',
                'label'           => esc_html__( 'Image Size', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'original'       => esc_html__( 'Original', 'divi_flash' ),
                    'large'         => esc_html__( '1080 X 675', 'divi_flash' ),
                    // 'mid-hr'        => esc_html__( '350 X 450', 'divi_flash' ),
                    'mid'           => esc_html__( '400 X 250', 'divi_flash' ),
                    // 'mid-squ'       => esc_html__( '400 X 400', 'divi_flash' ),
                    // 'sm-squ'        => esc_html__( '300 X 300', 'divi_flash' )

                ),
                'toggle_slug'       => 'image',
                'tab_slug'		    => 'advanced',
                'depends_show_if'   => 'image'
            ),
            'image_full_width'    => array(
                'label'             => esc_html__('Force Full Width', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'image',
                'tab_slug'		    => 'advanced',
                'depends_show_if'   => 'image'
            ),
            'overlay'    => array(
                'label'         => esc_html__('Overlay', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'overlay',
                'show_if'           => array(
                    'type'      => array('image')
                )
            ),
            'overlay_primary'  => array(
                'label'             => esc_html__( 'Overlay Primary color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'overlay',
                'default'           => '#00B4DB',
                'show_if'           => array(
                    'overlay'  => 'on',
                    'type'      => array('image')
                )
            ),
            'overlay_secondary'  => array(
                'label'             => esc_html__( 'Overlay Secondary color', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'overlay',
                'default'           => '#0083B0',
                'show_if'           => array(
                    'overlay'  => 'on',
                    'type'      => array('image')
                )
            ),
            'overlay_direction'    => array (
                'label'             => esc_html__( 'Overlay Gradient Direction', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'overlay',
                'default'           => '180deg',
                'default_unit'      => 'deg',
                'allowed_units'     => array ('deg'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '360',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if'           => array(
                    'overlay'  => 'on',
                    'type'      => array('image')
                )
            ),
            'overlay_icon'    => array(
                'label'         => esc_html__('Use Icon', 'divi_flash'),
                'type'          => 'yes_no_button',
                'options'       => array (
                    'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'       => 'off',
                'toggle_slug'   => 'overlay',
                'show_if'           => array(
                    'overlay'  => 'on',
                    'type'      => array('image')
                )
            ),
            'overlay_font_icon'                 => array(
				'label'                 => esc_html__( 'Icon', 'divi_flash' ),
				'type'                  => 'select_icon',
				'option_category'       => 'basic_option',
				'class'                 => array( 'et-pb-font-icon' ),
                'toggle_slug'           => 'overlay',
                'show_if'           => array(
                    'type'          => array('image'),
                    'overlay_icon'      => 'on',
                    'overlay'       => 'on'
                )
            ),
            'overlay_icon_color'            => array (
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
                'toggle_slug'       => 'overlay',
                'show_if'           => array(
                    'type'          => array('image'),
                    'overlay_icon'      => 'on',
                    'overlay'       => 'on'
                )
            ),
            'overlay_icon_size'             => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'toggle_slug'       => 'overlay',
                'default'           => '35px',
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
                    'type'          => array('image'),
                    'overlay_icon'      => 'on',
                    'overlay'       => 'on'
                )
            ),
            'overlay_icon_reveal'    => array(
                'label'    => esc_html__('Icon Reveal Type', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'df-fade-up'            => esc_html__('Fade Up', 'divi_flash'),
                    'df-fade-down'          => esc_html__('Fade Down', 'divi_flash'),
                    'df-fade-left'          => esc_html__('Fade Left', 'divi_flash'),
                    'df-fade-right'         => esc_html__('Fade Right', 'divi_flash'),
                    'df-fade-in'            => esc_html__('Fade In', 'divi_flash'),
                    'df-rotate-up-right'    => esc_html__('Rotate Up Right', 'divi_flash'),
                    'df-rotate-up-left'     => esc_html__('Rotate Up Left', 'divi_flash'),
                    'df-rotate-down-right'  => esc_html__('Rotate Down Right', 'divi_flash'),
                    'df-rotate-down-left'   => esc_html__('Rotate Down Left', 'divi_flash'),
                    'df-zoom-in'            => esc_html__('Zoom In', 'divi_flash'),
                ),
                'default'       => 'df-fade-up',
                'toggle_slug'   => 'overlay',
                'show_if'           => array(
                    'type'          => array('image'),
                    'overlay_icon'      => 'on',
                    'overlay'       => 'on'
                )
            ),
            'image_scale'    => array(
                'label'    => esc_html__('Image Scale Type', 'divi_flash'),
                'type'          => 'select',
                'options'       => array (
                    'no-image-scale'            => esc_html__('Select Scale Type', 'divi_flash'),
                    'df-image-zoom-in'          => esc_html__('Zoom In', 'divi_flash'),
                    'df-image-zoom-out'         => esc_html__('Zoom Out', 'divi_flash'),
                    'df-image-pan-up'           => esc_html__('Pan Up', 'divi_flash'),
                    'df-image-pan-down'         => esc_html__('Pan Down', 'divi_flash'),
                    'df-image-pan-left'         => esc_html__('Pan Left', 'divi_flash'),
                    'df-image-pan-right'        => esc_html__('Pan Right', 'divi_flash'),
                    // 'df-image-rotate-left'      => esc_html__('Rotate Left', 'divi_flash'),
                    // 'df-image-rotate-right'     => esc_html__('Rotate Right', 'divi_flash'),
                    // 'df-image-blur'             => esc_html__('Blur', 'divi_flash')
                ),
                'default'       => 'no-image-scale',
                'toggle_slug'   => 'overlay',
                'show_if'       => array(
                    'type'      => 'image'
                )
            ),
            'image_scale_hover'    => array (
                'label'             => esc_html__( 'Scale', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'overlay',
                'default'           => '1.3',
                'allowed_units'     => array (),
                'range_settings'    => array(
                    'min'  => '1.3',
                    'max'  => '3',
                    'step' => '.1',
                ),
                'validate_unit'    => false,
                'show_if'          => array (
                    'image_scale' => array( 'df-image-rotate-left', 'df-image-rotate-right')
                )
            )
        );

        $custom_text = array(
            'custom_text'    => array(
                'label'             => esc_html__('Custom Text', 'divi_flash'),
                'type'              => 'text',
                'toggle_slug'       => 'settings',
                'show_if'           => array(
                    'type'      => array('custom_text')
                )
            ),
        );

        $spacing = $this->add_margin_padding(array(
            'key'           => 'element',
            'toggle_slug'   => 'custom_spacing'
        ));

        $author_image_spacing = $this->add_margin_padding(array(
            'title'         => 'Author Image',
            'key'           => 'author_image',
            'toggle_slug'   => 'custom_spacing',
            'option'        => 'margin',
            'show_if'       => array(
                'type'      => 'author'
            )
        ));

        $button_spacing = $this->add_margin_padding(array(
            'title'         => 'Button',
            'key'           => 'button',
            'toggle_slug'   => 'custom_spacing',
            'show_if'       => array(
                'type'      => 'button'
            )
        ));

        $divider = array(
            'divider_line_height'    => array (
                'label'             => esc_html__( 'Divider Line Height', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'divider_line',
                'default'           => '3px',
                'default_unit'      => 'px',
                'allowed_units'     => array ('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if'           => array(
                    'type'  => 'divider'
                )
            ),
            'divider_color_primary'  => array(
                'label'             => esc_html__( 'Divider Color Primary', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'divider_line',
                'default'           => '#e02b20',
                'show_if'           => array(
                    'type'  => 'divider'
                )
            ),
            'divider_color_secondary'  => array(
                'label'             => esc_html__( 'Divider Color Secondary', 'divi_flash' ),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'divider_line',
                'default'           => '#fc7069',
                'show_if'           => array(
                    'type'  => 'divider'
                )
            ),
            'divider_color_direction'    => array (
                'label'             => esc_html__( 'Divider Color Direction', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'divider_line',
                'default'           => '90deg',
                'default_unit'      => 'deg',
                'allowed_units'     => array ('deg'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '360',
                    'step' => '1',
                ),
                // 'mobile_options'    => true,
                'show_if'           => array(
                    'type'  => 'divider'
                )
            ),
            'divider_color_start'    => array (
                'label'             => esc_html__( 'Starting Position', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'divider_line',
                'default'           => '0%',
                'default_unit'      => '%',
                'allowed_units'     => array ('%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                // 'mobile_options'    => true,
                'show_if'           => array(
                    'type'  => 'divider'
                )
            ),
            'divider_color_end'    => array (
                'label'             => esc_html__( 'Ending Position', 'divi_flash' ),
                'type'              => 'range',
                'toggle_slug'       => 'divider_line',
                'default'           => '100%',
                'default_unit'      => '%',
                'allowed_units'     => array ('%'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                // 'mobile_options'    => true,
                'show_if'           => array(
                    'type'  => 'divider'
                )
            ),
        );

        $divider_spacing = $this->add_margin_padding(array(
            'title'         => 'Divider',
            'key'           => 'divider',
            'toggle_slug'   => 'custom_spacing',
            'show_if'       => array(
                'type'      => 'divider'
            )
        ));
        $icon_spacing = $this->add_margin_padding(array(
            'title'         => 'Icon',
            'key'           => 'icon',
            'toggle_slug'   => 'custom_spacing',
            'option'        => 'margin',
            'show_if'       => array(
                'type'      => $icon_settings_dependency
            )
        ));

        return array_merge(
            $general,
            $type_setting,
            $title,
            $author,
            $date,
            $custom_text,
            $meta_sttings,
            $content,
            $read_more,
            $settings_for_acf,
            $icon_settings,
            $image_settings,
            $divider,
            $spacing,
            $author_image_spacing,
            $button_spacing,
            $divider_spacing,
            $icon_spacing
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $fields['icon_color'] = array('color' => '%%order_class%%.df-item-wrap .et-pb-icon');

        $fields['element_margin'] = array('margin' => '%%order_class%%');
        $fields['element_padding'] = array('padding' => '%%order_class%%');

        $fields['button_margin'] = array('margin' => '%%order_class%% a');
        $fields['button_padding'] = array('padding' => '%%order_class%% a');

        return $fields;
    }

    public function additional_css_styles($render_slug) {
        $meta = array('author', 'date', 'categories', 'comments', 'custom_text', 'tags');

        if(in_array($this->props['type'], $this->display_element_dependancy)) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%',
                'declaration' => sprintf('display: %1$s;', $this->props['meta_display'])
            ));
        }


        if($this->props['meta_display'] === 'inline-block' || $this->props['meta_display'] === 'inline-flex' || $this->props['meta_display'] === 'inline'){
            $this->df_process_string_attr(array(
                'render_slug'           => $render_slug,
                'slug'                  => 'meta_position',
                'type'                  => 'float',
                'selector'              => "%%order_class%%",
                'default'               => 'none',
                'responsive'            => true,
                'mobile_options'        => true
            ));
        }

        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_image_width',
            'type'              => 'width',
            'selector'          => '%%order_class%%.df-item-wrap .df-icon-image'
        ) );
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%.df-item-wrap .df-icon-image',
            'declaration' => sprintf('vertical-align: %1$s;', $this->props['icon_image_verticle_align'])
        ));
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_size',
            'type'              => 'font-size',
            'selector'          => '%%order_class%%.df-item-wrap .et-pb-icon'
        ) );
        if("on" === $this->props['icon_vertical_alignment']){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "$this->main_css_element.df-item-wrap .df-post-read-more",
                'declaration' => "display: flex; align-items: center;"
            ));
        }
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%%.df-item-wrap .et-pb-icon',
            'hover'             => '.df-post-outer-wrap:hover %%order_class%%.df-item-wrap .et-pb-icon'
        ));
        if($this->props['image_full_width'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% img',
                'declaration' => 'width: 100%;'
            ));
        }

        if ($this->props['image_scale'] === 'df-image-rotate-left') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => ".df-hover-trigger:hover {$this->main_css_element} .df-image-rotate-left img, :focus.df-hover-trigger {$this->main_css_element} .df-image-rotate-left img",
                'declaration' => sprintf('transform: scale(%1$s) rotate(-15deg);', $this->props['image_scale_hover'])
            ));
        }
        if ($this->props['image_scale'] === 'df-image-rotate-right') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => ".df-hover-trigger:hover {$this->main_css_element} .df-image-rotate-right img, :focus.df-hover-trigger {$this->main_css_element} .df-image-rotate-right img",
                'declaration' => sprintf('transform: scale(%1$s) rotate(15deg);', $this->props['image_scale_hover'])
            ));
        }
        // overlay
        if($this->props['overlay'] === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-hover-effect .df-overlay',
                'declaration' => sprintf('background-image: linear-gradient(%4$s, %1$s 0, %2$s %3$s);',
                    $this->props['overlay_primary'],
                    $this->props['overlay_secondary'],
                    '100%',
                    $this->props['overlay_direction']
                )
            ));
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'overlay_icon_size',
                'type'              => 'font-size',
                'selector'          => '%%order_class%%.df-item-wrap .df-icon-overlay'
            ) );
            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'overlay_icon_color',
                'type'              => 'color',
                'selector'          => '%%order_class%%.df-item-wrap .df-icon-overlay'
            ));
        }

        if('on' === $this->props['show_author_image']) {
	        $allowed_unit = ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'];
			$unit = '';
			if(!in_array(preg_replace("/[^a-zA-Z%]+/", "", $this->props['author_image_size']), $allowed_unit)){
				$unit = 'px';
			}
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'author_image_size',
                'type'              => 'width',
                'selector'          => '%%order_class%%.df-item-wrap .author-image img',
                'default'           => '16px',
	            'fixed_unit'        => $unit
            ));
        }

        if($this->props['type'] === 'divider') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df-post-ele-divider',
                'declaration' => sprintf('background-image: linear-gradient(%1$s, %2$s %4$s, %3$s %5$s);',
                    $this->props['divider_color_direction'],
                    $this->props['divider_color_primary'],
                    $this->props['divider_color_secondary'],
                    $this->props['divider_color_start'],
                    $this->props['divider_color_end']
                )
            ));
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'divider_line_height',
                'type'              => 'height',
                'selector'          => '%%order_class%%.df-item-wrap .df-post-ele-divider'
            ) );
        }
        // spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'element_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element}",
            'hover'             => ".df-hover-trigger:hover {$this->main_css_element}",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'element_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element}",
            'hover'             => ".df-hover-trigger:hover {$this->main_css_element}",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} a",
            'hover'             => ".df-hover-trigger:hover {$this->main_css_element} a",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'button_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} a",
            'hover'             => ".df-hover-trigger:hover {$this->main_css_element} a",
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'author_image_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .author-image",
            'hover'             => ".df-hover-trigger:hover {$this->main_css_element} .author-image",
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .df-icon-image, {$this->main_css_element} .et-pb-icon",
            'hover'             => ".df-hover-trigger:hover {$this->main_css_element} .df-icon-image, .df-hover-trigger:hover {$this->main_css_element} .et-pb-icon",
        ));
        if ($this->props['type'] === 'divider') {
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'divider_padding',
                'type'              => 'padding',
                'selector'          => "{$this->main_css_element} span",
                'hover'             => ".df-hover-trigger:hover {$this->main_css_element} span",
            ));
            $this->set_margin_padding_styles(array(
                'render_slug'       => $render_slug,
                'slug'              => 'divider_margin',
                'type'              => 'margin',
                'selector'          => "{$this->main_css_element} span",
                'hover'             => ".df-hover-trigger:hover {$this->main_css_element} span",
            ));
        }

        if($this->props['type'] === 'acf_fields') {
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'acf_image_width',
                'type'              => 'max-width',
                'selector'          => '%%order_class%%.df-item-wrap img.df-acf-image'
            ) );
        }

        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'overlay_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .df-icon-overlay',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }
    }

    public function render( $attrs, $content, $render_slug ) {
		$this->handle_fa_icon();
        $this->additional_css_styles($render_slug);
        global $df_post_items, $df_post_items_outside;
        $type_settings = array();

        if('select' !== $this->props['type']) {
            $type_settings['type'] = $this->props['type'];
            $type_settings['class'] = ET_Builder_Element::get_module_order_class( $render_slug );
            // title
            $type_settings['title_tag'] = $this->props['title_tag'];
            // content
            $type_settings['post_content'] = $this->props['post_content'];
            $type_settings['use_post_excrpt'] = $this->props['use_post_excrpt'];
            $type_settings['excerpt_length'] = $this->props['excerpt_length'];
            // meta
            $type_settings['date_format'] = str_replace( '%92', '\\', $this->props['date_format'] );
            $type_settings['show_author_image'] = $this->props['show_author_image'];
            $type_settings['hide_author_text'] = $this->props['hide_author_text'];
            $type_settings['comment_text'] = $this->props['comment_text'];
            // Read More
            $type_settings['read_more_text'] = $this->props['read_more_text'];
            // icon
            $type_settings['image_icon'] = $this->props['image_icon'];
            $type_settings['image_alt_text'] = $this->props['image_alt_text'] ? $this->props['image_alt_text'] : '';
            $type_settings['use_icon'] = $this->props['use_icon'];
            $type_settings['font_icon'] = isset($this->props['font_icon']) && $this->props['font_icon'] !== '' ?
                esc_attr(et_pb_process_font_icon( $this->props['font_icon'] )) : '5';
            // image
            $type_settings['image_size'] = $this->props['image_size'];

            // placement
            $type_settings['placement'] = $this->props['outside_wrapper'];
            // hover
            $type_settings['image_scale'] = $this->props['image_scale'];
            $type_settings['overlay'] = $this->props['overlay'];
            // overlay icon
            $type_settings['overlay_icon'] = $this->props['overlay_icon'];
            $type_settings['overlay_icon_reveal'] = $this->props['overlay_icon_reveal'];
            $type_settings['overlay_font_icon'] = !empty($this->props['overlay_font_icon']) ?
                $this->props['overlay_font_icon'] : '%%16%%';

            // custom text
            $type_settings['custom_text'] = $this->props['custom_text'];

            // acf fields
            if($this->props['type'] == 'acf_fields' && class_exists('ACF') && $this->acf_extension === 'on') {
                $type_settings['post_type_for_acf'] = $this->props['post_type_for_acf'];
                $type_settings['acf_field'] = $this->props['post_type_for_acf'] != '' && $this->props['post_type_for_acf'] != 'select' ?
                    $this->props[$this->props['post_type_for_acf']] : '';
                $type_settings['acf_before_label'] = $this->props['acf_before_label'] != '' ?
                    $this->props['acf_before_label'] : '';
                $type_settings['acf_after_label'] = $this->props['acf_after_label'] != '' ?
                    $this->props['acf_after_label'] : '';
                $type_settings['acf_url_text'] = $this->props['acf_url_text'] !== '' ?
                    $this->props['acf_url_text'] : '';
                $type_settings['acf_url_new_window'] = $this->props['acf_url_new_window'] !== '' ?
                    $this->props['acf_url_new_window'] : 'off';
                $type_settings['acf_email_text'] = $this->props['acf_email_text'] !== '' ?
                    $this->props['acf_email_text'] : '';
            }

            // background
            $type_settings['background_enable_mask_style'] = isset($this->props['background_enable_mask_style']) ? $this->props['background_enable_mask_style'] : 'off' ;
            $type_settings['background_enable_pattern_style'] = isset($this->props['background_enable_pattern_style']) ? $this->props['background_enable_pattern_style'] : 'off';
        }

        if ($this->props['outside_wrapper'] === 'on') {
            $df_post_items_outside[] = $type_settings;
        } else {
            $df_post_items[] = $type_settings;
        }

        return;
    }
}
new DIFL_PostItem;
