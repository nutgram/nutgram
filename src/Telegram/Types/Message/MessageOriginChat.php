<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MessageOriginType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;

/**
 * The message was originally sent on behalf of a chat to a group chat.
 * @see https://core.telegram.org/bots/api#messageoriginchat
 */
class MessageOriginChat extends MessageOrigin
{
    /**
     * Type of the message origin, always “chat”
     * @var MessageOriginType
     */
    #[EnumOrScalar]
    public MessageOriginType|string $type = MessageOriginType::CHAT;

    /**
     * Date the message was sent originally in Unix time
     * @var int
     */
    public int $date;

    /**
     * Chat that sent the message originally
     * @var Chat
     */
    public Chat $sender_chat;

    /**
     * Optional. For messages originally sent by an anonymous chat administrator, original message author signature
     * @var string|null
     */
    public ?string $author_signature = null;
}
