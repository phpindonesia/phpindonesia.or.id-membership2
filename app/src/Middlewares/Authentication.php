<?php
namespace Membership\Middlewares;

use Slim\Flash\Messages;
use Slim\Router;

class Authentication
{
    /**
     * @var array
     */
    private $publicRoutes = [];

    /**
     * @var \Slim\Flash\Messages
     */
    private $flash;

    /**
     * @var \Slim\Router
     */
    private $router;

    public function __construct(array $publicRoutes, Messages $flash, Router $router)
    {
        $this->publicRoutes = $publicRoutes;
        $this->flash = $flash;
        $this->router = $router;
    }

    public function __invoke($request, $response, $next)
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        if (!$this->assertContainPublicRoute($path) && !isset($_SESSION['MembershipAuth'])) {
            $this->flash->addMessage('error', 'You are not authenticated');
            return $response->withRedirect($this->router->pathFor('membership-login'));
        }

        return $next($request, $response);
    }

    private function assertContainPublicRoute($path)
    {
        $reqPath = $path;
        $contain = false;

        if ($reqPath != '/') {
            foreach ($this->publicRoutes as $route) {
                if ($route == '/') {
                    continue;
                }

                $route = str_replace('/', '\/', $route);
                if (preg_match('/'.$route.'/i', $reqPath)) {
                    $contain = true;
                    break;
                }
            }
        } else {
            $contain = true;
        }

        return $contain;
    }

    private function assertRouteOwnership($path)
    {
        $reqPath = $path;
        $contain = false;

        if ($reqPath != '/') {
            foreach ($this->publicRoutes as $route) {
                if ($route == '/') {
                    continue;
                }

                $route = str_replace('/', '\/', $route);
                if (preg_match('/'.$route.'/i', $reqPath)) {
                    $contain = true;
                    break;
                }
            }
        } else {
            $contain = true;
        }

        return $contain;
    }
}
