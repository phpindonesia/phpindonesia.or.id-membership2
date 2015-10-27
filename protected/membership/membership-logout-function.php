<?php
$app->get('/apps/membership/logout', function ($request, $response, $args) {

    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();
    return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-login'));

})->setName('membership-logout');
