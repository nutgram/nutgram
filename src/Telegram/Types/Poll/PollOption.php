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
     * @var string $text
     */
    public $text;

    /**
     * Number of users that voted for this option
     * @var int $voter_count
     */
    public $voter_count;
}
