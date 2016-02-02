<?php
/**
 * Slim Container
 *
 * @var \Slim\Container $container
 */
$container = $app->getContainer();

/**
 * Setup session
 */
$container['session'] = function ($container) {
    if (!isset($_SESSION['MembershipAuth'])) {
        $_SESSION['MembershipAuth'] = [];
    }
    $session =& $_SESSION['MembershipAuth'];

    return new Slim\Collection($session);
};

/**
 * Setup database container
 */
$container['db'] = function ($container) {
    $db = $container->get('settings')['db'];
    if (!isset($db['dsn'])) {
        $db['dsn'] = sprintf('%s:host=%s;dbname=%s', $db['driver'], $db['host'], $db['dbname']);
    }

    return new Slim\PDO\Database($db['dsn'], $db['username'], $db['password']);
};

/**
 * Setup data model container
 */
$container['data'] = function ($container) {
    $db = $container->get('db');
    $session = $container->get('session');

    return function ($class) use ($db, $session) {
        if (!class_exists($class)) {
            throw new LogicException("Data model class {$class} not exists ");
        }

        $model = new ReflectionClass($class);

        if (!$model->isSubclassOf(Membership\Models::class)) {
            throw new InvalidArgumentException(sprintf(
                'Data model must be instance of %s, %s given',
                Membership\Models::class,
                $model->getName()
            ));
        }

        return $model->newInstance($db, $session);
    };
};

/**
 * Setup validator container
 */
$container['validator'] = function ($container) {
    $request = $container->get('request');
    $validator = new Valitron\Validator($request->getParams(), [], 'id');

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
    $view->loadExtension(new League\Plates\Extension\Asset(ROOT_DIR.'www'));
    $view->loadExtension(new Membership\ViewExtension($request, $container->get('flash')));
    $view->loadExtension(new Projek\Slim\PlatesExtension($container->get('router'), $request->getUri()));

    return $view;
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

    return new Slim\Handlers\Error(true);
};
