<?php 
//check if stripe token exist to proceed with payment
if(!empty(sanitize_text_field($_POST['stripeToken']))){ 
    // get token and user details
    $stripeToken  = sanitize_text_field($_POST['stripeToken']);
    $custName = sanitize_text_field($_POST['custName']);
    $custEmail = sanitize_email($_POST['custEmail']);
    $cardNumber = sanitize_text_field($_POST['cardNumber']);
    $cardCVC = sanitize_text_field($_POST['cardCVC']);
    $cardExpMonth = sanitize_text_field($_POST['cardExpMonth']);
    $cardExpYear = sanitize_text_field($_POST['cardExpYear']);    
    //include Stripe PHP library
    require_once('stripe-php/init.php');    
    //set stripe secret key and publishable key
    $stripe = array(
      "secret_key"      => "sk_test_OiTHj8sLJeYzajQpK8h9eb8G",
      "publishable_key" => "pk_test_nddHOsaIrUVSkmrzYC9Gt1nY"
    );    
    \Stripe\Stripe::setApiKey($stripe['secret_key']);    
    //add customer to stripe
    $customer = \Stripe\Customer::create(array(
        'email' => $custEmail,
        'source'  => $stripeToken
    ));    
    // item details for which payment made
    $itemName = "phpzag test item";
    $itemNumber = "PHPZAG987654321";
    $itemPrice = 50;
    $currency = "usd";
    $orderID = "SKA987654321";    
    // details for which payment performed
    $payDetails = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount'   => $itemPrice,
        'currency' => $currency,
        'description' => $itemName,
        'metadata' => array(
            'order_id' => $orderID
        )
    ));    
    // get payment details
    $paymenyResponse = $payDetails->jsonSerialize();
    // check whether the payment is successful
    if($paymenyResponse['amount_refunded'] == 0 && empty($paymenyResponse['failure_code']) && $paymenyResponse['paid'] == 1 && $paymenyResponse['captured'] == 1){
        // transaction details 
        $amountPaid = $paymenyResponse['amount'];
        $balanceTransaction = $paymenyResponse['balance_transaction'];
        $paidCurrency = $paymenyResponse['currency'];
        $paymentStatus = $paymenyResponse['status'];
        $paymentDate = date("Y-m-d H:i:s");        
        //insert tansaction details into database
		include_once("db_connect.php");
        $insertTransactionSQL = "INSERT INTO transaction(cust_name, cust_email, card_number, card_cvc, card_exp_month, card_exp_year,item_name, item_number, item_price, item_price_currency, paid_amount, paid_amount_currency, txn_id, payment_status, created, modified) 
		VALUES('".$custName."','".$custEmail."','".$cardNumber."','".$cardCVC."','".$cardExpMonth."','".$cardExpYear."','".$itemName."','".$itemNumber."','".$itemPrice."','".$paidCurrency."','".$amountPaid."','".$paidCurrency."','".$balanceTransaction."','".$paymentStatus."','".$paymentDate."','".$paymentDate."')";
		mysqli_query($conn, $insertTransactionSQL) or die("database error: ". mysqli_error($conn));
        $lastInsertId = mysqli_insert_id($conn); 
       //if order inserted successfully
       if($lastInsertId && $paymentStatus == 'succeeded'){
            $paymentMessage = "<strong>The payment was successful.</strong><strong> Order ID: {$lastInsertId}</strong>";
       } else{
          $paymentMessage = "Payment failed!";
       }
    } else{
        $paymentMessage = "Payment failed!";
    }
} else{
    $paymentMessage = "Payment failed!";
}
echo $paymentMessage;