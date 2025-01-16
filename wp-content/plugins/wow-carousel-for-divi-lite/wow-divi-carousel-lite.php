<?php
/*
Plugin Name: Divi Carousel Lite
Plugin URI:  https://diviepic.com/
Description: Divi Carousel Lite is a free WordPress plugin that allows you to create stunning carousels for your Divi site.
Version: 2.0.4
Author: DiviEpic
Author URI:  https://diviepic.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: divi-carousel-lite
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit;
}

define('DCL_PLUGIN_VERSION', '2.0.4');
define('DCL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DCL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('DCL_PLUGIN_ASSETS', trailingslashit(DCL_PLUGIN_URL . 'assets'));
define('DCL_PLUGIN_FILE', __FILE__);
define('DCL_PLUGIN_BASE', plugin_basename(__FILE__));

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    return;
}

require_once __DIR__ . '/vendor/autoload.php';

function dcl_is_pro_installed()
{
    return defined('DIVI_CAROUSEL_PRO_VERSION');
}

function dcl_is_dm_pro_installed()
{
    return defined('DIVI_CAROUSEL_PRO_VERSION') && 'wow-divi-carousel' === DIVI_CAROUSEL_PRO_BASE;
}

require_once 'plugin-loader.php';
