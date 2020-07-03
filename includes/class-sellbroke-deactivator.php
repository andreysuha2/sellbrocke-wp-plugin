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
	public static function deactivate() {
	}

	public static function uninstall() {
        global $wpdb;

        $wpdb->query( "DROP TABLE IF EXISTS `" . SELLBROKE_TOKENS_TABLE_NAME . "`" );
    }

}
