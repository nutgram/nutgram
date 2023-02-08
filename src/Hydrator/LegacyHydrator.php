<?php

namespace SergiX44\Nutgram\Hydrator;

use JsonMapper;

class LegacyHydrator implements Hydrator
{
    private JsonMapper $mapper;

    public function __construct()
    {
        $this->mapper = new JsonMapper();
    }

    /**
     * @inheritDoc
     */
    public function hydrate(object|array $data, object|string $instance): mixed
    {
        return $this->mapper->map($data, $instance);
    }

    /**
     * @inheritDoc
     */
    public function hydrateArray(array $data, object|string $instance): array
    {
        return array_map(
            fn ($obj) => $this->mapper->map($obj, clone $instance),
            $data
        );
    }

    public function getConcreteFor(string $class): ?object
    {
        return null;
    }
}
