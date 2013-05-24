<?php namespace Models;

use Database\DB as DB;


/**
 * Model Client - Remove dependência da classe com o bando de dados
 * Api do cliente
 * @author Ramon Barros
 * @package api
 * @subpackage model
 * @category api, client, model, desing pattern
 */

class ModelClient {

	public static function get($id=null){
		$columms = array(
					 'name'
					,'email'
					,'phone'
					,'address'
					,'number'
					,'complement'
					,'city'
					,'country'
					,'zip_code'
				 );
		DB::table('client');
		DB::select($columms);
		if(!is_null($id)){
			return DB::get($id);
		}
		return DB::get();
	}
}