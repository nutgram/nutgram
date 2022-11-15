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
    public function hydrate(object|array $data, object $instance): mixed
    {
        return $this->mapper->hydrate($instance, $data);
    }

    /**
     * @inheritDoc
     */
    public function hydrateArray(array $data, object $instance): array
    {
        return array_map(
            fn ($obj) => $this->mapper->hydrate(clone $instance, $obj),
            $data
        );
    }
}
