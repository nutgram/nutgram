<?php

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;

/**
 * This object represents reaction changes on a message with anonymous reactions.
 * @see https://core.telegram.org/bots/api#messagereactioncountupdated
 */
class MessageReactionCountUpdated extends BaseType
{
    /**
     * The chat containing the message
     * @var Chat
     */
    public Chat $chat;

    /**
     * Unique message identifier inside the chat
     * @var int
     */
    public int $message_id;

    /**
     * Date of the change in Unix time
     * @var int
     */
    public int $date;

    /**
     * List of reactions that are present on the message
     * @var ReactionCount[]
     */
    #[ArrayType(ReactionCount::class)]
    public array $reactions;
}
