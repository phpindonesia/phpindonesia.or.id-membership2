<?php
namespace Membership;

use Slim\Http\Request;
use Slim\Http\Response;

class Middleware
{
    use ContainerAware;

    /**
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param callable            $next
     * @return mixed
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

        if ($request->getContentType() == 'application/json') {
            $request = $request->withHeader('X-Requested-With', 'XMLHttpRequest');
        }

        return $next($request, $response);
    }

    /**
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param callable            $next
     * @return \Slim\Http\Response
     */
    public function authenticateRoute(Request $request, Response $response, callable $next)
    {
        $message = 'Permission denied, authentication required.';

        // Forward all XHR GET request
        if ($request->isXhr()) {
            if ($request->isGet() || $this->getOwnerId($request) !== false) {
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
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param callable            $next
     * @return \Slim\Http\Response
     */
    public function authorizePorfolioRoute(Request $request, Response $response, callable $next)
    {
        // Is request acceptable?
        if ($this->isAcceptable($request)) {
            return $next($request, $response);
        }

        // Validate request with existing model
        if (!$this->assertOwnership($request, Models\MemberPortfolios::class)) {
            $this->flash->addMessage('error', 'Permission denied, authorization required.');

            return $response->withRedirect($this->router->pathFor('membership-account'));
        }

        return $next($request, $response);
    }

    /**
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param callable            $next
     * @return \Slim\Http\Response
     */
    public function authorizeSkillRoute(Request $request, Response $response, callable $next)
    {
        // Is request acceptable?
        if ($this->isAcceptable($request)) {
            return $next($request, $response);
        }

        // Validate request with existing model
        if (!$this->assertOwnership($request, Models\MemberSkills::class)) {
            $this->flash->addMessage('error', 'Permission denied, authorization required.');

            return $response->withRedirect($this->router->pathFor('membership-account'));
        }

        return $next($request, $response);
    }

    /**
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param callable            $next
     * @return mixed
     */
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

    /**
     * @param \Slim\Http\Request $request
     * @return bool
     */
    private function isAcceptable(Request $request)
    {
        $args = $request->getAttribute('routeInfo')[2];

        return !$args || ($request->isXhr() && $request->isGet());
    }

    /**
     * @param \Slim\Http\Request $request
     * @param string             $model
     * @return bool
     */
    private function assertOwnership(Request $request, $model)
    {
        $data = $this->data($model);
        $args = $request->getAttribute('routeInfo')[2];

        if (!$ownerId = $this->getOwnerId($request)) {
            return false;
        }

        return (bool) $data->count([$data->primary() => (int) $args['id'], 'user_id' => $ownerId]);
    }

    /**
     * @param \Slim\Http\Request $request
     * @return bool|int
     */
    private function getOwnerId(Request $request)
    {
        // Simply grab it from session, if available :P
        if ($this->session->has('user_id')) {
            return (int) $this->session->get('user_id');
        }

        // Or use basic HTTP Auth.
        $serverParams = $request->getServerParams();
        $username = isset($serverParams["PHP_AUTH_USER"]) ? $serverParams["PHP_AUTH_USER"] : '';
        $password = isset($serverParams["PHP_AUTH_PW"])   ? $serverParams["PHP_AUTH_PW"]   : '';

        if (isset($serverParams['HTTP_AUTHORIZATION'])) {
            if (preg_match("/Basic\s+(.*)$/i", $serverParams['HTTP_AUTHORIZATION'], $matches)) {
                list($username, $password) = explode(':', base64_decode($matches[1]));
            }
        }

        $users = $this->data(Models\Users::class);
        $user  = $users->get([$users->primary(), 'password'], ['username' => $username])->fetch();
        $salt  = $this->settings->get('salt_pwd');

        // TODO: We need better password hashing :sweat_smile:
        if ($user['password'] === md5($salt . $password)) {
            return (int) $user[$users->primary()];
        }

        return false;
    }
}
