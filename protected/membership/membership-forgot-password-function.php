<?php
$app->map(['GET', 'POST'], '/apps/membership/forgot-password', function ($request, $response, $args) {

    $gcaptcha_site_key = $this->get('settings')['gcaptcha']['site_key'];
    $gcaptcha_secret = $this->get('settings')['gcaptcha']['secret'];
    $use_captcha = $this->get('settings')['use_captcha'];

    if ($request->isPost()) {
        $db = $this->get('db');
        $validator = $this->get('validator');

        $success_msg = 'Email konfirmasi lupa password sudah berhasil dikirim. Segera check email anda. Terimakasih ^_^';
        $success_msg_alt = 'Email konfirmasi lupa password sudah berhasil dikirim. Segera check email anda.<br /><br /><strong>Kemungkinan email akan sampai agak terlambat, karena email server kami sedang mengalami sedikit kendala teknis. Jika belum juga mendapatkan email, maka jangan ragu untuk laporkan kepada kami melalu email: report@phpindonesia.or.id</strong><br /><br />Terimakasih ^_^';

        $validator->createInput($_POST);

        $validator->addNewRule('check_email_exist', function ($field, $value, array $params) use ($db) {
            $q_email_exist = $db->createQueryBuilder()
                ->select('COUNT(*) AS total_data')
                ->from('users')
                ->where('email = :email')
                ->andWhere('activated = :act')
                ->andWhere('deleted = :d')
                ->setParameter(':email', trim($_POST['email']))
                ->setParameter(':act', 'Y', \Doctrine\DBAL\Types\Type::STRING)
                ->setParameter(':d', 'N', \Doctrine\DBAL\Types\Type::STRING)
                ->execute();

            $email_exist = (int) $q_email_exist->fetch()['total_data'];
            if ($email_exist > 0) {
                return true;
            }

            return false;

        }, 'Tidak terdaftar! atau Account anda belum aktif.');

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

        $validator->rule('required', 'email');
        $validator->rule('email', 'email');
        $validator->rule('check_email_exist', 'email');

        if ($use_captcha == true) {
            $validator->rule('verify_captcha', 'captcha');
        }

        if ($validator->validate()) {
            $reset_key = md5(uniqid(rand(), true));
            $reset_expired_date = date('Y-m-d H:i:s', time() + 7200); // 2 jam
            $email_address = trim($_POST['email']);

            $q_member = $db->createQueryBuilder()
                ->select('user_id', 'username')
                ->from('users')
                ->where('email = :email')
                ->setParameter(':email', $email_address)
                ->execute();

            $member = $q_member->fetch();

            $db->insert('users_reset_pwd', array(
                'user_id' => $member['user_id'],
                'reset_key' => $reset_key,
                'expired_date' => $reset_expired_date,
                'email_sent' => 'N',
                'created' => date('Y-m-d H:i:s'),
                'deleted' => 'N'
            ));

            $db->close();

            try {
                $replacements = array();
                $replacements[$email_address] = array(
                    '{email_address}' => $email_address,
                    '{request_reset_date}' => date('d-m-Y H:i:s'),
                    '{reset_path}' => $this->router->pathFor('membership-reset-password', array(
                        'uid' => $member['user_id'],
                        'reset_key' => $reset_key
                    )),
                    '{reset_expired_date}' => date('d-m-Y H:i:s', strtotime($reset_expired_date)),
                    '{base_url}' => $request->getUri()->getBaseUrl()
                );

                $message = Swift_Message::newInstance('PHP Indonesia - Konfirmasi lupa password')
                    ->setFrom(array($this->get('settings')['email']['sender_email'] => $this->get('settings')['email']['sender_name']))
                    ->setTo(array($email_address => $member['username']))
                    ->setBody(file_get_contents(_FULL_APP_PATH_.'protected'._DS_.'views'._DS_.'email'._DS_.'forgot-password-confirmation.txt'));

                $mailer = $this->get('mailer');
                $mailer->registerPlugin(new Swift_Plugins_DecoratorPlugin($replacements));
                $mailer->send($message);

                // Update email sent status
                $db->update('users_reset_pwd', array('email_sent' => 'Y'), array(
                    'user_id' => $member['user_id'],
                    'reset_key' => $reset_key
                ));

                $db->close();

                $this->flash->addMessage('success', $success_msg);
            } catch (Swift_TransportException $e) {
                $this->flash->addMessage('success', $success_msg_alt);
            }

            return $response->withRedirect($this->router->pathFor('membership-login'), 302);

        } else {
            $this->flash->addMessage('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
        }
    }

    $this->view->getPlates()->addData(
        array(
            'page_title' => 'Membership',
            'sub_page_title' => 'Forgot Password',
            'layout_use_captcha' => $use_captcha
        ),
        'layouts::layout-system'
    );

    return $this->view->render(
        $response,
        'membership/forgot-password',
        compact('gcaptcha_site_key', 'use_captcha')
    );

})->setName('membership-forgot-password');
