<?php

	class DIFL_IconListItem extends ET_Builder_Module {
		use \DIFL\Fa_Icon_Handler;

		public $slug       = 'difl_iconlistitem';
		public $vb_support = 'on';
		public $type       = 'child';
		use DF_UTLS;

		// private attribute
		protected $module_credits
			                           = array(
				'module_uri' => '',
				'author'     => 'DiviFlash',
				'author_uri' => '',
			);
		private   $tooltip_css_element = '';

		/**
		 * Initiate Module.
		 * Set the module name on init.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function init() {
			$this->name   = esc_html__( 'List Item', 'divi_flash' );
			$this->plural = esc_html__( 'List Items', 'divi_flash' );

			$this->child_title_var          = 'list_item_title';
			$this->child_title_fallback_var = 'list_item_icon_type';

			$this->main_css_element    = '%%order_class%%.difl_iconlistitem';
			$this->tooltip_css_element = ".tippy-box[data-theme~='%%order_class%%']";
		}

		/**
		 * Declare settings modal toggles for the module
		 *
		 * @return array[][]
		 * @since 1.0.0
		 */
		public function get_settings_modal_toggles() {
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
						'main_content'          => esc_html__( 'Content', 'divi_flash' ),
						'child_image_icon'      => esc_html__( 'Icon', 'et_builder' ),
						'child_lottie_element'  => esc_html__( 'Lottie Settings', 'divi_flash' ),
						'child_tooltip_element' => esc_html__( 'Tooltip Settings', 'divi_flash' ),
						'admin_label'           => array(
							'title'    => et_builder_i18n( 'Admin Label' ),
							'priority' => 99,
						),
					),
				),
				'advanced' => array(
					'toggles' => array(
						'child_wrapper_element' => esc_html__( 'Item Wrapper Styles', 'divi_flash' ),
						'child_image_icon'      => esc_html__( 'Icon Styles', 'et_builder' ),
						'child_icon_text'       => esc_html__( 'Icon Text', 'divi_flash' ),
						'child_lottie_element'  => esc_html__( 'Icon Lottie Styles', 'divi_flash' ),
						'child_title_icon'      => esc_html__( 'Title Icon', 'et_builder' ),
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
							'priority' => 85,
						),
					),
				),
			);
		}

		/**
		 * Declare general fields for the module
		 *
		 * @return array[]
		 * @since 1.0.0
		 */
		public function get_fields() {
			$child_image_icon_placement = array(
				'inherit'     => et_builder_i18n( 'Default' ),
				'column'      => et_builder_i18n( 'Top' ),
				'row'         => et_builder_i18n( 'Left' ),
				'row-reverse' => et_builder_i18n( 'Right' ),
			);

			$text_fields = array(
				'list_item_title'           => array(
					'label'           => et_builder_i18n( 'Title' ),
					'description'     => esc_html__(
						'The title of your list item will appear in with your item image.',
						'divi_flash'
					),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'tab_slug'        => 'general',
					'toggle_slug'     => 'main_content',
					'show_if'         => array(
						'list_item_icon_only' => 'off',
					),

					'dynamic_content' => 'text',
					'mobile_options'  => true,
					'hover'           => 'tabs',
				),
				'content'                   => array(
					'label'           => esc_html__( 'Body', 'divi_flash' ),
					'description'     => esc_html__( 'Input the main text content for your module here.',
					                                 'divi_flash' ),
					'type'            => 'tiny_mce',
					'option_category' => 'basic_option',
					'tab_slug'        => 'general',
					'toggle_slug'     => 'main_content',
					'show_if'         => array(
						'list_item_icon_only' => 'off',
					),
					'dynamic_content' => 'text',
					'mobile_options'  => true,
					'hover'           => 'tabs',
				),
				'list_item_title_tag'       => array(
					'label'            => esc_html__( 'Title Tag', 'divi_flash' ),
					'description'      => esc_html__( 'Choose a tag to display with your title.', 'divi_flash' ),
					'type'             => 'select',
					'option_category'  => 'layout',
					'options'          => array(
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
					'tab_slug'         => 'general',
					'toggle_slug'      => 'main_content',
					'default_on_front' => 'h4',
					'show_if'          => array(
						'list_item_icon_only' => 'off',
					),
				),
				'list_item_use_tooltip'     => array(
					'label'            => esc_html__( 'Show Tooltip', 'divi_flash' ),
					'description'      => esc_html__(
						'Enable your desired item tooltip content for view.',
						'divi_flash'
					),
					'type'             => 'yes_no_button',
					'option_category'  => 'configuration',
					'options'          => array(
						'off' => esc_html__( 'No', 'divi_flash' ),
						'on'  => esc_html__( 'Yes', 'divi_flash' ),
					),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'main_content',
					'default_on_front' => 'off',
				),
				'list_item_tooltip_content' => array(
					'label'           => esc_html__( 'Tooltip Content', 'divi_flash' ),
					'description'     => esc_html__( 'Input the tooltip content for your module here.', 'divi_flash' ),
					'type'            => 'tiny_mce',
					'option_category' => 'basic_option',
					'tab_slug'        => 'general',
					'toggle_slug'     => 'main_content',
					'show_if'         => array(
						'list_item_use_tooltip' => 'on',
					),
					'dynamic_content' => 'text',
				),
			);

			$title_background   = $this->df_add_bg_field(
				array(
					'label'       => esc_html__( 'Title Background', 'divi_flash' ),
					'key'         => 'list_item_title_background',
					'toggle_slug' => 'child_title_element',
					'tab_slug'    => 'advanced',
					'show_if'     => array(
						'list_item_icon_only' => 'off',
					),
				)
			);
			$content_background = $this->df_add_bg_field(
				array(
					'label'       => esc_html__( 'Body Background', 'divi_flash' ),
					'key'         => 'list_item_content_background',
					'toggle_slug' => 'child_content_element',
					'tab_slug'    => 'advanced',
					'show_if'     => array(
						'list_item_icon_only' => 'off',
					),
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
					'tab_slug'    => 'advanced',
					'show_if'     => array(
						'list_item_use_tooltip' => 'on',
					),
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
					'show_if'         => array(
						'list_item_icon_only' => 'off',
					),
					'advanced_fields' => true,
					'mobile_options'  => true,
				),
				'list_item_content_max_width' => array(
					'label'           => esc_html__( 'Item Content Width', 'et_builder' ),
					'description'     => esc_html__(
						'Adjust the width of the content within the list item.',
						'et_builder'
					),
					'type'            => 'range',
					'range_settings'  => array(
						'min'  => '0',
						'max'  => '1100',
						'step' => '1',
					),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'width',
					'allowed_values'  => et_builder_get_acceptable_css_string_values( 'max-width' ),
					'allow_empty'     => true,
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc','ex', 'vh', 'vw' ),
					'validate_unit'   => true,
					'hover'           => 'tabs',
					'mobile_options'  => true,
					'responsive'      => true,
					'sticky'          => true,
					'show_if'         => array(
						'list_item_icon_only' => 'off',
					),
				),
			);
			$icon_image_fields            = array(
				'list_item_icon_type' => array(
					'label'            => esc_html__( 'Icon Type', 'divi_flash' ),
					'description'      => esc_html__(
						'Choose an icon type to display with your list item.',
						'divi_flash'
					),
					'type'             => 'select',
					'option_category'  => 'layout',
					'options'          => array(
						'icon'   => esc_html__( 'Icon', 'et_builder' ),
						'image'  => et_builder_i18n( 'Image' ),
						'text'   => et_builder_i18n( 'Text' ),
						'lottie' => esc_html__( 'Lottie', 'divi_flash' ),
						'none'   => esc_html__( 'None', 'divi_flash' ),
					),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'child_image_icon',
					'default_on_front' => 'icon',
					'affects'          => array(
						'list_item_icon',
						'list_item_image',
						'list_item_icon_text',
						'list_item_icon_lottie_src_type',
						'list_item_icon_lottie_delay',
						'list_item_icon_lottie_direction',
						'list_item_icon_lottie_renderer',
						'list_item_icon_lottie_color',
						'list_item_icon_lottie_background_color',
						'list_item_icon_lottie_width',
						'list_item_icon_lottie_height',
						'list_item_icon_color',
						'list_item_icon_size',
						'list_item_image_width',
						'list_item_image_height',
						'alt',
					),
				),
				'list_item_icon'      => array(
					'label'            => esc_html__( 'Choose an icon', 'divi_flash' ),
					'description'      => esc_html__( 'Choose an icon to display with your list item.', 'et_builder' ),
					'type'             => 'select_icon',
					'option_category'  => 'basic_option',
					'class'            => array( 'et-pb-font-icon' ),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'child_image_icon',
					'default_on_front' => '&#x4e;||divi||400',
					'depends_show_if'  => 'icon',
					'mobile_options'   => true,
					'hover'            => 'tabs',
				),
				'list_item_image'     => array(
					'label'              => et_builder_i18n( 'Image' ),
					'description'        => esc_html__(
						'Upload an image to display at the top of your list item.',
						'et_builder'
					),
					'type'               => 'upload',
					'option_category'    => 'basic_option',
					'upload_button_text' => et_builder_i18n( 'Upload an image' ),
					'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
					'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
					'tab_slug'           => 'general',
					'toggle_slug'        => 'child_image_icon',
					'depends_show_if'    => 'image',
					'dynamic_content'    => 'image',
					'mobile_options'     => true,
					'hover'              => 'tabs',
				),
				'alt'                 => array(
					'label'           => esc_html__( 'Image Alt Text', 'et_builder' ),
					'description'     => esc_html__( 'Define the HTML ALT text for your image here.', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'tab_slug'        => 'general',
					'toggle_slug'     => 'child_image_icon',
					'depends_show_if' => 'image',
					'dynamic_content' => 'text',
				),
				'list_item_icon_text' => array(
					'label'           => et_builder_i18n( 'Text' ),
					'description'     => esc_html__(
						'The title of your list item will appear in bold below your list item image.',
						'et_builder'
					),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'tab_slug'        => 'general',
					'toggle_slug'     => 'child_image_icon',
					'depends_show_if' => 'text',
					'dynamic_content' => 'text',
				),
			);
			$lottie_fields                = array(
				'list_item_icon_lottie_src_type'   => array(
					'label'            => esc_html__( 'Lottie File Location', 'divi_flash' ),
					'description'      => esc_html__(
						'Choose a file location to display from your lottie.',
						'divi_flash'
					),
					'type'             => 'select',
					'option_category'  => 'layout',
					'options'          => array(
						'select' => esc_html__( 'Select type', 'divi_flash' ),
						'remote' => esc_html__( 'External File URL', 'divi_flash' ),
						'local'  => esc_html__( 'Upload', 'divi_flash' ),
					),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'child_image_icon',
					'default'          => 'remote',
					'default_on_front' => 'remote',
					'depends_show_if'  => 'lottie',
					'affects'          => array(
						'list_item_icon_lottie_src_upload',
						'list_item_icon_lottie_src_remote',
					),
				),
				'list_item_icon_lottie_src_remote' => array(
					'label'           => esc_html__( 'URL', 'divi_flash' ),
					'description'     => esc_html__(
						'The external file url of your lottie image.',
						'divi_flash'
					),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'tab_slug'        => 'general',
					'toggle_slug'     => 'child_image_icon',
					'depends_show_if' => 'remote',
					'dynamic_content' => 'url',
				),
				'list_item_icon_lottie_src_upload' => array(
					'label'              => esc_html__( 'Upload', 'divi_flash' ),
					'description'        => esc_html__( 'A json file is chosen for lottie.', 'divi_flash' ),
					'type'               => 'upload',
					'option_category'    => 'basic_option',
					'upload_button_text' => esc_attr__( 'Upload a JSON', 'et_builder' ),
					'choose_text'        => esc_attr__( 'Choose a JSON', 'et_builder' ),
					'update_text'        => esc_attr__( 'Set As JSON', 'et_builder' ),
					'tab_slug'           => 'general',
					'toggle_slug'        => 'child_image_icon',
					'data_type'          => 'json',
					'depends_show_if'    => 'local',
				),
				'json_ex_notice'                   => array(
					'type'        => 'df_json_ex_notice',
					'tab_slug'    => 'general',
					'toggle_slug' => 'child_image_icon',
					'options'     => array(
						'list_item_icon_lottie_src_type' => 'local'
					)
				),
			);
			$lottie_animation_fields      = array(
				'list_item_icon_lottie_trigger_method'  => array(
					'label'           => esc_html__( 'Animation Trigger', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can choose animation trigger for your Lottie animation.',
						'divi_flash'
					),
					'type'            => 'select',
					'option_category' => 'layout',
					'options'         => array(
						'viewport' => esc_html__( 'Viewport', 'divi_flash' ),
						'click'    => esc_html__( 'On Click', 'divi_flash' ),
						'hover'    => esc_html__( 'On Hover', 'divi_flash' ),
						'scroll'   => esc_html__( 'On Scroll', 'divi_flash' ),
						'none'     => esc_html__( 'None', 'divi_flash' )
					),
					'default'         => 'viewport',
					'show_if'         => array(
						'list_item_icon_type' => 'lottie',
					),
					'tab_slug'        => 'general',
					'toggle_slug'     => 'child_lottie_element',
				),
				'list_item_icon_lottie_mouseout_action' => array(
					'label'       => esc_html__( 'Pause Animation Mouse Leave', 'divi_flash' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'off' => esc_html__( 'OFF', 'divi_flash' ),
						'on'  => esc_html__( 'ON', 'divi_flash' ),
					),
					'default'     => 'off',
					'show_if'     => array(
						'list_item_icon_lottie_trigger_method' => 'hover'
					),
					'tab_slug'    => 'general',
					'toggle_slug' => 'child_lottie_element',
				),
				'list_item_icon_lottie_scroll_effect'   => array(
					'label'       => esc_html__( 'Track Divi Scroll Effect', 'divi_flash' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'off' => esc_html__( 'OFF', 'divi_flash' ),
						'on'  => esc_html__( 'ON', 'divi_flash' ),
					),
					'default'     => 'off',
					'show_if'     => array(
						'list_item_icon_lottie_trigger_method' => 'scroll'
					),
					'tab_slug'    => 'general',
					'toggle_slug' => 'child_lottie_element',
				),
				'list_item_icon_lottie_delay'           => array(
					'label'            => esc_html__( 'Threshold', 'divi_flash' ),
					'description'      => esc_html__( 'It has a default value of zero, which means that as soon as a user approaches the target element and it becomes visible',
					                                  'divi_flash' ),
					'type'             => 'range',
					'option_category'  => 'configuration',
					'default_on_front' => '0',
					'validate_unit'    => false,
					'unitless'         => true,
					'range_settings'   => array(
						'min'  => '0',
						'max'  => '8000',
						'step' => '1',
					),
					'depends_show_if'  => 'lottie',
					'show_if'          => array(
						'list_item_icon_type'                  => 'lottie',
						'list_item_icon_lottie_trigger_method' => 'viewport',
					),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'child_lottie_element',
				),
				'list_item_icon_lottie_loop'            => array(
					'label'           => esc_html__( 'Loop', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can choose whether or not your Lottie will animate in loop.',
						'divi_flash'
					),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'off' => esc_html__( 'OFF', 'divi_flash' ),
						'on'  => esc_html__( 'ON', 'divi_flash' ),
					),
					'default'         => 'off',
					'show_if'         => array(
						'list_item_icon_type' => 'lottie',
					),
					'tab_slug'        => 'general',
					'toggle_slug'     => 'child_lottie_element',
				),
				'list_item_icon_lottie_speed'           => array(
					'label'           => esc_html__( 'Animation Speed', 'divi_flash' ),
					'description'     => esc_html__( 'The speed of the animation.', 'divi_flash' ),
					'type'            => 'range',
					'option_category' => 'layout',
					'validate_unit'   => false,
					'unitless'        => true,
					'range_settings'  => array(
						'min'  => '0.1',
						'max'  => '2.5',
						'step' => '0.1',
					),
					'default'         => '1',
					'show_if'         => array(
						'list_item_icon_type' => 'lottie',
					),
					'tab_slug'        => 'general',
					'toggle_slug'     => 'child_lottie_element',
				),
				'list_item_icon_lottie_direction'       => array(
					'label'           => esc_html__( 'Reverse Direction', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can enable play reverse direction for your Lottie animation.',
						'divi_flash'
					),
					'type'            => 'yes_no_button',
					'options'         => array(
						'off' => esc_html__( 'OFF', 'divi_flash' ),
						'on'  => esc_html__( 'ON', 'divi_flash' ),
					),
					'default'         => 'off',
					'depends_show_if' => 'lottie',
					'tab_slug'        => 'general',
					'toggle_slug'     => 'child_lottie_element',
				),
				'list_item_icon_lottie_renderer'        => array(
					'label'           => esc_html__( 'Renderer', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can choose renderer for your Lottie animation.',
						'divi_flash'
					),
					'type'            => 'select',
					'option_category' => 'layout',
					'options'         => array(
						'svg'    => esc_html__( 'SVG', 'divi_flash' ),
						'canvas' => esc_html__( 'Canvas', 'divi_flash' ),
					),
					'default'         => 'svg',
					'depends_show_if' => 'lottie',
					'tab_slug'        => 'general',
					'toggle_slug'     => 'child_lottie_element',
				),
			);
			$lottie_associated_fields     = array(
				'list_item_icon_lottie_color'            => array(
					'label'       => esc_html__( 'Lottie Color', 'divi_flash' ),
					'description' => esc_html__( 'Here you can define a custom color for lottie image.', 'divi_flash' ),
					'type'        => 'color-alpha',
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'child_lottie_element',
					'show_if'     => array(
						'list_item_icon_type'            => 'lottie',
						'list_item_icon_lottie_renderer' => 'svg',
					),
					'hover'       => 'tabs',
					'sticky'      => true,
				),
				'list_item_icon_lottie_background_color' => array(
					'label'           => esc_html__( 'Lottie Background Color', 'divi_flash' ),
					'description'     => esc_html__(
						'Here you can define a custom background color for lottie image.',
						'divi_flash'
					),
					'type'            => 'color-alpha',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'child_lottie_element',
					'depends_show_if' => 'lottie',
					'hover'           => 'tabs',
					'sticky'          => true,
				),
				'list_item_icon_lottie_width'            => array(
					'label'           => esc_html__( 'Lottie Width', 'divi_flash' ),
					'description'     => esc_html__( 'Here you can choose lottie width.', 'divi_flash' ),
					'type'            => 'range',
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '200',
						'step' => '1',
					),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'child_lottie_element',
					'validate_unit'   => true,
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'depends_show_if' => 'lottie',
					'responsive'      => true,
					'mobile_options'  => true,
					'sticky'          => true,
				),
				'list_item_icon_lottie_height'           => array(
					'label'           => esc_html__( 'Lottie Height', 'divi_flash' ),
					'description'     => esc_html__( 'Here you can choose lottie height.', 'divi_flash' ),
					'type'            => 'range',
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '200',
						'step' => '1',
					),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'child_lottie_element',
					'validate_unit'   => true,
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'depends_show_if' => 'lottie',
					'responsive'      => true,
					'mobile_options'  => true,
					'sticky'          => true,
				),
			);
			$title_icon_fields            = array(
				'list_item_title_icon_enable' => array(
					'label'            => esc_html__( 'Use Icon For Title', 'divi_flash' ),
					'description'      => esc_html__(
						'Here you can choose whether or not use icon for the item title.',
						'divi_flash'
					),
					'type'             => 'yes_no_button',
					'option_category'  => 'configuration',
					'options'          => array(
						'off' => esc_html__( 'No', 'divi_flash' ),
						'on'  => esc_html__( 'Yes', 'divi_flash' ),
					),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'child_image_icon',
					'default_on_front' => 'off',
					'show_if'          => array(
						'list_item_icon_only' => 'off',
					),
				),
				'list_item_title_icon'        => array(
					'label'            => esc_html__( 'Choose An Icon', 'divi_flash' ),
					'description'      => esc_html__( 'Choose an icon to display with your item title.', 'et_builder' ),
					'type'             => 'select_icon',
					'option_category'  => 'basic_option',
					'class'            => array( 'et-pb-font-icon' ),
					'default_on_front' => '&#x49;||divi||400',
					'tab_slug'         => 'general',
					'toggle_slug'      => 'child_image_icon',
					'show_if'          => array(
						'list_item_title_icon_enable' => 'on',
					),
				),
			);
			$icon_image_options_fields    = array(
				'list_item_icon_only'     => array(
					'label'            => esc_html__( 'Show Icon Only', 'divi_flash' ),
					'description'      => esc_html__( 'Enable your desired item icon only.', 'divi_flash' ),
					'type'             => 'yes_no_button',
					'option_category'  => 'configuration',
					'options'          => array(
						'off' => esc_html__( 'No', 'divi_flash' ),
						'on'  => esc_html__( 'Yes', 'divi_flash' ),
					),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'child_image_icon',
					'default_on_front' => 'off',
					'show_if'          => array(
						'list_item_icon_type' => array( 'image', 'icon', 'lottie' ),
					),
				),
				'list_item_icon_on_hover' => array(
					'label'            => esc_html__( 'Icon Show On Hover', 'divi_flash' ),
					'description'      => esc_html__(
						'By default, item icon to always be displayed. If you would like item icon are displayed on hover, then you can enable this option.',
						'divi_flash'
					),
					'type'             => 'yes_no_button',
					'option_category'  => 'configuration',
					'options'          => array(
						'off' => esc_html__( 'No', 'divi_flash' ),
						'on'  => esc_html__( 'Yes', 'divi_flash' ),
					),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'child_image_icon',
					'default_on_front' => 'off',
					'show_if'          => array(
						'list_item_icon_only' => 'off',
						'list_item_icon_type' => array( 'image', 'icon', 'lottie' ),
					),
				),
			);
			$title_icon_options_fields    = array(
				'list_item_title_icon_on_hover' => array(
					'label'            => esc_html__( 'Title Icon Show On Hover', 'divi_flash' ),
					'description'      => esc_html__(
						'By default, item title icon on hover be displayed. If you would like item icon is displayed all time, then you can enable this option.',
						'divi_flash'
					),
					'type'             => 'yes_no_button',
					'option_category'  => 'configuration',
					'options'          => array(
						'off' => esc_html__( 'No', 'divi_flash' ),
						'on'  => esc_html__( 'Yes', 'divi_flash' ),
					),
					'tab_slug'         => 'general',
					'toggle_slug'      => 'child_image_icon',
					'default_on_front' => 'off',
					'show_if'          => array(
						'list_item_title_icon_enable' => 'on',
					),
				),
			);
			$icon_image_associated_fields = array(
				'list_item_icon_color'              => array(
					'label'           => esc_html__( 'Icon Color', 'et_builder' ),
					'description'     => esc_html__( 'Here you can define a custom color for your icon.',
					                                 'et_builder' ),
					'type'            => 'color-alpha',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'child_image_icon',
					'depends_show_if' => 'icon',
					'hover'           => 'tabs',
					'mobile_options'  => true,
					'sticky'          => true,
				),
				'list_item_icon_bg_color'           => array(
					'label'          => esc_html__( 'Icon Background Color', 'et_builder' ),
					'description'    => esc_html__( 'Here you can define a custom background color.', 'et_builder' ),
					'type'           => 'color-alpha',
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'child_image_icon',
					'show_if'        => array(
						'list_item_icon_type' => array( 'icon', 'text' ),
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'sticky'         => true,
				),
				'list_item_title_icon_color'        => array(
					'label'          => esc_html__( 'Title Icon Color', 'et_builder' ),
					'description'    => esc_html__( 'Here you can define a custom color for your icon.', 'et_builder' ),
					'type'           => 'color-alpha',
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'child_image_icon',
					'show_if'        => array(
						'list_item_title_icon_enable' => 'on',
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'sticky'         => true,
				),
				'list_item_icon_size'               => array(
					'label'           => esc_html__( 'Icon Size', 'et_builder' ),
					'description'     => esc_html__( 'Here you can choose icon size.', 'et_builder' ),
					'type'            => 'range',
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '200',
						'step' => '1',
					),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'child_image_icon',
					'validate_unit'   => true,
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'depends_show_if' => 'icon',
					'hover'           => 'tabs',
					'responsive'      => true,
					'mobile_options'  => true,
					'sticky'          => true,
				),
				'list_item_title_icon_size'         => array(
					'label'           => esc_html__( 'Title Icon Size', 'et_builder' ),
					'description'     => esc_html__( 'Here you can choose icon size.', 'et_builder' ),
					'type'            => 'range',
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '200',
						'step' => '1',
					),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'child_image_icon',
					'validate_unit'   => true,
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'show_if'         => array(
						'list_item_title_icon_enable' => 'on',
					),
					'default'         => '16px',
					'hover'           => 'tabs',
					'responsive'      => true,
					'mobile_options'  => true,
					'sticky'          => true,
				),
				'list_item_image_width'             => array(
					'label'           => esc_html__( 'Image Width', 'et_builder' ),
					'description'     => esc_html__( 'Here you can choose image width.', 'et_builder' ),
					'type'            => 'range',
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '200',
						'step' => '1',
					),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'child_image_icon',
					'validate_unit'   => true,
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'depends_show_if' => 'image',
					'hover'           => 'tabs',
					'responsive'      => true,
					'mobile_options'  => true,
					'sticky'          => true,
				),
				'list_item_image_height'            => array(
					'label'           => esc_html__( 'Image Height', 'et_builder' ),
					'description'     => esc_html__( 'Here you can choose image height.', 'et_builder' ),
					'type'            => 'range',
					'range_settings'  => array(
						'min'  => '1',
						'max'  => '200',
						'step' => '1',
					),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'child_image_icon',
					'validate_unit'   => true,
					'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
					'depends_show_if' => 'image',
					'hover'           => 'tabs',
					'responsive'      => true,
					'mobile_options'  => true,
					'sticky'          => true,
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
					'show_if'        => array(
						'list_item_icon_only' => 'off',
					),
					'mobile_options' => true,
				),
				'list_item_icon_placement'          => array(
					'label'            => esc_html__( 'Icon Placement', 'et_builder' ),
					'description'      => esc_html__( 'Here you can choose where to place the icon.', 'et_builder' ),
					'type'             => 'select',
					'option_category'  => 'layout',
					'options'          => $child_image_icon_placement,
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'child_image_icon',
					'default_on_front' => 'inherit',
					'show_if'          => array(
						'list_item_icon_only' => 'off',
					),
					'show_if_not'      => array(
						'list_item_icon_type' => 'none',
					),
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
					'mobile_options'  => true,
					'show_if'         => array(
						'list_item_icon_placement' => 'column',
					),
					'show_if_not'     => array(
						'list_item_icon_only' => 'on',
					),
				),
				'list_item_icon_alignment_alt'      => array(
					'label'           => esc_html__( 'Icon Alignment', 'divi_flash' ),
					'description'     => esc_html__( 'Align icon to the left, right or center.', 'divi_flash' ),
					'type'            => 'align',
					'option_category' => 'layout',
					'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'child_image_icon',
					'mobile_options'  => true,
					'show_if'         => array(
						'list_item_icon_only' => 'on',
					),
				),
				'list_item_icon_vertical_placement' => array(
					'label'            => esc_html__( 'Vertical Placement', 'et_builder' ),
					'description'      => esc_html__( 'Here you can choose where to place the icon.', 'et_builder' ),
					'type'             => 'select',
					'option_category'  => 'layout',
					'options'          => array(
						'inherit'    => et_builder_i18n( 'Default' ),
						'flex-start' => et_builder_i18n( 'Top' ),
						'center'     => et_builder_i18n( 'Center' ),
						'flex-end'   => et_builder_i18n( 'bottom' ),
					),
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'child_image_icon',
					'default_on_front' => 'inherit',
					'show_if'          => array(
						'list_item_icon_only'      => 'off',
						'list_item_icon_placement' => array( 'row', 'row-reverse' ),
					),
					'show_if_not'      => array(
						'list_item_icon_type' => 'none',
					),
					'mobile_options'   => true,
				),
				'list_item_content_outside_wrapper' => array(
					'label'            => esc_html__( 'Show Content Outside The Wrapper', 'divi_flash' ),
					'description'      => esc_html__(
						'Here you can choose whether or not your content will display outside the wrapper.',
						'divi_flash'
					),
					'type'             => 'yes_no_button',
					'option_category'  => 'configuration',
					'options'          => array(
						'off' => esc_html__( 'No', 'divi_flash' ),
						'on'  => esc_html__( 'Yes', 'divi_flash' ),
					),
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'child_image_icon',
					'default_on_front' => 'off',
					'show_if'          => array(
						'list_item_icon_only' => 'off',
					),
					'show_if_not'      => array(
						'list_item_icon_placement' => 'column',
						'list_item_icon_type'      => 'none',
					),
				),
			);
			$tooltips_fields              = array(
				'tooltip_arrow'                => array(
					'label'       => esc_html__( 'Arrow', 'divi_flash' ),
					'description' => esc_html__(
						'Here you can choose whether or not show arrow for tooltip.',
						'divi_flash'
					),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => esc_html__( 'On', 'divi_flash' ),
						'off' => esc_html__( 'Off', 'divi_flash' ),
					),
					'default'     => 'on',
					'toggle_slug' => 'child_tooltip_element',
					'show_if'     => array(
						'list_item_use_tooltip' => 'on',
					),
				),
				'tooltip_placement'            => array(
					'label'       => esc_html__( 'Placement', 'divi_flash' ),
					'description' => esc_html__( 'Here you can choose where to place the tooltip.', 'divi_flash' ),
					'type'        => 'select',
					'options'     => array(
						'top'          => esc_html__( 'Top', 'divi_flash' ),
						'top-start'    => esc_html__( 'Top Start', 'divi_flash' ),
						'top-end'      => esc_html__( 'Top End', 'divi_flash' ),
						'right'        => esc_html__( 'Right', 'divi_flash' ),
						'right-start'  => esc_html__( 'Right Start', 'divi_flash' ),
						'right-end'    => esc_html__( 'Right End', 'divi_flash' ),
						'bottom'       => esc_html__( 'Bottom', 'divi_flash' ),
						'bottom-start' => esc_html__( 'Bottom Start', 'divi_flash' ),
						'bottom-end'   => esc_html__( 'Bottom End', 'divi_flash' ),
						'left'         => esc_html__( 'Left', 'divi_flash' ),
						'left-start'   => esc_html__( 'Left Start', 'divi_flash' ),
						'left-end'     => esc_html__( 'Left End', 'divi_flash' ),
					),
					'default'     => 'top',
					'toggle_slug' => 'child_tooltip_element',
					'show_if'     => array(
						'list_item_use_tooltip' => 'on',
					),
				),
				'tooltip_animation'            => array(
					'label'       => esc_html__( 'Animation', 'divi_flash' ),
					'description' => esc_html__( 'Here you can choose animation for the tooltip.', 'divi_flash' ),
					'type'        => 'select',
					'options'     => array(
						'fade'         => esc_html__( 'fade', 'divi_flash' ),
						'scale'        => esc_html__( 'Scale', 'divi_flash' ),
						'rotate'       => esc_html__( 'Rotate', 'divi_flash' ),
						'shift-away'   => esc_html__( 'Shift-away', 'divi_flash' ),
						'shift-toward' => esc_html__( 'Shift-toward', 'divi_flash' ),
						'perspective'  => esc_html__( 'perspective', 'divi_flash' ),
					),
					'default'     => 'fade',
					'toggle_slug' => 'child_tooltip_element',
					'show_if'     => array(
						'list_item_use_tooltip' => 'on',
					),
				),
				'tooltip_trigger'              => array(
					'label'       => esc_html__( 'Trigger', 'divi_flash' ),
					'description' => esc_html__( 'Here you can choose trigger for the tooltip.', 'divi_flash' ),
					'type'        => 'select',
					'options'     => array(
						'mouseenter focus' => esc_html__( 'Hover', 'divi_flash' ),
						'click'            => esc_html__( 'Click', 'divi_flash' ),
						'mouseenter click' => esc_html__( 'Hover And Click', 'divi_flash' ),
					),
					'default'     => 'mouseenter focus',
					'toggle_slug' => 'child_tooltip_element',
					'show_if'     => array(
						'list_item_use_tooltip' => 'on',
					),
				),
				'tooltip_interactive'          => array(
					'label'       => esc_html__( 'Hover Over Tooltip', 'divi_flash' ),
					'description' => esc_html__(
						'Tooltip allowing you to hover over and click inside it.',
						'divi_flash'
					),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => esc_html__( 'On', 'divi_flash' ),
						'off' => esc_html__( 'Off', 'divi_flash' ),
					),
					'default'     => 'on',
					'toggle_slug' => 'child_tooltip_element',
					'show_if'     => array(
						'list_item_use_tooltip' => 'on',
					),
				),
				'tooltip_interactive_border'   => array(
					'label'          => esc_html__( 'Tooltip Hover Area', 'divi_flash' ),
					'description'    => esc_html__(
						'Determines the size of the invisible border around the tooltip that will prevent it from hiding if the cursor left it.',
						'divi_flash'
					),
					'type'           => 'range',
					'toggle_slug'    => 'child_tooltip_element',
					'default'        => 2,
					'allowed_units'  => array(),
					'validate_unit'  => false,
					'range_settings' => array(
						'min'  => '0',
						'max'  => '100',
						'step' => '1',
					),
					'show_if'        => array(
						'tooltip_interactive'   => 'on',
						'list_item_use_tooltip' => 'on',
					),
				),
				'tooltip_interactive_debounce' => array(
					'label'          => esc_html__( 'Tooltip Content Hide Delay', 'divi_flash' ),
					'description'    => esc_html__(
						'Determines the time in ms to debounce the Tooltip content hide handler when the cursor leaves.',
						'divi_flash'
					),
					'type'           => 'range',
					'toggle_slug'    => 'child_tooltip_element',
					'default'        => 0,
					'allowed_units'  => array(),
					'validate_unit'  => false,
					'range_settings' => array(
						'min'  => '0',
						'max'  => '1000',
						'step' => '10',
					),
					'show_if'        => array(
						'tooltip_interactive'   => 'on',
						'list_item_use_tooltip' => 'on',
					),
				),
				'tooltip_follow_cursor'        => array(
					'label'       => esc_html__( 'Follow Cursor', 'divi_flash' ),
					'description' => esc_html__( 'Tooltip move with mouse courser.', 'divi_flash' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => esc_html__( 'On', 'divi_flash' ),
						'off' => esc_html__( 'Off', 'divi_flash' ),
					),
					'default'     => 'off',
					'toggle_slug' => 'child_tooltip_element',
					'show_if'     => array(
						'list_item_use_tooltip' => 'on',
						'tooltip_trigger'       => 'mouseenter focus',
					),
				),
				'tooltip_custom_maxwidth'      => array(
					'label'          => esc_html__( 'Max Width', 'divi_flash' ),
					'description'    => esc_html__(
						'Specifies the maximum width of the tooltip. Useful to prevent it from being too horizontally wide to read.',
						'divi_flash'
					),
					'type'           => 'range',
					'toggle_slug'    => 'child_tooltip_element',
					'default'        => 350,
					'allowed_units'  => array(),
					'validate_unit'  => false,
					'range_settings' => array(
						'min'  => '0',
						'max'  => '1000',
						'step' => '1',
					),
					'show_if'        => array(
						'list_item_use_tooltip' => 'on',
					),
				),
				'tooltip_offset_enable'        => array(
					'label'       => esc_html__( 'Tooltip Distance', 'divi_flash' ),
					'description' => esc_html__(
						'Displaces the tooltip from its reference element in pixels (skidding and distance).',
						'divi_flash'
					),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => esc_html__( 'On', 'divi_flash' ),
						'off' => esc_html__( 'Off', 'divi_flash' ),
					),
					'default'     => 'off',
					'toggle_slug' => 'child_tooltip_element',
					'show_if'     => array(
						'list_item_use_tooltip' => 'on',
					),
				),
				'tooltip_offset_skidding'      => array(
					'label'          => esc_html__( 'Tooltip Arrow Move', 'divi_flash' ),
					'description'    => esc_html__(
						'The vertical distance length from content to tooltip.',
						'divi_flash'
					),
					'type'           => 'range',
					'toggle_slug'    => 'child_tooltip_element',
					'default'        => 0,
					'allowed_units'  => array(),
					'validate_unit'  => false,
					'range_settings' => array(
						'min'  => '0',
						'max'  => '1000',
						'step' => '1',
					),
					'show_if'        => array(
						'tooltip_offset_enable' => 'on',
						'list_item_use_tooltip' => 'on',
					),
				),
				'tooltip_offset_distance'      => array(
					'label'          => esc_html__( 'Tooltip Distance', 'divi_flash' ),
					'description'    => esc_html__(
						'The horizontal distance length from content to tooltip',
						'divi_flash'
					),
					'type'           => 'range',
					'toggle_slug'    => 'child_tooltip_element',
					'default'        => 10,
					'allowed_units'  => array(),
					'validate_unit'  => false,
					'range_settings' => array(
						'min'  => '0',
						'max'  => '100',
						'step' => '1',
					),
					'show_if'        => array(
						'tooltip_offset_enable' => 'on',
						'list_item_use_tooltip' => 'on',
					),
				),
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
					'hover'       => 'tabs',
					'show_if'     => array(
						'list_item_use_tooltip' => 'on',
					),
				),
			);
			$url_fields                   = array(
				'list_item_title_url'            => array(
					'label'           => esc_html__( 'Title Link URL', 'et_builder' ),
					'description'     => esc_html__(
						'If you would like to make your item a link, input your destination URL here.',
						'et_builder'
					),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'toggle_slug'     => 'link_options',
					'dynamic_content' => 'url',
				),
				'list_item_title_url_new_window' => array(
					'label'            => esc_html__( 'Title Link Target', 'et_builder' ),
					'description'      => esc_html__(
						'Here you can choose whether or not your link opens in a new window',
						'et_builder'
					),
					'type'             => 'select',
					'option_category'  => 'configuration',
					'options'          => array(
						'off' => esc_html__( 'In The Same Window', 'et_builder' ),
						'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
					),
					'toggle_slug'      => 'link_options',
					'default_on_front' => 'off',
				),
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
					'show_if_not'     => array(
						'list_item_icon_type' => 'none',
					),
					'hover'           => 'tabs',
					'mobile_options'  => true,
					'responsive'      => true,
					'sticky'          => true,
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
					'show_if_not'     => array(
						'list_item_icon_type' => 'none',
					),
					'hover'           => 'tabs',
					'mobile_options'  => true,
					'responsive'      => true,
					'sticky'          => true,
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
					'depends_show_if' => 'on',
					'show_if_not'     => array(
						'list_item_icon_type' => 'none',
					),
					'hover'           => 'tabs',
					'mobile_options'  => true,
					'responsive'      => true,
					'sticky'          => true,
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
					'depends_show_if' => 'on',
					'show_if_not'     => array(
						'list_item_icon_type' => 'none',
					),
					'hover'           => 'tabs',
					'mobile_options'  => true,
					'responsive'      => true,
					'sticky'          => true,
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
					'show_if'         => array(
						'list_item_icon_only' => 'off',
					),
					'hover'           => 'tabs',
					'mobile_options'  => true,
					'responsive'      => true,
					'sticky'          => true,
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
					'show_if'         => array(
						'list_item_icon_only' => 'off',
					),
					'hover'           => 'tabs',
					'mobile_options'  => true,
					'responsive'      => true,
					'sticky'          => true,
				),
				'list_item_title_icon_margin'    => array(
					'label'           => esc_html__( 'Title Icon Margin', 'divi_flash' ),
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

					'show_if'        => array(
						'list_item_title_icon_enable' => 'on',
					),
					'hover'          => 'tabs',
					'mobile_options' => true,
					'responsive'     => true,
					'sticky'         => true,
				),
				'list_item_title_icon_padding'   => array(
					'label'           => esc_html__( 'Title Icon Padding', 'divi_flash' ),
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

					'show_if'        => array(
						'list_item_title_icon_enable' => 'on',
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
					'show_if'         => array(
						'list_item_icon_only' => 'off',
					),
					'hover'           => 'tabs',
					'mobile_options'  => true,
					'responsive'      => true,
					'sticky'          => true,
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
					'show_if'         => array(
						'list_item_icon_only' => 'off',
					),
					'hover'           => 'tabs',
					'mobile_options'  => true,
					'responsive'      => true,
					'sticky'          => true,
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
					'depends_show_if' => 'on',
					'hover'           => 'tabs',
					'mobile_options'  => true,
					'responsive'      => true,
					'sticky'          => true,
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
					'depends_show_if' => 'on',
					'hover'           => 'tabs',
					'mobile_options'  => true,
					'responsive'      => true,
					'sticky'          => true,
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
					'show_if'         => array(
						'list_item_use_tooltip' => 'on',
					),
					'hover'           => 'tabs',
					'mobile_options'  => true,
					'responsive'      => true,
					'sticky'          => true,
				)
			);
			$general_common_fields        = array(
				'admin_label' => array(
					'label'           => et_builder_i18n( 'Admin Label' ),
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
				$text_fields,
				$title_background,
				$content_background,
				$wrapper_background,
				$tooltip_background,
				$text_associated_fields,
				$icon_image_fields,
				$lottie_fields,
				$lottie_animation_fields,
				$lottie_associated_fields,
				$icon_image_options_fields,
				$title_icon_fields,
				$title_icon_options_fields,
				$icon_image_associated_fields,
				$tooltips_fields,
				$tooltips_associated_fields,
				$url_fields,
				$custom_margin_padding_fields,
				$general_common_fields
			);
		}

		/**
		 * Declare advanced fields for the module
		 *
		 * @return array[]
		 * @since 1.0.0
		 */
		public function get_advanced_fields_config() {
			$advanced_fields = array();

			$advanced_fields['fonts']['child_icon_text']  = array(
				'label'       => esc_html__( 'Icon', 'divi_flash' ),
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
					'main'  => implode( ', ', array(
						"$this->main_css_element .item-elements .difl_icon_item_container .difl_icon_item_icon_wrapper .difl_list_icon_text",
						"$this->main_css_element .item-elements .difl_icon_item_container .difl_icon_item_icon_wrapper .difl_list_icon_text a",
					) ),
					'hover' => implode( ', ', array(
						"$this->main_css_element .item-elements .difl_icon_item_container .difl_icon_item_icon_wrapper .difl_list_icon_text",
						"$this->main_css_element .item-elements:hover .difl_icon_item_container .difl_icon_item_icon_wrapper .difl_list_icon_text a",
					) ),
				),
				'show_if'     => array(
					'list_item_icon_type' => 'text',
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_icon_text',
			);
			$advanced_fields['fonts']['child_title_text'] = array(
				'label'       => esc_html__( 'Title', 'divi_flash' ),
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
					'main'  => implode( ', ', array(
						"$this->main_css_element .item-elements .difl_icon_item_container .difl_icon_item_header",
						"$this->main_css_element .item-elements .difl_icon_item_container .difl_icon_item_header a",
					) ),
					'hover' => implode( ', ', array(
						"$this->main_css_element .item-elements:hover .difl_icon_item_container .difl_icon_item_header",
						"$this->main_css_element .item-elements:hover .difl_icon_item_container .difl_icon_item_header a",
					) ),
				),
				'show_if'     => array(
					'list_item_icon_only' => 'off',
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_title_text',
			);

			// body text
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
						"$this->main_css_element div .item-elements .difl_icon_item_body",
						"$this->main_css_element div .item-elements .difl_icon_item_body p",
					) ),
					'hover' => implode( ', ', array(
						"$this->main_css_element div .item-elements:hover .difl_icon_item_body",
						"$this->main_css_element div .item-elements:hover .difl_icon_item_body p",
					) ),
				),
				'block_elements' => array(
					'tabbed_subtoggles' => true,
					'bb_icons_support'  => true,
					'css'               => array(
						'main'  => "$this->main_css_element div .item-elements .difl_icon_item_body",
						'hover' => "$this->main_css_element div .item-elements:hover .difl_icon_item_body",
					),
				),
				'show_if'        => array(
					'list_item_icon_only' => 'off',
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
					'main'  => "$this->main_css_element div .item-elements .difl_icon_item_body h1",
					'hover' => "$this->main_css_element div .item-elements:hover .difl_icon_item_body h1",
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_content_heading',
				'sub_toggle'  => 'h1',
				'show_if'     => array(
					'list_item_icon_only' => 'off',
				),
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
					'main'  => "$this->main_css_element div .item-elements .difl_icon_item_body h2",
					'hover' => "$this->main_css_element div .item-elements:hover .difl_icon_item_body h2",
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_content_heading',
				'sub_toggle'  => 'h2',
				'show_if'     => array(
					'list_item_icon_only' => 'off',
				),
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
					'main'  => "$this->main_css_element div .item-elements .difl_icon_item_body h3",
					'hover' => "$this->main_css_element div .item-elements:hover .difl_icon_item_body h3",
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_content_heading',
				'sub_toggle'  => 'h3',
				'show_if'     => array(
					'list_item_icon_only' => 'off',
				),
			);
			$advanced_fields['fonts']['content_heading_4']  = array(
				'label'       => esc_html__( 'Heading 4', 'divi_flash' ),
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
					'main'  => "$this->main_css_element div .item-elements .difl_icon_item_body h4",
					'hover' => "$this->main_css_element div .item-elements:hover .difl_icon_item_body h4",
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_content_heading',
				'sub_toggle'  => 'h4',
				'show_if'     => array(
					'list_item_icon_only' => 'off',
				),
			);
			$advanced_fields['fonts']['content_heading_5']  = array(
				'label'       => esc_html__( 'Heading 5', 'divi_flash' ),
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
					'main'  => "$this->main_css_element div .item-elements .difl_icon_item_body h5",
					'hover' => "$this->main_css_element div .item-elements:hover .difl_icon_item_body h5",
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_content_heading',
				'sub_toggle'  => 'h5',
				'show_if'     => array(
					'list_item_icon_only' => 'off',
				),
			);
			$advanced_fields['fonts']['content_heading_6']  = array(
				'label'       => esc_html__( 'Heading 6', 'divi_flash' ),
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
					'main'  => "$this->main_css_element div .item-elements .difl_icon_item_body h6",
					'hover' => "$this->main_css_element div .item-elements:hover .difl_icon_item_body h6",
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_content_heading',
				'sub_toggle'  => 'h6',
				'show_if'     => array(
					'list_item_icon_only' => 'off',
				),
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
					'hover' => "$this->tooltip_css_element:hover",
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
					'hover' => "$this->tooltip_css_element:hover h1",
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
					'hover' => "$this->tooltip_css_element:hover h2",
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
					'hover' => "$this->tooltip_css_element:hover h3",
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_tooltip_heading',
				'sub_toggle'  => 'h3',
			);
			$advanced_fields['fonts']['tooltip_heading_4']  = array(
				'label'       => esc_html__( 'Heading 4', 'divi_flash' ),
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
					'main'  => "$this->tooltip_css_element h4",
					'hover' => "$this->tooltip_css_element:hover h4",
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
					'default' => '500',
				),
				'line_height' => array(
					'default' => '1.7',
				),
				'css'         => array(
					'main'  => "$this->tooltip_css_element h5",
					'hover' => "$this->tooltip_css_element:hover h5",
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
					'default' => '500',
				),
				'line_height' => array(
					'default' => '1.7',
				),
				'css'         => array(
					'main'  => "$this->tooltip_css_element h6",
					'hover' => "$this->main_css_element:hover h6",
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'child_tooltip_heading',
				'sub_toggle'  => 'h6',
			);

			// main background (module)
			$advanced_fields['background'] = array(
				'settings' => array(
					'color' => 'alpha',
				),
				'css'      => array(
					'main'  => $this->main_css_element,
					'hover' => "$this->main_css_element:hover",
				),
			);

			$advanced_fields['child_image_icon'] = array(
				'css' => array(
					'main' => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper .icon-element",
				),
			);

			$advanced_fields['borders']['default']               = array();
			$advanced_fields['borders']['child_image_icon']      = array(
				'label_prefix' => et_builder_i18n( 'Icon' ),
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'child_image_icon',
				'css'          => array(
					'main' => array(
						'border_radii'        => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper .icon-element",
						'border_radii_hover'  => "$this->main_css_element .item-elements:hover .difl_icon_item_icon_wrapper .icon-element",
						'border_styles'       => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper .icon-element",
						'border_styles_hover' => "$this->main_css_element .item-elements:hover .difl_icon_item_icon_wrapper .icon-element",
					),
				),
			);
			$advanced_fields['borders']['child_title_element']   = array(
				'label_prefix' => et_builder_i18n( 'Title' ),
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'child_title_element',
				'css'          => array(
					'main' => array(
						'border_radii'        => "$this->main_css_element div .item-elements .difl_icon_item_header",
						'border_radii_hover'  => "$this->main_css_element div .item-elements:hover .difl_icon_item_header",
						'border_styles'       => "$this->main_css_element div .item-elements .difl_icon_item_header",
						'border_styles_hover' => "$this->main_css_element div .item-elements:hover .difl_icon_item_header",
					),
				),
			);
			$advanced_fields['borders']['child_content_element'] = array(
				'label_prefix' => et_builder_i18n( 'Body' ),
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'child_content_element',
				'css'          => array(
					'main' => array(
						'border_radii'        => "$this->main_css_element div .item-elements .difl_icon_item_body",
						'border_radii_hover'  => "$this->main_css_element div .item-elements:hover .difl_icon_item_body",
						'border_styles'       => "$this->main_css_element div .item-elements .difl_icon_item_body",
						'border_styles_hover' => "$this->main_css_element div .item-elements:hover .difl_icon_item_body",
					),
				),
			);
			$advanced_fields['borders']['child_wrapper_element'] = array(
				'label_prefix' => et_builder_i18n( 'Wrapper' ),
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'child_wrapper_element',
				'css'          => array(
					'main' => array(
						'border_radii'        => "$this->main_css_element div .item-elements",
						'border_radii_hover'  => "$this->main_css_element div .item-elements:hover",
						'border_styles'       => "$this->main_css_element div .item-elements",
						'border_styles_hover' => "$this->main_css_element div .item-elements:hover",
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
						'border_styles_hover' => "$this->tooltip_css_element:hover",
					),
				),
			);

			$advanced_fields['box_shadow']['default']               = array();
			$advanced_fields['box_shadow']['child_image_icon']      = array(
				'label'             => et_builder_i18n( 'Icon Box Shadow' ),
				'option_category'   => 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'child_image_icon',
				'css'               => array(
					'main'    => "$this->main_css_element div .item-elements .difl_icon_item_icon_wrapper .icon-element",
					'hover'   => "$this->main_css_element div .item-elements:hover .difl_icon_item_icon_wrapper .icon-element",
					'overlay' => 'inset',
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
					'main'  => "$this->main_css_element div .item-elements .difl_icon_item_header",
					'hover' => "$this->main_css_element div .item-elements:hover .difl_icon_item_header",
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
					'main'  => "$this->main_css_element div .item-elements .difl_icon_item_body",
					'hover' => "$this->main_css_element div .item-elements:hover .difl_icon_item_body",
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
					'main'  => "$this->main_css_element div .item-elements",
					'hover' => "$this->main_css_element div .item-elements:hover",
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
					'position' => 'outer',
				),
			);

			$advanced_fields['filters'] = array(
				'child_filters_target' => array(
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'child_image_icon',
					'show_if'     => array(
						'list_item_icon_type' => 'image',
					),
					'css'         => array(
						'main'  => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper .icon-element",
						'hover' => "$this->main_css_element .item-elements:hover .difl_icon_item_icon_wrapper .icon-element",
					),
				),
			);

			$advanced_fields['margin_padding'] = array(
				'use_padding' => true,
				'use_margin'  => true,
				'css'         => array(
					'margin'    => $this->main_css_element,
					'padding'   => $this->main_css_element,
					'important' => 'all',
				),
			);

			$advanced_fields['max_width'] = array(
				'css' => array(
					'main'             => $this->main_css_element,
					'module_alignment' => "$this->main_css_element.et_pb_module",
				),
			);

			$advanced_fields['image_icon'] = false;
			$advanced_fields['text']       = false;
			$advanced_fields['button']     = false;

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
					'label'    => esc_html__( 'Icon', 'divi_flash' ),
					'selector' => 'span.difl_icon_item_container span.difl_icon_item_icon_wrapper span.et-pb-icon',
				),
				'list_item_image'          => array(
					'label'    => esc_html__( 'Image', 'divi_flash' ),
					'selector' => 'span.difl_icon_item_container span.difl_icon_item_icon_wrapper img',
				),
				'list_item_icon_text'      => array(
					'label'    => esc_html__( 'Icon Text', 'divi_flash' ),
					'selector' => 'span.difl_icon_item_container span.difl_icon_item_icon_wrapper span.difl_list_icon_text',
				),
				'list_item_icon_wrapper'   => array(
					'label'    => esc_html__( 'Icon Wrapper', 'divi_flash' ),
					'selector' => 'span.difl_icon_item_container span.difl_icon_item_icon_wrapper',
				),
				'list_item_title'          => array(
					'label'    => esc_html__( 'Item Title', 'divi_flash' ),
					'selector' => '.difl_icon_item_content_wrapper .difl_icon_item_header',
				),
				'list_item_title_icon'     => array(
					'label'    => esc_html__( 'Item Title Icon', 'divi_flash' ),
					'selector' => 'span.difl_icon_item_container .difl_icon_item_header span.et-pb-icon',
				),
				'list_item_content'        => array(
					'label'    => esc_html__( 'Item Body', 'divi_flash' ),
					'selector' => 'div .item-elements .difl_icon_item_body',
				),
				'list_item_item_container' => array(
					'label'    => esc_html__( 'Item Container', 'divi_flash' ),
					'selector' => 'div .item-elements .difl_icon_item_container',
				),
				'list_item_item_wrapper'   => array(
					'label'    => esc_html__( 'Item Wrapper', 'divi_flash' ),
					'selector' => 'div .item-elements',
				),
				'list_item_item_tooltip'   => array(
					'label'    => esc_html__( 'Item Tooltip', 'divi_flash' ),
					'selector' => $this->tooltip_css_element,
				),
			);
		}

		/**
		 * Get CSS fields transition.
		 *
		 * Add form field options group and background image on the fields list.
		 *
		 *
		 * @since 1.0.0
		 */
		public function get_transition_fields_css_props() {
			$fields                         = parent::get_transition_fields_css_props();
			$fields['list_item_icon_color'] = array(
				'color' => "$this->main_css_element span.difl_icon_item_container span.difl_icon_item_icon_wrapper span.et-pb-icon",
			);

			$fields['list_item_title_icon_color'] = array(
				'color' => "$this->main_css_element span.difl_icon_item_container .difl_icon_item_header span.et-pb-icon",
			);

			$fields['list_item_icon_size'] = array(
				'font-size' => "$this->main_css_element span.difl_icon_item_container span.difl_icon_item_icon_wrapper span.et-pb-icon",
			);

			$fields['list_item_title_icon_size'] = array(
				'font-size' => "$this->main_css_element span.difl_icon_item_container .difl_icon_item_header span.et-pb-icon",
			);

			$fields['list_item_icon_bg_color'] = array(
				'background-color' => "$this->main_css_element .item-elements span.difl_icon_item_icon_wrapper .icon-element",
			);

			// Background transition
			$fields = $this->df_background_transition(
				array(
					'fields'   => $fields,
					'key'      => 'list_item_title_background',
					'selector' => "$this->main_css_element span.difl_icon_item_container .difl_icon_item_header",
				)
			);
			$fields = $this->df_background_transition(
				array(
					'fields'   => $fields,
					'key'      => 'list_item_content_background',
					'selector' => "$this->main_css_element div .item-elements  .difl_icon_item_body",
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
				"$this->main_css_element .difl_icon_item_icon_wrapper .icon-element"
			);
			$fields = $this->df_fix_border_transition(
				$fields,
				'child_title_element',
				"$this->main_css_element div .item-elements .difl_icon_item_header"
			);
			$fields = $this->df_fix_border_transition(
				$fields,
				'child_content_element',
				"$this->main_css_element div .item-elements .difl_icon_item_body"
			);
			$fields = $this->df_fix_border_transition(
				$fields,
				'child_wrapper_element',
				"$this->main_css_element div .item-elements"
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
				"$this->main_css_element .difl_icon_item_icon_wrapper .icon-element"
			);
			$fields = $this->df_fix_box_shadow_transition(
				$fields,
				'child_title_element',
				"$this->main_css_element div .item-elements .difl_icon_item_header"
			);
			$fields = $this->df_fix_box_shadow_transition(
				$fields,
				'child_content_element',
				"$this->main_css_element div .item-elements .difl_icon_item_body"
			);
			$fields = $this->df_fix_box_shadow_transition(
				$fields,
				'child_wrapper_element',
				"$this->main_css_element div .item-elements"
			);
			$fields = $this->df_fix_box_shadow_transition(
				$fields,
				'child_tooltip_element',
				$this->tooltip_css_element
			);

			// set transition for custom spacing
			$fields['list_item_icon_margin']          = array(
				'margin' => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper .icon-element",
			);
			$fields['list_item_icon_padding']         = array(
				'padding' => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper .icon-element",
			);
			$fields['list_item_icon_wrapper_margin']  = array(
				'margin' => "$this->main_css_element .item-elements span.difl_icon_item_icon_wrapper",
			);
			$fields['list_item_icon_wrapper_padding'] = array(
				'padding' => "$this->main_css_element .item-elements span.difl_icon_item_icon_wrapper",
			);
			$fields['list_item_title_margin']         = array(
				'margin' => "$this->main_css_element .item-elements span.difl_icon_item_container .difl_icon_item_header",
			);
			$fields['list_item_title_padding']        = array(
				'padding' => "$this->main_css_element .item-elements span.difl_icon_item_container .difl_icon_item_header",
			);
			$fields['list_item_title_icon_margin']    = array(
				'margin' => "$this->main_css_element .item-elements span.difl_icon_item_container .difl_icon_item_header span.et-pb-icon",
			);
			$fields['list_item_title_icon_padding']   = array(
				'padding' => "$this->main_css_element .item-elements span.difl_icon_item_container .difl_icon_item_header span.et-pb-icon",
			);
			$fields['list_item_content_margin']       = array(
				'margin' => "$this->main_css_element .item-elements .item-elements-group .difl_icon_item_body",
			);
			$fields['list_item_content_padding']      = array(
				'padding' => "$this->main_css_element .item-elements .item-elements-group .difl_icon_item_body",
			);
			$fields['list_item_wrapper_margin']       = array(
				'margin' => "$this->main_css_element div .item-elements",
			);
			$fields['list_item_wrapper_padding']      = array(
				'padding' => "$this->main_css_element div .item-elements",
			);
			$fields['list_item_tooltip_padding']      = array(
				'padding' => $this->tooltip_css_element,
			);


			$fields['list_item_image_width'] = array(
				'width' => "$this->main_css_element span.difl_icon_item_container span.difl_icon_item_icon_wrapper img",
			);

			$fields['list_item_image_height'] = array(
				'height' => "$this->main_css_element span.difl_icon_item_container span.difl_icon_item_icon_wrapper img",
			);

			$fields['list_item_content_max_width'] = array(
				'max-width' => "$this->main_css_element .item-elements",
			);

			$fields['background_layout'] = array(
				'color' => "$this->main_css_element .difl_icon_item_header, $this->main_css_element div .item-elements .difl_icon_item_body",
			);

			$fields['body_text_color'] = array(
				'color' => "$this->main_css_element div .item-elements .difl_icon_item_body",
			);

			return $fields;
		}

		/**
		 * Wrap module's rendered output with proper module wrapper. Ensuring module has consistent
		 * wrapper output which compatible with module attribute and background insertion.
		 *
		 *
		 * @param string $output      Module's rendered output.
		 * @param string $render_slug Slug of module that is used for rendering output.
		 *
		 * @return string
		 */
		public function _render_module_wrapper( $output = '', $render_slug = '' ) {
			$wrapper_settings    = $this->get_wrapper_settings( $render_slug );
			$slug                = $render_slug;
			$outer_wrapper_attrs = $wrapper_settings['attrs'];
			$inner_wrapper_attrs = $wrapper_settings['inner_attrs'];

			/**
			 * Filters the HTML attributes for the module's outer wrapper. The dynamic portion of the
			 * filter name, '$slug', corresponds to the module's slug.
			 *
			 *
			 * @param string[]           $outer_wrapper_attrs
			 * @param ET_Builder_Element $module_instance
			 */
			$outer_wrapper_attrs = apply_filters(
				"et_builder_module_{$slug}_outer_wrapper_attrs",
				$outer_wrapper_attrs,
				$this
			);

			/**
			 * Filters the HTML attributes for the module's inner wrapper. The dynamic portion of the
			 * filter name, '$slug', corresponds to the module's slug.
			 *
			 * @param string[]           $inner_wrapper_attrs
			 * @param ET_Builder_Element $module_instance
			 */
			$inner_wrapper_attrs = apply_filters(
				"et_builder_module_{$slug}_inner_wrapper_attrs",
				$inner_wrapper_attrs,
				$this
			);

			return sprintf(
				'<li%1$s>
				%2$s
				%3$s
				%6$s
				%7$s
				%8$s
				%9$s
				<div%4$s>
					%5$s
				</div>
			</li>',
				et_html_attrs( $outer_wrapper_attrs ),
				$wrapper_settings['parallax_background'],
				$wrapper_settings['video_background'],
				et_html_attrs( $inner_wrapper_attrs ),
				$output,
				et_()->array_get( $wrapper_settings, 'video_background_tablet' ),
				et_()->array_get( $wrapper_settings, 'video_background_phone' ),
				et_core_esc_previously( $wrapper_settings['pattern_background'] ), // #8
				et_core_esc_previously( $wrapper_settings['mask_background'] ) // #9
			);
		}

		/**
		 * Renders the module output.
		 *
		 * @param array  $attrs       List of attributes.
		 * @param string $content     Content being processed.
		 * @param string $render_slug Slug of module that is used for rendering output.
		 *
		 * @return string
		 */
		public function render( $attrs, $content, $render_slug ) {
			$this->handle_fa_icon();
			$multi_view = et_pb_multi_view_options( $this );

			return sprintf(
				'<span class="item-elements et_pb_with_background">
                    <span class="item-elements-group"><span class="difl_icon_item_container">%2$s %1$s</span>%3$s</span>
                    <span class="item-tooltip-data" style="display:none">%4$s</span>
                </span>',
				et_core_esc_previously( $this->render_icon_item_body( $multi_view ) ),
				et_core_esc_previously( $this->render_item_icon( $multi_view ) ),
				et_core_esc_previously( $this->render_icon_item_body_outer_wrapper( $multi_view ) ),
				et_core_esc_previously( $this->render_icon_item_tooltip_text( $multi_view ) )
			);
		}

		/**
		 * Render item body with title and content
		 *
		 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
		 *
		 * @return null|string
		 */
		private function render_icon_item_body( $multi_view ) {
			$_is_outside = $this->props['list_item_content_outside_wrapper'];

			if ( $this->props['list_item_icon_only'] === 'off' ) {
				$this->df_process_bg(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_title_background',
						'selector'    => "$this->main_css_element .item-elements span.difl_icon_item_container .difl_icon_item_header",
						'hover'       => "$this->main_css_element .item-elements:hover span.difl_icon_item_container .difl_icon_item_header",
					)
				);
				$this->df_process_bg(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_content_background',
						'selector'    => "$this->main_css_element div .item-elements .difl_icon_item_body",
						'hover'       => "$this->main_css_element div .item-elements:hover .difl_icon_item_body",
					)
				);
				$this->df_process_bg(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_wrapper_background',
						'selector'    => "$this->main_css_element .item-elements",
						'hover'       => "$this->main_css_element .item-elements:hover",
						'important'   => true,
					)
				);

				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_text_orientation',
						'selector'       => "$this->main_css_element .item-elements *:not(.difl_icon_item_icon_wrapper)",
						'css_property'   => 'text-align',
						'render_slug'    => $this->slug,
						'type'           => 'align',
						'important'      => true,
					)
				);

				$this->set_margin_padding_styles(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_title_margin',
						'type'        => 'margin',
						'selector'    => "$this->main_css_element .item-elements span.difl_icon_item_container .difl_icon_item_header",
						'hover'       => "$this->main_css_element .item-elements:hover span.difl_icon_item_container .difl_icon_item_header",
					)
				);
				$this->set_margin_padding_styles(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_title_padding',
						'type'        => 'padding',
						'selector'    => "$this->main_css_element .item-elements span.difl_icon_item_container .difl_icon_item_header",
						'hover'       => "$this->main_css_element .item-elements:hover span.difl_icon_item_container .difl_icon_item_header",
					)
				);
				$this->set_margin_padding_styles(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_content_margin',
						'type'        => 'margin',
						'selector'    => "$this->main_css_element .item-elements .item-elements-group .difl_icon_item_body",
						'hover'       => "$this->main_css_element .item-elements:hover .item-elements-group .difl_icon_item_body",
					)
				);
				$this->set_margin_padding_styles(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_content_padding',
						'type'        => 'padding',
						'selector'    => "$this->main_css_element .item-elements .item-elements-group .difl_icon_item_body",
						'hover'       => "$this->main_css_element .item-elements:hover .item-elements-group .difl_icon_item_body",
					)
				);
				$this->set_margin_padding_styles(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_wrapper_margin',
						'type'        => 'margin',
						'selector'    => "$this->main_css_element div .item-elements",
						'hover'       => "$this->main_css_element div .item-elements:hover",
					)
				);
				$this->set_margin_padding_styles(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_wrapper_padding',
						'type'        => 'padding',
						'selector'    => "$this->main_css_element div .item-elements",
						'hover'       => "$this->main_css_element div .item-elements:hover",
					)
				);

				$outside_wrapper = $_is_outside === 'off' ? $this->render_icon_item_body_text( $multi_view ) : null;

				return sprintf(
					'<span class="difl_icon_item_content_wrapper">%1$s%2$s</span>',
					et_core_esc_previously( $this->render_icon_item_title_text( $multi_view ) ),
					et_core_esc_previously( $outside_wrapper )
				);
			}

			return null;
		}

		/**
		 * Render item body with title and content
		 *
		 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
		 *
		 * @return string
		 */
		private function render_icon_item_body_text( $multi_view ) {
			$body_classes = $this->df_iconlist_add_background_class(
				array(
					'background_field' => 'list_item_content_background',
					'classes'          => array(
						'difl_icon_item_body',
					),
				)
			);

			$implode_classes = implode( ' ', $body_classes );

			$item_body_text = $multi_view->render_element(
				array(
					'tag'     => 'span',
					'content' => '{{content}}',
					'attrs'   => array(
						'class' => $implode_classes,
					),
				)
			);

			if ( '' !== $item_body_text ) {
				return $item_body_text;
			}

			return null;
		}

		/**
		 * Render item body with title and content
		 *
		 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
		 *
		 * @return null|string
		 */
		private function render_icon_item_title_text( $multi_view ) {
			$icon_title_tag        = isset( $this->props['list_item_title_tag'] ) ? $this->props['list_item_title_tag'] : 'h4';
			$icon_title_url        = isset( $this->props['list_item_title_url'] ) ? $this->props['list_item_title_url'] : '';
			$icon_title_url_target = isset( $this->props['list_item_title_url_new_window'] ) ? $this->props['list_item_title_url_new_window'] : '';

			$title_tag   = '' !== $icon_title_url ? 'a' : 'span';
			$title_attrs = [];

			if ( 'a' === $title_tag ) {
				$title_attrs['href'] = $icon_title_url;

				if ( 'on' === $icon_title_url_target ) {
					$title_attrs['target'] = '_blank';
				}
			}

			$title_text = $multi_view->render_element(
				array(
					'tag'     => $title_tag,
					'content' => '{{list_item_title}}',
					'attrs'   => $title_attrs,
				)
			);

			if ( '' !== $title_text ) {
				$body_classes = $this->df_iconlist_add_background_class(
					array(
						'background_field' => 'list_item_title_background',
						'classes'          => array(
							'difl_icon_item_header',
						),
					)
				);

				$implode_classes = implode( ' ', $body_classes );

				return sprintf(
					'<%1$s class="%4$s">%2$s%3$s</%1$s>',
					et_core_esc_previously( $icon_title_tag ),
					et_core_esc_previously( $title_text ),
					et_core_esc_previously( $this->render_item_title_font_icon() ),
					et_core_esc_previously( $implode_classes )
				);
			}

			return null;
		}

		/**
		 * Render item title icon
		 *
		 * @return null|string
		 */
		private function render_item_title_font_icon() {
			if ( $this->props['list_item_title_icon_enable'] === 'on'
			     && $this->props['list_item_icon_only'] === 'off' ) {
				$icon_classes = array( 'et-pb-icon', 'difl_list_title_icon' );

				if ( $this->props['list_item_title_icon_on_hover'] !== 'on' ) {
					$icon_classes[] = 'always_show';
				}

				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_title_icon_color',
						'selector'       => "$this->main_css_element .item-elements span.difl_icon_item_container .difl_icon_item_header span.et-pb-icon",
						'hover_selector' => "$this->main_css_element .item-elements:hover span.difl_icon_item_container .difl_icon_item_header span.et-pb-icon",
						'css_property'   => 'color',
						'render_slug'    => $this->slug,
						'type'           => 'color',
						'important'      => true,
					)
				);
				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_title_icon_size',
						'selector'       => "$this->main_css_element .item-elements span.difl_icon_item_container .difl_icon_item_header span.et-pb-icon",
						'hover_selector' => "$this->main_css_element .item-elements:hover span.difl_icon_item_container .difl_icon_item_header span.et-pb-icon",
						'css_property'   => 'font-size',
						'render_slug'    => $this->slug,
						'type'           => 'range',
						'important'      => true,
					)
				);

				// Icon margin and padding with default, responsive, hover
				$this->set_margin_padding_styles(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_title_icon_margin',
						'type'        => 'margin',
						'selector'    => "$this->main_css_element .item-elements span.difl_icon_item_container .difl_icon_item_header span.et-pb-icon",
						'hover'       => "$this->main_css_element .item-elements:hover span.difl_icon_item_container .difl_icon_item_header span.et-pb-icon",
					)
				);
				$this->set_margin_padding_styles(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_title_icon_padding',
						'type'        => 'padding',
						'selector'    => "$this->main_css_element .item-elements span.difl_icon_item_container .difl_icon_item_header span.et-pb-icon",
						'hover'       => "$this->main_css_element .item-elements:hover span.difl_icon_item_container .difl_icon_item_header span.et-pb-icon",
					)
				);

				$icon_prop = 'list_item_title_icon';
				$icon_data = ! empty( $this->props[ $icon_prop ] ) ? $this->props[ $icon_prop ] : '&#x49;||divi||400';

				difl_inject_fa_icons( $icon_data );

				$this->generate_styles(
					array(
						'utility_arg'    => 'icon_font_family',
						'render_slug'    => $this->slug,
						'base_attr_name' => 'list_item_title_icon',
						'important'      => true,
						'selector'       => "$this->main_css_element .difl_icon_item_header span.et-pb-icon",
						'processor'      => array(
							'ET_Builder_Module_Helper_Style_Processor',
							'process_extended_icon',
						),
					)
				);

				return sprintf(
					'<span class="%2$s">%1$s</span>',
					et_pb_process_font_icon( $icon_data ),
					implode( ' ', $icon_classes )
				);
			}

			return null;
		}

		/**
		 * Render item icon
		 *
		 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
		 *
		 * @return null|string
		 */
		private function render_item_font_icon( $multi_view ) {
			if ( $this->props['list_item_icon_type'] === 'icon' ) {
				$icon_classes = array( 'et-pb-icon', 'difl_list_icon' );

				$this->df_process_color(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_icon_color',
						'type'        => 'color',
						'selector'    => "$this->main_css_element .item-elements span.difl_icon_item_container span.difl_icon_item_icon_wrapper span.et-pb-icon",
						'hover'       => "$this->main_css_element .item-elements:hover span.difl_icon_item_container span.difl_icon_item_icon_wrapper span.et-pb-icon",
					)
				);

				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_icon_size',
						'selector'       => "$this->main_css_element .item-elements span.difl_icon_item_container span.difl_icon_item_icon_wrapper span.et-pb-icon",
						'hover_selector' => "$this->main_css_element .item-elements:hover span.difl_icon_item_container span.difl_icon_item_icon_wrapper span.et-pb-icon",
						'css_property'   => 'font-size',
						'render_slug'    => $this->slug,
						'type'           => 'range',
						'important'      => true,
					)
				);

				difl_inject_fa_icons( $this->props['list_item_icon'] );

				$this->generate_styles(
					array(
						'utility_arg'    => 'icon_font_family',
						'render_slug'    => $this->slug,
						'base_attr_name' => 'list_item_icon',
						'important'      => true,
						'selector'       => "$this->main_css_element .item-elements span.difl_icon_item_container span.difl_icon_item_icon_wrapper span.et-pb-icon",
						'processor'      => array(
							'ET_Builder_Module_Helper_Style_Processor',
							'process_extended_icon',
						),
					)
				);

				return $multi_view->render_element(
					array(
						'content' => '{{list_item_icon}}',
						'attrs'   => array(
							'class' => implode( ' ', $icon_classes ),
						),
					)
				);
			}

			return null;
		}

		/**
		 * Render item image
		 *
		 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
		 *
		 * @return null|string
		 */
		private function render_item_icon_image( $multi_view ) {
			if ( $this->props['list_item_icon_type'] === 'image' && ! empty( $this->props['list_item_image'] ) ) {
				$alt_text      = $this->_esc_attr( 'alt' );
				$image_classes = [ 'et_pb_image_wrap' ];

				$image_attachment_class = et_pb_media_options()->get_image_attachment_class(
					$this->props,
					'list_item_image'
				);

				if ( ! empty( $image_attachment_class ) ) {
					$image_classes[] = esc_attr( $image_attachment_class );
				}

				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_image_width',
						'selector'       => "$this->main_css_element .item-elements span.difl_icon_item_container span.difl_icon_item_icon_wrapper img",
						'hover_selector' => "$this->main_css_element .item-elements:hover span.difl_icon_item_container span.difl_icon_item_icon_wrapper img",
						'css_property'   => 'width',
						'render_slug'    => $this->slug,
						'type'           => 'range',
						'important'      => true,
					)
				);

				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_image_height',
						'selector'       => "$this->main_css_element .item-elements span.difl_icon_item_container span.difl_icon_item_icon_wrapper img",
						'hover_selector' => "$this->main_css_element .item-elements:hover span.difl_icon_item_container span.difl_icon_item_icon_wrapper img",
						'css_property'   => 'height',
						'render_slug'    => $this->slug,
						'type'           => 'range',
						'important'      => true,
					)
				);

				return $multi_view->render_element(
					array(
						'tag'      => 'img',
						'attrs'    => array(
							'src'   => '{{list_item_image}}',
							'class' => implode( ' ', $image_classes ),
							'alt'   => $alt_text,
						),
						'required' => 'list_item_image',
					)
				);
			}

			return null;
		}

		/**
		 * Render item image
		 *
		 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
		 *
		 * @return null|string
		 */
		private function render_item_icon_text( $multi_view ) {
			if ( $this->props['list_item_icon_type'] === 'text' && ! empty( $this->props['list_item_icon_text'] ) ) {
				$icon_text_classes = [ 'difl_list_icon_text' ];

				return $multi_view->render_element(
					array(
						'content' => '{{list_item_icon_text}}',
						'attrs'   => array(
							'class' => implode( ' ', $icon_text_classes ),
						),
					)
				);
			}

			return null;
		}

		/**
		 * Render item lottie image
		 *
		 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
		 *
		 * @return null|string
		 */
		private function render_item_icon_lottie( $multi_view ) {
			if ( $this->props['list_item_icon_type'] === 'lottie'
			     && (
				     ! empty( $this->props['list_item_icon_lottie_src_upload'] )
				     || ! empty( $this->props['list_item_icon_lottie_src_remote'] )
			     )
			) {
				$lottie_image_classes = array( 'difl_lottie_player', 'lottie-player-container' );
				
				wp_enqueue_script( 'df-lottie-lib' );
				
			
				// Set background color for Icon
				$this->df_process_color(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_icon_lottie_color',
						'type'        => 'fill',
						'selector'    => "$this->main_css_element .item-elements .difl_lottie_player svg path",
						'hover'       => "$this->main_css_element .item-elements:hover .difl_lottie_player svg path",
					)
				);

				$this->df_process_color(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_icon_lottie_background_color',
						'type'        => 'background-color',
						'selector'    => "$this->main_css_element .item-elements .difl_lottie_player",
						'hover'       => "$this->main_css_element .item-elements:hover .difl_lottie_player",
					)
				);

				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_icon_lottie_width',
						'selector'       => "$this->main_css_element .item-elements .difl_lottie_player",
						'css_property'   => 'width',
						'render_slug'    => $this->slug,
						'type'           => 'range',
						'important'      => true,
					)
				);

				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_icon_lottie_height',
						'selector'       => "$this->main_css_element .item-elements .difl_lottie_player",
						'css_property'   => 'height',
						'render_slug'    => $this->slug,
						'type'           => 'range',
						'important'      => true,
					)
				);

				// Generate configuration for lottie animation
				$lottie_type     = isset( $this->props['list_item_icon_lottie_src_type'] ) ? $this->props['list_item_icon_lottie_src_type'] : '';
				$lottie_src_prop = $lottie_type === 'local' ? '{{list_item_icon_lottie_src_upload}}' : '{{list_item_icon_lottie_src_remote}}';

				// General Settings
				$output_renderer = isset( $this->props['list_item_icon_lottie_renderer'] ) ? $this->props['list_item_icon_lottie_renderer'] : 'svg';
				$play_speed      = isset( $this->props['list_item_icon_lottie_speed'] ) ? $this->props['list_item_icon_lottie_speed'] : '1';
				$play_direction  = isset( $this->props['list_item_icon_lottie_direction'] ) ? $this->props['list_item_icon_lottie_direction'] : 'off';

				// Conditional Settings
				$play_loop           = isset( $this->props['list_item_icon_lottie_loop'] ) && $this->props['list_item_icon_lottie_loop'] === 'on';
				$play_trigger_method = isset( $this->props['list_item_icon_lottie_trigger_method'] ) ? $this->props['list_item_icon_lottie_trigger_method'] : 'viewport';

				// Interactivity Settings
				$play_with_delay = isset( $this->props['list_item_icon_lottie_delay'] ) && $play_trigger_method === 'viewport' ? $this->props['list_item_icon_lottie_delay'] : '0';
				$anim_mouse_out  = isset( $this->props['list_item_icon_lottie_mouseout_action'] ) ? $this->props['list_item_icon_lottie_mouseout_action'] : 'off';
				$scroll_effect   = isset( $this->props['list_item_icon_lottie_scroll_effect'] ) ? $this->props['list_item_icon_lottie_scroll_effect'] : 'off';

				// migration
				if ( in_array( $play_trigger_method, array( 'play-once', 'freeze-click' ) ) ) {
					$play_trigger_method = 'viewport';
				}

				$lottie_image_options = array(
					// General Options
					'renderer'          => $output_renderer,
					'speed'             => $play_speed,
					'direction_reverse' => $play_direction,
					'loop'              => $play_loop,

					// Interactive Options
					'delay'             => (int) $play_with_delay,
					'mode'              => 'normal',
					'interaction'       => $play_trigger_method,
					'scroll_effect'     => $scroll_effect,
				);

				// Set mouse out event for hover interactivity with lottie image.
				$old_values = array( '', 'no_action', 'off' );
				if ( $play_trigger_method === 'hover' && ! in_array( $anim_mouse_out, $old_values, true ) ) {
					$lottie_image_options['mouse_out_event'] = $anim_mouse_out;
				}

				return $multi_view->render_element(
					array(
						'tag'   => 'span',
						'attrs' => array(
							'class'        => implode( ' ', $lottie_image_classes ),
							'data-src'     => $lottie_src_prop,
							'data-options' => wp_json_encode( $lottie_image_options ),
						),
					)
				);
			}

			return null;
		}

		/**
		 * Render item icon which on are active
		 *
		 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
		 *
		 * @return string
		 */
		private function render_item_icon( $multi_view ) {
			if ( $this->props['list_item_icon_type'] !== 'none'
			     && (
				     null !== $this->render_item_font_icon( $multi_view )
				     || null !== $this->render_item_icon_image( $multi_view )
				     || null !== $this->render_item_icon_text( $multi_view )
				     || null !== $this->render_item_icon_lottie( $multi_view )
			     )
			) {
				$icon_wrapper_class = [ 'difl_icon_item_icon_wrapper' ];
				$lottie_renderer    = isset( $this->props['list_item_icon_lottie_renderer'] ) ? $this->props['list_item_icon_lottie_renderer'] : 'svg';

				if ( $this->props['list_item_icon_only'] === 'on' ) {
					$icon_wrapper_class[] = 'icon_only';
				}

				// Start the effect : Show icon on hover
				if ( $this->props['list_item_icon_on_hover'] === 'on' && $this->props['list_item_icon_only'] === 'off' ) {
					$icon_wrapper_class[] = 'show_on_hover';

					// set icon placement for button image with default, hover and responsive
					$this->df_iconlist_show_icon_on_hover_styles(
						array(
							'field'         => 'list_item_icon_placement',
							'trigger'       => 'list_item_icon_type',
							'dependsOn'     => array(
								'icon'   => 'list_item_icon_size',
								'image'  => 'list_item_image_width',
								'lottie' => 'list_item_icon_lottie_width',
							),
							'selector'      => "$this->main_css_element .item-elements span.difl_icon_item_container span.difl_icon_item_icon_wrapper.show_on_hover",
							'hover'         => "$this->main_css_element .item-elements:hover span.difl_icon_item_container span.difl_icon_item_icon_wrapper.show_on_hover",
							'css_property'  => 'margin',
							'type'          => 'margin',
							'allowedUnits'  => array(
								'%',
								'em',
								'rem',
								'px',
								'cm',
								'mm',
								'in',
								'pt',
								'pc',
								'ex',
								'vh',
								'vw',
							),
							'mappingValues' => array(
								'row'            => '0 #px 0 -#px',
								'row-reverse'    => '0 -#px 0 #px',
								'column'         => '-#px 0 #px 0',
								'column-reverse' => '#px 0 -#px 0',
							),
							'defaults'      => array(
								'icon'   => '40px',
								'image'  => '40px',
								'lottie' => '40px',
								'field'  => 'row',
							),
						)
					);
				}
				// End the effect : Show icon on hover

				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_icon_bg_color',
						'selector'       => "$this->main_css_element .item-elements span.difl_icon_item_icon_wrapper .icon-element",
						'hover_selector' => "$this->main_css_element .item-elements:hover span.difl_icon_item_icon_wrapper .icon-element",
						'css_property'   => 'background-color',
						'render_slug'    => $this->slug,
						'type'           => 'color',
						'important'      => true,
					)
				);

				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_icon_text_gap',
						'selector'       => "$this->main_css_element .item-elements span.difl_icon_item_container",
						'hover_selector' => "$this->main_css_element .item-elements:hover span.difl_icon_item_container",
						'css_property'   => 'gap',
						'render_slug'    => $this->slug,
						'type'           => 'range',
						'important'      => true,
					)
				);


				if ( $this->props['list_item_icon_placement'] !== 'inherit' ) {
					$this->generate_styles(
						array(
							'base_attr_name' => 'list_item_icon_placement',
							'selector'       => "$this->main_css_element span.difl_icon_item_container",
							'css_property'   => 'flex-direction',
							'render_slug'    => $this->slug,
							'type'           => 'align',
							'important'      => true,
						)
					);
				}

				//	$this->props['list_item_icon_placement'] !== 'column' && $this->props['list_item_icon_vertical_placement'] !== ''
				$align_selector = "$this->main_css_element span.difl_icon_item_container span.difl_icon_item_icon_wrapper";
				if ( $this->props['list_item_icon_placement'] !== 'column'
				     && $this->props['list_item_icon_vertical_placement'] !== 'inherit'
				     && ! ! $this->props['list_item_icon_vertical_placement'] ) {
					self::set_style( $this->slug, array(
						'selector'    => $align_selector,
						'declaration' => 'display:flex;',
					) );
					// Icon placement with default, responsive, hover
					$this->generate_styles(
						array(
							'base_attr_name' => 'list_item_icon_vertical_placement',
							'selector'       => $align_selector,
							'css_property'   => 'align-items',
							'render_slug'    => $this->slug,
							'type'           => 'align',
						)
					);
				} else if ( $this->props['list_item_icon_only'] === 'on' ) {
					// Icon placement with default, responsive, hover
					$this->generate_styles(
						array(
							'base_attr_name' => 'list_item_icon_alignment_alt',
							'selector'       => "$this->main_css_element span.difl_icon_item_container",
							'css_property'   => 'justify-content',
							'render_slug'    => $this->slug,
							'type'           => 'align',
						)
					);
				} else {
					if ( $this->props['list_item_icon_placement'] === 'column' ) {
						self::set_style( $this->slug, array(
							'selector'    => $align_selector,
							'declaration' => 'display: block;'
						) );
					}
				}

				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_icon_alignment',
						'selector'       => "$this->main_css_element span.difl_icon_item_container span.difl_icon_item_icon_wrapper",
						'css_property'   => 'text-align',
						'render_slug'    => $this->slug,
						'type'           => 'align',
						'important'      => true,
					)
				);

				$this->generate_styles(
					array(
						'base_attr_name' => 'list_item_content_max_width',
						'selector'       => "$this->main_css_element .item-elements",
						'hover_selector' => "$this->main_css_element .item-elements:hover",
						'css_property'   => 'max-width',
						'render_slug'    => $this->slug,
						'type'           => 'input',
						'important'      => $this->prop( 'list_item_content_max_width' ) !== 'none',
					)
				);


				// Icon margin and padding with default, responsive, hover
				$this->set_margin_padding_styles(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_icon_margin',
						'type'        => 'margin',
						'selector'    => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper .icon-element",
						'hover'       => "$this->main_css_element .item-elements:hover .difl_icon_item_icon_wrapper .icon-element",
					)
				);
				$this->set_margin_padding_styles(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_icon_padding',
						'type'        => 'padding',
						'selector'    => "$this->main_css_element .item-elements .difl_icon_item_icon_wrapper .icon-element",
						'hover'       => "$this->main_css_element .item-elements:hover .difl_icon_item_icon_wrapper .icon-element",
					)
				);
				$this->set_margin_padding_styles(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_icon_wrapper_margin',
						'type'        => 'margin',
						'selector'    => "$this->main_css_element .item-elements span.difl_icon_item_icon_wrapper",
						'hover'       => "$this->main_css_element .item-elements:hover span.difl_icon_item_icon_wrapper",
					)
				);

				$this->set_margin_padding_styles(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_icon_wrapper_padding',
						'type'        => 'padding',
						'selector'    => "$this->main_css_element .item-elements span.difl_icon_item_icon_wrapper",
						'hover'       => "$this->main_css_element .item-elements:hover span.difl_icon_item_icon_wrapper",
					)
				);

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

				return sprintf(
					'<span class="%1$s"><span class="icon-element">%2$s%3$s%4$s%5$s</span></span>',
					implode( ' ', $icon_wrapper_class ),
					et_core_esc_previously( $this->render_item_font_icon( $multi_view ) ),
					et_core_esc_previously( $this->render_item_icon_image( $multi_view ) ),
					et_core_esc_previously( $this->render_item_icon_text( $multi_view ) ),
					et_core_esc_previously( $this->render_item_icon_lottie( $multi_view ) )
				);
			}

			return null;
		}

		/**
		 * Render item body if content out wrapper is enabled
		 *
		 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
		 *
		 * @return null|string
		 */
		private function render_icon_item_body_outer_wrapper( $multi_view ) {
			if ( $this->props['list_item_icon_only'] === 'off'
			     && $this->props['list_item_content_outside_wrapper'] === 'on' ) {
				return sprintf(
					'<span class="difl_icon_item_outer_wrapper">%1$s</span>',
					et_core_esc_previously( $this->render_icon_item_body_text( $multi_view ) )

				);
			}

			return null;
		}

		/**
		 * Render item body with title and content
		 *
		 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
		 *
		 * @return string
		 */
		private function render_icon_item_tooltip_text( $multi_view ) {
			if ( $this->props['list_item_use_tooltip'] === 'on' && $this->props['list_item_tooltip_content'] !== '' ) {
				$data_options = array(
					'tooltip_enable'      => $this->props['list_item_use_tooltip'] === 'on',
					'arrow'               => $this->props['tooltip_arrow'] === 'on',
					'interactive'         => $this->props['tooltip_interactive'] === 'on',
					'interactiveBorder'   => $this->props['tooltip_interactive'] === 'on' && isset( $this->props['tooltip_interactive_border'] ) ? $this->props['tooltip_interactive_border'] : 2,
					'interactiveDebounce' => $this->props['tooltip_interactive'] === 'on' && isset( $this->props['tooltip_interactive_debounce'] ) ? $this->props['tooltip_interactive_debounce'] : 0,
					'animation'           => isset( $this->props['tooltip_animation'] ) ? $this->props['tooltip_animation'] : 'fade',
					'placement'           => isset( $this->props['tooltip_placement'] ) ? $this->props['tooltip_placement'] : 'top',
					'trigger'             => isset( $this->props['tooltip_trigger'] ) ? $this->props['tooltip_trigger'] : 'focus',
					'followCursor'        => $this->props['tooltip_follow_cursor'] === 'on',
					'maxWidth'            => isset( $this->props['tooltip_custom_maxwidth'] ) ? $this->props['tooltip_custom_maxwidth'] : 350,
					'offsetEnable'        => $this->props['tooltip_offset_enable'] === 'on',
					'offsetSkidding'      => $this->props['tooltip_offset_enable'] === 'on' && isset( $this->props['tooltip_offset_skidding'] ) ? $this->props['tooltip_offset_skidding'] : 0,
					'offsetDistance'      => $this->props['tooltip_offset_enable'] === 'on' && isset( $this->props['tooltip_offset_distance'] ) ? $this->props['tooltip_offset_distance'] : 10,
				);


				// Tooltip
				$this->df_process_bg(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_tooltip_background',
						'selector'    => $this->tooltip_css_element,
						'hover'       => "$this->tooltip_css_element:hover",
						'important'   => true,
					)
				);

				// item tooltip padding with default, responsive, hover
				$this->set_margin_padding_styles(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'list_item_tooltip_padding',
						'type'        => 'padding',
						'selector'    => $this->tooltip_css_element,
						'hover'       => "$this->tooltip_css_element:hover",
					)
				);

				// Arrow colors
				$this->df_process_color(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'tooltip_arrow_color',
						'type'        => 'border-top-color',
						'selector'    => "$this->tooltip_css_element[data-placement^='top'] > .tippy-arrow::before",
						'hover'       => "$this->tooltip_css_element[data-placement^='top']:hover > .tippy-arrow::before",
					)
				);
				$this->df_process_color(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'tooltip_arrow_color',
						'type'        => 'border-bottom-color',
						'selector'    => "$this->tooltip_css_element[data-placement^='bottom'] > .tippy-arrow::before",
						'hover'       => "$this->tooltip_css_element[data-placement^='bottom']:hover > .tippy-arrow::before",
					)
				);
				$this->df_process_color(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'tooltip_arrow_color',
						'type'        => 'border-left-color',
						'selector'    => "$this->tooltip_css_element[data-placement^='left'] > .tippy-arrow::before",
						'hover'       => "$this->tooltip_css_element[data-placement^='left']:hover > .tippy-arrow::before",
					)
				);
				$this->df_process_color(
					array(
						'render_slug' => $this->slug,
						'slug'        => 'tooltip_arrow_color',
						'type'        => 'border-right-color',
						'selector'    => "$this->tooltip_css_element[data-placement^='right'] > .tippy-arrow::before",
						'hover'       => "$this->tooltip_css_element[data-placement^='right']:hover > .tippy-arrow::before",
					)
				);

				return $multi_view->render_element(
					array(
						'tag'     => 'span',
						'content' => '{{list_item_tooltip_content}}',
						'attrs'   => array(
							'class'        => 'difl_icon_item_tooltip_content',
							'data-options' => wp_json_encode( $data_options ),
						),
					)
				);
			}

			return null;
		}

		/**
		 * Add class name for background field
		 *
		 * @param array $options
		 *
		 * @return null|array
		 */
		protected function df_iconlist_add_background_class( $options = array() ) {
			if ( isset( $options['background_field'], $options['classes'] ) ) {
				if ( array_key_exists( $options['background_field'], $this->get_fields() ) ) {
					$options['classes'][] = 'et_pb_with_background';
				}

				return $options['classes'];
			}

			return null;
		}

		/**
		 * Set actual position for icon or image in show on hover effect for current element with default, responsive and hover
		 *
		 * @param array $options Options of current width.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function df_iconlist_show_icon_on_hover_styles( $options = array() ) {
			$additional_css = '';
			$defaultUnits   = array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' );

			$default_options = array(
				'field'         => '',
				'trigger'       => '',
				'selector'      => '',
				'hover'         => '',
				'type'          => '',
				'dependsOn'     => array(),
				'defaults'      => array(),
				'mappingValues' => array(),
				'important'     => false,
			);
			$options         = wp_parse_args( $options, $default_options );


			// default Unit for margin replacement
			$default_unit_value = isset( $options['defaults']['unitValue'] ) ? $options['defaults']['unitValue'] : 4;
			$allowed_units      = isset( $options['allowedUnits'] ) ? $options['allowedUnits'] : $defaultUnits;

			$css_prop = $this->field_to_css_prop(
				isset( $options['css_property'] ) ? $options['css_property'] : $options['type']
			);

			// Append !important tag.
			if ( isset( $options['important'] ) && $options['important'] ) {
				$additional_css = ' !important';
			}

			// Collect the parent module
			$parent_module = $this->df_iconlist_get_parent_module();

			// Collect all values from current module and parent module, if this is a child module
			$icon_width_values = $this->difl_iconlist_get_icon_prop_width(
				$parent_module,
				array(
					'trigger'   => $options['trigger'],
					'dependsOn' => $options['dependsOn'],
					'defaults'  => $options['defaults'],
				)
			);

			// set styles in responsive mode
			foreach ( $icon_width_values as $device => $current_value ) {
				if ( empty( $current_value ) ) {
					continue;
				}

				// field suffix for icon placement
				$field_suffix = 'desktop' !== $device ? "_$device" : '';

				// generate css value with icon placement and icon width
				$css_value = $this->df_iconlist_generate_css(
					$parent_module,
					array(
						'qualified_name'     => $options['field'] . $field_suffix,
						'mappingValues'      => $options['mappingValues'],
						'allowed_units'      => $allowed_units,
						'default_width'      => $current_value,
						'default_unit_value' => $default_unit_value,
					)
				);

				$style = array(
					'selector'    => $options['selector'],
					'declaration' => sprintf( '%1$s:%2$s %3$s;', $css_prop, esc_html( $css_value ), $additional_css ),
				);

				if ( 'desktop' !== $device ) {
					$current_media_query  = 'tablet' === $device ? 'max_width_980' : 'max_width_767';
					$style['media_query'] = ET_Builder_Element::get_media_query( $current_media_query );
				}

				self::set_style( $this->slug, $style );
			}

			// Set default styles for the show icon on hover effect
			self::set_style( $this->slug, array( 'selector' => $options['selector'], 'declaration' => 'opacity: 0;' ) );
			self::set_style(
				$this->slug,
				array(
					'selector'    => isset( $options['hover'] ) ? $options['hover'] : "{$options['selector']}:hover",
					'declaration' => 'opacity: 1;margin: 0 0 0 0 !important;',
				)
			);
		}

		/**
		 * Collect parent module object, by default standard class object
		 *
		 * @param string $render_slug The slug of module.
		 *
		 * @return stdClass|object
		 * @since 1.0.0
		 */
		private function df_iconlist_get_parent_module( $render_slug = '' ) {
			$default        = new stdClass();
			$render_slug    = ! empty( $render_slug ) ? $render_slug : $this->slug;
			$parent_modules = self::get_parent_modules();

			foreach ( $parent_modules as $parent_module ) {
				foreach ( $parent_module as $moduleObject ) {
					if ( $moduleObject->child_slug === $render_slug ) {
						$default = $moduleObject;
						break;
					}
				}
			}

			return $default;
		}

		/**
		 * Collect icon prop width event if responsive mode
		 *
		 * @param object $parent_module The parent module
		 * @param array  $options       Options of current width.
		 *
		 * @return array
		 * @since 1.0.0
		 */
		private function difl_iconlist_get_icon_prop_width( $parent_module, $options = [] ) {
			$defaults      = array( 'icon' => '', 'image' => '', 'lottie' => '' );
			$results       = array( 'desktop' => '', 'tablet' => '', 'phone' => '' );
			$devices       = array_keys( $results );
			$allowed_props = array_keys( $defaults );

			// Initiate default values for current options
			$default_options = array(
				'trigger'   => '',
				'dependsOn' => $defaults,
				'defaults'  => $defaults,
			);
			$options         = wp_parse_args( $options, $default_options );

			$icon_trigger_prop = $options['trigger'];
			$icon_depend_prop  = $options['dependsOn'];

			if ( ( $this->props[ $icon_trigger_prop ] === 'off' )
			     || in_array( $this->props[ $icon_trigger_prop ], $allowed_props, true ) ) {
				foreach ( $devices as $current_device ) {
					$field_suffix = 'desktop' !== $current_device ? "_$current_device" : '';

					foreach ( $allowed_props as $allowed_prop ) {
						$modified_prop = $icon_depend_prop[ $allowed_prop ] . $field_suffix;

						if ( $this->props[ $icon_trigger_prop ] === $allowed_prop ) {
							if ( isset( $this->props[ $modified_prop ] ) && ! empty( $this->props[ $modified_prop ] ) ) {
								$results[ $current_device ] = $this->props[ $modified_prop ];
							} else if ( ! empty( $parent_module->props[ $modified_prop ] ) ) {
								$results[ $current_device ] = $parent_module->props[ $modified_prop ];
							} else if ( isset( $options['defaults'][ $allowed_prop ] ) ) {
								$results[ $current_device ] = $options['defaults'][ $allowed_prop ];
							} else {
								$results[ $current_device ] = '';
							}
						}
					}
				}
			}

			return $results;
		}


		/* Custom functions for icon list module */

		/**
		 * Collect the value of any props for Icon on hover effect
		 *
		 * @param object $parent_module The parent module
		 * @param array  $options       Options of current width.
		 *
		 * @return string
		 * @since 1.0.0
		 */
		private function df_iconlist_generate_css( $parent_module, $options = [] ) {
			// Initiate default values for current options
			$default_options = array(
				'qualified_name'     => '',
				'mappingValues'      => array(),
				'allowed_units'      => array(),
				'default_width'      => '',
				'default_unit_value' => '',
				'manual'             => false,
				'manual_value'       => '',
			);
			$options         = wp_parse_args( $options, $default_options );

			// Collect placement value
			if ( $options['manual'] ) {
				$default_value = $options['manual_value'];
			} else if ( $this->props[ $options['qualified_name'] ] === 'inherit' ) {
				if ( $this->type === 'child' && ! empty( $parent_module->props[ $options['qualified_name'] ] ) ) {
					$default_value = $parent_module->props[ $options['qualified_name'] ];
				} else {
					$default_value = isset( $options['defaults']['field'] ) ? $options['defaults']['field'] : '';
				}
			} else {
				$default_value = $this->props[ $options['qualified_name'] ];
			}

			// Generate actual value
			$field_value          = $this->df_iconlist_collect_prop_mapping_value( $options, $default_value );
			$clean_default_value  = str_replace( $options['allowed_units'], '', $options['default_width'] );
			$increased_value_data = (int) $clean_default_value + (int) $options['default_unit_value'];

			// Return actual value
			return str_replace( "#", $increased_value_data, $field_value );
		}

		/**
		 * Collect any props value from mapping values
		 *
		 * @param array $options The options array data
		 * @param       $current_value
		 *
		 * @return mixed
		 */
		protected function df_iconlist_collect_prop_mapping_value( $options, $current_value ) {
			if ( isset( $options['mappingValues'] ) && $options['mappingValues'] !== [] ) {
				if ( is_callable( $options['mappingValues'] ) ) {
					return $options['mappingValues']( $current_value );
				}

				return isset( $options['mappingValues'][ $current_value ] ) ? $options['mappingValues'][ $current_value ] : '';
			}

			return $current_value;
		}

		/**
		 * Filter multi view value.
		 *
		 * @param mixed                                     $raw_value
		 * @param array                                     $args
		 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
		 *
		 * @return mixed
		 * @since 1.0.0
		 *
		 * @see   ET_Builder_Module_Helper_MultiViewOptions::filter_value
		 */
		public function multi_view_filter_value( $raw_value, $args, $multi_view ) {
			$name = isset( $args['name'] ) ? $args['name'] : '';
			$mode = isset( $args['mode'] ) ? $args['mode'] : '';


			$icon_fields = [
				'list_item_icon',
				'list_item_title_icon',
			];
			if ( $raw_value && in_array( $name, $icon_fields, true ) ) {
				return et_pb_get_extended_font_icon_value( $raw_value, true );
			}

			$fields_need_escape = array(
				'list_item_title',
			);

			if ( $raw_value && in_array( $name, $fields_need_escape, true ) ) {
				return $this->_esc_attr( $multi_view->get_name_by_mode( $name, $mode ), 'none', $raw_value );
			}

			if ( $raw_value && in_array( $name, array( 'content', 'list_item_tooltip_content' ), true ) ) {
				$raw_value = preg_replace( '/^[\w]?<\/p>/smi', '', $raw_value );
				$raw_value = preg_replace( '/<p>$/smi', '', $raw_value );
			}

			return $raw_value;
		}
	}

	new DIFL_IconListItem();
