<?php


namespace SergiX44\Nutgram\Conversations;

use Psr\SimpleCache\InvalidArgumentException;
use RuntimeException;
use SergiX44\Nutgram\Nutgram;

/**
 * Class Conversation
 * @package SergiX44\Nutgram\Conversation
 */
abstract class Conversation
{

    /**
     * @var bool
     */
    protected bool $skipHandlers = false;

    /**
     * @var bool
     */
    protected bool $skipMiddlewares = false;

    /**
     * @var string|null
     */
    protected ?string $step = 'start';

    /**
     * @var Nutgram|null
     */
    protected ?Nutgram $bot;

    /**
     * @param  Nutgram  $bot
     * @return static
     */
    public static function begin(Nutgram $bot): self
    {
        $instance = new static();
        $instance($bot);

        return $instance;
    }

    /**
     * @param  Nutgram  $bot
     */
    public function start(Nutgram $bot)
    {
        throw new RuntimeException('Attempt to start an empty conversation.');
    }

    /**
     * @param  string  $step
     * @return void
     * @throws InvalidArgumentException
     */
    protected function next(string $step): void
    {
        $this->step = $step;

        $this->bot->stepConversation($this);
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    protected function end(): void
    {
        $this->closing($this->bot);
        $this->bot->endConversation();
    }

    /**
     * @param  Nutgram  $bot
     */
    protected function closing(Nutgram $bot)
    {
    }

    /**
     * Invokes the correct conversation step.
     * @param  Nutgram  $bot
     * @return mixed
     */
    public function __invoke(Nutgram $bot): mixed
    {
        if (method_exists($this, $this->step)) {
            $this->bot = $bot;
            $method = $this->step;
            return $this->$method($this->bot);
        }

        throw new RuntimeException("Conversation step '$this->step' not found.");
    }

    /**
     * @param  Nutgram  $bot
     * @throws InvalidArgumentException
     */
    public function terminate(Nutgram $bot): void
    {
        $this->bot = $bot;
        $this->end();
    }

    /**
     * @param  bool  $skipHandlers
     * @return Conversation
     */
    protected function setSkipHandlers(bool $skipHandlers): self
    {
        $this->skipHandlers = $skipHandlers;

        return $this;
    }

    /**
     * @param  bool  $skipMiddlewares
     * @return Conversation
     */
    protected function setSkipMiddlewares(bool $skipMiddlewares): self
    {
        $this->skipMiddlewares = $skipMiddlewares;

        return $this;
    }

    /**
     * @return bool
     */
    public function skipHandlers(): bool
    {
        return $this->skipHandlers;
    }

    /**
     * @return bool
     */
    public function skipMiddlewares(): bool
    {
        return $this->skipMiddlewares;
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        $attributes = get_object_vars($this);
        unset($attributes['bot']);

        return $attributes;
    }
}
