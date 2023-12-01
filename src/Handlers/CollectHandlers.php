<?php


namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Exception\StatusFinalizedException;
use SergiX44\Nutgram\Handlers\Listeners\MessageListeners;
use SergiX44\Nutgram\Handlers\Listeners\SpecialHandlers;
use SergiX44\Nutgram\Handlers\Listeners\UpdateListeners;

abstract class CollectHandlers
{
    use UpdateListeners, MessageListeners, SpecialHandlers;

    /**
     * @var array
     */
    protected array $globalMiddlewares = [];

    /**
     * @var string
     */
    protected string $target = 'handlers';

    /**
     * @var array
     */
    protected array $handlers = [];

    /**
     * @var HandlerGroup[]
     */
    protected array $groups = [];

    /**
     * @var array
     */
    protected array $groupHandlers = [];

    /**
     * @var bool
     */
    protected bool $finalized = false;

    /**
     * @param callable|callable-string|array $callable
     */
    public function middleware($callable): void
    {
        $this->checkFinalized();
        array_unshift($this->globalMiddlewares, $callable);
    }

    /**
     * @param Array<callable|callable-string|array> $callable
     */
    public function middlewares($callable): void
    {
        $this->checkFinalized();
        $middlewares = is_array($callable) ? $callable : [$callable];

        foreach ($middlewares as $middleware) {
            $this->middleware($middleware);
        }
    }

    public function group(callable $closure): HandlerGroup
    {
        $this->checkFinalized();
        return $this->groups[] = new HandlerGroup($closure);
    }

    /**
     * @param string $type
     * @param $callableOrPattern
     * @param $callable
     * @return Handler
     */
    private function registerErrorHandlerFor(string $type, $callableOrPattern, $callable = null): Handler
    {
        if ($callable !== null) {
            return $this->{$this->target}[$type][$callableOrPattern] = new Handler($callable, $callableOrPattern);
        }

        return $this->{$this->target}[$type][] = new Handler($callableOrPattern);
    }

    /**
     * @param bool $exception
     * @param bool $apiError
     * @return void
     */
    public function clearErrorHandlers(bool $exception = true, bool $apiError = true): void
    {
        if ($exception) {
            $this->{$this->target}[self::EXCEPTION] = [];
        }

        if ($apiError) {
            $this->{$this->target}[self::API_ERROR] = [];
        }
    }

    private function checkFinalized(): void
    {
        !$this->finalized ?: throw new StatusFinalizedException();
    }
}
