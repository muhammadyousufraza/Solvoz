<?php

/**
 * Dashboard class for managing admin dashboard functionality
 * 
 * Handles the admin dashboard interface, script enqueuing, and version rollback
 * functionality for the Divi Torque Lite plugin.
 *
 * @package DiviTorqueLite
 * @since 1.0.0
 */

namespace DiviTorqueLite;

use DiviTorqueLite\ModulesManager;
use DiviTorqueLite\Plugin_Upgrader;
use DiviTorqueLite\AdminHelper;

class Dashboard
{
    /**
     * Instance of this class
     *
     * @var Dashboard
     */
    private static $instance;

    /**
     * Menu slug for Divi Torque Lite
     *
     * @var string
     */
    private $menu_slug = 'divitorque';

    /**
     * Capability for accessing the Divi Torque Lite dashboard
     *
     * @var string
     */
    private $capability = 'manage_options';

    /**
     * Get singleton instance of Dashboard class
     *
     * @return Dashboard Instance of Dashboard class
     */
    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_post_divi_torque_lite_rollback', [$this, 'post_divi_torque_lite_rollback']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts'], 100);
    }

    /**
     * Add submenu page for Divi Torque Lite
     *
     * @return void
     */
    public function add_menu()
    {
        if (!current_user_can($this->capability) || AdminHelper::is_pro_installed()) {
            return;
        }

        add_menu_page(
            __('Divi Torque', 'divitorque'),
            __('Divi Torque', 'divitorque'),
            $this->capability,
            $this->menu_slug,
            [$this, 'render_app'],
            $this->icon_url(),
            130
        );

        add_submenu_page(
            $this->menu_slug,
            __('Divi Torque', 'divitorque'),
            __('Home', 'divitorque'),
            $this->capability,
            $this->menu_slug,
            array($this, 'render_app')
        );

        add_submenu_page(
            $this->menu_slug,
            __('Module Manager', 'divitorque'),
            __('Module Manager', 'divitorque'),
            $this->capability,
            "{$this->menu_slug}&path=module-manager",
            [$this, 'render_app']
        );

        $submenus = [
            'popups'            => __('Popups', 'divitorque'),
            'form-submissions'  => __('Submissions', 'divitorque'),
            'google-reviews'    => __('Google Reviews', 'divitorque'),
            'divi-mailer'       => __('Mailer', 'divitorque'),
            'dark-mode'         => __('Dark Mode', 'divitorque'),
            'rollback'          => __('Rollback', 'divitorque'),
        ];

        foreach ($submenus as $slug => $title) {
            add_submenu_page(
                $this->menu_slug,
                $title,
                $title,
                $this->capability,
                "{$this->menu_slug}&path={$slug}",
                [$this, 'render_app']
            );
        }

        add_submenu_page(
            $this->menu_slug,
            __('Upgrade to Pro', 'divitorque'),
            __('Upgrade to Pro', 'divitorque'),
            $this->capability,
            'go_divitorque_pro',
            function () {
                wp_redirect('https://diviepic.com/divi-torque-pro/#pricing?utm_source=wpadmin&utm_medium=click&utm_campaign=menubtn&utm_content=divi-torque');
                exit;
            },
            100
        );
    }

    /**
     * Load dashboard page content
     *
     * @return void
     */
    public function render_app()
    {
        $this->enqueue_scripts();
        echo '<div id="divitorque-root"></div>';
    }

    /**
     * Enqueue required scripts ands styles for dashboard
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        $manifest_path = DIVI_TORQUE_LITE_DIR . 'assets/mix-manifest.json';
        if (!file_exists($manifest_path)) {
            return;
        }

        $manifest = json_decode(file_get_contents($manifest_path), true);
        if (!$manifest) {
            return;
        }

        $assets_url = DIVI_TORQUE_LITE_URL . 'assets';
        $dashboard_js = $assets_url . $manifest['/admin/js/dashboard.js'];
        $dashboard_css = $assets_url . $manifest['/admin/css/dashboard.css'];

        wp_enqueue_script(
            'divi-torque-lite-dashboard',
            $dashboard_js,
            $this->wp_deps(),
            DIVI_TORQUE_LITE_VERSION,
            true
        );

        wp_enqueue_style(
            'divi-torque-lite-dashboard',
            $dashboard_css,
            ['wp-components'],
            DIVI_TORQUE_LITE_VERSION
        );

        $localize = [
            'root'            => esc_url_raw(get_rest_url()),
            'admin_slug'      => $this->menu_slug,
            'nonce'          => wp_create_nonce('wp_rest'),
            'assetsPath'     => esc_url_raw($assets_url),
            'version'        => DIVI_TORQUE_LITE_VERSION,
            'module_info'    => ModulesManager::get_all_modules(),
            'pro_module_info' => ModulesManager::get_all_pro_modules(),
            'module_icon_path' => DIVI_TORQUE_LITE_URL . 'assets/imgs/icons',
            'isProInstalled' => AdminHelper::is_pro_installed(),
            'upgradeLink'    => dtp_fs()->get_upgrade_url(),
            'rollbackLink'   => esc_url(
                add_query_arg(
                    'version',
                    'VERSION',
                    wp_nonce_url(
                        admin_url('admin-post.php?action=divi_torque_lite_rollback'),
                        'divi_torque_lite_rollback'
                    )
                )
            ),
            'rollbackVersions' => AdminHelper::get_rollback_versions(),
            'currentVersion'   => DIVI_TORQUE_LITE_VERSION,
        ];

        wp_localize_script('divi-torque-lite-dashboard', 'diviTorqueLite', $localize);
    }

    /**
     * Add admin styles
     */
    public function admin_enqueue_scripts()
    {
        wp_enqueue_style(
            'divi-torque-lite-admin',
            DIVI_TORQUE_LITE_URL . 'assets/admin/css/admin.css',
            [],
            DIVI_TORQUE_LITE_VERSION
        );
    }

    /**
     * Get WordPress dependencies for dashboard scripts
     *
     * @return array Array of script dependencies
     */
    public function wp_deps()
    {
        return [
            'react',
            'wp-api',
            'wp-i18n',
            'lodash',
            'wp-components',
            'wp-element',
            'wp-api-fetch',
            'wp-core-data',
            'wp-data',
            'wp-dom-ready',
        ];
    }

    /**
     * Handle plugin version rollback
     *
     * @return void
     */
    public function post_divi_torque_lite_rollback()
    {
        if (!current_user_can('install_plugins')) {
            wp_die(
                esc_html__('You do not have permission to access this page.', 'addons-for-divi'),
                esc_html__('Rollback to Previous Version', 'addons-for-divi'),
                ['response' => 200]
            );
        }

        check_admin_referer('divi_torque_lite_rollback');

        $plugin_version = isset($_GET['version']) ? sanitize_text_field($_GET['version']) : '';

        if (empty($plugin_version)) {
            wp_die(esc_html__('Error occurred, The version selected is invalid. Try selecting different version.', 'addons-for-divi'));
        }

        $plugin_slug = basename(DIVI_TORQUE_LITE_FILE, '.php');

        $rollback = new Plugin_Upgrader([
            'version' => $plugin_version,
            'plugin_name' => DIVI_TORQUE_LITE_BASE,
            'plugin_slug' => $plugin_slug,
            'package' => sprintf('https://downloads.wordpress.org/plugin/%s.%s.zip', $plugin_slug, $plugin_version),
        ]);

        $rollback->run();

        wp_die(
            ' ',
            esc_html__('Rollback to Previous Version', 'addons-for-divi'),
            ['response' => 200]
        );
    }

    /**
     * Get the icon URL for the Divi Torque Lite dashboard
     *
     * @return string The icon URL
     */
    private function icon_url()
    {
        return 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA0OCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTQ4IDI0LjA0NjZDNDggMzcuMjgxNiAzNy4wMjExIDQ4IDIzLjU4MTQgNDhIMjAuOTMxM0MxOC4yODEyIDQ4IDE2LjE5OSA0NS45NDk1IDE2LjE5OSA0My4zMzk4VjIyLjQ2MjFDMTYuMTk5IDE5Ljg1MjQgMTguMjgxMiAxNy44MDE5IDIwLjkzMTMgMTcuODAxOUMyMy41ODE0IDE3LjgwMTkgMjUuNjYzNiAxOS44NTI0IDI1LjY2MzYgMjIuNDYyMVYzOC40OTMyQzMyLjg1NjcgMzcuNDY4IDM4LjQ0MDggMzEuNDA5NyAzOC40NDA4IDIzLjk1MzRDMzguNDQwOCAxNS44NDQ3IDMxLjgxNTYgOS4zMjAzOSAyMy41ODE0IDkuMzIwMzlDMjAuOTMxMyA5LjMyMDM5IDE4LjQ3MDUgOS45NzI4MiAxNi4zODgzIDExLjE4NDVDMTMuODMyOSAxMi41ODI1IDExLjc1MDcgMTQuNzI2MiAxMC40MjU2IDE3LjMzNTlDMTAuMzMxIDE3LjUyMjMgOS43NjMxMSAxOC43MzQgOS4zODQ1MyAxOS45NDU2QzkuMTk1MjQgMjAuNDExNyA4LjgxNjY2IDIwLjY5MTMgOC4zNDM0MyAyMC41OTgxQzcuNzc1NTUgMjAuNTA0OSA3LjM5Njk3IDE5Ljk0NTYgNy41ODYyNiAxOS40Nzk2QzcuOTY0ODQgMTcuODk1MSA4LjUzMjcyIDE2Ljg2OTkgOC42MjczNiAxNi43NzY3QzguODE2NjYgMTYuMzEwNyA4LjYyNzM2IDE1Ljg0NDcgOC4xNTQxNCAxNS42NTgzSDguMDU5NDlDNy41ODYyNiAxNS40NzE4IDcuMDE4MzkgMTUuNjU4MyA2LjgyOTA5IDE2LjAzMTFDNi43MzQ0NSAxNi4zMTA3IDYuNTQ1MTYgMTYuNDk3MSA2LjQ1MDUxIDE2Ljc3NjdDNS43ODc5OSAxOC4zNjEyIDUuMzE0NzYgMjAuMDM4OCA1LjAzMDgzIDIxLjcxNjVDNS4wMzA4MyAyMS44MDk3IDQuOTM2MTggMjIuNjQ4NSA0LjkzNjE4IDIyLjc0MTdDNC45MzYxOCAyMy4yMDc4IDQuNDYyOTUgMjMuNjczOCAzLjk4OTcyIDIzLjU4MDZDMy40MjE4NSAyMy41ODA2IDMuMDQzMjYgMjMuMTE0NiAzLjEzNzkxIDIyLjY0ODVDMy4yMzI1NiAyMS4wNjQxIDMuNjExMTQgMTkuMzg2NCAzLjk4OTcyIDE3Ljk4ODNDMy45ODk3MiAxNy44OTUxIDMuOTg5NzIgMTcuODk1MSA0LjA4NDM3IDE3LjgwMTlDNC4wODQzNyAxNy40MjkxIDMuODAwNDMgMTcuMDU2MyAzLjQyMTg1IDE2Ljg2OTlDMi45NDg2MiAxNi42ODM1IDIuNDc1MzkgMTYuOTYzMSAyLjI4NjEgMTcuNDI5MUMyLjI4NjEgMTcuNTIyMyAyLjAwMjE2IDE4LjI2OCAxLjkwNzUyIDE4LjY0MDhDMS44MTI4NyAxOS4xMDY4IDEuMzM5NjQgMTkuMzg2NCAwLjc3MTc2NiAxOS4yOTMyQzAuMjk4NTM3IDE5LjIgLTAuMDgwMDQ1NiAxOC43MzQgMC4wMTQ2MDAyIDE4LjI2OEMwLjI5ODUzNyAxNy4yNDI3IDAuNzcxNzY2IDE1Ljg0NDcgMS4wNTU3IDE1LjAwNThDMi45NDg2MiAxMC4zNDU2IDYuMzU1ODcgNi40MzEwNyAxMC42MTQ5IDMuNzI4MTZDMTQuNDAwOCAxLjM5ODA2IDE4Ljg0OTEgMCAyMy42NzYgMEMzNy4xMTU3IDAgNDggMTAuODExNiA0OCAyNC4wNDY2WiIgZmlsbD0iI0E3QUFBRCIvPgo8L3N2Zz4K';
    }
}
