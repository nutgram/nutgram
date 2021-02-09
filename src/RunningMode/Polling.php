<?php


namespace SergiX44\Nutgram\RunningMode;

use JsonMapper;
use SergiX44\Nutgram\Nutgram;

class Polling implements RunningMode
{
    /**
     * @var JsonMapper
     */
    private JsonMapper $mapper;

    /**
     * Polling constructor.
     * @param  JsonMapper  $mapper
     */
    public function __construct(JsonMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function processUpdates(Nutgram $bot)
    {
        while (true) {
            // process updates
        }
    }
}
