<?php

use Slim\Collection;
use Slim\Container;
use Slim\PDO\Database;
use Slim\Handlers\Error as SlimError;
use League\Plates\Extension\Asset as PlatesAsset;
use Psr\Http\Message\UploadedFileInterface;
use Valitron\Validator;
use Membership\Models;

/**
 * Settings file
 */
$settingsFile = APP_DIR.'settings.php';
file_exists($settingsFile) || die ('Setting file not available');

session_start();

/**
 * Slim Container
 *
 * @var \Slim\Container $container
 */
$container = new Container([
    'settings' => require $settingsFile
]);

/**
 * Setup session
 */
$container['session'] = function ($container) {
    if (!isset($_SESSION['MembershipAuth'])) {
        $_SESSION['MembershipAuth'] = [];
    }

    return new Collection($_SESSION['MembershipAuth']);
};

/**
 * Setup database container
 */
$container['db'] = function ($container) {
    $db = $container->get('settings')['db'];
    if (!isset($db['dsn'])) {
        $db['dsn'] = sprintf('%s:host=%s;dbname=%s', $db['driver'], $db['host'], $db['dbname']);
    }

    return new Database($db['dsn'], $db['username'], $db['password']);
};

/**
 * Setup data model container
 */
$container['data'] = function ($container) {
    $db = $container->get('db');

    return function ($class) use ($db) {
        if (!class_exists($class)) {
            throw new LogicException("Data model class {$class} not exists ");
        }

        $model = new ReflectionClass($class);

        if (!$model->isSubclassOf(Models::class)) {
            throw new InvalidArgumentException(sprintf(
                'Data model must be instance of %s, %s given',
                Models::class,
                $model->getName()
            ));
        }

        return $model->newInstance($db);
    };
};

/**
 * Setup validator container
 */
$container['validator'] = function ($container) {
    $request = $container->get('request');
    $validator = new Validator($request->getParams(), [], 'id');

    return $validator;
};

/**
 * Setup flash message container
 */
$container['flash'] = function () {
    return new Slim\Flash\Messages;
};

/**
 * Setup cloudinary config before view
 */
Cloudinary::config($container->get('settings')['cloudinary']);

/**
 * Setup view container
 */
$container['view'] = function ($container) {
    $settings = $container->get('settings')['view'];
    $request = $container->get('request');
    $view = new Projek\Slim\Plates($settings, $container->get('response'));

    // Add app view folders
    $view->addFolder('layouts',  $settings['directory'].'/layouts');
    $view->addFolder('sections', $settings['directory'].'/sections');

    // Load app view extensions
    $view->loadExtension(new PlatesAsset(WWW_DIR));
    $view->loadExtension(new Membership\ViewExtension($request, $container->get('flash')));
    $view->loadExtension(new Projek\Slim\PlatesExtension($container->get('router'), $request->getUri()));

    return $view;
};

/**
 * Setup upload handler container
 */
$container['upload'] = function ($container) {
    $settings = $container->get('settings');
    $session = $container->get('session');

    return function (UploadedFileInterface $file, &$memberData) use ($settings, $session) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($file->getClientMediaType(), $allowedTypes)) {
            throw new InvalidArgumentException('We only accept jpg and png image');
        }

        $ext = strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
        $cdnTargetPath = 'phpindonesia/' . $settings['mode'] . '/';
        $newFileName = $session->get('user_id') . '-' . date('YmdHis');

        Cloudinary\Uploader::upload((string) $file->getStream(), [
            'public_id' => $cdnTargetPath . $newFileName,
            'tags' => ['user-avatar'],
        ]);

        $memberData['photo'] = $newFileName . '.' . $ext;

        if ($session->get('photo')) {
            $api = new Cloudinary\Api;
            $publicId = str_replace('.'.$ext, '', $session->get('photo'));

            $api->delete_resources($cdnTargetPath . $publicId, [
                'public_id' => $cdnTargetPath . $newFileName,
                'tags' => ['user-avatar'],
            ]);

            $session->set('photo', $memberData['photo']);
        }
    };
};

/**
 * Setup mailer container
 *
 * TODO: will replaced with PHPMailer
 */
$container['mailer'] = function ($container) {
    $smtp_account = $container->get('settings')['smtp'];
    $transport = null;

    if ($smtp_account['ssl']) {
        $transport = Swift_SmtpTransport::newInstance($smtp_account['host'], $smtp_account['port'], 'ssl');
    } else {
        $transport = Swift_SmtpTransport::newInstance($smtp_account['host'], $smtp_account['port']);
    }

    $transport->setUsername($smtp_account['username']);
    $transport->setPassword($smtp_account['password']);

    $mailer = Swift_Mailer::newInstance($transport);
    return $mailer;
};

/**
 * Custom error handler
 *
 * TODO: need more!!!
 */
$container['errorHandler'] = function ($container) {
    if ($container->get('settings')['mode'] !== 'development') {
        return function ($request, $response, $exception) use ($container) {
            return $container->get('view')->render('error/error500', [
                'message' => $exception->getMessage()
            ])->withStatus(500);
        };
    }

    return new SlimError(true);
};

return $container;
