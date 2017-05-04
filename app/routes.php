<?php

use Membership\Http\Middleware;
use Membership\Http\Controllers;

/**
 * Input string sanitizer middleware
 */
$app->add(Middleware::class.':sanitizeRequestBody');

/**
 * Route definitions
 *
 * - All GET Routes should be named
 * - Every request method (GET, POST, UPDATE, DELETE) with same path should resolve by different class method
 */
$app->get('/', Controllers\HomeController::class.':index')->setName('membership-index');

// Login end-point
$app->get('/login', Controllers\HomeController::class.':loginPage')->setName('membership-login');
$app->post('/login', Controllers\HomeController::class.':login');

// Registration end-point
$app->get('/register', Controllers\HomeController::class.':registerPage')->setName('membership-register');
$app->post('/register', Controllers\HomeController::class.':register');

// Logout end-point
$app->get('/logout', Controllers\HomeController::class.':logout')->setName('membership-logout');

// Forgot password end-point
$app->get('/forgot-password', Controllers\PasswordController::class.':forgotPage')->setName('membership-forgot-password');
$app->post('/forgot-password', Controllers\PasswordController::class.':forgot');

// Reset password end-point
$app->get('/reset-password/{user_id:[0-9]+}/{reset_key}', Controllers\PasswordController::class.':reset')->setName('membership-reset-password');

// Account activation end-point
$app->get('/activate/{user_id:[0-9]+}/{activation_key}', Controllers\AccountController::class.':activate')->setName('membership-activation');

// Account reactivation end-point
// TODO: need tobe done
$app->get('/reactivate', Controllers\AccountController::class.':reactivatePage')->setName('membership-account-reactivate');
$app->post('/reactivate', Controllers\AccountController::class.':reactivate');

// Javascript?
$app->get('/javascript', Controllers\AccountController::class.':javascriptPage')->setName('membership-account-javascript');

$app->group('/account', function () {

    // Account home
    $this->get('[/]', Controllers\AccountController::class.':index')->setName('membership-account');

    // Edit account
    $this->get('/edit', Controllers\AccountController::class.':editPage')->setName('membership-account-edit');
    $this->put('/edit', Controllers\AccountController::class.':edit')->setName('membership-account-update');

    // Update account password
    $this->get('/update-password', Controllers\PasswordController::class.':updatePage')->setName('membership-account-password-edit');
    $this->put('/update-password', Controllers\PasswordController::class.':update')->setName('membership-account-password-update');

    // Delete account?
    $this->delete('/{id:[0-9]+}', Controllers\AccountController::class.':delete')->setName('membership-account-delete');

    // Account portfolios
    $this->group('/portfolio', function () {

        // View and Update Portfolio
        $this->get('/{id:[0-9]+}', Controllers\PortfoliosController::class.':index')->setName('membership-portfolios-edit');
        $this->put('/{id:[0-9]+}', Controllers\PortfoliosController::class.':edit')->setName('membership-portfolios-update');

        // Delete Portfolio
        $this->delete('/{id:[0-9]+}', Controllers\PortfoliosController::class.':delete')->setName('membership-portfolios-delete');

        // Create new Portfolio
        $this->get('/add', Controllers\PortfoliosController::class.':addPage')->setName('membership-portfolios-add');
        $this->post('/', Controllers\PortfoliosController::class.':add')->setName('membership-portfolios-create');

    })->add(Middleware::class.':authorizePorfolioRoute');

    // Account Skills
    $this->group('/skills', function () {

        // View and Update skill
        $this->get('/{id:[0-9]+}', Controllers\SkillsController::class.':index')->setName('membership-skills-edit');
        $this->put('/{id:[0-9]+}', Controllers\SkillsController::class.':edit')->setName('membership-skills-update');

        // Delete skill
        $this->delete('/{id:[0-9]+}', Controllers\SkillsController::class.':delete')->setName('membership-skills-delete');

        // Create new skill
        $this->get('/add', Controllers\SkillsController::class.':addPage')->setName('membership-skills-add');
        $this->post('/', Controllers\SkillsController::class.':add')->setName('membership-skills-create');

    })->add(Middleware::class.':authorizeSkillRoute');

})->add(Middleware::class.':authenticateRoute');

// Regionals end-point
$app->group('/regionals', function () {

    $this->get('/provinces', Controllers\RegionalsController::class.':provinces')->setName('regionals-provinces');
    $this->get('/cities/{province_id:[0-9]+}', Controllers\RegionalsController::class.':cities')->setName('regionals-cities');

});

/**
 * TODO: normalize username,
 * - Username should accept alphanumeric, dash and underscore only [A-z\d\-\_]
 */
$app->get('/{username}', Controllers\AccountController::class.':profile')->setName('membership-profile');

