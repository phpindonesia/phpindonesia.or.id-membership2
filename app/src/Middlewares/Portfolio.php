<?php
namespace Membership\Middlewares;

class Portfolio
{
    public function __invoke($request, $response, $next)
    {
        $routeInfo = $request->getAttribute('routeInfo');
        $query = $this->db->select('count(*) num', 'user_id', 'member_portfolio_id')
            ->from('members_portfolios')
            ->where('member_portfolio_id = :portId')
            ->where('user_id = :userId')
            ->setParameter(':portId', $routeInfo[2]['id'])
            ->setParameter(':userId', $_SESSION['MembershipAuth']['user_id'])
            ->execute();

        $user = $query->fetch();

        if ($user['num'] < 1) {
            $this->flash->flashLater('warning', 'Permission denied.');
            return $res->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-profile'));
        }

        return $next($request, $response);
    }
}
