<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\MessageOriginResolver;

/**
 * This object describes the origin of a message. It can be one of
 * - {@see MessageOriginUser}
 * - {@see MessageOriginHiddenUser}
 * - {@see MessageOriginChat}
 * - {@see MessageOriginChannel}
 * @see https://core.telegram.org/bots/api#messageorigin
 */
#[MessageOriginResolver]
interface MessageOrigin
{
}
