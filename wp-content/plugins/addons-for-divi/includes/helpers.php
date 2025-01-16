<?php

namespace DiviTorqueLite;

class Helpers
{
    public static function init($output = OBJECT)
    {
        $_instance         = new static();
        $_instance->output = $output;

        return $_instance;
    }

    public static function get_responsive_options($option_name, $props)
    {

        $option                = [];
        $last_edited           = $props["{$option_name}_last_edited"];
        $get_responsive_status = et_pb_get_responsive_status($last_edited);
        $is_responsive_enabled = isset($last_edited) ? $get_responsive_status : false;
        $option_name_tablet    = "{$option_name}_tablet";
        $option_name_phone     = "{$option_name}_phone";

        $option["responsive_status"] = $is_responsive_enabled ? true : false;

        if ($is_responsive_enabled && !empty($props[$option_name_tablet])) {
            $option["tablet"] = $props[$option_name_tablet];
        } else {
            $option["tablet"] = $props[$option_name];
        }

        if ($is_responsive_enabled && !empty($props[$option_name_phone])) {
            $option["phone"] = $props[$option_name_phone];
        } else {
            $option["phone"] = $props[$option_name];
        }

        $option["desktop"] = $props[$option_name];

        return $option;
    }

    public static function get_browser()
    {
        $browser = get_browser(null, true);

        return $browser['browser'];
    }

    public static function get_device()
    {
        $device = 'desktop';

        if (wp_is_mobile()) {
            $device = 'mobile';
        }

        return $device;
    }

    public static function get_ip()
    {
        $ip = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field($_SERVER['REMOTE_ADDR']) : false;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = sanitize_text_field($_SERVER['HTTP_CLIENT_IP']);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
        }

        return $ip;
    }

    public static function get_city()
    {
        $ip = self::get_ip();

        $url = "http://ip-api.com/json/{$ip}";

        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            return false;
        }

        $body = wp_remote_retrieve_body($response);

        $data = json_decode($body, true);

        if (isset($data['city'])) {
            return $data['city'];
        }

        return false;
    }

    public static function get_country()
    {
        $ip = self::get_ip();

        $url = "http://ip-api.com/json/{$ip}";

        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            return false;
        }

        $body = wp_remote_retrieve_body($response);

        $data = json_decode($body, true);

        if (isset($data['country'])) {
            return $data['country'];
        }

        return false;
    }
}
