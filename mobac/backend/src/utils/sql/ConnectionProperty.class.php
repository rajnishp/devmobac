<?php
/**
 * Connection properties
 *
 * @author: Rahul Lahoria (rahul_lahoria@yahoo.com)
 * @date: 9.12.2014
 */
class ConnectionProperty{

	/*private static $host = 'localhost';
	private static $user = '';
	private static $password = '';
	private static $database = 'mobac';*/

	public static function getHost(){
		/*return ConnectionProperty::$host;*/
		global $configs;
		return $configs ['mysql'] ['host'];
	}

	public static function getUser(){
		/*return ConnectionProperty::$user;*/
		global $configs;
		return $configs ['mysql'] ['user'];
	}

	public static function getPassword(){
		/*return ConnectionProperty::$password;*/
		global $configs; 
		return $configs ['mysql'] ['password'];
	}

	public static function getDatabase(){
		/*return ConnectionProperty::$database;*/
		global $configs; 
		return $configs ['mysql'] ['database'];
	}
}
?>