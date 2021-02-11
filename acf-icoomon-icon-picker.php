<?php

/*
Plugin Name: ACF: Icomoon Icon Picker
Plugin URI: https://github.com/plovinicius/acf-icomoon-icon-picker
Description: ACF addon with a Icon Picker from icomoon.json file
Version: 1.0.0
Author: Paulo Vinicius
Author URI: https://github.com/plovinicius
License: MIT
License URI: https://opensource.org/licenses/MIT
*/

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

// verify if advanced custom field plugin is installed and active
// register_activation_hook( __FILE__, 'kndky_icomoon_picker_plugin_activate' );

function kndky_icomoon_picker_plugin_activate() {
	if ( ! is_plugin_active( 'advanced-custom-fields/acf.php' ) and current_user_can( 'activate_plugins' ) && is_admin() ) {
		add_action( 'admin_notices', 'kndky_icomoon_picker_notices' );

		deactivate_plugins( plugin_basename( __FILE__ ) );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		// Stop activation redirect and show error
		// wp_die('Sorry, but this plugin requires the Advanced Custom Fields to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
		}
}

add_action('admin_init', 'kndky_icomoon_picker_plugin_activate');

function kndky_icomoon_picker_notices() {
	echo '<div class="error"><p>Sorry, but ACF: Icomoon Icon Picker Plugin requires the Advanced Custom Fields plugin to be installed and active.</p></div>';
}


// check if class already exists
if( !class_exists('kndky_acf_plugin_icomoon_picker') ) :

class kndky_acf_plugin_icomoon_picker {

	// vars
	var $settings;


	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @type	function
	*  @since	1.0.0
	*
	*  @param	void
	*  @return	void
	*/

	function __construct() {

		// settings
		// - these will be passed into the field class.
		$this->settings = array(
			'version'	=> '1.0.0',
			'url'		=> plugin_dir_url( __FILE__ ),
			'path'		=> plugin_dir_path( __FILE__ )
		);


		// include field
		add_action('acf/include_field_types', 	array($this, 'include_field')); // v5
		add_action('acf/register_fields', 		array($this, 'include_field')); // v4
	}


	/*
	*  include_field
	*
	*  This function will include the field type class
	*
	*  @type	function
	*  @since	1.0.0
	*
	*  @param	$version (int) major ACF version. Defaults to false
	*  @return	void
	*/

	function include_field( $version = false ) {

		// support empty $version
		if( !$version ) $version = 5;


		// load textdomain
		load_plugin_textdomain( 'TEXTDOMAIN', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' );


		// include
		include_once('fields/class-kndky-acf-field-icomoon-picker-v' . $version . '.php');
	}

}


// initialize
new kndky_acf_plugin_icomoon_picker();


// class_exists check
endif;

?>