<?php

declare(strict_types=1);

namespace SergiX44\Nutgram;

use Closure;
use DateInterval;
use Laravel\SerializableClosure\SerializableClosure;
use Psr\Clock\ClockInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\SimpleCache\CacheInterface;
use SergiX44\Hydrator\HydratorInterface;
use SergiX44\Nutgram\Cache\Adapters\ArrayCache;
use SergiX44\Nutgram\Hydrator\NutgramHydrator;
use SergiX44\Nutgram\Support\SystemClock;

/**
 * Nutgram Configuration Class.
 * @see https://nutgram.dev/docs/configuration/installation#configuration
 */
final readonly class Configuration
{
    public const string DEFAULT_API_URL = 'https://api.telegram.org';
    public const int DEFAULT_POLLING_TIMEOUT = 10;
    public const int DEFAULT_POLLING_LIMIT = 100;
    public const int DEFAULT_CLIENT_TIMEOUT = 5;
    public const string DEFAULT_HYDRATOR = NutgramHydrator::class;
    public const string DEFAULT_CACHE = ArrayCache::class;
    public const string DEFAULT_LOGGER = NullLogger::class;
    public const array DEFAULT_ALLOWED_UPDATES = [
        'message',
        'edited_message',
        'channel_post',
        'edited_channel_post',
        'business_connection',
        'business_message',
        'edited_business_message',
        'deleted_business_messages',
        'message_reaction',
        'message_reaction_count',
        'inline_query',
        'chosen_inline_result',
        'callback_query',
        'shipping_query',
        'pre_checkout_query',
        'purchased_paid_media',
        'poll',
        'poll_answer',
        'my_chat_member',
        'chat_member',
        'chat_join_request',
        'chat_boost',
        'removed_chat_boost',
    ];
    public const bool DEFAULT_ENABLE_HTTP2 = true;
    public const int DEFAULT_CONVERSATION_TTL = 43200;
    public const string DEFAULT_CLOCK = SystemClock::class;

    /**
     * @param string $apiUrl Useful if you need to change to a local or different API server. WARNING: If the server does not support HTTP/2, remember to disable enableHttp2 in the configuration.
     * @param int|null $botId Bot ID. It will be automatically retrieved from the bot token if not specified.
     * @param string|null $botName Useful when the bot is a group bot (with {@see https://core.telegram.org/bots/features#privacy-mode Group Privacy} disabled) and you need to specify the bot name.
     * @param bool $testEnv Enable test environments useful when working with {@see https://core.telegram.org/bots/webapps#testing-web-apps Web Apps}.
     * @param bool $isLocal Enable the local mode when used along a self-hosted Telegram Bot API server. Nutgram will copy the file from your Telegram Bot API server instead downloading it. WARNING: If your local server does not support HTTP/2, remember to disable enableHttp2 in the configuration.
     * @param int $clientTimeout In seconds, define the timeout when sending requests to the Telegram API.
     * @param array<string, mixed> $clientOptions An array of options for the underlying {@see https://docs.guzzlephp.org/en/stable/quickstart.html Guzzle HTTP client}. Checkout the Guzzle documentation for further informations.
     * @param ContainerInterface|null $container Delegate container to resolve dependencies.
     * @param HydratorInterface|class-string $hydrator TODO: TO REMOVE Nutgram is too coupled to nutgram/hydrator. Remove.
     * @param CacheInterface|class-string $cache The object used to store conversation and data, must implements the PSR-16 CacheInterface.
     * @param LoggerInterface|class-string $logger The logger used to log debug http requests. Check out the {@see https://nutgram.dev/docs/configuration/logging Logging page} for other info.
     * @param array<string, string>|Closure|class-string|null $localPathTransformer Useful if you need to remap a relative file path when used along is_local config.
     * @param int $pollingTimeout In seconds, define the timeout when polling updates from the Telegram API.
     * @param list<string> $pollingAllowedUpdates Define the allowed updates to be retrieved from the Telegram API.
     * @param int $pollingLimit Define the maximum number of updates to be retrieved from the Telegram API.
     * @param bool $enableHttp2 Enable HTTP/2 support
     * @param DateInterval|int|null $conversationTtl The time-to-live for a conversation in seconds or a DateInterval object. Set to null to disable the TTL.
     * @param ClockInterface|string $clock TODO: TO REMOVE. Do not expose. Just replace in FakeNutgram
     * @param array<string, mixed> $extra Extra configuration parameters.
     */
    public function __construct(
        public string $apiUrl = self::DEFAULT_API_URL,
        public ?int $botId = null,
        public ?string $botName = null,
        public bool $testEnv = false,
        public bool $isLocal = false,
        public int $clientTimeout = self::DEFAULT_CLIENT_TIMEOUT,
        public array $clientOptions = [],
        public ?ContainerInterface $container = null,
        public HydratorInterface|string $hydrator = self::DEFAULT_HYDRATOR,
        public CacheInterface|string $cache = self::DEFAULT_CACHE,
        public string|LoggerInterface $logger = self::DEFAULT_LOGGER,
        public array|Closure|string|null $localPathTransformer = null,
        public int $pollingTimeout = self::DEFAULT_POLLING_TIMEOUT,
        public array $pollingAllowedUpdates = self::DEFAULT_ALLOWED_UPDATES,
        public int $pollingLimit = self::DEFAULT_POLLING_LIMIT,
        public bool $enableHttp2 = self::DEFAULT_ENABLE_HTTP2,
        public DateInterval|int|null $conversationTtl = self::DEFAULT_CONVERSATION_TTL,
        public ClockInterface|string $clock = self::DEFAULT_CLOCK,
        public array $extra = [],
    ) {
    }

    /**
     * Create a configuration from an array.
     * @param array<string, mixed> $config
     * @return self
     */
    public static function fromArray(array $config): self
    {
        return new self(
            apiUrl: $config['api_url'] ?? self::DEFAULT_API_URL,
            botId: $config['bot_id'] ?? null,
            botName: $config['bot_name'] ?? null,
            testEnv: $config['test_env'] ?? false,
            isLocal: $config['is_local'] ?? false,
            clientTimeout: $config['timeout'] ?? self::DEFAULT_CLIENT_TIMEOUT,
            clientOptions: $config['client'] ?? [],
            container: $config['container'] ?? null,
            hydrator: $config['hydrator'] ?? self::DEFAULT_HYDRATOR,
            cache: $config['cache'] ?? self::DEFAULT_CACHE,
            logger: $config['logger'] ?? self::DEFAULT_LOGGER,
            localPathTransformer: $config['local_path_transformer'] ?? null,
            pollingTimeout: $config['polling']['timeout'] ?? self::DEFAULT_POLLING_TIMEOUT,
            pollingAllowedUpdates: $config['polling']['allowed_updates'] ?? self::DEFAULT_ALLOWED_UPDATES,
            pollingLimit: $config['polling']['limit'] ?? self::DEFAULT_POLLING_LIMIT,
            enableHttp2: $config['enable_http2'] ?? self::DEFAULT_ENABLE_HTTP2,
            conversationTtl: array_key_exists('conversation_ttl', $config)
                ? $config['conversation_ttl']
                : self::DEFAULT_CONVERSATION_TTL,
            clock: $config['clock'] ?? self::DEFAULT_CLOCK,
            extra: $config['extra'] ?? [],
        );
    }

    /**
     * Returns the configuration as an array.
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'api_url' => $this->apiUrl,
            'bot_id' => $this->botId,
            'bot_name' => $this->botName,
            'test_env' => $this->testEnv,
            'is_local' => $this->isLocal,
            'timeout' => $this->clientTimeout,
            'client' => $this->clientOptions,
            'container' => $this->container,
            'hydrator' => $this->hydrator,
            'cache' => $this->cache,
            'logger' => $this->logger,
            'local_path_transformer' => $this->localPathTransformer,
            'enable_http2' => $this->enableHttp2,
            'polling' => [
                'timeout' => $this->pollingTimeout,
                'limit' => $this->pollingLimit,
                'allowed_updates' => $this->pollingAllowedUpdates,
            ],
            'conversation_ttl' => $this->conversationTtl,
            'clock' => $this->clock,
            'extra' => $this->extra,
        ];
    }

    public function __serialize(): array
    {
        $data = get_object_vars($this);

        unset($data['cache'], $data['extra'], $data['container']);

        if ($this->logger instanceof LoggerInterface) {
            unset($data['logger']);
        }

        if ($this->localPathTransformer instanceof Closure) {
            $data['localPathTransformer'] = new SerializableClosure($this->localPathTransformer);
        }

        return $data;
    }

    /**
     * @param array<string, mixed> $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $data['cache'] = self::DEFAULT_CACHE;
        $data['extra'] = [];
        $data['container'] = null;

        if (!isset($data['logger'])) {
            $data['logger'] = self::DEFAULT_LOGGER;
        }

        if ($data['localPathTransformer'] instanceof SerializableClosure) {
            $data['localPathTransformer'] = $data['localPathTransformer']->getClosure();
        }

        foreach ($data as $attribute => $value) {
            $this->{$attribute} = $value;
        }
    }

    public function __get(string $name): mixed
    {
        return $this->extra[$name] ?? null;
    }
}
