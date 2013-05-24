<?php namespace Api;

use Models\ModelTokens;
use \Luracast\Restler\iAuthenticate;
use \Luracast\Restler\Resources;
class AccessControl implements iAuthenticate
{
    public static $requires = 'client';
    public static $role = 'client';
    public static $roles=array();
    public function __isAllowed()
    {
        $token = isset($_SERVER['PHP_AUTH_USER'])?$_SERVER['PHP_AUTH_USER']:null;
        
        $tokens = ModelTokens::token($token);
        if(is_array($tokens)){
            foreach ($tokens as $role) {
                if(strlen($role['token'])>=32){
                    static::$roles[$role['token']] = $role['role'];
                }
            }
        }

        if (!isset($_SERVER['PHP_AUTH_USER'])|| !array_key_exists($_SERVER['PHP_AUTH_USER'], static::$roles)) {
            return false;
        }
        static::$role = static::$roles[$_SERVER['PHP_AUTH_USER']];
        Resources::$accessControlFunction = 'AccessControl::verifyAccess';
        return static::$requires == static::$role || static::$role == 'admin';
    }
    /**
     * @access private
     */
    public static function verifyAccess(array $m)
    {
        $requires =
            isset($m['class']['AccessControl']['properties']['requires'])
                ? $m['class']['AccessControl']['properties']['requires']
                : false;
        return $requires
            ? static::$role == 'admin' || static::$role == $requires
            : true;
    }
}