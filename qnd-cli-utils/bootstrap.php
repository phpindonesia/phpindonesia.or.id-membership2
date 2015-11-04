<?php
date_default_timezone_set('Asia/Jakarta');

if (!defined('_ROOT_')) {
    define('_ROOT_', dirname(dirname(__FILE__)));
}

if (!defined('_DS_')) {
    define('_DS_', DIRECTORY_SEPARATOR);
}

require _ROOT_._DS_.'vendor'._DS_.'autoload.php';

$container = new \Pimple\Container();

require 'dependencies.php';
