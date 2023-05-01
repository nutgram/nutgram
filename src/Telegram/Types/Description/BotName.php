<?php

namespace SergiX44\Nutgram\Telegram\Types\Description;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents the bot's name.
 * @see https://core.telegram.org/bots/api#botname
 */
class BotName extends BaseType
{
    /** The bot's name */
    public string $name;
}
