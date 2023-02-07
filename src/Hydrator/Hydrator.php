<?php

namespace SergiX44\Nutgram\Hydrator;

interface Hydrator
{
    /**
     * @param  array|object  $data
     * @param  object|string  $instance
     * @return object
     */
    public function hydrate(array|object $data, object|string $instance): mixed;

    /**
     * @param  array  $data
     * @param  object|string  $instance
     * @return array
     */
    public function hydrateArray(array $data, object|string $instance): array;

    /**
     * @param  string  $class
     * @return object|null
     */
    public function getConcreteFor(string $class): ?object;
}
