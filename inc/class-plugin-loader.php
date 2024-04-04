<?php
/**
 * Plugin Loader
 *
 * @since 1.0
 * @package ChoctawNation
 * @subpackage HeaderAlert
 */

namespace ChoctawNation\HeaderAlert;

/** Inits the Plugin */
class Plugin_Loader {

	/** Constructor */
	public function __construct() {
		$this->require_files();
		add_action( 'init', array( $this, 'init_header_alert' ) );
	}

	/** Loads the ACF APIs */
	private function require_files() {
		$path = plugin_dir_path( __DIR__ ) . 'inc/';

		$acf_files = array(
			'options-page',
			'options-page-fields',
		);
		foreach ( $acf_files as $file ) {
			require_once $path . 'acf/fields/' . $file . '.php';
		}

		require_once $path . 'class-header-alert.php';
	}

	/**
	 * Initializes the Header Alert
	 */
	public function init_header_alert() {
		new Header_Alert();
	}
}
