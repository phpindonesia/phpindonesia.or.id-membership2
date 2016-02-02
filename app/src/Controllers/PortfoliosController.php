<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;
use Membership\Models\Users;
use Membership\Models\Careers;
use Membership\Models\MemberPortfolios;

class PortfoliosController extends Controllers
{
    public function addPage(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Add new portfolio');

        $career = $this->data(Careers::class);

        $this->view->addData([
            'career_levels' => array_pairs($career->getLevels(), 'career_level_id'),
            'industries'    => array_pairs($career->getIndustries(), 'industry_id', 'industry_name')
        ], 'sections::portfolio-form');

        return $this->view->render('portfolio-add');
    }

    public function add(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();
        $users = $this->data(Users::class);
        $portfolio = $this->data(MemberPortfolios::class);

        $validator = $this->validator->rule('required', [
            'company_name',
            'industry_id',
            'start_date_y',
            'work_status',
            'job_title',
            'job_desc',
            'career_level_id'
        ]);

        if ($input['work_status'] == 'R') {
            $validator->rule('required', 'end_date_y');
        }

        if ($validator->validate()) {
            $portfolio->create([
                'user_id'         => $users->current('user_id'),
                'company_name'    => $input['company_name'],
                'industry_id'     => $input['industry_id'],
                'start_date_y'    => $input['start_date_y'],
                'start_date_m'    => $input['start_date_m'],
                'start_date_d'    => $input['start_date_d'],
                'end_date_y'      => $input['end_date_y'],
                'end_date_m'      => $input['end_date_m'],
                'end_date_d'      => $input['end_date_d'],
                'work_status'     => $input['work_status'],
                'job_title'       => $input['job_title'],
                'job_desc'        => $input['job_desc'],
                'career_level_id' => $input['career_level_id'],
            ]);

            $this->flash->addMessage('success', 'Item portfolio baru berhasil ditambahkan. Selamat! . Silahkan tambahkan lagi item portfolio anda.');
        } else {
            $this->flash->addMessage('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
        }

        return $response->withRedirect(
            $this->router->pathFor('membership-profile', [
                'username' => $users->current('username')
            ])
        );
    }

    public function editPage(Request $request, Response $response, array $args)
    {
        $career = $this->data(Careers::class);
        $portfolio = $this->data(MemberPortfolios::class)->find([
            'member_portfolio_id' => (int) $args['id'],
            'deleted' => 'N',
        ]);

        $this->view->addData([
            'career_levels' => array_pairs($career->getLevels(), 'career_level_id'),
            'industries'    => array_pairs($career->getIndustries(), 'industry_id', 'industry_name')
        ], 'sections::portfolio-form');

        $this->setPageTitle('Membership', 'Update portfolio item');

        return $this->view->render('portfolio-edit', [
            'portfolio' => $portfolio->fetch(),
        ]);
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $socmedias      = $this->settings->get('socmedias');
        $identity_types = ['ktp' => 'KTP', 'sim' => 'SIM', 'ktm' => 'Kartu Mahasiswa'];

        // validation layer
        $validator = $this->validator->rules([
            'required'   => [
                ['fullname'],
                ['email'],
                ['province_id'],
                ['city_id'],
                ['area'],
                ['job_id']
            ],
            'regex'      => [
                ['fullname', ':^[A-z\s]+$:'],
                ['contact_phone', ':^[-\+\d]+$:'],
                ['identity_number', ':^[-\+\d]+$:'],
            ],
            'lengthMax'  => [
                ['fullname', 32],
                ['contact_phone', 16],
                ['area', 64],
                ['identity_number', 32],
                ['birth_place', 32],
            ],
            'email'      => 'email',
            'dateFormat' => [
                ['birth_date', 'Y-m-d']
            ],
            'in'         => [
                ['identity_type', array_keys($identity_types)]
            ],
        ]);

        $validator->label([
            'province_id'     => 'Provinsi',
            'city_id'         => 'Kabupaten / Kota',
            'job_id'          => 'Pekerjaan',
            'birth_place'     => 'Tempat lahir',
            'birth_date'      => 'Tanggal lahir',
            'identity_type'   => 'Jenis Identitas',
            'identity_number' => 'Nomer Identitas',
        ]);

        if ($validator->validate()) {
            $input = $request->getParsedBody();
            $users = $this->data(Users::class);
            $profile = $this->data(MemberProfile::class);
            $socmeds = $this->data(MemberSocmeds::class);

            // input collection
            $memberProfile = [
                'fullname'        => strtoupper($input['fullname']),
                'contact_phone'   => $input['contact_phone'],
                'birth_place'     => strtoupper($input['birth_place']),
                'birth_date'      => $input['birth_date'],
                'identity_number' => $input['identity_number'],
                'identity_type'   => $input['identity_type'],
                'religion_id'     => $input['religion_id'],
                'province_id'     => $member['province_id'],
                'city_id'         => $member['city_id'],
                'area'            => $member['area'],
                'job_id'          => $input['job_id'],
            ];

            // Handle social medias
            $data_socmed = [];

            if (isset($input['socmeds']) && !empty($input['socmeds'])) {
                $socmeds = array_keys($socmedias);

                foreach ($input['socmeds'] as $i => $item) {
                    if (empty($item['socmed_type']) ||
                        (empty($item['account_name']) && empty($item['account_url']))
                    ) {
                        continue;
                    }

                    $socmed_type = $item['socmed_type'];
                    $validator->rule('in', "socmeds.{$i}.socmed_type", $socmeds)->message("Unknown media name : {$socmed_type}");
                    $validator->rule('slug', "socmeds.{$i}.account_name")->label("[{$socmed_type}]: account name");
                    $validator->rule('url', "socmeds.{$i}.account_url")->label("[{$socmed_type}]: account url");

                    $data_socmed[$i] = [
                        'user_id'      => $users->current('user_id'),
                        'socmed_type'  => $socmed_type,
                        'account_name' => $item['account_name'],
                        'account_url'  => $item['account_url'] ?: $socmedias[$socmed_type][2] . $item['account_name'],
                    ];
                }
            }

            $this->db->beginTransaction();

            try {
                // Handle Photo Profile Upload
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

                // social media deletions
                if (isset($input['socmeds_delete'])) {
                    foreach ($input['socmeds_delete'] as $item) {
                        $socmeds->delete([
                            'user_id' => $users->current('user_id'),
                            'socmed_type' => $item
                        ]);
                    }
                }

                // data social medias
                foreach ($data_socmed as $item) {
                    if ($item['member_socmed_id'] == 0) {
                        $socmeds->create($item);
                    } else {
                        $socmeds->update($item, [
                            'user_id'     => $item['user_id'],
                            'socmed_type' => $item['socmed_type'],
                        ]);
                    }
                }

                $this->db->commit();

                // also update session data
                unset($member['modified'], $member['modified_by'], $member['area']);
                isset($memberProfile['photo']) && $member['photo'] = $memberProfile['photo'];

                $member['fullname'] = $memberProfile['fullname'];
                $_SESSION['MembershipAuth'] = array_merge($_SESSION['MembershipAuth'], $member);
                $this->session->replace($_SESSION['MembershipAuth']);

                $this->flash->addMessage('success', 'Profile information successfuly updated! Congratulation!');
            } catch (Exception $e) {
                $this->db->rollback();

                $this->flash->addMessage('error', 'System failed<br />' . $e->getMessage());
            }
        } else {
            $this->flash->addMessage('warning', 'Some of fields are invalid!');
        }

        return $response->withRedirect(
            $this->router->pathFor('membership-profile', [
                'username' => $_SESSION['MembershipAuth']['username']
            ])
        );
    }

    public function deleted(Request $request, Response $response, array $args)
    {
        $this->flash->addMessage('warning', 'This feature is disabled');

        return $response->withRedirect(
            $this->router->pathFor('membership-profile', [
                'username' => $_SESSION['MembershipAuth']['username']
            ])
        );
    }
}
