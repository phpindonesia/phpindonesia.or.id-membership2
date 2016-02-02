<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;
use Membership\Models\Users;

class ProfileController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Detail Anggota');

        $users = $this->data(Users::class);
        $user = $users->get([
            'u.user_id', 'u.username', 'u.email', 'u.created', 'm.*',
            'reg_prv.regional_name province',
            'reg_cit.regional_name city'
        ], function ($query) use ($args) {
            $query->from('users u')
                ->leftJoin('members_profiles m', 'u.user_id', '=', 'm.user_id')
                ->leftJoin('regionals reg_prv', 'reg_prv.id', '=', 'm.province_id')
                ->leftJoin('regionals reg_cit', 'reg_cit.id', '=', 'm.city_id')
                ->where('u.username', '=', $args['username']);
        })->fetch();

        return $this->view->render('profile-index', [
            'member'            => $user,
            'member_portfolios' => $users->getPortfolios($user['user_id']),
            'member_skills'     => $users->getSkills($user['user_id']),
            'member_socmeds'    => $users->getSocmends($user['user_id']),
            'socmedias'         => $this->settings->get('socmedias'),
        ]);
    }

    public function forgotPasswordPage(Request $request, Response $response, array $args)
    {
        $this->enableCaptcha();
        $this->setPageTitle('Membership', 'Forgot Password');

        $this->view->addData([
            'helpTitle' => 'Bantuan Login?',
            'helpContent' => [
                'Jika belum terdaftar sebagai anggota, <a href="'.$this->router->pathFor('membership-register').'" title="">Daftar Disini</a> menjadi anggota PHP Indonesia.',
                'Sudah pernah terdaftar menjadi anggota PHP Indonesia, silahkan <a href="'.$this->router->pathFor('membership-login').'" title="">Login Disini.'
            ],
        ], 'layouts::account');

        return $this->view->render('password-forgot');
    }

    public function forgotPassword(Request $request, Response $response, array $args)
    {
        $users = $this->data(Users::class);
        $validator = $this->validator->rule('required', 'email');
        $validator->rule('email', 'email');

        $validator->addNewRule('assertEmailExists', function ($field, $value, array $params) use ($users) {
            return !$users->assertEmailExists($value);
        }, 'Email tersebut belum terdaftar!');

        $validator->rule('assertEmailExists', 'email');

        if ($gcaptcha['enable'] == true) {
            $validator->addNewRule('verify_captcha', function ($field, $value, array $params) use ($gcaptcha) {
                $result = false;
                if (isset($post['g-recaptcha-response'])) {
                    $recaptcha = new ReCaptcha($gcaptcha['secret']);
                    $resp = $recaptcha->verify($post['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
                    $result = $resp->isSuccess();
                }

                return $result;
            }, 'Tidak tepat!');

            $validator->rule('verify_captcha', 'captcha');
        }

        $success_msg = 'Email konfirmasi lupa password sudah berhasil dikirim. Segera check email anda. Terimakasih ^_^';
        $success_msg_alt = 'Email konfirmasi lupa password sudah berhasil dikirim. Segera check email anda.<br /><br /><strong>Kemungkinan email akan sampai agak terlambat, karena email server kami sedang mengalami sedikit kendala teknis. Jika belum juga mendapatkan email, maka jangan ragu untuk laporkan kepada kami melalu email: report@phpindonesia.or.id</strong><br /><br />Terimakasih ^_^';

        if ($validator->validate()) {
            $reset_key = md5(uniqid(rand(), true));
            $reset_expired_date = date('Y-m-d H:i:s', time() + 7200); // 2 jam
            $email_address = trim($post['email']);

            $member = $users->get(
                ['user_id', 'username'],
                ['email' => $email_address]
            )->fetch();

            $this->db->insert('users_reset_pwd', array(
                'user_id' => $member['user_id'],
                'reset_key' => $reset_key,
                'expired_date' => $reset_expired_date,
                'email_sent' => 'N',
                'created' => date('Y-m-d H:i:s'),
                'deleted' => 'N'
            ));

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
                    ->setFrom(array($this->settings->get('email')['sender_email'] => $this->settings->get('email')['sender_name']))
                    ->setTo(array($email_address => $member['username']))
                    ->setBody(file_get_contents(APP_DIR.'protected'._DS_.'views'._DS_.'email'._DS_.'forgot-password-confirmation.txt'));

                $mailer = $this->get('mailer');
                $mailer->registerPlugin(new Swift_Plugins_DecoratorPlugin($replacements));
                $mailer->send($message);

                // Update email sent status
                $this->db->update('users_reset_pwd', array('email_sent' => 'Y'), array(
                    'user_id' => $member['user_id'],
                    'reset_key' => $reset_key
                ));

                $this->flash->addMessage('success', $success_msg);
            } catch (Swift_TransportException $e) {
                $this->flash->addMessage('success', $success_msg_alt);
            }
        } else {
            $this->flash->addMessage('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
        }

        return $response->withRedirect($this->router->pathFor('membership-login'));
    }

    public function resetPassword(Request $request, Response $response, array $args)
    {
        $q_reset_exist_count = $this->db
            ->select('COUNT(*) AS total_data')
            ->from('users_reset_pwd')
            ->where('user_id', '=', $args['uid'])
            ->where('reset_key', '=', $args['reset_key'])
            ->where('deleted', '=', 'N')
            ->where('email_sent', '=', 'Y')
            ->where('expired_date', '>', 'NOW()')
            ->execute();

        $reset_exist_count = (int) $q_reset_exist_count->fetch()['total_data'];

        if ($reset_exist_count > 0) {
            $success_msg = 'Password baru sementara anda sudah dikirim ke email. Segera check email anda. Terimakasih ^_^';
            $success_msg_alt = 'Password baru sementara anda sudah dikirim ke email.<br /><br /><strong>Kemungkinan email akan sampai agak terlambat, karena email server kami sedang mengalami sedikit kendala teknis. Jika belum juga mendapatkan email, maka jangan ragu untuk laporkan kepada kami melalu email: report@phpindonesia.or.id</strong><br /><br />Terimakasih ^_^';

            // Fetch member basic info
            $q_member = $this->db
                ->select('username', 'email')->from('users')->where('user_id = :uid')
                ->setParameter(':uid', $args['uid'])->execute();

            $member = $q_member->fetch();
            $email_address = $member['email'];

            // Handle new temporary password
            $salt_pwd = $this->settings->get('salt_pwd');
            $temp_pwd = substr(str_shuffle(md5(microtime())), 0, 10);
            $salted_temp_pwd = md5($salt_pwd.$temp_pwd);

            $this->db->update('users', array(
                'password' => $salted_temp_pwd,
                'modified' => date('Y-m-d H:i:s'),
                'modified_by' => 0
            ), array('user_id' => $args['uid']));

            $this->db->update('users_reset_pwd', array('deleted' => 'Y' ), array(
                'user_id' => $args['uid'],
                'reset_key' => $args['reset_key']
            ));

            // Then send new temporary password to email
            try {
                $replacements = array();
                $replacements[$email_address] = array(
                    '{temp_pwd}' => $temp_pwd
                );

                $message = Swift_Message::newInstance('PHP Indonesia - Password baru sementara')
                    ->setFrom(array($this->settings->get('email')['sender_email'] => $this->settings->get('email')['sender_name']))
                    ->setTo(array($email_address => $member['username']))
                    ->setBody(file_get_contents(APP_DIR.'protected'._DS_.'views'._DS_.'email'._DS_.'password-change-ok-confirmation.txt'));

                $mailer = $this->get('mailer');
                $mailer->registerPlugin(new Swift_Plugins_DecoratorPlugin($replacements));
                $mailer->send($message);

                $this->flash->addMessage('success', $success_msg);
            } catch (\Swift_TransportException $e) {
                $this->flash->addMessage('success', $success_msg_alt);
            }
        } else {
            $this->flash->addMessage('error', 'Bad Request');
        }

        return $response->withRedirect($this->router->pathFor('membership-login'));
    }
}
