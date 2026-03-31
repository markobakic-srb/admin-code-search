<?php
/**
 * Plugin Name: Admin Code Search
 * Plugin URI: https://wordpress.org/plugins/admin-code-search/
 * Description: Search code inside active themes and plugins directly from the WordPress admin area.
 * Version: 1.2.0
 * Author: Marko Bakic
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: admin-code-search
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ADCOSE_VERSION', '1.2.0' );
define( 'ADCOSE_FILE', __FILE__ );
define( 'ADCOSE_PATH', plugin_dir_path( __FILE__ ) );
define( 'ADCOSE_URL', plugin_dir_url( __FILE__ ) );
define( 'ADCOSE_BASENAME', plugin_basename( __FILE__ ) );

require_once ADCOSE_PATH . 'includes/class-adcose-helpers.php';
require_once ADCOSE_PATH . 'includes/class-adcose-scanner.php';
require_once ADCOSE_PATH . 'includes/class-adcose-admin-page.php';
require_once ADCOSE_PATH . 'includes/class-adcose-plugin.php';

function adcose_run_plugin() {
	$plugin = new ADCOSE_Plugin();
	$plugin->init();
}
adcose_run_plugin();