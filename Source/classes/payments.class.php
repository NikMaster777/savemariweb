<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class payments {
	
	//@Log Actions/Transactions
	public function logIPN($message) {
		$log = @fopen(ROOT.'/logs/gateway-log.txt', "a");
		@fwrite($log, "\n". $message);
		@fclose($log);	
	}
	
	//@Process Payment from IPN
	public function processIPN($sorthub_value, $gateway_amount, $gateway_currency, $gateway_transid, $gateway_fees, $gateway_status, $gateway_id) {
				
		/*				
		  *@Invoice Status
		  * 0 == UNPAID
		  * 1 == PAID
		  * 2 == REFUNDED
		  
		  /@Adverts
		  * TYPEID(1)-ADVERT_ID-INVOICE_ID-PACKID
		  * Advert Status: 0 = Pending, 1 = Approved, 2, Removed/Cancelled/Refunded
		  //@Stores
		*/
		
		//Sort Hub Errors
		$sortHubErrors = array();
				
		//Lets sort the data
		$sorthub = @explode('-',$sorthub_value);
		
		$this->logIPN($sorthub_value);
		
		//Do we have a minimum sorting value?
		if(count($sorthub) < 1) { $sortHubErrors[] = 'We are missing the minimum value to continue (sorting value)'; }
		if(isset($sorthub[0]) && is_numeric($sorthub[0]) === false) { $sortHubErrors[] = 'The sorting value is not numeric, what are you trying to do?'; }
		
		//Lets do the sorting, a bit like the post-office!
		switch($sorthub[0]) {
			////////////////////////////////////
			//Standard Paid Advert
			////////////////////////////////////
			case 1: {
				$this->logIPN('--------------------------------------------');
				$this->logIPN('- Standard Paid Advert');
				$this->logIPN('--------------------------------------------');
				//Advert ID
				if(isset($sorthub[1]) && is_numeric($sorthub[1]) === false) { $sortHubErrors[] = 'The advert ID must be a numeric value only, what are you trying to do?'; }
				if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".db::mss($sorthub[1])."'") < 1) { 
					$sortHubErrors[] = 'The advert ID does not exist, what are you trying to do?';
				}
				$this->logIPN('* Advert ID Checked');
				//Invoice ID
				if(isset($sorthub[2]) && is_numeric($sorthub[2]) === false) { $sortHubErrors[] = 'The invoice ID must be a numeric value only, what are you trying to do? We got '.$sorthub[2]; }
				if(db::nRows("SELECT `invoice_id`,`invoice_typeid` FROM `".config::$db_prefix."invoices` WHERE 
					(`invoice_id`='".db::mss($sorthub[2])."' AND `invoice_type`='1' AND `invoice_typeid`='".db::mss($sorthub[1])."')") < 1) { 
					$sortHubErrors[] = 'The advert Invoice ID does not exist, what are you trying to do?';
				} else {
					$invoice = db::fetchQuery("SELECT * FROM `".config::$db_prefix."invoices` WHERE `invoice_id`='".db::mss($sorthub[2])."'");
					if($gateway_amount != $invoice['invoice_amount']) {
						$sortHubErrors[] = 'It seems we have a price mis-match, the gateway is telling us '.$gateway_amount.' and the invoice is telling us '.$invoice['invoice_amount'];
					}
				}
				$this->logIPN('* Invoice ID Checked');
				//Pack ID
				if(isset($sorthub[3]) && is_numeric($sorthub[3]) === false) { $sortHubErrors[] = 'The advert pack ID must be a numeric value only, what are you trying to do?'; }
				if(db::nRows("SELECT `pack_id` FROM `".config::$db_prefix."adpacks` WHERE (`pack_id`='".db::mss($sorthub[3])."')") < 1) { 
					$sortHubErrors[] = 'The ad-pack ID does not exist, what are you trying to do?';
				}
				$this->logIPN('* AdPack ID Checked');
				//Currency Check
				$currency = lib::getCurrency(lib::getSetting('Local_DefaultCurrency'));
				if($gateway_currency != $currency['currency_name']) {
					$sortHubErrors[] = 'It seems we have a currency mis-match, what happened? Gateway said '.$gateway_currency. ' we was expecting '.$currency['currency_name'];
				}
				$this->logIPN('--------------------------------------------');
				$this->logIPN('Advert ID: '.$sorthub[1]).' Gateway ID'.$gateway_id;
				$this->logIPN('--------------------------------------------');
				break;	
			}
			////////////////////////////////////
			// Order a Store
			////////////////////////////////////
			case 2: {
				$this->logIPN('--------------------------------------------');
				$this->logIPN('- Store');
				$this->logIPN('--------------------------------------------');
				//Store ID
				if(isset($sorthub[1]) && is_numeric($sorthub[1]) === false) { $sortHubErrors[] = 'The store ID must be a numeric value only, what are you trying to do?'; }
				if(db::nRows("SELECT `store_id` FROM `".config::$db_prefix."stores` WHERE `store_id`='".db::mss($sorthub[1])."'") < 1) { 
					$sortHubErrors[] = 'The store ID does not exist, what are you trying to do?';
				}
				$this->logIPN('* Store ID Checked');
				//Invoice ID
				if(isset($sorthub[2]) && is_numeric($sorthub[2]) === false) { $sortHubErrors[] = 'The invoice ID must be a numeric value only, what are you trying to do? We got '.$sorthub[2]; }
				if(db::nRows("SELECT `invoice_id`,`invoice_typeid` FROM `".config::$db_prefix."invoices` WHERE 
					(`invoice_id`='".db::mss($sorthub[2])."' AND `invoice_type`='2' AND `invoice_typeid`='".db::mss($sorthub[1])."')") < 1) { 
					$sortHubErrors[] = 'The store Invoice ID does not exist, what are you trying to do?';
				} else {
					$invoice = db::fetchQuery("SELECT * FROM `".config::$db_prefix."invoices` WHERE `invoice_id`='".db::mss($sorthub[2])."'");
					if($gateway_amount != $invoice['invoice_amount']) {
						$sortHubErrors[] = 'It seems we have a price mis-match, the gateway is telling us '.$gateway_amount.' and the invoice is telling us '.$invoice['invoice_amount'];
					}
				}
				$this->logIPN('* Invoice ID Checked');
				//Pack ID
				if(isset($sorthub[3]) && is_numeric($sorthub[3]) === false) { $sortHubErrors[] = 'The store pack ID must be a numeric value only, what are you trying to do?'; }
				if(db::nRows("SELECT `pack_id` FROM `".config::$db_prefix."stpacks` WHERE (`pack_id`='".db::mss($sorthub[3])."')") < 1) { 
					$sortHubErrors[] = 'The store pack-ID does not exist, what are you trying to do?';
				}
				$this->logIPN('* Store Pack ID Checked');
				//Currency Check
				$currency = lib::getCurrency(lib::getSetting('Local_DefaultCurrency'));
				if($gateway_currency != $currency['currency_name']) {
					$sortHubErrors[] = 'It seems we have a currency mis-match, what happened? Gateway said '.$gateway_currency. ' we was expecting '.$currency['currency_name'];
				}
				$this->logIPN('--------------------------------------------');
				$this->logIPN('Store ID: '.$sorthub[1]).' Gateway ID'.$gateway_id;
				$this->logIPN('--------------------------------------------');
				break;
			}
			////////////////////////////////////
			// Order a Product from Store
			////////////////////////////////////
			case 3: {
				$this->logIPN('--------------------------------------------');
				$this->logIPN('- Store Product');
				$this->logIPN('--------------------------------------------');
				//Product
				if(isset($sorthub[1]) && is_numeric($sorthub[1]) === false) { $sortHubErrors[] = 'The product ID must be a numeric value only, what are you trying to do?'; }
				if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".db::mss($sorthub[1])."' AND `advert_store`='1' AND `advert_storeid`='".$sorthub[3]."'") < 1) { 
					$sortHubErrors[] = 'The product ID does not exist, what are you trying to do?';
				}
				$this->logIPN('* Product ID Checked');
				//Invoice ID
				if(isset($sorthub[2]) && is_numeric($sorthub[2]) === false) { $sortHubErrors[] = 'The invoice ID must be a numeric value only, what are you trying to do? We got '.$sorthub[2]; }
				if(db::nRows("SELECT `invoice_id`,`invoice_typeid` FROM `".config::$db_prefix."invoices` WHERE 
					(`invoice_id`='".db::mss($sorthub[2])."' AND `invoice_type`='3' AND `invoice_typeid`='".db::mss($sorthub[1])."')") < 1) { 
					$sortHubErrors[] = 'The store Invoice ID does not exist, what are you trying to do?';
				} else {
					$invoice = db::fetchQuery("SELECT * FROM `".config::$db_prefix."invoices` WHERE `invoice_id`='".db::mss($sorthub[2])."'");
					if($gateway_amount != $invoice['invoice_amount']) {
						$sortHubErrors[] = 'It seems we have a price mis-match, the gateway is telling us '.$gateway_amount.' and the invoice is telling us '.$invoice['invoice_amount'];
					}
				}
				$this->logIPN('* Invoice ID Checked');
				//StoreID
				if(db::nRows("SELECT `store_id` FROM `".config::$db_prefix."stores` WHERE `store_id`='".$sorthub[3]."'") < 1) { 
					$this->errorsArray[] = 'We could not find a store matching the store ID provided.';
				}
				$this->logIPN('* Store ID Checked');
				//Currency Check
				$currency = lib::getCurrency(lib::getSetting('Local_DefaultCurrency'));
				if($gateway_currency != $currency['currency_name']) {
					$sortHubErrors[] = 'It seems we have a currency mis-match, what happened? Gateway said '.$gateway_currency. ' we was expecting '.$currency['currency_name'];
				}
				//Customer Check
				if(db::nRows("SELECT `user_id` FROM `".config::$db_prefix."store_users` WHERE `user_id`='".db::mss($sorthub[4])."' AND `user_storeid`='".db::mss($sorthub[3])."' AND `user_productid`='".db::mss($sorthub[1])."'") < 1) { 
					$this->errorsArray[] = 'We could not find a user matching the ID provided.';
				}
				$this->logIPN('* Customer Checked');
				$this->logIPN('--------------------------------------------');
				$this->logIPN('Product ID: '.$sorthub[1]).' Gateway ID'.$gateway_id;
				$this->logIPN('--------------------------------------------');
				break;
			}
		}
	
		//Do we have any errors?
		if(count($sortHubErrors) > 0) {
			$this->logIPN('Error: '.$sortHubErrors[0]);
		} else {
				
			switch($sorthub[0]) {
				////////////////////////////////////
				//Standard Paid Advert
				////////////////////////////////////
				case 1: {
					switch($gateway_status) {
						case 0: { //UNPAID
							$this->logIPN('Marked Invoice as UNPAID');	
							db::query("UPDATE `".config::$db_prefix."invoices` SET `invoice_status`='0',
																				   `invoice_transactionid`='',
																				   `invoice_gatewayid`='',
																				   `invoice_gatewayfees`='',
																				   `invoice_datepaid`='' WHERE `invoice_id`='".db::mss($sorthub[2])."'");
							db::query("UPDATE `".config::$db_prefix."adverts` SET `advert_expiredate`='' WHERE `advert_id`='".db::mss($sorthub[1])."'");
							break;
						}
						case 1: { //PAID
							$this->logIPN('Marked Invoice as PAID');
							db::query("UPDATE `".config::$db_prefix."invoices` SET `invoice_status`='1',
																				   `invoice_transactionid`='".db::mss($gateway_transid)."',
																				   `invoice_gatewayid`='".db::mss($gateway_id)."',
																				   `invoice_gatewayfees`='".db::mss($gateway_fees)."',
																				   `invoice_datepaid`='".date('Y-m-d')."' WHERE `invoice_id`='".db::mss($sorthub[2])."'");
							db::query("UPDATE `".config::$db_prefix."adverts` SET `advert_expiredate`='".date('Y-m-d h:i:s', strtotime("+1 Month"))."' WHERE `advert_id`='".db::mss($sorthub[1])."'");
							break;
						}
						case 2: { //REFUNDED
							$this->logIPN('Marked Invoice as REFUNDED');
							db::query("UPDATE `".config::$db_prefix."invoices` SET `invoice_status`='2',
																				   `invoice_transactionid`='".db::mss($gateway_transid)."',
																				   `invoice_gatewayid`='".db::mss($gateway_id)."',
																				   `invoice_gatewayfees`='".db::mss($gateway_fees)."',
																				   `invoice_datepaid`='".date('Y-m-d')."' WHERE `invoice_id`='".db::mss($sorthub[2])."'");
							db::query("UPDATE `".config::$db_prefix."adverts` SET `advert_expiredate`='',`advert_status`='2' WHERE `advert_id`='".db::mss($sorthub[1])."'");
							break;
						}
					}
					break;	
				}
				////////////////////////////////////
				// Order a Store
				////////////////////////////////////
				case 2: {
					switch($gateway_status) {
						case 0: { //UNPAID
							$this->logIPN('Marked Invoice as UNPAID');	
							db::query("UPDATE `".config::$db_prefix."invoices` SET `invoice_status`='0',
																				   `invoice_transactionid`='',
																				   `invoice_gatewayid`='',
																				   `invoice_gatewayfees`='',
																				   `invoice_datepaid`='' WHERE `invoice_id`='".db::mss($sorthub[2])."'");
							db::query("UPDATE `".config::$db_prefix."stores` SET `store_activated`='0' WHERE `store_id`='".db::mss($sorthub[1])."'");
							break;
						}
						case 1: { //PAID
							$this->logIPN('Marked Invoice as PAID');
							db::query("UPDATE `".config::$db_prefix."invoices` SET `invoice_status`='1',
																				   `invoice_transactionid`='".db::mss($gateway_transid)."',
																				   `invoice_gatewayid`='".db::mss($gateway_id)."',
																				   `invoice_gatewayfees`='".db::mss($gateway_fees)."',
																				   `invoice_datepaid`='".date('Y-m-d')."' WHERE `invoice_id`='".db::mss($sorthub[2])."'");
							db::query("UPDATE `".config::$db_prefix."stores` SET `store_activated`='1' WHERE `store_id`='".db::mss($sorthub[1])."'");
							break;
						}
						case 2: { //REFUNDED
							$this->logIPN('Marked Invoice as REFUNDED');
							db::query("UPDATE `".config::$db_prefix."invoices` SET `invoice_status`='2',
																				   `invoice_transactionid`='".db::mss($gateway_transid)."',
																				   `invoice_gatewayid`='".db::mss($gateway_id)."',
																				   `invoice_gatewayfees`='".db::mss($gateway_fees)."',
																				   `invoice_datepaid`='".date('Y-m-d')."' WHERE `invoice_id`='".db::mss($sorthub[2])."'");
							db::query("UPDATE `".config::$db_prefix."stores` SET `store_activated`='0' WHERE `store_id`='".db::mss($sorthub[1])."'");
							break;
						}
					}
					break;	
				}
				////////////////////////////////////
				// Product from Store
				////////////////////////////////////
				case 3: {
					switch($gateway_status) {
						case 0: { //UNPAID
							$this->logIPN('Marked Invoice as UNPAID');	
							db::query("UPDATE `".config::$db_prefix."invoices` SET `invoice_status`='0',
																				   `invoice_transactionid`='',
																				   `invoice_gatewayid`='',
																				   `invoice_gatewayfees`='',
																				   `invoice_datepaid`='' WHERE `invoice_id`='".db::mss($sorthub[2])."'");
							
							break;
						}
						case 1: { //PAID
							$this->logIPN('Marked Invoice as PAID');
							db::query("UPDATE `".config::$db_prefix."invoices` SET `invoice_status`='1',
																				   `invoice_transactionid`='".db::mss($gateway_transid)."',
																				   `invoice_gatewayid`='".db::mss($gateway_id)."',
																				   `invoice_gatewayfees`='".db::mss($gateway_fees)."',
																				   `invoice_datepaid`='".date('Y-m-d')."' WHERE `invoice_id`='".db::mss($sorthub[2])."'");
							//Mark Item as Sold
							db::query("UPDATE `".config::$db_prefix."adverts` SET `advert_store_sold`='1',`advert_store_sold_date`='".date('Y-m-d')."' WHERE `advert_id`='".db::mss($sorthub[1])."'");
							
							////////////////////////////////////////////
							//Create Voucher
							////////////////////////////////////////////
							while(1) {
								$this->voucher = substr(strtoupper(sha1(microtime())),0,5).'-'.substr(strtoupper(sha1(microtime())),0,5).'-'.substr(strtoupper(sha1(microtime())),0,5).'-'.substr(strtoupper(sha1(microtime())),0,5);
								if(db::nRows("SELECT `redeem_code` FROM `".config::$db_prefix."redeem` WHERE `redeem_code`='".db::mss($this->voucher)."' AND `redeem_storeid`='".db::mss($sorthub[1])."' AND `redeem_productid`='".db::mss($sorthub[1])."'") < 1) {
									break;
								}
							}
							
							///////////////////////////////////////////
							//Store Voucher Code
							///////////////////////////////////////////
							db::query("INSERT INTO `".config::$db_prefix."redeem` 
																				   (
																				   `redeem_code`,
																				   `redeem_storeid`,
																				   `redeem_productid`,
																				   `redeem_userid`,
																				   `redeem_invoiceid`
																				   ) 
																				   
																				   VALUES 
																				   
																				   (
																				   '".db::mss($this->voucher)."', 
																				   '".db::mss($sorthub[3])."', 
																				   '".db::mss($sorthub[1])."', 
																				   '".db::mss($sorthub[4])."',
																				   '".db::mss($sorthub[2])."'
																				   )
																				   
																				   ");
							
							//Load Customer
							$this->customer = db::fetchQuery("SELECT * FROM `".config::$db_prefix."store_users` WHERE `user_id`='".db::mss($sorthub[4])."'");
							
							//Load Invoice
							$this->invoice = db::fetchQuery("SELECT * FROM `".config::$db_prefix."invoices` WHERE `invoice_id`='".db::mss($sorthub[2])."'");
							
							//Load Product
							$product = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".db::mss($sorthub[1])."'");
							
							//Load Store
							$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_id`='".db::mss($sorthub[3])."'");
							
							//Load Voucher
							$this->redeem = db::fetchQuery("SELECT * FROM `".config::$db_prefix."redeem` WHERE `redeem_productid`='".db::mss($sorthub[1])."' and `redeem_invoiceid`='".db::mss($sorthub[2])."'");						
							
							//Gateway Type
							switch($gateway_id) {
								case 1: {
									$this->gateway_name = 'PayPal';
									break;	
								}
								case 2: {
									$this->gateway_name = 'PayNow';
									break;	
								}
							}
							
							/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							// REVIEW (LEAVE REVIEW) YOUR ORDER
							/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							
							//Generate Code
							$this->review_code = sha1(microtime().$this->customer['user_firstname']);
							$this->review_link = DOMAIN.'/index.php?stores='.$store['store_username'].'&page=reviews&review_code='.$this->review_code;
							
							//Create DB Code
							db::query("INSERT INTO `".config::$db_prefix."reviewcodes` (`code_storeid`,`code_value`) VALUES ('".$store['store_id']."','".db::mss($this->review_code)."')");
							
							//Load Review Template
							$this->template = db::fetchQuery("SELECT * FROM `".config::$db_prefix."email_templates` WHERE `template_id`='26'");
							
							//Build Complete HTML Template
							$this->template_message = $this->template['template_html'];
							
							//Payment Information
							$this->template_message = str_replace('<!--CUSTOMER_FIRSTNAME-->',$this->customer['user_firstname'], $this->template_message);
							$this->template_message = str_replace('<!--REVIEWLINK-->', $this->review_link, $this->template_message);
													
							//Send the message
							$mailer= new mailer($this->customer['user_email'], $this->template['template_subject'], $this->template_message, 0);
							$mailer->send();																		
																			   
							/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							// SYSTEM ADMINISTRATOR
							/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							//Load Welcome Template
							$this->template = db::fetchQuery("SELECT * FROM `".config::$db_prefix."email_templates` WHERE `template_id`='21'");
							
							//Build Complete HTML Template
							$this->template_message = $this->template['template_html'];
							
							//Payment Information
							$this->template_message = str_replace('<!--PAYMENT_REFERENCE-->',$this->invoice['invoice_reference'], $this->template_message);
							$this->template_message = str_replace('<!--PAYMENT_AMOUNT-->',$product['advert_price'], $this->template_message);
							$this->template_message = str_replace('<!--PAYMENT_INVOICEID-->',$this->invoice['invoice_id'], $this->template_message);
							$this->template_message = str_replace('<!--PAYMENT_PRODUCTID-->',lib::post('product_id',true), $this->template_message);
							$this->template_message = str_replace('<!--PAYMENT_USERID-->',$this->customer['user_id'], $this->template_message);
							$this->template_message = str_replace('<!--PAYMENT_STOREID-->',$store['store_id'], $this->template_message);
							$this->template_message = str_replace('<!--PAYMENT_STOREUSERNAME-->',$store['store_username'], $this->template_message);
							$this->template_message = str_replace('<!--PAYMENT_GATEWAY-->', $this->gateway_name, $this->template_message);
							
							//Customer Information
							$this->template_message = str_replace('<!--CUSTOMER_FIRSTNAME-->',$this->customer['user_firstname'], $this->template_message);
							$this->template_message = str_replace('<!--CUSTOMER_LASTNAME-->',$this->customer['user_lastname'], $this->template_message);
							$this->template_message = str_replace('<!--CUSTOMER_EMAILADDRESS-->',$this->customer['user_email'], $this->template_message);
							$this->template_message = str_replace('<!--CUSTOMER_ADDRESS1-->',$this->customer['user_address1'], $this->template_message);
							$this->template_message = str_replace('<!--CUSTOMER_ADDRESS2-->',$this->customer['user_address2'], $this->template_message);
							$this->template_message = str_replace('<!--CUSTOMER_ZIPCODE-->',$this->customer['user_postcode'], $this->template_message);
							$this->template_message = str_replace('<!--CUSTOMER_MOBILE-->',$this->customer['user_mobile'], $this->template_message);
													
							//Send the message
							$mailer= new mailer(lib::getSetting('General_DefaultAdminEmail'), $this->template['template_subject'], $this->template_message, 0);
							$mailer->send();
							
							/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							// STORE ADMINISTRATOR
							/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							//Load Welcome Template
							$this->template = db::fetchQuery("SELECT * FROM `".config::$db_prefix."email_templates` WHERE `template_id`='23'");
							
							//Build Complete HTML Template
							$this->template_message = $this->template['template_html'];
							
							//Payment Information
							$this->template_message = str_replace('<!--PAYMENT_REFERENCE-->',$this->invoice['invoice_reference'], $this->template_message);
							$this->template_message = str_replace('<!--PAYMENT_AMOUNT-->',$product['advert_price'], $this->template_message);
							$this->template_message = str_replace('<!--PAYMENT_INVOICEID-->',$this->invoice['invoice_id'], $this->template_message);
							$this->template_message = str_replace('<!--PAYMENT_PRODUCTID-->',lib::post('product_id',true), $this->template_message);
							$this->template_message = str_replace('<!--PAYMENT_USERID-->',$this->customer['user_id'], $this->template_message);
							$this->template_message = str_replace('<!--PAYMENT_STOREID-->',$store['store_id'], $this->template_message);
							$this->template_message = str_replace('<!--PAYMENT_STOREUSERNAME-->',$store['store_username'], $this->template_message);
							
							//Customer Information
							$this->template_message = str_replace('<!--CUSTOMER_FIRSTNAME-->',$this->customer['user_firstname'], $this->template_message);
							$this->template_message = str_replace('<!--CUSTOMER_LASTNAME-->',$this->customer['user_lastname'], $this->template_message);
							$this->template_message = str_replace('<!--CUSTOMER_EMAILADDRESS-->',$this->customer['user_email'], $this->template_message);
							$this->template_message = str_replace('<!--CUSTOMER_ADDRESS1-->',$this->customer['user_address1'], $this->template_message);
							$this->template_message = str_replace('<!--CUSTOMER_ADDRESS2-->',$this->customer['user_address2'], $this->template_message);
							$this->template_message = str_replace('<!--CUSTOMER_ZIPCODE-->',$this->customer['user_postcode'], $this->template_message);
							$this->template_message = str_replace('<!--CUSTOMER_MOBILE-->',$this->customer['user_mobile'], $this->template_message);
													
							//Send the message
							$mailer= new mailer($store['store_email'], $this->template['template_subject'], $this->template_message, 0);
							$mailer->send();
							
							//Send Text Message
							$sms->send($store['store_phone'], 'Congratulations, somebody has purchased one of your store items! Check your email for confirmation.');
							
							/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							// STORE BUYER
							/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							//Load Welcome Template
							$this->template = db::fetchQuery("SELECT * FROM `".config::$db_prefix."email_templates` WHERE `template_id`='22'");
							
							//Build Complete HTML Template
							$this->template_message = $this->template['template_html'];
							
							//Information
							$this->template_message = str_replace('<!--VOUCHER_CODE-->',$this->redeem['redeem_code'], $this->template_message);
							$this->template_message = str_replace('<!--STOREADDRESS-->',$store['store_address'], $this->template_message);
							$this->template_message = str_replace('<!--STOREEMAIL-->',$store['store_email'], $this->template_message);
							$this->template_message = str_replace('<!--STOREPHONE-->',$store['store_phone'], $this->template_message);
							$this->template_message = str_replace('<!--PRODUCT_TITLE-->',$product['advert_title'], $this->template_message);
							$this->template_message = str_replace('<!--PRODUCT_PRICE-->',$product['advert_price'], $this->template_message);
							
							//Send the message
							$mailer= new mailer($this->customer['user_email'], $this->template['template_subject'], $this->template_message, 0);
							$mailer->send();
							
							//Send Text Message
							$sms->send($this->customer['user_mobile'], 'You purchased an item from a savemari store! - You must now get in touch with the seller and go get your item. Please give the following voucher code below to the seller ONLY when you have received the item and are happy.

Voucher Code:'.$this->redeem['redeem_code']);
															
							break;
						}
						case 2: { //REFUNDED
							$this->logIPN('Marked Invoice as REFUNDED');
							db::query("UPDATE `".config::$db_prefix."invoices` SET `invoice_status`='2',
																				   `invoice_transactionid`='".db::mss($gateway_transid)."',
																				   `invoice_gatewayid`='".db::mss($gateway_id)."',
																				   `invoice_gatewayfees`='".db::mss($gateway_fees)."',
																				   `invoice_datepaid`='".date('Y-m-d')."' WHERE `invoice_id`='".db::mss($sorthub[2])."'");
							//Mark Item as unsold
							db::query("UPDATE `".config::$db_prefix."adverts` SET `advert_store_sold`='0',`advert_store_sold_date`='' WHERE `advert_id`='".db::mss($sorthub[1])."'");
							break;
						}
					}
					break;	
				}
			}
			
			//IPN Success
			$this->logIPN('IPN Success!');	
		}
		
		
	}

	
	
}