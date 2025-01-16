<?php

namespace DiviTorqueLite;

class BackendHelpers
{

    private function dummyData()
    {
        return array(
            'title'    => _x('Your Title Goes Here', 'Modules dummy content', 'divitorque'),
            'subtitle' => _x('Subtitle goes Here', 'divitorque'),
            'body'     => _x(
                '<p>Edit or remove this text inline or in the module Content settings. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin accumsan ipsum placerat lectus placerat ultricies.</p>',
                'divitorque'
            ),
            'text_color' => '#354559',
            'background_color' => '#3979ff',
        );
    }

    public function static_asset_helpers($exists = array())
    {
        $dummyData = $this->dummyData();

        $business_hour_child = $this->generate_module_shortcodes('ba_business_hour_child', [
            ['day' => __('Monday', 'addons-for-divi'), 'time' => __('08:00 - 14:00', 'addons-for-divi')],
            ['day' => __('Tuesday', 'addons-for-divi'), 'time' => __('08:00 - 14:00', 'addons-for-divi')],
            ['day' => __('Wednesday', 'addons-for-divi'), 'time' => __('08:00 - 14:00', 'addons-for-divi')],
            ['day' => __('Thursday', 'addons-for-divi'), 'time' => __('08:00 - 14:00', 'addons-for-divi')],
            ['day' => __('Friday', 'addons-for-divi'), 'time' => __('08:00 - 14:00', 'addons-for-divi')],
            ['day' => __('Saturday', 'addons-for-divi'), 'time' => __('08:00 - 14:00', 'addons-for-divi')],
            ['day' => __('Sunday', 'addons-for-divi'), 'time' => __('Closed', 'addons-for-divi')],
        ]);

        $image_carousel_child = $this->generate_module_shortcodes('ba_image_carousel_child', [
            ['photo' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/dog6.jpg',],
            ['photo' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/dog5.jpg',],
            ['photo' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/dog3.jpg',],
            ['photo' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/dog4.jpg',],
            ['photo' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/dog7.jpg',],
        ]);

        $logo_carousel_child = $this->generate_module_shortcodes('ba_logo_carousel_child', [
            ['logo' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-1.svg',],
            ['logo' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-2.svg',],
            ['logo' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-3.svg',],
            ['logo' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-4.svg',],
            ['logo' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-5.svg',],
            ['logo' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-6.svg',],
        ]);

        $logo_grid_child = $this->generate_module_shortcodes('ba_logo_grid_child', [
            [
                'logo_url' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-1.svg',
                'background_color' => '#e2e5ed',
                'custom_padding' => '50px|50|50px|50|false|false'
            ],
            [
                'logo_url' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-2.svg',
                'background_color' => '#e2e5ed',
                'custom_padding' => '50px|50|50px|50|false|false'
            ],
            [
                'logo_url' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-3.svg',
                'background_color' => '#e2e5ed',
                'custom_padding' => '50px|50|50px|50|false|false'
            ],
            [
                'logo_url' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-4.svg',
                'background_color' => '#e2e5ed',
                'custom_padding' => '50px|50|50px|50|false|false'
            ],
            [
                'logo_url' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-5.svg',
                'background_color' => '#e2e5ed',
                'custom_padding' => '50px|50|50px|50|false|false'
            ],
            [
                'logo_url' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-6.svg',
                'background_color' => '#e2e5ed',
                'custom_padding' => '50px|50|50px|50|false|false'
            ],
            [
                'logo_url' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-7.svg',
                'background_color' => '#e2e5ed',
                'custom_padding' => '50px|50|50px|50|false|false'
            ],
            [
                'logo_url' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-8.svg',
                'background_color' => '#e2e5ed',
                'custom_padding' => '50px|50|50px|50|false|false'
            ],
            [
                'logo_url' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/logo/logo-9.svg',
                'background_color' => '#e2e5ed',
                'custom_padding' => '50px|50|50px|50|false|false'
            ],
        ]);

        $skill_bar_child = $this->generate_module_shortcodes('ba_skill_bar_child', [
            ['use_name' => 'on', 'name' => __('HTML', 'addons-for-divi'), 'level' => '90%'],
            ['use_name' => 'on', 'name' => __('CSS', 'addons-for-divi'), 'level' => '80%'],
            ['use_name' => 'on', 'name' => __('JavaScript', 'addons-for-divi'), 'level' => '70%'],
            ['use_name' => 'on', 'name' => __('PHP', 'addons-for-divi'), 'level' => '60%'],
            ['use_name' => 'on', 'name' => __('Python', 'addons-for-divi'), 'level' => '50%'],
        ]);

        $helpers = [
            'defaults' => [

                'ba_animated_text' => [
                    'prefix' => __('We can bring', 'addons-for-divi'),
                    'animated_text'  => '[
                        {"value":"Money","checked":0,"dragID":1},
                        {"value":"Respect","checked":0,"dragID":2},
                        {"value":"Success","checked":0,"dragID":3}
                    ]',
                    'suffix' => __('to your business', 'addons-for-divi'),
                    'animation_type' => 'typed',
                    'animated_text_color' => '#354559',
                    'text_alignment' => 'center',
                    'main_text_color' => '#3979ff',

                ],

                'ba_image_compare' => [
                    'before_img' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/dog1.jpg',
                    'after_img'  => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/dog2.jpg',
                    'before_label' => __('Before', 'addons-for-divi'),
                    'after_label' => __('After', 'addons-for-divi'),
                    'orientation' => 'horizontal',
                    'before_label_bg' => '#3979ff',
                    'after_label_bg' => '#3979ff',
                ],

                'ba_business_hour' => [
                    'content' => et_fb_process_shortcode($business_hour_child),
                    'day_font' => "|600|||||||",
                    'day_font_size' =>  "1rem",
                    'day_text_color' => "#354559",
                    'show_title' => 'on',
                    'title' => __('Work Hours', 'addons-for-divi'),
                    'title_font_size' => "2rem",
                    'title_font' => "|700|||||||",
                    'title_text_align' => "center",
                ],

                'ba_image_carousel' => [
                    'content' => et_fb_process_shortcode($image_carousel_child),
                    'slide_count' => '4',
                    'use_nav' => 'on',
                    'nav_height' => '48px',
                    'nav_width' => '48px',
                    'nav_icon_size' => '30px',
                    'nav_color' => '#ffffff',
                    'nav_bg' => '#3979ff',
                    'nav_pos_x' => '-15px',
                    'icon_left' => '&#xf104;||fa||900',
                    'icon_right' => '&#xf105;||fa||900',
                    'content_alignment' => 'center',
                ],

                'ba_dual_button' => [
                    'btn_alignment' => "center",
                    'btn_a_text' => __('Get Started', 'addons-for-divi'),
                    'btn_b_text' => __('View Demo', 'addons-for-divi'),
                    'button_gap' => "10px",
                    'custom_btn_a' => 'on',
                    'btn_a_use_icon' => 'off',
                    'btn_a_bg_color' => "#3979ff",
                    'btn_a_text_color' => "#ffffff",
                    'btn_a_text_size' => "1rem",
                    'btn_a_border_color' => "#3979ff",
                    'btn_a_border_radius' => "50px",
                    'custom_btn_b' => 'on',
                    'btn_b_use_icon' => 'off',
                    'btn_b_bg_color' => "#ffffff",
                    'btn_b_text_color' => "#3979ff",
                    'btn_b_text_size' => "1rem",
                    'btn_b_border_color' => "#3979ff",
                    'btn_b_border_radius' => "50px",
                ],

                'ba_flipbox' => [
                    'front_media_type' => 'image',
                    'front_img' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/dog1.jpg',
                    'front_title' => __('Flip Box', 'addons-for-divi'),
                    'front_description' => __('This is a flip box module', 'addons-for-divi'),
                    'front_padding' => '0px|0px|0px|0px',
                    'front_img_width' => '120px',
                    'front_img_height' => '120px',
                    'front_bg_color' => '#ffffff',
                    'border_radii_front_media' => 'on|100px|100px|100px|100px',
                    'front_title_font_size' => '1.5rem',
                    'front_description_font_size' => '1rem',
                    'front_desc_spacing' => '10px',

                    'border_radii_card' => 'on|9px|9px|9px|9px',
                    'border_width_all_card' => '1px',
                    'border_color_all_card' => '#3979ff',

                    'back_media_type' => 'none',
                    'back_title' => $dummyData['title'],
                    'back_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin accumsan ipsum placerat lectus.',
                    'back_padding' => '0px|0px|0px|0px',
                    'back_img_width' => '120px',
                    'back_img_height' => '120px',
                    'back_bg_color' => '#3979ff',
                    'border_radii_back_media' => 'on|100px|100px|100px|100px',
                    'back_title_font_size' => '1.5rem',
                    'back_title_text_color' => '#ffffff',
                    'back_description_font_size' => '1rem',
                    'back_description_text_color' => '#ffffff',
                    'back_desc_spacing' => '10px',

                ],

                'ba_gradient_heading' => [
                    'title' => __('Awesome Gradient Heading', 'addons-for-divi'),
                    'html_tag' => 'h2',
                    'primary_color' => '#3979ff',
                    'secondary_color' => '#354559',
                    'primary_color_location' => '30',
                    'secondary_color_location' => '70',
                    'angle' => '45',
                    'title_font_size' => '3rem',
                ],

                'ba_icon_box' => [
                    'use_image' => 'off',
                    'icon' => '&#xf1a9;||fa||400',
                    'icon_color' => '#3979ff',
                    'icon_size' => '60px',
                    'icon_width' => '60px',
                    'icon_height' => '60px',
                    'icon_padding' => '0px|0px|0px|0px',
                    'icon_spacing' => '15px',

                    'title' => 'Awesome Icon Box',
                    'title_font_size' => '1.5rem',
                    'title_line_height' => '1.2em',
                    'title_level' => 'h2',
                    'title_spacing' => '10px',
                    'title_font' => '|700|||||||',

                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin accumsan ipsum placerat lectus.',
                    'description_font_size' => '1rem',
                    'description_line_height' => '1.4em',

                    'border_radii_box' => 'on|9px|9px|9px|9px',
                    'box_shadow_blur_item' => '0px',
                    'box_shadow_color_item' => 'rgba(0,0,0,0.1)',
                    'box_shadow_horizontal_item' => '10px',
                    'box_shadow_position_item' => 'outer',
                    'box_shadow_spread_item' => '0px',
                    'box_shadow_style_item' => 'preset4',
                    'box_shadow_vertical_item' => '10px',
                ],

                'ba_info_box' => [
                    'main_figure' => 'image',
                    'photo' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/dog5.jpg',
                    'title' => 'Awesome Info Box',
                    'body_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin accumsan ipsum placerat lectus.',
                    'use_button' => 'on',
                    'button_text' => 'Learn More',
                    'button_link' => '#',
                    'content_alignment' => 'center',

                    'border_radii_photo' => 'on|3px|3px|3px|3px',
                    'btn_spacing_top' => '40px',
                    'custom_button' => 'on',
                    'button_use_icon' => 'off',
                    'button_bg_color' => "#ffffff",
                    'button_text_color' => "#3979ff",
                    'button_text_size' => "1rem",
                    'button_border_color' => "#3979ff",
                    'button_border_radius' => "50px",
                    'button_custom_padding' => '0.7rem|2rem|0.7rem|2rem|true|true'
                ],

                'ba_alert' => [
                    'use_icon' => 'on',
                    'icon' => '&#xf1a9;||fa||400',
                    'icon_size' => '48px',
                    'icon_color' => '#3979ff',
                    'icon_spacing' => '15px',
                    'title' => 'Awesome Inline Notice',
                    'title_text_color' => '#FFFFFF',
                    'title_font_size' => ' 16px',
                    'title_font' => '|700|||||||',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin accumsan ipsum placerat lectus.',
                    'body_text_color' => '#FFFFFF',
                    'body_font_size' => ' 14px',
                    'alert_type' => 'info',
                    'background_color' => '#354559',
                    'border_radii_main' => 'on|9px|9px|9px|9px',
                    'dismiss_size' => '2rem',
                    'dismiss_color' => '#3979ff',
                ],

                'ba_logo_carousel' => [
                    'content' => et_fb_process_shortcode($logo_carousel_child),
                    'slide_count' => '4',
                    'use_nav' => 'on',
                    'nav_height' => '48px',
                    'nav_width' => '48px',
                    'nav_icon_size' => '30px',
                    'nav_color' => '#ffffff',
                    'nav_bg' => '#3979ff',
                    'nav_pos_x' => '-15px',
                    'icon_left' => '&#xf104;||fa||900',
                    'icon_right' => '&#xf105;||fa||900',
                    'content_alignment' => 'center',
                ],

                'ba_logo_grid' => [
                    'content' => et_fb_process_shortcode($logo_grid_child),
                    'column_count' => '3',
                    'grid_gap' => '20px',
                    'logo_size' => 'center',
                ],

                'ba_news_ticker' => [
                    'use_title' => 'on',
                    'title' => 'Latest News',
                    'speed' => '50000ms',
                    'use_bullet' => 'on',
                    'bullet_color' => '#3979ff',
                    'title_padding' => '0.7rem|1rem|0.7rem|1rem',
                    'title_bg_color' => '#3979ff',
                    'title_text_color' => '#ffffff',
                    'text_text_color' => '#354559',
                    'text_font_size' => '1rem',
                    'border_radii_title' => 'on|0px|0px|0px|0px',
                    'title_font_size' => '1rem',
                    'border_radii_main' => 'on|3px|3px|3px|3px',
                    'border_width_all_main' => '1px',
                    'border_color_all_main' => '#3979ff',
                ],

                'ba_number' => [
                    'number' => '1,234,567',
                    'use_counter' => 'on',
                    'title' => 'Happy Clients',
                    'use_box' => 'on',
                    'number_height' => '80px',
                    'number_width' => '180px',
                    'number_bg_color' => '#3979ff',
                    'number_alignment' => 'center',
                    'number_font' => '|600|||||||',
                    'number_text_color' => '#ffffff',
                    'number_font_size' => '2rem',
                    'title_text_align' => 'center',
                    'title_font_size' => '1.5rem',
                    'title_text_color' => '#354559',
                    'border_radii_number' => 'on|100px|100px|100px|100px',
                ],

                'ba_post_list' => [
                    'posts_number' => '4',
                    'show_thumb' => 'on',
                    'border_radii_image' => 'on|3px|3px|3px|3px',
                    'show_icon' => 'off',
                    'show_excerpt' => 'on',
                    'excerpt_length' => '100',
                    'show_author' => 'on',
                    'item_spacing' => '30px',
                    'item_padding' => '0px|0px|30px|0px|false|false',
                    'image_width' => '100px',
                    'image_height' => '100px',
                    'image_spacing' => '30px',
                    'title_font' => '|700|||||||',
                    'title_font_size' => '1.5rem',
                    'title_text_color' => '#3979ff',
                    'content_font_size' => '1rem',
                    'content_text_color' => '#354559',
                    'excerpt_spacing' => '10px',

                    'meta_font' => '|700|||||||',
                    'meta_text_color' => '#354559',
                    'meta_font_size' => '1rem',
                    'meta_spacing' => '5px',

                    'border_width_bottom_post' => '1px',
                    'border_color_bottom_post' => '#e2e5ed',
                ],

                'ba_review' => [
                    'scale' => '5',
                    'rating' => '4.9',
                    'show_number' => 'on',
                    'image' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/dog4.jpg',
                    'border_radii_image' => 'on|9px|9px|9px|9px',
                    'use_badge' => 'off',

                    'title' => 'Awesome Review',
                    'title_bottom_spacing' => '20px',
                    'title_level' => 'h2',
                    'title_font_size' => '1.5rem',
                    'title_text_color' => '#3979ff',
                    'title_font' => '|700|||||||',

                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin accumsan ipsum placerat lectus.',
                    'desc_font_size' => '1rem',
                    'desc_text_color' => '#354559',

                    'use_button' => 'on',
                    'button_text' => 'Read More',
                    'custom_button' => 'on',
                    'button_text_size' => '1rem',
                    'button_text_color' => '#3979ff',
                    'button_bg_color' => '#ffffff',
                    'button_border_width' => '1px',
                    'button_border_color' => '#3979ff',
                    'button_border_radius' => '50px',
                    'button_use_icon' => 'off',
                    'btn_spacing_top' => '20px',

                    'star_size' => '24px',
                    'star_spacing' => '5px',
                    'rating_bottom_spacing' => '20px',

                    'star_color' => '#b2bad1',
                    'star_active_color' => '#f7d154',

                    'rating_text_size' => '1rem',
                    'rating_text_color' => '#354559',

                    'content_alignment' => 'center',
                    'background_color' => '#f2f3f7',
                    'custom_padding' => '30px|30|30px|30|false|false',
                    'border_radii_main' => 'on|9px|9px|9px|9px',
                    'overlay_on_hover' => 'off',

                ],

                'ba_scroll_image' => [
                    'image' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/scroll-img.jpg',
                    'image_alt' => 'Scroll Image',
                    'show_icon' => 'on',
                    'icon' => '&#xf053;||fa||900',
                    'icon_color' => '#3979ff',
                    'icon_size' => '60px',
                    'use_icon_anim' => 'on',
                    'scroll_type' => 'on_hover',
                    'scroll_dir_hover' => 'X_ltr',
                    'scroll_speed' => '1000ms',
                ],

                'ba_skill_bar' => [
                    'content' => et_fb_process_shortcode($skill_bar_child),
                ],

                'ba_advanced_team' => [
                    'photo' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/dog5.jpg',
                    'member_name' => 'John Doe',
                    'name_font_size' => '1rem',
                    'name_text_color' => '#3979ff',
                    'name_font' => '|700|||||||',
                    'job_title' => 'CEO & Founder',
                    'job_font_size' => '1rem',
                    'job_text_color' => '#354559',
                    'short_bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin accumsan ipsum placerat lectus.',
                    'website' => '#',
                    'facebook' => '#',
                    'twitter' => '#',
                    'linkedin' => '#',
                    'photo_width' => '120px',
                    'photo_height' => '120px',
                    'photo_alignment' => 'center',
                    'border_radii_photo' => 'on|100px|100px|100px|100px',
                    'content_alignment' => 'center',
                    'name_bottom_spacing' => '10px',

                    'social_icon_color' => '#ffffff',
                    'links_bg' => '#3979ff',
                    'links_radius' => '50px',
                ],

                'ba_testimonial' => [
                    'image' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/dog1.jpg',
                    'image_alt' => 'Testimonial Image',
                    'name' => 'John Doe',
                    'name_bottom_spacing' => '10px',
                    'title' => 'CEO & Founder',
                    'job_bottom_spacing' => '10px',
                    'name_font' => '|700|||||||',
                    'name_font_size' => '1rem',
                    'name_text_color' => '#3979ff',
                    'job_title_font' => '|400|||||||',
                    'job_title_font_size' => '1rem',
                    'job_title_text_color' => '#354559',
                    'use_rating' => 'on',
                    'rating' => '5',
                    'testimonial' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin accumsan ipsum placerat lectus.',
                    'selected_icon' => '1',
                    'website_url' => '#',
                    'alignment' => 'center',
                    'content_padding' => '30px|30|30px|30|false|false',

                    'border_radii_image' => 'on|100px|100px|100px|100px',
                    'border_radii_main' => 'on|9px|9px|9px|9px',
                    'border_width_all_main' => '1px',
                    'border_color_all_main' => '#e2e5ed',
                    'ratings_position' => 'reviewer',
                ],

                'ba_video_popup' => [
                    'image' => DIVI_TORQUE_LITE_ASSETS . 'imgs/demo/landscape.jpg',
                    'type' => 'yt',
                    'video_link' => 'https://www.youtube.com/watch?v=WSdWSToS5LY',
                    'img_height' => '280px',
                    'icon_color' => '#3979ff',
                    'border_radii' => 'on|9px|9px|9px|9px',
                    'box_shadow_style' => 'preset1',
                    'box_shadow_horizontal' => '0px',
                    'box_shadow_vertical' => '2px',
                    'box_shadow_blur' => '18px',
                    'box_shadow_spread' => '0px',
                    'box_shadow_color' => 'rgba(0,0,0,0.2)',
                    'box_shadow_position' => 'outer',
                ],

                'ba_card'  => [
                    'use_icon' => 'on',
                    'icon' => '&#xf1a9;||fa||400',
                    'title' => 'Awesome Card',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin accumsan ipsum placerat lectus.',

                    'use_button' => 'on',
                    'button_text' => 'Read More',
                    'button_link' => '#',

                    'icon_color' => '#3979ff',
                    'icon_size' => '60px',
                    'icon_padding' => '0px|0px|10px|0px',

                    'content_alignment' => 'center',
                    'content_padding' => '0px|0px|0px|0px|false|false',
                    'custom_padding' => '30px|30px|30px|30px|false|false',

                    'title_font_size' => '1.5rem',
                    'title_text_color' => '#3979ff',
                    'title_font' => '|700|||||||',

                    'custom_button' => 'on',
                    'button_text_size' => '1rem',
                    'button_text_color' => '#3979ff',
                    'button_bg_color' => '#ffffff',
                    'button_border_width' => '1px',
                    'button_border_color' => '#3979ff',
                    'button_border_radius' => '50px',
                    'button_font' => '|700|||||||',
                    'button_use_icon' => 'off',

                    'btn_spacing_top' => '20px',

                    'border_radii_card' => 'on|9px|9px|9px|9px',
                    'border_color_all_card' => '#3979ff',
                    'border_style_all_card' => 'solid',
                    'border_width_right_card' => '1px',
                ],
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
            ';window.diviTorqueLiteBuilderBackend=%1$s; jQuery.extend(true, window.ETBuilderBackend, %1$s);',
            et_fb_remove_site_url_protocol(wp_json_encode($helpers))
        );
    }
}
