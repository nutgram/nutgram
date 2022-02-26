<?php


namespace SergiX44\Nutgram\Tests\Fixtures;

use JsonMapper;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\RunningMode;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

class TestingRunningMode implements RunningMode
{
    /**
     * @var JsonMapper
     */
    private JsonMapper $mapper;

    private $update;

    /**
     * TestingRunningMode constructor.
     * @param $update
     */
    public function __construct($update)
    {
        $this->mapper = new JsonMapper();
        $this->update = $update;
    }

    public function processUpdates(Nutgram $bot): void
    {
        $bot->processUpdate($this->mapper->map($this->update, new Update($bot)));
    }
}
