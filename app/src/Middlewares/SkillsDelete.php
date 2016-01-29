<?php
namespace Membership\Middlewares;

use Slim\Http\Request;
use Slim\Http\Response;

class SkillsDelete
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $routeInfo = $request->getAttribute('routeInfo');
        $query = $this['db']->createQueryBuilder()
            ->select('COUNT(*) AS total_data')
            ->from('members_skills')
            ->where('member_skill_id = :msid')
            ->where('user_id = :uid')
            ->setParameter(':msid', $routeInfo[2]['id'])
            ->setParameter(':uid', $_SESSION['MembershipAuth']['user_id'])
            ->execute();

        $owner = (int) $query->fetch()['total_data'];
        if ($owner < 1) {
            $this['flash']->flashLater('warning', 'Permission denied.');

            return $response->withStatus(302)
                ->withHeader('Location', $this['router']->pathFor('membership-profile'));
        }

        return $next($request, $response);
    }
}
