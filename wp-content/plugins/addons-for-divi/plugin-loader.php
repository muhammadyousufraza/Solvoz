<?php

/**
 * Plugin Loader Class
 * 
 * Main loader class that initializes the plugin functionality.
 * Handles plugin activation, text domain loading, and core functionality initialization.
 * 
 * @package DiviTorqueLite
 * @since 1.0.0
 */

namespace DiviTorqueLite;

use DiviTorqueLite\AdminHelper;
use DiviTorqueLite\AssetsManager;
use DiviTorqueLite\RestApi;
use DiviTorqueLite\Dashboard;
use DiviTorqueLite\ModulesManager;
use DiviTorqueLite\Deprecated;
use DiviTorqueLite\Divi_Library_Shortcode;
use DiviTorqueLite\Admin_Notices;

class PluginLoader
{
    /**
     * Holds the single instance of this class
     * @var PluginLoader
     */
    private static $instance;

    /**
     * Returns the singleton instance of this class
     * @return PluginLoader
     */
    public static function get_instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Constructor - Sets up the initial hooks
     */
    public function __construct()
    {
        register_activation_hook(DIVI_TORQUE_LITE_FILE, array($this, 'activation'));
        add_action('init', array($this, 'load_textdomain'));
        add_action('plugins_loaded', array($this, 'hooks_init'));
    }

    /**
     * Initializes plugin hooks and components
     */
    public function hooks_init()
    {
        add_action('divi_extensions_init', array($this, 'init_extension'));
        add_filter('plugin_action_links_' . plugin_basename(DIVI_TORQUE_LITE_FILE), array($this, 'add_pro_link'));

        AssetsManager::get_instance();
        RestApi::get_instance();

        if (!dt_is_pro_installed()) {
            Dashboard::get_instance();

            new Admin_Notices([
                'slug' => 'black_friday_deal',
                'title' => __('🔥 Black Friday Deal: 100 Sites for Life!', 'divitorque'),
                'message' => __('Upgrade to <strong>Divi Torque Pro</strong> with an amazing Black Friday offer. Get lifetime access for 100 sites at just <strong>$89</strong>! Limited time offer, don\'t miss out!', 'divitorque'),
                'type' => 'success',
                'show_after' => 'day',
                'screens' => ['plugins', 'divitorque'],
                'buttons' => [
                    [
                        'text' => __('Claim Black Friday Offer', 'divitorque'),
                        'url' => 'https://diviepic.com/divi-torque-pro/#pricing',
                        'class' => 'button-primary',
                        'target' => '_blank'
                    ]
                ]
            ]);
        }

        if (!get_option('divitorque_version')) {
            Divi_Library_Shortcode::get_instance();
        }

        if (get_option('divitorque_version') && version_compare(get_option('divitorque_version'), '3.5.7', '<=')) {
            require_once DIVI_TORQUE_LITE_DIR . 'includes/deprecated.php';
        }
    }

    /**
     * Handles plugin activation tasks
     */
    public function activation()
    {
        // Deprecated related
        if (get_option('divitorque_version') && version_compare(get_option('divitorque_version'), '3.5.7', '<=')) {
            require_once DIVI_TORQUE_LITE_DIR . 'includes/deprecated.php';
            $deprecated = new Deprecated();
            $deprecated->run();
        }

        // Activation Timestamp
        if (!get_option('divitorque_lite_activation_time')) {
            update_option('divitorque_lite_activation_time', time());
        }

        // Install Date
        if (!get_option('divitorque_lite_install_date')) {
            update_option('divitorque_lite_install_date', time());
        }

        // Set the version
        update_option('divitorque_lite_version', DIVI_TORQUE_LITE_VERSION);

        self::init();
    }

    /**
     * Initializes default module settings
     */
    public static function init()
    {
        $module_status = get_option('_divitorque_lite_modules', array());
        $modules = AdminHelper::get_modules();

        if (empty($module_status)) {
            foreach ($modules as $module) {
                $module_status[$module] = $module;
            }

            update_option('_divitorque_lite_modules', $module_status);
        }
    }

    /**
     * Loads plugin text domain for translations
     * Moved to init hook for WordPress 6.7.0 compatibility
     */
    public function load_textdomain()
    {
        load_plugin_textdomain('addons-for-divi', false, dirname(plugin_basename(DIVI_TORQUE_LITE_FILE)) . '/languages');
    }

    /**
     * Initializes Divi extension
     */
    public function init_extension()
    {
        ModulesManager::get_instance();
    }

    /**
     * Adds pro version link to plugin actions
     * @param array $links Existing plugin action links
     * @return array Modified plugin action links
     */
    public function add_pro_link($links)
    {
        if (defined('DIVI_TORQUE_PRO_VERSION')) {
            return $links;
        }

        $links[] = sprintf(
            '<a href="%s" target="_blank">%s</a>',
            esc_url_raw(self::get_url()),
            __('Dashboard', 'divitorque')
        );

        return $links;
    }

    /**
     * Returns the plugin dashboard URL
     * @return string Dashboard URL
     */
    public static function get_url()
    {
        return admin_url('admin.php?page=divitorque');
    }
}

PluginLoader::get_instance();
