<?php
/*
Plugin Name: LeaderBoard LITE
Description: This plugin is to manage the LeaderBoard of Events
Author: Andy Fradelakis
Version: 1.24
Text Domain: leaderboard
*/ 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define('LBD_DIR', plugin_dir_url(__FILE__));
register_activation_hook( __FILE__, 'LeaderBoardEventDB' );
register_activation_hook( __FILE__, 'createLBD_Shortcodes' );
register_activation_hook( __FILE__, 'setLBDOptions' );
function setLBDOptions(){
	add_option( 'LBD_version', 'FREE' );
}
register_deactivation_hook( __FILE__, 'remove_LBD_settings' ); 
function remove_LBD_settings(){
	global $wpdb;
	delete_option( 'LBD_version' );
	delete_option( 'LeaderBoardSettings' );
	//Delete pages
	$Dpages = array('LeaderBoard_eventspage','LeaderBoard_eventRegistrationpage','LeaderBoard_eventMyAccount','LeaderBoard_eventUserLogin','LeaderBoard_eventUserRegistration','LeaderBoard_Payment','Event_LeaderBoard');
	foreach ($Dpages as $Dpage) {
		$DpageV = get_option($Dpage);
		delete_option( $Dpage );
		wp_delete_post( $DpageV, true );
	} 
	//Delete Database Tables
	$table = array();
	$table[0] = $wpdb->prefix . "lbd_event_participants"; 
	$table[1] = $wpdb->prefix . "lbd_event_scores"; 
	$table[2] = $wpdb->prefix . "lbd_event_divisions"; 
	$table[3] = $wpdb->prefix . "lbd_event_registration_transaction";
	$table[4] = $wpdb->prefix . "lbd_event_competitions"; 
	$table[5] = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table[6] = $wpdb->prefix . "lbd_event_workouts"; 
	$table[7] = $wpdb->prefix . "lbd_event_events";  
	
	foreach($table as $tb){ 
		$sql = "DROP TABLE IF EXISTS ".$tb;
		$wpdb->query($sql);
	}
}
/*=========================================*/
//Add action links to the plugin page.
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links' );
function add_action_links ( $links ) {
	 $mylinks = array(
		 '<a href="' . admin_url( 'admin.php?page=lbd_settings' ) . '" style="color:#08104c;"><b>Settings</b></a>',
		 '<a href="https://wpleaderboard.com/" style="color:green;" target="_blank"><b>Go Pro</b></a>',
	 );
	return array_merge( $links, $mylinks );
}
//Custom user role
function add_roles_on_LBD_activation() {
    add_role( 'event_manager', 'Event Manager', 
	array(
                'read' => true,
                'edit_posts' => false,
                'delete_posts' => false,
                'publish_posts' => false,
                'upload_files' => true,
				'event_leaderboard'=> true,
				'manage_options' => true,
				'menu-tools' => false
            )
	);
	add_role( 'event_participant', 'Event Participant', 
	array(
                'read' => true,
                'edit_posts' => false,
                'delete_posts' => false,
                'publish_posts' => false,
                'upload_files' => true,
				'event_leaderboard'=> true,
				'manage_options' => true,
				'menu-tools' => false
            )
	);
}
add_action( 'admin_init', 'add_roles_on_LBD_activation' );
////////////////// Remove some default pages from Event manager's admin panel ///////////////////////
function check_role_LBD_permissions(){
	$user = wp_get_current_user();
	if ( in_array( 'event_manager', (array) $user->roles ) ) {
		remove_menu_page('tools.php'); 
		remove_menu_page('options-general.php');//General settings page
		remove_menu_page('slm-main');
	}
}
add_action( 'admin_init', 'check_role_LBD_permissions' );
/******************************************** Styles and Js - Admin LeaderBoard LITE Version *************************************************/
function add_LBD_stylesheet() {
    wp_enqueue_style( 'LBAdminCSS', plugins_url( '/css/LBMain.css', __FILE__ ) ); 
	wp_enqueue_style( 'LBAdmin-mainCSS', plugins_url( '/css/main.css', __FILE__ ) ); 
	wp_enqueue_style( 'LBAdmin-mediaCSS', plugins_url( '/css/media.css', __FILE__ ) ); 
	wp_enqueue_style( 'LBAdmin-datepickerCSS', plugins_url( '/css/jquery-ui.css', __FILE__ ) ); 
	wp_enqueue_style('thickbox');
}
add_action('admin_print_styles', 'add_LBD_stylesheet');
function add_LBD_script() {
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_media();
	wp_enqueue_script( 'ajax-handle',  admin_url( 'admin-ajax.php' ) , false, '26.12.18' );
	wp_localize_script( 'ajax-handle', 'customAjaxHandle', array( 'myPermalink' => admin_url( 'admin-ajax.php' ), 'ajaxurl' => admin_url('admin-ajax.php'),'ajax_nonce' => wp_create_nonce('lbdNonce') ) );
	//wp_localize_script( 'ajax_nonce_lbd', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php'),'ajax_nonce' => wp_create_nonce('lbdNonce')));
	wp_enqueue_script( 'LBAdmin-mainJS', plugins_url('/js/AdminMain.js', __FILE__ ) , false, '26.12.19' );
	wp_enqueue_script( 'LBAdmin-customJS', plugins_url('/js/custom.js', __FILE__ ) , false, '26.12.19' );
	wp_enqueue_script( 'LBAdmin-EventAjaxJS', plugins_url( '/js/event-ajax.js', __FILE__ ), false, '26.12.19' );
}
add_action( 'admin_enqueue_scripts', 'add_LBD_script' );
/******************************************** styles and Js - Front End *************************************************/
add_action( 'wp_enqueue_scripts', 'LBD_theme_scripts' );
function LBD_theme_scripts() {
	wp_enqueue_style( 'mainCss', plugins_url( '/css/main.css', __FILE__ ) ); 
	wp_enqueue_style( 'mediaCss', plugins_url( '/css/media.css', __FILE__ ) ); 
	wp_enqueue_style( 'customCss', plugins_url( '/css/custom.css', __FILE__ ) ); 
	wp_enqueue_script( 'StripeJS1', "https://js.stripe.com/v2/" , array(), '26.5.19', true );
	wp_enqueue_script( 'mainScript', plugins_url('/js/main.js', __FILE__ ) , array(), '26.5.19', true );
	wp_enqueue_script( 'mainajax', plugins_url('/js/front-end-ajax.js', __FILE__ ) , array(), '26.5.19', true );
	wp_enqueue_media();	
}
/* END of Styles and JS */
require_once('admin/event-pages.php'); //create plugin pages of Event LeaderBoard
require_once('admin/common-pages.php'); //create plugin pages for Common settings
require_once('core/articles.php'); //LeaderBoard articles
require_once('core/common-fns.php'); //Wrap all the common functions used in the plugin
require_once('core/db.php'); //Wrap all the common functions used in the plugin 
require_once('core/shortcodes.php'); //Shortcodes used in the plugin 
require_once('core/hooks.php'); //Custom Hooks used in the plugin 
require_once('front-end/pageTemplates.php');//Custom page templates
require_once('front-end/pages.php'); //Front end pages for the plugin 
//============/