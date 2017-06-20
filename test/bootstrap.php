<?php

define('ROOT_PATH', dirname(__DIR__));

/* @var $composer \Composer\Autoload\ClassLoader */
$composer = require_once ROOT_PATH . '/vendor/autoload.php';
$composer->setPsr4('BD\\pdf\\', ROOT_PATH . '/src');
