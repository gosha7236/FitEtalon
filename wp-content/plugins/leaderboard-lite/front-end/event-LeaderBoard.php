<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php 
	get_header(); 
	global $wpdb;
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	$table8 = $wpdb->prefix . "lbd_event_registration_transaction"; 
	
	$my_account   = get_option('LeaderBoard_eventMyAccount');
	$payment_url  = get_option('LeaderBoard_Payment');
	$eventList		  = get_option('LeaderBoard_eventspage');	
	$eventLeaderBoard = get_option('Event_LeaderBoard');
	$id 					= sanitize_text_field($_GET['id']);

	if(isset($id) && $id != ''){ 
		$CurrentEvent 	= LBDgetAllFields($table4,"id", $id); 
		$Divisions 			= LBDgetAllFields($table3,"event_id", $id); 
		$Workouts 		= LBDgetAllFields($table7,"event_id", $id); 
		foreach($CurrentEvent as $CurrentEve){$eve =$CurrentEve; }
		?>
		<section class="commen-wraper score-bord-top-block">
			<div class="plugin-container">
				<div class="score-bord-top-main">
					<?php if($eve->image){ ?>
					<span class="score-bord-top-img"><img class="img-resize" src="<?php echo $eve->image; ?>" alt=""></span>
					<?php } ?>
					<h3><?php echo $eve->event_name; ?></h3>
					<span class="live-now"><?php echo esc_html('Live Now'); ?></span>
					<?php echo $eve->description; ?>
				</div>
			</div><!-- plugin-container -->
		</section>
		
		<section class="commen-wraper scorebord-table-block">
			<div class="plugin-container">
				<div class="scorebord-table-main">
					<div id="parentHorizontalTab">
						<ul class="resp-tabs-list hor_1">
						<?php foreach($Workouts as $workout){ ?>
							<li><?php echo $workout->workout; ?></li>
						<?php } ?>
						</ul>
						<div class="resp-tabs-container hor_1">
						<?php foreach($Workouts as $workout){ ?>
							<div>
								<?php
								if($workout->measurement_unit == 'time'){
									$orderBy = " order by t2.score ASC";
								}else if($workout->measurement_unit == 'lbs' || $workout->measurement_unit == 'kg'){
									$orderBy = "ORDER BY LENGTH(t2.score) DESC, t2.score DESC";
								}else if($workout->measurement_unit == 'repetitions' ){
									$orderBy = " order by t2.score DESC";
								}
								
								$scores = $wpdb->get_results( "SELECT t1.id,t2.id as score_id,t1.participant_name,t2.workout_id, t2.score FROM ". $table1 ." as t1 INNER JOIN ".$table2." as t2 ON t1.id=t2.participant_id WHERE t2.event_id = ".$id." AND t2.workout_id  = ".$workout->id." ".$orderBy); 
								$lb = array();
								foreach($scores as $score){
									$lb[$score->id]['participant'] = $score->participant_name;
									$lb[$score->id]['score'] = $score->score;
									if($workout->measurement_unit == 'time'){
										$lb[$score->id]['scoreInsec'] = strtotime($score->score);
										$lb = LBDmsort($lb, array('scoreInsec'));
									}else{
										$lb[$score->id]['scoreInsec'] = $score->score;
									}
								}
								?>
								<div class="scorebord-table">
									<div class="resize-table">
									<?php if($scores){?>
										<table class="table-box"  border="0" cellpadding="0" cellspacing="0">
											<thead>
												<tr>
													<th rowspan="2">#</th>
													<th rowspan="2"><?php echo esc_html('Participant'); ?></th>
													<th rowspan="2"><?php echo esc_html('Score'); ?> <span style="font-weight:normal;"><i>( Unit : <?php echo ucwords($workout->measurement_unit); ?>)</i></span></th>
												</tr>
											</thead>
											<tbody>
												<?php $cnt = 1; ?>
												<?php foreach($lb as $score){  ?>
													<tr>
														<td><?php echo $cnt; $cnt++; ?></td>
														<td><?php echo $score['participant']; ?></td>
														<td>
														<?php 
														if($workout->measurement_unit == 'time'){
															echo gmdate("H:i:s", strtotime($score['score'])); 
														}else{
															echo $score['score'];
														}
														?>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									<?php }else{ ?>
										<div style="padding:20px;"><?php echo esc_html('No data available right now!'); ?></div>
									<?php } ?>
									</div>
								</div>
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
			</div><!-- plugin-container -->
		</section>  
	<?php }else{ ?>
			<section class="commen-wraper events-results-top-block">
				<div class="plugin-container">
					<div class="events-results-top-main">
						<h3><?php echo esc_html('Please choose an Event to see the LeaderBoard'); ?> 
						<?php $allEvents = LBDgetAllFields($table4); ?>
						<select name="chooseEvent" id="chooseEvent">
							<option value=""><?php echo esc_html('--Select Event --'); ?></option>
							<?php foreach($allEvents as $events){ ?>
							<option value="<?php echo $events->id; ?>"><?php echo $events->event_name; ?></option>
							<?php } ?>
						</select>
						</h3>
					</div>
				</div><!-- plugin-container -->
			</section>
	<?php } ?>
	<script type="text/javascript">
		var x=jQuery.noConflict();
		x('#chooseEvent').on('change', function (e) {
			var optionSelected = x("option:selected", this);
			var valueSelected = this.value;
			if(valueSelected != ''){
				window.location.href = '<?php echo get_permalink($eventLeaderBoard); ?>?id='+valueSelected;
			}
		});
	</script>
<?php get_footer(); ?>