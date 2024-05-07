<?php

namespace SergiX44\Nutgram\Telegram\Types\Poll;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * This object contains information about one answer option in a poll.
 * @see https://core.telegram.org/bots/api#polloption
 */
class PollOption extends BaseType
{
    /** Option text, 1-100 characters */
    public string $text;

    /**
     * Optional. Special entities that appear in the option text. Currently, only custom emoji entities are allowed in poll option texts
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $text_entities = null;

    /** Number of users that voted for this option */
    public int $voter_count;
}
