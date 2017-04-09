<?php
/**
 * Used for Codeception tests
 */

$config = include __DIR__ . "/config.php";
require(BASE_PATH.'/vendor/autoload.php');    
include __DIR__ . "/loader.php";
$di = new \Phalcon\DI\FactoryDefault();
include __DIR__ . "/services.php";
return new \Phalcon\Mvc\Application($di);