<?php

namespace Membership\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Interfaces\InvocationStrategyInterface;

class ActionResolver implements InvocationStrategyInterface
{
    /**
     * @var Container|null
     */
    protected $container = null;

    /**
     * @inheritdoc
     */
    public function __invoke(
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    )
    {
        list($instance, $method) = $callable;

        $reflection = new \ReflectionMethod($instance, $method);
        $args = [];

        foreach ($routeArguments as $k => $v) {
            $request = $request->withAttribute($k, $v);
        }

        foreach ($reflection->getParameters() as $parameter) {
            if ($class = $parameter->getClass()) {
                $interfaces = $class->getInterfaceNames();

                if (in_array(ServerRequestInterface::class, $interfaces)) {
                    $args[] = $request;
                } elseif (in_array(ResponseInterface::class, $interfaces)) {
                    $args[] = $response;
                } else {
                    $interfaces[] = $class->getName();

                    foreach ($interfaces as $interface) {
                        if ($this->container->has($interface)) {
                            $args[] = $this->container->get($interface);
                        }
                    }
                }
            } elseif ($parameter->getName() === 'args') {
                $args[] = $routeArguments;
            } elseif (isset($routeArguments[$parameter->getName()])) {
                $args[] = $routeArguments[$parameter->getName()];
            } elseif ($this->container->has($parameter->getName())) {
                $args[] = $this->container->get($parameter->getName());
            }
        }

        return $reflection->invokeArgs($instance, $args);
    }

    public function withContainer(Container $container)
    {
        $this->container = $container;
    }
}
