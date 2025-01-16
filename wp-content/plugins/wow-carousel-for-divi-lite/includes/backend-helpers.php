<?php

namespace Divi_Carousel_Lite;

class BackendHelpers
{

    const ASSETS_PATH = 'assets';

    private function dummyData()
    {
        return array(
            'title'    => _x('Your Title Goes Here', 'Modules dummy content', 'divi-carousel-lite'),
            'subtitle' => _x('Subtitle goes Here', 'divi-carousel-lite'),
            'body'     => _x(
                '<p>Your content goes here. Edit or remove this text inline or in the module Content settings. You can also style every aspect of this content in the module Design settings and even apply custom CSS to this text in the module Advanced settings.</p>',
                'divi-carousel-lite'
            ),
        );
    }

    public function static_asset_helpers($exists = array())
    {
        $dummyData = $this->dummyData();

        $image_carousel_child = $this->generate_module_shortcodes('wdcl_image_carousel_child', [
            ['photo' => 'https://placehold.co/800x800/AED581/FFFFFF?text=Divi+Torque+Pro&font=montserrat'],
            ['photo' => 'https://placehold.co/800x800/FF8A65/FFFFFF?text=Divi+Torque+Pro&font=montserrat'],
            ['photo' => 'https://placehold.co/800x800/4DD0E1/FFFFFF?text=Divi+Torque+Pro&font=montserrat'],
            ['photo' => 'https://placehold.co/800x800/BA68C8/FFFFFF?text=Divi+Torque+Pro&font=montserrat'],
            ['photo' => 'https://placehold.co/800x800/FFD54F/333333?text=Divi+Torque+Pro&font=montserrat'],
            ['photo' => 'https://placehold.co/800x800/4DB6AC/FFFFFF?text=Divi+Torque+Pro&font=montserrat'],
            ['photo' => 'https://placehold.co/800x800/4DB6AC/FFFFFF?text=Divi+Torque+Pro&font=montserrat'],
        ]);

        $logo_carousel_child = $this->generate_module_shortcodes('wdcl_logo_carousel_child', [
            ['logo' => DCL_PLUGIN_URL . self::ASSETS_PATH . '/imgs/demo/logo/logoipsum1.svg'],
            ['logo' => DCL_PLUGIN_URL . self::ASSETS_PATH . '/imgs/demo/logo/logoipsum2.svg'],
            ['logo' => DCL_PLUGIN_URL . self::ASSETS_PATH . '/imgs/demo/logo/logoipsum3.svg'],
            ['logo' => DCL_PLUGIN_URL . self::ASSETS_PATH . '/imgs/demo/logo/logoipsum4.svg'],
            ['logo' => DCL_PLUGIN_URL . self::ASSETS_PATH . '/imgs/demo/logo/logoipsum5.svg'],
            ['logo' => DCL_PLUGIN_URL . self::ASSETS_PATH . '/imgs/demo/logo/logoipsum6.svg'],
            ['logo' => DCL_PLUGIN_URL . self::ASSETS_PATH . '/imgs/demo/logo/logoipsum7.svg']
        ]);

        $helpers = [
            'defaults' => [
                'wdcl_logo_carousel' => array_merge($dummyData, [
                    'content'   => et_fb_process_shortcode($logo_carousel_child),
                    'slide_count' => 5,
                ]),

                'wdcl_image_carousel' => array_merge($dummyData, [
                    'content'   => et_fb_process_shortcode($image_carousel_child),
                    'slide_count' => 4,
                ]),
            ]
        ];

        return array_merge_recursive($exists, $helpers);
    }

    private function generate_module_shortcodes($child_name, $optionsArray)
    {
        return implode('', array_map(function ($options) use ($child_name) {
            return $this->dummy_module_shortcode($child_name, $options);
        }, $optionsArray));
    }

    private function dummy_module_shortcode($child_name, $options)
    {
        $shortcode = sprintf('[%1$s', $child_name);
        foreach ($options as $key => $value) {
            $shortcode .= sprintf(' %1$s="%2$s"', $key, $value);
        }
        $shortcode .= sprintf('][/%1$s]', $child_name);
        return $shortcode;
    }

    public function asset_helpers($content)
    {
        $helpers = $this->static_asset_helpers();
        return $content . sprintf(
            ';window.DCLBuilderBackend=%1$s; jQuery.extend(true, window.ETBuilderBackend, %1$s);',
            et_fb_remove_site_url_protocol(wp_json_encode($helpers))
        );
    }
}
