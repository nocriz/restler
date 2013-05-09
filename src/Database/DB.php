<?php namespace Database;

use \InvalidArgumentException as Argument;

class DB {
	
	protected static $db;
	protected static $table;

	public static function connection($driver='mysql'){
		switch ($driver)
		{
			case 'mysql':
				static::$db = new \Database\Driver\MySQL('localhost','root','','api');
				if(static::$db->connected()==false){
					throw new Argument(400,static::$db->error());
				}
			break;
		}	
		return static::$db;
	}

	public static function table($table=null){
		return static::connection()->from($table);
	}

	public static function where($where){
		return static::$db->where($where);
	}

	public static function get($columns = array('*')){
		$select = (array)$columns;
		return static::$db->select($select)->query();
	}

	public static function last_sql(){
		return static::$db->lastSql();
	}

	public static function exists($table)
	{
		return static::connection()->query("SELECT 1 FROM {$table}");
	}
}