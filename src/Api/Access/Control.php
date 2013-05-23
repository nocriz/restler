<?php namespace Api\Access;

use \Database\DB as DB;
use \Luracast\Restler\iAuthenticate;
use \Luracast\Restler\Resources;

class Control implements iAuthenticate
{
    public static $requires = 'client';
    public static $role = 'client';

    public function setRole($role=''){
        static::$role = $role;
    }

    public function __isAllowed()
    {
        DB::table(static::$role)->where('token',$_SERVER['PHP_AUTH_USER']);
        $table = DB::get(array('token'))->RowAssoc();
        $roles[$table['token']]=static::$role;
        var_dump($roles);
        if (!isset($_SERVER['PHP_AUTH_USER'])|| !array_key_exists($_SERVER['PHP_AUTH_USER'], $roles)) {
            return false;
        }
        static::$role = $roles[$_SERVER['PHP_AUTH_USER']];
        Resources::$accessControlFunction = 'Control::verifyAccess';
        return static::$requires == static::$role || static::$role == 'admin';
    }
    /**
     * @access private
     */
    public static function verifyAccess(array $m)
    {
        $requires =
            isset($m['class']['Control']['properties']['requires'])
                ? $m['class']['Control']['properties']['requires']
                : false;
        return $requires
            ? static::$role == 'admin' || static::$role == $requires
            : true;
    }
}