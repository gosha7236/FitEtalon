<?php if ( ! defined( 'ABSPATH' ) ) exit; 
function createLBD_Shortcodes(){ 
	global $wpdb, $post;
	/*************************1************************/
	//Events page
	$post = array(
	  'post_content' => "",
	  'post_status' => 'publish',
	  'post_title' => "Events",
	  'post_type' => 'page'
	);  
	$post_id1 = wp_insert_post( $post );
	update_post_meta( $post_id1, '_wp_page_template', 'eventList-template.php' );
	
	$option_name1 = 'LeaderBoard_eventspage' ;
	$new_value1 = $post_id1;
	if ( get_option( $option_name1 ) !== false ) {
		update_option( $option_name1, $new_value1 );
	} else {
		$deprecated = null;
		$autoload = 'yes';
		add_option( $option_name1, $new_value1, $deprecated, $autoload );
	}
	/*************************2************************/
	//Event Registration Page
	$post2 = array(
	  'post_content' => "",
	  'post_status' => 'publish',
	  'post_title' => "Event Registration",
	  'post_type' => 'page'
	);  
	$post_id2 = wp_insert_post( $post2 );
	update_post_meta( $post_id2, '_wp_page_template', 'eventRegistration-template.php' );
	
	$option_name2 = 'LeaderBoard_eventRegistrationpage' ;
	$new_value2 = $post_id2;
	if ( get_option( $option_name2 ) !== false ) {
		update_option( $option_name2, $new_value2 );
	}else{
		$deprecated = null;
		$autoload = 'yes';
		add_option( $option_name2, $new_value2, $deprecated, $autoload );
	}
	/*************************3************************/
	//Event - My Account Page
	$post3 = array(
	  'post_content' => "",
	  'post_status' => 'publish',
	  'post_title' => "My Account - Events",
	  'post_type' => 'page'
	);  
	$post_id3 = wp_insert_post( $post3 );
	update_post_meta( $post_id3, '_wp_page_template', 'my-account.php' );
	
	$option_name3 = 'LeaderBoard_eventMyAccount' ;
	$new_value3 = $post_id3;
	if ( get_option( $option_name3 ) !== false ) {
		update_option( $option_name3, $new_value3 );
	}else{
		$deprecated = null;
		$autoload = 'yes';
		add_option( $option_name3, $new_value3, $deprecated, $autoload );
	}
	/**************************4***********************/
	//Login Page
	$post4 = array(
	  'post_content' => "",
	  'post_status' => 'publish',
	  'post_title' => "Login",
	  'post_type' => 'page'
	);  
	$post_id4 = wp_insert_post( $post4 );
	update_post_meta( $post_id4, '_wp_page_template', 'eventLeaderBoard-login.php' );
	
	$option_name4 = 'LeaderBoard_eventUserLogin' ;
	$new_value4 = $post_id4;
	if ( get_option( $option_name4 ) !== false ) {
		update_option( $option_name4, $new_value4 );
	}else{
		$deprecated = null;
		$autoload = 'yes';
		add_option( $option_name4, $new_value4, $deprecated, $autoload );
	}
	/***************************5**********************/
	//Registration Page
	$post5 = array(
	  'post_content' => "",
	  'post_status' => 'publish',
	  'post_title' => "Registration",
	  'post_type' => 'page'
	);  
	$post_id5 = wp_insert_post( $post5 );
	update_post_meta( $post_id5, '_wp_page_template', 'eventLeaderBoard-registration.php' );
	
	$option_name5 = 'LeaderBoard_eventUserRegistration' ;
	$new_value5 = $post_id5;
	if ( get_option( $option_name5 ) !== false ) {
		update_option( $option_name5, $new_value5 );
	}else{
		$deprecated = null;
		$autoload = 'yes';
		add_option( $option_name5, $new_value5, $deprecated, $autoload );
	}
	/************************6*************************/
	//Payment Page
	$post6 = array(
	  'post_content' => "",
	  'post_status' => 'publish',
	  'post_title' => "Payment",
	  'post_type' => 'page'
	);  
	$post_id6 = wp_insert_post( $post6 );
	update_post_meta( $post_id6, '_wp_page_template', 'payment.php' );
	
	$option_name6 = 'LeaderBoard_Payment' ;
	$new_value6 = $post_id6;
	if ( get_option( $option_name6 ) !== false ) {
		update_option( $option_name6, $new_value6 );
	}else{
		$deprecated = null;
		$autoload = 'yes';
		add_option( $option_name6, $new_value6, $deprecated, $autoload );
	}
	/**************************7***********************/
	//Event LeaderBoard Page - To show event scores
	$post7 = array(
	  'post_content' => "",
	  'post_status' => 'publish',
	  'post_title' => "Event LeaderBoard",
	  'post_type' => 'page'
	);  
	$post_id7 = wp_insert_post( $post7 );
	update_post_meta( $post_id7, '_wp_page_template', 'event-LeaderBoard.php' );
	
	$option_name7 = 'Event_LeaderBoard' ;
	$new_value7 = $post_id7;
	if ( get_option( $option_name7 ) !== false ) {
		update_option( $option_name7, $new_value7 );
	}else{
		$deprecated = null;
		$autoload = 'yes';
		add_option( $option_name7, $new_value7, $deprecated, $autoload );
	}
}
