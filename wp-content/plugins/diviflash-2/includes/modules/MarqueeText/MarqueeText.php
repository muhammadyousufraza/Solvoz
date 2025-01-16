<?php
/**
 * Marquee Text Module Class
 *
 * This class provide animated text element functionalities in frontend.
 *
 * @since 1.3.9
 * @category Text
 * @link     http://#
 */
class DIFL_MarqueeText extends ET_Builder_Module {
	public $icon_path;

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
		$this->name             = esc_html__( 'Marquee Text', 'divi_flash' );
		$this->plural           = esc_html__( 'Marquee Texts', 'divi_flash' );
		$this->main_css_element = '%%order_class%%';
		$this->icon_path        = DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/marquee-text.svg';
		$this->slug             = 'difl_marqueetext';
		$this->child_slug       = 'difl_marqueetextitem';
		$this->vb_support       = 'on';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'settings' => esc_html__( 'Settings', 'divi_flash' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'design_text'  => esc_html__( 'Content', 'divi_flash' ),
					'design_media' => esc_html__( 'Image & Icon', 'divi_flash' ),
				),
			),
		);

		$text_wrapper = "$this->main_css_element .df_marqueetext_wrapper .df_marquee_text";

		$this->advanced_fields = array(
			'text'           => false,
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
						'main'  => "$text_wrapper>*:not(.df_marquee_media)",
						'hover' => "$text_wrapper:hover>*:not(.df_marquee_media)",
					),
				),
			),
			'borders'        => array(
				'default'           => array(),
				'text_media_border' => array(
					'css'         => array(
						'main' => array(
							'border_radii'        => "$text_wrapper .df_marquee_media",
							'border_radii_hover'  => "$text_wrapper:hover .df_marquee_media",
							'border_styles'       => "$text_wrapper .df_marquee_media",
							'border_styles_hover' => "$text_wrapper:hover .df_marquee_media",
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
						'main'  => "$text_wrapper .df_marquee_media",
						'hover' => "$text_wrapper:hover .df_marquee_media",
					),
				),
			),
			'margin_padding' => array(
				'css' => array(
					'main'      => "$this->main_css_element.et_pb_module",
					'important' => 'all',
				),
			),
		);

		$advanced_fields['margin_padding'] = array(
			'css' => array(
				'main'      => "{$this->main_css_element}.et_pb_module",
				'important' => 'all',
			),
		);

		$this->custom_css_fields = array(
			'marquee_text_css'       => array(
				'label'    => esc_html__( 'Marquee Text', 'divi_flash' ),
				'selector' => "$text_wrapper>*:not(.df_marquee_media)",
			),
			'marquee_text_icon_css'  => array(
				'label'    => esc_html__( 'Marquee Text Icon', 'divi_flash' ),
				'selector' => "$text_wrapper .df_marquee_text_icon",
			),
			'marquee_text_image_css' => array(
				'label'    => esc_html__( 'Marquee Text Image', 'divi_flash' ),
				'selector' => "$text_wrapper .df_marquee_text_img",
			),
		);
	}

	/**
	 * All fields settings

	 * @return array
	 */
	public function get_fields() {
		$settings = array(
			'ticker_hover'     => array(
				'label'       => esc_html__( 'Pause On Hover', 'divi_flash' ),
				'description' => esc_html__( 'Animation will pause on mouse hover.', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				),
				'default'     => 'off',
				'toggle_slug' => 'settings',
			),
			'ticker_loop'      => array(
				'label'       => esc_html__( 'Loop', 'divi_flash' ),
				'description' => esc_html__( 'The marquee will be duplicated to show the effect of continuous flow.', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				),
				'default'     => 'off',
				'toggle_slug' => 'settings',
			),
			'ticker_gap'       => array(
				'label'          => esc_html__( 'Gap', 'divi_flash' ),
				'description'    => esc_html__( 'Here, you can control the space in pixels between the items.', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'settings',
				'default'        => '10px',
				'default_unit'   => 'px',
				'allowed_units'  => array( 'px' ),
				'range_settings' => array(
					'min'       => '0',
					'min_limit' => 0,
					'max'       => '1000',
					'step'      => '1',
				),
				'responsive'     => true,
				'mobile_options' => true,
			),
			'ticker_speed'     => array(
				'label'          => esc_html__( 'Speed (ms)', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can control the speed of animation.', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'settings',
				'default'        => '10000',
				'default_unit'   => '',
				'allowed_units'  => array( '' ),
				'range_settings' => array(
					'min'       => 1,
					'min_limit' => 1,
					'max'       => 50000,
					'step'      => 1,
				),
				'validate_unit'  => false,
			),
			'ticker_direction' => array(
				'label'       => esc_html__( 'Animation Direction Reverse ', 'divi_flash' ),
				'description' => esc_html__( 'Here you can set animation direction.', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				),
				'default'     => 'off',
				'toggle_slug' => 'settings',
			),
		);

		$icon = array(
			'text_icon_color'  => array(
				'label'       => esc_html__( 'Icon Color', 'divi_flash' ),
				'description' => esc_html__( 'Here you can define a color for text icon.', 'divi_flash' ),
				'type'        => 'color-alpha',
				'toggle_slug' => 'design_media',
				'tab_slug'    => 'advanced',
				'hover'       => 'tabs',
			),
			'text_icon_size'   => array(
				'label'          => esc_html__( 'Icon Size', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can control icon size of text.', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'design_media',
				'tab_slug'       => 'advanced',
				'default'        => '14px',
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
			),
			'text_image_width' => array(
				'label'          => esc_html__( 'Image Width', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can control image size of text.', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'design_media',
				'tab_slug'       => 'advanced',
				'default'        => '20px',
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
		);

		$text_bg = $this->df_add_bg_field(
			array(
				'label'       => 'Background',
				'key'         => 'text_background',
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
				'title'          => 'Text',
				'key'            => 'marquee_text',
				'toggle_slug'    => 'design_text',
				'default_margin' => '0px|10px|0px|10px',
			)
		);

		$icon_margin = $this->add_margin_padding(
			array(
				'title'          => 'Wrapper',
				'key'            => 'marquee_text_media',
				'toggle_slug'    => 'design_media',
				'default_margin' => '0px|5px|0px|5px',
			)
		);

		return array_merge(
			$settings,
			$text_bg,
			$media_bg,
			$icon,
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
		$text          = "$this->main_css_element .df_marqueetext_wrapper .df_marquee_text>*:not(.df_marquee_media)";
		$icon          = "$this->main_css_element .df_marqueetext_wrapper .df_marquee_text .df_marquee_text_icon";
		$media_wrapper = "$this->main_css_element .df_marqueetext_wrapper .df_marquee_text .df_marquee_media";

		$fields['text_icon_color']            = array( 'color' => $icon );
		$fields['text_icon_size']             = array( 'font-size' => $icon );
		$fields['text_image_width']           = array( 'width' => "$media_wrapper .df_marquee_text_img" );
		$fields['marquee_text_margin']        = array( 'margin' => $text );
		$fields['marquee_text_padding']       = array( 'padding' => $text );
		$fields['marquee_text_media_margin']  = array( 'margin' => $media_wrapper );
		$fields['marquee_text_media_padding'] = array( 'padding' => $media_wrapper );

		$fields = $this->df_background_transition(
			array(
				'fields'   => $fields,
				'key'      => 'text_background',
				'selector' => $text,
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
	 * @param mixed  $render_slug  Slug of module that is used for rendering output.
	 * @param string $content — Content being processed.
	 * @return void
	 */
	public function additional_css_styles( $render_slug, $content ) {

		$text_wrapper = "$this->main_css_element .df_marqueetext_wrapper .df_marquee_text";

		$this->df_process_bg(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'text_background',
				'selector'    => "$text_wrapper>*:not(.df_marquee_media)",
				'hover'       => "$text_wrapper:hover>*:not(.df_marquee_media)",
				'important'   => true,
			)
		);

		$this->df_process_bg(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'text_media_bg',
				'selector'    => "$text_wrapper .df_marquee_media",
				'hover'       => "$text_wrapper .df_marquee_media",
			)
		);

		$this->df_process_color(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'text_icon_color',
				'type'        => 'color',
				'selector'    => "$text_wrapper .df_marquee_text_icon",
				'hover'       => "$text_wrapper:hover .df_marquee_text_icon",
				'important'   => false,
			)
		);

		$this->df_process_range(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'text_icon_size',
				'type'        => 'font-size',
				'selector'    => "$text_wrapper .df_marquee_text_icon",
				'hover'       => "$text_wrapper:hover .df_marquee_text_icon",
				'default'     => '14px',
				'important'   => false,
			)
		);

		$this->df_process_range(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'text_image_width',
				'type'        => 'width',
				'selector'    => "$text_wrapper .df_marquee_media .df_marquee_text_img",
				'hover'       => "$text_wrapper:hover .df_marquee_media .df_marquee_text_img",
			)
		);

		$this->df_process_range(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'ticker_gap',
				'type'        => 'gap',
				'selector'    => "$this->main_css_element .df_marquee_list",
			)
		);

		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'marquee_text_margin',
				'type'        => 'margin',
				'selector'    => "$text_wrapper>*:not(.df_marquee_media)",
				'hover'       => "$text_wrapper:hover>*:not(.df_marquee_media)",
				'important'   => true,
			)
		);

		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'marquee_text_padding',
				'type'        => 'padding',
				'selector'    => "$text_wrapper>*:not(.df_marquee_media)",
				'hover'       => "$text_wrapper:hover>*:not(.df_marquee_media)",
				'important'   => true,
			)
		);

		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'marquee_text_media_margin',
				'type'        => 'margin',
				'selector'    => "$text_wrapper .df_marquee_media",
				'hover'       => "$text_wrapper:hover .df_marquee_media",
				'important'   => true,
			)
		);

		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'marquee_text_media_padding',
				'type'        => 'padding',
				'selector'    => "$text_wrapper .df_marquee_media",
				'hover'       => "$text_wrapper:hover .df_marquee_media",
				'important'   => true,
			)
		);

		if ( empty( $this->content ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .et_pb_module_inner',
					'declaration' => 'text-align: center;',
				)
			);
		}

		if ( 'on' === $this->props['ticker_loop'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$this->main_css_element .df_marqueetext_wrapper .df_marquee_animation",
					'declaration' => 'display: flex;',
				)
			);
		}

	}

	/**
	 * Module's Output
	 *
	 *  @param array  $attrs — List of unprocessed attributes.
	 *  @param string $content — Content being processed.
	 *  @param string $render_slug — Slug of module that is used for rendering output.
	 *  @return string The module's HTML output.
	 */
	public function render( $attrs, $content, $render_slug ) {
		wp_enqueue_script( 'df-marquee-script' );
		wp_enqueue_script( 'df_marquee_text' );
		$this->additional_css_styles( $render_slug, $content );

		$data = array(
			'ticker_hover'     => 'on' === $this->props['ticker_hover'],
			'ticker_speed'     => $this->props['ticker_speed'],
			'ticker_direction' => $this->props['ticker_direction'],
			'ticker_loop'      => 'on' === $this->props['ticker_loop'],
			'ticker_gap'       => $this->props['ticker_gap'],
		);

		return ! empty( $this->content ) ? sprintf(
			'<div class="df_marqueetext_wrapper" data-settings=\'%2$s\'>
            <div class="df_marquee_animation">
            	<div class="df_marquee_list">
                  %1$s
               </div>
            </div>
         </div>',
			et_core_sanitized_previously( $this->content ),
			wp_json_encode( $data )
		) : "<h2 class='df_marquee_notice'>Please <strong>Add New Item.</strong></h2>";
	}
}
new DIFL_MarqueeText();
