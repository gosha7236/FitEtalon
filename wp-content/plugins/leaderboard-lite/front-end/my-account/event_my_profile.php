<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php if($successMsg){ ?><span class="GrnMsgBar"><?php echo $successMsg; ?></span><?php } ?>
<div class="compititor-regi-main">
	<h3 style="padding-top:25px;"><?php echo esc_html('My Profile'); ?></h3>
	<form name="EveMyProfile" method="post">
		<input type="hidden" name="participant_id" value="<?php echo $participant->id; ?>" />
		<div class="compititor-regi-cont clearfix">
			<div class="compititor-regi-left">
				<ul>
					<li class="clearfix">
						<label><?php echo esc_html('Full Name'); ?></label>
						<div class="compititor-input">
							<input type="text" class="compititor-input-box" value="<?php echo $participant->participant_name; ?>" name="participant_name" id="participant_name" />
						</div>
					</li>
					<li class="clearfix">
						<label><?php echo esc_html('Email ID'); ?></label>
						<div class="compititor-input">
							<input type="text" class="compititor-input-box" value="<?php echo $participant->email; ?>" readonly />
						</div>
					</li>
					<li class="clearfix">
						<label><?php echo esc_html('User Name'); ?></label>
						<div class="compititor-input">
							<input type="text" class="compititor-input-box" value="<?php echo $participant->user_name; ?>" readonly />
						</div>
					</li>
					<li class="clearfix">
						<label><?php echo esc_html('DOB'); ?></label>
						<div class="compititor-input">
							<input type="text" class="compititor-input-box" value="<?php echo $participant->dob; ?>" name="participant_dob" id="participant_dob" />(In <b>yyyy-mm-dd</b> format)
						</div>
					</li>
					<li class="clearfix">
						<label><?php echo esc_html('Age'); ?></label>
						<div class="compititor-input">
							<input type="text" class="compititor-input-box" value="<?php echo $participant->age; ?>" name="participant_age" id="participant_age" />
						</div>
					</li>
					<li class="clearfix">
						<label><?php echo esc_html('Gender'); ?></label>
						<div class="compititor-input">
							<select class="compititor-input-box" name="participant_gender" id="participant_gender">
								<option value="F" <?php if($participant->gender=="F"){ echo " selected"; }?>><?php echo esc_html('Female'); ?></option>
								<option value="M" <?php if($participant->gender=="M"){ echo " selected"; }?>><?php echo esc_html('Male'); ?></option>
							</select>
						</div>
					</li>
					<li class="clearfix">
						<label><?php echo esc_html('Phone Number'); ?></label>
						<div class="compititor-input">
							<input type="text" class="compititor-input-box" value="<?php echo $participant->phonenum; ?>" name="participant_phonenum" id="participant_phonenum" />
						</div>
					</li>
				</ul>
			</div>
			<div class="compititor-regi-right">
				<ul>
					<li class="clearfix">
						<label><?php echo esc_html('Address'); ?></label>
						<div class="compititor-input">
							<textarea class="compititor-textarea" name="participant_address" id="participant_address"><?php echo $participant->address; ?></textarea>
						</div>
					</li>
					<li class="clearfix">
						<label><?php echo esc_html('Division'); ?></label>
						<div class="compititor-input">
						<?php $divisions = LBDgetAllFields($table3,"id", $participant->division); foreach( $divisions as $div){$div_name=$div->division_name;} ?>
							<input type="text" class="compititor-input-box" value="<?php echo $div_name; ?>" readonly />
						</div>
					</li>
					<li class="clearfix">
						<label><?php echo esc_html('Registration Date'); ?></label>
						<div class="compititor-input">
							<input type="text" class="compititor-input-box" value="<?php echo $participant->registration_date; ?>" readonly />
						</div>
					</li>
					<li class="clearfix">
						<label><?php echo esc_html('Registration Fee remitted'); ?></label>
						<div class="compititor-input">
							<input type="text" class="compititor-input-box" value="<?php echo $participant->registration_fee; ?>" readonly />
						</div>
					</li>
					<input type="hidden" class="compititor-input-box" value="<?php echo $participant->payment_status; ?>" />
				</ul>
			</div>
		</div>
		<div class="submit-block clearfix">
			<div class="submit-right-block">
				<input type="submit" class="Submit-btn" value="Update Info" name="UpdateEveCompetitor">
			</div>
		</div>
	</form>
</div>