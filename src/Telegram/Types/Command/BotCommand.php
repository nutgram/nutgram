<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * This object represents a bot command.
 * @see https://core.telegram.org/bots/api#botcommand
 */
#[OverrideConstructor('bindToInstance')]
class BotCommand extends BaseType
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
}
