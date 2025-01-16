<?php

namespace DiviTorqueLite;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Filesystem
{

    private static $instance;

    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get_filesystem()
    {

        global $wp_filesystem;

        if (!$wp_filesystem || 'direct' !== $wp_filesystem->method) {
            require_once ABSPATH . '/wp-admin/includes/file.php';

            /**
             * Context for filesystem, default false.
             *
             * @see request_filesystem_credentials_context
             */
            $context = apply_filters('request_filesystem_credentials_context', false);

            add_filter('filesystem_method', array($this, 'filesystem_method'));
            add_filter('request_filesystem_credentials', array($this, 'request_filesystem_credentials'));

            $creds = request_filesystem_credentials(site_url(), '', true, $context, null);

            WP_Filesystem($creds, $context);

            remove_filter('filesystem_method', array($this, 'filesystem_method'));
            remove_filter('request_filesystem_credentials', array($this, 'request_filesystem_credentials'));
        }

        // Set the permission constants if not already set.
        if (!defined('FS_CHMOD_DIR')) {
            define('FS_CHMOD_DIR', 0755);
        }
        if (!defined('FS_CHMOD_FILE')) {
            define('FS_CHMOD_FILE', 0644);
        }

        return $wp_filesystem;
    }

    public function filesystem_method()
    {
        return 'direct';
    }

    public function request_filesystem_credentials()
    {
        return true;
    }
}

Filesystem::get_instance();

function divi_torque_lite_filesystem()
{
    return Filesystem::get_instance()->get_filesystem();
}
