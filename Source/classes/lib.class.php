<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class lib {
		
	//@Declared
	public static $variable;
	public static $countries;
	public static $countriesData;
	public static $countriesSQL;
	
	public static $cities;
	public static $citiesData;
	public static $citiesSQL;
	
	public static $timezones;
	public static $timezoneData;
	public static $timezoneSQL;
	public static $languages;
	public static $languagesSQL;
	public static $languagesData;
	public static $gateway;
	public static $gatewaySQL;
	public static $gatewayData;
	public static $currency;
	public static $currencySQL;
	public static $currencyData;
	public static $dateFormat;
	public static $value;
	public static $setting;
	public static $country;
	public static $cache = array();
	public static $group;
	public static $groups;
	public static $groupsSQL;
	public static $groupsData;
  	public static $date_day;
	public static $date_month;
	public static $date_year;
	public static $status_array;
	public static $advertData;
		
	//Timing Events
	public static function humanTiming($time) {
		
		//Time since
		$time = time() - $time;
				
		//Looop
		$time_array = array(
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second');
			
		//Foreach Loop
		foreach($time_array AS $stamp => $text) {
			if($time > $stamp) {
				$value = floor($time/$stamp);
				return $value. ' '.$text;
				break;	
			}
		}
			
	}
	
	//Strip Tags
	public static function filterOutput($html) {
		return strip_tags(self::closetags($html), '<ul><ol><li><em><strong>');
	}
	
	//Close HTML Tags
	public static function closetags($html) {
		preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
		$openedtags = $result[1];
		preg_match_all('#</([a-z]+)>#iU', $html, $result);
		$closedtags = $result[1];
		$len_opened = count($openedtags);
		if (count($closedtags) == $len_opened) {
			return $html;
		}
		$openedtags = array_reverse($openedtags);
		for ($i=0; $i < $len_opened; $i++) {
			if (!in_array($openedtags[$i], $closedtags)) {
				$html .= '</'.$openedtags[$i].'>';
			} else {
				unset($closedtags[array_search($openedtags[$i], $closedtags)]);
			}
		}
		return $html;
	}
	
	//Format Money for DB
	public static function formatMoneyDB($value) {
		return str_replace(',','',$value);	
	}
	
	//Selected Default
	public static function selectedDefault($field, $value, $setting = false) {
		if($setting) {
			if(lib::getSetting($field,false,true,true) == $value) {
				return 'selected';	
			}
		} else {
			if(lib::post($field,false,true,true) == $value) {
				return 'selected';	
			}
		}
	}
	
	//Checked Default
	public static function checkedDefault($field, $value) {
		if(lib::post($field,false,true,true) == $value) {
			return 'checked';	
		}
	}
			
	//List Currencies
	public static function getCurrencies() {
		self::$currency = array();
		self::$currencySQL = db::query("SELECT * FROM `".config::$db_prefix."currencies`");
		while(self::$currencyData = db::fetch(self::$currencySQL)) {
			self::$currency[self::$currencyData['currency_id']] = self::$currencyData['currency_name'];
		}	
		return self::$currency;	
	}
		
	public static $currencyReturn;
	
	//Get Currency Prefix
	public static function getCurrencyPrefix($currencyid, $value) {
		self::$currencyData = self::getCurrency($currencyid);
		self::$currencyReturn = '';
		if(self::$currencyData['currency_position'] == 0) { self::$currencyReturn .= self::$currencyData['currency_prefix']; }
		self::$currencyReturn .= $value;
		if(self::$currencyData['currency_position'] == 1) { self::$currencyReturn .= self::$currencyData['currency_prefix']; }
		return self::$currencyReturn;
	}
	
	//Get Currency
	//Returns the currency data for the selected userid.
	public static function getCurrency($currencyid) {
		self::$currencyData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."currencies` WHERE `currency_id`='".db::mss($currencyid)."'");
		return array('currency_id' => self::$currencyData['currency_id'], 
					 'currency_prefix' => self::$currencyData['currency_prefix'], 
					 'currency_position' => self::$currencyData['currency_position'],
					 'currency_name' => self::$currencyData['currency_name'],
					 'currency_baserate' => self::$currencyData['currency_baserate']);			
	}
	
	//Get Default Currency
	//Returns the currency data for the selected userid.
	public static function getDefaultCurrencySymbol() {
		self::$currencyData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."currencies` WHERE `currency_default`='1'");
		return self::$currencyData['currency_prefix'];			
	}
		
	//Convert Date
	//Allows us to convert dates to the american format for DB
	public static function convertDate($date) {
		self::$date_day = date('d',strtotime(str_replace('/','-',$date)));
		self::$date_month = date('m',strtotime(str_replace('/','-',$date)));
		self::$date_year = date('Y',strtotime(str_replace('/','-',$date)));
		if(checkdate(self::$date_month, self::$date_day, self::$date_year)) {
			return self::$date_year.'-'.self::$date_month.'-'.self::$date_day;	
		}	
	}
	
	public static $date_full;
	public static $errorsArray;
	
	//Date Validator (Replace / with -, Strtotime does not long none-conventional strings)
	//Allows us to validate date strings.
	public static function validateDate($date) {
		
		//Errors Array
		self::$errorsArray = array();
		
		////////////////////////////////////////////////////////////////////////
		//Lets try to validate it this way! (checkdate is not realiable)
		////////////////////////////////////////////////////////////////////////
		if(!preg_match('/^[0-9]{4}\/{1}[0-9]{2}\/{1}[0-9]{2}$/',$date)) { //UK
			if(!preg_match('/^[0-9]{2}\/{1}[0-9]{2}\/{1}[0-9]{4}$/',$date)) {
				self::$errorsArray[] = 'Please enter a valid date format below. [E1]';
			}
		}
		
		///////////////////////////////////////////////////////////////////////
		//Lets try to validate with checkdate()
		///////////////////////////////////////////////////////////////////////
		//Replace any / with -
		self::$date_full = str_replace('/','-',$date);
		
		//Convert to Single Values
		self::$date_day = date('d',strtotime(self::$date_full));
		self::$date_month = date('m',strtotime(self::$date_full));
		self::$date_year = date('Y',strtotime(self::$date_full));
		
		//Check Date
		if(!checkdate(self::$date_month, self::$date_day, self::$date_year)) {
			self::$errorsArray[] = 'Please enter a valid date format below. [E1]';
		}
		
		//Return Errors
		if(count(self::$errorsArray)) {
			return false;
		} else {
			return true;		
		}
	}
	
	//Get DateFormat
	//Returns the date format for javascript and PHP.
	public static function getDateFormat($client=false,$datepicker=false) {
		if($client) {
			if($datepicker) {
				self::$dateFormat = array('DD/MM/YYYY' => 'dd/mm/yy', 'DD.MM.YYYY' => 'd.m.Y', 'DD-MM-YYYY' => 'd-m-Y', 'MM/DD/YYYY' => 'm/d/Y', 'YYYY-MM-DD' => 'Y-m-d');
				return self::$dateFormat[lib::getSetting('Local_ClientDateFormat')];
			} else {
				self::$dateFormat = array('DD/MM/YYYY' => 'd/m/Y', 'DD.MM.YYYY' => 'd.m.Y', 'DD-MM-YYYY' => 'd-m-Y', 'MM/DD/YYYY' => 'm/d/Y', 'YYYY-MM-DD' => 'Y-m-d');
				return self::$dateFormat[lib::getSetting('Local_ClientDateFormat')];
			}
		} else {
			if($datepicker) {
				self::$dateFormat = array('DD/MM/YYYY' => 'dd/mm/yy', 'DD.MM.YYYY' => 'dd.mm.yy', 'DD-MM-YYYY' => 'dd-mm-yy', 'MM/DD/YYYY' => 'mm/dd/yy', 'YYYY-MM-DD' => 'yy-mm-dd');
				return self::$dateFormat[lib::getSetting('Local_ClientDateFormat')];
			} else {
				self::$dateFormat = array('DD/MM/YYYY' => 'd/m/Y', 'DD.MM.YYYY' => 'd.m.Y', 'DD-MM-YYYY' => 'd-m-Y', 'MM/DD/YYYY' => 'm/d/Y', 'YYYY-MM-DD' => 'Y-m-d');
				return self::$dateFormat[lib::getSetting('Local_DefaultDateFormat')];
			}
		}
	}
	
	//List Timezones
	public static function getTimezones() {
		self::$timezones= array();
		self::$timezoneSQL = db::query("SELECT * FROM `".config::$db_prefix."timezones`");
		while(self::$timezoneData = db::fetch(self::$timezoneSQL)) {
			self::$timezones[self::$timezoneData['timezone_id']] = self::$timezoneData['timezone_value'];
		}	
		return self::$timezones;	
	}
		
	//List Countries
	public static function getCountries() {
		if(isset(self::$countries) && count(self::$countries) > 0) {
			return self::$countries;
		} else {
			self::$countries = array();
			self::$countriesSQL = db::query("SELECT * FROM `".config::$db_prefix."countries`");
			while(self::$countriesData = db::fetch(self::$countriesSQL)) {
				if(self::$countriesData['id'] == 246) { //Limit Country
					self::$countries[self::$countriesData['id']] = self::$countriesData['country_name'];
				}
			}	
			return self::$countries;
		}	
	}
	
	//List Cities
	public static function getCities() {
		if(isset(self::$cities) && count(self::$cities) > 0) {
			return self::$cities;
		} else {
			self::$cities = array();
			self::$citiesSQL = db::query("SELECT * FROM `".config::$db_prefix."cities`");
			while(self::$citiesData = db::fetch(self::$citiesSQL)) {
				self::$cities[self::$citiesData['city_id']] = self::$citiesData['city_name'];
			}	
			return self::$cities;
		}	
	}
	
	//Get Advert City
	//Allows us to get a single city for an advert
	public static function getAdvertCity($advert_id) {
		self::$advertData = db::fetchQuery("SELECT `advert_cityid` FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".db::mss($advert_id)."'");
		self::$cities = db::fetchQuery("SELECT `city_name` FROM `".config::$db_prefix."cities` WHERE `city_id`='".self::$advertData['advert_cityid']."'");
		return self::$cities['city_name'];
	}
		
	//Get City
	//Allows us to get a single city
	public static function getCity($city_id) {
		self::$cities = db::fetchQuery("SELECT `city_name` FROM `".config::$db_prefix."cities` WHERE `city_id`='".$city_id."'");
		return self::$cities['city_name'];
	}
	
	//Get Country
	//Allows us to get a single country
	public static function getCountry($country_id) {
		self::$country = db::fetchQuery("SELECT `country_name` FROM `".config::$db_prefix."countries` WHERE `id`='".$country_id."'");
		return self::$country['country_name'];
	}
		
	//Get Settings
	public static function getSetting($value, $mss=false, $strip=false, $html=false) {		
		if(array_key_exists($value, self::$cache)) {
			self::$value = self::$cache[$value];
		} else {
			self::$setting = db::fetchQuery("SELECT `value` FROM `".config::$db_prefix."settings` WHERE `setting`='".$value."'");
			self::$cache[$value] = self::$setting['value'];
			self::$value = lib::san(self::$setting['value'], $mss, $strip, $html);
		}				
		return self::$value;
	}
	
	//Front-End Template
	public static function getTemplate() {
		return self::getSetting('General_DefaultTemplate'); //Come back later...
	}
			
	//@$_POST
	public static function post($key, $mss = false, $strip_tags = false, $html_entities = false, $max_char = 255) {
		self::$variable = @$_POST[$key];
		if(isset(self::$variable) && self::$variable != '') { self::$variable = self::$variable; } else { self::$variable = ''; }
		if($mss == true) { self::$variable = db::mss(self::$variable);}
		if($strip_tags == true) { self::$variable = strip_tags(self::$variable); }
		if($html_entities == true) { self::$variable = htmlentities(self::$variable, ENT_QUOTES, 'UTF-8'); }
		return self::$variable;			
	}
	
	//@$_GET
	public static function get($key, $mss = false, $strip_tags = false, $html_entities = false, $max_char = 255) {
		self::$variable = @$_GET[$key];
		if(isset(self::$variable) && self::$variable != '') { self::$variable = self::$variable; } else { self::$variable = ''; }
		if($mss == true) { self::$variable = db::mss(self::$variable); }
		if($strip_tags == true) { self::$variable = strip_tags(self::$variable);}
		if($html_entities == true) { self::$variable = htmlentities(self::$variable, ENT_QUOTES, 'UTF-8');}
		return self::$variable;	
	}
	
	//Sanitize Data
	public static function san($data, $mss = false, $strip_tags = true, $html_entities = true, $max_char = 255) {
		self::$variable = $data;
		if($mss == true) { self::$variable = db::mss(self::$variable);	}
		if($strip_tags == true) { self::$variable = strip_tags(self::$variable);	}
		if($html_entities == true) {self::$variable = htmlentities(self::$variable, ENT_QUOTES, 'UTF-8');}
		return self::$variable;
	}
	
	//Cookie
	public static function cookie($data, $mss = false, $strip_tags = false, $html_entities = false, $max_char = 255) {
		self::$variable = @$_COOKIE[$data];
		if($mss == true) { self::$variable = db::mss(self::$variable);	}
		if($strip_tags == true) { self::$variable = strip_tags(self::$variable);	}
		if($html_entities == true) {self::$variable = htmlentities(self::$variable, ENT_QUOTES, 'UTF-8');}
		return self::$variable;
	}
	
	//Session
	public static function session($data, $mss = false, $strip_tags = false, $html_entities = false, $max_char = 255) {
		self::$variable = @$_SESSION[$data];
		if($mss == true) { self::$variable = db::mss(self::$variable);	}
		if($strip_tags == true) { self::$variable = strip_tags(self::$variable);	}
		if($html_entities == true) {self::$variable = htmlentities(self::$variable, ENT_QUOTES, 'UTF-8');}
		return self::$variable;
	}
}