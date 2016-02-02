<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use ReCaptcha\ReCaptcha;
use Membership\Controllers;
use Membership\Models\Users;
use Membership\Models\Careers;
use Membership\Models\Regionals;

class HomeController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $regionals = $this->data(Regionals::class);
        $provinces = $cities = [];

        foreach ($regionals->getProvinces() as $prov) {
            $provinces[$prov['id']] = $prov['regional_name'];
        }

        if ($province_id = $request->getQueryParam('province_id')) {
            foreach ($regionals->getCities($province_id) as $city) {
                $cities[$city['id']] = $city['regional_name'];
            }
        }

        $members = $this->data(Users::class)->getMembers($request);
        $this->setPageTitle('Membership', 'Keanggotaan');

        return $this->view->render('home-index', compact('members', 'provinces', 'cities'));
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
            $errors = $validator->errors();
            $this->flash->addMessage('error', '<p>'.implode('</p><p>', array_flatten($errors)).'</p>');

            return $response->withRedirect(
                $this->router->pathFor('membership-login')
            );
        }

        try {
            $user = $users->authenticate($input['login'], $this->salt($input['password']));
        } catch (\InvalidArgumentException $e) {
            $this->flash->addMessage('error', $e->getMessage());

            return $response->withRedirect(
                $this->router->pathFor('membership-login')
            );
        }

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

        return $response->withRedirect(
            $this->router->pathFor('membership-account')
        );
    }

    public function registerPage(Request $request, Response $response, array $args)
    {
        $provinceId = $request->getParam('province_id');
        $regionals = $this->data(Regionals::class);

        $provinces = array_pairs($regionals->getProvinces(), 'id', 'regional_name');
        $cities = array_pairs($regionals->getCities($provinceId), 'id', 'regional_name');
        $jobs = array_pairs($this->data(Careers::class)->getJobs(), 'job_id');

        $this->view->addData([
            'helpTitle' => 'Bantuan Register?',
            'helpContent' => [
                'Sudah pernah terdaftar menjadi anggota PHP Indonesia, silahkan <a href="'.$this->router->pathFor('membership-login').'" title="">Login Disini',
                'Hilang atau lupa password login, silahkan <a href="'.$this->router->pathFor('membership-forgot-password').'" title="">Reset Password</a> Anda.'
            ],
        ], 'layouts::account');

        $this->enableCaptcha();
        $this->setPageTitle('Membership', 'Registrasi Anggota');

        return $this->view->render('home-register', compact('provinces', 'cities', 'jobs'));
    }

    public function register(Request $request, Response $response, array $args)
    {
        $users     = $this->data(Users::class);
        $password  = $request->getParsedBodyParam('password');
        $gcaptcha  = $this->settings->get('gcaptcha');
        $validator = $this->validator->rule('required', [
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
        ]);

        $validator->addNewRule('check_repassword', function ($field, $value, array $params) use ($password) {
            return $value == $password;
        }, 'Not match with choosen new password');

        $validator->addNewRule('assertEmailExists', function ($field, $value, array $params) use ($users) {
            return $users->assertEmailExists($value);
        }, 'Email tersebut sudah terdaftar!');

        $validator->addNewRule('assertUsernameExists', function ($field, $value, array $params) use ($users) {
            return $users->assertUsernameExists($value);
        }, 'Username tersebut sudah terdaftar!');

        if ($gcaptcha['enable'] == true) {
            $validator->addNewRule('verify_captcha', function ($field, $value, array $params) use ($gcaptcha) {
                $result = false;
                if (isset($input['g-recaptcha-response'])) {
                    $recaptcha = new ReCaptcha($gcaptcha['secret']);
                    $resp = $recaptcha->verify($input['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
                    $result = $resp->isSuccess();
                }

                return $result;

            }, 'Tidak tepat!');

            $validator->rule('verify_captcha', 'captcha');
        }

        $validator->rule('email', 'email');
        $validator->rule('check_repassword', 'repassword');
        $validator->rule('assertEmailExists', 'email');
        $validator->rule('assertUsernameExists', 'username');

        if ($validator->validate()) {
            $input = $request->getParsedBody();
            $input['fullname'] = ucwords($input['fullname']);

            $last_user_id = null;
            $activation_key = md5(uniqid(rand(), true));
            $activation_expired_date = date('Y-m-d H:i:s', time() + 172800); // 48 jam

            $register_success_msg = 'Haayy <strong>'.$input['fullname'].'</strong>,<br /> Submission keanggotan sudah berhasil disimpan. Akan tetapi account anda tidak langsung aktif. Demi keamanan dan validitas data, maka sistem telah mengirimkan email ke email anda, untuk melakukan aktivasi account. Segera check email anda! Terimakasih ^_^';
            $register_success_msg_alt = 'Haayy <strong>'.$input['fullname'].'</strong>,<br /> Submission keanggotan sudah berhasil disimpan. Akan tetapi account anda tidak langsung aktif. Demi keamanan dan validitas data, maka sistem telah mengirimkan email ke email anda, untuk melakukan aktivasi account. Segera check email anda! Terimakasih ^_^<br /><br /><strong>Kemungkinan email akan sampai agak terlambat, karena email server kami sedang mengalami sedikit kendala teknis. Jika anda belum juga mendapatkan email, maka jangan ragu untuk laporkan kepada kami melalu email: report@phpindonesia.or.id</strong>';

            $success = false;

            try {
                $success = $users->create([
                    'username'       => $input['username'],
                    'password'       => $this->salt($input['password']),
                    'email'          => $input['email'],
                    'fullname'       => $input['fullname'],
                    'gender'         => $input['gender_id'],
                    'province_id'    => $input['province_id'],
                    'city_id'        => $input['city_id'],
                    'area'           => $input['area'],
                    'job_id'         => $input['job_id'],
                    'activation_key' => $activation_key,
                    'expired_date'   => $activation_expired_date,
                ]);
            } catch (Exception $e) {
                $this->db->rollback();

                $this->flash->addMessage('error', 'System gagal!<br />'.$e->getMessage());
            }

            // Sending activation email handler //
            if ($success) {
                try {
                    $replacements = [];
                    $replacements[$input['email']] = array(
                        '{email_address}' => $input['email'],
                        '{fullname}' => filter_var(trim($input['fullname']), FILTER_SANITIZE_STRING),
                        '{registration_date}' => date('d-m-Y H:i:s'),
                        '{activation_path}' => $this->router->pathFor('membership-activation', array('uid' => $success, 'activation_key' => $activation_key)),
                        '{activation_expired_date}' => $activation_expired_date,
                        '{base_url}' => $request->getUri()->getBaseUrl()
                    );

                    $message = Swift_Message::newInstance('PHP Indonesia - Aktivasi Membership')
                        ->setFrom(array($this->settings->get('email')['sender_email'] => $this->settings->get('email')['sender_name']))
                        ->setTo(array($input['email'] => $input['fullname']))
                        ->setBody(file_get_contents(APP_DIR.'protected'._DS_.'views'._DS_.'email'._DS_.'activation.txt'));

                    $mailer = $this->get('mailer');
                    $mailer->registerPlugin(new Swift_Plugins_DecoratorPlugin($replacements));
                    $mailer->send($message);

                    // Update email sent status
                    $this->db->update('users_activations', array('email_sent' => 'Y'), array(
                        'user_id' => $success,
                        'activation_key' => $activation_key
                    ));


                    $this->flash->addMessage('success', $register_success_msg);
                } catch (Swift_TransportException $e) {
                    $this->flash->addMessage('success', $register_success_msg_alt);
                }
            }
        } else {
            $this->flash->addMessage('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
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

        return $response->withRedirect(
            $this->router->pathFor('membership-login')
        );
    }
}
