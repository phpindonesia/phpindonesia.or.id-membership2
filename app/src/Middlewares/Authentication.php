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
        $basePath = $uri->getBasePath();
        $path = $uri->getPath();

        // $request_path = $basePath.$path;
        $request_path = $path;

        $contain = false;
        if ($request_path != '/') {
            foreach ($this->publicRoutes as $item) {
                if ($item == '/') {
                    continue;
                }

                $str_path = str_replace('/', '\/', $item);
                if (preg_match('/'.$str_path.'/i', $request_path)) {
                    $contain = true;
                    break;
                }
            }
        } else {
            $contain = true;
        }

        if (!$contain && !isset($_SESSION['MembershipAuth'])) {
            $this->flash->addMessage('error', 'You are not authenticated');

            return $response->withRedirect(
                $this->router->pathFor('membership-login')
            );
        }

        return $next($request, $response);
    }
}
