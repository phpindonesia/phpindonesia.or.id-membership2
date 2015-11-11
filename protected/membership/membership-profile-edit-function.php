<?php
$app->map(['GET', 'POST'], '/apps/membership/profile/edit',
          function ($request, $response, $args) {

    $db             = $this->getContainer()->get('db');
    $q_jobs         = $db->createQueryBuilder()->select('job_id')->from('jobs')->execute();
    $jobs           = \Cake\Utility\Hash::combine($q_jobs->fetchAll(), '{n}.job_id', '{n}.job_id');
    $identity_types = array('ktp' => 'KTP', 'sim' => 'SIM', 'ktm' => 'Kartu Mahasiswa');
    $socmedias      = $this->getContainer()->get('settings')['socmedias'];

    $q_members_socmeds = $db->createQueryBuilder()
        ->select('member_socmed_id', 'socmed_type', 'account_name', 'account_url', 'deleted')
        ->from('members_socmeds')
        ->where('user_id = :uid')
        ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
        ->execute();
    $members_socmeds   = $q_members_socmeds->fetchAll();

    if ($request->isPost()) {
        try {
            $db->beginTransaction();
            $validator = $this->getContainer()->get('validator');
            $validator->createInput($_POST);

            $validator->rule([
                  'email'      => 'email',
                  'dateFormat' => [['birth_date', 'Y-m-d']],
                  'required'   => array(
                        ['fullname'],
                        ['email'],
                        ['province_id'],
                        ['city_id'],
                        ['area'],
                        ['job_id']
                  ),
                  'in'         => array(
                        ['job_id', $jobs],
                        ['identity_type', array_keys($identity_types)]
                  ),
                  'regex'      => array(
                        ['fullname', ':^[A-z\s]+$:'],
                        ['contact_phone', ':^[-\+\d]+$:'],
                        ['identity_number', ':^[-\+\d]+$:'],
                  ),
                  'lengthMax'  => array(
                        ['fullname', 32],
                        ['contact_phone', 16],
                        ['area', 64],
                        ['identity_number', 32],
                        ['birth_place', 32],
                  )
            ]);

            $validator->label([
                  'province_id'     => 'Provinsi',
                  'city_id'         => 'Kabupaten / Kota',
                  'job_id'          => 'Pekerjaan',
                  'birth_place'     => 'Tempat lahir',
                  'birth_date'      => 'Tanggal lahir',
                  'identity_type'   => 'Jenis Identitas',
                  'identity_number' => 'Nomer Identitas',
            ]);

            if (!$validator->validate()) throw new UnexpectedValueException;

            $member = array(
                  'email'       => trim($_POST['email']),
                  'province_id' => (int) $_POST['province_id'],
                  'city_id'     => (int) $_POST['city_id'],
                  'area'        => trim(strip_tags($_POST['area'])),
                  'modified'    => date('Y-m-d H:i:s'),
                  'modified_by' => $_SESSION['MembershipAuth']['user_id']
            );

            $members_profiles = array(
                  'fullname'        => ucwords(strtolower(trim($_POST['fullname']))),
                  'contact_phone'   => trim($_POST['contact_phone']),
                  'birth_place'     => trim(strtoupper(strip_tags($_POST['birth_place']))),
                  'birth_date'      => trim($_POST['birth_date']),
                  'identity_number' => trim($_POST['identity_number']),
                  'identity_type'   => trim($_POST['identity_type']),
                  'religion_id'     => (int) $_POST['religion_id'],
                  'province_id'     => $member['province_id'],
                  'city_id'         => $member['city_id'],
                  'area'            => $member['area'],
                  'job_id'          => trim($_POST['job_id']),
                  'modified'        => date('Y-m-d H:i:s'),
                  'modified_by'     => $_SESSION['MembershipAuth']['user_id']
            );

            $db->update('users', $member, array('user_id' => $_SESSION['MembershipAuth']['user_id']));
            unset($member['modified'], $member['modified_by'], $member['area']);

            // Handle Photo Profile Upload
            if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                $finfo     = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $_FILES['photo']['tmp_name']);
                finfo_close($finfo);

                $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

                if (($mime_type == 'image/jpeg' || $mime_type == 'image/png') && ($ext != 'php')) {

                    $upload_path = $this->getContainer()->get('settings')['upload_photo_profile_path'];
                    $new_fname   = $_SESSION['MembershipAuth']['user_id'] . '-' . date('YmdHis') . '.' . $ext;

                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path . $new_fname)) {
                        if (!empty($_SESSION['MembershipAuth']['photo'])) {
                            unlink($upload_path . $_SESSION['MembershipAuth']['photo']);
                        }

                        $members_profiles['photo'] = $new_fname;
                        $member['photo']           = $new_fname;
                    } else {
                        $this->view->getPlates()->addData(['_view_validation_errors_' => ['photo' => ['Upload error']]]);
                        throw new UnexpectedValueException;
                    }
                } else {
                    $this->view->getPlates()->addData(['_view_validation_errors_' => ['photo' => ['File not supported']]]);
                    throw new UnexpectedValueException;
                }
            }

            $db->update('members_profiles', $members_profiles,
                        array('user_id' => $_SESSION['MembershipAuth']['user_id']));

            // also update session data
            $member['fullname']         = $members_profiles['fullname'];
            $_SESSION['MembershipAuth'] = array_merge($_SESSION['MembershipAuth'], $member);

            // Handle social medias
            if (isset($_POST['socmeds_delete'])) {
                foreach ($_POST['socmeds_delete'] as $item) {
                    $db->update('members_socmeds', array('deleted' => 'Y'),
                                array(
                          'user_id'     => $_SESSION['MembershipAuth']['user_id'],
                          'socmed_type' => $item
                    ));
                }
            }

            if (isset($_POST['socmeds']) && !empty($_POST['socmeds'])) {
                $socmeds = array_keys($socmedias);

                foreach ($_POST['socmeds'] as $i => $item) {
                    $validator->rule('in', "socmeds.{$i}.socmed_type", $socmeds)
                        ->message("Media name #{$i} : unknown media name");
                    $validator->rule('slug', "socmeds.{$i}.account_name")
                        ->label("Account Name #{$i}");
                    $validator->rule('url', "socmeds.{$i}.account_url")
                        ->label("Account Url #{$i}");
                    $validator->validate();

                    $errors = $validator->errors();

                    if (isset($errors["socmeds.{$i}.socmed_type"])) continue;

                    $member = array(
                          'user_id'     => $_SESSION['MembershipAuth']['user_id'],
                          'socmed_type' => trim($item['socmed_type']),
                          'created'     => date('Y-m-d H:i:s')
                    );

                    !isset($errors["socmeds.{$i}.account_name"]) && (
                        $member['account_name'] = trim($item['account_name']));
                    !isset($errors["socmeds.{$i}.account_url"]) && (
                        $member['account_url']  = trim($item['account_url']));

                    // mencegah duplicate entry
                    try {
                        $db->insert('members_socmeds', $member);
                    } catch(Exception $e) {
                        unset($member['created']);
                        $member['modified'] = date('Y-m-d H:i:s');

                        $db->update('members_socmeds', $member,
                                    array(
                              'user_id'     => $member['user_id'],
                              'socmed_type' => $member['socmed_type'],
                        ));
                    }
                }
            }

            $db->commit();
            $db->close();

            $this->flash->flashLater('success', 'Profile information successfuly updated! Congratulation!');
            return $response->withStatus(302)->withHeader('Location',
                                                          $this->router->pathFor('membership-profile'));
        } catch(UnexpectedValueException $e) {
            $db->rollback();
            $db->close();

            $this->flash->flashNow('warning', 'Some of fields are invalid!');
        } catch(Exception $e) {
            $db->rollback();
            $db->close();

            $this->flash->flashNow('error', 'System failed<br />' . $e->getMessage());
        }
    }

    $q_member = $db->createQueryBuilder()
        ->select(
            'm.*', 'reg_prv.regional_name AS province', 'reg_cit.regional_name AS city'
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

    $province_id = isset($_POST['province_id']) ? $_POST['province_id'] :
        $_SESSION['MembershipAuth']['province_id'];

    $q_cities = $db->createQueryBuilder()
        ->select('id', 'regional_name')
        ->from('regionals')
        ->where('parent_id = :pvid')
        ->orderBy('province_code, city_code')
        ->setParameter(':pvid', $province_id, \Doctrine\DBAL\Types\Type::INTEGER)
        ->execute();

    $q_religions = $db->createQueryBuilder()
        ->select('religion_id', 'religion_name')
        ->from('religions')
        ->execute();

    $member    = $q_member->fetch();
    $provinces = \Cake\Utility\Hash::combine($q_provinces->fetchAll(), '{n}.id', '{n}.regional_name');
    $cities    = \Cake\Utility\Hash::combine($q_cities->fetchAll(), '{n}.id', '{n}.regional_name');
    $religions = \Cake\Utility\Hash::combine($q_religions->fetchAll(), '{n}.religion_id', '{n}.religion_name');
    $genders   = array('female' => 'Wanita', 'male' => 'Pria');
    $socmedias = $this->getContainer()->get('settings')['socmedias'];

    $db->close();
    $this->view->getPlates()->addData(
        array(
          'page_title'     => 'Membership',
          'sub_page_title' => 'Update Profile Anggota'
        ), 'layouts::layout-system'
    );

    return $this->view->render(
            $response, 'membership/profile-edit',
            compact(
                'member', 'provinces', 'cities', 'genders', 'religions', 'identity_types', 'socmedias',
                'members_socmeds', 'jobs'
            )
    );

})->setName('membership-profile-edit');
