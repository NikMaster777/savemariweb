<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

//Define Root
define('IN_ROOT', true);
define('ROOT', dirname(__FILE__));

//Error Reporting
error_reporting(E_ALL);
ini_set("display_errors", 'On');
ini_set("log_errors", 1);
ini_set("error_log", ROOT.'/logs/error_log.txt');

//Require Important Classes
require(ROOT.'/config.php');

//Test Database Connection
if(isset($connect) && mysqli_ping($connect)) {
	$connect = $connect;	
} else {
	$connect = @mysqli_connect(config::$db_hostname, config::$db_username, config::$db_password, config::$db_database);
}

if(!$connect) {
	die(mysqli_connect_error($connect, $template));
} else {
	@mysqli_close($connect);
}

//Require Important Classes
require(ROOT.'/classes/db.class.php');
require(ROOT.'/classes/lib.class.php');
require(ROOT.'/classes/logs.class.php');
require(ROOT.'/classes/paginate.class.php');
require(ROOT.'/classes/mailer.class.php');

/////////////////////////////////////////////////////////////////////////////////////////////
// @EDIT BELOW THIS LINE
/////////////////////////////////////////////////////////////////////////////////////////////

//@Deleted Adverts
$deletedCount = 0; 
$expiredCount = 0;

//@Standard Adverts - Expire Check
//This will find and mark any adverts that have expired to expired.
$SQLQuery = db::query("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_store`='0' AND `advert_status`='1'");
while($SQLData = db::fetch($SQLQuery)) {
		
	//Expiry Date
	$expireDate = strtotime($SQLData['advert_expiredate']);
		
	//If the advert has expired, more than 30 days old.
	if(time() > $expireDate) {
							
			//Log Message
			//logs::logAction(5,'The advert ID "'. $SQLData['advert_id'].'" has expired. - The advert has been set expired.',$location=null);	
			
			//Update the Advert
			//db::query("UPDATE `".config::$db_prefix."adverts` SET `advert_status`='2' WHERE `advert_id`='".db::mss($SQLData['advert_id'])."'");
			
			//Increment Statistics
			$expiredCount = $expiredCount+1;	
		
	}	
}

//Unset
unset($SQLQuery);
unset($SQLData);
unset($expireDate);

//@Standard Adverts - Delete Check
//This will find adverts that are older than 60 days.
/* $SQLQuery = db::query("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_store`='0' AND `advert_status`='2'");
while($SQLData = db::fetch($SQLQuery)) {
		
	//Expiry Date
	$expireDate = strtotime('+30 Days', strtotime($SQLData['advert_expiredate']));
		
	//If the advert has expired, more than 30 days old.
	if(time() > $expireDate) {
							
		logs::logAction(5,'The advert ID "'. $SQLData['advert_id'].'" is more than 60 days old. - The advert has been set deleted.',$location=null);	
	
		//Remove All Images
		$imageSQL = db::query("SELECT `image_name`,`image_id` FROM `".config::$db_prefix."advertimages` WHERE `image_advertid`='".db::mss($SQLData['advert_id'])."'");			
		while($imageData = db::fetch($imageSQL)) {
			@unlink(ROOT.'/uploads/advert_images/'.$imageData['image_name']);
			db::query("DELETE FROM `".config::$db_prefix."advertimages` WHERE `image_id`='".$imageData['image_id']."'");
		}
		
		//Remove Advert Stats
		db::query("DELETE FROM `".config::$db_prefix."advert_hitviews` WHERE `stat_advertid`='".db::mss($SQLData['advert_id'])."'");
		db::query("DELETE FROM `".config::$db_prefix."advert_uniqueviews` WHERE `stat_advertid`='".db::mss($SQLData['advert_id'])."'");
		
		//Remove Advert
		db::query("DELETE FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".db::mss($SQLData['advert_id'])."'"); 
		
		//Increment Statistics
		$deletedCount = $deletedCount++;	
		
	}	
} */

//Unset
unset($SQLQuery);
unset($SQLData);