<?php
/**
 * Marquee Text Child Module Class
 *
 * This class provide text element functionalities in frontend.
 *
 * @since 1.3.9
 * @category Text
 * @link     http://#
 */
class DIFL_MarqueeTextItem extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;
	use DF_UTLS;

	/**
	 * Module's credit

	 * @var array
	 */
	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
	);

	/**
	 * Initialization

	 * @return void
	 */
	public function init() {
		$this->name                     = esc_html__( 'Marquee Text Item', 'divi_flash' );
		$this->plural                   = esc_html__( 'Marquee Text Items', 'divi_flash' );
		$this->slug                     = 'difl_marqueetextitem';
		$this->main_css_element         = '%%order_class%%';
		$this->type                     = 'child';
		$this->vb_support               = 'on';
		$this->child_title_var          = 'text';
		$this->child_title_fallback_var = 'admin_title';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'content'     => esc_html__( 'Content', 'divi_flash' ),
					'icon'        => esc_html__( 'Image & Icon', 'divi_flash' ),
					'admin_label' => array(
						'title'    => et_builder_i18n( 'Admin Label' ),
						'priority' => 99,
					),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'design_text'    => esc_html__( 'Content', 'divi_flash' ),
					'design_media'   => esc_html__( 'Image & Icon', 'divi_flash' ),
					'custom_spacing' => esc_html__( 'Spacing', 'divi_flash' ),
				),
			),
		);

		$text_wrapper = "div.df_marqueetext_wrapper $this->main_css_element div.df_marquee_text";

		$this->advanced_fields = array(
			'text'           => false,
			'max_width'      => false,
			'margin_padding' => false,
			'fonts'          => array(
				'title' => array(
					'toggle_slug'     => 'design_text',
					'tab_slug'        => 'advanced',
					'hide_text_align' => true,
					'line_height'     => array(
						'default' => '1.7em',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'text_color'      => array(
						'default' => '#333',
					),
					'css'             => array(
						'main'      => "$text_wrapper>*:not(div.df_marquee_media)",
						'hover'     => "$text_wrapper:hover>*:not(div.df_marquee_media)",
						'important' => 'all',
					),
				),
			),

			'borders'        => array(
				'default'           => array(),
				'text_media_border' => array(
					'css'         => array(
						'main' => array(
							'border_radii'        => "$text_wrapper div.df_marquee_media",
							'border_radii_hover'  => "$text_wrapper:hover div.df_marquee_media",
							'border_styles'       => "$text_wrapper div.df_marquee_media",
							'border_styles_hover' => "$text_wrapper:hover div.df_marquee_media",
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'design_media',
				),
			),

			'box_shadow'     => array(
				'default'              => array(),
				'text_media_boxshadow' => array(
					'label'           => esc_html__( 'Box Shadow', 'et_builder' ),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'design_media',
					'css'             => array(
						'main'  => "$text_wrapper div.df_marquee_media",
						'hover' => "$text_wrapper:hover div.df_marquee_media",
					),
				),
			),
		);
	}

	/**
	 * All fields settings

	 * @return array
	 */
	public function get_fields() {
		$admin_label = array(
			'admin_title' => array(
				'label'       => et_builder_i18n( 'Admin Label' ),
				'default'     => esc_html__( 'Marquee Text Item', 'divi_flash' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the item in the builder for easy identification.', 'divi_flash' ),
				'toggle_slug' => 'admin_label',
			),
		);

		$text = array(
			'text'     => array(
				'label'           => esc_html__( 'Text', 'divi_flash' ),
				'description'     => esc_html__( 'Here you can create the text that will be used within the Marquee text item.', 'divi_flash' ),
				'type'            => 'text',
				'toggle_slug'     => 'content',
				'dynamic_content' => 'text',
			),
			'text_tag' => array(
				'label'       => esc_html__( 'Text Tag', 'divi_flash' ),
				'description' => esc_html__( 'Define a html tag for the text.', 'divi_flash' ),
				'type'        => 'select',
				'options'     => array(
					'h1'   => esc_html__( 'H1 tag', 'divi_flash' ),
					'h2'   => esc_html__( 'H2 tag', 'divi_flash' ),
					'h3'   => esc_html__( 'H3 tag', 'divi_flash' ),
					'h4'   => esc_html__( 'H4 tag', 'divi_flash' ),
					'h5'   => esc_html__( 'H5 tag', 'divi_flash' ),
					'h6'   => esc_html__( 'H6 tag', 'divi_flash' ),
					'p'    => esc_html__( 'P tag', 'divi_flash' ),
					'span' => esc_html__( 'Span tag', 'divi_flash' ),
					'div'  => esc_html__( 'Div tag', 'divi_flash' ),
				),
				'toggle_slug' => 'content',
				'default'     => 'p',
			),
		);

		$icon = array(
			'enable_text_icon' => array(
				'label'       => esc_html__( 'Enable Icon', 'divi_flash' ),
				'description' => esc_html__( 'Here you can enable icon for text.', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'default'     => 'off',
				'options'     => array(
					'on'  => esc_html__( 'On', 'divi_flash' ),
					'off' => esc_html__( 'Off', 'divi_flash' ),
				),
				'toggle_slug' => 'icon',
			),
			'text_icon'        => array(
				'label'           => esc_html__( 'Icon', 'divi_flash' ),
				'description'     => esc_html__( 'Choose an icon to display with your text start & end.', 'divi_flash' ),
				'type'            => 'select_icon',
				'default'         => '&#x5c;||divi||400',
				'option_category' => 'basic_option',
				'class'           => array( 'et-pb-font-icon' ),
				'toggle_slug'     => 'icon',
				'show_if'         => array(
					'enable_text_icon' => 'on',
				),
			),
			'text_icon_color'  => array(
				'label'       => esc_html__( 'Icon Color', 'divi_flash' ),
				'description' => esc_html__( 'Here you can define a color for text icon.', 'divi_flash' ),
				'type'        => 'color-alpha',
				'toggle_slug' => 'design_media',
				'tab_slug'    => 'advanced',
				'hover'       => 'tabs',
				'show_if'     => array(
					'enable_text_icon' => 'on',
				),
			),
			'text_icon_size'   => array(
				'label'          => esc_html__( 'Icon Size', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can control icon size.', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'design_media',
				'tab_slug'       => 'advanced',
				'allowed_units'  => array( 'px' ),
				'range_settings' => array(
					'min'       => '0',
					'min_limit' => '0',
					'max'       => '100',
					'step'      => '1',
				),
				'hover'          => 'tabs',
				'responsive'     => true,
				'mobile_options' => true,
				'show_if'        => array(
					'enable_text_icon' => 'on',
				),
			),
		);

		$image = array(
			'text_img'             => array(
				'label'              => esc_html__( 'Image', 'divi_flash' ),
				'description'        => esc_html__( 'Upload an image.', 'divi_flash' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'divi_flash' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'        => esc_attr__( 'Set As Image', 'divi_flash' ),
				'toggle_slug'        => 'icon',
				'dynamic_content'    => 'image',
				'show_if_not'        => array(
					'enable_text_icon' => 'on',
				),
			),
			'text_img_alt_txt'     => array(
				'label'       => esc_html__( 'Image Alt Text', 'divi_flash' ),
				'description' => esc_html__( 'Alternative text for marker image.', 'divi_flash' ),
				'default'     => 'Image Alt',
				'type'        => 'text',
				'toggle_slug' => 'icon',
				'show_if_not' => array(
					'enable_text_icon' => 'on',
				),
			),
			'text_image_width'     => array(
				'label'          => esc_html__( 'Image Width', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can control image size of text.', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'design_media',
				'tab_slug'       => 'advanced',
				'default_unit'   => 'px',
				'allowed_units'  => array( '%', 'px' ),
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'hover'          => 'tabs',
				'responsive'     => true,
				'mobile_options' => true,
				'show_if_not'    => array(
					'enable_text_icon' => 'on',
				),
			),
			'set_media_after_text' => array(
				'label'       => esc_html__( 'After Text', 'divi_flash' ),
				'description' => esc_html__( 'Here you can set icon or image placement after text.', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'default'     => 'off',
				'options'     => array(
					'on'  => esc_html__( 'On', 'divi_flash' ),
					'off' => esc_html__( 'Off', 'divi_flash' ),
				),
				'toggle_slug' => 'design_media',
				'tab_slug'    => 'advanced',
			),
		);

		$text_bg = $this->df_add_bg_field(
			array(
				'label'       => 'Background',
				'key'         => 'text_background',
				'toggle_slug' => 'design_text',
				'tab_slug'    => 'advanced',
			)
		);

		$text_clip = $this->df_text_clip(
			array(
				'key'         => 'text_clip',
				'toggle_slug' => 'design_text',
				'tab_slug'    => 'advanced',
			)
		);

		$media_bg = $this->df_add_bg_field(
			array(
				'label'       => 'Background',
				'key'         => 'text_media_bg',
				'toggle_slug' => 'design_media',
				'tab_slug'    => 'advanced',
			)
		);

		$text_margin = $this->add_margin_padding(
			array(
				'title'       => 'Text',
				'key'         => 'marquee_text',
				'toggle_slug' => 'design_text',
			)
		);

		$icon_margin = $this->add_margin_padding(
			array(
				'title'       => 'Wrapper',
				'key'         => 'marquee_text_media',
				'toggle_slug' => 'design_media',
			)
		);

		$wrapper_spacing = $this->add_margin_padding(
			array(
				'title'          => '',
				'key'            => 'item_wrapper',
				'toggle_slug'    => 'custom_spacing',
				'default_margin' => '0px|0px|0px|0px',
			)
		);

		return array_merge(
			$admin_label,
			$text,
			$text_bg,
			$text_clip,
			$media_bg,
			$icon,
			$image,
			$wrapper_spacing,
			$text_margin,
			$icon_margin
		);
	}

	/**
	 * Transition set on hover effect

	 * @return array
	 */
	public function get_transition_fields_css_props() {
		$fields        = parent::get_transition_fields_css_props();
		$text          = "div.df_marqueetext_wrapper $this->main_css_element div.df_marquee_text>*:not(div.df_marquee_media)";
		$icon          = "div.df_marqueetext_wrapper $this->main_css_element div.df_marquee_text span.df_marquee_text_icon";
		$media_wrapper = "div.df_marqueetext_wrapper $this->main_css_element div.df_marquee_text div.df_marquee_media";

		$fields['text_icon_color']  = array( 'color' => $icon );
		$fields['text_icon_size']   = array( 'font-size' => $icon );
		$fields['text_image_width'] = array( 'width' => "$media_wrapper img.df_marquee_text_img" );

		$fields['item_wrapper_margin']        = array( 'margin' => "$this->main_css_element.et_pb_module" );
		$fields['item_wrapper_padding']       = array( 'padding' => "$this->main_css_element.et_pb_module" );
		$fields['marquee_text_margin']        = array( 'margin' => $text );
		$fields['marquee_text_padding']       = array( 'padding' => $text );
		$fields['marquee_text_media_margin']  = array( 'margin' => $media_wrapper );
		$fields['marquee_text_media_padding'] = array( 'padding' => $media_wrapper );

		$fields['text_clip_fill_color']   = array( '-webkit-text-fill-color' => $text );
		$fields['text_clip_fill_color']   = array( '-webkit-text-stroke-color' => $text );
		$fields['text_clip_stroke_width'] = array( '-webkit-text-stroke-width' => $text );

		$fields = $this->df_background_transition(
			array(
				'fields'   => $fields,
				'key'      => 'text_background',
				'selector' => "div.df_marqueetext_wrapper $this->main_css_element div.df_marquee_text>*",
			)
		);

		$fields = $this->df_background_transition(
			array(
				'fields'   => $fields,
				'key'      => 'text_media_bg',
				'selector' => $media_wrapper,
			)
		);

		$fields = $this->df_fix_border_transition( $fields, 'text_media_border', $media_wrapper );
		$fields = $this->df_fix_box_shadow_transition( $fields, 'text_media_boxshadow', $media_wrapper );

		return $fields;
	}

	/**
	 * Set style for module
	 *
	 * @param mixed $render_slug  Slug of module that is used for rendering output.
	 * @return void
	 */
	public function additional_css_styles( $render_slug ) {

		$text_wrapper = "div.df_marqueetext_wrapper $this->main_css_element div.df_marquee_text";

		if ( method_exists( 'ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon' ) ) {
			if ( '' !== $this->props['text_icon'] && 'on' === $this->props['enable_text_icon'] ) {
				$this->generate_styles(
					array(
						'utility_arg'    => 'icon_font_family',
						'render_slug'    => $render_slug,
						'base_attr_name' => 'text_icon',
						'important'      => true,
						'selector'       => "$text_wrapper .df_marquee_text_icon",
						'processor'      => array(
							'ET_Builder_Module_Helper_Style_Processor',
							'process_extended_icon',
						),
					)
				);
			}
		}

		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'item_wrapper_margin',
				'type'        => 'margin',
				'selector'    => "$this->main_css_element.et_pb_module",
				'hover'       => "$this->main_css_element.et_pb_module:hover",
				'important'   => true,
			)
		);

		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'item_wrapper_padding',
				'type'        => 'padding',
				'selector'    => "$this->main_css_element.et_pb_module",
				'hover'       => "$this->main_css_element.et_pb_module:hover",
				'important'   => true,
			)
		);

		$this->df_process_bg(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'text_background',
				'selector'    => "$text_wrapper>*:not(div.df_marquee_media)",
				'hover'       => "$text_wrapper:hover>*:not(div.df_marquee_media)",
				'important'   => true,
			)
		);

		$this->df_process_text_clip(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'text_clip',
				'selector'    => "$text_wrapper>*:not(div.df_marquee_media)",
				'hover'       => "$text_wrapper:hover>*:not(div.df_marquee_media)",
			)
		);

		$this->df_process_bg(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'text_media_bg',
				'selector'    => "$text_wrapper div.df_marquee_media",
				'hover'       => "$text_wrapper:hover div.df_marquee_media",
				// 'important'   => true
			)
		);

		$this->df_process_color(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'text_icon_color',
				'type'        => 'color',
				'selector'    => "$text_wrapper span.df_marquee_text_icon",
				'hover'       => "$text_wrapper:hover span.df_marquee_text_icon",
			)
		);

		$this->df_process_range(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'text_icon_size',
				'type'        => 'font-size',
				'selector'    => "$text_wrapper span.df_marquee_text_icon",
				'hover'       => "$text_wrapper:hover span.df_marquee_text_icon",
			)
		);

		$this->df_process_range(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'text_image_width',
				'type'        => 'width',
				'selector'    => "$text_wrapper div.df_marquee_media img.df_marquee_text_img",
				'hover'       => "$text_wrapper:hover div.df_marquee_media img.df_marquee_text_img",
			)
		);

		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'marquee_text_margin',
				'type'        => 'margin',
				'selector'    => "$text_wrapper>*:not(div.df_marquee_media)",
				'hover'       => "$text_wrapper:hover>*:not(div.df_marquee_media)",
				'important'   => true,
			)
		);

		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'marquee_text_padding',
				'type'        => 'padding',
				'selector'    => "$text_wrapper>*:not(div.df_marquee_media)",
				'hover'       => "$text_wrapper:hover>*:not(div.df_marquee_media)",
				'important'   => true,
			)
		);

		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'marquee_text_media_margin',
				'type'        => 'margin',
				'selector'    => "$text_wrapper div.df_marquee_media",
				'hover'       => "$text_wrapper:hover div.df_marquee_media",
				'important'   => true,
			)
		);

		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'marquee_text_media_padding',
				'type'        => 'padding',
				'selector'    => "$text_wrapper div.df_marquee_media",
				'hover'       => "$text_wrapper:hover div.df_marquee_media",
				'important'   => true,
			)
		);
	}

	/**
	 * Module's Output
	 *
	 *  @param array  $attrs — List of unprocessed attributes.
	 *  @param string $content — Content being processed.
	 *  @param string $render_slug — Slug of module that is used for rendering output.
	 *  @return string — The module's HTML output.
	 */
	public function render( $attrs, $content, $render_slug ) {
		$this->handle_fa_icon();
		$this->additional_css_styles( $render_slug );
		$text_tag  = esc_attr( $this->props['text_tag'] ? $this->props['text_tag'] : 'p' );
		$text      = ! empty( $this->props['text'] ) ? $this->props['text'] : '';
		$text_html = '' !== $text ? sprintf( '<%1$s>%2$s</%1$s>', $text_tag, $text ) : '';

		$text_image = ! empty( $this->props['text_img'] ) ? sprintf(
			'<div class="df_marquee_media">
				<img src="%1$s" alt="%2$s" class="df_marquee_text_img"/>
			</div>',
			esc_attr( $this->props['text_img'] ),
			esc_attr( $this->props['text_img_alt_txt'] )
		) : '';

		$text_icon_html = ! empty( $this->props['text_icon'] ) ?
			sprintf(
				'<div class="df_marquee_media">
					<span class="et-pb-icon df_marquee_text_icon">%1$s</span>
				</div>',
				esc_attr( et_pb_process_font_icon( $this->props['text_icon'] ) )
			) : '';

		$icon_image = 'on' === $this->props['enable_text_icon'] ? $text_icon_html : $text_image;

		return ! empty( $text ) ?
			sprintf(
				'<div class="df_marquee_text">%2$s%1$s%3$s</div>',
				$text_html,
				'on' !== $this->props['set_media_after_text'] ? $icon_image : '',
				'on' === $this->props['set_media_after_text'] ? $icon_image : ''
			) : '';
	}
}
new DIFL_MarqueeTextItem();
