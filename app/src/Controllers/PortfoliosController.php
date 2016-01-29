<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;

class PortfoliosController extends Controllers
{
    public function index($request, $response)
    {
        $this->setPageTitle('Membership', 'Keanggotaan');

        return $this->view->render(
            'portfolio-index',
            compact('members','provinces', 'cities', 'html_view_pager')
        );
    }

    public function addPage(Request $request, Response $response, array $args)
    {
        $qCarerrLevels = $this->db
            ->select('career_level_id')
            ->from('career_levels')
            ->orderBy('order_by', 'ASC')
            ->execute();

        $qIndustries = $this->db
            ->select('industry_id', 'industry_name')
            ->from('industries')
            ->execute();

        $career_levels = $this->arrayPairs($qCarerrLevels->fetchAll(), 'career_level_id');
        $industries = $this->arrayPairs($qIndustries->fetchAll(), 'industry_id', 'industry_name');
        $years_range = $this->get('years_range');
        $months_range = $this->get('months_range');
        $days_range = $this->get('days_range');

        $this->setPageTitle('Membership', 'Add new portfolio');

        return $this->view->render(
            'portfolio-add',
            compact('career_levels', 'industries', 'years_range', 'months_range', 'days_range')
        );
    }

    public function add(Request $request, Response $response, array $args)
    {
        $post = $request->getParsedBody();
        $validator = $this->validator->rule('required', [
            'company_name',
            'industry_id',
            'start_date_y',
            'work_status',
            'job_title',
            'job_desc',
            'career_level_id'
        ]);

        if ($post['work_status'] == 'R') {
            $validator->rule('required', 'end_date_y');
        }

        if ($validator->validate()) {
            $this->db->insert('members_portfolios', [
                'user_id'         => $_SESSION['MembershipAuth']['user_id'],
                'company_name'    => $post['company_name'],
                'industry_id'     => $post['industry_id'],
                'start_date_y'    => $post['start_date_y'],
                'start_date_m'    => $post['work_status'] == 'A' ? null : $request->getParsedBodyParam('start_date_m'),
                'start_date_d'    => $post['work_status'] == 'A' ? null : $request->getParsedBodyParam('start_date_d'),
                'end_date_y'      => $post['end_date_y'],
                'end_date_m'      => $post['work_status'] == 'A' ? null : $request->getParsedBodyParam('end_date_m'),
                'end_date_d'      => $post['work_status'] == 'A' ? null : $request->getParsedBodyParam('end_date_d'),
                'work_status'     => $post['work_status'],
                'job_title'       => $post['job_title'],
                'job_desc'        => $post['job_desc'],
                'career_level_id' => $post['career_level_id'],
                'created'         => date('Y-m-d H:i:s'),
                'created_by'      => $_SESSION['MembershipAuth']['user_id'],
                'deleted'         => 'N'
            ]);

            $this->flash->addMessage('success', 'Item portfolio baru berhasil ditambahkan. Selamat! . Silahkan tambahkan lagi item portfolio anda.');
        } else {
            $this->flash->addMessage('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
        }

        return $response->withRedirect(
            $this->router->pathFor('membership-profile')
        );
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $socmedias      = $this->settings['socmedias'];
        $identity_types = ['ktp' => 'KTP', 'sim' => 'SIM', 'ktm' => 'Kartu Mahasiswa'];

        if ($request->isPost()) {
            // input collection
            $member = [
                'email'       => trim(htmlspecialchars($post['email'])),
                'province_id' => $post['province_id'],
                'city_id'     => $post['city_id'],
                'area'        => trim(htmlspecialchars($post['area'])),
                'modified'    => date('Y-m-d H:i:s'),
                'modified_by' => $_SESSION['MembershipAuth']['user_id'],
            ];

            $members_profiles = [
                'fullname'        => strtoupper(trim(strip_tags($post['fullname']))),
                'contact_phone'   => trim(htmlspecialchars($post['contact_phone'])),
                'birth_place'     => trim(strtoupper(htmlspecialchars($post['birth_place']))),
                'birth_date'      => trim(htmlspecialchars($post['birth_date'])),
                'identity_number' => trim(htmlspecialchars($post['identity_number'])),
                'identity_type'   => trim(htmlspecialchars($post['identity_type'])),
                'religion_id'     => $post['religion_id'],
                'province_id'     => $member['province_id'],
                'city_id'         => $member['city_id'],
                'area'            => $member['area'],
                'job_id'          => trim(htmlspecialchars($post['job_id'])),
                'modified'        => date('Y-m-d H:i:s'),
                'modified_by'     => $_SESSION['MembershipAuth']['user_id']
            ];

            // validation layer
            $validator = $this->validator;
            $validator->createInput($_POST);

            $validator->rules([
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

            // Handle Photo Profile Upload
            if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                $finfo     = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $_FILES['photo']['tmp_name']);
                finfo_close($finfo);

                $ext             = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                $env_mode        = $this->settings['mode'];
                $cdn_upload_path = 'phpindonesia/' . $env_mode . '/';
                $new_fname       = $_SESSION['MembershipAuth']['user_id'] . '-' . date('YmdHis');

                $options = [
                    'public_id' => $cdn_upload_path . $new_fname,
                    'tags'      => ['user-avatar'],
                ];

                if ((in_array($mime_type, ['image/jpeg', 'image/png'])) && ($ext != 'php')) {

                    // Upload photo to CDN Cloudinary
                    $photo = \Cloudinary\Uploader::upload($_FILES['photo']['tmp_name'], $options);
                    $members_profiles['photo'] = $new_fname . '.' . $ext;

                    // Delete old photo
                    if ($_SESSION['MembershipAuth']['photo'] != null) {
                        $api       = new \Cloudinary\Api;
                        $public_id = str_replace('.' . $ext, '', $_SESSION['MembershipAuth']['photo']);

                        $options = [
                            'public_id' => $cdn_upload_path . $new_fname,
                            'tags'      => ['user-avatar'],
                        ];

                        $api->delete_resources($cdn_upload_path . $public_id, $options);
                        $_SESSION['MembershipAuth']['photo'] = $members_profiles['photo'];
                    }
                } else {
                    $this->view->addData(array('_view_validation_errors_' => ['photo' => 'File not supported']));
                }
            }

            // Handle social medias
            $data_socmed = [];

            if (isset($post['socmeds']) && !empty($post['socmeds'])) {
                $socmeds = array_keys($socmedias);

                foreach ($post['socmeds'] as $i => $item) {
                    if (empty($item['socmed_type'])) continue;
                    if (empty($item['account_name']) && empty($item['account_url'])) continue;

                    $type = htmlentities($item['socmed_type']);
                    $validator->rule('in', "socmeds.{$i}.socmed_type", $socmeds)->message("Unknown media name : {$type}");
                    $validator->rule('slug', "socmeds.{$i}.account_name")->label("[{$type}]: account name");
                    $validator->rule('url', "socmeds.{$i}.account_url")->label("[{$type}]: account url");

                    $data_socmed[] = array(
                        'user_id'      => $_SESSION['MembershipAuth']['user_id'],
                        'socmed_type'  => $item['socmed_type'],
                        'account_name' => $item['account_name'],
                        'account_url'  => $item['account_url'] ? $item['account_url'] : $socmedias[$item['socmed_type']][2] . $item['account_name'],
                        'created'      => date('Y-m-d H:i:s'),
                        'deleted'      => 'N',
                    );
                }
            }

            try {
                if ($validator->validate()) {
                    $this->db->beginTransaction();

                    // Update profile data record
                    $this->db->update('members_profiles', $members_profiles, array(
                        'user_id' => $_SESSION['MembershipAuth']['user_id']
                    ));

                    $this->db->update('users', $member, array('user_id' => $_SESSION['MembershipAuth']['user_id']));

                    // social media deletions
                    if (isset($post['socmeds_delete'])) {
                        foreach ($post['socmeds_delete'] as $item) {
                            $this->db->update('members_socmeds', array('deleted' => 'Y'), array(
                                'user_id'     => $_SESSION['MembershipAuth']['user_id'],
                                'socmed_type' => $item
                            ));
                        }
                    }

                    // data social medias
                    foreach ($data_socmed as $item) {
                        try {
                            $this->db->insert('members_socmeds', $item);
                        } catch(Exception $e) {
                            unset($item['created']);
                            $item['modified'] = date('Y-m-d H:i:s');

                            $this->db->update('members_socmeds', $item, array(
                                'user_id'     => $item['user_id'],
                                'socmed_type' => $item['socmed_type'],
                            ));
                        }
                    }

                    $this->db->commit();
                    $this->db->close();

                    // also update session data
                    unset($member['modified'], $member['modified_by'], $member['area']);
                    isset($members_profiles['photo']) && ($member['photo'] = $members_profiles['photo']);

                    $member['fullname']         = $members_profiles['fullname'];
                    $_SESSION['MembershipAuth'] = array_merge($_SESSION['MembershipAuth'], $member);

                    $this->flash->addMessage('success', 'Profile information successfuly updated! Congratulation!');
                    return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-profile'));
                } else {
                    $this->flash->addMessage('warning', 'Some of fields are invalid!');
                }
            } catch(Exception $e) {
                $this->db->rollback();
                $this->db->close();

                $this->flash->addMessage('error', 'System failed<br />' . $e->getMessage());
            }
        }

        $q_member = $this->db
            ->select(
                'm.*',
                'reg_prv.regional_name AS province',
                'reg_cit.regional_name AS city'
            )
            ->from('members_profiles', 'm')
            ->leftJoin('m', 'regionals', 'reg_prv', 'reg_prv.id = m.province_id')
            ->leftJoin('m', 'regionals', 'reg_cit', 'reg_cit.id = m.city_id')
            ->where('m.user_id = :uid')
            ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
            ->execute();

        $q_members_socmeds = $this->db
            ->select('member_socmed_id', 'socmed_type', 'account_name', 'account_url')
            ->from('members_socmeds')
            ->where('user_id = :uid')
            ->where('deleted = :d')
            ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
            ->setParameter(':d', 'N')
            ->execute();

        $q_provinces = $this->db
            ->select('id', 'regional_name')
            ->from('regionals')
            ->where('parent_id IS NULL')
            ->where('city_code = :ccode')
            ->orderBy('province_code, city_code')
            ->setParameter(':ccode', '00', \Doctrine\DBAL\Types\Type::STRING)
            ->execute();

        $province_id = isset($post['province_id']) ? $post['province_id'] : $_SESSION['MembershipAuth']['province_id'];
        $q_cities    = $this->db
            ->select('id', 'regional_name')
            ->from('regionals')
            ->where('parent_id = :pvid')
            ->orderBy('province_code, city_code')
            ->setParameter(':pvid', $province_id, \Doctrine\DBAL\Types\Type::INTEGER)
            ->execute();

        $q_religions = $this->db
            ->select('religion_id', 'religion_name')
            ->from('religions')
            ->execute();

        $q_jobs = $this->db
            ->select('job_id')
            ->from('jobs')
            ->execute();

        $member          = $q_member->fetch();
        $members_socmeds = $q_members_socmeds->fetchAll();
        $provinces       = $this->arrayPairs($q_provinces->fetchAll(), 'id', 'regional_name');
        $cities          = $this->arrayPairs($q_cities->fetchAll(), 'id', 'regional_name');
        $religions       = $this->arrayPairs($q_religions->fetchAll(), 'religion_id', 'religion_name');
        $jobs            = $this->arrayPairs($q_jobs->fetchAll(), 'job_id', 'job_id');
        $genders         = ['female' => 'Wanita', 'male' => 'Pria'];

        $this->db->close();

        $this->view->addData(
            array(
                'page_title'     => 'Membership',
                'sub_page_title' => 'Update Profile Anggota'
            ),
            'layouts::system'
        );

        return $this->view->render(
            'profile-edit',
            compact(
                'member',
                'provinces',
                'cities',
                'genders',
                'religions',
                'identity_types',
                'socmedias',
                'members_socmeds',
                'jobs'
            )
        );
    }
}
