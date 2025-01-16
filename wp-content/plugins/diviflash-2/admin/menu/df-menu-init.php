<?php

require_once ABSPATH . 'wp-admin/includes/nav-menu.php';

class DF_Menu_Admin_Init {

	public static $menu_item_settings_key = '_df_mega_menu_item_settings';

	const META_KEY = '_df_am_dashboard';

	function __construct() {
		add_action( 'rest_api_init', [ $this, 'df_register_menu_ex_route' ] );
		add_action( 'admin_init', [ $this, 'handle_old_menu_meta' ] );
		add_action( 'admin_footer', [ $this, 'render_container_for_dashboard' ] );
		// load menu dashboard styles and scripts
		add_action( 'admin_enqueue_scripts', [ $this, 'load_styles_scripts' ] );
	}

	/**
	 * Handle old post meta which should be term meta.
	 *
	 * @return void
	 */
	public function handle_old_menu_meta() {
		$is_latest = '1.4.5' >= DIFL_VERSION;
		$meta_key  = self::META_KEY;

		if ( ! $is_latest ) {
			return;
		}

		global $wpdb;

		$posts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE meta_key=%s", $meta_key ) );

		if ( ! $posts ) {
			return;
		}

		foreach ( $posts as $post ) {
			$post_id    = $post->post_id;
			$meta_value = $post->meta_value;

			$term = get_term( $post_id, 'nav_menu' );
			if ( empty( $term ) || is_wp_error( $term ) ) {
				continue;
			}
			update_term_meta( $post_id, self::META_KEY, $meta_value );
		}
	}

	/**
	 * Check current screen
	 * If the screen is not nav-menus then return false
	 *
	 * @return boolean
	 */
	public function check_current_screen() {
		$screen = get_current_screen();

		return $screen->id === 'nav-menus' ? true : false;
	}

	/**
	 * Render container for dashboard
	 *
	 * @return void
	 */
	public function render_container_for_dashboard() {
		if ( ! $this->check_current_screen() ) {
			return;
		}
		echo '<div id="df-menu-dashboard"></div>';
	}

	/**
	 * Load necessary styles & scripts
	 * for DiviFlash Menu Dashboard
	 *
	 * @return void
	 */
	public function load_styles_scripts() {
		if ( ! $this->check_current_screen() ) {
			return;
		}

		$dir = __DIR__;

		$df_dashboard_asset_path = "$dir/assets/index.asset.php";

		// dashboard script
		$df_dashboard_js           = 'assets/index.js';
		$df_dashboard_script_asset = require( $df_dashboard_asset_path );
		wp_enqueue_script(
			'diviflash-menu-dashboard-admin-editor',
			plugins_url( $df_dashboard_js, __FILE__ ),
			$df_dashboard_script_asset['dependencies'],
			$df_dashboard_script_asset['version'],
			true
		);
		wp_set_script_translations( 'diviflash-menu-dashboard-admin-editor', 'divi_flash' );

		wp_localize_script( 'diviflash-menu-dashboard-admin-editor', 'df_menu', [
			'nonce'    => wp_create_nonce( 'df_menu_settings' ),
			'layouts'  => wp_json_encode( $this->df_get_library_items_for_menu() ),
			'site_url' => get_site_url(),
		] );

		// dashboard css
		$df_dashboard_css = 'assets/index.css';
		wp_enqueue_style(
			'diviflash-menu-dashboard-admin',
			plugins_url( $df_dashboard_css, __FILE__ ),
			[ 'wp-components' ],
			filemtime( "$dir/$df_dashboard_css" )
		);
	}

	/**
	 * Registering Rest API endpoints.
	 *
	 * - get-nav-menu
	 * - get-nav-menu-items
	 * - save-nav-menu-items
	 *
	 * @return void
	 */
	public function df_register_menu_ex_route() {
		register_rest_route( 'df-menu-settings/v2', '/get-nav-menu', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ $this, 'get_menu_items_data_callback' ],
			'permission_callback' => function () {
				return current_user_can( 'edit_others_posts' );
			},
		] );
		register_rest_route( 'df-menu-settings/v2', '/get-nav-menu-items', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ $this, 'get_nav_menu_items_callback' ],
			'permission_callback' => function () {
				return current_user_can( 'edit_others_posts' );
			},
		] );
		register_rest_route( 'df-menu-settings/v2', '/save-nav-menu-items', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ $this, 'save_nav_menu_items_callback' ],
			'permission_callback' => function () {
				return current_user_can( 'edit_others_posts' );
			},
		] );
		register_rest_route( 'df-menu-settings/v2', '/df-am-option-edit', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ $this, 'df_am_option_edit_callback' ],
			'permission_callback' => function () {
				return current_user_can( 'edit_others_posts' );
			},
		] );
		register_rest_route( 'df-menu-settings/v2', '/df-am-option-edit-set', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ $this, 'df_am_option_edit_set_callback' ],
			'permission_callback' => function () {
				return current_user_can( 'edit_others_posts' );
			},
		] );
		register_rest_route( 'df-menu-settings/v2', '/df-am-export-menu', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ $this, 'df_am_export_menu' ],
			'permission_callback' => function () {
				return current_user_can( 'edit_others_posts' );
			},
		] );
		register_rest_route( 'df-menu-settings/v2', '/df-am-import-menu', [
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => [ $this, 'df_am_import_menu' ],
			'permission_callback' => function () {
				return current_user_can( 'edit_others_posts' );
			},
		] );
	}

	public function df_am_export_menu( $request ) {
		$items         = $this->get_nav_menu_items_callback( $request );
		$data          = wp_json_encode( $this->get_menu_items_data_callback( $request ) );
		$library_items = [];
		$parent_object = [];

		foreach ( json_decode( $items ) as $id => $value ) {
			$item = json_decode( $value, true );
			if ( array_key_exists( 'library_items', $item ) && ! empty( $item['library_items'] ) ) {
				array_push( $library_items, $item['library_items'] );
			}

			if ( array_key_exists( 'menu_item_object_id', $item ) && ! empty( $item['menu_item_object_id'] ) ) {
				array_push( $parent_object, get_post( $item['menu_item_object_id'] ) );
			}
		}

		$library_items = $this->get_library_items( $library_items );
		$tab_lib_items = $this->get_tab_lib_item( $library_items );
		$response      = [
			'menu'  => $data,
			'items' => $items,
		];

		if ( ! empty( $library_items ) ) {
			$response['library_items'] = wp_json_encode( $library_items );
		}

		if ( ! empty( $parent_object ) ) {
			$response['parent_object'] = wp_json_encode( $parent_object );
		}

		if ( ! empty( $tab_lib_items ) ) {
			$response['tab_lib_items'] = json_encode( $tab_lib_items );
		}

		wp_send_json( wp_json_encode( $response ) );
	}

	public function df_am_import_menu( $request ) {
		$menuId           = $this->get_menu_id( $request );
		$settings         = json_decode( $request['settings'], true );
		$meta_items       = json_decode( $settings['items'] );
		$menu_items       = json_decode( $settings['menu'] );
		$library_items    = array_key_exists( 'library_items', $settings ) ? json_decode( $settings['library_items'] ) : '';
		$tab_lib_items    = array_key_exists( 'tab_lib_items', $settings ) ? json_decode( $settings['tab_lib_items'] ) : '';
		$parent_objects   = array_key_exists( 'parent_object', $settings ) ? json_decode( $settings['parent_object'] ) : '';
		$taxonomy_objects = array_filter( $menu_items, function ( $item ) {
			return 'taxonomy' === $item->type;
		} );

		$lib_mapper             = [];
		$tab_lib_mapper         = [];
		$menu_item_mapper       = [];
		$parent_id_mapper       = [];
		$parent_object_mapper   = [];
		$taxonomy_object_mapper = [];
		$menu_meta_keys         = [
			'type',
			'menu_item_parent',
			'object',
			'target',
			'classes',
			'xfn',
			'url',
		];
		$menu_meta_prefix       = '_menu_item_';
		if ( ! empty( $taxonomy_objects ) ) {
			foreach ( $taxonomy_objects as $taxonomy_object ) {
				$term_id = wp_insert_term( $taxonomy_object->title, $taxonomy_object->object );
				if ( is_wp_error( $term_id ) && array_key_exists( 'term_exists', $term_id->errors ) ) {
					$term_id = $term_id->error_data['term_exists'];
				}

				$taxonomy_object_mapper[ $taxonomy_object->object_id ] = is_array( $term_id ) ? $term_id['term_id'] : $term_id;
			}
		}

		if ( ! empty( $tab_lib_items ) ) {
			foreach ( $tab_lib_items as $library_item ) {
				$old_id = $library_item->ID;
				unset( $library_item->ID );
				$post_id = wp_insert_post( $library_item );

				if ( isset( $post['thumbnail'] ) ) {
					set_post_thumbnail( $post_id, $post['thumbnail'] );
				}

				if ( ! empty( $library_item->post_meta ) && is_array( $library_item->post_meta ) ) {
					foreach ( $library_item->post_meta as $key => $value ) {
						$key = sanitize_text_field( $key );

						if ( count( $value ) < 2 ) {
							$value = wp_kses_post( $value[0] );
						} else {
							$value = array_map( 'wp_kses_post', $value );
						}
						update_post_meta( $post_id, $key, $value );
					}
				}

				if ( ! empty( $library_item->terms ) ) {
					$processed_terms = [];

					foreach ( $library_item->terms as $term ) {
						if ( empty( $term->parent ) ) {
							$parent = 0;
						} else {
							if ( isset( $term->all_parents ) && ! empty( $term->all_parents ) ) {
								$this->restore_parent_categories( $term->all_parents, $term->taxonomy );
							}

							$parent = term_exists( $term->parent, $term->taxonomy );

							if ( is_array( $parent ) ) {
								$parent = $parent['term_id'];
							}
						}

						if ( ! $insert = term_exists( $term->slug, $term->taxonomy ) ) {
							$insert = wp_insert_term( $term->name, $term->taxonomy, [
								'slug'        => $term->slug,
								'description' => $term->description,
								'parent'      => intval( $parent ),
							] );
						}

						if ( is_array( $insert ) && ! is_wp_error( $insert ) ) {
							$processed_terms[ $term->taxonomy ][] = $term->slug;
						}
					}

					// Set post terms.
					foreach ( $processed_terms as $taxonomy => $ids ) {
						wp_set_object_terms( $post_id, $ids, $taxonomy );
					}
				}
				$tab_lib_mapper[ $old_id ] = $post_id;
			}
		}

		if ( ! empty( $library_items ) ) {
			foreach ( $library_items as $library_item ) {
				// Handle nested tab_lib_item
				preg_match_all( '/\[difl_advancedtabitem.*\[\/difl_advancedtabitem]/', $library_item->post_content, $matches );
				if ( ! empty( $matches[0] ) ) {
					foreach ( $matches[0] as $match ) {
						$tab_items = et_fb_process_shortcode( $match );
						foreach ( $tab_items as &$tab_item ) {
							if ( 'difl_advancedtabitem' !== $tab_item['type'] ) {
								continue;
							}

							if ( 'library' !== $tab_item['attrs']['content_type'] ) {
								break;
							}
							preg_match_all( '/library_item="(\d+)/', $match, $ids );
							if ( ! empty( $ids[1] ) && is_array( $ids[1] ) ) {
								foreach ( $ids[1] as $id ) {
									$old_id                     = $id;
									$search                     = "library_item=\"${old_id}\"";
									$new_id                     = $tab_lib_mapper[ $old_id ];
									$replace                    = "library_item=\"${new_id}\"";
									$library_item->post_content = str_replace( $search, $replace, $library_item->post_content );
								}
							}
						}
					}
				}

				$old_id = $library_item->ID;
				unset( $library_item->ID );
				$post_id = wp_insert_post( $library_item );

				if ( ! empty( $library_item->post_meta ) && is_array( $library_item->post_meta ) ) {
					foreach ( $library_item->post_meta as $key => $value ) {
						$key = sanitize_text_field( $key );

						if ( count( $value ) < 2 ) {
							$value = wp_kses_post( $value[0] );
						} else {
							$value = array_map( 'wp_kses_post', $value );
						}
						update_post_meta( $post_id, $key, $value );
					}
				}

				if ( ! empty( $library_item->terms ) ) {
					$processed_terms = [];

					foreach ( $library_item->terms as $term ) {
						if ( empty( $term->parent ) ) {
							$parent = 0;
						} else {
							if ( isset( $term->all_parents ) && ! empty( $term->all_parents ) ) {
								$this->restore_parent_categories( $term->all_parents, $term->taxonomy );
							}

							$parent = term_exists( $term->parent, $term->taxonomy );

							if ( is_array( $parent ) ) {
								$parent = $parent['term_id'];
							}
						}

						if ( ! $insert = term_exists( $term->slug, $term->taxonomy ) ) {
							$insert = wp_insert_term( $term->name, $term->taxonomy, [
								'slug'        => $term->slug,
								'description' => $term->description,
								'parent'      => intval( $parent ),
							] );
						}

						if ( is_array( $insert ) && ! is_wp_error( $insert ) ) {
							$processed_terms[ $term->taxonomy ][] = $term->slug;
						}
					}

					// Set post terms.
					foreach ( $processed_terms as $taxonomy => $ids ) {
						wp_set_object_terms( $post_id, $ids, $taxonomy );
					}
				}
				$lib_mapper[ $old_id ] = $post_id;
			}
		}

		if ( ! empty( $parent_objects ) ) {
			foreach ( $parent_objects as $parent_object ) {
				$old_id = $parent_object->ID;
				unset( $parent_object->ID );
				$post_id                         = wp_insert_post( $parent_object );
				$parent_object_mapper[ $old_id ] = $post_id;
			}
		}

		if ( ! empty( $menu_items ) ) {
			foreach ( $menu_items as $menu_item ) {
				$old_id = $menu_item->ID;
				unset( $menu_item->ID );
				unset( $menu_item->guid );
				$post_id              = wp_insert_post( $menu_item );
				$menu_item->object_id = $post_id;
				foreach ( $menu_meta_keys as $meta_key ) {
					update_post_meta( $post_id, $menu_meta_prefix . $meta_key, $menu_item->$meta_key );
				}

				$term = get_term( $menuId, 'nav_menu' );
				wp_set_object_terms( $post_id, $term->term_taxonomy_id, 'nav_menu' );
				$menu_item_mapper[ $old_id ] = $post_id;
				$parent_id_mapper[ $old_id ] = $menu_item->menu_item_parent;
			}
		}

		foreach ( $meta_items as $id => $value ) {
			$item                        = json_decode( $value, true );
			$item['menu_id']             = $menuId;
			$item['menu_item_id']        = $menu_item_mapper[ ! empty( $item['menu_item_id'] ) ? $item['menu_item_id'] : 0 ];
			$item['library_items']       = $lib_mapper[ ! empty( $item['library_items'] ) ? $item['library_items'] : 0 ];
			$item['menu_item_parent_id'] = ! empty( $item['menu_item_parent_id'] ) ? $item['menu_item_parent_id'] : 0;
			$post_id                     = $item['menu_item_id'];
			update_post_meta( $post_id, self::$menu_item_settings_key, wp_json_encode( $item ) );
			update_post_meta( $post_id, '_menu_item_object_id', $parent_object_mapper[ $item['menu_item_object_id'] ] );
		}

		foreach ( $menu_item_mapper as $id => $new_id ) {
			if ( empty( $parent_id_mapper[ $id ] ) ) {
				continue;
			}

			update_post_meta( $new_id, '_menu_item_menu_item_parent', $menu_item_mapper[ $parent_id_mapper[ $id ] ] );
		}

		foreach ( $menu_item_mapper as $id => $new_id ) {
			if ( empty( $taxonomy_object_mapper[ json_decode( $meta_items->$id )->menu_item_object_id ] ) ) {
				continue;
			}

			update_post_meta( $new_id, '_menu_item_object_id', $taxonomy_object_mapper[ json_decode( $meta_items->$id )->menu_item_object_id ] );
		}

		update_term_meta( $menuId, self::META_KEY, 'on' );

		wp_send_json( [
			'message'     => 'Successfully Imported',
			'success'     => true,
			'redirectURL' => admin_url( 'nav-menus.php?menu=' . $menuId )
		] );
	}

	public function get_menu_id( $request ) {
		$menuId = $request['menuId'];
		$menuId = wp_create_nav_menu( $menuId );
		if ( is_wp_error( $menuId ) && array_key_exists( 'menu_exists', $menuId->errors ) ) {
			$request->set_param( 'menuId', $request->get_param( 'menuId' ) . '_' . wp_rand( 1, 20 ) );
			$menuId = $this->get_menu_id( $request );
		}

		return $menuId;
	}

	public function df_am_option_edit_callback( WP_REST_Request $request ) {
		$id      = sanitize_key( $request['id'] );
		$options = get_term_meta( $id, self::META_KEY, true );

		return $options;
	}

	public function df_am_option_edit_set_callback( WP_REST_Request $request ) {
		$id      = sanitize_key( $request['id'] );
		$options = $request['_opt'];

		$options = $options == 'on' ? 'off' : 'on';

		update_term_meta( $id, self::META_KEY, $options );

		return $options;
	}

	/**
	 * Rest API callback.
	 * Process the request and return menu items.
	 *
	 * @return string | response
	 */
	public function get_nav_menu_items_callback( WP_REST_Request $request ) {
		$menu_id = sanitize_key( $request['id'] );
		$menu    = wp_get_nav_menu_object( $menu_id );

		if ( is_nav_menu( $menu ) ) {
			$menu_items = wp_get_nav_menu_items( $menu->term_id, [ 'post_status' => 'any' ] );
			$a          = [];
			foreach ( $menu_items as $key => $menu_item ) {
				$meta                            = get_post_meta( $menu_item->ID, DF_Menu_Admin_Init::$menu_item_settings_key, true );
				$parent_id                       = get_post_meta( $menu_item->ID, '_menu_item_menu_item_parent', true );
				$meta                            = json_decode( $meta, true );
				$meta['menu_id']                 = (string) $menu->term_id;
				$meta['menu_item_id']            = (string) $menu_item->ID;
				$meta['menu_item_object_id']     = get_post_meta( $menu_item->ID, '_menu_item_object_id', true );
				$meta['menu_item_parent_id']     = $parent_id;
				$meta['parent_mega_menu']        = DF_Menu_Admin_Init::get_parent_item_data( $menu_item->menu_item_parent, 'mega_menu' );
				$meta['parent_mega_menu_column'] = DF_Menu_Admin_Init::get_parent_item_data( $menu_item->menu_item_parent, 'mega_menu_column' );
				$meta                            = wp_json_encode( $meta );
				$a[ $menu_item->ID ]             = $meta;
			}

			return wp_json_encode( $a );
		}

		return 'No menu found';
	}

	/**
	 * Request API callback.
	 * Process the request and save menu items data.
	 *
	 * @return string | response
	 */
	public function save_nav_menu_items_callback( WP_REST_Request $request ) {
		$menu_id   = sanitize_key( $request['id'] );
		$menu_data = $request['menu'];
		$menu      = wp_get_nav_menu_object( $menu_id );

		if ( is_nav_menu( $menu ) ) {

			foreach ( $menu_data as $id => $data ) {
				update_post_meta( $id, DF_Menu_Admin_Init::$menu_item_settings_key, $data );
			}

			return 'Successfully Saved';
		}

		return 'No menu found';
	}

	/**
	 * Get the parent has mega menu
	 * enabled/disabled
	 *
	 * @param string | $id
	 * @param string | $key
	 *
	 * @return string
	 */
	public static function get_parent_item_data( $id, $key ) {
		$parent        = get_post_meta( $id, DF_Menu_Admin_Init::$menu_item_settings_key, true );
		$parent_object = json_decode( $parent, true );

		return isset( $parent_object[ $key ] ) ? $parent_object[ $key ] : null;
	}

	/**
	 * Menu item data array
	 *
	 * @param object $request
	 *
	 * @return string
	 */
	public function get_menu_items_data_callback( WP_REST_Request $request ) {
		$menu_id = sanitize_key( $request['id'] );
		$menu    = wp_get_nav_menu_object( $menu_id );

		if ( is_nav_menu( $menu ) ) {
			$menu_items = wp_get_nav_menu_items( $menu->term_id, [ 'post_status' => 'any' ] );

			return $menu_items;
		}

		return [ 'No menu found' ];
	}

	/**
	 * Get layouts from the Divi Library
	 * and create a new array
	 *
	 * @return array
	 */
	public function df_get_library_items_for_menu() {
		$args       = [
			'post_type'      => 'et_pb_layout',
			'posts_per_page' => - 1,
		];
		$item_array = [
			[ 'label' => 'Select Layout', 'value' => 'none' ],
		];
		$lib_items  = get_posts( $args );
		foreach ( $lib_items as $lib_item ) {
			$new_layout          = [];
			$new_layout['value'] = $lib_item->ID;
			$new_layout['label'] = $lib_item->post_title;
			$item_array[]        = $new_layout;
		}

		return $item_array;
	}

	public function get_library_items( $items ) {
		if ( empty( $items ) ) {
			return $items;
		}
		if ( ! class_exists( '\DIFL\Importer\Portability' ) ) {
			require_once DIFL_MAIN_DIR . '/includes/importer/Portability.php';
		}
		if ( ! class_exists( 'ET_Core_Portability' ) ) {
			require_once get_template_directory() . '/core/components/Portability.php';
		}
		$_POST['selection']                  = json_encode( $items );
		$difl_portability                    = new \DIFL\Importer\Portability( 'et_builder_layouts' );
		$difl_portability->instance          = new stdClass;
		$difl_portability->instance->target  = 'et_pb_layout';
		$difl_portability->instance->type    = 'post_type';
		$difl_portability->instance->context = 'et_builder_layouts';

		return $difl_portability->export_posts_query();
	}

	protected function restore_parent_categories( $parents_array, $taxonomy ) {
		foreach ( $parents_array as $slug => $category_data ) {
			$current_category = term_exists( $slug, $taxonomy );

			if ( ! is_array( $current_category ) ) {
				$parent_id = 0 !== $category_data['parent'] ? term_exists( $category_data['parent'], $taxonomy ) : 0;
				wp_insert_term( $category_data['name'], $taxonomy, [
					'slug'        => $slug,
					'description' => $category_data['description'],
					'parent'      => is_array( $parent_id ) ? $parent_id['term_id'] : $parent_id,
				] );
			} else if ( ( ! isset( $current_category['parent'] ) || 0 === $current_category['parent'] ) && 0 !== $category_data['parent'] ) {
				$parent_id = 0 !== $category_data['parent'] ? term_exists( $category_data['parent'], $taxonomy ) : 0;
				wp_update_term( $current_category['term_id'], $taxonomy, [ 'parent' => is_array( $parent_id ) ? $parent_id['term_id'] : $parent_id ] );
			}
		}
	}

	public function get_tab_lib_item( $library_items ) {
		$tab_lib_items = [];
		foreach ( $library_items as $library_item ) {
			preg_match_all( '/\[difl_advancedtabitem.*\[\/difl_advancedtabitem]/', $library_item->post_content, $matches );
			if ( empty( $matches[0] ) ) {
				continue;
			}
			foreach ( $matches[0] as $match ) {
				$tab_items = et_fb_process_shortcode( $match );
				foreach ( $tab_items as $tab_item ) {
					if ( 'difl_advancedtabitem' !== $tab_item['type'] ) {
						continue;
					}

					if ( 'library' === $tab_item['attrs']['content_type'] ) {
						array_push( $tab_lib_items, $tab_item['attrs']['library_item'] );
					}

				}
			}
		}

		return $this->get_library_items( $tab_lib_items );
	}
}

new DF_Menu_Admin_Init;
