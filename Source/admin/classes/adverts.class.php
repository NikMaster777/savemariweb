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
		
	//@Ajax Image Remove - Advert Creation
	//Allows adverts to upload images.
	public function createAdvert_ImageRemove() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));
		} else {
			
			//Load Image Session
			if(isset($_SESSION[config::$db_prefix.'advert']['advert_images']) && is_array($_SESSION[config::$db_prefix.'advert']['advert_images'])) {
				$this->advert_images = @$_SESSION[config::$db_prefix.'advert']['advert_images'];	
			} else {
				@$_SESSION[config::$db_prefix.'advert']['advert_images'] = array();
				$this->advert_images = @$_SESSION[config::$db_prefix.'advert']['advert_images'];
			}
			
			//Loop
			foreach($this->advert_images AS $this->image_key => $this->image_name) {
				if(lib::post('advert_image') == $this->image_key) {
					unset($this->advert_images[$this->image_key]);	
				}
			}
					
			//Save Image
			unset($_SESSION[config::$db_prefix.'advert']['advert_images']);
			$_SESSION[config::$db_prefix.'advert']['advert_images'] = $this->advert_images;	
			
			//Return Data
			return json_encode(array('success' => true, 'image-name' => lib::post('advert_image')));
		}
		
	}
	
	//@Ajax Image Upload - Advert Creation
	//Allows adverts to upload images.
	public function createAdvert_ImageUpload() {
		
		//A place to store errors
		$this->errorsArray = array();
				
		//Allowed Image Types
		$this->allowedImageTypes = array('image/jpg','image/jpeg','image/png','image/gif');
		$this->maxSize = 2097152;
		$this->minWidth = 250;
		$this->minHeight = 250;
		
		// Check atleast one image has been selected
		if(@$_FILES['advert-images']['tmp_name']== ""){
			$this->errorsArray[] = 'Please select an image to upload.';
		}
				
		// Check Images are valid image types
		if(!in_array(@$_FILES['advert-images']['type'], $this->allowedImageTypes)){
			$this->errorsArray[] = 'One or more images are not supported. Please check and try again.';
		}
		
		// Check images are valid sizes
		if(@$_FILES['advert-images']['size'] > $this->maxSize){
			$this->errorsArray[] = 'One or more of your images exceeds the max file size, please reduce the image file size to continue.';
		}
		
		// Get image width and height
		$this->image_dimensions = @getimagesize(@$_FILES['advert-images']['tmp_name']); // returns an array of image info [0] = width, [1] = height
		$this->image_width = $this->image_dimensions[0]; // Image width
		$this->image_height = $this->image_dimensions[1]; // Image height
		if(($this->image_width < $this->minWidth) || ($this->image_height < $this->minHeight)){
			$this->errorsArray[] = 'One or more of your images does not meet the minimum height and minimum width requirements. - '.@$_FILES['advert-images']['name'];
		}
		
		//Does the session even exist?
		if(isset($_SESSION[config::$db_prefix.'advert']) == false) {
			$this->errorsArray[] = 'Something unexpected happened with the session, where did it go?';
		} else {
			//Do we have any images?
			if(isset($_SESSION[config::$db_prefix.'advert']['advert_images']) && is_array($_SESSION[config::$db_prefix.'advert']['advert_images'])) {
				if(count($_SESSION[config::$db_prefix.'advert']['advert_images']) > 6) {
					$this->errorsArray[] = 'You have uploaded to many images, remove one or more to continue.';
				}
			}
		}
		
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Lets resize and get that image stored
			require(ROOT.'/classes/simpleimage.class.php');
			
			//Image Directory
			$this->image_dir = ROOT.'/uploads/advert_images';
			
			//Move File to Temp Directory
			move_uploaded_file(@$_FILES['advert-images']['tmp_name'], $this->image_dir.'/temp_images/'.@$_FILES['advert-images']['name']);
			
			//Unique Image Name
			$this->unique_name = session::data('user_id').'-'.preg_replace('/[. ]+/', '-', microtime()).'.jpg';
			
			//Load Simple Image Class
			$image = new \claviska\SimpleImage();
			
			//Magic!
			@$image
			  ->fromFile($this->image_dir.'/temp_images/'.@$_FILES['advert-images']['name']) // load image.jpg
			  //->resize(360,960)
			  // resize to 320x200 pixels
			  /* ->overlay('watermark.png', 'bottom right')  // add a watermark image */
			  ->toFile($this->image_dir.'/temp_images/'.$this->unique_name, 'image/jpg');      // convert to PNG and save a copy to new-image.png
						 
			//@Unlink
			@unlink($this->image_dir.'/temp_images/'.@$_FILES['advert-images']['name']);
			
			//Load Image Session
			if(isset($_SESSION[config::$db_prefix.'advert']['advert_images']) && is_array($_SESSION[config::$db_prefix.'advert']['advert_images'])) {
				$this->advert_images = @$_SESSION[config::$db_prefix.'advert']['advert_images'];	
			} else {
				@$_SESSION[config::$db_prefix.'advert']['advert_images'] = array();
				$this->advert_images = @$_SESSION[config::$db_prefix.'advert']['advert_images'];
			}
			
			//Append Images to Array
			$this->advert_images[@$_FILES['advert-images']['name']] = $this->unique_name;
			
			//Save Image
			$_SESSION[config::$db_prefix.'advert']['advert_images'] = $this->advert_images;
									
			//Return Data
			return json_encode(array('success' => true, 'image-name' => $this->unique_name));
			
		}
	}
	
	
	////////////////////////////////////////
	// @Delete Advert
	////////////////////////////////////////
	
	public function deleteAdvert() {
			
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the advert even exist?
		if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE `advert_userid`='".session::data('user_id')."' AND `advert_id`='".lib::post('advert_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please enter a valid advert ID to continue.';	
		}
		
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Load Advert
			$this->advert_data = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_userid`='".session::data('user_id')."' AND `advert_id`='".lib::post('advert_id',true)."'");
			
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
		if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE `advert_userid`='".session::data('user_id')."' AND `advert_id`='".lib::post('advert_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please enter a valid advert ID to continue.';	
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
		
		//Prepare Validation
		//preg_match_all( '#<([a-z]+)>#i' , lib::post('advert_html'), $start, PREG_OFFSET_CAPTURE);
		//preg_match_all( '#<\/([a-z]+)>#i' , lib::post('advert_html'), $end, PREG_OFFSET_CAPTURE);
		//$start = $start[1];
		//$end = $end[1];
		
		//Count HTML Tags
		//if(count($start) != count($end)) { $this->errorsArray[] = 'We are missing some HTML tags which should of been closed, what did you do?'; }
		
		//Do we have any images?
		if(isset($_SESSION[config::$db_prefix.'advert']['advert_images']) && count($_SESSION[config::$db_prefix.'advert']['advert_images']) > 0) {
			if(isset($_SESSION[config::$db_prefix.'advert']['advert_images']) && is_array($_SESSION[config::$db_prefix.'advert']['advert_images'])) {
				if(count($_SESSION[config::$db_prefix.'advert']['advert_images']) < 1) {
					$this->errorsArray[] = 'Please select an image to upload!';
				}
			}
		}
		
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
																	`advert_status`='0',
																	`advert_seo_url`='".db::mss($string)."',
																	`advert_catid`='".lib::post('advert_catid',true)."',
																	`advert_subcatid`='".lib::post('advert_subcatid',true)."'
																	
																	WHERE `advert_id`='".lib::post('advert_id',true)."'");
			
			//Load Advert
			$this->advert_data = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::post('advert_id',true)."'");
						
			//Images
			$this->advert_images = @$_SESSION[config::$db_prefix.'advert']['advert_images'];
			
			//Are we updating images?
			if(count($this->advert_images) > 0) {
				
				//Delete Old Images (Files)
				$this->oldSQL = db::query("SELECT * FROM `".config::$db_prefix."advertimages` WHERE `image_advertid`='".$this->advert_data['advert_id']."'");
				while($this->oldData = db::fetch($this->oldSQL)) {
					@unlink(ROOT.'/uploads/advert_images/'.$this->oldData['image_name']);
				}
				
				//Remove DB Entries
				db::query("DELETE FROM `".config::$db_prefix."advertimages` WHERE `image_advertid`='".$this->advert_data['advert_id']."'");
								
				//Foreach Image / Store
				foreach($this->advert_images AS $this->advert_image) {
					
					//Store Images
					db::query("INSERT INTO `".config::$db_prefix."advertimages` (`image_advertid`,
																				 `image_userid`,
																				 `image_name`)
																				  
																				VALUES 
																				
																				('".$this->advert_data['advert_id']."',
																				 '".session::data('user_id',true)."',
																				 '".db::mss($this->advert_image)."')
																				 ");
					
					
					//Image Directory
					$this->image_dir = ROOT.'/uploads/advert_images';
					
					//Move Images, We plan to keep them!
					@rename($this->image_dir.'/temp_images/'.$this->advert_image, $this->image_dir.'/'.$this->advert_image);
				}
				
			}
			
			//Success
			return json_encode(array('success' => 1));	
			
		}
		
	}
	
}