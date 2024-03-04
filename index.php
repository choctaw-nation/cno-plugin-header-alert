<?php
/**
 * Plugin Name: Choctaw Header Alert Plugin
 * Description: Choctaw Header Alert plugin allows users to add a banner to the top of a page and customize its colors and text via ACF fields.
 * Plugin URI: https://github.com/choctaw-nation/cno-plugin-header-alert
 * Version: 0.1.0
 * Author: Choctaw Nation of Oklahoma
 * Author URI: https://www.choctawnation.com
 * Text Domain: cno
 * License: GPLv3 or later
 *
 * @package ChoctawNation
 * @subpackage HeaderAlert
 */

use ChoctawNation\HeaderAlert\Plugin_Loader;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

require_once __DIR__ . '/inc/class-plugin-loader.php';
$plugin_loader = new Plugin_Loader();
