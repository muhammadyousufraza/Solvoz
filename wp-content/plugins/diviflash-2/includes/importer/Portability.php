<?php

namespace DIFL\Importer;

class Portability extends \ET_Core_Portability {
	public function __construct( $context ) {
		parent::__construct( $context );
	}

	/**
	 * Import Divi Theme Option
	 *
	 * @param string $file file path
	 */
	public function import_theme_options( $options ) {
		global $shortname;
		$timestamp = $this->get_timestamp();

		if ( isset( $options['images'] ) ) {
			$images          = $this->maybe_paginate_images( (array) $options['images'], 'upload_images', $timestamp );
			$options['data'] = $this->replace_images_urls( $images, $options['data'] );
		}

		if ( ! empty( $options['global_colors'] ) ) {
			$options['data'] = $this->_maybe_inject_gcid( $options['data'], $options['global_colors'] );
		}
		$data    = isset( $options['data'] ) ? df_sanitize_text_field( $options['data'] ) : [];
		$success = [ 'timestamp' => $timestamp ];

		if ( 'options' === $this->instance->type ) {
			// Reset all data besides excluded data.
			$current_data = $this->apply_query( get_option( $this->instance->target, [] ), 'unset' );

			if ( isset( $data['wp_custom_css'] ) && function_exists( 'wp_update_custom_css_post' ) ) {
				wp_update_custom_css_post( $data['wp_custom_css'] );

				if ( 'yes' === get_theme_mod( 'et_pb_css_synced', 'no' ) ) {
					// If synced, clear the legacy custom css value to avoid unwanted merging of old and new css.
					$data["{$shortname}_custom_css"] = '';
				}
			}

			// Import Google API settings.
			if ( isset( $et_google_api_settings ) ) {
				// Get exising Google API key, sine it is not added to export.
				$et_previous_google_api_settings   = get_option( 'et_google_api_settings' );
				$et_previous_google_api_key        = isset( $et_previous_google_api_settings['api_key'] ) ? $et_previous_google_api_settings['api_key'] : '';
				$et_google_api_settings['api_key'] = $et_previous_google_api_key;

				update_option( 'et_google_api_settings', $et_google_api_settings );
			}

			// Merge remaining current data with new data and update options.
			update_option( $this->instance->target, array_merge( $current_data, $data ) ); //phpcs:ignore -- sanitized through helper

			set_theme_mod( 'et_pb_css_synced', 'no' );
		}
		if ( ! empty( $options['global_colors'] ) ) {
			$this->import_global_colors( $options['global_colors'] );
			$success['globalColors'] = et_builder_get_all_global_colors();
		}

		return true;
	}

	/**
	 * Import Widget
	 *
	 * parse file and passe it to import function
	 *
	 * @param string $file file path
	 */
	public function import_widgets( $file ) {
		if ( ! is_file( $file ) ) {
			return [
				'success'      => false,
				'errorMessage' => esc_html__( "The .WIE file containing the widgets is not available or could not be read .. You might want to try to set the file permission to chmod 755.<br/>If this doesn't work please use the Widget Importer & Exporter and import the .wie file (should be located in your download .zip: Sample Content folder) manually ", 'divi_flash' )
			];
		}

		$filesystem = $this->set_filesystem();
		$data       = json_decode( $filesystem->get_contents( $file ) );

		// Clean All Widgets
		update_option( 'sidebars_widgets', [] );

		$imported_widgets = $this->import_widgets_data( $data );

		return [ 'success' => true, 'widgets' => $imported_widgets ];
	}


	/**
	 * Get Available widgets
	 *
	 * Gather site's widgets into array with ID base, name, etc.
	 * Used by import widgets functions.
	 *
	 * @return array Widget information
	 * @global array $wp_registered_widget_updates
	 */
	public function get_available_widgets() {
		global $wp_registered_widget_controls;
		$widget_controls   = $wp_registered_widget_controls;
		$available_widgets = array();
		foreach ( $widget_controls as $widget ) {
			// No duplicates.
			if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[ $widget['id_base'] ] ) ) {
				$available_widgets[ $widget['id_base'] ]['id_base'] = $widget['id_base'];
				$available_widgets[ $widget['id_base'] ]['name']    = $widget['name'];
			}
		}

		return $available_widgets;
	}

	/**
	 * Import widget JSON data
	 *
	 * @param object $data JSON widget data from .wie file.
	 *
	 * @return array Results array
	 * @since 0.4
	 * @global array $wp_registered_sidebars
	 */
	public function import_widgets_data( $data ) {
		global $wp_registered_sidebars;

		// Have valid data?
		// If no data or could not decode.
		if ( empty( $data ) || ! is_object( $data ) ) {
			return [
				'success'      => false,
				'errorMessage' => esc_html__( 'Import data is invalid.', 'divi_flash' )
			];
		}

		// Get all available widgets site supports.
		$available_widgets = $this->get_available_widgets();

		// Get all existing widget instances.
		$widget_instances = array();
		foreach ( $available_widgets as $widget_data ) {
			$widget_instances[ $widget_data['id_base'] ] = get_option( 'widget_' . $widget_data['id_base'] );
		}

		// Begin results.
		$results = array();

		// Loop import data's sidebars.
		foreach ( $data as $sidebar_id => $widgets ) {
			// Skip inactive widgets (should not be in export file).
			if ( 'wp_inactive_widgets' === $sidebar_id ) {
				continue;
			}

			// Check if sidebar is available on this site.
			// Otherwise add widgets to inactive, and say so.
			if ( isset( $wp_registered_sidebars[ $sidebar_id ] ) ) {
				$sidebar_available    = true;
				$use_sidebar_id       = $sidebar_id;
				$sidebar_message_type = 'success';
				$sidebar_message      = '';
			} else {
				$sidebar_available    = false;
				$use_sidebar_id       = 'wp_inactive_widgets'; // Add to inactive if sidebar does not exist in theme.
				$sidebar_message_type = 'errorMessage';
				$sidebar_message      = esc_html__( 'Widget area does not exist in theme (using Inactive)', 'widget-importer-exporter' );
			}

			// Result for sidebar
			// Sidebar name if theme supports it; otherwise ID.
			$results[ $sidebar_id ]['name']         = ! empty( $wp_registered_sidebars[ $sidebar_id ]['name'] ) ? $wp_registered_sidebars[ $sidebar_id ]['name'] : $sidebar_id;
			$results[ $sidebar_id ]['message_type'] = $sidebar_message_type;
			$results[ $sidebar_id ]['message']      = $sidebar_message;
			$results[ $sidebar_id ]['widgets']      = array();

			// Loop widgets.
			foreach ( $widgets as $widget_instance_id => $widget ) {
				$fail = false;

				// Get id_base (remove -# from end) and instance ID number.
				$id_base            = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
				$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

				// Does site support this widget?
				if ( ! $fail && ! isset( $available_widgets[ $id_base ] ) ) {
					$fail                = true;
					$widget_message_type = 'errorMessage';
					$widget_message      = esc_html__( 'Site does not support widget', 'widget-importer-exporter' ); // Explain why widget not imported.
				}


				$widget = json_decode( wp_json_encode( $widget ), true );

				// Does widget with identical settings already exist in same sidebar?
				if ( ! $fail && isset( $widget_instances[ $id_base ] ) ) {
					// Get existing widgets in this sidebar.
					$sidebars_widgets = get_option( 'sidebars_widgets' );
					$sidebar_widgets  = isset( $sidebars_widgets[ $use_sidebar_id ] ) ? $sidebars_widgets[ $use_sidebar_id ] : array(); // Check Inactive if that's where will go.

					// Loop widgets with ID base.
					$single_widget_instances = ! empty( $widget_instances[ $id_base ] ) ? $widget_instances[ $id_base ] : array();
					foreach ( $single_widget_instances as $check_id => $check_widget ) {
						// Is widget in same sidebar and has identical settings?
						if ( in_array( "$id_base-$check_id", $sidebar_widgets, true ) && (array) $widget === $check_widget ) {
							$fail                = true;
							$widget_message_type = 'warning';

							// Explain why widget not imported.
							$widget_message = esc_html__( 'Widget already exists', 'widget-importer-exporter' );

							break;
						}
					}
				}

				// No failure.
				if ( ! $fail ) {
					// Add widget instance
					$single_widget_instances   = get_option( 'widget_' . $id_base ); // All instances for that widget ID base, get fresh every time.
					$single_widget_instances   = ! empty( $single_widget_instances ) ? $single_widget_instances : array(
						'_multiwidget' => 1,   // Start fresh if have to.
					);
					$single_widget_instances[] = $widget; // Add it.

					// Get the key it was given.
					end( $single_widget_instances );
					$new_instance_id_number = key( $single_widget_instances );

					// If key is 0, make it 1
					// When 0, an issue can occur where adding a widget causes data from other widget to load,
					// and the widget doesn't stick (reload wipes it).
					if ( '0' === strval( $new_instance_id_number ) ) {
						$new_instance_id_number                             = 1;
						$single_widget_instances[ $new_instance_id_number ] = $single_widget_instances[0];
						unset( $single_widget_instances[0] );
					}

					// Move _multiwidget to end of array for uniformity.
					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
						$multiwidget = $single_widget_instances['_multiwidget'];
						unset( $single_widget_instances['_multiwidget'] );
						$single_widget_instances['_multiwidget'] = $multiwidget;
					}

					// Update option with new widget.
					update_option( 'widget_' . $id_base, $single_widget_instances );

					// Assign widget instance to sidebar.
					// Which sidebars have which widgets, get fresh every time.
					$sidebars_widgets = get_option( 'sidebars_widgets' );

					// Avoid rarely fatal error when the option is an empty string
					// https://github.com/churchthemes/widget-importer-exporter/pull/11.
					if ( ! $sidebars_widgets ) {
						$sidebars_widgets = array();
					}

					// Use ID number from new widget instance.
					$new_instance_id = $id_base . '-' . $new_instance_id_number;

					// Add new instance to sidebar.
					$sidebars_widgets[ $use_sidebar_id ][] = $new_instance_id;

					// Save the amended data.
					update_option( 'sidebars_widgets', $sidebars_widgets );

					// After widget import action.
					$after_widget_import = array(
						'sidebar'           => $use_sidebar_id,
						'sidebar_old'       => $sidebar_id,
						'widget'            => $widget,
						'widget_type'       => $id_base,
						'widget_id'         => $new_instance_id,
						'widget_id_old'     => $widget_instance_id,
						'widget_id_num'     => $new_instance_id_number,
						'widget_id_num_old' => $instance_id_number,
					);
					do_action( 'wie_after_widget_import', $after_widget_import );

					// Success message.
					if ( $sidebar_available ) {
						$widget_message_type = 'success';
						$widget_message      = esc_html__( 'Imported', 'widget-importer-exporter' );
					} else {
						$widget_message_type = 'warning';
						$widget_message      = esc_html__( 'Imported to Inactive', 'widget-importer-exporter' );
					}
				}
				// Result for widget instance
				$results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['name']         = isset( $available_widgets[ $id_base ]['name'] ) ? $available_widgets[ $id_base ]['name'] : $id_base;      // Widget name or ID if name not available (not supported by site).
				$results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['title']        = ! empty( $widget['title'] ) ? $widget['title'] : esc_html__( 'No Title', 'widget-importer-exporter' );  // Show "No Title" if widget instance is untitled.
				$results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['message_type'] = $widget_message_type;
				$results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['message']      = $widget_message;
			}
		}

		return $results;
	}

	/**
	 * Starting point of import customizer settings logic
	 */
	public function import_customizer( $file ) {
		if ( ! file_exists( $file ) ) {
			return [
				'success'      => false,
				'errorMessage' => esc_html__( 'Customizer export file not found please try it manually.', 'divi_flash' )
			];
		}
		$template = get_template();
		// Get the upload data.
		$raw  = file_get_contents( $file );
		$data = @unserialize( $raw );

		// Data checks.
		if ( 'array' != gettype( $data ) ) {
			return [
				'success'      => false,
				'errorMessage' => esc_html__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'divi_flash' )
			];
		}

		if ( ! isset( $data['template'] ) || ! isset( $data['mods'] ) ) {
			return [
				'success'      => false,
				'errorMessage' => esc_html__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'divi_flash' )
			];
		}

		if ( $data['template'] != $template ) {
			return [
				'success'      => false,
				'errorMessage' => esc_html__( 'Error importing settings! The settings you uploaded are not for the current theme.', 'divi_flash' )
			];
		}

		return $this->import_customizer_data( $data );
	}

	/**
	 *
	 * Import Customizer Settings
	 */

	public function import_customizer_data( $data ) {
		// Clear Divi customizer settings.

		wp_cache_delete( 'et_divi', 'options' );
		wp_cache_delete( 'alloptions', 'options' );

		global $wp_customize;
		global $customizer_reset_error;
		$template = get_template();
		// Data checks.
		if ( ! is_array( $data ) ) {
			$customizer_reset_error = __( 'ERROR importing settings! Please make sure that you uploaded a customizer export file.', 'customizer-reset' );

			return [ 'success' => false, 'errorMessage' => $customizer_reset_error ];
		}

		if ( ! isset( $data['template'] ) || ! isset( $data['mods'] ) ) {
			$customizer_reset_error = __( 'ERROR importing settings! Please make sure that you uploaded a customizer export file.', 'customizer-reset' );

			return [ 'success' => false, 'errorMessage' => $customizer_reset_error ];
		}

		if ( $data['template'] !== $template ) {
			$customizer_reset_error = __( 'ERROR importing settings! The settings you uploaded are not for the current theme.', 'customizer-reset' );

			return [ 'success' => false, 'errorMessage' => $customizer_reset_error ];
		}

		// Import images.
		$data['mods'] = $this->import_customizer_images( $data['mods'] );

		// Import custom options.
		if ( isset( $data['options'] ) ) {

			foreach ( $data['options'] as $option_key => $option_value ) {

				$option = new \DIFL_Customizer_Option_Import(
					$wp_customize,
					$option_key,
					array(
						'default'    => '',
						'type'       => 'option',
						'capability' => 'edit_theme_options',
					)
				);

				$option->import( $option_value );
			}
		}


		// Reset ET Options cache
		global $et_theme_options;
		$et_theme_options = get_option( 'et_divi' );
		// If wp_css is set then import it.
		if ( function_exists( 'wp_update_custom_css_post' ) && isset( $data['wp_css'] ) && '' !== $data['wp_css'] ) {
			wp_update_custom_css_post( $data['wp_css'] );
		}


		// Call the customize_save action.
		// do_action( 'customize_save', $wp_customize );

		// Loop through the mods.
		foreach ( $data['mods'] as $key => $val ) {

			// Call the customize_save_ dynamic action.
			do_action( 'customize_save_' . $key, $wp_customize );

			// Save the mod.
			set_theme_mod( $key, $val );
		}

		// Reset ET Options cache
		global $et_theme_options;
		$et_theme_options = get_option( 'et_divi' );


		// Call the customize_save_after action.
		do_action( 'customize_save_after', $wp_customize );

		return [ 'success' => true ];

	}


	/**
	 * Imports images for settings saved as mods.
	 *
	 * @param array $mods An array of customizer mods.
	 *
	 * @return array The mods array with any new import data.
	 * @since 0.1
	 * @access private
	 */
	protected function import_customizer_images( $mods ) {
		foreach ( $mods as $key => $val ) {

			if ( is_string( $val ) && preg_match( '/\.(jpg|jpeg|png|gif)/i', $val ) ) { // Is Image

				$data = $this->_sideload_image( $val );

				if ( ! is_wp_error( $data ) ) {

					$mods[ $key ] = $data->url;

					// Handle header image controls.
					if ( isset( $mods[ $key . '_data' ] ) ) {
						$mods[ $key . '_data' ] = $data;
						update_post_meta( $data->attachment_id, '_wp_attachment_is_custom_header', get_stylesheet() );
					}
				}
			}
		}

		return $mods;
	}

	/**
	 * Taken from the core media_sideload_image function and
	 * modified to return an array of data instead of html.
	 *
	 * @param string $file The image file path.
	 *
	 * @return object An object of image data.
	 * @since 0.1
	 * @access protected
	 */
	protected function _sideload_image( $file ) {
		$data = new stdClass();

		if ( ! function_exists( 'media_handle_sideload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
		}
		if ( ! empty( $file ) ) {

			// Set variables for storage, fix file filename for query strings.
			preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches );
			$file_array         = array();
			$file_array['name'] = basename( $matches[0] );

			// Download file to temp location.
			$file_array['tmp_name'] = download_url( $file );

			// If error storing temporarily, return the error.
			if ( is_wp_error( $file_array['tmp_name'] ) ) {
				return $file_array['tmp_name'];
			}

			// Do the validation and storage stuff.
			$id = media_handle_sideload( $file_array, 0 );

			// If error storing permanently, unlink.
			if ( is_wp_error( $id ) ) {
				@unlink( $file_array['tmp_name'] );

				return $id;
			}

			// Build the object to return.
			$meta                = wp_get_attachment_metadata( $id );
			$data->attachment_id = $id;
			$data->url           = wp_get_attachment_url( $id );
			$data->thumbnail_url = wp_get_attachment_thumb_url( $id );
			$data->height        = $meta['height'];
			$data->width         = $meta['width'];
		}

		return $data;
	}

	public function import_builder_templates( $file ) {
		$filesystem = $this->set_filesystem();


		if ( ! file_exists( $file ) ) {
			return [
				'success'      => false,
				'errorMessage' => esc_html__( "Import file doesn't exist", 'divi_flash' )
			];
		}

		$export = json_decode( $filesystem->get_contents( $file ), true );
		$_      = et_();
		if ( null === $export ) {
			wp_send_json_error(
				array(
					'code'         => ET_Theme_Builder_Api_Errors::UNKNOWN,
					'errorMessage' => esc_html__( 'An unknown error has occurred. Please try again later.' ),
				)
			);
		}
		$portability = et_core_portability_load( 'et_theme_builder' );
		if ( ! $portability->is_valid_theme_builder_export( $export ) ) {
			wp_send_json_error(
				array(
					'code'         => ET_Theme_Builder_Api_Errors::PORTABILITY_INCORRECT_CONTEXT,
					'errorMessage' => esc_html( 'This file should not be imported in this context.', 'divi_flash' ),
				)
			);
		}
		// $override_default_website_template = '1' === $_->array_get( $_POST, 'override_default_website_template', '0' );
		$override_default_website_template = true;
		$import_presets                    = '1' === $_->array_get( $_POST, 'import_presets', '0' ); //phpcs:ignore
		$has_default_template              = $_->array_get( $export, 'has_default_template', false );
		$has_global_layouts                = $_->array_get( $export, 'has_global_layouts', false );
		$presets                           = $_->array_get( $export, 'presets', array() );
		$presets_rewrite_map               = array();
		$incoming_layout_duplicate         = false;

		// Make imported preset overrides to avoid collisions with local presets.
		if ( $import_presets && is_array( $presets ) && ! empty( $presets ) ) {
			$presets_rewrite_map = $portability->prepare_to_import_layout_presets( $presets );
		}

		// Prepare import steps.
		$layout_id_map = array();
		$layout_keys   = array( 'header', 'body', 'footer' );
		$id            = md5( get_current_user_id() . '_' . uniqid( 'et_theme_builder_import_', true ) );
		$transient     = 'et_theme_builder_import_' . get_current_user_id() . '_' . $id;
		$steps_files   = array();


		foreach ( $export['templates'] as $index => $template ) {
			foreach ( $layout_keys as $key ) {
				$layout_id = (int) $_->array_get( $template, array( 'layouts', $key, 'id' ), 0 );

				if ( 0 === $layout_id ) {
					continue;
				}

				$layout = $_->array_get( $export, array( 'layouts', $layout_id ), null );


				if ( empty( $layout ) ) {
					continue;
				}

				// Use a temporary string id to avoid numerical keys being reset by various array functions.
				$template_id = 'template_' . $index;
				$is_global   = (bool) $_->array_get( $layout, 'theme_builder.is_global', false );
				$create_new  = ( $template['default'] && $override_default_website_template ) || ! $is_global || $incoming_layout_duplicate;

				if ( $create_new ) {
					$temp_id = 'tbi-step-' . count( $steps_files );

					et_theme_builder_api_import_theme_builder_save_layout( $portability, $template_id, $layout_id, $layout, $temp_id, $transient );

					$steps_files[] = array(
						'id'    => $temp_id,
						'group' => $transient,
					);
				} else {
					if ( ! isset( $layout_id_map[ $layout_id ] ) ) {
						$layout_id_map[ $layout_id ] = array();
					}

					$layout_id_map[ $layout_id ][ $template_id ] = 'use_global';
				}
			}
		}


		set_transient(
			$transient,
			array(
				'ready'                             => false,
				'steps'                             => $steps_files,
				'templates'                         => $export['templates'],
				'override_default_website_template' => $override_default_website_template,
				'incoming_layout_duplicate'         => $incoming_layout_duplicate,
				'layout_id_map'                     => $layout_id_map,
				'presets'                           => $presets,
				'import_presets'                    => $import_presets,
				'presets_rewrite_map'               => $presets_rewrite_map,
			),
			60 * 60 * 24
		);

		return array(
			'success' => true,
			'id'      => $id,
			'steps'   => count( $steps_files ),
		);
	}

	function import_builder_templates_step( $payload ) {
		if ( ! et_pb_is_allowed( 'theme_builder' ) ) {
			wp_send_json_error();
		}

		$_         = et_();
		$id        = sanitize_text_field( $_->array_get( $payload, 'id', '' ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is done in `et_builder_security_check`.
		$step      = (int) $_->array_get( $payload, 'step', 0 ); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is done in `et_builder_security_check`.
		$chunk     = (int) $_->array_get( $payload, 'chunk', 0 ); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is done in `et_builder_security_check`.
		$transient = 'et_theme_builder_import_' . get_current_user_id() . '_' . $id;
		$export    = get_transient( $transient );

		if ( false === $export ) {
			wp_send_json_error();
		}

		$layout_keys         = array( 'header', 'body', 'footer' );
		$portability         = et_core_portability_load( 'et_theme_builder' );
		$steps               = $export['steps'];
		$ready               = empty( $steps );
		$layout_id_map       = $export['layout_id_map'];
		$presets             = $export['presets'];
		$presets_rewrite_map = $export['presets_rewrite_map'];
		$import_presets      = $export['import_presets'];
		$templates           = array();
		$template_settings   = array();
		$chunks              = 1;


		if ( ! $ready ) {
			$import_step                   = et_theme_builder_api_import_theme_builder_load_layout( $portability, $steps[ $step ]['id'], $steps[ $step ]['group'] );
			$import_step                   = array_merge( $import_step, array( 'presets' => $presets ) );
			$import_step                   = array_merge( $import_step, array( 'presets_rewrite_map' => $presets_rewrite_map ) );
			$import_step['import_presets'] = $import_presets;
			$result                        = $portability->import_theme_builder( $id, $import_step, count( $steps ), $step, $chunk );

			if ( false === $result ) {
				wp_send_json_error();
			}

			$ready  = $result['ready'];
			$chunks = $result['chunks'];

			foreach ( $result['layout_id_map'] as $old_id => $new_ids ) {
				$layout_id_map[ $old_id ] = array_merge(
					$_->array_get( $layout_id_map, $old_id, array() ),
					$new_ids
				);
			}
		}

		if ( $ready ) {
			if ( $import_presets && is_array( $presets ) && ! empty( $presets ) ) {
				if ( ! $portability->import_global_presets( $presets ) ) {
					$presets_error = apply_filters( 'et_core_portability_import_error_message', '' );

					if ( $presets_error ) {
						wp_send_json_error(
							array(
								'code'         => ET_Theme_Builder_Api_Errors::PORTABILITY_IMPORT_PRESETS_FAILURE,
								'errorMessage' => $presets_error,
							)
						);
					}
				}
			}

			$portability->delete_temp_files( $transient );

			$conditions = array();

			foreach ( $export['templates'] as $index => $template ) {
				$sanitized = et_theme_builder_sanitize_template( $template );

				foreach ( $layout_keys as $key ) {
					$old_layout_id = (int) $_->array_get( $sanitized, array( 'layouts', $key, 'id' ), 0 );
					$layout_id     = et_()->array_get( $layout_id_map, array(
						$old_layout_id,
						'template_' . $index
					), '' );
					$layout_id     = ! empty( $layout_id ) ? $layout_id : 0;

					$_->array_set( $sanitized, array( 'layouts', $key, 'id' ), $layout_id );
				}

				$conditions = array_merge( $conditions, $sanitized['use_on'], $sanitized['exclude_from'] );

				$templates[] = $sanitized;
			}

			// Load all conditions from templates.
			$conditions        = array_unique( $conditions );
			$template_settings = array_replace(
				et_theme_builder_get_flat_template_settings_options(),
				et_theme_builder_load_template_setting_options( $conditions )
			);
			$valid_settings    = array_keys( $template_settings );

			// Strip all invalid conditions from templates.
			foreach ( $templates as $index => $template ) {
				$templates[ $index ]['use_on']       = array_values( array_intersect( $template['use_on'], $valid_settings ) );
				$templates[ $index ]['exclude_from'] = array_values( array_intersect( $template['exclude_from'], $valid_settings ) );
			}
		} else {
			set_transient(
				$transient,
				array_merge(
					$export,
					array(
						'layout_id_map' => $layout_id_map,
					)
				),
				60 * 60 * 24
			);
		}

		return array(
			'success'          => true,
			'chunks'           => $chunks,
			'templates'        => $templates,
			'templateSettings' => $template_settings
		);
	}

	function et_theme_builder_api_save( $payload ) {
		$_             = et_();
		$live          = '1' === $_->array_get( $payload, 'live', '1' );
		$first_request = '1' === $_->array_get( $payload, 'first_request', '1' ); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is done in `et_builder_security_check`.
		$last_request  = '1' === $_->array_get( $payload, 'last_request', '1' ); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is done in `et_builder_security_check`.
		$new_templates = wp_unslash( $_->array_get( $payload, 'templates', array() ) );

		$templates = et_theme_builder_get_theme_builder_templates( true );
		foreach ( $new_templates as $template ) {
			$template['enabled'] = '1';
			if ( ( isset( $template['default'] ) && ( $template['default'] === true || $template['default'] === '1' ) ) ) {
				$template['default'] = '1';
			}
			$templates[] = $template;
		}

		$theme_builder_id = et_theme_builder_get_theme_builder_post_id( $live, true );
		$has_default      = false;
		$updated_ids      = array();

		// Always reset the cached templates on first request.
		if ( $first_request ) {
			ET_Core_Cache_File::set( 'et_theme_builder_templates', array() );
		}

		$cached_templates = ET_Core_Cache_File::get( 'et_theme_builder_templates' );

		// Populate the templates.
		foreach ( $templates as $index => $template ) {

			$cached_templates[ $_->array_get( $template, 'id', 'unsaved_' . $index ) ] = $template;
		}

		// Store the populated templates data into the cache file.
		ET_Core_Cache_File::set( 'et_theme_builder_templates', $cached_templates );

		if ( $last_request ) {
			$affected_templates = array();

			// Update or insert templates.
			foreach ( $cached_templates as $template ) {
				$raw_post_id = $_->array_get( $template, 'id', 0 );
				$post_id     = is_numeric( $raw_post_id ) ? (int) $raw_post_id : 0;
				$new_post_id = et_theme_builder_store_template( $theme_builder_id, $template, ! $has_default );


				if ( ! $new_post_id ) {
					continue;
				}

				$is_default = get_post_meta( $new_post_id, '_et_default', true ) === '1';

				if ( $is_default ) {
					$has_default = true;
				}

				// Add template ID into $affected_templates for later use
				// to Add mapping template ID to theme builder ID
				// and delete existing template mapping.
				$affected_templates[ $new_post_id ] = array(
					'raw'        => $raw_post_id,
					'normalized' => $post_id,
				);
			}

			$existing_templates = get_post_meta( $theme_builder_id, '_et_template', false );

			if ( $existing_templates ) {
				// Store existing template mapping as backup to avoid data lost
				// when user interrupting the saving process before completed.
				update_option( 'et_tb_templates_backup_' . $theme_builder_id, $existing_templates );
			}


			// Delete existing template mapping.
			delete_post_meta( $theme_builder_id, '_et_template' );

			// Insert new template mapping.
			foreach ( $affected_templates as $template_id => $template_pair ) {
				add_post_meta( $theme_builder_id, '_et_template', $template_id );

				if ( $template_pair['normalized'] !== $template_id ) {
					$updated_ids[ $template_pair['raw'] ] = $template_id;
				}
			}

			// Delete existing template mapping backup.
			delete_option( 'et_tb_templates_backup_' . $theme_builder_id );

			if ( $live ) {
				et_theme_builder_trash_draft_and_unused_posts();
			}

			et_theme_builder_clear_wp_cache( 'all' );

			// Always reset the cached templates on last request after data stored into database.
			ET_Core_Cache_File::set( 'et_theme_builder_templates', array() );

			// Remove static resources on save. It's necessary because how we are generating the dynamic assets for the TB.
			ET_Core_PageResource::remove_static_resources( 'all', 'all', false, 'dynamic' );
		}

		return array(
			'success'            => true,
			'updatedTemplateIds' => (object) $updated_ids,
		);
	}

	public function maybe_add_default_layout( $templates ) {
		$has_default = false;
		foreach ( $templates as $template ) {
			if ( $template['default'] ) {
				$has_default = true;
			}
		}

		if ( ! $has_default ) {
			array_unshift( $templates, [
				'title'               => 'Default Website Template',
				'autogenerated_title' => false,
				'default'             => 1,
				'enabled'             => 1,
				'layouts'             => [
					'header' => [
						'id'      => 0,
						'enabled' => true,
					],
					'body'   => [
						'id'      => 0,
						'enabled' => true,
					],
					'footer' => [
						'id'      => 0,
						'enabled' => true,
					]
				]
			] );

		}

		return $templates;
	}

	public function install_plugin( $slug, $pagenow = '' ) {


		if ( empty( $slug ) ) {
			return array(
				'success'      => false,
				'slug'         => '',
				'errorCode'    => 'no_plugin_specified',
				'errorMessage' => __( 'No plugin specified.' ),
			);
		}

		$status = array(
			'install' => 'plugin',
			'slug'    => sanitize_key( wp_unslash( $slug ) ),
		);

		if ( ! current_user_can( 'install_plugins' ) ) {
			$status['errorMessage'] = __( 'Sorry, you are not allowed to install plugins on this site.' );

			return [ 'success' => false, 'status' => $status ];
		}

		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

		$api = plugins_api(
			'plugin_information',
			array(
				'slug'   => sanitize_key( wp_unslash( $slug ) ),
				'fields' => array(
					'sections' => false,
				),
			)
		);

		if ( is_wp_error( $api ) ) {
			$status['errorMessage'] = $api->get_error_message();
			wp_send_json_error( $status );
		}

		$status['pluginName'] = $api->name;

		$skin     = new \WP_Ajax_Upgrader_Skin();
		$upgrader = new \Plugin_Upgrader( $skin );
		$result   = $upgrader->install( $api->download_link );

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$status['debug'] = $skin->get_upgrade_messages();
		}

		if ( is_wp_error( $result ) ) {
			$status['errorCode']    = $result->get_error_code();
			$status['errorMessage'] = $result->get_error_message();

			return [ 'success' => false, 'status' => $status ];
		} elseif ( is_wp_error( $skin->result ) ) {
			$status['errorCode']    = $skin->result->get_error_code();
			$status['errorMessage'] = $skin->result->get_error_message();

			return [ 'success' => false, 'status' => $status ];
		} elseif ( $skin->get_errors()->has_errors() ) {
			$status['errorMessage'] = $skin->get_error_messages();

			return [ 'success' => false, 'status' => $status ];
		} elseif ( is_null( $result ) ) {
			global $wp_filesystem;

			$status['errorCode']    = 'unable_to_connect_to_filesystem';
			$status['errorMessage'] = __( 'Unable to connect to the filesystem. Please confirm your credentials.' );

			// Pass through the error from WP_Filesystem if one was raised.
			if ( $wp_filesystem instanceof WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->has_errors() ) {
				$status['errorMessage'] = esc_html( $wp_filesystem->errors->get_error_message() );
			}

			return [ 'success' => false, 'status' => $status ];
		}

		$install_status = install_plugin_install_status( $api );
		$pagenow        = isset( $pagenow ) ? sanitize_key( $pagenow ) : '';

		// If installation request is coming from import page, do not return network activation link.
		$plugins_url = ( 'import' === $pagenow ) ? admin_url( 'plugins.php' ) : network_admin_url( 'plugins.php' );

		if ( current_user_can( 'activate_plugin', $install_status['file'] ) && is_plugin_inactive( $install_status['file'] ) ) {
			$status['activateUrl'] = add_query_arg(
				array(
					'_wpnonce' => wp_create_nonce( 'activate-plugin_' . $install_status['file'] ),
					'action'   => 'activate',
					'plugin'   => $install_status['file'],
				),
				$plugins_url
			);
		}

		if ( is_multisite() && current_user_can( 'manage_network_plugins' ) && 'import' !== $pagenow ) {
			$status['activateUrl'] = add_query_arg( array( 'networkwide' => 1 ), $status['activateUrl'] );
		}

		return [ 'success' => true, 'status' => $status ];
	}

	public function activate_plugin( $plugin ) {
		$current = get_option( 'active_plugins' );
		$plugin  = plugin_basename( trim( $plugin ) );

		if ( ! in_array( $plugin, $current ) ) {
			$current[] = $plugin;
			sort( $current );
			do_action( 'activate_plugin', trim( $plugin ) );
			update_option( 'active_plugins', $current );
			do_action( 'activate_' . trim( $plugin ) );
			do_action( 'activated_plugin', trim( $plugin ) );
		}

		return true;
	}

	public function import_customizer_and_layout( $import ) {
		global $shortname;
		$timestamp              = $this->get_timestamp();
		$include_global_presets = false;
		$temp_presets           = false;
		self::$_doing_import    = true;
		if ( isset( $import['images'] ) ) {
//			$images = $this->maybe_paginate_images( (array) $import['images'], 'upload_images', $timestamp );
			$import['data'] = $this->replace_images_urls( $import['images'], $import['data'] );
		}

		if ( ! empty( $import['global_colors'] ) ) {
			$import['data'] = $this->_maybe_inject_gcid( $import['data'], $import['global_colors'] );
		}

		$data    = $import['data'];
		$success = array( 'timestamp' => $timestamp );

		if ( 'options' === $this->instance->type ) {
			// Reset all data besides excluded data.
			$current_data = $this->apply_query( get_option( $this->instance->target, array() ), 'unset' );

			if ( isset( $data['wp_custom_css'] ) && function_exists( 'wp_update_custom_css_post' ) ) {
				wp_update_custom_css_post( $data['wp_custom_css'] );

				if ( 'yes' === get_theme_mod( 'et_pb_css_synced', 'no' ) ) {
					// If synced, clear the legacy custom css value to avoid unwanted merging of old and new css.
					$data["{$shortname}_custom_css"] = '';
				}
			}

			// Import Google API settings.
			if ( isset( $et_google_api_settings ) ) {
				// Get exising Google API key, sine it is not added to export.
				$et_previous_google_api_settings   = get_option( 'et_google_api_settings' );
				$et_previous_google_api_key        = isset( $et_previous_google_api_settings['api_key'] ) ? $et_previous_google_api_settings['api_key'] : '';
				$et_google_api_settings['api_key'] = $et_previous_google_api_key;

				update_option( 'et_google_api_settings', $et_google_api_settings );
			}

			// Merge remaining current data with new data and update options.
			update_option( $this->instance->target, array_merge( $current_data, $data ) );

			set_theme_mod( 'et_pb_css_synced', 'no' );
		}

		// Pass the post content and let js save the post.
		if ( 'post' === $this->instance->type ) {
			$success['postContent'] = reset( $data );

			// In some cases we receive the post array instaed of shortcode string. Handle this case.
			$shortcode_string = is_array( $success['postContent'] ) && ! empty( $success['postContent']['post_content'] ) ? $success['postContent']['post_content'] : $success['postContent'];

			if ( ! empty( $import['presets'] ) ) {
				$preset_rewrite_map = $this->prepare_to_import_layout_presets( $import['presets'] );
				$global_presets     = $import['presets'];

				$shortcode_object = et_fb_process_shortcode( $shortcode_string );
				$this->rewrite_module_preset_ids( $shortcode_object, $import['presets'], $preset_rewrite_map );

				$shortcode_string = et_fb_process_to_shortcode( $shortcode_object, array(), '', false );
			}

			do_shortcode( $shortcode_string );

			$success['postContent'] = $shortcode_string;
			$success['migrations']  = \ET_Builder_Module_Settings_Migration::$migrated;
			$success['presets']     = isset( $import['presets'] ) && is_array( $import['presets'] ) ? $import['presets'] : (object) array();
		}

		if ( 'post_type' === $this->instance->type ) {
			$preset_rewrite_map = array();
			if ( ! empty( $import['presets'] ) && $include_global_presets ) {
				$preset_rewrite_map = $this->prepare_to_import_layout_presets( $import['presets'] );
				$global_presets     = $import['presets'];
			}

			foreach ( $data as &$post ) {
				$shortcode_object = et_fb_process_shortcode( $post['post_content'] );

				if ( ! empty( $import['presets'] ) ) {
					if ( $include_global_presets ) {
						$this->rewrite_module_preset_ids( $shortcode_object, $import['presets'], $preset_rewrite_map );
					} else {
						$this->apply_global_presets( $shortcode_object, $import['presets'] );
					}
				}

				$post_content = et_fb_process_to_shortcode( $shortcode_object, array(), '', false );
				// Add slashes for post content to avoid unwanted unslashing (by wp_unslash) while post is inserting.
				$post['post_content'] = wp_slash( $post_content );

				// Upload thumbnail image if exist.
				if ( ! empty( $post['post_meta'] ) && ! empty( $post['post_meta']['_thumbnail_id'] ) ) {
					$post_thumbnail_origin_id = (int) $post['post_meta']['_thumbnail_id'][0];

					if ( ! empty( $import['thumbnails'] ) && ! empty( $import['thumbnails'][ $post_thumbnail_origin_id ] ) ) {
						$post_thumbnail_new = $this->upload_images( $import['thumbnails'][ $post_thumbnail_origin_id ] );
						$new_thumbnail_data = reset( $post_thumbnail_new );

						// New thumbnail image was uploaded and it should be updated.
						if ( isset( $new_thumbnail_data['replacement_id'] ) ) {
							$new_thumbnail_id  = $new_thumbnail_data['replacement_id'];
							$post['thumbnail'] = $new_thumbnail_id;

							if ( ! function_exists( 'wp_crop_image' ) ) {
								include ABSPATH . 'wp-admin/includes/image.php';
							}

							$thumbnail_path = get_attached_file( $new_thumbnail_id );

							// Generate all the image sizes and update thumbnail metadata.
							$new_metadata = wp_generate_attachment_metadata( $new_thumbnail_id, $thumbnail_path );
							wp_update_attachment_metadata( $new_thumbnail_id, $new_metadata );
						}
					}
				}
			}

			$imported_posts = $this->import_posts( $data );

			if ( false === $imported_posts ) {
				/**
				 * Filters the error message when {@see ET_Core_Portability::import()} fails.
				 *
				 * @param mixed $error_message Default is `null`.
				 *
				 * @since 3.0.99
				 *
				 */
				if ( $error_message = apply_filters( 'et_core_portability_import_error_message', false ) ) {
					$error_message = array( 'message' => $error_message );
				}

				return $error_message;
			} else {
				$success['imported_posts'] = $imported_posts;
			}
		}

		if ( ! empty( $global_presets ) ) {
			if ( ! $this->import_global_presets( $global_presets, $temp_presets ) ) {
				if ( $error_message = apply_filters( 'et_core_portability_import_error_message', false ) ) {
					$error_message = array( 'message' => $error_message );
				}

				return $error_message;
			}
		}

		if ( ! empty( $import['global_colors'] ) ) {
			$this->import_global_colors( $import['global_colors'] );
			$success['globalColors'] = et_builder_get_all_global_colors();
		}

		return $success;
	}

	protected function replace_images_urls( $images, $data ) {
		foreach ( $data as $post_id => &$post_data ) {
			foreach ( $images as $image ) {
				if ( is_array( $post_data ) ) {
					foreach ( $post_data as $post_param => &$param_value ) {
						if ( ! is_array( $param_value ) ) {
							$data[ $post_id ][ $post_param ] = $this->replace_image_url( $param_value, $image );
						}
					}
					unset( $param_value );
				} else {
					$data[ $post_id ] = $this->replace_image_url( $post_data, $image );
				}
			}
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
	public function export_posts_query() {
		return parent::export_posts_query();
	}
}