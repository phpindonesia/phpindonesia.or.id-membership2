<?php
$app->get('/apps/membership/profile', function ($request, $response, $args) {
      
    $q_member = $this->db->createQueryBuilder()
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

    $q_member_socmeds = $this->db->createQueryBuilder()
    ->select('socmed_type', 'account_name', 'account_url')
    ->from('members_socmeds')
    ->where('user_id = :uid')
    ->andWhere('deleted = :d')
    ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
    ->setParameter(':d', 'N')
    ->execute();

    $q_member_portfolios = $this->db->createQueryBuilder()
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

    /*
     * Data view for portfolio-add-section
     * //
    */
    $q_carerr_levels = $this->db->createQueryBuilder()
    ->select('career_level_id')
    ->from('career_levels')
    ->orderBy('order_by', 'ASC')
    ->execute();

    $q_industries = $this->db->createQueryBuilder()
    ->select('industry_id', 'industry_name')
    ->from('industries')
    ->execute();

    $career_levels = \Cake\Utility\Hash::combine($q_carerr_levels->fetchAll(), '{n}.career_level_id', '{n}.career_level_id');
    $industries = \Cake\Utility\Hash::combine($q_industries->fetchAll(), '{n}.industry_id', '{n}.industry_name');
    $years_range = $this->getContainer()->get('years_range');
    $months_range = $this->getContainer()->get('months_range');
    $days_range = $this->getContainer()->get('days_range');
    // --- End data view for portfolio-add-section

    $this->db->close();

    $this->view->getPlates()->addData(
        array(
            'page_title' => 'Membership',
            'sub_page_title' => 'Profil Anggota'
        ),
        'layouts::layout-system'
    );

    /*
     * Assign data view for portfolio-add-section
     * //
    */
    $this->view->getPlates()->addData(
        compact(
            'career_levels',
            'industries',
            'years_range',
            'months_range',
            'days_range'
        ),
        'membership/sections/portfolio-add-section'
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

$app->get('/apps/membership/profile-javascript', function ($request, $response, $args) {

    $q_check_portf = $this->db->createQueryBuilder()
    ->select('COUNT(*) AS total_data')
    ->from('members_portfolios')
    ->where('user_id = :uid')
    ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
    ->execute();

    $have_portf = false;
    if ($q_check_portf->fetch()['total_data'] > 0) {
        $have_portf = true;
    }

    $this->db->close();

    $response_n = $response->withStatus(200)
    ->withHeader('Content-Type', 'application/javascript');
    
    return $this->view->render(
        $response_n,
        'membership/profile-javascript',
        array('have_portf' => $have_portf)
    );

})->setName('membership-profile-javascript');
