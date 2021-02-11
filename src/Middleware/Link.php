<?php


namespace SergiX44\Nutgram\Middleware;

use SergiX44\Nutgram\Nutgram;

class Link
{
    /**
     * @var
     */
    private $callable;

    /**
     * @var Link|null
     */
    private ?Link $next;

    /**
     * Link constructor.
     * @param $callable
     * @param  Link|null  $next
     */
    public function __construct($callable, ?Link $next = null)
    {
        $this->callable = $callable;
        $this->next = $next;
    }

    /**
     * @param  Nutgram  $bot
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __invoke(Nutgram $bot)
    {
        return call_user_func($bot->resolve($this->callable), $bot, $this->next);
    }
}
