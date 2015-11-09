<?php
$app->map(['GET', 'POST'], '/apps/membership/account-reactivation[/]', function ($request, $response, $args) {

	$gcaptcha_site_key = $this->getContainer()->get('settings')['gcaptcha']['site_key'];
    $gcaptcha_secret = $this->getContainer()->get('settings')['gcaptcha']['secret'];
    $use_captcha = $this->getContainer()->get('settings')['use_captcha'];

    if ($request->isPost()) {

		$db = $this->getContainer()->get('db');
        $validator = $this->getContainer()->get('validator');
        $validator->createInput($_POST);

        $validator->addNewRule('check_email_exist', function ($field, $value, array $params) use ($db) {
			$q_email_exist = $db->createQueryBuilder()
			->select('COUNT(*) AS total_data')
			->from('users')
			->where('email = :email')
            ->andWhere('deleted = :d')
			->setParameter(':email', trim($_POST['email']))
            ->setParameter(':d', 'N')
			->execute();

			$email_exist = (int) $q_email_exist->fetch()['total_data'];
			if ($email_exist > 0) {
				return true;
			}

			return false;

		}, 'Tidak terdaftar!');

		$validator->rule('required', 'email');
		$validator->rule('check_email_exist', 'email');

        if ($validator->validate()) {
        	//
        }
	}

	$this->view->getPlates()->addData(
        array(
            'page_title' => 'Membership',
            'sub_page_title' => 'Account Reactivation',
            'layout_use_captcha' => $use_captcha
        ),
        'layouts::layout-system'
    );

    return $this->view->render(
        $response,
        'membership/account-reactivation',
        compact('gcaptcha_site_key', 'use_captcha')
    );

})->setName('membership-account-reactivation');
