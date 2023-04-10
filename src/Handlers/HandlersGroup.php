<?php

namespace SergiX44\Nutgram\Handlers;

class HandlersGroup
{
    protected array $handlers;
    private bool $skipGlobalMiddlewares;
    protected array $skippedGlobalMiddlewares;

    public function __construct(array $handlers = [])
    {
        $this->handlers = $handlers;
        $this->skipGlobalMiddlewares = false;
        $this->skippedGlobalMiddlewares = [];
    }

    public function skipGlobalMiddlewares(array $middlewares = []): void
    {
        $this->skipGlobalMiddlewares = true;
        $this->skippedGlobalMiddlewares = $middlewares;
    }

    public function evaluateGroupMethods(): void
    {
        if (!$this->skipGlobalMiddlewares) {
            return;
        }

        array_walk_recursive($this->handlers, function ($handler) {
            if ($handler instanceof Handler) {
                $handler->skipGlobalMiddlewares($this->skippedGlobalMiddlewares);
            }
        });
    }
}
