<?php
/**
 *
 * Load function.
 *
 * @package popup
 */

if ( file_exists( __DIR__ . '/functions.php' ) ) {
	require_once __DIR__ . '/functions.php';
}

/**
 *
 * Load function.
 *
 * @package Mobile Detect Library
 */
if ( file_exists( __DIR__ . '/MobileDetect.php' ) ) {
	require_once __DIR__ . '/MobileDetect.php';
}

/**
 * The Popup functionality of the plugin.
 */
class DF_Popup_Process {

	/**
	 * Popup post type
	 */
	const POST_TYPE = 'difl_popup';
	/**
	 * User Agent
	 *
	 * @var string
	 */
	private $user_agent;

	/**
	 * Device Detector
	 *
	 * @var Object
	 */
	private $detect;

	/**
	 * Overlay Trigger
	 *
	 * @var array
	 */
	private $overlays;

	/**
	 * User Role
	 *
	 * @var string
	 */
	private $user_role;

	/**
	 * Css Selector
	 *
	 * @var array
	 */
	private $css_selector = array();

	/**
	 * Close Selector
	 *
	 * @var array
	 */
	private $close_selector = array();

	/**
	 * Display Condition (type & device)
	 *
	 * @var bool
	 */
	private $display;

	/**
	 * Include Items
	 *
	 * @var array
	 */
	private $inc_items = array();

	/**
	 * Exclude Items
	 *
	 * @var array
	 */
	private $exc_items = array();

	/**
	 * Initialization
	 *
	 * @return void
	 */
	public function __construct() {
		$post_type    = self::POST_TYPE;
		$popup_enable = get_option( 'df_general_popup_enable' ) === '1' ? 'on' : 'off'; // change key after dashboard code update.
		if ( 'on' !== $popup_enable ) {
			return;
		}
		// Set user agent (Load lib).
		$this->df_user_device_detector();

		// Popup initialization.
		add_action( 'wp_footer', array( $this, 'init' ) );

		// Save Post meta.
		add_action( "save_post_$post_type", array( $this, 'save_et_meta' ), 10, 2 );
		add_action( "save_post_$post_type", [ $this, 'clear_static_file' ], 10, 2 );
		// Handle metabox for current post type.
		add_action( 'admin_init', array( $this, 'handle_metabox' ) );

		// Remove custom fields.
		add_action( 'admin_menu', array( $this, 'df_disable_popup_custom_fields' ) );

		add_filter( 'et_builder_post_type_options_blocklist', array( $this, 'blacklist_post_type' ) );
	}

	/**
	 *  Initialization
	 *
	 * @return void
	 */
	public function init() {
		echo '<div id="df-popup-extension" class="et-animated-content">';

		// Device detect.
		// $this->df_popup_display_device(); // remove for condition mismatch Now add 'df_popup_display_device_status' function.

		// Trigger popup.
		// $this->df_popup_automatic_trigger();.

		// Design.
		$this->df_popup_design();

		// Css selector.
		$this->df_popup_css_selector();

		// Close link selector.
		$this->df_popup_close_link_selector();

		// Trigger Type.
		$this->overlays = $this->css_selector + $this->df_popup_automatic_trigger() + $this->close_selector;

		// Popup display by user role
		// $this->df_popup_display_user_role(); // remove for condition mismatch Now add 'df_popup_display_user_role_status' function.

		// Popup display condition.
		$this->df_popup_dispaly_condition();

		// Display.
		$this->df_popup_display();

		echo '</div>';
	}

	/**
	 *  Device Detector
	 *
	 * @return void
	 */
	private function df_user_device_detector() {

		$user_agent = isset( $_SERVER['HTTP_USER_AGENT'] )
			? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';

		$this->user_agent = strtolower( $user_agent );
		// library: Mobile Detect.
		if ( class_exists( '\Detection\DIFL_MobileDetect' ) ) {
			$this->detect = new \Detection\DIFL_MobileDetect();
			$this->detect->setUserAgent( $this->user_agent );
		}
	}


	/**
	 * Display Popup by device
	 *
	 * @param int $popup_id Popup ID.
	 * @return boolean $device_status Device status
	 */
	private function df_popup_display_device_status( $popup_id ) {
		$device_status = false;
		if ( 'publish' === get_post_status( $popup_id ) ) {
			$post_settings = $this->df_get_popup_settings( $popup_id );

			// get devices.
			$devices     = $post_settings->df_popup_display_user_devices;
			$detect      = $this->detect;
			$get_devices = array();

			if ( $detect->isTablet() ) {
				array_push( $get_devices, 'tablet' );
			}

			// mobile.
			if ( $detect->isMobile() && ! in_array( 'tablet', $get_devices, true ) ) {
				array_push( $get_devices, 'mobile' );
			}

			// desktop.
			if ( ! $detect->isMobile() && ! in_array( 'tablet', $get_devices, true ) ) {
				array_push( $get_devices, 'desktop' );
			}

			if ( in_array( 'all', $devices, true ) || in_array( $get_devices[0], $devices, true ) ) {
				$device_status = true;
			}
		}

		return $device_status;
	}

	/**
	 * Get Popup settings
	 *
	 * @param string $id post ID.
	 * @return [] popup settings data
	 */
	private function df_get_popup_settings( $id ) {
		return json_decode( get_post_meta( $id, '_df_popup_item_settings', true ) );
	}

	/**
	 * Popup trigger on load
	 *
	 * @return array popup settings data
	 */
	private function df_popup_automatic_trigger() {
		$popups_with_automatic_trigger = array();

		// get post trigger type.
		$posts = $this->df_popup_get_trigger_click( '!=' );

		if ( ! empty( $posts[0] ) ) {
			echo '<script type="text/javascript">var popups_with_automatic_trigger = {';

			if ( ! empty( $posts[0] ) ) {
				foreach ( $posts as $post ) {
					$post_settings = $this->df_get_popup_settings( $post->ID );

					// Trigger type.
					// if ($this->display) {.
					$at_type = get_post_meta( $post->ID, '_df_popup_item_trigger_type', true );

					$at_timed             = 'on_load' === $at_type && $post_settings->df_popup_time_delay ? $post_settings->df_popup_time_delay : '';
					$at_scroll_from       = 'on_scroll' === $at_type && $post_settings->df_popup_scrolling_offset ? $post_settings->df_popup_scrolling_offset : '';
					$at_inactivity        = 'on_inactivity' === $at_type && $post_settings->df_popup_inactivity_time_delay ? $post_settings->df_popup_inactivity_time_delay : '';
					$at_scroll_to_element = 'scroll_to_element' === $at_type && $post_settings->df_popup_scroll_element_selector ? $post_settings->df_popup_scroll_element_selector : '';
					$at_scroll_to_element_viewport = 'scroll_to_element' === $at_type && $post_settings->df_popup_scroll_element_viewport ? $post_settings->df_popup_scroll_element_viewport : 'on_bottom';

					if ( '' !== $at_type ) {
						switch ( $at_type ) {
							case 'on_load':
								$at_value = $at_timed;
								$at_view  = '';
								break;
							case 'on_scroll':
								$at_value = $at_scroll_from;
								$at_view  = '';
								break;
							case 'scroll_to_element':
								$at_value = $at_scroll_to_element;
								$at_view  = $at_scroll_to_element_viewport;
								break;
							case 'on_inactivity':
								$at_value = $at_inactivity;
								$at_view  = '';
								break;
							default:
								$at_value = $at_type;
								$at_view  = '';
						}

						$at_settings = wp_json_encode(
							array(
								'at_type'  => $at_type,
								'at_value' => $at_value,
								'at_view'  => $at_view,
							),
							JSON_UNESCAPED_SLASHES
						);

						echo '' . wp_kses( '\'' . $post->ID . '\': \'' . $at_settings . '\',', array( 'code' => array() ) );

						$popups_with_automatic_trigger[ $post->ID ] = $at_type;
					}
					// }
				}
			}

			echo '};</script>';
		}

		return $popups_with_automatic_trigger;
	}

	/**
	 * Popup Css Selector
	 *
	 * @return void
	 */
	private function df_popup_css_selector() {
		// get post trigger type.
		$posts = $this->df_popup_get_trigger_click( '=' );
		// var_dump($posts[0]);.
		if ( ! empty( $posts[0] ) ) {
			echo '<script type="text/javascript">var popups_with_css_trigger = {';

			foreach ( $posts as $post ) {
				$post_settings = $this->df_get_popup_settings( $post->ID );
				$css_selector  = '' !== $post_settings->df_popup_custom_selector ? $post_settings->df_popup_custom_selector : 'no_click';

				if ( '' != $css_selector ) {
					echo '' . wp_kses(
							'\'' . $post->ID . '\': \'' . $css_selector . '\',',
							array( 'code' => array() )
						);
					$this->css_selector[ $post->ID ] = $css_selector;
				}
			}

			echo '};</script>';
			echo '<style type="text/css">';
			foreach ( $posts as $post ) {
				$post_settings = $this->df_get_popup_settings( $post->ID );
				$css_selector  = $post_settings->df_popup_custom_selector;
				if ( '' !== $css_selector ) {
					echo '' . wp_kses(
							'body .et_pb_row:not(.ui-sortable) ' . $css_selector . '{
							pointer-events:none;
						}',
							array( 'code' => array() )
						);
				}
			}
			echo '</style>';
		}
	}

	/**
	 * Popup close link selector
	 *
	 * @return void
	 */
	private function df_popup_close_link_selector() {
		$posts = $this->df_popup_get_posts();
		if ( empty( $posts ) ) {
			return;
		}

		$js_object = array();
		foreach ( $posts as $post ) {
			$post_id       = $post->ID;
			$post_settings = $this->df_get_popup_settings( $post_id );
			$css_selector  = isset( $post_settings->df_popup_close_link_selector ) ? $post_settings->df_popup_close_link_selector : '';
			if ( empty( $css_selector ) ) {
				continue;
			}
			$js_object[ $post_id ]             = $css_selector;
			$this->close_selector[ $post->ID ] = $css_selector;
		} ?>
        <script type="text/javascript">var df_popup_close_link_selector = <?php echo wp_json_encode( $js_object ); ?>
        </script>
		<?php
	}

	/**
	 * Popup display by user role
	 *
	 * @param int $popup_id Popup ID.
	 * @return bool
	 */
	private function df_popup_display_user_role_status( $popup_id ) {
		$role_status = false;
		if ( 'publish' === get_post_status( $popup_id ) ) {
			$single_popup_object         = $this->df_get_popup_settings( $popup_id );
			$df_popup_display_user_roles = $single_popup_object->df_popup_display_user_roles;
			if ( ( in_array( 'guest', $df_popup_display_user_roles ) ) && ! is_user_logged_in() ) {
				$role_status = true;
			}

			if ( ( in_array( 'all', $df_popup_display_user_roles ) ) ) {
				$role_status = true;
			}

			$current_user = wp_get_current_user();
			$user_role    = $current_user->roles;
			if ( ! empty( $user_role ) ) {
				if ( ( in_array( $user_role[0], $df_popup_display_user_roles, true ) ) ) {
					$role_status = true;
				}
			}
		}

		return $role_status;
	}

	/**
	 * Popup display by condition
	 *
	 * @return void
	 */
	public function df_popup_dispaly_condition() {
		$post_type = self::POST_TYPE;
		if ( is_array( $this->overlays ) && count( $this->overlays ) > 0 ) {
			foreach ( $this->overlays as $overlay_id => $idx ) {
				// exclude popup post.
				$popup_post_ids = get_posts( "post_type=$post_type&posts_per_page=-1&fields=ids" );
				foreach ( $popup_post_ids as $id ) {
					$this->exc_items[ $overlay_id ][] = $id;
				}

				if ( 'publish' === get_post_status( $overlay_id ) ) {
					$single_popup_object = $this->df_get_popup_settings( $overlay_id );
					$df_popup_status     = get_post_meta( $overlay_id, '_df_popup_item_status', true );
					if ( 1 == $df_popup_status ) {
						// Multiple display condition.
						if ( isset( $single_popup_object->df_popup_display_condition ) ) {
							$popups_display = $single_popup_object->df_popup_display_condition;
							foreach ( $popups_display as $popup_display ) {
								// entire site.
								if ( 'include' === $popup_display->condition_type && 'entire_site' === $popup_display->show_popup_at ) {
									$this->inc_items[ $overlay_id ][] = 'entire_site';
								}

								// specific pages.
								if ( ! empty( $popup_display->pages ) ) {
									foreach ( $popup_display->pages as $item_id ) {
										// all items.
										if ( 'all' == $item_id ) {
											$get_post_ids = '';
											if ( 'taxonomy' !== $popup_display->show_popup_at ) {
												$get_post_ids = $this->df_get_post_ids( $popup_display->show_popup_at );
											}
											if ( is_array( $get_post_ids ) && ! empty( $get_post_ids ) ) {
												foreach ( $get_post_ids as $id ) {
													'include' === $popup_display->condition_type ?
														$this->inc_items[ $overlay_id ][] = $id : $this->exc_items[ $overlay_id ][] = $id;
												}
											}
										}

										// taxonomy.
										if ( isset( $item_id->value ) && is_string( $item_id->value ) ) {
											$post_type    = get_post_type();
											$tax_post_ids = $this->df_get_post_ids_from_taxonomy( $item_id->value, $post_type );
											$tax_post_ids = array( $overlay_id => $tax_post_ids );

											$queried_obj_array = (array) get_queried_object();
											if ( is_archive() && has_term( '', $item_id->value ) ) {
												if ( array_key_exists( 'term_id', $queried_obj_array ) ) {
													'include' === $popup_display->condition_type ?
														$this->inc_items[ $overlay_id ][] = $queried_obj_array['term_id'] : $this->exc_items[ $overlay_id ][] = $queried_obj_array['term_id'];
												}
											}

											// push taxonomy ids.
											foreach ( $tax_post_ids as $overlay => $ids ) {
												'include' === $popup_display->condition_type ?
													$this->inc_items[ $overlay ][] = $ids : $this->exc_items[ $overlay ][] = $ids;
											}

											// remove string.
											unset( $item_id->value );
										}

										// push ids to inc/exc.
										if ( ! empty( $item_id->value ) ) {
											'include' === $popup_display->condition_type ?
												$this->inc_items[ $overlay_id ][] = $item_id->value : $this->exc_items[ $overlay_id ][] = $item_id->value;
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Popup Display
	 *
	 * @return void
	 */
	private function df_popup_display() {
		$current_post_id = get_queried_object_id();
		if ( function_exists( 'wc_get_page_id' ) && is_shop() ) {
			$current_post_id = wc_get_page_id( 'shop' );
		}
		if ( is_front_page() ) {
			$current_post_id = get_the_ID();
		}

		if ( ! empty( $this->overlays ) ) {
			foreach ( $this->overlays as $overlay_id => $idx ) {
				if ( ! empty( $this->inc_items ) ) {
					foreach ( $this->inc_items as $key => $values ) {

						$all_val_inc = $this->df_make_flat_arr( $values );

						// entire site.
						if ( in_array( 'entire_site', $all_val_inc ) && $key == $overlay_id ) {  // Include && Entire Site.

							$exc_items_flat = $this->df_make_flat_arr( $this->exc_items[ $overlay_id ] );

							if ( ! in_array( $current_post_id, $exc_items_flat ) &&
							     $this->df_popup_display_user_role_status( $overlay_id ) && // user role check.
							     $this->df_popup_display_device_status( $overlay_id )           // User Device check.
							) {
								echo et_core_esc_previously( showPopup( $overlay_id ) );
							}
						} elseif ( in_array( $current_post_id, $all_val_inc ) && $key == $overlay_id ) { // Include && not Entire Site.
							if ( $this->df_popup_display_user_role_status( $overlay_id ) && // user role check.
							     $this->df_popup_display_device_status( $overlay_id ) ) {// User Device check.
								echo et_core_esc_previously( showPopup( $overlay_id ) );
							}
						}
					}
				}

				if ( ! empty( $this->exc_items ) ) {// Only Exclude Item.
					foreach ( $this->exc_items as $key => $values ) {
						$all_val_exc = $this->df_make_flat_arr( $values );
						if ( in_array( $current_post_id, $all_val_exc ) && $key == $overlay_id ) {
							echo et_core_esc_previously( showPopup( $overlay_id = null ) );
						}
					}
				}
			}
		}
	}

	/**
	 * Nested array to flat
	 *
	 * @param array $array_val Complex array.
	 * @return array
	 */
	private function df_make_flat_arr( $array_val ) {
		$result = array();

		foreach ( $array_val as $value ) {
			if ( is_array( $value ) ) {
				$result = array_merge( $result, $this->df_make_flat_arr( $value ) );
			} else {
				$result[] = $value;
			}
		}

		return $result;
	}

	/**
	 * Popup design
	 *
	 * @return void
	 */
	private function df_popup_design() {
		// get trigger type.
		$posts = $this->df_popup_get_posts();

		if ( isset( $posts[0] ) ) {
			// Design.
			foreach ( $posts as $post ) {
				$post_settings               = $this->df_get_popup_settings( $post->ID );
				$overlay_background          = isset( $post_settings->df_popup_overlay_bg_color ) ? $post_settings->df_popup_overlay_bg_color : 'rgba(61,61,61,0.9)';
				$overlay_gradient_background = isset( $post_settings->df_popup_overlay_bg_gradient ) ? $post_settings->df_popup_overlay_bg_gradient : '';
				$close_btn_design_active     = isset( $post_settings->df_popup_close_btn_design_on ) ? $post_settings->df_popup_close_btn_design_on : false;
				$close_btn_color             = isset( $post_settings->df_popup_close_btn_color ) ? $post_settings->df_popup_close_btn_color : '#fff';
				$close_btn_font_size         = isset( $post_settings->df_popup_close_btn_font_size ) ? $post_settings->df_popup_close_btn_font_size : '72px';
				$close_btn_font_weight       = isset( $post_settings->df_popup_close_btn_font_weight ) ? $post_settings->df_popup_close_btn_font_weight : '300';
				// $close_btn_width = $post_settings->df_popup_close_btn_width ? $post_settings->df_popup_close_btn_width : '0';
				// $close_btn_height = $post_settings->df_popup_close_btn_height ? $post_settings->df_popup_close_btn_height : '0';
				$close_btn_line_height             = isset( $post_settings->df_popup_close_btn_line_height ) ? $post_settings->df_popup_close_btn_line_height : '50px';
				$close_btn_background              = isset( $post_settings->df_popup_close_btn_background ) ? $post_settings->df_popup_close_btn_background : 'transparent';
				$close_btn_border                  = isset( $post_settings->df_popup_close_btn_border ) ? $post_settings->df_popup_close_btn_border : array(
					'top'    => '0px',
					'right'  => '0px',
					'bottom' => '0px',
					'left'   => '0px',
				);
				$close_btn_border_color            = isset( $post_settings->df_popup_close_btn_border_color ) ? $post_settings->df_popup_close_btn_border_color : 'transparent';
				$close_btn_border_radius           = isset( $post_settings->df_popup_close_btn_border_radius ) ? $post_settings->df_popup_close_btn_border_radius : array(
					'top'    => '0px',
					'right'  => '0px',
					'bottom' => '0px',
					'left'   => '0px',
				);
				$close_btn_padding                 = isset( $post_settings->df_popup_close_btn_padding ) ? $post_settings->df_popup_close_btn_padding : array(
					'top'    => '0px',
					'right'  => '0px',
					'bottom' => '0px',
					'left'   => '0px',
				);
				$close_btn_margin                  = isset( $post_settings->df_popup_close_btn_margin ) ? $post_settings->df_popup_close_btn_margin : array(
					'top'    => '0px',
					'right'  => '0px',
					'bottom' => '0px',
					'left'   => '0px',
				);
				$close_btn_move_inner_content      = isset( $post_settings->df_popup_close_btn_move_inner_content ) ? $post_settings->df_popup_close_btn_move_inner_content : false;
				$df_popup_close_on_overlay_click   = isset( $post_settings->df_popup_close_on_overlay_click ) ? $post_settings->df_popup_close_on_overlay_click : false;
				$make_clickable_outside_popup_area = isset( $post_settings->df_popup_clickable_outside_popup_area ) ? $post_settings->df_popup_clickable_outside_popup_area : false;
				$df_popup_content_position_type    = isset( $post_settings->df_popup_content_position ) ? $post_settings->df_popup_content_position : 'center';
				$df_popup_animation_type           = isset( $post_settings->df_popup_animation_type ) ? $post_settings->df_popup_animation_type : 'fade_in';
				$df_popup_animation_duration       = isset( $post_settings->df_popup_animation_duration ) ? $post_settings->df_popup_animation_duration : '500';
				$df_popup_animation_time_function  = isset( $post_settings->df_popup_animation_time_function ) ? $post_settings->df_popup_animation_time_function : 'linear';

				$df_popup_close_animation_enable        = isset( $post_settings->df_popup_close_animation_enable ) ? $post_settings->df_popup_close_animation_enable : false;
				$df_popup_close_animation_type          = isset( $post_settings->df_popup_close_animation_type ) ? $post_settings->df_popup_close_animation_type : 'fade_in';
				$df_popup_close_animation_duration      = isset( $post_settings->df_popup_close_animation_duration ) ? $post_settings->df_popup_close_animation_duration : '100';
				$df_popup_close_animation_time_function = isset( $post_settings->df_popup_close_animation_time_function ) ? $post_settings->df_popup_close_animation_time_function : 'linear';
				// $df_popup_enable_custom_css = isset($post_settings->df_popup_enable_custom_css) ? $post_settings->df_popup_enable_custom_css : false;
				// $df_popup_custom_css = $df_popup_enable_custom_css === true && isset($post_settings->df_popup_custom_css) ? $post_settings->df_popup_custom_css : '';
				// Transform values - element position
				$trans_values = array(
					'top_left'         => 'top: 0px !important; left: 0px !important; transform: none !important;',
					'top_left_cornar'  => 'top: 0px !important; left: 0px !important; transform: translateX(-100%) translateY(-100%) !important;',
					'top_center'       => 'top: 0px !important; left: 50% !important; transform: translateX(-50%) !important;',
					'top_right'        => 'top:0px !important; left: 100% !important; transform: translate(-100%) !important;',
					'top_right_cornar' => 'top:0px !important; left: 100% !important; transform: translateX(0%) translateY(-100%) !important;',
					'center_left'      => 'left: 0px !important; top: 50% !important; transform: translateY(-50%) !important;',
					'center'           => 'left: 50% !important; top:50% !important; transform: translate(-50%, -50%) !important;',
					'center_right'     => 'left: 100% !important; top: 50% !important; transform: translate(-100%, -50%) !important;',
					'bottom_left'      => 'left:0px !important; top: 100% !important; transform: translateY(-100%) !important;',
					'bottom_center'    => 'left: 50% !important; top:100% !important; transform: translate(-50% ,-100%) !important',
					'bottom_right'     => 'left: 100% !important; top: 100% !important; transform: translate(-100% ,-100%) !important;',
				);

				// Popup Content position.

				$translate_values       = array(
					'top_left'      => 'align-items:start !important; justify-content:start !important',
					'top_center'    => 'align-items:center !important; justify-content:start !important;',
					'top_right'     => 'align-items:end !important; justify-content:start !important;',
					'center_left'   => 'align-items:start !important; justify-content:center !important;',
					'center'        => 'align-items:center !important; justify-content:center !important;',
					'center_right'  => 'align-items:end !important; justify-content:center !important;',
					'bottom_left'   => 'align-items:start !important; justify-content:end !important;',
					'bottom_center' => 'align-items:center !important; justify-content:end !important;',
					'bottom_right'  => 'align-items:end !important; justify-content:end !important;',
				);
				$popup_content_position = $translate_values[ $df_popup_content_position_type ];
				$custom_style           = '';
				$custom_style          .= '
					#popup_' . $post->ID . ' .df_popup_inner_container {
					' . $popup_content_position . '
					}
					';

				if ( '' !== $overlay_gradient_background ) {
					$overlay_background = $overlay_gradient_background;
				}

				if ( '' !== $overlay_background ) {
					$custom_style .= '
					#popup_' . $post->ID . ' {
						background:' . $overlay_background . ' !important;
					}
					';
				}

				// animation.

				$animation_cubic_value = $this->df_get_cubic_bezier_value( $df_popup_animation_time_function );
				$custom_style         .= '
				#popup_' . $post->ID . '.' . $df_popup_animation_type . '.active .df_popup_inner_container{
					visibility: visible;
					animation: ' . $df_popup_animation_type . ' ' . $df_popup_animation_duration . 'ms;

					animation-timing-function: ' . $animation_cubic_value . ';
				}
				';

				if ( $df_popup_close_animation_enable ) {
					$animation_cubic_value = $this->df_get_cubic_bezier_value( $df_popup_close_animation_time_function );
					$custom_style         .= '
					#popup_' . $post->ID . '.' . $df_popup_animation_type . '.close .df_popup_inner_container{
						animation: ' . $df_popup_close_animation_type . '_rev ' . $df_popup_close_animation_duration . 'ms;
						animation-timing-function: ' . $animation_cubic_value . ';
					}
					';
				}

				if ( $make_clickable_outside_popup_area && false === $df_popup_close_on_overlay_click ) {
					$custom_style .= '
					#popup_' . $post->ID . '.active{
						pointer-events:none;
					}

					#popup_' . $post->ID . '.active .df_popup_wrapper .et_pb_section,
					#popup_' . $post->ID . '.active .popup-close{
						pointer-events:auto;
					}
					';
				}

				$df_popup_content_scroll = isset( $post_settings->df_popup_content_scroll ) ? $post_settings->df_popup_content_scroll : false;

				if ( $df_popup_content_scroll ) {
					$custom_style .= '
					#df-popup-container-' . $post->ID . ' #popup_' . $post->ID . ':not(.close) {
						overflow-y: scroll;
					}
					';
				}
				if ( $close_btn_design_active ) {
					$padding_css   = '';
					$border_css    = '';
					$border_radius = '';

					// padding.
					if ( is_object( $close_btn_padding ) ) {
						foreach ( $close_btn_padding as $name => $value ) {

							$padding_css .= 'padding-' . $name . ':' . $value . ' !important;';
						}
					}

					// Margin
					$__position__popup_close_button = ($close_btn_move_inner_content
						? ($post_settings->df_popup_close_position_type_for_inside ? $post_settings->df_popup_close_position_type_for_inside : 'top_right')
						: ($post_settings->df_popup_close_position_type ? $post_settings->df_popup_close_position_type : 'top_right')
					);
					if (is_object($close_btn_margin) && in_array($__position__popup_close_button, ['top_right', 'top_right_cornar', 'center_right'])) {
						foreach ($close_btn_margin as $name => $value) {
							if ('right' === $name) {
								$padding_css .= 'margin-' . $name . ':0px !important;';
								$padding_css .= 'margin-left:-' . $value . ' !important;';
							} elseif ('left' === $name) {
								continue;
							} else {
								$padding_css .= 'margin-' . $name . ':' . $value . ' !important;';
							}
						}
					} elseif (is_object($close_btn_margin) && in_array($__position__popup_close_button, ['bottom_left', 'bottom_center'])) {
						foreach ($close_btn_margin as $name => $value) {
							if ('bottom' === $name) {
								$padding_css .= 'margin-' . $name . ':0px !important;';
								$padding_css .= 'margin-top:-' . $value . ' !important;';
							} elseif ('top' === $name) {
								continue;
							} else {
								$padding_css .= 'margin-' . $name . ':' . $value . ' !important;';
							}
						}
					} elseif (is_object($close_btn_margin) && 'bottom_right' === $__position__popup_close_button) {
						foreach ($close_btn_margin as $name => $value) {
							if ('bottom' === $name) {
								$padding_css .= 'margin-' . $name . ':0px !important;';
								$padding_css .= 'margin-top:-' . $value . ' !important;';
							} elseif ('right' === $name) {
								$padding_css .= 'margin-' . $name . ':0px !important;';
								$padding_css .= 'margin-left:-' . $value . ' !important;';
							}
						}
					} elseif (is_object($close_btn_margin)) {
						foreach ($close_btn_margin as $name => $value) {
							$padding_css .= 'margin-' . $name . ':' . $value . ' !important;';
						}
					}

					// border.

					if ( is_object( $close_btn_border ) ) {
						foreach ( $close_btn_border as $name => $value ) {
							$border_css .= 'border-' . $name . '-width:' . $value . ' !important;';
						}
					}

					// border radius.
					if ( is_object( $close_btn_border_radius ) ) {
						foreach ( $close_btn_border_radius as $value ) {
							$border_radius .= ' ' . $value;
						}
					}

					$popup_close_position = $close_btn_move_inner_content ? 'absolute' : 'fixed';

					$custom_style .= '.popup-close-button-' . $post->ID . ' {
							position: ' . $popup_close_position . ' !important;
							color:' . $close_btn_color . ' !important;
							font-size:' . $close_btn_font_size . 'px !important;
							line-height:' . $close_btn_line_height . 'px !important;
							background-color:' . $close_btn_background . ' !important;
							border-style: solid !important;
							' . $padding_css . '
							' . $border_css . '
							border-radius: ' . $border_radius . ' !important;
							border-color: ' . $close_btn_border_color . ' !important;
						}';

					$custom_style .= '.popup-close-button-' . $post->ID . ' span.df_popup_custom_btn {
							font-weight:' . $close_btn_font_weight . ' !important;
						}';
				}
				$df_popup_close_button_position            = ( false === $close_btn_move_inner_content ) && isset( $post_settings->df_popup_close_position_type ) ? $post_settings->df_popup_close_position_type : 'top_right';
				$df_popup_close_button_position_for_inside = ( true === $close_btn_move_inner_content ) && isset( $post_settings->df_popup_close_position_type_for_inside ) ? $post_settings->df_popup_close_position_type_for_inside : 'top_right';
				$popup_close_button_position               = true === $close_btn_move_inner_content ?
					$trans_values[ $df_popup_close_button_position_for_inside ] :
					$trans_values[ $df_popup_close_button_position ];

				$custom_style .= '.popup-close-button-' . $post->ID . '{
						' . $popup_close_button_position . '
					}';
				// Custom CSS Field Data.

				// if($df_popup_enable_custom_css){
				// $custom_style.="\n";
				// $custom_style .=  $df_popup_custom_css;
				// }.

				if ( $custom_style ) {
					$handle = 'df-popup-css-' . $post->ID;
					wp_register_style( $handle, false );
					wp_enqueue_style( $handle );
					wp_add_inline_style( $handle, $custom_style );
				}
			}
		}
	}

	/**
	 * Get popup trigger type
	 *
	 * @param string $condition load/click.
	 */
	private function df_popup_get_trigger_click( $condition ) {
		$args = array(
			'post_type'      => self::POST_TYPE,
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'     => '_df_popup_item_trigger_type',
					'value'   => 'click',
					'compare' => $condition,
				),
				array(
					'key'     => '_df_popup_item_status',
					'value'   => '1',
					'compare' => '=',
				),
			),
		);
		if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
			$args['suppress_filters'] = false;
			$args['lang'] = apply_filters( 'wpml_current_language', null );
		}

		return get_posts($args);
	}

	/**
	 * Get popup all posts
	 *
	 * @return array post data
	 */
	private function df_popup_get_posts() {
		$args = array(
			'post_type'      => self::POST_TYPE,
			'posts_per_page' => -1,
			'meta_key'       => '_df_popup_item_status',
			'meta_value'     => '1',
			'meta_compare'   => '=',
		);
		if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
			$args['suppress_filters'] = false;
			$args['lang'] = apply_filters( 'wpml_current_language', null );
		}

		return get_posts($args);
	}

	/**
	 * Get post ids
	 *
	 * @param string $post_type Post Type.
	 * @return array post ids
	 */
	private function df_get_post_ids( $post_type = 'post' ) {
		$post_ids = array();
		$args = array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		);
		if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
			$args['suppress_filters'] = false;
			$args['lang'] = apply_filters( 'wpml_current_language', null );
		}

		$posts    = get_posts($args);

		foreach ( $posts as $post ) {
			$post_ids[] = $post->ID;
		}

		return $post_ids;
	}

	/**
	 * Get post ids from taxonomy
	 *
	 * @param string $taxonomy Taxonomy name.
	 * @param string $post_type Post Type name.
	 * @return array post ids
	 */
	private function df_get_post_ids_from_taxonomy( $taxonomy = 'category', $post_type = 'post' ) {
		$post_ids = array();
		$args = array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'tax_query'      => array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'operator' => 'IN',
					'terms' => get_terms( [ 'taxonomy' => $taxonomy, 'fields' => 'ids' ] ),
				),
			),
		);
		if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
			$args['suppress_filters'] = false;
			$args['lang'] = apply_filters( 'wpml_current_language', null );
		}

		$posts    = get_posts($args);

		foreach ( $posts as $post ) {
			$post_ids[] = $post->ID;
		}

		return $post_ids;
	}

	/**
	 * Remove Metabox (Divi Page Settings)
	 *
	 *  @param int   $post_id Post ID.
	 *  @param mixed $post Post Data.
	 *  @return void
	 */
	public function save_et_meta( $post_id, $post ) {
		update_post_meta( $post_id, '_et_pb_page_layout', 'et_no_sidebar' ); // make force page layout change to no-sidebar.
	}

	/**
	 * Remove Metabox (Page Layout) Options
	 *
	 * @return void
	 */
	public function handle_metabox() {
        //phpcs:disable -- utilizes GET for handle specific metabox
		global $pagenow;
		$pages = array( 'post.php', 'post-new.php' );

		if ( ! in_array( $pagenow, $pages, true ) ) {
			return;
		}

		$post_type = array_key_exists( 'post_type', $_GET ) ? $_GET['post_type'] : '';

		if ( 'post-new.php' === $pagenow && self::POST_TYPE !== $post_type ) {
			return;
		}

		$post_type = array_key_exists( 'post', $_GET ) ? get_post( $_GET['post'] )->post_type : '';

		if ( isset( $_GET['post'] ) && self::POST_TYPE !== $post_type ) {
			return;
		}

		remove_action( 'add_meta_boxes', 'et_add_post_meta_box' );
        //phpcs:enable
	}

	/**
	 * Disable custom fields.
	 *
	 * @return void
	 */
	public function df_disable_popup_custom_fields() {
		remove_meta_box( 'postcustom', self::POST_TYPE, 'normal' );
	}

	/**
	 * Transition Effect for cubic set.
	 *
	 * @param string $option type of transition.
	 * @return string
	 */
	public function df_get_cubic_bezier_value( $option ) {
		switch ( $option ) {
			case 'linear':
				return 'cubic-bezier(0, 0, 1, 1)';
			case 'ease':
				return 'cubic-bezier(0.25, 0.1, 0.25, 1)';
			case 'ease-in':
				return 'cubic-bezier(0.42, 0, 1, 1)';
			case 'ease-out':
				return 'cubic-bezier(0, 0, 0.58, 1)';
			case 'ease-in-out':
				return 'cubic-bezier(0.42, 0, 0.58, 1)';
			case 'easeInQuad':
				return 'cubic-bezier(0.55, 0.085, 0.68, 0.53)';
			case 'easeInCubic':
				return 'cubic-bezier(0.55, 0.055, 0.675, 0.19)';
			case 'easeInQuart':
				return 'cubic-bezier(0.895, 0.03, 0.685, 0.22)';
			case 'easeInQuint':
				return 'cubic-bezier(0.755, 0.05, 0.855, 0.06)';
			case 'easeInSine':
				return 'cubic-bezier(0.47, 0, 0.745, 0.715)';
			case 'easeInExpo':
				return 'cubic-bezier(0.95, 0.05, 0.795, 0.035)';
			case 'easeInCirc':
				return 'cubic-bezier(0.6, 0.04, 0.98, 0.335)';
			case 'easeInBack':
				return 'cubic-bezier(0.6, -0.28, 0.735, 0.045)';
			case 'easeInBounce':
				return 'cubic-bezier(0.68, -0.55, 0.27, 1.55)';
			case 'easeInOutQuad':
				return 'cubic-bezier(0.455, 0.03, 0.515, 0.955)';
			case 'easeInOutCubic':
				return 'cubic-bezier(0.645, 0.045, 0.355, 1)';
			case 'easeInOutQuart':
				return 'cubic-bezier(0.77, 0, 0.175, 1)';
			case 'easeInOutSine':
				return 'cubic-bezier(0.445, 0.05, 0.55, 0.95)';
			case 'easeInOutExpo':
				return 'cubic-bezier(1, 0, 0, 1)';
			case 'easeInOutCirc':
				return 'cubic-bezier(0.785, 0.135, 0.15, 0.86)';
			case 'easeInOutBounce':
				return 'cubic-bezier(0.68, -0.55, 0.27, 1.55)';
			case 'easeInOutBack':
				return 'cubic-bezier(0.68, -0.55, 0.27, 1.55)';
			case 'easeOutQuad':
				return 'cubic-bezier(0.25, 0.46, 0.45, 0.94)';
			case 'easeOutCubic':
				return 'cubic-bezier(0.215, 0.61, 0.355, 1)';
			case 'easeOutQuart':
				return 'cubic-bezier(0.165, 0.84, 0.44, 1)';
			case 'easeOutExpo':
				return 'cubic-bezier(0.19, 1, 0.22, 1)';
			case 'easeOutCirc':
				return 'cubic-bezier(0.075, 0.82, 0.165, 1)';
			case 'easeOutBack':
				return 'cubic-bezier(0.175, 0.885, 0.32, 1.275)';
			case 'easeOutQuint':
				return 'cubic-bezier(0.23, 1, 0.32, 1)';
			case 'easeOutBounce':
				return 'cubic-bezier(0.68, -0.55, 0.27, 1.55)';
			default:
				return '';
		}
	}

	/**
	 * Disable post type options
	 *
	 * @param string $blacklist post type.
	 * @return array
	 */
	public function blacklist_post_type( $blacklist ) {
		$blacklist[] = self::POST_TYPE;

		return $blacklist;
	}

	public function clear_static_file() {
		if ( class_exists( 'ET_Core_PageResource' ) ) {
			$post_id = 'all';
			$owner   = 'all';
			\ET_Core_PageResource::remove_static_resources( $post_id, $owner );
		}
	}
}

new DF_Popup_Process();
