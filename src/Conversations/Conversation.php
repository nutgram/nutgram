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
    protected bool $skipHandlers = false;
    protected bool $skipMiddlewares = false;
    protected ?string $step = 'start';
    protected Nutgram $bot;
    private static bool $refreshInstance = false;
    private ?int $userId = null;
    private ?int $chatId = null;

    public static function begin(Nutgram $bot, ?int $userId = null, ?int $chatId = null, array $data = []): self
    {
        if ($userId xor $chatId) {
            throw new \InvalidArgumentException('You need to provide both userId and chatId.');
        }

        $instance = $bot->getContainer()->get(static::class);
        $instance->userId = $userId;
        $instance->chatId = $chatId;
        $instance($bot, ...$data);

        return $instance;
    }

    /**
     * @return bool
     */
    public function shouldRefreshInstance(): bool
    {
        return self::$refreshInstance;
    }

    /**
     * @param  bool  $flag
     * @return void
     */
    public static function refreshOnDeserialize(bool $flag = true): void
    {
        self::$refreshInstance = $flag;
    }

    /**
     * @param  string  $step
     * @return void
     * @throws InvalidArgumentException
     */
    protected function next(string $step): void
    {
        $this->step = $step;

        $this->bot->stepConversation($this, $this->userId, $this->chatId);
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    protected function end(): void
    {
        $this->closing($this->bot);
        $this->bot->endConversation($this->userId, $this->chatId);
    }

    /**
     * Developer defined function called before the current step.
     * @param  Nutgram  $bot
     * @return void
     */
    protected function beforeStep(Nutgram $bot)
    {
    }

    /**
     * Developer defined function called when the conversation is shut down.
     * @param  Nutgram  $bot
     * @return void
     */
    protected function closing(Nutgram $bot)
    {
    }

    /**
     * Invokes the correct conversation step.
     * @param  Nutgram  $bot
     * @param  mixed  ...$parameters
     * @return mixed
     */
    public function __invoke(Nutgram $bot, ...$parameters): mixed
    {
        if (method_exists($this, $this->step)) {
            $this->bot = $bot;
            $this->beforeStep($bot);
            return $this->{$this->step}($bot, ...$parameters);
        }

        throw new RuntimeException("Conversation step '$this->step' not found.");
    }

    /**
     * @param  Nutgram  $bot
     * @param  int|null  $userId
     * @param  int|null  $chatId
     * @throws InvalidArgumentException
     */
    public function terminate(Nutgram $bot, ?int $userId = null, ?int $chatId = null): void
    {
        $this->bot = $bot;
        $this->closing($this->bot);
        $this->bot->endConversation($userId, $chatId);
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
        $attributes = [
            ...get_object_vars($this),
            ...$this->getSerializableAttributes(),
        ];
        unset($attributes['bot']);

        return $attributes;
    }

    /**
     * @return array
     */
    protected function getSerializableAttributes(): array
    {
        return [];
    }

    public function getChatId(): ?int
    {
        return $this->chatId;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }
}
