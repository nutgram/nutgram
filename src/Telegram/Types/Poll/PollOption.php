<?php

namespace SergiX44\Nutgram\Telegram\Types\Poll;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object contains information about one answer option in a poll.
 * @see https://core.telegram.org/bots/api#polloption
 */
class PollOption extends BaseType
{
    /**
     * Option text, 1-100 characters
     */
    public string $text;

    /**
     * Number of users that voted for this option
     */
    public int $voter_count;
}
