<?php


namespace SergiX44\Nutgram\Middleware;

abstract class MiddlewareChain
{
    protected mixed $head;

    /**
     * @param callable|class-string|array $callable
     * @return $this
     */
    public function middleware($callable): self
    {
        $next = $this->head;
        $this->head = new Link($callable, $next);

        return $this;
    }

    public function getHead(): mixed
    {
        return $this->head;
    }
}
