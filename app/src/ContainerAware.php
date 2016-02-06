<?php
namespace Membership;

use Slim\Container;
use BadMethodCallException;

/**
 * @property-read \Slim\Interfaces\CollectionInterface session
 * @property-read \Slim\Flash\Messages flash
 * @property-read \Slim\PDO\Database db
 * @property-read \Valitron\Validator validator
 * @property-read \Projek\Slim\Plates view
 * @property-read callable data
 * @property-read callable upload
 * @method Models data(string $class)
 * @method string[] upload(\Psr\Http\Message\UploadedFileInterface $file, array $data)
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

        throw new BadMethodCallException("Method $method is not a valid method");
    }

}
