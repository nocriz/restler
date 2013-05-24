<?php namespace Models;

use Database\DB as DB;


/**
 * Model Tokens
 * Api do cliente
 * @author Ramon Barros
 * @package api
 * @subpackage model
 * @category api, client, model, desing pattern
 */

class ModelTokens {

	public static function token($token=''){
		DB::table('tokens')->where('token','=',$token);
        return DB::get();
	}
}