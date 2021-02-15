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
     * @var int
     */
    public int $id;

    /**
     * Type of chat, can be either “private”, “group”, “supergroup” or “channel”
     * @var string
     */
    public string $type;

    /**
     * Optional. Title, for supergroups, channels and group chats
     * @var string|null
     */
    public ?string $title;

    /**
     * Optional. Username, for private chats, supergroups and channels if available
     * @var string
     */
    public ?string $username;

    /**
     * Optional. First name of the other party in a private chat
     * @var string
     */
    public ?string $first_name;

    /**
     * Optional. Last name of the other party in a private chat
     * @var string
     */
    public ?string $last_name;

    /**
     * Optional. Chat photo.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var ChatPhoto
     */
    public ?ChatPhoto $photo;

    /**
     * Optional. Bio of the other party in a private chat.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var string
     */
    public ?string $bio;

    /**
     * Optional. Description, for groups, supergroups and channel chats.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var string
     */
    public ?string $description;

    /**
     * Optional. Chat invite link, for groups, supergroups and channel chats.
     * Each administrator in a chat generates their own invite links, so the bot must first generate
     * the link using {@see https://core.telegram.org/bots/api#exportchatinvitelink exportChatInviteLink}.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var string
     */
    public ?string $invite_link;

    /**
     * Optional. Pinned message, for supergroups.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var Message
     */
    public ?Message $pinned_message;

    /**
     * Optional. Default chat member permissions, for groups and supergroups.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var ChatPermissions
     */
    public ?ChatPermissions $permissions;

    /**
     * Optional. For supergroups, the minimum allowed delay between
     * consecutive messages sent by each unpriviledged user.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var int
     */
    public ?int $slow_mode_delay;

    /**
     * Optional. For supergroups, name of Group sticker set.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var string
     */
    public ?string $sticker_set_name;

    /**
     * Optional. True, if the bot can change group the sticker set.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var bool
     */
    public bool $can_set_sticker_set;

    /**
     * Optional. Unique identifier for the linked chat,
     * i.e. the discussion group identifier for a channel and vice versa; for supergroups and channel chats.
     * This identifier may be greater than 32 bits and some programming
     * languages may have difficulty/silent defects in interpreting it.
     * But it is smaller than 52 bits, so a signed 64 bit integer or double-precision
     * float type are safe for storing this identifier.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var int
     */
    public ?int $linked_chat_id;

    /**
     * Optional. For supergroups, the location to which the supergroup is connected.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var ChatLocation
     */
    public ?ChatLocation $location;
}
