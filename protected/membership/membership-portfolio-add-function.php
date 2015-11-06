<?php
$app->map(['GET', 'POST'], '/apps/membership/portfolio/add', function ($request, $response, $args) {

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
            'job_desc',
            'career_level_id'
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

        	$db->insert('members_portfolios', array(
                'user_id' => $_SESSION['MembershipAuth']['user_id'],
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
                'created' => date('Y-m-d H:i:s'),
                'created_by' => $_SESSION['MembershipAuth']['user_id'],
                'deleted' => 'N'
            ));

            $this->flash->flashLater('success', 'Item portfolio baru berhasil ditambahkan. Selamat! . Silahkan tambahkan lagi item portfolio anda.');
            return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-profile'));

        } else {
        	$this->flash->flashNow('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
        }
	}

	$q_carerr_levels = $db->createQueryBuilder()
    ->select('career_level_id')
    ->from('career_levels')
    ->orderBy('order_by', 'ASC')
    ->execute();

    $q_industries = $db->createQueryBuilder()
    ->select('industry_id', 'industry_name')
    ->from('industries')
    ->execute();

    $career_levels = \Cake\Utility\Hash::combine($q_carerr_levels->fetchAll(), '{n}.career_level_id', '{n}.career_level_id');
    $industries = \Cake\Utility\Hash::combine($q_industries->fetchAll(), '{n}.industry_id', '{n}.industry_name');
    $years_range = $this->getContainer()->get('years_range');
	$months_range = $this->getContainer()->get('months_range');
	$days_range = $this->getContainer()->get('days_range');

	$this->view->getPlates()->addData(
        array(
            'page_title' => 'Membership',
            'sub_page_title' => 'Update Portfolio'
        ),
        'layouts::layout-system'
    );

    return $this->view->render(
        $response,
        'membership/portfolio-add',
        compact('career_levels', 'industries', 'years_range', 'months_range', 'days_range')
    );

})->setName('membership-portfolio-add');
