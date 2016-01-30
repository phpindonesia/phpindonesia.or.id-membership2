<?php
use Membership\Controllers\AccountController;
use Membership\Controllers\HomeController;
use Membership\Controllers\PortfoliosController;
use Membership\Controllers\ProfileController;
use Membership\Controllers\SkillsController;
use Membership\Controllers\RegionalsController;

$app->get('/', HomeController::class.':index')->setName('membership-index');

$app->get('/login', HomeController::class.':loginPage')->setName('membership-login');
$app->post('/login', HomeController::class.':login');

$app->get('/register', HomeController::class.':registerPage')->setName('membership-register');
$app->post('/register', HomeController::class.':register');

$app->get('/logout', HomeController::class.':logout')->setName('membership-logout');

$app->get('/profile/{username:[a-zA-Z]+}', ProfileController::class.':index')->setName('membership-profile');

$app->get('/forgot-password', ProfileController::class.':forgotPasswordPage')->setName('membership-forgot-password');
$app->post('/forgot-password', ProfileController::class.':forgotPassword');

$app->get('/reset-password/{uid}/{reset_key}', ProfileController::class.':resetPasswordPage')->setName('membership-reset-password');

$app->group('/account', function () {
    $this->get('/', AccountController::class.':index')->setName('membership-account');

    $this->get('/edit', AccountController::class.':editPage')->setName('membership-account-edit');
    $this->post('/edit', AccountController::class.':edit');

    $this->get('/activate/{uid}/{activation_key}', AccountController::class.':activatePage')->setName('membership-account-activate');
    $this->post('/activate', AccountController::class.':activate');

    $this->get('/reactivate', AccountController::class.':reactivate')->setName('membership-account-reactivate');

    $this->get('/update-password', AccountController::class.':updatePasswordPage')->setName('membership-update-password');
    $this->post('/update-password', AccountController::class.':updatePassword');

    $this->get('/javascript', AccountController::class.':javascriptPage')->setName('membership-account-javascript');

    $this->delete('/{id:[0-9]+}', AccountController::class.':delete')->setName('membership-account-delete');
});

$app->group('/portfolio', function () {
    $this->get('/add', PortfoliosController::class.':addPage')->setName('membership-portfolio-add');
    $this->post('/add', PortfoliosController::class.':add');

    $this->get('/edit', PortfoliosController::class.':editPage')->setName('membership-portfolio-edit');
    $this->post('/edit', PortfoliosController::class.':edit');
});

$app->group('/skills', function () {
    $this->get('', SkillsController::class.':index')->setName('membership-skills');

    $this->delete('/{id:[0-9]+}', SkillsController::class.':delete')->setName('membership-skills-delete');

    $this->get('/add', SkillsController::class.':addPage')->setName('membership-skills-add');
    $this->post('/add', SkillsController::class.':add');
});

$app->group('/regionals', function () {
    $this->get('/provinces', RegionalsController::class.':provinces')->setName('regionals-provinces');
    $this->get('/cities/{province_id:[0-9]+}', RegionalsController::class.':cities')->setName('regionals-cities');
});

