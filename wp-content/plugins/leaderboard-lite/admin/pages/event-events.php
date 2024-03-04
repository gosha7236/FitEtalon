<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php 
global $wpdb;
$table4 = $wpdb->prefix . "lbd_event_events";  
$table5 = $wpdb->prefix . "lbd_event_competitions"; 
$LeaderBoard_eventspage 	= get_option('LeaderBoard_eventspage');
?>
<section class="commen-wraper scorebord-table-block">
    <div class="plugin-container">
        <div class="scorebord-table-main">
		<span class="ResultArea"></span>
            <div id="parentHorizontalTab">
                <ul class="resp-tabs-list hor_1">
                    <li><?php echo esc_html('Events'); ?></li>
                    <li><?php echo esc_html('Add Event'); ?></li>
                </ul>
                <div class="resp-tabs-container hor_1">
                    <div>
                       <div class="scorebord-table">
                            <div class="resize-table eventTable">
							<?php $events = LBDgetAllFields($table4); $i=1;?>
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
										<?php if($events){ ?>
											<?php foreach($events as $event){ ?>
												<tr>
													<td><?php echo $i; ?></td>
													<td><?php echo $event->event_name; ?></td>
													<td><?php echo $event->from_date; ?></td>
													<td><?php echo $event->to_date; ?></td>
													<?php $event_user = get_user_by( 'email',  $event->event_organizer_email);?>
													<?php $current_user = wp_get_current_user(); ?>
													<td><?php echo $event_user->display_name; ?></td>
													<td><?php echo $event->event_type; ?></td>
													<?php if($current_user->user_email == $event->event_organizer_email || is_admin() ){ ?>
														<td width="150px;" style="text-align:justify;">
														<span class ="editEvent editLink">Edit<input type="hidden" id="event_id" name="event_id" value="<?php echo $event->id;?>" /></span> 
														<?php if(get_option("LBD_version")=="PRO"){ ?>
														<span class="deleteEvent deleteLink">Delete<input type="hidden" id="event_id" name="event_id" value="<?php echo $event->id;?>" /></span>
														<?php } ?>
														<span class ="previewEvent previewLink"><a href="<?php echo get_permalink($LeaderBoard_eventspage)."?id=".$event->id; ?>" target="_blank"><img src="<?php echo LBD_DIR."img/QuickView.png"; ?>" /></a></span> 
														</td>
													<?php }else{ ?>
													<td><span style="color:#FF0000"><?php echo esc_html('You have no permission to edit/delete this event'); ?></span></td>
													<?php } ?>
												</tr>
											<?php $i++;} ?>
										<?php }else{ ?>
											<tr>
												<td colspan="7"><?php echo esc_html('No Events found!'); ?></td>
											</tr>
										<?php } ?>
                                    </tbody>
                                </table>
								<span style="color:red; text-align:right; width:100%; display:block; margin-top:20px;"><?php echo esc_html('* You have allowed to create a single Event with this plan.Please upgrade to our PRO version for unlimited events!'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div>
					<?php $EventCount = count($events);  ?>
					<?php if(get_option("LBD_version")=="FREE" && $EventCount>=1){ ?>
						<span style="color:#ca3030;">Sorry, you can't add more events to this site. Please <a href="https://wpleaderboard.com">Upgrade</a> to our PRO version for unlimited events!</span>
					<?php }else{ ?>
						<form method="post" id="eventForm" name="eventForm">
							<div class="scorebord-table">
								<div class="resize-table">
								
									<h3><?php echo esc_html('Your Details'); ?></h3>
									<?php $current_user = wp_get_current_user(); ?>
									<div class="blockCustom">
										<div class="block2_1">
											<label><?php echo esc_html('Name:'); ?></label><input type="text" name="event_organizer_name" value="<?php echo $current_user->display_name; ?>" id="event_organizer_name" class="log-in-input" readonly />
										</div>
										<div class="block2_1">
											<label><?php echo esc_html('Email:'); ?></label><input type="text" name="event_organizer_email" value="<?php echo $current_user->user_email; ?>" id="event_organizer_email" class="log-in-input" readonly />
										</div>
									</div>
									
									<div class="seperator"></div>
									<h3><?php echo esc_html('Event Details'); ?></h3>
									<div class="blockCustom">
										<div class="block2_1">
											<label><?php echo esc_html('Event Name:'); ?></label> <input type="text" class="log-in-input" name="event_name" id="event_name" value=""  />
										</div>
										<div class="block2_1">
											<label><?php echo esc_html('Event Type:'); ?></label> 
											<select name="event_type" id="event_type">
												<option value="individual">Individual</option>
												<?php /*?><option value="team">Team</option><?php */?>
											</select>
										</div>
										<div class="block2_1">
											<label><?php echo esc_html('Competition:'); ?></label>
											<?php $competitions = LBDgetAllFields($table5); $i=1; ?>
											<select name="event_competition" id="event_competition" >
												<option value="">-Select Competition-</option>
												<?php foreach($competitions as $com){ ?>
												<option value="<?php echo $com->id; ?>"><?php echo $com->competition_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="seperator"></div>
									
									<h3><?php echo esc_html('When'); ?></h3>
									<div class="blockCustom">
										<div class="block2_1">
											<label><?php echo esc_html('From:'); ?></label>
											<input type="text" name="event_from" value="" id="event_from" class="log-in-input" />
											<select name="event_time_from" id="event_time_from">
												<?php echo LBD_TimeSlotes(); ?>
											</select>
										</div>
										<div class="block2_1">
											<label><?php echo esc_html('To:'); ?></label>
											<input type="text" name="event_to" value="" id="event_to" class="log-in-input" />
											<select name="event_time_to" id="event_time_to">
												<?php echo LBD_TimeSlotes(); ?>
											</select>
										</div>
									</div>
									 <div class="blockCustom">
										<div class="block2_1">
											<?php echo esc_html('All the day event? '); ?><input type="checkbox" name="event_time_fullday" id="event_time_fullday"  />
										</div>
									</div>
									
									<div class="seperator"></div>
									
									<h3><?php echo esc_html('Where'); ?></h3>
									<div class="blockCustom">
										<div class="block2_1">
											<label><?php echo esc_html('Location Name:*'); ?></label>
											<input type="text" name="event_location" value="" id="event_location" class="log-in-input" />
										</div>
										<div class="block2_1">
											<label><?php echo esc_html('Region:'); ?></label>
											<input type="text" name="event_region" value="" id="event_region" class="log-in-input" />
										</div>
									</div>
									<div class="blockCustom">
										<div class="block2_1">
											<label><?php echo esc_html('Address:*'); ?></label>
											<input type="text" name="event_address" value="" id="event_address" class="log-in-input" />
										</div>
										<div class="block2_1">
											<label><?php echo esc_html('Country:'); ?></label>
											<select name="event_country" id="event_country" >
												<?php echo LBD_getCountries(); ?>
											</select>
										</div>
									</div>
									<div class="blockCustom">
										<div class="block2_1">
											<label><?php echo esc_html('City/Town:'); ?></label>
											<input type="text" name="event_city" value="" id="event_city" class="log-in-input" />
										</div>
										<div class="block2_1">
											<label><?php echo esc_html('Post code:'); ?></label>
											<input type="text" name="event_po" value="" id="event_po" class="log-in-input" />
										</div>
									</div>
									<div class="blockCustom">
										<div class="block2_1">
											<label><?php echo esc_html('Latitude:'); ?></label>
											<input type="text" name="event_latitude" value="" id="event_latitude" class="log-in-input" />
										</div>
										<div class="block2_1">
											<label><?php echo esc_html('Longitude:'); ?></label>
											<input type="text" name="event_longitude" value="" id="event_longitude" class="log-in-input" />
										</div>
										<div class="note"><?php echo esc_html('? Please get the Latitude and Longitude of your location from Google Maps.'); ?></div>
									</div>
									
									<div class="seperator"></div>
									
									<h3><?php echo esc_html('Details'); ?></h3>
									<div class="blockCustom"> 
										<label><?php echo esc_html('Event Details:'); ?></label>
										<?php 
										$editor_id = 'event_desc';
										$event_desc = "";
										wp_editor( $event_desc, $editor_id );
										?>
									</div>
									<div class="blockCustom">
										<label><?php echo esc_html('Event Image:'); ?></label>
										<input id="upload_image" type="text" size="36" name="event_image" />
										<input id="upload_image_button" type="button" value="Upload Image" />
									</div>
									<div class="blockCustom">
										<label><?php echo esc_html('Event Website:'); ?></label>
										<input type="text" name="event_website" value="" id="event_website" class="log-in-input" />
									</div>
																	
									<div class="seperator"></div>
									
									<h3><?php echo esc_html('Settings - Event Registration'); ?></h3>
									<div class="blockCustom"> 
											<?php echo esc_html('Enable Booking for this Event?:'); ?> &nbsp;<input type="checkbox" name="event_enable_booking" id="event_enable_booking"  />
									</div>
									<div class="blockCustom"> 
										<label><?php echo esc_html('Registration End Date:'); ?></label>
										<input type="text" name="event_endof_reg_date" value="" id="event_endof_reg_date" class="log-in-input" /> by 
										<select name="event_endof_reg_time" id="event_endof_reg_time">
											<?php echo LBD_TimeSlotes(); ?>
										</select>
									</div>
									<div class="blockCustom" id="eventFee" style="display:none;"> 
										<label><?php echo esc_html('Event Fee:'); ?> </label> <input type="text" name="event_fee" id="event_fee" class="log-in-input" /> In  <select name="event_fee_currency" id="event_fee_currency">
											<option value="USD">USD</option>
											<option value="EUR">EUR</option>
											<option value="GBP">GBP</option>
										</select>
										<br />
										<div class="note"><?php echo esc_html('? Empty event fee means the event is free/open to all.'); ?></div>
									</div>
									
									<div class="seperator"></div>
									
									<div class="blockCustom"> 
										<input type="submit" name="add_event" value="Add Event" class="log-in-submit addEvent" /> 
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