<?php
namespace Membership\Middlewares;

use Slim\Http\Request;
use Slim\Http\Response;

class Portfolio
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $routeInfo = $request->getAttribute('routeInfo');
        $query = $this->db->select('count(*) num', 'user_id', 'member_portfolio_id')
            ->from('members_portfolios')
            ->where('member_portfolio_id', '=', $routeInfo[2]['id'])
            ->where('user_id', '=', $_SESSION['MembershipAuth']['user_id'])
            ->execute();

        $user = $query->fetch();

        if ($user['num'] < 1) {
            $this->flash->flashLater('warning', 'Permission denied.');
            return $res->withStatus(302)->withHeader('Location', $this->router->pathFor('membership-profile'));
        }

        return $next($request, $response);
    }
}
