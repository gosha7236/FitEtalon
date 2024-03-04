<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
* DB operations - Event LeaderBoard
* Create Table participants
* Create Table scores
* Create Table divisions
* Create Table events
* Create Table competitions
* Create Table registeredEvents
*/
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
global $LBD_db_version,$wpdb;
$LBD_db_version = '1.0';

$charset_collate = $wpdb->get_charset_collate();

function LeaderBoardEventDB() {
	global $wpdb;

	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	$table8 = $wpdb->prefix . "lbd_event_registration_transaction"; 
	
	$sql1 = "CREATE TABLE $table1 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		participant_name tinytext NOT NULL,
		user_name tinytext NOT NULL,
		user_pass tinytext NOT NULL,
		gender tinytext NOT NULL,
		dob tinytext NOT NULL,
		age tinytext NOT NULL,
		email varchar(55) NOT NULL,
		address longtext,
		nation_representing longtext,
		phonenum varchar(55) NOT NULL,
		division varchar(55) NOT NULL,
		registration_date tinytext NOT NULL,
		registration_fee tinytext NOT NULL,
		payment_status tinytext NOT NULL,
		status mediumint(9) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
	
	$sql2 = "CREATE TABLE $table2 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		participant_id mediumint(9) NOT NULL,
		event_id mediumint(9) NOT NULL,
		workout_id mediumint(9) NOT NULL,
		division_id mediumint(9) NOT NULL,
		modified_date tinytext NOT NULL,
		added_by varchar(55) NOT NULL,
		score varchar(100) NOT NULL,
		point varchar(100) NOT NULL,
		proof longtext NOT NULL,
		status mediumint(9) DEFAULT '0' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
	
	$sql3 = "CREATE TABLE $table3 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		division_name tinytext NOT NULL,
		event_id mediumint(9) NOT NULL,
		status mediumint(9) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
	
	
	$sql4 = "CREATE TABLE $table4 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		event_name tinytext NOT NULL,
		event_organizer_email tinytext NOT NULL,
		event_competition tinytext ,
		from_date varchar(55),
		from_time varchar(55),
		to_date varchar(55),
		to_time varchar(55),
		full_day mediumint(9),
		location tinytext ,
		region tinytext,
		address tinytext ,
		country tinytext,
		city tinytext,
		po tinytext,
		latitude tinytext,
		longitude tinytext ,
		description longtext,
		image longtext,
		website longtext ,
		enable_booking mediumint(9) ,
		event_type varchar(55),
		endof_reg_date varchar(55),
		endof_reg_time varchar(55),
		fee mediumint(9) ,
		currency tinytext,
		status mediumint(9) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
	
	
	$sql5 = "CREATE TABLE $table5 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		competition_name tinytext NOT NULL,
		from_date date DEFAULT '0000-00-00' NOT NULL,
		to_date date DEFAULT '0000-00-00' NOT NULL,
		details longtext NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
	
	$sql6 = "CREATE TABLE $table6 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		event_id mediumint(9) NOT NULL,
		participant tinytext NOT NULL,
		transaction_id mediumint(9) NOT NULL,
		payment_status mediumint(9) NOT NULL,
		registration_status mediumint(9) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	$sql7 = "CREATE TABLE $table7 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		workout tinytext NOT NULL,
		event_id mediumint(9) NOT NULL,
		divisions varchar(55) NOT NULL,
		details longtext NOT NULL,
		measurement_unit varchar(55) NOT NULL,
		status mediumint(9) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
	
	$sql8 = "CREATE TABLE $table8 (
	 id int(11) NOT NULL AUTO_INCREMENT,
	 cust_name varchar(100)  NOT NULL,
	 cust_email varchar(255)  NOT NULL,
	 card_number bigint(20) NOT NULL,
	 card_cvc int(5) NOT NULL,
	 card_exp_month varchar(2)  NOT NULL,
	 card_exp_year varchar(5)  NOT NULL,
	 item_name varchar(255)  NOT NULL,
	 item_number varchar(50)  NOT NULL,
	 item_price float(10,2) NOT NULL,
	 item_price_currency varchar(10)  NOT NULL DEFAULT 'usd',
	 paid_amount varchar(10)  NOT NULL,
	 paid_amount_currency varchar(10)  NOT NULL,
	 txn_id varchar(100)  NOT NULL,
	 payment_status varchar(50)  NOT NULL,
	 created datetime NOT NULL,
	 modified datetime NOT NULL,
	 PRIMARY KEY (id)
	) $charset_collate;";
	
	dbDelta( $sql1 );
	dbDelta( $sql2 );
	dbDelta( $sql3 );
	dbDelta( $sql4 );
	dbDelta( $sql5 );
	dbDelta( $sql6 );
	dbDelta( $sql7 );
	dbDelta( $sql8 );
	
	add_option( 'LBD_db_version', $LBD_db_version );
	
	//For Events Score table
	$alter1 = "ALTER TABLE ".$table2."  ADD CONSTRAINT `f1_event_id` FOREIGN KEY (`event_id`) REFERENCES ".$table4."(`id`) ON DELETE CASCADE ON UPDATE NO ACTION";
	//For Division table
	$alter2 = "ALTER TABLE ".$table3."  ADD CONSTRAINT `f2_event_id` FOREIGN KEY (`event_id`) REFERENCES ".$table4." (`id`) ON DELETE CASCADE ON UPDATE NO ACTION";
	//For Registered Events table
	$alter3 = "ALTER TABLE ".$table6."  ADD CONSTRAINT `f3_event_id` FOREIGN KEY (`event_id`) REFERENCES ".$table4." (`id`) ON DELETE CASCADE ON UPDATE NO ACTION";
	//For Workouts table
	$alter4 = "ALTER TABLE ".$table7."  ADD CONSTRAINT `f4_event_id` FOREIGN KEY (`event_id`) REFERENCES ".$table4." (`id`) ON DELETE CASCADE ON UPDATE NO ACTION";
	
	$res1 = $wpdb->query($alter1);
	$res2 = $wpdb->query($alter2);
	$res3 = $wpdb->query($alter3);
	$res4 = $wpdb->query($alter4);
}