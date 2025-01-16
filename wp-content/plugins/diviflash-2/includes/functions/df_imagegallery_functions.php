<?php
/**
 * ImageGallery: Return Options for Gallery
 *
 * @return $options
 */
function df_ig_options($iamges, $object) {
	$options = array(
		'show_caption' => $object['show_caption'],
		'show_description' => $object['show_description'],
		'image_size' => $object['image_size'],
		'use_orientation' => $object['use_orientation'],
		'image_orientation' => $object['image_orientation'],
		'filter_nav' => $object['filter_nav'],
		'layout_mode' => $object['layout_mode'],
		'load_more' => $object['load_more'],
		'init_count' => $object['init_count'],
		'image_count' => $object['image_count'],
		'use_lightbox' => isset($object['use_lightbox']) ? $object['use_lightbox'] : 'off',
		'use_lightbox_content' => isset($object['use_lightbox_content']) ? $object['use_lightbox_content'] : 'off',
		'use_lightbox_download' => isset($object['use_lightbox_download']) ? $object['use_lightbox_download'] : 'off',
		'caption_tag' => $object['caption_tag'],
		'description_tag' => $object['description_tag'],
		'image_scale' => $object['image_scale'],
		'enable_content_position' => $object['enable_content_position'],
		'content_position_outside' => $object['content_position_outside'],
		'content_position' => $object['content_position'],
		'content_reveal_caption' => $object['content_reveal_caption'],
		'content_reveal_description' => $object['content_reveal_description'],
		'border_anim' => $object['border_anim'],
		'border_anm_style' => $object['border_anm_style'],
		'always_show_title' => $object['always_show_title'],
		'always_show_description' => $object['always_show_description'],
		'use_url' =>isset($object['use_url']) ? $object['use_url'] : 'off',
		'url_target' => isset($object['url_target']) ? $object['url_target'] : 'same_window',
		'overlay' => $object['overlay'],
		'field_use_icon'              => $object['field_use_icon'],
		'field_font_icon'             => $object['field_font_icon'],
		'content_reveal_icon'         => $object['content_reveal_icon'],
		'show_pagination'             => $object['show_pagination'],
		'pagination_img_count'        => $object['pagination_img_count'],
		'use_number_pagination'       => $object['use_number_pagination'],
		'older_text'                  => isset($object['older_text'])?$object['older_text']:'Older Entries',
		'newer_text'                  => isset($object['newer_text'])?$object['newer_text']:'Next Entries',
		'use_icon_only_at_pagination' => $object['use_icon_only_at_pagination'],
	);
	return array_merge($iamges, $options);
}

/**
 * ImageGallery: Request from Gallery VB
 *
 * @return response | JSON
 */
add_action('wp_ajax_df_image_gallery', 'df_image_gallery');
function df_image_gallery() {
	// create the display gallery code
	$data = json_decode(file_get_contents('php://input'), true);
	if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
		wp_die();
	}

	$_objects = json_decode($data['images']);
	$images_array = [];
	foreach($_objects as $_object) {
		$title = isset($_object->gallery_title) && $_object->gallery_title !== '' ?
			$_object->gallery_title : '';
		$category = isset($_object->gallery_title) && $_object->gallery_title !== '' ?
			strtolower(preg_replace('/[^A-Za-z0-9-]/', "-", $_object->gallery_title)) : '';
		$ids = array();
		if(property_exists($_object, 'gallery_ids')){ // version 1.1.5 change from array_key_exists('gallery_ids', $_object)
			$ids = explode( ',', $_object->gallery_ids);
		}
		foreach($ids as $id) {
			$images_array[$id][] = $category;
		}
	}

	/**
	 * image order
	 */
	if('on' === $data['use_image_order']) {
		if('' === $data['image_order'] || 'random' === $data['image_order']) {
			$images_array = df_shuffle_assoc($images_array);
		} else if('asc' === $data['image_order']) {
			ksort($images_array);
		} else if('desc' === $data['image_order']) {
			krsort($images_array);
		}
	}

	$options = df_ig_options(
		array('images_array' => $images_array),
		$data
	);

	$gallery = df_ig_render_images( $options );

	wp_send_json_success($gallery);
}

function df_display_galler_load_actions( $actions ) {
	$actions[] = 'df_image_gallery';

	return $actions;
}
add_filter( 'et_builder_load_actions', 'df_display_galler_load_actions' );

/**
 * ImageGallery: Load More image with Fetch
 *
 * @return json response
 */
add_action('wp_ajax_df_image_gallery_fetch', 'df_image_gallery_more_image');
add_action('wp_ajax_nopriv_df_image_gallery_fetch', 'df_image_gallery_more_image');
function df_image_gallery_more_image() {

	if (isset($_POST['et_frontend_nonce']) && !wp_verify_nonce( sanitize_text_field($_POST['et_frontend_nonce']), 'et_frontend_nonce' )) {
		wp_die();
	}

	$settings = isset($_POST["options"]) ? json_decode(stripslashes(sanitize_text_field($_POST["options"])), true) : '';
	$data = isset($_POST['images']) ? sanitize_text_field($_POST['images']) : '';
	$page = isset($_POST['page']) ? sanitize_text_field($_POST['page']) : '';
	$image_count = isset($_POST['image_count']) ? sanitize_text_field($_POST['image_count']) : '';
	$loaded = isset($_POST['loaded']) ? sanitize_text_field($_POST['loaded']) : '';
	$images_array = explode(',', $data);
	$images_array = array_unique($images_array);
	$images_array = array_slice($images_array, $loaded, $image_count);

	$options = df_ig_options(
		array('images_array' => $images_array),
		$settings
	);
	$images = df_ig_render_images( $options, true );

	wp_send_json_success($images);
}

add_action('wp_ajax_df_image_gallery_category_data_fetch', 'df_image_gallery_category_data_fetch');
add_action('wp_ajax_nopriv_df_image_gallery_category_data_fetch', 'df_image_gallery_category_data_fetch');
function df_image_gallery_category_data_fetch() {
	if (isset($_POST['et_frontend_nonce']) && !wp_verify_nonce( sanitize_text_field($_POST['et_frontend_nonce']), 'et_frontend_nonce' )) {
		wp_die();
	}

	$tax_ids = isset($_POST['tax_ids']) ? sanitize_text_field($_POST['tax_ids']) : '';
	$tax_array = explode(',', $tax_ids);
	$tax_array = array_unique($tax_array);
	$images = "";
	$request_data = [];
	$titles = [];
	foreach ($tax_array as $tax_id) {
		$tax_id = str_replace(['+', '-'], '', filter_var($tax_id, FILTER_SANITIZE_NUMBER_INT));
		$args = array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => -1,
			'tax_query'      => array(
				array(
					'taxonomy' => DiviFlash_Media_Category::TAXONOMY,
					'field'    => 'term_id',
					'terms'    => $tax_id,
				),
			),
		);
		$media_items = get_posts($args);
		if ($media_items) {
			$gallery_title = get_term($tax_id, DiviFlash_Media_Category::TAXONOMY)->name;
			$titles[strtolower(str_replace(' ', '-', $gallery_title))] = $gallery_title;
			$gallery_ids = "";
			foreach ($media_items as $media_item) {
				$gallery_ids = $gallery_ids.$media_item->ID.",";
				$images = $images.$media_item->ID.",";
			}
		}
		$gallery_title = isset($gallery_title) ? $gallery_title: "";
		$gallery_ids = isset($gallery_ids) ? $gallery_ids : "";
		$request_data[] = [ "gallery_title" => $gallery_title, "gallery_ids" => rtrim($gallery_ids, ',') ];
	}
	wp_send_json_success(["images" => $images, "request_data" => $request_data, "titles" => $titles]);
}
/**  Pagination start **/
add_action('wp_ajax_df_image_gallery_fetch_page_data', 'df_image_gallery_page_image');
add_action('wp_ajax_nopriv_df_image_gallery_fetch_page_data', 'df_image_gallery_page_image');

function df_image_gallery_page_image() {
	if ( isset($_POST['et_frontend_nonce']) ) {
		if ( ! wp_verify_nonce( sanitize_text_field( $_POST['et_frontend_nonce'] ), 'et_frontend_nonce' ) ) {
			wp_die();
		}
	}

	$settings     = isset( $_POST["options"] ) ? json_decode( stripslashes( sanitize_text_field( $_POST["options"] ) ), true ) : '';
	$data         = isset( $_POST['images'] ) ? sanitize_text_field( $_POST['images'] ) : '';
	$page         = isset( $_POST['page'] ) ? sanitize_text_field( $_POST['page'] ) : '';
	$image_count  = isset( $_POST['image_count'] ) ? sanitize_text_field( $_POST['image_count'] ) : '';
	$images_array = explode( ',', $data );
	$images_array = array_unique( $images_array );
	$start_index  = ( $page - 1 ) * $image_count;
	$end_index    = ( (int) $start_index + (int) $image_count );
	$images_array = array_slice( $images_array, $start_index, $end_index );

	$options = df_ig_options(
		array('images_array' => $images_array),
		$settings
	);
	$images = df_ig_render_images( $options, true );

	wp_send_json_success($images);
}
/**  Pagination end **/
/**
 * ImageGallery: Image markup for gallery
 *
 * @param $options array
 * @param $load_more_type boolean, whether it is load more request or not
 * @return $images | HTML Markup
 */
function df_ig_render_images( $options=[], $load_more_type = false ) {

	$default = array(
		'images_array' => [],
		'show_caption' => 'off',
		'show_description' => 'off',
		'image_size' => 'medium',
		'use_orientation' => 'off',
		'image_orientation' => 'landscape',
		'filter_nav' => 'off',
		'load_more' => 'off',
		'init_count' => 6,
		'image_count' => 3,
		'use_lightbox' => 'off',
		'use_lightbox_content' => 'off',
		'caption_tag' => '',
		'description_tag' => '',
		'image_scale' => '',
		'enable_content_position' => 'off',
		'content_position_outside' => '',
		'content_position' => '',
		'content_reveal_caption' => '',
		'content_reveal_description' => '',
		'border_anim' => 'off',
		'border_anm_style' => '',
		'always_show_title' => '',
		'always_show_description' => '',
		'use_url' => 'off',
		'url_target' => 'same_window',
		'overlay' => '',
		'field_use_icon'              => 'off',
		'field_font_icon'             => '',
		'content_reveal_icon'         => '',
		'show_pagination'             => 'off',
		'pagination_img_count'        => 6,
		'use_number_pagination'       => 'off',
		'older_text'                  => 'Older Entries',
		'newer_text'                  => 'Next Entries',
		'use_icon_only_at_pagination' => 'off'
	);

	$default_image = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA4MCIgaGVpZ2h0PSI1NDAiIHZpZXdCb3g9IjAgMCAxMDgwIDU0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPHBhdGggZmlsbD0iI0VCRUJFQiIgZD0iTTAgMGgxMDgwdjU0MEgweiIvPgogICAgICAgIDxwYXRoIGQ9Ik00NDUuNjQ5IDU0MGgtOTguOTk1TDE0NC42NDkgMzM3Ljk5NSAwIDQ4Mi42NDR2LTk4Ljk5NWwxMTYuMzY1LTExNi4zNjVjMTUuNjItMTUuNjIgNDAuOTQ3LTE1LjYyIDU2LjU2OCAwTDQ0NS42NSA1NDB6IiBmaWxsLW9wYWNpdHk9Ii4xIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgICAgICA8Y2lyY2xlIGZpbGwtb3BhY2l0eT0iLjA1IiBmaWxsPSIjMDAwIiBjeD0iMzMxIiBjeT0iMTQ4IiByPSI3MCIvPgogICAgICAgIDxwYXRoIGQ9Ik0xMDgwIDM3OXYxMTMuMTM3TDcyOC4xNjIgMTQwLjMgMzI4LjQ2MiA1NDBIMjE1LjMyNEw2OTkuODc4IDU1LjQ0NmMxNS42Mi0xNS42MiA0MC45NDgtMTUuNjIgNTYuNTY4IDBMMTA4MCAzNzl6IiBmaWxsLW9wYWNpdHk9Ii4yIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgIDwvZz4KPC9zdmc+Cg==';

	$options = wp_parse_args($options, $default);
	extract($options); // phpcs:ignore WordPress.PHP.DontExtract
	$images = '';
	$classes = '';
	$_i = 0;

	if ( $load_more_type === true ) {
		$images_array = array_flip($images_array);
	}

	$always_title       = 'on' === $always_show_title || 'on' === $enable_content_position ? 'always-show-title ' : $content_reveal_caption;
	$always_title       = 'on' === $always_show_title && 'on' !== $enable_content_position ? $always_title . 'c4-fade-up' : $always_title;

	$always_description = 'on' === $always_show_description || 'on' === $enable_content_position ? 'always-show-description ' : $content_reveal_description;
	$always_description = 'on' === $always_show_description && 'on' !== $enable_content_position ? $always_description . 'c4-fade-up' : $always_description;

	$border_anim_class = 'on' === $border_anim ? $border_anm_style : '';

	foreach( $images_array as $id => $value ) {
		if ('on' === $load_more && 'on' !== $filter_nav) {
			if ($_i >= $init_count && $load_more_type === false) {
				break;
			}
		}
		if ('on' === $show_pagination && 'on' !== $load_more) {
			if ($_i >= $pagination_img_count) {
				break;
			}
		}
		$_i++;
		if ( 'on' === $use_orientation ) {
			$width  = 400;
			$height = ( 'landscape' ===  $image_orientation ) ? 284 : 516;

			$width  = (int) apply_filters( 'et_pb_gallery_image_width', $width );
			$height = (int) apply_filters( 'et_pb_gallery_image_height', $height );
			$media  = wp_get_attachment_image_src( $id, array( $width, $height ) );

		} else {
			$media = wp_get_attachment_image_src( $id, $image_size );
		}

		$media_lightbox = wp_get_attachment_image_src($id, 'original');
		$lightbox_image_url = '' !== $media_lightbox && !is_bool($media_lightbox) ? $media_lightbox[0] : $default_image;

		$content_box = '';

		$details = '' !== $id ? get_post($id) : "";
		$caption = '';
		$description = '';
		if(('on' === $use_lightbox_content || 'on' === $show_caption) && $details){
			$caption = '' !== $details->post_excerpt ?
				sprintf('<div class="%3$s %4$s"><%2$s class="df_ig_caption">%1$s</%2$s></div>',
					wp_kses_post($details->post_excerpt, 'divi_flash'),
					esc_attr($caption_tag),
					esc_attr($always_title),
					esc_attr('on' !== $show_caption ? 'df-hide-title' : '')
				) : '';
		}
		if(('on' === $use_lightbox_content || 'on' === $show_description) && $details) {
			$description = '' !== $details->post_content ?
				sprintf('<div class="%3$s %4$s"><%2$s class="df_ig_description">%1$s</%2$s></div>',
					wp_kses_post($details->post_content, 'divi_flash'),
					esc_attr($description_tag),
					esc_attr($always_description),
					esc_attr('on' !== $show_description ? 'df-hide-description' : '')
				) : '';
		}

		$content_box = sprintf('%1$s%2$s', $caption, $description);

		$data_lightbox_html = 'on' === $use_lightbox_content && '' !== $content_box ?
			'data-sub-html=".df_ig_content"' : '';

		if ( $load_more_type === false ) {
			$classes = implode(" ", $value);
		}

		$custom_url = $use_url === 'on' ?
			sprintf('data-url="%1$s"', esc_attr(get_post_meta( $id, 'df_ig_url', true )))
			: '';

		$empty_class = $content_box === '' ? ' empty_content' : '';

		if(empty($media[0])) continue;
		$image_url = !empty($media[0]) ? $media[0] : $default_image;

		$conent_positioning = sprintf( '<%5$s class="df_ig_content %2$s %3$s %4$s">
                            %1$s
                        </%5$s>',
			$content_box,
			'on' === $enable_content_position ? esc_attr( $content_position_outside ) : esc_attr( $content_position ),
			esc_attr( $empty_class ),
			'on' === $enable_content_position ? esc_attr( 'outside' ) : '',
			'on' === $enable_content_position ? 'div' : 'figcaption'
		);

		$content_outside_positioning = "";
		if('on' === $enable_content_position && 'on' === $use_lightbox_content && $details){
			$lightbox_caption = '' !== $details->post_excerpt ?
				sprintf('<div class="ig_is_lightbox"><%2$s class="df_ig_caption">%1$s</%2$s></div>',
					wp_kses_post($details->post_excerpt, 'divi_flash'),
					esc_attr($caption_tag)
				):"";
			$lightbox_description = '' !== $details->post_content ?
				sprintf('<div class="ig_is_lightbox"><%2$s class="df_ig_description">%1$s</%2$s></div>',
					wp_kses_post($details->post_content, 'divi_flash'),
					esc_attr($description_tag)
				) : '';
			$content_outside_positioning = sprintf('<figcaption class="df_ig_content">%1$s%2$s</figcaption>', $lightbox_caption, $lightbox_description);
		}

		// Lightbox Caption : https://sachinchoolur.github.io/lightgallery.js/demos/captions.html
		$image = sprintf('<div class="df_ig_image grid-item %1$s" data-src="%2$s" %3$s>
                <div class="item-content %4$s" %10$s>
                    %11$s
                    <figure class="%5$s c4-izmir %6$s">
                        %7$s
                        <img class="ig-image" src="%8$s" alt="%9$s" class=""/>
                        %12$s
                    </figure>
                    %13$s
                </div>
            </div>',
			esc_attr($classes),
			esc_attr($lightbox_image_url),
			$data_lightbox_html,
			esc_attr($image_scale),
			esc_attr($border_anim_class),
			esc_attr(' has_overlay'),
			'on' === $overlay ? sprintf('<span class="df-overlay">%1$s</span>','on' === $field_use_icon ? df_get_processed_font_content($field_font_icon, $content_reveal_icon) : '') : '',
			esc_attr($image_url),
			esc_attr(get_post_meta($id , '_wp_attachment_image_alt', true)),
			$custom_url,
			'on' === $enable_content_position && in_array($content_position_outside, ['c4-layout-top-left', 'c4-layout-top-center', 'c4-layout-top-right'])? $conent_positioning : "",
			'on' !== $enable_content_position ? $conent_positioning : $content_outside_positioning,
			'on' === $enable_content_position && in_array($content_position_outside, ['c4-layout-bottom-left', 'c4-layout-bottom-center', 'c4-layout-bottom-right'])? $conent_positioning : ""
	    );
		$images .= $image;
	}
	return $images;
}
/**
 * Suffle an associative array in random order
 *
 */
function df_shuffle_assoc($my_array) {
	$keys = array_keys($my_array);

	shuffle($keys);

	foreach($keys as $key) {
		$new[$key] = $my_array[$key];
	}

	$my_array = $new;

	return $my_array;
}
function df_get_processed_font_content($field_font_icon, $content_reveal_icon) {
	$icon_data = explode("|",$field_font_icon);
	return sprintf('<div class="df_ig_icon_wrap %2$s"><span class="et-pb-icon">%1$s</span></div>',
		esc_attr($icon_data[0]),
		$content_reveal_icon
	);
}