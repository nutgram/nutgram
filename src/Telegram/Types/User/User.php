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
     * Unique identifier for this user or bot.
     * This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    public int $id;

    /** True, if this user is a bot */
    public bool $is_bot;

    /** User's or bot's first name */
    public string $first_name;

    /**
     * Optional.
     * User's or bot's last name
     */
    public ?string $last_name = null;

    /**
     * Optional.
     * User's or bot's username
     */
    public ?string $username = null;

    /**
     * Optional.
     * {@see https://en.wikipedia.org/wiki/IETF_language_tag IETF language tag} of the user's language
     */
    public ?string $language_code = null;

    /**
     * Optional.
     * True, if this user is a Telegram Premium user
     */
    public ?bool $is_premium = null;

    /**
     * Optional.
     * True, if this user added the bot to the attachment menu
     */
    public ?bool $added_to_attachment_menu = null;

    /**
     * Optional.
     * True, if the bot can be invited to groups.
     * Returned only in {@see https://core.telegram.org/bots/api#getme getMe}.
     */
    public ?bool $can_join_groups = null;

    /**
     * Optional.
     * True, if {@see https://core.telegram.org/bots/features#privacy-mode privacy mode} is disabled for the bot.
     * Returned only in {@see https://core.telegram.org/bots/api#getme getMe}.
     */
    public ?bool $can_read_all_group_messages = null;

    /**
     * Optional.
     * True, if the bot supports inline queries.
     * Returned only in {@see https://core.telegram.org/bots/api#getme getMe}.
     */
    public ?bool $supports_inline_queries = null;

    /**
     * Optional.
     * True, if the bot can be connected to a Telegram Business account to receive its messages.
     * Returned only in {@see https://core.telegram.org/bots/api#getme getMe}.
     */
    public ?bool $can_connect_to_business = null;

    /**
     * Optional.
     * True, if the bot has a main Web App.
     * Returned only in {@see https://core.telegram.org/bots/api#getme getMe}.
     */
    public ?bool $has_main_web_app = null;

    public static function make(
        int $id,
        bool $is_bot,
        string $first_name,
        ?string $last_name = null,
        ?string $username = null,
        ?string $language_code = null,
        ?bool $is_premium = null,
        ?bool $added_to_attachment_menu = null,
        ?bool $can_join_groups = null,
        ?bool $can_read_all_group_messages = null,
        ?bool $supports_inline_queries = null,
        ?bool $can_connect_to_business = null,
        ?bool $has_main_web_app = null,
    ): User {
        $user = new self();
        $user->id = $id;
        $user->is_bot = $is_bot;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->username = $username;
        $user->language_code = $language_code;
        $user->is_premium = $is_premium;
        $user->added_to_attachment_menu = $added_to_attachment_menu;
        $user->can_join_groups = $can_join_groups;
        $user->can_read_all_group_messages = $can_read_all_group_messages;
        $user->supports_inline_queries = $supports_inline_queries;
        $user->can_connect_to_business = $can_connect_to_business;
        $user->has_main_web_app = $has_main_web_app;
        return $user;
    }
}
