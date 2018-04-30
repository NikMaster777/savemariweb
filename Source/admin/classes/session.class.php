<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class session {
	
	//@Declared
	public static $private_key;
	public static $public_key;
	public static $global_key;
	public static $errorsArray;
	public static $user;
	
	public static $botFields;
	public static $botFieldCount;
	public static $fieldName;
	public static $fieldValue;
	public static $botFieldsOutput;
	public static $botFieldArray;
	
	//@Bot Trap: Validation
	public static function validateBotTrap() {
				
		//Do we have bot traps enabled?
		if(lib::getSetting('Security_BotTraps')) {
			
			//A place to store errors
			self::$errorsArray = array();
			
			//Start Validation
			if(isset($_SESSION[config::$session_prefix.'botfields']) && count($_SESSION[config::$session_prefix.'botfields']) > 0) {
				self::$botFields = $_SESSION[config::$session_prefix.'botfields'];
				foreach(self::$botFields AS self::$botFieldArray) {					
					if(!self::$botFieldArray['field']) {
						self::$errorsArray[] = 'We are missing part of the array, what happened?';	
					}
					if(lib::post(self::$botFieldArray['name']) != @self::$botFieldArray['expected']) {
						self::$errorsArray[] = 'It looks like you did not pass the bot inspection. You shall not pass. '.self::$botFieldArray['field'];	
					}
				}
			} else {
				self::$errorsArray[] = 'Where is the bot session, who took it?';	
			}
												
			//Do we have any errors?
			if(count(self::$errorsArray)) {
				return false;
			} else {
				return true;	
			}
		
		}
	}
	
	//@Bot Traps: Set the trap
	//The following will generate a random array of fields to trick bots.
	public static function setBotTrap() {
		
		//Do we have bot traps enabled?
		if(lib::getSetting('Security_BotTraps')) {
					
			//Lets make some fields...
			self::$botFields = array();
			
			//How many fields are we building
			self::$botFieldCount = rand(4,10);
			
			//Generate Fields
			for($i=1;$i<self::$botFieldCount;$i++) {
				
				//Generate Field Name
				self::$fieldName = substr(sha1($i),0,rand(4,7));
				
				//Randomize the field contents..
				if(rand(0,3) != 1) {
					self::$fieldValue = '';
				} else {
					self::$fieldValue = substr(sha1(rand(0,100)),0,10);	
				}
				
				//Add field to Array
				self::$botFields[] = array('field' => '<input type="hidden" name="'.self::$fieldName.'" value="'.self::$fieldValue.'"/>', 
										   'expected' => self::$fieldValue, 
										   'name' => self::$fieldName);
			}
				
			//Set Fields
			$_SESSION[config::$session_prefix.'botfields'] = array();
			$_SESSION[config::$session_prefix.'botfields'] = self::$botFields;
								
			//Return Output
			self::$botFieldsOutput = '<!-- BOT TRAPS -->';
			foreach(self::$botFields AS self::$botFieldArray) { 
				self::$botFieldsOutput .= self::$botFieldArray['field']; 
			}
			
			//Return!
			return self::$botFieldsOutput;
		
		}
	}
	
	//@Session Data
	public static function data($key, $mss = false, $strip = false, $html = false) {
		if(isset(self::$user[$key]) && self::$user[$key] != '') {
			return lib::san(self::$user[$key], $mss, $strip, $html);
		} else {
			self::$user = db::fetchQuery("SELECT * FROM `".config::$db_prefix."staff` WHERE `user_username`='".db::mss(substr(@$_SESSION[config::$session_prefix.'username'],0,255))."'");
			return lib::san(self::$user[$key], $mss, $strip, $html);	
		}
	}
		
	//@Session Active
	//Do we have an active session?
	public static function active() {
		
		//@Errors Array
		//A place to store errors
		self::$errorsArray = array();
		
		//@Check USER_ID
		if(isset($_SESSION[config::$session_prefix.'username'])) {
			if($_SESSION[config::$session_prefix.'username'] == '') {
				self::$errorsArray[] = '[E1] User username is empty!';
			} else {
				if(db::nRows("SELECT `user_username` FROM `".config::$db_prefix."staff` WHERE `user_username`='".db::mss(substr(@$_SESSION[config::$session_prefix.'username'],0,255))."'") < 1) {
					self::$errorsArray[] = '[E2] User username does not exist!';	
				}
			}
		} else {
			self::$errorsArray[] = '[E3] User username session does not exist!';
		}
		
		//@Check USER_PUBLIC
		if(isset($_SESSION[config::$session_prefix.'public'])) {
			if($_SESSION[config::$session_prefix.'public'] == '') {
				self::$errorsArray[] = '[E4] User public key is empty!';
			} else {
				if(db::nRows("SELECT `user_username`,`user_session` FROM `".config::$db_prefix."staff` WHERE 
				(`user_username`='".db::mss(substr(@$_SESSION[config::$session_prefix.'username'],0,255))."' 
				AND `user_session`='".sha1(sha1(config::$session_salt).db::mss(substr(@$_SESSION[config::$session_prefix.'public'],0,255)))."')") < 1) {
					self::$errorsArray[] = '[E5] User public key does not exist!';	
				}	
			}
		} else {
			self::$errorsArray[] = '[E6] User public key session does not exist!';
		}
				
		//Do we have any errors?
		if(count(self::$errorsArray) > 0) {
			return false;
		}else {
			return true;
		}
			
	}
	
	//@Create Session
	//Are we creating a new session
	public static function create($user_username) {
		
		//Create Public, Private and Global Key
		self::$public_key  = sha1($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time());
		self::$private_key = sha1(config::$session_salt);
		self::$global_key = sha1(self::$private_key.self::$public_key);
		
		//Store Global Key
		db::query("UPDATE `".config::$db_prefix."staff` SET `user_session`='".self::$global_key."',`user_ipaddress`='".db::mss($_SERVER['REMOTE_ADDR'])."',`user_login_timestamp`='".time()."' WHERE `user_username`='".db::mss($user_username)."'");
		
		//Create PHP Session
		$_SESSION[config::$session_prefix.'username'] = $user_username;
		$_SESSION[config::$session_prefix.'public'] = self::$public_key;
		
		//Resets Brute Force
		unset($_SESSION[config::$session_prefix.'brute']); 
						
	}
	
	//@Kill Session
	//Are we killing a new session
	public static function kill() {
		logs::logAction(0,'The user '.session::data('user_username').' has logged out.','admin');
		@session_destroy();	
	}
	
}