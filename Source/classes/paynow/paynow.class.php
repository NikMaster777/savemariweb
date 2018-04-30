<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
function ParseMsg($msg) {
	//convert to array data
	$parts = explode("&",$msg);
	$result = array();
	foreach($parts as $i => $value) {
		$bits = explode("=", $value, 2);
		$result[$bits[0]] = urldecode($bits[1]);
	}

	return $result;
}
function UrlIfy($fields) {
	//url-ify the data for the POST
	$delim = "";
	$fields_string = "";
	foreach($fields as $key=>$value) {
		$fields_string .= $delim . $key . '=' . $value;
		$delim = "&";
	}

	return $fields_string;
}
function CreateHash($values, $MerchantKey){
	$string = "";
	foreach($values as $key=>$value) {
		if( strtoupper($key) != "HASH" ){
			$string .= $value;
		}
	}
	$string .= $MerchantKey;
	$hash = hash("sha512", $string);
	return strtoupper($hash);
}
function CreateMsg($values, $MerchantKey){
	$fields = array();
	foreach($values as $key=>$value) {
	   $fields[$key] = urlencode($value);
	}

	$fields["hash"] = urlencode(CreateHash($values, $MerchantKey));

	$fields_string = UrlIfy($fields);
	return $fields_string;
}

class paynow {
	
	////////////////////////////////////
	//@ Create Transaction
	////////////////////////////////////
	public function create_trans($reference, $amount, $additional, $returnurl) {
		
		//Load IPN Functions
		//require(ROOT.'/classes/paynow/PayNowFunctions.php');
		
		//A place to store errors
		$errorsArray = array();
								
		//set POST variables
		$values = array(
				'resulturl' => DOMAIN.'/payments-api/2',
				'returnurl' =>  $returnurl,
				'reference' =>  $reference,
				'amount' =>  $amount,
				'id' =>  config::$integration_id,
				'additionalinfo' =>  $additional,
				'status' =>  'Message'); //just a simple message
		
		//Create Message from Fields		
		$fields_string = CreateMsg($values, config::$integration_key);
		
		//Start Curl Session
		$ch = curl_init();
		
		//Curl Options
		curl_setopt($ch, CURLOPT_URL, 'https://www.paynow.co.zw/interface/initiatetransaction');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
		//execute post
		$result = curl_exec($ch);
	
		if($result) {
			
			//Parse Message
			$msg = ParseMsg($result);
										
			//first check status, take appropriate action
			if ($msg["status"] == 'Error'){
				header("Location: $checkout_url");
				exit;
			}
			else if ($msg["status"] == 'Ok'){
				
				//second, check hash
				$validateHash = CreateHash($msg, config::$integration_key);
				if($validateHash != $msg["hash"]){
					$errorsArray[] =  "Paynow reply hashes do not match : " . $validateHash . " - " . $msg["hash"];
				} else {
					header("Location:".$msg["browserurl"]);
					die();
				}
				
			} else {						
				//unknown status or one you dont want to handle locally
				$errorsArray[] =  "Invalid status in from Paynow, cannot continue.";
			}
		} else {
		   $errorsArray[] = curl_error($ch);
		}
		
		//close connection
		curl_close($ch);
	
		//Do we have any errors?
		if(count($errorsArray)) {
			return $errorsArray[0];
		} else {
			return 'Redirecting...';	
		}
		
	}
	
	////////////////////////////////////
	//@ IPN Receiver
	////////////////////////////////////
	public function paynowIPN() {
		
		//ErrorsArray
		$this->errorsArray = array();
			
		// Check the request method is POST
		if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] != 'POST' ) {
			return;
		}
		
		//Mail What We do
		//$fields = '';
		//foreach($_POST as $key=>$value) { $fields .= $key.'=>'.$value; }
	
		//Open Connection
		$ch = curl_init();		
		
		curl_setopt($ch, CURLOPT_URL, @$_POST['pollurl']);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, '');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		//execute post
		$result = curl_exec($ch);
		
		if($result) {
			
			//Close Connection
			$msg = ParseMsg($result);
			
			$MerchantKey =  config::$integration_key;
			$validateHash = CreateHash($msg, $MerchantKey);
			
			if($validateHash != $msg["hash"]){
				$this->errorsArray[]= 'There has been a mismatch with ';
			} else {
						
				/* Advert Status: 0 = Pending, 1 = Approved, 2, Removed/Cancelled/Refunded */
				
				//Require Payments Class
				require(ROOT.'/classes/payments.class.php');
				$payments=new payments;
				
				//Transaction Fees
				$trans_fee = $msg["amount"]/100;
				$trans_fee = $trans_fee * 3.5;
				$trans_fee = $trans_fee + 0.50;
				
				//Switch Status
				switch($msg["status"]) {
					case 'Cancelled': { // The transaction has been cancelled in Paynow and may not be resumed and needs to be recreated
						$payments->processIPN(@$msg['reference'], @$msg["amount"], 'USD', $msg['paynowreference'], $trans_fee, 2, 2);
						break;
					}
					case 'Paid': { //Transaction paid successfully, the merchant will receive the funds at next settlement
						$payments->processIPN(@$msg['reference'], @$msg["amount"], 'USD', $msg['paynowreference'], $trans_fee, 1, 2);
						break;
					}
					case 'Awaiting Delivery': { //Transaction paid successfully, but is sitting in suspense waiting on the merchant to confirm delivery of the goods.
						$payments->processIPN(@$msg['reference'], @$msg["amount"], 'USD', $msg['paynowreference'], $trans_fee, 1, 2);
						break;
					}
					case 'Delivered': { //The user or merchant has acknowledged delivery of the goods but the funds are still sitting insuspense awaiting the 24 hour confirmation window to close
						$payments->processIPN(@$msg['reference'], @$msg["amount"], 'USD', $msg['paynowreference'], $trans_fee, 1, 2);
						break;
					}
					case 'Created': { //Transaction has been created in Paynow, but has not yet been paid by the customer
						break;
					}
					case 'Refunded': { //Funds were refunded back to the customer.
						$payments->processIPN(@$MSG['reference'], @$msg["amount"], 'USD', $msg['paynowreference'], $trans_fee, 2, 2);
						break;
					}
				}
				
			}
		
		}		
	}
}