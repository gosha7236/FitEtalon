<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//Create Common admin pages 
add_action( 'admin_menu', 'common_leaderboard_menu' );
function common_leaderboard_menu() {
	add_menu_page( 'LB Settings', 'LB Settings', 'manage_options', 'lbd_settings', 'lbd_settings', 'dashicons-admin-generic', 8  );
}
function lbd_settings(){
	LBDheaderStyle("Settings");
	include_once('pages/settings.php');
	LBDfooterStyle();
}