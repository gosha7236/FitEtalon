<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php get_header(); ?>
<?php global $wpdb, $post; ?>
<?php
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
	$LeaderBoard_eventUserLogin 				= get_option('LeaderBoard_eventUserLogin');
	$LeaderBoard_eventspage 						= get_option('LeaderBoard_eventspage');
	$LeaderBoard_eventRegistrationpage 	= get_option('LeaderBoard_eventRegistrationpage');
	$LeaderBoard_eventMyAccount 				= get_option('LeaderBoard_eventMyAccount');
	$LeaderBoard_Payment 							= get_option('LeaderBoard_Payment');
	$LeaderBoard_eventRegistrationpage 	= get_option('LeaderBoard_eventRegistrationpage');
	$LeaderBoard_eventUserRegistration 	= get_option('LeaderBoard_eventUserRegistration');
	$Event_LeaderBoard 									= get_option('Event_LeaderBoard');
	
	extract($_REQUEST);
?>
<?php if(isset($id)){ ?>
	<?php $getEvent = LBDgetAllFields($table4,"id",$id); foreach($getEvent as $event){$eve = $event;} ?>
	<section class="commen-wraper events-results-top-block">
		<div class="plugin-container">
			<div class="events-details-top-main">
				<div class="events-details-top-left">
					<div style="float:left">
						<span class="events-details-top-icon">
							<?php if($eve->image){ ?>
								<img class="img-resize" src="<?php echo $eve->image; ?>" alt="">
							<?php }else{ ?>
								<img class="img-resize" src="<?php echo plugins_url( '/LeaderBoard/img/placeholder.png'); ?>" alt="">
							<?php } ?>
						</span>
					</div>
					<div>
						<h3><?php echo $eve->event_name; ?></h3>
						<p>
						<?php 
						$competitions = LBDgetAllFields($table5,"id",$eve->event_competition); 
						foreach($competitions as $com){
							echo $com->competition_name." ";
						}
						?>
						</p>
					</div>
				</div>
				<div class="events-details-top-right">
				<?php 
				if(is_user_logged_in()){ 
					$redirect_to = get_option('LeaderBoard_eventRegistrationpage');
				}else{ 
					$redirect_to = get_option('LeaderBoard_eventUserLogin');
				} 
				$transData = array();
				$regData = array();
				
				$d=strtotime("now");
				if(strtotime($eve->endof_reg_date.' '.$eve->endof_reg_time) > strtotime(date("Y-m-d h:ia", $d))){
					$current_user = wp_get_current_user();
						$getRegistrationDetails = LBDgetAllFields($table6,"participant",$current_user->user_email); //Get registration details
						foreach($getRegistrationDetails as $rd){
							$regData = $rd;
						}
						if($regData){
							$getTransactionDetails = LBDgetAllFields($table8,"id",$regData->transaction_id); //Get transaction details
							foreach($getTransactionDetails as $td){
								$transData = $td;
							}
						}
				?>
					<ul>
						<li>
							<?php if(is_user_logged_in() && $transData->payment_status=="succeeded"){ //already registered ?>
								<a class="reg-now-btn" style="background:red;">Already Registered</a>
							<?php }else{ ?>
								<a href="<?php echo get_permalink($redirect_to)."?id=".$eve->id; ?>" class="reg-now-btn"><?php echo esc_html('Register Now'); ?></a>
							<?php } ?>
						</li>
						<li>
							<span class="reg-now-amount"><?php echo $eve->fee." ".$eve->currency; ?></span>
						</li>
					</ul>
				<?php }else{echo '<a class="reg-now-btn" style="background:red;">Registration Closed</a>';} ?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div><!-- plugin-container -->
	</section> 
		
	<section class="commen-wraper events-details-block">
		<div class="events-details-top-block">
			<div id="parentHorizontalTab">
				<div class="events-details-tabs">
					<div class="plugin-container">
						<ul class="resp-tabs-list hor_1">
							<li><?php echo esc_html('Events Details'); ?></li>
							<li><?php echo esc_html('Workouts'); ?></li>
						</ul>
					</div>
				</div>
				<div class="resp-tabs-container hor_1">
					<div>
						<div class="plugin-container">
							<div class="details-tabs-content">
								<div class="details-tabs-left">
									<div class="details-tabs-left-div">
										<?php echo apply_filters('the_content',$eve->description); ?>
									</div><!-- details-tabs-left-div -->
								</div>
								<div class="details-tabs-right">
									<div class="details-tabs-right-top">
										<ul>
											<li><i class="fa fa-calendar-check-o" aria-hidden="true"></i> <?php echo date("M d, Y",strtotime($eve->from_date)); ?> - <?php echo date("M d, Y",strtotime($eve->to_date)); ?></li>
											<li><i class="fa fa-clock-o" aria-hidden="true"></i> From <?php echo date("M d, Y",strtotime($eve->from_time)); ?> UTC</li>
										</ul>
									</div>
									<?php if($eve->website){ ?>
									<div class="details-tabs-right-sec">
										<h5><?php echo esc_html('Website'); ?></h5>
										<a href="<?php echo $eve->website; ?>" target="_blank"><?php echo $eve->website; ?></a>
									</div>
									<?php } ?>
									<div class="details-tabs-right-sec">
										<ul>
											<li><span><?php echo esc_html('Venue'); ?></span> :  <?php echo $eve->address; ?></li>
											<li><span><?php echo esc_html('Location'); ?></span> :  <?php echo $eve->city.", ".$eve->country; ?></li>
										</ul>
									</div>
									<div class="details-tabs-right-map">
										<?php if($eve->latitude && $eve->longitude){ ?>
										<iframe frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=<?php echo $eve->latitude;?>,<?php echo $eve->longitude;?>&key=AIzaSyDHDkqQ79nsncjlkeofkkADsn-Ko13PNr4"></iframe>
										<?php } ?>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
					<div>
						<div class="plugin-container">
							<?php 
							$getWorkouts = LBDgetAllFields($table7,"event_id",$eve->id); 
							if($getWorkouts){ 
								foreach($getWorkouts as $workout){
								?>
								<div class="eventWorkout_list" style="background:#33333314; padding:20px; margin:20px;;">
									<h5 style="font-size:18px; color: #00005D;"><?php echo $workout->workout; ?></h5>
									<p><?php echo $workout->details; ?></p>
									<span style="font-size:14px;">
									<?php 
									$divs = explode(",",$workout->divisions); 
									$divisions = $wpdb->get_results( "SELECT * FROM ". $table3 ." WHERE id IN ('".$workout->divisions."')" ); 
									if($divisions){
										echo '<b>Divisions: </b>';
										foreach($divisions as $d){
											echo $d->division_name.' , ';
										}
									}
									?>
									</span>
								</div>
								<?php
								} 
							}else{
								echo esc_html('No Workouts found!');
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="events-details-bottom-block">
		</div>
	</section>
<?php }else{ ?>
	<section class="commen-wraper events-results-top-block">
		<div class="plugin-container">
			<div class="events-results-top-main">
				<h3><?php echo esc_html('Find your next competition'); ?></h3>
				<div class="events-results-div"><input type="text" class="vents-results-input" placeholder="Search events"></div>
			</div>
		</div><!-- plugin-container -->
	</section>  
	<?php
		$LiveEvents	= array();
		$UpcomingEvents = array();
		$PastEvents = array();
		
		foreach($allEvents as $event){ 
			$d=strtotime("now");
			if(strtotime(date("Y-m-d h:ia", $d)) > strtotime($event->from_date.' '.$event->from_time) &&
				strtotime(date("Y-m-d h:ia", $d)) < strtotime($event->to_date.' '.$event->to_time) ){ // Live events
				$LiveEvents[] = $event;
			}else if(strtotime(date("Y-m-d h:ia", $d)) < strtotime($event->from_date.' '.$event->from_time) &&
				strtotime(date("Y-m-d h:ia", $d)) < strtotime($event->to_date.' '.$event->to_time)){//Upcoming Events
				$UpcomingEvents[] = $event;
			}else if(strtotime(date("Y-m-d h:ia", $d)) > strtotime($event->from_date.' '.$event->from_time) &&
				strtotime(date("Y-m-d h:ia", $d)) > strtotime($event->to_date.' '.$event->to_time)){//Past Events
				$PastEvents[] = $event;
			}
		} 
	?>
	<section class="commen-wraper events-tab-block">
		<div id="parentHorizontalTab">
			<ul class="resp-tabs-list hor_1">
				<li><?php echo esc_html('Live Events'); ?></li>
				<li><?php echo esc_html('Upcoming Events'); ?></li>
				<li><?php echo esc_html('Past Events'); ?></li>
			</ul>
			<div class="resp-tabs-container hor_1">
				<div>
					<div class="commen-wraper events-listing-block">
						<ul>
							<?php if($LiveEvents){ ?>
								<?php foreach($LiveEvents as $event){ ?>
									<li>
										<div class="plugin-container">
											<div class="events-listing-main">
												<span class="events-listing-span">
													<?php if($event->image){ ?>
														<img class="img-resize" src="<?php echo $event->image; ?>" alt="">
													<?php }else{ ?>
														<img class="img-resize" src="<?php echo plugins_url( '/LeaderBoard/img/placeholder.png'); ?>" alt="">
													<?php } ?>
												</span>
												<div class="events-listing-top">
													<h3><a href="<?php echo get_permalink($LeaderBoard_eventspage)?>?id=<?php echo $event->id; ?>"><?php echo $event->event_name; ?></a></h3>
													<p><?php echo date("M d, Y",strtotime($event->from_date)); ?></p>
													<a href="<?php echo get_permalink($Event_LeaderBoard); ?>?id=<?php echo $event->id; ?>" class="leader-bord-btn">Leaderboard</a>
												</div>
												<div class="events-listing-bottom">
													<p><?php echo LBD_Limit_Letters($event->description,300); ?></p>
												</div>
											</div>
										</div><!-- plugin-container -->
									</li>
								<?php } ?>
							<?php }else{ ?>
								<li>
									<div class="plugin-container">
										<?php echo esc_html('No Events running now.'); ?>
									</div>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div>
					<div class="commen-wraper events-listing-block">
						<ul>
							<?php if($UpcomingEvents){ ?>
								<?php foreach($UpcomingEvents as $event){ ?>
									<li>
										<div class="plugin-container">
											<div class="events-listing-main">
												<span class="events-listing-span">
													<?php if($event->image){ ?>
														<img class="img-resize" src="<?php echo $event->image; ?>" alt="">
													<?php }else{ ?>
														<img class="img-resize" src="<?php echo plugins_url( '/LeaderBoard/img/placeholder.png'); ?>" alt="">
													<?php } ?>
												</span>
												<div class="events-listing-top">
													<h3><a href="<?php echo get_permalink($LeaderBoard_eventspage)?>?id=<?php echo $event->id; ?>"><?php echo $event->event_name; ?></a></h3>
													<p><?php echo date("M d, Y",strtotime($event->from_date)); ?></p>
													<a href="<?php echo get_permalink($Event_LeaderBoard); ?>?id=<?php echo $event->id; ?>" class="leader-bord-btn">Leaderboard</a>
												</div>
												<div class="events-listing-bottom">
													<p><?php echo LBD_Limit_Letters($event->description,300); ?></p>
												</div>
											</div>
										</div><!-- plugin-container -->
									</li>
								<?php } ?>
							<?php }else{ ?>
								<li>
									<div class="plugin-container">
										<?php echo esc_html('No Upcoming Events scheduled.'); ?>
									</div>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div>
					<div class="commen-wraper events-listing-block">
						<ul>
							<?php if($PastEvents){ ?>
								<?php foreach($PastEvents as $event){ ?>
									<li>
										<div class="plugin-container">
											<div class="events-listing-main">
												<span class="events-listing-span">
													<?php if($event->image){ ?>
														<img class="img-resize" src="<?php echo $event->image; ?>" alt="">
													<?php }else{ ?>
														<img class="img-resize" src="<?php echo plugins_url( '/LeaderBoard/img/placeholder.png'); ?>" alt="">
													<?php } ?>
												</span>
												<div class="events-listing-top">
													<h3><a href="<?php echo get_permalink($LeaderBoard_eventspage)?>?id=<?php echo $event->id; ?>"><?php echo $event->event_name; ?></a></h3>
													<p><?php echo date("M d, Y",strtotime($event->from_date)); ?></p>
													<a href="<?php echo get_permalink($Event_LeaderBoard); ?>?id=<?php echo $event->id; ?>" class="leader-bord-btn">Leaderboard</a>
												</div>
												<div class="events-listing-bottom">
													<p><?php echo LBD_Limit_Letters($event->description,300); ?></p>
												</div>
											</div>
										</div><!-- plugin-container -->
									</li>
								<?php } ?>
							<?php }else{ ?>
								<li>
									<div class="plugin-container">
										<?php echo esc_html('No Events in the past.'); ?>
									</div>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>
<?php get_footer(); ?>