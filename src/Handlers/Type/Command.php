<?php

namespace SergiX44\Nutgram\Handlers\Type;

use RuntimeException;
use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommand;

class Command extends Handler
{
    protected string $command = '#';

    protected ?string $description = null;

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
