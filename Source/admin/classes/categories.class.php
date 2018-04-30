<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class categories {
	
	//Delete Category
	public function deleteCategory() {
		
		//Any errors?
		$this->errorsArray = array();
		
		//Does it exist?
		if(db::nRows("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::get('cat_id',true)."'") < 1) {
			$this->errorsArray[] = 'We are missing a valid category ID to continue.';	
		}
		
		//Does it contain products?
		if(db::nRows("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_catid`='".lib::get('cat_id',true)."' OR `advert_subcatid`='".lib::get('cat_id',true)."'") > 0) {
			$this->errorsArray[] = 'This category contains products and can not be deleted.';
		}
			
		//Do we have any issues?
		if(count($this->errorsArray)) {
			return $this->errorsArray[0];
		} else {
			
			//Load Data
			$this->catData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::get('cat_id',true)."'");
			
			//Image Directory
			$this->image_dir = ROOT.'/uploads/cat_images';
					
			//Delete Old Image
			@unlink($this->image_dir.'/'.$this->catData['cat_image']);
			
			//Delete Category
			db::query("DELETE FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::get('cat_id',true)."'");
			
		}
		
	}
	
	//Create Category
	public function createCategory() {
		
		//Any errors?
		$this->errorsArray = array();
				
		//Do we have a valid category?
		if(lib::post('cat_id')) {
			if(db::nRows("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::post('cat_id',true)."'") < 1) {
				$this->errorsArray[] = 'We are missing a valid category ID to continue.';	
			}
		}
		
		//Do we have an image?
		if(!lib::post('cat_id')) {
			if(@$_FILES['cat_image']['tmp_name']) {
				
				//Allowed Image Types
				$this->allowedImageTypes = array('image/jpg','image/jpeg','image/png','image/gif');
				$this->maxSize = 2097152;
				$this->minWidth = 554;
				$this->minHeight = 194;
				
				// Check atleast one image has been selected
				if(@$_FILES['cat_image']['tmp_name']== ""){
					$this->errorsArray[] = 'Please select an image to upload.';
				}
						
				// Check Images are valid image types
				if(!in_array(@$_FILES['cat_image']['type'], $this->allowedImageTypes)){
					$this->errorsArray[] = 'One or more images are not supported. Please check and try again.';
				}
				
				// Check images are valid sizes
				if(@$_FILES['cat_image']['size'] > $this->maxSize){
					$this->errorsArray[] = 'One or more of your images exceeds the max file size, please reduce the image file size to continue.';
				}
				
				// Get image width and height
				$this->image_dimensions = @getimagesize(@$_FILES['cat_image']['tmp_name']); // returns an array of image info [0] = width, [1] = height
				$this->image_width = $this->image_dimensions[0]; // Image width
				$this->image_height = $this->image_dimensions[1]; // Image height
				if(($this->image_width < $this->minWidth) || ($this->image_height < $this->minHeight)){
					$this->errorsArray[] = 'One or more of your images does not meet the minimum height and minimum width requirements. - '.@$_FILES['cat_image']['name'];
				}
			}
		}
		
		//Do we have any issues?
		if(count($this->errorsArray)) {
			return $this->errorsArray[0];
		} else {
			
			//Create Category
			if(!lib::post('cat_id')) {
				db::query("INSERT INTO `".config::$db_prefix."categories` (`cat_name`) VALUES ('".lib::post('cat_title',true)."')");
			} else {
				db::query("INSERT INTO `".config::$db_prefix."categories` (`cat_name`,`cat_parentid`) VALUES ('".lib::post('cat_title',true)."','".lib::post('cat_id',true)."')");
			}
			
			//Load Data
			$this->catData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::post('subcat_id',true)."' ORDER BY `cat_id` DESC LIMIT 0,1");
			
			//Do we have an image?
			if(!lib::post('cat_id')) {
				if(@$_FILES['cat_image']['tmp_name']) {
							
					//Lets resize and get that image stored
					require(ROOT.'/classes/simpleimage.class.php');
									
					//Image Directory
					$this->image_dir = ROOT.'/uploads/cat_images';
					
					//Delete Old Image
					@unlink($this->image_dir.'/'.$this->catData['cat_image']);
					
					//Move File to Temp Directory
					move_uploaded_file(@$_FILES['cat_image']['tmp_name'], $this->image_dir.'/temp_images/'.@$_FILES['cat_image']['name']);
					
					//Unique Image Name
					$this->unique_name = $this->catData['cat_id'].'-'.preg_replace('/[. ]+/', '-', microtime()).'.jpg';
					
					//Load Simple Image Class
					$image = new \claviska\SimpleImage();
					
					//Magic!
					@$image
					  ->fromFile($this->image_dir.'/temp_images/'.@$_FILES['cat_image']['name']) // load image.jpg
					  //->resize(360,960)
					  // resize to 320x200 pixels
					  /* ->overlay('watermark.png', 'bottom right')  // add a watermark image */
					  ->toFile($this->image_dir.'/'.$this->unique_name, 'image/jpg');      // convert to PNG and save a copy to new-image.png
								 
					//@Unlink
					@unlink($this->image_dir.'/temp_images/'.@$_FILES['advert-images']['name']);
					
					//Update Image
					if(lib::post('sub_catid')) {
						db::query("UPDATE `".config::$db_prefix."categories` SET `cat_image`='".db::mss($this->unique_name)."' WHERE `cat_id`='".lib::post('sub_catid',true)."'");
					} else {
						db::query("UPDATE `".config::$db_prefix."categories` SET `cat_image`='".db::mss($this->unique_name)."' WHERE `cat_id`='".lib::post('cat_id',true)."'");
					}
					
				}
			}
			
			
		}
		
		
			
	}
	
	//Edit Category
	public function editCategory() {
		
		//Any errors?
		$this->errorsArray = array();
				
		//Do we have a valid category?
		if(db::nRows("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::post('cat_id',true)."'") < 1) {
			$this->errorsArray[] = 'We are missing a valid category ID to continue.';	
		} else {
			
			//Do we have a sub cat?
			if(lib::post('sub_catid')) {
				if(db::nRows("SELECT `cat_id` FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::post('sub_catid',true)."'") < 1) {
					$this->errorsArray[] = 'That sub-cat does not exist, what are you doing huh?';
				}
			}
			
		}
		
		//Do we have an image?
		if(!lib::post('sub_catid')) {
			if(@$_FILES['cat_image']['tmp_name']) {
				
				//Allowed Image Types
				$this->allowedImageTypes = array('image/jpg','image/jpeg','image/png','image/gif');
				$this->maxSize = 2097152;
				$this->minWidth = 554;
				$this->minHeight = 194;
				
				// Check atleast one image has been selected
				if(@$_FILES['cat_image']['tmp_name']== ""){
					$this->errorsArray[] = 'Please select an image to upload.';
				}
						
				// Check Images are valid image types
				if(!in_array(@$_FILES['cat_image']['type'], $this->allowedImageTypes)){
					$this->errorsArray[] = 'One or more images are not supported. Please check and try again.';
				}
				
				// Check images are valid sizes
				if(@$_FILES['cat_image']['size'] > $this->maxSize){
					$this->errorsArray[] = 'One or more of your images exceeds the max file size, please reduce the image file size to continue.';
				}
				
				// Get image width and height
				$this->image_dimensions = @getimagesize(@$_FILES['cat_image']['tmp_name']); // returns an array of image info [0] = width, [1] = height
				$this->image_width = $this->image_dimensions[0]; // Image width
				$this->image_height = $this->image_dimensions[1]; // Image height
				if(($this->image_width < $this->minWidth) || ($this->image_height < $this->minHeight)){
					$this->errorsArray[] = 'One or more of your images does not meet the minimum height and minimum width requirements. - '.@$_FILES['cat_image']['name'];
				}
			}
		}
		
		//Do we have any issues?
		if(count($this->errorsArray)) {
			return $this->errorsArray[0];
		} else {
			
			//Update Category
			if(lib::post('sub_catid')) {
				db::query("UPDATE `".config::$db_prefix."categories` SET `cat_name`='".lib::post('cat_title',true)."', `cat_parentid`='".lib::post('cat_id',true)."' WHERE `cat_id`='".lib::post('sub_catid',true)."'");
				$this->catData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::post('subcat_id',true)."'");
			} else {
				db::query("UPDATE `".config::$db_prefix."categories` SET `cat_name`='".lib::post('cat_title',true)."' WHERE `cat_id`='".lib::post('cat_id',true)."'");
				$this->catData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::post('cat_id',true)."'");
			}
			
			//Do we have an image?
			if(!lib::post('sub_catid')) {
				if(@$_FILES['cat_image']['tmp_name']) {
							
					//Lets resize and get that image stored
					require(ROOT.'/classes/simpleimage.class.php');
									
					//Image Directory
					$this->image_dir = ROOT.'/uploads/cat_images';
					
					//Delete Old Image
					@unlink($this->image_dir.'/'.$this->catData['cat_image']);
					
					//Move File to Temp Directory
					move_uploaded_file(@$_FILES['cat_image']['tmp_name'], $this->image_dir.'/temp_images/'.@$_FILES['cat_image']['name']);
					
					//Unique Image Name
					$this->unique_name = $this->catData['cat_id'].'-'.preg_replace('/[. ]+/', '-', microtime()).'.jpg';
					
					//Load Simple Image Class
					$image = new \claviska\SimpleImage();
					
					//Magic!
					@$image
					  ->fromFile($this->image_dir.'/temp_images/'.@$_FILES['cat_image']['name']) // load image.jpg
					  //->resize(360,960)
					  // resize to 320x200 pixels
					  /* ->overlay('watermark.png', 'bottom right')  // add a watermark image */
					  ->toFile($this->image_dir.'/'.$this->unique_name, 'image/jpg');      // convert to PNG and save a copy to new-image.png
								 
					//@Unlink
					@unlink($this->image_dir.'/temp_images/'.@$_FILES['advert-images']['name']);
					
					//Update Image
					if(lib::post('sub_catid')) {
						db::query("UPDATE `".config::$db_prefix."categories` SET `cat_image`='".db::mss($this->unique_name)."' WHERE `cat_id`='".lib::post('sub_catid',true)."'");
					} else {
						db::query("UPDATE `".config::$db_prefix."categories` SET `cat_image`='".db::mss($this->unique_name)."' WHERE `cat_id`='".lib::post('cat_id',true)."'");
					}
					
				}
			}
			
			
		}
		
		
			
	}
	
	
}