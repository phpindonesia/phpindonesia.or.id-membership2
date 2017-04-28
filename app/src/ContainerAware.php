<?php

namespace Membership;

use Slim\Container;
use BadMethodCallException;

/**
 * @property-read \Slim\Interfaces\CollectionInterface session
 * @property-read \Slim\Flash\Messages flash
 * @property-read \Valitron\Validator validator
 * @property-read \Projek\Slim\Plates view
 * @property-read Mailer mailer
 * @property-read Database db
 * @property-read callable upload
 * @property-read callable setting
 * @method array|string setting(string $name, $default = null)
 * @method string[] upload(\Psr\Http\Message\UploadedFileInterface $file, array $database)
 */
trait ContainerAware
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
     * @param  string $method
     * @param  array $params
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

        throw new BadMethodCallException("Method $method is not a valid method");
    }

}
