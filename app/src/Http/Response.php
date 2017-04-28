<?php

namespace Membership\Http;

use Projek\Slim\Plates;

class Response extends \Slim\Http\Response
{
    /**
     * @var \League\Plates\Engine
     */
    protected $view;

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
     * @param string $name
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function view($name, array $data = [])
    {
        return $this->write($this->view->render($name, $data));
    }
}
