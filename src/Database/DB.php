<?php namespace Database;

//use \InvalidArgumentException as Argument;

use Database\DAO\DAO;
use Database\DAO\DB as DAODB;
use Database\Registry;
use Database\MySQL\ConnectorConfig as MySQL;
use Api\Config;

class DB {
	
	private static $db;
	public static $table;

	public static function connection($driver=null){
		
		/** instância do repositório Registry **/
		$registry = Registry::getInstance();
		
		if(is_null($driver)){
			$driver = Config::get('database.default');
		}

		$connections = Config::get('database.connections');
		$dbhost = $connections[$driver]['host'];
		$dbname = $connections[$driver]['database'];
		$dbuser = $connections[$driver]['username'];
		$dbpwd  = $connections[$driver]['password'];

		switch ($driver)
		{
			case 'mysql':
				$defaultConnectorConfig = new MySQL( $dbhost, $dbname, $dbuser, $dbpwd );
				$registry->set( 'defaultConnectorConfig', $defaultConnectorConfig );
			break;
		}

		$defaultDAO = new DAO( $defaultConnectorConfig );
		$registry->set( 'defaultDAO', $defaultDAO );
		static::$db = new DAODB( $registry->get( 'defaultDAO' ) );
		return static::$db;
	}

	public static function table($table=null){
		return static::connection()->table($table);
	}

	public static function get($id=null){
		//$select = (array)$columns;
		if(is_null($id)){
			return static::$db->getAll();
		}else{
			return static::$db->get();
		}
	}
}