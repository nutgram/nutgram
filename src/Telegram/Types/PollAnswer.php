<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents an answer of a user in a non-anonymous poll.
 * @see https://core.telegram.org/bots/api#pollanswer
 */
class PollAnswer
{
    /**
     * Unique poll identifier
     * @var string $poll_id
     */
    public $poll_id;
    
    /**
     * The user, who changed the answer to the poll
     * @var User $user
     */
    public $user;
    
    /**
     * 0-based identifiers of answer options, chosen by the user. May be empty if the user retracted their vote.
     * @var int[] $option_ids
     */
    public $option_ids;
}
