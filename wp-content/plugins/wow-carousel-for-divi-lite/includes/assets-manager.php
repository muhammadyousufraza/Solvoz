<?php

/**
 * Assets Manager Class
 * 
 * Handles all asset (JS/CSS) loading for the Divi Carousel Lite plugin.
 * Manages script/style registration and enqueuing for both frontend and builder.
 * 
 * @package Divi_Carousel_Lite
 * @since 1.0.0
 */

namespace Divi_Carousel_Lite;

use Divi_Carousel_Lite\BackendHelpers;

class Assets_Manager
{
    /**
     * Singleton instance
     * @var Assets_Manager|null
     */
    private static $instance = null;

    /**
     * Get singleton instance
     * @return Assets_Manager Instance of the class
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor - Sets up action hooks
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueFrontendScripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueBuilderScripts']);
        add_action('wp_loaded', [$this, 'load_backend_data']);
    }

    /**
     * Main method to enqueue styles and scripts
     * 
     * @param string $prefix Asset prefix/name
     * @param array $dependencies Script dependencies
     * @param bool $isStyle Whether to enqueue styles
     * @param bool $isScript Whether to enqueue scripts
     */
    public function enqueueStylesAndScripts($prefix, $dependencies = ['react-dom', 'react'], $isStyle = true, $isScript = true)
    {
        $manifest = $this->getManifest();

        if ($manifest) {
            $this->enqueueFromManifest($prefix, $dependencies, $isStyle, $isScript, $manifest);
        } else {
            $this->enqueueFallback($prefix, $dependencies, $isStyle, $isScript);
        }
    }

    /**
     * Get the manifest file contents
     * @return array|null Manifest data or null if invalid
     */
    private function getManifest()
    {
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);

        $manifestPath = DCL_PLUGIN_DIR . 'assets/mix-manifest.json';
        $manifest = json_decode(file_get_contents($manifestPath, false, $context), true);

        return is_array($manifest) ? $manifest : null;
    }

    /**
     * Enqueue assets using manifest file
     */
    private function enqueueFromManifest($prefix, $dependencies, $isStyle, $isScript, $manifest)
    {
        if ($isScript) {
            wp_enqueue_script(
                "dcl-{$prefix}",
                DCL_PLUGIN_ASSETS . $manifest["/js/{$prefix}.js"],
                $dependencies,
                DCL_PLUGIN_VERSION,
                true
            );
        }

        if ($isStyle) {
            wp_enqueue_style(
                "dcl-{$prefix}",
                DCL_PLUGIN_ASSETS . $manifest["/css/{$prefix}.css"],
                [],
                DCL_PLUGIN_VERSION,
                'all'
            );
        }
    }

    /**
     * Fallback enqueue method when manifest is not available
     */
    private function enqueueFallback($prefix, $dependencies, $isStyle, $isScript)
    {
        if ($isStyle) {
            wp_enqueue_style(
                "dcl-{$prefix}",
                DCL_PLUGIN_ASSETS . "css/{$prefix}.css",
                [],
                DCL_PLUGIN_VERSION,
                'all'
            );
        }

        if ($isScript) {
            wp_register_script(
                "dcl-{$prefix}",
                DCL_PLUGIN_ASSETS . "js/{$prefix}.js",
                $dependencies[0] === 'jquery' ? ['jquery'] : $dependencies,
                DCL_PLUGIN_VERSION,
                true
            );
        }
    }

    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueueFrontendScripts()
    {
        $this->enqueueLibraries();
        $this->enqueueStylesAndScripts('frontend');
    }

    /**
     * Enqueue third-party libraries
     */
    private function enqueueLibraries()
    {
        // Enqueue Scripts
        wp_enqueue_script('dcl-slick', DCL_PLUGIN_ASSETS . 'libs/slick/slick.min.js', ['jquery'], DCL_PLUGIN_VERSION, true);
        wp_enqueue_script('dcl-magnific', DCL_PLUGIN_ASSETS . 'libs/magnific/magnific-popup.min.js', ['jquery'], DCL_PLUGIN_VERSION, true);

        // Enqueue Styles
        wp_enqueue_style('dcl-slick', DCL_PLUGIN_ASSETS . 'libs/slick/slick.min.css', null, DCL_PLUGIN_VERSION);
        wp_enqueue_style('dcl-magnific', DCL_PLUGIN_ASSETS . 'libs/magnific/magnific-popup.min.css', null, DCL_PLUGIN_VERSION);
    }

    /**
     * Enqueue Divi builder specific scripts
     * Only loads when Divi builder is active
     */
    public function enqueueBuilderScripts()
    {
        // Use global namespace for Divi function
        if (!\function_exists('\et_core_is_fb_enabled') || !\et_core_is_fb_enabled()) {
            return;
        }

        $this->enqueueStylesAndScripts('builder');
    }

    /**
     * Load backend data for Divi builder integration
     */
    public function load_backend_data()
    {
        if (!function_exists('et_fb_process_shortcode') || !class_exists(BackendHelpers::class)) {
            return;
        }

        $helpers = new BackendHelpers();
        $this->registerFiltersAndActions($helpers);
    }

    /**
     * Register filters and actions for backend helpers
     * @param BackendHelpers $helpers Instance of backend helpers
     */
    private function registerFiltersAndActions(BackendHelpers $helpers)
    {
        add_filter('et_fb_backend_helpers', [$helpers, 'static_asset_helpers'], 11);
        add_filter('et_fb_get_asset_helpers', [$helpers, 'asset_helpers'], 11);

        $enqueueScriptsCallback = function () use ($helpers) {
            wp_localize_script('et-frontend-builder', 'DCLBuilderBackend', $helpers->static_asset_helpers());
        };

        add_action('wp_enqueue_scripts', $enqueueScriptsCallback);
        add_action('admin_enqueue_scripts', $enqueueScriptsCallback);
    }
}
