<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class db {
	
	//@Declared
	public static $connect;
	public static $sql;
	public static $item;
	public static $payload = array();
	public static $payloads;
	
	//@Database Connection
	//Make a connection
	public static function connect() {
		if(isset(self::$connect) && mysqli_ping(self::$connect)) {
			
			// Change character set to utf8
			mysqli_set_charset($connect,"utf8");
			
			//Return Connection
			return self::$connect;
			
		} else {
			
			//Make connection
			$connect = mysqli_connect(config::$db_hostname, config::$db_username, config::$db_password, config::$db_database);
						
			// Change character set to utf8
			mysqli_set_charset($connect,"utf8");
			
			//Return Connection
			return $connect;
		}
	}
	
	//@Database Query
	//Make a database query
	public static function query($sql) {
		self::$payload[] = $sql;
		return mysqli_query(self::connect(), $sql);	
	}
	
	//@Database Fetch
	//Make a database fetch
	public static function fetch($sql) {
		self::$sql = @mysqli_fetch_array($sql);
		return self::$sql;
	}
	
	//@Database Fetch Query
	//Make a database fetch query
	public static function fetchQuery($sql) {
		return self::fetch(self::query($sql));	
	}
	
	//@Database Num Rows
	//How many rows?
	public static function nRows($sql) {
		return mysqli_num_rows(self::query($sql));	
	}
	
	//@Database Num Rows Query
	public static function nRowsQuery($sql) {
		return mysqli_num_rows($sql);	
	}
	
	//MYSQL Injection Protection
	public static function mss($sql) {
		return mysqli_real_escape_string(self::connect(), $sql);	
	}
	
	public static function querysCount() {
		return count(self::$payload);
	}
	
	public static function querysList() {
		self::$payloads = '';
		foreach(self::$payload AS self::$item) {
			self::$payloads .= self::$item."\n";
		}
		return self::$payloads;
	}
	
	public static function closeDB() {
		return mysqli_close(self::connect());	
	}
	
}