<?php
$app->get('/apps/membership', function ($request, $response, $args) {

    $db = $this->getContainer()->get('db');

    $q_members = $db->createQueryBuilder()
    ->select(
        'u.user_id',
        'u.username',
        'u.email',
        'u.created',
        'ur.role_id',
        'm.fullname',
        'm.gender',
        'm.photo',
        'reg_prv.regional_name AS province',
        'reg_cit.regional_name AS city'
    )
    ->from('users', 'u')
    ->leftJoin('u', 'members_profiles', 'm', 'u.user_id = m.user_id')
    ->leftJoin('u', 'users_roles', 'ur', 'u.user_id = ur.user_id')
    ->leftJoin('m', 'regionals', 'reg_prv', 'reg_prv.id = m.province_id')
    ->leftJoin('m', 'regionals', 'reg_cit', 'reg_cit.id = m.city_id')
    ->where('ur.role_id = :rid')
    ->andWhere('u.activated = :act')
    ->orderBy('u.created', 'DESC')
    ->setParameter(':rid', 'member')
    ->setParameter(':act', 'Y');

    if ((isset($_GET['province_id'])) && (!empty($_GET['province_id']))) {
        $q_members->andWhere('m.province_id = :pvid');
        $q_members->setParameter(':pvid', $_GET['province_id']);
    }

    if ((isset($_GET['city_id'])) && (!empty($_GET['city_id']))) {
        $q_members->andWhere('m.city_id = :ctid');
        $q_members->setParameter(':ctid', $_GET['city_id']);
    }

    if ((isset($_GET['area'])) && (!empty($_GET['area']))) {
        $q_members->andWhere('m.area LIKE :area');
        $q_members->setParameter(':area', "%".$_GET['area']."%");
    }

    // Paging handling
    $countQueryBuilderModifier = function ($q_members) {
        $q_members->select('COUNT(DISTINCT u.user_id) AS total_results')
        ->setMaxResults(1);
    };

    $pagerAdapter = new \Pagerfanta\Adapter\DoctrineDbalAdapter($q_members, $countQueryBuilderModifier);
    
    $pagerfanta = new \Pagerfanta\Pagerfanta($pagerAdapter);
    $pagerfanta->setMaxPerPage(20);
    $pagerfanta->setCurrentPage(isset($_GET['page']) ? $_GET['page'] : 1);

    $viewPager = new \Pagerfanta\View\TwitterBootstrapView();

    $routerGen = function ($page) use ($request) {
        $uri_page = 'membership?page='.$page;
        $count_get_req = count($_GET);

        if ($count_get_req > 0) {
            $_GET['page'] = $page;
            $uri_page = 'membership?'.http_build_query($_GET);
        }

        return $uri_page;
    };

    $html_view_pager = $viewPager->render($pagerfanta, $routerGen, array(
        'proximity' => 3,
        'prev_message' => 'Prev',
        'next_message' => 'Next'
    ));

    $members = $pagerfanta->getCurrentPageResults();
    // --- End of paging handling

    $q_provinces = $db->createQueryBuilder()
    ->select('id', 'regional_name')
    ->from('regionals')
    ->where('parent_id IS NULL')
    ->andWhere('city_code = :ccode')
    ->orderBy('province_code, city_code')
    ->setParameter(':ccode', '00', \Doctrine\DBAL\Types\Type::STRING)
    ->execute();

    $provinces = \Cake\Utility\Hash::combine($q_provinces->fetchAll(), '{n}.id', '{n}.regional_name');
    $cities = array();

    if ((isset($_GET['province_id'])) && (!empty($_GET['province_id']))) {
        $q_cities = $db->createQueryBuilder()
        ->select('id', 'regional_name')
        ->from('regionals')
        ->where('parent_id = :pvid')
        ->orderBy('province_code, city_code')
        ->setParameter(':pvid', $_GET['province_id'])
        ->execute();

        $cities = \Cake\Utility\Hash::combine($q_cities->fetchAll(), '{n}.id', '{n}.regional_name');
    }

    $this->view->getPlates()->addData(
        array(
            'page_title' => 'Membership',
            'sub_page_title' => 'Keanggotaan'
        ),
        'layouts::layout-system'
    );

    return $this->view->render(
        $response,
        'membership/index',
        compact('members','provinces', 'cities', 'html_view_pager')
    );

})->setName('membership-index');
