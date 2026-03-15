<?php
/**
 * Plugin Name: Admin Code Search
 * Plugin URI: https://wordpress.org/plugins/admin-code-search/
 * Description: Search code inside active themes and plugins directly from the WordPress admin area.
 * Version: 1.0.0
 * Author: Marko Bakic
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: admin-code-search
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ACS_VERSION', '1.0.0' );
define( 'ACS_FILE', __FILE__ );
define( 'ACS_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACS_URL', plugin_dir_url( __FILE__ ) );
define( 'ACS_BASENAME', plugin_basename( __FILE__ ) );

require_once ACS_PATH . 'includes/class-acs-helpers.php';
require_once ACS_PATH . 'includes/class-acs-scanner.php';
require_once ACS_PATH . 'includes/class-acs-admin-page.php';
require_once ACS_PATH . 'includes/class-acs-plugin.php';

function acs_run_plugin() {
	$plugin = new ACS_Plugin();
	$plugin->init();
}
acs_run_plugin();
