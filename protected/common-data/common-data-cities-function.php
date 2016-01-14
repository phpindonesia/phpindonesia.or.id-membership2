<?php
$app->get('/apps/common-data/cities/{province_id:[0-9]+}', function ($request, $response, $args) {

    if ($request->isXhr()) {
        $q_cities = $this->db->createQueryBuilder()
        ->select('id', 'regional_name')
        ->from('regionals')
        ->where('parent_id = :pid')
        ->setParameter(':pid', $args['province_id'])
        ->execute();

        $cities = array();
        foreach ($q_cities->fetchAll() as $item) {
            $cities[] = array(
                'id' => $item['id'],
                'regional_name' => $item['regional_name']
            );
        }

        return $response->withJson($cities, 200);
    }
});
