<?php


namespace SergiX44\Nutgram\RunningMode;

use JsonMapper;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Update;

class Webhook implements RunningMode
{

    /**
     * @var JsonMapper
     */
    private JsonMapper $mapper;

    /**
     * Webhook constructor.
     * @param  JsonMapper  $mapper
     */
    public function __construct(JsonMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param  Nutgram  $bot
     * @throws \JsonMapper_Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function processUpdates(Nutgram $bot)
    {
        $input = file_get_contents('php://input');
        $update = $this->mapper->map(json_decode($input), new Update());
        $bot->processUpdate($update);
    }
}
