<?php


namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Telegram\Types\Message;

abstract class CollectHandlers
{
    /**
     * @var array
     */
    protected array $globalMiddlewares = [];

    /**
     * @var array
     */
    protected array $handlers;

    /**
     * @param $callable
     */
    public function middleware($callable): void
    {
        array_unshift($this->globalMiddlewares, $callable);
    }

    /**
     * @param  string  $command
     * @param $callable
     * @return Handler
     */
    public function onCommand(string $command, $callable): Handler
    {
        $command = "/{$command}";

        return $this->handlers[Message::class][$command] = new Handler($callable, $command);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function onMessage($callable): Handler
    {
        return $this->handlers[Message::class][] = new Handler($callable);
    }

    /**
     * @param  string  $pattern
     * @param $callable
     * @return Handler
     */
    public function onText(string $pattern, $callable): Handler
    {
        return $this->handlers[Message::class][$pattern] = new Handler($callable);
    }

    public function onCallbackQuery($callable)
    {
    }

    public function onException($callable)
    {
    }
}
