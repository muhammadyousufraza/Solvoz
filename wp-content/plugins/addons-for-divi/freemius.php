<?php

if (!function_exists('dtp_fs')) {

    function dtp_fs()
    {

        global $dtp_fs;

        if (!isset($dtp_fs)) {

            require_once dirname(__FILE__) . '/freemius/start.php';

            $dtp_fs = fs_dynamic_init(array(
                'id'                => '14886',
                'slug'              => 'addons-for-divi',
                'premium_slug'      => 'divitorque-pro',
                'type'              => 'plugin',
                'public_key'        => 'pk_8f558616fc3f1a6ad3193595141b1',
                'is_premium'        => false,
                'is_premium_only'   => false,
                'has_addons'        => false,
                'has_paid_plans'    => true,
                'is_org_compliant'  => true,
                'menu'              => array(
                    'slug'    => 'divitorque',
                    'contact' => false,
                    'support' => false,
                    'parent'  => array(
                        'slug' => 'diviepic-plugins',
                    ),
                ),
                'is_live'         => true,
            ));
        }

        return $dtp_fs;
    }
}

// Register hooks and actions.
function dtl_init_hooks()
{
    $dtp_fs = dtp_fs();

    // Set plugin icon
    $dtp_fs->add_filter('plugin_icon', function () {
        return __DIR__ . '/assets/imgs/icon.png';
    });

    // Disable affiliate notice
    $dtp_fs->add_filter('show_affiliate_program_notice', '__return_false');
    // Disable auto deactivation
    $dtp_fs->add_filter('deactivate_on_activation', '__return_false');
    // Disable redirect on activation
    $dtp_fs->add_filter('redirect_on_activation', '__return_false');

    // Signal that SDK was initiated.
    do_action('dtp_fs_loaded');
}

dtl_init_hooks();
