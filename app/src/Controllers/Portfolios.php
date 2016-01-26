<?php
namespace Membership\Controllers;

use Membership\Controllers;
use Slim\Exception\NotFoundException;

class Portfolios extends Controllers
{
    public function index($request, $response)
    {
        $this->setPageTitle('Membership', 'Keanggotaan');

        return $this->view->render(
            'membership/index',
            compact('members','provinces', 'cities', 'html_view_pager')
        );
    }

    public function add($request, $response, $args)
    {
        $db = $this->db;

        if ($request->isPost()) {
            $validator = $this->validator;
            $validator->createInput($_POST);
            $validator->rule('required', array(
                'company_name',
                'industry_id',
                'start_date_y',
                'work_status',
                'job_title',
                'job_desc',
                'career_level_id'
            ));

            if ($_POST['work_status'] == 'R') {
                $validator->rule('required', 'end_date_y');
            }

            if ($validator->validate()) {

                if ($_POST['work_status'] == 'A') {
                    $_POST['end_date_y'] = null;
                    $_POST['end_date_m'] = null;
                    $_POST['end_date_d'] = null;
                }

                $this->db->insert('members_portfolios', array(
                    'user_id' => $_SESSION['MembershipAuth']['user_id'],
                    'company_name' => filter_var(trim($_POST['company_name']), FILTER_SANITIZE_STRING),
                    'industry_id' => filter_var(trim($_POST['industry_id']), FILTER_SANITIZE_STRING),
                    'start_date_y' => filter_var(trim($_POST['start_date_y']), FILTER_SANITIZE_STRING),
                    'start_date_m' => $_POST['start_date_m'] == '' ? null : filter_var(trim($_POST['start_date_m']), FILTER_SANITIZE_STRING),
                    'start_date_d' => $_POST['start_date_d'] == '' ? null : filter_var(trim($_POST['start_date_d']), FILTER_SANITIZE_STRING),
                    'end_date_y' => filter_var(trim($_POST['end_date_y']), FILTER_SANITIZE_STRING),
                    'end_date_m' => $_POST['end_date_m'] == '' ? null : filter_var(trim($_POST['end_date_m']), FILTER_SANITIZE_STRING),
                    'end_date_d' => $_POST['end_date_d'] == '' ? null : filter_var(trim($_POST['end_date_d']), FILTER_SANITIZE_STRING),
                    'work_status' => filter_var(trim($_POST['work_status']), FILTER_SANITIZE_STRING),
                    'job_title' => filter_var(trim($_POST['job_title']), FILTER_SANITIZE_STRING),
                    'job_desc' => filter_var(trim($_POST['job_desc']), FILTER_SANITIZE_STRING),
                    'career_level_id' => filter_var(trim($_POST['career_level_id']), FILTER_SANITIZE_STRING),
                    'created' => date('Y-m-d H:i:s'),
                    'created_by' => $_SESSION['MembershipAuth']['user_id'],
                    'deleted' => 'N'
                ));

                $this->flash->addMessage('success', 'Item portfolio baru berhasil ditambahkan. Selamat! . Silahkan tambahkan lagi item portfolio anda.');
                return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-profile'));

            } else {
                $this->flash->addMessage('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
            }
        }

        $q_carerr_levels = $this->db->createQueryBuilder()
        ->select('career_level_id')
        ->from('career_levels')
        ->orderBy('order_by', 'ASC')
        ->execute();

        $q_industries = $this->db->createQueryBuilder()
        ->select('industry_id', 'industry_name')
        ->from('industries')
        ->execute();

        $career_levels = \Cake\Utility\Hash::combine($q_carerr_levels->fetchAll(), '{n}.career_level_id', '{n}.career_level_id');
        $industries = \Cake\Utility\Hash::combine($q_industries->fetchAll(), '{n}.industry_id', '{n}.industry_name');
        $years_range = $this->get('years_range');
        $months_range = $this->get('months_range');
        $days_range = $this->get('days_range');

        $this->view->addData(
            array(
                'page_title' => 'Membership',
                'sub_page_title' => 'Add new portfolio'
            ),
            'layouts::system'
        );

        return $this->view->render(
            $response,
            'membership/portfolio-add',
            compact('career_levels', 'industries', 'years_range', 'months_range', 'days_range')
        );
    }

    public function edit($request, $response, $args)
    {
        $socmedias      = $this->settings['socmedias'];
        $identity_types = array('ktp' => 'KTP', 'sim' => 'SIM', 'ktm' => 'Kartu Mahasiswa');

        if ($request->isPost()) {
            // input collection
            $member = array(
                'email'       => trim(htmlspecialchars($_POST['email'])),
                'province_id' => $_POST['province_id'],
                'city_id'     => $_POST['city_id'],
                'area'        => trim(htmlspecialchars($_POST['area'])),
                'modified'    => date('Y-m-d H:i:s'),
                'modified_by' => $_SESSION['MembershipAuth']['user_id'],
            );

            $members_profiles = array(
                'fullname'        => strtoupper(trim(strip_tags($_POST['fullname']))),
                'contact_phone'   => trim(htmlspecialchars($_POST['contact_phone'])),
                'birth_place'     => trim(strtoupper(htmlspecialchars($_POST['birth_place']))),
                'birth_date'      => trim(htmlspecialchars($_POST['birth_date'])),
                'identity_number' => trim(htmlspecialchars($_POST['identity_number'])),
                'identity_type'   => trim(htmlspecialchars($_POST['identity_type'])),
                'religion_id'     => $_POST['religion_id'],
                'province_id'     => $member['province_id'],
                'city_id'         => $member['city_id'],
                'area'            => $member['area'],
                'job_id'          => trim(htmlspecialchars($_POST['job_id'])),
                'modified'        => date('Y-m-d H:i:s'),
                'modified_by'     => $_SESSION['MembershipAuth']['user_id']
            );

            // validation layer
            $validator = $this->validator;
            $validator->createInput($_POST);

            $validator->rule(array(
                'required'   => array(
                    ['fullname'],
                    ['email'],
                    ['province_id'],
                    ['city_id'],
                    ['area'],
                    ['job_id']
                ),
                'regex'      => array(
                    ['fullname', ':^[A-z\s]+$:'],
                    ['contact_phone', ':^[-\+\d]+$:'],
                    ['identity_number', ':^[-\+\d]+$:'],
                ),
                'lengthMax'  => array(
                    ['fullname', 32],
                    ['contact_phone', 16],
                    ['area', 64],
                    ['identity_number', 32],
                    ['birth_place', 32],
                ),
                'email'      => 'email',
                'dateFormat' => array(['birth_date', 'Y-m-d']),
                'in'         => array(['identity_type', array_keys($identity_types)]),
            ));

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
            $data_socmed = array();

            if (isset($_POST['socmeds']) && !empty($_POST['socmeds'])) {
                $socmeds = array_keys($socmedias);

                foreach ($_POST['socmeds'] as $i => $item) {
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
                    if (isset($_POST['socmeds_delete'])) {
                        foreach ($_POST['socmeds_delete'] as $item) {
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

        $q_member = $this->db->createQueryBuilder()
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

        $q_members_socmeds = $this->db->createQueryBuilder()
        ->select('member_socmed_id', 'socmed_type', 'account_name', 'account_url')
        ->from('members_socmeds')
        ->where('user_id = :uid')
        ->andWhere('deleted = :d')
        ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
        ->setParameter(':d', 'N')
        ->execute();

        $q_provinces = $this->db->createQueryBuilder()
        ->select('id', 'regional_name')
        ->from('regionals')
        ->where('parent_id IS NULL')
        ->andWhere('city_code = :ccode')
        ->orderBy('province_code, city_code')
        ->setParameter(':ccode', '00', \Doctrine\DBAL\Types\Type::STRING)
        ->execute();

        $province_id = isset($_POST['province_id']) ? $_POST['province_id'] : $_SESSION['MembershipAuth']['province_id'];
        $q_cities    = $this->db->createQueryBuilder()
        ->select('id', 'regional_name')
        ->from('regionals')
        ->where('parent_id = :pvid')
        ->orderBy('province_code, city_code')
        ->setParameter(':pvid', $province_id, \Doctrine\DBAL\Types\Type::INTEGER)
        ->execute();

        $q_religions = $this->db->createQueryBuilder()
        ->select('religion_id', 'religion_name')
        ->from('religions')
        ->execute();

        $q_jobs = $this->db->createQueryBuilder()
        ->select('job_id')
        ->from('jobs')
        ->execute();

        $member          = $q_member->fetch();
        $members_socmeds = $q_members_socmeds->fetchAll();
        $provinces       = \Cake\Utility\Hash::combine($q_provinces->fetchAll(), '{n}.id', '{n}.regional_name');
        $cities          = \Cake\Utility\Hash::combine($q_cities->fetchAll(), '{n}.id', '{n}.regional_name');
        $religions       = \Cake\Utility\Hash::combine($q_religions->fetchAll(), '{n}.religion_id', '{n}.religion_name');
        $jobs            = \Cake\Utility\Hash::combine($q_jobs->fetchAll(), '{n}.job_id', '{n}.job_id');
        $genders         = array('female' => 'Wanita', 'male' => 'Pria');

        $this->db->close();

        $this->view->addData(
            array(
                'page_title'     => 'Membership',
                'sub_page_title' => 'Update Profile Anggota'
            ),
            'layouts::system'
        );

        return $this->view->render(
            $response,
            'membership/profile-edit',
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
