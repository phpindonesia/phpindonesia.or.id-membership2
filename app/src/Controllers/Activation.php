<?php
namespace Membership\Controllers;

use Membership\Controllers;
use Slim\Exception\NotFoundException;

class Activation extends Controllers
{
    public function reactivatePage($request, $response, $args)
    {
        $this->enableCaptcha();
        $this->setPageTitle('Membership', 'Account Reactivation');

        $this->view->addData([
            'helpTitle' => 'Bantuan Login?',
            'helpContent' => [
                'Jika belum terdaftar sebagai anggota, <a href="'.$this->router->pathFor('membership-register').'" title="">Daftar Disini</a> menjadi anggota PHP Indonesia.',
                'Sudah pernah terdaftar menjadi anggota PHP Indonesia, silahkan <a href="'.$this->router->pathFor('membership-login').'" title="">Login Disini.'
            ],
        ], 'layouts::account');

        return $this->view->render('activation-reactivate');
    }

    public function activate($request, $response, $args)
    {
        $q_activation_exist_count = $this->db
            ->select('COUNT(*) AS total_data')
            ->from('users_activations')
            ->where('user_id = :uid')
            ->where('activation_key = :actkey')
            ->where('deleted = :d')
            ->where('expired_date > NOW()')
            ->setParameter(':uid', $args['uid'])
            ->setParameter(':actkey', $args['activation_key'])
            ->setParameter(':d', 'N')
            ->execute();

        $activation_exist_count = (int) $q_activation_exist_count->fetch()['total_data'];

        if ($activation_exist_count > 0) {
            $this->db->update('users', ['activated' => 'Y'], ['user_id' => $args['uid']]);

            $this->db->update('users_activations', ['deleted' => 'Y'], [
                'user_id' => $args['uid'],
                'activation_key' => $args['activation_key']
            ]);

            $this->flash->addMessage('success', 'Selamat! Account anda sudah aktif. Silahkan login...');
        } else {
            $this->flash->addMessage('error', 'Bad Request');
        }

        return $response->withRedirect(
            $this->router->pathFor('membership-login')
        );
    }

    public function reactivate($request, $response, $args)
    {
        $validator = $this->validator->createInput($_POST);

        $validator->addNewRule('check_email_exist', function ($field, $value, array $params) use ($db) {
            $q_email_exist = $this->db
                ->select('COUNT(*) AS total_data')
                ->from('users')
                ->where('email = :email')
                ->where('deleted = :d')
                ->setParameter(':email', trim($_POST['email']))
                ->setParameter(':d', 'N')
                ->execute();

            $email_exist = (int) $q_email_exist->fetch()['total_data'];
            if ($email_exist > 0) {
                return true;
            }

            return false;

        }, 'Tidak terdaftar!');

        $validator->rule('required', 'email');
        $validator->rule('check_email_exist', 'email');

        if ($validator->validate()) {
            //
        }
    }
}