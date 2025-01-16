<?php

class DF_License {
	const KEY = 'df_license_key';

	const STATUS_KEY = 'df_license_status';
	const STORE_URL = 'https://diviflash.com';
	const FALLBACK_URL = 'https://diviflash.echoacloud.com/api/proxy';

	const ITEM_ID = 94;

	const ITEM_NAME = 'Divi Flash';

	public function __construct() {
		$this->load_updater();
		$this->register_hook();
	}

	protected function load_updater() {
		if ( ! class_exists( 'DF_SL_Plugin_Updater' ) ) {
			include( dirname( __FILE__ ) . '/DF_SL_Plugin_Updater.php' );
		}
	}

	protected function register_hook() {
		add_filter( 'difl_dashboard_local_vars', [ $this, 'dashboard_local_vars' ] );
		add_action( 'admin_init', [ $this, 'plugin_updater' ], 0 );
		add_action( 'wp_ajax_difl_license_activate', [ $this, 'activate_license' ] );
		add_action( 'wp_ajax_difl_license_deactivate', [ $this, 'deactivate_license' ] );
		add_action( 'wp_ajax_difl_license_handle_fallback', [ $this, 'handle_fallback' ] );
	}

	public function plugin_updater() {
		$license_key = trim( get_option( self::KEY ) );

		new DF_SL_Plugin_Updater( self::STORE_URL, DIFL_MAIN_FILE_PATH,
			[
				'version' => DIFL_VERSION,
				'license' => $license_key,
				'item_id' => self::ITEM_ID,
				'author'  => 'DiviFlash',
				'beta'    => false,
			]
		);

	}

	public function deactivate_license() {
		$payload = \DIFL\Dashboard::get_paylod_data();

		if ( empty( $payload ) ) {
			wp_send_json( [ 'success' => false, 'message' => __( 'Nonce verification failed', 'divi_flash' ) ] );
		}

		$api_params = $this->get_api_params( 'deactivate_license' );

		$response = wp_remote_post( self::STORE_URL, [
			'timeout'   => 15,
			'sslverify' => false,
			'body'      => $api_params
		] );

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.' );
			}

			wp_send_json( [
				'success'         => false,
				'message'         => $message,
				'use_fallback'    => true,
				'fallback_params' => array_merge( $this->get_api_params( 'deactivate_license' ), [
					'fallback_url' => self::FALLBACK_URL,
					'item_id'      => self::ITEM_ID
				] )
			] );

		}

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		$statuses     = [ 'deactivated', 'failed' ];

		if ( in_array( $license_data->license, $statuses ) ) {
			delete_option( self::KEY );
		}

		wp_send_json( [ 'success' => true, 'message' => __( 'License deactivated successfully', 'divi_flash' ) ] );
	}

	public function activate_license() {
		$settings = \DIFL\Dashboard::get_paylod_data( 'settings' );

		if ( empty( $settings ) ) {
			wp_send_json( [ 'success' => false, 'message' => __( 'Nonce verification failed', 'divi_flash' ) ] );
		}

		if ( empty( $settings->key ) ) {
			wp_send_json( [ 'success' => false, 'message' => __( 'Please enter valid license', 'divi_flash' ) ] );
		}

		$api_params = $this->get_api_params();

		if ( empty( $api_params['license'] ) ) {
			$api_params['license'] = $settings->key;
		}

		$response = wp_remote_post( self::STORE_URL, [
			'timeout'   => 15,
			'sslverify' => false,
			'body'      => $api_params
		] );

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.', 'divi_flash' );
			}

			wp_send_json( [
				'success'         => false,
				'message'         => $message,
				'use_fallback'    => true,
				'fallback_params' => array_merge( $this->get_api_params(), [
                    'fallback_url' => self::FALLBACK_URL,
                    'item_id'      => self::ITEM_ID,
                    'license'      => $settings->key,
				] )
			] );
		}

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		$success      = $license_data->success;

		if ( empty( $success ) ) {
			$statuses = [
				'expired'             => sprintf(
					__( 'Your license key expired on %s.', 'divi_flash' ),
					date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
				),
				'disabled'            => __( 'Your license key has been disabled.', 'divi_flash' ),
				'revoked'             => __( 'Your license key has been disabled.', 'divi_flash' ),
				'missing'             => __( 'Invalid license.', 'divi_flash' ),
				'invalid'             => __( 'Your license is not active for this URL.', 'divi_flash' ),
				'site_inactive'       => __( 'Your license is not active for this URL.', 'divi_flash' ),
				'item_name_mismatch'  => sprintf( __( 'This appears to be an invalid license key for %s.', 'divi_flash' ), self::ITEM_NAME, ),
				'no_activations_left' => __( 'Your license key has reached its activation limit.', 'divi_flash' ),
			];

			if ( $license_data->error ) {
				$message = $statuses[ $license_data->error ];
				$message = empty( $message ) ? __( 'An error occurred, please try again.' ) : $message;
			}
		}

		if ( ! empty( $message ) ) {
			wp_send_json( [ 'success' => false, 'message' => $message ] );
		}

		update_option( self::STATUS_KEY, $license_data->license );
		update_option( self::KEY, $settings->key );
		wp_send_json( [ 'success' => true, 'message' => $license_data->license ] );
	}

	protected function get_api_params( $action = '' ) {
		$license = trim( get_option( self::KEY ) );

		return [
			'edd_action' => ! empty( $action ) ? $action : 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( self::ITEM_NAME ),
			'url'        => home_url()
		];
	}

	public function handle_fallback() {
		$settings = \DIFL\Dashboard::get_paylod_data( 'settings' );
		$action   = $settings->edd_action;
		if ( 'activate_license' === $action ) {
			update_option( self::STATUS_KEY, $settings->status );
			update_option( self::KEY, $settings->license );
		}

		if ( 'deactivate_license' === $action ) {
			delete_option( self::KEY );
		}
	}

	public function dashboard_local_vars( $vars ) {
		$vars['license'] = get_option( self::KEY );

		return $vars;
	}
}

new DF_License();
