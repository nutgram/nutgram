<?php

namespace SergiX44\Nutgram\Testing;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\SimpleCache\CacheInterface;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionUnionType;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\User\User;

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
     * @var bool
     */
    private bool $rememberUserAndChat = false;

    /**
     * @var User|null
     */
    private ?User $storedUser = null;

    /**
     * @var Chat|null
     */
    private ?Chat $storedChat = null;

    /**
     * @var array
     */
    private array $methodsReturnTypes = [];

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

        (function () use ($handlerStack, $mock) {
            /** @psalm-scope-this SergiX44\Nutgram\Testing\FakeNutgram */
            $this->mockHandler = $mock;
            $this->typeFaker = new TypeFaker($this->getContainer());

            $properties = (new ReflectionClass(Client::class))->getMethods(ReflectionMethod::IS_PUBLIC);

            foreach ($properties as $property) {
                $return = $property->getReturnType();
                if ($return instanceof ReflectionNamedType) {
                    $this->methodsReturnTypes[$property->getReturnType()?->getName()][] = $property->getName();
                }

                if ($return instanceof ReflectionUnionType) {
                    foreach ($return->getTypes() as $type) {
                        $this->methodsReturnTypes[$type->getName()][] = $property->getName();
                    }
                }
            }
            $handlerStack->push(Middleware::history($this->testingHistory));
            $handlerStack->push(function (callable $handler) {
                return function (RequestInterface $request, array $options) use ($handler) {
                    if ($this->mockHandler->count() === 0) {
                        [$partialResult, $ok] = array_pop($this->partialReceives) ?? [[], true];
                        $return = (new ReflectionClass(self::class))
                            ->getMethod($request->getUri())
                            ->getReturnType();

                        $instance = null;
                        if ($return instanceof ReflectionNamedType) {
                            $instance = $this->typeFaker->fakeInstanceOf(
                                $return->getName(),
                                $partialResult
                            );
                        } elseif ($return instanceof ReflectionUnionType) {
                            foreach ($return->getTypes() as $type) {
                                $instance = $this->typeFaker->fakeInstanceOf(
                                    $type,
                                    $partialResult
                                );
                                if (is_object($instance)) {
                                    break;
                                }
                            }
                        }

                        $this->mockHandler->append(new Response(body: json_encode([
                            'ok' => $ok,
                            'result' => $instance,
                        ], JSON_THROW_ON_ERROR)));
                    }
                    return $handler($request, $options);
                };
            }, 'handles_empty_queue');
        })->call($bot);

        return $bot;
    }

    /**
     * @return array
     */
    public function getRequestHistory(): array
    {
        return $this->testingHistory;
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

        $this->run();

        $this->partialReceives = [];

        return $this;
    }

    /**
     * @return $this
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function clearCache(): self
    {
        $this->getContainer()
            ->get(CacheInterface::class)
            ->clear();

        return $this;
    }

    /**
     * @return $this
     */
    public function willStartConversation($remember = true): self
    {
        $this->rememberUserAndChat = $remember;
        return $this;
    }

    public function dump(): self
    {
        print(str_repeat('-', 25));
        print("\e[32m Nutgram Request History Dump \e[39m");
        print(str_repeat('-', 25) . PHP_EOL);

        if (count($this->getRequestHistory()) > 0) {
            foreach ($this->getRequestHistory() as $i => $item) {
                /** @var Request $request */
                [$request,] = array_values($item);

                $requestIndex = "[$i] > ";
                print($requestIndex . "\e[34m" . $request->getUri()->getPath() . "\e[39m" . PHP_EOL);
                print(str_repeat(' ', strlen($requestIndex)));
                print($request->getBody());

                if ($i < count($this->getRequestHistory()) - 1) {
                    print(PHP_EOL);
                }
            }
        } else {
            print('Request history empty');
        }

        print(PHP_EOL);
        print(str_repeat('-', 80) . PHP_EOL);
        print(PHP_EOL);
        flush();
        ob_flush();

        return $this;
    }

    public function dd(): self
    {
        $this->dump();
        die();
    }
}
