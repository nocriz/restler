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
		DB::table('client');
		if(!is_null($id)){
			DB::where('id',$id);
		}
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
		return DB::get($columms)->RowAssoc();
	}
}