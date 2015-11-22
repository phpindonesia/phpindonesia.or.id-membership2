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

            //

            $this->flash->flashLater('success', 'Item skill baru berhasil ditambahkan. Selamat! . Silahkan tambahkan lagi item skill anda.');
            return $response->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-profile'));

        } else {
            $this->flash->flashNow('warning', 'Masih ada isian-isian wajib yang belum anda isi. Atau masih ada isian yang belum diisi dengan benar');
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
