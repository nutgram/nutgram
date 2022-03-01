<?php


namespace SergiX44\Nutgram\RunningMode;

use JsonMapper;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

class Fake implements RunningMode
{

    /**
     * Fake running mode constructor.
     * @param  string|null  $update
     */
    public function __construct(private mixed $update = null)
    {
    }

    public function processUpdates(Nutgram $bot): void
    {
        $update = $bot->getContainer()
            ->get(JsonMapper::class)
            ->map($this->update, $bot->getContainer()->get(Update::class));

        $bot->processUpdate($update);
    }

    /**
     * @param  mixed  $update
     * @return Fake
     */
    public function setUpdate(mixed $update): Fake
    {
        $this->update = $update;
        return $this;
    }
}
