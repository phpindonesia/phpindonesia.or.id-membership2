<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;
use Membership\Models\Users;
use Membership\Models\Skills;
use Membership\Models\MemberSkills;

class SkillsController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $this->assertXhrRequest($request, $response);

        return $response->withJson(
            $this->data(Skills::class)->getChilds($args['skill_id'])
        );
    }

    public function addPage(Request $request, Response $response, array $args)
    {
        $skills = $this->data(Skills::class);
        $provinceId = $request->getParam('province_id');

        $this->setPageTitle('Membership', 'Add new techno skill item');

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
            $users = $this->data(Users::class);
            $skills = $this->data(MemberSkills::class);
            $skills->create([
                'user_id'              => $users->current('user_id'),
                'skill_id'             => $input['skill_id'] ?: $input['skill_parent_id'],
                'skill_parent_id'      => $input['skill_parent_id'],
                'skill_self_assesment' => $input['skill_self_assesment'],
            ]);

            $this->flash->addMessage('success', 'Item skill baru berhasil ditambahkan. Selamat!.  Silahkan tambahkan lagi item skill anda.');
        } else {
            $this->flash->addMessage('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
        }

        return $response->withRedirect(
            $this->router->pathFor('membership-profile', [
                'username' => $users->current('username')
            ])
        );
    }

    public function editPage(Request $request, Response $response, array $args)
    {
        $users = $this->data(Users::class);
        $this->flash->addMessage('error', 'Page you just visited, not available at this time');

        return $response->withRedirect(
            $this->router->pathFor('membership-profile', [
                'username' => $users->current('username')
            ])
        );
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $users = $this->data(Users::class);
        $this->flash->addMessage('error', 'Page you just visited, not available at this time');

        return $response->withRedirect(
            $this->router->pathFor('membership-profile', [
                'username' => $users->current('username')
            ])
        );
    }

    public function delete(Request $request, Response $response, array $args)
    {
        $users = $this->data(Users::class);
        $skills = $this->data(MemberSkills::class);

        if ($skills->delete((int) $args['id'])) {
            $this->flash->addMessage('success', 'Item Skill berhasil dihapus.');
        } else {
            $this->flash->addMessage('error', 'Sesuatu terjadi, skill gagal dihapus.');
        }

        return $response->withRedirect(
            $this->router->pathFor('membership-profile', [
                'username' => $users->current('username')
            ])
        );
    }
}
