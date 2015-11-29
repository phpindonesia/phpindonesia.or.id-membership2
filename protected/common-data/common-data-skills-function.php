<?php
$app->get('/apps/common-data/skills/{parent_id:[0-9]+}', function ($request, $response, $args) {

    if ($request->isXhr()) {
        $q_skills = $this->db->createQueryBuilder()
        ->select('skill_id', 'skill_name')
        ->from('skills')
        ->where('parent_id = :pid')
        ->setParameter(':pid', $args['parent_id'])
        ->execute();

        $skills = array();
        foreach ($q_skills->fetchAll() as $item) {
            $skills[] = array(
                'skill_id' => $item['skill_id'],
                'skill_name' => $item['skill_name']
            );
        }

        return $response->withJson($skills, 200);
    }

})->setName('common-data-skills');
