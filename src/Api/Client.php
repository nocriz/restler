<?php
namespace Api;

use Api\AbstractApi\AbstractClient;
use \RestException as Argument;
use Models\ModelClient;

/**
 * Client
 * Api do cliente
 * @author Ramon Barros
 * @package api
 * @subpackage concrete
 * @category api, client , desing pattern
 */
class Client extends AbstractClient {
	/*
	public function get($param=null,$id=null){
		if($param=='user'){
			return $this->user($id);
		}elseif($param=='admin'){
			return $this->admin($id);
		}else{
			$id = (is_null($id)?$param:$id);
			return $this->user($id);
		}
	}
	*/
	
	/**
     * @access protected
     * @class  AccessControl {@requires user}
     */
	public function user($id=null){
		
		$this->setId($id);

		$results = ModelClient::get_user($this->getId());

		if(empty($results) && !is_null($this->getId())){
			throw new Argument(400,"This ID doesn't exist");
		}
		return $results;
	}

	/**
     * @access protected
     * @class  AccessControl {@requires admin}
     */
	public function admin($id=null){
		
		$this->setId($id);

		$results = ModelClient::get_admin($this->getId());

		if(empty($results) && !is_null($this->getId())){
			throw new Argument(400,"This ID doesn't exist");
		}
		return $results;
	}
}