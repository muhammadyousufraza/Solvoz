<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       diviflash.com
 * @since      1.0.0
 *
 * @package    diviflash
 * @subpackage diviflash/includes
 */

class DiviFlashInit {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      DiviFlash_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'DIFL_VERSION' ) ) {
			$this->version = DIFL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'diviflash';

		$this->load_dependencies();
		$this->set_locale();
		add_action( 'divi_extensions_init', array( $this, 'difl_initialize_extension' ) );
		new DIFL\Admin();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - DiviFlash_Loader. Orchestrates the hooks of the plugin.
	 * - DiviFlash_i18n. Defines internationalization functionality.
	 * - DiviFlash_Admin. Defines all hooks for the admin area.
	 * - DiviFlash_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-diviflash-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-diviflash-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/Admin.php';
		/**
		 * The class responsible for defining all Module Management area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-diviflash-module-manage.php';
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-diviflash-public.php';
		/**
		 * All external functions for diviflash plugin
		 * 
		 */
		require_once ( plugin_dir_path( dirname( __FILE__ ) ) . '/includes/functions.php' );

		/**
		 * The class responsible for defining all actions that occur in the POPUP
		 * of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/popup/class-popup-process.php';

		/**
		 * Taxonomies
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/taxonomies/class-diviflash-gallery.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/taxonomies/class-diviflash-page.php';

		$this->loader = new DiviFlash_Loader();

	}


	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the DiviFlash_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new DiviFlash_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Load all Modules
	 * of diviflash
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function difl_initialize_extension() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/Diviflash.php';
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new DiviFlash_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    DiviFlash_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
