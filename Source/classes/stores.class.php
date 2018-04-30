<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class stores {
	
	public function getReviews($store_id) {
		
		//Load Store
		$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_id`='".db::mss($store_id)."'");
		
		//if(db::nRows("SELECT `review_rating` FROM `".config::$db_prefix."reviews` WHERE `review_storeid`='".db::mss($store_id)."'") > 0) {
			
			//$stars = db::nRows("SELECT `review_rating` FROM `".config::$db_prefix."reviews` WHERE `review_storeid`='".db::mss($store_id)."'");
			//$stars_5 = db::nRows("SELECT `review_rating` FROM `".config::$db_prefix."reviews` WHERE `review_rating`='5' AND `review_storeid`='".db::mss($store_id)."'");	
			//$stars_4 = db::nRows("SELECT `review_rating` FROM `".config::$db_prefix."reviews` WHERE `review_rating`='4' AND `review_storeid`='".db::mss($store_id)."'");
			//$stars_3 = db::nRows("SELECT `review_rating` FROM `".config::$db_prefix."reviews` WHERE `review_rating`='3' AND `review_storeid`='".db::mss($store_id)."'");
			//$stars_2 = db::nRows("SELECT `review_rating` FROM `".config::$db_prefix."reviews` WHERE `review_rating`='2' AND `review_storeid`='".db::mss($store_id)."'");
			//$stars_1 = db::nRows("SELECT `review_rating` FROM `".config::$db_prefix."reviews` WHERE `review_rating`='1' AND `review_storeid`='".db::mss($store_id)."'");
			
			//Add all togther, then device by total ratings.
			//$rating = ceil($stars_1 + $stars_2 * 2 + $stars_3 * 3 + $stars_4 * 4 + $stars_5 * 5 / $stars);
			
			//return $rating;
		
		//} else {
			//return 0;
		//}
		return db::nRows("SELECT `review_rating` FROM `".config::$db_prefix."reviews` WHERE `review_storeid`='".db::mss($store_id)."'");
	}
	
	////////////////////////////////////////
	// @Leave Review
	////////////////////////////////////////
	public function deleteReview() {
		
		//Errors
		$this->errorsArray = array();
		
		//Load Store
		$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
		
		//Does the review exist?
		if(!lib::post('review_id',true)) { $this->errorsArray[] = 'Please select a valid review ID to continue.'; }
		if(db::nRows("SELECT `review_id` FROM `".config::$db_prefix."reviews` WHERE `review_id`='".lib::post('review_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid review to delete.';	
		}
		
		//Do we have any issues?
		if(count($this->errorsArray) > 0) {
			return $this->errorsArray[0];
		} else {
			db::query("DELETE FROM `".config::$db_prefix."reviews` WHERE `review_id`='".lib::post('review_id',true)."'");
		}
	}
	
	////////////////////////////////////////
	// @Leave Review
	////////////////////////////////////////
	public function leaveReview() {
		
		//Errors
		$this->errorsArray = array();
		
		//Do we have a rating?
		if(!lib::post('user_rating')) { $this->errorsArray[] = 'Please choose a rating below to continue.'; }
		
		//Do we have a full name?
		if(!lib::post('review_fullname')) { $this->errorsArray[] = 'Please enter your full name below to leave a review.'; }
		if(!lib::post('review_comment')) { $this->errorsArray[] = 'Please leave your review comment below.'; }
		
		//Do we have a review code?
		if(lib::post('review_code')) {
			if(db::nRows("SELECT * FROM `".config::$db_prefix."reviewcodes` WHERE `code_value`='".lib::get('review_code',true)."'") < 1) {
				$this->errorsArray[] = 'We are missing a review code, what happened?';
			}
		} else {
			$this->errorsArray[] = 'We are missing a review code, what happened?';	
		}
		
		//Do we have any issues?
		if(count($this->errorsArray) > 0) {
			return $this->errorsArray[0];
		} else {
			$codeData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."reviewcodes` WHERE `code_value`='".lib::get('review_code',true)."'");
			db::query("DELETE FROM `".config::$db_prefix."reviewcodes` WHERE `code_value`='".lib::get('review_code',true)."'");
			db::query("INSERT INTO `".config::$db_prefix."reviews` (`review_storeid`,`review_fullname`,`review_comment`,`review_date`) VALUES ('".$codeData['code_storeid']."','".lib::post('review_fullname',true)."','".lib::post('review_comment',true)."','".date('Y-m-d')."')");
		}
											
	}
	
	////////////////////////////////////////
	// @Redeem Voucher
	////////////////////////////////////////
	public function redeemVoucher() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Load Store
		$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
		
		//Lets do some digging
		if(!lib::post('voucher_code')) { $this->errorsArray[] = 'Please enter a valid voucher code below to continue.'; }
		if(db::nRows("SELECT `redeem_code` FROM `".config::$db_prefix."redeem` WHERE `redeem_code`='".lib::post('voucher_code',true)."' AND `redeem_storeid`='".db::mss($store['store_id'])."'") < 1) {
			$this->errorsArray[] = 'Please enter a valid redeem code below to continue.';
		}
		if(db::nRows("SELECT `redeem_code` FROM `".config::$db_prefix."redeem` WHERE `redeem_code`='".lib::post('voucher_code',true)."' AND `redeem_storeid`='".db::mss($store['store_id'])."' AND `redeem_redeemed`='1'") > 0) {
			$this->errorsArray[] = 'That voucher has already been redeemed.';	
		}
		
		//Do we have any issues?
		if(count($this->errorsArray)) {
			return $this->errorsArray[0];	
		} else {
			
			//Redeem the Code
			db::query("UPDATE `".config::$db_prefix."redeem` SET `redeem_redeemed`='1' WHERE `redeem_code`='".lib::post('voucher_code',true)."' AND `redeem_storeid`='".db::mss($store['store_id'])."'");
			
			//Load Store
			$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// SYSTEM ADMINISTRATOR
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//Load Welcome Template
			$this->template = db::fetchQuery("SELECT * FROM `".config::$db_prefix."email_templates` WHERE `template_id`='24'");
			
			//Build Complete HTML Template
			$this->template_message = $this->template['template_html'];
			
			//Payment Information
			$this->template_message = str_replace('<!--STORE_USERNAME-->',$store['store_username'], $this->template_message);
			$this->template_message = str_replace('<!--STORE_OWNER-->',session::data('user_firstname').' '.session::data('user_lastname'), $this->template_message);
									
			//Send the message
			$mailer= new mailer(lib::getSetting('General_DefaultAdminEmail'), $this->template['template_subject'], $this->template_message, 0);
			$mailer->send();
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// STORE OWNER
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//Load Welcome Template
			$this->template = db::fetchQuery("SELECT * FROM `".config::$db_prefix."email_templates` WHERE `template_id`='25'");
			
			//Build Complete HTML Template
			$this->template_message = $this->template['template_html'];
			
			//Payment Information
			//$this->template_message = str_replace('<!--PAYMENT_REFERENCE-->',$this->invoice['invoice_reference'], $this->template_message);
									
			//Send the message
			$mailer= new mailer($store['store_email'], $this->template['template_subject'], $this->template_message, 0);
			$mailer->send();
			
			
		}
			
	}
	
	
	////////////////////////////////////////
	// @Purchase - Stage 1
	////////////////////////////////////////
	public function purchase_stage1($store) {
				
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the product exist for this store?
		if(db::nRows("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::post('product_id',true)."' AND `advert_store`='1'") < 1) {
			$this->errorsArray[] = 'Please select a valid product to purchase.';	
		}
		
		//Do we have a firstname?
		if(!lib::post('user_firstname')) { $this->errorsArray[] = 'Please enter a first name below to continue.'; }
		if(strlen(lib::post('user_firstname')) > 100) { $this->errorsArray[] = 'Your first name must be less than 100 characters long.'; }
		if(!lib::post('user_lastname')) { $this->errorsArray[] = 'Please provide your last name below to continue.'; }
		if(strlen(lib::post('user_lastname')) > 100) { $this->errorsArray[] = 'Your last name must be less than 100 characters long.'; }
		if(!lib::post('user_address1')) { $this->errorsArray[] = 'Please provide your address 1.'; }
		if(strlen(lib::post('user_address1')) > 200) { $this->errorsArray[] = 'Your address 1 must be less than 200 characters long.'; }
		if(lib::post('user_address2')) { 
			if(strlen(lib::post('user_address2')) > 200) { 
				$this->errorsArray[] = 'Your address 1 must be less than 200 characters long.'; 
			} 
		}
		if(!lib::post('user_postcode')) { $this->errorsArray[] = 'Please provide your zip/postcode below.'; }
		if(!lib::post('user_email')) { $this->errorsArray[] = 'Please provide an email address below.'; }
		if(!filter_var(lib::post('user_email',true),FILTER_VALIDATE_EMAIL)) { $this->errorsArray[] = 'Please provide a valid email address below to continue.'; }
		if(!lib::post('user_mobile')) { $this->errorsArray[] = 'Please enter your mobile number below to continue.'; }
		
		//Do we have any issues?
		if(count($this->errorsArray)) {
			return $this->errorsArray[0];	
		} else {
			
			//Load Product
			$product = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::post('product_id',true)."' AND `advert_store`='1'");					
			
			//Create Customer
			db::query("INSERT INTO `".config::$db_prefix."store_users` (
																		`user_firstname`,
																		`user_lastname`,
																		`user_address1`,
																		`user_address2`,
																		`user_postcode`,
																		`user_email`,
																		`user_mobile`,
																		`user_storeid`,
																		`user_productid`
																		) 
																		VALUES 
																		(
																		 '".lib::post('user_firstname',true)."',
																		 '".lib::post('user_lastname',true)."',
																		 '".lib::post('user_address1',true)."',
																		 '".lib::post('user_address2',true)."',
																		 '".lib::post('user_postcode',true)."',
																		 '".lib::post('user_email',true)."',
																		 '".lib::post('user_mobile',true)."',
																		 '".$product['advert_storeid']."',
																		 '".lib::post('product_id',true)."'
																		)");
			
			
			//Load Customer
			$this->customer = db::fetchQuery("SELECT * FROM `".config::$db_prefix."store_users` ORDER BY `user_id` DESC LIMIT 0,1");
			
			//Bank Transfer Reference
			$this->reference = '3'.'-'.$this->customer['user_id'].'-'.lib::post('product_id',true).'-'.$store['store_id'];
					
			//Create Invoice
			db::query("INSERT INTO `".config::$db_prefix."invoices` 
			
			(
			
			`invoice_userid`,
			`invoice_type`,
			`invoice_typeid`,
			`invoice_amount`,
			`invoice_reference`
			
			) 
			VALUES 
			(
			
			'".$this->customer['user_id']."',
			'3',
			'".lib::post('product_id',true)."', 
			'".db::mss($product['advert_price'])."',
			'".db::mss($this->reference)."'		
			)");	
			
			//Load Invoice
			$this->invoice = db::fetchQuery("SELECT * FROM `".config::$db_prefix."invoices` WHERE  (`invoice_userid`='".$this->customer['user_id']."' AND 
			`invoice_typeid`='".lib::post('product_id',true)."' AND `invoice_type`='3') ORDER BY `invoice_id` DESC LIMIT 0,1");
			
			//Redirect to Gateways
			switch(lib::post('payment_method')) {
				//PayPal
				case 1: {
					//Load PayPal Class
					require(ROOT.'/classes/paypal/paypal.class.php');	
					$paypal=new paypal();
					$sort_id = '3'.'-'.lib::post('product_id',true).'-'.$this->invoice['invoice_id'].'-'.$product['advert_storeid'].'-'.$this->customer['user_id'];
					return $paypal->create_trans($sort_id, $product['advert_price'], '', DOMAIN.'/index.php?stores='.urlencode($store['store_username']).'&page=thankyou');
					die();		
					break;
				}
				//PayNow
				case 2: {
					//Load PayNow Class
					require(ROOT.'/classes/paynow/paynow.class.php');												
					$paynow=new paynow();
					$sort_id = '3'.'-'.lib::post('product_id',true).'-'.$this->invoice['invoice_id'].'-'.$product['advert_storeid'].'-'.$this->customer['user_id'];
					$paynow->create_trans($sort_id, $product['advert_price'], '', DOMAIN.'/index.php?stores='.urlencode($store['store_username']).'&page=thankyou');
					die();
					break;
				}
				case 3: {
					
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// SYSTEM ADMIN EMAIL
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//Load Welcome Template
					$this->template = db::fetchQuery("SELECT * FROM `".config::$db_prefix."email_templates` WHERE `template_id`='19'");
										
					//Build Complete HTML Template
					$this->template_message = $this->template['template_html'];
					
					//Payment Information
					$this->template_message = str_replace('<!--PAYMENT_REFERENCE-->',$this->reference, $this->template_message);
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
					$mailer= new mailer(lib::getSetting('General_DefaultAdminEmail'), $this->template['template_subject'], $this->template_message, 0);
					$mailer->send();
					
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// SYSTEM BUYER
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//Load Welcome Template
					$this->template = db::fetchQuery("SELECT * FROM `".config::$db_prefix."email_templates` WHERE `template_id`='20'");
					
					//Build Complete HTML Template
					$this->template_message = $this->template['template_html'];
					
					//Payment Information
					$this->template_message = str_replace('<!--PAYMENT_REFERENCE-->',$this->reference, $this->template_message);
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
					$mailer= new mailer($this->customer['user_email'], $this->template['template_subject'], $this->template_message, 0);
					$mailer->send();
									
					//Redirect
					@header("Location:".DOMAIN.'/index.php?stores='.urlencode($store['store_username']).'&page=thankyou&reference='.$this->reference);
					die();
					break;	
				}
			}
		
		}
		
	}
	
	
	////////////////////////////////////////
	// @Add Product
	////////////////////////////////////////
	public function EditProduct() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Load Store
		$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
		
		//Does the product/advert exist?
		if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE 
		
		`advert_userid`='".session::data('user_id')."' AND 
		`advert_id`='".lib::post('advert_id',true)."' AND 
		`advert_storeid`='".$store['store_id']."'") < 1) {
			
			$this->errorsArray[] = 'Please select a valid product to edit.';
		}
		
		//Form Field Validation
		if(!lib::post('advert_title')) { $this->errorsArray[] = 'Please enter a title for your advert.'; }
		if(strlen(lib::post('advert_title')) > 60) { $this->errorsArray[] = 'Your advert title must be less than 60 characters long.'; }
		if(!preg_match("/[A-Za-z0-9,'\s]+/", lib::post('advert_title'))) { $this->errorsArray[] = 'Your advert title must not contain any other characters other than A-Z and 0-9 with spaces.'; }
		
		//Validate Price
		if(!lib::post('advert_price')) { $this->errorsArray[] = 'Please enter a valid price for your advert below.'; }
		if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', lib::post('advert_price'))) { $this->errorsArray[] = 'Please enter a valid price for your advert below.'; }
		if(!lib::post('advert_html')) { $this->errorsArray[] = 'Please enter a description for your advert to continue.'; }
		if(strlen(lib::post('advert_html')) > 15000) { $this->errorsArray[] = 'Your advert description must not be more than 1500 characters long.'; }
		
		//Prepare Validation
		//preg_match_all( '#<([a-z]+)>#i' , lib::post('advert_html'), $start, PREG_OFFSET_CAPTURE);
		//preg_match_all( '#<\/([a-z]+)>#i' , lib::post('advert_html'), $end, PREG_OFFSET_CAPTURE);
		//$start = $start[1];
		//$end = $end[1];
		
		//Count HTML Tags
		//if(count($start) != count($end)) { $this->errorsArray[] = 'We are missing some HTML tags which should of been closed, what did you do?'; }
				
		//Load Store
		$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
		
		//Does it exist?
		if(db::nRows("SELECT `cat_id`,`cat_storeid` FROM `".config::$db_prefix."store_categories` WHERE `cat_id`='".lib::post('advert_catid',true)."' AND `cat_storeid`='".$store['store_id']."'") < 1) {
			$this->errorsArray[] = 'Please select a valid product category';
		}
		
		//Field List
		$fieldSQL = db::query("SELECT * FROM `".config::$db_prefix."store_fields` WHERE `field_storeid`='".$store['store_id']."'");
		while($fieldData = db::fetch($fieldSQL)) {
				switch($fieldData['field_type']) {
					case 1: { //Textbox
						
						break;	
					}
					case 2: { //Textarea
						
						break;	
					}
					case 3: { //Dropdown Item
						if(db::nRows("SELECT * FROM `".config::$db_prefix."store_fields_options` WHERE `option_id`='".lib::post($fieldData['field_id'],true)."'") < 1) {
							$this->errorsArray[] = 'Invalid Response! [E3]';
						}
						break;	
					}
					case 4: { //Checkbox Exist?
						$optionSQL = db::query("SELECT * FROM `".config::$db_prefix."store_fields_options` WHERE `option_id`='".lib::post($fieldData['field_id'],true)."'");
						while($optionData = db::fetch($optionSQL)) {
							if(!in_array(lib::post($optionData['option_id'],true), array(0,1))) { $this->errorsArray[] = 'Invalid Response! [E4]'; }
						}
						break;	
					}
				}
			
		}
		
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Load Session
			$this->advert = $_SESSION[config::$db_prefix.'advert'];
			
			//Append Info
			$this->advert['advert_title'] = lib::post('advert_title');
			$this->advert['advert_catid'] = lib::post('advert_catid');
			$this->advert['advert_subcatid'] = lib::post('advert_subcatid');
			$this->advert['advert_price'] = lib::post('advert_price');	
			$this->advert['advert_province'] = lib::post('advert_province');
			$this->advert['advert_country'] = lib::post('advert_country');
			$this->advert['advert_html'] = lib::post('advert_html');
						
			//Append Session
			$_SESSION[config::$db_prefix.'advert'] = $this->advert;
			
			//Create Reference
			$this->advert_ref = session::data('user_id',true).'-'.time();
			
			//Create SEO String
			$string = strtolower($this->advert['advert_title']);
			$string = preg_replace('/[^a-zA-Z0-9 ]/','', $string);
			$string = preg_replace('/\s+/','-',$string);
			
			//Load Store
			$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
			
			//Create Advert
			db::query("UPDATE `".config::$db_prefix."adverts` SET	`advert_title`='".db::mss($this->advert['advert_title'])."',
																	`advert_price`='".db::mss($this->advert['advert_price'])."',
																	`advert_html`='".db::mss($this->advert['advert_html'])."',
																	`advert_datetime`='".date('Y-m-d h:i:s')."',
																	`advert_status`='1',
																	`advert_ref`='".db::mss($this->advert_ref)."',
																	`advert_seo_url`='".db::mss($string)."',
																	`advert_expiredate`='".date('Y-m-d h:i:s', strtotime("+1 Month"))."',
																	`advert_store_catid`='".lib::post('advert_catid',true)."'
																																																			
																	WHERE `advert_id`='".lib::post('advert_id',true)."' AND `advert_store`='1' ");
			
			//Load Advert
			$this->advert_data = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::post('advert_id',true)."' AND `advert_userid`='".session::data('user_id',true)."'");
			
			//Images
			$this->advert_images = @$_SESSION[config::$db_prefix.'advert']['advert_images'];
			
			//Are we updating images?
			if(count($this->advert_images) > 0) {
				
				//Delete Old Images (Files)
				$this->oldSQL = db::query("SELECT * FROM `".config::$db_prefix."advertimages` WHERE `image_advertid`='".$this->advert_data['advert_id']."'");
				while($this->oldData = db::fetch($this->oldSQL)) {
					@unlink(ROOT.'/uploads/advert_images/'.$this->oldData['image_name']);
				}
				
				//Remove DB Entries
				db::query("DELETE FROM `".config::$db_prefix."advertimages` WHERE `image_advertid`='".$this->advert_data['advert_id']."'");
								
				//Foreach Image / Store
				foreach($this->advert_images AS $this->advert_image) {
					
					//Store Images
					db::query("INSERT INTO `".config::$db_prefix."advertimages` (`image_advertid`,
																				 `image_userid`,
																				 `image_name`)
																				  
																				VALUES 
																				
																				('".$this->advert_data['advert_id']."',
																				 '".session::data('user_id',true)."',
																				 '".db::mss($this->advert_image)."')
																				 ");
					
					
					//Image Directory
					$this->image_dir = ROOT.'/uploads/advert_images';
					
					//Move Images, We plan to keep them!
					@rename($this->image_dir.'/temp_images/'.$this->advert_image, $this->image_dir.'/'.$this->advert_image);
				}
				
			}
			
			//Remove Existing Fields
			db::query("DELETE FROM `".config::$db_prefix."store_fields_values` WHERE `value_advertid`='".$this->advert_data['advert_id']."'");
			
			//Field List
			$fieldSQL = db::query("SELECT * FROM `".config::$db_prefix."store_fields` WHERE `field_storeid`='".$store['store_id']."'");
			while($fieldData = db::fetch($fieldSQL)) {
				
					switch($fieldData['field_type']) {
						case 1: { //Textbox
							db::query("INSERT INTO `".config::$db_prefix."store_fields_values` (
																								`value_fieldid`,
																								`value_storeid`,
																								`value_advertid`,
																								`value_optionid`,
																								`value_value`
																								) 
																								
																								VALUES 
																								
																								(
																								 '".$fieldData['field_id']."',
																								 '".$store['store_id']."',
																								 '".$this->advert_data['advert_id']."',
																								 '',
																								 '".lib::post($fieldData['field_id'],true)."'
																								)");
							break;	
						}
						case 2: { //Textarea
							db::query("INSERT INTO `".config::$db_prefix."store_fields_values` (
																								`value_fieldid`,
																								`value_storeid`,
																								`value_advertid`,
																								`value_optionid`,
																								`value_value`
																								) 
																								
																								VALUES 
																								
																								(
																								 '".$fieldData['field_id']."',
																								 '".$store['store_id']."',
																								 '".$this->advert_data['advert_id']."',
																								 '',
																								 '".lib::post($fieldData['field_id'],true)."'
																								)");
							break;	
						}
						case 3: { //Dropdown
							//Load Dropdown Field
							$optionData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."store_fields_options` WHERE `option_id`='".lib::post($fieldData['field_id'])."'");
							db::query("INSERT INTO `".config::$db_prefix."store_fields_values` (
																								`value_fieldid`,
																								`value_storeid`,
																								`value_advertid`,
																								`value_optionid`,
																								`value_value`,
																								`value_fieldname`
																								) 
																								
																								VALUES 
																								
																								(
																								 '".$fieldData['field_id']."',
																								 '".$store['store_id']."',
																								 '".$this->advert_data['advert_id']."',
																								 '',
																								 '".db::mss($optionData['option_name'])."',
																								 '".db::mss($fieldData['field_name'])."'
																								)");
							break;	
						}
						case 4: { //Checkbox
							$optionSQL = db::query("SELECT * FROM `".config::$db_prefix."store_fields_options` WHERE `option_fieldid`='".$fieldData['field_id']."'");
							while($optionData = db::fetch($optionSQL)) {
								db::query("INSERT INTO `".config::$db_prefix."store_fields_values` (
																								`value_fieldid`,
																								`value_storeid`,
																								`value_advertid`,
																								`value_optionid`,
																								`value_value`
																								) 
																								
																								VALUES 
																								
																								(
																								 '".$fieldData['field_id']."',
																								 '".$store['store_id']."',
																								 '".$this->advert_data['advert_id']."',
																								 '".$optionData['option_id']."',
																								 '".lib::post($optionData['option_id'],true)."'
																								)");
							}
							break;	
						}
					}
				
			} 
			
			//Tell Ajax is was OK
			return json_encode(array('success' => 1));
		}
		
	}
	
	////////////////////////////////////////
	// @Delete Category
	////////////////////////////////////////
	public function edit_deletecategory() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Load Store
		$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
			
		//Does it exist?
		if(db::nRows("SELECT `cat_id`,`cat_storeid` FROM `".config::$db_prefix."store_categories` WHERE `cat_id`='".lib::get('cate_id',true)."' AND `cat_storeid`='".$store['store_id']."'") < 0) {
			$this->errorsArray[] = 'Please select a valid';
		}
		
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Delete
			db::query("DELETE FROM `".config::$db_prefix."store_categories` WHERE `cat_id`='".lib::post('cat_id',true)."' AND `cat_storeid`='".$store['store_id']."'");	
		}
			
	}
	
	////////////////////////////////////////
	// @Add Category
	////////////////////////////////////////
	public function edit_addcategory() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have a category name?
		if(!lib::post('cat_name')) { $this->errorsArray[] = 'Please enter a category name below.'; }
		if(strlen(lib::post('cat_name')) > 100) { $this->errorsArray[] = 'Your category name must be less than 100 characters long.'; }
		
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Load Store
			$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
			
			//Insert
			db::query("INSERT INTO `".config::$db_prefix."store_categories` (`cat_name`,`cat_storeid`) VALUES ('".lib::post('cat_name',true)."','".$store['store_id']."')");	
		}
			
	}
	
	
	////////////////////////////////////////
	// @Add Product
	////////////////////////////////////////
	public function AddProduct() {
		
		//A place to store errors
		$this->errorsArray = array();
				
		//Form Field Validation
		if(!lib::post('advert_title')) { $this->errorsArray[] = 'Please enter a title for your advert.'; }
		if(strlen(lib::post('advert_title')) > 60) { $this->errorsArray[] = 'Your advert title must be less than 60 characters long.'; }
		if(!preg_match("/[A-Za-z0-9,'\s]+/", lib::post('advert_title'))) { $this->errorsArray[] = 'Your advert title must not contain any other characters other than A-Z and 0-9 with spaces.'; }
		
		//Validate Price
		if(!lib::post('advert_price')) { $this->errorsArray[] = 'Please enter a valid price for your advert below.'; }
		if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', lib::post('advert_price'))) {
			$this->errorsArray[] = 'Please enter a valid price for your advert below.';
		}
				
		if(!lib::post('advert_html')) { $this->errorsArray[] = 'Please enter a description for your advert to continue.'; }
		if(strlen(lib::post('advert_html')) > 15000) { $this->errorsArray[] = 'Your advert description must not be more than 1500 characters long.'; }
		
		//Prepare Validation
		//preg_match_all( '#<([a-z]+)>#i' , lib::post('advert_html'), $start, PREG_OFFSET_CAPTURE);
		//preg_match_all( '#<\/([a-z]+)>#i' , lib::post('advert_html'), $end, PREG_OFFSET_CAPTURE);
		//$start = $start[1];
		//$end = $end[1];
		
		//Count HTML Tags
		//if(count($start) != count($end)) { $this->errorsArray[] = 'We are missing some HTML tags which should of been closed, what did you do?'; }
		
		//Do we have any images?
		if(isset($_SESSION[config::$db_prefix.'advert']['advert_images']) && is_array($_SESSION[config::$db_prefix.'advert']['advert_images'])) {
			if(count($_SESSION[config::$db_prefix.'advert']['advert_images']) < 1) {
				$this->errorsArray[] = 'Please select an image to upload!';
			}
		} else {
			$this->errorsArray[] = 'Please select an image to upload!';
		}
		
		//Load Store
		$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
		
		//Does it exist?
		if(db::nRows("SELECT `cat_id`,`cat_storeid` FROM `".config::$db_prefix."store_categories` WHERE `cat_id`='".lib::post('advert_catid',true)."' AND `cat_storeid`='".$store['store_id']."'") < 1) {
			$this->errorsArray[] = 'Please select a valid product category';
		}		
		
		//Field List
		$fieldSQL = db::query("SELECT * FROM `".config::$db_prefix."store_fields` WHERE `field_storeid`='".$store['store_id']."'");
		while($fieldData = db::fetch($fieldSQL)) {
				switch($fieldData['field_type']) {
					case 1: { //Textbox
						
						break;	
					}
					case 2: { //Textarea
						
						break;	
					}
					case 3: { //Dropdown Item
						if(db::nRows("SELECT * FROM `".config::$db_prefix."store_fields_options` WHERE `option_id`='".lib::post($fieldData['field_id'],true)."'") < 1) {
							$this->errorsArray[] = 'Invalid Response! [E3]';
						}
						break;	
					}
					case 4: { //Checkbox Exist?
						$optionSQL = db::query("SELECT * FROM `".config::$db_prefix."store_fields_options` WHERE `option_id`='".lib::post($fieldData['field_id'],true)."'");
						while($optionData = db::fetch($optionSQL)) {
							if(!in_array(lib::post($optionData['option_id'],true), array(0,1))) { $this->errorsArray[] = 'Invalid Response! [E4]'; }
						}
						break;	
					}
				}
			
		}
		
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Load Session
			$this->advert = $_SESSION[config::$db_prefix.'advert'];
			
			//Append Info
			$this->advert['advert_title'] = lib::post('advert_title');
			$this->advert['advert_catid'] = lib::post('advert_catid');
			$this->advert['advert_subcatid'] = lib::post('advert_subcatid');
			$this->advert['advert_price'] = lib::post('advert_price');	
			$this->advert['advert_province'] = lib::post('advert_province');
			$this->advert['advert_country'] = lib::post('advert_country');
			$this->advert['advert_html'] = lib::post('advert_html');
						
			//Append Session
			$_SESSION[config::$db_prefix.'advert'] = $this->advert;
			
			//Create Reference
			$this->advert_ref = session::data('user_id',true).'-'.time();
			
			//Create SEO String
			$string = strtolower($this->advert['advert_title']);
			$string = preg_replace('/[^a-zA-Z0-9 ]/','', $string);
			$string = preg_replace('/\s+/','-',$string);
			
			//Load Store
			$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
			
			//Create Advert
			db::query("INSERT INTO `".config::$db_prefix."adverts` (`advert_userid`,
																	`advert_title`,
																	`advert_price`,
																	`advert_html`,
																	`advert_datetime`,
																	`advert_status`,
																	`advert_ref`,
																	`advert_seo_url`,
																	`advert_expiredate`,
																	`advert_store`,
																	`advert_storeid`,
																	`advert_store_catid`) 
																	
																	VALUES 
																	
																	('".session::data('user_id',true)."',
																	 '".db::mss($this->advert['advert_title'])."',
																	 '".db::mss($this->advert['advert_price'])."',
																	 '".db::mss($this->advert['advert_html'])."',
																	 '".date('Y-m-d h:i:s')."',
																	 '1',
																	 '".db::mss($this->advert_ref)."',
																	 '".db::mss($string)."',
																	 '".date('Y-m-d h:i:s', strtotime("+1 Month"))."',
																	 '1',
																	 '".$store['store_id']."',
																	 '".lib::post('advert_catid',true)."')");
			
			//Load Advert
			$this->advert_data = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_ref`='".db::mss($this->advert_ref)."' AND `advert_userid`='".session::data('user_id',true)."'");
						
			//Images
			$this->advert_images = @$_SESSION[config::$db_prefix.'advert']['advert_images'];
			
			//Foreach Image / Store
			foreach($this->advert_images AS $this->advert_image) {
				
				//Store Images
				db::query("INSERT INTO `".config::$db_prefix."advertimages` (`image_advertid`,
																			 `image_userid`,
																			 `image_name`)
																			  
																			VALUES 
																			
																			('".$this->advert_data['advert_id']."',
																			 '".session::data('user_id',true)."',
																			 '".db::mss($this->advert_image)."')
																			 ");
				
				
				//Image Directory
				$this->image_dir = ROOT.'/uploads/advert_images';
				
				//Move Images, We plan to keep them!
				@rename($this->image_dir.'/temp_images/'.$this->advert_image, $this->image_dir.'/'.$this->advert_image);
			}
						
			//Field List
			$fieldSQL = db::query("SELECT * FROM `".config::$db_prefix."store_fields` WHERE `field_storeid`='".$store['store_id']."'");
			while($fieldData = db::fetch($fieldSQL)) {
				
					switch($fieldData['field_type']) {
						case 1: { //Textbox
							db::query("INSERT INTO `".config::$db_prefix."store_fields_values` (
																								`value_fieldid`,
																								`value_storeid`,
																								`value_advertid`,
																								`value_optionid`,
																								`value_value`,
																								`value_fieldname`
																								) 
																								
																								VALUES 
																								
																								(
																								 '".$fieldData['field_id']."',
																								 '".$store['store_id']."',
																								 '".$this->advert_data['advert_id']."',
																								 '',
																								 '".lib::post($fieldData['field_id'],true)."',
																								 '".db::mss($fieldData['field_name'])."'
																								)");
							break;	
						}
						case 2: { //Textarea
							db::query("INSERT INTO `".config::$db_prefix."store_fields_values` (
																								`value_fieldid`,
																								`value_storeid`,
																								`value_advertid`,
																								`value_optionid`,
																								`value_value`,
																								`value_fieldname`
																								) 
																								
																								VALUES 
																								
																								(
																								 '".$fieldData['field_id']."',
																								 '".$store['store_id']."',
																								 '".$this->advert_data['advert_id']."',
																								 '',
																								 '".lib::post($fieldData['field_id'],true)."',
																								 '".db::mss($fieldData['field_name'])."'
																								)");
							break;	
						}
						case 3: { //Dropdown
							//Load Dropdown Field
							$optionData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."store_fields_options` WHERE `option_id`='".lib::post($fieldData['field_id'])."'");
							db::query("INSERT INTO `".config::$db_prefix."store_fields_values` (
																								`value_fieldid`,
																								`value_storeid`,
																								`value_advertid`,
																								`value_optionid`,
																								`value_value`,
																								`value_fieldname`
																								) 
																								
																								VALUES 
																								
																								(
																								 '".$fieldData['field_id']."',
																								 '".$store['store_id']."',
																								 '".$this->advert_data['advert_id']."',
																								 '',
																								 '".db::mss($optionData['option_name'])."',
																								 '".db::mss($fieldData['field_name'])."'
																								)");
							break;	
						}
						case 4: { //Checkbox
							$optionSQL = db::query("SELECT * FROM `".config::$db_prefix."store_fields_options` WHERE `option_fieldid`='".$fieldData['field_id']."'");
							while($optionData = db::fetch($optionSQL)) {
								db::query("INSERT INTO `".config::$db_prefix."store_fields_values` (
																								`value_fieldid`,
																								`value_storeid`,
																								`value_advertid`,
																								`value_optionid`,
																								`value_value`,
																								`value_fieldname`
																								) 
																								
																								VALUES 
																								
																								(
																								 '".$fieldData['field_id']."',
																								 '".$store['store_id']."',
																								 '".$this->advert_data['advert_id']."',
																								 '".$optionData['option_id']."',
																								 '".lib::post($optionData['option_id'],true)."',
																								 '".db::mss($fieldData['field_name'])."'
																								)");
							}
							break;	
						}
					}
				
			} 
			
			//Tell Ajax is was OK
			return json_encode(array('success' => 1));
		}
		
	}
	
	
	//@Add Custom Field
	//Allows us to add a custom field.
	public function edit_DeleteCustomField() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Load Store
		$this->store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."' LIMIT 0,1");
		
		//Does the field exist?
		if(db::nRows("SELECT * FROM `".config::$db_prefix."store_fields` WHERE `field_id`='".lib::post('field_id',true)."' AND `field_storeid`='".$this->store['store_id']."'") < 1) {
			$this->errorsArray[] = 'Please provide a valid field ID to continue.';	
		}
		
		//In use?
		if(db::nRows("SELECT * FROM `".config::$db_prefix."store_fields_values` WHERE `value_fieldid`='".lib::post('field_id',true)."'") > 0) {
			$this->errorsArray[] = 'You have one or more products with this custom field being used, delete them first.';
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			db::query("DELETE FROM `".config::$db_prefix."store_fields` WHERE `field_id`='".lib::post('field_id',true)."'");
			db::query("DELETE FROM `".config::$db_prefix."store_fields_options` WHERE `option_fieldid`='".lib::post('field_id',true)."'");
		}
		
	}
	
	//@Add Custom Field
	//Allows us to add a custom field.
	public function edit_AddCustomField() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have a field type?
		if(!lib::post('field_name')) { $this->errorsArray[] = 'Please provide a valid field name below.'; }
		if(strlen(lib::post('field_name')) > 50) { $this->errorsArray[] = 'Your field name must be less than 50 characters long.'; }
		if(lib::post('field_placeholder')) { 
			if(strlen(lib::post('field_placeholder')) > 255) { 
				$this->errorsArray[] = 'Your field name must be less than 255 characters long.'; 
			}
		}
		if(!in_array(lib::post('field_type'),array(1,2,3,4))) { $this->errorsArray[] = 'Please select a valid field type to continue.'; }
		
		//Switch Validation
		switch(lib::post('field_type')) {
			case 3: {
				for($i=1;$i<=6;$i++) {
					if(lib::post('field_option'.$i)) {
						if(strlen(lib::post('field_option'.$i)) > 255) { $this->errorsArray[] = 'Please provide a valid for option field '.$i; }
					}
				}
				break;	
			}
			case 4: {
				for($i=1;$i<=6;$i++) {
					if(lib::post('field_option'.$i)) {
						if(strlen(lib::post('field_option'.$i)) > 255) { $this->errorsArray[] = 'Please provide a valid for option field '.$i; }
					}
				}
				break;	
			}
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			
			//Load Store
			$this->store = db::fetchQuery("SELECT `store_id` FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");	
					
			//Create Field
			db::query("INSERT INTO `".config::$db_prefix."store_fields` (`field_type`,`field_name`,`field_placeholder`,`field_storeid`) VALUES ('".lib::post('field_type',true)."','".lib::post('field_name',true)."','".lib::post('field_placeholder',true)."','".$this->store['store_id']."')");
			
			//Load Field
			$this->field = db::fetchQuery("SELECT * FROM `".config::$db_prefix."store_fields` WHERE `field_storeid`='".$this->store['store_id']."' ORDER BY `field_id` DESC LIMIT 0,1");
			
			//Create Custom Field Options (If any)
			switch(lib::post('field_type')) {
				case 3: {
					for($i=1;$i<=6;$i++) {
						if(lib::post('field_option'.$i)) {
							db::query("INSERT INTO `".config::$db_prefix."store_fields_options` (`option_name`,`option_fieldid`,`option_storeid`) VALUES ('".lib::post('field_option'.$i,true)."', '".$this->field['field_id']."', '".$this->store['store_id']."')");
						}
					}
					break;	
				}
				case 4: {
					for($i=1;$i<=6;$i++) {
						if(lib::post('field_option'.$i)) {
							db::query("INSERT INTO `".config::$db_prefix."store_fields_options` (`option_name`,`option_fieldid`,`option_storeid`) VALUES ('".lib::post('field_option'.$i,true)."', '".$this->field['field_id']."', '".$this->store['store_id']."')");
						}
					}
					break;	
				}
			}
			
		}
	}
	
	//@Edit Store - Logo Store
	//Allows the user to edit the store logo.
	public function edit_ChangeColors() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have a valid color type?
		if(!in_array(lib::post('store_color-type'), array('menu-color',  'item-background-active', 'item-font-color-active', 'item-font-color-normal'))) {
			$this->errorsArray[] = 'Please provide a valid HTML color code type to continue.';
		}
		
		//Do we have a valid color hex?
		if(!preg_match('/^[a-f0-9]{6}$/', lib::post('store_color-code'))) {
			$this->errorsArray[] = 'Please provide a valid HTML color code to continue.';
		}
			
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			
			//What are we updating?
			switch(lib::post('store_color-type')) {
				case 'menu-color': { 
					db::query("UPDATE `".config::$db_prefix."stores` SET `store_menu_color`='".lib::post('store_color-code',true)."' WHERE `store_userid`='".session::data('user_id')."'");
					break; 
				}	
				case 'item-background-active': { 
					db::query("UPDATE `".config::$db_prefix."stores` SET `store_item_background_active`='".lib::post('store_color-code',true)."' WHERE `store_userid`='".session::data('user_id')."'");
					break; 
				}
				case 'item-font-color-active': { 
					db::query("UPDATE `".config::$db_prefix."stores` SET `store_item_font_color_active`='".lib::post('store_color-code',true)."' WHERE `store_userid`='".session::data('user_id')."'");
					break; 
				}
				case 'item-font-color-normal': { 
					db::query("UPDATE `".config::$db_prefix."stores` SET `store_item_font_color_normal`='".lib::post('store_color-code',true)."' WHERE `store_userid`='".session::data('user_id')."'");
					break; 
				}
			}
			
			//Return Success
			return json_encode(array('success' => true));
			
		}
		
		
	}
	
	//@Edit Store - Logo Store
	//Allows the user to edit the store logo.
	public function edit_LogoUpload() {
		
		//A place to store errors
		$this->errorsArray = array();
				
		//Allowed Image Types
		$this->allowedImageTypes = array('image/jpg','image/jpeg','image/png','image/gif');
		$this->maxSize = 2097152;
		$this->minWidth = 250;
		$this->minHeight = 100;
		
		//Does the session even exist?
		if(isset($_SESSION[config::$db_prefix.'store']) == false) {
			$this->errorsArray[] = 'Something unexpected happened with the session, where did it go?';
		}
		
		// Check atleast one image has been selected
		if(@$_FILES['store-logo']['tmp_name']== ""){
			$this->errorsArray[] = 'Please select an image to upload.';
		}
				
		// Check Images are valid image types
		if(!in_array(@$_FILES['store-logo']['type'], $this->allowedImageTypes)){
			$this->errorsArray[] = 'The logo image type you have uploaded is not supported, please select another image.';
		}
		
		// Check images are valid sizes
		if(@$_FILES['store-logo']['size'] > $this->maxSize){
			$this->errorsArray[] = 'Your logo image file size is too big, please select a smaller sized file.';
		}
		
		// Get image width and height
		$this->image_dimensions = @getimagesize(@$_FILES['store-logo']['tmp_name']); // returns an array of image info [0] = width, [1] = height
		$this->image_width = $this->image_dimensions[0]; // Image width
		$this->image_height = $this->image_dimensions[1]; // Image height
		if(($this->image_width < $this->minWidth) || ($this->image_height < $this->minHeight)){
			$this->errorsArray[] = 'One or more of your images does not meet the minimum height and minimum width requirements. - '.@$_FILES['store-logo']['name'];
		}
				
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Load Store
			$this->store = db::fetchQuery("SELECT `store_id`,`store_logo` FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
			
			//Lets resize and get that image stored
			require(ROOT.'/classes/simpleimage.class.php');
			
			//Image Directory
			$this->image_dir = ROOT.'/uploads/store_images';
			
			//Remove Old Image
			@unlink($this->image_dir.'/'.@$this->store['store_logo']);	
			
			//Move File to Temp Directory
			move_uploaded_file(@$_FILES['store-logo']['tmp_name'], $this->image_dir.'/temp_images/'.@$_FILES['store-logo']['name']);
			
			//Unique Image Name
			$this->unique_name = 'logo-'.session::data('user_id').'-'.preg_replace('/[. ]+/', '-', microtime()).'.jpg';
			
			//Load Simple Image Class
			$image = new \claviska\SimpleImage();
			
			//Magic!
			@$image
			  ->fromFile($this->image_dir.'/temp_images/'.@$_FILES['store-logo']['name']) // load image.jpg
			  //->resize(250)
			  // resize to 320x200 pixels
			  /* ->overlay('watermark.png', 'bottom right')  // add a watermark image */
			  ->toFile($this->image_dir.'/'.$this->unique_name, 'image/jpg');      // convert to PNG and save a copy to new-image.png
						 
			//@Unlink
			@unlink($this->image_dir.'/temp_images/'.@$_FILES['store-logo']['name']);
									
			//Save Image
			db::query("UPDATE `".config::$db_prefix."stores` SET `store_logo`='".db::mss($this->unique_name)."' WHERE `store_userid`='".session::data('user_id')."'");
									
			//Return Data
			return json_encode(array('success' => true, 'image-name' => $this->unique_name));
			
		}
	}
	
	//@Delete Banners
	//Allows the user to edit the store banners
	public function edit_deleteBanners() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the banner exist?
		if(db::nRows("SELECT `banner_id` FROM `".config::$db_prefix."store_banners` WHERE `banner_userid`='".session::data('user_id')."' AND `banner_id`='".lib::post('banner_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please provide a valid banner ID';	
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return $this->errorsArray[0];
		} else {
			db::query("DELETE FROM `".config::$db_prefix."store_banners` WHERE `banner_userid`='".session::data('user_id')."' AND `banner_id`='".lib::post('banner_id',true)."'");
		}
		
	}
	
	//@Upload Banners
	//Allows the user to upload banners via edit store.
	public function edit_uploadBanner() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Allowed Image Types
		$this->allowedImageTypes = array('image/jpg','image/jpeg','image/png','image/gif');
		$this->maxSize = 2097152;
		$this->minWidth = 960;
		$this->minHeight = 360;
		
		// Check atleast one image has been selected
		if(@$_FILES['store-banner']['tmp_name']== ""){
			$this->errorsArray[] = 'Please select an image to upload.';
		}
				
		// Check Images are valid image types
		if(!in_array(@$_FILES['store-banner']['type'], $this->allowedImageTypes)){
			$this->errorsArray[] = 'One or more images are not supported. Please check and try again.';
		}
		
		// Check images are valid sizes
		if(@$_FILES['store-banner']['size'] > $this->maxSize){
			$this->errorsArray[] = 'One or more of your images exceeds the max file size, please reduce the image file size to continue.';
		}
		
		// Get image width and height
		$this->image_dimensions = @getimagesize(@$_FILES['store-banner']['tmp_name']); // returns an array of image info [0] = width, [1] = height
		$this->image_width = $this->image_dimensions[0]; // Image width
		$this->image_height = $this->image_dimensions[1]; // Image height
		if(($this->image_width < $this->minWidth) || ($this->image_height < $this->minHeight)){
			$this->errorsArray[] = 'One or more of your images does not meet the minimum height and minimum width requirements. - '.@$_FILES['store-banner']['name'];
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			
			//Lets resize and get that image stored
			require(ROOT.'/classes/simpleimage.class.php');
			
			//Image Directory
			$this->image_dir = ROOT.'/uploads/store_images';
			
			//Move File to Temp Directory
			move_uploaded_file(@$_FILES['store-banner']['tmp_name'], $this->image_dir.'/temp_images/'.@$_FILES['store-banner']['name']);
			
			//Unique Image Name
			$this->unique_name = 'banner-'.session::data('user_id').'-'.preg_replace('/[. ]+/', '-', microtime()).'.jpg';
			
			//Load Simple Image Class
			$image = new \claviska\SimpleImage();
			
			//Magic!
			@$image
			  ->fromFile($this->image_dir.'/temp_images/'.@$_FILES['store-banner']['name']) // load image.jpg
			  //->resize(250)
			  // resize to 320x200 pixels
			  /* ->overlay('watermark.png', 'bottom right')  // add a watermark image */
			  ->toFile($this->image_dir.'/'.$this->unique_name, 'image/jpg');      // convert to PNG and save a copy to new-image.png
						 
			//@Unlink
			@unlink($this->image_dir.'/temp_images/'.@$_FILES['store-banner']['name']);
			
			//Load Store
			$this->store = db::fetchQuery("SELECT `store_id` FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
			
			//Store Images
			db::query("INSERT INTO `".config::$db_prefix."store_banners` (`banner_userid`,`banner_image`,`banner_storeid`)
			
																				VALUES 
																				
																				('".session::data('user_id')."',
																				 '".db::mss($this->unique_name)."',
																				 '".$this->store['store_id']."')
																				 ");
										
			//Return Data
			return json_encode(array('success' => true, 'image-name' => $this->unique_name));
					
			
		}
			
	}
	
	
	//@Edit Store
	//Allows the user to edit their store.
	public function editStore() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have a store title?
		if(!lib::post('store_title')) { $this->errorsArray[] = 'Please enter a store title below to continue.'; }
		if(strlen(lib::post('store_title')) > 80) { $this->errorsArray[] = 'Your store title must be less than 80 characters long.';}
		
		//Description
		if(!lib::post('store_description')) { $this->errorsArray[] = 'Please enter a store description below.'; }
		if(strlen(lib::post('store_description')) > 1500) { $this->errorsArray[] = 'Your store description must be less than 1500 characters long.'; }
		
		//Store Keywords
		if(!lib::post('store_keywords')) { $this->errorsArray[] = 'Please enter a store description below.'; }
		if(strlen(lib::post('store_keywords')) > 500) { $this->errorsArray[] = 'Your store keywords must be less than 500 characters long.';}
		
		//Store About Us
		if(!lib::post('store_aboutus')) { $this->errorsArray[] = 'Please enter some text for your "About Us" page, this will be displayed to your customers.';}
		if(strlen(lib::post('store_aboutus')) > 1500) { $this->errorsArray[] = 'Your store about us text must be less than 1500 characters long.';}
		
		//Store Email
		if(!lib::post('store_email')) { $this->errorsArray[] = 'Please provide an email address for your store, this will allow customers to contact you.'; }
		if(!filter_var(lib::post('store_email'), FILTER_VALIDATE_EMAIL)) { $this->errorsArray[] = 'Please provide a valid store email address to continue.'; }
		
		//Store Address
		if(!lib::post('store_address')) {  
			if(strlen(lib::post('store_address')) > 500) { $this->errorsArray[] = 'Your store address must be less than 500 characters long.'; }
		}
		
		//Store Phone
		if(lib::post('store_phone')) { 
			if(strlen(lib::post('store_phone')) > 15) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
			if(!preg_match('/^[0-9\s+]+$/',lib::post('store_phone'))) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
		}
		
		//Store Phone
		if(lib::post('store_phone1')) { 
			if(strlen(lib::post('store_phone1')) > 15) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
			if(!preg_match('/^[0-9\s+]+$/',lib::post('store_phone1'))) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
		}
		
		//Store Phone
		if(lib::post('store_phone2')) { 
			if(strlen(lib::post('store_phone2')) > 15) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
			if(!preg_match('/^[0-9\s+]+$/',lib::post('store_phone2'))) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
		}
		
		//Store Whatsapp
		if(lib::post('store_whatsapp')) { 
			if(strlen(lib::post('store_whatsapp')) > 15) { $this->errorsArray[] = 'Please provide a valid whatsapp phone number below.'; }
			if(!preg_match('/^[0-9\s+]+$/',lib::post('store_whatsapp'))) { $this->errorsArray[] = 'Please provide a valid whatsapp phone number below.'; }
		}
		
		//Twitter URL
		if(lib::post('store_twitter')) {
			if(strlen(lib::post('store_twitter')) > 100) { $this->errorsArray[] = 'Please provide a valid twitter url below.'; }
			if(!strstr(lib::post('store_twitter'), 'twitter.com')) { $this->errorsArray[] = 'Please provide a valid twitter url below.'; }
		}
		
		//Facebook URL
		if(lib::post('store_facebook')) {
			if(strlen(lib::post('store_facebook')) > 100) { $this->errorsArray[] = 'Please provide a valid facebook url below.'; }
			if(!strstr(lib::post('store_facebook'), 'facebook.com')) { $this->errorsArray[] = 'Please provide a valid facebook url below.'; }
		}
		
		//Google URL
		if(lib::post('store_google')) {
			if(strlen(lib::post('store_google')) > 100) { $this->errorsArray[] = 'Please provide a valid google url below.'; }
			if(!strstr(lib::post('store_google'), 'google.com')) { $this->errorsArray[] = 'Please provide a valid google url below.'; }
		}
		
		//Payment Method
		if(!lib::post('store_paymentmethod')) { $this->errorsArray[] = 'Please provide a payment method below so we can pay you.'; }
		if(strlen(lib::post('store_paymenthod')) > 1000) { $this->errorsArray[] = 'Please provide a valid payment method below.'; }
		
		//Payment Method
		if(lib::post('store_echocash')) { 
			if(strlen(lib::post('store_echocash')) > 1000) { $this->errorsArray[] = 'Please provide a valid echo cash payment method below.'; }
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return $this->errorsArray[0];
		} else {
			
			//Create a store
			db::query("UPDATE `".config::$db_prefix."stores` SET 
																   `store_title`='".lib::post('store_title',true)."',
																   `store_description`='".lib::post('store_description',true)."',
																   `store_keywords`='".lib::post('store_keywords',true)."',
																   `store_aboutus`='".lib::post('store_aboutus',true)."',
																   `store_email`='".lib::post('store_email',true)."',
																   `store_address`='".lib::post('store_address',true)."',
																   `store_phone`='".lib::post('store_phone',true)."',
																   `store_phone1`='".lib::post('store_phone1',true)."',
																   `store_phone2`='".lib::post('store_phone2',true)."',
																   `store_whatsapp`='".lib::post('store_whatsapp',true)."',
																   `store_twitter`='".lib::post('store_twitter',true)."',
																   `store_facebook`='".lib::post('store_facebook',true)."',
																   `store_google`='".lib::post('store_google',true)."',
																   `store_paymentmethod`='".lib::post('store_paymentmethod',true)."',
																   `store_echocash`='".lib::post('store_echocash',true)."',
																   `store_menu_color`='".lib::post('menu-color',true)."',
																   `store_item_background_active`='".lib::post('item-background-active',true)."',
																   `store_item_font_color_active`='".lib::post('item-font-color-active',true)."',
																   `store_item_font_color_normal`='".lib::post('item-font-color-normal',true)."'
																   
																   WHERE `store_userid`='".session::data('user_id')."'
																   
																   ");
			
			
		}
	}
	
	//@Set Session Colors
	//Allows the user to customize the store.
	public function createStore_ChangeColor() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have a valid color type?
		if(!in_array(lib::post('store_color-type'), array('menu-color',  'item-background-active', 'item-font-color-active', 'item-font-color-normal'))) {
			$this->errorsArray[] = 'Please provide a valid HTML color code type to continue.';
		}
		
		//Do we have a valid color hex?
		if(!preg_match('/^[a-f0-9]{6}$/', lib::post('store_color-code'))) {
			$this->errorsArray[] = 'Please provide a valid HTML color code to continue.';
		}
			
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			
			//Load Image Session
			if(isset($_SESSION[config::$db_prefix.'store']['store-colors']) && is_array($_SESSION[config::$db_prefix.'store']['store-colors'])) {
				$this->store_colors = @$_SESSION[config::$db_prefix.'store']['store-colors'];	
			} else {
				@$_SESSION[config::$db_prefix.'store']['store-colors'] = array();
				$this->store_colors = @$_SESSION[config::$db_prefix.'store']['store-colors'];
			}
			
			//Unset The Color Type
			unset($this->store_colors[lib::post('store_color-type')]);
			
			//Store the new color
			$this->store_colors[lib::post('store_color-type')]  = lib::post('store_color-code');
			
			//Store the new session.
			@$_SESSION[config::$db_prefix.'store']['store-colors'] = $this->store_colors;
			
			//Return Success
			return json_encode(array('success' => true));
			
		}
		
	}
	
	//@Ajax Banner Upload - Allow Banner Upload
	//Allows the upload of banners
	public function createStore_BannerRemove() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			
			//Load Image Session
			if(isset($_SESSION[config::$db_prefix.'store']['store-banners']) && is_array($_SESSION[config::$db_prefix.'store']['store-banners'])) {
				$this->banner_images = @$_SESSION[config::$db_prefix.'store']['store-banners'];	
			} else {
				@$_SESSION[config::$db_prefix.'store']['store-banners'] = array();
				$this->banner_images = @$_SESSION[config::$db_prefix.'store']['store-banners'];
			}
			
			//Image Directory
			$this->image_dir = ROOT.'/uploads/store_images';
			
			//Loop
			foreach($this->banner_images AS $this->image_key => $this->image_name) {
				if(lib::post('banner_image') == $this->image_key) {
					unlink($this->image_dir.'/temp_images/'.$this->image_name); //Delete the Image
					unset($this->banner_images[$this->image_key]); //Remove Entry from Array
				}
			}
					
			//Save Image
			unset($_SESSION[config::$db_prefix.'store']['store-banners']);
			$_SESSION[config::$db_prefix.'store']['store-banners'] = $this->banner_images;	
			
			//Return Data
			return json_encode(array('success' => true));
		}
		
	}
	
	//@Ajax Banner Upload - Allow Banner Upload
	//Allows the upload of banners
	public function createStore_BannerUpload() {
		
		//A place to store errors
		$this->errorsArray = array();
				
		//Allowed Image Types
		$this->allowedImageTypes = array('image/jpg','image/jpeg','image/png','image/gif');
		$this->maxSize = 2097152;
		$this->minWidth = 960;
		$this->minHeight = 360;
		
		// Check atleast one image has been selected
		if(@$_FILES['store-banner']['tmp_name']== ""){
			$this->errorsArray[] = 'Please select an image to upload.';
		}
				
		// Check Images are valid image types
		if(!in_array(@$_FILES['store-banner']['type'], $this->allowedImageTypes)){
			$this->errorsArray[] = 'One or more images are not supported. Please check and try again.';
		}
		
		// Check images are valid sizes
		if(@$_FILES['store-banner']['size'] > $this->maxSize){
			$this->errorsArray[] = 'One or more of your images exceeds the max file size, please reduce the image file size to continue.';
		}
		
		// Get image width and height
		$this->image_dimensions = @getimagesize(@$_FILES['store-banner']['tmp_name']); // returns an array of image info [0] = width, [1] = height
		$this->image_width = $this->image_dimensions[0]; // Image width
		$this->image_height = $this->image_dimensions[1]; // Image height
		if(($this->image_width < $this->minWidth) || ($this->image_height < $this->minHeight)){
			$this->errorsArray[] = 'One or more of your images does not meet the minimum height and minimum width requirements. - '.@$_FILES['store-banner']['name'];
		}
		
		//Does the session even exist?
		if(isset($_SESSION[config::$db_prefix.'store']) == false) {
			$this->errorsArray[] = 'Something unexpected happened with the session, where did it go?';
		} else {
			//Do we have any images?
			if(isset($_SESSION[config::$db_prefix.'store']['store-banners']) && is_array($_SESSION[config::$db_prefix.'store']['store-banners'])) {
				if(count($_SESSION[config::$db_prefix.'store']['store-banners']) > 6) {
					$this->errorsArray[] = 'You have uploaded to many images, remove one or more to continue.';
				}
			}
		}
		
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Lets resize and get that image stored
			require(ROOT.'/classes/simpleimage.class.php');
			
			//Image Directory
			$this->image_dir = ROOT.'/uploads/store_images';
			
			//Move File to Temp Directory
			move_uploaded_file(@$_FILES['store-banner']['tmp_name'], $this->image_dir.'/temp_images/'.@$_FILES['store-banner']['name']);
			
			//Unique Image Name
			$this->unique_name = 'banner-'.session::data('user_id').'-'.preg_replace('/[. ]+/', '-', microtime()).'.jpg';
			
			//Load Simple Image Class
			$image = new \claviska\SimpleImage();
			
			//Magic!
			@$image
			  ->fromFile($this->image_dir.'/temp_images/'.@$_FILES['store-banner']['name']) // load image.jpg
			  //->resize(250)
			  // resize to 320x200 pixels
			  /* ->overlay('watermark.png', 'bottom right')  // add a watermark image */
			  ->toFile($this->image_dir.'/temp_images/'.$this->unique_name, 'image/jpg');      // convert to PNG and save a copy to new-image.png
						 
			//@Unlink
			@unlink($this->image_dir.'/temp_images/'.@$_FILES['store-banner']['name']);
			
			//Load Image Session
			if(isset($_SESSION[config::$db_prefix.'store']['store-banners']) && is_array($_SESSION[config::$db_prefix.'store']['store-banners'])) {
				$this->banner_images = @$_SESSION[config::$db_prefix.'store']['store-banners'];	
			} else {
				@$_SESSION[config::$db_prefix.'store']['store-banners'] = array();
				$this->banner_images = @$_SESSION[config::$db_prefix.'store']['store-banners'];
			}
			
			//Append Images to Array
			$this->banner_images[@$_FILES['store-banner']['name']] = $this->unique_name;
			
			//Save Image
			$_SESSION[config::$db_prefix.'store']['store-banners'] = $this->banner_images;
									
			//Return Data
			return json_encode(array('success' => true, 'image-name' => $this->unique_name));
			
		}
	}
	
	
	//@Ajax Image Upload - Store Loog
	//Allows the store logo to be uploaded
	public function createStore_LogoRemove() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the session even exist?
		if(isset($_SESSION[config::$db_prefix.'store']) == false) {
			$this->errorsArray[] = 'Something unexpected happened with the session, where did it go?';
		}
		
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Image Directory
			$this->image_dir = ROOT.'/uploads/store_images';
			
			//Remove Old Image
			if(isset($_SESSION[config::$db_prefix.'store']['store-logo']) && $_SESSION[config::$db_prefix.'store']['store-logo'] != '') {
				@unlink($this->image_dir.'/temp_images/'.@$_SESSION[config::$db_prefix.'store']['store-logo']);
				@$_SESSION[config::$db_prefix.'store']['store-logo'] = '';
			}
			
			//Return Data
			return json_encode(array('success' => true));
		}
		
	}
	
	//@Ajax Image Upload - Store Loog
	//Allows the store logo to be uploaded
	public function createStore_LogoUpload() {
		
		//A place to store errors
		$this->errorsArray = array();
				
		//Allowed Image Types
		$this->allowedImageTypes = array('image/jpg','image/jpeg','image/png','image/gif');
		$this->maxSize = 2097152;
		$this->minWidth = 250;
		$this->minHeight = 100;
		
		//Does the session even exist?
		if(isset($_SESSION[config::$db_prefix.'store']) == false) {
			$this->errorsArray[] = 'Something unexpected happened with the session, where did it go?';
		}
		
		// Check atleast one image has been selected
		if(@$_FILES['store-logo']['tmp_name']== ""){
			$this->errorsArray[] = 'Please select an image to upload.';
		}
				
		// Check Images are valid image types
		if(!in_array(@$_FILES['store-logo']['type'], $this->allowedImageTypes)){
			$this->errorsArray[] = 'The logo image type you have uploaded is not supported, please select another image.';
		}
		
		// Check images are valid sizes
		if(@$_FILES['store-logo']['size'] > $this->maxSize){
			$this->errorsArray[] = 'Your logo image file size is too big, please select a smaller sized file.';
		}
		
		// Get image width and height
		$this->image_dimensions = @getimagesize(@$_FILES['store-logo']['tmp_name']); // returns an array of image info [0] = width, [1] = height
		$this->image_width = $this->image_dimensions[0]; // Image width
		$this->image_height = $this->image_dimensions[1]; // Image height
		if(($this->image_width < $this->minWidth) || ($this->image_height < $this->minHeight)){
			$this->errorsArray[] = 'One or more of your images does not meet the minimum height and minimum width requirements. - '.@$_FILES['store-logo']['name'];
		}
				
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Lets resize and get that image stored
			require(ROOT.'/classes/simpleimage.class.php');
			
			//Image Directory
			$this->image_dir = ROOT.'/uploads/store_images';
			
			//Remove Old Image
			if(isset($_SESSION[config::$db_prefix.'store']['store-logo']) && $_SESSION[config::$db_prefix.'store']['store-logo'] != '') {
				unlink($this->image_dir.'/temp_images/'.@$_SESSION[config::$db_prefix.'store']['store-logo']);	
			}
			
			//Move File to Temp Directory
			move_uploaded_file(@$_FILES['store-logo']['tmp_name'], $this->image_dir.'/temp_images/'.@$_FILES['store-logo']['name']);
			
			//Unique Image Name
			$this->unique_name = 'logo-'.session::data('user_id').'-'.preg_replace('/[. ]+/', '-', microtime()).'.jpg';
			
			//Load Simple Image Class
			$image = new \claviska\SimpleImage();
			
			//Magic!
			@$image
			  ->fromFile($this->image_dir.'/temp_images/'.@$_FILES['store-logo']['name']) // load image.jpg
			  //->resize(250)
			  // resize to 320x200 pixels
			  /* ->overlay('watermark.png', 'bottom right')  // add a watermark image */
			  ->toFile($this->image_dir.'/temp_images/'.$this->unique_name, 'image/jpg');      // convert to PNG and save a copy to new-image.png
						 
			//@Unlink
			@unlink($this->image_dir.'/temp_images/'.@$_FILES['store-logo']['name']);
									
			//Save Image
			$_SESSION[config::$db_prefix.'store']['store-logo'] = $this->unique_name;
									
			//Return Data
			return json_encode(array('success' => true, 'image-name' => $this->unique_name));
			
		}
	}
		
	//@Create Store - Stage 4
	//Create the store, Make a payment, Redirect
	public function createStore_Stage4() {
		
		//@A place to store errors
		$this->errorsArray = array();
		
		//Do we have a valid store-pack?
		if(!lib::post('store_packid')) { $this->errorsArray[]  = 'Please select a valid store pack-id to continue.';}
		if(db::nRows("SELECT `pack_id` FROM `".config::$db_prefix."stpacks` WHERE `pack_id`='".lib::post('store_packid',true)."'") < 1) {
			$this->errorsArray[] = 'Please provide a valid store pack-id to continue.';	
		}
		
		//Do we have a valid payment gateway ID?
		if(!lib::post('payment_method')) { $this->errorsArray[] = 'Please provide a valid payment gateway ID to continue.'; }
		if(!in_array(lib::post('payment_method'),array(1,2,3))) { $this->errorsArray[] = 'Please provide a valid payment gateway ID to continue.'; }
		
		//Do we have any issues?
		if(count($this->errorsArray)) {
			echo $this->errorsArray[0];	
		} else {
				
			//Load Session
			$this->store_session = @$_SESSION[config::$db_prefix.'store'];
						
			//Create a store
			db::query("INSERT INTO `".config::$db_prefix."stores` (
																   `store_userid`,
																   `store_username`,
																   `store_title`,
																   `store_description`,
																   `store_keywords`,
																   `store_aboutus`,
																   `store_email`,
																   `store_address`,
																   `store_phone`,
																   `store_phone1`,
																   `store_phone2`,
																   `store_whatsapp`,
																   `store_twitter`,
																   `store_facebook`,
																   `store_google`,
																   `store_paymentmethod`,
																   `store_echocash`,
																   `store_packid`,
																   `store_menu_color`,
																   `store_item_background_active`,
																   `store_item_font_color_active`,
																   `store_item_font_color_normal`
																   ) 
																   VALUES 
																   (
																   	'".session::data('user_id')."',
																	'".db::mss(@strtolower($this->store_session['store_username']))."',
																	'".db::mss(@$this->store_session['store_title'])."',
																	'".db::mss(@$this->store_session['store_description'])."',
																	'".db::mss(@$this->store_session['store_keywords'])."',
																	'".db::mss(@$this->store_session['store_aboutus'])."',
																	'".db::mss(@$this->store_session['store_email'])."',
																	'".db::mss(@$this->store_session['store_address'])."',
																	'".db::mss(@$this->store_session['store_phone'])."',
																	'".db::mss(@$this->store_session['store_phone1'])."',
																	'".db::mss(@$this->store_session['store_phone2'])."',
																	'".db::mss(@$this->store_session['store_whatsapp'])."',
																	'".db::mss(@$this->store_session['store_twitter'])."',
																	'".db::mss(@$this->store_session['store_facebook'])."',
																	'".db::mss(@$this->store_session['store_google'])."',
																	'".db::mss(@$this->store_session['store_paymentmethod'])."',
																	'".db::mss(@$this->store_session['store_echocash'])."',
																	
																	'".lib::post('store_packid',true)."',
																	'".db::mss(@$this->store_session['store-colors']['menu-color'])."',
																	'".db::mss(@$this->store_session['store-colors']['item-background-active'])."',
																	'".db::mss(@$this->store_session['store-colors']['item-font-color-active'])."',
																	'".db::mss(@$this->store_session['store-colors']['item-font-color-normal'])."'
																   )");
																   
						
			
			
			//Load Store
			$this->store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
			
					
			////////////////////////////////////////////////////////////////////
			//Store Banner Images	
			////////////////////////////////////////////////////////////////////			   
			$this->banner_images = @$_SESSION[config::$db_prefix.'store']['store-banners'];
			
			//Are we updating images?
			if(count($this->banner_images) > 0) {
												
				//Foreach Image / Store
				foreach($this->banner_images AS $this->banner_key => $this->banner_image) {
					
					//Store Images
					db::query("INSERT INTO `".config::$db_prefix."store_banners` (`banner_userid`,
																				 `banner_image`,
																				 `banner_storeid`)
																				  
																				VALUES 
																				
																				('".session::data('user_id')."',
																				 '".db::mss($this->banner_image)."',
																				 '".$this->store['store_id']."')
																				 ");
					
					
					//Image Directory
					$this->image_dir = ROOT.'/uploads/store_images';
					
					//Move Images, We plan to keep them!
					@rename($this->image_dir.'/temp_images/'.$this->banner_image, $this->image_dir.'/'.$this->banner_image);
				}
				
			}
			
			////////////////////////////////////////////////////////////////////
			//Store Logo
			////////////////////////////////////////////////////////////////////
			$this->store_logo = @$_SESSION[config::$db_prefix.'store']['store-logo'];
			if(isset($this->store_logo) && $this->store_logo != '') {
				
				//Update Store
				db::query("UPDATE `".config::$db_prefix."stores` SET `store_logo`='".db::mss($this->store_logo)."' WHERE `store_id`='".$this->store['store_id']."'");
				
				//Image Directory
				$this->image_dir = ROOT.'/uploads/store_images';
					
				//Move Images, We plan to keep them!
				@rename($this->image_dir.'/temp_images/'.$this->store_logo, $this->image_dir.'/'.$this->store_logo);
				
			}
			
			
			
			
			//Load Ad-pack
			$this->stpack = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stpacks` WHERE `pack_id`='".lib::post('store_packid',true)."'");
						
			//Create Invoice
			db::query("INSERT INTO `".config::$db_prefix."invoices` 
			
			(
			
			`invoice_userid`,
			`invoice_type`,
			`invoice_typeid`,
			`invoice_amount`,
			`invoice_gatewayfees`
			
			) 
			VALUES 
			(
			
			'".session::data('user_id',true)."',
			'2',
			'".$this->store['store_id']."', 
			'".db::mss($this->stpack['pack_price'])."',
			'0.00'
			
			)");	
			
			//Load Invoice
			$this->invoice = db::fetchQuery("SELECT * FROM `".config::$db_prefix."invoices` WHERE  (`invoice_userid`='".session::data('user_id',true)."' AND `invoice_typeid`='".$this->store['store_id']."' AND `invoice_type`='2') ORDER BY `invoice_id` DESC LIMIT 0,1");
			
			//Redirect to Gateways
			switch(lib::post('payment_method')) {
				//PayPal
				case 1: {
					//Load PayPal Class
					require(ROOT.'/classes/paypal/paypal.class.php');	
					$paypal=new paypal();
					$sort_id = '2'.'-'.$this->store['store_id'].'-'.$this->invoice['invoice_id'].'-'.$this->stpack['pack_id'];
					return $paypal->create_trans($sort_id, $this->stpack['pack_price'], $this->stpack['pack_title'], DOMAIN.'/index.php?page=dashboard&view=store&action=success');		
					break;
				}
				//PayNow
				case 2: {
					//Load PayNow Class
					require(ROOT.'/classes/paynow/paynow.class.php');												
					$paynow=new paynow();
					$sort_id = '2'.'-'.$this->store['store_id'].'-'.$this->invoice['invoice_id'].'-'.$this->stpack['pack_id'];
					$paynow->create_trans($sort_id, $this->stpack['pack_price'], $this->stpack['pack_title'], DOMAIN.'/index.php?page=dashboard&view=store&action=success');
					break;
				}
				case 3: {
					@header("Location:".DOMAIN.'/index.php?page=dashboard&view=store&action=success');
					die();
					break;	
				}
			}
			
			
			
			
		}
			
	}
	
	//@Create Store - Stage 1
	//This will allow us to log the unique views of adverts
	public function createStore_Stage1() {
		
		//@A place to store errors
		$this->errorsArray = array();
					
		if(db::nRows("SELECT `store_id` FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'") > 0) {
			$this->errorsArray[] = 'We are currently waiting for the payment to process, you can not create another store.';	
		}
			
		//Do we have a store username?
		if(!lib::post('store_username')) { $this->errorsArray[] = 'Please provide a store username below to continue.'; }
		if(strlen(lib::post('store_username')) > 20) { $this->errorsArray[] = 'Your store username must be less than 80 characters long.';}
		if(!preg_match('/^[a-z0-9]{0,20}+$/', lib::post('store_username'))) { $this->errorsArray[] = 'Your store username must contain lowercase characters and numbers only.'; }
		if(db::nRows("SELECT `store_username` FROM `".config::$db_prefix."stores` WHERE `store_username`='".lib::post('store_username',true)."'") > 0) {
			$this->errorsArray[] = 'Sorry, that username is already being used, please choose another.';	
		}
		
		//Do we have a store title?
		if(!lib::post('store_title')) { $this->errorsArray[] = 'Please enter a store title below to continue.'; }
		if(strlen(lib::post('store_title')) > 80) { $this->errorsArray[] = 'Your store title must be less than 80 characters long.';}
		
		//Description
		if(!lib::post('store_description')) { $this->errorsArray[] = 'Please enter a store description below.'; }
		if(strlen(lib::post('store_description')) > 1500) { $this->errorsArray[] = 'Your store description must be less than 1500 characters long.'; }
		
		//Store Keywords
		if(!lib::post('store_keywords')) { $this->errorsArray[] = 'Please enter a store description below.'; }
		if(strlen(lib::post('store_keywords')) > 500) { $this->errorsArray[] = 'Your store keywords must be less than 500 characters long.';}
		
		//Store About Us
		if(!lib::post('store_aboutus')) { $this->errorsArray[] = 'Please enter some text for your "About Us" page, this will be displayed to your customers.';}
		if(strlen(lib::post('store_aboutus')) > 1500) { $this->errorsArray[] = 'Your store about us text must be less than 1500 characters long.';}
		
		//Store Email
		if(!lib::post('store_email')) { $this->errorsArray[] = 'Please provide an email address for your store, this will allow customers to contact you.'; }
		if(!filter_var(lib::post('store_email'), FILTER_VALIDATE_EMAIL)) { $this->errorsArray[] = 'Please provide a valid store email address to continue.'; }
		
		//Store Address
		if(!lib::post('store_address')) {  
			if(strlen(lib::post('store_address')) > 500) { $this->errorsArray[] = 'Your store address must be less than 500 characters long.'; }
		}
		
		//Store Phone
		if(lib::post('store_phone')) { 
			if(strlen(lib::post('store_phone')) > 15) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
			if(!preg_match('/^[0-9\s+]+$/',lib::post('store_phone'))) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
		}
		
		//Store Phone
		if(lib::post('store_phone1')) { 
			if(strlen(lib::post('store_phone1')) > 15) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
			if(!preg_match('/^[0-9\s+]+$/',lib::post('store_phone1'))) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
		}
		
		//Store Phone
		if(lib::post('store_phone2')) { 
			if(strlen(lib::post('store_phone2')) > 15) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
			if(!preg_match('/^[0-9\s+]+$/',lib::post('store_phone2'))) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
		}
		
		//Store Whatsapp
		if(lib::post('store_whatsapp')) { 
			if(strlen(lib::post('store_whatsapp')) > 15) { $this->errorsArray[] = 'Please provide a valid whatsapp phone number below.'; }
			if(!preg_match('/^[0-9\s+]+$/',lib::post('store_whatsapp'))) { $this->errorsArray[] = 'Please provide a valid whatsapp phone number below.'; }
		}

		
		//Twitter URL
		if(lib::post('store_twitter')) {
			if(strlen(lib::post('store_twitter')) > 100) { $this->errorsArray[] = 'Please provide a valid twitter url below.'; }
			if(!strstr(lib::post('store_twitter'), 'twitter.com')) { $this->errorsArray[] = 'Please provide a valid twitter url below.'; }
		}
		
		//Facebook URL
		if(lib::post('store_facebook')) {
			if(strlen(lib::post('store_facebook')) > 100) { $this->errorsArray[] = 'Please provide a valid facebook url below.'; }
			if(!strstr(lib::post('store_facebook'), 'facebook.com')) { $this->errorsArray[] = 'Please provide a valid facebook url below.'; }
		}
		
		//Google URL
		if(lib::post('store_google')) {
			if(strlen(lib::post('store_google')) > 100) { $this->errorsArray[] = 'Please provide a valid google url below.'; }
			if(!strstr(lib::post('store_google'), 'google.com')) { $this->errorsArray[] = 'Please provide a valid google url below.'; }
		}
		
		//Payment Method
		if(!lib::post('store_paymentmethod')) { $this->errorsArray[] = 'Please provide a payment method below so we can pay you.'; }
		if(strlen(lib::post('store_paymenthod')) > 1000) { $this->errorsArray[] = 'Please provide a valid payment method below.'; }
		
		//Payment Method
		if(lib::post('store_echocash')) { 
			if(strlen(lib::post('store_echocash')) > 1000) { $this->errorsArray[] = 'Please provide a valid echo cash payment method below.'; }
		}
		
		//Session Check
		if(isset($_SESSION[config::$db_prefix.'store'])) {
			if(!is_array($_SESSION[config::$db_prefix.'store'])) {
				$this->errorsArray[] = 'Something unexpected happened, please refresh the page.';	
			}
		} else {
			$this->errorsArray[] = 'Something unexpected happened, please refresh the page.';		
		}
		
		//Do we have any issues?
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			/*******************************************************************/
			// *** REMOVE ANY EXISTING STORE DATA ***
			/*******************************************************************/
			
			/*******************************************************************/
			// *** REMOVE ANY EXISTING STORE DATA ***
			/*******************************************************************/
			
			//Load Session
			$this->store = $_SESSION[config::$db_prefix.'store'];
			
			//Append
			$this->store['store_username'] = lib::post('store_username');
			$this->store['store_title'] = lib::post('store_title');
			$this->store['store_description'] = lib::post('store_description');
			$this->store['store_keywords'] = lib::post('store_keywords');
			$this->store['store_aboutus'] = lib::post('store_aboutus');
			$this->store['store_email'] = lib::post('store_email');
			$this->store['store_address'] = lib::post('store_address');
			$this->store['store_phone'] = lib::post('store_phone');
			$this->store['store_phone1'] = lib::post('store_phone1');
			$this->store['store_phone2'] = lib::post('store_phone2');
			$this->store['store_whatsapp'] = lib::post('store_whatsapp');
			$this->store['store_twitter'] = lib::post('store_twitter');
			$this->store['store_facebook'] = lib::post('store_facebook');
			$this->store['store_google'] = lib::post('store_google');
			$this->store['store_paymentmethod'] = lib::post('store_paymentmethod');
			$this->store['store_echocash'] = lib::post('store_echocash');
			
			//Append to Session
			$_SESSION[config::$db_prefix.'store'] = $this->store;
			
			//Success
			return json_encode(array('success' => 1));
		}
		
	}	
	
}