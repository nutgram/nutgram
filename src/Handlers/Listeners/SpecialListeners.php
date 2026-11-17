<?php

declare(strict_types=1);

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
     * @param callable|class-string|array $callable
     * @return void
     */
    public function fallback($callable): void
    {
        $this->checkFinalized();
        $this->{$this->target}[self::FALLBACK][] = new Handler($callable);
    }

    /**
     * @param UpdateType $type
     * @param callable|class-string|array $callable
     * @return void
     */
    public function fallbackOn(UpdateType $type, $callable): void
    {
        $this->checkFinalized();
        $this->{$this->target}[self::FALLBACK][$type->value] = new Handler($callable, $type->value);
    }

    /**
     * @param class-string|callable|callable-string|array $callableOrException
     * @param callable|callable-string|array|null $callable
     * @return void
     */
    public function onException($callableOrException, $callable = null): void
    {
        $this->checkFinalized();
        $this->registerErrorHandlerFor(self::EXCEPTION, $callableOrException, $callable);
    }

    /**
     * @param callable|string $callableOrPattern
     * @param callable|null $callable
     * @return void
     */
    public function onApiError($callableOrPattern, $callable = null): void
    {
        $this->checkFinalized();
        $this->registerErrorHandlerFor(self::API_ERROR, $callableOrPattern, $callable);
    }

    /**
     * @param class-string<ApiException>|ApiException $exceptionClass
     * @return void
     */
    public function registerApiException(string|ApiException $exceptionClass): void
    {
        $this->checkFinalized();

        if (is_string($exceptionClass) && !is_subclass_of($exceptionClass, ApiException::class)) {
            throw new InvalidArgumentException(
                sprintf('The provided exception must be a subclass of %s.', ApiException::class)
            );
        }

        if ($exceptionClass::$pattern === null) {
            throw new InvalidArgumentException(
                sprintf('The $pattern must be defined on the class %s.', $exceptionClass)
            );
        }

        $this->registerErrorHandlerFor(self::API_ERROR, $exceptionClass::$pattern, $exceptionClass);
    }

    /**
     * @param callable|class-string|array $callable
     * @return void
     */
    public function beforeApiRequest($callable): void
    {
        $this->checkFinalized();
        $this->{$this->target}[self::BEFORE_API_REQUEST] = (new Handler($callable))->skipGlobalMiddlewares();
    }

    /**
     * @param callable|class-string|array $callable
     * @return void
     */
    public function afterApiRequest($callable): void
    {
        $this->checkFinalized();
        $this->{$this->target}[self::AFTER_API_REQUEST] = (new Handler($callable))->skipGlobalMiddlewares();
    }
}
