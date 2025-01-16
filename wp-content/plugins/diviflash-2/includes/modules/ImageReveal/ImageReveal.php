<?php

class DIFL_ImageReveal extends ET_Builder_Module {
	public $slug = 'difl_imagereveal';
	public $vb_support = 'on';
	public $icon_path;

	use DF_UTLS;

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
	);

	public function init() {
		$this->name             = esc_html__( 'Image Reveal', 'divi_flash' );
		$this->plural           = esc_html__( 'Image Reveal', 'divi_flash' );
		$this->main_css_element = "%%order_class%%";
		$this->icon_path        = DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/image-reveal.svg';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'content_image'            => esc_html__( 'Image', 'divi_flash' ),
					'content_reveal_animation' => esc_html__( 'Reveal Amination', 'divi_flash' ),
					'content_placeholder'      => esc_html__( 'Placeholder', 'divi_flash' ),
					'content_overlay'          => esc_html__( 'Overlay', 'divi_flash' ),
					'content_hover_overlay'    => esc_html__( 'Hover', 'divi_flash' ),
					'content_caption'          => esc_html__( 'Caption', 'divi_flash' ),
					'content_link'             => esc_html__( 'Link', 'divi_flash' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'design_hover_overlay' => array(
						'title'             => esc_html__( 'Hover Overlay Content Styles', 'divi_flash' ),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'title'       => array(
								'name' => esc_html__( 'Title', 'divi_flash' )
							),
							'description' => array(
								'name' => esc_html__( 'Description', 'divi_flash' )
							),
						),
					),
					'design_caption'       => esc_html__( 'Caption Styles', 'divi_flash' ),
					'alignment'            => esc_html__( 'Alignment', 'divi_flash' ),
					'width'                => array(
						'title'    => et_builder_i18n( 'Sizing' ),
						'priority' => 65,
					),
				),
			),
		);

		$this->advanced_fields = array(
			'fonts'          => array(
				'overlay_title'       => array(
					'label'          => esc_html__( '' ),
					'css'            => array(
						'main' => "{$this->main_css_element} .difl__image_reveal_hover_overlay .difl__image_reveal_hover_overlay_content .title",
					),
					'line_height'    => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'font_size'      => array(
						'default' => '18px',
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'font'           => array(
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'text_color'     => array(
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'text_align'     => array(
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'text_shadow'    => array(
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'letter_spacing' => array(
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'design_hover_overlay',
					'sub_toggle'     => 'title',
					'important'      => false,
				),
				'overlay_description' => array(
					'label'          => esc_html__( '' ),
					'css'            => array(
						'main' => "{$this->main_css_element} .difl__image_reveal_hover_overlay .difl__image_reveal_hover_overlay_content .description",
					),
					'line_height'    => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'font_size'      => array(
						'default' => '14px',
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'font'           => array(
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'text_color'     => array(
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'text_align'     => array(
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'text_shadow'    => array(
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'letter_spacing' => array(
						'show_if' => array(
							'field_hover_overlay_content_enable' => 'on',
							'field_hover_overlay_enable'         => 'on'
						),
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'design_hover_overlay',
					'sub_toggle'     => 'description',
					'important'      => false,
				),
				'caption'             => array(
					'label'          => esc_html__( '' ),
					'css'            => array(
						'main' => "{$this->main_css_element} .difl__image_reveal_wrapper .difl__image_wrap .difl_caption",
					),
					'line_height'    => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
						'show_if' => array(
							'field_caption_enable' => 'on'
						),
					),
					'font_size'      => array(
						'default' => '16px',
						'show_if' => array(
							'field_caption_enable' => 'on'
						),
					),
					'font'           => array(
						'show_if' => array(
							'field_caption_enable' => 'on'
						),
					),
					'text_color'     => array(
						'show_if' => array(
							'field_caption_enable' => 'on'
						),
					),
					'text_align'     => array(
						'show_if' => array(
							'field_caption_enable' => 'on'
						),
					),
					'text_shadow'    => array(
						'show_if' => array(
							'field_caption_enable' => 'on'
						),
					),
					'letter_spacing' => array(
						'show_if' => array(
							'field_caption_enable' => 'on'
						),
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'design_caption',
					'important'      => false,
				),
			),
			'borders' => array(
				'default' => array(
					'css'      => array(
						'main'  => "$this->main_css_element .difl__image_reveal_wrapper .difl__image_wrap",
						'hover' => "$this->main_css_element .difl__image_reveal_wrapper .difl__image_wrap",
					),
				),
			),
			'box_shadow'     => array(
				'default'     => true,
				'placeholder' => array(
					'css'         => array(
						'main'  => "$this->main_css_element .difl__image_reveal_wrapper .difl__image_wrap",
						'hover' => "$this->main_css_element .difl__image_reveal_wrapper .difl__image_wrap",
					),
					'toggle_slug' => 'content_placeholder',
					'tab_slug'    => 'general',
				),
			),
			'max_width'      => array(
				'css'     => array(
					'width'            => "{$this->main_css_element}",
					'max_width'        => "{$this->main_css_element}",
					'module_alignment' => "{$this->main_css_element}",
				),
				'options' => array(
					'width'     => array(
						'default'         => 'auto',
						'depends_show_if' => 'off',
					),
					'max_width' => array(
						'default'         => '100',
						'depends_show_if' => 'off',
					),
				),
			),
			'margin_padding' => array(
				'css' => array(
					'main'      => "{$this->main_css_element}",
					'important' => 'all',
				),
			),
			'text'           => false,
			'link_options'   => false,
		);
	}

	public function get_fields() {

		$image                      = array(
			'field_image' => array(
				'label'              => esc_html__( 'Image', 'divi_flash' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_html__( 'Upload an image', 'divi_flash' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'        => esc_attr__( 'Set As Image', 'divi_flash' ),
				'hide_metadata'      => true,
				'affects'            => array(
					'alt',
					'title_text',
				),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'divi_flash' ),
				'toggle_slug'        => 'content_image',
				'dynamic_content'    => 'image',
			),
			'alt'         => array(
				'label'           => esc_html__( 'Alternative Text', 'divi_flash' ),
				'type'            => 'text',
				'depends_show_if' => 'on',
				'depends_on'      => array(
					'image_field',
				),
				'description'     => esc_html__( 'This defines the HTML ALT text. A short description of your image can be placed here.', 'divi_flash' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content_image',
				'dynamic_content' => 'text',
			),
			'title_text'  => array(
				'label'           => esc_html__( 'Title Text', 'divi_flash' ),
				'type'            => 'text',
				'depends_show_if' => 'on',
				'depends_on'      => array(
					'image_field',
				),
				'description'     => esc_html__( 'This defines the HTML Title text.', 'divi_flash' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content_image',
			)
		);
		$link                       = array(
			'field_lightbox_enable' => array(
				'label'            => esc_html__( 'Open in Lightbox', 'divi_flash' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'default_on_front' => 'off',
				'affects'          => array(
					'field_link_url',
					'field_link_target',
				),
				'toggle_slug'      => 'content_link',
				'description'      => esc_html__( 'Here you can choose whether or not the image should open in Lightbox. Note: if you select to open the image in Lightbox, url options below will be ignored.', 'divi_flash' ),
			),
			'field_link_url'        => array(
				'label'            => esc_html__( 'Image Link URL', 'difl-image-rebuild' ),
				'type'             => 'text',
				'depends_show_if'  => 'off',
				'default_on_front' => '',
				'description'      => esc_html__( 'If you would like your image to be a link, input your destination URL here. No link will be created if this field is left blank.', 'divi_flash' ),
				'toggle_slug'      => 'content_link',
			),
			'field_link_target'     => array(
				'label'           => esc_html__( 'Image Link Target', 'divi_flash' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'same_window' => esc_html__( 'In The Same Window', 'divi_flash' ),
					'new_window'  => esc_html__( 'In The New Tab', 'divi_flash' ),
				),
				'default'         => 'same_window',
				'depends_show_if' => 'off',
				'toggle_slug'     => 'content_link',
				'description'     => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'divi_flash' ),
			),
		);
		$reveal_animation           = array(
			'field_reveal_directions' => array(
				'label'       => esc_html__( 'Direction', 'divi_flash' ),
				'type'        => 'select',
				'options'     => array(
					'reveal_ltr' => esc_html__( 'Left to Right', 'divi_flash' ),
					'reveal_rtl' => esc_html__( 'Right to Left', 'divi_flash' ),
					'reveal_ttb' => esc_html__( 'Top to Bottom', 'divi_flash' ),
					'reveal_btt' => esc_html__( 'Bottom to Top', 'divi_flash' ),
				),
				'default'     => 'reveal_ltr',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content_reveal_animation',
				'description' => esc_html__( 'You can control the direction of Reveal Animation', 'divi_flash' ),
			)
		);
		$reveal_color_bg            = $this->df_add_bg_field(
			array(
				'label'       => 'Reveal Color',
				'key'         => 'reveal_color_bg',
				'toggle_slug' => 'content_reveal_animation',
				'tab_slug'    => 'general',
				'image'       => false,
			)
		);
		$reveal_time                = array(
			'field_reveal_delay'          => array(
				'label'          => esc_html__( 'Delay (Sec)', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '0',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '5',
					'step' => '0.1',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_reveal_animation',
				'description'    => esc_html__( 'You can control the delay of the Reveal Image Animation', 'divi_flash' ),
			),
			'field_reveal_animation_time' => array(
				'label'          => esc_html__( 'Animation Time (Sec)', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '1',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '5',
					'step' => '0.05',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_reveal_animation',
				'description'    => esc_html__( 'You can control the time of Animation to Reveal the Image', 'divi_flash' ),
			),
			'field_reveal_view_port'      => array(
				'label'          => esc_html__( 'Animate in Viewport (%)', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '25',
				'default_unit'   => '%',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '5',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_reveal_animation',
				'description'    => esc_html__( 'You can set the position of the Viewport(Display position) when Image will Reveal', 'divi_flash' ),
			),
		);
		$placeholder_bg             = $this->df_add_bg_field(
			array(
				'label'       => 'Color',
				'key'         => 'field_placeholder_bg',
				'toggle_slug' => 'content_placeholder',
				'tab_slug'    => 'general',
			)
		);
		$placeholder_rounded_corner = array(
			'field_rounded_corner' => array(
				'label'           => esc_html__( 'Rounded Corners', 'divi_flash' ),
				'type'            => 'border-radius',
				'hover'           => 'tabs',
				'validate_input'  => true,
				'default'         => 'on|0px|0px|0px|0px',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content_placeholder',
				'sub_toggle'      => '',
				'attr_suffix'     => 'ir',
				'option_category' => 'border',
				'description'     => esc_html__( 'Here you can control the corner radius of this element. Enable the link icon to control all four corners at once, or disable to define custom values for each.', 'divi_flash' ),
				'tooltip'         => esc_html__( 'Sync values', 'divi_flash' ),
				'mobile_options'  => true,
				'sticky'          => true,
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
			),
		);
		$reveal_overlay             = array(
			'field_overlay_enable'  => array(
				'label'           => esc_html__( 'Enable', 'divi_flash' ),
				'type'            => 'yes_no_button',
				'option_category' => 'layout',
				'options'         => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content_overlay',
				'description'     => esc_html__( 'If enabled, user can set an overlay over the Image', 'divi_flash' ),

			),
			'field_overlay_color'   => array(
				'label'       => esc_html__( 'Color on Default', 'divi_flash' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content_overlay',
				'default'     => '#FFFFFF',
				'description' => esc_html__( 'Set an overlay color, it will be visible over the Image', 'divi_flash' ),
				'show_if'     => array(
					'field_overlay_enable' => 'on'
				),
			),
			'field_overlay_opacity' => array(
				'label'          => esc_html__( 'Opacity', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '0.15',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1',
					'step' => '0.01',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_overlay',
				'description'    => esc_html__( 'Define how transparent or opaque overlay color should be.', 'divi_flash' ),
				'show_if'        => array(
					'field_overlay_enable' => 'on'
				),
			),

		);
		$reveal_hover_overlay       = array(
			'field_hover_overlay_enable'            => array(
				'label'           => esc_html__( 'Enable Overlay', 'divi_flash' ),
				'type'            => 'yes_no_button',
				'option_category' => 'layout',
				'options'         => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content_hover_overlay',
				'description'     => esc_html__( 'If enabled, an overlay color will be displayed over the image when the mouse hovers.', 'divi_flash' ),
				'show_if'         => array(
					'field_hover_image_effect_enable' => 'off',
				),
			),
			'field_hover_overlay_color'             => array(
				'label'       => esc_html__( 'Color', 'divi_flash' ),
				'type'        => 'color-alpha',
				'default'     => "#FFFFFF",
				'tab_slug'    => 'general',
				'toggle_slug' => 'content_hover_overlay',
				'description' => esc_html__( 'Set a color. This color will be visible when the mouse hovers over the image.', 'divi_flash' ),
				'show_if'     => array(
					'field_hover_overlay_enable'      => 'on',
					'field_hover_image_effect_enable' => 'off',
				),
			),
			'field_hover_overlay_opacity'           => array(
				'label'          => esc_html__( 'Opacity', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '0.3',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '1',
					'step' => '0.1',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_hover_overlay',
				'description'    => esc_html__( 'Define how transparent or opaque hover overlay color should be.', 'divi_flash' ),
				'show_if'        => array(
					'field_hover_overlay_enable'      => 'on',
					'field_hover_image_effect_enable' => 'off',
				),
			),
			'field_hover_overlay_arrive_from' => array(
				'label'       => esc_html__( 'Styles', 'divi_flash' ),
				'type'        => 'select',
				'options'     => array(
					'top' => esc_html__( 'Top to Bottom', 'divi_flash' ),
					'right' => esc_html__( 'Right to Left', 'divi_flash' ),
					'bottom' => esc_html__( 'Bottom to Top', 'divi_flash' ),
					'left' => esc_html__( 'Left to Right', 'divi_flash' ),
					'linear' => esc_html__( 'Linear', 'divi_flash' ),
					'ease_in_out' => esc_html__( 'Ease In Out', 'divi_flash' ),
					'ease' => esc_html__( 'Ease', 'divi_flash' ),
					'ease_in' => esc_html__( 'Ease In', 'divi_flash' ),
					'ease_out' => esc_html__( 'Ease Out', 'divi_flash' ),
				),
				'default'         => 'right',
				'toggleable'      => true,
				'multi_selection' => false,
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content_hover_overlay',
				'description'     => esc_html__( 'You can control the overlay style when the mouse hovers.', 'divi_flash' ),
				'show_if'         => array(
					'field_hover_overlay_enable'      => 'on',
					'field_hover_image_effect_enable' => 'off',
				),
			),
			'field_hover_overlay_content_arrive_from' => array(
				'label'       => esc_html__( 'Text Content Reveal', 'divi_flash' ),
				'type'        => 'select',
				'options'     => array(
					'top' => esc_html__( 'Top', 'divi_flash' ),
					'right' => esc_html__( 'Right', 'divi_flash' ),
					'bottom' => esc_html__( 'Bottom', 'divi_flash' ),
					'left' => esc_html__( 'Left', 'divi_flash' ),
				),
				'default'         => 'right',
				'toggleable'      => true,
				'multi_selection' => false,
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content_hover_overlay',
				'description'     => esc_html__( 'You can control the Content when the mouse hovers.', 'divi_flash' ),
				'show_if'         => array(
					'field_hover_overlay_enable'      => 'on',
					'field_hover_image_effect_enable' => 'off',
				),
			),
			'field_hover_overlay_transition_delay'  => array(
				'label'          => esc_html__( 'Animation Delay', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '0',
				'default_unit'   => 's',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '3',
					'step' => '0.1',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_hover_overlay',
				'description'    => esc_html__( 'If you would like to add a delay before your animation runs you can designate that delay here in seconds. This can be useful when using multiple animated modules together.', 'divi_flash' ),
				'show_if'        => array(
					'field_hover_overlay_enable'      => 'on',
					'field_hover_image_effect_enable' => 'off',
				),
			),
			'field_hover_overlay_transition_time'   => array(
				'label'          => esc_html__( 'Animation Time', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '0.6',
				'default_unit'   => 's',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '3',
					'step' => '0.5',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_hover_overlay',
				'description'    => esc_html__( 'You can control the arrival animation time of the hover overlay', 'divi_flash' ),
				'show_if'        => array(
					'field_hover_overlay_enable'      => 'on',
					'field_hover_image_effect_enable' => 'off',
				),
			),
			'field_hover_overlay_content_enable'    => array(
				'label'           => esc_html__( 'Content', 'divi_flash' ),
				'type'            => 'yes_no_button',
				'option_category' => 'layout',
				'options'         => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content_hover_overlay',
				'description'     => esc_html__( 'If enabled, you can set content on the hover overlay, it will be displayed with hover overlay when the mouse hovers.', 'divi_flash' ),
				'show_if'         => array(
					'field_hover_overlay_enable'      => 'on',
					'field_hover_image_effect_enable' => 'off',
				),
			),
			'field_hover_overlay_content_field'     => array(
				'label'               => esc_html__( 'Hover Overlay Content', 'divi_flash' ),
				'type'                => 'composite',
				'tab_slug'            => 'general',
				'toggle_slug'         => 'content_hover_overlay',
				'composite_type'      => 'default',
				'composite_structure' => array(
					'hover_overlay_title_tab' => array(
						// 'icon'     => 'setting',
						'type'     => 'text',
						'label'    => esc_html__( 'Title', 'divi_flash' ),
						'controls' => array(
							'field_hover_content_title_text' => array(
								'label'            => esc_html__( 'Title Text', 'divi_flash' ),
								'type'             => 'text',
								'option_category'  => 'basic_option',
								'default_on_front' => 'Your Title Goes Here',
								'tab_slug'         => 'general',
								'toggle_slug'      => 'content_hover_overlay',
								'description'      => esc_html__( 'Set the title of the hover overlay content', 'divi_flash' ),
							),

						),
					),
					'hover_overlay_desc_tab'  => array(
						// 'icon'  => 'hover_icon',
						'type'     => 'text',
						'label'    => esc_html__( 'Description', 'divi_flash' ),
						'controls' => array(
							'field_hover_content_desc_text' => array(
								'label'            => esc_html__( 'Description Text', 'divi_flash' ),
								'type'             => 'tiny_mce',
								'option_category'  => 'basic_option',
								'default_on_front' => 'Your Description Goes Here',
								'tab_slug'         => 'general',
								'toggle_slug'      => 'content_hover_overlay',
								'description'      => esc_html__( 'Set the description of the hover overlay content', 'divi_flash' ),
							),

						),
					)
				),
				'show_if'             => array(
					'field_hover_overlay_content_enable' => 'on',
					'field_hover_overlay_enable'         => 'on',
					'field_hover_image_effect_enable'    => 'off',
				),
			),
			'field_hover_overlay_content_placement' => array(
				'label'       => esc_html__( 'Content Placement', 'divi_flash' ),
				'type'        => 'select',
				'options'     => array(
					'start'  => esc_html__( 'Top', 'divi_flash' ),
					'center' => esc_html__( 'Center', 'divi_flash' ),
					'end'    => esc_html__( 'Bottom', 'divi_flash' ),
				),
				'default'     => 'center',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content_hover_overlay',
				'description' => esc_html__( 'You can control the placement of the hover overlay content', 'divi_flash' ),
				'show_if'     => array(
					'field_hover_overlay_content_enable' => 'on',
					'field_hover_overlay_enable'         => 'on',
					'field_hover_image_effect_enable'    => 'off',
				),
			),
			'field_hover_overlay_content_alignment' => array(
				'label'           => esc_html__( 'Content Alignment', 'divi_flash' ),
				'type'            => 'multiple_buttons',
				'options'         => array(
					'start'  => array(
						'title' => esc_html__( 'Left', 'divi_flash' ),
						'icon'  => 'align-left', // Any svg icon that is defined on ETBuilderIcon component
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'divi_flash' ),
						'icon'  => 'align-center', // Any svg icon that is defined on ETBuilderIcon component
					),
					'end'    => array(
						'title' => esc_html__( 'Right', 'divi_flash' ),
						'icon'  => 'align-right', // Any svg icon that is defined on ETBuilderIcon component
					),
				),
				'default'         => 'center',
				'toggleable'      => true,
				'multi_selection' => false,
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content_hover_overlay',
				'description'     => esc_html__( 'You can control the hover overlay content alignment', 'divi_flash' ),
				'show_if'         => array(
					'field_hover_overlay_content_enable' => 'on',
					'field_hover_overlay_enable'         => 'on',
					'field_hover_image_effect_enable'    => 'off',
				),
			),
			'field_hover_overlay_container_padding' => array(
				'label'       => esc_html__( 'Padding around content', 'divi_flash' ),
				'type'        => 'custom_margin',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content_hover_overlay',
				'description' => esc_html__( 'You can set the padding around the hover overlay content', 'divi_flash' ),
				'show_if'     => array(
					'field_hover_overlay_content_enable' => 'on',
					'field_hover_overlay_enable'         => 'on',
					'field_hover_image_effect_enable'    => 'off',

				),
			),
			'field_hover_image_effect_enable'       => array(
				'label'           => esc_html__( 'Enable Image Effect', 'divi_flash' ),
				'type'            => 'yes_no_button',
				'option_category' => 'layout',
				'options'         => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content_hover_overlay',
				'description'     => esc_html__( 'If enabled, you can set few effects on image,this effect will be display when mouse hover', 'divi_flash' ),
				'show_if'         => array(
					'field_hover_overlay_enable' => 'off',
				),
			),
			'field_effect_style'                    => array(
				'label'       => esc_html__( 'Effects', 'divi_flash' ),
				'type'        => 'select',
				'options'     => array(
					'none'                     => esc_html__( 'None', 'divi_flash' ),
					'zoom_in'                  => esc_html__( 'Zoom In', 'divi_flash' ),
					'zoom_n_rotate'            => esc_html__( 'Zoom & Rotate', 'divi_flash' ),
					'blur_out_with_zooming_in' => esc_html__( 'Blur Out with Zooming Out', 'divi_flash' ),
					'colorize_with_zooming_in' => esc_html__( 'Colorize with Zooming In', 'divi_flash' ),
				),
				'default'     => 'default_n',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content_hover_overlay',
				'description' => esc_html__( 'Choose an effect, its action will be visible when mouse hovers', 'divi_flash' ),
				'show_if'     => array(
					'field_hover_overlay_enable'      => 'off',
					'field_hover_image_effect_enable' => 'on',
				),
			),
			'field_zoom_scale'                      => array(
				'label'          => esc_html__( 'Zooming Range', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '1.5',
				'default_tablet' => '1.3',
				'default_phone'  => '1.2',
				'default_unit'   => '',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '5',
					'step' => '0.1',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_hover_overlay',
				'description'    => esc_html__( 'You can control the transition time of the Effects', 'divi_flash' ),
				'mobile_options' => true,
				'responsive'     => true,
				'show_if'        => array(
					'field_hover_overlay_enable'      => 'off',
					'field_hover_image_effect_enable' => 'on',
					'field_effect_style'              => array(
						'zoom_in',
						'zoom_n_rotate',
						'blur_out_with_zooming_in',
						'colorize_with_zooming_in'
					),
				),
				'show_if_not'    => array(
					'field_hover_image_effect_enable' => 'off',
				),
			),
			'field_zooming_time'                    => array(
				'label'          => esc_html__( 'Animation Duration (Sec)', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '0.25',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '5',
					'step' => '0.05',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_hover_overlay',
				'description'    => esc_html__( 'You can control the Animation time of the Effect', 'divi_flash' ),
				'show_if'        => array(
					'field_hover_overlay_enable'      => 'off',
					'field_hover_image_effect_enable' => 'on',
					'field_effect_style'              => array(
						'zoom_in',
						'zoom_n_rotate',
						'blur_out_with_zooming_in',
						'colorize_with_zooming_in'
					),
				),
			),
			'field_zooming_blur_out_time'           => array(
				'label'          => esc_html__( 'Blur Out Animation Duration (Sec)', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '0.25',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '5',
					'step' => '0.05',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_hover_overlay',
				'description'    => esc_html__( 'You can control the Animation Blur Out time of the Effect', 'divi_flash' ),
				'show_if'        => array(
					'field_hover_overlay_enable'      => 'off',
					'field_hover_image_effect_enable' => 'on',
					'field_effect_style'              => array( 'blur_out_with_zooming_in' ),
				),
			),
			'field_zooming_blur_level'              => array(
				'label'          => esc_html__( 'Blur Level (px)', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '2',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '15',
					'step' => '0.5',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_hover_overlay',
				'description'    => esc_html__( 'Blur by this amount.', 'divi_flash' ),
				'show_if'        => array(
					'field_hover_overlay_enable'      => 'off',
					'field_hover_image_effect_enable' => 'on',
					'field_effect_style'              => array( 'blur_out_with_zooming_in' ),
				),
			),
			'field_grayscale'                       => array(
				'label'          => esc_html__( 'Gray Scale Level (%)', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '100',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_hover_overlay',
				'description'    => esc_html__( 'You can control the Gray Scale of the Effect', 'divi_flash' ),
				'show_if'        => array(
					'field_hover_overlay_enable'      => 'off',
					'field_hover_image_effect_enable' => 'on',
					'field_effect_style'              => array( 'colorize_with_zooming_in' ),
				),
			),
			'field_Speed_curve'                     => array(
				'label'       => esc_html__( 'Animation Speed Curve', 'divi_flash' ),
				'type'        => 'select',
				'options'     => array(
					'ease-in-out' => esc_html__( 'Ease-In-Out', 'divi_flash' ),
					'ease-in'     => esc_html__( 'Ease-In', 'divi_flash' ),
					'ease-out'    => esc_html__( 'Ease-Out', 'divi_flash' ),
					'linear'      => esc_html__( 'Linear', 'divi_flash' ),
				),
				'default'     => 'ease-in',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content_hover_overlay',
				'description' => esc_html__( 'Here you can adjust the easing method of your animation. Easing your animation in and out will create a smoother effect when compared to a linear speed curve.', 'divi_flash' ),
				'show_if'     => array(
					'field_hover_overlay_enable'      => 'off',
					'field_hover_image_effect_enable' => 'on',
					'field_effect_style'              => array(
						'zoom_in',
						'zoom_n_rotate',
						'blur_out_with_zooming_in',
						'colorize_with_zooming_in'
					),
				),
			),
			'field_zoom_rotate'                     => array(
				'label'          => esc_html__( 'Rotate Range (Degree)', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '25',
				'default_tablet' => '25',
				'default_phone'  => '25',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '90',
					'step' => '1',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_hover_overlay',
				'description'    => esc_html__( 'Here you can adjust the rotation of your image.', 'divi_flash' ),
				'mobile_options' => true,
				'responsive'     => true,
				'show_if'        => array(
					'field_hover_overlay_enable'      => 'off',
					'field_hover_image_effect_enable' => 'on',
					'field_effect_style'              => 'zoom_n_rotate',
				),
			),
		);
		$allign_and_sizing          = array(
			'align'           => array(
				'label'            => esc_html__( 'Image Alignment', 'divi_flash' ),
				'type'             => 'text_align',
				'option_category'  => 'layout',
				'options'          => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default_on_front' => 'left',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'alignment',
				'description'      => esc_html__( 'Here you can choose the image alignment.', 'divi_flash' ),
				'options_icon'     => 'module_align',
				'mobile_options'   => true,
			),
			'force_fullwidth' => array(
				'label'            => esc_html__( 'Force Fullwidth', 'divi_flash' ),
				'description'      => esc_html__( "When enabled, this will force your image to extend 100% of the width of the column it's in.", 'divi_flash' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'layout',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'default_on_front' => 'off',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'width',
				'affects'          => array(
					'max_width',
					'width',
				),
			),
		);
		$reveal_caption             = array(
			'field_caption_enable'     => array(
				'label'           => esc_html__( 'Enable', 'divi_flash' ),
				'type'            => 'yes_no_button',
				'option_category' => 'layout',
				'options'         => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'content_caption',
				'description'     => esc_html__( 'If enabled, user can set a caption for the image', 'divi_flash' ),
			),
			'field_caption_title'      => array(
				'label'       => esc_html__( 'Text', 'divi_flash' ),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content_caption',
				'description' => esc_html__( 'Add caption for the image', 'divi_flash' ),
				'show_if'     => array(
					'field_caption_enable' => 'on',
				),
			),
			'field_caption_placement'  => array(
				'label'       => esc_html__( 'Placement', 'divi_flash' ),
				'type'        => 'select',
				'options'     => array(
					'top'    => esc_html__( 'Top', 'divi_flash' ),
					'bottom' => esc_html__( 'Bottom', 'divi_flash' ),
				),
				'default'     => 'bottom',
				// 'default_on_front' => true,
				'tab_slug'    => 'general',
				'toggle_slug' => 'content_caption',
				'description' => esc_html__( 'You can control the placement of the caption', 'divi_flash' ),
				'show_if'     => array(
					'field_caption_enable' => 'on',
				),
			),
			'field_caption_background' => array(
				'label'          => esc_html__( 'Background Color', 'divi_flash' ),
				'type'           => 'color-alpha',
				'default'        => '',
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_caption',
				'description'    => esc_html__( 'Set background for the caption section', 'divi_flash' ),
				'mobile_options' => true,
				'responsive'     => true,
				'show_if'        => array(
					'field_caption_enable' => 'on',
				),
			),
			'field_caption_padding'    => array(
				'label'       => esc_html__( 'Padding', 'divi_flash' ),
				'type'        => 'custom_margin',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content_caption',
				'description' => esc_html__( 'Set padding around the caption', 'divi_flash' ),
				'show_if'     => array(
					'field_caption_enable' => 'on',
				),
			),
		);
		$reveal_effects             = array(
			'field_reveal_effects'               => array(
				'label'       => esc_html__( 'Effect', 'divi_flash' ),
				'type'        => 'select',
				'options'     => array(
					'none'         => esc_html__( 'None', 'divi_flash' ),
					'difl_bounce'       => esc_html__( 'Bounce', 'divi_flash' ),
					'difl_flash'        => esc_html__( 'Flash', 'divi_flash' ),
					'difl_pulse'        => esc_html__( 'Pulse', 'divi_flash' ),
					'difl_rubberBand'   => esc_html__( 'Rubber Band', 'divi_flash' ),
					'difl_headShake'    => esc_html__( 'Head Shake', 'divi_flash' ),
					'difl_swing'        => esc_html__( 'Swing', 'divi_flash' ),
					'difl_tada'         => esc_html__( 'Tada', 'divi_flash' ),
					'difl_wobble'       => esc_html__( 'Wobble', 'divi_flash' ),
					'difl_jello'        => esc_html__( 'Jello', 'divi_flash' ),
					'difl_heartBeat'    => esc_html__( 'Heart Beat', 'divi_flash' ),
				),
				'default'     => 'none',
				'tab_slug'    => 'general',
				'toggle_slug' => 'content_reveal_animation',
				'description' => esc_html__( 'Set effect when Image Reveal', 'divi_flash' ),
			),
			'field_reveal_effect_delay'          => array(
				'label'          => esc_html__( 'Effect Delay (Sec)', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '0',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '5',
					'step' => '0.1',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_reveal_animation',
				'description'    => esc_html__( 'If you would like to add a delay before your animation runs you can designate that delay here in seconds. This can be useful when using multiple animated modules together.', 'divi_flash' ),
				'show_if_not'    => array(
					'field_reveal_effects' => 'none'
				),
			),
			'field_reveal_effect_animation_time' => array(
				'label'          => esc_html__( 'Effect Time (Sec)', 'divi_flash' ),
				'type'           => 'range',
				'default'        => '1',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '5',
					'step' => '0.05',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'content_reveal_animation',
				'description'    => esc_html__( 'If you would like to add a time of your animation runs you can designate that time here in seconds. This can be useful when using multiple animated modules together.', 'divi_flash' ),
				'show_if_not'    => array(
					'field_reveal_effects' => 'none'
				),
			),
		);

		return array_merge(
			$image,
			$link,
			$reveal_animation,
			$reveal_color_bg,
			$reveal_time,
			$placeholder_bg,
			$placeholder_rounded_corner,
			$reveal_overlay,
			$reveal_hover_overlay,
			$allign_and_sizing,
			$reveal_caption,
			$reveal_effects
		);
	}

	public function get_transition_fields_css_props() {
		$fields       = parent::get_transition_fields_css_props();
		$main_wrapper = "$this->main_css_element .difl__image_reveal_wrapper";
		$reveal_area  = "$main_wrapper .difl__image_reveal_element";

		// Reveal Color
		$fields = $this->df_background_transition(
			array(
				'fields'   => $fields,
				'key'      => 'reveal_color_bg',
				'selector' => "$this->main_css_element .difl__image_reveal_wrapper .difl__image_reveal_element",
			)
		);

		// Placeholder Color
		$fields = $this->df_background_transition(
			array(
				'fields'   => $fields,
				'key'      => 'field_placeholder_bg',
				'selector' => "$this->main_css_element .difl__image_reveal_wrapper .difl__image_wrap",
			)
		);

		return $fields;
	}

	public function get_alignment( $device = 'desktop' ) {
		$is_desktop = 'desktop' === $device;
		$suffix     = ! $is_desktop ? "_{$device}" : '';
		$alignment  = $is_desktop && isset( $this->props['align'] ) ? $this->props['align'] : '';

		if ( ! $is_desktop && et_pb_responsive_options()->is_responsive_enabled( $this->props, 'align' ) ) {
			$alignment = et_pb_responsive_options()->get_any_value( $this->props, "align{$suffix}" );
		}

		return et_pb_get_alignment( $alignment );
	}

	/**
	 * @param $hex
	 * @param $alpha
	 *
	 * @return string RGBA(0,0,0,0.1)
	 */
	function hexToRgba( $hex, $alpha = 1.0 ) {
		if( preg_match('/^#[a-f0-9]{6}$/i', $hex) )
		{
			$hex = ltrim( $hex, '#' );
			if ( strlen( $hex ) === 3 ) {
				$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
			}
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );

			return "rgba($r, $g, $b, $alpha)";
		}else{
			return $hex;
		}

	}

	public function additional_css_styles( $render_slug ) {
		// Overlay Container Class
		$__class__overlay_container     = '%%order_class%% .difl__image_reveal_wrapper .difl__image_reveal_overlay';
		$__class__hover_overlay_content = '%%order_class%% .difl__image_reveal_wrapper .difl__image_reveal_hover_overlay .difl__image_reveal_hover_overlay_content';

		// Hover Zoom Effect Classes
		$__class__hover_image_effect       = '%%order_class%% .difl__image_reveal_wrapper .difl__image_reveal_content img';
		$__class__hover_image_effect_hover = '%%order_class%% .difl__image_reveal_wrapper .difl__image_reveal_content:hover img';

		// Overlay field diclaretion
		$__field__overlay_enable    = $this->props['field_overlay_enable'];
		$__field__overlay_color     = $this->props['field_overlay_color'];
		$__field__overlay_opacity   = $this->props['field_overlay_opacity'];
		$__field__reveal_directions = $this->props['field_reveal_directions'];

		// Caption Field Declaration
		$__field__caption_enable     = $this->props['field_caption_enable'];
		$__field__caption_background = $this->props['field_caption_background'];
		$__field__caption_padding    = $this->props['field_caption_padding'];

		// Allignment, Force Full width Field Declaration
		$align           = $this->get_alignment();
		$align_tablet    = $this->get_alignment( 'tablet' );
		$align_phone     = $this->get_alignment( 'phone' );
		$force_fullwidth = $this->props['force_fullwidth'];

		// Reveal Animation Time, Delay Field Declaration
		$__field__reveal_animation_delay = $this->props['field_reveal_delay'];
		$__field__reveal_animation_time  = $this->props['field_reveal_animation_time'];

		// Reveal Effect Field Declaration
		$__field__reveal_effects_enable         = $this->props['field_reveal_effects'];
		$__field__reveal_effect_animation_delay = $this->props['field_reveal_effect_delay'];
		$__field__reveal_effect_animation_time  = $this->props['field_reveal_effect_animation_time'];

		// Hover Overlay Color, Opacity, Transition Delay, Transition Time Field Declaration
		$__field__hover_overlay_enable            = $this->props['field_hover_overlay_enable'];
		$__field__hover_overlay_color             = $this->props['field_hover_overlay_color'];
		$__field__hover_overlay_opacity           = $this->props['field_hover_overlay_opacity'];
		$__field__hover_overlay_transition_time   = $this->props['field_hover_overlay_transition_time'];
		$__field__hover_overlay_transition_delay  = $this->props['field_hover_overlay_transition_delay'];
		$__field__hover_overlay_arrive_from       = $this->props['field_hover_overlay_arrive_from'];
		$__field__hover_overlay_content_arrive_from       = $this->props['field_hover_overlay_content_arrive_from'];
		$__field__hover_overlay_content_placement = $this->props['field_hover_overlay_content_placement'];
		$__field__hover_overlay_content_alignment = $this->props['field_hover_overlay_content_alignment'];
		$__field__hover_overlay_container_padding = $this->props['field_hover_overlay_container_padding'];
		// Hover Zoom Effect Field Declaration
		$__field__hover_image_effect_enable = $this->props['field_hover_image_effect_enable'];
		$__field__hover_image_effect_style  = $this->props['field_effect_style'];
		$__field__zoom_scale                = $this->props['field_zoom_scale'];
		$__field__zooming_time              = $this->props['field_zooming_time'];
		$__field__Speed_curve               = $this->props['field_Speed_curve'];
		$__field__zoom_rotate               = $this->props['field_zoom_rotate'];
		$__field__zooming_blur_out_time     = $this->props['field_zooming_blur_out_time'];
		$__field__zooming_blur_level        = $this->props['field_zooming_blur_level'];
		$__field__zooming_grayscale         = $this->props['field_grayscale'];


		// Force Full Width handler
		if ( 'on' === $force_fullwidth ) {
			$el_style = array(
				'selector'    => '%%order_class%%',
				'declaration' => 'width: 100% !important; max-width: 100% !important;',
			);
			ET_Builder_Element::set_style( $render_slug, $el_style );

			$el_style = array(
				'selector'    => '%%order_class%% .difl__image_wrap',
				'declaration' => 'width: 100% !important; max-width: 100% !important;',
			);
			ET_Builder_Element::set_style( $render_slug, $el_style );
			$el_style = array(
				'selector'    => '%%order_class%% .difl__image_wrap img',
				'declaration' => 'width: 100% !important; max-width: 100% !important;',
			);
			ET_Builder_Element::set_style( $render_slug, $el_style );
		}

		// Placeholder Rounded Corner
		if ( isset( $this->props['field_rounded_corner_phone'] ) ) {
			$roundedCorner        = $this->props['field_rounded_corner_phone'];
			$roundedCorner_devide = explode( "|", $roundedCorner );
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__image_wrap',
				'declaration' => sprintf( '
				border-top-left-radius: %1$s;
				border-top-right-radius: %2$s;
                border-bottom-right-radius: %3$s;
                border-bottom-left-radius: %4$s;
				',
					! empty( $roundedCorner_devide[1] ) ? $roundedCorner_devide[1] : "0px",
					! empty( $roundedCorner_devide[2] ) ? $roundedCorner_devide[2] : "0px",
					! empty( $roundedCorner_devide[3] ) ? $roundedCorner_devide[3] : "0px",
					! empty( $roundedCorner_devide[4] ) ? $roundedCorner_devide[4] : "0px"
				),
				'media_query' => self::get_media_query( 'max_width_767' ),
			) );
		}
		if ( isset( $this->props['field_rounded_corner_tablet'] ) ) {
			$roundedCorner        = $this->props['field_rounded_corner_tablet'];
			$roundedCorner_devide = explode( "|", $roundedCorner );
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__image_wrap',
				'declaration' => sprintf( '
				border-top-left-radius: %1$s;
				border-top-right-radius: %2$s;
                border-bottom-right-radius: %3$s;
                border-bottom-left-radius: %4$s;
				',
					! empty( $roundedCorner_devide[1] ) ? $roundedCorner_devide[1] : "0px",
					! empty( $roundedCorner_devide[2] ) ? $roundedCorner_devide[2] : "0px",
					! empty( $roundedCorner_devide[3] ) ? $roundedCorner_devide[3] : "0px",
					! empty( $roundedCorner_devide[4] ) ? $roundedCorner_devide[4] : "0px"
				),
				'media_query' => self::get_media_query( '768_980' )
			) );
		}
		if ( isset( $this->props['field_rounded_corner'] ) ) {
			$roundedCorner        = $this->props['field_rounded_corner'];
			$roundedCorner_devide = explode( "|", $roundedCorner );
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__image_wrap',
				'declaration' => sprintf( '
				border-top-left-radius: %1$s;
				border-top-right-radius: %2$s;
                border-bottom-right-radius: %3$s;
                border-bottom-left-radius: %4$s;
				',
					! empty( $roundedCorner_devide[1] ) ? $roundedCorner_devide[1] : "0px",
					! empty( $roundedCorner_devide[2] ) ? $roundedCorner_devide[2] : "0px",
					! empty( $roundedCorner_devide[3] ) ? $roundedCorner_devide[3] : "0px",
					! empty( $roundedCorner_devide[4] ) ? $roundedCorner_devide[4] : "0px"
				),
				'media_query' => self::get_media_query( 'min_width_981' )
			) );
		}

		// Alignment handler
		$align_values = array(
			'desktop' => array(
				'text-align'      => esc_html( $align ),
				"margin-{$align}" => ! empty( $align ) && 'center' !== $align ? '0' : '',
			),
		);

		if ( ! empty( $align_tablet ) ) {
			$align_values['tablet'] = array(
				'text-align'             => esc_html( $align_tablet ),
				'margin-left'            => 'left' !== $align_tablet ? 'auto' : '',
				'margin-right'           => 'left' !== $align_tablet ? 'auto' : '',
				"margin-{$align_tablet}" => ! empty( $align_tablet ) && 'center' !== $align_tablet ? '0' : '',
			);
		}

		if ( ! empty( $align_phone ) ) {
			$align_values['phone'] = array(
				'text-align'            => esc_html( $align_phone ),
				'margin-left'           => 'left' !== $align_phone ? 'auto' : '',
				'margin-right'          => 'left' !== $align_phone ? 'auto' : '',
				"margin-{$align_phone}" => ! empty( $align_phone ) && 'center' !== $align_phone ? '0' : '',
			);
		}

		et_pb_responsive_options()->generate_responsive_css( $align_values, '%%order_class%%', '', $render_slug, '', 'alignment' );

		// Caption handler
		if ( 'on' === $__field__caption_enable ) {
			$caption_bg      = isset( $__field__caption_background ) && ! empty( $__field__caption_background ) ? $__field__caption_background : 'transparent';
			$caption_padding = isset( $__field__caption_padding ) ? $__field__caption_padding : '0px|0px|0px|0px';

			$caption_padding_devide = explode( "|", $caption_padding );
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__image_wrap .difl_caption',
				'declaration' => sprintf( '
				background: %1$s;
				padding-top: %2$s;
                padding-right: %3$s;
                padding-bottom: %4$s;
                padding-left: %5$s;
				',
					$caption_bg,
					! empty( $caption_padding_devide[0] ) ? $caption_padding_devide[0] : "0px",
					! empty( $caption_padding_devide[1] ) ? $caption_padding_devide[1] : "0px",
					! empty( $caption_padding_devide[2] ) ? $caption_padding_devide[2] : "0px",
					! empty( $caption_padding_devide[3] ) ? $caption_padding_devide[3] : "0px"
				)
			) );
		}

		//	Reveal Color handler
		if('on' === $this->props['reveal_color_bg_use_gradient']){
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "{$this->main_css_element} .difl__image_reveal_wrapper .difl__image_reveal_element",
				'declaration' => 'background-color: transparent !important;'
			) );
		}else{
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "{$this->main_css_element} .difl__image_reveal_wrapper .difl__image_reveal_element",
				'declaration' => 'background-color: #ffffff;'
			) );
		}
		$this->df_process_bg(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'reveal_color_bg',
				'selector'    => "$this->main_css_element .difl__image_reveal_wrapper .difl__image_reveal_element",
			)
		);


		// Placeholder Color handler
		$this->df_process_bg(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'field_placeholder_bg',
				'selector'    => "$this->main_css_element .difl__image_reveal_wrapper .difl__image_wrap",
			)
		);

		// Overlay Style handler
		if ( isset( $__field__overlay_enable ) ) {
			$color = $this->hexToRgba(
				! empty( $__field__overlay_color ) ? $__field__overlay_color : '#FFFFFF',
				$__field__overlay_opacity >= 0 ? $__field__overlay_opacity : 0.15 );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $__class__overlay_container,
				'declaration' => sprintf( 'background: %1$s;', $color )
			) );
		}

		// Reveal Animation Time, Delay Style handler
		if ( isset( $this->props['field_reveal_directions'] ) ) {
			$additionalCssItem  = array();
			$additionalCssItem2 = array();
			$additionalCssItem3 = array();
			$delay              = isset( $__field__reveal_animation_delay ) && ! empty( $__field__reveal_animation_delay ) ? $__field__reveal_animation_delay : 0;
			$anim_time          = isset( $__field__reveal_animation_time ) && ! empty( $__field__reveal_animation_time ) ?
				$__field__reveal_animation_time :
				1;

			$reveal_in_anim    = (float) $anim_time /2.0;
			$reveal_out_anim    = (float) $anim_time /2.0;
			$reveal_out_delay   = (float) $delay + (float) $reveal_in_anim;
			$direction          = ! empty( $__field__reveal_directions ) ? $__field__reveal_directions : "reveal_ltr";
			switch ( $direction ) {
				case 'reveal_ltr':
					$additionalCssItem  = array(
						'selector'    => '%%order_class%% .difl__image_reveal_lr img',
						'declaration' => "animation: fadeInImg 0s {$reveal_out_delay}s forwards;-webkit-animation: fadeInImg 0s {$reveal_out_delay}s forwards;"
					);
					$additionalCssItem2 = array(
						'selector'    => '%%order_class%% .difl__image_reveal_lr .difl__image_reveal_overlay',
						'declaration' => "animation: fadeInImg {$anim_time}s {$reveal_out_delay}s linear forwards;-webkit-animation: fadeInImg {$anim_time}s {$reveal_out_delay}s linear forwards;"
					);
					$additionalCssItem3 = array(
						'selector'    => '%%order_class%% .difl__image_reveal_lr .difl__image_reveal',
						'declaration' => "-webkit-animation: imageRevealLR {$reveal_in_anim}s {$delay}s, imageRevealOutLR {$reveal_out_anim}s {$reveal_out_delay}s;animation: imageRevealLR {$reveal_in_anim}s {$delay}s, imageRevealOutLR {$reveal_out_anim}s {$reveal_out_delay}s;-webkit-animation-fill-mode: forwards;animation-fill-mode: forwards"
					);
					break;
				case 'reveal_rtl':
					$additionalCssItem  = array(
						'selector'    => '%%order_class%% .difl__image_reveal_rl img',
						'declaration' => "animation: fadeInImg 0s {$reveal_out_delay}s forwards;-webkit-animation: fadeInImg 0s {$reveal_out_delay}s forwards;"
					);
					$additionalCssItem2 = array(
						'selector'    => '%%order_class%% .difl__image_reveal_rl .difl__image_reveal_overlay',
						'declaration' => "animation: fadeInImg {$anim_time}s {$reveal_out_delay}s linear forwards;-webkit-animation: fadeInImg {$anim_time}s {$reveal_out_delay}s linear forwards;"
					);
					$additionalCssItem3 = array(
						'selector'    => '%%order_class%% .difl__image_reveal_rl .difl__image_reveal',
						'declaration' => "-webkit-animation: imageRevealRL {$reveal_in_anim}s {$delay}s, imageRevealOutRL {$reveal_out_anim}s {$reveal_out_delay}s;animation: imageRevealRL {$reveal_in_anim}s {$delay}s, imageRevealOutRL {$reveal_out_anim}s {$reveal_out_delay}s;-webkit-animation-fill-mode: forwards;animation-fill-mode: forwards"
					);
					break;
				case 'reveal_ttb':
					$additionalCssItem  = array(
						'selector'    => '%%order_class%% .difl__image_reveal_tb img',
						'declaration' => "animation: fadeInImg 0s {$reveal_out_delay}s forwards;-webkit-animation: fadeInImg 0s {$reveal_out_delay}s forwards;"
					);
					$additionalCssItem2 = array(
						'selector'    => '%%order_class%% .difl__image_reveal_tb .difl__image_reveal_overlay',
						'declaration' => "animation: fadeInImg {$anim_time}s {$reveal_out_delay}s linear forwards;-webkit-animation: fadeInImg {$anim_time}s {$reveal_out_delay}s linear forwards;"
					);
					$additionalCssItem3 = array(
						'selector'    => '%%order_class%% .difl__image_reveal_tb .difl__image_reveal',
						'declaration' => "-webkit-animation: imageRevealTB {$reveal_in_anim}s {$delay}s, imageRevealOutTB {$reveal_out_anim}s {$reveal_out_delay}s;animation: imageRevealTB {$reveal_in_anim}s {$delay}s, imageRevealOutTB {$reveal_out_anim}s {$reveal_out_delay}s;-webkit-animation-fill-mode: forwards;animation-fill-mode: forwards"
					);
					break;
				case 'reveal_btt':
					$additionalCssItem  = array(
						'selector'    => '%%order_class%% .difl__image_reveal_bt img',
						'declaration' => "animation: fadeInImg 0s {$reveal_out_delay}s forwards;-webkit-animation: fadeInImg 0s {$reveal_out_delay}s forwards;"
					);
					$additionalCssItem2 = array(
						'selector'    => '%%order_class%% .difl__image_reveal_bt .difl__image_reveal_overlay',
						'declaration' => "animation: fadeInImg {$anim_time}s {$reveal_out_delay}s linear forwards;-webkit-animation: fadeInImg {$anim_time}s {$reveal_out_delay}s linear forwards;"
					);
					$additionalCssItem3 = array(
						'selector'    => '%%order_class%% .difl__image_reveal_bt .difl__image_reveal',
						'declaration' => "-webkit-animation: imageRevealBT {$reveal_in_anim}s {$delay}s, imageRevealOutBT {$reveal_out_anim}s {$reveal_out_delay}s;animation: imageRevealBT {$reveal_in_anim}s {$delay}s, imageRevealOutBT {$reveal_out_anim}s {$reveal_out_delay}s;-webkit-animation-fill-mode: forwards;animation-fill-mode: forwards"
					);
					break;
				default:
					$additionalCssItem  = array(
						'selector'    => '%%order_class%% .difl__image_reveal_bt img',
						'declaration' => "animation: fadeInImg 0s 0.5s forwards;-webkit-animation: fadeInImg 0s 0.5s forwards;"
					);
					$additionalCssItem2 = array(
						'selector'    => '%%order_class%% .difl__image_reveal_bt .difl__image_reveal_overlay',
						'declaration' => "animation: fadeInImg 0.25s 0.5s linear forwards;-webkit-animation: fadeInImg 0.25s 0.5s linear forwards;"
					);
					$additionalCssItem3 = array(
						'selector'    => '%%order_class%% .difl__image_reveal_bt .difl__image_reveal',
						'declaration' => "-webkit-animation: imageRevealLR 0.25s 0s, imageRevealOutLR 0.5s 0.5s;animation: imageRevealLR 0.25s 0s, imageRevealOutLR 0.5s 0.5s;-webkit-animation-fill-mode: forwards;animation-fill-mode: forwards"
					);

			}
			ET_Builder_Element::set_style( $render_slug, $additionalCssItem );
			ET_Builder_Element::set_style( $render_slug, $additionalCssItem2 );
			ET_Builder_Element::set_style( $render_slug, $additionalCssItem3 );
		}

		// Reveal Effect style handler
		if ( isset( $__field__reveal_effects_enable ) && 'none' !== $__field__reveal_effects_enable ) {
			$reveal_delay              = isset( $__field__reveal_animation_delay ) && ! empty( $__field__reveal_animation_delay ) ? $__field__reveal_animation_delay : 0.1;
			$effect_delay = isset( $__field__reveal_effect_animation_delay ) && ! empty( $__field__reveal_effect_animation_delay ) ? $__field__reveal_effect_animation_delay : 0;
			$effect_time  = isset( $__field__reveal_effect_animation_time ) && ! empty( $__field__reveal_effect_animation_time ) ? $__field__reveal_effect_animation_time : 1;
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__animate',
				'declaration' => sprintf( '
					-webkit-animation-duration: %1$ss;
				    animation-duration: %1$ss;
				    -webkit-animation-duration: %1$ss;
				    animation-duration: %1$ss;
				    animation-delay: %2$ss;
				',
					$effect_time,
					(float)$effect_delay+(float)$reveal_delay
				)
			) );
		}

		// Hover Overlay Color, Opacity, Transition Delay, Transition Time style handler
		if ( isset( $__field__hover_overlay_enable ) && 'on' === $__field__hover_overlay_enable ) {
			$ho_color   = isset( $__field__hover_overlay_color ) && ! empty( $__field__hover_overlay_color ) ? $__field__hover_overlay_color : "#FFFFFF";
			$ho_opacity = isset( $__field__hover_overlay_opacity ) && (!empty( $__field__hover_overlay_opacity ) || empty($__field__hover_overlay_opacity)) ? $__field__hover_overlay_opacity : 0.3;

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $__class__hover_overlay_content,
				'declaration' => sprintf( 'background-color: %1$s;', $this->hexToRgba( $ho_color, $ho_opacity ) )
			) );

			// Hover Overlay Animation Control
			$ho_anim_time   = isset( $__field__hover_overlay_transition_time ) && ! empty( $__field__hover_overlay_transition_time ) ? $__field__hover_overlay_transition_time : '0.6s';
			$ho_anim_delay  = isset( $__field__hover_overlay_transition_delay ) && ! empty( $__field__hover_overlay_transition_delay ) ? $__field__hover_overlay_transition_delay : '0s';
			$ho_arrive_from = isset( $__field__hover_overlay_arrive_from ) && ! empty( $__field__hover_overlay_arrive_from ) ? $__field__hover_overlay_arrive_from : 'left';
			$ho_anim_time   = substr( $ho_anim_time, - 1 ) !== 's' ? $ho_anim_time . "s" : $ho_anim_time;
			$ho_anim_delay  = substr( $ho_anim_delay, - 1 ) !== 's' ? $ho_anim_delay . "s" : $ho_anim_delay;
			switch ( $ho_arrive_from ) {
				case 'left':
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__hover_overlay_lr:hover .difl__image_reveal_hover_overlay_content',
						'declaration' => sprintf( '
							-webkit-animation: imageRevealLR %1$s linear %2$s;
                            animation: imageRevealLR %1$s linear %2$s;
                            -webkit-animation-fill-mode: forwards;
                            animation-fill-mode: forwards;
                            ',
							$ho_anim_time,
							$ho_anim_delay
						),
					) );
					break;
				case 'right':
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__hover_overlay_rl:hover .difl__image_reveal_hover_overlay_content',
						'declaration' => sprintf( '
							-webkit-animation: imageRevealRL %1$s linear %2$s;
                            animation: imageRevealRL %1$s linear %2$s;
                            -webkit-animation-fill-mode: forwards;
                            animation-fill-mode: forwards;
                            ',
							$ho_anim_time,
							$ho_anim_delay
						),
					) );
					break;
				case 'top':
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__hover_overlay_tb:hover .difl__image_reveal_hover_overlay_content',
						'declaration' => sprintf( '
							-webkit-animation: imageRevealTB %1$s linear %2$s;
                            animation: imageRevealTB %1$s linear %2$s;
                            -webkit-animation-fill-mode: forwards;
                            animation-fill-mode: forwards;
                            ',
							$ho_anim_time,
							$ho_anim_delay
						),
					) );
					break;
				case 'bottom':
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__hover_overlay_bt:hover .difl__image_reveal_hover_overlay_content',
						'declaration' => sprintf( '
							-webkit-animation: imageRevealBT %1$s linear %2$s;
                            animation: imageRevealBT %1$s linear %2$s;
                            -webkit-animation-fill-mode: forwards;
                            animation-fill-mode: forwards;
                            ',
							$ho_anim_time,
							$ho_anim_delay
						),
					) );
					break;
				case 'linear':
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__hover_overlay_linear:hover .difl__image_reveal_hover_overlay_content',
						'declaration' => sprintf( '
							-webkit-animation: overlayViewer %1$s linear %2$s;
                            animation: overlayViewer %1$s linear %2$s;
                            -webkit-animation-fill-mode: both;
                            animation-fill-mode: both;
                            ',
							$ho_anim_time,
							$ho_anim_delay
						),
					) );
					break;
				case 'ease_in_out':
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__hover_overlay_ease_in_out:hover .difl__image_reveal_hover_overlay_content',
						'declaration' => sprintf( '
							-webkit-animation: overlayViewer %1$s ease-in-out %2$s;
                            animation: overlayViewer %1$s ease-in-out %2$s;
                            -webkit-animation-fill-mode: both;
                            animation-fill-mode: both;
                            ',
							$ho_anim_time,
							$ho_anim_delay
						),
					) );
					break;
				case 'ease':
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__hover_overlay_ease:hover .difl__image_reveal_hover_overlay_content',
						'declaration' => sprintf( '
							-webkit-animation: overlayViewer %1$s ease %2$s;
                            animation: overlayViewer %1$s ease %2$s;
                            -webkit-animation-fill-mode: both;
                            animation-fill-mode: both;
                            ',
							$ho_anim_time,
							$ho_anim_delay
						),
					) );
					break;
				case 'ease_in':
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__hover_overlay_ease_in:hover .difl__image_reveal_hover_overlay_content',
						'declaration' => sprintf( '
							-webkit-animation: overlayViewer %1$s ease-in %2$s;
                            animation: overlayViewer %1$s ease-in %2$s;
                            -webkit-animation-fill-mode: both;
                            animation-fill-mode: both;
                            ',
							$ho_anim_time,
							$ho_anim_delay
						),
					) );
					break;
				case 'ease_out':
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__hover_overlay_ease_out:hover .difl__image_reveal_hover_overlay_content',
						'declaration' => sprintf( '
							-webkit-animation: overlayViewer %1$s ease-out %2$s;
                            animation: overlayViewer %1$s ease-out %2$s;
                            -webkit-animation-fill-mode: both;
                            animation-fill-mode: both;
                            ',
							$ho_anim_time,
							$ho_anim_delay
						),
					) );
					break;
				default:
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_wrapper .difl__hover_overlay_lr:hover .difl__image_reveal_hover_overlay_content',
						'declaration' => "
							-webkit-animation: imageRevealLR 0.5s linear 0s;
                            animation: imageRevealLR 0.5s linear 0s;
                            -webkit-animation-fill-mode: forwards;
                            animation-fill-mode: forwards;
                        ",
					) );

			}

			// Hover Overlay Content Controll
			$ho_content_placement = isset( $__field__hover_overlay_content_placement ) && ! empty( $__field__hover_overlay_content_placement ) ? $__field__hover_overlay_content_placement : 'center';
			$ho_content_alignment = isset( $__field__hover_overlay_content_alignment ) && ! empty( $__field__hover_overlay_content_alignment ) ? $__field__hover_overlay_content_alignment : 'center';
			$ho_content_padding   = isset( $__field__hover_overlay_container_padding ) && ! empty( $__field__hover_overlay_container_padding ) ? $__field__hover_overlay_container_padding : '0px|0px|0px|0px';
			$ho_padding_devide    = explode( "|", $ho_content_padding );
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $__class__hover_overlay_content,
				'declaration' => sprintf( '
				justify-content: %1$s;
				align-items: %2$s;
				padding-top: %3$s;
                padding-right: %4$s;
                padding-bottom: %5$s;
                padding-left: %6$s;
				',
					$ho_content_placement,
					$ho_content_alignment,
					! empty( $ho_padding_devide[0] ) ? $ho_padding_devide[0] : "0px",
					! empty( $ho_padding_devide[1] ) ? $ho_padding_devide[1] : "0px",
					! empty( $ho_padding_devide[2] ) ? $ho_padding_devide[2] : "0px",
					! empty( $ho_padding_devide[3] ) ? $ho_padding_devide[3] : "0px"
				)
			) );

			// Hover Overlay Content Animation
			$ho_content_arrive_from = isset( $__field__hover_overlay_content_arrive_from ) && ! empty( $__field__hover_overlay_content_arrive_from ) ? $__field__hover_overlay_content_arrive_from : 'left';
			switch ( $ho_content_arrive_from ) {
				case 'left':
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_hover_overlay_content .arrival',
						'declaration' => sprintf( '
							transition: all 1s ease-in-out %1$s;
                            transform: translateX(-2rem);
                            ',
							$ho_anim_delay
						),
					) );
					break;
				case 'right':
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_hover_overlay_content .arrival',
						'declaration' => sprintf( '
							transition: all 1s ease-in-out %1$s;
                            transform: translateX(2rem);
                            ',
							$ho_anim_delay
						),
					) );
					break;
				case 'top':
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_hover_overlay_content .arrival',
						'declaration' => sprintf( '
							transition: all 1s ease-in-out %1$s;
                            transform: translateY(-2rem);
                            ',
							$ho_anim_delay
						),
					) );
					break;
				case 'bottom':
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_hover_overlay_content .arrival',
						'declaration' => sprintf( '
							transition: all 1s ease-in-out %1$s;
                            transform: translateY(2rem);
                            ',
							$ho_anim_delay
						),
					) );
					break;
				default:
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .difl__image_reveal_hover_overlay_content .arrival',
						'declaration' => "
							transition: all 1s ease-in-out 0s;
                            transform: translateX(-1.5rem);
                        ",
					) );

			}

		}

		// Hover Zoom Effect style handle
		if ( 'on' === $__field__hover_image_effect_enable && ( ! isset( $__field__hover_image_effect_enable ) || 'off' === $__field__hover_overlay_enable ) ) {
			$h_effetc = isset( $__field__hover_image_effect_style ) && 'none' !== $__field__hover_image_effect_style ?
				$__field__hover_image_effect_style : 'none';

			switch ( $h_effetc ) {
				case 'zoom_in':
					$zoom_scale        = isset( $__field__zoom_scale ) && ! empty( $__field__zoom_scale ) ? $__field__zoom_scale : 1.5;
					$zooming_time      = isset( $__field__zooming_time ) && ! empty( $__field__zooming_time ) ? $__field__zooming_time : 0.25;
					$field_Speed_curve = isset( $__field__Speed_curve ) && ! empty( $__field__Speed_curve ) ? $__field__Speed_curve : 'ease-in';
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => $__class__hover_image_effect_hover,
						'declaration' => sprintf( '
							transform-origin: center center;
	                        transition: transform %2$ss, visibility %4$ss %3$s;
	                        -ms-transform:scale(%1$s);
	                        -webkit-transform: scale(%1$s);
	                        transform: scale(%1$s);
						',
							$zoom_scale,
							$zooming_time,
							$field_Speed_curve,
							((float)$zooming_time/2)
						)
					) );
					break;
				case 'zoom_n_rotate':
					$zoom_n_scale          = isset( $__field__zoom_scale ) && ! empty( $__field__zoom_scale ) ? $__field__zoom_scale : 1.5;
					$zooming_n_time        = isset( $__field__zooming_time ) && ! empty( $__field__zooming_time ) ? $__field__zooming_time : 0.25;
					$field_z_n_Speed_curve = isset( $__field__Speed_curve ) && ! empty( $__field__Speed_curve ) ? $__field__Speed_curve : 'ease-in';
					$zoom_n_rotate         = isset( $__field__zoom_rotate ) && ! empty( $__field__zoom_rotate ) ? $__field__zoom_rotate : '25';

					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => $__class__hover_image_effect_hover,
						'declaration' => sprintf( '
						transform-origin: center center;
                        transition: transform %2$ss, visibility %5$ss %3$s;
                        -ms-transform:scale(%1$s) rotate(%4$sdeg);
                        -webkit-transform: scale(%1$s) rotate(%4$sdeg);
                        transform: scale(%1$s) rotate(%4$sdeg);
						',
							$zoom_n_scale,
							$zooming_n_time,
							$field_z_n_Speed_curve,
							$zoom_n_rotate,
							((float)$zooming_n_time/2)
						)
					) );
					break;
				case 'blur_out_with_zooming_in':
					$zoom_bo_scale          = isset( $__field__zoom_scale ) && ! empty( $__field__zoom_scale ) ? $__field__zoom_scale : 1.5;
					$zooming_bo_time        = isset( $__field__zooming_time ) && ! empty( $__field__zooming_time ) ? $__field__zooming_time : 0.25;
					$field_bo_Speed_curve   = isset( $__field__Speed_curve ) && ! empty( $__field__Speed_curve ) ? $__field__Speed_curve : 'ease-in';
					$field_bo_blur_out_time = isset( $__field__zooming_blur_out_time ) && ! empty( $__field__zooming_blur_out_time ) ? $__field__zooming_blur_out_time : '.25';
					$field_bo_blur_level    = isset( $__field__zooming_blur_level ) && ! empty( $__field__zooming_blur_level ) ? $__field__zooming_blur_level : '2';

					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => $__class__hover_image_effect,
						'declaration' => sprintf( '
						transform: scale(%1$s);
                        transition: transform %2$ss, filter %4$ss %3$s;
                        filter: blur(%5$spx);
						',
							$zoom_bo_scale,
							$zooming_bo_time,
							$field_bo_Speed_curve,
							$field_bo_blur_out_time,
							$field_bo_blur_level
						)
					) );
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => $__class__hover_image_effect_hover,
						'declaration' => 'transform: scale(1);filter: blur(0);'
					) );
					break;
				case 'colorize_with_zooming_in':
					$zoom_c_scale          = isset( $__field__zoom_scale ) && ! empty( $__field__zoom_scale ) ? $__field__zoom_scale : 1.5;
					$zooming_c_time          = isset( $__field__zooming_time ) && ! empty( $__field__zooming_time ) ? $__field__zooming_time : 0.25;
					$field_c_Speed_curve     = isset( $__field__Speed_curve ) && ! empty( $__field__Speed_curve ) ? $__field__Speed_curve : 'ease-in';
					$field_c_field_grayscale = isset( $__field__zooming_grayscale ) && ! empty( $__field__zooming_grayscale ) ? $__field__zooming_grayscale . "%" : '100%';

					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => $__class__hover_image_effect,
						'declaration' => sprintf( '
							transition: transform %1$ss, filter %1$ss %2$s;
	                        filter: grayscale(%3$s);
						',
							$zooming_c_time,
							$field_c_Speed_curve,
							$field_c_field_grayscale
						)
					) );
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => $__class__hover_image_effect_hover,
						'declaration' => sprintf('transform: scale(%1$s);filter: grayscale(0);',$zoom_c_scale)
					) );
					break;
			}
		}

	}

	function getRevealDirection( $direction ) {
		switch ( $direction ) {
			case 'reveal_ltr':
				return 'difl__image_reveal_lr';
			case 'reveal_rtl':
				return 'difl__image_reveal_rl';
			case 'reveal_ttb':
				return 'difl__image_reveal_tb';
			case 'reveal_btt':
				return 'difl__image_reveal_bt';
			default:
				return 'difl__image_reveal_lr';
		}
	}

	function getHoverOverlayDirection( $direction ) {
		switch ( $direction ) {
			case 'left':
				return 'difl__hover_overlay_lr';
			case 'right':
				return 'difl__hover_overlay_rl';
			case 'top':
				return 'difl__hover_overlay_tb';
			case 'bottom':
				return 'difl__hover_overlay_bt';
			case 'linear':
				return 'difl__hover_overlay_linear';
			case 'ease_in_out':
				return 'difl__hover_overlay_ease_in_out';
			case 'ease':
				return 'difl__hover_overlay_ease';
			case 'ease_in':
				return 'difl__hover_overlay_ease_in';
			case 'ease_out':
				return 'difl__hover_overlay_ease_out';
			default:
				return 'difl__hover_overlay_lr';
		}
	}

	function generateHoverOverlay() {
		$hover_overlay_content = ( isset( $this->props['field_hover_overlay_content_enable'] ) && 'on' === $this->props['field_hover_overlay_content_enable'] ) ? sprintf( '<h3 class="title arrival">%1$s</h3><div class="description arrival">%2$s</div>',
			( isset( $this->props['field_hover_content_title_text'] ) && ! empty( $this->props['field_hover_content_title_text'] ) ) ? $this->props['field_hover_content_title_text'] : "Your Title Goes Here..",
			( isset( $this->props['field_hover_content_desc_text'] ) && ! empty( $this->props['field_hover_content_desc_text'] ) ) ? $this->props['field_hover_content_desc_text'] : "Your Description Goes Here..."
		) : "";
		$ho_arrive_from        = ( isset( $this->props['field_hover_overlay_arrive_from'] ) && ! empty( $this->props['field_hover_overlay_arrive_from'] ) ) ? $this->props['field_hover_overlay_arrive_from'] : "left";


		$hover_overlay = ( isset( $this->props['field_hover_overlay_enable'] ) && 'on' === $this->props['field_hover_overlay_enable'] ) ? "<div class= 'difl__image_reveal_hover_overlay {$this->getHoverOverlayDirection($ho_arrive_from)}'>
                        <div class='difl__image_reveal_hover_overlay_content'>
                            {$hover_overlay_content}
                        </div>
                    </div>" : "";


		return $hover_overlay;
	}

	function generateCaption( $image_caption ) {
		if ( 'on' === $this->props['field_caption_enable'] ) {
			$__field__caption_title = $this->props['field_caption_title'];
			$generate_caption       = sprintf(
				'<div class="difl_caption">%1$s</div>',
				$__field__caption_title
			);

			return $generate_caption;
		}
	}

	public function render( $attrs, $content, $render_slug ) {
		wp_enqueue_script( 'lightgallery-script' );
		wp_enqueue_script( 'df-image-reveal' );

		$this->additional_css_styles( $render_slug );

		$__field__image             = $this->props['field_image'];
		$__field__alt               = $this->props['alt'];
		$__field__title_text        = $this->props['title_text'];
		$__field__reveal_directions = $this->props['field_reveal_directions'];
		$__field__caption_enable    = $this->props['field_caption_enable'];
		$__field__caption_placement = $this->props['field_caption_placement'];
		$__field__hover_overlay_transition_time   = $this->props['field_hover_overlay_transition_time'];
		// Reveal Animation Time, Delay Field Declaration
		$__field__reveal_animation_delay = $this->props['field_reveal_delay'];
		$__field__reveal_animation_time  = $this->props['field_reveal_animation_time'];

		$srcset_sizes = et_get_image_srcset_sizes( $__field__image );
		$srcset       = "";
		$sizes        = "";

		if (
			isset( $srcset_sizes["srcset"], $srcset_sizes["sizes"] ) &&
			$srcset_sizes["srcset"] &&
			$srcset_sizes["sizes"]
		) {
			$srcset = $srcset_sizes["srcset"];
			$sizes  = $srcset_sizes["sizes"];
		}

		$attachment_id = et_get_attachment_id_by_url( $__field__image );
		$image_caption = wp_get_attachment_caption( $attachment_id );
		$image_size    = wp_get_attachment_image_src( $attachment_id, 'full' );
		$image_width   = isset( $image_size[1] ) ? $image_size[1] : "";
		$image_height  = isset( $image_size[2] ) ? $image_size[2] : "";

		$empty_image = "data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%200%200'%3E%3C/svg%3E";

		$delay              = isset( $__field__reveal_animation_delay ) && ! empty( $__field__reveal_animation_delay ) ? $__field__reveal_animation_delay : 0;
		$anim_time          = isset( $__field__reveal_animation_time ) && ! empty( $__field__reveal_animation_time ) ? $__field__reveal_animation_time : 1;
		$reveal_in_anim    = (float) $anim_time /2.0;
		$reveal_out_delay   = (float) $delay + $reveal_in_anim;
		$ho_anim_time   = isset( $__field__hover_overlay_transition_time ) && ! empty( $__field__hover_overlay_transition_time ) ? $__field__hover_overlay_transition_time : '0.6s';
		$ho_anim_time   = substr( $ho_anim_time, - 1 ) !== 's' ? $ho_anim_time . "s" : $ho_anim_time;
		$data_settings = [
			'revealDirectionClass' => isset( $__field__reveal_directions ) ? $this->getRevealDirection( $__field__reveal_directions ) : "difl__image_reveal_lr",
			'revealPosition'       => isset( $this->props['field_reveal_view_port'] ) && ! empty( $this->props['field_reveal_view_port'] ) ? str_replace( "%", "", $this->props['field_reveal_view_port'] ) : "25",
			'revealEffect'         => isset( $this->props['field_reveal_effects'] ) && ! empty( $this->props['field_reveal_effects'] ) && 'none' !== $this->props['field_reveal_effects'] ? $this->props['field_reveal_effects'] : "",
			'revealDelay'          => $reveal_out_delay,
			'use_light_box'        => isset( $this->props['field_lightbox_enable'] ) ? $this->props['field_lightbox_enable'] : 'off',
			'link_url'             => $this->props['field_lightbox_enable'] === 'off' && isset( $this->props['field_link_url'] ) && $this->props['field_link_url'] !== '' ? $this->props['field_link_url'] : '',
			'link_url_target'      => isset( $this->props['field_link_target'] ) ? $this->props['field_link_target'] : 'same_window',
			'animationTime'        => $ho_anim_time,
		];
		$link_url      = isset( $this->props['field_link_url'] ) && $this->props['field_link_url'] !== '' ? $this->props['field_link_url'] : "";
		$custom_url    = $this->props['field_lightbox_enable'] === 'off' && $link_url !== '' ?
			sprintf( 'data-url="%1$s"', $link_url )
			: '';

		return sprintf(
			'<div class="difl__image_reveal_wrapper" data-settings=\'%10$s\'>
                    <span class="difl__image_wrap link_lightbox" data-src="%14$s">
                        <div class="difl__image_reveal_content" %15$s>
                            <div class="difl__box_shadow_overlay"></div>
                            %12$s
                            <img
                                decoding="async"
                                fetchpriority="high"
                                src="%1$s"
                                alt="%3$s"
                                title="%4$s"                                
                                sizes="%6$s"
                                width="%7$s"
                                height="%8$s"
                            />
                            %13$s
                            <noscript><img
                                decoding="async"
                                src="%2$s"
                                srcSet="%5$s"
                            />
                            </noscript>
                        </div>
                        %9$s
                        %11$s
                        <div class="difl__image_reveal_element"></div>                        
                    </span>
                </div>',
			$empty_image,
			$__field__image,
			$__field__alt,
			$__field__title_text,
			$srcset,
			$sizes,
			$image_width,
			$image_height,
			( isset( $this->props['field_overlay_enable'] ) && 'on' === $this->props['field_overlay_enable'] ) ? '<div class="difl__image_reveal_overlay"></div>' : "",
			wp_json_encode( $data_settings ),
			$this->generateHoverOverlay(),
			'on' === $__field__caption_enable && 'top' === $__field__caption_placement ? $this->generateCaption( $image_caption ) : '',
			'on' === $__field__caption_enable && 'bottom' === $__field__caption_placement ? $this->generateCaption( $image_caption ) : '',
			$__field__image,
			$custom_url
		);
	}
}

new DIFL_ImageReveal;

