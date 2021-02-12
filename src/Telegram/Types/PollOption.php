<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object contains information about one answer option in a poll.
 * @see https://core.telegram.org/bots/api#polloption
 */
class PollOption
{
    /**
     * Option text, 1-100 characters
     * @var string
     */
    public string $text;

    /**
     * Number of users that voted for this option
     * @var int
     */
    public int $voter_count;
}
