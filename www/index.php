<?php
/**
 * The actual directory name for the "app".
 */
define('_DS_',     DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(__DIR__).DIRECTORY_SEPARATOR);
define('APP_DIR',  ROOT_DIR.'app'.DIRECTORY_SEPARATOR);
define('RES_DIR',  ROOT_DIR.'resources'.DIRECTORY_SEPARATOR);
define('WWW_DIR',  __DIR__.DIRECTORY_SEPARATOR);

/**
 * Set default timezone
 */
date_default_timezone_set('Asia/Jakarta');

/**
 * Load all composer dependencies
 */
require ROOT_DIR.'vendor/autoload.php';

/**
 * Create new Slim\App instance
 *
 * @var Slim\App $app
 */
$app = new Slim\App(
    require RES_DIR.'container.php'
);

require RES_DIR.'routes.php';

/**
 * Go!
 */
$app->run();
