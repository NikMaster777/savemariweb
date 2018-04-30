<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You smn not access this file directly!'); }
class session {
	
	//@Declared
	public static $private_key;
	public static $public_key;
	public static $global_key;
	public static $errorsArray;
	public static $user;
	public static $session_userid;
	public static $session_public;
	public static $value;
					
	//@Session Data
	public static function data($key, $mss=false, $strip=false, $html=false) {
		if(isset(self::$user[$key]) && self::$user[$key] != '') {
			self::$value = lib::san(self::$user[$key], $mss, $strip, $html);
			return self::$value;
		} else {
						
			//What type of session do we have?
			if(lib::session(config::$session_prefix.'userid_sm') != '' && lib::session(config::$session_prefix.'public_sm') != '') {
				self::$session_userid = lib::session(config::$session_prefix.'userid_sm');
				self::$session_public = lib::session(config::$session_prefix.'public_sm');			
			} elseif(lib::cookie(config::$session_prefix.'userid_sm') != '' && lib::cookie(config::$session_prefix.'public_sm') != '') {
				self::$session_userid = lib::cookie(config::$session_prefix.'userid_sm');
				self::$session_public = lib::cookie(config::$session_prefix.'public_sm');
			} else {
				self::$errorsArray[] = 'E1';
			}
			
			self::$user = db::fetchQuery("SELECT * FROM `".config::$db_prefix."clients` WHERE `user_id`='".db::mss(substr(self::$session_userid,0,255))."'");
			self::$value = lib::san(self::$user[$key], $mss, $strip, $html);
			return self::$value;
		}
	}
		
	//@Session Active
	//Do we have an active session?
	public static function active() {
		
		//@Errors Array
		//A place to store errors
		self::$errorsArray = array();
		
		//What type of session do we have?
		if(lib::session(config::$session_prefix.'userid_sm') != '' && lib::session(config::$session_prefix.'public_sm') != '') {
			self::$session_userid = lib::session(config::$session_prefix.'userid_sm');
			self::$session_public = lib::session(config::$session_prefix.'public_sm');			
		} elseif(lib::cookie(config::$session_prefix.'userid_sm') != '' && lib::cookie(config::$session_prefix.'public_sm') != '') {
			self::$session_userid = lib::cookie(config::$session_prefix.'userid_sm');
			self::$session_public = lib::cookie(config::$session_prefix.'public_sm');
		} else {
			self::$errorsArray[] = 'E1';
		}
				
		//Build Global Key
		self::$global_key = sha1(self::$private_key = sha1(config::$session_salt).self::$session_public);
		
		//Does it exist?
		if(db::nRows("SELECT `user_session`,`user_id` FROM `".config::$db_prefix."clients` WHERE `user_session`='".db::mss(self::$global_key)."' AND `user_id`='".db::mss(self::$session_userid)."'") < 1) {
			self::$errorsArray[] = 'E2';
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
	public static function create($user_id, $cookie = false) {
		
		//Create Public, Private and Global Key
		self::$public_key  = sha1($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time());
		self::$private_key = sha1(config::$session_salt);
		self::$global_key = sha1(self::$private_key.self::$public_key);
		
		//Store Global Key
		db::query("UPDATE `".config::$db_prefix."clients` SET `user_session`='".self::$global_key."',`user_ipaddress`='".db::mss($_SERVER['REMOTE_ADDR'])."',`user_login_timestamp`='".time()."' WHERE `user_id`='".db::mss($user_id)."'");
		
		//Create PHP Session
		if($cookie) {
			$domain = lib::getSetting('General_SystemURL');
			$domain = str_replace('https://', '', $domain);
			$domain = str_replace('http://', '', $domain);
			$domain = str_replace('/', '', $domain);	
			$domain = str_replace('www.', '', $domain);
			setcookie(config::$session_prefix.'userid_sm', $user_id, time()+60*60*24*7, '/', $domain, false, false); 
			setcookie(config::$session_prefix.'public_sm', self::$public_key, time()+60*60*24*7, '/', $domain, false, false);
		} else {
			$_SESSION[config::$session_prefix.'userid_sm'] = $user_id;
			$_SESSION[config::$session_prefix.'public_sm'] = self::$public_key; 
		}
						
	}
	
	//@Kill Session
	//Are we killing a new session
	public static function kill() {
		//Log Action
		$domain = lib::getSetting('General_SystemURL');
		$domain = str_replace('https://', '', $domain);
		$domain = str_replace('http://', '', $domain);
		$domain = str_replace('/', '', $domain);
		$domain = str_replace('www.', '', $domain);
		setcookie(config::$session_prefix.'userid_sm', '123', time()-60*60*24*7, '/', $domain, false, false); 
		setcookie(config::$session_prefix.'public_sm', '123', time()-60*60*24*7, '/', $domain, false, false);
		@session_destroy();	
	}
	
}