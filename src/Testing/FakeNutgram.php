<?php

namespace SergiX44\Nutgram\Testing;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use JsonException;
use Psr\Http\Message\RequestInterface;
use Psr\SimpleCache\CacheInterface;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionUnionType;
use RuntimeException;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\User\User;
use function sodium_bin2base64;

class FakeNutgram extends Nutgram
{
    use Hears, Asserts;

    public const TOKEN = '123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11';

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
     * @var array
     */
    protected array $dumpHistory = [];

    /**
     * @var User|null
     */
    protected ?User $commonUser = null;

    /**
     * @var Chat|null
     */
    protected ?Chat $commonChat = null;

    /**
     * @param mixed $update
     * @param array $responses
     * @return FakeNutgram
     */
    public static function instance(
        array|object $update = null,
        array $responses = [],
        Configuration $config = null
    ): self {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);

        $c = [
            'client' => ['handler' => $handlerStack, 'base_uri' => ''],
            'api_url' => '',
        ];

        if ($config !== null) {
            $c = array_replace_recursive($config->toArray(), $c);
        }

        $bot = new self(self::TOKEN, Configuration::fromArray($c));

        $bot->setRunningMode(new Fake($update));

        self::inject($bot, $mock, $handlerStack);

        return $bot;
    }

    private static function inject(Nutgram $bot, MockHandler $mock, HandlerStack $handlerStack): void
    {
        (function () use ($handlerStack, $mock) {
            /** @psalm-scope-this \SergiX44\Nutgram\Testing\FakeNutgram */
            $this->mockHandler = $mock;
            $this->typeFaker = new TypeFaker($this->hydrator);

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
                            ->getMethod((string)$request->getUri())
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
    }

    /**
     * @return array
     */
    public function getRequestHistory(): array
    {
        return $this->testingHistory;
    }

    public function getDumpHistory(): array
    {
        return $this->dumpHistory;
    }

    /**
     * @param array|int|true $result
     * @param bool $ok
     * @return $this
     */
    public function willReceive(array|int|true $result, bool $ok = true): self
    {
        $body = json_encode(compact('ok', 'result'), JSON_THROW_ON_ERROR);
        $this->mockHandler->append(new Response($ok ? 200 : 400, [], $body));

        return $this;
    }

    /**
     * @param array|int|true $result
     * @param bool $ok
     * @return $this
     */
    public function willReceivePartial(array|int|true $result, bool $ok = true): self
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
     * @param bool $remember
     * @return $this
     */
    public function willStartConversation(bool $remember = true): self
    {
        $this->rememberUserAndChat = $remember;
        return $this;
    }

    /**
     * @return $this
     * @throws JsonException
     */
    public function dump(): self
    {
        print(str_repeat('-', 25));
        print("\e[32m Nutgram Request History Dump \e[39m");
        print(str_repeat('-', 25).PHP_EOL);
        $this->printHistory();
        print(sprintf("\n%s\n\n", str_repeat('-', 80)));
        $this->dumpHistory[] = preg_replace("/\033\[[^m]*m/", '', ob_get_contents());
        flush();
        ob_flush();

        return $this;
    }

    public function dd(): never
    {
        $this->dump();
        die();
    }

    public function getMethodsReturnTypes(): array
    {
        return $this->methodsReturnTypes;
    }

    protected function printHistory(): void
    {
        $history = $this->getRequestHistory();

        if (count($history) === 0) {
            print('Request history empty');
            return;
        }

        foreach ($history as $i => $item) {
            /** @var Request $request */
            [$request,] = array_values($item);

            $requestIndex = "[$i] ";
            print($requestIndex."\e[34m".$request->getUri()->getPath()."\e[39m".PHP_EOL);
            $content = json_encode(
                value: self::getActualData($request),
                flags: JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
            );
            print(preg_replace('/"(.+)":/', "\"\e[33m\${1}\e[39m\":", $content));

            if ($i < count($history) - 1) {
                print(PHP_EOL);
            }
        }
    }


    /**
     * @param string|string[] $middleware
     * @return $this
     */
    public function withoutMiddleware(string|array $middleware): self
    {
        $middleware = !is_array($middleware) ? [$middleware] : $middleware;
        $this->globalMiddlewares = array_filter($this->globalMiddlewares, function ($item) use ($middleware) {
            return !in_array($item, $middleware, true);
        });

        return $this;
    }

    /**
     * @param string|string[] $middleware
     * @return $this
     */
    public function overrideMiddleware(string|array $middleware): self
    {
        $middleware = !is_array($middleware) ? [$middleware] : $middleware;
        $this->globalMiddlewares = $middleware;

        return $this;
    }

    /**
     * Get the actual data from the request.
     * @param Request $request
     * @param array $mapping
     * @return array
     * @throws JsonException
     */
    public static function getActualData(Request $request, array $mapping = []): array
    {
        //get content type
        $contentType = $request->getHeaderLine('Content-Type');

        //get body
        $body = (string)$request->getBody();

        //get data from json
        if (str_contains($contentType, 'application/json')) {
            return json_decode($body, true, flags: JSON_THROW_ON_ERROR);
        }

        //get data from form data
        if (str_contains($contentType, 'multipart/form-data')) {
            $formData = FormDataParser::parse($request);
            $params = $formData->params;

            //remap types lost in the form data parser
            if (count($mapping) > 0) {
                array_walk_recursive($params, function (&$value, $key) use ($mapping) {
                    if (array_key_exists($key, $mapping)) {
                        $value = match (gettype($mapping[$key])) {
                            'integer' => filter_var($value, FILTER_VALIDATE_INT),
                            'double' => filter_var($value, FILTER_VALIDATE_FLOAT),
                            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
                            default => $value,
                        };
                    }
                });
            }
            return [...$params, ...$formData->files];
        }

        throw new InvalidArgumentException("Content-Type '$contentType' not supported");
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        $attributes = parent::__serialize();

        $conf = $attributes['config']->toArray();
        unset($conf['client']['handler']);
        $attributes['config'] = Configuration::fromArray($conf);

        return $attributes;
    }

    /**
     * @param array $data
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __unserialize(array $data): void
    {
        $mock = new MockHandler();
        $handlerStack = HandlerStack::create($mock);

        $conf = $data['config']->toArray();
        $conf['client']['handler'] = $handlerStack;
        $data['config'] = Configuration::fromArray($conf);

        parent::__unserialize($data);
        self::inject($this, $mock, $handlerStack);
    }

    /**
     * Generates webapp data + hash.
     * @param array $data The data to generate webapp data from.
     * @return string The generated webapp data as query string.
     * @internal For testing purposes only.
     */
    public function generateWebAppData(array $data): string
    {
        $queryString = http_build_query(array_filter($data));

        [$sortedData] = self::parseQueryString($queryString, ['hash']);
        $secretKey = $this->createHashHmac(self::TOKEN, 'WebAppData');
        $hash = bin2hex($this->createHashHmac($sortedData, $secretKey));

        return $queryString.'&hash='.$hash;
    }

    /**
     * Generates webapp data for third party + signature.
     * @param int $botId The bot id.
     * @param array $data The generated webapp data as query string.
     * @return array
     * @internal For testing purposes only.
     */
    public static function generateWebAppDataForThirdParty(int $botId, array $data): array
    {
        if (!extension_loaded('sodium')) {
            throw new RuntimeException('Sodium extension is required for this method');
        }

        // generate keypair
        $keyPair = sodium_crypto_sign_keypair();

        // generate secret key
        $secretKey = sodium_crypto_sign_secretkey($keyPair);

        // generate public key (hex)
        $publicKey = sodium_bin2hex(sodium_crypto_sign_publickey($keyPair));

        // generate signature
        $queryString = http_build_query(array_filter($data));
        [$sortedData] = self::parseQueryString($queryString, ['hash', 'signature']);
        $dataCheckString = sprintf("%s:WebAppData\n%s", $botId, $sortedData);
        $signature = sodium_crypto_sign_detached($dataCheckString, $secretKey);
        $signature = sodium_bin2base64($signature, SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING);
        $initData = $queryString.'&signature='.$signature.'&hash=test';

        return [$initData, $publicKey];
    }

    /**
     * Generates login data + hash.
     * @param array $data The data to generate login data from.
     * @return string The generated login data as query string.
     * @internal For testing purposes only.
     */
    public function generateLoginData(array $data): string
    {
        $queryString = http_build_query(array_filter($data));

        [$sortedData] = self::parseQueryString($queryString, ['hash']);
        $secretKey = $this->createHash(self::TOKEN);
        $hash = bin2hex($this->createHashHmac($sortedData, $secretKey));

        return $queryString.'&hash='.$hash;
    }
}
