<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Exception\NotFoundException;
use Membership\Controllers;
use Membership\Models;

class AccountController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Profil Anggota');

        /** @var \Membership\Models\Users $users */
        $users = $this->data(Models\Users::class);

        if ($request->isXhr()) {
            $outputJson = $this->normalizeUserJsonOutput($users);

            return $response->withJson($outputJson);
        }

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

        /** @var \Membership\Models\Users $users */
        $users = $this->data(Models\Users::class);
        $user = $users->getProfileUsername($args['username']);

        if (!$user) {
            throw new NotFoundException($request, $response);
        }

        if ($request->isXhr()) {
            $outputJson = [
                'username' => $user['username'],
                'fullname' => $user['fullname'],
                'email'    => $user['email'],
                'gender'   => $user['gender'],
                'city'     => $user['city'],
                'province' => $user['province'],
            ];

            return $response->withJson($outputJson);
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

        /** @var \Membership\Models\Users $users */
        $users = $this->data(Models\Users::class);
        /** @var \Membership\Models\Regionals $regionals */
        $regionals = $this->data(Models\Regionals::class);
        /** @var \Membership\Models\Religions $religion */
        $religions = $this->data(Models\Religions::class);
        $provinceId = $users->getProfile()['province_id'];

        return $this->view->render('account-edit', [
            'member'         => $users->getProfile(),
            'member_socmeds' => $users->getSocmends(),
            'religions'      => array_pairs($religions->get()->fetchAll(), 'religion_id', 'religion_name'),
            'provinces'      => array_pairs($regionals->getProvinces(), 'id', 'regional_name'),
            'cities'         => array_pairs($regionals->getCities($provinceId), 'id', 'regional_name'),
            'jobs'           => array_pairs($this->data(Models\Careers::class)->getJobs(), 'job_id'),
            'genders'        => ['female' => 'Wanita', 'male' => 'Pria'],
            'identity_types' => ['ktp' => 'KTP', 'sim' => 'SIM', 'ktm' => 'Kartu Mahasiswa'],
            'socmedias'      => $this->settings->get('socmedias'),
        ]);
    }

    public function edit(Request $request, Response $response, array $args)
    {
        /** @var \Membership\Models\Users $users */
        $users = $this->data(Models\Users::class);
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
             $protected = [
                'admin',
                'account', 'login', 'register', 'logout',
                'activate', 'reactivate', 'regionals',
                'forgot-password', 'reset-password'
            ];
            return $user['username'] == $value || (!in_array($value, $protected) && !$users->assertUsernameExists($value));
        }, 'tersebut sudah terdaftar!');

        $validator->rules([
            'regex' => [
                ['fullname', ':^[A-z\s]+$:'],
                ['username', ':^[A-z\d\-\.\_]+$:'],
                ['contact_phone', ':^[-\+\d]+$:'],
                ['identity_number', ':^[^\W_]+$:'],
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
            /** @var \Membership\Models\MemberProfile $profile */
            $profile = $this->data(Models\MemberProfile::class);
            /** @var \Membership\Models\MemberSocmeds $socmeds */
            $socmeds = $this->data(Models\MemberSocmeds::class);

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
                    'username'    => $input['username'],
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

                        if ($socmedRow) {
                            if ($socmedRow['account_name'] != $item['account_name']) {
                                $socmedRow['account_name'] = $item['account_name'];
                            }

                            if ($socmedRow['account_url'] != $item['account_url']) {
                                $socmedRow['account_url'] = $item['account_url'];
                            }

                            $socmeds->update($socmedRow, $terms);
                        } else {

                            $termsStatus = [
                                'user_id' => $userId,
                                'socmed_type' => $item['socmed_type'],
                                'deleted' => 'Y',
                            ];

                            $socmedAdd = [
                                'user_id'      => $userId,
                                'socmed_type'  => $item['socmed_type'],
                                'account_name' => $item['account_name'],
                                'account_url'  => $item['account_url'],
                            ];

                            $socmedId = $socmeds->get(['member_socmed_id'], $termsStatus)->fetch();

                            if ($socmedId) {
                                $socmedAdd['deleted'] = 'N';
                                $socmeds->update($socmedAdd, $termsStatus);
                            } else {
                                $socmeds->create($socmedAdd);
                            }
                        }
                    }
                }

                if (isset($input['socmeds_delete'])) {
                    foreach ($input['socmeds_delete'] as $item) {
                        $terms = [
                            'user_id' => $userId,
                            'deleted' => 'N',
                            'socmed_type' => $item,
                        ];

                        $socmedRow = $socmeds->get(['user_id'], $terms)->fetch();

                        if ($socmedRow) {
                            $socmeds->delete([
                                'user_id' => $userId,
                                'socmed_type' => $item
                            ]);
                        }
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
        /** @var \Membership\Models\Users $users */
        $activation = $this->data(Models\UsersActivations::class);

        if ($activation->isExists($args['uid'], $args['activation_key']) &&
            $activation->activate($args['uid'], $args['activation_key'])
        ) {
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
        /** @var \Membership\Models\Users $users */
        $users = $this->data(Models\Users::class);
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
        /** @var \Membership\Models\Users $users */
        $users = $this->data(Models\Users::class);
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

    private function normalizeUserJsonOutput(Users $users, $userId = null)
    {
        $user = $users->getProfile($userId);

        $output = [
            'id' => $user['user_id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'fullname' => $user['fullname'],
            'phone' => $user['contact_phone'],
            'photo' => $user['photo'],
            'birthPlace' => $user['birth_place'],
            'birthDate' => $user['birth_date'],
            'identityType' => $user['identity_type'],
            'identityNumber' => $user['identity_number'],
            'gender' => $user['gender'],
            'religion' => $user['religion_name'],
            'area' => $user['area'],
            'city' => $user['city'],
            'province' => $user['province'],
            'portfolios' => [],
            'skills' => [],
            'socmeds' => [],
        ];

        foreach ($users->getPortfolios($user['user_id']) as $i => $portfolio) {
            $output['portfolios'][$i] = [
                'id' => $portfolio['member_portfolio_id'],
                'companyName' => $portfolio['company_name'],
                'industryName' => $portfolio['industry_name'],
                'workStatus' => $portfolio['work_status'],
                'jobTitle' => $portfolio['job_title'],
                'jobDesc' => $portfolio['job_desc'],
            ];
        }

        foreach ($users->getSkills($user['user_id']) as $i => $skill) {
            $output['skills'][$i] = [
                'id' => $skill['member_skill_id'],
                'name' => $skill['skill_name'],
                'parent' => $skill['skill_parent_name'],
                'assesment' => $skill['skill_self_assesment'],
            ];
        }

        foreach ($users->getSocmends($user['user_id']) as $i => $socmend) {
            $output['socmeds'][$i] = [
                'type' => $socmend['socmed_type'],
                'name' => $socmend['account_name'],
                'url' => $socmend['account_url'],
            ];
        }

        return $output;
    }
}
