<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;

class ProfileController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $qMembers = $this->db->select([
                'u.user_id',
                'u.username',
                'u.email',
                'u.created',
                'm.*',
                'reg_prv.regional_name province',
                'reg_cit.regional_name city'
            ])
            ->from('users u')
            ->leftJoin('members_profiles m', 'u.user_id', '=', 'm.user_id')
            ->leftJoin('regionals reg_prv', 'reg_prv.id', '=', 'm.province_id')
            ->leftJoin('regionals reg_cit', 'reg_cit.id', '=', 'm.city_id')
            ->where('u.username', '=', $args['name'])
            ->execute();

        $member = $qMembers->fetch();

        $qMembersSocmeds = $this->db->select(['socmed_type', 'account_name', 'account_url'])
            ->from('members_socmeds')
            ->where('user_id', '=', $member['user_id'])
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
            ->where('mp.user_id', '=', $member['user_id'])
            ->where('mp.deleted', '=', 'N')
            ->execute();

        $member_portfolios = $qMembersPortfolios->fetchAll();
        $member_socmeds = $qMembersSocmeds->fetchAll();
        $socmedias = $this->settings['socmedias'];
        $socmedias_logo = $this->settings['socmedias_logo'];
        $months = [];

        $this->view->addData([
            'page_title' => 'Membership',
            'sub_page_title' => 'Detail Anggota'
        ], 'layouts::system');

        return $this->view->render(
            'profile-index',
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

    public function member(Request $request, Response $response, array $args)
    {
        $qMembers = $this->db
            ->select(
                'm.*',
                'reg_prv.regional_name AS province',
                'reg_cit.regional_name AS city'
            )
            ->from('members_profiles', 'm')
            ->leftJoin('m', 'regionals', 'reg_prv', 'reg_prv.id = m.province_id')
            ->leftJoin('m', 'regionals', 'reg_cit', 'reg_cit.id = m.city_id')
            ->where('m.user_id = :uid')
            ->where('m.deleted = :d')
            ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
            ->setParameter(':d', 'N')
            ->execute();

        $qMembersSocmeds = $this->db
            ->select('socmed_type', 'account_name', 'account_url')
            ->from('members_socmeds')
            ->where('user_id = :uid')
            ->where('deleted = :d')
            ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
            ->setParameter(':d', 'N')
            ->execute();

        $qMembersPortfolios = $this->db
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
            ->where('mp.deleted = :d')
            ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
            ->setParameter(':d', 'N')
            ->execute();

        $qMembers_skills = $this->db
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
            ->where('ms.deleted = :d')
            ->orderBy('sp.skill_name', 'ASC')
            ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
            ->setParameter(':d', 'N')
            ->execute();

        $member = $qMembers->fetch();
        $member_portfolios = $qMembersPortfolios->fetchAll();
        $member_skills = $qMembers_skills->fetchAll();
        $member_socmeds = $qMembersSocmeds->fetchAll();
        $socmedias = $this->settings['socmedias'];
        $socmedias_logo = $this->settings['socmedias_logo'];
        $months = $this->get('months');

        /*
         * Data view for portfolio-add
         * //
        */
        $q_carerr_levels = $this->db
        ->select('career_level_id')
        ->from('career_levels')
        ->orderBy('order_by', 'ASC')
        ->execute();

        $q_industries = $this->db
        ->select('industry_id', 'industry_name')
        ->from('industries')
        ->execute();

        $career_levels = $this->arrayPairs($q_carerr_levels->fetchAll(), '{n}.career_level_id', '{n}.career_level_id');
        $industries = $this->arrayPairs($q_industries->fetchAll(), '{n}.industry_id', '{n}.industry_name');
        $years_range = $this->get('years_range');
        $months_range = $this->get('months_range');
        $days_range = $this->get('days_range');

        // --- End data view for portfolio-add

        /*
         * Data view for skill-add
         * //
        */
        $q_skills_main = $this->db
        ->select('skill_id', 'skill_name')
        ->from('skills')
        ->where('parent_id IS NULL')
        ->execute();

        $skills_main = $this->arrayPairs($q_skills_main->fetchAll(), '{n}.skill_id', '{n}.skill_name');
        $skills = array();

        if (isset($post['skill_id']) && $post['skill_parent_id'] != '') {
            $q_skills = $this->db->select('skill_id', 'skill_name')
            ->from('skills')
            ->where('parent_id = :pid')
            ->setParameter(':pid', $post['skill_parent_id'])
            ->execute();

            $skills = $this->arrayPairs($q_skills->fetchAll(), '{n}.skill_id', '{n}.skill_name');
        }

        // --- End data view for skill-add

        $this->db->close();

        $this->view->addData(
            array(
                'page_title' => 'Membership',
                'sub_page_title' => 'Profil Anggota'
            ),
            'layouts::system'
        );


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
            'sections/portfolio-add'
        );

        /*
         * Assign data view for skill-add
         */
        $this->view->addData(
            compact('skills_main', 'skills'),
            'sections/skill-add'
        );

        return $this->view->render(
            'profile',
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
