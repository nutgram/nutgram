<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Nutgram\Telegram\Types\Chat\Chat;

class InaccessibleMessage extends MaybeInaccessibleMessage
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
     * Always 0. The field can be used to differentiate regular and inaccessible messages.
     */
    public int $date;
}
