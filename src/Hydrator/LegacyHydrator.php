<?php

namespace SergiX44\Nutgram\Hydrator;

use JsonMapper;

class LegacyHydrator implements Hydrator
{
    private JsonMapper $mapper;

    public function __construct()
    {
        $this->mapper = new JsonMapper();
        $this->mapper->undefinedPropertyHandler = static function ($object, $propName, $jsonValue): void {
            $object->{$propName} = $jsonValue;
        };
    }

    /**
     * @inheritDoc
     */
    public function hydrate(object|array $data, object $instance): mixed
    {
        return $this->mapper->map($data, $instance);
    }

    /**
     * @inheritDoc
     */
    public function hydrateArray(array $data, object $instance): array
    {
        return array_map(
            fn ($obj) => $this->mapper->map($obj, clone $instance),
            $data
        );
    }
}
