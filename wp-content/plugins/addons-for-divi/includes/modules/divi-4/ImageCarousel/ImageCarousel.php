<?php
class DTQ_Image_Carousel extends Divi_Torque_Lite_Module
{

	public function init()
	{

		$this->vb_support = 'on';
		$this->slug       = 'ba_image_carousel';
		$this->child_slug = 'ba_image_carousel_child';
		$this->name       = esc_html__('Image Carousel', 'addons-for-divi');

		$this->icon_path  	= $this->dtl_icon_path('carousel-2');

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => array(
						'title'             => esc_html__('Carousel Settings', 'addons-for-divi'),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'general'  => array(
								'name' => esc_html__('General', 'addons-for-divi'),
							),
							'advanced' => array(
								'name' => esc_html__('Advanced', 'addons-for-divi'),
							),
						),
					),
				),
			),

			'advanced' => array(
				'toggles' => array(

					'content'  => esc_html__('Common', 'addons-for-divi'),
					'title'    => esc_html__('Title', 'addons-for-divi'),
					'subtitle' => esc_html__('Sub Title', 'addons-for-divi'),

					'nav'  => array(
						'title'             => esc_html__('Navigation', 'addons-for-divi'),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'nav_common' => array(
								'name' => esc_html__('Common', 'addons-for-divi'),
							),
							'nav_left'   => array(
								'name' => esc_html__('Left', 'addons-for-divi'),
							),
							'nav_right'  => array(
								'name' => esc_html__('Right', 'addons-for-divi'),
							),
						),
					),
					'pagi' => array(
						'title'             => esc_html__('Pagination', 'addons-for-divi'),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'pagi_common' => array(
								'name' => esc_html__('Common', 'addons-for-divi'),
							),
							'pagi_active' => array(
								'name' => esc_html__('Active', 'addons-for-divi'),
							),
						),
					),
				),
			),
		);

		$this->custom_css_fields = array(
			'nav_prev'  => array(
				'label'    => esc_html__('Prev (Navigation)', 'addons-for-divi'),
				'selector' => '%%order_class%% .slick-arrow.slick-prev',
			),
			'nav_next'  => array(
				'label'    => esc_html__('Next (Navigation)', 'addons-for-divi'),
				'selector' => '%%order_class%% .slick-arrow.slick-next',
			),
			'pagi_dots' => array(
				'label'    => esc_html__('Pagination Wrapper', 'addons-for-divi'),
				'selector' => '%%order_class%% .slick-dots',
			),
			'pagi_item' => array(
				'label'    => esc_html__('Pagination Item', 'addons-for-divi'),
				'selector' => '%%order_class%% .slick-dots li',
			),
			'pagi_dot'  => array(
				'label'    => esc_html__('Pagination Dot', 'addons-for-divi'),
				'selector' => '%%order_class%% .slick-dots button',
			),
		);
	}

	public function get_fields()
	{

		$fields = [];

		$fields['content_alignment'] = array(
			'label'            => esc_html__('Content Text Alignment', 'addons-for-divi'),
			'description'      => esc_html__('Align texts to the left, right or center.', 'addons-for-divi'),
			'type'             => 'text_align',
			'option_category'  => 'layout',
			'options'          => et_builder_get_text_orientation_options(array('justified')),
			'options_icon'     => 'module_align',
			'default_on_front' => 'left',
			'toggle_slug'      => 'content',
			'tab_slug'         => 'advanced',
		);

		$get_carousel_option_fields =  $this->get_carousel_option_fields(array('lightbox', 'equal_height'), array(), array(), 'main_content');

		return array_merge($fields, $get_carousel_option_fields);
	}

	public function get_advanced_fields_config()
	{

		$advanced_fields = array();

		$advanced_fields['text']         = array();
		$advanced_fields['borders']      = array();
		$advanced_fields['text_shadow']  = array();
		$advanced_fields['link_options'] = array();
		$advanced_fields['fonts']        = array();

		$advanced_fields['fonts']['title'] = array(
			'label'           => esc_html__('Title', 'addons-for-divi'),
			'css'             => array(
				'main'      => '%%order_class%% .dtq-carousel .dtq-image-title, .et-db #et-boc %%order_class%% .dtq-carousel .dtq-image-title',
				'important' => 'all',
			),
			'tab_slug'        => 'advanced',
			'toggle_slug'     => 'title',
			'line_height'     => array(
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
			),
			'hide_text_align' => true,
			'header_level'    => array(
				'default' => 'h3',
			),
		);

		$advanced_fields['fonts']['subtitle'] = array(
			'label'           => esc_html__('Subtitle', 'addons-for-divi'),
			'css'             => array(
				'main'      => '%%order_class%% .dtq-carousel .dtq-image-subtitle, .et-db #et-boc %%order_class%% .dtq-carousel .dtq-image-subtitle',
				'important' => 'all',
			),
			'tab_slug'        => 'advanced',
			'toggle_slug'     => 'subtitle',
			'hide_text_align' => true,
			'line_height'     => array(
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
			),
			'header_level'    => array(
				'default' => 'h5',
			),
		);

		$advanced_fields['borders']['default'] = array(
			'label_prefix' => esc_html__('Border', 'addons-for-divi'),
			'css'          => array(
				'main'      => '%%order_class%%',
			),
		);

		$advanced_fields['borders']['carousel'] = array(
			'label_prefix' => esc_html__('Carousel', 'addons-for-divi'),
			'css'          => array(
				'main' => [
					'border_radii'  => '%%order_class%% .dtq-carousel .slick-slide',
					'border_styles' => '%%order_class%% .dtq-carousel .slick-slide',
				],
			),
			'tab_slug'     => 'advanced',
			'toggle_slug'  => 'content',
		);

		$advanced_fields['borders']['image'] = array(
			'label_prefix' => esc_html__('Image', 'addons-for-divi'),
			'css'          => array(
				'main' => [
					'border_radii'  => '%%order_class%% .dtq-carousel .slick-slide img',
					'border_styles' => '%%order_class%% .dtq-carousel .slick-slide img',
				],
			),
			'tab_slug'     => 'advanced',
			'toggle_slug'  => 'content',
		);

		return $advanced_fields;
	}

	public function render($attrs, $content, $render_slug)
	{

		wp_enqueue_script('divi-torque-lite-slick');
		wp_enqueue_style('divi-torque-lite-slick');
		$this->render_css($render_slug);

		$content          	= $this->props['content'];
		$content_alignment	= $this->props['content_alignment'];
		$is_center        	= $this->props['is_center'];
		$center_mode_type 	= $this->props['center_mode_type'];
		$use_lightbox     	= $this->props['use_lightbox'];
		$custom_cursor    	= $this->props['custom_cursor'];
		$classes          	= array();

		array_push($classes, "dtq-lightbox-{$use_lightbox}");

		if ('on' === $is_center) {
			array_push($classes, 'dtq-centered');
			array_push($classes, "dtq-centered--{$center_mode_type}");
		}

		if ('on' === $custom_cursor) {
			array_push($classes, 'dtq-cursor');
		}

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .dtq-carousel .dtq-image-carousel-item .content-inner',
				'declaration' => sprintf('text-align: %1$s;', $content_alignment),
			)
		);

		$output = sprintf(
			'<div class="dtq-carousel dtq-image-carousel dtq-carousel-frontend %3$s" %2$s >
                    %1$s
                </div>',
			$content,
			$this->get_carousel_options_data(),
			join(' ', $classes)
		);

		return $output;
	}

	public function render_css($render_slug)
	{
		$this->render_carousel_css($render_slug);
	}
}

new DTQ_Image_Carousel();
