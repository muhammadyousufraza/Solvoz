<?php

namespace DiviTorqueLite;

class Deprecated
{

    public function __construct()
    {
        $this->includes();

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function enqueue_scripts()
    {
        $js_path  = DIVI_TORQUE_LITE_ASSETS . 'deprecated/';
        $css_path = DIVI_TORQUE_LITE_ASSETS . 'deprecated/';
        $version  = DIVI_TORQUE_LITE_VERSION;

        $prefix = defined('DTQ_DEBUG') && true === constant('DTQ_DEBUG') ? '' : '.min';

        wp_enqueue_style('dtqc-deprecated', $css_path . 'index' . $prefix . '.css', null, $version);
        wp_enqueue_script('dtqj-popup', $js_path . 'popup' . $prefix . '.js', array('jquery'), $version, true);
        wp_register_script('dtqj-marvin', $js_path . 'index' . $prefix . '.js', array('jquery'), $version, true);
    }

    public function includes()
    {
        require_once DIVI_TORQUE_LITE_DIR . 'includes/deprecated/functions.php';
        require_once DIVI_TORQUE_LITE_DIR . 'includes/deprecated/customizer/customizer.php';
        require_once DIVI_TORQUE_LITE_DIR . 'includes/deprecated/extensions/popup-maker/ext-post-type.php';
        require_once DIVI_TORQUE_LITE_DIR . 'includes/deprecated/extensions/popup-maker/popup-settings.php';
        require_once DIVI_TORQUE_LITE_DIR . 'includes/deprecated/extensions/popup-maker/ext-popup-maker.php';
        require_once DIVI_TORQUE_LITE_DIR . 'includes/deprecated/extensions/login-designer/ext-login-designer.php';
        require_once DIVI_TORQUE_LITE_DIR . 'includes/deprecated/extensions/login-designer/ext-page-template.php';
        require_once DIVI_TORQUE_LITE_DIR . 'includes/deprecated/extensions/login-designer/ext-installer.php';
        require_once DIVI_TORQUE_LITE_DIR . 'includes/deprecated/extensions/library-shortcodes/ext-library-shortcodes.php';
    }

    public function run()
    {
        $login_designer = new \DiviTorque\Ext\LoginDesigner\Installer();
        $login_designer->run();

        $popup_postype = new \DiviTorque\Popup_Post_Type();
        $popup_postype->register_post_type();
        flush_rewrite_rules();
    }
}

new Deprecated();
