<?php

namespace SergiX44\Nutgram\Telegram\Types\Poll;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object contains information about one answer option in a poll.
 * @see https://core.telegram.org/bots/api#polloption
 */
class PollOption extends BaseType
{
    /**
     * Unique identifier of the option, persistent on option addition and deletion
     */
    public string $persistent_id;

    /** Option text, 1-100 characters */
    public string $text;

    /**
     * Optional. Special entities that appear in the option text. Currently, only custom emoji entities are allowed in poll option texts
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $text_entities = null;

    /**
     * Optional. Media added to the poll option
     */
    public ?PollMedia $media = null;

    /** Number of users that voted for this option */
    public int $voter_count;

    /**
     * Optional.
     * User who added the option;
     * omitted if the option wasn't added by a user after poll creation
     */
    public ?User $added_by_user = null;

    /**
     * Optional.
     * Chat that added the option;
     * omitted if the option wasn't added by a chat after poll creation
     */
    public ?Chat $added_by_chat = null;

    /**
     * Optional.
     * Point in time (Unix timestamp) when the option was added;
     * omitted if the option existed in the original poll
     */
    public ?int $addition_date = null;
}
