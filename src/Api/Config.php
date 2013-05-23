<?php namespace Api;

use Api\IntercafeApi\InterfaceConfig;
use \InvalidArgumentException as Argument;

/**
 * Config carregamento das configurações API Nocriz
 * @abstract
 * @author Ramon Barros
 * @package system
 * @subpackage config
 * @category api,config, design pattern
 */
class Config implements InterfaceConfig {

	/**
	 * The configuration arrays are keyed by their owning file.
	 * @var array
	 */
	private static $items = array();

	/**
	 * A cache of the parsed configuration items.
	 *
	 * @var array
	 */
	public static $cache = array();

	/**
	 * Set a configuration item's value.
	 * <code>
	 * 		// Set the "timezone" option in the "application" configuration file.
	 * 		Config::set('application.timezone','UTC');
	 * </code>
	 * 
	 * @param string $key   
	 * @param mixed  $value
	 * @return void
	 */
	public static function set($key=null,$value=null){
		
		if (empty($key) or empty($value)) {
            throw new Argument('Empty key or value not allowed');
        }

		list($key,$file,$item) =	self::parse($key);
		static::load($file, $item);
		if(is_null($item)){
			static::$items[$file] = $value;
		}else{
			static::$items[$file][$item] = $value;
		}
	}

	/**
	 * Get a configuration item
	 *
	 * <code>
	 * 		// Get the "timezone" option from the "application" configuration file.
	 * 		$timezone = Config::get('application.timezone');
	 * </code>
	 * 
	 * @param  string $key
	 * @return array      
	 */
	public static function get($key){
		if(empty($key)){
			throw new Argument("Empty key not allowed");
		}

		list($key,$file,$item) = self::parse($key);
		static::load($file, $item);
		if(is_null($item) and isset(static::$items[$file])){
			return static::$items[$file];
		}elseif(isset(static::$items[$file][$item])){
			return static::$items[$file][$item];
		}else{
			return false;
		}
	}

	/**
	 * Parse a key and return its bundle, file, and key segments.
	 *
	 * Configuration items are named using the {file}.{item} convention.
	 *
	 * @param  string  $key
	 * @return array
	 */
	protected static function parse($key)
	{
		// First, we'll check the keyed cache of configuration items, as this will
		// be the fastest method of retrieving the configuration option. After an
		// item is parsed, it is always stored in the cache by its key.
		if (array_key_exists($key, static::$cache))
		{
			return static::$cache[$key];
		}

		$segments = explode('.',$key);

		// If there are not at least two segments in the array, it means that the
		// developer is requesting the entire configuration array to be returned.
		// If that is the case, we'll make the item field "null".
		if (count($segments) >= 2)
		{
			$parsed = array($key, $segments[0], implode('.', array_slice($segments, 1)));
		}
		else
		{
			$parsed = array($key, $segments[0], null);
		}
		return static::$cache[$key] = $parsed;
	}

	/**
	 * Load all of the configuration items from a configuration file.
	 *
	 * @param  string  $bundle
	 * @param  string  $file
	 * @return bool
	 */
	public static function load($file, $item)
	{
		if (isset(static::$items[$file][$item])) return true;

		$config = static::file($file);

		// If configuration items were actually found for the bundle and file, we
		// will add them to the configuration array and return true, otherwise
		// we will return false indicating the file was not found.
		if (count($config) > 0)
		{
			static::$items[$file] = $config;
		}
		return isset(static::$items[$file][$item]);
	}

	/**
	 * Load the configuration items from a configuration file.
	 *
	 * @param  string  $bundle
	 * @param  string  $file
	 * @return array
	 */
	public static function file($file)
	{
		$config = array();

		// Configuration files cascade. Typically, the bundle configuration array is
		// loaded first, followed by the environment array, providing the convenient
		// cascading of configuration options across environments.
		foreach (static::paths() as $directory)
		{
			if ($directory !== '' and file_exists($path = $directory.$file.'.php'))
			{
				$config = array_merge($config, require $path);
			}
		}

		return $config;
	}

	/**
	 * Get the array of configuration paths that should be searched for a bundle.
	 *
	 * @param  string  $bundle
	 * @return array
	 */
	protected static function paths($path='.')
	{
		$paths[] = realpath($path).'/src/config/';

		return $paths;
	}
}