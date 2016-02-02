<?php
/**
 * The actual directory name for the "app".
 */
define('_DS_',     DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(__DIR__)._DS_);
define('APP_DIR',  ROOT_DIR.'app'._DS_);
define('MOD_DIR',  APP_DIR.'libraries'._DS_);
define('WWW_DIR',  __DIR__._DS_);

/**
 * Load the bootstrap file
 *
 * @var \Slim\App $app
 */
$app = require APP_DIR.'bootstrap.php';

/**
 * Go!
 */
$app->run();
