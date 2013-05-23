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

	/**
	 * url GET /client/:id
     * @access protected
     * @class  AccessControl {@requires client}
     */
	public function get($id=null){
		
		$this->setId($id);

		$results = ModelClient::get($this->getId());

		if(empty($results) && !is_null($this->getId())){
			throw new Argument(400,"This ID doesn't exist");
		}
		return $results;
	}
}