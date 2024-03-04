<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
///////////////////////////////////////////////////////////////////Ajax Calls///////////////////////////////////////////////////////////////////////////
/******************************* Event-division selector ********************************/ 
add_action( 'wp_ajax_lbd_event_workout_div', 'lbd_event_workout_div_callback' );
add_action( 'wp_ajax_nopriv_lbd_event_workout_div', 'lbd_event_workout_div_callback' );
function lbd_event_workout_div_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$event_id = sanitize_text_field($_POST['event_id']);

	if($event_id != ''){
		$divisions = LBDgetAllFields($table3,'event_id',$event_id);
		if($divisions){
			echo '<label>Available Divisions:</label>';
			echo '<select name="event_workout_divisions" id="event_workout_divisions" multiple>';
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
/******************************* Event-division selector - Edit screen ********************************/ 
add_action( 'wp_ajax_lbd_event_workout_edit_div', 'lbd_event_workout_edit_div_callback' );
add_action( 'wp_ajax_nopriv_lbd_event_workout_edit_div', 'lbd_event_workout_edit_div_callback' );
function lbd_event_workout_edit_div_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$event_id = sanitize_text_field($_POST['event_id']);
	$old_event_workout_division = sanitize_text_field($_POST['old_event_workout_division']);
	if($event_id != ''){
		$divisions = LBDgetAllFields($table3,'event_id',$event_id);
		if($divisions){
			echo '<label>Available Divisions:</label>';
			
			if($old_event_workout_division !== ''){
				echo '<select name="edit_event_workout_divisions" id="edit_event_workout_divisions" multiple>';
				$new_workout_divisions = array(); 
				$new_workout_divisions = explode(",",$old_event_workout_division);
				foreach($divisions as $div){ 
					if(in_array($div->id,$new_workout_divisions)){$sel = "selected";}else{$sel = "";}
					echo '<option value="'.$div->id.'" '.$sel.'>'.$div->division_name.'</option>';
				} 
			}else{
				echo '<select name="edit_event_workout_divisions" id="edit_event_workout_divisions" multiple>';
				foreach($divisions as $div){ 
					echo '<option value="'.$div->id.'">'.$div->division_name.'</option>';
				} 
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
/**********************************************  Save Workout  ************************************************/
add_action( 'wp_ajax_lbd_add_workout', 'lbd_add_workout_callback' );
add_action( 'wp_ajax_nopriv_lbd_add_workout', 'lbd_add_workout_callback' );
function lbd_add_workout_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	
	$event_workout_name= sanitize_text_field($_POST['event_workout_name']);
	$event_workout_event= sanitize_text_field($_POST['event_workout_event']);
	
	$tempvar = filter_var_array($_POST['event_workout_divisions'],FILTER_SANITIZE_STRING); 
	$event_workout_divisions=implode(",",$tempvar);

	$event_workout_desc= sanitize_text_field($_POST['event_workout_desc']);
	$event_workout_unit= sanitize_text_field($_POST['event_workout_unit']);
	$event_workout_enable= (filter_var($_POST['event_workout_enable'], FILTER_SANITIZE_STRING)=='on')?1:0;
	
	if($event_workout_name != '' && $event_workout_event != '' && $event_workout_desc != ''){
		$sql  = 'INSERT INTO '.$table7.'  (id, workout, event_id, divisions, details, measurement_unit, status) VALUES (NULL,"'.$event_workout_name.'","'.$event_workout_event.'","'.$event_workout_divisions.'","'.$event_workout_desc.'","'.$event_workout_unit.'","'.$event_workout_enable.'")';
		
	dbDelta( $sql );
	echo "New Workout added successfully";
	}else{
		echo '0';
	}
	wp_die();
}
/********************************************** Delete Workout *************************************/
add_action( 'wp_ajax_lbd_delete_workout', 'lbd_delete_workout_callback' );
add_action( 'wp_ajax_nopriv_lbd_delete_workout', 'lbd_delete_workout_callback' );
function lbd_delete_workout_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	
	$workout_id = sanitize_text_field($_POST['workout_id']); 
	if($workout_id != ''){
		if($wpdb->delete( $table7, array( 'id' => $workout_id ) )){
			echo "<span class='greenmsg'>Workout deleted successfully</span>";
		}
	}
	$workouts = LBDgetAllFields($table7); $i=1;?>
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
					<td><?php echo $workout->divisions; ?></td>
					<td><?php echo $workout->details; ?></td>
					<td width="130px"><span class ="editWorkout editLink">Edit<input type="hidden" id="workout_id" name="workout_id" value="<?php echo $workout->id;?>" /></span> | <span class="deleteWorkout deleteLink">Delete<input type="hidden" id="workout_id" name="workout_id" value="<?php echo $workout->id;?>" /></span></td>
				</tr>
			<?php $i++;} ?>
		</tbody>
	</table>    
	<?php 
	wp_die(); 
}
/********************************************** Edit Workout *************************************/
add_action( 'wp_ajax_lbd_edit_workout', 'lbd_edit_workout_callback' );
add_action( 'wp_ajax_nopriv_lbd_edit_workout', 'lbd_edit_workout_callback' );
function lbd_edit_workout_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	
	$workout_id = sanitize_text_field($_POST['workout_id']);
	$editWorkout = LBDgetAllFields($table7,"id",$workout_id);
	foreach($editWorkout as $work){
		$row = $work;
	}
	?>
	<form method="post" id="workoutForm" name="workoutForm">
		<input type="hidden" name="edit_event_workout_id" value="<?php echo $row-> id; ?>" id="edit_event_workout_id" />
		<div class="scorebord-table">
			<div class="resize-table">
				<h3><?php echo esc_html('Workout Info:'); ?></h3>
				<div class="blockCustom">
						<label><?php echo esc_html('Workout Name:'); ?></label><input type="text" name="edit_event_workout_name" value="<?php echo $row-> workout; ?>" id="edit_event_workout_name" class="log-in-input" />
				</div>
				<div class="blockCustom">
					<div class="block2_1">
						<label><?php echo esc_html('For Event:'); ?></label>
						<?php $events = LBDgetAllFields($table4); ?>
						<select name="edit_event_workout_event" id="edit_event_workout_event" >
							<option value="">-Select Event-</option>
							<?php foreach($events as $event){ ?>
							<option value="<?php echo $event->id; ?>" <?php if($event->id == $row->event_id){ echo "selected"; } ?>><?php echo $event->event_name; ?></option>
							<?php } ?>
						</select>
					</div>
					<input type="hidden" value="<?php echo $row->divisions; ?>" name="old_event_workout_division" id="old_event_workout_division" />
					<div class="block2_1" id="edit_available_divisions">
						<?php
						$divisions = LBDgetAllFields($table3,'event_id',$row->event_id); 
						if($divisions){
							echo '<label>Available Divisions:</label>';
							
							if($row->divisions !== ''){
								echo '<select name="edit_event_workout_divisions" id="edit_event_workout_divisions" multiple>';
								$new_workout_divisions = array(); 
								$new_workout_divisions = explode(",",$row->divisions);
								foreach($divisions as $div){ 
									if(in_array($div->id,$new_workout_divisions)){$sel = "selected";}else{$sel = "";}
									echo '<option value="'.$div->id.'" '.$sel.'>'.$div->division_name.'</option>';
								} 
								echo "</select>";
							}else{
								echo '<select name="edit_event_workout_divisions" id="edit_event_workout_divisions" multiple>';
								foreach($divisions as $div){ 
									echo '<option value="'.$div->id.'">'.$div->division_name.'</option>';
								} 
								echo "</select>";
							}
					}else{
						echo '<span style="color:red; font-weight:bold;">No Division is availabe for the selection. Please add/assign division first.</span>';
					}
					?>
					</div>
				</div>
				
				<div class="seperator"></div>
				
				<h3><?php echo esc_html('Details'); ?></h3>
				<div class="blockCustom"> 
					<label><?php echo esc_html('Workout Details:'); ?></label>
					<?php 
					$editor_id = 'edit_event_workout_desc';
					$event_workout_desc = $row-> details;
					wp_editor( $event_workout_desc, $editor_id );
					?>
				</div>
				<div class="blockCustom">
					<label><?php echo esc_html('Measurement unit:'); ?></label>
					<?php $munit = array("time"=>"Time in hh:mm:ss","kg"=>"Weight in kg","lbs"=>"Weight in lbs","repetitions"=>"Number of Repetitions"); ?>
					<select name="edit_event_workout_unit" id="edit_event_workout_unit" >
						<option value="">--Select Unit--</option>
						<?php foreach($munit as $u=>$val){ ?>
						<option value="<?php echo $u; ?>" <?php if($u==$row->measurement_unit){ echo "selected"; }?>><?php echo $val; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="blockCustom"> 
						<label><?php echo esc_html('Workout Status?:'); ?> </label><input type="checkbox" name="edit_event_workout_enable" id="edit_event_workout_enable" <?php if($row->status==1){echo "checked";} ?>  />
				</div>
			
				<div class="seperator"></div>
				
				<div class="blockCustom"> 
					<input type="submit" name="save_workout" value="Save Workout" class="log-in-submit editWorkoutSave" /> 
				</div>
				
			</div>
		</div>
	</form>
	<?php 
 	wp_die(); 
} 
/********************************************** Edit Save Workout *************************************/ 
add_action( 'wp_ajax_lbd_editsave_workout', 'lbd_editsave_workout_callback' ); 
add_action( 'wp_ajax_nopriv_lbd_editsave_workout', 'lbd_editsave_workout_callback' );
function lbd_editsave_workout_callback() {
	global $post, $wpdb; 
	check_ajax_referer( 'lbdNonce', 'security');
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 

	$event_workout_id 							= sanitize_text_field($_POST['event_workout_id']);
	$event_workout_name					= sanitize_text_field($_POST['event_workout_name']);
	$event_workout_event					= sanitize_text_field($_POST['event_workout_event']);
	$tempvar 											= filter_var_array($_POST['event_workout_divisions'],FILTER_SANITIZE_STRING); 
	$event_workout_divisions				= implode(",",$tempvar);

	$event_workout_desc						= sanitize_text_field($_POST['event_workout_desc']);
	$event_workout_unit						= sanitize_text_field($_POST['event_workout_unit']);
	$event_workout_enable					= (filter_var($_POST['event_workout_enable'], FILTER_SANITIZE_STRING)=='on')?1:0; 
	
	
	if($event_workout_name !=''){
		$sql  = 'UPDATE '.$table7.' SET workout="'.$event_workout_name.'", event_id="'.$event_workout_event.'", divisions="'.$event_workout_divisions.'", details="'.$event_workout_desc .'", measurement_unit="'.$event_workout_unit .'", status="'.$event_workout_enable .'"  WHERE id = '.$event_workout_id; 
		
		dbDelta( $sql );
		echo "Workout Edited successfully"; 
	}else{
		echo 0;
	}
	wp_die();
}