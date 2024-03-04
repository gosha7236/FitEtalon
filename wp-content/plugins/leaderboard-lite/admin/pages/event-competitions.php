<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php 
global $wpdb;
$table4 = $wpdb->prefix . "lbd_event_events"; 
$table5 = $wpdb->prefix . "lbd_event_competitions"; ?>
<section class="commen-wraper scorebord-table-block">
    <div class="plugin-container">
        <div class="scorebord-table-main">
		<span class="ResultArea"></span>
            <div id="parentHorizontalTab">
                <ul class="resp-tabs-list hor_1">
                    <li><?php echo esc_html('Competitions'); ?></li>
					<li><?php echo esc_html('Add Competition'); ?></li>
                </ul>
				<?php $c = LBDgetRowCount($table4); ?>
                <div class="resp-tabs-container hor_1">
                    <div>
                       <div class="scorebord-table">
                            <div class="resize-table competitionTable">
							<?php $competitions = LBDgetAllFields($table5); $i=1;?>
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
										<?php if($competitions){ ?>
											<?php foreach($competitions as $com){ ?>
												<tr>
													<td><?php echo $i; ?></td>
													<td><?php echo $com->competition_name; ?></td>
													<td><?php echo $com->from_date; ?></td>
													<td><?php echo $com->to_date; ?></td>
													<td><span class ="editCompetition editLink">Edit<input type="hidden" id="competition_id" name="competition_id" value="<?php echo $com->id;?>" /></span> | <span class="deleteCompetition deleteLink">Delete<input type="hidden" id="competition_id" name="competition_id" value="<?php echo $com->id;?>" /></span></td>
												</tr>
											<?php $i++;} ?>
										<?php }else{ ?>
											<tr>
												<td colspan="5">No Competitions found!</td>
											</tr>
										<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div>
					<form method="post" id="competitionForm" name="competitionForm">
                        <div class="scorebord-table">
                            <div class="resize-table">
                                <div class="blockCustom">
									<label><?php echo esc_html('Competition Name:'); ?></label><input type="text" name="competition_name" value="" id="competition_name" class="log-in-input" />
								</div>
								<div class="blockCustom">
									<div class="block2_1"><label>From:</label> <input type="text" class="log-in-input" name="competition_start_date" id="competition_start_date" value=""  /></div>
									<div class="block2_1"><label>To:</label> <input type="text" class="log-in-input" name="competition_end_date" id="competition_end_date" value=""/></div>
								</div>
								<div class="blockCustom"> 
									<label><?php echo esc_html('Details:'); ?></label>
									<?php 
									$competition_desc = "";
									$editor_id = 'competition_desc';
									wp_editor( $competition_desc, $editor_id );
									?>
									<input type="submit" name="add_competition" value="Add Competition" class="log-in-submit addCompetition" /> 
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