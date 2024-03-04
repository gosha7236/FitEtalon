<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php 
global $wpdb, $post;
if ( current_user_can('event_manager') || current_user_can('administrator') ) { 
}else{
	die('Permission not granted');
}
	$default_settings = array();

	if (!is_array(get_option('LeaderBoardSettings'))){
		add_option('LeaderBoardSettings', $default_settings);
	}
	
	if(!get_option('LeaderBoardSettings')){
			$options = array(
				'user_login' 				=> NULL,
				'user_registration' 	=> NULL,
				'my_account' 			=> NULL,
				'event_list'			 		=> NULL,
				'event_registration' 	=> NULL,
				'save_settings' 						=> NULL,
				'LeaderBoard_Payment' 		=> NULL,
				'Event_LeaderBoard' 			=> NULL,
				'stripe_secret' 						=> NULL,
				'stripe_publishable' 				=> NULL,
				'enable_stripeTestMode' 	=> NULL,
				'memberFee_individual' 		=> NULL,
				'memberFee_group' 			=> NULL,
				'memberFee_individual_currency' 	=> NULL,
				'memberFee_group_currency' 			=> NULL
			);

	}else{
		$options = get_option('LeaderBoardSettings'); 
	}
	
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	
	$args = array(
		'sort_order' => 'asc',
		'sort_column' => 'post_title',
		'hierarchical' => 1,
		'exclude' => '',
		'include' => '',
		'meta_key' => '',
		'meta_value' => '',
		'authors' => '',
		'child_of' => 0,
		'parent' => -1,
		'exclude_tree' => '',
		'number' => '',
		'offset' => 0,
		'post_type' => 'page',
		'post_status' => 'publish'
	); 
	$pages = get_pages($args); 

	$LeaderBoard_eventUserLogin 				= get_option('LeaderBoard_eventUserLogin');
	$LeaderBoard_eventspage 						= get_option('LeaderBoard_eventspage');
	$LeaderBoard_eventRegistrationpage 	= get_option('LeaderBoard_eventRegistrationpage');
	$LeaderBoard_eventMyAccount 				= get_option('LeaderBoard_eventMyAccount');
	$LeaderBoard_Payment 							= get_option('LeaderBoard_Payment');
	$LeaderBoard_eventUserRegistration 	= get_option('LeaderBoard_eventUserRegistration');
	$Event_LeaderBoard 									= get_option('Event_LeaderBoard');
	
	if (isset($_POST['save_settings'])== 'Save Settings') {
	
		$user_login 				= sanitize_text_field($_POST['user_login']);
		$user_registration 	= sanitize_text_field($_POST['user_registration']);
		$my_account 			= sanitize_text_field($_POST['my_account']);
		$event_list 				= sanitize_text_field($_POST['event_list']);
		$event_registration 	= sanitize_text_field($_POST['event_registration']);
		
		$save_settings 						= sanitize_text_field($_POST['save_settings']);
		$LeaderBoard_Payment 	= sanitize_text_field($_POST['LeaderBoard_Payment']);
		$Event_LeaderBoard 			= sanitize_text_field($_POST['Event_LeaderBoard']);
		$stripe_secret 						= sanitize_text_field($_POST['stripe_secret']);
		
		$stripe_publishable 					= sanitize_text_field($_POST['stripe_publishable']);
		$enable_stripeTestMode 			= $_POST['enable_stripeTestMode'];
		$memberFee_individual 			= sanitize_text_field($_POST['memberFee_individual']);
		$memberFee_group 					= sanitize_text_field($_POST['memberFee_group']);
		$memberFee_individual_currency 	= sanitize_text_field($_POST['memberFee_individual_currency']);
		$memberFee_group_currency 			= sanitize_text_field($_POST['memberFee_group_currency']);
	
		$options["user_login"]  				=  ($user_login!='')?$LeaderBoard_eventUserLogin:$user_login;
		$options["user_registration"]  	=  ($user_registration!='')?$LeaderBoard_eventUserRegistration:$user_registration;
		$options["my_account"]  				=  ($my_account!='')?$LeaderBoard_eventMyAccount:$my_account;
		$options["event_list"]  					=  ($event_list!='')?$LeaderBoard_eventspage:$event_list;
		$options["event_registration"]  	=  ($event_registration!='')?$LeaderBoard_eventRegistrationpage:$event_registration;
		
		
		$options["LeaderBoard_Payment"]  				=  ($LeaderBoard_Payment!='')?$LeaderBoard_Payment:$LeaderBoard_Payment;
		$options["Event_LeaderBoard"]  					=  ($Event_LeaderBoard!='')?$Event_LeaderBoard:$Event_LeaderBoard;
		
		$options["stripe_secret"]  	=  $stripe_secret;
		$options["stripe_publishable"]  		=  $stripe_publishable;
		$options["enable_stripeTestMode"] = isset($enable_stripeTestMode)?1:0;
		
		$options["memberFee_individual"]  	=  $memberFee_individual;
		$options["memberFee_group"]  		=  $memberFee_group;
		
		$options["memberFee_individual_currency"]  	=  $memberFee_individual_currency;
		$options["memberFee_group_currency"]  			=  $memberFee_group_currency;
		
		update_option( 'LeaderBoard_eventUserLogin',$user_login);
		update_option( 'LeaderBoard_eventspage', $event_list);
		update_option( 'LeaderBoard_eventRegistrationpage',$event_registration);
		update_option( 'LeaderBoard_eventMyAccount',$my_account);
		update_option( 'LeaderBoard_Payment',$LeaderBoard_Payment );
		update_option( 'Event_LeaderBoard',$Event_LeaderBoard);
		update_option( 'LeaderBoard_eventUserRegistration', $user_registration);
		
		
		update_option('LeaderBoardSettings', $options);
		echo '<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204); width: 100%; margin:0;"><p>LeaderBoard settings <strong>saved</strong>.</p></div>';
	}
	$LeaderBoard_eventUserLogin 				= get_option('LeaderBoard_eventUserLogin');
	$LeaderBoard_eventspage 						= get_option('LeaderBoard_eventspage');
	$LeaderBoard_eventRegistrationpage 	= get_option('LeaderBoard_eventRegistrationpage');
	$LeaderBoard_eventMyAccount 				= get_option('LeaderBoard_eventMyAccount');
	$LeaderBoard_Payment 							= get_option('LeaderBoard_Payment');
	$LeaderBoard_eventUserRegistration 	= get_option('LeaderBoard_eventUserRegistration');
	$Event_LeaderBoard 									= get_option('Event_LeaderBoard');
?>
<section class="commen-wraper scorebord-table-block">
    <div class="plugin-container">
        <div class="scorebord-table-main">
		<span class="ResultArea"></span>
            <div id="parentHorizontalTab">
                <ul class="resp-tabs-list hor_1">
                    <li><?php echo esc_html('Bind Pages to Templates'); ?></li>
					<li><?php echo esc_html('Membership'); ?></li>
					<li><?php echo esc_html('Stripe Payment'); ?></li>
					<li><?php echo esc_html('Miscellaneous'); ?></li>
                </ul>
				<form enctype="multipart/form-data" method="post" id="settingsForm" name="settingsForm">
					<div class="resp-tabs-container hor_1">
						<div>
							<div class="scorebord-table">
								<div class="resize-table">
									<div class="resize-table settingsTable">
										<h3 style="text-align:center;"><?php echo esc_html('Event LeaderBoard Page Templates'); ?></h3>
										<div class="blockCustom">
												<label><?php echo esc_html('User Login Page:'); ?></label>
												<select name="user_login" id="user_login" class="log-in-input">
													<option value=""><?php echo esc_html('-- Select page --'); ?></option>
													<?php foreach($pages as $p){ ?>
													<option value="<?php echo $p->ID; ?>" <?php if($p->ID==$options['user_login'] || $p->ID==$LeaderBoard_eventUserLogin){echo "selected"; } ?>><?php echo $p->post_title; ?></option>
													<?php } ?>
												</select>
										</div>        
										<div class="blockCustom">
												<label><?php echo esc_html('User Registration Page:'); ?></label>
												<select name="user_registration" id="user_registration" class="log-in-input">
													<option value=""><?php echo esc_html('-- Select page --'); ?></option>
													<?php foreach($pages as $p){ ?>
													<option value="<?php echo $p->ID; ?>" <?php if($p->ID==$options["user_registration"] || $p->ID==$LeaderBoard_eventUserRegistration){echo "selected"; } ?>><?php echo $p->post_title; ?></option>
													<?php } ?>
												</select>
										</div>
										<div class="blockCustom">
												<label><?php echo esc_html('My Account Page:'); ?></label>
												<select name="my_account" id="my_account" class="log-in-input">
													<option value=""><?php echo esc_html('-- Select page --'); ?></option>
													<?php foreach($pages as $p){ ?>
													<option value="<?php echo $p->ID; ?>" <?php if($p->ID==$options["my_account"] || $p->ID==$LeaderBoard_eventMyAccount){echo "selected"; } ?>><?php echo $p->post_title; ?></option>
													<?php } ?>
												</select>
										</div>    
										<div class="blockCustom">
												<label><?php echo esc_html('Event Listing Page:'); ?></label>
												<select name="event_list" id="event_list" class="log-in-input">
													<option value=""><?php echo esc_html('-- Select page --'); ?></option>
													<?php foreach($pages as $p){ ?>
													<option value="<?php echo $p->ID; ?>" <?php if($p->ID==$options["event_list"] || $p->ID==$LeaderBoard_eventspage){echo "selected"; } ?>><?php echo $p->post_title; ?></option>
													<?php } ?>
												</select>
										</div>   
										<div class="blockCustom">
												<label><?php echo esc_html('Event Registration Page:'); ?></label>
												<select name="event_registration" id="event_registration" class="log-in-input">
													<option value=""><?php echo esc_html('-- Select page --'); ?></option>
													<?php foreach($pages as $p){ ?>
													<option value="<?php echo $p->ID; ?>" <?php if($p->ID==$options["event_registration"] || $p->ID==$LeaderBoard_eventRegistrationpage){echo "selected"; } ?>><?php echo $p->post_title; ?></option>
													<?php } ?>
												</select>
										</div>
										<div class="blockCustom">
												<label><?php echo esc_html('Payment Page:'); ?></label>
												<select name="LeaderBoard_Payment" id="LeaderBoard_Payment" class="log-in-input">
													<option value=""><?php echo esc_html('-- Select page --'); ?></option>
													<?php foreach($pages as $p){ ?>
													<option value="<?php echo $p->ID; ?>" <?php if($p->ID==$options["LeaderBoard_Payment"] || $p->ID==$LeaderBoard_Payment){echo "selected"; } ?>><?php echo $p->post_title; ?></option>
													<?php } ?>
												</select>
										</div>
										<div class="blockCustom">
												<label><?php echo esc_html('Event LeaderBoard Page:'); ?></label>
												<select name="Event_LeaderBoard" id="Event_LeaderBoard" class="log-in-input">
													<option value=""><?php echo esc_html('-- Select page --'); ?></option>
													<?php foreach($pages as $p){ ?>
													<option value="<?php echo $p->ID; ?>" <?php if($p->ID==$options["Event_LeaderBoard"] || $p->ID==$Event_LeaderBoard){echo "selected"; } ?>><?php echo $p->post_title; ?></option>
													<?php } ?>
												</select>
										</div>								
									</div>
								</div>
							</div>
						</div>
						<div>
						<?php if(is_admin()){ ?>
						   <div class="scorebord-table">
								<div class="resize-table settingsTable">
									<h3><?php echo esc_html('Membership Fee'); ?></h3>
									<div class="blockCustom">
											<label><?php echo esc_html('Individual:'); ?></label>
											<input type="text" name="memberFee_individual" value="<?php echo $options["memberFee_individual"]; ?>" id="memberFee_individual" class="log-in-input short-input" /> In  
											<select name="memberFee_individual_currency" id="memberFee_individual_currency">
												<?php echo LBDCurrencies( $options["memberFee_individual_currency"]); ?>
											</select>
									</div>
									<div class="blockCustom">
											<label><?php echo esc_html('Group/Team:'); ?></label>
											<input type="text" name="memberFee_group" value="<?php echo $options["memberFee_group"]; ?>" id="memberFee_group" class="log-in-input short-input" /> In  
											<select name="memberFee_group_currency" id="memberFee_group_currency">
												<?php echo LBDCurrencies( $options["memberFee_group_currency"]); ?>
											</select>
									</div>                        
								</div>
							</div>
						<?php } ?>	
						</div>
						<div>
						<?php if(is_admin()){ ?>
						   <div class="scorebord-table">
								<div class="resize-table settingsTable">
									<h3><?php echo esc_html('Stripe Payment Details'); ?></h3>
									<div class="blockCustom">
											<label><?php echo esc_html('Enable Test Mode:'); ?></label>
											<input type="checkbox" name="enable_stripeTestMode" <?php if($options["enable_stripeTestMode"]==1){echo "checked";}?> id="enable_stripeTestMode"  /> 
									</div>
									<div id="stripe_data">
										<div class="blockCustom">
												<label><?php echo esc_html('Secret Key:'); ?></label>
												<input type="text" name="stripe_secret" value="<?php echo $options["stripe_secret"]; ?>" id="stripe_secret" class="log-in-input" /> 
										</div>
										<div class="blockCustom">
												<label><?php echo esc_html('Publishable Key:'); ?></label>
												<input type="text" name="stripe_publishable" value="<?php echo $options["stripe_publishable"]; ?>" id="stripe_publishable" class="log-in-input" /> 
										</div>  
									</div>                      
								</div>
							</div>
						<?php } ?>	
						</div>
						<div>
						   <div class="scorebord-table">
								<div class="resize-table settingsTable">
									<div class="blockCustom">
											<label><?php echo esc_html('Maximum Events/year Allowed:'); ?></label>
											<?php if(get_option('LBD_version')=="PRO"){ echo "<b>Unlimited</b>"; }else{ ?>
											<input type="text" name="max_eve" value="1" id="max_eve" class="log-in-input short-input" readonly /><span class="notes">Want to add more events? <a href="https://wpleaderboard.com/" target="_blank">Upgrade to our PRO</a> version now!  </span>
											<?php } ?>
									</div>
									<div class="blockCustom">
											<label><?php echo esc_html('Maximum Competitors/event Allowed:'); ?></label>
											<?php if(get_option('LBD_version')=="PRO"){ echo "<b>Unlimited</b>"; }else{ ?>
											<input type="text" name="max_competitors" value="25" id="max_competitors" class="log-in-input short-input" readonly /><span class="notes"><a href="https://wpleaderboard.com/" target="_blank">Upgrade to our PRO</a> version now and manage big events.  </span>
											<?php } ?>
									</div>
									<div class="blockCustom">
											<label><?php echo esc_html('Maximum Divisions Allowed:'); ?></label>
											<?php if(get_option('LBD_version')=="PRO"){ echo "<b>Unlimited</b>"; }else{ ?>
											<input type="text" name="max_divisions" value="3" id="max_divisions" class="log-in-input short-input" readonly /><span class="notes"><a href="https://wpleaderboard.com/" target="_blank">Upgrade to our PRO</a> version to add more divisions.  </span>
											<?php } ?>
									</div>                           
								</div>
							</div>
						</div>
					</div>
					<div class="blockCustom">
						<input type="submit" name="save_settings" value="Save Settings" class="log-in-submit" />
					</div>
				</form>
            </div>
        </div>
    </div>
</section>