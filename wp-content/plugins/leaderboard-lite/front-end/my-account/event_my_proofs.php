<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="compititor-regi-main">
	<h3 style="padding-top:25px;"><?php echo esc_html('Proofs'); ?></h3>
	<div class="compititor-regi-cont clearfix">
		<?php
			$scores = LBDgetAllFields($table2,"participant_id",$participantID); 
			$i = 1;
		?>
		<div class="scorebord-table">
			<div class="resize-table">
				<table class="table-box"  border="0" cellpadding="0" cellspacing="0">
					<tr class="firstTR">
						<td>#</td>
						<td><?php echo esc_html('Event Name'); ?></td>
						<td><?php echo esc_html('Workout'); ?></td>
						<td><?php echo esc_html('Proofs'); ?></td>
						<td><?php echo esc_html('Uploaded on'); ?></td>
					</tr>
					<?php 
					foreach($scores as $score){
						if($score->proof != ''){ ?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo LBDgetNameById($table4, "event_name", "id", $score->event_id); ?></td>
							<td><?php echo LBDgetNameById($table7, "workout", "id", $score->workout_id); ?></td>
							<td>
								<table>
								<?php $pa = explode(",", $score->proof); ?>
								<?php foreach($pa as $p){ ?>
								<tr>
									<td class="proofData"><a href="<?php echo wp_get_attachment_url( $p ); ?>" target="_blank"><img src="<?php echo LBD_DIR; ?>img/multimediaicon.png" width="25px" /><?php echo get_the_title( $p ); ?></a></td>
								</tr>
								<?php } ?>
								</table>
							</td>
							<td><?php echo date("dS M, Y",strtotime($score->modified_date)); ?></td>
						</tr>
						<?php 
						$i++;
						}
					} ?>
				</table>
			</div>
		</div>
	</div>
</div>