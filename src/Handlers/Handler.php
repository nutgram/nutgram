<?php


namespace SergiX44\Nutgram\Handlers;

use Illuminate\Support\Traits\Macroable;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Container\Container;
use SergiX44\Nutgram\Middleware\Link;
use SergiX44\Nutgram\Middleware\MiddlewareChain;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Support\Constraints;
use SergiX44\Nutgram\Support\Disable;
use SergiX44\Nutgram\Support\Taggable;

class Handler extends MiddlewareChain
{
    use Taggable, Macroable, Disable, Constraints;

    /**
     * Regex to capture named parameters.
     *
     * Valid:
     * - {name}
     * - {name1}
     * - {firstName}
     * - {first_name}
     * - {n123}
     * - {n}
     *
     * Invalid:
     * - {1} (reserved for quantifiers)
     * - {1,} (reserved for quantifiers)
     * - {1,2} (reserved for quantifiers)
     * - {1name} (must start with a letter)
     * - {_1name} (must start with a letter)
     */
    protected const PARAM_NAME_REGEX = '/{([a-zA-Z][_a-zA-Z\d]*)}/';

    /**
     * @var string|null
     */
    protected ?string $pattern;


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
     * @param Container $container
     * @return bool
     */
    public function matching(string $value, Container $container): bool
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
            array_shift($matches);

            $params = [];
            foreach ($matches as $k => $v) {
                if (is_numeric($k) && is_string(array_search($v, $matches, true))) {
                    continue;
                }
                $v = $v === '' ? null : $v;

                if (is_string($k) && $container->has("param.$k")) {
                    $v = $container->make("param.$k", [$v]);
                }

                $params[] = $v;
            }

            $this->setParameters(...$params);
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
}
