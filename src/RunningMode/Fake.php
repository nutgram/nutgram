<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\RunningMode;

use InvalidArgumentException;
use SergiX44\Hydrator\Hydrator;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

class Fake implements RunningMode
{
    /**
     * Fake running mode constructor.
     * @param object|array|null $update
     */
    public function __construct(private object|array|null $update = null)
    {
    }

    /**
     * @param Nutgram $bot
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Throwable
     */
    public function processUpdates(Nutgram $bot): void
    {
        $update = match (true) {
            $this->update instanceof Update => $this->update,
            is_object($this->update),
            is_array($this->update) => new Hydrator($bot->getContainer())->hydrate(Update::class, $this->update),
            default => throw new InvalidArgumentException('Invalid update specified.')
        };

        $bot->processUpdate($update);
    }

    /**
     * @param mixed $update
     * @return Fake
     */
    public function setUpdate(mixed $update): Fake
    {
        $this->update = $update;
        return $this;
    }
}
