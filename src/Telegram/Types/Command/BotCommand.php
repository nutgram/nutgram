<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Command;

use JsonSerializable;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a bot command.
 * @see https://core.telegram.org/bots/api#botcommand
 */
class BotCommand extends BaseType implements JsonSerializable
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

    public static function make(string $command, string $description): self
    {
        $instance = new self;
        $instance->command = $command;
        $instance->description = $description;

        return $instance;
    }

    public function jsonSerialize(): array
    {
        return [
            'command' => $this->command,
            'description' => $this->description,
        ];
    }
}
