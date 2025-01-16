<?php

	/**
	 * Icon List Module Class which extend the Divi Builder Module Class.
	 *
	 * This class provide listed icon element functionalities in frontend.
	 *
	 */
	class DIFL_IconList extends ET_Builder_Module
	{
		public $slug       = 'difl_iconlist';
		public $vb_support = 'on';
		public $child_slug = 'difl_iconlistitem';
		use DF_UTLS;

		protected $module_credits
			                           = array(
				'module_uri' => '',
				'author'     => 'DiviFlash',
				'author_uri' => ''
			);
		private   $tooltip_css_element = '';

		public function init()
		{
			$this->name      = esc_html__( 'Advanced List', 'divi_flash' );
			$this->plural    = esc_html__( 'Advanced Lists', 'divi_flash' );
			$this->icon_path = DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/icon-list.svg';

			$this->main_css_element    = '%%order_class%%.difl_iconlist';
			$this->tooltip_css_element = ".tippy-box[data-theme~='difl_icon_item_tooltip']";
		}

		/**
		 * Return add new item(module) text.
		 *
		 * @return string
		 */
		public function add_new_child_text()
		{
			return esc_html__( 'Add New List Item', 'divi_flash' );
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
				'general'  => array(
					'toggles' => array(
						'list_settings' => esc_html__( 'Settings', 'divi_flash' )
					)
				),
				'advanced' => array(
					'toggles' => array(
						'child_wrapper_element' => esc_html__( 'Item Wrapper Styles', 'divi_flash' ),
						'child_image_icon'      => esc_html__( 'Icon Styles', 'divi_flash' ),
						'child_icon_text'       => esc_html__( 'Icon Text', 'divi_flash' ),
						'child_lottie_element'  => esc_html__( 'Icon Lottie Styles', 'divi_flash' ),
						'child_title_element'   => esc_html__( 'Title Styles', 'divi_flash' ),
						'child_title_text'      => esc_html__( 'Title Text', 'divi_flash' ),
						'child_content_element' => esc_html__( 'Body Styles', 'divi_flash' ),
						'child_content_text'    => array(
							'title'             => esc_html__( 'Body Text', 'divi_flash' ),
							'tabbed_subtoggles' => true,
							'sub_toggles'       => $content_sub_toggles,
						),
						'child_content_heading' => array(
							'title'             => esc_html__( 'Body Heading Text', 'divi_flash' ),
							'tabbed_subtoggles' => true,
							'sub_toggles'       => $heading_sub_toggles,
						),
						'child_tooltip_element' => esc_html__( 'Tooltip Styles', 'divi_flash' ),
						'child_tooltip_text'    => array(
							'title'             => esc_html__( 'Tooltip Text', 'divi_flash' ),
							'tabbed_subtoggles' => true,
							'sub_toggles'       => $content_sub_toggles,
						),
						'child_tooltip_heading' => array(
							'title'             => esc_html__( 'Tooltip Heading Text', 'divi_flash' ),
							'tabbed_subtoggles' => true,
							'sub_toggles'       => $heading_sub_toggles,
						),
						'custom_spacing'        => array(
							'title'    => esc_html__( 'Custom Spacing', 'divi_flash' ),
							'priority' => 85
						)
					)
				)
			);
		}

		public function get_fields()
		{
			$et_accent_color = et_builder_accent_color();

			$child_image_icon_placement = array(
				'column'      => et_builder_i18n( 'Top' ),
				'row'         => et_builder_i18n( 'Left' ),
				'row-reverse' => et_builder_i18n( 'Right' ),
			);

			$child_default_placement = 'row';

			if ( is_rtl() ) {
				$child_default_placement = 'row-reverse';
			}

			$icon_list_settings = array(
				'list_view_type'                 => array(
					'label'            => esc_html__( 'Layout Type', 'divi_flash' ),
					'description'      => esc_html__( 'Here you can choose icon list layout type.', 'divi_flash' ),
					'type'             => 'select',
					'option_category'  => 'layout',
					'options'          => array(
						'list'   => esc_html__( 'List', 'divi_flash' ),
						'inline' => esc_html__( 'Grid', 'divi_flash' ),
					),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'list_settings',
					'default_on_front' => 'list',
					'mobile_options'   => true,
				),
				'list_item_per_column'           => array(
					'label'             => esc_html__( 'Layout Columns', 'divi_flash' ),
					'description'       => esc_html__( 'Here you can choose icon item per column.', 'divi_flash' ),
					'type'              => 'range',
					'range_settings'    => array(
						'min'  => '1',
						'max'  => '6',
						'step' => '1',
					),
					'number_validation' => true,
					'fixed_range'       => true,
					'validate_unit'     => true,
					'allowed_units'     => array( '' ),
					'option_category'   => 'layout',
					'tab_slug'          => 'general',
					'toggle_slug'       => 'list_settings',
					'default_on_front'  => '2',
					'show_if'           => array(
						'list_view_type' => 'inline',
					),
					'mobile_options'    => true,
				),
				'list_item_gap'                  => array(
					'label'            => esc_html__( 'Item Gap', 'divi_flash' ),
					'description'      => esc_html__( 'Here you can choose icon item gap.', 'divi_flash' ),
					'type'             => 'range',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '100',
						'step' => '1',
					),
					'validate_unit'    => true,
					'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'option_category'  => 'layout',
					'tab_slug'         => 'general',
					'toggle_slug'      => 'list_settings',
					'default_on_front' => '10px',
					'mobile_options'   => true,
				),
				'list_item_horizontal_alignment' => array(
					'label'       => esc_html__( 'Item Horizontal Alignment', 'divi_flash' ),
					'description' => esc_html__( 'Here you can choose horizontal alignment for item.', 'divi_flash' ),
					'type'        => 'select',
					'options'     => array(
						'flex-start' => et_builder_i18n( 'Left' ),
						'center'     => et_builder_i18n( 'Center' ),
						'flex-end'   => et_builder_i18n( 'Right' )
					),
					'tab_slug'    => 'general',
					'toggle_slug' => 'list_settings'
				),
				'list_item_equal_width'          => array(
					'label'            => esc_html__( 'Apply item equal width', 'divi_flash' ),
					'description'      => esc_html__(
						'Here you can choose whether or not item is equal width.',
						'divi_flash'
					),
					'type'             => 'yes_no_button',
					'option_category'  => 'configuration',
					'options'          => array(
						'off' => esc_html__( 'No', 'divi_flash' ),
						'on'  => esc_html__( 'Yes', 'divi_flash' )
					),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'list_settings',
					'default_on_front' => 'off',
				),
				'list_item_vertical_alignment'   => array(
					'label'           => esc_html__( 'Item Vertical Alignment', 'divi_flash' ),
					'description'     => esc_html__( 'Here you can choose vertical alignment for item.', 'divi_flash' ),
					'type'            => 'select',
					'option_category' => 'layout',
					'options'         => array(
						'flex-start' => esc_html__( 'Top', 'divi_flash' ),
						'center'     => esc_html__( 'Center', 'divi_flash' ),
						'flex-end'   => esc_html__( 'Bottom', 'divi_flash' )
					),
					'tab_slug'        => 'general',
					'toggle_slug'     => 'list_settings',
					'default'         => 'flex-start',
					'show_if'         => array(
						'list_view_type' => 'inline'
					)
				),
				'list_item_elements_align'       => array(
					'label'            => esc_html__( 'Apply vertical alignment for elements', 'divi_flash' ),
					'description'      => esc_html__(
						'Here you can choose whether or not vertical alignment for elements.',
						'divi_flash'
					),
					'type'             => 'yes_no_button',
					'option_category'  => 'configuration',
					'options'          => array(
						'off' => esc_html__( 'No', 'divi_flash' ),
						'on'  => esc_html__( 'Yes', 'divi_flash' )
					),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'list_settings',
					'default_on_front' => 'off',
					'show_if'          => array(
						'list_view_type' => 'inline'
					)
				),
			);

			$title_background = $this->df_add_bg_field(
				array(
					'label'       => esc_html__( 'Title Background', 'divi_flash' ),
					'key'         => 'list_item_title_background',
					'toggle_slug' => 'child_title_element',
					'tab_slug'    => 'advanced'
				)
			);

			$content_background = $this->df_add_bg_field(
				array(
					'label'       => esc_html__( 'Body Background', 'divi_flash' ),
					'key'         => 'list_item_content_background',
					'toggle_slug' => 'child_content_element',
					'tab_slug'    => 'advanced'
				)
			);

			$wrapper_background = $this->df_add_bg_field(
				array(
					'label'       => esc_html__( 'Wrapper Background', 'divi_flash' ),
					'key'         => 'list_item_wrapper_background',
					'toggle_slug' => 'child_wrapper_element',
					'tab_slug'    => 'advanced'
				)
			);

			$tooltip_background = $this->df_add_bg_field(
				array(
					'label'       => esc_html__( 'Tooltip Background', 'divi_flash' ),
					'key'         => 'list_item_tooltip_background',
					'toggle_slug' => 'child_tooltip_element',
					'tab_slug'    => 'advanced'
				)
			);

			$text_associated_fields       = array(
				'list_item_text_orientation'  => array(
					'label'           => esc_html__( 'Text Alignment', 'et_builder' ),
					'description'     => esc_html__(
						'This controls how your text is aligned within the module.',
						'et_builder'
					),
					'type'            => 'text_align',
					'option_category' => 'layout',
					'options'         => et_builder_get_text_orientation_options(
						array( 'justified' ),
						array( 'justify' => 'Justified' )
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'child_wrapper_element',
					'advanced_fields' => true,
					'default'         => 'left',
					'mobile_options'  => true,
				),
				'list_item_content_max_width' => array(
					'label'            => esc_html__( 'Item Content Width', 'divi_flash' ),
					'description'      => esc_html__(
						'Adjust the width of the content within the icon item.',
						'divi_flash'
					),
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'width',
					'type'             => 'range',
					'range_settings'   => array(
						'min'  => '0',
						'max'  => '1100',
						'step' => '1',
					),
					'allowed_values'   => et_builder_get_acceptable_css_string_values( 'max-width' ),
					'default_unit'     => 'px',
					'default'          => '550px',
					'default_on_front' => '550px',
					'default_tablet'   => 'none',
					'hover'            => 'tabs',
					'responsive'       => true,
					'mobile_options'   => true,
				),
			);
			$icon_image_associated_fields = array(
				'list_item_icon_color'              => array(
					'label'           => esc_html__( 'Icon Color', 'divi_flash' ),
					'description'     => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
					'type'            => 'color-alpha',
					'toggle_slug'     => 'child_image_icon',
					'tab_slug'        => 'advanced',
					'default'         => $et_accent_color,
					'hover'           => 'tabs',
					'depends_show_if' => 'on',
				),
				'list_item_icon_bg_color'           => array(
					'label'       => esc_html__( 'Icon Background Color', 'divi_flash' ),
					'description' => esc_html__( 'Here you can define a custom background color.', 'divi_flash' ),
					'type'        => 'color-alpha',
					'toggle_slug' => 'child_image_icon',
					'tab_slug'    => 'advanced',
					'hover'       => 'tabs',
				),
				'list_item_icon_size'               => array(
					'label'          => esc_html__( 'Icon Size', 'divi_flash' ),
					'description'    => esc_html__( 'Here you can choose icon size.', 'divi_flash' ),
					'type'           => 'range',
					'range_settings' => array(
						'min'  => '1',
						'max'  => '200',
						'step' => '1',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'child_image_icon',
					'default'        => '40px',
					'hover'          => 'tabs',
					'responsive'     => true,
					'mobile_options' => true,
				),
				'list_item_image_width'             => array(
					'label'          => esc_html__( 'Image Width', 'divi_flash' ),
					'description'    => esc_html__( 'Here you can choose image width.', 'divi_flash' ),
					'type'           => 'range',
					'range_settings' => array(
						'min'  => '1',
						'max'  => '200',
						'step' => '1',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'child_image_icon',
					'default'        => '40px',
					'hover'          => 'tabs',
					'mobile_options' => true,
				),
				'list_item_image_height'            => array(
					'label'          => esc_html__( 'Image Height', 'divi_flash' ),
					'description'    => esc_html__( 'Here you can choose image height.', 'divi_flash' ),
					'type'           => 'range',
					'range_settings' => array(
						'min'  => '1',
						'max'  => '200',
						'step' => '1',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'child_image_icon',
					'default'        => '40px',
					'hover'          => 'tabs',
					'mobile_options' => true,
				),
				'list_item_icon_text_gap'           => array(
					'label'          => esc_html__( 'Gap Between Icon and Text', 'divi_flash' ),
					'description'    => esc_html__( 'Here you can choose gap between icon and text.', 'divi_flash' ),
					'type'           => 'range',
					'range_settings' => array(
						'min'  => '1',
						'max'  => '200',
						'step' => '1',
					),
					'allowed_values' => et_builder_get_acceptable_css_string_values( 'max-width' ),
					'allow_empty'    => true,
					'allowed_units'  => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'validate_unit'  => true,
					'default_unit'   => 'px',
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'child_image_icon',
					'default'        => '10px',
					'mobile_options' => true,
				),
				'list_item_icon_placement'          => array(
					'label'            => esc_html__( 'Icon Placement', 'divi_flash' ),
					'description'      => esc_html__( 'Here you can choose where to place the icon.', 'divi_flash' ),
					'type'             => 'select',
					'option_category'  => 'layout',
					'options'          => $child_image_icon_placement,
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'child_image_icon',
					'default_on_front' => $child_default_placement,
					'mobile_options'   => true,
				),
				'list_item_icon_alignment'          => array(
					'label'           => esc_html__( 'Icon Alignment', 'divi_flash' ),
					'description'     => esc_html__( 'Align icon to the left, right or center.', 'divi_flash' ),
					'type'            => 'align',
					'option_category' => 'layout',
					'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'child_image_icon',
					'default'         => 'left',
					'mobile_options'  => true,
					'show_if'         => array(
						'list_item_icon_placement' => 'column',
					),
				),
				'list_item_icon_vertical_placement' => array(
					'label'            => esc_html__( 'Vertical Placement', 'divi_flash' ),
					'description'      => esc_html__( 'Here you can choose where to place the icon.', 'et_builder' ),
					'type'             => 'select',
					'option_category'  => 'layout',
					'options'          => array(
						'flex-start' => et_builder_i18n( 'Top' ),
						'center'     => et_builder_i18n( 'Center' ),
						'flex-end'   => et_builder_i18n( 'bottom' )
					),
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'child_image_icon',
					'default_on_front' => 'flex-start',
					'show_if'          => array(
						'list_item_icon_placement' => array( 'row', 'row-reverse' )
					),
					'mobile_options'   => true
				),
			);
			$lottie_associated_fields     = array(
				'list_item_icon_lottie_color'            => array(
					'label'       => esc_html__( 'Lottie Color', 'divi_flash' ),
					'description' => esc_html__( 'Here you can define a custom color for lottie image.', 'divi_flash' ),
					'type'        => 'color-alpha',
					'toggle_slug' => 'child_lottie_element',
					'tab_slug'    => 'advanced',
					'hover'       => 'tabs',
				),
				'list_item_icon_lottie_background_color' => array(
					'label'       => esc_html__( 'Lottie Background Color', 'divi_flash' ),
					'description' => esc_html__(
						'Here you can define a custom background color for lottie image.',
						'divi_flash'
					),
					'type'        => 'color-alpha',
					'toggle_slug' => 'child_lottie_element',
					'tab_slug'    => 'advanced',
					'hover'       => 'tabs',
				),
				'list_item_icon_lottie_width'            => array(
					'label'            => esc_html__( 'Lottie Width', 'divi_flash' ),
					'description'      => esc_html__( 'Here you can choose lottie width.', 'divi_flash' ),
					'type'             => 'range',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '200',
						'step' => '1',
					),
					'option_category'  => 'layout',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'child_lottie_element',
					'validate_unit'    => true,
					'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'default_on_front' => '40px',
					'responsive'       => true,
					'mobile_options'   => true,
					'sticky'           => true,
				),
				'list_item_icon_lottie_height'           => array(
					'label'            => esc_html__( 'Lottie Height', 'divi_flash' ),
					'description'      => esc_html__( 'Here you can choose lottie height.', 'divi_flash' ),
					'type'             => 'range',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '200',
						'step' => '1',
					),
					'option_category'  => 'layout',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'child_lottie_element',
					'default_on_front' => '40px',
					'validate_unit'    => true,
					'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				)
			);
			$tooltips_associated_fields   = array(
				'tooltip_arrow_color' => array(
					'label'       => esc_html__( 'Tooltip Arrow Color', 'divi_flash' ),
					'description' => esc_html__(
						'Here you can define a custom color for your tooltip arrow.',
						'divi_flash'
					),
					'type'        => 'color-alpha',
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'child_tooltip_element',
					'hover'       => 'tabs'
				)
			);
			$custom_margin_padding_fields = array(
				'list_item_icon_margin'          => array(
					'label'           => esc_html__( 'Icon Margin', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can define a custom padding size for the icon wrapper.',
						'divi_flash'
					),
					'type'            => 'custom_margin',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'custom_spacing',
					'default_unit'    => 'px',
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '50',
						'step' => '1',
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'responsive'     => true,
					'sticky'         => true,
				),
				'list_item_icon_padding'         => array(
					'label'           => esc_html__( 'Icon Padding', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can define a custom padding size for the icon wrapper.',
						'divi_flash'
					),
					'type'            => 'custom_padding',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'custom_spacing',
					'default_unit'    => 'px',
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '50',
						'step' => '1',
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'responsive'     => true,
					'sticky'         => true,
				),
				'list_item_icon_wrapper_margin'  => array(
					'label'           => esc_html__( 'Icon Wrapper Margin', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can define a custom padding size for the icon wrapper.',
						'divi_flash'
					),
					'type'            => 'custom_margin',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'custom_spacing',
					'default_unit'    => 'px',
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '50',
						'step' => '1',
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'responsive'     => true,
					'sticky'         => true,
				),
				'list_item_icon_wrapper_padding' => array(
					'label'           => esc_html__( 'Icon Wrapper Padding', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can define a custom padding size for the icon wrapper.',
						'divi_flash'
					),
					'type'            => 'custom_padding',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'custom_spacing',
					'default_unit'    => 'px',
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '50',
						'step' => '1',
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'responsive'     => true,
					'sticky'         => true,
				),
				'list_item_title_margin'         => array(
					'label'           => esc_html__( 'Item Title Margin', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can define a custom padding size for the title.',
						'divi_flash'
					),
					'type'            => 'custom_margin',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'custom_spacing',
					'default_unit'    => 'px',
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '50',
						'step' => '1',
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'responsive'     => true,
					'sticky'         => true,
				),
				'list_item_title_padding'        => array(
					'label'           => esc_html__( 'Item Title Padding', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can define a custom padding size for the title.',
						'divi_flash'
					),
					'type'            => 'custom_padding',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'custom_spacing',
					'default_unit'    => 'px',
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '50',
						'step' => '1',
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'responsive'     => true,
					'sticky'         => true,
				),
				'list_item_content_margin'       => array(
					'label'           => esc_html__( 'Item Body Margin', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can define a custom padding size for the content.',
						'divi_flash'
					),
					'type'            => 'custom_margin',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'custom_spacing',
					'default_unit'    => 'px',
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '50',
						'step' => '1',
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'responsive'     => true,
					'sticky'         => true,
				),
				'list_item_content_padding'      => array(
					'label'           => esc_html__( 'Item Body Padding', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can define a custom padding size for the content.',
						'divi_flash'
					),
					'type'            => 'custom_padding',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'custom_spacing',
					'default_unit'    => 'px',
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '50',
						'step' => '1',
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'responsive'     => true,
					'sticky'         => true,
				),
				'list_item_wrapper_margin'       => array(
					'label'           => esc_html__( 'Item Wrapper Margin', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can define a custom padding size for the wrapper.',
						'divi_flash'
					),
					'type'            => 'custom_margin',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'custom_spacing',
					'default_unit'    => 'px',
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '50',
						'step' => '1',
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'responsive'     => true,
					'sticky'         => true,
				),
				'list_item_wrapper_padding'      => array(
					'label'           => esc_html__( 'Item Wrapper Padding', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can define a custom padding size for the wrapper.',
						'divi_flash'
					),
					'type'            => 'custom_padding',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'custom_spacing',
					'default_unit'    => 'px',
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '50',
						'step' => '1',
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'responsive'     => true,
					'sticky'         => true,
				),
				'list_item_tooltip_padding'      => array(
					'label'           => esc_html__( 'Item Tooltip Padding', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can define a custom padding size for the tooltip.',
						'divi_flash'
					),
					'type'            => 'custom_padding',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'custom_spacing',
					'default_unit'    => 'px',
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '50',
						'step' => '1',
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'responsive'     => true,
					'sticky'         => true,
				)
			);

			return array_merge(
				$icon_list_settings,
				$title_background,
				$content_background,
				$wrapper_background,
				$tooltip_background,
				$text_associated_fields,
				$icon_image_associated_fields,
				$lottie_associated_fields,
				$tooltips_associated_fields,
				$custom_margin_padding_fields
			);
		}

		public function get_advanced_fields_config() {
			$advanced_fields = array();

			// Font styles for Icon Heading and Body Content
			$advanced_fields['fonts']['child_icon_text']  = array(
				'label'       => esc_html__( 'Icon', 'divi_flash' ),
				'font_size'   => array(
					'default' => '16px'
				),
				'font_weight' => array(
					'default' => '500'
				),
				'line_height' => array(
					'default' => '1.7'
				),
				'css'         => array(
					'main'  => implode( ', ', array(
						"$this->main_css_element .item-elements .difl_list_icon_text",
						"$this->main_css_element .item-elements .difl_list_icon_text a"
					) ),
					'hover' => implode( ', ', array(
						"$this->main_css_element .item-elements:hover .difl_list_icon_text",
						"$this->main_css_element .item-elements:hover .difl_list_icon_text a"
					) )
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_icon_text',
			);
			$advanced_fields['fonts']['child_title_text'] = array(
				'label'       => esc_html__( 'Title', 'divi_flash' ),
				'font_size'   => array(
					'default' => '18px'
				),
				'font_weight' => array(
					'default' => '500'
				),
				'line_height' => array(
					'default' => '1.7'
				),
				'css'         => array(
					'main'  => implode( ', ', array(
						"$this->main_css_element .item-elements .difl_icon_item_header",
						"$this->main_css_element .item-elements .difl_icon_item_header a"
					) ),
					'hover' => implode( ', ', array(
						"$this->main_css_element .item-elements:hover .difl_icon_item_header",
						"$this->main_css_element .item-elements:hover .difl_icon_item_header a"
					) )
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_title_text',
			);

			// Body text
			$advanced_fields['fonts']['child_content_text'] = array(
				'label'          => esc_html__( 'Body', 'divi_flash' ),
				'line_height'    => array(
					'default' => '1.7',
				),
				'font_weight'    => array(
					'default' => '400',
				),
				'css'            => array(
					'main'  => implode( ', ', array(
						"$this->main_css_element .item-elements .difl_icon_item_body",
						"$this->main_css_element .item-elements .difl_icon_item_body p"
					) ),
					'hover' => implode( ', ', array(
						"$this->main_css_element .item-elements:hover .difl_icon_item_body",
						"$this->main_css_element .item-elements:hover .difl_icon_item_body p"
					) )
				),
				'block_elements' => array(
					'tabbed_subtoggles' => true,
					'bb_icons_support'  => true,
					'css'               => array(
						'main'  => "$this->main_css_element .item-elements .difl_icon_item_body",
						'hover' => "$this->main_css_element .item-elements:hover .difl_icon_item_body",
					),
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'child_content_text',
			);
			$advanced_fields['fonts']['content_heading_1']  = array(
				'label'       => esc_html__( 'Heading 1', 'divi_flash' ),
				'font_size'   => array(
					'default' => absint( et_get_option( 'body_header_size', '30' ) ) . 'px',
				),
				'font_weight' => array(
					'default' => '500',
				),
				'line_height' => array(
					'default' => '1.7',
				),
				'css'         => array(
					'main'  => "$this->main_css_element .item-elements .difl_icon_item_body h1",
					'hover' => "$this->main_css_element .item-elements:hover .difl_icon_item_body h1"
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_content_heading',
				'sub_toggle'  => 'h1',
			);
			$advanced_fields['fonts']['content_heading_2']  = array(
				'label'       => esc_html__( 'Heading 2', 'divi_flash' ),
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
					'main'  => "$this->main_css_element .item-elements .difl_icon_item_body h2",
					'hover' => "$this->main_css_element .item-elements:hover .difl_icon_item_body h2"
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_content_heading',
				'sub_toggle'  => 'h2',
			);
			$advanced_fields['fonts']['content_heading_3']  = array(
				'label'       => esc_html__( 'Heading 3', 'divi_flash' ),
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
					'main'  => "$this->main_css_element .item-elements .difl_icon_item_body h3",
					'hover' => "$this->main_css_element .item-elements:hover .difl_icon_item_body h3"
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_content_heading',
				'sub_toggle'  => 'h3',
			);
			$advanced_fields['fonts']['content_heading_4']  = array(
				'label'       => esc_html__( 'Heading 4', 'divi_flash' ),
				'font_size'   => array(
					'default' => '18px'
				),
				'font_weight' => array(
					'default' => '500'
				),
				'line_height' => array(
					'default' => '1.7'
				),
				'css'         => array(
					'main'  => "$this->main_css_element .item-elements .difl_icon_item_body h4",
					'hover' => "$this->main_css_element .item-elements:hover .difl_icon_item_body h4"
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_content_heading',
				'sub_toggle'  => 'h4',
			);
			$advanced_fields['fonts']['content_heading_5']  = array(
				'label'       => esc_html__( 'Heading 5', 'divi_flash' ),
				'font_size'   => array(
					'default' => '16px',
				),
				'font_weight' => array(
					'default' => '500'
				),
				'line_height' => array(
					'default' => '1.7'
				),
				'css'         => array(
					'main'  => "$this->main_css_element .item-elements .difl_icon_item_body h5",
					'hover' => "$this->main_css_element .item-elements:hover .difl_icon_item_body h5"
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_content_heading',
				'sub_toggle'  => 'h5',
			);
			$advanced_fields['fonts']['content_heading_6']  = array(
				'label'       => esc_html__( 'Heading 6', 'divi_flash' ),
				'font_size'   => array(
					'default' => '14px',
				),
				'font_weight' => array(
					'default' => '500'
				),
				'line_height' => array(
					'default' => '1.7'
				),
				'css'         => array(
					'main'  => "$this->main_css_element .item-elements .difl_icon_item_body h6",
					'hover' => "$this->main_css_element .item-elements:hover .difl_icon_item_body h6"
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_content_heading',
				'sub_toggle'  => 'h6',
			);


			// Tooltip text
			$advanced_fields['fonts']['child_tooltip_text'] = array(
				'label'          => esc_html__( 'Tooltip', 'divi_flash' ),
				'line_height'    => array(
					'default' => '1.7',
				),
				'font_weight'    => array(
					'default' => '400',
				),
				'css'            => array(
					'main'  => $this->tooltip_css_element,
					'hover' => "$this->tooltip_css_element:hover"
				),
				'block_elements' => array(
					'tabbed_subtoggles' => true,
					'bb_icons_support'  => true,
					'css'               => array(
						'main'  => $this->tooltip_css_element,
						'hover' => "$this->tooltip_css_element:hover",
					),
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'child_tooltip_text',
			);
			$advanced_fields['fonts']['tooltip_heading_1']  = array(
				'label'       => esc_html__( 'Heading 1', 'divi_flash' ),
				'font_size'   => array(
					'default' => absint( et_get_option( 'body_header_size', '30' ) ) . 'px',
				),
				'font_weight' => array(
					'default' => '500',
				),
				'line_height' => array(
					'default' => '1.7',
				),
				'css'         => array(
					'main'  => "$this->tooltip_css_element h1",
					'hover' => "$this->tooltip_css_element:hover h1"
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_tooltip_heading',
				'sub_toggle'  => 'h1',
			);
			$advanced_fields['fonts']['tooltip_heading_2']  = array(
				'label'       => esc_html__( 'Heading 2', 'divi_flash' ),
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
					'main'  => "$this->tooltip_css_element h2",
					'hover' => "$this->tooltip_css_element:hover h2"
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_tooltip_heading',
				'sub_toggle'  => 'h2',
			);
			$advanced_fields['fonts']['tooltip_heading_3']  = array(
				'label'       => esc_html__( 'Heading 3', 'divi_flash' ),
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
					'main'  => "$this->tooltip_css_element h3",
					'hover' => "$this->tooltip_css_element:hover h3"
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_tooltip_heading',
				'sub_toggle'  => 'h3',
			);
			$advanced_fields['fonts']['tooltip_heading_4']  = array(
				'label'       => esc_html__( 'Heading 4', 'divi_flash' ),
				'font_size'   => array(
					'default' => '18px'
				),
				'font_weight' => array(
					'default' => '500'
				),
				'line_height' => array(
					'default' => '1.7'
				),
				'css'         => array(
					'main'  => "$this->tooltip_css_element h4",
					'hover' => "$this->tooltip_css_element:hover h4"
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_tooltip_heading',
				'sub_toggle'  => 'h4',
			);
			$advanced_fields['fonts']['tooltip_heading_5']  = array(
				'label'       => esc_html__( 'Heading 5', 'divi_flash' ),
				'font_size'   => array(
					'default' => '16px',
				),
				'font_weight' => array(
					'default' => '500'
				),
				'line_height' => array(
					'default' => '1.7'
				),
				'css'         => array(
					'main'  => "$this->tooltip_css_element h5",
					'hover' => "$this->tooltip_css_element:hover h5"
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_tooltip_heading',
				'sub_toggle'  => 'h5',
			);
			$advanced_fields['fonts']['tooltip_heading_6']  = array(
				'label'       => esc_html__( 'Heading 6', 'divi_flash' ),
				'font_size'   => array(
					'default' => '14px',
				),
				'font_weight' => array(
					'default' => '500'
				),
				'line_height' => array(
					'default' => '1.7'
				),
				'css'         => array(
					'main'  => "$this->tooltip_css_element h6",
					'hover' => "$this->main_css_element:hover h6"
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_tooltip_heading',
				'sub_toggle'  => 'h6',
			);

			// Background styles for Icon item
			$advanced_fields['background'] = array(
				'settings' => array(
					'color' => 'alpha',
				),
				'css'      => array(
					'main'  => $this->main_css_element,
					'hover' => "$this->main_css_element:hover",
				),
			);

			// Default styles for image and icon
			$advanced_fields['child_image_icon'] = array(
				'css' => array(
					'main' => "$this->main_css_element .item-elements .icon-element",
				),
			);

			// Borders styles for Icon image and default
			$advanced_fields['borders']['default']               = array();
			$advanced_fields['borders']['child_image_icon']      = array(
				'label_prefix' => et_builder_i18n( 'Icon' ),
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'child_image_icon',
				'css'          => array(
					'main' => array(
						'border_radii'        => "$this->main_css_element .item-elements .icon-element",
						'border_radii_hover'  => "$this->main_css_element .item-elements:hover .icon-element",
						'border_styles'       => "$this->main_css_element .item-elements .icon-element",
						'border_styles_hover' => "$this->main_css_element .item-elements:hover .icon-element",
					),
				),
			);
			$advanced_fields['borders']['child_title_element']   = array(
				'label_prefix' => et_builder_i18n( 'Title' ),
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'child_title_element',
				'css'          => array(
					'main' => array(
						'border_radii'        => "$this->main_css_element .item-elements .difl_icon_item_header",
						'border_radii_hover'  => "$this->main_css_element .item-elements:hover .difl_icon_item_header",
						'border_styles'       => "$this->main_css_element .item-elements .difl_icon_item_header",
						'border_styles_hover' => "$this->main_css_element .item-elements:hover .difl_icon_item_header",
					),
				),
			);
			$advanced_fields['borders']['child_content_element'] = array(
				'label_prefix' => et_builder_i18n( 'Body' ),
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'child_content_element',
				'css'          => array(
					'main' => array(
						'border_radii'        => "$this->main_css_element .item-elements .difl_icon_item_body",
						'border_radii_hover'  => "$this->main_css_element .item-elements:hover .difl_icon_item_body",
						'border_styles'       => "$this->main_css_element .item-elements .difl_icon_item_body",
						'border_styles_hover' => "$this->main_css_element .item-elements:hover .difl_icon_item_body",
					),
				),
			);
			$advanced_fields['borders']['child_wrapper_element'] = array(
				'label_prefix' => et_builder_i18n( 'Wrapper' ),
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'child_wrapper_element',
				'css'          => array(
					'main' => array(
						'border_radii'        => "$this->main_css_element .item-elements",
						'border_radii_hover'  => "$this->main_css_element .item-elements:hover",
						'border_styles'       => "$this->main_css_element .item-elements",
						'border_styles_hover' => "$this->main_css_element .item-elements:hover",
					),
				),
			);
			$advanced_fields['borders']['child_tooltip_element'] = array(
				'label_prefix' => et_builder_i18n( 'Tooltip' ),
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'child_tooltip_element',
				'css'          => array(
					'main' => array(
						'border_radii'        => $this->tooltip_css_element,
						'border_radii_hover'  => "$this->tooltip_css_element:hover",
						'border_styles'       => $this->tooltip_css_element,
						'border_styles_hover' => "$this->tooltip_css_element:hover"
					)
				)
			);

			// Box shadow styles for Icon image and default
			$advanced_fields['box_shadow']['default']               = array();
			$advanced_fields['box_shadow']['child_image_icon']      = array(
				'label'             => et_builder_i18n( 'Icon Box Shadow' ),
				'option_category'   => 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'child_image_icon',
				'css'               => array(
					'main'  => "$this->main_css_element .item-elements .icon-element",
					'hover' => "$this->main_css_element .item-elements:hover .icon-element",
				),
				'default_on_fronts' => array(
					'color'    => 'rgba(0,0,0,0.3)',
					'position' => 'outer',
				),
			);
			$advanced_fields['box_shadow']['child_title_element']   = array(
				'label'             => et_builder_i18n( 'Title Box Shadow' ),
				'option_category'   => 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'child_title_element',
				'css'               => array(
					'main'  => "$this->main_css_element .item-elements .difl_icon_item_header",
					'hover' => "$this->main_css_element .item-elements:hover .difl_icon_item_header",
				),
				'default_on_fronts' => array(
					'color'    => 'rgba(0,0,0,0.3)',
					'position' => 'outer',
				),
			);
			$advanced_fields['box_shadow']['child_content_element'] = array(
				'label'             => et_builder_i18n( 'Body Box Shadow' ),
				'option_category'   => 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'child_content_element',
				'css'               => array(
					'main'  => "$this->main_css_element .item-elements .difl_icon_item_body",
					'hover' => "$this->main_css_element .item-elements:hover .difl_icon_item_body",
				),
				'default_on_fronts' => array(
					'color'    => 'rgba(0,0,0,0.3)',
					'position' => 'outer',
				),
			);
			$advanced_fields['box_shadow']['child_wrapper_element'] = array(
				'label'             => et_builder_i18n( 'Wrapper Box Shadow' ),
				'option_category'   => 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'child_wrapper_element',
				'css'               => array(
					'main'  => "$this->main_css_element .item-elements",
					'hover' => "$this->main_css_element .item-elements:hover",
				),
				'default_on_fronts' => array(
					'color'    => 'rgba(0,0,0,0.3)',
					'position' => 'outer',
				),
			);
			$advanced_fields['box_shadow']['child_tooltip_element'] = array(
				'label'             => et_builder_i18n( 'Tooltip Box Shadow' ),
				'option_category'   => 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'child_tooltip_element',
				'css'               => array(
					'main'  => $this->tooltip_css_element,
					'hover' => "$this->tooltip_css_element:hover",
				),
				'default_on_fronts' => array(
					'color'    => 'rgba(0,0,0,0.3)',
					'position' => 'outer'
				)
			);

			// Filters for Icon
			$advanced_fields['filters'] = array(
				'child_filters_target' => array(
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'child_image_icon',
					'css'         => array(
						'main'  => "$this->main_css_element .item-elements .icon-element",
						'hover' => "$this->main_css_element .item-elements:hover .icon-element",
					),
				),
			);

			// Margin & padding for Icon List
			$advanced_fields['margin_padding'] = array(
				'use_padding' => true,
				'use_margin'  => true,
				'css'         => array(
					'margin'    => $this->main_css_element,
					'padding'   => $this->main_css_element,
					'important' => 'all',
				),
			);

			// Width for Icon List
			$advanced_fields['max_width'] = array(
				'css' => array(
					'main'             => $this->main_css_element,
					'module_alignment' => "$this->main_css_element.et_pb_module",
				),
			);

			$advanced_fields['image_icon']   = false;
			$advanced_fields['text']         = false;
			$advanced_fields['button']       = false;
			$advanced_fields['link_options'] = false;

			return $advanced_fields;
		}

		/**
		 * Declare custom css fields for the module
		 *
		 *
		 * @return array[]
		 * @since 1.0.0
		 */
		public function get_custom_css_fields_config() {
			return array(
				'list_item_icon'           => array(
					'label'    => esc_html__( 'Item Icon', 'divi_flash' ),
					'selector' => '.item-elements .et-pb-icon',
				),
				'list_item_image'          => array(
					'label'    => esc_html__( 'Item Image', 'divi_flash' ),
					'selector' => '.item-elements img',
				),
				'list_item_icon_text'      => array(
					'label'    => esc_html__( 'Item Icon Text', 'divi_flash' ),
					'selector' => '.item-elements .difl_list_icon_text',
				),
				'list_item_icon_wrapper'   => array(
					'label'    => esc_html__( 'Item Icon Wrapper', 'divi_flash' ),
					'selector' => '.item-elements .difl_icon_item_icon_wrapper',
				),
				'list_item_icon_title'     => array(
					'label'    => esc_html__( 'Item Title', 'divi_flash' ),
					'selector' => '.item-elements .difl_icon_item_header',
				),
				'list_item_icon_content'   => array(
					'label'    => esc_html__( 'Item Body', 'divi_flash' ),
					'selector' => '.item-elements .difl_icon_item_body',
				),
				'list_item_item_container' => array(
					'label'    => esc_html__( 'Item Container', 'divi_flash' ),
					'selector' => '.item-elements .difl_icon_item_container',
				),
				'list_item_item_tooltip'   => array(
					'label'    => esc_html__( 'Item Tooltip', 'divi_flash' ),
					'selector' => $this->tooltip_css_element,
				),
				'list_item_item_wrapper'   => array(
					'label'    => esc_html__( 'Item Wrapper', 'divi_flash' ),
					'selector' => '.item-elements',
				)
			);
		}

		public function get_transition_fields_css_props() {
			$fields                         = parent::get_transition_fields_css_props();
			$fields['list_item_icon_color'] = array(
				'color' => "$this->main_css_element .item-elements .et-pb-icon",
			);
			$fields['list_item_icon_size']  = array(
				'font-size' => "$this->main_css_element .item-elements .et-pb-icon",
			);

			$fields['list_item_icon_bg_color'] = array(
				'background-color' => "$this->main_css_element .item-elements .icon-element",
			);

			// Background transition
			$fields = $this->df_background_transition(
				array(
					'fields'   => $fields,
					'key'      => 'list_item_title_background',
					'selector' => "$this->main_css_element .item-elements .difl_icon_item_header",
				)
			);
			$fields = $this->df_background_transition(
				array(
					'fields'   => $fields,
					'key'      => 'list_item_content_background',
					'selector' => "$this->main_css_element .item-elements .difl_icon_item_body",
				)
			);
			$fields = $this->df_background_transition(
				array(
					'fields'   => $fields,
					'key'      => 'list_item_wrapper_background',
					'selector' => "$this->main_css_element .item-elements",
				)
			);
			$fields = $this->df_background_transition(
				array(
					'fields'   => $fields,
					'key'      => 'list_item_tooltip_background',
					'selector' => $this->tooltip_css_element,
				)
			);

			// border
			$fields = $this->df_fix_border_transition(
				$fields,
				'child_image_icon',
				"$this->main_css_element .item-elements .icon-element"
			);
			$fields = $this->df_fix_border_transition(
				$fields,
				'child_title_element',
				"$this->main_css_element.item-elements .difl_icon_item_header"
			);
			$fields = $this->df_fix_border_transition(
				$fields,
				'child_content_element',
				"$this->main_css_element.item-elements .difl_icon_item_body"
			);
			$fields = $this->df_fix_border_transition(
				$fields,
				'child_wrapper_element',
				"$this->main_css_element.item-elements"
			);
			$fields = $this->df_fix_border_transition(
				$fields,
				'child_tooltip_element',
				$this->tooltip_css_element
			);

			// box-shadow fix
			$fields = $this->df_fix_box_shadow_transition(
				$fields,
				'child_image_icon',
				"$this->main_css_element .item-elements .icon-element"
			);
			$fields = $this->df_fix_box_shadow_transition(
				$fields,
				'child_title_element',
				"$this->main_css_element .item-elements .difl_icon_item_header"
			);
			$fields = $this->df_fix_box_shadow_transition(
				$fields,
				'child_content_element',
				"$this->main_css_element .item-elements .difl_icon_item_body"
			);
			$fields = $this->df_fix_box_shadow_transition(
				$fields,
				'child_wrapper_element',
				"$this->main_css_element .item-elements"
			);
			$fields = $this->df_fix_box_shadow_transition(
				$fields,
				'child_tooltip_element',
				$this->tooltip_css_element
			);

			// set transition for custom spacing
			$fields['list_item_icon_margin']          = array(
				'margin' => "$this->main_css_element .item-elements .icon-element",
			);
			$fields['list_item_icon_padding']         = array(
				'padding' => "$this->main_css_element .item-elements .icon-element",
			);
			$fields['list_item_icon_wrapper_margin']  = array(
				'margin' => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper",
			);
			$fields['list_item_icon_wrapper_padding'] = array(
				'padding' => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper",
			);
			$fields['list_item_title_margin']         = array(
				'margin' => "$this->main_css_element .item-elements .difl_icon_item_header",
			);
			$fields['list_item_title_padding']        = array(
				'padding' => "$this->main_css_element .item-elements .difl_icon_item_header",
			);
			$fields['list_item_content_margin']       = array(
				'margin' => "$this->main_css_element .item-elements .difl_icon_item_body",
			);
			$fields['list_item_content_padding']      = array(
				'padding' => "$this->main_css_element .item-elements .difl_icon_item_body",
			);
			$fields['list_item_wrapper_margin']       = array(
				'margin' => "$this->main_css_element .item-elements",
			);
			$fields['list_item_wrapper_padding']      = array(
				'padding' => "$this->main_css_element .item-elements",
			);
			$fields['list_item_tooltip_padding']      = array(
				'padding' => $this->tooltip_css_element,
			);


			$fields['list_item_image_width'] = array(
				'width' => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper img",
			);

			$fields['list_item_image_height'] = array(
				'height' => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper img",
			);

			$fields['list_item_content_max_width'] = array(
				'max-width' => "$this->main_css_element .item-elements"
			);

			$fields['body_text_color'] = array(
				'color' => "$this->main_css_element .item-elements .difl_icon_item_description",
			);

			return $fields;
		}

		/**
		 * Render module output
		 *
		 * @param array  $attrs       List of unprocessed attributes
		 * @param string $content     Content being processed
		 * @param string $render_slug Slug of module that is used for rendering output
		 *
		 * @return string module's rendered output
		 * @since 1.0.0
		 */
		public function render( $attrs, $content, $render_slug ) {

			// Show a notice message in Visual Builder if the list item is empty.
			if ( $this->content === '' ) {
				return sprintf(
					'<div class="difl_iconlist_notice">%s</div>',
					esc_html__( 'Add one or more list items.', 'divi_flash' )
				);
			}

			$this->_set_additional_styles( $attrs, $render_slug );

			wp_enqueue_script( 'df_iconlist' );
			wp_enqueue_script( 'image-hotspot-popper-script' );
			wp_enqueue_script( 'image-hotspot-tippy-bundle-script' );

			return sprintf(
				'<ul class="difl_iconlist_container" style="list-style-type: none;">%1$s</ul>',
				$this->content
			);
		}

		/**
		 * Process styles for module output
		 *
		 * @param array $attrs List of unprocessed attributes
		 *
		 * @return void
		 */
		private function _set_additional_styles( $attrs, $render_slug ) {
			$this->props                = array_merge( $attrs, $this->props );
			$default_alignment_selector = "$this->main_css_element .difl_iconlistitem";

			if ( $this->props['list_view_type'] === 'inline' ) {
				// List layout with default and responsive
				$this->df_iconlist_set_dynamic_grid_columns(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_per_column',
						'selector'    => "$this->main_css_element ul.difl_iconlist_container"
					)
				);

				// List item vertical alignment with default, responsive
				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_vertical_alignment',
						'selector'       => $default_alignment_selector,
						'css_property'   => 'align-items',
						'render_slug'    => $this->slug,
						'type'           => 'align',
					)
				);

				// set force alignment for all elements of item
				if ( $this->props['list_item_elements_align'] === 'on' ) {
					self::set_style( $this->slug, array(
						'selector'    => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper",
						'declaration' => 'width:100%;',
					) );
					$this->generate_styles(
						array(
							'base_attr_name' => 'list_item_vertical_alignment',
							'selector'       => "$this->main_css_element .item-elements .difl_icon_item_container",
							'css_property'   => 'align-items',
							'render_slug'    => $this->slug,
							'type'           => 'align',
						)
					);
				}
			}

			if ( $this->props['list_item_equal_width'] === 'on'
				/*&& in_array( $this->props['list_item_horizontal_alignment'], array( 'center', 'flex-end' ), true )*/ ) {
				$default_alignment_selector = "$this->main_css_element .difl_iconlistitem div.et_pb_module_inner";
				self::set_style( $this->slug, array(
					'selector'    => "$default_alignment_selector, $this->main_css_element .item-elements",
					'declaration' => 'width:100%;',
				) );
			}

			// Icon item horizontal alignment with default, responsive, hover
			$this->generate_styles(
				array(
					'base_attr_name' => 'list_item_horizontal_alignment',
					'selector'       => $default_alignment_selector,
					'css_property'   => 'justify-content',
					'render_slug'    => $this->slug,
					'type'           => 'align',
				)
			);


			// List gap with default, responsive, hover
			$this->df_process_range(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_gap',
					'type'        => 'gap',
					'selector'    => "$this->main_css_element ul.difl_iconlist_container",
				)
			);

			// Icon item text alignment with default, responsive, hover
			$this->generate_styles(
				array(
					'base_attr_name' => 'list_item_text_orientation',
					'selector'       => "$this->main_css_element .difl_iconlistitem *",
					'css_property'   => 'text-align',
					'render_slug'    => $this->slug,
					'type'           => 'align',
				)
			);


			// Icon title background with default, responsive, hover
			$this->df_process_bg(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_title_background',
					'selector'    => "$this->main_css_element .item-elements .difl_icon_item_header",
					'hover'       => "$this->main_css_element .item-elements:hover .difl_icon_item_header"
				)
			);

			// Icon content background with default, responsive, hover
			$this->df_process_bg(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_content_background',
					'selector'    => "$this->main_css_element .item-elements .difl_icon_item_body",
					'hover'       => "$this->main_css_element .item-elements:hover .difl_icon_item_body",
				)
			);

			// Icon wrapper background with default, responsive, hover
			$this->df_process_bg(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_wrapper_background',
					'selector'    => "$this->main_css_element .item-elements",
					'hover'       => "$this->main_css_element .item-elements:hover",
				)
			);

			// Icon content width with default, responsive, hover
			$this->df_process_range(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_content_max_width',
					'type'        => 'max-width',
					'selector'    => "$this->main_css_element .item-elements",
					'hover'       => "$this->main_css_element .item-elements:hover",
					'important'   => false
				)
			);

			// all icons style from parent module
			// Set background color for Icon
			$this->generate_styles(
				array(
					'base_attr_name' => 'list_item_icon_bg_color',
					'selector'       => "$this->main_css_element .item-elements .icon-element",
					'hover_selector' => "$this->main_css_element .item-elements:hover .icon-element",
					'css_property'   => 'background-color',
					'render_slug'    => $this->slug,
					'type'           => 'color',
				)
			);

			// Icon placement with default, responsive, hover
			$this->generate_styles(
				array(
					'base_attr_name' => 'list_item_icon_placement',
					'selector'       => "$this->main_css_element .item-elements .difl_icon_item_container",
					'css_property'   => 'flex-direction',
					'render_slug'    => $this->slug,
					'type'           => 'align',
				)
			);

			// Icon alignment with default, responsive, hover
			// applied when render is not html
			$this->generate_styles(
				array(
					'base_attr_name' => 'list_item_icon_alignment',
					'selector'       => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper",
					'css_property'   => 'text-align',
					'render_slug'    => $this->slug,
					'type'           => 'align',
				)
			);

			if ( $this->props['list_item_icon_placement'] !== 'column' && $this->props['list_item_icon_vertical_placement'] !== '' ) {
				self::set_style( $this->slug, array(
					'selector'    => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper",
					'declaration' => 'display:flex;',
				) );

				// Icon placement with default, responsive, hover
				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_icon_vertical_placement',
						'selector'       => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper",
						'css_property'   => 'align-items',
						'render_slug'    => $this->slug,
						'type'           => 'align',
					)
				);
			}


			// Icon margin and padding with default, responsive, hover
			$this->set_margin_padding_styles(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_icon_margin',
					'type'        => 'margin',
					'selector'    => "$this->main_css_element .item-elements .icon-element",
					'hover'       => "$this->main_css_element .item-elements:hover .icon-element"
				)
			);
			$this->set_margin_padding_styles(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_icon_padding',
					'type'        => 'padding',
					'selector'    => "$this->main_css_element .item-elements .icon-element",
					'hover'       => "$this->main_css_element .item-elements:hover .icon-element"
				)
			);

			// Icon wrapper margin and padding with default, responsive, hover
			$this->set_margin_padding_styles(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_icon_wrapper_margin',
					'type'        => 'margin',
					'selector'    => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper",
					'hover'       => "$this->main_css_element .item-elements:hover .difl_icon_item_icon_wrapper"
				)
			);
			$this->set_margin_padding_styles(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_icon_wrapper_padding',
					'type'        => 'padding',
					'selector'    => "$this->main_css_element .item-elements .difl_icon_item_container",
					'hover'       => "$this->main_css_element .item-elements:hover .difl_icon_item_container"
				)
			);


			// Images: Add CSS Filters and Mix Blend Mode rules (if set)
			if ( array_key_exists( 'child_image_icon', $this->advanced_fields )
			     && array_key_exists( 'css', $this->advanced_fields['child_image_icon'] ) ) {
				$this->generate_css_filters(
					$this->slug,
					'child_',
					self::$data_utils->array_get(
						$this->advanced_fields['child_image_icon']['css'],
						'main',
						$this->main_css_element
					)
				);
			}

			// font icon
			$this->df_process_color(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_icon_color',
					'type'        => 'color',
					'selector'    => "$this->main_css_element .item-elements .et-pb-icon",
					'hover'       => "$this->main_css_element .item-elements:hover .et-pb-icon"
				)
			);
			// Set size for Icon
			$this->df_process_range(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_icon_size',
					'type'        => 'font-size',
					'selector'    => "$this->main_css_element .item-elements .et-pb-icon",
					'hover'       => "$this->main_css_element .item-elements:hover .et-pb-icon",
				)
			);


			// image as icon
			$this->df_process_range(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_image_width',
					'type'        => 'width',
					'selector'    => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper img",
					'hover'       => "$this->main_css_element .item-elements:hover .difl_icon_item_icon_wrapper img",
				)
			);
			$this->df_process_range(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_image_height',
					'type'        => 'height',
					'selector'    => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper img",
					'hover'       => "$this->main_css_element .item-elements:hover .difl_icon_item_icon_wrapper img",
				)
			);

			$this->df_process_range(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_icon_text_gap',
					'type'        => 'gap',
					'selector'    => "$this->main_css_element .item-elements .difl_icon_item_container",
					'hover'       => "$this->main_css_element .item-elements:hover .difl_icon_item_container",
				)
			);

			// Set background color for Icon
			$this->df_process_color(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_icon_lottie_color',
					'type'        => 'fill',
					'selector'    => "$this->main_css_element .item-elements .difl_lottie_player svg path",
					'hover'       => "$this->main_css_element .item-elements:hover .difl_lottie_player svg path"
				)
			);

			// Set background color for Icon
			$this->df_process_color(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_icon_lottie_background_color',
					'type'        => 'background-color',
					'selector'    => "$this->main_css_element .item-elements .difl_lottie_player",
					'hover'       => "$this->main_css_element .item-elements:hover .difl_lottie_player"
				)
			);

			// Set width for Image
			$this->generate_styles(
				array(
					'base_attr_name' => 'list_item_icon_lottie_width',
					'selector'       => "$this->main_css_element .item-elements .difl_lottie_player",
					'css_property'   => 'width',
					'render_slug'    => $this->slug,
					'type'           => 'range',
				)
			);
			// Set height for Image
			$this->generate_styles(
				array(
					'base_attr_name' => 'list_item_icon_lottie_height',
					'selector'       => "$this->main_css_element .item-elements .difl_lottie_player",
					'css_property'   => 'height',
					'render_slug'    => $this->slug,
					'type'           => 'range',
				)
			);


			// margin and padding from parent module
			// Icon title margin with default, responsive, hover
			$this->set_margin_padding_styles(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_title_margin',
					'type'        => 'margin',
					'selector'    => "$this->main_css_element .item-elements .difl_icon_item_header",
					'hover'       => "$this->main_css_element .item-elements:hover .difl_icon_item_header",
					'important'   => false
				)
			);
			$this->set_margin_padding_styles(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_title_padding',
					'type'        => 'padding',
					'selector'    => "$this->main_css_element .item-elements .difl_icon_item_header",
					'hover'       => "$this->main_css_element .item-elements:hover .difl_icon_item_header",
					'important'   => false
				)
			);

			// Icon content margin with default, responsive, hover
			$this->set_margin_padding_styles(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_content_margin',
					'type'        => 'margin',
					'selector'    => "$this->main_css_element .item-elements .difl_icon_item_body",
					'hover'       => "$this->main_css_element .item-elements:hover .difl_icon_item_body",
					'important'   => false
				)
			);
			$this->set_margin_padding_styles(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_content_padding',
					'type'        => 'padding',
					'selector'    => "$this->main_css_element .item-elements .difl_icon_item_body",
					'hover'       => "$this->main_css_element .item-elements:hover .difl_icon_item_body",
					'important'   => false
				)
			);

			// item wrapper margin with default, responsive, hover
			$this->set_margin_padding_styles(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_wrapper_margin',
					'type'        => 'margin',
					'selector'    => "$this->main_css_element .item-elements",
					'hover'       => "$this->main_css_element .item-elements:hover",
					'important'   => false
				)
			);
			$this->set_margin_padding_styles(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_wrapper_padding',
					'type'        => 'padding',
					'selector'    => "$this->main_css_element .item-elements",
					'hover'       => "$this->main_css_element .item-elements:hover",
					'important'   => false
				)
			);

			// Icon tooltip background with default, responsive, hover
			$this->df_process_bg(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_tooltip_background',
					'selector'    => $this->tooltip_css_element,
					'hover'       => "$this->tooltip_css_element:hover",
				)
			);

			// Arrow color
			$this->df_process_color(
				array(
					'render_slug' => $this->slug,
					'slug'        => 'tooltip_arrow_color',
					'type'        => 'border-top-color',
					'selector'    => "$this->tooltip_css_element[data-placement^='top'] > .tippy-arrow::before",
					'hover'       => "$this->tooltip_css_element[data-placement^='top']:hover > .tippy-arrow::before",
					'important'   => false
				)
			);
			$this->df_process_color(
				array(
					'render_slug' => $this->slug,
					'slug'        => 'tooltip_arrow_color',
					'type'        => 'border-bottom-color',
					'selector'    => "$this->tooltip_css_element[data-placement^='bottom'] > .tippy-arrow::before",
					'hover'       => "$this->tooltip_css_element[data-placement^='bottom']:hover > .tippy-arrow::before",
					'important'   => false
				)
			);
			$this->df_process_color(
				array(
					'render_slug' => $this->slug,
					'slug'        => 'tooltip_arrow_color',
					'type'        => 'border-left-color',
					'selector'    => "$this->tooltip_css_element[data-placement^='left'] > .tippy-arrow::before",
					'hover'       => "$this->tooltip_css_element[data-placement^='left']:hover > .tippy-arrow::before",
					'important'   => false
				)
			);
			$this->df_process_color(
				array(
					'render_slug' => $this->slug,
					'slug'        => 'tooltip_arrow_color',
					'type'        => 'border-right-color',
					'selector'    => "$this->tooltip_css_element[data-placement^='right'] > .tippy-arrow::before",
					'hover'       => "$this->tooltip_css_element[data-placement^='right']:hover > .tippy-arrow::before",
					'important'   => false
				)
			);

			// item tooltip padding with default, responsive, hover
			$this->set_margin_padding_styles(
				array(
					'render_slug' => $render_slug,
					'slug'        => 'list_item_tooltip_padding',
					'type'        => 'padding',
					'selector'    => $this->tooltip_css_element,
					'hover'       => "$this->tooltip_css_element:hover",
					'important'   => false
				)
			);
		}

		/**
		 * Process dynamic grid column for module output
		 *
		 * @param array $options Options array for operation
		 *
		 * @return void
		 */
		private function df_iconlist_set_dynamic_grid_columns( $options ) {
			$default = array(
				'render_slug' => '',
				'slug'        => '',
				'selector'    => '',
			);
			$options = wp_parse_args( $options, $default );

			if ( array_key_exists( $options['slug'], $this->props ) && ! empty( $this->props[ $options['slug'] ] ) ) {
				$desktop_column = $this->props[ $options['slug'] ];
				self::set_style( $options['render_slug'], array(
					'selector'    => $options['selector'],
					'declaration' => sprintf( 'grid-template-columns:repeat(%1$s, 1fr);', $desktop_column ),
				) );
			}

			if ( array_key_exists( $options['slug'] . '_tablet', $this->props )
			     && ! empty( $this->props[ $options['slug'] . '_tablet' ] ) ) {
				$tablet_column = $this->props[ $options['slug'] . '_tablet' ];
				self::set_style( $options['render_slug'], array(
					'selector'    => $options['selector'],
					'declaration' => sprintf( 'grid-template-columns:repeat(%1$s, 1fr);', $tablet_column ),
					'media_query' => self::get_media_query( 'max_width_980' )
				) );
			}

			if ( array_key_exists( $options['slug'] . '_phone', $this->props )
			     && ! empty( $this->props[ $options['slug'] . '_phone' ] ) ) {
				$phone_column = $this->props[ $options['slug'] . '_phone' ];
				self::set_style( $options['render_slug'], array(
					'selector'    => $options['selector'],
					'declaration' => sprintf( 'grid-template-columns:repeat(%1$s, 1fr);', $phone_column ),
					'media_query' => self::get_media_query( 'max_width_767' )
				) );
			}
		}
	}

	new DIFL_IconList();
