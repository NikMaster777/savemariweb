<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class auth {
	
	//@Login
	//Are we logging in?
	public function login() { 
	
		//@Errors Array
		//A place to store errors
		$this->errorsArray = array();
		
		//Validate Formfields
		if(!lib::post('user_emailaddress')) { $this->errorsArray[] = 'Please enter your email address below.'; }
		if(!lib::post('user_password')) { $this->errorsArray[] = 'Please enter your password below.'; }
		if(strlen(lib::post('user_emailaddress')) > 255) { $this->errorsArray[] = 'Please enter your email address below.'; }
		if(strlen(lib::post('user_password')) > 255) { $this->errorsArray[] = 'Please enter your password below.'; }
		
		//Does the account exist?
		if(db::nRows("SELECT `user_emailaddress` FROM `".config::$db_prefix."clients` WHERE `user_emailaddress`='".lib::post('user_emailaddress', true)."'") < 1) {
			$this->errorsArray[] = 'Sorry, the account your looking for does not exist.';	
		} else {
					
			//Does the username and password match?
			$this->account = db::fetchQuery("SELECT `user_id`,`user_password`,`user_disabled`,`user_activated` FROM `".config::$db_prefix."clients` WHERE `user_emailaddress`='".lib::post('user_emailaddress', true)."'");
			if(!password_verify(lib::post('user_password', true), $this->account['user_password'])) {
				$this->errorsArray[] = 'Sorry, the email address or password provided is incorrect.';	
			}
			
			//Is it disabled?
			if($this->account['user_disabled'] == 1) { $this->errorsArray[] = 'Your account has been disabled. [E1]'; }
			
			//Activated?
			if($this->account['user_activated'] == 0) { $this->errorsArray[] = 'You have not yet activated your account, please check your emails.'; }
		}
		
		//Anti-Spam Check
		/* if(lib::getSetting('Security_CaptchaEnabled')) {			
			if(lib::post('g-recaptcha-response')) {
				$response=json_decode(@file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".lib::getSetting('Security_CaptchaPrivate')."&response=".lib::post('g-recaptcha-response')."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
				if($response['success'] == false) {
				  $this->errorsArray[] = 'Please click the button below to validate the captcha field.';
				}
			} else {
				$this->errorsArray[] = 'Please click the button below to validate the captcha field.';	
			}
		} */
								
		//Do we have any errors?
		if(count($this->errorsArray) > 0) {			
			//Return Error
			return $this->errorsArray[0];		
		} else {
			//Create Session
			if(lib::post('user_remember')) {
				session::create($this->account['user_id'], true);
			} else {
				session::create($this->account['user_id'], false);
			}
		}
	
	}
	
	//@Activation
	//If we are activating an account
	public function activate() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have an activation code
		if(!lib::get('code',true)) {
			$this->errorsArray[] = 'We was unable to activate your account. Activation code is missing, did you click the link correctly?';	
		}
		
		//Does the code exist?
		if(db::nRows("SELECT `user_activation_code` FROM `".config::$db_prefix."clients` WHERE `user_activation_code`='".lib::get('code',true)."'") < 1) {
			$this->errorsArray[] = 'We was unable to activate your account. The activation code does not exist.';
		} else {
			//Already activated?
			if(db::nRows("SELECT `user_activated` FROM `".config::$db_prefix."clients` WHERE `user_activation_code`='".lib::get('code',true)."' AND `user_activated`='1'") > 0) {
				$this->errorsArray[] = 'We was unable to activate your account. This account has already been activated.';
			}
		}
		
		//Anti-Spam Check
		/* if(lib::getSetting('Security_CaptchaEnabled')) {			
			if(lib::post('g-recaptcha-response')) {
				$response=json_decode(@file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".lib::getSetting('Security_CaptchaPrivate')."&response=".lib::post('g-recaptcha-response')."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
				if($response['success'] == false) {
				  $this->errorsArray[] = 'Please click the button below to validate the captcha field.';
				}
			} else {
				$this->errorsArray[] = 'Please click the button below to validate the captcha field.';	
			}
		} */
				
		//Do we have a problem
		if(count($this->errorsArray)) {
			return $this->errorsArray[0];
		} else {
			
			//Load User Data
			$this->userData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."clients` WHERE `user_activation_code`='".lib::get('code',true)."'");
			
			//Send welcome email
			$this->sendWelcome($this->userData);
			
			//Update account
			db::query("UPDATE `".config::$db_prefix."clients` SET `user_activated`='1',`user_activation_code`='' WHERE `user_activation_code`='".lib::get('code',true)."'");
			
		}
		
	}	
		
	//@Send Welcome
	//Lets give them a warm welcome.
	public function sendWelcome($userData) {
		
		//A place to store errors
		$this->errorsArray = array();
				
		//Load Welcome Template
		$this->template = db::fetchQuery("SELECT * FROM `".config::$db_prefix."email_templates` WHERE `template_id`='1'");
		
		//Build Complete HTML Template
		$this->template_message = $this->template['template_html'];
								
		//Send the message
		$mailer= new mailer($userData['user_emailaddress'], $this->template['template_subject'], $this->template_message, $userData['user_id']);
		$mailer->send();
						
	}
			
	//@Send Activation
	//If the system admin requires account activation, this will be the thing to do!
	public function sendActivation($userData) {
		
		//A place to store errors
		$this->errorsArray = array();
								
		//Generate Activation Link
		$this->activation_code = sha1(time().$userData['user_emailaddress']);
		
		//Store Activation Code
		db::query("UPDATE `".config::$db_prefix."clients` SET `user_activation_code`='".$this->activation_code."' WHERE `user_id`='".db::mss($userData['user_id'])."'");
		
		//Load Activation Template
		$this->template = db::fetchQuery("SELECT * FROM `".config::$db_prefix."email_templates` WHERE `template_id`='8'");
		
		//Build Complete HTML Template
		$this->template_message = $this->template['template_html'];
		$this->template_message = str_replace('<!--USER_ACTIVATION_LINK-->', DOMAIN.'/index.php?page=activation&code='.$this->activation_code, $this->template_message);
								
		//Send the message
		$mailer= new mailer($userData['user_emailaddress'], $this->template['template_subject'], $this->template_message, $userData['user_id']);
		$mailer->send();
						
	}
	
	//@Register
	//Are we creating a new account?
	public function register() { 
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Closed Reg
		//$this->errorsArray[] = 'Registrations are closed at this time!';
		
		//Firstname
		if(!lib::post('user_firstname')) { $this->errorsArray[] = 'Please enter your first name below to continue.'; }
		if(strlen(lib::post('user_firstname')) > 25) { $this->errorsArray[] = 'Your first name can not be more than 25 characters long.'; }
		
		//Lastname
		if(!lib::post('user_lastname')) { $this->errorsArray[] = 'Please enter your last name below to continue.'; }
		if(strlen(lib::post('user_lastname')) > 25) { $this->errorsArray[] = 'Your last name can not be more than 25 characters long.'; }
		
		//Username
		if(!lib::post('user_username')) { $this->errorsArray[] = 'Please choose your username below.'; }
		if(strlen(lib::post('user_username')) > 15) { $this->errorsArray[] = 'Your username must be less than 15 characters long.'; }
		if(db::nRows("SELECT `user_username` FROM `".config::$db_prefix."clients` WHERE `user_username`='".lib::post('user_username',true)."'") > 0) {
			$this->errorsArray[] = 'Sorry, that username has already been taken!';	
		}
				
		//Email Address
		if(!lib::post('user_emailaddress')) { $this->errorsArray[] = 'Please enter your email address below.'; }
		if(strlen(lib::post('user_emailaddress')) > 80) { $this->errorsArray[] = 'Your email address must be less than 80 characters long.'; }
		if(!filter_var(lib::post('user_emailaddress'), FILTER_VALIDATE_EMAIL)) { $this->errorsArray[] = 'Please enter a valid email address below.'; }
		if(db::nRows("SELECT `user_emailaddress` FROM `".config::$db_prefix."clients` WHERE `user_emailaddress`='".lib::post('user_emailaddress',true)."'") > 0) {
			$this->errorsArray[] = 'An account with that email address already exists!';	
		}
				
		//Password
		if(lib::post('user_password')) {
			if(strlen(lib::post('user_password')) > 80) { $this->errorsArray[] = 'The password must be less than 80 characters long.'; }
			if(strlen(lib::post('user_password')) < 4) { $this->errorsArray[] = 'The password must be at least 4 characters long.'; }	
		} else {
			$this->errorsArray[] = 'Please choose a valid password below to continue.';	
		}
		
		//Confirm Password
		if(lib::post('user_password2')) { 
			if(strlen(lib::post('user_password2')) > 80) { $this->errorsArray[] = 'The confirm password must be less than 80 characters long.'; }
			if(strlen(lib::post('user_password2')) < 4) { $this->errorsArray[] = 'The confirm password must be at least 4 characters long.'; }	
			if(lib::post('user_password') != lib::post('user_password2')) { $this->errorsArray[] = 'Your passwords do not match, please check and try again'; }
		} else {
			$this->errorsArray[] = 'Please choose a valid confirm password below to continue.';	
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
				$this->errorsArray[] = 'Your postcode must be less than 10 characters long.';	
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
		
		//Terms and Conditions Check
		if(!lib::post('user_terms')) { 
			$this->errorsArray[] = 'Please accept the terms and conditions to continue.'; 
		}
		
		//Anti-Spam Check
		if(lib::getSetting('Security_CaptchaEnabled')) {			
			if(lib::post('g-recaptcha-response')) {
				$response=json_decode(@file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".lib::getSetting('Security_CaptchaPrivate')."&response=".lib::post('g-recaptcha-response')."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
				if($response['success'] == false) {
				  $this->errorsArray[] = 'Please click the button below to validate the captcha field.';
				}
			} else {
				$this->errorsArray[] = 'Please click the button below to validate the captcha field.';	
			}
		}
				
		//Do we have any problems?
		if(count($this->errorsArray)) {			
			return $this->errorsArray[0];	
		} else {
						
			//Do good stuff.
			db::query("INSERT INTO `".config::$db_prefix."clients` (
																	`user_firstname`,
																	`user_lastname`,
																	`user_username`,
																	`user_emailaddress`,
																	`user_address1`,
																	`user_address2`, 
																	`user_city`,
																	`user_state`,
																	`user_postcode`,
																	`user_country`,
																	`user_password`,
																	`user_created`,
																	`user_ipaddress`
																	)
																	
																	VALUES
																	
																	(
																	'".lib::post('user_firstname',true)."',
																	'".lib::post('user_lastname',true)."',
																	'".lib::post('user_username',true)."',
																	'".lib::post('user_emailaddress',true)."',
																	'".lib::post('user_address1',true)."',
																	'".lib::post('user_address2',true)."', 
																	'".lib::post('user_city',true)."',
																	'".lib::post('user_state',true)."',
																	'".lib::post('user_postcode',true)."',
																	'".lib::post('user_country',true)."',
																	'".password_hash(lib::post('user_password',true), PASSWORD_DEFAULT)."',
																	'".date('Y-m-d')."',
																	'".db::mss($_SERVER['REMOTE_ADDR'])."'
																	)
																	");
			
			//Load Data														
			$this->userData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."clients` WHERE `user_emailaddress`='".lib::post('user_emailaddress',true)."'");
										
			//Lets get an activation email to them
			$this->sendActivation($this->userData);
						
		}
	
	}
	
	//@Forgot Password
	//Have we forgotten the password?
	public function forgot() { 
		
		//@Errors Array
		//A place to store errors
		$this->errorsArray = array();
		
		//Validate Formfields
		if(!lib::post('user_emailaddress')) { $this->errorsArray[] = 'Please enter your email address below.'; }
		if(strlen(lib::post('user_emailaddress')) > 255) { $this->errorsArray[] = 'Please enter your email address below.'; }
		
		//Does the account exist?
		if(db::nRows("SELECT `user_emailaddress` FROM `".config::$db_prefix."clients` WHERE `user_emailaddress`='".lib::post('user_emailaddress', true)."'") < 1) {
			$this->errorsArray[] = 'Sorry, the account your looking for does not exist.';	
		} else {
					
			//Does the username and password match?
			$this->account = db::fetchQuery("SELECT `user_id`,`user_password`,`user_disabled`,`user_activated` FROM `".config::$db_prefix."clients` WHERE `user_emailaddress`='".lib::post('user_emailaddress', true)."'");
			
			//Is it disabled?
			if($this->account['user_disabled'] == 1) { $this->errorsArray[] = 'Your account has been disabled. [E1]'; }
			
			//Activated?
			if($this->account['user_activated'] == 0) { $this->errorsArray[] = 'You have not yet activated your account, please check your emails.'; }
			
		}
		
		//Anti-Spam Check
		/* if(lib::getSetting('Security_CaptchaEnabled')) {			
			if(lib::post('g-recaptcha-response')) {
				$response=json_decode(@file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".lib::getSetting('Security_CaptchaPrivate')."&response=".lib::post('g-recaptcha-response')."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
				if($response['success'] == false) {
				  $this->errorsArray[] = 'Please click the button below to validate the captcha field.';
				}
			} else {
				$this->errorsArray[] = 'Please click the button below to validate the captcha field.';	
			}
		} */
								
		//Do we have any errors?
		if(count($this->errorsArray) > 0) {			
			return $this->errorsArray[0];		
		} else {
			
			//Does the username and password match?
			$this->userData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."clients` WHERE `user_emailaddress`='".lib::post('user_emailaddress', true)."'");
			
			//Generate Activation Link
			$this->activation_code = sha1(time().$this->userData['user_emailaddress']);
			
			//Store Activation Code
			db::query("UPDATE `".config::$db_prefix."clients` SET `user_activation_code`='".$this->activation_code."' WHERE `user_id`='".db::mss($this->userData['user_id'])."'");
			
			//Load Activation Template
			$this->template = db::fetchQuery("SELECT * FROM `".config::$db_prefix."email_templates` WHERE `template_id`='17'");
			
			//Build Complete HTML Template
			$this->template_message = $this->template['template_html'];
			$this->template_message = str_replace('<!--FORGOTPASSWORD_LINK-->', DOMAIN.'/index.php?page=forgotpassword&confirm=change-password&code='.$this->activation_code, $this->template_message);
									
			//Send the message
			$mailer= new mailer($this->userData['user_emailaddress'], $this->template['template_subject'], $this->template_message, $this->userData['user_id']);
			$mailer->send();
			
		}
		
	}
	
	//@Change Password
	//Lets change the users password
	public function forgot_changepassword() {
		
		//@Errors Array
		$this->errorsArray = array();
		
		//Validate Fields
		if(!lib::post('user_password')) { $this->errorsArray[] = 'Please enter a new password below to continue.'; }
		if(strlen(lib::post('user_password')) > 50) { $this->errorsArray[] = 'Your new password must be less than 50 characters long.'; }
		if(!lib::post('user_password2')) { $this->errorsArray[] = 'Please confirm your new password below to continue.'; }
		if(lib::post('user_password') != lib::post('user_password2')) { $this->errorsArray[] = 'Your passwords do not match, please check and try again.'; }
		
		//Validate Hidden Fields
		if(!lib::post('code')) { $this->errorsArray[] = 'Something unexpected happened trying to reset your passsword. [E2]'; }
		if(db::nRows("SELECT `user_activation_code` FROM `".config::$db_prefix."clients` WHERE `user_activation_code`='".lib::post('code',true)."'") < 1) {
			$this->errorsArray[] = 'Something unexpected happened trying to reset your passsword. [E1]';
		}
		
		//Do we have any errors?
		if(count($this->errorsArray) > 0) {			
			return $this->errorsArray[0];		
		} else {
			//Change Password
			db::query("UPDATE `".config::$db_prefix."clients` SET `user_password`='".password_hash(lib::post('user_password',true), PASSWORD_DEFAULT)."' WHERE `user_activation_code`='".lib::post('code',true)."'");
			db::query("UPDATE `".config::$db_prefix."clients` SET `user_activation_code`='' WHERE `user_activation_code`='".lib::post('code',true)."'");
		}
	}
		
}