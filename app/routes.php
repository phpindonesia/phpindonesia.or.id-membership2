<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Models;
use Membership\Controllers\HomeController;
use Membership\Controllers\AccountController;
use Membership\Controllers\PasswordController;
use Membership\Controllers\PortfoliosController;
use Membership\Controllers\ProfileController;
use Membership\Controllers\SkillsController;
use Membership\Controllers\RegionalsController;

/**
 * Input string sanitizer middleware
 */
$app->add(function (Request $request, Response $response, callable $next) {

    if ($inputs = $request->getParsedBody()) {
        $inputs = array_filter($inputs, function (&$value) {
            if (is_string($value)) {
                $value = filter_var(trim($value), FILTER_SANITIZE_STRING);
            }
            return $value ?: null;
        });

        if (isset($inputs['_METHOD']) && $request->getMethod() == $inputs['_METHOD']) {
            unset($inputs['_METHOD']);
        }

        $request = $request->withParsedBody($inputs);
    }

    if ($request->getContentType() == 'application/json') {
        $request = $request->withHeader('X-Requested-With', 'XMLHttpRequest');
    }

    return $next($request, $response);

});

/**
 * Route definitions
 *
 * - All GET Routes should be named
 * - Every request method (GET, POST, UPDATE, DELETE) with same path should resolve by different class method
 */
$app->get('/', HomeController::class.':index')->setName('membership-index');

// Login end-point
$app->get('/login', HomeController::class.':loginPage')->setName('membership-login');
$app->post('/login', HomeController::class.':login');

// Registration end-point
$app->get('/register', HomeController::class.':registerPage')->setName('membership-register');
$app->post('/register', HomeController::class.':register');

// Logout end-point
$app->get('/logout', HomeController::class.':logout')->setName('membership-logout');

// Forgot password end-point
$app->get('/forgot-password', PasswordController::class.':forgotPage')->setName('membership-forgot-password');
$app->post('/forgot-password', PasswordController::class.':forgot');

// Reset password end-point
$app->get('/reset-password/{uid:[0-9]}/{reset_key}', PasswordController::class.':reset')->setName('membership-reset-password');

// Account activation end-point
$app->get('/activate/{uid:[0-9]}/{activation_key}', AccountController::class.':activate')->setName('membership-activation');

// Account reactivation end-point
// TODO: need tobe done
$app->get('/reactivate', AccountController::class.':reactivatePage')->setName('membership-account-reactivate');
$app->post('/reactivate', AccountController::class.':reactivate');

// Javascript?
$app->get('/javascript', AccountController::class.':javascriptPage')->setName('membership-account-javascript');

$app->group('/account', function () {

    // Account home
    $this->get('[/]', AccountController::class.':index')->setName('membership-account');

    // Edit account
    $this->get('/edit', AccountController::class.':editPage')->setName('membership-account-edit');
    $this->put('/edit', AccountController::class.':edit')->setName('membership-account-update');

    // Update account password
    $this->get('/update-password', PasswordController::class.':updatePage')->setName('membership-account-password-edit');
    $this->put('/update-password', PasswordController::class.':update')->setName('membership-account-password-update');

    // Delete account?
    $this->delete('/{id:[0-9]+}', AccountController::class.':delete')->setName('membership-account-delete');

    // Account portfolios
    $this->group('/portfolio', function () {

        // View and Update Portfolio
        $this->get('/{id:[0-9]+}', PortfoliosController::class.':index')->setName('membership-portfolios-edit');
        $this->put('/{id:[0-9]+}', PortfoliosController::class.':edit')->setName('membership-portfolios-update');

        // Delete Portfolio
        $this->delete('/{id:[0-9]+}', PortfoliosController::class.':delete')->setName('membership-portfolios-delete');

        // Create new Portfolio
        $this->get('/add', PortfoliosController::class.':addPage')->setName('membership-portfolios-add');
        $this->post('/', PortfoliosController::class.':add')->setName('membership-portfolios-create');

    })->add(function (Request $request, Response $response, callable $next) {

        // Authorize portfolio middleware
        $args = $request->getAttribute('routeInfo')[2];

        if (!$args || ($request->isXhr() && $request->isGet())) {
            return $next($request, $response);
        }

        $data = $this->get('data');
        $count = $data(Models\MemberPortfolios::class)->count([
            'member_portfolio_id' => (int) $args['id'],
            'user_id' => $this->session->get('user_id'),
        ]);

        if ($count < 1) {
            $this->flash->addMessage('warning', 'Permission denied.');

            return $response->withRedirect($this->router->pathFor('membership-account'));
        }

        return $next($request, $response);

    });

    // Account Skills
    $this->group('/skills', function () {

        // View and Update skill
        $this->get('/{id:[0-9]+}', SkillsController::class.':index')->setName('membership-skills-edit');
        $this->put('/{id:[0-9]+}', SkillsController::class.':edit')->setName('membership-skills-update');

        // Delete skill
        $this->delete('/{id:[0-9]+}', SkillsController::class.':delete')->setName('membership-skills-delete');

        // Create new skill
        $this->get('/add', SkillsController::class.':addPage')->setName('membership-skills-add');
        $this->post('/', SkillsController::class.':add')->setName('membership-skills-create');

    })->add(function (Request $request, Response $response, callable $next) {

        // Authorize skills middleware
        $args = $request->getAttribute('routeInfo')[2];

        if (!$args || ($request->isXhr() && $request->isGet())) {
            return $next($request, $response);
        }

        $data = $this->get('data');
        $count = $data(Models\MemberSkills::class)->count([
            'member_skill_id' => (int) $args['id'],
            'user_id' => $this->session->get('user_id'),
        ]);

        if ($count < 1) {
            $this->flash->addMessage('warning', 'Permission denied.');

            return $response->withRedirect($this->router->pathFor('membership-account'));
        }

        return $next($request, $response);

    });

})->add(function (Request $request, Response $response, callable $next) {

    // Forward all XHR request
    if ($request->isXhr() && $request->isGet()) {
        return $next($request, $response);
    }

    // Authorize account middleware
    if (!$this->session->has('user_id')) {
        $this->flash->addMessage('error', 'You are not authenticated');

        return $response->withRedirect($this->router->pathFor('membership-login'));
    }

    return $next($request, $response);

});

// Regionals end-point
$app->group('/regionals', function () {

    $this->get('/provinces', RegionalsController::class.':provinces')->setName('regionals-provinces');
    $this->get('/cities/{province_id:[0-9]+}', RegionalsController::class.':cities')->setName('regionals-cities');

});

/**
 * TODO: normalize username,
 * - Username should accept alphanumeric, dash and underscore only [A-z\d\-\_]
 */
$app->get('/{username}', AccountController::class.':profile')->add(function (Request $request, Response $response, callable $next) {

    $routeInfo = $request->getAttribute('routeInfo');
    $args = $routeInfo[2];

    if (substr($args['username'], -5) == '.json') {
        $routeInfo[2]['username'] = substr($args['username'], 0, -5);

        $request = $request
            ->withAttribute('routeInfo', $routeInfo)
            ->withHeader('X-Requested-With', 'XMLHttpRequest');
    }

    return $next($request, $response);

})->setName('membership-profile');

