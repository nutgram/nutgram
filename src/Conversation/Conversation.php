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
     * @var Nutgram
     */
    private Nutgram $bot;

    public function __construct(Nutgram $bot)
    {
        $this->bot = $bot;
    }

    /**
     * @param  Nutgram  $bot
     * @return static
     */
    public static function begin(Nutgram $bot)
    {
        $instance = new static($bot);
        $instance();

        return $instance;
    }

    /**
     * @param  Nutgram  $bot
     */
    public function setBot(Nutgram $bot): void
    {
        $this->bot = $bot;
    }

    /**
     * @param  string  $step
     * @return Conversation
     */
    protected function next(string $step): Conversation
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Invokes the correct conversation step.
     */
    public function __invoke()
    {
        if ($this->step !== null) {
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
}
