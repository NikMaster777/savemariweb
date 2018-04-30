<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class client {
	
	//@Client Group: Delete Group
	//Allows us to edit a client group
	public function deletegroup() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does it exist?
		if(db::nRows("SELECT `group_id` FROM `".config::$db_prefix."clients_groups` WHERE `group_id`='".lib::post('group_id',true)."'") < 1) {
			$this->errorsArray[] = 'The group you was trying to edit does not exist!';
		}
			
		//Do we have any errors?
		if(count($this->errorsArray)) {
			//Log Action
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];
		} else {
			db::query("DELETE FROM `".config::$db_prefix."clients_groups` WHERE `group_id`='".lib::post('group_id',true)."'");
		}
		
	}
	
	//@Client Group: Edit Group
	//Allows us to edit a client group
	public function editgroup() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have a group name?
		if(!lib::post('group_name',true)) { $this->errorsArray[] = 'Please enter a name for your group below.'; }
		if(strlen(lib::post('group_name',true)) > 100) { $this->errorsArry[] = 'You group name must be less than 100 characters long.'; }
		
		//Do we have a group description?
		if(!lib::post('group_description',true)) { $this->errorsArray[] = 'Please enter a description for your group below.'; }
		if(strlen(lib::post('group_description',true)) > 200) { $this->errorsArry[] = 'You group description must be less than 200 characters long.'; }
		
		//Do we have a html color?
		if(!lib::post('group_color')) { $this->errorsArray[] = 'Please select a color for this group.'; }
		if(!preg_match('/\#[a-z0-9]{6}/', lib::post('group_color'))) { $this->errorsArray[] = 'Please select a valid HTML color below.'; }
		
		if(db::nRows("SELECT `group_id` FROM `".config::$db_prefix."clients_groups` WHERE `group_id`='".lib::post('group_id',true)."'") < 1) {
			$this->errorsArray[] = 'The group you was trying to edit does not exist!';
		}
			
		//Do we have any errors?
		if(count($this->errorsArray)) {
			//Log Action
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];
		} else {
			db::query("UPDATE `".config::$db_prefix."clients_groups` SET `group_name`='".lib::post('group_name',true)."',`group_description`='".lib::post('group_description',true)."',`group_color`='".lib::post('group_color',true)."' WHERE `group_id`='".lib::post('group_id',true)."'");
		}
		
	}
	
	//@Client Group: Add Group
	//Allows us to add a client group
	public function addgroup() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have a group name?
		if(!lib::post('group_name',true)) { $this->errorsArray[] = 'Please enter a name for your group below.'; }
		if(strlen(lib::post('group_name',true)) > 100) { $this->errorsArry[] = 'You group name must be less than 100 characters long.'; }
		
		//Do we have a group description?
		if(!lib::post('group_description',true)) { $this->errorsArray[] = 'Please enter a description for your group below.'; }
		if(strlen(lib::post('group_description',true)) > 200) { $this->errorsArry[] = 'You group description must be less than 200 characters long.'; }
		
		//Do we have a html color?
		if(!lib::post('group_color')) { $this->errorsArray[] = 'Please select a color for this group.'; }
		if(!preg_match('/\#[a-z0-9]{6}/', lib::post('group_color'))) { $this->errorsArray[] = 'Please select a valid HTML color below.'; }
				
		//Do we have any errors?
		if(count($this->errorsArray)) {
			//Log Action
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];
		} else {
			db::query("INSERT INTO `".config::$db_prefix."clients_groups` (`group_name`,`group_description`,`group_color`) VALUES ('".lib::post('group_name',true)."','".lib::post('group_description',true)."','".lib::post('group_color',true)."')");
		}
		
			
	}
	
	
	//@Delete Client(s)
	public function delete() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Are we deleting all clients?
		if(isset($_POST) && is_array($_POST) && count($_POST) > 0) {
			
			//Lets get a list shall we.
			$this->user_ids = $_POST; 
			
			//Remove Delete Key
			unset($this->user_ids['_delete']);
						
			//Testing..
			foreach($this->user_ids as $this->user_id) {
				if(!is_numeric($this->user_id)) {
					$this->errorsArray[] = 'Somethig unexpected happened attempting to delete one or more clients.'. $this->user_id;	
				}
				if(db::nRows("SELECT `user_id` FROM `".config::$db_prefix."clients` WHERE `user_id`='".lib::san($this->user_id,true)."'") < 1) {
					$this->errorsArray[] = 'Somethig unexpected happened attempting to delete one or more clients.';	
				}
			}
						
		} else {
			$this->errorsArray[] = 'Please select some clients to delete.';	
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			//Log Action
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];
		} else {
			foreach($this->user_ids as $this->user_id) {
				logs::logAction(1,'The user '.session::data('user_username').' deleted a client. ('.$this->user_id.')','admin');
				db::query("DELETE FROM `".config::$db_prefix."clients` WHERE `user_id`='".lib::san($this->user_id,true)."'");	
			}
		}
		
	}
	
	//@Update
	public function update() {
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the account ID exist?
		if(db::nRows("SELECT `user_id` FROM `".config::$db_prefix."clients` WHERE `user_id`='".lib::post('user_id',true)."'") < 1) {
			$this->errorsArray[] = 'Sorry, something expected happened trying to update the selected user.';	
		}
				
		//Company Name
		if(lib::post('user_companyname')) { 
			if(strlen(lib::post('user_companyname')) > 80) {
				$this->errorsArray[] = 'Your company name must be less than 80 characters long.';	
			}
		}
		
		//Firstname
		if(!lib::post('user_firstname')) { $this->errorsArray[] = 'Please enter your client\'s first name below.'; }
		if(strlen(lib::post('user_firstname')) > 50) { $this->errorsArray[] = 'Your client\'s first name must be less than 50 characters long.'; }
		
		//Lastname
		if(!lib::post('user_lastname')) { $this->errorsArray[] = 'Please enter your client\'s last name below.'; }
		if(strlen(lib::post('user_lastname')) > 50) { $this->errorsArray[] = 'Your client\'s last name must be less than 50 characters long.'; }
		
		//Email Address
		if(!lib::post('user_emailaddress')) { $this->errorsArray[] = 'Please enter your client\'s email address below.'; }
		if(strlen(lib::post('user_emailaddress')) > 80) { $this->errorsArray[] = 'Your client\'s email address must be less than 80 characters long.'; }
		if(!filter_var(lib::post('user_emailaddress'), FILTER_VALIDATE_EMAIL)) { $this->errorsArray[] = 'Please enter a valid email address below.'; }
		
		//Load Account
		$this->account = db::fetchQuery("SELECT `user_emailaddress` FROM `".config::$db_prefix."clients` WHERE `user_id`='".lib::post('user_id',true)."'");
		
		if($this->account['user_emailaddress'] != lib::post('user_emailaddress',true)) {
			if(db::nRows("SELECT `user_emailaddress` FROM `".config::$db_prefix."clients` WHERE `user_emailaddress`='".lib::post('user_emailaddress',true)."'") > 0) {
				$this->errorsArray[] = 'An account with that email address already exists!';	
			}
		}
		
		//Phone Number
		if(lib::post('user_phonenumber')) {
			if(strlen(lib::post('user_phonenumber')) > 18) { $this->errorsArray[] = 'Your client\'s phone number must be less than 18 characters long.';}
		}
		
		//Password
		if(lib::post('user_password')) {
			if(strlen(lib::post('user_password')) > 80) { $this->errorsArray[] = 'The password must be less than 80 characters alone.'; }
			if(strlen(lib::post('user_password')) < 4) { $this->errorsArray[] = 'The password must be at least 4 characters long.'; }	
		}
		
		//Security Question
		if(lib::post('user_security_question')) {
			//Does the security question exist?
			if(db::nRows("SELECT `question_id` FROM `".config::$db_prefix."questions` WHERE `question_id`='".lib::post('user_security_question',true)."'") < 1) {
				$this->errorsArray[] = 'Please select a valid security question below.';	
			}
		}
		
		//Default Timezone
		if(!array_key_exists(lib::post('user_timezone'), lib::getTimezones())) { $this->errorsArray[] = 'Please select a valid default timezone.';}
		
		//Security Answer
		if(lib::post('user_security_answer')) {
			if(strlen(lib::post('user_security_answer')) > 100) {
				$this->errorsArray[] = 'Your security answer must be less than 100 characters long.';
			}
		}
		
		//Late Fees
		if(lib::post('user_latefees')) { 
			if(!in_array(lib::post('user_latefees'), array(0,1))) { 
				$this->errorsArray[] = 'Something unexpected happened for late fees.';
			}
		}
		
		//Overdue Emails
		if(lib::post('user_overdue')) { 
			if(!in_array(lib::post('user_overdue'), array(0,1))) { 
				$this->errorsArray[] = 'Something unexpected happened for overdue notices.';
			}
		}
		
		//Tax Exempt
		if(lib::post('user_tax')) { 
			if(!in_array(lib::post('user_tax'), array(0,1))) { 
				$this->errorsArray[] = 'Something unexpected happened for tax exempt.';
			}
		}
		
		//Automatic CC Process Disable
		if(lib::post('user_creditcard')) { 
			if(!in_array(lib::post('user_creditcard'), array(0,1))) { 
				$this->errorsArray[] = 'Something unexpected happened for automatic credit card processing.';
			}
		}
		
		//Disable Marketing
		if(lib::post('user_marketing')) { 
			if(!in_array(lib::post('user_marketing'), array(0,1))) { 
				$this->errorsArray[] = 'Something unexpected happened for user disable marketing.';
			}
		}
		
		//Address 1
		if(lib::post('user_address1')) { 
			if(strlen(lib::post('user_address1')) > 100) {
				$this->errorsArray[] = 'Your address 1 must be less than 100 characters long.';	
			}
		}
		
		//Address 2
		if(lib::post('user_address2')) { 
			if(strlen(lib::post('user_address2')) > 100) {
				$this->errorsArray[] = 'Your address 2 must be less than 100 characters long.';	
			}
		}
		
		//City
		if(lib::post('user_city')) { 
			if(strlen(lib::post('user_city')) > 100) {
				$this->errorsArray[] = 'Your city must be less than 100 characters long.';	
			}
		}
		
		//State/Region
		if(lib::post('user_state')) { 
			if(strlen(lib::post('user_state')) > 100) {
				$this->errorsArray[] = 'Your state must be less than 100 characters long.';	
			}
		}
		
		//Postcode
		if(lib::post('user_postcode')) {
			if(strlen(lib::post('user_postcode')) > 10) {
				$this->errorsArray[] = 'Your postcode must be less than 10 characters long.';	
			}
		}
		
		//Country Validation
		if(!array_key_exists(lib::post('user_country'), lib::getCountries())) { $this->errorsArray[] = 'Please select a valid default country.'; }
		
		//Payment Gateway
		if(lib::post('user_paymentmethod')) {
			if(!array_key_exists(lib::post('user_paymentmethod'), lib::getGateways())) { $this->errorsArray[] = 'Please select a valid default payment gateway.'; }
		}
		
		//Default Language
		if(!array_key_exists(lib::post('user_language'), lib::getLanguages())) { $this->errorsArray[] = 'Please select a valid default language.'; }
		
		//Account Status
		if(!lib::post('user_status')) {	$this->errorsArray[] = 'Please select a valid account status below.'; }
		if(!in_array(lib::post('user_status'), array(1,2,3))) { $this->errorsArray[] = 'Please select a valid account status below.'; }
		
		//Default Currency
		if(!array_key_exists(lib::post('user_currency'), lib::getCurrencies())) { $this->errorsArray[] = 'Please select a valid currency below.'; }
		
		//Admin Notes
		if(lib::post('user_adminnotes',true)) {
			if(strlen(lib::post('user_adminnotes',true)) > 15000) {
				$this->errorsArray[] = 'Your admin notes can not be more than 15000 characters long.';	
			}
		}
		
		//Do we have any problems?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' updated a client. ('.lib::post('user_emailaddress',true).')','admin');
			
			//Do good stuff.
			db::query("UPDATE `".config::$db_prefix."clients` SET   `user_firstname`='".lib::post('user_firstname',true)."',
																	`user_lastname`='".lib::post('user_lastname',true)."',
																	`user_emailaddress`='".lib::post('user_emailaddress',true)."',
																	`user_address1`='".lib::post('user_address1',true)."',
																	`user_address2`='".lib::post('user_address2',true)."', 
																	`user_city`='".lib::post('user_city',true)."',
																	`user_state`='".lib::post('user_state',true)."',
																	`user_postcode`='".lib::post('user_postcode',true)."',
																	`user_country`='".lib::post('user_country',true)."',
																	`user_phonenumber`='".lib::post('user_phonenumber',true)."',
																	`user_companyname`='".lib::post('user_companyname',true)."',
																	`user_paymentmethod`='".lib::post('user_paymentmethod',true)."',
																	`user_security_question`='".lib::post('user_security_question',true)."',
																	`user_security_answer`='".lib::post('user_security_answer',true)."',
																	`user_latefees`='".lib::post('user_latefees',true)."',
																	`user_overdue`='".lib::post('user_overdue',true)."',
																	`user_tax`='".lib::post('user_tax',true)."',
																	`user_creditcard`='".lib::post('user_creditcard',true)."',
																	`user_marketing`='".lib::post('user_marketing',true)."',
																	`user_language`='".lib::post('user_language',true)."',
																	`user_status`='".lib::post('user_status',true)."',
																	`user_currency`='".lib::post('user_currency',true)."',
																	`user_adminnotes`='".lib::post('user_adminnotes',true)."',
																	`user_timezone`='".lib::post('user_timezone',true)."'
																	
																	WHERE `user_id`='".lib::post('user_id',true)."'
																	");
																	
			//Update Password
			if(lib::post('user_password',true) != '') {	
				logs::logAction(1,'The user '.session::data('user_username').' changed the password of a client. ('.lib::post('user_emailaddress',true).')','admin');
				db::query("UPDATE `".config::$db_prefix."clients` SET `user_password`='".password_hash(lib::post('user_password',true), PASSWORD_DEFAULT)."' WHERE `user_id`='".lib::post('user_id',true)."'");												
			}
		}	
	}
	
	//@Add Client
	public function add() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Company Name
		if(lib::post('user_companyname')) { 
			if(strlen(lib::post('user_companyname')) > 80) {
				$this->errorsArray[] = 'Your company name must be less than 80 characters long.';	
			}
		}
		
		//Firstname
		if(!lib::post('user_firstname')) { $this->errorsArray[] = 'Please enter your client\'s first name below.'; }
		if(strlen(lib::post('user_firstname')) > 50) { $this->errorsArray[] = 'Your client\'s first name must be less than 50 characters long.'; }
		
		//Lastname
		if(!lib::post('user_lastname')) { $this->errorsArray[] = 'Please enter your client\'s last name below.'; }
		if(strlen(lib::post('user_lastname')) > 50) { $this->errorsArray[] = 'Your client\'s last name must be less than 50 characters long.'; }
		
		//Email Address
		if(!lib::post('user_emailaddress')) { $this->errorsArray[] = 'Please enter your client\'s email address below.'; }
		if(strlen(lib::post('user_emailaddress')) > 80) { $this->errorsArray[] = 'Your client\'s email address must be less than 80 characters long.'; }
		if(!filter_var(lib::post('user_emailaddress'), FILTER_VALIDATE_EMAIL)) { $this->errorsArray[] = 'Please enter a valid email address below.'; }
		if(db::nRows("SELECT `user_emailaddress` FROM `".config::$db_prefix."clients` WHERE `user_emailaddress`='".lib::post('user_emailaddress')."'") > 0) {
			$this->errorsArray[] = 'An account with that email address already exists!';	
		}
		
		//Phone Number
		if(lib::post('user_phonenumber')) {
			if(strlen(lib::post('user_phonenumber')) > 18) { $this->errorsArray[] = 'Your client\'s phone number must be less than 18 characters long.';}
		}
		
		//Password
		if(lib::post('user_password')) {
			if(strlen(lib::post('user_password')) > 80) { $this->errorsArray[] = 'The password must be less than 80 characters alone.'; }	
		}
		
		//Security Question
		if(lib::post('user_securityquestion')) {
			//Does the security question exist?
			if(db::nRows("SELECT `question_id` FROM `".config::$db_prefix."questions` WHERE `question_id`=''") < 1) {
				$this->errorsArray[] = 'Please select a valid security question below.';	
			}
		}
		
		//Default Timezone
		if(!array_key_exists(lib::post('user_timezone'), lib::getTimezones())) { $this->errorsArray[] = 'Please select a valid default timezone.';}
		
		//Security Answer
		if(lib::post('user_securityquestion')) {
			if(strlen(lib::post('user_securityanswer')) > 100) {
				$this->errorsArray[] = 'Your security answer must be less than 100 characters long.';
			}
		}
		
		//Late Fees
		if(lib::post('user_latefees')) { 
			if(!in_array(lib::post('user_latefees'), array(0,1))) { 
				$this->errorsArray[] = 'Something unexpected happened for late fees.';
			}
		}
		
		//Overdue Emails
		if(lib::post('user_overdue')) { 
			if(!in_array(lib::post('user_overdue'), array(0,1))) { 
				$this->errorsArray[] = 'Something unexpected happened for overdue notices.';
			}
		}
		
		//Tax Exempt
		if(lib::post('user_tax')) { 
			if(!in_array(lib::post('user_tax'), array(0,1))) { 
				$this->errorsArray[] = 'Something unexpected happened for tax exempt.';
			}
		}
		
		//Automatic CC Process Disable
		if(lib::post('user_creditcard')) { 
			if(!in_array(lib::post('user_creditcard'), array(0,1))) { 
				$this->errorsArray[] = 'Something unexpected happened for automatic credit card processing.';
			}
		}
		
		//Disable Marketing
		if(lib::post('user_marketing')) { 
			if(!in_array(lib::post('user_marketing'), array(0,1))) { 
				$this->errorsArray[] = 'Something unexpected happened for user disable marketing.';
			}
		}
		
		//Address 1
		if(lib::post('user_address1')) { 
			if(strlen(lib::post('user_address1')) > 100) {
				$this->errorsArray[] = 'Your address 1 must be less than 100 characters long.';	
			}
		}
		
		//Address 2
		if(lib::post('user_address2')) { 
			if(strlen(lib::post('user_address2')) > 100) {
				$this->errorsArray[] = 'Your address 2 must be less than 100 characters long.';	
			}
		}
		
		//City
		if(lib::post('user_city')) { 
			if(strlen(lib::post('user_city')) > 100) {
				$this->errorsArray[] = 'Your city must be less than 100 characters long.';	
			}
		}
		
		//State/Region
		if(lib::post('user_state')) { 
			if(strlen(lib::post('user_state')) > 100) {
				$this->errorsArray[] = 'Your state must be less than 100 characters long.';	
			}
		}
		
		//Postcode
		if(lib::post('user_postcode')) {
			if(strlen(lib::post('user_postcode')) > 10) {
				$this->errorsArray[] = 'Your postcode must be less than 10 characters long.';	
			}
		}
		
		//Country Validation
		if(!array_key_exists(lib::post('user_country'), lib::getCountries())) { $this->errorsArray[] = 'Please select a valid default country.'; }
		
		//Payment Gateway
		if(lib::post('user_paymentmethod')) {
			if(!array_key_exists(lib::post('user_paymentmethod'), lib::getGateways())) { $this->errorsArray[] = 'Please select a valid default payment gateway.'; }
		}
		
		//Default Language
		if(!array_key_exists(lib::post('user_language'), lib::getLanguages())) { $this->errorsArray[] = 'Please select a valid default language.'; }
		
		//Account Status
		if(!lib::post('user_status')) {	$this->errorsArray[] = 'Please select a valid account status below.'; }
		if(!in_array(lib::post('user_status'), array(1,2,3))) { $this->errorsArray[] = 'Please select a valid account status below.'; }
		
		//Default Currency
		if(!array_key_exists(lib::post('user_currency'), lib::getCurrencies())) { $this->errorsArray[] = 'Please select a valid currency below.'; }
		
		//Admin Notes
		if(lib::post('user_adminnotes',true)) {
			if(strlen(lib::post('user_adminnotes',true)) > 15000) {
				$this->errorsArray[] = 'Your admin notes can not be more than 15000 characters long.';	
			}
		}
		
		//Do we have any problems?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			
			//Log Actions
			logs::logAction(1,'The user '.session::data('user_username').' added a client. ('.lib::post('user_emailaddress',true).')','admin');
			
			//Do good stuff.
			db::query("INSERT INTO `".config::$db_prefix."clients` (
																	`user_firstname`,
																	`user_lastname`,
																	`user_emailaddress`,
																	`user_address1`,
																	`user_address2`, 
																	`user_city`,
																	`user_state`,
																	`user_postcode`,
																	`user_country`,
																	`user_phonenumber`,
																	`user_companyname`,
																	`user_password`,
																	`user_paymentmethod`,
																	`user_security_question`,
																	`user_security_answer`,
																	`user_latefees`,
																	`user_overdue`,
																	`user_tax`,
																	`user_creditcard`,
																	`user_marketing`,
																	`user_language`,
																	`user_status`,
																	`user_currency`,
																	`user_adminnotes`,
																	`user_created`,
																	`user_ipaddress`,
																	`user_timezone`
																	)
																	
																	VALUES
																	
																	(
																	'".lib::post('user_firstname',true)."',
																	'".lib::post('user_lastname',true)."',
																	'".lib::post('user_emailaddress',true)."',
																	'".lib::post('user_address1',true)."',
																	'".lib::post('user_address2',true)."', 
																	'".lib::post('user_city',true)."',
																	'".lib::post('user_state',true)."',
																	'".lib::post('user_postcode',true)."',
																	'".lib::post('user_country',true)."',
																	'".lib::post('user_phonenumber',true)."',
																	'".lib::post('user_companyname',true)."',
																	'".password_hash(lib::post('user_password',true), PASSWORD_DEFAULT)."',
																	'".lib::post('user_paymentmethod',true)."',
																	'".lib::post('user_security_question',true)."',
																	'".lib::post('user_security_answer',true)."',
																	'".lib::post('user_latefees',true)."',
																	'".lib::post('user_overdue',true)."',
																	'".lib::post('user_tax',true)."',
																	'".lib::post('user_creditcard',true)."',
																	'".lib::post('user_marketing',true)."',
																	'".lib::post('user_language',true)."',
																	'".lib::post('user_status',true)."',
																	'".lib::post('user_currency',true)."',
																	'".lib::post('user_adminnotes',true)."',
																	'".date('Y-m-d')."',
																	'',
																	'".lib::post('user_timezone',true)."'
																	)
																	
																	
																	",true);	
		}
		
	}
	
}