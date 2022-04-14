<?php

namespace SergiX44\Nutgram\Mapper;

class JsonMapper implements Mapper
{
    private \JsonMapper $mapper;

    /**
     * @param  \JsonMapper  $mapper
     */
    public function __construct(\JsonMapper $mapper)
    {
        $this->mapper = $mapper;
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
