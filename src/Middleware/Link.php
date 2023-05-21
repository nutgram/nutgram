<?php


namespace SergiX44\Nutgram\Middleware;

use Closure;
use Laravel\SerializableClosure\SerializableClosure;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Nutgram\Nutgram;

class Link
{
    /**
     * @var
     */
    private $callable;

    /**
     * @var Link|null
     */
    private ?Link $next;

    /**
     * Link constructor.
     * @param $callable
     * @param  Link|null  $next
     */
    public function __construct($callable, ?Link $next = null)
    {
        $this->callable = $callable;
        $this->next = $next;
    }

    /**
     * @param  Nutgram  $bot
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(Nutgram $bot): mixed
    {
        return call_user_func($bot->resolve($this->callable), $bot, $this->next);
    }

    public function __serialize(): array
    {
        return array_map(function ($property) {
            return $property instanceof Closure ? new SerializableClosure($property) : $property;
        }, get_object_vars($this));
    }
}
