<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
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
	
	 if(!current_user_can('event_participant')){//Logout
	 	wp_logout();
	 }
	
	if(!is_user_logged_in()){
		wp_redirect(get_permalink($LeaderBoard_eventUserLogin));exit;
	}

	get_header(); 

	$options = get_option('LeaderBoardSettings');
	$successMsg = "";
	$success_score = "";

	extract($_REQUEST);
	
	$UpdateEveCompetitor = (isset($_POST['UpdateEveCompetitor']))?sanitize_text_field($_POST['UpdateEveCompetitor']):"";
	$participant_name = (isset($_POST['participant_name']))?sanitize_text_field($_POST['participant_name']):"";

if(is_user_logged_in()){ 
	/******************************** Update Competitor Info ****************************/
	if(isset($UpdateEveCompetitor) && $UpdateEveCompetitor=="Update Info"){
		extract($_POST);
		//Update WP user details
		$user = wp_get_current_user();
		if($user->ID && $participant_name!=''){
			wp_update_user( array(
				'ID' => $user->ID,
				'display_name' => $participant_name
		   ) );
	   }
		//Update Event LeaderBoard user details
		$sql  = 'UPDATE '.$table1.'  SET participant_name="'.$participant_name.'", dob="'.$participant_dob.'", age='.$participant_age.', gender="'.$participant_gender.'", phonenum='.$participant_phonenum.', address="'.$participant_address.'" WHERE id = '.$participant_id; 
		dbDelta( $sql );
		$successMsg = esc_html("Profile updated!");
	}							
	/******************************Save Score Block*******************************/
	$pid = (isset($_POST['id']))?sanitize_text_field($_POST['id']):"";
	
	 if( 'POST' == $_SERVER['REQUEST_METHOD']  ) {
			$files = (!empty($_FILES["front-EveScore"]))?$_FILES["front-EveScore"]:array("name"=> "");  
			/*if($files['name']!=""){
				$fileInfo = wp_check_filetype(basename($files['name']));
			}else{
				$fileInfo = array();
			}*/
			//print_r($files);
			$newupload = array();
			
			if (!empty($files)) { //echo "<pre>"; print_r($files); echo "</pre>";
				foreach ($files['name'] as $key => $value) {     
					 $fileInfo = wp_check_filetype($files['name'][$key]);   // echo "<pre>".$files['tmp_name'][$key]; print_r($fileInfo); echo "</pre>";  
					if ($files['name'][$key] && !empty($fileInfo['ext'])) { 
						$file = array( 
							'name' => $files['name'][$key],
							'type' => $files['type'][$key], 
							'tmp_name' => $files['tmp_name'][$key], 
							'error' => $files['error'][$key],
							'size' => $files['size'][$key]
						); 
						$FILES = array ("front-EveScore" => $file); 
						foreach ($FILES as $file => $array) {              
							$newupload[] = LBD_handle_attachment($file,$pid); 
						}
					} 
				} 
			} else {
				$newupload = array();
			}
			
			$files = ($newupload)?implode(",",$newupload):"";
			//echo "<pre>"; print_r($newupload); echo "</pre>";
			//echo "<pre>"; print_r($files); echo "</pre>";
			//echo $files;
			
			$data=array(
				'id' 						=> NULL,
				'participant_id' 	=> (isset($_POST['front-EveScoreParticipant']))?sanitize_text_field($_POST['front-EveScoreParticipant']):"",
				'event_id' 			=> (isset($_POST['front-EveScoreEvent']))?sanitize_text_field($_POST['front-EveScoreEvent']):"", 
				'workout_id'		=> (isset($_POST['front-EveScoreWork']))?sanitize_text_field($_POST['front-EveScoreWork']):"",
				'division_id'		=> (isset($_POST['front-EveScoreDivision']))?$_POST['front-EveScoreDivision']:"", 
				'modified_date' => date("Y-m-d"),
				'added_by' 		=> (isset($_POST['front-EveScoreAddedBy']))?sanitize_text_field($_POST['front-EveScoreAddedBy']):"",
				'score' 				=> (isset($_POST['front-EveScore']))?sanitize_text_field($_POST['front-EveScore']):"", 
				'proof' 					=> $files
			 );
	
		 $wpdb->insert( $table2, $data);
		 $lastid = $wpdb->insert_id;
		 if($lastid){$success_score = esc_html("Score added succesfully");}else{$success_score = '';}
		}
	/******************************End of Save Score Block*******************************/
	/************* Delete score *************/
	$type 		= (isset($_GET['type']))?sanitize_text_field($_GET['type']):"";
	$id 			= (isset($_GET['id']))?sanitize_text_field($_GET['id']):"";
	if($type=="scoreDelete" && $id != ''){
		if($wpdb->delete( $table2, array( 'id' => $id ) )){
			$success_score = esc_html("Score deleted successfully");
		}
	}
	/************************************************/
	$current_user = wp_get_current_user(); 
	$participants = $wpdb->get_results( "SELECT * FROM ". $table1 ." WHERE email ='".$current_user->user_email."'"); //echo "<pre>"; print_r($participants); echo "</pre>";
	foreach($participants as $usr){
		$participantID = $usr->id;
		$participantStatus = $usr->payment_status;//Payment status
		$participantRegFee = $usr->registration_fee;//Registration Fee
		$participant = $usr;
	}
	?>
	<section class="commen-wraper compititor-block <?php if($participantStatus == "pending" && $participantRegFee > 0){ echo esc_html('nonActive_user');} ?>">
		<div class="plugin-container">
			<div class="compititor-main">
				<?php 
					$action			= (isset($_GET['action']))?sanitize_text_field($_GET['action']):"";
					$my_profile	= (isset($_GET['my-profile']))?sanitize_text_field($_GET['my-profile']):""; 
					$my_events	= (isset($_GET['my-events']))?sanitize_text_field($_GET['my-events']):""; 
					$scores			= (isset($_GET['scores']))?sanitize_text_field($_GET['scores']):""; 
					$proofs			= (isset($_GET['proofs']))?sanitize_text_field($_GET['proofs']):""; 
				?>
				<?php if($action=="complete_payment"){ ?>
					<?php require_once(dirname(__FILE__) .'/my-account/complete_payment.php'); ?>
				<?php }else{ ?>
					<div class="compititor-left">
						<ul>
							<li><a href="<?php echo get_permalink($LeaderBoard_eventMyAccount); ?>" class="homeBtn"><?php echo esc_html('Home'); ?></a></li>
							<li><a href="?my-profile=active"><img class="img-resize" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/acco-icon-1.jpg" alt=""> <?php echo esc_html('My Profile'); ?></a></li>
							<li><a href="?my-events=active"><img class="img-resize" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/acco-icon-2.jpg" alt=""><?php echo esc_html(' Events'); ?></a></li>
							<li><a href="?scores=active"><img class="img-resize" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/acco-icon-3.jpg" alt=""> <?php echo esc_html('Scores'); ?></a></li>
							<li><a href="?proofs=active"><img class="img-resize" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/acco-icon-4.jpg" alt=""> <?php echo esc_html('Proofs'); ?></a></li>
						</ul>
					</div>
					<div class="compititor-right">
						<div class="compititor-right-top">
							<?php if($participantStatus == "pending" && $participantRegFee > 0){ ?>
								<div class="payNotif"><?php echo esc_html('Complete payment and activate your account'); ?> <a href="<?php echo get_permalink($LeaderBoard_eventMyAccount); ?>?action=complete_payment" class="common-btn"><?php echo esc_html('Pay now!'); ?></a></div>
							<?php } ?>
							<div class="payNotif"><?php echo esc_html('Logged in as'); ?> <b><?php echo $participant->participant_name; ?></b></div><a href="<?php echo wp_logout_url( get_permalink($LeaderBoard_eventUserLogin) ); ?>" class="log-out"><img class="img-resize" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/log-out.png" alt=""> Log Out</a>						
						</div>
						
						<?php if($my_profile){ ?>
							<?php require_once(dirname(__FILE__) .'/my-account/event_my_profile.php'); ?>
						<?php }else if($my_events){ ?>
							<?php require_once(dirname(__FILE__) .'/my-account/event_my_events.php'); ?>
						<?php }else if($scores){ ?>
							<?php require_once(dirname(__FILE__) .'/my-account/event_my_scores.php'); ?>
						<?php }else if($proofs){ ?>
							<?php require_once(dirname(__FILE__) .'/my-account/event_my_proofs.php'); ?>
						<?php }else{ ?>
						<div class="compititor-right-cont">
							<h3><?php echo esc_html('Welcome to the Dashboard'); ?></h3>
							<ul>
								<li><a href="?my-profile=active"><?php echo esc_html('Edit Profile'); ?></a></li>
								<li><a href="<?php echo get_permalink($LeaderBoard_eventspage); ?>" target="_blank"><?php echo esc_html('Register an Event'); ?></a></li>
								<li><a href="?scores=active"><?php echo esc_html('Add Scores'); ?></a></li>
							</ul>
						</div>
						<?php } ?>
					</div>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>

<?php }else{ ?>
	<?php echo esc_html(' Please login into the admin side of LeaderBoard..'); ?>
<?php } ?>
<?php get_footer(); ?>