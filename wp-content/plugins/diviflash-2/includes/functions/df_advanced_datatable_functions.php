<?php
/**
 * Check if TablePress is activated
 *
 * @return bool
 */
function df_is_table_press_activated() {
	return class_exists( 'TablePress' );
}

/**
 * TablePress Tables List
 *
 * @return array
 */
function df_get_table_press_list() {
	$lists = [];
	if ( ! df_is_table_press_activated() ) return $lists;

	$tables = TablePress::$model_table->load_all( true ) ;
	if( $tables ) {
        $lists['select']  = 'Select Table';
		foreach ( $tables as $table ) {
			$table = TablePress::$model_table->load( $table, false, false );
			$lists[$table['id']] = $table['name'];
		}
	}

	return $lists;
}

/**
 * Database Table List
 *
 * @return array
 */
function df_db_tables_list() {
	global $wpdb;

	$tables_list = [];
	$tables = $wpdb->get_results('show tables', ARRAY_N); // phpcs:ignore WordPress.DB.DirectDatabaseQuery

	if ( $tables ) {
		$tables = wp_list_pluck( $tables, 0 );
        $tables_list['select']  = 'Select Table';
		foreach ( $tables as $table ) {
			$tables_list[$table] = $table;
		}
	}

	return $tables_list;
}

/**
 * Database ajax
 *
 * @return json response
 */
add_action('wp_ajax_action_data_from_database', 'df_data_from_database');
function df_data_from_database() {
    global $wpdb;
    $data = json_decode(file_get_contents('php://input'), true);
		
	$table_name = $data["table"];
	$table_data = array();
	$error_message = [];
	if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
		$error_message[] = __( 'Verify Nonce', 'divi_flash' );
		$error_data['error'] = $error_message;
		wp_send_json_success($error_data);
	}
	else if ( empty( $table_name ) ) {
		$error_message[] = __( 'Table shouldn\'t empty', 'divi_flash' );
		$error_data['error'] = $error_message;
		wp_send_json_success($error_data);
	}	
	else if ( $table_name ==='select' ) {
		$error_message[] = __( 'Must select a table', 'divi_flash' );
		$error_data['error'] = $error_message;
		wp_send_json_success($error_data);
	} 
	else{
		// phpcs:disable WordPress.DB.PreparedSQLPlaceholders.UnquotedComplexPlaceholder
		$table_data = $wpdb->get_results( $wpdb->prepare("SELECT * FROM %1s", $table_name), ARRAY_A ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery
		// phpcs:enable WordPress.DB.PreparedSQLPlaceholders.UnquotedComplexPlaceholder
		wp_send_json_success($table_data);
	}	
}

/**
 * Table Press Ajax
 *
 * @return json response
 */

add_action('wp_ajax_action_data_from_tablepress', 'df_data_from_tablepress');
function df_data_from_tablepress() {
	$data = json_decode(file_get_contents('php://input'), true);
	// error handling.
	$error_message = [];
	if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
		$error_message[] = __( 'Verify Nonce', 'divi_flash' );
	}
	else if ( ! df_is_table_press_activated() ) {
		$error_message[] = __( 'Install TablePress', 'divi_flash' );
	}	
	else if ( empty( df_get_table_press_list() ) ) {
		$error_message[] = __( 'Create Table', 'divi_flash' );
	} 
	else if ( empty( $data['table'] ) ) {
		$error_message[] = __( 'Select Table', 'divi_flash' );
	}
	else if ( $data['table'] ==='select' ) {
		$error_message[] = __( 'Must Select a Table', 'divi_flash' );
	}
	$table_data = array();
	if ( ! empty( $error_message ) ) {
		$table_data['error'] = $error_message;
		wp_send_json_success($table_data);
	}else{
		$tables_option = get_option( 'tablepress_tables', '{}' );
		$tables_opt = json_decode( $tables_option, true );
		$tables = $tables_opt['table_post'];
		$table_id = $tables[$data['table']];
		$table_data = get_post_field( 'post_content', $table_id );
		$tables = json_decode( $table_data, true );
		wp_send_json_success($tables);
	}	
}

/**
 * Google Sheet Ajax
 *
 * @return json response
 */
 
add_action('wp_ajax_action_data_from_google_sheet', 'df_data_from_google_sheet');
function df_data_from_google_sheet(){
	$data = json_decode(file_get_contents('php://input'), true);
    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }
	// error handling.
	$error_message = [];
	if ( empty( $data['google_api_key']) ) {
		$error_message[] = __( 'Add API key', 'divi_flash' );
	} elseif ( empty( $data['google_sheet_id'] ) ) {
		$error_message[] = __( 'Add Google Sheets ID', 'divi_flash' );
	} elseif ( empty($data['google_sheet_range'] ) ) {
		$error_message[] = __( 'Add Sheets Range', 'divi_flash' );
	}
	$table_data = array();
	if ( ! empty( $error_message ) ) {
		$table_data['error'] = $error_message;
		wp_send_json_success($table_data);
	}else{
		$sheet_id = esc_html( $data['google_sheet_id'] );
		$range = $data['google_sheet_range'] ? str_replace(':', '%3A', esc_html( trim( $data['google_sheet_range'] ) ) ) : '';
		$api_key = esc_html( $data['google_api_key'] );
		$base_url = 'https://sheets.googleapis.com/v4/spreadsheets/';
		$parameters = '?dateTimeRenderOption=FORMATTED_STRING&majorDimension=ROWS&valueRenderOption=FORMATTED_VALUE&key=';
		$url = $base_url . $sheet_id .'/values/'. $range . $parameters . $api_key;
		
		$transient_key = $data['id'] . '_data_table_cash';
		$table_data = get_transient( $transient_key );
	
		if ( false === $table_data ) {
			$data = wp_remote_get( $url );
			$table_data = json_decode( wp_remote_retrieve_body( $data ), true );
			set_transient( $transient_key, $table_data, 0 );
		}
		if ( $data['google_cache_remove'] === true ) {
			delete_transient( $transient_key );
		}
		wp_send_json_success($table_data);
	}
}
