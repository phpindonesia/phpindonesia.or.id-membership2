<?php
namespace Membership\Controllers;

use Membership\Controllers;
use Slim\Exception\NotFoundException;

class Skills extends Controllers
{
    public function index($request, $response, $args)
    {
        $this->assertXhrRequest($request, $response);

        $skills = Skills::factory($this->db)
            ->getChild($args['skill_id']);

        return $response->withJson($skills, 200);
    }

    public function add($request, $response, $args)
    {
        $this->assertXhrRequest($request, $response);

        $skills = $this->db->select(['skill_id', 'skill_name'])
            ->from('skills')
            ->where('parent_id', '=', $args['skill_id'])
            ->execute();

        return $response->withJson($skills, 200);
    }

    public function addPage($request, $response, $args)
    {
        if ($request->isPost()) {
            $this->validator->createInput($_POST);
            $this->validator->rule('required', array(
                'skill_parent_id',
                'skill_self_assesment'
            ));

            if (isset($_POST['skill_id'])) {
                $this->validator->rule('required', array('skill_id'));
            }

            if ($this->validator->validate()) {

                $skill_id = null;
                $skill_parent_id = filter_var(trim($_POST['skill_parent_id']), FILTER_SANITIZE_STRING);
                if (!isset($_POST['skill_id'])) {
                    $skill_id = $skill_parent_id;
                } else {
                    $skill_id = filter_var(trim($_POST['skill_id']), FILTER_SANITIZE_STRING);
                }

                $this->db->insert('members_skills', array(
                    'user_id' => filter_var(trim($_SESSION['MembershipAuth']['user_id']), FILTER_SANITIZE_STRING),
                    'skill_id' => $skill_id,
                    'skill_parent_id' => $skill_parent_id,
                    'skill_self_assesment' => filter_var(trim($_POST['skill_self_assesment']), FILTER_SANITIZE_STRING),
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => null
                ));

                $this->db->close();

                $this->flash->addMessage('success', 'Item skill baru berhasil ditambahkan. Selamat! . Silahkan tambahkan lagi item skill anda.');
                return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-profile'));

            } else {
                $this->flash->addMessage('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
            }
        }


        $q_skills_main = $this->db->createQueryBuilder()
            ->select('skill_id', 'skill_name')
            ->from('skills')
            ->where('parent_id IS NULL')
            ->execute();

        $skills_main = $this->arrayPairs($q_skills_main->fetchAll(), '{n}.skill_id', '{n}.skill_name');
        $skills = array();

        if (isset($_POST['skill_id']) && $_POST['skill_parent_id'] != '') {
            $q_skills = $this->db->createQueryBuilder()
            ->select('skill_id', 'skill_name')
            ->from('skills')
            ->where('parent_id = :pid')
            ->setParameter(':pid', $_POST['skill_parent_id'])
            ->execute();

            $skills = $this->arrayPairs($q_skills->fetchAll(), '{n}.skill_id', '{n}.skill_name');
        }

        $this->view->addData(
            array(
                'page_title' => 'Membership',
                'sub_page_title' => 'Add new techno skill item'
            ),
            'layouts::system'
        );

        return $this->view->render(
            'membership/skill-add',
            compact('skills_main', 'skills')
        );
    }

    public function delete($request, $response, $args)
    {
        $this->db->update('members_skills', array(
            'deleted' => 'Y',
            'modified' => date('Y-m-d H:i:s')
        ), array('member_skill_id' => $args['id']));

        $this->db->close();

        $this->flash->addMessage('success', 'Item Skill berhasil dihapus');

        return $response->withStatus(302)
            ->withHeader('Location', $this->router->pathFor('membership-profile'));
    }
}
