<?php

namespace SergiX44\Nutgram\Telegram\Types\Description;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents the bot's description.
 * @see https://core.telegram.org/bots/api#botdescription
 */
class BotDescription extends BaseType
{
    /** The bot's description */
    public string $description;
}
