<?php
$app->map(['GET', 'POST'], '/apps/membership/login', function ($request, $response, $args) {

    if ($request->isPost()) {

        $db = $this->get('db');
        $salt_pwd = md5($this->get('settings')['salt_pwd'].$_POST['password']);

        $q_user_count = $db->createQueryBuilder();
        $q_user_count
        ->select('COUNT(*) AS total_data')
        ->from('users', 'u')
        ->leftJoin('u', 'users_roles', 'ur', 'u.user_id = ur.user_id')
        ->where(
            $q_user_count->expr()->orX(
                $q_user_count->expr()->eq('u.username', ':username'),
                $q_user_count->expr()->eq('u.email', ':email')
            )
        )
        ->andWhere('u.password = :password')
        ->andWhere('u.deleted = :d')
        ->andWhere('u.activated = :act')
        ->andWhere('ur.role_id = :rid')
        ->setParameter(':username', trim($_POST['username']), \Doctrine\DBAL\Types\Type::STRING)
        ->setParameter(':email', trim($_POST['username']), \Doctrine\DBAL\Types\Type::STRING)
        ->setParameter(':password', $salt_pwd, \Doctrine\DBAL\Types\Type::STRING)
        ->setParameter(':d', 'N')
        ->setParameter(':act', 'Y')
        ->setParameter(':rid', 'member');

        $sth = $q_user_count->execute();
        $user_count = (int) $sth->fetch()['total_data'];
        $db->close();

        if ($user_count > 0) {
            if (!isset($_SESSION['MembershipAuth'])) {

                $q_user = $db->createQueryBuilder();
                $q_user
                ->select(
                    'u.user_id',
                    'u.username',
                    'u.email',
                    'u.province_id',
                    'u.city_id',
                    'ur.role_id',
                    'up.fullname',
                    'up.photo',
                    'up.job_id'
                )
                ->from('users', 'u')
                ->leftJoin('u', 'users_roles', 'ur', 'u.user_id = ur.user_id')
                ->leftJoin('u', 'members_profiles', 'up', 'u.user_id = up.user_id')
                ->where(
                    $q_user_count->expr()->orX(
                        $q_user_count->expr()->eq('u.username', ':username'),
                        $q_user_count->expr()->eq('u.email', ':email')
                    )
                )
                ->andWhere('u.password = :password')
                ->andWhere('ur.role_id = :rid')
                ->setParameter(':username', trim($_POST['username']))
                ->setParameter(':email', trim($_POST['username']))
                ->setParameter(':password', $salt_pwd)
                ->setParameter(':rid', 'member');

                $sth = $q_user->execute();
                $user = $sth->fetch();
                $db->close();

                $_SESSION['MembershipAuth'] = array();
                $_SESSION['MembershipAuth']['user_id'] = $user['user_id'];
                $_SESSION['MembershipAuth']['username'] = $user['username'];
                $_SESSION['MembershipAuth']['role_id'] = $user['role_id'];
                $_SESSION['MembershipAuth']['email'] = $user['email'];
                $_SESSION['MembershipAuth']['province_id'] = $user['province_id'];
                $_SESSION['MembershipAuth']['city_id'] = $user['city_id'];
                $_SESSION['MembershipAuth']['photo'] = $user['photo'];
                $_SESSION['MembershipAuth']['fullname'] = $user['fullname'];
                $_SESSION['MembershipAuth']['job_id'] = $user['job_id'];

                $db->update('users', array('last_login' => date('Y-m-d H:i:s')), array(
                    'user_id' => $user['user_id']
                ));

                $db->close();

                $this->flash->addMessage('success', 'Welcome brother!');
                return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-profile'));
            }

        } else {
            $this->flash->addMessage('error', 'Wrong credentials');
            return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-login'));
        }
    }

    $this->view->getPlates()->addData(
        array(
            'page_title' => 'Membership',
            'sub_page_title' => 'Login Anggota'
        ),
        'layouts::layout-system'
    );

    return $this->view->render(
        $response,
        'membership/login'
    );

})->setName('membership-login');
