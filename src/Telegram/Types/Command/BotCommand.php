<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use JsonSerializable;

/**
 * This object represents a bot command.
 * @see https://core.telegram.org/bots/api#botcommand
 */
class BotCommand implements JsonSerializable
{
    /**
     * Text of the command;
     * 1-32 characters.
     * Can contain only lowercase English letters, digits and underscores.
     */
    public string $command;

    /**
     * Description of the command;
     * 1-256 characters.
     */
    public string $description;

    public function __construct(string $command, string $description)
    {
        $this->command = $command;
        $this->description = $description;
    }

    public static function make(string $command, string $description): self
    {
        return new self($command, $description);
    }

    public function jsonSerialize(): array
    {
        return [
            'command' => $this->command,
            'description' => $this->description,
        ];
    }
}
