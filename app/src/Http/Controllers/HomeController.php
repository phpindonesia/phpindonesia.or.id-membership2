<?php

namespace Membership\Http\Controllers;

use Membership\Collection;
use Membership\Http\Request;
use Membership\Http\Response;
use Membership\Http\Controllers;
use Membership\Http\ValidatorException;
use Membership\Mail\MessageException;
use Membership\Mail\MessageInterface;
use Membership\Models;

class HomeController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Keanggotaan');

        $users = new Models\Users;
        $regionals  = new Models\Regionals;

        $provinceId = $request->getQueryParam('province_id');

        return $response->view('home-index', [
            'members'     => $users->getMembers($request),
            'totalMember' => $users->getTotalMember($request),
            'provinces'   => array_pairs($regionals->getProvinces(), 'id', 'regional_name'),
            'cities'      => array_pairs($regionals->getCities($provinceId), 'id', 'regional_name'),
        ]);
    }

    public function loginPage(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Login Anggota');

        $this->view->addData([
            'helpTitle' => 'Bantuan Login?',
            'helpContent' => [
                'Jika belum terdaftar sebagai anggota, <a href="'.$this->router->pathFor('membership-register').'" title="">Daftar Disini</a> menjadi anggota PHP Indonesia.',
                'Hilang atau lupa password login, silahkan <a href="'.$this->router->pathFor('membership-forgot-password').'" title="">Reset Password</a> Anda.'
            ],
        ], 'layout::account');

        return $response->view('home-login');
    }

    public function login(Request $request, Response $response, array $args)
    {
        $request->rules([
            'required' => ['login', 'password']
        ]);

        try {
            $request->validate(new Models\Users, function (Collection $input, Models\Users $users) {
                $user = $users->authenticate(
                    $input->get('login'),
                    $this->salt($input->get('password'))
                );

                if ($user) {
                    $_SESSION['MembershipAuth'] = [
                        'user_id' => $user['user_id']
                    ];
                    $this->session->replace($_SESSION['MembershipAuth']);

                    $users->updateLogin($user['user_id']);
                }
            });

            return $response->withRedirectRoute('membership-account');
        } catch (\Throwable $e) {
            if ($e instanceof ValidatorException) {
                $this->addFormAlert('warning', $e->getMessage(), $e->getErrors());
            }

            $this->addFormAlert('error', $e->getMessage());

            $response->withRedirectRoute('membership-login');
        }
    }

    public function registerPage(Request $request, Response $response, array $args)
    {
        $this->enableCaptcha();
        $this->setPageTitle('Membership', 'Registrasi Anggota');

        $this->view->addData([
            'helpTitle' => 'Bantuan Register?',
            'helpContent' => [
                'Sudah pernah terdaftar menjadi anggota PHP Indonesia, silahkan <a href="'.$this->router->pathFor('membership-login').'" title="">Login Disini',
                'Hilang atau lupa password login, silahkan <a href="'.$this->router->pathFor('membership-forgot-password').'" title="">Reset Password</a> Anda.'
            ],
        ], 'layout::account');

        $regionals = new Models\Regionals;
        $provinceId = $request->getParam('province_id');

        return $response->view('home-register', [
            'provinces' => array_pairs($regionals->getProvinces(), 'id', 'regional_name'),
            'cities'    => array_pairs($regionals->getCities($provinceId), 'id', 'regional_name'),
            'jobs'      => array_pairs((new Models\Careers)->getJobs(), 'job_id'),
        ]);
    }

    public function register(Request $request, Response $response, array $args)
    {
        $request->rules('required', [
            'email', 'username', 'fullname', 'password', 'repassword',
            'job_id', 'gender_id', 'province_id', 'area',
            // 'city_id', // disable it for now
        ]);

        try {
            $request->validate(new Models\Users, function (Collection $input, Models\Users $model) {
                $activationKey = md5(uniqid(rand(), true));
                $activationExpiredDate = date('Y-m-d H:i:s', time() + 172800); // 48 jam
                $registerSuccessMsg = 'Haayy <strong>'.$input['fullname'].'</strong>,<br> Submission keanggotan sudah berhasil disimpan. Akan tetapi account anda tidak langsung aktif. Demi keamanan dan validitas database, maka sistem telah mengirimkan email ke email anda, untuk melakukan aktivasi account. Segera check email anda! Terimakasih ^_^';

                $input['activation_key'] = $activationKey;
                $input['expired_date'] = $activationExpiredDate;
                $input['fullname'] = ucwords($input['fullname']);
                $input['password'] = $this->salt($input['password']);

                if ($userId = $model->create($input)) {
                    $address = $input->get('email');
                    $data = [
                        'user_id' => $userId,
                        'activation_key' => $activationKey
                    ];

                    $this->mail
                        ->to($address, $input['fullname'])
                        ->subject('PHP Indonesia - Aktivasi Membership')
                        ->send('email::activation', [
                            'email' => $address,
                            'fullname' => $input['fullname'],
                            'regDate' => date('d-m-Y H:i:s'),
                            'activationExp' => $activationExpiredDate,
                            'activationUrl' => $this->router->pathFor('membership-activation', $data),
                        ]);

                    // Update email sent status
                    (new Models\UsersActivations)->update(['email_sent' => 'Y'], $data);

                    $this->addFormAlert('success', $registerSuccessMsg);
                }
            });

            return $response->withRedirectRoute('membership-index');
        } catch (\Exception $e) {
            if ($e instanceof ValidatorException) {
                $this->addFormAlert('warning', $e->getMessage(), $e->getErrors());
            }

            $this->addFormAlert('error', 'System failed<br>'.$e->getMessage());

            return $response->withRedirectRoute('membership-register');
        }
    }

    public function logout(Request $request, Response $response, array $args)
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        $response->withRedirectRoute('membership-login');
    }
}
