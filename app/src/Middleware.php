<?php
namespace Membership;

use Slim\Http\Request;
use Slim\Http\Response;

class Middleware
{
    use ContainerAware;

    public function sanitizeRequestBody(Request $request, Response $response, callable $next)
    {
        if ($inputs = $request->getParsedBody()) {
            $inputs = array_filter($inputs, function (&$value) {
                if (is_string($value)) {
                    $value = filter_var(trim($value), FILTER_SANITIZE_STRING);
                }
                return $value ?: null;
            });

            if (isset($inputs['_METHOD']) && $request->getMethod() == $inputs['_METHOD']) {
                unset($inputs['_METHOD']);
            }

            $request = $request->withParsedBody($inputs);
        }

        if ($request->getContentType() == 'application/json') {
            $request = $request->withHeader('X-Requested-With', 'XMLHttpRequest');
        }

        return $next($request, $response);
    }

    public function authorizeAccountRoute(Request $request, Response $response, callable $next)
    {
        // Forward all XHR request
        if ($request->isXhr() && $request->isGet()) {
            return $next($request, $response);
        }

        // Authorize account middleware
        if (!$this->session->has('user_id')) {
            $this->flash->addMessage('error', 'You are not authenticated');

            return $response->withRedirect($this->router->pathFor('membership-login'));
        }

        return $next($request, $response);
    }

    public function authorizePorfolioRoute(Request $request, Response $response, callable $next)
    {
        // Authorize portfolio middleware
        $args = $request->getAttribute('routeInfo')[2];

        if (!$args || ($request->isXhr() && $request->isGet())) {
            return $next($request, $response);
        }

        $count = $this->data(Models\MemberPortfolios::class)->count([
            'member_portfolio_id' => (int) $args['id'],
            'user_id' => $this->session->get('user_id'),
        ]);

        if ($count < 1) {
            $this->flash->addMessage('warning', 'Permission denied.');

            return $response->withRedirect($this->router->pathFor('membership-account'));
        }

        return $next($request, $response);
    }

    public function authorizeSkillRoute(Request $request, Response $response, callable $next)
    {
        // Authorize portfolio middleware
        $args = $request->getAttribute('routeInfo')[2];

        if (!$args || ($request->isXhr() && $request->isGet())) {
            return $next($request, $response);
        }

        $count = $this->data(Models\MemberSkills::class)->count([
            'member_skill_id' => (int) $args['id'],
            'user_id' => $this->session->get('user_id'),
        ]);

        if ($count < 1) {
            $this->flash->addMessage('warning', 'Permission denied.');

            return $response->withRedirect($this->router->pathFor('membership-account'));
        }

        return $next($request, $response);
    }

    public function normalizeProfile(Request $request, Response $response, callable $next)
    {
        $routeInfo = $request->getAttribute('routeInfo');
        $args = $routeInfo[2];

        if (substr($args['username'], -5) == '.json') {
            $routeInfo[2]['username'] = substr($args['username'], 0, -5);

            $request = $request
                ->withAttribute('routeInfo', $routeInfo)
                ->withHeader('X-Requested-With', 'XMLHttpRequest');
        }

        return $next($request, $response);
    }
}
