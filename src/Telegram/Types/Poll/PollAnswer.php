<?php

namespace SergiX44\Nutgram\Telegram\Types\Poll;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents an answer of a user in a non-anonymous poll.
 * @see https://core.telegram.org/bots/api#pollanswer
 */
class PollAnswer extends BaseType
{
    /**
     * Unique poll identifier
     */
    public string $poll_id;

    /**
     * The user, who changed the answer to the poll
     */
    public User $user;

    /**
     * 0-based identifiers of answer options, chosen by the user. May be empty if the user retracted their vote.
     * @var int[] $option_ids
     */
    public array $option_ids;
}
