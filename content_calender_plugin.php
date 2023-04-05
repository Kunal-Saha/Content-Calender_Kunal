<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://kunal-saha
 * @since             1.0.0
 * @package           Content_calender_plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Content-Calender
 * Plugin URI:        https://Content_Calender_plugin
 * Description:       Content Calendar Plugin 
 * Version:           1.0.0
 * Author:            Kunal Saha
 * Author URI:        https://kunal-saha
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       content_calender_plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CONTENT_CALENDER_PLUGIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-content_calender_plugin-activator.php
 */
function activate_content_calender_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content_calender_plugin-activator.php';
	Content_calender_plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-content_calender_plugin-deactivator.php
 */
function deactivate_content_calender_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content_calender_plugin-deactivator.php';
	Content_calender_plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_content_calender_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_content_calender_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-content_calender_plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function create_event_tables() {
    global $wpdb;

    $table_name = $wpdb->prefix . "events";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name(
        id mediumint(9) AUTO_INCREMENT,
        date date NOT NULL,
        occassion text,
        post_title text NOT NULL,
        author varchar(40) NOT NULL,
        reviewer varchar(40) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

register_activation_hook( __FILE__, 'create_event_tables' );

function run_content_calender_plugin() {

	$plugin = new Content_calender_plugin();
	$plugin->run();

}
run_content_calender_plugin();
