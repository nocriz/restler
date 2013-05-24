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
			return DB::get($id);
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
		return DB::get();
	}

	public static function token($token=''){
		 DB::table('client')->where('token',$token);
        $client = DB::get(array('token'))->RowObject();
        return $client->token;  
	}
}