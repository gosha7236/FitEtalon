<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//Create Event LeaderBoard related admin pages and functions 
add_action( 'admin_menu', 'event_leaderboard_menu' );
function event_leaderboard_menu() {
	add_menu_page( 'Event LB', 'Event LB', 'manage_options', 'event_leaderboard', 'event_leaderboard', 'dashicons-index-card', 6  );
	add_submenu_page( 'event_leaderboard', 'Competitions', 'Competitions', 'manage_options', 'event_competitions', 'competitions_leaderboard' ); 
	add_submenu_page( 'event_leaderboard', 'Events', 'Events', 'manage_options', 'event_events', 'events_leaderboard' );
	add_submenu_page( 'event_leaderboard', 'Workouts', 'Workouts', 'manage_options', 'event_workouts', 'workouts_leaderboard' );
	add_submenu_page( 'event_leaderboard', 'Divisions', 'Divisions', 'manage_options', 'event_divisions', 'divisions_leaderboard' ); 
	add_submenu_page( 'event_leaderboard', 'Competitors', 'Competitors', 'manage_options', 'event_competitors', 'competitors_leaderboard' );
	add_submenu_page( 'event_leaderboard', 'Scores', 'Scores', 'manage_options', 'event_scores', 'scores_leaderboard' );
}
function event_leaderboard(){
	LBDheaderStyle("Event LeaderBoard - An Introduction");
	include_once('pages/event-intro.php');
	LBDfooterStyle();
}
function competitions_leaderboard(){
	LBDheaderStyle("Competitions"); 
	include_once('pages/event-competitions.php');
	LBDfooterStyle();
}
function events_leaderboard(){ 
	LBDheaderStyle("Events");
	include_once('pages/event-events.php');
	LBDfooterStyle();
}
function workouts_leaderboard(){
	LBDheaderStyle("Workouts");
	include_once('pages/event-workouts.php');
	LBDfooterStyle();
}
function divisions_leaderboard(){
	LBDheaderStyle("Divisions");
	include_once('pages/event-divisions.php');
	LBDfooterStyle();
} 
function competitors_leaderboard(){
	LBDheaderStyle("Competitors");
	include_once('pages/event-competitors.php');
	LBDfooterStyle();
}
function scores_leaderboard(){
	LBDheaderStyle("Scores");
	include_once('pages/event-scores.php');
	LBDfooterStyle();
}
include_once('ajax/event-competitions.php');
include_once('ajax/event-divisions.php');
include_once('ajax/event-events.php');
include_once('ajax/event-competitors.php');
include_once('ajax/event-workouts.php');
include_once('ajax/event-scores.php');
include_once('ajax/settings.php');