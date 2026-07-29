<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Nutgram\Telegram\Types\Chat\Chat;

/**
 * This object describes a message that was deleted or is otherwise inaccessible to the bot.
 * @see https://core.telegram.org/bots/api#inaccessiblemessage
 */
class InaccessibleMessage extends MaybeInaccessibleMessage
{
    /**
     * Conversation the message belongs to
     */
    public Chat $chat;

    /**
     * Unique message identifier inside this chat
     */
    public int $message_id;

    /**
     * Date the message was sent in Unix time
     */
    public int $date;
}
