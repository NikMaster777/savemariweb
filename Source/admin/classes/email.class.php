<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class email {
	
	//@Delete Template
	public function deleteTemplate() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Lock Feature
		$this->errorsArray[] = 'This feature has been disabled, please contact the developer.';
		
		//Does the template exist?
		if(db::nRows("SELECT `template_id` FROM `".config::$db_prefix."email_templates` WHERE `template_id`='".lib::get('template_id',true)."'") < 1) {
			$this->errorsArray[] = 'Sorry, we could not find an email template matching the ID you provided.';	
		} else {
			$template = db::fetchQuery("SELECT `template_id` FROM `".config::$db_prefix."email_templates` WHERE `template_id`='".lib::get('template_id',true)."'");
		}
		
		//Is System?
		if($template['template_default']) {
			$this->errorsArray[] = 'Sorry, you can not delete a system email template.';	
		}
				
		//Do we have any problems?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' deleted an email template. ('.lib::get('template_id',true).')','admin');
			db::query("DELETE FROM `".config::$db_prefix."email_templates` WHERE `template_id`='".lib::get('template_id',true)."'");
		}
		
	}
	
	//@Add Template
	public function editTemplate() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Lock Feature
		//$this->errorsArray[] = 'This feature has been disabled, please contact the developer.';
		
		//Does the template exist?
		if(db::nRows("SELECT `template_id` FROM `".config::$db_prefix."email_templates` WHERE `template_id`='".lib::post('template_id',true)."'") < 1) {
			$this->errorsArray[] = 'Sorry, we could not find an email template matching the ID you provided.';	
		}
			
		//Validate Name
		if(!lib::post('template_name')) { $this->errorsArray[] = 'Please enter a name for your template below.'; }
		if(strlen(lib::post('template_name')) > 100) { $this->errorsArray[] = 'Your template name must be less than 100 characters long.'; }
		
		//Validate Subject
		if(!lib::post('template_subject')) { $this->errorsArray[] = 'Please enter a subject for your template below.'; }
		if(strlen(lib::post('template_subject')) > 100) { $this->errorsArray[] = 'Your template subject must be less than 100 characters long.'; }
		
		//Validate Description
		if(!lib::post('template_description')) { $this->errorsArray[] = 'Please enter a description for your new template below.'; }
		if(strlen(lib::post('template_description')) > 100) { $this->errorsArray[] = 'Your template description must be less than 100 characters long.'; }
		
		//Validate HTML
		if(!lib::post('template_html')) { $this->errorsArray[] = 'You must add HTML to your new template to continue.'; }
		if(strlen(lib::post('template_html')) > 150000) { $this->errorsArray[] = 'Your template HTML must be less than 15000 long.'; }
		
		//Do we have any problems?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' edited an email template. ('.lib::get('template_id',true).')','admin');
			db::query("UPDATE `".config::$db_prefix."email_templates` SET `template_name`='".lib::post('template_name',true)."',`template_subject`='".lib::post('template_subject',true)."', `template_description`='".lib::post('template_description',true)."', `template_html`='".lib::post('template_html',true,false,false,150000)."' WHERE `template_id`='".lib::post('template_id',true)."'");
		}
		
	}
	
	//@Add Template
	public function addTemplate() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Lock Feature
		//$this->errorsArray[] = 'This feature has been disabled, please contact the developer.';
		
		//Validate Name
		if(!lib::post('template_name')) { $this->errorsArray[] = 'Please enter a name for your template below.'; }
		if(strlen(lib::post('template_name')) > 100) { $this->errorsArray[] = 'Your template name must be less than 100 characters long.'; }
		
		//Validate Subject
		if(!lib::post('template_subject')) { $this->errorsArray[] = 'Please enter a subject for your template below.'; }
		if(strlen(lib::post('template_subject')) > 100) { $this->errorsArray[] = 'Your template subject must be less than 100 characters long.'; }
		
		//Validate Description
		if(!lib::post('template_description')) { $this->errorsArray[] = 'Please enter a description for your new template below.'; }
		if(strlen(lib::post('template_description')) > 100) { $this->errorsArray[] = 'Your template description must be less than 100 characters long.'; }
		
		//Validate HTML
		if(!lib::post('template_html')) { $this->errorsArray[] = 'You must add HTML to your new template to continue.'; }
		if(strlen(lib::post('template_html')) > 15000) { $this->errorsArray[] = 'Your template HTML must be less than 15000 long.'; }
		
		//Do we have any problems?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' added an email template. ('.lib::post('template_name',true).')','admin');
			db::query("INSERT INTO `".config::$db_prefix."email_templates` (`template_name`,`template_subject`, `template_description`, `template_html`) VALUES ('".lib::post('template_name',true)."','".lib::post('template_subject',true)."','".lib::post('template_description',true)."','".lib::post('template_html',true)."')");
		}
		
	}
	
	//@Preview Window
	public function previewWindow() {
		$this->previewHTML = '';
		$this->previewHTML .= lib::getSetting('General_EmailHeader');
		$this->previewHTML .= lib::getSetting('General_EmailFooter');
		$this->previewHTML =  str_replace('<!--LOGO-->',lib::getSetting('General_LogoURL'),$this->previewHTML);
		return $this->previewHTML;
	}
	
	//@Save Header/Footer
	public function updateHeaderFooter() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Header Validation
		if(lib::post('email_header')) {
			if(strlen(lib::post('email_header')) > 15000) {
				$this->errorsArray[] = 'Your email header must be less than 15000 characters long.';
			}
		}
		
		//Footer Validation
		if(lib::post('email_footer')) {
			if(strlen(lib::post('email_footer')) > 15000) {
				$this->errorsArray[] = 'Your email header must be less than 15000 characters long.';
			}
		}
		
		//Do we have any problems?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' updated email template header and footer HTML.','admin');
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('email_footer',true)."' WHERE `setting`='General_EmailFooter'");
			db::query("UPDATE `".config::$db_prefix."settings` SET `value`='".lib::post('email_header',true)."' WHERE `setting`='General_EmailHeader'");
		}
		
	}
	
	
}