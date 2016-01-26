<?php
namespace Membership\Middlewares;

class SkillsDelete
{
    public function __invoke($request, $response, $next)
    {
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
    }
}
