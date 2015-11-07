<?php
$app->map(['GET', 'POST'], '/apps/membership/register', function ($request, $response, $args) {

    $db = $this->getContainer()->get('db');
    $gcaptcha_site_key = $this->getContainer()->get('settings')['gcaptcha']['site_key'];
    $gcaptcha_secret = $this->getContainer()->get('settings')['gcaptcha']['secret'];
    $use_captcha = $this->getContainer()->get('settings')['use_captcha'];

    if ($request->isPost()) {
        $validator = $this->getContainer()->get('validator');
        $validator->createInput($_POST);
        $validator->rule('required', array(
            'username',
            'password',
            'repassword',
            'email',
            'province_id',
            'city_id',
            'area',
            'job_id',
            'fullname',
            'gender_id'
        ));

        if ($use_captcha == true) {
            $validator->addNewRule('verify_captcha', function ($field, $value, array $params) use ($gcaptcha_secret) {
                $result = false;

                if (isset($_POST['g-recaptcha-response'])) {
                    $recaptcha = new \ReCaptcha\ReCaptcha($gcaptcha_secret);
                    $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

                    $result = $resp->isSuccess();
                }

                return $result;

            }, 'Tidak tepat!');
        }

        $validator->addNewRule('check_repassword', function ($field, $value, array $params) {
            if ($value != $_POST['password']) {
                return false;
            }

            return true;

        }, 'Not match with current password');

        $validator->addNewRule('check_email_exist', function ($field, $value, array $params) use ($db) {
            $q_email_count = $db->createQueryBuilder()
            ->select('COUNT(*) AS total_data')
            ->from('users')
            ->where('email = :email')
            ->andWhere('deleted = :d')
            ->setParameter(':email', trim(strtolower($_POST['email'])))
            ->setParameter(':d', 'N')
            ->execute();

            $email_count = (int) $q_email_count->fetch()['total_data'];
            $db->close();

            if ($email_count > 0) {
                return false;
            }

            return true;

        }, 'Already exist');

        $validator->addNewRule('check_username_exist', function ($field, $value, array $params) use ($db) {
            $q_username_count = $db->createQueryBuilder()
            ->select('COUNT(*) AS total_data')
            ->from('users')
            ->where('username = :uname')
            ->andWhere('deleted = :d')
            ->setParameter(':uname', trim(strtolower($_POST['username'])))
            ->setParameter(':d', 'N')
            ->execute();

            $username_count = (int) $q_username_count->fetch()['total_data'];
            $db->close();

            if ($username_count > 0) {
                return false;
            }

            return true;

        }, 'Already exist');

        $validator->rule('email', 'email');
        $validator->rule('check_repassword', 'repassword');
        $validator->rule('check_email_exist', 'email');
        $validator->rule('check_username_exist', 'username');

        if ($use_captcha == true) {
            $validator->rule('verify_captcha', 'captcha');
        }

        if ($validator->validate()) {
            $salt_pwd = md5($this->getContainer()->get('settings')['salt_pwd'].$_POST['password']);
            $area = trim($_POST['area']);
            $area = empty($area) ? null : $area;
            $fullname = ucwords(trim($_POST['fullname']));
            $email_address = trim($_POST['email']);

            $last_user_id = null;
            $activation_key = md5(uniqid(rand(), true));
            $activation_expired_date = date('Y-m-d H:i:s', time() + 172800); // 48 jam

            $register_success_msg = 'Haayy <strong>'.$fullname.'</strong>,<br /> Submission keanggotan sudah berhasil disimpan. Akan tetapi account anda tidak langsung aktif. Demi keamanan dan validitas data, maka sistem telah mengirimkan email ke email anda, untuk melakukan aktivasi account. Segera check email anda! Terimakasih ^_^';
            $register_success_msg_alt = 'Haayy <strong>'.$fullname.'</strong>,<br /> Submission keanggotan sudah berhasil disimpan. Akan tetapi account anda tidak langsung aktif. Demi keamanan dan validitas data, maka sistem telah mengirimkan email ke email anda, untuk melakukan aktivasi account. Segera check email anda! Terimakasih ^_^<br /><br /><strong>Kemungkinan email akan sampai agak terlambat, karena email server kami sedang mengalami sedikit kendala teknis. Jika anda belum juga mendapatkan email, maka jangan ragu untuk laporkan kepada kami melalu email: report@phpindonesia.or.id</strong>';

            $trx_success = false;
            $db->beginTransaction();

            try {
                $db->insert('users', array(
                    'username' => filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING),
                    'password' => $salt_pwd,
                    'email' => $email_address,
                    'province_id' => $_POST['province_id'],
                    'city_id' => $_POST['city_id'],
                    'area' => $area,
                    'created' => date('Y-m-d H:i:s'),
                    'created_by' => 0
                ));

                $last_user_id = $db->lastInsertId();

                $db->insert('users_roles', array(
                    'user_id' => $last_user_id,
                    'role_id' => 'member',
                    'created' => date('Y-m-d H:i:s'),
                    'created_by' => 0
                ));

                $db->insert('members_profiles', array(
                    'user_id' => $last_user_id,
                    'fullname' => $fullname,
                    'gender' => $_POST['gender_id'],
                    'province_id' => $_POST['province_id'],
                    'city_id' => $_POST['city_id'],
                    'area' => $area,
                    'job_id' => $_POST['job_id'],
                    'created' => date('Y-m-d H:i:s'),
                    'created_by' => 0
                ));

                $db->insert('users_activations', array(
                    'user_id' => $last_user_id,
                    'activation_key' => $activation_key,
                    'expired_date' => $activation_expired_date,
                    'created' => date('Y-m-d H:i:s'),
                    'deleted' => 'N'
                ));

                $db->commit();
                $db->close();
                $trx_success = true;

            } catch (Exception $e) {
                $db->rollback();
                $db->close();
                $trx_success = false;

                $this->flash->flashNow('error', 'System gagal!<br />'.$e->getMessage());

            }

            // Sending activation email handler //
            if ($trx_success) {
                try {
                    $replacements = array();
                    $replacements[$email_address] = array(
                        '{email_address}' => $email_address,
                        '{fullname}' => filter_var(trim($fullname), FILTER_SANITIZE_STRING),
                        '{registration_date}' => date('d-m-Y H:i:s'),
                        '{activation_path}' => $this->router->pathFor('membership-activation', array('uid' => $last_user_id, 'activation_key' => $activation_key)),
                        '{activation_expired_date}' => $activation_expired_date,
                        '{base_url}' => $request->getUri()->getBaseUrl()
                    );

                    $message = Swift_Message::newInstance('PHP Indonesia - Aktivasi Membership')
                    ->setFrom(array($this->getContainer()->get('settings')['email']['sender_email'] => $this->getContainer()->get('settings')['email']['sender_name']))
                    ->setTo(array($email_address => $fullname))
                    ->setBody(file_get_contents(_FULL_APP_PATH_.'protected'._DS_.'views'._DS_.'email'._DS_.'activation.txt'));

                    $mailer = $this->getContainer()->get('mailer');
                    $mailer->registerPlugin(new Swift_Plugins_DecoratorPlugin($replacements));
                    $mailer->send($message);

                    // Update email sent status
                    $db->update('users_activations', array('email_sent' => 'Y'), array(
                        'user_id' => $last_user_id,
                        'activation_key' => $activation_key
                    ));

                    $db->close();

                    $this->flash->flashLater('success', $register_success_msg);
                    return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-index'));

                } catch (Swift_TransportException $e) {
                    $this->flash->flashLater('success', $register_success_msg_alt);
                    return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-index'));
                }
            }

        } else {
            $this->flash->flashNow('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
        }
    }

    $q_provinces = $db->createQueryBuilder()
    ->select('id', 'regional_name')
    ->from('regionals')
    ->where('parent_id IS NULL')
    ->andWhere('city_code = :ccode')
    ->orderBy('province_code, city_code')
    ->setParameter(':ccode', '00', \Doctrine\DBAL\Types\Type::STRING)
    ->execute();

    $q_jobs = $db->createQueryBuilder()
    ->select('job_id')
    ->from('jobs')
    ->execute();

    // Just default value for list of cities
    $cities = array();
    // In case someone failed to register and we have $_POST['province_id'] already set
    if ($province_id = $request->getParam('province_id')) {
        // Just copy the functionality of common-data-cities-function.php
        // and wondering why we don't put it independently so share functionality could be much more easier
        $q_cities = $this->db->createQueryBuilder()
            ->select('id', 'regional_name')
            ->from('regionals')
            ->where('parent_id = :pid')
            ->orderBy('province_code, city_code')
            ->setParameter(':pid', $province_id)
            ->execute();

        $cities = \Cake\Utility\Hash::combine($q_cities->fetchAll(), '{n}.id', '{n}.regional_name');
    }

    $provinces = \Cake\Utility\Hash::combine($q_provinces->fetchAll(), '{n}.id', '{n}.regional_name');
    $jobs = \Cake\Utility\Hash::combine($q_jobs->fetchAll(), '{n}.job_id', '{n}.job_id');

    $db->close();

    $this->view->getPlates()->addData(
        array(
            'page_title' => 'Membership',
            'sub_page_title' => 'Registrasi Anggota',
            'layout_use_captcha' => $use_captcha
        ),
        'layouts::layout-system'
    );

    return $this->view->render(
        $response,
        'membership/register',
        compact('provinces', 'cities', 'jobs', 'gcaptcha_site_key', 'use_captcha')
    );

})->setName('membership-register');

