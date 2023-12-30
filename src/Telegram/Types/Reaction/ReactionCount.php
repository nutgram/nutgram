<?php

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Represents a reaction added to a message along with the number of times it was added.
 * @see https://core.telegram.org/bots/api#reactioncount
 */
class ReactionCount extends BaseType
{
    /**
     * Type of the reaction
     * @var ReactionType
     */
    public ReactionType $type;

    /**
     * Number of times the reaction was added
     * @var int
     */
    public int $total_count;
}
