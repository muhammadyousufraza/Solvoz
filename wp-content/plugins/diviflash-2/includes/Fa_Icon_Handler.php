<?php
namespace DIFL;

trait Fa_Icon_Handler {
	public static $fa_icon_loaded = false;

	public function get_icon_controls() {
		return array_filter( $this->get_fields(), function ( $field ) {
			return 'select_icon' === $field['type'];
		} );
	}

	public function handle_fa_icon() {
		$icons_field = $this->get_icon_controls();
		if ( empty( $icons_field ) ) {
			return;
		}

		foreach ( $icons_field as $key => $icon_field ) {
			$font_icon = $this->props[ $key ];

			if ( self::$fa_icon_loaded ) {
				return;
			}

			add_filter( 'et_late_global_assets_list', function ( $assets, $assets_args, $et_dynamic_assets ) use ( $font_icon ) {
				if ( isset( $assets['et_icons_fa'] ) || self::$fa_icon_loaded ) {
					return $assets;
				}

				if ( strpos( $font_icon, '||fa||' ) !== false ) {
					$assets_prefix         = et_get_dynamic_assets_path();
					$assets['et_icons_fa'] = [
						'css' => "{$assets_prefix}/css/icons_fa_all.css",
					];
					self::$fa_icon_loaded  = true;
				}

				return $assets;
			}, 100, 3 );
		}
	}
}