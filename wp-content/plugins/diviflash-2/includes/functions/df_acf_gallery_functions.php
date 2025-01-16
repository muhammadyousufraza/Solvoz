<?php
function df_acf_gallery_options( $images, $object ) {
	$options = array(
		'show_caption'                => $object['show_caption'],
		'show_description'            => $object['show_description'],
		'image_size'                  => $object['image_size'],
		'use_orientation'             => $object['use_orientation'],
		'image_orientation'           => $object['image_orientation'],
		'layout_mode'                 => $object['layout_mode'],
		'load_more'                   => $object['load_more'],
		'init_count'                  => $object['init_count'],
		'image_count'                 => $object['image_count'],
		'use_lightbox'                => isset( $object['use_lightbox'] ) ? $object['use_lightbox'] : 'off',
		'use_lightbox_content'        => isset( $object['use_lightbox_content'] ) ? $object['use_lightbox_content'] : 'off',
		'use_lightbox_download'       => isset( $object['use_lightbox_download'] ) ? $object['use_lightbox_download'] : 'off',
		'caption_tag'                 => $object['caption_tag'],
		'description_tag'             => $object['description_tag'],
		'image_scale'                 => $object['image_scale'],
		'enable_content_position'     => $object['enable_content_position'],
		'content_position_outside'    => $object['content_position_outside'],
		'content_position'            => $object['content_position'],
		'content_reveal_caption'      => $object['content_reveal_caption'],
		'content_reveal_description'  => $object['content_reveal_description'],
		'border_anim'                 => $object['border_anim'],
		'border_anm_style'            => $object['border_anm_style'],
		'always_show_title'           => $object['always_show_title'],
		'always_show_description'     => $object['always_show_description'],
		'use_url'                     => isset( $object['use_url'] ) ? $object['use_url'] : 'off',
		'url_target'                  => isset( $object['url_target'] ) ? $object['url_target'] : 'same_window',
		'overlay'                     => $object['overlay'],
		'field_use_icon'              => $object['field_use_icon'],
		'field_font_icon'             => $object['field_font_icon'],
		'content_reveal_icon'         => $object['content_reveal_icon'],
		'show_pagination'             => $object['show_pagination'],
		'pagination_img_count'        => $object['pagination_img_count'],
		'use_number_pagination'       => $object['use_number_pagination'],
		'older_text'                  => isset( $object['older_text'] ) ? $object['older_text'] : 'Older Entries',
		'newer_text'                  => isset( $object['newer_text'] ) ? $object['newer_text'] : 'Next Entries',
		'use_icon_only_at_pagination' => $object['use_icon_only_at_pagination'],
	);

	return array_merge( $images, $options );
}


// Builder API
add_action( 'wp_ajax_df_acf_gallery', 'df_acf_gallery' );
add_action( 'wp_ajax_nopriv_df_acf_gallery', 'df_acf_gallery' );
function df_acf_gallery() {
	if ( isset( $_POST['et_frontend_nonce'] ) && ! wp_verify_nonce( sanitize_text_field( $_POST['et_frontend_nonce'] ), 'et_frontend_nonce' ) ) {
		wp_die();
	}
	$acf_gallery_field_data = isset( $_POST['acf_gallery_fields'] ) ? sanitize_text_field( $_POST['acf_gallery_fields'] ) : '';
	$acf_gallery_field_data = json_decode( str_replace( '\\', '', $acf_gallery_field_data ) );
	$post_id = !empty($_POST['post_id']) ? sanitize_text_field( $_POST['post_id'] ) : 0;

	$image_array = [];
	if( 0 === $post_id){
		global $post, $paged, $wp_query, $wp_the_query;
		$main_query = $wp_the_query;
		$args       = [
			'posts_per_page' => 1,
			'post_type'      => 'any',
			'orderby'        => 'rand',
			'meta_query'     => [
				[
					'key'     => $acf_gallery_field_data,
					'compare' => 'EXISTS',
				],
			],
		];

		query_posts( $args );

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				$post_id = $post->ID;
				$gallery_data = get_field( $acf_gallery_field_data, $post->ID );
				if ( is_array( $gallery_data ) && ! empty( $gallery_data ) ) {
					$image_array = $gallery_data;
				}
			}


		}
		$wp_the_query = $wp_query = $main_query; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
		wp_reset_query(); // phpcs:ignore WordPress.WP.DiscouragedFunctions
	}else{
		$gallery_data = get_field( $acf_gallery_field_data, $post_id );
		if ( is_array( $gallery_data ) && ! empty( $gallery_data ) ) {
			$image_array = $gallery_data;
		}
	}


	$options = df_acf_gallery_options(
		array( 'images_array' => $image_array ),
		$_POST
	);

	$gallery = df_acf_gallery_render_images( $options );

	wp_send_json_success( [ "gallery" => $gallery, "image_array" => $image_array, "post_id" => $post_id ] );
}


// Load More
add_action( 'wp_ajax_df_acf_gallery_load_more', 'df_acf_gallery_load_more' );
add_action( 'wp_ajax_nopriv_df_acf_gallery_load_more', 'df_acf_gallery_load_more' );
function df_acf_gallery_load_more() {

	if ( isset( $_POST['et_frontend_nonce'] ) && ! wp_verify_nonce( sanitize_text_field( $_POST['et_frontend_nonce'] ), 'et_frontend_nonce' ) ) {
		wp_die();
	}

	$settings     = isset( $_POST["options"] ) ? json_decode( stripslashes( sanitize_text_field( $_POST["options"] ) ), true ) : '';
	$page         = isset( $_POST['page'] ) ? sanitize_text_field( $_POST['page'] ) : '';
	$image_count  = isset( $_POST['image_count'] ) ? sanitize_text_field( $_POST['image_count'] ) : '';
	$loaded       = isset( $_POST['loaded'] ) ? sanitize_text_field( $_POST['loaded'] ) : '';
	$images_array = array_slice( $settings['images_array'], $loaded, $image_count );
	unset( $settings['images_array'] );
	$options = df_acf_gallery_options(
		array( 'images_array' => $images_array ),
		$settings
	);
	$images  = df_acf_gallery_render_images( $options, true );

	wp_send_json_success( $images );
}

// Pagination
add_action( 'wp_ajax_df_acf_gallery_fetch_page_data', 'df_acf_gallery_page_image' );
add_action( 'wp_ajax_nopriv_df_acf_gallery_fetch_page_data', 'df_acf_gallery_page_image' );

function df_acf_gallery_page_image() {
	if ( isset( $_POST['et_frontend_nonce'] ) ) {
		if ( ! wp_verify_nonce( sanitize_text_field( $_POST['et_frontend_nonce'] ), 'et_frontend_nonce' ) ) {
			wp_die();
		}
	}

	$settings     = isset( $_POST["options"] ) ? json_decode( stripslashes( sanitize_text_field( $_POST["options"] ) ), true ) : '';
	$page         = isset( $_POST['page'] ) ? sanitize_text_field( $_POST['page'] ) : '';
	$image_count  = isset( $_POST['image_count'] ) ? sanitize_text_field( $_POST['image_count'] ) : '';
	$start_index  = ( $page - 1 ) * $image_count;
	$end_index    = ( (int) $start_index + (int) $image_count );
	$images_array = array_slice( $settings['images_array'], $start_index, $end_index );
	unset( $settings['images_array'] );

	$options = df_acf_gallery_options(
		array( 'images_array' => $images_array ),
		$settings
	);
	$images  = df_acf_gallery_render_images( $options, true );

	wp_send_json_success( $images );
}

function df_acf_gallery_render_images( $options = [], $load_more_type = false ) {

	$default = array(
		'images_array'                => [],
		'show_caption'                => 'off',
		'show_description'            => 'off',
		'image_size'                  => 'medium',
		'use_orientation'             => 'off',
		'image_orientation'           => 'landscape',
		'load_more'                   => 'off',
		'init_count'                  => 6,
		'image_count'                 => 3,
		'use_lightbox'                => 'off',
		'use_lightbox_content'        => 'off',
		'caption_tag'                 => '',
		'description_tag'             => '',
		'image_scale'                 => '',
		'enable_content_position'     => 'off',
		'content_position_outside'    => '',
		'content_position'            => '',
		'content_reveal_caption'      => '',
		'content_reveal_description'  => '',
		'border_anim'                 => 'off',
		'border_anm_style'            => '',
		'always_show_title'           => '',
		'always_show_description'     => '',
		'use_url'                     => 'off',
		'url_target'                  => 'same_window',
		'overlay'                     => '',
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

	$options = wp_parse_args( $options, $default );
	extract( $options ); // phpcs:ignore WordPress.PHP.DontExtract
	$images  = '';
	$classes = '';
	$_i      = 0;

//	if ( $load_more_type === true ) {
//		$images_array = array_flip( $images_array );
//	}

	$always_title = 'on' === $always_show_title || 'on' === $enable_content_position ? 'always-show-title ' : $content_reveal_caption;
	$always_title = 'on' === $always_show_title && 'on' !== $enable_content_position ? $always_title . 'c4-fade-up' : $always_title;

	$always_description = 'on' === $always_show_description || 'on' === $enable_content_position ? 'always-show-description ' : $content_reveal_description;
	$always_description = 'on' === $always_show_description && 'on' !== $enable_content_position ? $always_description . 'c4-fade-up' : $always_description;

	$border_anim_class = 'on' === $border_anim ? $border_anm_style : '';

	foreach ( $images_array as $image ) {
		if(is_array($image)){
			$id = $image['id'];
		}else if(filter_var($image, FILTER_VALIDATE_URL)){
			$id = attachment_url_to_postid( $image );
		}else{
			$id = $image;
		}

		if ( 'on' === $load_more ) {
			if ( $_i >= $init_count && $load_more_type === false ) {
				break;
			}
		}
		if ( 'on' === $show_pagination && 'on' !== $load_more ) {
			if ( $_i >= $pagination_img_count ) {
				break;
			}
		}
		$_i ++;
		if ( 'on' === $use_orientation ) {
			$width  = 400;
			$height = ( 'landscape' === $image_orientation ) ? 284 : 516;

			$width  = (int) apply_filters( 'et_pb_gallery_image_width', $width );
			$height = (int) apply_filters( 'et_pb_gallery_image_height', $height );
			$media  = wp_get_attachment_image_src( $id, array( $width, $height ) );

		}else {
			$media = wp_get_attachment_image_src( $id, $image_size );
		}

		$media_lightbox     = wp_get_attachment_image_src($id, 'original');
		$lightbox_image_url = '' !== $media_lightbox && !is_bool($media_lightbox) ? $media_lightbox[0] : $default_image;

		$content_box = '';

		$details     = '' !== $id ? get_post( $id ) : "";
		$caption     = '';
		$description = '';
		if ( ( 'on' === $use_lightbox_content || 'on' === $show_caption ) && $details ) {
			$caption = '' !== $details->post_excerpt ?
				sprintf( '<div class="%3$s %4$s"><%2$s class="df_acf_gallery_caption">%1$s</%2$s></div>',
					wp_kses_post($details->post_excerpt, 'divi_flash'),
					esc_attr( $caption_tag ),
					esc_attr( $always_title ),
					esc_attr( 'on' !== $show_caption ? 'df_acf_gallery_hide_title' : '' )
				) : '';
		}
		if ( ( 'on' === $use_lightbox_content || 'on' === $show_description ) && $details ) {
			$description = '' !== $details->post_content ?
				sprintf( '<div class="%3$s %4$s"><%2$s class="df_acf_gallery_description">%1$s</%2$s></div>',
					wp_kses_post($details->post_content, 'divi_flash'),
					esc_attr( $description_tag ),
					esc_attr( $always_description ),
					esc_attr( 'on' !== $show_description ? 'df_acf_gallery_hide_description' : '' )
				) : '';
		}

		$content_box = sprintf( '%1$s%2$s', $caption, $description );

		$data_lightbox_html = 'on' === $use_lightbox_content && '' !== $content_box ?
			'data-sub-html=".df_acf_gallery_content"' : '';

		if ( $load_more_type === false ) {
			$classes = "";
		}

		$custom_url = $use_url === 'on' ?
			sprintf( 'data-url="%1$s"', esc_attr( get_post_meta( $id, 'df_ig_url', true ) ) )
			: '';

		$empty_class = $content_box === '' ? ' empty_content' : '';

		if ( empty( $media[0] ) ) {
			continue;
		}
		$image_url = ! empty( $media[0] ) ? $media[0] : $default_image;

		$conent_positioning = sprintf( '<%5$s class="df_acf_gallery_content %2$s %3$s %4$s">
                            %1$s
                        </%5$s>',
			$content_box,
			'on' === $enable_content_position ? esc_attr( $content_position_outside ) : esc_attr( $content_position ),
			esc_attr( $empty_class ),
			'on' === $enable_content_position ? esc_attr( 'outside' ) : '',
			'on' === $enable_content_position ? 'div' : 'figcaption'
		);

		$content_outside_positioning = '<figcaption class="df_acf_gallery_content" ></figcaption>';
		if('on' === $enable_content_position && 'on' === $use_lightbox_content && $details){
			$lightbox_caption = '' !== $details->post_excerpt ?
				sprintf('<div class="df_acf_gallery_is_lightbox"><%2$s class="df_acf_gallery_caption">%1$s</%2$s></div>',
					wp_kses_post($details->post_excerpt, 'divi_flash'),
					esc_attr($caption_tag)
				):"";
			$lightbox_description = '' !== $details->post_content ?
				sprintf('<div class="df_acf_gallery_is_lightbox"><%2$s class="df_acf_gallery_description">%1$s</%2$s></div>',
					wp_kses_post($details->post_content, 'divi_flash'),
					esc_attr($description_tag)
				) : '';
			$content_outside_positioning = sprintf('<figcaption class="df_acf_gallery_content" >%1$s%2$s</figcaption>', $lightbox_caption, $lightbox_description);
		}

		// Lightbox Caption : https://sachinchoolur.github.io/lightgallery.js/demos/captions.html
		$image  = sprintf( '<div class="df_acf_gallery_image grid-item %1$s" data-src="%2$s" %3$s>
                <div class="item-content %4$s" %10$s>
                    %11$s
                    <figure class="%5$s c4-izmir %6$s">
                        %7$s
                        <img class="acf_gallery_image" src="%8$s" alt="%9$s" class=""/>
                        %12$s
                    </figure>
                    %13$s
                </div>
            </div>',
			esc_attr( $classes ),
			esc_attr( $lightbox_image_url ),
			$data_lightbox_html,
			esc_attr( $image_scale ),
			esc_attr( $border_anim_class ),
			esc_attr( ' has_overlay' ),
			'on' === $overlay ? sprintf( '<span class="df-overlay">%1$s</span>', 'on' === $field_use_icon ? df_acf_get_processed_font_content( $field_font_icon, $content_reveal_icon ) : '' ) : '',
			esc_attr( $image_url ),
			esc_attr(get_post_meta($id , '_wp_attachment_image_alt', true)),
			$custom_url,
			'on' === $enable_content_position && in_array( $content_position_outside, [
				'c4-layout-top-left',
				'c4-layout-top-center',
				'c4-layout-top-right'
			] ) ? $conent_positioning : "",
			'on' !== $enable_content_position ? $conent_positioning : $content_outside_positioning,
			'on' === $enable_content_position && in_array( $content_position_outside, [
				'c4-layout-bottom-left',
				'c4-layout-bottom-center',
				'c4-layout-bottom-right'
			] ) ? $conent_positioning : ""
		);
		$images .= $image;
	}

	return $images;
}

function df_acf_get_processed_font_content( $field_font_icon, $content_reveal_icon ) {
	$icon_data = explode( "|", $field_font_icon );

	return sprintf( '<div class="df_acf_gallery_icon_wrap %2$s"><span class="et-pb-icon">%1$s</span></div>',
		esc_attr( $icon_data[0] ),
		$content_reveal_icon
	);
}