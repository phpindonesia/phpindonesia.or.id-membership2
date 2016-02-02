<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;

class AccountController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $qMembers = $this->db->select([
                'm.*',
                'reg_prv.regional_name province',
                'reg_cit.regional_name city'
            ])
            ->from('members_profiles m')
            ->leftJoin('regionals reg_prv', 'reg_prv.id', '=', 'm.province_id')
            ->leftJoin('regionals reg_cit', 'reg_cit.id', '=', 'm.city_id')
            ->where('m.user_id', '=', $_SESSION['MembershipAuth']['user_id'])
            ->where('m.deleted', '=', 'N')
            ->execute();

        $qMembersSocmeds = $this->db->select(['socmed_type', 'account_name', 'account_url'])
            ->from('members_socmeds')
            ->where('user_id', '=', $_SESSION['MembershipAuth']['user_id'])
            ->where('deleted', '=', 'N')
            ->execute();

        $qMembersPortfolios = $this->db->select([
                'mp.member_portfolio_id',
                'mp.company_name',
                'ids.industry_name',
                'mp.start_date_y',
                'mp.start_date_m',
                'mp.start_date_d',
                'mp.end_date_y',
                'mp.end_date_m',
                'mp.end_date_d',
                'mp.work_status',
                'mp.job_title',
                'mp.job_desc',
                'mp.created'
            ])
            ->from('members_portfolios mp')
            ->leftJoin('industries ids', 'mp.industry_id', '=', 'ids.industry_id')
            ->where('mp.user_id', '=', $_SESSION['MembershipAuth']['user_id'])
            ->where('mp.deleted', '=', 'N')
            ->execute();

        $qMembers_skills = $this->db->select([
                'ms.member_skill_id',
                'ms.skill_self_assesment',
                'sp.skill_name AS skill_parent_name',
                'ss.skill_name'
            ])
            ->from('members_skills ms')
            ->leftJoin('skills sp', 'ms.skill_parent_id', '=', 'sp.skill_id')
            ->leftJoin('skills ss', 'ms.skill_id', '=', 'ss.skill_id')
            ->where('ms.user_id', '=', $_SESSION['MembershipAuth']['user_id'])
            ->where('ms.deleted', '=', 'N')
            ->orderBy('sp.skill_name', 'ASC')
            ->execute();

        $member = $qMembers->fetch();
        $member_portfolios = $qMembersPortfolios->fetchAll();
        $member_skills = $qMembers_skills->fetchAll();
        $member_socmeds = $qMembersSocmeds->fetchAll();
        $socmedias = $this->settings['socmedias'];
        $socmedias_logo = $this->settings['socmedias_logo'];
        $months = months();

        /*
         * Data view for portfolio-add
         */
        $q_carerr_levels = $this->db->select(['career_level_id'])
            ->from('career_levels')
            ->orderBy('order_by', 'ASC')
            ->execute();

        $q_industries = $this->db->select(['industry_id', 'industry_name'])
            ->from('industries')
            ->execute();

        $career_levels = array_pairs($q_carerr_levels->fetchAll(), 'career_level_id', 'career_level_id');
        $industries = array_pairs($q_industries->fetchAll(), 'industry_id', 'industry_name');
        $years_range = years_range();
        $months_range = months_range();
        $days_range = days_range();

        // --- End data view for portfolio-add

        /*
         * Data view for skill-add
         */
        $q_skills_main = $this->db->select(['skill_id', 'skill_name'])
            ->from('skills')
            ->whereNull('parent_id')
            ->execute();

        $skills_main = array_pairs($q_skills_main->fetchAll(), 'skill_id', 'skill_name');
        $skills = array();

        if (isset($post['skill_id']) && $post['skill_parent_id'] != '') {
            $q_skills = $this->db->select(['skill_id', 'skill_name'])
                ->from('skills')
                ->where('parent_id', '=', $post['skill_parent_id'])
                ->execute();

            $skills = array_pairs($q_skills->fetchAll(), 'skill_id', 'skill_name');
        }

        // --- End data view for skill-add

        $this->setPageTitle('Membership', 'Profil Anggota');

        /*
         * Assign data view for portfolio-add
         */
        $this->view->addData(
            compact(
                'career_levels',
                'industries',
                'years_range',
                'months_range',
                'days_range'
            ),
            'sections::portfolio-add'
        );

        /*
         * Assign data view for skill-add
         */
        $this->view->addData(
            compact('skills_main', 'skills'),
            'sections::skill-add'
        );

        return $this->view->render(
            'account-index',
            compact(
                'member',
                'member_portfolios',
                'member_skills',
                'member_socmeds',
                'socmedias',
                'socmedias_logo',
                'months'
            )
        );
    }

    public function editPage(Request $request, Response $response, array $args)
    {
        $q_member = $this->db->select([
                'm.*',
                'reg_prv.regional_name province',
                'reg_cit.regional_name city'
            ])
            ->from('members_profiles m')
            ->leftJoin('regionals reg_prv', 'reg_prv.id', '=', 'm.province_id')
            ->leftJoin('regionals reg_cit', 'reg_cit.id', '=', 'm.city_id')
            ->where('m.user_id', '=', $_SESSION['MembershipAuth']['user_id'])
            ->execute();

        $q_members_socmeds = $this->db->select(['member_socmed_id', 'socmed_type', 'account_name', 'account_url'])
            ->from('members_socmeds')
            ->where('user_id', '=', $_SESSION['MembershipAuth']['user_id'])
            ->where('deleted', '=', 'N')
            ->execute();

        $q_provinces = $this->db->select(['id', 'regional_name'])
            ->from('regionals')
            ->whereNull('parent_id')
            ->where('city_code', '=', '00')
            ->orderBy('province_code, city_code')
            ->execute();

        $q_cities = $this->db->select(['id', 'regional_name'])
            ->from('regionals')
            ->where('parent_id', '=', $_SESSION['MembershipAuth']['province_id'])
            ->orderBy('province_code, city_code')
            ->execute();

        $q_religions = $this->db->select(['religion_id', 'religion_name'])
            ->from('religions')
            ->execute();

        $q_jobs = $this->db->select(['job_id'])
            ->from('jobs')
            ->execute();

        $member = $q_member->fetch();
        $members_socmeds = $q_members_socmeds->fetchAll();
        $provinces = array_pairs($q_provinces->fetchAll(), 'id', 'regional_name');
        $cities = array_pairs($q_cities->fetchAll(), 'id', 'regional_name');
        $religions = array_pairs($q_religions->fetchAll(), 'religion_id', 'religion_name');
        $jobs = array_pairs($q_jobs->fetchAll(), 'job_id', 'job_id');

        $genders = ['female' => 'Wanita', 'male' => 'Pria'];
        $identity_types = ['ktp' => 'KTP', 'sim' => 'SIM', 'ktm' => 'Kartu Mahasiswa'];
        $socmedias = $this->settings['socmedias'];

        $this->setPageTitle('Membership', 'Update Profile Anggota');

        return $this->view->render(
            'account-edit',
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

    public function edit(Request $request, Response $response, array $args)
    {
        $post = $request->getParsedBody();
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
            $area = trim($post['area']);
            $area = empty($area) ? null : $area;
            $identity_number = trim($post['identity_number']);
            $identity_number = empty($identity_number) ? null : filter_var(trim($identity_number), FILTER_SANITIZE_STRING);
            $identity_type = $post['identity_type'] == '' ? null : filter_var(trim($post['identity_type']), FILTER_SANITIZE_STRING);
            $religion_id = $post['religion_id'] == '' ? null : filter_var(trim($post['religion_id']), FILTER_SANITIZE_STRING);

            $db->beginTransaction();
            try {
                $members_profiles = [
                    'fullname' => filter_var(trim($post['fullname']), FILTER_SANITIZE_STRING),
                    'contact_phone' => filter_var(trim($post['contact_phone']), FILTER_SANITIZE_STRING),
                    'birth_place' => filter_var(trim(strtoupper($post['birth_place'])), FILTER_SANITIZE_STRING),
                    'birth_date' => $post['birth_date'] == '' ? null : filter_var(trim($post['birth_date']), FILTER_SANITIZE_STRING),
                    'identity_number' => $identity_number,
                    'identity_type' => $identity_type,
                    'religion_id' => $religion_id,
                    'province_id' => filter_var(trim($post['province_id']), FILTER_SANITIZE_STRING),
                    'city_id' => filter_var(trim($post['city_id']), FILTER_SANITIZE_STRING),
                    'area' => filter_var(trim($area), FILTER_SANITIZE_STRING),
                    'job_id' => filter_var(trim($post['job_id']), FILTER_SANITIZE_STRING),
                    'modified' => date('Y-m-d H:i:s'),
                    'modified_by' => $_SESSION['MembershipAuth']['user_id']
                ];

                // Handle Photo Profile Upload
                if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime_type = finfo_file($finfo, $_FILES['photo']['tmp_name']);
                    finfo_close($finfo);

                    $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                    $env_mode = $this->get('settings')['mode'];
                    $cdn_upload_path = 'phpindonesia/'.$env_mode.'/';
                    $new_fname = $_SESSION['MembershipAuth']['user_id'].'-'.date('YmdHis');

                    $options = [
                        'public_id' => $cdn_upload_path.$new_fname,
                        'tags' => ['user-avatar'],
                    ];

                    if ((in_array($mime_type, ['image/jpeg', 'image/png'])) && ($ext != 'php')) {

                        // Upload photo to CDN Cloudinary
                        $photo = \Cloudinary\Uploader::upload($_FILES['photo']['tmp_name'], $options);
                        $members_profiles['photo'] = $new_fname.'.'.$ext;

                        // Delete old photo
                        if ($_SESSION['MembershipAuth']['photo'] != null) {
                            $api = new \Cloudinary\Api;
                            $public_id = str_replace('.'.$ext, '', $_SESSION['MembershipAuth']['photo']);

                            $options = [
                                'public_id' => $cdn_upload_path.$new_fname,
                                'tags' => ['user-avatar'],
                            ];

                            $api->delete_resources($cdn_upload_path.$public_id, $options);
                            $_SESSION['MembershipAuth']['photo'] = $members_profiles['photo'];
                        }
                    }
                }

                // Update profile data record
                $db->update('members_profiles', $members_profiles, array(
                    'user_id' => $_SESSION['MembershipAuth']['user_id']
                ));

                $db->update('users', array(
                    'email' => trim($post['email']),
                    'province_id' => $post['province_id'],
                    'city_id' => $post['city_id'],
                    'area' => $area,
                    'modified' => date('Y-m-d H:i:s'),
                    'modified_by' => $_SESSION['MembershipAuth']['user_id']
                ), array('user_id' => $_SESSION['MembershipAuth']['user_id']));

                // Handle social medias
                if (isset($post['socmeds']) && !empty($post['socmeds'])) {
                    foreach ($post['socmeds'] as $item) {
                        $row = array(
                            'user_id' => $_SESSION['MembershipAuth']['user_id'],
                            'socmed_type' => filter_var(trim($item['socmed_type']), FILTER_SANITIZE_STRING),
                            'account_name' => filter_var(trim($item['account_name']), FILTER_SANITIZE_STRING),
                            'account_url' => filter_var(trim($item['account_url']), FILTER_SANITIZE_STRING),
                            'created' => date('Y-m-d H:i:s')
                        );

                        if ($item['member_socmed_id'] == 0) {
                            $db->insert('members_socmeds', $row);
                        } else {
                            unset($row['created']);
                            $row['modified'] = date('Y-m-d H:i:s');

                            $db->update('members_socmeds', $row, array(
                                'member_socmed_id' => $item['member_socmed_id']
                            ));
                        }

                    }
                }

                if (isset($post['socmeds_delete'])) {
                    foreach ($post['socmeds_delete'] as $item) {
                        $db->update('members_socmeds', array('deleted' => 'Y'), array(
                            'user_id' => $_SESSION['MembershipAuth']['user_id'],
                            'socmed_type' => $item
                        ));
                    }
                }

                $db->commit();

                $this->flash->addMessage('success', 'Profile information successfuly updated! Congratulation!');
            } catch (Exception $e) {
                $db->rollback();

                $this->flash->addMessage('error', 'System failed<br>'.$e->getMessage());
            }

            $db->close();
        } else {
            $this->flash->addMessage('warning', 'Some of mandatory fields is empty!');
        }

        return $response->withRedirect(
            $this->router->pathFor('membership-account')
        );
    }

    public function updatePasswordPage(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Update Password');

        return $this->view->render('account-update-password');
    }

    public function updatePassword(Request $request, Response $response, array $args)
    {
        $validator = $this->validator;
        $salt_pwd = $this->settings['salt_pwd'];

        $validator->createInput($_POST);
        $validator->rule('required', array(
            'oldpassword',
            'password',
            'repassword'
        ));

        $validator->addNewRule('check_oldpassword', function ($field, $value, array $params) use ($db, $salt_pwd) {
            $salted_current_pwd = md5($salt_pwd.$value);

            $q_current_pwd_count = $this->db
                ->select('COUNT(*) AS total_data')
                ->from('users')
                ->where('user_id = :uid')
                ->where('password = :pwd')
                ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
                ->setParameter(':pwd', $salted_current_pwd)
                ->execute();

            $current_pwd_count = (int) $q_current_pwd_count->fetch()['total_data'];
            if ($current_pwd_count > 0) {
                return true;
            }

            return false;

        }, 'Wrong! Please remember your old password');

        $validator->addNewRule('check_repassword', function ($field, $value, array $params) {
            if ($value != $post['password']) {
                return false;
            }

            return true;

        }, 'Not match with choosen new password');

        $validator->rule('check_oldpassword', 'oldpassword');
        $validator->rule('check_repassword', 'repassword');

        if ($validator->validate()) {
            $salted_new_pwd = md5($salt_pwd.$post['password']);

            $this->db->update('users', array(
                'password' => $salted_new_pwd,
                'modified' => date('Y-m-d H:i:s'),
                'modified_by' => $_SESSION['MembershipAuth']['user_id']
            ), array('user_id' => $_SESSION['MembershipAuth']['user_id']));

            $this->flash->addMessage('success', 'Password anda berhasil diubah! Selamat!');
            return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-profile'));

        } else {
            $this->flash->addMessage('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
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

    public function activate(Request $request, Response $response, array $args)
    {
        $actExistCount = $this->data(Users::class)
            ->assertActivationExists($args['uid'], $args['activation_key']);

        if ($actExistCount > 0) {
            $this->db->update('users', ['activated' => 'Y'], ['user_id' => $args['uid']]);

            $this->db->update('users_activations', ['deleted' => 'Y'], [
                'user_id' => $args['uid'],
                'activation_key' => $args['activation_key']
            ]);

            $this->flash->addMessage('success', 'Selamat! Account anda sudah aktif. Silahkan login...');
        } else {
            $this->flash->addMessage('error', 'Bad Request');
        }

        return $response->withRedirect(
            $this->router->pathFor('membership-login')
        );
    }

    public function reactivate(Request $request, Response $response, array $args)
    {
        $validator = $this->validator->createInput($_POST);

        $validator->addNewRule('check_email_exist', function ($field, $value, array $params) use ($db) {
            $q_email_exist = $this->db
                ->select('COUNT(*) AS total_data')
                ->from('users')
                ->where('email = :email')
                ->where('deleted = :d')
                ->setParameter(':email', trim($post['email']))
                ->setParameter(':d', 'N')
                ->execute();

            $email_exist = (int) $q_email_exist->fetch()['total_data'];
            if ($email_exist > 0) {
                return true;
            }

            return false;

        }, 'Tidak terdaftar!');

        $validator->rule('required', 'email');
        $validator->rule('check_email_exist', 'email');

        if ($validator->validate()) {
            //
        }
    }

    public function javascript(Request $request, Response $response, array $args)
    {
        $open_portfolio = false;
        $open_skill = false;
        $worker = array('KARYAWAN', 'FREELANCER', 'OWNER', 'MAHASISWA-KARYAWAN');
        $student = array('PELAJAR', 'MAHASISWA');

        if (in_array($_SESSION['MembershipAuth']['job_id'], $worker)) {

            if (!isset($_COOKIE['portfolio-popup'])) {
                $q_check_portf = $this->db
                    ->select('COUNT(*) AS total_data')
                    ->from('members_portfolios')
                    ->where('user_id = :uid')
                    ->where('deleted = :d')
                    ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
                    ->setParameter(':d', 'N')
                    ->execute();

                if ($q_check_portf->fetch()['total_data'] > 0) {
                    $open_portfolio = false;
                } else {
                    $open_portfolio = true;
                }
            }

            if (!isset($_COOKIE['skill-popup'])) {
                $q_check_skills = $this->db
                    ->select('COUNT(*) AS total_data')
                    ->from('members_skills')
                    ->where('user_id = :uid')
                    ->where('deleted = :d')
                    ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
                    ->setParameter(':d', 'N')
                    ->execute();

                if ($q_check_skills->fetch()['total_data'] > 0) {
                    $open_skill = false;
                } else {
                    $open_skill = true;
                }
            }

        } else if (in_array($_SESSION['MembershipAuth']['job_id'], $student)) {

            if (!isset($_COOKIE['skill-popup'])) {
                $q_check_skills = $this->db
                    ->select('COUNT(*) AS total_data')
                    ->from('members_skills')
                    ->where('user_id = :uid')
                    ->where('deleted = :d')
                    ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
                    ->setParameter(':d', 'N')
                    ->execute();

                if ($q_check_skills->fetch()['total_data'] > 0) {
                    $open_skill = false;
                } else {
                    $open_skill = true;
                }
            }
        }

        return $this->view->render(
            'account-javascript',
            array(
                'open_portfolio' => $open_portfolio,
                'open_skill' => $open_skill
            )
        )->withHeader('Content-Type', 'application/javascript');
    }

    public function portfolioCookie(Request $request, Response $response, array $args)
    {
        if (!isset($_COOKIE['portfolio-popup'])) {
            setcookie('portfolio-popup', 1, time()+86400);
        }

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array('resp' => 'OK')));
    }

    public function skillsCookie(Request $request, Response $response, array $args)
    {
        if (!isset($_COOKIE['skill-popup'])) {
            setcookie('skill-popup', 1, time()+86400);
        }

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode(array('resp' => 'OK')));
    }
}
