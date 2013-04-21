<?php
namespace Api;

use Api\AbstractApi\AbstractClient;

/**
 * Client
 * Api do cliente
 * @author Ramon Barros
 * @package api
 * @subpackage concrete
 * @category api, client , desing pattern
 */
class Client extends AbstractClient {
	
	protected $name;

	public function get($id=null){
		try {
			if(is_null($id)){
				throw new Exception("O nome não pode ser vazio.");
			}
			$this->setName($name);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}