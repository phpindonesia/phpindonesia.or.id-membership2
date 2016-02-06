<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;
use Membership\Models\Users;
use Membership\Models\UsersResetPwd;
use Swift_Message;
use Swift_Plugins_DecoratorPlugin;
use Swift_TransportException;

class PasswordController extends Controllers
{
    public function forgotPage(Request $request, Response $response, array $args)
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

    public function forgot(Request $request, Response $response, array $args)
    {
        /** @var Users $users */
        $users = $this->data(Users::class);
        $input = $request->getParsedBody();
        $validator = $this->validator->rule('required', 'email');
        $validator->rule('email', 'email');

        $validator->addRule('assertNotEmailExists', function ($field, $value, array $params) use ($users) {
            return !$users->assertEmailExists($value);
        }, 'Email tersebut tidak terdaftar!');

        $validator->rule('assertNotEmailExists', 'email');

        $success_msg = 'Email konfirmasi lupa password sudah berhasil dikirim. Segera check email anda. Terimakasih ^_^';
        $success_msg_alt = 'Email konfirmasi lupa password sudah berhasil dikirim. Segera check email anda.<br><br><strong>Kemungkinan email akan sampai agak terlambat, karena email server kami sedang mengalami sedikit kendala teknis. Jika belum juga mendapatkan email, maka jangan ragu untuk laporkan kepada kami melalu email: report@phpindonesia.or.id</strong><br><br>Terimakasih ^_^';

        if ($validator->validate()) {
            $resetKey = md5(uniqid(rand(), true));
            $emailAddress = $input['email'];
            $resetExpiredDate = date('Y-m-d H:i:s', time() + 7200); // 2 jam
            /** @var UsersResetPwd $usersResetPass */
            $usersResetPass = $this->data(UsersResetPwd::class);

            $member = $users->get(
                ['user_id', 'username'],
                ['email' => $emailAddress]
            )->fetch();

            $usersResetPass->create([
                'user_id' => $member['user_id'],
                'reset_key' => $resetKey,
                'expired_date' => $resetExpiredDate,
                'email_sent' => 'N',
            ]);

            try {
                $emailSettings = $this->settings->get('email');
                $message = \Swift_Message::newInstance('PHP Indonesia - Konfirmasi lupa password')
                    ->setFrom([$emailSettings['sender_email'] => $emailSettings['sender_name']])
                    ->setTo([$emailAddress => $member['username']])
                    ->setBody(file_get_contents(APP_DIR.'views'._DS_.'email'._DS_.'forgot-password-confirmation.txt'));

                $this->mailer->registerPlugin(new \Swift_Plugins_DecoratorPlugin([
                    $emailAddress => [
                        '{email_address}' => $emailAddress,
                        '{request_reset_date}' => date('d-m-Y H:i:s'),
                        '{reset_path}' => $this->router->pathFor('membership-reset-password', [
                            'uid' => $member['user_id'],
                            'reset_key' => $resetKey
                        ]),
                        '{reset_expired_date}' => date('d-m-Y H:i:s', strtotime($resetExpiredDate)),
                        '{base_url}' => $request->getUri()->getBaseUrl()
                    ]
                ]));

                $this->mailer->send($message);

                // Update email sent status
                $usersResetPass->update(['email_sent' => 'Y'], [
                    'user_id' => $member['user_id'],
                    'reset_key' => $resetKey
                ]);

                $this->addFormAlert('success', $success_msg);
            } catch (\PDOException $e) {
                $this->addFormAlert('error', 'System error'.$e->getMessage());
            } catch (\Swift_TransportException $e) {
                $this->addFormAlert('success', $success_msg_alt);
            }
        } else {
            $this->addFormAlert('warning', 'Some of mandatory fields is empty!', $validator->errors());

            return $response->withRedirect($this->router->pathFor('membership-forgot-password'));
        }

        return $response->withRedirect($this->router->pathFor('membership-login'));
    }

    public function updatePage(Request $request, Response $response, array $args)
    {
        $this->enableCaptcha();
        $this->setPageTitle('Membership', 'Update Password');

        return $this->view->render('password-update');
    }

    public function update(Request $request, Response $response, array $args)
    {
        /** @var Users $users */
        $users     = $this->data(Users::class);
        $saltPass  = $this->settings->get('salt_pwd');
        $password  = $request->getParsedBodyParam('password');
        $validator = $this->validator->rule('required', [
            'oldpassword',
            'password',
            'repassword'
        ]);

        $validator->addRule('check_oldpassword', function ($field, $value, array $params) use ($users, $saltPass) {
            $password = md5($saltPass.$value);
            $countPass = $users->count(function ($query) use ($password) {
                $query->where('user_id', '=', $this->session->get('user_id'))
                    ->where('password', '=', $password);
            });

            return $countPass > 0;
        }, 'Wrong! Please remember your old password');

        $validator->rules([
            'check_oldpassword' => 'oldpassword',
            'equals' => [
                ['repassword', 'password']
            ],
            'lengthMin' => [
                ['password', 6],
            ],
        ]);

        if (!$validator->validate()) {
            $this->addFormAlert('warning', 'Some of mandatory fields is empty!', $validator->errors());

            return $response->withRedirect($this->router->pathFor('membership-account-password-edit'));
        }

        $users->update(
            ['password' => $this->salt($password)],
            $this->session->get('user_id')
        );

        $this->addFormAlert('success', 'Password anda berhasil diubah! Selamat!');

        return $response->withRedirect($this->router->pathFor('membership-account'));
    }

    public function reset(Request $request, Response $response, array $args)
    {
        /** @var Users $users */
        $users = $this->data(Users::class);
        /** @var UsersResetPwd $usersResetPass */
        $usersResetPass = $this->data(UsersResetPwd::class);

        if ($usersResetPass->verifyUserKey($args['uid'], $args['reset_key'])) {
            $success_msg = 'Password baru sementara anda sudah dikirim ke email. Segera check email anda. Terimakasih ^_^';
            $success_msg_alt = 'Password baru sementara anda sudah dikirim ke email.<br><br><strong>Kemungkinan email akan sampai agak terlambat, karena email server kami sedang mengalami sedikit kendala teknis. Jika belum juga mendapatkan email, maka jangan ragu untuk laporkan kepada kami melalu email: report@phpindonesia.or.id</strong><br><br>Terimakasih ^_^';

            // Fetch member basic info
            $member = $users->get(['username', 'email'], function ($query) use ($args) {
                $query->where('user_id', '=', (int) $args['uid']);
            })->fetch();
            $emailAddress = $member['email'];

            // Create temporary password
            $tmpPass = substr(str_shuffle(md5(microtime())), 0, 10);

            $users->update([
                'password' => $this->salt($tmpPass),
                'modified_by' => 0
            ], (int) $args['uid']);

            $usersResetPass->delete([
                'user_id' => (int) $args['uid'],
                'reset_key' => $args['reset_key']
            ]);

            // Then send new temporary password to email
            try {
                $emailSettings = $this->settings->get('email');
                $message = \Swift_Message::newInstance('PHP Indonesia - Password baru sementara')
                    ->setFrom([$emailSettings['sender_email'] => $emailSettings['sender_name']])
                    ->setTo([$emailAddress => $member['username']])
                    ->setBody(file_get_contents(APP_DIR.'views'._DS_.'email'._DS_.'password-change-ok-confirmation.txt'));

                $this->mailer->registerPlugin(new \Swift_Plugins_DecoratorPlugin([
                    $emailAddress => ['{temp_pwd}' => $tmpPass]
                ]));
                $this->mailer->send($message);

                $this->addFormAlert('success', $success_msg);
            } catch (\Swift_TransportException $e) {
                $this->addFormAlert('success', $success_msg_alt);
            }
        } else {
            $this->addFormAlert('error', 'Bad Request');
        }

        return $response->withRedirect($this->router->pathFor('membership-login'));
    }
}
