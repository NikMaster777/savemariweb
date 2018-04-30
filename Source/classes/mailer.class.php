<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class mailer {
	
	//Automated Mailer
	public function autoMarketer() {
		
		//Does the account exist in the database?
		//if(db::nRows("
		
		
		
		
		
			
	}
	
	public $to;
	public $subject;
	public $message;
	public $html;
	public $email_footer;
	public $email_header;
	public $headers;
	public $user_id;
	public $userData;
	
	//Build Template
	public function __construct($to , $subject = '', $message = '', $user_id = 0) {
		$this->to = $to;
		$this->user_id = $user_id;
		$this->subject = $this->parse($subject,$this->user_id);
		$this->message = $this->parse($message,$this->user_id);
		$this->email_header = $this->parse(lib::getSetting('General_EmailHeader'),$this->user_id);
		$this->email_footer = $this->parse(lib::getSetting('General_EmailFooter'),$this->user_id);
	}
	
	//Provide User Data
	public function userData($user_id, $value) {
						
		//Have we already requested the same data?
		if(isset($this->userData) && is_array($this->userData) && count($this->userData) > 0) {
			$this->userData = $this->userData;			
		} else {
			$this->userData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."clients` WHERE `user_id`='".db::mss($user_id)."'");
		}
		
		//If user country is requested, send the country name!
		switch($value) {
			case 'user_country': {
				$this->userData = db::fetchQuery("SELECT `country_name` FROM `".config::$db_prefix."countries` WHERE `country_id`='".db::mss($this->userData['user_country'])."'");
				if(isset($this->userData[$value])) { 
					return $this->userData[$value]; 
				}
				break;	
			}
			default: {
				if(isset($this->userData[$value])) { 
					return $this->userData[$value]; 
				}
				break;	
			}
		}
		
	}
	
	public function parse($html, $user_id = 0) {
		
		//Basic Vars
		$this->template = $html;
		$this->template = str_replace('<!--DOMAIN-->', DOMAIN, $this->template);
		$this->template = str_replace('<!--LOGO-->', lib::getSetting('General_LogoURL'), $this->template);
		$this->template = str_replace('<!--PHONENUMBER-->', lib::getSetting('General_PhoneNumber'), $this->template);
		$this->template = str_replace('<!--COMPANYNAME-->', lib::getSetting('General_CompanyName'), $this->template);
		$this->template = str_replace('<!--COMPANYEMAIL-->', lib::getSetting('General_DefaultSender'), $this->template);
		
		//Customer Data
		$this->template = str_replace('<!--USER_FIRSTNAME-->', $this->userData($user_id, 'user_firstname'), $this->template);	
		$this->template = str_replace('<!--USER_LASTNAME-->', $this->userData($user_id, 'user_lastname'), $this->template);	
		$this->template = str_replace('<!--USER_EMAILADDRESS-->', $this->userData($user_id, 'user_emailaddress'), $this->template);	
		$this->template = str_replace('<!--USER_ADDRESS1-->', $this->userData($user_id, 'user_address1'), $this->template);	
		$this->template = str_replace('<!--USER_ADDRESS2-->', $this->userData($user_id, 'user_address2'), $this->template);	
		$this->template = str_replace('<!--USER_CITY-->', $this->userData($user_id, 'user_city'), $this->template);	
		$this->template = str_replace('<!--USER_STATE-->', $this->userData($user_id, 'user_state'), $this->template);	
		$this->template = str_replace('<!--USER_POSTCODE-->', $this->userData($user_id, 'user_postcode'), $this->template);
		$this->template = str_replace('<!--USER_PHONENUMBER-->', $this->userData($user_id, 'user_phonenumber'), $this->template);
		$this->template = str_replace('<!--USER_COUNTRY-->', $this->userData($user_id, 'user_country'), $this->template);
		$this->template = str_replace('<!--USER_COMPANYNAME-->', $this->userData($user_id, 'user_companyname'), $this->template);
		
		return $this->template;
		
	}
	
	//Send Message
	public function send() {
		
		// Always set content-type when sending HTML email
		$this->headers = "MIME-Version: 1.0" . "\r\n";
		$this->headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		// More headers
		$this->headers .= 'From: '.lib::getSetting('General_CompanyName').' <'.lib::getSetting('General_DefaultSender').'>' . "\r\n";
				
		//Send Mail
		mail($this->to,$this->subject,$this->email_header.$this->message.$this->email_footer,$this->headers);
		
	}
	
	
	
}