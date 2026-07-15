<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * This object represents a bot command.
 * @see https://core.telegram.org/bots/api#botcommand
 */
#[SkipConstructor]
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

    /**
     * Optional.
     * True, if the command sends an ephemeral message,
     * which can be seen only by the sender of the message and the bot
     */
    public ?bool $is_ephemeral = null;

    public function __construct(string $command, string $description, ?bool $is_ephemeral = null)
    {
        $this->command = $command;
        $this->description = $description;
        $this->is_ephemeral = $is_ephemeral;
    }

    public static function make(string $command, string $description, ?bool $is_ephemeral = null): self
    {
        return new self(
            command: $command,
            description: $description,
            is_ephemeral: $is_ephemeral,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'command' => $this->command,
            'description' => $this->description,
            'is_ephemeral' => $this->is_ephemeral,
        ]);
    }
}
