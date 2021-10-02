<?php

namespace SergiX44\Nutgram\Telegram\Types\User;

/**
 * This object represents a Telegram user or bot.
 * @see https://core.telegram.org/bots/api#user
 */
class User
{
    /**
     * Unique identifier for this user or bot
     * @var int $id
     */
    public $id;

    /**
     * True, if this user is a bot
     * @var bool $is_bot
     */
    public $is_bot;

    /**
     * User‘s or bot’s first name
     * @var string $first_name
     */
    public $first_name;

    /**
     * Optional. User‘s or bot’s last name
     * @var string $last_name
     */
    public $last_name;

    /**
     * Optional. User‘s or bot’s username
     * @var string $username
     */
    public $username;

    /**
     * Optional. IETF language tag of the user's language
     * @see https://en.wikipedia.org/wiki/IETF_language_tag IETF language tag
     * @var string $language_code
     */
    public $language_code;

    /**
     * Optional. True, if the bot can be invited to groups.
     * Returned only in {@see https://core.telegram.org/bots/api#getme getMe}.
     * @var bool $can_join_groups
     */
    public $can_join_groups;

    /**
     * Optional. True, if privacy mode is disabled for the bot.
     * Returned only in {@see https://core.telegram.org/bots/api#getme getMe}.
     * @var bool $can_read_all_group_messages
     */
    public $can_read_all_group_messages;

    /**
     * Optional. True, if the bot supports inline queries.
     * Returned only in {@see https://core.telegram.org/bots/api#getme getMe}.
     * @var bool $supports_inline_queries
     */
    public $supports_inline_queries;
}
