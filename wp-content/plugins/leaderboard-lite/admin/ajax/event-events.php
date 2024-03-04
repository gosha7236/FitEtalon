<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
///////////////////////////////////////////////////////////////////Ajax Calls///////////////////////////////////////////////////////////////////////////
/**********************************************  Save an Event  ************************************************/
add_action( 'wp_ajax_lbd_add_event', 'lbd_add_event_callback' );
add_action( 'wp_ajax_nopriv_lbd_add_event', 'lbd_add_event_callback' );
function lbd_add_event_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	
	$event_organizer_email				= sanitize_email($_POST['event_organizer_email']);
	$event_name								= sanitize_text_field($_POST['event_name']);
	$event_competition						= sanitize_text_field($_POST['event_competition']);
	$event_type									= sanitize_text_field($_POST['event_type']);
	$event_from									= sanitize_text_field($_POST['event_from']);
	$event_time_from							= sanitize_text_field($_POST['event_time_from']);
	$event_to										= sanitize_text_field($_POST['event_to']);
	$event_time_to								= sanitize_text_field($_POST['event_time_to']);
	$event_time_fullday						= (filter_var($_POST['event_time_fullday'], FILTER_SANITIZE_STRING)=='on')?1:0;
	$event_location							= sanitize_text_field($_POST['event_location']);
	$event_region								= sanitize_text_field($_POST['event_region']);
	$event_address							= sanitize_text_field($_POST['event_address']);
	$event_country								= sanitize_text_field($_POST['event_country']);
	$event_city									= sanitize_text_field($_POST['event_city']);
	$event_po										= sanitize_text_field($_POST['event_po']);
	$event_latitude								= sanitize_text_field($_POST['event_latitude']);
	$event_longitude							= sanitize_text_field($_POST['event_longitude']);
	$event_desc									= sanitize_text_field($_POST['event_desc']);
	$event_image								= sanitize_text_field($_POST['event_image']);
	$event_website							= sanitize_text_field($_POST['event_website']);
	$event_enable_booking				= (filter_var($_POST['event_enable_booking'], FILTER_SANITIZE_STRING)=='on')?1:0;
	$event_endof_reg_date				= sanitize_text_field($_POST['event_endof_reg_date']);
	$event_endof_reg_time				= sanitize_text_field($_POST['event_endof_reg_time']);
	$event_fee										= (sanitize_text_field($_POST['event_fee'])=='')?0:sanitize_text_field($_POST['event_fee']);
	$event_fee_currency					= sanitize_text_field($_POST['event_fee_currency']);

	
	if($event_name != ''){
		$sql  = 'INSERT INTO '.$table4.'  (id, event_name, event_organizer_email, event_competition,  from_date, from_time, to_date,to_time, full_day, location, region, address, country, city, po, latitude, longitude, description, image, website, enable_booking, event_type, endof_reg_date,endof_reg_time, fee, currency, status) VALUES (NULL,"'.$event_name.'","'.$event_organizer_email.'","'.$event_competition.'","'.$event_from.'","'.$event_time_from.'","'.$event_to.'","'.$event_time_to.'","'.$event_time_fullday.'","'.$event_location.'","'.$event_region.'","'.$event_address.'","'.$event_country.'","'.$event_city.'","'.$event_po.'","'.$event_latitude.'","'.$event_longitude.'","'.$event_desc.'","'.$event_image.'","'.$event_website.'","'.$event_enable_booking.'","'.$event_type.'", "'.$event_endof_reg_date.'","'.$event_endof_reg_time.'","'.$event_fee.'","'.$event_fee_currency.'",1)';
		
	dbDelta( $sql );
	echo "New Event added successfully";
	}else{
		echo '0';
	}
	wp_die();
}
/********************************************** Delete Events *************************************/
add_action( 'wp_ajax_lbd_delete_event', 'lbd_delete_event_callback' );
add_action( 'wp_ajax_nopriv_lbd_delete_event', 'lbd_delete_event_callback' );
function lbd_delete_event_callback() {
	global $post, $wpdb;  
	check_ajax_referer( 'lbdNonce', 'security');
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$event_id = sanitize_text_field($_POST['event_id']); 
	if($event_id != ''){
		if($wpdb->delete( $table4, array( 'id' => $event_id ) )){
			echo "<span class='greenmsg'>Event deleted successfully</span>";
		}
	}
	$events = LBDgetAllFields($table4); $i=1;?>
       <table class="table-box" border="0" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>#</th>
					<th><?php echo esc_html('Event'); ?></th>
					<th><?php echo esc_html('From'); ?></th>
					<th><?php echo esc_html('To'); ?></th>
					<th><?php echo esc_html('Organized by'); ?></th>
					<th><?php echo esc_html('Event Type'); ?></th>
					<th><?php echo esc_html('Action'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($events as $event){ ?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $event->event_name; ?></td>
						<td><?php echo $event->from_date; ?></td>
						<td><?php echo $event->to_date; ?></td>
						<?php $user = get_user_by( 'email',  $event->event_organizer_email	 ); ?>
						<td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
						<td><?php echo $event->event_type; ?></td>
						<td><span class ="editEvent">Edit<input type="hidden" id="event_id" name="event_id" value="<?php echo $event->id;?>" /></span></td>
					</tr>
				<?php $i++;} ?>
			</tbody>
		</table>
	<?php
	wp_die();
}
/********************************************** Edit Events *************************************/
add_action( 'wp_ajax_lbd_edit_event', 'lbd_edit_event_callback' );
add_action( 'wp_ajax_nopriv_lbd_edit_event', 'lbd_edit_event_callback' );
function lbd_edit_event_callback() {
	global $post, $wpdb; 
	check_ajax_referer( 'lbdNonce', 'security'); 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$event_id = sanitize_text_field($_POST['event_id']);
	$editEvent = LBDgetAllFields($table4,"id",$event_id);
	foreach($editEvent as $evet){
		$eve = $evet;
	}
	?>
	<form method="post" id="eventForm" name="eventFormEdit">
		<div class="scorebord-table">
			<div class="resize-table">
				<?php $current_user = wp_get_current_user(); ?>
				<input type="hidden" name="edit_event_id" value="<?php echo $eve->id; ?>" id="edit_event_id" />
				<input type="hidden" name="edit_event_organizer_name" value="<?php echo $current_user->display_name; ?>" id="edit_event_organizer_name" class="log-in-input" />
				<input type="hidden" name="edit_event_organizer_email" value="<?php echo $current_user->user_email; ?>" id="edit_event_organizer_email" class="log-in-input" />
				
				<div class="seperator"></div>
				
				<div class="blockCustom">
					<h3><?php echo esc_html('Event Details'); ?></h3>
					<div class="block2_1">
						<label><?php echo esc_html('Event Name:'); ?></label> <input type="text" class="log-in-input" name="edit_event_name" id="edit_event_name" value="<?php echo $eve->event_name; ?>"  />
					</div>
					<div class="block2_1">
						<label><?php echo esc_html('Event Type:'); ?></label> 
						<select name="edit_event_type" id="edit_event_type">
							<option value="individual" <?php if($eve->event_type == "individual"){ echo "selected"; } ?>>Individual</option>
							<?php /*?><option value="team" <?php if($eve->event_type == "team"){ echo "selected"; } ?>>Team</option><?php */?>
						</select>
					</div>
					<div class="block2_1">
						<label><?php echo esc_html('Competition:'); ?></label>
						<?php $competitions = LBDgetAllFields($table5); $i=1; ?>
						<select name="edit_event_competition" id="edit_event_competition" >
							<option value="">-Select Competition-</option>
							<?php foreach($competitions as $com){ ?>
							<option value="<?php echo $com->id; ?>" <?php if($com->id==$eve->event_competition){echo "selected"; } ?>><?php echo $com->competition_name; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="seperator"></div>
				<h3><?php echo esc_html('When'); ?></h3>
				<div class="blockCustom">
					<div class="block2_1">
						<label>From:</label>
						<input type="text" name="edit_event_from" value="<?php echo $eve->from_date; ?>" id="edit_event_from" class="log-in-input" />
						<select name="edit_event_time_from" id="edit_event_time_from">
							<?php echo LBD_TimeSlotes($eve->from_time); ?>
						</select>
					</div>
					<div class="block2_1">
						<label>To:</label>
						<input type="text" name="edit_event_to" value="<?php echo $eve->to_date; ?>" id="edit_event_to" class="log-in-input" />
						<select name="edit_event_time_to" id="edit_event_time_to">
							<?php echo LBD_TimeSlotes($eve->to_time); ?>
						</select>
					</div>
				</div>
				 <div class="blockCustom">
					<div class="block2_1">
						<?php echo esc_html('All the day event?'); ?> <input type="checkbox" name="edit_event_time_fullday" id="edit_event_time_fullday" <?php if($eve->full_day==1){ echo "checked"; } ?>  />
					</div>
				</div>
				
				<div class="seperator"></div>
				
				<h3><?php echo esc_html('Where'); ?></h3>
				<div class="blockCustom">
					<div class="block2_1">
						<label><?php echo esc_html('Location Name:*'); ?></label>
						<input type="text" name="edit_event_location" value="<?php echo $eve->location; ?>" id="edit_event_location" class="log-in-input" />
					</div>
					<div class="block2_1">
						<label><?php echo esc_html('Region:'); ?></label>
						<input type="text" name="edit_event_region" value="<?php echo $eve->region; ?>" id="edit_event_region" class="log-in-input" />
					</div>
				</div>
				<div class="blockCustom">
					<div class="block2_1">
						<label><?php echo esc_html('Address:*'); ?></label>
						<input type="text" name="edit_event_address" value="<?php echo $eve->address; ?>" id="edit_event_address" class="log-in-input" />
					</div>
					<div class="block2_1">
						<label><?php echo esc_html('Country:'); ?></label>
						<select name="edit_event_country" id="edit_event_country" >
							<?php echo LBD_getCountries($eve->country); ?>
						</select>
					</div>
				</div>
				<div class="blockCustom">
					<div class="block2_1">
						<label><?php echo esc_html('City/Town:'); ?></label>
						<input type="text" name="edit_event_city" value="<?php echo $eve->city; ?>" id="edit_event_city" class="log-in-input" />
					</div>
					<div class="block2_1">
						<label><?php echo esc_html('Post code:'); ?></label>
						<input type="text" name="edit_event_po" value="<?php echo $eve->po; ?>" id="edit_event_po" class="log-in-input" />
					</div>
				</div>
				<div class="blockCustom">
					<div class="block2_1">
						<label><?php echo esc_html('Latitude:'); ?></label>
						<input type="text" name="edit_event_latitude" value="<?php echo $eve->latitude; ?>" id="edit_event_latitude" class="log-in-input" />
					</div>
					<div class="block2_1">
						<label><?php echo esc_html('Longitude:'); ?></label>
						<input type="text" name="edit_event_longitude" value="<?php echo $eve->longitude; ?>" id="edit_event_longitude" class="log-in-input" />
					</div>
					<div class="note"><?php echo esc_html('? Please get the Latitude and Longitude of your location from Google Maps.'); ?></div>
				</div>
				
				<div class="seperator"></div>
				
				<h3><?php echo esc_html('Details'); ?></h3>
				<div class="blockCustom"> 
					<label><?php echo esc_html('Event Details:'); ?></label>
					<?php 
					$editor_id = 'edit_event_desc';
					wp_editor( $eve->description, $editor_id );
					?>
				</div>
				<div class="blockCustom">
					<label><?php echo esc_html('Event Image:'); ?></label>
					<input id="upload_image" type="text" size="36" name="edit_event_image" value="<?php echo $eve->image; ?>" />
					<input id="upload_image_button" type="button" value="Upload Image" />
				</div>
				<div class="blockCustom">
					<label><?php echo esc_html('Event Website:'); ?></label>
					<input type="text" name="edit_event_website" value="<?php echo $eve->website; ?>" id="edit_event_website" class="log-in-input" />
				</div>
												
				<div class="seperator"></div>
				
				<h3><?php echo esc_html('Settings - Event Registration'); ?></h3>
				<div class="blockCustom"> 
						<?php echo esc_html('Enable Booking for this Event?:'); ?> &nbsp;<input type="checkbox" name="edit_event_enable_booking" id="edit_event_enable_booking" <?php if($eve->enable_booking ==  1){ echo "checked"; } ?> />
				</div>
				<div class="blockCustom"> 
					<label><?php echo esc_html('Registration End Date:'); ?></label>
					<input type="text" name="edit_event_endof_reg_date" value="<?php echo $eve->endof_reg_date; ?>" id="edit_event_endof_reg_date" class="log-in-input" /> by 
					<select name="edit_event_endof_reg_time" id="edit_event_endof_reg_time">
						<?php echo LBD_TimeSlotes($eve->endof_reg_time); ?>
					</select>
				</div>
				
				<div class="blockCustom" id="edit_eventFee"> 
					<label><?php echo esc_html('Event Fee:'); ?> </label> <input type="text" name="edit_event_fee" id="edit_event_fee" class="log-in-input" value="<?php echo $eve->fee; ?>" /> In  <select name="edit_event_fee_currency" id="edit_event_fee_currency">
						<?php echo LBDCurrencies($eve->currency); ?>
					</select>
					<br />
					<div class="note"><?php echo esc_html('? Empty event fee means the event is free/open to all.'); ?></div>
				</div>
				
				
				<div class="seperator"></div>
				
				<div class="blockCustom"> 
					<input type="submit" name="editsave_event" value="Save Event" class="log-in-submit editEventSave" /> 
				</div>
				
			</div>
		</div>
	</form>
	<?php 
	wp_die(); 
}
/********************************************** Edit Save Event *************************************/ 
add_action( 'wp_ajax_lbd_editsave_event', 'lbd_editsave_event_callback' );
add_action( 'wp_ajax_nopriv_lbd_editsave_event', 'lbd_editsave_event_callback' );
function lbd_editsave_event_callback() {
	global $post, $wpdb;
	check_ajax_referer( 'lbdNonce', 'security');

	$event_id 							= sanitize_text_field($_POST['event_id']);
	$event_organizer_email	= sanitize_email($_POST['event_organizer_email']);
	$event_name					= sanitize_text_field($_POST['event_name']);
	$event_competition			= sanitize_text_field($_POST['event_competition']);
	$event_type						= sanitize_text_field($_POST['event_type']);
	$event_from						= sanitize_text_field($_POST['event_from']);
	$event_time_from				= sanitize_text_field($_POST['event_time_from']);
	$event_to							= sanitize_text_field($_POST['event_to']);
	$event_time_to					= sanitize_text_field($_POST['event_time_to']);
	$event_time_fullday			= (filter_var($_POST['event_time_fullday'], FILTER_SANITIZE_STRING)=='on')?1:0;
	$event_location				= sanitize_text_field($_POST['event_location']);
	$event_region					= sanitize_text_field($_POST['event_region']);
	$event_address				= sanitize_text_field($_POST['event_address']);
	$event_country					= sanitize_text_field($_POST['event_country']);
	$event_city						= sanitize_text_field($_POST['event_city']);
	$event_po							= sanitize_text_field($_POST['event_po']);
	$event_latitude					= sanitize_text_field($_POST['event_latitude']);
	$event_longitude				= sanitize_text_field($_POST['event_longitude']);
	$event_desc						= sanitize_text_field($_POST['event_desc']);
	$event_image					= sanitize_text_field($_POST['event_image']);
	$event_website				= sanitize_text_field($_POST['event_website']);
	$event_enable_booking	= (filter_var($_POST['event_enable_booking'], FILTER_SANITIZE_STRING)=='on')?1:0;
	$event_endof_reg_date	= sanitize_text_field($_POST['event_endof_reg_date']);
	$event_endof_reg_time	= sanitize_text_field($_POST['event_endof_reg_time']);
	$event_fee							= (sanitize_text_field($_POST['event_fee'])=='')?0:sanitize_text_field($_POST['event_fee']);
	$event_fee_currency		= sanitize_text_field($_POST['event_fee_currency']);
	 
	if($event_name !=''){ 
		 $table4 = $wpdb->prefix . "lbd_event_events"; 
		$sql  = 'UPDATE '.$table4.' SET event_name="'.$event_name.'", event_competition="'.$event_competition.'", from_date="'.$event_from .'", from_time="'.$event_time_from .'", to_date="'.$event_to .'", to_time="'.$event_time_to .'", full_day="'.$event_time_fullday .'", location="'.$event_location .'", region="'.$event_region .'", address="'.$event_address .'", country="'.$event_country .'", city="'.$event_city .'", po="'.$event_po .'", latitude="'.$event_latitude .'", longitude="'.$event_longitude .'", description="'.$event_desc .'", image="'.$event_image .'", website="'.$event_website .'", enable_booking="'.$event_enable_booking .'", event_type="'.$event_type .'", endof_reg_date="'.$event_endof_reg_date .'", endof_reg_time="'.$event_endof_reg_time .'", fee="'.$event_fee .'", currency="'.$event_fee_currency .'" WHERE id = '.$event_id; 
		
		dbDelta( $sql );
		echo "Event Edited successfully"; 
	}else{
		echo 0;
	}
	wp_die();
}