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
    private array $parameters = [];

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
        $this->head = new Link($this);
    }

    /**
     * @param  string  $value
     * @return bool
     */
    public function matching(string $value): bool
    {
        if ($this->pattern === null) {
            return true;
        }

        $pattern = str_replace('/', '\/', $this->pattern);
        $regex = '/^'.preg_replace(self::PARAM_NAME_REGEX, '(?<$1>.*)', $pattern).' ?$/miu';

        $regexMatched = (bool) preg_match($regex, $value, $matches);
        if ($regexMatched) {
            $this->parameters = array_slice(array_unique($matches), 1);
        }

        return $regexMatched;
    }

    /**
     * @param  array  $parameters
     * @return Handler
     */
    public function setParameters(array $parameters): Handler
    {
        $this->parameters = $parameters;
        return $this;
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

    /**
     * @return string|null
     */
    public function getPattern(): ?string
    {
        return $this->pattern;
    }
}
