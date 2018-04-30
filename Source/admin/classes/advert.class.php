<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class advert {
	
	//Reject Advert
	public function multiCat() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have a category
		if(!lib::post('advert_catid')) { $this->errorsArray[] = 'Please select an category to continue.'; }
		if(db::nRows("SELECT `cat_id` FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::post('advert_catid',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid category to continue.';
		}
		
		//Do we have advert IDs
		if(!lib::post('advertids')) { $this->errorsArray[] = 'Please select an advert to continue.'; }
		$this->advertids = explode(',', lib::post('advertids'));
		if(count($this->advertids) < 1) { $this->errorsArray[] = 'Please select an advert to continue.';  }
		foreach($this->advertids AS $this->advertid) {
			if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".$this->advertid."'") < 1) {
				$this->errorsArray[] = 'Please enter a valid advert ID to continue.';	
			}
		}
				
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			
			//Update Advert
			$this->advertids = explode(',', lib::post('advertids'));
			foreach($this->advertids AS $this->advertid) {
				$cat_id = db::fetchQuery("SELECT `cat_id`,`cat_parentid` FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::post('advert_catid',true)."'");			
				db::query("UPDATE `".config::$db_prefix."adverts` SET `advert_catid`='".$cat_id['cat_parentid']."',`advert_subcatid`='".$cat_id['cat_id']."' WHERE `advert_id`='".db::mss($this->advertid)."'");
			}
			
			//Return Success
			return json_encode(array('success' => 1));
		}	
	}
		
	//Reject Advert
	public function rejectAdvert($advertid) {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does it exist?
		if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".db::mss($advertid)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid advert to approve.';	
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			
			//Update Advert
			db::query("UPDATE `".config::$db_prefix."adverts` SET `advert_status`='3' WHERE `advert_id`='".db::mss($advertid)."'");
			
			//Return Success
			return json_encode(array('success' => 1));
		}
		
	}
	
	//Approve Advert
	public function approveAdvert($advertid) {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does it exist?
		if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".db::mss($advertid)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid advert to approve.';	
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			
			//Update Advert
			db::query("UPDATE `".config::$db_prefix."adverts` SET `advert_status`='1' WHERE `advert_id`='".db::mss($advertid)."'");
			
			//Return Success
			return json_encode(array('success' => 1));
		}
		
	}
		
	//@Get Package
	public function getAdpack($packid) {
		return db::fetchQuery("SELECT * FROM `".config::$db_prefix."adpacks` WHERE `pack_id`='".db::mss($packid)."'");
	}
	
	//@Get Images
	public function getImages($advertid, $single=false) {
		$images = array();
		if(isset($images) && count($images) > 0) {
			return $images;
		} else {
			$imageSQL = db::query("SELECT * FROM `".config::$db_prefix."advertimages` WHERE `image_advertid`='".db::mss($advertid)."'");
			while($imageData = db::fetch($imageSQL)) {
				if(file_exists(ROOT.'/uploads/advert_images/'.$imageData['image_name'])) {
					$images[$imageData['image_id']] = $imageData['image_name'];
				}
				if($single) { break; }
			}
			return $images;
		}
	}
	
	//@Get Advert Images
	public function getDashboardImage($advertid) {
		$image = db::fetchQuery("SELECT * FROM `".config::$db_prefix."advertimages` WHERE `image_advertid`='".db::mss($advertid)."' LIMIT 0,1");
		if(file_exists(ROOT.'/uploads/advert_images/'.$image['image_name'])) {
			return DOMAIN.'/index.php?image=adverts&size=100&image_name='.$image['image_name'];
		} else {
			return DOMAIN.'/templates/default/images/75x75noimage.png';
		}
	}	
	
	////////////////////////////////////////
	// @Delete Advert
	////////////////////////////////////////
	public function deleteAdvert() {
			
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the advert even exist?
		if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::post('advert_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please enter a valid advert ID to continue.';	
		}
		
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Load Advert
			$this->advert_data = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::post('advert_id',true)."'");
			
			//Remove All Images
			$this->imageSQL = db::query("SELECT `image_name`,`image_id` FROM `".config::$db_prefix."advertimages` WHERE `image_advertid`='".$this->advert_data['advert_id']."'");			
			while($this->imageData = db::fetch($this->imageSQL)) {
				@unlink(ROOT.'/uploads/advert_images/'.$this->imageData['image_name']);
				db::query("DELETE FROM `".config::$db_prefix."advertimages` WHERE `image_id`='".$this->imageData['image_id']."'");
			}
			
			//Remove Advert
			db::query("DELETE FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::post('advert_id',true)."'");
			
			//Success
			return json_encode(array('success' => 1));
		}
			
	}
	
	////////////////////////////////////////
	// @Edit Advert
	////////////////////////////////////////
	public function editAdvert() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the advert even exist?
		if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::post('advert_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please enter a valid advert ID to continue.';	
		}
		
		//Does the adpack exist?
		if(db::nRows("SELECT * FROM `".config::$db_prefix."adpacks` WHERE `pack_id`='".lib::post('advert_packid',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid adpack to continue.';
		}	
			
		//Do we have a category
		if(!lib::post('advert_catid')) { $this->errorsArray[] = 'Please select an category to continue.'; }
		if(db::nRows("SELECT `cat_id` FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::post('advert_catid',true)."' AND `cat_parentid`='0'") < 1) {
			$this->errorsArray[] = 'Please select a valid category to continue.';
		} else {
			$parent = db::fetchquery("SELECT `cat_id` FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::post('advert_catid',true)."' AND `cat_parentid`='0'");
			if(!lib::post('advert_subcatid')) { $this->errorsArray[] = 'Please select a sub-category to continue.'; }
			if(db::nRows("SELECT `cat_id` FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::post('advert_subcatid',true)."' AND `cat_parentid`='".$parent['cat_id']."'") < 1) {
				$this->errorsArray[] = 'Please select a valid sub-category to continue.';
			}
		}
		
		//Form Field Validation
		if(!lib::post('advert_title')) { $this->errorsArray[] = 'Please enter a title for your advert.'; }
		if(strlen(lib::post('advert_title')) > 60) { $this->errorsArray[] = 'Your advert title must be less than 60 characters long.'; }
		if(!preg_match("/[A-Za-z0-9,'\s]+/", lib::post('advert_title'))) { $this->errorsArray[] = 'Your advert title must not contain any other characters other than A-Z and 0-9 with spaces.'; }
		
		//Validate Price
		if(!lib::post('advert_price')) { $this->errorsArray[] = 'Please enter a valid price for your advert below.'; }
		if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', lib::post('advert_price'))) {
			$this->errorsArray[] = 'Please enter a valid price for your advert below.';
		}
		
		//Province Validation
		if(!lib::post('advert_province')) { $this->errorsArray[] = 'Please select a province to continue.'; }
		if(db::nRows("SELECT `city_id` FROM `".config::$db_prefix."cities` WHERE `city_id`='".lib::post('advert_province',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a province to continue.';
		}
		
		//Country Validation
		if(!lib::post('advert_country')) { $this->errorsArray[] = 'Please select a valid country to continue.'; }
		if(db::nRows("SELECT `id` FROM `".config::$db_prefix."countries` WHERE `id`='".lib::post('advert_country',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a province to continue.';
		}
		
		if(!lib::post('advert_html')) { $this->errorsArray[] = 'Please enter a description for your advert to continue.'; }
		if(strlen(lib::post('advert_html')) > 15000) { $this->errorsArray[] = 'Your advert description must not be more than 1500 characters long.'; }
				
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Load Session
			$this->advert = $_SESSION[config::$db_prefix.'advert'];
			
			//Create SEO String
			$string = strtolower(lib::post('advert_title',true));
			$string = preg_replace('/[^a-zA-Z0-9 ]/','', $string);
			$string = preg_replace('/\s+/','-',$string);
			
			//Update Advert
			db::query("UPDATE `".config::$db_prefix."adverts` SET
																	`advert_title`='".lib::post('advert_title',true)."',
																	`advert_price`='".lib::post('advert_price',true)."',
																	`advert_cityid`='".lib::post('advert_province',true)."',
																	`advert_countryid`='".lib::post('advert_country',true)."',
																	`advert_html`='".lib::post('advert_html',true)."',
																	`advert_status`='1',
																	`advert_seo_url`='".db::mss($string)."',
																	`advert_catid`='".lib::post('advert_catid',true)."',
																	`advert_subcatid`='".lib::post('advert_subcatid',true)."',
																	`advert_packid`='".lib::post('advert_packid',true)."'
																	
																	WHERE `advert_id`='".lib::post('advert_id',true)."'");
												
			//Success
			return json_encode(array('success' => 1));	
			
		}
		
	}
	
}