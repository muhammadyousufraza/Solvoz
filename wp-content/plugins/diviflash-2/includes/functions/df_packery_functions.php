<?php
/**
 * Packery: Return Options for Gallery
 * 
 * @return $options
 */
function df_pg_options($object, $images = null) {
    $options = array(
        'gallery' => $images === null ? (isset($object['gallery']) ? $object['gallery']: null)  : $images,
        'pg_layout' => isset($object['pg_layout']) ? $object['pg_layout'] : 'one',
        'space_between' => $object['space_between'],
        'show_caption' => $object['show_caption'],
        'show_description' => $object['show_description'],
        'load_more' => $object['load_more'],
        'image_count' => $object['image_count'],
        'init_count' => $object['init_count'],
        'use_lightbox_content' => isset($object['use_lightbox_content']) ? $object['use_lightbox_content'] : 'off',
        'use_lightbox' => isset($object['use_lightbox']) ? $object['use_lightbox'] : 'off',
        'use_lightbox_download' => isset($object['use_lightbox_download']) ? $object['use_lightbox_download'] : 'off',
        'content_reveal_caption' => $object['content_reveal_caption'],
        'content_reveal_description' => $object['content_reveal_description'],
        'content_position' => $object['content_position'],
        'always_show_title' => $object['always_show_title'],
        'always_show_description' => $object['always_show_description'],
        'overlay' => $object['overlay'],
        'caption_tag' => $object['caption_tag'], 
        'description_tag' => $object['description_tag'],
        'border_anim' => $object['border_anim'],
        'border_anm_style' => $object['border_anm_style'],
        'use_url' => isset($object['use_url']) ? $object['use_url'] : 'off',
        'url_target' =>  isset($object['url_target']) ? $object['url_target'] : 'same_window',
        'keep_dsk_tab' => $object['keep_dsk_tab']
    );
    return $options;
}

/**
 * Packery: Render markup for Gallery
 * 
 * @param $options array
 * @param $load_more_type boolean, whether it is load more request or not
 * @return $images | HTML Markup
 */
function df_pg_render_gallery_markup($options=[], $load_more_type = false, $load_count = 0){
    $default = array(
        'gallery' => '',
        'pg_layout' => '',
        'margin' => '',
        'show_caption' => 'off',
        'show_description' => 'off',
        'image_size' => 'large',
        'load_more' => 'off',
        'image_count' => 8,
        'init_count' => 8,
        'use_lightbox' => '',
        'use_lightbox_content' => '',
        'content_reveal_caption' => 'c4-fade-up',
        'content_reveal_description' => 'c4-fade-up',
        'content_position' => 'c4-layout-top-left',
        'image_scale' => 'no-image-scale',
        'caption_tag' => 'h4', 
        'description_tag' => 'p',
        'border_anim' => 'off',
        'border_anm_style' => 'c4-border-fade',
        'use_url' => '',
        'url_target' => '',
        'overlay' => '',
        'always_show_title' => '',
        'always_show_description' => '',
        'keep_dsk_tab' => 'off'
    );

    $default_image = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA4MCIgaGVpZ2h0PSI1NDAiIHZpZXdCb3g9IjAgMCAxMDgwIDU0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPHBhdGggZmlsbD0iI0VCRUJFQiIgZD0iTTAgMGgxMDgwdjU0MEgweiIvPgogICAgICAgIDxwYXRoIGQ9Ik00NDUuNjQ5IDU0MGgtOTguOTk1TDE0NC42NDkgMzM3Ljk5NSAwIDQ4Mi42NDR2LTk4Ljk5NWwxMTYuMzY1LTExNi4zNjVjMTUuNjItMTUuNjIgNDAuOTQ3LTE1LjYyIDU2LjU2OCAwTDQ0NS42NSA1NDB6IiBmaWxsLW9wYWNpdHk9Ii4xIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgICAgICA8Y2lyY2xlIGZpbGwtb3BhY2l0eT0iLjA1IiBmaWxsPSIjMDAwIiBjeD0iMzMxIiBjeT0iMTQ4IiByPSI3MCIvPgogICAgICAgIDxwYXRoIGQ9Ik0xMDgwIDM3OXYxMTMuMTM3TDcyOC4xNjIgMTQwLjMgMzI4LjQ2MiA1NDBIMjE1LjMyNEw2OTkuODc4IDU1LjQ0NmMxNS42Mi0xNS42MiA0MC45NDgtMTUuNjIgNTYuNTY4IDBMMTA4MCAzNzl6IiBmaWxsLW9wYWNpdHk9Ii4yIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgIDwvZz4KPC9zdmc+Cg==';

    $options = wp_parse_args($options, $default);
    extract($options); // phpcs:ignore WordPress.PHP.DontExtract
    $image_ids = explode(',', $gallery);
    $images = '';
    $_i = 0;

    $border_anim_class = $border_anim === 'on' ? $border_anm_style : '';

    foreach( $image_ids as $id ) {
        if ($load_more === 'on') {
            if ($_i >= $init_count && $load_more_type === false) {
                break;
            } 
        }
        $_i++;

        $layout_index = $_i;
        if ($load_more_type === true) {
            //$layout_index = $_i + $load_count;
            $layout_index = (int)$_i + (int)$load_count;
        }

        $details = $id !== '' ? get_post($id) : "";
        $content_box = '';
        $caption = '';
        $description = '';
        $always_title = $always_show_title === 'on' ? 
            'always-show-title c4-fade-up' : $content_reveal_caption;
        $always_description = $always_show_description === 'on' ? 
            'always-show-description c4-fade-up' : $content_reveal_description;

        if(('on' == $use_lightbox_content || 'on' == $show_caption) && $details){
            $caption = $details->post_excerpt !== ''?
                sprintf('<div class="%3$s %4$s"><%2$s class="df_pg_caption">%1$s</%2$s></div>', 
                    wp_kses_post($details->post_excerpt, 'divi_flash'), 
                    esc_attr($caption_tag), 
                    esc_attr($always_title),
                    esc_attr($show_caption !='on' ? 'df-hide-title' : '')
                ) : '';
        }
        if(('on' == $use_lightbox_content || 'on' == $show_description) && $details) {
            $description = $details->post_content !== ''?
                sprintf('<div class="%3$s %4$s"><%2$s class="df_pg_description">%1$s</%2$s></div>', 
                    wp_kses_post($details->post_content, 'divi_flash'), 
                    esc_attr($description_tag), 
                    esc_attr($always_description),
                    esc_attr($show_description !='on' ? 'df-hide-description' : '')
                ) : '';  
        }

        $content_box = sprintf('%1$s%2$s', $caption, $description);

        $show_lightbox_content = $use_lightbox_content === 'on' && $content_box !== '' ? 
            'data-sub-html=".df_pg_content"' : '';

        $custom_url = $use_url === 'on' ? 
            sprintf('data-customurl="%1$s" data-target="%2$s"', 
                esc_attr(get_post_meta( $id, 'df_ig_url', true )),
                esc_attr($url_target)
            ) 
            : '';

        $image_url = wp_get_attachment_image_src($id, $image_size);

        $image_url = !empty($image_url) && !is_bool($image_url[0]) ? $image_url[0] : $default_image;

        $media_lightbox = wp_get_attachment_image_src($id, 'original');
        $lightbox_image_url = $media_lightbox != '' && !is_bool($media_lightbox) ? $media_lightbox[0] : $default_image;

        $image = sprintf('<div class="df_pg_item%11$s" data-src="%8$s" %4$s %10$s>
                <figure class="c4-izmir df_pg_image %6$s %7$s %9$s" %10$s style="background-image:url(%1$s);">
                    %12$s
                    <figcaption class="df_pg_content %5$s">
                        %3$s
                    </figcaption>
                </figure></div>', 
            esc_attr( $image_url ), 
            esc_attr(get_post_meta($id , '_wp_attachment_image_alt', true)),
            $content_box, 
            $show_lightbox_content,
            esc_attr($content_position),
            esc_attr($image_scale),
            esc_attr(' has_overlay'),
            esc_attr($lightbox_image_url),
            esc_attr($border_anim_class),
            $custom_url,
            df_pg_layout_classes($layout_index, $pg_layout),
            $overlay === 'on' ? '<span class="df-overlay"></span>' : '',
            $use_lightbox
        );

        $images .= $image;
    }
    return $images;
}

/**
 * Packery: Render image for Gallery FB
 * 
 * @return json response
 */
add_action('wp_ajax_df_pg_render_image', 'df_pg_render_image_gallery_fb_callback');
function df_pg_render_image_gallery_fb_callback() {

    $data = json_decode(file_get_contents('php://input'), true);

    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }

    $gallery_array = df_pg_options($data);
    $images = df_pg_render_gallery_markup($gallery_array);
    
    wp_send_json_success($images);
}

function df_pg_galler_load_actions( $actions ) {
	$actions[] = 'df_pg_render_image';

	return $actions;
}
add_filter( 'et_builder_load_actions', 'df_pg_galler_load_actions' );

/**
 * Packery: Load More image with Fetch
 * 
 * @return json response
 */
add_action('wp_ajax_df_pg_fetch', 'df_pg_load_more_image');
add_action('wp_ajax_nopriv_df_pg_fetch', 'df_pg_load_more_image');
function df_pg_load_more_image() {

    if (isset($_POST['et_frontend_nonce']) && !wp_verify_nonce( sanitize_text_field($_POST['et_frontend_nonce']), 'et_frontend_nonce' )) {
        wp_die();
    }

    $options = isset($_POST["options"]) ? json_decode(stripslashes(sanitize_text_field($_POST["options"])), true) : '';
    $gallery =  isset($_POST['gallery']) ? sanitize_text_field($_POST['gallery']) : '';
    $image_count = isset($_POST['image_count']) ? sanitize_text_field($_POST['image_count']) : '';
    $loaded = isset($_POST['loaded']) ? sanitize_text_field($_POST['loaded']) : '';
    if(empty($gallery)){
        wp_die(); 
    }
    $images_array = explode(',', $gallery);
    $images_array = array_slice($images_array, $loaded, $image_count);

    $_images = $gallery !== '' ? implode(',', $images_array) : '';

    $gallery_array = df_pg_options($options, $_images);

    $images = df_pg_render_gallery_markup($gallery_array, true, $loaded);

    wp_send_json_success( $images );
}

/**
 * Packery: Generate layout classes
 * 
 * @param Int $index
 * @param String $style
 * @return String $classes
 */
function df_pg_layout_classes($index, $pg_layout) {
    $classes = '';

    if ($pg_layout === 'one') {
        if ($index%8 === 3 || $index%8 === 5) {
            $classes = ' df_pg_item--width-height2';
        } else if ($index%8 === 4 || $index%8 === 0) {
            $classes = ' df_pg_item--width2';
        }
    } else if($pg_layout === 'two') {
        if ($index%3 === 0 && ($index + 1)%2 === 0) {
            $classes = ' df_pg_item--width-height2';
        } else if($index%2 === 0 && ($index -1)%3 === 0) {
            $classes = ' df_pg_item--width-height2';
        }
    } else if ($pg_layout === 'three') {
        if ($index%6 === 0 || $index%6 === 5) {
            $classes = ' df_pg_item--width-height2';
        } 
    } else if ($pg_layout === 'four') {
        if (df_get_lastDigit($index) === 3 || df_get_lastDigit($index) === 6) {
            $classes = ' df_pg_item--width-height2';
        } 
    } else if ( $pg_layout === 'five' ){
        if ($index%9 === 0 || $index%9 === 5 || $index%9 === 1) {
            $classes = ' df_pg_item--width-height2';
        } else {
            $classes = ' df_pg_item--height2';
        }
    } else if ( $pg_layout === 'six' ){
        if($index%16 === 1 || $index%16 === 11) {
            $classes = ' df_pg_item--width-height2';
        } else if ($index%16 === 7 || $index%16 === 15) {
            $classes = ' df_pg_item--width2';
        }
    } else if ( $pg_layout === 'seven' ){
        if($index%5 === 2) {
            $classes = ' df_pg_item--width-height2';
        }
    } else if ( $pg_layout === 'eight' ){
        if($index%6 === 2 || $index%6 === 3) {
            $classes = ' df_pg_item--height2';
        }
    } else if ( $pg_layout === 'nine' ){
        if($index%6 === 1 || $index%6 === 4) {
            $classes = ' df_pg_item--height2';
        }
    } else if ( $pg_layout === 'ten' ){
        if($index%10 === 1 || $index%10 === 3 || $index%10 === 6 || $index%10 === 9) {
            $classes = ' df_pg_item--height2';
        } else if($index%10 === 2 || $index%10 === 0) {
            $classes = ' df_pg_item--width2';
        }
    }
    
    return $classes;
}

// return the last digit 
function df_get_lastDigit($n) { 
    return ((int)$n % 10); 
} 