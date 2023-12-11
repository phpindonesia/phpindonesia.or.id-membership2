<?php

use Slim\Collection;
use Slim\Container;
use Slim\Handlers\Error as SlimError;
use League\Plates\Extension\Asset as PlatesAsset;
use Psr\Http\Message\UploadedFileInterface;
use Valitron\Validator;
use Membership\Models;
use Membership\Libraries;
use Membership\Libraries\PDO\Database;

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
 *
 * @return Collection
 */
$container['session'] = function () {
    if (!isset($_SESSION['MembershipAuth'])) {
        $_SESSION['MembershipAuth'] = [];
    }

    return new Collection($_SESSION['MembershipAuth']);
};

/**
 * Setup database container
 *
 * @param Container $container
 * @return Database
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
 *
 * @param Container $container
 * @return callable
 */
$container['data'] = function ($container) {
    $db = $container->get('db');
    $session = $container->get('session');

    return function ($class) use ($db, $session) {
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

        return $model->newInstance($db, $session);
    };
};

/**
 * Setup validator container
 *
 * @param Container $container
 * @return \Valitron\Validator
 */
$container['validator'] = function ($container) {
    $request = $container->get('request');
    $viewData = $container->get('view')->getPlates()->getData('sections::captcha');
    $validator = new Validator($request->getParams(), [], 'id');

    if ($viewData['gcaptchaEnable'] == true) {
        $remoteAddr = $container->get('environment')->get('REMOTE_ADDR');

        $validator->addRule('verifyCaptcha', function ($field, $value, array $params) use ($viewData, $remoteAddr) {
            if (isset($field['g-recaptcha-response'])) {
                $recaptcha = new ReCaptcha\ReCaptcha($viewData['gcaptchaSecret']);

                return $recaptcha->verify($field['g-recaptcha-response'], $remoteAddr)->isSuccess();
            }
            return false;
        }, 'Verifikasi captcha salah!');

        $validator->rule('verifyCaptcha', 'captcha');
    }

    return $validator;
};

/**
 * Setup flash message container
 *
 * @return \Slim\Flash\Messages
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
 *
 * @param Container $container
 * @return \Projek\Slim\Plates
 */
$container['view'] = function ($container) {
    $settings = $container->get('settings');
    $view = new Projek\Slim\Plates(
        $viewSettings = $settings->get('view'),
        $container->get('response')
    );

    // Add app view folders
    $view->addFolder('emails',   $viewSettings['directory'].'/emails');
    $view->addFolder('layouts',  $viewSettings['directory'].'/layouts');
    $view->addFolder('sections', $viewSettings['directory'].'/sections');

    // Load app view extensions
    $view->loadExtension(new PlatesAsset(WWW_DIR));
    $view->loadExtension(new Libraries\ViewExtension(
        $request = $container->get('request'),
        $container->get('flash'),
        $settings
    ));
    $view->loadExtension(new Projek\Slim\PlatesExtension($container->get('router'), $request->getUri()));

    return $view;
};

/**
 * Setup upload handler container
 *
 * @param Container $container
 * @return callable
 */
$container['upload'] = function ($container) {
    $settings = $container->get('settings');
    $session = $container->get('session');

    /**
     * Upload callabel
     *
     * @param UploadedFileInterface $photo
     * @param string[] $memberData
     * @return string[]
     */
    return function (UploadedFileInterface $photo, $memberData) use ($settings, $session) {
        if ($photo->getError() !== UPLOAD_ERR_OK) {
            return $memberData;
        }

        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($photo->getClientMediaType(), $allowedTypes)) {
            throw new InvalidArgumentException('We only accept jpg and png image');
        }

        $ext = strtolower(pathinfo($photo->getClientFilename(), PATHINFO_EXTENSION));
        $cdnTargetPath = 'phpindonesia/' . $settings['mode'] . '/';
        $newFileName = $session->get('user_id') . '-' . date('YmdHis');

        Cloudinary\Uploader::upload($photo->file, [
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

        return $memberData;
    };
};

/**
 * Setup smtp mailer container
 *
 * @param Container $container
 * @return Libraries\Mailer
 */
$container['mailer'] = function ($container) {

    $view = $container->get('view')->getPlates();
    $settings = $container->get('settings');
    $appSetting = $settings->get('app');

    $mailer = new Libraries\Mailer($settings->get('mailer'), $view);

    $mailer->debugMode($settings->get('mode'));
    $mailer->setSender($appSetting['email'], $appSetting['name']);

    return $mailer;
};

/**
 * Custom error handler
 *
 * TODO: need more!!!
 *
 * @param Container $container
 * @return callable
 */
$container['errorHandler'] = function ($container) {
    if ($container->get('settings')['mode'] !== 'development') {
        /**
         * @param \Slim\Http\Request $request
         * @param \Slim\Http\Response $response
         * @param \Exception $exception
         */
        return function ($request, $response, $exception) use ($container) {
            return $container->get('view')->render('errors/500', [
                'message' => $exception->getMessage()
            ])->withStatus(500);
        };
    }

    return new SlimError(true);
};

return $container;
