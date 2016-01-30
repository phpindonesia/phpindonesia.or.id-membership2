<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;
use Membership\Models\Jobs;
use Membership\Models\Users;
use Membership\Models\Regionals;

class HomeController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $members = Users::factory($this->db)->getMembers($request);
        $provinces = $cities = [];

        foreach (Regionals::factory($this->db)->getProvinces() as $prov) {
            $provinces[$prov['id']] = $prov['regional_name'];
        }

        if ($province_id = $request->getQueryParam('province_id')) {
            foreach (Regionals::factory($this->db)->getCities($province_id) as $city) {
                $cities[$city['id']] = $prov['regional_name'];
            }
        }

        $this->setPageTitle('Membership', 'Keanggotaan');

        return $this->view->render('home-index', compact('members','provinces', 'cities'));
    }

    public function loginPage(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Login Anggota');

        $this->view->addData([
            'helpTitle' => 'Bantuan Login?',
            'helpContent' => [
                'Jika belum terdaftar sebagai anggota, <a href="'.$this->router->pathFor('membership-register').'" title="">Daftar Disini</a> menjadi anggota PHP Indonesia.',
                'Hilang atau lupa password login, silahkan <a href="'.$this->router->pathFor('membership-password-forgot').'" title="">Reset Password</a> Anda.'
            ],
        ], 'layouts::account');

        return $this->view->render('home-login');
    }

    public function login(Request $request, Response $response, array $args)
    {
        $post = $request->getParsedBody();
        $validator = $this->validator->rule('required', ['login', 'password']);

        if (filter_var($post['login'], FILTER_VALIDATE_EMAIL)) {
            $validator->rule('email', [$post['login']]);
        }

        if (!$validator->validate()) {
            $errors = $validator->errors();
            $this->flash->addMessage('error', '<p>'.implode('</p><p>', $this->arrayFlattenValues($errors)).'</p>');

            return $response->withRedirect(
                $this->router->pathFor('membership-login')
            );
        }

        try {
            $password = md5($this->settings['salt_pwd'].$post['password']);
            $user = Users::factory($this->db)->authenticate($post['login'], $password);
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

        $this->db->update(['last_login' => date('Y-m-d H:i:s')])
            ->table('users')
            ->where('user_id', '=', $user['user_id']);

        return $response->withRedirect(
            $this->router->pathFor('membership-account')
        );
    }

    public function registerPage(Request $request, Response $response, array $args)
    {
        $qProvinces = Regionals::factory($this->db)->getProvinces();
        $qJobs = Jobs::factory($this->db)->getIds();

        $cities = [];
        if ($provinceId = $request->getParam('province_id')) {
            $qCities = Regionals::factory($this->db)->getCities($provinceId);
            $cities = $this->arrayPairs($qCities, 'id', 'regional_name');
        }

        $provinces = $this->arrayPairs($qProvinces, 'id', 'regional_name');
        $jobs = $this->arrayPairs($qJobs, 'job_id');

        $this->view->addData([
            'helpTitle' => 'Bantuan Register?',
            'helpContent' => [
                'Sudah pernah terdaftar menjadi anggota PHP Indonesia, silahkan <a href="'.$this->router->pathFor('membership-login').'" title="">Login Disini',
                'Hilang atau lupa password login, silahkan <a href="'.$this->router->pathFor('membership-password-forgot').'" title="">Reset Password</a> Anda.'
            ],
        ], 'layouts::account');

        $this->enableCaptcha();
        $this->setPageTitle('Membership', 'Registrasi Anggota');

        return $this->view->render('home-register', compact('provinces', 'cities', 'jobs'));
    }

    public function register(Request $request, Response $response, array $args)
    {
        $gcaptchaSitekey = $this->settings['gcaptcha']['site_key'];
        $gcaptchaSecret = $this->settings['gcaptcha']['secret'];
        $gcaptchaEnable = $this->settings['gcaptcha']['enable'];

        $validator = $this->validator;
        $validator->createInput($_POST);
        $validator->rule('required', [
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

        if ($gcaptchaEnable == true) {
            $validator->addNewRule('verify_captcha', function ($field, $value, array $params) use ($gcaptchaSecret) {
                $result = false;
                if (isset($post['g-recaptcha-response'])) {
                    $recaptcha = new \ReCaptcha\ReCaptcha($gcaptchaSecret);
                    $resp = $recaptcha->verify($post['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
                    $result = $resp->isSuccess();
                }

                return $result;

            }, 'Tidak tepat!');
        }

        $validator->addNewRule('check_repassword', function ($field, $value, array $params) {
            if ($value != $post['password']) {
                return false;
            }

            return true;

        }, 'Not match with current password');

        $validator->addNewRule('check_email_exist', function ($field, $value, array $params) use ($db) {
            $q_email_count = $this->db
                ->select('COUNT(*) AS total_data')
                ->from('users')
                ->where('email = :email')
                ->where('deleted = :d')
                ->setParameter(':email', trim(strtolower($post['email'])))
                ->setParameter(':d', 'N')
                ->execute();

            $email_count = (int) $q_email_count->fetch()['total_data'];
            $this->db->close();

            if ($email_count > 0) {
                return false;
            }

            return true;

        }, 'Already exist');

        $validator->addNewRule('check_username_exist', function ($field, $value, array $params) use ($db) {
            $q_username_count = $this->db
                ->select('COUNT(*) AS total_data')
                ->from('users')
                ->where('username = :uname')
                ->where('deleted = :d')
                ->setParameter(':uname', trim(strtolower($post['username'])))
                ->setParameter(':d', 'N')
                ->execute();

            $username_count = (int) $q_username_count->fetch()['total_data'];
            $this->db->close();

            if ($username_count > 0) {
                return false;
            }

            return true;

        }, 'Already exist');

        $validator->rule('email', 'email');
        $validator->rule('check_repassword', 'repassword');
        $validator->rule('check_email_exist', 'email');
        $validator->rule('check_username_exist', 'username');

        if ($gcaptchaEnable == true) {
            $validator->rule('verify_captcha', 'captcha');
        }

        if ($validator->validate()) {
            $salt_pwd = md5($this->settings['salt_pwd'].$post['password']);
            $area = trim($post['area']);
            $area = empty($area) ? null : $area;
            $fullname = ucwords(trim($post['fullname']));
            $email_address = trim($post['email']);

            $last_user_id = null;
            $activation_key = md5(uniqid(rand(), true));
            $activation_expired_date = date('Y-m-d H:i:s', time() + 172800); // 48 jam

            $register_success_msg = 'Haayy <strong>'.$fullname.'</strong>,<br /> Submission keanggotan sudah berhasil disimpan. Akan tetapi account anda tidak langsung aktif. Demi keamanan dan validitas data, maka sistem telah mengirimkan email ke email anda, untuk melakukan aktivasi account. Segera check email anda! Terimakasih ^_^';
            $register_success_msg_alt = 'Haayy <strong>'.$fullname.'</strong>,<br /> Submission keanggotan sudah berhasil disimpan. Akan tetapi account anda tidak langsung aktif. Demi keamanan dan validitas data, maka sistem telah mengirimkan email ke email anda, untuk melakukan aktivasi account. Segera check email anda! Terimakasih ^_^<br /><br /><strong>Kemungkinan email akan sampai agak terlambat, karena email server kami sedang mengalami sedikit kendala teknis. Jika anda belum juga mendapatkan email, maka jangan ragu untuk laporkan kepada kami melalu email: report@phpindonesia.or.id</strong>';

            $trx_success = false;
            $this->db->beginTransaction();

            try {
                $this->db->insert('users', [
                    'username' => filter_var(trim($post['username']), FILTER_SANITIZE_STRING),
                    'password' => $salt_pwd,
                    'email' => $email_address,
                    'province_id' => $post['province_id'],
                    'city_id' => $post['city_id'],
                    'area' => $area,
                    'created' => date('Y-m-d H:i:s'),
                    'created_by' => 0
                ]);

                $last_user_id = $this->db->lastInsertId();

                $this->db->insert('users_roles', [
                    'user_id' => $last_user_id,
                    'role_id' => 'member',
                    'created' => date('Y-m-d H:i:s'),
                    'created_by' => 0
                ]);

                $this->db->insert('members_profiles', [
                    'user_id' => $last_user_id,
                    'fullname' => $fullname,
                    'gender' => $post['gender_id'],
                    'province_id' => $post['province_id'],
                    'city_id' => $post['city_id'],
                    'area' => $area,
                    'job_id' => $post['job_id'],
                    'created' => date('Y-m-d H:i:s'),
                    'created_by' => 0
                ]);

                $this->db->insert('users_activations', [
                    'user_id' => $last_user_id,
                    'activation_key' => $activation_key,
                    'expired_date' => $activation_expired_date,
                    'created' => date('Y-m-d H:i:s'),
                    'deleted' => 'N'
                ]);

                $this->db->commit();
                $this->db->close();
                $trx_success = true;

            } catch (Exception $e) {
                $this->db->rollback();
                $this->db->close();
                $trx_success = false;

                $this->flash->addMessage('error', 'System gagal!<br />'.$e->getMessage());
            }

            // Sending activation email handler //
            if ($trx_success) {
                try {
                    $replacements = [];
                    $replacements[$email_address] = array(
                        '{email_address}' => $email_address,
                        '{fullname}' => filter_var(trim($fullname), FILTER_SANITIZE_STRING),
                        '{registration_date}' => date('d-m-Y H:i:s'),
                        '{activation_path}' => $this->router->pathFor('membership-activation', array('uid' => $last_user_id, 'activation_key' => $activation_key)),
                        '{activation_expired_date}' => $activation_expired_date,
                        '{base_url}' => $request->getUri()->getBaseUrl()
                    );

                    $message = Swift_Message::newInstance('PHP Indonesia - Aktivasi Membership')
                        ->setFrom(array($this->settings['email']['sender_email'] => $this->settings['email']['sender_name']))
                        ->setTo(array($email_address => $fullname))
                        ->setBody(file_get_contents(APP_DIR.'protected'._DS_.'views'._DS_.'email'._DS_.'activation.txt'));

                    $mailer = $this->get('mailer');
                    $mailer->registerPlugin(new Swift_Plugins_DecoratorPlugin($replacements));
                    $mailer->send($message);

                    // Update email sent status
                    $this->db->update('users_activations', array('email_sent' => 'Y'), array(
                        'user_id' => $last_user_id,
                        'activation_key' => $activation_key
                    ));

                    $this->db->close();

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
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        return $response->withRedirect(
            $this->router->pathFor('membership-login')
        );
    }
}
