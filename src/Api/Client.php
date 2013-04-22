<?php
namespace Api;

use Api\AbstractApi\AbstractClient;
use DB\MySQL;

/**
 * Client
 * Api do cliente
 * @author Ramon Barros
 * @package api
 * @subpackage concrete
 * @category api, client , desing pattern
 */
class Client extends AbstractClient {
	
	protected $db;
	protected $name;

	public function __construct(){
		$this->db = new MySQL('localhost','root','','api');
	}
	public function get($id=null){
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
		$results = $this->db->RowAll();
		if(empty($results) && !is_null($id)){
			throw new \RestException(400,"This ID doesn't exist");
		}
		return $results;
	}
}