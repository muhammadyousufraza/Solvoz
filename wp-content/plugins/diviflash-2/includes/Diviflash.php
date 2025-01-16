<?php

class DIFL_Diviflash extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'difl-diviflash';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'diviflash';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = DIFL_VERSION;

	/**
	 * DIFL_Diviflash constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'diviflash', $args = array() ) {		
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}
}

new DIFL_Diviflash;
