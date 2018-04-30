<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class banners {
	
	//Upload Banner
	public function ImageUpload() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the banner exist?
		if(db::nRows("SELECT * FROM `".config::$db_prefix."banners` WHERE `banner_id`='".lib::get('banner_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please select the correct banner to upload an image to.';	
		} else {
			$bannerData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."banners` WHERE `banner_id`='".lib::get('banner_id',true)."'");	
		}
				
		//Allowed Image Types
		$this->allowedImageTypes = array('image/jpg','image/jpeg','image/png','image/gif');
		$this->maxSize = 2097152;
		$this->minWidth = @$bannerData['banner_width'];
		$this->minHeight = @$bannerData['banner_height'];
		
		// Check atleast one image has been selected
		if(@$_FILES['banner-images']['tmp_name']== ""){
			$this->errorsArray[] = 'Please select an image to upload.';
		}
				
		// Check Images are valid image types
		if(!in_array(@$_FILES['banner-images']['type'], $this->allowedImageTypes)){
			$this->errorsArray[] = 'One or more images are not supported. Please check and try again.';
		}
		
		// Check images are valid sizes
		if(@$_FILES['banner-images']['size'] > $this->maxSize){
			$this->errorsArray[] = 'One or more of your images exceeds the max file size, please reduce the image file size to continue.';
		}
		
		// Get image width and height
		$this->image_dimensions = @getimagesize(@$_FILES['banner-images']['tmp_name']); // returns an array of image info [0] = width, [1] = height
		$this->image_width = $this->image_dimensions[0]; // Image width
		$this->image_height = $this->image_dimensions[1]; // Image height
		if(($this->image_width < $this->minWidth) || ($this->image_height < $this->minHeight)){
			$this->errorsArray[] = 'One or more of your images does not meet the minimum height and minimum width requirements. - '.@$_FILES['banner-images']['name'];
		}
		
		//Does the session even exist?
		if(isset($_SESSION[config::$db_prefix.'banner']) == false) {
			$this->errorsArray[] = 'Something unexpected happened with the session, where did it go?';
		} else {
			//Do we have any images?
			if(isset($_SESSION[config::$db_prefix.'banner']['banner_images']) && is_array($_SESSION[config::$db_prefix.'banner']['banner_images'])) {
				if(count($_SESSION[config::$db_prefix.'banner']['banner_images']) > 6) {
					$this->errorsArray[] = 'You have uploaded to many images, remove one or more to continue.';
				}
			}
		}
		
		//Image Link?
		if(!lib::post('image_link')) { $this->errorsArray[] = 'Please supply a valid image link to continue.'; }
		if(strlen(lib::post('image_link')) > 500) { $this->errorsArray[] = 'Please supply a valid image link to continue.'; }
		
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			
			
			//Lets resize and get that image stored
			require(ROOT.'/classes/simpleimage.class.php');
			
			//Image Directory
			$this->image_dir = ROOT.'/uploads/banner_images';
			
			//Move File to Temp Directory
			move_uploaded_file(@$_FILES['banner-images']['tmp_name'], $this->image_dir.'/temp_images/'.@$_FILES['banner-images']['name']);
			
			//Unique Image Name
			$this->unique_name = session::data('user_id').'-'.preg_replace('/[. ]+/', '-', microtime()).'.jpg';
			
			//Load Simple Image Class
			$image = new \claviska\SimpleImage();
			
			//Magic!
			@$image
			  ->fromFile($this->image_dir.'/temp_images/'.@$_FILES['banner-images']['name']) // load image.jpg
			  //->resize(360,960)
			  // resize to 320x200 pixels
			  /* ->overlay('watermark.png', 'bottom right')  // add a watermark image */
			  ->toFile($this->image_dir.'/'.$this->unique_name, 'image/jpg');      // convert to PNG and save a copy to new-image.png
						 
			//@Unlink
			@unlink($this->image_dir.'/temp_images/'.@$_FILES['banner-images']['name']);
						
			//Insert Image
			db::query("INSERT INTO `".config::$db_prefix."banners_images` (`image_bannerid`,`image_name`,`image_link`) VALUES ('".lib::get('banner_id',true)."','".db::mss($this->unique_name)."','".lib::post('image_link',true)."')");
									
			//Return Data
			return json_encode(array('success' => true, 'image-name' => $this->unique_name));
			
		}
		
		
	}
	
	//Delete Banner 
	public function deleteImage() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the advert even exist?
		if(db::nRows("SELECT `image_id` FROM `".config::$db_prefix."banners_images` WHERE `image_id`='".lib::get('image_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please enter a valid image ID to continue.';	
		}
		
		//Do we have any errors
		if(count($this->errorsArray)) {
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Load Advert
			$this->ImageData = db::fetchQuery("SELECT `image_name`,`image_id` FROM `".config::$db_prefix."banners_images` WHERE `image_id`='".lib::get('image_id',true)."'");
			
			//Remove All Images
			@unlink(ROOT.'/uploads/banner_images/'.$this->ImageData['image_name']);
			db::query("DELETE FROM `".config::$db_prefix."banners_images` WHERE `image_id`='".$this->ImageData['image_id']."'");
			
		}
		
	}
	
	
	
	
	
	
}