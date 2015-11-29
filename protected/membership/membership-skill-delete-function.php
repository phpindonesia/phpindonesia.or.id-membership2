<?php
$app->post('/apps/membership/skill/delete/{id:[0-9]+}', function ($request, $response, $args) {

    $this->db->update('members_skills', array(
        'deleted' => 'Y',
        'modified' => date('Y-m-d H:i:s')
    ), array('member_skill_id' => $args['id']));

    $this->db->close();

    $this->flash->flashLater('success', 'Item Skill berhasil dihapus');

    return $response->withStatus(302)
    ->withHeader('Location', $this->router->pathFor('membership-profile'));

})->add(function ($request, $response, $next) {
    
    $routeInfo = $request->getAttribute('routeInfo');
    $id = $routeInfo[2]['id'];

    $q_check_owner = $this['db']->createQueryBuilder()
    ->select('COUNT(*) AS total_data')
    ->from('members_skills')
    ->where('member_skill_id = :msid')
    ->andWhere('user_id = :uid')
    ->setParameter(':msid', $id)
    ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
    ->execute();

    $check_owner = $q_check_owner->fetch();
    if ($check_owner['total_data'] < 1) {
        $this['flash']->flashLater('warning', 'Permission denied.');

        return $response->withStatus(302)
        ->withHeader('Location', $this['router']->pathFor('membership-profile'));
    }

    return $next($request, $response);

})->setName('membership-skill-delete');
