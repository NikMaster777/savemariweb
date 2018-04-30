<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class checkpoint {
	public function __construct($template = 0) {
				
		//Error Reporting
		error_reporting(E_ALL);
		ini_set("display_errors", 'On');
		ini_set("log_errors", 1);
		ini_set("error_log", ROOT.'/logs/error_log.txt');
		
		//Require Important Classes
		require(ROOT.'/config.php');
		
		//Test Database Connection
		if(isset($this->connect) && mysqli_ping($this->connect)) {
			$this->connect = $this->connect;	
		} else {
			$this->connect = @mysqli_connect(config::$db_hostname, config::$db_username, config::$db_password, config::$db_database);
		}
		
		if(!$this->connect) {
			die(mysqli_connect_error($this->connect, $template));
		} else {
			@mysqli_close($this->connect);
		}
		
		//Start Session
		session_start();
					
		//Require Important Classes
		require(ROOT.'/classes/db.class.php');
		require(ROOT.'/classes/lib.class.php');
		require(ROOT.'/classes/logs.class.php');
		require(ROOT.'/classes/paginate.class.php');
		require(ROOT.'/classes/mailer.class.php');
		require(ROOT.'/classes/sms.class.php');
				
		//SSL Enabled?
		$domain = 'www.savemari.com';		
		
		//Constants
		define('DOMAIN', 'https://'.$domain);
		define('ADMINDOMAIN', 'https://'.$domain.'/admin');
		
		//If not SSL, Redirect
		if($_SERVER['SERVER_PORT']  != 443) { header("Location:".DOMAIN); }
		
		//Which Template?
		if($template) {
			require(ROOT.'/admin/classes/session.class.php');
			require(ROOT.'/admin/classes/auth.class.php');
			require(ROOT.'/admin/classes/template.class.php');
		} else {
			require(ROOT.'/classes/session.class.php');
			require(ROOT.'/classes/auth.class.php');
			require(ROOT.'/classes/user.class.php');
			require(ROOT.'/classes/template.class.php');
		}
								 	
		//Load Template
		$template = new template;
						
		//Close Any DB Connection
		db::closeDB();
			
	}
}