<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MessageOriginType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * The message was originally sent on behalf of a chat to a group chat.
 * @see https://core.telegram.org/bots/api#messageoriginchat
 */
class MessageOriginChat extends BaseType implements MessageOrigin
{
    /**
     * Type of the message origin, always “chat”
     */
    #[EnumOrScalar]
    public MessageOriginType|string $type = MessageOriginType::CHAT;

    /**
     * Date the message was sent originally in Unix time
     */
    public int $date;

    /**
     * Chat that sent the message originally
     */
    public Chat $sender_chat;

    /**
     * Optional. For messages originally sent by an anonymous chat administrator, original message author signature
     */
    public ?string $author_signature = null;
}
