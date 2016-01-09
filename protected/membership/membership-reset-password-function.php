<?php
$app->get('/apps/membership/reset-password/{uid}/{reset_key}', function ($request, $response, $args) {

    $db = $this->get('db');

    $q_reset_exist_count = $db->createQueryBuilder()
    ->select('COUNT(*) AS total_data')
    ->from('users_reset_pwd')
    ->where('user_id = :uid')
    ->andWhere('reset_key = :resetkey')
    ->andWhere('deleted = :d')
    ->andWhere('email_sent = :sent')
    ->andWhere('expired_date > NOW()')
    ->setParameter(':uid', $args['uid'])
    ->setParameter(':resetkey', $args['reset_key'])
    ->setParameter(':d', 'N')
    ->setParameter(':sent', 'Y')
    ->execute();

    $reset_exist_count = (int) $q_reset_exist_count->fetch()['total_data'];

    if ($reset_exist_count > 0) {
        $success_msg = 'Password baru sementara anda sudah dikirim ke email. Segera check email anda. Terimakasih ^_^';
        $success_msg_alt = 'Password baru sementara anda sudah dikirim ke email.<br /><br /><strong>Kemungkinan email akan sampai agak terlambat, karena email server kami sedang mengalami sedikit kendala teknis. Jika belum juga mendapatkan email, maka jangan ragu untuk laporkan kepada kami melalu email: report@phpindonesia.or.id</strong><br /><br />Terimakasih ^_^';

    	// Fetch member basic info
    	$q_member = $db->createQueryBuilder()
    	->select('username', 'email')->from('users')->where('user_id = :uid')
    	->setParameter(':uid', $args['uid'])->execute();

    	$member = $q_member->fetch();
    	$email_address = $member['email'];

        // Handle new temporary password
        $salt_pwd = $this->get('settings')['salt_pwd'];
        $temp_pwd = substr(str_shuffle(md5(microtime())), 0, 10);
        $salted_temp_pwd = md5($salt_pwd.$temp_pwd);

        $db->update('users', array(
        	'password' => $salted_temp_pwd,
        	'modified' => date('Y-m-d H:i:s'),
        	'modified_by' => 0
        ), array('user_id' => $args['uid']));

        $db->update('users_reset_pwd', array('deleted' => 'Y' ), array(
            'user_id' => $args['uid'],
            'reset_key' => $args['reset_key']
        ));

        $db->close();

        // Then send new temporary password to email
        try {
            $replacements = array();
            $replacements[$email_address] = array(
                '{temp_pwd}' => $temp_pwd
            );

            $message = Swift_Message::newInstance('PHP Indonesia - Password baru sementara')
            ->setFrom(array($this->get('settings')['email']['sender_email'] => $this->get('settings')['email']['sender_name']))
            ->setTo(array($email_address => $member['username']))
            ->setBody(file_get_contents(_FULL_APP_PATH_.'protected'._DS_.'views'._DS_.'email'._DS_.'password-change-ok-confirmation.txt'));

            $mailer = $this->get('mailer');
            $mailer->registerPlugin(new Swift_Plugins_DecoratorPlugin($replacements));
            $mailer->send($message);

            $this->flash->addMessage('success', $success_msg);
            return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-login'));

        } catch (Swift_TransportException $e) {
            $this->flash->addMessage('success', $success_msg_alt);
            return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-login'));
        }

    } else {
        $this->flash->addMessage('error', 'Bad Request');
        return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-login'));
    }

})->setName('membership-reset-password');

