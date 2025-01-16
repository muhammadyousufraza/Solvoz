<?php

namespace DiviTorqueLite;

use DiviTorqueLite\BackendHelpers;

class AssetsManager
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
		add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_builder_scripts'));
		add_action('wp_loaded', array($this, 'load_backend_data'));
	}

	public function enqueue_frontend_scripts()
	{

		$this->vendor_enqueue_scripts();

		$version = DIVI_TORQUE_LITE_VERSION;
		$js_path = DIVI_TORQUE_LITE_ASSETS . 'js/';
		$css_path = DIVI_TORQUE_LITE_ASSETS . 'css/';

		// Main JS
		wp_enqueue_script(
			'divi-torque-lite-frontend',
			$js_path . 'frontend.js',
			array(
				'jquery',
				'divi-torque-lite-magnific-popup',
				'divi-torque-lite-slick',
				'divi-torque-lite-counter-up',
			),
			$version,
			true
		);

		// Modules CSS
		wp_enqueue_style(
			'divi-torque-lite-modules-style',
			$css_path . 'modules-style.css',
			array(),
			$version,
			'all'
		);

		// Main CSS
		wp_enqueue_style(
			'divi-torque-lite-frontend',
			$css_path . 'frontend.css',
			array(
				'divi-torque-lite-magnific-popup'
			),
			$version,
			'all'
		);

		// Localize script
		wp_localize_script(
			'divi-torque-lite-frontend',
			'diviTorqueLiteFrontend',
			array(
				'ajaxurl' => admin_url('admin-ajax.php'),
			)
		);
	}

	public function enqueue_builder_scripts()
	{
		if (!et_core_is_fb_enabled()) {
			return;
		}

		$version = DIVI_TORQUE_LITE_VERSION;
		$manifest_path = DIVI_TORQUE_LITE_DIR . 'assets/mix-manifest.json';

		if (file_exists($manifest_path)) {
			$mj = file_get_contents($manifest_path);
			$mj = json_decode($mj, true);

			if (is_array($mj)) {
				wp_enqueue_style('divi-torque-lite-bundle', DIVI_TORQUE_LITE_ASSETS . $mj['/css/bundle.css'], [], $version);
				wp_enqueue_style('divi-torque-lite-modules-style', DIVI_TORQUE_LITE_ASSETS . $mj['/css/modules-style.css'], [], $version);
				wp_enqueue_style('divi-torque-lite-slick-css', DIVI_TORQUE_LITE_ASSETS . '/libs/slick/slick.min.css', [], $version);

				wp_enqueue_script(
					'divi-torque-lite-bundle',
					DIVI_TORQUE_LITE_ASSETS . $mj['/js/bundle.js'],
					['react-dom', 'react', 'et_pb_media_library'],
					$version,
					true
				);

				// Localize script
				wp_localize_script(
					'divi-torque-lite-bundle',
					'diviTorqueLiteBuilder',
					[
						'ajax_url' => admin_url('admin-ajax.php'),
					]
				);
			}
		}
	}

	public function vendor_enqueue_scripts()
	{
		$libs_path = DIVI_TORQUE_LITE_ASSETS . 'libs/';
		$version = DIVI_TORQUE_LITE_VERSION;

		$scripts = [
			'slick' => 'slick/slick.min.js',
			'twentytwenty' => 'twentytwenty/twentytwenty.min.js',
			'tippy' => 'tippy/tippy.min.js',
			'event-move' => 'event-move/event_move.min.js',
			'popper' => 'popper/popper.min.js',
			'typed' => 'typed/typed.min.js',
			'anime' => 'anime/anime.min.js',
			'text-animation' => 'text-animation/text-animation.min.js',
			'counter-up' => 'counter-up/counter-up.min.js',
			'magnific-popup' => 'magnific-popup/magnific-popup.js'

		];

		$styles = [
			'slick' => 'slick/slick.min.css',
			'tippy' => 'tippy/tippy.min.css',
			'magnific-popup' => 'magnific-popup/magnific-popup.css',

		];

		// Register scripts
		foreach ($scripts as $handle => $path) {
			wp_register_script("divi-torque-lite-$handle", $libs_path . $path, ['jquery'], $version, true);
		}

		// Register styles
		foreach ($styles as $handle => $path) {
			wp_register_style("divi-torque-lite-$handle", $libs_path . $path, [], $version, 'all');
		}
	}


	public function load_backend_data()
	{
		if (!function_exists('et_fb_process_shortcode') || !class_exists(BackendHelpers::class)) {
			return;
		}

		$helpers = new BackendHelpers();
		$this->registerFiltersAndActions($helpers);
	}

	private function registerFiltersAndActions(BackendHelpers $helpers)
	{
		add_filter('et_fb_backend_helpers', [$helpers, 'static_asset_helpers'], 11);
		add_filter('et_fb_get_asset_helpers', [$helpers, 'asset_helpers'], 11);

		$enqueueScriptsCallback = function () use ($helpers) {
			wp_localize_script('et-frontend-builder', 'diviTorqueLiteBuilderBackend', $helpers->static_asset_helpers());
		};

		add_action('wp_enqueue_scripts', $enqueueScriptsCallback);
		add_action('admin_enqueue_scripts', $enqueueScriptsCallback);
	}
}
