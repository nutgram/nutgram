<?php

namespace SergiX44\Nutgram\Handlers\Listeners;

use InvalidArgumentException;
use SergiX44\Nutgram\Exception\ApiException;
use SergiX44\Nutgram\Handlers\CollectHandlers;
use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;

/**
 * @mixin CollectHandlers
 */
trait SpecialListeners
{
    protected const FALLBACK = 'FALLBACK';
    protected const EXCEPTION = 'EXCEPTION';
    protected const BEFORE_API_REQUEST = 'BEFORE_API_REQUEST';
    protected const AFTER_API_REQUEST = 'AFTER_API_REQUEST';
    protected const API_ERROR = 'API_ERROR';

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
}
