<?php


namespace SergiX44\Nutgram\Conversation;

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
     * @var string
     */
    protected string $step;

    /**
     * @var Nutgram|null
     */
    private ?Nutgram $bot;

    /**
     * @param  Nutgram  $bot
     * @return static
     */
    public static function begin(Nutgram $bot): Conversation
    {
        $instance = new static();
        $instance($bot);

        return $instance;
    }

    /**
     * @param  string  $step
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function next(string $step): void
    {
        $this->step = $step;

        $this->bot->stepConversation($this);
    }

    /**
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function end(): void
    {
        $this->bot->endConversation();
    }

    /**
     * Invokes the correct conversation step.
     * @param  Nutgram  $bot
     */
    public function __invoke(Nutgram $bot)
    {
        if ($this->step !== null) {
            $this->bot = $bot;
            $method = $this->step;
            $this->$method($this->bot);
        } else {
            throw new RuntimeException('Conversation step not defined.');
        }
    }

    /**
     * @param  bool  $skipHandlers
     * @return Conversation
     */
    protected function setSkipHandlers(bool $skipHandlers): Conversation
    {
        $this->skipHandlers = $skipHandlers;

        return $this;
    }

    /**
     * @param  bool  $skipMiddlewares
     * @return Conversation
     */
    protected function setSkipMiddlewares(bool $skipMiddlewares): Conversation
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
