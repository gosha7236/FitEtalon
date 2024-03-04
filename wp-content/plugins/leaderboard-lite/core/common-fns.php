<?php if ( ! defined( 'ABSPATH' ) ) exit; 
//Common functions
function LBDheaderStyle($title=NULL){
	echo '<div class="head_lbAdmin">';
		echo '<div class="header_inner_lb">';
			echo '<h3><label for="title">'.$title.'</label></h3>';
		echo '</div>';
		echo '<div class="lbAdmin_cont">';
}
function LBDfooterStyle(){
		echo '</div>';
		echo '<div class="footer_inner_lb">';
		
		echo '</div>';
	echo '</div>';
}
///////////////////////////////// Time list /////////////////////////////////////
function LBD_TimeSlotes($default=NULL){
	$vals = array("12:00am","12:30am","1:00am","1:30am","2:00am","2:30am","3:00am","3:30am","4:00am","4:30am","5:00am","5:30am","6:00am","6:30am","7:00am","7:30am","8:00am","8:30am","9:00am","9:30am","10:00am","10:30am","11:00am","11:30am","12:00pm","12:30pm","1:00pm","1:30pm","2:00pm","2:30pm","3:00pm","3:30pm","4:00pm","4:30pm","5:00pm","5:30pm","6:00pm","6:30pm","7:00pm","7:30pm","8:00pm","8:30pm","9:00pm","9:30pm","10:00pm","10:30pm","11:00pm","11:30pm");
	$html = '';
	foreach($vals as $val){
		$html .= '<option value="'.$val.'"'.($val==$default? "selected":"").'>'.$val.'</option>';
	}
	return $html;
}
////////////////////////// Country list ////////////////////////////////////
function LBD_getCountries($default=NULL){
	$vals = array("United States","United Kingdom","Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Cote D\'ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands (Malvinas)","Fiji","Finland","France","French Guiana","French Polynesia","French Southern Territories","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea-bissau","Guyana","Haiti","Heard Island and Mcdonald Islands","Holy See (Vatican City State)","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran, Islamic Republic of","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea, Democratic People\'s Republic of","Korea, Republic of","Kuwait","Kyrgyzstan","Lao People\'s Democratic Republic","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macao","Macedonia, The Former Yugoslav Republic of","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia, Federated States of","Moldova, Republic of","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestinian Territory, Occupied","Panama","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russian Federation","Rwanda","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Pierre and Miquelon","Saint Vincent and The Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia and The South Sandwich Islands","Spain","Sri Lanka","Sudan","Suriname","Svalbard and Jan Mayen","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan, Province of China","Tajikistan","Tanzania, United Republic of","Thailand","Timor-leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","United States Minor Outlying Islands","Uruguay","Uzbekistan","Vanuatu","Venezuela","Viet Nam","Virgin Islands, British","Virgin Islands, U.S.","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe");
	$html = '';
	foreach($vals as $val){
		$html .= '<option value="'.$val.'"'.($val==$default? "selected":"").'>'.$val.'</option>';
	}
	return $html;
}
//////////////////// Get Event based Divisions - Event LeaderBoard ///////////////
function LBDEveWorkoutDivisions($div){
	global $wpdb;
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	$table8 = $wpdb->prefix . "lbd_event_registration_transaction"; 
	
	if($div != ''){
		$myrows = $wpdb->get_results( "SELECT * FROM ". $table7 ." WHERE divisions LIKE '%".$div."%' " );
		foreach($myrows as $row){
			$workouts[$row->id] = $row->workout;
		}
	}
	return $workouts;
}
//////////////////// Get Event based Division Units - Event LeaderBoard ///////////////
function LBDEveWorkoutDivisionUnits(){
	global $wpdb;
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	$table8 = $wpdb->prefix . "lbd_event_registration_transaction"; 
	$munit = array("time"=>"Time in hh:mm:ss","kg"=>"Weight in kg","lbs"=>"Weight in lbs","repetitions"=>"Number of Repetitions");
	$myrows = $wpdb->get_results( "SELECT workout, measurement_unit FROM ". $table7 );
	foreach($myrows as $row){
		$workouts[$row->workout] = $munit[$row->measurement_unit];
	}
	return $workouts;
}
////////////////////// DB functions ////////////////////////
function LBDgetAllFields($table,$key1=NULL,$val1=NULL,$key2=NULL,$val2=NULL){
	global $wpdb;
	$where = "";
	$condition1 = ($key1==NULL?"":$key1."='".$val1."'"); 
	$condition2 = ($key2==NULL?"":$key2."='".$val2."'"); 

	if($condition1 && $condition2){
		$where  = " WHERE (".$condition1." AND ".$condition2.") ";
	}else if($condition1 && !$condition2){
		$where = " WHERE ".$condition1;
	}
	
	$myrows = $wpdb->get_results( "SELECT * FROM ". $table .$where );
	return $myrows;
}

function LBDgetAllFieldsWithLimites($table,$limitfrom=0,$pagin=10,$key1=NULL,$val1=NULL){
	global $wpdb;
	$specialTable = $wpdb->prefix . "lbd_gym_workouts";
	if($table == $specialTable){
		$limit = " order by workout_date DESC  LIMIT ".$limitfrom.", ".$pagin."";
	}else{
		$limit = " LIMIT ".$limitfrom.", ".$pagin;
	}
	$where = "";
	$condition1 = ($key1==NULL?"":$key1."='".$val1."'"); 
	if($condition1){
		$where = " WHERE ".$condition1;
	}
	$myrows = $wpdb->get_results( "SELECT * FROM ". $table .$where.$limit );

	return  $myrows;
}
function LBDgetNameById($table,$field,$constraint,$constraint_value){
	global $wpdb;
	$where = " WHERE ".$constraint." = '".$constraint_value."'";
	$myrows = $wpdb->get_results( "SELECT ".$field." FROM ". $table .$where );
	foreach($myrows as $row){
		$result = $row->$field;
	}
	return $result;
}
//////////////// Get table row count ///////////////////////
function LBDgetRowCount($table=NULL){
	global $wpdb;
	if($table){
		$myrows = $wpdb->get_results("SELECT count(*) as c FROM ".$table);
		foreach($myrows as $row){
			return $row->c;
		}
	}else{
		return 0;
	}
}
//////////////// Permission notice ///////////////////////
function LBD_permission_notice(){
	echo 'Sorry, you don\'t have the permission to edit this page. Please inform site admin at <a href="mailto:'.get_option('admin_email').'">'.get_option('admin_email').'</a>';
}
//////////////////// LBDCurrencies ///////////////////////
function LBDCurrencies($default=NULL){
	$vals = array("USD","EUR","GBP");
	$html = '';
	foreach($vals as $val){
		$html .= '<option value="'.$val.'"'.($val==$default? "selected":"").'>'.$val.'</option>';
	}
	return $html;
}
///////////////////// Limit letters //////////////////////
function LBD_Limit_Letters($string, $letters_limit){
	$letters = substr($string,0,$letters_limit);
	if(strlen($string) > $letters_limit){
		return $letters.'...';
	}else{
		return $string;
	}
}
///////////////////// Limit Words /////////////////////
function LBD_string_limit_words($string, $word_limit){
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}
/////////////////// Auto Login //////////////////
function LBDautoLoginUser($user_id){
	global $wpdb, $post;
	$user = get_user_by( 'id', $user_id );
	if( $user ) {
		wp_set_current_user( $user_id, $user->user_login );
		wp_set_auth_cookie( $user_id );
		do_action( 'wp_login', $user->user_login, $user);
	}
}
/////////////////// Event Registration status check - Events LeaderBoard ///////////////////////////////
function LBDisRegistered(){
	global $wpdb, $post;
	return true;
}
/////////////////// Login Failed /////////////////
function LBD_login_failed() {
	global $wpdb, $post;
	$LeaderBoard_eventUserLogin 	= get_option('LeaderBoard_eventUserLogin');
	$from = $_SERVER['HTTP_REFERER'];
	$fromID = url_to_postid( $from );
	if($fromID==$LeaderBoard_eventUserLogin){
		$login_page = get_permalink($LeaderBoard_eventUserLogin);
		wp_redirect( $login_page . '?login=failed');
		exit;
	}
}
add_action( 'wp_login_failed', 'LBD_login_failed' );
//Add theme class to all pages
add_filter( 'body_class', 'lbd_body_class' );
function lbd_body_class( $classes ) {
	$classes[] = 'LeaderBoard_container';
	return $classes;
}
///////////////// Get total points for the Event LeaderBoard ///////////////////////////
function LBDgetEventTotalPoints($participant_id=NULL,$event_id=NULL){
	global $wpdb;
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	if($participant_id!=NULL && $event_id!=NULL){
		$myrows = $wpdb->get_results("SELECT SUM(point) as total_points FROM ".$table2." WHERE participant_id=".$participant_id." AND event_id=".$event_id);
		foreach($myrows as $row){
			return $row->total_points;
		}
	}else{
		return 0;
	}
}
//Sort array
function LBDmsort($array, $key, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
        if (!empty($key)) {
            $mapping = array();
            foreach ($array as $k => $v) {
                $sort_key = '';
                if (!is_array($key)) {
                    $sort_key = $v[$key];
                } else {
                    // @TODO This should be fixed, now it will be sorted as string
                    foreach ($key as $key_key) {
                        $sort_key .= $v[$key_key];
                    }
                    $sort_flags = SORT_STRING;
                }
                $mapping[$k] = $sort_key;
            }
            asort($mapping, $sort_flags);
            $sorted = array();
            foreach ($mapping as $k => $v) {
                $sorted[] = $array[$k];
            }
            return $sorted;
        }
    }
    return $array;
}