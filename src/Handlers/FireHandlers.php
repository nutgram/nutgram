<?php

namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use Throwable;

trait FireHandlers
{
    protected ?Handler $currentHandler = null;

    public function getCurrentHandler(): ?Handler
    {
        return $this->currentHandler;
    }

    /**
     * @param string $type
     * @param array $parameters
     * @return mixed
     * @throws Throwable
     */
    protected function fireHandlersBy(string $type, array $parameters = []): mixed
    {
        $handlers = [];
        $this->addHandlersBy($handlers, $type);
        return $this->fireHandlers($handlers, $parameters);
    }

    /**
     * @param array $handlers
     * @param array $parameters
     * @return mixed
     * @throws Throwable
     */
    protected function fireHandlers(array $handlers, array $parameters = []): mixed
    {
        $result = null;

        /** @var Handler $handler */
        foreach ($handlers as $handler) {
            try {
                $this->currentHandler = $handler;
                $result = $handler->addParameters($parameters)->getHead()($this);
            } catch (Throwable $e) {
                $this->fireExceptionHandlerBy(self::EXCEPTION, $e);
            }
        }
        $this->currentHandler = null;

        return $result;
    }

    /**
     * @param string $type
     * @param Throwable $e
     * @return mixed
     * @throws Throwable
     */
    protected function fireExceptionHandlerBy(string $type, Throwable $e): mixed
    {
        $handlers = [];

        if ($e instanceof TelegramException) {
            $this->addHandlersBy($handlers, $type, value: $e->getMessage());
        } else {
            $this->addHandlersBy($handlers, $type, $e::class);
        }

        if (empty($handlers)) {
            $this->addHandlersBy($handlers, $type);
        }

        if (empty($handlers)) {
            throw $e;
        }

        /** @var Handler $handler */
        $handler = array_shift($handlers)?->setParameters($e);
        return $handler($this);
    }
}
