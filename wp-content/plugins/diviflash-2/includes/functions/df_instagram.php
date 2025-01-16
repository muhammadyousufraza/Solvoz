<?php
require_once ( DIFL_MAIN_DIR . '/includes/functions/df_instagram_process.php');

/**
 * InstagramCarousel: builder request process
 * 
 */
add_action('wp_ajax_df_inc_render_items', 'df_inc_render_items_fb_callback');
function df_inc_render_items_fb_callback() {

    $settings = json_decode(file_get_contents('php://input'), true);

    if (! wp_verify_nonce( $settings['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }
    $user_token_changed= (!empty($settings['user_token_changed'])) ? $settings['user_token_changed'] : false;
    $instagram_client_id= (!empty($settings['instagramClientID'])) ? $settings['instagramClientID'] : '';
    $instagram_client_secret = (!empty($settings['instagramClientSecret'])) ? $settings['instagramClientSecret'] : '';
    $instagram_user_token = (!empty($settings['instagramUserToken'])) ? $settings['instagramUserToken'] : '';
    $instagram_post_only_image = (!empty($settings['instagram_post_only_image'])) ? $settings['instagram_post_only_image'] : 'off';
    $item_limit = (!empty($settings['item_limit'])) ? $settings['item_limit'] : '6';
    $cache_time = (!empty($settings['cache_time'])) ? $settings['cache_time'] : '-1';
    $cache_time_type = (!empty($settings['cache_time_type'])) ? $settings['cache_time_type'] : 'minute';
    $settings_data = array(
        'item_limit'      => $item_limit,
        'cache_time'      => $cache_time,
        'cache_time_type' => $cache_time_type
    );
    $unique_module_name = $settings['unique_module_name'];
   
    $instagram_obj = new DF_Instagram_Process($instagram_client_id, $instagram_client_secret, $instagram_user_token, $user_token_changed);
    
    $data = $instagram_obj->get_instagram_data($settings_data, $unique_module_name);
    
    if($instagram_user_token === ''){
        $data['error'] = 'Please Input Access token';
    }
    else if (isset($instagram_obj->get_instagram_account_id($instagram_user_token)->status) && $instagram_obj->get_instagram_account_id($instagram_user_token)->status === 400 ) {
        $data['error'] = 'Your Instagram User access token is not valid';
    }
    else if(count($data) < 1 ){
        if($item_limit < 0 ){
            $data['error'] = 'Item limit should more then 0';
        }else{
            $data['error'] = 'No data found from instagram';
        }  
    }else{
        
    }

    wp_send_json_success($data);
}

/**
 * InstagramGallery: Return Options for Gallery
 * 
 * @return $options
 */
function df_intagram_gallery_options($iamges, $object) {
    $options = array(
        'show_caption' => $object['show_caption'],
        'show_instagram_user_info' => $object['show_instagram_user_info'],
        'instagram_user_profile_picture' => $object['instagram_user_profile_picture'],
        'instagram_username_text' => $object['instagram_username_text'],
        'date_formate'            =>$object['date_formate'],
        'instagram_icon' => !empty($object['instagram_icon'])?$object['instagram_icon']:'',
        'instagram_icon_enable' => !empty($object['instagram_icon_enable'])?$object['instagram_icon_enable']:'',
        'instagram_post_only_image' => $object['instagram_post_only_image'],
        'autoplay_video' => $object['autoplay_video'],
        'cache_time' => !empty($object['cache_time'])?$object['cache_time']:'-1',
        'cache_time_type' => !empty($object['cache_time_type'])?$object['cache_time_type']:'minute',
        'image_size' => !empty($object['image_size'])?$object['image_size']:'',
        'layout_mode' => $object['layout_mode'],
        'load_more' => $object['load_more'],
        'item_limit' => !empty($object['item_limit'])?$object['item_limit']:'',
        'total_item' => !empty($object['total_item'])?$object['total_item']:'',
        'init_count' => $object['init_count'],
        'image_count' => $object['image_count'],
        'caption_tag' => $object['caption_tag'],
        'image_scale' => $object['image_scale'],
        'content_position' => $object['content_position'],
        'content_reveal_caption' => $object['content_reveal_caption'],
        'border_anim' => $object['border_anim'],
        'border_anm_style' => $object['border_anm_style'],
        'always_show_title' => $object['always_show_title'],
        'use_icon' => isset ($object['use_icon']) ? $object['use_icon'] : 'off',
        'hover_icon' => $object['hover_icon'],
        'use_url' => isset ($object['use_url']) ? $object['use_url'] : 'off',
        'url_target' => isset($object['url_target']) ? $object['url_target'] : 'same_window',
        'overlay' => $object['overlay'],
        'instagram_user_token' => isset($object['instagram_user_token']) ? $object['instagram_user_token'] : '',
        'unique_module_name'   => $object['unique_module_name'],
        'user_token_changed'   => isset($object['user_token_changed']) ? $object['user_token_changed'] : false,
        
    );
    return array_merge($iamges, $options);
}

/**
 * InstagramGallery: Request from Instagram for Builder
 * 
 * @return response | JSON
 */
add_action('wp_ajax_df_instagram_gallery', 'df_instagram_gallery');
function df_instagram_gallery() {
    // create the display gallery code
    $data = json_decode(file_get_contents('php://input'), true);
    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }

    $images_array = [];
    $builder= !empty($data['user_token_changed']) ?  $data['user_token_changed'] : false;
    $instagram_client_id= (!empty($data['instagramClientID'])) ? $data['instagramClientID'] : '';
    $instagram_client_secret = (!empty($data['instagramClientSecret'])) ? $data['instagramClientSecret'] : '';
    $instagram_user_token = (!empty($data['instagramUserToken'])) ? $data['instagramUserToken'] : '';
    $item_limit = (!empty($data['item_limit'])) ? $data['item_limit'] : '6';
    $cache_time = (!empty($data['cache_time'])) ? $data['cache_time'] : '-1';
    $cache_time_type = (!empty($data['cache_time_type'])) ? $data['cache_time_type'] : 'minute';
    $settings_data = array(
        'item_limit' => $item_limit,
        'cache_time' => $cache_time,
        'cache_time_type' => $cache_time_type
    );
    $instagram_obj = new DF_Instagram_Process($instagram_client_id, $instagram_client_secret, $instagram_user_token, $builder);
    $unique_module_name = $data['unique_module_name'];
    $images_array = $instagram_obj->get_instagram_data($settings_data , $unique_module_name);
    if($data['instagram_post_only_image'] =='on'){
            
        $media_type= "IMAGE";
        $images_array = array_filter(
                    $images_array,
                    function ($value) use ($media_type) {
                        return $value->media_type == $media_type;
                    },
                    ARRAY_FILTER_USE_BOTH
                );
    }
      
    $options = df_intagram_gallery_options(
        array('images_array' => $images_array),
        $data
    );

    $gallery =array();
    $instagram_data = true;
    if($instagram_user_token === ''){
        $gallery['error'] = array(
            'status' => true,
            'msg'    => "Please input access token"
        );
    }
    else if (isset($instagram_obj->get_instagram_account_id($instagram_user_token)->status) && $instagram_obj->get_instagram_account_id($instagram_user_token)->status === 400 ) {
        $gallery['error'] = array(
            'status' => true,
            'msg'    => "Your Instagram User access token is not valid"
        );
       
    }else if(intval(count($images_array)) < 1){
      
        if($item_limit < 0 ){
            $gallery['error'] = array(
                'status' => true,
                'msg'    => "Item limit should more then 0"
            );
        }else{
            $gallery['error'] = array(
                'status' => true,
                'msg'    => "No data found from instagram"
            );
        }  
    }else{
        $gallery['error'] = array(
            'status' => false,
            'msg'    => "success"
        );
        $gallery = df_ing_render_images( $options );
    }
   
    wp_send_json_success($gallery);
}
/**
 * InstagramGallery: Load More image with Fetch
 * 
 * @return json response
 */
add_action('wp_ajax_df_instagram_gallery_fetch', 'df_instagram_gallery_more_image');
add_action('wp_ajax_nopriv_df_instagram_gallery_fetch', 'df_instagram_gallery_more_image');
function df_instagram_gallery_more_image() {

    if (isset($_POST['et_frontend_nonce']) && !wp_verify_nonce( sanitize_text_field($_POST['et_frontend_nonce']), 'et_frontend_nonce' )) {
        wp_die();
    }
    $settings = isset($_POST["options"]) ? json_decode(stripslashes(sanitize_text_field($_POST["options"])), true) : '';
    $data = isset($_POST['images']) ? sanitize_text_field($_POST['images']) : '';
    $page = isset($_POST['page']) ? sanitize_text_field($_POST['page']) : '';
    $image_count = isset($_POST['image_count']) ? sanitize_text_field($_POST['image_count']) : '';
    $loaded = isset($_POST['loaded']) ? sanitize_text_field($_POST['loaded']) : '';
    $images_array = [];

    $item_limit = $settings['item_limit']; 
    $unique_module_name = $settings['unique_module_name'];

    $transient_key = 'df_instagram_feed_data_' .$unique_module_name .'_'. $item_limit;
    $images_array = get_transient($transient_key)->data;

    if($settings['instagram_post_only_image'] =='on'){
            
        $media_type= "IMAGE";
        $images_array = array_filter(
                    $images_array,
                    function ($value) use ($media_type) {
                        return $value->media_type == $media_type;
                    },
                    ARRAY_FILTER_USE_BOTH
                );
    }

    $images_array = array_slice($images_array, $loaded, $image_count);
    
    
    $options = df_intagram_gallery_options(
        array('images_array' => $images_array),
        $settings
    );
    $images = df_ing_render_images( $options, true );
   
    wp_send_json_success($images);
}
/**
 * InstagramGallery: Image markup for gallery
 * 
 * @param $options array
 * @param $load_more_type boolean, whether it is load more request or not
 * @return $images | HTML Markup
 */

function df_ing_render_images( $options=[], $load_more_type = false ) {
 
    $default = array(
        'images_array' => [],
        'show_instagram_user_info' => 'off',
        'instagram_icon_enable' => 'on',
        'instagram_user_profile_picture'=> '',
        'instagram_username_text'=> '',
        'autoplay_video' => 'off',
        'show_caption' => 'off',
        'show_description' => 'off',
        'image_size' => 'medium',
        'filter_nav' => 'off',
        'load_more' => 'off',
        'init_count' => 6,
        'image_count' => 3,
        'use_lightbox' => 'off',
        'use_lightbox_content' => 'off',
        'caption_tag' => '',
        'description_tag' => '',
        'image_scale' => '',
        'content_position' => '',
        'content_reveal_caption' => '',
        'content_reveal_description' => '',
        'border_anim' => 'off',
        'border_anm_style' => '',
        'always_show_title' => '',
        'always_show_description' => '',
        'use_url' => 'off',
        'url_target' => 'same_window',
        'overlay' => ''
    );
  
    $options = wp_parse_args($options, $default);
    
  
    extract($options); // phpcs:ignore WordPress.PHP.DontExtract
    $images = '';
    $classes = '';
    $_i = 0;

    // print_r($images_array);
   
    $always_title = $always_show_title === 'on' ? 
        'always-show-title c4-fade-up' : $content_reveal_caption;
    $always_description = $always_show_description === 'on' ? 
        'always-show-description c4-fade-up' : $content_reveal_description;

    $border_anim_class = $border_anim === 'on' ? $border_anm_style : '';
 
    $instagram_username = $instagram_username_text !==''? 
        sprintf('<span class="df-instagram-user-name">%1$s</span>', esc_attr($instagram_username_text))
        :'';

    $instagram_user_profile_picture_html = $instagram_user_profile_picture !==''?
    sprintf('<div class="df-instagram-user-profile-picture">
                <img src=%1$s alt="%2$s">
            </div>', esc_url($instagram_user_profile_picture) , esc_attr($instagram_username_text)
            )
            :'';
    $post_date_formate = $date_formate ? $date_formate : "M j, Y";
    foreach( $images_array as $item ) {
        if ($load_more === 'on') {
            if ($_i >= $init_count && $load_more_type === false) {
                break;
            }  
        }
        $_i++;
        $image_upper_icon = $use_icon === 'on'?
        sprintf('<span class="et-pb-icon hover_icon">%1$s</span>',$hover_icon ):'';

        $content_box = '';
        $caption     = '';
        if($show_caption ==='on' && !empty($item->caption)){
            $caption .= $show_caption === 'on'?
                sprintf('<div class="%3$s"><%2$s class="df_ing_caption">%1$s</%2$s></div>', 
                    esc_html__( $item->caption, 'divi_flash'), 
                    esc_attr($caption_tag), 
                    esc_attr($always_title)) : '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><path d="M23,32H9c-5,0-9-4-9-9V9c0-5,4-9,9-9h14c5,0,9,4,9,9v14C32,28,28,32,23,32z M9,2C5.1,2,2,5.1,2,9v14c0,3.9,3.1,7,7,7h14  c3.9,0,7-3.1,7-7V9c0-3.9-3.1-7-7-7H9z"></path><path d="M16,24.2c-4.5,0-8.2-3.7-8.2-8.2c0-4.5,3.7-8.2,8.2-8.2c4.5,0,8.2,3.7,8.2,8.2C24.2,20.5,20.5,24.2,16,24.2z M16,9.8  c-3.4,0-6.2,2.8-6.2,6.2s2.8,6.2,6.2,6.2s6.2-2.8,6.2-6.2S19.4,9.8,16,9.8z"></path><circle cx="16" cy="16" r="1.9"></circle></svg>';

        }
        $content_box = sprintf('%1$s %2$s',$image_upper_icon, $caption);
         $empty_class = $content_box === '' ? ' empty_content' : '';
  
        $data_lightbox_html = $use_lightbox_content === 'on' ? 
            'data-sub-html=".df_ing_content"' : '';

        
        $custom_url = $use_url === 'on' ? 
        sprintf('data-url="%1$s"', $item->permalink) 
        : '';  
        
        $media_type = ('VIDEO' == $item->media_type)? 'video': 'img';
        $autoplay_attribute = $autoplay_video === 'on' ? 'autoplay' : '';
        $instagram_item_caption = isset($item->caption) && $item->caption ? $item->caption : '';
        $media_html ='';
        if($item->media_type !== 'VIDEO'){
            $media_html .=  sprintf('<%1$s class="ing-image" src="%2$s" alt="%4$s" title="Image by: %3$s"/>', $media_type, $item->media_url , $item->username , $instagram_item_caption );
        }else{
            $media_html .=  sprintf( '<video id="instagram-video" class="ing-image instagram-video"  controls %2$s>  <source src="%1$s" type="video/mp4" /></video>', $item->media_url , $autoplay_attribute );
        }
        
        $instagram_date = strtotime($item->timestamp);
        $instagram_date = gmdate($post_date_formate, $instagram_date); 

        $instagram_icon_html =  $instagram_icon_enable == 'on' ? 
            sprintf('<a class="df-instagram-feed-icon" href="%1$s" target="_blank">
                    <span class="et-pb-icon instagram_icon">%2$s</span>
                </a>',
                $item->permalink ? $item->permalink : "",
                $instagram_icon ? $instagram_icon : ""
            ): '';
        

            $instagram_user_info_html = $show_instagram_user_info === 'on' ? 
            sprintf( '<div class="df-instagram-user-info">
                        <a class="df-instagram-user" href="https://www.instagram.com/%1$s" target="_blank">
                            %2$s
                            <div class="df-instagram-username-and-postdate">
                                %3$s
                                <span class="df-instagram-postdate">  %4$s </span>
                            </div>
                        </a>
                        %5$s
                    </div>',
                    $item->username,
                    $instagram_user_profile_picture_html,
                    $instagram_username !==''? $instagram_username : '<span class="df-instagram-user-name">'.$item->username . '</span>',
                    $instagram_date,
                    $instagram_icon_html
                )
                : '';
        // Lightbox Caption : https://sachinchoolur.github.io/lightgallery.js/demos/captions.html
        
        $image = sprintf('<div class="df_ing_image grid-item %3$s" data-src="%8$s" %4$s>
                <div class="item-content" %10$s >
                 
                     %12$s
                    <div class="image-container %5$s %14$s"> 
                        <figure %10$s class="%7$s c4-izmir %9$s">
                            %13$s
                            %1$s
                            <figcaption class="df_ing_content %6$s %11$s">
                                %2$s
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>', 
            $media_html, 
            $content_box, 
            esc_attr($classes), 
            $data_lightbox_html, 
            esc_attr($image_scale), 
            esc_attr($content_position),
            esc_attr($border_anim_class), 
            esc_attr($item->media_url),
            esc_attr(' has_overlay'),
            $custom_url,
            esc_attr($empty_class),
            $instagram_user_info_html,
            // esc_attr(get_post_meta($id , '_wp_attachment_image_alt', true)),
            $overlay === 'on' ? '<span class="df-overlay"></span>' : '',
            $item->media_type == 'VIDEO' ? 'media_type_video' : ''
        );
        $images .= $image;
    }
    return $images;
}

