<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class users {
	
	//@Change Password
	//Allows the user to change password.
	public function changepassword() {
				
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have the old password?
		if(!lib::post('user_password')) { $this->errorsArray[] = 'Please enter the old password to continue.'; }
		if(!password_verify(lib::post('user_password', true), session::data('user_password'))) { $this->errorsArray[] = 'Sorry, the old password is incorrect, try again!'; }
		
		//Check new password
		if(!lib::post('user_password1')) { $this->errorsArray[] = 'Please enter your new password below.'; }
		if(strlen(lib::post('user_password1')) > 80) { $this->errorsArray[] = 'The new password must be less than 80 characters long.'; }
		if(strlen(lib::post('user_password1')) < 4) { $this->errorsArray[] = 'The new password must be at least 4 characters long.'; }	
		
		//Does the passwords match?
		if(lib::post('user_password1') != lib::post('user_password2')) { $this->errorsArray[] = 'Your new passwords do not match, please check and try again.'; }
		
		//Do we have any problems?
		if(count($this->errorsArray)) {			
			return $this->errorsArray[0];	
		} else {
			//Do good stuff.
			db::query("UPDATE `".config::$db_prefix."clients` SET  password='".password_hash(lib::post('user_password1',true), PASSWORD_DEFAULT)."' WHERE `user_id`='".session::data('user_id')."'");
		}
		
		
	}
	
	//@Edit Profile
	//Allows the user to edit their profile :)
	public function editprofile() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Firstname
		if(!lib::post('user_firstname')) { $this->errorsArray[] = 'Please enter your first name below to continue.'; }
		if(strlen(lib::post('user_firstname')) > 25) { $this->errorsArray[] = 'Your first name can not be more than 25 characters long.'; }
		
		//Lastname
		if(!lib::post('user_lastname')) { $this->errorsArray[] = 'Please enter your last name below to continue.'; }
		if(strlen(lib::post('user_lastname')) > 25) { $this->errorsArray[] = 'Your last name can not be more than 25 characters long.'; }
						
		//Email Address
		if(!lib::post('user_emailaddress')) { $this->errorsArray[] = 'Please enter your email address below.'; }
		if(strlen(lib::post('user_emailaddress')) > 80) { $this->errorsArray[] = 'Your email address must be less than 80 characters long.'; }
		if(!filter_var(lib::post('user_emailaddress'), FILTER_VALIDATE_EMAIL)) { $this->errorsArray[] = 'Please enter a valid email address below.'; }
		if(lib::post('user_emailaddress',true) != session::data('user_emailaddress')) { 
			if(db::nRows("SELECT `user_emailaddress` FROM `".config::$db_prefix."clients` WHERE `user_emailaddress`='".lib::post('user_emailaddress',true)."'") > 0) {
				$this->errorsArray[] = 'An account with that email address already exists!';	
			}
		}
									
		//Address 1
		if(lib::post('user_address1')) { 
			if(strlen(lib::post('user_address1')) > 100) {
				$this->errorsArray[] = 'Your address 1 must be less than 100 characters long.';	
			}
		}
		
		//Address 2
		if(lib::post('user_address2')) { 
			if(strlen(lib::post('user_address2')) > 100) {
				$this->errorsArray[] = 'Your address 2 must be less than 100 characters long.';	
			}
		}
		
		//Postcode
		if(lib::post('user_postcode')) {
			if(strlen(lib::post('user_postcode')) > 10) {
				$this->errorsArray[] = 'Your areacode must be less than 10 characters long.';	
			}
		}
		
		//City
		if(!array_key_exists(lib::post('user_city'), lib::getCities())) { $this->errorsArray[] = 'Please select a valid city to continue.'; }
		
		//State/Region
		if(lib::post('user_state')) { 
			if(strlen(lib::post('user_state')) > 100) {
				$this->errorsArray[] = 'Your state must be less than 100 characters long.';	
			}
		}
		
		//Country Validation
		if(!array_key_exists(lib::post('user_country'), lib::getCountries())) { $this->errorsArray[] = 'Please select a valid default country.'; }
		
		//User Phone
		if(lib::post('user_phone')) { 
			if(strlen(lib::post('user_phone')) > 18) {
				$this->errorsArray[] = 'You must enter a valid phone number to continue.';	
			}
			if(!preg_match('/^[0-9 ]+$/',lib::post('user_phone'))) {
				$this->errorsArray[] = 'Please enter a valid phone number to continue.';	
			}
		}
		
		//User Phone
		if(lib::post('user_mobile')) { 
			if(strlen(lib::post('user_mobile')) > 18) {
				$this->errorsArray[] = 'You must enter a valid mobile number to continue.';	
			}
			if(!preg_match('/^[0-9 ]+$/',lib::post('user_mobile'))) {
				$this->errorsArray[] = 'Please enter a valid mobile number to continue.';	
			}
		}
		
		//User Phone
		if(lib::post('user_whatsapp')) { 
			if(strlen(lib::post('user_whatsapp')) > 18) {
				$this->errorsArray[] = 'You must enter a valid whatsapp number to continue.';	
			}
			if(!preg_match('/^[0-9 ]+$/',lib::post('user_whatsapp'))) {
				$this->errorsArray[] = 'Please enter a valid whatsapp number to continue.';	
			}
		}
					
		//Do we have any problems?
		if(count($this->errorsArray)) {			
			return $this->errorsArray[0];	
		} else {
						
			//Do good stuff.
			db::query("UPDATE `".config::$db_prefix."clients` SET `user_firstname`='".lib::post('user_firstname',true)."',
																`user_lastname`='".lib::post('user_lastname',true)."',
																`user_emailaddress`='".lib::post('user_emailaddress',true)."',
																`user_address1`='".lib::post('user_address1',true)."',
																`user_address2`='".lib::post('user_address2',true)."', 
																`user_city`='".lib::post('user_city',true)."',
																`user_state`='".lib::post('user_state',true)."',
																`user_postcode`='".lib::post('user_postcode',true)."',
																`user_country`='".lib::post('user_country',true)."',
																`user_phone`='".lib::post('user_phone',true)."',
																`user_mobile`='".lib::post('user_mobile',true)."',
																`user_whatsapp`='".lib::post('user_whatsapp',true)."',
																`user_ipaddress`='".db::mss($_SERVER['REMOTE_ADDR'])."'
																	
																WHERE `user_id`='".session::data('user_id')."'");
						
		}
		
			
	}
	
	
}