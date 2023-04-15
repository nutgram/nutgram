<?php

namespace SergiX44\Nutgram\Handlers\Type;

use RuntimeException;
use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommand;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScope;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeDefault;

class Command extends Handler
{
    protected string $command = '#';

    protected ?string $description = null;

    protected array $scopes = [];

    /**
     * @param  callable|callable-string  $callable
     * @param  string|null  $command
     */
    public function __construct($callable = null, ?string $command = null)
    {
        $command = $command ?? $this->command;
        parent::__construct($callable ?? [$this, 'handle'], "/{$command}");
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        [$cmd,] = explode(' ', strtolower($this->pattern ?? ''));
        return str_replace('/', '', $cmd);
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
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
     * @param  string  $description
     * @return Command
     */
    public function description(string $description): Command
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param  BotCommandScope|BotCommandScope[]  $scope
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
     * @return BotCommand
     */
    public function toBotCommand(): BotCommand
    {
        return new BotCommand($this->getName(), $this->getDescription());
    }

    public function handle(Nutgram $bot): void
    {
        throw new RuntimeException('The handle method must be extended!');
    }
}
