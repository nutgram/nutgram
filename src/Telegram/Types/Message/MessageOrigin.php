<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MessageOriginType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the origin of a message. It can be one of
 * - {@see MessageOriginUser}
 * - {@see MessageOriginHiddenUser}
 * - {@see MessageOriginChat}
 * - {@see MessageOriginChannel}
 * @see https://core.telegram.org/bots/api#messageorigin
 */
#[MessageOriginResolver]
abstract class MessageOrigin extends BaseType
{
    /**
     * Type of the message origin
     * @var MessageOriginType
     */
    #[EnumOrScalar]
    public MessageOriginType|string $type;
}
