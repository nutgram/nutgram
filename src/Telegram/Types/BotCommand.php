<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a bot command.
 * @see https://core.telegram.org/bots/api#botcommand
 */
class BotCommand
{
    /**
     * Text of the command, 1-32 characters. Can contain only lowercase English letters, digits and underscores.
     * @var string
     */
    public string $command;

    /**
     * Description of the command, 3-256 characters.
     * @var string
     */
    public string $description;
}
