<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * Represents a reaction added to a message along with the number of times it was added.
 * @see https://core.telegram.org/bots/api#reactioncount
 */
class ReactionCount extends BaseType
{
    /**
     * Type of the reaction
     */
    public ReactionType $type;

    /**
     * Number of times the reaction was added
     */
    public int $total_count;
}
