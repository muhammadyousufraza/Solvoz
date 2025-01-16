<?php

namespace DiviTorqueLite;

use DiviTorqueLite\ModulesManager;

class AdminHelper
{

    public static function get_common_settings()
    {
        return [
            'modules_settings' => self::get_modules(),
        ];
    }

    public static function get_options()
    {
        $general_settings = self::get_common_settings();

        return apply_filters('divitorque_lite_global_data_options', $general_settings);
    }

    public static function get_modules()
    {
        $all_modules = ModulesManager::get_all_modules();
        $default_modules = [];

        foreach ($all_modules as $name => $value) {
            $_name = $value['name'];
            $default_modules[$_name] = $_name;
        }

        if (self::is_pro_installed()) {
            $saved_modules = get_option('_divitorque_modules', []);
        } else {
            $saved_modules = get_option('_divitorque_lite_modules', []);
        }

        return wp_parse_args($saved_modules, $default_modules);
    }

    public static function is_pro_installed()
    {
        return defined('DTP_VERSION');
    }

    public static function get_rollback_versions()
    {
        // Set cache key and maximum number of versions to keep.
        $cacheKey = 'divitorque_lite_rollback_versions_' . DIVI_TORQUE_LITE_VERSION;
        $max_versions = 5;

        // Retrieve cached rollback versions.
        $rollback_versions = get_transient($cacheKey);

        // If cached data isn't available, fetch it from the plugin API.
        if (empty($rollback_versions)) {
            require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

            // Request plugin information via the plugins API.
            $api = plugins_api('plugin_information', ['slug' => 'addons-for-divi']);

            // Return an empty array if the API request results in an error.
            if (is_wp_error($api)) {
                return [];
            }

            // Sort the plugin versions in descending order.
            $versions = $api->versions;
            krsort($versions);

            // Initialize an array to store the rollback versions.
            $rollback_versions = [];
            $count = 0;

            // Add up to $maxVersions rollback versions, skipping the current version.
            foreach ($versions as $version => $package) {
                if ($version === 'trunk' || $version === 'V3.5.3' || $version === 'V3.5.4') {
                    continue;
                }

                $rollback_versions[$version] = $package;
                $count++;

                // Stop adding versions once the limit is reached.
                if ($count >= $max_versions) {
                    break;
                }
            }

            $rollback_versions = array_slice($rollback_versions, 0, $max_versions, true);

            set_transient($cacheKey, $rollback_versions, 60 * 60 * 24);
        }

        return $rollback_versions;
    }
}
