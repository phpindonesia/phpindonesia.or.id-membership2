<?php

namespace Membership\Http;

use Projek\Slim\Plates;
use Slim\Interfaces\RouterInterface;
use Slim\Route;

class Response extends \Slim\Http\Response
{
    /**
     * @var \League\Plates\Engine
     */
    protected $view;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @param Plates $view
     * @return static
     */
    public function setView(Plates $view)
    {
        $this->view = $view->getPlates();

        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return static
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;

        return $this;
    }

    /**
     * Redirect to route
     *
     * @param string $name
     * @param array $args
     * @return static
     */
    public function withRedirectRoute($name, $args = [])
    {
        $clone = clone $this;

        return $clone->withRedirect($this->router->pathFor($name, $args));
    }

    /**
     * @param string $name
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function view($name, array $data = [])
    {
        return $this->write($this->view->render($name, $data));
    }
}
