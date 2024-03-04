<?php
require_once('./stripe/init.php'); 
			$striperesult 		= $dbClass->getTableRecordSingle("payment_settings",'payment_settings_id=?',array(2));
			$stripe_api_key		= trim($striperesult['payment_settings_account']);
			$stripe_paymode		= $striperesult['payment_settings_paymod'];
			
			\Stripe\Stripe::setApiKey($stripe_api_key);	
			//Stripe::setApiVersion("2016-03-07");
			
			$charge_price = $total_amount * 100;
			try 
			{
				$myCard = array('number' => trim($cc_no), 'exp_month' => trim($exp_month), 'exp_year' => trim($exp_year));
				$charge = \Stripe\Charge::create(array('card' => $myCard, 'amount' => $charge_price, 'currency' => 'usd'));
			}
			catch(\Stripe\Error\Card $e)
			{
			  $e_json = $e->getJsonBody();
			  $error = $e_json['error'];
			  $errorFlag = 1;
			  $errorList[] = $error['message'];
			 // print_r($error);
			}
			if($charge->paid==1 || $charge->paid==true) // payment success
			{
				$chargeID = $charge->id;
				
			}
			else
			{
				
			}