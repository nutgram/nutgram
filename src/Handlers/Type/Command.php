<?php

namespace SergiX44\Nutgram\Handlers\Type;

use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Telegram\Types\BotCommand;

class Command extends Handler
{
    protected string $description = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        [$cmd,] = explode(' ', strtolower($this->pattern));
        return str_replace('/', '', $cmd);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param  string  $description
     * @return Command
     */
    public function setDescription(string $description): Command
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
