<?php

namespace SergiX44\Nutgram\Handlers\Type;

use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Telegram\Types\BotCommand;

class Command extends Handler
{
    protected ?string $description = null;

    /**
     * @return string
     */
    public function getName(): string
    {
        [$cmd,] = explode(' ', strtolower($this->pattern));
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
}
