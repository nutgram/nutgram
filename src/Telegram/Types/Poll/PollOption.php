<?php

namespace SergiX44\Nutgram\Telegram\Types\Poll;

/**
 * This object contains information about one answer option in a poll.
 * @see https://core.telegram.org/bots/api#polloption
 */
class PollOption
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
