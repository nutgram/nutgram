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
    public function hydrate(object|array $data, object|string $instance): object|string
    {
        return $this->mapper->hydrate($instance, $data);
    }

    /**
     * @inheritDoc
     */
    public function hydrateArray(array $data, object|string $instance): array
    {
        return array_map(
            fn ($obj) => $this->mapper->hydrate(is_string($instance) ? $instance : clone $instance, $obj),
            $data
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function getConcreteFor(string $class): ?object
    {
        return $this->mapper->getConcreteResolverFor($class);
    }
}
