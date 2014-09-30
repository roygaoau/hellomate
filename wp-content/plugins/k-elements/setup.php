<?php

/*
Plugin Name: K Elements
Plugin URL: http://seventhqueen.com/
Description: Wordpress elements using easy to add shortcodes
Version: 2.0.1
Author: SeventhQueen
Author URI: http://seventhqueen.com/
*/

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Define Constants
//   02. Require Files
//   03. Enqueue Assets
// =============================================================================

// Define Constants
// =============================================================================


if ( ! defined( 'K_ELEM_VERSION' ) ) {
	define( 'K_ELEM_VERSION', '2.0.1' );
}

// Plugin Folder Path
if ( ! defined( 'K_ELEM_PLUGIN_DIR' ) ) {
	define( 'K_ELEM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin Folder URL
if ( ! defined( 'K_ELEM_PLUGIN_URL' ) ) {
	define( 'K_ELEM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}			

// Plugin Root File
if ( ! defined( 'K_ELEM_PLUGIN_FILE' ) ) {
	define( 'K_ELEM_PLUGIN_FILE', __FILE__ );
}


// Require Files
// =============================================================================

function k_elements_init() {
    require_once( trailingslashit(K_ELEM_PLUGIN_DIR) . 'functions/helpers.php' );
    require_once( trailingslashit(K_ELEM_PLUGIN_DIR) . 'admin/tiny_mce.php' );
    require_once( trailingslashit(K_ELEM_PLUGIN_DIR) . 'shortcodes/shortcodes.php' );
}

if(function_exists('vc_set_as_theme')) {
	require_once( trailingslashit(K_ELEM_PLUGIN_DIR) . 'compat/plugin-js-composer/config.php' );	//compatibility with Visual composer plugin
}

add_action( 'init', 'k_elements_init' );



// Enqueue Site Scripts
// =============================================================================

function k_elements_enqueue_site_scripts() {

  if ( ! is_admin() ) {

		/* Footer scripts */
		wp_register_script( 'bootstrap', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/bootstrap.min.js', array('jquery'),K_ELEM_VERSION, true );
		wp_register_script( 'waypoints', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/plugins/waypoints.min.js', array('jquery'),K_ELEM_VERSION, true );
		wp_register_script( 'caroufredsel', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/plugins/carouFredSel/jquery.carouFredSel-6.2.0-packed.js', array('jquery'),K_ELEM_VERSION, true );
		wp_register_script( 'jquery-mousewheel', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/plugins/carouFredSel/helper-plugins/jquery.mousewheel.min.js', array('jquery', 'caroufredsel'),K_ELEM_VERSION, true );
		wp_register_script( 'jquery-touchswipe', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/plugins/carouFredSel/helper-plugins/jquery.touchSwipe.min.js', array('jquery', 'caroufredsel'),K_ELEM_VERSION, true );
		wp_register_script( 'isotope', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/plugins/jquery.isotope.min.js', array('jquery'),K_ELEM_VERSION, true );
		wp_register_script( 'kleo-shortcodes', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/shortcodes.min.js', array('jquery'),K_ELEM_VERSION, true );

		//enque them
		wp_enqueue_script('bootstrap');
		wp_enqueue_script('waypoints');
		wp_enqueue_script('caroufredsel');
		wp_enqueue_script('jquery-touchswipe');
		wp_enqueue_script('isotope');
		wp_enqueue_script('kleo-shortcodes');
  }

}

add_action( 'wp_enqueue_scripts', 'k_elements_enqueue_site_scripts' );



// Enqueue Site Styles
// =============================================================================

function k_elements_enqueue_site_styles() {

  if ( ! is_admin() ) {

		// Register the styles
		wp_register_style( 'bootstrap', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/css/bootstrap.min.css', array(), K_ELEM_VERSION, 'all' );  
		wp_register_style( 'kleo-shortcodes', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/css/shortcodes.min.css', array(), K_ELEM_VERSION, 'all' );

		//enque required styles
		wp_enqueue_style( 'bootstrap' );
		wp_enqueue_style( 'kleo-shortcodes' );   

  }
}

add_action( 'wp_enqueue_scripts', 'k_elements_enqueue_site_styles' );


// Auto updater
require_once('wp-updates-plugin.php');
new WPUpdatesPluginUpdater_403( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__));