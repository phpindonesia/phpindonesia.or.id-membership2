<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;
use Membership\Models\Users;
use Membership\Models\Careers;
use Membership\Models\Regionals;
use Membership\Models\UsersActivations;

class HomeController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Keanggotaan');

        $regionals  = $this->data(Regionals::class);
        $provinceId = $request->getQueryParam('province_id');

        return $this->view->render('home-index', [
            'members'   => $this->data(Users::class)->getMembers($request),
            'provinces' => array_pairs($regionals->getProvinces(), 'id', 'regional_name'),
            'cities'    => array_pairs($regionals->getCities($provinceId), 'id', 'regional_name'),
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
        ], 'layouts::account');

        return $this->view->render('home-login');
    }

    public function login(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();
        $users = $this->data(Users::class);
        $validator = $this->validator->rule('required', ['login', 'password']);

        if (filter_var($input['login'], FILTER_VALIDATE_EMAIL)) {
            $validator->rule('email', [$input['login']]);
        }

        if (!$validator->validate()) {
            $this->flash->addMessage('warning', 'Some of mandatory fields is empty!');
            $this->flashValidationErrors($validator->errors());

            return $response->withRedirect($this->router->pathFor('membership-login'));
        }

        try {
            $user = $users->authenticate($input['login'], $this->salt($input['password']));
        } catch (\InvalidArgumentException $e) {
            $this->flash->addMessage('error', $e->getMessage());

            return $response->withRedirect($this->router->pathFor('membership-login'));
        }

        if ($user) {
            $_SESSION['MembershipAuth'] = [
                'user_id'     => $user['user_id'],
                'username'    => $user['username'],
                'role_id'     => $user['role_id'],
                'email'       => $user['email'],
                'province_id' => $user['province_id'],
                'city_id'     => $user['city_id'],
                'photo'       => $user['photo'],
                'fullname'    => $user['fullname'],
                'job_id'      => $user['job_id'],
            ];
            $this->session->replace($_SESSION['MembershipAuth']);

            $users->updateLogin($user['user_id']);
        }

        return $response->withRedirect($this->router->pathFor('membership-account'));
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
        ], 'layouts::account');

        $regionals = $this->data(Regionals::class);
        $provinceId = $request->getParam('province_id');

        return $this->view->render('home-register', [
            'provinces' => array_pairs($regionals->getProvinces(), 'id', 'regional_name'),
            'cities'    => array_pairs($regionals->getCities($provinceId), 'id', 'regional_name'),
            'jobs'      => array_pairs($this->data(Careers::class)->getJobs(), 'job_id'),
        ]);
    }

    public function register(Request $request, Response $response, array $args)
    {
        $users = $this->data(Users::class);
        $input = $request->getParsedBody();
        $validator = $this->validator->rule('required', [
            'email',
            'username',
            'password',
            'repassword',
            'fullname',
            'gender_id',
            'province_id',
            // 'city_id',
            'area',
            'job_id',
        ]);

        $validator->addRule('assertEmailNotExists', function ($field, $value, array $params) use ($users) {
            return !$users->assertEmailExists($value);
        }, 'tersebut sudah terdaftar!');

        $validator->addRule('assertUsernameNotExists', function ($field, $value, array $params) use ($users) {
            return !$users->assertUsernameExists($value);
        }, 'tersebut sudah terdaftar!');

        $validator->rules([
            'regex' => [
                ['fullname', ':^[A-z\s]+$:'],
                ['username', ':^[A-z\d\-\.\_]+$:'],
            ],
            'email' => 'email',
            'assertEmailNotExists' => 'email',
            'assertUsernameNotExists' => 'username',
            'dateFormat' => [
                ['birth_date', 'Y-m-d']
            ],
            'equals' => [
                ['repassword', 'password']
            ],
            'lengthMax' => [
                ['username', 32],
                ['fullname', 64],
                ['area', 64],
            ],
            'lengthMin' => [
                ['username', 6],
                ['password', 6],
            ],
        ]);

        if ($validator->validate()) {
            $emailAddress = $input['email'];
            $activationKey = md5(uniqid(rand(), true));
            $activationExpiredDate = date('Y-m-d H:i:s', time() + 172800); // 48 jam
            $registerSuccessMsg = 'Haayy <strong>'.$input['fullname'].'</strong>,<br> Submission keanggotan sudah berhasil disimpan. Akan tetapi account anda tidak langsung aktif. Demi keamanan dan validitas data, maka sistem telah mengirimkan email ke email anda, untuk melakukan aktivasi account. Segera check email anda! Terimakasih ^_^';

            try {
                $input['activation_key'] = $activationKey;
                $input['expired_date'] = $activationExpiredDate;
                $input['fullname'] = ucwords($input['fullname']);
                $input['password'] = $this->salt($input['password']);

                if ($userId = $users->create($input)) {
                    $emailSettings = $this->settings->get('email');
                    $message = \Swift_Message::newInstance('PHP Indonesia - Aktivasi Membership')
                        ->setFrom([$emailSettings['sender_email'] => $emailSettings['sender_name']])
                        ->setTo([$emailAddress => $member['fullname']])
                        ->setBody(file_get_contents(APP_DIR.'views'._DS_.'email'._DS_.'activation.txt'));

                    $this->mailer->registerPlugin(new \Swift_Plugins_DecoratorPlugin([
                        $emailAddress  => [
                            '{email_address}' => $emailAddress,
                            '{fullname}' => $input['fullname'],
                            '{registration_date}' => date('d-m-Y H:i:s'),
                            '{activation_path}' => $this->router->pathFor('membership-activation', ['uid' => $userId, 'activation_key' => $activationKey]),
                            '{activation_expired_date}' => $activationExpiredDate,
                            '{base_url}' => $request->getUri()->getBaseUrl()
                        ]
                    ]));

                    $this->mailer->send($message);

                    // Update email sent status
                    $this->data(UsersActivations::class)->update(['email_sent' => 'Y'], [
                        'user_id' => $userId,
                        'activation_key' => $activationKey
                    ]);
                }
            } catch (\Swift_TransportException $e) {
                $registerSuccessMsg .= '<br><br><strong>Kemungkinan email akan sampai agak terlambat, karena email server kami sedang mengalami sedikit kendala teknis. Jika anda belum juga mendapatkan email, maka jangan ragu untuk laporkan kepada kami melalu email: report@phpindonesia.or.id</strong>';
            } catch (\PDOException $e) {
                $this->flash->addMessage('error', 'System failed<br>'.$e->getMessage());

                return $response->withRedirect($this->router->pathFor('membership-register'));
            }

            $this->flash->addMessage('success', $registerSuccessMsg);
        } else {
            $this->flash->addMessage('warning', 'Some of mandatory fields is empty!');
            $this->flashValidationErrors($validator->errors());

            return $response->withRedirect($this->router->pathFor('membership-register'));
        }

        return $response->withRedirect($this->router->pathFor('membership-index'));
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

        return $response->withRedirect($this->router->pathFor('membership-login'));
    }
}
