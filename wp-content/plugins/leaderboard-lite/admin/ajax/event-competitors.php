<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
///////////////////////////////////////////////////////////////////Ajax Calls///////////////////////////////////////////////////////////////////////////
/********************************************** Add Competition *************************************/
$table1 = $wpdb->prefix . "lbd_event_participants"; 
$table2 = $wpdb->prefix . "lbd_event_scores"; 
$table3 = $wpdb->prefix . "lbd_event_divisions"; 
$table4 = $wpdb->prefix . "lbd_event_events"; 
$table5 = $wpdb->prefix . "lbd_event_competitions"; 
$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	
add_action( 'wp_ajax_lbd_add_competitor', 'lbd_add_competitor_callback' ); 
add_action( 'wp_ajax_nopriv_lbd_add_competitor', 'lbd_add_competitor_callback' );
function lbd_add_competitor_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	
	$competitor_name 		= sanitize_text_field($_POST['competitor_name']);
	$competitor_gender 	= sanitize_text_field($_POST['competitor_gender']);
	$competitor_dob 			= sanitize_text_field($_POST['competitor_dob']);
	$competitor_age 			= sanitize_text_field($_POST['competitor_age']);
	$competitor_email 		= sanitize_email($_POST['competitor_email']);
	$competitor_phone 		= sanitize_text_field($_POST['competitor_phone']);
	$competitor_division 	= sanitize_text_field($_POST['competitor_division']);
	$competitor_reg_date = sanitize_text_field($_POST['competitor_reg_date']);
	$competitor_reg_date = ($competitor_reg_date=='')?date('Y-m-d'):$competitor_reg_date;
	$competitor_reg_fee 	= sanitize_text_field($_POST['competitor_reg_fee'])." ".sanitize_text_field($_POST['competitor_reg_fee_currency']);
	$competitor_payment_status = sanitize_text_field($_POST['competitor_payment_status']);
	$competitor_status 		= (filter_var($_POST['competitor_status'], FILTER_SANITIZE_STRING)=='on')?1:0; 
	
	//login data
	$competitor_username 	= trim($competitor_name).date('ymd');
	$pass 									= strtotime("now");
	$competitor_pass 			= md5($pass);


	if($competitor_name != '' && $competitor_email !='' && $competitor_phone !=''){
		$sql  = 'INSERT INTO '.$table1.' (`id`, `participant_name`,`user_name`,`user_pass`,`gender`, `dob`, `age`,`email`, `phonenum`, `division`, `registration_date`, `registration_fee`, `payment_status`, `status`) VALUES (NULL, "'.$competitor_name.'","'.$competitor_username.'","'.$competitor_pass.'","'.$competitor_gender.'", "'.$competitor_dob.'", "'.$competitor_age.'", "'.$competitor_email.'", "'.$competitor_phone.'", "'.$competitor_division.'", "'.$competitor_reg_date.'", "'.$competitor_reg_fee.'", "'.$competitor_payment_status.'", "'.$competitor_status.'")';

		dbDelta( $sql );
		//Add as WP user with Role "event participant"
		$userdata = array(
			'first_name' => $competitor_name,
			'role' => 'event_participant',
			'user_email' => $competitor_email,
			'user_login'  =>  $competitor_username,
			'user_pass'   =>  $competitor_pass
		);
		
		$user_id = wp_insert_user( $userdata ) ; 
		if ( ! is_wp_error( $user_id ) ) {
			echo "New Competitor added successfully. Username & Password are mailed to your registered EmailID.";
			//Send mail
			$to = $competitor_email;
			$subject = "Membership confirmation";
			$txt = "Thanks for registering with LeaderBoard Plugin. Please go through our payment process and activate your account <br />\r\n User Name:".$competitor_username."\n\n"."Password: ".$pass."\n\n\n\n\n\n";
			$headers = "From: ".get_option('admin_email'). "\r\n" .
			"CC: ".get_option('admin_email');
			
			mail($to,$subject,$txt,$headers);
		}
	}else{
		echo 0;
	}
	wp_die();
}
/********************************************** Delete Competitor *************************************/
add_action( 'wp_ajax_lbd_delete_competitor', 'lbd_delete_competitor_callback' );
add_action( 'wp_ajax_nopriv_lbd_delete_competitor', 'lbd_delete_competitor_callback' );
function lbd_delete_competitor_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$competitor_id = sanitize_text_field($_POST['competitor_id']); 
	if($competitor_id != ''){
		if($wpdb->delete( $table1, array( 'id' => $competitor_id ) )){
			echo "<span class='greenmsg'>Competitor deleted successfully</span>";
			//Remove the WP user associated with this user too.
			$current_usr = LBDgetAllFields($table1,"id",$competitor_id); 
			foreach($current_usr as $usr){$usrEmail = $usr->email;}
			if($usrEmail){
				$user = get_user_by( 'email', $usrEmail );
				wp_delete_user( $user->ID );
			}
		}
	}
	wp_die();
} 
/********************************************** Edit Competitor *************************************/
add_action( 'wp_ajax_lbd_edit_competitor', 'lbd_edit_competitor_callback' );
add_action( 'wp_ajax_nopriv_lbd_edit_competitor', 'lbd_edit_competitor_callback' );
function lbd_edit_competitor_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	$competitor_id = sanitize_text_field($_POST['competitor_id']);
	$editCompetitor = LBDgetAllFields($table1,"id",$competitor_id);
	foreach($editCompetitor as $compet){
		$com = $compet;
	}
	?>
	<form method="post" id="competitorForm" name="competitorFormEdit">
		<input type="hidden" name="edit_competitor_id" value="<?php echo $com->id; ?>" id="edit_competitor_id" />
		<div class="scorebord-table">
			<div class="resize-table">
				<div class="blockCustom">
					<div class="block2_1">
						<label><?php echo esc_html('Competitor Name:'); ?></label>
						<input type="text" name="edit_competitor_name" value="<?php echo $com->participant_name; ?>" id="edit_competitor_name" class="log-in-input" />
					</div>
					<div class="block2_1">
						<label><?php echo esc_html('Gender:'); ?></label>
						<select name="edit_competitor_gender" id="edit_competitor_gender" class="log-in-input">
							<option value="">-- Select Option --</option>
							<option value="M" <?php if("M"==$com->gender){ echo "selected"; }?>>Male</option>
							<option value="F" <?php if("F"==$com->gender){ echo "selected"; }?>>Female</option>
						</select>
					</div>
				</div>
				 <div class="blockCustom">
					<div class="block2_1">
						<label><?php echo esc_html('DOB(YYYY-MM-DD):'); ?></label>
						<input type="text" name="edit_competitor_dob" value="<?php echo $com->dob; ?>" id="edit_competitor_dob" class="log-in-input" />
					</div>
					<div class="block2_1">
						<label><?php echo esc_html('Age:'); ?></label>
						<input type="text" name="edit_competitor_age" value="<?php echo $com->age; ?>" id="edit_competitor_age" class="log-in-input" style="width:50px;" />
					</div>
				</div>
				 <div class="blockCustom">
					<div class="block2_1">
						<label><?php echo esc_html('EmailID:'); ?></label>
						<input type="text" name="edit_competitor_email" value="<?php echo $com->email; ?>" id="edit_competitor_email" class="log-in-input" />
					</div>
					<div class="block2_1">
						<label><?php echo esc_html('Phone Number:'); ?></label>
						<input type="text" name="edit_competitor_phone" value="<?php echo $com->phonenum; ?>" id="edit_competitor_phone" class="log-in-input" />
					</div>
				</div>
				 <div class="blockCustom">
					<div class="block2_1">
						<label><?php echo esc_html('Division:'); ?></label>
						<?php $divisions = LBDgetAllFields($table3); ?>
						<select name="edit_competitor_division" id="edit_competitor_division" >
							<option value="">-Select Division-</option>
							<?php foreach($divisions as $div){ ?>
							<option value="<?php echo $div->id; ?>" <?php if($div->id==$com->division){ echo "selected"; }?>><?php echo $div->division_name; ?> </option>
							<?php } ?>
						</select>
					</div>
					<div class="block2_1">
						<label><?php echo esc_html('Registration Date:'); ?></label>
						<input type="text" name="edit_competitor_reg_date" value="<?php echo $com->registration_date; ?>" id="edit_competitor_reg_date" class="log-in-input" />
					</div>
				</div>
				 <div class="blockCustom">
					<div class="block2_1">
						<label><?php echo esc_html('Registration Fee:'); ?></label>
						<input type="text" name="edit_competitor_reg_fee" value="<?php echo $com->registration_fee; ?>" id="edit_competitor_reg_fee" class="log-in-input" />
					</div>
					<div class="block2_1">
						<label><?php echo esc_html('Payment Status:'); ?></label>
						<?php $payStatus = array("pending"=>"Pending","hold"=>"On Hold","cancelled"=>"Cancelled","completed"=>"Completed"); ?>
						<select name="edit_competitor_payment_status" id="edit_competitor_payment_status" class="log-in-input">
							<option value="">-- Select Option --</option>
							<?php foreach($payStatus as $ps=>$val){ ?>
							<option value="<?php echo $ps; ?>" <?php if($ps==$com->payment_status){ echo "selected"; } ?>><?php echo $val; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="blockCustom">
					<div class="block2_1">
						<label><?php echo esc_html('Status:'); ?></label>
						<input type="checkbox" name="edit_competitor_status" id="edit_competitor_status" <?php if($com->status==1){ echo "checked"; }?> />
						<?php echo esc_html(' ( Tick to activate Membership )'); ?>
					</div>
				</div>
				<div class="blockCustom">
					<input type="submit" name="editsave_competitor" value="Save Changes" class="log-in-submit editCompetitorSave" />
				</div>
			</div>
		</div>
	</form>
	<?php  
	wp_die(); 
} 
/********************************************** Edit Save Competitor *************************************/  
add_action( 'wp_ajax_lbd_editsave_competitor', 'lbd_editsave_competitor_callback' ); 
add_action( 'wp_ajax_nopriv_lbd_editsave_competitor', 'lbd_editsave_competitor_callback' );
function lbd_editsave_competitor_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	
	$competitor_id 				= sanitize_text_field($_POST['competitor_id']);
	$competitor_name 		= sanitize_text_field($_POST['competitor_name']);
	$competitor_gender 	= sanitize_text_field($_POST['competitor_gender']);
	$competitor_dob 			= sanitize_text_field($_POST['competitor_dob']);
	$competitor_age 			= sanitize_text_field($_POST['competitor_age']);
	$competitor_email 		= sanitize_email($_POST['competitor_email']);
	$competitor_phone 		= sanitize_text_field($_POST['competitor_phone']);
	$competitor_division 	= sanitize_text_field($_POST['competitor_division']);
	$competitor_reg_date = (sanitize_text_field($_POST['competitor_reg_date'])=='')?date('Y-m-d'):sanitize_text_field($_POST['competitor_reg_date']);
	$competitor_reg_fee 	= sanitize_text_field($_POST['competitor_reg_fee']);
	$competitor_payment_status = sanitize_text_field($_POST['competitor_payment_status']);
	$competitor_status 		= (filter_var($_POST['competitor_status'], FILTER_SANITIZE_STRING)=='on')?1:0; 

	if($competitor_name !=''){
		$sql  = 'UPDATE '.$table1.' SET participant_name="'.$competitor_name.'", gender="'.$competitor_gender.'", dob="'.$competitor_dob.'", age="'.$competitor_age .'", email="'.$competitor_email .'", phonenum="'.$competitor_phone .'", division="'.$competitor_division .'", registration_date="'.$competitor_reg_date .'", registration_fee="'.$competitor_reg_fee .'", payment_status="'.$competitor_payment_status .'", status="'.$competitor_status.'" WHERE id = '.$competitor_id; 
		
		dbDelta( $sql );
		echo "Event Edited successfully"; 
	}else{
		echo 0;
	}
	wp_die();
}