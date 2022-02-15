<?php

namespace SergiX44\Nutgram\Testing;

use Exception;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\RunningMode\RunningMode;
use function PHPUnit\Framework\assertContains;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;

/**
 * @method assertSendMessageCalled(int $times): self
 * @method assertSendMessageContains(mixed $expected, ?int $index = 0): self
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
     * @var bool
     */
    private bool $hasRun = false;

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
            'client' => ['handler' => $handlerStack, 'base_uri' => ''],
            'api_url' => '',
        ]);

        $bot->setRunningMode(new Fake($update));
        $bot->setupHistoryContainer($handlerStack);
        $bot->setMockHandler($mock);

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
     * @param  mixed  $update
     * @return $this
     */
    public function hears(mixed $update): static
    {
        $update = is_string($update) ? json_decode($update, flags: JSON_THROW_ON_ERROR) : $update;
        $this->getContainer()->get(RunningMode::class)->setUpdate($update);

        return $this;
    }

    /**
     * @param  object|array  $result
     * @param  bool  $ok
     * @return $this
     * @throws \JsonException
     */
    public function willReceive(object|array $result, bool $ok = true): self
    {
        $body = json_encode(compact('ok', 'result'), JSON_THROW_ON_ERROR);
        $this->mockHandler->append(new Response($ok ? 200 : 400, [], $body));

        return $this;
    }

    /**
     * @param  string  $name
     * @param  array  $arguments
     * @return self
     * @throws \JsonException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __call(string $name, array $arguments): self
    {
        if (!$this->hasRun) {
            $this->run();
            $this->hasRun = true;
        }

        $lowerName = strtolower($name);

        // begin assertion
        match (str_starts_with($lowerName, 'assert')) {
            str_ends_with($lowerName, 'called') => $this->assertApiMethodCalled($this->extractName($name, 'called'), $arguments),
            str_ends_with($lowerName, 'contains') => $this->assertApiMethodContains($this->extractName($name, 'contains'), $arguments),
            default => throw new Exception('Invalid assertion')
        };

        return $this;
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
     * @param  string  $method
     * @param  array  $arguments
     * @return void
     */
    private function assertApiMethodCalled(string $method, array $arguments): void
    {
        [$expected,] = $arguments;

        $actual = 0;
        foreach ($this->testingHistory as $reqRes) {
            /** @var Request $request */
            [$request,] = array_values($reqRes);

            if ($request->getUri()->getPath() === $method) {
                $actual++;
            }
        }

        assertEquals($expected, $actual);
    }

    /**
     * @param  string  $method
     * @param  array  $arguments
     * @return void
     * @throws \JsonException
     */
    private function assertApiMethodContains(string $method, array $arguments): void
    {
        $reqRes = $this->testingHistory[$arguments[1] ?? 0];

        /** @var Request $request */
        [$request,] = array_values($reqRes);

        assertSame($method, $request->getUri()->getPath());

        $data = json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR);

        assertContains($arguments[0] ?? [], $data);
    }
}
