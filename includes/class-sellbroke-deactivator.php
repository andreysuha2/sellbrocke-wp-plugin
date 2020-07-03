<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Sellbroke
 * @subpackage Sellbroke/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Sellbroke
 * @subpackage Sellbroke/includes
 * @author     Your Name <email@example.com>
 */
class Sellbroke_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate($table_name) {
		global $wpdb;

		$table_name = "{$wpdb->prefix}{$table_name}";
		// if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();
	    $wpdb->query( "DROP TABLE `{$table_name}`" );
	}

}
