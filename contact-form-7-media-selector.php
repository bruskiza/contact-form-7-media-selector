<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              github.com/bruskiza
 * @since             0.0.1
 * @package           Contact_Form_7_Media_Selector
 *
 * @wordpress-plugin
 * Plugin Name:       Contact Form 7 Media Selector
 * Plugin URI:        github.com/bruskiza/content-form-7-media-selector
 * Description:       Allows selecting of media for attaching and mailing in Contact Form 7.
 * Version:           0.0.1
 * Author:            Bruce McIntyre
 * Author URI:        github.com/bruskiza
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       contact-form-7-media-selector
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
define( 'PLUGIN_NAME_VERSION', '0.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-contact-form-7-media-selector-activator.php
 */
function activate_contact_form_7_media_selector() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-contact-form-7-media-selector-activator.php';
	if ( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) and current_user_can( 'activate_plugins' ) ) {
		// Stop activation redirect and show error
		wp_die('Sorry, but this plugin requires the <a href="https://wordpress.org/plugins/contact-form-7/">Contact Form 7</a> Plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
	}
	if ( ! is_plugin_active( 'contact-form-7-shortcode-enabler/contact-form-7-shortcode-enabler.php' ) and current_user_can( 'activate_plugins' ) ) {
		// Stop activation redirect and show error
		wp_die('Sorry, but this plugin requires the <a href="https://wordpress.org/plugins/contact-form-7short-code-enabler/">Contact Form Shortcode enabler</a> Plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
	}

	Contact_Form_7_Media_Selector_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-contact-form-7-media-selector-deactivator.php
 */
function deactivate_contact_form_7_media_selector() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-contact-form-7-media-selector-deactivator.php';
	Contact_Form_7_Media_Selector_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_contact_form_7_media_selector' );
register_deactivation_hook( __FILE__, 'deactivate_contact_form_7_media_selector' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-contact-form-7-media-selector.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_contact_form_7_media_selector() {

	$plugin = new Contact_Form_7_Media_Selector();
	$plugin->run();

}
run_contact_form_7_media_selector();
