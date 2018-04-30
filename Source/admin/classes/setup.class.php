<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Creative Miles
 *@Start: 12th June 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class setup {
	
	//Card Settings
	public function priceSettings() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Check Adpacks
		$advertPackageSQL = db::query("SELECT * FROM `".config::$db_prefix."adpacks`");
		while($advertPackageData = db::fetch($advertPackageSQL)) {
			if(!lib::post('ad_'.$advertPackageData['pack_id'])) { $this->errorsArray[] = 'Please enter a price for the '.$advertPackageData['pack_title']; }
			if(!is_numeric(lib::post('ad_'.$advertPackageData['pack_id']))) { $this->errorsArray[] = 'Please enter a numeric value for '.$advertPackageData['pack_title']; }
		}
		
		//Check Stores
		$storePackageSQL = db::query("SELECT * FROM `".config::$db_prefix."stpacks`");
		while($storePackageData = db::fetch($storePackageSQL)) {
			if(!lib::post('st_'.$storePackageData['pack_id'])) { $this->errorsArray[] = 'Please enter a price for the '.$storePackageData['pack_title']; }
			if(!is_numeric(lib::post('st_'.$storePackageData['pack_id']))) { $this->errorsArray[] = 'Please enter a numeric value for '.$storePackageData['pack_title']; }
		}
				
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
						
			//Update Adpacks
			$advertPackageSQL = db::query("SELECT * FROM `".config::$db_prefix."adpacks`");
			while($advertPackageData = db::fetch($advertPackageSQL)) {
				db::query("UPDATE `".config::$db_prefix."adpacks` SET `pack_price`='".lib::post('ad_'.$advertPackageData['pack_id'],true)."' WHERE `pack_id`='".$advertPackageData['pack_id']."'");
			}
			
			//Update Stores
			$storePackageSQL = db::query("SELECT * FROM `".config::$db_prefix."stpacks`");
			while($storePackageData = db::fetch($storePackageSQL)) {
				db::query("UPDATE `".config::$db_prefix."stpacks` SET `pack_price`='".lib::post('st_'.$storePackageData['pack_id'],true)."' WHERE `pack_id`='".$storePackageData['pack_id']."'");
			}
			
			//Return Success
			return json_encode(array('success' => 1));
			
		}	
	}
	
	//Card Settings
	public function cardSettings() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Validate Settings
		if(lib::post('Card_AllowUse') == '') { $this->errorsArray[] = 'Please select a valid value to use below.'; }
		if(lib::post('Card_AllowStorage') == '') { $this->errorsArray[] = 'Please select a valid value to use below.'; }
		if(!in_array(lib::post('Card_AllowUse'),array(0,1))) { $this->errorsArray[] = 'Please select a valid value to use below.'; }
		if(!in_array(lib::post('Card_AllowStorage'),array(0,1))) { $this->errorsArray[] = 'Please select a valid value to use below.'; }
		
		//Validate Gateway
		if(lib::post('Card_AllowUse')) { 
			if(lib::post('Card_Gateway') == '') { 
				$this->errorsArray[] = 'Please select a valid gateway below before enabling Credit/Debit Card support.';
			}
			if(lib::post('Card_Gateway')) {
				if(db::nRows("SELECT `plugin_id`,`plugin_credit` FROM `".config::$db_prefix."plugins` WHERE `plugin_id`='".lib::post('Card_Gateway',true)."' AND `plugin_type`='3'") < 1) {
					$this->errorsArray[] = 'Please select a valid credit/debit card gateway.';	
				}
			}
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			
			//If a gateway is choosen.
			if(lib::post('Card_Gateway')) {
				 db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Card_Gateway',true)."' WHERE `setting`='Card_Gateway'"); 
			}
			
			//Update Settings
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Card_AllowUse',true)."' WHERE `setting`='Card_AllowUse'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Card_AllowStorage',true)."' WHERE `setting`='Card_AllowStorage'");
			
			//Return Success
			return json_encode(array('success' => 1));
		}
		
	}
	
	//Invoice Settings
	public function InvoicesSettings() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Invoice Starting Number
		if(!lib::post('Invoices_StartNumber')) { $this->errorsArray[] = 'Please enter an Invoice starting number below.'; }
		if(!preg_match('/^[0-9]{0,64}$/', lib::post('Invoices_StartNumber'))) { $this->errorsArray[] = 'Please enter a valid Invoice Starting Number.'; }
		//Check Num Rows - Last Increment
		
		//Invoice Number Increment
		if(!lib::post('Invoices_Increment')) { $this->errorsArray[] = 'Please enter an invoice increment number below.'; }
		if(!preg_match('/^[0-9]{0,10}$/', lib::post('Invoices_Increment'))) { $this->errorsArray[] = 'Please enter a valid Invoice Increment Number.'; }
		
		//Invoice PDF Font
		if(!in_array(lib::post('Invoices_PDFFont'), array('Arial', 'Courier','Tahoma', 'Times New Roman'))) {
			$this->errorsArray[] = 'Please select a valid font for Invoice PDF below.';	
		}
		
		//Generate PDF Invoices?
		if(lib::post('Invoices_GeneratePDF') == '') { 
			$this->errorsArray[] = 'Please select a valid value for Generate PDF Invoices below.';
		}
		
		//Invoice Creation Notification
		if(db::nRows("SELECT `".config::$db_prefix."email_templates` WHERE `template_id`='".lib::post('Invoices_CreationNotification',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid email template for "Invoice Creation Notification" below.';
		}	
		
		//Invoice Unpaid Notification
		if(db::nRows("SELECT `".config::$db_prefix."email_templates` WHERE `template_id`='".lib::post('Invoices_UnpaidNotification',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid email template for "Unpaid Invoice Notification" below.';
		}
		
		//Invoice Overdue Warning 1
		if(db::nRows("SELECT `".config::$db_prefix."email_templates` WHERE `template_id`='".lib::post('Invoices_OverdueWarning1',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid email template for "Overdue Invoice Warning 1" below.';
		}
		
		//Invoice Overdue Warning 2
		if(db::nRows("SELECT `".config::$db_prefix."email_templates` WHERE `template_id`='".lib::post('Invoices_OverdueWarning2',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid email template for "Overdue Invoice Warning 2" below.';
		}
		
		//Invoice Overdue Warning 3
		if(db::nRows("SELECT `".config::$db_prefix."email_templates` WHERE `template_id`='".lib::post('Invoices_OverdueWarning3',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid email template for "Overdue Invoice Warning 3" below.';
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			
			//Update Settings
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Invoices_StartNumber',true)."' WHERE `setting`='Invoices_StartNumber'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Invoices_Increment',true)."' WHERE `setting`='Invoices_Increment'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Invoices_PDFFont',true)."' WHERE `setting`='Invoices_PDFFont'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Invoices_NumberFormat',true)."' WHERE `setting`='Invoices_NumberFormat'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Invoices_GeneratePDF',true)."' WHERE `setting`='Invoices_GeneratePDF'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Invoices_CreatedNotification',true)."' WHERE `setting`='Invoices_CreatedNotification'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Invoices_UnpaidNotification',true)."' WHERE `setting`='Invoices_UnpaidNotification'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Invoices_OverdueWarning1',true)."' WHERE `setting`='Invoices_OverdueWarning1'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Invoices_OverdueWarning2',true)."' WHERE `setting`='Invoices_OverdueWarning2'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Invoices_OverdueWarning3',true)."' WHERE `setting`='Invoices_OverdueWarning3'");
			
			//Return Success
			return json_encode(array('success' => 1));
		}
	}
		
	//Security Questions
	public function securityQuestions() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//If we are removing a question
		if(lib::post('sq_option')) {
			//Does the question ID exist?
			if(db::nRows("SELECT * FROM `".config::$db_prefix."questions` WHERE `question_id`='".lib::post('sq_id',true)."'") < 1) {
				$this->errorsArray[] = 'That security question does not exist, try again?';	
			}
		} else {
			//Validate Question
			if(strlen(lib::post('sq_text')) > 100) { $this->errorsArray[] = 'Sorry, your security question must be less than 100 characters long.';	}
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];
		} else {
			if(lib::post('sq_option')) {
				//Log Action
				logs::logAction(1,'The user '.session::data('user_username').' deleted a security question from setup.','admin');
				db::query("DELETE FROM `".config::$db_prefix."questions` WHERE `question_id`='".lib::post('sq_id',true)."'");
			} else {
				//Log Action
				logs::logAction(1,'The user '.session::data('user_username').' added a security question from setup.','admin');
				db::query("INSERT INTO `".config::$db_prefix."questions` (`question_value`) VALUES ('".lib::post('sq_text',true)."')");
			}
		}
		
	}
	
	//API WhiteList
	public function APIWhiteList() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have an IP?
		if(!lib::post('ip_address')) { $this->errorsArray[] = 'Please enter a valid IP Address below for "IP Ban Whitelist"'; }
		if(!filter_var(lib::post('ip_address'), FILTER_VALIDATE_IP)) { $this->errorsArray[] = 'Please enter a valid IP Address below for "API Whitelist"'; }
		
		//If we are removing an IP Address
		if(lib::post('ip_option')) {
			//Does the IP Address Exist?
			if(db::nRows("SELECT `ip_address` FROM `".config::$db_prefix."api_whitelist` WHERE `ip_address`='".lib::post('ip_address',true)."'") < 1) { 
				$this->errorsArray[] = 'Please select a valid IP Address to remove.'; 
			}
		} else {
			if(db::nRows("SELECT * FROM `".config::$db_prefix."api_whitelist` WHERE `ip_address`='".lib::post('ip_address',true)."'") > 0) { 
				$this->errorsArray[] = 'Sorry, that IP Address already exists!'; 
			}	
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];
		} else {
			if(lib::post('ip_option')) {
				//Log Action
				logs::logAction(1,'The user '.session::data('user_username').' deleted the IP '.lib::post('ip_address',true).' from the API White List','admin');
				db::query("DELETE FROM `".config::$db_prefix."api_whitelist` WHERE `ip_address`='".lib::post('ip_address',true)."'");
			} else {
				//Log Action
				logs::logAction(1,'The user '.session::data('user_username').' added the IP '.lib::post('ip_address',true).' to the API White List','admin');
				db::query("INSERT INTO `".config::$db_prefix."api_whitelist` (`ip_address`) VALUES ('".lib::post('ip_address',true)."')");
			}
		}
		
	}
	
	//IP Ban WhiteList
	public function IPBanWhiteList() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have an IP?
		if(!lib::post('ip_address')) { $this->errorsArray[] = 'Please enter a valid IP Address below for "IP Ban Whitelist"'; }
		if(!filter_var(lib::post('ip_address'), FILTER_VALIDATE_IP)) { $this->errorsArray[] = 'Please enter a valid IP Address below for "IP Ban Whitelist"'; }
		
		//If we are removing an IP Address
		if(lib::post('ip_option')) {
			//Does the IP Address Exist?
			if(db::nRows("SELECT `ip_address` FROM `".config::$db_prefix."ipban_whitelist` WHERE `ip_address`='".lib::post('ip_address',true)."'") < 1) { 
				$this->errorsArray[] = 'Please select a valid IP Address to remove.'; 
			}
		} else {
			if(db::nRows("SELECT * FROM `".config::$db_prefix."ipban_whitelist` WHERE `ip_address`='".lib::post('ip_address',true)."'") > 0) { 
				$this->errorsArray[] = 'Sorry, that IP Address already exists!'; 
			}	
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];
		} else {
			if(lib::post('ip_option')) {
				//Log Action
				logs::logAction(1,'The user '.session::data('user_username').' deleted the IP '.lib::post('ip_address',true).' from the IP Ban White List','admin');
				db::query("DELETE FROM `".config::$db_prefix."ipban_whitelist` WHERE `ip_address`='".lib::post('ip_address',true)."'");
			} else {
				//Log Action
				logs::logAction(1,'The user '.session::data('user_username').' added the IP '.lib::post('ip_address',true).' to the IP Ban White List','admin');
				db::query("INSERT INTO `".config::$db_prefix."ipban_whitelist` (`ip_address`) VALUES ('".lib::post('ip_address',true)."')");
			}
		}
		
	}
	
	
	
	//Security Settings
	public function securitySettings() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Brute Force Attemps
		if(!lib::post('Security_AuthBruteForceAttempts')) { $this->errorsArray[] = 'Please enter a valid value for brute force attempts below.'; }
		if(!preg_match('/[0-9]+/',lib::post('Security_AuthBruteForceAttempts'))) { $this->errorsArray[] = 'Please enter a valid value for brute force attempts below.';  }
		if(!lib::post('Security_AuthBruteForceAttemptsReset')) { $this->errorsArray[] = 'Please enter a valid value for brute force attempts reset below.'; }
		if(!preg_match('/[0-9]+/',lib::post('Security_AuthBruteForceAttemptsReset'))) { $this->errorsArray[] = 'Please enter a valid value for brute force attempts reset below.';  }
		
		//Account Lockout
		if(!lib::post('Security_AuthLockAttempts')) { $this->errorsArray[] = 'Please enter a valid number for Account Lockout Attempts.'; }
		if(!preg_match('/[0-9]+/',lib::post('Security_AuthLockAttempts'))) { $this->errorsArray[] = 'Please enter a valid number for Account Lockout Attempts.'; }
		if(!lib::post('Security_AuthLockAttemptsReset')) { $this->errorsArray[] = 'Please enter a valid value for Account Lockout Attempts'; }
		if(!preg_match('/[0-9]+/',lib::post('Security_AuthLockAttemptsReset'))) { $this->errorsArray[] = 'Please enter a valid value for Account Lockout Attempts'; }
		
		//Fraud Protection
		if(!in_array(lib::post('Security_FraudProtection'), array(0,1))) { $this->errorsArray[] = 'Please select a valid value for Fraud Protection to continue.'; }
		
		//Email Activation
		if(!in_array(lib::post('Security_EmailActivation'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened for email activation.'; }
		
		//Multifactor Authentication
		if(!in_array(lib::post('Security_Multifactor'), array(0,1))) { $this->errorsArray[] = 'Please select a valid value for Multi-factor authentication below.'; }
		
		//Captcha Plugin
		if(lib::post('Security_CaptchaPlugin')) { 
			if(db::nRows("SELECT `plugin_id` FROM `".config::$db_prefix."plugins` WHERE `plugin_type`='5' AND `plugin_id`='".lib::post('Security_CaptchaPlugin',true)."'") < 1) {
				$this->errorsArray[] = 'Please select a valid captcha plugin to continue.';	
			}
		}
		
		//Block User Agents
		if(!in_array(lib::post('Security_BlockAgents'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with Block Blank UA'; }
		
		//Block Proxy
		if(!in_array(lib::post('Security_BlockProxy'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with Block Proxy.'; }
		
		//Bot Traps
		if(!in_array(lib::post('Security_BotTraps'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with Bot Traps'; }
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return json_encode(array('errors' => $this->errorsArray[0]));
		} else {
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' updated the security settings in setup.','admin');
			
			//Brute Force
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Security_AuthBruteForceAttempts',true)."' WHERE `setting`='Security_AuthBruteForceAttempts'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Security_AuthBruteForceAttemptsReset',true)."' WHERE `setting`='Security_AuthBruteForceAttemptsReset'");
			
			//Lockout
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Security_AuthLockAttempts',true)."' WHERE `setting`='Security_AuthLockAttempts'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Security_AuthLockAttemptsReset',true)."' WHERE `setting`='Security_AuthLockAttemptsReset'");
			
			//Fraud Protection
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Security_FraudProtection',true)."' WHERE `setting`='Security_FraudProtection'");
			
			//Email Activation			
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Security_EmailActivation',true)."' WHERE `setting`='Security_EmailActivation'");
			
			//Multifactor
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Security_Multifactor',true)."' WHERE `setting`='Security_Multifactor'");	
			
			//Captcha Plugin			
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Security_CaptchaPlugin',true)."' WHERE `setting`='Security_CaptchaPlugin'");		
			
			//Blocks
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Security_BlockAgents',true)."' WHERE `setting`='Security_BlockAgents'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Security_BotTraps',true)."' WHERE `setting`='Security_BotTraps'");
			
			//Return Success
			return json_encode(array('success' => 1));

		}
	}
	
	//Local Settings
	public function localSettings() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Date Format Validation
		$dateFormats = array('DD/MM/YYYY', 'DD.MM.YYYY', 'DD-MM-YYYY', 'MM/DD/YYYY', 'YYYY/MM/DD', 'YYYY-MM-DD');
		if(!in_array(lib::post('Local_DefaultDateFormat'),$dateFormats)) { $this->errorsArray[] = 'Please select a valid date format.'; }
		if(!in_array(lib::post('Local_ClientDateFormat'),$dateFormats)) { $this->errorsArray[] = 'Please select a valid client date format.'; }
		
		//Choose Language
		if(!in_array(lib::post('Local_ChooseLanguage'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with Choose Language...'; }
		
		//Default Country
		if(!array_key_exists(lib::post('Local_DefaultCountry'), lib::getCountries())) { $this->errorsArray[] = 'Please select a valid default country.'; }
		
		//Default Language
		if(!array_key_exists(lib::post('Local_DefaultLanguage'), lib::getLanguages())) { $this->errorsArray[] = 'Please select a valid default language.'; }
		
		//Default Timezone
		if(!array_key_exists(lib::post('Local_DefaultTimezone'), lib::getTimezones())) { $this->errorsArray[] = 'Please select a valid default timezone.';}
		
		//Default Currency
		if(!array_key_exists(lib::post('Local_DefaultCurrency'), lib::getCurrencies())) { $this->errorsArray[] = 'Please select a valid currency below.'; }
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' updated the local settings in setup.','admin');
			
			//Date Format
			$dateFormat = array('DD/MM/YYYY' => 'd/m/Y', 'DD.MM.YYYY' => 'd.m.Y', 'DD-MM-YYYY' => 'd-m-Y', 'MM/DD/YYYY' => 'm/d/Y', 'YYYY-MM-DD' => 'Y-m-d');
			
			//Update Settings													
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Local_DefaultDateFormat',true)."' WHERE `setting`='Local_DefaultDateFormat'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Local_ClientDateFormat',true)."' WHERE `setting`='Local_ClientDateFormat'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Local_ChooseLanguage',true)."' WHERE `setting`='Local_ChooseLanguage'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Local_DefaultCountry',true)."' WHERE `setting`='Local_DefaultCountry'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Local_DefaultLanguage',true)."' WHERE `setting`='Local_DefaultLanguage'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Local_DefaultTimezone',true)."' WHERE `setting`='Local_DefaultTimezone'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('Local_DefaultCurrency',true)."' WHERE `setting`='Local_DefaultCurrency'");
			
			//Return Success
			return json_encode(array('success' => 1));
			
		}
		
	}
	
	//General Settings
	public function generalSettings() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have a payout percentage?
		if(!lib::post('General_PayoutPercentage')) { $this->errorsArray[] = 'Please enter a valid payout percentage.'; }
		if(lib::post('General_PayoutPercentage') < 0) { $this->errorsArray[] = 'Please enter a higher payout percentage.';}
		if(lib::post('General_PayoutPercentage') > 1000) { $this->errorsArray[] = 'Your payout percentage must be less than 1000%'; }
		if(!is_numeric(lib::post('General_PayoutPercentage'))) { $this->errorsArray[] = 'Please enter a valid payout percentage.'; }
		
		/* 
		//Do we have a company name?
		if(!lib::post('General_CompanyName')) { $this->errorsArray[] = 'Please enter a company name, this is required'; }
		if(strlen(lib::post('General_CompanyName')) > 60) { $this->errorsArray[] = 'Your company name must be less than 60 characters long.'; }
		
		//Default Sender
		if(!lib::post('General_DefaultSender')) { $this->errorsArray[] = 'Please enter an email address for the default sender field.'; }
		if(strlen(lib::post('General_DefaultSender')) > 60) { $this->errorsArray[] = 'Your default sender must be less than 60 characters long.'; }	
		if(!filter_var(lib::post('General_DefaultSender'), FILTER_VALIDATE_EMAIL)) { $this->errorsArray[] = 'Please enter a valid email address for the default sender field.'; }
		
		//Template
		if(!lib::post('General_DefaultTemplate')) { $this->errorsArray[] = 'Please select a template for the client area.'; }
		$templates = scandir(ROOT.'/templates'); unset($templates[0]); unset($templates[1]);
		if(!in_array(lib::post('General_DefaultTemplate'), $templates)) { $this->errorsArray[] = 'Please select a template for the client area.'; }
		
		//Mantenance Mode
		if(lib::post('General_MaintenanceMode')) {
			if(!in_array(lib::post('General_MaintenanceMode'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with system maintenance...'; }
			if(strlen(lib::post('General_MaintenanceMode')) > 1) { $this->errorsArray[] = 'Something unexpected happened with system maintenance...'; }
		}
		if(!lib::post('General_MaintenanceMessage')) { $this->errorsArray[] = 'Please enter a maintenance message below to continue.'; }
		if(strlen(lib::post('General_MaintenanceMessage')) > 1000) { $this->errorsArray[] = 'Your maintenance message must be less than 1000 characters long.'; }
		
		//Logo URL
		if(!lib::post('General_LogoURL')) { $this->errorsArray[] = 'Please enter your logo URL below.'; }
		if(strlen(lib::post('General_LogoURL')) > 100) { $this->errorsArray[] = 'Your logo URL must be less than 100 characters long.'; }
		
		//Records Per Page
		if(!lib::post('General_RecordsLimit')) { $this->errorsArray[] = 'Please select how many records you would like to display per page.'; }
		if(!in_array(lib::post('General_RecordsLimit'), array(25,75,100,150,200))) { $this->errorsArray[] = 'Please select how many records you would like to display per page.'; }
		
		//Creative 	Billing URL
		if(!lib::post('General_SystemURL')) { $this->errorsArray[] = 'Please enter the URL to your Creative Billing Installation'; }
		if(strlen(lib::post('General_SystemURL')) > 255) { $this->errorsArray[] = 'Your Creative Billing Installation URL must be less than 255 characters long.'; }
		
		//Force SSL
		if(lib::post('General_SystemForceSSL') == '') { $this->errorsArray[] = 'Something unexpected happened with Force SSL?'; }
		if(!in_array(lib::post('General_SystemForceSSL'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with Force SSL?'; }
		
		//Force SSL
		if(lib::post('General_SystemMode') == '') { $this->errorsArray[] = 'Something unexpected happened with System Mode'; }
		if(!in_array(lib::post('General_SystemMode'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with System Mode'; }
		*/
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' updated the general settings in setup.','admin');
			
			//Update Settings																	
			//db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('General_CompanyName',true)."' WHERE `setting`='General_CompanyName'");
			//db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('General_DefaultSender',true)."' WHERE `setting`='General_DefaultSender'");
			//db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('General_DefaultTemplate',true)."' WHERE `setting`='General_DefaultTemplate'");
			//db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('General_MaintenanceMode',true)."' WHERE `setting`='General_MaintenanceMode'");
			//db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('General_MaintenanceMessage',true)."' WHERE `setting`='General_MaintenanceMessage'");
			//db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('General_LogoURL',true)."' WHERE `setting`='General_LogoURL'");
			//db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('General_RecordsLimit',true)."' WHERE `setting`='General_RecordsLimit'");
			//db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('General_SystemURL',true)."' WHERE `setting`='General_SystemURL'");
			//db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('General_SystemForceSSL',true)."' WHERE `setting`='General_SystemForceSSL'");
			//db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('General_SystemMode',true)."' WHERE `setting`='General_SystemMode'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('General_PayoutPercentage',true)."' WHERE `setting`='General_PayoutPercentage'");
			
			//Return
			return json_encode(array('success' => 1));
		}
		
	}
	
	
	
}