<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

/**
 * This object represents a bot command.
 * @see https://core.telegram.org/bots/api#botcommand
 */
class BotCommand
{
    /**
     * Text of the command, 1-32 characters. Can contain only lowercase English letters, digits and underscores.
     */
    public string $command;

    /**
     * Description of the command, 3-256 characters.
     */
    public string $description;

    /**
     * @param  string  $command
     * @param  string  $description
     */
    public function __construct(string $command, string $description)
    {
        $this->command = $command;
        $this->description = $description;
    }
}
