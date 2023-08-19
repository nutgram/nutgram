<?php

namespace SergiX44\Nutgram\Telegram\Types\Poll;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents an answer of a user in a non-anonymous poll.
 * @see https://core.telegram.org/bots/api#pollanswer
 */
class PollAnswer extends BaseType
{
    /** Unique poll identifier */
    public string $poll_id;

    /**
     * Optional.
     * The chat that changed the answer to the poll, if the voter is anonymous
     */
    public ?Chat $voter_chat = null;

    /**
     * Optional.
     * The user that changed the answer to the poll, if the voter isn't anonymous
     */
    public ?User $user = null;

    /**
     * 0-based identifiers of chosen answer options.
     * May be empty if the vote was retracted.
     * @var int[] $option_ids
     */
    public array $option_ids;
}
