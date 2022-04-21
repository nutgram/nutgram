<?php

namespace SergiX44\Nutgram\Hydrator;

class SunriseHydrator implements Hydrator
{
    private \Sunrise\Hydrator\Hydrator $mapper;

    public function __construct()
    {
        $this->mapper = new \Sunrise\Hydrator\Hydrator();
        $this->mapper->aliasSupport(false);
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
