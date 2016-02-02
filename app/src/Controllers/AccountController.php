<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;
use Membership\Models\Users;
use Membership\Models\Skills;
use Membership\Models\Careers;
use Membership\Models\Religions;
use Membership\Models\Regionals;
use Membership\Models\MemberProfile;
use Membership\Models\MemberSocmeds;

class AccountController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $users = $this->data(Users::class);

        $this->setPageTitle('Membership', 'Profil Anggota');

        return $this->view->render('account-index', [
            'member'            => $users->getProfile(),
            'member_portfolios' => $users->getPortfolios(),
            'member_skills'     => $users->getSkills(),
            'member_socmeds'    => $users->getSocmends(),
            'socmedias'         => $this->settings->get('socmedias'),
        ]);
    }

    public function editPage(Request $request, Response $response, array $args)
    {
        $users = $this->data(Users::class);
        $regionals = $this->data(Regionals::class);
        $religions = $this->data(Religions::class);

        $this->setPageTitle('Membership', 'Update Profile Anggota');

        return $this->view->render('account-edit', [
            'member'         => $users->getProfile(),
            'member_socmeds' => $users->getSocmends(),
            'religions'      => array_pairs($religions->get()->fetchAll(), 'religion_id', 'religion_name'),
            'provinces'      => array_pairs($regionals->getProvinces(), 'id', 'regional_name'),
            'cities'         => array_pairs($regionals->getCities($users->current('province_id')), 'id', 'regional_name'),
            'jobs'           => array_pairs($this->data(Careers::class)->getJobs(), 'job_id'),
            'genders'        => ['female' => 'Wanita', 'male' => 'Pria'],
            'identity_types' => ['ktp' => 'KTP', 'sim' => 'SIM', 'ktm' => 'Kartu Mahasiswa'],
            'socmedias'      => $this->settings->get('socmedias'),
        ]);
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $validator = $this->validator->rule('required', [
            'fullname',
            'email',
            'province_id',
            'city_id',
            'area',
            'job_id'
        ]);

        $validator->rule('email', 'email');

        if ($validator->validate()) {
            $input = $request->getParsedBody();
            $users = $this->data(Users::class);
            $profile = $this->data(MemberProfile::class);
            $socmeds = $this->data(MemberSocmeds::class);

            $memberProfile = [
                'fullname'        => $input['fullname'],
                'contact_phone'   => $input['contact_phone'],
                'birth_place'     => strtoupper($input['birth_place']),
                'birth_date'      => $input['birth_date'],
                'identity_number' => $input['identity_number'],
                'identity_type'   => $input['identity_type'],
                'religion_id'     => $input['religion_id'],
                'province_id'     => $input['province_id'],
                'city_id'         => $input['city_id'],
                'area'            => $input['area'],
                'job_id'          => $input['job_id']
            ];

            $this->db->beginTransaction();

            try {
                if ($file = $request->getUploadedFiles()) {
                    $this->upload($file['photo'], $memberProfile);
                }

                // Update profile data record
                $profile->update($memberProfile, ['user_id' => $users->current('user_id')]);

                $users->update([
                    'email'       => $input['email'],
                    'province_id' => $input['province_id'],
                    'city_id'     => $input['city_id'],
                    'area'        => $input['area'],
                ], ['user_id' => $users->current('user_id')]);

                // Handle social medias
                if ($input['socmeds']) {
                    foreach ($input['socmeds'] as $item) {
                        $row = [
                            'user_id'      => $users->current('user_id'),
                            'socmed_type'  => $item['socmed_type'],
                            'account_name' => $item['account_name'],
                            'account_url'  => $item['account_url'],
                        ];

                        if ($item['member_socmed_id'] == 0) {
                            $socmeds->create($row);
                        } else {
                            $socmeds->update($row, (int) $item['member_socmed_id']);
                        }
                    }
                }

                if (isset($input['socmeds_delete'])) {
                    foreach ($input['socmeds_delete'] as $item) {
                        $socmeds->delete([
                            'user_id' => $users->current('user_id'),
                            'socmed_type' => $item
                        ]);
                    }
                }

                $this->db->commit();

                $this->flash->addMessage('success', 'Profile information successfuly updated! Congratulation!');
            } catch (Exception $e) {
                $this->db->rollback();

                $this->flash->addMessage('error', 'System failed<br>'.$e->getMessage());
            }
        } else {
            $this->flash->addMessage('warning', 'Some of mandatory fields is empty!');
        }

        return $response->withRedirect(
            $this->router->pathFor('membership-account')
        );
    }

    public function updatePasswordPage(Request $request, Response $response, array $args)
    {
        $this->enableCaptcha();
        $this->setPageTitle('Membership', 'Update Password');

        return $this->view->render('account-update-password');
    }

    public function updatePassword(Request $request, Response $response, array $args)
    {
        $users     = $this->data(Users::class);
        $saltPass  = $this->settings->get('salt_pwd');
        $password  = $request->getParsedBodyParam('password');
        $validator = $this->validator->rule('required', [
            'oldpassword',
            'password',
            'repassword'
        ]);

        $validator->addNewRule('check_oldpassword', function ($field, $value, array $params) use ($users, $saltPass) {
            $password = md5($saltPass.$value);
            $countPass = $users->count(function ($query) use ($password) {
                $query->where('user_id', '=', $users->current())
                    ->where('password', '=', $password);
            });

            return $countPass > 0;
        }, 'Wrong! Please remember your old password');

        $validator->addNewRule('check_repassword', function ($field, $value, array $params) use ($password) {
            return $value == $password;
        }, 'Not match with choosen new password');

        $validator->rule('check_oldpassword', 'oldpassword');
        $validator->rule('check_repassword', 'repassword');

        if ($validator->validate()) {
            $users->update(
                ['password' => $this->salt($password)],
                $users->current()
            );

            $this->flash->addMessage('success', 'Password anda berhasil diubah! Selamat!');

            return $response->withRedirect(
                $this->router->pathFor('membership-profile', [
                    'username' => $users->current('username')
                ])
            );
        } else {
            $this->flash->addMessage('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
        }

        return $response->withRedirect($this->router->pathFor('membership-login'));
    }

    public function activate(Request $request, Response $response, array $args)
    {
        $users = $this->data(Users::class);
        $actExistCount = $users->assertActivationExists($args['uid'], $args['activation_key']);

        if ($actExistCount === 1 && $users->activate($args['uid'], $args['activation_key'])) {
            $this->flash->addMessage('success', 'Selamat! Account anda sudah aktif. Silahkan login...');
        } else {
            $this->flash->addMessage('error', 'Bad Request');
        }

        return $response->withRedirect(
            $this->router->pathFor('membership-login')
        );
    }

    public function reactivatePage(Request $request, Response $response, array $args)
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

        return $this->view->render('account-reactivate');
    }

    public function reactivate(Request $request, Response $response, array $args)
    {
        $users = $this->data(Users::class);
        $validator = $this->validator->rule('required', 'email');

        $validator->addNewRule('assertEmailExists', function ($field, $value, array $params) use ($users) {
            return !$users->assertEmailExists($value);
        }, 'Email tersebut tidak terdaftar!');

        $validator->rule('assertEmailExists', 'email');

        if ($validator->validate()) {
            //
            $this->flash->addMessage('error', 'Bad Request');
        } else {
            $this->flash->addMessage('warning', 'Some of mandatory fields is empty!');
        }

        return $response->withRedirect(
            $this->router->pathFor('membership-account-reactivate')
        );
    }

    public function javascript(Request $request, Response $response, array $args)
    {
        $users = $this->data(Users::class);
        $cookie = $request->getCookieParams();
        $open_portfolio = false;
        $open_skill = false;
        $worker = ['KARYAWAN', 'FREELANCER', 'OWNER', 'MAHASISWA-KARYAWAN'];
        $student = ['PELAJAR', 'MAHASISWA'];

        if (in_array($users->current('job_id'), $worker)) {

            if (!isset($cookie['portfolio-popup'])) {
                $open_portfolio = $users->countPortfolios() === 0;
            }

            if (!isset($cookie['skill-popup'])) {
                $open_skill = $users->countSkills() === 0;
            }

        } else if (in_array($users->current('job_id'), $student)) {

            if (!isset($cookie['skill-popup'])) {
                $open_skill = $users->countSkills() === 0;
            }

        }

        return $this->view->render('account-javascript', [
            'open_portfolio' => $open_portfolio,
            'open_skill'     => $open_skill
        ])->withHeader('Content-Type', 'application/javascript');
    }

    public function portfolioCookie(Request $request, Response $response, array $args)
    {
        $cookie = $request->getCookieParams();
        if (!isset($cookie['portfolio-popup'])) {
            setcookie('portfolio-popup', 1, $this->cookieTtl());
        }

        return $response->withJson(['resp' => 'OK']);
    }

    public function skillsCookie(Request $request, Response $response, array $args)
    {
        $cookie = $request->getCookieParams();
        if (!isset($cookie['skill-popup'])) {
            setcookie('skill-popup', 1, $this->cookieTtl());
        }

        return $response->withJson(['resp' => 'OK']);
    }

    private function cookieTtl()
    {
        return time() + 86400;
    }
}
