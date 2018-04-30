<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class domains {
	
	//@Edit TLD
	//Allows us to edit the TLD prices.
	public function editTLD() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does it exist?
		if(db::nRows("SELECT `tld_id` FROM `".config::$db_prefix."tlds` WHERE `tld_id`='".lib::post('tld_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid TLD to edit.';	
		}
		
		//Loop 10 Years
		for($i=1;$i<=10;$i++) {
		
			//Loop Currencies
			foreach(lib::getCurrencies() AS $currency_id => $currency_name) {
				
				//If the fields are enabled
				if(lib::post($i.'_'.$currency_id.'_enabled')) {
						
					//Validate Year
					if(!in_array(lib::post($i.'_'.$currency_id.'_year'), array(1,2,3,4,5,6,7,8,9,10))) { 
						$this->errorsArray[] = 'Please enter a valid register price below for '.lib::san($currency_name,false,true,true); 
					}
					
					//Validate Register
					if(!lib::post($i.'_'.$currency_id.'_price_register')) { $this->errorsArray[] = 'Please enter a valid register price below for '.lib::san($currency_name,false,true,true); }
					if(!preg_match('/^[0-9]+(?:\.[0-9]{2}){0,1}$/', lib::formatMoneyDB(lib::post($i.'_'.$currency_id.'_price_register')))) {
						$this->errorsArray[] = 'Please enter a valid value below for '.lib::san($currency_name,false,true,true).' register price.';
					}
					
					//Validate Renew
					if(!lib::post($i.'_'.$currency_id.'_price_renew')) { $this->errorsArray[] = 'Please enter a valid renew price below for '.lib::san($currency_name,false,true,true); }
					if(!preg_match('/^[0-9]+(?:\.[0-9]{2}){0,1}$/', lib::formatMoneyDB(lib::post($i.'_'.$currency_id.'_price_renew')))) {
						$this->errorsArray[] = 'Please enter a valid value below for '.lib::san($currency_name,false,true,true).' renew price.';
					}
					
					//Validate Transfer
					if(!lib::post($i.'_'.$currency_id.'_price_transfer')) { $this->errorsArray[] = 'Please enter a transfer valid price below for '.lib::san($currency_name,false,true,true); }
					if(!preg_match('/^[0-9]+(?:\.[0-9]{2}){0,1}$/', lib::formatMoneyDB(lib::post($i.'_'.$currency_id.'_price_transfer')))) {
						$this->errorsArray[] = 'Please enter a valid value below for '.lib::san($currency_name,false,true,true).' transfer price.';
					}
				}
			}
		
		}
		
		//Do we ave any issues
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' edited a TLD price. ('.lib::post('tld_id',true).')','admin');
				
			//Loop 10 Years
			for($i=1;$i<=10;$i++) {
			
				//Loop Currencies
				foreach(lib::getCurrencies() AS $currency_id => $currency_name) {
						
					//If the fields are enabled
					if(lib::post($i.'_'.$currency_id.'_enabled')) {
																								
						//Does the price list exist for this currency?
						if(db::nRows("SELECT * FROM `".config::$db_prefix."tlds_prices` WHERE (`tld_currencyid`='".db::mss($currency_id)."' AND 
																							   `tld_tldid`='".lib::post('tld_id',true)."' AND 
																							   `tld_year`='".lib::post($i.'_'.$currency_id.'_year',true)."')") > 0) {
							
							//Update
							db::query("UPDATE `".config::$db_prefix."tlds_prices` SET `tld_price_register`='".lib::formatMoneyDB(lib::post($i.'_'.$currency_id.'_price_register',true))."',
																					  `tld_price_renew`='".lib::formatMoneyDB(lib::post($i.'_'.$currency_id.'_price_renew',true))."',
																					  `tld_price_transfer`='".lib::formatMoneyDB(lib::post($i.'_'.$currency_id.'_price_transfer',true))."',
																					  `tld_enabled`='".lib::post($i.'_'.$currency_id.'_enabled',true)."'
																					  
																					  WHERE `tld_currencyid`='".db::mss($currency_id)."' 
																					  	AND `tld_tldid`='".lib::post('tld_id',true)."' 
																						AND `tld_year`='".lib::post($i.'_'.$currency_id.'_year',true)."'");
						} else {
							
							
							//Create
							db::query("INSERT INTO `".config::$db_prefix."tlds_prices` (`tld_price_register`,
																						`tld_price_renew`,
																						`tld_price_transfer`,
																						`tld_currencyid`,
																						`tld_tldid`,
																						`tld_year`,
																						`tld_enabled`
																						) 
																						
																						VALUES 
																						
																						(
																							'".lib::formatMoneyDB(lib::post($i.'_'.$currency_id.'_price_register',true))."',
																							'".lib::formatMoneyDB(lib::post($i.'_'.$currency_id.'_price_renew',true))."',
																							'".lib::formatMoneyDB(lib::post($i.'_'.$currency_id.'_price_transfer',true))."',
																							'".db::mss($currency_id)."',
																							'".lib::post('tld_id',true)."',
																							'".lib::post($i.'_'.$currency_id.'_year',true)."',
																							'".lib::post($i.'_'.$currency_id.'_enabled',true)."'
																						)");
						}
						
					}
					
				}
			
			}
			
		}
	}
	
	//@Update Addons
	//Allows us to update domain addon prices.
	public function updateAddons() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Loop Currencies
		foreach(lib::getCurrencies() AS $currency_id => $currency_name) {
			
			//DNS Price
			if(!preg_match('/^[0-9]+(?:\.[0-9]{2}){0,1}$/', lib::post($currency_id.'_dns_price'))) {
				$this->errorsArray[] = 'Please enter a valid price below for '.lib::san($currency_name,false,true,true).' DNS addon price.';
			}
			
			//Email Price
			if(!preg_match('/^[0-9]+(?:\.[0-9]{2}){0,1}$/', lib::post($currency_id.'_email_price'))) {
				$this->errorsArray[] = 'Please enter a valid price below for '.lib::san($currency_name,false,true,true).' Email addon price.';
			}
			
			//WHOIS Price
			if(!preg_match('/^[0-9]+(?:\.[0-9]{2}){0,1}$/', lib::post($currency_id.'_whois_price'))) {
				$this->errorsArray[] = 'Please enter a valid price below for '.lib::san($currency_name,false,true,true).' WHOIS addon price.';
			}
			
			//EPP Price
			if(!preg_match('/^[0-9]+(?:\.[0-9]{2}){0,1}$/', lib::post($currency_id.'_epp_price'))) {
				$this->errorsArray[] = 'Please enter a valid price below for '.lib::san($currency_name,false,true,true).' EPP addon price.';
			}
			
		}
		
		//Do we ave any issues
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' updated tld addons.','admin');
			
			//Loop Currencies
			foreach(lib::getCurrencies() AS $currency_id => $currency_name) {
				
				if(db::nRows("SELECT `addon_currencyid` FROM `".config::$db_prefix."tlds_addons` WHERE `addon_currencyid`='".db::mss($currency_id)."'") < 1) {
					
					db::query("INSERT INTO `".config::$db_prefix."tlds_addons` 
						(
						`addon_currencyid`,
						`addon_dns`,
						`addon_email`,
						`addon_whois`,
						`addon_epp`
						) 
						VALUES 
						(
						'".db::mss($currency_id)."',
						'".lib::post($currency_id.'_dns_price',true)."', 
						'".lib::post($currency_id.'_email_price',true)."', 
						'".lib::post($currency_id.'_whois_price',true)."',
						'".lib::post($currency_id.'_epp_price',true)."'
						)
					");
					
				} else {
					
					db::query("UPDATE `".config::$db_prefix."tlds_addons` SET 	`addon_dns`='".lib::post($currency_id.'_dns_price',true)."',
																				`addon_email`='".lib::post($currency_id.'_email_price',true)."',
																				`addon_whois`='".lib::post($currency_id.'_whois_price',true)."', 
																				`addon_epp`='".lib::post($currency_id.'_epp_price',true)."'
																				
																				WHERE `addon_currencyid`='".db::mss($currency_id)."'");
				}
			}
		}
			
	}
	
	//@Save TLD
	//Allows us to save a TLD
	public function saveTLD() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does it exist?
		if(db::nRows("SELECT `tld_id` FROM `".config::$db_prefix."tlds` WHERE `tld_id`='".lib::post('tld_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid TLD to save.';	
		}
		
		//Load TLD
		$this->tld = db::fetchQuery("SELECT `tld_id`,`tld_name` FROM `".config::$db_prefix."tlds` WHERE `tld_id`='".lib::post('tld_id',true)."'");
		
		//Domain TLD
		if(!lib::post('tld_name')) { $this->errorsArray[] = 'Please enter a valid domain name TLD below e.g. .com'; }
		if(strlen(lib::post('tld_name')) > 10) { $this->errorsArray[] = 'Please enter a valid domain name TLD below e.g. .com'; }
		if(!preg_match('/^\.[a-zA-Z.]+$/',lib::post('tld_name'))) { $this->errorsArray[] = 'Please enter a valid domain name TLD below e.g. .com'; }
		if($this->tld['tld_name'] != lib::post('tld_name',true)) {
			if(db::nRows("SELECT `tld_name` FROM `".config::$db_prefix."tlds` WHERE `tld_name`='".lib::post('tld_name',true)."'") > 0) {
				$this->errorsArray[] = 'A domain TLD already exists with that name.';	
			}
		}
		
		//DNS Management
		if(!in_array(lib::post('tld_dns'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with adding a tld. [E1]'; }		
		
		//Email Forwarding
		if(!in_array(lib::post('tld_email'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with adding a tld. [E2]'; }
		
		//WHOIS
		if(!in_array(lib::post('tld_whois'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with adding a tld. [E3]'; }
		
		//EPP Code
		if(!in_array(lib::post('tld_epp'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with adding a tld. [E4]'; }
		
		//Does the registrar exist?
		if(db::nRows("SELECT `plugin_id` FROM `".config::$db_prefix."plugins` WHERE `plugin_id`='".lib::post('tld_registrar',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid domain registrar.';
		}
		
		//Do we ave any issues
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' updated a TLD. ('.lib::post('tld_id',true).')','admin');
			
			db::query("UPDATE `".config::$db_prefix."tlds` SET 
			
			`tld_name`='".lib::post('tld_name',true)."',
			`tld_dns`='".lib::post('tld_dns',true)."',
			`tld_email`='".lib::post('tld_email',true)."',
			`tld_whois`='".lib::post('tld_whois',true)."',
			`tld_epp`='".lib::post('tld_epp',true)."',
			`tld_registrarid`='".lib::post('tld_registrar',true)."' WHERE `tld_id`='".lib::post('tld_id',true)."'");
			
		}
	}
	
	//@Delete TLD
	//Allows us to remove a TLD
	public function deleteTLD() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does it exist?
		if(db::nRows("SELECT `tld_id` FROM `".config::$db_prefix."tlds` WHERE `tld_id`='".lib::get('tld_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid TLD to delete.';	
		}
		
		//Do we ave any issues
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' delted a TLD. ('.lib::post('tld_id',true).')','admin');
			
			db::query("DELETE FROM `".config::$db_prefix."tlds` WHERE `tld_id`='".lib::get('tld_id',true)."'");
		}
	}
	
	//@Add TLD
	//Allows us to add a domain TLD
	public function addTLD() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Domain TLD
		if(!lib::post('tld_name')) { $this->errorsArray[] = 'Please enter a valid domain name TLD below e.g. .com'; }
		if(strlen(lib::post('tld_name')) > 10) { $this->errorsArray[] = 'Please enter a valid domain name TLD below e.g. .com'; }
		if(!preg_match('/^\.[a-zA-Z.]+$/',lib::post('tld_name'))) { $this->errorsArray[] = 'Please enter a valid domain name TLD below e.g. .com'; }
		if(db::nRows("SELECT `tld_name` FROM `".config::$db_prefix."tlds` WHERE `tld_name`='".lib::post('tld_name',true)."'") > 0) {
			$this->errorsArray[] = 'A domain TLD already exists with that name.';	
		}
		
		//DNS Management
		if(!in_array(lib::post('tld_dns'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with adding a tld. [E1]'; }		
		
		//Email Forwarding
		if(!in_array(lib::post('tld_email'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with adding a tld. [E2]'; }
		
		//WHOIS
		if(!in_array(lib::post('tld_whois'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with adding a tld. [E3]'; }
		
		//EPP Code
		if(!in_array(lib::post('tld_epp'), array(0,1))) { $this->errorsArray[] = 'Something unexpected happened with adding a tld. [E4]'; }
		
		//Does the registrar exist?
		if(db::nRows("SELECT `plugin_id` FROM `".config::$db_prefix."plugins` WHERE `plugin_id`='".lib::post('tld_registrar',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid domain registrar.';
		}
		
		//Do we ave any issues
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' added a TLD. ('.lib::post('tld_name',true).')','admin');
			
			//Create TLD
			db::query("INSERT INTO `".config::$db_prefix."tlds` 
																	(
																	`tld_name`,
																	`tld_dns`,
																	`tld_email`,
																	`tld_whois`,
																	`tld_epp`,
																	`tld_registrarid`
																	) 
																	
																	VALUES 
																	
																	(
																	'".lib::post('tld_name',true)."',
																	'".lib::post('tld_dns',true)."',
																	'".lib::post('tld_email',true)."',
																	'".lib::post('tld_whois',true)."',
																	'".lib::post('tld_epp',true)."',
																	'".lib::post('tld_registrar',true)."'
																	
																	)
																	");	
		}
			
	}
	
}