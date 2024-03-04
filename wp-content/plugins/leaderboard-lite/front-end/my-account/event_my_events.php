<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="compititor-regi-main">
	<h3 style="padding-top:25px;"><?php echo esc_html('My Registered Events'); ?></h3>
	<div class="compititor-regi-cont clearfix">
	<?php 
	$RegEvents = LBDgetAllFields($table6,"participant", $participant->email); 
	?>
	<div class="scorebord-table">
		<div class="resize-table">
		<?php if($RegEvents){ ?>
			<table class="table-box"  border="0" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th><?php echo esc_html('Event Name'); ?></th>
						<th><?php echo esc_html('Event Start on'); ?></th>
						<th><?php echo esc_html('Payment Status'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php $i =1; ?>
				<?php foreach($RegEvents as $eve){ ?>
					<?php
					$allEvents = LBDgetAllFields($table4,"id",$eve->event_id);
					foreach($allEvents as $event){$eveData = $event;}
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $eveData->event_name; ?></td>
						<td><?php echo date("d M, Y", strtotime($eveData->from_date)); ?></td>
						<td><?php if($eve->payment_status==0){ echo '<b style="color:red">Pending</b> <br /> <a class="common-btn">Complete Your Payment Now!</a>'; }else{echo "Completed";} ?></td>
					</tr>
				<?php $i++;} ?>
				</tbody>
			</table>
			<?php }else{?>
				<?php echo esc_html('No Registered Events Found !. Explore the'); ?> <a href="<?php echo get_permalink($LeaderBoard_eventspage); ?>" target="_blank"><b>Events</b></a> page
			<?php } ?>
		</div>
	</div>
	</div>
</div>