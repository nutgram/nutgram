<?php


namespace SergiX44\Nutgram\RunningMode;

use JsonMapper;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

class Fake implements RunningMode
{

    private mixed $update;

    /**
     * Fake running mode constructor.
     * @param $update
     */
    public function __construct(mixed $update)
    {
        $this->update = $update;
    }

    public function processUpdates(Nutgram $bot): void
    {
        $update = $bot->getContainer()
            ->get(JsonMapper::class)
            ->map($this->update, new Update());

        $bot->processUpdate($update);
    }
}
