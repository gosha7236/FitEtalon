<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
///////////////////////////////////////////////////////////////////Ajax Calls///////////////////////////////////////////////////////////////////////////
/********************************************** Add Division *************************************/
add_action( 'wp_ajax_lbd_add_division', 'lbd_add_division_callback' );
add_action( 'wp_ajax_nopriv_lbd_add_division', 'lbd_add_division_callback' );
function lbd_add_division_callback() {
	global $post, $wpdb; 
	check_ajax_referer( 'lbdNonce', 'security'); 
	$division_name = sanitize_text_field($_POST['division_name']);
	$division_event = sanitize_text_field($_POST['division_event']);
	if($division_name != '' && $division_event !=''){
		 $table5 = $wpdb->prefix . "lbd_event_divisions"; 
		$sql  = 'INSERT INTO '.$table5.' (`id`, `division_name`, `event_id`, `status`) VALUES (NULL, "'.$division_name.'","'.$division_event.'", "1")';
		dbDelta( $sql );
		echo "New Division added successfully";
	}else{
		echo 0;
	}
	wp_die();
}
/********************************************** Delete Division *************************************/
add_action( 'wp_ajax_lbd_delete_division', 'lbd_delete_division_callback' );
add_action( 'wp_ajax_nopriv_lbd_delete_division', 'lbd_delete_division_callback' );
function lbd_delete_division_callback() {
	global $post, $wpdb; 
	check_ajax_referer( 'lbdNonce', 'security'); 
	$table5 = $wpdb->prefix . "lbd_event_divisions";
	$division_id = sanitize_text_field($_POST['division_id']); 
	if($division_id != ''){
		if($wpdb->delete( $table5, array( 'id' => $division_id ) )){
			echo "<span class='greenmsg'>Division deleted successfully</span>";
		}
	}
	$divisions = LBDgetAllFields($table5); $i=1;?>
	<table class="table-box" border="0" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo esc_html('Division'); ?></th>
				<th><?php echo esc_html('Event'); ?></th>
				<th><?php echo esc_html('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($divisions as $com){ ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $com->division_name; ?></td>
					<td><?php echo $com->event_id; ?></td>
					<td><span class ="editDivision">Edit<input type="hidden" id="division_id" name="division_id" value="<?php echo $com->id;?>" /></span> | <span class="deleteDivision">Delete<input type="hidden" id="division_id" name="division_id" value="<?php echo $com->id;?>" /></span></td>
				</tr>
			<?php $i++;} ?>
		</tbody>
	</table>
	<?php
	wp_die();
}
/********************************************** Edit Division *************************************/
add_action( 'wp_ajax_lbd_edit_division', 'lbd_edit_division_callback' );
add_action( 'wp_ajax_nopriv_lbd_edit_division', 'lbd_edit_division_callback' );
function lbd_edit_division_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	$division_id = sanitize_text_field($_POST['division_id']);
	$editDiv = LBDgetAllFields($table3,"id",$division_id);
	foreach($editDiv as $division){
		$div = $division;
	}
	?>
	<form method="post" id="divisionForm" name="divisionForm">
	<input type="hidden" name="edit_division_id" value="<?php echo $div-> id; ?>" id="edit_division_id" />
		<div class="scorebord-table">
			<div class="resize-table">
				<div class="blockCustom">
					<div class="block2_1">
						<label><?php echo esc_html('Division Name:'); ?></label>
						<input type="text" name="edit_division_name" value="<?php echo $div->division_name; ?>" id="edit_division_name" class="log-in-input" />
					</div>
					<div class="block2_1">
						<label><?php echo esc_html('Event Name:'); ?></label>
						<?php $events = LBDgetAllFields($table4); ?>
						<select name="edit_division_event" id="edit_division_event" class="log-in-input">
							<option value="">-- Select Event --</option>
						<?php foreach($events as $eve){ ?>
							<option value="<?php echo $eve->id; ?>" <?php if($eve->id==$div->event_id){ echo "selected";} ?>><?php echo $eve->event_name; ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="blockCustom"> 
					<input type="submit" name="editsave_division" value="Edit & Save" class="log-in-submit editDivSave" /> 
				</div>
			</div>
		</div>
	</form>
	<?php
	wp_die();
}
/********************************************** Edit Save Division ************************************/  
add_action( 'wp_ajax_lbd_editsave_division', 'lbd_editsave_division_callback' );
add_action( 'wp_ajax_nopriv_lbd_editsave_division', 'lbd_editsave_division_callback' );
function lbd_editsave_division_callback(){
	global $post, $wpdb; 
	check_ajax_referer( 'lbdNonce', 'security');
	$division_id = sanitize_text_field($_POST['division_id']);
	$division_name = sanitize_text_field($_POST['division_name']);
	$division_event = sanitize_text_field($_POST['division_event']);
	
	if($division_name != '' && $division_event !=''){
		 $table3 = $wpdb->prefix . "lbd_event_divisions"; 
		$sql  = 'UPDATE '.$table3.'  SET division_name="'.$division_name.'", event_id='.$division_event.' WHERE id = '.$division_id; 
		dbDelta( $sql );
		echo "Division Edited successfully";
	}else{
		echo 0;
	}
	wp_die();
}