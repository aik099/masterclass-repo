<?php
define('FULL_PATH', realpath(__DIR__ . '/..'));

$vendor_path = FULL_PATH . '/vendor';

if ( !is_dir($vendor_path) ) {
	echo 'Install dependencies first' . PHP_EOL;
	exit(1);
}

require_once ($vendor_path . '/autoload.php');

$auto_loader = new \Composer\Autoload\ClassLoader();
$auto_loader->add("Upvote\\", FULL_PATH);
$auto_loader->add("tests\\Upvote\\", FULL_PATH . '/');
$auto_loader->register();
