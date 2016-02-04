<?php
use Membership\Controllers\HomeController;
use Membership\Controllers\AccountController;
use Membership\Controllers\PasswordController;
use Membership\Controllers\PortfoliosController;
use Membership\Controllers\ProfileController;
use Membership\Controllers\SkillsController;
use Membership\Controllers\RegionalsController;

/**
 * Route definitions
 *
 * - All GET Routes should be named
 * - Every request method (GET, POST, UPDATE, DELETE) with same path should resolve by different class method
 */

$app->get('/', HomeController::class.':index')->setName('membership-index');

$app->get('/login', HomeController::class.':loginPage')->setName('membership-login');
$app->post('/login', HomeController::class.':login');

$app->get('/register', HomeController::class.':registerPage')->setName('membership-register');
$app->post('/register', HomeController::class.':register');

$app->get('/logout', HomeController::class.':logout')->setName('membership-logout');

$app->get('/forgot-password', PasswordController::class.':forgotPage')->setName('membership-forgot-password');
$app->post('/forgot-password', PasswordController::class.':forgot');

$app->get('/reset-password/{uid}/{reset_key}', PasswordController::class.':reset')->setName('membership-reset-password');

$app->get('/activate/{uid}/{activation_key}', AccountController::class.':activate')->setName('membership-activation');

$app->get('/reactivate', AccountController::class.':reactivatePage')->setName('membership-account-reactivate');
$app->post('/reactivate', AccountController::class.':reactivate');

/**
 * TODO: normalize username,
 * - Username should accept alphanumeric, dash and underscore only
 */
$app->get('/profile/{username}', AccountController::class.':profile')->setName('membership-profile');

$app->group('/account', function () {

    $this->get('[/]', AccountController::class.':index')->setName('membership-account');

    $this->get('/edit', AccountController::class.':editPage')->setName('membership-account-edit');
    $this->post('/edit', AccountController::class.':edit');

    $this->get('/update-password', PasswordController::class.':updatePage')->setName('membership-update-password');
    $this->post('/update-password', PasswordController::class.':update');

    $this->get('/javascript', AccountController::class.':javascriptPage')->setName('membership-account-javascript');

    $this->delete('/{id:[0-9]+}', AccountController::class.':delete')->setName('membership-account-delete');

    $this->group('/portfolio', function () {
        $this->get('/{id:[0-9]+}', PortfoliosController::class.':editPage')->setName('membership-portfolio-edit');
        $this->post('/{id:[0-9]+}', PortfoliosController::class.':edit');
        $this->delete('/{id:[0-9]+}', PortfoliosController::class.':delete');

        $this->get('/add', PortfoliosController::class.':addPage')->setName('membership-portfolio-add');
        $this->post('/add', PortfoliosController::class.':add');
    });

    $this->group('/skills', function () {
        $this->get('[/]', SkillsController::class.':index')->setName('membership-skills');

        $this->get('/{id:[0-9]+}', SkillsController::class.':editPage')->setName('membership-skills-edit');
        $this->post('/{id:[0-9]+}', SkillsController::class.':edit');
        $this->delete('/{id:[0-9]+}', SkillsController::class.':delete')->setName('membership-skills-delete');

        $this->get('/add', SkillsController::class.':addPage')->setName('membership-skills-add');
        $this->post('/add', SkillsController::class.':add');
    });

});

$app->group('/regionals', function () {

    $this->get('/provinces', RegionalsController::class.':provinces')->setName('regionals-provinces');
    $this->get('/cities/{province_id:[0-9]+}', RegionalsController::class.':cities')->setName('regionals-cities');

});

