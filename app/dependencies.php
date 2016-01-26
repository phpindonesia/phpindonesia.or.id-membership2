<?php
/**
 * Slim Container
 *
 * @var \Slim\Container $container
 */
$container = $app->getContainer();

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
 * Setup validator container
 */
$container['validator'] = function ($container) {
    $params = $container->get('request')->getParams();

    return new Valitron\Validator($params, [], 'id');
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

$container['months'] = function ($container) {
    return [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ];
};

$container['years_range'] = function ($container) {
    $start_year = 1990;
    $end_year = (int) date('Y');
    $years_range = [];

    foreach (range($start_year, $end_year) as $item) {
        $item_str = (string) $item;
        $years_range[$item_str] = $item;
    }

    return $years_range;
};

$container['months_range'] = function ($container) {
    $months = $container->get('months');
    $months_range = [];

    foreach (range(1, 12) as $item) {
        $item_str = ''.$item;
        $item_str = strlen($item_str) > 1 ? $item_str : '0'.$item_str;
        $months_range[$item_str] = $months[$item_str];
    }

    return $months_range;
};

$container['days_range'] = function ($container) {
    $days_range = [];

    foreach (range(1, 31) as $item) {
        $item_str = ''.$item;
        $item_str = strlen($item_str) > 1 ? $item_str : '0'.$item_str;
        $days_range[$item_str] = $item_str;
    }

    return $days_range;
};
