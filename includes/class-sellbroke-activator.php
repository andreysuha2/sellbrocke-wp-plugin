<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Sellbroke
 * @subpackage Sellbroke/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Sellbroke
 * @subpackage Sellbroke/includes
 */
class Sellbroke_Activator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE `" . SELLBROKE_TOKENS_TABLE_NAME . "` (
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`access_token` text NOT NULL,
			`refresh_token` text NOT NULL,
			`expired_at` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			`created_at` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			PRIMARY KEY  (id)
		) {$charset_collate};";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}
