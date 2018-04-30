<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class servers {
		
	//@Remove Port
	//Allows us to remove a server port
	public function removePort() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Single or Multi?
		if(strstr(lib::post('port_id'), ',')) {
			$this->port_ids = explode(',',lib::post('port_id'));
			if(count($this->port_ids)) {
				foreach($this->port_ids AS $this->port) {
					if(!is_numeric($this->port)) { $this->errorsArray[] = 'Invalid Port ID!'; }
					if(db::nRows("SELECT `port_id` FROM `".config::$db_prefix."serverports` WHERE `port_id`='".db::mss($this->port)."' AND `port_system`='0'") < 1) {
						$this->errorsArray[] = 'You can not remove the default ports, please select another port.';	
					}
				}
			}
		} else {
			if(!is_numeric(lib::post('port_id'))) { $this->errorsArray[] = 'Invalid Port ID'; }	
			if(db::nRows("SELECT `port_id` FROM `".config::$db_prefix."serverports` WHERE `port_id`='".lib::post('port_id',true)."' AND `port_system`='0'") < 1) {
				$this->errorsArray[] = 'You can not remove the default ports, please select another port.';	
			}
		}
						
		//Do we have any issues?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' removed a server group port.','admin');
			
			//Single or Multi
			if(strstr(lib::post('port_id'), ',')) {
				$this->port_ids = explode(',',lib::post('port_id'));
				if(count($this->port_ids)) {
					foreach($this->port_ids AS $this->port) {
						db::query("DELETE FROM `".config::$db_prefix."serverports` WHERE `port_id`='".db::mss($this->port)."'");	
					}
				}
			} else {
				db::query("DELETE FROM `".config::$db_prefix."serverports` WHERE `port_id`='".lib::post('port_id',true)."'");	
			}
			
			return json_encode(array('success' => true));
		}
		
	}
	
	//@Add Port
	//Allows us to add a server port
	public function addPort() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have a port name?
		if(!lib::post('port_name')) { $this->errorsArray[] = 'Please enter a valid port name below.'; }
		if(strlen(lib::post('port_name')) > 10) { $this->errorsArray[] = 'Your port name is too long, must be less than 10 characters long.'; }
		
		//Do we have a server port?
		if(!lib::post('port_value')) { $this->errorsArray[] = 'Please enter your server port below.'; }
		if(preg_match('/^[0-9]+\:[0-9]+$/',lib::post('port_value'))) {
			$this->port_range = explode(':', lib::post('port_value'));
			if($this->port_range[0] > 65535 | $this->port_range[1] > 65535) {
				$this->errorsArray[] = 'Your port range can not be more than the max port value of 65535';	
			} else {
				$this->max_range = $this->port_range[0] - $this->port_range[1];
				if($this->max_range > 10) { $this->errorsArray[] = 'The port range can only be between 10 ports only. e.g 80:90'; }
			}
			if(db::nRows("SELECT `port_value` FROM `".config::$db_prefix."serverports` WHERE `port_value`='".lib::post('port_value',true)."'") > 0) {
				$this->errorsArray[] = 'That port range already exists.';	
			}
		} else {
			if(preg_match('/^[0-9]+$/',lib::post('port_value'))) {
				if(lib::post('port_value') > 65535) { $this->errorsArray[] = 'Your port can not be more than the max port value of 65535'; }
				if(db::nRows("SELECT `port_value` FROM `".config::$db_prefix."serverports` WHERE `port_value`='".lib::post('port_value',true)."'") > 0) {
					$this->errorsArray[] = 'That port range already exists.';	
				}
			} else {
				$this->errorsArray[] = 'Please enter a valid port or port range to continue.';	
			}
		}
			
		//Do we have any issues?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' added a server group port.','admin');
			db::query("INSERT INTO `".config::$db_prefix."serverports` (`port_name`,`port_value`) VALUES ('".lib::post('port_name',true)."','".lib::post('port_value',true)."')");
			$this->port = db::fetchQuery("SELECT `port_id` FROM `".config::$db_prefix."serverports` WHERE `port_name`='".lib::post('port_name',true)."' AND `port_value`='".lib::post('port_value',true)."'");
			return json_encode(array('success' => true, 'port_id' => $this->port['port_id']));
		}
	}
	
	//@Delete Server
	//Allows us to remove a server from the system.
	public function deleteServer() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the server exist?
		if(db::nRows("SELECT `server_id` FROM `".config::$db_prefix."servers` WHERE `server_id`='".lib::post('server_id',true)."'") < 1) {
			$this->errorsArray[] = 'We was unable to delete the server.';	
		}
		
		//$this->errorsArray[] = 'Product Check Required!';
		
		//Do we have any issues?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' deleted a server.','admin');
			db::query("DELETE FROM `".config::$db_prefix."servers` WHERE `server_id`='".lib::post('server_id',true)."'");
			db::query("DELETE FROM `".config::$db_prefix."server_fields` WHERE `field_serverid`='".lib::post('server_id',true)."'");	
		}
			
	}
	
	//@Edit Server
	//Allows us to edit a server.
	public function editServer() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the server exist?
		if(db::nRows("SELECT `server_id` FROM `".config::$db_prefix."servers` WHERE `server_id`='".lib::post('server_id',true)."'") < 1) {
			$this->errorsArray[] = 'The server you was looking for does not exist.';	
		} else {
			$this->server = db::fetchQuery("SELECT * FROM `".config::$db_prefix."servers` WHERE `server_id`='".lib::post('server_id',true)."'");
		}	
		
		//Do we have a server name
		if($this->server['server_name'] != lib::post('server_name')) {
			if(!lib::post('server_name')) { $this->errorsArray[] = 'Please enter a name for your server below.'; }
			if(strlen(lib::post('server_name')) > 100) { $this->errorsArray[] = 'Your server name must be less than 100 characters long.'; }
			if(db::nRows("SELECT `server_name` FROM `".config::$db_prefix."servers` WHERE `server_name`='".lib::post('server_name',true)."'") > 0) { 
				$this->errorsArray[] = 'A server with that name already exists, please choose another.';
			}
		}
		
		//Validate Server Group
		if(!lib::post('server_groupid')) { $this->errorsArray[] = 'Please select a valid server group below.'; }
		if(db::nRows("SELECT `group_id` FROM `".config::$db_prefix."servergroups` WHERE `group_id`='".lib::post('server_groupid',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid server group below to continue.';	
		}
		
		//Max Accounts
		if(lib::post('server_maxaccounts') != '') { 
			if(strlen(lib::post('server_maxaccounts')) > 11) { 
				$this->errorsArray[] = 'Please enter a valid max accounts number for the server.'; 
			}
			if(!is_numeric(lib::post('server_maxaccounts'))) {
				$this->errorsArray[] = 'Please enter a valid max accounts number for the server.';	
			}
		} else {
			$this->errorsArray[] = 'Please enter a valid max accounts number for the server.';	
		}
								
		//Load Fields
		$this->f_sql = db::query("SELECT * FROM `".config::$db_prefix."plugin_fields` WHERE `field_pluginid`='".db::mss($this->server['server_pluginid'])."' AND `field_groupid`='2' ORDER BY `field_order` ASC");
		while($this->f_data = db::fetch($this->f_sql)) {
			
			//Field Title
			$this->field_title = lib::post(str_replace(' ','_', $this->f_data['field_title']));
						
			//Switch Types
			switch($this->f_data['field_type']) {
				case 'textfield': {
					if($this->f_data['field_required']) {
						if(!$this->field_title) {
							$this->errorsArray[] = 'The field "'.$this->f_data['field_title'].'" is required.';
						}
					}
					if($this->f_data['field_regex']) {
						if(!preg_match($this->f_data['field_regex'], $this->field_title)) {
							$this->errorsArray[] = 'The value for the field "'.$this->f_data['field_title'].'" is not valid.';	
						}
					}	
					if($this->f_data['field_date']) {
						$this->d_month = date('m', strtotime($this->field_title));
						$this->d_day = date('d', strtotime($this->field_title));
						$this->d_year = date('Y', strtotime($this->field_title));
						if(!checkdate($this->d_month, $this->d_day, $this->d_year)) {
							$this->errorsArray[] = 'Please enter a valid date for the field "'.$this->f_data['field_title'].'"';
						}
					}
					break;	
				}
				case 'textarea': {
					if($this->f_data['field_required']) {
						if(!$this->field_title) {
							$this->errorsArray[] = 'The field "'.$this->f_data['field_title'].'" is required.';
						}
					}
					if($this->f_data['field_regex']) {
						if(!preg_match($this->f_data['field_regex'], $this->field_title)) {
							$this->errorsArray[] = 'The value for the field "'.$this->f_data['field_title'].'" is not valid.';	
						}
					}
					break;	
				}
				case 'select': {
					if($this->f_data['field_required']) {
						if(!lib::post($this->f_data['field_id'])) {
							$this->errorsArray[] = 'The field "'.$this->f_data['field_title'].'" is required.';
						}
					}
					$this->options = explode(',',$this->f_data['field_options']);
					if(!in_array($this->field_title, $this->options)) {
						$this->errorsArray[] = 'Please select a valid option for the field "'.$this->f_data['field_title'].'"';	
					}
					break;	
				}
				case 'checkbox': {
					if($this->f_data['field_required']) {
						if(!$this->field_title) {
							$this->errorsArray[] = 'The field "'.$this->f_data['field_title'].'" is required.';
						}
					}
					break;	
				}
			}	
		}
		
		//Do we have any issues?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' edited a server. ('.lib::post('server_name',true).')','admin');
			
			//Create Server
			db::query("UPDATE `".config::$db_prefix."servers` SET
																	`server_name`='".lib::post('server_name',true)."', 
																	`server_groupid`='".lib::post('server_groupid',true)."', 
																	`server_pluginid`='".lib::post('plugin_id',true)."',
																	`server_maxaccounts`='".lib::post('server_maxaccounts',true)."' 
																	
																	WHERE `server_id`='".lib::post('server_id',true)."'
																
																");
																
			//Load Fields
			$this->f_sql = db::query("SELECT * FROM `".config::$db_prefix."server_fields` WHERE `field_pluginid`='".db::mss($this->server['server_pluginid'])."' AND 
																								`field_serverid`='".db::mss($this->server['server_id'])."'");
			//Loop Fields
			while($this->f_data = db::fetch($this->f_sql)) {
				
				//If button, insert as normal, buttons use "value", we don't need to grab this from the form.
				switch($this->f_data['field_type']) {
					case 'button': {
						
						//Create Field
						db::query("UPDATE `".config::$db_prefix."server_fields` SET
																				
																				 `field_order`='".db::mss($this->f_data['field_order'])."',
																				 `field_cols`='".db::mss($this->f_data['field_cols'])."',
																				 `field_rows`='".db::mss($this->f_data['field_rows'])."',
																				 `field_title`='".db::mss($this->f_data['field_title'])."',
																				 `field_description`='".db::mss($this->f_data['field_description'])."',
																				 `field_type`='".db::mss($this->f_data['field_type'])."',
																				 `field_size`='".db::mss($this->f_data['field_size'])."',
																				 `field_regex`='".db::mss($this->f_data['field_regex'])."',
																				 `field_required`='".db::mss($this->f_data['field_required'])."',
																				 `field_disabled`='".db::mss($this->f_data['field_disabled'])."',
																				 `field_value`='".db::mss($this->f_data['field_value'])."',
																				 `field_placeholder`='".db::mss($this->f_data['field_placeholder'])."',
																				 `field_date`='".db::mss($this->f_data['field_date'])."',
																				 `field_url`='".db::mss($this->f_data['field_url'])."',
																				 `field_function`='".db::mss($this->f_data['field_function'])."',
																				 `field_options`='".db::mss($this->f_data['field_options'])."',
																				 `field_default`='".db::mss($this->f_data['field_default'])."',
																				 `field_checked`='".db::mss($this->f_data['field_checked'])."'
																				 
																				WHERE `field_id`='".db::mss($this->f_data['field_id'])."'
																				
																				");
						
						break;	
					}
					default: {
						
						//Create Field
						db::query("UPDATE `".config::$db_prefix."server_fields` SET
																				
																				 `field_order`='".db::mss($this->f_data['field_order'])."',
																				 `field_cols`='".db::mss($this->f_data['field_cols'])."',
																				 `field_rows`='".db::mss($this->f_data['field_rows'])."',
																				 `field_title`='".db::mss($this->f_data['field_title'])."',
																				 `field_description`='".db::mss($this->f_data['field_description'])."',
																				 `field_type`='".db::mss($this->f_data['field_type'])."',
																				 `field_size`='".db::mss($this->f_data['field_size'])."',
																				 `field_regex`='".db::mss($this->f_data['field_regex'])."',
																				 `field_required`='".db::mss($this->f_data['field_required'])."',
																				 `field_disabled`='".db::mss($this->f_data['field_disabled'])."',
																				 `field_value`='".lib::post(str_replace(' ','_', $this->f_data['field_title']),true)."',
																				 `field_placeholder`='".db::mss($this->f_data['field_placeholder'])."',
																				 `field_date`='".db::mss($this->f_data['field_date'])."',
																				 `field_url`='".db::mss($this->f_data['field_url'])."',
																				 `field_function`='".db::mss($this->f_data['field_function'])."',
																				 `field_options`='".db::mss($this->f_data['field_options'])."',
																				 `field_default`='".db::mss($this->f_data['field_default'])."',
																				 `field_checked`='".db::mss($this->f_data['field_checked'])."'
																				 
																				 WHERE `field_id`='".db::mss($this->f_data['field_id'])."'
																				
																				");

						break;		
					}
																		
				}
				
			}
						
			//Add Server
			return json_encode(array('success' => true));
			
		}
		
	}
	
	//@Add Server
	//Allows us to add a new server!
	public function addServer() {
		
		//A place to store errors
		$this->errorsArray = array();
			
		//Do we have a server name
		if(!lib::post('server_name')) { $this->errorsArray[] = 'Please enter a name for your server below.'; }
		if(strlen(lib::post('server_name')) > 100) { $this->errorsArray[] = 'Your server name must be less than 100 characters long.'; }
		if(db::nRows("SELECT `server_name` FROM `".config::$db_prefix."servers` WHERE `server_name`='".lib::post('server_name',true)."'") > 0) { 
			$this->errorsArray[] = 'A server with that name already exists, please choose another.';
		}
		
		//Validate Server Group
		if(!lib::post('server_groupid')) { $this->errorsArray[] = 'Please select a valid server group below.'; }
		if(db::nRows("SELECT `group_id` FROM `".config::$db_prefix."servergroups` WHERE `group_id`='".lib::post('server_groupid',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid server group below to continue.';	
		}
		
		//Max Accounts
		if(lib::post('server_maxaccounts') != '') { 
			if(strlen(lib::post('server_maxaccounts')) > 11) { 
				$this->errorsArray[] = 'Please enter a valid max accounts number for the server.'; 
			}
			if(!is_numeric(lib::post('server_maxaccounts'))) {
				$this->errorsArray[] = 'Please enter a valid max accounts number for the server.';	
			}
		} else {
			$this->errorsArray[] = 'Please enter a valid max accounts number for the server.';	
		}
					
		//Server Plugin
		if(!lib::post('plugin_id')) { $this->errorsArray[] = 'Please select a server plugin to continue,'; }
		if(db::nRows("SELECT `plugin_id` FROM `".config::$db_prefix."plugins` WHERE `plugin_id`='".lib::post('plugin_id',true)."'") < 1) {
			$this->errorsArray[] = 'Please select a valid server type to continue.';	
		}
						
		//Load Fields
		$this->f_sql = db::query("SELECT * FROM `".config::$db_prefix."plugin_fields` WHERE `field_pluginid`='".lib::post('plugin_id',true)."' AND `field_groupid`='2' ORDER BY `field_order` ASC");
		while($this->f_data = db::fetch($this->f_sql)) {
			
			//Field Title
			$this->field_title = lib::post(str_replace(' ','_', $this->f_data['field_title']));
			
			//Switch Types
			switch($this->f_data['field_type']) {
				case 'textfield': {
					if($this->f_data['field_required']) {
						if(!$this->field_title) {
							$this->errorsArray[] = 'The field "'.$this->f_data['field_title'].'" is required.';
						}
					}
					if($this->f_data['field_regex']) {
						if(!preg_match($this->f_data['field_regex'], $this->field_title)) {
							$this->errorsArray[] = 'The value for the field "'.$this->f_data['field_title'].'" is not valid.';	
						}
					}	
					if($this->f_data['field_date']) {
						$this->d_month = date('m', strtotime($this->field_title));
						$this->d_day = date('d', strtotime($this->field_title));
						$this->d_year = date('Y', strtotime($this->field_title));
						if(!checkdate($this->d_month, $this->d_day, $this->d_year)) {
							$this->errorsArray[] = 'Please enter a valid date for the field "'.$this->f_data['field_title'].'"';
						}
					}
					break;	
				}
				case 'textarea': {
					if($this->f_data['field_required']) {
						if(!$this->field_title) {
							$this->errorsArray[] = 'The field "'.$this->f_data['field_title'].'" is required.';
						}
					}
					if($this->f_data['field_regex']) {
						if(!preg_match($this->f_data['field_regex'], $this->field_title)) {
							$this->errorsArray[] = 'The value for the field "'.$this->f_data['field_title'].'" is not valid.';	
						}
					}
					break;	
				}
				case 'select': {
					if($this->f_data['field_required']) {
						if(!lib::post($this->f_data['field_id'])) {
							$this->errorsArray[] = 'The field "'.$this->f_data['field_title'].'" is required.';
						}
					}
					$this->options = explode(',',$this->f_data['field_options']);
					if(!in_array($this->field_title, $this->options)) {
						$this->errorsArray[] = 'Please select a valid option for the field "'.$this->f_data['field_title'].'"';	
					}
					break;	
				}
				case 'checkbox': {
					if($this->f_data['field_required']) {
						if(!$this->field_title) {
							$this->errorsArray[] = 'The field "'.$this->f_data['field_title'].'" is required.';
						}
					}
					break;	
				}
			}	
		}
				
		//Do we have any issues?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return json_encode(array('error' => $this->errorsArray[0]));	
		} else {
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' added a server. ('.lib::post('server_name',true).')','admin');
			
			//Create Server
			db::query("INSERT INTO `".config::$db_prefix."servers` 
																(
																	`server_name`, 
																	`server_groupid`, 
																	`server_pluginid`,
																	`server_maxaccounts`
																) 
																
																VALUES 
																
																(
																	'".lib::post('server_name',true)."',
																	'".lib::post('server_groupid',true)."',
																	'".lib::post('plugin_id',true)."',
																	'".lib::post('server_maxaccounts',true)."'
																
																)");
																
			//Load Server
			$this->server = db::fetchQuery("SELECT `server_id` FROM `".config::$db_prefix."servers` WHERE `server_name`='".lib::post('server_name',true)."' AND `server_pluginid`='".lib::post('plugin_id',true)."'");
			
			//Load Plugin
			$this->plugin = db::fetchQuery("SELECT `plugin_id`,`plugin_dir`,`plugin_type` FROM `".config::$db_prefix."plugins` WHERE `plugin_id`='".lib::post('plugin_id',true)."'");
			
			//Load Fields
			$this->f_sql = db::query("SELECT * FROM `".config::$db_prefix."plugin_fields` WHERE `field_pluginid`='".$this->plugin['plugin_id']."' AND `field_groupid`='2'");
			while($this->f_data = db::fetch($this->f_sql)) {
				
				//If button, insert as normal, buttons use "value", we don't need to grab this from the form.
				switch($this->f_data['field_type']) {
					case 'button': {
						
						//Create Field
						db::query("INSERT INTO `".config::$db_prefix."server_fields` 
																				(
																				 `field_order`,
																				 `field_cols`,
																				 `field_rows`,
																				 `field_title`,
																				 `field_description`,
																				 `field_type`,
																				 `field_size`,
																				 `field_regex`,
																				 `field_required`,
																				 `field_disabled`,
																				 `field_value`,
																				 `field_placeholder`,
																				 `field_date`,
																				 `field_url`,
																				 `field_function`,
																				 `field_pluginid`,
																				 `field_serverid`,
																				 `field_options`,
																				 `field_default`,
																				 `field_checked`
																				 ) 
																				
																				VALUES 
																				
																				(
																				  '".db::mss($this->f_data['field_order'])."',
																				  '".db::mss($this->f_data['field_cols'])."',
																				  '".db::mss($this->f_data['field_rows'])."',
																				  '".db::mss($this->f_data['field_title'])."',
																				  '".db::mss($this->f_data['field_description'])."',
																				  '".db::mss($this->f_data['field_type'])."',
																				  '".db::mss($this->f_data['field_size'])."',
																				  '".db::mss($this->f_data['field_regex'])."',
																				  '".db::mss($this->f_data['field_required'])."',
																				  '".db::mss($this->f_data['field_disabled'])."',
																				  '".db::mss($this->f_data['field_value'])."',
																				  '".db::mss($this->f_data['field_placeholder'])."',
																				  '".db::mss($this->f_data['field_date'])."',
																				  '".db::mss($this->f_data['field_url'])."',
																				  '".db::mss($this->f_data['field_function'])."',
																				  '".db::mss($this->plugin['plugin_id'])."',
																				  '".db::mss($this->server['server_id'])."',
																				  '".db::mss($this->f_data['field_options'])."',
																				  '".db::mss($this->f_data['field_default'])."',
																				  '".db::mss($this->f_data['field_checked'])."'
																				)
																				
																				");
						
						break;	
					}
					default: {
						
						//Create Field
						db::query("INSERT INTO `".config::$db_prefix."server_fields` 
																				(
																				 `field_order`,
																				 `field_cols`,
																				 `field_rows`,
																				 `field_title`,
																				 `field_description`,
																				 `field_type`,
																				 `field_size`,
																				 `field_regex`,
																				 `field_required`,
																				 `field_disabled`,
																				 `field_value`,
																				 `field_placeholder`,
																				 `field_date`,
																				 `field_url`,
																				 `field_function`,
																				 `field_pluginid`,
																				 `field_serverid`,
																				 `field_options`,
																				 `field_default`,
																				 `field_checked`
																				 ) 
																				
																				VALUES 
																				
																				(
																				  '".db::mss($this->f_data['field_order'])."',
																				  '".db::mss($this->f_data['field_cols'])."',
																				  '".db::mss($this->f_data['field_rows'])."',
																				  '".db::mss($this->f_data['field_title'])."',
																				  '".db::mss($this->f_data['field_description'])."',
																				  '".db::mss($this->f_data['field_type'])."',
																				  '".db::mss($this->f_data['field_size'])."',
																				  '".db::mss($this->f_data['field_regex'])."',
																				  '".db::mss($this->f_data['field_required'])."',
																				  '".db::mss($this->f_data['field_disabled'])."',
																				  '".lib::post(str_replace(' ','_', $this->f_data['field_title']),true)."',
																				  '".db::mss($this->f_data['field_placeholder'])."',
																				  '".db::mss($this->f_data['field_date'])."',
																				  '".db::mss($this->f_data['field_url'])."',
																				  '".db::mss($this->f_data['field_function'])."',
																				  '".db::mss($this->plugin['plugin_id'])."',
																				  '".db::mss($this->server['server_id'])."',
																				  '".db::mss($this->f_data['field_options'])."',
																				  '".db::mss($this->f_data['field_default'])."',
																				  '".db::mss($this->f_data['field_checked'])."'
																				)
																				
																				");

						break;		
					}
																		
				}
				
			}
						
			//Add Server
			return json_encode(array('success' => true));	
		}
		
	}
	
	//@Delete Group
	public function deleteGroup() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the group exist?
		if(db::nRows("SELECT `group_id` FROM `".config::$db_prefix."servergroups` WHERE `group_id`='".lib::post('group_id',true)."'") < 1) {
			$this->errorsArray[] = 'The group your trying to edit does not exist!';	
		}
		
		//Do we have any servers in the group?
		if(db::nRows("SELECT `server_groupid` FROM `".config::$db_prefix."servers` WHERE `server_groupid`='".lib::post('group_id',true)."'") > 0) {
			$this->errorsArray[] = 'This group contains servers and can not be deleted.';
		}
		
		//Do we have any problems?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' deleted a server group. ('.lib::post('group_id',true).')','admin');
			db::query("DELETE FROM `".config::$db_prefix."servergroups` WHERE `group_id`='".lib::post('group_id',true)."'");
		}
		
	}
	
	//@Edit Group
	//Allows us to edit a server group.
	public function editGroup() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Does the group exist?
		if(db::nRows("SELECT `group_id` FROM `".config::$db_prefix."servergroups` WHERE `group_id`='".lib::post('group_id',true)."'") < 1) {
			$this->errorsArray[] = 'The group your trying to edit does not exist!';	
		}
		
		//Do we have a group name?
		if(!lib::post('group_name')) { $this->errorsArray[] = 'Please enter a group name below.'; }
		if(strlen(lib::post('group_name')) > 100) { $this->errorsArray[] = 'Your server group name must be less than 100 characters long.'; }
		
		//Do we have a group description
		if(!lib::post('group_description')) { $this->errorsArray[] = 'Please enter a group description below.'; }
		if(strlen(lib::post('group_description')) > 1500) { $this->errorsArray[] = 'Your group description must be less than 1500 characters long.';}
		
		//Validate Hosting Type
		if(!in_array(lib::post('group_servertype'),array(0,1,2,3,4,5))) {
			$this->errorsArray[] = 'Please select a valid server group to continue.';	
		}
		
		//Validate Server Ports
		if(lib::post('group_servermonitor')) {
			if(!is_numeric(lib::post('group_servermonitor'))) { $this->errorsArray[] = 'Something unexpected happened while trying to create this group.'; }
			if(is_array(lib::post('group_serverports'))) {
				if(count(lib::post('group_serverports'))) {
					foreach(lib::post('group_serverports') AS $this->port_key => $this->port_value) {
						if(!is_numeric($this->port_value)) { $this->errorsArray[] = 'Please select a valid server port to use.';	}
						if(db::nRows("SELECT `port_id` FROM `".config::$db_prefix."serverports` WHERE `port_id`='".db::mss($this->port_value)."'") < 1) {
							$this->errorsArray[] = 'Please select a valid server port to use.';
						}
					}
				} else {
					if(!is_numeric(lib::post('group_serverports'))) { $this->errorsArray[] = 'Please select a valid server port to use.';	}
					if(db::nRows("SELECT `port_id` FROM `".config::$db_prefix."serverports` WHERE `port_id`='".lib::post('group_serverports',true)."'") < 1) {
						$this->errorsArray[] = 'Please select a valid server port to use.';
					}
				}
			} else {
				$this->errorsArray[] = 'Please select the ports below you wish to use.';	
			}
		}		
		
		//Do we have any problems?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' edited a server group. ('.lib::post('group_name',true).')','admin');
			
			//Server Ports
			if(lib::post('group_servermonitor')) {
				if(is_array(lib::post('group_serverports'))) {
					if(count(lib::post('group_serverports'))) {
						$this->server_ports = implode(',', lib::post('group_serverports'));
					} else {
						$this->server_ports = '';	
					}
				} else {
					$this->server_ports = lib::post('group_serverports');
				}
			}
			
			//Update...
			db::query("UPDATE `".config::$db_prefix."servergroups` SET  `group_name`='".lib::post('group_name',true)."', 
																		`group_description`='".lib::post('group_description',true)."',
																		`group_servermonitor`='".lib::post('group_servermonitor',true)."',
																		`group_serverports`='".db::mss($this->server_ports)."' ,
																		`group_servertype`='".lib::post('group_servertype',true)."'
																		
																		WHERE `group_id`='".lib::post('group_id',true)."'");
		}
			
	}
	
	//@Add Group
	//Allows us to add a server group.
	public function addGroup() {
		
		//A place to store errors
		$this->errorsArray = array();
		
		//Do we have a group name?
		if(!lib::post('group_name')) { $this->errorsArray[] = 'Please enter a group name below.'; }
		if(strlen(lib::post('group_name')) > 100) { $this->errorsArray[] = 'Your server group name must be less than 100 characters long.'; }
		
		//Do we have a group description
		if(!lib::post('group_description')) { $this->errorsArray[] = 'Please enter a group description below.'; }
		if(strlen(lib::post('group_description')) > 1500) { $this->errorsArray[] = 'Your group description must be less than 1500 characters long.';}
		
		//Validate Hosting Type
		if(!in_array(lib::post('group_servertype'),array(0,1,2,3,4,5))) {
			$this->errorsArray[] = 'Please select a valid server group to continue.';	
		}
		
		//Validate Server Ports
		if(lib::post('group_servermonitor')) {
			if(!is_numeric(lib::post('group_servermonitor'))) { $this->errorsArray[] = 'Something unexpected happened while trying to create this group.'; }
			if(is_array(lib::post('group_serverports'))) {
				if(count(lib::post('group_serverports'))) {
					foreach(lib::post('group_serverports') AS $this->port_key => $this->port_value) {
						if(!is_numeric($this->port_value)) { $this->errorsArray[] = 'Please select a valid server port to use.';	}
						if(db::nRows("SELECT `port_id` FROM `".config::$db_prefix."serverports` WHERE `port_id`='".db::mss($this->port_value)."'") < 1) {
							$this->errorsArray[] = 'Please select a valid server port to use.';
						}
					}
				} else {
					if(!is_numeric(lib::post('group_serverports'))) { $this->errorsArray[] = 'Please select a valid server port to use.';	}
					if(db::nRows("SELECT `port_id` FROM `".config::$db_prefix."serverports` WHERE `port_id`='".lib::post('group_serverports',true)."'") < 1) {
						$this->errorsArray[] = 'Please select a valid server port to use.';
					}
				}
			} else {
				$this->errorsArray[] = 'Please select the ports below you wish to use.';	
			}
		}
							
		//Do we have any problems?
		if(count($this->errorsArray)) {
			logs::logAction(2,$this->errorsArray[0],'admin');
			return $this->errorsArray[0];	
		} else {		
			
			//Log Action
			logs::logAction(1,'The user '.session::data('user_username').' added a server group. ('.lib::post('group_name',true).')','admin');
			
			//Server Ports
			if(lib::post('group_servermonitor')) {
				if(is_array(lib::post('group_serverports'))) {
					if(count(lib::post('group_serverports'))) {
						$this->server_ports = implode(',', lib::post('group_serverports'));
					} else {
						$this->server_ports = '';	
					}
				} else {
					$this->server_ports = lib::post('group_serverports');
				}
			}
			
			db::query("INSERT INTO `".config::$db_prefix."servergroups` 
			
			(
				`group_name`, 
				`group_description`,
				`group_serverports`,
				`group_servermonitor`,
				`group_servertype`
			) 
			
			VALUES 
			
			(
				'".lib::post('group_name',true)."',
				'".lib::post('group_description',true)."',
				'".db::mss($this->server_ports)."',
				'".lib::post('group_servermonitor',true)."',
				'".lib::post('group_servertype',true)."'
			)");	
		}
		
			
	}
		
}