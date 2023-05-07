<?php


namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Exception\StatusFinalizedException;
use SergiX44\Nutgram\Handlers\Listeners\MessageListeners;
use SergiX44\Nutgram\Handlers\Listeners\UpdateListeners;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;

abstract class CollectHandlers
{
    use UpdateListeners, MessageListeners;

    protected const FALLBACK = 'FALLBACK';
    protected const EXCEPTION = 'EXCEPTION';
    protected const BEFORE_API_REQUEST = 'BEFORE_API_REQUEST';
    protected const AFTER_API_REQUEST = 'AFTER_API_REQUEST';
    protected const API_ERROR = 'API_ERROR';

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
        !$this->finalized ?: throw new StatusFinalizedException();
        array_unshift($this->globalMiddlewares, $callable);
    }

    /**
     * @param Array<callable|callable-string|array> $callable
     */
    public function middlewares($callable): void
    {
        !$this->finalized ?: throw new StatusFinalizedException();
        $middlewares = is_array($callable) ? $callable : [$callable];

        foreach ($middlewares as $middleware) {
            $this->middleware($middleware);
        }
    }

    public function group(callable $closure)
    {
        !$this->finalized ?: throw new StatusFinalizedException();
        return $this->groups[] = new HandlerGroup($closure);
    }

//    /**
//     * @param  callable|callable-string|array  $middlewares
//     * @param  callable  $closure
//     * @return void
//     */
//    public function group($middlewares, callable $closure): void
//    {
//        $middlewares = is_array($middlewares) ? array_reverse($middlewares) : [$middlewares];
//
//        // get the current group status
//        $beforeMyMiddlewares = $this->groupMiddlewares;
//        $beforeMyHandlers = $this->groupHandlers;
//
//        // reset the current group status
//        $this->groupHandlers = [];
//
//        // push new middlewares to the stack
//        $this->groupMiddlewares = [...$middlewares, ...$this->groupMiddlewares];
//
//        // get the current target
//        $previousTarget = $this->target;
//        $this->target = 'groupHandlers';
//        $closure($this);
//        // restore the parent target
//        $this->target = $previousTarget;
//
//        // apply the middleware stack to the current registered group handlers
//        array_walk_recursive($this->groupHandlers, function ($leaf) {
//            if ($leaf instanceof Handler) {
//                foreach ($this->groupMiddlewares as $middleware) {
//                    $leaf->middleware($middleware);
//                }
//            }
//        });
//
//        // commit the handlers
//        $this->handlers = array_merge_recursive($this->handlers, $this->groupHandlers);
//
//        // restore the status of the parent group, if any
//        $this->groupMiddlewares = $beforeMyMiddlewares;
//        $this->groupHandlers = $beforeMyHandlers;
//    }

    /**
     * @param callable|string $callableOrException
     * @param callable|null $callable
     * @return Handler
     */
    public function onException($callableOrException, $callable = null): Handler
    {
        !$this->finalized ?: throw new StatusFinalizedException();
        return $this->registerErrorHandlerFor(self::EXCEPTION, $callableOrException, $callable);
    }

    /**
     * @param callable|string $callableOrPattern
     * @param callable|null $callable
     * @return Handler
     */
    public function onApiError($callableOrPattern, $callable = null): Handler
    {
        !$this->finalized ?: throw new StatusFinalizedException();
        return $this->registerErrorHandlerFor(self::API_ERROR, $callableOrPattern, $callable);
    }

    /**
     * @param string $type
     * @param $callableOrPattern
     * @param $callable
     * @return Handler
     */
    private function registerErrorHandlerFor(string $type, $callableOrPattern, $callable = null): Handler
    {
        !$this->finalized ?: throw new StatusFinalizedException();

        if ($callable !== null) {
            return $this->{$this->target}[$type][$callableOrPattern] = new Handler($callable, $callableOrPattern);
        }

        return $this->{$this->target}[$type][] = new Handler($callableOrPattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function fallback($callable): Handler
    {
        return $this->{$this->target}[self::FALLBACK][] = new Handler($callable);
    }

    /**
     * @param UpdateType $type
     * @param $callable
     * @return Handler
     */
    public function fallbackOn(UpdateType $type, $callable): Handler
    {
        !$this->finalized ?: throw new StatusFinalizedException();
        return $this->{$this->target}[self::FALLBACK][$type->value] = new Handler($callable, $type->value);
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

    /**
     * @param $callable
     * @return Handler
     */
    public function beforeApiRequest($callable): Handler
    {
        !$this->finalized ?: throw new StatusFinalizedException();
        return $this->{$this->target}[self::BEFORE_API_REQUEST] = (new Handler($callable))->skipGlobalMiddlewares();
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function afterApiRequest($callable): Handler
    {
        !$this->finalized ?: throw new StatusFinalizedException();
        return $this->{$this->target}[self::AFTER_API_REQUEST] = (new Handler($callable))->skipGlobalMiddlewares();
    }
}
