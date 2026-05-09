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
     * True, if the poll allows to change the chosen answer options
     */
    public bool $allows_revoting;

    /**
     * True if voting is limited to users who have been members of the chat where the poll was originally sent for more than 24 hours
     */
    public ?bool $members_only = null;

    /**
     * Optional.
     * A list of two-letter {@see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2 ISO 3166-1 alpha-2}
     * country codes indicating the countries from which users can vote in the poll.
     * If omitted, then users from any country can participate in the poll.
     * @var string[]|null
     */
    public ?array $country_codes = null;

    /**
     * Optional.
     * Array of 0-based identifiers of the correct answer options.
     * Available only for polls in quiz mode which are closed or
     * were sent (not forwarded) by the bot or to the private chat with the bot.
     * @var int[]|null
     */
    public ?array $correct_option_ids = null;

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
     * Optional. Media added to the quiz explanation
     */
    public ?PollMedia $explanation_media = null;

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

    /**
     * Optional.
     * Description of the poll; for polls inside the {@see https://core.telegram.org/bots/api#message Message} object only
     */
    public ?string $description = null;

    /**
     * Optional. Media added to the poll description; for polls inside the Message object only
     */
    public ?PollMedia $media = null;

    /**
     * Optional.
     * Special entities like usernames, URLs, bot commands, etc.
     * that appear in the description
     * @var MessageEntity[]|null
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $description_entities = null;
}
