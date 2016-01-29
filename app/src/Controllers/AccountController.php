<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;

class AccountController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $qMembers = $this->db
            ->select([
                'm.*',
                'reg_prv.regional_name AS province',
                'reg_cit.regional_name AS city'
            ])
            ->from('members_profiles m')
            ->leftJoin('regionals reg_prv', 'reg_prv.id', '=', 'm.province_id')
            ->leftJoin('regionals reg_cit', 'reg_cit.id', '=', 'm.city_id')
            ->where('m.user_id', '=', $_SESSION['MembershipAuth']['user_id'])
            ->where('m.deleted', '=', 'N')
            ->execute();

        $qMembersSocmeds = $this->db
            ->select(['socmed_type', 'account_name', 'account_url'])
            ->from('members_socmeds')
            ->where('user_id', '=', $_SESSION['MembershipAuth']['user_id'])
            ->where('deleted', '=', 'N')
            ->execute();

        $qMembersPortfolios = $this->db
            ->select([
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

        $qMembers_skills = $this->db
            ->select([
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
        $months = []; // $this->get('months');

        /*
         * Data view for portfolio-add
         */
        $q_carerr_levels = $this->db
            ->select(['career_level_id'])
            ->from('career_levels')
            ->orderBy('order_by', 'ASC')
            ->execute();

        $q_industries = $this->db
            ->select(['industry_id', 'industry_name'])
            ->from('industries')
            ->execute();

        $career_levels = $this->arrayPairs($q_carerr_levels->fetchAll(), 'career_level_id', 'career_level_id');
        $industries = $this->arrayPairs($q_industries->fetchAll(), 'industry_id', 'industry_name');
        $years_range = []; // $this->get('years_range');
        $months_range = []; // $this->get('months_range');
        $days_range = []; // $this->get('days_range');

        // --- End data view for portfolio-add

        /*
         * Data view for skill-add
         * //
        */
        $q_skills_main = $this->db
            ->select(['skill_id', 'skill_name'])
            ->from('skills')
            ->whereNull('parent_id')
            ->execute();

        $skills_main = $this->arrayPairs($q_skills_main->fetchAll(), 'skill_id', 'skill_name');
        $skills = array();

        if (isset($post['skill_id']) && $post['skill_parent_id'] != '') {
            $q_skills = $this->db->select(['skill_id', 'skill_name'])
                ->from('skills')
                ->where('parent_id', '=', $post['skill_parent_id'])
                ->execute();

            $skills = $this->arrayPairs($q_skills->fetchAll(), 'skill_id', 'skill_name');
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
            'profile-account',
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

    public function updatePasswordPage(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Update Password');

        return $this->view->render('password-update');
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

        return $this->view->render('activation-reactivate');
    }

    public function activate(Request $request, Response $response, array $args)
    {
        $actExistCount = Users::factory($this->db)
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

        $response_n = $response->withStatus(200)
            ->withHeader('Content-Type', 'application/javascript');

        return $this->view->render(
            $response_n,
            'profile-javascript',
            array(
                'open_portfolio' => $open_portfolio,
                'open_skill' => $open_skill
            )
        );
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
