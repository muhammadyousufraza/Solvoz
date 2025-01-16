<?php
function showPopup($overlay_id = NULL)
{

	ob_start();

	if (!is_numeric($overlay_id))
		return NULL;

	$overlay_id = (int) $overlay_id;

	$post_data = get_post($overlay_id);

	$single_popup_settings = get_post_meta($overlay_id, '_df_popup_item_settings', true);
	$post_settings = json_decode($single_popup_settings);
	$schedule_type  = isset($post_settings->df_popup_schedule_type) ? $post_settings->df_popup_schedule_type : '';
	$recuring_schedule_day  = isset($post_settings->df_popup_recuring_schedule_day) ? $post_settings->df_popup_recuring_schedule_day : '';
	$schedule_start_date = isset($post_settings->df_popup_schedule_start_date) ? $post_settings->df_popup_schedule_start_date  : '';
	$schedule_end_date = isset($post_settings->df_popup_schedule_end_date) ? $post_settings->df_popup_schedule_end_date  : '';
	$remove_close_link = isset($post_settings->df_popup_remove_link) ? $post_settings->df_popup_remove_link : false;
	$prevent_scroll = isset($post_settings->df_popup_prevent_scroll) ? $post_settings->df_popup_prevent_scroll : false;

	/* Scheduling */
	$enable_scheduling = $schedule_type === 'always' ? false : true;

	if ($enable_scheduling) {
		$timezone = new DateTimeZone(wp_timezone_string());
		$date_now = new DateTime('now', $timezone);

		// Start & End Time
		if ($schedule_type === 'date_and_time') {
			$date_start = $schedule_start_date;
			$date_end = $schedule_end_date;

			//$date_start = doConvertDateToUserTimezone( $date_start );
			$date_start = new DateTime($date_start, $timezone);

			if ($date_start >= $date_now) {
				return;
			}

			if ($date_end != '') {
				//$date_end = doConvertDateToUserTimezone( $date_end );
				$date_end = new DateTime($date_end, $timezone);

				if ($date_end <= $date_now) {
					return;
				}
			}
		}


		// Recurring Scheduling
		if ($schedule_type == 'recurring') {
			$daysToShowPopup = $recuring_schedule_day;
			$currentDayOfWeek = gmdate('l');

			// Check if the current day is in the array of days to show the popup
			if (!in_array(strtolower($currentDayOfWeek), array_values($daysToShowPopup))) {
				return;
			}
		}
	}
	/* End Scheduling */

	if (isset($prevent_scroll)) {
		$prevent_scroll = $prevent_scroll;
	} else {
		$prevent_scroll = 0;
	}

	// Close Icon enable disable
	if (isset($remove_close_link)) {
		$hideclosebtn = $remove_close_link;
	} else {
		$hideclosebtn = false;
	}

	$output = df_render_library_layout_for_popup($post_data);
	
?>
	<div id="df-popup-container-<?php echo esc_attr( $overlay_id ); ?>" class="popup-container">
		<div id="popup_<?php echo esc_attr( $post_data->ID ); ?>" class="overlay" data-settings='<?php echo esc_attr( $single_popup_settings ) ?>' data-preventscroll="<?php echo esc_attr( $prevent_scroll ) ?>">
		<?php if ( $hideclosebtn == false ) { ?>
			<a href="javascript:;" class="popup-close popup-close-button-<?php echo esc_attr( $overlay_id ) ?>">
				<span class="df_popup_custom_btn">&times;</span>

			</a>
        <?php } ?>	
			<div class="df_popup_inner_container" id="df_popup_inner_containner_<?php echo esc_attr( $post_data->ID ); ?>">
				<div class="df_popup_wrapper">
					<?php 
					if ('on' === get_post_meta($post_data->ID, '_et_pb_use_builder', true)) {
						echo et_core_esc_previously( $output );
					} else {
					?>
						<div class="et_section_regular custom_section">
							<div class="et_pb_row custom_row">
								<div class="et_pb_column custom_column">
									<?php 
									echo et_core_esc_previously( $output );
									?>
								</div>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>

		</div>
	</div>
<?php

	return ob_get_clean();
}