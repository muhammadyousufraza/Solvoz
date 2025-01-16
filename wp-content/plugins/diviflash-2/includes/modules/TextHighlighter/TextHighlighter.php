<?php
class DIFL_TextHighlighter extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;

	public $slug       = 'difl_text_highlighter';
	public $vb_support = 'on';
	use DF_UTLS;

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
	);

	public function init() {
		$this->name             = esc_html__( 'Text Highlighter', 'divi_flash' );
		$this->main_css_element = '%%order_class%%';
		$this->icon_path        = DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/text-highlighter.svg';
	}

	public function get_settings_modal_toggles() {
		return array(
			'general'  => array(
				'toggles' => array(
					'content'              => esc_html__( 'Content', 'divi_flash' ),
					'highlighter_settings' => esc_html__( 'Highlighter Settings', 'divi_flash' ),
					'divider'              => esc_html__( 'Divider', 'divi_flash' ),
					'divider_background'   => esc_html__( 'Divider Line Background', 'divi_flash' ),
					'prefix_background'    => esc_html__( 'Prefix Background', 'divi_flash' ),
					'infix_background'     => esc_html__( 'Infix Background', 'divi_flash' ),
					'suffix_background'    => esc_html__( 'Suffix Background', 'divi_flash' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'title'          => esc_html__( 'Title', 'divi_flash' ),
					'dual_text'      => esc_html__( 'Dual Text', 'divi_flash' ),
					'prefix'         => esc_html__( 'Prefix Text', 'divi_flash' ),
					'infix'          => esc_html__( 'Infix Text', 'divi_flash' ),
					'suffix'         => esc_html__( 'Suffix Text', 'divi_flash' ),
					'highlighter'    => esc_html__( 'Highlighter', 'divi_flash' ),
					'border'         => esc_html__( 'Border', 'divi_flash' ),
					'custom_borders' => esc_html__( 'Custom border', 'divi_flash' ),
					'custom_spacing' => esc_html__( 'Custom Spacing', 'divi_flash' ),
				),
			),
		);
	}

	public function get_advanced_fields_config() {
		$advanced_fields          = array();
		$advanced_fields['fonts'] = array(
			'title'    => array(
				'label'       => esc_html__( 'Title', 'divi_flash' ),
				'toggle_slug' => 'title',
				'tab_slug'    => 'advanced',
				'line_height' => array(
					'default' => '1em',
				),
				'font_size'   => array(
					'default' => '24',
				),
				'css'         => array(
					'main'      => "{$this->main_css_element} h1,
                                {$this->main_css_element} h2,
                                {$this->main_css_element} h3,
                                {$this->main_css_element} h4,
                                {$this->main_css_element} h5,
                                {$this->main_css_element} h6,
                                {$this->main_css_element} p,
                                {$this->main_css_element} span,
                                {$this->main_css_element} div,
                                {$this->main_css_element} h1 span,
                                {$this->main_css_element} h2 span,
                                {$this->main_css_element} h3 span,
                                {$this->main_css_element} h4 span,
                                {$this->main_css_element} h5 span,
                                {$this->main_css_element} h6 span,
                                {$this->main_css_element} p span,
                                {$this->main_css_element} span span,
                                {$this->main_css_element} div span",
					'hover'     => "{$this->main_css_element}:hover h1,
                                {$this->main_css_element}:hover h2,
                                {$this->main_css_element}:hover h3,
                                {$this->main_css_element}:hover h4,
                                {$this->main_css_element}:hover h5,
                                {$this->main_css_element}:hover h6,
                                {$this->main_css_element}:hover p,
                                {$this->main_css_element}:hover span,
                                {$this->main_css_element}:hover div,
                                {$this->main_css_element}:hover h1 span,
                                {$this->main_css_element}:hover h2 span,
                                {$this->main_css_element}:hover h3 span,
                                {$this->main_css_element}:hover h4 span,
                                {$this->main_css_element}:hover h5 span,
                                {$this->main_css_element}:hover h6 span,
                                {$this->main_css_element}:hover p span,
                                {$this->main_css_element}:hover span span,
                                {$this->main_css_element}:hover div span",
					'important' => 'all',
				),
			),
			't_dual'   => array(
				'label'       => esc_html__( 'Dual Text', 'divi_flash' ),
				'toggle_slug' => 'dual_text',
				'tab_slug'    => 'advanced',
				'text_color'  => array(
					'default' => '#e0e0e0',
				),
				'line_height' => array(
					'default' => '1em',
				),
				'font_size'   => array(
					'default' => '30px',
				),
				'css'         => array(
					'main'      => "{$this->main_css_element} .df-heading-dual_text",
					'hover'     => "{$this->main_css_element}:hover .df-heading-dual_text",
					'important' => 'all',
				),
			),
			't_prefix' => array(
				'label'       => esc_html__( 'Prefix', 'divi_flash' ),
				'toggle_slug' => 'prefix',
				'tab_slug'    => 'advanced',
				'line_height' => array(
					'default' => '1em',
				),
				'font_size'   => array(
					'default' => '24px',
				),
				'css'         => array(
					'main'      => "{$this->main_css_element} span.prefix",
					'hover'     => "{$this->main_css_element}:hover span.prefix",
					'important' => 'all',
				),
			),
			't_infix'  => array(
				'label'       => esc_html__( 'Infix', 'divi_flash' ),
				'toggle_slug' => 'infix',
				'tab_slug'    => 'advanced',
				'line_height' => array(
					'default' => '1em',
				),
				'font_size'   => array(
					'default' => '24px',
				),
				'css'         => array(
					'main'      => "{$this->main_css_element} span.infix",
					'hover'     => "{$this->main_css_element}:hover span.infix",
					'important' => 'all',
				),
			),
			't_suffix' => array(
				'label'       => esc_html__( 'Suffix', 'divi_flash' ),
				'toggle_slug' => 'suffix',
				'tab_slug'    => 'advanced',
				'line_height' => array(
					'default' => '1em',
				),
				'font_size'   => array(
					'default' => '24px',
				),
				'css'         => array(
					'main'      => "{$this->main_css_element} span.suffix",
					'hover'     => "{$this->main_css_element}:hover span.suffix",
					'important' => 'all',
				),
			),
		);
		$advanced_fields['borders'] = array(
			'default'       => array(),
			'prefix_border' => array(
				'css'          => array(
					'main' => array(
						'border_radii'        => "{$this->main_css_element} span.prefix",
						'border_styles'       => "{$this->main_css_element} span.prefix",
						'border_styles_hover' => "{$this->main_css_element}:hover span.prefix",
					),
				),
				'label_prefix' => esc_html__( 'Prefix', 'divi_flash' ),
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'custom_borders',
			),
			'infix_border'  => array(
				'css'          => array(
					'main' => array(
						'border_radii'        => "{$this->main_css_element} span.infix",
						'border_styles'       => "{$this->main_css_element} span.infix",
						'border_styles_hover' => "{$this->main_css_element}:hover span.infix",
					),
				),
				'label_prefix' => esc_html__( 'Infix', 'divi_flash' ),
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'custom_borders',
			),
			'suffix_border' => array(
				'css'          => array(
					'main' => array(
						'border_radii'        => "{$this->main_css_element} span.suffix",
						'border_styles'       => "{$this->main_css_element} span.suffix",
						'border_styles_hover' => "{$this->main_css_element}:hover span.suffix",
					),
				),
				'label_prefix' => esc_html__( 'Suffix', 'divi_flash' ),
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'custom_borders',
			),

		);
		$advanced_fields['box_shadow']     = array(
			'default' => true,
			'prefix'  => array(
				'css'         => array(
					'main'  => '%%order_class%% span.prefix',
					'hover' => '%%order_class%%:hover span.prefix',
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'prefix',
			),
			'infix'   => array(
				'css'         => array(
					'main'  => '%%order_class%% span.infix',
					'hover' => '%%order_class%%:hover span.infix',
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'infix',
			),
			'suffix'  => array(
				'css'         => array(
					'main'  => '%%order_class%% span.suffix',
					'hover' => '%%order_class%%:hover span.suffix',
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'suffix',
			),
		);
		$advanced_fields['margin_padding'] = array(
			'css' => array(
				'important' => 'all',
			),
		);
		$advanced_fields['text']           = false;
		$advanced_fields['filters']        = false;

		return $advanced_fields;
	}

	public function get_fields() {
		$heading = array(
			'title_tag'            => array(
				'label'       => esc_html__( 'Title Tag', 'divi_flash' ),
				'description' => esc_html__( 'Choose a tag to display title.', 'divi_flash' ),
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
				'toggle_slug' => 'title',
				'tab_slug'    => 'advanced',
				'default'     => 'h3',
			),
			'title_prefix'         => array(
				'label'           => esc_html__( 'Title Prefix', 'divi_flash' ),
				'type'            => 'text',
				'toggle_slug'     => 'content',
				'dynamic_content' => 'text',
			),
			'title_prefix_block'   => array(
				'label'            => esc_html__( 'Display Element', 'divi_flash' ),
				'type'             => 'select',
				'options'          => array(
					'inline-block' => esc_html__( 'Default', 'divi_flash' ),
					'block'        => esc_html__( 'Block', 'divi_flash' ),
					'inline'       => esc_html__( 'Inline', 'divi_flash' ),
				),
				'default'          => 'inline-block',
				'default_on_front' => 'inline-block',
				'toggle_slug'      => 'prefix',
				'tab_slug'         => 'advanced',
				'responsive'       => true,
				'mobile_options'   => true,
				'dynamic_content'  => 'text',
			),
			'title_infix'          => array(
				'label'           => esc_html__( 'Title Infix (Highlight)', 'divi_flash' ),
				'type'            => 'text',
				'toggle_slug'     => 'content',
				'dynamic_content' => 'text',
			),
			'title_infix_block'    => array(
				'label'            => esc_html__( 'Display Block', 'divi_flash' ),
				'type'             => 'select',
				'options'          => array(
					'inline-block' => esc_html__( 'Default', 'divi_flash' ),
					'block'        => esc_html__( 'Block', 'divi_flash' ),
					'inline'       => esc_html__( 'Inline', 'divi_flash' ),
				),
				'default'          => 'inline-block',
				'default_on_front' => 'inline-block',
				'toggle_slug'      => 'infix',
				'tab_slug'         => 'advanced',
				'responsive'       => true,
				'mobile_options'   => true,
			),
			'title_suffix'         => array(
				'label'           => esc_html__( 'Title Suffix', 'divi_flash' ),
				'type'            => 'text',
				'toggle_slug'     => 'content',
				'dynamic_content' => 'text',
			),
			'title_suffix_block'   => array(
				'label'            => esc_html__( 'Display Block', 'divi_flash' ),
				'type'             => 'select',
				'options'          => array(
					'inline-block' => esc_html__( 'Default', 'divi_flash' ),
					'block'        => esc_html__( 'Block', 'divi_flash' ),
					'inline'       => esc_html__( 'Inline', 'divi_flash' ),
				),
				'default'          => 'inline-block',
				'default_on_front' => 'inline-block',
				'toggle_slug'      => 'suffix',
				'tab_slug'         => 'advanced',
				'responsive'       => true,
				'mobile_options'   => true,
			),
			'use_dual_text'        => array(
				'label'       => esc_html__( 'Use Dual Text', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'default'     => 'off',
				'toggle_slug' => 'dual_text',
				'tab_slug'    => 'advanced',
			),
			'use_dual_text_custom' => array(
				'label'       => esc_html__( 'Custom Text', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'default'     => 'off',
				'toggle_slug' => 'dual_text',
				'tab_slug'    => 'advanced',
				'show_if'     => array(
					'use_dual_text' => 'on',
				),
			),
			'custom_text_input'    => array(
				'label'       => esc_html__( 'Custom Text Input', 'divi_flash' ),
				'type'        => 'text',
				'toggle_slug' => 'dual_text',
				'tab_slug'    => 'advanced',
				'show_if'     => array(
					'use_dual_text_custom' => 'on',
				),
			),
		);

		$highlighter_settings = array(
			'highlighter_type'                => array(
				'label'       => esc_html__( 'Type', 'divi_flash' ),
				'description' => esc_html__( 'Here you can chose highlighter element type.', 'divi_flash' ),
				'type'        => 'df_text_highlighter_select',
				'default'     => 'underline',
				'toggle_slug' => 'highlighter_settings',
			),
			'highlighter_color'               => array(
				'label'       => esc_html__( 'Color', 'divi_flash' ),
				'description' => esc_html__( 'Here you can define a custom color for highlighter stroke.', 'divi_flash' ),
				'type'        => 'color-alpha',
				'default'     => '#6A33D7',
				'toggle_slug' => 'highlighter',
				'tab_slug'    => 'advanced',
				'hover'       => 'tabs',
				'show_if_not' => array(
					'enable_gradient_color' => 'on',
				),
			),
			'enable_gradient_color'           => array(
				'label'       => esc_html__( 'Use Gradient Color', 'divi_flash' ),
				'description' => esc_html__( 'Here you can set gradient color for highlighter stroke.', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'default'     => 'off',
				'options'     => array(
					'on'  => esc_html__( 'On', 'divi_flash' ),
					'off' => esc_html__( 'Off', 'divi_flash' ),
				),
				'toggle_slug' => 'highlighter',
				'tab_slug'    => 'advanced',
			),
			'gradient_color_start'            => array(
				'label'       => esc_html__( 'Start Color', 'divi_flash' ),
				'description' => esc_html__( 'Here you can define start gradient color for highlighter stroke.', 'divi_flash' ),
				'type'        => 'color-alpha',
				'default'     => '#2b87da',
				'toggle_slug' => 'highlighter',
				'tab_slug'    => 'advanced',
				'show_if'     => array(
					'enable_gradient_color' => 'on',
				),
			),
			'gradient_color_end'              => array(
				'label'       => esc_html__( 'End Color', 'divi_flash' ),
				'description' => esc_html__( 'Here you can define end gradient color for highlighter stroke.', 'divi_flash' ),
				'type'        => 'color-alpha',
				'default'     => '#29c4a9',
				'toggle_slug' => 'highlighter',
				'tab_slug'    => 'advanced',
				'show_if'     => array(
					'enable_gradient_color' => 'on',
				),
			),
			'gradient_type'                   => array(
				'label'       => esc_html__( 'Gradient Type', 'divi_flash' ),
				'description' => esc_html__( 'Here you can set gradient type.', 'divi_flash' ),
				'type'        => 'select',
				'default'     => 'linearGradient',
				'options'     => array(
					'linearGradient' => esc_html__( 'Linear', 'divi_flash' ),
					'radialGradient' => esc_html__( 'Radial', 'divi_flash' ),
				),
				'toggle_slug' => 'highlighter',
				'tab_slug'    => 'advanced',
				'show_if'     => array(
					'enable_gradient_color' => 'on',
				),
			),
			'gradient_direction'              => array(
				'label'          => esc_html__( 'Gradient Direction', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can specify both color angle value.', 'divi_flash' ),
				'type'           => 'range',
				'range_settings' => array(
					'min'       => '0',
					'min_limit' => '0',
					'max'       => '360',
					'step'      => '1',
				),
				'default_unit'   => 'deg',
				'default'        => '180deg',
				'toggle_slug'    => 'highlighter',
				'tab_slug'       => 'advanced',
				'show_if'        => array(
					'enable_gradient_color' => 'on',
					'gradient_type'         => 'linearGradient',
				),
			),
			'gradient_direction_radial'       => array(
				'label'       => esc_html__( 'Radial Direction', 'divi_flash' ),
				'description' => esc_html__( 'Here you can specify both color radial position value..', 'divi_flash' ),
				'type'        => 'select',
				'default'     => 'top',
				'options'     => array(
					'top'    => esc_html__( 'Top', 'divi_flash' ),
					'bottom' => esc_html__( 'Bottom', 'divi_flash' ),
					'left'   => esc_html__( 'Left', 'divi_flash' ),
					'right'  => esc_html__( 'Right', 'divi_flash' ),
					'center' => esc_html__( 'Center', 'divi_flash' ),
				),
				'toggle_slug' => 'highlighter',
				'tab_slug'    => 'advanced',
				'show_if'     => array(
					'enable_gradient_color' => 'on',
					'gradient_type'         => 'radialGradient',
				),
			),
			'gradient_start_position'         => array(
				'label'          => esc_html__( 'Start position', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can specify the start position of the first gradient color.', 'divi_flash' ),
				'type'           => 'range',
				'range_settings' => array(
					'min'       => '0',
					'min_limit' => '0',
					'max'       => '100',
					'max_limit' => '100',
					'step'      => '1',
				),
				'default'        => '0%',
				'default_unit'   => '%',
				'toggle_slug'    => 'highlighter',
				'tab_slug'       => 'advanced',
				'show_if'        => array(
					'enable_gradient_color' => 'on',
				),
			),
			'gradient_end_position'           => array(
				'label'          => esc_html__( 'End position', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can specify the end position of the first gradient color.', 'divi_flash' ),
				'type'           => 'range',
				'range_settings' => array(
					'min'       => '0',
					'min_limit' => '0',
					'max'       => '100',
					'max_limit' => '100',
					'step'      => '1',
				),
				'default'        => '100%',
				'default_unit'   => '%',
				'toggle_slug'    => 'highlighter',
				'tab_slug'       => 'advanced',
				'show_if'        => array(
					'enable_gradient_color' => 'on',
				),
			),
			'highlighter_stroke_width'        => array(
				'label'          => esc_html__( 'Stroke Width', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can define stroke width for highlighter element.', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'highlighter',
				'tab_slug'       => 'advanced',
				'default'        => '8px',
				'default_unit'   => 'px',
				'hover'          => 'tabs',
				'mobile_options' => true,
				'range_settings' => array(
					'min'       => '0',
					'min_limit' => '0',
					'max'       => '100',
					'step'      => '1',
				),
			),
			'highlighter_size'                => array(
				'label'          => esc_html__( 'Size (by scale)', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can define a custom size for highlighter element by scale. The amount of scaling is defined by a vector [sx, sy], it can resize the horizontal and vertical dimensions at different scales.', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'highlighter',
				'tab_slug'       => 'advanced',
				'default'        => '1',
				'default_unit'   => '',
				'hover'          => 'tabs',
				'mobile_options' => true,
				'range_settings' => array(
					'min'       => '0',
					'min_limit' => '0',
					'max'       => '10',
					'step'      => '.01',
				),
			),
			'highlighter_opacity'             => array(
				'label'          => esc_html__( 'Opacity', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can set the opacity level for highlighter element.', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'highlighter',
				'tab_slug'       => 'advanced',
				'range_settings' => array(
					'min'       => '0',
					'min_limit' => '0',
					'max'       => '1',
					'step'      => '.01',
				),
				'hover'          => 'tabs',
				'mobile_options' => true,
				'default'        => '1',
			),
			'highlighter_position'            => array(
				'label'       => esc_html__( 'Position', 'divi_flash' ),
				'description' => esc_html__( 'Select whether the highlighter element is above or below the text.', 'divi_flash' ),
				'type'        => 'select',
				'default'     => 'below',
				'options'     => array(
					'below' => esc_html__( 'Below Text', 'divi_flash' ),
					'above' => esc_html__( 'Above Text', 'divi_flash' ),
				),
				'toggle_slug' => 'highlighter',
				'tab_slug'    => 'advanced',
			),
			'highlighter_vertical_position'   => array(
				'label'          => esc_html__( 'Vertical Offset', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can define vertical offset of highlighter element.', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'highlighter',
				'tab_slug'       => 'advanced',
				'default'        => '0px',
				'default_unit'   => 'px',
				'hover'          => 'tabs',
				'mobile_options' => true,
				'range_settings' => array(
					'min'  => '-100',
					'max'  => '100',
					'step' => '1',
				),
			),
			'highlighter_horizontal_position' => array(
				'label'          => esc_html__( 'Horizontal Offset', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can define horizontal offset of highlighter element.', 'divi_flash' ),
				'type'           => 'range',
				'toggle_slug'    => 'highlighter',
				'tab_slug'       => 'advanced',
				'default'        => '0px',
				'default_unit'   => 'px',
				'hover'          => 'tabs',
				'mobile_options' => true,
				'range_settings' => array(
					'min'  => '-100',
					'max'  => '100',
					'step' => '1',
				),
			),
			'enable_animation'                => array(
				'label'       => esc_html__( 'Enable Animation', 'divi_flash' ),
				'description' => esc_html__( 'Here you can enable animation for highlighter.', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'default'     => 'on',
				'options'     => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				),
				'toggle_slug' => 'highlighter_settings',
			),
			'anim_start'                      => array(
				'label'       => esc_html__( 'Animation Start', 'divi_flash' ),
				'description' => esc_html__( 'Define when the animation will start.', 'divi_flash' ),
				'type'        => 'select',
				'default'     => 'page_load',
				'options'     => array(
					'page_load' => esc_html__( 'On Page Load', 'divi_flash' ),
					'viewport'  => esc_html__( 'In Viewport', 'divi_flash' ),
				),
				'toggle_slug' => 'highlighter_settings',
				'show_if'     => array(
					'enable_animation' => 'on',
				),
			),
			'anim_start_viewport'             => array(
				'label'          => esc_html__( 'Viewport Bottom Offset', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can specifies the animation start position on viewport from bottom.', 'divi_flash' ),
				'type'           => 'range',
				'range_settings' => array(
					'min'       => '1',
					'min_limit' => '1',
					'max'       => '100',
					'max_limit' => '100',
					'step'      => '1',
				),
				'default'        => '50%',
				'default_unit'   => '%',
				'toggle_slug'    => 'highlighter_settings',
				'show_if'        => array(
					'anim_start'       => 'viewport',
					'enable_animation' => 'on',
				),
			),
			'anim_easing'                     => array(
				'label'       => esc_html__( 'Easing', 'divi_flash' ),
				'description' => esc_html__( 'The easing option specifies the speed curve of an animation.', 'divi_flash' ),
				'type'        => 'select',
				'default'     => 'linear',
				'options'     => array(
					'LINEAR'          => esc_html__( 'linear', 'divi_flash' ),
					'EASE'            => esc_html__( 'ease', 'divi_flash' ),
					'EASE_IN'         => esc_html__( 'ease-in', 'divi_flash' ),
					'EASE_OUT'        => esc_html__( 'ease-out', 'divi_flash' ),
					'EASE_OUT_BOUNCE' => esc_html__( 'ease-out-bounce', 'divi_flash' ),
				),
				'toggle_slug' => 'highlighter_settings',
				'show_if'     => array(
					'enable_animation' => 'on',
				),
			),
			'anim_duration'                   => array(
				'label'          => esc_html__( 'Duration', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can define duration for animation by ms.', 'divi_flash' ),
				'type'           => 'range',
				'range_settings' => array(
					'min'       => '100',
					'min_limit' => '100',
					'max'       => '10000',
					'step'      => '1',
				),
				'default_unit'   => 'ms',
				'default'        => '1000ms',
				'toggle_slug'    => 'highlighter_settings',
				'show_if'        => array(
					'enable_animation' => 'on',
				),
			),
			'anim_delay'                      => array(
				'label'          => esc_html__( 'Delay', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can define a delay for the start of an animation ms.', 'divi_flash' ),
				'type'           => 'range',
				'range_settings' => array(
					'min'       => '0',
					'min_limit' => '0',
					'max'       => '10000',
					'step'      => '1',
				),
				'default_unit'   => 'ms',
				'default'        => '0ms',
				'toggle_slug'    => 'highlighter_settings',
				'show_if'        => array(
					'enable_animation' => 'on',
				),
			),
			'enable_loop'                     => array(
				'label'       => esc_html__( 'Loop', 'divi_flash' ),
				'description' => esc_html__( 'Here you can enable animation for infinite times.', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'default'     => 'off',
				'options'     => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				),
				'toggle_slug' => 'highlighter_settings',
				'show_if'     => array(
					'enable_animation' => 'on',
				),
			),
			'anim_iteration'                  => array(
				'label'          => esc_html__( 'Iteration', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can specifies the number of times an animation should be played.', 'divi_flash' ),
				'type'           => 'range',
				'range_settings' => array(
					'min'       => '1',
					'min_limit' => '1',
					'max'       => '1000',
					'step'      => '1',
				),
				'default'        => '1',
				'toggle_slug'    => 'highlighter_settings',
				'show_if'        => array(
					'enable_loop'      => 'off',
					'enable_animation' => 'on',
				),
			),
			'anim_iteration_gap'              => array(
				'label'          => esc_html__( 'Iteration Gap', 'divi_flash' ),
				'description'    => esc_html__( 'Here you can define a delay between each iteration by ms. This options will work if iteration more than one.', 'divi_flash' ),
				'type'           => 'range',
				'range_settings' => array(
					'min'       => '1',
					'min_limit' => '1',
					'max'       => '10000',
					'step'      => '1',
				),
				'default_unit'   => 'ms',
				'default'        => '1000ms',
				'toggle_slug'    => 'highlighter_settings',
				'show_if'        => array(
					'enable_animation' => 'on',
				),
			),
		);
		$divider              = array(
			'use_divider'              => array(
				'label'       => esc_html__( 'Use Divider', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'default'     => 'off',
				'toggle_slug' => 'divider',
			),
			'divider_position'         => array(
				'label'       => esc_html__( 'Divider Position', 'divi_flash' ),
				'type'        => 'select',
				'options'     => array(
					'bottom' => esc_html__( 'Bottom', 'divi_flash' ),
					'top'    => esc_html__( 'Top', 'divi_flash' ),
				),
				'toggle_slug' => 'divider',
				'default'     => 'bottom',
				'show_if'     => array(
					'use_divider' => 'on',
				),
			),
			'divider_style'            => array(
				'label'       => esc_html__( 'Divider Line Style', 'divi_flash' ),
				'type'        => 'select',
				'options'     => array(
					'solid'  => esc_html__( 'Default', 'divi_flash' ),
					'dotted' => esc_html__( 'Dotted', 'divi_flash' ),
					'dashed' => esc_html__( 'Dashed', 'divi_flash' ),
					'double' => esc_html__( 'Double', 'divi_flash' ),
					'groove' => esc_html__( 'Groove', 'divi_flash' ),
					'ridge'  => esc_html__( 'Ridge', 'divi_flash' ),
				),
				'toggle_slug' => 'divider',
				'default'     => 'solid',
				'show_if'     => array(
					'use_divider' => 'on',
				),
			),
			'divider_color'            => array(
				'label'       => esc_html__( 'Divider Line Color', 'divi_flash' ),
				'type'        => 'color-alpha',
				'toggle_slug' => 'divider',
				'show_if'     => array(
					'use_divider' => 'on',
				),
			),
			'divider_height'           => array(
				'label'            => esc_html__( 'Divider Thickness', 'divi_flash' ),
				'type'             => 'range',
				'toggle_slug'      => 'divider',
				'default'          => '5px',
				'default_unit'     => 'px',
				'default_on_front' => '',
				'mobile_options'   => true,
				'range_settings'   => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'          => array(
					'use_divider' => 'on',
				),
			),
			'divider_border_radius'    => array(
				'label'            => esc_html__( 'Divider Border Radius', 'divi_flash' ),
				'type'             => 'range',
				'toggle_slug'      => 'divider',
				'default'          => '0px',
				'default_unit'     => 'px',
				'default_on_front' => '',
				'hover'            => 'tabs',
				'responsive'       => true,
				'mobile_options'   => true,
				'range_settings'   => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'          => array(
					'use_divider' => 'on',
				),
			),
			'divider_width'            => array(
				'label'            => esc_html__( 'Divider Max Width', 'divi_flash' ),
				'type'             => 'range',
				'toggle_slug'      => 'divider',
				'default'          => '100%',
				'default_unit'     => '%',
				'default_on_front' => '',
				'hover'            => 'tabs',
				'mobile_options'   => true,
				'range_settings'   => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'          => array(
					'use_divider' => 'on',
				),
			),
			'divider_alignment'        => array(
				'label'       => esc_html__( 'Divider Alignment', 'divi_flash' ),
				'type'        => 'text_align',
				'toggle_slug' => 'divider',
				'options'     => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'show_if'     => array(
					'use_divider' => 'on',
				),
				'show_if_not' => array(
					'divider_width' => '100%',
				),
			),
			'use_divider_icon'         => array(
				'label'       => esc_html__( 'Use Divider Icon', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'default'     => 'off',
				'toggle_slug' => 'divider',
				'show_if'     => array(
					'use_divider' => 'on',
				),
				'show_if_not' => array(
					'use_divider_image' => 'on',
				),
			),
			'divider_icon'             => array(
				'label'       => esc_html__( 'Icon', 'divi_flash' ),
				'type'        => 'select_icon',
				'class'       => array( 'et-pb-font-icon' ),
				'toggle_slug' => 'divider',
				'show_if'     => array(
					'use_divider'      => 'on',
					'use_divider_icon' => 'on',
				),
			),
			'divider_icon_alignment'   => array(
				'label'       => esc_html__( 'Divider Icon Alignment', 'divi_flash' ),
				'type'        => 'text_align',
				'toggle_slug' => 'divider',
				'options'     => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'show_if'     => array(
					'use_divider'      => 'on',
					'use_divider_icon' => 'on',
				),
			),
			'divider_icon_color'       => array(
				'label'       => esc_html__( 'Divider Icon Color', 'divi_flash' ),
				'type'        => 'color-alpha',
				'toggle_slug' => 'divider',
				'hover'       => 'tabs',
				'show_if'     => array(
					'use_divider'      => 'on',
					'use_divider_icon' => 'on',
				),
			),
			'divider_icon_bgcolor'     => array(
				'label'       => esc_html__( 'Divider Icon Background Color', 'divi_flash' ),
				'type'        => 'color-alpha',
				'toggle_slug' => 'divider',
				'hover'       => 'tabs',
				'default'     => 'rgba(0,0,0,0)',
				'show_if'     => array(
					'use_divider'      => 'on',
					'use_divider_icon' => 'on',
				),
			),
			'use_divider_icon_circle'  => array(
				'label'       => esc_html__( 'Icon Circle', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'default'     => 'off',
				'toggle_slug' => 'divider',
				'show_if'     => array(
					'use_divider'      => 'on',
					'use_divider_icon' => 'on',
				),
			),
			'dvr_icon_font_size'       => array(
				'label'            => esc_html__( 'Divider Icon Size', 'divi_flash' ),
				'type'             => 'range',
				'toggle_slug'      => 'divider',
				'default'          => '18px',
				'default_unit'     => 'px',
				'default_on_front' => '',
				'hover'            => 'tabs',
				'responsive'       => true,
				'mobile_options'   => true,
				'range_settings'   => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'          => array(
					'use_divider'      => 'on',
					'use_divider_icon' => 'on',
				),
			),
			'use_divider_image'        => array(
				'label'       => esc_html__( 'Use Divider Image', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'default'     => 'off',
				'toggle_slug' => 'divider',
				'show_if'     => array(
					'use_divider' => 'on',
				),
				'show_if_not' => array(
					'use_divider_icon' => 'on',
				),
			),
			'divider_image'            => array(
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Image', 'divi_flash' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'        => esc_attr__( 'Set As Image', 'divi_flash' ),
				'toggle_slug'        => 'divider',
				'show_if'            => array(
					'use_divider'       => 'on',
					'use_divider_image' => 'on',
				),
			),
			'divider_image_alt_text'   => array(
				'label'       => esc_html__( 'Image Alt Text', 'divi_flash' ),
				'type'        => 'text',
				'toggle_slug' => 'divider',
				'show_if'     => array(
					'use_divider'       => 'on',
					'use_divider_image' => 'on',
				),
			),
			'divider_image_width'      => array(
				'label'            => esc_html__( 'Divider Image Max Width', 'divi_flash' ),
				'type'             => 'range',
				'toggle_slug'      => 'divider',
				'default'          => '100px',
				'default_unit'     => 'px',
				'default_on_front' => '',
				'hover'            => 'tabs',
				'responsive'       => true,
				'mobile_options'   => true,
				'range_settings'   => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'show_if'          => array(
					'use_divider'       => 'on',
					'use_divider_image' => 'on',
				),
			),
			'divider_image_alignment'  => array(
				'label'       => esc_html__( 'Divider Image Alignment', 'divi_flash' ),
				'type'        => 'text_align',
				'toggle_slug' => 'divider',
				'options'     => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'show_if'     => array(
					'use_divider'       => 'on',
					'use_divider_image' => 'on',
				),
			),
			'divider_image_bgcolor'    => array(
				'label'       => esc_html__( 'Divider Image Background Color', 'divi_flash' ),
				'type'        => 'color-alpha',
				'toggle_slug' => 'divider',
				'hover'       => 'tabs',
				'default'     => 'rgba(0,0,0,0)',
				'show_if'     => array(
					'use_divider'       => 'on',
					'use_divider_image' => 'on',
				),
			),
			'use_divider_image_circle' => array(
				'label'       => esc_html__( 'Image Circle', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
				),
				'default'     => 'off',
				'toggle_slug' => 'divider',
				'show_if'     => array(
					'use_divider'       => 'on',
					'use_divider_image' => 'on',
				),
			),
		);
		$prefix_max_width     = $this->df_add_max_width(
			array(
				'title_pefix' => 'Prefix',
				'key'         => 'prefix',
				'toggle_slug' => 'prefix',
				'sub_toggle'  => null,
				'alignment'   => true,
				'priority'    => 30,
				'tab_slug'    => 'advanced',
				'show_if'     => array(
					'title_prefix_block' => 'block',
				),
			)
		);
		$infix_max_width      = $this->df_add_max_width(
			array(
				'title_pefix' => 'Infix',
				'key'         => 'infix',
				'toggle_slug' => 'infix',
				'sub_toggle'  => null,
				'alignment'   => true,
				'priority'    => 30,
				'tab_slug'    => 'advanced',
				'show_if'     => array(
					'title_infix_block' => 'block',
				),
			)
		);
		$suffix_max_width     = $this->df_add_max_width(
			array(
				'title_pefix' => 'Suffix',
				'key'         => 'suffix',
				'toggle_slug' => 'suffix',
				'sub_toggle'  => null,
				'alignment'   => true,
				'priority'    => 30,
				'tab_slug'    => 'advanced',
				'show_if'     => array(
					'title_suffix_block' => 'block',
				),
			)
		);
		$divider_background   = $this->df_add_bg_field(
			array(
				'label'       => 'Divider Line Background',
				'key'         => 'divider_background',
				'toggle_slug' => 'divider_background',
				'tab_slug'    => 'general',
			)
		);
		$prefix_background    = $this->df_add_bg_field(
			array(
				'label'       => 'Prefix Background',
				'key'         => 'prefix_background',
				'toggle_slug' => 'prefix_background',
				'tab_slug'    => 'general',
			)
		);
		$infix_background     = $this->df_add_bg_field(
			array(
				'label'       => 'Infix Background',
				'key'         => 'infix_background',
				'toggle_slug' => 'infix_background',
				'tab_slug'    => 'general',
			)
		);
		$suffix_background    = $this->df_add_bg_field(
			array(
				'label'       => 'Suffix Background',
				'key'         => 'suffix_background',
				'toggle_slug' => 'suffix_background',
				'tab_slug'    => 'general',
			)
		);
		$heading_spacing      = $this->add_margin_padding(
			array(
				'title'       => 'Heading',
				'key'         => 'heading',
				'toggle_slug' => 'margin_padding',
			)
		);
		$prefix_spacing       = $this->add_margin_padding(
			array(
				'title'       => 'Prefix',
				'key'         => 'prefix',
				'toggle_slug' => 'margin_padding',
			)
		);
		$infix_spacing        = $this->add_margin_padding(
			array(
				'title'       => 'Infix',
				'key'         => 'infix',
				'toggle_slug' => 'margin_padding',
			)
		);
		$suffix_spacing       = $this->add_margin_padding(
			array(
				'title'       => 'Suffix',
				'key'         => 'suffix',
				'toggle_slug' => 'margin_padding',
			)
		);
		$divider_container_spacing = $this->add_margin_padding(
			array(
				'title'       => 'Divider Container',
				'key'         => 'divider_container',
				'toggle_slug' => 'margin_padding',
			)
		);
		$divider_spacing           = $this->add_margin_padding(
			array(
				'title'       => 'Divider Line',
				'key'         => 'divider',
				'toggle_slug' => 'margin_padding',
			)
		);
		$divider_icon_spacing      = $this->add_margin_padding(
			array(
				'title'       => 'Divider Icon & Image',
				'key'         => 'divider_icon_image',
				'toggle_slug' => 'margin_padding',
			)
		);
		$dual_text_spacing = $this->add_margin_padding(
			array(
				'title'       => 'Dual Text',
				'key'         => 'dual_text',
				'toggle_slug' => 'dual_text',
			)
		);
		$prefix_text_clip  = $this->df_text_clip(
			array(
				'key'         => 'df_prefix',
				'toggle_slug' => 'prefix',
				'tab_slug'    => 'advanced',
			)
		);
		$infix_text_clip   = $this->df_text_clip(
			array(
				'key'         => 'df_infix',
				'toggle_slug' => 'infix',
				'tab_slug'    => 'advanced',
			)
		);
		$suffix_text_clip  = $this->df_text_clip(
			array(
				'key'         => 'df_suffix',
				'toggle_slug' => 'suffix',
				'tab_slug'    => 'advanced',
			)
		);

		return array_merge(
			$heading,
			$highlighter_settings,
			$divider,
			$divider_background,
			$prefix_max_width,
			$prefix_text_clip,
			$infix_max_width,
			$infix_text_clip,
			$suffix_max_width,
			$suffix_text_clip,
			$prefix_background,
			$infix_background,
			$suffix_background,
			$heading_spacing,
			$prefix_spacing,
			$infix_spacing,
			$suffix_spacing,
			// $highlighter_spacing,
			$divider_container_spacing,
			$divider_spacing,
			$divider_icon_spacing,
			$dual_text_spacing
		);
	}

	public function additional_css_styles( $render_slug ) {
		$this->df_process_bg(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_background',
				'selector'    => '%%order_class%% .df-heading-divider .df-divider-line',
				'hover'       => '%%order_class%%:hover .df-heading-divider .df-divider-line',
			)
		);
		$this->df_process_bg(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'prefix_background',
				'selector'    => '%%order_class%% .df-heading .prefix',
				'hover'       => '%%order_class%%:hover .df-heading .prefix',
			)
		);
		$this->df_process_bg(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'infix_background',
				'selector'    => '%%order_class%% .df-heading .infix',
				'hover'       => '%%order_class%%:hover .df-heading:hover .infix',
			)
		);
		$this->df_process_bg(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'suffix_background',
				'selector'    => '%%order_class%% .df-heading .suffix',
				'hover'       => '%%order_class%%:hover .df-heading .suffix',
			)
		);

		// heading spacing.
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'heading_margin',
				'type'        => 'margin',
				'selector'    => '%%order_class%% .df-heading',
				'hover'       => '%%order_class%%:hover .df-heading',
				'important'   => true,
			)
		);
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'heading_padding',
				'type'        => 'padding',
				'selector'    => '%%order_class%% .df-heading',
				'hover'       => '%%order_class%%:hover .df-heading',
				'important'   => true,
			)
		);
		// prefix spacing.
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'prefix_margin',
				'type'        => 'margin',
				'selector'    => '%%order_class%% .df-heading .prefix',
				'hover'       => '%%order_class%%:hover .df-heading .prefix',
				'important'   => true,
			)
		);
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'prefix_padding',
				'type'        => 'padding',
				'selector'    => '%%order_class%% .df-heading .prefix',
				'hover'       => '%%order_class%%:hover .df-heading .prefix',
				'important'   => true,
			)
		);
		// infix spacing.
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'infix_margin',
				'type'        => 'margin',
				'selector'    => '%%order_class%% .df-heading .infix',
				'hover'       => '%%order_class%%:hover .df-heading .infix',
				'important'   => true,
			)
		);
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'infix_padding',
				'type'        => 'padding',
				'selector'    => '%%order_class%% .df-heading .infix',
				'hover'       => '%%order_class%%:hover .df-heading .infix',
				'important'   => true,
			)
		);
		// suffix spacing.
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'suffix_margin',
				'type'        => 'margin',
				'selector'    => '%%order_class%% .df-heading .suffix',
				'hover'       => '%%order_class%%:hover .df-heading .suffix',
				'important'   => true,
			)
		);
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'suffix_padding',
				'type'        => 'padding',
				'selector'    => '%%order_class%% .df-heading .suffix',
				'hover'       => '%%order_class%%:hover .df-heading .suffix',
				'important'   => true,
			)
		);

		// divider spacing.
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_margin',
				'type'        => 'margin',
				'selector'    => '%%order_class%% .df-heading-divider .df-divider-line',
				'hover'       => '%%order_class%%:hover .df-heading-divider .df-divider-line',
				'important'   => true,
			)
		);
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_padding',
				'type'        => 'padding',
				'selector'    => '%%order_class%% .df-heading-divider .df-divider-line',
				'hover'       => '%%order_class%%:hover .df-heading-divider .df-divider-line',
				'important'   => true,
			)
		);
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_container_margin',
				'type'        => 'margin',
				'selector'    => '%%order_class%% .df-heading-divider',
				'hover'       => '%%order_class%%:hover .df-heading-divider',
				'important'   => true,
			)
		);
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_container_padding',
				'type'        => 'padding',
				'selector'    => '%%order_class%% .df-heading-divider',
				'hover'       => '%%order_class%%:hover .df-heading-divider',
				'important'   => true,
			)
		);
		// Divider Icon and Image text spacing.
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_icon_image_margin',
				'type'        => 'margin',
				'selector'    => '%%order_class%% .df-heading-divider span',
				'hover'       => '%%order_class%%:hover .df-heading-divider span',
				'important'   => true,
			)
		);
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_icon_image_margin',
				'type'        => 'margin',
				'selector'    => '%%order_class%% .df-heading-divider img',
				'hover'       => '%%order_class%%:hover .df-heading-divider img',
				'important'   => true,
			)
		);
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_icon_image_padding',
				'type'        => 'padding',
				'selector'    => '%%order_class%% .df-heading-divider span',
				'hover'       => '%%order_class%%:hover .df-heading-divider span',
				'important'   => true,
			)
		);
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_icon_image_padding',
				'type'        => 'padding',
				'selector'    => '%%order_class%% .df-heading-divider img',
				'hover'       => '%%order_class%%:hover .df-heading-divider img',
				'important'   => true,
			)
		);
		// dual_text text spacing.
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'dual_text_margin',
				'type'        => 'margin',
				'selector'    => '%%order_class%% .df-heading-dual_text',
				'hover'       => '%%order_class%%:hover .df-heading-dual_text',
				'important'   => true,
			)
		);
		$this->set_margin_padding_styles(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'dual_text_padding',
				'type'        => 'padding',
				'selector'    => '%%order_class%% .df-heading-dual_text',
				'hover'       => '%%order_class%%:hover .df-heading-dual_text',
				'important'   => true,
			)
		);

		// Highlighter styles.
		if ( 'on' !== $this->props['enable_gradient_color'] ) {
			$this->df_process_color(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'highlighter_color',
					'type'        => 'stroke',
					'selector'    => '%%order_class%% .df-text-highlight svg path',
					'hover'       => '%%order_class%%:hover .df-text-highlight svg path',
				)
			);
		} else {
			$svg_gradient_color_id = 'gradient_' . $this->props['highlighter_type'] . '_' . $this->get_module_order_class( $render_slug );

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-text-highlight svg path',
					'declaration' => 'stroke: url(#' . $svg_gradient_color_id . ');',
				)
			);
		}

		$this->df_process_range(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'highlighter_stroke_width',
				'type'        => 'stroke-width',
				'selector'    => '%%order_class%% .df-text-highlight svg path',
				'hover'       => '%%order_class%%:hover .df-text-highlight svg path',
				'default'     => '8px',
			)
		);

		// svg scale and transform
		$infix_text_padding_right_desktop = '0px';
		$infix_text_padding_right_tablet  = $infix_text_padding_right_desktop;
		$infix_text_padding_right_phone   = $infix_text_padding_right_tablet;

		if ( isset( $this->props['infix_padding'] ) ) {
			$infix_text_padding_right_desktop = isset( $this->props['infix_padding'] ) && $this->props['infix_padding'] !== '' ? explode( '|', $this->props['infix_padding'] )[1] : '0px';
			$infix_text_padding_right_tablet  = isset( $this->props[ 'infix_padding' . '_tablet' ] ) && $this->props[ 'infix_padding' . '_tablet' ] !== '' ? explode( '|', $this->props[ 'infix_padding' . '_tablet' ] )[1] : $infix_text_padding_right_desktop;
			$infix_text_padding_right_phone   = isset( $this->props[ 'infix_padding' . '_phone' ] ) && $this->props[ 'infix_padding' . '_phone' ] !== '' ? explode( '|', $this->props[ 'infix_padding' . '_phone' ] )[1] : $infix_text_padding_right_tablet;
		}

		$highlighter_size_desktop = isset( $this->props['highlighter_size'] ) && $this->props['highlighter_size'] !== '' ? $this->props['highlighter_size'] : 1;
		$highlighter_size_tablet  = isset( $this->props[ 'highlighter_size' . '_tablet' ] ) && $this->props[ 'highlighter_size' . '_tablet' ] !== '' ? $this->props[ 'highlighter_size' . '_tablet' ] : $highlighter_size_desktop;
		$highlighter_size_phone   = isset( $this->props[ 'highlighter_size' . '_phone' ] ) && $this->props[ 'highlighter_size' . '_phone' ] !== '' ? $this->props[ 'highlighter_size' . '_phone' ] : $highlighter_size_tablet;

		if ( '' === $infix_text_padding_right_desktop ) {
			$infix_text_padding_right_desktop = '0px';
		}

		if ( isset( $highlighter_size_desktop ) || isset( $infix_text_padding_right_desktop ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-text-highlight svg',
					'declaration' => 'transform: translateX(calc(-100% + 10px + ' . $infix_text_padding_right_desktop . ')) scale(' . $highlighter_size_desktop . ');',
				)
			);
		}

		if ( '' === $infix_text_padding_right_tablet ) {
			$infix_text_padding_right_tablet = '0px';
		}

		if ( isset( $highlighter_size_tablet ) || isset( $infix_text_padding_right_tablet ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-text-highlight svg',
					'declaration' => 'transform: translateX(calc(-100% + 10px + ' . $infix_text_padding_right_tablet . ')) scale(' . $highlighter_size_tablet . ');',
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}
		if ( '' === $infix_text_padding_right_phone ) {
			$infix_text_padding_right_phone = '0px';
		}
		if ( isset( $highlighter_size_phone ) || isset( $infix_text_padding_right_phone ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-text-highlight svg',
					'declaration' => 'transform: translateX(calc(-100% + 10px + ' . $infix_text_padding_right_phone . ')) scale(' . $highlighter_size_phone . ');',
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		if ( et_builder_is_hover_enabled( 'highlighter_size', $this->props ) && isset( $this->props[ 'highlighter_size' . '__hover' ] ) && '' !== $this->props['highlighter_size'] ) {
			$highlighter_size_hover = $this->props[ 'highlighter_size' . '__hover' ];
			if ( ! empty( $highlighter_size_hover ) ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%%:hover .df-text-highlight svg',
						'declaration' => 'transform: translateX(calc(-100% + 10px + ' . $infix_text_padding_right_desktop . ')) scale(' . $highlighter_size_hover . ') !important;',
					)
				);
			}
		}

		$this->df_process_range(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'highlighter_opacity',
				'type'        => 'opacity',
				'selector'    => '%%order_class%% .df-text-highlight svg',
				'hover'       => '%%order_class%%:hover .df-text-highlight svg',
			)
		);

		if ( 'above' === $this->props['highlighter_position'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-text-highlight svg',
					'declaration' => 'z-index: 1 !important;',
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-texthighlighter-container .df-heading > span',
					'declaration' => 'z-index: 0 !important;',
				)
			);
		}

		$this->df_process_range(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'highlighter_vertical_position',
				'type'        => 'top',
				'selector'    => '%%order_class%% .df-text-highlight svg',
				'hover'       => '%%order_class%%:hover .df-text-highlight svg',
			)
		);

		$this->df_process_range(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'highlighter_horizontal_position',
				'type'        => 'margin-left',
				'selector'    => '%%order_class%% .df-text-highlight svg',
				'hover'       => '%%order_class%%:hover .df-text-highlight svg',
			)
		);

		// divider styles
		if ( isset( $this->props['divider_style'] ) && ! empty( $this->props['divider_style'] ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-heading-divider .df-divider-line::before',
					'declaration' => sprintf(
						'border-top-style:%1$s !important;',
						$this->props['divider_style']
					),
				)
			);
		}
		if ( isset( $this->props['divider_color'] ) && ! empty( $this->props['divider_color'] ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-heading-divider .df-divider-line::before',
					'declaration' => sprintf(
						'border-top-color:%1$s !important;',
						$this->props['divider_color']
					),
				)
			);
		}
		$divider_height = isset( $this->props['divider_height'] ) && ! empty( $this->props['divider_height'] ) ?
			$this->props['divider_height'] : '5px';
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .df-heading-divider .df-divider-line',
				'declaration' => sprintf(
					'top:calc(%1$s - %2$s);',
					'50%',
					$this->df_get_div_value( $divider_height )
				),
			)
		);
		if ( isset( $this->props['divider_height_tablet'] ) && ! empty( $this->props['divider_height_tablet'] ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-heading-divider .df-divider-line',
					'declaration' => sprintf(
						'top:calc(%1$s - %2$s);',
						'50%',
						$this->df_get_div_value( $this->props['divider_height_tablet'] )
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}
		if ( isset( $this->props['divider_height_phone'] ) && ! empty( $this->props['divider_height_phone'] ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-heading-divider .df-divider-line',
					'declaration' => sprintf(
						'top:calc(%1$s - %2$s);',
						'50%',
						$this->df_get_div_value( $this->props['divider_height_phone'] )
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}
		$this->apply_single_value(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_height',
				'type'        => 'border-top-width',
				'selector'    => '%%order_class%% .df-heading-divider .df-divider-line::before',
				'unit'        => 'px',
				'default'     => '5',
			)
		);
		$this->apply_single_value(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_height',
				'type'        => 'height',
				'selector'    => '%%order_class%% .df-heading-divider .df-divider-line',
				'unit'        => 'px',
				'default'     => '5',
			)
		);
		$this->apply_single_value(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_width',
				'type'        => 'max-width',
				'selector'    => '%%order_class%% .df-heading-divider',
				'unit'        => '%',
				'hover'       => '%%order_class%%:hover .df-heading-divider',
				'default'     => '100',
			)
		);
		if ( isset( $this->props['divider_alignment'] ) && ! empty( $this->props['divider_alignment'] ) ) {
			if ( $this->props['divider_alignment'] === 'center' ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .df-heading-divider',
						'declaration' => 'margin: 0 auto;',
					)
				);
			}
			if ( $this->props['divider_alignment'] === 'right' ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .df-heading-divider',
						'declaration' => 'margin: 0 0 0 auto;',
					)
				);
			}
		}
		if ( $this->props['use_divider_icon'] !== 'on' && $this->props['use_divider_image'] !== 'on' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-heading-divider::before',
					'declaration' => 'position: relative;',
				)
			);
		}
		if ( $this->props['use_divider_icon_circle'] === 'on' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-heading-divider .et-pb-icon',
					'declaration' => 'border-radius: 50%;',
				)
			);
		}
		if ( $this->props['use_divider_image_circle'] === 'on' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-heading-divider img',
					'declaration' => 'border-radius: 50%;',
				)
			);
		}
		$this->apply_single_value(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_border_radius',
				'type'        => 'border-radius',
				'selector'    => '%%order_class%% .df-heading-divider .df-divider-line:before',
				'unit'        => 'px',
				'hover'       => '%%order_class%%:hover .df-heading-divider .df-divider-line:before',
				'default'     => '0',
			)
		);
		$this->apply_single_value(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_border_radius',
				'type'        => 'border-radius',
				'selector'    => '%%order_class%% .df-heading-divider .df-divider-line',
				'unit'        => 'px',
				'hover'       => '%%order_class%%:hover .df-heading-divider .df-divider-line',
				'default'     => '0',
			)
		);
		$this->apply_single_value(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'dvr_icon_font_size',
				'type'        => 'font-size',
				'selector'    => '%%order_class%% .df-heading-divider span',
				'unit'        => 'px',
				'hover'       => '%%order_class%%:hover .df-heading-divider .et-pb-icon',
				'default'     => '18',
			)
		);
		$this->df_process_color(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_icon_color',
				'type'        => 'color',
				'selector'    => '%%order_class%% .df-heading-divider .et-pb-icon',
				'hover'       => '%%order_class%%:hover .df-heading-divider .et-pb-icon',
			)
		);
		$this->df_process_color(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_icon_bgcolor',
				'type'        => 'background-color',
				'selector'    => '%%order_class%% .df-heading-divider .et-pb-icon',
				'hover'       => '%%order_class%%:hover .df-heading-divider .et-pb-icon',
			)
		);
		$this->df_process_color(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_image_bgcolor',
				'type'        => 'background-color',
				'selector'    => '%%order_class%% .df-heading-divider img',
				'hover'       => '%%order_class%%:hover .df-heading-divider img',
			)
		);
		if ( ! empty( $this->props['divider_icon_alignment'] ) && $this->props['use_divider_icon'] === 'on' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-heading-divider',
					'declaration' => sprintf( 'text-align: %1$s;', $this->props['divider_icon_alignment'] ),
				)
			);
		}
		$this->apply_single_value(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'divider_image_width',
				'type'        => 'max-width',
				'selector'    => '%%order_class%% .df-heading-divider .divider-image',
				'unit'        => 'px',
				'hover'       => '%%order_class%%:hover .df-heading-divider .divider-image',
				'default'     => '100',
			)
		);
		if ( ! empty( $this->props['divider_image_alignment'] ) && $this->props['use_divider_image'] == 'on' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .df-heading-divider',
					'declaration' => sprintf( 'text-align: %1$s;', $this->props['divider_image_alignment'] ),
				)
			);
		}
		// Display Element
		$this->df_process_string_attr(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'title_prefix_block',
				'type'        => 'display',
				'selector'    => '%%order_class%% .df-heading .prefix',
				'hover'       => '%%order_class%%:hover .df-heading .prefix',
				'default'     => 'inline-block',
			)
		);
		$this->df_process_string_attr(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'title_infix_block',
				'type'        => 'display',
				'selector'    => '%%order_class%% .df-heading .infix',
				'hover'       => '%%order_class%%:hover .df-heading .infix',
				'default'     => 'inline-block',
			)
		);
		$this->df_process_string_attr(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'title_suffix_block',
				'type'        => 'display',
				'selector'    => '%%order_class%% .df-heading .suffix',
				'hover'       => '%%order_class%%:hover .df-heading .suffix',
				'default'     => 'inline-block',
			)
		);

		// process max-width and alignment
		$this->df_process_maxwidth(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'prefix',
				'selector'    => '%%order_class%% .df-heading .prefix',
				'hover'       => '%%order_class%%:hover .df-heading .prefix',
				'alignment'   => true,
				'important'   => true,
			)
		);
		$this->df_process_maxwidth(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'infix',
				'selector'    => '%%order_class%% .df-heading .infix',
				'hover'       => '%%order_class%%:hover .df-heading .infix',
				'alignment'   => true,
				'important'   => true,
			)
		);
		$this->df_process_maxwidth(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'suffix',
				'selector'    => '%%order_class%% .df-heading .suffix',
				'hover'       => '%%order_class%%:hover .df-heading .suffix',
				'alignment'   => true,
				'important'   => true,
			)
		);

		// text clip
		$this->df_process_text_clip(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'df_prefix',
				'selector'    => '%%order_class%% .df-heading .prefix',
				'hover'       => '%%order_class%%:hover .df-heading .prefix',
			)
		);
		$this->df_process_text_clip(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'df_infix',
				'selector'    => '%%order_class%% .df-heading .infix',
				'hover'       => '%%order_class%%:hover .df-heading .infix',
			)
		);
		$this->df_process_text_clip(
			array(
				'render_slug' => $render_slug,
				'slug'        => 'df_suffix',
				'selector'    => '%%order_class%% .df-heading .suffix',
				'hover'       => '%%order_class%%:hover .df-heading .suffix',
			)
		);

		// icon font family
		if ( method_exists( 'ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon' ) ) {
			$this->generate_styles(
				array(
					'utility_arg'    => 'icon_font_family',
					'render_slug'    => $render_slug,
					'base_attr_name' => 'divider_icon',
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

	public function get_transition_fields_css_props() {
		$fields                 = parent::get_transition_fields_css_props();
		$prefix                 = '%%order_class%% .df-heading .prefix';
		$infix                  = '%%order_class%% .df-heading .infix';
		$suffix                 = '%%order_class%% .df-heading .suffix';
		$heading                = '%%order_class%% .df-heading';
		$divider_line_container = '%%order_class%% .df-heading-divider';
		$divider_line           = '%%order_class%% .df-heading-divider .df-divider-line';
		$divider_icon           = '%%order_class%% .df-heading-divider span';
		$divider_img            = '%%order_class%% .df-heading-divider img';
		$dual_text              = '%%order_class%% .df-heading-dual_text';

		// spacing
		$fields['heading_margin']  = array( 'margin' => $heading );
		$fields['heading_padding'] = array( 'padding' => $heading );

		$fields['prefix_margin']  = array( 'margin' => $prefix );
		$fields['prefix_padding'] = array( 'padding' => $prefix );

		$fields['infix_margin']  = array( 'margin' => $infix );
		$fields['infix_padding'] = array( 'padding' => $infix );

		$fields['suffix_margin']  = array( 'margin' => $suffix );
		$fields['suffix_padding'] = array( 'padding' => $suffix );

		$fields['divider_margin']  = array( 'margin' => $divider_line );
		$fields['divider_padding'] = array( 'padding' => $divider_line );

		$fields['divider_container_margin']  = array( 'margin' => $divider_line_container );
		$fields['divider_container_padding'] = array( 'padding' => $divider_line_container );

		$fields['divider_icon_image_margin']  = array( 'margin' => $divider_icon );
		$fields['divider_icon_image_padding'] = array( 'padding' => $divider_icon );
		$fields['divider_icon_image_margin']  = array( 'margin' => $divider_img );
		$fields['divider_icon_image_padding'] = array( 'padding' => $divider_img );

		$fields['dual_text_margin']  = array( 'margin' => $dual_text );
		$fields['dual_text_padding'] = array( 'padding' => $dual_text );

		// others
		$fields['divider_width'] = array( 'max-width' => $divider_line_container );

		$fields['divider_border_radius'] = array( 'border-radius' => '%%order_class%% .df-heading-divider .df-divider-line:before' );
		$fields['divider_border_radius'] = array( 'border-radius' => $divider_line );

		$fields['dvr_icon_font_size'] = array( 'font-size' => $divider_icon );

		$fields['highlighter_color'] = array( 'stroke' => '%%order_class%% .df-text-highlight svg path' );

		$fields['divider_icon_color'] = array( 'color' => '%%order_class%% .df-heading-divider .et-pb-icon' );

		$fields['divider_icon_bgcolor']  = array( 'background-color' => '%%order_class%% .df-heading-divider .et-pb-icon' );
		$fields['divider_image_bgcolor'] = array( 'background-color' => $divider_img );

		$fields['divider_image_width'] = array( 'max-width' => '%%order_class%% .df-heading-divider .divider-image' );

		$fields['prefix_maxwidth'] = array( 'max-width' => $prefix );
		$fields['infix_maxwidth']  = array( 'max-width' => $infix );
		$fields['suffix_maxwidth'] = array( 'max-width' => $suffix );

		$fields['highlighter_stroke_width'] = array( 'stroke-width' => '%%order_class%% .df-text-highlight svg path' );
		// $fields['highlighter_size']         = array( 'transform' => '%%order_class%% .df-text-highlight svg' );
		$fields['highlighter_opacity']             = array( 'opacity' => '%%order_class%% .df-text-highlight svg' );
		$fields['highlighter_vertical_position']   = array( 'bottom' => '%%order_class%% .df-text-highlight svg' );
		$fields['highlighter_horizontal_position'] = array( 'margin-left' => '%%order_class%% .df-text-highlight svg' );

		$fields['df_prefix_fill_color']   = array( '-webkit-text-fill-color' => $prefix );
		$fields['df_prefix_fill_color']   = array( '-webkit-text-stroke-color' => $prefix );
		$fields['df_prefix_stroke_width'] = array( '-webkit-text-stroke-width' => $prefix );

		$fields['df_infix_fill_color']   = array( '-webkit-text-fill-color' => $infix );
		$fields['df_infix_fill_color']   = array( '-webkit-text-stroke-color' => $infix );
		$fields['df_infix_stroke_width'] = array( '-webkit-text-stroke-width' => $infix );

		$fields['df_suffix_fill_color']   = array( '-webkit-text-fill-color' => $suffix );
		$fields['df_suffix_fill_color']   = array( '-webkit-text-stroke-color' => $suffix );
		$fields['df_suffix_stroke_width'] = array( '-webkit-text-stroke-width' => $suffix );

		// background
		$fields = $this->df_background_transition(
			array(
				'fields'   => $fields,
				'key'      => 'divider_background',
				'selector' => $divider_line,
			)
		);
		$fields = $this->df_background_transition(
			array(
				'fields'   => $fields,
				'key'      => 'prefix_background',
				'selector' => $prefix,
			)
		);
		$fields = $this->df_background_transition(
			array(
				'fields'   => $fields,
				'key'      => 'infix_background',
				'selector' => $infix,
			)
		);
		$fields = $this->df_background_transition(
			array(
				'fields'   => $fields,
				'key'      => 'suffix_background',
				'selector' => $suffix,
			)
		);

		return $fields;
	}

	public function get_custom_css_fields_config() {
		return array(
			'highlighter_prefix_css' => array(
				'label'    => esc_html__( 'Prefix', 'divi_flash' ),
				'selector' => '%%order_class%% .df-texthighlighter-container .df-heading .prefix',
			),
			'highlighter_infix_css' => array(
				'label'    => esc_html__( 'Infix', 'divi_flash' ),
				'selector' => '%%order_class%% .df-texthighlighter-container .df-heading .infix',
			),
			'highlighter_suffix_css' => array(
				'label'    => esc_html__( 'Suffix', 'divi_flash' ),
				'selector' => '%%order_class%% .df-texthighlighter-container .df-heading .suffix',
			),
			'highlighter_svg_css' => array(
				'label'    => esc_html__( 'Highlighter', 'divi_flash' ),
				'selector' => '%%order_class%% .df-text-highlight svg',
			),
		);
	}

	public function render_divider( $position, $value ) {
		$divider_icon = '';
		if ( $this->props['use_divider_icon'] === 'on' ) {
			$divider_icon = ! empty( $this->props['divider_icon'] ) && $this->props['divider_icon'] !== null ?
				sprintf(
					'<span class="et-pb-icon">%1$s</span>',
					html_entity_decode( et_pb_process_font_icon( $this->props['divider_icon'] ) )
				) :
					'<span class="et-pb-icon">1</span>';
		}
		if ( $this->props['use_divider_image'] === 'on' ) {
			$image_alt    = $this->props['divider_image_alt_text'] !== '' ? $this->props['divider_image_alt_text'] : df_image_alt_by_url( $this->props['divider_image'] );
			$divider_icon = ! empty( $this->props['divider_image'] ) && $this->props['divider_image'] !== null ?
				sprintf(
					'<img alt="%2$s" src="%1$s" class="divider-image"/>',
					$this->props['divider_image'],
					$image_alt
				) : '';
		}
		if ( $value === $position ) {
			return $this->props['use_divider'] === 'on' ?
				sprintf( '<div class="df-heading-divider"><div class="df-divider-line"></div>%1$s</div>', $divider_icon ) : '';
		}
	}

	public function highlighter_svg() {
		$highlighter_svg = array(
			'underline'     => '<svg id="underline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="underline" d="M7.7,145.6C109,125,299.9,116.2,401,121.3c42.1,2.2,87.6,11.8,87.3,25.7"></path></svg>',
			'curlyline1'    => '<svg id="curlyline1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="curlyline1" d="M3,146.1c17.1-8.8,33.5-17.8,51.4-17.8c15.6,0,17.1,18.1,30.2,18.1c22.9,0,36-18.6,53.9-18.6 c17.1,0,21.3,18.5,37.5,18.5c21.3,0,31.8-18.6,49-18.6c22.1,0,18.8,18.8,36.8,18.8c18.8,0,37.5-18.6,49-18.6c20.4,0,17.1,19,36.8,19 c22.9,0,36.8-20.6,54.7-18.6c17.7,1.4,7.1,19.5,33.5,18.8c17.1,0,47.2-6.5,61.1-15.6"></path></svg>',
			'curlyline2'    => '<svg id="curlyline2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="curlyline2" d="M2.2,140.2l4.6-4.5c18.1-17.7,47.5-17.7,65.7,0l4.4,4.2l4.1-4c18.1-17.7,47.5-17.7,65.7,0l4.4,4.2l4.1-4c18.1-17.7,47.5-17.7,65.7,0l4.8,4.7l2.8-2.8c17.9-17.4,46.8-17.7,65-0.6l3.4,3.2l2.6-2.4c18.1-16.7,46.5-16.4,64.4,0.5l1.7,1.6l1.2-1.1c18-16.9,46.6-16.9,64.6,0.1l1.3,1.3l0.5-0.5c18.2-17.2,47.2-17,65.2,0.5l0,0"></path></svg>',
			'delete'        => '<svg id="delete" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="deleteA" d="M497.4,23.9C301.6,40,155.9,80.6,4,144.4"></path><path class="deleteB" d="M14.1,27.6c204.5,20.3,393.8,74,467.3,111.7"></path></svg>',
			'circle1'       => '<svg id="circle1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="circle1" d="M325,18C228.7-8.3,118.5,8.3,78,21C22.4,38.4,4.6,54.6,5.6,77.6c1.4,32.4,52.2,54,142.6,63.7 c66.2,7.1,212.2,7.5,273.5-8.3c64.4-16.6,104.3-57.6,33.8-98.2C386.7-4.9,179.4-1.4,126.3,20.7"></path></svg>',
			'circle2'       => '<svg id="circle2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="circle2" d="M29.7,117.9c43.4,27.7,151.8,30.4,226.1,28.1c120.4-3.8,242.5-24.6,241.6-60.9c-0.9-33-61.1-56.7-139.1-69.7C287.4,3.7,201.9,0.7,133,7.6C65.4,14.3,13.7,30.5,7.1,57c-12.9,59.8,74.8,73.3,183.5,77.6c90,3.6,164.9-3.1,251.4-21.7"></path></svg>',
			'diagonal'      => '<svg id="diagonal" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="diagonal" d="M13.5,15.5c131,13.7,289.3,55.5,475,125.5"></path></svg>',
			'double'        => '<svg id="double" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="doubleA" d="M8.4,143.1c14.2-8,97.6-8.8,200.6-9.2c122.3-0.4,287.5,7.2,287.5,7.2"></path><path class="doubleB" d="M8,19.4c72.3-5.3,162-7.8,216-7.8c54,0,136.2,0,267,7.8"></path></svg>',
			'doubleline'    => '<svg id="doubleline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="doublelineA" d="M5,125.4c30.5-3.8,137.9-7.6,177.3-7.6c117.2,0,252.2,4.7,312.7,7.6"></path><path class="doublelineB" d="M26.9,143.8c55.1-6.1,126-6.3,162.2-6.1c46.5,0.2,203.9,3.2,268.9,6.4"></path></svg>',
            'strikethrough' => '<svg id="strikethrough" xmlns="http://www.w3.org/2000/svg" viewBox="70 -70 220 150" preserveAspectRatio="none"><path className="strikethrough" d="M67.21521365836082 17.27089556060956 C121.57652005061789 12.01211611248977, 171.30955265118612 13.646444986358137, 280.4195833182171 13.328917559519123"></path></svg>',
            'zigzag'        => '<svg id="zigzag" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="zigzag" d="M6.7,111.6c0,0,487.1-6.7,488.2,7.4s-441.5-0.3-442.6,12.3c-1.1,12.6,296.4,5.6,309.9,16.6"></path></svg>',
			'zigzagline'    => '<svg id="zigzagline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="zigzagline" d="M3,146.8l22.1-18l20.9,18l22.1-18l21,18.1l21.9-18.1l20.9,18l22.1-18l21,18.1l22-18.1l20.9,18l22.1-18l21,18.1l21.9-18.1l20.9,18l22.1-18l21,18.1l21.8-18.1l20.9,18l22.1-18l21,18.1l21.9-18.1l20.9,18l22.1-18"></path></svg>',
			'wave1'         => '<svg id="wave1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 466.33 50.26"><path class="wave1" d="M0,40.46S116.21-9.15,131.26,9.53a6.89,6.89,0,0,1,1.3,5.28c-1.17,8.33-5.06,46.64,24.79,32.25,0,0,86.54-42.66,93.38-45.08,0,0,20.18-12,19.55,23.17a15.72,15.72,0,0,0,14.78,16.07c13.44.76,38.11-3.54,82.8-24.34,0,0,19-8.57,13.76,12.7a8.55,8.55,0,0,0,9.57,10.47c12.95-1.94,36.34-7.28,75.14-21.66"></path></svg>',
			'wave2'         => '<svg id="wave2" xmlns="http://www.w3.org/2000/svg" viewBox="0 50 500 80" preserveAspectRatio="none"><path class="wave2" d="M12.8,143.9c4.9-27.9,40.8-50.5,45.7-47s-1.3,46.8,20.8,45.2c6.2-0.4,25.7-45.2,34.6-33.7c18.9,24.5,44.3,29.5,50.1,29.3c51.4-2.2,29.8-31.1,78-19.5c83.4,20,223,19.5,247.9,13.3"></path></svg>',
			'spiral'        => '<svg id="spiral" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 430.38 67.12"><path class="spiral" d="M0,50.34s42-.2,51.8-34.16c9-31.13-62.37,5.62-12.62,42.42A31,31,0,0,0,88.29,39.52a71.59,71.59,0,0,0,1.13-14.69C88.6-21,29.72,70.55,103.51,67c0,0,25.16-2.33,33.33-46.43S66.37,70.33,146,66.42c0,0,19.42-.55,31.31-42,10-34.76-46,2.39-14.18,27.27,20.15,15.76,50.17,9.74,62.52-12.68a62.5,62.5,0,0,0,5.48-13.71c7.45-27.17-30.26-8.58-15.54,17.6,11.71,20.84,41.15,21.5,55.42,2.32a47.54,47.54,0,0,0,9.64-28.76c.11-33.22-38,39.48,1.09,44.6a31.7,31.7,0,0,0,18.79-3.62c11-5.82,30.24-19.6,32.22-45.73,2.3-30.22-39,4.93-17.08,26.71,14,13.94,38,10.31,47.58-7a42.23,42.23,0,0,0,5.08-18.55c1.39-26.53-35.11-3.51-11.12,25.88a20.43,20.43,0,0,0,34.41-4.09c2.54-5.34,4.4-12.51,4.89-22.14,2-39.37-54.24,26.19,2.09,40.83,0,0,27.71,6.33,31.8-5.86"></path></svg>',
			'brush'         => '<svg id="brush" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="brush" d="M4.2,59.2c28.5-2.3,493-3,493-3L2.4,98.1c0,0,469-2.8,492.5-4.3"></path></svg>',
			'splash'        => '<svg id="splash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 479.14 73.08"><path class="splash" d="M.53,23.05S-7,58,34.51,69C120.17,91.75,198.87,12,215.66,7c102.8-30.83,248.87,50.48,263.48,54.77"></path></svg>',
			'brickwall'     => '<svg id="brickwall" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 470.31 23.83"><path class="brickwall" d="M470.31,0V23.83l-58.82-1.21V0H356.72V23.23H293.47L292.74,0H230.22l.49,23.23H164.79L164.55,0H99V23.23H37.2L37.56,0H0V23.23"></path></svg>',
			'fluid'         => '<svg id="fluid" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="fluid" d="M494.4,94.5c7.6-16.8-45-90.9-96.7-87.8c-46.6,2.8-59.5,66.4-104.5,62.8c-31-2.5-34.5-33.5-64.9-34.1c-44.6-0.9-65.7,65.1-92.1,55.9c-23.7-8.3-14.5-64.3-41-77.7C66.2-1.1,8.8,43.1,10.6,78.5c1.9,37,69,73.7,126.1,66c55.6-7.5,63.8-51.9,111.9-49c51,3.1,69.9,54.8,104,41.5c29.9-11.6,30-57.2,57.1-59.1c18.6-1.3,27.4,19.4,60.3,21.3C480.9,99.9,491.7,100.5,494.4,94.5z"></path></svg>',
			'multiline'     => '<svg id="multiline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="multilineA" d="M3.7,125.7c50.5-3.7,442.9-7,487.5,4.7"></path><path class="multilineB" d="M488.6,133c-33.9-3-452.6-12-483.2-2.7"></path><path class="multilineC" d="M5.4,132.3c75.2,4.3,445.9-4,488.8-0.3"></path></svg>',
			'box'           => '<svg id="box" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="box" d="M7.1,6.6C5.7,21.9,2.7,123,5.7,142.7s474.9-12,488.8-1c3-19.3,3.3-128-1.7-137.3c-5-9.3-476.2,3-481.9,5"></path></svg>',
			'bracket'       => '<svg id="bracket" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="bracketA" d="M30.5,3.7c0,0-22.2,0.5-26.2,0.5"></path><path class="bracketB" d="M4.1,7.6c0,0-2,134.2-0.3,137.2s24.6,1.3,26.6,0.3"></path><path class="bracketC" d="M467.9,4.7c0,0,23.1-2.4,24.7,0.3c1.7,2.7,2.2,133.6,1.9,136.6"></path><path class="bracketD" d="M494.3,144.9c0,0-20.7,1-24,0"></path></svg>',
			'bracket2'      => '<svg id="bracket2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="bracket2A" d="M494.3,31.2c0,0-1.7-22.2-1.7-26.2"></path><path class="bracket2B" d="M485,5.4c0,0-466.2-6.2-475.3-1C4,7.6,4.6,26.9,6.6,30.7"></path><path class="bracket2C" d="M489.7,118.6c0,0,4.4,21.6-0.9,23.1c-9.3,1.7-463.8,2.4-474.2,2.1"></path><path class="bracket2D" d="M7.2,144.7c0,0-1-19.1,0.1-24"></path></svg>',
		);

		if ( empty( $this->props['highlighter_type'] ) ) {
			return $highlighter_svg['line'];
		}

		return $highlighter_svg[ $this->props['highlighter_type'] ];
	}

	public function render( $attrs, $content, $render_slug ) {
		$this->handle_fa_icon();
		wp_enqueue_script( 'df-vivus-svg' );
		wp_enqueue_script( 'df-text-highlighter' );

		$heading_classes  = '';
		$dual_text_title  = '';
		$divider_position = '' !== $this->props['divider_position'] ?
			$this->props['divider_position'] : 'bottom';
		// $title_level  = $this->props['title_level'];
		$title_level  = $this->props['title_tag'];
		$title_prefix = ! empty( $this->props['title_prefix'] ) ?
			sprintf( '<span class="prefix">%1$s</span>', $this->props['title_prefix'] ) : '';

		$title_infix = ! empty( $this->props['title_infix'] ) ?
			sprintf(
				'<span class="infix df-text-highlight">%1$s %2$s</span>',
				$this->props['title_infix'],
				$this->highlighter_svg()// $highlighter_svg
			) : '';

			$title_suffix = ! empty( $this->props['title_suffix'] ) ?
			sprintf( '<span class="suffix">%1$s</span>', $this->props['title_suffix'] ) : '';

		$title = sprintf( '%1$s %2$s %3$s', $title_prefix, $title_infix, $title_suffix );

		$this->additional_css_styles( $render_slug );

		if ( $this->props['use_dual_text'] === 'on' ) {
			$dual_title = sprintf( '%1$s %2$s %3$s', $this->props['title_prefix'], $this->props['title_infix'], $this->props['title_suffix'] );

			if ( $this->props['use_dual_text_custom'] !== 'on' ) {
				$dual_text_title = sprintf(
					'<div class="df-heading-dual_text" data-title="%1$s"></div>',
					wp_strip_all_tags( trim( $dual_title ) )
				);
			} else {
				$dual_text_title = sprintf(
					'<div class="df-heading-dual_text" data-title="%1$s"></div>',
					wp_strip_all_tags( $this->props['custom_text_input'] )
				);
			}

			$heading_classes .= ' has-dual-text';
		}

		$data = array(
			'animation'          => $this->props['enable_animation'],
			'animationStart'     => $this->props['anim_start'],
			'viewportPosition'   => $this->props['anim_start_viewport'],
			'type'               => $this->props['highlighter_type'],
			'animTimingFunction' => $this->props['anim_easing'],
			'duration'           => (float) $this->props['anim_duration'],
			'delay'              => (float) $this->props['anim_delay'],
			'loop'               => $this->props['enable_loop'],
			'iteration'          => (int) $this->props['anim_iteration'],
			'iterationGap'       => (int) $this->props['anim_iteration_gap'],
		);

		$data_svg = array(
			'isGradient'              => $this->props['enable_gradient_color'],
			'colorStart'              => $this->props['gradient_color_start'],
			'colorEnd'                => $this->props['gradient_color_end'],
			'gradientType'            => $this->props['gradient_type'],
			'gradientDirection'       => $this->props['gradient_direction'],
			'gradientDirectionRadial' => $this->props['gradient_direction_radial'],
			'startPosition'           => $this->props['gradient_start_position'],
			'endPosition'             => $this->props['gradient_end_position'],
		);

		return sprintf(
			'<div class="df-texthighlighter-container %6$s active" data-svg=\'%8$s\' data-settings=\'%7$s\'>
                %3$s
                %5$s
                <%2$s class="df-heading">%1$s</%2$s>
                %4$s
            </div>',
			/**1*/ $title,
			/**2*/ et_pb_process_header_level( $title_level, 'h3' ),
			/**3*/ $this->render_divider( 'top', $divider_position ),
			/**4*/ $this->render_divider( 'bottom', $divider_position ),
			/**5*/ $dual_text_title,
			/**6*/ $heading_classes,
			/**7*/ wp_json_encode( $data ),
			/**8*/ wp_json_encode( $data_svg )
		);
	}
}
new DIFL_TextHighlighter();
