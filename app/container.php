<?php

use Slim\Collection;
use Slim\Container;
use Slim\Handlers\Error as SlimError;
use League\Plates\Extension\Asset as PlatesAsset;
use Psr\Http\Message\UploadedFileInterface;
use Valitron\Validator;
use Membership\Models;

/**
 * Settings file
 */
file_exists($settingsFile = APP_DIR.'settings.php') || die ('Setting file not available');

session_start();

/**
 * Load environment variables
 */
$envPath = null;
foreach ([__DIR__.'/.env', dirname(__DIR__).'/.env'] as $envFile) {
    if (file_exists($envFile)) {
        $envPath = dirname($envFile);
        break;
    }
}

(new \Dotenv\Dotenv($envPath))->load();

/**
 * Slim Container
 *
 * @var Container $container
 */
$container = new Container([
    'settings' => require $settingsFile
]);

/**
 * Application setting.
 *
 * @param Container $container
 * @return callable
 */
$container['setting'] = function ($container) {
    /**
     * @param string $name
     * @param mixed $default
     * @return array|string
     */
    return function ($name, $default = null) use ($container) {
        $settings = $container->get('settings');

        return array_key_exists($name, $settings) ? $settings[$name] : $default;
    };
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
            return $container->get('view')->render('error::500', [
                'message' => $exception->getMessage()
            ])->withStatus(500);
        };
    }

    return new SlimError(true);
};

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
 * @return Membership\Database
 */
$container['db'] = function ($container) {
    $settings = $container->get('settings')->get('db');

    if (!isset($settings['dsn'])) {
        $settings['dsn'] = sprintf(
            '%s:host=%s;dbname=%s',
            $settings['driver'],
            $settings['host'],
            $settings['dbname']
        );
    }

    return new Membership\Database($settings['dsn'], $settings['username'], $settings['password']);
};

/**
 * Setup validator container
 *
 * @param Container $container
 * @return \Valitron\Validator
 */
$container['validator'] = function ($container) {
    $request = $container->get('request');
    $viewData = $container->get('view')->getPlates()->getData('section::captcha');
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
        $viewSettings = $settings->get('view')
    );

    // Add app view folders
    $view->addFolder('email',   $viewSettings['directory'].DIRECTORY_SEPARATOR.'_emails');
    $view->addFolder('error',   $viewSettings['directory'].DIRECTORY_SEPARATOR.'_errors');
    $view->addFolder('layout',  $viewSettings['directory'].DIRECTORY_SEPARATOR.'_layouts');
    $view->addFolder('section', $viewSettings['directory'].DIRECTORY_SEPARATOR.'_sections');

    // Load app view extensions
    $view->loadExtension(new PlatesAsset(ROOT_DIR));
    $view->loadExtension(new Membership\ViewExtension(
        $request = $container->get('request'),
        $container->get('flash'),
        $settings->get('mode')
    ));
    $view->loadExtension(new Projek\Slim\PlatesExtension($container->get('router'), $request->getUri()));

    return $view;
};

/**
 * PSR-7 Request object
 *
 * @param Container $container
 *
 * @return \Membership\Http\Request
 */
$container['request'] = function ($container) {
    return \Membership\Http\Request::createFromEnvironment($container->get('environment'));
};

/**
 * PSR-7 Response object
 *
 * @param Container $container
 *
 * @return \Membership\Http\Response
 */
$container['response'] = function ($container) {
    $headers = new \Slim\Http\Headers(['Content-Type' => 'text/html; charset=UTF-8']);
    $response = new \Membership\Http\Response(200, $headers);

    $response->setView($container->get('view'));

    return $response->withProtocolVersion($container->get('settings')['httpVersion']);
};

/**
 * Setup upload handler container
 *
 * @return \Http\Client\Curl\Client
 */
$container['httpClient'] = function () {
    return new \Http\Client\Curl\Client(
        new \Http\Message\MessageFactory\SlimMessageFactory(),
        new \Http\Message\StreamFactory\SlimStreamFactory()
    );
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
 * Setup SparkPost mailer
 *
 * @param Container $container
 * @return \Membership\Mail\SparkpostMessage
 */
$container[\Membership\Mail\SparkpostMessage::class] = function ($container) {
    $mailer = new \SparkPost\SparkPost($container->get('httpClient'), [
        'key' => $container->get('settings')['sparkpost']['api_key']
    ]);

    return new \Membership\Mail\SparkpostMessage($mailer);
};

/**
 * Setup SMTP mailer
 *
 * @param Container $container
 * @return \Membership\Mail\SmtpMessage
 */
$container[\Membership\Mail\SmtpMessage::class] = function ($container) {
    $mailer = new \PHPMailer(true);
    $settings = $container->get('settings')->get('mail');

    $mailer->Host = $settings['host'];
    $mailer->Port = $settings['port'];
    $mailer->Username = $settings['username'];
    $mailer->Password = $settings['password'];

    $mailer->isSMTP();

    $mailer->SMTPAuth = $settings['auth'];
    $mailer->SMTPSecure = $settings['secure'];

    return new \Membership\Mail\SmtpMessage($mailer);
};

/**
 * Setup mailer container
 *
 * @param Container $container
 * @return Membership\Mail
 */
$container['mail'] = function ($container) {
    $settings = $container->get('settings');
    $drivers = [
        'smtp' => \Membership\Mail\SmtpMessage::class,
        'sparkpost' => \Membership\Mail\SparkpostMessage::class,
    ];

    if (! array_key_exists($settings['mail']['driver'], $drivers)) {
        throw new InvalidArgumentException('No mail driver found');
    }

    $driver = $settings['mail']['driver'];

    return new Membership\Mail($container->get($drivers[$driver]), $container->get('view'), $settings['app']);
};

return $container;
