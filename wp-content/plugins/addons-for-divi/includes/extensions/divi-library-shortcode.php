<?php

namespace DiviTorqueLite;

class Divi_Library_Shortcode
{
	private static $instance;

	public static function get_instance()
	{
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct()
	{
		add_filter('manage_et_pb_layout_posts_columns', array($this, 'columns_head_et_pb_layout'), 10);
		add_action('manage_et_pb_layout_posts_custom_column', array($this, 'columns_content_et_pb_layout'), 10, 2);
		add_shortcode('divi_library_shortcode', array($this, 'shortcode_callback'));
	}

	public function columns_head_et_pb_layout($defaults)
	{
		$defaults['shortcode_id'] = esc_html__('Lite Shortcode', 'addons-for-divi');
		return $defaults;
	}

	public function columns_content_et_pb_layout($column_name, $post_id)
	{
		if ('shortcode_id' === $column_name) {
			printf('<code class="dtl-library-shortcode">[divi_library_shortcode id="%1$s"]</code>', esc_attr($post_id));
		}
	}

	public function shortcode_callback($atts)
	{
		$atts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts,
			'divi_library_shortcode'
		);

		$shortcode = do_shortcode(
			sprintf(
				'[et_pb_section global_module="%1$s"][/et_pb_section]',
				esc_attr($atts['id'])
			)
		);

		return $shortcode;
	}
}
