<?php //namespace Api;

use Models\ModelTokens;
use \Luracast\Restler\iAuthenticate;
use \Luracast\Restler\Resources;

class AccessControl implements iAuthenticate
{
    public static $requires = 'user';
    public static $role = 'user';
    public function __isAllowed()
    {
        // 12345 Basic MTIzNDU6eA==
        // 67890 Basic Njc4OTA6eA==
        //$roles = array('12345' => 'user', '67890' => 'admin');
        $roles = array();
        $token = isset($_SERVER['PHP_AUTH_USER'])?$_SERVER['PHP_AUTH_USER']:null;
        
        $tokens = ModelTokens::token($token);
        if(is_array($tokens)){
            foreach ($tokens as $role) {
                //if(strlen($role['token'])>=32){
                    $roles[$role['token']] = $role['role'];
                //}
            }
        }
        
        if (count($roles) and !isset($_SERVER['PHP_AUTH_USER'])|| !array_key_exists($_SERVER['PHP_AUTH_USER'], $roles)) {
            return false;
        }
        static::$role = $roles[$_SERVER['PHP_AUTH_USER']];
        return static::$requires == static::$role || static::$role == 'admin';
    }
}
