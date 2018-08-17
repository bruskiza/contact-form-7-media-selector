<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       github.com/bruskiza
 * @since      1.0.0
 *
 * @package    Contact_Form_7_Media_Selector
 * @subpackage Contact_Form_7_Media_Selector/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Contact_Form_7_Media_Selector
 * @subpackage Contact_Form_7_Media_Selector/includes
 * @author     Bruce McIntyre <bruce.mcintyre@gmail.com>
 */
class Contact_Form_7_Media_Selector_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'contact-form-7-media-selector',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
