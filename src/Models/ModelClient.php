<?php namespace Models;

use DB\DataAccess;


/**
 * Model Client - Remove dependência da classe com o bando de dados
 * Api do cliente
 * @author Ramon Barros
 * @package api
 * @subpackage model
 * @category api, client, model, desing pattern
 */

class ModelClient extends DataAccess {

	public static function get($id=null){
		if(!is_null($id)){
			$this->db->where('id',$id);
		}
		
		$this->db->select(array(
					 'name'
					,'email'
					,'phone'
					,'address'
					,'number'
					,'complement'
					,'city'
					,'country'
					,'zip_code'
				 ))
				 ->from('client')
				 ->query();
		return self;
	}

	public function getArray(){
		return $this->db->RowAll();
	}

	public function getObject(){
		return $this->db->RowObject();
	}
}