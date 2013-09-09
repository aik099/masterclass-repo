<?php

define('FULL_PATH', dirname(__DIR__));

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

function upvote_autoload($className)
{
	$className = ltrim($className, '\\');
	$fileName = '';

	if ( $lastNsPos = strrpos($className, '\\') ) {
		$namespace = substr($className, 0, $lastNsPos);
		$className = substr($className, $lastNsPos + 1);
		$fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

	require $fileName;
}

set_include_path(get_include_path() . ':' . FULL_PATH);
spl_autoload_register('upvote_autoload');

$config = require_once('../config.php');

$framework = new \Upvote\Library\Front\Controller($config);
echo $framework->execute();