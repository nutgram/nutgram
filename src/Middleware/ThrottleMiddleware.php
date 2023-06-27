<?php

namespace SergiX44\Nutgram\Middleware;

use Psr\SimpleCache\CacheInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Support\RateLimiter;

class ThrottleMiddleware
{
    protected const CACHE_KEY = '__throttle';

    public function __invoke(Nutgram $bot, $next)
    {
        // if user is not set, skip this middleware
        if ($bot->userId() === null) {
            $next($bot);

            return;
        }

        //get throttle object
        $currentHandler = $bot->currentHandler();
        $throttle = $currentHandler?->getThrottle() ?? $bot->getThrottle();

        // if throttle is disabled, skip this middleware
        if ($throttle === null) {
            $next($bot);

            return;
        }

        // get throttle key
        $key = $currentHandler?->getThrottle() !== null ? $currentHandler?->getThrottleHash() : $bot->getThrottleHash();

        // get the rate limit key
        $rateLimitKey = $this->getRateLimitKey($key, $bot->userId());

        // init rate limiter
        /** @var CacheInterface $cache */
        $cache = $bot->getContainer()->get(CacheInterface::class);
        $rateLimiter = new RateLimiter($cache);

        // use the rate limiter
        $executed = $rateLimiter->attempt(
            key: $rateLimitKey,
            maxAttempts: $throttle->getAttempts(),
            callback: fn () => $next($bot),
            decaySeconds: $throttle->getDecay(),
        );

        // if the rate limit is not exceeded, remove the cache key
        if ($executed) {
            $cache->delete($rateLimitKey.':exceeded');
        }

        // if the rate limit is exceeded, send a message to the user only once
        if (!$executed && !$cache->has($rateLimitKey.':exceeded')) {
            // get the number of seconds until the rate limit is reset
            $seconds = $rateLimiter->availableIn($rateLimitKey);

            // if the message is a callback query, answer it
            if ($bot->isCallbackQuery()) {
                $bot->answerCallbackQuery();
            }

            // call throttle message closure
            $throttleMessageClosure = $bot::$throttleMessageClosure;

            // send a message to the user
            if ($throttleMessageClosure !== null) {
                $throttleMessageClosure($bot, $seconds);
            } else {
                $bot->sendMessage("Too many messages sent!\nYou may try again in $seconds seconds.");
            }

            // set the cache key to prevent sending the message again
            $cache->set($rateLimitKey.':exceeded', 1);
        }
    }

    protected function getRateLimitKey(string $key, int|string $userID): string
    {
        return sprintf("%s:%s:%d", self::CACHE_KEY, $key, $userID);
    }
}
