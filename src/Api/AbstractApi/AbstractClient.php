<?php
namespace Api\AbstractApi;

use Api\InterfaceApi\InterfaceClient;

/**
 * Interface InterfaceClient
 * Interface para criação da api de Clientes
 * @author Ramon Barros
 * @package api
 * @subpackage concrete
 * @category api, client , desing pattern
 */
abstract class AbstractClient implements InterfaceClient {
	
	protected $name;

	public function setName($name=null){
		$this->name = $name;
	}
	public function getName(){
		return $this->name;
	}	
}