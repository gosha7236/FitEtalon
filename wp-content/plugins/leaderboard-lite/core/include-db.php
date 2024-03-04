<?php if ( ! defined( 'ABSPATH' ) ) exit; 
	/************************* Do Not Modify ***************************/
	global $wpdb;
	//Table data
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	$table8 = $wpdb->prefix . "lbd_event_registration_transaction"; 
	//Page Templates
	$LeaderBoard_eventUserLogin 				= get_option('LeaderBoard_eventUserLogin');
	$LeaderBoard_eventspage 						= get_option('LeaderBoard_eventspage');
	$LeaderBoard_eventRegistrationpage 	= get_option('LeaderBoard_eventRegistrationpage');
	$LeaderBoard_eventMyAccount 				= get_option('LeaderBoard_eventMyAccount');
	$LeaderBoard_Payment 							= get_option('LeaderBoard_Payment');
	$LeaderBoard_eventRegistrationpage 	= get_option('LeaderBoard_eventRegistrationpage');
	$LeaderBoard_eventUserRegistration 	= get_option('LeaderBoard_eventUserRegistration');
?>