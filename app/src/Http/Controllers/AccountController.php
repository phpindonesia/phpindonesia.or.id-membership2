<?php

namespace Membership\Http\Controllers;

use Membership\Collection;
use Membership\Http\Request;
use Membership\Http\Response;
use Membership\Http\ValidatorException;
use Slim\Exception\NotFoundException;
use Membership\Http\Controllers;
use Membership\Models;

class AccountController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Profil Anggota');

        $users = new Models\Users;

        if ($request->isXhr()) {
            return $response->withJson(
                $this->normalizeUserJsonOutput($users)
            );
        }

        return $response->view('account-index', [
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

        $users = new Models\Users;

        if (! $user = $users->getProfileUsername($args['username'])) {
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

        return $response->view('profile-index', [
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

        $users = new Models\Users;
        $regionals = new Models\Regionals;
        $religions = new Models\Religions;
        $provinceId = $users->getProfile()['province_id'];

        return $response->view('account-edit', [
            'member'         => $users->getProfile(),
            'member_socmeds' => $users->getSocmends(),
            'religions'      => array_pairs($religions->get()->fetchAll(), 'religion_id', 'religion_name'),
            'provinces'      => array_pairs($regionals->getProvinces(), 'id', 'regional_name'),
            'cities'         => array_pairs($regionals->getCities($provinceId), 'id', 'regional_name'),
            'jobs'           => array_pairs((new Models\Careers)->getJobs(), 'job_id'),
            'genders'        => Models\Users::GENDERS,
            'identity_types' => Models\Users::IDENTITY_TYPES,
            'socmedias'      => $this->settings->get('socmedias'),
        ]);
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $request->rules('required', ['email', 'username', 'fullname', 'province_id', 'city_id', 'area', 'job_id']);

        try {
            $request->validate(new Models\Users, function (Collection $input, Models\Users $users) use ($request) {
                $this->db->transaction(function () use ($request, $users, $input) {
                    $userId = $this->session->get('user_id');

                    $users->update([
                        'email'       => $input['email'],
                        'username'    => $input['username'],
                        'province_id' => $input['province_id'],
                        'city_id'     => $input['city_id'],
                        'area'        => $input['area'],
                    ], ['user_id' => $userId]);

                    $memberProfile = [
                        'fullname' => $input['fullname'],
                        'contact_phone' => $input['contact_phone'],
                        'birth_place' => $input['birth_place'],
                        'birth_date' => $input['birth_date'],
                        'identity_number' => $input['identity_number'],
                        'identity_type' => $input['identity_type'],
                        'religion_id' => $input['religion_id'],
                        'province_id' => $input['province_id'],
                        'city_id' => $input['city_id'],
                        'area' => $input['area'],
                        'job_id' => $input['job_id']
                    ];

                    if ($photo = $request->getUploadedFiles()['photo']) {
                        $memberProfile = $this->upload($photo, $memberProfile);
                    }

                    // Update profile database record
                    (new Models\MemberProfile)->update($memberProfile, ['user_id' => $userId]);

                    $socmeds = new Models\MemberSocmeds;

                    // Handle social medias
                    if ($input['socmeds']) {
                        $terms = ['user_id' => $userId, 'deleted' => 'N'];

                        foreach ($input['socmeds'] as $item) {
                            $terms['socmed_type'] = $item['socmed_type'];

                            if ($socmedRow = $socmeds->get(['account_name', 'account_url'], $terms)->fetch()) {
                                if ($socmedRow['account_name'] != $item['account_name']) {
                                    $socmedRow['account_name'] = $item['account_name'];
                                }

                                if ($socmedRow['account_url'] != $item['account_url']) {
                                    $socmedRow['account_url'] = $item['account_url'];
                                }

                                $socmeds->update($socmedRow, $terms);
                            } else {
                                $terms['deleted'] = 'Y';

                                $socmedAdd = [
                                    'user_id'      => $userId,
                                    'socmed_type'  => $item['socmed_type'],
                                    'account_name' => $item['account_name'],
                                    'account_url'  => $item['account_url'],
                                ];

                                $socmedId = $socmeds->get(['member_socmed_id'], $terms)->fetch();

                                if ($socmedId) {
                                    $socmedAdd['deleted'] = 'N';
                                    $socmeds->update($socmedAdd, $terms);
                                } else {
                                    $socmeds->create($socmedAdd);
                                }
                            }
                        }
                    }

                    if (isset($input['socmeds_delete'])) {
                        foreach ($input['socmeds_delete'] as $item) {
                            $socmeds->delete(['user_id' => $userId, 'socmed_type' => $item]);
                        }
                    }
                });
            });
        } catch (\Throwable $e) {
            if ($e instanceof ValidatorException) {
                $this->addFormAlert('warning', 'Some of mandatory fields is empty!', $e->getErrors());
            }

            $this->addFormAlert('error', 'System failed<br>'.$e->getMessage());

            return $response->withRedirect($this->router->pathFor('membership-account-edit', $args));
        }

        return $response->withRedirect($this->router->pathFor('membership-account'));
    }

    public function activate(Request $request, Response $response, array $args)
    {
        $activation = new Models\UsersActivations;

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
        ], 'layout::account');

        return $response->view('account-reactivate');
    }

    public function reactivate(Request $request, Response $response, array $args)
    {
        $users = new Models\Users;
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
        $users = new Models\Users;
        $cookie = $request->getCookieParams();
        $open_portfolio = false;
        $open_skill = false;

        if (in_array($this->session->get('job_id'), Models\Careers::WORKER_TYPES)) {
            if (!isset($cookie['portfolio-popup'])) {
                $open_portfolio = $users->countPortfolios() === 0;
            }

            if (!isset($cookie['skill-popup'])) {
                $open_skill = $users->countSkills() === 0;
            }
        } elseif (in_array($this->session->get('job_id'), Models\Careers::STUDENT_TYPES)) {
            if (!isset($cookie['skill-popup'])) {
                $open_skill = $users->countSkills() === 0;
            }
        }

        return $response->view('account-javascript', [
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

    private function normalizeUserJsonOutput(Models\Users $users, $userId = null)
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
