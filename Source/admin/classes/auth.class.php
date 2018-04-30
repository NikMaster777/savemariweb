<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class auth {
	
	//@Account Lock Reset
	//Resets the account lock after X minutes.
	public function accountLockReset($userid=0) {
				
		//Does the user ID exist, and is it locked?
		if(db::nRows("SELECT `user_id` FROM `".config::$db_prefix."staff` WHERE `user_id`='".db::mss($userid)."' AND `user_lock`='1'") > 0) {
							
			//Load Account
			$this->account = db::fetchQuery("SELECT `user_id`,`user_lock_timestamp` FROM `".config::$db_prefix."staff` WHERE `user_id`='".db::mss($userid)."'");
			
			//Timestamp
			$this->timestamp = time() - $this->account['user_lock_timestamp'];
			$this->timestamp = floor($this->timestamp/60);
			
			//If timestamp is more than X
			if($this->timestamp > lib::getSetting('Security_AuthLockAttemptsReset')) {
				//Log Action
				logs::logAction(0,'The user id '.$userid.' account lock has been removed.','admin');
				db::query("UPDATE `".config::$db_prefix."staff` SET `user_lock`='0',`user_lock_timestamp`='0' WHERE `user_id`='".db::mss($userid)."'");	
			}
			
		}
			
	}
	
	//Account Lockout
	//Locks account after X attempts
	public function accountLock($userid=0) {
			
		//Does the user ID exist?
		if(db::nRows("SELECT `user_id` FROM `".config::$db_prefix."staff` WHERE `user_id`='".db::mss($userid)."' AND `user_lock`='0'") > 0) {
			
			//Do we have a lock session?
			if(isset($_SESSION[config::$session_prefix.'lock']) && is_int($_SESSION[config::$session_prefix.'lock'])) {
				$this->lockCount = $_SESSION[config::$session_prefix.'lock'];
				$_SESSION[config::$session_prefix.'lock'] = $this->lockCount+1;
	
			} else {
				$_SESSION[config::$session_prefix.'lock'] = 1;	
				$this->lockCount = $_SESSION[config::$session_prefix.'lock'];
			}
			
			//Counting Limit
			if($this->lockCount >= lib::getSetting('Security_AuthLockAttempts')) {
				unset($_SESSION[config::$session_prefix.'lock']);
				logs::logAction(0,'The user id '.$userid.' account has been locked.','admin');
				db::query("UPDATE `".config::$db_prefix."staff` SET `user_lock`='1',`user_lock_timestamp`='".time()."' WHERE `user_id`='".db::mss($userid)."'");
			}
			
		}
					
	}
	
	//Brute Reset
	//Prevents brute force attacks.
	public function bruteHookReset() {
		
		//Does the user exist in the whitelist?
		if(db::nRows("SELECT `ip_address` FROM `".config::$db_prefix."ban_whitelist` WHERE `ip_address`='".$_SERVER['REMOTE_ADDR']."'") < 1) {
		
			//Does it exist in the DB
			if(db::nRows("SELECT * FROM `".config::$db_prefix."banlist` WHERE `ban_ipaddress`='".$_SERVER['REMOTE_ADDR']."'") > 0) {
		
				//Load IP Ban
				$this->ip_data = db::fetchQuery("SELECT * FROM `".config::$db_prefix."banlist` WHERE `ban_ipaddress`='".$_SERVER['REMOTE_ADDR']."'");
				
				//Timestamp
				$this->timestamp = time() - $this->ip_data['ban_brute_timestamp'];
				$this->timestamp = floor($this->timestamp/60);
								
				//If the ban has existed more than X minutes
				if($this->timestamp >= lib::getSetting('Security_AuthBruteForceAttemptsReset')) {
					logs::logAction(0,'The IP Address '.$_SERVER['REMOTE_ADDR'].' has been removed from the ban list due to time expire.','admin');
					db::query("DELETE FROM `".config::$db_prefix."banlist` WHERE `ban_ipaddress`='".$_SERVER['REMOTE_ADDR']."'");
				}
			
			}
		
		}			
	}
	
	//Brute Hook
	//Prevents brute force attacks.
	public function bruteHook() {
		
		//Does the user exist in the whitelist?
		if(db::nRows("SELECT `ip_address` FROM `".config::$db_prefix."ban_whitelist` WHERE `ip_address`='".$_SERVER['REMOTE_ADDR']."'") < 1) {
		
			//Does the user ID or IP Address already exist?
			if(db::nRows("SELECT `ban_ipaddress` FROM `".config::$db_prefix."banlist` WHERE `ban_ipaddress`='".$_SERVER['REMOTE_ADDR']."'") < 1) {
			
				//Do we have a brute session?
				if(isset($_SESSION[config::$session_prefix.'brute']) && is_int($_SESSION[config::$session_prefix.'brute'])) {
					$this->bruteCount = $_SESSION[config::$session_prefix.'brute'];
					$_SESSION[config::$session_prefix.'brute'] = $this->bruteCount+1;	
				} else {
					$_SESSION[config::$session_prefix.'brute'] = 1;	
					$this->bruteCount = $_SESSION[config::$session_prefix.'brute'];
				}
				
			}
			
			//Counting Limit
			if($this->bruteCount >= lib::getSetting('Security_AuthBruteForceAttempts')) {
				unset($_SESSION[config::$session_prefix.'brute']);
				logs::logAction(0,'The IP Address '.$_SERVER['REMOTE_ADDR'].' has been added the ban list.','admin');
				db::query("INSERT INTO `".config::$db_prefix."banlist` (`ban_ipaddress`,`ban_useragent`,`ban_date`,`ban_brute_timestamp`) 
															VALUES ('".$_SERVER['REMOTE_ADDR']."', '".db::mss($_SERVER['HTTP_USER_AGENT'])."', '".date('Y-m-d h:i:s')."', '".time()."')");	
			}
		
		}			
	}
	
	//@Login
	//Are we logging in?
	public function login() { 
	
		//@Errors Array
		//A place to store errors
		$this->errorsArray = array();
		
		//Validate Formfields
		if(!lib::post('user_username')) { $this->errorsArray[] = 'Please enter your username below.'; }
		if(!lib::post('user_password')) { $this->errorsArray[] = 'Please enter your password below.'; }
		if(strlen(lib::post('user_username')) > 255) { $this->errorsArray[] = 'Please enter your username below.'; }
		if(strlen(lib::post('user_password')) > 255) { $this->errorsArray[] = 'Please enter your username below.'; }
		
		//Bot Trap
		if(!session::validateBotTrap()) {
			$this->errorsArray[] = 'You did not validate the bot trap, you shall not pass!';	
		}
				
		//Does the account exist?
		if(db::nRows("SELECT `user_username` FROM `".config::$db_prefix."staff` WHERE `user_username`='".lib::post('user_username', true)."'") < 1) {
			$this->errorsArray[] = 'Sorry, the username or password provided is incorrect.';	
		} else {
			
			//Does the username and password match?
			$this->account = db::fetchQuery("SELECT `user_id`,`user_password` FROM `".config::$db_prefix."staff` WHERE `user_username`='".lib::post('user_username', true)."'");
			if(!password_verify(lib::post('user_password', true), $this->account['user_password'])) {
				$this->errorsArray[] = 'Sorry, the username or password provided is incorrect.';	
			}
		}
				
		//Account Lock Reset
		$this->accountLockReset($this->account['user_id']);
		
		//Brute Reset
		$this->bruteHookReset();
			
		//Do we have any errors?
		if(count($this->errorsArray) > 0) {
			
			//If we know the account and the user ID
			if(db::nRows("SELECT `user_id` FROM `".config::$db_prefix."staff` WHERE `user_username`='".lib::post('user_username', true)."'") > 0) {
				
				//Load the account
				$this->account = db::fetchQuery("SELECT `user_id` FROM `".config::$db_prefix."staff` WHERE `user_username`='".lib::post('user_username', true)."'");
				$this->account = $this->account['user_id'];
				
			} else {
				$this->account = 0;	
			}
			
			//Brute Force Protection
			$this->bruteHook();
			
			//Account Lock Protection
			$this->accountLock($this->account);
			
			//Log Action
			logs::logAction(2,$this->errorsArray[0],'admin');
			
			//Return Error
			return $this->errorsArray[0];
			
		} else {
						
			//Create Session
			session::create(lib::post('user_username'));
			
			//Log Action
			logs::logAction(0,'The username '.session::data('user_username').' has logged in successfully.','admin');
		}
	
	}
	//@Edit User
	//Are we creating a new account?
	public function deleteUser() { 
	
		//@Errors Array
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the account exist?
		if(db::nRows("SELECT `user_id` FROM `".config::$db_prefix."staff` WHERE `user_id`='".lib::get('user_id',true)."'") < 1) {
			$this->errorsArray[] = 'Sorry, that user does not exist!';
		} else {
			$this->account = db::fetchQuery("SELECT `user_username`,`user_emailaddress`,`user_id`,`user_root` FROM `".config::$db_prefix."staff` WHERE `user_id`='".lib::get('user_id',true)."'");	
		}
					
		//Prevent None-Root from editing..
		if($this->account['user_root']) {
			if(session::data('user_id') != $this->account['user_id']) {
				$this->errorsArray[] = 'Sorry, you do not have permission to the root account.';
			} else {
				if(session::data('user_id') == $this->account['user_id']) {
					$this->errorsArray[] = 'Sorry, this user is root and can not be deleted.';
				}
			}
		}
			
		//Do we have any errors?
		if(count($this->errorsArray) > 0) {
			
			//Log Action
			logs::logAction(2,$this->errorsArray[0],'admin');
			
			//Return Errors
			return $this->errorsArray[0];
		} else {
			
			//Log Action
			logs::logAction(1,'The username '.session::data('user_username').' has deleted a staff user. ('.lib::get('user_id',true).')','admin');
			
			db::query("DELETE FROM `".config::$db_prefix."staff` WHERE `user_id`='".lib::get('user_id',true)."'");	
		}
	}
	
	//@Edit User
	//Are we creating a new account?
	public function editUser() { 
	
		//@Errors Array
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the account exist?
		if(db::nRows("SELECT `user_id` FROM `".config::$db_prefix."staff` WHERE `user_id`='".lib::post('user_id',true)."'") < 1) {
			$this->errorsArray[] = 'Sorry, that user does not exist!';
		} else {
			$this->account = db::fetchQuery("SELECT * FROM `".config::$db_prefix."staff` WHERE `user_id`='".lib::post('user_id',true)."'");	
		}
		
		//Full Name
		if(!lib::post('user_fullname')) { $this->errorsArray[] = 'Please enter a full name below.'; }
		if(strlen(lib::post('user_fullname')) > 80) { $this->errorsArray[] = 'Your full name must be less than 80 characters long.'; }
		
		//Username
		if(!lib::post('user_username')) { $this->errorsArray[] = 'Please enter a username below.'; }
		if(strlen(lib::post('user_username')) > 50) { $this->errorsArray[] = 'Your username must be less than 50 characters long.'; }
		if(!preg_match('/^[a-zA-Z0-9]+$/', lib::post('user_username'))) { $this->errorsArray[] = 'Your username must be a-zA-Z0-9 characters only.'; }
		if(lib::post('user_username') != $this->account['user_username']) {
			if(db::nRows("SELECT `user_username` FROM `".config::$db_prefix."staff` WHERE `user_username`='".lib::post('user_username',true)."'") > 0) {
				$this->errorsArray[] = 'Sorry, that username has already been used..';
			}
		}
		
		//Email Address
		if(!lib::post('user_emailaddress')) { $this->errorsArray[] = 'Please enter an email address below.'; }
		if(!filter_var(lib::post('user_emailaddress'), FILTER_VALIDATE_EMAIL)) { $this->errorsArray[] = 'Please enter a valid email address below.'; }
		if(strlen(lib::post('user_emailaddress')) > 80) { $this->errorsArray[] = 'Please enter a valid email address below.'; }
		if(lib::post('user_emailaddress') != $this->account['user_emailaddress']) {
			if(db::nRows("SELECT `user_emailaddress` FROM `".config::$db_prefix."staff` WHERE `user_emailaddress`='".lib::post('user_emailaddress',true)."'") > 0) {
				$this->errorsArray[] = 'Sorry, that email address has already been used..';
			}
		}
		
		//Group Check
		if(!lib::post('user_groupid')) { $this->errorsArray[] = 'Please select a valid group below.'; }
		if(db::nRows("SELECT * FROM `".config::$db_prefix."groups` WHERE `group_id`='".lib::post('user_groupid',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid group below.';	
		}
		
		//Password Check
		if(lib::post('user_password')) {
			if(strlen(lib::post('user_password')) > 80) {
				$this->errorsArray[] = 'Your password must be less than 80 characters long.';
			}
		}
		
		//Prevent None-Root from editing.. or leaving his/her group.
		if($this->account['user_root']) {
			if(session::data('user_id') != $this->account['user_id']) {
				$this->errorsArray[] = 'Sorry, you do not have permission to the root account.';
			}
			if($this->account['user_groupid'] != lib::post('user_groupid')) {
				$this->errorsArray[] = 'Sorry, you must stay in this group, your root.';	
			}
		}
		
		//Do we have any errors?
		if(count($this->errorsArray) > 0) {
			
			//Log Action
			logs::logAction(2,$this->errorsArray[0],'admin');
			
			//Return Errors
			return $this->errorsArray[0];
		} else {
			
			//Log Action
			logs::logAction(1,'The username '.session::data('user_username').' has edited a staff user. ('.lib::post('user_username',true).')','admin');
			
			db::query("UPDATE `".config::$db_prefix."staff` SET
			
														`user_fullname`='".lib::post('user_fullname',true)."', 
														`user_emailaddress`='".lib::post('user_emailaddress',true)."',
														`user_username`='".lib::post('user_username',true)."', 
														`user_password`='".password_hash(lib::post('user_password',true), PASSWORD_DEFAULT)."',
														`user_groupid`='".lib::post('user_groupid',true)."'
														
													WHERE `user_id`='".lib::post('user_id',true)."'");	
		}
	}
	
	//@Add User
	//Are we creating a new account?
	public function addUser() { 
	
		//@Errors Array
		//A place to store errors
		$this->errorsArray = array();
		
		//Full Name
		if(!lib::post('user_fullname')) { $this->errorsArray[] = 'Please enter a full name below.'; }
		if(strlen(lib::post('user_fullname')) > 80) { $this->errorsArray[] = 'Your full name must be less than 80 characters long.'; }
		
		//Username
		if(!lib::post('user_username')) { $this->errorsArray[] = 'Please enter a username below.'; }
		if(strlen(lib::post('user_username')) > 50) { $this->errorsArray[] = 'Your username must be less than 50 characters long.'; }
		if(!preg_match('/^[a-zA-Z0-9]+$/', lib::post('user_username'))) { $this->errorsArray[] = 'Your username must be a-zA-Z0-9 characters only.'; }
		if(db::nRows("SELECT `user_username` FROM `".config::$db_prefix."staff` WHERE `user_username`='".lib::post('user_username',true)."'") > 0) {
			$this->errorsArray[] = 'Sorry, that username has already been used..';
		}
		
		//Email Address
		if(!lib::post('user_emailaddress')) { $this->errorsArray[] = 'Please enter an email address below.'; }
		if(!filter_var(lib::post('user_emailaddress'), FILTER_VALIDATE_EMAIL)) { $this->errorsArray[] = 'Please enter a valid email address below.'; }
		if(strlen(lib::post('user_emailaddress')) > 80) { $this->errorsArray[] = 'Please enter a valid email address below.'; }
		if(db::nRows("SELECT `user_emailaddress` FROM `".config::$db_prefix."staff` WHERE `user_emailaddress`='".lib::post('user_emailaddress',true)."'") > 0) {
			$this->errorsArray[] = 'Sorry, that email address has already been used..';
		}
		
		//Group Check
		if(!lib::post('user_groupid')) { $this->errorsArray[] = 'Please select a valid group below.'; }
		if(db::nRows("SELECT * FROM `".config::$db_prefix."groups` WHERE `group_id`='".lib::post('user_groupid',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid group below.';	
		}
		
		//Password Check
		if(lib::post('user_password')) {
			if(strlen(lib::post('user_password')) > 80) {
				$this->errorsArray[] = 'Your password must be less than 80 characters long.';
			}
		} else {
			$this->errorsArray[] = 'A password must be set for this user.';	
		}
		
		//Do we have any errors?
		if(count($this->errorsArray) > 0) {
			
			//Log Action
			logs::logAction(2,$this->errorsArray[0],'admin');
			
			return $this->errorsArray[0];
		} else {
			
			
			//Log Action
			logs::logAction(1,'The username '.session::data('user_username').' has added a staff user. ('.lib::post('user_username',true).')','admin');
			
			db::query("INSERT INTO `".config::$db_prefix."staff` 
			
													(
														`user_fullname`, 
														`user_emailaddress`,
														`user_username`, 
														`user_password`,
														`user_groupid`
													) 
													  VALUES 
													(
														'".lib::post('user_fullname',true)."', 
														'".lib::post('user_emailaddress',true)."',
														'".lib::post('user_username',true)."', 
														'".password_hash(lib::post('user_password',true), PASSWORD_DEFAULT)."',
														'".lib::post('user_groupid',true)."'
													)");	
		}
	}
	
	//@Delete Group
	public function deleteGroup() {
	
		//@Errors Array
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the group exist?
		if(db::nRows("SELECT `group_id` FROM `".config::$db_prefix."groups` WHERE `group_id`='".lib::get('group_id',true)."'") < 1) {
			$this->errorsArray[] = 'Sorry, the group your trying to edit does not exist.';	
		} else {
			$this->group = 	db::fetchQuery("SELECT `group_root` FROM `".config::$db_prefix."groups` WHERE `group_id`='".lib::get('group_id',true)."'");
		}
		
		//Does it have any members?
		if(db::nRows("SELECT `user_groupid` FROM `".config::$db_prefix."staff` WHERE `user_groupid`='".lib::get('group_id',true)."'") > 0) {
			$this->errorsArray[] = 'This group has members, remove the members first!';	
		}
		
		//If group is root
		if($this->group['group_root']) {
			$this->errorsArray[] = 'Sorry, this group can not be deleted.';	
		}
		
		//Do we have any errors?
		if(count($this->errorsArray) > 0) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];
		} else {
			logs::logAction(1,'The username '.session::data('user_username').' has removed a group.','admin');
			db::query("DELETE FROM `".config::$db_prefix."groups` WHERE `group_id`='".lib::get('group_id',true)."'");
		}
	}
	
	//@Edit Group
	public function editGroup() {
	
		//@Errors Array
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the group exist?
		if(db::nRows("SELECT `group_id` FROM `".config::$db_prefix."groups` WHERE `group_id`='".lib::post('group_id',true)."'") < 1) {
			$this->errorsArray[] = 'Sorry, the group your trying to edit does not exist.';	
		} else {
			$this->group = 	db::fetchQuery("SELECT `group_root` FROM `".config::$db_prefix."groups` WHERE `group_id`='".lib::post('group_id',true)."'");
		}
		
		//Group Name
		if(!lib::post('group_name')) { $this->errorsArray[] = 'Please enter a group name below to continue.'; }
		if(strlen(lib::post('group_name')) > 50) { $this->errorsArray[] = 'Your group name must be less than 50 characters long.'; }
		
		//Group Description
		if(!lib::post('group_description')) { $this->errorsArray[] = 'Please enter a group name below to continue.'; }
		if(strlen(lib::post('group_description')) > 100) { $this->errorsArray[] = 'Your group description must be less than 100 characters long.'; }
		
		//If group is root
		if($this->group['group_root']) {
			$this->errorsArray[] = 'Sorry, this group can not be edit.';	
		}
		
		//Do we have any errors?
		if(count($this->errorsArray) > 0) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];
		} else {
			logs::logAction(1,'The username '.session::data('user_username').' has edited a group. ('.lib::post('group_id',true).')','admin');
			db::query("UPDATE `".config::$db_prefix."groups` SET `group_name`='".lib::post('group_name',true)."', `group_description`='".lib::post('group_description',true)."' WHERE `group_id`='".lib::post('group_id',true)."'");
		}
	}
	
	//@Add Group
	public function addGroup() {
	
		//@Errors Array
		//A place to store errors
		$this->errorsArray = array();
		
		//Group Name
		if(!lib::post('group_name')) { $this->errorsArray[] = 'Please enter a group name below to continue.'; }
		if(strlen(lib::post('group_name')) > 50) { $this->errorsArray[] = 'Your group name must be less than 50 characters long.'; }
		
		//Group Description
		if(!lib::post('group_description')) { $this->errorsArray[] = 'Please enter a group name below to continue.'; }
		if(strlen(lib::post('group_description')) > 100) { $this->errorsArray[] = 'Your group description must be less than 100 characters long.'; }
		
		//Do we have any errors?
		if(count($this->errorsArray) > 0) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];
		} else {
			logs::logAction(1,'The username '.session::data('user_username').' has added a group. ('.lib::post('group_name',true).')','admin');
			db::query("INSERT INTO `".config::$db_prefix."groups` (`group_name`, `group_description`) VALUES ('".lib::post('group_name',true)."','".lib::post('group_description',true)."')");
		}
	}
	
}