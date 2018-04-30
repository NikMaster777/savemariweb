<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class paypal {
	
	////////////////////////////////////
	//@ Create Transaction
	////////////////////////////////////
	public function create_trans($reference, $amount, $additional, $returnurl) {
		$currency = lib::getCurrency(lib::getSetting('Local_DefaultCurrency'));
		return preg_replace('/\s+/',' ','<!doctype html>
						<html>
						<head>
						<meta charset="utf-8">
						<title>Redirecting - PayPal</title>
						</head>
						<body> 
						<form action="'.config::$paypal_url.'" method="post" id="paypal-form"/>
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="notify_url" value="'.DOMAIN.'/payments-api/1/'.'">
							<input type="hidden" name="amount" value="'.$amount.'">
							<input type="hidden" name="currency_code" value="'.$currency['currency_name'].'">
							<input type="hidden" name="custom" value="'.$reference.'">
							<input type="hidden" name="business" value="'.config::$paypal_email.'">
							<input type="hidden" name="item_name" value="'.$additional.'">
							<input type="hidden" name="return_url" value="'.$returnurl.'">
						</form>
						<script type="text/javascript">document.getElementById("paypal-form").submit();</script>
						</body>
						</html>');	
	}
	
	/////////////////////////////////
	//@IPN Receiver
	/////////////////////////////////
	public function paypalIPNR() {
		try {
			
			//Load IPN CLass
			require(ROOT.'/classes/paypal/PaypalIPN.php');
			
			//IPN 
			$ipn = new PaypalIPN();
			
			//Use the sandbox endpoint during testing.
			$ipn->useSandbox();
			$verified = $ipn->verifyIPN();
			if ($verified) {
				
				/* Advert Status: 0 = Pending, 1 = Approved, 2, Removed/Cancelled/Refunded */
				
				//Require Payments Class
				require(ROOT.'/classes/payments.class.php');
				$payments=new payments;
								
				//Payment Status
				switch($_POST['payment_status']) {
					case 'Canceled_Reversal': { 
						$payments->processIPN(@$_POST['custom'], @$_POST['mc_gross'], @$_POST['mc_currency'], @$_POST['txn_id'], @$_POST['mc_fee'], 2, 1);
						break;
					}
					case 'Completed': {
						$payments->processIPN(@$_POST['custom'], @$_POST['mc_gross'], @$_POST['mc_currency'], @$_POST['txn_id'], @$_POST['mc_fee'], 1, 1);
						break;
					}
					case 'Created': { 
						//Do nothing. 
						break;
					}
					case 'Denied': { 
						//Do nothing. 
						break;
					}
					case 'Expired': {
						//Do nothing. 
						break;
					}
					case 'Failed': { 
						//Do nothing. 
						break;
					}
					case 'Pending': {
						//Do nothing.  
						break;
					}
					case 'Refunded': { 
						$payments->processIPN(@$_POST['custom'], @$_POST['mc_gross'], @$_POST['mc_currency'], @$_POST['txn_id'], @$_POST['mc_fee'], 2, 1);
						break;
					}
					case 'Reversed': { 
						$payments->processIPN(@$_POST['custom'], @$_POST['mc_gross'], @$_POST['mc_currency'], @$_POST['txn_id'], @$_POST['mc_fee'], 2, 1);
						//Do nothing. 
						break;
					}
					case 'Processed': { 
						//Do nothing. 
						break;
					}
					case 'Voided': {
						//Do nothing. 
						break;
					}
				}
				
				//
			}
			
			//Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
			header("HTTP/1.1 200 OK");
		
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	}
}