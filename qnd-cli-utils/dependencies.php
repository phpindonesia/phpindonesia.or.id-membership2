<?php
$container['settings'] = function ($container) {
    $settings = require 'settings.php';
    return $settings['settings'];
};

$container['db'] = function ($container) {
    $connection_params = $container['settings']['db'];
    $config = new \Doctrine\DBAL\Configuration();
    $db = \Doctrine\DBAL\DriverManager::getConnection($connection_params, $config);

    return $db;
};

$container['mailer'] = function ($container) {
    $smtp_account = $container['settings']['smtp'];
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
