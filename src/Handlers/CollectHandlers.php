<?php


namespace SergiX44\Nutgram\Handlers;

use InvalidArgumentException;
use SergiX44\Nutgram\Exception\ApiException;
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
     * @param callable|string $callableOrException
     * @param callable|null $callable
     * @return Handler
     */
    public function onException($callableOrException, $callable = null): Handler
    {
        $this->checkFinalized();
        return $this->registerErrorHandlerFor(self::EXCEPTION, $callableOrException, $callable);
    }

    /**
     * @param callable|string $callableOrPattern
     * @param callable|null $callable
     * @return Handler
     */
    public function onApiError($callableOrPattern, $callable = null): Handler
    {
        $this->checkFinalized();
        return $this->registerErrorHandlerFor(self::API_ERROR, $callableOrPattern, $callable);
    }

    /**
     * @param string $exceptionClass
     * @return Handler
     */
    public function registerApiException(string $exceptionClass): Handler
    {
        $this->checkFinalized();

        if (!is_subclass_of($exceptionClass, ApiException::class)) {
            throw new InvalidArgumentException(
                sprintf('The provided exception must be a subclass of %s.', ApiException::class)
            );
        }

        if ($exceptionClass::$pattern === null) {
            throw new InvalidArgumentException(
                sprintf('The $pattern must be defined on the class %s.', $exceptionClass)
            );
        }

        return $this->registerErrorHandlerFor(self::API_ERROR, $exceptionClass::$pattern, $exceptionClass);
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
        $this->checkFinalized();
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
        $this->checkFinalized();
        return $this->{$this->target}[self::BEFORE_API_REQUEST] = (new Handler($callable))->skipGlobalMiddlewares();
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function afterApiRequest($callable): Handler
    {
        $this->checkFinalized();
        return $this->{$this->target}[self::AFTER_API_REQUEST] = (new Handler($callable))->skipGlobalMiddlewares();
    }

    private function checkFinalized(): void
    {
        !$this->finalized ?: throw new StatusFinalizedException();
    }
}
