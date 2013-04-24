<?php namespace Api;
use \Luracast\Restler\iAuthenticate;
use \Luracast\Restler\Resources;
class AccessControl implements iAuthenticate
{
    public static $requires = 'user';
    public static $role = 'user';
    public function __isAllowed()
    {
        $roles = array('033d888e4b5223a90989350c0d7dc044' => 'user', '67890' => 'admin');
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