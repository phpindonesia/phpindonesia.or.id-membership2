<?php

$mail_url = parse_url(env('MAIL_URL', 'smtp://username:@mailrap.io:2525'));

return [
    'mode' => 'development',

    'salt_pwd' => 'dev-spirit',

    'app' => [
        'name'  => 'PHP Indonesia - Membership App',
        'email' => 'admin@membership.phpindonesia.id',
        'url' => 'membership.phpindonesia.id',
        'home_url' => 'phpindonesia.id'
    ],

    'db' => [
        'driver'   => env('DB_DRIVER', 'mysql'),
        'host'     => env('DB_HOST', 'localhost'),
        'username' => env('DB_USER', 'root'),
        'password' => env('DB_PASS'),
        'dbname'   => env('DB_NAME'),
    ],

    'mail' => [
        'driver'   => env('MAIL_DRIVER', $mail_url['scheme']),
        'host'     => env('MAIL_HOST', $mail_url['host']),
        'port'     => env('MAIL_PORT', $mail_url['port']),
        'username' => env('MAIL_USER', $mail_url['user']),
        'password' => env('MAIL_PASS', $mail_url['pass']),
    ],

    'gcaptcha' => [
        'enable'  => true,
        'sitekey' => env('GCAPTCHA_KEY'),
        'secret'  => env('GCAPTCHA_SECRET')
    ],

    'cloudinary' => [
        'cloud_name' => env('CLOUDINARY_NAME'),
        'api_key'    => env('CLOUDINARY_KEY'),
        'api_secret' => env('CLOUDINARY_SECRET'),
    ],

    'sparkpost' => [
        'api_key' => env('SPARKPOST_API_KEY')
    ],

    'view' => [
        'directory'     => APP_DIR.'views',
        'fileExtension' => 'php',
    ],

    'socmedias' => [
        'facebook'  => ['Facebook',  'fa-facebook',    'http://facebook.com/'],
        'twitter'   => ['Twitter',   'fa-twitter',     'http://twitter.com/'],
        'linkedin'  => ['LinkedIn',  'fa-linkedin',    'http://linkedin.com/in/'],
        'instagram' => ['Instagram', 'fa-instagram',   'http://instagram.com/'],
        'path'      => ['Path',      'fa-pinterest-p', 'http://path.com/'],
        'github'    => ['GitHub',    'fa-github',      'http://github.com/'],
    ],
];
