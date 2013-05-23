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
	
	protected $id;
	protected $name;

	/*
	public function setName($name=null){
		$this->name = $name;
	}
	public function getName(){
		return $this->name;
	}
	*/
	public function setId($id=null){
		$this->id=$id;
		return $this;
	}
	public function getId(){
		return $this->id;
	}	
}