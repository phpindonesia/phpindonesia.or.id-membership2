<?php
return [
    'mode' => 'development',

    'salt_pwd' => 'dev-spirit',

    'app' => [
        'name'  => 'PHP Indonesia - Membership App',
        'email' => 'admin@membership.phpindinesia.id',
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
        'host'     => env('MAIL_HOST', 'mailtrap.io'),
        'port'     => env('MAIL_PORT', 2525),
        'username' => env('MAIL_USER'),
        'password' => env('MAIL_PASS'),
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
