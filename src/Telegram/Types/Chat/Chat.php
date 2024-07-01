<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Business\BusinessIntro;
use SergiX44\Nutgram\Telegram\Types\Business\BusinessLocation;
use SergiX44\Nutgram\Telegram\Types\Business\BusinessOpeningHours;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Reaction\ReactionType;
use SergiX44\Nutgram\Telegram\Types\User\Birthdate;

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


    /*
    |--------------------------------------------------------------------------
    | ChatFullInfo Properties
    |--------------------------------------------------------------------------
    |
    | https://core.telegram.org/bots/api#chatfullinfo
    |
    | The following properties are only returned by getChat method.
    | https://core.telegram.org/bots/api#getchat
    |
    | To not make breaking changes, we will split this class in the next major version.
    | @deprecated <= Bookmark this line for Nutgram 5.0.0
    |
    */

    /**
     * Optional.
     * Identifier of the accent color for the chat name and backgrounds of the chat photo, reply header, and link preview.
     * See {@see https://core.telegram.org/bots/api#accent-colors accent colors} for more details.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * Always returned in getChat.
     */
    public ?int $accent_color_id = null;

    /**
     * The maximum number of reactions that can be set on a message in the chat
     */
    public ?int $max_reaction_count = null;

    /**
     * Optional.
     * Chat photo.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?ChatPhoto $photo = null;

    /**
     * Optional.
     * If non-empty, the list of all {@see https://telegram.org/blog/topics-in-groups-collectible-usernames#collectible-usernames active chat usernames};
     * for private chats, supergroups and channels.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var string[] $active_usernames
     */
    public ?array $active_usernames = null;

    /**
     * Optional.
     * For private chats, the date of birth of the user.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?Birthdate $birthdate = null;

    /**
     * Optional. For private chats with business accounts, the intro of the business.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?BusinessIntro $business_intro = null;

    /**
     * Optional. For private chats with business accounts, the location of the business.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?BusinessLocation $business_location = null;

    /**
     * Optional. For private chats with business accounts, the opening hours of the business.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?BusinessOpeningHours $business_opening_hours = null;

    /**
     * Optional.
     * For private chats, the personal channel of the user.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?Chat $personal_chat = null;

    /**
     * Optional.
     * List of available reactions allowed in the chat.
     * If omitted, then all {@see https://core.telegram.org/bots/api#reactiontypeemoji emoji reactions} are allowed.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * @var ReactionType[] $available_reactions
     */
    #[ArrayType(ReactionType::class)]
    public ?array $available_reactions = null;

    /**
     * Optional.
     * Custom emoji identifier of emoji chosen by the chat for the reply header and link preview background.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?string $background_custom_emoji_id = null;

    /**
     * Optional.
     * Identifier of the accent color for the chat's profile background.
     * See {@see https://core.telegram.org/bots/api#profile-accent-colors profile accent colors} for more details.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?int $profile_accent_color_id = null;

    /**
     * Optional.
     * Custom emoji identifier of the emoji chosen by the chat for its profile background.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?string $profile_background_custom_emoji_id = null;

    /**
     * Optional.
     * Custom emoji identifier of emoji status of the other party in a private chat.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?string $emoji_status_custom_emoji_id = null;

    /**
     * Optional.
     * Expiration date of the emoji status of the other party in a private chat, if any.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?int $emoji_status_expiration_date = null;

    /**
     * Optional.
     * Bio of the other party in a private chat.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?string $bio = null;

    /**
     * Optional.
     * True, if privacy settings of the other party in the private chat allows to use tg://user?id=<user_id> links only in chats with the user.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?bool $has_private_forwards = null;

    /**
     * Optional.
     * True, if the privacy settings of the other party restrict sending voice and video note messages in the private chat.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?bool $has_restricted_voice_and_video_messages = null;

    /**
     * Optional.
     * True, if users need to join the supergroup before they can send messages.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?bool $join_to_send_messages = null;

    /**
     * Optional.
     * True, if all users directly joining the supergroup need to be approved by supergroup administrators.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?bool $join_by_request = null;

    /**
     * Optional.
     * Description, for groups, supergroups and channel chats.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?string $description = null;

    /**
     * Optional.
     * Primary invite link, for groups, supergroups and channel chats.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?string $invite_link = null;

    /**
     * Optional.
     * The most recent pinned message (by sending date).
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?Message $pinned_message = null;

    /**
     * Optional.
     * Default chat member permissions, for groups and supergroups.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?ChatPermissions $permissions = null;

    /**
     * Optional.
     * True, if paid media messages can be sent or forwarded to the channel chat.
     * The field is available only for channel chats.
     */
    public ?bool $can_send_paid_media = null;

    /**
     * Optional.
     * For supergroups, the minimum allowed delay between consecutive messages sent by each unpriviledged user;
     * in seconds.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?int $slow_mode_delay = null;

    /**
     * Optional.
     * For supergroups, the minimum number of boosts that a non-administrator user
     * needs to add in order to ignore slow mode and chat permissions.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?int $unrestrict_boost_count = null;

    /**
     * Optional.
     * The time after which all messages sent to the chat will be automatically deleted;
     * in seconds.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?int $message_auto_delete_time = null;

    /**
     * Optional.
     * True, if aggressive anti-spam checks are enabled in the supergroup.
     * The field is only available to chat administrators.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?bool $has_aggressive_anti_spam_enabled = null;

    /**
     * Optional.
     * True, if non-administrators can only get the list of bots and administrators in the chat.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?bool $has_hidden_members = null;

    /**
     * Optional.
     * True, if messages from the chat can't be forwarded to other chats.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?bool $has_protected_content = null;

    /**
     * Optional. True, if new chat members will have access to old messages; available only to chat administrators.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?bool $has_visible_history = null;

    /**
     * Optional.
     * For supergroups, name of group sticker set.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?string $sticker_set_name = null;

    /**
     * Optional.
     * True, if the bot can change the group sticker set.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?bool $can_set_sticker_set = null;

    /**
     * Optional. For supergroups, the name of the group's custom emoji sticker set.
     * Custom emoji from this set can be used by all users and bots in the group.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?string $custom_emoji_sticker_set_name = null;

    /**
     * Optional.
     * Unique identifier for the linked chat, i.e.
     * the discussion group identifier for a channel and vice versa;
     * for supergroups and channel chats.
     * This identifier may be greater than 32 bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it is smaller than 52 bits, so a signed 64 bit integer or double-precision float type are safe for storing this identifier.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?int $linked_chat_id = null;

    /**
     * Optional.
     * For supergroups, the location to which the supergroup is connected.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     */
    public ?ChatLocation $location = null;

    public static function make(
        int $id,
        ChatType|string $type,
        ?string $title = null,
        ?string $username = null,
        ?string $first_name = null,
        ?string $last_name = null,
        ?bool $is_forum = null,
        ?ChatPhoto $photo = null,
        ?array $active_usernames = null,
        ?string $emoji_status_custom_emoji_id = null,
        ?string $bio = null,
        ?bool $has_private_forwards = null,
        ?bool $has_restricted_voice_and_video_messages = null,
        ?bool $join_to_send_messages = null,
        ?bool $join_by_request = null,
        ?string $description = null,
        ?string $invite_link = null,
        ?Message $pinned_message = null,
        ?ChatPermissions $permissions = null,
        ?int $slow_mode_delay = null,
        ?int $message_auto_delete_time = null,
        ?bool $has_aggressive_anti_spam_enabled = null,
        ?bool $has_hidden_members = null,
        ?bool $has_protected_content = null,
        ?string $sticker_set_name = null,
        ?bool $can_set_sticker_set = null,
        ?int $linked_chat_id = null,
        ?ChatLocation $location = null,
        ?bool $can_send_paid_media = null,
    ): Chat {
        $chat = new self();
        $chat->id = $id;
        $chat->type = $type;
        $chat->title = $title;
        $chat->username = $username;
        $chat->first_name = $first_name;
        $chat->last_name = $last_name;
        $chat->is_forum = $is_forum;
        $chat->photo = $photo;
        $chat->active_usernames = $active_usernames;
        $chat->emoji_status_custom_emoji_id = $emoji_status_custom_emoji_id;
        $chat->bio = $bio;
        $chat->has_private_forwards = $has_private_forwards;
        $chat->has_restricted_voice_and_video_messages = $has_restricted_voice_and_video_messages;
        $chat->join_to_send_messages = $join_to_send_messages;
        $chat->join_by_request = $join_by_request;
        $chat->description = $description;
        $chat->invite_link = $invite_link;
        $chat->pinned_message = $pinned_message;
        $chat->permissions = $permissions;
        $chat->slow_mode_delay = $slow_mode_delay;
        $chat->message_auto_delete_time = $message_auto_delete_time;
        $chat->has_aggressive_anti_spam_enabled = $has_aggressive_anti_spam_enabled;
        $chat->has_hidden_members = $has_hidden_members;
        $chat->has_protected_content = $has_protected_content;
        $chat->sticker_set_name = $sticker_set_name;
        $chat->can_set_sticker_set = $can_set_sticker_set;
        $chat->linked_chat_id = $linked_chat_id;
        $chat->location = $location;
        $chat->can_send_paid_media = $can_send_paid_media;
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
