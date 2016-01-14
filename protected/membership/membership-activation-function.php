<?php
$app->get('/apps/membership/activation/{uid}/{activation_key}', function ($request, $response, $args) {

    $db = $this->get('db');
    $q_activation_exist_count = $db->createQueryBuilder()
        ->select('COUNT(*) AS total_data')
        ->from('users_activations')
        ->where('user_id = :uid')
        ->andWhere('activation_key = :actkey')
        ->andWhere('deleted = :d')
        ->andWhere('expired_date > NOW()')
        ->setParameter(':uid', $args['uid'])
        ->setParameter(':actkey', $args['activation_key'])
        ->setParameter(':d', 'N')
        ->execute();

    $activation_exist_count = (int) $q_activation_exist_count->fetch()['total_data'];

    if ($activation_exist_count > 0) {
        $db->update('users', ['activated' => 'Y'], ['user_id' => $args['uid']]);

        $db->update('users_activations', ['deleted' => 'Y'], [
            'user_id' => $args['uid'],
            'activation_key' => $args['activation_key']
        ]);

        $this->flash->addMessage('success', 'Selamat! Account anda sudah aktif. Silahkan login...');
    } else {
        $this->flash->addMessage('error', 'Bad Request');
    }

    return $response->withRedirect($this->router->pathFor('membership-login'), 302);
})->setName('membership-activation');

