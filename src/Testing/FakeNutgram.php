<?php

namespace SergiX44\Nutgram\Testing;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\SimpleCache\CacheInterface;
use ReflectionClass;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;

class FakeNutgram extends Nutgram
{
    use Hears, Asserts;

    /**
     * @var MockHandler
     */
    protected MockHandler $mockHandler;

    /**
     * @var array
     */
    protected array $testingHistory = [];

    /**
     * @var array
     */
    protected array $partialReceives = [];

    /**
     * @var TypeFaker
     */
    protected TypeFaker $typeFaker;

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
        $bot->bindToInstance($handlerStack);
        $bot->setMockHandler($mock);

        return $bot;
    }

    /**
     * @param  HandlerStack  $handlerStack
     */
    protected function bindToInstance(HandlerStack $handlerStack): void
    {
        $this->typeFaker = new TypeFaker($this->getContainer());

        $handlerStack->push(function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                if ($this->mockHandler->count() === 0) {
                    [$partialResult, $ok] = array_pop($this->partialReceives) ?? [[], true];
                    $method = (new ReflectionClass(self::class))->getMethod($request->getUri());
                    $instance = $this->typeFaker->fakeInstanceOf(
                        $method->getReturnType()?->getName(),
                        $partialResult
                    );

                    $this->mockHandler->append(new Response(body: json_encode([
                        'ok' => $ok,
                        'result' => $instance
                    ], JSON_THROW_ON_ERROR)));
                }
                return $handler($request, $options);
            };
        }, 'handles_empty_queue');

        $handlerStack->push(Middleware::history($this->testingHistory));
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
     */
    public function setMockHandler(MockHandler $mockHandler): self
    {
        $this->mockHandler = $mockHandler;
        return $this;
    }

    /**
     * @param  array  $result
     * @param  bool  $ok
     * @return $this
     * @throws \JsonException
     */
    public function willReceive(array $result, bool $ok = true): self
    {
        $body = json_encode(compact('ok', 'result'), JSON_THROW_ON_ERROR);
        $this->mockHandler->append(new Response($ok ? 200 : 400, [], $body));

        return $this;
    }

    /**
     * @param  array  $result
     * @return $this
     */
    public function willReceivePartial(array $result, bool $ok = true): self
    {
        array_unshift($this->partialReceives, [$result, $ok]);

        return $this;
    }

    /**
     * @return $this
     */
    public function reply(): self
    {
        $this->testingHistory = [];

        $this->getContainer()
            ->get(CacheInterface::class)
            ->clear();

        $this->run();

        $this->partialReceives = [];

        return $this;
    }
}
