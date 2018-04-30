<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class banners {
	
	
	//Load Banners
	public function getImages($bannerID, $limit=0, $random=0) {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the banner exist?
		if(db::nRows("SELECT * FROM `".config::$db_prefix."banners` WHERE `banner_id`='".db::mss($bannerID)."'") < 1) {
			$this->errorsArray[] = 'That banner does not exist.';	
		}
		
		//Do we have any errors
		if(count($this->errorsArray) > 0) {
			return array();
		} else {
			
			//Images Array
			$bannerImages = array();
			
			//Counter
			$counter = 0;
					
			//Load Images
			if($random == 1) {
				$imageSQL = db::query("SELECT * FROM `".config::$db_prefix."banners_images` WHERE `image_bannerid`='".db::mss($bannerID)."' ORDER BY RAND() LIMIT 0,1");
			} else {
				$imageSQL = db::query("SELECT * FROM `".config::$db_prefix."banners_images` WHERE `image_bannerid`='".db::mss($bannerID)."'");	
			}			
			while($imageData = db::fetch($imageSQL)) {
				$bannerImages[$imageData['image_name']] = $imageData['image_link'];
				$counter++;
				if($limit != 0 && $limit == $counter) { break; }
			}
			
			//Return
			return $bannerImages;
			
		}
		
	}	
	
}