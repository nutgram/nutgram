<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Conversations;

use Closure;
use Psr\SimpleCache\InvalidArgumentException;
use RuntimeException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

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

    /**
     * Start a conversation.
     * @param array<string, mixed> $data
     */
    public static function begin(
        Nutgram $bot,
        ?int $userId = null,
        ?int $chatId = null,
        ?int $threadId = null,
        array $data = [],
    ): self {
        if ($userId xor $chatId) {
            throw new \InvalidArgumentException('You need to provide both userId and chatId.');
        }

        $instance = $bot->getContainer()->get(static::class);
        $instance->userId = $userId;
        $instance->chatId = $chatId;
        $instance->threadId = $threadId;

        $originalUpdate = null;
        if ($userId && $chatId) {
            $originalUpdate = $bot->update();
            $bot->setContextUpdate(Update::frankensteinize($userId, $chatId, $threadId, $originalUpdate));
        }

        $instance($bot, ...$data);

        if ($originalUpdate) {
            $bot->setContextUpdate($originalUpdate);
        }

        return $instance;
    }

    public function shouldRefreshInstance(): bool
    {
        return self::$refreshInstance;
    }

    public static function refreshOnDeserialize(bool $flag = true): void
    {
        self::$refreshInstance = $flag;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function next(string $step, UpdateType|MessageType|Closure|null $type = null): static
    {
        if ($type instanceof UpdateType || $type instanceof MessageType) {
            $this->conditionalSteps[$type->value] = $step;
        } elseif ($type instanceof Closure) {
            $this->conditionalSteps[0][] = [$step, $type];
        } else {
            $this->step = $step;
        }

        $this->bot->stepConversation($this, $this->userId, $this->chatId, $this->threadId);

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function end(): void
    {
        $this->bot->endConversation($this->userId, $this->chatId, $this->threadId);
        $this->closing($this->bot);
    }

    /**
     * Developer defined function called before the current step.
     * @return void
     */
    protected function beforeStep(Nutgram $bot)
    {
    }

    /**
     * Developer defined function called when the conversation is shut down.
     * @return void
     */
    protected function closing(Nutgram $bot)
    {
    }

    /**
     * Invokes the correct conversation step.
     * @param mixed ...$parameters
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
            ($step = $this->conditionalSteps[$messageType->value] ?? $this->conditionalSteps[$updateType->value] ?? null)
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
     * @throws InvalidArgumentException
     */
    public function terminate(Nutgram $bot, ?int $userId = null, ?int $chatId = null): void
    {
        $this->bot = $bot;
        $this->bot->endConversation($userId, $chatId, $this->threadId);
        $this->closing($this->bot);
    }

    protected function setSkipHandlers(bool $skipHandlers): self
    {
        $this->skipHandlers = $skipHandlers;

        return $this;
    }

    protected function setSkipMiddlewares(bool $skipMiddlewares): self
    {
        $this->skipMiddlewares = $skipMiddlewares;

        return $this;
    }

    public function skipHandlers(): bool
    {
        return $this->skipHandlers;
    }

    public function skipMiddlewares(): bool
    {
        return $this->skipMiddlewares;
    }

    /**
     * @return array<string, mixed>
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
     * @return array<string, mixed>
     */
    protected function getSerializableAttributes(): array
    {
        return [];
    }
}
