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


/**
	*
	*
	*/
add_shortcode('media-selector', 'get_emailable_attachments');

function get_emailable_attachments() {
	$query_images_args = array(
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'post_status'    => 'inherit',
    'posts_per_page' => - 1,
	);

	$query_images = new WP_Query( $query_images_args );

	$images = array();
	$counter = 0;
	$msg = "<p><label>Files To Send</label></p><span class='wpcf7-form-control wpcf7-checkbox'>";
	foreach ( $query_images->posts as $image ) {
		$file = get_attached_file( $image->ID );
		$file_size = sprintf("%.2f", filesize($file) / 1024 / 1024) . " MB";
    $msg .= "<input name='cf7-media-selector-{$counter}' type='checkbox' value='{$image->ID}'>{$image->post_title} ({$file_size})</input><br/>\n";
		error_log(print_r($image, true));
		// error_log( print_r("Filename: " . $file, true) );
		// error_log( print_r("File size: " . $file_size, true) );
		$counter += 1;
	}
	$msg .= "</span>";

	return $msg;


}


add_action( 'wpcf7_before_send_mail', 'send_attachment_file' );
function send_attachment_file($cf7) {
	error_log("In here...");
	error_log(print_r($cf7, true));
	if ($cf7->id==872) {
		$uploads = wp_upload_dir();     // will output the array of path,url,subdir,basedir,baseurl,error -- what we need is the path = '/home/euroling/public_html/beta/wp-content/uploads/2013/01'
		//define some constants
		define ('PRICE_UPLOAD_PATH',$uploads['path'].'/price');     // create price folder in the path
	 	if ($cf7->mail['use_html']==true)
	 		$nl="<br/>";
		else
			$nl="\n";
			$pdf_filename = "testnew.pdf";
	 		$cf7->uploaded_files = array( 'file_upload' => PRICE_UPLOAD_PATH .'/'.$pdf_filename );

			//append some text to the outgoing email
	 		$message=$nl.$nl.'Blah blah blah.....'.$nl;
	 		$message.='So Long, and Thanks for All the Fish!'.$nl;
			$cf7->mail_2['body'].=$message;
		}
}
