<?php

namespace SergiX44\Nutgram\Hydrator;

use Psr\Container\ContainerInterface;

interface Hydrator
{
    /**
     * @param  array|object  $data
     * @param  object  $instance
     * @return object
     */
    public function hydrate(array|object $data, object $instance): mixed;

    /**
     * @param  array  $data
     * @param  object  $instance
     * @return array
     */
    public function hydrateArray(array $data, object $instance): array;

    /**
     * @param  ContainerInterface  $container
     * @return void
     */
    public function setContainer(ContainerInterface $container): void;
}
