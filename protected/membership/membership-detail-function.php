<?php
$app->get('/apps/membership/detail/{name}', function ($request, $response, $args) {
    
    $db = $this->getContainer()->get('db');
    
    $q_member = $db->createQueryBuilder()
    ->select(
        'u.user_id',
        'u.username',
        'u.email',
        'u.created',
        'm.*',
        'reg_prv.regional_name AS province',
        'reg_cit.regional_name AS city'
    )
    ->from('users', 'u')
    ->leftJoin('u', 'members_profiles', 'm', 'u.user_id = m.user_id')
    ->leftJoin('m', 'regionals', 'reg_prv', 'reg_prv.id = m.province_id')
    ->leftJoin('m', 'regionals', 'reg_cit', 'reg_cit.id = m.city_id')
    ->where('u.username = :uname')
    ->setParameter(':rid', 'member')
    ->setParameter(':uname', $args['name'])
    ->execute();

    $member = $q_member->fetch();

    $q_member_socmeds = $db->createQueryBuilder()
    ->select('socmed_type', 'account_name', 'account_url')
    ->from('members_socmeds')
    ->where('user_id = :uid')
    ->andWhere('deleted = :d')
    ->setParameter(':uid', $member['user_id'])
    ->setParameter(':d', 'N')
    ->execute();

    $member_socmeds = $q_member_socmeds->fetchAll();
    $socmedias = $this->getContainer()->get('settings')['socmedias'];
    $socmedias_logo = $this->getContainer()->get('settings')['socmedias_logo'];

    $this->view->getPlates()->addData(
        array(
            'page_title' => 'Membership',
            'sub_page_title' => 'Detail Anggota'
        ),
        'layouts::layout-system'
    );

    return $this->view->render(
        $response,
        'membership/detail',
        compact('member', 'member_socmeds', 'socmedias', 'socmedias_logo')
    );

})->setName('membership-detail');
