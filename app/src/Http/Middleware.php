<?php

namespace Membership\Http;

use Membership\ContainerAware;
use Membership\Models\MemberPortfolios;
use Membership\Models\MemberSkills;
use Membership\Models\Users;

class Middleware
{
    use ContainerAware;

    /**
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
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

        if ($request->getHeaderLine('Accept') == 'application/json') {
            $request = $request->withHeader('X-Requested-With', 'XMLHttpRequest');
        }

        return $next($request, $response);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function authenticateRoute(Request $request, Response $response, callable $next)
    {
        $message = 'Permission denied, authentication required.';

        // Forward all XHR GET request
        if ($request->isXhr()) {
            if ($this->getOwnerId($request) !== false) {
                return $next($request, $response);
            }

            return $response->withJson(['message' => $message], 401);
        }

        // Check user session
        if ($this->getOwnerId($request) === false) {
            $this->flash->addMessage('error', $message);

            return $response->withRedirect($this->router->pathFor('membership-login'));
        }

        return $next($request, $response);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function authorizePorfolioRoute(Request $request, Response $response, callable $next)
    {
        // Is request acceptable?
        if ($this->isAcceptable($request)) {
            return $next($request, $response);
        }

        // Validate request with existing model
        if (!$this->authorizeOwnership($request, MemberPortfolios::class)) {
            return $this->responseWithDenial($request, $response);
        }

        return $next($request, $response);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function authorizeSkillRoute(Request $request, Response $response, callable $next)
    {
        // Is request acceptable?
        if ($this->isAcceptable($request)) {
            return $next($request, $response);
        }

        // Validate request with existing model
        if (!$this->authorizeOwnership($request, MemberSkills::class)) {
            return $this->responseWithDenial($request, $response);
        }

        return $next($request, $response);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    private function responseWithDenial(Request $request, Response $response)
    {
        $message = 'Permission denied, authorization required.';

        // Response with json if XHR request
        if ($request->isXhr()) {
            return $response->withJson(['message' => $message], 401);
        }

        // Response with redirect if otherwise
        $this->flash->addMessage('error', $message);

        return $response->withRedirect($this->router->pathFor('membership-account'));
    }

    /**
     * @param Request  $request
     * @return bool
     */
    private function isAcceptable(Request $request)
    {
        $args = $request->getAttribute('routeInfo')[2];

        return !$args || ($request->isXhr() && $request->isGet());
    }

    /**
     * @param Request $request
     * @param string  $model
     * @return bool
     */
    private function authorizeOwnership(Request $request, $model)
    {
        $data = new $model;
        $args = $request->getAttribute('routeInfo')[2];

        if (!$ownerId = $this->getOwnerId($request)) {
            return false;
        }

        return (bool) $data->count([$data->primary() => (int) $args['id'], 'user_id' => $ownerId]);
    }

    /**
     * @param Request $request
     * @return bool|int
     */
    private function getOwnerId(Request $request)
    {
        // Simply grab it from session, if available :P
        if ($this->session->has('user_id')) {
            return (int) $this->session->get('user_id');
        }

        // Or use HTTP Basic Auth.
        $serverParams = $request->getServerParams();
        $username = isset($serverParams['PHP_AUTH_USER']) ? $serverParams['PHP_AUTH_USER'] : '';
        $password = isset($serverParams['PHP_AUTH_PW'])   ? $serverParams['PHP_AUTH_PW']   : '';

        if (isset($serverParams['HTTP_AUTHORIZATION'])) {
            if (preg_match("/Basic\s+(.*)$/i", $serverParams['HTTP_AUTHORIZATION'], $matches)) {
                list($username, $password) = explode(':', base64_decode($matches[1]));
            }
        }

        $users = new Users;
        $user  = $users->get([$users->primary(), 'password', 'username'], ['username' => $username])->fetch();
        $salt  = $this->settings->get('salt_pwd');

        // TODO: We need better password hashing :sweat_smile:
        if ($user['password'] === md5($salt . $password)) {
            $userId = (int) $user[$users->primary()];

            $this->session->set('user_id', $userId);
            $this->session->set('username', $user['username']);

            return $userId;
        }

        return false;
    }
}
