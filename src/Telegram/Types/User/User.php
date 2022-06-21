<?php

namespace SergiX44\Nutgram\Telegram\Types\User;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a Telegram user or bot.
 * @see https://core.telegram.org/bots/api#user
 */
class User extends BaseType
{
    /**
     * Unique identifier for this user or bot
     */
    public int $id;

    /**
     * True, if this user is a bot
     */
    public bool $is_bot;

    /**
     * User‘s or bot’s first name
     */
    public string $first_name;

    /**
     * Optional. User‘s or bot’s last name
     */
    public ?string $last_name = null;

    /**
     * Optional. User‘s or bot’s username
     */
    public ?string $username = null;

    /**
     * Optional. IETF language tag of the user's language
     * @see https://en.wikipedia.org/wiki/IETF_language_tag IETF language tag
     */
    public ?string $language_code = null;

    /**
     * Optional. True, if this user is a Telegram Premium user
     */
    public ?bool $is_premium = null;

    /**
     * Optional. True, if this user added the bot to the attachment menu
     */
    public ?bool $added_to_attachment_menu = null;

    /**
     * Optional. True, if the bot can be invited to groups.
     * Returned only in {@see https://core.telegram.org/bots/api#getme getMe}.
     */
    public ?bool $can_join_groups = null;

    /**
     * Optional. True, if privacy mode is disabled for the bot.
     * Returned only in {@see https://core.telegram.org/bots/api#getme getMe}.
     */
    public ?bool $can_read_all_group_messages = null;

    /**
     * Optional. True, if the bot supports inline queries.
     * Returned only in {@see https://core.telegram.org/bots/api#getme getMe}.
     */
    public ?bool $supports_inline_queries = null;
}
