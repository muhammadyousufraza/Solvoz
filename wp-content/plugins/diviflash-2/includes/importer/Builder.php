<?php

namespace DIFL\Importer;

class Builder {
	private $content;

	public function __construct( $content ) {
		$this->content = $content;
	}

	protected function set_filesystem() {
		global $wp_filesystem;

		add_filter( 'filesystem_method', array( $this, 'replace_filesystem_method' ) );
		WP_Filesystem();

		return $wp_filesystem;
	}

	public function replace_filesystem_method() {
		return 'direct';
	}

	public function import() {

		$content = $this->content;

		if ( ! $content || ! array_key_exists( 'context', $content ) ) {
			return [
				'success' => false,
				'message' => esc_html__( 'Invalid file format', 'divi_flash' ),
			];
		}
		if ( ! isset( $content['layouts'] ) || ! isset( $content['templates'] ) ) {
			return [
				'success' => false,
				'message' => esc_html__( 'Invalid file format', 'divi_flash' ),
			];
		}

		$theme_builder_id    = et_theme_builder_get_theme_builder_post_id( true, true );
		$this->old_templates = [];
		$meta                = get_post_meta( $theme_builder_id, '_et_template' );

		foreach ( $meta as $key => $value ) {
			$this->old_templates[] = $value;
		}

		$layout_map = [];

		foreach ( $content['layouts'] as $id => $layout ) {
			$layout_map[ $id ] = $this->import_layout( $id, $layout );
		}

		$template_list = [];

		foreach ( $content['templates'] as $template ) {
			$template_list[] = $this->store_template( $template, $layout_map, true );
		}

		foreach ( $template_list as $template_id ) {
			add_post_meta( $theme_builder_id, '_et_template', intval( $template_id ) );
		}

		return true;
	}

	protected function import_layout( $layout_id, $layout ) {

		if ( $layout['images'] > 0 ) {
			$images                       = $this->upload_images( $layout['images'] );
			$layout['data'][ $layout_id ] = $this->replace_images_urls( $images, $layout['data'][ $layout_id ] );

		}

		$post_title   = $layout['post_title'];
		$post_type    = $layout['post_type'];
		$post_content = $layout['data'][ $layout_id ];
		$post_meta    = df_sanitize_text_field( $layout['post_meta'] );
		$options      = [
			'post_title'   => sanitize_post_field('post_title', $post_title, 0,'db' ),
			'post_type'    => sanitize_post_field( 'post_type', $post_type, 0, 'db' ),
			'post_content' => sanitize_post_field('post_content', $post_content, 0, 'db' ),
		];
		$post_id      = $this->store_layout( $options );
		foreach ( $post_meta as $entry ) {
			update_post_meta( $post_id, $entry['key'], $entry['value'] ); //phpcs:ignore -- Sanitize throught helper functions due to array
		}


		return $post_id;
	}

	protected function store_layout( $options ) {
		if ( ! current_user_can( 'edit_others_posts' ) ) {
			wp_die();
		}

		$post_id = wp_insert_post(
			array_merge(
				[
					'post_status' => 'publish',
					'post_title'  => 'Theme Builder Layout',
				],
				$options
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			return $post_id;
		}

		wp_set_object_terms( $post_id, 'layout', 'layout_type', true );
		et_builder_enable_for_post( $post_id );

		return $post_id;
	}

	protected function upload_images( $images ) {
		$filesystem = $this->set_filesystem();

		$allow_duplicates = false;

		foreach ( $images as $key => $image ) {
			$basename = sanitize_file_name( wp_basename( $image['url'] ) );
			$id       = 0;
			$url      = '';

			if ( ! $allow_duplicates ) {
				$attachments = get_posts( array(
					'posts_per_page' => - 1,
					'post_type'      => 'attachment',
					'meta_key'       => '_wp_attached_file',
					'meta_value'     => pathinfo( $basename, PATHINFO_FILENAME ),
					'meta_compare'   => 'LIKE',
				) );

				if ( ! is_wp_error( $attachments ) && ! empty( $attachments ) ) {
					foreach ( $attachments as $attachment ) {
						$attachment_url = wp_get_attachment_url( $attachment->ID );
						$file           = get_attached_file( $attachment->ID );

						// Use existing image only if the content matches.
						if ( $filesystem->get_contents( $file ) === base64_decode( $image['encoded'] ) ) {
							$id  = isset( $image['id'] ) ? $attachment->ID : 0;
							$url = $attachment_url;

							break;
						}
					}
				}
			}

			// Create new image.
			if ( empty( $url ) ) {
				$temp_file = wp_tempnam();
				$filesystem->put_contents( $temp_file, base64_decode( $image['encoded'] ) );
				$filetype = wp_check_filetype_and_ext( $temp_file, $basename );

				if ( ! $allow_duplicates && ! empty( $attachments ) && ! is_wp_error( $attachments ) ) {
					// Avoid further duplicates if the proper_filename matches an existing image.
					if ( isset( $filetype['proper_filename'] ) && $filetype['proper_filename'] !== $basename ) {
						foreach ( $attachments as $attachment ) {
							$attachment_url = wp_get_attachment_url( $attachment->ID );
							$file           = get_attached_file( $attachment->ID );
							$filename       = sanitize_file_name( wp_basename( $file ) );

							if ( isset( $filename ) && $filename === $filetype['proper_filename'] ) {
								// Use existing image only if the basenames and content match.
								if ( $filesystem->get_contents( $file ) === $filesystem->get_contents( $temp_file ) ) {
									$id  = isset( $image['id'] ) ? $attachment->ID : 0;
									$url = $attachment_url;

									$filesystem->delete( $temp_file );

									break;
								}
							}
						}
					}
				}

				$file = array(
					'name'     => $basename,
					'tmp_name' => $temp_file,
				);


				$upload        = media_handle_sideload( $file );
				$attachment_id = is_wp_error( $upload ) ? 0 : $upload;

				/**
				 * Fires when image attachments are created during portability import.
				 *
				 * @param int $attachment_id The attachment id or 0 if attachment upload failed.
				 *
				 * @since 4.14.6
				 *
				 */
				do_action( 'et_core_portability_import_attachment_created', $attachment_id );

				if ( ! is_wp_error( $upload ) ) {
					// Set the replacement as an id if the original image was set as an id (for gallery).
					$id  = isset( $image['id'] ) ? $upload : 0;
					$url = wp_get_attachment_url( $upload );
				} else {
					// Make sure the temporary file is removed if media_handle_sideload didn't take care of it.
					$filesystem->delete( $temp_file );
				}
			}

			// Only declare the replace if a url is set.
			if ( $id > 0 ) {
				$images[ $key ]['replacement_id'] = $id;
			}

			if ( ! empty( $url ) ) {
				$images[ $key ]['replacement_url'] = $url;
			}

			unset( $url );
		}

		return $images;
	}

	protected function replace_images_urls( $images, $data ) {

		foreach ( $images as $image ) {

			$data = $this->replace_image_url( $data, $image );

		}

		unset( $post_data );

		return $data;
	}

	protected function replace_image_url( $subject, $image ) {
		if ( isset( $image['replacement_id'] ) && isset( $image['id'] ) ) {
			$search      = $image['id'];
			$replacement = $image['replacement_id'];
			$subject     = preg_replace( "/(gallery_ids=.*){$search}(.*\")/", "\${1}{$replacement}\${2}", $subject );
		}

		if ( isset( $image['url'] ) && isset( $image['replacement_url'] ) && $image['url'] !== $image['replacement_url'] ) {
			$search      = $image['url'];
			$replacement = $image['replacement_url'];
			$subject     = str_replace( $search, $replacement, $subject );
		}

		return $subject;
	}

	protected function store_template( $template, $layout_map, $allow_default ) {
		if ( ! current_user_can( 'edit_others_posts' ) ) {
			wp_die();
		}

		$_              = et_();
		$title          = sanitize_text_field( $_->array_get( $template, 'title', '' ) );
		$default        = $allow_default && true === $_->array_get( $template, 'default', true );
		$enabled        = true === $_->array_get( $template, 'enabled', true );
		$header_id      = (int) $_->array_get( $template, 'layouts.header.id', 0 );
		$header_enabled = (bool) $_->array_get( $template, 'layouts.header.enabled', true );
		$body_id        = (int) $_->array_get( $template, 'layouts.body.id', 0 );
		$body_enabled   = (bool) $_->array_get( $template, 'layouts.body.enabled', true );
		$footer_id      = (int) $_->array_get( $template, 'layouts.footer.id', 0 );
		$footer_enabled = (bool) $_->array_get( $template, 'layouts.footer.enabled', true );
		$use_on         = array_map( 'sanitize_text_field', $_->array_get( $template, 'use_on', array() ) );
		$exclude_from   = array_map( 'sanitize_text_field', $_->array_get( $template, 'exclude_from', array() ) );


		if ( array_key_exists( $header_id, $layout_map ) ) {
			$header_id = $layout_map[ $header_id ];
		}

		if ( array_key_exists( $body_id, $layout_map ) ) {
			$body_id = $layout_map[ $body_id ];
		}

		if ( array_key_exists( $footer_id, $layout_map ) ) {
			$footer_id = $layout_map[ $footer_id ];
		}

		$autogenerated_title = true === $_->array_get( $template, 'autogenerated_title', '1' );


		if ( ET_THEME_BUILDER_HEADER_LAYOUT_POST_TYPE !== get_post_type( $header_id ) || 'publish' !== get_post_status( $header_id ) ) {
			$header_id = 0;
		}

		if ( ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE !== get_post_type( $body_id ) || 'publish' !== get_post_status( $body_id ) ) {
			$body_id = 0;
		}

		if ( ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE !== get_post_type( $footer_id ) || 'publish' !== get_post_status( $footer_id ) ) {
			$footer_id = 0;
		}


		$post_id = wp_insert_post(
			array(
				'post_type'   => ET_THEME_BUILDER_TEMPLATE_POST_TYPE,
				'post_status' => 'publish',
				'post_title'  => $title,
			)
		);


		if ( 0 === $post_id || is_wp_error( $post_id ) ) {
			return false;
		}

		$metas = array(
			'_et_autogenerated_title'   => $autogenerated_title ? '1' : '0',
			'_et_default'               => $default ? '1' : '0',
			'_et_enabled'               => $enabled ? '1' : '0',
			'_et_header_layout_id'      => $header_id,
			'_et_header_layout_enabled' => $header_enabled ? '1' : '0',
			'_et_body_layout_id'        => $body_id,
			'_et_body_layout_enabled'   => $body_enabled ? '1' : '0',
			'_et_footer_layout_id'      => $footer_id,
			'_et_footer_layout_enabled' => $footer_enabled ? '1' : '0',
		);

		foreach ( $metas as $key => $value ) {
			if ( strval( $value ) === strval( get_post_meta( $post_id, $key, true ) ) ) {
				continue;
			}

			update_post_meta( $post_id, $key, $value );
		}

		// Handle _et_use_on meta.
		delete_post_meta( $post_id, '_et_use_on' );
		if ( $use_on ) {
			$use_on_unique = array_unique( $use_on );
			foreach ( $use_on_unique as $condition ) {
				add_post_meta( $post_id, '_et_use_on', $condition );
				// unsign old templates for the same use as the new one
				foreach ( $this->old_templates as $old_template ) {
					delete_post_meta( $old_template, '_et_use_on', $condition );
				}
			}
		}

		// Handle _et_exclude_from meta.
		delete_post_meta( $post_id, '_et_exclude_from' );
		if ( $exclude_from ) {
			$exclude_from_unique = array_unique( $exclude_from );

			foreach ( $exclude_from_unique as $condition ) {
				add_post_meta( $post_id, '_et_exclude_from', $condition );
			}
		}

		return $post_id;
	}
}

