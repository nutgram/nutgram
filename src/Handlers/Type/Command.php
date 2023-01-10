<?php

namespace SergiX44\Nutgram\Handlers\Type;

use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommand;

class Command extends Handler
{
    protected string $command;

    protected ?string $description = null;

    /**
     * @param  string|null  $pattern
     * @param  null  $callable
     */
    public function __construct(?string $pattern = null, $callable = null)
    {
        parent::__construct($callable ?? [$this, 'handle'], $pattern ?? "/$this->command");
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
     * @param  string  $command
     * @return Command
     */
    public function command(string $command): Command
    {
        $this->command = $command;
        return $this;
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
     * @return BotCommand
     */
    public function toBotCommand(): BotCommand
    {
        return new BotCommand($this->getName(), $this->getDescription());
    }

    public function handle(Nutgram $bot): void
    {
    }
}
