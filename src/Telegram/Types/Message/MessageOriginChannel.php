<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MessageOriginType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;

/**
 * The message was originally sent to a channel chat.
 * @see https://core.telegram.org/bots/api#messageoriginchannel
 */
class MessageOriginChannel extends MessageOrigin
{
    /**
     * Type of the message origin, always “channel”
     * @var MessageOriginType
     */
    #[EnumOrScalar]
    public MessageOriginType|string $type = MessageOriginType::CHANNEL;

    /**
     * Date the message was sent originally in Unix time
     * @var int
     */
    public int $date;

    /**
     * Channel chat to which the message was originally sent
     * @var Chat
     */
    public Chat $chat;

    /**
     * Unique message identifier inside the chat
     * @var int
     */
    public int $message_id;

    /**
     * Optional. Signature of the original post author
     * @var string|null
     */
    public ?string $author_signature = null;
}
