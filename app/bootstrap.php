<?php
/**
 * Set default timezone
 */
date_default_timezone_set('Asia/Jakarta');

/**
 * Load all composer dependencies
 */
require ROOT_DIR.'vendor/autoload.php';

/**
 * Create new Slim\App instance
 *
 * @var Slim\App $app
 */
$app = new Slim\App(require APP_DIR.'container.php');

$app->add(function ($request, $response, $next) {
    if (!empty($inputs = $request->getParsedBody())) {
        $request = $request->withParsedBody(array_filter($inputs, function (&$value) {
            if (is_string($value)) {
                $value = filter_var(trim($value), FILTER_SANITIZE_STRING);
            }
            return $value ?: null;
        }));
    }

    return $next($request, $response);
});

$app->add(new Membership\Middlewares\Authentication(
    $app->getContainer()->get('settings')['publicRoutes'],
    $app->getContainer()->get('flash'),
    $app->getContainer()->get('router')
));

require APP_DIR.'routes.php';

return $app;
