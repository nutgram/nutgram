<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Command;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a bot command.
 * @see https://core.telegram.org/bots/api#botcommand
 */
#[OverrideConstructor('bindToInstance')]
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

    public function __construct(string $command, string $description)
    {
        $this->command = $command;
        $this->description = $description;
    }


    public function jsonSerialize(): array
    {
        return [
            'command' => $this->command,
            'description' => $this->description,
        ];
    }
}
