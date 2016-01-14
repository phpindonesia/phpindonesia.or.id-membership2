<?php
$app->map(['GET', 'POST'], '/apps/membership/update-password', function ($request, $response, $args) {

    if ($request->isPost()) {
        $db = $this->get('db');
        $validator = $this->get('validator');
        $salt_pwd = $this->get('settings')['salt_pwd'];

        $validator->createInput($_POST);
        $validator->rule('required', array(
            'oldpassword',
            'password',
            'repassword'
        ));

        $validator->addNewRule('check_oldpassword', function ($field, $value, array $params) use ($db, $salt_pwd) {
            $salted_current_pwd = md5($salt_pwd.$value);

            $q_current_pwd_count = $db->createQueryBuilder()
            ->select('COUNT(*) AS total_data')
            ->from('users')
            ->where('user_id = :uid')
            ->andWhere('password = :pwd')
            ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
            ->setParameter(':pwd', $salted_current_pwd)
            ->execute();

            $current_pwd_count = (int) $q_current_pwd_count->fetch()['total_data'];
            if ($current_pwd_count > 0) {
                return true;
            }

            return false;

        }, 'Wrong! Please remember your old password');

        $validator->addNewRule('check_repassword', function ($field, $value, array $params) {
            if ($value != $_POST['password']) {
                return false;
            }

            return true;

        }, 'Not match with choosen new password');

        $validator->rule('check_oldpassword', 'oldpassword');
        $validator->rule('check_repassword', 'repassword');

        if ($validator->validate()) {
            $salted_new_pwd = md5($salt_pwd.$_POST['password']);

            $db->update('users', array(
                'password' => $salted_new_pwd,
                'modified' => date('Y-m-d H:i:s'),
                'modified_by' => $_SESSION['MembershipAuth']['user_id']
            ), array('user_id' => $_SESSION['MembershipAuth']['user_id']));

            $this->flash->addMessage('success', 'Password anda berhasil diubah! Selamat!');
            return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-profile'));

        } else {
            $this->flash->addMessage('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
        }
    }

    $this->view->getPlates()->addData(
        array(
            'page_title' => 'Membership',
            'sub_page_title' => 'Update Password'
        ),
        'layouts::layout-system'
    );

    return $this->view->render(
        $response,
        'membership/update-password'
    );

})->setName('membership-update-password');
