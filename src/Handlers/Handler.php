<?php


namespace SergiX44\Nutgram\Handlers;

use Illuminate\Support\Traits\Macroable;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Nutgram\Middleware\Link;
use SergiX44\Nutgram\Middleware\MiddlewareChain;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Support\Disable;
use SergiX44\Nutgram\Support\Taggable;

class Handler extends MiddlewareChain
{
    use Taggable, Macroable, Disable;

    /**
     * regular expression to capture named parameters but not quantifiers
     * captures {name}, but not {1}, {1,}, or {1,2}.
     */
    protected const PARAM_NAME_REGEX = '/{((?:(?!\d+,?\d?+)\w)+?)}/';

    /**
     * @var string|null
     */
    protected ?string $pattern;

    /**
     * @var array<string, string>
     */
    protected array $constraints = [];

    /**
     * @var array
     */
    protected array $parameters = [];

    /**
     * @var callable $callable
     */
    protected $callable;

    /**
     * @var bool
     */
    protected bool $skipGlobalMiddlewares = false;

    /**
     * @var array
     */
    protected array $skippedGlobalMiddlewares = [];

    /**
     * Handler constructor.
     * @param $callable
     * @param string|null $pattern
     */
    public function __construct($callable, ?string $pattern = null)
    {
        $this->pattern = $pattern;
        $this->callable = $callable;
        $this->head = new Link($this);
    }

    /**
     * @param string $value
     * @return bool
     */
    public function matching(string $value): bool
    {
        if ($this->pattern === null) {
            return false;
        }

        // sanitize pattern
        $pattern = str_replace('/', '\/', $this->pattern);

        // replace named parameters with regex
        $replaceRule = function ($matches) {
            $parameterName = $matches[1];
            $constraint = $this->constraints[$parameterName] ?? '.*';
            return sprintf("(?<%s>%s?)", $parameterName, $constraint);
        };
        $regex = '/^'.preg_replace_callback(self::PARAM_NAME_REGEX, $replaceRule, $pattern).'$/mu';

        // match + return only named parameters
        $regexMatched = (bool)preg_match($regex, $value, $matches, PREG_UNMATCHED_AS_NULL);
        if ($regexMatched) {
            array_walk($matches, fn (&$x) => $x = ($x === '' ? null : $x));
            array_shift($matches);
            $this->setParameters(...array_filter($matches, 'is_numeric', ARRAY_FILTER_USE_KEY));
        }

        return $regexMatched;
    }

    /**
     * @param array $parameters
     * @return Handler
     */
    public function setParameters(...$parameters): Handler
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     * @return Handler
     */
    public function addParameters(array $parameters): Handler
    {
        $this->parameters = [...$this->parameters, ...$parameters];
        return $this;
    }

    /**
     * @param Nutgram $bot
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(Nutgram $bot): mixed
    {
        try {
            return $bot->invoke($this->callable, ['bot' => $bot, ...$this->parameters]);
        } finally {
            $this->parameters = [];
        }
    }

    /**
     * Skip global middlewares.
     * If you want to skip a specific global middleware, use the "$middlewares" parameter.
     * @param array $middlewares
     * @return $this
     */
    public function skipGlobalMiddlewares(array $middlewares = []): Handler
    {
        $this->skipGlobalMiddlewares = true;
        $this->skippedGlobalMiddlewares = $middlewares;
        return $this;
    }

    /**
     * Returns true if the handler is skipping global middlewares.
     * @return bool
     */
    public function isSkippingGlobalMiddlewares(): bool
    {
        return $this->skipGlobalMiddlewares;
    }

    /**
     * Returns the skipped global middlewares.
     * @return array
     */
    public function getSkippedGlobalMiddlewares(): array
    {
        return $this->skippedGlobalMiddlewares;
    }

    /**
     * @return string|null
     */
    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    public function where(array|string $parameter, ?string $constraint = null): Handler
    {
        if (!is_array($parameter)) {
            $constraints = [$parameter => $constraint];
        } else {
            $constraints = $parameter;
        }

        $this->constraints = [...$this->constraints, ...$constraints];

        return $this;
    }
}
