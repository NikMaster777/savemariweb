<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You smn not access this file directly!'); }
class sms {
	
	//SendSMS Message
	public function send($receiver, $message) {
		$token  = '0a75-b9e6-b95b-ea18';
		$message = urlencode($message);
		$message = substr(0,469);
		@file_get_contents('https://my.fastsms.co.uk/api?Token='.$token.'&Action=Send&DestinationAddress='.$receiver.'&SourceAddress=API&Body='.$message);	
	}
	
	
	
}

//Spawn Class
$sms=new sms();