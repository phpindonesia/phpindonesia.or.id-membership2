<?php
use Doctrine\DBAL;
use App\Libraries\Validator;
use Slim\Views\PlatesTemplate;
use Slim\Flash\Messages as SlimFlash;
use Slim\Handlers\Error as SlimError;
use League\Plates\Extension as PlatesExtension;

$container = $app->getContainer();

$container['db'] = function ($container) {
    return DBAL\DriverManager::getConnection(
        $container->get('settings')['db'],
        new DBAL\Configuration()
    );
};

// Setup cloudinary config before view
Cloudinary::config($container->get('settings')['cloudinary']);

$container['view'] = function ($container) {
    $view_cfg = $container->get('settings')['view'];
    $view = new PlatesTemplate($view_cfg['template_path']);

    $view->loadExtension(new PlatesExtension\Asset(_FULL_APP_PATH_.'public'));
    $view->loadExtension(new PlatesExtension\PlatesUriExtension($container->get('request')->getUri(), $container->get('router'), $container->get('settings')));
    $view->loadExtension(new PlatesExtension\PlatesFlashMessageExtension($container->get('flash')));
    $view->loadExtension(new PlatesExtension\PlatesFormHelperExtension($container->get('request')->getMethod()));

    $view->addFolder('layouts', $view_cfg['template_path']._DS_.'layouts');
    $view->addFolder('sections', $view_cfg['template_path']._DS_.'sections');

    /*
     * Registering some view helper / extensions functions
     * Actually this is not a middleware. I just put it here
     */
    $plates = $view->getPlates();
    $plates->registerFunction('append_js', function (array $js_files = []) use ($plates) {
        $plates->addData(['_view_js_' => $js_files]);
    });

    $plates->registerFunction('append_css', function (array $css_files = []) use ($plates) {
        $plates->addData(['_view_css_' => $css_files]);
    });

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

$container['validator'] = function ($container) {
    return new Validator($container->get('view')->getPlates());
};

$container['flash'] = function () {
    return new SlimFlash;
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

$container['errorHandler'] = function ($container) {
    if ($container->get('settings')['mode'] == 'production') {
        return function ($request, $response, $exception) use ($container) {
            $response_n = $container['response']
                ->withStatus(500)
                ->withHeader('Content-Type', 'text/html');

            return $container->get('view')->render(
                $response_n,
                'error/error500',
                ['message' => $exception->getMessage()]
            );
        };
    } else if ($container->get('settings')['mode'] == 'development') {
        return new SlimError(true);
    }
};
