<?php
$app->map(['GET', 'POST'], '/apps/membership/skill/add', function ($request, $response, $args) {

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

    $this->view->getPlates()->addData(
        array(
            'page_title' => 'Membership',
            'sub_page_title' => 'Add new techno skill item'
        ),
        'layouts::layout-system'
    );

    return $this->view->render(
        $response,
        'membership/skill-add',
        compact('skills_main', 'skills')
    );

})->setName('membership-skill-add');
