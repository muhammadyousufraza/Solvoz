<?php
    /*
    Plugin Name: DiviFlash
    Plugin URI:  http://www.diviflash.com
    Description: Most advanced Divi plugin with powerful Divi modules, extensions, and premade layouts.
    Version:     1.4.5
    Author:      DiviFlash
    Author URI:  http://www.diviflash.com
    License:     GPL2
    License URI: https://www.gnu.org/licenses/gpl-2.0.html
    Text Domain: divi_flash
    Domain Path: /languages
    Tested up to: 6.3
    Requires at least: 5.6
    Requires PHP: 7.1
    Update URI: https://www.diviflash.com
    */

    if(!defined('DIFL_MAIN_DIR')) {
        define('DIFL_MAIN_DIR', __DIR__);
    }
    if(!defined('DIFL_ADMIN_DIR')) {
        define('DIFL_ADMIN_DIR', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'admin/');
    }
    if(!defined('DIFL_ADMIN_DIR_PATH')) {
        define('DIFL_ADMIN_DIR_PATH', plugin_dir_path( __FILE__ ) . 'admin/');
    }
    if(!defined('DIFL_PUBLIC_DIR')) {
        define('DIFL_PUBLIC_DIR', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'public/');
    }
    if(!defined('DIFL_PUBLIC_DIR_PATH')) {
        define('DIFL_PUBLIC_DIR_PATH', plugin_dir_path( __FILE__ ) . 'public/');
    }
    if(!defined('DIFL_MAIN_FILE_PATH')) {
        define('DIFL_MAIN_FILE_PATH', __FILE__);
    }
    if(!defined('DIFL_VERSION')) {
        define('DIFL_VERSION','1.4.5');
    }

    if ( ! defined( 'DIFL_BASENAME' ) ) {
        define( 'DIFL_BASENAME', plugin_basename( __FILE__ ) );
    }

    if( !defined('DIFL_PLACEHOLDER_LOGO')) {
        define('DIFL_PLACEHOLDER_LOGO', "data:image/png;base64,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");
    }

    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-diviflash-init.php';
    require plugin_dir_path( __FILE__ ) . 'includes/Fa_Icon_Handler.php';
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     */
    function run_diviflash() {

        $plugin = new DiviFlashInit();
        $plugin->run();
	    $module_manager = new Diviflash_Module_Manage();

	    if( get_option( 'difl_inactive_modules' ) ) { // if upgrade from v1.1.2
            update_option( 'df_inactive_modules', get_option( 'difl_inactive_modules' ) ); // clone from another key.
            delete_option( 'difl_inactive_modules' ); //clean up previouse option key
        }

	    if ( get_option( 'df_inactive_modules' ) ) { // upgrade from v1.1.5
		    $get_all_modules                       = $module_manager->get_all_modules();
		    $get_default_inactive_module           = json_decode( $module_manager->get_inactive_modules() );
		    $diff_module                           = array_diff( array_keys( $get_all_modules ), $get_default_inactive_module );
		    $default_inactive_latest_array         = array_filter( $module_manager->get_all_modules(), function ( $var ) {
			    if ( isset( $var['release_version'] ) ) {
				    return $var['release_version'] === DIFL_VERSION && $var['is_default_active'] === false;
			    }
		    } );
		    $default_inactive_latest_array_modules = array_keys( $default_inactive_latest_array );
		    $update_modules                        = array_diff( $diff_module, $default_inactive_latest_array_modules );

		    update_option( 'df_active_modules', wp_json_encode( array_values( $update_modules ) ) );
		    update_option( 'df_inactive_modules_added', DIFL_VERSION );
		    delete_option( 'df_inactive_modules' ); //clean up previouse option key
	    }

        if ( ! get_option('df_active_modules') ){	 // if First time purchase
            update_option( 'df_active_modules', wp_json_encode($module_manager->get_default_active_modules()) );
            update_option( 'df_inactive_modules_added', DIFL_VERSION );
        }
    }

    run_diviflash();

    /**
     * Auto-deactivate DiviFlash Plugin if inactive Divi/Extra child or parent theme or Divi Builder
     *
     */
    function df_deactivate_if_theme_builder_uses() {
        // Don't do anything if the user isn't logged in
        if ( ! is_user_logged_in() ) {
            return;
        }

        if (class_exists('ET_Core_API_ElegantThemes')) {
            return;
        }

        if ( current_user_can( 'activate_plugins' ) ) {
            add_action( 'admin_notices', 'df_auto_deactivate_notice' );
            add_action( 'admin_init', 'df_auto_deactivate' );
        }
    }
    add_action( 'init', 'df_deactivate_if_theme_builder_uses' );

    /**
     * Deactivate this plugin
     *
     */
    function df_auto_deactivate() {
        deactivate_plugins( DIFL_BASENAME );
    }

    /**
     * Print a WP Admin notice when DiviFlash has deactivated
     *
     */
    function df_auto_deactivate_notice() {
        $classes = 'notice notice-warning is-dismissible';
        $message = __( 'First You should activate Divi/Extra theme or Divi Builder to use diviflash.', 'et_builder' );

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $classes ), esc_html( $message ) );

        if ( isset( $_GET['activate'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
            unset( $_GET['activate'] ); // phpcs:ignore WordPress.Security.NonceVerification
        }
    }

	add_filter( 'et_builder_load_requests', function ( $request ) {
		$request['action'][] = 'difl_layout_import';
		return $request;
	}, PHP_INT_MAX );

	if ( ! ( df_divi_is_theme() || df_divi_is_plugin() ) ) {
		return;
	}

	if ( is_admin() && ( df_divi_is_theme() || df_divi_is_plugin() ) ) {
		if ( ! defined( 'WP_LOAD_IMPORTERS' ) && ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] === 'diviflash' ) ) { // phpcs:disable WordPress.Security.NonceVerification.Recommended -- as this is general handling nonce checking can be escaped
			define( 'WP_LOAD_IMPORTERS', true );
		}

		if ( ! defined( 'WP_LOAD_IMPORTERS' ) && wp_doing_ajax() && ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'difl_layout_import' ) ) { // phpcs:disable WordPress.Security.NonceVerification.Recommended -- as this is general handling nonce checking can be escaped
			define( 'WP_LOAD_IMPORTERS', true );
		}

		if ( ! class_exists( 'ET_Core_Portability' ) ) {
			require_once df_load_portability_class();
		}
		require plugin_dir_path( __FILE__ ) . 'admin/RemoteData.php';
		require plugin_dir_path( __FILE__ ) . 'admin/Dashboard.php';
	}


	remove_action( 'wp_ajax_et_core_portability_export', 'et_core_portability_ajax_export' );
	if ( ! function_exists( 'et_core_portability_load_extended' ) ) {
		if ( ! class_exists( 'ET_Core_Portability' ) ) {
			require_once df_load_portability_class();
		}
		function et_core_portability_load_extended( $context ) {
			return new ET_Core_Portability_Extended( $context );
		}
	}

	class ET_Core_Portability_Extended extends ET_Core_Portability {
		protected function get_data_images( $data, $force = false ) {
			if ( empty( $data ) ) {
				return [];
			}

			$images     = [];
			$images_src = [];
			$basenames  = [
				'field_image',
				'hotsopt_image',
				'text_img',
				'line_top_image',
				'line_bottom_image',
				'content_image',
				'list_item_icon_lottie_src_upload',
				'list_item_image',
				'divider_image',
				'answer_image',
				'sticky_logo',
				'logo_upload',
				'ap_photo',
				'ap_alternative_photo',
				'marker_img',
				'company_logo',
				'different_lightbox_image',
				'scroll_image',
				'instagram_user_profile_picture',
				'open_question_image',
				'tab_image',
				'before_image',
				'after_image',
				'image_icon',
				'image_as_icon',
				'close_question_image' .
				'src',
				'image_url',
				'background_image',
				'image',
				'url',
				'bg_img_?\d?',
			];
			$suffixes   = [
				'__hover',
				'_tablet',
				'_phone',
			];

			foreach ( $basenames as $basename ) {
				$images_src[] = $basename;
				foreach ( $suffixes as $suffix ) {
					$images_src[] = $basename . $suffix;
				}
			}

			foreach ( $data as $value ) {
				// If the $value is an object and there is no post_content property,
				// it's unlikely to contain any image data so we can continue with the next iteration.
				if ( is_object( $value ) && ! property_exists( $value, 'post_content' ) ) {
					continue;
				}

				if ( is_array( $value ) || is_object( $value ) ) {
					// If the $value contains the post_content property, set $value to use
					// this object's property value instead of the entire object.
					if ( is_object( $value ) && property_exists( $value, 'post_content' ) ) {
						$value = $value->post_content;
					}

					$images = array_merge( $images, $this->get_data_images( (array) $value ) );
					continue;
				}

				// Extract images from HTML or shortcodes.
				if ( preg_match_all( '/(' . implode( '|', $images_src ) . ')="(?P<src>\w+[^"]*)"/i', $value, $matches ) ) {
					foreach ( array_unique( $matches['src'] ) as $key => $src ) {
						$images = array_merge( $images, $this->get_data_images( [ $key => $src ] ) );
					}
				}

				// Extract images from shortcodes gallery.
				if ( preg_match_all( '/gallery_ids="(?P<ids>\w+[^"]*)"/i', $value, $matches ) ) {
					foreach ( array_unique( $matches['ids'] ) as $galleries ) {
						$explode = explode( ',', str_replace( ' ', '', $galleries ) );

						foreach ( $explode as $image_id ) {
							$images = array_merge( $images, $this->get_data_images( [ (int) $image_id ], true ) );
						}
					}
				}

				if ( preg_match( '/^.+?\.(jpg|jpeg|jpe|png|gif|svg|webp)/', $value, $match ) || $force ) {
					$basename = basename( $value );

					// Skip if the value is not a valid URL or an image ID (integer).
					if ( ! ( wp_http_validate_url( $value ) || is_int( $value ) ) ) {
						continue;
					}

					// Skip if the images array already contains the value to avoid duplicates.
					if ( isset( $images[ $value ] ) ) {
						continue;
					}

					$images[ $value ] = $value;
				}
			}

			return $images;
		}
	}

	function et_core_portability_ajax_export_extended() {
		if ( ! isset( $_POST['context'] ) ) {
			wp_send_json_error();

			return;
		}

		$context = sanitize_text_field( $_POST['context'] );

		// phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.FoundInControlStructure, WordPress.CodeAnalysis.AssignmentInCondition.Found -- Existing codebase.
		if ( ! $capability = et_core_portability_cap( $context ) ) {
			wp_send_json_error();

			return;
		}

		if ( ! et_core_security_check_passed( $capability, 'et_core_portability_export', 'nonce' ) ) {
			wp_send_json_error();

			return;
		}

		$return = isset( $_POST['return'] ) && sanitize_text_field( $_POST['return'] );

		if ( $return ) {
			$data = et_core_portability_load_extended( $context )->export( $return );

			wp_send_json_success( $data );
		} else {
			et_core_portability_load_extended( $context )->export();
		}

		wp_send_json_error();
	}

	add_action( 'wp_ajax_et_core_portability_export', 'et_core_portability_ajax_export_extended' );