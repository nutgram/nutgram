<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Poll;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Describes a service message about an option deleted from a poll.
 * @see https://core.telegram.org/bots/api#polloptiondeleted
 */
class PollOptionDeleted extends BaseType
{
    /**
     * Optional.
     * Message containing the poll from which the option was deleted, if known.
     * Note that the Message object in this field will not contain
     * the reply_to_message field even if it itself is a reply.
     */
    public ?Message $poll_message = null;

    /**
     * Unique identifier of the deleted option
     */
    public string $option_persistent_id;

    /**
     * Option text
     */
    public string $option_text;

    /**
     * Optional.
     * Special entities that appear in the option_text
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $option_text_entities = null;
}
