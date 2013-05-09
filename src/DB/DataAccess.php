<?php namespace DB;

abstract class DataAccess {
	
	protected $db;

	public function __construct(MySQL $db){
		$this->db = $db;
		if($this->db->connected()==false){
			throw new Argument(400,$this->db->error());
		}
	}
}