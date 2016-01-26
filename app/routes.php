<?php
use Membership\Controllers;

$app->get('/', Controllers\Home::class.':index')->setName('membership-index');

$app->get('/login', Controllers\Account::class.':loginPage')->setName('membership-login');
$app->post('/login', Controllers\Account::class.':login');

$app->get('/register', Controllers\Account::class.':registerPage')->setName('membership-register');
$app->post('/register', Controllers\Account::class.':register');

$app->get('/logout', Controllers\Account::class.':logout')->setName('membership-logout');

$app->get('/account', Controllers\Profile::class.':member')->setName('membership-account');
$app->group('/profile', function () {
    $this->get('/add', Controllers\Profile::class.':addPage')->setName('membership-profile-add');
    $this->post('/add', Controllers\Profile::class.':add');

    $this->get('/javascript', Controllers\Profile::class.':javascriptPage')->setName('membership-profile-javascript');
    $this->get('/edit', Controllers\Profile::class.':editPage')->setName('membership-profile-edit');

    $this->get('/{name:[a-zA-Z]+}', Controllers\Profile::class.':index')->setName('membership-profile');

    $this->delete('/{id:[0-9]+}', Controllers\Profile::class.':delete')->setName('membership-profile-delete');
});

$app->group('/activation', function () {
    $this->get('/activate/{uid}/{activation_key}', Controllers\Activation::class.':activatePage')->setName('membership-activation-activate');
    $this->post('/activate', Controllers\Activation::class.':activate');

    $this->get('/reactivate', Controllers\Activation::class.':reactivate')->setName('membership-activation-reactivate');
});

$app->group('/password', function () {
    $this->get('/update', Controllers\Password::class.':updatePage')->setName('membership-password-update');
    $this->post('/update', Controllers\Password::class.':update');

    $this->get('/reset/{uid}/{reset_key}', Controllers\Password::class.':resetPage')->setName('membership-password-reset');

    $this->get('/forgot', Controllers\Password::class.':forgotPage')->setName('membership-password-forgot');
    $this->post('/forgot', Controllers\Password::class.':forgot');
});

$app->group('/portfolio', function () {
    $this->get('/add', Controllers\Portfolios::class.':addPage')->setName('membership-portfolio-add');
    $this->post('/add', Controllers\Portfolios::class.':add');

    $this->get('/edit', Controllers\Portfolios::class.':editPage')->setName('membership-portfolio-edit');
    $this->post('/edit', Controllers\Portfolios::class.':edit');
});

$app->group('/skills', function () {
    $this->get('', Controllers\Skills::class.':index')->setName('membership-skills');

    $this->delete('/{id:[0-9]+}', Controllers\Skills::class.':delete')->setName('membership-skills-delete');

    $this->get('/add', Controllers\Skills::class.':addPage')->setName('membership-skills-add');
    $this->post('/add', Controllers\Skills::class.':add');
});

$app->group('/common-data', function () {
    $this->get('/cities/{province_id:[0-9]+}', Controllers\CommonData::class.':cities')->setName('dataa-cities');
    $this->get('/skills/{skills_id:[0-9]+}',   Controllers\CommonData::class.':skills')->setName('dataa-skills');
});

