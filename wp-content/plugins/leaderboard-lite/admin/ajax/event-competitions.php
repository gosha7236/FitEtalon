<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
///////////////////////////////////////////////////////////////////Ajax Calls///////////////////////////////////////////////////////////////////////////
/********************************************** Add Competition *************************************/
add_action( 'wp_ajax_lbd_add_competition', 'lbd_add_competition_callback' );
add_action( 'wp_ajax_nopriv_lbd_add_competition', 'lbd_add_competition_callback' );
function lbd_add_competition_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$competition_name = sanitize_text_field($_POST['competition_name']);
	$competition_start_date = sanitize_text_field($_POST['competition_start_date']);
	$competition_end_date = sanitize_text_field($_POST['competition_end_date']);
	$competition_desc = sanitize_text_field($_POST['competition_desc']);
	
	if($competition_name != '' && $competition_start_date !='' && $competition_end_date !=''){
		 $table5 = $wpdb->prefix . "lbd_event_competitions"; 
		$sql  = 'INSERT INTO '.$table5.' (`id`, `competition_name`, `from_date`, `to_date`, `details`) VALUES (NULL, "'.$competition_name.'","'.$competition_start_date.'", "'.$competition_end_date.'", "'.$competition_desc.'")';
		dbDelta( $sql );
		echo "New Competition added successfully";
	}else{
		echo 0;
	}
	wp_die();
}
/********************************************** Delete Competition *************************************/
add_action( 'wp_ajax_lbd_delete_competition', 'lbd_delete_competition_callback' );
add_action( 'wp_ajax_nopriv_lbd_delete_competition', 'lbd_delete_competition_callback' );
function lbd_delete_competition_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table5 = $wpdb->prefix . "lbd_event_competitions";
	$competition_id = sanitize_text_field($_POST['competition_id']); 
	if($competition_id != ''){
		if($wpdb->delete( $table5, array( 'id' => $competition_id ) )){
			echo "<span class='greenmsg'>Competition deleted successfully</span>";
		}
	}
	$competitions = LBDgetAllFields($table5); $i=1;?>
	<table class="table-box" border="0" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo esc_html('Competition'); ?></th>
				<th><?php echo esc_html('From'); ?></th>
				<th><?php echo esc_html('To'); ?></th>
				<th><?php echo esc_html('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($competitions as $com){ ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $com->competition_name; ?></td>
					<td><?php echo $com->from_date; ?></td>
					<td><?php echo $com->to_date; ?></td>
					<td><span class ="editCompetition">Edit<input type="hidden" id="competition_id" name="competition_id" value="<?php echo $com->id;?>" /></span> | <span class="deleteCompetition">Delete<input type="hidden" id="competition_id" name="competition_id" value="<?php echo $com->id;?>" /></span></td>
				</tr>
			<?php $i++;} ?>
		</tbody>
	</table>
	<?php
	wp_die();
}
/********************************************** Edit Competition *************************************/
add_action( 'wp_ajax_lbd_edit_competition', 'lbd_edit_competition_callback' );
add_action( 'wp_ajax_nopriv_lbd_edit_competition', 'lbd_edit_competition_callback' );
function lbd_edit_competition_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table5 = $wpdb->prefix . "lbd_event_competitions";
	$competition_id = sanitize_text_field($_POST['competition_id']);
	$editComp = LBDgetAllFields($table5,"id",$competition_id);
	foreach($editComp as $compet){
		$comp = $compet;
	}
	?>
	<form method="post" id="competitionForm" name="competitionForm">
	<input type="hidden" name="edit_competition_id" value="<?php echo $comp-> id; ?>" id="edit_competition_id" />
		<div class="scorebord-table">
			<div class="resize-table">
				<div class="blockCustom">
					<label><?php echo esc_html('Competition Name:'); ?></label><input type="text" name="edit_competition_name" value="<?php echo $comp-> competition_name; ?>" id="edit_competition_name" class="log-in-input" />
				</div>
				<div class="blockCustom">
					<div class="block2_1"><label>From:</label> <input type="text" class="log-in-input" name="edit_competition_start_date" id="edit_competition_start_date" value="<?php echo $comp-> from_date; ?>"  /></div>
					<div class="block2_1"><label>To:</label> <input type="text" class="log-in-input" name="edit_competition_end_date" id="edit_competition_end_date" value="<?php echo $comp-> to_date; ?>"/></div>
				</div>
				<div class="blockCustom"> 
					<label>Details:</label>
					<?php 
					$editor_id = 'edit_competition_desc';
					$competition_desc = $comp-> details;
					wp_editor( $competition_desc, $editor_id );
					?>
					<input type="submit" name="editsave_competition" value="Edit & Save" class="log-in-submit editCompSave" /> 
				</div>
			</div>
		</div>
	</form>
	<?php
	wp_die();
}
/********************************************** Edit Save Competition *************************************/   
add_action( 'wp_ajax_lbd_editsave_competition', 'lbd_editsave_competition_callback' ); 
add_action( 'wp_ajax_nopriv_lbd_editsave_competition', 'lbd_editsave_competition_callback' );
function lbd_editsave_competition_callback() {
	global $post, $wpdb;   
	check_ajax_referer( 'lbdNonce', 'security');
	$competition_id 				= sanitize_text_field($_POST['competition_id']);
	$competition_name 		= sanitize_text_field($_POST['competition_name']); 
	$competition_start_date 	= sanitize_text_field($_POST['competition_start_date']);
	$competition_end_date 	= sanitize_text_field($_POST['competition_end_date']);
	$competition_desc 			= sanitize_text_field($_POST['competition_desc']); 
	
	if($competition_name != '' && $competition_start_date !='' && $competition_end_date !=''){
		 $table5 = $wpdb->prefix . "lbd_event_competitions"; 
		$sql  = 'UPDATE '.$table5.' SET competition_name="'.$competition_name.'", from_date="'.$competition_start_date.'", to_date="'.$competition_end_date.'",details="'.$competition_desc.'" WHERE id = '.$competition_id; 
		dbDelta( $sql );
		echo "Competition Edited successfully"; 
	}else{
		echo "<span class='redmsg'>Please fill all the fields</span>";
	}
	wp_die();
}