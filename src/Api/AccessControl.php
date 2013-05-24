<?php namespace Api;

use Models\ModelClient;
use \Luracast\Restler\iAuthenticate;
use \Luracast\Restler\Resources;
class AccessControl implements iAuthenticate
{
    public static $requires = 'client';
    public static $role = 'client';
    public function __isAllowed()
    {
        $token = isset($_SERVER['PHP_AUTH_USER'])?$_SERVER['PHP_AUTH_USER']:null;
        //var_dump(ModelClient::token($token)); 
        //var_dump($roles);
        $roles = array('b599cfee8a52251902ed4a52cbe635cf' => 'client', '123456' => 'admin');
        //var_dump($roles);
        if (!isset($_SERVER['PHP_AUTH_USER'])|| !array_key_exists($_SERVER['PHP_AUTH_USER'], $roles)) {
            return false;
        }
        static::$role = $roles[$_SERVER['PHP_AUTH_USER']];
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