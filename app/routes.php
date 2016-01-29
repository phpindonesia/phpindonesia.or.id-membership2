<?php
use Membership\Controllers\AccountController;
use Membership\Controllers\ActivationController;
use Membership\Controllers\HomeController;
use Membership\Controllers\PasswordController;
use Membership\Controllers\PortfoliosController;
use Membership\Controllers\ProfileController;
use Membership\Controllers\RegionalsController;
use Membership\Controllers\SkillsController;

$app->get('/', HomeController::class.':index')->setName('membership-index');

$app->get('/login', AccountController::class.':loginPage')->setName('membership-login');
$app->post('/login', AccountController::class.':login');

$app->get('/register', AccountController::class.':registerPage')->setName('membership-register');
$app->post('/register', AccountController::class.':register');

$app->get('/logout', AccountController::class.':logout')->setName('membership-logout');

$app->get('/account', ProfileController::class.':member')->setName('membership-account');
$app->group('/profile', function () {
    $this->get('/add', ProfileController::class.':addPage')->setName('membership-profile-add');
    $this->post('/add', ProfileController::class.':add');

    $this->get('/javascript', ProfileController::class.':javascriptPage')->setName('membership-profile-javascript');
    $this->get('/edit', ProfileController::class.':editPage')->setName('membership-profile-edit');

    $this->get('/{name:[a-zA-Z]+}', ProfileController::class.':index')->setName('membership-profile');

    $this->delete('/{id:[0-9]+}', ProfileController::class.':delete')->setName('membership-profile-delete');
});

$app->group('/activation', function () {
    $this->get('/activate/{uid}/{activation_key}', ActivationController::class.':activatePage')->setName('membership-activation-activate');
    $this->post('/activate', ActivationController::class.':activate');

    $this->get('/reactivate', ActivationController::class.':reactivate')->setName('membership-activation-reactivate');
});

$app->group('/password', function () {
    $this->get('/update', PasswordController::class.':updatePage')->setName('membership-password-update');
    $this->post('/update', PasswordController::class.':update');

    $this->get('/reset/{uid}/{reset_key}', PasswordController::class.':resetPage')->setName('membership-password-reset');

    $this->get('/forgot', PasswordController::class.':forgotPage')->setName('membership-password-forgot');
    $this->post('/forgot', PasswordController::class.':forgot');
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

$app->group('/common-data', function () {
    $this->get('/cities/{province_id:[0-9]+}', CommonDataController::class.':cities')->setName('dataa-cities');
    $this->get('/skills/{skills_id:[0-9]+}',   Controllers\CommonData::class.':skills')->setName('dataa-skills');
});

