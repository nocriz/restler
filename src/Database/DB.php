<?php namespace Database;

//use \InvalidArgumentException as Argument;

use Database\DAO\DAO;
use Database\DAO\DB_DAO;
use Database\Registry;
use Database\MySQL\ConnectorConfig as MySQL;

class DB {
	
	private $db;
	protected static $table;

	public static function connection($driver='mysql'){
		
		/** instância do repositório Registry **/
		$registry = Registry::getInstance();
		
		switch ($driver)
		{
			case 'mysql':
				$defaultConnectorConfig = new MySQL( 'localhost', 'restler', 'root', '' );
				$registry->set( 'defaultConnectorConfig', $defaultConnectorConfig );
			break;
		}

		$defaultDAO = new DAO( $defaultConnectorConfig );
		$registry->set( 'defaultDAO', $defaultDAO );
		$this->db = new DB_DAO( $registry->get( 'defaultDAO' ) );
		return $this->db;
	}

	public static function table($table=null){
		return static::connection()->table($table);
	}

	public static function where($where){
		//return static::$db->where($where);
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