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

$r = new Restler();
$r->addAPIClass('Say');
$r->handle();