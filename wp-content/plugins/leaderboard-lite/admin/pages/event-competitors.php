<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php 
	global $wpdb;
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$options = get_option('LeaderBoardSettings');
?>
<section class="commen-wraper scorebord-table-block">
    <div class="plugin-container">
        <div class="scorebord-table-main">
		<span class="ResultArea"></span>
            <div id="parentHorizontalTab">
                <ul class="resp-tabs-list hor_1">
					<li><?php echo esc_html('Competitors'); ?></li>
                    <li><?php echo esc_html('Add Competitor'); ?></li>
                </ul>
                <div class="resp-tabs-container hor_1">
                    <div>
                       <div class="scorebord-table">
                            <div class="resize-table competitorTable">
							<?php $competitors = LBDgetAllFields($table1); $i=1;?>
							<?php if($competitors){ ?>
                                <table class="table-box" border="0" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo esc_html('Competitor'); ?></th>
											<th><?php echo esc_html('Division'); ?></th>
											<th><?php echo esc_html('Registration Date'); ?></th>
											<th><?php echo esc_html('Payment Status'); ?></th>
											<th><?php echo esc_html('Action'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php foreach($competitors as $com){ ?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo ucwords($com->participant_name); ?></td>
												<?php $division = LBDgetAllFields($table3,"id",$com->division); ?>
												<?php if($division){ ?>
													<?php foreach($division as $div){ ?>
													<td><?php echo $div->division_name; ?></td>
													<?php } ?>
												<?php }else{ ?>
													<td></td>
												<?php } ?>
												<td><?php echo $com->registration_date; ?></td>
												<td class="<?php echo $com->payment_status; ?>"><?php echo ucwords($com->payment_status); ?></td>
												<td><span class ="editCompetitor editLink">Edit<input type="hidden" id="competitor_id" name="competitor_id" value="<?php echo $com->id;?>" /></span> | <span class="deleteCompetitor deleteLink">Delete<input type="hidden" id="competitor_id" name="competitor_id" value="<?php echo $com->id;?>" /></span></td>
											</tr>
										<?php $i++;} ?>
                                    </tbody>
                                </table>
							<?php }else{ ?>
								<?php echo esc_html('No Competitors Found!'); ?>
							<?php } ?>
                            </div>
                        </div>
                    </div>
                    <div>
					<form method="post" id="competitorForm" name="competitorForm">
                        <div class="scorebord-table">
                            <div class="resize-table">
                                <div class="blockCustom">
									<div class="block2_1">
										<label><?php echo esc_html('Competitor Name:'); ?></label>
										<input type="text" name="competitor_name" value="" id="competitor_name" class="log-in-input" />
									</div>
									<div class="block2_1">
										<label><?php echo esc_html('Gender:'); ?></label>
										<select name="competitor_gender" id="competitor_gender" class="log-in-input">
											<option value="">-- Select Option --</option>
											<option value="M">Male</option>
											<option value="F">Female</option>
										</select>
									</div>
								</div>
								 <div class="blockCustom">
									<div class="block2_1">
										<label><?php echo esc_html('DOB(YYYY-MM-DD):'); ?></label>
										<input type="text" name="competitor_dob" value="" id="competitor_dob" class="log-in-input" />
									</div>
									<div class="block2_1">
										<label><?php echo esc_html('Age:'); ?></label>
										<input type="text" name="competitor_age" value="" id="competitor_age" class="log-in-input" style="width:50px;" />
									</div>
								</div>
								 <div class="blockCustom">
									<div class="block2_1">
										<label><?php echo esc_html('EmailID:'); ?></label>
										<input type="text" name="competitor_email" value="" id="competitor_email" class="log-in-input" />
									</div>
									<div class="block2_1">
										<label><?php echo esc_html('Phone Number:'); ?></label>
										<input type="text" name="competitor_phone" value="" id="competitor_phone" class="log-in-input" />
									</div>
								</div>
								 <div class="blockCustom">
									<div class="block2_1">
										<label><?php echo esc_html('Division:'); ?></label>
										<?php $divisions = LBDgetAllFields($table3); ?>
										<select name="competitor_division" id="competitor_division" >
											<option value="">-Select Division-</option>
											<?php foreach($divisions as $div){ ?>
											<option value="<?php echo $div->id; ?>"><?php echo $div->division_name; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="block2_1">
										<label><?php echo esc_html('Registration Date:'); ?></label>
										<input type="text" name="competitor_reg_date" value="" id="competitor_reg_date" class="log-in-input" />
									</div>
								</div>
								 <div class="blockCustom">
									<div class="block2_1">
										<label><?php echo esc_html('Registration Fee:'); ?></label>
										<input type="text" name="competitor_reg_fee" value="<?php echo $options["memberFee_individual"]; ?>" id="competitor_reg_fee" class="log-in-input" style="width:150px;" />In  
										<select name="competitor_reg_fee_currency" id="competitor_reg_fee_currency">
											<?php echo LBDCurrencies( $options["memberFee_individual_currency"]); ?>
										</select>
									</div>
									<div class="block2_1">
										<label><?php echo esc_html('Payment Status:'); ?></label>
										<?php $payStatus = array("pending"=>"Pending","hold"=>"On Hold","cancelled"=>"Cancelled","completed"=>"Completed"); ?>
										<select name="competitor_payment_status" id="competitor_payment_status" class="log-in-input">
											<option value="">-- Select Option --</option>
											<?php foreach($payStatus as $ps=>$val){ ?>
											<option value="<?php echo $ps; ?>"><?php echo $val; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="blockCustom">
									<div class="block2_1">
										<label><?php echo esc_html('Status:'); ?></label>
										<input type="checkbox" name="competitor_status" id="competitor_status" /><?php echo esc_html(' ( Tick to activate Membership )'); ?>
									</div>
								</div>
								<div class="blockCustom">
									<input type="submit" name="add_competitor" value="Add Competitor" class="log-in-submit addCompetitor" />
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