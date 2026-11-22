<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\User;

use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * This object contains full information about the bot itself.
 * @see https://core.telegram.org/bots/api#botfullinfo
 */
class BotFullInfo extends BaseType
{
    /**
     * Unique identifier for this bot.
     * This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    public int $id;

    /**
     * Always True
     */
    public bool $is_bot;

    /**
     * Bot's first name
     */
    public string $first_name;

    /**
     * Optional. Bot's username
     */
    public ?string $username = null;

    /**
     * Optional. If non-empty, the list of all {@see https://telegram.org/blog/topics-in-groups-collectible-usernames#collectible-usernames active usernames} of the bot
     * @var string[]|null
     */
    public ?array $active_usernames = null;

    /**
     * True, if the bot can be added to groups
     */
    public bool $can_join_groups;

    /**
     * True, if {@see https://core.telegram.org/bots/features#privacy-mode privacy mode} is disabled for the bot
     */
    public bool $can_read_all_group_messages;

    /**
     * True, if the bot supports guest queries from chats it is not a member of
     */
    public bool $supports_guest_queries;

    /**
     * True, if the bot supports inline queries
     */
    public bool $supports_inline_queries;

    /**
     * Optional. Placeholder for inline queries, which is shown in the input field after the bot's username; omitted if the default placeholder is used
     */
    public ?string $inline_query_placeholder = null;

    /**
     * True, if the bot requests the location of the user with every inline query
     */
    public bool $needs_inline_query_location;

    /**
     * True, if the bot can be connected to a user account to manage it
     */
    public bool $can_connect_to_business;

    /**
     * True, if the bot has a main Web App
     */
    public bool $has_main_web_app;

    /**
     * True, if the bot has forum topic mode enabled in private chats
     */
    public bool $has_topics_enabled;

    /**
     * True, if the bot allows users to create and delete topics in private chats
     */
    public bool $allows_users_to_create_topics;

    /**
     * True, if topics in private chats with the bot are shown in a sidebar
     */
    public bool $has_topic_sidebar;

    /**
     * True, if other bots can be created to be controlled by the bot
     */
    public bool $can_manage_bots;

    /**
     * True, if the bot supports join request queries and can be assigned to process them
     */
    public bool $supports_join_request_queries;
}
