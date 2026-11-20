<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * This object describes an update about a user stopping message generation.
 * @see https://core.telegram.org/bots/api#messagegenerationstopped
 */
class MessageGenerationStopped extends BaseType
{
    /**
     * Chat in which the message is generated
     */
    public Chat $chat;

    /**
     * Optional. Unique identifier of the message thread in which the message is generated
     */
    public ?int $message_thread_id = null;

    /**
     * Unique identifier of the message draft which was stopped
     */
    public int $draft_id;
}
