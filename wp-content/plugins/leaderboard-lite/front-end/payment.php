<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php get_header(); ?>
<?php global $wpdb, $post; ?>
<?php
if(is_user_logged_in() && current_user_can('event_participant')){
	//Proceed
}else{
	die("Not have enough permission to view this page");
}
	date_default_timezone_set("UTC");
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	$table7 = $wpdb->prefix . "lbd_event_workouts"; 
	$table8 = $wpdb->prefix . "lbd_event_registration_transaction"; 
	
	$allEvents = LBDgetAllFields($table4);
	
	$redirect_to = get_option('LeaderBoard_eventUserLogin');
	$my_account_page = get_permalink(get_option('LeaderBoard_eventMyAccount'));
	$LeaderBoardSettings = get_option('LeaderBoardSettings');
	
	extract($_REQUEST); 
	
	$stripeToken = (isset($_POST['stripeToken']))?sanitize_text_field($_POST['stripeToken']):"";
	$action 			= (isset($_POST['action']))?sanitize_text_field($_GET['action']):"";
	
if(!empty($stripeToken)){
	if(isset($action) && $action == "activate_eve_accnt"){
		//Its membership activation page
		/***************************************START************************************/
		$custName = sanitize_text_field($_POST['custName']);
		$custEmail = sanitize_email($_POST['custEmail']);
		$cardNumber = sanitize_text_field($_POST['cardNumber']);
		$cardCVC = sanitize_text_field($_POST['cardCVC']);
		$cardExpMonth = sanitize_text_field($_POST['cardExpMonth']);
		$cardExpYear = sanitize_text_field($_POST['cardExpYear']);    
		require_once(dirname(__FILE__) .'/stripe-php/init.php');    
	
		if($LeaderBoardSettings['enable_stripeTestMode']==1){
			$stripe = array(
			  "secret_key"      => "sk_test_OiTHj8sLJeYzajQpK8h9eb8G",
			  "publishable_key" => "pk_test_nddHOsaIrUVSkmrzYC9Gt1nY"
			); 
		}else{
			$stripe = array(
			  "secret_key"      => $LeaderBoardSettings['stripe_secret'],
			  "publishable_key" => $LeaderBoardSettings['stripe_publishable']
			); 
		}
		
		   
		\Stripe\Stripe::setApiKey($stripe['secret_key']);    
		$customer = \Stripe\Customer::create(array(
			'email' => $custEmail,
			'source'  => $stripeToken
		));   
		
		$itemName = "EventLeaderBoard Membership";
		$itemNumber = "PHPZA968574";
		$itemPrice = sanitize_text_field($_POST['regFeeAmt']);
		$currency = strtolower(sanitize_text_field($_POST['regFeeCurrency']));
		$eventID = 0;		
		
		try {
		  // Use a Stripe PHP library method that may throw an exception....
		  $payDetails = \Stripe\Charge::create(array(
			'customer' => $customer->id,
			'amount'   => $itemPrice,
			'currency' => $currency,
			'description' => $itemName
		));    
		} catch (\Stripe\Error\Base $e) {
		  echo($e->getMessage());
		} catch (Exception $e) {
			//Do nothing
		}
		$paymenyResponse = $payDetails->jsonSerialize();
		if($paymenyResponse['amount_refunded'] == 0 && empty($paymenyResponse['failure_code']) && $paymenyResponse['paid'] == 1 && $paymenyResponse['captured'] == 1){
			
			$amountPaid = $paymenyResponse['amount'];
			$balanceTransaction = $paymenyResponse['balance_transaction'];
			$paidCurrency = $paymenyResponse['currency'];
			$paymentStatus = $paymenyResponse['status'];
			$paymentDate = date("Y-m-d H:i:s");        
			$sql1  = "INSERT INTO ".$table8." (`cust_name`, `cust_email`, `card_number`, `card_cvc`, `card_exp_month`, `card_exp_year`,`item_name`, `item_number`, `item_price`, `item_price_currency`, `paid_amount`, `paid_amount_currency`, `txn_id`, `payment_status`, `created`, `modified`) VALUES ('".$custName."','".$custEmail."','".$cardNumber."','".$cardCVC."','".$cardExpMonth."','".$cardExpYear."','".$itemName."','".$itemNumber."','".$itemPrice."','".$paidCurrency."','".$amountPaid."','".$paidCurrency."','".$balanceTransaction."','".$paymentStatus."','".$paymentDate."','".$paymentDate."')";
			dbDelta( $sql1 );
			$lastInsertId = $wpdb->insert_id;
			$paymentMessage = "<span class='notes' style='text-align:center;'><strong>Payment Completed. Please visit your account: </strong><strong><a href='".$my_account_page."'>DashBoard</a></strong></span>";
			$payment_status = ($paymentStatus=="succeeded")?"completed":"pending"; 
			$user_status = ($paymentStatus=="succeeded")?1:0;
			$sql2  = 'UPDATE '.$table1.'  SET payment_status="'.$payment_status.'", status='.$user_status.' WHERE email ="'.$custEmail.'"'; 
			dbDelta( $sql2 );
		} else{
			$paymentMessage = "Payment failed!!";
		}
		/***************************************END************************************/
	}else{
		//Its event registration page
		/***************************************START************************************/
		$stripeToken  = sanitize_text_field($_POST['stripeToken']);
		$custName = sanitize_text_field($_POST['custName']);
		$custEmail = sanitize_email($_POST['custEmail']);
		$cardNumber = sanitize_text_field($_POST['cardNumber']);
		$cardCVC = sanitize_text_field($_POST['cardCVC']);
		$cardExpMonth = sanitize_text_field($_POST['cardExpMonth']);
		$cardExpYear = sanitize_text_field($_POST['cardExpYear']);    
		require_once(dirname(__FILE__) .'/stripe-php/init.php');    
		
		if($LeaderBoardSettings['enable_stripeTestMode']==1){
			$stripe = array(
			  "secret_key"      => "sk_test_OiTHj8sLJeYzajQpK8h9eb8G",
			  "publishable_key" => "pk_test_nddHOsaIrUVSkmrzYC9Gt1nY"
			); 
		}else{
			$stripe = array(
			  "secret_key"      => $LeaderBoardSettings['stripe_secret'],
			  "publishable_key" => $LeaderBoardSettings['stripe_publishable']
			); 
		}
		 
		\Stripe\Stripe::setApiKey($stripe['secret_key']);    
		$customer = \Stripe\Customer::create(array(
			'email' => $custEmail,
			'source'  => $stripeToken
		));    
		$itemName = "Event Subscription";
		$itemNumber = "PHPZAG987654321";
		$itemPrice = sanitize_text_field($_POST['regFeeAmt']);
		$currency = strtolower(sanitize_text_field($_POST['regFeeCurrency']));
		$eventID = sanitize_text_field($_POST['eventID']);   
		$payDetails = \Stripe\Charge::create(array(
			'customer' => $customer->id,
			'amount'   => $itemPrice,
			'currency' => $currency,
			'description' => $itemName,
			'metadata' => array(
				'event_id' => $eventID
			)
		));    
		$paymenyResponse = $payDetails->jsonSerialize();

		if($paymenyResponse['amount_refunded'] == 0 && empty($paymenyResponse['failure_code']) && $paymenyResponse['paid'] == 1 && $paymenyResponse['captured'] == 1){
			$amountPaid = $paymenyResponse['amount'];
			$balanceTransaction = $paymenyResponse['balance_transaction'];
			$paidCurrency = $paymenyResponse['currency'];
			$paymentStatus = $paymenyResponse['status'];
			$paymentDate = date("Y-m-d H:i:s");        
			$sql1  = "INSERT INTO ".$table8." (`cust_name`, `cust_email`, `card_number`, `card_cvc`, `card_exp_month`, `card_exp_year`,`item_name`, `item_number`, `item_price`, `item_price_currency`, `paid_amount`, `paid_amount_currency`, `txn_id`, `payment_status`, `created`, `modified`) VALUES ('".$custName."','".$custEmail."','".$cardNumber."','".$cardCVC."','".$cardExpMonth."','".$cardExpYear."','".$itemName."','".$itemNumber."','".$itemPrice."','".$paidCurrency."','".$amountPaid."','".$paidCurrency."','".$balanceTransaction."','".$paymentStatus."','".$paymentDate."','".$paymentDate."')";
			dbDelta( $sql1 );
			$lastInsertId = $wpdb->insert_id;
			$paymentMessage = "<span class='notes' style='text-align:center;'><strong>You have successfully registered to the Event. Please add scores from your account </strong><strong><a href='".$my_account_page."?scores'>DashBoard</a></strong></span>";
			$payment_status = ($paymentStatus=="succeeded")?1:0;
			$sql2  = "INSERT INTO ".$table6." (`event_id`, `participant`, `transaction_id`, `payment_status`, `registration_status`) VALUES ('".$eventID."','".$custEmail."','".$lastInsertId."',".$payment_status.",1)"; 
			dbDelta( $sql2 );
		} else{
			$paymentMessage = "Payment failed!!";
		}
		/***************************************END************************************/
	}
} else{
    $paymentMessage = "You're in wrong place. Contact site admin";
}
echo $paymentMessage; ?>
<?php get_footer(); ?>