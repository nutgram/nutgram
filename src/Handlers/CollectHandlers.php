<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Handlers;

use SergiX44\Container\Container;
use SergiX44\Nutgram\Exception\StatusFinalizedException;
use SergiX44\Nutgram\Handlers\Listeners\MessageListeners;
use SergiX44\Nutgram\Handlers\Listeners\SpecialListeners;
use SergiX44\Nutgram\Handlers\Listeners\UpdateListeners;
use SergiX44\Nutgram\Support\InteractsWithRateLimit;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

abstract class CollectHandlers
{
    use UpdateListeners, MessageListeners, SpecialListeners, InteractsWithRateLimit;

    /**
     * @var list<callable>
     */
    protected array $globalMiddlewares = [];

    /**
     * @var string
     */
    protected string $target = 'handlers';

    /**
     * @var array<string, callable>|array<string, array<string, callable>>
     */
    protected array $handlers = [];

    /**
     * @var HandlerGroup[]
     */
    protected array $groups = [];

    /**
     * @var array<string, callable>|array<string, array<string, callable>>
     */
    protected array $groupHandlers = [];

    protected bool $finalized = false;

    abstract public function getContainer(): Container;

    /**
     * @param callable $callable
     */
    public function middleware($callable): void
    {
        $this->checkFinalized();
        array_unshift($this->globalMiddlewares, $callable);
    }

    /**
     * @param list<callable> $callables
     */
    public function middlewares($callables): void
    {
        $this->checkFinalized();

        foreach ($callables as $callable) {
            $this->middleware($callable);
        }
    }

    public function group(callable $closure): HandlerGroup
    {
        $this->checkFinalized();
        return $this->groups[] = new HandlerGroup($closure);
    }

    /**
     * @param string $type
     * @param callable|string $callableOrPattern
     * @param callable|null $callable
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

    /**
     * @param callable $callable
     * @return Handler
     */
    public function onUpdate($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[Update::class] = new Handler($callable);
    }
}
