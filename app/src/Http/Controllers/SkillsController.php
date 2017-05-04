<?php

namespace Membership\Http\Controllers;

use Membership\Http\Request;
use Membership\Http\Response;
use Membership\Http\Controllers;
use Membership\Models;
use Slim\Exception\NotFoundException;

class SkillsController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $this->assertXhrRequest($request, $response);

        if (!$skills = (new Models\Skills)->getChilds($args['id'])) {
            throw new NotFoundException($request, $response);
        }

        return $response->withJson($skills);
    }

    public function addPage(Request $request, Response $response)
    {
        $this->setPageTitle('Membership', 'Add new techno skill item');

        $skills = new Models\Skills;
        $provinceId = $request->getParam('province_id');

        return $response->view('skills-add', [
            'skills_main' => array_pairs($skills->getParents(), 'skill_id', 'skill_name'),
            'skills'      => array_pairs($skills->getChilds($provinceId), 'skill_id', 'skill_name'),
        ]);
    }

    public function add(Request $request, Response $response)
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
            (new Models\MemberSkills)->create([
                'user_id'              => $this->session->get('user_id'),
                'skill_id'             => $input['skill_id'] ?: $input['skill_parent_id'],
                'skill_parent_id'      => $input['skill_parent_id'],
                'skill_self_assesment' => $input['skill_self_assesment'],
            ]);

            $this->addFormAlert('success', 'Item skill baru berhasil ditambahkan. Selamat!.  Silahkan tambahkan lagi item skill anda.');
        } else {
            $this->addFormAlert('warning', 'Some of mandatory fields is empty!', $validator->errors());

            return $response->withRedirectRoute('membership-skills-add');
        }

        return $response->withRedirectRoute('membership-account');
    }

    public function edit(Response $response)
    {
        $this->addFormAlert('error', 'Page you just visited, not available at this time');

        return $response->withRedirectRoute('membership-account');
    }

    public function delete(Response $response, array $args)
    {
        $skills = new Models\MemberSkills();

        if ($skills->delete((int) $args['id'])) {
            $this->addFormAlert('success', 'Item Skill berhasil dihapus.');
        } else {
            $this->addFormAlert('error', 'Sesuatu terjadi, skill gagal dihapus.');
        }

        return $response->withRedirectRoute('membership-account');
    }
}
