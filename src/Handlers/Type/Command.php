<?php

namespace SergiX44\Nutgram\Handlers\Type;

use RuntimeException;
use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommand;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScope;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeDefault;

class Command extends Handler
{
    protected string $command = '#';

    protected ?string $description = null;

    protected array $localizedDescriptions = [];

    protected array $scopes = [];

    /**
     * @param callable|callable-string $callable
     * @param string|null $command
     */
    public function __construct($callable = null, ?string $command = null)
    {
        $command = $command ?? $this->command;

        if ($callable !== null) {
            parent::__construct($callable, "/{$command}");
            return;
        }

        if (!method_exists($this, 'handle')) {
            throw new RuntimeException('The handle method must be implemented!');
        }

        parent::__construct([$this, 'handle'], "/{$command}");
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        [$cmd,] = explode(' ', strtolower($this->pattern ?? ''));
        return str_replace('/', '', $cmd);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getLocalizedDescriptions(): array
    {
        return $this->localizedDescriptions;
    }

    public function getAllDescriptions(): array
    {
        $descriptions = [];

        if ($this->getDescription() !== null) {
            $descriptions['*'] = $this->getDescription();
        }

        return [
            ...$descriptions,
            ...$this->getLocalizedDescriptions()
        ];
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return empty($this->getAllDescriptions());
    }

    /**
     * @param array<string, string>|string $description
     * @return Command
     */
    public function description(array|string $description): Command
    {
        if (is_string($description)) {
            $this->description = $description;
            return $this;
        }

        $this->localizedDescriptions = $description;
        return $this;
    }

    /**
     * @param BotCommandScope|BotCommandScope[] $scope
     * @return $this
     */
    public function scope(BotCommandScope|array $scope): Command
    {
        if (!is_array($scope)) {
            $scope = [$scope];
        }

        $this->scopes = array_merge($this->scopes, $scope);
        return $this;
    }

    /**
     * @return BotCommandScope[]
     */
    public function scopes(): array
    {
        return !empty($this->scopes) ? $this->scopes : [new BotCommandScopeDefault];
    }

    /**
     * @param string|null $languageCode
     * @return BotCommand
     */
    public function toBotCommand(?string $languageCode = null): BotCommand
    {
        $descriptions = $this->getAllDescriptions();

        if ($languageCode !== null) {
            return new BotCommand(
                command: $this->getName(),
                description: $descriptions[$languageCode] ?? array_shift($descriptions)
            );
        }

        return new BotCommand($this->getName(), $descriptions['*'] ?? null);
    }
}
