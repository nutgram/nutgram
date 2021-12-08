<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\Message\Message;

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
     */
    public int $id;

    /**
     * Type of chat, can be either “private”, “group”, “supergroup” or “channel”
     */
    public string $type;

    /**
     * Optional. Title, for supergroups, channels and group chats
     */
    public ?string $title = null;

    /**
     * Optional. Username, for private chats, supergroups and channels if available
     */
    public ?string $username = null;

    /**
     * Optional. First name of the other party in a private chat
     */
    public ?string $first_name = null;

    /**
     * Optional. Last name of the other party in a private chat
     */
    public ?string $last_name = null;

    /**
     * Optional. Chat photo.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?ChatPhoto $photo = null;

    /**
     * Optional. Bio of the other party in a private chat.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?string $bio = null;

    /**
     * Optional. True, if privacy settings of the other party in the private chat allows to use tg://user?id=<user_id>
     * links only in chats with the user. Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var bool|null
     */
    public ?bool $has_private_forwards = null;

    /**
     * Optional. Description, for groups, supergroups and channel chats.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?string $description = null;

    /**
     * Optional. Chat invite link, for groups, supergroups and channel chats.
     * Each administrator in a chat generates their own invite links, so the bot must first generate
     * the link using {@see https://core.telegram.org/bots/api#exportchatinvitelink exportChatInviteLink}.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?string $invite_link = null;

    /**
     * Optional. Pinned message, for supergroups.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?Message $pinned_message = null;

    /**
     * Optional. Default chat member permissions, for groups and supergroups.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?ChatPermissions $permissions = null;

    /**
     * Optional. For supergroups, the minimum allowed delay between
     * consecutive messages sent by each unpriviledged user.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?int $slow_mode_delay = null;

    /**
     * Optional. The time after which all messages sent to the chat will be automatically deleted; in seconds.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var int|null
     */
    public ?int $message_auto_delete_time = null;

    /**
     * Optional. True, if messages from the chat can't be forwarded to other chats.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var bool|null
     */
    public ?bool $has_protected_content = null;

    /**
     * Optional. For supergroups, name of Group sticker set.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?string $sticker_set_name = null;

    /**
     * Optional. True, if the bot can change group the sticker set.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?bool $can_set_sticker_set = null;

    /**
     * Optional. Unique identifier for the linked chat,
     * i.e. the discussion group identifier for a channel and vice versa; for supergroups and channel chats.
     * This identifier may be greater than 32 bits and some programming
     * languages may have difficulty/silent defects in interpreting it.
     * But it is smaller than 52 bits, so a signed 64 bit integer or double-precision
     * float type are safe for storing this identifier.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?int $linked_chat_id = null;

    /**
     * Optional. For supergroups, the location to which the supergroup is connected.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?ChatLocation $location = null;
}
