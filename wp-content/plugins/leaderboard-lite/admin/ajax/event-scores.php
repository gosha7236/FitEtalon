<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
///////////////////////////////////////////////////////////////////Ajax Calls///////////////////////////////////////////////////////////////////////////
/******************************* Score Workout selector  lbd_event_workout_measurement_unit ********************************/ 
add_action( 'wp_ajax_lbd_event_workout_measurement_unit', 'lbd_event_workout_measurement_unit_callback' );
add_action( 'wp_ajax_nopriv_lbd_event_workout_measurement_unit', 'lbd_event_workout_measurement_unit_callback' );
function lbd_event_workout_measurement_unit_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table7 = $wpdb->prefix . "lbd_event_workouts";

	$workout_id = sanitize_text_field($_POST['workout_id']);

	if($workout_id != ''){
		$workouts = LBDgetAllFields($table7,'id',$workout_id);
		if($workouts){
			foreach($workouts as $w){ 
				if($w->measurement_unit ==  "time"){ 
					echo "Time in hh:mm:ss";
				}else if($w->measurement_unit == "kg"){
					echo "Weight in kg";
				}else if($w->measurement_unit == "lbs"){ 
					echo "Weight in lbs";
				}else if($w->measurement_unit == "repetitions"){ 
					echo "Number of Repetitions";
				}else{
					echo "";
				}
			} 
		}else{
			//echo '<span style="color:red; font-weight:bold;">No Division is availabe for the selection. Please add/assign division first.</span>';
		}
	}else{
		echo '0';
	}
	wp_die();
}
/******************************* Score selector ********************************/ 
add_action( 'wp_ajax_lbd_event_score_division', 'lbd_event_score_division_callback' );
add_action( 'wp_ajax_nopriv_lbd_event_score_division', 'lbd_event_score_division_callback' );
function lbd_event_score_division_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts";

	$event_id = sanitize_text_field($_POST['event_id']);

	if($event_id != ''){
		$divisions = LBDgetAllFields($table3,'event_id',$event_id);
		if($divisions){
			echo '<label>Division:</label>';
			echo '<select name="event_score_division" id="event_score_division" >';
			echo '<option value="">-Select Division-</option>';
			foreach($divisions as $div){ 
				echo '<option value="'.$div->id.'">'.$div->division_name.'</option>';
			} 
			echo '</select>'; 
		}else{
			echo '<span style="color:red; font-weight:bold;">No Division is availabe for the selection. Please add/assign division first.</span>';
		}
	}else{
		echo '0';
	}
	wp_die();
}
////////
add_action( 'wp_ajax_lbd_event_score_workout', 'lbd_event_score_workout_callback' );
add_action( 'wp_ajax_nopriv_lbd_event_score_workout', 'lbd_event_score_workout_callback' );
function lbd_event_score_workout_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts";

	$event_id = sanitize_text_field($_POST['event_id']);
	$division = sanitize_text_field($_POST['division']);

	if($event_id != '' & $division != ""){
		$workouts = $wpdb->get_results( "SELECT * FROM ". $table7 ." WHERE event_id=".$event_id." AND divisions LIKE '%".$division."%' " );
		if($workouts){
			echo '<label>Workout:</label>';
			echo '<select name="event_score_workout" id="event_score_workout" >';
			echo '<option value="">--Select Workout--</option>';
			foreach($workouts as $work){ 
				echo '<option value="'.$work->id.'">'.$work->workout.'</option>';
			} 
			echo '</select>'; 
		}else{
			echo '<span style="color:red; font-weight:bold;">No Workout is availabe for the selection</span>';
		}
	}else{
		echo '0';
	}
	wp_die();
}
////////
add_action( 'wp_ajax_lbd_event_score_competitor', 'lbd_event_score_competitor_callback' );
add_action( 'wp_ajax_nopriv_lbd_event_score_competitor', 'lbd_event_score_competitor_callback' );
function lbd_event_score_competitor_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	
	$division = sanitize_text_field($_POST['division']);
	if($division != ""){
		$competitors = LBDgetAllFields($table1,"division",$division); 
		if($competitors){
			echo '<label>Competitor:</label>';
			echo '<select name="event_score_competitor" id="event_score_competitor" >';
			echo '<option value="">--Select Competitor--</option>';
			foreach($competitors as $com){ 
				echo '<option value="'.$com->id.'">'.$com->participant_name.'</option>';
			} 
			echo '</select>'; 
		}else{
			echo '<span style="color:red; font-weight:bold;">No Competitor is availabe for the selection</span>';
		}
	}else{
		echo '0';
	}

	wp_die();
}

/**********************************************  Add Score  ************************************************/
add_action( 'wp_ajax_lbd_add_score', 'lbd_add_score_callback' );
add_action( 'wp_ajax_nopriv_lbd_add_score', 'lbd_add_score_callback' );
function lbd_add_score_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 

	$event_score_event= sanitize_text_field($_POST['event_score_event']);
	$event_score_division= sanitize_text_field($_POST['event_score_division']);
	$event_score_workout= sanitize_text_field($_POST['event_score_workout']);
	$event_score_competitor= sanitize_text_field($_POST['event_score_competitor']);
	$event_point = sanitize_text_field($_POST['event_score_point']);
	$event_score= sanitize_text_field($_POST['event_score']);
		
	$tempvar = filter_var_array($_POST['event_score_proof'],FILTER_SANITIZE_STRING); 
	$event_score_proof=implode(",",$tempvar);
	
	$event_modified_date = date('Y-m-d');
	
	$current_user = wp_get_current_user();
	//Check for duplication
	$check = LBDgetAllFields($table2, "participant_id", $event_score_competitor, "workout_id", $event_score_workout); 
	if(count($check)==0){
		if($event_score_event != '' && $event_score_division != '' && $event_score_workout != '' && $event_score_competitor != '' && $event_score != ''){
			$sql  = 'INSERT INTO '.$table2.'  (id, participant_id, event_id, workout_id, division_id, modified_date, added_by, score,point,proof) VALUES (NULL,"'.$event_score_competitor.'", "'.$event_score_event.'","'.$event_score_workout.'","'.$event_score_division.'","'.$event_modified_date.'","'.$current_user->user_email.'","'.$event_score.'","'.$event_point.'","'.$event_score_proof.'")';
			dbDelta( $sql );
			echo "New Score added successfully";
		}else{
			echo '0';
		}
	}else{
		echo "Duplicate Entry. Participants can't have multiple scores for a single Workout.";
	}
	wp_die();
}
/********************************************** Delete Score *************************************/
add_action( 'wp_ajax_lbd_delete_score', 'lbd_delete_score_callback' );
add_action( 'wp_ajax_nopriv_lbd_delete_score', 'lbd_delete_score_callback' );
function lbd_delete_score_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	
	$score_id = sanitize_text_field($_POST['score_id']); 
	if($score_id != ''){
		if($wpdb->delete( $table2, array( 'id' => $score_id ) )){
			echo "<span class='greenmsg'>Score deleted successfully</span>";
		}
	}
	$workouts = LBDgetAllFields($table2); $i=1;?>
    <table class="table-box" border="0" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo esc_html('Participant'); ?></th>
				<th><?php echo esc_html('Event'); ?></th>
				<th><?php echo esc_html('Workout'); ?></th>
				<th><?php echo esc_html('Score'); ?></th>
				<th><?php echo esc_html('Point'); ?></th>
				<th><?php echo esc_html('Added by'); ?></th>
				<th><?php echo esc_html('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($scores as $score){ ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $score->participant_id; ?></td>
					<td><?php echo $score->event_id; ?></td>
					<td><?php echo $score->workout_id; ?></td>
					<td><?php echo $score->score; ?></td>
					<td><?php echo $score->point; ?></td>
					<td><?php echo $score->added_by; ?></td>
					<td><span class ="editScore editLink">Edit<input type="hidden" id="score_id" name="score_id" value="<?php echo $score->id;?>" /></span> | <span class="deleteScore deleteLink">Delete<input type="hidden" id="score_id" name="score_id" value="<?php echo $score->id;?>" /></span></td>
				</tr>
			<?php $i++;} ?>
		</tbody>
	</table>    
	<?php 
	wp_die(); 
}
/********************************************** Edit Score *************************************/
add_action( 'wp_ajax_lbd_edit_score', 'lbd_edit_score_callback' );
add_action( 'wp_ajax_nopriv_lbd_edit_score', 'lbd_edit_score_callback' );
function lbd_edit_score_callback() {
	global $post, $wpdb; 
	check_ajax_referer( 'lbdNonce', 'security'); 
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	
	$score_id = sanitize_text_field($_POST['score_id']);
	$editScore = LBDgetAllFields($table2,"id",$score_id);
	foreach($editScore as $score){
		$row = $score;
	}
	?>
	<?php 
	 $events 		= LBDgetAllFields($table4); 
	 $workouts 	= LBDgetAllFields($table7); 
	 $divisions 	= LBDgetAllFields($table3); 
	 $competitors = LBDgetAllFields($table1); 
	?>
	   <form method="post" id="scoreForm" name="scoreForm" enctype="multipart/form-data">
	   <input type="hidden" name="edit_event_score_id" value="<?php echo $row->id; ?>" id="edit_event_score_id" />
		<div class="scorebord-table">
			<div class="resize-table">
				<div class="blockCustom">
					<div class="block2_1">
						<label>Event:</label>
						<select name="edit_event_score_event" id="edit_event_score_event">
							<option value="">-Select Event-</option>
							<?php foreach($events as $eve){ ?>
							<option value="<?php echo $eve->id; ?>" <?php if($row->event_id == $eve->id){echo "selected";} ?>><?php echo $eve->event_name; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="block2_1" id="edit_event_score_division_selector">
						<label>Division:</label>
						<?php $divisions = LBDgetAllFields($table3,'event_id',$row->event_id); ?>
						<select name="edit_event_score_division" id="edit_event_score_division">
						<option value="">-Select Division-</option>
						<?php foreach($divisions as $div){ ?>
							<option value="<?php echo $div->id; ?>" <?php if($div->id==$row->division_id){ echo "selected"; } ?>><?php echo $div->division_name; ?></option>
						<?php } ?>
						</select>
					</div>
					<div class="block2_1" id="edit_event_score_workout_selector">
						<label>Workout:</label>
						<?php
						$workouts = $wpdb->get_results( "SELECT * FROM ". $table7 ." WHERE event_id=".$row->event_id." AND divisions LIKE '%".$row->division_id."%' " );
						?>
						<select name="edit_event_score_workout" id="edit_event_score_workout">
							<option value="">-Select Workout-</option>
							<?php foreach($workouts as $work){ $workoutUnit[$work->id] = $work->measurement_unit; ?>
								<option value="<?php echo $work->id; ?>" <?php if($work->id==$row->workout_id){ echo "selected"; } ?>><?php echo $work->workout; ?></option>
							<?php }	?>
						</select>
					</div>
					<div class="block2_1" id="edit_event_score_competitor_selector">
						<label>Competitor:</label>
						<?php $competitors = LBDgetAllFields($table1,"division",$row->division_id);  ?>
						<select name="edit_event_score_competitor" id="edit_event_score_competitor">
							<option value="">-Select Competitor-</option>
							<?php foreach($competitors as $com){ ?> 
				 				<option value="<?php echo $com->id; ?>" <?php if($com->id==$row->participant_id){ echo "selected"; } ?>><?php echo $com->participant_name; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="blockCustom">
					<div class="block2_1">
						<label>Score:</label>
						<?php $score_unit = array("time" =>"Time in hh:mm:ss",
												"kg" => "Weight in kg",
												"lbs" => "Weight in lbs",
												"repetitions" => "Number of Repetitions") 
						?>
						<input type="text" name="edit_event_score" id="edit_event_score" class="log-in-input" value="<?php echo $row->score; ?>" style="width:100px;"  /><i><span id="score_unit"><?php echo $score_unit[$workoutUnit[$row->workout_id]]; ?></span></i>
					</div>
					<div class="block2_1">
						<label>Video:</label>
						<input type="button" name="edit_event_score_proof_upload" id="edit_event_score_proof_upload" value="Upload" />
						<span id="myplugin-placeholder">
						<?php  $proofs = ($row->proof=='')?'':explode(",",$row->proof);  ?>
						<?php if($proofs){ ?>
							<?php foreach($proofs as $proof){ ?>
								<?php if($proof){ ?>
									<div class="listBlck">
										<a href="<?php echo wp_get_attachment_url( $proof ); ?>" target="_blank" class="applicationBg"></a>
										<h5><?php echo wp_get_attachment_url( $proof ); ?></h5>
										<span id="proof<?php echo $proof; ?>" class="old_eve_score_proof">X<input id="save_proof<?php echo $proof; ?>" type="hidden" value="<?php echo $proof; ?>"></span>
									</div>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						<select name="old_event_score_proof" id="old_event_score_proof" class="old_eve_drop" style="display:none;" multiple="">
							<?php foreach($proofs as $proof){ ?>
								<?php if($proof){ ?>
									<option value="<?php echo $proof; ?>" selected=""><?php echo $proof; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						</span>
					</div>
				</div>

				<div class="seperator"></div>
				<div class="blockCustom"> 
					<input type="submit" name="save_score" value="Save Score" class="log-in-submit editScoreSave" /> 
				</div>
			</div>
		</div>
	</form>
	<?php 
 	wp_die(); 
}   
/********************************************** Edit Save Score *************************************/ 
add_action( 'wp_ajax_lbd_editsave_score', 'lbd_editsave_score_callback' ); 
add_action( 'wp_ajax_nopriv_lbd_editsave_score', 'lbd_editsave_score_callback' );
function lbd_editsave_score_callback() {  
	global $post, $wpdb; 
	check_ajax_referer( 'lbdNonce', 'security');
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 

	$event_score_id= sanitize_text_field($_POST['event_score_id']);
	$event_score_event= sanitize_text_field($_POST['event_score_event']);
	$event_score_division= sanitize_text_field($_POST['event_score_division']);
	$event_score_workout= sanitize_text_field($_POST['event_score_workout']);
	$event_score_competitor= sanitize_text_field($_POST['event_score_competitor']);
	$event_score= sanitize_text_field($_POST['event_score']);
	$event_point = sanitize_text_field($_POST['event_score_point']);
		
	$tempvar = filter_var_array($_POST['event_score_proof'],FILTER_SANITIZE_STRING); 
	$proof=implode(",",$tempvar);
	
	$tempvarOld = filter_var_array($_POST['old_event_score_proof'],FILTER_SANITIZE_STRING); 
	$proof_old=implode(",",$tempvarOld);
	
	$f1 = 0;
	$f2 = 0;
	if($proof){
		$score_proof1 = $proof;
		$f1 = 1;
	}
	if($proof_old){
		$score_proof2 = $proof_old;
		$f2 = 1;
	}
	if($f1==1 && $f2==1){
		$score_proof = $score_proof1.",".$score_proof2;
	}else if($f1==1 && $f2!=1){
		$score_proof = $score_proof1;
	}else if($f1!=1 && $f2==1){
		$score_proof = $score_proof2;
	}else{
		$score_proof = '';
	}
	$event_modified_date = date('Y-m-d');
	
	if($event_score_event != '' && $event_score_division != '' && $event_score_workout != '' && $event_score_competitor != '' && $event_score != ''){
		$sql  = 'UPDATE '.$table2.' SET participant_id="'.$event_score_competitor.'", event_id="'.$event_score_event.'", workout_id="'.$event_score_workout.'", division_id="'.$event_score_division .'", modified_date="'.$event_modified_date .'", score="'.$event_score .'", point="'.$event_point .'", proof="'.$score_proof .'"  WHERE id = '.$event_score_id; 

		dbDelta( $sql );
		echo "Score Edited successfully"; 
	}else{
		echo 0;
	}
	wp_die();
}