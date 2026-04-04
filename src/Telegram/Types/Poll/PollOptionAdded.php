<?php

namespace SergiX44\Nutgram\Telegram\Types\Poll;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Describes a service message about an option added to a poll.
 * @see https://core.telegram.org/bots/api#polloptionadded
 */
class PollOptionAdded extends BaseType
{
    /**
     * Optional.
     * Message containing the poll to which the option was added, if known.
     * Note that the Message object in this field will not contain
     * the reply_to_message field even if it itself is a reply.
     * @var Message|null
     */
    public ?Message $poll_message = null;

    /**
     * Unique identifier of the added option
     * @var string
     */
    public string $option_persistent_id;

    /**
     * Option text
     * @var string
     */
    public string $option_text;

    /**
     * Optional.
     * Special entities that appear in the option_text
     * @var MessageEntity[]|null
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $option_text_entities = null;
}
