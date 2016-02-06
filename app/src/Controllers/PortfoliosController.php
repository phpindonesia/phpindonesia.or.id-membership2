<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;
use Membership\Models\Careers;
use Membership\Models\MemberPortfolios;

class PortfoliosController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        /** @var Careers $career */
        $career = $this->data(Careers::class);
        /** @var \PDOStatement $portfolio */
        $portfolio = $this->data(MemberPortfolios::class)->find([
            'member_portfolio_id' => (int) $args['id'],
            'user_id' => $this->session->get('user_id'),
            'deleted' => 'N',
        ]);

        if ($request->isXhr()) {
            return $response->withJson($portfolio->fetch());
        }

        $this->view->addData([
            'career_levels' => array_pairs($career->getLevels(), 'career_level_id'),
            'industries'    => array_pairs($career->getIndustries(), 'industry_id', 'industry_name')
        ], 'sections::portfolio-form');

        $this->setPageTitle('Membership', 'Update portfolio item');

        return $this->view->render('portfolio-edit', [
            'portfolio' => $portfolio->fetch(),
        ]);
    }

    public function addPage(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Add new portfolio');

        /** @var Careers $career */
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
        /** @var MemberPortfolios $portfolio */
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

            return $response->withRedirect($this->router->pathFor('membership-portfolios-add'));
        }

        return $response->withRedirect($this->router->pathFor('membership-account'));
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();
        /** @var MemberPortfolios $portfolio */
        $portfolio = $this->data(MemberPortfolios::class);
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

            return $response->withRedirect($this->router->pathFor('membership-portfolios-edit', $args));
        }

        return $response->withRedirect($this->router->pathFor('membership-account'));
    }

    public function deleted(Request $request, Response $response, array $args)
    {
        $this->addFormAlert('warning', 'This feature is disabled');

        return $response->withRedirect(
            $this->router->pathFor('membership-profile', [
                'username' => $this->session->get('username')
            ])
        );
    }
}
