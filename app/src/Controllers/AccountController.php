<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;
use Membership\Models\Users;
use Membership\Models\Careers;
use Membership\Models\Religions;
use Membership\Models\Regionals;
use Membership\Models\MemberProfile;
use Membership\Models\MemberSocmeds;
use Slim\Exception\NotFoundException;

class AccountController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Profil Anggota');

        /** @var Users $users */
        $users = $this->data(Users::class);

        return $this->view->render('account-index', [
            'member'            => $users->getProfile(),
            'member_portfolios' => $users->getPortfolios(),
            'member_skills'     => $users->getSkills(),
            'member_socmeds'    => $users->getSocmends(),
            'socmedias'         => $this->settings->get('socmedias'),
        ]);
    }

    public function profile(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Detail Anggota');

        /** @var Users $users */
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

        if (!$user) {
            throw new NotFoundException($request, $response);
        }

        if ($request->isXhr()) {
            return $response->withJson([
                'username' => $user['username'],
                'fullname' => $user['fullname'],
                'email'    => $user['email'],
                'gender'   => $user['gender'],
                'city'     => $user['city'],
                'province' => $user['province'],
            ]);
        }

        return $this->view->render('profile-index', [
            'member'            => $user,
            'member_portfolios' => $users->getPortfolios($user['user_id']),
            'member_skills'     => $users->getSkills($user['user_id']),
            'member_socmeds'    => $users->getSocmends($user['user_id']),
            'socmedias'         => $this->settings->get('socmedias'),
        ]);
    }

    public function editPage(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Update Profile Anggota');

        /** @var Users $users */
        $users = $this->data(Users::class);
        /** @var Regionals $regionals */
        $regionals = $this->data(Regionals::class);
        /** @var Religions $religion */
        $religions = $this->data(Religions::class);
        $provinceId = $this->session->get('province_id');

        return $this->view->render('account-edit', [
            'member'         => $users->getProfile(),
            'member_socmeds' => $users->getSocmends(),
            'religions'      => array_pairs($religions->get()->fetchAll(), 'religion_id', 'religion_name'),
            'provinces'      => array_pairs($regionals->getProvinces(), 'id', 'regional_name'),
            'cities'         => array_pairs($regionals->getCities($provinceId), 'id', 'regional_name'),
            'jobs'           => array_pairs($this->data(Careers::class)->getJobs(), 'job_id'),
            'genders'        => ['female' => 'Wanita', 'male' => 'Pria'],
            'identity_types' => ['ktp' => 'KTP', 'sim' => 'SIM', 'ktm' => 'Kartu Mahasiswa'],
            'socmedias'      => $this->settings->get('socmedias'),
        ]);
    }

    public function edit(Request $request, Response $response, array $args)
    {
        /** @var Users $users */
        $users = $this->data(Users::class);
        $user = $users->get(['email', 'username'], $this->session->get('user_id'))->fetch();
        $identityTypes = ['ktp' => 'KTP', 'sim' => 'SIM', 'ktm' => 'Kartu Mahasiswa'];
        $validator = $this->validator->rule('required', [
            'email',
            'username',
            'fullname',
            'province_id',
            'city_id',
            'area',
            'job_id',
        ]);

        $validator->addRule('assertEmailNotExists', function ($field, $value, array $params) use ($users, $user) {
            return $user['email'] == $value || !$users->assertEmailExists($value);
        }, 'tersebut sudah terdaftar!');

        $validator->addRule('assertUsernameNotExists', function ($field, $value, array $params) use ($users, $user) {
            return $user['username'] == $value || !$users->assertUsernameExists($value);
        }, 'tersebut sudah terdaftar!');

        $validator->rules([
            'regex' => [
                ['fullname', ':^[A-z\s]+$:'],
                ['username', ':^[A-z\d\-\.\_]+$:'],
                ['contact_phone', ':^[-\+\d]+$:'],
                ['identity_number', ':^[-\+\d]+$:'],
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
            'in' => [
                ['identity_type', array_keys($identityTypes)]
            ],
            'lengthMax' => [
                ['fullname', 32],
                ['username', 64],
                ['contact_phone', 16],
                ['area', 64],
                ['identity_number', 32],
                ['birth_place', 32],
            ],
            'lengthMin' => [
                ['username', 6],
                ['password', 6],
            ],
        ]);

        if ($validator->validate()) {
            $input = $request->getParsedBody();
            /** @var MemberProfile $profile */
            $profile = $this->data(MemberProfile::class);
            /** @var MemberSocmeds $socmeds */
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
                $userId = $this->session->get('user_id');

                if ($photo = $request->getUploadedFiles()['photo']) {
                    $memberProfile = $this->upload($photo, $memberProfile);
                }

                // Update profile data record
                $profile->update($memberProfile, ['user_id' => $userId]);

                $users->update([
                    'email'       => $input['email'],
                    'province_id' => $input['province_id'],
                    'city_id'     => $input['city_id'],
                    'area'        => $input['area'],
                ], ['user_id' => $userId]);

                // Handle social medias
                if ($input['socmeds']) {
                    $terms = [
                        'user_id' => $userId,
                        'deleted' => 'N',
                    ];

                    foreach ($input['socmeds'] as $item) {
                        $terms = [
                            'user_id' => $userId,
                            'deleted' => 'N',
                            'socmed_type' => $item['socmed_type'],
                        ];

                        $socmedRow = $socmeds->get(['account_name', 'account_url'], $terms)->fetch();

                        if ($socmedRow['account_name'] != $item['account_name']) {
                            $socmedRow['account_name'] = $item['account_name'];
                        }

                        if ($socmedRow['account_url'] != $item['account_url']) {
                            $socmedRow['account_url'] = $item['account_url'];
                        }

                        $socmeds->update($socmedRow, $terms);
                    }
                }

                if (isset($input['socmeds_delete'])) {
                    foreach ($input['socmeds_delete'] as $item) {
                        $socmeds->delete([
                            'user_id' => $userId,
                            'socmed_type' => $item
                        ]);
                    }
                }

                $this->db->commit();

                $this->addFormAlert('success', 'Profile information successfuly updated! Congratulation!');
            } catch (\PDOException $e) {
                $this->db->rollback();

                $this->addFormAlert('error', 'System failed<br>'.$e->getMessage());
            } catch (\Exception $e) {
                $this->db->rollback();

                $this->addFormAlert('error', 'System failed<br>'.$e->getMessage());
            }
        } else {
            $this->addFormAlert('warning', 'Some of mandatory fields is empty!', $validator->errors());

            return $response->withRedirect($this->router->pathFor('membership-account-edit', $args));
        }

        return $response->withRedirect($this->router->pathFor('membership-account'));
    }

    public function activate(Request $request, Response $response, array $args)
    {
        /** @var Users $users */
        $users = $this->data(Users::class);
        $actExistCount = $users->assertActivationExists($args['uid'], $args['activation_key']);

        if ($actExistCount === 1 && $users->activate($args['uid'], $args['activation_key'])) {
            $this->addFormAlert('success', 'Selamat! Account anda sudah aktif. Silahkan login...');
        } else {
            $this->addFormAlert('error', 'Bad Request');
        }

        return $response->withRedirect($this->router->pathFor('membership-login'));
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
        /** @var Users $users */
        $users = $this->data(Users::class);
        $validator = $this->validator->rule('required', 'email');

        $validator->addRule('assertNotEmailExists', function ($field, $value, array $params) use ($users) {
            return !$users->assertEmailExists($value);
        }, 'Email tersebut tidak terdaftar!');

        $validator->rule('assertNotEmailExists', 'email');

        if ($validator->validate()) {
            //
            $this->addFormAlert('error', 'Bad Request');
        } else {
            $this->addFormAlert('warning', 'Some of mandatory fields is empty!', $validator->errors());

            return $response->withRedirect($this->router->pathFor('membership-login'));
        }

        return $response->withRedirect($this->router->pathFor('membership-account-reactivate'));
    }

    public function javascript(Request $request, Response $response, array $args)
    {
        /** @var Users $users */
        $users = $this->data(Users::class);
        $cookie = $request->getCookieParams();
        $open_portfolio = false;
        $open_skill = false;
        $worker = ['KARYAWAN', 'FREELANCER', 'OWNER', 'MAHASISWA-KARYAWAN'];
        $student = ['PELAJAR', 'MAHASISWA'];

        if (in_array($this->session->get('job_id'), $worker)) {
            if (!isset($cookie['portfolio-popup'])) {
                $open_portfolio = $users->countPortfolios() === 0;
            }

            if (!isset($cookie['skill-popup'])) {
                $open_skill = $users->countSkills() === 0;
            }
        } elseif (in_array($this->session->get('job_id'), $student)) {
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
