<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Sellbroke
 *
 * @wordpress-plugin
 * Plugin Name:       Sellbroke
 * Plugin URI:        http://example.com/Sellbroke-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Sellbroke
 * Domain Path:       /languages
 */

global $wpdb;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SELLBROKE_VERSION', '1.0.0' );
define( 'SELLBROKE_TOKENS_TABLE_NAME', "{$wpdb->prefix}sellbroke_tokens" );
define( 'SELLBROKE_API_URL', defined("SELLBROKE_DEV_API_URL") ? SELLBROKE_DEV_API_URL : "http://localhost/");

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sellbroke-activator.php
 */
function activate_sellbroke() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sellbroke-activator.php';
	Sellbroke_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sellbroke-deactivator.php
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-sellbroke-deactivator.php';

function deactivate_sellbroke() {
    Sellbroke_Deactivator::deactivate();
}

function uninstall_sellbroke() {
    Sellbroke_Deactivator::uninstall();
}

register_activation_hook( __FILE__, 'activate_sellbroke' );
register_deactivation_hook( __FILE__, 'deactivate_sellbroke' );
register_uninstall_hook(__FILE__, "uninstall_sellbroke");

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sellbroke.php';

function run_sellbroke() {

	$plugin = new Sellbroke();
	$plugin->run();

}
run_sellbroke();
