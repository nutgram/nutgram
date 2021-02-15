<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a chat.
 * @see https://core.telegram.org/bots/api#chat
 */
class Chat
{
    /**
     * Unique identifier for this chat.
     * This number may be greater than 32 bits and some programming languages
     * may have difficulty/silent defects in interpreting it.
     * But it is smaller than 52 bits, so a signed 64 bit integer or
     * double-precision float type are safe for storing this identifier.
     * @var int $id
     */
    public $id;

    /**
     * Type of chat, can be either “private”, “group”, “supergroup” or “channel”
     * @var string $type
     */
    public $type;

    /**
     * Optional. Title, for supergroups, channels and group chats
     * @var string $title
     */
    public $title;

    /**
     * Optional. Username, for private chats, supergroups and channels if available
     * @var string $username
     */
    public $username;

    /**
     * Optional. First name of the other party in a private chat
     * @var string $first_name
     */
    public $first_name;

    /**
     * Optional. Last name of the other party in a private chat
     * @var string $last_name
     */
    public $last_name;

    /**
     * Optional. Chat photo.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var ChatPhoto $photo
     */
    public $photo;

    /**
     * Optional. Bio of the other party in a private chat.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var string $bio
     */
    public $bio;

    /**
     * Optional. Description, for groups, supergroups and channel chats.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var string $description
     */
    public $description;

    /**
     * Optional. Chat invite link, for groups, supergroups and channel chats.
     * Each administrator in a chat generates their own invite links, so the bot must first generate
     * the link using {@see https://core.telegram.org/bots/api#exportchatinvitelink exportChatInviteLink}.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var string $invite_link
     */
    public $invite_link;

    /**
     * Optional. Pinned message, for supergroups.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var Message $pinned_message
     */
    public $pinned_message;

    /**
     * Optional. Default chat member permissions, for groups and supergroups.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var ChatPermissions $permissions
     */
    public $permissions;

    /**
     * Optional. For supergroups, the minimum allowed delay between
     * consecutive messages sent by each unpriviledged user.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var int $slow_mode_delay
     */
    public $slow_mode_delay;

    /**
     * Optional. For supergroups, name of Group sticker set.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var string $sticker_set_name
     */
    public $sticker_set_name;

    /**
     * Optional. True, if the bot can change group the sticker set.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var bool $can_set_sticker_set
     */
    public $can_set_sticker_set;

    /**
     * Optional. Unique identifier for the linked chat,
     * i.e. the discussion group identifier for a channel and vice versa; for supergroups and channel chats.
     * This identifier may be greater than 32 bits and some programming
     * languages may have difficulty/silent defects in interpreting it.
     * But it is smaller than 52 bits, so a signed 64 bit integer or double-precision
     * float type are safe for storing this identifier.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var int $linked_chat_id
     */
    public $linked_chat_id;

    /**
     * Optional. For supergroups, the location to which the supergroup is connected.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var ChatLocation $location
     */
    public $location;
}
