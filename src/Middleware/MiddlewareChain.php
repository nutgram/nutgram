<?php


namespace SergiX44\Nutgram\Middleware;

abstract class MiddlewareChain
{
    /**
     * @var
     */
    protected mixed $head;

    /**
     * @param $callable
     * @return $this
     */
    public function middleware($callable): self
    {
        $next = $this->head;
        $this->head = new Link($callable, $next);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHead(): mixed
    {
        return $this->head;
    }
}
