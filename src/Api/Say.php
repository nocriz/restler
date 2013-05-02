<?php namespace Api;

/**
 * Classe de teste do Restler
 * @author Ramon Barros
 * @package api
 * @subpackage concrete
 * @category api, client , desing pattern
 */
class Say {

	/**
	 * Função exemplo GET say/hello
	 * @param  string $to texto a ser retornado
	 * @return string
	 */
	function hello($to='world') {
		return "Hello {$to}!";
	}
}