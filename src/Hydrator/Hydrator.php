<?php

namespace SergiX44\Nutgram\Hydrator;

interface Hydrator
{
    /**
     * @param  array|object  $data
     * @param  object  $instance
     * @return object
     */
    public function hydrate(array|object $data, object|string $instance): mixed;

    /**
     * @param  array  $data
     * @param  object  $instance
     * @return array
     */
    public function hydrateArray(array $data, object|string $instance): array;
}
