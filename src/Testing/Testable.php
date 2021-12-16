<?php

namespace SergiX44\Nutgram\Testing;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;

/**
 * @mixin Nutgram
 */
trait Testable
{

    /**
     * @var array
     */
    protected array $testingHistory = [];

    /**
     * @param  mixed  $update
     * @param  array  $responses
     * @return Nutgram
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public static function fake(mixed $update = null, array $responses = []): static
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);

        $bot = new static(__CLASS__, [
            'client' => ['handler' => $handlerStack],
            'api_url' => '',
        ]);

        $bot->setRunningMode(new Fake($update));
        $bot->setupHistoryContainer($handlerStack);

        return $bot;
    }

    /**
     * @param  HandlerStack  $handlerStack
     */
    protected function setupHistoryContainer(HandlerStack $handlerStack): void
    {
        $history = Middleware::history($this->testingHistory);
        $handlerStack->push($history);
    }

    /**
     * @return array
     */
    public function getRequestHistory(): array
    {
        return $this->testingHistory;
    }
}
