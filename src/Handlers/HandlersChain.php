<?php


namespace SergiX44\Nutgram\Handlers;


use DI\Container;
use SergiX44\Nutgram\Middleware\MiddlewareChain;
use SergiX44\Nutgram\Telegram\Types\Message;

abstract class HandlersChain extends MiddlewareChain
{
    /**
     * @var Container
     */
    protected Container $container;

    protected array $handlers;

    public function onCommand(string $command, $callable)
    {
        $handler = new Handler($callable, $command);
        $this->handlers[Message::class][$command] = $handler;
        return $handler;
    }

    public function onMessage($callable)
    {
        $handler = new Handler($callable);
        $this->handlers[Message::class][] = $handler;
        return $handler;
    }

    public function onText(string $pattern, $callable)
    {

    }

    public function onCallbackQuery($callable)
    {

    }

    public function onException($callable)
    {

    }

}