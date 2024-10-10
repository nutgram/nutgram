<?php

namespace SergiX44\Nutgram\Hydrator;

use Psr\Container\ContainerInterface;

class NutgramHydrator implements Hydrator
{
    private \SergiX44\Hydrator\Hydrator $mapper;

    public function __construct(ContainerInterface $container)
    {
        $this->mapper = new \SergiX44\Hydrator\Hydrator($container);
    }

    /**
     * @inheritDoc
     */
    public function hydrate(object|array $data, object|string $instance): mixed
    {
        return $this->mapper->hydrate($instance, $data);
    }

    /**
     * @inheritDoc
     */
    public function hydrateArray(array $data, object|string $instance): array
    {
        return array_map(function ($obj) use ($instance): mixed {
            return $this->mapper->hydrate(is_object($instance) ? clone $instance : $instance, $obj);
        }, $data);
    }

    /**
     * @inheritDoc
     */
    public function getConcreteFor(string $class): ?object
    {
        return $this->mapper->getConcreteResolverFor($class);
    }
}
