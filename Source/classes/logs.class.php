<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Creative Miles
 *@Start: 12th June 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class logs {
	
	/* 0 => Security
	 * 1 => General
	 * 2 => Form Errors
	 * 3 => Update Logs
	 * 4 => Cron Jobs
	 * 5 => 
	 * 
	 */
		
	//@Log Action
	//Allows us to log an action to the system
	public static function logAction($log_type=0,$log_message=null,$location=null) {
		db::query("INSERT INTO `".config::$db_prefix."logs` (`log_type`,`log_message`,`log_timestamp`,`log_useragent`,`log_ipaddress`,`log_location`,`log_datetime`) VALUES ('".db::mss($log_type)."', '".db::mss($log_message)."', '".time()."', '".db::mss(substr($_SERVER['HTTP_USER_AGENT'],0,255))."', '".$_SERVER['REMOTE_ADDR']."','".db::mss($location)."','".db::mss(date('Y-m-d h:i:s'))."')");
	}
	
	
}