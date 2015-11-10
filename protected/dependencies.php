<?php
$container = $app->getContainer();

$container['db'] = function ($container) {
	$connection_params = $container->get('settings')['db'];
	$config = new \Doctrine\DBAL\Configuration();
	$db = \Doctrine\DBAL\DriverManager::getConnection($connection_params, $config);

	return $db;
};

// Setup cloudinary config before view
\Cloudinary::config($container->get('settings')['cloudinary']);

$container['view'] = function ($container) {
	$view_cfg = $container->get('settings')['view'];
	$view = new \Slim\Views\PlatesTemplate($view_cfg['template_path']);

	$view->loadExtension(new \League\Plates\Extension\Asset(_FULL_APP_PATH_.'public'));
	$view->loadExtension(new \League\Plates\Extension\PlatesUriExtension($container->get('request')->getUri(), $container->get('router')));
	$view->loadExtension(new \League\Plates\Extension\PlatesFlashMessageExtension($container->get('flash')));
	$view->loadExtension(new \League\Plates\Extension\PlatesFormHelperExtension($container->get('request')->getMethod()));

	$view->addFolder('layouts', $view_cfg['template_path']._DS_.'layouts');
	$view->addFolder('sections', $view_cfg['template_path']._DS_.'sections');

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
	return new \App\Libraries\Validator($container->get('view')->getPlates());
};

$container['flash'] = function ($container) {
	return new \Slim\Flash\Messages;
};

$container['months'] = function ($container) {
	return array(
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
	);
};

$container['years_range'] = function ($container) {
	$start_year = 1990;
	$end_year = (int) date('Y');
	$years_range = array();

	foreach (range($start_year, $end_year) as $item) {
		$item_str = (string) $item;
		$years_range[$item_str] = $item;
	}

	return $years_range;
};

$container['months_range'] = function ($container) {
	$months = $container->get('months');
	$months_range = array();

	foreach (range(1,12) as $item) {
		$item_str = ''.$item;
		$item_str = strlen($item_str) > 1 ? $item_str : '0'.$item_str;
		$months_range[$item_str] = $months[$item_str];
	}

	return $months_range;
};

$container['days_range'] = function ($container) {
	$days_range = array();

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
                array('message' => $exception->getMessage())
            );
        };

    } else if ($container->get('settings')['mode'] == 'development') {
        return new \Slim\Handlers\Error;
    }
};
