<?php
namespace Membership;

use Slim\Container;
use Slim\Exception\NotFoundException;

abstract class Controllers
{
    /**
     * Slim\Container instance
     *
     * @var \Slim\Container
     */
    private $container;

    /**
     * Create Controller\Base instance
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get \Slim\Container name
     *
     * @param  string $name Container Name
     * @return mixed
     * @throws \Slim\Exception\ContainerValueNotFoundException
     */
    public function __get($name)
    {
        return $this->container->get($name);
    }

    /**
     * Call \Slim\Container callable name
     *
     * @param  string $method Container Name
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($method, $params)
    {
        if ($this->container->has($method)) {
            $obj = $this->container->get($method);
            if (is_callable($obj)) {
                return call_user_func_array($obj, $params);
            }
        }

        throw new \BadMethodCallException("Method $method is not a valid method");
    }

    /**
     * Set Page main and sub title
     *
     * @param string $mainTitle     Main Page Title
     * @param string $subTitle      Sub Page Title
     * @param bool   $enableCaptcha Enable Captcha
     */
    protected function setPageTitle($mainTitle, $subTitle, $enableCaptcha = false)
    {
        $this->view->addData([
            'page_title' => $mainTitle,
            'sub_page_title' => $subTitle,
            'enable_captcha' => $enableCaptcha,
        ], 'layouts::system');
    }

    /**
     * Assert is XHR request
     *
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @throws \Slim\Exception\NotFoundException
     */
    protected function assertXhrRequest($request, $response)
    {
        if (!$request->isXhr()) {
            throw new NotFoundException($request, $response);
        }
    }
}
