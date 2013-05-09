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
     * @access protected
     * @class  AccessControl {@requires user}
     */
	public function get($id=null){
		
		$results = ModelClient::get($id);

		if(empty($results) && !is_null($id)){
			throw new Argument(400,"This ID doesn't exist");
		}
		return $results;
	}
}