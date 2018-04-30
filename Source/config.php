<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class config {
	
	//Database Connection
	public static $db_username = 'savemar_new';
	public static $db_password = '8y!rePmuaqow';
	public static $db_hostname = 'localhost';
	public static $db_database = 'savemar_new';
	public static $db_prefix = 'sa_';
		
	//Session Prefix
	public static $session_prefix = 'sa_';
	public static $session_salt = 'mf8u93h3hg980h43980';
	
	//Localization
	public static $default_country = '246';
		
	//PayPal API Details
	public static $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
	public static $paypal_email = 'pkonoro@gmail.com';
	
	//PayNow API Details
	public static $integration_id = '3479';
	public static $integration_key = 'e0d2d875-7420-4bb7-92b9-96bd319a1a69';
	
	//Service Emails
	public static $service_email = 'shaun@creativemiles.co.uk';
	
}