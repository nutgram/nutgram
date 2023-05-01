<?php

namespace SergiX44\Nutgram\Telegram\Types\Description;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents the bot's short description.
 * @see https://core.telegram.org/bots/api#botshortdescription
 */
class BotShortDescription extends BaseType
{
    /** The bot's short description */
    public string $short_description;
}
