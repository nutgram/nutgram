<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a chat.
 * @see https://core.telegram.org/bots/api#chat
 */
class Chat extends BaseType
{
    /**
     * Unique identifier for this chat.
     * This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    public int $id;

    /** Type of the chat, can be either “private”, “group”, “supergroup” or “channel” */
    #[EnumOrScalar]
    public ChatType|string $type;

    /**
     * Optional.
     * Title, for supergroups, channels and group chats
     */
    public ?string $title = null;

    /**
     * Optional.
     * Username, for private chats, supergroups and channels if available
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
     * Optional.
     * True, if the supergroup chat is a forum (has {@see https://telegram.org/blog/topics-in-groups-collectible-usernames#topics-in-groups topics} enabled)
     */
    public ?bool $is_forum = null;

    /**
     * Optional.
     * True, if the chat is the direct messages chat of a channel
     */
    public ?bool $is_direct_messages = null;

    public static function make(
        int $id,
        ChatType|string $type,
        ?string $title = null,
        ?string $username = null,
        ?string $first_name = null,
        ?string $last_name = null,
        ?bool $is_forum = null,
        ?bool $is_direct_messages = null,
    ): Chat {
        $chat = new self();
        $chat->id = $id;
        $chat->type = $type;
        $chat->title = $title;
        $chat->username = $username;
        $chat->first_name = $first_name;
        $chat->last_name = $last_name;
        $chat->is_forum = $is_forum;
        $chat->is_direct_messages = $is_direct_messages;
        return $chat;
    }

    public function isPrivate(): bool
    {
        return $this->type === ChatType::PRIVATE;
    }

    public function isGroup(): bool
    {
        return $this->type === ChatType::GROUP;
    }

    public function isSupergroup(): bool
    {
        return $this->type === ChatType::SUPERGROUP;
    }

    public function isChannel(): bool
    {
        return $this->type === ChatType::CHANNEL;
    }
}
