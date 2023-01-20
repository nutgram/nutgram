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
     * @var array
     */
    protected array $handlers = [];

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
            return $this->handlers[self::EXCEPTION][$callableOrException] = new Handler($callable, $callableOrException);
        }

        return $this->handlers[self::EXCEPTION][] = new Handler($callableOrException);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function beforeApiRequest($callable): Handler
    {
        return $this->handlers[self::BEFORE_API_REQUEST][] = new Handler($callable);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function afterApiRequest($callable): Handler
    {
        return $this->handlers[self::AFTER_API_REQUEST][] = new Handler($callable);
    }

    /**
     * @param  callable|string  $callableOrPattern
     * @param  callable|null  $callable
     * @return Handler
     */
    public function onApiError($callableOrPattern, $callable = null): Handler
    {
        if ($callable !== null) {
            return $this->handlers[self::API_ERROR][$callableOrPattern] = new Handler($callable, $callableOrPattern);
        }

        return $this->handlers[self::API_ERROR][] = new Handler($callableOrPattern);
    }

    /**
     * @param $callable
     * @return Handler
     */
    public function fallback($callable): Handler
    {
        return $this->handlers[self::FALLBACK][] = new Handler($callable);
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
        return $this->handlers[self::FALLBACK][$type] = new Handler($callable, $type);
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
