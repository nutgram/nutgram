<?php

namespace SergiX44\Nutgram\RunningMode;

use SergiX44\Nutgram\Hydrator\Hydrator;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

class Fake implements RunningMode
{
    /**
     * Fake running mode constructor.
     *
     * @param object|array|null $update
     */
    public function __construct(private object|array|null $update = null)
    {
    }

    /**
     * @param Nutgram $bot
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Throwable
     *
     * @return void
     */
    public function processUpdates(Nutgram $bot): void
    {
        if ($this->update instanceof Update) {
            $update = $this->update;
        } else {
            $update = $bot->getContainer()
                ->get(Hydrator::class)
                ->hydrate($this->update, Update::class);
        }

        $bot->processUpdate($update);
    }

    /**
     * @param mixed $update
     *
     * @return Fake
     */
    public function setUpdate(mixed $update): self
    {
        $this->update = $update;

        return $this;
    }
}
