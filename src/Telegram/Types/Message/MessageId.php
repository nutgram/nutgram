<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a unique message identifier.
 * @see https://core.telegram.org/bots/api#messageid
 */
class MessageId extends BaseType
{
    /** Unique message identifier */
    public int $message_id;
}
