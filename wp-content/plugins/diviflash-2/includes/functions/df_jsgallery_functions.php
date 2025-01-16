<?php
/**
 * JustifiedGallery: Return Options for Gallery
 * 
 * @return $options
 */
function df_jsg_options($object, $images = null) {
    $options = array(
        'gallery' => $images === null ? (isset($object['gallery']) ? $object['gallery']: null) : $images,
        'rowHeight' => isset($object['rowheight']) ? $object['rowheight'] : '',
        'margin' => isset($object['space_between']) ? $object['space_between'] : '',
        'show_caption' => $object['show_caption'],
        'show_description' => $object['show_description'],
        'load_more' => $object['load_more'],
        'image_count' => $object['image_count'],
        'ini_count' => $object['ini_count'],
        'show_content_lg' => $object['show_content_lg'],
        'use_lightbox' => isset($object['use_lightbox']) ? $object['use_lightbox'] : 'off',
        'use_lightbox_download' => isset($object['use_lightbox_download']) ? $object['use_lightbox_download'] : 'off',
        'content_reveal_caption' => $object['content_reveal_caption'],
        'content_reveal_description' => $object['content_reveal_description'],
        'content_position' => $object['content_position'],
        'image_scale' => $object['image_scale'],
        'overlay' => $object['overlay'],
        'image_size' => $object['image_size'],
        'caption_tag' => $object['caption_tag'], 
        'description_tag' => $object['description_tag'],
        'border_anim' => $object['border_anim'],
        'border_anm_style' => $object['border_anm_style'],
        'use_url' => isset($object['use_url']) ? $object['use_url'] : 'off',
        'url_target' => isset($object['url_target']) ? $object['url_target'] : 'same_window'
    );
    return $options;
}

/**
 * JustifiedGallery: Render markup for Gallery
 * 
 * @param $options array
 * @param $load_more_type boolean, whether it is load more request or not
 * @return $images | HTML Markup
 */
function df_jsg_render_gallery_markup($options=[], $load_more_type = false){
    $default = array(
        'gallery' => '',
        'margin' => '',
        'show_caption' => 'off',
        'show_description' => 'off',
        'image_size' => 'medium',
        'load_more' => 'off',
        'image_count' => 8,
        'ini_count' => 8,
        'show_content_lg' => 'off',
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
        'overlay' => ''
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
            if ($_i >= $ini_count && $load_more_type === false) {
                break;
            } 
        }
        $_i++;

        $details = get_post($id);
        $content_box = '';
        $caption = '';
        $description = '';
        if(('on' == $show_content_lg || 'on' == $show_caption) && $details) {
            $caption = $details->post_excerpt !== ''?
                sprintf('<div class="%3$s %4$s"><%2$s class="df_jsg_caption">%1$s</%2$s></div>', 
                    wp_kses_post($details->post_excerpt, 'divi_flash'), 
                    esc_attr($caption_tag), 
                    esc_attr($content_reveal_caption),
                    esc_attr($show_caption !='on' ? 'df-hide-title' : '')
                ) : '';
        }
        if(('on' == $show_content_lg || 'on' == $show_description) && $details) {
            $description = $details->post_content !== ''?
                sprintf('<div class="%3$s %4$s"><%2$s class="df_jsg_description">%1$s</%2$s></div>', 
                    wp_kses_post($details->post_content, 'divi_flash'), 
                    esc_attr($description_tag), 
                    esc_attr($content_reveal_description),
                    esc_attr($show_description !='on' ? 'df-hide-description' : '')
                ) : '';
        }

        $content_box = sprintf('%1$s%2$s', $caption, $description);

        $show_content_lightbox = $show_content_lg === 'on' && $content_box !== '' ? 
            'data-sub-html=".df_jsg_content"' : '';
            
        $custom_url = $use_url === 'on' ? 
            sprintf('data-customurl="%1$s" data-target="%2$s"', 
                esc_attr(get_post_meta( $id, 'df_ig_url', true )),
                esc_attr($url_target)
            ) 
            : '';

        $loading_class = 'image_loading';

        $image_url = $image_url_array = wp_get_attachment_image_src($id, $image_size);

        $image_url = !empty($image_url) && !is_bool($image_url[0]) ? $image_url[0] : $default_image;

        $media_lightbox = wp_get_attachment_image_src($id, 'original');
        $lightbox_image_url = $media_lightbox != '' && !is_bool($media_lightbox) ? $media_lightbox[0] : $default_image;

        $image = sprintf('<figure class="c4-izmir df_jsg_image %6$s %7$s %9$s %11$s" data-src="%8$s" %4$s %10$s>
                    %12$s
                    
                    <img class="jsg-image" src="%1$s" alt="%2$s" class="" width="%13$s" height="%14$s"/>
                    <figcaption class="df_jsg_content %5$s">
                        %3$s
                    </figcaption>
                </figure>', 
            esc_attr( $image_url ), 
            esc_attr(get_post_meta($id , '_wp_attachment_image_alt', true)),
            $content_box, 
            $show_content_lightbox,
            esc_attr($content_position),
            esc_attr($image_scale),
            esc_attr(' has_overlay'),
            esc_attr($lightbox_image_url),
            esc_attr($border_anim_class),
            $custom_url,
            $loading_class,
            $overlay === 'on' ? '<span class="df-overlay"></span>' : '',
            esc_attr($image_url_array[1]),
            esc_attr($image_url_array[2])
        );

        $images .= $image;
    }
    return $images;
}

/**
 * JustifiedGallery: Render image for Gallery FB
 * 
 * @return json response
 */
add_action('wp_ajax_df_jsg_render_image', 'df_jsg_render_image_gallery_fb_callback');
function df_jsg_render_image_gallery_fb_callback() {

    $data = json_decode(file_get_contents('php://input'), true);

    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }

    $gallery_array = df_jsg_options($data);
    $images = df_jsg_render_gallery_markup($gallery_array);
    
    wp_send_json_success($images);
}

function df_jsg_galler_load_actions( $actions ) {
	$actions[] = 'df_jsg_render_image';

	return $actions;
}
add_filter( 'et_builder_load_actions', 'df_jsg_galler_load_actions' );

/**
 * JustifiedGallery: Load More image with Fetch
 * 
 * @return json response
 */
add_action('wp_ajax_df_jsg_fetch', 'df_jsg_load_more_image');
add_action('wp_ajax_nopriv_df_jsg_fetch', 'df_jsg_load_more_image');
function df_jsg_load_more_image() {

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

    $gallery_array = df_jsg_options($options, $_images);

    $images = df_jsg_render_gallery_markup($gallery_array, true);

    wp_send_json_success( $images );
}