<?php
$app->get('/apps/common-data/cities/{province_id:[0-9]+}', function ($request, $response, $args) {

	if ($request->isXhr()) {
		$db = $this->getContainer()->get('db');

		$q_cities = $db->createQueryBuilder()
		->select('id', 'regional_name')
		->from('regionals')
		->where('parent_id = :pid')
		->setParameter(':pid', $args['province_id'])
		->execute();

		$cities = array();
		foreach ($q_cities->fetchAll() as $item) {
			array_push($cities, array(
				'id' => $item['id'],
				'regional_name' => $item['regional_name']
			));
		}

		$response_new = $response->withStatus(200)->withHeader('Content-type', 'application/json');
		return $this->view->render(
			$response_new,
			'ajax',
			array('_view_ajax_data_' => $cities)
		);
	}
});
