<?php

namespace SergiX44\Nutgram\Handlers\Type;

use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommand;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScope;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeDefault;

final class Command extends Handler
{
    protected array $description = [];

    protected array $scopes = [];

    /**
     * @param callable|callable-string $callable
     * @param string $command
     */
    public function __construct($callable, string $command)
    {
        parent::__construct($callable, "/{$command}");
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        [$cmd,] = explode(' ', strtolower($this->pattern ?? ''));
        return str_replace('/', '', $cmd);
    }

    public function getDescription(): array
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return empty($this->getDescription());
    }

    /**
     * @param array<string, string>|string $description
     * @return Command
     */
    public function description(array|string $description): Command
    {
        if (is_string($description)) {
            $this->description['*'] = $description;
            return $this;
        }

        $this->description = $description;
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
        $descriptions = $this->getDescription();

        if ($languageCode !== null) {
            return new BotCommand(
                command: $this->getName(),
                description: $descriptions[$languageCode] ?? array_shift($descriptions)
            );
        }

        return new BotCommand($this->getName(), $descriptions['*']);
    }
}
