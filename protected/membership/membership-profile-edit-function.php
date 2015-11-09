<?php
$app->map(['GET', 'POST'], '/apps/membership/profile/edit[/]', function ($request, $response, $args) {

    $db = $this->getContainer()->get('db');

    if ($request->isPost()) {
        $validator = $this->getContainer()->get('validator');
        $validator->createInput($_POST);
        $validator->rule('required', array(
            'fullname',
            'email',
            'province_id',
            'city_id',
            'area',
            'job_id'
        ));

        $validator->rule('email', 'email');

        if ($validator->validate()) {
            $area = trim($_POST['area']);
            $area = empty($area) ? null : $area;
            $identity_number = trim($_POST['identity_number']);
            $identity_number = empty($identity_number) ? null : filter_var(trim($identity_number), FILTER_SANITIZE_STRING);
            $identity_type = $_POST['identity_type'] == '' ? null : filter_var(trim($_POST['identity_type']), FILTER_SANITIZE_STRING);
            $religion_id = $_POST['religion_id'] == '' ? null : filter_var(trim($_POST['religion_id']), FILTER_SANITIZE_STRING);

            $db->beginTransaction();
            try {

                $members_profiles = array(
                    'fullname' => filter_var(trim($_POST['fullname']), FILTER_SANITIZE_STRING),
                    'contact_phone' => filter_var(trim($_POST['contact_phone']), FILTER_SANITIZE_STRING),
                    'birth_place' => filter_var(trim(strtoupper($_POST['birth_place'])), FILTER_SANITIZE_STRING),
                    'birth_date' => $_POST['birth_date'] == '' ? null : filter_var(trim($_POST['birth_date']), FILTER_SANITIZE_STRING),
                    'identity_number' => $identity_number,
                    'identity_type' => $identity_type,
                    'religion_id' => $religion_id,
                    'province_id' => filter_var(trim($_POST['province_id']), FILTER_SANITIZE_STRING),
                    'city_id' => filter_var(trim($_POST['city_id']), FILTER_SANITIZE_STRING),
                    'area' => filter_var(trim($area), FILTER_SANITIZE_STRING),
                    'job_id' => filter_var(trim($_POST['job_id']), FILTER_SANITIZE_STRING),
                    'modified' => date('Y-m-d H:i:s'),
                    'modified_by' => $_SESSION['MembershipAuth']['user_id']
                );

                // Handle Photo Profile Upload
                if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime_type = finfo_file($finfo, $_FILES['photo']['tmp_name']);
                    finfo_close($finfo);

                    $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

                    if (($mime_type == 'image/jpeg' || $mime_type == 'image/png') && ($ext != 'php')) {
                        $new_fname = $_SESSION['MembershipAuth']['user_id'].'-'.date('YmdHis').'.'.$ext;

                        if (move_uploaded_file($_FILES['photo']['tmp_name'], $this->getContainer()->get('settings')['upload_photo_profile_path'].$new_fname)) {
                            $members_profiles['photo'] = $new_fname;
                            if ($_SESSION['MembershipAuth']['photo'] != null) {
                                unlink($this->getContainer()->get('settings')['upload_photo_profile_path'].$_SESSION['MembershipAuth']['photo']);
                            }

                            $_SESSION['MembershipAuth']['photo'] = $new_fname;

                        } else {
                            $members_profiles['photo'] = null;
                        }
                    }
                }

                $db->update('members_profiles', $members_profiles, array(
                    'user_id' => $_SESSION['MembershipAuth']['user_id']
                ));

                $db->update('users', array(
                    'email' => trim($_POST['email']),
                    'province_id' => $_POST['province_id'],
                    'city_id' => $_POST['city_id'],
                    'area' => $area,
                    'modified' => date('Y-m-d H:i:s'),
                    'modified_by' => $_SESSION['MembershipAuth']['user_id']
                ), array('user_id' => $_SESSION['MembershipAuth']['user_id']));

                // Handle social medias
                if (isset($_POST['socmeds']) && !empty($_POST['socmeds'])) {
                    foreach ($_POST['socmeds'] as $item) {
                        $row = array(
                            'user_id' => $_SESSION['MembershipAuth']['user_id'],
                            'socmed_type' => filter_var(trim($item['socmed_type']), FILTER_SANITIZE_STRING),
                            'account_name' => filter_var(trim($item['account_name']), FILTER_SANITIZE_STRING),
                            'account_url' => filter_var(trim($item['account_url']), FILTER_SANITIZE_STRING),
                            'created' => date('Y-m-d H:i:s')
                        );

                        if ($item['member_socmed_id'] == 0) {
                            $db->insert('members_socmeds', $row);
                        } else {
                            unset($row['created']);
                            $row['modified'] = date('Y-m-d H:i:s');

                            $db->update('members_socmeds', $row, array(
                                'member_socmed_id' => $item['member_socmed_id']
                            ));
                        }

                    }
                }

                if (isset($_POST['socmeds_delete'])) {
                    foreach ($_POST['socmeds_delete'] as $item) {
                        $db->update('members_socmeds', array('deleted' => 'Y'), array(
                            'user_id' => $_SESSION['MembershipAuth']['user_id'],
                            'socmed_type' => $item
                        ));
                    }
                }

                $db->commit();
                $db->close();

                $this->flash->flashLater('success', 'Profile information successfuly updated! Congratulation!');
                return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-profile'));

            } catch (Exception $e) {
                $db->rollback();
                $db->close();

                $this->flash->flashNow('error', 'System failed<br />'.$e->getMessage());
            }

        } else {
            $this->flash->flashNow('warning', 'Some of mandatory fields is empty!');
        }
    }

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
    ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
    ->execute();

    $q_members_socmeds = $db->createQueryBuilder()
    ->select('member_socmed_id', 'socmed_type', 'account_name', 'account_url')
    ->from('members_socmeds')
    ->where('user_id = :uid')
    ->andWhere('deleted = :d')
    ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
    ->setParameter(':d', 'N')
    ->execute();

    $q_provinces = $db->createQueryBuilder()
    ->select('id', 'regional_name')
    ->from('regionals')
    ->where('parent_id IS NULL')
    ->andWhere('city_code = :ccode')
    ->orderBy('province_code, city_code')
    ->setParameter(':ccode', '00', \Doctrine\DBAL\Types\Type::STRING)
    ->execute();

    $q_cities = $db->createQueryBuilder()
    ->select('id', 'regional_name')
    ->from('regionals')
    ->where('parent_id = :pvid')
    ->orderBy('province_code, city_code')
    ->setParameter(':pvid', $_SESSION['MembershipAuth']['province_id'], \Doctrine\DBAL\Types\Type::INTEGER)
    ->execute();

    $q_religions = $db->createQueryBuilder()
    ->select('religion_id', 'religion_name')
    ->from('religions')
    ->execute();

    $q_jobs = $db->createQueryBuilder()
    ->select('job_id')
    ->from('jobs')
    ->execute();

    $member = $q_member->fetch();
    $members_socmeds = $q_members_socmeds->fetchAll();
    $provinces = \Cake\Utility\Hash::combine($q_provinces->fetchAll(), '{n}.id', '{n}.regional_name');
    $cities = \Cake\Utility\Hash::combine($q_cities->fetchAll(), '{n}.id', '{n}.regional_name');
    $religions = \Cake\Utility\Hash::combine($q_religions->fetchAll(), '{n}.religion_id', '{n}.religion_name');
    $jobs = \Cake\Utility\Hash::combine($q_jobs->fetchAll(), '{n}.job_id', '{n}.job_id');

    $genders = array('female' => 'Wanita', 'male' => 'Pria');
    $identity_types = array('ktp' => 'KTP', 'sim' => 'SIM', 'ktm' => 'Kartu Mahasiswa');
    $socmedias = $this->getContainer()->get('settings')['socmedias'];

    $db->close();

    $this->view->getPlates()->addData(
        array(
            'page_title' => 'Membership',
            'sub_page_title' => 'Update Profile Anggota'
        ),
        'layouts::layout-system'
    );

    return $this->view->render(
        $response,
        'membership/profile-edit',
        compact(
            'member',
            'provinces',
            'cities',
            'genders',
            'religions',
            'identity_types',
            'socmedias',
            'members_socmeds',
            'jobs'
        )
    );

})->setName('membership-profile-edit');
