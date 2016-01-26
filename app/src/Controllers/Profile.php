<?php
namespace Membership\Controllers;

use Membership\Controllers;
use Slim\Exception\NotFoundException;

class Profile extends Controllers
{
    public function index($request, $response)
    {
        $q_member = $this->db->createQueryBuilder()
            ->select(
                'u.user_id',
                'u.username',
                'u.email',
                'u.created',
                'm.*',
                'reg_prv.regional_name AS province',
                'reg_cit.regional_name AS city'
            )
            ->from('users', 'u')
            ->leftJoin('u', 'members_profiles', 'm', 'u.user_id = m.user_id')
            ->leftJoin('m', 'regionals', 'reg_prv', 'reg_prv.id = m.province_id')
            ->leftJoin('m', 'regionals', 'reg_cit', 'reg_cit.id = m.city_id')
            ->where('u.username = :uname')
            ->setParameter(':rid', 'member')
            ->setParameter(':uname', $args['name'])
            ->execute();

        $member = $q_member->fetch();

        $q_member_socmeds = $this->db->createQueryBuilder()
            ->select('socmed_type', 'account_name', 'account_url')
            ->from('members_socmeds')
            ->where('user_id = :uid')
            ->andWhere('deleted = :d')
            ->setParameter(':uid', $member['user_id'])
            ->setParameter(':d', 'N')
            ->execute();

        $q_member_portfolios = $this->db->createQueryBuilder()
            ->select(
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
            )
            ->from('members_portfolios', 'mp')
            ->leftJoin('mp', 'industries', 'ids', 'mp.industry_id = ids.industry_id')
            ->where('mp.user_id = :uid')
            ->andWhere('mp.deleted = :d')
            ->setParameter(':uid', $member['user_id'])
            ->setParameter(':d', 'N')
            ->execute();

        $member_portfolios = $q_member_portfolios->fetchAll();
        $member_socmeds = $q_member_socmeds->fetchAll();
        $socmedias = $this->settings['socmedias'];
        $socmedias_logo = $this->settings['socmedias_logo'];
        $months = $this->get('months');

        $this->view->addData([
            'page_title' => 'Membership',
            'sub_page_title' => 'Detail Anggota'
        ], 'layouts::system');

        return $this->view->render(
            $response,
            'membership/detail',
            compact(
                'member',
                'member_socmeds',
                'socmedias',
                'socmedias_logo',
                'member_portfolios',
                'months'
            )
        );
    }

    public function member($request, $response)
    {
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
        ->andWhere('m.deleted = :d')
        ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
        ->setParameter(':d', 'N')
        ->execute();

        $q_member_socmeds = $this->db->createQueryBuilder()
        ->select('socmed_type', 'account_name', 'account_url')
        ->from('members_socmeds')
        ->where('user_id = :uid')
        ->andWhere('deleted = :d')
        ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
        ->setParameter(':d', 'N')
        ->execute();

        $q_member_portfolios = $this->db->createQueryBuilder()
        ->select(
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
        )
        ->from('members_portfolios', 'mp')
        ->leftJoin('mp', 'industries', 'ids', 'mp.industry_id = ids.industry_id')
        ->where('mp.user_id = :uid')
        ->andWhere('mp.deleted = :d')
        ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
        ->setParameter(':d', 'N')
        ->execute();

        $q_member_skills = $this->db->createQueryBuilder()
        ->select(
            'ms.member_skill_id',
            'ms.skill_self_assesment',
            'sp.skill_name AS skill_parent_name',
            'ss.skill_name'
        )
        ->from('members_skills', 'ms')
        ->leftJoin('ms', 'skills', 'sp', 'ms.skill_parent_id = sp.skill_id')
        ->leftJoin('ms', 'skills', 'ss', 'ms.skill_id = ss.skill_id')
        ->where('ms.user_id = :uid')
        ->andWhere('ms.deleted = :d')
        ->orderBy('sp.skill_name', 'ASC')
        ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
        ->setParameter(':d', 'N')
        ->execute();

        $member = $q_member->fetch();
        $member_portfolios = $q_member_portfolios->fetchAll();
        $member_skills = $q_member_skills->fetchAll();
        $member_socmeds = $q_member_socmeds->fetchAll();
        $socmedias = $this->settings['socmedias'];
        $socmedias_logo = $this->settings['socmedias_logo'];
        $months = $this->get('months');

        /*
         * Data view for portfolio-add-section
         * //
        */
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

        // --- End data view for portfolio-add-section

        /*
         * Data view for skill-add-section
         * //
        */
        $q_skills_main = $this->db->createQueryBuilder()
        ->select('skill_id', 'skill_name')
        ->from('skills')
        ->where('parent_id IS NULL')
        ->execute();

        $skills_main = \Cake\Utility\Hash::combine($q_skills_main->fetchAll(), '{n}.skill_id', '{n}.skill_name');
        $skills = array();

        if (isset($_POST['skill_id']) && $_POST['skill_parent_id'] != '') {
            $q_skills = $this->db->createQueryBuilder()
            ->select('skill_id', 'skill_name')
            ->from('skills')
            ->where('parent_id = :pid')
            ->setParameter(':pid', $_POST['skill_parent_id'])
            ->execute();

            $skills = \Cake\Utility\Hash::combine($q_skills->fetchAll(), '{n}.skill_id', '{n}.skill_name');
        }

        // --- End data view for skill-add-section

        $this->db->close();

        $this->view->addData(
            array(
                'page_title' => 'Membership',
                'sub_page_title' => 'Profil Anggota'
            ),
            'layouts::system'
        );


        /*
         * Assign data view for portfolio-add-section
         * //
        */
        $this->view->addData(
            compact(
                'career_levels',
                'industries',
                'years_range',
                'months_range',
                'days_range'
            ),
            'membership/sections/portfolio-add-section'
        );

        /*
         * Assign data view for skill-add-section
         * //
        */
        $this->view->addData(
            compact('skills_main', 'skills'),
            'membership/sections/skill-add-section'
        );

        return $this->view->render(
            $response,
            'membership/profile',
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

    public function javascript($request, $response)
    {
        $open_portfolio = false;
        $open_skill = false;
        $worker = array('KARYAWAN', 'FREELANCER', 'OWNER', 'MAHASISWA-KARYAWAN');
        $student = array('PELAJAR', 'MAHASISWA');

        if (in_array($_SESSION['MembershipAuth']['job_id'], $worker)) {

            if (!isset($_COOKIE['portfolio-popup'])) {
                $q_check_portf = $this->db->createQueryBuilder()
                ->select('COUNT(*) AS total_data')
                ->from('members_portfolios')
                ->where('user_id = :uid')
                ->andWhere('deleted = :d')
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
                $q_check_skills = $this->db->createQueryBuilder()
                ->select('COUNT(*) AS total_data')
                ->from('members_skills')
                ->where('user_id = :uid')
                ->andWhere('deleted = :d')
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
                $q_check_skills = $this->db->createQueryBuilder()
                ->select('COUNT(*) AS total_data')
                ->from('members_skills')
                ->where('user_id = :uid')
                ->andWhere('deleted = :d')
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
            'membership/profile-javascript',
            array(
                'open_portfolio' => $open_portfolio,
                'open_skill' => $open_skill
            )
        );
    }

    public function portfolioCookie($request, $response)
    {
        if (!isset($_COOKIE['portfolio-popup'])) {
            setcookie('portfolio-popup', 1, time()+86400);
        }

        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array('resp' => 'OK')));
    }

    public function skillsCookie($request, $response)
    {
        if (!isset($_COOKIE['skill-popup'])) {
            setcookie('skill-popup', 1, time()+86400);
        }

        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array('resp' => 'OK')));
    }
}
