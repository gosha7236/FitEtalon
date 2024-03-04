<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="compititor-regi-main">
	<h3 style="padding-top:25px;"><?php echo esc_html('My Scores'); ?></h3>
	<div class="compititor-regi-cont clearfix">
		<?php 
		$EveScores = LBDgetAllFields($table2,"participant_id", $participant->id);
		$RegEvents = LBDgetAllFields($table6,"participant", $participant->email); 
		?>
		<div class="scorebord-table">
			<div class="resize-table">
			<?php
				$type = (isset($_POST['type']))?sanitize_text_field($_POST['type']):"";
				$pid = (isset($_POST['id']))?sanitize_text_field($_POST['id']):"";
			?>
				<?php if(isset($type) && $type == 'scoreEdit' && $pid != ''){ ?>

				<?php }else{ ?>
					<div class="comn-btn">
						<button id="addScoreBtn" class="Submit-btn"><?php echo esc_html('Add Score'); ?></button>
						<div id="myModal" class="modal">
						  <div class="modal-content">
							<span class="close">&times;</span>
							<form id="addScore" action="" method="post" enctype="multipart/form-data">
							<input type="hidden" name="front-EveScoreParticipant" id="front-EveScoreParticipant" value="<?php echo $participant->id; ?>" />
							<input type="hidden" name="front-EveScoreAddedBy" id="front-EveScoreAddedBy" value="<?php echo $participant->email; ?>" />
							<input type="hidden" name="front-EveScoreDivision" id="front-EveScoreDivision" value="<?php echo $participant->division; ?>" />
							<div class="compititor-regi-cont clearfix">
							<h3 style="text-align:center; background:#e2f3ff; padding:20px;"><?php echo esc_html('Add Score'); ?></h3>
							
								<div class="compititor-regi-left scoreSelect">
									<ul>
										<li class="clearfix">
											<label><?php echo esc_html('Event'); ?> </label>
											<div class="compititor-input">
												<select name="front-EveScoreEvent" id="front-EveScoreEvent" class="compititor-input-box" >
													<option value=""><?php echo esc_html('-- Select Event --'); ?></option>
													<?php foreach($RegEvents as $re){ ?>
													<?php $RegEventData = LBDgetAllFields($table4,"id", $re->event_id);foreach($RegEventData as $red){$rd = $red;}  ?>
													<option value="<?php echo $rd->id; ?>"><?php echo $rd->event_name; ?></option>
													<?php } ?>
												</select>
											</div>
										</li>
										<li class="clearfix">
											<label><?php echo esc_html('Workout'); ?> </label>
											<div class="compititor-input">
											<?php
												$EventWorks = LBDEveWorkoutDivisions($participant->division); 
											?>
												<select name="front-EveScoreWork" id="front-EveScoreWork"  class="compititor-input-box">
													<option value=""><?php echo esc_html('-- Select Workout --'); ?></option>
													<?php foreach($EventWorks as $key=>$val){ ?>
													<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
													<?php } ?>
												</select>
											</div>
										</li>
										<li class="clearfix">
											<label><?php echo esc_html('Score'); ?> </label>
											<div class="compititor-input">
												<input type="text" class="compititor-input-box"  name="front-EveScore" id="front-EveScore" style="width:150px;display:inline-block;">
												<?php $unit = LBDEveWorkoutDivisionUnits(); ?>
												<?php foreach($unit  as $key=>$val){ ?>
													<?php echo '<span id="'.$key.'" style="display:none;" class="divUnit">'.$val.'</span>'; ?>
												<?php } ?>
											</div>
										</li>
										
									</ul>
								</div>
								<div class="compititor-regi-right">
									<ul>
										<li class="clearfix">
											<label><?php echo esc_html('Upload Proofs'); ?> </label>
											<div class="compititor-input">
												<input type="file" name="front-EveScore[]" id="front-EveScore[]" class="bg_checkbox"  multiple >
												<span id="error_block"></span>
											</div>
										</li>
									</ul>
								</div>
								
							</div>
							<div class="centerBlock">
								<input type="submit" name="" value="Submit" class="Submit-btn" id="" />
							</div>
							</form>
						  </div>
						</div>
					</div>
					<?php if($success_score!=""){ echo '<span class="GrnMsgBar">'.$success_score.'</span>';}?>
					<?php if($EveScores){ ?>
						<table class="table-box"  border="0" cellpadding="0" cellspacing="0">
						  <tr class="firstTR">
							<td rowspan="2">#</td>
							<td rowspan="2"><?php echo esc_html('Event Name'); ?></td>
							<td rowspan="2"><?php echo esc_html('Workout'); ?></td>
							<td colspan="2"><?php echo esc_html('Score'); ?></td>
							<td rowspan="2"><?php echo esc_html('Modified date'); ?></td>
							<td rowspan="2"><?php echo esc_html('Action'); ?></td>
						  </tr>
						  <tr class="firstTR">
						  </tr>
						 <?php $i =1; ?>
						<?php foreach($EveScores as $score){ ?>
							<?php
							$allEvents = LBDgetAllFields($table4,"id",$score->event_id);
							foreach($allEvents as $event){$eveData = $event;}
							$allWorkouts = LBDgetAllFields($table7,"id",$score->workout_id);
							foreach($allWorkouts as $workout){$workoutData = $workout;}
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><a href="<?php echo get_permalink($EventsPage)."?id=".$score->event_id; ?>" target="_blank"><?php echo $eveData->event_name; ?></a></td>
								<td><?php echo $workoutData->workout; ?></td>
								<td colspan="2"><?php echo $score->score; ?></td>
								<td><?php echo date("dS M, Y", strtotime($score->modified_date));  ?></td>
								<td><?php /*?><a href="<?php echo get_permalink($my_account); ?>?scores=active&type=scoreEdit&id=<?php echo $score->id; ?>" class="editScore editLink">Edit</a> | <?php */?><a href="<?php echo get_permalink($LeaderBoard_eventMyAccount); ?>?scores=active&type=scoreDelete&id=<?php echo $score->id; ?>" class="deleteScore deleteLink"><?php echo esc_html('Delete'); ?></a></td>
							</tr>
						<?php $i++;} ?>
						</table>
					<?php }else{?>
						<?php echo esc_html('No score entries Found !'); ?>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>