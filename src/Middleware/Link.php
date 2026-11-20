<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Middleware;

use SergiX44\Nutgram\Nutgram;

class Link
{
    /**
     * @var callable|class-string|array
     */
    private $callable;

    private ?Link $next;

    /**
     * Link constructor.
     * @param callable|class-string|array $callable
     */
    public function __construct($callable, ?Link $next = null)
    {
        $this->callable = $callable;
        $this->next = $next;
    }

    public function __invoke(Nutgram $bot): mixed
    {
        return $bot->invoke($this->callable, ['bot' => $bot, $this->next]);
    }
}
