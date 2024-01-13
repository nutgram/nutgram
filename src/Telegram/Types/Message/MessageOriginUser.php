<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MessageOriginType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * The message was originally sent by a known user.
 * @see https://core.telegram.org/bots/api#messageoriginuser
 */
class MessageOriginUser extends MessageOrigin
{
    /**
     * Type of the message origin, always “user”
     * @var MessageOriginType
     */
    #[EnumOrScalar]
    public MessageOriginType|string $type = MessageOriginType::USER;

    /**
     * Date the message was sent originally in Unix time
     * @var int
     */
    public int $date;

    /**
     * User that sent the message originally
     * @var User
     */
    public User $sender_user;
}
