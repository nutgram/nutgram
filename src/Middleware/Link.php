<?php


namespace SergiX44\Nutgram\Middleware;


use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Nutgram;

class Link
{

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
     * @return false|mixed
     */
    public function __invoke(Nutgram $bot)
    {
        return call_user_func($this->callable, $bot, $this->next);
    }
}