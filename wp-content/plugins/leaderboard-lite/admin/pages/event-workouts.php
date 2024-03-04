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
?>
<section class="commen-wraper scorebord-table-block">
    <div class="plugin-container">
        <div class="scorebord-table-main">
		<span class="ResultArea"></span>
            <div id="parentHorizontalTab">
                <ul class="resp-tabs-list hor_1">
                    <li><?php echo esc_html('Workouts'); ?></li>
					<li><?php echo esc_html('Add Workout'); ?></li>
                </ul>
                <div class="resp-tabs-container hor_1">
                    <div>
						<div class="scorebord-table">
                            <div class="resize-table workoutTable">
							<?php $events = LBDgetAllFields($table4); ?>
							<?php foreach($events as $eve){ ?>
								<?php $workouts = LBDgetAllFields($table7,"event_id",$eve->id); $i=1;?>
								<?php if($workouts){ ?>
									<h3 class="section_title">Event Name: <span><?php echo $eve->event_name; ?></span></h3>
									<table class="table-box" border="0" cellpadding="0" cellspacing="0">
										<thead>
											<tr>
												<th>#</th>
												<th><?php echo esc_html('Workout'); ?></th>
												<th><?php echo esc_html('Divisions'); ?></th>
												<th><?php echo esc_html('Details'); ?></th>
												<th><?php echo esc_html('Action'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($workouts as $workout){ ?>
												<tr>
													<td><?php echo $i; ?></td>
													<td><?php echo $workout->workout; ?></td>
													<?php
													$divisions = $wpdb->get_results("SELECT division_name FROM ".$table3." WHERE id IN(".$workout->divisions.")");
													$c = 1;
													?>
													<td style="padding:8px 0;">
													<ul>
													<?php foreach($divisions as $div){ ?>
													<li <?php if(count($divisions)>1 && count($divisions)!= $c){ echo 'style="border-bottom:2px solid #dfeaf3;"';}else{}?>><?php echo $div->division_name; ?></li>
													<?php $c++;} ?>
													</ul>
													</td>
													<td><?php echo $workout->details; ?></td>
													<td width="130px"><span class ="editWorkout editLink">Edit<input type="hidden" id="workout_id" name="workout_id" value="<?php echo $workout->id;?>" /></span> | <span class="deleteWorkout deleteLink">Delete<input type="hidden" id="workout_id" name="workout_id" value="<?php echo $workout->id;?>" /></span></td>
												</tr>
											<?php $i++;} ?>
										</tbody>
									</table>
								<?php }else{ ?>
									<?php echo esc_html('No Workouts added'); ?>
								<?php } ?>
							<?php } ?>
                            </div>
                        </div>
                    </div>
                    <div>
                       <form method="post" id="workoutForm" name="workoutForm">
                        <div class="scorebord-table">
                            <div class="resize-table">
							
								<h3><?php echo esc_html('Workout Info:'); ?></h3>
                                <div class="blockCustom">
										<label><?php echo esc_html('Workout Name:'); ?></label><input type="text" name="event_workout_name" value="" id="event_workout_name" class="log-in-input" />
								</div>
								<div class="blockCustom">
									<div class="block2_1">
										<label><?php echo esc_html('For Event:'); ?></label>
										<?php $events = LBDgetAllFields($table4); ?>
										<select name="event_workout_event" id="event_workout_event" >
											<option value="">-Select Event-</option>
											<?php foreach($events as $event){ ?>
											<option value="<?php echo $event->id; ?>"><?php echo $event->event_name; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="block2_1" id="available_divisions">
										
									</div>
								</div>
								
								<div class="seperator"></div>
								
								<h3><?php echo esc_html('Details'); ?></h3>
								<div class="blockCustom"> 
									<label><?php echo esc_html('Workout Details:'); ?></label>
									<?php 
									$editor_id = 'event_workout_desc';
									$event_workout_desc = "";
									wp_editor( $event_workout_desc, $editor_id );
									?>
								</div>
								<div class="blockCustom">
									<label><?php echo esc_html('Measurement unit:'); ?></label>
									<?php $munit = array("time"=>"Time in hh:mm:ss","kg"=>"Weight in kg","lbs"=>"Weight in lbs","repetitions"=>"Number of Repetitions"); ?>
									<select name="event_workout_unit" id="event_workout_unit" >
										<option value="">--Select Unit--</option>
										<?php foreach($munit as $u=>$val){ ?>
										<option value="<?php echo $u; ?>"><?php echo $val; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="blockCustom"> 
										<label><?php echo esc_html('Workout Status?:'); ?> </label><input type="checkbox" name="event_workout_enable" id="event_workout_enable"  />
								</div>
							
								<div class="seperator"></div>
								
								<div class="blockCustom"> 
									<input type="submit" name="add_workout" value="Add Workout" class="log-in-submit addWorkout" /> 
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