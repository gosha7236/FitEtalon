<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php get_header(); ?>
<?php 
	global $wpdb, $post; 
	$options = get_option('LeaderBoardSettings');
	
	date_default_timezone_set("UTC");
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	$table8 = $wpdb->prefix . "lbd_event_registration_transaction"; 
	
	$my_account = get_option('LeaderBoard_eventMyAccount');
	$payment_url = get_option('LeaderBoard_Payment');
	$LeaderBoard_eventUserRegistration 	= get_option('LeaderBoard_eventUserRegistration');
?>
<section class="commen-wraper compititor-regi-block">
    <div class="plugin-container">
	<?php	
	if(isset($_POST['AddCompetitorReg'])=='Submit'){
		$competitor_name 		= (isset($_POST['comp_fullname']))?sanitize_text_field($_POST['comp_fullname']):"";
		$competitor_gender 	= (isset($_POST['comp_gender']))?sanitize_text_field($_POST['comp_gender']):"";
		$competitor_dob 			= sanitize_text_field($_POST['comp_dob']);
		$competitor_age 			= sanitize_text_field($_POST['comp_age']);
		$competitor_email 		= sanitize_email($_POST['comp_email']);
		$competitor_address 	= stripslashes(sanitize_text_field($_POST['comp_address']));
		$competitor_phone 		= sanitize_text_field($_POST['comp_phn']);
		$competitor_division 	= sanitize_text_field($_POST['comp_div']);
		$competitor_reg_date = date('Y-m-d');
		$competitor_reg_fee 	= $options['memberFee_individual'];
		$competitor_payment_status = "pending";
		$competitor_status 		= 0;
		//login data
		$competitor_username 	= str_replace(" ","",$competitor_name).date('ymd');
		$pass 									= strtotime("now");
		$competitor_pass 			= md5($pass);
	
		if($competitor_name != '' && $competitor_email !='' && $competitor_phone !=''){
			$sql  = 'INSERT INTO '.$table1.' (`id`, `participant_name`,`user_name`,`user_pass`,`gender`, `dob`, `age`,`email`, `address`, `phonenum`, `division`, `registration_date`, `registration_fee`, `payment_status`, `status`) VALUES (NULL, "'.$competitor_name.'","'.$competitor_username.'","'.$competitor_pass.'","'.$competitor_gender.'", "'.$competitor_dob.'", "'.$competitor_age.'", "'.$competitor_email.'", "'.$competitor_address.'", "'.$competitor_phone.'", "'.$competitor_division.'", "'.$competitor_reg_date.'", "'.$competitor_reg_fee.'", "'.$competitor_payment_status.'", "'.$competitor_status.'")';
	
			dbDelta( $sql );
			//Add as WP user with Role "event_participant"
			$userdata = array(
				'first_name' => $competitor_name,
				'role' => 'event_participant',
				'user_email' => $competitor_email,
				'user_login'  =>  $competitor_username,
				'user_pass'   =>  $pass
			);
			
			$user_id = wp_insert_user( $userdata ) ; 
			if ( ! is_wp_error( $user_id ) ) {
				echo "<span class='notes'>Thanks for registering with LeaderBoard Plugin. <br /><br />
				<b>User Name: </b> ".$competitor_username."\n\n"."<br /><b>Password: </b> ".$pass."<br /><br /> To activate the account, please go through the payment process and activate your account</span><a href='".get_permalink($my_account)."?action=complete_payment' class='common-btn' target='_blank'>Proceed to payment</a>&nbsp;&nbsp;<a href='".get_permalink($my_account)."' class='common-btn' target='_blank'>Login & Visit Your Account</a>";
				LBDautoLoginUser($user_id); 

				if($user_id){//Send mail
					$to = $competitor_email;
					$subject = "Membership confirmation";
					$txt = "<span class='notes'>Thanks for registering with LeaderBoard Plugin. <br /><br />
					<b>User Name: </b> ".$competitor_username."\n\n"."<br /><b>Password: </b> ".$pass."<br /><br /> To activate the account, please go through the payment process and activate your account</span><a href='".get_permalink($my_account)."?action=complete_payment' class='common-btn' target='_blank'>Proceed to payment</a>&nbsp;&nbsp;<a href='".get_permalink($my_account)."' class='common-btn' target='_blank'>Login & Visit Your Account</a>";
				
					$headers = "From: ".get_option('admin_email'). "\r\n" .
					"CC: ".get_option( 'admin_email' );
					
					mail($to,$subject,$txt,$headers);
				}
			}
		}else{
			echo 'Something went wrong. Please <a href="'.get_permalink($LeaderBoard_eventUserRegistration).'"><b> reload</b></a> the page.';
		}
	}else{
?>
        <div class="compititor-regi-main">
            <h3><?php echo esc_html('Register Now'); ?></h3>
			<form name="Competitor_registration" id="Competitor_registration" method="post">
				<div class="compititor-regi-cont clearfix">
					<div class="compititor-regi-left">
						<ul>
							<li class="clearfix">
								<label><?php echo esc_html('Full Name'); ?> <span class="redFont">*</span></label>
								<div class="compititor-input">
									<input type="text" class="compititor-input-box" name="comp_fullname" id="comp_fullname">
								</div>
							</li>
							<li class="clearfix">
								<label><?php echo esc_html('DOB'); ?></label>
								<div class="compititor-input">
									<input type="text" class="compititor-input-box" name="comp_dob" id="comp_dob"><?php echo esc_html('(In yyyy-mm-dd format)'); ?>
								</div>
							</li>
							<li class="clearfix">
								<label><?php echo esc_html('Gender'); ?></label>
								<div class="compititor-input">
									<label class="compititor-radio"><input name="comp_gender" type="radio" value="M" id="comp_gender" /> <span><?php echo esc_html('Male'); ?></span></label>
									<label class="compititor-radio"><input name="comp_gender" type="radio" value="F" id="comp_gender" /> <span><?php echo esc_html('Female'); ?></span></label>
								</div>
							</li>
							<li class="clearfix">
								<label><?php echo esc_html('Email Address'); ?> <span class="redFont">*</span></label>
								<div class="compititor-input">
									<input type="text" class="compititor-input-box" name="comp_email" id="comp_email">
								</div>
							</li>
							<li class="clearfix">
								<label><?php echo esc_html('Phone Number'); ?> <span class="redFont">*</span></label>
								<div class="compititor-input">
									<input type="text" class="compititor-input-box" name="comp_phn" id="comp_phn">
								</div>
							</li>
							<li class="clearfix">
								<label><?php echo esc_html('Division'); ?></label>
								<div class="compititor-input">
									<select name="comp_div" id="comp_div" class="compititor-select" >
										<?php $division = LBDgetAllFields($table3); ?>
										<?php foreach($division as $div){ ?>
											<option value="<?php echo $div->id; ?>"><?php echo $div->division_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</li>
						</ul>
					</div>
					<div class="compititor-regi-right">
						<ul>
							<li class="clearfix">
								<label><?php echo esc_html('Upload Photo'); ?></label>
								<div class="compititor-input">
									<div class="compititor-input-file-div"><input class="compititor-input-file" name="comp_photo" id="comp_photo" type="file" /></div>
								</div>
							</li>
							<li class="clearfix">
								<label><?php echo esc_html('Age'); ?></label>
								<div class="compititor-input">
									<input type="text" class="compititor-input-box" name="comp_age" id="comp_age">
								</div>
							</li>
							<li class="clearfix">
								<label><?php echo esc_html('Address'); ?></label>
								<div class="compititor-input">
									<textarea class="compititor-textarea" name="comp_address" id="comp_address"></textarea>
								</div>
							</li>
							<li class="clearfix">
								<label><?php echo esc_html('Nation Representing'); ?></label>
								<div class="compititor-input">
									<select name="comp_nation" id="comp_nation" class="compititor-select">
										<?php echo LBD_getCountries(); ?>
									</select>
								</div>
							</li>
						</ul>
					</div>
					<div id="error_block"></div>
				</div>
				<div class="submit-block clearfix">
					<div class="submit-left-block">
						<label><input name="accept_conditions" type="checkbox" id="accept_conditions" /> <span><?php echo esc_html('I Accept the terms and condition of Leaderboard'); ?></span> </label>
					</div>
					<div class="submit-right-block">
					<input type="submit" class="Submit-btn" name="AddCompetitorReg" id="AddCompetitorReg" value="Submit">
					</div>
				</div>
			</form>
        </div>
<?php } ?>
    </div>
</section>
<?php get_footer();