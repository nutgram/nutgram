<?php

namespace SergiX44\Nutgram\Telegram\Types\Poll;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\PollType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * This object contains information about a poll.
 * @see https://core.telegram.org/bots/api#poll
 */
class Poll extends BaseType
{
    /** Unique poll identifier */
    public string $id;

    /** Poll question, 1-300 characters */
    public string $question;

    /**
     * Optional. Special entities that appear in the question. Currently, only custom emoji entities are allowed in poll questions
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $question_entities = null;

    /**
     * List of poll options
     * @var PollOption[] $options
     */
    #[ArrayType(PollOption::class)]
    public array $options;

    /** Total number of users that voted in the poll */
    public int $total_voter_count;

    /** True, if the poll is closed */
    public bool $is_closed;

    /** True, if the poll is anonymous */
    public bool $is_anonymous;

    /** Poll type, currently can be “regular” or “quiz” */
    #[EnumOrScalar]
    public PollType|string $type;

    /** True, if the poll allows multiple answers */
    public bool $allows_multiple_answers;

    /**
     * Optional.
     * 0-based identifier of the correct answer option.
     * Available only for polls in the quiz mode, which are closed, or was sent (not forwarded) by the bot or to the private chat with the bot.
     */
    public ?int $correct_option_id = null;

    /**
     * Optional.
     * Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz-style poll, 0-200 characters
     */
    public ?string $explanation = null;

    /**
     * Optional.
     * Special entities like usernames, URLs, bot commands, etc.
     * that appear in the explanation
     * @var MessageEntity[] $explanation_entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $explanation_entities = null;

    /**
     * Optional.
     * Amount of time in seconds the poll will be active after creation
     */
    public ?int $open_period = null;

    /**
     * Optional.
     * Point in time (Unix timestamp) when the poll will be automatically closed
     */
    public ?int $close_date = null;
}
