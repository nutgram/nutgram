<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MessageOriginType;

/**
 * The message was originally sent by an unknown user.
 * @see https://core.telegram.org/bots/api#messageoriginhiddenuser
 */
class MessageOriginHiddenUser extends MessageOrigin
{
    /**
     * Type of the message origin, always “hidden_user”
     * @var MessageOriginType
     */
    #[EnumOrScalar]
    public MessageOriginType|string $type = MessageOriginType::HIDDEN_USER;

    /**
     * Date the message was sent originally in Unix time
     * @var int
     */
    public int $date;

    /**
     * Name of the user that sent the message originally
     * @var string
     */
    public string $sender_user_name;
}
