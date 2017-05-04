<?php

namespace Membership\Http\Controllers;

use Membership\Http\Request;
use Membership\Http\Response;
use Membership\Http\Controllers;
use Membership\Mail\MessageException;
use Membership\Models;

class PasswordController extends Controllers
{
    public function forgotPage(Response $response)
    {
        $this->enableCaptcha();
        $this->setPageTitle('Membership', 'Forgot Password');

        $this->view->addData([
            'helpTitle' => 'Bantuan Login?',
            'helpContent' => [
                'Jika belum terdaftar sebagai anggota, <a href="'.$this->router->pathFor('membership-register').'" title="">Daftar Disini</a> menjadi anggota PHP Indonesia.',
                'Sudah pernah terdaftar menjadi anggota PHP Indonesia, silahkan <a href="'.$this->router->pathFor('membership-login').'" title="">Login Disini.'
            ],
        ], 'layout::account');

        return $response->view('password-forgot');
    }

    public function forgot(Request $request, Response $response)
    {
        $users = new Models\Users;
        $input = $request->getParsedBody();
        $validator = $this->validator->rule('required', 'email');
        $validator->rule('email', 'email');

        $validator->addRule('assertNotEmailExists', function ($field, $value, array $params) use ($users) {
            return $users->assertEmailExists($value);
        }, 'tersebut tidak terdaftar!');

        $validator->rule('assertNotEmailExists', 'email');

        if ($validator->validate()) {
            $resetKey = md5(uniqid(rand(), true));
            $emailAddress = $input['email'];
            $resetExpiredDate = date('Y-m-d H:i:s', time() + 7200); // 2 jam

            $member = $users->get(
                ['u.user_id', 'u.username', 'u.email', 'm.fullname'],
                function ($query) use ($emailAddress) {
                    $query->from('users u')
                        ->leftJoin('members_profiles m', 'u.user_id', '=', 'm.user_id')
                        ->where('u.email', '=', $emailAddress)
                        ->where('u.deleted', '=', 'N');
                }
            )->fetch();

            $doReset = (new Models\UsersResetPwd)->create([
                'user_id' => $member['user_id'],
                'reset_key' => $resetKey,
                'expired_date' => $resetExpiredDate,
                'email_sent' => 'N',
            ]);

            if ($doReset) {
                $successMsg = 'Email konfirmasi lupa password sudah berhasil dikirim. Segera check email anda';

                try {
                    $data = ['uid' => $member['user_id'], 'reset_key' => $resetKey];

                    $this->mail->to($emailAddress, $member['fullname'])
                        ->subject('PHP Indonesia - Konfirmasi lupa password')
                        ->send('email::forgot-password', [
                            'email' => $emailAddress,
                            'fullname' => $member['fullname'],
                            'reqDate' => date('d-m-Y H:i:s'),
                            'resetExp' => $resetExpiredDate,
                            'resetUrl' => $this->router->pathFor('membership-reset-password', $data),
                        ]);
                } catch (MessageException $e) {
                    if ($this->settings['mode'] = 'development') {
                        throw $e;
                    }

                    $successMsg .= '<br><br><strong>Kemungkinan email akan sampai agak terlambat, karena email server kami sedang mengalami sedikit kendala teknis. Jika anda belum juga mendapatkan email, maka jangan ragu untuk laporkan kepada kami melalu email: report@phpindonesia.or.id</strong>';
                }
            }

            $this->addFormAlert('success', $successMsg . '. Terima kasih ^_^.');
        } else {
            $this->addFormAlert('warning', 'Some of mandatory fields is empty!', $validator->errors());

            return $response->withRedirectRoute('membership-forgot-password');
        }

        $response->withRedirectRoute('membership-login');
    }

    public function updatePage(Response $response)
    {
        $this->enableCaptcha();
        $this->setPageTitle('Membership', 'Update Password');

        return $response->view('password-update');
    }

    public function update(Request $request, Response $response)
    {
        $users     = new Models\Users;
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

            return $response->withRedirectRoute('membership-account-password-edit');
        }

        $users->update(
            ['password' => $this->salt($password)],
            $this->session->get('user_id')
        );

        $this->addFormAlert('success', 'Password anda berhasil diubah! Selamat!');

        return $response->withRedirectRoute('membership-account');
    }

    public function reset(Request $request, Response $response, $uid, $reset_key)
    {
        $users = new Models\Users;
        $usersResetPass = (new Models\UsersResetPwd);

        if ($usersResetPass->verifyUserKey($uid, $reset_key)) {
            // Create temporary password
            $tmpPass = substr(str_shuffle(md5(microtime())), 0, 10);

            $users->update([
                'password' => $this->salt($tmpPass),
                'modified_by' => 0
            ], (int) $uid);

            $usersResetPass->delete([
                'user_id' => (int) $uid,
                'reset_key' => $reset_key
            ]);

            // Fetch member basic info
            $member = $users->get(
                ['u.user_id', 'u.username', 'u.email', 'm.fullname'],
                function ($query) use ($uid) {
                    $query->from('users u')
                        ->leftJoin('members_profiles m', 'u.user_id', '=', 'm.user_id')
                        ->where('u.user_id', '=', (int) $uid)
                        ->where('u.deleted', '=', 'N');
                }
            )->fetch();

            try {
                $this->mail
                    ->to($member['email'], $member['fullname'])
                    ->subject('PHP Indonesia - Password baru sementara')
                    ->send('email::reset-password', [
                        'tmpPass' => $tmpPass,
                        'fullname' => $member['fullname'],
                    ]);

                $successMsg = 'Password baru sementara anda sudah dikirim ke email, Segera check email anda.';
            } catch (MessageException $e) {
                if ($this->settings['mode'] = 'development') {
                    throw $e;
                }

                $successMsg = '<br><br><strong>Kemungkinan email akan sampai agak terlambat, karena email server kami sedang mengalami sedikit kendala teknis. Jika anda belum juga mendapatkan email, maka jangan ragu untuk laporkan kepada kami melalu email: report@phpindonesia.or.id</strong>';
            }

            $this->addFormAlert('success', $successMsg . '. Terima kasih ^_^.');
        } else {
            $this->addFormAlert('error', 'Bad Request');
        }

        $response->withRedirectRoute('membership-login');
    }
}
