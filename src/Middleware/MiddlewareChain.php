<?php


namespace SergiX44\Nutgram\Middleware;

abstract class MiddlewareChain
{
    /**
     * @var
     */
    protected $chain;

    /**
     * @param $callable
     * @return $this
     */
    public function middleware($callable): self
    {
        $next = $this->chain;
        $this->chain = new Link($callable, $next);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChain()
    {
        return $this->chain;
    }
}
