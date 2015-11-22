<?php
$app->map(['GET', 'POST'], '/apps/membership/portfolio/edit/{id}', function ($request, $response, $args) {

	$db = $this->getContainer()->get('db');

	if ($request->isPost()) {
		$validator = $this->getContainer()->get('validator');
        $validator->createInput($_POST);
        $validator->rule('required', array(
            'company_name',
            'industry_id',
            'start_date_y',
            'work_status',
            'job_title',
            'job_desc'
        ));

        if ($_POST['work_status'] == 'R') {
            $validator->rule('required', 'end_date_y');
        }

        if ($validator->validate()) {

            if ($_POST['work_status'] == 'A') {
                $_POST['end_date_y'] = null;
                $_POST['end_date_m'] = null;
                $_POST['end_date_d'] = null;
            }

        	$db->update('members_portfolios', array(
                'company_name' => filter_var(trim($_POST['company_name']), FILTER_SANITIZE_STRING),
                'industry_id' => filter_var(trim($_POST['industry_id']), FILTER_SANITIZE_STRING),
                'start_date_y' => filter_var(trim($_POST['start_date_y']), FILTER_SANITIZE_STRING),
                'start_date_m' => $_POST['start_date_m'] == '' ? null : filter_var(trim($_POST['start_date_m']), FILTER_SANITIZE_STRING),
                'start_date_d' => $_POST['start_date_d'] == '' ? null : filter_var(trim($_POST['start_date_d']), FILTER_SANITIZE_STRING),
                'end_date_y' => filter_var(trim($_POST['end_date_y']), FILTER_SANITIZE_STRING),
                'end_date_m' => $_POST['end_date_m'] == '' ? null : filter_var(trim($_POST['end_date_m']), FILTER_SANITIZE_STRING),
                'end_date_d' => $_POST['end_date_d'] == '' ? null : filter_var(trim($_POST['end_date_d']), FILTER_SANITIZE_STRING),
                'work_status' => filter_var(trim($_POST['work_status']), FILTER_SANITIZE_STRING),
                'job_title' => filter_var(trim($_POST['job_title']), FILTER_SANITIZE_STRING),
                'job_desc' => filter_var(trim($_POST['job_desc']), FILTER_SANITIZE_STRING),
                'career_level_id' => filter_var(trim($_POST['career_level_id']), FILTER_SANITIZE_STRING),
                'modified' => date('Y-m-d H:i:s'),
                'modified_by' => $_SESSION['MembershipAuth']['user_id']
            ), array('member_portfolio_id' => $_POST['member_portfolio_id']));

            $this->flash->flashLater('success', 'Item portfolio berhasil diperbaharui. Selamat!');
            return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-profile'));

        } else {
        	$this->flash->flashNow('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
        }
	}

    $q_portfolio = $db->createQueryBuilder()
    ->select(
        'member_portfolio_id',
        'company_name',
        'industry_id',
        'start_date_y',
        'start_date_m',
        'start_date_d',
        'end_date_y',
        'end_date_m',
        'end_date_d',
        'work_status',
        'job_title',
        'job_desc',
        'career_level_id',
        'created'
    )
    ->from('members_portfolios')
    ->where('member_portfolio_id = :id')
    ->andWhere('deleted = :d')
    ->setParameter(':id', $args['id'])
    ->setParameter(':d', 'N')
    ->execute();

    $q_carerr_levels = $db->createQueryBuilder()
    ->select('career_level_id')
    ->from('career_levels')
    ->orderBy('order_by', 'ASC')
    ->execute();

    $q_industries = $db->createQueryBuilder()
    ->select('industry_id', 'industry_name')
    ->from('industries')
    ->execute();

	$portfolio = $q_portfolio->fetch();
    $industries = \Cake\Utility\Hash::combine($q_industries->fetchAll(), '{n}.industry_id', '{n}.industry_name');
    $career_levels = \Cake\Utility\Hash::combine($q_carerr_levels->fetchAll(), '{n}.career_level_id', '{n}.career_level_id');
    $years_range = $this->getContainer()->get('years_range');
	$months_range = $this->getContainer()->get('months_range');
	$days_range = $this->getContainer()->get('days_range');

	$this->view->getPlates()->addData(
        array(
            'page_title' => 'Membership',
            'sub_page_title' => 'Update portfolio item'
        ),
        'layouts::layout-system'
    );

    return $this->view->render(
        $response,
        'membership/portfolio-edit',
        compact('portfolio', 'industries', 'career_levels', 'years_range', 'months_range', 'days_range')
    );

})->add(function ($req, $res, $next) {

    $routeInfo = $req->getAttribute('routeInfo');
    $id = $routeInfo[2]['id'];

    $q_user = $this['db']->createQueryBuilder()
        ->select('count(*) num', 'user_id', 'member_portfolio_id')
        ->from('members_portfolios')
        ->where('member_portfolio_id = :portId')
        ->andWhere('user_id = :userId')
        ->setParameter(':portId', $routeInfo[2]['id'])
        ->setParameter(':userId', $_SESSION['MembershipAuth']['user_id'])
        ->execute();

    $user = $q_user->fetch();

    if ($user['num'] < 1) {

        $this['flash']->flashLater('warning', 'Permission denied.');
        return $res->withStatus(302)->withHeader('Location', $this['router']->pathFor('membership-profile'));

    }

    return $next($req, $res);

})->setName('membership-portfolio-edit');
