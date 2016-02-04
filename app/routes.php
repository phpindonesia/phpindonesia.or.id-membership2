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

        $request = $request->withParsedBody($inputs);
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
$app->get('/reset-password/{uid}/{reset_key}', PasswordController::class.':reset')->setName('membership-reset-password');

// Account activation end-point
$app->get('/activate/{uid}/{activation_key}', AccountController::class.':activate')->setName('membership-activation');

// Account reactivation end-point
// TODO: need tobe done
$app->get('/reactivate', AccountController::class.':reactivatePage')->setName('membership-account-reactivate');
$app->post('/reactivate', AccountController::class.':reactivate');

/**
 * TODO: normalize username,
 * - Username should accept alphanumeric, dash and underscore only
 */
$app->get('/profile/{username}', AccountController::class.':profile')->setName('membership-profile');

$app->group('/account', function () {

    // Account home
    $this->get('[/]', AccountController::class.':index')->setName('membership-account');

    // Edit account
    $this->get('/edit', AccountController::class.':editPage')->setName('membership-account-edit');
    $this->post('/edit', AccountController::class.':edit');

    // Update account password
    $this->get('/update-password', PasswordController::class.':updatePage')->setName('membership-update-password');
    $this->post('/update-password', PasswordController::class.':update');

    // Javascript?
    $this->get('/javascript', AccountController::class.':javascriptPage')->setName('membership-account-javascript');

    // Delete account?
    $this->delete('/{id:[0-9]+}', AccountController::class.':delete')->setName('membership-account-delete');

    // Account portfolios
    $this->group('/portfolio', function () {

        // Update & Delete Portfolio
        $this->get('/{id:[0-9]+}', PortfoliosController::class.':editPage')->setName('membership-portfolio-edit');
        $this->post('/{id:[0-9]+}', PortfoliosController::class.':edit');
        $this->delete('/{id:[0-9]+}', PortfoliosController::class.':delete');

        // Create new Portfolio
        $this->get('/add', PortfoliosController::class.':addPage')->setName('membership-portfolio-add');
        $this->post('/add', PortfoliosController::class.':add');

    })->add(function (Request $request, Response $response, callable $next) {

        // Authorize portfolio middleware
        $data = $this->get('data');
        $args = $request->getAttribute('routeInfo')[2];
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

        // Read all skills
        $this->get('[/]', SkillsController::class.':index')->setName('membership-skills');

        // Update & Delete skills
        $this->get('/{id:[0-9]+}', SkillsController::class.':editPage')->setName('membership-skills-edit');
        $this->post('/{id:[0-9]+}', SkillsController::class.':edit');
        $this->delete('/{id:[0-9]+}', SkillsController::class.':delete')->setName('membership-skills-delete');

        // Create new skills
        $this->get('/add', SkillsController::class.':addPage')->setName('membership-skills-add');
        $this->post('/add', SkillsController::class.':add');

    })->add(function (Request $request, Response $response, callable $next) {

        // Authorize skills middleware
        $data = $this->get('data');
        $args = $request->getAttribute('routeInfo')[2];
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

