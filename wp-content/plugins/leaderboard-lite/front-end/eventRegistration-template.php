<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php 
	global $wpdb, $post; 
	$current_user = wp_get_current_user();
	
	$redirect_to = get_option('LeaderBoard_eventRegistrationpage');
	$payment_url = get_option('LeaderBoard_Payment');
	$my_account = get_option('LeaderBoard_eventMyAccount');
	$LeaderBoard_eventUserLogin = get_option('LeaderBoard_eventUserLogin');
	$LeaderBoard_eventspage = get_option('LeaderBoard_eventspage');
	
	$id 					= sanitize_text_field($_GET['id']);
	$regID 			= isset($_GET['regID'])?sanitize_text_field($_GET['regID']):'';
	$regStatus 	= isset($_GET['regStatus'])?sanitize_text_field($_GET['regStatus']):'';
	
	if(is_user_logged_in() && $id==''){//If not ID, redirect to My Account page
		wp_redirect(get_permalink($my_account));exit;
	}else if(!is_user_logged_in() && $id!=''){
		wp_redirect(get_permalink($LeaderBoard_eventUserLogin));exit;
	}
	get_header();
	
	date_default_timezone_set("UTC");
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	$table8 = $wpdb->prefix . "lbd_event_registration_transaction"; 
	
	$allEvents = LBDgetAllFields($table4);
	
	//Get the details of current user
	$currentUser = $current_user->user_email; 
	$getUserDetails = LBDgetAllFields($table1,"email",$currentUser);
	if($getUserDetails){ 
		foreach($getUserDetails as $usr){
			$user = $usr;
		}
	}else{
		$user = array();
	}

if(is_user_logged_in() && isset($id)!=""){
	$eventID = $id;
	$event = array();
	$regData = array();
	$transData = array();
	
	$getEventDetails = LBDgetAllFields($table4,"id",$eventID);
	foreach($getEventDetails as $eve){
		$event = $eve;
	}
	 if(isset($regStatus)==1 && isset($regID)){ 
		$getRegistrationDetails = LBDgetAllFields($table6,"id",$regID); //Get registration details
		foreach($getRegistrationDetails as $rd){
			$regData = $rd;
		}
		if($regData){
			$getTransactionDetails = LBDgetAllFields($table8,"id",$regData->transaction_id); //Get transaction details
			foreach($getTransactionDetails as $td){
				$transData = $td;
			}
		}
	}
	?>
	<section class="commen-wraper events-reg-top-block">
    <div class="plugin-container">
        <div class="events-reg-top-main clearfix">
            <div class="events-reg-top-left">
                <h3><span><?php echo esc_html('Register For'); ?></span> <?php echo esc_html($event->event_name); ?></h3>
                <p> <?php echo date("M d, Y",strtotime($event->from_date))." ".$event->from_time." - ".date("M d, Y",strtotime($event->to_date))." ".$event->to_time; ?></p>
            </div>
            <div class="events-reg-top-right">
                <span class="events-reg-span"><?php echo esc_html($event->currency)." ".esc_html($event->fee); ?></span>
            </div>
        </div>
    </div>
</section> 

<section class="commen-wraper events-reg-sec-block">
    <div class="plugin-container">
        <div class="events-reg-sec-main clearfix">
            <p><?php echo esc_html('Logged In As'); ?> <b><?php echo esc_html($current_user->user_login); ?></b><a href="<?php echo get_permalink($my_account); ?>" target="_blank"><?php echo esc_html('My Profile'); ?></a></p>
        </div>
    </div><!-- plugin-container -->
</section> 

<section class="commen-wraper events-reg-form-block">
    <div class="plugin-container">
        <?php if(isset($_POST['confirm_details'])=='Confirm & Proceed to Payment'){ ?>
			<?php
			$confirm_details = sanitize_text_field($_POST['confirm_details']);
			$eve_customer_tel = sanitize_text_field($_POST['eve_customer_tel']);
			$eve_customer_nation = sanitize_text_field($_POST['eve_customer_nation']);
			$eve_customer_email = sanitize_text_field($_POST['eve_customer_email']);
			$eve_customer_regFee = sanitize_text_field($_POST['eve_customer_regFee']);
			$eve_customer_regFeeCurrency = sanitize_text_field($_POST['eve_customer_regFeeCurrency']);
			?>
			<?php //Update details of the user 
			if($eve_customer_tel != '' && $eve_customer_nation != ''){
				$sql  = 'UPDATE '.$table1.' SET phonenum="'.$eve_customer_tel.'", nation_representing="'.$eve_customer_nation.'"  WHERE email = "'.$eve_customer_email.'"'; 
				dbDelta( $sql );
			}
			?>
			<span class="paymentErrors"></span>	
			<span class="notes"><?php echo esc_html('Please pay the registration fee of '); ?><?php echo $eve_customer_regFee." ".$eve_customer_regFeeCurrency; ?></span>
			
			<form action="<?php echo get_permalink($payment_url); ?>" method="POST" id="paymentForm">		
				<input type="hidden" name="regFeeAmt" value="<?php echo $eve_customer_regFee; ?>" />
				<input type="hidden" name="regFeeCurrency" value="<?php echo $eve_customer_regFeeCurrency; ?>" />
				<input type="hidden" name="eventID" value="<?php echo $id; ?>" />
				<div class="events-reg-form-main clearfix">
					<ul class="clearfix">
						<li>
							<p><?php echo esc_html('Name'); ?></p>
							<input type="text" name="custName" class="form-control" value="<?php echo sanitize_text_field($_POST['eve_customer_name']); ?>">
						</li>
						<li>
							<p><?php echo esc_html('Email'); ?></p>
							<input type="email" name="custEmail" class="form-control" value="<?php echo sanitize_email($_POST['eve_customer_email']); ?>">
						</li>
					</ul>
				</div>
				<div class="events-reg-form-main clearfix">
					<ul class="clearfix">
						<li>
							<p><?php echo esc_html('Card Number'); ?></p>
							<input type="text" name="cardNumber" size="20" autocomplete="off" id="cardNumber" class="form-control" />
						</li>
						<li>
							<p><?php echo esc_html('CVC'); ?></p>
							<input type="text" name="cardCVC" size="4" autocomplete="off" id="cardCVC" class="form-control" />
						</li>
					</ul>
				</div>
				<div class="events-reg-form-main clearfix">
					<ul class="clearfix">
						<li>
							<p><?php echo esc_html('Expiration (MM/YYYY)'); ?></p>
							<input type="text" name="cardExpMonth" placeholder="MM" size="2" id="cardExpMonth" class="form-control" style="width:100px; margin-right:10px; float:left;" /> 
							<input type="text" name="cardExpYear" placeholder="YYYY" size="4" id="cardExpYear" class="form-control" style="width:100px;"  />
						</li>
						<li>
						<span class="notes" style="background:#dc0b0b9e; border-left:5px solid red;"><?php echo 'Development Mode is ON: Please use the following details.<br />
						Card Number: 4242424242424242<br />
						CVC:123<br />
						Expiry date: 12/2019'; ?></span>
						</li>
					</ul>		
				</div>		
				<div class="events-reg-form-button">
					<input type="submit" id="makePayment" class="btn btn-success proceed-payment-btn" value="Make Payment">
				</div>		
			</form>
		<?php }else{ ?>
			<?php if($event->event_type=='team'){ ?>
				<div class="events-reg-form-main clearfix">
					<h4><?php echo esc_html('Team Captain info'); ?></h4>
					<ul class="clearfix">
					<li>
						<p><?php echo esc_html('Participant'); ?></p>
						<input type="text" class="events-reg-input" placeholder="First Name">
					</li>
					<li>
						<p>&nbsp;</p>
						<input type="text" class="events-reg-input" placeholder="Last Name">
					</li>
					<li>
						<p><?php echo esc_html('Email address'); ?></p>
						<input type="text" class="events-reg-input" placeholder="Enter your email address">
					</li>
					<li>
						<p><?php echo esc_html('Gender'); ?></p>
						<div class="gender">
							<label class="compititor-radio"><input name="" type="radio" value="" /> <span><?php echo esc_html('Male'); ?></span></label>
							<label class="compititor-radio"><input name="" type="radio" value="" /> <span><?php echo esc_html('Female'); ?></span></label>
						</div>
					</li>
					<li>
						<p><?php echo esc_html('Team Name'); ?></p>
						<input type="text" class="events-reg-input" placeholder="Team Name">
					</li>
				</ul>
				</div>
				<div class="events-reg-form-main clearfix">
				<h4><?php echo esc_html('Team mates'); ?> <span><?php echo esc_html('* all Fields are required'); ?></span></h4>
				<h5><?php echo esc_html('Teammate 1'); ?></h5>
				<ul class="clearfix">
					<li>
						<p><?php echo esc_html('First Name'); ?></p>
						<input type="text" class="events-reg-input" placeholder="Street address address">
					</li>
					<li>
						<p><?php echo esc_html('Last Name'); ?></p>
						<input type="text" class="events-reg-input" placeholder="Street address address">
					</li>
					<li>
						<p><?php echo esc_html('Email address'); ?></p>
						<input type="text" class="events-reg-input" placeholder="Unique email address">
					</li>
					<li>
						<p><?php echo esc_html('Gender'); ?></p>
						<div class="gender">
							<label class="compititor-radio"><input name="" type="radio" value="" /> <span><?php echo esc_html('Male'); ?></span></label>
							<label class="compititor-radio"><input name="" type="radio" value="" /> <span><?php echo esc_html('Female'); ?></span></label>
						</div>
					</li>
				</ul>
			</div>
				<div class="events-reg-form-button">
				<a href="#" class="proceed-payment-btn"> <?php echo esc_html('Confirm & Proceed to payment'); ?></a>
			</div>
			<?php }else{ ?>
				<form name="eventRegistration-individual" method="post" action="">
					<div class="events-reg-form-main clearfix">
						<h4><?php echo esc_html('User Registration Info:'); ?></h4>
						<ul class="clearfix">
							<li>
								<p><?php echo esc_html('Participant'); ?></p>
								<input type="text" class="events-reg-input" placeholder="First Name" name="eve_customer_name" id="eve_customer_name" value="<?php echo $current_user->display_name; ?>" readonly="">
							</li>
							<li>
								<p><?php echo esc_html('Email address'); ?></p>
								<input type="text" class="events-reg-input" placeholder="Enter your email address" name="eve_customer_email" id="eve_customer_email" value="<?php echo $current_user->user_email; ?>" readonly="">
							</li>
						</ul>
					</div>
					<div class="events-reg-form-main clearfix">
						<ul class="clearfix">
							<li>
								<p><?php echo esc_html('Emergency Contact '); ?></p>
								<input type="text" class="events-reg-input" placeholder="Emergency contact Name" name="eve_customer_tel" id="eve_customer_tel" value="<?php if($user){echo $user->phonenum;} ?>">
							</li>
							<li>
							<p><?php echo esc_html('Nation representing'); ?></p>
							<select name="eve_customer_nation" id="eve_customer_nation" class="events-select">
								<?php echo LBD_getCountries($user->nation_representing); ?>
							</select>
							</li>
						</ul>
					</div>
					<div class="events-reg-form-main clearfix">
						<h4><?php echo esc_html('Payment Info:'); ?></h4>
						<ul class="clearfix">		
							<li>
							<p><?php echo esc_html('Registration Fee'); ?></p>
							<input type="text" class="events-reg-input" value="<?php echo $event->fee; ?>"  name="eve_customer_regFee" id="eve_customer_regFee" style="width:100px; display:inline-block; margin-right:10px;" readonly=""><?php echo $event->currency; ?> 
							<input type="hidden" class="events-reg-input" value="<?php echo $event->currency; ?>"  name="eve_customer_regFeeCurrency" id="eve_customer_regFeeCurrency" />
							</li>
						</ul>
					</div>
					<div class="events-reg-form-button">
						<input type="submit" value="Confirm & Proceed to Payment" name="confirm_details" class="proceed-payment-btn" />
					</div>
				</form>
			<?php } ?>
         <?php } ?>   
    </div><!-- plugin-container -->
</section>
<?php } ?>
<?php get_footer(); ?>