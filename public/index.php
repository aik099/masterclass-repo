<?php

define('FULL_PATH', dirname(__DIR__));

require_once FULL_PATH . '/vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

/*function upvote_autoload($className)
{
	$className = ltrim($className, '\\');
	$fileName = '';

	if ( $lastNsPos = strrpos($className, '\\') ) {
		$namespace = substr($className, 0, $lastNsPos);
		$className = substr($className, $lastNsPos + 1);
		$fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

	require FULL_PATH . DIRECTORY_SEPARATOR . $fileName;
}

spl_autoload_register('upvote_autoload');*/

$config = require_once('../config.php');

$database_factory = new \Upvote\Library\Database\DatabaseFactory();
$framework = new \Upvote\Library\Controller\FrontController($database_factory, $config);
echo $framework->execute();