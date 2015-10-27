<?php
date_default_timezone_set('Asia/Jakarta');

if (!defined('_ROOT_')) {
	define('_ROOT_', dirname(dirname(__FILE__)));
}

/**
 * The actual directory name for the "app".
 *
 */
if (!defined('_APP_DIR_')) {
	define('_APP_DIR_', basename(dirname(__FILE__)));
}

if (!defined('_DS_')) {
	define('_DS_', DIRECTORY_SEPARATOR);
}

if (!defined('_FULL_APP_PATH_')) {
	define('_FULL_APP_PATH_', _ROOT_._DS_._APP_DIR_._DS_);
}

if (!defined('_MODULES_DIR_')) {
	define('_MODULES_DIR_', _FULL_APP_PATH_.'protected'._DS_);
}

require 'vendor'._DS_.'autoload.php';
require 'libraries'._DS_.'PlatesTemplate.php';
require 'libraries'._DS_.'Validator.php';
require 'libraries'._DS_.'PlatesUriExtension.php';
require 'libraries'._DS_.'PlatesFlashMessageExtension.php';
require 'libraries'._DS_.'PlatesFormHelperExtension.php';
require 'libraries'._DS_.'Hash.php';

$settings = require 'protected'._DS_.'settings.php';
session_start();
$app = new \Slim\App($settings);

require 'protected'._DS_.'dependencies.php';

$modules = array(
	_MODULES_DIR_.'common-data',
	_MODULES_DIR_.'membership'
);

$includer = new \Aura\Includer\Includer();
$includer->setDirs($modules);
$includer->addFiles(array('*.php'));
$includer->setVars(array('app' => $app));
$includer->load();

require 'protected'._DS_.'middlewares.php';

$app->run();
