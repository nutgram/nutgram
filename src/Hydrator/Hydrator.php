<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Hydrator;

interface Hydrator
{
    /**
     * @template T of object
     * @param array|object $data
     * @param T|class-string<T> $instance
     * @return T
     */
    public function hydrate(array|object $data, object|string $instance): mixed;

    /**
     * @template T of object
     * @param array $data
     * @param T|class-string<T> $instance
     * @return array<array-key,T>
     */
    public function hydrateArray(array $data, object|string $instance): array;

    /**
     * @param class-string $class
     * @return object|null
     */
    public function getConcreteFor(string $class): ?object;
}
