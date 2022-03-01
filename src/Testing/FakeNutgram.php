<?php

namespace SergiX44\Nutgram\Testing;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\RequestInterface;
use ReflectionClass;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\RunningMode\RunningMode;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

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
     * @var array
     */
    protected array $partialReceives = [];

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
                    $reflectionClass = new ReflectionClass(self::class);
                    $method = $reflectionClass->getMethod($request->getUri());
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
     */
    public function setMockHandler(MockHandler $mockHandler): static
    {
        $this->mockHandler = $mockHandler;
        return $this;
    }

    /**
     * @param  string  $type
     * @param  array  $partialAttributes
     * @return $this
     */
    public function hears(string $type, array $partialAttributes = []): static
    {
        if (!in_array($type, UpdateTypes::all(), true)) {
            throw new InvalidArgumentException('The parameter "type" is not a valid update type.');
        }

        /** @var Update $update */
        $update = $this->getContainer()->get(Update::class);

        $update->{$type} = $this->typeFaker->fakeInstanceOf(UpdateTypes::classOf($type), $partialAttributes);

        return $this->hearsUpdate($update);
    }

    /**
     * @param  mixed  $update
     * @return $this
     */
    public function hearsUpdate(Update $update): static
    {
        $this->getContainer()->get(RunningMode::class)->setUpdate($update);

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
     * @param  string  $method
     * @param  int  $times
     * @return FakeNutgram
     */
    public function assertApiMethodCalled(string $method, int $times): self
    {
        $actual = 0;
        foreach ($this->testingHistory as $reqRes) {
            /** @var Request $request */
            [$request,] = array_values($reqRes);

            if ($request->getUri()->getPath() === $method) {
                $actual++;
            }
        }

        Assert::assertEquals($times, $actual);

        return $this;
    }

    /**
     * @param  string  $method
     * @param  mixed  $data
     * @param  int  $index
     * @return FakeNutgram
     */
    public function assertApiRequestContains(string $method, mixed $data, int $index = 0): self
    {
        $reqRes = $this->testingHistory[$index];

        /** @var Request $request */
        [$request,] = array_values($reqRes);

        Assert::assertSame($method, $request->getUri()->getPath());

        $actual = json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR);

        Assert::assertContains($data, $actual);

        return $this;
    }

    public function fireUp(): self
    {
        $this->run();

        return $this;
    }
}
