<?php

ini_set('display_errors',1);
error_reporting(E_ALL | E_STRICT );
date_default_timezone_set('America/Sao_Paulo');

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', realpath(__DIR__.DS.'..'));

$composer_autoload = APP_ROOT.DS.'vendor'.DS.'autoload.php';
if(!file_exists($composer_autoload)){
    die('Please, fucking install composer, http://getcomposer.org');
}
require $composer_autoload;

//require_once APP_ROOT.DS.'vendor'.DS.'luracast'.DS.'restler'.DS.'vendor'.DS.'restler.php';

use Luracast\Restler\Restler;
use Luracast\Restler\Defaults;
use Luracast\Restler\Resources;
use Luracast\Restler\Format\JsonFormat;
use Luracast\Restler\Format\XmlFormat;

Defaults::$smartAutoRouting = false;
Defaults::$useUrlBasedVersioning = true;

$r = new Restler();
/**
 * Para utilizar o API-Explorer 
 */
//$r->addAPIClass('Luracast\\Restler\\Resources'); //this creates resources.json at API Root

//$r->setSupportedFormats('JsonFormat','XmlFormat');
$r->setAPIVersion(1);

/**
 * GET http://localhost/restler/public/client => 401 Unauthorized
 * GET Authorization Basic Njc4OTA6eA== http://localhost/restler/public/client => 200 OK
 */
$r->addAPIClass('Api\\Access');
$r->addAPIClass('Api\\Client');
$r->addAPIClass('Resources');

/**
 * Authorization Control
 */
$r->addAuthenticationClass('AccessControl');

$r->handle();