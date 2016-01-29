<?php
namespace Membership\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Membership\Controllers;

class SkillsController extends Controllers
{
    public function index(Request $request, Response $response, array $args)
    {
        $this->assertXhrRequest($request, $response);

        return $response->withJson(
            Skills::factory($this->db)->getChilds($args['skill_id'])
        );
    }

    public function addPage(Request $request, Response $response, array $args)
    {
        $post = $request->getParsedBody();
        $requiredFields = [
            'skill_parent_id',
            'skill_self_assesment'
        ];

        if (isset($post['skill_id'])) {
            $requiredFields[] = 'skill_id';
        }

        $validator = $this->validator->rule('required', $requiredFields);

        if ($validator->validate()) {
            $this->db->insert('members_skills', [
                'user_id' => filter_var(trim($_SESSION['MembershipAuth']['user_id']), FILTER_SANITIZE_STRING),
                'skill_id' => !isset($post['skill_id']) ?  $post['skill_parent_id'] : $post['skill_id'],
                'skill_parent_id' => $post['skill_parent_id'],
                'skill_self_assesment' => $post['skill_self_assesment'],
                'created' => date('Y-m-d H:i:s'),
                'modified' => null
            ]);

            $this->db->close();

            $this->flash->addMessage('success', 'Item skill baru berhasil ditambahkan. Selamat! . Silahkan tambahkan lagi item skill anda.');
        } else {
            $this->flash->addMessage('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
        }

        return $response->withRedirect(
            $this->router->pathFor('membership-profile')
        );
    }

    public function add(Request $request, Response $response, array $args)
    {
        $q_skills_main = $this->db
            ->select('skill_id', 'skill_name')
            ->from('skills')
            ->where('parent_id IS NULL')
            ->execute();

        $skills_main = $this->arrayPairs($q_skills_main->fetchAll(), 'skill_id', 'skill_name');
        $skills = [];

        if (isset($post['skill_id']) && $post['skill_parent_id'] != '') {
            $q_skills = $this->db
                ->select('skill_id', 'skill_name')
                ->from('skills')
                ->where('parent_id = :pid')
                ->setParameter(':pid', $post['skill_parent_id'])
                ->execute();

            $skills = $this->arrayPairs($q_skills->fetchAll(), 'skill_id', 'skill_name');
        }

        $this->setPageTitle('Membership', 'Add new techno skill item');

        return $this->view->render(
            'membership/skill-add',
            compact('skills_main', 'skills')
        );
    }

    public function delete(Request $request, Response $response, array $args)
    {
        $this->db->update('members_skills', array(
            'deleted' => 'Y',
            'modified' => date('Y-m-d H:i:s')
        ), array('member_skill_id' => $args['id']));

        $this->db->close();

        $this->flash->addMessage('success', 'Item Skill berhasil dihapus');

        return $response->withRedirect(
            $this->router->pathFor('membership-profile')
        );
    }
}
