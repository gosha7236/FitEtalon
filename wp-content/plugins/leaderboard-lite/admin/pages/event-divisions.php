<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php global $wpdb; 
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
    <div class="scorebord-table-main"> <span class="ResultArea"></span>
      <div id="parentHorizontalTab">
        <ul class="resp-tabs-list hor_1">
          <li><?php echo esc_html('Divisions'); ?></li>
          <li><?php echo esc_html('Add Division'); ?></li>
        </ul>
        <div class="resp-tabs-container hor_1">
          <div>
            <div class="scorebord-table">
              <div class="resize-table divisionTable">
				<?php $events = LBDgetAllFields($table4); ?>
				<?php if($events){ ?>
					<?php foreach($events as $eve){ ?>
						<?php $divisions = LBDgetAllFields($table3,"event_id",$eve->id); $i=1; ?>
						<h3 class="section_title">Event Name: <span><?php echo $eve->event_name; ?></span></h3>
						<table class="table-box" border="0" cellpadding="0" cellspacing="0">
						  <thead>
							<tr>
							  <th>#</th>
							  <th><?php echo esc_html('Division'); ?></th>
							  <th><?php echo esc_html('Action'); ?></th>
							</tr>
						  </thead>
						  <tbody>
							<?php if($divisions){ ?>
								<?php foreach($divisions as $com){ ?>
								<tr>
								  <td><?php echo $i; ?></td>
								  <td><?php echo $com->division_name; ?></td>
								  <td><span class ="editDivision editLink">Edit
									<input type="hidden" id="division_id" name="division_id" value="<?php echo $com->id;?>" />
									</span> | <span class="deleteDivision deleteLink">Delete
									<input type="hidden" id="division_id" name="division_id" value="<?php echo $com->id;?>" />
									</span></td>
								</tr>
								<?php $i++;} ?>
							<?php }else{ ?>
								<tr><td colspan="3"><?php echo esc_html('No Dvisions found'); ?></td></tr>
							<?php } ?>
						  </tbody>
						</table>
					<?php } ?>
				<?php }else{ ?>
					<?php echo esc_html('Add Events First'); ?>
				<?php } ?>
              </div>
            </div>
          </div>
          <div>
		  	<?php $Alldivisions = LBDgetAllFields($table3); ?>
		  	<?php $DivisionsCount = count($Alldivisions); ?>
			<?php if(get_option("LBD_version")=="FREE" && $DivisionsCount>=3){ ?>
				<span style="color:#ca3030;">Sorry, you have reached the maximum division limits. You can't add more Divisions to this site. Please <a href="https://wpleaderboard.com/" target="_blank">Upgrade</a> to our PRO version for unlimited Divisions!</span>
			<?php }else{ ?>
				<form method="post" id="divisionForm" name="divisionForm">
				  <div class="scorebord-table">
					<div class="resize-table">
					  <div class="blockCustom">
						<div class="block2_1">
						  <label><?php echo esc_html('Division Name:'); ?></label>
						  <input type="text" name="division_name" value="" id="division_name" class="log-in-input" />
						</div>
						<div class="block2_1">
						  <label><?php echo esc_html('Event Name:'); ?></label>
						  <?php $events = LBDgetAllFields($table4); ?>
						  <select name="division_event" id="division_event" class="log-in-input">
							<option value="">-- Select Event --</option>
							<?php foreach($events as $eve){ ?>
							<option value="<?php echo $eve->id; ?>"><?php echo $eve->event_name; ?></option>
							<?php } ?>
						  </select>
						</div>
					  </div>
					  <div class="blockCustom">
						<input type="submit" name="add_division" value="Add Division" class="log-in-submit addDivision" />
					  </div>
					</div>
				  </div>
				</form>
			<?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
