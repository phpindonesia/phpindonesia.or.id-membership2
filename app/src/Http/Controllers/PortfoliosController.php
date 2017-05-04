<?php

namespace Membership\Http\Controllers;

use Membership\Http\Request;
use Membership\Http\Response;
use Membership\Http\Controllers;
use Membership\Models;

class PortfoliosController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $career = new Models\Careers;
        $portfolio = (new Models\MemberPortfolios)->find([
            'member_portfolio_id' => (int) $args['id'],
            'user_id' => $this->session->get('user_id'),
            'deleted' => 'N',
        ]);

        if ($request->isXhr()) {
            return $response->withJson($portfolio->fetch());
        }

        $this->setPageTitle('Membership', 'Update portfolio item');

        $this->view->addData([
            'career_levels' => array_pairs($career->getLevels(), 'career_level_id'),
            'industries'    => array_pairs($career->getIndustries(), 'industry_id', 'industry_name')
        ], 'section::portfolio-form');

        return $response->view('portfolio-edit', [
            'portfolio' => $portfolio->fetch(),
        ]);
    }

    public function addPage(Response $response)
    {
        $this->setPageTitle('Membership', 'Add new portfolio');

        $career = new Models\Careers;

        $this->view->addData([
            'career_levels' => array_pairs($career->getLevels(), 'career_level_id'),
            'industries'    => array_pairs($career->getIndustries(), 'industry_id', 'industry_name')
        ], 'section::portfolio-form');

        return $response->view('portfolio-add');
    }

    public function add(Request $request, Response $response)
    {
        $input = $request->getParsedBody();
        $portfolio = new Models\MemberPortfolios;

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
            $input['user_id'] = $this->session->get('user_id');

            try {
                $create = $portfolio->create($input);
                $message = 'Item portfolio baru berhasil ditambahkan. Selamat! . Silahkan tambahkan lagi item portfolio anda.';
            } catch (\PDOException $e) {
                $create = false;
                $message = 'System error!<br>'.$e->getMessage();
            }

            $this->addFormAlert(($create !== false ? 'success' : 'error'), $message);
        } else {
            $this->addFormAlert('warning', 'Some of mandatory fields is empty!', $validator->errors());

            return $response->withRedirectRoute('membership-portfolios-add');
        }

        return $response->withRedirectRoute('membership-account');
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();
        $portfolio = new Models\MemberPortfolios;
        $validator = $this->validator->rule('required', [
            'company_name',
            'industry_id',
            'start_date_y',
            'work_status',
            'job_title',
            'job_desc'
        ]);

        if ($input['work_status'] == 'R') {
            $validator->rule('required', 'end_date_y');
        }

        if ($validator->validate()) {
            if ($input['work_status'] == 'A') {
                unset($input['end_date_y'], $input['end_date_m'], $input['end_date_d']);
            }

            try {
                $update = $portfolio->update($input, (int) $args['id']);
                $message = 'Item portfolio berhasil diperbaharui. Selamat!';
            } catch (\PDOException $e) {
                $update = false;
                $message = 'System error!<br>'.$e->getMessage();
            }

            $this->addFormAlert(($update !== false ? 'success' : 'error'), $message);
        } else {
            $this->addFormAlert('warning', 'Some of mandatory fields is empty!', $validator->errors());

            return $response->withRedirectRoute('membership-portfolios-edit', $args);
        }

        return $response->withRedirectRoute('membership-account');
    }

    public function deleted(Response $response)
    {
        $this->addFormAlert('warning', 'This feature is disabled');

        return $response->withRedirectRoute('membership-profile', [
            'username' => $this->session->get('username')
        ]);
    }
}
