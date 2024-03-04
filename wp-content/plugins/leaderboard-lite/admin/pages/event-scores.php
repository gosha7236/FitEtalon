<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php 
	global $wpdb;
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	
	$scoreCount = count(LBDgetAllFields($table2));
	
	$score_unit = array("time" =>"Time in hh:mm:ss",
										"kg" => "Weight in kg",
										"lbs" => "Weight in lbs",
										"repetitions" => "Number of Repetitions");
?>
<section class="commen-wraper scorebord-table-block">
    <div class="plugin-container">
        <div class="scorebord-table-main">
		<span class="ResultArea"></span>
            <div id="parentHorizontalTab">
                <ul class="resp-tabs-list hor_1">
                    <li><?php echo esc_html('Scores'); ?></li>
					<li><?php echo esc_html('Add Score'); ?></li>
                </ul>
                <div class="resp-tabs-container hor_1">
                    <div>
						<div class="scorebord-table">
                            <div class="resize-table scoreTable">
							<?php $events = LBDgetAllFields($table4); ?>
							<?php foreach($events as $event){ ?>
								<?php $workouts = LBDgetAllFields($table7,"event_id",$event->id); ?>
								<?php if($workouts){ ?>
									<?php $getEventCount = $wpdb->query("SELECT * FROM ".$table2." WHERE event_id=".$event->id); ?>
										<?php if($getEventCount){ ?>
											<h3 class="section_title">Event Name: <span><?php echo $event->event_name; ?></span></h3>
										<?php } ?>
										<?php foreach($workouts as $workout){ ?>
											<?php $scores = LBDgetAllFields($table2,"workout_id",$workout->id); $i=1;?>
											<?php if($scores){ ?>
												<div class="halfContainer orangeHead" >
													<h3 class="section_title" style="padding:10px 0;"><span><?php echo $workout->workout; ?></span></h3>
													<table class="table-box" border="0" cellpadding="0" cellspacing="0">
														<thead>
															<tr>
																<th>#</th>
																<th><?php echo esc_html('Participant'); ?></th>
																<th><?php echo esc_html('Score'); ?></th>
																<th><?php echo esc_html('Score Unit'); ?></th>
																<th><?php echo esc_html('Added by'); ?></th>
																<th><?php echo esc_html('Action'); ?></th>
															</tr>
														</thead>
														<tbody>
															<?php foreach($scores as $score){ ?>
																<tr>
																	<td><?php echo $i; ?></td>
																	<?php $participant = LBDgetAllFields($table1,"id",$score->participant_id); ?>
																	<?php foreach($participant as $p){ ?>
																		<td><?php echo $p->participant_name; ?></td>
																	<?php } ?>
																	<td><?php echo $score->score; ?></td>
																	<td><?php echo $score_unit[$workout->measurement_unit]; ?></td>
																	<?php $user = get_user_by( 'email',$score->added_by); ?>
																	<td><?php echo $user->display_name; ?></td>
																	<td width="100px;"><span class ="editScore editLink">Edit<input type="hidden" id="score_id" name="score_id" value="<?php echo $score->id;?>" /></span> | <span class="deleteScore deleteLink">Delete<input type="hidden" id="score_id" name="score_id" value="<?php echo $score->id;?>" /></span></td>
																</tr>
															<?php $i++;} ?>
														</tbody>
													</table>
												</div>
											<?php } ?>
										<?php } ?>
									
								<?php } ?>
							<?php } ?>
							<?php if($scoreCount < 1){ ?>
								<?php echo esc_html('No Scores entered!'); ?>
							<?php } ?>
                            </div>
                        </div>
                    </div>
                    <div>
					<?php 
					 $events 		= LBDgetAllFields($table4); 
					 $workouts 	= LBDgetAllFields($table7); 
					 $divisions 	= LBDgetAllFields($table3); 
					 $competitors = LBDgetAllFields($table1); 
					?>
                       <form method="post" id="scoreForm" name="scoreForm" enctype="multipart/form-data">
                        <div class="scorebord-table">
                            <div class="resize-table">
                                <div class="blockCustom">
									<div class="block2_1">
										<label><?php echo esc_html('Event:'); ?></label>
										<select name="event_score_event" id="event_score_event">
											<option value=""><?php echo esc_html('-Select Event-'); ?></option>
											<?php foreach($events as $eve){ ?>
											<option value="<?php echo $eve->id; ?>"><?php echo $eve->event_name; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="block2_1" id="event_score_division_selector">
										<label><?php echo esc_html('Division:'); ?></label>
										<select name="event_score_division" id="event_score_division" disabled>
											<option value=""><?php echo esc_html('-Select Division-'); ?></option>
										</select>
									</div>
								</div>
								<div class="blockCustom">
									<div class="block2_1" id="event_score_workout_selector">
										<label><?php echo esc_html('Workout:'); ?></label>
										<select name="event_score_workout" id="event_score_workout" disabled>
											<option value="">-Select Workout-</option>
										</select>
									</div>
									<div class="block2_1" id="event_score_competitor_selector">
										<label><?php echo esc_html('Competitor:'); ?></label>
										<select name="event_score_competitor" id="event_score_competitor" disabled>
											<option value="">-Select Competitor-</option>
										</select>
									</div>
								</div>
								<div class="blockCustom">
									<div class="block2_1">
										<label><?php echo esc_html('Score:'); ?></label>
										<input type="text" name="event_score" id="event_score" class="log-in-input" style="width:100px;" /><i><span id="score_unit"></span></i>
									</div>
									<div class="block2_1">
										<label><?php echo esc_html('Video:'); ?></label>
										<input type="button" name="event_score_proof_upload" id="event_score_proof_upload" value="Upload" />
										<span id="myplugin-placeholder"></span>
									</div>
								</div>
								<div class="seperator"></div>
								<div class="blockCustom"> 
									<input type="submit" name="add_score" value="Add Score" class="log-in-submit addScore" /> 
								</div>
                            </div>
                        </div>
					</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>