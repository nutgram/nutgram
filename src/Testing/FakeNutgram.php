<?php

namespace SergiX44\Nutgram\Testing;

use Exception;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;

/**
 * @method assertSendMessageCalled
 */
class FakeNutgram extends Nutgram
{
    /**
     * @var MockHandler
     */
    protected MockHandler $mockHandler;

    /**
     * @var array
     */
    protected array $testingHistory = [];

    /**
     * @param  mixed  $update
     * @param  array  $responses
     * @return FakeNutgram
     */
    public static function instance(mixed $update = null, array $responses = []): self
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);

        $bot = new self(__CLASS__, [
            'client' => ['handler' => $handlerStack],
            'api_url' => '',
        ]);

        $bot->setRunningMode(new Fake($update));
        $bot->setupHistoryContainer($handlerStack);
        $bot->setMockHandler($mock);

        return $bot;
    }

    /**
     * @param  mixed|null  $update
     * @return FakeNutgram
     */
    public function withUpdate(mixed $update = null): self
    {
        $this->setRunningMode(new Fake($update));
        return $this;
    }

    /**
     * @param  mixed  $body
     * @param  int  $status
     * @param  array  $headers
     * @return FakeNutgram
     */
    public function withResponse(
        mixed $body = ['ok' => false, 'result' => null],
        int $status = 200,
        array $headers = [],
    ): self {
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
     * @return FakeNutgram
     */
    public function setMockHandler(MockHandler $mockHandler): static
    {
        $this->mockHandler = $mockHandler;
        return $this;
    }

    /**
     * @param  string  $name
     * @param  array  $arguments
     * @return void
     * @throws Exception
     */
    public function __call(string $name, array $arguments)
    {
        $lowerName = strtolower($name);

        // begin assertion
        match (str_starts_with($lowerName, 'assert')) {
            str_ends_with($lowerName, 'called') => $this->assertApiMethodCalled($this->extractName($name, 'called'), $arguments),
            default => throw new Exception('Invalid assertion')
        };
    }

    /**
     * @param  string  $name
     * @param  string  $string
     * @return string
     */
    private function extractName(string $name, string $string): string
    {
        return lcfirst(str_ireplace(['assert', $string], '', $name));
    }

    /**
     * @param $method
     * @param $arguments
     * @return void
     */
    private function assertApiMethodCalled($method, $arguments)
    {
        dd($method);
    }
}
