<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MessageOriginType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * The message was originally sent to a channel chat.
 * @see https://core.telegram.org/bots/api#messageoriginchannel
 */
class MessageOriginChannel extends BaseType implements MessageOrigin
{
    /**
     * Type of the message origin, always “channel”
     */
    #[EnumOrScalar]
    public MessageOriginType|string $type = MessageOriginType::CHANNEL;

    /**
     * Date the message was sent originally in Unix time
     */
    public int $date;

    /**
     * Channel chat to which the message was originally sent
     */
    public Chat $chat;

    /**
     * Unique message identifier inside the chat
     */
    public int $message_id;

    /**
     * Optional. Signature of the original post author
     */
    public ?string $author_signature = null;
}
