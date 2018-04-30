<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class stores {
	
	//@Mark Product as Paid-out
	//This marks a product as paid out.
	public function markPaid() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the product exist for this store?
		if(db::nRows("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::post('product_id',true)."' AND `advert_store`='1'") < 1) {
			$this->errorsArray[] = 'Please select a valid product to purchase.';	
		}
		
		//Do we have any issues?
		if(count($this->errorsArray)) {
			return $this->errorsArray[0];	
		} else {
			db::query("UPDATE `".config::$db_prefix."adverts` SET `advert_paidout`='1' WHERE `advert_id`='".lib::post('product_id',true)."' AND `advert_store`='1'");
		}
		
	}
	
	//@Edit Store
	//Allows the user to edit their store.
	public function deleteStore() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the store exist?
		if(db::nRows("SELECT `store_id` FROM `".config::$db_prefix."stores` WHERE `store_id`='".lib::post('store_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please provide a valid store ID to continue.';	
		}
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return $this->errorsArray[0];
		} else {
			
			//Load Store
			$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_id`='".lib::post('store_id',true)."'");
			
			//Remove Banners
			$bannerSQL = db::query("SELECT * FROM `".config::$db_prefix."store_banners` WHERE `banner_storeid`='".lib::post('store_id',true)."'");
			while($bannerData = db::fetch($bannerSQL)) {
				@unlink(ROOT.'/uploads/store_images/'.$bannerData['banner_image']);
			}
			
			//Remove Logo
			@unlink(ROOT.'/uploads/store_images/'.$store['store_logo']);
			
			//Remove Products/Adverts
			$productSQL = db::query("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_storeid`='".lib::post('store_id',true)."' AND `advert_store`='1'");
			while($productData = db::fetch($productSQL)) {
				
				//Load Stat/Remove
				db::query("DELETE FROM `".config::$db_prefix."advert_hitviews` WHERE `stat_advertid`='".$productData['advert_id']."'");
				db::query("DELETE FROM `".config::$db_prefix."advert_uniqueviews` WHERE `stat_advertid`='".$productData['advert_id']."'");
				
				//Load Image/Remove
				$productImageSQL = db::query("SELECT * FROM `".config::$db_prefix."advertimages` WHERE `image_advertid`='".$productData['advert_id']."'");
				while($productImageData = db::fetch($productImageSQL)) {
					@unlink(ROOT.'/uploads/advert_images/'.$productImageData['image_name']);
					db::query("DELETE FROM `".config::$db_prefix."advertimages` WHERE `image_advertid`='".$productData['advert_id']."'");
				}	
			}
			
			//Remove Records
			db::query("DELETE FROM `".config::$db_prefix."adverts` WHERE `advert_storeid`='".lib::post('store_id',true)."' AND `advert_store`='1'");
			db::query("DELETE FROM `".config::$db_prefix."invoices` WHERE `invoice_type`='2' AND `invoice_typeid`='".lib::post('store_id',true)."'");
			
			db::query("DELETE FROM `".config::$db_prefix."redeem` WHERE `redeem_storeid`='".lib::post('store_id',true)."'");
			db::query("DELETE FROM `".config::$db_prefix."reviewcodes` WHERE `code_storeid`='".lib::post('store_id',true)."'");
			db::query("DELETE FROM `".config::$db_prefix."reviews` WHERE `review_storeid`='".lib::post('store_id',true)."'");
			
			db::query("DELETE FROM `".config::$db_prefix."stores` WHERE `store_id`='".lib::post('store_id',true)."'");
			db::query("DELETE FROM `".config::$db_prefix."store_banners` WHERE `banner_storeid`='".lib::post('store_id',true)."'");
			db::query("DELETE FROM `".config::$db_prefix."store_categories` WHERE `cat_storeid`='".lib::post('store_id',true)."'");
			db::query("DELETE FROM `".config::$db_prefix."store_fields` WHERE `field_storeid`='".lib::post('store_id',true)."'");
			db::query("DELETE FROM `".config::$db_prefix."store_fields_options` WHERE `option_storeid`='".lib::post('store_id',true)."'");
			db::query("DELETE FROM `".config::$db_prefix."store_fields_values` WHERE `field_storeid`='".lib::post('store_id',true)."'");
			db::query("DELETE FROM `".config::$db_prefix."store_users` WHERE `user_storeid`='".lib::post('store_id',true)."'");
			
		}
		
	}
	
	//@Edit Store
	//Allows the user to edit their store.
	public function editStore() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the store exist?
		if(db::nRows("SELECT `store_id` FROM `".config::$db_prefix."stores` WHERE `store_id`='".lib::post('store_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please provide a valid store ID to continue.';	
		}
		
		//Do we have a store title?
		if(!lib::post('store_title')) { $this->errorsArray[] = 'Please enter a store title below to continue.'; }
		if(strlen(lib::post('store_title')) > 80) { $this->errorsArray[] = 'Your store title must be less than 80 characters long.';}
		
		//Description
		if(!lib::post('store_description')) { $this->errorsArray[] = 'Please enter a store description below.'; }
		if(strlen(lib::post('store_description')) > 1500) { $this->errorsArray[] = 'Your store description must be less than 1500 characters long.'; }
		
		//Store Keywords
		if(!lib::post('store_keywords')) { $this->errorsArray[] = 'Please enter a store description below.'; }
		if(strlen(lib::post('store_keywords')) > 500) { $this->errorsArray[] = 'Your store keywords must be less than 500 characters long.';}
		
		//Store About Us
		if(!lib::post('store_aboutus')) { $this->errorsArray[] = 'Please enter some text for your "About Us" page, this will be displayed to your customers.';}
		if(strlen(lib::post('store_aboutus')) > 1500) { $this->errorsArray[] = 'Your store about us text must be less than 1500 characters long.';}
		
		//Store Email
		if(!lib::post('store_email')) { $this->errorsArray[] = 'Please provide an email address for your store, this will allow customers to contact you.'; }
		if(!filter_var(lib::post('store_email'), FILTER_VALIDATE_EMAIL)) { $this->errorsArray[] = 'Please provide a valid store email address to continue.'; }
		
		//Store Address
		if(!lib::post('store_address')) {  
			if(strlen(lib::post('store_address')) > 500) { $this->errorsArray[] = 'Your store address must be less than 500 characters long.'; }
		}
		
		//Store Phone
		if(lib::post('store_phone')) { 
			if(strlen(lib::post('store_phone')) > 15) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
			if(!preg_match('/^[0-9\s+]+$/',lib::post('store_phone'))) { $this->errorsArray[] = 'Please provide a valid phone number below.'; }
		}
		
		//Twitter URL
		if(lib::post('store_twitter')) {
			if(strlen(lib::post('store_twitter')) > 100) { $this->errorsArray[] = 'Please provide a valid twitter url below.'; }
			if(!strstr(lib::post('store_twitter'), 'twitter.com')) { $this->errorsArray[] = 'Please provide a valid twitter url below.'; }
		}
		
		//Facebook URL
		if(lib::post('store_facebook')) {
			if(strlen(lib::post('store_facebook')) > 100) { $this->errorsArray[] = 'Please provide a valid facebook url below.'; }
			if(!strstr(lib::post('store_facebook'), 'facebook.com')) { $this->errorsArray[] = 'Please provide a valid facebook url below.'; }
		}
		
		//Google URL
		if(lib::post('store_google')) {
			if(strlen(lib::post('store_google')) > 100) { $this->errorsArray[] = 'Please provide a valid google url below.'; }
			if(!strstr(lib::post('store_google'), 'google.com')) { $this->errorsArray[] = 'Please provide a valid google url below.'; }
		}
		
		//Payment Method
		if(!lib::post('store_paymentmethod')) { $this->errorsArray[] = 'Please provide a payment method below so we can pay you.'; }
		if(strlen(lib::post('store_paymenthod')) > 1000) { $this->errorsArray[] = 'Please provide a valid payment method below.'; }
		
		//Store Activated
		if(!in_array(lib::post('store_activated'), array(0,1))) { $this->errorsArray[] = 'Please use a valid value for store activation.'; }
		
		//Do we have any errors?
		if(count($this->errorsArray)) {
			return $this->errorsArray[0];
		} else {
						
			//Create a store
			db::query("UPDATE `".config::$db_prefix."stores` SET 
																   `store_title`='".lib::post('store_title',true)."',
																   `store_description`='".lib::post('store_description',true)."',
																   `store_keywords`='".lib::post('store_keywords',true)."',
																   `store_aboutus`='".lib::post('store_aboutus',true)."',
																   `store_email`='".lib::post('store_email',true)."',
																   `store_address`='".lib::post('store_address',true)."',
																   `store_phone`='".lib::post('store_phone',true)."',
																   `store_twitter`='".lib::post('store_twitter',true)."',
																   `store_facebook`='".lib::post('store_facebook',true)."',
																   `store_google`='".lib::post('store_google',true)."',
																   `store_paymentmethod`='".lib::post('store_paymentmethod',true)."',
																   `store_activated`='".lib::post('store_activated',true)."',
																   `store_menu_color`='".lib::post('menu-color',true)."',
																   `store_item_background_active`='".lib::post('item-background-active',true)."',
																   `store_item_font_color_active`='".lib::post('item-font-color-active',true)."',
																   `store_item_font_color_normal`='".lib::post('item-font-color-normal',true)."'
																   
																   WHERE `store_id`='".lib::post('store_id',true)."'");
			
			
		}
	}
	
	
}