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

/*
 Title: Hello World Example.
 Tagline: Let's say hello!.
 Description: Basic hello world example to get started with Restler 2.0.
 Example 1: GET say/hello returns "Hello world!".
 Example 2: GET say/hello/Restler2.0 returns "Hello Restler2.0!".
 Example 3: GET say/hello?to=R.Arul%20Kumaran returns "Hello R.Arul Kumaran!".
 */
require_once APP_ROOT.DS.'vendor'.DS.'luracast'.DS.'restler'.DS.'vendor'.DS.'restler.php';

use Luracast\Restler\Restler;
use Luracast\Restler\Defaults;
use Luracast\Restler\Resources;

Defaults::$smartAutoRouting = false;
Defaults::$useUrlBasedVersioning = true;

$r = new Restler();
/**
 * Para utilizar o API-Explorer 
 */
$r->addAPIClass('Luracast\\Restler\\Resources'); //this creates resources.json at API Root

$r->setSupportedFormats('JsonFormat','XmlFormat');
$r->setAPIVersion(1);

/**
 * GET http://localhost/restler/public/client => 401 Unauthorized
 * GET Authorization Basic Njc4OTA6eA== http://localhost/restler/public/client => 200 OK
 */
$r->addAPIClass('Api\\Client');
//$r->addAPIClass('Api\\Authors');

/**
 * GET http://localhost/restler/public/access/admin => 401 Unauthorized
 * GET Authorization Basic Njc4OTA6eA== http://localhost/restler/public/access/admin => 200 OK
 */
//$r->addAPIClass('Api\\Access');

/**
 * Authorization Control
 */
$r->addAuthenticationClass('Api\\AccessControl');

$r->handle();