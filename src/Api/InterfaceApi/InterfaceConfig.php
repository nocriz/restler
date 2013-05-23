<?php namespace Api\InterfaceApi;

/**
 * Interface para carregamento das configurações API Nocriz
 * @abstract
 * @author Ramon Barros
 * @package restler
 * @subpackage config
 * @category api
 */
interface InterfaceConfig {
	public static function set($key,$value);
	public static function get($key);
	public static function load($file,$item);
	public static function file($file);
}