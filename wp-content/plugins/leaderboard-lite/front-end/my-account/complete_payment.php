<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="compititor-regi-main">
	<h3><?php echo esc_html('Pay now'); ?></h3>
	<form action="<?php echo get_permalink($LeaderBoard_Payment); ?>?action=activate_eve_accnt" method="POST" id="EnablepaymentForm">
		<div class="compititor-regi-cont clearfix">
			<div class="compititor-regi-left">
				<ul>
					<li class="clearfix">
						<label><?php echo esc_html('Full Name'); ?> <span class="redFont">*</span></label>
						<div class="compititor-input">
							<input type="text" class="compititor-input-box" name="custName" id="comp_fullname" value="<?php echo $current_user->display_name; ?>" readonly="">
						</div>
					</li>
					<li class="clearfix">
						<label><?php echo esc_html('Registration Fee'); ?></label>
						<div class="compititor-input">
							<input type="text" class="compititor-input-box" name="regFeeAmt" id="comp_fee" value="<?php echo $participantRegFee; ?>"  style="width:200px; display:inline-block;" readonly="">  <?php echo $options['memberFee_individual_currency']; ?>
							<input type="hidden" name="regFeeCurrency" value="<?php echo $options['memberFee_individual_currency']; ?>" />
						</div>
					</li>
				</ul>
			</div>
			<div class="compititor-regi-right">
				<ul>
					<li class="clearfix">
						<label><?php echo esc_html('Email Address'); ?> <span class="redFont">*</span></label>
						<div class="compititor-input">
							<input type="text" class="compititor-input-box" name="custEmail" id="comp_email" value="<?php echo $current_user->user_email; ?>" readonly="">
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="compititor-regi-cont clearfix">
			<div class="compititor-regi-left">
				<ul class="clearfix">
					<li>
						<label><?php echo esc_html('Card Number'); ?></label>
						<input type="text" name="cardNumber" size="20" autocomplete="off" id="cardNumber" class="form-control">
					</li>
					<li>
						<label><?php echo esc_html('CVC'); ?></label>
						<input type="text" name="cardCVC" size="4" autocomplete="off" id="cardCVC" class="form-control">
					</li>
				</ul>
			</div>
			<div class="compititor-regi-right">
				<ul class="clearfix">
					<li>
						<label><?php echo esc_html('Expiration (MM/YYYY)'); ?></label>
						<input type="text" name="cardExpMonth" placeholder="MM" size="2" id="cardExpMonth" class="form-control" style="width:100px; margin-right:10px; float:left;"> 
						<input type="text" name="cardExpYear" placeholder="YYYY" size="4" id="cardExpYear" class="form-control" style="width:100px;">
					</li>
					<li>
					<span class="notes" style="background:#dc0b0b9e; border-left:5px solid red;">
						<?php echo esc_html('Development Mode is ON: Please use the following details.'); ?><br>
						<?php echo esc_html('Card Number: 4242424242424242'); ?><br>
						<?php echo esc_html('CVC:123'); ?><br>
						<?php echo esc_html('Expiry date: 12/2019'); ?>
					</span>
					</li>
				</ul>
			</div>
		</div>
		
		<span class="paymentErrors" style="color:red;"></span>
		
		<div class="submit-block clearfix">
			<div class="submit-right-block">
			<input type="submit" class="Submit-btn" name="EnableCompetitorReg" id="EnableCompetitorReg" value="Proceed to pay">
			</div>
		</div>
	</form>
</div>