<?php


namespace SergiX44\Nutgram\Handlers;

use InvalidArgumentException;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;

abstract class CollectHandlers
{
    use UpdateHandlers, MessageHandlers;

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
    protected array $groupHandlers = [];

    /**
     * @var array
     */
    protected array $groupMiddlewares = [];

    /**
     * @var array
     */
    protected array $handlers = [];

    /**
     * @param  callable|callable-string|array  $callable
     */
    public function middleware($callable): void
    {
        array_unshift($this->globalMiddlewares, $callable);
    }

    /**
     * @param  Array<callable|callable-string|array>  $callable
     */
    public function middlewares($callable): void
    {
        $middlewares = is_array($callable) ? $callable : [$callable];

        foreach ($middlewares as $middleware) {
            $this->middleware($middleware);
        }
    }

    /**
     * @param  callable|callable-string|array  $middlewares
     * @param  callable  $closure
     * @return void
     */
    public function group($middlewares, callable $closure): void
    {
        $middlewares = is_array($middlewares) ? array_reverse($middlewares) : [$middlewares];

        // get the current group status
        $beforeMyMiddlewares = $this->groupMiddlewares;
        $beforeMyHandlers = $this->groupHandlers;

        // reset the current group status
        $this->groupHandlers = [];

        // push new middlewares to the stack
        $this->groupMiddlewares = array_merge($middlewares, $this->groupMiddlewares);

        // get the current target
        $previousTarget = $this->target;
        $this->target = 'groupHandlers';
        $closure($this);
        // restore the parent target
        $this->target = $previousTarget;

        // apply the middleware stack to the current registered group handlers
        array_walk_recursive($this->groupHandlers, function ($leaf) {
            if ($leaf instanceof Handler) {
                foreach ($this->groupMiddlewares as $middleware) {
                    $leaf->middleware($middleware);
                }
            }
        });

        // commit the handlers
        $this->handlers = array_merge_recursive($this->handlers, $this->groupHandlers);

        // restore the status of the parent group, if any
        $this->groupMiddlewares = $beforeMyMiddlewares;
        $this->groupHandlers = $beforeMyHandlers;
    }

    /**
     * @param  callable|string  $callableOrException
     * @param  callable|null  $callable
     * @return Handler
     */
    public function onException($callableOrException, $callable = null): Handler
    {
        return $this->registerErrorHandlerFor(self::EXCEPTION, $callableOrException, $callable);
    }

    /**
     * @param  callable|string  $callableOrPattern
     * @param  callable|null  $callable
     * @return Handler
     */
    public function onApiError($callableOrPattern, $callable = null): Handler
    {
        return $this->registerErrorHandlerFor(self::API_ERROR, $callableOrPattern, $callable);
    }

    /**
     * @param  string  $type
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
     * @param $callable
     * @return Handler
     */
    public function fallback($callable): Handler
    {
        return $this->{$this->target}[self::FALLBACK][] = new Handler($callable);
    }

    /**
     * @param  string  $type
     * @param $callable
     * @return Handler
     */
    public function fallbackOn(string $type, $callable): Handler
    {
        if (!in_array($type, UpdateTypes::all(), true)) {
            throw new InvalidArgumentException('The parameter "type" is not a valid update type.');
        }
        return $this->{$this->target}[self::FALLBACK][$type] = new Handler($callable, $type);
    }

    /**
     * @param  bool  $exception
     * @param  bool  $apiError
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
        return $this->{$this->target}[self::BEFORE_API_REQUEST] = (new Handler($callable))->skipGlobalMiddlewares();
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function afterApiRequest($callable): Handler
    {
        return $this->{$this->target}[self::AFTER_API_REQUEST] = (new Handler($callable))->skipGlobalMiddlewares();
    }
}
