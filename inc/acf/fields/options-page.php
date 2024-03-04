<?php
/**
 * The Options Page
 *
 * @package ChoctawNation
 * @subpackage HeaderAlert
 */

add_action(
	'acf/init',
	function () {
		acf_add_options_page(
			array(
				'page_title'  => 'Alert Bar',
				'menu_slug'   => 'alert-bar',
				'icon_url'    => 'dashicons-warning',
				'menu_title'  => 'Alert Bar',
				'description' => 'Powers a banner above the header to display alerts',
				'position'    => '',
				'redirect'    => false,
				'autoload'    => true,
			)
		);
	}
);