<?php

namespace SergiX44\Nutgram\Testing;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;

trait Testable
{
    /** @var Nutgram */
    protected static $bot;

    protected MockHandler $mockHandler;

    /**
     * @var array
     */
    protected array $testingHistory = [];

    /**
     * @param  mixed  $update
     * @param  array  $responses
     * @return Testable
     */
    public static function instance(mixed $update = null, array $responses = []): static
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);

        self::$bot = new static(__CLASS__, [
            'client' => ['handler' => $handlerStack],
            'api_url' => '',
        ]);

        self::$bot->setRunningMode(new Fake($update));
        self::$bot->setupHistoryContainer($handlerStack);
        self::$bot->setMockHandler($mock);

        return self::$bot;
    }

    /**
     * @param  mixed|null  $update
     * @return $this
     */
    public function withUpdate(mixed $update = null): static
    {
        self::$bot->setRunningMode(new Fake($update));
        return $this;
    }

    /**
     * @param  int  $status
     * @param  array  $headers
     * @param  null  $body
     * @return FakeNutgram
     */
    public function withResponse(
        mixed $body = ['ok' => false, 'result' => null],
        int $status = 200,
        array $headers = [],
    ): static {
        $this->mockHandler->append(new Response($status, $headers, is_string($body) ? $body : json_encode($body, JSON_THROW_ON_ERROR)));
        return $this;
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

    /**
     * @param  MockHandler  $mockHandler
     * @return Testable
     */
    public function setMockHandler(MockHandler $mockHandler): static
    {
        $this->mockHandler = $mockHandler;
        return $this;
    }
}
