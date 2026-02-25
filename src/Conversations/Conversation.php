<?php


namespace SergiX44\Nutgram\Conversations;

use Closure;
use Laravel\SerializableClosure\SerializableClosure;
use Psr\SimpleCache\InvalidArgumentException;
use RuntimeException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;

/**
 * Class Conversation
 * @package SergiX44\Nutgram\Conversation
 */
abstract class Conversation
{
    protected Nutgram $bot;
    protected bool $skipHandlers = false;
    protected bool $skipMiddlewares = false;
    protected ?string $step = 'start';
    private array $conditionalSteps = [];
    private static bool $refreshInstance = false;
    private ?int $userId = null;
    private ?int $chatId = null;
    private ?int $threadId = null;

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
     * @todo: remove in favor of the begin() method in Nutgram 5.0, as the threadId parameter will be placed after the $chatId parameter.
     */
    public static function beginThread(
        Nutgram $bot,
        ?int $userId = null,
        ?int $chatId = null,
        ?int $threadId = null,
        array $data = []
    ): self {
        if ($userId xor $chatId) {
            throw new \InvalidArgumentException('You need to provide both userId and chatId.');
        }

        $instance = $bot->getContainer()->get(static::class);
        $instance->userId = $userId;
        $instance->chatId = $chatId;
        $instance->threadId = $threadId;
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
     * @param bool $flag
     * @return void
     */
    public static function refreshOnDeserialize(bool $flag = true): void
    {
        self::$refreshInstance = $flag;
    }

    /**
     * @param string $step
     * @param UpdateType|MessageType|Closure|null $type
     * @return Conversation
     * @throws InvalidArgumentException
     */
    protected function next(string $step, UpdateType|MessageType|Closure|null $type = null): static
    {
        if ($type instanceof UpdateType || $type instanceof MessageType) {
            $this->conditionalSteps[$type->value] = $step;
        } elseif ($type instanceof Closure) {
            $this->conditionalSteps[0][] = [$step, new SerializableClosure($type)];
        } else {
            $this->step = $step;
        }

        $this->bot->stepConversation($this, $this->userId, $this->chatId, $this->threadId);

        return $this;
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    protected function end(): void
    {
        $this->bot->endConversation($this->userId, $this->chatId, $this->threadId);
        $this->closing($this->bot);
    }

    /**
     * Developer defined function called before the current step.
     * @param Nutgram $bot
     * @return void
     */
    protected function beforeStep(Nutgram $bot)
    {
    }

    /**
     * Developer defined function called when the conversation is shut down.
     * @param Nutgram $bot
     * @return void
     */
    protected function closing(Nutgram $bot)
    {
    }

    /**
     * Invokes the correct conversation step.
     * @param Nutgram $bot
     * @param mixed ...$parameters
     * @return mixed
     */
    public function __invoke(Nutgram $bot, ...$parameters): mixed
    {
        $currentStep = $this->resolveCurrentStep($bot);

        if (method_exists($this, $this->step)) {
            $this->bot = $bot;
            $this->beforeStep($bot);
            $this->conditionalSteps = [];
            return $this->{$currentStep}($bot, ...$parameters);
        }

        throw new RuntimeException("Conversation step '$currentStep' not found.");
    }

    private function resolveCurrentStep(Nutgram $bot): ?string
    {
        $updateType = $bot->update()?->getType();

        if ($updateType &&
            $updateType->isMessageType() &&
            ($messageType = $bot->update()?->getMessage()?->getType()) &&
            ($step = $this->conditionalSteps[$messageType->value] ?? $this->conditionalSteps[$updateType->value])
        ) {
            return $step;
        }

        if (array_key_exists(0, $this->conditionalSteps)) {
            foreach ($this->conditionalSteps[0] as [$step, $closure]) {
                if ($closure($bot)) {
                    return $step;
                }
            }
        }

        return $this->step;
    }

    /**
     * @param Nutgram $bot
     * @param int|null $userId
     * @param int|null $chatId
     * @throws InvalidArgumentException
     */
    public function terminate(Nutgram $bot, ?int $userId = null, ?int $chatId = null): void
    {
        $this->bot = $bot;
        $this->bot->endConversation($userId, $chatId, $this->threadId);
        $this->closing($this->bot);
    }

    /**
     * @param bool $skipHandlers
     * @return Conversation
     */
    protected function setSkipHandlers(bool $skipHandlers): self
    {
        $this->skipHandlers = $skipHandlers;

        return $this;
    }

    /**
     * @param bool $skipMiddlewares
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
