<?php


namespace SergiX44\Nutgram\Handlers;


use SergiX44\Nutgram\Middleware\MiddlewareChain;
use SergiX44\Nutgram\Middleware\Link;
use SergiX44\Nutgram\Nutgram;

class Handler extends MiddlewareChain
{

    private $pattern;

    private $callable;

    /**
     * Handler constructor.
     * @param $callable
     * @param  string|null  $pattern
     */
    public function __construct($callable, ?string $pattern = null)
    {
        $this->pattern = $pattern;
        $this->callable = $callable;
        $this->chain = new Link($this);
    }

    /**
     * @param  Nutgram  $bot
     * @return false|mixed
     */
    public function __invoke(Nutgram $bot)
    {
        return call_user_func($this->callable, $bot);
    }

}