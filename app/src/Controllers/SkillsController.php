<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;
use Membership\Models\Skills;
use Membership\Models\MemberSkills;
use Slim\Exception\NotFoundException;

class SkillsController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $this->assertXhrRequest($request, $response);
        /** @var array|false $skills */
        $skills = $this->data(Skills::class)->getChilds($args['id']);

        if (!$skills) {
            throw new NotFoundException($request, $response);
        }

        return $response->withJson($skills);
    }

    public function addPage(Request $request, Response $response, array $args)
    {
        $this->setPageTitle('Membership', 'Add new techno skill item');

        /** @var Skills $skills */
        $skills = $this->data(Skills::class);
        $provinceId = $request->getParam('province_id');

        return $this->view->render('skills-add', [
            'skills_main' => array_pairs($skills->getParents(), 'skill_id', 'skill_name'),
            'skills'      => array_pairs($skills->getChilds($provinceId), 'skill_id', 'skill_name'),
        ]);
    }

    public function add(Request $request, Response $response, array $args)
    {
        $input = $request->getParsedBody();
        $requiredFields = [
            'skill_parent_id',
            'skill_self_assesment'
        ];

        if (isset($input['skill_id'])) {
            $requiredFields[] = 'skill_id';
        }

        $validator = $this->validator->rule('required', $requiredFields);

        if ($validator->validate()) {
            /** @var Skills $skills */
            $skills = $this->data(MemberSkills::class);
            $skills->create([
                'user_id'              => $this->session->get('user_id'),
                'skill_id'             => $input['skill_id'] ?: $input['skill_parent_id'],
                'skill_parent_id'      => $input['skill_parent_id'],
                'skill_self_assesment' => $input['skill_self_assesment'],
            ]);

            $this->addFormAlert('success', 'Item skill baru berhasil ditambahkan. Selamat!.  Silahkan tambahkan lagi item skill anda.');
        } else {
            $this->addFormAlert('warning', 'Some of mandatory fields is empty!', $validator->errors());

            return $response->withRedirect($this->router->pathFor('membership-skills-add'));
        }

        return $response->withRedirect($this->router->pathFor('membership-account'));
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $this->addFormAlert('error', 'Page you just visited, not available at this time');

        return $response->withRedirect($this->router->pathFor('membership-account'));
    }

    public function delete(Request $request, Response $response, array $args)
    {
        /** @var MemberSkills $skills */
        $skills = $this->data(MemberSkills::class);

        if ($skills->delete((int) $args['id'])) {
            $this->addFormAlert('success', 'Item Skill berhasil dihapus.');
        } else {
            $this->addFormAlert('error', 'Sesuatu terjadi, skill gagal dihapus.');
        }

        return $response->withRedirect($this->router->pathFor('membership-account'));
    }
}
