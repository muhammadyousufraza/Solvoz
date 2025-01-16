<?php

namespace DIFL;

class RemoteData {
	const URL = 'https://raw.githubusercontent.com/sayedkouser/diviflash-promotion/main/';
	const FILES = [
		'changelog'  => [ 'name' => 'changelog.json', 'expire' => MONTH_IN_SECONDS ],
		'layouts'    => [ 'name' => 'layouts.json', 'expire' => DAY_IN_SECONDS ],
		'promotions' => [ 'name' => 'promotions.json', 'expire' => DAY_IN_SECONDS ],
	];

	const CACHE_KEY = 'difl';

	const SLUG = 'diviflash';

	public function __construct() {
		add_action( 'set_site_transient_update_plugins', [ $this, 'handle_cache' ], 20, 3 ); //phpcs:ignore ET.Sniffs.NoCustomUpdater.NoUpdater -- As we provide layout from external source and new layout is added continuously this is the best approach for client and performance also.
	}

	public static function get_file_content( $key, $use_cache = true ) {
		if ( ! in_array( $key . '.json', array_column( self::FILES, 'name' ) ) ) {
			return false;
		}

		$file_name = self::FILES[ $key ]['name'];
		$cache_key = self::CACHE_KEY . '_' . $file_name;
		$data      = get_transient( $cache_key );

		if ( ! empty( $data ) && $use_cache ) {
			return $data;
		}

		$url = self::URL . $file_name;

		$response = wp_remote_get( $url, [
			'timeout'   => 600,
			'sslverify' => false
		] );

		if ( is_wp_error( $response ) ) {
			return [
				'success'      => false,
				'errorMessage' => 'Faild to download file',
				'res'          => $response
			];
		}

		$body = $response['body'];

		if ( self::is_json( $body ) ) {
			$value = json_decode( $body, true );
			set_transient( $cache_key, $value, self::get_expiration( $key ) );

			return $value;
		}

		return $body;
	}

	private static function is_json( $string ) {
		json_decode( $string );

		return json_last_error() === JSON_ERROR_NONE;
	}

	public function handle_cache() {
		$result = get_site_transient( 'update_plugins' );
		if ( ! is_object( $result ) ) {
			return;
		}

		$result = property_exists( $result, 'response' ) ? $result->response : false;

		if ( empty( $result ) || ! is_array( $result ) ) {
			return;
		}

		$plugin = plugin_basename( plugin_dir_path( __DIR__ ) . 'diviflash.php' );

		if ( ! array_key_exists( $plugin, $result ) ) {
			return;
		}
		self::update_cache();
	}

	public static function update_cache() {
		foreach ( self::FILES as $key => $file ) {
			self::get_file_content( $key, false );
		}
	}

	public static function get_expiration( $key ) {
		if ( 'https://www.diviflash.com' !== get_plugin_data( DIFL_MAIN_DIR . '/diviflash.php' )['UpdateURI'] ) {
			return DAY_IN_SECONDS;
		}

		return self::FILES[ $key ]['expire'];
	}
}

new RemoteData();
