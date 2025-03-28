<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Properties\ChatType;
use SergiX44\Nutgram\Telegram\Types\Business\BusinessIntro;
use SergiX44\Nutgram\Telegram\Types\Business\BusinessLocation;
use SergiX44\Nutgram\Telegram\Types\Business\BusinessOpeningHours;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Reaction\ReactionType;
use SergiX44\Nutgram\Telegram\Types\User\Birthdate;

/**
 * This object contains full information about a chat.
 * @see https://core.telegram.org/bots/api#chatfullinfo
 */
class ChatFullInfo extends Chat
{
    /**
     * Identifier of the accent color for the chat name and backgrounds of the chat photo, reply header, and link preview.
     * See {@see https://core.telegram.org/bots/api#accent-colors accent colors} for more details.
     * Returned only in {@see https://core.telegram.org/bots/api#getchat getChat}.
     * Always returned in getChat.
     */
    public int $accent_color_id;

    /**
     * The maximum number of reactions that can be set on a message in the chat
     */
    public int $max_reaction_count;

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
     * True, if gifts can be sent to the chat
     */
    public ?bool $can_send_gift = null;

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

}
