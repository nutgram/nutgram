<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\MaybeInaccessibleMessageResolver;

/**
 * This object describes a message that can be inaccessible to the bot. It can be one of
 * - {@see Message}
 * - {@see InaccessibleMessage}
 * @see https://core.telegram.org/bots/api#maybeinaccessiblemessage
 */
#[MaybeInaccessibleMessageResolver]
abstract class MaybeInaccessibleMessage extends BaseType
{
    public Chat $chat;
    public int $message_id;
    public int $date;

    /**
     * Check if this message is deleted or is inaccessible to the bot.
     * @return bool
     */
    public function isInaccessible(): bool
    {
        return $this->date === 0;
    }
}
