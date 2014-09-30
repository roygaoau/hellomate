<?php

/* 
 * bbPress specific configurations
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */


//register our own css file
if(!is_admin()){ add_action('bbp_enqueue_scripts', 'kleo_bbpress_register_style',15); }


function kleo_bbpress_register_style()
{
	global $bbp;

	wp_dequeue_style( 'bbp-default-bbpress' );
	wp_dequeue_style( 'bbp-default' );
	wp_enqueue_style( 'kleo-bbpress', THEME_URI.'/bbpress/css/bbpress.css');

}


function kleo_bbp_no_breadcrumb ($param) {
    return true;
}
add_filter ('bbp_no_breadcrumb', 'kleo_bbp_no_breadcrumb');


//Change page layout to match theme options settings
add_filter('kleo_page_layout', 'kleo_bbpress_change_layout');

function kleo_bbpress_change_layout($layout) {
	if (is_bbpress()) {
		$bbpress_template = sq_option('bbpress_sidebar', 'default');
		if ( $bbpress_template != 'default' ) {
			$layout = $bbpress_template;
		}
	}
	
	return $layout;
}