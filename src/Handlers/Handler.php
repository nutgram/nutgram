<?php


namespace SergiX44\Nutgram\Handlers;

use SergiX44\Nutgram\Middleware\Link;
use SergiX44\Nutgram\Middleware\MiddlewareChain;
use SergiX44\Nutgram\Nutgram;

class Handler extends MiddlewareChain
{
    /**
     * regular expression to capture named parameters but not quantifiers
     * captures {name}, but not {1}, {1,}, or {1,2}.
     */
    protected const PARAM_NAME_REGEX = '/\{((?:(?!\d+,?\d+?)\w)+?)\}/';

    /**
     * @var string|null
     */
    private ?string $pattern;

    /**
     * @var array
     */
    private array $parameters;

    private $callable;

    /**
     * Handler constructor.
     * @param $callable
     * @param  string|null  $pattern
     */
    public function __construct($callable, ?string $pattern = null)
    {
        $this->pattern = $pattern;
        $this->callable = $callable;
        $this->chain = new Link($this);
    }

    /**
     * @param  string  $pattern
     * @param  string  $value
     * @return bool
     */
    public function matching(string $pattern, string $value): bool
    {
        $pattern = str_replace('/', '\/', $pattern);
        $regex = '/^'.preg_replace(self::PARAM_NAME_REGEX, '(?<$1>.*)', $pattern).' ?$/miu';

        $regexMatched = (bool) preg_match($regex, $value, $matches);
        if ($regexMatched) {
            $this->parameters = array_slice(array_unique($matches), 1);
        }

        return $regexMatched;
    }

    /**
     * @param  Nutgram  $bot
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __invoke(Nutgram $bot)
    {
        return call_user_func($bot->resolve($this->callable), $bot, ...$this->parameters);
    }
}
