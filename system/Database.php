<?php
class Database
{
	
	/**
	 * 
	 * connection for Db
	 * @var PDO
	 */
	protected static $_conn = null;
	
	 /**
	  * Singleton pattern
	  */
	static function getConnection() {
		if(!self::$_conn){
			$configDb = Configuration::getInstance()->get('config.db');
			self::$_conn = new PDO(
				'mysql:host=' . $configDb['host']
				. ';dbname=' . $configDb['db'],
				$configDb['username'],
				$configDb['pass']
			);
    	}
    	self::$_conn->exec('CHARSET UTF8');
    	self::$_conn->exec('SET NAMES UTF8');
    	
		return self::$_conn;
	}
}