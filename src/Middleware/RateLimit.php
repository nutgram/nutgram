<?php

namespace SergiX44\Nutgram\Middleware;

use Psr\SimpleCache\CacheInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Support\RateLimiter;

class RateLimit
{
    /**
     * @var null|callable(Nutgram $bot, int $availableIn): void
     */
    protected $warningCallback;

    public function __construct(
        protected int $maxAttempts,
        protected int $decaySeconds = 60,
        protected ?string $key = null,
        $warningCallback = null,
    ) {
        $this->warningCallback = $warningCallback ?? function (Nutgram $bot, int $availableIn) {
            $bot->sendMessage('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');

            if ($bot->isCallbackQuery()) {
                $bot->answerCallbackQuery();
            }
        };
    }

    public function __invoke(Nutgram $bot, $next): void
    {
        $userId = $bot->userId();
        $chatId = $bot->chatId();

        if ($userId === null || $chatId === null) {
            $next($bot);
            return;
        }

        $key = $this->key ?? $bot->currentHandler()?->getHash() ?? throw new \Exception('No rate limit key provided');
        $key = sprintf("%s:%s.%s", $key, $userId, $chatId);

        $cache = $bot->getContainer()->get(CacheInterface::class);
        $rateLimiter = new RateLimiter(
            cache: $cache,
            key: $key,
            maxAttempts: $this->maxAttempts,
            decaySeconds: $this->decaySeconds,
        );

        if ($rateLimiter->tooManyAttempts()) {
            if (!$cache->has($rateLimiter->getKey().':warning')) {
                $bot->invoke($this->warningCallback, [
                    'bot' => $bot,
                    'availableIn' => $rateLimiter->availableIn(),
                ]);
                $cache->set($rateLimiter->getKey().':warning', true);
            }

            return;
        }

        $cache->delete($rateLimiter->getKey().':warning');

        $rateLimiter->increment();

        $next($bot);
    }

    public function setKey(string $key): self
    {
        if ($this->key !== null) {
            return $this;
        }

        $this->key = $key;

        return $this;
    }
}
