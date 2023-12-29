<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;

/**
 * This object describes a message that can be inaccessible to the bot. It can be one of
 * - {@see Message}
 * - {@see InaccessibleMessage}
 * @see https://core.telegram.org/bots/api#maybeinaccessiblemessage
 */
#[MaybeInaccessibleMessageResolver]
abstract class MaybeInaccessibleMessage extends BaseType
{
    /**
     * Chat the message belonged to
     */
    public Chat $chat;

    /**
     * Unique message identifier inside the chat
     */
    public int $message_id;

    /**
     * The field can be used to differentiate regular and inaccessible messages.
     * For inaccessible messages, it will be equal to 0.
     */
    public int $date;
}
