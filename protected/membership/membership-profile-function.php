<?php
$app->get('/apps/membership/profile[/]', function ($request, $response, $args) {

    $db = $this->getContainer()->get('db');

    $q_member = $db->createQueryBuilder()
    ->select(
        'm.*',
        'reg_prv.regional_name AS province',
        'reg_cit.regional_name AS city'
    )
    ->from('members_profiles', 'm')
    ->leftJoin('m', 'regionals', 'reg_prv', 'reg_prv.id = m.province_id')
    ->leftJoin('m', 'regionals', 'reg_cit', 'reg_cit.id = m.city_id')
    ->where('m.user_id = :uid')
    ->andWhere('m.deleted = :d')
    ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
    ->setParameter(':d', 'N')
    ->execute();

    $q_member_socmeds = $db->createQueryBuilder()
    ->select('socmed_type', 'account_name', 'account_url')
    ->from('members_socmeds')
    ->where('user_id = :uid')
    ->andWhere('deleted = :d')
    ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
    ->setParameter(':d', 'N')
    ->execute();

    $q_member_portfolios = $db->createQueryBuilder()
    ->select(
        'mp.member_portfolio_id',
        'mp.company_name',
        'ids.industry_name',
        'mp.start_date_y',
        'mp.start_date_m',
        'mp.start_date_d',
        'mp.end_date_y',
        'mp.end_date_m',
        'mp.end_date_d',
        'mp.work_status',
        'mp.job_title',
        'mp.job_desc',
        'mp.created'
    )
    ->from('members_portfolios', 'mp')
    ->leftJoin('mp', 'industries', 'ids', 'mp.industry_id = ids.industry_id')
    ->where('mp.user_id = :uid')
    ->andWhere('mp.deleted = :d')
    ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
    ->setParameter(':d', 'N')
    ->execute();

    $member = $q_member->fetch();
    $member_portfolios = $q_member_portfolios->fetchAll();
    $member_socmeds = $q_member_socmeds->fetchAll();
    $socmedias = $this->getContainer()->get('settings')['socmedias'];
    $socmedias_logo = $this->getContainer()->get('settings')['socmedias_logo'];
    $months = $this->getContainer()->get('months');

    $db->close();

    $this->view->getPlates()->addData(
        array(
            'page_title' => 'Membership',
            'sub_page_title' => 'Profil Anggota'
        ),
        'layouts::layout-system'
    );

    return $this->view->render(
        $response,
        'membership/profile',
        compact(
            'member',
            'member_portfolios',
            'member_socmeds',
            'socmedias',
            'socmedias_logo',
            'months'
        )
    );

})->setName('membership-profile');
