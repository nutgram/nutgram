<?php


namespace SergiX44\Nutgram\Handlers;

use Closure;
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
     * @var array
     */
    protected array $handlers = [];

    /**
     * @var array
     */
    protected array $groupMiddlewares = [];

    public function middlewares($middleware, Closure $callable): void
    {
        if (!is_array($middleware)) {
            $middleware = [$middleware];
        }

        $this->groupMiddlewares[] = $middleware;
        $callable($this);
        array_pop($this->groupMiddlewares);
    }

    /**
     * @param $callable
     */
    public function middleware($callable): void
    {
        array_unshift($this->globalMiddlewares, $callable);
    }

    /**
     * @param  callable|string  $callableOrException
     * @param  callable|null  $callable
     * @return Handler
     */
    public function onException($callableOrException, $callable = null): Handler
    {
        if ($callable !== null) {
            return $this->handlers[self::EXCEPTION][$callableOrException] = new Handler(
                $callable,
                $callableOrException,
                groupMiddlewares: $this->groupMiddlewares
            );
        }

        return $this->handlers[self::EXCEPTION][] = new Handler(
            $callableOrException,
            groupMiddlewares: $this->groupMiddlewares
        );
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function beforeApiRequest($callable): Handler
    {
        return $this->handlers[self::BEFORE_API_REQUEST] = new Handler(
            $callable,
            groupMiddlewares: $this->groupMiddlewares
        );
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function afterApiRequest($callable): Handler
    {
        return $this->handlers[self::AFTER_API_REQUEST] = new Handler(
            $callable,
            groupMiddlewares: $this->groupMiddlewares
        );
    }

    /**
     * @param  callable|string  $callableOrPattern
     * @param  callable|null  $callable
     * @return Handler
     */
    public function onApiError($callableOrPattern, $callable = null): Handler
    {
        if ($callable !== null) {
            return $this->handlers[self::API_ERROR][$callableOrPattern] = new Handler(
                $callable,
                $callableOrPattern,
                groupMiddlewares: $this->groupMiddlewares
            );
        }

        return $this->handlers[self::API_ERROR][] = new Handler(
            $callableOrPattern,
            groupMiddlewares: $this->groupMiddlewares
        );
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function fallback($callable): Handler
    {
        return $this->handlers[self::FALLBACK][] = new Handler($callable, groupMiddlewares: $this->groupMiddlewares);
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
        return $this->handlers[self::FALLBACK][$type] = new Handler(
            $callable,
            $type,
            groupMiddlewares: $this->groupMiddlewares
        );
    }

    /**
     * @param  bool  $exception
     * @param  bool  $apiError
     * @return void
     */
    public function clearErrorHandlers(bool $exception = true, bool $apiError = true): void
    {
        if ($exception) {
            $this->handlers[self::EXCEPTION] = [];
        }

        if ($apiError) {
            $this->handlers[self::API_ERROR] = [];
        }
    }
}
