<?php

namespace DIFL;

class Admin {
	public function __construct() {
		include DIFL_ADMIN_DIR_PATH . '/menu/df-menu-init.php';
		include DIFL_ADMIN_DIR_PATH . '/popup/df-popup-init.php';
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_filter( 'script_loader_tag', [ $this, 'print_api_request_script' ], PHP_INT_MAX, 3 );
	}
	public function print_api_request_script( $tag, $handle, $src ) {
		$script_handles = [
			'wp-api-request',
		];
		if ( in_array( $handle, $script_handles, true ) ) {
			return '<script type="text/javascript" src="' . $src . '"></script>' . "\n"; // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript
		}

		return $tag;
	}
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in DiviFlash_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The DiviFlash_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_style( 'df-admin-style', DIFL_ADMIN_DIR . 'css/admin.css', array(), DIFL_VERSION );
		wp_enqueue_style( 'df-admin-style' );
		wp_register_style( 'df-builder-styles', DIFL_PUBLIC_DIR . 'css/df-builder-styles.css', array(), DIFL_VERSION );
		if ( (function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled()) || (function_exists( 'et_builder_tb_enabled' ) && et_builder_tb_enabled()) || ( function_exists('et_builder_enable_classic_editor') && et_builder_enable_classic_editor(false))) {
			wp_enqueue_style( 'df-builder-styles' );
		}

		if ( get_current_screen()->base === 'nav-menus' ) {
			wp_register_style( 'df-menu-dashboard-style', DIFL_ADMIN_DIR . 'css/menu.css', array(), DIFL_VERSION );
			wp_enqueue_style( 'df-menu-dashboard-style' );

		}
		// Check if the specific plugin is active
		if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
			// Enqueue your custom CSS file
			wp_register_style( 'df-plugin-complibility-style', DIFL_ADMIN_DIR . 'css/plugin-complibility.css', array(), DIFL_VERSION );
			wp_enqueue_style( 'df-plugin-complibility-style' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in DiviFlash_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The DiviFlash_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$screen = get_current_screen();

		if ( isset( $screen->base ) && $screen->id === 'edit-et_pb_layout' ) {
			wp_register_script( 'df-shortcode-copy', DIFL_ADMIN_DIR . 'js/df-shortcode-copy.js', array(), DIFL_VERSION, true );
			wp_enqueue_script( 'df-shortcode-copy' );
		}

		if ( isset( $screen->base ) && $screen->post_type === 'difl_popup' ) {
			wp_register_script( 'df-popup-single', DIFL_ADMIN_DIR . 'js/df-popup-single.js', array(), DIFL_VERSION, true );
			wp_enqueue_script( 'df-popup-single' );
		}

		/**
		 * Menu Dashboard data
		 *
		 */
		if ( get_current_screen()->id === 'nav-menus' ) {
			wp_enqueue_media();
			// wp_enqueue_style('media_collector', get_stylesheet_directory_uri() . '/mediaCollector.css');

			wp_register_script( 'df-menu-dashboard-script', DIFL_ADMIN_DIR . 'js/df-menu.js', array( 'jquery' ), DIFL_VERSION, true );
			wp_enqueue_script( 'df-menu-dashboard-script' );
		}

		/**
		 * Popup Script
		 *
		 */
		if ( isset( $screen->base ) && $screen->id === 'edit-difl_popup' ) {
			//echo "ok";
			wp_register_script( 'df-popup-id-copy', DIFL_ADMIN_DIR . 'js/df-popup-id-copy.js', array(), DIFL_VERSION, true );
			wp_enqueue_script( 'df-popup-id-copy' );
		}
	}

}

