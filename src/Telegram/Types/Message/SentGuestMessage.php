<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes an inline message sent by a guest bot.
 * @see https://core.telegram.org/bots/api#sentguestmessage
 */
class SentGuestMessage extends BaseType
{
    /**
     * Identifier of the sent inline message
     */
    public string $inline_message_id;
}
