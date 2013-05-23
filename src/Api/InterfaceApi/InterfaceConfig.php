<?php namespace Api\InterfaceApi;

/**
 * Interface para carregamento das configurações API Nocriz
 * @abstract
 * @author Ramon Barros
 * @package system
 * @subpackage config
 * @category api,system, design pattern
 */
interface InterfaceConfig {

	public static function set($key,$value);
	public static function get($key);
	protected static function parse($key);
	public static function load($file,$item);
	public static function file($file);
	protected static function paths($path);
}