<?php

namespace SergiX44\Nutgram\Support;

use SergiX44\Nutgram\Middleware\RateLimit;

trait InteractWithRateLimit
{
    public function throttle(int $maxAttempts, int $decaySeconds = 60, ?string $key = null): self
    {
        /*
        |---------------------------------------------------------------------------------
        | TODO: nope. we should find a way to add the middleware to the top of the stack
        |---------------------------------------------------------------------------------
        | maybe we can declare a rateLimit = null property and then
        | add the middleware to the top of the stack after the bot initialization
        |
        | also, we should add a way to add a global rate limit to the bot and must be
        | to the top of the stack too. it's applied globally to all handlers
        */

        $this->middleware(new RateLimit(
            maxAttempts: $maxAttempts,
            decaySeconds: $decaySeconds,
            key: $key,
        ));

        return $this;
    }
}
